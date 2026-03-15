// compras-pagamento.js - Doces Dias Payment Processing

// Dados Globais
let pedidoData = {};
let carrinhoData = [];
let metodoAtual = 'cartao';

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    carregarDados();
    inicializarEventos();
    atualizarResumo();
});

// ========== CARREGAR DADOS ==========
function carregarDados() {
    // Carregar pedido (vem da página anterior)
    const pedido = localStorage.getItem('pedido_docesdias');
    if (pedido) {
        pedidoData = JSON.parse(pedido);
    } else {
        window.location.href = '../pages/compras-finalizar.php';
        return;
    }

    // Carregar carrinho
    const carrinho = localStorage.getItem('carrinho_docesdias');
    if (carrinho) {
        carrinhoData = JSON.parse(carrinho);
    }

    // Preencher resumo
    preencherResumo();
}

function preencherResumo() {
    document.getElementById('resumo-cliente').textContent = pedidoData.pessoal?.nome || '-';
    document.getElementById('resumo-email').textContent = pedidoData.pessoal?.email || '-';

    const endereco = pedidoData.endereco;
    if (endereco) {
        const enderecoTexto = `${endereco.endereco}, ${endereco.codigoPostal} ${endereco.cidade}`;
        document.getElementById('resumo-endereco').textContent = enderecoTexto;
    }

    // Calcular totais
    const subtotal = calcularSubtotal();
    const entrega = calcularEntrega();
    const desconto = pedidoData.desconto || 0;
    const iva = (subtotal + entrega - desconto) * 0.23;
    const total = subtotal + entrega - desconto + iva;

    document.getElementById('resumo-subtotal').textContent = '€ ' + subtotal.toFixed(2);
    document.getElementById('resumo-entrega-valor').textContent = '€ ' + entrega.toFixed(2);
    document.getElementById('resumo-iva-valor').textContent = '€ ' + iva.toFixed(2);
    document.getElementById('resumo-total-grande').textContent = '€ ' + total.toFixed(2);

    // Mostrar desconto se houver
    if (desconto > 0) {
        document.getElementById('resumo-desconto-item').style.display = 'flex';
        document.getElementById('resumo-desconto-valor').textContent = '- € ' + desconto.toFixed(2);
    }

    // Atualizar totais nos formulários
    document.getElementById('total-cartao').textContent = total.toFixed(2);
    document.getElementById('total-mbway').textContent = total.toFixed(2);
    document.getElementById('mbway-valor').textContent = total.toFixed(2);
}

function calcularSubtotal() {
    let subtotal = 0;
    if (carrinhoData && Array.isArray(carrinhoData)) {
        carrinhoData.forEach(produto => {
            subtotal += produto.preco * produto.quantidade;
        });
    }
    return subtotal;
}

function calcularEntrega() {
    const tipoEntrega = pedidoData.entrega || 'normal';
    const tarifas = {
        'normal': 5.00,
        'express': 12.00,
        'urgente': 25.00
    };
    return tarifas[tipoEntrega] || 5.00;
}

function atualizarResumo() {
    preencherResumo();
}

// ========== SELEÇÃO DE MÉTODOS ==========
function selecionarMetodo(metodo) {
    metodoAtual = metodo;

    // Atualizar abas
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Mostrar método correto
    document.querySelectorAll('.metodo-pagamento').forEach(div => div.classList.remove('active'));
    document.getElementById('metodo-' + metodo).classList.add('active');

    // Focar no primeiro input
    const primeiroInput = document.getElementById('metodo-' + metodo).querySelector('input');
    if (primeiroInput) {
        setTimeout(() => primeiroInput.focus(), 100);
    }
}

// ========== INICIALIZAR EVENTOS ==========
function inicializarEventos() {
    // Cartão - Número
    const inputCartao = document.getElementById('cartao');
    if (inputCartao) {
        inputCartao.addEventListener('input', function() {
            formatarNumeroCartao(this);
            atualizarPreviewCartao();
        });
    }

    // Cartão - Data
    const inputData = document.getElementById('data-expiracao');
    if (inputData) {
        inputData.addEventListener('input', function() {
            formatarData(this);
            atualizarPreviewCartao();
        });
    }

    // Cartão - CVV
    const inputCVV = document.getElementById('cvv');
    if (inputCVV) {
        inputCVV.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 4);
        });
    }

    // Cartão - Titular
    const inputTitular = document.getElementById('titular');
    if (inputTitular) {
        inputTitular.addEventListener('input', function() {
            atualizarPreviewCartao();
        });
    }

    // Telefone MBWay
    const inputTelefone = document.getElementById('telefone-mbway');
    if (inputTelefone) {
        inputTelefone.addEventListener('input', function() {
            this.value = formatarTelefoneMBWay(this.value);
        });
    }
}

