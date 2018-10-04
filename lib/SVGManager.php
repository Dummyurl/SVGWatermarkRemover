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
  public static $targetDir="output/";

    /**
     * @throws \ImagickException
     */
    public static function removeWatermarks()
  {
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {

      // Count # of uploaded files in array
      $total = count($_FILES['filesToUpload']['tmp_name']);

      // Loop through each file
      for( $i=0 ; $i < $total ; $i++ ) {

        $tmpFile = $_FILES["filesToUpload"]["tmp_name"][$i];
        $outFile = $_FILES["filesToUpload"]["name"][$i];
        $targetFile=self::$targetDir.$outFile;

        if ($tmpFile != ""){

          self::removeWatermark($tmpFile);
          self::saveSVG($targetFile);
          self::displaySVG($targetFile);
            self::savePngFromSVG($targetFile);

        }
      }
    }
  }

    /**
     * @param string $tmpFile
     */
  public static function removeWatermark($tmpFile)
  {
    self::$svg = new \SimpleXMLElement( file_get_contents( $tmpFile )  );

    self::$svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
    self::$svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
    foreach (self::$svg as $key => $elt) {
      unset($elt->text);
    }
  }

  public static function saveSVG($targetFile)
  {
    self::$svg->asXML( $targetFile);

  }

  public static function displaySVG($targetFile)
  {
    $resultSvg = file_get_contents($targetFile);
    print_r($resultSvg);
  }

    /**
     * @param $sourceFile
     * @throws \ImagickException
     */
    public static function savePngFromSVG($sourceFile){
      $im = new \Imagick();
      $svg = file_get_contents($sourceFile);
        $im->setCompressionQuality(100);


        if(!$im->readImageBlob($svg)) return;
        /*png settings*/
        if(!$im->setImageFormat("png")) return;

        $pattern="/\.svg$/";

        if(preg_match($pattern,$sourceFile)){
            $destFile = preg_replace($pattern,".png",$sourceFile);
            if(!$im->writeImage($destFile)) return;

            echo "image wrote successfully</br>";
        }






        $im->clear();
        $im->destroy();


  }
}
