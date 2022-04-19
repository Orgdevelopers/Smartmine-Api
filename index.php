<?php

 require 'vendor/phpmailer/phpmailer/phpmailer/src/Exception.php';
 require 'vendor/phpmailer/phpmailer/phpmailer/src/PHPMailer.php';
 require 'vendor/phpmailer/phpmailer/phpmailer/src/SMTP.php';

 require 'vendor/phpmailer/autoload.php';

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 use PHPMailer\PHPMailer\SMTP;

 $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = '139.59.2.121';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'kindu@problemdeal.tk';                     // SMTP username
    $mail->Password   = 'kindu@problemdeal.tk';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('kinddusingh1k2k3@gmail.com', 'Joe User');     // Add a recipient
   // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

function getCurrentBtcDollar() {
    //
    $url='https://bitpay.com/api/rates';
    $json=json_decode( file_get_contents( $url ) );
    $btc=0;

    foreach( $json as $obj ){
        if( $obj->code=='USD' )$btc=$obj->rate;
    }

    return $btc;
}

?>