<?php  ?>
<style>.rht_content_cmn.task_lis_page .wrapper{padding-top:35px;}
 /* don't move this code to the custom.css page **/ 
.wrapper{width:100%;padding: 35px 0 25px;}
.on-boarding-page .row.gs_top_sec{margin:0}
.on-boarding-page .get_started_outer{ margin: 25px auto 0;width: 95%;}
.on-boarding-page .gs_top_bnr{width:100%;margin-left:0;height:auto;padding:50px 0}
.on-boarding-page .gs_top_bnr h1,on-boarding-page .gs_top_bnr h4{padding:0 10px;margin-bottom:10px}
.on-boarding-page .gs_top_bnr h4{line-height:45px}
@media only screen and (max-width:850px){
   .slide_rht_con{margin-top:0}
}
@media only screen and (max-width:700px){
.rht_content_cmn > .dbrd-bar + input + .wrapper, .rht_content_cmn > .media-bar + input + .wrapper{padding-top:0;margin-top: 35px;}
.on-boarding-page .gs_top_bnr h1{font-size: 35px;}
.on-boarding-page .gs_top_bnr h4{font-size:18px;line-height:30px}
}

@media only screen and (max-width:500px){
.on-boarding-page  .gs_top_bnr h1{font-size: 30px;}
.on-boarding-page  .gs_top_bnr h4{font-size:15px}
.on-boarding-page  .get_det{padding:20px}
.on-boarding-page  .get_img{float:none;width:100px;height:auto;margin:0}
.on-boarding-page  .get_text{float:none;width:100%;}
}

.bs-wizard {margin-top: 40px;}

