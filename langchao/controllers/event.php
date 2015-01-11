<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Event extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
    }

    public function index(){
        $where = array();
        $member = $this->Member_model->get_member_list($where);
        $this->data['member_list'] = $member;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/index',$this->data);
    }

    public function add_event(){
        $data = $this->security->xss_clean($_POST);
        $where = array("id"=>trim($data['id']));
        $member = $this->Member_model->get_member_info($where);
        $this->data['user_data'] = $this->session->userdata;
        $this->data['member'] = $member;    
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list;
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));      
        $this->data['worktime_list'] = $worktime_list;        
        $event_list = $this->Role_model->get_event_list(array("display"=>"1"));      
        $this->data['event_list'] = $event_list;        
        $this->load->view('event/add_event',$this->data);
    }

    public function edit(){
        $data = $this->security->xss_clean($_GET);
        $id = $_GET['id'];
        $where = array("id"=>trim($id));
        $member = $this->Member_model->get_member_info($where);
        $this->data['user_data'] = $this->session->userdata;
        $this->data['member'] = $member;
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list;
        $member_type = $this->Role_model->get_setting_list(array("type"=>"membertype"));      
        $this->data['member_type'] = $member_type;          
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
        if(empty($data['short_name'])){
            unset($data['short_name']);
        }
        if(empty($data['code'])){
            unset($data['code']);
        }
        if(empty($data['contacts'])){
            unset($data['contacts']);
        }
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $member = $this->Member_model->get_member_info($where);
        $this->data['member'] = $member;
        //print_r($member);
        $this->load->view('member/do_search',$this->data);
    }
}

?>