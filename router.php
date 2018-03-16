<?php

if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI']))
{
    return false; // serve the requested resource as-is.
} 
else 
{
	// Default root
	$application = '';
	
	// Application Admin
	if (substr($_SERVER['REQUEST_URI'], 0, 7) === '/admin/')
	{
		$application = '/admin';
		chdir('admin');
	}
	
	// Application Reviewer
	if (substr($_SERVER['REQUEST_URI'], 0, 10) === '/reviewer/')
	{
		$application = '/reviewer';
		chdir('reviewer');
	}
	
	// this is the important part!
	$_SERVER['SCRIPT_NAME'] = $application . '/index.php';

	include_once (__DIR__ . $application . '/index.php');
}