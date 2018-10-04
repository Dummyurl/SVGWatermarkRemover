SVGWatermarkRemover
=====
**SVGWatermarkRemover** is an SVG watermark remover for starUML 3.0 svg exports.
## Prerequisites
* PHP 5.6 and above
* apache2 server

```
sudo apt-get install php7.2-imagick
sudo apt-get install libgraphicsmagick1-dev libmagickcore-dev libmagickcore-6.q16-2 libmagickcore-6.q16-2-extra
```

## Installation
Clone this repository into your /var/www folder (or your favorite working folder)
```
git clone https://github.com/sldevand/SVGWatermarkRemover.git
cd SVGWatermarkRemover
mkdir output
sudo chmod -R 777 output
```
if you want to install bootstrap
```
npm install
```

### For apache2 users
By default, php is set with 20 max file uploads and 2MB max filesize.
<br>
In order to modifiy these settings, you have to modify php.ini this way :

##### Edit /etc/php/7.0/apache2/php.ini to change these values
```
upload_max_filesize = 256M
max_file_uploads = 70
```
##### Restart apache2 server
```
sudo service apache2 restart
```

## Usage
http://localhost/SVGWatermarkRemover/

* Click on browse button.
* You can select multiple files.
* Click on upload button.
* You have the result inside the browser.
* You can copy your files from /var/www/output folder.
