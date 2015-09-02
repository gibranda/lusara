<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Data_model extends CI_Model
{
	var $tblName;
	function __construct($table = null){
		parent::__construct();
		$this->tblName = $table;
	}

	function get_all($data = null){
		if(isset($data['select'])){
			$this->db->select($data['select']);
		}

		$this->db->from($this->tblName);

		if(isset($data['join'])){
			foreach ($data['join'] as $key => $value) {
				$this->db->join($data['join'][$key][0],$data['join'][$key][1], $data['join'][$key][2]);
			}
		}

		if(isset($data['where'])){
			$this->db->where($data['where']);
		}

		if(isset($data['order_by'])){
			foreach ($data['order_by'] as $key => $value) {
				$this->db->order_by($key,$value);
			}
		}

		if(isset($data['limit'])){
			$this->db->limit($data['limit']);
		}

		return $this->db->get()->result();
	}

	function get_details($where){
		$this->db->where($where);
		$this->db->from($this->tblName);
		$this->db->limit(1);
		$query = $this->db->get()->result();;
		return $query;
	}

	function verifying_maxid($subject){
		$this->db->select_max($subject);
		$result = $this->db->get($this->tblName)->result();
		return $result[0]->$subject;
	}

	function inserting($data, $datetime = false){
		if(isset($data['action_key'])){
			unset($data['action_key']);
		}
		if($datetime == true){
			$data['created_at'] = date('Y-m-d H:i:s');
		}		
		$this->db->insert($this->tblName,$data);
		return $this->db->insert_id();
	}

	function updating($data = array(), $id = array(), $datetime = false){
		if(isset($data['action_key'])){
			unset($data['action_key']);
		}

		if($datetime == true){
			$data['updated_at'] = date('Y-m-d H:i:s');
		}
		return $this->db->update($this->tblName, $data, $id);
	}

	function soft_deleting($id = array(), $data = array()){
		if(isset($data['action_key'])){
			unset($data['action_key']);
		}
		$data['deleted_at'] = date('Y-m-d H:i:s');
		return $this->db->update($this->tblName, $data, $id);
	}

	function real_deleting($id = array()){
		return $this->db->delete($this->tblName, $id);
	}

	function restore($id = array(), $data = array() ){
		$data['deleted_at'] = null;
		return $this->db->update($this->tblName, $data, $id);
	}


}