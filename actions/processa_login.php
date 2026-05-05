<?php
session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['pass'] ?? '';

$stmt = $con->prepare("
    SELECT id, nome, email, pass, telefone, admin
    FROM utilizadores
    WHERE email = ? AND ativo = 1
    LIMIT 1
");
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user && password_verify($senha, $user['pass'])) {
    //Cria sessions importantes para uso mais à frente
    $_SESSION['user']      = $user['email'];
    $_SESSION['nome']      = $user['nome'];
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['admin']     = $user['admin'];
    $_SESSION['telemovel'] = $user['telefone'];

    header('Location: ../index.php');
    exit;
}

$_SESSION['loginErro'] = 'Email ou password incorretos ou conta desativada.';
header('Location: ../pages/login.php');
exit;
