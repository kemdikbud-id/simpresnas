<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_Input $input
 * @property CI_DB_mysqli_driver $db
 * @property CI_DB_query_builder $db
 */
class RequestUser_model extends CI_Model
{
	public $id;
	public $perguruan_tinggi;
	public $program_id;
	public $nama_pengusul;
	public $jabatan_pengusul; 
	public $kontak_pengusul; 
	public $lembaga_pengusul_id;
	public $unit_lembaga; 
	public $email; 
	public $nama_file; 
	public $approved_at; 
	public $rejected_at;
	public $reject_message;
	public $created_at;
	
	public function list_request()
	{
		return $this->db
			->select('request_user.*, program.nama_program_singkat')
			->join('program', 'program.id = program_id')
			->where('approved_at IS NULL', NULL, FALSE)
			->where('rejected_at IS NULL', NULL, FALSE)
			->order_by('created_at ASC')
			->get('request_user')
			->result();
	}
	
	public function list_request_rejected()
	{
		return $this->db
			->where('approved_at IS NULL', NULL, FALSE)
			->where('rejected_at IS NOT NULL', NULL, FALSE)
			->order_by('created_at ASC')
			->get('request_user')
			->result();
	}
	
	public function list_request_approved()
	{
		return $this->db
			->where('approved_at IS NOT NULL', NULL, FALSE)
			->where('rejected_at IS NULL', NULL, FALSE)
			->order_by('created_at ASC')
			->get('request_user')
			->result();
	}

	public function insert()
	{
		$this->program_id			= $this->input->post('program_id');
		$this->perguruan_tinggi		= trim($this->input->post('perguruan_tinggi'));
		$this->lembaga_pengusul_id	= $this->input->post('lembaga_pengusul_id');
		$this->unit_lembaga			= $this->input->post('unit_lembaga');
		$this->nama_pengusul		= $this->input->post('nama_pengusul');
		$this->jabatan_pengusul		= $this->input->post('jabatan_pengusul');
		$this->kontak_pengusul		= $this->input->post('kontak_pengusul');
		$this->email				= $this->input->post('email');
		
		$this->created_at			= date('Y-m-d H:i:s');
		
		return $this->db->insert('request_user', $this);
	}
	
	/**
	 * @param int $id
	 * @return RequestUser_model
	 */
	public function get_single($id)
	{
		return $this->db->get_where('request_user', ['id' => $id], 1)->row();
	}
	
	public function approve($id)
	{
		return $this->db->update('request_user', array('approved_at' => date('Y-m-d H:i:s')), ['id' => $id]);
	}
	
	public function reject($id, $reject_message)
	{
		return $this->db->update('request_user', array(
			'rejected_at' => date('Y-m-d H:i:s'),
			'reject_message' => $reject_message
		), ['id' => $id]);
	}
}
