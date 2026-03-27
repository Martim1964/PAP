<?php

$token = $_POST["token"];//Vai buscar o token que esta no /pages/reset-password.php

$token_hash = hash("sha256", $token); //vai fazer o hash dessa password

$mysqli = require __DIR__ . "/../includes/db.php"; //buscar a pagina do diretorio db.php para fazer a ligacao a base de dados e alterar os dados do user


$sql = "SELECT * FROM utilizadores 
        WHERE reset_token_hash = ?";

//Prepara e executa a query
$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result(); 

$user = $result->fetch_assoc();

if ($user === null) {
    ?>
        <script>
            alert ('Utilizador não encontrado!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    ?>
        <script>
            alert ('O tempo expirou!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

if (strlen($_POST["password"]) < 8) {
    ?>
        <script>
            alert ('A password tem que ter mais que 8 caracteres!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    ?>
        <script>
            alert ('A password tem que ter pelo menos 1 letra!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    ?>
        <script>
            alert ('A password tem que ter pelo menos 1 número!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    ?>
        <script>
            alert ('As passwords têm de coincidir!');
            window.location.href= "../pages/forgot-password.php";
        </script>
    <?php
}

//Vai encriptar a password inserida pelo utilizador
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

//Vai alterar na BD a password, vai dar reset ao token hash e token expires at do id em questao
$sql = "UPDATE utilizadores
        SET pass = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

?>

<script>
    alert ('Password atualizada, faça login!');
    window.location.href= "../pages/login.php";
</script>