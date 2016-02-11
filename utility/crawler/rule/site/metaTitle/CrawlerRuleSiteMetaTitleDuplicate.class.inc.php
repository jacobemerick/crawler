<?php

Loader::load('utility', 'crawler/rule/site/metaTitle/CrawlerRuleSiteMetaTitle');

class CrawlerRuleSiteMetaTitleDuplicate extends CrawlerRuleSiteMetaTitle
{

	protected function run_check()
	{
		$duplicate_title_count = 0;
		$titles = array();
		
		$metaTitles = $this->get_meta_titles();
		
		foreach($metaTitles as $metaTitle)
		{
			if(in_array($metaTitle->getID(), $titles))
				$duplicate_title_count++;
			else
				$titles[] = $metaTitle->getID();
		}
		
		$pass = $duplicate_title_count == 0;
		
		if(!$pass)
			$this->error('Duplicate Titles Found!');
	}

}

?>