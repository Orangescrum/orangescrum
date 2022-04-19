<?php
/**
 * Captcha Component
 *
 * Component for Generating Captcha in CakePHP 2.x
 *
 * PHP versions 5.2.8
 *
 * @copyright Copyright (c) Arvind K. (http://www.devarticles.in/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     Arvind K. (arvind.mailto@gmail.com)
 *
 * @version 2.5
 *
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Version history
 *
 * 2010-10-25  - Initial version
 * 2010-12-16  - Add Height/Width options to Captcha Image
               - Add the Automatic Deletion of old captcha image files 
                 on the server
               - Add Model validation for Captcha
 * 2011-06-09  - Add Random difficulty level Captcha
               - Replace the storing of image files with one time direct 
                 output to image tag
               - Add the GD library check
 * 2012-09-01  - Add variations to captcha fonts (size, angle)
               - Add configurable difficulty levels to captcha
               - Created different versions for CakePHP 1.x and 2.x
               - Fixed ob buffering issue
 *             - Add error & messages
 * 2013-04-09  - Add settings parameter to set font, font variations, adjustments
 *             - Update _construct to get controller response (following 2.x approach) 
 * 2013-04-12  - Add $theme option to render fixed or random theme
               - Random captcha images are possible. Set “theme”=>”random” in $settings 
                 variable of CaptchaComponent.php or in Controller when loading captcha component.
               - Added "Can’t Read? Reload". A working piece of jQuery code is included 
                 in view file add.ctp. Be sure to include jquery library, such as https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js to make 
                 Reloading of captcha working
 * 2013-09-19  - Add Model.Field name support
               - Updated the controller function to detect the existence of font file
 * 2013-09-25  - Add Image and Simple Math captcha
               - Add support so it works without GD Truetype font support (NOT RECOMMENDED though)
 *             - Refined Default and Random themes for Image Captcha
 * 2014-06-14  - Restructured files 
 *             - Refined loading in Controller and Model validation code blocks
               - Fixed header already sent bug
 * 2014-09-06  - Add angel of rotation to the captcha text
 *             - Add Lib > Fonts > (3 font files) and made the captcha selecting random file.
               - Changed some variables to more logical names
 * 2014-09-08  - Add Multiple Captcha Support
 *                A page may have multiple forms and hence multiple captchas. Support multiple Models, Fields.                    Obviously you wont want multiple captchas in a single form.  It however supports it if you                      wanted it! It simply supports multiple captchas on one page. In different forms and in single 
                  form as well.
 *             - Add fully configurable from view file
 *             - Fully configurable from view file
 *             - Add Pass Helper settings directly to Helper from Component. Overwrite with 
                 custom configurations from view file if found
 * 2015-01-22  - Tested with Cakephp 2.6.0
 *
 */
  App::uses('Component', 'Controller');

  class CaptchaComponent extends Component{

    /**
     * Default monospaced fonts available
     *
     * The font files (.ttf) are stored in app/Lib/Fonts
     * You can add more fonts to this directory and then to the array below
     * @var array
     */
    private $__fonts = array('anonymous', 'droidsans', 'ubuntu');

    /**
     * Used in a mechanism to detect errors
     *
     * @var array
     */
    private $errors = array();

    /**
     * Set to define fatal error (Missing GD support or Font file)
     *
     * @var bool
     */
    private $fatalError = false;

    /**
     * Set to check about the True Type Font support
     *
     * @var bool
     */
    private $TTFSupport = true;

    /**
     * Set the default name of session key
     *
     * @var bool
     */
    private $sessionKey = 'Signup.captcha';

    /**
     * The default theme/texture on image, behind the captcha text
     *
     * @var array
     */
    private $themes = array(
      'default'=>array(
        'bgcolor'=>array(200,200, 200),
        'txtcolor'=>array(10, 30, 80),
        'noisecolor'=>array(60, 90, 120)
      )
    );

    /**
     * The default settings
     *
     * @var array
     */
    public $settings = array(
      'width' => 120,
      'height' => 40,
      'length' => 6,
      'theme'=>'default',
      'fontAdjustment'=>0.50,
      'type'=>'image',
      'model' => 'Signup',
      'field' => 'captcha',
      'rotate' => true,
      'reload_txt' => '<img src="/img/home_outer/refreshing.png" alt="reload" />',
      'clabel' => '<p>Enter security code shown above:</p>',
      'mlabel' => '<p>Answer simple math:</p>'
       
    );

    /**
     * Other Components this component will use.
     *
     * @var array
     */
    public $components = array('Session');

    /**
     * Constructor
     *
     * @param ComponentCollection $collection A ComponentCollection this component can use 
       to lazy load its   components
     * @param array $settings Array of configuration settings.
     */
    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->Controller = $collection->getController();
        parent::__construct($collection, array_merge($this->settings, (array)$settings));
        $this->__init();
    }

    /**
     * Custom Intializer of our Component
     *
     * Checks the given setup for support
     * @param (void) 
     */
    private function __init() {
        
        //Check to see if the TTF support is enabled
        $this->__checkTTFSupport();

        //basically for helper specific settings
        $this->__setDefaults();

        //set the name of Session key
        $this->__setSessionKey();

        //Initialize captcha type (image or math text). If image do some basic support test like GD check and existence of font files. Create a Math Question if it's the Math Captcha
        $this->__initType();
        
        //Do not expect to get in there.
        if($this->__hasFatalError()) {
            die($this->__getStringErrors());
        }
    }

    /**
     * Set some date for the CaptchaHelper
     *
     * @param ($instance of Controller) 
     */
    public function beforeRender(Controller $controller) {
        $controller->helpers['Captcha'] = array_merge($this->__getSettings(), array('controller'=>$this->Controller->params['controller'], 'action'=>'captcha1'));
        //$this->Controller->set('captchaSettings', array_merge($this->__getSettings(), array('controller'=>$this->Controller->params['controller'], 'action'=>'captcha')));
        //debug($this->settings);
    }

    /**
     * Set Helper generated params
     *
     * @param (void) 
     */
    function __setDefaults()    {

        $q = $this->Controller->request->query;
        if(!$q) return;

        //Preference is given the settings parameter passed through helper
        foreach($this->settings as $k=>$v)  {
            if(isset($q[$k]) && $q[$k]) $this->settings[$k] = $q[$k];
        }
    }

    /**
     * Generate AlphaNumeric Key of given characters
     *
     * @param (void) 
     */
    function __AlphaNumeric() {

      /* list all possible characters ; similar looking characters and vowels have been ommitted */
      $possible = '23456789bcdfghjkmnpqrstvwxyz';//ABCDFGHJKMNPRSTVWXYZ

      $code = '';$i = 0;
      while ($i < $this->settings['length']) { 
        $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
        $i++;
      }
      return $code;
    }

    /**
     * Session Session key name for the current captcha call
     *
     * @param (void) 
     */
    private function __setSessionKey()
    {
        $this->sessionKey = "Captcha.{$this->settings['model']}_{$this->settings['field']}";
    }

    /**
     * return session key name for the current call
     *
     * @param (void) 
     */
    private function __getSessionKey()
    {
        return $this->sessionKey;
    }

    function create($settings = array()) {
      switch($this->__getType()):
        case 'image';
          $this->__imageCaptcha();
        break;
        case 'math';
        /*if(isset($this->Controller->request->data[$this->settings['model']][$this->settings['field']]))  {
          $this->Controller->Session->write('security_code_math', $this->Controller->Session->read('security_code'));
        }*/
        $this->__mathCaptcha();
        $this->Controller->set('settings', $this->settings);
        $this->Controller->render('/Elements/captchamath');
        break;
      endswitch;
    }
    private function __initType()  {
      
      if($this->__getType() == 'image')  {
       // Gets full path to fonts dir
       $font_path = dirname(dirname(dirname(__FILE__))) . DS . 'webroot' . DS . 'fonts';

       $font_name = $this->__fonts[array_rand($this->__fonts)] . ".ttf";

       $this->settings['font'] = $font_path . DS . $font_name;

        if(!$this->__gdInfo())  {
           $this->__setError('Cannot use image captcha as GD library is not enabled! Set $this->settings[\'type\'] => \'math\' in order to show a simple math captcha instead!');
           $this->fatalError = true;
        } else  {
          if(!$this->__TTFEnabled())  {
            $this->__setError("For best results use GD library with freetype font enabled!");
            if(Configure::read('debug'))  {
              debug("CAPTCHA COMPONENT - For best results use GD library with Freetype enabled!");
            }
          } else if(!file_exists($this->settings['font'])) {
            $this->__setError("The font file does not exist at the location: " . $this->settings['font']);
            $this->fatalError = true;
          }
        }
      }
      /* else  {
        $this->create();
      }*/
    }
    private function __setType($type)  {
      $this->settings['type'] = $type;
    }
    private function __getType()  {
      return $this->settings['type'];
    }
    private function __mathCaptcha()  {
      $operators = array("+", "-", "*");
      $rand_key = array_rand($operators);
      switch($operators[$rand_key]):
        case "+":
          $a = rand(0,20);
          $b = rand(0,20);
          $code = $a + $b;
          $stringOperation = $a . " + " . $b;
        break;
        case "-":
          $a = rand(0,20);
          $b = rand(0,20);
          $code = $a > $b ? $a - $b : $b - $a;
          $stringOperation =  $a > $b ? $a . " - " . $b : $b . " - " . $a;
        break;
        case "*":
          $a = rand(0,10);
          $b = rand(0,10);
          $code = $a * $b;
          $stringOperation = $a . " * " . $b;
        break;
      endswitch;
      $this->settings['stringOperation'] = $stringOperation;
      $this->Session->write($this->__getSessionKey(), $code);
    }


    function __imageCaptcha() {
        $width = $this->settings['width'];
        $height = $this->settings['height'];
        $this->__prepareThemes();
        $theme = $this->settings['theme'];
        if(!$this->__TTFEnabled())  {
            $width = 70;
            $height = 30;
            $theme = "default";
            $this->themes[$theme]['txtcolor'] = array(255, 255, 255);
        }

        $code = $this->__AlphaNumeric();
        /* font size will be 75% of the image height */
        $font_size = $height * $this->settings['fontAdjustment'];
        $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        /* set the colours */
        $background_color = imagecolorallocate($image, $this->themes[$theme]['bgcolor'][0], $this->themes[$theme]['bgcolor'][1], $this->themes[$theme]['bgcolor'][2]);
        $text_color = imagecolorallocate($image, $this->themes[$theme]['txtcolor'][0], $this->themes[$theme]['txtcolor'][1], $this->themes[$theme]['txtcolor'][2]);
        $noise_color = imagecolorallocate($image, $this->themes[$theme]['noisecolor'][0], $this->themes[$theme]['noisecolor'][1], $this->themes[$theme]['noisecolor'][2]);
        /* generate random dots in background */
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
        }

        /* create textbox and add text */
        if($this->__TTFEnabled())  {

            //If specified, rotate text
            $angle = 0;
            if($this->settings['rotate']) {
                $angle = rand(-15, 15);
            }

            $textbox = imagettfbbox($font_size, $angle, $this->settings['font'], $code) or die('Error in imagettfbbox function');
            $x = ($width - $textbox[4])/2;
            $y = ($height - $textbox[5])/2;
            $y -= 5;
            imagettftext($image, $font_size, $angle, $x, $y, $text_color, $this->settings['font'] , $code) or die('Error in imagettftext function');
        } else if(function_exists("imagestring"))  {
            //$font_size = imageloadfont($this->settings['font']);
            $textbox = imagestring($image, 5, 5, 5, $code, $text_color) or die('Error in imagestring function');
        } else  {
            $this->__setError("Cannot use image captcha without GD Library enabled!");
        }

        $sessionKey = $this->__getSessionKey();

        $this->Session->delete($sessionKey);
        $this->Session->write($sessionKey, $code);
        //@ob_end_clean(); //clean buffers, as a fix for 'headers already sent errors..'

        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }
    function getCode($sessionKey)	{
      /*if($this->__getType()=='image')  {
        return $this->Controller->Session->read('Captcha.{$sessionKey}');
      } else if($this->__getType()=='math')  {
        return $this->Controller->Session->read('Captcha.{$sessionKey}_math');
      }*/
      $sessionKey = str_replace('.', '_', $sessionKey);
      return $this->Session->read("Captcha.{$sessionKey}");
    }
    private function __prepareThemes()	{
      if($this->settings['theme']=='random')	{
        $this->themes['random'] = array(
          'bgcolor'=>array($bg_r=rand(0,255), $bg_g=rand(0,255), $bg_b=rand(0,255)),
          'txtcolor'=>array(rand(0,255), rand(0,255), rand(0,255)),
          'noisecolor'=>array(rand(0,255), rand(0,255), rand(0,255))
        );
        $ch_r = rand(40, 50);$ch_g = rand(40, 50);$ch_b = rand(40, 50);
        $txt_r = $bg_r+$ch_r >= 255 ? 255 : $bg_r+$ch_r;
        $txt_g = $bg_g+$ch_g >= 255 ? 255 : $bg_g+$ch_g;
        $txt_b = $bg_b+$ch_b >= 255 ? 255 : $bg_b+$ch_b;
        $this->themes['random']['txtcolor'] = array($txt_r, $txt_g, $txt_b);
      }
    }
    function __setError($error_message) {
      $this->errors[] = $error_message;
    }
    function __getErrors() {
      return $this->errors;
    }
    private function __hasErrors() {
      return !is_null($this->errors);
    }
    private function __hasFatalError()  {
      return $this->fatalError;
    }
    private function __getStringErrors()  {
      if($this->__hasErrors())  {
        $html = '<p>CAPTCH ERRORS:</p><ul class="c-errors">';
        foreach($this->__getErrors() as $error) {
          $html .= '<li>' . $error . '</li>';
        }
        $html .= '</ul>';
        return $html;
      }
    }
    private function __checkTTFSupport() {
      if(!function_exists("imagettftext")) $this->TTFSupport = false;
    }
    private function __TTFEnabled()  {
      return $this->TTFSupport;
    }
    private function __getSettings()  {
      return $this->settings;
    }
    private function __gdInfo() {
      if(!function_exists("gd_info")) return false;
      return true;
    }
  }