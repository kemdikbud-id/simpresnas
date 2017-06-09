<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Reviewer_model extends CI_Model
{
	public function list_reviewer()
	{
		return $this->db
			->select('r.id, r.nama, r.kompetensi, ifnull(pt.nama_pt, r.asal_institusi) as asal, r.no_kontak, u.username, u.password')
			->from('reviewer r')
			->join('perguruan_tinggi pt', 'pt.id = r.perguruan_tinggi_id', 'LEFT')
			->join('user u', 'u.reviewer_id = r.id')
			->get()
			->result();
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('reviewer', ['id' => $id], 1)->row();
	}
	
	public function get_plot_single($plot_reviewer_id)
	{
		return $this->db->get_where('plot_reviewer', ['id' => $plot_reviewer_id])->row();
	}
}
