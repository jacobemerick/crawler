<?php

Loader::load('utility', 'crawler/rule/CrawlerRule');

abstract class CrawlerRuleSite extends CrawlerRule
{

	private $siteObject;

	public function __construct() {}

	final public function setSite($siteObject)
	{
		$this->siteObject = $siteObject;
		return $this;
	}

	final protected function get_site()
	{
		return $this->siteObject;
	}

}

?>