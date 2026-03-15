<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Makes the site responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Import Bootstrap styles - navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Import Bootstrap JavaScript functionality - navbar-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"><!-- Import Bootstrap icons -->
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg"> <!-- Site favicon -->
    <title>Header - Doces Dias</title>
    <link rel="stylesheet" href="../../css/header.css"> <!-- Custom header styles -->
        

<body>
    <?php session_start(); ?>
    <!-- Responsive navigation bar with Doces Dias colors -->
    <nav class="navbar navbar-expand-sm navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" style="height:50px;">
            </a>
            
            <!-- Hamburger button for mobile devices -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" style="border-color: rgba(255,255,255,0.5);">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu that collapses on small screens -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <!-- Navbar creation -->
                <ul class="navbar-nav me-auto">     
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/sobrenos.php">Sobre Nós</a>
                    </li>
                    
                    <!-- Dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nossos Bolos</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../../pages/bolos/casamento.php">🎂 Bolos de casamento</a></li>
                                <li><a class="dropdown-item" href="../../pages/bolos/aniversario.php">🎉 Bolos de aniversário</a></li>
                                <li><a class="dropdown-item" href="../../pages/bolos/batizados.php">👶 Bolos de batizado</a></li>
                                <li><a class="dropdown-item" href="../../pages/bolos/cupcakes.php">🧁 Cupcakes/Bolos tradicionais</a></li>
                            </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/encomende.php">Encomende já</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/informacoes.php">Informações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/contactos.php">Contacte-nos</a>
                    </li>
                </ul>
                
                <!-- Right side: Login, Cart and Social Media -->
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" onclick="if(confirm('Deseja realmente fazer logout?')){window.location='../../actions/logout.php';}return false;">
                                Bem vindo, <strong><?php echo $_SESSION['nome']; ?></strong>!
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/login.php">
                                <i class="bi bi-person"></i> Login/Registe-se
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/compras.php">
                            <i class="bi bi-cart-fill"></i>
                        </a>
                    </li>

                    <!-- Social media with divider -->
                    <li class="nav-item social-divider">
                        <a class="nav-link" href="https://wa.me/351913047889" target="_blank" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/doces__dias" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/docessdias" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
 

</body>
</html>