<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
	public function get_list($page = 1)
	{
		$offset = ($page - 1) * RECORDS_PER_PAGE;
		$this->db->limit(RECORDS_PER_PAGE , $offset);
		return $this->db->get('users')->result();
	}

	public function get_count()
	{
		return $this->db->count_all('users');
	}

	public function insert($profile_picture)
	{
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('email', $this->input->post('email'));

		$password = $this->input->post('password');
		$this->db->set('password', "MD5('$password')", false);
		
		$this->db->set('profile_picture', $profile_picture);

		$this->db->set('date_created', date('Y-m-d'));
		
		$this->db->insert('users');
	}

	public function get_record($user_id )
	{
		$this->db->where('user_id', $user_id);
		return $this->db->get('users')->row();
	}
	
	public function update($user_id, $profile_picture)
	{	
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('email', $this->input->post('email'));
		$password = $this->input->post('password');
		
		if (!empty($password)) {
			$this->db->set('password', "MD5('$password')", false);
		}
		if (!empty($profile_picture)) {
			$this->db->set('profile_picture', $profile_picture);
		}
		$this->db->where('user_id', $user_id);
		$this->db->update('users');	
	}
	
	public function delete($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('users');			
	}

	// validate password of the user which is login
	public function validate_password($user_id, $password)
	{		
		$this->db->where('user_id', $user_id);
		$this->db->where("password = MD5('$password')");
		return $this->db->get('users')->num_rows();				
	}

	public function update_profile($user_id, $profile_picture)
	{	
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('email', $this->input->post('email'));
		$password = $this->input->post('new_password');
		
		if (!empty($password)) {
			$this->db->set('password', "MD5('$password')", false);
		}
		if (!empty($profile_picture)) {
			$this->db->set('profile_picture', $profile_picture);
		}
		$this->db->where('user_id', $user_id);
		$this->db->update('users');	
	}
	// validate user for login page
	public function validate_user()
	{		
		$this->db->where('email', $this->input->post('email'));
		$password = $this->input->post('password');
		$this->db->where("password = MD5('$password')");
		return $this->db->get('users')->row();				
	}

	public function get_user_by_email($email_id)
	{
		$this->db->where('email', $email_id);
		return $this->db->get('users')->row();
	}

	public function save_hash($user_id, $hash)
	{
		$this->db->where('user_id', $user_id);
		$this->db->set('hash', $hash);
		$this->db->update('users');
	}

	public function get_user_by_hash($hash)
	{
		$this->db->where('hash', $hash);
		return $this->db->get('users')->row();
	}

	public function update_password($user_id, $password)
	{
		$this->db->where('user_id', $user_id);
		$this->db->set('password', "MD5('$password')", false);
		$this->db->update('users');
	}
}
?>