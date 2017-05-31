<?php

/**
 * @author Fathoni
 * @property Proposal_model $proposal_model
 * @property FileProposal_model $fileproposal_model
 * @property PerguruanTinggi_model $pt_model
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
		$this->load->model('PerguruanTinggi_model', 'pt_model');
		
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
		// id proposal
		$id = (int)$this->input->get('id');
		
		$data = $this->proposal_model->get_single($id);
		$data->file_proposal_set = $this->fileproposal_model->list_by_proposal($id);
		$this->smarty->assign('data', $data);
		
		$pt = $this->pt_model->get_single($data->perguruan_tinggi_id);
		
		if ($data->program_id == PROGRAM_PBBT) { $program_path = 'pbbt'; $username = $pt->npsn . '01'; }
		if ($data->program_id == PROGRAM_KBMI) { $program_path = 'kbmi'; $username = $pt->npsn . '02'; }
		
		// file location
		$path = base_url() . '../upload/file-proposal/'.$program_path.'/'.$username.'/'.$id.'/';
		$this->smarty->assign('file_path', $path);
		
		$this->smarty->display();
	}
}
