<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css">
    
    <!-- Favicon -->
    <link rel="icon" href="img-pap/logotipo-docesdias.jpg">
    
    <title>Página Principal - Doces Dias</title>
</head>
<body>

<?php include 'includes/header-root.php'; ?>

<main>

    <div class="container">
        <h3 class="subtitle">Bolos caseiros deliciosos</h3>
        <h1 class="main-title">DOCES DIAS</h1>

        <div class="divider">
            <h2 class="online-text">Doçaria online</h2>
        </div>

    <img src="img-pap/homepage-img/bolo-img1.jpg" alt="Bolo-fundo" class="img-fundo">
    <img src="img-pap/homepage-img/bolo-img2.jpg" alt="Bolo-fundo2" class="img-fundo2">
    </div>

    <hr>

    <div class="choose-section">
        <div>
        <button><a href="pages/sobrenos.php">Sobre nós</a></button>
            <h3>Conheça a nossa história, os nossos valores e a paixão que colocamos em cada bolo artesanal</h3>
        </div>

        <div>
        <button><a href="pages/encomende.php">Os nossos bolos</a></button>
            <h3>Descubra a nossa variedade de bolos caseiros, feitos com ingredientes selecionados e muito carinho</h3>
        </div>

        <div>
        <button><a href="pages/contactos.php">Contacte-nos</a></button>
            <h3>Entre em contacto connosco para encomendas, dúvidas ou sugestões</h3>
        </div>
    </div>

    <hr>

    <div class="cakes-section">
    <img src="img-pap/homepage-img/bolo3.jpg" alt="Bolo 3">
    <img src="img-pap/homepage-img/bolo4.jpg" alt="Bolo 4">
    <img src="img-pap/homepage-img/bolo5.jpg" alt="Bolo 5">

    <button><a href="pages/encomende.php">Ver todos os bolos</a></button>
    </div>

    <hr>

    <div class="info-section">
        <h1>Todas as informações para os nossos clientes</h1>
        <h2>Veja aqui todas as informações importantes para as suas encomendas</h3>
        <button><a href="pages/informacoes.php">Ver todas as informações</a></button>
    </div>

</main>

<?php include 'includes/footer-root.php'; ?>

</body>
</html>