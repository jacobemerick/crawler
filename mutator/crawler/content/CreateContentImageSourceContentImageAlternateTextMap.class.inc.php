<?php

class CreateContentImageSourceContentImageAlternateTextMap extends Mutator
{

	public function setData(ContentImageSource $contentImageSource, ContentImageAlternateText $contentImageAlternateText)
	{
		$this->object = new ContentImageSourceContentImageAlternateTextMap();
		$this->object->setContentImageSource($contentImageSource);
		$this->object->setContentImageAlternateText($contentImageAlternateText);
		return $this;
	}

}

?>