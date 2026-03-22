<?php
session_start();

// ==========================================
// DADOS DOS BOLOS DO CATÁLOGO
// Aqui defines todas as informações de cada bolo.
// Quando adicionares um novo bolo à página, só
// precisas de adicionar uma entrada aqui.
// ==========================================
$bolos = [// ---------------------------------------------------------------
    //Cupcakes / Doces Tradicionais
    //----------------------------------------------------------------
    'bolachas-natal' => [
        'nome' => 'Bolachas Natal',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/bolachas-natal.jpg',
        'desc' => 'Deliciosas bolachas natalícias.',
        'preco_base' => 25,
    ],
    'bolachas-panda' => [
        'nome' => 'Bolachas Panda',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/bolachas-panda.jpg',
        'desc' => 'Bolachas temáticas de panda.',
        'preco_base' => 25,
    ],
    'mini-brigadeiros' => [
        'nome' => 'Mini Brigadeiros',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/mini-brigadeiros.jpg',
        'desc' => 'Mini brigadeiros deliciosos.',
        'preco_base' => 25,
    ],
    'brigadeiro-chocolate' => [
        'nome' => 'Brigadeiro Chocolate',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/brigadeiro-chocolate.jpg',
        'desc' => 'Clássico brigadeiro de chocolate.',
        'preco_base' => 25,
    ],
    'torta-chocolate' => [
        'nome' => 'Torta de Chocolate',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/torta-chocolate.jpg',
        'desc' => 'Torta rica em chocolate.',
        'preco_base' => 25,
    ],
    'torta-laranja' => [
        'nome' => 'Torta de Laranja',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/torta-laranja.jpg',
        'desc' => 'Torta refrescante de laranja.',
        'preco_base' => 25,
    ],
    'bolo-bolacha' => [
        'nome' => 'Bolo Bolacha',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/bolo-bolacha.jpg',
        'desc' => 'Delicioso bolo de bolacha.',
        'preco_base' => 25,
    ],
    'torre-choux' => [
        'nome' => 'Torre de Choux',
        'img'  => '../../img-pap/nossos-bolos/cupcakes/bolo-ar-gri-est-4.jpg',
        'desc' => 'Elegante torre de choux.',
        'preco_base' => 25,
    ],
];
// ---------------------------------------------------------------
// ---------------------------------------------------------------
//----------------------------------------------------------------

// ==========================================
// LÊ O PARÂMETRO ?bolo= DA URL
// ==========================================

$bolo_id  = $_GET['bolo'] ?? null;
$bolo_sel = ($bolo_id && isset($bolos[$bolo_id])) ? $bolos[$bolo_id] : null;


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
    <link rel="stylesheet" href="../../css/encomenda-cupcakes.css">
    <title>Encomendar <?= htmlspecialchars($bolo_sel['nome']) ?> - Doces Dias</title>
</head>
<body>
<?php include '../../includes/header-bolos.php'; ?>

<div class="bcontainer" data-category="<?= htmlspecialchars($category) ?>">

    <!-- CABEÇALHO COM INFO DO BOLO ESCOLHIDO -->
    <div class="title">
        <h1>Encomendar: <?= htmlspecialchars($bolo_sel['nome']) ?></h1>
        <p class="subtitle">Após o pedido, entraremos em contacto para confirmar todos os detalhes</p>
    </div>

    <!-- CARD DO BOLO SELECIONADO -->
    <div class="cake-overview">
        <img src="<?= htmlspecialchars($bolo_sel['img']) ?>" alt="<?= htmlspecialchars($bolo_sel['nome']) ?>">
        <div class="cake-overview-info">
            <h3><?= htmlspecialchars($bolo_sel['nome']) ?></h3>
            <p><?= htmlspecialchars($bolo_sel['desc']) ?></p>
            <strong>Preço base: desde €<?= $bolo_sel['preco_base'] ?></strong>
        </div>
    </div>

    <!-- FORMULÁRIO DE ENCOMENDA -->
    <div class="personalize-form">
        <form method="post" action="processar_encomenda.php">

            <!-- Campo hidden com o ID do bolo — vai junto no POST -->
            <input type="hidden" name="bolo_id" value="<?= htmlspecialchars($bolo_id) ?>">

            <div class="grid-container">
                <div class="coluna-esquerda">

                    <!-- Quantidade -->
                    <section class="form-section">
                        <h2>1. Quantidade</h2>
                        <select id="tamanho" name="tamanho" required>
                            <option value="">Escolha a quantidade...</option>
                            <option value="pequeno">Pack 6 bolachas- €25</option>
                            <option value="medio">Pack 14 bolachas - €35</option>
                            <option value="grande">Pack 28 bolachas - €50</option>
                            <option value="muito_grande">Pack 50 bolachas - €70</option>
                        </select>
                    </section>

                     <!-- Data do Evento -->
                        <section class="form-section">
                            <h2>2. Data do Evento</h2>
                            <label for="birthday">Data do evento (mín. 7 dias):</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </section>
                    
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

                        <p class="disclaimer">* Preço indicativo. O orçamento final será confirmado por email após análise do pedido.</p>
                    </section>

                </div>
            </div>

        </form>
    </div>
</div>
<script src="../../js/encomenda-cupcakes.js"></script>
<?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>