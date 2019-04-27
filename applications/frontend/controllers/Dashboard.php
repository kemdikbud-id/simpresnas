<?php

/**
 * @author Fathoni
 */
class Dashboard extends Frontend_Controller
{
	public function index()
	{
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		
		// Ambil kegiatan yang aktif
		$kegiatan_kbmi = $this->kegiatan_model->get_aktif(PROGRAM_KBMI);
		$kegiatan_workshop = $this->kegiatan_model->get_aktif(PROGRAM_WORKSHOP);
		
		// --------------------------
		// Jumlah-Jumlah
		// --------------------------
		$jumlah = array();
		$jumlah['proposal_submit'] = $this->get_jumlah_proposal_submit($kegiatan_kbmi);
		$jumlah['proposal_all'] = $this->get_jumlah_proposal($kegiatan_kbmi);
		$jumlah['pt'] = $this->get_jumlah_pt($kegiatan_kbmi);
		$jumlah['mahasiswa'] = $this->get_jumlah_mahasiswa($kegiatan_workshop);
		$this->smarty->assign('jumlah', $jumlah);
		
		// --------------------------
		// Grafik
		// --------------------------
		$this->smarty->assign('chart_proposal', $this->get_chart_proposal_submit($kegiatan_kbmi));
		
		
		// --------------------------
		// Top 10 Perguruan Tinggi
		// --------------------------
		$this->smarty->assign('top10pt_set', $this->list_top_10_pt($kegiatan_kbmi));
		
		
		// --------------------------
		// Sebaran LLDikti
		// --------------------------
		$this->smarty->assign('lldikti_set', $this->list_sebaran_lldikti($kegiatan_kbmi));
		
		
		// --------------------------
		// Sebaran Bentuk PT
		// --------------------------
		$this->smarty->assign('bentuk_pt_set', $this->list_sebaran_bentuk_pt($kegiatan_kbmi));
		
		
		$this->smarty->display();
	}
	
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function get_jumlah_proposal_submit($kegiatan)
	{
		return $this->db->from('proposal')
			->where('kegiatan_id', $kegiatan->id)
			->where('is_submited', 1)
			->count_all_results('');
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function get_jumlah_proposal($kegiatan)
	{
		return $this->db->from('proposal')
			->where('kegiatan_id', $kegiatan->id)
			->count_all_results('');
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function get_jumlah_pt($kegiatan)
	{
		return $this->db
			->select('perguruan_tinggi_id')->distinct()
			->from('proposal')
			->where('kegiatan_id', $kegiatan->id)
			->count_all_results('');
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function get_jumlah_mahasiswa($kegiatan)
	{
		return $this->db
			->from('peserta_workshop')
			->join('lokasi_workshop', 'lokasi_workshop.id = lokasi_workshop_id')
			->where('kegiatan_id', $kegiatan->id)
			->count_all_results('');
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function get_chart_proposal_submit($kegiatan)
	{
		$result['labels'] = array();
		$result['data'] = array();
		
		$data_set = $this->db
			->select('date_format(updated_at, \'%Y-%m-%d\') as tanggal, count(proposal.id) as jumlah', FALSE)
			->from('proposal')
			->where('kegiatan_id', $kegiatan->id)
			->where('is_submited', 1)
			->group_by('date_format(updated_at, \'%Y-%m-%d\')', FALSE)
			->order_by('updated_at')
			->get()->result();
		
		foreach ($data_set as $data)
		{
			array_push($result['labels'], "'".substr($data->tanggal, -2)."'");
			array_push($result['data'], $data->jumlah);
		}
		
		$result['labels'] = implode(',', $result['labels']);
		$result['data'] = implode(',', $result['data']);
		
		return $result;
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function list_top_10_pt($kegiatan)
	{
		return $this->db
			->select('nama_pt, count(proposal.id) as jumlah')
			->from('proposal')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->where('kegiatan_id', $kegiatan->id)
			->group_by('nama_pt')
			->order_by('2', 'desc', FALSE)
			->limit(10)
			->get()->result();
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function list_sebaran_lldikti($kegiatan)
	{		
		return $this->db
			->select('left(npsn, 2) as kode_lldikti, count(distinct perguruan_tinggi.id) as jumlah_pt, count(proposal.id) as jumlah_proposal', FALSE)
			->from('proposal')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->where('kegiatan_id', $kegiatan->id)
			->group_by('left(npsn, 2)', FALSE)
			->order_by(1, 'asc', FALSE)
			->get()->result();
	}
	
	/**
	 * @param Kegiatan_model $kegiatan
	 */
	private function list_sebaran_bentuk_pt($kegiatan)
	{
		/**
		 * select bentuk_pendidikan, count(distinct perguruan_tinggi.id) as jumlah_pt, count(proposal.id) as jumlah_proposal
from proposal
join perguruan_tinggi on perguruan_tinggi.id = perguruan_tinggi_id
join bentuk_pendidikan on bentuk_pendidikan.id = bentuk_pendidikan_id
where kegiatan_id = 9
group by bentuk_pendidikan
order by 1 asc
		 */
		
		return $this->db
			->select('bentuk_pendidikan, count(distinct perguruan_tinggi.id) as jumlah_pt, count(proposal.id) as jumlah_proposal', FALSE)
			->from('proposal')
			->join('perguruan_tinggi', 'perguruan_tinggi.id = perguruan_tinggi_id')
			->join('bentuk_pendidikan', 'bentuk_pendidikan.id = bentuk_pendidikan_id')
			->where('kegiatan_id', $kegiatan->id)
			->group_by('bentuk_pendidikan')
			->order_by(1, 'asc', FALSE)
			->get()->result();
	}
}
