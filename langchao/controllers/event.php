<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Event extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('User_model');
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

    public function do_add_event(){
        $data = $this->security->xss_clean($_POST);
        $res = $this->Event_model->add_event_info($data);            
        $redirect_url = 'ctl=event&act=index';
        redirect($redirect_url);    
    }

    public function event_list(){
        $where = array();
        $work_order = $this->Event_model->get_event_list($where);
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list;
        $this->data['work_order_list'] = $work_order;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_list',$this->data);        
    }

    public function do_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        if(empty($data['event_time'])){
            unset($data['event_time']);
        }
        if(empty($data['status'])){
            unset($data['status']);
        }
        $where = array();        
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $event_list = $this->Event_model->get_event_list($where);
        print_r($event_list);
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['user'] = $user;
        $this->data['event_list'] = $event_list;
        $this->load->view('event/do_search',$this->data);
    }

    public function add_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_POST);
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;    
        $this->load->view('event/add_work_order',$this->data);        
    }
}

?>