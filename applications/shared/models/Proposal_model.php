<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property CI_DB_query_builder $db
 * @property int $id
 * @property int $perguruan_tinggi_id
 * @property string $judul
 * @property int $kegiatan_id
 * @property int $dosen_id
 * @property string $updated_at
 * @property Anggota_proposal_model $ketua
 * @property File_proposal_model[] $file_proposal_set
 * @property Anggota_proposal_model[] $anggota_proposal_set
 * @property Dosen_model $dosen
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
	
	public function list_by_perguruan_tinggi($perguruan_tinggi_id, $kegiatan_id)
	{
		return $this->db
			->select('p.id, p.judul, ap.mahasiswa_id, m.nim, m.nama, ps.nama as nama_program_studi, d.nama as nama_dosen, p.is_submited')
			->from('proposal p')
			->join('anggota_proposal ap', 'ap.proposal_id = p.id AND ap.no_urut = 1') // Ketua di No Urut 1
			->join('mahasiswa m', 'm.id = ap.mahasiswa_id')
			->join('program_studi ps', 'ps.id = m.program_studi_id')
			->join('dosen d', 'd.id = p.dosen_id', 'LEFT')
			->where(['p.perguruan_tinggi_id' => $perguruan_tinggi_id, 'kegiatan_id' => $kegiatan_id])
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
	
	/**
	 * @param int $mahasiswa_id
	 * @return Proposal_model
	 */
	public function get_by_ketua($kegiatan_id, $mahasiswa_id)
	{
		return $this->db
			->select('p.*')
			->from('proposal p')
			->join('anggota_proposal ap', 'ap.proposal_id = p.id AND ap.no_urut = 1')
			->where('p.kegiatan_id', $kegiatan_id)
			->where('ap.mahasiswa_id', $mahasiswa_id)
			->get()->row();
	}
	
	public function add(stdClass &$model)
	{
		$result = $this->db->insert('proposal', $model);
		$model->id = $this->db->insert_id();
		return $result;
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
			->select('proposal.id, nama_pt, nama_kategori, judul, is_submited, is_didanai, is_ditolak, keterangan_ditolak, is_kmi_award, fe.nama_file')
			->from('proposal')
			->join('kategori', 'kategori.id = kategori_id')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->join('file_expo fe', 'fe.kegiatan_id = proposal.kegiatan_id and fe.perguruan_tinggi_id = proposal.perguruan_tinggi_id', 'LEFT')
			->where(['proposal.kegiatan_id' => $kegiatan_id, 'is_submited' => 1])
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
	
	public function list_rekap_expo_pt()
	{
		// Kegiatan Expo Aktif
		$kegiatan_id = $this->db->get_where('kegiatan', ['program_id' => PROGRAM_EXPO, 'is_aktif' => 1], 1)->row()->id;
		
		return $this->db
			->select('npsn, nama_pt, sum(is_didanai) as jumlah_lolos, sum(is_ditolak) as jumlah_ditolak')
			->from('proposal')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->where(['proposal.kegiatan_id' => $kegiatan_id, 'is_submited' => 1])
			->group_by('npsn, nama_pt')
			->order_by('3 desc, npsn asc', null, FALSE)
			->get()->result();
	}
	
	public function list_rekap_expo_kategori()
	{
		// Kegiatan Expo Aktif
		$kegiatan_id = $this->db->get_where('kegiatan', ['program_id' => PROGRAM_EXPO, 'is_aktif' => 1], 1)->row()->id;
		
		return $this->db
			->select('nama_kategori, count(distinct if(is_didanai = 1, perguruan_tinggi_id, null)) as jumlah_pt, sum(is_didanai) as jumlah_lolos, sum(is_ditolak) as jumlah_ditolak')
			->from('proposal')
			->join('kategori', 'kategori.id = kategori_id')
			->where(['proposal.kegiatan_id' => $kegiatan_id, 'is_submited' => 1])
			->group_by('nama_kategori')
			->get()->result();
	}
	
	function update_dosen($perguruan_tinggi_id, $proposal_id, $dosen_id)
	{
		return $this->db->update('proposal', [
			'dosen_id' => $dosen_id,
			'updated_at' => date('Y-m-d H:i:s')
		], [
			'perguruan_tinggi_id' => $perguruan_tinggi_id,
			'id' => $proposal_id
		]);
	}
}
