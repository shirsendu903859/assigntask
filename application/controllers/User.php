
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct() {
		parent::__construct();
		$this->load->model(array("user_model"));
	}
	
	public function index() {
		/*$data['bannerdata'] = $this->gethomeactivebanner();
		$data['category'] = $this->getactiveparentcategory();
		$data['sitedata'] = $this->user_model->sitedata();
		$data['homeproduct'] = $this->user_model->homeproduct();*/
		
		$data['bannerdata'] = $this->db->get_where('bannermanagement', array('page'=>1))->result_array();
		$data['sitedata'] = $this->user_model->sitedata();
		$data['offer'] = $this->db->get_where('offer', array('status'=>1))->result_array();
		$data['testimonial'] = $this->db->get_where('testimonialmanagement', array('status'=>1))->result_array();
		$data['service'] = $this->db->get_where('subservicemanagement', array('status'=>1))->result_array();
		$data['content'] = $this->db->get('homepagemanagement')->row_array();
		
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/home', $data);
		$this->load->view('frontend/footer', $data);
		
	}
	
	/*for chat part starts*/
	public function index2() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['sessdata']) || !empty($sessdata['sessdata'])) {
			redirect(base_url('chat'));
		}
		else {
			$post = $this->input->post();
			if(empty($post)) {
				$this->load->view('user/login');
			}
			else {
				$this->form_validation->set_rules('email', 'Username', 'trim|required');
				$this->form_validation->set_rules('pass', 'Password', 'trim|required');
				if($this->form_validation->run() == TRUE) {
					if($post['email'] == DEMOUSER1) {
						if($post['pass'] == DEMOPASS1) {
							$sessionarr = array(
								'username' => DEMOUSER1,
								'isLoggedIn' => 1,
								'userid' => 1,
							);
							$this->session->set_userdata('sessdata', $sessionarr);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Session Created';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Invalid Credentials';
						}
					}
					elseif($post['email'] == DEMOUSER2) {
						if($post['pass'] == DEMOPASS2) {
							$sessionarr = array(
								'username' => DEMOUSER2,
								'isLoggedIn' => 1,
								'userid' => 2,
							);
							$this->session->set_userdata('sessdata', $sessionarr);
							$response['success'] = 1;
							$response['error'] = 0;
							$response['msg'] = 'Session Created';
						}
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Invalid Credentials';
						} 	
					}
					else {
						$response['success'] = 0;
						$response['error'] = 1;
						$response['msg'] = 'Invalid Credentials';
					}
				}
				else {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = validation_errors();	
				}
				echo json_encode($response);
			}
		}
	}
	public function chat() {
		$sessdata = $this->session->all_userdata();
		if(isset($sessdata['sessdata']) || !empty($sessdata['sessdata'])) {
			$userid = $sessdata['sessdata']['userid'];
			if($userid == 1) { $reciever = 2; }
			if($userid == 2) { $reciever = 1; }
			
			$data['chat'] = $this->user_model->getchat($userid, $reciever);
			$this->load->view('user/chat', $data);
		}
		else {
			redirect(base_url());
		}
	}
	public function sendmsg() {
		$post = $this->input->post();
		$msg = base64_decode($post['msg']);
		$sessdata = $this->session->all_userdata();
		$userid = $sessdata['sessdata']['userid'];
		if($userid == 1) { $reciever = 2; }
		if($userid == 2) { $reciever = 1; }
		
		$datetime = date('Y-m-d h:i:s');
		$insertarr = array(
						   'sender'=>$userid,
						   'reciever'=>$reciever,
						   'msg'=>$msg,
						   'datetime' => $datetime
						   );
		$isInsert = $this->user_model->sendmsg($insertarr);
		if($isInsert) {
			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'msg send';
			$response['datetime'] = $datetime;
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Sorry some error occured';	
		}
		echo json_encode($response);
	}
	public function randomcheckmsg() {
		$sessdata = $this->session->all_userdata();
		$userid = $sessdata['sessdata']['userid'];
		if($userid == 1) { $reciever = 2; }
		if($userid == 2) { $reciever = 1; }
		$data = $this->user_model->getchat($userid, $reciever);
		echo json_encode($data);
	}
	/*for chat part ends*/
		
	public function logout() {
		$this->session->unset_userdata('sessdata');
		redirect(base_url());
	}
	
	public function gethomeactivebanner() {
		$banner = $this->user_model->gethomeactivebanner();
		foreach($banner as $key=>$val) {
			$imagename = $val['imagename'];
			$fullimagepath = base_url().BANNER_UPLOAD_URL.$imagename;
			$banner[$key]['path'] = $fullimagepath;
		}
		return $banner;
	}
	
	public function getactiveparentcategory() {
		$category = $this->user_model->getactiveparentcategory();
		return $category;
	}
	
	public function getproductfromactivecategory() {
		
	}
	
	public function productdetails($name='', $id='') {
		$data = array();
		$data['sitedata'] = $this->user_model->sitedata();
		$data['cartdata'] = $this->cart->contents();
		$data['product'] = $this->user_model->getcompleteproductdatabyid($id);
		$data['review']  = $this->user_model->getreviewbyproductid($id);
		$data['cartwish'] = $this->checkexistcartwishlist($id);
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/productdetails', $data);
		$this->load->view('frontend/footer', $data);
	}
	
	public function addreview() {
		$post = $this->input->post();
		if(!empty($post)) {
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('rating', 'Rating', 'trim|required');
			$this->form_validation->set_rules('comment', 'Review', 'trim|required');
			if($this->form_validation->run() == TRUE) {
				$isInsert = $this->user_model->insertreview($post);
				if($isInsert) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'We have successfully revieved your review. It will post on site upon approval.';	
				}
				else {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'Sorry some error occured. Please try again after some time.';
				}
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = validation_errors();
			}
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Please fill the form first';	
		}
		echo json_encode($response);
		die();
	}
	
	public function register() {
		$post = $this->input->post();
		if(!empty($post)) {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			if($this->form_validation->run() == TRUE) {
				$password = md5($post['password']);
				$post['password'] = $password;
				$isInsert = $this->user_model->insertregisterdata($post);
				if($isInsert) {
					$response['success'] = 1;
					$response['error'] = 0;
					$response['msg'] = 'You have registered successfully. We have send you an verification email. Please verify it to login.';	
				}
				else {
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'Sorry some error occured. Please try again after some moment.. !!';		
				}
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = validation_errors(); 
			}
			
		} else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Please fill the form first';
		}
		echo json_encode($response);
		die();
	}
	
	public function customerlogin() {
		$post = $this->input->post();
		$this->form_validation->set_rules('loginusername', 'Username or Email', 'trim|required');
		$this->form_validation->set_rules('loginpassword', 'Password', 'trim|required');
		if($this->form_validation->run() == TRUE) {
			$isCheck = $this->user_model->customerlogin($post);
			if($isCheck) {
				$sessionarr = array(
									'id'=>$isCheck['id'],
									'fname'=>$isCheck['fname'],
									'lname'=>$isCheck['lname'],
									'username'=>$isCheck['username'],
									'email'=>$isCheck['email'],
									'image'=>base_url(USER_IMAGE_UPLOAD_URL.$isCheck['imagename']),
									'isLoggedIn' => 1
									);
				$this->session->set_userdata('customer',$sessionarr);
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = 'Welcome '.$isCheck['fname'];	
				$response['data'] = $isCheck;
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = 'Username or Password is incorrect';		
			}
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = validation_errors();
		}
		echo json_encode($response);
		die();
	}
	
	public function customerlogout() {
		$this->session->unset_userdata('customer');
		return true;
	}
	
	public function wishlist($productid) {
		if($this->session->userdata('customer')) {
			$sessiondata = $this->session->userdata('customer');
			$userid = $sessiondata['id'];
			$isWishlist = $this->user_model->wishlistproduct($productid, $userid);
			if($isWishlist) {
				$response['success'] = 1;
				$response['error'] = 0;
				$response['msg'] = $isWishlist['msg'];
				$response['type'] = $isWishlist['type'];
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = 'Sorry some error occured. Please try again after some moment.. !!';
			}
		}
		else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = 'Please Login to avail the Wishlist';	
		}
		echo json_encode($response);
	}
	
	public function mywishlist() {
		$sessiondata = $this->session->userdata('customer');
		if(!empty($sessiondata)) {
			$data = array();
			$userid = $sessiondata['id'];
			$data['sitedata'] = $this->user_model->sitedata();
			$data['cartdata'] = $this->cart->contents();
			$data['wishlist'] = $this->user_model->getwishlistbyuserid($userid);
			$this->load->view('frontend/header', $data);
			$this->load->view('frontend/mywishlist', $data);
			$this->load->view('frontend/footer', $data);
		}
		else {
			redirect(base_url());	
		}
	}
	
	public function mycart() {
		$data['sitedata'] = $this->user_model->sitedata();
		$data['cartdata'] = $this->cart->contents();
		//$data['wishlist'] = $this->user_model->getwishlistbyuserid($userid);
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/mycart', $data);
		$this->load->view('frontend/footer', $data);
	}
	
	public function cartfuncionality($productid) {
		$post = $this->input->post();
		foreach($post as $key=>$val) {
			$this->form_validation->set_rules($key, ucwords($key), 'trim|required');
		}
		if($this->form_validation->run() == TRUE) {
			$productdata = $this->user_model->getcompleteproductdatabyid($productid);
			if($productdata['data']['discountprice'] != '' && $productdata['data']['discountprice'] != 0) {
				$price = $productdata['data']['discountprice'];
			} else {
				$price = $productdata['data']['price'];
			}			
			$post['image'] = $productdata['image'][0]['image'];
			$post['slug'] = $productdata['data']['slug'];
			$cartdata = array(
			'id'      => $productid,
			'qty'     => 1,
			'price'   => $price,
			'name'    => $productdata['data']['title'],
			'options' => $post
			);
			$this->cart->insert($cartdata);	
			
			if($this->session->userdata('customer')) {
				$sessiondata = $this->session->userdata('customer');
				$userid = $sessiondata['id'];
				$this->user_model->insertcartindb($userid, $cartdata);
			}

			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'Product Successfully Added To Your Cart';
			$response['cartdata'] = $cartdata;
		} else {
			$response['success'] = 0;
			$response['error'] = 1;
			$response['msg'] = validation_errors();
		}		
		echo json_encode($response);
	}
	
	public function checkexistcartwishlist($id) {
		$cartdata = $this->cart->contents();
		$isCart = 0;
		foreach($cartdata as $key=>$val) {
			if($val['id'] == $id) {
				$isCart = 1;	
			}
		}
		$isWishlist = 0;
		$sessdata = $this->session->userdata('customer');
		if(!empty($sessdata) && isset($sessdata['id']) && $sessdata['id'] != '') {
			$checkwishlist = $this->user_model->checkwishlistwithuseridproductid($id, $sessdata['id']);
			if(!empty($checkwishlist)) {
				$isWishlist = 1;
			}
		}
		
		$data['isCart'] = $isCart;
		$data['isWishlist'] = $isWishlist;
		return $data;
	}
	
	public function removecartbyproductid($productid = '') {
		if($productid != '') {
			$cartdata = $this->cart->contents();
			foreach($cartdata as $key=>$val) {
				if($val['id'] == $productid) {
					$data = array(
						'rowid'   => $key,
						'qty'     => 0
					);
			
					$this->cart->update($data);	
				}
			}
			
			$response['success'] = 1;
			$response['error'] = 0;
			$response['msg'] = 'Product Successfully Removed From Your Cart';
			
			echo json_encode($response);
		}
	}
	
	public function feedback() {
		$post = $this->input->post();
		if(!empty($post)) {
			
		}
		else {
			$data['sitedata'] = $this->user_model->sitedata();
			$data['cartdata'] = $this->cart->contents();
			$this->load->view('frontend/header', $data);
			$this->load->view('frontend/feedback', $data);
			$this->load->view('frontend/footer', $data);
		}
	}
	
	public function aboutus() {
		$data['sitedata'] = $this->user_model->sitedata();
		$data['cartdata'] = $this->cart->contents();
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/aboutus', $data);
		$this->load->view('frontend/footer', $data);
	}
	
	public function updatecartquantity($pid, $qty) {
		$product = $this->user_model->getcompleteproductdatabyid($pid);
		if($product['data']['discountprice'] != '' && $product['data']['discountprice'] != 0) {
			$price = $product['data']['discountprice'];
		} else {
			$price = $product['data']['price'];
		}
		$newprice = doubleval($price) * intval($qty);
		$cartcontent = $this->cart->contents();
		foreach($cartcontent as $key=>$val) {
			if($val['id'] == $pid) {
				$rowid = $key;	
			}
		}		
		$data=array(
        		'rowid'=>$rowid,
            	'qty'=> $qty
            );
        $this->cart->update($data);
		
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Quantity successfully updated';
		$response['price'] = $newprice;
		
		echo json_encode($response);
	}
	
	public function checkout() {
		$post = $this->input->post();
		if(empty($post)) {
			$data['sitedata'] = $this->user_model->sitedata();
			$data['cartdata'] = $this->cart->contents();
			$this->load->view('frontend/header', $data);
			$this->load->view('frontend/checkout', $data);
			$this->load->view('frontend/footer', $data);
		} else {			
			$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lname', 'Last name', 'trim|required');
			$this->form_validation->set_rules('address1', 'Street Address', 'trim|required');
			$this->form_validation->set_rules('state', 'State', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('zip', 'Zip', 'trim|required');
			$this->form_validation->set_rules('county', 'County', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('landmark', 'Landmark', 'trim|required');
			$this->form_validation->set_rules('paymentmethod', 'Payment Method', 'trim|required');
			if(isset($post['createaccount']) && $post['createaccount'] == 1) {
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
			}
			
			if($this->form_validation->run() == TRUE) {
				$fname = $post['fname'];
				$lname = $post['lname'];
				$address1 = $post['address1'];
				$address2 = $post['address2'];
				$state = $post['state'];
				$city = $post['city'];
				$zip = $post['zip'];
				$county = $post['county'];
				$email = $post['email'];
				$phone = $post['phone'];
				$landmark = $post['landmark'];
				$label = $post['label'];
				if(isset($post['createaccount'])) { $createaccount = 1; } else { $createaccount = 0; }
				if(isset($post['createaccount'])) { $password = md5($post['password']); } else { $password = ''; }
				$note = $post['note'];
				$paymentmethod = $post['paymentmethod'];
				
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
				if($this->form_validation->run() == TRUE) { 
					
					if($createaccount == 1) { //user registering
						$registerdata['fname'] = $fname;
						$registerdata['lname'] = $lname;
						$registerdata['username'] = $fname.time();
						$registerdata['email'] = $email;
						$registerdata['password'] = $password;
						$registerdata['fname'] = $fname;
						
						$isRegister = $this->user_model->insertregisterdatareturn($registerdata);
						if($isRegister) { $userid = $isRegister; $flying = 0; }
						else {
							$response['success'] = 0;
							$response['error'] = 1;
							$response['msg'] = 'Sorry some error occured while registering please try again after few momentes';
							echo json_encode($response);
							die();
						}
						
					}
					elseif(!empty($this->session->userdata('customer'))) {
						$sess = $this->session->userdata('customer');
						$userid = $sess['id']; $flying = 0;
					}
					else {
						$userid = time(); $flying = 1;	
					}
					
					$address['userid'] = $userid;
					$address['country'] = $county;
					$address['fname'] = $fname;
					$address['lname'] = $lname;
					$address['address1'] = $address1;
					$address['address2'] = $address2;
					$address['city'] = $city;
					$address['state'] = $state;
					$address['zip'] = $zip;
					$address['email'] = $email;
					$address['phone'] = $phone;
					$address['label'] = $label;
					$address['landmark'] = $landmark;
					$address['flying'] = $flying;
					
					$addressID = $this->user_model->insertaddress($address);
					
					$cartcontent = $this->cart->contents();
					foreach($cartcontent as $key=>$val) {
						$orderid = 'ORHMWL'.time();
						$orderdata['orderid'] = $orderid;
						$orderdata['productid'] = $val['id'];
						$orderdata['userid'] = $userid;
						$orderdata['name'] = $val['name'];
						$orderdata['image'] = $val['options']['image'];
						$attrarr = array();
						foreach($val['options'] as $optionkey=>$optionval) {
							if($optionkey != 'image' && $optionkey != 'slug') {
								$attrarr[$optionkey] = $optionval;	
							}
						}
						
						$productdata = $this->user_model->getcompleteproductdatabyid($val['id']);
												
						$orderdata['attribute'] = json_encode($attrarr);
						$orderdata['orgprice'] = $productdata['data']['price'];
						$orderdata['slug'] = $val['options']['slug'];
						if($productdata['data']['discountprice'] != 0) {
							$orderdata['soldprice'] = $productdata['data']['discountprice'];
						} else {
							$orderdata['soldprice'] = $productdata['data']['discountprice'];
						}
						$orderdata['coupon'] = '';
						$orderdata['paymentmethod'] = $paymentmethod;
						$orderdata['paymentstatus'] = 0;
						$orderdata['orderstatus'] = 0;
						$orderdata['address'] = $addressID;	
						$orderdata['note'] = $note;
						
						$orderID = $this->user_model->insertorder($orderdata);
					
						$response['success'] = 1;
						$response['error'] = 0;
						$response['orderid'] = $orderid;
					}
				}
				else {					
					$response['success'] = 0;
					$response['error'] = 1;
					$response['msg'] = 'An account already exist with this email. Please log back in or try with a different email.';					
				}
			}
			else {
				$response['success'] = 0;
				$response['error'] = 1;
				$response['msg'] = validation_errors();
			}
			echo json_encode($response);
		}
	}
	
	public function confirmorder($orderid) {
		$data['orderdata'] = $this->user_model->getorderdata($orderid);
		$data['sitedata'] = $this->user_model->sitedata();
		$data['cartdata'] = $this->cart->contents();

		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/confirmorder', $data);
		$this->load->view('frontend/footer', $data);
	} 
	
	public function productcategory($category='', $categoryid=0) {
		if($categoryid == 0) {
			redirect(base_url());	
		}
		
		$productdetails = $this->user_model->getproductsbycategoryid($categoryid);
	}
	
	public function blog() {
		$data = array();
		$data['banner'] = $this->db->get_where('bannermanagement', array('page'=>2))->result_array();
		$data['category'] = $this->db->get_where('blogcategory', array('status'=>1))->result_array();
		$blog = $this->db->get_where('blogmanagement', array('status'=>1))->result_array();
		foreach($blog as $key=>$val) {
			$category = $this->db->get_where('blogcategory', array('id'=>$val['category']))->row_array();
			$blog[$key]['categoryname'] = $category['titleen'];	
		}
		$data['blog'] = $blog;
		$data['seo'] = getseobypageid(2);
		$this->load->view('frontend/innerheader', $data);
		$this->load->view('frontend/blog', $data);
		$this->load->view('frontend/footer', $data);
	}
	
	public function blogdetails($name='', $id='') {
		if($id != '' && $name != '') {
			$data['data'] = $this->db->get_where('blogmanagement', array('id'=>$id))->row_array();	
			$data['seo'] = getseobypageid(3);
			$this->load->view('frontend/innerheader', $data);
			$this->load->view('frontend/blogdetails', $data);
			$this->load->view('frontend/footer', $data);		
		}
	}
	
	public function seomanagement($pageid='') {
        if($pageid == '') { redirect(base_url()); }
        
        $post = $this->input->post();
        if(empty($post)) {
            $data = array();
            $this->load->view('frontend/innerheader', $data);
		    $this->load->view('frontend/seomanagement', $data);
		    $this->load->view('frontend/footer', $data);
        } else {
            print_r($post); die();
        }
    }
    
    public function project() {
		$data['ongoing'] = $this->db->get_where('projectmanagement', array('status'=>1, 'type'=>0))->result_array();
		$data['complete'] = $this->db->get_where('projectmanagement', array('status'=>1, 'type'=>1))->result_array();	
		$data['data'] = $this->db->get('projectpage')->row_array();
		
		$data['seo'] = getseobypageid(4);
		
		$this->load->view('frontend/innerheader', $data);
		$this->load->view('frontend/project', $data);
		$this->load->view('frontend/footer', $data);	
	}
	
	public function newsletter() {
		$post = $this->input->post();
		$email = $post['email'];
		
		$insertarr['email'] = $email;
		$insertarr['datetime'] = date('Y-m-d h:i:s');
		
		$this->db->insert('newsletter', $insertarr);
		
		$response['success'] = 1;
		$response['error'] = 0;
		$response['msg'] = 'Successfully Registerd..!!';

		echo json_encode($response);
			
	}
}
