<?php
// ============================================================
// FICHEIRO: pages/bolos/encomenda.php
// O QUE FAZ: Página de encomenda para bolos normais
// (aniversário, casamento, batizado).
// Os tamanhos, massas e recheios vêm da base de dados.
// ============================================================

require_once __DIR__ . '/../../includes/carrinho.php';
require_once __DIR__ . '/../../includes/db.php';

dd_start_session();
require_once __DIR__ . '/../../includes/verificar_ativo.php';

// --- BUSCAR O BOLO DA BASE DE DADOS ---
$bolo_id  = $_GET['bolo'] ?? null;
$bolo_sel = $bolo_id ? buscar_bolo($con, $bolo_id) : null;

// Se o bolo não existe, redireciona
if (!$bolo_sel) {
    header('Location: ../encomende.php');
    exit;
}

// Se não está logado, redireciona para login
if (!isset($_SESSION['user'])) {
    $redirectTarget = 'bolos/encomenda.php?bolo=' . urlencode($bolo_id);
    header('Location: ../login.php?redirect=' . urlencode($redirectTarget));
    exit;
}

// --- BUSCAR OPÇÕES DA BASE DE DADOS ---
$tamanhos = buscar_tamanhos($con, $bolo_id);
$massas   = buscar_massas($con);
$recheios = buscar_recheios($con);

$category = 'outros';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/encomenda.css">
    <title>Encomendar <?= htmlspecialchars($bolo_sel['nome']) ?> - Doces Dias</title>
</head>
<body>
<?php include '../../includes/header-bolos.php'; ?>

<main>

<?php $flash = dd_flash_get(); ?>

<div class="bcontainer" data-category="<?= htmlspecialchars($category) ?>">

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

    <!-- CARD DO BOLO -->
    <div class="cake-overview">
        <img src="../../<?= htmlspecialchars($bolo_sel['imagem']) ?>" alt="<?= htmlspecialchars($bolo_sel['nome']) ?>">
        <div class="cake-overview-info">
            <h3><?= htmlspecialchars($bolo_sel['nome']) ?></h3>
            <p><?= htmlspecialchars($bolo_sel['descricao']) ?></p>
        </div>
    </div>

    <!-- FORMULÁRIO -->
    <div class="personalize-form">
        <form method="post" action="../../actions/adicionar_carrinho.php">

            <input type="hidden" name="bolo_id"    value="<?= htmlspecialchars($bolo_id) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
            <input type="hidden" name="quantidade" value="1">

            <div class="grid-container">
                <div class="coluna-esquerda">

                    <!-- 1. TAMANHO — gerado dinamicamente da BD -->
                    <section class="form-section">
                        <h2>1. Tamanho do Bolo</h2>
                        <select id="tamanho" name="tamanho" aria-label="Tamanho" required>
                            <option value="">Escolha um tamanho...</option>
                            <?php foreach ($tamanhos as $slug => $dados): ?>
                                <option value="<?= htmlspecialchars($slug) ?>">
                                    <?= htmlspecialchars($dados['label']) ?> - €<?= dd_formata_preco($dados['preco']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </section>

                    <!-- 2. MASSA — gerado dinamicamente da BD -->
                    <section class="form-section">
                        <h2>2. Tipo de Massa</h2>
                        <select id="massa" name="massa" aria-label="Massa" required>
                            <option value="">Escolha uma massa...</option>
                            <optgroup label="Massas Standard">
                                <?php foreach ($massas as $slug => $dados): ?>
                                    <?php if (!$dados['premium']): ?>
                                        <option value="<?= htmlspecialchars($slug) ?>">
                                            <?= htmlspecialchars($dados['label']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Massas Premium (+)">
                                <?php foreach ($massas as $slug => $dados): ?>
                                    <?php if ($dados['premium']): ?>
                                        <option value="<?= htmlspecialchars($slug) ?>">
                                            <?= htmlspecialchars($dados['label']) ?> (+€<?= dd_formata_preco($dados['preco']) ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </section>

                    <!-- 3. RECHEIO — gerado dinamicamente da BD -->
                    <section class="form-section">
                        <h2>3. Tipo de Recheio</h2>
                        <select id="recheio" name="recheio" aria-label="Recheio" required>
                            <option value="">Escolha um recheio...</option>
                            <optgroup label="Recheios Standard">
                                <?php foreach ($recheios as $slug => $dados): ?>
                                    <?php if (!$dados['premium']): ?>
                                        <option value="<?= htmlspecialchars($slug) ?>">
                                            <?= htmlspecialchars($dados['label']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Recheios Premium (+)">
                                <?php foreach ($recheios as $slug => $dados): ?>
                                    <?php if ($dados['premium']): ?>
                                        <option value="<?= htmlspecialchars($slug) ?>">
                                            <?= htmlspecialchars($dados['label']) ?> (+€<?= dd_formata_preco($dados['preco']) ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </section>

                    <!-- Sugestões de combinações -->
                    <section class="form-section suggestions-box">
                        <h2>Sugestões de Combinações</h2>
                        <div class="suggestions-grid">
                            <div class="suggestion-card">
                                <h3>Standard</h3>
                                <ul>
                                    <li>Baunilha + Caramelo</li>
                                    <li>Papoila + Limão</li>
                                </ul>
                            </div>
                            <div class="suggestion-card">
                                <h3>Premium</h3>
                                <ul>
                                    <li>Chocolate + Brigadeiro</li>
                                    <li>Red Velvet + Mascarpone</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- 4. DATA DO EVENTO -->
                    <section class="form-section">
                        <h2>4. Data do Evento</h2>
                        <label for="birthday">Data do evento (mín. 7 dias):</label>
                        <input type="date" id="birthday" name="birthday" aria-label="Event Date" required>
                    </section>

                    <!-- 5. OBSERVAÇÕES -->
                    <section class="form-section">
                        <h2>5. Observações Especiais</h2>
                        <label for="observacoes">Informações adicionais (alergias, preferências, etc.):</label>
                        <textarea id="observacoes" name="observacoes" rows="4" placeholder="Descreve detalhes importantes..."></textarea>
                    </section>

                </div>

                <div class="coluna-direita">

                    <!-- RESUMO DO PEDIDO -->
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

<!-- Passa os preços da BD para o JavaScript -->
<script>
    // Os preços vêm do PHP (base de dados) para o JavaScript
    // O JS usa-os só para mostrar o resumo visual em tempo real
    const precosDB = {
        tamanho: <?= json_encode(array_map(fn($t) => $t['preco'], $tamanhos)) ?>,
        massa:   <?= json_encode(array_map(fn($m) => $m['preco'], $massas)) ?>,
        recheio: <?= json_encode(array_map(fn($r) => $r['preco'], $recheios)) ?>
    };
</script>
<script src="../../js/encomenda.js"></script>
<?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>