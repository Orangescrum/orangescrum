<?php
/*print '<div style="width: 50%;
    height: 300px;
    position: absolute;
    left: 0px;
    top: -60px;
    bottom: 0px;
    right: 0px;
    margin: auto;">
<div style="text-align:center;margin-bottom:20px;">
<img src="https://www.orangescrum.com/img/logo/orangescrum-134-40.png?v=493" border="0" alt="Orangescrum.com" title="Orangescrum.com">
</div>
<img src="https://www.orangescrum.com/img/maintein.png" style="max-width:100%"/>

<div style="text-align:center;margin-top:20px;font-size25px;">
We are making Orangescrum safer and robust.
Sorry for the inconvenience caused. <br /><br />
We will be back in 1 hour.<br /><br />
Thank You Very Much For Your Kind Cooperation. <br />
</div>
</div>';exit;*/

register_shutdown_function('shutdown');

function shutdown() {
    $error = error_get_last();
    if ($error['type'] == 1 || $error['type'] == 4 || $error['type'] == 64 || stristr($error['message'], "FATAL")) {
        # Here we handle the error, displaying HTML, logging, ...
        if (!file_exists(WWW_ROOT . 'error.check')) {

            $my_file = WWW_ROOT . 'error.check';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
            $data = 'This is an error check file.';
            fwrite($handle, $data);

            if ($handle) {
                fclose($handle);
            }
            $errormsg = "Error:<b>" . $error['type'] . "</b><br/>Msg: <b>" . $error['message'] . " </b><br/>File: <b>" . $error['file'] . " </b><br/>Line: <b>" . $error['line'] . "</b>";

            $toemail = array("developer");

            $from = "support";
            $subject = "Fatal Error on " . $GLOBALS['_SERVER']['HTTP_HOST'];

            if (stristr($_SERVER['SERVER_NAME'], "orangescrum.com") || stristr($_SERVER['SERVER_NAME'], "easyagile.us")) {
                if ($error['type'] == 2048) {
                    $extnderror = "<br/>Note: <span style='color:#FF0000'>This seems to be a cakeError. There might be some wrong component, helper or model name on the controller.</span><br/>";
                }

                $message = "<div style='font-size:14px;font-family:Arial'><br/>$errormsg<br/>" . $extnderror . "<br/><br/>HTTP_HOST: <b>" . $GLOBALS['_SERVER']['HTTP_HOST'] . "</b></b><br/><br/>DOCUMENT_ROOT: <b>" . $GLOBALS['_SERVER']['DOCUMENT_ROOT'] . "</b></div>";

                $url = 'https://api.sendgrid.com/';
                $user = '';
                $pass = '';

                foreach ($toemail as $to) {
                    $params = array(
                        'api_user' => $user,
                        'api_key' => $pass,
                        'to' => $to,
                        'subject' => $subject,
                        'html' => $message,
                        'text' => '',
                        'from' => $from,
                    );
                    // From email is not valid with space.

                    $request = $url . 'api/mail.send.json';
                    $session = curl_init($request);
                    curl_setopt($session, CURLOPT_POST, true);
                    curl_setopt($session, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($session, CURLOPT_HEADER, false);
                    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($session);
                    curl_close($session);
                }
            }
            if ($handle) {
                fclose($handle);
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

/**
 * Index
 *
 * The Front Controller for handling every request
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */
/**
 * The full path to the directory which holds "app", WITHOUT a trailing DS.
 *
 */
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
/**
 * The actual directory name for the "app".
 *
 */
if (!defined('APP_DIR')) {
    define('APP_DIR', basename(dirname(dirname(__FILE__))));
}

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * Un-comment this line to specify a fixed path to CakePHP.
 * This should point at the directory containing `Cake`.
 *
 * For ease of development CakePHP uses PHP's include_path.  If you
 * cannot modify your include_path set this value.
 *
 * Leaving this constant undefined will result in it being defined in Cake/bootstrap.php
 */
//define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'lib');

/**
 * Editing below this line should NOT be necessary.
 * Change at your own risk.
 *
 */
if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', dirname(__FILE__) . DS);
}

if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    if (function_exists('ini_set')) {
        ini_set('include_path', ROOT . DS . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
    }
    if (!include ('Cake' . DS . 'bootstrap.php')) {
        $failed = true;
    }
} else {
    if (!include (CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'bootstrap.php')) {
        $failed = true;
    }
}
if (!empty($failed)) {
    trigger_error("CakePHP core could not be found.  Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php.  It should point to the directory containing your " . DS . "cake core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
}

App::uses('Dispatcher', 'Routing');

$Dispatcher = new Dispatcher();
$Dispatcher->dispatch(new CakeRequest(), new CakeResponse(array('charset' => Configure::read('App.encoding'))));