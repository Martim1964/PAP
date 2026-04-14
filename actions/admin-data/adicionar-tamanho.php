<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bolo_slug = mysqli_real_escape_string($con, $_POST['bolo_slug'] ?? '');
    $label = mysqli_real_escape_string($con, $_POST['label'] ?? '');
    $slug = mysqli_real_escape_string($con, $_POST['slug'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $ordem = (int)($_POST['ordem'] ?? 0);
    
    mysqli_query($con, "INSERT INTO tamanhos_produtos (bolo_slug, label, slug, preco, ordem, ativo) 
                       VALUES ('$bolo_slug', '$label', '$slug', $preco, $ordem, 1)");
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
