<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 * 
 * @property int $id 
 * @property int $program_id
 * @property int $tahun
 * @property int $proposal_per_pt
 * @property int $is_aktif
 */
class Kegiatan_model extends CI_Model
{	
	public function update($id)
	{
		$post = $this->input->post();
		
		$this->db->trans_start();
		
		// Building item to be update
		$kegiatan = new stdClass();
		$kegiatan->proposal_per_pt	= $this->input->post('proposal_per_pt');
		$kegiatan->tgl_awal_upload	= "{$post['awal_upload_Year']}-{$post['awal_upload_Month']}-{$post['awal_upload_Day']} {$post['awal_upload_HMS']}";
		$kegiatan->tgl_akhir_upload	= "{$post['akhir_upload_Year']}-{$post['akhir_upload_Month']}-{$post['akhir_upload_Day']} {$post['akhir_upload_HMS']}";
		$kegiatan->tgl_awal_review	= "{$post['awal_review_Year']}-{$post['awal_review_Month']}-{$post['awal_review_Day']} {$post['awal_review_HMS']}";
		$kegiatan->tgl_akhir_review	= "{$post['akhir_review_Year']}-{$post['akhir_review_Month']}-{$post['akhir_review_Day']} {$post['akhir_review_HMS']}";
		$kegiatan->tgl_pengumuman	= "{$post['pengumuman_Year']}-{$post['pengumuman_Month']}-{$post['pengumuman_Day']} {$post['pengumuman_HMS']}";
		$kegiatan->is_aktif			= $this->input->post('is_aktif');
		
		$this->db->update('kegiatan', $kegiatan, ['id' => $id]);
		
		// jika sedang mengaktifkan kegiatan, kegiatan yg lain utk program yg sama perlu dimatikan juga
		if ($kegiatan->is_aktif == '1')
		{
			// ambil id program
			$old_kegiatan = $this->db->select('program_id')->get_where('kegiatan', ['id' => $id], 1)->row();
			
			// nonaktifkan program yg sama selain yg akan di update
			$this->db->update('kegiatan', ['is_aktif' => 0], ['id <>' => $id, 'program_id' => $old_kegiatan->program_id]);
		}
		
		return $this->db->trans_complete();
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
	
	/**
	 * @param int $program_id
	 * @return Kegiatan_model
	 */
	public function get_aktif($program_id)
	{
		return $this->db->get_where('kegiatan', ['program_id' => $program_id, 'is_aktif' => 1], 1)->row();
	}
}
