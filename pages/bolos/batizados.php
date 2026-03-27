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
        <div class="cake-item" id="bolo-batismo">
            <img src="../../img-pap/nossos-bolos/batizado/bolo-batismo-bat.jfif" alt="bolo batismo">
            <div class="cake-content">
                <h2>Bolo Batismo</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-batismo" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-batismo" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-1ºcomunhão">
            <img src="../../img-pap/nossos-bolos/batizado/bolo-1ºcomunhão-bat.jfif" alt="bolo 1º comunhão">
            <div class="cake-content">
                <h2>Bolo 1º Comunhão</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-1ºcomunhão" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-1ºcomunhão" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-baloiço">
            <img src="../../img-pap/nossos-bolos/batizado/bolo-baloiço-bat.jfif" alt="bolo baloiço">
            <div class="cake-content">
                <h2>Bolo Baloiço</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-baloiço" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-baloiço" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>
        
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