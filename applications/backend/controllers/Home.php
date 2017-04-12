<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Home extends Backend_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->check_credentials();
	}
	
	public function index()
	{
		$this->smarty->display();
	}
}
