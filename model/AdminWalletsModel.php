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

}

?>