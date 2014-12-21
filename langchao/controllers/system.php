<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        //$this->load->helper('security');
        $this->load->model('Role_model');
    }

	public function role_list()
	{		
		$where = array();
		$role_list = $this->Role_model->get_roles($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role_list'] = $role_list;
        $this->layout->view('system/role_list',$this->data);
	}

	public function role_add(){
		$ctl_list = $this->Role_model->get_ctl_list();
		$this->data['user_data'] = $this->session->userdata;
		$this->data['ctl_list'] = $ctl_list;
		$this->layout->view('system/role_add',$this->data);
	}

	public function do_role_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['role_name']){
			$permission = serialize($data['ctl']);
			$sql = array("role_name"=>trim($data['role_name']),"role_memo"=>$data['role_memo'],'permission'=>$permission);
			$result = $this->Role_model->add_role($sql);
		}
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url);
	}

	public function check_role_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("role_name"=>trim($data['role_name']));
		$role = $this->Role_model->get_role_info($where);
         if($role){
            echo True;
         }else{
            echo False;
         }		
	}

	public function role_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("role_id"=>$data['role_id']);
		$role = $this->Role_model->delete_role($where);
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url);
	}

	public function role_edit(){
		$data = $this->security->xss_clean($_GET);
		$role_id = $_GET['role_id'];
		$where = array("role_id"=>trim($role_id));
		$role = $this->Role_model->edit_role($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/role_edit',$this->data);
	}

    public function do_role_edit(){
		$data = $this->security->xss_clean($_POST);
		$role_id = $data['role_id'];
		$permission = serialize($data['ctl']);
		$where = array("role_id"=>$role_id);
		$data = array("role_name"=>trim($data['role_name']),"role_memo"=>$data['role_memo'],'permission'=>$permission);
		$result = $this->Role_model->update_role($where,$data);
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url); 	
    }

	public function city_list()
	{		
		$where = array();
		$city_list = $this->Role_model->get_city_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['city_list'] = $city_list;
        $this->layout->view('system/city_list',$this->data);
	}

	public function city_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/city_add',$this->data);
	}

	public function check_city_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_city_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_city_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_city($sql);
		}
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url);		
	}

	public function city_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_city($where);
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url);		
	}

	public function city_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_city_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/city_edit',$this->data);
	}

    public function do_city_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_city($where,$data);
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url); 	
    }



	public function custom_list()
	{		
		$where = array();
		$custom_list = $this->Role_model->get_custom_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $custom_list;
        $this->layout->view('system/custom_list',$this->data);
	}

	public function custom_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/custom_add',$this->data);
	}

	public function check_custom_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_custom_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_custom_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_custom($sql);
		}
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url);		
	}

	public function custom_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_custom($where);
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url);		
	}

	public function custom_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_custom_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/custom_edit',$this->data);
	}

    public function do_custom_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_custom($where,$data);
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url); 	
    }


/** 部门**/

    public function department_list()
	{		
		$where = array();
		$department_list = $this->Role_model->get_department_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $department_list;
        $this->layout->view('system/department_list',$this->data);
	}

	public function department_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/department_add',$this->data);
	}

	public function check_department_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_department_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_department_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_department($sql);
		}
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url);		
	}

	public function department_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_department($where);
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url);		
	}

	public function department_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_department_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/department_edit',$this->data);
	}

    public function do_department_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_department($where,$data);
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url); 	
    }




/** 事件**/

    public function event_list()
	{		
		$where = array();
		$event_list = $this->Role_model->get_event_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $event_list;
        $this->layout->view('system/event_list',$this->data);
	}

	public function event_add(){
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));		
		$this->data['department_list'] = $department_list;
		$this->load->view('system/event_add',$this->data);
	}

	public function check_event_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_event_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_event_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']),"department_id"=>$data['department_id']);
			$result = $this->Role_model->add_event($sql);
		}
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url);		
	}

	public function event_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_event($where);
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url);		
	}

	public function event_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_event_info($where);
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));		
		$this->data['department_list'] = $department_list;
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/event_edit',$this->data);
	}

    public function do_event_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']),"department_id"=>$data['department_id']);
		$result = $this->Role_model->update_event($where,$data);
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url); 	
    }




/** 系统信息配置**/

    public function setting_list()
	{		
		$where = array();
		$setting_list = $this->Role_model->get_setting_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $setting_list;
        $this->layout->view('system/setting_list',$this->data);
	}

	public function setting_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/setting_add',$this->data);
	}

	public function check_setting_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']),"type"=>trim($data['type']));
		$role = $this->Role_model->get_setting_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_setting_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']),"type"=>trim($data['type']));
			$result = $this->Role_model->add_setting($sql);
		}
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url);		
	}

	public function setting_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_setting($where);
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url);		
	}

	public function setting_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_setting_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/setting_edit',$this->data);
	}

    public function do_setting_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']),"type"=>trim($data['type']));
		$result = $this->Role_model->update_setting($where,$data);
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url); 	
    }    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */