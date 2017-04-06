<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 */
class Kegiatan extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
	}
	
	public function index()
	{
		$data_set = $this->kegiatan_model->list_all();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function add()
	{
		
	}
	
	public function update($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			echo $this->kegiatan_model->update($id); exit();
		}
		
		$data = $this->kegiatan_model->get_single((int)$id);
		
		$this->smarty->assign('data', $data);
		
		$this->smarty->display();
	}
}
