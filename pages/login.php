<?php
// Preserve an optional redirect target so we can return the user to the page they originally wanted.
$redirectTo = '';
if (isset($_GET['redirect'])) {
    $redirectTo = trim($_GET['redirect']);
    // Basic sanitization: prevent open redirects and HTTP scheme injection
    $redirectTo = preg_replace('/[\r\n]/', '', $redirectTo);
}
?>

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

    <main id="main-content" class="login-main">
        <div class="login-container">
            <div class="login-image">
                <img src="../img-pap/logotipo-docesdias.jpg" alt="Logótipo da Doces Dias" class="logo-login">
                <h1 class="welcome-text">Bem-vindo</h1>
                <p class="subtitle-text">Aceda à sua conta para encomendar os melhores bolos</p>
            </div>

            <div class="login-form-section">
                <form action="../actions/processa_login.php" method="POST" class="login-form" id="loginForm">
                    <h2 class="form-title">Faça Login</h2>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill" aria-hidden="true"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seu.email@exemplo.com" aria-describedby="email-help" aria-label = "Email" required autocomplete="email">
                        <small class="form-text" id="email-help">Introduza o seu endereço de email registado.</small>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill" aria-hidden="true"></i> Senha
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" class="form-control" id="password" name="pass" placeholder="••••••••" aria-describedby="password-help" aria-label = "Password" required autocomplete="current-password">
                            <button type="button" class="btn-toggle-password" onclick="togglePassword()" aria-controls="password" aria-label="Mostrar palavra-passe" aria-pressed="false">
                                <i class="bi bi-eye-fill" id="toggleIcon" aria-hidden="true"></i>
                            </button>
                        </div>
                        <small class="form-text" id="password-help">Mínimo 8 caracteres.</small>
                    </div>

                    <div class="form-options">
                        <a href="forgot-password.php" class="forgot-password">Esqueceu a senha?</a>
                    </div>

                    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirectTo); ?>">

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right" aria-hidden="true" aria-label = "Enter Button"></i> Entrar
                    </button>

                    <?php if (isset($_SESSION['loginErro'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <?php
                                echo htmlspecialchars($_SESSION['loginErro']);
                                unset($_SESSION['loginErro']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="login-footer">
                        <p>Não tem conta? <a href="regist.php" aria-label="Registe-se aqui">Registe-se aqui</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="../js/login.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
