<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property Reviewer_model $reviewer_model
 * @property User_model $user_model
 * @property Kegiatan_model $kegiatan_model
 * @property Tahapan_model $tahapan_model
 */
class User_Reviewer extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
		
		$this->load->model(MODEL_REVIEWER, 'reviewer_model');
		$this->load->model(MODEL_USER, 'user_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_TAHAPAN, 'tahapan_model');
	}
	
	public function index()
	{
		$data_set = $this->reviewer_model->list_reviewer();
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function update($id)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { $this->_post_update($id); }
		
		$user = $this->user_model->get_single_by_reviewer($id);
		$user->reviewer = $this->reviewer_model->get_single($id);
		$this->smarty->assign('data', $user);
		$this->smarty->display();
	}
	
	private function _post_update($id)
	{
		$this->db->trans_begin();
		
		$this->db->update('user', array(
			'username'		=> $this->input->post('username'),
			'password'		=> $this->input->post('password'),
			'password_hash'	=> sha1($this->input->post('password')),
			'updated_at'	=> date('Y-m-d H:i:s')
		), ['reviewer_id' => $id]);
		
		$this->db->update('reviewer', array(
			'nama'			=> $this->input->post('nama'),
			'gelar_depan'	=> $this->input->post('gelar_depan'),
			'gelar_belakang'=> $this->input->post('gelar_belakang'),
			'kompetensi'	=> $this->input->post('kompetensi'),
			'no_kontak'		=> $this->input->post('no_kontak'),
			'asal_institusi'=> $this->input->post('asal_institusi'),
		), ['id' => $id]);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();

			$this->smarty->assign('updated', TRUE);
		}
	}
	
	public function plotting()
	{
		$kegiatan_id = $this->input->get('kegiatan_id');
		$tahapan_id = $this->input->get('tahapan_id');
		
		// Jika ada isinya
		if ($kegiatan_id && $tahapan_id)
		{
			$data_set = $this->db
				->select("tp.id, p.judul, nama_pt, r1.nama as reviewer_1, r2.nama as reviewer_2")
				->from('tahapan_proposal tp')
				->join('proposal p', 'p.id = tp.proposal_id')
				->join('perguruan_tinggi pt', 'pt.id = p.perguruan_tinggi_id')
				->join('plot_reviewer pr1', 'pr1.tahapan_proposal_id = tp.id AND pr1.no_urut = 1', 'LEFT')
				->join('reviewer r1', 'r1.id = pr1.reviewer_id', 'LEFT')
				->join('plot_reviewer pr2', 'pr2.tahapan_proposal_id = tp.id AND pr2.no_urut = 2', 'LEFT')
				->join('reviewer r2', 'r2.id = pr2.reviewer_id', 'LEFT')
				->where(['tp.kegiatan_id' => $kegiatan_id, 'tp.tahapan_id' => $tahapan_id])->get()->result();
			
			$this->smarty->assign('data_set', $data_set);
		}
		
		$this->smarty->assign('kegiatan_option_set', $this->kegiatan_model->list_aktif_for_option());
		$this->smarty->assign('tahapan_option_set', $this->tahapan_model->list_all_for_option());
		
		$this->smarty->display();
	}
	
	public function update_plotting($tahapan_proposal_id)
	{		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$reviewer_ids = $this->input->post('reviewer_id');
			
			$this->db->trans_begin();
			
			for ($i = 1; $i <= 2; $i++)
			{
				// proses hanya diisi
				if ($reviewer_ids[$i] != '')
				{
					// get plot reviewer
					$plot_reviewer = $this->db->get_where('plot_reviewer', ['tahapan_proposal_id' => $tahapan_proposal_id, 'no_urut' => $i])->row();

					// jika tidak ada, insert
					if ($plot_reviewer == NULL)
					{
						$this->db->insert('plot_reviewer', array(
							'tahapan_proposal_id' => $tahapan_proposal_id,
							'reviewer_id' => $reviewer_ids[$i], 
							'no_urut' => $i
						));
					}
					else
					{
						// proses hanya jika beda
						if ($reviewer_ids[$i] != $plot_reviewer->reviewer_id)
						{
							// reset nilai juga
							$this->db->update('plot_reviewer', ['reviewer_id' => $reviewer_ids[$i], 'nilai_reviewer' => 0], ['id' => $plot_reviewer->id]);
						}
					}
				}
				else
				{
					$this->db->delete('plot_reviewer', ['tahapan_proposal_id' => $tahapan_proposal_id, 'no_urut' => $i], 1);
				}
			}
			
			if ($this->db->trans_status() !== FALSE)
			{
				$this->db->trans_commit();
				
				$this->smarty->assign('updated', TRUE);
			}
			else
			{
				$this->db->trans_rollback();
			}
		}
		
		$data = $this->db
			->select('tp.id, p.judul, pt.nama_pt, p.perguruan_tinggi_id, tp.kegiatan_id, tp.tahapan_id')->from('tahapan_proposal  tp')
			->join('proposal p', 'p.id = tp.proposal_id')
			->join('perguruan_tinggi pt', 'pt.id = p.perguruan_tinggi_id')
			->where(['tp.id' => $tahapan_proposal_id])->get()->row();
		$this->smarty->assign('data', $data);
		
		$reviewer_set = $this->db
			->select("r.id, concat(r.nama,' (',ifnull(pt.nama_pt, r.asal_institusi),')') as nama")
			->from('reviewer r')->join('perguruan_tinggi pt', 'pt.id = r.perguruan_tinggi_id', 'LEFT')
			->or_where(['r.perguruan_tinggi_id <>' => $data->perguruan_tinggi_id, 'r.perguruan_tinggi_id IS NULL' => NULL])
			->get()->result_array();
		$reviewer_option_set = array_column($reviewer_set, 'nama', 'id');
		$this->smarty->assign('reviewer_option_set', $reviewer_option_set);
		
		$reviewer_1 = $this->db->get_where('plot_reviewer', ['tahapan_proposal_id' => $data->id, 'no_urut' => 1])->row();
		$reviewer_2 = $this->db->get_where('plot_reviewer', ['tahapan_proposal_id' => $data->id, 'no_urut' => 2])->row();
		
		// Prevent Error
		if ($reviewer_1 == NULL) { $reviewer_1 = new stdClass(); $reviewer_1->reviewer_id = -1; }
		if ($reviewer_2 == NULL) { $reviewer_2 = new stdClass(); $reviewer_2->reviewer_id = -1; }
		
		$this->smarty->assign('reviewer_1', $reviewer_1);
		$this->smarty->assign('reviewer_2', $reviewer_2);
		
		$this->smarty->display();
	}
	
	public function rekap()
	{
		$this->smarty->display();
	}
}