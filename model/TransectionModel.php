<?php

class Transection{


    public function getMyPendingTransactions($data)
    {
        if($data!=null  && $this->conn){

            if(isset($data['id'])){
                $id = $data['id'];
                $qry = mysqli_query($this->conn,"SELECT * FROM transections WHERE user_id='$id' AND status='0'");

            }else{
                empty_data();
            }

            $result = mysqli_fetch_all($qry,1);

            if($result && count($result)>0){
                $output['code'] = '200';
                $output['msg'] = $result;

            }else if(!(count($result)>0)){
                $output['code'] = '201';
                $output['msg'] = $result;

            }else{
                $output['code'] = '111';
                $output['msg'] = "sql error";
            }

            return $output;

        }else{
            $output['code']='101';
            $output['msg'] = "server error";
            return $output;
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

        return $output;

    }


    public function getMyAllTransactions($data)
    {
        if($data!=null  && $this->conn){

            if(isset($data['id'])){
                $id = $data['id'];
                $qry = mysqli_query($this->conn,"SELECT * FROM transections WHERE user_id='$id' ORDER BY id DESC");

            }else{
                empty_data();
            }

            $result = mysqli_fetch_all($qry,1);

            if($result && count($result)>0){
                $output['code'] = '200';
                $output['msg'] = $result;

            }else if(!(count($result)>0)){
                $output['code'] = '201';
                $output['msg'] = $result;

            }else{
                $output['code'] = '111';
                $output['msg'] = "sql error";
            }

            return $output;

        }else{
            $output['code']='101';
            $output['msg'] = "server error";
            return $output;
        }
    }

    public function getrecent($data)
    {
        if($data!=null  && $this->conn){


            if(isset($data['id'])){
                $id = $data['id'];
                $qry = mysqli_query($this->conn,"SELECT * FROM transections WHERE user_id='$id' AND status='1' ORDER BY id DESC");

            }else{
                empty_data();
            }

            $result = mysqli_fetch_all($qry,1);

            if($result && count($result)>0){
                $output['code'] = '200';
                $output['msg'] = $result;

            }else if(!(count($result)>0)){
                $output['code'] = '201';
                $output['msg'] = $result;

            }else{
                $output['code'] = '111';
                $output['msg'] = "sql error";
            }

            return $output;

        }else{
            $output['code']='101';
            $output['msg'] = "server error";
            return $output;
        }

    }

    public function getAll()
    {
        if($this->conn){
            $qry = mysqli_query($this->conn,"SELECT * FROM transections");

            $all = mysqli_fetch_all($qry,1);

            if($all){
                return $all;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function getdetails($data)
    {
        if($this->conn && isset($data['id'])){
            $id = $data['id'];
            $detail = mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM transections WHERE id='$id'"));
            if($detail){
                return $detail;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    
}

?>