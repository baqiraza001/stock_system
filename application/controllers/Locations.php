<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Locations extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('locations_model');		
	}

	public function index()
	{
		user_session_check();

		redirect('locations/all');
	}

	public function all($page = 1)
	{
		user_session_check();

		# pagination function
		$data['pagination']	= pagination('locations/all', $this->locations_model->get_count());
		
		$data['list'] = $this->locations_model->get_list($page);
		$data['page'] = 'locations/locations_list';
		$data['page_title'] = 'Locations';
		$this->load->view('template', $data);

	}

	public function add()
	{
		user_session_check();

		$this->form_validation->set_rules('location_name', 'Location name', 
			'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('location_description', 'Description', 
			'min_length[3]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'locations/add_location';
			$data['page_title'] = 'Add Location';
			$this->load->view('template', $data);
		}
		else
		{
			$this->locations_model->insert();
			$alert = get_alert_html('Location added successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('locations/all');
		}
	}

	public function edit($location_id = 0)
	{
		user_session_check();
		
		if (!$location_id || !is_numeric($location_id)) {
			show_404();
		}
		$location = $this->locations_model->get_record($location_id);
		if (is_null($location)) {
			show_404();
		}
		$this->form_validation->set_rules('location_name', 'Location name', 
			'trim|required|min_length[3]|max_length[200]');
		$this->form_validation->set_rules('location_description', 'Description', 
			'min_length[3]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'locations/edit_location';
			$data['page_title'] = 'Edit Location';
			$data['location'] = $location;
			$this->load->view('template', $data);
		}
		else
		{
			$this->locations_model->update($location_id);
			$alert = get_alert_html('Location updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('locations/all');
		}
	}

	public function delete($location_id = 0)
	{
		user_session_check();

		if (!$location_id || !is_numeric($location_id)) {
			show_404();
		}
		$location = $this->locations_model->get_record($location_id);
		if (is_null($location)) {
			show_404();
		}
		$this->locations_model->delete($location_id);
		$alert = get_alert_html('Location deleted successfully', ALERT_TYPE_SUCCESS);
		$this->session->set_flashdata('alert', $alert);
		redirect('locations/all');
	}
}

?>