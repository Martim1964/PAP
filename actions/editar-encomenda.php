<?php

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../includes/carrinho.php';
    require_once __DIR__ . '/../includes/db.php';
    
    dd_start_session();

    if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
        header('Location: ../pages/login.php');
        exit;
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST'){ //Recebe os dados inseridos pelo administrador
            $id         = (int)$_POST['encomenda_id'];
            $tamanho    = mysqli_real_escape_string($con, $_POST['tamanho_edit']);
            $massa      = mysqli_real_escape_string($con, $_POST['massa_edit']);
            $recheio    = mysqli_real_escape_string($con, $_POST['recheio_edit']);
            $quantidade = (int)$_POST['quantidade_edit'];
            $dataEvento = mysqli_real_escape_string($con, $_POST['data_evento_edit']);

            $precoUnit      = mysqli_real_escape_string($con, $_POST['preco_unit_edit']);
            $precoTotal     = round($precoUnit * $quantidade, 2);
            $iva            = round($precoTotal * 0.23, 2); 

            //Atualiza a tabela das encomendas personalizadas com as novas alterações
            $sql = "UPDATE encomendas_personalizadas SET 
            tamanho_final = '$tamanho', massa_final = '$massa', recheio_final = '$recheio',
            quantidade_final = $quantidade, data_evento_final = '$dataEvento', preco_unit = $precoUnit,
            preco_total = $precoTotal, iva = $iva, estado = 'confirmada'
            WHERE id = $id";

            mysqli_query($con, $sql); //Executar a query inserindo todos os dados 
        

            //Calcular preço com iva para o email
            $precoComIva = (float)$precoTotal + $iva;

            $nome = $_SESSION['nome']; //Ir buscar o nome do cliente

            $lineBuy = ""; //Criar variavel para inserir os dados da encomenda personalizada
            
            //Inserir os dados da encomenda
            $lineBuy .= "";
            $lineBuy .= ' | Nome: ' . $nome;
            $lineBuy .= ' | Tamanho: ' . $tamanho;
            if($massa){ 
                $lineBuy .= ' | Massa: ' . $massa;
            }
            if($recheio){
                $lineBuy .= ' | Massa: ' . $recheio;
            }
            $lineBuy .= ' | Quantidade: ' . $quantidade;
            $lineBuy .= ' | Data do evento: ' . $dataEvento;
            $lineBuy .= ' | Preço total pago: ' . $precoComIva;


            

            $email = $_SESSION['user']; //Ir buscar o email do utilizador para enviar o email
            if($email){
            $mail = require_once __DIR__ . '/../includes/mailer.php';

            $mail->setFrom("martimdias.pap@gmail.com"); //Aqui é o email que enviará a mensagem
            $mail->addAddress($email); 
            $mail->Subject = "A sua encomenda personalizada foi confirmada!"; //Titulo da mensagem
            //Abaixo a mensagem usada e a configuração da mesma 
            $mail->Body = <<<END

            <h2>Obrigado por personalizar a sua encomenda connosco!</h2>
            <h2>A sua encomenda acabou de ser confirmada, obrigado pela confiança!</h2>
            <p>Acompanhe a sua encomenda personalizada na sua área reservada.</p>
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
                    alert('Email enviado e dados postos na BD com sucesso.');
                    window.location.href = '../pages/data/admin-data.php';
                </script>;
                <?php
            } catch (Exception $e) {
                ?>
                <script>
                    alert('Menssagem não enviada: {$mail->ErrorInfo}');
                    window.location.href = '../pages/data/admin-data.php';
                </script>";
                <?php
            }
        }

            }else {
                header('Location: ../pages/data/admin-data.php');
            }
           
        
    
?>