<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class TahapanProposal_model extends CI_Model
{
	public function get_single($id)
	{
		return $this->db->get_where('tahapan_proposal', ['id' => $id])->row();
	}
	
	public function insert(stdClass $model)
	{
		return $this->db->insert('tahapan_proposal', $model);
	}
}