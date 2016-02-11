<?php

Loader::load('utility', 'crawler/rule/page/contentInternalLink/CrawlerRulePageContentInternalLink');

class CrawlerRulePageContentInternalLinkMaximum extends CrawlerRulePageContentInternalLink
{

	private static $MAXIMUM_INTERNAL_LINK_COUNT = 100;

	protected function run_check()
	{
		$content_internal_links = $this->get_content_internal_links();
		$pass = count($content_internal_links) <= self::$MAXIMUM_INTERNAL_LINK_COUNT;
		
		if(!$pass)
			$this->error('Too many internal links!');
	}

}

?>