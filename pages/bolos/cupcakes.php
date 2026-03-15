<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupcakes e Doces Tradicionais - Doces Dias</title>
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/casamento.css">
    <link rel="stylesheet" href="../../css/dropdown.css">
</head>
<body>
    <?php include '../../includes/header-bolos.php'; ?>
    <div class="title">
        <h1>Cupcakes / Doces Tradicionais</h1>
    </div>

    <div class="cakes">
        <div class="cake-item" id="bolachas-natal">
            <img src="../../img-pap/nossos-bolos/cupcakes/bolachas-natal.jpg" alt="bolachas natal">
            <div class="cake-content">
                <h2>Bolachas Natal</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=bolachas-natal" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=bolachas-natal" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolachas-panda">
            <img src="../../img-pap/nossos-bolos/cupcakes/bolachas-panda.jpg" alt="bolachas panda">
            <div class="cake-content">
                <h2>Bolachas Panda</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=bolachas-panda" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=bolachas-panda" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="mini-brigadeiros">
            <img src="../../img-pap/nossos-bolos/cupcakes/mini-brigadeiros.jpg" alt="mini brigadeiros">
            <div class="cake-content">
                <h2>Mini Brigadeiros</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=mini-brigadeiros" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=mini-brigadeiros" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="brigadeiro-chocolate">
            <img src="../../img-pap/nossos-bolos/cupcakes/brigadeiro-chocolate.jpg" alt="brigadeiro chocolate">
            <div class="cake-content">
                <h2>Brigadeiro Chocolate</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=brigadeiro-chocolate" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=brigadeiro-chocolate" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="torta-chocolate">
            <img src="../../img-pap/nossos-bolos/cupcakes/torta-chocolate.jpg" alt="torta chocolate">
            <div class="cake-content">
                <h2>Torta de Chocolate</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=torta-chocolate" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=torta-chocolate" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="torta-laranja">
            <img src="../../img-pap/nossos-bolos/cupcakes/torta-laranja.jpg" alt="torta laranja">
            <div class="cake-content">
                <h2>Torta de Laranja</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=torta-laranja" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=torta-laranja" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="bolo-bolacha">
            <img src="../../img-pap/nossos-bolos/cupcakes/bolo-bolacha.jpg" alt="bolo bolacha">
            <div class="cake-content">
                <h2>Bolo Bolacha</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=bolo-bolacha" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=bolo-bolacha" class="order-btn">Encomendar / Personalizar</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="cake-item" id="torre-choux">
            <img src="../../img-pap/nossos-bolos/cupcakes/bolo-ar-gri-est-4.jpg" alt="torre choux">
            <div class="cake-content">
                <h2>Torre de Choux</h2>
                <p>Descrição do doce</p>
                <h4>Preço: Desde ... euros</h4>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="encomendas&bolo=torre-choux" class="order-btn">Encomendar / Personalizar</a>
                <?php else: ?>
                    <a href="../../pages/login.php?redirect=encomendas&bolo=torre-choux" class="order-btn">Encomendar / Personalizar</a>
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