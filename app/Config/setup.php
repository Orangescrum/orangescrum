<?php
/* * *******************************************************************************
 * Orangescrum Community Edition is a web based Project Management software developed by
 * Orangescrum. Copyright (C) 2013-2014
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
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
 * ****************************************************************************** */
 ?>
<?php
//Prabhu set up 
/*define("OCDCONFPATH", WWW_ROOT.'os-conf.ini');
//read and write to inin file
if(file_exists(OCDCONFPATH)){
	$os_cnf = parse_ini_file(OCDCONFPATH,true);
}else{
	die("Missing configuration file.");exit;
}
//using ini file
if (!empty($_POST)) {
	$handle_fl = fopen(OCDCONFPATH, "w+");
	foreach($os_cnf as $k => $v){
		$txt_k = '['.$k.']'."\n";
		fwrite($handle_fl, $txt_k);
		if(is_array($v)){
			foreach($v as $in_k => $in_v){	
				$txt_in_k = $in_k.' = '.$in_v;
				fwrite($handle_fl, $txt_in_k."\n");
			}
		}
		fwrite($handle_fl, "\n");
	}
	fclose($handle_fl);
}*/
?>
<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 if(strrpos( $actual_link,"?")){
	$actual_link = substr($actual_link, 0, strrpos( $actual_link,"?"));
 }
error_reporting(E_ALL);
set_time_limit(0);
include_once("database.php");
include_once("constants.php");
$config = new DATABASE_CONFIG();
$name = 'default';
$settings = $config->{$name};
$database_flag = 0;
$smtp_flag = 0;
$others_flag = 0;
$email_verify_flag = 0;
$url = $_SERVER['REQUEST_URI'];
$arr = explode("/", $url);
$sub_folder = $arr[1];
if(SUB_FOLDER != $sub_folder."/") {
    check_subfolder();
}
/*if(!empty($_REQUEST['check_email']) && $_REQUEST['check_email']==1 ){
   $msg = checkEmailSmtp($_REQUEST['data']);
}*/
if(!empty($_REQUEST['is_smtp']) && $_REQUEST['is_smtp']==1 ){
   checkSkipSmtp('smtp');
   checkDebug();
}
if(!empty($_REQUEST['is_email_verify']) && $_REQUEST['is_email_verify']==1 ){
   checkSkipSmtp('emailv');
}
if(!empty($_REQUEST['is_others']) && $_REQUEST['is_others']==1 ){
   checkSkipSmtp('other');
   sleep(4);
   header('Location:'.$actual_link);exit;
}
 $check_constants_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php';
 $check_file = fopen($check_constants_filename, "a+");
  while (!feof($check_file)) {
    $check_line = fgets($check_file);
    if (stristr($check_line, 'define("SMTP_UNAME", "youremail@gmail.com");') || stristr($check_line, 'define("SMTP_PWORD", "******");')) {
        $smtp_flag =1;
        break;
    }
}
fclose($check_file);
if(!empty($settings['host']) && !empty($settings['login']) && !empty($settings['database'])){
    $conn = @new mysqli($settings['host'], $settings['login'], $settings['password'],$settings['database']);
        if (!empty($conn->connect_error)) { 
            $database_flag= 0;
        }else{
            $check_database_table_sql = "select count(*) as table_count from information_schema.tables where table_type = 'BASE TABLE' and table_schema ='".$settings['database']."'";
            $table_count_obj = $conn->query($check_database_table_sql);
            $table_count =  $table_count_obj->fetch_assoc();
            if(empty($table_count['table_count'])){
                $database_flag= 2;
            }else{
				$database_flag= 1;
			}
        }
}
if (!empty($_POST)) {
    if(!empty($_POST['Database'])){
        $postdata = $_POST['Database'];
        $servername = !empty($postdata['host']) ? $postdata['host'] : $settings['host'];
        $username = !empty($postdata['user']) ? $postdata['user'] : $settings['login'];
        $password = !empty($postdata['pass']) ? $postdata['pass'] : $settings['password'];
        $database = !empty($postdata['database']) ? $postdata['database'] : $settings['database'];
        // Create connection
        $conn = @new mysqli($servername, $username, $password);
        // Check connection
        if (!empty($conn->connect_error)) { ?>
            <!DOCTYPE html>
                <html>
                    <head>
                        <meta name="robots" content="noindex,nofollow" />
                        <link rel="shortcut icon" href="images/favicon_new.ico"/>
                        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
                        <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
                        <title>Orangescrum Setup Wizard</title>
                    </head>
                    <body>
                         <div class="ld_pop_mcnt" style="display:none;">
                            <div class="loader_pop">  
                                Please do not refresh the page while installation <br/>is being processed.
                                <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                                <div style="clear: both"></div>    
                             </div>
                        </div>
                        <div id="container">
                            <div id="content">
                                <div class="title_logo">
                                  <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                                  <h3>Database Configuration</h3>
                                   <strong style="display: block;" class="config-error">Wrong database information. Please try with correct information.</strong>
                                </div>
                                <table width="100%" align="center">
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
                                                <tr>
                                                    <td align="left">
                                                        <form id="setup" method="post">
                                                            <table>
                                                                <tr>
                                                                    <td>Name:</td>
                                                                    <td><input type="text" name="Database[database]" placeholder="Enter database name" autofocus="1"  autocomplete="off" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Host:</td>
                                                                    <td><input type="text" name="Database[host]" placeholder="Enter database host"  autocomplete="off" />
                                                                    <small style="color:green;display: block;margin-left: 8px;margin-top: 5px;font-size: 12px;">Note: localhost or IP Address(192.168.2.54) or RDS end point</small>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Username:</td>
                                                                    <td><input type="text" name="Database[user]" placeholder="Enter database username"  autocomplete="off" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Password:</td>
                                                                    <td><input type="password" name="Database[pass]" placeholder="Enter database password" autocomplete="off"/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td><input type="submit" value="Next"/></td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td align="center">
                                                        <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
                        <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#setup").validate({
                                    rules: {               
                                        'Database[database]': {
                                            required: true,             
                                        },
                                        'Database[host]': {
                                            required: true,             
                                        },
                                        'Database[user]': {
                                            required: true,             
                                        }
                                    },
                                    messages: {               
                                        'Database[database]': {
                                            required: "Please enter your database name",
                                        },
                                        'Database[host]': {
                                            required: "Please enter your database host",
                                        },
                                        'Database[user]': {
                                            required: "Please enter your database user name",
                                        }
                                    },
                                    errorElement: "small",
                                    errorPlacement: function(error, element) {
                                        error.insertAfter(element);
                                    },
                                    submitHandler: function(form) {
                                        $(".ld_pop_mcnt").show();
                                        form.submit();
                                    }
                                });       
                            });
                        </script> 
                    </body>
                </html>
