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
            $info_list = array();
            $i=0;
            foreach ($info as $key => $value) {
                if($i>=$this->per_page && $i<($this->per_page+ROW_SHOW_NUM)){
                    $info_list[$key] = $value;
                }
                $i += 1;
            }
            $this->data['info_list'] = $info_list;
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
            $this->data['data_type'] = $data['data_type'];
            $this->data['user_id'] = $data['user_id'];
            if($data['user_id'] !='all'){
                $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
                $this->data['name'] = $user['name'];
            }
            $this->data['department_id'] = $data['department_id'];
            $this->data['event_month'] = $data['event_month'];

            $where = array('event_month'=>$data['event_month']);
            if($data['user_id'] != "all"){
                $where['user_id'] = $data['user_id'];
            }
            $result = array();
            $event_list = $this->Event_model->get_event_list($where);
            foreach($event_list['info'] as $key=>$val){
                $result[$val['user_id']][] = $val;
            }
            if($data['data_type']=="work_time"){
                $info = $this->get_data_export_worktime($result,$data);
            }elseif($data['data_type']=="fee"){
                $info = $this->get_data_export_fee($result,$data);
            }
            $this->pages_conf(count($info));
            $info_list = array();
            foreach ($info as $key => $value) {
                if($key>=$this->per_page && $key<($this->per_page+ROW_SHOW_NUM)){
                    $info_list[] = $value;
                }
            }            
            $this->data['info_list'] = $info_list;
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list['info'];        
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_export',$this->data);
    }

    public function get_data_export_fee($result,$data){
        $info = array();
        foreach($result as $key => $value){
            $transportation_fee = 0;
            $hotel_fee = 0;
            $food_fee = 0;
            $other_fee = 0;
            foreach ($value as $k => $v) {
                list($t_fee,$h_fee,$f_fee,$o_fee) = $this->get_cost_fee($v['id']);
                $transportation_fee += $t_fee;
                $hotel_fee += $h_fee;
                $food_fee += $f_fee;
                $other_fee += $o_fee;
            }
            $info[$key]['transportation_fee'] =  $transportation_fee;
            $info[$key]['hotel_fee'] = $hotel_fee;
            $info[$key]['food_fee'] = $food_fee;
            $info[$key]['other_fee'] = $other_fee;
            $info[$key]['event_month'] = $data['event_month'];
            $info[$key]['user_name'] = $value[0]['user_name'];
            $info[$key]['name'] = $value[0]['name'];
            $info[$key]['user_id'] = $key;
        }
        return $info;
    }

    public function get_cost_fee($event_id){
        $transportation_fee = 0;
        $hotel_fee = 0;
        $food_fee = 0;
        $other_fee = 0;
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                if($val['status'] == 2){
                    $transportation_fee += $val['transportation_fee'];
                    $hotel_fee += $val['hotel_fee'];
                    $food_fee += $val['food_fee'];
                    $other_fee += $val['other_fee'];
                }
            }
        }
        $result[] = $transportation_fee;
        $result[] = $hotel_fee;
        $result[] = $food_fee;
        $result[] = $other_fee;
        return $result;
    }


    public function get_data_export_worktime($result,$data){
        $info = array();     
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
            $info[$key]['name'] = $value[0]['name'];
            $info[$key]['user_id'] = $key;
        }
        return $info;
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

    public function do_data_export(){
        $data = $this->security->xss_clean($_GET);
        $this->data['is_search'] = 1;
        $this->data['data_type'] = $data['data_type'];
        $this->data['user_id'] = $data['user_id'];
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['name'] = $user['name'];
        $this->data['department_id'] = $data['department_id'];
        $this->data['event_month'] = $data['event_month'];        
        $where = array('user_id'=>$data['user_id'],'event_month'=>$data['event_month']);
        $result = array();
        $event_list = $this->Event_model->get_event_list($where);
        foreach ($event_list['info'] as $key => $value) {
            $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$value['id']));
            foreach ($work_order_list as $k => $val) {
                if($data['data_type']=="work_time"){
                    $result[] = $this->do_data_export_worktime($val,$data);
                }elseif($data['data_type']=="fee"){
                    foreach($val['bill_order_list'] as $m=>$n){
                        $result[] = $n;                        
                    }
                }
            }
        }
        if (isset($data['is_export']) && $data['is_export']){
            $this->export_xls($result);
        }
        $this->pages_conf(count($result));
        $info_list = array();
        foreach ($result as $key => $value) {
            if($key>=$this->per_page && $key<($this->per_page+ROW_SHOW_NUM)){
                $info_list[] = $value;
            }
        }
        $this->data['info_list'] = $info_list;
        $this->data['user_data'] = $this->session->userdata; 
        $this->layout->view('search/do_data_export',$this->data);
    }

    public function export_xls($msg){
        require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");

        $objPHPExcel->createSheet(0);
        // Add some data
        /**
        $objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!')
                    ->setCellValue('C1', 'Hello')
                    ->setCellValue('D2', 'world!');

        **/
        $arrayData = array(
            array(NULL, 2010, 2011, 2012),
            array('Q1',   12,   15,   21),
            array('Q2',   56,   73,   86),
            array('Q3',   52,   61,   69),
            array('Q4',   30,   32,    0),
        );

        $arrayData = $msg;
        $objPHPExcel->setActiveSheetIndex(0)
            ->fromArray(
                $arrayData,  // The data to set
                NULL,        // Array values with this value will not be set
                'A1'         // Top left coordinate of the worksheet range where
                             //    we want to set these values (default is A1)
            );

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('sheet');

        $objPHPExcel->setActiveSheetIndex(0);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="数据导出.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;        
    }

    public function do_data_export_worktime($work_order,$data){
        $worktime_count = $this->do_data_export_worktime_count($work_order);
        $work_order['worktime_count'] = $worktime_count;
        list($week_more,$weekend_more,$holiday_more) = $this->do_data_export_worktime_more($work_order);
        $work_order['week_more'] = $week_more;
        $work_order['weekend_more'] = $weekend_more;
        $work_order['holiday_more'] = $holiday_more;
        return $work_order;
    }

    public function do_data_export_worktime_count($work_order){
        $worktime_count = 0;
        $tmp = strtotime($work_order['back_time']) - strtotime($work_order['arrive_time']);
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
        return $worktime_count;
    }

    public function do_data_export_worktime_more($work_order){
        $week_more = 0;
        $weekend_more = 0;
        $holiday_more = 0;

        $tmp = strtotime($work_order['back_time']) - strtotime($work_order['arrive_time']);
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
        $date = substr($work_order['back_time'],0,10);
        $holiday_list = $this->Event_model->get_holiday_list();
        $weekend_list = explode('_', WEEKEND);
        if (in_array($date, $holiday_list)){
            $holiday_more = $holiday_more+$int_tmp+$less_tmp;
        }elseif(in_array(date("N",strtotime($date)), $weekend_list)){
            $weekend_more = $weekend_more+$int_tmp+$less_tmp;
        }else{
            $week_more = $week_more+$int_tmp+$less_tmp;
        }
        $res[] = $week_more;
        $res[] = $weekend_more;
        $res[] = $holiday_more;
        return $res;
    }

}

?>
