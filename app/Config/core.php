<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
Configure::write('debug',0);

/**
 * Configure the Error handler used to handle errors for your application.  By default
 * ErrorHandler::handleError() is used.  It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0. 
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
 *    including anonymous functions.
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
    'level' => E_ALL & ~E_DEPRECATED & ~E_NOTICE,
    'trace' => true
));

/**
 * Configure the Exception handler used for uncaught exceptions.  By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed.  When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 * - `renderer` - string - The class responsible for rendering uncaught exceptions.  If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
/* Configure::write('Exception', array(
  'handler' => 'ErrorHandler::handleException',
  'renderer' => 'ExceptionRenderer',
  'log' => true
  )); */

Configure::write('Exception', array(
    'handler' => 'ErrorHandler::handleException',
    'renderer' => 'AppExceptionRenderer',
    'log' => true
));

/**
 * Application wide charset encoding
 */
Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 * 	`admin_index()` and `/admin/controller/index`
 * 	`manager_index()` and `/manager/controller/index`
 *
 */
//Configure::write('Routing.prefixes', array('admin'));

/**
 * Turn off all caching application-wide.
 *
 */
//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
//Configure::write('Cache.check', true);

/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
define('LOG_ERROR', LOG_ERR);

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler.  Expects an array of of callables,
 *    that can be used with `session_save_handler`.  Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
/* Configure::write('Session', array(
  'defaults' => 'php'
  )); */
Configure::write('Session', array(
    'defaults' => 'php'
));

/**
 * The level of CakePHP security.
 */
Configure::write('Security.level', 'medium');

/**
 * A random string used in security hashing methods.
 */
//Configure::write('Security.salt', 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');
Configure::write('Security.salt', '');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
Configure::write('Security.cipherSeed', 76859309657453542496749683645);
//Configure::write('Security.cipherSeed', '');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
//Configure::write('Asset.timestamp', true);

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');

/**
 * Uncomment this line and correct your server timezone to fix 
 * any date & time related errors.
 */
date_default_timezone_set('UTC');

/**
 * Pick the caching engine to use.  If APC is enabled use it.
 * If running via cli - apc is disabled by default. ensure it's available and enabled in this case
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in boostrap.php for more info on the cache engines available 
 *       and their setttings.
 */
$engine = 'File';
//$engine = 'File';//'Memcache';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
    $engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
    $duration = '+10 seconds';
}
// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'myapp_';

