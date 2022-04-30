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
            $tspd = $data['true_speed'];
            $created = gmdate("Y-m-d H:i:s");
            
            $qry = "INSERT INTO plans(id, name, algo, speed, duration, earning, price, package, true_speed, created)
                        VALUES ('0','$name','$algo','$speed','$speed','$earning','$price','$package','$tspd','$created')";

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

    public function delete($data)
    {
        if($this->conn && isset($data['id'])){
            $id = $data['id'];
            $qry = "DELETE FROM plans WHERE id='$id'";

            if($this->conn->query($qry)){
                return true;

            }else{
                return false;

            }

        }else{
            return false;
        }
    }

    public function updatePlan($data)
    {
        if($this->conn && isset($data['id'])){
            $id = $data['id'];

            $current = $this->getdetails($data);
            $name = $current['name'];$algo = $current['algo'];$speed = $current['speed'];
            $duration = $current['duration'];$earning = $current['earning'];$price = $current['price'];
            $package = $current['package'];$tspd = $current['true_speed'];

            if(isset($data['name'])){
                $name = $data['name'];
            }else if(isset($data['algo'])){
                $algo =$data['algo'];
            }else if(isset($data['speed'])){
                $speed =$data['speed'];
            }else if(isset($data['duration'])){
                $duration =$data['duration'];
            }else if(isset($data['earning'])){
                $earning =$data['earning'];
            }else if(isset($data['price'])){
                $price =$data['price'];
            }else if(isset($data['package'])){
                $package =$data['package'];
            }else if(isset($data['true_speed'])){
                $tspd =$data['true_speed'];
            }

            $qry = "UPDATE plans SET name='$name', algo='$algo', speed='$speed', duration='$duration', earning='$earning'
            , price='$price', package='$package', true_speed='$tspd' WHERE id='$id'";

            if($this->conn->query($qry)){
                return true;

            }else{
                return false;
            }

        }else{
            return false;
        }
        
    }

}

?>