<?php
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../includes/db.php";

$sql = "SELECT * FROM utilizadores
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token não encontrado");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token expirado");
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
    <title>Alterar Password - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main id="main-content" class="login-main">
        <div class="login-container">
            <div class="login-image">
                <img src="../img-pap/logotipo-docesdias.jpg" alt="Logótipo da Doces Dias" class="logo-login">
                <h1 class="welcome-text">Bem-vindo</h1>
                <p class="subtitle-text">Defina uma nova password para voltar a aceder à sua conta</p>
            </div>

            <div class="login-form-section">
                <form method="post" action="../actions/processa_reset_password.php" class="login-form" id="loginForm">
                    <h2 class="form-title">Alterar password</h2>

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill" aria-hidden="true"></i> Nova Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="******" aria-describedby="reset-password-help" required>
                        <small class="form-text" id="reset-password-help">Utilize uma password com pelo menos 8 caracteres.</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill" aria-hidden="true"></i> Confirme a password
                        </label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******" aria-describedby="reset-password-confirm-help" required>
                        <small class="form-text" id="reset-password-confirm-help">Repita a nova password exatamente como acima.</small>
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
                        <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Alterar password
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
