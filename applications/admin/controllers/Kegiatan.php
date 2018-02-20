<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Program_model $program_model
 * @property LokasiWorkshop_model $lokasi_model
 */
class Kegiatan extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
		$this->load->model('Program_model', 'program_model');
		$this->load->model('LokasiWorkshop_model', 'lokasi_model');
	}
	
	public function index()
	{
		$data_set = $this->kegiatan_model->list_all();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$add_result = $this->kegiatan_model->add();
			
			if ($add_result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Kegiatan',
					'message' => 'Berhasil menambah data',
					'link_1' => '<a href="'.site_url('kegiatan').'">Kembali ke master kegiatan</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Kegiatan',
					'message' => 'Gagal menambah data',
					'link_1' => '<a href="'.site_url('kegiatan').'">Kembali ke master kegiatan</a>',
				));
				
				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$this->smarty->assign('program_set', $this->program_model->list_all());
		
		$this->smarty->display();
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
	
	public function lokasi()
	{
		$kegiatan_id = $this->input->get('kegiatan_id');
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop());
		$this->smarty->assign('lokasi_set', $this->lokasi_model->list_all($kegiatan_id));
		
		$this->smarty->display();
	}
	
	public function add_lokasi()
	{
		$kegiatan_id = $this->input->get('kegiatan_id');
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$add_result = $this->lokasi_model->add();
			
			if ($add_result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Lokasi Workshop',
					'message' => 'Berhasil menambah data',
					'link_1' => '<a href="' . site_url('kegiatan/lokasi?kegiatan_id=' . $kegiatan_id) . '">Kembali ke master lokasi workshop</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Lokasi Workshop',
					'message' => 'Gagal menambah data',
					'link_1' => '<a href="' . site_url('kegiatan/lokasi?kegiatan_id=' . $kegiatan_id) . '">Kembali ke master lokasi workshop</a>',
				));
				
				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$this->smarty->assign('kegiatan', $this->kegiatan_model->get_single($kegiatan_id));
		
		$this->smarty->display();
	}
	
	public function edit_lokasi($id)
	{
		$lokasi = $this->lokasi_model->get_single($id);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$update_result = $this->lokasi_model->update($id);
			
			if ($update_result)
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Edit Lokasi Workshop',
					'message' => 'Berhasil mengupdate data',
					'link_1' => '<a href="' . site_url('kegiatan/lokasi?kegiatan_id=' . $lokasi->kegiatan_id) . '">Kembali ke master lokasi workshop</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->session->set_flashdata('result', array(
					'page_title' => 'Edit Lokasi Workshop',
					'message' => 'Gagal mengupdate data',
					'link_1' => '<a href="' . site_url('kegiatan/lokasi?kegiatan_id=' . $lokasi->kegiatan_id) . '">Kembali ke master lokasi workshop</a>',
				));
				
				redirect(site_url('alert/error'));
			}
			
			exit();
		}

		$kegiatan = $this->kegiatan_model->get_single($lokasi->kegiatan_id);
		
		$this->smarty->assign('data', $lokasi);
		$this->smarty->assign('kegiatan', $kegiatan);
		$this->smarty->display();
	}
}
