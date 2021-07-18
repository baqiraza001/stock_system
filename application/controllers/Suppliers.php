<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Suppliers extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('suppliers_model');
	}

	public function index()
	{
		user_session_check();

		redirect('suppliers/all');
	}

	public function all($page = 1)
	{
		user_session_check();
		# pagination function
		$data['pagination']	= pagination('suppliers/all', $this->suppliers_model->get_count());

		$data['list'] = $this->suppliers_model->get_list($page);
		$data['page'] = 'suppliers/suppliers_list';
		$data['page_title'] = 'Suppliers';
		$this->load->view('template', $data);

	}

	public function add()
	{
		user_session_check();

		$this->form_validation->set_rules('supplier_name', 'Supplier name', 
			'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('supplier_phone', 'Supplier Phone', 
		'trim|required|min_length[10]|max_length[20]');
		$this->form_validation->set_rules('supplier_address', 'Supplier address', 
		'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('supplier_description', 'Description', 
		'min_length[3]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'suppliers/add_supplier';
			$data['page_title'] = 'Add Supplier';
			$this->load->view('template', $data);
		}
		else
		{
			$this->suppliers_model->insert();
			$alert = get_alert_html('Supplier added successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('suppliers/all');
		}
	}

	public function edit($supplier_id = 0)
	{
		user_session_check();
		
		if (!$supplier_id || !is_numeric($supplier_id)) {
			show_404();
		}
		$supplier = $this->suppliers_model->get_record($supplier_id);
		if (is_null($supplier)) {
			show_404();
		}
		
		$this->form_validation->set_rules('supplier_name', 'Supplier name', 
		'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('supplier_phone', 'Supplier Phone', 
		'trim|required|min_length[10]|max_length[20]');
		$this->form_validation->set_rules('supplier_address', 'Supplier address', 
		'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('supplier_description', 'Description', 
		'min_length[3]');

		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'suppliers/edit_supplier';
			$data['page_title'] = 'Edit Supplier';
			$data['supplier'] = $supplier;
			$this->load->view('template', $data);
		}
		else
		{
			$this->suppliers_model->update($supplier_id);
			$alert = get_alert_html('Supplier updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('suppliers/all');
		}
	}

	public function delete($supplier_id = 0)
	{
		user_session_check();

		if (!$supplier_id || !is_numeric($supplier_id)) {
			show_404();
		}
		$supplier = $this->suppliers_model->get_record($supplier_id);
		if (is_null($supplier)) {
			show_404();
		}
		$this->suppliers_model->delete($supplier_id);
		$alert = get_alert_html('Supplier deleted successfully', ALERT_TYPE_SUCCESS);
		$this->session->set_flashdata('alert', $alert);
		redirect('suppliers/all');
	}
}

?>