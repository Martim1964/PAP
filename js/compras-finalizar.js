// =========================================================
// JS DA ETAPA DE FINALIZACAO
// - carrega o carrinho para resumo visual
// - valida dados pessoais e de entrega
// - guarda os dados para a etapa de pagamento
// =========================================================

// Dados Globais
let carrinhoData = {};
let pedidoData = {
    pessoal: {},
    endereco: {},
    observacoes: '',
    entrega: 'normal',
    desconto: 0
};

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    carregarDadosCarrinho();
    inicializarFormularios();
    atualizarResumo();
});

// ========== CARREGAR DADOS DO CARRINHO ==========
function carregarDadosCarrinho() {
    if (Array.isArray(window.carrinhoSessao) && window.carrinhoSessao.length > 0) {
        carrinhoData = window.carrinhoSessao.map(function (produto) {
            return {
                imagem: produto.imagem,
                nome: produto.nome,
                quantidade: Number(produto.quantidade || 0),
                preco: Number(produto.preco_unitario || 0)
            };
        });

        localStorage.setItem('carrinho_docesdias', JSON.stringify(carrinhoData));
        renderizarResumo();
        return;
    }

    const carrinhoStorage = localStorage.getItem('carrinho_docesdias');
    if (!carrinhoStorage) {
        window.location.href = '../pages/compras.php';
        return;
    }

    carrinhoData = JSON.parse(carrinhoStorage);
    renderizarResumo();
}

