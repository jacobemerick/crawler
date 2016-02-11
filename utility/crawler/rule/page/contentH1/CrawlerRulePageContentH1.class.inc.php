<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageContentH1 extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_content_h1s()
	{
		return $this->get_page()->getContentH1s();
	}

}

?>