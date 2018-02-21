<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property LokasiWorkshop_model $lokasi_model
 * @property PesertaWorkshop_model $peserta_model
 */
class Workshop extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
		$this->load->model('LokasiWorkshop_model', 'lokasi_model');
		$this->load->model('PesertaWorkshop_model', 'peserta_model');
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
}
