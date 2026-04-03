<?php
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../pages/login.php');
        exit;
    }

    $user_id  = (int)$_SESSION['user_id'];
    $tamanho    = mysqli_real_escape_string($con, trim($_POST['tamanho_edit']   ?? ''));
    $massa    = mysqli_real_escape_string($con, trim($_POST['massa_edit']   ?? ''));
    $recheio    = mysqli_real_escape_string($con, trim($_POST['recheio_edit']   ?? ''));
    $quantidade   = mysqli_real_escape_string($con, trim($_POST['quantidade_edit']   ?? ''));
    $dataEvento    = mysqli_real_escape_string($con, trim($_POST['data_evento_edit']   ?? ''));
    $precoUnit   = mysqli_real_escape_string($con, trim($_POST['preco_unit_edit']  ));

    $preco_total    = round($precoUnit * $quantidade, 2);
    $iva            = round($preco_total * 0.23, 2);

    if ($user_id) {
        $sql = "UPDATE encomendas-personalizadas SET
        tamanho_edit = $tamanho, massa_edit = $massa,
        recheio_edit = $recheio, quantidade = $quantidade,
        data_evento_edit = $dataEvento, precoUnit = $precoUnit,
        precoTotal = $preco_total, iva = $iva,
         WHERE id = $user_id";
         
        mysqli_query($con, $sql);
    }

    header('Location: ../pages/data/user-data.php');
    exit;
?>