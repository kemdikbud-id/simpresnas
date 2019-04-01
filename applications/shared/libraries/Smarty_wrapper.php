<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Commented since using Composer Autoload
// require_once APPPATH . '../../vendor/smarty/smarty/libs/Smarty.class.php';

class Smarty_wrapper extends Smarty
{ 
	
	function __construct()
	{
		parent::__construct();
		
		$CI =& get_instance();
		
		$views_folder			= 'views';
		$views_compiled_folder	= 'views_compiled';
		
		// Config Initialize
		$this->setTemplateDir(APPPATH.$views_folder);
		$this->setCompileDir(APPPATH.$views_compiled_folder);
		$this->assignByRef('ci', $CI);
				
		// create folder if not exist
		if ( ! file_exists(APPPATH.$views_compiled_folder))
		{
			mkdir(APPPATH.$views_compiled_folder, 0777);
		}
	}
	
	/**
     * Override fungsi 'display()' dari Smarty, dengan melakukan automatisasi pada class & method dengan cara memanggil file nama_class/nama_method.tpl
     *
     * @param string $template   the resource handle of the template file or template object
     * @param mixed  $cache_id   cache id to be used with this template
     * @param mixed  $compile_id compile id to be used with this template
     * @param object $parent     next higher level of Smarty variables
     */
	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
	{		
		// Di olah hanya ketika null
		if ($template == NULL)
		{
			$CI =& get_instance();
			
			$class_name		= $CI->uri->rsegment(1);			// Class name sebagai nama folder
			$method_name	= $CI->uri->rsegment(2, 'index');	// Method sebagai nama file tpl
			$method_name_2	= str_replace('_', '-', $method_name);
			
			$template = APPPATH.'views'.DIRECTORY_SEPARATOR.$class_name.DIRECTORY_SEPARATOR.$method_name.'.tpl';
			$template2 = APPPATH.'views'.DIRECTORY_SEPARATOR.$class_name.DIRECTORY_SEPARATOR.$method_name_2.'.tpl';
			
			if (file_exists($template))
			{
				parent::display($template, $cache_id, $compile_id, $parent);
			}
			else if (file_exists($template2))
			{
				parent::display($template2, $cache_id, $compile_id, $parent);
			}
			else
			{
				show_error("Template \"{$template}\" not found.");
			}
		}
		else
		{
			try
			{
				parent::display($template, $cache_id, $compile_id, $parent);
			} 
			catch (SmartyException $ex)
			{
				show_error($ex->getMessage());
			}
		}
	}
	
	public function assignForCombo($tpl_var, $rows_object, $value_column, $display_column)
	{
		$value = array();
		
		foreach ($rows_object as $row)
		{
			$value[$row->{$value_column}] = $row->{$display_column};
		}
		
		parent::assign($tpl_var, $value);
	}
}

/* End of file Smarty_wrapper.php */