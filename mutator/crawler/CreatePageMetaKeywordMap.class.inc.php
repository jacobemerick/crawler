<?php

class CreatePageMetaKeywordMap extends Mutator
{

	public function setData(Page $page, MetaKeyword $metaKeyword)
	{
		$this->object = new PageMetaKeywordMap();
		$this->object->setPage($page);
		$this->object->setMetaKeyword($metaKeyword);
		return $this;
	}

}

?>