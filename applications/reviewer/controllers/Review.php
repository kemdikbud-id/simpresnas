<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Kegiatan_model $kegiatan_model
 * @property Tahapan_model $tahapan_model
 * @property Proposal_model $proposal_model
 * @property Reviewer_model $reviewer_model
 */
class Review extends Reviewer_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_TAHAPAN, 'tahapan_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_REVIEWER, 'reviewer_model');
	}
	
	public function index()
	{
		$kegiatan_id = $this->input->get('kegiatan_id');
		$tahapan_id = $this->input->get('tahapan_id');
		
		// Jika ada isinya
		if ($kegiatan_id && $tahapan_id)
		{
			$data_set = $this->proposal_model->list_proposal_per_reviewer($kegiatan_id, $tahapan_id, $this->session->userdata('user')->reviewer_id);
			$this->smarty->assign('data_set', $data_set);
		}
		
		$this->smarty->assign('kegiatan_option_set', $this->kegiatan_model->list_aktif_for_option());
		$this->smarty->assign('tahapan_option_set', $this->tahapan_model->list_all_for_option());
		$this->smarty->assign('reviewer_id', $this->session->userdata('user')->reviewer_id);
		
		$this->smarty->display();
	}
	
	public function penilaian($plot_reviewer_id)
	{
		$data = $this->db
			->select('pr.id, t.tahapan, p.judul, tp.kegiatan_id, tp.tahapan_id')->from('plot_reviewer pr')
			->join('tahapan_proposal tp', 'tp.id = pr.tahapan_proposal_id')
			->join('tahapan t', 't.id = tp.tahapan_id')
			->join('proposal p', 'p.id = tp.proposal_id')
			->where(['pr.id' => $plot_reviewer_id])
			->get()->row();
		$this->smarty->assign('data', $data);
		
		$penilaian_set = $this->db->query(
			"select kp.id, kp.urutan, kp.kriteria, kp.bobot from komponen_penilaian kp
			join tahapan_proposal tp on tp.kegiatan_id = kp.kegiatan_id and tp.tahapan_id = kp.tahapan_id
			join plot_reviewer pr on pr.tahapan_proposal_id = tp.id
			where pr.id = ?
			order by urutan", array($plot_reviewer_id))->result();
		$this->smarty->assign('penilaian_set', $penilaian_set);
		
		$this->smarty->display();
	}
}