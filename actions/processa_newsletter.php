<?php
session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_SESSION['user']; 

    if (!$email) {
        ?>
        <script>
            alert('Faça login para se subscrever!');
            window.location.href = '../index.php';
        </script>
        <?php
        exit; // Para o código aqui se não houver email
    }

    //GUARDAR NA BASE DE DADOS
    $sucesso = guardar_newsletter($con, [
        'email' => $email,
    ]);

    if($sucesso > 0){
        // Enviar o email
        $mail = require_once __DIR__ . '/../includes/mailer.php';

        $mail->setFrom("martimdias.pap@gmail.com", "Pastelaria PAP");
        $mail->addAddress($email);
        $mail->Subject = "Obrigado por subscrever a newsletter";
        $mail->Body = <<<END
            <h2>Obrigado pela subscrição!</h2>
            <p>Esteja atento porque a partir de agora irá receber todas as novidades primeiro que toda a gente.</p>
            <br><br>
            <p>Qualquer questão disponha!</p>
END;

        try {
            $mail->send(); 
            ?>
            <script>
                alert('Obrigado por subscrever a nossa newsletter. Verifique o seu email!');
                window.location.href = '../index.php';
            </script>
            <?php
        } catch (Exception $e) {
            ?>
            <script>
                alert('Erro ao enviar email: <?= $mail->ErrorInfo ?>');
                window.location.href = '../index.php';
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert('Já está subscrito ou ocorreu um erro ao subscrever!');
            window.location.href = '../index.php';
        </script>
        <?php
    }
}
?>