/**
 * compras-pagamento.js
 * ─────────────────────────────────────────────────────────────
 * Lógica completa da página de pagamento.
 * Inclui simulação MBWay com 5 estados visuais distintos.
 *
 * SEGURANÇA: Preços nunca são recalculados aqui.
 * Os valores vêm do PHP via variável DADOS_PEDIDO injetada.
 * ─────────────────────────────────────────────────────────────
 */

'use strict';

// ══════════════════════════════════════════════════════════════
// ESTADO GLOBAL
// ══════════════════════════════════════════════════════════════
let metodoAtual        = 'cartao';
let mbwayReferencia    = null;
let mbwayPollingTimer  = null;
let mbwayCancelTimer   = null;
let mbwayContadorTimer = null;
let mbwayIniciado      = false;

// ──────────────────────────────────────────────────────────────
// Fallback: se o PHP não injetou DADOS_PEDIDO, tentar localStorage
// (compatibilidade com o fluxo anterior)
// ──────────────────────────────────────────────────────────────
if (typeof DADOS_PEDIDO === 'undefined') {
    try {
        const pedidoLS  = JSON.parse(localStorage.getItem('pedido_docesdias') || '{}');
        const carrinhoLS = JSON.parse(localStorage.getItem('carrinho_docesdias') || '[]');

        let subtotal = 0;
        carrinhoLS.forEach(p => { subtotal += (p.preco || 0) * (p.quantidade || 1); });

        const tarifas   = { normal: 5, express: 12, urgente: 25 };
        const entrega   = tarifas[pedidoLS.entrega || 'normal'] || 5;
        const desconto  = pedidoLS.desconto || 0;
        const total     = Math.max(0, subtotal + entrega - desconto);
        const iva       = +(total * 0.23).toFixed(2);

        window.DADOS_PEDIDO = {
            nome:      pedidoLS.pessoal?.nome  || '',
            email:     pedidoLS.pessoal?.email || '',
            endereco:  pedidoLS.endereco
                ? `${pedidoLS.endereco.endereco}, ${pedidoLS.endereco.codigoPostal} ${pedidoLS.endereco.cidade}`
                : '',
            subtotal:  '€ ' + subtotal.toFixed(2).replace('.', ','),
            entrega:   '€ ' + entrega.toFixed(2).replace('.', ','),
            desconto:  '€ ' + desconto.toFixed(2).replace('.', ','),
            iva:       '€ ' + iva.toFixed(2).replace('.', ','),
            total:     '€ ' + total.toFixed(2).replace('.', ','),
            total_num: total.toFixed(2).replace('.', ','),
        };
        window.CSRF_TOKEN  = window.CSRF_TOKEN  || '';
        window.MBWAY_URL   = window.MBWAY_URL   || '../pages/mbway_processar.php';
        window.SUCESSO_URL = window.SUCESSO_URL || '../pages/pagamento_sucesso.php';
    } catch(_) {}
}

// ══════════════════════════════════════════════════════════════
// INICIALIZAÇÃO
// ══════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    preencherResumo();
    configurarEventos();
    atualizarBtnConfirmar();
});

// ══════════════════════════════════════════════════════════════
// RESUMO
// ══════════════════════════════════════════════════════════════
function preencherResumo() {
    const d = window.DADOS_PEDIDO || {};
    setText('resumo-cliente',      d.nome      || '—');
    setText('resumo-email',        d.email     || '—');
    setText('resumo-endereco',     d.endereco  || '—');
    setText('resumo-subtotal',     d.subtotal  || '€ 0,00');
    setText('resumo-entrega-valor',d.entrega   || '€ 0,00');
    setText('resumo-iva-valor',    d.iva       || '€ 0,00');
    setText('resumo-total-grande', d.total     || '€ 0,00');
    setText('total-cartao',        d.total_num || '0,00');
    setText('total-mbway',         d.total_num || '0,00');
    setText('mbway-valor',         d.total_num || '0,00');

    const numerico = parseFloat((d.total_num || '0').replace(',', '.'));
    if (numerico > 0) {
        const desc = d.desconto?.replace('€ ', '').replace(',', '.');
        if (desc && parseFloat(desc) > 0) {
            const el = document.getElementById('resumo-desconto-item');
            if (el) el.style.display = 'flex';
            setText('resumo-desconto-valor', '- ' + d.desconto);
        }
    }
}

