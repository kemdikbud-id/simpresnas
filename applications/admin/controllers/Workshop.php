<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property LokasiWorkshop_model $lokasi_model
 * @property PesertaWorkshop_model $peserta_model
 * @property ProposalWorkshop_model $proposal_model
 * @property Reviewer_model $reviewer_model
 */
class Workshop extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_LOKASI_WORKSHOP, 'lokasi_model');
		$this->load->model(MODEL_PESERTA_WORKSHOP, 'peserta_model');
		$this->load->model(MODEL_PROPOSAL_WORKSHOP, 'proposal_model');
		$this->load->model(MODEL_REVIEWER, 'reviewer_model');
	}
	
	public function peserta()
	{
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop());
		
		if ($this->input->get('kegiatan_id'))
		{
			$this->smarty->assign('lokasi_set', $this->lokasi_model->list_all($this->input->get('kegiatan_id')));
			$this->smarty->assign('data_set', $this->peserta_model->list_all_by_lokasi($this->input->get('lokasi_workshop_id')));
		}
		
		$this->smarty->display();
	}
	
	/**
	 * Ajax Request
	 */
	public function data_lokasi($id = 0)
	{
		// Pre process untuk format waktu pelaksanaan
		$lokasi_set = $this->lokasi_model->list_all($id);
		
		foreach ($lokasi_set as &$lokasi)
		{
			$lokasi->waktu_pelaksanaan = strftime('%d %B %Y', strtotime($lokasi->waktu_pelaksanaan));
		}
		
		echo json_encode($lokasi_set);
	}
	
	public function proposal()
	{
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop());
		
		if ($this->input->get('kegiatan_id'))
		{
			$this->smarty->assign('lokasi_set', $this->lokasi_model->list_all($this->input->get('kegiatan_id')));
			$this->smarty->assign('data_set', $this->proposal_model->list_all($this->input->get('lokasi_workshop_id')));
		}
		
		$this->smarty->display();
	}
	
	public function plotting($mode = 'index')
	{
		if ($mode == 'index')
		{
			$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop());
		
			if ($this->input->get('kegiatan_id'))
			{
				$this->smarty->assign('lokasi_set', $this->lokasi_model->list_all($this->input->get('kegiatan_id')));
				$this->smarty->assign('data_set', $this->peserta_model->list_all_by_lokasi($this->input->get('lokasi_workshop_id')));
			}

			$this->smarty->display();
		}
		
		if ($mode == 'pilih-reviewer')
		{
			$peserta_ids = $this->input->post('peserta_ids');
			
			if (count($peserta_ids) == 0)
			{
				redirect('workshop/plotting');
				exit();
			}
			
			$this->smarty->assign('peserta_ids', $peserta_ids);
			$this->smarty->assign('reviewer_set', $this->reviewer_model->list_reviewer());
			
			$this->smarty->display('workshop/plotting-pilih-reviewer.tpl');
		}
		
		if ($mode == 'save')
		{
			$peserta_ids = $this->input->post('peserta_ids');
			$reviewer_id = $this->input->post('reviewer_id');
			
			$result = $this->peserta_model->set_reviewer($peserta_ids, $reviewer_id);
			
			if ($result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Plotting Reviewer Peserta Workshop',
					'message' => 'Berhasil setting reviewer',
					'link_1' => '<a href="'.site_url('workshop/plotting').'">Kembali ke daftar peserta workshop</a>'
				));

				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Plotting Reviewer Peserta Workshop',
					'message' => 'Terjadi kesalahan',
					'link_1' => '<a href="'.site_url('workshop/plotting').'">Kembali ke daftar peserta workshop</a>'
				));

				redirect(site_url('alert/error'));
			}
		}
	}
}
