<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Cloud extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('Cloud_model');
    }

    public function doc_download(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['type']) && $data['type']=="download"){
            $doc = $this->Cloud_model->get_doc_info(array("id"=>$data['id']));
            $this->Cloud_model->add_doc_download_num(array("id"=>$data['id']));
            header("location:".$doc['path']);
        }
        $this->data['user_data'] = $this->session->userdata;
        $doc_list = $this->Cloud_model->get_doc_list(array(),$this->per_page);
        $this->pages_conf($doc_list['count']);
        $this->data['doc_list'] = $doc_list['info'];
        $this->layout->view('cloud/doc_list',$this->data);        
    }

    public function doc_look(){
        $data = $this->security->xss_clean($_GET);
        $doc = $this->Cloud_model->get_doc_info(array("id"=>$data['id']));
        $file = $doc['path'];
        $this->Cloud_model->add_doc_look_num(array("id"=>$data['id']));
        header('Content-type: application/pdf');
        header('filename='.$file);
        readfile($file);
    }

}

?>
