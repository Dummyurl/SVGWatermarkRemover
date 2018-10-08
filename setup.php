<?php
$iniFile = parse_ini_file("config.ini");
define('ROOT',__DIR__.'/');
define('NODEJS',$iniFile['nodejs-path']);
