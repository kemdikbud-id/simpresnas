<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 */
class Pt extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
	}
	
	public function index()
	{
		$this->smarty->display();
	}
	
	public function data_pt_all()
	{
		$data_set = $this->pt_model->list_all();
		echo json_encode(array('data' => $data_set));
	}
}
