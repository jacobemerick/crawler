<?php

class CreateContentImageSource extends Mutator
{

	public function setData($name)
	{
		$this->object = new ContentImageSource();
		$this->object->setName($name);
		return $this;
	}

}

?>