/*Form Wizard*/
.bs-wizard {border: none; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 36px; height: 39px; display: block; background: url("<?php echo HTTP_ROOT;?>/img/images/os-nav-logo-fill.png") no-repeat 0px 0px; top: 17px; left: 50%; margin-top: -15px; margin-left: -15px;background-size:100% 100%; color:#425f87; font-weight:bold; text-align:center; padding-top:10px; text-decoration:none; font-size:15px; line-height:30px;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: '1'; width: 27px; height: 27px; background:none;  position: absolute; top: 8px; left: 4px; } 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot.val2:after{content: '2';}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot.val3:after{content: '3';}
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #f58920;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:47%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot,.bs-wizard > .bs-wizard-step.active > .bs-wizard-dot {background: url("<?php echo HTTP_ROOT;?>/img/images/os-nav-logo-gray.png") no-repeat 0px 0px; }
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 54%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;left: -3%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
body.open_hellobar .on-boarding-page {margin-top: -95px;}
/*END Form Wizard*/
</style>
<div class="on-boarding-page">
<div class="row gs_top_sec">
	<div class="gs_top_bnr">
		<h1><span>Welcome to</span> Orangescrum.</h1>
		<h4>Let's get started on<br/>how you can start managing your projects as easy as eating a doughnut!</h4>
	</div>
</div>
    <div class='container'>
    <div class="row bs-wizard">                
        <div class="col-xs-4 bs-wizard-step <?php if(!empty($projects)){?>complete<?php }else{ ?>disabled<?php } ?>">
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="javascript:void(0);" class="bs-wizard-dot val1"></a>
        </div>

        <div class="col-xs-4 bs-wizard-step <?php if(!empty($invitations) && !empty($projects)){?>complete<?php }else if(!empty($projects) && empty($invitations)){?> active <?php }else{ ?>disabled<?php } ?>"><!-- complete -->
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="javascript:void(0);" class="bs-wizard-dot val2"></a>
        </div>

        <div class="col-xs-4 bs-wizard-step <?php if(!empty($tasks) && !empty($invitations) && !empty($projects)){?>complete<?php }else if(!empty($invitations) && !empty($projects) && empty($tasks)){ ?>active<?php }else{ ?>disabled<?php } ?> "><!-- complete -->
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="javascript:void(0);" class="bs-wizard-dot val3"></a>
        </div>
    </div>
    </div>
<div class="get_started_outer">
    <?php if(SES_TYPE<3) { ?>
    <div class="get_hd_bg">Getting Started with Orangescrum
	<span style="float:right;">Need Help? <a href="https://helpdesk.orangescrum.com/cloud/" target="_blank" onclick="return trackEventLeadTracker('Getting Started','Need Help','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Click here!</a></span>
    <?php if (isset($first_login) && $first_login == 1) { /* ?>
        <span class="skip-to-list">
            <a href="<?php echo HTTP_ROOT; ?>dashboard#tasks" class="btn btn_cmn_efect cmn_bg btn-info cmn_size skip-btn" onclick="delete_cookie('FIRST_LOGIN_1');">Skip</a>
        </span>
    <?php */ } ?>
    </div>
    <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
    <div class="get_det">
        <div class="fl get_img get_prj_bg" onclick="setSessionStorage('Getting Started Page Icon','Create Project');newProject();">
						<div class="gsm-icon gs-proj"><i class="material-icons">&#xE8F9;</i></div>
        </div>
        <div class="get_text fl">
            <div class="get_title"><?php echo $this->Html->link('Create and Assign Project','javascript:void(0);',array('onclick'=>'setSessionStorage(\'Getting Started Page Text\',\'Create Project\');newProject();','class'=>''));?> <?php echo !empty($projects)?$this->Html->image('yes.png'):'';?> </div>
            <ul>
                <li>
                    Name your project suitably, choose short name accordingly.
                </li>
                <li>
                    Add up your team members/customers to the project while creating.
                </li>
                <li>
                    Alternately, you can add team/customer to a project in 'Manage Projects' section.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
<?php } ?>
    <div class="get_det">
        <div class="fl get_img get_usr_bg" onclick="newUser();">
						<div class="gsm-icon gs-user"><i class="material-icons">&#xE7FE;</i></div>
        </div>
        <div class="get_text fl">
            <div class="get_title"><?php 
            if(!empty($projects)){
                echo $this->Html->link('Invite User','javascript:void(0);',array('onclick'=>'newUser();','class'=>''));
            }else{
                echo $this->Html->link('Invite User','javascript:void(0);',array('onclick'=>'alert("Please complete step 1 then try again.");return false;','class'=>'')); 
            }
            ?> <?php echo (!empty($invitations) && !empty($projects))?$this->Html->image('yes.png'):'';?></div>
            <ul>
                <li>
                    Send invitation to team member (separate by comma for multi Email IDs)
                </li>
                <li>
                    Invitees need to set up their account using link provided in the email.
                </li>
                <li>
                    Assign projects to your team members while inviting them.
                </li>
                <li>
                    You can assign/remove projects from your team members any time on manage users section.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    <div class="get_det">
        <div class="fl get_img get_tsk_bg"   <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    onclick="setSessionStorage('Getting Started Page Icon','Create Task');creatask();" <?php } ?>>
						<div class="gsm-icon gs-task"><i class="material-icons">&#xE862;</i></div>
        </div>
        <div class="get_text fl">
            <div class="get_title">
 <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
                <?php 
            if(!empty($projects) && !empty($invitations)){
            echo $this->Html->link('Create','javascript:void(0);',array('onclick'=>'setSessionStorage(\'Getting Started Page Text\',\'Create Task\');creatask();','class'=>'get_title'));
            }else{
              echo $this->Html->link('Create','javascript:void(0);',array('onclick'=>'alert("Please complete step 1 and 2 then try again.");return false;','class'=>'get_title'));  
            }
            ?> or <?php 
            if(!empty($projects) && !empty($invitations)){
                echo $this->Html->link('Import Task','/import-export',array('class'=>''));
            }else{
                echo $this->Html->link('Import Task','/import-export',array('onclick'=>'alert("Please complete step 1 and 2 then try again.");return false;','class'=>''));
            }
