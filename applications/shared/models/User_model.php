<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class User_model extends CI_Model
{
	public $id;
	public $username;
	public $password;
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
	
	/**
	 * @param int $id
	 * @return User_model 
	 */
	public function get_single($id)
	{
		return $this->db->get_where('user', ['id' => $id], 1)->row();
	}
	
	public function get_single_by_reviewer($reviewer_id)
	{
		return $this->db->get_where('user', ['reviewer_id' => $reviewer_id], 1)->row();
	}
	
	public function is_exist($username, $program_id, $tipe_user)
	{
		return $this->db
			->where(array(
				'username'		=> $username,
				'program_id'	=> $program_id,
				'tipe_user'		=> $tipe_user
			))->count_all_results('user') > 0;
	}
	
	public function list_user()
	{
		return $this->db
			->select('user.id, username, password, tipe_user, user.email, user.program_id, program.nama_program_singkat, perguruan_tinggi.nama_pt')
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
	
	public function login_failed($username, $password, $ip_address, $keterangan)
	{
		return $this->db->insert('login_failed', array(
			'username' => $username,
			'password' => $password,
			'ip_address' => $ip_address,
			'keterangan' => $keterangan
		));
	}
	
	public function change_password($user_id, $new_password)
	{
		return $this->db->update('user', array(
			'password'		=> $new_password,
			'password_hash'	=> sha1($new_password),
			'updated_at'	=> date('Y-m-d H:i:s')
		), ['id' => $user_id], 1);
	}
}
