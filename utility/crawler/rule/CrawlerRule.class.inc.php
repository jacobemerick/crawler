<?php

abstract class CrawlerRule
{

	private $error;

	public function __construct() {}

	abstract protected function run_check();

	final public function execute()
	{
		$this->run_check();
		
		if(isset($this->error))
			return $this->error;
		
		return;
	}

	final protected function error($error_message)
	{
		$this->error = $error_message;
	}

}

?>