<?php exit;
}
$filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'database.php';
$tmp_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'database.tmp.php';
$file = fopen($filename, "a+");
$writing = fopen($tmp_filename, 'w');
$size = filesize($filename);
//start buffered download
while (!feof($file)) {
//reset time limit for big files
#set_time_limit(0);
$line = fgets($file);

if (stristr($line, "'host'") && !empty($servername)) {
	$line = "'host' => '{$servername}',\n";
} elseif (stristr($line, "'login'") && !empty($username)) {
	$line = "'login' => '{$username}',\n";
} elseif (stristr($line, "'password'") && !empty($password)) {
	$line = "'password' => '{$password}',\n";
} elseif (stristr($line, "'database'") && !empty($database)) {
	$line = "'database' => '{$database}',\n";
}
fputs($writing, $line);
//flush();
//ob_flush();
}
fclose($file);
fclose($writing);
unlink($filename);
rename($tmp_filename, $filename);
$sql = "CREATE DATABASE " . $database . ";";
if ($conn->query($sql) === TRUE) {
$conn = @new mysqli($servername, $username, $password,$database);
	$database_sql = ROOT.DS."database.sql";
	$templine = '';
	$lines = file($database_sql);
	foreach ($lines as $line){
		if (substr($line, 0, 2) == '--' || $line == ''){
			continue;
		}
		$templine .= $line;
		if (substr(trim($line), -1, 1) == ';'){
			$conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			$templine = '';
		}
	}?>
			<!DOCTYPE html>
			<html>
				<head>
					<meta name="robots" content="noindex,nofollow" />
					<link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
					<link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
					<title>Orangescrum Setup Wizard</title>
				</head>
			<body>
			   <div class="ld_pop_mcnt" style="display:none;">
					<div class="loader_pop">  
					  Please do not refresh the page while installation <br/>is being processed.
					  <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
					  <div style="clear: both"></div>    
				   </div>
				</div>
				<div id="container">
					<div id="content">
						<div class="title_logo">
							<a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
							<h3>SMTP Configuration</h3>
						</div>
						<table width="100%" align="center">
								<tr>
									<td align="center">
										<table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
											<tr>
												<td align="left">
													<form id="setup" method="post">
														<table>
													<tr>
														<td class="select_check_config">
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="1" checked="checked" class="radio_type_bx" /> 
                                SMTP
                              </span>
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="2" class="radio_type_bx" /> PHP Mailer
                              </span>
														</td>
													</tr>
															<tr>
																<td>Host:</td>
																<td><input type="text" name="Smtp[host]" placeholder="ssl://smtp.gmail.com" autofocus="1"  autocomplete="off" />
																<input type="hidden" name="Smtp[is_smtp]" value="0" id="is_smtp" />
																</td>
															</tr>
															<tr>
																<td>Port:</td>
																<td><input type="text" name="Smtp[port]" placeholder="25, 465 or 587"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>Username or Email Address:</td>
																<td><input type="text" name="Smtp[email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>Password:</td>
																<td><input type="password" name="Smtp[password]" placeholder="******"  autocomplete="off" /></td>
															</tr>
															
															<tr>
																<td>From Email:</td>
																<td><input type="text" name="Smtp[from_email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>Notify Email:</td>
																<td><input type="text" name="Smtp[notify_email]" placeholder="notify-email@gmail.com"  autocomplete="off" /></td>
															</tr>
															
															<tr>
																<td>&nbsp;</td>
																<td><input type="submit" value="Next"/></td>
															</tr>
															<?php /*<tr>
																<td  style="padding: 0 !important;"><label style="text-align: center;display: block;"><a href="?is_smtp=1" style="font-size: 13px;color:#333">Skip this step</a></label></td>
															</tr> */ ?>
														</table>
													</form>
												</td>
											</tr>
											<tr>
												<td align="center">
													<h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
					<script type="text/javascript">
						function skipSmtp(){
							$("#is_smtp").val(1);
							$('#setup').submit();
						}
					</script>
                    <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
                     <script type="text/javascript">
                        $(document).ready(function(){
                            $("#setup").validate({
                                rules: {               
                                    'Smtp[host]': {
                                        required: true,             
                                    },
                                    'Smtp[port]': {
                                        required: true,             
                                    },
                                    'Smtp[email]': {
                                        required: true,             
                                    },
                                    'Smtp[password]': {
                                        required: true,             
                                    },
									'Smtp[from_email]': {
										required: true,  
										email: true
									}
								},
								messages: {               
									'Smtp[host]': {
										required: "Please enter your smtp host name",
									},
									'Smtp[port]': {
										required: "Please enter your smtp port",
									},
									'Smtp[email]': {
										required: "Please enter your smtp username or email",
									},
									'Smtp[password]': {
										required: "Please enter your smtp password",
									},
									'Smtp[from_email]': {
										required: "Please enter your from email",
										email: "Please enter a valid email"
									}
								},
                                errorElement: "small",
                                errorPlacement: function(error, element) {
                                    error.insertAfter(element);
                                },
                                submitHandler: function(form) {
                                    $(".ld_pop_mcnt").show();
                                    form.submit();
                                }
                            });       
                        });
                    </script>
				</body>
			</html>				
        <?php exit;} else {
            $check_database_table_sql = "select count(*) as table_count from information_schema.tables where table_type = 'BASE TABLE' and table_schema ='".$database."'";
            $table_count_obj = $conn->query($check_database_table_sql);
            $table_count =  $table_count_obj->fetch_assoc();
            if(empty($table_count['table_count'])){
								$conn = @new mysqli($servername, $username, $password,$database);
                $database_sql = ROOT.DS."database.sql";
                $templine = '';
                $lines = file($database_sql);
                foreach ($lines as $line){
                    if (substr($line, 0, 2) == '--' || $line == ''){
                        continue;
										}
                    $templine .= $line;
                    if (substr(trim($line), -1, 1) == ';'){
                        $conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                        $templine = '';
                    }
                }
								sleep(5);
								header('Location:'.$actual_link);exit;//PRB
			?>
			<!DOCTYPE html>
			<html>
				<head>
					<meta name="robots" content="noindex,nofollow" />
					<link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
          <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
					<title>Orangescrum Setup Wizard</title>
				</head>
				<body>
         <div class="ld_pop_mcnt" style="display:none;">
            <div class="loader_pop">  
                Please do not refresh the page while installation <br/>is being processed.
                <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                <div style="clear: both"></div>    
             </div>
        </div>
					<div id="container">
						<div id="content">
               <div class="title_logo">
                <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                <h3>SMTP Configuration</h3>
              </div>
							<table width="100%" align="center">
								<tr>
									<td align="center">
										<table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
											<tr>
												<td align="left">
													<form id="setup" method="post">
														<table>
															<tr>
																<td class="select_check_config">
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="1" checked="checked" class="radio_type_bx" /> 
                                SMTP
                              </span>
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="2" class="radio_type_bx" /> PHP Mailer
                              </span>
														</td>
															</tr>
															<tr>
																<td>Host:</td>
																<td><input type="text" name="Smtp[host]" placeholder="ssl://smtp.gmail.com" autofocus="1" autocomplete="off"/>
																<input type="hidden" name="Smtp[is_smtp]" value="0" id="is_smtp" />
																</td>
															</tr>
															<tr>
																<td>Port:</td>
																<td><input type="text" name="Smtp[port]" placeholder="25, 465 or 587"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>Username or Email Address:</td>
																<td><input type="text" name="Smtp[email]" placeholder="youremail@gmail.com"  autocomplete="off"/></td>
															</tr>
															<tr>
																<td>Password:</td>
																<td><input type="password" name="Smtp[password]" placeholder="******"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>From Email:</td>
																<td><input type="text" name="Smtp[from_email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>Notify Email:</td>
																<td><input type="text" name="Smtp[notify_email]" placeholder="notify-email@gmail.com"  autocomplete="off" /></td>
															</tr>
															<tr>
																<td>&nbsp;</td>
																<td><input type="submit" value="Next"/></td>
															</tr>
															<?php /*<tr>
																<td  style="padding: 0 !important;"><label style="text-align: center;display: block;"><a href="?is_smtp=1" style="font-size: 13px;color:#333">Skip this step</a></label></td>
															</tr> */ ?>
														</table>
													</form>
												</td>
											</tr>
											
											<tr>
												<td align="center">
													<h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
					<script type="text/javascript">
						function skipSmtp(){
							$("#is_smtp").val(1);
							$('#setup').submit();
						}
					</script>
                    <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#setup").validate({
                                rules: {               
                                    'Smtp[host]': {
                                        required: true,             
                                    },
                                    'Smtp[port]': {
                                        required: true,             
                                    },
                                    'Smtp[email]': {
                                        required: true,             
                                    },
                                    'Smtp[password]': {
                                        required: true,             
                                    },
									'Smtp[from_email]': {
										required: true,             
									}
                                },
                                messages: {               
                                    'Smtp[host]': {
                                        required: "Please enter your smtp host name",
                                    },
                                    'Smtp[port]': {
                                        required: "Please enter your smtp port",
                                    },
                                    'Smtp[email]': {
                                        required: "Please enter your smtp username or email",
                                    },
                                    'Smtp[password]': {
                                        required: "Please enter your smtp password",
                                    },
									'Smtp[from_email]': {
										required: "Please enter your from email",
									}

                                },
                                errorElement: "small",
                                errorPlacement: function(error, element) {
                                    error.insertAfter(element);
                                },
                                submitHandler: function(form) {
                                    $(".ld_pop_mcnt").show();
                                    form.submit();
                                }
                            });       
                        });
                    </script>
				</body>
			</html>
		<?php exit;}else { sleep(10); header('Location:'.$actual_link);exit;//PRB ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta name="robots" content="noindex,nofollow" />
                    <link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
                    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
                    <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
                    <title>Orangescrum Setup Wizard</title>
                </head>
                <body>
                    <div class="ld_pop_mcnt" style="display:none;">
                        <div class="loader_pop">  
                            Please do not refresh the page while installation <br/>is being processed.
                            <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                            <div style="clear: both"></div>    
                         </div>
                    </div>
                    <div id="container">
                        <div id="content">
                          <div class="title_logo">
                              <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                              <h3>Database Configuration</h3>
                              <strong style="display: block;" class="config-error">Wrong database information. Please try with correct information.</strong>
                            </div>
                            <table width="100%" align="center">
                                <tr>
                                    <td align="center">
                                        <table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
                                            <tr>
                                                <td align="left">
                                                    <form id="setup" method="post">
                                                        <table>
                                                            <tr>
                                                                <td>Name:</td>
                                                                <td><input type="text" name="Database[database]" placeholder="Enter database name" autofocus="1" autocomplete="off"/></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td><input type="submit" value="Next"/></td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
                    <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#setup").validate({
                                rules: {               
                                    'Database[database]': {
                                        required: true,             
                                    }
                                },
                                messages: {               
                                    'Database[database]': {
                                        required: "Please enter your database name",
                                    }
                                },
                                errorElement: "small",
                                errorPlacement: function(error, element) {
                                    error.insertAfter(element);
                                },
                                submitHandler: function(form) {
                                    $(".ld_pop_mcnt").show();
                                    form.submit();
                                }
                            });       
                        });
                    </script> 
                </body>
            </html>
