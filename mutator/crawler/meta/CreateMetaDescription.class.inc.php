<?php

class CreateMetaDescription extends Mutator
{

	public function setData($name)
	{
		$this->object = new MetaDescription();
		$this->object->setName($name);
		return $this;
	}

}

?>