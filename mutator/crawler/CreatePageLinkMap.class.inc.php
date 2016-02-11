<?php

class CreatePageLinkMap extends Mutator
{

	public function setData(Page $page, Link $link, $is_internal_link)
	{
		$this->object = new PageLinkMap();
		$this->object->setPage($page);
		$this->object->setLink($link);
		$this->object->setInternalLInk($is_internal_link);
		return $this;
	}

}

?>