// Renderizar Resumo de Produtos
function renderizarResumo() {
    const container = document.getElementById('lista-resumo-produtos');
    
    if (!carrinhoData || carrinhoData.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #6B6B6B;">Carrinho vazio</p>';
        return;
    }

    let html = '';
    carrinhoData.forEach(produto => {
        const subtotal = produto.preco * produto.quantidade;
        html += `
            <div class="resumo-produto-item">
                <div class="resumo-produto-img">
                    <img src="${produto.imagem}" alt="${produto.nome}">
                </div>
                <div class="resumo-produto-info">
                    <div class="resumo-produto-nome">${produto.nome}</div>
                    <div class="resumo-produto-qtd">Quantidade: ${produto.quantidade}x</div>
                </div>
                <div class="resumo-produto-preco">€ ${subtotal.toFixed(2)}</div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// ========== INICIALIZAR FORMULÁRIOS ==========
function inicializarFormularios() {
    // Contador de caracteres
    const observacoes = document.getElementById('observacoes');
    if (observacoes) {
        observacoes.addEventListener('input', function() {
            document.getElementById('chars-atual').textContent = this.value.length;
            if (this.value.length > 500) {
                this.value = this.value.substring(0, 500);
            }
        });
    }

    // Validação em tempo real
    const inputs = document.querySelectorAll('.form-grupo input, .form-grupo textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validarCampo(this);
        });

        input.addEventListener('input', function() {
            if (this.parentElement.classList.contains('erro')) {
                validarCampo(this);
            }
        });
    });

    // Enderço igual - toggle
    const enderecoIgual = document.getElementById('endereco-igual');
    if (enderecoIgual) {
        enderecoIgual.addEventListener('change', function() {
            if (this.checked) {
                preencherEnderecoFaturacao();
            }
        });
    }
}

// ========== VALIDAÇÃO ==========
function validarCampo(campo) {
    const parent = campo.parentElement;
    const valor = campo.value.trim();
    let valido = true;
    let mensagem = '';

    switch (campo.id) {
        case 'nome':
            valido = valor.length >= 3;
            mensagem = 'Nome deve ter pelo menos 3 caracteres';
            break;
        case 'email':
            valido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor);
            mensagem = 'Email inválido';
            break;
        case 'telefone':
            valido = /^(\+351|00351|9)[0-9]{8}$/.test(valor.replace(/\s/g, ''));
            mensagem = 'Telemóvel inválido';
            break;
        case 'endereco':
            valido = valor.length >= 5;
            mensagem = 'Endereço inválido';
            break;
        case 'codigo-postal':
            valido = /^[0-9]{4}-[0-9]{3}$/.test(valor);
            mensagem = 'Código postal no formato XXXX-XXX';
            break;
        case 'cidade':
            valido = valor.length >= 3;
            mensagem = 'Cidade inválida';
            break;
    }

    if (!valido && valor) {
        parent.classList.add('erro');
        parent.querySelector('.erro-msg').textContent = mensagem;
    } else {
        parent.classList.remove('erro');
    }

    return valido;
}

function validarFormulario() {
    const inputs = document.querySelectorAll('#form-dados-pessoais input, #form-endereco input');
    let valido = true;

    inputs.forEach(input => {
        if (input.hasAttribute('required') && !input.value.trim()) {
            input.parentElement.classList.add('erro');
            input.parentElement.querySelector('.erro-msg').textContent = 'Campo obrigatório';
            valido = false;
        } else {
            if (!validarCampo(input)) {
                valido = false;
            }
        }
    });

    const termos = document.getElementById('termos');
    if (!termos || !termos.checked) {
        alert('Por favor, aceita os Termos e Condições');
        return false;
    }

    return valido;
}

// ========== PREÇOS E RESUMO ==========
function calcularSubtotal() {
    let subtotal = 0;
    if (carrinhoData && Array.isArray(carrinhoData)) {
        carrinhoData.forEach(produto => {
            subtotal += produto.preco * produto.quantidade;
        });
    }
    return subtotal;
}

function selecionarEntrega(tipo) {
    pedidoData.entrega = tipo;
    atualizarResumo();
}

function atualizarResumo() {
    const subtotal = calcularSubtotal();
    let taxaEntrega = 5.00;

    if (pedidoData.entrega === 'express') {
        taxaEntrega = 12.00;
    } else if (pedidoData.entrega === 'urgente') {
        taxaEntrega = 25.00;
    }

    const subtotalComEntrega = subtotal + taxaEntrega;
    const desconto = pedidoData.desconto || 0;
    const iva = (subtotalComEntrega - desconto) * 0.23;
    const total = subtotalComEntrega - desconto + iva;

    // Atualizar DOM
    document.getElementById('resumo-subtotal').textContent = '€ ' + subtotal.toFixed(2);
    document.getElementById('resumo-entrega').textContent = '€ ' + taxaEntrega.toFixed(2);
    document.getElementById('resumo-iva').textContent = '€ ' + iva.toFixed(2);
    document.getElementById('resumo-total-final').textContent = '€ ' + total.toFixed(2);

    // Mostrar/esconder desconto
    const descontoContainer = document.getElementById('resumo-desconto-container');
    if (desconto > 0) {
        descontoContainer.style.display = 'flex';
        document.getElementById('resumo-desconto').textContent = '- € ' + desconto.toFixed(2);
    } else {
        descontoContainer.style.display = 'none';
    }
}

// ========== PREENCHIMENTO AUTOMÁTICO ==========
function preencherEnderecoFaturacao() {
    const endereco = document.getElementById('endereco').value;
    const cep = document.getElementById('codigo-postal').value;
    const cidade = document.getElementById('cidade').value;

    // Se implementado, preencher campos de faturação automaticamente
    console.log('Endereço de faturação sincronizado');
}

// ========== APLICAR CÓDIGO PROMOCIONAL ==========
function aplicarCodigoPromocional() {
    const codigo = document.getElementById('codigo-promo')?.value || '';
    
    // Códigos de exemplo
    const codigos = {
        'DOCESDIAS10': 0.10,
        'FESTA15': 0.15,
        'WELCOME5': 0.05,
        'NIVER20': 0.20
    };

    if (codigos[codigo]) {
        const desconto = calcularSubtotal() * codigos[codigo];
        pedidoData.desconto = desconto;
        mostrarNotificacao(`Código aplicado! Desconto: € ${desconto.toFixed(2)}`, 'sucesso');
        atualizarResumo();
    } else if (codigo) {
        mostrarNotificacao('Código promocional inválido', 'erro');
    }
}

// ========== NAVEGAÇÃO ==========
function voltarCarrinho() {
    window.location.href = '../pages/compras.php';
}

function avancarPagamento() {
    if (!validarFormulario()) {
        mostrarNotificacao('Por favor, preenche todos os campos corretamente', 'erro');
        return;
    }

    // Guardar dados do pedido
    pedidoData.pessoal = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        telefone: document.getElementById('telefone').value
    };

    pedidoData.endereco = {
        endereco: document.getElementById('endereco').value,
        codigoPostal: document.getElementById('codigo-postal').value,
        cidade: document.getElementById('cidade').value,
        complemento: document.getElementById('complemento').value || ''
    };

    pedidoData.observacoes = document.getElementById('observacoes').value || '';

    // Guardar em localStorage
    localStorage.setItem('pedido_docesdias', JSON.stringify(pedidoData));

    mostrarNotificacao('Avançando para pagamento...', 'sucesso');

    // Redirecionar para página de pagamento
    setTimeout(() => {
        window.location.href = '../pages/compras-pagamento.php';
    }, 1500);
}

// ========== NOTIFICAÇÕES ==========
function mostrarNotificacao(mensagem, tipo = 'info') {
    // Remover notificação anterior se existir
    const notificacaoAnterior = document.querySelector('.notificacao-flutuante');
    if (notificacaoAnterior) {
        notificacaoAnterior.remove();
    }

    const notificacao = document.createElement('div');
    notificacao.className = `notificacao-flutuante notificacao-${tipo}`;
    notificacao.textContent = mensagem;
    notificacao.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 16px 24px;
        background: ${tipo === 'erro' ? '#E74C3C' : tipo === 'sucesso' ? '#6DC95D' : '#5B9BD5'};
        color: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        z-index: 1000;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    `;

    document.body.appendChild(notificacao);

    setTimeout(() => {
        notificacao.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notificacao.remove(), 300);
    }, 3000);
}

// ========== UTILITÁRIOS ==========
function formatarTelefone(value) {
    let cleaned = value.replace(/\D/g, '');
    if (cleaned.length > 9) cleaned = cleaned.substring(0, 9);
    if (cleaned.startsWith('9')) {
        return cleaned.replace(/(\d{1})(\d{3})(\d{3})(\d{2})/, '$1 $2 $3 $4');
    }
    return cleaned;
}

function formatarCodigoPostal(value) {
    let cleaned = value.replace(/\D/g, '');
    if (cleaned.length > 7) cleaned = cleaned.substring(0, 7);
    if (cleaned.length >= 4) {
        return cleaned.substring(0, 4) + '-' + cleaned.substring(4);
    }
    return cleaned;
}

// Aplicar máscaras de input
document.addEventListener('DOMContentLoaded', function() {
    const telefone = document.getElementById('telefone');
    if (telefone) {
        telefone.addEventListener('input', function() {
            this.value = formatarTelefone(this.value);
        });
    }

    const cp = document.getElementById('codigo-postal');
    if (cp) {
        cp.addEventListener('input', function() {
            this.value = formatarCodigoPostal(this.value);
        });
    }
});
