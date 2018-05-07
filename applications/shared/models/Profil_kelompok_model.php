<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class Profil_kelompok_model extends CI_Model
{
	public $id;
	public $perguruan_tinggi_id;
	
	/**
	 * @param int $perguruan_tinggi_id
	 * @return Profil_kelompok_model
	 */
	public function get_single_by_pt($perguruan_tinggi_id)
	{
		$row = $this->db->get_where('profil_kelompok_usaha', ['perguruan_tinggi_id' => $perguruan_tinggi_id], 1)->row();
		
		if ( ! $row)
		{
			$result = $this->db->insert('profil_kelompok_usaha', ['perguruan_tinggi_id' => $perguruan_tinggi_id]);
			
			$row = $this->db->get_where('profil_kelompok_usaha', ['perguruan_tinggi_id' => $perguruan_tinggi_id], 1)->row();
		}
		
		return $row;
	}
	
	public function update(stdClass $model, $id)
	{
		return $this->db->update('profil_kelompok_usaha', $model, ['id' => $id]);
	}
}
