<?php

Loader::load('utility', 'crawler/rule/page/metaDescription/CrawlerRulePageMetaDescription');

class CrawlerRulePageMetaDescriptionExists extends CrawlerRulePageMetaDescription
{

	protected function run_check()
	{
		$meta_description = $this->get_meta_description();
		$pass = strlen($meta_description) > 0;
		
		if(!$pass)
			$this->error('No page meta description detected!');
	}

}

?>