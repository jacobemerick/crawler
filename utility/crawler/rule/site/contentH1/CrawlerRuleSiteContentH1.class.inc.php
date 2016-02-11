<?php

Loader::load('utility', 'crawler/rule/site/CrawlerRuleSite');

abstract class CrawlerRuleSiteContentH1 extends CrawlerRuleSite
{

	public function __construct() {}

	final protected function get_content_h1s()
	{
		return $this->get_site()->getContentH1s();
	}

}

?>