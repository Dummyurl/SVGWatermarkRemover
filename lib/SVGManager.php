<?php

namespace Utils;

/**
 * Class SVGManager
 * @package Utils
 * @author Sébastien Lorrain
 */
class SVGManager
{
    public static $svg;
    public static $targetDir = "output";

    /**
     * @throws \ImagickException
     */
    public static function removeWatermarks($targetDir)
    {
        self::$targetDir = $targetDir;

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {

            // Count # of uploaded files in array
            $total = count($_FILES['filesToUpload']['tmp_name']);

            // Loop through each file
            for ($i = 0; $i < $total; $i++) {

                $tmpFile = $_FILES["filesToUpload"]["tmp_name"][$i];
                $outFile = $_FILES["filesToUpload"]["name"][$i];

                $outFile = preg_replace("/!| /", "_", $outFile);

                $targetFile = self::$targetDir . $outFile;

                if ($tmpFile != "") {

                    self::removeWatermark($tmpFile);
                    self::saveSVG($targetFile);
                    self::displaySVG($targetFile);
                }
            }
        }
    }

    /**
     * @param string $tmpFile
     */
    public static function removeWatermark($tmpFile)
    {
        self::$svg = new \SimpleXMLElement(file_get_contents($tmpFile));

        self::$svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
        self::$svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
        foreach (self::$svg as $key => $elt) {
            unset($elt->text);
        }
    }

    public static function saveSVG($targetFile)
    {
        self::$svg->asXML($targetFile);

    }

    /**
     * @param string $targetFile
     */
    public static function displaySVG($targetFile)
    {
        $resultSvg = file_get_contents($targetFile);
        print_r($resultSvg);
    }

    /**
     * @param $sourceFile
     * @throws \ImagickException
     */
    public static function savePngFromSVG($sourceFile)
    {
        $im = new \Imagick();


        if (!($svg = file_get_contents($sourceFile))) {
            throw new \ImagickException("Oops File $sourceFile is empty");
        }

        var_dump($svg);
        echo "file is not empty </br>";

//        if (!$im->setCompressionQuality(9)) {
//            throw new \ImagickException("Oops Cant set Compression Quality!");
//        }
//        echo "compression quality set</br>";


        if (!$im->readImageBlob($svg)) {
            throw new \ImagickException("Oops Cant read image blob!");
        }


        echo "imageblob read</br>";

        // die();
        /*png settings*/
        if (!$im->setImageFormat("png")) {
            throw new \ImagickException("Oops Cant set Image Format");
        }

        $pattern = "/\.svg$/";

        if (preg_match($pattern, $sourceFile)) {
            $destFile = preg_replace($pattern, ".png", $sourceFile);
            if (!$im->writeImage($destFile)) {
                throw new \ImagickException("Oops Cant set Image Format");
            }

            echo "image wrote successfully</br>";
        } else {
            throw new \ImagickException("Oops Cant find svg file!");
        }


        $im->clear();
        $im->destroy();
    }

    public static function convertSvgToPngFile($sourceFile)
    {

        $status = [];

        $pattern = "/\.svg$/";

        if (preg_match($pattern, $sourceFile)) {
            $destFile = preg_replace($pattern, ".png", $sourceFile);
            $command = NODEJS." node_modules/.bin/svgexport $sourceFile $destFile";
            exec($command,$status);

        } else {
            throw new \ImagickException("Oops Cant find svg file!");
        }
    }


    public static function convertSvgToPngDir($targetDir)
    {
        $files = scandir($targetDir);
        foreach ($files as $file) {
            if (preg_match("/.svg$/", $file)) {
                self::convertSvgToPngFile($targetDir . $file);
            }
        }
    }

    public static function removeSvgInOutputDir($outputDir)
    {
        $file = $outputDir . "*.svg";
        array_map("unlink", glob($file));
    }
}
