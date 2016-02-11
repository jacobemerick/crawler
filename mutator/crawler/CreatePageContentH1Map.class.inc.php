<?php

class CreatePageContentH1Map extends Mutator
{

	public function setData(Page $page, ContentH1 $contentH1)
	{
		$this->object = new PageContentH1Map();
		$this->object->setPage($page);
		$this->object->setContentH1($contentH1);
		return $this;
	}

}

?>