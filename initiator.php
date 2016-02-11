<?php

return;

include_once 'utility/Loader.class.inc.php';

error_reporting(-1);
date_default_timezone_set('America/Chicago');

Loader::setRoot(dirname(__FILE__));
Loader::load('model', array(
	'DataObject',
	'DataCollection'));
Loader::load('mutator', 'Mutator');
Loader::loadNew('utility', 'Router');

?>