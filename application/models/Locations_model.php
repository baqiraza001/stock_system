<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations_model extends CI_Model
{
	public function get_list($page = 1)
	{
		$offset = ($page - 1) * RECORDS_PER_PAGE;
		$this->db->limit(RECORDS_PER_PAGE , $offset);
		return $this->db->get('locations')->result();
	}

	public function get_count()
	{
		return $this->db->count_all('locations');
	}

	public function get_all()
	{
		$this->db->order_by('location_name', 'ASC');
		return $this->db->get('locations')->result();
	}

	public function insert()
	{
		$this->db->set('location_name', $this->input->post('location_name'));
		$this->db->set('location_description', $this->input->post('location_description'));
		$this->db->insert('locations');
	}

	public function get_record($location_id )
	{
		$this->db->where('location_id', $location_id);
		return $this->db->get('locations')->row();
	}
	
	public function update($location_id)
	{	
		$this->db->set('location_name', $this->input->post('location_name'));
		$this->db->set('location_description', $this->input->post('location_description'));
		
		$this->db->where('location_id', $location_id);
		$this->db->update('locations');	
	}
	
	public function delete($location_id)
	{
		$this->db->where('location_id', $location_id);
		$this->db->delete('locations');

		$item = array('location_id' => 0);			
		$this->db->where('location_id', $location_id);
		$this->db->update('items', $item);
	}

}
?>