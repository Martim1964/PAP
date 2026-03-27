<?php
// ============================================================
// FICHEIRO: actions/processa_user.php
// O QUE FAZ: Recebe o formulário de registo e guarda o novo
// utilizador na base de dados.
// ============================================================

session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LER OS DADOS DO FORMULÁRIO ---
    $nome             = trim($_POST['nome']             ?? '');
    $email            = trim($_POST['email']            ?? '');
    $telefone         = trim($_POST['telefone']         ?? '');
    $data_nascimento  = trim($_POST['data_nascimento']  ?? '');
    $password         = trim($_POST['confirm_password'] ?? '');

    // --- VALIDAÇÕES BÁSICAS ---
    if (empty($nome) || empty($email) || empty($password)) {
        $_SESSION['regist_error'] = 'Por favor preenche todos os campos obrigatórios.';
        header('Location: ../pages/regist.php');
        exit;
    }

    // Verifica se o email já existe na BD
    $emailEscapado = mysqli_real_escape_string($con, $email);
    $verificar = mysqli_query($con, "SELECT id FROM utilizadores WHERE email = '$emailEscapado' LIMIT 1");
    if (mysqli_num_rows($verificar) > 0) {
        $_SESSION['regist_error'] = 'Este email já está registado.';
        header('Location: ../pages/regist.php');
        exit;
    }

    // --- HASH DA PASSWORD ---
    // Nunca guardamos a password em texto — usamos bcrypt
    $hashPass = password_hash($password, PASSWORD_DEFAULT);

    // --- DATA DE NASCIMENTO ---
    // Pode ser null se o utilizador não preencheu
    $dataNasc = !empty($data_nascimento) ? "'$data_nascimento'" : "NULL";

    // --- INSERIR NA BASE DE DADOS ---
    $nomeEsc     = mysqli_real_escape_string($con, $nome);
    $emailEsc    = mysqli_real_escape_string($con, $email);
    $telefoneEsc = mysqli_real_escape_string($con, $telefone);
    $hashEsc     = mysqli_real_escape_string($con, $hashPass);

    $inserir = "INSERT INTO utilizadores (nome, email, pass, telefone, data_nascimento)
                VALUES ('$nomeEsc', '$emailEsc', '$hashEsc', '$telefoneEsc', $dataNasc)";

    if (mysqli_query($con, $inserir)) {
        $_SESSION['regist_success'] = 'Registo feito com sucesso! Podes fazer login.';
        header('Location: ../pages/login.php');
    } else {
        $_SESSION['regist_error'] = 'Erro ao fazer o registo: ' . mysqli_error($con);
        header('Location: ../pages/regist.php');
    }

    exit;
}

mysqli_close($con);