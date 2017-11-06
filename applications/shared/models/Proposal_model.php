<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property int $id
 * @property int $perguruan_tinggi_id
 * @property string $judul
 * @property File_proposal_model[] $file_proposal_set
 * @property Anggota_proposal_model[] $anggota_proposal_set
 */
class Proposal_model extends CI_Model
{
	public function list_all_per_kegiatan($kegiatan_id)
	{
		return $this->db
			->select("p.id, p.judul, pt.nama_pt, ktg.nama_kategori, p.nim_ketua, p.nama_ketua, p.created_at")
			->select('count(s.id) as jumlah_syarat, sum(s.is_wajib) as syarat_wajib', FALSE)
			->select('count(fp.id) as syarat_terupload, sum(if(s.is_wajib = 1 AND fp.id IS NOT NULL, 1,0)) as syarat_wajib_terupload', FALSE)
			->from('proposal p')
			->join('kegiatan k', 'k.id = p.kegiatan_id')
			->join('perguruan_tinggi pt', 'pt.id = p.perguruan_tinggi_id')
			->join('kategori ktg', 'ktg.id = p.kategori_id')
			->join('syarat s', 's.kegiatan_id = k.id', 'LEFT')
			->join('file_proposal fp', 'fp.proposal_id = p.id AND fp.syarat_id = s.id', 'LEFT')
			->where(['p.kegiatan_id' => $kegiatan_id])
			->group_by("p.id, p.judul, pt.nama_pt, ktg.nama_kategori, p.nim_ketua, p.nama_ketua, p.created_at")
			->get()->result();
	}
	
	/**
	 * Mengambil satu data Proposal
	 * @param int $id
	 * @param int $perguruan_tinggi_id Harus ada untuk tampilan frontend sebagai pengaman
	 * @return Proposal_model 
	 */
	public function get_single($id, $perguruan_tinggi_id = NULL)
	{
		$this->db->where(['id' => $id]);
		if ($perguruan_tinggi_id != NULL) $this->db->where(['perguruan_tinggi_id' => $perguruan_tinggi_id]);
		return $this->db->get('proposal', 1)->row();
	}
	
	public function update($id, stdClass $model)
	{
		return $this->db->update('proposal', $model, ['id' => $id]);
	}
	
	public function delete($id, $perguruan_tinggi_id = NULL)
	{
		if ($perguruan_tinggi_id != NULL)
		{
			return $this->db->delete('proposal', array(
				'id' => $id,
				'perguruan_tinggi_id' => $perguruan_tinggi_id
			), 1);
		}
	}
	
	/**
	 * Jumlah proposal per kegiatan per perguruan tinggi
	 * @param int $kegiatan_id
	 * @param int $perguruan_tinggi_id
	 * @return int 
	 */
	public function get_jumlah_per_pt($kegiatan_id, $perguruan_tinggi_id)
	{
		return $this->db->from('proposal p')
			->join('kegiatan k', 'k.id = p.kegiatan_id')
			->where(array(
				'kegiatan_id' => $kegiatan_id,
				'perguruan_tinggi_id' => $perguruan_tinggi_id
			))
			->count_all_results();
	}
	
	public function list_proposal_per_reviewer($kegiatan_id, $tahapan_id, $reviewer_id)
	{
		$sql = 
			"select pr.id, p.judul, pt.nama_pt, pr.biaya_rekomendasi, pr.nilai_reviewer
			from plot_reviewer pr
			join tahapan_proposal tp on tp.id = pr.tahapan_proposal_id
			join proposal p on p.id = tp.proposal_id
			join perguruan_tinggi pt on pt.id = p.perguruan_tinggi_id
			where tp.kegiatan_id = ? and tp.tahapan_id = ? and pr.reviewer_id = ?
			order by p.judul";
		return $this->db->query($sql, array(
			$kegiatan_id, $tahapan_id, $reviewer_id
		))->result();
	}
	
	public function list_proposal_expo($perguruan_tinggi_id)
	{
		// Kegiatan Expo Aktif
		$kegiatan_id = $this->db->get_where('kegiatan', ['program_id' => PROGRAM_EXPO, 'is_aktif' => 1], 1)->row()->id;
		
		return $this->db
			->select('proposal.id, judul, nama_kategori, is_submited, is_didanai, is_ditolak, is_kmi_award')
			->from('proposal')
			->join('kategori', 'kategori.id = kategori_id')
			->where(['perguruan_tinggi_id' => $perguruan_tinggi_id, 'kegiatan_id' => $kegiatan_id])
			->get()->result();
	}
	
	public function list_all_proposal_expo()
	{
		// Kegiatan Expo Aktif
		$kegiatan_id = $this->db->get_where('kegiatan', ['program_id' => PROGRAM_EXPO, 'is_aktif' => 1], 1)->row()->id;
		
		return $this->db
			->select('proposal.id, nama_pt, nama_kategori, judul, is_submited, is_didanai, is_ditolak, is_kmi_award')
			->from('proposal')
			->join('kategori', 'kategori.id = kategori_id')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->where(['kegiatan_id' => $kegiatan_id, 'is_submited' => 1])
			->order_by('nama_pt', 'asc')
			->get()->result();
	}
	
	public function submit($id)
	{
		return $this->db->update('proposal', [
			'is_submited' => 1,
			'updated_at' => date('Y-m-d H:i:s')
		], ['id' => $id]);
	}
	
	public function has_kmi_award($kegiatan_id, $perguruan_tinggi_id)
	{
		$this->db->where(array(
			'kegiatan_id' => $kegiatan_id, 
			'perguruan_tinggi_id' => $perguruan_tinggi_id,
			'is_kmi_award' => 1
		));
		
		$count = $this->db->count_all_results('proposal');
		
		return ($count > 0);
	}
}
