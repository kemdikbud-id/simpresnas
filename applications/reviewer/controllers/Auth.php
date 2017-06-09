<?php

/**
 * @author Fathoni <m.fathoni@mail.com>
 */
class Auth extends Reviewer_Controller
{	
	public function logout()
	{
		$this->session->unset_userdata('user');

		// redirect to home
		redirect(GLOBAL_BASE_URL);
	}
}
