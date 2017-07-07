<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model 
 * @property Tahapan_model $tahapan_model 
 */
class Penilaian extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_TAHAPAN, 'tahapan_model');
	}
	
	public function index()
	{
		$kegiatan_id	= $this->input->get('kegiatan_id');
		$tahapan_id		= $this->input->get('tahapan_id');
		
		$data_set = $this->db
			->select('p.judul, pt.nama_pt, r1.nama as reviewer_1, r2.nama as reviewer_2, r3.nama as reviewer_3')
			->select('pr1.biaya_rekomendasi as biaya_rekomendasi_1, pr2.biaya_rekomendasi as biaya_rekomendasi_2, pr3.biaya_rekomendasi as biaya_rekomendasi_3')
			->select('pr1.nilai_reviewer as nilai_reviewer_1, pr2.nilai_reviewer as nilai_reviewer_2, pr3.nilai_reviewer as nilai_reviewer_3, ABS(pr1.nilai_reviewer - pr2.nilai_reviewer) as nilai_selisih')
			->select('AVG(pr.nilai_reviewer) as nilai_rata, SUM(pr.nilai_reviewer) as nilai_total')
			->from('tahapan_proposal tp')
			->join('proposal p', 'p.id = tp.proposal_id')
			->join('perguruan_tinggi pt', 'pt.id = p.perguruan_tinggi_id')
			->join('plot_reviewer pr1', 'pr1.tahapan_proposal_id = tp.id AND pr1.no_urut = 1', 'LEFT')
			->join('reviewer r1', 'r1.id = pr1.reviewer_id', 'LEFT')
			->join('plot_reviewer pr2', 'pr2.tahapan_proposal_id = tp.id AND pr2.no_urut = 2', 'LEFT')
			->join('reviewer r2', 'r2.id = pr2.reviewer_id', 'LEFT')
			->join('plot_reviewer pr3', 'pr3.tahapan_proposal_id = tp.id AND pr3.no_urut = 3', 'LEFT')
			->join('reviewer r3', 'r3.id = pr3.reviewer_id', 'LEFT')
			->join('plot_reviewer pr', 'pr.tahapan_proposal_id = tp.id', 'LEFT')
			->where(['tp.kegiatan_id' => $kegiatan_id, 'tp.tahapan_id' => $tahapan_id])
			->group_by('p.judul, pt.nama_pt, r1.nama, r2.nama, r3.nama, pr1.nilai_reviewer, pr2.nilai_reviewer, pr3.nilai_reviewer, pr1.biaya_rekomendasi, pr2.biaya_rekomendasi, pr3.biaya_rekomendasi')
			->order_by('13 DESC, 14 DESC', NULL, FALSE) // AVG & SUM
			->get()->result();
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->assign('kegiatan_option_set', $this->kegiatan_model->list_aktif_for_option());
		$this->smarty->assign('tahapan_option_set', $this->tahapan_model->list_all_for_option());
		$this->smarty->display();
	}
}