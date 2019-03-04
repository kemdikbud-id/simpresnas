<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class PesertaWorkshop_model extends CI_Model
{
	public function add()
	{
		$post = $this->input->post();
		
		$peserta_set = array();
		
		// Inputan tiap mahasiswa
		for ($i = 0; $i < count($post['nim']); $i++)
		{
			$peserta = new stdClass();
			$peserta->perguruan_tinggi_id = $post['perguruan_tinggi_id'];
			$peserta->lokasi_workshop_id = $post['lokasi_workshop_id'];
			$peserta->nim = $post['nim'][$i];
			$peserta->nama = $post['nama'][$i];
			$peserta->angkatan = $post['angkatan'][$i];
			$peserta->program_studi = $post['program_studi'][$i];
			
			$peserta_set[] = $peserta;
		}
		
		return $this->db->insert_batch('peserta_workshop', $peserta_set);
	}
	
	public function add_single()
	{
		$post = $this->input->post();
		
		$peserta = new stdClass();
		$peserta->nama					= trim($post['nama']);
		$peserta->perguruan_tinggi_id	= $post['perguruan_tinggi_id'];
		$peserta->program_studi			= $post['program_studi'];
		$peserta->nim					= $post['nim'];
		$peserta->angkatan				= $post['angkatan'];
		$peserta->email					= $post['email'];
		$peserta->no_hp					= $post['no_hp'];
		$peserta->username_ig			= $post['username_ig'];
		$peserta->lokasi_workshop_id	= $post['lokasi_workshop_id'];
		$peserta->noble_purpose			= $post['noble_purpose'];
		$peserta->tujuan_mulia			= $post['tujuan_mulia'];
		
		return $this->db->insert('peserta_workshop', $peserta);
	}
	
	public function list_all_by_lokasi($lokasi_workshop_id)
	{
		return $this->db
			->select('peserta_workshop.*, pt.nama_pt')
			->from('peserta_workshop')
			->join('lokasi_workshop', 'lokasi_workshop.id = peserta_workshop.lokasi_workshop_id')
			->join('perguruan_tinggi pt', 'peserta_workshop.perguruan_tinggi_id = pt.id')
			->where([
				'peserta_workshop.lokasi_workshop_id' => $lokasi_workshop_id
			])
			->get()->result();
	}
	
	public function list_all($perguruan_tinggi_id)
	{
		return $this->db
			->select('peserta_workshop.*, lokasi_workshop.kota, lokasi_workshop.tempat')
			->from('peserta_workshop')
			->join('lokasi_workshop', 'lokasi_workshop.id = peserta_workshop.lokasi_workshop_id')
			->join('kegiatan', 'kegiatan.id = lokasi_workshop.kegiatan_id')
			->where([
				'kegiatan.program_id' => PROGRAM_WORKSHOP, 
				'kegiatan.is_aktif' => 1, 
				'peserta_workshop.perguruan_tinggi_id' => $perguruan_tinggi_id
			])
			->order_by('peserta_workshop.id', 'ASC')
			->get()->result();
	}
	
	public function delete($id)
	{
		return $this->db->delete('peserta_workshop', ['id' => $id], 1);
	}
}
