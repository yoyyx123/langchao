<?php
class Cloud_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_doc_list($where,$offset=false){
        $this->db->order_by("date", "desc");
        if($offset!==false){
            $query = $this->db->get_where('doc_list', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('doc_list', $where);
        }
        $res = $query->result_array();
        $this->db->where($where);
        $this->db->from('doc_list');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res); 
    }

    public function get_doc_info($where){
        $query = $this->db->get_where('doc_list', $where);
        $res = $query->row_array();      
        return $res;
    }

    public function add_doc_download_num($where){
        $query = $this->db->get_where('doc_list', $where);
        $res = $query->row_array();      
        $num = $res['download'] + 1;
        $this->db->where($where);
        $this->db->update('doc_list', array("download"=>$num));
    }

    public function add_doc_look_num($where){
        $query = $this->db->get_where('doc_list', $where);
        $res = $query->row_array();      
        $num = $res['look'] + 1;
        $this->db->where($where);
        $this->db->update('doc_list', array("look"=>$num));
    }    



}

?>
