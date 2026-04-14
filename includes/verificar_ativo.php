<?php
// Inclui o ficheiro de base de dados para garantir que a variável $con existe
require_once __DIR__ . '/db.php'; 

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Agora o $con já deve estar disponível porque fizemos o require_once acima
    $sql_check = "SELECT ativo FROM utilizadores WHERE id = '$user_id' LIMIT 1";
    $res_check = mysqli_query($con, $sql_check);
    
    if ($res_check) {
        $user_check = mysqli_fetch_assoc($res_check);

        if (!$user_check || $user_check['ativo'] == 0) {
            session_destroy();
            header("Location: /../pages/login.php");
            exit;
        }
    }
}