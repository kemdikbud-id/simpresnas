<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 * 
 * @property Backend_Session_Session $session
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_Upload $upload
 * @property Smarty_wrapper $smarty
 * @property CI_DB_query_builder $db
 * @property CI_DB_mysqli_driver $db
 * @property CI_Session $session
 */
class Reviewer_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// Always check credentials
		$this->check_credentials();
	}
	
	public function check_credentials()
	{
		if ($this->session->userdata('user') == NULL)
		{
			redirect($this->config->item('global_base_url'));
		}
	}
}
