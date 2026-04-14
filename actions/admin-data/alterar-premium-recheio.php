<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/carrinho.php';
dd_start_session();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) { header('Location: ../login.php'); exit; }
$id   = (int)$_GET['id'];
$premium = (int)$_GET['premium'];
mysqli_query($con, "UPDATE recheios SET premium = $premium WHERE id = $id");
header('Location: ../../pages/data/admin-data-bolos.php');
exit;
