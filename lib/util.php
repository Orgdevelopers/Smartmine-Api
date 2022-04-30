<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

class Utails {

    public function SendEmmail($to,$subject,$msg)
    {
        

            // $to = $data['email']."";
            // $subject = $data['subject'];
            // $msg = $data['msg'];

            //$mail = new PHPMailer(true);
            
            $headers  = "From: Smartmine Verification Services <noreply@thesmartmine.com>\n";
            //$headers .= "Cc: testsite <mail@testsite.com>\n"; 
            $headers .= "X-Sender: Smartmine Verification Services <noreply@thesmartmine.com>\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            //$headers .= "X-Priority: 1\n"; // Urgent message!
            $headers .= "Return-Path: noreply@thesmartmine.com\n"; // Return path for errors
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
            
            if(mail($to,$subject,$msg,$headers)){
                return true;
            }else{
                return false;
            }

            // try {
            //     //Server settings
            //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //     $mail->isSMTP();                                            // Send using SMTP
            //     $mail->Host       = 'localhost';                    // Set the SMTP server to send through
            //     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            //     $mail->Username   = 'noreply@thesmartmine.com';                     // SMTP username
            //     $mail->Password   = 'noreply@thesmartmine.com';                               // SMTP password
            //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            //     $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //     //Recipients
            //     $mail->setFrom('noreply@thesmartmine.com', 'Smartmine');
            //     $mail->addAddress($to);     // Add a recipient
            // // $mail->addAddress('ellen@example.com');               // Name is optional
            //     $mail->addReplyTo('noreply@thesmartmine.com', 'noreply@thesmartmine.com');
            //     //$mail->addCC('cc@example.com');
            //     //$mail->addBCC('bcc@example.com');
        
            //     // Attachments
            //     //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            //     // Content
            //     $mail->isHTML(false);                                  // Set email format to HTML
            //     $mail->Subject = $subject;
            //     $mail->Body    = $msg;
            //     //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            //     $mail->send();
            //     echo "success";
            // } catch (Exception $e) {
            //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //     return false;
            // }
        


    }

}

?>