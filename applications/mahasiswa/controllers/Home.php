<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Proposal_model $proposal_model
 */
class Home extends Mahasiswa_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->check_credentials();
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
	}
	
	public function index()
	{
		$kegiatan = $this->session->kegiatan;
		
		$kegiatan->available = (strtotime($kegiatan->tgl_awal_upload) < time()) && (time() < strtotime($kegiatan->tgl_akhir_upload));
		
		$proposal = $this->proposal_model->get_by_ketua($kegiatan->id, $this->session->user->mahasiswa_id);
		
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('kegiatan', $kegiatan);
		$this->smarty->display();
	}
}
