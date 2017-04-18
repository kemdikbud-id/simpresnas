<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class User_model extends CI_Model
{
	public $id;
	public $username;
	public $password_hash;
	public $password_reset_token;
	public $email;
	public $tipe_user;
	public $program_id;
	public $perguruan_tinggi_id;
	public $latest_login;
	public $status = 1;
	public $created_at;
	public $updated_at;
	
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
	
	public function create_user(User_model $user)
	{
		return $this->db->insert('user', $user);
	}
}
