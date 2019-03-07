<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property PesertaWorkshop_model $peserta_model
 * @property LokasiWorkshop_model $lokasi_model 
 */
class Workshop extends Reviewer_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PESERTA_WORKSHOP, 'peserta_model');
		$this->load->model(MODEL_LOKASI_WORKSHOP, 'lokasi_model');
	}
	
	public function index()
	{
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop());
		
		$jumlah_peserta_seminar = 0;
		$jumlah_peserta_pelatihan = 0;
		
		if ($this->input->get('kegiatan_id'))
		{
			$this->smarty->assign('lokasi_set', $this->lokasi_model->list_all($this->input->get('kegiatan_id')));
			
			$data_set = $this->peserta_model->list_all_by_reviewer(
				$this->input->get('lokasi_workshop_id'),
				$this->session->userdata('user')->reviewer_id
			);
			
			foreach ($data_set as &$data)
			{
				// Clean instagram username
				$data->username_ig = ltrim($data->username_ig, '@');
			}
			
			$this->smarty->assign('data_set', $data_set);
			
			$jumlah_peserta_seminar = $this->db
				->where('lokasi_workshop_id', $this->input->get('lokasi_workshop_id'))
				->where('ikut_seminar', '1')
				->count_all_results('peserta_workshop');
			
			$jumlah_peserta_pelatihan = $this->db
				->where('lokasi_workshop_id', $this->input->get('lokasi_workshop_id'))
				->where('ikut_pelatihan', '1')
				->count_all_results('peserta_workshop');
		}
		
		$this->smarty->assign('jumlah_peserta_seminar', $jumlah_peserta_seminar);
		$this->smarty->assign('jumlah_peserta_pelatihan', $jumlah_peserta_pelatihan);

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
	
	/**
	 * Ajax POST request set review
	 */
	public function set_review()
	{
		$peserta_id	= $this->input->post('peserta_id');
		$mode		= $this->input->post('mode');
		$status		= $this->input->post('status');
		
		if ($mode == 'seminar')
		{
			$result = $this->db->update('peserta_workshop', ['ikut_seminar' => $status], ['id' => $peserta_id]);
		}
		
		if ($mode == 'pelatihan')
		{
			$result = $this->db->update('peserta_workshop', ['ikut_pelatihan' => $status], ['id' => $peserta_id]);
		}
		
		echo ($result) ? '1' : '0';
	}
	
	public function get_peserta_seminar()
	{
		echo $this->db
			->where('lokasi_workshop_id', $this->input->post('lokasi_workshop_id'))
			->where('ikut_seminar', '1')
			->count_all_results('peserta_workshop');
	}
	
	public function get_peserta_pelatihan()
	{
		echo $this->db
			->where('lokasi_workshop_id', $this->input->post('lokasi_workshop_id'))
			->where('ikut_pelatihan', '1')
			->count_all_results('peserta_workshop');
	}
}
