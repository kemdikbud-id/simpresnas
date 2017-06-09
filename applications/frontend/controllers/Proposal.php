<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Proposal_model $proposal_model
 * @property FileProposal_model $fileproposal_model
 * @property Kegiatan_model $kegiatan_model
 * @property Program_model $program_model
 */
class Proposal extends Frontend_Controller
{
	const MAX_FILE_SIZE = 5242880;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'fileproposal_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PROGRAM, 'program_model');
	}
	
	public function index()
	{
		$data_set = $this->db
			->select('proposal.*, kategori.nama_kategori')
			->from('proposal')
			->join('kategori', 'kategori.id = proposal.kategori_id')
			->where(array(
				'proposal.program_id' => $this->session->program_id,
				'proposal.perguruan_tinggi_id' => $this->session->perguruan_tinggi->id
			))->get()->result();
		
		$data_set = $this->db->query(
			"select 
				proposal.id, judul, nama_kategori, nim_ketua, nama_ketua,
				count(syarat.id) jumlah_syarat, 
				count(file_proposal.id) syarat_terupload,
				sum(syarat.is_wajib) syarat_wajib, 
				sum(if(syarat.is_wajib = 1 AND file_proposal.id IS NOT NULL, 1,0)) syarat_wajib_terupload
			from proposal
			join program on program.id = proposal.program_id
			join kategori on kategori.id = proposal.kategori_id
			join syarat on syarat.program_id = program.id
			left join file_proposal on file_proposal.proposal_id = proposal.id and file_proposal.syarat_id = syarat.id
			where
				proposal.program_id = ? and
				proposal.perguruan_tinggi_id = ?
			group by proposal.id, judul, nama_kategori, nim_ketua, nama_ketua
			order by proposal.id", array(
				$this->session->program_id,
				$this->session->perguruan_tinggi->id
			))->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { $this->_post_create(); }
		
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
		
		$kategori_set = $this->db->get_where('kategori', array('program_id' => $this->session->program_id))->result();
		$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		
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
		
		// Start transaksi
		$this->db->trans_start();
		
		// Insert Proposal
		$this->db->insert('proposal', array(
			'perguruan_tinggi_id' => $this->session->perguruan_tinggi->id,
			'program_id' => $this->session->program_id,
			'judul' => $this->input->post('judul'),
			'kategori_id' => $this->input->post('kategori_id'),
			'nim_ketua' => $this->input->post('nim_ketua'),
			'nama_ketua' => $this->input->post('nama_ketua'),
			'nim_anggota_1' => $this->input->post('nim_anggota_1'),
			'nama_anggota_1' => $this->input->post('nama_anggota_1'),
			'nim_anggota_2' => $this->input->post('nim_anggota_2'),
			'nama_anggota_2' => $this->input->post('nama_anggota_2'),
			'nim_anggota_3' => $this->input->post('nim_anggota_3'),
			'nama_anggota_3' => $this->input->post('nama_anggota_3'),
			'nim_anggota_4' => $this->input->post('nim_anggota_4'),
			'nama_anggota_4' => $this->input->post('nama_anggota_4'),
			'nim_anggota_5' => $this->input->post('nim_anggota_5'),
			'nama_anggota_5' => $this->input->post('nama_anggota_5'),
		));
		
		// Mendapatkan PK yg baru terinsert
		$proposal_id = $this->db->insert_id();
		
		// Set lokasi simpan
		$this->upload->upload_path = './upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$proposal_id.'/';
		
		// Buat folder jika belum ada
		if ( ! file_exists($this->upload->upload_path))
		{
			if (mkdir($this->upload->upload_path, 0777, true) == false)
			{
				// jika create directory gagal, tampilkan error
				show_error("Permission denied : ".$this->upload->upload_path);
			}
		}
		
		$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		
		// Baca tiap-tiap syarat
		foreach ($syarat_set as $syarat)
		{
			if ($this->upload->do_upload('file_syarat_'.$syarat->id))
			{
				$data = $this->upload->data();
				
				$this->db->insert('file_proposal', array(
					'proposal_id' => $proposal_id,
					'nama_asli' => $data['orig_name'],
					'nama_file' => $data['file_name'],
					'syarat_id' => $syarat->id
				));
			}
		}
		
		if ($this->db->trans_complete())
		{
			// set message
			$this->session->set_flashdata('result', array(
				'page_title' => 'Tambah Proposal',
				'success_message' => 'Penambahan proposal sudah berhasil !',
				'link_1' => '<a href="'.site_url('proposal').'" class="alert-link">Kembali ke daftar proposal</a>',
				'link_2' => '<a href="'.site_url('proposal/create').'" class="alert-link">Tambah proposal lagi</a>',
			));
			
			redirect(site_url('proposal/result_message'));
		}
	}
	
	public function update($id)
	{	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { $this->_post_update($id); }
		
		$proposal_id = (int)$id;
		
		$kategori_set = $this->db->get_where('kategori', array('program_id' => $this->session->program_id))->result();
		//$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		$syarat_set = $this->db
			->select('syarat.id, syarat, keterangan, file.id as file_proposal_id, nama_asli, nama_file')
			->from('syarat')
			->join('file_proposal file', 'file.syarat_id = syarat.id AND file.proposal_id = '.$proposal_id, 'LEFT')
			->where(array(
				'syarat.program_id' => $this->session->program_id
			))->get()->result();
		
		// get proposal row
		$proposal = $this->db->get_where('proposal', array(
			'perguruan_tinggi_id' => $this->session->perguruan_tinggi->id,
			'id' => $proposal_id
		))->row();
		
		// build upload path
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		$upload_path = base_url("upload/file-proposal/{$program_path}/{$this->session->user->username}/{$proposal_id}/");
		
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		$this->smarty->assign('syarat_set', $syarat_set);
		$this->smarty->assign('proposal', $proposal);
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
		
		// Start transaksi
		$this->db->trans_start();
		
		// update informasi proposal
		$this->db->update('proposal', array(
			'judul' => $this->input->post('judul'),
			'kategori_id' => $this->input->post('kategori_id'),
			'nim_ketua' => $this->input->post('nim_ketua'),
			'nama_ketua' => $this->input->post('nama_ketua'),
			'nim_anggota_1' => $this->input->post('nim_anggota_1'),
			'nama_anggota_1' => $this->input->post('nama_anggota_1'),
			'nim_anggota_2' => $this->input->post('nim_anggota_2'),
			'nama_anggota_2' => $this->input->post('nama_anggota_2'),
			'nim_anggota_3' => $this->input->post('nim_anggota_3'),
			'nama_anggota_3' => $this->input->post('nama_anggota_3'),
			'nim_anggota_4' => $this->input->post('nim_anggota_4'),
			'nama_anggota_4' => $this->input->post('nama_anggota_4'),
			'nim_anggota_5' => $this->input->post('nim_anggota_5'),
			'nama_anggota_5' => $this->input->post('nama_anggota_5'),
		), array('id' => $id));
		
		$proposal_id = $id;
		
		$this->upload->upload_path = './upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$proposal_id.'/';
		
		// Buat folder jika belum ada
		if ( ! file_exists($this->upload->upload_path))
		{
			if (mkdir($this->upload->upload_path, 0777, true) == false)
			{
				// jika create directory gagal, tampilkan error
				show_error("Permission denied : ".$this->upload->upload_path);
			}
		}
		
		$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		
		// Baca tiap-tiap syarat
		foreach ($syarat_set as $syarat)
		{
			if ($this->upload->do_upload('file_syarat_'.$syarat->id))
			{
				$data = $this->upload->data();
				
				$file_row_exist = $this->db->where(array(
					'proposal_id' => $proposal_id,
					'syarat_id' => $syarat->id
				))->count_all_results('file_proposal') > 0;
				
				// if file record exist : update
				if ($file_row_exist)
				{
					$this->db->update('file_proposal', array(
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name']
					), array('proposal_id' => $proposal_id, 'syarat_id' => $syarat->id));
				}
				else // update
				{
					$this->db->insert('file_proposal', array(
						'proposal_id' => $proposal_id,
						'nama_asli' => $data['orig_name'],
						'nama_file' => $data['file_name'],
						'syarat_id' => $syarat->id
					));
				}
			}
		}
		
		if ($this->db->trans_complete())
		{
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
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->db->trans_start();
			
			// Ambil list file proposal
			$file_proposal_set = $this->fileproposal_model->list_by_proposal($id);
			
			// delete tiap file
			foreach ($file_proposal_set as $file)
				unlink('./upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$id.'/'.$file->nama_file);
			
			// delete row file proposal
			$this->fileproposal_model->delete_by_proposal($id);
			
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
}