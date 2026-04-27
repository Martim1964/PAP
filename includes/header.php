<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg"> 
    <title>Doces Dias</title>
    <link rel="stylesheet" href="../css/header.css"> 
    <script src="../js/acessibilidade.js" defer></script>
</head>
<body>

<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>

<nav class="navbar navbar-expand-sm navbar-custom">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand" href="../index.php">
            <img src="../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" style="height:50px;">
        </a>

        <!-- BOTÃO MOBILE -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Abrir menu de navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <!-- MENU ESQUERDA -->
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="../pages/sobrenos.php">Sobre Nós</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Nossos Bolos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/bolos/casamento.php">Bolos de casamento</a></li>
                        <li><a class="dropdown-item" href="../pages/bolos/aniversario.php">Bolos de aniversário</a></li>
                        <li><a class="dropdown-item" href="../pages/bolos/batizados.php">Bolos de batizado</a></li>
                        <li><a class="dropdown-item" href="../pages/bolos/cupcakes.php">Cupcakes/Bolos tradicionais</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../pages/encomende.php">Encomende já</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../pages/informacoes.php">Informações</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../pages/contactos.php">Contacte-nos</a>
                </li>

            </ul>

            <!-- MENU DIREITA -->
            <ul class="navbar-nav ms-auto">

                <!-- BOTOES DE ACESSIBILIDADE WCAG -->
                <li class="nav-item">
                    <button id="btn-ouvir" class="btn-acessibilidade" aria-label="Ouvir conteúdo da página">🔊</button>
                </li>

                <li class="nav-item">
                    <button id="btn-parar" class="btn-acessibilidade" aria-label="Parar leitura da página">⏹</button>
                </li>

                <li class="nav-item">
                    <button id="btn-aumentar" class="btn-acessibilidade" aria-label="Aumentar tamanho do texto">A+</button>
                </li>

                <li class="nav-item">
                    <button id="btn-diminuir" class="btn-acessibilidade" aria-label="Diminuir tamanho do texto">A-</button>
                </li>

                <li class="nav-item">
                    <button id="btn-dark" class="btn-acessibilidade" aria-label="Ativar ou desativar modo escuro" aria-pressed="false">
                        <i class="bi bi-moon-fill" aria-hidden="true"></i>
                    </button>
                </li>
                

                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../pages/data/user-data.php">Ver conta</a></li>

                            <?php if($_SESSION['admin'] == 1): ?>
                                <li><a class="dropdown-item" href="../pages/data/menu-admin.php">Painel Admin</a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../actions/logout.php">Terminar sessão</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/login.php">
                            <i class="bi bi-person"></i> Login/Registe-se
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="../pages/compras.php" aria-label="Abrir carrinho">
                        <i class="bi bi-cart-fill"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://wa.me/351913047889" target="_blank">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://www.instagram.com/docesdias.pt" target="_blank">
                        <i class="bi bi-instagram"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://www.facebook.com/docessdias" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>
