<?php

/**
 * @property File_proposal_model $file_proposal_model
 * @property Proposal_model $proposal_model
 * @property Kegiatan_model $kegiatan_model
 * @property PerguruanTinggi_model $pt_model
 */
class Download extends Frontend_Controller
{
	public function index()
	{
		$this->load->model(MODEL_FILE_PROPOSAL, 'file_proposal_model');
		$this->load->model(MODEL_PROPOSAL, 'proposal_model');
		$this->load->model(MODEL_KEGIATAN, 'kegiatan_model');
		$this->load->model(MODEL_PERGURUAN_TINGGI, 'pt_model');
		
		// file proposal id
		$id = $this->input->get('id');
		$mode = $this->input->get('mode');
		
		if ($mode == 'download')
			$disposition = 'attachment';
		else
			$disposition = 'inline';
		
		$file_proposal = $this->file_proposal_model->get_single($id);
		$proposal = $this->proposal_model->get_single($file_proposal->proposal_id);
		$kegiatan = $this->kegiatan_model->get_single($proposal->kegiatan_id);
		$pt = $this->pt_model->get_single($proposal->perguruan_tinggi_id);
		
		if ($kegiatan->program_id == 1) { $program_folder = 'pbbt'; $username = $pt->npsn . '01'; }
		if ($kegiatan->program_id == 2) { $program_folder = 'kbmi'; $username = $pt->npsn . '02'; }
		
		$file_location = APPPATH . '../../upload/lampiran/'.$file_proposal->nama_file;
		
		if (file_exists($file_location))
		{
			header('Content-Type: application/pdf');
			header('Content-Disposition: '.$disposition.'; filename="'.$file_proposal->nama_asli.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file_location));
			readfile($file_location);
			exit;
		}
		else
		{
			show_404();
		}
	}
}