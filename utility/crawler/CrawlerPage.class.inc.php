<?php

Loader::load('model', array(
	'crawler/Domain',
	'crawler/Link',
	'crawler/Page',
	'crawler/PageContentH1Map',
	'crawler/PageContentImageSourceMap',
	'crawler/PageLinkMap',
	'crawler/PageMetaKeywordMap',
	'crawler/content/ContentH1',
	'crawler/content/ContentImageAlternateText',
	'crawler/content/ContentImageSource',
	'crawler/content/ContentImageSourceContentImageAlternateTextMap',
	'crawler/content/ContentPage',
	'crawler/meta/MetaDescription',
	'crawler/meta/MetaKeyword',
	'crawler/meta/MetaTitle'));

class CrawlerPage
{

	private static $MATCH_HTTP_CODE				= '@HTTP([^\s]+)\s(\d+)\s(.*)@';
	private static $MATCH_TITLE					= '@<title>(.*)</title>@';
	private static $MATCH_META_REDIRECT			= '@<meta http-equiv="refresh" content="(\d+)" />@';
	private static $MATCH_META_DESCRIPTION		= '@<meta name="description" content="(.*)" />@';
	private static $MATCH_META_KEYWORD			= '@<meta name="keywords" content="(.*)" />@';
	private static $MATCH_CONTENT_H1			= '@<h1(.*)>(.*)</h1>@';
	private static $MATCH_CONTENT_IMAGE			= '@<img(.*)>@';
	private static $MATCH_IMAGE_SOURCE			= '@src="([^"]+)"@';
	private static $MATCH_IMAGE_ALTERNATE_TEXT	= '@alt="([^"]+)"@';
	private static $MATCH_LINK					= '@href="([^"]+)"@';

