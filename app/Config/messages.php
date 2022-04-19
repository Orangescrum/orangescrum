<?php
define("LOGIN_ERROR","Email or Password is invalid.");
define("SIGNUP_SUCC","Login to access your account.");
define("RESET_REQUEST","Please check your mail to reset your password");
define("PASS_CHANGED","Please check your mail to get your new password");

$emailHeader = "";
define('EMAIL_HEADER', $emailHeader);
$emailFooter = "<tr>
                    <td align='left' style='font:11px Verdana;color:#848484;padding-top:20px;'>
                        <div style='line-height:20px;padding-top:10px;padding-bottom:5px;font-size:14px;'>
                            Regards,<br/>
                            The Orangescrum Team
                       </div>
                        <br/>
                        If you have any questions, please write to us at <a href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a>, we will be happy to help.
                        <br/>
                        (This message comes from an unmonitored alias. Please do not reply directly.)
                        <br/>

                        <div style='font-size:11px;color:#5A5A5A;font-family:verdana;padding-top:12px;'>
                            This message is distributed by Andolasoft, San Jose, CA, 95124.
                        </div>
                    </td>
		</tr>
		<tr>
                    <td align='left' style='padding:5px 0px'>
                        <hr style='border: none; height: 0.1em; color:#DBDBDB;background:#DBDBDB;'/>
                    </td>
		</tr>
		<tr>
                    <td align='left' style='font:9px Verdana;padding-top:2px;color:#737373'>
                        You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please email with subject 'Unsubscribe' to <a href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a>
                    </td>
		</tr>
		";
define('EMAIL_FOOTER', $emailFooter);


$newEmailHeader = '<table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td width="100%" bgcolor="#ffffff" style="text-align:center;padding-top:10px;"><a href="http://www.orangescrum.com/"><img src="'.HTTP_ROOT.'img/transparent_logo1.png" alt="Orangescrum" title="Orangescrum" style="display:inline-block; width:50px; height:50px;border-bottom-right-radius:8px;border-bottom-left-radius:8px;" border="0"></a>
                            </td>
                        </tr>
                    </table>';
define('NEW_EMAIL_HEADER', $newEmailHeader);


$year = gmdate('Y');
$newEmailFooter = 'Copyright ' . $year . ' Orangescrum. All Rights Reserved.<br>
                    2059 Camden Ave. #118, San Jose, CA 95124, USA
                    <br><br>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://blog.orangescrum.com/">Blog</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/how-it-works">How it Works</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/help">Help</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/aboutus">About Us</a>

                    <br><br>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="https://twitter.com/theorangescrum"><img src="'.HTTP_ROOT.'img/tw.png" alt="Twitter" style="width:32px;height:32px"></a>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="https://www.facebook.com/pages/Orangescrum/170831796411793"><img src="'.HTTP_ROOT.'img/fb.png" alt="Facebook" style="width:32px;height:32px"></a>

                    <br><br>';
define('NEW_EMAIL_FOOTER', $newEmailFooter);

