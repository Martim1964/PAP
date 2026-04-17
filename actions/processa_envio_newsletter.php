<?php
session_start();
require_once __DIR__ . '/../includes/db.php';


if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    die("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $sucesso = guardar_newsletter_enviada($con);

    // Vou buscar todos os email dos subscritores
    $query = "SELECT email, ativo FROM newsletter_subscritores WHERE ativo = '1'";
    $result = mysqli_query($con, $query);

    $contador = 0; //Crio a variável para contar todos os emails 

    if (mysqli_num_rows($result) > 0) { // Se for enconntrado algum email envia a mensagem
        $mail = require_once __DIR__ . '/../includes/mailer.php';

        $mail->setFrom("martimdias.pap@gmail.com");
        $mail->Subject = $assunto;

        while ($row = mysqli_fetch_assoc($result)) { //Enquanto existirem emails para enviar na base de dados
            $email = $row['email']; //Crio a variavel que vai buscar os emails

            try {
                $mail->addAddress($email); //Envia para os emails presentes na BD
                $mail->Body = <<<END

            <h2> Novas novidades Doces Dias!</h2>
            $mensagem
            <br><br>
            <p>Qualquer questão disponha!</p>
            <br><br><br>
            Não quer receber mais newsletters? 
            <a href="http://localhost/PAP/actions/processa_newsletter_cancel.php?email=$email">
            Clique aqui para cancelar a subscrição
            
            END;
                
                if($mail->send()) {
                    $contador++; //Conta o numero de emails que foram enviados
                }

                // Limpo os endereços de email para uma nova newsletter
                $mail->clearAddresses();
                
            } catch (Exception $e) {
                // Se um falhar, ignora e continua para o próximo
                continue;
            }
        }

        echo "<script>
                alert('Newsletter enviada com sucesso para $contador subscritores!');
                window.location.href = '../pages/data/admin-data.php'; 
              </script>";
    } else {
        echo "<script>
                alert('Não existem subscritores na lista.');
                window.location.href = '../pages/data/admin-data.php'; 
              </script>";
    }
}