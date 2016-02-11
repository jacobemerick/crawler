<?php

Loader::load('utility', 'crawler/rule/page/contentImage/CrawlerRulePageContentImage');

class CrawlerRulePageContentImageAlternateTextExists extends CrawlerRulePageContentImage
{

	protected function run_check()
	{
		$content_images = $this->get_content_images();
		foreach($content_images as $content_image)
		{
			$pass = strlen($content_image->alternate_text) > 0;
			if(!$pass)
			{
				$this->error('You have images without alternate text!');
				break;
			}
		}
	}

}

?>