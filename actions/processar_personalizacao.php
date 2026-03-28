
<?php
    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';
    //Fazer o email personalizado
    $lineBuy = "";
    $lineBuy .= "";
    $lineBuy .= ' | Tamanho: ' . $_POST['tamanho'];
    $lineBuy .= ' | Massa: ' . $_POST['massa'];
    $lineBuy .= ' | Recheio: ' . $_POST['recheio'];
    $lineBuy .= ' | Data de entrega: ' . $_POST['birthday'];
    if($_POST['observacoes']){
        $lineBuy .= ' | Observações: ' . $_POST['observacoes'];
    }
    $lineBuy .= ' | Imagem: ' . 'A mesma foi inserida com sucesso, vai para verificação';

    //Enviar o email
    $email = $_SESSION['user']; //Ir buscar o email que esta na sessao de utilizador
    if($email){
        $mail = require_once __DIR__ . '/../includes/mailer.php';

        $mail -> setFrom("martimdias.pap@gmail.com");
        $mail -> addAddress($email);
        $mail -> Subject = "Personalizacao de encomenda";
        $mail -> Body = <<<END

        <h2> Obrigado por personalizar a sua encomenda connosco!</h2>
        <p>Brevemente entraremos em contacto para confirmação de todos os detalhes via email ou número de telefone</p>
        <p>Após confirmação pode acompanhar a sua encomenda na sua área reservada</p>
        <br>    
        <strong>Detalhes da sua encomenda:</strong><br>
        $lineBuy
        <br><br>
        <p>Qualquer questão disponha!</p>
        
        END;

        try {
            $mail->send(); //Aqui envia a mensagem que está na variável $mail
            ?>
            <script>
                alert('Obrigado por personalizar a sua encomenda connosco. Verifique o seu email!');
                window.location.href = '../index.php';
             </script>;
             <?php
        } catch (Exception $e) {
            ?>
            <script>
                alert('Menssagem não enviada: {$mail->ErrorInfo}');
                window.location.href = '../pages/bolospersonalizados.php';
             </script>";
             <?php
        }
    }
        else {
            ?>
             <script>
                alert('Erro no pagamento!');
                window.location.href = '../pages/bolospersonalizados.php';
             </script>;

            <?php
        }    
?>