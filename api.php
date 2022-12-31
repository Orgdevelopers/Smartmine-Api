<?php
$php_self =  $_SERVER['PHP_SELF'];
$request_uri =  $_SERVER['REQUEST_URI'];

$php_self=str_replace("/","",$php_self);
$php_self=str_replace("index.php","/",$php_self);

$request_uri=str_replace($php_self,"",$request_uri);
//$request_uri = substr($request_uri,1);
//$request_uri=str_replace("/","",$request_uri);

//check api key
//verfiy_api_key();

//call method
$url = explode('/',$request_uri);

$controller = $url[count($url)-2];
$request = $url[count($url)-1];
//$_SERVER['PATH_INFO'];


if($controller=="admin"){

}else if($controller=="api"){
    require_once("lib/util.php");
        require_once("model/autoload.php");
        require_once("db/dbconnecter.php");
        require_once("lib/Functions.php");
        require_once("config.php");


        require 'vendor/phpmailer/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/phpmailer/src/SMTP.php';

        require 'vendor/phpmailer/autoload.php';

        include_once('Controllers/apicontroller.php');

        
    

        //process next
        $controller = new apiController();
        $controller->init();
        $controller->handle_request($request);

}else{
    //api call from browser without request
    header("Location: ../");//redirect to index page;
}

// if($_SERVER['PATH_INFO']!="/"){
//     //$headers =  apache_request_headers();
//     //if(isset($headers['API-KEY']) && verify_api_key($headers['API-KEY'])){
        
        

//     //}else{
//        // echo 'access denied';
//     //}

// }else{
    

// }


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


?>