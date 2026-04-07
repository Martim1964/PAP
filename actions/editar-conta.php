<?php
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../pages/login.php');
        exit;
    }

    $user_id  = (int)$_SESSION['user_id'];
    $email    = mysqli_real_escape_string($con, trim($_POST['email']   ?? ''));
    $telefone = mysqli_real_escape_string($con, trim($_POST['telefone'] ?? ''));

    if ($email) {
        $sql = "UPDATE utilizadores SET email = '$email', telefone = '$telefone' WHERE id = $user_id";
        mysqli_query($con, $sql);
        $_SESSION['user'] = $email; 
    }

    header('Location: ../pages/data/user-data.php');
    exit;
?>