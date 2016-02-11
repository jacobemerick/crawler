<?php

class CreateContentPage extends Mutator
{

	public function setData($name)
	{
		$this->object = new ContentPage();
		$this->object->setName($name);
		return $this;
	}

}

?>