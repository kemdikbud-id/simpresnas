<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Download_model $download_model
 */
class Download extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('download_model');
	}
	
	public function index()
	{
		$data_set = $this->download_model->list_all();
		$this->smarty->assign('data_set', $data_set);
		$this->smarty->display();
	}
	
	public function add()
	{
		if ($this->input->method() == 'post')
		{
			// Inisialisasi file upload
			$this->load->library('upload', [
				'upload_path' => './../download/',
				'allowed_types' => ['pdf','doc','docx']
			]);
			
			if ($this->upload->do_upload('file'))
			{
				$upload_data = $this->upload->data();
				
				$this->download_model->add($upload_data['file_name']);
				
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Download File',
					'message' => 'Berhasil menambah data',
					'link_1' => '<a href="'.site_url('download').'">Kembali ke Master Download File</a>',
				));
				
				redirect(site_url('alert/success'));
			}
			else
			{
				$upload_error = $this->upload->display_errors('', '');
				
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Download File',
					'message' => 'Gagal menambah data. ' . $upload_error,
					'link_1' => '<a href="'.site_url('download').'">Kembali ke Download File</a>',
				));
				
				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		// get max upload size
		$upload_max_filesize = ini_get('upload_max_filesize');
		$this->smarty->assign('upload_max_filesize', $upload_max_filesize);
		
		$this->smarty->display();
	}
	
	public function delete($id)
	{
		$data = $this->download_model->get($id);
		
		if ($this->input->method() == 'post')
		{
			if ( ! $data->is_external)
				unlink('./../download/'.$data->nama_file);
			
			$this->download_model->delete($id);
			
			$this->session->set_flashdata('result', array(
					'page_title' => 'Hapus Download File',
					'message' => 'Berhasil menghapus data',
					'link_1' => '<a href="'.site_url('download').'">Kembali ke Master Download File</a>',
				));
				
			redirect(site_url('alert/success'));
				
			exit();
		}
		
		$this->smarty->assign('data', $data);
		
		$this->smarty->display();
	}
}
