<?php

//mysql database


$hostname = "localhost";
$database   = "prob_lemdeal";
$db_user = 'prob_lemdeal';
$password = 'prob_lemdeal';
$portt = 3307;

//email - 
$smtp_name = "Smartmine Customer Support";
$smtp_from = "support@domain.com";
$smtp_host= "host";
$smtp_username = "ex@ex.com";
$smtp_password = "password";
$smtp_port = 465; // user 25 for vps

$skip_mail = true; //turn this off after setting up smtp


$base_url = "https://hashcoiner.com/";
$api_key = "10001200-AAGGDDSE-99332299-ssttmmnn";


define('DB_HOST',$hostname);
define('DB_DATABASE',$database);
define('DB_USERNAME',$db_user);
define('DB_PASSWORD',$password);
define('DB_PORT',$portt);
define('BASE_URL',$base_url);
define('SMTP_HOST',$smtp_host);
define('SMTP_USERNAME',$smtp_username);
define('SMTP_PASSWORD',$smtp_password);
define('SMTP_PORT',$smtp_port);
define('SMTP_NAME',$smtp_name);
define('SMTP_FROM',$smtp_from);

define('SKIP_MAIL',$skip_mail);

// $headers = [
//     "Accept: application/json",
//     "Content-Type: application/json",
//     "API-KEY: ".$api_key." "
// ];

// $data = [
//     "role"=> "admin"
// ];

// $ch = curl_init('the-metasoft.tk/Api');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// $return = curl_exec($ch);
// echo $return;
// // $json_data = json_decode($return, true);
  

// // $curl_error = curl_error($ch);
// // $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// // $data = $json_data['msg'];


?>