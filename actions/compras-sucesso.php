<?php

    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../includes/db.php';

    $itensCart = dd_carrinho_get(); //Buscar os itens do carrinho antes de serem limpos
    
    //Criar variavel para por o preco total somado pago pelo utilizador
    $total = 0;
    //Fazer o email personalizado
    $lineBuy = "";

    
    //Inserir na base de dados
    $user_id = $_SESSION['user_id'] ?? null;
    foreach($itensCart as $item){
        $sucesso = guardar_encomenda($con, [
            'utilizador_id'  => $user_id,
            'bolo_slug'      => $item['bolo_id'],
            'bolo_nome'      => $item['nome'],
            'tamanho_slug'   => $item['tamanho'],
            'tamanho_label'  => $item['tamanho_label'],
            'massa_slug'     => $item['massa'] ?? '',
            'massa_label'    => $item['massa_label'] ?? '',
            'recheio_slug'   => $item['recheio'] ?? '',
            'recheio_label'  => $item['recheio_label'] ?? '',
            'data_evento'    => $item['data_evento'] ?? date('d-m-Y'),
            'observacoes'    => $item['observacoes'],
            'quantidade'     => (int)$item['quantidade'],
            'preco_unitario' => (float)$item['preco_unitario'],
        ]);
    }


    //Calcular preços para serem postos no email
    foreach($itensCart as $item){
        $precoComIva = (float)$item['preco_unitario'] * 1.23 *$item['quantidade'];
        $total += $precoComIva;

        $lineBuy .= "";
        $lineBuy .= ' | Nome: ' . $item['nome'];
        $lineBuy .= ' | Tamanho: ' . $item['tamanho_label'];
        $lineBuy .= ' | Recheio: ' . $item['recheio_label'];
        $lineBuy .= ' | Massa: ' . $item['massa_label'];
        $lineBuy .= ' | Quantidade: ' . $item['quantidade'];
        $lineBuy .= ' | Preço final: ' . $total . "€";
    }

    //Limpar o carrinho pois os itens ja foram guardados
    dd_carrinho_limpar();


    //Enviar o email
    $email = $_SESSION['user']; //Ir buscar o email que esta na sessao de utilizador
    if($email){
        $mail = require_once __DIR__ . '/../includes/mailer.php';

        $mail->setFrom("martimdias.pap@gmail.com"); //Aqui é o email que enviará a mensagem
        $mail->addAddress($email); 
        $mail->Subject = "Obrigado pela sua encomenda!"; //Titulo da mensagem
        //Abaixo a mensagem usada e a configuração da mesma 
        $mail->Body = <<<END

        <h2>Obrigado pela sua compra!</h2>
        <p>Acompanhe a sua encomenda na área reservada.</p>
        <br>
        <strong>Detalhes da sua encomenda:</strong><br>
        $lineBuy
        <br><br>
        Qualquer questão disponha!

        END;
        

         try {
            $mail->send(); //Aqui envia a mensagem que está na variável $mail
            ?>
            <script>
                alert('Obrigado pela sua compra. Verifique o seu email!');
                window.location.href = '../index.php';
             </script>;
             <?php
        } catch (Exception $e) {
            ?>
            <script>
                alert('Menssagem não enviada: {$mail->ErrorInfo}');
                window.location.href = '../pages/compras-finalizar.php';
             </script>";
             <?php
        }
    }
        else {
            ?>
             <script>
                alert('Erro no pagamento!');
                window.location.href = '../pages/compras-finalizar.php';
             </script>;

            <?php
        }
    


?>


