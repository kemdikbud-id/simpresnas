<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 * @property Proposal_model $proposal_model
 */
class Expo extends Admin_Controller
{	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('proposal_model');
	}
	
	public function index()
	{	
		$data_set = $this->proposal_model->list_all_proposal_expo();

		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
	
	public function set_didanai()
	{
		if ($this->input->method() == 'post')
		{
			$proposal_id = $this->input->post('proposal_id');
			$this->db->update('proposal', ['is_didanai' => 1, 'is_ditolak' => 0, 'keterangan_ditolak' => null], ['id' => $proposal_id]);
		}
	}
	
	public function set_ditolak()
	{
		if ($this->input->method() == 'post')
		{
			$proposal_id = $this->input->post('proposal_id');
			$keterangan = $this->input->post('keterangan');
			$this->db->update('proposal', ['is_didanai' => 0, 'is_ditolak' => 1, 'keterangan_ditolak' => $keterangan], ['id' => $proposal_id]);
		}
	}
	
	public function index_per_pt()
	{
		$data_set = $this->proposal_model->list_all_proposal_expo_per_pt();
		
		$this->smarty->assign('data_set', $data_set);
		
		$this->smarty->display();
	}
}