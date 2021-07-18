<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model
{
	public function get_list($page, $get_count = FALSE)
	{	
		$offset = ($page - 1) * ITEMS_PER_PAGE;
		
		$this->db->select('items.*');
		$this->db->from('items');

		if($this->input->post('location_id'))
		$this->db->where('location_id', $this->input->post('location_id'));

		if($this->input->post('category_id'))
		$this->db->where('category_id', $this->input->post('category_id'));

		if($this->input->post('supplier_id'))
		$this->db->where('supplier_id', $this->input->post('supplier_id'));

		if($this->input->post('stock_type') == 'low_stock')
		$this->db->where('current_stock <=', 'low_stock_threshold');

		if($get_count)
			return $this->db->count_all_results();

		$this->db->limit(ITEMS_PER_PAGE, $offset);

		return $this->db->get()->result();
	}

	public function get_count()
	{
		return $this->db->count_all('items');
	}

	public function insert($item_image, $item_file)
	{
		$this->db->set('item_name', $this->input->post('item_name'));
		$this->db->set('item_code', $this->input->post('item_code'));
		$this->db->set('current_stock', $this->input->post('current_stock'));
		$this->db->set('low_stock_threshold', $this->input->post('threshold'));
		$this->db->set('location_id', $this->input->post('location_id'));
		$this->db->set('category_id', $this->input->post('category_id'));
		$this->db->set('supplier_id', $this->input->post('supplier_id'));
		$this->db->set('item_notes', $this->input->post('item_notes'));
		$this->db->set('item_description', $this->input->post('item_description'));
		$this->db->set('date_created', date('Y-m-d'));
		$this->db->set('image_name', $item_image);
		$this->db->set('file_name', $item_file);
		
		$this->db->insert('items');
	}

	public function get_record($item_id)
	{
		$this->db->select('items.*, location_name, category_name, supplier_name');
		$this->db->from('items');
		$this->db->join('locations', 'items.location_id = locations.location_id', 'left');
		$this->db->join('categories', 'items.category_id = categories.category_id', 'left');
		$this->db->join('suppliers', 'items.supplier_id = suppliers.supplier_id', 'left');
		$this->db->where('item_id', $item_id);
		return $this->db->get()->row();
	}
	
	public function update($item_id, $item_image, $item_file)
	{	
		$this->db->set('item_name', $this->input->post('item_name'));
		$this->db->set('item_code', $this->input->post('item_code'));
		$this->db->set('current_stock', $this->input->post('current_stock'));
		$this->db->set('low_stock_threshold', $this->input->post('threshold'));
		$this->db->set('location_id', $this->input->post('location_id'));
		$this->db->set('category_id', $this->input->post('category_id'));
		$this->db->set('supplier_id', $this->input->post('supplier_id'));
		$this->db->set('item_notes', $this->input->post('item_notes'));
		$this->db->set('item_description', $this->input->post('item_description'));
	
		if (!empty($item_image)) {
			$this->db->set('image_name', $item_image);
		}
		if (!empty($item_file)) {
			$this->db->set('file_name', $item_file);
		}
		$this->db->where('item_id', $item_id);
		$this->db->update('items');	
	}
	
	public function delete($item_id)
	{
		$this->db->where('item_id', $item_id);
		$this->db->delete('items');			
	}

	public function add_stock($item_id)
	{
		$this->db->set('user_id', $this->session->userdata('user_id'));
		$this->db->set('item_id', $item_id);
		$this->db->set('amount', $this->input->post('amount'));
		$this->db->set('reference', $this->input->post('reference'));
		$this->db->set('type', STOCK_ADD);
		$this->db->set('history_datetime', date('Y-m-d H:i:s'));
		
		$this->db->insert('items_history');
		
		$amount = $this->input->post('amount');
		$this->db->set('current_stock', "current_stock + $amount", FALSE);
		$this->db->Where('item_id', $item_id);
		$this->db->update('items');
	}

	public function remove_stock($item_id)
	{
		$this->db->set('user_id', $this->session->userdata('user_id'));
		$this->db->set('item_id', $item_id);
		$this->db->set('amount', $this->input->post('amount'));
		$this->db->set('reference', $this->input->post('reference'));
		$this->db->set('type', STOCK_REMOVE);
		$this->db->set('history_datetime', date('Y-m-d H:i:s'));
		
		$this->db->insert('items_history');
		
		$amount = $this->input->post('amount');
		$this->db->set('current_stock', "current_stock - $amount", FALSE);
		$this->db->Where('item_id', $item_id);
		$this->db->update('items');
	}

	public function get_history($item_id)
	{
		$this->db->select('items_history.amount, items_history.type, items_history.reference, items_history.history_datetime, users.name, users.profile_picture');
		$this->db->from('items_history');
		$this->db->join('users', 'items_history.user_id = users.user_id', 'inner');
		$this->db->Where('item_id', $item_id);
		$this->db->order_by('history_datetime', 'DESC');
		return $this->db->get()->result();
	}

	public function search()
	{
		$search_q  = $this->input->post('search_q');
		$this->db->select('item_id, item_name, item_code')->from('items')
		->like('item_name', $search_q)->or_like('item_code', $search_q)
		->limit(5);
		return $this->db->get()->result();
	}
}
?>