<?php exit;
			} 
			$conn->close();
		}
    }else if(!empty($_POST['Smtp'])){
		//echo $_POST['Smtp']['is_smtp'];exit;
        $smtp_post = $_POST['Smtp'];
        $SMTP_HOST = !empty($smtp_post['host']) ? $smtp_post['host'] : 'ssl://smtp.gmail.com';
        $SMTP_PORT = !empty($smtp_post['port']) ? $smtp_post['port'] : '465';
        $SMTP_UNAME = !empty($smtp_post['email']) ? $smtp_post['email'] : 'youremail@gmail.com';
        $SMTP_PWORD = !empty($smtp_post['password']) ? $smtp_post['password'] : '******';
        $FROM_EMAIL = !empty($smtp_post['from_email']) ? $smtp_post['from_email'] : "";
		if(!empty($smtp_post['notify_email'])){
			$NOTIFY_EMAIL = !empty($smtp_post['notify_email']) ? $smtp_post['notify_email'] : "";
		}else if($FROM_EMAIL != ''){
			$NOTIFY_EMAIL = $FROM_EMAIL;
		}else{
			$NOTIFY_EMAIL = !empty($smtp_post['notify_email']) ? $smtp_post['notify_email'] : "";
		}        
        //$IS_SMTP = !empty($smtp_post['is_smtp']) ? $smtp_post['is_smtp'] : '0';
        $IS_SMTP = (isset($smtp_post['smpt_mail_type']) && trim($smtp_post['smpt_mail_type']) ==1)?1:0; //as we put validations in fronmt end
		
        $constants_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php';
        $tmp_constants_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.tmp.php';
        $file = fopen($constants_filename, "a+");
        $writing = fopen($tmp_constants_filename, 'w');
        $size = filesize($constants_filename);
        while (!feof($file)) {
            $line = fgets($file);
            $endline ="\n";
            if (stristr($line, 'define("SMTP_HOST", "ssl://smtp.gmail.com");') && !empty($SMTP_HOST)) {
               $stmp_host = '"'.$SMTP_HOST.'"';
               $line = 'define("SMTP_HOST", '.$stmp_host.');'.$endline;
            } elseif (stristr($line, 'define("SMTP_PORT", "465");') && !empty($SMTP_PORT)) {
               $stmp_host = '"'.$SMTP_PORT.'"';
               $line = 'define("SMTP_PORT", '.$stmp_host.');'.$endline;
            } elseif (stristr($line, 'define("SMTP_UNAME", "youremail@gmail.com");') && !empty($SMTP_UNAME)) {
                $stmp_uname = '"'.$SMTP_UNAME.'"';
                $line = 'define("SMTP_UNAME", '.$stmp_uname.');'.$endline;
            } elseif (stristr($line, 'define("SMTP_PWORD", "******");') && !empty($SMTP_UNAME)) {
				$stmp_pword = '"'.$SMTP_PWORD.'"';
				$line = 'define("SMTP_PWORD", '.$stmp_pword.');'.$endline;
            }
			elseif (stristr($line, 'define("SUPPORT_EMAIL", "");') && !empty($FROM_EMAIL)) {
				//$FROM_EMAIL = '"'.$FROM_EMAIL.'"';
				$line = 'define("SUPPORT_EMAIL", "'.$FROM_EMAIL.'");'.$endline;
            } elseif (stristr($line, 'define("FROM_EMAIL", "");') && !empty($NOTIFY_EMAIL)) {
				//$FROM_EMAIL = '"'.$FROM_EMAIL.'"';
				$line = 'define("FROM_EMAIL", "'.$FROM_EMAIL.'");'.$endline;
            } elseif (stristr($line, 'define("FROM_EMAIL_EC", "");') && !empty($NOTIFY_EMAIL)) {
				$NOTIFY_EMAIL = '"'.$NOTIFY_EMAIL.'"';
				$line = 'define("FROM_EMAIL_EC", '.$NOTIFY_EMAIL.');'.$endline;
            }
			if(!empty($_POST['Smtp']['is_smtp']) && (stristr($line, 'define("IS_SMTP", 0);') || stristr($line, 'define("IS_SMTP", 1);')) && !empty($IS_SMTP)){
				$is_smtp = $IS_SMTP;
				$line = 'define("IS_SMTP", '.$is_smtp.');'.$endline;
			}			
			if(isset($smtp_post['smpt_mail_type']) && trim($smtp_post['smpt_mail_type']) ==2){
				if(stristr($line, 'define("PHPMAILER", 0);') || stristr($line, 'define("PHPMAILER", 1);')){
					$line = 'define("PHPMAILER", 1);'.$endline;
				}
			}else if(isset($smtp_post['smpt_mail_type']) && trim($smtp_post['smpt_mail_type']) ==1){
				if(stristr($line, 'define("PHPMAILER", 0);') || stristr($line, 'define("PHPMAILER", 1);')){
					$line = 'define("PHPMAILER", 0);'.$endline;
				}
			}			
            fputs($writing, $line);
            //flush();
            //ob_flush();
        }
		if(isset($smtp_post['smpt_mail_type']) && trim($smtp_post['smpt_mail_type']) ==2){
			$conn_i = @new mysqli($settings['host'], $settings['login'], $settings['password'],$settings['database']);
			if (!empty($conn_i->connect_error)) {
			}else{
				$smtp_val = 1;
				if(empty($SMTP_UNAME) || empty($SMTP_PWORD)){
					$smtp_val = 3;
				}			
				$check_database_table_sql_i = "update email_settings set host='".$SMTP_HOST."', port='".$SMTP_PORT."',email='".$SMTP_UNAME."',password='".$SMTP_PWORD."',from_email='".$FROM_EMAIL."',reply_email='".$NOTIFY_EMAIL."',is_smtp=".$smtp_val." where id=1";
				$table_count_obj = $conn_i->query($check_database_table_sql_i);
			}
			$conn_i->close();
		}
        fclose($file);
        fclose($writing);
        unlink($constants_filename);
        rename($tmp_constants_filename, $constants_filename);
        checkDebug();
		$smtp_flag =0;
    }else if(!empty($_POST['VerifyEmail'])){
		//verify emails
    }else if(!empty($_POST['Others'])){
        $others = $_POST['Others'];
        $client_id = !empty($others['client_id']) ? $others['client_id'] : 'XXXXXXXXXXXX.apps.googleusercontent.com';
        $client_secret = !empty($others['client_secret']) ? $others['client_secret'] : 'xXxXXxxxx_xXxXXxxxx';
        $api_key = !empty($others['api_key']) ? $others['api_key'] : 'xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx';
		
        $db_key = !empty($others['db_key']) ? $others['db_key'] : 'xXxxXxxxXx';
		
        $bkt_name = !empty($others['bkt_name']) ? $others['bkt_name'] : 'Bucket Name';
        $aws_key = !empty($others['aws_key']) ? $others['aws_key'] : 'XXXXXXXXXXXXXX';
        $aws_secret = !empty($others['aws_secret']) ? $others['aws_secret'] : 'XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX';
		
        $constants_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php';
        $tmp_constants_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.tmp.php';
        $file = fopen($constants_filename, "a+");
        $writing = fopen($tmp_constants_filename, 'w');
        $size = filesize($constants_filename);
        while (!feof($file)) {
            $line = fgets($file);
            $endline ="\n";			
			if (stristr($line, 'define("CLIENT_ID", "XXXXXXXXXXXX.apps.googleusercontent.com");') && !empty($client_id)) {
               //$client_id = '"'.$client_id.'"';
               $line = 'define("CLIENT_ID", "'.$client_id.'");'.$endline;
            } elseif (stristr($line, 'define("CLIENT_SECRET", "xXxXXxxxx_xXxXXxxxx");') && !empty($client_secret)) {
               //$client_secret = '"'.$client_secret.'"';
               $line = 'define("CLIENT_SECRET", "'.$client_secret.'");'.$endline;
            } elseif (stristr($line, 'define("API_KEY", "xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx");') && !empty($api_key)) {
                //$api_key = '"'.$api_key.'"';
                $line = 'define("API_KEY", "'.$api_key.'");'.$endline;
            } elseif (stristr($line, 'define("USE_GOOGLE", 0);') && $client_id != 'XXXXXXXXXXXX.apps.googleusercontent.com' && $client_secret!= 'xXxXXxxxx_xXxXXxxxx' && $api_key != 'xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx') {
                $line = 'define("USE_GOOGLE", 1);'.$endline;
            }
			//dropbox
			if (stristr($line, 'define("DROPBOX_KEY", "xXxxXxxxXx");') && !empty($db_key)) {
               //$db_key = '"'.$db_key.'"';
               $line = 'define("DROPBOX_KEY", "'.$db_key.'");'.$endline;
            } elseif (stristr($line, 'define("USE_DROPBOX", 0);') && $db_key != 'xXxxXxxxXx') {
               $line = 'define("USE_DROPBOX", 1);'.$endline;
            }
			//Aws s3
			if (stristr($line, 'define("BUCKET_NAME", "Bucket Name");') && !empty($api_key)) {
                $bkt_name = '"'.$bkt_name.'"';
                $line = 'define("BUCKET_NAME", '.$bkt_name.');'.$endline;
            } elseif (stristr($line, 'define("awsAccessKey", "XXXXXXXXXXXXXX");') && !empty($aws_key)) {
				$aws_key = '"'.$aws_key.'"';
                $line = 'define("awsAccessKey", '.$aws_key.');'.$endline;
            } elseif (stristr($line, 'ddefine("awsSecretKey", "XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX");')) {
				$aws_secret = '"'.$aws_secret.'"';
                $line = 'define("awsSecretKey", '.$aws_secret.');'.$endline;
            } elseif (stristr($line, 'define("USE_S3", 0);') && $bkt_name != 'Bucket Name' && $aws_secret != 'XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX' && $aws_key != 'XXXXXXXXXXXXXX') {
                $line = 'define("USE_S3", 1);'.$endline;
            }	
			if ((stristr($line, 'define("IS_OTHERS", 0);') || stristr($line, 'define("IS_OTHERS", 1);'))) {
			   $line = 'define("IS_OTHERS", 1);'.$endline;
			}
            fputs($writing, $line);
            //flush();
            //ob_flush();
        }
        fclose($file);
        fclose($writing);
        unlink($constants_filename);
        rename($tmp_constants_filename, $constants_filename);
        //checkDebug();
		//$smtp_flag =0;
		sleep(4);
		header('Location:'.$actual_link);exit;
    }
}
if (trim($settings['database']) != "" && $database_flag ==2) {
    $database_sql = ROOT.DS."database.sql";
    $templine = '';
    $lines = file($database_sql);
    foreach ($lines as $line){
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        $templine .= $line;
        if (substr(trim($line), -1, 1) == ';'){
            // echo $templine ; 
            $conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
            $templine = '';
        }
    } 
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta name="robots" content="noindex,nofollow" />
            <link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
            <title>Orangescrum Setup Wizard</title>
        </head>
        <body>
             <div class="ld_pop_mcnt" style="display:none;">
                <div class="loader_pop">  
                    Please do not refresh the page while installation <br/>is being processed.
                    <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                    <div style="clear: both"></div>    
                 </div>
            </div>
            <div id="container">
                <div id="content">
                  <div class="title_logo">
                    <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                    <h3>SMTP Configuration</h3>
                  </div>
                    <table width="100%" align="center">
                        <tr>
                            <td align="center">
                                <table cellpadding="8" cellspacing="8" align="center"  class="cmn_step_layout">
                                    <tr>
                                        <td align="left">
                                            <form id="setup" method="post">
                                                <table>
													<tr>
														<td class="select_check_config">
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="1" checked="checked" class="radio_type_bx" /> 
                                SMTP
                              </span>
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="2" class="radio_type_bx" /> PHP Mailer
                              </span>
														</td>
													</tr>
                                                    <tr>
                                                        <td>Host:</td>
                                                        <td><input type="text" name="Smtp[host]" placeholder="ssl://smtp.gmail.com" autofocus="1" autocomplete="off"/>
														<input type="hidden" name="Smtp[is_smtp]" value="0" id="is_smtp" autocomplete="off" />
														</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Port:</td>
                                                        <td><input type="text" name="Smtp[port]" placeholder="25, 465 or 587" autocomplete="off"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Username or Email Address:</td>
                                                        <td><input type="text" name="Smtp[email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Password:</td>
                                                        <td><input type="password" name="Smtp[password]" placeholder="******"  autocomplete="off" /></td>
                                                    </tr>
													<tr>
														<td>From Email:</td>
														<td><input type="text" name="Smtp[from_email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
													</tr>
													<tr>
														<td>Notify Email:</td>
														<td><input type="text" name="Smtp[notify_email]" placeholder="notify-email@gmail.com"  autocomplete="off" /></td>
													</tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit" value="Next"/></td>
                                                    </tr>
													<?php /*<tr>
                                                    <td  style="padding: 0 !important;"><label style="text-align: center;display: block;"><a href="?is_smtp=1" style="font-size: 13px;color:#333">Skip this step</a></label></td>
                                                    </tr> */ ?>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
			<script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
			<script type="text/javascript">
				function skipSmtp(){
					$("#is_smtp").val(1);
					$('#setup').submit();
				}
			</script>
            <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
             <script type="text/javascript">
                $(document).ready(function(){
                    $("#setup").validate({
                        rules: {               
                            'Smtp[host]': {
                                required: true,             
                            },
                            'Smtp[port]': {
                                required: true,             
                            },
                            'Smtp[email]': {
                                required: true,             
                            },
                            'Smtp[password]': {
                                required: true,             
                            },
                            'Smtp[from_email]': {
                                required: true,  
								email: true
                            }
                        },
                        messages: {               
                            'Smtp[host]': {
                                required: "Please enter your smtp host name",
                            },
                            'Smtp[port]': {
                                required: "Please enter your smtp port",
                            },
                            'Smtp[email]': {
                                required: "Please enter your smtp username or email",
                            },
                            'Smtp[password]': {
                                required: "Please enter your smtp password",
                            },
                            'Smtp[from_email]': {
                                required: "Please enter your from email",
								email: "Please enter a valid email"
                            }

                        },
                        errorElement: "small",
                        errorPlacement: function(error, element) {
                            error.insertAfter(element);
                        },
                        submitHandler: function(form) {
                            $(".ld_pop_mcnt").show();
                            form.submit();
                        }
                    });       
                });
            </script>
        </body>
    </html>
<?php
exit;
} else if (trim($settings['database']) == "" || $database_flag ==0) { ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex,nofollow" />
        <link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
        <title>Orangescrum Setup Wizard</title>
    </head>
    <body>
         <div class="ld_pop_mcnt" style="display:none;">
            <div class="loader_pop">  
                Please do not refresh the page while installation <br/>is being processed.
                <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                <div style="clear: both"></div>    
             </div>
        </div>
        <div id="container">
            <div id="content">
              <div class="title_logo">
              <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                    <h3>Database Configuration</h3>
                  </div>
                <table width="100%" align="center">
                    <tr>
                        <td align="center">
                        <table cellpadding="8" cellspacing="8" align="center"  class="cmn_step_layout">
                                <tr>
                                <td align="left">
                                        <form id="setup" method="post">
                                            <table>
                                                <tr>
                                                    <td>Name:</td>
                                                    <td><input type="text" name="Database[database]" placeholder="Enter database name" autofocus="1"  autocomplete="off" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Host:</td>
                                                    <td><input type="text" name="Database[host]" placeholder="Enter database host"  autocomplete="off" />
													<small style="color:green;display: block;margin-left: 8px;margin-top: 5px;font-size: 12px;">Note: localhost or IP Address(192.168.2.54) or RDS end point</small>
													</td>
                                                </tr>
                                                <tr>
                                                    <td>Username:</td>
                                                    <td><input type="text" name="Database[user]" placeholder="Enter database username"  autocomplete="off" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Password:</td>
                                                    <td><input type="password" name="Database[pass]" placeholder="Enter database password" autocomplete="off"/></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><input type="submit" value="Next"/></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td align="center">
                                    <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
        <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#setup").validate({
                    rules: {               
                        'Database[database]': {
                            required: true,             
                        },
                        'Database[host]': {
                            required: true,             
                        },
                        'Database[user]': {
                            required: true,             
                        }
                    },
                    messages: {               
                        'Database[database]': {
                            required: "Please enter your database name",
                        },
                        'Database[host]': {
                            required: "Please enter your database host",
                        },
                        'Database[user]': {
                            required: "Please enter your database user name",
                        }
                    },
                    errorElement: "small",
                    errorPlacement: function(error, element) {
                        error.insertAfter(element);
                    },
                    submitHandler: function(form) {
                      $(".ld_pop_mcnt").show();
                        form.submit();
                    }
                });       
            });
        </script> 
    </body>
