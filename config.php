<?php

$hostname = "localhost";
$database   = "startmine_db";
$db_user = 'root';
$password = '';
$portt = '3307';

$base_url = "https://the-metasoft.tk/Startmine_api/";
$api_key = 'QnVLNHRm-M1M3eEd4-UWJ4ZTBR-YW9UU2py-L2JGVDRX-UEdSek95dz0=';


define('DB_HOST',$hostname);
define('DB_DATABASE',$database);
define('DB_USERNAME',$db_user);
define('DB_PASSWORD',$password);
define('DB_PORT',$portt);
define('BASE_URL',$base_url);

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