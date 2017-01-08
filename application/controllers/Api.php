<?php

class Api extends CI_Controller
{

	public function index()
	{
		$this->load->view('api');
		//We use $this->input->post() for taking the data from form in the android application

	}

	public function sign_in()
	{
		//let me consider that the $post array will contain the data from $this->input->post()
		$post = ['username'=>'abc','password'=>'xyz'];

		//Form Validation
		$this->load->library('form_validation');
		//username and password name will be in the form of frontend
		$this->form_validation->set_rules('username','User Name',"required|alpha|trim|is_unique('users','username')");
		$this->form_validation->set_rules('password','Password','required');

		//Condtion will be $this->form_validation->run() but at this the the form not exist so we do not validate the form
		if($this->form_validation->run())
		{
			$post['password'] = md5($post['password']);
			//Try to match with database
			$this->load->model('apimodel');
			if($this->apimodel->sign_in($post))
			{
				echo "Signed In\n";
				return TRUE;
			}
			else
			{
				echo "Invalid username or password\n";
				return FALSE;
			}
		}
		else
		{
			echo "Wrong pattern\n";
			//echo validation_errors();
			return FALSE;
		}

	}
	public function sign_up()
	{
		$this->load->helper('url');
		//let me consider that the $post array will contain the data from $this->input->post()
		$post = ['username'=>'abc','password'=>'xyz','dob'=>'20-12-1997','gender'=>'Male','Address'=>'XYZ'];

		//Form Validation
		$this->load->library('form_validation');
		//username and password name will be in the form of frontend
		$this->form_validation->set_rules('username','User Name',"required|alpha|trim|is_unique('users','username')");
		$this->form_validation->set_rules('password','Password','required');

		//Condtion will be $this->form_validation->run() but at this the the form not exist so we do not validate the form

		$config = [
			'upload_path'	=>		'./uploads',
			'allowed_types'	=>		'jpg|gif|png|jpeg|pdf|doc',
		];
		$this->load->library('upload', $config);
		//image will be the name of file_upload
		if($this->form_validation->run() && $this->upload->do_upload('image'))
		{
			$data = $this->upload->data();
			$image_path = base_url("uploads/".$data['raw_name'].$data['file_ext']);
			$post['image_path'] = $image_path;
			$post['password'] = md5($post['password']);
			//Try to match with database
			$this->load->model('apimodel');
			if($this->apimodel->sign_up($post))
			{
				echo "Successfully Registered";
			}
			else
			{
				echo "Intenal Error!";
			}
		}
		else
		{
			echo "Error in form fields";
			//echo validation_errors();
			return FALSE;
		}

	}

	

}