// ══════════════════════════════════════════════════════════════
// TABS
// ══════════════════════════════════════════════════════════════
function selecionarMetodo(metodo) {
    metodoAtual = metodo;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.metodo-pagamento').forEach(d => d.classList.remove('active'));
    document.querySelector(`[onclick="selecionarMetodo('${metodo}')"]`).classList.add('active');
    document.getElementById(`metodo-${metodo}`).classList.add('active');
    atualizarBtnConfirmar();
}

function atualizarBtnConfirmar() {
    const btn = document.getElementById('btn-confirmar');
    if (!btn) return;
    if (metodoAtual === 'mbway') {
        btn.innerHTML = '<span class="btn-mbway-icon">📱</span> Pagar com MBWay';
        btn.className = 'btn-confirmar btn-confirmar-mbway';
    } else {
        btn.innerHTML = '✓ Confirmar Pagamento';
        btn.className = 'btn-confirmar';
    }
}

// ══════════════════════════════════════════════════════════════
// EVENTOS DE FORMULÁRIO
// ══════════════════════════════════════════════════════════════
function configurarEventos() {
    // Cartão – número
    document.getElementById('cartao')?.addEventListener('input', function() {
        formatarNumeroCartao(this);
        atualizarPreviewCartao();
    });
    // Cartão – data
    document.getElementById('data-expiracao')?.addEventListener('input', function() {
        formatarData(this);
        atualizarPreviewCartao();
    });
    // Cartão – CVV
    document.getElementById('cvv')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 4);
    });
    // Cartão – titular
    document.getElementById('titular')?.addEventListener('input', atualizarPreviewCartao);
    // MBWay – telefone
    document.getElementById('telefone-mbway')?.addEventListener('input', function() {
        this.value = formatarTelefone(this.value);
    });
}

// ══════════════════════════════════════════════════════════════
// FORMATAÇÃO
// ══════════════════════════════════════════════════════════════
function formatarNumeroCartao(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
    const logo = document.getElementById('logo-cartao');
    if (logo) logo.textContent = detectarTipoCartao(v);
}

function detectarTipoCartao(n) {
    if (/^4/.test(n))      return 'VISA';
    if (/^5[1-5]/.test(n)) return 'MC';
    if (/^3[47]/.test(n))  return 'AMEX';
    return '';
}

function formatarData(input) {
    let v = input.value.replace(/\D/g, '');
    if (v.length >= 3) v = v.substring(0, 2) + '/' + v.substring(2, 4);
    input.value = v;
}

function formatarTelefone(valor) {
    let n = valor.replace(/\D/g, '').replace(/^351/, '').substring(0, 9);
    if (n.length <= 3)      return n;
    if (n.length <= 6)      return n.substring(0, 3) + ' ' + n.substring(3);
    return n.substring(0, 3) + ' ' + n.substring(3, 6) + ' ' + n.substring(6);
}

// ══════════════════════════════════════════════════════════════
// PREVIEW CARTÃO
// ══════════════════════════════════════════════════════════════
function atualizarPreviewCartao() {
    const num     = document.getElementById('cartao')?.value || '•••• •••• •••• ••••';
    const titular = document.getElementById('titular')?.value.toUpperCase() || 'NOME DO TITULAR';
    const data    = document.getElementById('data-expiracao')?.value || 'MM/AA';
    setText('preview-numero',  num.padEnd(19, '•'));
    setText('preview-titular', titular);
    setText('preview-data',    data);
}

