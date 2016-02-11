<?php

class CreateContentImageAlternateText extends Mutator
{

	public function setData($name)
	{
		$this->object = new ContentImageAlternateText();
		$this->object->setName($name);
		return $this;
	}

}

?>