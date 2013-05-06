<?php
include_once 'bootstrap.php.cache';

use Blogger\BlogBundle\Helpers\Utils as Utils;

Utils::clearLog();
Utils::clearFile(__DIR__ .'/logs/test.log');
Utils::clearFile('C:\wamp\logs\genquery.log');
Utils::log("test started");