// ========== FORMATAÇÃO ==========
function formatarNumeroCartao(input) {
    let valor = input.value.replace(/\s/g, '').replace(/\D/g, '');
    if (valor.length > 16) {
        valor = valor.substring(0, 16);
    }

    let valorFormatado = '';
    for (let i = 0; i < valor.length; i++) {
        if (i > 0 && i % 4 === 0) {
            valorFormatado += ' ';
        }
        valorFormatado += valor[i];
    }

    input.value = valorFormatado;

    // Detectar tipo de cartão
    const tipo = detectarTipoCartao(valor);
    const logoElement = document.getElementById('logo-cartao');
    if (logoElement) {
        logoElement.textContent = tipo;
    }
}

function detectarTipoCartao(numero) {
    if (!numero) return '';
    if (/^4/.test(numero)) return 'VISA';
    if (/^5[1-5]/.test(numero)) return 'MC';
    if (/^3[47]/.test(numero)) return 'AMEX';
    return '';
}

function formatarData(input) {
    let valor = input.value.replace(/\D/g, '');
    if (valor.length >= 2) {
        valor = valor.substring(0, 2) + '/' + valor.substring(2, 4);
    }
    input.value = valor;
}

function formatarTelefoneMBWay(valor) {
    let cleaned = valor.replace(/\D/g, '');
    if (cleaned.length > 9) cleaned = cleaned.substring(0, 9);
    if (cleaned.length > 0) {
        if (cleaned.startsWith('9')) {
            return '+351 ' + cleaned.substring(0, 1) + cleaned.substring(1, 4) + ' ' + 
                   cleaned.substring(4, 7) + ' ' + cleaned.substring(7);
        }
    }
    return valor;
}

// ========== PREVIEW CARTÃO ==========
function atualizarPreviewCartao() {
    const numero = document.getElementById('cartao').value || '1234 5678 9012 3456';
    const titular = document.getElementById('titular').value.toUpperCase() || 'JOÃO SILVA';
    const data = document.getElementById('data-expiracao').value || 'MM/AA';

    document.getElementById('preview-numero').textContent = numero;
    document.getElementById('preview-titular').textContent = titular;
    document.getElementById('preview-data').textContent = data;
}

// ========== VALIDAÇÃO ==========
function validarCartao() {
    const titular = document.getElementById('titular').value.trim();
    const cartao = document.getElementById('cartao').value.replace(/\s/g, '');
    const data = document.getElementById('data-expiracao').value;
    const cvv = document.getElementById('cvv').value;
    const termos = document.getElementById('termos-cartao').checked;

    let valido = true;

    // Validar titular
    if (titular.length < 3) {
        marcarErro('titular', 'Nome do titular inválido');
        valido = false;
    } else {
        limparErro('titular');
    }

    // Validar cartão (Luhn algorithm simplificado)
    if (cartao.length !== 16) {
        marcarErro('cartao', 'Número do cartão inválido');
        valido = false;
    } else {
        limparErro('cartao');
    }

    // Validar data
    if (!/^\d{2}\/\d{2}$/.test(data)) {
        marcarErro('data-expiracao', 'Data inválida (MM/AA)');
        valido = false;
    } else {
        const [mes, ano] = data.split('/');
        if (mes < 1 || mes > 12 || ano < 24) {
            marcarErro('data-expiracao', 'Cartão expirado');
            valido = false;
        } else {
            limparErro('data-expiracao');
        }
    }

    // Validar CVV
    if (!/^\d{3,4}$/.test(cvv)) {
        marcarErro('cvv', 'CVV inválido');
        valido = false;
    } else {
        limparErro('cvv');
    }

    // Validar termos
    if (!termos) {
        alert('Por favor, autoriza o débito');
        valido = false;
    }

    return valido;
}

