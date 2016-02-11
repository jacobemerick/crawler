<?php

Loader::load('model', 'DataCollection');

class Collection extends DataCollection
{

	private function get_collection()
	{
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
		if($name == 'get' . $this->model_name . 's')
			return $this->get_collection();
		if($name == 'get' . $this->model_name . 'es')
			return $this->get_collection();
		if($name == 'get' . substr($this->model_name, 0, -1) . 'ies')
			return $this->get_collection();
		return parent::__call($name, $arguments);
	}

}

?>