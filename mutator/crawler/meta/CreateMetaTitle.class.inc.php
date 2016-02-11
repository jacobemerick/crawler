<?php

class CreateMetaTitle extends Mutator
{

	public function setData($name)
	{
		$this->object = new MetaTitle();
		$this->object->setName($name);
		return $this;
	}

}

?>