function validarMBWay() {
    const telefone = document.getElementById('telefone-mbway').value.replace(/\D/g, '');
    const termos = document.getElementById('termos-mbway').checked;

    let valido = true;

    if (telefone.length !== 9) {
        marcarErro('telefone-mbway', 'Telemóvel inválido');
        valido = false;
    } else {
        limparErro('telefone-mbway');
    }

    if (!termos) {
        alert('Por favor, autoriza o pagamento');
        valido = false;
    }

    return valido;
}

function marcarErro(elementId, mensagem) {
    const element = document.getElementById(elementId);
    if (element) {
        element.parentElement.classList.add('erro');
        const msgElement = document.getElementById('erro-' + elementId);
        if (msgElement) {
            msgElement.textContent = mensagem;
        }
    }
}

function limparErro(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.parentElement.classList.remove('erro');
        const msgElement = document.getElementById('erro-' + elementId);
        if (msgElement) {
            msgElement.textContent = '';
        }
    }
}

// ========== PROCESSAMENTO PAGAMENTO ==========
function confirmarPagamento() {
    let valido = false;

    if (metodoAtual === 'cartao') {
        valido = validarCartao();
    } else if (metodoAtual === 'mbway') {
        valido = validarMBWay();
    }

    if (!valido) {
        return;
    }

    // Desabilitar botão
    document.getElementById('btn-confirmar').disabled = true;

    // Mostrar modal de processamento
    const modal = document.getElementById('modal-processamento');
    modal.classList.add('active');

    // Simular processamento
    let metodoNome = metodoAtual === 'cartao' ? 'Cartão de Crédito' : 'MBWay';
    document.getElementById('modal-titulo').textContent = `A processar pagamento via ${metodoNome}...`;

    // Simular delays e processamento
    setTimeout(() => {
        document.getElementById('modal-descricao').textContent = 'A validar dados...';
    }, 800);

    setTimeout(() => {
        document.getElementById('modal-descricao').textContent = 'A processar transação...';
    }, 1600);

    // Sucesso (90% de chance)
    setTimeout(() => {
        if (Math.random() > 0.1) {
            processarPagamentoSucesso();
        } else {
            processarPagamentoErro();
        }
    }, 2800);
}

function processarPagamentoSucesso() {
    const modal = document.getElementById('modal-processamento');
    modal.classList.remove('active');

    // Gerar número de encomenda
    const numeroEncomenda = 'DOC' + Date.now().toString().slice(-6);
    document.getElementById('numero-encomenda').textContent = numeroEncomenda;

    // Guardar pedido completado
    const pedidoCompleto = {
        ...pedidoData,
        numeroEncomenda: numeroEncomenda,
        data: new Date().toLocaleDateString('pt-PT'),
        hora: new Date().toLocaleTimeString('pt-PT'),
        metodo: metodoAtual === 'cartao' ? 'Cartão de Crédito' : 'MBWay'
    };
    localStorage.setItem('pedido_completo', JSON.stringify(pedidoCompleto));

    // Mostrar modal de sucesso
    const modalSucesso = document.getElementById('modal-sucesso');
    modalSucesso.classList.add('active');
}

function processarPagamentoErro() {
    const modal = document.getElementById('modal-processamento');
    modal.classList.remove('active');

    // Mostrar modal de erro
    const modalErro = document.getElementById('modal-erro');
    modalErro.classList.add('active');

    // Reabilitar botão
    document.getElementById('btn-confirmar').disabled = false;

    const erros = [
        'Dados do cartão inválidos',
        'Transação recusada pelo banco',
        'Saldo insuficiente',
        'Cartão expirado ou bloqueado'
    ];

    const erroAleatorio = erros[Math.floor(Math.random() * erros.length)];
    document.getElementById('modal-erro-msg').textContent = erroAleatorio;
}

// ========== NAVEGAÇÃO ==========
function voltarFinalizacao() {
    window.location.href = '../pages/compras-finalizar.php';
}

function finalizarCompra() {
    // Limpar localStorage
    localStorage.removeItem('carrinho_docesdias');
    localStorage.removeItem('pedido_docesdias');

    // Ir para página inicial
    window.location.href = '../index.php';
}

function fecharErro() {
    const modalErro = document.getElementById('modal-erro');
    modalErro.classList.remove('active');
}
