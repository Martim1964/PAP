<?php
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../pages/login.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id         = (int)$_POST['encomenda_id'];
            $tamanho    = mysqli_real_escape_string($con, $_POST['tamanho_edit']);
            $massa      = mysqli_real_escape_string($con, $_POST['massa_edit']);
            $recheio    = mysqli_real_escape_string($con, $_POST['recheio_edit']);
            $quantidade = (int)$_POST['quantidade_edit'];
            $dataEvento = mysqli_real_escape_string($con, $_POST['data_evento_edit']);

            $precoUnit      = mysqli_real_escape_string($con, $_POST['preco_unit_edit']);
            $precoTotal     = round($precoUnit * $quantidade, 2);
            $iva            = round($precoTotal * 0.23, 2); 


            $sql = "UPDATE encomendas_personalizadas SET 
            tamanho_final = '$tamanho', massa_final = '$massa', recheio_final = '$recheio',
            quantidade_final = $quantidade, data_evento_final = '$dataEvento', preco_unit = $precoUnit,
            preco_total = $precoTotal, iva = $iva, estado = 'confirmada'
            WHERE id = $id";

            if(mysqli_query($con, $sql)){
                header('Location: ../pages/data/admin-data.php?msg=confirmada');
            } else{
                header('Location: ../pages/data/admin-data.php?msg=erro');
            }
           
        }
    
?>