<?php

class CreateCrawlSiteError extends Mutator
{

	public function setData(Domain $domain, CrawlSiteRule $crawlSiteRule, $message)
	{
		$this->object = new CrawlSiteError();
		$this->object->setDomain($domain);
		$this->object->setCrawlSiteRule($crawlSiteRule);
		$this->object->setMessage($message);
		return $this;
	}

}

?>