<?php

Loader::load('utility', 'crawler/rule/page/contentH1/CrawlerRulePageContentH1');

class CrawlerRulePageContentH1Maximum extends CrawlerRulePageContentH1
{

	private static $MAXIMUM_CONTENT_H1_COUNT = 1;

	protected function run_check()
	{
		$content_h1s = $this->get_content_h1s();
		$pass = count($content_h1s) <= self::$MAXIMUM_CONTENT_H1_COUNT;
		
		if(!$pass)
			$this->error('Too many content h1s!');
	}

}

?>