<?php
use Lib\Cache\Cache;

error_reporting(E_ALL);
define("ROOT",dirname(__FILE__));
require_once ROOT.DIRECTORY_SEPARATOR.'Lib/AutoLoad.php';

//$file = new File();
//$file->demo();

$cache = Cache::Factory('File');
$cache->demo();