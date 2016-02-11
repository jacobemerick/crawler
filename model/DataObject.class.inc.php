<?php

Loader::load('utility', 'Database');

abstract class DataObject
{

	const PRIMARY_KEY = 'id';

	private $key_values = array();
	private $changed_key_values = array();
	private $invalid_key_values = array();

	private $primary_key;

	public function __construct($id = null)
	{
		if(isset($id))
			$this->primary_key = $id;
	}

	//abstract public static function getDatabase();
	//abstract public static function getTable();

	public static function getPrimaryKey()
	{
		return self::PRIMARY_KEY;;
	}

	public function getID()
	{
		return $this->primary_key;
	}

	final private function load_from_database()
	{
		$query = "
			SELECT
				*
			FROM
				`{$this->getDatabase()}`.`{$this->getTable()}`
			WHERE
				`{$this->getPrimaryKey()}` = '{$this->primary_key}'
			LIMIT 1";
		$row = Database::selectRow($query);
		$this->load($row);
	}

	final public function load($row)
	{
		foreach($row as $key => $value)
		{
			$this->set_field($key, $value);
		}
	}

	final protected function get_field($key)
	{
		if(!isset($this->key_values[$key]))
			$this->load_from_database();
		
		if(!isset($this->key_values[$key]))
			trigger_error("Tried to get an invalid key {$key} from table!");
		else
			return $this->key_values[$key];
	}

	final protected function set_field($key, $value)
	{
		if($key == $this->getPrimaryKey())
			$this->primary_key = $value;
		else
		{
			if(isset($this->key_values[$key]) && $this->key_values[$key] != $value)
				$this->changed_key_values[$key] = $value;
			else
				$this->key_values[$key] = $value;
		}
	}

	final private function get_mutate_keys()
	{
		$keys = array_keys($this->key_values);
		$keys = implode("`,`", $keys);
		$keys = "(`{$keys}`)";
		return $keys;
	}

	final private function get_mutate_values()
	{
		$values = array_map(array('Database', 'escape'), $this->key_values);
		$values = array_values($values);
		$values = implode("','", $values);
		$values = "('{$values}')";
		return $values;
	}

	final private function get_mutate_pairs()
	{
		$values = array_map(array('Database', 'escape'), $this->changed_key_values);
		$mutate_array = array();
		foreach($values as $key => $value)
		{
			$mutate_array[] = "`{$key}` = '{$value}'";
		}
		$mutate = implode(', ', $mutate_array);
		return $mutate;
	}

	final private function get_where_clause()
	{
		$values = array_map(array('Database', 'escape'), $this->key_values);
		
		$clause_array = array();
		foreach($values as $key => $value)
		{
			$clause_array[] = "`$key` = '$value'";
		}
		$clause = implode(" && ", $clause_array);
		return $clause;
	}

	final public function save()
	{
		if(isset($this->primary_key))
		{
			if(!empty($this->changed_key_values))
				$this->save_as_update();
		}
		else
		{
			$this->save_as_insert();
			$this->set_primary_key();
		}
		return true;
	}

	final public function delete()
	{
		return $this->delete_row();
	}

	final private function delete_row()
	{
		$query = "
			DELETE FROM
				`{$this->getDatabase()}`.`{$this->getTable()}`
			WHERE
				`{$this->getPrimaryKey()}` = '{$this->primary_key}'";
		return Database::execute($query);
	}

	final private function save_as_insert()
	{
		$query = "
			INSERT INTO
				`{$this->getDatabase()}`.`{$this->getTable()}`
				{$this->get_mutate_keys()}
			VALUES
				{$this->get_mutate_values()}";
		return Database::execute($query);
	}

	final private function save_as_update()
	{
		$query = "
			UPDATE
				`{$this->getDatabase()}`.`{$this->getTable()}`
			SET
				{$this->get_mutate_pairs()}
			WHERE
				`{$this->getPrimaryKey()}` = '{$this->primary_key}'";
		return Database::execute($query);
	}

	final private function set_primary_key()
	{
		$this->primary_key = Database::lastInsertID();
		return $this->primary_key;
	}

	final public function exists()
	{
		return $this->check_as_where();
	}

	final private function check_as_where()
	{
		$query = "
			SELECT
				1
			FROM
				`" . $this->getDatabase() . "`.`" . $this->getTable() . "`
			WHERE
				{$this->get_where_clause()}
			LIMIT 1";
		$result = Database::selectRow($query);
		return count(Database::select($query)) === 1;
	}

}

?>