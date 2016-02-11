<?php

class CreateCrawlSiteQueue extends Mutator
{

	public function setData(Domain $domain, $status)
	{
		$this->object = new CrawlSiteQueue();
		$this->object->setDomain($domain);
		$this->object->setStatus($status);
		return $this;
	}

}

?>