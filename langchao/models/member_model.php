<?php
class Member_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }


    public function get_member_info($where){
        $query = $this->db->get_where('member', $where);
        $res = $query->row_array();
        if($res){
            $city_id = $res['city'];
            $query2 = $this->db->get_where('setting_list', array('id'=>$city_id));
            $res2 = $query2->row_array();
            $res['city_name'] = $res2['name'];
            $member_type = $res['member_type'];
            $query3 = $this->db->get_where('setting_list', array('id'=>$member_type));
            $res3 = $query3->row_array();
            $res['member_type_name'] = $res3['name'];
        }
        return $res;       
    }

    public function get_member_list($where,$offset=false){
        $this->db->order_by("id", "desc");
        if($offset!==false){
            $query = $this->db->get_where('member', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('member', $where);
        }        
        //$query = $this->db->get_where('member', $where);
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $city_id = $value['city'];
            $query2 = $this->db->get_where('setting_list', array('id'=>$city_id));
            $res2 = $query2->row_array();
            $value['city_name'] = $res2['name'];
            $member_type = $value['member_type'];
            $query3 = $this->db->get_where('setting_list', array('id'=>$member_type));
            $res3 = $query3->row_array();
            $value['member_type_name'] = $res3['name'];
            $res[$key] = $value;
        }
        $this->db->where($where);
        $this->db->from('member');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);        
    }

    public function edit_member_info($where,$params){
        $res = $this->db->update('member', $params,$where); 
        return $res;
    }

    public function save_member_info($params){
        $this->db->set($params);
        $res = $this->db->insert('member');
        return $res;
    }

    public function delete_member($data){
        if (is_array($data)){
            $res = $this->db->delete('member', $data); 
            return $res;
        }else{
            return false;
        }       
    }    

}

?>