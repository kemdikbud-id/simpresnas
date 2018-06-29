<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db 
 * @property CI_Input $input
 */
class Profil_kelompok_model extends CI_Model
{
	public $id;
	public $perguruan_tinggi_id;
	
	public $kategori_id;
	public $kategori_lain;
	public $sumber_pendanaan;
	public $nama_produk;
	public $gambaran_bisnis;
	public $capaian_bisnis;
	public $rencana_kedepan;
	public $prestasi_bisnis;
	public $file_anggota;
	public $file_produk;
	
	/**
	 * @param int $perguruan_tinggi_id
	 * @return Profil_kelompok_model
	 */
	public function get_single_by_pt($perguruan_tinggi_id, $is_kemenristek = 1, $kelompok_ke = 1)
	{
		$row = $this->db->get_where('profil_kelompok_usaha', [
			'perguruan_tinggi_id' => $perguruan_tinggi_id,
			'is_kemenristek' => $is_kemenristek,
			'kelompok_ke' => $kelompok_ke
		], 1)->row();
		
		// Jika tidak ada
		if ( ! $row)
		{
			// Insert baru
			$this->db->insert('profil_kelompok_usaha', [
				'perguruan_tinggi_id' => $perguruan_tinggi_id,
				'is_kemenristek' => $is_kemenristek,
				'kelompok_ke' => $kelompok_ke
			]);
			
			// Ambil recordnya
			$row = $this->db->get_where('profil_kelompok_usaha', [
				'perguruan_tinggi_id' => $perguruan_tinggi_id,
				'is_kemenristek' => $is_kemenristek,
				'kelompok_ke' => $kelompok_ke
			], 1)->row();
		}
		
		return $row;
	}
	
	public function update(stdClass $model, $id)
	{
		return $this->db->update('profil_kelompok_usaha', $model, ['id' => $id]);
	}
}
