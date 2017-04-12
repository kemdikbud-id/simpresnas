<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class Kegiatan_model extends CI_Model
{	
	public function update($id)
	{
		$post = $this->input->post();
		
		// Building item to be update
		$kegiatan = new stdClass();
		$kegiatan->proposal_per_pt	= $this->input->post('proposal_per_pt');
		$kegiatan->tgl_awal_upload	= "{$post['awal_upload_Year']}-{$post['awal_upload_Month']}-{$post['awal_upload_Day']} {$post['awal_upload_HMS']}";
		$kegiatan->tgl_akhir_upload	= "{$post['akhir_upload_Year']}-{$post['akhir_upload_Month']}-{$post['akhir_upload_Day']} {$post['akhir_upload_HMS']}";
		$kegiatan->tgl_awal_review	= "{$post['awal_review_Year']}-{$post['awal_review_Month']}-{$post['awal_review_Day']} {$post['awal_review_HMS']}";
		$kegiatan->tgl_akhir_review	= "{$post['akhir_review_Year']}-{$post['akhir_review_Month']}-{$post['akhir_review_Day']} {$post['akhir_review_HMS']}";
		$kegiatan->tgl_pengumuman	= "{$post['pengumuman_Year']}-{$post['pengumuman_Month']}-{$post['pengumuman_Day']} {$post['pengumuman_HMS']}";
		
		return $this->db->update('kegiatan', $kegiatan, ['id' => $id]);
	}
	
	public function list_all()
	{
		return $this->db
			->select('kegiatan.*, program.nama_program')
			->from('kegiatan')
			->join('program', 'program.id = kegiatan.program_id')
			->get()
			->result();
	}
	
	public function get_single($id)
	{
		return $this->db
			->select('kegiatan.*, program.nama_program')
			->from('kegiatan')
			->join('program', 'program.id = kegiatan.program_id')
			->where('kegiatan.id', $id)
			->get()
			->row();
	}
}
