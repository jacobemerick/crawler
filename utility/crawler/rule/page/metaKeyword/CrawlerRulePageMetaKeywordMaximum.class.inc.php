<?php

Loader::load('utility', 'crawler/rule/page/metaKeyword/CrawlerRulePageMetaKeyword');

class CrawlerRulePageMetaKeywordMaximum extends CrawlerRulePageMetaKeyword
{

	private static $MAXIMUM_COUNT = 10;

	protected function run_check()
	{
		$meta_keywords = $this->get_meta_keyword();
		$pass = count($meta_keywords) <= self::$MAXIMUM_COUNT;
		
		if(!$pass)
			$this->error('You have too many keywords!');
	}

}

?>