</html>
<?php
exit;
}else if($smtp_flag==1 && IS_SMTP==0){ ?>
	<!DOCTYPE html>
    <html>
        <head>
            <meta name="robots" content="noindex,nofollow" />
            <link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
            <title>Orangescrum Setup Wizard</title>
        </head>
        <body>
			 <div class="ld_pop_mcnt" style="display:none;">
                <div class="loader_pop">  
                    Please do not refresh the page while installation <br/>is being processed.
                    <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                    <div style="clear: both"></div>    
                 </div>
            </div>
            <div id="container">
                <div id="content">
                   <div class="title_logo">
                    <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                    <h3>SMTP Configuration</h3>
                  </div>
                    <table width="100%" align="center">
                        <tr>
                            <td align="center">
                          <table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
                                    <tr>
                                        <td align="left">
                                            <form id="setup" method="post">
                                                <table>
													<tr>
														<td class="select_check_config">
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="1" checked="checked" class="radio_type_bx" /> 
                                SMTP
                              </span>
                              <span>
                                <input type="radio" name="Smtp[smpt_mail_type]" value="2" class="radio_type_bx" /> PHP Mailer
                              </span>
														</td>
													</tr>
                                                    <tr>
                            <td class="p_0">
                              <div class="dual_fld_tbl">
                                <table>
                                  <tr>
                                                        <td>Host:</td>
                                                        <td><input type="text" name="Smtp[host]" placeholder="ssl://smtp.gmail.com" autofocus="1" autocomplete="off" />
														<input type="hidden" name="Smtp[is_smtp]" value="0" id="is_smtp" />
														</td>
                                                    </tr>
                                </table>
                              </div>
                              <div class="dual_fld_tbl">
                                <table>
                                                    <tr>
                                                        <td>Port:</td>
                                                        <td><input type="text" name="Smtp[port]" placeholder="25, 465 or 587" autocomplete="off" /></td>
                                                    </tr>
                                </table>
                              </div>
                              <div class="cb"></div>
                            </td>
                          </tr>
                                                    <tr>
                                                        <td>Username or Email Address:</td>
                                                        <td><input type="text" name="Smtp[email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Password:</td>
                                                        <td><input type="password" name="Smtp[password]" placeholder="******" autocomplete="off" /></td>
                                                    </tr>
													<tr>
														<td>From Email:</td>
														<td><input type="text" name="Smtp[from_email]" placeholder="youremail@gmail.com"  autocomplete="off" /></td>
													</tr>
													<tr>
														<td>Notify Email:</td>
														<td><input type="text" name="Smtp[notify_email]" placeholder="notify-email@gmail.com"  autocomplete="off" /></td>
													</tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit" value="Next"/></td>
                                                    </tr>
													<?php /*<tr>
                                                    <td  style="padding: 0 !important;"><label style="text-align: center;display: block;"><a href="?is_smtp=1" style="font-size: 13px;color:#333">Skip this step</a></label></td>
                                                    </tr> */ ?>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
			<script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
			<script type="text/javascript">
				function skipSmtp(){
					$("#is_smtp").val(1);
					$('#setup').submit();
				}
			</script>
            <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
            <script type="text/javascript">	
                $(document).ready(function(){
                    $("#setup").validate({
                        rules: {               
                            'Smtp[host]': {
                                required: true,             
                            },
                            'Smtp[port]': {
                                required: true,             
                            },
                            'Smtp[email]': {
                                required: true,             
                            },
                            'Smtp[password]': {
                                required: true,             
                            },
                            'Smtp[from_email]': {
                                required: true,  
								email: true
                            }
                        },
                        messages: {               
                            'Smtp[host]': {
                                required: "Please enter your smtp host name",
                            },
                            'Smtp[port]': {
                                required: "Please enter your smtp port",
                            },
                            'Smtp[email]': {
                                required: "Please enter your smtp username or email",
                            },
                            'Smtp[password]': {
                                required: "Please enter your smtp password",
                            },
                            'Smtp[from_email]': {
                                required: "Please enter your from email",
								email: "Please enter a valid email"
                            }

                        },
                        errorElement: "small",
                        errorPlacement: function(error, element) {
                            error.insertAfter(element);
                        },
                        submitHandler: function(form) {
                            $(".ld_pop_mcnt").show();
                            form.submit();
                        }
                    });       
                });
            </script> 
        </body>
    </html>
<?php
exit;
} else if(IS_EML_VERIFY==0 && 0){
//for email verification
exit;
} else if(IS_OTHERS==0){ ?>
<!DOCTYPE html>
    <html>
        <head>
            <meta name="robots" content="noindex,nofollow" />
            <link rel="shortcut icon" href="https://www.orangescrum.com/favicon.ico"/>
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="<?php echo $actual_link; ?>css/setup.css"/>
            <title>Orangescrum Setup Wizard</title>
        </head>
        <body>
			 <div class="ld_pop_mcnt" style="display:none;">
                <div class="loader_pop">  
                    Please do not refresh the page while installation <br/>is being processed.
                    <div class="lds-ellipsis" ><div></div><div></div><div></div><div></div></div>
                    <div style="clear: both"></div>    
                 </div>
            </div>
            <div id="container">
                <div id="content">
                   <div class="title_logo">
                    <a href="https://www.orangescrum.com/"><img src="<?php echo $actual_link; ?>img/header/orangescrum-logo.svg" border="0" alt="Orangescrum.com" title="Orangescrum.com"></a>
                    <h3>Advanced Configuration</h3>
                  </div>
                    <table width="100%" align="center">
                        <tr>
                            <td align="center">
                            <table cellpadding="8" cellspacing="8" align="center" class="cmn_step_layout">
									<tr>
                                <td>
                                  <table style="width:100%">
                                    <tr>
                                      <td align="left" class="accordion">
                                            <form id="setup" method="post">
                                          <p class="accordion-toggle open_ggl_key">Google Keys</p>
                                          <table class="accordion-content">
												<tr>
                                                <td>API KEY</td>
                                                        <td><input type="text" name="Others[api_key]" placeholder="xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx"  autocomplete="off" /></td>
                                                    </tr>
												<tr>
                                                <td>CLIENT ID</td>
                                                        <td><input type="text" name="Others[client_id]" placeholder="XXXXXXXXXXXX.apps.googleusercontent.com" autofocus="1" autocomplete="off" />
														<input type="hidden" name="Others[is_others]" value="0" id="is_others" />
														</td>
                                                    </tr>
                                                    <tr>
                                                <td>CLIENT SECRET</td>
                                                        <td><input type="text" name="Others[client_secret]" placeholder="xXxXXxxxx_xXxXXxxxx" autocomplete="off" /></td>
                                                    </tr>
                                          </table>
                                          <p class="accordion-toggle">Dropbox</p>
                                          <table class="accordion-content">
                                                    <tr>
                                                <td>API KEY</td>
                                                        <td><input type="text" name="Others[db_key]" placeholder="xXxxXxxxXx" autocomplete="off" /></td>
                                                    </tr>
                                          </table>
                                          <p class="accordion-toggle">AWS S3 Bucket</p>
                                          <table class="accordion-content">
													<tr>
                                              <td>BUCKET NAME</td>
														<td><input type="text" name="Others[bkt_name]" placeholder="Bucket Name"  autocomplete="off" /></td>
													</tr>
													<tr>
														<td>AWS Access Key</td>
														<td><input type="text" name="Others[aws_key]" placeholder="XXXXXXXXXXXXXX"  autocomplete="off" /></td>
													</tr>
													<tr>
                                              <td>AWS Secret Key</td>
														<td><input type="text" name="Others[aws_secret]" placeholder="XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX"  autocomplete="off" /></td>
													</tr>
                                          </table>
                                          <table>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit" value="Finish"/></td>
                                                    </tr>
													<tr>
                                                    <td  style="padding: 0 !important;"><label style="text-align: center;display: block;"><a href="?is_others=1" style="font-size: 13px;color:#333">Skip this step</a></label></td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                                    <tr>
                                        <td align="center">
                                            <h5>Make sure that you have write permission (777) to `app/tmp` and `app/webroot` folders</h5>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
			<script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery-1.7.2.min.js"></script> 
			<script type="text/javascript">
				function skipSmtp(){
					$("#is_others").val(1);
					$('#setup').submit();
				}
				$('.accordion').find('.accordion-toggle').click(function(){
				  //Expand or collapse this panel
				  $(this).next().slideToggle('fast');
				  //Hide the other panels
				  $(this).hasClass('active')?$(this).removeClass('active'):$(this).addClass('active');
				});
			</script>
            <script type="text/javascript" src="<?php echo $actual_link; ?>js/jquery.validate.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
					$('.open_ggl_key').trigger('click');
                    /*$("#setup").validate({
                        rules: {               
                            'Others[host]': {
                                required: true,             
                            },
                            'Others[port]': {
                                required: true,             
                            },
                            'Others[email]': {
                                required: true,             
                            },
                            'Others[password]': {
                                required: true,             
                            },
                            'Others[from_email]': {
                                required: true,  
								email: true
                            }
                        },
                        messages: {               
                            'Others[host]': {
                                required: "Please enter your smtp host name",
                            },
                            'Others[port]': {
                                required: "Please enter your smtp port",
                            },
                            'Others[email]': {
                                required: "Please enter your smtp username or email",
                            },
                            'Others[password]': {
                                required: "Please enter your smtp password",
                            },
                            'Others[from_email]': {
                                required: "Please enter your from email",
								email: "Please enter a valid email"
                            }

                        },
                        errorElement: "small",
                        errorPlacement: function(error, element) {
                            error.insertAfter(element);
                        },
                        submitHandler: function(form) {
                            $(".ld_pop_mcnt").show();
                            form.submit();
                        }
                    });*/       
                });
            </script> 
        </body>
    </html>
