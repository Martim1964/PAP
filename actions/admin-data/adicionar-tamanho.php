<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bolo_slug = $_POST['bolo_slug'] ?? '';
    $label = $_POST['label'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $preco = (float)($_POST['preco'] ?? 0);
    $ordem = (int)($_POST['ordem'] ?? 0);
    
    $stmt = $con->prepare("INSERT INTO tamanhos_produtos (bolo_slug, label, slug, preco, ordem, ativo) 
                       VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssdi", $bolo_slug, $label, $slug, $preco, $ordem);
    $stmt->execute();
    $stmt->close();
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
