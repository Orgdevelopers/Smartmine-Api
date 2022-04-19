<?php

class Database{
	
	private $host  = DB_HOST;
    private $user  = DB_USERNAME;
    private $password   = DB_PASSWORD;
    private $database  = DB_DATABASE; 
    private $port = DB_PORT;
    
    public function getConnection(){		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database,$this->port);
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}



?>