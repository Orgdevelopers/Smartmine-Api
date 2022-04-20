<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

class Utails {

    public function SendEmmail($data)
    {
        // $email = $data['email'];
        // $subject = $data['subject'];
        // $url = $data['url'];

        // // $headers  = "From: Smartmine Support <info@hashcoiner.com>\n";
        // // //$headers .= "Cc: testsite <mail@testsite.com>\n"; 
        // // $headers .= "X-Sender: Smartmine Support <info@hashcoiner.com>\n";
        // // $headers .= 'X-Mailer: PHP/' . phpversion();
        // // $headers .= "X-Priority: 1\n"; // Urgent message!
        // // $headers .= "Return-Path: info@hashcoiner.com\n"; // Return path for errors
        // // $headers .= "MIME-Version: 1.0\r\n";
        // // $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

        // $headers = 'From: Smartmine Support <info@hashcoiner.com>' . "\r\n" .
        //     'Reply-To: info@hashcoiner.com' . "\r\n" .
        //     'X-Mailer: PHP/' . phpversion(). "\r\n" .
        //     'Content-Type: text/html; charset=iso-8859-1' ;
       
        // $str = strval(file_get_contents('http://hashcoiner.com/api/templates/email_template.php'),false);

        // $str = str_replace('aaaaaaaaaaaaaaaa',$url."",$str,1);

        // if(mail($email,$subject,$str,$headers)){
        //     return true;

        // }else{
        //     return false;
        // }

         $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'support@hashcoiner.com';                     // SMTP username
        $mail->Password   = 'support@hashcoiner.com';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('support@hashcoiner.com', 'Smartmine Support');
        $mail->addAddress('kinddusingh1k2k3@gmail.com', 'Joe User');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('support@hashcoiner.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

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


    }

}

?>