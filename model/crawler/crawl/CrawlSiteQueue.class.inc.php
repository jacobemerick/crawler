<?php

Loader::load('model', 'crawler/Domain');

class CrawlSiteQueue extends DataObject
{

	const PRIMARY_KEY	= 'id';
	const DOMAIN		= 'domain_id';
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
		return 'crawl_site_queue';
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