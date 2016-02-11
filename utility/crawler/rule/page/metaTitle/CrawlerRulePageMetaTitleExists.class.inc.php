<?php

Loader::load('utility', 'crawler/rule/page/metaTitle/CrawlerRulePageMetaTitle');

class CrawlerRulePageMetaTitleExists extends CrawlerRulePageMetaTitle
{

	protected function run_check()
	{
		$title = $this->get_title();
		$pass = strlen($title) > 0;
		
		if(!$pass)
			$this->error('No Page Title Detected!');
	}

}

?>