<?php

class Plan {

    public function createPlan($data)
    {
        if ($this->conn && $data!=null) {
            $name = $data['name'];
            $algo = $data['algo'];
            $speed = $data['speed'];
            $duration = $data['duration'];
            $earning = $data['earning'];
            $price = $data['price'];
            $package = $data['package'];
            $created = gmdate("Y-m-d H:i:s");
            
            $qry = "INSERT INTO plans(id, name, algo, speed, duration, earning, price, package, created)
                        VALUES ('0','$name','$algo','$speed','$speed','$earning','$price','$package','$created')";

            if($this->conn->query($qry)){
                return true;

            }else{
                return false;
            }        

        }else{
            return false;
        }
    }


    public function getdetails($data)
    {
        if ($this->conn && $data!=null) {
            $id = $data['id'];
            $qry = mysqli_query($this->conn,"SELECT * FROM plans WHERE id='$id'");

            $result = mysqli_fetch_array($qry,1);

            return $result;

        }else{
            return false;
        }
    }

    public function getall()
    {
        if($this->conn){
            $qry = mysqli_query($this->conn, "select * from plans");

            $data = mysqli_fetch_all($qry,1);

            return $data;

        }else {
            return false;
        }
    }

}

?>