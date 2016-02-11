<?php

Loader::load('controller', '/PageController');
Loader::load('model', array(
	'crawler/crawl/CrawlPageQueue',
	'crawler/crawl/CrawlSiteQueue',
	'crawler/Domain',
	'crawler/Link'));
Loader::load('utility', array(
	'crawler/CrawlerURL',
	'Request'));

class HomeController extends PageController
{

	protected function set_data()
	{
		$this->set_title('Awesome Crawler');
		$this->set_head('description', 'A crawler that is awesome. Nuff said.');
		$this->set_head('keywords', 'awesome, crawler');
		
		$this->set_body('form_success', false);
		
		if(Request::getPost('domain'))
			$this->process_form();
		
		$this->set_body_view('Home');
	}

	private function process_form()
	{
		$domain = Request::getPost('domain');
		if(strlen($domain) < 1)
			return;
		
		$this->set_body('form_success', true);
		
		$url = CrawlerURL::instance($domain);
		
		$domain = $url->getDomain();
		$link = "{$domain}/";
		
		$domainObject = Finder::instance('Domain')
			->setNameFilter($domain)
			->getDomain();
		
		if(!$domainObject)
		{
			$domainObject = Mutator::instance('Domain', 'Create')
				->setData($domain)
				->execute();
		}
		
		$linkObject = Finder::instance('Link')
			->setNameFilter($link)
			->getLink();
		
		if(!$linkObject)
		{
			$linkObject = Mutator::instance('Link', 'Create')
				->setData($link)
				->execute();
		}
		
		$crawlSiteQueueObject = Finder::instance('CrawlSiteQueue')
			->setDomainFilter($domainObject->getID())
			->setStatusFilter(CrawlSiteQueue::$IS_UNCRAWLED)
			->getCrawlSiteQueue();
		
		if(!$crawlSiteQueueObject)
		{
			Mutator::instance('CrawlSiteQueue', 'Create')
				->setData($domainObject, CrawlSiteQueue::$IS_UNCRAWLED)
				->execute();
		}
		
		$crawlPageQueueObject = Finder::instance('CrawlPageQueue')
			->setDomainFilter($domainObject->getID())
			->setLinkFilter($linkObject->getID())
			->setStatusFilter(CrawlPageQueue::$IS_UNCRAWLED)
			->getCrawlPageQueue();
		
		if(!$crawlPageQueueObject)
		{
			Mutator::instance('CrawlPageQueue', 'Create')
				->setData($domainObject, $linkObject, CrawlPageQueue::$IS_UNCRAWLED)
				->execute();
		}
	}

}

?>