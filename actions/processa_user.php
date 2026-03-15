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
    $password = trim($_POST['confirm_password']); 
    $telefone = ($_POST['telefone']);

    $password = htmlspecialchars($password); 

    $hashPass= password_hash($password, PASSWORD_DEFAULT); 
    
    $inserir = "INSERT INTO utilizadores (nome, email, pass, telefone) 
                VALUES ('$nome', '$email', '$hashPass', '$telefone')";
    
    if(mysqli_query($con, $inserir)){
        echo "<script>alert('Registo feito com sucesso!'); window.location.href='../pages/login.php';</script>";
    } else {
        echo "<script>alert('Erro ao fazer o registo: " . mysqli_error($con) . "');</script>";
    }
}

mysqli_close($con);
?>