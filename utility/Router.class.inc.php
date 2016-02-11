<?php

Loader::load('utility', 'Request');

class Router
{

	function __construct()
	{
		$this->redirect();
		$this->direct();
	}

	private function redirect() {}

	private function direct()
	{
		$link_map = $this->construct_direct_link_map();
		
		$uri = Request::getServer('REQUEST_URI');
		if(array_key_exists($uri, $link_map))
			$controller = Loader::loadNew('controller', $link_map[$uri]);
		else
			$controller = Loader::loadNew('controller', 'Error404Controller');
		
		$controller->activate();
	}

	private function construct_direct_link_map()
	{
		return array(
			'/' => 'HomeController');
	}

}

?>