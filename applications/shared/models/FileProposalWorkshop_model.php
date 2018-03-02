<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property CI_DB_mysqli_driver $db
 * @property int $id
 * @property int $proposal_workshop_id
 * @property string $nama_file
 * @property string $nama_asli
 */
class FileProposalWorkshop_model extends CI_Model
{
	public function add(stdClass $model)
	{
		return $this->db->insert('file_proposal_workshop', $model);
	}
	
	public function delete($proposal_workshop_id)
	{
		return $this->db->delete('file_proposal_workshop', ['proposal_workshop_id' => $proposal_workshop_id]);
	}
	
	/**
	 * @param int $proposal_workshop_id
	 * @return FileProposalWorkshop_model
	 */
	public function get_by_proposal($proposal_workshop_id)
	{
		return $this->db->get_where('file_proposal_workshop', ['proposal_workshop_id' => $proposal_workshop_id], 1)->row();
	}
}
