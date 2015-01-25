<?php
class Event_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function add_event_info($params){
        $this->db->set($params);
        $res = $this->db->insert('event_list');
        return $res;
    }

    public function get_event_info($where){
        $query = $this->db->get_where('event_list', $where);
        $res = $query->row_array();
        $query3 = $this->db->get_where('event_type_list', array('id'=>$res['event_type_id']));
        $res3 = $query3->row_array();
        $res['event_type_name'] = $res3['name'];        
        return $res;
    }

    public function get_event_list($where){
        $query = $this->db->get_where('event_list', $where);
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $time = $value['event_time'];
            $x = strtotime($time);
            $n = strtotime(date("Y-m-d"));
            $r = round(($x+5*24*3600-$n)/(24*3600));
            $value['event_less_time'] = $r;
            $query2 = $this->db->get_where('work_order_list', array('event_id'=>$value['id']));
            $res2 = $query2->result_array();
            $value['work_order_num'] = count($res2);
            $query3 = $this->db->get_where('event_type_list', array('id'=>$value['event_type_id']));
            $res3 = $query3->row_array();
            $value['event_type_name'] = $res3['name'];
            $query4 = $this->db->get_where('member', array('id'=>$value['member_id']));
            $res4 = $query4->row_array();
            $value['short_name'] = $res4['short_name'];
            $query4 = $this->db->get_where('user', array('id'=>$value['user_id']));
            $res4 = $query4->row_array();
            $value['user_name'] = $res4['username'];  
            $res[$key] = $value;
        }
        return $res; 
    }

    public function update_event_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('event_list', $params); 
        return $res;         
    }    

    public function save_work_order_info($params){
        $this->db->set($params);
        $res = $this->db->insert('work_order_list');
        return $res;        
    }

    public function get_work_order_list($where){
        $query = $this->db->get_where('work_order_list', $where);
        $res = $query->result_array();
        foreach($res as $key=>$val){
            $where = array('work_order_id'=>$val['id']);
            $bill_list = $this->get_bill_order_list($where);
            $val['bill_order_list'] = $bill_list;
            $res[$key] = $val;
        }
        return $res;       
    }

    public function insert_biil_orderr_info($params){
        $this->db->set($params);
        $res = $this->db->insert('biil_order_list');
        return $res;         
    }

    public function save_biil_orderr_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('biil_order_list', $params); 
        return $res;         
    }

    public function get_biil_orderr_info($where){
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get_where('biil_order_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function delete_biil_orderr_info($where){
        $this->db->where($where);
        $res = $this->db->delete('biil_order_list');
        return $res;
    }

    public function get_bill_order_list($where){
        $query = $this->db->get_where('biil_order_list', $where);
        $res = $query->result_array();
        return $res;         
    }

    public function insert_check_event_info($params){
        $this->db->set($params);
        $res = $this->db->insert('check_event_list');
        return $res;          
    }

    public function update_check_event_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('check_event_list', $params); 
        return $res;         
    }

    public function get_check_event_info($where){
        $query = $this->db->get_where('check_event_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function delete_check_event_info($where){
        $this->db->where($where);
        $res = $this->db->delete('check_event_list');
        return $res;        
    }

}

?>