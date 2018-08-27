<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	public function sendmsg($data) {
		$this->db->insert('chat', $data);
		return true;
	}
	
	public function getchat($sender, $reciever) {
		
		$this->db->select('*');
		$this->db->where(array('sender'=>$sender, 'reciever'=>$reciever));
		$this->db->or_where(array('sender'=>$reciever, 'reciever'=>$sender));
		$this->db->from('chat');
		$query = $this->db->get();
		$data = $query->result_array();
		
		/*$sendchat = $this->db->get_where('chat', array('sender'=>$sender, 'reciever'=>$reciever))->result_array();
		$recievechat = $this->db->get_where('chat', array('sender'=>$reciever, 'reciever'=>$sender))->result_array();
		
		$data = array_merge($sendchat, $recievechat);*/
		return $data;
	}
	
	public function gethomeactivebanner() {
		$data = $this->db->get_where('bannermanagement', array('status'=>1))->result_array();
		return $data;
	}
	
	public function getactiveparentcategory() {
		$data = $this->db->get_where('categorymanagement', array('status'=>1, 'parent'=>0))->result_array();
		return $data;
	}
	
	public function getcompleteproductdatabyid($id) {
		$product = $this->db->get_where('productmanagement', array('productid'=>$id))->row_array();
		if(!empty($product)) {
			$category = $this->db->get_where('categorymanagement', array('id'=>$product['category']))->row_array();
			$product['categoryname'] = $category['title'];
			$data['data'] = $product;
			
			$image = $this->db->get_where('productimagemanagement', array('productid'=>$id))->result_array();
			foreach($image as $key=>$val) {
				$image[$key]['image'] = base_url().PRODUCT_UPLOAD_URL.$val['image'];	
			}	
			$data['image'] = $image;
			
			$productattribute = $this->db->get_where('productattributemanagement', array('productid'=>$id))->result_array();
			foreach($productattribute as $key=>$val) {
				$getattrdata[] = $this->db->get_where('attributemanagement', array('id'=>$val['attribute']))->row_array();	
			}
			foreach($getattrdata as $key=>$val) {
				if($val['parent'] == 0) {
					$parent[] = $val;
				}
				else {
					$child[] = $val;	
				}
			}
			foreach($parent as $key=>$val) {
				$attribute[$key]['data'] = $val;
				foreach($child as $innerkey=>$innerval) {
					if($innerval['parent'] == $val['id']) {
						$attribute[$key]['child'][] = $innerval;
					}
				}
			}			
			$data['attribute'] = $attribute;
						
			$data['hierarchy'] = $this->getparentcategorydata($product['category']);

			return $data;
		}
		else {
			redirect(base_url());	
		}
	}
	
	public function getparentcategorydata($parentid) {
		$parentdata = array();
		$data = $this->getparentsql($parentid);
		if($data['parent'] == 0) {
			$parentdata[] = $data;
		}
		else {
			$parentdata[] = $data;
			$data = $this->getparentsql($data['parent']);
			if($data['parent'] == 0) {
				$parentdata[] = $data;
			}
			else {
				$parentdata[] = $data;
				$data = $this->getparentsql($data['parent']);
				if($data['parent'] == 0) {
					$parentdata[] = $data;
				}
				else {
					$parentdata[] = $data;
					$data = $this->getparentsql($data['parent']);
					if($data['parent'] == 0) {
						$parentdata[] = $data;
					}
					else {
						$parentdata[] = $data;
						$data = $this->getparentsql($data['parent']);
					}
				}
			}
		}
		return $parentdata;
	}
	
	public function getparentsql($parentid) {
		$data = $this->db->get_where('categorymanagement', array('id'=>$parentid))->row_array();
		return $data;
	}
	
	public function insertreview($data) {
		$data['userid'] = '';
		$session = $this->session->userdata('customer');
		if(!empty($session)) {
			$data['userid'] = $session['id'];
		}
		$data['datetime'] = date('Y-m-d h:i:s');
		$this->db->insert('reviewmanagement', $data);
		return true;
	}
	
	public function insertregisterdata($data) {
		$this->db->insert('users', $data);
		return true;	
	}
	
	public function insertregisterdatareturn($data) {
		$this->db->insert('users', $data);
		return $this->db->insert_id();	
	}
	
	public function customerlogin($data) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $data['loginusername']);
		$this->db->or_where('username', $data['loginusername']);
		$this->db->where('password', md5($data['loginpassword']));
		$return = $this->db->get()->row_array();
		
		if(empty($return)) {
			return false;
		} else {
			return $return; 
		}
	}
	
	public function getreviewbyproductid($id) {
		$review = $this->db->get_where('reviewmanagement', array('productid'=>$id, 'status'=>1))->result_array();
		foreach($review as $key=>$val) {
			if($val['userid'] != '' && $val['userid'] != 0) {
				$user = $this->db->get_where('users', array('id'=>$val['userid']))->row_array();
				if(isset($user['imagename']) && $user['imagename'] != '') {
					$review[$key]['userimage'] = base_url().USER_IMAGE_UPLOAD_URL.$user['imagename'];	
				} else {
					$review[$key]['userimage'] = base_url('assets/images/nouserimage.jpg');
				}
			} else {
				$review[$key]['userimage'] = base_url('assets/images/nouserimage.jpg');	
			}
		}
		return $review;		
	}
	
	public function wishlistproduct($productid, $userid) {
		$check = $this->db->get_where('wishlist', array('productid'=>$productid, 'userid'=>$userid))->row_array();
		if(empty($check)) {
			$insert = array(
							'productid'=>$productid,
							'userid'=>$userid,
							'datetime'=>date('Y-m-d h:i:s')
							);	
			$this->db->insert('wishlist', $insert);
			$data['msg'] = 'Product Successfully Added to your wishlist';
			$data['type'] = 1;
		}
		else {
			$this->db->where(array('productid'=>$productid, 'userid'=>$userid));
			$this->db->delete('wishlist');	
			$data['msg'] = 'Product Successfully Removed from your wishlist';
			$data['type'] = 0;
		}
		return $data;
	}
	
	public function getwishlistbyuserid($userid) {
		$wishlist = $this->db->get_where('wishlist', array('userid'=>$userid))->result_array();
		if(empty($wishlist)) {
			return array();
		}
		else {
			foreach($wishlist as $key=>$val) {
				$productid = $val['productid'];
				$data[$key]['wishlist'] = $val;
				  $data[$key]['product'] = $this->getcompleteproductdatabyid($productid);
			}
			return $data;
		}
	}
	
	public function insertcartindb($userid, $cartdata) {
		$insertarray = array(
							 'userid'=>$userid,
							 'productid'=>$cartdata['id'],
							 'cartjson'=>json_encode($cartdata)
							 );	
		$this->db->insert('usercart', $insertarray);
		return true;
	}
	
	public function sitedata() {
		$data = $this->db->get('sitemanagement')->row_array();
		return $data;
	}
	
	public function checkwishlistwithuseridproductid($productid, $userid) {
		$data = $this->db->get_where('wishlist', array('productid'=>$productid, 'userid'=>$userid))->row_array();
		return $data;
	}
	
	public function homeproduct() {
		$homeproduct = $this->db->get_where('productmanagement', array('isHome'=>1))->result_array();
		foreach($homeproduct as $key=>$val) {
			$productid = $val['productid'];
			$returndata[] = $this->getcompleteproductdatabyid($productid);
		}
		return $returndata;
	}
	
	public function insertaddress($address) {
		$this->db->insert('useraddress', $address);
		return $this->db->insert_id();
	}
	
	public function insertorder($orderdata) {
		$this->db->insert('order', $orderdata);
		return $this->db->insert_id();
	}
	
	public function getorderdata($orderid) {
		$data['order'] = $order = $this->db->get_where('order', array('orderid'=>$orderid))->result_array();
		if(!empty($order)) {
			$data['address'] = $address = $this->db->get_where('useraddress', array('id'=>$order[0]['address']))->row_array();
			return $data;
		}
		else {
			redirect(base_url());
		}
	}
	
	public function getproductsbycategoryid($categoryid) {
		$childcategories = $this->db->get_where('categorymanagement', array('parent'=>$categoryid))->result_array();
		if(!empty($childcategories)) {
			foreach($childcategories as $childkey=>$childval) {
				$childcategoryarr[] = $childval['id'];	
			}
			$arr[0] = $categoryid;
			$allcategoryid = array_merge($childcategoryarr, $arr);
		}
		else {
			$allcategoryid[0] = $categoryid;
		}
		
		//products = $this->db->get_where('productmanagement', array('category'=>))->result_array();
	}
	
}