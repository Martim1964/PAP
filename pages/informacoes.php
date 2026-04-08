<?php
require_once __DIR__ . '/../includes/carrinho.php';
require_once __DIR__ . '/../includes/db.php';

dd_start_session();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img-pap/logotipo-docesdias.jpg">
    <link rel="stylesheet" href="../css/informacoes.css">
    <title>Informações - Doces Dias</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-subtitle">As melhores informações para os nossos clientes</h2>
                <div class="logo-container">
                    <img src="../img-pap/logotipo-docesdias.jpg" alt="Doces Dias Logo" class="hero-logo">
                </div>
            </div>
        </div>
    </section>

    <div class="infos-grid container">
    <?php 
        $infos = buscar_infos($con); 
        if (empty($infos)): 
    ?>
        <p class="text-center w-100 my-5">Não há informações disponíveis de momento.</p>
    <?php else: ?>
        <?php foreach ($infos as $info): ?> 
            <article class="info-card">
                <div class="info-card-body">
                    <h2><?= htmlspecialchars($info['nome']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($info['conteudo'])) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


    <?php include '../includes/footer.php'; ?>
</body>
</html>