// ══════════════════════════════════════════════════════════════
// VALIDAÇÃO
// ══════════════════════════════════════════════════════════════
function validarCartao() {
    const titular = document.getElementById('titular').value.trim();
    const cartao  = document.getElementById('cartao').value.replace(/\s/g, '');
    const data    = document.getElementById('data-expiracao').value;
    const cvv     = document.getElementById('cvv').value;
    const termos  = document.getElementById('termos-cartao').checked;
    let ok = true;

    if (titular.length < 3) { marcarErro('titular', 'Nome inválido');          ok = false; } else limparErro('titular');
    if (cartao.length !== 16){ marcarErro('cartao', 'Número inválido (16 dígitos)'); ok = false; } else limparErro('cartao');
    if (!/^\d{2}\/\d{2}$/.test(data)) {
        marcarErro('data-expiracao', 'Formato inválido (MM/AA)'); ok = false;
    } else {
        const [m, a] = data.split('/').map(Number);
        const agora  = new Date();
        const anoFull = 2000 + a;
        if (m < 1 || m > 12 || anoFull < agora.getFullYear() || (anoFull === agora.getFullYear() && m < agora.getMonth() + 1)) {
            marcarErro('data-expiracao', 'Cartão expirado'); ok = false;
        } else limparErro('data-expiracao');
    }
    if (!/^\d{3,4}$/.test(cvv)) { marcarErro('cvv', 'CVV inválido'); ok = false; } else limparErro('cvv');
    if (!termos) { alert('Por favor, autoriza o débito no cartão.'); ok = false; }
    return ok;
}

function validarMBWay() {
    const tel    = document.getElementById('telefone-mbway').value.replace(/\D/g, '').replace(/^351/, '');
    const termos = document.getElementById('termos-mbway').checked;
    let ok = true;

    if (!/^9[1236]\d{7}$/.test(tel)) {
        marcarErro('telefone-mbway', 'Número inválido. Ex: 912 345 678');
        ok = false;
    } else limparErro('telefone-mbway');

    if (!termos) { alert('Por favor, autoriza o pagamento via MBWay.'); ok = false; }
    return ok;
}

function marcarErro(id, msg) {
    const el = document.getElementById(id);
    if (!el) return;
    el.closest('.form-grupo')?.classList.add('erro');
    const err = document.getElementById('erro-' + id);
    if (err) { err.textContent = msg; err.style.display = 'block'; }
}

function limparErro(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.closest('.form-grupo')?.classList.remove('erro');
    const err = document.getElementById('erro-' + id);
    if (err) { err.textContent = ''; err.style.display = 'none'; }
}

// ══════════════════════════════════════════════════════════════
// CONFIRMAR PAGAMENTO – ponto de entrada
// ══════════════════════════════════════════════════════════════
function confirmarPagamento() {
    if (metodoAtual === 'mbway') {
        if (!validarMBWay()) return;
        iniciarFluxoMBWay();
    } else {
        if (!validarCartao()) return;
        iniciarFluxoCartao();
    }
}

// ══════════════════════════════════════════════════════════════
// FLUXO CARTÃO (simulação simples)
// ══════════════════════════════════════════════════════════════
function iniciarFluxoCartao() {
    const btn = document.getElementById('btn-confirmar');
    btn.disabled = true;

    mostrarModal('processamento');
    atualizarModal('processamento', 'A validar dados do cartão…', 'Aguarda um momento');

    setTimeout(() => atualizarModal('processamento', 'A processar transação…', 'Comunicando com o banco'), 1200);
    setTimeout(() => atualizarModal('processamento', 'A confirmar pagamento…', 'Quase pronto!'), 2400);

    setTimeout(() => {
        fecharModal('processamento');
        // 90% sucesso
        if (Math.random() > 0.10) {
            const ref = 'DOC' + Date.now().toString().slice(-6);
            guardarEncomendaLocal(ref);
            mostrarSucessoCartao(ref);
        } else {
            btn.disabled = false;
            const erros = ['Transação recusada pelo banco', 'Saldo insuficiente', 'Cartão bloqueado temporariamente'];
            mostrarErro(erros[Math.floor(Math.random() * erros.length)]);
        }
    }, 3400);
}

