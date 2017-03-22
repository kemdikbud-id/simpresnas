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
	public $program_id;
	public $perguruan_tinggi;
	public $nama_pengusul;
	public $jabatan_pengusul; 
	public $kontak_pengusul; 
	public $unit_lembaga; 
	public $email; 
	public $nama_file; 
	public $approved_at; 
	public $rejected_at;
	public $created_at;
	
	public function list_request()
	{
		return $this->db
			->where('approved_at IS NULL', NULL, FALSE)
			->where('rejected_at IS NULL', NULL, FALSE)
			->get('request_user')
			->result();
	}

	public function insert()
	{
		$this->program_id		= $this->input->post('program_id');
		$this->perguruan_tinggi	= $this->input->post('perguruan_tinggi');
		$this->unit_lembaga		= $this->input->post('unit_lembaga');
		$this->nama_pengusul	= $this->input->post('nama_pengusul');
		$this->jabatan_pengusul	= $this->input->post('jabatan_pengusul');
		$this->kontak_pengusul	= $this->input->post('kontak_pengusul');
		$this->email			= $this->input->post('email');
		
		$this->created_at		= date('Y-m-d H:i:s');
		
		return $this->db->insert('request_user', $this);
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('request_user', ['id' => $id], 1)->row();
	}
	
	public function approve($id)
	{
		return $this->db->update('request_user', ['approved_at' => date('Y-m-d H:i:s')], ['id' => $id]);
	}
	
	public function reject($id)
	{
		return $this->db->update('request_user', ['rejected_at' => date('Y-m-d H:i:s')], ['id' => $id]);
	}
}
