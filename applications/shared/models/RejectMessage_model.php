<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class RejectMessage_model extends CI_Model
{
	public function list_all()
	{
		return $this->db->get('reject_message')->result();
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('reject_message', array('id' => $id))->row();
	}
}
