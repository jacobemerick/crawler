<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageContentInternalLink extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_content_internal_links()
	{
		return $this->get_page()->getInternalLinks();
	}

}

?>