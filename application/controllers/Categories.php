<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Categories extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('categories_model');
	}

	public function index()
	{
		user_session_check();

		redirect('categories/all');
	}

	public function all($page = 1)
	{
		user_session_check();
		# pagination function
		$data['pagination']	= pagination('categories/all', $this->categories_model->get_count());

		$data['list'] = $this->categories_model->get_list($page);
		$data['page'] = 'categories/categories_list';
		$data['page_title'] = 'Categories';
		$this->load->view('template', $data);

	}

	public function add()
	{
		user_session_check();

		$this->form_validation->set_rules('category_name', 'Category name', 
			'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('category_description', 'Description', 
			'min_length[3]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'categories/add_category';
			$data['page_title'] = 'Add Category';
			$this->load->view('template', $data);
		}
		else
		{
			$this->categories_model->insert();
			$alert = get_alert_html('Category added successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('categories/all');
		}
	}

	public function edit($category_id = 0)
	{
		user_session_check();
		
		if (!$category_id || !is_numeric($category_id)) {
			show_404();
		}
		$category = $this->categories_model->get_record($category_id);
		if (is_null($category)) {
			show_404();
		}
		$this->form_validation->set_rules('category_name', 'Category name', 
			'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('category_description', 'Description', 
			'min_length[3]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'categories/edit_category';
			$data['page_title'] = 'Edit Category';
			$data['category'] = $category;
			$this->load->view('template', $data);
		}
		else
		{
			$this->categories_model->update($category_id);
			$alert = get_alert_html('Category updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('categories/all');
		}
	}

	public function delete($category_id = 0)
	{
		user_session_check();

		if (!$category_id || !is_numeric($category_id)) {
			show_404();
		}
		$category = $this->categories_model->get_record($category_id);
		if (is_null($category)) {
			show_404();
		}
		$this->categories_model->delete($category_id);
		$alert = get_alert_html('Category deleted successfully', ALERT_TYPE_SUCCESS);
		$this->session->set_flashdata('alert', $alert);
		redirect('categories/all');
	}
}

?>