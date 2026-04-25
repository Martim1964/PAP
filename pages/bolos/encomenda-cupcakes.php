<?php
// ============================================================
// FICHEIRO: pages/bolos/encomenda-cupcakes.php
// O QUE FAZ: Pagina de encomenda para cupcakes e doces
// tradicionais. Mostra o produto escolhido e o formulario
// para selecionar o pack/tamanho e a data do evento.
// ============================================================

require_once __DIR__ . '/../../includes/carrinho.php';
require_once __DIR__ . '/../../includes/db.php';

dd_start_session();
require_once __DIR__ . '/../../includes/verificar_ativo.php';

// --- BUSCAR O BOLO DA BASE DE DADOS ---
$bolo_id  = $_GET['bolo'] ?? null;
$bolo_sel = $bolo_id ? buscar_bolo($con, $bolo_id) : null;

// Se nao esta logado, redireciona para login
if (!isset($_SESSION['user'])) {
    $redirectTarget = 'bolos/encomenda-cupcakes.php?bolo=' . urlencode($bolo_id);
    header('Location: ../login.php?redirect=' . urlencode($redirectTarget));
    exit;
}

// Se o bolo nao existe, redireciona
if (!$bolo_sel) {
    header('Location: ../encomende.php');
    exit;
}

// --- BUSCAR OPCOES DA BASE DE DADOS ---
$tamanhos = buscar_tamanhos($con, $bolo_id);

// Verifico se o id do bolo contém as palavras 'bolachas' ou 'brigadeiros'
// O strpos retorna a posição da palavra ou 'false' se nao encontrar nada
$is_pack = (strpos($bolo_id, 'bolachas') !== false || strpos($bolo_id, 'brigadeiros') !== false);

//Se for um pack (bolachas/brigadeiros) o titulo será quantidade
//Caso contrario (tortas/bolo de bolacha) o titulo será tamanho
$titulo_secao = $is_pack ? 'Quantidade' : 'Tamanho';

//Define a categoria
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

<main>


<div class="bcontainer" data-category="<?= htmlspecialchars($category) ?>">

    <div class="title">
        <h1>Encomendar: <?= htmlspecialchars($bolo_sel['nome']) ?></h1>
        <p class="subtitle">Apos o pedido, entraremos em contacto para confirmar todos os detalhes</p>
    </div>

    <div class="cake-overview">
        <img src="../../<?= htmlspecialchars($bolo_sel['imagem']) ?>" alt="<?= htmlspecialchars($bolo_sel['nome']) ?>">
        <div class="cake-overview-info">
            <h3><?= htmlspecialchars($bolo_sel['nome']) ?></h3>
            <p><?= htmlspecialchars($bolo_sel['descricao']) ?></p>
        </div>
    </div>

    <div class="personalize-form">
        <form method="post" action="../../actions/adicionar_carrinho_cupcakes.php">
            <input type="hidden" name="bolo_id" value="<?= htmlspecialchars($bolo_id) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
            <input type="hidden" name="quantidade" value="1">

            <div class="grid-container">
                <div class="coluna-esquerda">
                    <section class="form-section">
                        <!-- Vai buscar os dados postos na variavel com o titulo,
                         podendo ser quantidade ou tamanho conforme o doce -->
                        <h2>1. <?= htmlspecialchars($titulo_secao) ?></h2>


                        <select id="tamanho" name="tamanho" aria-label = "Tamanho" required>
                            <option value="">Escolha uma opcao...</option>
                            <!--Inicio um foreach para percorrer o array de tamanhos / packs da BD -->
                            <?php foreach ($tamanhos as $slug => $t): ?>
                                <!-- Crio uma <option> para dropdown onde o value receber o slug da BD -->
                                <option value="<?= htmlspecialchars($slug) ?>">

                                    <!-- Escrevemos o texto que o user ve (ex: pack 6 unidades).
                                     Concatenamos com o euro e formatamos o preco com 2 c.d
                                     usando a virgula para os centimos e o ponto para os milhares -->
                                    <?= htmlspecialchars($t['label']) ?> - €<?= dd_formata_preco($t['preco']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </section>

                    <section class="form-section">
                        <h2>2. Data do Evento</h2>
                        <label for="birthday">Data do evento (min. 7 dias):</label>
                        <input type="date" id="birthday" name="birthday" aria-label="Event Date" required>
                    </section>

                    <section class="form-section">
                        <h2>3. Observacoes</h2>
                        <label for="observacoes">Informacoes adicionais (alergias, preferencias, etc.):</label>
                        <textarea id="observacoes" name="observacoes" rows="4" placeholder="Descreve detalhes importantes..."></textarea>
                    </section>
                </div>

                <div class="coluna-direita">
                    <section class="form-section resumo-section" id="resumo-pedido-box">
                        <h2>Resumo do Pedido</h2>

                        <div id="resumo-content">
                            <p class="resumo-vazio">Preenche os campos para ver o resumo...</p>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-secondary" id="btn-limpar-pedido" aria-label="Reset">Limpar Pedido</button>
                            <button type="submit" class="btn-primary" aria-label="Add to Cart">Adicionar ao Carrinho</button>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </div>
</div>

</main>

<script>
    window.precosCupcakesDB = <?= json_encode(array_map(fn($t) => $t['preco'], $tamanhos)) ?>;
</script>
<script src="../../js/encomenda-cupcakes.js?v=1.3"></script>
<?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>
