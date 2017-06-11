<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 */
class PlotReviewer_model extends CI_Model
{
	public function get_single($id)
	{
		return $this->db->get_where('plot_reviewer', ['id' => $id])->row();
	}
}