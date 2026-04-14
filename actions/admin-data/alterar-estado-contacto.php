<?php
    require_once __DIR__ . '/../../includes/db.php';
    require_once __DIR__ . '/../../includes/carrinho.php';
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../login.php');
        exit;
    }

    $id     = isset($_GET['id'])     ? (int)$_GET['id']                        : 0;
    $estado = isset($_GET['estado']) ? mysqli_real_escape_string($con, $_GET['estado']) : '';

    if ($id > 0 && in_array($estado, ['pendente', 'respondido'])) {
        mysqli_query($con, "UPDATE contactos SET estado = '$estado' WHERE id = $id");
        ?>
            <script>
                alert('Estado do contacto alterado com sucesso');
                window.location.href = '../../pages/data/admin-data-clientes.php';
             </script>";
        <?php
    } else {
        ?>
            <script>
                alert('Erro ao alterar estado do contacto');
                window.location.href = '../../pages/data/admin-data-clientes.php';
             </script>";
        <?php
    }
    exit;