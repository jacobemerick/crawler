<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/Page'));

class CrawlerSite
{

	private $site;

	private function __construct($site)
	{
		$this->site = $site;
	}

	public static function instance($site)
	{
		return new CrawlerSite($site);
	}

	private $domain;
	public function getDomain()
	{
		if(!isset($this->domain))
		{
			$domain = Finder::instance('Domain')
				->setNameFilter($this->site)
				->getDomain();
			
			if(!$domain)
				trigger_error("CrawlerSite tried to pull an invalid domain {$this->site}!");
			
			$this->domain = $domain;
		}
		return $this->domain;
	}

	private $pages;
	public function getPages()
	{
		if(!isset($this->pages))
		{
			$pages = Collection::instance('Page')
				->setDomainFilter($this->getDomain()->getID())
				->getPages();
			
			if(!$pages)
				trigger_error("CrawlerSite did not find any pages for domain {$this->getDomain()->getName()}!");
			
			$this->pages = $pages;
		}
		return $this->pages;
	}

	private $metaTitles;
	public function getMetaTitles()
	{
		if(!isset($this->metaTitles))
		{
			$this->metaTitles = array();
			
			$pages = $this->getPages();
			foreach($pages as $page)
			{
				$this->metaTitles[] = $page->getMetaTitle();
			}
		}
		return $this->metaTitles;
	}

	private $contentH1s;
	public function getContentH1s()
	{
		if(!isset($this->contentH1s))
		{
			$this->contentH1s = array();
			
			$pages = $this->getPages();
			foreach($pages as $page)
			{
				$pageContentH1Maps = Collection::instance('PageContentH1Map')
					->setPageFilter($page->getID())
					->getPageContentH1Maps();
				
				if(!$pageContentH1Maps)
					continue;
				
				foreach($pageContentH1Maps as $pageContentH1Map)
				{
					$this->contentH1s[] = $pageContentH1Map->getContentH1();
				}
			}
		}
		return $this->contentH1s;
	}

	private $contentPages;
	public function getContentPages()
	{
		if(!isset($this->contentPages))
		{
			$this->contentPages = array();
			
			$pages = $this->getPages();
			foreach($pages as $page)
			{
				$this->contentPages[] = $page->getContentPage();
			}
		}
		return $this->contentPages;
	}

}

?>