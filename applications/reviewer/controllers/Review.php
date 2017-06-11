<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 * @property Kegiatan_model $kegiatan_model
 * @property Tahapan_model $tahapan_model
 * @property Proposal_model $proposal_model
 * @property TahapanProposal_model $tproposal_model
 * @property FileProposal_model $fileproposal_model
 * @property Reviewer_model $reviewer_model
 * @property PlotReviewer_model $plotr_model
 * @property CI_Config $config
 * @property CI_Form_validation $form_validation
 */
class Review extends Reviewer_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_TAHAPAN, 'tahapan_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_TAHAPAN_PROPOSAL, 'tproposal_model');
		$this->load->model(MODEL_FILE_PROPOSAL, 'fileproposal_model');
		$this->load->model(MODEL_REVIEWER, 'reviewer_model');
		$this->load->model(MODEL_PLOT_REVIEWER, 'plotr_model');
		
		 $this->load->library('form_validation');
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
		$plot_reviewer		= $this->plotr_model->get_single($plot_reviewer_id);
		$tahapan_proposal	= $this->tproposal_model->get_single($plot_reviewer->tahapan_proposal_id);
		$tahapan			= $this->tahapan_model->get_single($tahapan_proposal->tahapan_id);
		$proposal			= $this->proposal_model->get_single($tahapan_proposal->proposal_id);
		$file_proposal_set	= $this->fileproposal_model->list_by_proposal($tahapan_proposal->proposal_id);
		$kegiatan			= $this->kegiatan_model->get_single($proposal->kegiatan_id);
		$pt					= $this->pt_model->get_single($proposal->perguruan_tinggi_id);
		
		// Ambil komponen penilaian di left join dengan hasil penilaian per reviewer
		// dimulai dari tabel plot reviewer
		$penilaian_set = $this->db
			->select('kp.id as komponen_penilaian_id, kp.urutan, kp.kriteria, kp.bobot, hp.id as hp_id, hp.skor, hp.nilai')
			->from('plot_reviewer pr')
			->join('tahapan_proposal tp', 'tp.id = pr.tahapan_proposal_id')
			->join('kegiatan k', 'k.id = tp.kegiatan_id')
			->join('tahapan t', 't.id = tp.tahapan_id')
			->join('komponen_penilaian kp', 'kp.kegiatan_id = k.id AND kp.tahapan_id = t.id')
			->join('hasil_penilaian hp', 'hp.tahapan_proposal_id = tp.id AND hp.komponen_penilaian_id = kp.id', 'LEFT')
			->where(['pr.id' => $plot_reviewer_id])
			->order_by('kp.urutan')
			->get()->result();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// replace input
			$_POST['biaya_rekomendasi'] = str_replace('.', '', $_POST['biaya_rekomendasi']);
			
			// Ketika reviewer ke satu, wajib mengisi biaya rekomendasi
			if ($plot_reviewer->no_urut == 1)
			{
				// Isian biaya_rekomendasi wajib ada, minimal 1
				$this->form_validation->set_rules('biaya_rekomendasi', 'Biaya Rekomendasi', 'greater_than[0]', 
					array('greater_than' => "Biaya rekomendasi Wajib di isi !"));
			}
			
			// Isian komponen nilai
			foreach ($this->input->post('skor') as $komponen_penilaian_id => $skor)
			{
				$this->form_validation->set_rules("skor[{$komponen_penilaian_id}]", "Skor", 'required');
			}
			
			// Pre-updated object
			$proposal->lama_kegiatan			= $this->input->post('lama_kegiatan');
			$proposal->biaya_diusulkan			= str_replace('.', '', $this->input->post('biaya_diusulkan'));
			$proposal->biaya_rekomendasi		= str_replace('.', '', $this->input->post('biaya_rekomendasi'));
			$proposal->biaya_kontribusi_pt		= str_replace('.', '', $this->input->post('biaya_kontribusi_pt'));
			$proposal->biaya_kontribusi_umkm	= str_replace('.', '', $this->input->post('biaya_kontribusi_umkm'));
			$proposal->updated_at				= date('Y-m-d H:i:s');
			
			$plot_reviewer->nilai_reviewer	= 0; // di 0 kan dulu sebelum di counting ulang
			$plot_reviewer->komentar		= $this->input->post('komentar');
			$plot_reviewer->updated_at		= date('Y-m-d H:i:s');
			
			
			// Pre-updated object
			foreach ($penilaian_set as &$penilaian)
			{
				$penilaian->skor = (int)$this->input->post("skor[{$penilaian->komponen_penilaian_id}]");
				
				// update nilai jika ada isian skor
				if ($skor != '') $penilaian->nilai = $penilaian->bobot * $penilaian->skor;
				
				$plot_reviewer->nilai_reviewer += $penilaian->nilai;
			}
			
			// clear references
			unset($penilaian);
			
			if ($this->form_validation->run())
			{
				$this->db->trans_begin();
				
				$this->db->update('proposal', $proposal, ['id' => $proposal->id]);
				$this->db->update('plot_reviewer', $plot_reviewer, ['id' => $plot_reviewer->id]);
				
				
				foreach ($penilaian_set as $penilaian)
				{
					if ($penilaian->hp_id == '')  // hasil_penilaian_id kosong artinya belum ada record, perlu INSERT
					{
						$this->db->insert('hasil_penilaian', array(
							'tahapan_proposal_id'	=> $plot_reviewer->tahapan_proposal_id,
							'komponen_penilaian_id'	=> $penilaian->komponen_penilaian_id,
							'reviewer_id'			=> $plot_reviewer->reviewer_id,
							'skor'					=> $penilaian->skor,	// nilai sudah di dapat : lihat line 107
							'nilai'					=> $penilaian->nilai	// nilai sudah di dapat : lihat line 110
						));
					}
					else
					{
						$this->db->update('hasil_penilaian', array(
							'skor'					=> $penilaian->skor,	// nilai sudah di dapat : lihat line 107
							'nilai'					=> $penilaian->nilai,	// nilai sudah di dapat : lihat line 110
							'updated_at'			=> date('Y-m-d H:i:s')
						), ['id' => $penilaian->hp_id]);	// hasil_penilaian_id
					}
				}
				
				
				if ($this->db->trans_status() !== FALSE)
				{
					$this->db->trans_commit();
					
					$this->smarty->assign('updated', TRUE);
				}
				else
				{
					show_error("Terdapat kesalahan");
				}
			}
			else
			{
				$this->smarty->assign('updated', FALSE);
			}
		}
		
		$this->smarty->assign('plot_reviewer', $plot_reviewer);
		$this->smarty->assign('tahapan_proposal', $tahapan_proposal);
		$this->smarty->assign('proposal', $proposal);
		$this->smarty->assign('tahapan', $tahapan);
		$this->smarty->assign('file_proposal_set', $file_proposal_set);
		$this->smarty->assign('pt', $pt);
		
		$download_url = $this->config->item('global_base_url') . '/index.php/download/';
		$this->smarty->assign('download_url', $download_url);
		
		if ($kegiatan->program_id == 1) { $program_folder = 'pbbt'; $username = $pt->npsn . '01'; }
		if ($kegiatan->program_id == 2) { $program_folder = 'kbmi'; $username = $pt->npsn . '02'; }
		$preview_url = $this->config->item('global_base_url') . '/upload/file-proposal/'.$program_folder.'/'.$username.'/'.$proposal->id.'/';
		$this->smarty->assign('preview_url', $preview_url);
		
		$this->smarty->assign('penilaian_set', $penilaian_set);
		
		$skor_set = $this->db->select("skor, concat(skor,' - ',keterangan) as keterangan", FALSE)->get('skor')->result_array();
		$this->smarty->assign('skor_option_set', array_column($skor_set, 'keterangan', 'skor'));
		
		$this->smarty->display();
	}
}