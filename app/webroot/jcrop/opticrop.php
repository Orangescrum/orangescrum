<?php
/*
 * Opticrop
 * An optimized cropping utility 
 *
 * @author Jue Wang (jue@jueseph.com)
 * @modified 6/17/2010
 *
 * Based on code from:
 * http://www.theukwebdesigncompany.com/articles/php-imagemagick.php
 * http://shiftingpixel.com/2008/03/03/smart-image-resizer/
 *
 */

/* basic housekeeping */

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
	define('ROOT', dirname(dirname(dirname(__FILE__))));
}
if (!defined('APP_DIR')) {
	define('APP_DIR', basename(dirname(dirname(__FILE__))));
}
define('APP_PATH', ROOT . DS . APP_DIR . DS);

error_reporting(E_ALL);
ini_set('display_errors', '1'); // debug use; set to 0 for production
date_default_timezone_set('America/New_York');  // for script timer
mt_srand(1);    // seed RNG to get consistent results
                // comment out for debug

/* constants */
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('CACHE_PATH', 'opticrop-cache/');
define('LOG_PATH', 'log.opticrop.txt');

/* global parameters (and defaults) */
if (isset($_GET['w'])) define('WIDTH',$_GET['w']);
if (isset($_GET['h'])) define('HEIGHT',$_GET['h']);
if (isset($_GET['debug']) && $_GET['debug'] == 1) define('DEBUG', 1);
else define('DEBUG', 0);
if (isset($_GET["cache"])) define('CACHING',$_GET["cache"]);
else define('CACHING','yes');
if (isset($_GET['format'])) define('FORMAT',$_GET['format']);
else define('FORMAT', 'img');
if (isset($_GET['gamma'])) define('GAMMA',$_GET['gamma']);
else define('GAMMA', 0.2);

// execute the script
main();

