<?php

class UpdateCrawlSiteQueue extends Mutator
{

	public function setData(CrawlSiteQueue $crawlSiteQueue, $status)
	{
		$this->object = $crawlSiteQueue;
		$this->object->setStatus($status);
		return $this;
	}

}

?>