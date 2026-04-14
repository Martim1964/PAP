<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label = mysqli_real_escape_string($con, $_POST['label'] ?? '');
    $slug = mysqli_real_escape_string($con, $_POST['slug'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $premium = (int)($_POST['premium'] ?? 0);
    
    mysqli_query($con, "INSERT INTO recheios (label, slug, preco, premium, ativo) 
                       VALUES ('$label', '$slug', $preco, $premium, 1)");
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
