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
        $member = $this->Member_model->get_member_list($where,$this->per_page);
        $this->pages_conf($member['count']);
        $this->data['member_list'] = $member['info'];
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
        $this->data['department_list'] = $department_list['info'];
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));      
        $this->data['worktime_list'] = $worktime_list['info'];        
        $event_list = $this->Role_model->get_event_list(array("display"=>"1"));      
        $this->data['event_list'] = $event_list;        
        $this->load->view('event/add_event',$this->data);
    }

    public function do_add_event(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        unset($params['is_all']);
        unset($params['event_time_start']);
        unset($params['event_time_end']);
        if (isset($data['is_all']) && !empty($data['is_all'])){
            $start =  strtotime($data['event_time_start']);
            $end = strtotime($data['event_time_end']);
            $num = ($end - $start)/(3600*24);
            for ($i=0; $i <= $num; $i++) { 
                $event_time =  date('Y-m-d', ($start + $i*24*3600));
                if($this->is_valid_date($event_time)){
                    $params['event_time'] = $event_time;
                    $event_month = substr($params['event_time'],0,7);
                    $params['event_month'] = $event_month;
                    $res = $this->Event_model->add_event_info($params);
                }
            }
        }else{

            $event_month = substr($params['event_time'],0,7);
            $params['event_month'] = $event_month;
            $res = $this->Event_model->add_event_info($params);            
        }
        $redirect_url = 'ctl=event&act=index';
        redirect($redirect_url);    
    }

    public function is_valid_date($date){
        $holiday_list = $this->Event_model->get_holiday_list();
        $weekend_list = explode('_', WEEKEND);
        if (in_array($date, $holiday_list)){
            return false;
        }elseif(in_array(date("N",strtotime($date)), $weekend_list)){
            return false;
        }else{
            return true;
        }
    }

    public function event_list(){
        $data = $this->security->xss_clean($_GET);
        $this->data['back_url'] = "index.php?".http_build_query($data);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['status'] = $data['status'];
            $where = array();        
            foreach($data as $k =>$v){
                if(!empty($data[$k])){
                    $where[$k] = trim($v);
                }
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            foreach ($event_list['info'] as $key => $value) {
                $cost_fee = $this->get_event_cost_fee($value);
                $value['cost_fee'] = $cost_fee;
                $event_list['info'][$key] = $value;
            }
            $this->pages_conf($event_list['count']);
            $this->data['event_list'] = $event_list['info'];        
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));        
            $this->data['user'] = $user;            
        }
        

        //$where = array();
        //$work_order = $this->Event_model->get_event_list($where);
        $user = $this->User_model->get_user_list();
        $this->data['user_list'] = $user['info'];
        //$this->data['work_order_list'] = $work_order;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_list',$this->data);        
    }

    public function get_event_cost_fee($event){
        $cost_fee = 0;
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $cost_fee = $cost_fee + $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
            }
        }
        return $cost_fee;
    }

    public function do_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        unset($data['ctl']);
        unset($data['act']);
        unset($data['per_page']);
        $this->data['user_id'] = $data['user_id'];
        $this->data['event_month'] = $data['event_month'];
        $this->data['status'] = $data['status'];
        $where = array();        
        foreach($data as $k =>$v){
            if(!empty($data[$k])){
                $where[$k] = trim($v);
            }
        }
        $event_list = $this->Event_model->get_event_list($where);
        $this->pages_conf($event_list['count']);
        $this->data['event_list'] = $event_list['info'];        
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));        
        $this->data['user'] = $user;
        $this->load->view('event/do_search',$this->data);
    }

    public function add_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $_GET['back_url'];
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'event_list'));
        }
        $this->data['back_url'] = $back_url;
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;    
        $this->layout->view('event/add_work_order',$this->data);        
    }

    public function do_add_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_POST);
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $data['back_url'];
            unset($data['back_url']);
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'index'));
        }        
        $event_id = $data['event_id'];
        $res = $this->Event_model->save_work_order_info($data);
        $this->change_event_status($event_id,2);

        $redirect_url = 'ctl=event&act=edit_work_order&event_id='.$event_id."&back_url=".urlencode($back_url);
        redirect($redirect_url); 
    }

    public function edit_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $_GET['back_url'];
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'event_list'));
        }
        $this->data['back_url'] = $back_url;        
        if(isset($data['work_order_id'])){
            $this->data['work_order_id'] = $data['work_order_id']; 
        }
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event; 
        $where = array("event_id"=>trim($data['event_id']));
        if(isset($data['work_order_id'])&&!empty($data['work_order_id'])){
            $where['id'] = $data['work_order_id'];
        }
        $work_order_list = $this->Event_model->get_work_order_list($where);
        $this->data['work_order_list'] = $work_order_list;
        if(!isset($this->data['work_order_id'])){
            $tmp_order = end($work_order_list);
            $this->data['work_order_id'] = $tmp_order['id'];
        }
        $traffic_list = $this->Role_model->get_setting_list(array("type"=>"traffic"));
        $this->data['traffic_list'] = $traffic_list['info'];
        $this->layout->view('event/edit_work_order',$this->data); 
    }

    public function do_edit_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_POST);
        $event_id = $data['event_id'];
        $work_order_id = $data['work_order_id'];
        unset($data['work_order_id']);
        $where = array("id"=>$work_order_id);
        $res = $this->Event_model->update_work_order_info($data,$where);
        $redirect_url = 'ctl=event&act=edit_work_order&event_id='.$event_id;
        redirect($redirect_url);         
    }

    public function add_biil_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_POST);
        unset($data['id']);
        if(isset($data['bill_id']) && !empty($data['bill_id'])){
            $where = array('id'=>$data['bill_id']);
            unset($data['bill_id']);            
            $res = $this->Event_model->save_biil_orderr_info($data,$where);
        }else{
            unset($data['bill_id']);
            $res = $this->Event_model->insert_biil_orderr_info($data);
            $where = array('work_order_id'=>$data['work_order_id']);            
        }
        $result = $this->Event_model->get_biil_orderr_info($where);
        if($result && $result['bill_no']==$data['bill_no']){
            echo json_encode(array("status"=>"succ","id"=>$result["id"]));
        }else{
            echo json_encode(array('status'=>'fail'));
        }
    }

    public function delete_biil_order(){
        $data = $this->security->xss_clean($_POST);
        $where = array('id'=>$data['bill_id']);
        $res = $this->Event_model->delete_biil_orderr_info($where);
        if ($res){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function event_check(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['status'] = $data['status'];                      
            if(empty($data['event_time'])){
                unset($data['event_time']);
            }
            if(empty($data['status'])){
                unset($data['status']);
            }
            $where = array();        
            foreach($data as $k =>$v){
                if(!empty($data[$k])){
                    $where[$k] = trim($v);
                }
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            $this->pages_conf($event_list['count']);
            foreach ($event_list['info'] as $key => $value) {
                $worktime_count = $this->get_event_worktime_count($value);
                $value['worktime_count'] = $worktime_count;
                $event_list['info'][$key] = $value;
            }
            $this->data['event_list'] = $event_list['info'];            
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
            $this->data['user'] = $user;
        }
        

        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_check',$this->data);
    }

    public function get_event_worktime_count($event){
        $worktime_count = 0;
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            $tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
            $int_tmp =  intval($tmp/3600);
            $less = $tmp-($int_tmp*3600);
            $less_int =  intval($less/60);
            if ($less_int>45){
                $less_tmp = 1;
            }elseif($less_int<=45 && $less_int>=15){
                $less_tmp = 0.5;
            }else{
                $less_tmp = 0;
            }
            $worktime_count = $worktime_count+$int_tmp+$less_tmp;
        }
        return $worktime_count;        
    }

    public function do_check_search(){
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
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['user'] = $user;
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/do_check_search',$this->data);
    }

    public function check_work_order(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        if(isset($data['work_order_id'])){
            $this->data['work_order_id'] = $data['work_order_id']; 
        }
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $worktime_count = $this->get_event_worktime_count($event);
        $event['worktime_count'] =  $worktime_count;
        $more_work = $this->get_event_worktime_more($event);
        $event['week_more'] = $more_work['week_more'];
        $event['weekend_more'] = $more_work['weekend_more'];
        $event['holiday_more'] = $more_work['holiday_more'];
        $time = $event['event_time'];
        $x = strtotime($time);
        $n = strtotime(date("Y-m-d"));
        $r = round(($x+5*24*3600-$n)/(24*3600));
        if($r>=0){
            $this->data['event_less_time'] = 1;
        }else{
            $this->data['event_less_time'] = 0;
        }
        //$event['event_less_time'] = $r;
        $this->data['event'] = $event;
        $check = $this->Event_model->get_check_event_info(array('id'=>$data['event_id']));
        if($check['performance_id'] !=0){
            $this->data['check'] = $check;            
        }
        $where = array("event_id"=>trim($data['event_id']));
        $work_order_list = $this->Event_model->get_work_order_list($where);
        $this->data['work_order_list'] = $work_order_list;
        $this->data['work_order_num'] = count($work_order_list);
        $performance_list = $this->Role_model->get_setting_list(array("type"=>"performance"));
        $this->data['performance_list'] = $performance_list['info'];
        $this->layout->view('event/check_work_order',$this->data);         
    }

    public function get_event_worktime_more($event){
        $week_more = 0;
        $weekend_more = 0;
        $holiday_more = 0;

        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            $tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
            $int_tmp =  intval($tmp/3600);
            $less = $tmp-($int_tmp*3600);
            $less_int =  intval($less/60);
            if ($less_int>45){
                $less_tmp = 1;
            }elseif($less_int<=45 && $less_int>=15){
                $less_tmp = 0.5;
            }else{
                $less_tmp = 0;
            }
            $date = substr($value['back_time'],0,10);
            $holiday_list = $this->Event_model->get_holiday_list();
            $weekend_list = explode('_', WEEKEND);
            if (in_array($date, $holiday_list)){
                $holiday_more = $holiday_more+$int_tmp+$less_tmp;
            }elseif(in_array(date("N",strtotime($date)), $weekend_list)){
                $weekend_more = $weekend_more+$int_tmp+$less_tmp;
            }else{
                $week_more = $week_more+$int_tmp+$less_tmp;
            }
        }
        $res['week_more'] = $week_more;
        $res['weekend_more'] = $weekend_more;
        $res['holiday_more'] = $holiday_more;
        return $res;         
    }

    public function add_check_event_info(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_POST);
        $event_id = $data['event_id'];
        $where = array("id"=>$event_id);
        unset($data['check_id']);
        unset($data['event_id']);
        $work_order_list = $this->Event_model->update_check_event_info($data,$where);
        $this->change_event_status($event_id,3);
        $redirect_url = 'ctl=event&act=check_work_order&event_id='.$event_id;
        redirect($redirect_url);
    }

    public function delete_check_event(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        if(isset($data['event_id'])&&!empty($data['event_id'])){
            $where = array('id'=>$data['event_id']);
            $this->Event_model->delete_check_event_info($where);
            $redirect_url = 'ctl=event&act=check_work_order&event_id='.$data['event_id'];
            $this->change_event_status($data['event_id'],2);          
        }else{
            $redirect_url = 'ctl=event&act=event_check';  
        }

        redirect($redirect_url);
    }

    public function change_event_status($event_id,$status){
        $where = array('id'=>$event_id);
        $params = array('status'=>$status);
        $this->Event_model->update_event_info($params,$where);
    }   

    public function event_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            $this->data['back_url'] = "index.php?".http_build_query($data);
            unset($data['is_event']);
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['short_name'] = $data['short_name'];            
            $this->data['title'] = 'member';
            foreach($data as $key=>$value){
                if(empty($data[$key])){
                    unset($data[$key]);                
                }
            }
            if(isset($data['short_name']) && !empty($data['short_name'])){
                $this->data['title'] = 'member';
                $member = $this->Member_model->get_member_info(array("short_name"=>trim($data['short_name'])));
                unset($data['short_name']);
                if($member){
                    $data['member_id'] = $member['id'];
                    $this->data['member'] = $member;
                }
            }
            if(isset($data['user_id']) && !empty($data['user_id'])){
                $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
                if($user){
                    $this->data['user'] = $user;
                }
                $this->data['title'] = 'user';
            }
            $where = array();       
            foreach($data as $k =>$v){
                $where[$k] = trim($v);
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            $this->pages_conf($event_list['count']);
            $this->data['event_list'] = $event_list['info'];            
        }




        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_search',$this->data);        
    }

    public function do_event_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        foreach($data as $key=>$value){
            if(empty($data[$key])){
                unset($data[$key]);                
            }
        }
        if(isset($data['short_name']) && !empty($data['short_name'])){
            $this->data['title'] = 'member';
            $member = $this->Member_model->get_member_info(array("short_name"=>trim($data['short_name'])));
            unset($data['short_name']);
            if($member){
                $data['member_id'] = $member['id'];
                $this->data['member'] = $member;
            }
        }
        if(isset($data['user_id']) && !empty($data['user_id'])){
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
            if($user){
                $this->data['user'] = $user;
            }
            $this->data['title'] = 'user';
        }
        $where = array();       
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $event_list = $this->Event_model->get_event_list($where);
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/do_event_search',$this->data);        
    }

    public function cost_check(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['cost_status'] = $data['cost_status'];
            $where = $data;
            foreach($where as $key=>$value){
                if(empty($where[$key])){
                    unset($where[$key]);                
                }
            }
            unset($where['is_event']);
            $month_list = array();
            $event_list = $this->Event_model->get_event_list($where);
            //$this->pages_conf($event_list['count']);
            foreach($event_list['info'] as $key => $value){
                list($total,$rel_total) = $this->get_cost_fee($value['id']);
                $value['total'] = $total;
                $value['rel_total'] = $rel_total;
                $month_list[$value['event_month']][] = $value;
            }
            foreach ($month_list as $key => $value) {
                $info = array();
                $total_fee = 0;
                $rel_total_fee = 0;
                foreach($value as $k => $v) {
                    $total_fee += $v['total'];
                    $rel_total_fee += $v['rel_total'];
                }
                $info = array(
                    'user_name' =>$v['user_name'], 
                    'user_id' =>$v['user_id'], 
                    'cost_status'=>$v['cost_status'],
                    'total_fee' =>$total_fee,
                    'rel_total_fee' => $rel_total_fee,
                    );
                $month_list[$key] = $info;
            }
            $this->data['month_list'] = $month_list;
        }

        $where = array();
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/cost_check',$this->data);
    }

    public function do_event_cost_search(){
        $data = $this->security->xss_clean($_POST);
        $where = $data;
        foreach($where as $key=>$value){
            if(empty($where[$key])){
                unset($where[$key]);                
            }
        }
        unset($where['is_event']);
        $month_list = array();
        $event_list = $this->Event_model->get_event_list($where);
        foreach($event_list['info'] as $key => $value){
            list($total,$rel_total) = $this->get_cost_fee($value['id']);
            $value['total'] = $total;
            $value['rel_total'] = $rel_total;
            $month_list[$value['event_month']][] = $value;
        }
        foreach ($month_list as $key => $value) {
            $info = array();
            $total_fee = 0;
            $rel_total_fee = 0;
            foreach($value as $k => $v) {
                $total_fee += $v['total'];
                $rel_total_fee += $v['rel_total'];
            }
            $info = array(
                'user_name' =>$v['user_name'], 
                'user_id' =>$v['user_id'], 
                'cost_status'=>$v['cost_status'],
                'total_fee' =>$total_fee,
                'rel_total_fee' => $rel_total_fee,
                );
            $month_list[$key] = $info;
        }
        $this->data['month_list'] = $month_list;
        $this->load->view('event/do_event_cost_search',$this->data);
    }

    public function get_cost_fee($event_id){
        $total = 0;
        $rel_total = 0;
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $total = $total + $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                if($val['status'] == 2){
                    if($val['rel_fee']){
                        $rel_total += $val['rel_fee'];
                    }else{
                        $rel_total = $rel_total + $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                    }
                }
            }
        }
        $result[] = $total;
        $result[] = $rel_total;
        return $result;
    }

    public function get_event_biil_list(){
        $total = 0;
        $bill_list = array();
        $is_cost = 1;
        $data = $this->security->xss_clean($_GET);
        $where = array('event_month'=>$data['event_month'],'user_id'=>$data['user_id']);
        $event_list = $this->Event_model->get_event_simple_list($where);
        foreach ($event_list as $key => $value) {
            list($total_tmp,$biil_list_tmp) = $this->get_biil_list($value['id']);
            $total += $total_tmp;
            foreach ($biil_list_tmp as $key => $val) {
                $bill_list[] = $val;
            }
            if($value['cost_status'] !=3){
                $is_cost = 0;
            }
        }
        $user_info = $this->User_model->get_user_info(array('id'=>$data['user_id']));
        $this->data['is_cost'] = $is_cost;
        $this->data['total'] = $total;
        $this->data['bill_list'] = $bill_list;
        $this->data['event_month'] = $data['event_month'];
        $this->data['user_info'] = $user_info;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/get_event_biil_list',$this->data);      
    }

    public function get_biil_list($event_id){
        $total = 0;
        $bill_list = array();
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $transportation_info = $this->Role_model->get_setting_info(array("id"=>$val['transportation']));
                $val['transportation_name'] = $transportation_info['name'];
                if(floatval($val['rel_fee'])){
                    $total += $val['rel_fee'];
                }else{
                    $total = $total+$val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                }
                $bill_total = $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                $val['bill_total'] = $bill_total;
                $bill_list[] = $val;
            }
        }
        $result[] = $total;
        $result[] = $bill_list;
        return $result;        
    }

    public function change_event_cost_status(){
        $data = $this->security->xss_clean($_POST);
        $where = array('event_month'=>$data['event_month'],"user_id"=>$data['user_id']);
        $params = array('cost_status'=>$data['status']);
        $this->Event_model->update_event_info($params,$where);
        echo "succ";
    }

    public function update_bill_order_status(){
        $data = $this->security->xss_clean($_POST);
        $id = $data['id'];
        unset($data['id']);
        $where = array('id'=>$id);
        $this->Event_model->update_bill_order_status($data,$where);
        echo "succ";
    }    
}

?>
