<?php

class UpdateCrawlPageQueue extends Mutator
{

	public function setData(CrawlPageQueue $crawlPageQueue, $status)
	{
		$this->object = $crawlPageQueue;
		$this->object->setStatus($status);
		return $this;
	}

}

?>