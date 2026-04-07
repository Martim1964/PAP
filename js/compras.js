// ============================================================
// FICHEIRO: js/compras.js
// O QUE FAZ: Comportamento interativo da página do carrinho.
//
// FUNCIONALIDADES:
//   1. Quando o utilizador muda a quantidade → envia o formulário
//      automaticamente (sem ter de clicar num botão extra).
//   2. Quando o utilizador quer remover um item → pede confirmação
//      antes de apagar, para evitar remoções acidentais.
// ============================================================

// --- 1. ATUALIZAR QUANTIDADE AUTOMATICAMENTE ---
// Quando o utilizador seleciona uma nova quantidade no <select>,
// o formulário é enviado automaticamente para o servidor.
function ligarEventosQuantidade() {
    // Seleciona todos os dropdowns de quantidade na página
    const seletoresQuantidade = document.querySelectorAll('.js-quantity-select');

    seletoresQuantidade.forEach(function(seletor) {
        seletor.addEventListener('change', function(evento) {
            // Encontra o formulário pai deste dropdown e envia-o
            const formulario = evento.target.closest('.js-quantity-form');
            if (formulario) {
                formulario.submit();
            }
        });
    });
}

// --- 2. CONFIRMAR ANTES DE REMOVER ---
// Quando o utilizador tenta remover um item, aparece uma caixa
// de diálogo a perguntar se tem a certeza.
// Se clicar "Cancelar", o formulário NÃO é enviado.
function ligarEventosRemocao() {
    const formulariosRemocao = document.querySelectorAll('.js-remove-form');

    formulariosRemocao.forEach(function(formulario) {
        formulario.addEventListener('submit', function(evento) {
            const confirmado = window.confirm('Tens a certeza que queres remover este item do carrinho?');
            if (!confirmado) {
                evento.preventDefault(); // Cancela o envio do formulário
            }
        });
    });
}

// --- INICIALIZAÇÃO ---
// Quando a página terminar de carregar, ativa as duas funções acima.
document.addEventListener('DOMContentLoaded', function() {
    ligarEventosQuantidade();
    ligarEventosRemocao();
});