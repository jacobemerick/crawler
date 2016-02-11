<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageMetaDescription extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_meta_description()
	{
		return $this->get_page()->getMetaDescription();
	}

}

?>