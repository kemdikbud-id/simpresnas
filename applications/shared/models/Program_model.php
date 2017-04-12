<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Program_model extends CI_Model
{
	/**
	 * @var int 
	 */
	public $id;
	
	/**
	 * @var string 
	 */
	public $nama_program;
	
	/**
	 * @param int $id
	 * @return mixed 
	 */
	public function get_single($id)
	{
		$this->db->get_where('program', ['id' => $id], 1)->row();
	}
}
