<?php

Loader::load('model', array(
	'crawler/Page',
	'crawler/content/ContentImageSource'));

class PageContentImageSourceMap extends DataObject
{

	const PRIMARY_KEY				= 'id';
	const PAGE						= 'page_id';
	const CONTENT_IMAGE_SOURCE		= 'content_image_source_id';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'page_content_image_source_map';
	}

	private $page;
	public function getPage()
	{
		if(!isset($this->page))
			$this->page = new Page($this->get_field(self::PAGE));
		return $this->page;
	}

	public function setPage(Page $page)
	{
		$this->page = $page;
		$this->set_field(self::PAGE, $page->getID());
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

}

?>