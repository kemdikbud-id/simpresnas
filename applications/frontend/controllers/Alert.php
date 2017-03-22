<?php

/**
 * @author Fathoni
 */
class Alert extends Frontend_Controller
{
	public function error()
	{
		$this->smarty->display();
	}
	
	public function success()
	{
		$this->smarty->display();
	}
}
