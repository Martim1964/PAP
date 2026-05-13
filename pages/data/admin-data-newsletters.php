<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    $user_id = (int)$_SESSION['user_id'];

    // Buscar total de subscritores
    $result_total = mysqli_query($con, "SELECT COUNT(*) AS total FROM newsletter_subscritores");

    $result_historico = mysqli_query($con, "SELECT * FROM newsletters_enviadas ORDER BY data_envio");

    // Mensagem de feedback (após envio)
    $mensagem = $_GET['mensagem'] ?? '';
    $tipo     = $_GET['tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Newsletter - Admin Doces Dias</title>
</head>
<body>
    <?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

    <main>

    <div class="container my-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="menu-admin.php"><i class="bi bi-house"></i> Painel</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-3 mb-4">
            <h1 class="mb-0"><i class="bi bi-envelope-at"></i> Gestão de Newsletter</h1>
        </div>


        <!-- Histórico de newsletters enviadas -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Newsletters enviadas</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Assunto</th>
                            <th>Mensagem</th>
                            <th>Data de envio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_historico) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_historico)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['assunto']) ?></td>
                                <td><?= htmlspecialchars($row['mensagem']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($row['data_envio'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Nenhuma newsletter enviada ainda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulário de envio -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-send"></i> Enviar nova newsletter</h5>
            </div>
            <div class="card-body p-4">
                <form action="../../actions/processa_envio_newsletter.php" method="POST">

                    <div class="mb-3">
                        <label for="assunto-email" class="form-label fw-semibold">
                            Assunto do email <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="assunto-email"
                            name="assunto"
                            class="form-control"
                            placeholder="Ex: Novidades de Páscoa na Doces Dias!"
                            maxlength="150"
                            required
                        >
                        <div class="form-text">Máximo de 150 caracteres.</div>
                    </div>

                    <div class="mb-4">
                        <label for="mensagem-email" class="form-label fw-semibold">
                            Mensagem <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="mensagem-email"
                            name="mensagem"
                            class="form-control"
                            rows="8"
                            placeholder="Escreva aqui a mensagem para todos os seus clientes..."
                            required
                        ></textarea>
                    </div>

                    <!-- Pré-visualização -->
                    <div class="mb-4">
                        <div id="preview-box" class="border rounded p-3 mt-3 bg-light d-none">
                            <p class="text-muted small mb-1 fw-semibold">ASSUNTO:</p>
                            <p id="preview-assunto" class="mb-3 fw-semibold"></p>
                            <p class="text-muted small mb-1 fw-semibold">MENSAGEM:</p>
                            <p id="preview-mensagem" class="mb-0" style="white-space: pre-wrap;"></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary" id="btn-enviar">
                            <i class="bi bi-send-fill"></i> Enviar para todos os subscritores
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Botão de regresso -->
        <a href="menu-admin.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar ao painel
        </a>

    </div>


    </main>

    <?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>