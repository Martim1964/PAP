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

    <main id="main-content" class="container regist-container">
        <img class="img-fluid" src="../img-pap/logotipo-docesdias.jpg" alt="Logótipo da Doces Dias">

        <div class="regist-form-content">
            <h2 class="regist-title">Já tem conta? <a href="login.php">Faça login</a></h2>

            <?php if (isset($_SESSION['regist_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i>
                    <?= htmlspecialchars($_SESSION['regist_error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar aviso"></button>
                </div>
                <?php unset($_SESSION['regist_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['regist_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    <?= htmlspecialchars($_SESSION['regist_success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar aviso"></button>
                </div>
                <?php unset($_SESSION['regist_success']); ?>
            <?php endif; ?>

            <form action="../actions/processa_user.php" method="POST" class="regist-form" id="registForm">
                <div class="mb-3">
                    <label for="nome" class="form-label">
                        <i class="bi bi-person-fill" aria-hidden="true"></i> Nome
                    </label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="O teu nome completo" minlength="3" maxlength="120" aria-describedby="nome-help" required>
                    <small class="form-text" id="nome-help">Mínimo 3 caracteres.</small>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope-fill" aria-hidden="true"></i> Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="seu.email@exemplo.com" aria-describedby="email-help" required>
                    <small class="form-text" id="email-help">Usaremos este email para contacto.</small>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill" aria-hidden="true"></i> Senha
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="password" name="password_hash" placeholder="••••••••" minlength="8" aria-describedby="password-help" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('password')" aria-controls="password" aria-label="Mostrar senha" aria-pressed="false">
                            <i class="bi bi-eye-fill" aria-hidden="true"></i>
                        </button>
                    </div>
                    <small class="form-text" id="password-help">Mínimo 8 caracteres.</small>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">
                        <i class="bi bi-lock-fill" aria-hidden="true"></i> Confirme a sua Senha
                    </label>
                    <div class="password-input-wrapper">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="••••••••" minlength="8" aria-describedby="confirm-password-help" required>
                        <button type="button" class="btn-toggle-password" onclick="togglePassword('confirm_password')" aria-controls="confirm_password" aria-label="Mostrar confirmação da senha" aria-pressed="false">
                            <i class="bi bi-eye-fill" aria-hidden="true"></i>
                        </button>
                    </div>
                    <small class="form-text" id="confirm-password-help">As senhas devem coincidir.</small>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">
                        <i class="bi bi-phone-fill" aria-hidden="true"></i> Nº Telemóvel
                    </label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="913 047 889" aria-describedby="telefone-help" required>
                    <small class="form-text" id="telefone-help">Usaremos este número para contacto.</small>
                </div>

                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">
                        <i class="bi bi-cake-fill" aria-hidden="true"></i> Data de Nascimento
                    </label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                </div>

                <button type="submit" class="btn btn-primary regist-button">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i> Registar
                </button>

                <div class="regist-footer">
                    <p>Ao registar, concorda com os nossos <a href="#">Termos e Condições</a></p>
                </div>
            </form>
        </div>
    </main>

    <script src="../js/regist.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
