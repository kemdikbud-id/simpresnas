<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class User_model extends CI_Model
{
	public $id;
	public $username;
	public $program_id;
	public $peruguran_tinggi_id;
	
	public function list_user()
	{
		return $this->db
			->select('user.*, program.nama_program, perguruan_tinggi.nama_pt')
			->from('user')
			->join('program', 'program.id = user.program_id')
			->join('perguruan_tinggi', 'user.perguruan_tinggi_id = perguruan_tinggi.id', 'LEFT')
			->where('tipe_user', TIPE_USER_NORMAL)
			->get()
			->result();
	}
	
	public function list_user_reviewer()
	{
		return $this->db
			->select('user.*, program.nama_program, perguruan_tinggi.nama_pt')
			->from('user')
			->join('program', 'program.id = user.program_id')
			->join('perguruan_tinggi', 'user.perguruan_tinggi_id = perguruan_tinggi.id', 'LEFT')
			->where('tipe_user', TIPE_USER_REVIEWER)
			->get()
			->result();
	}
}
