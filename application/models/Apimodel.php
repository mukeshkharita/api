<?php

class Apimodel extends CI_Controller
{
	public function sign_in($post)
	{
		$this->load->database();
		$db = $this->db->from('users')
				->select(['username','password'])
				->where(['username'=>$post['username'],'password'=>$post['password']])
				->get();
		return $db->num_rows();
	}
	public function sign_up($post)
	{
		$this->load->database();
		$db = $this->db->insert('users',$post);
		return $db;
	}
}