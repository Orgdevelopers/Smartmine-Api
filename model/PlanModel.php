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


        }else{
            return false;
        }
    }

}

?>