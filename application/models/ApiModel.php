<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiModel Extends CI_Model{ 
	public function __construct() {
		Parent:: __construct();
	}

	public function register( $image_name ) {
		$data = [
			'name'			=> $this->input->post('name'),
			'username'		=> $this->input->post('username'),
			'mobile'		=> $this->input->post('mobile'),
			'email'			=> $this->input->post('email'),
			'password'		=> md5($this->input->post('password')),
			'image'			=> $image_name,
			'created_on'	=> date('Y-m-d')
		];

		if( $this->db->insert('users', $data) ) {
			return "User Registered Success";
		}else {
			return "Registration Failed";
		}
	}

	public function login() {

		$this->db->where('is_deleted', '0');
		$this->db->where('status', '1');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$result = $this->db->get('users');

		$result_data = $result->row();

		if ( $result->num_rows() === 1 ) {
			return 'Login Success, Welcome user: '. $result_data->name;
		}else {
			return 'Login failed, Username/Password was Incorrect';
		}

	}
}
