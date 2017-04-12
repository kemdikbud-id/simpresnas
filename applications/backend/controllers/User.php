<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property RequestUser_model $requestuser_model
 * @property User_model $user_model
 */
class User extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('RequestUser_model', 'requestuser_model');
		$this->load->model('User_model', 'user_model');
	}
	
	public function index()
	{
		$data_set = $this->user_model->list_user();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function update($id)
	{		
		$this->smarty->display();
	}
	
	public function request()
	{
		$this->load->helper('time_elapsed');
		
		$data_set = $this->requestuser_model->list_request();
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			$data->waktu = time_elapsed_string($data->created_at);
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function request_approve()
	{
		$id = (int)$this->input->get('id');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->requestuser_model->approve($id);
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar User Request',
				'message' => 'Berhasil',
				'link_1' => '<a href="'.site_url('user/request').'">Kembali ke daftar user request</a>'
			));
			
			redirect(site_url('alert/success'));
		}
		
		$data = $this->requestuser_model->get_single($id);
		
		$this->smarty->assign('data', $data);
		$this->smarty->display();
	}
	
	public function request_reject()
	{
		$id = (int)$this->input->get('id');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->requestuser_model->reject($id);
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar User Request',
				'message' => 'Berhasil',
				'link_1' => '<a href="'.site_url('user/request').'">Kembali ke daftar user request</a>'
			));
			
			redirect(site_url('alert/success'));
		}
		
		$data = $this->requestuser_model->get_single($id);
		
		$this->smarty->assign('data', $data);
		$this->smarty->display();
	}
}
