<?php

class Database
{

	private static $read;
	private static $write;

	private function __construct() {}

	private static $instance;
	public static function instance()
	{
		if(!self::$instance)
		{
			self::$instance = new Database();
			self::$read = new mysqli('SERVER', 'USER', 'PASS');
			self::$write = new mysqli('SERVER', 'USER', 'PASS');
		}
		return self::$instance;
	}

	public static function escape($string)
	{
		return self::$read->real_escape_string($string);
	}

	public static function select($query)
	{
		if($result = self::$read->query($query))
		{
			$array = array();
			while($row = $result->fetch_object())
				$array[] = $row;
			$result->close();
			return $array;
		}
		trigger_error("Could not preform query - {$query} - " . self::$read->error);
	}

	public static function selectRow($query)
	{
		$result = self::select($query);
		return $result[0];
	}

	public static function execute($query)
	{
		if(self::$write->query($query))
			return true;
		trigger_error("Could not preform query - {$query} - " . self::$write->error);
	}

	public static function lastInsertID()
	{
		$id = self::$write->insert_id;
		if($id == 0)
			return;
		return $id;
	}

}

Database::instance();

?>
