<?php

Loader::load('model', array(
	'crawler/Page',
	'crawler/Link'));

class PageLinkMap extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const PAGE				= 'page_id';
	const LINK				= 'link_id';
	const INTERNAL_LINK		= 'is_internal_link';

	private static $IS_INTERNAL_LINK	= 1;
	private static $IS_EXTERNAL_LINK	= 0;

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'page_link_map';
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

	private $link;
	public function getLink()
	{
		if(!isset($this->link))
			$this->link = new Link($this->get_field(self::LINK));
		return $this->link;
	}

	public function setLink(Link $link)
	{
		$this->link = $link;
		$this->set_field(self::LINK, $link->getID());
	}

	public function isInternalLink()
	{
		return ($this->get_field(self::INTERNAL_LINK) == self::$IS_INTERNAL_LINK);
	}

	public function isExternalLink()
	{
		return ($this->get_field(self::INTERNAL_LINK) == self::$IS_EXTERNAL_LINK);
	}

	public function setInternalLink($is_internal_link)
	{
		if($is_internal_link)
			$this->set_field(self::INTERNAL_LINK, self::$IS_INTERNAL_LINK);
		else
			$this->set_field(self::INTERNAL_LINK, self::$IS_EXTERNAL_LINK);
	}

}

?>