<?php

class ContentImageSourceContentImageAlternateTextMap extends DataObject
{

	const PRIMARY_KEY					= 'id';
	const CONTENT_IMAGE_SOURCE			= 'content_image_source_id';
	const CONTENT_IMAGE_ALTERNATE_TEXT	= 'content_image_alternate_text_id';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'content_image_source_content_image_alternate_text_map';
	}

	private $contentImageSource;
	public function getContentImageSource()
	{
		if(!isset($this->contentImageSource))
			$this->contentImageSource = new ContentImageSource($this->get_field(self::CONTENT_IMAGE_SOURCE));
		return $this->contentImageSource;
	}

	public function setContentImageSource(ContentImageSource $contentImageSource)
	{
		$this->contentImageSource = $contentImageSource;
		$this->set_field(self::CONTENT_IMAGE_SOURCE, $contentImageSource->getID());
	}

	private $contentImageAlternateText;
	public function getContentImageAlternateText()
	{
		if(!isset($this->contentImageAlternateText))
			$this->contentImageAlternateText = new ContentImageAlternateText($this->get_field(self::CONTENT_IMAGE_ALTERNATE_TEXT));
		return $this->contentImageAlternateText;
	}

	public function setContentImageAlternateText(ContentImageAlternateText $contentImageAlternateText)
	{
		$this->contentImageAlternateText = $contentImageAlternateText;
		$this->set_field(self::CONTENT_IMAGE_ALTERNATE_TEXT, $contentImageAlternateText->getID());
	}

}

?>