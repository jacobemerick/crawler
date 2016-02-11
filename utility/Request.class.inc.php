<?php

class Request
{

	private static $server = array();
	private static $get = array();
	private static $post = array();

	private static $AJAX_REQUEST = 'HTTP_X_REQUESTED_WITH';

	static function init()
	{
		self::make_server();
		self::make_get();
		self::make_post();
	}

	static function getServer($key = null)
	{
		if($key)
		{
			if(isset(self::$server[$key]))
				return self::$server[$key];
			return false;
		}
		return self::$server;
	}

	static function isAjax()
	{
		if(self::getServer(self::$AJAX_REQUEST))
			return true;
		return false;
	}

	static function getGet($key = null)
	{
		if($key)
		{
			if(isset(self::$get[$key]))
				return self::$get[$key];
			return false;
		}
		return self::$get;
	}

	static function getPost($key = null)
	{
		if($key)
		{
			if(isset(self::$post[$key]))
				return self::$post[$key];
			return false;
		}
		return self::$post;
	}

	public static function hasPost()
	{
		return is_array(self::$post) && !empty(self::$post);
	}

	static function make_server()
	{
		self::$server = $_SERVER;
	}

	static function make_get()
	{
		self::$get = $_GET;
	}

	static function make_post()
	{
		self::$post = $_POST;
	}

}

Request::init();

?>