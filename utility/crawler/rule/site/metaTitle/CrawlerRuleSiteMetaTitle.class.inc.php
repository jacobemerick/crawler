<?php

Loader::load('utility', 'crawler/rule/site/CrawlerRuleSite');

abstract class CrawlerRuleSiteMetaTitle extends CrawlerRuleSite
{

	public function __construct() {}

	final protected function get_meta_titles()
	{
		return $this->get_site()->getMetaTitles();
	}

}

?>