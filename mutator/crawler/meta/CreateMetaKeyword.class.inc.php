<?php

class CreateMetaKeyword extends Mutator
{

	public function setData($name)
	{
		$this->object = new MetaKeyword();
		$this->object->setName($name);
		return $this;
	}

}

?>