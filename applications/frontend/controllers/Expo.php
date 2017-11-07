<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Proposal_model $proposal_model
 * @property File_proposal_model $file_proposal_model
 * @property File_expo_model $file_expo_model
 * @property Kegiatan_model $kegiatan_model
 * @property Program_model $program_model
 * @property Syarat_model $syarat_model
 * @property Anggota_proposal_model $anggota_proposal_model 
 */
class Expo extends Frontend_Controller
{
	const MAX_FILE_SIZE = 5242880;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'file_proposal_model');
		$this->load->model(MODEL_FILE_EXPO, 'file_expo_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROGRAM, 'program_model');
		$this->load->model(MODEL_SYARAT, 'syarat_model');
		$this->load->model(MODEL_ANGGOTA_PROPOSAL, 'anggota_proposal_model');
	}
	
	/**
	 * List daftar usaha yang ikut expo
	 */
	public function index()
	{
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_EXPO);
		$kegiatan->program = $this->program_model->get_single($kegiatan->program_id);
		$this->smarty->assign('kegiatan', $kegiatan);
		
		$file_expo = $this->file_expo_model->get_single($kegiatan->id, $this->session->perguruan_tinggi->id);
		$this->smarty->assign('file_expo', $file_expo);
		
		if ($this->input->method() == 'post')
		{
			// Inisialisasi file upload
			$this->load->library('upload', array(
				'allowed_types' => 'pdf',
				'max_size' => 5 * 1024, // 5 MB,
				'encrypt_name' => TRUE,
				'upload_path' => FCPATH.'upload/usulan-expo/'
			));
			
			// Coba upload dahulu, kemudian proses datanya
			if ($this->upload->do_upload('file1'))
			{
				$data_file = $this->upload->data();
				
				if ($file_expo == NULL)
				{
					$file_expo = new stdClass();
					$file_expo->created_at = date('Y-m-d H:i:s');
				}
				else
				{
					$file_expo->updated_at = date('Y-m-d H:i:s');
				}
				
				$file_expo->kegiatan_id = $kegiatan->id;
				$file_expo->perguruan_tinggi_id = $this->session->perguruan_tinggi->id;
				$file_expo->nama_file = $data_file['file_name'];
				$file_expo->nama_asli = $data_file['orig_name'];
				
				if ( ! isset($file_expo->id))
				{
					$this->file_expo_model->insert($file_expo);
				}
				else
				{
					$this->file_expo_model->update($file_expo->id, $file_expo);
				}
				
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Daftar Delegasi Expo KMI',
					'message' => 'Upload file berhasil',
					'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali</a>'
				));

				redirect(site_url('alert/success'));
			}
			else
			{
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Daftar Delegasi Expo KMI',
					'message' => 'Gagal upload file : ' . $this->upload->display_errors('' ,''),
					'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali</a>'
				));

				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$data_set = $this->proposal_model->list_proposal_expo($this->session->perguruan_tinggi->id);
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function submit($id)
	{
		// get proposal by perguruan tinggi
		$proposal = $this->proposal_model->get_single($id, $this->session->perguruan_tinggi->id);
		
		if ($proposal != NULL)
		{
			$this->proposal_model->submit($proposal->id);
			
			// set message
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar Delegasi Expo KMI',
				'message' => 'Submit usulan berhasil',
				'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali</a>'
			));

			redirect(site_url('alert/success'));
			
			exit();
		}
	}
	
	public function pilih_proposal()
	{
		$data_set = $this->db->query(
			"select proposal.id, judul, nama_kategori, nim_ketua, nama_ketua
			from proposal
			join kegiatan on kegiatan.id = proposal.kegiatan_id
			join program on program.id = kegiatan.program_id
			join kategori on kategori.id = proposal.kategori_id
			where
				proposal.is_didanai = 1 and
				proposal.kegiatan_id = ? and
				proposal.perguruan_tinggi_id = ? and
				proposal.id not in (select proposal_id from usaha_expo where proposal_id is not null)", 
			array(
				$this->session->kegiatan->id,
				$this->session->perguruan_tinggi->id
			))->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function add()
	{	
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$now = date('Y-m-d H:i:s');

			// Mendapatkan kegiatan expo yg aktif
			$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_EXPO);

			$proposal = new stdClass();
			$proposal->perguruan_tinggi_id	= $this->session->perguruan_tinggi->id;
			$proposal->is_kmi_award			= ($this->input->post('is_kmi_award') == '1') ? 1 : 0 ;
			$proposal->judul				= $this->input->post('judul');
			$proposal->kegiatan_id			= $kegiatan->id;
			$proposal->kategori_id			= $this->input->post('kategori_id');
			$proposal->nim_ketua			= $this->input->post('nim_ketua');
			$proposal->nama_ketua			= $this->input->post('nama_ketua');
			$proposal->created_at			= $now;

			$this->db->insert('proposal', $proposal);

			// get last insert id
			$proposal->id = $this->db->insert_id();

			// Proses anggota
			for ($i = 1; $i <= 5; $i++)
			{
				if (trim($this->input->post('nim_anggota_'.$i)) != '' && trim($this->input->post('nama_anggota_'.$i)) != '')
				{
					$anggota				= new stdClass();
					$anggota->proposal_id	= $proposal->id;
					$anggota->no_urut		= $i;
					$anggota->nim			= $this->input->post('nim_anggota_'.$i);
					$anggota->nama			= $this->input->post('nama_anggota_'.$i);
					$anggota->created_at	= $now;

					$this->db->insert('anggota_proposal', $anggota);
				}
			}

			// set message
			$this->session->set_flashdata('result', array(
				'page_title' => 'Tambah usulan untuk ikut Expo KMI',
				'message' => 'Penambahan sudah berhasil !',
				'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali ke daftar Expo</a>'
			));

			redirect(site_url('alert/success'));

			exit();
		}
		
		$kategori_set = $this->db->get_where('kategori', ['program_id' => $this->session->program_id])->result();
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		
		// get kegiatan aktif
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_EXPO);
		
		// cek apa sudah terdapat usulan kmi award
		$has_kmi_award = $this->proposal_model->has_kmi_award($kegiatan->id, $this->session->perguruan_tinggi->id);
		$this->smarty->assign('has_kmi_award', $has_kmi_award);
		
		$this->smarty->display();
	}
	
	public function edit($id)
	{
		// memastikan id sesuai dengan pt (menghindari hack)
		$proposal = $this->proposal_model->get_single($id, $this->session->perguruan_tinggi->id);
		$proposal->anggota_proposal_set = $this->anggota_proposal_model->list_by_proposal($proposal->id);
		$proposal->file_proposal_set = $this->file_proposal_model->list_by_proposal($proposal->id);
		
		if ($this->input->method() == 'post')
		{
			$this->db->trans_begin();
			
			$now = date('Y-m-d H:i:s');
			
			$proposal->is_kmi_award	= $this->input->post('is_kmi_award');
			$proposal->judul		= $this->input->post('judul');
			$proposal->kategori_id	= $this->input->post('kategori_id');
			$proposal->nim_ketua	= $this->input->post('nim_ketua');
			$proposal->nama_ketua	= $this->input->post('nama_ketua');
			$proposal->updated_at	= $now;
			
			$this->proposal_model->update($proposal->id, $proposal);
			
			// Iterasi tiap isian anggota
			for ($i = 1; $i <= 3; $i++)
			{
				// Jika isian tidak kosong, insert / update
				if (trim($this->input->post('nim_anggota_'.$i)) != '' && trim($this->input->post('nama_anggota_'.$i)) != '')
				{
					// Jika belum ada
					if ( ! isset($proposal->anggota_proposal_set[$i - 1]))
					{
						$anggota				= new stdClass();
						$anggota->proposal_id	= $proposal->id;
						$anggota->no_urut		= $i;
						$anggota->nim			= $this->input->post('nim_anggota_'.$i);
						$anggota->nama			= $this->input->post('nama_anggota_'.$i);
						$anggota->created_at	= $now;
						
						$this->db->insert('anggota_proposal', $anggota);
						
						$proposal->anggota_proposal_set[$i - 1] = $anggota;
					}
					else
					{
						$anggota				= $proposal->anggota_proposal_set[$i - 1];
						$anggota->nim			= $this->input->post('nim_anggota_'.$i);
						$anggota->nama			= $this->input->post('nama_anggota_'.$i);
						$anggota->updated_at	= $now;
						
						$this->db->update('anggota_proposal', $anggota, ['proposal_id' => $proposal->id, 'no_urut' => $i]);
					}
				}
			}
			
			$result = $this->db->trans_commit();
			
			if ($result)
			{
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Edit usulan untuk ikut Expo KMI',
					'message' => 'Edit berhasil !',
					'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali ke daftar Expo</a>'
				));

				redirect(site_url('alert/success'));

				exit();
			}
			else
			{
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Edit usulan untuk ikut Expo KMI',
					'message' => 'Edit gagal !',
					'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali ke daftar Expo</a>'
				));

				redirect(site_url('alert/error'));

				exit();
			}
		}
		
		// Iterasi tiap isian anggota
		for ($i = 1; $i <= 3; $i++)
		{
			// Jika kosong set null
			if ( ! isset($proposal->anggota_proposal_set[$i - 1]))
			{
				$proposal->anggota_proposal_set[$i - 1] = new stdClass();
				$proposal->anggota_proposal_set[$i - 1]->nim = NULL;
				$proposal->anggota_proposal_set[$i - 1]->nama = NULL;
			}
		}
		
		$this->smarty->assign('proposal', $proposal);
		
		$kategori_set = $this->db->get_where('kategori', ['program_id' => $this->session->program_id])->result();
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		
		// get kegiatan aktif
		$kegiatan = $this->kegiatan_model->get_aktif(PROGRAM_EXPO);
		
		// cek apa sudah terdapat usulan kmi award
		$has_kmi_award = $this->proposal_model->has_kmi_award($kegiatan->id, $this->session->perguruan_tinggi->id);
		$this->smarty->assign('has_kmi_award', $has_kmi_award);
		
		$this->smarty->display();
	}
	
	public function hapus($id)
	{
		// memastikan id sesuai dengan pt (menghindari hack)
		$proposal = $this->proposal_model->get_single($id, $this->session->perguruan_tinggi->id);
		
		if ($proposal != NULL)
		{
			$this->db->trans_begin();
			
			// delete file
			$this->file_proposal_model->delete_by_proposal($proposal->id);
			// delete anggota
			$this->anggota_proposal_model->delete_by_proposal($proposal->id);
			// delete proposal
			$this->proposal_model->delete($proposal->id, $this->session->perguruan_tinggi->id);
			
			$this->db->trans_commit();
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Daftar Usaha Expo KMI',
				'message' => 'Penghapusan data sudah berhasil !',
				'link_1' => '<a href="'.site_url('expo').'" class="alert-link">Kembali ke daftar Expo</a>'
			));

			redirect(site_url('alert/success'));
			
			exit();
		}
		
		redirect(site_url('expo'));
	}
}