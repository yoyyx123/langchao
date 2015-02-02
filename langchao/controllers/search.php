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
            $this->data['is_search'] = 1;
            $params['user_id'] = $data['user_id'];
            $params['start_time'] = $data['start_time'];
            $params['end_time'] = $data['end_time'];
            if(isset($data['short_name'])&&!empty($data['short_name'])){
                $member = $this->Member_model->get_member_info(array('short_name'=>$data['short_name']));
                if($member){
                    $member_id = $member['id'];
                    $params['member_id'] = $member_id;
                }
            }
            foreach ($params as $key => $value) {
                if(empty($params[$key])){
                    unset($params[$key]);
                }
            }
            $event_list = $this->Event_model->get_event_search_list($params,$this->per_page);
            if(isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val{
                    $result[$val['user_id']][] = $val;
                }
            }elseif(isset($params['member_id'])&&empty($params['user_id'])){
                foreach($event_list as $key=>$val{
                    $result[$val['user_id']][] = $val;
                }                
            }elseif(!isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val{
                    $result[$val['member_id']][] = $val;
                }                
            }

            foreach ($result as $k=>$v){
                $info[$key]['count'] = count($val);
                $info[$key]['user_name'] = $val[0]['user_name'];
                $info[$key]['short_name'] = $val[0]['short_name'];
                $work_time = 0;
                $road_time = 0;
                $complain_num = 0
                $check_num = 0
                foreach($v as $kk=>$vv){
                    if($vv['is_complain']==1){
                     $complain_num +=1;
                    }
                    if($vv['status']==3){
                     $check_num +=1;
                    }
                    $work_time += (strtotime($vv['arrive_time'])-$vv['back_time']);
                    foreach($vv['bill_order_list'] as $m => $n){
                        $road_time += (strtotime($n['arrival_time'])-$n['go_time'])
                    }
                }
                $info[$key]['work_time'] = $work_time;
                $info[$key]['road_time'] = $road_time;
                $info[$key]['complain_num'] = $complain_num;
                $info[$key]['check_num'] = $check_num;
            }            
            //$this->pages_conf($event_list['count']);
            $this->data['info_list'] = $info;
        }
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_search',$this->data);        
    }
}

?>
