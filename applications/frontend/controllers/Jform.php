<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property LokasiWorkshop_model $lokasi_model 
 * @property PesertaWorkshop_model $peserta_model
 */
class Jform extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_LOKASI_WORKSHOP, 'lokasi_model');
		$this->load->model(MODEL_PESERTA_WORKSHOP, 'peserta_model');
	}
	
	public function kbmi()
	{
		$this->smarty->display();
	}
	
	public function workshop()
	{
		if ($this->input->method() == 'post')
		{
			$add_result = $this->peserta_model->add_single();
			
			if ($add_result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Pendaftaran Workshop Rencana Bisnis',
					'message' => 'Pendaftaran workshop berhasil. Tunggu informasi pengumuman selanjutnya.<br/>'
					. 'Untuk informasi lebih lengkap silahkan download <a href="'.base_url('download/panduan_workshop_2019.pdf').'">Panduan Workshop</a>',
					'link_1' => '<a href="'.site_url().'" class="alert-link">Kembali ke halaman depan</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Pendaftaran Workshop Rencana Bisnis',
					'message' => 'Pendaftaran workshop gagal. Silahkan ulangi pendaftaran.',
					'link_1' => '<a href="'.site_url().'" class="alert-link">Kembali ke halaman depan</a>',
				));
				
				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$kegiatan = $this->kegiatan_model->get_by_program(PROGRAM_WORKSHOP, 2019);
		
		if ($kegiatan == null)
		{
			echo "Tidak ada kegiatan workshpo aktif. Hubungi Admin.<br/>";
			echo anchor(site_url(), 'Kembali ke halaman depan');
			exit();
		}
		
		$lokasi_set = $this->lokasi_model->list_all_aktif($kegiatan->id);
		
		// Pre process untuk format waktu pelaksanaan
		setlocale(LC_TIME, 'id_ID');
		foreach ($lokasi_set as &$lokasi)
		{
			$lokasi->waktu_pelaksanaan = strftime('%d %B %Y', strtotime($lokasi->waktu_pelaksanaan));
		}
		
		$this->smarty->assign('lokasi_set', $lokasi_set);
		
		$this->smarty->display();
	}
}
