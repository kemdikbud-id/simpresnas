<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property LokasiWorkshop_model $lokasi_model 
 * @property PesertaWorkshop_model $peserta_model
 * @property ProposalWorkshop_model $proposal_workshop_model	
 * @property FileProposalWorkshop_model $file_workshop_model
 */
class Workshop extends Frontend_Controller
{
	// Ukuran maksimal upload
	const MAX_FILE_SIZE = 5242880;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model('Kegiatan_model', 'kegiatan_model');
		$this->load->model('LokasiWorkshop_model', 'lokasi_model');
		$this->load->model('PesertaWorkshop_model', 'peserta_model');
		$this->load->model('ProposalWorkshop_model', 'proposal_workshop_model');
		$this->load->model('FileProposalWorkshop_model', 'file_workshop_model');
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
	
	public function proposal()
	{
		$this->smarty->assign('data_set', $this->proposal_workshop_model->list_all_by_pt($this->session->perguruan_tinggi->id));
		$this->smarty->display();
	}
	
	public function add_proposal()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Inisialisasi file upload
			$this->load->library('upload', array(
				'allowed_types' => 'pdf',
				'max_size' => $this::MAX_FILE_SIZE, // 5 MB,
				'encrypt_name' => TRUE
			));
			
			// Start DB Transaction
			$this->db->trans_begin();
		
			// Create object proposal workshop
			$proposal_workshop = new stdClass();
			$proposal_workshop->perguruan_tinggi_id = $this->session->perguruan_tinggi->id;
			$proposal_workshop->judul = $this->input->post('judul');
			$proposal_workshop->lokasi_workshop_id = $this->input->post('lokasi_workshop_id');
			$proposal_workshop->created_at = date('Y-m-d H:i:s');
			
			$add_result = $this->proposal_workshop_model->add($proposal_workshop);
			
			// Set lokasi simpan
			$this->upload->upload_path = './upload/file-proposal/workshop/'.$this->session->user->username.'/';
			
			// Buat folder jika belum ada
			if ( ! file_exists($this->upload->upload_path))
			{
				if (mkdir($this->upload->upload_path, 0777, true) == false)
				{
					// jika create directory gagal, tampilkan error
					show_error("Permission denied : ".$this->upload->upload_path);
				}
			}
			
			// Jika upload berhasil
			if ($this->upload->do_upload('file'))
			{
				$data = $this->upload->data();
				
				// Create object file proposal
				$file_workshop = new stdClass();
				$file_workshop->proposal_workshop_id = $proposal_workshop->id;
				$file_workshop->nama_asli = $data['orig_name'];
				$file_workshop->nama_file = $data['file_name'];
				$file_workshop->created_at = date('Y-m-d H:i:s');
				
				$add_file_result = $this->file_workshop_model->add($file_workshop);
			}
			
			
			if ($add_result && $add_file_result)
			{
				// Commit transaction
				$this->db->trans_commit();
				
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Proposal Workshop',
					'message' => 'Penambahan proposal workshop berhasil !',
					'link_1' => '<a href="'.site_url('workshop/proposal').'" class="alert-link">Kembali ke daftar proposal</a>',
				));

				redirect(site_url('alert/success'));
			}
			else
			{
				// Rollback transaction
				$this->db->trans_rollback();
				
				// set message
				$this->session->set_flashdata('result', array(
					'page_title' => 'Tambah Proposal Workshop',
					'message' => 'Gagal menambahkan proposal workshop !',
					'link_1' => '<a href="'.site_url('workshop/proposal').'" class="alert-link">Kembali ke daftar proposal</a>',
				));

				redirect(site_url('alert/error'));
			}
			
			exit();
		}
		
		$this->smarty->assign('kegiatan_set', $this->kegiatan_model->list_workshop_aktif());
		$this->smarty->display();
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
	
	public function delete_proposal($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->db->trans_begin();
			
			$file_proposal = $this->file_workshop_model->get_by_proposal($id);
			
			// Jika ada filenya
			if ($file_proposal)
			{
				// Delete file
				@unlink('./upload/file-proposal/workshop/'.$this->session->user->username.'/'.$file_proposal->nama_file);
			}
			
			$this->file_workshop_model->delete($id);
			
			$this->proposal_workshop_model->delete($id);
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
				
				echo "1";
			}
			else
			{
				$this->db->trans_rollback();
				
				echo "0";
			}
		}
	}
}
