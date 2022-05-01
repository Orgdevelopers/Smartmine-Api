<?php
class AdminWallets{

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

}

?>