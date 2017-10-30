<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property int $id
 * @property int $kegiatan_id
 * @property int $perguruan_tinggi_id
 * @property string $nama_file 
 * @property string $nama_asli 
 * @property string $created_at
 * @property string $updated_at
 */
class File_expo_model extends CI_Model
{
	/**
	 * @param int $kegiatan_id
	 * @param int $perguruan_tinggi_id
	 * @return File_expo_model 
	 */
	public function get_single($kegiatan_id, $perguruan_tinggi_id)
	{
		return $this->db->get_where('file_expo', ['kegiatan_id' => $kegiatan_id, 'perguruan_tinggi_id' => $perguruan_tinggi_id], 1)->row();
	}
	
	public function insert(stdClass $model)
	{
		return $this->db->insert('file_expo', $model);
	}
	
	public function update($id, stdClass $model)
	{
		return $this->db->update('file_expo', $model, ['id' => $id]);
	}
}
