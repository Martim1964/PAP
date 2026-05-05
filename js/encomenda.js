// ============================================================
// FICHEIRO: js/encomenda.js
// O QUE FAZ: Comportamento interativo da página de encomenda.
//
// IMPORTANTE: Os preços já não estão hardcoded aqui!
// Vêm do PHP via variável global `precosDB` que é gerada
// a partir da base de dados (ver fundo do encomenda.php).
// O JS usa-os SÓ para mostrar o resumo visual em tempo real.
// O preço REAL é sempre calculado no servidor (PHP + MySQL).
// ============================================================

// --- CALCULAR PREÇO TOTAL ---
// Usa os preços que vieram da BD via PHP
function calcularTotal() {
    const tamanhoVal = document.getElementById('tamanho')?.value;
    const massaVal   = document.getElementById('massa')?.value;
    const recheioVal = document.getElementById('recheio')?.value;

    const precoTamanho = (precosDB?.tamanho?.[tamanhoVal] || 0);
    const precoMassa   = (precosDB?.massa?.[massaVal]     || 0);
    const precoRecheio = (precosDB?.recheio?.[recheioVal] || 0);

    return precoTamanho + precoMassa + precoRecheio;
}

// --- ATUALIZAR RESUMO EM TEMPO REAL ---
function atualizarResumo() {
    const tamanhoEl = document.getElementById('tamanho');
    const massaEl   = document.getElementById('massa');
    const recheioEl = document.getElementById('recheio');
    const dataEl    = document.getElementById('birthday');
    const obsEl     = document.getElementById('observacoes');
    const resumoDiv = document.getElementById('resumo-content');

    if (!resumoDiv) return;

    // Só mostra o resumo quando os campos obrigatórios estão preenchidos
    if (!tamanhoEl?.value || !massaEl?.value || !recheioEl?.value || !dataEl?.value) {
        resumoDiv.innerHTML = '<p class="resumo-vazio">Preenche os campos para ver o resumo...</p>';
        return;
    }

    const total = calcularTotal();
    const dataFormatada = new Date(dataEl.value + 'T00:00:00').toLocaleDateString('pt-PT');

    let html = '';

    html += '<div class="resumo-item">';
    html += '<h3>Detalhes do Bolo</h3>';
    html += `<p><strong>Tamanho:</strong> ${tamanhoEl.options[tamanhoEl.selectedIndex].text}</p>`;
    html += `<p><strong>Massa:</strong> ${massaEl.options[massaEl.selectedIndex].text}</p>`;
    html += `<p><strong>Recheio:</strong> ${recheioEl.options[recheioEl.selectedIndex].text}</p>`;
    html += '</div>';

    html += '<div class="resumo-item">';
    html += '<h3>Evento</h3>';
    html += `<p><strong>Data:</strong> ${dataFormatada}</p>`;
    html += '</div>';

    if (obsEl?.value.trim()) {
        html += '<div class="resumo-item">';
        html += '<h3>Observações</h3>';
        html += `<p>${obsEl.value.trim()}</p>`;
        html += '</div>';
    }

    html += `<div class="resumo-total">Total estimado: €${total.toFixed(2)}</div>`;

    resumoDiv.innerHTML = html;
}

// --- VALIDAÇÃO DA DATA ---
function inicializarValidacaoData() {
    const campoData = document.getElementById('birthday');
    if (!campoData) return;

    const hoje       = new Date();
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    campoData.min = dataMinima.toISOString().split('T')[0];

    campoData.addEventListener('blur', function () {
        if (!campoData.value) return;

        const dataSelecionada = new Date(campoData.value + 'T00:00:00');
        const minima = new Date();
        minima.setHours(0, 0, 0, 0);
        minima.setDate(minima.getDate() + 7);

        if (dataSelecionada < minima) {
            alert('A data do evento tem de ser pelo menos 7 dias a partir de hoje.');
            campoData.value = '';
            atualizarResumo();
        }
    });

    campoData.addEventListener('change', atualizarResumo);
}

// --- LIMPAR FORMULÁRIO ---
function inicializarBotaoLimpar() {
    const btnLimpar = document.getElementById('btn-limpar-pedido');
    if (!btnLimpar) return;

    btnLimpar.addEventListener('click', function () {
        if (!confirm('Tens a certeza que queres limpar todos os campos?')) return;
        document.querySelector('form')?.reset();
        const resumoDiv = document.getElementById('resumo-content');
        if (resumoDiv) {
            resumoDiv.innerHTML = '<p class="resumo-vazio">Preenche os campos para ver o resumo...</p>';
        }
    });
}

// --- MONITORAR CAMPOS ---
function inicializarListeners() {
    const campos = ['tamanho', 'massa', 'recheio', 'birthday', 'observacoes'];
    campos.forEach(function (id) {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener('change', atualizarResumo);
            campo.addEventListener('input',  atualizarResumo);
        }
    });
}

// --- MOSTRAR DECORAÇÃO CORRETA CONFORME CATEGORIA ---
function mostrarDecoracaoCorreta() {
    const categoria = document.querySelector('.bcontainer')?.dataset?.category || '';
    const decoracoes = {
        'casamento'  : document.getElementById('decoracao-casamento'),
        'aniversario': document.getElementById('decoracao-aniversario'),
        'batizado'   : document.getElementById('decoracao-batizado'),
    };

    Object.values(decoracoes).forEach(function (el) {
        if (el) el.style.display = 'none';
    });

    if (decoracoes[categoria]) {
        decoracoes[categoria].style.display = 'block';
    }
}

// --- INICIALIZAÇÃO ---
document.addEventListener('DOMContentLoaded', function () {
    mostrarDecoracaoCorreta();
    inicializarValidacaoData();
    inicializarBotaoLimpar();
    inicializarListeners();
});