	private static $GOOGLEBOT_HEADERS = array(
		'http' => array(
			'method' => 'GET',
			'user_agent' => 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)'));

	private $crawlerURL;
	private $data;
	private $headers;
	private $date_accessed;
	private $page;

	private function __construct(CrawlerURL $crawlerURL)
	{
		$this->crawlerURL = $crawlerURL;
	}

	public static function instance(CrawlerURL $crawlerURL)
	{
		return new CrawlerPage($crawlerURL);
	}

	public function execute()
	{
		$this->data = $this->file_get_contents();
		$this->headers = $this->file_get_headers();
		$this->date_accessed = time();
		return $this;
	}

	public function save()
	{
		$domain = Finder::instance('Domain')
			->setNameFilter($this->crawlerURL->getDomain())
			->getDomain();
		
		if(!isset($domain))
		{
			$domain = Mutator::instance('Domain', 'Create')
				->setData($this->crawlerURL->getDomain())
				->execute();
		}
		
		$link = Finder::instance('Link')
			->setNameFilter($this->crawlerURL->getAbsoluteURL())
			->getLink();
		
		if(!isset($link))
		{
			$link = Mutator::instance('Link', 'Create')
				->setData($this->crawlerURL->getAbsoluteURL())
				->execute();
		}
		
		$metaTitle = Finder::instance('MetaTitle')
			->setNameFilter($this->getMetaTitle())
			->getMetaTitle();
		
		if(!isset($metaTitle))
		{
			$metaTitle = Mutator::instance('MetaTitle', 'Create')
				->setData($this->getMetaTitle())
				->execute();
		}
		
		$metaDescription = Finder::instance('MetaDescription')
			->setNameFilter($this->getMetaDescription())
			->getMetaDescription();
		
		if(!isset($metaDescription))
		{
			$metaDescription = Mutator::instance('MetaDescription', 'Create')
				->setData($this->getMetaDescription())
				->execute();
		}
		
		$contentPage = Finder::instance('ContentPage')
			->setNameFilter($this->getContentPage())
			->getContentPage();
		
		if(!isset($contentPage))
		{
			$contentPage = Mutator::instance('ContentPage', 'Create')
				->setData($this->getContentPage())
				->execute();
		}
		
		$page = Finder::instance('Page')
			->setDomainFilter($domain->getID())
			->setLinkFilter($link->getID())
			->setMetaTitleFilter($metaTitle->getID())
			->setMetaDescriptionFilter($metaDescription->getID())
			->setMetaRedirectFilter($this->hasMetaRedirect())
			->setContentPageFilter($contentPage->getID())
			->setHTTPCodeFilter($this->getHTTPCode())
			->getPage();
		
		if(!isset($page))
		{
			$page = Mutator::instance('Page', 'Create')
				->setData($domain, $link, $metaTitle, $metaDescription, $this->hasMetaRedirect(), $contentPage, $this->getHTTPCode(), $this->getDateAccessed())
				->execute();
		}
		
		$this->page = $page;
		
		foreach($this->getContentH1s() as $contentH1)
		{
			$contentH1Object = Finder::instance('ContentH1')
				->setNameFilter($contentH1)
				->getContentH1();
			
			if(!isset($contentH1Object))
			{
				$contentH1Object = Mutator::instance('ContentH1', 'Create')
					->setData($contentH1)
					->execute();
			}
			
			$pageContentH1Map = Mutator::instance('PageContentH1Map', 'Create')
				->setData($page, $contentH1Object)
				->execute();
		}
		
		foreach($this->getContentImages() as $image)
		{
			$contentImageSource = Finder::instance('ContentImageSource')
				->setNameFilter($image->source)
				->getContentImageSource();
			
			if(!isset($contentImageSource))
			{
				$contentImageSource = Mutator::instance('ContentImageSource', 'Create')
					->setData($image->source)
					->execute();
			}
			
			$pageContentImageSourceMap = Finder::instance('PageContentImageSourceMap')
				->setPageFilter($page->getID())
				->setContentImageSourceFilter($contentImageSource->getID())
				->getPageContentImageSourceMap();
			
			if(!$pageContentImageSourceMap)
			{
				$pageContentImageSourceMap = Mutator::instance('PageContentImageSourceMap', 'Create')
					->setData($page, $contentImageSource)
					->execute();
			}
			
			if(strlen($image->alternate_text) > 0)
			{
				
				$contentImageAlternateText = Finder::instance('ContentImageAlternateText')
					->setNameFilter($image->alternate_text)
					->getContentImageAlternateText();
				
				if(!isset($contentImageAlternateText))
				{
					$contentImageAlternateText = Mutator::instance('ContentImageAlternateText', 'Create')
						->setData($image->alternate_text)
						->execute();
				}
				
				$contentImageSourceContentImageAlternateTextMap = Finder::instance('ContentImageSourceContentImageAlternateTextMap')
					->setContentImageSourceFilter($contentImageSource->getID())
					->setContentImageAlternateTextFilter($contentImageAlternateText->getID())
					->getContentImageSourceContentImageAlternateTextMap();
				
				if(!isset($contentImageSourceContentImageAlternateTextMap))
				{
					$contentImageSourceContentImageAlternateTextMap = Mutator::instance('ContentImageSourceContentImageAlternateTextMap', 'Create')
						->setData($contentImageSource, $contentImageAlternateText)
						->execute();
				}
			}
		}
		
		foreach($this->get_links() as $crawlerLink)
		{
			if(!$crawlerLink->isContentLink())
				continue;
			
			$link = Finder::instance('Link')
				->setNameFilter($crawlerLink->getAbsoluteURL())
				->getLink();
			
			if(!isset($link))
			{
				$link = Mutator::instance('Link', 'Create')
					->setData($crawlerLink->getAbsoluteURL())
					->execute();
			}
			
			$host = $domain->getName();
			$host = str_replace('http://', '', $host);
			
			$pageLinkMap = Finder::instance('PageLinkMap')
				->setPageFilter($page->getID())
				->setLinkFilter($link->getID())
				->setInternalLinkFilter($crawlerLink->isInternalLink($host))
				->getPageLinkMap();
			
			if(!$pageLinkMap)
			{
				$pageLinkMap = Mutator::instance('PageLinkMap', 'Create')
					->setData($page, $link, $crawlerLink->isInternalLink($host))
					->execute();
			}
		}
		
		foreach($this->getMetaKeywords() as $metaKeyword)
		{
			$keyword = Finder::instance('MetaKeyword')
				->setNameFilter($metaKeyword)
				->getMetaKeyword();
			
			if(!isset($keyword))
			{
				$keyword = Mutator::instance('MetaKeyword', 'Create')
					->setData($metaKeyword)
					->execute();
			}
			
			$pageKeywordMap = Finder::instance('PageMetaKeywordMap')
				->setPageFilter($page->getID())
				->setMetaKeywordFilter($keyword->getID())
				->getPageMetaKeywordMap();
			
			if(!$pageKeywordMap)
			{
				$pageKeywordMap = Mutator::instance('PageMetaKeywordMap', 'Create')
					->setData($page, $keyword)
					->execute();
			}
		}
	}

	private function file_get_contents()
	{
		$context = stream_context_create(self::$GOOGLEBOT_HEADERS);
		return file_get_contents($this->crawlerURL->getURL(), false, $context);
	}

	private function file_get_headers()
	{
		$headers = get_headers($this->crawlerURL->getURL(), 1);
		return $headers;
	}

	private $http_code;
	public function getHTTPCode()
	{
		if(!isset($this->http_code))
		{
			$code = $this->headers[0];
			preg_match(self::$MATCH_HTTP_CODE, $code, $matches);
			$this->http_code = $matches[2];
		}
		return $this->http_code;
	}

	private $external_links;
	public function getExternalLinks()
	{
		if(!isset($this->external_links))
		{
			$links = $this->get_links();
			$host = $this->crawlerURL->getHost();
			
			$this->external_links = array();
			foreach($links as $link)
			{
				if(!$link->isInternalLink($host) && $link->isContentLink())
					$this->external_links[] = $link->getAbsoluteURL();
			}
		}
		return $this->external_links;
	}

	private $internal_links;
	public function getInternalLinks()
	{
		if(!isset($this->internal_links))
		{
			$links = $this->get_links();
			$host = $this->crawlerURL->getHost();
			
			$this->internal_links = array();
			foreach($links as $link)
			{
				if($link->isInternalLink($host) && $link->isContentLink())
					$this->internal_links[] = $link->getAbsoluteURL();
			}
		}
		return $this->internal_links;
	}

	private $links;
	private function get_links()
	{
		if(!isset($this->links))
		{
			preg_match_all(self::$MATCH_LINK, $this->data, $match);
			if(isset($match[1]) && is_array($match[1]))
			{
				$links = array();
				foreach($match[1] as $link)
				{
					if(stristr($link, 'http://') != $link)
						$link = $this->crawlerURL->getDomain() . $link;
					
					$links[] = CrawlerURL::instance($link);
				}
				$this->links = $links;
			}
			else
				$this->links = array();
		}
		return $this->links;
	}

	private $title;
	public function getMetaTitle()
	{
		if(!isset($this->title))
		{
			preg_match(self::$MATCH_TITLE, $this->data, $match);
			if(isset($match[1]) && is_string($match[1]))
				$this->title = $match[1];
			else
				$this->title = '';
		}
		return $this->title;
	}

	private $has_meta_redirect;
	public function hasMetaRedirect()
	{
		if(!isset($this->has_meta_redirect))
		{
			if(preg_match(self::$MATCH_META_REDIRECT, $this->data) > 0)
				$this->has_meta_redirect = true;
			else
				$this->has_meta_redirect = false;
		}
		return $this->has_meta_redirect;
	}

	private $meta_description;
	public function getMetaDescription()
	{
		if(!isset($this->meta_description))
		{
			preg_match(self::$MATCH_META_DESCRIPTION, $this->data, $match);
			if(isset($match[1]) && is_string($match[1]))
				$this->meta_description = $match[1];
			else
				$this->meta_description = '';
		}
		return $this->meta_description;
	}

	private $meta_keywords;
	public function getMetaKeywords()
	{
		if(!isset($this->meta_keywords))
		{
			preg_match(self::$MATCH_META_KEYWORD, $this->data, $match);
			if(isset($match[1]) && is_string($match[1]))
			{
				$meta_keywords = $match[1];
				$meta_keywords = explode(',', $meta_keywords);
				$this->meta_keywords = $meta_keywords;
			}
			else
				$this->meta_keywords = array();
		}
		return $this->meta_keywords;
	}

	private $content_h1s;
	public function getContentH1s()
	{
		if(!isset($this->content_h1s))
		{
			preg_match_all(self::$MATCH_CONTENT_H1, $this->data, $match);
			if(isset($match[2]) && is_array($match[2]))
				$this->content_h1s = $match[2];
			else
				$this->content_h1s = array();
		}
		return $this->content_h1s;
	}

	private $content_images;
	public function getContentImages()
	{
		if(!isset($this->content_images))
		{
			preg_match_all(self::$MATCH_CONTENT_IMAGE, $this->data, $match);
			if(isset($match[0]) && is_array($match[0]) && count($match[0]) > 0)
			{
				foreach($match[0] as $image)
				{
					preg_match(self::$MATCH_IMAGE_SOURCE, $image, $match);
					if(isset($match[1]) && is_string($match[1]))
						$source = $match[1];
					else
						$source = '';
					
					preg_match(self::$MATCH_IMAGE_ALTERNATE_TEXT, $image, $match);
					if(isset($match[1]) && is_string($match[1]))
						$alternate_text = $match[1];
					else
						$alternate_text = '';
					
					$this->content_images[] = (object) array(
						'source' => $source,
						'alternate_text' => $alternate_text);
				}
			}
			else
				$this->content_images = array();
		}
		return $this->content_images;
	}

	public function getContentPage()
	{
		return $this->data;
	}

	public function getDateAccessed()
	{
		return date('Y-m-d g:i:s', $this->date_accessed);
	}

	public function getPage()
	{
		return $this->page;
	}

}

?>