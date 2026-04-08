<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="img-pap/logotipo-docesdias.jpg">
    <title>Header - Doces Dias</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php session_start(); ?>
    <a href="#main-content" class="visually-hidden-focusable position-absolute top-0 start-0 p-2 bg-white text-dark">Saltar para o conteúdo principal</a>
    <nav class="navbar navbar-expand-sm navbar-custom" aria-label="Navegação principal">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" style="height:50px;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Abrir menu de navegação" style="border-color: rgba(255,255,255,0.5);">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/sobrenos.php">Sobre Nós</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Abrir menu Nossos Bolos">Nossos Bolos</a>
                            <ul class="dropdown-menu" aria-label="Submenu Nossos Bolos">
                                <li><a class="dropdown-item" href="pages/bolos/casamento.php">Bolos de casamento</a></li>
                                <li><a class="dropdown-item" href="pages/bolos/aniversario.php">Bolos de aniversário</a></li>
                                <li><a class="dropdown-item" href="pages/bolos/batizados.php">Bolos de batizado</a></li>
                                <li><a class="dropdown-item" href="pages/bolos/cupcakes.php">Cupcakes/Bolos tradicionais</a></li>
                            </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="pages/encomende.php">Encomende já</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/informacoes.php">Informações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/contactos.php">Contacte-nos</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Abrir menu da conta">
                                Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['nome']); ?></strong>!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="pages/data/user-data.php">Ver conta</a></li>
                                <?php if($_SESSION['admin'] == 1): ?>
                                    <li><a class="dropdown-item" href="pages/data/admin-data.php">Painel Admin</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="actions/logout.php">Terminar sessão</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/login.php" aria-label="Abrir página de login ou registo">
                                <i class="bi bi-person" aria-hidden="true"></i> Login/Registe-se
                            </a>
                        </li>
                    <?php endif; ?>


                    <li class="nav-item">
                        <a class="nav-link" href="pages/compras.php" aria-label="Abrir carrinho de compras">
                            <i class="bi bi-cart-fill" aria-hidden="true"></i>
                        </a>
                    </li>

                    <li class="nav-item social-divider">
                        <a class="nav-link" href="https://wa.me/351913047889" target="_blank" rel="noopener noreferrer" title="WhatsApp" aria-label="Abrir WhatsApp da Doces Dias">
                            <i class="bi bi-whatsapp" aria-hidden="true"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/docesdias.pt" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Abrir Instagram da Doces Dias">
                            <i class="bi bi-instagram" aria-hidden="true"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/docessdias" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Abrir Facebook da Doces Dias">
                            <i class="bi bi-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
