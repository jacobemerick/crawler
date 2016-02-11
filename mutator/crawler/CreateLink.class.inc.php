<?php

class CreateLink extends Mutator
{

	public function setData($name)
	{
		$this->object = new Link();
		$this->object->setName($name);
		return $this;
	}

}

?>