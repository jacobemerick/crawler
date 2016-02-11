<?php

abstract class PageController
{

	private $data_array = array();

	abstract protected function set_data();

	public function __construct()
	{
		$this->data_array = array(
			'head' => array(
				'title' => '',
				'description' => '',
				'keywords' => ''),
			'body' => array(),
			'foot' => array());
	}

	public function activate()
	{
		$this->set_data();
		$this->set_footer();
		
		Loader::load('view', 'part/Head', $this->data_array['head']);
		Loader::load('view', "body/{$this->body_view}", $this->data_array['body']);
		Loader::load('view', 'part/Foot', $this->data_array['foot']);
	}

	protected function set_title($value)
	{
		$this->set_head('title', $value);
		$this->set_body('title', $value);
	}

	protected function set_head($set, $value)
	{
		$this->data_array['head'][$set] = $value;
	}

	protected function set_body($set, $value)
	{
		$this->data_array['body'][$set] = $value;
	}

	protected function set_footer()
	{
		return array();
	}

	protected function set_body_view($view)
	{
		$this->body_view = $view;
	}

	protected function eject()
	{
		Loader::loadNew('controller', 'Error404Controller')->activate();
	}

}

?>