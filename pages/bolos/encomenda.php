<?php
declare(strict_types=1);

// =========================================================
// PAGINA DE ENCOMENDA
// Mostra um bolo do catalogo e recolhe a configuracao
// que depois sera enviada para o carrinho.
// =========================================================

require_once __DIR__ . '/../../includes/carrinho.php';

dd_start_session();

$bolos = dd_catalogo_bolos();

// ==========================================
// LÊ O PARÂMETRO ?bolo= DA URL
// ==========================================

$bolo_id  = $_GET['bolo'] ?? null;
$bolo_sel = ($bolo_id && isset($bolos[$bolo_id])) ? $bolos[$bolo_id] : null;
$category = $bolo_sel['categoria'] ?? 'outro';

// Se não existe esse bolo, redireciona
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
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Import Bootstrap JavaScript functionality - navbar-->
    <link rel="stylesheet" href="../../css/encomenda.css">
    <title>Encomendar <?= htmlspecialchars($bolo_sel['nome']) ?> - Doces Dias</title>
</head>
<body>
<?php include '../../includes/header-bolos.php'; ?>

<?php $flash = dd_flash_get(); ?>

<div class="bcontainer" data-category="<?= htmlspecialchars($category) ?>">
    <?php if ($flash): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type'] === 'danger' ? 'danger' : 'success') ?> mt-3" role="alert">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <!-- CABEÇALHO COM INFO DO BOLO ESCOLHIDO -->
    <div class="title">
        <h1>Encomendar: <?= htmlspecialchars($bolo_sel['nome']) ?></h1>
        <p class="subtitle">Após o pedido, entraremos em contacto para confirmar todos os detalhes</p>
    </div>

    <!-- CARD DO BOLO SELECIONADO -->
    <div class="cake-overview">
        <img src="../../<?= htmlspecialchars($bolo_sel['img']) ?>" alt="<?= htmlspecialchars($bolo_sel['nome']) ?>">
        <div class="cake-overview-info">
            <h3><?= htmlspecialchars($bolo_sel['nome']) ?></h3>
            <p><?= htmlspecialchars($bolo_sel['desc']) ?></p>
            <strong>Preço base: desde €<?= dd_formata_preco($bolo_sel['preco_base']) ?></strong>
        </div>
    </div>

    <!-- FORMULÁRIO DE ENCOMENDA -->
    <div class="personalize-form">
        <form method="post" action="../../actions/adicionar_carrinho.php">

            <!-- Campo hidden com o ID do bolo — vai junto no POST -->
            <input type="hidden" name="bolo_id" value="<?= htmlspecialchars($bolo_id) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(dd_csrf_token()) ?>">
            <input type="hidden" name="quantidade" value="1">

            <div class="grid-container">
                <div class="coluna-esquerda">

                    <!-- Tamanho -->
                    <section class="form-section">
                        <h2>1. Tamanho do Bolo</h2>
                        <select id="tamanho" name="tamanho" required>
                            <option value="">Escolha um tamanho...</option>
                            <option value="pequeno">Pequeno (10-12 pessoas) - €25</option>
                            <option value="medio">Médio (13-16 pessoas) - €35</option>
                            <option value="grande">Grande (17-20 pessoas) - €50</option>
                            <option value="muito_grande">Muito Grande (20+ pessoas) - €70</option>
                        </select>
                    </section>

                    <!-- Tipo de Massa -->
                        <section class="form-section">
                            <h2>2. Tipo de Massa</h2>
                            <label for="massa">Selecione a massa:</label>
                            <select id="massa" name="massa" required>
                                <option value="">Escolha uma massa...</option>
                                <optgroup label="Massas Standard">
                                    <option value="baunilha">Baunilha</option>
                                    <option value="laranja_canela">Laranja e Canela</option>
                                    <option value="papoila_limao">Papoila e Limão</option>
                                </optgroup>
                                <optgroup label="Massas Premium (+)">
                                    <option value="chocolate">Chocolate Negro (+€10)</option>
                                    <option value="red_velvet">Red Velvet (+€12)</option>
                                    <option value="cenoura">Laranja e Amêndoa (+€8)</option>
                                </optgroup>
                            </select>
                        </section>
                    
                    <!-- Tipo de Recheio -->
                        <section class="form-section">
                            <h2>3. Tipo de Recheio</h2>
                            <label for="recheio">Selecione o recheio:</label>
                            <select name="recheio" id="recheio" required>
                                <option value="">Escolha um recheio...</option>
                                <optgroup label="Recheios Standard">
                                    <option value="caramelo">Caramelo Salgado</option>
                                    <option value="morango">Curd de Morango</option>
                                    <option value="limao">Curd de Limão</option>
                                    <option value="creamcheese">Cream Cheese Laranja</option>
                                </optgroup>
                                <optgroup label="Recheios Premium (+)">
                                    <option value="brigadeiro">Brigadeiro Negro (+€8)</option>
                                    <option value="mascarpone">Mascarpone (+€10)</option>
                                    <option value="framboesa">Ganache Framboesa (+€12)</option>
                                    <option value="maracuja">Ganache Maracujá (+€12)</option>
                                </optgroup>
                            </select>
                        </section>

                     <!-- Sugestões -->
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

                     <!-- Data do Evento -->
                        <section class="form-section">
                            <h2>4. Data do Evento</h2>
                            <label for="birthday">Data do evento (mín. 7 dias):</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </section>

                    <!-- Observações -->
                        <section class="form-section">
                            <h2>5. Observações Especiais</h2>
                            <label for="observacoes">Informações adicionais (alergias, preferências, etc.):</label>
                            <textarea id="observacoes" name="observacoes" rows="4" placeholder="Descreva detalhes importantes..."></textarea>
                        </section>
                    </div>
                    
                    <div class="coluna-direita">
                    <!-- Resumo do Pedido -->
                        <section class="form-section resumo-section" id="resumo-pedido-box">
                            <h2>Resumo do Pedido</h2>
                            
                            <div id="resumo-content">
                                <p class="resumo-vazio">Preencha os campos para ver o resumo...</p>
                            </div>

                    <!-- Botões de Ação -->
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
<script src="../../js/encomenda.js"></script>
<?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>
