// carrinho.js - Doces Dias

// Variáveis Globais
let carrinho = [];
let codigoPromoAtivo = null;

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    carregarCarrinho();
    atualizarResumo();
});

// Carregar carrinho do localStorage ou sessão PHP
function carregarCarrinho() {
    const carrinhoStorage = localStorage.getItem('carrinho_docesdias');
    if (carrinhoStorage) {
        carrinho = JSON.parse(carrinhoStorage);
    } else {
        // Produtos de exemplo (remover em produção)
        carrinho = [
            {
                id: 1,
                tipo: 'bolo_personalizado',
                nome: 'BOLO PERSONALIZADO',
                descricao: 'Red Velvet / Mascarpone',
                tamanho: 'Médio (13-16 pessoas)',
                evento: 'Aniversário - 25 anos',
                data: '15/02/2026',
                preco: 45.00,
                quantidade: 1,
                imagem: '../img-pap/bolo-exemplo.jpg'
            },
            {
                id: 2,
                tipo: 'cupcakes',
                nome: 'CUPCAKES ARTESANAIS',
                descricao: 'Chocolate / Brigadeiro',
                pack: 'Pack 6 unidades',
                categoria: 'Premium',
                preco: 18.00,
                quantidade: 1,
                imagem: '../img-pap/cupcakes-exemplo.jpg'
            }
        ];
    }
}

// Salvar carrinho
function salvarCarrinho() {
    localStorage.setItem('carrinho_docesdias', JSON.stringify(carrinho));
}

// Atualizar quantidade de um produto
function atualizarQuantidade(id, novaQuantidade) {
    const produto = carrinho.find(p => p.id === id);
    if (produto) {
        produto.quantidade = parseInt(novaQuantidade);
        salvarCarrinho();
        atualizarResumo();
        mostrarNotificacao('Quantidade atualizada! 🎂', 'sucesso');
    }
}

// Remover item do carrinho
function removerItem(id) {
    const produto = carrinho.find(p => p.id === id);
    if (produto) {
        if (confirm(`Tem a certeza que deseja remover "${produto.nome}" do carrinho?`)) {
            carrinho = carrinho.filter(p => p.id !== id);
            salvarCarrinho();
            
            // Remover visualmente
            const elemento = document.querySelector(`.produto-item[data-id="${id}"]`);
            if (elemento) {
                elemento.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    elemento.remove();
                    atualizarResumo();
                    
                    // Se carrinho vazio
                    if (carrinho.length === 0) {
                        mostrarCarrinhoVazio();
                    }
                }, 300);
            }
            
            mostrarNotificacao('Produto removido do carrinho 🗑️', 'info');
        }
    }
}

// Mostrar carrinho vazio
function mostrarCarrinhoVazio() {
    const listaProdutos = document.getElementById('lista-produtos');
    listaProdutos.innerHTML = `
        <div class="carrinho-vazio">
            <h2>🛒 O teu carrinho está vazio</h2>
            <p>Adiciona alguns doces deliciosos!</p>
            <a href="../pages/produtos.php" class="btn-continuar">Continuar a Comprar</a>
        </div>
    `;
}

// Atualizar resumo da encomenda
function atualizarResumo() {
    // Calcular totais
    let subtotal = 0;
    let totalItens = 0;
    
    carrinho.forEach(produto => {
        subtotal += produto.preco * produto.quantidade;
        totalItens += produto.quantidade;
    });
    
    // Calcular entrega
    let entrega = subtotal >= 50 ? 0 : 5.00;
    
    // Calcular desconto
    let desconto = 0;
    if (codigoPromoAtivo) {
        if (codigoPromoAtivo.tipo === 'percentagem') {
            desconto = subtotal * (codigoPromoAtivo.valor / 100);
        } else {
            desconto = codigoPromoAtivo.valor;
        }
    }
    
    // Total final
    let total = subtotal + entrega - desconto;
    
    // Impostos (IVA 23%)
    let impostos = total * 0.187; // Aproximadamente 23% incluído no total
    
    // Atualizar HTML
    document.getElementById('total-itens').textContent = `${totalItens} produto${totalItens !== 1 ? 's' : ''}`;
    document.getElementById('subtotal').textContent = `€ ${subtotal.toFixed(2)}`;
    document.getElementById('entrega-valor').textContent = entrega === 0 ? 'Grátis' : `€ ${entrega.toFixed(2)}`;
    document.getElementById('desconto-valor').textContent = `- € ${desconto.toFixed(2)}`;
    document.getElementById('total-final').textContent = `€ ${total.toFixed(2)}`;
    document.getElementById('impostos').textContent = impostos.toFixed(2);
    
    // Atualizar contador no header
    document.querySelector('.produto-count').textContent = `(${totalItens} produto${totalItens !== 1 ? 's' : ''})`;
    
    // Mensagem de entrega grátis
    if (entrega === 0) {
        document.getElementById('entrega-valor').style.color = 'var(--verde-sucesso)';
        document.getElementById('entrega-valor').style.fontWeight = '700';
    }
}

// Toggle código promocional
function togglePromoCode() {
    const container = document.getElementById('promo-container');
    const seta = document.querySelector('.codigo-promo .seta');
    
    if (container.style.display === 'none') {
        container.style.display = 'flex';
        seta.style.transform = 'rotate(180deg)';
    } else {
        container.style.display = 'none';
        seta.style.transform = 'rotate(0deg)';
    }
}

