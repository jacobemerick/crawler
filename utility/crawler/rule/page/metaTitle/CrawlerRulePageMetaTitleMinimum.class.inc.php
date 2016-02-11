<?php

Loader::load('utility', 'crawler/rule/page/metaTitle/CrawlerRulePageMetaTitle');

class CrawlerRulePageMetaTitleMinimum extends CrawlerRulePageMetaTitle
{

	private static $MINIMUM_LENGTH = 40;

	protected function run_check()
	{
		$title = $this->get_title();
		$pass = strlen($title) > self::$MINIMUM_LENGTH;
		
		if(!$pass)
			$this->error('Your page title is too long!');
	}

}

?>