<?php
use GuzzleHttp\Client;

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Config $config
 * @property CI_DB_query_builder $db
 * @property Kegiatan_model $kegiatan_model
 * @property Program_studi_model $program_studi_model
 * @property Mahasiswa_model $mahasiswa_model 
 * @property User_model $user_model 
 * @property Proposal_model $proposal_model
 * @property Anggota_proposal_model $anggota_model
 * @property GuzzleHttp\Client $client
 */
class Proposal_KBMI extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROGRAM_STUDI, 'program_studi_model');
		$this->load->model(MODEL_MAHASISWA, 'mahasiswa_model');
		$this->load->model(MODEL_USER, 'user_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_ANGGOTA_PROPOSAL, 'anggota_model');
	}
	
	public function index()
	{
		$current_pt = $this->session->perguruan_tinggi;
		$kegiatan_aktif = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$data_set = $this->proposal_model->list_by_perguruan_tinggi($current_pt->id, $kegiatan_aktif->id);
		
		$this->smarty->assign('kegiatan', $kegiatan_aktif);
		$this->smarty->assign('data_set', $data_set);
		$this->smarty->display();
	}
	
	public function create()
	{
		$current_pt = $this->session->perguruan_tinggi;
		
		if ($this->input->post('mode') == 'search')
		{
			$error_type = '';
			
			// Algoritma :
			// 1 - Cari data mahasiswa dari database terlebih dahulu
			// 2 - Jika tidak ada, mengambil dari API Forlap
			
			$nim = trim($this->input->post('nim'));
			$mahasiswa = $this->mahasiswa_model->get_by_nim($current_pt->npsn, $nim);
			
			if ($mahasiswa != NULL)
			{
				// Ubah selected prodi-nya ke prodi yang benar sesuai input nim
				$_POST['program_studi_id'] = $mahasiswa->program_studi_id;
				
				// Ambil Informasi Program Studi
				$mahasiswa->program_studi = $this->program_studi_model->get($mahasiswa->program_studi_id);
			}
			else
			{
				// Ambil konfigurasi
				$this->config->load('pddikti');
				$pddikti_url = $this->config->item('pddikti_url');
				$pddikti_auth = $this->config->item('pddikti_auth');
				
				$this->client = new Client([
					'base_uri' => $pddikti_url,
					'headers' => [
						'Accept' => 'application/json',
						'Authorization' => 'Bearer ' . $pddikti_auth
					]
				]); 
				
				$program_studi = $this->program_studi_model->get($this->input->post('program_studi_id'));
				// Di cleansing 
				$program_studi->kode_prodi = trim($program_studi->kode_prodi);
				
				// Cari dari Forlap
				$response = $this->client->get("pt/{$current_pt->npsn}/prodi/{$program_studi->kode_prodi}/mahasiswa/{$nim}");
				
				if ($response->getStatusCode() == 200)
				{
					$body = $response->getBody();
					$mahasiswa_pddikti = json_decode($body);
					
					// cek jika mahasiswa sudah lulus
					if ($mahasiswa_pddikti[0]->terdaftar->tgl_keluar != '')
					{
						$error_type = "MHS_TIDAK_AKTIF";
						$mahasiswa = new stdClass();
						$mahasiswa->nim = $mahasiswa_pddikti[0]->terdaftar->nim;
						$mahasiswa->nama = $mahasiswa_pddikti[0]->nama;
					}
					else
					{
						// Insert Mahasiswa dari Pddikti
						$this->mahasiswa_model->insert_from_pddikti($mahasiswa_pddikti[0]);
						
						// di query ulang
						$mahasiswa = $this->mahasiswa_model->get_by_nim($current_pt->npsn, $nim);
						$mahasiswa->program_studi = $this->program_studi_model->get($mahasiswa->program_studi_id);
					}
				}
			}
			
			$this->smarty->assignByRef('mahasiswa', $mahasiswa);
			$this->smarty->assign('error_type', $error_type);
		}
		
		if ($this->input->post('mode') == 'add')
		{
			$this->load->helper('string');
			
			$mahasiswa_id = $this->input->post('mahasiswa_id');
			$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
			$mahasiswa = $this->mahasiswa_model->get($mahasiswa_id);
			$user = $this->user_model->get_single_by_mahasiswa($mahasiswa->id);
			
			// Jika user belum ada maka dibuatkan
			if ($user == NULL)
			{
				$user					= new User_model();
				$user->username			= $current_pt->npsn . '-' . $mahasiswa->nim; // kode pt + nim
				$user->password			= random_string('numeric', 6);
				$user->password_hash	= sha1($user->password);
				$user->mahasiswa_id		= $mahasiswa->id;
				$user->perguruan_tinggi_id = $current_pt->id;
				$user->tipe_user		= TIPE_USER_MAHASISWA;
				$user->program_id		= PROGRAM_KBMI;
				$user->created_at		= date('Y-m-d H:i:s');
				$this->user_model->create_user($user);
			}
			
			// Check apakah sudah terdaftar di proposal lain
			if ($this->anggota_model->is_sudah_terdaftar($mahasiswa_id, $kegiatan->id))
			{
				$this->session->set_flashdata('result', [
					'page_title' => 'Tambah Proposal Baru',
					'message' => 'Mahasiswa ini sudah didaftarkan.',
					'link_1' => anchor('proposal-kbmi/create', 'Kembali')
				]);
				
				redirect('alert/error');
				
				exit();
			}
			
			$this->db->trans_begin();
			
			$proposal = new stdClass();
			$proposal->perguruan_tinggi_id = $current_pt->id;
			$proposal->judul		= $this->input->post('judul');
			$proposal->kegiatan_id	= $kegiatan->id;
			$proposal->created_at	= date('Y-m-d H:i:s');
			$this->proposal_model->add($proposal);
			
			$anggota = new stdClass();
			$anggota->proposal_id	= $proposal->id;
			$anggota->no_urut		= 1;
			$anggota->mahasiswa_id	= $mahasiswa_id;
			$anggota->created_at	= date('Y-m-d H:i:s');
			$this->anggota_model->add($anggota);
			
			$mahasiswa->email		= $this->input->post('email');
			$mahasiswa->no_hp		= $this->input->post('no_hp');
			$mahasiswa->updated_at	= date('Y-m-d H:i:s');
			$this->mahasiswa_model->update($mahasiswa);
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				
				$this->session->set_flashdata('result', [
					'page_title' => 'Tambah Proposal Baru',
					'message' => 'Usulan berhasil ditambahkan',
					'link_1' => anchor('proposal-kbmi/index', 'Kembali ke Daftar Proposal')
				]);
				
				redirect('alert/success');

				exit();
			}
		}
		
		$this->smarty->assignForCombo('program_studi_set', $this->program_studi_model->list_by_pt($current_pt->npsn), 'id', 'nama');
		$this->smarty->display();
	}
	
	public function update($proposal_id)
	{
		$proposal = $this->proposal_model->get_single($proposal_id);
		$anggota = $this->anggota_model->get_ketua($proposal_id);
		$mahasiswa = $this->mahasiswa_model->get($anggota->mahasiswa_id);
		$mahasiswa->program_studi = $this->program_studi_model->get($mahasiswa->program_studi_id);
		
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('mahasiswa', $mahasiswa);
		$this->smarty->display();
	}
	
	public function send_login()
	{
		$mahasiswa_id = $this->input->post('mahasiswa_id');
		$mahasiswa = $this->mahasiswa_model->get($mahasiswa_id);
		$user = $this->user_model->get_single_by_mahasiswa($mahasiswa_id);
		
		$this->smarty->assign('username', $user->username);
		$this->smarty->assign('password', $user->password);
		$body = $this->smarty->fetch('email/login_mahasiswa.tpl');
		
		// Load Library
		$this->load->library('email');
		$this->config->load('email');
		
		// Kirim Email
		$this->email->from($this->config->item('smtp_user'), 'SIM-PKMI Ristekdikti');
		$this->email->to($mahasiswa->email);
		$this->email->subject('Informasi Akun SIM-PKMI');
		$this->email->message($body);
		$this->email->set_mailtype("html");
		$send_result = $this->email->send();

		$this->session->set_flashdata('result', array(
			'page_title' => 'Pengiriman Akun SIM-PKMI',
			'message' => 'Pengiriman login berhasil',
			'link_1' => '<a href="'.site_url('proposal-kbmi/index').'">Kembali</a>'
		));

		redirect(site_url('alert/success'));
	}
	
	public function delete($proposal_id)
	{
		if ($this->input->method() == 'post')
		{
			$current_pt = $this->session->perguruan_tinggi;
			$proposal_id = $this->input->post('proposal_id');
			
			$this->db->trans_begin();
			
			$this->anggota_model->delete_by_proposal($proposal_id);
			$this->proposal_model->delete($proposal_id, $current_pt->id);
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				
				$this->session->set_flashdata('result', array(
					'page_title' => 'Hapus Proposal',
					'message' => 'Proposal berhasil dihapus',
					'link_1' => '<a href="'.site_url('proposal-kbmi/index').'">Kembali</a>'
				));

				redirect(site_url('alert/success'));
				
				exit();
			}
		}
		
		$proposal = $this->proposal_model->get_single($proposal_id);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->display();
	}
}
