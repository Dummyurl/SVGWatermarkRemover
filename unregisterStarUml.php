<?php
require_once 'setup.php';

require_once ROOT.'lib/SVGManager.php';
require_once ROOT.'lib/TokenManager.php';
ini_set('display_errors', '1');

use Utils\TokenManager;
use Utils\SVGManager;

$targetDir = ROOT."output/";

if(TokenManager::check()){
    try {

        SVGManager::removeSvgInOutputDir($targetDir);
        SVGManager::removeWatermarks($targetDir);
        SVGManager::convertSvgToPngDir($targetDir);

    } catch (ImagickException $e) {
        echo $e->getMessage();
    }

}


