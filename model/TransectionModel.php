<?php

$mqry = 'mysqli_query';
$select = "SELECT * FROM transections";
$clause = " WHERE ";

class Transection{


    public function getMyPendingTransactions($data)
    {
        if($data!=null  && $this->conn){

            if(isset($data['id'])){
                $id = $data['id'];
                $qry = mysqli_query($this->conn,"SELECT * FROM transections WHERE id=$id");
               

            }else if(isset($data['username'])){
                $username = $data['username'];
                $qry = mysqli_query($this->conn,"SELECT * FROM transections WHERE username=$username");

            }else{
                empty_data();
            }

            $result = $this->conn->query($qry);

            return $result;

        }else{
            return false;
        }
    }

    public function confirmtransaction($data)
    {
        if($this->conn && $data['id']){
            $id = $data['id'];
            $amount = $data['amount'];
            $wallet = $data['wallet_address'];

            $qry = "INSERT INTO `transections` (`id`, `user_id`, `amount`, `wallet_address`, `status`, `updated`, `created`)
                                         VALUES ('0', '$id', '$amount', '$wallet', '0', current_timestamp(), current_timestamp());";

            if($this->conn->query($qry)){
                $output['code'] = '200';
                $output['msg'] = 'success';

            }else{
                $output['code'] = '111';
                $output['msg'] = 'error:-'.$this->conn->error;

            }                          

        }else{
            $output['code'] = '101';
            $output['msg'] = 'err connection';
        }

    }

    
}

?>