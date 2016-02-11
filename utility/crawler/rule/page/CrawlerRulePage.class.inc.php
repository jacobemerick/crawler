<?php

Loader::load('utility', 'crawler/rule/CrawlerRule');

abstract class CrawlerRulePage extends CrawlerRule
{

	private $pageObject;

	public function __construct() {}

	final public function setPage($pageObject)
	{
		$this->pageObject = $pageObject;
		return $this;
	}

	final protected function get_page()
	{
		return $this->pageObject;
	}

}

?>