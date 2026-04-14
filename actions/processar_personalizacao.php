
<?php
    session_start();
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../includes/db.php';
    //Inserir na base de dados
    $user_id = $_SESSION['user_id']; 
    $fileName = $_FILES["photo"]["name"]; //Criar variavel que vai buscar a imagem e o seu respetivo nome
    //Criar variavel a dizer o caminho que a imagem deve fazer, ou seja em que pasta vai ser posta 
    $path = __DIR__ . '/../img-pap/upload-bolos-personalizados/' . $_FILES['photo']['name'];
    //Confirmar que ela foi para aquela posta e inserir na base de dados
    if(move_uploaded_file($_FILES['photo']['tmp_name'], $path)){
    $sucesso = guardar_encomenda_personalizada($con, [
        'utilizador_id'  => $user_id,
        'tamanho'        => $_POST['tamanho'],
        'massa'          => $_POST['massa'],
        'recheio'        => $_POST['recheio'],
        'data_evento'    => $_POST['birthday'] ?? date('d-m-Y'),
        'observacoes'    => $_POST['observacoes'],
        'tema'           => $_POST['tema'], 
        'imagem'         => $fileName,
    ]);
    }


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
                alert('Menssagem não enviada: <?=  $mail->ErrorInfo ?>');
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