<?php
    require_once __DIR__ . '/../../includes/carrinho.php';
    require_once __DIR__ . '/../../includes/db.php';
    dd_start_session();

    // Entrar só se a conta que entrou for a do admin
    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../pages/login.php');
        exit;
    }

    $id     = isset($_GET['id']) ? (int)$_GET['id'] : 0; //Ver o id da conta que o estado foi alterado
    $estado = isset($_GET['estado']) ? mysqli_real_escape_string($con, $_GET['estado']) : ''; //Alterar  o estado

    $estados_validos = ['1', '0']; //Verifica o nome do estado
    
    if ($id > 0 && in_array($estado, $estados_validos)) { //Altera o estado conforme a escolha do admin
        $sql = "UPDATE utilizadores SET ativo = '$estado' WHERE id = $id";
        mysqli_query($con, $sql);
        
        ?>
            <script>
                alert('Estado do cliente alterado com sucesso');
                window.location.href = '../../pages/data/admin-data-clientes.php';
             </script>";
        <?php
    }     

?>