// Aplicar código promocional
function aplicarCodigo() {
    const input = document.getElementById('codigo-promo');
    const codigo = input.value.trim().toUpperCase();
    
    // Códigos válidos (em produção, verificar no backend)
    const codigosValidos = {
        'DOCESDIAS10': { tipo: 'percentagem', valor: 10, descricao: '10% de desconto' },
        'BEMVINDO': { tipo: 'percentagem', valor: 5, descricao: '5% de desconto' },
        'PRIMEIRACOMPRA': { tipo: 'fixo', valor: 5, descricao: '5€ de desconto' },
        'ANIVERSARIO': { tipo: 'percentagem', valor: 15, descricao: '15% de desconto' }
    };
    
    if (codigosValidos[codigo]) {
        codigoPromoAtivo = codigosValidos[codigo];
        codigoPromoAtivo.codigo = codigo;
        
        mostrarNotificacao(`✅ Código "${codigo}" aplicado! ${codigoPromoAtivo.descricao}`, 'sucesso');
        
        // Atualizar visual
        const codigoDiv = document.querySelector('.codigo-promo');
        codigoDiv.style.background = 'var(--verde-sucesso)';
        codigoDiv.style.color = 'white';
        codigoDiv.innerHTML = `
            <span class="promo-icon">✓</span>
            <span>Código ${codigo} aplicado!</span>
            <button onclick="removerCodigo()" style="background: none; border: none; color: white; cursor: pointer; margin-left: auto;">✕</button>
        `;
        
        input.value = '';
        togglePromoCode();
        atualizarResumo();
    } else {
        mostrarNotificacao('❌ Código inválido ou expirado', 'erro');
        input.style.borderColor = 'var(--vermelho)';
        setTimeout(() => {
            input.style.borderColor = 'var(--rosa-principal)';
        }, 2000);
    }
}

// Remover código promocional
function removerCodigo() {
    codigoPromoAtivo = null;
    
    const codigoDiv = document.querySelector('.codigo-promo');
    codigoDiv.style.background = 'var(--rosa-claro)';
    codigoDiv.style.color = 'var(--texto-escuro)';
    codigoDiv.innerHTML = `
        <span class="promo-icon">🏷️</span>
        <span>Utiliza um código promocional</span>
        <span class="seta">▼</span>
    `;
    
    codigoDiv.onclick = togglePromoCode;
    
    atualizarResumo();
    mostrarNotificacao('Código removido', 'info');
}

// Finalizar compra - Ir para Finalização
function irParaFinalizacao() {
    if (carrinho.length === 0) {
        mostrarNotificacao('❌ O teu carrinho está vazio!', 'erro');
        return;
    }
    
    // Verificar produtos com data de entrega
    const produtosComData = carrinho.filter(p => p.data);
    const hoje = new Date();
    
    for (let produto of produtosComData) {
        const dataEvento = new Date(produto.data.split('/').reverse().join('-'));
        const diasDiferenca = Math.ceil((dataEvento - hoje) / (1000 * 60 * 60 * 24));
        
        if (diasDiferenca < 7) {
            mostrarNotificacao(`⚠️ Atenção: O bolo "${produto.nome}" necessita de pelo menos 7 dias de antecedência!`, 'erro');
            return;
        }
    }

    // Salvar carrinho antes de ir para finalização
    salvarCarrinho();
    
    mostrarNotificacao('🎂 A redirecionar para a finalização...', 'sucesso');
    setTimeout(() => {
        window.location.href = '../pages/compras-finalizar.php';
    }, 1500);
}

// Finalizar compra (legado)
function finalizarCompra() {
    irParaFinalizacao();
}

// Calcular subtotal
function calcularSubtotal() {
    return carrinho.reduce((total, produto) => {
        return total + (produto.preco * produto.quantidade);
    }, 0);
}

// Sistema de notificações
function mostrarNotificacao(mensagem, tipo = 'info') {
    // Remover notificação anterior se existir
    const notificacaoAnterior = document.querySelector('.notificacao-toast');
    if (notificacaoAnterior) {
        notificacaoAnterior.remove();
    }
    
    // Criar nova notificação
    const notificacao = document.createElement('div');
    notificacao.className = `notificacao-toast notificacao-${tipo}`;
    notificacao.textContent = mensagem;
    
    // Estilos inline
    notificacao.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 12px;
        font-weight: 600;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    `;
    
    // Cores por tipo
    const cores = {
        sucesso: 'background: var(--verde-sucesso); color: white;',
        erro: 'background: var(--vermelho); color: white;',
        info: 'background: var(--rosa-principal); color: white;'
    };
    
    notificacao.style.cssText += cores[tipo] || cores.info;
    
    document.body.appendChild(notificacao);
    
    // Remover após 4 segundos
    setTimeout(() => {
        notificacao.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notificacao.remove(), 300);
    }, 4000);
}

// Animações CSS (adicionar ao CSS ou criar dinamicamente)
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(-100%);
            opacity: 0;
        }
    }
    
    .carrinho-vazio {
        text-align: center;
        padding: 60px 20px;
    }
    
    .carrinho-vazio h2 {
        font-size: 28px;
        color: var(--chocolate);
        margin-bottom: 15px;
    }
    
    .carrinho-vazio p {
        color: var(--texto-claro);
        margin-bottom: 25px;
    }
    
    .btn-continuar {
        display: inline-block;
        padding: 14px 30px;
        background: var(--rosa-principal);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .btn-continuar:hover {
        background: var(--rosa-escuro);
        transform: translateY(-2px);
    }
`;
document.head.appendChild(style);

// Event Listeners adicionais
document.addEventListener('keypress', function(e) {
    // Enter no input do código promo
    if (e.target.id === 'codigo-promo' && e.key === 'Enter') {
        e.preventDefault();
        aplicarCodigo();
    }
});