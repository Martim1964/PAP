<!DOCTYPE html>
<html lang="pt">
<style>
    #btnSeeInfo {
        background: linear-gradient(135deg, #ffffff 0%, #c2185b 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 30px !important;
        padding: 15px 40px !important;
        font-size: 1rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
    }

    #btnSeeInfo:hover{
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 30px rgba(233, 30, 99, 0.4);
    color: white;
    }

    #btnSeeInfo:active{
    transform: translateY(-1px);
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/encomende.css">
    <title>Encomende já - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h1>Escolha um tipo de bolo e faça já a sua encomenda!</h1>

    <div class="section-cakes">
        
        <div class="cake-item">
            <a href="bolos/casamento.php">
                <img src="../img-pap/nossos-bolos/bolo-casamento.png" alt="Bolo de Casamento">
                <h2>Bolos de Casamento</h2>
            </a>
        </div>

        <div class="cake-item">
            <a href="bolos/aniversario.php">
                <img src="../img-pap/nossos-bolos/bolo-aniversario.png" alt="Bolo de Aniversário">
                <h2>Bolos de Aniversário</h2>
            </a>
        </div>

        <div class="cake-item">
            <a href="bolos/batizados.php">
                <img src="../img-pap/nossos-bolos/bolo-batizado.png" alt="Bolo de Batizado">
                <h2>Bolos de Batizado</h2>
            </a>
        </div>

        <div class="cake-item">
            <a href="bolos/cupcakes.php">
                <img src="../img-pap/nossos-bolos/doce-tradicional.png" alt="Doce Tradicional">
                <h2>Cupcakes/Doces Tradicionais</h2>
            </a>
        </div>
    </div>

    <!-- Promo Section -->
    <section class="promo-section">
        <div class="promo-content">
            <h2>O bolo ideal para o seu grande dia</h2>
            <h3>Casamentos, aniversários ou eventos especiais. Personalize o seu bolo à sua medida.</h3>
                <?php if(isset($_SESSION['user'])): ?>
                        <a href="bolospersonalizados.php" class ="btn-promo">Personalize aqui o seu bolo!</a>
                    <?php else: ?>
                        <a href="login.php?redirect=bolospersonalizados.php" class ="btn-promo">Personalize aqui o seu bolo!</a>
                    <?php endif; ?>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-subtitle">Tudo o que precisa de saber para fazer a sua encomenda</h2>
                <p>Escolha o sabor, o tamanho e o design do seu bolo. Descubra prazos de encomenda, preços e opções de personalização para tornar o seu momento ainda mais especial.</p>
                <button id="btnSeeInfo" onclick="window.location.href='../pages/informacoes.php'">Ver todas as informações</button>
                <button id="btnNeedHelp" onclick="window.location.href='../pages/contactos.php'">Precisa de ajuda?</button>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>
</html>