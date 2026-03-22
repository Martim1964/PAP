// =============================================
// ENCOMENDA.JS
// JS específico para a página de encomenda
// de um bolo do catálogo
// =============================================

// ===== CATEGORIA DO BOLO (vem do PHP via data-category) =====
const category = document.querySelector('.bcontainer')?.dataset?.category || 'outro';

// ===== MOSTRAR A DECORAÇÃO CORRETA AUTOMATICAMENTE =====
// Em vez de o utilizador escolher o tipo de evento,
// a decoração já sabe a categoria do bolo que foi clicado.
function mostrarDecoracaoCorreta() {
    const decoracaoCasamento  = document.getElementById('decoracao-casamento');
    const decoracaoAniversario = document.getElementById('decoracao-aniversario');
    const decoracaoBatizado   = document.getElementById('decoracao-batizado');

    // Esconde todas primeiro
    if (decoracaoCasamento)  decoracaoCasamento.style.display  = 'none';
    if (decoracaoAniversario) decoracaoAniversario.style.display = 'none';
    if (decoracaoBatizado)   decoracaoBatizado.style.display   = 'none';

    // Mostra só a da categoria deste bolo
    switch (category) {
        case 'casamento':
            if (decoracaoCasamento) decoracaoCasamento.style.display = 'block';
            break;
        case 'aniversario':
            if (decoracaoAniversario) decoracaoAniversario.style.display = 'block';
            break;
        case 'batizado':
            if (decoracaoBatizado) decoracaoBatizado.style.display = 'block';
            break;
        // 'outro' (cupcakes etc.) — não mostra nenhuma decoração específica
    }
}

// ===== VALIDAÇÃO DE DATA (mínimo 7 dias) =====
function inicializarData() {
    const dataInput = document.getElementById('birthday');
    if (!dataInput) return;

    // Define a data mínima via HTML5
    const hoje = new Date();
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    dataInput.min = dataMinima.toISOString().split('T')[0];

    dataInput.addEventListener('blur', function () {
        if (!dataInput.value || dataInput.value.length < 10) return;

        const dataSelecionada = new Date(dataInput.value);
        if (isNaN(dataSelecionada.getTime())) return;

        const minima = new Date();
        minima.setHours(0, 0, 0, 0);
        minima.setDate(minima.getDate() + 7);
        dataSelecionada.setHours(0, 0, 0, 0);

        if (dataSelecionada < minima) {
            alert('A data do evento deve ser marcada com pelo menos 7 dias de antecedência.');
            dataInput.value = '';
            atualizarResumo();
        }
    });

    dataInput.addEventListener('change', atualizarResumo);
}

// ===== TABELA DE PREÇOS =====
const precos = {
    tamanho: {
        pequeno:     25,
        medio:       35,
        grande:      50,
        muito_grande: 70
    },
    massa: {
        baunilha:      0,
        laranja_canela: 0,
        papoila_limao:  0,
        chocolate:     10,
        red_velvet:    12,
        cenoura:        8
    },
    recheio: {
        caramelo:    0,
        morango:     0,
        limao:       0,
        creamcheese: 0,
        brigadeiro:  8,
        mascarpone: 10,
        framboesa:  12,
        maracuja:   12
    }
};

function calcularTotal() {
    const tamanhoVal = document.getElementById('tamanho')?.value;
    const massaVal   = document.getElementById('massa')?.value;
    const recheioVal = document.getElementById('recheio')?.value;

    return (precos.tamanho[tamanhoVal] || 0)
         + (precos.massa[massaVal]     || 0)
         + (precos.recheio[recheioVal] || 0);
}

