SVGWatermarkRemover
=====
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/69a41c4ac71d4041bc03ccc1090a5cfd)](https://www.codacy.com/app/sldevand/SVGWatermarkRemover?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=sldevand/SVGWatermarkRemover&amp;utm_campaign=Badge_Grade)

**SVGWatermarkRemover** is an SVG watermark remover for starUML 3.0 svg exports.
*  It removes UNREGISTERED watermarks from SVG files
*  It exports these images in png format

## Prerequisites
*  PHP 5.6 and above
*  apache2 server

## Dependencies

Install Roboto fonts on your system if you use them inside StarUml, ignore this instead.
```
sudo apt-get install fonts-roboto   
```

## Installation
Clone this repository into your /var/www folder (or your favorite working folder)
```
git clone https://github.com/sldevand/SVGWatermarkRemover.git
cd SVGWatermarkRemover
sudo chmod -R 777 output
npm install
```

### For apache2 users
By default, php is set with 20 max file uploads and 2MB max filesize.
<br>
In order to modifiy these settings, you have to modify php.ini this way :

##### Edit /etc/php/X.X/apache2/php.ini to change these values
```
upload_max_filesize = 256M
max_file_uploads = 70
```
##### Restart apache2 server
```
sudo service apache2 restart
```

## Config file
*  Change config.ini.sample into config.ini
*  Set
```
nodejs-path=""
```
with your own nodejs installation path.

To know where it's installed, type
```
which node
```
## Usage
[http://localhost/SVGWatermarkRemover/](http://localhost/SVGWatermarkRemover/)

*  Click on browse button.
*  Select one or multiple files.
*  Click on upload button.
*  The result is inside the browser.
*  Copy your files from /var/www/output folder.

## Thanks to 
Shakiba for SvgExport : SVG to PNG/JPEG command-line tool and Node.js module.
It uses PhantomJS for rendering SVG files.

[SvgExport](https://github.com/shakiba/svgexport)