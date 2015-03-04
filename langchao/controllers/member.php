<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Member extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function add(){
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $member_type = $this->Role_model->get_setting_list(array("type"=>"membertype"));      
        $this->data['member_type'] = $member_type['info'];  
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('member/add',$this->data);
    }

    public function do_add(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        $res = $this->Member_model->save_member_info($params);            
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);
    }

    public function check_code(){
         $data = $this->security->xss_clean($_POST);
         $where['code'] = $data['code'];
         $user = $this->Member_model->get_member_info($where);
         if($user){
            echo True;
         }else{
            echo False;
         }
    }

    public function manage(){
        $where = array();
        $member = $this->Member_model->get_member_list($where,$this->per_page);
        $this->pages_conf($member['count']);
        $this->data['member_list'] = $member['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('member/manage',$this->data);
    }

    public function do_delete(){
        $data = $this->security->xss_clean($_GET);
        $where = array("id"=>$data['id']);
        $role = $this->Member_model->delete_member($where);
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);        
    }

    public function edit(){
        $data = $this->security->xss_clean($_GET);
        $id = $data['id'];
        $where = array("id"=>trim($id));
        $member = $this->Member_model->get_member_info($where);
        $this->data['user_data'] = $this->session->userdata;
        $this->data['member'] = $member;
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $member_type = $this->Role_model->get_setting_list(array("type"=>"membertype"));      
        $this->data['member_type'] = $member_type['info'];
        $this->load->view('member/edit',$this->data);
    }

    public function do_member_edit(){
        $data = $this->security->xss_clean($_POST);
        $id = $data['id'];
        $where = array("id"=>$id);
        unset($data['id']);
        $result = $this->Member_model->edit_member_info($where,$data);
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);    
    }

    public function search(){
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('member/search',$this->data);        
    }

    public function do_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        if(empty($data['short_name'])){
            unset($data['short_name']);
        }
        if(empty($data['code'])){
            unset($data['code']);
        }
        if(empty($data['contacts'])){
            unset($data['contacts']);
        }
        $where = array();        
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $member = $this->Member_model->get_member_info_like($where);
        $this->data['member'] = $member;
        $event_time = date("Y-m-d",time()-7*24*3600);
        $ww = array("member_id ="=>$member['id'], 'event_time >=' => $event_time);
        $event_list = $this->Event_model->get_member_event_list($ww);
        $this->data['event_list'] = $event_list;
        $this->load->view('member/do_search',$this->data);
    }
}

?>