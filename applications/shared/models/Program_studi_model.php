<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * 
 * @property int $id 
 * @property string $kode_prodi
 * @property string $nama
 */
class Program_studi_model extends CI_Model
{
	function list_by_pt($npsn)
	{
		return $this->db->select('ps.id, ps.kode_prodi, ps.nama')
			->from('program_studi ps')
			->join('perguruan_tinggi pt', 'pt.id = ps.perguruan_tinggi_id')
			->where('pt.npsn', $npsn)
			->order_by('ps.nama')
			->get()->result();
	}
	
	/**
	 * @param int $id
	 * @return Program_studi_model
	 */
	function get($id)
	{
		return $this->db->get_where('program_studi', ['id' => $id])->row();
	}
}
