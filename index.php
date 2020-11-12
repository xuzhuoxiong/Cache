<?php
error_reporting(E_ALL);
define("ROOT",dirname(__FILE__));
require_once ROOT.DIRECTORY_SEPARATOR.'Lib/AutoLoad.php';
$file = new \Lib\Cache\File();
$file->demo();
