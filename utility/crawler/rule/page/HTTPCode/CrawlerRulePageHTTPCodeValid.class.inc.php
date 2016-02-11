<?php

Loader::load('utility', 'crawler/rule/page/HTTPCode/CrawlerRulePageHTTPCode');

class CrawlerRulePageHTTPCodeValid extends CrawlerRulePageHTTPCode
{

	private static $HTTP_CODE_VALID = 200;

	protected function run_check()
	{
		$http_code = $this->get_http_code();
		$pass = ($http_code == self::$HTTP_CODE_VALID);
		
		if(!$pass)
			$this->error('Invalid HTTP return code detected!');
	}

}

?>