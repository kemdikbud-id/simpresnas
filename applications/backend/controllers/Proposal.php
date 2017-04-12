<?php

/**
 * @author Fathoni
 * @property Proposal_model $proposal_model
 */
class Proposal extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Proposal_model', 'proposal_model');
	}
	
	public function index_pbbt()
	{
		$data_set = $this->proposal_model->list_pbbt_all();
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			$data->waktu = time_elapsed_string($data->created_at);
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function index_kbmi()
	{
		$data_set = $this->proposal_model->list_kbmi_all();
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			$data->waktu = time_elapsed_string($data->created_at);
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}
