<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class Tahapan_model extends CI_Model
{
	public function get_single($id)
	{
		return $this->db->get_where('tahapan', ['id' => $id])->row();
	}
	
	public function list_all_for_option()
	{
		$tahapan_set = $this
			->db
			->where('is_aktif', 1)
			->get('tahapan')->result_array();
		return array_column($tahapan_set, 'tahapan', 'id');
	}
}