<?php

Loader::load('utility', 'crawler/rule/site/CrawlerRuleSite');

abstract class CrawlerRuleSiteContentPage extends CrawlerRuleSite
{

	public function __construct() {}

	final protected function get_content_pages()
	{
		return $this->get_site()->getContentPages();
	}

}

?>