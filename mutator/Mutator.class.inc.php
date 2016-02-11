<?php

abstract class Mutator
{

	private $model_name;
	private $action;
	private $can_save = true;

	protected $object;

	private $actor;
	private $message;

	function __construct($model_name, $action)
	{
		$this->model_name = $model_name;
		$this->action = $action;
	}

	final public function setObject($object)
	{
		$this->object = $object;
		return $this;
	}

	public function checkExist()
	{
		if($this->object->exists())
			$this->can_save = false;
		return $this;
	}

	public function execute()
	{
		if(!$this->can_save)
			return;
		
		switch($this->action)
		{
			case 'Create' :
			case 'Update' :
				$this->object->save();
			break;
			case 'Delete' :
				$this->object->delete();
			break;
		}
		
		return $this->object;
	}

	public static function instance($model_name, $action)
	{
		Loader::load('mutator', self::get_file_name($model_name, $action));
		$mutation_name = $action . $model_name;
		$reflection = new ReflectionClass($mutation_name);
		return $reflection->newInstance($model_name, $action);
	}

	private static function get_file_name($model_name, $action)
	{
		$reflection = new ReflectionClass($model_name);
		$path = $reflection->getFileName();
		
		if(strstr($path, '/'))
			$path = explode('/', $path);
		else
			$path = explode('\\', $path);
		
		$offset = array_search('model', $path);
		$offset += 1;
		$end = count($path);
		$end -= 1;
		$length = $end - $offset;
		
		$path = array_slice($path, $offset, $length);
		$path = implode('/', $path);
		
		return $path . '/' . $action . $model_name;
	}

}

?>