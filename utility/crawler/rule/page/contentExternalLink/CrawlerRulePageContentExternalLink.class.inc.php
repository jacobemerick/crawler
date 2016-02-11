<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageContentExternalLink extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_content_external_links()
	{
		return $this->get_page()->getExternalLinks();
	}

}

?>