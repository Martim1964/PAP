<?php
require_once __DIR__ . '/../../includes/carrinho.php';
require_once __DIR__ . '/../../includes/db.php';

dd_start_session();

// Buscar todos  os dados do catalogo dos bolos onde a categoria e a de aniversarios
$query = "SELECT * FROM catalogo_bolos WHERE categoria_id = 3 AND ativo = 1 ORDER BY nome ASC";
$res_bolos = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolos de Batizado - Doces Dias</title>
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/casamento.css">
    <link rel="stylesheet" href="../../css/dropdown.css">
</head>
<body>
    <?php include '../../includes/header-bolos.php'; ?>
    <div class="title">
        <h1>Bolos de Batizado</h1>
    </div>

    <div class="cakes">
    <?php while ($bolo = mysqli_fetch_assoc($res_bolos)): 
        // Para cada bolo que o MySQL encontrar, vamos buscar os seus tamanhos específicos e o seu preco
        $tamanhos = buscar_tamanhos_cupcake($con, $bolo['slug']);
        
        // Pegamos no primeiro preço da lista, que é o pequeno para mostrar o preco minimo
        // Usamos o reset() para pegar no primeiro elemento do array de tamanhos
        $minimo = reset($tamanhos);
        $precomin = $minimo ? dd_formata_preco($minimo['preco']) : '0.00';
    ?>

    <div class="cake-item">
        <img src="../../<?= htmlspecialchars($bolo['imagem']) ?>" alt="<?= htmlspecialchars($bolo['nome']) ?>">
            <div class="cake-content">
                <h2><?= htmlspecialchars($bolo['nome']) ?></h2>
                <p><?= htmlspecialchars($bolo['descricao']) ?></p>
                <h4>Preço: Desde €<?= $precomin ?></h4>
                <?php 
                    $slug = $bolo['slug'];
                    if(isset($_SESSION['user'])): 
                        $url = "encomenda.php?bolo=" . $slug;
                    else: 
                        $url = "../../pages/login.php?redirect=bolos/encomenda.php&bolo=" . $slug;
                    endif; 
                ?>
                
                <a href="<?= $url ?>" class="order-btn">Encomendar / Personalizar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <section>
        <div class="Encomendas">
            <div class="enc-type">
                <h2>Personalize aqui o seu bolo de batismo!</h2>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="../../pages/bolospersonalizados.php">Personalize já o seu bolo de batismo!</a>
                    <?php else: ?>
                        <a href="../../pages/login.php">Personalize já o seu bolo de batismo!</a>
                    <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>