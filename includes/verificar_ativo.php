<?php
// Inclui o ficheiro de base de dados para garantir que a variável $con existe
require_once __DIR__ . '/db.php'; 

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Verificar se o utilizador está ativo (prepared statement para segurança)
    $stmt = $con->prepare("SELECT ativo FROM utilizadores WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user_check = $result->fetch_assoc();

        if ($user_check['ativo'] == 0) {
            session_destroy();
            header("Location: ../../pages/login.php");
            exit;
        }
    } else {
        // Utilizador não encontrado
        session_destroy();
        header("Location: ../../pages/login.php");
        exit;
    }
    
    $stmt->close();
}