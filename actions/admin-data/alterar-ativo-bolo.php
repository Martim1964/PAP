<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }
$id   = (int)$_GET['id'];
$ativo = (int)$_GET['ativo'];
mysqli_query($con, "UPDATE catalogo_bolos SET ativo = $ativo WHERE id = $id");
header('Location: ../../pages/data/admin-data-bolos.php');
exit;