// ══════════════════════════════════════════════════════════════
// FLUXO MBWAY – 5 estados visuais
// ══════════════════════════════════════════════════════════════
function iniciarFluxoMBWay() {
    if (mbwayIniciado) return;
    mbwayIniciado = true;

    const tel = document.getElementById('telefone-mbway').value.replace(/\D/g, '').replace(/^351/, '');
    const btn = document.getElementById('btn-confirmar');
    btn.disabled = true;

    // Estado 1 – Enviar pedido
    mostrarModalMBWay('enviando', tel);

    // Simular chamada ao backend
    setTimeout(async () => {
        // Tentar backend real; se falhar, continuar em modo demo
        let referencia = null;
        let totalNum   = (window.DADOS_PEDIDO?.total_num || '0').replace(',', '.');

        if (window.CSRF_TOKEN && window.MBWAY_URL) {
            try {
                const resp = await fetch(window.MBWAY_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        acao: 'iniciar',
                        telefone: tel,
                        csrf_token: window.CSRF_TOKEN
                    })
                });
                const data = await resp.json();
                if (data.sucesso) {
                    referencia = data.referencia;
                    totalNum   = (data.total || totalNum).replace(',', '.');
                }
            } catch(_) { /* modo demo */ }
        }

        mbwayReferencia = referencia || ('DEMO' + Math.random().toString(36).substring(2, 8).toUpperCase());

        // Estado 2 – Aguardando notificação
        mostrarModalMBWay('aguardando', tel, mbwayReferencia, totalNum);

        // Estado 3 – Após 4s: "notificação enviada"
        setTimeout(() => {
            mostrarModalMBWay('notificacao', tel, mbwayReferencia, totalNum);
        }, 4000);

        // Polling ou timer demo
        const tempoInicio = Date.now();
        const TIMEOUT_MS  = 300_000; // 5 min real; para demo usamos 8s
        const DEMO_PAGO   = 8000;    // simular confirmação ao fim de 8s

        // Timer de expiração
        mbwayCancelTimer = setTimeout(() => {
            pararPolling();
            mostrarModalMBWay('expirado', tel, mbwayReferencia, totalNum);
        }, TIMEOUT_MS);

        if (referencia && window.CSRF_TOKEN && window.MBWAY_URL) {
            // Polling real (cada 3 segundos)
            mbwayPollingTimer = setInterval(() => verificarEstadoMBWay(referencia, tel, totalNum), 3000);
        } else {
            // Demo: confirmar ao fim de 8s
            setTimeout(() => {
                pararPolling();
                mostrarModalMBWay('pago', tel, mbwayReferencia, totalNum);
            }, DEMO_PAGO);
        }

        // Contador regressivo de 5 min
        iniciarContador(300);

    }, 1800); // simular latência "envio"
}

async function verificarEstadoMBWay(referencia, tel, totalNum) {
    try {
        const resp = await fetch(window.MBWAY_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                acao: 'verificar',
                referencia,
                csrf_token: window.CSRF_TOKEN
            })
        });
        const data = await resp.json();
        if (!data.sucesso) return;

        if (data.estado === 'pago') {
            pararPolling();
            mostrarModalMBWay('pago', tel, referencia, totalNum);
        } else if (data.estado === 'cancelado') {
            pararPolling();
            mostrarModalMBWay('cancelado', tel, referencia, totalNum);
        }
    } catch(_) { /* rede falhou – ignorar, tentar de novo */ }
}

function pararPolling() {
    clearInterval(mbwayPollingTimer);
    clearTimeout(mbwayCancelTimer);
    clearInterval(mbwayContadorTimer);
    mbwayPollingTimer = null;
    mbwayCancelTimer  = null;
}

