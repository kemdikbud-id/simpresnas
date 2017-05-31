<?php

/**
 * @author Fathoni
 * @property Proposal_model $proposal_model
 * @property FileProposal_model $fileproposal_model
 */
class Proposal extends Admin_Controller
{
	const FILE_PROPOSAL_PATH = '../upload/file-proposal/';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Proposal_model', 'proposal_model');
		$this->load->model('FileProposal_model', 'fileproposal_model');
		
		$this->load->helper('time_elapsed_helper');
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
	
	public function view()
	{
		$id = (int)$this->input->get('id');
		
		$data = $this->proposal_model->get_single($id);
		$data->file_proposal_set = $this->fileproposal_model->list_by_proposal($id);
		$this->smarty->assign('data', $data);
		
		$this->smarty->display();
	}
}
