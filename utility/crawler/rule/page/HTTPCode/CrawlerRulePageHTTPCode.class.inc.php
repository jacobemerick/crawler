<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageHTTPCode extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_http_code()
	{
		return $this->get_page()->getHTTPCode();
	}

}

?>