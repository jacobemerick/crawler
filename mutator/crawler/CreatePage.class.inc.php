<?php

class CreatePage extends Mutator
{

	public function setData(Domain $domain, Link $link, MetaTitle $metaTitle, MetaDescription $metaDescription, $has_meta_redirect, ContentPage $contentPage, $http_code, $date)
	{
		$this->object = new Page();
		$this->object->setDomain($domain);
		$this->object->setLink($link);
		$this->object->setMetaTitle($metaTitle);
		$this->object->setMetaDescription($metaDescription);
		$this->object->setMetaRedirect($has_meta_redirect);
		$this->object->setContentPage($contentPage);
		$this->object->setHTTPCode($http_code);
	//	$this->object->setDateAccessed($date);
		return $this;
	}

}

?>