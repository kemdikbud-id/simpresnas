<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 */
class Kegiatan extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
	}
	
	public function index()
	{
		$data_set = $this->kegiatan_model->list_all();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function add()
	{
		
	}
	
	public function update($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$result = $this->kegiatan_model->update($id);
			
			if ($result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Update Kegiatan',
					'message' => 'Berhasil mengupdate data',
					'link_1' => '<a href="'.site_url('kegiatan').'">Kembali ke master kegiatan</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Update Kegiatan',
					'message' => 'Gagal mengupdate data',
					'link_1' => '<a href="'.site_url('kegiatan/update/'.$id).'">Kembali</a>',
					'link_2' => '<a href="'.site_url('kegiatan').'">Kembali ke master kegiatan</a>',
				));
				
				redirect(site_url('alert/error'));
			}
		}
		
		$data = $this->kegiatan_model->get_single((int)$id);
		$this->smarty->assign('data', $data);
		
		$aktif_set = array(0 => 'NONAKTIF', 1 => 'AKTIF');
		$this->smarty->assign('aktif_set', $aktif_set);
		
		$this->smarty->display();
	}
}
