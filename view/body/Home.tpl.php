<div id="content" class="container">
	<? if($form_success) : ?>
	<h3>Thank you for the submission! You will be emailed when the crawl is finished.</h3>
	<? else : ?>
	<form method="post" action="">
		<label for="domain">
			Please enter the Domain:
		</label>
		<input id="domain" type="text" name="domain" value="" />
	</form>
	<? endif ?>
</div>