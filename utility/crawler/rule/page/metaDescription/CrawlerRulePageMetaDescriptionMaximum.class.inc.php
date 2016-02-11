<?php

Loader::load('utility', 'crawler/rule/page/metaDescription/CrawlerRulePageMetaDescription');

class CrawlerRulePageMetaDescriptionMaximum extends CrawlerRulePageMetaDescription
{

	private static $MAXIMUM_LENGTH = 140;

	protected function run_check()
	{
		$meta_description = $this->get_meta_description();
		$pass = strlen($meta_description) < self::$MAXIMUM_LENGTH;
		
		if(!$pass)
			$this->error('Your page meta description is too long!');
	}

}

?>