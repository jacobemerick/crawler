<?php

Loader::load('controller', '/PageController');

class Error404Controller extends PageController
{

	public function __construct()
	{
		header('HTTP/1.0 404 Not Found');
		
		parent::__construct();
	}

	protected function set_data()
	{
		$this->set_title('Absolute Danz - 404 Page Not Found');
		$this->set_head('description', 'Page Not Found!');
		$this->set_head('keywords', '');
		
		$this->set_content('404');
		$this->set_body_view('Content');
	}

}

?>