<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/Link'));

class CrawlPageQueue extends DataObject
{

	const PRIMARY_KEY	= 'id';
	const DOMAIN		= 'domain_id';
	const LINK			= 'link_id';
	const STATUS		= 'status';

	public static $IS_UNCRAWLED			= 1;
	public static $IS_BEING_CRAWLED		= 2;
	public static $IS_CRAWLED			= 4;

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'crawl_page_queue';
	}

	private $domain;
	public function getDomain()
	{
		if(!isset($this->domain))
			$this->domain = new Domain($this->get_field(self::DOMAIN));
		return $this->domain;
	}

	public function setDomain(Domain $domain)
	{
		$this->domain = $domain;
		$this->set_field(self::DOMAIN, $domain->getID());
	}

	private $link;
	public function getLink()
	{
		if(!isset($this->link))
			$this->link = new Link($this->get_field(self::LINK));
		return $this->link;
	}

	public function setLink(Link $link)
	{
		$this->link = $link;
		$this->set_field(self::LINK, $link->getID());
	}

	public function isUncrawled()
	{
		$status = $this->get_field(self::STATUS);
		return $status == self::$IS_UNCRAWLED;
	}

	public function isBeingCrawled()
	{
		$status = $this->get_field(self::STATUS);
		return $status == self::$IS_BEING_CRAWLED;
	}

	public function isCrawled()
	{
		$status = $this->get_field(self::STATUS);
		return $status == self::$IS_CRAWLED;
	}

	public function setStatus($status)
	{
		$this->set_field(self::STATUS, $status);
	}

}

?>