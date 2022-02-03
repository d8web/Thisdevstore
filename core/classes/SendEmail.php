<?php
namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail {

    // ===========================================================================
    public function sendEmailConfirmNewClient(string $emailClient, string $hash): bool {

        $link = BASE_URL . '?a=confirmEmail&hash=' . $hash;
        $mail = new PHPMailer(true);

        try {
            
            // Server config
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_FROM;
            $mail->Password   = EMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = "UTF-8";

            // Emissor e recebedor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($emailClient);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de e-mail';

            // Messagem
            $html = '<p>Seja bem-vindo a nossa loja' . APP_NAME . '.</p>';
            $html .= '<p>Para concluir o seu cadastro, você precisa confirmar seu e-mail!</p>';
            $html .= '<p>Clique no link abaixo para confirmar:</p>';
            $html .= '<p><a href="' . $link . '">Confirmar Email</a></p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';

            $mail->Body = $html;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
