<?php

Loader::load('model', array(
	'crawler/Page',
	'crawler/crawl/CrawlPageRule'));

class CrawlPageError extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const PAGE				= 'page_id';
	const CRAWL_PAGE_RULE	= 'crawl_page_rule_id';
	const MESSAGE			= 'message';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'crawl_page_error';
	}

	private $page;
	public function getPage()
	{
		if(!isset($this->page))
			$this->page = new Page($this->get_field(self::PAGE));
		return $this->page;
	}

	public function setPage(Page $page)
	{
		$this->page = $page;
		$this->set_field(self::PAGE, $page->getID());
	}

	private $crawlPageRule;
	public function getCrawlPageRule()
	{
		if(!isset($this->crawlPageRule))
			$this->crawlPageRule = new CrawlPagePage($this->get_field(self::CRAWL_PAGE_RULE));
		return $this->crawlPageRule;
	}

	public function setCrawlPageRule(CrawlPageRule $crawlPageRule)
	{
		$this->crawlPageRule = $crawlPageRule;
		$this->set_field(self::CRAWL_PAGE_RULE, $crawlPageRule->getID());
	}

	public function getMessage()
	{
		return $this->get_field(self::MESSAGE);
	}

	public function setMessage($message)
	{
		$this->set_field(self::MESSAGE, $message);
	}

}

?>