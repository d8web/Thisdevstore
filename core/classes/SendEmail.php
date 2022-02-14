<?php
namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail {

    /**
     * @param string $emailClient
     * @param string $hash
     * @return bool 
    */
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

    /**
     * @param string $emailClient
     * @param array $dataOrder
     * @return bool 
    */
    public static function sendEmailConfirmOrder(string $emailClient, array $dataOrder): bool {

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

    /**
     * @param array $orderData
     * @return bool 
    */
    public static function sendEmailSendProduct(array $orderData): bool {

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
            $mail->addAddress($orderData["order"]->email);

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . " - Sua compra foi enviada ".$orderData["order"]->code_order;

            // Message
            $html = "<h1>Olá ".$orderData["order"]->name.", tudo bem?</h1>";
            $html .= "<p>Estou aqui para informar que a sua compra já foi enviada para os correios.</p>";
            $html .= "<p>Portanto ela deve chegar nos próximos dias.</p>";
            $html .= "<p>Pedimos para que fique de olho na sua caixa de correio.</p>";

            $html .= "Código da compra = ".$orderData["order"]->code_order;

            // Montando lista dos produtos que o cliente comprou
            $html .= "<ul>";
            foreach ($orderData["orderProducts"] as $product) {
                $html .= "<li> $product->quantity X - $product->name </li>";
            }
            $html .= "</ul>";


            $mail->Body = $html;
            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $emailClient
     * @param string $fileName
     * @return bool
    */
    public static function sendPDFOrderFromClient(string $emailClient, string $name) {

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
            $mail->Subject = APP_NAME . ' - PDF com detalhes da sua compra';

            // Messagem
            $html = '<p>Veja no anexo um pdf com os detalhes da sua compra.</p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';

            // Anexo
            $mail->addAttachment( PDF_PATH . $name);

            $mail->Body = $html;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }

    }

}
