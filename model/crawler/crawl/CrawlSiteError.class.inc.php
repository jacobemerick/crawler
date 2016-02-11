<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/crawl/CrawlSiteRule'));

class CrawlSiteError extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const DOMAIN			= 'domain_id';
	const CRAWL_SITE_RULE	= 'crawl_site_rule_id';
	const MESSAGE			= 'message';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'crawl_site_error';
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

	private $crawlSiteRule;
	public function getCrawlSiteRule()
	{
		if(!isset($this->crawlSiteRule))
			$this->crawlSiteRule = new CrawlSiteRule($this->get_field(self::CRAWL_SITE_RULE));
		return $this->crawlSiteRule;
	}

	public function setCrawlSiteRule(CrawlSiteRule $crawlSiteRule)
	{
		$this->crawlSiteRule = $crawlSiteRule;
		$this->set_field(self::CRAWL_SITE_RULE, $crawlSiteRule->getID());
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