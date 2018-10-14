<?php

namespace App\Archiver;

use App\Exception\ArchiverException;
use \ZipArchive;

/**
 * Class Archiver
 * @package App\Archiver
 * @author Sébastien Lorrain
 */
class Archiver
{
    /**
     * @var Archiver $instance
     */
    private static $instance;

    /**
     * @var string $targetDir
     */
    private $targetDir;

    /**
     * @var string $targetZip
     */
    private $targetZip;

    /**
     * SVGManager constructor.
     * @param string $targetDir
     * @param string $targetZip
     */
    private function __construct($targetDir, $targetZip)
    {
        $this->targetDir = $targetDir;
        $this->targetZip = $targetZip;
    }

    /**
     * @param string $targetDir
     * @param string $targetZip
     * @return mixed
     */
    public static function getInstance($targetDir, $targetZip)
    {
        if (!isset(self::$instance)) {
            self::$instance = new Archiver($targetDir, $targetZip);
        }

        return self::$instance;
    }

    /**
     *
     * @param array $fileTypes
     * @param bool $deleteOriginalFiles
     * @throws ArchiverException
     */
    public function createArchive($fileTypes,$deleteOriginalFiles = false)
    {
        $zip = new ZipArchive();

        if (!$zip->open($this->targetDir . $this->targetZip, ZipArchive::CREATE)) {
            throw new ArchiverException("Can't create archive");
        }

        $files = scandir($this->targetDir);
        foreach ($files as $file) {

            $extension = pathinfo($file)["extension"];

            if (in_array($extension,$fileTypes)) {
                if (!$zip->addFile($this->targetDir . $file, $extension . '/' . $file)) {
                    throw new ArchiverException("Can't add file : $file to archive");
                }
            }
        }

        $zip->close();

        if ($deleteOriginalFiles) {
            foreach ($fileTypes as $fileType){
                array_map("unlink", glob($this->targetDir."*.$fileType"));
            }
        }
    }

    /**
     * @param string $zipFile
     */
    public function readArchive($zipFile)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipFile) !== TRUE) {
            die ("Could not open archive");
        }

        $numFiles = $zip->numFiles;

        for ($x = 0; $x < $numFiles; $x++) {
            $file = $zip->statIndex($x);
            printf("%s (%d bytes)", $file['name'], $file['size']);
            print "
                    ";
        }

        // close archive
        $zip->close();
    }
}
