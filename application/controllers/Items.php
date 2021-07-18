<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Items extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('items_model');
		$this->load->model('locations_model');
		$this->load->model('categories_model');
		$this->load->model('suppliers_model');

	}

	public function index()
	{
		user_session_check();

		redirect('items/all');
	}

	public function all()
	{
		user_session_check();
		$data['locations'] = $this->locations_model->get_all();
		$data['categories'] = $this->categories_model->get_all();
		$data['suppliers'] = $this->suppliers_model->get_all();
		$data['page'] = 'items/items_list';
		$data['page_title'] = 'Items';
		$this->load->view('template', $data);

	}

	public function add()
	{
		user_session_check();

		$this->form_validation->set_rules('item_name', 'Item name', 
			'trim|required|min_length[3]|max_length[300]');
		$this->form_validation->set_rules('item_code', 'Item code', 
			'trim|required|min_length[3]|max_length[300]');
		$this->form_validation->set_rules('current_stock', 'Current Stock', 
		'trim|required|is_natural|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('threshold', 'Low stock threshold', 
		'trim|required|is_natural|min_length[1]|max_length[11]');
	
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['locations'] = $this->locations_model->get_all();
			$data['categories'] = $this->categories_model->get_all();
			$data['suppliers'] = $this->suppliers_model->get_all();
			$data['page'] = 'items/add_item';
			$data['page_title'] = 'Add Item';
			$this->load->view('template', $data);
		}
		else
		{
			$item_image = '';
			$item_file = '';
			$this->load->library('upload');

			if (!empty($_FILES['item_image']['name'])) {
				$config['upload_path'] = PATH_ITEM_IMAGES;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '2048';
				$config['overwrite'] = TRUE;
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('item_image'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('items/add');
		        }
		        $upload_data = $this->upload->data();
				$item_image = $upload_data['file_name'];
			}

			if (!empty($_FILES['item_file']['name'])) {
				$config['upload_path'] = PATH_ITEM_FILES;
				$config['allowed_types'] = 'docx|pdf|doc|text|xls';
				$config['max_size'] = '5021';
				$config['overwrite'] = TRUE;
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('item_file'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('items/add');
		        }
		        $upload_data = $this->upload->data();
				$item_file = $upload_data['file_name'];
			}

			$this->items_model->insert($item_image, $item_file);
			$alert = get_alert_html('Item added successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('items/all');
		}
	}

	public function edit($item_id = 0)
	{
		user_session_check();

		if (!$item_id || !is_numeric($item_id)) {
			show_404();
		}
		$item = $this->items_model->get_record($item_id);
		if (is_null($item)) {
			show_404();
		}

		$this->form_validation->set_rules('item_name', 'Item name', 
			'trim|required|min_length[3]|max_length[300]');
		$this->form_validation->set_rules('item_code', 'Item code', 
			'trim|required|min_length[3]|max_length[300]');
		$this->form_validation->set_rules('current_stock', 'Current Stock', 
		'trim|required|is_natural|min_length[1]|max_length[11]');
		$this->form_validation->set_rules('threshold', 'Low stock threshold', 
		'trim|required|is_natural|min_length[1]|max_length[11]');
	
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['locations'] = $this->locations_model->get_all();
			$data['categories'] = $this->categories_model->get_all();
			$data['suppliers'] = $this->suppliers_model->get_all();
			$data['page'] = 'items/edit_item';
			$data['page_title'] = 'Edit Item';
			$data['item'] = $item;
			$this->load->view('template', $data);
		}
		else
		{
			$item_image = '';
			$item_file = '';
			$this->load->library('upload');

			if (!empty($_FILES['item_image']['name'])) {
				$config['upload_path'] = PATH_ITEM_IMAGES;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '2048';
				$config['overwrite'] = TRUE;
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('item_image'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect("items/edit/$item_id");
		        }
		        $upload_data = $this->upload->data();
				$item_image = $upload_data['file_name'];
			}

			if (!empty($_FILES['item_file']['name'])) {
				$config['upload_path'] = PATH_ITEM_FILES;
				$config['allowed_types'] = 'docx|pdf|doc|text|xls';
				$config['max_size'] = '5021';
				$config['overwrite'] = TRUE;
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('item_file'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect("items/edit/$item_id");
		        }
		        $upload_data = $this->upload->data();
				$item_file = $upload_data['file_name'];
			}

			$this->items_model->update($item_id, $item_image, $item_file);
			$alert = get_alert_html('Item updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect("items/detail/$item_id");
		}
	}

	public function delete($item_id = 0)
	{
		user_session_check();

		if (!$item_id || !is_numeric($item_id)) {
			show_404();
		}
		$item = $this->items_model->get_record($item_id);
		if (is_null($item)) {
			show_404();
		}
		$this->items_model->delete($item_id);

		# code to delete item file or image from folder or directory
		if(!empty($item->image_name) && file_exists(PATH_ITEM_IMAGES . $item->image_name))
			unlink(PATH_ITEM_IMAGES . $item->image_name);

		if(!empty($item->file_name) && file_exists(PATH_ITEM_FILES . $item->file_name))
			unlink(PATH_ITEM_FILES . $item->file_name);
		# file delete code ends here
		# to move file to other folder use php rename function

		$alert = get_alert_html('Item deleted successfully', ALERT_TYPE_SUCCESS);
		$this->session->set_flashdata('alert', $alert);
		redirect('items/all');
	}

	public function detail($item_id = 0)
	{
		user_session_check();
		if (!$item_id || !is_numeric($item_id)) {
			show_404();
		}
		$item = $this->items_model->get_record($item_id);
		$items_history = $this->items_model->get_history($item_id);
		if (is_null($item)) {
			show_404();
		}
		$data["page"] = "items/item_details";
		$data["item"] = $item;
		$data["items_history"] = $items_history;
		$data['page_title'] = 'Item Details';
		$this->load->view('template',$data);
	}

	public function all_ajax($page = 1)
	{
		user_session_check();

		# pagination function
		$data['pagination']	= pagination('items/all_ajax', $this->items_model->get_list($page, TRUE), ITEMS_PER_PAGE);

		$data["items"] = $this->items_model->get_list($page, FALSE);
		$this->load->view('items/items_list_ajax',$data);
	}

	public function add_stock($item_id = 0)
	{
		user_session_check();

		if (!$item_id || !is_numeric($item_id)) {
			show_404();
		}
		$item = $this->items_model->get_record($item_id);
		if (is_null($item)) {
			show_404();
		}

		$this->form_validation->set_rules('amount', 'Amount', 
			'trim|required|is_natural|min_length[1]|max_length[11]');
	
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$message = validation_errors(' ', ' ');
			$alert = get_alert_html($message, ALERT_TYPE_ERROR);
			$this->session->set_flashdata('alert', $alert);
			redirect("items/detail/$item_id");
		}
		else
		{
			$this->items_model->add_stock($item_id);
			$alert = get_alert_html('Stock updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect("items/detail/$item_id");
		}
	}

	public function remove_stock($item_id = 0)
	{
		user_session_check();

		if (!$item_id || !is_numeric($item_id)) {
			show_404();
		}
		$item = $this->items_model->get_record($item_id);
		if (is_null($item)) {
			show_404();
		}

		$this->form_validation->set_rules('amount', 'Amount', 
			'trim|required|is_natural|min_length[1]|max_length[11]');
	
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$message = validation_errors(' ', ' ');
			$alert = get_alert_html($message, ALERT_TYPE_ERROR);
			$this->session->set_flashdata('alert', $alert);
			redirect("items/detail/$item_id");
		}
		else
		{
			$this->items_model->remove_stock($item_id);
			$alert = get_alert_html('Stock updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect("items/detail/$item_id");
		}
	}	

	public function search()
	{
		$data['items'] = $this->items_model->search();
		$this->load->view('items/search_results', $data);
	}
}

?>