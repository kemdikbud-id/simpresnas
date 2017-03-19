<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Proposal extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
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
		
		$kategori_set = $this->db->get_where('kategori', array('program_id' => $this->session->program_id))->result();
		$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		
		$this->smarty->assignForCombo('kategori_set', $kategori_set, 'id', 'nama_kategori');
		$this->smarty->assign('syarat_set', $syarat_set);
		
		$this->smarty->display();
	}
	
	private function _post_create()
	{
		$program_path = ($this->session->program_id == PROGRAM_PBBT) ? 'pbbt' : 'kbmi';
		
		// Inisialisasi file upload
		$this->load->library('upload', array(
			'allowed_types' => 'pdf',
			'max_size' => 5 * 1024 * 1024, // 5 MB,
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
		
		$syarat_set = $this->db->get_where('syarat', array('program_id' => $this->session->program_id))->result();
		
		// Set lokasi simpan
		$this->upload->upload_path = './upload/file-proposal/'.$program_path.'/'.$this->session->user->username.'/'.$proposal_id.'/';
		
		// Buat folder jika belum ada
		if ( ! file_exists($this->upload->upload_path))
			mkdir($this->upload->upload_path, 0777, true);
		
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
		
		$this->smarty->display();
	}
	
	public function result_message()
	{
		$this->smarty->display();
	}
}