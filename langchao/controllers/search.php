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
            $this->data['user_id'] = $data['user_id'];
            $this->data['start_time'] = $data['start_time'];
            $this->data['end_time'] = $data['end_time'];
            $params['user_id'] = $data['user_id'];
            $params['start_time'] = $data['start_time'];
            $params['end_time'] = $data['end_time'];
            if(isset($data['short_name'])&&!empty($data['short_name'])){
                $this->data['short_name'] = $data['short_name'];
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
            $event_list = $this->Event_model->get_event_search_list($params);
            $result = array();
            $info = array();
            if(isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['user_id']][] = $val;
                }
            }elseif(isset($params['member_id'])&&empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['user_id']][] = $val;
                }                
            }elseif(!isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['member_id']][] = $val;
                }
                
            }
            foreach ($result as $k=>$v){
                $info[$k]['count'] = count($v);
                $info[$k]['user_name'] = $v[0]['user_name'];
                $info[$k]['short_name'] = $v[0]['short_name'];
                $work_time = 0;
                $road_time = 0;
                $complain_num = 0;
                $check_num = 0;
                foreach($v as $kk=>$vv){
                    if($vv['is_complain']==1){
                     $complain_num +=1;
                    }
                    if($vv['status']==3){
                     $check_num +=1;
                    }
                    foreach($vv['work_order_list'] as $mm => $nn){
                        $work_time = $work_time+(strtotime($nn['back_time'])-strtotime($nn['arrive_time'])) ;
                        foreach($nn['bill_order_list'] as $m => $n){
                            $road_time += (strtotime($n['arrival_time'])-strtotime($n['go_time']));
                        }
                    }
                }
                $info[$k]['work_time'] = $this->trans_to_hour($work_time);
                $info[$k]['road_time'] = $this->trans_to_hour($road_time);
                $info[$k]['complain_num'] = $complain_num;
                $info[$k]['check_num'] = $check_num;
            }
            $this->pages_conf(count($info));
            $this->data['info_list'] = $info;
        }
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_search',$this->data);
    }

    public function trans_to_hour($data){
        $int_tmp =  intval($data/3600);
        $less = $data-($int_tmp*3600);
        $less_int =  intval($less/60);
        if ($less_int>45){
            $less_tmp = 1;
        }elseif($less_int<=45 && $less_int>=15){
            $less_tmp = 0.5;
        }else{
            $less_tmp = 0;
        }
        $hour = $int_tmp+$less_tmp;
        return $hour;
    }

    public function data_export(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_search']) && $data['is_search']==1){
            $this->data['is_search'] = 1;
            $where = array('event_month'=>$data['event_month']);
            if($data['user_id'] != "all"){
                $where['user_id'] = $data['user_id'];
            }
            $result = array();
            $info = array();
            $event_list = $this->Event_model->get_event_list($where);
            foreach($event_list['info'] as $key=>$val){
                $result[$val['user_id']][] = $val;
            }
            foreach ($result as $key => $value) {
                $week_more = 0;
                $weekend_more = 0;
                $holiday_more = 0;
                $worktime_count = 0;
                foreach ($value as $k => $v) {
                    $more_work = $this->get_event_worktime_more($v);
                    $week_more += $more_work['week_more'];
                    $weekend_more += $more_work['weekend_more'];
                    $holiday_more += $more_work['holiday_more'];
                    $worktime_count += $this->get_event_worktime_count($v);
                }
                
                $info[$key]['worktime_count'] =  $worktime_count;
                $info[$key]['week_more'] = $week_more;
                $info[$key]['weekend_more'] = $weekend_more;
                $info[$key]['holiday_more'] = $holiday_more;
                $info[$key]['event_month'] = $data['event_month'];
                $info[$key]['user_name'] = $value[0]['user_name'];
                $info[$key]['user_id'] = $key;
            }
            $this->pages_conf(count($info));
            $this->data['info_list'] = $info;
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list;        
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_export',$this->data);        
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


}

?>
