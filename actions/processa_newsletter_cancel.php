<?php
require_once __DIR__ . '/../includes/db.php';

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
    
    // Validar formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Email inválido!');
                window.location.href = '../index.php'; 
              </script>";
        exit;
    }

    // Usar prepared statement para segurança
    $stmt = $con->prepare("UPDATE newsletter_subscritores SET ativo = 0 WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Cancelaste a subscrição da newsletter com sucesso!');
                window.location.href = '../index.php'; 
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cancelar a subscrição. Tenta novamente.');
                window.location.href = '../index.php'; 
              </script>";
    }
    
    $stmt->close();
}
?>