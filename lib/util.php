<?php

use function PHPSTORM_META\map;

class Utails {

    public function SendEmmail($data)
    {
        $email = $data['email'];
        $subject = $data['subject'];
        $msg = $data['msg'];

        // $headers  = "From: Smartmine Support <info@hashcoiner.com>\n";
        // //$headers .= "Cc: testsite <mail@testsite.com>\n"; 
        // $headers .= "X-Sender: Smartmine Support <info@hashcoiner.com>\n";
        // $headers .= 'X-Mailer: PHP/' . phpversion();
        // $headers .= "X-Priority: 1\n"; // Urgent message!
        // $headers .= "Return-Path: info@hashcoiner.com\n"; // Return path for errors
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

        $headers = 'From: Smartmine Support <info@hashcoiner.com>' . "\r\n" .
            'Reply-To: info@hashcoiner.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion(). "\r\n" .
            'Content-Type: text/html; charset=iso-8859-1' ;
       


        if(mail($email,$subject,$msg,$headers)){
            return true;

        }else{
            return false;
        }
        return true;

    }

}

?>