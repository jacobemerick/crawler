<?php

Loader::load('utility', 'crawler/rule/page/CrawlerRulePage');

abstract class CrawlerRulePageContentImage extends CrawlerRulePage
{

	public function __construct() {}

	final protected function get_content_images()
	{
		return $this->get_page()->getContentImages();
	}

}

?>