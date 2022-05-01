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
                $to = $data['email']."";
                $subject ="Smartmine verification email";
                $msg = "click the link below to verify your Smartmine Account \n"."verification link:-". BASE_URL."verify.php?token=". encrypt_password($data['email']);
                

                if($this->Utails->SendEmmail($to,$subject,$msg)){

                    if($this->User->CreateUser()){
                    
                        $output['code'] = "200";
                        $output['msg'] = "signup successfull";

                        $dat['email'] = $data['email'];
                        $output['user'] = $this->User->getdetails($dat);
                        $output['email'] = $data['email'];
                    
    
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
    
    public function verifyemail(){
        
        $data = json_decode(file_get_contents("php://input"),true);
        
        if($data!=null){
            
            $this->loadModel('User');
            $email['email'] = decrypt_password($data['hash_token']);
    
            $output = $this->User->getdetails($email);
            if($output && $output['status']=="0"){
                $update['status'] = "1";
                $update['id'] = $output['id'];
    
                if($this->User->updateuser($update)){
                    $output['code'] = "200";

                }else{
                    $output['code'] = "101";
                    $output['msg'] = "failed to update".$this->User->conn->error;
                }
    
            }else{
                $output['code'] = "101";
                $output['msg'] = "user not found".$email['email'];
            }
            
        }else{
            $output['code'] = "101";
            $output['msg'] = $data;
        }
            
        echo json_encode($output);
        die;
        
    }

    public function getuserdetails() //200=success, 201=no user, 101=error+error reson;
    {
        if($_POST!=null){
            $data = $_POST;
        }else{
            $data = json_decode(file_get_contents("php://input"),true);
        }
        
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
        if(isset($_POST['id'])){
            $data = $_POST;

        }else{
            $data = json_decode(file_get_contents("php://input"),true);
        }

        if($data!=null && isset($data['id'])){
            $this->loadModel('User');
            if ($this->User->updateuser($data)) {
                $info['id'] = $data['id'];
                $output['code'] = '200';
                $output['msg'] = $data;

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

    public function registerplan() //buy request
    {
        $data = $_POST;
        if ($data!=null && isset($data['id'])) {
            $uid = $data['id'];
            $plan = $data['plan'];
            $image = $data['image'];

            $filename = rand(9999,999999).$uid.".jpg";
            $sql_path = "uploads/images/".$filename;
            $fullpath = UPLOADS_DIR.$filename;

            $img = $image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);

            $created = gmdate("Y-m-d H:i:s");

            $success=file_put_contents($fullpath, $img);

            if($success){
                $qry = "INSERT INTO buy_requests(id,user_id,plan,attachment,created) VALUES ('0', '$uid', '$plan', '$sql_path', '$created') ;";

                if($this->conn->query($qry)){

                    $output['code'] = "200";
                    $output['msg'] = "success";

                }else{
                    $output['code'] = "111";
                    $output['msg'] = "sql error: ".$this->conn->error;
                }

            }else{
                $output['code'] = "101";
                $output['msg'] = "image write failed";
            }

            echo json_encode($output);
            die;


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
        if(isset($_POST['id'])){
            $data = $_POST;
        }else{
            $data = json_decode(file_get_contents("php://input"),true);

        }

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

            echo json_encode($output);
            die;

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
        die;

    }

    public function updateminingstats()
    {
        $data = $_POST;
        if($data!=null && $data['id']){
            $this->loadModel('User');
            $user = $this->User->getdetails($data);
            
            if($user) {

                $min_min = $data['mined_seconds']/60;

                $update_data['id'] = $data['id'];
                $update_data['balance'] = $data['total_coins'];
                $update_data['mined_minutes'] = $min_min;
                
                if($this->User->updateuser($update_data)){
                    $output['code'] = "200";
                    $output['msg'] = "success";

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

        }else{
            empty_data();
        }
    }

    public function registerrefundrequest() //200 = success, 201 = insert error, 101=connection error
    {
        $data = $_POST;
        if($data!=null && isset($data['id'])){
            $this->loadModel('RefundRequest');
            $image = $data['image'];

            $filename = uniqid().".jpg";
            $sql_path = "uploads/images/".$filename;
            $fullpath = UPLOADS_DIR.$filename;

            $img = $image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);
            
            $success=file_put_contents($fullpath, $img);

            if($success){
                $data['attachment'] = $sql_path;
                $result = $this->RefundRequest->createRequest($data);

            }else{
                $result['code'] = "101";
                $result['msg'] = "attachment upload failed";
            }
            echo json_encode($result);
            die;

        }

    }

    public function getadminwallets()
    {
        $this->loadModel('AdminWallets');
        $result = $this->AdminWallets->getAll();

        if($result){
            $output['code'] = "200";
            $output['msg'] = $result;

        }else{
            $output['code'] = "201";
            $output['msg'] = "no plans error ".$this->User->conn->error;

        }

        echo json_encode($output);

    }

    public function updaterefundrequest()
    {
        $data=$_POST;

        if($data!=null&& isset($data['id'])){

            $this->loadModel('RefundRequest');

            $result=$this->RefundRequest->update($data);
            echo json_encode($result);
            die;



        }else{
            empty_data();
        }

        
    }

    public function getallrefundrequests()
    {
        $data =  json_decode(file_get_contents("php://input"),true);

        if($data!=null){
            $this->loadModel('RefundRequest');

            $result=$this->RefundRequest->getAll($data);
            echo json_encode($result);
            die;

        }else{
            empty_data();
        }
       
    }

    public function getallrefundrequestsbyid()
    {
        $data=$_POST;

        if($data!=null&& isset($data['id'])){
            $this->loadModel('RefundRequest');

            $result=$this->RefundRequest->getAllbyid($data);
            echo json_encode($result);
            die;

        }else{
            empty_data();
        }
       
    }


    public function getrefundrequestdetail()
    {
        $data=$_POST;

        if($data!=null&& isset($data['id'])){
            $this->loadModel('RefundRequest');

            $result=$this->RefundRequest->getinfobyid($data);
            echo json_encode($result);
            die;

        }else{
            empty_data();
        }
       
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


    public function googleplanpurchased()
    {
        $data = $_POST;
        if(isset($data['id']) && isset($data['purchased_plan'])){

            $this->loadModel('User');
            $id = $data['id'];
            $plan = $data['purchased_plan'];
            $plan_purchased = gmdate("Y-m-d H:i:s");

            $current_user = $this->User->getdetails($data);
            if(!$current_user){
                $output['code'] = '111';
                $output['msg'] = 'user not found';
                
                echo json_encode($output);
                die;

            }

            $update_data['id'] = $id;
            $update_data['plan'] = $plan;
            $update_data['plan_purchased'] = $plan_purchased;

            if($this->User->updateuser($update_data)){
                $output['code'] = '200';
                $output['msg'] = 'success';
            }else{
                $output['code'] = '101';
                $output['msg'] = "error ".$this->User->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }

    public function getrecentpayouts()
    {
        $data = $_POST;
        if(isset($data)){
            $this->loadModel('Transection');
            echo json_encode($this->Transection->getrecent($data));
            die;

        }else{

            empty_data();
        }
    }


    //admin functions start from here

    public function adminlogin()
    {
        $data =  json_decode(file_get_contents("php://input"),true);
        if($data!=null && isset($data['email'])){

            $email = $data['email'];
            $password = $data['password'];

            $admin = mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM admin WHERE email='$email' "));
            if($admin){
                if(encrypt_password($password)==$admin['password']){
                    $output['code'] = "200";
                    $output['msg'] = $admin;

                }else{
                    $output['code'] = "101";
                    $output['msg'] = "wrong password";
                }

            }else{
                $output['code'] = "101";
                $output['msg'] = "wrong email";
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }
    
    
    
    public function sendotp()
    {
        $data = $_POST;

        if($data!=null && isset($data['email'])){
            $this->loadModel('User');
            $this->loadUtails();

            $check = $this->User->getdetails($data);
            if($check){
                $otp = rand(100000,999999);
                $to = $data['email'];
                $subject = "Smartmine verification code";
                $msg = "Here is your Smartmine verification code:-".$otp;

                if($this->Utails->SendEmmail($to,$subject,$msg)){
                    $output['code'] = "200";
                    $output['msg'] = $otp."";

                }else{
                    $output['code'] ="111";
                    $output['msg'] = "otp not sent";
                }

            }else{
                $output['code'] = "211";
                $output['msg'] = "user not found";
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }


    public function updatepassword()
    {
        $data = $_POST;
        if($data!=null && isset($data['email'])){
            $this->loadModel('User');

            $email = $data['email'];
            $password = $data['password'];
            $hash = encrypt_password($password);

            $current_user = $this->User->getdetails($data);
            
            if($current_user){
                $update_data['password'] = $hash;
                $update_data['id'] = $current_user['id'];

                if($this->User->updateuser($update_data)){

                    $output['code'] = "200";
                    $output['msg'] = "success";

                }else{
                    $output['code'] = "111";
                    $output['msg'] = "error ".$this->User->conn->error;
                }

            }else{
                $output['code'] = "211";
                $output['msg'] = "user not found";
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }
    
    public function getallusers()
    {
        $this->loadModel('User');
        $all =$this->User->getAll();

        if($all){
            $output['code'] = "200";
            $output['msg']  = $all;

        }else{

            $output['code'] = "101";
            $output['msg'] = "error "+$this->User->conn->error;

        }

        echo json_encode($output);
        die;

    }

    public function getallbuyrequests()
    {
        $all = mysqli_fetch_all(mysqli_query($this->conn,"SELECT * FROM buy_requests"),1);

        if($all){
            $output['code'] = "200";
            $output['msg'] = $all;
        }else{
            $output['code'] = "101";
            $output['msg'] = "error ".$this->conn->error;
        }

        echo json_encode($output);
        die;

    }

    public function getalltransections()
    {
        $this->loadModel('Transection');

        $all = $this->Transection->getAll();

        if($all){
            $output['code'] = "200";
            $output['msg'] = $all;

        }else{
            $output['code'] = '101';
            $output['msg'] = "error ".$this->Transection->conn->error;
        }

        echo json_encode($output);
        die;

    }
    

    public function createplan()
    {
        $data = json_decode(file_get_contents("php://input"),true);

        if($data!=null && isset($data['name'])){
            $this->loadModel('Plan');
            if($this->Plan->createPlan($data)){
                $output['code'] = '200';
                $output['msg'] = "success";

            }else{
                $output['code'] = '101';
                $output['msg'] = "error ".$this->Plan->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }

    }

    public function deleteplan()
    {
        $data = json_decode(file_get_contents("php://input"),true);

        if($data!=null && isset($data['id'])){
            $this->loadModel('Plan');

            if($this->Plan->delete($data)){
                $output['code'] = '200';
                $output['msg'] = "success";

            }else{
                $output['code'] = '101';
                $output['msg'] = "error ".$this->Plan->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }


    }

    public function updateplan()
    {
        $data = json_decode(file_get_contents("php://input"),true);
        if($data!=null && isset($data['id'])){
            $this->loadModel('Plan');
            if($this->Plan->updatePlan($data)){

                $output['code']="200";
                $output['msg']="success";

            }else{
                $output['code']="101";
                $output['msg']="failed".$this->Plan->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
        empty_data();
        }

    }

    public function deleterefundrequest()
    {
        if(isset($_POST['id'])){
            $data = $_POST;
        }else{
            $data = json_decode(file_get_contents("php://input"),true);
        }

        if($data!=null && isset($data['id'])){

            $this->loadModel('RefundRequest');
            if($this->RefundRequest->delete($data['id'])){
                $output['code'] = "200";
                $output['msg'] = "success";

            }else{
                $output['code'] = "101";
                $output['msg'] = "error ".$this->RefundRequest->conn->error;
            }

            echo json_encode($output);
            die;



            

        }else{
            empty_data();
        }


    }

    public function reject_refund_request()
    {
        if(isset($_POST['id'])){
            $data = $_POST;
        }else{
            $data = json_decode(file_get_contents("php://input"),true);
        }

        if($data!=null && isset($data['id'])){

            $data['status'] = "2";
            $this->loadModel('RefundRequest');
            if($this->RefundRequest->update($data)){
                $output['code'] = "200";
                $output['msg'] = "success";

            }else{
                $output['code'] = "101";
                $output['msg'] = "error ".$this->RefundRequest->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }
        
    }


    public function accept_refund_requet()
    {
        if(isset($_POST['id'])){
            $data = $_POST;
        }else{
            $data = json_decode(file_get_contents("php://input"),true);
        }

        if($data!=null && isset($data['id'])){

            $data['status'] = "1";
            $this->loadModel('RefundRequest');
            if($this->RefundRequest->update($data)){
                $output['code'] = "200";
                $output['msg'] = "success";

            }else{
                $output['code'] = "101";
                $output['msg'] = "error ".$this->RefundRequest->conn->error;
            }

            echo json_encode($output);
            die;

        }else{
            empty_data();
        }
        
    }


}


?>