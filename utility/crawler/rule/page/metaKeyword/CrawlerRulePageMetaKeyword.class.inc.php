<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageMetaKeyword extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_meta_keyword()
	{
		return $this->get_page()->getMetaKeywords();
	}

}

?>