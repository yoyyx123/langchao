<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }


    public function get_user_mobile($user){
        $query = $this->db->get_where('user', array('username' => $user));
        $res = $query->row_array();
        return $res;
    }

    public function get_user_info($where){
        $query = $this->db->get_where('user', $where);
        $res = $query->row_array();
        return $res;       
    }

    public function get_user_list($where){
        $query = $this->db->get_where('user', $where);
        $res = $query->result_array();
        return $res; 
    }

    public function check_captcha_msg($uid,$captcha){
        $this->db->order_by("created", "desc");
        $query = $this->db->get_where('sms_captcha', array('uid' =>$uid ,'status'=>'1' ));
        $res = $query->row_array();
        if ($res['captcha'] == $captcha && (time()- 60*30 <= $res['created'])){
            return $res;
        }else{
            return False;
        }
    }

    public function get_sms_info(){
        $query = $this->db->get_where('sms_setting', array('status' => '1'));
        $res = $query->row_array();
        return $res;         
    }

    public function save_sms_captcha($uid,$captcha,$task_id){
        $data = array(
               'uid' => $uid,
               'captcha' => $captcha,
               'task_id' => $task_id,
               'created' => time(),
        );
        $this->db->insert('sms_captcha', $data); 
    }

    public function edit_user_info($where,$params){
        $res = $this->db->update('user', $params,$where); 
        return $res;
    }

    public function save_user_info($params){
        $this->db->set($params);
        $res = $this->db->insert('user');
        return $res;
    }
}

?>