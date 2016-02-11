<?php

class Loader
{

	private static $root;
	private static $included_files = array();

	private static function get_class_name($file)
	{
		$array = explode('/', $file);
		return array_pop($array);
	}

	public static function setRoot($root)
	{
		self::$root = $root;
	}

	public static function getRoot()
	{
		return self::$root;
	}

	private static function get_path($type, $file)
	{
		$path = self::$root . "/{$type}/{$file}";
		
		switch($type)
		{
			case 'controller' :
			case 'model' :
			case 'mutator' :
			case 'utility' :
				$path .= '.class.inc.php';
			break;
			case 'view' :
				$path .= '.tpl.php';
			break;
		}
		return $path;
	}

	public static function load($type, $files, $data = array())
	{
		foreach((array)$files as $file)
		{
			$path = self::get_path($type, $file);
			if(!in_array($path, self::$included_files))
			{
				extract($data);
				switch($type)
				{
					case 'view':
						include($path);
					break;
					default:
						include_once($path);
						self::$included_files[] = $path;
					break;
				}
			}
		}
	}

	public static function loadNew($type, $file, $data = array())
	{
		self::load($type, $file);
		$class_name = self::get_class_name($file);
		$reflectionObject = new ReflectionClass($class_name);
		if($reflectionObject->hasMethod('__construct'))
			return $reflectionObject->newInstanceArgs($data);
		else
			return $reflectionObject->newInstance();
	}

}

?>