<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Search extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('User_model');
    }

    public function data_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_search']) && $data['is_search']==1){
            if(isset($data['short_name'])&&!empty($data['short_name'])){
                $member = $this->Member_model->get_member_info(array('short_name'=>$data['short_name']));
                if($member){
                    $member_id = $member['id'];
                }
            }
            if(isset($member_id)&&isset($data['user_id']&&!empty($data['use_id']))){
                 $event_list = $this->Event_model->get_event_list(array('user_id'=>$data['use_id'],"member_id"=>$member_id));
                 foreach ($event_list as $key => $value) {
                     
                 }
            }
            $this->load->view('event/do_data_search',$this->data);
        }else{
            $where = array();
            $user_list = $this->User_model->get_user_list();
            $this->data['user_list'] = $user_list;
            $this->data['user_data'] = $this->session->userdata;
            $this->layout->view('search/data_search',$this->data);
        }

    }
}

?>
