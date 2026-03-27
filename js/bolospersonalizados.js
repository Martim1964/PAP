// ===== VALIDAÇÃO DE DATA =====
const dataInput = document.getElementById('birthday');

function validarData() {
    // Só valida se o campo tiver uma data completa
    if (!dataInput.value || dataInput.value.length < 10) {
        return true; // Não valida se a data ainda não está completa
    }
    
    const dataSelecionada = new Date(dataInput.value);
    const hoje = new Date();
    
    // Verifica se é uma data válida
    if (isNaN(dataSelecionada.getTime())) {
        return true; // Não valida se a data for inválida (ainda a escrever)
    }
    
    hoje.setHours(0, 0, 0, 0);
    dataSelecionada.setHours(0, 0, 0, 0);
    
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    
    if (dataSelecionada < dataMinima) {
        alert('Por favor, insira uma data válida. O evento deve ser agendado com pelo menos 7 dias de antecedência.');
        dataInput.value = '';
        return false;
    }
    
    return true;
}

// Usar 'blur' em vez de 'change' - só valida quando sair do campo
dataInput.addEventListener('blur', validarData);

// Definir data mínima no campo (validação HTML5)
const hoje = new Date();
const dataMinima = new Date(hoje);
dataMinima.setDate(hoje.getDate() + 7);
dataInput.min = dataMinima.toISOString().split('T')[0];

// ===== MOSTRAR/OCULTAR SEÇÕES CONDICIONAIS =====
const temaSelect = document.getElementById('tema-festa');
const outrasOcasioes = document.getElementById('outras-ocasioes');
const decoracaoCasamento = document.getElementById('decoracao-casamento');
const decoracaoAniversario = document.getElementById('decoracao-aniversario');
const decoracaoBatizado = document.getElementById('decoracao-batizado');

function atualizarSecoesTema() {
    // Ocultar todas as seções condicionais
    outrasOcasioes.style.display = 'none';
    decoracaoCasamento.style.display = 'none';
    decoracaoAniversario.style.display = 'none';
    decoracaoBatizado.style.display = 'none';

    const temaSelecionado = temaSelect.value;

    // Mostrar a seção apropriada
    switch(temaSelecionado) {
        case 'outro':
            outrasOcasioes.style.display = 'block';
            break;
        case 'casamento':
            decoracaoCasamento.style.display = 'block';
            break;
        case 'aniversario':
            decoracaoAniversario.style.display = 'block';
            break;
        case 'batizado':
            decoracaoBatizado.style.display = 'block';
            break;
    }
    
    // Atualizar resumo após mudança de tema
    atualizarResumo();
}

temaSelect.addEventListener('change', atualizarSecoesTema);

// ===== VALIDAÇÃO E PREVIEW DE IMAGEM =====
const inputImagem = document.getElementById('imagem');
const mensagemErro = document.getElementById('mensagemErro');
const mensagemSucesso = document.getElementById('mensagemSucesso');
const preview = document.getElementById('preview');
const imagemPreview = document.getElementById('imagemPreview');
const btnLimparImg = document.getElementById('btn-limpar-img');

