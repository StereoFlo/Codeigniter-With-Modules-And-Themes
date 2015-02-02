<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$theme = get_cookie('theme');
		if (in_array($theme, array('default', 'skeleton')))
		{
			$this->theme->set_theme($theme);
		}
	}

	public function index()
	{
		$message = get_cookie('message');
		if ($message)
		{
			$this->theme->add_message($message, 'success');
			set_cookie('message', null, null);
		}
		$this->theme->view('theme_example');
	}

	public function switch_theme($theme)
	{
		set_cookie('theme', $theme, 60*60*24*365);
		set_cookie('message', 'Theme switched to: '.$theme , 60*60*24*365);
		redirect('template');
	}
}