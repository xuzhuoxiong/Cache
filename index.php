<?php
use Lib\Cache\Cache;

error_reporting(E_ALL);
define("ROOT",dirname(__FILE__));
require_once ROOT.DIRECTORY_SEPARATOR.'Lib/AutoLoad.php';

//$file = new File();
//$file->demo();

$cache = Cache::Factory('File',['preFix'=>"test",'fileExt'=>'.txt']);
//$cache->save('1','1',600);
//$cache->decrement('1','3');
//echo $cache->delete('1');
var_dump($cache->flush());
