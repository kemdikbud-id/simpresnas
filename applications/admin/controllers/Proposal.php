<?php

/**
 * @author Fathoni
 * @property Proposal_model $proposal_model
 * @property File_proposal_model $file_proposal_model
 * @property PerguruanTinggi_model $pt_model
 * @property Kegiatan_model $kegiatan_model
 * @property Kategori_model $kategori_model
 */
class Proposal extends Admin_Controller
{
	const FILE_PROPOSAL_PATH = '../upload/file-proposal/';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'file_proposal_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_KATEGORI, 'kategori_model');
		
		$this->load->helper('time_elapsed_helper');
	}
	
	public function index_pbbt()
	{
		if ( ! empty($this->input->get('kegiatan_id')))
		{
			$data_set = $this->proposal_model->list_all_per_kegiatan($this->input->get('kegiatan_id'));
			
			$this->smarty->assign('data_set', $data_set);
		}
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_all(PROGRAM_PBBT));
		$this->smarty->display();
	}
	
	public function index_kbmi()
	{
		if ( ! empty($this->input->get('kegiatan_id')))
		{
			$data_set = $this->proposal_model->list_all_per_kegiatan($this->input->get('kegiatan_id'));
			
			$this->smarty->assign('data_set', $data_set);
		}
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_all(PROGRAM_KBMI));
		$this->smarty->display();
	}
	
	public function index_kbmi_v2()
	{
		if ( ! empty($this->input->get('kegiatan_id')))
			$kegiatan_id = $this->input->get('kegiatan_id');
		else
			$kegiatan_id = 0;
		
		if ( ! empty($this->input->get('tampilan')))
			$tampilan = $this->input->get('tampilan');
		else
			$tampilan = '';
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_all(PROGRAM_KBMI));
		$this->smarty->assign('kegiatan_id', $kegiatan_id);
		$this->smarty->assign('tampilan', $tampilan);
		$this->smarty->display();
	}
	
	public function index_kbmi_v2_data($kegiatan_id, $tampilan = 'submited')
	{
		echo json_encode(
			$this->proposal_model->list_all_per_kegiatan_v2_dt($kegiatan_id, $tampilan, $this->input->post(), TRUE)
		);
	}
	
	public function index_startup()
	{
		if ( ! empty($this->input->get('kegiatan_id')))
		{
			$data_set = $this->proposal_model->list_all_startup($this->input->get('kegiatan_id'));
			
			$this->smarty->assign('data_set', $data_set);
		}
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_all(PROGRAM_STARTUP));
		$this->smarty->display();
	}
	
	public function view()
	{
		// id proposal
		$id = (int)$this->input->get('id');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$is_didanai = $this->input->post('is_didanai');
			
			$this->db->update('proposal', ['is_didanai' => $is_didanai], ['id' => $id]);
			
			$this->session->set_flashdata('updated', TRUE);
			
			redirect(site_url('proposal/view') . '?' . $_SERVER['QUERY_STRING']);
			exit();
		}
		
		$data = $this->proposal_model->get_single($id);
		$data->kegiatan = $this->kegiatan_model->get_single($data->kegiatan_id);
		$data->file_proposal_set = $this->file_proposal_model->list_by_proposal($id);
		$data->kategori = $this->kategori_model->get_single($data->kategori_id);
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
