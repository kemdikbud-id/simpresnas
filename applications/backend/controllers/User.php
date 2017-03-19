<?php

/**
 * Description of User
 *
 * @author Fathoni
 */
class User extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		$data_set = $this->db
			->select('user.*, program.nama_program, perguruan_tinggi.nama_pt')
			->from('user')
			->join('program', 'program.id = user.program_id')
			->join('perguruan_tinggi', 'user.perguruan_tinggi_id = perguruan_tinggi.id', 'LEFT')
			->get()
			->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}
