<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Kegiatan extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		$data_set = $this->db
			->select('kegiatan.*, program.nama_program')
			->from('kegiatan')
			->join('program', 'program.id = kegiatan.program_id')
			->get()
			->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function update($id)
	{
		$data = $this->db->get_where('kegiatan', array('id' => $id))->row();
		
		$this->smarty->display();
	}
}
