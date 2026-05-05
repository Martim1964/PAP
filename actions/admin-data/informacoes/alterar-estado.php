<?php
require_once __DIR__ . '/../../../includes/carrinho.php';
require_once __DIR__ . '/../../../includes/db.php';
dd_start_session();

if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
    header('Location: ../../pages/login.php');
    exit;
}

$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

$estados_validos = ['1', '0'];

if ($id > 0 && in_array($estado, $estados_validos)) {
    $stmt = $con->prepare("UPDATE informacoes SET ativo = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: ../../../pages/data/admin-data-info.php');
exit;
?>