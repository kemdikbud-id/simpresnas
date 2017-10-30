<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 * @property PerguruanTinggi_model $pt_model
 */
class Expo extends Admin_Controller
{	
	public function index()
	{	
		$this->smarty->assign('data_set', null);
		
		$this->smarty->display();
	}
}