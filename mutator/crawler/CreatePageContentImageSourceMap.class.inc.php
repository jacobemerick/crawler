<?php

class CreatePageContentImageSourceMap extends Mutator
{

	public function setData(Page $page, ContentImageSource $contentImageSource)
	{
		$this->object = new PageContentImageSourceMap();
		$this->object->setPage($page);
		$this->object->setContentImageSource($contentImageSource);
		return $this;
	}

}

?>