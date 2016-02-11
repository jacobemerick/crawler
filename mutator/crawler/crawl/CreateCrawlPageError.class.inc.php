<?php

class CreateCrawlPageError extends Mutator
{

	public function setData(Page $page, CrawlPageRule $crawlPageRule, $message)
	{
		$this->object = new CrawlPageError();
		$this->object->setPage($page);
		$this->object->setCrawlPageRule($crawlPageRule);
		$this->object->setMessage($message);
		return $this;
	}

}

?>