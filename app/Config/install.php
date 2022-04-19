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
 
include("database.php");
$config= new DATABASE_CONFIG();
$name = 'default';
$settings = $config->{$name};
$is_connected = 1;
if(trim($settings['database']) == "") {
	$is_connected = 0;	
}else{
	App::uses('ConnectionManager', 'Model');
	try{
		$db = ConnectionManager::getDataSource('default');
		@$connected = $db->connect();
		if($connected){
			$is_connected = 1;			
		}
	}catch(Exception $e){
		$is_connected = 0;
		//print $e->getMessage();exit;
	}	
}

if(!$is_connected) {
    ?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta name="robots" content="noindex,nofollow" />
		<link rel="shortcut icon" href="images/favicon_new.ico"/>
		<title>Orangescrum Setup Wizard</title>
		<style>
		*{
			padding:5;
			margin:5;	
			font-family:Tahoma, Verdana;
		}
		.link:hover {
			text-decoration:underline;
		}
		h4 {
			font-size:14px;
		}
		</style>
	</head>
	<body>
		<div id="container">
			<div id="content">
				<table width="100%" align="center"><tr><td align="center">
				<table cellpadding="8" cellspacing="8" style="border:1px solid #999999;color:#000000" align="center" width="520px">
					<tr>
						<td align="center" style="border-bottom:1px solid #999999">
							<h3 style="color:#245271">4 simple steps to get started with Self hosted Orangescrum</h3>
						</td>
					</tr>
					<tr>
						<td align="left" style="padding-top:10px">
							<h4>Step1: <span style="font-weight:normal;">Give write permission (777) to `app/config`, `app/tmp` and `app/webroot` folders</h4>
							<h4>Step2: <span style="font-weight:normal;">Update database credentials to the "database.php" inside "app/Config" folder.</span></h4>
							<h4>Step3: <span style="font-weight:normal;">Provide the details of SMTP email sending options in `app/Config/constants.php`</span></h4>
							<h4>Step4: <span style="font-weight:normal;">Provide the details of SUPPORT_EMAIL, FROM_EMAIL, FROM_EMAIL_EC, TO_DEV_EMAIL in `app/Config/constants.php`</span></h4>
						</td>
					</tr>
                    <tr>
						<td align="center">
							
						</td>
					</tr>
				</table>
				</td></tr></table>
			</div>
		</div>
	</body>
	</html>
<?php
	check_subfolder(); exit;
}else{
	check_subfolder();
} ?>
<?php
function check_subfolder(){
	ini_set('display_errors', 0);
    error_reporting(E_ALL ^ E_NOTICE);
	include_once("constants.php");
	include_once(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Utility' . DS. 'File.php');
	include_once(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Utility' . DS. 'Folder.php');
	$root = dirname(dirname(dirname(__FILE__)));
	$config_dir = $root.DS.'app'.DS.'Config'.DS;
	$folders = explode(DS, $root);
	$sub_folder = $folders[count($folders) - 1].'/';
	$vhosted_folders = explode('/', $_SERVER['DOCUMENT_ROOT']);
	$vhosted_folder = $vhosted_folders[count($vhosted_folders) - 1] == ''?$vhosted_folders[count($vhosted_folders) - 2].'/':$vhosted_folders[count($vhosted_folders) - 1].'/';
	if($vhosted_folders[count($vhosted_folders) - 1] == '' && $vhosted_folder == $sub_folder){
		$sub_folder = '';
	}else if($vhosted_folders[count($vhosted_folders) - 1] != '' && $vhosted_folder == $sub_folder){
		$sub_folder = '/';
	}
	if($sub_folder != SUB_FOLDER){
		$path = $root.DS.'app'.DS.'Config'.DS.'constants.php';
		$tmppath = $root.DS.'app'.DS.'Config'.DS.'constants_tmp.php';
		$File = new File($path, true, 0777);
		$tmpfile = new File($tmppath, true, 0777);
		$originalContent = $File->read();
		//$replacement = "$sub_folder";
		$replacement = "define('SUB_FOLDER', '$sub_folder');";
		if(SUB_FOLDER == ''){
			$string = "/define\(\'SUB_FOLDER\'\, \'\'\);/";
		}else {
			$string = "/define\(\'SUB_FOLDER\'\, \'.*\'\);/";
		}
		$newContent = preg_replace($string, $replacement, $originalContent);
		$tmpfile->write($newContent);
		if($tmpfile->copy($path,true)){
			$tmpfile->delete();
			$File->close();
			checkDebug($sub_folder);
		}
	}
}
function checkDebug($sub_folder){
	ini_set('display_errors', 0);
	$debug = Configure::read('debug');
	if($debug == 2){
		$root = dirname(dirname(dirname(__FILE__)));
		$path = $root.DS.'app'.DS.'Config'.DS.'core.php';
		$tmppath = $root.DS.'app'.DS.'Config'.DS.'core_tmp.php';
		$File = new File($path, true, 0777);
		$TmpFile = new File($tmppath, true, 0777);
		$originalContent = $File->read('a');
		$pattern = "/Configure::write\(\'debug\',2\);/";
		$replacement = "Configure::write('debug',0);";
		$newContent = preg_replace($pattern, $replacement, $originalContent);
		$TmpFile->write($newContent);
		if($TmpFile->copy($path,true)){
			$TmpFile->delete();
			$File->close();
		}
		header('Location: '.HTTP_ROOT.$sub_folder);exit;
	}
}
?>