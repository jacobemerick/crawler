<?php

Loader::load('utility', 'crawler/rule/page/contentExternalLink/CrawlerRulePageContentExternalLink');

class CrawlerRulePageContentExternalLinkMaximum extends CrawlerRulePageContentExternalLink
{

	private static $MAXIMUM_EXTERNAL_LINK_COUNT = 100;

	protected function run_check()
	{
		$content_external_links = $this->get_content_external_links();
		$pass = count($content_external_links) <= self::$MAXIMUM_EXTERNAL_LINK_COUNT;
		
		if(!$pass)
			$this->error('Too many external links!');
	}

}

?>