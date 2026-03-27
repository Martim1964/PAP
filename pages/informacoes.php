<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/informacoes.css">
    <title>Informações - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-subtitle">As melhores informações para os nossos clientes</h2>
                <div class="logo-container">
                    <img src="../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" class="hero-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Info section -->
<section class="Info-section">
    <!-- Info 1 -->
    <div class="info1">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info1.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>

    <!-- Info 2 -->
    <div class="info2">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info2.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>
    
    <!-- Info 3 -->
    <div class="info3">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info3.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>

    <!-- Info 4 -->
    <div class="info4">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info4.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>

    <!-- Extra Info (initially hidden) -->
    <div class="info5" id="info5" style="display: none;">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info5.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>

    <div class="info6" id="info6" style="display: none;">
        <div class="info-container">
            <img src="../img/" alt="" class="info-logo">
            <p class="info-text"> Mini texto cinzento c/info Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit accusamus voluptas quisquam vero illum.</p>
            <a href="info6.php" class="btn-ver-mais">Ver mais</a>
        </div>
    </div>

    <!-- Add more info here with display: none -->

</section>

<!-- Button at the end -->
<div style="text-align: center; margin: 30px 0;">
    <button id="btnVerMais" onclick="mostrarMais()">Ver mais informações</button>
</div>

<script src="../js/informacoes.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>