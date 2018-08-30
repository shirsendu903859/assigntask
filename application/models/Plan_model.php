<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Plan_model extends CI_Model {

	public function bannermanagementinsert($insertdata) {
		if(!empty($insertdata)) {
			$this->db->insert('bannermanagement', $insertdata);
		}
		return true;
	}
	
	public function planmanagementfetchdata() {
		$data = $this->db->get('planmanagement')->result_array();
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
	
}