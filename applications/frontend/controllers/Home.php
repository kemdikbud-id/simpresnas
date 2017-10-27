<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Home extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		
		if ($this->session->program_id == PROGRAM_PBBT) $template = 'home/index-pbbt.tpl';
		if ($this->session->program_id == PROGRAM_KBMI) $template = 'home/index-kbmi.tpl';
		if ($this->session->program_id == PROGRAM_EXPO) $template = 'home/index-expo.tpl';
		
		$this->smarty->display($template);
	}
}