<?php
exit;
}
function check_subfolder() {
    include_once("constants.php");
    include_once(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Utility' . DS . 'File.php');
    include_once(CAKE_CORE_INCLUDE_PATH . DS . 'Cake' . DS . 'Utility' . DS . 'Folder.php');
    $root = dirname(dirname(dirname(__FILE__)));
    $config_dir = $root . DS . 'app' . DS . 'Config' . DS;
    $folders = explode(DS, $root);
    $sub_folder = $folders[count($folders) - 1] . '/';
    $vhosted_folders = explode('/', $_SERVER['DOCUMENT_ROOT']);
    $vhosted_folder = $vhosted_folders[count($vhosted_folders) - 1] == '' ? $vhosted_folders[count($vhosted_folders) - 2] . '/' : $vhosted_folders[count($vhosted_folders) - 1] . '/';
    if ($vhosted_folders[count($vhosted_folders) - 1] == '' && $vhosted_folder == $sub_folder) {
        $sub_folder = '';
    } else if ($vhosted_folders[count($vhosted_folders) - 1] != '' && $vhosted_folder == $sub_folder) {
        $sub_folder = '/';
    }
    if ($sub_folder != SUB_FOLDER) {
        $path = $root . DS . 'app' . DS . 'Config' . DS . 'constants.php';
        $tmppath = $root . DS . 'app' . DS . 'Config' . DS . 'constants_tmp.php';
        $File = new File($path, true, 0777);
        $tmpfile = new File($tmppath, true, 0777);
        $originalContent = $File->read();
        $replacement = "$sub_folder";
        $newContent = str_replace('@SUB_FOLDER', $replacement, $originalContent);
        //extra added
        $newContent = str_replace(SUB_FOLDER, $sub_folder, $newContent);
        $tmpfile->write($newContent);
        if ($tmpfile->copy($path, true)) {
            $tmpfile->delete();
            $File->close();
        }
    }
}
function checkDebug() {
    $core_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core.php';
	$tmp_core_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'core.tmp.php';
	$file = fopen($core_filename, "a+");
	$writing = fopen($tmp_core_filename, 'w');
	$size = filesize($core_filename);
	while (!feof($file)) {
		$line = fgets($file);
		$endline ="\n";
		if (stristr($line, "Configure::write('debug',2);")) {
		   $line = "Configure::write('debug',0);".$endline;
		} 
		fputs($writing, $line);
	}
	fclose($file);
	fclose($writing);
	unlink($core_filename);
	rename($tmp_core_filename, $core_filename);
	//return true;
}
function checkSkipSmtp($type='smtp') {
    $core_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php';
    $tmp_core_filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.tmp.php';
    $file = fopen($core_filename, "a+");
    $writing = fopen($tmp_core_filename, 'w');
    $size = filesize($core_filename);
    while (!feof($file)) {
        $line = fgets($file);
        $endline ="\n";
		if($type == 'smtp'){
			if ((stristr($line, 'define("IS_SMTP", "0");') || stristr($line, 'define("IS_SMTP", "1");'))) {
			   $line = 'define("IS_SMTP", "1");'.$endline;
			}
		}else if($type == 'emailv'){
			if ((stristr($line, 'define("IS_EML_VERIFY", 0);') || stristr($line, 'define("IS_EML_VERIFY", 1);'))) {
			   $line = 'define("IS_EML_VERIFY", 1);'.$endline;
			}
		}else if($type == 'other'){
			if ((stristr($line, 'define("IS_OTHERS", 0);') || stristr($line, 'define("IS_OTHERS", 1);'))) {
			   $line = 'define("IS_OTHERS", 1);'.$endline;
			}
		} 
        fputs($writing, $line);
    }
    fclose($file);
    fclose($writing);
    unlink($core_filename);
    rename($tmp_core_filename, $core_filename);
    //return true;
}