<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property RequestUser_model $requestuser_model
 * @property LembagaPengusul_model $lembaga_model
 * @property PerguruanTinggi_model $pt_model 
 */
class Auth extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// Load default model
		$this->load->model(MODEL_REQUEST_USER, 'requestuser_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_LEMBAGA_PENGUSUL, 'lembaga_model');
	}
	
	public function reg()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Inisialisasi file upload
			$this->load->library('upload', array(
				'allowed_types' => 'pdf',
				'max_size' => 5 * 1024, // 5 MB,
				'encrypt_name' => TRUE
			));
					
			$this->upload->upload_path = './upload/request-user/';
			
			// Coba upload dahulu, kemudian proses datanya
			if ($this->upload->do_upload('file1'))
			{
				$data = $this->upload->data();
				
				$this->requestuser_model->nama_file = $data['file_name'];
				$this->requestuser_model->insert();
				
				$this->session->set_flashdata('result', array(
					'page_title' => 'Registrasi Akun SIM-PKMI',
					'message'	=> 'Request user telah berhasil. Dokumen yang diupload akan diverifikasi oleh tim admin maksimal 1x24 jam. User login akan dikirimkan ke email : '.$this->input->post('email')
				));
				redirect(site_url('alert/success'));
			}
			else
			{
				$this->smarty->assign('error', array(
					'message' => 'Gagal upload file. ' . $this->upload->display_errors('' ,'')
				));
			}
		}
		
		$this->smarty->assign('lembaga_set', $this->lembaga_model->list_all());
		
		$this->smarty->display();
	}
	
	public function login($mode)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			
			// Jenis Program
			if ($mode == 'pbbt' || $mode == 'pbbt-reviewer') $program_id = PROGRAM_PBBT;
			if ($mode == 'kbmi' || $mode == 'kbmi-reviewer') $program_id = PROGRAM_KBMI;
			
			// Tipe User
			if ($mode == 'pbbt' || $mode == 'kbmi') $tipe_user = TIPE_USER_NORMAL;
			if ($mode == 'pbbt-reviewer' || $mode == 'kbmi-reviewer') $tipe_user = TIPE_USER_REVIEWER;
			
			$user = $this->db->get_where('user', array(
				'program_id' => $program_id,
				'username' => $username,
				'tipe_user' => $tipe_user
			))->row();
			
			// Jika row ada
			if ($user != null)
			{
				// Bandingkan password, temporari --> password
				if ($user->password_hash == sha1($password))
				//if ($password == 'password')
				{
					// Ambil data perguruan tinggi
					$perguruan_tinggi = $this->db->get_where('perguruan_tinggi', array('id' => $user->perguruan_tinggi_id))->row();
					
					// Assign data login ke session
					$this->session->set_userdata('user', $user);
					$this->session->set_userdata('perguruan_tinggi', $perguruan_tinggi);
					$this->session->set_userdata('program_id', $program_id);
					
					// redirect
					if ($tipe_user == TIPE_USER_NORMAL)
						redirect(site_url('home'));
					else if ($tipe_user == TIPE_USER_REVIEWER)
						redirect(site_url('reviewer'));
				}
			}
			
			$this->session->set_flashdata('failed_login', TRUE);
		}
		
		$judul_set = array(
			'pbbt' => 'Pendaftaran PBBT',
			'pbbt-reviewer' => 'Reviewer PBBT',
			'kbmi' => 'Pendaftaran KBMI',
			'kbmi-reviewer' => 'Reviewer KBMI'
		);
		
		$this->smarty->assign('judul', $judul_set[$mode]);
		
		$this->smarty->display();
	}
	
	/**
	 * POST /site/logout
	 */
	public function logout()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' or $_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->session->unset_userdata('user');
			$this->session->unset_userdata('program_id');
			
			// redirect to home
			redirect(base_url());
		}
	}
	
	public function search_pt()
	{
		$term = $this->input->get('term');
		
		$result_set = $this->pt_model->list_by_fts($term);
		
		echo json_encode($result_set);
	}
}
