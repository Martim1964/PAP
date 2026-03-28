<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ . "/../vendor/autoload.php";

    $mail = new PHPMailer(true); 
    //Confirmar que a variavel $mail usa o SMTPServer e configurar
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com"; //O email em questão é do tipo gmail.com
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Encripta a segurança do SMTP
    $mail->Port = 587;//Uso da porta usada pelo SMTP
    $mail->Username = "martimdias.pap@gmail.com"; //O meu email de envio
    $mail->Password = "mvqlawuhysnspyjl"; //Uso da password dado pelo GmailSMTP

    $mail->isHtml(true);

    return $mail;
?>