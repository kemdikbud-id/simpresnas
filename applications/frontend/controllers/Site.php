<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Site extends Frontend_Controller
{
	public function index()
	{
		$tahun = date('Y');
		
		$kegiatan_pbbt = $this->db->get_where('kegiatan', array(
			'program_id' => PROGRAM_PBBT,
			'tahun' => $tahun
		))->row();
		
		$kegiatan_kbmi = $this->db->get_where('kegiatan', array(
			'program_id' => PROGRAM_KBMI,
			'tahun' => $tahun
		))->row();
		
		// Assign data to display
		$this->smarty->assign('kegiatan_pbbt', $kegiatan_pbbt);
		$this->smarty->assign('kegiatan_kbmi', $kegiatan_kbmi);
		
		$this->smarty->display();
	}
}
