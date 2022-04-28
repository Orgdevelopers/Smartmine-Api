<?php

// require_once("config.php");

// $conn = mysqli_connect($hostname,$db_user,$password,$database);

// if(!$conn){
//     echo "connection failed";
//     die;
// }

// $qry = mysqli_query($conn, "select * from plans");

// $data = mysqli_fetch_all($qry);

// echo json_encode($data);

require_once("lib/util.php");
require_once("model/autoload.php");
require_once("db/dbconnecter.php");
require_once("lib/Functions.php");
require_once("config.php");


require 'vendor/phpmailer/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/phpmailer/src/SMTP.php';

require 'vendor/phpmailer/autoload.php';

$util = new Utails();

$data['email'] = "kinddusingh1k2k3@gmail.com";
$data['subject'] = "Hello world";
$data['msg'] = "ksdfjskldfjasddf ;lksdjflksjlasjflkflasjdsdpokfj";

$util->SendEmmail($data);


?>

