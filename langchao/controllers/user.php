<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('User_model');
         $this->load->model('Role_model');
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function login(){
		$this->load->view('user/login');
	}

	public function do_login() {
        $data = $this->security->xss_clean($_POST);
    	$where = array('username' => $data['user_name'], 'password' => do_hash($data['password'],'md5'),'mobile' => $data['mobile'],);
    	$user = $this->User_model->get_user_info($where);
    	if(!$user){
            $redirect_url = 'ctl=user&act=login';
    	}
    	//$status = $this->User_model->check_captcha_msg($user['id'],$data['sms_captcha']);
        $status = True;//临时去掉验证码
    	if (!$status){
            $redirect_url = 'ctl=user&act=login';
    	}else{
    		$this->session->set_userdata($user);
    		$redirect_url = 'ctl=home&act=index';
    	}
        redirect($redirect_url);
	}	

	public function logout(){
        $this->session->sess_destroy();
        $redirect_url = 'ctl=user&act=login';
        redirect($redirect_url);
    }

    public function check_login(){
    	$data = $this->security->xss_clean($_POST);
    	$where = array('username' => $data['user_name'], 'password' => do_hash($data['password'],'md5'),'mobile' => $data['mobile'],);
    	$user = $this->User_model->get_user_info($where);
    	if(!$user){
    		echo 'fail';
    	}
    	//$status = $this->User_model->check_captcha_msg($user['id'],$data['sms_captcha']);
        $status = True;//临时去掉验证码
    	if ($status){
    		echo 'succ';
    	}else{
    		echo 'fail';
    	}
    }

    public function send_captcha(){
    	$data = $this->security->xss_clean($_POST);
    	$u_info = $this->check_mobile($data['mobile'],$data['user_name']);
    	if (!$u_info){
    		echo "error";exit;
    	}
    	$status = $this->send_captcha_sms($u_info);
    	if ($status){
    		echo 'succ';
    	}else{
    		echo 'fail';
    	}
    }

    public function check_mobile($mobile,$user){
    	$u_info = $this->User_model->get_user_mobile($user);
        if(isset($u_info['mobile']) && $mobile==$u_info['mobile']){
            return $u_info;
        }else{
            return False;
        }
    }

    public function send_captcha_sms($u_info){
        $sms_info = $this->User_model->get_sms_info();
        $captcha = $this->get_captcha();
        $content = "您的验证码是 ".$captcha.", 请于30分钟内输入, 请勿泄漏. 【浪潮工贸】";
        $params['userid'] = $sms_info['userid'];
        $params['account'] = $sms_info['account'];
        $params['password'] = $sms_info['passwd'];
        $params['mobile'] = $u_info['mobile'];
        $params['content'] = $content;
        $params['sendTime'] = "";
        $params['action'] = "send";
        $params['extno'] = "";
        $result = $this->request_post($sms_info['url'],$params);
        $xml = simplexml_load_string($result);
        $status = (string) $xml->returnstatus;
        if($status != 'Success'){
            return False;
        }else{
            $task_id = (string) $xml->taskID;
            $this->User_model->save_sms_captcha($u_info['id'],$captcha,$task_id);
        }
    	return 1;
    }

    public function get_captcha(){
        return rand(100000,999999);
    }

    public function info(){
        $this->data['user_data'] = $this->session->userdata;
        //$this->data['user_data']['password'] = substr($this->data['user_data']['password'],-2);
        $this->layout->view('user/info',$this->data);
    }

    public function check_passwd(){
        $data = $this->security->xss_clean($_POST);
        $password = do_hash($data['passwd'],'md5');
        $username = $this->session->userdata['username'];
        $where = array('username' => $username, 'password' => $password);
        $user = $this->User_model->get_user_info($where);
        if($user){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function edit_passwd(){
        $data = $this->security->xss_clean($_POST);
        $password = do_hash($data['old_password'],"md5");
        $username = $this->session->userdata['username'];
        $where = array('username' => $username, "password" => $password);
        $new_pass = do_hash($data['new_password'],'md5');
        $params = array('password'=>$new_pass);
        $res = $this->User_model->edit_user_info($where,$params);
        if($res){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function edit_user_img(){
        $tp = array("image/gif","image/pjpeg","image/jpeg");
        $path = "./upload/img/userlogo";
        if(!in_array($_FILES["img"]["type"],$tp)) { 
            //文件格式不对
            $status = 'fail';
            $msg = '文件格式不对';
        }
        if($_FILES["img"]["size"]>1024*1024){
            $status = 'fail';
            $msg = '文件格式不对';
        }
        $type = end(explode(".",$_FILES['img']['name']));
        $filename = 'user_'.$this->session->userdata['username'].".".$type;
        $file = $path."/".$filename;
        $result = move_uploaded_file($_FILES["img"]["tmp_name"],$file);
        $where = array('id' => $this->session->userdata['id']);
        $params = array("img"=>$filename);
        if ($result){
            $res = $this->User_model->edit_user_info($where,$params);
            $status = 'succ';
            $msg = '上传成功';
        }else{
            $status = 'fail';
            $msg = '上传失败';            
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }

    public function add(){
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list;
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list;         
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));      
        $this->data['worktime_list'] = $worktime_list;        
        $role_list = $this->Role_model->get_roles(array());
        $this->data['role_list'] = $role_list;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('user/add',$this->data);
    }

    public function do_add(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        $params['password'] = do_hash($params['password'],"md5");
        $res = $this->save_user_img($params['username']);
        if ('succ'==$res['status']){
            $params['img'] = $res['filename'];
            $res = $this->User_model->save_user_info($params);            
        }
        $redirect_url = 'ctl=user&act=manage';
        redirect($redirect_url);
    }

    public function save_user_img($username){
        $tp = array("image/gif","image/pjpeg","image/jpeg");
        $path = "./upload/img/userlogo";
        if(!in_array($_FILES["img"]["type"],$tp)) { 
            //文件格式不对
            $status = 'fail';
            $msg = '文件格式不对';
        }
        if($_FILES["img"]["size"]>1024*1024){
            $status = 'fail';
            $msg = '文件格式不对';
        }
        $type = end(explode(".",$_FILES['img']['name']));
        $filename = 'user_'.$username.".".$type;
        $file = $path."/".$filename;
        $result = move_uploaded_file($_FILES["img"]["tmp_name"],$file);
        if ($result){
            $res['status'] = 'succ';
        }else{
            $res['status'] = 'fail';
        }
        $res['filename'] = $filename;
        return $res;
    }

    public function check_username(){
         $data = $this->security->xss_clean($_POST);
         $where['username'] = $data['username'];
         $user = $this->User_model->get_user_info($where);
         if($user){
            echo True;
         }else{
            echo False;
         }
    }

    public function manage(){
        $where = array();
        $users = $this->User_model->get_user_list($where);
        $this->data['user_list'] = $users;
        $this->data['user_data'] = $this->session->userdata;
        //print_r($users);exit;
        $this->layout->view('user/manage',$this->data);
    }
}

?>