//core emails replaced.
$config = array();
Configure::write('common_footer',"<tr>
                                        <td align='left' style='padding:5px 0px'>
                                                <hr style='border: none; height: 0.1em; color:#DBDBDB;background:#DBDBDB;'/>
                                        </td>
                                </tr>
                                <tr>
                                        <td align='left' style='font:9px Verdana;padding-top:2px;color:#737373'>
                                                You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please forward this Email to <a href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a> with message 'Unsubscribe'.
                                        </td>
                                </tr>");
Configure::write('formal_header','<table style="font-family:Arial;font-size:14px;margin:0 auto 13px;background-color:#F3F3F3;border-bottom-left-radius:8px;border-bottom-right-radius:8px;width:96%;"><tbody><tr style="background-color:#F3F3F3">
<td style="text-align:left;padding-top:0px"><a target="_blank" style="font:bold 22px verdana;color:#e85d12" href="https://www.orangescrum.com/"><img border="0" alt="Orangescrum" title="Orangescrum" src="'.HTTP_ROOT.'img/images/logo_outer.png">
</a><div style="color:#000000;font-size: 14px;line-height: 16px;margin-top:5px;font-style: italic ;">Project collaboration made simple</div></td>
<td></td></tr></tbody></table>');
Configure::write('formal_footer',"<table cellpadding='0' cellspacing='0' align='left' width='100%'>	<tr><td align='left' style='font-size:11px;padding-top:5px;padding-left:21px;color:#737373' colspan='2'>
					This message is distributed by Andolasoft, San Jose, CA, 95124.	</td></tr><tr><td align='left' style='font-size:10px;padding-top:2px;padding-left:21px;color:#737373'>You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please forward this Email to <a href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a> with message 'Unsubscribe'.
					</td></tr></table>");
					
Configure::write('invite_user_footer',"<table cellpadding='0' cellspacing='0' align='left' width='100%'><tr><td align='left' style='font-size:14px;padding-top:5px;color:#737373' colspan='2'>If you have any questions, please write us at <a href='mailto:".SUPPORT_EMAIL."'>".SUPPORT_EMAIL."</a>, we will be happy to help you.</td></tr></table>");

Configure::write('free_signup_footer',"<table cellpadding='0' cellspacing='0' align='left' width='100%'><tr><td align='left' style='font-size:14px;padding-top:5px;color:#737373;font-size:12px;' colspan='2'>Your email address is used to create an account on Orangescrum. If you didn't intend to do this, just ignore this email; no account has been created yet</td></tr></table>");

Configure::write('enterprise_inquiry_subject','Thank You for Contacting Us!');
Configure::write('cancel_subscription_subject','Your subscription has been canceled on Orangescrum');
Configure::write('delete_account',"We're sorry to see you go");
Configure::write('forgot_password',"Forgot Password Request on Orangescrum");
Configure::write('marketing_from',"Orangescrum Support <".SUPPORT_EMAIL.">");

##*** Default template after signed up by a company starts. ***##
Configure::write(
    'default_template',
    array(
        array('name'=>'Bug',
		'description'=>'<b>Browser version:</b>
			<br/>
			<b>OS version:</b>
			<br/><br/>
			<b>Url:</b>
			<br/><br/>
			<b>What is the test case:</b><br/>
			<b>What is the expected result:</b><br/>
			<b>What is the actual result:</b><br/><br/>

			<b>Is it happening all the time or intermittently:</b><br/>
			<br/>
			<b>Attach screenshots:</b>'
	    ),
	    array('name'=>'Change Request',
		'description'=>"<p><strong>Change Requested:</strong></p>
		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>
		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 125</strong></p>
		<p><strong>Today's accomplishment:</strong></p>
		<p><strong>&nbsp; &nbsp; &nbsp; Task no: 120</strong></p>
		<ul>
		<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>
		<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>
		<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>
		</ul>
		<p>&nbsp; &nbsp; &nbsp;<strong>Task no: 125</strong></p>
		<ul>
		<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>
		<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>
		<li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>
		</ul>
		<p><br /> <strong>List of files changed:</strong></p>
		<ol>
		<li>index.html</li>
		<li>style.css</li>
		<li>contact-us.html</li>
		</ol>
		<p>Is code checked in Repository: <strong>Y/N</strong><br /> Is code available in Stager: <strong>Y/N</strong> </p>
		<p><strong>Blocker/Testing Issues:</strong></p>
		<p><strong>Task Group Update: &lt; Specify Task Group name here &gt;</strong></p>
		<p>&nbsp; &nbsp;1. Total tasks:</p>
		<p>&nbsp; &nbsp;2. # of Work in Progress tasks:</p>
		<p>&nbsp; &nbsp;3. # of Resolve tasks:</p>
		<p>&nbsp; &nbsp;4. # of tasks not started:</p>
		<p><br /> <strong>Next Day's Plan:</strong></p>"
	    ),
	    array('name'=>'Meeting Minute',
		'description'=>'<b>Attendees:</b>  John, Micheal<br/>
				<b>Date and Time:</b> July 11th 11 am PST<br/>
				<b>Purpose:</b><br/>
				<br/>
				<b>Agenda:</b> 
				<o>
				    <li>Discuss Layout </li>
				    <li>Discuss on Design</li>
				</ol>
				<br/>
				<b>Discussion:</b><br/>'
	    ),
	    array('name'=>'R&D',
		'description'=>''
	    ),
	    array('name'=>'Status update',
		'description'=>"<b>Today's accomplishment</b><br/>
		<ul>
		    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>
		    <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>
		    <li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>
		    <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry</li>
		    <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li>
		    <li>Contrary to popular belief, Lorem Ipsum is not simply random text</li>
		</ul>
		<br/>
		<b>List of files changed:</b> 
		<ol>
		    <li>index.html</li>
		    <li>style.css</li>
		    <li>contact-us.html</li>
		</ol>
		Is  code checked in Repository: <b>Y/N</b><br/>
		Is code available in Stager: <b>Y/N</b>
		<br/><br/>
		<b>Blocker/Testing Issues:</b> 
		<br/><br/>
		<b>Next Day's Plan:</b>"
	    )
    ));
##*** Default template after signed up by a company ends. ***##


	Configure::write('TASK_HEAD','<div style="width:100%!important;margin-bottom:0px;margin-top:0px;background:#f1f3f4;margin-left:0px;margin-right:0px">
    <span style="display:none!important;font-size:1px;color:#eaeaea">Orangescrum trial includes all features, unlimited Users and unlimited Projects.</span>
    <table width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#ebebeb">
        <tbody><tr>
            <td align="center" bgcolor="#f1f3f4">
                <img src="'.HTTP_ROOT.'img/email/logo_email_small.png" style="padding:20px 0 1px" alt="Orangescrum Logo" />
				<div class="sb_ttl" style="display:block;padding-top:3px;font-size:13px;color:#999999;  margin-bottom: 5px;">
				<b>#1</b>
				Task Management Software
				</div>
                <table style="font-size:14px;width:90%;" cellspacing="0" cellpadding="0" border="0" width="600">
                    <tbody><tr>
                        <td bgcolor="#ffffff" style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#7c7c7c;line-height:22px;padding:25px;border-top:2px solid #3DBB89;text-align:center;">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tbody><tr>
                                    <td valign="top">');
									
	Configure::write('TASK_FOOT','</td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <br>
                <table border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr bgcolor="#f1f3f4">
                        <td><p align="center" style="font-size:11px;color:#7d7d7d;font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif">&copy; 2015 <a href="http://www.orangescrum.com" style="color:#344351;text-decoration:none" target="_blank"><strong>Orangescrum</strong></a>. 2059 Camden Ave. #118, San Jose, CA 95124</p></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody></table><div class="yj6qo"></div><div class="adL">
</div></div>');


Configure::write(
    'DEFAULT_TASK_INPUT',
    array(
        array('title'=>'Welcome to Orangescrum',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to create your first \'Project\'?</strong><br />You have "Logged In" to Orangescrum and it\'s time to create your first project. Creating projects in Orangescrum is way easier with some few clicks. Let\'s guide you how!<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/projects/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to \'Invite or Add\' users?</strong><br />Once you have created your first project, your next step would be to invite or add users to collaborate with you in the project. You can add or remove a user any time you wish.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/users/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to create your first \'Task\'?</strong><br />Time to create some \'Tasks\' and assign them to your team or to a specific user(s) associated with the project. You can also use the Quick Task as well as Task Template feature that makes it easier for you and saves a lot of your important time.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/tasks/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to use \'Task List View\'?</strong><br />In order to see all your tasks that you or your team members have created in a single page with all the vital information in front of you like whom it is assigned to, timeline, estimated hours spent, status of the task, conversation count etc.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/tasks-list/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to use the \'Kanban Board\'?</strong><br />One of the most powerful features of Orangescrum is its Kanban Board. Learn and know tasks that are Planned, In Stack, In Progress and Tasks Completed all in a single frame.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/kanban-view/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to use \'Task Group View\'?</strong><br />Similar tasks can be grouped in a single view or group so that it would be easier for you and your team to understand related tasks better and bunch it in one single cluster.
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to get started with \'Time Log\'?</strong><br />Log time (start & end time) for all your resources linked with the tasks they are assigned to. Understand who is doing what at what time frame. Further, generate professional Invoices.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/time-log/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;"><strong style="color:#333">How to use \'Daily Catch-up\'?</strong><br />You have a distributed team, every tasks cannot be captured, and you just want your team to send daily updates, just set it and sit back.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/daily-catch-up/" target="_blank" >More...</a></p>
<p style="font-family:\'RobotoDraft-Regular\',Arial,sans-serif;color:#999999;font-size:16px;">For all features, please visit the&nbsp; Features section.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base/" target="_blank" >Help</a></p>'
	    ),
	    array('title'=>'How to create a new Task',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to create a new Task?</strong><br />Creating a task in Orangescrum is quite easy. There are many ways to create a task.<br />You can hit on the "Create Task" button or click "Task" from "+Add" menu from the top right corner. This will open up create task page.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/tasks/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/task/creat_task.jpg">
<img src="'.HTTP_ROOT.'img/help/task/creat_task.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to view Task details and reply on a task',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to view Task details and reply on a task?</strong><br />Once you click on the task, you will be able to see all the details related to the task.<br />You can then scroll down to reply to the task in the reply section as shown below.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/tasks/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/task/creat_task_detail.jpg">
<img src="'.HTTP_ROOT.'img/help/task/creat_task_detail.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to Create Task Group',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to Create Task Group?</strong><br />In the tasks page, click on the tab "Task Group" in the top. Here, you will find the option "+ New Task Group" in the left hand side just beside the list pane or from the "+Add" menu from the top right corner. You can create a task group under a specific project by any one of the above options. Now you can start adding tasks to your new task group you have created.</p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/Task_group.jpg">
<img src="'.HTTP_ROOT.'img/help/Task_group.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to Attach file to task',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to Attach File to task?</strong><br />To attach an image you just have to click on the paper-clip icon. You can also share your images with your "Google Drive" or "DropBox" account. Description shown in the image below.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/tasks/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/attach_image.jpg">
<img src="'.HTTP_ROOT.'img/help/attach_image.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to create new task type',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to create new task type?</strong><br />Creating a task type makes it easy to segregate a particular genre of tasks. You can create a new task type from the settings tab, hit on "Task Type". Click on "+ New Task Type". You will be able to see all task types here in this section.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/task-type/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/custom-task-type.jpg">
<img src="'.HTTP_ROOT.'img/help/custom-task-type.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to Log Time for a Project',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to Log Time for a Project?</strong><br />
You can log time by clicking on the left hand sidebar or from the "Log More Time" button on the right hand side of the grid.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/time-log/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/ways_log_time.jpg">
<img src="'.HTTP_ROOT.'img/help/ways_log_time.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to Generate Invoice from Time Log',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to Generate Invoice from Time Log?</strong><br />To generate an invoice with timelog, click on "Invoice" icon on the left hand side bar. You will see the invoice dashboard with all the billable details. Select on the left hand side checkbox for the tasks against which you want to generate invoices and hit on "Create Invoice".
<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/invoice/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/invoices_buildtime.jpg">
<img src="'.HTTP_ROOT.'img/help/invoices_buildtime.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to generate invoice without Time Log',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to generate invoice without Time Log?</strong><br />Navigate to "Invoice section" by clicking on "Invoice" icon on the left hand side bar. It will show all unbilled time. Hit on the right side drop down arrow "Create Invoice" button and select "Create invoice without unbilled time". It will redirect to create an invoice page with an empty form.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/invoice/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/invoice_without.jpg">
<img src="'.HTTP_ROOT.'img/help/invoice_without.jpg" style="width:100%;">
</a></p>'
	    ),
		array('title'=>'How to configure Daily Catchup ',
		'description'=>'<p style="font-family:\'RobotoDraft-Regular\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;">
<strong style="color:#333">How to configure Daily Catchup?</strong><br />Helps to get an update from your team or from others working on a common project through email. "Daily catch up" sends an email alert at a specific time only to the selected members in the project to get task updates and making it easy to collaborate without the botheration of sending individual mails.<br /><a class="trial-left trial-left-temp" href="http://helpdesk.orangescrum.com/knowledge-base-category/daily-catch-up/" target="_blank">More...</a></p><p><a rel="prettyPhoto[]" href="https://www.orangescrum.com/img/help/daily_catchup.jpg">
<img src="'.HTTP_ROOT.'img/help/daily_catchup.jpg" style="width:100%;">
</a></p>'
	    )
    ));
	
	Configure::write(
    'DEFAULT_TASKGROUP_INPUT',
        array('1'=>'Daily Catch-up','2'=>'Second Step -Time Log/Invoicing','3'=>'First Step - Tasks','4'=>'Welcome')
		);