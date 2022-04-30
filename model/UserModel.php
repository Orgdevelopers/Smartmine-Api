<?php

class User {

    public function CreateUser()
    {
        if ($this->conn && $this->data !=null) {
            $email = $this->data['email'];
            $username = $this->data['username'];
            $password = encrypt_password($this->data['password']);

            $date = $this->date;

        
            $status = '0';
            

            $qry = "INSERT INTO user (id, username, email, password, pic, status, role, plan, balance, mined_minutes, plan_purchased, updated, created) 
                            VALUES ('0', '$username', '$email', '$password', '', '$status', 'user', '0', '0', '0', '$date', '$date', '$date');";

            if ($this->conn->query($qry)) {
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

        if(isset($data['id'])){
            $id= $data['id'];
            $qry = mysqli_query($this->conn,"SELECT * FROM user WHERE id='$id'");

        }elseif (isset($data['email'])) {
            $email = $data['email'];
            $qry = mysqli_query($this->conn,"SELECT * FROM user WHERE email='$email'");

        }elseif (isset($data['username'])) {
            $username = $data['username'];
            $qry = mysqli_query($this->conn,"SELECT * FROM user WHERE username='$username'");

        }
        
        $user = mysqli_fetch_array($qry,1);

        return $user;

    }

    public function check_signup_data($email,$username)
    {
        $email_check = mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM user WHERE email='$email'"));
        if($email_check){
            //email alredy exists
            $output['code'] = '111';
            $output['msg'] = "email";
            return $output;
        }

        $username_check = mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM user WHERE username='$username'"));

        if($username_check){
            //username alredy exists
            $output['code'] = '101';
            $output['msg'] = "username";
            return $output;
        }

         
         $output['code'] = '200';
         $output['msg'] = "success";
         return $output;

    }

    public function updateuser($data)
    {
        if($this->conn){ 
            $info['id'] = $data['id'];
            $current_user = $this->getdetails($info);
            $id = $data['id'];

            $username = $current_user['username']; $email = $current_user['email']; $password = $current_user['password'];
            $pic = $current_user['pic']; $status = $current_user['status']; $role = $current_user['role']; $plan = $current_user['plan'];
            $balance = $current_user['balance']; $mined_minutes = $current_user['mined_minutes']; $plan_purchased = $current_user['plan_purchased'];

            $updated = gmdate("Y-m-d H:i:s");

            if(isset($data['username'])){
                $username = $data['username'];
            }if (isset($data['email'])) {
                $email = $data['email'];
            }if (isset($data['password'])) {
                $password = $data['password'];
            }if (isset($data['pic'])) {
                $pic = $data['pic'];
            }if (isset($data['status'])) {
                $status = $data['status'];
            }if (isset($data['role'])) {
                $role = $data['role'];
            }if (isset($data['plan'])) {
                $plan = $data['plan'];
            }if (isset($data['balance'])) {
                $balance = $data['balance'];
            }if (isset($data['mined_minutes'])) {
                $mined_minutes = $data['mined_minutes'];
            }if (isset($data['plan_purchased'])) {
                $plan_purchased = $data['plan_purchased'];
            }


            $qry = "UPDATE user SET username='$username',email='$email',password='$password',pic='$pic',
            status='$status',role='$role',plan='$plan',balance='$balance',mined_minutes='$mined_minutes',
            plan_purchased='$plan_purchased',updated='$updated' WHERE id=$id";

            if ($this->conn->query($qry)) {
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