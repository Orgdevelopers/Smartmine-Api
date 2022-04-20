<?php

use function PHPSTORM_META\map;

class Utails {

    public function SendEmmail($data)
    {
        $email = $data['email'];
        $subject = $data['subject'];
        $msg = $data['msg'];

        $headers = 'From: info@hashcoiner.com' . "\r\n" .
            'Reply-To: info@hashcoiner.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion(). "\r\n" .
            'Content-Type: text/html; charset=utf-8' ;


        // if(mail($email,$subject,$msg,$headers)){
        //     return true;

        // }else{
        //     return false;
        // }
        return true;

    }

}

?>