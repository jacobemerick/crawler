<?php

class ContentPage extends DataObject
{

	const PRIMARY_KEY	= 'id';
	const NAME			= 'name';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'content_page';
	}

	public function getName()
	{
		return $this->get_field(self::NAME);
	}

	public function setName($name)
	{
		$this->set_field(self::NAME, $name);
	}

}

?>