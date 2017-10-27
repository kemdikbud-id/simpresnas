<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class Anggota_proposal_model extends CI_Model
{	
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
