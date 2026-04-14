<?php

    $email = $_POST['email']; //Ir buscar o email posto na página forgot-password.php

    $token = bin2hex(random_bytes(16)); //Criar um token com random bytes transformando-os em hexadecimal
    $token_hash = hash("sha256", $token); //Transforma o token num bloco com 256 bits

    $expira = date("Y-m-d H:i:s", time() + 60 * 30); //Criar variável que serve para dizer que o token ou seja o cliente tem 30 minutos para alterar a password
    $mysqli = require __DIR__ . "/../includes/db.php"; //A função mysqli irá buscar a página de ligação à BD

    //Esta função servirá para atualizar a tabela de utilizadores inserindo o token naquele utilizador para ser verificado na página final de reset da password
    $sql = "UPDATE utilizadores
    SET reset_token_hash = ?, 
            reset_token_expires_at = ?
        WHERE email = ?"; 
    
    //Aqui irá preparar a função e executá-la, utiliza se prepared statements para evitar SQL Injection
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $token_hash, $expira, $email); //Vai buscar o token_hash, a expiração do token e também o email que o user utilizou
    mysqli_stmt_execute($stmt);

    //Verifica se o email existe na BD
    if ($mysqli->affected_rows > 0) {
        $mail = require __DIR__ . "/../includes/mailer.php"; //Vai buscar os dados do SMTP no mailer.php

        $mail->setFrom("martimdias.pap@gmail.com"); //Aqui é o email que enviará a mensagem
        $mail->addAddress($email); 
        $mail->Subject = "Password Reset"; //Titulo da mensagem
        //Abaixo a mensagem usada e a configuração da mesma 
        $mail->Body = <<<END

        Clica <a href="http://localhost/PAP/pages/reset-password.php?token=$token">aqui</a> 
        para trocar a sua password.

        END;

        try {
            $mail->send(); //Aqui envia a mensagem que está na variável $mail
            ?>
            <script>
                alert('Mensagem enviada. Verifique o seu email!');
                window.location.href = '../pages/login.php';
             </script>;
             <?php
        } catch (Exception $e) {
            ?>
            <script>
                alert('Menssagem não enviada: {$mail->ErrorInfo}');
                window.location.href = '../pages/forgot-password.php';
             </script>";
             <?php
        }
    }
        else {
            ?>
             <script>
                alert('Email inválido, utilize o seu email registado!');
                window.location.href = '../pages/forgot-password.php';
             </script>;

            <?php
        }
?>
    