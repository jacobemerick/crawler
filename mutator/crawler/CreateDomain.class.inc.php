<?php

class CreateDomain extends Mutator
{

	public function setData($name)
	{
		$this->object = new Domain();
		$this->object->setName($name);
		return $this;
	}

}

?>