<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/sobrenos.css">
    <title>Sobre Nós - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h3 class="hero-subtitle">Quem Somos</h3>
                <h1 class="hero-title">Doces Dias</h1>
                <div class="logo-container">
                    <img src="../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" class="hero-logo">
                    <img src="../img-pap/mae.jpg" alt="Mae" class="hero-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Intro Section -->
    <section class="intro-section">
        <div class="container">
            <div class="content-box">
                <h2 class="section-heading">Bem-vindo ao Doces Dias</h2>
                <p class="section-text">
                    Breve apresentação minha e da página. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                    quis nostrud exercitation ullamco laboris.
                </p>
            </div>
        </div>
    </section>

    <!-- Development Section 1 -->
    <section class="development-section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-box">
                        <h2 class="section-heading">O que é a Página</h2>
                        <p class="section-text">
                            Nossa plataforma foi criada com amor e dedicação para conectar você aos melhores 
                            doces artesanais. Combinamos tradição e inovação para oferecer uma experiência 
                            única em confeitaria.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image-container">
                        <img src="../img-pap/sobrenos-img/bolo1.jpg" alt="Bolo Artesanal" class="section-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Development Section 2 -->
    <section class="development-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="content-box">
                        <h2 class="section-heading">O que Oferecemos</h2>
                        <p class="section-text">
                            Trabalhamos com ingredientes selecionados e receitas exclusivas. Desde bolos 
                            personalizados até doces tradicionais portugueses, cada criação é feita com 
                            carinho e atenção aos detalhes.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="image-container">
                        <img src="../img-pap/sobrenos-img/bolo2.jpg" alt="Doces Tradicionais" class="section-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Conclusion Section -->
    <section class="conclusion-section bg-primary text-white">
        <div class="container">
            <div class="content-box text-center">
                <h2 class="section-heading text-white">Adoce os Seus Dias</h2>
                <p class="section-text text-white">
                    Mensagem final. Obrigado por visitar o Doces Dias. Estamos aqui para tornar 
                    cada momento especial com sabores que ficam na memória. Junte-se a nós nesta 
                    doce jornada!
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="container">
            <div class="mission-content">
                <h2 class="mission-title">Nossa Missão</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <h4>Qualidade Superior</h4>
                            <p>Garantir produtos de excelência com ingredientes selecionados e frescos</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4>Satisfação do Cliente</h4>
                            <p>Proporcionar experiências memoráveis em cada encomenda</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <h4>Inovação Constante</h4>
                            <p>Criar novos sabores mantendo a essência tradicional</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mission-card">
                            <div class="mission-icon">
                                <i class="bi bi-gem"></i>
                            </div>
                            <h4>Paixão pela Confeitaria</h4>
                            <p>Dedicação e amor em cada detalhe dos nossos produtos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logo Divider -->
    <section class="logo-divider">
        <div class="container text-center">
            <img src="../img-pap/mae.jpg" alt="Mae" class="divider-logo">
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>