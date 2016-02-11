<?php

class CreateContentH1 extends Mutator
{

	public function setData($name)
	{
		$this->object = new ContentH1();
		$this->object->setName($name);
		return $this;
	}

}

?>