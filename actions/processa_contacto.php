<?php
$servidor = "localhost"; 
$user = "root"; 
$pass = ""; 
$db_name = "pap_db";

$con = mysqli_connect($servidor, $user, $pass, $db_name);
if(!$con){
    die("Falha na conexão à BD: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nome = ($_POST['nome']);
    $email = ($_POST['email']);
    $telefone =($_POST['telefone']);
    $assunto = ($_POST['assunto']);
    $mensagem = ($_POST['mensagem']);
    
    $inserir = "INSERT INTO contactos (nome, email, assunto, mensagem, telefone) 
                VALUES ('$nome', '$email', '$assunto', '$mensagem', '$telefone')";
    
    if(mysqli_query($con, $inserir)){
        echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href='../pages/contactos.php';</script>";
    } else {
        echo "<script>alert('Erro ao enviar mensagem: " . mysqli_error($con) . "');</script>";
    }
}

mysqli_close($con);
?>