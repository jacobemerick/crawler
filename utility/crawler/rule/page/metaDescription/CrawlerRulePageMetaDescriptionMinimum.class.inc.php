<?php

Loader::load('utility', 'crawler/rule/page/metaDescription/CrawlerRulePageMetaDescription');

class CrawlerRulePageMetaDescriptionMinimum extends CrawlerRulePageMetaDescription
{

	private static $MINIMUM_LENGTH = 100;

	protected function run_check()
	{
		$meta_description = $this->get_meta_description();
		$pass = strlen($meta_description) > self::$MINIMUM_LENGTH;
		
		if(!$pass)
			$this->error('Your page meta description is too short!');
	}

}

?>