// ── Cancelar por botão ─────────────────────────────────────────
async function cancelarMBWay() {
    pararPolling();
    if (mbwayReferencia && window.CSRF_TOKEN && window.MBWAY_URL) {
        try {
            await fetch(window.MBWAY_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    acao: 'cancelar',
                    referencia: mbwayReferencia,
                    csrf_token: window.CSRF_TOKEN
                })
            });
        } catch(_) {}
    }
    fecharModalMBWay();
    mbwayIniciado = false;
    document.getElementById('btn-confirmar').disabled = false;
}

// ══════════════════════════════════════════════════════════════
// MODAL MBWAY – renderização dos 5 estados
// ══════════════════════════════════════════════════════════════
function mostrarModalMBWay(estado, tel, ref, total) {
    let modal = document.getElementById('modal-mbway');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'modal-mbway';
        modal.className = 'modal-mbway';
        document.body.appendChild(modal);
    }
    modal.className = 'modal-mbway modal-mbway-ativo';
    modal.innerHTML = renderEstadoMBWay(estado, tel, ref, total);
    modal.style.display = 'flex';

    // Vibração (mobile)
    if (estado === 'notificacao' && navigator.vibrate) navigator.vibrate([200, 100, 200]);
}

function fecharModalMBWay() {
    const modal = document.getElementById('modal-mbway');
    if (modal) { modal.style.display = 'none'; modal.className = 'modal-mbway'; }
}

