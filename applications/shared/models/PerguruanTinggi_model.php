<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 */
class PerguruanTinggi_model extends CI_Model
{
	public $id;
	public $npsn;
	public $nama_pt;
	public $email_pt;
	
	public function list_all()
	{
		return $this->db->order_by('nama_pt')->get('perguruan_tinggi')->result();
	}
	
	/**
	 * Pencarian berbasis Full-Text Search
	 * @param string $nama_pt
	 */
	public function list_by_fts($nama_pt)
	{
		return $this->db
			->select('id, nama_pt as value')
			->from('perguruan_tinggi')
			->where("(nama_pt like '{$nama_pt}%' or nama_pt like '% {$nama_pt}%')", NULL, TRUE)	// full-text matching
			->limit(10)
			->get()
			->result_array();
	}
	
	/**
	 * @param int $id
	 * @return PerguruanTinggi_model
	 */
	public function get_single($id)
	{
		return $this->db->get_where('perguruan_tinggi', ['id' => $id])->row();
	}
	
	public function list_by_name($nama_pt)
	{
		$nama_pt = strtolower($nama_pt);
		
		return $this->db
			->select('*')->from('perguruan_tinggi')
			->where("trim(nama_pt) like '{$nama_pt}'", NULL, TRUE)
			->get()
			->result();
	}
}
