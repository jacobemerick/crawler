<?php

Loader::load('utility', 'crawler/rule/page/metaTitle/CrawlerRulePageMetaTitle');

class CrawlerRulePageMetaTitleMaximum extends CrawlerRulePageMetaTitle
{

	private static $MAXIMUM_LENGTH = 70;

	protected function run_check()
	{
		$title = $this->get_title();
		$pass = strlen($title) < self::$MAXIMUM_LENGTH;
		
		if(!$pass)
			$this->error('Your page title is too long!');
	}

}

?>