<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 */
class Expo extends Admin_Controller
{	
	public function index()
	{
		
		$data_set = $this->db->query(
			"select u.id, nama_usaha, nama_kategori, nama_pt, is_lolos_expo, proposal_id,
				(select count(*) from anggota_usaha_expo a where a.usaha_expo_id = u.id) as jumlah_anggota
			from usaha_expo u
			join kategori on kategori.id = u.kategori_id
			join perguruan_tinggi on perguruan_tinggi.id = u.perguruan_tinggi_id
			where is_ditolak = 0")->result();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}