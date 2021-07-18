<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
	}

	public function index()
	{
		user_session_check();

		redirect('users/all');
	}

	public function all($page = 1)
	{
		user_session_check();

		# pagination function
		$data['pagination']	= pagination('users/all', $this->users_model->get_count());

		$data['list'] = $this->users_model->get_list($page);
		$data['page'] = 'users_list';
		$data['page_title'] = 'Users';
		$this->load->view('template', $data);

	}

	public function add()
	{
		user_session_check();

		$this->form_validation->set_rules('name', 'Name', 
			'trim|required|regex_match[/^[a-zA-Z ]*$/]|min_length[3]|max_length[75]');
		$this->form_validation->set_rules('email', 'Email',
		'trim|required|regex_match[/\b[a-zA-Z][a-z0-9._%+-]+@[a-z.-]+\.[a-z.-]/]|valid_email|min_length[8]|max_length[100]|is_unique[users.email]',array('is_unique' => 'email already exists'));
		$this->form_validation->set_rules('password', 'Password', 
			'required|min_length[8]|max_length[100]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'add_user';
			$data['page_title'] = 'Add User';
			$this->load->view('template', $data);
		}
		else
		{
			$profile_picture = '';
			if (!empty($_FILES['profile_picture']['name'])) {
				$config['upload_path'] = PATH_USER_PICS;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '2048';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('profile_picture'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('users/add');
		        }
		        $upload_data = $this->upload->data();
				$profile_picture = $upload_data['file_name'];
			}

			$this->users_model->insert($profile_picture);
			$alert = get_alert_html('User added successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			
			redirect('users/all');
		}
	}

	public function edit($user_id = 0)
	{
		user_session_check();
		
		if (!$user_id || !is_numeric($user_id)) {
			show_404();
		}
		$user = $this->users_model->get_record($user_id);
		if (is_null($user)) {
			show_404();
		}
		$this->form_validation->set_rules('name', 'Name', 
			'trim|required|regex_match[/^[a-zA-Z ]*$/]|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('email', 'Email',
		'trim|required|regex_match[/\b[a-zA-Z][a-z0-9._%+-]+@[a-z.-]+\.[a-z.-]/]|valid_email|min_length[8]|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 
			'min_length[8]|max_length[50]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'edit_user';
			$data['page_title'] = 'Edit User';
			$data['user'] = $user;
			$this->load->view('template', $data);
		}
		else
		{
			$profile_picture = '';
			if (!empty($_FILES['profile_picture']['name'])) {
				$config['upload_path'] = PATH_USER_PICS;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '2048';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('profile_picture'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('users/add');
		        }
		        $upload_data = $this->upload->data();
				$profile_picture = $upload_data['file_name'];
			}

			$this->users_model->update($user_id, $profile_picture);
			$alert = get_alert_html('User updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('users/all');
		}
	}

	public function profile()
	{
		user_session_check();
		$user_id = $this->session->userdata('user_id');
		
		$user = $this->users_model->get_record($user_id);
		if (is_null($user)) {
			show_404();
		}
		$this->form_validation->set_rules('name', 'Name', 
			'trim|required|regex_match[/^[a-zA-Z ]*$/]|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('email', 'Email',
		'trim|required|regex_match[/\b[a-zA-Z][a-z0-9._%+-]+@[a-z.-]+\.[a-z.-]/]|valid_email|min_length[8]|max_length[100]');
		$this->form_validation->set_rules('old_password', 'Password', 
			'min_length[8]|max_length[50]');
		$this->form_validation->set_rules('new_password', 'Password', 
			'min_length[8]|max_length[50]');
		$this->form_validation->set_message("required", "%s field is required");
		
		if (! $this->form_validation->run()) {
			$data['page'] = 'edit_profile';
			$data['page_title'] = 'Edit Profile';
			$data['user'] = $user;
			$this->load->view('template', $data);
		}
		else
		{
			// validate old password with new password
			if ($this->input->post('new_password')) {
				$old_password = $this->input->post('old_password');
				$rows = $this->users_model->validate_password($user_id, $old_password);
				if ($rows == 0) {
					$message = 'Invalid current password';
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('users/profile');
				}
			}

			$profile_picture = '';
			if (!empty($_FILES['profile_picture']['name'])) {
				$config['upload_path'] = PATH_USER_PICS;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size'] = '2048';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('profile_picture'))
		        {
		            $message = $this->upload->display_errors('', '');
		            $alert = get_alert_html($message, ALERT_TYPE_ERROR);
					$this->session->set_flashdata('alert', $alert);
					redirect('users/profile');
		        }
		        $upload_data = $this->upload->data();
				$profile_picture = $upload_data['file_name'];
			}

			$this->users_model->update_profile($user_id, $profile_picture);
			$alert = get_alert_html('Profile updated successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);

			$this->session->set_userdata('name', $this->input->post('name'));
			$this->session->set_userdata('email', $this->input->post('email'));
			if (!empty($profile_picture)) {
				$this->session->set_userdata('profile_picture', $profile_picture);
			}
			redirect('users/profile');
		}
	}
	public function delete($user_id = 0)
	{
		user_session_check();

		if (!$user_id || !is_numeric($user_id)) {
			show_404();
		}
		$user = $this->users_model->get_record($user_id);
		if (is_null($user)) {
			show_404();
		}
		$this->users_model->delete($user_id);
		$alert = get_alert_html('User deleted successfully', ALERT_TYPE_SUCCESS);
		$this->session->set_flashdata('alert', $alert);
		redirect('users/all');
	}

	public function login()
	{
		if ($this->session->userdata('user_id')) 
		{
			redirect('items/all');
		}
		
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_message('required','%s is required');

		if( !$this->form_validation->run())
		{
			$data['page_title'] = 'Login';
			$this->load->view('login', $data);
		}
		else 
		{
			$user = $this->users_model->validate_user();
			if (is_null($user)) 
			{
				$alert = get_alert_html('Invalid email or password', ALERT_TYPE_ERROR);
				$this->session->set_flashdata('alert', $alert);
				redirect('users/login');
			}
			$this->session->set_userdata('user_id', $user->user_id);
			$this->session->set_userdata('name', $user->name);
			$this->session->set_userdata('email', $user->email);
			if (empty($user->profile_picture)) {
				$this->session->set_userdata('profile_picture', 'avatar.png');
			}
			else {
				$this->session->set_userdata('profile_picture', $user->profile_picture);
			}
			$alert = get_alert_html('Login successfully', ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect('items/all');
		}
	}

	public function forgot_password()
	{
		if (is_user()) 
		{
			redirect('items/all');
		}
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if( !$this->form_validation->run())
		{
			$data['page_title'] = 'Forgot Password';
			$this->load->view('forgot_password', $data);
		}
		else 
		{
			$email_id = $this->input->post('email');
			$user = $this->users_model->get_user_by_email($email_id);
			if (is_null($user)) 
			{
				$alert = get_alert_html('Email does not exists', ALERT_TYPE_ERROR);
				$this->session->set_flashdata('alert', $alert);
				redirect('users/forgot_password');
			}
			// random encrypted code generation
			$hash = uniqid();
			$hash = md5($hash);
			$this->users_model->save_hash($user->user_id, $hash);

			# email send code starts here
			$data['name'] = $user->name;
			$data['reset_url'] = site_url("users/reset_password/$hash");

			$config['mailtype'] = 'html';
			$this->load->library('email', $config);
			
			$this->email->from(ADMIN_EMAIL);
			$this->email->to($email_id);
			$this->email->subject('Reset Password');
			$message = $this->load->view('emails/forgot_email', $data, true);
			$this->email->message($message);
			$is_sent = $this->email->send();
			if ($is_sent) {
				$alert = get_alert_html('An email has been sent to your email address to reset password. please check your email box.', ALERT_TYPE_SUCCESS);
				$this->session->set_flashdata('alert', $alert);
			}
			# //email send code starts here
			
			redirect('users/forgot_password');
		}	
	}

	public function reset_password($hash)
	{
		if (is_user()) 
		{
			redirect('items/all');
		}

		if (empty($hash)) {
			show_404();
		}
		
		$user = $this->users_model->get_user_by_hash($hash);
		if (is_null($user)) {
			show_404();
		}
		$this->form_validation->set_rules('password', 'New password', 
			'required|min_length[8]|max_length[100]');
				$this->form_validation->set_rules('confirm_password', 'Confirm password', 
			'required|min_length[8]|max_length[100]');
		if( !$this->form_validation->run())
		{
			$data['page_title'] = 'Reset Password';
			$this->load->view('reset_password', $data);
		}
		else 
		{
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			if($password != $confirm_password) {
				$alert = get_alert_html("Password didn't match.", ALERT_TYPE_ERROR);
				$this->session->set_flashdata('alert', $alert);
				redirect("users/reset_password/$hash");
			}
			$this->users_model->update_password($user->user_id, $password);
			$this->users_model->save_hash($user->user_id, '');
			$alert = get_alert_html("Password changed successfully. please login with new password", ALERT_TYPE_SUCCESS);
			$this->session->set_flashdata('alert', $alert);
			redirect("users/login");
		}
	}

	public function logout()
	{
		user_session_check();
		
		$this->session->sess_destroy();
		redirect('users/login');
	}
}

?>