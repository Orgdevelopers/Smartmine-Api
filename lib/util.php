<?php

class Utails {

    public function SendEmmail($data)
    {
        $email = $data['email'];
        $subject = $data['subject'];
        $msg = $data['msg'];

        return true;

    }

}

?>