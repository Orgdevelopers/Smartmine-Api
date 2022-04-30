<?php

require_once("config.php");

if(isset($_GET['token'])){
    $headers = [
        "Accept: application/json",
        "Content-Type: application/json",
        
    ];
    
    $data = [
        "hash_token" => $_GET['token']
    ];

    $url = "http://thesmartmine.com/smartmine-api/api.php/verifyemail";

    $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $return = curl_exec($ch);
      $json_data = json_decode($return, true);
        
      
      $curl_error = curl_error($ch);
      $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   
      if($json_data['code']=="200"){
          echo "<script>
          alert('Email verified successfully. close this page and restart app');
          window.location.assign('https://thesmartmine.com');

      </script>";      

      }else{
        echo "<script>
          alert('Email verification failed. please contact support');
          window.location.assign('https://thesmartmine.com');

      </script>";

      }
    
}else{
    echo "<script>
          window.location.assign('https://thesmartmine.com');

      </script>";
}


?>


