<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label = $_POST['label'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $preco = (float)($_POST['preco'] ?? 0);
    $premium = (int)($_POST['premium'] ?? 0);
    
    $stmt = $con->prepare("INSERT INTO massas (label, slug, preco, premium, ativo) 
                       VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("ssdi", $label, $slug, $preco, $premium);
    $stmt->execute();
    $stmt->close();
}
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
