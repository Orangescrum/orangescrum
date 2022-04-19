<?php $page_array = array('glide_chart', 'hours_report', 'chart', 'weeklyusage_report','pending_task','resource_utilization'); ?>
<style type="text/css">
	.left_panel_ntother_link small.new_txt{color: #ff0000;display: inline-block; font-size: 10px;font-weight: 500; left: 4px; position: relative;top: -6px}
    .left-menu-panel .side-nav {background:#fff;border-right:1px solid rgba(0,0,0,.15);}
    .left-menu-panel .side-nav li a {color:#212121;}
    .left-menu-panel .side-nav li.active a {color:#F6911D;background:none;}
    .left-menu-panel .side-nav li a:hover {color:#F6911D;background:none;}
    .big-sidebar .left-menu-panel .side-nav li.active .hover_subitem a,.big-sidebar .left-menu-panel .side-nav li:hover .hover_subitem a {color: #212121;}
    .big-sidebar .left-menu-panel .side-nav li.active .hover_subitem a.activesmenu,.big-sidebar .left-menu-panel .side-nav li:hover .hover_subitem a.active  {color:#F6911D;}

    .left-menu-panel .side-nav li .show_new_add_div li a {color:#888;font:500px;}
    .left-menu-panel .side-nav li .show_new_add_div li a:hover {color:#F6911D;background:none;}

    .left-menu-panel .side-nav li a .left-menu-icon.material-icons{color:#888;}
    .left-menu-panel .side-nav li a:hover .left-menu-icon.material-icons {color:#F6911D;}
    .left-menu-panel .side-nav li a.btn_cmn_efect:hover {color:#fff;}
    #btn-add-new-all, #new_onboarding_add_icon .btn {
        margin:15px;
    }
    .show_new_add_div{
        box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        z-index:999;	
        display:none;
        width:172px;
        background: #fff none repeat scroll 0 0;
        margin-left: 14px;
        margin-top: -13px;
        position: absolute;
    }
    .left-menu-panel .side-nav li a .left-menu-icon.material-icons, .show_new_add_div ul li a .material-icons {margin-right:10px;}
    .show_new_add_div ul li {list-style-type:none;}
    .show_new_add_div ul {margin-left: -20px;}
/*    .list_miscl ul.smenu_miscl {background: #fff none repeat scroll 0 0;}*/
    .list_miscl ul.smenu_miscl a{color:#212121;}
    ul.smenu_miscl_whit{list-style: none; padding: 0px;}
    .left-menu-panel .side-nav li.active ul.smenu_miscl_whit  li a {background: #fff none repeat scroll 0 0;color:#212121;}
    .left-menu-panel .side-nav li.active ul.smenu_miscl_whit li a:hover, .left-menu-panel .side-nav li.active ul.smenu_miscl li.active_bk a {color:#F6911D;}
    .left-menu-panel .side-nav li.active a .left-menu-icon.material-icons{color:#F6911D;}
    #saveFilter:hover .material-icons {color:#00BCD5;}
    .left-menu-panel .side-nav ul.smenu_miscl li a {padding: 5px 12px 5px 36px;}

    .left-menu-panel .side-nav li.menu-logs{position:relative}
    .left-menu-panel .side-nav li .fixleft-submenu{border:1px solid #ddd;position:absolute;right:-90%;top:0px;width:100%;z-index:9;border-radius:5px;background:#fff;display:none;}
    .left-menu-panel .side-nav li.menu-logs:hover .fixleft-submenu{display:block}
    .left-menu-panel .side-nav li .fixleft-submenu::before{content:'';border-right:12px solid #ddd;border-bottom:12px solid transparent;border-top:12px solid transparent;position:absolute;left:-13px;top:10px;display:block}
    .left-menu-panel .side-nav li .fixleft-submenu::after{content:'';border-right:10px solid #fff;border-bottom:10px solid transparent;border-top:10px solid transparent;position:absolute;left:-10px;top:12px;display:block}
    .left-menu-panel .side-nav li .fixleft-submenu ul{margin:0;padding:0;list-style-type:none;}
    .left-menu-panel .side-nav li .fixleft-submenu ul li{display:block;padding:5px 10px;border-bottom:1px solid #ddd}
    .left-menu-panel .side-nav li .fixleft-submenu ul li:first-child{border-radius:5px 5px 0px 0px}
    .left-menu-panel .side-nav li .fixleft-submenu ul li:last-child{border-radius:0px 0px 5px 5px;border-bottom:none}
    .left-menu-panel .side-nav li .fixleft-submenu ul li a{padding:0;text-decoration:none;color:#212121;font-size:13px;line-height:26px;}

    .new_back_icon {font-size: 14px;left: 10%;margin-top: 90px;position:fixed;top: 29%;z-index: 999;color:#A6A6A6;}
    .left-menu-panel .side-nav li .fixleft-submenu ul li:hover a{color:#F6911D}
    .new_back_icon:hover {color:#0091EA;}
	.left_panel_other_link {display:none;}
	
	
	body.project-scrum .project-scrum-link {display:block;}
	body.project-scrum .project-scrum-nlink {display:none;}
	
	
    <?php if ($_COOKIE['FIRST_INVITE_1'] && 1 != 1) {  ?>
    .gray-out,.gray-out-sub,.gray-out-quick,.gray-out-setting{width:100%; height:100%;background-color: gray;opacity: .8; position:absolute;z-index:1000;}   
    .gray-out-sub{left:0px; height:160px;}
    #new_onboarding_add_icon,#new_onboarding_add_icon a,.show_new_add_div{z-index: 1001;}
    .gray-out-quick{left:0px;top:0px;}
    .gray-out-setting{left:0px;top:0px;}
    <?php }else{ ?>
     .gray-out,.gray-out-sub,.gray-out-quick,.gray-out-setting{display:none;}
    <?php } ?>
    <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) { ?>
     .big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects,.big-sidebar .recent_visited_project_reports{display:none;}
     .big-sidebar .left_panel_ntother_link,.projectMenuLeft,.projectReportMenuLeft{display:block;}
    <?php } else if(CONTROLLER == "projects" && (PAGE_NAME == "manage")){ ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .recent_visited_projects, #recent_visted_projects_dvblk{display:block;}
     .big-sidebar .left_panel_ntother_link,.big-sidebar .view_tasks_menu,.big-sidebar .caseMenuLeft,.big-sidebar .projectReportMenuLeft,.big-sidebar .recent_visited_project_reports, body.project-scrum .project-scrum-link{display:none;}      
    <?php } else if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports' || in_array(PAGE_NAME, $page_array))) { ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .recent_visited_project_reports{display:block;} 
     .big-sidebar .left_panel_ntother_link,.big-sidebar .view_tasks_menu,.big-sidebar .caseMenuLeft,.big-sidebar .projectMenuLeft,body.project-scrum .project-scrum-link{display:none;}      
    <?php }else{ ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects,.big-sidebar .recent_visited_project_reports{display:none;}
     .big-sidebar .left_panel_ntother_link{display:block;}
    <?php } ?>
     <?php if ($_COOKIE['FIRST_INVITE_1']) {  ?>
       .big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects,.big-sidebar .recent_visited_project_reports{display:none;}
     .big-sidebar .left_panel_ntother_link{display:block;}
     <?php } ?>
        .template-menu{display:none;}
	.mini-sidebar .new_back_icon{display:none;}
	.mini-sidebar .plan-info-li{display:none;}
	<?php if(CONTROLLER == 'ganttchart' && PAGE_NAME == 'ganttv2'){ ?>
		body.open_hellobar .rht_content_cmn.task_lis_page .wrapper {padding-top:45px;}
	<?php } ?>
	
.left-menu-panel .tour_btn{margin-top: 30px;}
.left-menu-panel .tour_btn a.btn{text-decoration:none;display:inline-block;padding:6px 10px;margin-left:15px;text-align:center;font-size:13px;color:#fff;background:#F6911D}
.left-menu-panel .tour_btn a.btn:hover{background:#F6911D;color:#fff}
.mini-sidebar .left-menu-panel .tour_btn a.btn{background:none;text-align:left;margin-left:0}
.left-menu-panel .side-nav li.tour_btn a .left-menu-icon.material-icons{color:#fff;transform: rotate(60deg);-webkit-transform: rotate(60deg);-moz-transform: rotate(60deg);}
.mini-sidebar .left-menu-panel .side-nav li.tour_btn a .left-menu-icon.material-icons{color:#888;background: transparent;}
@media only screen and (max-width:1280px) {.left-menu-panel .side-nav li a {padding: 6px 12px;}}

</style>    
<?php $scrumArr = array('simple'); ?>
<div class="main-container">
    <div class="left-menu-panel">       
        <?php
        $shw = 1;
        $priving_arr_fun = array("subscription", "transaction", "creditcard", "account_activity", "pricing", 'upgrade_member', 'account_usages', 'downgrade', 'edit_creditcard', 'confirmationPage','cancel_subscription_os');
        $priving_arr_fun = is_array($priving_arr_fun) ? $priving_arr_fun : array();
        if (in_array(PAGE_NAME, $priving_arr_fun)) {
            $shw = 0;
        }
        if (!in_array(PAGE_NAME, array("updates", "help", "tour", "customer_support")) && $shw) {
            ?>
            <ul class="side-nav sidebar-menu">
                 <div class="gray-out"></div>
                <li>
                    <span id="new_onboarding_add_icon">
                        <a onclick="$('.show_new_add_div').toggle();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" id="btn-add-new-all" href="javascript:void(0)"><?php __('New');?><div class="ripple-container"></div></a>
                    </span>
                    <div class="show_new_add_div">
                        <ul class="border-box">
                            <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
                            <li>
                                <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Project');newProject();">
                                    <i class="material-icons cmn-icon-prop">&#xE8F9;</i><?php echo __('Project'); ?>
                                </a>
                            </li>
                        <?php } ?>
                            <div class="gray-out-sub"></div>
                             <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
                            <li>
                                <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Task');creatask();">
                                    <i class="material-icons cmn-icon-prop">&#xE862;</i><?php echo __('Task'); ?>
                                </a>
                            </li>
                        <?php } ?>
                            <?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                                <li >
                                    <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Time Log');createlog(0, '')">
                                        <i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry'); ?>
                                    </a>
                                </li>
                            <?php } ?>	
                            <?php if (SES_TYPE < 3) { ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Invite User');newUser()">
                                        <i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('User'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
				 <li class="list-7 projectMenuLeft <?php
                if (CONTROLLER == "projects" && (PAGE_NAME == "manage")) {
                    echo 'active';
                }else{
                ?> project-<?php echo $_SESSION['project_methodology'];?>-link <?php } ?> showhiderec_visted_proj">
				<?php
					$type = $_COOKIE['PROJECTVIEW_TYPE'];
					$type = explode('_', $type);
					$projecturl = '';
					$projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
					?>
                    <a href="javascript:void(0);">
						<?php if (CONTROLLER == "projects" && PAGE_NAME == 'manage') { ?>
						<i style="width: 30px;" class="material-icons comn_back_icon" data-name="project">arrow_backward</i>
						<?php }else{ ?>
							<i class="left-menu-icon material-icons">&#xE8F9;</i>
						<?php } ?>
						<!--<i class="left-menu-icon material-icons">&#xE8F9;</i>-->
                        <span class="mini-sidebar-label"><?php echo __('Projects');?></span>
                        <span class="fr" title="<?php echo __('View Last Visited Projects'); ?>" rel="tooltip">						
						<?php /*<i class="material-icons report-arrow_forward" <?php if (CONTROLLER == "projects") { ?>style="display:none;"<?php } ?>>arrow_forward</i> */ ?>						
						<i class="material-icons">keyboard_arrow_down</i>
						
						</span>
                    </a>
					<?php if(CONTROLLER == "projects" && PAGE_NAME == "manage"){ }else{ ?>
					<div id="recent_visted_projects_dvblk">
					<?php } ?>
                    <?php echo $this->element('recent_visted_projects'); ?>
					<?php if(CONTROLLER == "projects" && PAGE_NAME == "manage"){ }else{ ?>
					</div>
					<?php } ?>
                </li>
                <li class="list-1 left_panel_ntother_link <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "mydashboard")) {
                    echo 'active';
                }
                ?> project-<?php echo $_SESSION['project_methodology'];?>-link">
                    <a href="<?php echo HTTP_ROOT . 'mydashboard'; ?>" onclick="resetAllProjectFromDbd();return trackEventLeadTracker('Left Panel','Dashboard Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <!--<span class="os_sprite dash-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE871;</i>
                        <span class="mini-sidebar-label"><?php echo __('Dashboard');?></span>
                    </a>
                </li>               
				<li class="left_panel_ntother_link menu-backlog prevent_togl_li list-13 project-<?php echo $_SESSION['project_methodology'];?>-link">
					<a href="<?php echo HTTP_ROOT . 'dashboard#backlog'; ?>" onclick="trackEventLeadTracker('Left Panel', 'Backlog Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>'); checkHashLoad('backlog');">
						<i class="left-menu-icon material-icons">ballot</i>
						<span class="mini-sidebar-label"><?php echo __('Backlog'); ?> </span>
					</a>
				</li>
				<li class="left_panel_ntother_link menu-sprint prevent_togl_li list-4 project-<?php echo $_SESSION['project_methodology'];?>-link">
					<a href="<?php echo HTTP_ROOT . 'dashboard#activesprint'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Active Sprint Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>'); checkHashLoad('sprint');">
						<i class="left-menu-icon material-icons">horizontal_split</i>
						<span class="mini-sidebar-label"><?php echo __('Active Sprint'); ?></span>
					</a>
				</li>
				<li class="list-71 projectReportMenuLeft  <?php
                if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array))) {
                    echo 'active';
                }else{
                ?> project-<?php echo $_SESSION['project_methodology'];?>-link <?php } ?>">
                    <a href="<?php echo HTTP_ROOT . 'project_reports/dashboard' ; ?>">
						<?php if (CONTROLLER != "project_reports" && !in_array(PAGE_NAME, $page_array)) { ?>
                        <i class="left-menu-icon material-icons">&#xE922;</i>
						<?php }else{ ?>
						<i style="width: 30px;" class="material-icons comn_back_icon" data-name="report">arrow_backward</i>
						<?php } ?>
                        <span class="mini-sidebar-label"><?php echo __('Reports'); ?></span><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __('New');?></sup>
                        <?php /*<span class="last_visited_project_reports fr glyphicon <?php
                        if (CONTROLLER == "project_reports" && (PAGE_NAME == "dashboard")) {
                            echo 'glyphicon-menu-down';
                        } else {
                            echo 'glyphicon-menu-right';
                        }
                        ?>" title="<?php echo __('View Last Visited Reports');?>" rel="tooltip"></span> */ ?>
						<span class="fr glyphicon" title="<?php echo __('View Last Visited Reports');?>" rel="tooltip">
						
						<i class="material-icons report-arrow_forward" <?php if (CONTROLLER == 'ProjectReports' || CONTROLLER == "project_reports" || in_array(PAGE_NAME, $page_array)) { ?>style="display:none;"<?php } ?>>arrow_forward</i>
						</span>
                    </a>					
                    <?php echo $this->element('recent_visited_project_reports'); ?>
                </li>
                <li class="caseMenuLeft menu-cases list-2 list_miscl relative miscl-icon-li <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
                    echo 'active';
                }
                ?> project-<?php echo $_SESSION['project_methodology'];?>-link">
                        <?php
                        $tskurl = '';
                        $onclick = '';
						$ldTrkUrl = '';
                        if(DEFAULT_VIEW_VALUE != 0){
                            $tskurl = DEFAULT_VIEW_TASK;
                            $ldTrkUrl = DEFAULT_VIEW_TASK;
                            if (DEFAULT_VIEW_TASK == 'tasks') {
                                $onclick = "checkHashLoad('tasks')";
                                $ldTrkUrl = 'Tasks Page';
                            } else if (DEFAULT_VIEW_TASK == 'taskgroup') {
                                $tskurl = "tasks";
                                $onclick = "return groupby('milestone')";
                                $ldTrkUrl = 'Task Group Page';
							}else if (DEFAULT_VIEW_TASK == 'taskgroups') {
                                $tskurl = "taskgroups";
                                $onclick = "return ajaxCaseView('taskgroups')";
                                $ldTrkUrl = 'Sub-task view';
                        }else{
                                $onclick = "return checkHashLoad('milestonelist')";
                                $ldTrkUrl = 'Task Group Page';
                            }
                        }else{
                            $tskurl = DEFAULT_TASKVIEW == 'milestonelist' ? 'milestonelist' : 'tasks';
                            if (DEFAULT_TASKVIEW == 'tasks') {
                                $onclick = "checkHashLoad('tasks')";
                                $ldTrkUrl = 'Tasks Page';
                            } else if (DEFAULT_TASKVIEW == 'task_group') {
                                $onclick = "return groupby('milestone')";
                                $ldTrkUrl = 'Task Group Page';
                            }else if (DEFAULT_TASKVIEW == 'taskgroups') {
                                $tskurl = "taskgroups";
                                $onclick = "return ajaxCaseView('taskgroups')";
                                $ldTrkUrl = 'Sub-task view';
                            } else {
                                $onclick = "return checkHashLoad('milestonelist')";
                                $ldTrkUrl = 'Task Group Page';
                            }
                        }
                        ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $tskurl; ?>" onclick="<?php echo $onclick; ?>;">
                        <!--<span class="os_sprite task-icon"></span>-->
						<i style="width: 30px;" class="material-icons comn_back_icon task_back_icon" data-name="project">arrow_backward</i>
						<i class="left-menu-icon material-icons task_back_icon_d">&#xE862;</i>
                        <span class="mini-sidebar-label"><?php echo __('Tasks'); ?></span>
                        <span class="fr" title="<?php echo __('View Tasks');?>" rel="tooltip">
						<i class="material-icons report-arrow_forward" <?php if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') { ?>style="display:none;"<?php } ?>>arrow_forward</i>
						
						</span>

                    </a>
                    <?php echo $this->element('view_tasks_menu'); ?>
                </li>
				<li class="cmn-arrow_backli">
					<a href="javascript:void(0);" title="<?php __('Back');?>">
						<i class="material-icons cmn-arrow_back" style="display:none;">arrow_back</i>
					</a>
				</li>
                <li class="menu-logs left_panel_ntother_link list-3  list_miscl relative miscl-icon-li <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "timelog") || PAGE_NAME == "resource_utilization" || PAGE_NAME == "resource_availability") {
                    echo 'active';
                }
                ?> project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                         <?php
                         $timelogurl = '';
                         $ldTrkUrl = '';
                         $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
                         $ldTrkUrl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'Time Log Calendar Page' : 'Time Log Page';
                         ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" onclick="return trackEventLeadTracker('Left Panel', '<?php echo $ldTrkUrl; ?>', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');return checkHashLoad('timelog');"  >
                        <!--<span class="os_sprite tlog-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE192;</i>
                        <span class="mini-sidebar-label-hidden"><?php echo __('Time Log'); ?></span> <!--<small class="new_txt">New</small>-->
                    </a>
                    <ul class="smenu_miscl_tl inner_ul_list">						
                        <li class="prevent_togl_li list-11">
							<a onclick="return trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('timelog');" href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" <?php if(PAGE_NAME != "resource_availability" && PAGE_NAME != "resource_utilization"){ echo "class='activesmenu'";} ?> style="margin-top: 5px;" title="<?php echo __('Time Log List View');?>">
                                <i class="material-icons">&#xE192;</i><?php echo __('Time Log List View'); ?> 
                            </a>							
                        </li>
                        <?php if ($this->Format->isTimesheetOn() && $this->Format->isLifeFreeUser()) { ?>
                            <!-- <li class="prevent_togl_li list-12">
                                <a id="timesheet_btn_timelog" onclick="return trackEventLeadTracker('Weekly Timesheet', 'Left Menu', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="<?php echo HTTP_ROOT . 'dashboard#timesheet_weekly'; ?>" title=" <?php echo __('Weekly Timesheet'); ?>"><i class="material-icons">&#xE616;</i> <?php echo __('Weekly Timesheet'); ?></a>
                            </li>						 -->
                        <?php } else { ?>
                            <li class="prevent_togl_li list-12">
                                <a onclick="showUpgradPopup(0, 1);" href="javascript:void(0);" title="<?php echo __('Weekly Timesheet'); ?>"><i class="material-icons">&#xE616;</i> <?php echo __('Weekly Timesheet'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                            </li>
                        <?php } ?>

                        <?php if (SES_TYPE < 3) { ?>
                            <li class="prevent_togl_li list-12 <?php
                            if (PAGE_NAME == "resource_utilization") {
                                echo 'active_bk active';
                            }
                            ?>">
							 <a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-utilization/" ?>" <?php if(PAGE_NAME == "resource_utilization"){ echo "class='active'";} ?> title="<?php echo __('Resource Utilization');?>">
                                    <i class="material-icons">&#xE335;</i><?php echo __('Resource Utilization'); ?>
                                </a>
                            </li> 
                        <?php } ?>
                        <li class="prevent_togl_li list-12 <?php
                        if (PAGE_NAME == "resource_availability") {
                            echo 'active_bk active';
                        }
                        ?>">
                                <?php
                                if (SES_TYPE < 3) {
                                    if ($this->Format->isResourceAvailabilityOn('upgrade')) {
                                        if ($this->Format->isResourceAvailabilityOn('status')) {
                                            ?>              
                                <a onclick="return trackEventLeadTracker('Left Panel','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-availability/" ?>" <?php if(PAGE_NAME == "resource_availability"){ echo "class='active'";} ?> title=" <?php echo __('Resource Availability');?>">
                                            <i class="material-icons">&#xE7FB;</i>
                                            <?php echo __('Resource Availability'); ?>
                                        </a>
                            <?php }}else{ ?>
                                    <a onclick="showUpgradPopup(0, 1, 1); trackEventLeadTracker('Left Panel', 'Resource Availability Report', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="javascript:void(0);" class="upgradeLink" title=" <?php echo __('Resource Availability'); ?>"><i class="material-icons">&#xE7FB;</i><?php echo __('Resource Availability'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                        <?php }
                                                }?>
                        </li>
                    </ul>

                    <div class="hover_subitem">
                         <a onclick="return trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('timelog');" href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" <?php if(PAGE_NAME == "timelog"){ echo "class='active'";} ?>>
                            <i class="material-icons">&#xE192;</i><?php echo __('Time Log List View'); ?> 
                        </a>
                        <?php if ($this->Format->isTimesheetOn() && $this->Format->isLifeFreeUser()) { ?>
                            <!-- <a id="timesheet_btn_timelog" onclick="return trackEventLeadTracker('Weekly Timesheet', 'Left Menu', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="<?php echo HTTP_ROOT . 'dashboard#timesheet_weekly'; ?>" class="upgradeLink"><i class="material-icons">&#xE616;</i> <?php echo __('Weekly Timesheet'); ?></a> -->
                           <?php } else { ?>
                            <a onclick="showUpgradPopup(0, 1);" href="javascript:void(0);"><i class="material-icons">&#xE616;</i><?php echo __('Weekly Timesheet'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                        <?php } ?>
                        <?php if (SES_TYPE < 3) { ?>
                          <a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-utilization/" ?>" <?php if(PAGE_NAME == "resource_utilization"){ echo "class='active'";} ?>>
                                <i class="material-icons">&#xE335;</i><?php echo __('Resource Utilization'); ?>
                            </a>
                        <?php } ?>
                        <?php
                        if (SES_TYPE < 3) {
                            if ($this->Format->isResourceAvailabilityOn('upgrade')) {
                                if ($this->Format->isResourceAvailabilityOn('status')) {
                                    ?>              
                                <a onclick="return trackEventLeadTracker('Left Panel','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-availability/" ?>" <?php if(PAGE_NAME == "resource_availability"){ echo "class='active'";} ?>>
                                        <i class="material-icons">&#xE7FB;</i>
                                        <?php echo __('Resource Availability'); ?>
                                    </a>
                            <?php }}else{ ?>
                                <a onclick="showUpgradPopup(0, 1, 1);trackEventLeadTracker('Left Panel', 'Resource Availability Report', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="javascript:void(0);" class="upgradeLink"><i class="material-icons">&#xE7FB;</i><?php echo __('Resource Availability'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                        <?php }
                           }
                           ?>
                    </div>

                </li>
                
                
                <li class="list-71 left_panel_other_link project-<?php echo $_SESSION['project_methodology'];?>-link">
                    <a href="javascript:void(0);">
                        <i class="left-menu-icon material-icons">&#xE619;</i>
                        <span class="mini-sidebar-label"><?php echo __('Others'); ?>...</span>
                    </a>					
                    <?php //echo $this->element('other_links');    ?>
                </li>

                <?php if (SES_TYPE < 3) { ?>
                    <li class="left_panel_ntother_link prevent_togl_li list-13 <?php
                    if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {
                        echo 'active_bk active';
                    }
                    ?> project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                            <?php if ($this->Format->isFeatureOn('gantt', $user_subscription['subscription_id'])) { ?>
                            <a href="javascript:showUpgradPopup(0,1);" onclick="trackEventLeadTracker('Left Panel', 'Gantt Chart Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                                <i class="left-menu-icon material-icons">&#xE919;</i>
                                <span class="mini-sidebar-label"><?php echo __('Gantt Chart'); ?> <?php echo $this->Format->getlockIcon(1); ?></span>
                            </a>
                        <?php } else { ?>					
                            <a href="<?php echo HTTP_ROOT . 'ganttchart/manage'; ?>" onclick="trackEventLeadTracker('Left Panel', 'Gantt Chart Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                                <i class="left-menu-icon material-icons">&#xE919;</i>
                                <span class="mini-sidebar-label"><?php echo __('Gantt Chart'); ?></span>
                            </a>
                        <?php } ?>
                    </li>
                    <li class="left_panel_ntother_link menu-invoices list-4 <?php
                    if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) {
                        echo 'active';
                    }
                    ?> project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                        <a href="<?php echo HTTP_ROOT . 'easycases/invoice'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Invoice Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                            <!--<span class="os_sprite invo-icon"></span>-->
                            <i class="left-menu-icon material-icons">&#xE53E;</i>
                            <span class="mini-sidebar-label"><?php echo __('Invoices'); ?></span>
                        </a>
                    </li>
                <?php } ?>
                <li class="left_panel_ntother_link list-5 menu-files project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                    <a href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Files Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');return checkHashLoad('files');">
                        <!--<span class="os_sprite file-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE2BC;</i>
                        <span class="mini-sidebar-label"><?php echo __('Files'); ?> <span id="fileCnt" style="display: none;margin-left:5px;"></span></span>
                    </a>
                </li>				
                <?php if (SES_TYPE == 1 || SES_TYPE == 2) { ?>
                    <li class="left_panel_ntother_link list-8 <?php
                    if (CONTROLLER == "users" && (PAGE_NAME == "manage")) {
                        echo 'active';
                    }
                    ?> project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                        <a href="<?php echo HTTP_ROOT . 'users/manage'; ?>">
                            <!--<span class="os_sprite user-icon"></span>-->
                            <i class="left-menu-icon material-icons">&#xE7FD;</i>
                            <span class="mini-sidebar-label"><?php echo __('Users'); ?></span>
                        </a>
                    </li>
                <?php } ?>
                <?php $page_array = array('glide_chart', 'hours_report', 'chart', 'weeklyusage_report'); ?>
                <li class="list_miscl miscli relative miscl-icon-li template-menu-parent left_panel_ntother_link <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>active_bkp<?php } ?> project-<?php echo $_SESSION['project_methodology'];?>-nlink">
                    <a href="javascript:void(0)" class="miscl-icon-anchor">
                        <!--<span class="os_sprite miscl-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE53B;</i>
                        <span class="mini-sidebar-label-hidden"><?php echo __('Miscellaneous'); ?></span>
                        <span class="glyphicon gly_mis <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>glyphicon-menu-down<?php } else { ?> glyphicon-menu-right<?php } ?>"></span>
                    </a>
                    <ul class="smenu_miscl smenu_miscl_whit ss_menu_mis inner_ul_list template-menu">
                        <li class="prevent_togl_li list-11 <?php
                        if (CONTROLLER == "archives" && (PAGE_NAME == "listall")) {
                            echo 'active_bk active';
                        }
                        ?>">
                            <a href="<?php echo HTTP_ROOT . 'archives/listall#caselist'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Archive Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                                    <!--<span class="os_sprite arch-icon"></span>-->
                                <i class="left-menu-icon material-icons">&#xE149;</i>
                                <?php echo __('Archive'); ?>
                            </a>
                        </li>
                        <?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
                            <li class="prevent_togl_li list-12 <?php
                            if (CONTROLLER == "templates") {
                                echo 'active_bk active';
                            }
                            ?>">
                                <a href="<?php echo HTTP_ROOT . 'templates/projects'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Template Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                                        <!--<span class="os_sprite temp-icon"></span>-->
                                    <i class="left-menu-icon material-icons">&#xE8F1;</i>
                                    <?php echo __('Template'); ?>
                                </a>
                            </li> 
                        <?php } ?>                        
                    </ul>
                </li>
                <?php if (in_array($GLOBALS['user_subscription']['subscription_id'], array(11, 13)) || 1) { ?>
                    <li class="left_panel_ntother_link_bkp list-10 tour_btn" id="startTourBtn" <?php if ((PAGE_NAME == 'dashboard' && CONTROLLER != "project_reports") || (CONTROLLER == "projects" && PAGE_NAME == "manage" && (!isset($this->request->params['pass'][0]) || $this->request->params['pass'][0] != 'active-grid')) || (CONTROLLER == "users" && PAGE_NAME == "manage")) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                        <a class="btn" href="javascript:void(0);" onclick="return trackEventLeadTracker('Left Panel', 'Quick Tour', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                            <i class="left-menu-icon material-icons">&#xE55D;</i>
                            <span class="mini-sidebar-label"><?php echo __('Quick Tour'); ?></span>
                        </a>
                    </li>
                    <?php if (SES_TYPE == 1 && !in_array(PAGE_NAME, array('subscription', 'pricing', 'downgrade', 'upgrade_member', 'confirmationPage'))) { ?>
                        <li class="left_panel_ntother_link_bkp refafrnd_li">
                            <a class="btn" href="javascript:void(0);" onclick="referAFriend();return trackEventLeadTracker('Left Panel', 'Refer a Friend', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                                <span class="glyphicon glyphicon-bullhorn glyphico_raf"></span>
                                <span class="mini-sidebar-label"><?php echo __('Refer a Friend'); ?></span> 
                            </a>
                        </li>	
                    <?php } ?>
                <?php } ?>
            </ul>
        <?php } else if (in_array(PAGE_NAME, $priving_arr_fun) && SES_ID && SES_TYPE == 1) { ?>
            <ul class="side-nav sidebar-menu">
                <?php if (PAGE_NAME == "upgrade_member" || PAGE_NAME == "downgrade") { ?>
                    <li class="list-1 plan-info-li">
                        <div style="color:#79A9C5;font-size:14px;border-bottom: 1px solid #EFF4F5;">
                            <span class="mini-sidebar-label" style="padding: 10px;margin-top: 0px;display: block;">
                                <?php $all_PAID_plans = Configure::read('CURRENT_PAID_PLANS'); ?>
                                <ul style="list-style: none;margin-left: -33px;">
                                    <?php
                                    $y__m_chk = 'F';
                                    $pln_month = Configure::read('CURRENT_MONTHLY_PLANS');
                                    $pln_yr = Configure::read('CURRENT_YEALY_PLANS');
                                    if (array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_month)) {
                                        $y__m_chk = 'monthly';
                                    } else if (array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_yr)) {
                                        $y__m_chk = 'yearly';
                                    }
                                    ?>
                                    <li title="<?php echo __('This is your current plan'); ?> <br />(<?php echo $user_subscriptions['UserSubscription']['user_limit']; ?> <?php echo __('Users'); ?> & <?php echo ($user_subscriptions['UserSubscription']['storage'] / 1024) . 'GB'; ?> Storage)" style="font-size: 18px;" rel="tooltipi"><?php echo ($y__m_chk == 'F') ? __('Free') : $all_PAID_plans[$user_subscriptions['UserSubscription']['subscription_id']]; ?> <?php echo __('Plan'); ?> </li>
                                    <?php if ($y__m_chk != 'F') { ?>
                                        <li style="font-size:12px;color:#888;font-style: italic;"><?php echo __('billing'); ?> <?php echo $y__m_chk; ?></li>
                                    <?php } ?>
                                </ul>
                            </span>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="subscription_planbtn">
                        <a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Subscription Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Upgrade Now'); ?></a>
                    </li>
                <?php } ?>
                <li class="list-1 <?php
                if (CONTROLLER == "users" && (PAGE_NAME == "pricing" || PAGE_NAME == "downgrade" || PAGE_NAME == "upgrade_member")) {
                    echo 'active';
                }
                ?>">
                    <a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Subscription Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <i class="left-menu-icon material-icons">&#xE064;</i>
                        <span class="mini-sidebar-label"><?php echo __('Subscription'); ?></span>
                    </a>
                </li>
                <li class="list-3 <?php echo (CONTROLLER == "users" && (PAGE_NAME == "creditcard" || PAGE_NAME == "edit_creditcard")) ? 'active' : ''; ?>">
                    <a href="<?php echo HTTP_ROOT . 'users/creditcard'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Credit Card Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <i class="left-menu-icon material-icons">&#xE870;</i>
                        <span class="mini-sidebar-label"><?php echo __('Credit Card'); ?></span>
                    </a>
                </li>
                <li class="list-2 <?php echo (CONTROLLER == "users" && (PAGE_NAME == "transaction")) ? 'active' : ''; ?>">
                    <a href="<?php echo HTTP_ROOT . 'users/transaction'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Transactions Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <i class="left-menu-icon material-icons">&#xE915;</i>
                        <span class="mini-sidebar-label"><?php echo __('Invoices'); ?></span>
                    </a>
                </li>
                <li class="list-4 <?php echo (CONTROLLER == "users" && (PAGE_NAME == "subscription")) ? 'active' : ''; ?>">
                    <a href="<?php echo HTTP_ROOT . 'users/subscription'; ?>" onclick="return trackEventLeadTracker(' Left Panel', 'Subscription Activity Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <i class="left-menu-icon material-icons">&#xE86D;</i>
                        <span class="mini-sidebar-label"><?php echo __('Account Activity'); ?></span>
                    </a>
                </li>
            </ul>
        <?php } ?>
    </div>
    <div class="<?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>rht_content_cmn<?php } else { ?>rht_content_cmn_help<?php } ?> task_lis_page">
        <?php echo $this->element('top_bar'); ?>
        <?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>
            <!-- breadcrumb -->  
            <input type="hidden" id="checkload" value="0">
            <?php //echo $this->element('breadcrumb');      ?>
        <?php } ?>
        <div class="wrapper">
            <?php echo $this->element('popup'); ?>
            <div class="slide_rht_con" <?php if (PAGE_NAME == 'updates') { ?>style="width: 100%;padding: 0px;"<?php } ?>> 
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
            <script>
<?php if ((CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>
                    $('.big-sidebar').find('.template-menu').show();
                    //$('.mini-sidebar').find('.template-menu-parent').addClass('active'); 
<?php } else { ?>
                    $('.template-menu').hide();
<?php } ?>
                    $(function () {
			$('[rel="tooltipi"]').tipsy({
                gravity: 'w',
                fade: true,
				 html: true
            });
                    });
            </script>
<?php $fst_invite = 0; if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13))){
            if (isset($_COOKIE['FIRST_INVITE_2'])) {
                $fst_invite = 1;
            }
            ?>
            <script type="text/javascript">
                    var fst_invite = '<?php echo $fst_invite; ?>';
                    $(function () {
                        if (!localStorage.getItem("OSTOUR") && fst_invite == '1') {
                            setTimeout(startTour, 1000);
                        }
                    });
                    function startTour() {
                        $('#startTourBtn').click();
                        localStorage.setItem("OSTOUR", 1);
                    }
            </script>
        <?php } ?>
        <input type="hidden" value="<?php echo $fst_invite; ?>" id="fst_invite_chk" />
        <?php
        if (isset($_COOKIE['RAF_OTHERS'])) {
            unset($_SESSION['RAF_OTHERS']);
            setcookie('RAF_OTHERS', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);
            if (SES_TYPE == 1) {
                ?>
                <script type="text/javascript">
                        $(function () {
                            referAFriend();
                        });
                </script>
                <?php
            }
        }
        ?>