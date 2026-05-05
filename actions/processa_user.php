<?php
// ============================================================
// FICHEIRO: actions/processa_user.php
// O QUE FAZ: Recebe o formulário de registo e guarda o novo
// utilizador na base de dados.
// ============================================================

session_start();

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/carrinho.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LER OS DADOS DO FORMULÁRIO ---
    $nome             = trim($_POST['nome']             ?? '');
    $email            = trim($_POST['email']            ?? '');
    $telefone         = trim($_POST['telefone']         ?? '');
    $data_nascimento  = trim($_POST['data_nascimento']  ?? '');
    $password         = trim($_POST['confirm_password'] ?? '');

    // --- VALIDAÇÕES BÁSICAS ---
    if (empty($nome) || empty($email) || empty($password) || (!empty($data_nascimento) && !dd_validar_idade_minima($data_nascimento))) {
        $_SESSION['regist_error'] = 'Por favor insira todos os dados obrigatórios e/ou verifique a sua data de nascimento.';
        header('Location: ../pages/regist.php');
        exit;
    }

    
    $stmtCheck = $con->prepare("SELECT id FROM utilizadores WHERE email = ? LIMIT 1");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    // Verifica se o email já existe na BD
    if ($stmtCheck->num_rows > 0) {
        $_SESSION['regist_error'] = 'Este email já está registado.';
        $stmtCheck->close();
        header('Location: ../pages/regist.php');
        exit;
    }
    $stmtCheck->close();

    // --- HASH DA PASSWORD ---
    // Nunca guardamos a password em texto — usamos bcrypt
    $hashPass = password_hash($password, PASSWORD_DEFAULT);

    // --- DATA DE NASCIMENTO ---
    // Pode ser null se o utilizador não preencheu
    $dataNasc = !empty($data_nascimento) ? $data_nascimento : null;

    // --- INSERIR NA BASE DE DADOS ---
    $sql = "INSERT INTO utilizadores (nome, email, pass, telefone, data_nascimento) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $hashPass, $telefone, $dataNasc);

    if ($stmt->execute()) {
        $_SESSION['regist_success'] = 'Registo feito com sucesso! Podes fazer login.';
        header('Location: ../pages/login.php');
    } else {
        $_SESSION['regist_error'] = 'Erro ao fazer o registo: ' . $stmt->error;
        header('Location: ../pages/regist.php');
    }

    $stmt->close();
    exit;
}

$con->close();
?>