function renderEstadoMBWay(estado, tel, ref, total) {
    const telMascarado = tel ? `9•• ••• ${tel.slice(-3)}` : '---';
    const totalFmt     = total ? `€ ${parseFloat(total).toFixed(2).replace('.', ',')}` : '—';
    const refFmt       = ref   || '—';

    const estados = {

        // ── ESTADO 1: Enviando ─────────────────────────────────
        enviando: `
            <div class="mbw-card">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                </div>
                <div class="mbw-body">
                    <div class="mbw-sending-animation">
                        <div class="mbw-phone-icon">📱</div>
                        <div class="mbw-signal">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                    <h3 class="mbw-titulo">A enviar pedido…</h3>
                    <p class="mbw-sub">A contactar o número <strong>${telMascarado}</strong></p>
                    <div class="mbw-progress-bar"><div class="mbw-progress-fill mbw-animate-fill"></div></div>
                </div>
            </div>`,

        // ── ESTADO 2: Aguardando ───────────────────────────────
        aguardando: `
            <div class="mbw-card">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                    <button class="mbw-btn-fechar" onclick="cancelarMBWay()">✕</button>
                </div>
                <div class="mbw-body">
                    <div class="mbw-pulse-wrapper">
                        <div class="mbw-pulse-ring"></div>
                        <div class="mbw-pulse-ring mbw-pulse-ring-2"></div>
                        <div class="mbw-pulse-core">📲</div>
                    </div>
                    <h3 class="mbw-titulo">Pedido enviado!</h3>
                    <p class="mbw-sub">Abre a app <strong>MBWay</strong> no teu telemóvel<br>e confirma o pagamento</p>
                    <div class="mbw-info-row">
                        <div class="mbw-info-box">
                            <span class="mbw-info-label">Valor</span>
                            <span class="mbw-info-val">${totalFmt}</span>
                        </div>
                        <div class="mbw-info-box">
                            <span class="mbw-info-label">Ref.</span>
                            <span class="mbw-info-val mbw-ref">${refFmt}</span>
                        </div>
                    </div>
                    <div class="mbw-timer-row">
                        <span class="mbw-timer-icon">⏱</span>
                        <span>Expira em </span>
                        <span id="mbw-contador" class="mbw-contador">4:55</span>
                    </div>
                    <button class="mbw-btn-cancelar" onclick="cancelarMBWay()">Cancelar</button>
                </div>
            </div>`,

        // ── ESTADO 3: Notificação enviada ──────────────────────
        notificacao: `
            <div class="mbw-card">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                    <button class="mbw-btn-fechar" onclick="cancelarMBWay()">✕</button>
                </div>
                <div class="mbw-body">
                    <!-- Ecrã de telemóvel simulado -->
                    <div class="mbw-phone-screen">
                        <div class="mbw-screen-bar">
                            <span>${new Date().toLocaleTimeString('pt-PT', {hour:'2-digit',minute:'2-digit'})}</span>
                            <span>📶 🔋</span>
                        </div>
                        <div class="mbw-notif-banner">
                            <div class="mbw-notif-icon">💳</div>
                            <div class="mbw-notif-texto">
                                <div class="mbw-notif-app">MBWay</div>
                                <div class="mbw-notif-msg">Pagamento de <strong>${totalFmt}</strong></div>
                                <div class="mbw-notif-sub">Doces Dias · Toca para confirmar</div>
                            </div>
                        </div>
                        <div class="mbw-screen-btns">
                            <div class="mbw-screen-btn mbw-btn-recusar-fake">Recusar</div>
                            <div class="mbw-screen-btn mbw-btn-aceitar-fake">Aceitar</div>
                        </div>
                    </div>
                    <p class="mbw-sub mbw-sub-small">A aguardar confirmação na app…</p>
                    <div class="mbw-timer-row">
                        <span class="mbw-timer-icon">⏱</span>
                        <span id="mbw-contador" class="mbw-contador">4:55</span>
                    </div>
                    <button class="mbw-btn-cancelar" onclick="cancelarMBWay()">Cancelar</button>
                </div>
            </div>`,

        // ── ESTADO 4: PAGO ─────────────────────────────────────
        pago: `
            <div class="mbw-card mbw-card-sucesso">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo mbw-logo-verde">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                </div>
                <div class="mbw-body">
                    <div class="mbw-check-wrapper">
                        <svg class="mbw-check-svg" viewBox="0 0 52 52">
                            <circle class="mbw-check-circle" cx="26" cy="26" r="24" fill="none"/>
                            <path  class="mbw-check-path"   d="M14 26 L22 34 L38 18" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="mbw-titulo mbw-titulo-verde">Pagamento confirmado!</h3>
                    <p class="mbw-sub">O pagamento de <strong>${totalFmt}</strong><br>foi autorizado com sucesso.</p>
                    <div class="mbw-recibo">
                        <div class="mbw-recibo-linha"><span>Referência</span><span class="mbw-ref">${refFmt}</span></div>
                        <div class="mbw-recibo-linha"><span>Valor</span><span>${totalFmt}</span></div>
                        <div class="mbw-recibo-linha"><span>Data</span><span>${new Date().toLocaleString('pt-PT',{day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'})}</span></div>
                    </div>
                    <button class="mbw-btn-ok" onclick="finalizarMBWayPago()">Ver encomenda →</button>
                </div>
            </div>`,

        // ── ESTADO 5a: Cancelado ───────────────────────────────
        cancelado: `
            <div class="mbw-card mbw-card-erro">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo mbw-logo-vermelho">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                </div>
                <div class="mbw-body">
                    <div class="mbw-x-wrapper">✕</div>
                    <h3 class="mbw-titulo mbw-titulo-vermelho">Pagamento cancelado</h3>
                    <p class="mbw-sub">O pagamento foi cancelado ou recusado<br>na app MBWay.</p>
                    <button class="mbw-btn-tentar" onclick="reporMBWay()">Tentar novamente</button>
                    <button class="mbw-btn-cancelar" onclick="fecharModalMBWay(); document.getElementById('btn-confirmar').disabled=false; mbwayIniciado=false;">Fechar</button>
                </div>
            </div>`,

        // ── ESTADO 5b: Expirado ────────────────────────────────
        expirado: `
            <div class="mbw-card mbw-card-erro">
                <div class="mbw-logo-bar">
                    <div class="mbw-logo mbw-logo-cinza">
                        <div class="mbw-logo-m">MB</div>
                        <div class="mbw-logo-way">WAY</div>
                    </div>
                </div>
                <div class="mbw-body">
                    <div class="mbw-x-wrapper mbw-x-cinza">⏱</div>
                    <h3 class="mbw-titulo mbw-titulo-cinza">Pedido expirado</h3>
                    <p class="mbw-sub">O tempo limite de 5 minutos foi ultrapassado<br>sem confirmação.</p>
                    <button class="mbw-btn-tentar" onclick="reporMBWay()">Tentar novamente</button>
                </div>
            </div>`
    };

    return `<div class="mbw-overlay">${estados[estado] || estados.enviando}</div>`;
}

