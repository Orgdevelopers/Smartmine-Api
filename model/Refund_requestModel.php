<?php 

class RefundRequest{

    public function createRequest($data)
    {
        if($this->conn && $data!=null){
            $id = $data['id'];
            $name = $data['name'];
            $email = $data['email'];
            $plan_name = $data['plan_name'];
            $purchase_date = $data['purchase_date'];
            $refund_reson = $data['refund_reson'];
            $attachment = $data['attachment'];

            $created = gmdate("Y-m-d H:i:s");

            $qry = "INSERT INTO refund_requests (id, user_id, name, email, plan_name, purchase_date, refund_reson, attachment, status, reject_reson, created) 
                    VALUES ('0', '$id', '$name', '$email', '$plan_name', '$purchase_date', '$refund_reson', '$attachment', '0', '', '$created');";

            if($this->conn->query($qry)){

                $output['code'] = "200";
                $output['msg'] = "success";

            }else{
                $output['code'] = "201";
                $output['msg'] = "error ".$this->conn->error;

            }     


        }else{
            $output['code'] = "101";
            $output['msg'] = "error connection";

        }

        return $output;

    }

    public function getAll($data)
    {
        if($this->conn && $data!=null){
            
            $sp = 0;
            if(isset($data['starting_point'])){
                $sp = $data['starting_point'];
            }

            if(isset($data['show_all'])){
                $qry = mysqli_query($this->conn,"SELECT * FROM refund_requests ORDER BY id DESC ;");

            }else{
                $qry = mysqli_query($this->conn,"SELECT * FROM refund_requests ORDER BY id DESC LIMIT $sp,10 ;");

            }
            
            $result = mysqli_fetch_all($qry,1);

            if($result){

                $output['code'] = "200";
                $output['msg'] = $result;

            }else{
                $output['code'] = "201";
                $output['msg'] = "error ".$this->conn->error;

            }     


        }else{
            $output['code'] = "101";
            $output['msg'] = "error connection";

        }

        return $output;


    }

    public function getAllbyid($data)
    {
        if($this->conn && $data!=null && isset($data['user_id'])){
            
            $sp = 0;
            $user_id = $data['user_id'];
            if(isset($data['starting_point'])){
                $sp = $data['starting_point'];
            }

            if(isset($data['show_all'])){
                $qry = mysqli_query($this->conn,"SELECT * FROM refund_requests WHERE user_id='$user_id' ORDER BY id DESC ;");

            }else{
                $qry = mysqli_query($this->conn,"SELECT * FROM refund_requests WHERE user_id='$user_id' ORDER BY id DESC LIMIT $sp,10 ;");

            }
            
            $result = mysqli_fetch_all($qry,1);

            if($result){

                $output['code'] = "200";
                $output['msg'] = $result;

            }else{
                $output['code'] = "201";
                $output['msg'] = "error ".$this->conn->error;

            }     


        }else{
            $output['code'] = "101";
            $output['msg'] = "error connection";

        }

        return $output;
    }

    public function getinfobyid($data){
        if($this->conn && isset($data['id'])){
            $id = $data['id'];
            $qry = mysqli_query($this->conn,"SELECT * FROM refund_requests WHERE id='$id'");

            return mysqli_fetch_array($qry,1);

        }else{
            return false;
        }

    }

    public function update($data)//200=success 201 failupdate 111 failfetch 101 conc erorr
        {
        if ($this->conn && $data!=null && isset($data['id'])) {
            
            $id = $data['id'];
            $current = $this->getinfobyid($data);

            if($current && $current!=null){
                $email = $current['email']; $plan_name = $current['plan_name']; $purchase_date=$current['purchase_date'];
                $refund_reson=$current['refund_reson']; $attachment=$current['attachment']; $status=$current['status'];
                $reject_reson=$current['reject_reson'];

                if(isset($data['email'])){
                    $email = $data['email'];

                }else if(isset($data['plan_name'])){
                    $plan_name = $data['plan_name'];

                }else if(isset($data['purchase_date'])){
                    $purchase_date = $data['purchase_date'];
                    
                }else if(isset($data['refund_reson'])){
                    $refund_reson = $data['refund_reson'];

                }else if(isset($data['attachment'])){
                    $attachment = $data['attachment'];
                    
                }else if(isset($data['status'])){
                    $status = $data['status'];

                }else if(isset($data['reject_reson'])){
                    $reject_reson = $data['reject_reson'];

                }

                $qry = "UPDATE refund_requests SET email='$email', plan_name='$plan_name', purchase_date='$purchase_date',
                        refund_reson='$refund_reson', attachment='$attachment', status='$status', reject_reson='$reject_reson' WHERE id='$id'";

                $result = $this->conn->query($qry);
                
                if($result){
                    $output['code'] = "200";
                    //$id["id"]=$this->conn->insert_id;
                    $detail=$this->getinfobyid($id);
                    $output['msg'] = $detail;

                }else{
                    $output['code'] = "201";
                    $output['msg'] = "error failed to update".$this->conn->error;
                }

            }else{
                $output['code'] = "111";
                $output['msg'] = "error failed to fetch";
            }

            return $output;

        }else{
            $output['code'] = "101";
            $output['msg'] = "error connection";
        }
    }

    public function delete($id)
    {
        if($this->conn){
            $qry = "DELETE FROM refund_requests WHERE id='$id'";

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