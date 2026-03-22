// =============================================
// ENCOMENDA-CUPCAKES.JS
// JS para a página de encomenda de cupcakes
// e doces tradicionais
// =============================================

// ===== TABELA DE PREÇOS =====
const precos = {
    pequeno:     25,
    medio:       35,
    grande:      50,
    muito_grande: 70
};

const labels = {
    pequeno:      'Pack 6 bolachas',
    medio:        'Pack 14 bolachas',
    grande:       'Pack 28 bolachas',
    muito_grande: 'Pack 50 bolachas'
};

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

// ===== ATUALIZAR RESUMO EM TEMPO REAL =====
function atualizarResumo() {
    const quantidadeEl  = document.getElementById('tamanho'); // reutiliza o id "tamanho"
    const dataEl        = document.getElementById('birthday');
    const obsEl         = document.getElementById('observacoes');
    const resumoContent = document.getElementById('resumo-content');

    if (!resumoContent) return;

    // Só mostra resumo quando os campos obrigatórios estiverem preenchidos
    if (!quantidadeEl?.value || !dataEl?.value) {
        resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        return;
    }

    const total = precos[quantidadeEl.value] || 0;
    const labelQuantidade = labels[quantidadeEl.value] || quantidadeEl.value;
    const dataFormatada = new Date(dataEl.value + 'T00:00:00').toLocaleDateString('pt-PT');

    let html = '';

    // Bloco: detalhes da encomenda
    html += '<div class="resumo-item">';
    html += '<h3>🧁 Detalhes da Encomenda</h3>';
    html += `<p><strong>Quantidade:</strong> ${labelQuantidade}</p>`;
    html += `<p><strong>Data:</strong> ${dataFormatada}</p>`;
    html += '</div>';

    // Bloco: observações (se existirem)
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

        const resumoContent = document.getElementById('resumo-content');
        if (resumoContent) {
            resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        }
    });
}

// ===== MONITORAR CAMPOS PARA ATUALIZAR RESUMO =====
function inicializarListeners() {
    const campos = ['tamanho', 'birthday', 'observacoes'];

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
    inicializarData();
    inicializarLimpar();
    inicializarListeners();
});