<?php

Loader::load('utility', 'crawler/rule/page/metaRedirect/CrawlerRulePageMetaRedirect');

class CrawlerRulePageMetaRedirectExists extends CrawlerRulePageMetaRedirect
{

	protected function run_check()
	{
		$has_meta_redirect = $this->has_meta_redirect();
		$pass = !$has_meta_redirect;
		
		if(!$pass)
			$this->error('Meta Redirect Detected!');
	}

}

?>