// =============================================
// ENCOMENDA-CUPCAKES.JS (Versão Dinâmica)
// =============================================

// ===== VALIDAÇÃO DE DATA (mínimo 7 dias) =====
function inicializarData() {
    const dataInput = document.getElementById('birthday');
    if (!dataInput) return;

    const hoje = new Date();
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    dataInput.min = dataMinima.toISOString().split('T')[0];

    dataInput.addEventListener('change', atualizarResumo);
}

// ===== ATUALIZAR RESUMO EM TEMPO REAL =====
function atualizarResumo() {
    const selectTamanho = document.getElementById('tamanho');
    const dataEl        = document.getElementById('birthday');
    const obsEl         = document.getElementById('observacoes');
    const resumoContent = document.getElementById('resumo-content');

    if (!resumoContent) return;

    // Se não selecionou tamanho ou data, mostra vazio
    if (!selectTamanho?.value || !dataEl?.value) {
        resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        return;
    }

    // --- LÓGICA DINÂMICA ---
    // 1. Pega o texto todo da opção (ex: "Tamanho Familiar - €40")
    const textoCompleto = selectTamanho.options[selectTamanho.selectedIndex].text;
    
    // 2. Separa o Nome do Preço usando o hífen " - "
    const partes = textoCompleto.split(' - ');
    const labelSelecionada = partes[0]; // "Tamanho Familiar"
    
    // 3. Extrai o número do preço (procura o que está depois do €)
    const precoMatch = textoCompleto.match(/€(\d+)/);
    const precoFinal = precoMatch ? parseFloat(precoMatch[1]) : 0;

    const dataFormatada = new Date(dataEl.value + 'T00:00:00').toLocaleDateString('pt-PT');

    let html = '';
    html += '<div class="resumo-item">';
    html += '<h3>Detalhes da Encomenda</h3>';
    html += `<p><strong>Opção:</strong> ${labelSelecionada}</p>`;
    html += `<p><strong>Data:</strong> ${dataFormatada}</p>`;
    html += '</div>';

    if (obsEl?.value.trim()) {
        html += '<div class="resumo-item">';
        html += '<h3>Observações</h3>';
        html += `<p>${obsEl.value.trim()}</p>`;
        html += '</div>';
    }

    // Mostra o Total calculado dinamicamente
    html += `<div class="resumo-total">Total estimado: €${precoFinal.toFixed(2)}</div>`;

    resumoContent.innerHTML = html;
}

// ===== LIMPAR PEDIDO =====
function inicializarLimpar() {
    const btnLimpar = document.getElementById('btn-limpar-pedido');
    if (!btnLimpar) return;

    btnLimpar.addEventListener('click', function () {
        if (!confirm('Tem a certeza que quer limpar todos os campos?')) return;
        document.querySelector('form')?.reset();
        atualizarResumo();
    });
}

// ===== LISTENERS =====
function inicializarListeners() {
    const ids = ['tamanho', 'birthday', 'observacoes'];
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', atualizarResumo);
            el.addEventListener('input', atualizarResumo);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    inicializarData();
    inicializarLimpar();
    inicializarListeners();
});