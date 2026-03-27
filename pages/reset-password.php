<?php
$token = $_GET["token"]; //Obtém o token enviado via parâmetro GET no URL

$token_hash = hash("sha256", $token); //Vai fazer o hash do token para comparar com o que está na BD

$mysqli = require __DIR__ . "/../includes/db.php"; //Vai obter os dados da db para alterar esses mesmos dados apos a troca da password

//Vais buscar os dados do user com aquele token_hash em questao
$sql = "SELECT * FROM utilizadores
        WHERE reset_token_hash = ?";

//Vai preparar e executar a query
$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result(); //vai obter o resultado

$user = $result->fetch_assoc(); //Vai ver os dados do user em questao

if ($user === null) { //caso  user nao exista
    die("token não encontrado");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) { //caso tenho passado o tempo do token
    die("token expirado");
}

?>
<!DOCTYPE html>
<html>
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
                <form method="post" action="../actions/processa_reset_password.php" class="login-form" id="loginForm">
                    <h3 class="form-title">Recupere sua password</h3>

                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-envelope-fill"></i> Nova Password
                        </label>
                        <input type="password" class = "form-control" id="password" name="password" placeholder="******" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-envelope-fill"></i> Confirme a password
                        </label>
                        <input type="password" class = "form-control" id="password_confirmation" name="password_confirmation" placeholder="******" required>
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
                </form>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
        <input type="password" id="password_confirmation"
               name="password_confirmation">

        <button>Send</button>
    </form>

</body>
</html>