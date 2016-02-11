<?php

Loader::load('model', array(
	'collection/Collection',
	'collection/Finder'));
Loader::load('utility', 'Database');

abstract class DataCollection
{

	protected $model_name;
	protected $key;
	protected $database;
	protected $table;

	private $where_clause;
	private $order_clause;
	private $limit_clause;

	function __construct($model)
	{
		$this->model_name = $model;
		$this->key = call_user_func(array($model, 'getPrimaryKey'));
		$this->database = call_user_func(array($model, 'getDatabase'));
		$this->table = call_user_func(array($model, 'getTable'));
		
		return $this;
	}

	final private function set_filter($array)
	{
		if(isset($array['comparison']))
			$clause = "`{$array['column']}` {$array['comparison']} '" . Database::escape($array['value']) . "'";
		else
			$clause = "`{$array['column']}` = '" . Database::escape($array['value']) . "'";
		$this->where_clause[] = $clause;
	}

	final protected function set_multi_filter($array)
	{
		array_map(array('Database', 'escape'), $array['value']);
		$clause = "`{$array['column']}` IN ('" . implode("','", $array['value']) . "')";
		$this->where_clause[] = $clause;
	}

	final private function set_order($array)
	{
		if(isset($array['order']))
			$clause = "`{$array['column']}` {$array['order']}";
		else
			$clause = "`{$array['column']}` ASC";
		$this->order_clause[] = $clause;
	}

	public function setLimit($range, $offset = null)
	{
		if($offset)
			$this->limit_clause = "{$offset}, {$range}";
		else
			$this->limit_clause = "{$range}";
		
		return $this;
	}

	private function build_where_clause()
	{
		if(empty($this->where_clause))
			return;
		$where = implode(' && ', $this->where_clause);
		$where = " WHERE {$where}";
		return $where;
	}

	private function build_order_clause()
	{
		if(empty($this->order_clause))
			return;
		$order = implode(', ', $this->order_clause);
		$order = " ORDER BY {$order}";
		return $order;
	}

	private function build_limit_clause()
	{
		if(empty($this->limit_clause))
			return;
		$limit = " LIMIT {$this->limit_clause}";
		return $limit;
	}

	final protected function load_collection()
	{
		$query = "
			SELECT
				*
			FROM
				`{$this->database}`.`{$this->table}`
			{$this->build_where_clause()}
			{$this->build_order_clause()}
			{$this->build_limit_clause()}";
		$results = Database::select($query);
		return $results;
	}

	final protected function load_collection_count()
	{
		$query = "
			SELECT
				COUNT(1) AS `count`
			FROM
				`{$this->database}`.`{$this->table}`
			{$this->build_where_clause()}";
		$results = Database::select($query);
		return $results;
	}

	final protected function get_collection_count()
	{
		$count_result = $this->load_collection_count();
		$count_result = current($count_result);
		
		return $count_result->count;
	}

	final public static function instance($model)
	{
		// pre 5.3 sucks!
		$backtrace = debug_backtrace();
		$lines = file($backtrace[0]['file']);
		preg_match('/([a-zA-Z0-9_]+)::' . $backtrace[0]['function'] . '/', $lines[$backtrace[0]['line'] - 1], $matches);
		$class = $matches[1];
		$reflection = new ReflectionClass($class);
		return $reflection->newInstance($model);
	}

	function __call($name, $arguments)
	{
		if($name == 'get' . $this->model_name . 'Count')
			return $this->get_collection_count();
		
		if(substr($name, 0, 3) == 'set' && substr($name, -6) == 'Filter')
		{
			if(substr($name, -17, -6) == 'GreaterThan')
			{
				$comparison = '>=';
				$name = str_replace('GreaterThan', '', $name);
			}
			if(substr($name, -14, -6) == 'LessThan')
			{
				$comparison = '<=';
				$name = str_replace('LessThan', '', $name);
			}
			$column_name = substr($name, 3, strlen($name) - 9);
			$column_name = preg_replace('/(\B[A-Z])(?=[a-z])|(?<=[a-z])([A-Z])/sm', '_$1$2', $column_name);
			$column_name = strtoupper($column_name);
			$constant_name = "{$this->model_name}::{$column_name}";
			
			if(is_bool($arguments[0]))
				$value = $arguments[0] ? 1 : 0;
			else
				$value = $arguments[0];
			
			if(defined($constant_name))
			{
				if(is_array($value))
				{
					$filter = array(
						'column' => constant($constant_name),
						'value' => $value);
					if(isset($comparison))
						$filter['comparison'] = $comparison;
					
					$this->set_multi_filter($filter);
				}
				else
				{
					$filter = array(
						'column' => constant($constant_name),
						'value' => $value);
					if(isset($comparison))
						$filter['comparison'] = $comparison;
					
					$this->set_filter($filter);
				}
				return $this;
			}
		}
		
		if(substr($name, 0, 3) == 'set' && substr($name, -5) == 'Order')
		{
			$column_name = substr($name, 3, strlen($name) - 8);
			$column_name = strtoupper($column_name);
			$order = isset($arguments[0]) ? $arguments[0] : 'ASC';
			$constant_name = "{$this->model_name}::{$column_name}";
			
			if(defined($constant_name))
			{
				$this->set_order(array(
					'column' => constant($constant_name),
					'order' => $order));
				return $this;
			}
		}
		
		trigger_error("Called {$name} on DataCollection - does not exist!");
	}

}

?>