<?php
require_once __DIR__ . '/../../includes/carrinho.php';
require_once __DIR__ . '/../../includes/db.php';

dd_start_session();
require_once __DIR__ . '/../../includes/verificar_ativo.php';

// Buscar todos  os dados do catalogo dos bolos onde a categoria e a de aniversarios
$query = "SELECT * FROM catalogo_bolos WHERE categoria_id = 4 AND ativo = 1 ORDER BY nome ASC";
$res_bolos = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupcakes e Doces Tradicionais - Doces Dias</title>
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/dropdown.css">
</head>
<body>
    <?php include '../../includes/header-bolos.php'; ?>
    <div class="title">
        <h1>Cupcakes / Doces Tradicionais</h1>
    </div>

    <div class="cakes" aria-label="Product List">
    <?php while ($bolo = mysqli_fetch_assoc($res_bolos)): 
        // Para cada bolo que o MySQL encontrar, vamos buscar os seus tamanhos específicos e o seu preco
        $tamanhos = buscar_tamanhos($con, $bolo['slug']);
        
        // Pegamos no primeiro preço da lista, que é o pequeno para mostrar o preco minimo
        // Usamos o reset() para pegar no primeiro elemento do array de tamanhos
        $minimo = reset($tamanhos);
        $precomin = $minimo ? dd_formata_preco($minimo['preco']) : '0.00';
    ?>

    <div class="cake-item" aria-label="Product Card">
        <img src="../../<?= htmlspecialchars($bolo['imagem']) ?>" alt="<?= htmlspecialchars($bolo['nome']) ?>">
            <div class="cake-content">
                <h2><?= htmlspecialchars($bolo['nome']) ?></h2>
                <p><?= htmlspecialchars($bolo['descricao']) ?></p>
                <h3>Preço: Desde €<?= $precomin ?> sem IVA</h3>
                <?php 
                    $slug = $bolo['slug'];
                    if(isset($_SESSION['user'])): 
                        $url = "encomenda-cupcakes.php?bolo=" . $slug;
                    else: 
                        $url = "../../pages/login.php?redirect=bolos/encomenda-cupcakes.php&bolo=" . $slug;
                    endif; 
                ?>
                
                <a href="<?= $url ?>" class="order-btn" aria-label="Encomendar bolo">Encomendar / Personalizar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <section>
        <div class="Encomendas">
            <div class="enc-type">
                <h2>Personalize aqui o seu cupcake / doce tradicional!</h2>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="../../pages/bolospersonalizados.php">Personalize já o seu cupcake / doce tradicional!</a>
                    <?php else: ?>
                        <a href="../../pages/login.php">Personalize já o seucupcake / doce tradicional!</a>
                    <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>