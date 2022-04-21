<?php

//$_SERVER['PATH_INFO'];


if($_SERVER['PATH_INFO']!="/"){
    $headers =  apache_request_headers();
    //if(isset($headers['API-KEY']) && verify_api_key($headers['API-KEY'])){
        
        require_once("lib/util.php");
        require_once("model/autoload.php");
        require_once("db/dbconnecter.php");
        require_once("lib/Functions.php");


        require 'vendor/phpmailer/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/phpmailer/src/SMTP.php';

        require 'vendor/phpmailer/autoload.php';

        include_once('Controllers/apicontroller.php');

        
    

        //process next
        $dat = new apiController();
        $dat->init();

    //}else{
       // echo 'access denied';
    //}

}else{
    //api call from browser without request
    header("Location: ../");//redirect to index page;

}


function verify_api_key($key):bool{
    require_once('config.php');
    if($key==$api_key){
        return true;
    }else{
        return false;
    }

}

function empty_data(){
    $echo['code']="499";
    $echo['msg']= "incomplete data";

    echo json_encode($echo);
    die;
}

//api commit test

?>