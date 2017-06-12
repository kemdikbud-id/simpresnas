<?php

/**
 * @author Fathoni
 * @property Proposal_model $proposal_model
 * @property FileProposal_model $fileproposal_model
 * @property PerguruanTinggi_model $pt_model
 * @property Kegiatan_model $kegiatan_model
 */
class Proposal extends Admin_Controller
{
	const FILE_PROPOSAL_PATH = '../upload/file-proposal/';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'fileproposal_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		
		$this->load->helper('time_elapsed_helper');
	}
	
	public function index_pbbt()
	{
		// PBBT 2017 --> 1
		$data_set = $this->proposal_model->list_all_per_kegiatan(1);
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			//$data->waktu = time_elapsed_string($data->created_at);
		}
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function index_kbmi()
	{
		// KBMI 2017 --> 2
		$data_set = $this->proposal_model->list_all_per_kegiatan(2);
		
		foreach ($data_set as &$data)
		{
			// get elapsed time
			//$data->waktu = time_elapsed_string($data->created_at);
		}
			
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function view()
	{
		// id proposal
		$id = (int)$this->input->get('id');
		
		$data = $this->proposal_model->get_single($id);
		$data->kegiatan = $this->kegiatan_model->get_single($data->kegiatan_id);
		$data->file_proposal_set = $this->fileproposal_model->list_by_proposal($id);
		$this->smarty->assign('data', $data);
		
		$pt = $this->pt_model->get_single($data->perguruan_tinggi_id);
		
		if ($data->kegiatan->program_id == PROGRAM_PBBT) { $program_path = 'pbbt'; $username = $pt->npsn . '01'; }
		if ($data->kegiatan->program_id == PROGRAM_KBMI) { $program_path = 'kbmi'; $username = $pt->npsn . '02'; }
		
		// file location
		$path = base_url() . '../upload/file-proposal/'.$program_path.'/'.$username.'/'.$id.'/';
		$this->smarty->assign('file_path', $path);
		
		$this->smarty->display();
	}
}
