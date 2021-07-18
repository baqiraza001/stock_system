<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers_model extends CI_Model
{
	public function get_list($page = 1)
	{	
		$offset = ($page - 1) * RECORDS_PER_PAGE;
		$this->db->limit(RECORDS_PER_PAGE , $offset);
		return $this->db->get('suppliers')->result();
	}

	public function get_count()
	{
		return $this->db->count_all('suppliers');
	}

	public function get_all()
	{
		$this->db->order_by('supplier_name', 'ASC');
		return $this->db->get('suppliers')->result();
	}

	public function insert()
	{
		$this->db->set('supplier_name', $this->input->post('supplier_name'));
		$this->db->set('supplier_phone', $this->input->post('supplier_phone'));
		$this->db->set('supplier_address', $this->input->post('supplier_address'));
		$this->db->set('supplier_description', $this->input->post('supplier_description'));
		$this->db->insert('suppliers');
	}

	public function get_record($supplier_id )
	{
		$this->db->where('supplier_id', $supplier_id);
		return $this->db->get('suppliers')->row();
	}
	
	public function update($supplier_id)
	{	
		$this->db->set('supplier_name', $this->input->post('supplier_name'));
		$this->db->set('supplier_phone', $this->input->post('supplier_phone'));
		$this->db->set('supplier_address', $this->input->post('supplier_address'));
		$this->db->set('supplier_description', $this->input->post('supplier_description'));
		
		$this->db->where('supplier_id', $supplier_id);
		$this->db->update('suppliers');	
	}
	
	public function delete($supplier_id)
	{
		$this->db->where('supplier_id', $supplier_id);
		$this->db->delete('suppliers');			

		$item = array('supplier_id' => 0);			
		$this->db->where('supplier_id', $supplier_id);
		$this->db->update('items', $item);
	}

}
?>