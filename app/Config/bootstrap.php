<?php
define('RELEASE', 36); //Increase the release version on every code push
//define('DISCOUNT',30);//% // Make sure that the same discount amount is there in "coupons" table
define('BETA_RELEASE', 0); //on 21-12-2021
define("USE_COUPON", 0);
define('RELEASE_V', 1);
define('RELEASE_VESION', 'v2.1.1');
define('MAINTENANCE', 0); //1 - activate , 0 - normal mode
define('SHOW_ARABIC', 0);
define('HELPDESK_URL_PARAM', "?oshead");
define('IS_SKINNY', 1);
define('HELPDESK_URL', 'https://helpdesk.orangescrum.com/');
define('SELFHOSTED_UPGRADE', 'https://www.orangescrum.com/pricing');
define('WHATS_NEW_URL', 'https://www.orangescrum.com/whats-new');
define('COMMUNITY_FORUM_URL', 'https://groups.google.com/g/orangescrum-community-support');
define('SUPPORT_URL', 'https://www.orangescrum.com/contact-support/');
Configure::write('PAID_PLANS', array('Startup' => 10, 'Basic' => 5, 'Standard' => 12, 'Professional' => 14));
Configure::write('FREE_PLANS', array('old' => '9', 'new' => '11')); //new should be the new FREE plan
Configure::write('ALL_FREE_PLANS', array(1, 9, 11));
Configure::write('ALL_PAID_PLANS', array());
Configure::write('CURRENT_PAID_PLANS', array(10 => 'Startup', 5 => 'Basic', 12 => 'Standard', 14 => 'Professional'));
//To compare and check Downgrade/Upgrade
Configure::write('ALL_PAID_PLANS_REVISED', array(5 => 'Basic',
    10 => 'Startup', 12 => 'Standard', 14 => 'Professional'));
Configure::write('CURRENT_YEALY_PLANS', array());
Configure::write('CURRENT_MONTHLY_PLANS', array(10 => 'Startup', 5 => 'Basic', 12 => 'Standard', 14 => 'Professional'));
Configure::write('CURRENT_PAID_PLANS_REVISED', array(
    'MONTHLY' => array(0 => array('Startup', 10, 9), 1 => array('Basic', 5, 29), 2 => array('Standard', 12, 49), 3 => array('Professional', 14, 69)),
    'YEARLY' => array(0 => array('Startup', 21, 108), 1 => array('Basic', 22, 348), 2 => array('Standard', 23, 588), 3 => array('Professional', 24, 828))));
define("CURRENT_FREE_PLAN", 1);
define("CURRENT_EXPIRED_PLAN", 13);
define("UPGRADE_PLAN", 16);
define("FREE_TRIAL_PERIOD", 365);
Configure::write('DEFAULT_TASK_DTL',array('title'=>'Welcome to Orangescrum! How it works? (Dummy Task)', 'description'=>'Create projects, invite your teams, assign tasks and get going in less than sixty seconds. <br /> Auto-notifications and invites are sent to users to start working on their assigned tasks and move projects forward.','attach'=>''));
Configure::write('RESTRICTED_PROJ_OV', array(38154,19398));
if (!defined('CHECK_DOMAIN')) {
    define('NO_SUB_DOMAIN', 1);
    define('CHECK_DOMAIN', '');
}
Configure::write('TASK_FIELDS', array(
        '0'=>array('id'=>1,'label'=>__('Project'),'is_default'=>0,'force_display'=>0),
        '1'=>array('id'=>2,'label'=>__('Task Title'),'is_default'=>1,'force_display'=>0),
        '2'=>array('id'=>3,'label'=>__('Assign To'),'is_default'=>0,'force_display'=>0),
        '3'=>array('id'=>4,'label'=>__('Task Type'),'is_default'=>0,'force_display'=>0),
        '4'=>array('id'=>5,'label'=>__('Priority'),'is_default'=>0,'force_display'=>0),
        '5'=>array('id'=>6,'label'=>__('Description & Attachment'),'is_default'=>0,'force_display'=>0),
        '6'=>array('id'=>7,'label'=>__('Date Range'),'is_default'=>0,'force_display'=>0),        
        '7'=>array('id'=>8,'label'=>__('Task Group/Sprint'),'is_default'=>0,'force_display'=>0),
        '8'=>array('id'=>9,'label'=>__('Estimated Hours'),'is_default'=>0,'force_display'=>0),
        '10'=>array('id'=>11,'label'=>__('Timelog'),'is_default'=>0,'force_display'=>0),
        '14'=>array('id'=>15,'label'=>__('Notify Via Email'),'is_default'=>0,'force_display'=>0),

    )
);
Configure::write('TASK_FIELDS_DEFAULT', array('1,2,3,4,5,6,7,8,9,14,16'));
Configure::write('PROJECT_FIELDS', array(
        '0'=>array('id'=>1,'label'=>__('Project Name'),'is_default'=>1,'force_display'=>0),
        '1'=>array('id'=>2,'label'=>__('Project Short Name'),'is_default'=>1,'force_display'=>0),
        '2'=>array('id'=>3,'label'=>__('Priority'),'is_default'=>1,'force_display'=>0),
        '3'=>array('id'=>4,'label'=>__('Description'),'is_default'=>0,'force_display'=>0),
        '4'=>array('id'=>5,'label'=>__('Project Plan'),'is_default'=>0,'force_display'=>0),
        '5'=>array('id'=>6,'label'=>__('Project Template'),'is_default'=>0,'force_display'=>0),
        '6'=>array('id'=>7,'label'=>__('Workflow'),'is_default'=>0,'force_display'=>0),        
        '7'=>array('id'=>8,'label'=>__('Task Type'),'is_default'=>0,'force_display'=>0),
        '8'=>array('id'=>9,'label'=>__('Estimated Hours'),'is_default'=>0,'force_display'=>0),
        '9'=>array('id'=>10,'label'=>__('Date Range'),'is_default'=>0,'force_display'=>0),
        '10'=>array('id'=>11,'label'=>__('Project Manager'),'is_default'=>0,'force_display'=>0),        
        '11'=>array('id'=>12,'label'=>__('Client'),'is_default'=>0,'force_display'=>0),
        '12'=>array('id'=>13,'label'=>__('Currency'),'is_default'=>0,'force_display'=>0),
        '13'=>array('id'=>14,'label'=>__('Users'),'is_default'=>0,'force_display'=>0),
        '14'=>array('id'=>15,'label'=>__('Budget'),'is_default'=>0,'force_display'=>0),
        '15'=>array('id'=>16,'label'=>__('Default Rate'),'is_default'=>0,'force_display'=>0),
        '16'=>array('id'=>17,'label'=>__('Cost Appr'),'is_default'=>0,'force_display'=>0),
        '17'=>array('id'=>18,'label'=>__('Min & Max Tolerance'),'is_default'=>0,'force_display'=>0),
        '18'=>array('id'=>19,'label'=>__('Project Status'),'is_default'=>0,'force_display'=>0),
        '19'=>array('id'=>20,'label'=>__('Project Type'),'is_default'=>0,'force_display'=>0),
        '20'=>array('id'=>21,'label'=>__('Industry'),'is_default'=>0,'force_display'=>0),

    )
);
Configure::write('PROJECT_FIELDS_DEFAULT', array('1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21'));

Configure::write('PROJECT_FIELDS_LISTING', array("Project Name","Short Name","Description","Project Manager","Client","Budget","Status","Cost Approved","Estimated","Spent","Users","Tasks","Template","Workflow","Last Activity","Storage","Project Type","Industry"));

define("PLAY_VIDEO_TEXT", 'Watch Video');
define("CURRENT_FREE_PLAN", 11);
define("CURRENT_EXPIRED_PLAN", 13);
define("UPGRADE_PLAN", 16);
if(date('Y-m-d H:i:s') >= '2020-11-12 11:50:00'){
	define("FREE_TRIAL_PERIOD", 14);
	define('TRIAL_DAY_TXT', 14);
}else{
	define("FREE_TRIAL_PERIOD", 45);
	define('TRIAL_DAY_TXT', 45);
}
define("MARKETING_SUPPORT_EMAIL", '');
define("ADMIN_EMAIL", '');
define("DEV_EMAIL", '');
define('TESTING_IN_LOCAL', 1);
/* * *********** Marketing Email ********* */
define('MARKETING_NAME', 'Orangescrum Support Customer');
define('MARKETING_EMAIL', 'support@orangescrum.com');
/* * ************************************* */
define('GA_CODE', 0);
define('FROM_EMAIL_EC_NOTIFY', FROM_EMAIL_EC);
define('HTTP_HOME_ORG', 'http://www.orangescrum.org/');
define('HTTP_DEMO', 'https://demo.orangescrum.com');

define('TIMELIMIT', 3000);
define('GMT_DATETIME', gmdate('Y-m-d H:i:s'));
define('GMT_DATE', gmdate('Y-m-d'));
define('GMT_TIME', gmdate('H:i:s'));
define('MAX_FILE_SIZE', 200); //In Mb
define('CASE_PAGE_LIMIT', 30); // Task Listing Page
define('MILESTONE_PAGE_LIMIT', 5);
define('PROJECT_PAGE_LIMIT', 30);
define('MILE_PAGE_LIMIT', 30);
define('USER_PAGE_LIMIT', 30);
define('ARC_PAGE_LIMIT', 30);
define('MAX_SPACE_USAGE', 1024);
define('MILESTONE_PER_PAGE', 3);
define('ARC_CASE_PAGE_LIMIT', 10);
define('ARC_FILE_PAGE_LIMIT', 10);
define('TEMP_PROJECT_PAGE_LIMIT', 10);
define('TEMP_TASK_PAGE_LIMIT', 10);
define('TASK_SEARCH_LIMIT', 30);
define("SIGNUP_CTA_A", 'Try It Free For 30 Days');
define("SIGNUP_CTA_B", 'Start Your Free Trial');
define("PRICING_BOX_TXT", 'Get Started');
Configure::write('TYPES_PLAN', array(9 => 'Free', 11 => 'Free', 10 => 'Startup', 5 => 'Basic', 6 => 'Team', 7 => 'Business', 8 => 'Premium', 1 => 'Free', 2 => 'Pro', 3 => 'Team', 4 => 'Premium', 12 => 'Standard', 14 => 'Professional', 21 => 'Startup', 22 => 'Basic', 23 => 'Standard', 24 => 'Professional',31=>'Corporate',32=>'Corporate'));




define('INACT_CASE_PAGE_LIMIT', 10);
define("INACT_TASK_GROUP_CASE_PAGE_LIMIT", 5);
define('FILTER_PAGE_LIMIT', 30);

define('ONBORDING', 1);
define('ONBORDING_DAILY_UPDATE', 1);
define('ONBORDING_DATE', '2013-10-10');
define('IP2LOC_API_KEY', '');

define('SHOW_CLICKDESK', 1);
define('MANDRILL_UNAME', "");
define('MANDRILL_APIKEY', "");
define('MANDRILL_PASSWORD', "");

//For Opensource
define('OPENSOURCE_MANUAL', 'https://github.com/Orangescrum/orangescrum/raw/master/OrangescrumInstallationManual.pdf');
define('OPENSOURCE_APP', '');

if (isset($_COOKIE['REMEMBER']) && $_COOKIE['REMEMBER']) {
    define('COOKIE_TIME', time() + 3600 * 24 * 180);
} else {
    define('COOKIE_TIME', time() + 3600 * 24 * 180);
}
define('COOKIE_REM', time() + 3600 * 24 * 180);

define('CSS_PATH', HTTP_ROOT . 'css/');
define('JS_PATH', HTTP_ROOT . 'js/');
define('CSV_PATH', WWW_ROOT . 'csv/');
define('DOWNLOAD_TASK_PATH', WWW_ROOT . 'DownloadTask'.DS);
define('DOWNLOAD_S3_TASK_PATH', 'DownloadTask/zipTask/');
define('CHAT_PATH', WWW_ROOT . 'chat-imgs' . DS);
define('CHAT_FILE', HTTP_APP . 'chat-imgs/');
define('LOGTIME_CSV_PATH', CSV_PATH . 'logtime_csv' . DS);
define('TASKLIST_CSV_PATH', CSV_PATH . 'tasks_csv' . DS);

//Image Display path
define('HTTP_IMAGES', HTTP_ROOT . 'img/');
define('HTTP_FILES', HTTP_ROOT . 'files/');
define('HTTP_CASE_FILES', HTTP_FILES . 'case_files/');
define('HTTP_USER_PHOTOS', HTTP_FILES . 'photos/');
define('HTTP_PROJECT_LOGO', HTTP_FILES . 'project_logo/');
define('JCROP_PATH', 'app/webroot/jcrop/opticrop.php?src=/app/webroot/');



define('OS_LICENSE_SALT', "##orangescrum537F");
define('OS_LICENSE_SALT_FILE', "upgradelicenses");

//Subscription information
define("CONFIG_SUBSCRIPTION", 1);
define("PRICE_PER_USER", 8);
define("TRIAL_PERIOD", 60);
define("REC_PER_PAGE", 20);
/* Not required */
define("BT_DISCOUNT", '');
define("BT_ADDON", '');
$ext = '.ini';
define("OCDPATH", WWW_ROOT.'os'.$ext);
include_once('messages.php');
//include_once('core-email.php');
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'File', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, // [optional]
 * 		'mask' => 0666, // [optional] permission mask to use when creating cache files
 * 	));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Apc', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with thic string
 * 	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Xcache', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 * 		'user' => 'user', //user from xcache.admin.user settings
 * 		'password' => 'password', //plaintext password (xcache.admin.pass)
 * 	));
 *
 * Memcache (http://memcached.org/)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Memcache', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 * 	));
 *
 *  Wincache (http://php.net/wincache)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Wincache', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 	));
 *
 * Redis (http://http://redis.io/)
 *
 * 	 Cache::config('default', array(
 * 		'engine' => 'Redis', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'server' => '127.0.0.1' // localhost
 * 		'port' => 6379 // default port 6379
 * 		'timeout' => 0 // timeout in seconds, 0 = unlimited
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 	));
 */
    Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models', '/next/path/to/models'),
 *     'Model/Behavior'            => array('/path/to/behaviors', '/next/path/to/behaviors'),
 *     'Model/Datasource'          => array('/path/to/datasources', '/next/path/to/datasources'),
 *     'Model/Datasource/Database' => array('/path/to/databases', '/next/path/to/database'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions', '/next/path/to/sessions'),
 *     'Controller'                => array('/path/to/controllers', '/next/path/to/controllers'),
 *     'Controller/Component'      => array('/path/to/components', '/next/path/to/components'),
 *     'Controller/Component/Auth' => array('/path/to/auths', '/next/path/to/auths'),
 *     'Controller/Component/Acl'  => array('/path/to/acls', '/next/path/to/acls'),
 *     'View'                      => array('/path/to/views', '/next/path/to/views'),
 *     'View/Helper'               => array('/path/to/helpers', '/next/path/to/helpers'),
 *     'Console'                   => array('/path/to/consoles', '/next/path/to/consoles'),
 *     'Console/Command'           => array('/path/to/commands', '/next/path/to/commands'),
 *     'Console/Command/Task'      => array('/path/to/tasks', '/next/path/to/tasks'),
 *     'Lib'                       => array('/path/to/libs', '/next/path/to/libs'),
 *     'Locale'                    => array('/path/to/locales', '/next/path/to/locales'),
 *     'Vendor'                    => array('/path/to/vendors', '/next/path/to/vendors'),
 *     'Plugin'                    => array('/path/to/plugins', '/next/path/to/plugins'),
 * ));
 *
 */
/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rulec('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
/**
 * You can attach event listeners to the request lifecyle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 * 		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 * 		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 * 		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 * 		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'FileLog',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
    'mask' => 0777,
));
CakeLog::config('error', array(
    'engine' => 'FileLog',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
    'mask' => 0777,
));

define('STATIC_CONTENT_BUCKET_NAME', '');
define('STATIC_CONTENT_S3_PATH', '');
define('CUSTOMER_SUPPORT_URL', 'http://helpdesk.orangescrum.com/contact-support/');
define('KNOWLEDGEBASE_URL', 'http://helpdesk.orangescrum.com/knowledge-base/');
define('KNOWLEDGEBASE_CATEGORY_URL', 'http://helpdesk.orangescrum.com/knowledge-base-category/');
define('ADD_ON_FOLDER_PATH', '');
define("USE_ADDON_DISCOUNT", 0);
define("UPGD_PKG", 'Upgrade your package to avail this feature.');

Configure::write('FEATURE_RESTRICTED_PLAN', array('ra'=>array(10, 21))); //'gantt'=>array(10, 21),
Configure::write('ALLOWED_COMPANIES', array(19398));
Configure::write('DEFAULT_TASK_TYPES', array('1' => array('Type' => array('id' => '1','name' => 'Bug','short_name' => 'bug', 'seq_order' => '2')),'2' => array('Type' => array('id' => '12','name' => 'Change Request','short_name' => 'cr','seq_order' => '4')),'3' => array('Type' => array('id' => '2','name' => 'Development','short_name' => 'dev','seq_order' => '1')),'4' => array('Type' => array('id' => '3','name' => 'Enhancement','short_name' => 'enh','seq_order' => '6')),'5' => array('Type' => array('id' => '11','name' => 'Idea','short_name' => 'idea','seq_order' => '5')),'6' => array('Type' => array('id' => '7','name' => 'Maintenance','short_name' => 'mnt','seq_order' => '8')),'7' => array('Type' => array('id' => '5','name' => 'Quality Assurance','short_name' => 'qa','seq_order' => '9')),'8' => array('Type' => array('id' => '9','name' => 'Release','short_name' => 'rel','seq_order' => '11')),'9' => array('Type' => array('id' => '4','name' => 'Research n Do','short_name' => 'rnd','seq_order' => '7')),'10' => array('Type' => array('id' => '6','name' => 'Unit Testing','short_name' => 'unt','seq_order' => '10')),'11' => array('Type' => array('id' => '10','name' => 'Update','short_name' => 'upd','seq_order' => '3') ),'12' => array('Type' => array('id' => '8','name' => 'Others','short_name' => 'oth','seq_order' => '12')),'13' => array('Type' => array('id' => '13','name' => 'Epic','short_name' => 'ep','seq_order' => '13')),'14' => array('Type' => array('id' => '14','name' => 'Story','short_name' =>'sto','seq_order' => '14'))));

Configure::write('USER_DASHBOARD_ITEMS',
    array(
        0=>array(
            '1' => array('id' => '9', 'name' => 'admin_task_status'),
            '2' => array('id' => '1','name' => 'all_projects'),
            '3' => array('id' => '10','name' => 'all_clients'),
            '6' => array('id' => '11','name' => 'dashboard_timelog'),
            '7' => array('id' => '5','name' => 'project_resource_utilization'),
            '8' => array('id' => '6','name' => 'To Dos'),
            '9' => array('id' => '7','name' => 'project_status'),
            '10' => array('id' => '8','name' => 'Task Types'),
            '11' => array('id' => '12','name' => 'Recent Activities' ),
            '12' => array('id' => '13','name' => 'dashboardBookmarksList' )
        ),
        1=>array(
            '1' => array('id' => '10','name' => 'Spent Hour'),
            '2' => array('id' => '11','name' => 'My Tasks'),
            '3' => array('id' =>'12','name' => 'My Overdue'),
            '4' => array('id' => '6','name' => 'Recent Activities'),
            '5' => array('id' => '13','name' => 'workload_chart'),
            '6' =>array('id' => '14','name' => 'My Progress'),
            '7' => array('id' => '15','name' => 'Task Piechart'),
            '8' => array('id' => '9','name' => 'Task Status'),
            '9' => array('id' => '1','name' => 'To Dos'),
            '10' => array('id' => '3','name' => 'Usage Details'),
            '11' => array('id' => '5','name' => 'Statistics'),
            '12' => array('id' => '7','name' => 'project_status'),
            '13' =>array('id' => '8','name' => 'Task Types'),
            '14' => array('id' => '13','name' => 'dashboardBookmarksList')
        )
    ));

Configure::write('PROJECT_TYPE',array(1=>'Simple', 2=>'Scrum'));
Configure::write('VALID_H_POT',array(
									'refer'=>array(0,'wn'), //name, whattsap
									'register'=>array('','m'), // last, middle
									'register_outer'=>array('','m'), // last, middle
									'order_self'=>array('p','0'), // phonr, otheremail
									'inv_eml'=>array(0=>''), // name
									'tutorial'=>array('','m'), // last, middle
								)
				);
define('DUMMY_PROJECT_NAME', 'Sample Project- Website Development');
define('DUMMY_PROJECT_SHT_NAME', 'WDEV');
define('UNIQUE_SIGNUP_PROCESS', 1);
Configure::write('OUTER_PAGES', ['home', 'gdrive', 'testnefield', 'updates', 'community_faq', 'lp_installation_guides', 'open_source_outer', 'mobile_app', 'site_map', 'slack_integration', 'invoice_how_it_works', 'time_login', 'consulting_details', 'os_premises', 'training', 'customization', 'get_involved', 'testimonial', 'contact_team', 'free_download', 'community', 'roadmap', 'services', 'unsubscribe', 'request_demo', 'send_mail_to_customers', 'checksubscription_cron', 'validate_emailurl', 'instantinvoice', 'eventLog', 'bttransaction', 'create_btprofile', 'register_user', 'login', 'pricing', 'success_story', 'contact_support', 'choose_orangescrum', 'extendtrialdrip', 'timesheet_templates', 'excel_projt_templates', 'excel_gc_templates', 'excel_invo_templates', 'all_free_templates', 'about_timesheet', 'captcha1', 'rendCaptcha', 'validateCaptcha', 'compareos', 'tutorial', 'free_template_download', 'feed', 'displayStorage', 'display', 'signup', 'give_away', 'get_mobile_device', 'watch_demo', 'gdpr_rule', 'all_features', 'termsofservice_refer', 'refer_a_friend', 'register', 'forgotpassword', 'feedback', 'contactnow', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'price', 'privacypolicy', 'securities', 'affiliates', 'aboutus', 'tour', 'termsofservice', 'latest', 'update_email', 'dailyupdate_notifications', 'registration', 'check_short_name_reg','ajax_registration', 'confirmation', 'check_url_reg',
'check_email_reg','invitation', 'getlogin', 'session_maintain', 'post_support', 'invoicePage',
'sub_transaction','paypalipn', 'paypalipnreturn', 'thank_mail', 'lunchuser', 'help',
'googleConnect', 'syncGoogleCalendar', 'googleSignup', 'setGoogleInfo',
'emailUpdate', 'add_ons', 'installation_guide', 'install_windows', 'go_daddy',
 'install_mac', 'local_setup', 'project_management','resource_utlization',
 'gantt_chart','timelog','time_tracking', 'cost_tracking', 'task_groups',
 'kanban_view', 'catch_up', 'invoicePdf', 'customer_support', 'nginx',
 'addon_download_invoice', 'os_rev_from_self', 'enterprise_home',
 'marketing_industry','it_industry', 'order_enterprise',
 'community_installation_support', 'installation_download_invoice',
 'sendEbookLink', 'user_build_form','create_project','contact_faq','timesheetPDF',
 'resource_allocation_pdf','community_addon_download','pdfcase_project',
 'task_management','os_v3','alternative_asana','alternative_jira',
 'alternative_wrike','alternative_openproject','alternative_google_task',
 'onboard_outer','register_user_outer','downloadTutorialPdf',
 'sendTutorialAttachement','project_overview_pdf','unlimited_user',
 'export_pdf_timelog','help_support','agile_pm','os_migration','pdfsprint_report',
 'executive_demo','user_role_management','gcnotification','whats_new_update',
 'resource_all','gcalendar_integration','custom_status_workflow',
 'remote_team_management','agency_project_management','updategithubevents','sync',
 'labelsync','gitconnect','gonetaplogin','os_press','product_videos',
 'search_helpdesk','analytic_reports','project_templates','project_templates_scrum',
 'project_templates_kanban','project_templates_bugtracker',
 'project_templates_contentmgmt','project_templates_recruitment',
 'project_templates_procurement','project_templates_simple',
 'project_templates_tasktracking','ppc_landing','ppc_template','news_room','release',
 'press_release_detail','press_release_detail_freetrial','press_release_detail_osv3',
 'saveTraffic','thankyou','ajax_get_location','notify_me','allproduct',
 'business_operations','professional_service','mention','work_management',
 'workload_management', 'program_management', 'client_management','project_calendar','customers','build_vs_buy','custom_fields','verifySubDomain','ssoLogin']);

Configure::write('AJAX_EXCLUDE_PAGES', ['ajax_case_menu','ajax_project_size','ajax_case_status','ajax_common_breadcrumb','getLabelTasks','ajax_change_sequence','active_sprint','ajax_check_estd','ajax_check_parent','quickTask','project_menu','case_details','case_project','case_backlog','loadTaskByBacklog', 'fetchTaskItemOptions','ajax_quickcase_mem','loadTaskByTaskgroup','saveParentTask']);
Configure::write('AJAX_PAGES', ['remember_filters', 'session_maintain', 'add_user', 'add_project','archive_case', 'archive_file', 'ajaxpostcase', 'check_email_reg', 'check_short_name_reg', 'check_url_reg', 'update_notification', 'feedback', 'check_short_name', 'new_user', 'notification', 'caseview_remove', 'project_all', 'jquery_multi_autocomplete_data', 'search_project_menu', 'project_listing', 'assign_prj', 'contactnow', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'case_list', 'file_list', 'move_list', 'case_remove', 'move_file', 'file_remove', 'comment_edit', 'comment', 'fileremove', 'fileupload', 'case_update', 'case_files', 'case_reply', 'case_quick', 'case_message', 'update_assignto', 'exportcase', 'assign_userall', 'image_thumb', 'to_dos', 'recent_projects', 'recent_activities', 'recent_milestones', 'statistics', 'usage_details', 'task_progress', 'task_types', 'leader_board', 'post_support_inner']);
Configure::write('INDUSTRY_PAGES', ["home", "gdrive", "signup", 'register', "register_user", "free_download", "community", "services", "company_details", "pricing", "add_ons", 'installation_guide', 'install_windows', 'go_daddy', 'install_mac', 'local_setup', 'enterprise_home', 'order_enterprise','marketing_industry','it_industry','success_story','give_away','get_mobile_device','watch_demo', 'gdpr_rule','all_features', 'refer_a_friend','task_management','os_v3','register_user_outer','agile_pm','os_migration','executive_demo','whats_new_update','resource_all','os_press','product_videos','project_templates','project_templates_scrum','project_templates_kanban','project_templates_bugtracker','project_templates_contentmgmt','project_templates_recruitment','project_templates_procurement','project_templates_simple','project_templates_tasktracking','ppc_landing','news_room','press_release_detail','press_release_detail_freetrial','press_release_detail_osv3','allproduct','business_operations','mention','work_management','workload_management']);