function main() {
    // start timer
    $timeparts = explode(' ',microtime());
    $starttime = $timeparts[1].substr($timeparts[0],1);
	
	// This is for incident images
	if(file_exists(APP_PATH.'img/incident/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1)))){
		$_GET['src'] = '/rr/app/webroot/img/incident/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1));
	}
	
	// This is for profile images
	if(file_exists(APP_PATH.'img/profile/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1)))){
		$_GET['src'] = '/rr/app/webroot/img/profile/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1));
	}
	
	// This is for preview images
	if(isset($_GET['prevew'])){
		if(file_exists(APP_PATH.'img/preview/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1)))){
			$_GET['src'] = '/rr/app/webroot/img/preview/thumb/'.trim(substr($_GET['src'],strrpos($_GET['src'],'/')+1));
		}
	}
	
	
	//$h = fopen("ftest.txt","a");
	//fwrite($h,print_r($_GET,true));
	//exit;
	
    // find source image
    if (isset($_GET['src'])) {
        $image = get_image_path($_GET['src']);
    }
    else {
        header('HTTP/1.1 400 Bad Request');
        die('Error: no image was specified');
    }
	
	// extract arguments from query string
    if (defined('WIDTH') && defined('HEIGHT')) {
        // prep cache path
        $cache = get_cache_path($image);
        // compute image if needed
        $result = dispatch($image, $cache);
    }
    // no dimensions provided, just show source image
    elseif (!defined('WIDTH') && !defined('HEIGHT')) {
        $cache = $image;
        $result = 0;
    }
    else {
        header('HTTP/1.1 400 Bad Request');
        die("ERROR: Both width and height need to be provided");
    }

    if (DEBUG == 1) {
        // show source image for comparison
        render(end(explode('/', $image)), true, 'img');
        echo "<br/>";
    }

    // end timer
    $timeparts = explode(' ',microtime());
    $endtime = $timeparts[1].substr($timeparts[0],1);
    //$elapsed = bcsub($endtime,$starttime,6);
	$number = $endtime-$starttime;	
	$elapsed = number_format($number, 6);
    dprint("<br/>Script execution time (s): ".$elapsed);

    // serve out results
    render($cache, (DEBUG==1)?true:false, FORMAT);

    // log results
    $lf = fopen(LOG_PATH, 'a');
    $logstring = date(DATE_RFC822)."\n".
        $_SERVER["QUERY_STRING"]."\n$elapsed s\n\n";
    fwrite($lf, $logstring);
    fclose($lf);
}

/* prints debug messages */
function dprint($str, $print_r=false) {
    if (DEBUG > 0) {
        if ($print_r) {
            print_r($str);
            echo "<br/>\n";
        }
        else {
            echo $str."<br/>\n";
        }
    }
}

/* 
 * returns local system path for an image
 * doesn't work if image isn't on this domain
 *
 * $url - url of image on the same domain as this script
 *
 */
function get_image_path($url) {
    // url given, strip domain 
    $image = preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', $url);

    // for security directories can't contain ':'
    // images can't contain '..' or '<', 
    if (strpos(dirname($image), ':') || 
        preg_match('/(\.\.|<|>)/', $image)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Error: malformed image path. Image paths must begin with \'/\'';
        exit();
    }

    // add docroot to absolute paths
    if ($image{0} == '/') {
        $docRoot = rtrim(DOCUMENT_ROOT,'/');
        $image = $docRoot . $image;
    }
    else {
        // relative path
        $image = str_replace('\\', '/', getcwd()).'/'.$image;
    }

    // check if an image location is given
    if (!$image) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Error: no image was specified';
        exit();
    }

    // check if the file exists
    if (!file_exists($image)) {
        header('HTTP/1.1 400 Bad Request');
        echo 'Error: image does not exist: ' . $image;
        exit();
    }
    return $image;
}

/*
 * returns a path to the cache for an image
 *
 * $image - path to source image
 */
function get_cache_path($image) {
    $cache = ltrim($image, '/');
    // path to cache directory
    $path = explode('/',$cache);
    $cache_dirs = CACHE_PATH.implode('/', array_slice($path, 2, -1)); 
    // create cache directory if doesn't exist
    if (!is_dir($cache_dirs)) {
        mkdir($cache_dirs, 0777, true);
    }
    // path to cache file
    $cache_file = end($path);
    // append script parameters to cache path
    $cache = $cache_dirs.'/'.$cache_file.'-'.$_GET['w'].'x'.$_GET['h'].'-'.GAMMA.'-'.FORMAT;
    $cache = escapeshellcmd($cache);
    return $cache;
}

/*
 * parses imagemagick commands and runs the command line 'convert' utility on 
 * the source image. calls outside functions for image processing if necessary.
 *
 * $image - path to source image
 * &$cache - path to save transformed image, passed by reference so it can be 
 * changed depending on cache settings
 */
function dispatch($image, &$cache) {
    // bypass or disable cache?
    switch(CACHING) {
    case 'no': 
        $cache = CACHE_PATH."temp.jpg";
        dprint("no caching. using $cache for temporary storage");
    case 'refresh': // or 'no':
        dprint("refreshing cache.");
        if (file_exists($cache)) {
            unlink($cache);
            dprint("cache $cache deleted.");
        }
    }
    // get cache
    if (file_exists($cache)) {
        dprint('cached data retrieved');
        return 0;
    }
    // compute image
    $result = opticrop($image, WIDTH, HEIGHT, $cache, FORMAT);

    dprint($cache);
    // there should be a file named $cache now
    if (!file_exists($cache)) {
        die('ERROR: Image conversion failed.');
    }

    return $result;
}


/* 
 * displays an image over the webserver
 *
 * $cache - path of file to display
 * $as_html - serve the image as an img tag in an html page (use for debugging)
 */
function render($cache, $as_html=false, $format) {
    if ($format != 'img') {
        readfile($cache);
        return;
    }
    if ($as_html) {
        echo "<img src=\"$cache\"/>";
        return;
    }
    // get image data for use in http-headers
    $imginfo = getimagesize($cache);
    $content_length = filesize($cache);
    $last_modified = gmdate('D, d M Y H:i:s',filemtime($cache)).' GMT';

    // array of getimagesize() mime types
    $getimagesize_mime = array(1=>'image/gif',2=>'image/jpeg',
          3=>'image/png',4=>'application/x-shockwave-flash',
          5=>'image/psd',6=>'image/bmp',7=>'image/tiff',
          8=>'image/tiff',9=>'image/jpeg',
          13=>'application/x-shockwave-flash',14=>'image/iff');

    // did the browser send an if-modified-since request?
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
       // parse header
       $if_modified_since = 
    preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']);

        if ($if_modified_since == $last_modified) {
         // the browser's cache is still up to date
         header("HTTP/1.0 304 Not Modified");
         header("Cache-Control: max-age=86400, must-revalidate");
         exit;
        }
    }

    // send other headers
    header('Cache-Control: max-age=86400, must-revalidate');
    header('Content-Length: '.$content_length);
    header('Last-Modified: '.$last_modified);
    if (isset($getimagesize_mime[$imginfo[2]])) {
       header('Content-Type: '.$getimagesize_mime[$imginfo[2]]);
    } else {
            // send generic header
            header('Content-Type: application/octet-stream');
    }

    // and finally, send the image
    readfile($cache);
}
               
/* 
 * edge-maximizing crop
 * determines center-of-edginess, then tries different-sized crops around it. 
 * picks the crop with the highest normalized edginess.
 * see documentation on how to tune the algorithm
 *
 * $w, $h - target dimensions of thumbnail
 * $image - system path to source image
 * $out - path/name of output image
 */

function opticrop($image, $w, $h, $out, $format) {
    // source dimensions
    $imginfo = getimagesize($image);
    $w0 = $imginfo[0];
    $h0 = $imginfo[1];
    if ($w > $w0 || $h > $h0)
        die("Target dimensions must be smaller or equal to source dimensions.");

    // parameters for the edge-maximizing crop algorithm
    $r = 1;         // radius of edge filter
    $nk = 9;        // scale count: number of crop sizes to try
    $gamma = GAMMA;   // edge normalization parameter -- see documentation
    $ar = $w/$h;    // target aspect ratio (AR)
    $ar0 = $w0/$h0;    // target aspect ratio (AR)

    dprint(basename($image).": $w0 x $h0 => $w x $h");
    $img = new Imagick($image);
    $imgcp = clone $img;

    // compute center of edginess
    $img->edgeImage($r);
    $img->modulateImage(100,0,100); // grayscale
    $img->blackThresholdImage("#0f0f0f");
    $img->writeImage($out);
    // use gd for random pixel access
    $im = ImageCreateFromJpeg($out);
    $xcenter = 0;
    $ycenter = 0;
    $sum = 0;
    $n = 100000;
    for ($k=0; $k<$n; $k++) {
        $i = mt_rand(0,$w0-1);
        $j = mt_rand(0,$h0-1);
        $val = imagecolorat($im, $i, $j) & 0xFF;
        $sum += $val;
        $xcenter += ($i+1)*$val;
        $ycenter += ($j+1)*$val;
    }
    $xcenter /= $sum;
    $ycenter /= $sum;

    // crop source img to target AR
    if ($w0/$h0 > $ar) {
        // source AR wider than target
        // crop width to target AR
        $wcrop0 = round($ar*$h0);
        $hcrop0 = $h0;
    } 
    else {
        // crop height to target AR
        $wcrop0 = $w0;
        $hcrop0 = round($w0/$ar);
    }

    // crop parameters for all scales and translations
    $params = array();

    // crop at different scales
    $hgap = $hcrop0 - $h;
    $hinc = ($nk == 1) ? 0 : $hgap / ($nk - 1);
    $wgap = $wcrop0 - $w;
    $winc = ($nk == 1) ? 0 : $wgap / ($nk - 1);

    // find window with highest normalized edginess
    $n = 10000;
    $maxbetanorm = 0;
    $maxfile = '';
    $maxparam = array('w'=>0, 'h'=>0, 'x'=>0, 'y'=>0);
    for ($k = 0; $k < $nk; $k++) {
        $hcrop = round($hcrop0 - $k*$hinc);
        $wcrop = round($wcrop0 - $k*$winc);
        $xcrop = $xcenter - $wcrop / 2;
        $ycrop = $ycenter - $hcrop / 2;
        dprint("crop: $wcrop, $hcrop, $xcrop, $ycrop");

        if ($xcrop < 0) $xcrop = 0;
        if ($xcrop+$wcrop > $w0) $xcrop = $w0-$wcrop;
        if ($ycrop < 0) $ycrop = 0;
        if ($ycrop+$hcrop > $h0) $ycrop = $h0-$hcrop;

        // debug
        $currfile = CACHE_PATH."image$k.jpg";
        if (DEBUG > 0) {
            $currimg = clone $img;
            $c= new ImagickDraw(); 
            $c->setFillColor("red"); 
            $c->circle($xcenter, $ycenter, $xcenter, $ycenter+4); 
            $currimg->drawImage($c); 
            $currimg->cropImage($wcrop, $hcrop, $xcrop, $ycrop);
            $currimg->writeImage($currfile);
            $currimg->destroy();
        }

        $beta = 0;
        for ($c=0; $c<$n; $c++) {
            $i = mt_rand(0,$wcrop-1);
            $j = mt_rand(0,$hcrop-1);
            $beta += imagecolorat($im, $xcrop+$i, $ycrop+$j) & 0xFF;
        }
        $area = $wcrop * $hcrop;
        $betanorm = $beta / ($n*pow($area, $gamma-1));
        dprint("beta: $beta; betan: $betanorm");
        dprint("image$k.jpg:<br/>\n<img src=\"$currfile\"/>");
        // best image found, save it
        if ($betanorm > $maxbetanorm) {
            $maxbetanorm = $betanorm;
            $maxparam['w'] = $wcrop;
            $maxparam['h'] = $hcrop;
            $maxparam['x'] = $xcrop;
            $maxparam['y'] = $ycrop;
            $maxfile = $currfile;
        }
    }
    dprint("best image: $maxfile");

    if (FORMAT == 'json') {
        // return coordinates instead of image
        $data = json_encode($maxparam);
        file_put_contents($out, $data);
    }
    else {
        // return image
        $imgcp->cropImage($maxparam['w'],$maxparam['h'],
            $maxparam['x'],$maxparam['y']);
        $imgcp->scaleImage($w,$h);
        $imgcp->writeImage($out);
    }
    chmod($out, 0777);
    $img->destroy();
    $imgcp->destroy();
    return 0;
}

?>
