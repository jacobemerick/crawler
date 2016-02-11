<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/Link',
	'crawler/content/ContentPage',
	'crawler/meta/MetaDescription',
	'crawler/meta/MetaTitle'));

class Page extends DataObject
{

	const PRIMARY_KEY		= 'id';
	const DOMAIN			= 'domain_id';
	const LINK				= 'link_id';
	const CONTENT_PAGE		= 'content_page_id';
	const META_DESCRIPTION	= 'meta_description_id';
	const META_TITLE		= 'meta_title_id';
	const META_REDIRECT		= 'has_meta_redirect';
	const HTTP_CODE			= 'http_code';
	const DATE				= 'date';

	private static $HAS_META_REDIRECT		= 1;
	private static $HAS_NO_META_REDIRECT	= 0;

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'page';
	}

	private $domain;
	public function getDomain()
	{
		if(!isset($this->domain))
			$this->domain = new Domain($this->get_field(self::DOMAIN));
		return $this->domain;
	}

	public function setDomain(Domain $domain)
	{
		$this->domain = $domain;
		$this->set_field(self::DOMAIN, $domain->getID());
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

	private $contentPage;
	public function getContentPage()
	{
		if(!isset($this->contentPage))
			$this->contentPage = new ContentPage($this->get_field(self::CONTENT_PAGE));
		return $this->contentPage;
	}

	public function setContentPage(ContentPage $contentPage)
	{
		$this->contentPage = $contentPage;
		$this->set_field(self::CONTENT_PAGE, $contentPage->getID());
	}

	private $metaDescription;
	public function getMetaDescription()
	{
		if(!isset($this->metaDescription))
			$this->metaDescription = new MetaDescription($this->get_field(self::META_DESCRIPTION));
		return $this->metaDescription;
	}

	public function setMetaDescription(MetaDescription $metaDescription)
	{
		$this->metaDescription = $metaDescription;
		$this->set_field(self::META_DESCRIPTION, $metaDescription->getID());
	}

	private $metaTitle;
	public function getMetaTitle()
	{
		if(!isset($this->metaTitle))
			$this->metaTitle = new MetaTitle($this->get_field(self::META_TITLE));
		return $this->metaTitle;
	}

	public function setMetaTitle(MetaTitle $metaTitle)
	{
		$this->metaTitle = $metaTitle;
		$this->set_field(self::META_TITLE, $metaTitle->getID());
	}

	public function getMetaRedirect()
	{
		return ($this->get_field(self::META_REDIRECT) == self::$HAS_META_REDIRECT);
	}

	public function setMetaRedirect($has_meta_redirect)
	{
		if($has_meta_redirect)
			$this->set_field(self::META_REDIRECT, self::$HAS_META_REDIRECT);
		else
			$this->set_field(self::META_REDIRECT, self::$HAS_NO_META_REDIRECT);
	}

	public function getHTTPCode()
	{
		return $this->get_field(self::HTTP_CODE);
	}

	public function setHTTPCode($http_code)
	{
		$this->set_field(self::HTTP_CODE, $http_code);
	}

	public function getDateAccessed()
	{
		return $this->get_field(self::DATE);
	}

	public function setDateAccessed($date)
	{
		$this->set_field(self::DATE, $date);
	}

}

?>