<?php
class Role_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }


    public function get_roles($where){
        $query = $this->db->get_where('user_roles', $where);
        $res = $query->result_array();
        return $res;
    }


    public function get_ctl_list() {
    	$where = array("pid"=>0,"type"=>"ctl");
    	$query = $this->db->get_where('ctl_list', $where);
        $rs = $query->result_array();
        for($i = 0; $i < count($rs); $i++) {
        	$where = array("pid"=>"{$rs[$i]['id']}","type"=>"ctl");
        	$query2 = $this->db->get_where('ctl_list', $where);
            $rs2 = $query2->result_array();
            $rs[$i]['ctl_child'] = $rs2;
        }
        //var_dump($rs);exit;
        return $rs;
    }

    public function add_role($data){
    	$this->db->insert('user_roles', $data); 
    }

    public function get_role_info($where){
        $query = $this->db->get_where('user_roles', $where);
        $res = $query->row_array();
        return $res;       
    }

    public function delete_role($data){
    	if (is_array($data)){
    		$res = $this->db->delete('user_roles', $data); 
    		return $res;
    	}else{
    		return false;
    	}
    }

    public function update_role($where,$data){
    	$res = $this->db->update('user_roles', $data,$where); 
        return $res;
    }

    public function edit_role($where){
    	$query = $this->db->get_where('user_roles', $where);
        $rs = $query->row_array();
        $ctl_arr = unserialize(stripcslashes($rs['permission']));
        $query2 = $this->db->get_where('ctl_list', array("pid"=>0,"type"=>"ctl"));
        $rs2 = $query2->result_array();
        for($i = 0; $i < count($rs2); $i++) {
        	$query3 = $this->db->get_where('ctl_list', array("pid"=>"{$rs2[$i]['id']}","type"=>"ctl"));
        	$rs3 = $query3->result_array();
            for($j = 0; $j < count($rs3); $j++) {
                if(in_array($rs3[$j]['id'], $ctl_arr)) {
                    $rs3[$j]['sel'] = 1;
                } else {
                    $rs3[$j]['sel'] = 0;
                }
            }
            $rs2[$i]['ctl_child'] = $rs3;
            if(in_array($rs2[$i]['id'], $ctl_arr)) {
                $rs2[$i]['sel'] = 1;
            } else {
                $rs2[$i]['sel'] = 0;
            }
        }
        $rs['ctl'] = $rs2;
        return $rs;    	
    }

    public function get_city_list($where){
        $query = $this->db->get_where('city_list', $where);
        $res = $query->result_array();
        return $res;    	
    }

    public function get_city_info($where){
        $query = $this->db->get_where('city_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_city($data){
    	$this->db->insert('city_list', $data);     	
    }

    public function delete_city($data){
    	if (is_array($data)){
    		$res = $this->db->delete('city_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_city($where,$data){
    	$res = $this->db->update('city_list', $data,$where); 
        return $res;
    }

    public function get_custom_list($where){
        $query = $this->db->get_where('custom_type_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_custom_info($where){
        $query = $this->db->get_where('custom_type_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_custom($data){
    	$this->db->insert('custom_type_list', $data);     	
    }

    public function delete_custom($data){
    	if (is_array($data)){
    		$res = $this->db->delete('custom_type_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_custom($where,$data){
    	$res = $this->db->update('custom_type_list', $data,$where); 
        return $res;
    }    



    public function get_department_list($where){
        $query = $this->db->get_where('department_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_department_info($where){
        $query = $this->db->get_where('department_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_department($data){
    	$this->db->insert('department_list', $data);     	
    }

    public function delete_department($data){
    	if (is_array($data)){
    		$res = $this->db->delete('department_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_department($where,$data){
    	$res = $this->db->update('department_list', $data,$where); 
        return $res;
    }    




    public function get_event_list($where){
        $query = $this->db->get_where('event_type_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_event_info($where){
        $query = $this->db->get_where('event_type_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_event($data){
    	$this->db->insert('event_list', $data);     	
    }

    public function delete_event($data){
    	if (is_array($data)){
    		$res = $this->db->delete('event_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_event($where,$data){
    	$res = $this->db->update('event_list', $data,$where); 
        return $res;
    }




    public function get_setting_list($where){
        $query = $this->db->get_where('setting_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_setting_info($where){
        $query = $this->db->get_where('setting_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_setting($data){
    	$this->db->insert('setting_list', $data);     	
    }

    public function delete_setting($data){
    	if (is_array($data)){
    		$res = $this->db->delete('setting_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_setting($where,$data){
    	$res = $this->db->update('setting_list', $data,$where); 
        return $res;
    }  





}


?>