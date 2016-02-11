<?php

class CrawlerURL
{

	private $url;

	private function __construct($url)
	{
		$this->url = $url;
	}

	public static function instance($url)
	{
		return new CrawlerURL($url);
	}

	public function isInternalLink($host)
	{
		return $this->getHost() == $host;
	}

	public function isContentLink()
	{
		$extension = $this->getExtension();
		
		if(
			$extension == 'css' ||
			$extension == 'js' ||
			$extension == 'ico' ||
			$extension == 'jpg' ||
			$extension == 'xml')
		{
			return false;
		}
		
		return true;
	}

	public function getDomain()
	{
		$url = '';
		$url .= $this->getScheme();
		$url .= '://';
		$url .= $this->getHost();
		return $url;
	}

	public function getAbsoluteURL()
	{
		$url = '';
		$url .= $this->getScheme();
		$url .= '://';
		$url .= $this->getHost();
		$url .= $this->getPath();
		return $url;
	}

	public function getRelativeURL()
	{
		exit('not completed yet');
	}

	public function getURL()
	{
		return $this->url;
	}

	public function getExtension()
	{
		$path = $this->getPath();
		$path = explode('/', $path);
		$path = array_pop($path);
		$path = explode('.', $path);
		
		if(count($path) > 1)
			return array_pop($path);
		return '';
	}

	public function getScheme()
	{
		return $this->get_part('scheme');
	}

	public function getHost()
	{
		return $this->get_part('host');
	}

	public function getPort()
	{
		return $this->get_part('port');
	}

	public function getUser()
	{
		return $this->get_part('user');
	}

	public function getPass()
	{
		return $this->get_part('pass');
	}

	public function getPath()
	{
		return $this->get_part('path');
	}

	public function getQuery()
	{
		return $this->get_part('query');
	}

	public function getFragment()
	{
		return $this->get_part('fragment');
	}

	private function get_part($part)
	{
		$parsed_url = $this->get_parsed_url();
		return $parsed_url->$part;
	}

	private $parsed_url;
	private function get_parsed_url()
	{
		if(!isset($this->parsed_url))
		{
			$parsed_url = @parse_url($this->url);
			$this->parsed_url = new stdclass();
			
			$this->parsed_url->scheme = (isset($parsed_url['scheme'])) ? $parsed_url['scheme'] : 'http';
			
			if(isset($parsed_url['host']))
				$this->parsed_url->host = $parsed_url['host'];
			else
			{
				$host = $parsed_url['path'];
				$host = explode('/', $host, 2);
				$host = array_shift($host);
				$this->parsed_url->host = $host;
			}
			
			$this->parsed_url->user = (isset($parsed_url['user'])) ? $parsed_url['user'] : '';
			$this->parsed_url->pass = (isset($parsed_url['pass'])) ? $parsed_url['pass'] : '';
			$this->parsed_url->path = (isset($parsed_url['path'])) ? $parsed_url['path'] : '';
			$this->parsed_url->query = (isset($parsed_url['query'])) ? $parsed_url['query'] : '';
			$this->parsed_url->fragment = (isset($parsed_url['fragment'])) ? $parsed_url['fragment'] : '';
		}
		return $this->parsed_url;
	}

	public static function fixURL($url, $domain)
	{
		return $url;
	}

}

?>