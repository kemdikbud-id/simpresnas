<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 */
class Kelas_presentasi_model extends CI_Model
{
	public function list_all_for_option($kegiatan_id)
	{
		$kelas_presentasi_set = $this->db
			->where('kegiatan_id', $kegiatan_id)
			->get('kelas_presentasi')->result_array();
		
		return array_column($kelas_presentasi_set, 'nama_kelas', 'id');
	}
}
