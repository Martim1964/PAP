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
    $estado = isset($_GET['estado']) ? $_GET['estado'] : ''; //Alterar  o estado

    $estados_validos = ['1', '0']; //Verifica o nome do estado
    
    if ($id > 0 && in_array($estado, $estados_validos)) { //Altera o estado conforme a escolha do admin
        $stmt = $con->prepare("UPDATE utilizadores SET ativo = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id);
        $stmt->execute();
        $stmt->close();

    // Se a conta foi desativada, desativa também a newsletter
    if ($estado == '0') {
        $stmt2 = $con->prepare("UPDATE newsletter_subscritores ns JOIN utilizadores u ON u.email = ns.email SET ns.ativo = '0' WHERE u.id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();
    }
        
        ?>
            <script>
                alert('Estado do cliente alterado com sucesso');
                window.location.href = '../../pages/data/admin-data-clientes.php';
             </script>";
        <?php
    }     

?>