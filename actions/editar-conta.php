<?php
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../includes/db.php';
    dd_start_session();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../pages/login.php');
        exit;
    }

    $user_id  = (int)$_SESSION['user_id'];
    $email    = trim($_POST['email']   ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if ($email) {
        $stmt = $con->prepare("UPDATE utilizadores SET email = ?, telefone = ? WHERE id = ?");
        $stmt->bind_param("ssi", $email, $telefone, $user_id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['user'] = $email; 
    }

    header('Location: ../pages/data/user-data.php');
    exit;
?>