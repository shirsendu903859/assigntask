<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array("admin_model"));
		
		$array = array('url'=>current_url());
		$this->session->set_userdata('previousurl', $array);
	}
	
	public function index() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard');
			$this->load->view('admin/footer');
		}
		else
		{
			redirect(base_url('admin/login'));
		}
	}
	
	public function login() {	
		$sessdata = $this->session->all_userdata();
		if(!isset($sessdata['adminsessdata']) || empty($sessdata['adminsessdata'])) {		
			$post = $this->input->post();
			if(empty($post)) {
				$this->load->view('admin/login');
			}
			else {
				if($this->input->is_ajax_request()) {
					$this->form_validation->set_rules('email', 'Email', 'trim|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					if($this->form_validation->run() == TRUE) {
						$isLogin = $this->admin_model->adminlogin($post);
						if(!empty($isLogin)) {
							if($isLogin['password'] == md5($post['password'])) {
								$loginTimeUpdate = $this->admin_model->loginTimeUpdate($isLogin['id']);
								$adminlogindata = array(
								'userid' => $isLogin['id'],
								'useremail' => $isLogin['email'],
								'last_login' => $loginTimeUpdate['lastlogin']
								);
							
								$this->session->set_userdata('adminsessdata', $adminlogindata);
								
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Login Successful';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Please check your password';	
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please check your username';	
						}
					}
					else
					{
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = validation_errors();	
					}
					echo json_encode($response);
				}
				else {
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin'));
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('adminsessdata');
		redirect(base_url('admin/'));
	} 
	
	public function usermanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) { //first time page load
				$data['vehicletype'] = $this->db->get_where('vehicletype', array('status'=>1))->result_array();
				$data['user'] = $this->admin_model->getalluserdata();
				
				$this->load->view('admin/header');
				$this->load->view('admin/adduser', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) { //request is made from ajax request
					if(isset($post['tag'])) {
						if($post['tag'] == 'statuschange') { //for changing the status change
							$isChange = $this->admin_model->changeuserstatus($post['userid']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'User status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'deleteuser') { //for deleting the user
							$isDelete = $this->admin_model->deleteuser($post['userid']);
							if($isDelete) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'User successfully deleted';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
							}
						}
						elseif($post['tag'] == 'edituser') { //for edit the user
							if($post['type'] == 'get') { //for fetching the data to put in the edit form
								$userdata = $this->admin_model->getuserdatabyid($post['userid']);
								if(!empty($userdata)) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'User successfully fetched';
									$response['data'] = $userdata;
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';
								}
							}
							elseif($post['type'] == 'post') { //for updating the database with edited data						

								$previousdata = $this->db->get_where('users', array('id'=>$post['useridedit']))->row_array();
								
								if($previousdata['email'] != $post['email']) {
									$this->form_validation->set_rules('email', 'Driver Email', 'trim|required|valid_email|is_unique[users.email]'); }
								else {
									$this->form_validation->set_rules('email', 'Driver Email', 'trim|required'); }
								
								if($previousdata['vehiclenumber'] != $post['vehiclenumber']) {
									$this->form_validation->set_rules('vehiclenumber', 'Vehicle Number', 'trim|required|is_unique[users.vehiclenumber]');  }
								else {
									$this->form_validation->set_rules('vehiclenumber', 'Vehicle Number', 'trim|required');  }
									
								$this->form_validation->set_rules('name', 'Name', 'trim|required');
								$this->form_validation->set_rules('vehicletype', 'Vehicle Type', 'trim|required');
								$this->form_validation->set_rules('address', 'Address', 'trim|required'); 
								$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
								if($this->form_validation->run() == TRUE) {
																		
									$insertdata['name'] = $post['name'];
									$insertdata['vehicletype'] = $post['vehicletype'];
									$insertdata['address'] = $post['address'];
									$insertdata['email'] = $post['email'];
									$insertdata['phone'] = $post['phone'];
									$insertdata['vehiclenumber'] = $post['vehiclenumber'];
									
									$isUpdate = $this->admin_model->updateuserdetails($insertdata, $post['useridedit']);
									if($isUpdate) {
										$response['success'] = 1;
										$response['error'] = 0;
										$response['msg'] = 'Driver data successfully updated';
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
									$response['msg'] = validation_errors();
								}
							}
						}
					}
					else //for inserting user data in db
					{
						$this->form_validation->set_rules('name', 'Driver Name', 'trim|required');
						$this->form_validation->set_rules('phone', 'Driver Phone', 'trim|required');
						$this->form_validation->set_rules('vehicletype', 'Vehicle Type', 'trim|required');
						$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]'); 
						$this->form_validation->set_rules('address', 'Address', 'trim|required'); 
						$this->form_validation->set_rules('vehiclenumber', 'Vehicle Number', 'trim|required|is_unique[users.vehiclenumber]'); 
						if($this->form_validation->run() == TRUE) {
							
							$inserdata = array();
							$inserdata['name'] = $post['name'];
							$inserdata['phone'] = $post['phone'];
							$inserdata['vehicletype'] = $post['vehicletype'];
							$inserdata['email'] = $post['email'];
							$inserdata['address'] = $post['address'];
							$inserdata['vehiclenumber'] = $post['vehiclenumber'];
								
							$isInsert = $this->admin_model->usermanagementinsert($inserdata);
							if($isInsert) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Driver added successfully';
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
							$response['msg'] = validation_errors();	
						}
					}
					echo json_encode($response);
				}
			}
			}
		else {
			redirect('admin');
		}	
		
	}
	
	public function vehicletypemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) { //first time page load
				$data['vehicletype'] = $this->db->get('vehicletype')->result_array();
				$this->load->view('admin/header');
				$this->load->view('admin/vehiclemanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) { //request is made from ajax request
				
					if(isset($post['tag'])) {
						if($post['tag'] == 'statuschange') { //for changing the status change
							$isChange = $this->admin_model->changevehiclestatus($post['vehicleid']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Vehicle status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'deleteuser') { //for deleting the user
							$isDelete = $this->admin_model->deletevehicle($post['vehicleid']);
							if($isDelete) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Vehicle successfully deleted';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
							}
						}
						elseif($post['tag'] == 'editvehicle') { //for edit the user
							if($post['type'] == 'get') { //for fetching the data to put in the edit form
								
								$vehicledata = $this->admin_model->getvehicledatabyid($post['vehicleid']);
								if(!empty($vehicledata)) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Vehicle successfully fetched';
									$response['data'] = $vehicledata;
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';
								}
							}
							elseif($post['type'] == 'post') { //for updating the database with edited data	
									
								$this->form_validation->set_rules('title', 'Vehicle Name', 'trim|required');
								$this->form_validation->set_rules('luggage', 'Luggage Availability', 'trim|required');
								$this->form_validation->set_rules('seat', 'No of Seats', 'trim|required'); 
								
								if($this->form_validation->run() == TRUE) {
																		
									$insertdata['title'] = $post['title'];
									$insertdata['luggage'] = $post['luggage'];
									$insertdata['seat'] = $post['seat'];
									
									$isUpdate = $this->admin_model->updatevehicledetails($insertdata, $post['vehicleidedit']);
									if($isUpdate) {
										$response['success'] = 1;
										$response['error'] = 0;
										$response['msg'] = 'Vehicle data successfully updated';
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
									$response['msg'] = validation_errors();
								}
							}
						}
					}
					else //for inserting user data in db
					{					
						$this->form_validation->set_rules('title', 'Vehicle Name', 'trim|required');
						$this->form_validation->set_rules('seat', 'No of Seat', 'trim|required');
						$this->form_validation->set_rules('luggage', 'Luggae Facility', 'trim|required');
						$this->form_validation->set_rules('caption', 'Vehicle Caption', 'trim|required');
						$this->form_validation->set_rules('description', 'Vehicle Description', 'trim|required');
						$this->form_validation->set_rules('doors', 'No of Doors', 'trim|required');
						$this->form_validation->set_rules('fuel', 'Fuel type', 'trim|required');
						if($this->form_validation->run() == TRUE) {
							$isInsert = $this->admin_model->vehiclemanagementinsert($post);
							if($isInsert) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Vehicle added successfully';
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
							$response['msg'] = validation_errors();	
						}
					}
					echo json_encode($response);
				}
			}
			}
		else {
			redirect('admin');
		}	
		
	}
	
	public function vehiclemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) { //first time page load
				$data['blog'] = $this->admin_model->getallblogdata();
				$data['vehicletype'] = $this->db->get_where('vehicletype', array('status'=>1))->result_array();
				$data['driver'] = $this->admin_model->getalluserdata();
				$this->load->view('admin/header');
				$this->load->view('admin/vehicleaddmanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					if(isset($post['tag'])) {
						if($post['tag'] == 'statuschange') { // for change the blog status
							$isChange = $this->admin_model->changeblogstatus($post['blogid']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'deleteblog') { //for delete blog
							$isDelete = $this->admin_model->deleteblog($post['blogid']);
							if($isDelete) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service successfully deleted';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
							}
						}
						elseif($post['tag'] == 'editblog') { //for edit blog
							if($post['type'] == 'get') { //for fetching the data to put in the edit form
								$blogdata = $this->admin_model->getblogdatabyid($post['blogid']);
								if(!empty($blogdata)) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Service successfully fetched';
									$response['data'] = $blogdata;
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';
								}
							}
							elseif($post['type'] == 'post') { //for updating the database with edited data		
								
								$insertdata = array();
								$imagenamearray = array();
								
								$filesCount = count($_FILES['blogimage']['name']);
								if($_FILES['blogimage']['name'][0] != '') {
									for($i = 0; $i < $filesCount; $i++){
									$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
									$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
									$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
									$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
									$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
					
									$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
									$config['allowed_types']        = 'gif|jpg|png';
									$config['max_size']             = 1000000;
									$config['max_width']            = 1024000;
									$config['max_height']           = 7680000;
									$config['encrypt_name']         = TRUE;
									
									$this->load->library('upload', $config);
									$this->upload->initialize($config);
									if($this->upload->do_upload('userFile')){
										$fileData = $this->upload->data();
										$imagenamearray[$i] = $fileData['file_name'];
									}
								}
									$allimage = $imagenamearray;
								}
								else {
									$allimage = $post['hiddenimg'];
								}
								
								//$allimage = array_merge($imagenamearray, $post['hiddenimg']);
								$inserdata['imagename'] = $allimage[0]; /*implode(STRING_DELIMETER,$allimage);*/
								$inserdata['title'] = $post['title'];
								$inserdata['description'] = $post['description'];
								$inserdata['shortdescription'] = $post['shortdescription'];
								
								$isUpdate = $this->admin_model->updateblogdetails($inserdata, $post['blogid']);
								if($isUpdate) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Service data successfully updated';
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
								}
							}
						}
						elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
							$imagedata = $this->admin_model->getblogimagebyid($post['blogid']);
							if(!empty($imagedata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service Image fetched successfully';
								$response['data'] = $imagedata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
							$descdata = $this->admin_model->getblogdescriptionbyid($post['blogid']);
							if(!empty($descdata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service details fetched successfully';
								$response['data'] = $descdata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
					}
					else //for inserting user data in db
					{
						$this->form_validation->set_rules('title', 'Service Title', 'trim|required');
						$this->form_validation->set_rules('description', 'Service Description', 'trim|required');
						if($this->form_validation->run() == TRUE) {
							$inserdata = $imagenamearray = array();
							$inserdata['imagename'] = '';
							
							$filesCount = count($_FILES['blogimage']['name']);
							for($i = 0; $i < $filesCount; $i++){
								$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
								$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
								$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
								$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
								$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
				
								$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
								
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if($this->upload->do_upload('userFile')){
									$fileData = $this->upload->data();
									$imagenamearray[$i] = $fileData['file_name'];
								}
							}
							if(!empty($imagenamearray)) { 
								$inserdata['imagename'] = implode(STRING_DELIMETER,$imagenamearray);
							}
							$inserdata['title'] = $post['title'];
							$inserdata['description'] = $post['description'];
							$inserdata['shortdescription'] = $post['shortdescription'];
						
							$isInsert = $this->admin_model->blogmanagementinsert($inserdata);
							if($isInsert) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service added successfully';
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
							$response['msg'] = validation_errors();	
						}
					}
					echo json_encode($response);
				}
			}
		}
		else {
			redirect('admin');
		}	
	
	}
	
	public function contentmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$data['user'] = $this->admin_model->getalluserdata();
			$this->load->view('admin/header');
			$this->load->view('admin/contentmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			redirect('admin');
		}
	}
	
	public function assigncontent($uid) {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$data['user'] = $this->admin_model->getuserdatabyid($uid);
			$data['filedata'] = $this->admin_model->getfiledatabyuserid($uid);
			$this->load->view('admin/header');
			$this->load->view('admin/assigncontent', $data);
			$this->load->view('admin/footer');
		}
		else {
			redirect('admin');
		}
	}
	
	public function savecontent($uid) {
		$post = $this->input->post();
		$files = $_FILES;
		if(!empty($files) && isset($files['file']['name'][0]) && $files['file']['name'][0] != '') {
			$countproductimage = count($files['file']['name']);
			
			foreach($files['file']['name'] as $key=>$val) {
				$previousimagename[] = $val;
			}	
			
			$config['upload_path']          = PRODUCT_UPLOAD_PATH;
			$config['allowed_types'] 		= '*';
			$config['max_size']             = 1000000;
			$config['max_width']            = 1024000;
			$config['max_height']           = 7680000;
			$config['encrypt_name']         = TRUE;

			$this->load->library('upload', $config);

			for($i=0; $i<$countproductimage; $i++) {				
				$_FILES['images']['name']= $files['file']['name'][$i];
				$_FILES['images']['type']= $files['file']['type'][$i];
				$_FILES['images']['tmp_name']= $files['file']['tmp_name'][$i];
				$_FILES['images']['error']= $files['file']['error'][$i];
				$_FILES['images']['size']= $files['file']['size'][$i];
				
				if ( ! $this->upload->do_upload('images')) {
					$error = array('error' => $this->upload->display_errors());					
				}
				else {
					$data = array('upload_data' => $this->upload->data());
					$imagename = $data['upload_data']['file_name'];
					$imagedata[] = $imagename;
				}
			}
			$isInsert = $this->admin_model->insertfiledata($uid, $imagedata, $previousimagename);
			if($isInsert) {
				$this->session->set_flashdata('successmsg', 'Files are successfully assigned');	
			}
			else {
				$this->session->set_flashdata('errormsg', 'Some internal error occured while uplaoding the files');	
			}
			
		}
		else {
			//$this->session->set_flashdata('errormsg', 'Please upload atleast one file to proceed');
			redirect('admin/assigncontent/'.$uid,'refresh');
		}
		$data['user'] = $this->admin_model->getuserdatabyid($uid);
		$data['filedata'] = $this->admin_model->getfiledatabyuserid($uid);
		$this->load->view('admin/header');
		$this->load->view('admin/assigncontent', $data);
		$this->load->view('admin/footer');
	}
	
	public function deletefile($fid, $uid) {
		$this->db->where('id',$fid);
		$this->db->delete('filedata');
		$this->session->set_flashdata('successmsg', 'File successfully deleted');
		redirect('admin/assigncontent/'.$uid,'refresh');
		/*$data['user'] = $this->admin_model->getuserdatabyid($uid);
		$data['filedata'] = $this->admin_model->getfiledatabyuserid($uid);
		$this->load->view('admin/header');
		$this->load->view('admin/assigncontent', $data);
		$this->load->view('admin/footer');*/
	}
	
	public function logomanagement(){
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data['logo'] = $this->admin_model->logomanagementfetchdata();
				$this->load->view('admin/header');
				$this->load->view('admin/logomanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				$inserdata = array();
				if(!empty($_FILES) && isset($_FILES['logoimage']) && !empty($_FILES['logoimage']) && isset($_FILES['logoimage']['name']) && $_FILES['logoimage']['name'] != '') {
					$config['upload_path']          = LOGO_UPLOAD_PATH;
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 1000000;
					$config['max_width']            = 1024000;
					$config['max_height']           = 7680000;
					$config['encrypt_name']         = TRUE;

               		$this->load->library('upload', $config);

                	if ( ! $this->upload->do_upload('logoimage')) {
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
					$inserdata['alt'] = $post['alt'];
					$inserdata['title'] = $post['title'];
					$inserdata['height'] = $post['height'];
					$inserdata['width'] = $post['width'];
					if(isset($post['active']) && $post['active'] == 1) {
						$inserdata['status'] = 1; }
					else {
						$inserdata['status'] = 0; }
					$isInsert = $this->admin_model->logomanagementinsert($inserdata);
					if($isInsert) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Logo successfully uploaded';
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
	
	public function logomanagementfetchdatabyid($logoid) {
		$logodata = $this->admin_model->logomanagementfetchdatabyid($logoid);
		if(!empty($logodata)) {
			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'Successfully fetched';
			$response['data'] = $logodata;
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Sorry some error occured. Please try again later.. !!';		
		}
		echo json_encode($response);
		exit(0);
	}
	
	public function updatelogomanagement() {
		if($this->input->is_ajax_request()) {
			$post = $this->input->post();
			if(!empty($post)) {
				if(!empty($_FILES) && isset($_FILES['logoimage']) && !empty($_FILES['logoimage']) && isset($_FILES['logoimage']['name']) && $_FILES['logoimage']['name'] != '') {
					$config['upload_path']          = LOGO_UPLOAD_PATH;
					$config['allowed_types']        = 'gif|jpg|png';
					$config['max_size']             = 1000000;
					$config['max_width']            = 1024000;
					$config['max_height']           = 7680000;
					$config['encrypt_name']         = TRUE;

               		$this->load->library('upload', $config);

                	if ( ! $this->upload->do_upload('logoimage')) {
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
				$inserdata['alt'] = $post['alt'];
				$inserdata['title'] = $post['title'];
				$inserdata['height'] = $post['height'];
				$inserdata['width'] = $post['width'];
					
				$isupdate = $this->admin_model->logomanagementupdate($inserdata, $post['hiddeneditloogid']);
				if($isupdate) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'Logo successfully uploaded';
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
	
	public function logomanagementchangestatus($logoid) {
		if($this->input->is_ajax_request()) {
			$isupdate = $this->admin_model->logomanagementchangestatus($logoid);
			if($isupdate) {
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Logo successfully uploaded';
				$response['data'] = $isupdate;
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
	
	public function logomanagementdelete($logoid) {
		if($this->input->is_ajax_request()) {
			$isdelete = $this->admin_model->logomanagementdelete($logoid);
			if($isdelete) {
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Logo successfully deleted';
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
	
	public function blogmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['blog'] = $this->admin_model->getallblogdata();
			$data['tag'] = $this->admin_model->selectqueryall('blogtag');
			$data['category'] = $this->admin_model->selectqueryall('blogcategory');
			$this->load->view('admin/header');
			$this->load->view('admin/blogmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changeblogstatus($post['blogid']);
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Service status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'deleteblog') { //for delete blog
						$isDelete = $this->admin_model->deleteblog($post['blogid']);
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'editblog') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$blogdata = $this->admin_model->getblogdatabyid($post['blogid']);
							$blogdata['imagename'] = ASSETS_URL.BLOG_IMAGE_UPLOAD_URL.$blogdata['imagename'][0];
							if(!empty($blogdata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service successfully fetched';
								$response['data'] = $blogdata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							
							$insertdata = array();
							$imagenamearray = array();
							
							$filesCount = count($_FILES['blogimage']['name']);
							if($_FILES['blogimage']['name'][0] != '') {
								for($i = 0; $i < $filesCount; $i++){
								$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
								$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
								$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
								$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
								$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
				
								$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
								
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if($this->upload->do_upload('userFile')){
									$fileData = $this->upload->data();
									$imagenamearray[$i] = $fileData['file_name'];
								}
							}
								$allimage = $imagenamearray;
								$inserdata['imagename'] = $allimage[0];
							}
							
							
							
							$inserdata['category'] = $post['category'];
							$inserdata['tag'] = $post['tag'];
							$inserdata['titleen'] = $post['titleen'];
							$inserdata['titlefr'] = $post['titlefr'];
							$inserdata['descriptionen'] = $post['descriptionen'];
							$inserdata['descriptionfr'] = $post['descriptionfr'];
							$inserdata['shortdescriptionen'] = $post['shortdescriptionen'];
							$inserdata['shortdescriptionfr'] = $post['shortdescriptionfr'];
							
							$isUpdate = $this->admin_model->updateblogdetails($inserdata, $post['blogid']);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getblogimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getblogdescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{					
					$this->form_validation->set_rules('titleen', 'Blog Title (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Blog Title (FR)', 'trim|required');
					$this->form_validation->set_rules('descriptionen', 'Blog Description (EN)', 'trim|required');
					$this->form_validation->set_rules('descriptionfr', 'Blog Description (FR)', 'trim|required');
					$this->form_validation->set_rules('shortdescriptionen', 'Blog Short Description (EN)', 'trim|required');
					$this->form_validation->set_rules('shortdescriptionfr', 'Blog Short Description (FR)', 'trim|required');
					$this->form_validation->set_rules('category', 'Blog Category', 'trim|required');
					$this->form_validation->set_rules('blogtag[]', 'Blog Tag', 'trim|required');
					
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						$inserdata['imagename'] = '';
						
						$filesCount = count($_FILES['blogimage']['name']);
						for($i = 0; $i < $filesCount; $i++){
							$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
							$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
							$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
							$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
							$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
			
							$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
							
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('userFile')){
								$fileData = $this->upload->data();
								$imagenamearray[$i] = $fileData['file_name'];
							}
						}
						if(!empty($imagenamearray)) { 
							$inserdata['imagename'] = /*implode(STRING_DELIMETER,$imagenamearray);*/ $imagenamearray[0];
						}
						$inserdata['category'] = $post['category'];
						$inserdata['tag'] = implode(',',$post['blogtag']);
						$inserdata['titleen'] = $post['titleen'];
						$inserdata['titlefr'] = $post['titlefr'];
						$inserdata['descriptionen'] = $post['descriptionen'];
						$inserdata['descriptionfr'] = $post['descriptionfr'];
						$inserdata['shortdescriptionen'] = $post['shortdescriptionen'];
						$inserdata['shortdescriptionfr'] = $post['shortdescriptionfr'];
						$inserdata['datetime'] = date('Y-m-d h:i:s');
						
					
						$isInsert = $this->admin_model->blogmanagementinsert($inserdata);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function servicemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->getallservicedata();
			
			$this->load->view('admin/header');
			$this->load->view('admin/servicemanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changeservicestatus($post['id']);
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Service status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deleteservice($post['id']);
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$servicedata = $this->admin_model->getservicedatabyid($post['id']);
							if(!empty($servicedata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service successfully fetched';
								$response['data'] = $servicedata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
								$config['upload_path']          = SERVICE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
			
								$this->load->library('upload', $config);
			
								if ( ! $this->upload->do_upload('imageblue')) {
									$error = array('error' => $this->upload->display_errors());
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
								}
								else {
									$data = array('upload_data' => $this->upload->data());
									$imagename = $data['upload_data']['file_name'];
									$imagenamearray['imageblue'] = $imagename;
								}
							}
						
							if(!empty($_FILES) && isset($_FILES['imageblack']) && !empty($_FILES['imageblack']) && isset($_FILES['imageblack']['name']) && $_FILES['imageblack']['name'] != '') {
								$config['upload_path']          = SERVICE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
			
								$this->load->library('upload', $config);
			
								if ( ! $this->upload->do_upload('imageblack')) {
									$error = array('error' => $this->upload->display_errors());
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
								}
								else {
									$data = array('upload_data' => $this->upload->data());
									$imagename = $data['upload_data']['file_name'];
									$imagenamearray['imageblack'] = $imagename;
								}
							}
							
							if(isset($imagenamearray['imageblue']) && $imagenamearray['imageblue'] != '') {
								$this->db->where('serviceid', $post['id']);
								$this->db->update('serviceimage', array('blueimagename'=>$imagenamearray['imageblue']));
							}
							if(isset($imagenamearray['imageblack']) && $imagenamearray['imageblack'] != '') {
								$this->db->where('serviceid', $post['id']);
								$this->db->update('serviceimage', array('blackimagename'=>$imagenamearray['imageblack']));
							} 
							
							
							
							$updatedata['titleen'] = $post['titleen'];
							$updatedata['titlefr'] = $post['titlefr'];
							$updatedata['descriptionen'] = $post['descriptionen'];
							$updatedata['descriptionfr'] = $post['descriptionfr'];
							$updatedata['shortdescriptionen'] = $post['shortdescriptionen'];
							$updatedata['shortdescriptionfr'] = $post['shortdescriptionfr'];
							
							$isUpdate = $this->admin_model->updateservicedetails($updatedata, $post['id']);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('titleen', 'Service Title (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Service Title (FR)', 'trim|required');
					$this->form_validation->set_rules('descriptionen', 'Service Description (EN)', 'trim|required');
					$this->form_validation->set_rules('descriptionfr', 'Service Description (FR)', 'trim|required');
					/*$this->form_validation->set_rules('shortdescriptionen', 'Service Short Description (EN)', 'trim|required');
					$this->form_validation->set_rules('shortdescriptionfr', 'Service Short Description (FR)', 'trim|required');*/
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						
						
						if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
							$config['upload_path']          = SERVICE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('imageblue')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$imagename = $data['upload_data']['file_name'];
								$imagenamearray['imageblue'] = $imagename;
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please upload one blue service image';
							echo json_encode($response);
							die();
						}
						
						if(!empty($_FILES) && isset($_FILES['imageblack']) && !empty($_FILES['imageblack']) && isset($_FILES['imageblack']['name']) && $_FILES['imageblack']['name'] != '') {
							$config['upload_path']          = SERVICE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('imageblack')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$imagename = $data['upload_data']['file_name'];
								$imagenamearray['imageblack'] = $imagename;
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please upload one black service image';
							echo json_encode($response);
							die();
						}
						
						$inserdata['titleen'] = $post['titleen'];
						$inserdata['titlefr'] = $post['titlefr'];
						$inserdata['descriptionen'] = $post['descriptionen'];
						$inserdata['descriptionfr'] = $post['descriptionfr'];
						$inserdata['shortdescriptionen'] = $post['shortdescriptionen'];
						$inserdata['shortdescriptionfr'] = $post['shortdescriptionfr'];
					
						$isInsert = $this->admin_model->servicemanagementinsert($inserdata);
						if($isInsert) {
							
							$imageinsertarr['serviceid'] = $isInsert;
							$imageinsertarr['blueimagename'] = $imagenamearray['imageblue'];
							$imageinsertarr['blackimagename'] = $imagenamearray['imageblack'];
							
							$isInsert = $this->admin_model->serviceimagemanagementinsert($imageinsertarr);
							if($isInsert) {		
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service added successfully';
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
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function offer() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->db->get('offer')->result_array();
			
			$this->load->view('admin/header');
			$this->load->view('admin/offer', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changeofferstatus($post['id']);
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Offer Status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$this->db->where('id', $post['id']);
						$isDelete = $this->db->delete('offer');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Offer successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$servicedata = $this->db->get_where('offer', array('id'=>$post['id']))->row_array();
							$servicedata['imagepath'] = base_url().SERVICE_UPLOAD_URL.$servicedata['imagename'];
							if(!empty($servicedata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Offer successfully fetched';
								$response['data'] = $servicedata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
								$config['upload_path']          = SERVICE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
			
								$this->load->library('upload', $config);
			
								if ( ! $this->upload->do_upload('imageblue')) {
									$error = array('error' => $this->upload->display_errors());
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
								}
								else {
									$data = array('upload_data' => $this->upload->data());
									$imagename = $data['upload_data']['file_name'];
									$updatedata['imagename'] = $imagename;
								}
							}
						
							if(isset($imagenamearray['imageblack']) && $imagenamearray['imageblack'] != '') {
								$this->db->where('serviceid', $post['id']);
								$this->db->update('serviceimage', array('blackimagename'=>$imagenamearray['imageblack']));
							} 
							
							
							
							$updatedata['title'] = $post['title'];
							$updatedata['description'] = $post['description'];
							
							$this->db->where('id', $post['id']);
							$isUpdate = $this->db->update('offer', $updatedata);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Offer successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('title', 'Offer Title', 'trim|required');
					$this->form_validation->set_rules('description', 'Offer Description', 'trim|required');
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						
						
						if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
							$config['upload_path']          = SERVICE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('imageblue')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   
								echo json_encode($response);
								die();                  
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$imagename = $data['upload_data']['file_name'];
								$inserdata['imagename'] = $imagename;
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please upload one blue service image';
							echo json_encode($response);
							die();
						}
												
						$inserdata['title'] = $post['title'];
						$inserdata['description'] = $post['description'];
						$inserdata['dateadded'] = date('Y-m-d h:i:s');
						
						$isInsert = $this->db->insert('offer', $inserdata);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Offer added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	
	
	public function subservicemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->getallservicedata();
			$data['subdata'] = $this->admin_model->getallsubservicedata();
			
			$this->load->view('admin/header');
			$this->load->view('admin/subservicemanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changeservicestatus($post['id']);
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Service status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deleteservice($post['id']);
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$servicedata = $this->admin_model->getsubservicedatabyid($post['id']);
							if(!empty($servicedata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service successfully fetched';
								$response['data'] = $servicedata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatesubservicedetails($post, $id);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('title', 'Title', 'trim|required');
					$this->form_validation->set_rules('description', 'Description', 'trim|required');
					$this->form_validation->set_rules('overview', 'Overview', 'trim|required');
					$this->form_validation->set_rules('offerings', 'Offering', 'trim|required');
					$this->form_validation->set_rules('specialization', 'Specialization', 'trim|required');
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						$post["serviceimage"] = "noimage.png";

						if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
							$config['upload_path']          = SERVICE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;

							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload('serviceimage')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$imagename = $data['upload_data']['file_name'];
								$post["serviceimage"] = $imagename;
							}
						}
						
						$isInsert = $this->admin_model->subservicemanagementinsert($post);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function adminprofile() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['admindata'] = $this->admin_model->getadmindetail();
				
				$this->load->view('admin/header');
				$this->load->view('admin/adminprofile', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					if(isset($post['newpassword']) && $post['newpassword'] != '') {
						$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
						$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
						$this->form_validation->set_rules('email', 'Email', 'trim|required');
						$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[8]');
						$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[newpassword]|min_length[8]');
						if($this->form_validation->run() == TRUE) {
							$password = md5($post['newpassword']);
							$post['password'] = $password;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = validation_errors();
							
							echo json_encode($response);
							die();	
						}
					}
					unset($post['newpassword']);
					unset($post['confirmpassword']);
					if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
						$config['upload_path']          = ADMIN_DP_UPLOAD_PATH;
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
							$post['imagename'] = $imagename;
						}
					}
					
					$isUpdate = $this->admin_model->updateadmindata($post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
						die();
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	}
	
	public function couponmanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data = array();
			//$data['blog'] = $this->admin_model->getallblogdata();
			$this->load->view('admin/header');
			$this->load->view('admin/couponmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changeblogstatus($post['blogid']);
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Blog status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'deleteblog') { //for delete blog
						$isDelete = $this->admin_model->deleteblog($post['blogid']);
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'editblog') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$blogdata = $this->admin_model->getblogdatabyid($post['blogid']);
							if(!empty($blogdata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'User successfully fetched';
								$response['data'] = $blogdata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$filesCount = count($_FILES['blogimage']['name']);
							for($i = 0; $i < $filesCount; $i++){
								$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
								$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
								$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
								$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
								$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
				
								$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
								
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if($this->upload->do_upload('userFile')){
									$fileData = $this->upload->data();
									$imagenamearray[$i] = $fileData['file_name'];
								}
							}
							
							$allimage = array_merge($imagenamearray, $post['hiddenimg']);
							$inserdata['imagename'] = implode(STRING_DELIMETER,$allimage);
							$inserdata['title'] = $post['title'];
							$inserdata['description'] = $post['description'];
							
							$isUpdate = $this->admin_model->updateblogdetails($inserdata, $post['blogid']);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getblogimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getblogdescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('title', 'Blog Title', 'trim|required');
					$this->form_validation->set_rules('description', 'Blog Description', 'trim|required');
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						$inserdata['imagename'] = '';
						
						$filesCount = count($_FILES['blogimage']['name']);
						for($i = 0; $i < $filesCount; $i++){
							$_FILES['userFile']['name'] = $_FILES['blogimage']['name'][$i];
							$_FILES['userFile']['type'] = $_FILES['blogimage']['type'][$i];
							$_FILES['userFile']['tmp_name'] = $_FILES['blogimage']['tmp_name'][$i];
							$_FILES['userFile']['error'] = $_FILES['blogimage']['error'][$i];
							$_FILES['userFile']['size'] = $_FILES['blogimage']['size'][$i];
			
							$config['upload_path']          = BLOG_IMAGE_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
							
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('userFile')){
								$fileData = $this->upload->data();
								$imagenamearray[$i] = $fileData['file_name'];
							}
						}
						if(!empty($imagenamearray)) { 
							$inserdata['imagename'] = implode(STRING_DELIMETER,$imagenamearray);
						}
						$inserdata['title'] = $post['title'];
						$inserdata['description'] = $post['description'];
					
						$isInsert = $this->admin_model->blogmanagementinsert($inserdata);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function categorymanagement() {
		$response = array();
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['categorydata'] = $this->admin_model->getcategorymanagementdetail();
				
				$this->load->view('admin/header');
				$this->load->view('admin/categorymanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					if(!isset($post['tag'])) {
						$this->form_validation->set_rules('title', 'Category Title', 'trim|required');
						if($this->form_validation->run() == TRUE) {
					$isUpdate = $this->admin_model->insertcategorymanagement($post);
						if($isUpdate) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Successfully Added!!'; 	   	
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
						$response['msg'] = validation_errors();	
					}
					}
					else {
						if($post['tag'] == 'statuschange') {
							$isChange = $this->admin_model->changecategorystatus($post['categoryid']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Category status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'editcategory') {
							$isUpdate = $this->admin_model->updatecategorybyid($post);
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Category Updated successfully';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
					}
					echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	}
		
	public function bannermanagement() {
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
	
	public function sitemanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['sitedata'] = $this->admin_model->getsitemanagementdetail();
				
				$this->load->view('admin/header');
				$this->load->view('admin/sitemanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					$isUpdate = $this->admin_model->updatesitemanagementdata($post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	
	}
	
	public function aboutmanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['sitedata'] = $this->admin_model->getaboutmanagementdetail();
								
				$this->load->view('admin/header');
				$this->load->view('admin/aboutmanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					$isUpdate = $this->admin_model->updateaboutmanagementdata($post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	
	}
	
	public function privacypolicymanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['sitedata'] = $this->admin_model->getprivacypolicymanagementdetail();
								
				$this->load->view('admin/header');
				$this->load->view('admin/privacypolicymanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					$isUpdate = $this->admin_model->updateprivacypolicymanagementdata($post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	
	}
	
	public function faremanagement() {		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) { //first time page load
				$data['vehicletype'] = $this->db->get_where('vehicletype', array('status'=>1))->result_array();
				$data['faremanagement'] = $this->db->get('faremanagement')->result_array();
				$this->load->view('admin/header');
				$this->load->view('admin/faremanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) { //request is made from ajax request
					if(isset($post['tag'])) {
						if($post['tag'] == 'statuschange') { //for changing the status change
							$isChange = $this->admin_model->changefarestatus($post['id']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Fare Plan status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'deleteuser') { //for deleting the user
							$isDelete = $this->admin_model->deletefare($post['id']);
							if($isDelete) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Fare Plan successfully deleted';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
							}
						}
						elseif($post['tag'] == 'editfare') { //for edit the user
							if($post['type'] == 'get') { //for fetching the data to put in the edit form
								
								$faredata = $this->admin_model->getfaredatabyid($post['id']);
								$vehicleid = $faredata['vehicletype'];
								$choosenvehicledata = $this->admin_model->getvehicledatabyid($vehicleid);
								
								if(!empty($faredata)) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Fare Plan successfully fetched';
									$response['data'] = $faredata;
									$response['seatcount'] = $choosenvehicledata['seat'];
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';
								}
							}
							elseif($post['type'] == 'post') { //for updating the database with edited data	
									
								$this->form_validation->set_rules('maxkm', 'Maximum Kilometer', 'trim|required');
								$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
								$this->form_validation->set_rules('starthour', 'Start Hour', 'trim|required');
								$this->form_validation->set_rules('startminute', 'Start Minute', 'trim|required');
								$this->form_validation->set_rules('startmeridian', 'Start Meridian', 'trim|required');
								$this->form_validation->set_rules('endhour', 'End Hour', 'trim|required');
								$this->form_validation->set_rules('endminute', 'End Minute', 'trim|required');
								$this->form_validation->set_rules('endmeridian', 'End Meridian', 'trim|required');
								$this->form_validation->set_rules('vehicletype', 'Vehicle Type', 'trim|required');
								$this->form_validation->set_rules('numberofseat', 'Number of Seats', 'trim|required');
								
								if($this->form_validation->run() == TRUE) {
																		
									if($post['startmeridian'] == 'PM') {
										$post['starthour'] = intval($post['starthour']) + intval(12);
									}
									if($post['endmeridian'] == 'PM') {
										$post['endhour'] = intval($post['endhour']) + intval(12);
									}
									
									$starttime = $post['starthour'].':'.$post['startminute'];
									$endtime = $post['endhour'].':'.$post['endminute'];
									
									$insertarray = array(
														 'maxkm'=>$post['maxkm'],
														 'amount'=>$post['amount'],
														 'starttime'=>$starttime,
														 'endtime'=>$endtime,
														 'vehicletype'=>$post['vehicletype'],
														 'numberofseat'=>$post['numberofseat'],
														 );
									
									$isUpdate = $this->admin_model->updatefaredetails($insertarray, $post['id']);
									if($isUpdate) {
										$response['success'] = 1;
										$response['error'] = 0;
										$response['msg'] = 'Vehicle data successfully updated';
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
									$response['msg'] = validation_errors();
								}
							}
						}
					}
					else //for inserting user data in db
					{					
						$this->form_validation->set_rules('maxkm', 'Maximum Kilometer', 'trim|required');
						$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
						$this->form_validation->set_rules('starthour', 'Start Hour', 'trim|required');
						$this->form_validation->set_rules('startminute', 'Start Minute', 'trim|required');
						$this->form_validation->set_rules('startmeridian', 'Start Meridian', 'trim|required');
						$this->form_validation->set_rules('endhour', 'End Hour', 'trim|required');
						$this->form_validation->set_rules('endminute', 'End Minute', 'trim|required');
						$this->form_validation->set_rules('endmeridian', 'End Meridian', 'trim|required');
						$this->form_validation->set_rules('vehicletype', 'Vehicle Type', 'trim|required');
						$this->form_validation->set_rules('numberofseat', 'Number of Seats', 'trim|required');
						
						if($this->form_validation->run() == TRUE) {
							
							if($post['startmeridian'] == 'PM') {
								$post['starthour'] = intval($post['starthour']) + intval(12);
							}
							if($post['endmeridian'] == 'PM') {
								$post['endhour'] = intval($post['endhour']) + intval(12);
							}
							
							$starttime = $post['starthour'].':'.$post['startminute'];
							$endtime = $post['endhour'].':'.$post['endminute'];
							
							$insertarray = array(
												 'maxkm'=>$post['maxkm'],
												 'amount'=>$post['amount'],
												 'starttime'=>$starttime,
												 'endtime'=>$endtime,
												 'vehicletype'=>$post['vehicletype'],
												 'numberofseat'=>$post['numberofseat'],
												 );
							
							$isInsert = $this->admin_model->faremanagementinsert($insertarray);
							if($isInsert) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Fare plan added successfully';
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
							$response['msg'] = validation_errors();	
						}
					}
					echo json_encode($response);
				}
			}
			}
		else {
			redirect('admin');
		}	
		
	
	}

	public function customermanagement() {
		$customer = $this->db->get('customer')->result_array();
		foreach($customer as $key=>$val) {
			$details = array();
			if($val['customertype'] == 'individual') {
				$details = $this->db->get_where('customerindividual', array('foreignid'=>$val['id']))->row_array();
				$customer[$key]['details'] = $details;
			}
			elseif($val['customertype'] == 'institution') {
				$details = $this->db->get_where('customerinstitution', array('foreignid'=>$val['id']))->row_array();
				$customer[$key]['details'] = $details;
			}
		}
		
		$post = $this->input->post();
		/*if(!empty()){
				
		}*/
		
		
		$data['data'] = $customer;
		$this->load->view('admin/header');
		$this->load->view('admin/customermanagement', $data);
		$this->load->view('admin/footer');
		
	}
	
	public function testimonialmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('testimonialmanagement');
			
			$this->load->view('admin/header');
			$this->load->view('admin/testimonialmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'testimonialmanagement');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Testimonial status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'testimonialmanagement');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Testimonial successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'testimonialmanagement');
							if(!empty($data)) {
								
								$data['image'] = ASSETS_URL.TESTIMONIAL_UPLOAD_URL.$data['image'];
								
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Testimonial successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
						
							$insertdata = array();
							$imagenamearray = array();
							
							if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
								$config['upload_path']          = TESTIMONIAL_UPLOAD_PATH;
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
									$post['image'] = $imagename;
								}
							}
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'testimonialmanagement');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Testimonial data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('name', 'Person Name', 'trim|required');
					/*$this->form_validation->set_rules('designation', 'Person Designation', 'trim|required');*/
					$this->form_validation->set_rules('testimonial', 'Testimonial', 'trim|required');
					/*$this->form_validation->set_rules('testimonialfr', 'Testimonial (FR)', 'trim|required');*/
					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						
						
						/*if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
							$config['upload_path']          = TESTIMONIAL_UPLOAD_PATH;
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
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please upload one image';
							echo json_encode($response);
							die();
						}*/
						
						$tablename = 'testimonialmanagement';
						
						$isInsert = $this->admin_model->insertquery($post, $tablename);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Testimonial added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function faqtopicmanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('faqtopic');
			
			$this->load->view('admin/header');
			$this->load->view('admin/faqtopicmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'faqtopic');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'FAQ Topic status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'faqtopic');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'faqtopic');
							if(!empty($data)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'FAQ Topic successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'faqtopic');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'FAQ Topic data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('titleen', 'FAQ Topic Title (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'FAQ Topic Title (FR)', 'trim|required');
					if($this->form_validation->run() == TRUE) {
					
						$isInsert = $this->admin_model->insertquery($post, 'faqtopic');
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'FAQ Topic added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function faqmanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['topic'] = $this->admin_model->selectqueryall('faqtopic');
			$data['data'] = $this->admin_model->selectqueryall('faqmanagement');
		
			$this->load->view('admin/header');
			$this->load->view('admin/faqmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'faqmanagement');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'FAQ status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'faqmanagement');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'FAQ successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'faqmanagement');
							if(!empty($data)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'FAQ successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'faqmanagement');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'FAQ data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('questionen', 'Question (EN)', 'trim|required');
					$this->form_validation->set_rules('answeren', 'Answer (EN)', 'trim|required');
					$this->form_validation->set_rules('questionfr', 'Question (FR)', 'trim|required');
					$this->form_validation->set_rules('answerfr', 'Answer (FR)', 'trim|required');
					$this->form_validation->set_rules('topic', 'FAQ Topic', 'trim|required');
					
					if($this->form_validation->run() == TRUE) {
					
						$isInsert = $this->admin_model->insertquery($post, 'faqmanagement');
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'FAQ added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function termsconditions() {
		
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$data['sitedata'] = $this->admin_model->selectqueryall('termsconditions');
								
				$this->load->view('admin/header');
				$this->load->view('admin/termsconditions', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					$isUpdate = $this->admin_model->updatetermsconditionsmanagementdata($post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}
	
	
	}
	
	public function contactquery() {
		$data['data'] = $this->db->get('contactquery')->result_array();
		$this->load->view('admin/header');
		$this->load->view('admin/contactquery', $data);
		$this->load->view('admin/footer');
	}
	
	public function blogcategorymanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('blogcategory');
			
			$this->load->view('admin/header');
			$this->load->view('admin/blogcategorymanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'blogcategory');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Blog Category status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'blogcategory');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Category successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'blogcategory');
							if(!empty($data)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog Category successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'blogcategory');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog Category data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogcategory']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Category fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogcategory']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Category fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('titleen', 'Blog Category (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Blog Category (FR)', 'trim|required');
					if($this->form_validation->run() == TRUE) {
					
						$isInsert = $this->admin_model->insertquery($post, 'blogcategory');
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Category added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function blogtagmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('blogtag');
			
			$this->load->view('admin/header');
			$this->load->view('admin/blogtagmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'blogtag');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Blog Tag status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'blogtag');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Tag successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'blogtag');
							if(!empty($data)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog Tag successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'blogtag');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Blog Tag data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogtag']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Tag fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogtag']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Tag fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('titleen', 'Blog Category (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Blog Category (FR)', 'trim|required');
					if($this->form_validation->run() == TRUE) {
					
						$isInsert = $this->admin_model->insertquery($post, 'blogtag');
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Blog Tag added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function resourcemanagement() {
		
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('resourcemanagement');
			$this->load->view('admin/header');
			$this->load->view('admin/resourcemanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'resourcemanagement');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Resource status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'resourcemanagement');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Resource successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'resourcemanagement');
							if(!empty($data)) {
								
								$data['image'] = ASSETS_URL.RESOURCES_UPLOAD_URL.$data['image'];
								
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Testimonial successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
						
							$insertdata = array();
							$imagenamearray = array();
							
							if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
								$config['upload_path']          = RESOURCES_UPLOAD_PATH;
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
									$post['image'] = $imagename;
								}
							}
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'resourcemanagement');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Resource data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Service details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					$this->form_validation->set_rules('titleen', 'Title (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Title (FR)', 'trim|required');
					$this->form_validation->set_rules('categoryen', 'Category (EN)', 'trim|required');
					$this->form_validation->set_rules('categoryfr', 'Category (FR)', 'trim|required');
					$this->form_validation->set_rules('texten', 'Description (EN)', 'trim|required');
					$this->form_validation->set_rules('textfr', 'Description (FR)', 'trim|required');
					$this->form_validation->set_rules('url', 'Redirect URL', 'trim|required');

					if($this->form_validation->run() == TRUE) {
						$inserdata = $imagenamearray = array();
						
						if(!empty($_FILES) && isset($_FILES['image']) && !empty($_FILES['image']) && isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
							$config['upload_path']          = RESOURCES_UPLOAD_PATH;
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
							}
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Please upload one image';
							echo json_encode($response);
							die();
						}
						
						$post['image'] = $imagename;
						$tablename = 'resourcemanagement';
						
						$isInsert = $this->admin_model->insertquery($post, $tablename);
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Resources added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	
	}
	
	public function processmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$result = $this->admin_model->selectqueryall('processmanagement');
				$data['data'] = $result[0];		
				$this->load->view('admin/header');
				$this->load->view('admin/processmanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					
					$isUpdate = $this->db->update('processmanagement', $post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}	
	}
	
	public function homepagemanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$result = $this->admin_model->selectqueryall('homepagemanagement');
				$data['data'] = $result[0];		
				$this->load->view('admin/header');
				$this->load->view('admin/homepagemanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					
					if(!empty($_FILES) && isset($_FILES['image1']) && !empty($_FILES['image1']) && isset($_FILES['image1']['name']) && $_FILES['image1']['name'] != '') {
							$config['upload_path']          = RESOURCES_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('image1')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$post['image1'] = $data['upload_data']['file_name'];
							}
						}
					if(!empty($_FILES) && isset($_FILES['image2']) && !empty($_FILES['image2']) && isset($_FILES['image2']['name']) && $_FILES['image2']['name'] != '') {
							$config['upload_path']          = RESOURCES_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('image2')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$post['image2'] = $data['upload_data']['file_name'];
							}
						}
					
					
					$isUpdate = $this->db->update('homepagemanagement', $post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}	
	}
	
	public function ratesmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

		$post = $this->input->post();
		if(empty($post)) { //first time page load
			$data['data'] = $this->admin_model->selectqueryall('faqtopic');
			
			$this->load->view('admin/header');
			$this->load->view('admin/ratesmanagement', $data);
			$this->load->view('admin/footer');
		}
		else {
			if($this->input->is_ajax_request()) {
				if(isset($post['tag'])) {
					if($post['tag'] == 'statuschange') { // for change the blog status
						$isChange = $this->admin_model->changestatus($post['id'], 'faqtopic');
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Rates status successfully changed';
						$response['data'] = $isChange;
					}
					elseif($post['tag'] == 'delete') { //for delete blog
						$isDelete = $this->admin_model->deletequery($post['id'], 'faqtopic');
						if($isDelete) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Rates successfully deleted';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
						}
					}
					elseif($post['tag'] == 'edit') { //for edit blog
						if($post['type'] == 'get') { //for fetching the data to put in the edit form
							$data = $this->admin_model->selectquerybyid($post['id'], 'faqtopic');
							if(!empty($data)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Rates successfully fetched';
								$response['data'] = $data;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['type'] == 'post') { //for updating the database with edited data		
							$insertdata = array();
							$imagenamearray = array();
							
							$id = $post['id'];
							unset($post['id']);
							unset($post['tag']);
							unset($post['type']);
							
							$isUpdate = $this->admin_model->updatequery($post, $id, 'faqtopic');
							if($isUpdate) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Rates data successfully updated';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
							}
						}
					}
					elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
						$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
						if(!empty($imagedata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Rates Image fetched successfully';
							$response['data'] = $imagedata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
					elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
						$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
						if(!empty($descdata)) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Rates details fetched successfully';
							$response['data'] = $descdata;
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured. Please try again later..!!';
						}
					}
				}
				else //for inserting user data in db
				{
					print_r($post); die();
					$this->form_validation->set_rules('titleen', 'Title (EN)', 'trim|required');
					$this->form_validation->set_rules('titlefr', 'Title (FR)', 'trim|required');
					$this->form_validation->set_rules('amount', 'Title (EN)', 'trim|required');
					$this->form_validation->set_rules('viewallprovider', 'Title (FR)', 'trim|required');
					$this->form_validation->set_rules('contactallprovider', 'Title (EN)', 'trim|required');
					$this->form_validation->set_rules('regularjob', 'Title (FR)', 'trim|required');
					$this->form_validation->set_rules('urgentjob', 'Title (EN)', 'trim|required');
					$this->form_validation->set_rules('bookpay', 'Title (FR)', 'trim|required');
					$this->form_validation->set_rules('backgroundcheck', 'Title (EN)', 'trim|required');
					
					if($this->form_validation->run() == TRUE) {
					
						$isInsert = $this->admin_model->insertquery($post, 'faqtopic');
						if($isInsert) {
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Rates added successfully';
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
						$response['msg'] = validation_errors();	
					}
				}
				echo json_encode($response);
			}
		}
		}
		else {
			redirect('admin');
		}	
	}
	
	public function identityvalidation() {
		$data = array();
		$data = $this->db->get_where('identitydocument', array('status'=>0))->result_array();
		foreach($data as $key=>$val) {
			$userdata = $this->db->get_where('worker', array('id'=>$val['userid']))->row_array();
			$data[$key]['userdata'] = $userdata; 
		}
		$return['data'] = $data;
		$this->load->view('admin/header');
		$this->load->view('admin/identityvalidation', $return);
		$this->load->view('admin/footer');
	}
	
	public function identitydocumentview($id) {
		$data = $this->db->get_where('identitydocument', array('id'=>$id))->row_array();
		$imagename = ASSETS_URL.DOCUMENT_DP_UPLOAD_URL.$data['imagename'];
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Successfully Fetched';
		$response['imagename'] = $imagename;
		
		echo json_encode($response); exit(0); die();
	}
	
	public function approveidentity($id) {
		$updatearr['status'] = 1;
		$this->db->where('id',$id);
		$this->db->update('identitydocument', $updatearr);
		
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Successfully Approved';
	
		echo json_encode($response); exit(0); die();
	}
	
	public function declineidentity($id) {
		$updatearr['status'] = 2;
		$this->db->where('id',$id);
		$this->db->update('identitydocument', $updatearr);
		
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Successfully Declined';
	
		echo json_encode($response); exit(0); die();
	}
	
	public function seomanagement($pageid = '') {
		if($pageid == '') { redirect(base_url()); }
		
		$data = array();
		
		$this->load->view('admin/header');
		$this->load->view('admin/seomanagement', $data);
		$this->load->view('admin/footer');
	}
	
	public function seomanagementupdate() {
		$post = $this->input->post();
		$pageid = $post['pageid'];
		unset($post['pageid']);
		$this->db->where('pageid', $pageid);
		$this->db->update('seomanagement', $post);
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Successfully Updated';
		
		echo json_encode($response); exit(0); die();
	}
	
		public function projectmanagement() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

			$post = $this->input->post();
			if(empty($post)) { //first time page load
				$data['data'] = $this->db->get('projectmanagement')->result_array();
				
				$this->load->view('admin/header');
				$this->load->view('admin/projectmanagement', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					if(isset($post['tag'])) {
						if($post['tag'] == 'statuschange') { // for change the blog status
							$isChange = $this->admin_model->changeprojectstatus($post['id']);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Project status successfully changed';
							$response['data'] = $isChange;
						}
						elseif($post['tag'] == 'delete') { //for delete blog
										$this->db->where('id', $post['id']);
							$isDelete = $this->db->delete('projectmanagement');
							//$isDelete = $this->admin_model->deleteservice($post['id']);
							if($isDelete) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Project successfully deleted';
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';					
							}
						}
						elseif($post['tag'] == 'edit') { //for edit blog
							if($post['type'] == 'get') { //for fetching the data to put in the edit form
								$servicedata = $this->db->get_where('projectmanagement', array('id'=>$post['id']))->row_array();
								$imagepath = base_url().SERVICE_UPLOAD_URL.$servicedata['imagename'];
								$servicedata['imagepath'] = $imagepath;
								if(!empty($servicedata)) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Project successfully fetched';
									$response['data'] = $servicedata;
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';
								}
							}
							elseif($post['type'] == 'post') { //for updating the database with edited data		
								$insertdata = array();
								$imagenamearray = array();
								
								if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
									$config['upload_path']          = SERVICE_UPLOAD_PATH;
									$config['allowed_types']        = 'gif|jpg|png';
									$config['max_size']             = 1000000;
									$config['max_width']            = 1024000;
									$config['max_height']           = 7680000;
									$config['encrypt_name']         = TRUE;
				
									$this->load->library('upload', $config);
				
									if ( ! $this->upload->do_upload('imageblue')) {
										$error = array('error' => $this->upload->display_errors());
										$response['success'] = 0;
										$response['error'] = 1;
										$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
									}
									else {
										$data = array('upload_data' => $this->upload->data());
										$imagename = $data['upload_data']['file_name'];
										$updatedata['imagename'] = $imagename;
									}
								}
							
																
								$updatedata['title'] = $post['title'];
								$updatedata['type'] = $post['projecttype'];
								$updatedata['unit'] = $post['unit'];
								$updatedata['price'] = $post['price'];
								
											$this->db->where('id', $post['id']);
								$isUpdate = $this->db->update('projectmanagement', $updatedata);
								
								if($isUpdate) {
									$response['success'] = 1;
									$response['error'] = 0;
									$response['msg'] = 'Project data successfully updated';
								}
								else {
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!';	
								}
							}
						}
						elseif($post['tag'] == 'fetchimage') { //for fetch the blog images to show in enlarger
							$imagedata = $this->admin_model->getserviceimagebyid($post['blogid']);
							if(!empty($imagedata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service Image fetched successfully';
								$response['data'] = $imagedata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
						elseif($post['tag'] == 'fetchdescription') { //fetch the full description 
							$descdata = $this->admin_model->getservicedescriptionbyid($post['blogid']);
							if(!empty($descdata)) {
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Service details fetched successfully';
								$response['data'] = $descdata;
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!';
							}
						}
					}
					else //for inserting user data in db
					{
						$this->form_validation->set_rules('title', 'Project Title', 'trim|required');
						$this->form_validation->set_rules('type', 'Project Type', 'trim|required');
						$this->form_validation->set_rules('unit', 'Project Unit', 'trim|required');
						$this->form_validation->set_rules('price', 'Project Price', 'trim|required');
						if($this->form_validation->run() == TRUE) {
							$inserdata = $imagenamearray = array();

							if(!empty($_FILES) && isset($_FILES['imageblue']) && !empty($_FILES['imageblue']) && isset($_FILES['imageblue']['name']) && $_FILES['imageblue']['name'] != '') {
								$config['upload_path']          = SERVICE_UPLOAD_PATH;
								$config['allowed_types']        = 'gif|jpg|png';
								$config['max_size']             = 1000000;
								$config['max_width']            = 1024000;
								$config['max_height']           = 7680000;
								$config['encrypt_name']         = TRUE;
			
								$this->load->library('upload', $config);
			
								if ( ! $this->upload->do_upload('imageblue')) {
									$error = array('error' => $this->upload->display_errors());
									$response['success'] = 0;
									$response['error'] = 1;
									$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
								}
								else {
									$data = array('upload_data' => $this->upload->data());
									$imagename = $data['upload_data']['file_name'];
									$post['imagename'] = $imagename;
								}
							}
							else {
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Please upload project image';
								echo json_encode($response);
								die();
							}
														
							$isInsert = $this->db->insert('projectmanagement', $post);
							if($isInsert) {								
								$response['success'] = 1;
								$response['error'] = 0;
								$response['msg'] = 'Project added successfully';
								
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
							$response['msg'] = validation_errors();	
						}
					}
					echo json_encode($response);
				}
			}
		}
		else {
			redirect('admin');
		}	
	}


	public function newsletter() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {

			$data['newsletter'] = $this->db->get('newsletter')->result_array();
			$this->load->view('admin/header');
			$this->load->view('admin/newsletter', $data);
			$this->load->view('admin/footer');
		}
		else {
			redirect('admin');
		}	

	}
	
		public function projectpage() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['adminsessdata']) || !empty($sessdata['adminsessdata'])) {
			$post = $this->input->post();
			if(empty($post)) {
				$data = array();
				$result = $this->admin_model->selectqueryall('projectpage');
				$data['data'] = $result[0];		
				$this->load->view('admin/header');
				$this->load->view('admin/projectpage', $data);
				$this->load->view('admin/footer');
			}
			else {
				if($this->input->is_ajax_request()) {
					
					if(!empty($_FILES) && isset($_FILES['imageone']) && !empty($_FILES['imageone']) && isset($_FILES['imageone']['name']) && $_FILES['imageone']['name'] != '') {
							$config['upload_path']          = RESOURCES_UPLOAD_PATH;
							$config['allowed_types']        = 'gif|jpg|png';
							$config['max_size']             = 1000000;
							$config['max_width']            = 1024000;
							$config['max_height']           = 7680000;
							$config['encrypt_name']         = TRUE;
		
							$this->load->library('upload', $config);
		
							if ( ! $this->upload->do_upload('imageone')) {
								$error = array('error' => $this->upload->display_errors());
								$response['success'] = 0;
								$response['error'] = 1;
								$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	                     
							}
							else {
								$data = array('upload_data' => $this->upload->data());
								$post['imageone'] = $data['upload_data']['file_name'];
							}
						}
					
					
					$isUpdate = $this->db->update('projectpage', $post);
					if($isUpdate) {
						$response['success'] = 1;
						$response['error'] = 0;
						$response['msg'] = 'Successfully Updated!!'; 	   	
					} 
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Sorry some error occured. Please try again later..!!'; 	   	
					}
						echo json_encode($response);
				}
				else { 
					die('No direct script access allowed');
				}
			}
		}
		else {
			redirect(base_url('admin/login'));	
		}	
	}


}