/**
 * Configure the cache used for general framework caching.  Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
if ($engine == 'Memcache') {
    Cache::config('_cake_core_', array(
        'engine' => $engine,
        'prefix' => $prefix . 'cake_core_',
        'path' => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'Memcache'),
        'duration' => $duration
    ));
} else {
    Cache::config('_cake_core_', array(
        'engine' => $engine,
        'prefix' => $prefix . 'cake_core_',
        'path' => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'File'),
        'duration' => $duration
    ));
}
/****************** Default language setting *******************/
Configure::write('language','eng');//spa
/****************** Default language setting *******************/
/**
 * Configure the cache for model and datasource caches.  This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
if ($engine == 'Memcache') {
    Cache::config('_cake_model_', array(
        'engine' => $engine,
        'prefix' => $prefix . 'cake_model_',
        'path' => CACHE . 'models' . DS,
        'serialize' => ($engine === 'Memcache'),
        'duration' => $duration
    ));
} else {
    Cache::config('_cake_model_', array(
        'engine' => $engine,
        'prefix' => $prefix . 'cake_model_',
        'path' => CACHE . 'models' . DS,
        'serialize' => ($engine === 'File'),
        'duration' => $duration
    ));
}
//Configure::write('Session.checkAgent', false);
//Configure::write('Session.ini',array('session.cookie_secure' => false, 'session.referer_check' => false));
//Configure::load('core-email');
//Configure::write('DTAB', array( 1=>array('ftext'=>'All','fkeyword'=>'cases'),2 => array('ftext'=>'Recent','fkeyword'=>'latest'),4 =>array('ftext'=>'','fkeyword'=>'assigntome'),8=>array('ftext'=>'Bug','fkeyword'=>'bugcase'),16 =>array('ftext'=> 'High Priority','fkeyword'=>'highpriority'),32=>array('ftext'=>'New & WIP','fkeyword'=>'newwip')));
Configure::write('DTAB', array(1 => array('ftext' => __('All Tasks',true), 'fkeyword' => 'cases','ftext_org'=>'All Tasks'), 2 => array('ftext' => __('Tasks assigned to me',true), 'fkeyword' => 'assigntome','ftext_org'=>'Tasks assigned to me'),4 => array('ftext' => 'Favourites', 'fkeyword' => 'favourite','ftext_org'=>'Favourites'), 8 => array('ftext' => __('Overdue',true), 'fkeyword' => 'overdue','ftext_org'=>'Overdue'), 16 => array('ftext' => __("Tasks I've created",true), 'fkeyword' => 'delegateto','ftext_org'=>"Tasks I've created"), 32 => array('ftext' => __('High Priority',true), 'fkeyword' => 'highpriority','ftext_org'=>"High Priority"), 64 => array('ftext' => __('All Opened',true), 'fkeyword' => 'openedtasks','ftext_org'=>"All Opened"), 128 => array('ftext' => __('All Closed',true), 'fkeyword' => 'closedtasks','ftext_org'=>"All Closed")));
Configure::write('DTAB_SPA', array(1 => array('ftext' =>'Todas las tareas', 'fkeyword' => 'cases','ftext_org'=>'All Tasks'), 2 => array('ftext' => 'Tareas asignadas a mi', 'fkeyword' => 'assigntome','ftext_org'=>'Tasks assigned to me'),4 => array('ftext' => 'Favoritos', 'fkeyword' => 'favourite','ftext_org'=>'Favourites'), 8 => array('ftext' =>'Atrasado', 'fkeyword' => 'overdue','ftext_org'=>'Overdue'), 16 => array('ftext' => 'Tareas que he creado', 'fkeyword' => 'delegateto','ftext_org'=>"Tasks I've created"), 32 => array('ftext' => 'Alta prioridad', 'fkeyword' => 'highpriority','ftext_org'=>"High Priority"), 64 => array('ftext' => 'Todos abiertos', 'fkeyword' => 'openedtasks','ftext_org'=>"All Opened"), 128 => array('ftext' => 'Todo cerrado', 'fkeyword' => 'closedtasks','ftext_org'=>"All Closed")));

Configure::write('DTAB_POR', array(1 => array('ftext' =>'Todas as tarefas', 'fkeyword' => 'cases','ftext_org'=>'All Tasks'), 2 => array('ftext' => 'Tarefas atribuídas a mim', 'fkeyword' => 'assigntome','ftext_org'=>'Tasks assigned to me'),4 => array('ftext' => 'Favoritos', 'fkeyword' => 'favourite','ftext_org'=>'Favourites'), 8 => array('ftext' =>'Atrasado', 'fkeyword' => 'overdue','ftext_org'=>'Overdue'), 16 => array('ftext' => 'Tarefas que criei', 'fkeyword' => 'delegateto','ftext_org'=>"Tasks I've created"), 32 => array('ftext' => 'Prioridade máxima', 'fkeyword' => 'highpriority','ftext_org'=>"High Priority"), 64 => array('ftext' => 'Tudo aberto', 'fkeyword' => 'openedtasks','ftext_org'=>"All Opened"), 128 => array('ftext' => 'Tudo fechado', 'fkeyword' => 'closedtasks','ftext_org'=>"All Closed")));

Configure::write('DTAB_DEU', array(1 => array('ftext' =>'Alle Aufgaben', 'fkeyword' => 'cases','ftext_org'=>'All Tasks'), 2 => array('ftext' => 'Aufgaben, die mir zugewiesen wurden', 'fkeyword' => 'assigntome','ftext_org'=>'Tasks assigned to me'),4 => array('ftext' => 'Favoriten', 'fkeyword' => 'favourite','ftext_org'=>'Favourites'), 8 => array('ftext' =>'Überfällig', 'fkeyword' => 'overdue','ftext_org'=>'Overdue'), 16 => array('ftext' => 'Aufgaben, die ich erstellt habe', 'fkeyword' => 'delegateto','ftext_org'=>"Tasks I've created"), 32 => array('ftext' => 'Hohe Priorität', 'fkeyword' => 'highpriority','ftext_org'=>"High Priority"), 64 => array('ftext' => 'Alle geöffnet', 'fkeyword' => 'openedtasks','ftext_org'=>"All Opened"), 128 => array('ftext' => 'Alle geschlossen', 'fkeyword' => 'closedtasks','ftext_org'=>"All Closed")));

Configure::write('DTAB_FRA', array(1 => array('ftext' => 'Toutes les tâches', 'fkeyword' => 'cases','ftext_org'=>'All Tasks'), 2 => array('ftext' => 'Tâches assignées à moi', 'fkeyword' => 'assigntome','ftext_org'=>'Tasks assigned to me'),4 => array('ftext' => 'Favoris', 'fkeyword' => 'favourite','ftext_org'=>'Favourites'), 8 => array('ftext' => 'En retard', 'fkeyword' => 'overdue','ftext_org'=>'Overdue'), 16 => array('ftext' => 'Tâches que j\'ai créées', 'fkeyword' => 'delegateto','ftext_org'=>"Tasks I've created"), 32 => array('ftext' => 'Haute priorité', 'fkeyword' => 'highpriority','ftext_org'=>"High Priority"), 64 => array('ftext' => 'Tous ouverts', 'fkeyword' => 'openedtasks','ftext_org'=>"All Opened"), 128 => array('ftext' => 'Tous fermés', 'fkeyword' => 'closedtasks','ftext_org'=>"All Closed")));
Configure::write('default_action', 'mydashboard');
Configure::write('PROFILE_BG_CLR', array('clr1', 'clr2', 'clr3', 'clr4', 'clr5', 'clr6', 'clr7', 'clr8', 'clr9', 'clr10'));
Configure::write('VALID_USER_COUNT', array('10', '20', '35', '50','100'));

//for add-on discount 
//Configure::write('dis_cupn_arr', array('CHNEW05','CHSAVE10'));
Configure::write('discount', '0');
Configure::write('discount_type', 'per'); //flat

define('LDTRACK_URL', '');
Configure::write('USER_ACCESS_CHANGES', 
	array(
		'0' => __('Your access permission has been updated. Please login again.'),
		'1' => __('Your email has been changed. Please login with your new email.'),
		'2' => __('Your password has been changed. Please login with your new password.'),
		'3' => __('Your access permission has been upgraded to "Admin". Please login again to have this feature.'),
		'4' => __('Your access permission has been changed from "Client". Please login again to have this feature.'),
		'5' => __('Your access permission has been changed from "Admin" to "Client". Please login again to have this feature.'),
		'6' => __('Your access permission has been changed from "Client" to "User". Please login again to have this feature.'),
		'7' => __('Your access permission has been upgraded from "Client" to "Admin". Please login again to have this feature.'),
		'8' => __('Your account has been deactivated. Please contact your owner.')));

//include("install.php");
//include_once("constants.php");
include("setup.php");