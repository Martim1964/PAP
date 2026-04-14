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
    <title>Recuperar Password - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main id="main-content" class="login-main">
        <div class="login-container">
            <div class="login-image">
                <img src="../img-pap/logotipo-docesdias.jpg" alt="Logótipo da Doces Dias" class="logo-login">
                <h1 class="welcome-text">Bem-vindo</h1>
                <p class="subtitle-text">Aceda à sua conta para encomendar os melhores bolos</p>
            </div>

            <div class="login-form-section">
                <form action="../actions/send-pass-reset.php" method="POST" class="login-form" id="loginForm">
                    <h2 class="form-title">Recupere a sua password</h2>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill" aria-hidden="true"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seu.email@exemplo.com" aria-describedby="forgot-email-help" required autocomplete="email">
                        <small class="form-text" id="forgot-email-help">Introduza o email associado à sua conta para receber instruções.</small>
                    </div>
                    
                    <?php if (isset($_SESSION['loginErro'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <?php
                                echo htmlspecialchars($_SESSION['loginErro']);
                                unset($_SESSION['loginErro']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Recuperar password
                    </button>

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
