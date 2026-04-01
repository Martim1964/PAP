<?php
session_start();

$servidor = "localhost";
$user = "root";
$pass = "";
$db_name = "pap_db";

$con = mysqli_connect($servidor, $user, $pass, $db_name);
if (!$con) {
    die("Falha na conexão à BD: " . mysqli_connect_error());
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $senha = $_POST['pass'];

    // Preserve an optional redirect target so that after login the user goes back to the intended page.
    $redirectTo = '';
    if (!empty($_POST['redirect'])) {
        $redirectTo = trim($_POST['redirect']);
        $redirectTo = preg_replace('/[\r\n]/', '', $redirectTo);

        // Prevent open redirects and path traversal.
        if (preg_match('#^(?:https?:)?//#i', $redirectTo) || strpos($redirectTo, '..') !== false) {
            $redirectTo = '';
        }
    }

    // Default destination after successful login.
    $destination = '../index.php';
    if ($redirectTo !== '') {
        $redirectTo = ltrim($redirectTo, '/\\');
        $destination = '../pages/' . $redirectTo;
    }

    $query = "SELECT * FROM utilizadores WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        if(password_verify($senha, $row['pass'])){
            $_SESSION['user'] = $row['email'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['admin']   = $row['admin'];
            header("Location: $destination");
            exit;
        } else {
            $_SESSION['loginErro'] = "Email ou password incorretos.";
            $loginPage = '../pages/login.php';
            if ($redirectTo !== '') {
                $loginPage .= '?redirect=' . urlencode($redirectTo);
            }
            header("Location: $loginPage");
            exit;
        }
    } else {
        $_SESSION['loginErro'] = "Email ou password incorretos.";
        $loginPage = '../pages/login.php';
        if ($redirectTo !== '') {
            $loginPage .= '?redirect=' . urlencode($redirectTo);
        }
        header("Location: $loginPage");
        exit;
    }
}


mysqli_close($con);
?>