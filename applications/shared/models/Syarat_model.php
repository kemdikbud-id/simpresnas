<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
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
}