inputImagem.addEventListener('change', function(e) {
    const arquivo = e.target.files[0];
    
    mensagemErro.style.display = 'none';
    mensagemSucesso.style.display = 'none';
    preview.style.display = 'none';
    
    if (!arquivo) {
        return;
    }
    
    const extensao = arquivo.name.split('.').pop().toLowerCase();
    const tipoPNG = arquivo.type === 'image/png';
    
    if (extensao !== 'png' || !tipoPNG) {
        mensagemErro.textContent = '❌ Por favor, selecione apenas imagens no formato PNG.';
        mensagemErro.style.display = 'block';
        inputImagem.value = '';
        return;
    }
    
    const tamanhoMaximo = 5 * 1024 * 1024;
    if (arquivo.size > tamanhoMaximo) {
        mensagemErro.textContent = '❌ A imagem é muito grande. O tamanho máximo é 5MB.';
        mensagemErro.style.display = 'block';
        inputImagem.value = '';
        return;
    }
    
    mensagemSucesso.textContent = '✓ Imagem PNG válida!';
    mensagemSucesso.style.display = 'block';
    
    const reader = new FileReader();
    reader.onload = function(e) {
        imagemPreview.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(arquivo);
});

// Botão Limpar Imagem
btnLimparImg.addEventListener('click', function() {
    inputImagem.value = '';
    preview.style.display = 'none';
    mensagemErro.style.display = 'none';
    mensagemSucesso.style.display = 'none';
    imagemPreview.src = '';
});

// ===== TABELA DE PREÇOS =====
const precos = {
    tamanho: {
        pequeno: 25,
        medio: 35,
        grande: 50,
        muito_grande: 70
    },
    massa: {
        baunilha: 0,
        laranja_canela: 0,
        papoila_limao: 0,
        chocolate: 10,
        red_velvet: 12,
        cenoura: 8
    },
    recheio: {
        caramelo: 0,
        morango: 0,
        limao: 0,
        creamcheese: 0,
        brigadeiro: 8,
        mascarpone: 10,
        framboesa: 12,
        maracuja: 12
    },
    decoracao: 15
};

function calcularPrecoTotal() {
    let total = 0;
    
    const tamanho = document.getElementById('tamanho').value;
    total += precos.tamanho[tamanho] || 0;
    
    const massa = document.getElementById('massa').value;
    total += precos.massa[massa] || 0;
    
    const recheio = document.getElementById('recheio').value;
    total += precos.recheio[recheio] || 0;
    
    const tema = document.getElementById('tema-festa').value;
    if (tema && tema !== '') {
        total += precos.decoracao;
    }
    
    return total;
}

// ===== ATUALIZAR RESUMO AUTOMATICAMENTE =====
function atualizarResumo() {
    const tamanho = document.getElementById('tamanho');
    const massa = document.getElementById('massa');
    const recheio = document.getElementById('recheio');
    const data = document.getElementById('birthday');
    const tema = document.getElementById('tema-festa');
    const ocasiao = document.getElementById('ocasiao');
    const idade = document.getElementById('idade');
    const observacoes = document.getElementById('observacoes');
    const imagem = document.getElementById('imagem');
    
    const resumoContent = document.getElementById('resumo-content');
    
    // Se os campos principais não estão preenchidos, mostrar mensagem vazia
    if (!tamanho.value || !massa.value || !recheio.value || !data.value || !tema.value) {
        resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
        return;
    }
    
    const precoTotal = calcularPrecoTotal();
    
    // Construir HTML do resumo
    let html = '';
    
    // Detalhes do Bolo
    html += '<div class="resumo-item">';
    html += '<h3>Detalhes do Bolo</h3>';
    html += `<p><strong>Tamanho:</strong> ${tamanho.options[tamanho.selectedIndex].text}</p>`;
    html += `<p><strong>Massa:</strong> ${massa.options[massa.selectedIndex].text}</p>`;
    html += `<p><strong>Recheio:</strong> ${recheio.options[recheio.selectedIndex].text}</p>`;
    html += '</div>';
    
    // Informações do Evento
    html += '<div class="resumo-item">';
    html += '<h3>Informações do Evento</h3>';
    html += `<p><strong>Data:</strong> ${new Date(data.value).toLocaleDateString('pt-PT')}</p>`;
    html += `<p><strong>Tema:</strong> ${tema.options[tema.selectedIndex].text}</p>`;
    if (ocasiao && ocasiao.value) {
        html += `<p><strong>Ocasião:</strong> ${ocasiao.value}</p>`;
    }
    if (idade && idade.value) {
        html += `<p><strong>Idade:</strong> ${idade.value} anos</p>`;
    }
    if (tema.value && tema.value !== '') {
        html += `<p><strong>Decoração:</strong> Incluída (+€${precos.decoracao})</p>`;
    }
    html += '</div>';
    
    // Observações (se existirem)
    if (observacoes.value) {
        html += '<div class="resumo-item">';
        html += '<h3>Observações</h3>';
        html += `<p>${observacoes.value}</p>`;
        html += '</div>';
    }
    
    // Imagem (se existir)
    if (imagem.files.length > 0) {
        html += '<div class="resumo-item">';
        html += '<h3>📷 Imagem de Referência</h3>';
        html += `<p>✓ ${imagem.files[0].name}</p>`;
        html += '<p style="font-size: 0.85rem; color: #666;">A imagem será analisada e o orçamento final será enviado por email.</p>';
        html += '</div>';
    }
    
    // Total
    html += '<div class="resumo-total">';
    html += `<h2>💰 Total: €${precoTotal.toFixed(2)}</h2>`;
    html += '</div>';
    
    resumoContent.innerHTML = html;
}

// ===== LIMPAR PEDIDO =====
document.getElementById('btn-limpar-pedido').addEventListener('click', function() {
    if (confirm('Tem certeza que deseja limpar todos os campos do pedido?')) {
        document.querySelector('form').reset();
        document.getElementById('preview').style.display = 'none';
        document.getElementById('mensagemErro').style.display = 'none';
        document.getElementById('mensagemSucesso').style.display = 'none';
        document.getElementById('imagemPreview').src = '';
        
        // Ocultar seções condicionais
        document.getElementById('outras-ocasioes').style.display = 'none';
        document.getElementById('decoracao-casamento').style.display = 'none';
        document.getElementById('decoracao-aniversario').style.display = 'none';
        document.getElementById('decoracao-batizado').style.display = 'none';
        
        // Limpar resumo
        document.getElementById('resumo-content').innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
    }
});

// ===== EVENTOS PARA ATUALIZAR RESUMO EM TEMPO REAL =====
document.addEventListener('DOMContentLoaded', function() {
    const camposParaMonitorar = [
        'tamanho', 'massa', 'recheio', 'birthday', 'tema-festa', 
        'ocasiao', 'idade', 'observacoes'
    ];
    
    camposParaMonitorar.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.addEventListener('change', atualizarResumo);
            campo.addEventListener('input', atualizarResumo);
        }
    });
    
    // Monitorar mudanças na imagem
    document.getElementById('imagem').addEventListener('change', atualizarResumo);
});