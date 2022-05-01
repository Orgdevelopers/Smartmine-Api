<?php
class AdminWallets{

    public function create($data)
    {
        if($this->conn){
            $name = $data['name'];
            $address = $data['address'];

            $qry = "INSERT INTO admin_wallets(id, name, address) VALUES('0', '$name', '$address') ;";

            if($this->conn->query($qry)){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }

    public function getAll()
    {
        if($this->conn){
            $qry = mysqli_query($this->conn,"SELECT * FROM admin_wallets");

            return mysqli_fetch_all($qry,1);

        }else{
            return false;
        }
    }

    public function delete($data)
    {
        if(isset($data['id']) && $this->conn){
            $id=$data['id'];
            $qry = "DELETE FROM admin_wallets WHERE id='$id'";

            if($this->conn->query($qry)){
                return true;
            
            }else{
                return false;
            }

        }else{
            return false;
        }


    }

    public function update($data)
    {
        if($this->conn && isset($data['id'])){
            $id = $data['id'];
            $current = mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM admin_wallets WHERE id='$id'"));

            if($current){
                $name=$current['name']; $address = $current['address'];

                if(isset($data['name'])){
                    $name = $data['name'];
                }
                if(isset($data['address'])){
                    $address = $data['address'];
                }

                $qry = "UPDATE admin_wallets SET name='$name', address='$address' WHERE id='$id'";

                if($this->conn->query($qry)){
                    return true;

                }else{
                    return false;
                }

            }else{
                return false;
            }

        }else{
            return false;
        }

    }

}

?>