<?php

//mysql database


$hostname = "localhost";
$database   = "test";
$db_user = 'root';
$password = '';
$portt = 3306;

//email - 
$smtp_name = "Smartmine Customer Support";
$smtp_from = "noreply@thesmartmine.com";
$smtp_host= "server1.multiplecloudminer.com";
$smtp_username = "noreply@thesmartmine.com";
$smtp_password = "noreply@thesmartmine.com";
$smtp_port = 465; // user 25 for vps

$skip_mail = false; //turn this off after setting up smtp


$base_url = "https://thesmartmine.com/smartmine-api/";
$api_key = "10001200-AAGGDDSE-99332299-ssttmmnn";

$upload_dir =  __DIR__."/uploads/images/";

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
define("UPLOADS_DIR",$upload_dir);
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