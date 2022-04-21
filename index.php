<?php

require_once("config.php");

$conn = mysqli_connect($hostname,$db_user,$password,$database);

if(!$conn){
    echo "connection failed";
    die;
}

$qry = mysqli_query($conn, "select * from plans");

$data = mysqli_fetch_all($qry);

echo json_encode($data);

?>

