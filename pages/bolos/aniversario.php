<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolos de Aniversário - Doces Dias</title>
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/casamento.css">
    <link rel="stylesheet" href="../../css/dropdown.css">
</head>
<body>
    <?php include '../../includes/header-bolos.php'; ?>
    <div class="title">
        <h1>Bolos de Aniversário</h1>
    </div>

    <div class="cakes">
        <div class="cake-item" id="bolo-avos">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-avós-aniv.jpg" alt="bolo avós">
            <div class="cake-content">
                <h2>Bolo de avós</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="encomenda.php?bolo=bolo-avos" class="order-btn">Encomendar / Personalizar</a>
                    <?php else: ?>
                        <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-avos" class="order-btn">Encomendar / Personalizar</a>
                    <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-camisa">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-camisa-aniv.jpg" alt="bolo camisa">
            <div class="cake-content">
                <h2>Bolo camisa</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-camisa" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-camisa" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-cars">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-cars-aniv.jpg" alt="bolo cars">
            <div class="cake-content">
                <h2>Bolo Cars</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-cars" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-cars" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-conchas">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-conchas-aniv.jpg" alt="bolo conchas">
            <div class="cake-content">
                <h2>Bolo Conchas</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-conchas" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-conchas" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-panda">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-panda-aniv.jpg" alt="bolo panda">
            <div class="cake-content">
                <h2>Bolo Panda</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-panda" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-panda" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-pasteleiro">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-pasteleiro-aniv.jpg" alt="bolo pasteleiro">
            <div class="cake-content">
                <h2>Bolo Pasteleiro</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-pasteleiro" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-pasteleiro" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-praia">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-praia-aniv.jpg" alt="bolo praia">
            <div class="cake-content">
                <h2>Bolo Praia</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-praia" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-praia" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-rosa">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-rosa-aniv.jpg" alt="bolo rosa">
            <div class="cake-content">
                <h2>Bolo Rosa</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-rosa" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-rosa" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-sofa">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-sofa-aniv.jpg" alt="bolo sofa">
            <div class="cake-content">
                <h2>Bolo Sofá</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-sofa" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-sofa" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-sonic">
            <img src="../../img-pap/nossos-bolos/aniversario/bolo-sonic-aniv.jpg" alt="bolo sonic">
            <div class="cake-content">
                <h2>Bolo Sonic</h2>
                <p>Descrição do bolo</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomenda.php?bolo=bolo-sonic" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomenda.php&bolo=bolo-sonic" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <section>
        <div class="Encomendas">
            <div class="enc-type">
                <h2>Personalize aqui o seu bolo de aniversário!</h2>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="../../pages/bolospersonalizados.php">Personalize já o seu bolo de aniversário!</a>
                    <?php else: ?>
                        <a href="../../pages/login.php">Personalize já o seu bolo de aniversário!</a>
                    <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include '../../includes/footer-bolos.php'; ?>
</body>
</html>