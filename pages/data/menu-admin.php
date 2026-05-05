<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();

if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img-pap/logotipo-docesdias.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Import Bootstrap styles - navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Import Bootstrap JavaScript functionality - navbar-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"><!-- Import Bootstrap icons -->
    <title>Admin - Doces Dias</title>
</head>
<body>
<?php include __DIR__ . '/../../includes/header-bolos.php'; ?>

<main>

<div class="container my-5">
    <h6 class="text-muted text-uppercase fw-semibold">Doces Dias</h6>
    <h1 class="mb-5">Painel de administrador</h1> <?php //Titulo ?>

    <div class="row g-3">
        <div class="col-md-6">
            <a href="admin-data-encomendas.php" class="card text-decoration-none h-100 p-4"><?php //Ligação a pagina da gestao de encomendas ?>
                <h5>Gestão de encomendas</h5>
                <p class="text-muted mb-0">Ver e atualizar o estado das encomendas normais e personalizadas.</p>
            </a>
        </div>
        <div class="col-md-6">
            <a href="admin-data-clientes.php" class="card text-decoration-none h-100 p-4"> <?php //Ligação a pagina da gestao de clientes ?>
                <h5>Gestão de clientes</h5>
                <p class="text-muted mb-0">Pesquisar clientes, ativar contas e gerir permissões de administrador.</p>
            </a>
        </div>
        <div class="col-md-6"> 
            <a href="admin-data-info.php" class="card text-decoration-none h-100 p-4"> <?php //Ligação a pagina da gestao da pagina de informacoes ?>
                <h5>Gestão da página de informações</h5>
                <p class="text-muted mb-0">Adicionar, reordenar e gerir as informações visíveis ao público.</p>
            </a>
        </div>
        <div class="col-md-6">
            <a href="admin-data-newsletters.php" class="card text-decoration-none h-100 p-4"> <?php //Ligação a pagina da gestao da gestao de newsletters ?>
                <h5>Gestão de newsletters</h5>
                <p class="text-muted mb-0">Redigir e enviar newsletters para todos os subscritores.</p>
            </a>
        </div>

        <div class="col-md-6">
            <a href="admin-data-bolos.php" class="card text-decoration-none h-100 p-4"> <?php //Ligação a pagina da gestao de bolos ?>
                <h5>Gestão de bolos</h5>
                <p class="text-muted mb-0">Adicionar novos produtos, novas massas, recheios e tamanhos.</p>
            </a>
        </div>
    </div>
</div>

</main>

<?php include __DIR__ . '/../../includes/footer-bolos.php'; ?>
</body>
</html>