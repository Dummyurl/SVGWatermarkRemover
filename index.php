<?php
require_once 'setup.php';

use App\Token\TokenManager;
use App\Converter\SVGManager;
use App\Converter\SVGToPngConverter;

$targetDir = OUTPUT;

$method = $_SERVER['REQUEST_METHOD'];

//ROUTING
if ($method === "GET") {
    try {
       createForm();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} elseif ($method === "POST") {
    try {
        createSvgandPng($targetDir);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


//CONTROLLER FUNCTIONS
/**
 * @throws \Exception
 */
function createForm(){
    $token = TokenManager::create();
    require VIEW.'form.php';
}

/**
 * @param string $targetDir
 * @throws Exception
 */
function createSvgandPng($targetDir){

    /** @var SVGManager $svgManager */
    $svgManager = SVGManager::getInstance($targetDir);

    /** @var SVGToPngConverter $svgToPngConverter */
    $svgToPngConverter = SVGToPngConverter::getInstance($targetDir);

    if (TokenManager::check()) {
        $svgManager->removeSvgInOutputDir($targetDir);
        $svgManager->removeWatermarks();
        $svgToPngConverter->convertSvgToPngDir();
    }
}
