<?php

Loader::load('model', array(
	'crawler/Page',
	'crawler/meta/MetaKeyword'));

class PageMetaKeywordMap extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const PAGE				= 'page_id';
	const META_KEYWORD		= 'meta_keyword_id';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'page_meta_keyword_map';
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

	private $metaKeyword;
	public function getMetaKeyword()
	{
		if(!isset($this->metaKeyword))
			$this->metaKeyword = new MetaKeyword($this->get_field(self::META_KEYWORD));
		return $this->metaKeyword;
	}

	public function setMetaKeyword(MetaKeyword $metaKeyword)
	{
		$this->metaKeyword = $metaKeyword;
		$this->set_field(self::META_KEYWORD, $metaKeyword->getID());
	}

}

?>