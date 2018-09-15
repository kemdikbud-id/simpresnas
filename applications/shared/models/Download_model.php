<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 */
class Download_model extends CI_Model
{
	public function list_all()
	{
		return $this->db->get('download')->result();
	}
	
	public function add($filename)
	{
		$post = $this->input->post();
		
		$download = new stdClass();
		$download->judul = $post['judul'];
		$download->is_external = $post['is_external'];
		
		if ( ! $download->is_external)
			$download->nama_file = $filename;
		else
			$download->link = $post['link'];
		
		return $this->db->insert('download', $download);
	}
	
	public function get($id)
	{
		return $this->db->get_where('download', ['id' => $id])->first_row();
	}
	
	public function delete($id)
	{
		return $this->db->delete('download', ['id' => $id]);
	}
}
