<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Plan_model extends CI_Model {

	public function planmanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('planmanagement', $insertdata);
		}
		return true;
	}
	
	public function planmanagementfetchdata() {
		$data = $this->db->get('planmanagement')->result_array();
		return $data;
	}
	
	public function planmanagementfetchdatabyid($id) {
		$data = $this->db->get_where('planmanagement', array('id'=>$id))->row_array();
		return $data;
	}
	
	public function planmanagementupdate($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('planmanagement', $data);
		return true;
	}
	
	public function planmanagementchangestatus($id) {
		$checkstatus = $this->db->get_where('planmanagement', array('id'=>$id))->row_array();
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
		
		$this->db->where('id',$id);
		$this->db->update('planmanagement', array('status'=>$newstatus));
		
		return $newclass;		
	}
	
	public function planmanagementdelete($id) {
		$this->db->where(array('id'=>$id));
		$this->db->delete('planmanagement');
		return true;
	}
	
}