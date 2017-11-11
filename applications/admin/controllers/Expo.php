<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 * @property Proposal_model $proposal_model
 */
class Expo extends Admin_Controller
{	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('proposal_model');
	}
	
	public function index()
	{	
		$data_set = $this->proposal_model->list_all_proposal_expo();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function index_per_pt()
	{
		$data_set = $this->proposal_model->list_all_proposal_expo_per_pt();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}