<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * 
 * @property int $id
 * @property int $perguruan_tinggi_id 
 * @property string $nim
 * @property string $nama
 * @property int $program_studi_id
 * @property Program_studi_model $program_studi 
 */
class Mahasiswa_model extends CI_Model
{
	function get($id)
	{
		return $this->db->get_where('mahasiswa', ['id' => $id])->row();
	}
	
	function update(stdClass $model)
	{
		return $this->db->update('mahasiswa', $model, ['id' => $model->id]);
	}
	
	/**
	 * @param string $npsn Kode Perguruan Tinggi
	 * @param string $nim NIM Mahasiswa
	 * @return Mahasiswa_model
	 */
	function get_by_nim($npsn, $nim)
	{
		return $this->db
			->select('m.*')
			->from('mahasiswa m')
			->join('perguruan_tinggi pt', 'pt.id = m.perguruan_tinggi_id')
			->where('pt.npsn', $npsn)
			->where('m.nim', $nim)
			->get()->first_row();
	}
	
	function insert_from_pddikti($param)
	{
		// get perguruan tinggi id
		$pt = $this->db->get_where('perguruan_tinggi', ['npsn' => $param->terdaftar->kode_pt])->row();
		
		// get program studi id
		$program_studi = $this->db->get_where('program_studi', [
			'perguruan_tinggi_id' => $pt->id,
			'kode_prodi' => $param->terdaftar->kode_prodi
		])->row();
		
		return $this->db->insert('mahasiswa', [
			'perguruan_tinggi_id' => $pt->id,
			'nim' => trim($param->terdaftar->nim),
			'nama' => $param->nama,
			'program_studi_id' => $program_studi->id,
			'angkatan' => strftime('%Y', strtotime($param->terdaftar->tgl_masuk)),
			'email' => $param->email,
			'no_hp' => $param->handphone,
			'id_pdpt' => strtolower($param->id),
			'created_at' => date('Y-m-d H:i:s')
		]);
	}
}
