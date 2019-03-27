<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property int $mahasiswa_id
 * @property Mahasiswa_model $mahasiswa
 */
class Anggota_proposal_model extends CI_Model
{	
	public function add(stdClass $model)
	{
		$result = $this->db->insert('anggota_proposal', $model);
		
		if ($result)
		{
			$model->id = $this->db->last_insert_id();
		}
		
		return $result;
	}
	
	public function is_sudah_terdaftar($mahasiswa_id, $kegiatan_id)
	{
		$count = $this->db
			->from('anggota_proposal a')
			->join('proposal p', 'p.id = a.proposal_id')
			->where('a.mahasiswa_id', $mahasiswa_id)
			->where('p.kegiatan_id', $kegiatan_id)
			->count_all_results();
		
		return ($count > 0);
	}
	
	public function get_ketua($proposal_id)
	{
		return $this->db->get_where('anggota_proposal', ['proposal_id' => $proposal_id, 'no_urut' => 1], 1)->row();
	}
	
	/**
	 * @param int $proposal_id
	 * @return Anggota_proposal_model[] 
	 */
	public function list_by_proposal($proposal_id)
	{
		return $this->db
			->order_by('no_urut')
			->get_where('anggota_proposal', ['proposal_id' => $proposal_id])->result();
	}
	
	public function delete_by_proposal($proposal_id)
	{
		return $this->db->delete('anggota_proposal', ['proposal_id' => $proposal_id]);
	}
}
