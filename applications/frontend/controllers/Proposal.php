<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Proposal_model $proposal_model
 * @property File_proposal_model $file_proposal_model
 * @property Kegiatan_model $kegiatan_model
 * @property Program_model $program_model
 * @property Anggota_proposal_model $anggota_proposal_model 
 * @property TahapanProposal_model $tahapan_proposal_model Description
 */
class Proposal extends Frontend_Controller
{
	const MAX_FILE_SIZE = 5242880;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'file_proposal_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROGRAM, 'program_model');
		$this->load->model(MODEL_ANGGOTA_PROPOSAL, 'anggota_proposal_model');
		$this->load->model(MODEL_TAHAPAN_PROPOSAL, 'tahapan_proposal_model');
	}
	
	public function index()
	{
		
		$data_set = $this->db->query(
			"select 
				proposal.id, judul, nama_kategori, nim_ketua, nama_ketua, tp.id as tp_id,
				count(syarat.id) jumlah_syarat, 
				count(file_proposal.id) syarat_terupload,
				sum(syarat.is_wajib) syarat_wajib, 
				sum(if(syarat.is_wajib = 1 AND file_proposal.id IS NOT NULL, 1,0)) syarat_wajib_terupload
			from proposal
			join kegiatan on kegiatan.id = proposal.kegiatan_id
			join program on program.id = kegiatan.program_id
			join kategori on kategori.id = proposal.kategori_id
			join syarat on syarat.kegiatan_id = kegiatan.id
			left join file_proposal on file_proposal.proposal_id = proposal.id and file_proposal.syarat_id = syarat.id
			left join tahapan_proposal tp on tp.kegiatan_id = kegiatan.id AND tp.proposal_id = proposal.id and tp.tahapan_id = 1 /* Submit --> Tahapan Evaluasi Proposal */
			where
				proposal.kegiatan_id = ? and
				proposal.perguruan_tinggi_id = ?
			group by proposal.id, judul, nama_kategori, nim_ketua, nama_ketua, tp.id
			order by proposal.id", array(
				$this->session->kegiatan->id,
				$this->session->perguruan_tinggi->id
			))->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function create()
	{
		if ($this->input->method() == 'post') { $this->_post_create(); }
		
		// Cek maksimal upload per proposal
		$kegiatan = $this->kegiatan_model->get_aktif($this->session->program_id);
		
		if ($kegiatan != null)
		{
			$program = $this->program_model->get_single($kegiatan->program_id);
			$jumlah_proposal = $this->proposal_model->get_jumlah_per_pt($kegiatan->id, $this->session->perguruan_tinggi->id);
			
			if ($kegiatan->proposal_per_pt <= $jumlah_proposal)
			{
				$this->smarty->assign('kegiatan', $kegiatan);
				$this->smarty->assign('nama_program', $program->nama_program);
				$this->smarty->assign('tahun', $kegiatan->tahun);
				$this->smarty->display('proposal/create_unable.tpl'); 
				exit();
			}
		}
		else
		{
			// tidak ada kegiatan yg aktif pada program terpilih
			$this->smarty->assign('kegiatan', $kegiatan);
			$this->smarty->display('proposal/create_unable.tpl'); 
			exit();
		}
		
		$kategori_set = $this->db->get_where('kategori', ['program_id' => $this->session->program_id])->result();
		$syarat_set = $this->db->get_where('syarat', ['kegiatan_id' => $kegiatan->id])->result();
		
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		$this->smarty->assign('syarat_set', $syarat_set);
		
		if ($this->session->program_id == PROGRAM_PBBT)
			$this->smarty->display('proposal/create_pbbt.tpl');
		if ($this->session->program_id == PROGRAM_KBMI)
			$this->smarty->display('proposal/create_kbmi.tpl');
	}
	
	private function _post_create()
	{
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		
		// Inisialisasi file upload
		$this->load->library('upload', array(
			'allowed_types' => 'pdf',
			'max_size' => $this::MAX_FILE_SIZE, // 5 MB,
			'encrypt_name' => TRUE
		));
		
		$created_at = date('Y-m-d H:i:s');
		
		// Start transaksi
		$this->db->trans_begin();
		
		// Create object proposal
		$proposal = new stdClass();
		$proposal->perguruan_tinggi_id	= $this->session->perguruan_tinggi->id;
		$proposal->kegiatan_id			= $this->session->kegiatan->id;
		$proposal->judul				= $this->input->post('judul');
		$proposal->kategori_id			= $this->input->post('kategori_id');
		$proposal->nim_ketua			= $this->input->post('nim_ketua');
		$proposal->nama_ketua			= $this->input->post('nama_ketua');
		$proposal->created_at			= $created_at;
		
		// Insert Proposal
		$this->db->insert('proposal', $proposal);
		
		// Mendapatkan PK yg baru terinsert
		$proposal->id = $this->db->insert_id();
				
		for ($i_anggota = 1; $i_anggota <= 5; $i_anggota++)
		{
			// Jika isian tidak kosong 
			if ($this->input->post('nim_anggota')[$i_anggota] != '' && $this->input->post('nama_anggota')[$i_anggota] != '')
			{
				// Create object anggota
				$anggota = new stdClass();
				$anggota->proposal_id	= $proposal->id;
				$anggota->no_urut		= $i_anggota;
				$anggota->nim			= $this->input->post('nim_anggota')[$i_anggota];
				$anggota->nama			= $this->input->post('nama_anggota')[$i_anggota];
				$anggota->created_at	= $created_at;
				
				$this->db->insert('anggota_proposal', $anggota);
			}
		}
		
		// Set lokasi simpan
		$this->upload->upload_path = './upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$proposal->id.'/';
		
		// Buat folder jika belum ada
		if ( ! file_exists($this->upload->upload_path))
		{
			if (mkdir($this->upload->upload_path, 0777, true) == false)
			{
				// jika create directory gagal, tampilkan error
				show_error("Permission denied : ".$this->upload->upload_path);
				
				// Rollback transaction
				$this->db->trans_rollback();
			}
		}
		
		$syarat_set = $this->db->get_where('syarat', ['kegiatan_id' => $this->session->kegiatan->id])->result();
		
		// Baca tiap-tiap syarat
		foreach ($syarat_set as $syarat)
		{
			if ($this->upload->do_upload('file_syarat_'.$syarat->id))
			{
				$data = $this->upload->data();
				
				$this->db->insert('file_proposal', array(
					'proposal_id' => $proposal->id,
					'nama_asli' => $data['orig_name'],
					'nama_file' => $data['file_name'],
					'syarat_id' => $syarat->id
				));
			}
		}
		
		if ($this->db->trans_status() === TRUE)
		{
			// Commit transaction
			$this->db->trans_commit();
			
			// set message
			$this->session->set_flashdata('result', array(
				'page_title' => 'Tambah Proposal',
				'success_message' => 'Penambahan proposal sudah berhasil !',
				'link_1' => '<a href="'.site_url('proposal').'" class="alert-link">Kembali ke daftar proposal</a>',
				'link_2' => '<a href="'.site_url('proposal/create').'" class="alert-link">Tambah proposal lagi</a>',
			));
			
			redirect(site_url('proposal/result_message'));
			
			exit();
		}
	}
	
	public function update($id)
	{	
		if ($this->input->method() == 'post') { $this->_post_update($id); }
		
		$proposal_id = (int)$id;
		
		$kategori_set = $this->db->get_where('kategori', array('program_id' => $this->session->program_id))->result();
		
		$syarat_set = $this->db
			->select('syarat.id, syarat, keterangan, file.id as file_proposal_id, nama_asli, nama_file')
			->from('syarat')
			->join('file_proposal file', 'file.syarat_id = syarat.id AND file.proposal_id = '.$proposal_id, 'LEFT')
			->where(array(
				'syarat.kegiatan_id' => $this->session->kegiatan->id
			))->get()->result();
		
		// get proposal row
		$proposal = $this->db->get_where('proposal', array(
			'perguruan_tinggi_id' => $this->session->perguruan_tinggi->id,
			'id' => $proposal_id
		))->row();
		
		// get anggota proposal set, no urut as key
		foreach ($this->db->get_where('anggota_proposal', ['proposal_id' => $proposal->id])->result() as $anggota)
		{
			$anggota_set[$anggota->no_urut] = $anggota;
		}
		
		// build upload path
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		$upload_path = base_url("upload/file-proposal/{$program_path}/{$this->session->user->username}/{$proposal_id}/");
		
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		$this->smarty->assign('syarat_set', $syarat_set);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('anggota_set', $anggota_set);
		$this->smarty->assign('upload_path', $upload_path);
		
		if ($this->session->program_id == PROGRAM_PBBT)
			$this->smarty->display('proposal/update_pbbt.tpl');
		else if ($this->session->program_id == PROGRAM_KBMI)
			$this->smarty->display('proposal/update_kbmi.tpl');
	}
	
	private function _post_update($id)
	{
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		
		// Inisialisasi file upload
		$this->load->library('upload', array(
			'allowed_types' => 'pdf',
			'max_size' => $this::MAX_FILE_SIZE, // 5 MB,
			'encrypt_name' => TRUE
		));
		
		$updated_at = date('Y-m-d H:i:s');
		
		// Start transaksi
		$this->db->trans_begin();
		
		// Get row proposal
		$proposal = $this->db->get_where('proposal', ['id' => $id, 'perguruan_tinggi_id' => $this->session->perguruan_tinggi->id], 1)->row();
		
		// Update informasi proposal
		$proposal->judul			= $this->input->post('judul');
		$proposal->kategori_id		= $this->input->post('kategori_id');
		$proposal->nim_ketua		= $this->input->post('nim_ketua');
		$proposal->nama_ketua		= $this->input->post('nama_ketua');
		$proposal->updated_at		= $updated_at;
		
		// update informasi proposal
		$this->db->update('proposal', $proposal, ['id' => $proposal->id]);
		
		// Baca isian anggota
		for ($i_anggota = 1; $i_anggota <= 5; $i_anggota++)
		{
			$id_anggota		= $this->input->post('id_anggota')[$i_anggota];
			$nim_anggota	= $this->input->post('nim_anggota')[$i_anggota];
			$nama_anggota	= $this->input->post('nama_anggota')[$i_anggota];
			
			// Jika isian tidak kosong / salah satu ada isi
			if ($nim_anggota != '' || $nama_anggota != '')
			{
				// Jika sudah ada id, update data
				if ($id_anggota != '')
				{
					// Create object anggota
					$anggota = new stdClass();
					$anggota->proposal_id	= $proposal->id;
					$anggota->no_urut		= $i_anggota;
					$anggota->nim			= $this->input->post('nim_anggota')[$i_anggota];
					$anggota->nama			= $this->input->post('nama_anggota')[$i_anggota];
					$anggota->updated_at	= $updated_at;

					$this->db->update('anggota_proposal', $anggota, ['id' => $this->input->post('id_anggota')[$i_anggota]], 1);
				}
				else // jika belum ada id, insert
				{
					// Create object anggota
					$anggota = new stdClass();
					$anggota->proposal_id	= $proposal->id;
					$anggota->no_urut		= $i_anggota;
					$anggota->nim			= $this->input->post('nim_anggota')[$i_anggota];
					$anggota->nama			= $this->input->post('nama_anggota')[$i_anggota];
					$anggota->created_at	= $updated_at;
					
					$this->db->insert('anggota_proposal', $anggota);
				}
			}
			
			// Jika isian kosong semua, tetapi punya id
			else if ($nim_anggota == '' && $nama_anggota == '' && $id_anggota != '')
			{
				// delete data
				$this->db->delete('anggota_proposal', ['id' => $id_anggota], 1);
			}
		}
				
		$this->upload->upload_path = './upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$proposal->id.'/';
		
		// Buat folder jika belum ada
		if ( ! file_exists($this->upload->upload_path))
		{
			if (mkdir($this->upload->upload_path, 0777, true) == false)
			{
				// jika create directory gagal, tampilkan error
				show_error("Permission denied : ".$this->upload->upload_path);
				
				// Rollback transaction
				$this->db->trans_rollback();
			}
		}
		
		$syarat_set = $this->db->get_where('syarat', array('kegiatan_id' => $proposal->kegiatan_id))->result();
		
		// Baca tiap-tiap syarat
		foreach ($syarat_set as $syarat)
		{
			if ($this->upload->do_upload('file_syarat_'.$syarat->id))
			{
				$data = $this->upload->data();
				
				$file_row_exist = $this->db->where(array(
					'proposal_id' => $proposal->id,
					'syarat_id' => $syarat->id
				))->count_all_results('file_proposal') > 0;
				
				// if file record exist : update
				if ($file_row_exist)
				{
					$this->db->update('file_proposal', array(
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name']
					), array('proposal_id' => $proposal->id, 'syarat_id' => $syarat->id));
				}
				else // update
				{
					$this->db->insert('file_proposal', array(
						'proposal_id' => $proposal->id,
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name'],
						'syarat_id' => $syarat->id
					));
				}
			}
		}
		
		if ($this->db->trans_status() === TRUE)
		{
			// Commit transaction
			$this->db->trans_commit();
			
			// set message
			$this->session->set_flashdata('result', array(
				'page_title' => 'Update Proposal',
				'success_message' => 'Update proposal sudah berhasil !',
				'link_1' => '<a href="'.site_url('proposal').'" class="alert-link">Kembali ke daftar proposal</a>',
				'link_2' => null
			));
			
			redirect(site_url('proposal/result_message'));
		}
	}
	
	public function delete($id)
	{
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		
		// cleansing
		$id = (int)$id;
		
		if ($this->input->method() == 'post')
		{
			$this->db->trans_start();
			
			// Ambil list file proposal
			$file_proposal_set = $this->file_proposal_model->list_by_proposal($id);
			
			// delete tiap file
			foreach ($file_proposal_set as $file)
			{
				if (file_exists('./upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$id.'/'.$file->nama_file))
				{
					unlink('./upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$id.'/'.$file->nama_file);
				}
			}
			
			// delete row file proposal
			$this->file_proposal_model->delete_by_proposal($id);
			
			// delete row anggota proposal
			$this->anggota_proposal_model->delete_by_proposal($id);
			
			// delete proposal
			$this->proposal_model->delete($id, $this->session->perguruan_tinggi->id);
			
			$this->db->trans_commit();
			
			$this->session->set_flashdata('result', array(
				'page_title' => 'Hapus Proposal',
				'message' => 'Proposal berhasil di hapus',
				'link_1' => '<a href="'.site_url('proposal/index').'">Kembali ke Daftar Proposal</a>'
			));
			
			redirect(site_url('alert/success'));
		}
		
		$data = $this->proposal_model->get_single($id, $this->session->perguruan_tinggi->id);
		
		$this->smarty->assign('data', $data);
		
		$this->smarty->display();
	}
	
	public function result_message()
	{
		$this->smarty->display();
	}
	
	public function submit($id = 0)
	{
		$proposal_id = (int)$id;
		
		$proposal = $this->proposal_model->get_single($proposal_id, $this->session->perguruan_tinggi->id);
		
		if ($this->input->method() == 'post')
		{
			$this->db->trans_begin();
			
			$tahapan_proposal = new stdClass();
			$tahapan_proposal->kegiatan_id	= $proposal->kegiatan_id;
			$tahapan_proposal->proposal_id	= $proposal->id;
			$tahapan_proposal->tahapan_id	= TAHAPAN_EVALUASI;
			$tahapan_proposal->nilai_akhir	= 0;
			$tahapan_proposal->created_at	= date('Y-m-d H:i:s');
			
			// Insert Tahapan
			$this->tahapan_proposal_model->insert($tahapan_proposal);

			$proposal->is_submited = 1;
			
			// Update status proposal
			$this->proposal_model->update($proposal_id, $proposal);			
			
			if ($this->db->trans_status() === TRUE)
			{
				$this->db->trans_commit();
			
				$this->session->set_flashdata('result', array(
					'page_title' => 'Submit Proposal',
					'message' => 'Proposal berhasil di submit',
					'link_1' => '<a href="'.site_url('proposal/index').'">Kembali ke Daftar Proposal</a>'
				));

				redirect(site_url('alert/success'));
			}
			
			exit();
		}
		
		$this->smarty->assign('data', $proposal);
		$this->smarty->display();
	}
}