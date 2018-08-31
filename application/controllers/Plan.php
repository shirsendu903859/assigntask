<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array("plan_model"));
		
		$array = array('url'=>current_url());
		$this->session->set_userdata('previousurl', $array);
	}
	
	public function index() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$data['plan'] = $this->plan_model->planmanagementfetchdata();
			$this->load->view('admin/header');
			$this->load->view('admin/planmanagement',$data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect(base_url('admin/login'));
		}
	}
		
	public function planmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data['banner'] = $this->plan_model->planmanagementfetchdata();
				$this->load->view('admin/header');
				$this->load->view('admin/planmanagement', $data);
				$this->load->view('admin/footer');
			}
			else {				
				$inserdata = array();
				$this->form_validation->set_rules('titleen', 'Plan Title', 'trim|required');
				$this->form_validation->set_rules('descriptionen', 'Plan Description', 'trim|required');
				$this->form_validation->set_rules('planprice', 'Plan Price', 'trim|required|is_numeric');
				$this->form_validation->set_rules('plantype', 'Plan Type', 'trim|required');
				if($this->form_validation->run() == FALSE) {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Please enter all the required fields with valid data.';
					echo json_encode($response);
					die();
				}				
				$inserdata['plan_title'] = $post['titleen'];
				$inserdata['plan_price'] = $post['planprice'];
				$inserdata['plan_duration'] = $post['plantype'];
				$inserdata['plan_details'] = $post['descriptionen'];
				$inserdata['status'] = 1;
				$isInsert = $this->plan_model->planmanagementinsert($inserdata);
				if($isInsert) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'Plan successfully added';
				}
				else {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Sorry some error occured. Please try again later..!!';
				}
			
			
			echo json_encode($response);
			exit(0);
		
		}
		}
		else {
			redirect(base_url('admin/login'));
		}
	}
	
	public function planmanagementfetchdatabyid($id) {
		$plandata = $this->plan_model->planmanagementfetchdatabyid($id);
		if(!empty($plandata)) {
			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'Successfully fetched';
			$response['data'] = $plandata;
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Sorry some error occured. Please try again later.. !!';		
		}
		echo json_encode($response);
		exit(0);
	}
	
	public function updateplanmanagement() {
		if($this->input->is_ajax_request()) {
			$post = $this->input->post();
			if(!empty($post)) {
				$inserdata = array();
				$this->form_validation->set_rules('titleen', 'Plan Title', 'trim|required');
				$this->form_validation->set_rules('descriptionen', 'Plan Description', 'trim|required');
				$this->form_validation->set_rules('planprice', 'Plan Price', 'trim|required|is_numeric');
				$this->form_validation->set_rules('plantype', 'Plan Type', 'trim|required');
				if($this->form_validation->run() == FALSE) {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Please enter all the required fields with valid data.';
					echo json_encode($response);
					die();
				}
				$inserdata['plan_title'] = $post['titleen'];
				$inserdata['plan_price'] = $post['planprice'];
				$inserdata['plan_duration'] = $post['plantype'];
				$inserdata['plan_details'] = $post['descriptionen'];
				$isupdate = $this->plan_model->planmanagementupdate($inserdata, $post['hiddeneditplanid']);
				if($isupdate) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'Plan successfully updated';
				}
				else {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Sorry some error occured. Please try again later..!!';
				}
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = 'Sorry some error occured. Please try again later.. !!';
			}
			echo json_encode($response);
			exit(0);
		}
		else {
			die('No direct script access allowed');	
		}
	}
	
	public function planmanagementchangestatus($id) {
		if($this->input->is_ajax_request()) {
			$isupdate = $this->plan_model->planmanagementchangestatus($id);
			/*if($isupdate) {*/
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Plan status successfully updated';
				$response['data'] = $isupdate;
			/*}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = 'Sorry some error occured. Please try again later.. !!';
			}*/
			echo json_encode($response);
			exit(0);
		}
		else {
			die('No direct script access allowed');	
		}
	}
	
	public function planmanagementdelete($id) {
		if($this->input->is_ajax_request()) {
			$isdelete = $this->plan_model->planmanagementdelete($id);
			if($isdelete) {
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Plan successfully deleted';
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = 'Sorry some error occured. Please try again later.. !!';
			}
			echo json_encode($response);
			exit(0);
		}
		else {
			die('No direct script access allowed');	
		}
	}	
	
	
}