// ===== ATUALIZAR RESUMO EM TEMPO REAL =====
function atualizarResumo() {
    const tamanhoEl  = document.getElementById('tamanho');
    const massaEl    = document.getElementById('massa');
    const recheioEl  = document.getElementById('recheio');
    const dataEl     = document.getElementById('birthday');
    const obsEl      = document.getElementById('observacoes');
    const resumoContent = document.getElementById('resumo-content');

    if (!resumoContent) return;

    // Só mostra resumo quando os campos obrigatórios estiverem preenchidos
    if (!tamanhoEl?.value || !massaEl?.value || !recheioEl?.value || !dataEl?.value) {
        resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        return;
    }

    const total = calcularTotal();
    let html = '';

    // Bloco: detalhes do bolo
    html += '<div class="resumo-item">';
    html += '<h3>🎂 Detalhes do Bolo</h3>';
    html += `<p><strong>Tamanho:</strong> ${tamanhoEl.options[tamanhoEl.selectedIndex].text}</p>`;
    html += `<p><strong>Massa:</strong> ${massaEl.options[massaEl.selectedIndex].text}</p>`;
    html += `<p><strong>Recheio:</strong> ${recheioEl.options[recheioEl.selectedIndex].text}</p>`;
    html += '</div>';

    // Bloco: evento
    html += '<div class="resumo-item">';
    html += '<h3>📅 Evento</h3>';

    const dataFormatada = new Date(dataEl.value + 'T00:00:00').toLocaleDateString('pt-PT');
    html += `<p><strong>Data:</strong> ${dataFormatada}</p>`;

    // Decoração (se existir e estiver preenchida)
    const decoracaoAniv = document.getElementById('decoracao-select-aniversario');
    const decoracaoCas  = document.getElementById('decoracao-select-casamento');
    const decoracaoBat  = document.getElementById('decoracao-select-batizado');
    const idadeEl       = document.getElementById('idade');

    if (decoracaoAniv?.value) {
        html += `<p><strong>Decoração:</strong> ${decoracaoAniv.options[decoracaoAniv.selectedIndex].text}</p>`;
        if (idadeEl?.value) html += `<p><strong>Idade:</strong> ${idadeEl.value} anos</p>`;
    }
    if (decoracaoCas?.value) {
        html += `<p><strong>Decoração:</strong> ${decoracaoCas.options[decoracaoCas.selectedIndex].text}</p>`;
    }
    if (decoracaoBat?.value) {
        html += `<p><strong>Decoração:</strong> ${decoracaoBat.options[decoracaoBat.selectedIndex].text}</p>`;
    }

    html += '</div>';

    // Bloco: observações
    if (obsEl?.value.trim()) {
        html += '<div class="resumo-item">';
        html += '<h3>📝 Observações</h3>';
        html += `<p>${obsEl.value.trim()}</p>`;
        html += '</div>';
    }

    // Total
    html += `<div class="resumo-total">💰 Total estimado: €${total.toFixed(2)}</div>`;

    resumoContent.innerHTML = html;
}

// ===== LIMPAR PEDIDO =====
function inicializarLimpar() {
    const btnLimpar = document.getElementById('btn-limpar-pedido');
    if (!btnLimpar) return;

    btnLimpar.addEventListener('click', function () {
        if (!confirm('Tem a certeza que quer limpar todos os campos?')) return;

        document.querySelector('form')?.reset();

        // Volta a mostrar a decoração certa (não esconde tudo)
        mostrarDecoracaoCorreta();

        // Limpa o resumo
        const resumoContent = document.getElementById('resumo-content');
        if (resumoContent) {
            resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        }
    });
}

// ===== MONITORAR TODOS OS CAMPOS PARA ATUALIZAR RESUMO =====
function inicializarListeners() {
    const campos = ['tamanho', 'massa', 'recheio', 'birthday', 'observacoes',
                    'decoracao-select-aniversario', 'decoracao-select-casamento',
                    'decoracao-select-batizado', 'idade'];

    campos.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', atualizarResumo);
            el.addEventListener('input',  atualizarResumo);
        }
    });
}

// ===== INICIALIZAÇÃO =====
document.addEventListener('DOMContentLoaded', function () {
    mostrarDecoracaoCorreta();
    inicializarData();
    inicializarLimpar();
    inicializarListeners();
});