<?php

Loader::load('model', array(
	'crawler/Page',
	'crawler/content/ContentH1'));

class PageContentH1Map extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const PAGE				= 'page_id';
	const CONTENT_H1		= 'content_h1_id';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'page_content_h1_map';
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

	private $contentH1;
	public function getContentH1()
	{
		if(!isset($this->contentH1))
			$this->contentH1 = new ContentH1($this->get_field(self::CONTENT_H1));
		return $this->contentH1;
	}

	public function setContentH1(ContentH1 $contentH1)
	{
		$this->contentH1 = $contentH1;
		$this->set_field(self::CONTENT_H1, $contentH1->getID());
	}

}

?>