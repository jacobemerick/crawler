<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/Link',
	'crawler/crawl/CrawlPageQueue',
	'crawler/crawl/CrawlSiteQueue',
	'crawler/crawl/CrawlPageRule',
	'crawler/crawl/CrawlSiteRule',
	'crawler/crawl/CrawlPageError',
	'crawler/crawl/CrawlSiteError'));

Loader::load('utility', array(
	'crawler/CrawlerPage',
	'crawler/CrawlerSite',
	'crawler/CrawlerURL'));

class CrawlerHandler
{

	private static $PAGE_RULE_DIRECTORY		= 'page';
	private static $SITE_RULE_DIRECTORY		= 'site';

	private $pages;
	private $count;
	private $start;

	private static $EXECUTION_TIME = 720;
	private static $BUFFER_TIME = 60;

	private function __construct()
	{
		$this->start = time();
	}

	private static $instance;
	public static function instance()
	{
		if(!self::$instance)
			self::$instance = new CrawlerHandler();
		return self::$instance;
	}

	public function execute()
	{
		$current = time();
		
		if(self::$EXECUTION_TIME - ($current - $this->start) < self::$BUFFER_TIME)
			exit;
		
		$page = Finder::instance('CrawlPageQueue')
			->setStatusFilter(CrawlPageQueue::$IS_UNCRAWLED)
			->getCrawlPageQueue();
		
		if($page)
		{
			$page = Mutator::instance('CrawlPageQueue', 'Update')
				->setData($page, CrawlPageQueue::$IS_BEING_CRAWLED)
				->execute();
			
			$link = CrawlerURL::instance($page->getLink()->getName());
			
			$domain = Finder::instance('Domain')
				->setNameFilter($link->getDomain())
				->getDomain();
			
			$pageObject = CrawlerPage::instance($link)
				->execute();
			
			$pageObject->save();
			
			$this->run_page_rules($pageObject);
			
			foreach($pageObject->getInternalLinks() as $crawlerLink)
			{
				$linkObject = Finder::instance('Link')
					->setNameFilter($crawlerLink)
					->getLink();
				
				$crawlPageQueue = Finder::instance('CrawlPageQueue')
					->setDomainFilter($domain->getID())
					->setLinkFilter($linkObject->getID())
					->getCrawlPageQueue();
				
				if(!isset($crawlPageQueue))
				{
					$crawlQueue = Mutator::instance('CrawlPageQueue', 'Create')
						->setData($domain, $linkObject, CrawlPageQueue::$IS_UNCRAWLED)
						->execute();
				}
			}
			
			Mutator::instance('CrawlPageQueue', 'Update')
				->setData($page, CrawlPageQueue::$IS_CRAWLED)
				->execute();
			
			$this->execute();
		}
		
		$site = Finder::instance('CrawlSiteQueue')
			->setStatusFilter(CrawlSiteQueue::$IS_UNCRAWLED)
			->getCrawlSiteQueue();
		
		if($site)
		{
			$site = Mutator::instance('CrawlSiteQueue', 'Update')
				->setData($site, CrawlSiteQueue::$IS_BEING_CRAWLED)
				->execute();
			
			$siteObject = CrawlerSite::instance($site->getDomain()->getName());
			$this->run_site_rules($siteObject);
			
			$this->send_report($site->getDomain());
			
			$site = Mutator::instance('CrawlSiteQueue', 'Update')
				->setData($site, CrawlSiteQueue::$IS_CRAWLED)
				->execute();
		}
	}

	private function run_page_rules($pageObject)
	{
		$rules = Collection::instance('CrawlPageRule')
			->setActiveFilter(CrawlPageRule::$IS_ACTIVE)
			->getCrawlPageRules();
		
		foreach($rules as $rule)
		{
			$path = "crawler/rule/";
			$path .= self::$PAGE_RULE_DIRECTORY . '/';
			$path .= "{$rule->getPiece()}/";
			$path .= "{$rule->getRule()}";
			
			$error = Loader::loadNew('utility', $path)
				->setPage($pageObject)
				->execute();
			
			if(isset($error))
			{
				Mutator::instance('CrawlPageError', 'Create')
					->setData($pageObject->getPage(), $rule, $error)
					->execute();
			}
		}
	}

	private function run_site_rules($siteObject)
	{
		$rules = Collection::instance('CrawlSiteRule')
			->setActiveFilter(CrawlSiteRule::$IS_ACTIVE)
			->getCrawlSiteRules();
		
		foreach($rules as $rule)
		{
			$path = "crawler/rule/";
			$path .= self::$SITE_RULE_DIRECTORY . '/';
			$path .= "{$rule->getPiece()}/";
			$path .= "{$rule->getRule()}";
			
			$error = Loader::loadNew('utility', $path)
				->setSite($siteObject)
				->execute();
			
			if(isset($error))
			{
				Mutator::instance('CrawlSiteError', 'Create')
					->setData($siteObject->getDomain(), $rule, $error)
					->execute();
			}
		}
	}

	private function send_report($domain)
	{
		$crawlSiteErrors = Collection::instance('CrawlSiteError')
			->setDomainFilter($domain->getID())
			->getCrawlSiteErrors();
		
		$site_error_message = '';
		foreach($crawlSiteErrors as $error)
		{
			$site_error_message .= "{$error->getMessage()}\n";
		}
		
		$pages = Collection::instance('Page')
			->setDomainFilter($domain->getID())
			->getPages();
		
		$page_errors = array();
		foreach($pages as $page)
		{
			$crawlPageErrors = Collection::instance('CrawlPageError')
				->setPageFilter($page->getID())
				->getCrawlPageErrors();
			
			foreach($crawlPageErrors as $error)
			{
				if(!isset($page_errors[$error->getMessage()]))
					$page_errors[$error->getMessage()] = 0;
				$page_errors[$error->getMessage()]++;
			}
		}
		
		arsort($page_errors);
		
		$page_error_message = '';
		foreach($page_errors as $message => $count)
		{
			$page_error_message .= "{$message} -- {$count} instances\n";
		}
		
		$message = "
Hello, there! Here is our crawl report for {$domain->getName()}...

SITE-WIDE CHECKS
{$site_error_message}

PER-PAGE CHECKS
{$page_error_message}";
		
		mail('EMAIL', 'Test Crawler Results', $message);
	}

}

?>
