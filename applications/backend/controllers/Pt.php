<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 */
class Pt extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
	}
	
	public function index()
	{
		$data_set = $this->pt_model->list_all();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}
