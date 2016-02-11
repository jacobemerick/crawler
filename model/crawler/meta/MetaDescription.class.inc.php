<?php

class MetaDescription extends DataObject
{

	const PRIMARY_KEY	= 'id';
	const NAME			= 'name';

	public static function getDatabase()
	{
		return '526592_crawler';
	}

	public static function getTable()
	{
		return 'meta_description';
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