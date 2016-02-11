<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageMetaTitle extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_title()
	{
		return $this->get_page()->getMetaTitle();
	}

}

?>