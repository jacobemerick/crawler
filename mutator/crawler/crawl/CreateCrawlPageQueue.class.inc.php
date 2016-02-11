<?php

class CreateCrawlPageQueue extends Mutator
{

	public function setData(Domain $domain, Link $link, $status)
	{
		$this->object = new CrawlPageQueue();
		$this->object->setDomain($domain);
		$this->object->setLink($link);
		$this->object->setStatus($status);
		return $this;
	}

}

?>