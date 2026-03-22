// =========================================================
// JS DO CARRINHO
// 1. Quando a quantidade muda, envia o formulario.
// 2. Quando tentamos remover um item, pede confirmacao.
// =========================================================

function atualizarQuantidade(evento) {
    const seletor = evento.target;
    const formulario = seletor.closest('.js-quantity-form');

    if (formulario) {
        formulario.submit();
    }
}

function confirmarRemocao(evento) {
    const querRemover = window.confirm('Tem a certeza de que pretende remover este item do carrinho?');

    if (!querRemover) {
        evento.preventDefault();
    }
}

function ligarEventosQuantidade() {
    const seletores = document.querySelectorAll('.js-quantity-select');

    seletores.forEach(function (seletor) {
        seletor.addEventListener('change', atualizarQuantidade);
    });
}

function ligarEventosRemocao() {
    const formulariosRemocao = document.querySelectorAll('.js-remove-form');

    formulariosRemocao.forEach(function (formulario) {
        formulario.addEventListener('submit', confirmarRemocao);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    ligarEventosQuantidade();
    ligarEventosRemocao();
});
