<?php

class CrawlSiteRule extends DataObject
{

	const PRIMARY_KEY	= 'id';
	const PIECE			= 'piece';
	const RULE			= 'rule';
	const ACTIVE		= 'active';

	public static $IS_ACTIVE		= 1;
	public static $IS_NOT_ACTIVE	= 0;

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'crawl_site_rule';
	}

	public function getPiece()
	{
		return $this->get_field(self::PIECE);
	}

	public function getRule()
	{
		return $this->get_field(self::RULE);
	}

	public function isActive()
	{
		return $this->get_field(self::ACTIVE) == self::$IS_ACTIVE;
	}

}

?>