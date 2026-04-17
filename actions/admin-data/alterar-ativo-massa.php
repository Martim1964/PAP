<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }
$id   = (int)$_GET['id'];
$ativo = (int)$_GET['ativo'];
$stmt = $con->prepare("UPDATE massas SET ativo = ? WHERE id = ?");
$stmt->bind_param("ii", $ativo, $id);
$stmt->execute();
$stmt->close();
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
