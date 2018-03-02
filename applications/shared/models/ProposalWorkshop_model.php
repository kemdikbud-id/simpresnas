<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property int $id
 * @property int $perguruan_tinggi_id
 * @property string $judul
 * @property int $lokasi_workshop_id
 */
class ProposalWorkshop_model extends CI_Model
{
	public function add(stdClass &$model)
	{
		$insert_result = $this->db->insert('proposal_workshop', $model);
		
		// get last insert id
		$model->id = $this->db->insert_id();
		
		return $insert_result;
	}
	
	public function get_single($id)
	{
		return $this->db->get_where('proposal_workshop', ['id' => $id], 1);
	}
	
	public function list_all_by_pt($pt_id = 0)
	{
		return $this->db
			->select('pw.id, pw.judul, lw.kota, fpw.nama_file, fpw.nama_asli')
			->from('proposal_workshop pw')
			->join('lokasi_workshop lw', 'lw.id = pw.lokasi_workshop_id')
			->join('file_proposal_workshop fpw', 'fpw.proposal_workshop_id = pw.id', 'LEFT')
			->where(['pw.perguruan_tinggi_id' => $pt_id])
			->get()->result();
	}
	
	public function list_all($lokasi_workshop_id)
	{
		return $this->db
			->select('pw.id, pt.nama_pt, pw.judul, user.username, fpw.nama_file')
			->from('proposal_workshop pw')
			->join('file_proposal_workshop fpw', 'fpw.proposal_workshop_id = pw.id')
			->join('perguruan_tinggi pt', 'pt.id = pw.perguruan_tinggi_id')
			->join('user', 'user.perguruan_tinggi_id = pt.id AND user.program_id = ' . PROGRAM_WORKSHOP)
			->where(['pw.lokasi_workshop_id' => $lokasi_workshop_id])
			->get()->result();
	}
	
	public function delete($id)
	{
		return $this->db->delete('proposal_workshop', ['id' => $id], 1);
	}
}
