<?php

class apiController {

    public function init() //error code 499 means incomplete params
    {
        $request = str_replace('/','',$_SERVER['PATH_INFO']);

        try {
            $db = new Database();
            $this->conn = $db->getConnection();
            $this->$request();

        } catch (\Throwable $th) {
            $this->no_method($th);
        }
        
    }

    public function sendverificationemail() //200= success, 201 = fail, 111= email exists, 101=username exists, 1001=error
    {
        $data = $_POST;
        if($data!=null && isset($data['email'])){
            $this->loadUtails();

            $email['email'] = $data['email'];
            $email['subject'] ="Smartmine verification email";

            $str = strval(file_get_contents('/templates/email_template.php',false));
            $url = BASE_URL.'verify.php?token='. encrypt_password($email);

            str_replace('aaaaaaaaaaaaaaaa',$url,$str);

            $email['msg'] = $str;

            if($this->Utails->SendEmmail($email)){

                $output['code']= "200";
                $output['msg'] = "success";

            }else{
                $output['code']= "101";
                $output['msg'] = "faild to send email";
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }

    public function emailsignup() //200=success, 111= email exists, 101=username exists, 201=email send fail 1001=error
    {
        
        $data = $_POST;

        if($data!=null && isset($data['email']) && isset($data['username']) && isset($data['password'])){
            $this->loadModel('User');
            $this->loadUtails();
            $this->User->date = gmdate("Y-m-d H:i:s");
            $this->User->data = $data;
            
            $check = $this->User->check_signup_data($data['email'], $data['username']);
            if($check['code'] == '200'){
                $email['email'] = $data['email'];
                $email['subject'] ="Smartmine verification email";
                $email['msg'] = "click the link below to verify your Smartmine Account \n"."verification link:-". BASE_URL."verify.php?token=". encrypt_password($data['email']);

                if($this->Utails->SendEmmail($email)){

                    if($this->User->CreateUser()){
                    
                        $output['code'] = "200";
                        $output['msg'] = "signup successfull";

                        $dat['email'] = $data['email'];
                        $output['user'] = $this->User->getdetails($dat);
                    
    
                    }else{
                        $output['code'] = "1001";
                        $output['msg'] = "failed error:- ".$this->User->conn->error;
                    }

                }else{
                    $output['code'] = '201';
                    $output['msg'] = 'faild to send email';

                }

            
            }else{
                $output = $check;
            }
            
            echo json_encode($output);
            die;

        }else{
            $output['code'] = '499';
            $output['msg'] = 'failed';
        
            echo json_encode($output);
            die;

        }
        
    }

    public function getuserdetails() //200=success, 201=no user, 101=error+error reson;
    {
        $data = $_POST;
        if($data!=null){
            if(isset($data['username']) || isset($data['email']) || isset($data['id'])){
                $this->loadModel('User');

                $user = $this->User->getdetails($data);

                if ($user) {

                    $output['code'] = '200';
                    $output['msg'] = $user;

                }else if($user==null){
                    $output['code'] = '201';
                    $output['msg'] = "no user found";
                }else {
                    $output['code'] = '101';
                    $output['msg'] = "error".$this->User->conn->error;
                }

                echo json_encode($output);
                die;

            }

        }else{
            empty_data();
        }

    }

    public function emaillogin() //200=success, 201=wrong pass,211 = user not, 101=error
    {

        $data = $_POST;
        if($data!=null){
            if(isset($data['email']) && isset($data['password'])){
                $this->loadModel('User');
                $user = $this->User->getdetails($data);

                if ($user) {
                    if($user['password'] == encrypt_password($data['password'])){
                        $output['code'] = '200';
                        $output['msg'] = $user;

                    }else{
                        $output['code'] = '201';
                        $output['msg'] = "wrong password";

                    }

                }else if($user == null){
                    $output['code'] = '211';
                    $output['msg'] = "no user on this email";

                }
                else{
                    $output['code'] = '101';
                    $output['msg'] = "error". $this->conn->error;
                }

                echo json_encode($output);
                die;
                

            }

        }else{
            empty_data();
        }
    }

    public function updateuser()
    {
        $data = $_POST;

        if($data!=null && isset($data['id'])){
            $this->loadModel('User');
            if ($this->User->updateuser($data)) {
                $info['id'] = $data['id'];
                $output['code'] = '200';
                $output['msg'] = $this->User->getdetails($info);

            }else{
                $output['code']='101';
                $output['msg'] = "error ".$this->User->conn->error;

            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }

    public function uploadpic()
    {
        $data = $_POST;

        if ($data!=null && isset($data['pic'])) {
            

        }else{
            empty_data();
        }

    }

    public function getallplans() //200 success, 201 no plan, 101 fail server error
    {
        $this->loadModel('Plan');
        $plans = $this->Plan->getall();

        if($plans){
            $output['code'] = "200";
            $output['msg'] = $plans;

        }else if($this->conn){
            $output['code'] = "201";
            $output['msg'] = "no plans found";

        }else{
            $output['code'] = "101";
            $output['msg'] = "error:-".$this->conn->error;
        }

        echo json_encode($output);
        die;

    }

    public function confirmtransaction() //200=success, 201=already exists, 111 sql error, 101 = server error
    {
        $data = $_POST;
        if($data!=null && isset($data['id'])){

            $this->loadModel('Transection');

            $trdata['id'] = $data['id'];
            $check = $this->Transection->getMyPendingTransactions($trdata); // send id in obj

            if($check['code'] == '200'){
                $output['code'] = '201';
                $output['msg'] = "request already exists";

            }else if($check['code']=='201'){
                $output = $this->Transection->confirmtransaction($data);

            }else{
                $output = $check;
            }

            echo json_encode($output);

            die;

        }else{
            empty_data();
        }

    }

    public function getmyalltransections()//200=success,201=no tran, other error
    {
        $data = $_POST;

        if($data!=null && isset($data['id'])){
            $this->loadModel('Transection');
            $output = $this->Transection->getMyAllTransactions($data);

            echo json_encode($output);

        }else{
            empty_data();
        }

    }

    public function getplandetails()
    {
        $data = $_POST;
        if($data!=null && isset($data['id'])){
            $this->loadModel('Plan');
            $details = $this->Plan->getdetails($data);

            if($details){
                $output['code'] = "200";
                $output['msg'] = $details;

            }else{
                $output['code'] = "201";
                $output['msg'] = "not found ".$this->Plan->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }
        
    }

    public function enablefreetrial()
    {
        $data = $_POST;
        if($data!=null && isset($data['id'])){
            $this->loadModel('Plan');
            $this->loadModel('User');
            $user = $this->User->getdetails($data);
            
            if($user) {
                $data['plan'] = '1';
                $data['plan_purchased'] = gmdate("Y-m-d H:i:s");
                
                if($this->User->updateuser($data)){
                    $output['code'] = "200";
                    $output['msg'] = $this->User->getdetails($data);

                }else{
                    $output['code'] = "201";
                    $output['msg'] = "failed to update".$this->User->conn->error;

                }

            }else{
                $output['code'] = "101";
                $output['msg'] = "user not found";

            }

            echo json_encode($output);
            die;

        }

    }

    public function removeuserplan()
    {
        $data = $_POST;
        if($data!=null && $data['id']){
            $this->loadModel('User');
            $user = $this->User->getdetails($data);
            
            if($user) {
                $data['plan'] = '0';
                
                if($this->User->updateuser($data)){
                    $output['code'] = "200";
                    $output['msg'] = $this->User->getdetails($data);

                }else{
                    $output['code'] = "201";
                    $output['msg'] = "failed to update".$this->User->conn->error;

                }

            }else{
                $output['code'] = "101";
                $output['msg'] = "user not found";

            }

        }else{
            empty_data();
        }

    }

    public function gettrailplandetails()
    {
        $qry = mysqli_query($this->conn,"SELECT * FROM free_plan WHERE id='1'");

        $res = mysqli_fetch_array($qry,1);

        if($res){
            $output['code'] = "200";
            $output['msg'] = $res;
        
        }else{
            $output['code'] = "101";
            $output['msg'] = "error ".$this->conn->error;
        }

        echo json_encode($output);

    }

    public function getbtcliverate()
    {
        $url='https://bitpay.com/api/rates';
        $json=json_decode( file_get_contents($url));

        $btc=0;
        foreach( $json as $obj ){
            if( $obj->code=='USD' )$btc=$obj->rate;
        }

        echo $btc;

    }

    public function no_method($th){
        $echo['code']='10101';
        $echo['msg']="method desen't exists:-".str_replace('/','',$_SERVER['PATH_INFO']).$th;
        echo json_encode($echo);
        die;
    }


    public function loadModel($model_name)
    {
        $model = new $model_name;
        $model->conn = $this->conn;

        $this->$model_name = $model;

    }

    public function loadUtails()
    {
        $Utails = new Utails();
        $this->Utails = $Utails;
    }
    

}


?>