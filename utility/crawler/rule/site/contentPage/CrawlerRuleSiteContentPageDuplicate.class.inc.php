<?php

Loader::load('utility', 'crawler/rule/site/contentPage/CrawlerRuleSiteContentPage');

class CrawlerRuleSiteContentPageDuplicate extends CrawlerRuleSiteContentPage
{

	protected function run_check()
	{
		$duplicate_content_page_count = 0;
		$content_pages = array();
		
		$contentPages = $this->get_content_pages();
		foreach($contentPages as $contentPage)
		{
			if(in_array($contentPage->getID(), $content_pages))
				$duplicate_content_page_count++;
			else
				$content_pages[] = $contentPage->getID();
		}
		
		$pass = $duplicate_content_page_count == 0;
		
		if(!$pass)
			$this->error('Duplicate Page Content Found!');
	}

}

?>