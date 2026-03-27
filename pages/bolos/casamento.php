<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolos de Casamento - Doces Dias</title>
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../../css/dropdown.css">
    <link rel="stylesheet" href="../../css/casamento.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include '../../includes/header-bolos.php'; ?>
    <div class="title">
        <h1>Bolos de Casamento</h1>
    </div>

    <div class="cakes">
        <div class="cake-item" id="bolo-aliancas">
            <img src="../../img-pap/nossos-bolos/casamento/bolo-aliancas-cas.jpg" alt="bolo aliancas">
            <div class="cake-content">
                <h2>Bolo Alianças</h2>
                <p>Um bolo especial para um dia especial</p>
                <h4>Preço: Desde 25 euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-aliancas" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-aliancas" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-bodas-diamante">
            <img src="../../img-pap/nossos-bolos/casamento/bolo-bodas-diamante-cas.jpg" alt="bolo bodas diamante">
            <div class="cake-content">
                <h2>Bolo Bodas Diamante</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-bodas-diamante" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-bodas-diamante" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-flores">
            <img src="../../img-pap/nossos-bolos/casamento/bolo-flores-cas.jpg" alt="bolo flores">
            <div class="cake-content">
                <h2>Bolo Flores</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-flores" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-flores" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-flores-comestiveis">
            <img src="../../img-pap/nossos-bolos/casamento/bolo-flores-comestiveis-cas.jpg" alt="bolo flores comestiveis">
            <div class="cake-content">
                <h2>Bolo Flores Comestíveis</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-flores-comestiveis" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-flores-comestiveis" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <section>
        <div class="Encomendas">
            <div class="enc-type">
                <h2>Personalize aqui o seu bolo de casamento!</h2>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="../../pages/bolospersonalizados.php">Personalize já o seu bolo de casamento!</a>
                    <?php else: ?>
                        <a href="../../pages/login.php">Personalize já o seu bolo de casamento!</a>
                    <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>