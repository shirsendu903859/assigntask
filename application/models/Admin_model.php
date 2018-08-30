<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Admin_model extends CI_Model {

	public function adminlogin($data) {
		if(!empty($data)) {
			$check = $this->db->get_where('admin', array('username'=>$data['email']))->row_array();
			return $check;
		}
	}
	
	public function loginTimeUpdate($id) {
		$data = array('lastlogin'=>date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		$this->db->update('admin', $data);
		
		$returndata = $this->db->get_where('admin', array('id'=>$id))->row_array();
		
		return $returndata;	
	}
	
	public function logomanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('logomanagement', $insertdata);
		}
		return true;
	}
	
	public function logomanagementfetchdata() {
		$data = $this->db->get('logomanagement')->result_array();
		return $data;
	}
	
	public function logomanagementfetchdatabyid($logoid) {
		$data = $this->db->get_where('logomanagement', array('id'=>$logoid))->row_array();
		return $data;
	}
	
	public function logomanagementupdate($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('logomanagement', $data);
		return true;
	}
	
	public function logomanagementchangestatus($logoid) {
		$checkstatus = $this->db->get_where('logomanagement', array('id'=>$logoid))->row_array();
		$currentstatus = $checkstatus['status'];
		if($currentstatus == 1) { 
			$newstatus = 0; $newclass = 0;
			
			$this->db->where('id',$logoid);
			$this->db->update('logomanagement', array('status'=>$newstatus));
		}
		if($currentstatus == 0) { 
			$newstatus = 1; $newclass = 1; 
			
			$this->db->update('logomanagement', array('status'=>$currentstatus));
			
			$this->db->where('id',$logoid);
			$this->db->update('logomanagement', array('status'=>$newstatus));
		}
		
		return $newclass;		
	}
	
	public function logomanagementdelete($logoid) {
		$this->db->where(array('id'=>$logoid));
		$this->db->delete('logomanagement');
		return true;
	}
	
	public function usermanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('users', $insertdata);
		}
		return true;
	}
	
	public function vehiclemanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('vehicletype', $insertdata);
		}
		return true;
	}
	
	public function faremanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('faremanagement', $insertdata);
		}
		return true;
	}
	
	public function getalluserdata() {
		$data = $this->db->get('users')->result_array();
		return $data;
	}
	
	public function changeuserstatus($userid) {
		if($userid != '') {
			$currentstatus = $this->db->get_where('users', array('id'=>$userid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $userid);
			$this->db->update('users', $data);
			return $newstatus;
		}
	}
	
	public function changevehiclestatus($vehicleid) {
		if($vehicleid != '') {
			$currentstatus = $this->db->get_where('vehicletype', array('id'=>$vehicleid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $vehicleid);
			$this->db->update('vehicletype', $data);
			return $newstatus;
		}
	}
	
	public function changefarestatus($id) {
		if($id != '') {
			$currentstatus = $this->db->get_where('faremanagement', array('id'=>$id))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $id);
			$this->db->update('faremanagement', $data);
			return $newstatus;
		}
	}
	
	public function deleteuser($userid) {
		if($userid != '') {
			$this->db->where('id', $userid);
			$this->db->delete('users');
			return true;
		}
	}
	
	public function deletevehicle($vehicleid) {
		if($vehicleid != '') {
			$this->db->where('id', $vehicleid);
			$this->db->delete('vehicletype');
			return true;
		}
	}
	
	public function deletefare($id) {
		if($id != '') {
			$this->db->where('id', $id);
			$this->db->delete('faremanagement');
			return true;
		}
	}
	
	public function getuserdatabyid($userid) {
		if($userid != '') {
			$data = $this->db->get_where('users', array('id'=>$userid))->row_array();
			return $data;
		}	
	}
	
	public function getvehicledatabyid($vehicleid) {
		if($vehicleid != '') {
			$data = $this->db->get_where('vehicletype', array('id'=>$vehicleid))->row_array();
			return $data;
		}	
	}
	
	public function getfaredatabyid($id) {
		if($id != '') {
			$data = $this->db->get_where('faremanagement', array('id'=>$id))->row_array();
			return $data;
		}	
	}
	
	public function updateuserdetails($data, $userid) {
		if(isset($data['imagename']) && $data['imagename'] == '') {
			$existdata = $this->db->get_where('users', array('id'=>$userid))->row_array();
			$data['imagename'] = $existdata['imagename'];
		}
		
		$this->db->where('id', $userid);
		$this->db->update('users', $data);
		return true;
	}
	
	public function updatevehicledetails($data, $userid) {
		if(isset($data['imagename']) && $data['imagename'] == '') {
			$existdata = $this->db->get_where('users', array('id'=>$userid))->row_array();
			$data['imagename'] = $existdata['imagename'];
		}
		
		$this->db->where('id', $userid);
		$this->db->update('vehicletype', $data);
		return true;
	}
	
	public function updatefaredetails($data, $userid) {
		if(isset($data['imagename']) && $data['imagename'] == '') {
			$existdata = $this->db->get_where('users', array('id'=>$userid))->row_array();
			$data['imagename'] = $existdata['imagename'];
		}
		
		$this->db->where('id', $userid);
		$this->db->update('faremanagement', $data);
		return true;
	}
	
	/*for blog part start*/
	public function blogmanagementinsert($data) {
		if(!empty($data)) {
			$this->db->insert('blogmanagement', $data);	
		}
		return true;
	}
	
	public function getallblogdata() {
		$data = $this->db->get('blogmanagement')->result_array();
		return $data;
	}
	
	public function getblogimagebyid($blogid) {
		if($blogid != '') {
			$data = $this->db->get_where('blogmanagement', array('id'=>$blogid))->row_array();
			$imagenamestr = $data['imagename'];
			$imagenamearr = explode(STRING_DELIMETER,$imagenamestr);
			$imagearr = array();
			foreach($imagenamearr as $key=>$val) {
				$imagearr[] = base_url().BLOG_IMAGE_UPLOAD_URL.$val;
			}
			return $imagearr;
		}
	}
	
	public function getblogdescriptionbyid($blogid) {
		if($blogid != '') {
			$data = $this->db->get_where('blogmanagement', array('id'=>$blogid))->row_array();
			if(!empty($data)) {
				return $data['description'];
			}
			else { 
				return false;
			}
		}
	}
	
	public function updateblogdetails($data, $id) {
				
		$this->db->where('id', $id);
		$this->db->update('blogmanagement', $data);
		return true;
	}
	
	public function changeblogstatus($blogid) {
		if($blogid != '') {
			$currentstatus = $this->db->get_where('blogmanagement', array('id'=>$blogid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $blogid);
			$this->db->update('blogmanagement', $data);
			return $newstatus;
		}
	}
	
	public function deleteblog($blogid) {
		if($blogid != '') {
			$this->db->where('id', $blogid);
			$this->db->delete('blogmanagement');
			return true;
		}
	}
	
	public function getblogdatabyid($blogid) {
		$data = $this->db->get_where('blogmanagement', array('id'=>$blogid))->row_array();
		$imagename = explode(STRING_DELIMETER, $data['imagename']);
		$data['imagename'] = $imagename;
		$imageurl = $this->getblogimagebyid($blogid);
		$data['imageurl'] = $imageurl;
		return $data;
	}
	/*for blog part end*/
	
	/*for service part start*/
	public function servicemanagementinsert($data) {
		if(!empty($data)) {
			$this->db->insert('servicemanagement', $data);	
		}
		return $this->db->insert_id();
	}
	
	public function serviceimagemanagementinsert($data) {
		if(!empty($data)) {
			$this->db->insert('serviceimage', $data);	
		}
		return true;
	}
	
	public function subservicemanagementinsert($data) {
		if(!empty($data)) {
			$this->db->insert('subservicemanagement', $data);	
		}
		return true;
	}
	
	public function getallsubservicedata() {
		$data = $this->db->get('subservicemanagement')->result_array();
		return $data;
	}
	
	public function getallservicedata() {
		$data = $this->db->get('servicemanagement')->result_array();
		foreach($data as $key=>$val) {
			$image = $this->db->get_where('serviceimage', array('serviceid'=>$val['id']))->row_array();
			$data[$key]['image'] = $image;
		}
		return $data;
	}
	
	public function getserviceimagebyid($serviceid) {
		if($serviceid != '') {
			$data = $this->db->get_where('servicemanagement', array('id'=>$serviceid))->row_array();
			$imagenamestr = $data['imagename'];
			$imagenamearr = explode(STRING_DELIMETER,$imagenamestr);
			$imagearr = array();
			foreach($imagenamearr as $key=>$val) {
				$imagearr[] = base_url().SERVICE_IMAGE_UPLOAD_URL.$val;
			}
			return $imagearr;
		}
	}
	
	public function getservicedescriptionbyid($serviceid) {
		if($serviceid != '') {
			$data = $this->db->get_where('servicemanagement', array('id'=>$serviceid))->row_array();
			if(!empty($data)) {
				return $data['description'];
			}
			else { 
				return false;
			}
		}
	}
	
	public function updateservicedetails($data, $id) {
				
		$this->db->where('id', $id);
		$this->db->update('servicemanagement', $data);
		return true;
	}
	
	public function updatesubservicedetails($data, $id) {
				
		$this->db->where('id', $id);
		$this->db->update('subservicemanagement', $data);
		return true;
	}
	
	public function changeservicestatus($serviceid) {
		if($serviceid != '') {
			$currentstatus = $this->db->get_where('servicemanagement', array('id'=>$serviceid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $serviceid);
			$this->db->update('servicemanagement', $data);
			return $newstatus;
		}
	}

	public function changesubservicestatus($serviceid) {
		if($serviceid != '') {
			$currentstatus = $this->db->get_where('subservicemanagement', array('id'=>$serviceid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $serviceid);
			$this->db->update('subservicemanagement', $data);
			return $newstatus;
		}
	}
	
	public function changeofferstatus($serviceid) {
		if($serviceid != '') {
			$currentstatus = $this->db->get_where('offer', array('id'=>$serviceid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $serviceid);
			$this->db->update('offer', $data);
			return $newstatus;
		}
	}
	
	public function deleteservice($id) {
		if($id != '') {
			$this->db->where('id', $id);
			$this->db->delete('servicemanagement');
			
			$this->db->where('serviceid', $id);
			$this->db->delete('serviceimage');
			return true;
		}
	}

	public function deletesubservice($id) {
		if($id != '') {
			$this->db->where('id', $id);
			$this->db->delete('subservicemanagement');
			return true;
		}
	}
	
	public function getservicedatabyid($id) {
		$data = $this->db->get_where('servicemanagement', array('id'=>$id))->row_array();
		$imagedata = $this->db->get_where('serviceimage', array('serviceid'=>$id))->row_array();
		$data['blueimage'] = ASSETS_URL.SERVICE_UPLOAD_URL.$imagedata['blueimagename'];
		$data['blackimage'] = ASSETS_URL.SERVICE_UPLOAD_URL.$imagedata['blackimagename'];
		
		return $data;
	}
	
	public function getsubservicedatabyid($id) {
		$data = $this->db->get_where('subservicemanagement', array('id'=>$id))->row_array();		
		return $data;
	}
	/*for service part end*/
	
	public function getadmindetail() {
		$data = $this->db->get('admin')->row_array();
		return $data;
	}
	
	public function updateadmindata($data) {
		$this->db->update('admin', $data);
		return true;
	}
	
	public function getsitemanagementdetail() {
		$data = $this->db->get('sitemanagement')->row_array();
		return $data;
	}
	
	public function getaboutmanagementdetail() {
		$data = $this->db->get('aboutmanagement')->row_array();
		return $data;
	}
	
	public function getprivacypolicymanagementdetail() {
		$data = $this->db->get('privacypolicymanagement')->row_array();
		return $data;
	}
	
	public function updatesitemanagementdata($data) {
		$this->db->update('sitemanagement', $data);
		return true;
	}
	
	public function updateaboutmanagementdata($data) {
		$this->db->update('aboutmanagement', $data);
		return true;
	}
	
	public function updatetermsconditionsmanagementdata($data) {
		$this->db->update('termsconditions', $data);
		return true;
	}
	
	public function updateprivacypolicymanagementdata($data) {
		$this->db->update('privacypolicymanagement', $data);
		return true;
	}
	
	public function getcategorymanagementdetail() {
		$data = $this->db->get('categorymanagement')->result_array();
		return $data;
	}
	
	public function insertcategorymanagement($data) {
		if(!empty($data)) {
			$this->db->insert('categorymanagement', $data);	
		}
		return true;
	}
	
	public function changecategorystatus($categoryid) {
		if($categoryid != '') {
			$currentstatus = $this->db->get_where('categorymanagement', array('id'=>$categoryid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $categoryid);
			$this->db->update('categorymanagement', $data);
			return $newstatus;
		}
	}
	
	public function getcategorybyid($catid) {
		$data = $this->db->get_where('categorymanagement', array('id'=>$catid))->row_array();
		return $data;
	}
	
	public function updatecategorybyid($data) {
		$categoryid = $data['categoryid'];
		unset($data['categoryid']);
		unset($data['tag']);
	
		$this->db->where('id', $categoryid);
		$this->db->update('categorymanagement', $data);
		
		return true;
	}
		
	public function getattributemanagementdetail() {
		$data = $this->db->get('attributemanagement')->result_array();
		return $data;
	}
	
	public function insertattributemanagement($data) {
		if(!empty($data)) {
			$this->db->insert('attributemanagement', $data);	
		}
		return true;
	}
	
	public function changeattributestatus($attributeid) {
		if($attributeid != '') {
			$currentstatus = $this->db->get_where('attributemanagement', array('id'=>$attributeid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $attributeid);
			$this->db->update('attributemanagement', $data);
			return $newstatus;
		}
	}
	
	public function getattributeid($attributeid) {
		$data = $this->db->get_where('attributemanagement', array('id'=>$attributeid))->row_array();
		return $data;
	}
	
	public function updateattributebyid($data) {
		$attributeid = $data['attributeid'];
		unset($data['attributeid']);
		unset($data['tag']);
	
		$this->db->where('id', $attributeid);
		$this->db->update('attributemanagement', $data);
		
		return true;
	}
	
	public function getparentattributemanagementdetail() {
		$data = $this->db->get_where('attributemanagement', array('parent'=>0))->result_array();
		return $data;
	}
	
	public function getchildattribute($attributeid) {
		$data = $this->db->get_where('attributemanagement', array('parent'=>$attributeid))->result_array();
		return $data;
	}
	
	public function insertproductdata($productarray, $productimagearray, $productattributearray) {
		if(!empty($productarray)) {
			$this->db->insert('productmanagement', $productarray);	
		}
		if(!empty($productimagearray)) {
			$this->db->insert_batch('productimagemanagement', $productimagearray);	
		}
		if(!empty($productattributearray)) {
			$this->db->insert_batch('productattributemanagement', $productattributearray);	
		}
		
		return true;
	}

	public function bannermanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('bannermanagement', $insertdata);
		}
		return true;
	}
	
	public function bannermanagementfetchdata() {
		$data = $this->db->get('bannermanagement')->result_array();
		return $data;
	}
	
	public function bannermanagementfetchdatabyid($bannerid) {
		$data = $this->db->get_where('bannermanagement', array('id'=>$bannerid))->row_array();
		return $data;
	}
	
	public function bannermanagementupdate($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('bannermanagement', $data);
		return true;
	}
	
	public function bannermanagementchangestatus($bannerid) {
		$checkstatus = $this->db->get_where('bannermanagement', array('id'=>$bannerid))->row_array();
		$currentstatus = $checkstatus['status'];
		/*if($currentstatus == 1) { 
			$newstatus = 0; $newclass = 0;
			
			$this->db->where('id',$bannerid);
			$this->db->update('bannermanagement', array('status'=>$newstatus));
		}
		if($currentstatus == 0) { 
			$newstatus = 1; $newclass = 1; 
			
			//$this->db->update('bannermanagement', array('status'=>$currentstatus));
			
			$this->db->where('id',$bannerid);
			$this->db->update('bannermanagement', array('status'=>$newstatus));
		}*/
		
		if($currentstatus == 1) { $newstatus = 0; $newclass = 0; }
		if($currentstatus == 0) { $newstatus = 1; $newclass = 1; }
		
		$this->db->where('id',$bannerid);
		$this->db->update('bannermanagement', array('status'=>$newstatus));
		
		return $newclass;		
	}
	
	public function bannermanagementdelete($bannerid) {
		$this->db->where(array('id'=>$bannerid));
		$this->db->delete('bannermanagement');
		return true;
	}
	
	public function insertfiledata($userid, $imagedata, $previousimagename) {
		foreach($imagedata as $key=>$val) {
			$insertarr = array(
						   	'userid' => $userid,
							'encryptname' => $val,
							'actualname' => $previousimagename[$key],
							'userid' => $userid,
						   );
			$this->db->insert('filedata', $insertarr);
		}
		return true;
	}
	
	public function getfiledatabyuserid($uid) {
		$data = $this->db->get_where('filedata', array('userid'=>$uid, 'status'=>1))->result_array();
		return $data;
	}
	
	public function allpagelist() {
		$data = $this->db->get_where('pages', array('status'=>1))->result_array();
		return $data;
	}
	
	public function insertquery($insertdata, $tablename) {
		if(!empty($insertdata)) {
			$this->db->insert($tablename, $insertdata);
		}
		return true;
	}
	
	public function selectqueryall($tablename) {
		$data = $this->db->get($tablename)->result_array();	
		return $data;
	}
	
	public function changestatus($id, $tablename) {
		if($id != '') {
			$currentstatus = $this->db->get_where($tablename, array('id'=>$id))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $id);
			$this->db->update($tablename, $data);
			return $newstatus;
		}
	}
	
	public function selectquerybyid($id, $tablename) {
		$data = $this->db->get_where($tablename, array('id'=>$id))->row_array();
		return $data;
	}
	
	public function selectqueryactive($tablename) {
		$data = $this->db->get_where($tablename, array('status'=>1))->result_array();
		return $data;
	}
	
	
	public function updatequery($array, $id, $tablename) {
		$this->db->where('id',$id);
		$this->db->update($tablename, $array);
		
		return true;
	}
	
	public function deletequery($id, $tablename) {
		$this->db->where('id', $id);
		$this->db->delete($tablename);	
		return true;
	}
	
	public function changeprojectstatus($serviceid) {
		if($serviceid != '') {
			$currentstatus = $this->db->get_where('projectmanagement', array('id'=>$serviceid))->row_array();
			if($currentstatus['status'] == 1) { $newstatus = 0; }
			if($currentstatus['status'] == 0) { $newstatus = 1; }
			$data = array('status'=>$newstatus);
			$this->db->where('id', $serviceid);
			$this->db->update('projectmanagement', $data);
			return $newstatus;
		}
	}
}