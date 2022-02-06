<?php
namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail {

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

    public function sendEmailConfirmOrder(string $emailClient, array $dataOrder): bool {

        $mail = new PHPMailer(true);

        try {
            // Server config
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
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
            $mail->Subject = APP_NAME . " - Confirmação da compra - " . $dataOrder["paymentData"]["codeOrder"];

            // Message
            $html = "<h2>Confirmação da sua compra.</h2>";
            $html .= "<p>Dados compra: </p>";

            // Montando lista dos produtos que o cliente comprou
            $html .= "<ul>";
            foreach ($dataOrder["products"] as $product) {
                $html .= "<li>$product</li>";
            }
            $html .= "</ul>";

            // Total
            $html .= "<p>Total: <strong>" . $dataOrder["total"] . "</strong></p>";

            // Dados de pagamento
            $html .= "<hr>";
            $html .= "<p>DADOS DE PAGAMENTO</p>";
            $html .= "<p>Número da conta: <strong>" . $dataOrder["paymentData"]["numberAccount"] . "</strong></p>";
            $html .= "<p>Código da encomenda: <strong>" . $dataOrder["paymentData"]["codeOrder"] . "</strong></p>";
            $html .= "<p>Total a pagar: <strong>" . $dataOrder["paymentData"]["total"] . "</strong></p>";
            $html .= "<hr>";

            // Nota importante
            $html .= "<p>NOTA: A sua encomenda só será processada após o pagamento!</p>";

            $mail->Body = $html;
            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

}
