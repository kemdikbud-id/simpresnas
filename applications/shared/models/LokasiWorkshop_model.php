<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 * @property int $id
 * @property int $kegiatan_id
 * @property string $kota
 * @property string $tempat
 * @property string $waktu_pelaksanaan
 * @property string $tgl_awal_registrasi
 * @property string $tgl_akhir_registrasi
 */
class LokasiWorkshop_model extends CI_Model
{
	public function add()
	{
		$post = $this->input->post();
		
		$lokasi = new stdClass();
		$lokasi->kegiatan_id = $post['kegiatan_id'];
		$lokasi->kota = $post['kota'];
		$lokasi->tempat	= $post['tempat'];
		$lokasi->waktu_pelaksanaan = "{$post['waktu_pelaksanaan_Year']}-{$post['waktu_pelaksanaan_Month']}-{$post['waktu_pelaksanaan_Day']}";
		$lokasi->tgl_awal_registrasi = "{$post['awal_registrasi_Year']}-{$post['awal_registrasi_Month']}-{$post['awal_registrasi_Day']} {$post['awal_registrasi_time']}";
		$lokasi->tgl_akhir_registrasi = "{$post['akhir_registrasi_Year']}-{$post['akhir_registrasi_Month']}-{$post['akhir_registrasi_Day']} {$post['akhir_registrasi_time']}";
		
		return $this->db->insert('lokasi_workshop', $lokasi);
	}
	
	public function update($id)
	{
		$post = $this->input->post();
		
		$lokasi = $this->get_single($id);
		$lokasi->kegiatan_id = $post['kegiatan_id'];
		$lokasi->kota = $post['kota'];
		$lokasi->tempat	= $post['tempat'];
		$lokasi->waktu_pelaksanaan = "{$post['waktu_pelaksanaan_Year']}-{$post['waktu_pelaksanaan_Month']}-{$post['waktu_pelaksanaan_Day']}";
		$lokasi->tgl_awal_registrasi = "{$post['awal_registrasi_Year']}-{$post['awal_registrasi_Month']}-{$post['awal_registrasi_Day']} {$post['awal_registrasi_time']}";
		$lokasi->tgl_akhir_registrasi = "{$post['akhir_registrasi_Year']}-{$post['akhir_registrasi_Month']}-{$post['akhir_registrasi_Day']} {$post['akhir_registrasi_time']}";
		
		return $this->db->update('lokasi_workshop', $lokasi, ['id' => $id]);
	}
	
	/**
	 * @param int $id
	 * @return LokasiWorkshop_model
	 */
	public function get_single($id)
	{
		return $this->db->get_where('lokasi_workshop', ['id' => $id], 1)->row();
	}
	
	public function list_all($kegiatan_id)
	{
		return $this->db
			->order_by('waktu_pelaksanaan ASC')
			->get_where('lokasi_workshop', ['kegiatan_id' => $kegiatan_id])->result();
	}
	
	public function list_all_aktif($kegiatan_id)
	{
		return $this->db
			->from('lokasi_workshop')
			->where('NOW() between tgl_awal_registrasi AND tgl_akhir_registrasi', NULL, FALSE)
			->where(['kegiatan_id' => $kegiatan_id])
			->order_by('waktu_pelaksanaan ASC')
			->get()->result();
	}
}
