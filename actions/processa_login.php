<?php
session_start();

// Configurações de ligação (Idealmente isto estaria num ficheiro externo config.php)
$servidor = "localhost";
$user     = "root";
$pass     = "";
$db_name  = "pap_db";

// Conexão em estilo POO
$con = new mysqli($servidor, $user, $pass, $db_name);

if ($con->connect_error) {
    die("Falha na conexão: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['pass'])) {
    $email = $_POST['email'];
    $senha = $_POST['pass'];

    // --- Lógica de Redirecionamento ---
    $redirectTo = $_POST['redirect'] ?? '';
    $destination = '../index.php';

    if (!empty($redirectTo)) {
        $redirectTo = preg_replace('/[\r\n]/', '', trim($redirectTo));
        // Bloqueia redirecionamentos externos ou path traversal
        if (!preg_match('#^(?:https?:)?//#i', $redirectTo) && strpos($redirectTo, '..') === false) {
            $destination = '../pages/' . ltrim($redirectTo, '/\\');
        } else {
            $redirectTo = ''; // Reset se for inválido
        }
    }

    // --- Prepared Statement ---
    $sql = "SELECT * FROM utilizadores WHERE email = ? AND ativo = 1 LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verifica a password
        if (password_verify($senha, $row['pass'])) {
            $_SESSION['user']      = $row['email'];
            $_SESSION['nome']      = $row['nome'];
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['admin']     = $row['admin'];
            $_SESSION['telemovel'] = $row['telefone'];
            
            header("Location: $destination");
            exit;
        }
    }

    // --- Se chegar aqui, algo falhou (Login Incorreto) ---
    $_SESSION['loginErro'] = "Email ou password incorretos ou conta desativada.";
    $loginPage = '../pages/login.php' . ($redirectTo ? '?redirect=' . urlencode($redirectTo) : '');
    
    header("Location: $loginPage");
    exit;
}

$con->close();