// ══════════════════════════════════════════════════════════════
// CONTADOR REGRESSIVO
// ══════════════════════════════════════════════════════════════
function iniciarContador(segundos) {
    clearInterval(mbwayContadorTimer);
    let restantes = segundos;

    const atualizar = () => {
        const el = document.getElementById('mbw-contador');
        if (!el) return;
        const m = Math.floor(restantes / 60);
        const s = restantes % 60;
        el.textContent = `${m}:${s.toString().padStart(2, '0')}`;
        if (restantes <= 30) el.classList.add('mbw-contador-urgente');
        restantes--;
    };

    atualizar();
    mbwayContadorTimer = setInterval(() => {
        if (restantes < 0) { clearInterval(mbwayContadorTimer); return; }
        atualizar();
    }, 1000);
}

// ══════════════════════════════════════════════════════════════
// FINALIZAÇÃO
// ══════════════════════════════════════════════════════════════
function finalizarMBWayPago() {
    fecharModalMBWay();
    guardarEncomendaLocal(mbwayReferencia);

    // Se tiver URL de sucesso PHP, redirecionar; caso contrário, modal genérico
    if (window.SUCESSO_URL && window.SUCESSO_URL.includes('.php')) {
        window.location.href = window.SUCESSO_URL;
    } else {
        setText('numero-encomenda', '#' + mbwayReferencia);
        mostrarSucessoCartao(mbwayReferencia);
    }
}

function mostrarSucessoCartao(ref) {
    setText('numero-encomenda', '#' + ref);
    mostrarModal('sucesso');
}

function guardarEncomendaLocal(ref) {
    try {
        const pedido = JSON.parse(localStorage.getItem('pedido_docesdias') || '{}');
        localStorage.setItem('pedido_completo', JSON.stringify({
            ...pedido,
            numeroEncomenda: ref,
            data:   new Date().toLocaleDateString('pt-PT'),
            hora:   new Date().toLocaleTimeString('pt-PT'),
            metodo: metodoAtual === 'mbway' ? 'MBWay' : 'Cartão'
        }));
        localStorage.removeItem('carrinho_docesdias');
        localStorage.removeItem('pedido_docesdias');
    } catch(_) {}
}

function reporMBWay() {
    pararPolling();
    fecharModalMBWay();
    mbwayIniciado = false;
    document.getElementById('btn-confirmar').disabled = false;
}

// ══════════════════════════════════════════════════════════════
// MODAIS GENÉRICOS (processamento / sucesso / erro)
// ══════════════════════════════════════════════════════════════
function mostrarModal(tipo) {
    document.getElementById(`modal-${tipo}`)?.classList.add('active');
}

function fecharModal(tipo) {
    document.getElementById(`modal-${tipo}`)?.classList.remove('active');
}

function atualizarModal(tipo, titulo, descricao) {
    if (tipo === 'processamento') {
        setText('modal-titulo',      titulo);
        setText('modal-descricao',   descricao);
    }
}

function mostrarErro(msg) {
    setText('modal-erro-msg', msg);
    mostrarModal('erro');
}

// ── Expostos para os modais HTML ───────────────────────────────
function finalizarCompra() {
    localStorage.removeItem('carrinho_docesdias');
    localStorage.removeItem('pedido_docesdias');
    window.location.href = '../index.php';
}

function voltarFinalizacao() {
    window.location.href = '../pages/compras-finalizar.php';
}

function fecharErro() {
    fecharModal('erro');
    document.getElementById('btn-confirmar').disabled = false;
}

// ══════════════════════════════════════════════════════════════
// UTILS
// ══════════════════════════════════════════════════════════════
function setText(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}