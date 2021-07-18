<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model
{
	public function get_list($page = 1)
	{	
		$offset = ($page - 1) * RECORDS_PER_PAGE;
		$this->db->limit(RECORDS_PER_PAGE , $offset);
		return $this->db->get('categories')->result();
	}

	public function get_count()
	{
		return $this->db->count_all('categories');
	}

	public function get_all()
	{
		$this->db->order_by('category_name', 'ASC');
		return $this->db->get('categories')->result();
	}

	public function insert()
	{
		$this->db->set('category_name', $this->input->post('category_name'));
		$this->db->set('category_description', $this->input->post('category_description'));
		$this->db->insert('categories');
	}

	public function get_record($category_id )
	{
		$this->db->where('category_id', $category_id);
		return $this->db->get('categories')->row();
	}
	
	public function update($category_id)
	{	
		$this->db->set('category_name', $this->input->post('category_name'));
		$this->db->set('category_description', $this->input->post('category_description'));
		
		$this->db->where('category_id', $category_id);
		$this->db->update('categories');	
	}
	
	public function delete($category_id)
	{
		$this->db->where('category_id', $category_id);
		$this->db->delete('categories');			
		
		$item = array('category_id' => 0);			
		$this->db->where('category_id', $category_id);
		$this->db->update('items', $item);
	}

}
?>