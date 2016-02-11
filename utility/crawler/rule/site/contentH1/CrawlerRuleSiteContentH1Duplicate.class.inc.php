<?php

Loader::load('utility', 'crawler/rule/site/contentH1/CrawlerRuleSiteContentH1');

class CrawlerRuleSiteContentH1Duplicate extends CrawlerRuleSiteContentH1
{

	protected function run_check()
	{
		$duplicate_content_h1_count = 0;
		$content_h1s = array();
		
		$contentH1s = $this->get_content_h1s();
		
		foreach($contentH1s as $contentH1)
		{
			if(in_array($contentH1->getID(), $content_h1s))
				$duplicate_content_h1_count++;
			else
				$content_h1s[] = $contentH1->getID();
		}
		
		
		$pass = $duplicate_content_h1_count == 0;
		
		if(!$pass)
			$this->error('Duplicate Content H1s Found!');
	}

}

?>