<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageMetaRedirect extends CrawlerRulePage
{

	public function __construct() {}

	final protected function has_meta_redirect()
	{
		return $this->get_page()->hasMetaRedirect();
	}

}

?>