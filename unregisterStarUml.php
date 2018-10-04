<?php
require_once 'lib/SVGManager.php';
require_once 'lib/TokenManager.php';

use Utils\TokenManager;
use Utils\SVGManager;
if(TokenManager::check()){
    try {
        SVGManager::removeWatermarks();
    } catch (ImagickException $e) {
        echo $e->getMessage();
    }

}
