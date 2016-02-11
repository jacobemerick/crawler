<?php

Loader::load('utility', 'crawler/rule/page/contentH1/CrawlerRulePageContentH1');

class CrawlerRulePageContentH1Exists extends CrawlerRulePageContentH1
{

	protected function run_check()
	{
		$content_h1s = $this->get_content_h1s();
		$content_h1 = array_pop($content_h1s);
		$pass = strlen($content_h1) > 0;
		
		if(!$pass)
			$this->error('No page content H1 detected!');
	}

}

?>