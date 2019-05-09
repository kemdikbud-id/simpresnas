<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property RequestUser_model $requestuser_model
 * @property LembagaPengusul_model $lembaga_model
 * @property PerguruanTinggi_model $pt_model 
 * @property User_model $user_model
 * @property Kegiatan_model $kegiatan_model
 * @property Reviewer_model $reviewer_model 
 * @property Mahasiswa_model $mahasiswa_model 
 * @property Program_studi_model $program_studi_model
 */
class Auth extends Frontend_Controller
{
	const CAPTCHA_TIMEOUT = 7200;

	public function __construct()
	{
		parent::__construct();
		
		// Load default model
		$this->load->model(MODEL_REQUEST_USER, 'requestuser_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_LEMBAGA_PENGUSUL, 'lembaga_model');
		$this->load->model(MODEL_USER, 'user_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_REVIEWER, 'reviewer_model');
		$this->load->model(MODEL_MAHASISWA, 'mahasiswa_model');
		$this->load->model(MODEL_PROGRAM_STUDI, 'program_studi_model');
	}
	
	public function reg()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Inisialisasi file upload
			$this->load->library('upload', array(
				'allowed_types' => 'pdf',
				'max_size' => 5 * 1024, // 5 MB,
				'encrypt_name' => TRUE,
				'upload_path' => FCPATH.'upload/request-user/'
			));
					
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
	
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$captcha	= $this->input->post('captcha');
			
			// Ambil data user by username
			$user = $this->db->get_where('user', ['username' => $username], 1)->row();
			
			$expiration = time() - $this::CAPTCHA_TIMEOUT;
			
			// Hapus file captcha lama yang expired
			$captcha_set = $this->db->where('captcha_time < ', $expiration)->get('captcha')->result();
			foreach ($captcha_set as $captcha_row)
				@unlink('./assets/captcha/'.$captcha_row->filename);
			// Hapus record db
			$this->db->where('captcha_time < ', $expiration)->delete('captcha');
			
			// ambil data captcha
			$captcha_count = $this->db->query(
				"SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?",
				array($captcha, $this->input->ip_address(), $expiration))->row()->count;
			
			// Jika row ada
			if ($user != null)
			{
				// Bandingkan password
				if ($user->password_hash == sha1($password))
				{
					// jika captcha OK
					if ($captcha_count > 0)
					{
						// Ambil data perguruan tinggi
						$perguruan_tinggi = $this->pt_model->get_single($user->perguruan_tinggi_id);
						
						// Ambil kegiatan yang aktif
						$kegiatan = $this->kegiatan_model->get_aktif($user->program_id);

						// redirect
						if ($user->tipe_user == TIPE_USER_NORMAL)
						{
							$redirect_to = site_url('home');
						}
						else if ($user->tipe_user == TIPE_USER_REVIEWER)
						{
							// tambahkan session reviewer
							$user->reviewer = $this->reviewer_model->get_single($user->reviewer_id);
							$redirect_to = base_url() . 'reviewer';
						}
						else if ($user->tipe_user == TIPE_USER_MAHASISWA)
						{
							// tambahkan session mahasiswa
							$user->mahasiswa = $this->mahasiswa_model->get($user->mahasiswa_id);
							$user->mahasiswa->program_studi = $this->program_studi_model->get($user->mahasiswa->program_studi_id);
							$redirect_to = base_url() . 'mahasiswa';
						}
						else if ($user->tipe_user == TIPE_USER_ADMIN)
						{
							$redirect_to = base_url() . 'admin';
						}
						
						// Assign data login ke session
						$this->session->set_userdata('user', $user);
						$this->session->set_userdata('perguruan_tinggi', $perguruan_tinggi);
						$this->session->set_userdata('program_id', $user->program_id);
						$this->session->set_userdata('kegiatan', $kegiatan);
						
						// update latest login
						$this->db->update('user', array('latest_login' => date('Y-m-d H:i:s')), array('id' => $user->id));
						
						// end output after redirect
						redirect($redirect_to);
						exit();
					}
					else
					{	
						$this->user_model->login_failed($username, $password, $this->input->ip_address(), 'CAPTCHA_FAIL');
						$this->session->set_flashdata('failed_login', 'Isian captcha tidak sesuai. Silahkan ulangi login');
					}
				}
				else
				{
					$this->user_model->login_failed($username, $password, $this->input->ip_address(), 'WRONG_PASSWORD');
					$this->session->set_flashdata('failed_login', 'Password tidak sesuai. Silahkan ulangi login.');
				}
			}
			else
			{
				$this->user_model->login_failed($username, $password, $this->input->ip_address(), 'USER_NOT_FOUND');
				$this->session->set_flashdata('failed_login', 'Username tidak ditemukan. Silahkan ulangi login.');
			}
		}
		
		$this->smarty->assign('img_captcha', $this->get_captcha());
		
		$this->smarty->display();
	}
	
	/**
	 * POST /site/logout
	 */
	public function logout()
	{
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('perguruan_tinggi');
		$this->session->unset_userdata('program_id');
		$this->session->unset_userdata('kegiatan');

		// redirect to home
		redirect(base_url());
	}
	
	public function search_pt()
	{
		$term = $this->input->get('term');
		
		$result_set = $this->pt_model->list_by_fts($term);
		
		echo json_encode($result_set);
	}
	
	public function get_captcha()
	{		
		$this->load->helper('captcha');
			
		// Captcha Parameter
		$captcha_params = array(
			'img_path'		=> FCPATH . 'assets/captcha/',
			'img_url'		=> base_url('assets/captcha/'),
			'font_path'		=> FCPATH . 'assets/fonts/OpenSans-Semibold.ttf',
			'img_width'     => 180,
			'img_height'    => 60,
			'expiration'    => $this::CAPTCHA_TIMEOUT,
			'word_length'   => 4,
			'font_size'     => 28,
			'pool'          => '0123456789',
			'img_id'		=> time(),

			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(255, 255, 255),
					'border' => array(0, 0, 0),
					'text' => array(0, 0, 0),
					'grid' => array(rand(0, 255), rand(0, 255), rand(0, 255))
			)
		);
		
		$captcha = create_captcha($captcha_params);
		
		if ($captcha)
		{
			$data = array(
				'captcha_time'  => $captcha['time'],
				'ip_address'    => $this->input->ip_address(),
				'word'          => $captcha['word'],
				'filename'		=> $captcha['filename']
			);

			$this->db->insert('captcha', $data);

			return $captcha['image'];
		}
		else
		{
			return 'Captcha Error: GD Extension / Image Path Not Writeable';
		}
	}
}
