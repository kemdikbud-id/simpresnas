<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 */
class LembagaPengusul_model extends CI_Model
{
	public function list_all()
	{
		return $this->db->get('lembaga_pengusul')->result();
	}
}
