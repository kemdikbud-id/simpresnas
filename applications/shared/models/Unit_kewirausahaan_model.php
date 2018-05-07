<?php

/**
 * Description of Unit_kewirausahaan_model
 *
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class Unit_kewirausahaan_model extends CI_Model
{
	public $id;
	public $perguruan_tinggi_id;
	
	/**
	 * @param int $perguruan_tinggi_id
	 * @return Unit_kewirausahaan_model
	 */
	public function get_single_by_pt($perguruan_tinggi_id)
	{
		$row = $this->db->get_where('unit_kewirausahaan', ['perguruan_tinggi_id' => $perguruan_tinggi_id], 1)->row();
		
		// Jika belum ada
		if ( ! $row)
		{
			// insert 1 row
			$this->db->insert('unit_kewirausahaan', ['perguruan_tinggi_id' => $perguruan_tinggi_id]);
			
			// ambil lagi
			$row = $this->db->get_where('unit_kewirausahaan', ['perguruan_tinggi_id' => $perguruan_tinggi_id], 1)->row();
		}
		
		return $row;
	}
	
	public function update(stdClass $model, $id)
	{
		return $this->db->update('unit_kewirausahaan', $model, ['id' => $id]);
	}
}
