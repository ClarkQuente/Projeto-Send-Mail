<?php

    /* SEM SEGURANÇA
    require("../../../app_send_mail/libs/PHPMailer/Exception.php");
    require("../../../app_send_mail/libs/PHPMailer/OAuthTokenProvider.php");
    require("../../../app_send_mail/libs/PHPMailer/OAuth.php");
    require("../../../app_send_mail/libs/PHPMailer/PHPMailer.php");
    require("../../../app_send_mail/libs/PHPMailer/POP3.php");
    require("../../../app_send_mail/libs/PHPMailer/SMTP.php");

    require('../../../app_send_mail/process_email.php');
    */

    if(!isset($_POST['email'])) {
        header('Location: ../index.php');
        die();
        return;
    }

    require("../libs/PHPMailer/Exception.php");
    require("../libs/PHPMailer/OAuthTokenProvider.php");
    require("../libs/PHPMailer/OAuth.php");
    require("../libs/PHPMailer/PHPMailer.php");
    require("../libs/PHPMailer/POP3.php");
    require("../libs/PHPMailer/SMTP.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Message {

        private $to;
        private $subject;
        private $message;
        private $status;

        public function __construct($to, $subject, $message) {
            $this->to = $to;
            $this->subject = $subject;
            $this->message = $message;
            $this->status = array('codigo_status' => 0, 'descricao_status' => '');
        }

        public function __get($attribute) {
            return $this->$attribute;
        }

        public function __set($attribute, $value) {
            $this->$attribute = $value;
        }

        public function isMessageValid() {
            if(empty($this->__get('to')) || empty($this->__get('subject')) || empty($this->__get('message'))) return false;
            return true;
        }
    }

    $message = new Message($_POST['email'], $_POST['assunto'], $_POST['mensagem']);

    if(!$message->isMessageValid()) {
        header('Location: ../index.php?error=fields');
        echo 'non-valid';
        return;
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug  = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'username';                     //SMTP username
        $mail->Password   = 'smtp-password';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('email-remetente', 'remetente');
        $mail->addAddress($message->__get('to'), 'Destinatário');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = ucfirst($message->__get('subject'));
        $mail->Body    = str_replace('TEST', '<strong>TEST</strong>', $message->__get('message'));
        $mail->AltBody = $message->__get('message');

        $mail->send();

        $status = array('codigo_status' => 1, 'descricao_status' => 'E-mail enviado com sucesso.');
        $message->__set('status', $status);

    } catch (Exception $e) {

        $status = array('codigo_status' => 2, 'descricao_status' => 'Houve um erro na tentativa de enviar o email. Detalhes do erro: ' . $mail->ErrorInfo);
        $message->__set('status', $status);
    }
?>

<html>
    <head>
        <title>App Mail Send</title>
        <meta charset="utf-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <div class="text-center py-3">
                <img src="../images/logo.png" width="72" height="72" class="d-block mx-auto mb-2">
                <h2>Send Mail</h1>
                <p class="lead">Seu app de envio de e-mails particular!</p>

                <?php if(isset($_GET['error']) && $_GET['error'] == 'fields') { ?>
                    
                    <div class="text-center text-danger">
                        <h3>Preencha todos os campos corretamente.</h3>
                    </div>

                <?php } ?>
            </div>

            <div class="row">
                <div class="col">
                    <?php if($message->status['codigo_status'] == 1) { ?>
                        
                        <div class="container">
                            <h1 class="display-4 text-success">Sucesso</h1>
                            <p><?= $message->status['descricao_status'] ?></p>
                            <a href="../index.php" class="btn btn-lg btn-success mt-5 text-white">Voltar</a>
                        </div>

                    <?php } ?>

                    <?php if($message->status['codigo_status'] == 2) { ?>
                        
                        <div class="container">
                            <h1 class="display-4 text-danger">Erro</h1>
                            <p><?= $message->status['descricao_status'] ?></p>
                            <a href="../index.php" class="btn btn-lg btn-danger mt-5 text-white">Voltar</a>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>