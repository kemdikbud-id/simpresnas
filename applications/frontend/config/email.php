<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (file_exists('../shared/config/email.php'))
	include_once APPPATH . '../shared/config/email.php';
else
	show_error ("Email configuration not found", 500, "Configuration error");