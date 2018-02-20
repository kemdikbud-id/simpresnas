<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property LokasiWorkshop_model $lokasi_model 
 * @property PesertaWorkshop_model $peserta_model
 */
class Workshop extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
		$this->load->model('LokasiWorkshop_model', 'lokasi_model');
		$this->load->model('PesertaWorkshop_model', 'peserta_model');
	}
	
	public function index()
	{
		$this->smarty->assign('peserta_set', $this->peserta_model->list_all($this->session->perguruan_tinggi->id));
		$this->smarty->display();
	}
	
	public function add_peserta()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$add_result = $this->peserta_model->add();
			
			if ($add_result)
			{
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Mahasiswa Peserta Workshop',
					'message' => 'Penambahan peserta workshop berhasil !',
					'link_1' => '<a href="'.site_url('workshop').'" class="alert-link">Kembali ke daftar peserta</a>',
				));

				redirect(site_url('alert/success'));
			}
			else
			{
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Mahasiswa Peserta Workshop',
					'message' => 'Gagal menambahkan peserta workshop !',
					'link_1' => '<a href="'.site_url('workshop').'" class="alert-link">Kembali ke daftar peserta</a>',
				));

				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop_aktif());
		$this->smarty->display();
	}
	
	/**
	 * Ajax Request
	 */
	public function data_lokasi($id = 0)
	{
		// Pre process untuk format waktu pelaksanaan
		$lokasi_set = $this->lokasi_model->list_all_aktif($id);
		
		foreach ($lokasi_set as &$lokasi)
		{
			$lokasi->waktu_pelaksanaan = strftime('%d %B %Y', strtotime($lokasi->waktu_pelaksanaan));
		}
		
		echo json_encode($lokasi_set);
	}
	
	public function jadwal()
	{
		$kegiatan_set = $this->kegiatan_model->list_workshop_aktif();
		
		foreach ($kegiatan_set as &$kegiatan)
		{
			$kegiatan->lokasi_set = $this->lokasi_model->list_all($kegiatan->id);
		}
		
		$this->smarty->assign('kegiatan_set', $kegiatan_set);
		$this->smarty->display();
	}
	
	public function delete_peserta($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$delete_result = $this->peserta_model->delete($id);
			
			echo $delete_result ? "1" : "0";
		}
	}
}
