<?php

namespace App\Converter;

use App\Exception\ConverterException;

/**
 * Class SVGManager
 * @package Converter
 * @author Sébastien Lorrain
 */
class SVGManager
{
    /**
     * @var \SimpleXMLElement $svg
     */
    private $svg;

    /**
     * @var string $targetDir ;
     */
    private $targetDir;

    /**
     * @var SVGManager $instance
     */
    private static $instance;


    /**
     * SVGManager constructor.
     * @param string $targetDir
     */
    private function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param string $targetDir
     * @return mixed
     */
    public static function getInstance($targetDir)
    {
        if (!isset(self::$instance)) {
            self::$instance = new SVGManager($targetDir);
        }
        return self::$instance;
    }

    /**
     * @param string $outputDir
     */
    public function clearOutputDir($outputDir)
    {
        $file = $outputDir . "*";
        array_map("unlink", glob($file));
    }

    /**
     * Removes Watermarks from SVG file
     * @throws ConverterException
     */
    public function removeWatermarks()
    {

        if (!isset($_POST["submit"])) {
            throw new ConverterException('$_POST[submit] is not set');
        }


        $total = count($_FILES['filesToUpload']['tmp_name']);

        for ($i = 0; $i < $total; $i++) {
            $tmpFile = $_FILES["filesToUpload"]["tmp_name"][$i];
            $outFile = $_FILES["filesToUpload"]["name"][$i];
            $outFile = preg_replace("/!| /", "_", $outFile);
            $targetFile = $this->targetDir . $outFile;


            if ($tmpFile != "") {
                $this->removeWatermark($tmpFile);
                $this->saveSVG($targetFile);
                $this->displaySVG($targetFile);
            }
        }

    }


    /**
     * @param string $tmpFile
     */
    private function removeWatermark($tmpFile)
    {
        $this->svg = new \SimpleXMLElement(file_get_contents($tmpFile));

        $this->svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
        $this->svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
        foreach ($this->svg as $key => $elt) {
            unset($elt->text);
        }
    }

    private function saveSVG($targetFile)
    {
        $this->svg->asXML($targetFile);
    }

    /**
     * @param string $targetFile
     */
    private function displaySVG($targetFile)
    {
        $resultSvg = file_get_contents($targetFile);
        print_r($resultSvg);
    }
}
