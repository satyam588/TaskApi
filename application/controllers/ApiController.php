<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends CI_Controller{ 

	public function __construct() {
		parent :: __construct();

		$this->load->model('ApiModel');

		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");
		header("Access-Control-Allow-Methods: GET, POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	}

	public function upload_image() {

		$config['upload_path']          = './uploads';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 5000;
        $config['encrypt_name']			= TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image')){
            $error = array('error' => $this->upload->display_errors());

            print_r($error);
            exit;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data'];
        }
	}

	public function register() {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$this->form_validation->set_data($this->input->post());
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|min_length[10]|max_length[10]|is_unique[users.mobile]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('re-password', 'Re-Password', 'required|matches[password]');

            if ($this->form_validation->run() == FALSE){
                echo "Failed Validation <br>";
                echo validation_errors();

            }else{
            	$image_data = $this->upload_image();
            	
                $data = $this->ApiModel->register( $image_data['file_name'] );

                echo $data;
            }
		}else {
			echo "Something Went Wrong";
		}
	}

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

			$this->form_validation->set_data($this->input->post());
			$this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE){
                echo "Failed Validation <br>";
                echo validation_errors();

            }else{
                $data = $this->ApiModel->login();

                echo $data;
            }

		}else {
			echo "Something Went Wrong";
		}
	}
}
