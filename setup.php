<?php
ini_set('display_errors', '1');
define('ROOT',__DIR__.'/');
define('SRC',ROOT.'src/');
define('VIEW',SRC.'view/');
define('OUTPUT',ROOT.'output/');
$iniFile = parse_ini_file(ROOT."config.ini");
define('NODEJS',$iniFile['nodejs-path']);
require_once ROOT."vendor/autoload.php";