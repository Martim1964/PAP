<?php
require_once __DIR__ . '/../../../includes/db.php';
require_once __DIR__ . '/../../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $preco = (float)($_POST['preco'] ?? 0);
    
    $stmt = $con->prepare("UPDATE recheios SET preco = ? WHERE id = ? ");
    $stmt->bind_param("di",$preco, $id);
    $stmt->execute();
    $stmt->close();
}
header('Location: ../../../pages/data/admin-data-bolos.php');
exit;