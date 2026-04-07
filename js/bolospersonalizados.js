// ============================================================
//  Doces Dias – bolospersonalizados.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // ===== 1. VALIDAÇÃO DE DATA (mínimo 7 dias) =====
    const dataInput = document.getElementById('birthday');

    const hoje = new Date();
    const dataMinima = new Date(hoje);
    dataMinima.setDate(hoje.getDate() + 7);
    dataInput.min = dataMinima.toISOString().split('T')[0];

    dataInput.addEventListener('blur', function () {
        if (!dataInput.value || dataInput.value.length < 10) return;

        const dataSelecionada = new Date(dataInput.value);
        if (isNaN(dataSelecionada.getTime())) return;

        const limite = new Date();
        limite.setHours(0, 0, 0, 0);
        limite.setDate(limite.getDate() + 7);
        dataSelecionada.setHours(0, 0, 0, 0);

        if (dataSelecionada < limite) {
            alert('⚠️ A data do evento deve ser marcada com pelo menos 7 dias de antecedência.');
            dataInput.value = '';
            atualizarResumo();
        }
    });


    // ===== 2. VALIDAÇÃO E PRÉ-VISUALIZAÇÃO DA IMAGEM =====
    const inputImagem     = document.getElementById('imagem');
    const mensagemErro    = document.getElementById('mensagemErro');
    const mensagemSucesso = document.getElementById('mensagemSucesso');
    const preview         = document.getElementById('preview');
    const imagemPreview   = document.getElementById('imagemPreview');
    const btnLimparImg    = document.getElementById('btn-limpar-img');

    inputImagem.addEventListener('change', function (e) {
        const arquivo = e.target.files[0];

        mensagemErro.style.display    = 'none';
        mensagemSucesso.style.display = 'none';
        preview.style.display         = 'none';

        if (!arquivo) return;

        const extensao = arquivo.name.split('.').pop().toLowerCase();
        if (extensao !== 'png' || arquivo.type !== 'image/png') {
            mensagemErro.textContent   = '❌ Por favor, selecione apenas imagens no formato PNG.';
            mensagemErro.style.display = 'block';
            inputImagem.value          = '';
            return;
        }

        if (arquivo.size > 5 * 1024 * 1024) {
            mensagemErro.textContent   = '❌ A imagem é muito grande. O tamanho máximo é 5MB.';
            mensagemErro.style.display = 'block';
            inputImagem.value          = '';
            return;
        }

        mensagemSucesso.textContent    = '✅ Imagem PNG válida!';
        mensagemSucesso.style.display  = 'block';

        const reader = new FileReader();
        reader.onload = function (e) {
            imagemPreview.src     = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(arquivo);

        atualizarResumo();
    });

    btnLimparImg.addEventListener('click', function () {
        inputImagem.value             = '';
        preview.style.display         = 'none';
        mensagemErro.style.display    = 'none';
        mensagemSucesso.style.display = 'none';
        imagemPreview.src             = '';
        atualizarResumo();
    });


    // ===== 3. TABELA DE PREÇOS =====
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
            mascarpone:  10,
            framboesa:   12,
            maracuja:    12
        },
        decoracao: 15
    };

    function calcularPrecoTotal() {
        let total = 0;
        total += precos.tamanho[document.getElementById('tamanho').value] || 0;
        total += precos.massa[document.getElementById('massa').value]     || 0;
        total += precos.recheio[document.getElementById('recheio').value] || 0;
        if (document.getElementById('tema-festa').value) total += precos.decoracao;
        return total;
    }


    // ===== 4. RESUMO DO PEDIDO EM TEMPO REAL =====
    function atualizarResumo() {
        const tamanho     = document.getElementById('tamanho');
        const massa       = document.getElementById('massa');
        const recheio     = document.getElementById('recheio');
        const data        = document.getElementById('birthday');
        const tema        = document.getElementById('tema-festa');
        const observacoes = document.getElementById('observacoes');
        const imagem      = document.getElementById('imagem');
        const resumoContent = document.getElementById('resumo-content');

        if (!tamanho.value || !data.value || !tema.value) {
            resumoContent.innerHTML = '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
            return;
        }

        const precoTotal = calcularPrecoTotal();
        let html = '';

        html += '<div class="resumo-item">';
        html += '<h3>Detalhes do Bolo</h3>';
        html += `<p><strong>Tamanho:</strong> ${tamanho.options[tamanho.selectedIndex].text}</p>`;
        html += `<p><strong>Massa:</strong> ${massa.options[massa.selectedIndex].text}</p>`;
        html += `<p><strong>Recheio:</strong> ${recheio.options[recheio.selectedIndex].text}</p>`;
        html += '</div>';

        const [ano, mes, dia] = data.value.split('-');
        html += '<div class="resumo-item">';
        html += '<h3>Informações do Evento</h3>';
        html += `<p><strong>Data:</strong> ${dia}/${mes}/${ano}</p>`;
        html += `<p><strong>Tipo de evento:</strong> ${tema.options[tema.selectedIndex].text}</p>`;
        html += `<p><strong>Decoração temática:</strong> incluída (+€${precos.decoracao})</p>`;
        html += '</div>';

        if (observacoes.value.trim()) {
            html += '<div class="resumo-item">';
            html += '<h3>Observações</h3>';
            html += `<p>${observacoes.value}</p>`;
            html += '</div>';
        }

        if (imagem.files.length > 0) {
            html += '<div class="resumo-item">';
            html += '<h3>Imagem de Referência</h3>';
            html += `<p>${imagem.files[0].name}</p>`;
            html += '<p style="font-size:0.85rem;color:#666;">A imagem será analisada pela equipa e o orçamento final enviado por email.</p>';
            html += '</div>';
        }

        html += '<div class="resumo-total">';
        html += `<h2>Estimativa: €${precoTotal.toFixed(2)}</h2>`;
        html += '<p style="font-size:0.8rem;color:#888;">*O valor final pode variar conforme a decoração pedida.</p>';
        html += '</div>';

        resumoContent.innerHTML = html;
    }


    // ===== 5. LIMPAR PEDIDO COMPLETO =====
    document.getElementById('btn-limpar-pedido').addEventListener('click', function () {
        if (!confirm('Tem a certeza que deseja limpar todos os campos?')) return;

        document.querySelector('form').reset();

        preview.style.display         = 'none';
        mensagemErro.style.display    = 'none';
        mensagemSucesso.style.display = 'none';
        imagemPreview.src             = '';

        document.getElementById('resumo-content').innerHTML =
            '<p class="resumo-vazio">Preencha os campos para ver o resumo...</p>';
    });


    // ===== 6. MONITORAR CAMPOS PARA ATUALIZAR O RESUMO =====
    ['tamanho', 'massa', 'recheio', 'birthday', 'tema-festa', 'observacoes'].forEach(function (id) {
        const campo = document.getElementById(id);
        if (campo) {
            campo.addEventListener('change', atualizarResumo);
            campo.addEventListener('input',  atualizarResumo);
        }
    });

}); 