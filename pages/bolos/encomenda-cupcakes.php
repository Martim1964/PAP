<?php
// ============================================================
// FICHEIRO: pages/bolos/encomenda-cupcakes.php
// O QUE FAZ: Página de encomenda para cupcakes e doces
// tradicionais. Mostra o produto escolhido e o formulário
// para selecionar o pack e a data do evento.
// ============================================================

// Precisamos do carrinho para usar dd_csrf_token() e dd_start_session()
require_once __DIR__ . '/../../includes/carrinho.php';
//Para ir buscar as funções com os dados implementados na base de dados
require_once __DIR__ . '/../../includes/db.php';

dd_start_session();

// Se não está logado, redireciona para login
if (!isset($_SESSION['user'])) {
    $redirectTarget = 'bolos/encomenda-cupcakes.php?bolo=' . urlencode($bolo_id);
    header('Location: ../login.php?redirect=' . urlencode($redirectTarget));
    exit;
}

// --- BUSCAR O BOLO DA BASE DE DADOS ---
$bolo_id  = $_GET['bolo'] ?? null;
$bolo_sel = $bolo_id ? buscar_bolo($con, $bolo_id) : null;

// Se o bolo não existe, redireciona
if (!$bolo_sel) {
    header('Location: ../encomende.php');
    exit;
}

// --- BUSCAR OPÇÕES DA BASE DE DADOS ---
$tamanhos = buscar_tamanhos($con, $bolo_id);


// Verifico se o ID do bolo contém as palavras 'bolachas' ou 'brigadeiros'.
// O strpos retorna a posição da palavra ou 'false' se não encontrar nada.
$is_pack = (strpos($bolo_id, 'bolachas') !== false || strpos($bolo_id, 'brigadeiros') !== false);

// Se for um pack (bolachas/brigadeiros), o título será 'Quantidade'.
// Caso contrário (tortas/bolos de bolacha), o título será 'Tamanho'.
$titulo_secao = $is_pack ? 'Quantidade' : 'Tamanho';

// Definir categoria
$category = 'cupcakes';


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/encomenda-cupcakes.css">
    <title>Encomendar <?= htmlspecialchars($bolo_sel['nome']) ?> - Doces Dias</title>
</head>
<body>
<?php include '../../includes/header-bolos.php'; ?>

<?php $flash = dd_flash_get(); ?>

<div class="bcontainer" data-category="<?= htmlspecialchars($category) ?>">

    <!-- Mensagem de erro ou sucesso (se vier da action) -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['tipo'] === 'danger' ? 'danger' : 'success' ?> mt-3" role="alert">
            <?= htmlspecialchars($flash['mensagem']) ?>
        </div>
    <?php endif; ?>

    <!-- CABEÇALHO -->
    <div class="title">
        <h1>Encomendar: <?= htmlspecialchars($bolo_sel['nome']) ?></h1>
        <p class="subtitle">Após o pedido, entraremos em contacto para confirmar todos os detalhes</p>
    </div>

    <!-- CARD DO PRODUTO -->
    <div class="cake-overview">
        <img src="../../<?= htmlspecialchars($bolo_sel['imagem']) ?>" alt="<?= htmlspecialchars($bolo_sel['nome']) ?>">
        <div class="cake-overview-info">
            <h3><?= htmlspecialchars($bolo_sel['nome']) ?></h3>
            <p><?= htmlspecialchars($bolo_sel['descricao']) ?></p>
        </div>
    </div>

    <!-- FORMULÁRIO DE ENCOMENDA -->
    <div class="personalize-form">
        <form method="post" action="../../actions/adicionar_carrinho_cupcakes.php">

            <!-- Campos hidden: identificam o produto e protegem o formulário -->
            <input type="hidden" name="bolo_id"    value="<?= htmlspecialchars($bolo_id) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
            <input type="hidden" name="quantidade" value="1">

            <div class="grid-container">
                <div class="coluna-esquerda">
                    <section class="form-section">
                    <!-- Vai buscar os dados postos na variável com o titulo,
                     podendo ser quantidade ou tamanho conforme o doce em questão -->
                    <h2>1. <?= $titulo_secao ?></h2> 
                    
                    <select id="tamanho" name="tamanho" required>
                        <option value="">Escolha uma opção...</option>
                        <!-- Inicio um ciclo foreach para percorrer o array de tamanhos/packs vindos da BD -->
                            <?php foreach ($tamanhos as $slug => $t): ?>
                                <!-- Crio uma tag <option> para dropdown onde o 'value' recebe o slug da BD -->
                                <option value="<?= htmlspecialchars($slug) ?>">
                                    
                                    <!-- Escrevemos o texto que o utilizador vê (ex: Pack 6 unidades).
                                        Concatenamos com o símbolo do Euro e formatamos o preço com 2 casas decimais, 
                                        usando a vírgula para os cêntimos e o ponto para os milhares. -->
                                    <?= htmlspecialchars($t['label']) ?> - €<?= number_format($t['preco'], 2, ',', '.') ?>

                                </option>
                            <?php endforeach; ?>
                    </select>
                </section>

                    <!-- 2. DATA DO EVENTO -->
                    <section class="form-section">
                        <h2>2. Data do Evento</h2>
                        <label for="birthday">Data do evento (mín. 7 dias):</label>
                        <input type="date" id="birthday" name="birthday" required>
                    </section>

                    <!-- 3. OBSERVAÇÕES -->
                    <section class="form-section">
                        <h2>3. Observações</h2>
                        <label for="observacoes">Informações adicionais (alergias, preferências, etc.):</label>
                        <textarea id="observacoes" name="observacoes" rows="4" placeholder="Descreve detalhes importantes..."></textarea>
                    </section>

                </div>

                <div class="coluna-direita">

                    <!-- RESUMO DO PEDIDO (atualizado em tempo real pelo JS) -->
                    <section class="form-section resumo-section" id="resumo-pedido-box">
                        <h2>Resumo do Pedido</h2>

                        <div id="resumo-content">
                            <p class="resumo-vazio">Preencha os campos para ver o resumo...</p>
                        </div>

                        <!-- BOTÕES -->
                        <div class="button-group">
                            <button type="button" class="btn-secondary" id="btn-limpar-pedido">Limpar Pedido</button>
                            <button type="submit" class="btn-primary">Adicionar ao Carrinho</button>
                        </div>

                    </section>

                </div>
            </div>

        </form>
    </div>
</div>

<script src="../../js/encomenda-cupcakes.js?v=1.1"></script>
<?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>