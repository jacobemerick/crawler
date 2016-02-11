<?php

class Finder extends DataCollection
{

	private function get_collection()
	{
		$this->setLimit(1);
		$rows = $this->load_collection();
		
		$reflection = new ReflectionClass($this->model_name);
		$array = array();
		foreach($rows as $row)
		{
			$object = $reflection->newInstance($row->id);
			$object->load($row);
			$array[] = $object;
		}
		return $array;
	}

	function __call($name, $arguments)
	{
		if($name == 'get' . $this->model_name)
		{
			$collection = $this->get_collection();
			return array_pop($collection);
		}
		return parent::__call($name, $arguments);
	}

}

?>