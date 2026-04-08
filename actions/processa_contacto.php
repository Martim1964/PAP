<?php
// ============================================================
// FICHEIRO: actions/processa_contacto.php
// O QUE FAZ: Recebe o formulário de contacto e guarda a
// mensagem na base de dados.
// ============================================================

session_start();

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LER OS DADOS DO FORMULÁRIO ---
    $nome  = $_SESSION['nome'];
    $email = $_SESSION['user'];
    $telefone = $_SESSION['telemovel'];

    // --- GUARDAR NA BASE DE DADOS ---
    $sucesso = guardar_contacto($con, [
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
        'assunto' => $_POST['assunto'],
        'mensagem' => $_POST['mensagem'],
    ]);
    }

    //Fazer o email personalizado
    $lineBuy = "";
    $lineBuy .= "";
    $lineBuy .= ' | Nome: ' . $nome;
    $lineBuy .= ' | Assunto: ' . $_POST['assunto'];
    $lineBuy .= ' | Mensagem: ' . $_POST['mensagem'];
    
    //Enviar o email
    if($email){
        $mail = require_once __DIR__ . '/../includes/mailer.php';

        $mail -> setFrom("martimdias.pap@gmail.com");
        $mail -> addAddress($email);
        $mail -> addAddress("martimdias.pap@gmail.com"); //Envia para mim 
        $mail->addReplyTo($email, $nome); //Para responder logo ao cliente a partir da menssagem enviada para mim

        $mail -> Subject = "Mensagem enviada com sucesso";
        $mail -> Body = <<<END

        <h2> Obrigado pelo envio da mensagem!</h2>
        <p>Brevemente entraremos em contacto para responder à sua mensagem via email ou número de telefone</p>
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
                alert('Contacto enviado com sucesso. Verifique o seu email!');
                window.location.href = '../index.php';
             </script>;
             <?php
        } catch (Exception $e) {
            ?>
            <script>
                alert('Menssagem não enviada: <?=  $mail->ErrorInfo ?>');
            window.location.href = '../pages/contactos.php';
        </script>";
             <?php
        }
    }
        else {
            ?>
             <script>
                alert('Erro ao enviar a mensagem!');
                window.location.href = '../pages/contactos.php';
             </script>;

            <?php
        }    
?>