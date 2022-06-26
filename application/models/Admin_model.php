<?php 
class Admin_model extends CI_Model{	

	public function __construct(){ 
		$this->load->database();
	}
	public function add_products($data=array())
	{
		$this->db->trans_start();
		foreach($data as $insdata)
		{
			$this->db->insert('tbl_item_details',$insdata);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
			return 0;
		else
		return 1;
	}

	public function get_lists($table,$columns,$limit="",$orderby="")
	{
		if($limit !="")
		{
			$limit='limit '.$limit;
		}
		if($orderby=="")
		{
			$orderby=' order by created_on desc';
		}
	  
		$query   = $this->db->query("SELECT $columns from $table where status != 'Deleted' $orderby $limit");
		$results = $query->result();
		return $results;
	}
	
	public function get_single_item_withid($columnlist,$id,$table,$where="")
	{
		   $this->db->select($columnlist)->from($table)->where('id',$id)->where('status !=','Deleted');
		   if($where)
		   $this->db->where($where);
		   return $result=$this->db->get()->row(); 
	}

	public function update_item_quantity($id,$qty)
	{
		$this->db->where('id', $id);
		$result= $this->db->query("update tbl_item_details set quantity = quantity-$qty where id=$id");
		if($this->db->affected_rows() >=0)
		return 1;
		else
		return 0;
	}

}