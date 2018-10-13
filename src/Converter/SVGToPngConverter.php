<?php

namespace App\Converter;

/**
 * Class SVGToPngConverter
 * @package Converter
 * @author Sébastien Lorrain
 */
class SVGToPngConverter
{
    /**
     * @var SVGManager $instance
     */
    private static $instance;

    /**
     * @var string $sourceFile
     */
    private $targetDir;

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
            self::$instance = new SVGToPngConverter($targetDir);
        }

        return self::$instance;
    }

    /**
     * @throws \ImagickException
     */
    public function convertSvgToPngDir()
    {
        $files = scandir($this->targetDir);
        foreach ($files as $file) {
            if (preg_match("/.svg$/", $file)) {
                $this->convertSvgToPngFile($this->targetDir . $file);
            }
        }
    }

    /**
     * @param string $sourceFile
     * @return array
     * @throws \ImagickException
     */
    public function convertSvgToPngFile($sourceFile)
    {
        $status = [];
        $pattern = "/\.svg$/";

        if (!preg_match($pattern, $sourceFile)) {
            throw new \ImagickException("Oops Cant find svg file!");
        }

        $destFile = preg_replace($pattern, ".png", $sourceFile);
        $command = NODEJS . " node_modules/.bin/svgexport $sourceFile $destFile";
        exec($command, $status);

        return $status;
    }
}
