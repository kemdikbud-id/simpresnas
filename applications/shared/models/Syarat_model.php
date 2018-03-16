<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 */
class Syarat_model extends CI_Model
{
	public function list_by_kegiatan($kegiatan_id)
	{
		return $this->db
			->from('syarat')
			->where(['kegiatan_id' => $kegiatan_id])
			->order_by('urutan')
			->get()->result();
	}
	
	public function is_deletable($id)
	{
		return ($this->db->from('file_proposal')->where(['syarat_id' => $id])->count_all_results() === 0);
	}
	
	public function add()
	{
		$post = $this->input->post();
		
		$syarat					= new stdClass();
		$syarat->kegiatan_id	= $post['kegiatan_id'];
		$syarat->urutan			= $post['urutan'];
		$syarat->syarat			= $post['syarat'];
		$syarat->keterangan		= $post['keterangan'];
		$syarat->is_wajib		= $post['is_wajib'];
		
		return $this->db->insert('syarat', $syarat);
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('syarat', ['id' => $id], 1)->row();
	}
	
	public function update($id)
	{
		$post = $this->input->post();
		
		$syarat					= $this->get_single($id);
		$syarat->urutan			= $post['urutan'];
		$syarat->syarat			= $post['syarat'];
		$syarat->keterangan		= $post['keterangan'];
		$syarat->is_wajib		= $post['is_wajib'];
		
		return $this->db->update('syarat', $syarat, ['id' => $id]);
	}
}