?> <?php } ?> <?php echo (!empty($tasks) && !empty($invitations) && !empty($projects) )?$this->Html->image('yes.png'):'';?></div>
            <ul>
                <li>
                    Enter a title, put due date or set priority and create a task under a project.
                </li>
                <li>
                    Assign task to a team member, attach files from Google Drive or Dropbox while creating a task.
                </li>
                <li>
                    You can also Import a bunch of tasks from a .CSV file under a project.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    
     <div class="get_hd_bg" onclick="window.location='<?php echo HTTP_ROOT; ?>task-type'">Custom Task Type</div>
    <div class="get_det">
        <div class="fl get_img custom_taskn" onclick="window.location='<?php echo HTTP_ROOT; ?>task-type'">
            <div class="gs-email">
            	Custom<br/>Task Type
            </div>
        </div>
        <div class="get_text fl">
            <div class="get_title"><?php echo $this->Html->link('Create Custom Task Type','/task-type', array('class' => 'get_title')); ?> <?php echo !empty($types)?$this->Html->image('yes.png'):'';?></div>
            <ul>
            	<li>
                    You can categorize your Task using the Task Types.
                </li>
                <li>
                    It's doesn't matter whether your business is Education or Health Services or Construction, you can define your own Task Type and add Tasks under them
                </li>
                <li>
                   You can remove the default Task Type by unchecking the checkbox and save the changes.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    
    <?php } ?>
    <div class="get_hd_bg" onclick="window.location='<?php echo HTTP_ROOT; ?>help-emails-notifications-11'">Respond via Email</div>
    <div class="get_det">
        <div class="fl get_img get_eml_bg" onclick="window.location='<?php echo HTTP_ROOT; ?>help-emails-notifications-11'">
						<div class="gsm-icon gs-msg"><i class="material-icons">&#xE0BE;</i></div>
        </div>
        <div class="get_text fl">
            <div class="get_title"></div>
            <ul>
                <li>
                    You can respond to the task Email sent from notify&#64;orangescrum&#46;com.
                </li>
                <li>
                    Your Email response will be posted on Orangescrum against that task.
                </li>
                <li>
                    Respond on a task even on-the-go from your mobile via Email.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    <?php
	if (defined('NODEJS_HOST') && trim(NODEJS_HOST)) {
	?>
   	<div class="get_hd_bg" onclick="window.location='<?php echo HTTP_ROOT; ?>users/email_notifications'">Desktop Notification</div>
    <div class="get_det">
		<a class="get_title" href="/users/email_notifications">
			<div class="fl get_img get_not_bg">
				<div class="gsm-icon gs-not"><i class="material-icons">&#xE7F4;</i></div>
			</div>
        </a>
        <div class="get_text fl">
            <div class="get_title"></div>
            <ul>
                <li>
                   The Desktop Notification works on heigher versions of most of the browsers.
                   Firefox 22 and above, Chrome 32 and above, Safari 6 on Mac OSX 10.8+
                </li>
                <li>
                   You'll see a pop-up when a new task or reply arrives so you can keep track of your Tasks even when you're not looking at Orangescrum.
                </li>
                <li>
                    Turn the desktop notification On or Off in the "<?php echo $this->Html->link('Notifications','/users/email_notifications');?>" page.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    <?php
	}
	?>
    <div class="get_hd_bg">Settings</div>
    <div class="get_det">
	<a class="get_title" href="/users/profile">
        <div class="fl get_img get_tm_bg">
						<div class="gsm-icon gs-time"><i class="material-icons">&#xE8B8;</i></div>
        </div>
	</a>
        <div class="get_text fl">
            <div class="get_title"><?php echo $this->Html->link('Timezone & Profile','/users/profile',array('class'=>'get_title'));?></div>
            <ul>
                <li>
                    Personalize your Orangescrum account by setting up your Profile details and Timezone.
                </li>
                <li>
                    The Timezone settings help you to keep stay up-to-date while working with a virtual or remote team.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    <div class="get_det">
	<a class="get_title" href="/users/email_notifications">
        <div class="fl get_img get_not_bg">
						<div class="gsm-icon gs-not"><i class="material-icons">&#xE7F4;</i></div>
        </div>
	</a>
        <div class="get_text fl">
            <div class="get_title"><?php echo $this->Html->link('Notifications','/users/email_notifications',array('class'=>'get_title'));?> <?php echo !empty($notifications)?$this->Html->image('yes.png'):'';?></div>
            <ul>
                <li>
                    The Email Notification is set to "No" by default, to get email those email only when selected when task is posted.
                </li>
                <li>
                    Set to "Yes", to get all the Task related Emails from all your assigned projects from Orangescrum.
                </li>
                <li>
                    You can enable or disable Google Chrome Desktop Notification on the "Notification" page.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
    <div class="get_det">
	<a class="get_title" href="/users/email_reports">
        <div class="fl get_img get_emlrpt_bg">
						<div class="gsm-icon gs-emlrpt"><i class="material-icons">&#xE151;</i></div>
        </div>
	</a>
        <div class="get_text fl">
            <div class="get_title"><?php echo $this->Html->link('Email Reports','/users/email_reports',array('class'=>'get_title'));?></div>
            <ul>
                <li>
                    Customize your Email report settings.
                </li>
                <li>
                    Select projects and set your daily update settings.
                </li>
            </ul>
        </div>
        <div class="cb"></div>
    </div>
</div>
</div>
<script language="javascript" type="text/javascript">

	/* Code for Create Event tracking starts here */
	var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
	var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
	var event_name = sessionStorage.getItem('SessionStorageEventValue');
	
	if(eventRefer && event_name){
		trackEventLeadTrackerGetting(event_name, eventRefer, sessionEmail);
	}
	/* Code for Create Event tracking ends here */
</script>