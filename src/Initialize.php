<?php
require __DIR__.'/../vendor/autoload.php';
/** @var $Database \mqtchums\singleton\Database */
$Database = \mqtchums\singleton\Database::inst();
$Database->Connect();

?>