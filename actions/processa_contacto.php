<?php
// ============================================================
// FICHEIRO: actions/processa_contacto.php
// O QUE FAZ: Recebe o formulário de contacto e guarda a
// mensagem na base de dados.
// ============================================================

session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LER OS DADOS DO FORMULÁRIO ---
    $nome  = $_SESSION['nome'];
    $email = $_SESSION['user'];
    $telefone = trim($_POST['telefone'] ?? '');
    $assunto  = trim($_POST['assunto']  ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // --- VALIDAÇÃO BÁSICA ---
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $_SESSION['contacto_erro'] = 'Por favor preenche todos os campos obrigatórios.';
        header('Location: ../pages/contactos.php');
        exit;
    }

    // --- GUARDAR NA BASE DE DADOS ---
    $nomeEsc     = mysqli_real_escape_string($con, $nome);
    $emailEsc    = mysqli_real_escape_string($con, $email);
    $telefoneEsc = mysqli_real_escape_string($con, $telefone);
    $assuntoEsc  = mysqli_real_escape_string($con, $assunto);
    $mensagemEsc = mysqli_real_escape_string($con, $mensagem);

    $inserir = "INSERT INTO contactos (nome, email, telefone, assunto, mensagem)
                VALUES ('$nomeEsc', '$emailEsc', '$telefoneEsc', '$assuntoEsc', '$mensagemEsc')";

    if (mysqli_query($con, $inserir)) {
        // Mostra o alert e redireciona para a página de contactos
        echo "<script>
            alert('Mensagem enviada com sucesso! Irá receber um email em breve.');
            window.location.href = '../pages/contactos.php';
        </script>";
    } else {
        $_SESSION['contacto_erro'] = 'Erro ao enviar mensagem. Tenta novamente.';
        header('Location: ../pages/contactos.php');
    }

    exit;
}

mysqli_close($con);