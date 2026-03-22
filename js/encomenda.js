// ============================================================
// FICHEIRO: js/encomenda.js
// O QUE FAZ: Comportamento interativo da página de encomenda.
//
// FUNCIONALIDADES:
//   1. Calcula e mostra o preço total enquanto o utilizador escolhe
//      tamanho, massa e recheio (em tempo real, sem recarregar).
//   2. Valida a data: tem de ser pelo menos 7 dias no futuro.
//   3. Limpa o formulário quando o utilizador clica "Limpar Pedido".
//   4. Mostra a decoração correta consoante a categoria do bolo.
// ============================================================

// --- TABELA DE PREÇOS ---
// Igual ao que está no PHP (carrinho.php), mas em JavaScript
// para calcular o preço em tempo real no browser.
const precos = {
    tamanho: {
        pequeno:      25,
        medio:        35,
        grande:       50,
        muito_grande: 70
    },
    massa: {
        baunilha:       0,
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

// --- CALCULAR PREÇO TOTAL ---
// Soma o preço do tamanho + extra da massa + extra do recheio.
function calcularTotal() {
    const tamanhoEscolhido = document.getElementById('tamanho')?.value;
    const massaEscolhida   = document.getElementById('massa')?.value;
    const recheioEscolhido = document.getElementById('recheio')?.value;

    const precoTamanho = precos.tamanho[tamanhoEscolhido] || 0;
    const precoMassa   = precos.massa[massaEscolhida]     || 0;
    const precoRecheio = precos.recheio[recheioEscolhido] || 0;

    return precoTamanho + precoMassa + precoRecheio;
}

// --- ATUALIZAR RESUMO EM TEMPO REAL ---
// Sempre que o utilizador muda uma opção, o resumo lateral atualiza.
function atualizarResumo() {
    const tamanhoEl  = document.getElementById('tamanho');
    const massaEl    = document.getElementById('massa');
    const recheioEl  = document.getElementById('recheio');
    const dataEl     = document.getElementById('birthday');
    const obsEl      = document.getElementById('observacoes');
    const resumoDiv  = document.getElementById('resumo-content');

    if (!resumoDiv) return;

    // Só mostra o resumo quando os campos obrigatórios estão preenchidos
    if (!tamanhoEl?.value || !massaEl?.value || !recheioEl?.value || !dataEl?.value) {
        resumoDiv.innerHTML = '<p class="resumo-vazio">Preenche os campos para ver o resumo...</p>';
        return;
    }

    const total = calcularTotal();

    // Formata a data para português (dd/mm/aaaa)
    const dataFormatada = new Date(dataEl.value + 'T00:00:00').toLocaleDateString('pt-PT');

    // Constrói o HTML do resumo
    let html = '';

    html += '<div class="resumo-item">';
    html += '<h3>🎂 Detalhes do Bolo</h3>';
    html += `<p><strong>Tamanho:</strong> ${tamanhoEl.options[tamanhoEl.selectedIndex].text}</p>`;
    html += `<p><strong>Massa:</strong> ${massaEl.options[massaEl.selectedIndex].text}</p>`;
    html += `<p><strong>Recheio:</strong> ${recheioEl.options[recheioEl.selectedIndex].text}</p>`;
    html += '</div>';

    html += '<div class="resumo-item">';
    html += '<h3>📅 Evento</h3>';
    html += `<p><strong>Data:</strong> ${dataFormatada}</p>`;
    html += '</div>';

    // Observações (só aparece se o utilizador escreveu alguma coisa)
    if (obsEl?.value.trim()) {
        html += '<div class="resumo-item">';
        html += '<h3>📝 Observações</h3>';
        html += `<p>${obsEl.value.trim()}</p>`;
        html += '</div>';
    }

    html += `<div class="resumo-total">💰 Total estimado: €${total.toFixed(2)}</div>`;

    resumoDiv.innerHTML = html;
}

// --- VALIDAÇÃO DA DATA ---
// Define o mínimo como hoje + 7 dias no campo de data.
// Também valida quando o utilizador sai do campo (blur).
function inicializarValidacaoData() {
    const campoData = document.getElementById('birthday');
    if (!campoData) return;

    // Define o atributo "min" do input para não deixar escolher datas passadas
    const hoje       = new Date();
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    campoData.min = dataMinima.toISOString().split('T')[0]; // Formato: AAAA-MM-DD

    // Valida quando o utilizador sai do campo
    campoData.addEventListener('blur', function() {
        if (!campoData.value) return;

        const dataSelecionada = new Date(campoData.value + 'T00:00:00');
        const minima          = new Date();
        minima.setHours(0, 0, 0, 0);
        minima.setDate(minima.getDate() + 7);

        if (dataSelecionada < minima) {
            alert('A data do evento tem de ser pelo menos 7 dias a partir de hoje.');
            campoData.value = ''; // Limpa a data inválida
            atualizarResumo();
        }
    });

    campoData.addEventListener('change', atualizarResumo);
}

// --- LIMPAR FORMULÁRIO ---
// Quando o utilizador clica em "Limpar Pedido", confirma e limpa tudo.
function inicializarBotaoLimpar() {
    const btnLimpar = document.getElementById('btn-limpar-pedido');
    if (!btnLimpar) return;

    btnLimpar.addEventListener('click', function() {
        if (!confirm('Tens a certeza que queres limpar todos os campos?')) return;

        document.querySelector('form')?.reset(); // Limpa todos os campos do formulário

        // Volta ao estado inicial do resumo
        const resumoDiv = document.getElementById('resumo-content');
        if (resumoDiv) {
            resumoDiv.innerHTML = '<p class="resumo-vazio">Preenche os campos para ver o resumo...</p>';
        }
    });
}

// --- MONITORAR CAMPOS PARA ATUALIZAR RESUMO ---
// Cada vez que qualquer campo muda, o resumo é recalculado.
function inicializarListeners() {
    const camposAMonitorar = ['tamanho', 'massa', 'recheio', 'birthday', 'observacoes'];

    camposAMonitorar.forEach(function(id) {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener('change', atualizarResumo);
            campo.addEventListener('input',  atualizarResumo);
        }
    });
}

// --- MOSTRAR DECORAÇÃO CORRETA CONFORME A CATEGORIA DO BOLO ---
// A categoria vem do PHP via atributo data-category no HTML.
// Assim, cada tipo de bolo (casamento, aniversário, batizado) mostra
// as suas próprias opções de decoração.
function mostrarDecoracaoCorreta() {
    const categoria = document.querySelector('.bcontainer')?.dataset?.category || '';

    const decoracoes = {
        'casamento'   : document.getElementById('decoracao-casamento'),
        'aniversario' : document.getElementById('decoracao-aniversario'),
        'batizado'    : document.getElementById('decoracao-batizado'),
    };

    // Esconde todas as decorações
    Object.values(decoracoes).forEach(function(el) {
        if (el) el.style.display = 'none';
    });

    // Mostra só a da categoria atual
    if (decoracoes[categoria]) {
        decoracoes[categoria].style.display = 'block';
    }
}

// --- INICIALIZAÇÃO ---
// Quando a página carrega, ativa todas as funcionalidades acima.
document.addEventListener('DOMContentLoaded', function() {
    mostrarDecoracaoCorreta();
    inicializarValidacaoData();
    inicializarBotaoLimpar();
    inicializarListeners();
});