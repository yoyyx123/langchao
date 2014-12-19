<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
    }

	public function index()
	{		
		//$this->data['name'] = $this->session->userdata['name'];
		$this->data['user_data'] = $this->session->userdata;
		$this->layout->view('home/index',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */