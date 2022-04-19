<?php
/*************************************************************************	
 * Orangescrum Community Edition is a web based Project Management software developed by
 * Orangescrum. Copyright (C) 2013-2022
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): THERE IS NO WARRANTY FOR THE PROGRAM, * TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN   
 * WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS"
 * WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT 
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 * PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE
 * PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
 * ALL NECESSARY SERVICING, REPAIR OR CORRECTION..
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street Fifth Floor, Boston, MA 02110,
 * United States.
 *
 * You can contact Orangescrum, 2059 Camden Ave. #118, San Jose, CA - 95124, US. 
   or at email address support@orangescrum.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Orangescrum" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Orangescrum".
 *****************************************************************************/

define("TASK_GROUP_CASE_PAGE_LIMIT", 25);

$ht = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
define('PROTOCOL', $ht);

if(stristr($_SERVER['SERVER_NAME'], '/') && substr($_SERVER['SERVER_NAME'], -1) == '/'){
	define('DOMAIN', $_SERVER['SERVER_NAME']);
}else{
	define('DOMAIN', $_SERVER['SERVER_NAME'] . "/");
}
/*Subfolder set up */
define('SUB_FOLDER', '@SUB_FOLDER');

define('HTTP_SERVER', PROTOCOL . DOMAIN);
if(stristr(HTTP_SERVER, '/') && substr(HTTP_SERVER, -1) == '/' && SUB_FOLDER == '/'){
	define('HTTP_ROOT', HTTP_SERVER);
	define('HTTP_APP', PROTOCOL . DOMAIN);
	define('HTTPS_HOME', PROTOCOL . DOMAIN);
	define('HTTP_HOME', "http://" . DOMAIN);
}else{
	define('HTTP_ROOT', HTTP_SERVER . SUB_FOLDER);
	define('HTTP_APP', PROTOCOL . DOMAIN . SUB_FOLDER);
	define('HTTPS_HOME', PROTOCOL . DOMAIN . SUB_FOLDER);
	define('HTTP_HOME', "http://" . DOMAIN . SUB_FOLDER);
}
if($_SERVER['SERVER_NAME'] == 'localhost'){
	define('DOMAIN_COOKIE', false);
}else{
	define('DOMAIN_COOKIE', $_SERVER['SERVER_NAME']);
}

/* SMTP credentials SET Ups Start*/

//gmail SMTP
define("SMTP_HOST", "smtp.sendgrid.net");
define("SMTP_PORT", "587");
define("SMTP_UNAME", "apikey");
define("SMTP_PWORD", "your_password");
define("SMTP_APIKEY", "");

define("IS_SMTP", 0);
define("IS_EML_VERIFY", 0);
define("IS_OTHERS", 1);
//https://sendgrid.com/user/signup (free signup to sendgrid)

define('EMAIL_DELIVERY', 'smtp');

//Most required settings start
define("SUPPORT_EMAIL", "");
define("FROM_EMAIL", "");
define("FROM_EMAIL_EC", "");

//Send mail without smtp
define("PHPMAILER", 0);

/* SMTP credentials SET Ups end*/

define("WEB_DOMAIN", "YourDomain.com"); //ex. demo.orangescrum.com
define('EMAIL_SUBJ', '[Orangescrum]');
define('EMAIL_SUBJC', 'Orangescrum');
define('SITE_NAME', '');

define("PDF_LIB_PATH", ""); ///usr/bin/wkhtmltopdf
define('HTTP_ROOT_INVOICE', "http://" . $_SERVER['SERVER_NAME'] . "/" . SUB_FOLDER);
define('HTTP_INVOICE', HTTP_ROOT . 'invoice/');
define('HTTP_INVOICE_PATH', WWW_ROOT . 'invoice' . DS);
define('INVOICE_LOGO_PATH', WWW_ROOT . 'invoice-logo' . DS);

define('USE_LOCAL', 1);
define("TO_DEV_EMAIL", SUPPORT_EMAIL);

define("NODEJS_HOST", ''); //ex. http://localhost:3002
define("NODEJS_HOST_CHAT", ''); // this is required for in-app chat

##################### Google Keys (Login, Drive, Contacts) ############################
define("CLIENT_ID", "XXXXXXXXXXXX.apps.googleusercontent.com");
define("CLIENT_ID_NUM", "XXXXXXXXXXXX");
define("CLIENT_SECRET", "xXxXXxxxx_xXxXXxxxx");
define("API_KEY", "xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx");
define("REDIRECT_URI", HTTP_ROOT . "users/googleConnect");
define("USE_GOOGLE", 0);


##################### Dropbox Key ############################
define("DROPBOX_KEY", "xXxxXxxxXx");
define("USE_DROPBOX", 0);

##################### AWS S3 Bucket ############################
define("USE_S3", 0); //Set this parameter to 1 to use AWS S3 Bucket
define("BUCKET_NAME", "Bucket Name");
define("DOWNLOAD_BUCKET_NAME", "download");
define("awsAccessKey", "XXXXXXXXXXXXXX");
define("awsSecretKey", "XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX");

define('DIR_USER_PHOTOS_S3', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/photos/');
define('DIR_USER_PHOTOS_S3_TEMP', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/temp/');
define('DIR_USER_PHOTOS_S3_FOLDER', 'files/photos/');
define('DIR_CASE_FILES_S3', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/case_files/');
define('DIR_CASE_FILES_S3_FOLDER', 'files/case_files/');
define('DIR_CASE_FILES_S3_FOLDER_TEMP', 'files/case_files/temp/');
define('DIR_CASE_FILES_S3_FOLDER_THUMB', 'files/case_files/thumb/');

define('DIR_INVOICE_PHOTOS_S3', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/invoice_logo/');
define('DIR_INVOICE_PHOTOS_S3_FOLDER', 'files/invoice_logo/');
define('DIR_PHOTOS_S3_TEMP_FOLDER', 'files/temp/');
define('DIR_PHOTOS_S3_TEMP', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/temp/');

define('DIR_COMPANY_LOGO', WWW_ROOT . 'files/company-logo/');
define('DIR_COMPANY_PHOTOS_S3', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/company_logo/');
define('DIR_COMPANY_PHOTOS_S3_FOLDER', 'files/company_logo/');
define('DIR_USER_COMPANY_S3', 'https://s3.amazonaws.com/' . BUCKET_NAME . '/files/company_logo/');
define('DIR_USER_COMPANY_S3_FOLDER', 'files/company_logo/');

//Push notification
define('PASS_PHASE', '');

//Android Pushnotification Key
define('FIREBASE_API_KEY', '');	

define('INVOICE_PAGE_LIMIT', 10);
define('RESOURCE_UTILIZATION_CSV_PATH', WWW_ROOT . 'files' . DS . 'resource_utilization' . DS);
define('HTTP_FILES', HTTP_ROOT . 'files/');
define('HTTP_DEFECT_FILES', HTTP_FILES . 'defect_files/');
//Image Upload Path
define('SKIP_MAIL_CHK', 1);
define('DIR_IMAGES', WWW_ROOT . 'img/');
define('DIR_FILES', WWW_ROOT . 'files/');
define('HTTP_DEFECT_ROOT_FILES', DIR_FILES . 'defect_files/');
define('DIR_CASE_FILES', DIR_FILES . 'case_files/');
define('DIR_USER_PHOTOS', DIR_FILES . 'photos/');
define('DIR_USER_PHOTOS_TEMP', 'files/temp/');
define('DIR_USER_PHOTOS_THUMB', 'files/thumb/');
define('DIR_PROJECT_LOGO', DIR_FILES . 'project_logo/');
define('HTTP_ROOT_LIVE', 'http://www.orangescrum.com/');
//Git client id
define("GITHUB_CLIENT_ID", "");
define("GITHUB_CLIENT_SECRET", "");

define('DIR_CASE_FILES_EDITOR_S3', 'https://s3.amazonaws.com/'.BUCKET_NAME.DS.'files'.DS.'case_editor_files'.DS);
define('DIR_CASE_FILES_EDITOR_S3_FOLDER_T', 'files'.DS.'case_editor_files'.DS);
define('DIR_CASE_EDITOR_FILES_T', DIR_FILES.'case_files'.DS.'case_editor_files'.DS);

define('DIR_CASE_FILES_EDITOR_S3_FOLDER', 'files/case_editor_files/');
define('DIR_CASE_EDITOR_FILES', WWW_ROOT.'files'.DS .'case_files/case_editor_files/');

define('GITHUB_LINK', 'https://github.com/Orangescrum/orangescrum/issues');