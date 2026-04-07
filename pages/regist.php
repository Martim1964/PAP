<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/regist.css">
    <title>Registe-se - Doces Dias</title>
</head>
<body>
    <?php
    session_start();
    include '../includes/header.php';
    ?>

    <div class="container regist-container">
        <img class="img-fluid" src="../img-pap/logotipo-docesdias.jpg" alt="Bolo Doces Dias">

        <div class="regist-form-content">
            <h2 class="regist-title">Já tem conta? <a href="login.php">Faça login</a></h2>

            <!-- Mensagem de Erro -->
            <?php if (isset($_SESSION['regist_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['regist_error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['regist_error']); ?>
            <?php endif; ?>

            <!-- Mensagem de Sucesso -->
            <?php if (isset($_SESSION['regist_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= htmlspecialchars($_SESSION['regist_success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['regist_success']); ?>
            <?php endif; ?>

            <form action="../actions/processa_user.php" method="POST" class="regist-form" id="registForm">

                <!-- Nome -->
                <div class="mb-3">
                    <label for="nome" class="form-label">
                        <i class="bi bi-person-fill"></i> Nome
                    </label>
                    <input type="text" class="form-control" id="nome" name="nome"
                           placeholder="O teu nome completo" minlength="3" maxlength="120" required>
                    <small class="form-text">Mínimo 3 caracteres</small>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope-fill"></i> Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="seu.email@exemplo.com" required>
                    <small class="form-text">Usaremos este email para contacto</small>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill"></i> Senha
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="password" name="password_hash"
                               placeholder="••••••••" minlength="8" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('password')">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    <small class="form-text">Mínimo 8 caracteres</small>
                </div>

                <!-- Confirmar Password -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">
                        <i class="bi bi-lock-fill"></i> Confirme a sua Senha
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="••••••••" minlength="8" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('confirm_password')">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                    <small class="form-text">As senhas devem coincidir</small>
                </div>

                <!-- Telemóvel -->
                <div class="mb-3">
                    <label for="telefone" class="form-label">
                        <i class="bi bi-phone-fill"></i> Nº Telemóvel
                    </label>
                    <input type="tel" class="form-control" id="telefone" name="telefone"
                           placeholder="913 047 889" required>
                    <small class="form-text">Usaremos este número para contacto</small>
                </div>

                <!-- Data de Nascimento -->
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label" required>
                        <i class="bi bi-cake-fill"></i> Data de Nascimento
                    </label>
                    <input type="date" class="form-control" id="data_nascimento" name = "data_nascimento">
                </div>

                <button type="submit" class="btn btn-primary regist-button">
                    <i class="bi bi-check-circle-fill"></i> Registar
                </button>

                <div class="regist-footer">
                    <p>Ao registar, concorda com os nossos <a href="#">Termos e Condições</a></p>
                </div>

            </form>
        </div>
    </div>

    <script src="../js/regist.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>