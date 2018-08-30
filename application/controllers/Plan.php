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
		
	public function pricemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data['banner'] = $this->admin_model->bannermanagementfetchdata();
				$data['page'] = $this->admin_model->allpagelist();
				$this->load->view('admin/header');
				$this->load->view('admin/bannermanagement', $data);
				$this->load->view('admin/footer');
			}
			else {				
				$inserdata = array();
				if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
					$this->form_validation->set_rules('page', 'Choosing Page', 'trim|required');
					if($this->form_validation->run() == FALSE) {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Please Choose an page to apply the banner';
						
						echo json_encode($response);
						die();
					}
					
					
					$config['upload_path']          = BANNER_UPLOAD_PATH;
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 1000000;
					$config['max_width']            = 1024000;
					$config['max_height']           = 7680000;
					$config['encrypt_name']         = TRUE;

               		$this->load->library('upload', $config);

                	if ( ! $this->upload->do_upload('image')) {
                        $error = array('error' => $this->upload->display_errors());
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
                	}
                	else {
                        $data = array('upload_data' => $this->upload->data());
						$imagename = $data['upload_data']['file_name'];
						$inserdata['imagename'] = $imagename;
					}
					
					$inserdata['texten'] = $post['texten'];
					$inserdata['textfr'] = $post['textfr'];
					$inserdata['page'] = $post['page'];
					
					$isInsert = $this->admin_model->bannermanagementinsert($inserdata);
					if($isInsert) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Banner successfully uploaded';
					}
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!';
					}
				}
				else
				{
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Please upload an image to proceed';
				}
				
				echo json_encode($response);
				exit(0);
			
			}
		}
		else {
			redirect(base_url('admin/login'));
		}
	}
	
	public function bannermanagementfetchdatabyid($bannerid) {
		$bannerdata = $this->admin_model->bannermanagementfetchdatabyid($bannerid);
		if(!empty($bannerdata)) {
			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'Successfully fetched';
			$response['data'] = $bannerdata;
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Sorry some error occured. Please try again later.. !!';		
		}
		echo json_encode($response);
		exit(0);
	}
	
	public function updatebannermanagement() {
		if($this->input->is_ajax_request()) {
			$post = $this->input->post();
			if(!empty($post)) {
				if(!empty($_FILES) && isset($_FILES['bannerimage']) && !empty($_FILES['bannerimage']) && isset($_FILES['bannerimage']['name']) && $_FILES['bannerimage']['name'] != '') {
					$config['upload_path']          = BANNER_UPLOAD_PATH;
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 1000000;
					$config['max_width']            = 1024000;
					$config['max_height']           = 7680000;
					$config['encrypt_name']         = TRUE;

               		$this->load->library('upload', $config);

                	if ( ! $this->upload->do_upload('bannerimage')) {
                        $error = array('error' => $this->upload->display_errors());
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
                	}
					else {
						$data = array('upload_data' => $this->upload->data());
						$imagename = $data['upload_data']['file_name'];
						$inserdata['imagename'] = $imagename;
					}
					
				}
				
				$inserdata['texten'] = $post['texten'];
				$inserdata['textfr'] = $post['textfr'];
				$inserdata['page'] = $post['pageedit'];
				
					
				$isupdate = $this->admin_model->bannermanagementupdate($inserdata, $post['hiddeneditbannerid']);
				if($isupdate) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'Banner successfully uploaded';
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
	
	public function bannermanagementchangestatus($bannerid) {
		if($this->input->is_ajax_request()) {
			$isupdate = $this->admin_model->bannermanagementchangestatus($bannerid);
			/*if($isupdate) {*/
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Banner successfully uploaded';
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
	
	public function bannermanagementdelete($bannerid) {
		if($this->input->is_ajax_request()) {
			$isdelete = $this->admin_model->bannermanagementdelete($bannerid);
			if($isdelete) {
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Banner successfully deleted';
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


