<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="login-main">
        <div class="login-container">
            <!-- Seção de Imagem -->
            <div class="login-image">
                <img src="../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" class="logo-login">
                <h2 class="welcome-text">Bem-vindo</h2>
                <p class="subtitle-text">Aceda à sua conta para encomendar os melhores bolos</p>
            </div>

            <!-- Seção de Formulário -->
            <div class="login-form-section">
                <form action="../actions/send-pass-reset.php" method="POST" class="login-form" id="loginForm">
                    <h3 class="form-title">Recupere sua password</h3>

                    <!-- Campo Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill"></i> Email
                        </label>
                        <input 
                        type="email" class="form-control" id="email" name="email" placeholder="seu.email@exemplo.com" required autocomplete="email">
                        <small class="form-text">Introduza o seu endereço de email para a recuperação da password</small>
                    </div>
                    
                    <!-- Mensagem de Erro -->
                    <?php if(isset($_SESSION['loginErro'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?php 
                                echo htmlspecialchars($_SESSION['loginErro']); 
                                unset($_SESSION['loginErro']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Botão de Recuperar Senha -->
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Recuperar password
                    </button>

                    <!-- Link para Registo -->
                    <div class="login-footer">
                        <p>Não tem conta? <a href="regist.php">Registe-se aqui</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../js/login.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>