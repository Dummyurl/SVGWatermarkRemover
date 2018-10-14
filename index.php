<?php
require_once 'setup.php';

use App\Progress\Progress;
use App\Token\TokenManager;
use App\Converter\SVGManager;
use App\Converter\SVGToPngConverter;
use App\Archiver\Archiver;

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

    /** @var Archiver $archiver */
    $archiver = Archiver::getInstance($targetDir,'starUML.zip');
    $types=["png","svg"];

    /** @var Progress $progress */
    $progress = Progress::getInstance();
    $progress->setProgress(0);

    if (TokenManager::check()) {
        $svgManager->clearOutputDir($targetDir);
        $svgManager->removeWatermarks();
        $progress->setProgress(15);
        $svgToPngConverter->convertSvgToPngDir();
        $progress->setProgress(80);
        $archiver->createArchive($types,true);
    }

    $progress->setProgress(0);
}
