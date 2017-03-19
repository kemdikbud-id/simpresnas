<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends Backend_Controller
{
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			
			$user = $this->db->get_where('user', array(
				'username' => 'pbbt',   // nanti diganti admin
				'tipe_user' => TIPE_USER_ADMIN
			))->row();
			
			// Jika row ada
			if ($user != null)
			{
				// Bandingkan password, temporari --> password
				// if ($user->password_hash == sha1($password))
				if ($password == 'password')
				{
					
					// Assign data login ke session
					$this->session->set_userdata('user', $user);
					
					redirect(site_url('home'));
				}
			}
			
			$this->session->set_flashdata('failed_login', TRUE);
		}
		
		$this->smarty->display();
	}
}
