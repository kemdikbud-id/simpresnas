<?php

/**
 * @author Fathoni
 */
class Pt extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		$data_set = $this->db
			->get('perguruan_tinggi')
			->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}
