<style type="text/css">

    .new_back_icon {font-size: 14px;left: 10%;margin-top: 90px;position:fixed;top: 29%;z-index: 999;color:#A6A6A6;}
    .left-menu-panel .side-nav li .fixleft-submenu ul li:hover a{color:#F6911D}
    .new_back_icon:hover {color:#0091EA;}
	.left_panel_other_link {display:none;}
    .option_menu_panel .sidebar_parent_li.miscellaneous_li .hover_sub_menu {top: -40px;}
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
      <?php } else if(CONTROLLER == "projects" && (PAGE_NAME == "manage")){/* ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .recent_visited_projects{display:block;}
     .big-sidebar .left_panel_ntother_link,.big-sidebar .view_tasks_menu,.big-sidebar .caseMenuLeft{display:none;}
     //.mini-sidebar .visit_tasks{display:none} 
    <?php */}else{ ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects{display:none;}
     .big-sidebar .left_panel_ntother_link{display:block;}
    <?php } ?>
     <?php if ($_COOKIE['FIRST_INVITE_1']) {  ?>
       .big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects{display:none;}
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

    .left-palen-submenu-items{display:none;}
</style>
<?php $sub_text_class = $this->Format->getsubmenucolor($theme_settings['sidebar_color']); ?> 
<div class="main-container">
    <div class="left-menu-panel<?php echo ' cmn_white_bg';?>"> 
      <aside class="option_menu_panel">
        <?php
        $shw = 1;
        $priving_arr_fun = array("subscription", "transaction", "creditcard", "account_activity", "pricing", 'upgrade_member', 'account_usages', 'downgrade', 'edit_creditcard', 'confirmationPage','cancel_subscription_os');
        $priving_arr_fun = is_array($priving_arr_fun) ? $priving_arr_fun : array();
        if (in_array(PAGE_NAME, $priving_arr_fun)) {
            $shw = 0;
        } ?>
        <div class="fixed_left_nav">
       <?php if (!in_array(PAGE_NAME, array("updates", "help", "tour", "customer_support")) && $shw) {
            ?>
          
            <div>
                <span class="all_create_btn" id="new_onboarding_add_icon">
                        <a onclick="$('.show_new_add_div').toggle();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow'; ?>" id="btn-add-new-all" href="javascript:void(0)"><?php __('New'); ?><div class="ripple-container"></div></a>
                    </span>
                <div class="show_new_add_div new_add_dropdown">
                        <ul class="border-box">
                            <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
                            <li>
                                <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Project');newProject();">
                                    <i class="material-icons cmn-icon-prop">&#xE8F9;</i><?php echo __('Project');?>
                                </a>
                            </li>
                        <?php } ?>
                            <div class="gray-out-sub"></div>
                             <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
                            <li>
                                <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Task');
                                            creatask();">
                                    <i class="material-icons cmn-icon-prop">&#xE862;</i><?php echo __('Task');?>
                                </a>
                            </li>
                        <?php } ?>
                            <?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                                <li >
                                    <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Time Log');
                                                    createlog(0, '')">
                                        <i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry');?>
                                    </a>
                                </li>
                            <?php } ?>
							<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
                            <li class="qadd-tg-icon">
                                <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Task Group');
                                            addEditMilestone('', '', '', '', '', '');">
                                    <i class="material-icons cmn-icon-prop">&#xE065;</i><?php echo __('Task Group');?>
                                </a>
                            </li>
							<?php } ?>
                            <?php if (SES_TYPE < 3) { ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Invite User');
                                                    newUser()">
                                        <i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('User');?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
            </div>
            <ul class="side-nav sidebar-menu">
                 <div class="gray-out"></div>
                <?php if(!empty($checked_left_menu_submenu['checked_left_menu'])){ ?>
					<?php echo $this->element('custom_left_menu_exp',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist,'sub_text_class'=>$sub_text_class));?>
				 <?php }else{ ?>
                <li class="sidebar_parent_li <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "mydashboard")) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                    <a href="<?php echo HTTP_ROOT . 'mydashboard'; ?>" onclick="resetAllProjectFromDbd();return trackEventLeadTracker('Left Panel','Dashboard Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <!--<span class="os_sprite dash-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE871;</i>
                        <span class="mini-sidebar-label"><?php echo __('Dashboard');?></span>
                    </a>
                </li>
                <li class="sidebar_parent_li projectMenuLeft <?php
                if (CONTROLLER == "projects" && (PAGE_NAME == "manage")) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                        <?php
                        $type = $_COOKIE['PROJECTVIEW_TYPE'];
                        $type = explode('_', $type);
                        $projecturl = '';
                        $projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
                        ?>
                    <a href="<?php echo HTTP_ROOT . 'projects/manage' . $projecturl; ?>">
                        <i class="left-menu-icon material-icons">&#xE8F9;</i>
                        <span class="mini-sidebar-label"><?php echo __('Projects');?></span>
                    </a>
					<?php //echo $this->element('recent_visted_projects'); ?>
                </li>
                <?php if($_SESSION['project_methodology'] == 'scrum'){ ?>
				<li class="sidebar_parent_li menu-backlog <?php
				if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
					echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
				}
				?>">				
					<a href="<?php echo HTTP_ROOT . 'dashboard#backlog'; ?>" onclick="trackEventLeadTracker('Left Panel', 'Backlog Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>'); checkHashLoad('backlog');">
						<i class="left-menu-icon material-icons">ballot</i>
						<span class="mini-sidebar-label"><?php echo __('Backlog'); ?> </span>
					</a>
				</li>
				
				<li class="sidebar_parent_li menu-sprint <?php
				if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
					echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
				}
				?>">				
					<a href="<?php echo HTTP_ROOT . 'dashboard#activesprint'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Active Sprint Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>'); checkHashLoad('sprint');">
						<i class="left-menu-icon material-icons">horizontal_split</i>
						<span class="mini-sidebar-label"><?php echo __('Active Sprint'); ?></span>
					</a>
				</li>
        <?php } ?>
                <li class="caseMenuLeft menu-cases sidebar_parent_li hover_arrow_right <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                        <?php
                        $tskurl = '';
                        $onclick = '';
						$ldTrkUrl = '';
                        $tskurl = DEFAULT_TASKVIEW == 'milestonelist' ? 'milestonelist' : 'tasks';
                        if (DEFAULT_TASKVIEW == 'tasks') {
                            $onclick = "checkHashLoad('tasks')";
							$ldTrkUrl = 'Tasks Page';
                        } else if (DEFAULT_TASKVIEW == 'task_group') {
                            $onclick = "return groupby('milestone')";
							$ldTrkUrl = 'Task Group Page';
                        }else if (DEFAULT_VIEW_TASK == 'taskgroups') {
							$tskurl = "taskgroups";
							$onclick = "return ajaxCaseView('taskgroups')";
							$ldTrkUrl = 'Sub-task view';
						} else {
							$onclick = "return checkHashLoad('milestonelist')";
							$ldTrkUrl = 'Task Group Page';
                        }
                        ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $tskurl; ?>" onclick="<?php echo $onclick; ?>;">
                        <!--<span class="os_sprite task-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE862;</i>
                        <span class="mini-sidebar-label"><?php echo __('Tasks');?></span>
                        <?php /*?><span class="visit_tasks fr glyphicon glyphicon-menu-right" title="View Tasks" rel="tooltip"></span><?php */?>
                       
                    </a>
                     <?php echo $this->element('view_tasks_menu'); ?>
                </li>
                <li  class="menu-logs sidebar_parent_li <?php
                if (CONTROLLER == "easycases" && (PAGE_NAME == "timelog") || PAGE_NAME == "resource_utilization" || PAGE_NAME == "resource_availability" ) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                        <?php
                        $timelogurl = '';
						$ldTrkUrl = '';
                        $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
						$ldTrkUrl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'Time Log Calendar Page' : 'Time Log Page';
                        ?>
                    <a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"  >
                        <!--<span class="os_sprite tlog-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE192;</i>
                        <span class="mini-sidebar-label-hidden"><?php echo __('Time Log');?> <small class="new_txt"><?php echo __('New');?></small> <?php echo $this->Format->getlockIcon(); ?></span>
                    </a>
                </li>
				
				<?php /*<li class="list-7 left_panel_other_link">
                    <a href="javascript:void(0);">
                        <i class="left-menu-icon material-icons">&#xE619;</i>
                        <span class="mini-sidebar-label"><?php echo __('Others');?>...</span>
						<!--<span class="showhide_other_links fr glyphicon glyphicon-menu-right" title="View All Links" rel="tooltip"></span>-->
                    </a>					
					<?php //echo $this->element('other_links'); ?>
                </li> */ ?>
				
                <?php if (SES_TYPE < 3) { ?>
					<li class="sidebar_parent_li <?php
					if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {
						echo 'active_bk active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
					}
					?>">
						<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Gantt Chart Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
							<i class="left-menu-icon material-icons">&#xE919;</i>
                            <span class="mini-sidebar-label"><?php echo __('Gantt Chart');?> <?php echo $this->Format->getlockIcon(); ?></span>
						</a>
					</li>
<li class="left_panel_ntother_link menu-invoices list-4 <?php
                    if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) {
                        echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                    }
                    ?>"">
                        <a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Invoice Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <!--<span class="os_sprite invo-icon"></span>-->
                            <i class="left-menu-icon material-icons">&#xE53E;</i>
                            <span class="mini-sidebar-label"><?php echo __('Invoices');?> <?php echo $this->Format->getlockIcon(); ?></span>
                        </a>
                    </li>
                <?php } ?>
				<li class="sidebar_parent_li menu-files">
                    <a href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="return trackEventLeadTracker('Left Panel','Files Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('files');">
                        <!--<span class="os_sprite file-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE2BC;</i>
                        <span class="mini-sidebar-label"><?php echo __('Files');?> <span id="fileCnt" style="display: none;margin-left:5px;"></span></span>
                    </a>
                </li>
				<?php $check_kanban = 1; if(defined('CMP_CREATED') && CMP_CREATED >= '2018-01-17 00:00:59' && SES_COMP != 37731){$check_kanban = 0;}; ?>
				<?php if($check_kanban){ ?>
                <li class="sidebar_parent_li menu-milestone <?php
                if (CONTROLLER == "milestones" && (PAGE_NAME == "milestone")) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
					<?php
                        $kanbanurl = '';
						$ldTrkUrl = '';
                        $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
						$ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
                        ?>
                    <a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT . 'dashboard#' . $kanbanurl;} ?>" onclick="trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('<?php echo $kanbanurl; ?>');">
                        <!--<span class="os_sprite tskg-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE8F0;</i>
                        <span class="mini-sidebar-label"><?php echo __('Kanban');?></span><?php echo $this->Format->getlockIcon(); ?>
                    </a>
                </li>
				<?php } ?>
                <?php if (SES_TYPE == 1 || SES_TYPE == 2) { ?>
                    <li class="sidebar_parent_li <?php
                    if (CONTROLLER == "users" && (PAGE_NAME == "manage")) {
                        echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                    }
                    ?>">
                        <a href="<?php echo HTTP_ROOT . 'users/manage'; ?>">
                            <!--<span class="os_sprite user-icon"></span>-->
                            <i class="left-menu-icon material-icons">&#xE7FD;</i>
                            <span class="mini-sidebar-label"><?php echo __('Users');?></span>
                        </a>
                    </li>
                    <li class="sidebar_parent_li <?php
                    if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) {
                        echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                    }
                    ?>">
                        <a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Daily Catch-up Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <!--<span class="os_sprite dc-icon"></span>-->
                            <i class="left-menu-icon material-icons">&#xE003;</i>
                            <span class="mini-sidebar-label"><?php echo __('Daily Catch-up');?> <?php echo $this->Format->getlockIcon(); ?></span>
                        </a>
                    </li>
                <?php } ?>
                <?php $page_array = array('glide_chart', 'hours_report', 'chart', 'weeklyusage_report'); ?>
                <li class="sidebar_parent_li <?php echo (CONTROLLER == "reports" && in_array(PAGE_NAME, $page_array)) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : '';?>">
                    <a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Analytics','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <!--<span class="os_sprite anly-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE922;</i>
                        <span class="mini-sidebar-label"><?php echo __('Analytics');?> <?php echo $this->Format->getlockIcon(); ?></span>
                    </a>
                </li>
                <li class="sidebar_parent_li hover_arrow_right miscellaneous_li  list_miscl Miscl_list menu-files <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>active_bkp<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow';?><?php } ?>">
                    <a href="javascript:void(0)" class="miscl-icon-anchor">
                        <!--<span class="os_sprite miscl-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE53B;</i>
                        <span class="mini-sidebar-label-hidden"><?php echo __('Miscellaneous');?></span>
                        <?php /*?><span class="glyphicon gly_mis <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>glyphicon-menu-down<?php } else { ?> glyphicon-menu-right<?php } ?>"></span><?php */?>
                    </a>
                    <ul class="hover_sub_menu">
                        <li class="prevent_togl_li list-11 <?php
                        if (CONTROLLER == "archives" && (PAGE_NAME == "listall")) {
                            echo 'active_bk active';
                        }
                        ?>">
                            <a href="<?php echo HTTP_ROOT . 'archives/listall#caselist'; ?>" onclick="return trackEventLeadTracker('Left Panel','Archive Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(CONTROLLER == "archives" && PAGE_NAME == "listall"){ echo " class='".$sub_text_class."'";} ?>>
                                    <!--<span class="os_sprite arch-icon"></span>-->
                                <i class="left-menu-icon material-icons">&#xE149;</i>
                                <?php echo __('Archive');?>
                            </a>
                        </li>
                        <?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
                            <li class="prevent_togl_li list-12 <?php
                            if (CONTROLLER == "templates") {
                                echo 'active_bk active';
                            }
                            ?>">
                                <a href="<?php echo HTTP_ROOT . 'templates/projects'; ?>" onclick="return trackEventLeadTracker('Left Panel','Template Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                        <!--<span class="os_sprite temp-icon"></span>-->
                                    <i class="left-menu-icon material-icons">&#xE8F1;</i>
                                    <?php echo __('Template');?>
                                </a>
                            </li> 
                        <?php } ?>                        
                    </ul>
                </li>
				 <?php } ?>
            </ul>
        <?php } else if (in_array(PAGE_NAME, $priving_arr_fun) && SES_ID && SES_TYPE == 1) { ?>
            <ul class="side-nav sidebar-menu">
				<?php if(PAGE_NAME == "upgrade_member" || PAGE_NAME == "downgrade"){ ?>
				<li class="list-1 plan-info-li">
					<div>
						<span class="mini-sidebar-label">
							<?php $all_PAID_plans = Configure::read('CURRENT_PAID_PLANS'); ?>
							<ul class="plan_info_ul" >
								<?php 
									$y__m_chk = 'F';
									$pln_month = Configure::read('CURRENT_MONTHLY_PLANS');
									$pln_yr = Configure::read('CURRENT_YEALY_PLANS');
									if(array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_month)){
										$y__m_chk = 'monthly';
									} else if(array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_yr)){
										$y__m_chk = 'yearly';
									}
								?>
								<li title="<?php echo __('This is your current plan');?> <br />(<?php echo $user_subscriptions['UserSubscription']['user_limit']; ?> <?php echo __('Users');?> & <?php echo ($user_subscriptions['UserSubscription']['storage']/1024).'GB'; ?> <?php echo __('Storage');?>)" rel="tooltipi"><?php echo ($y__m_chk == 'F')? __('Free'):$all_PAID_plans[$user_subscriptions['UserSubscription']['subscription_id']]; ?> <?php echo __('Plan');?> </li>
								<?php if($y__m_chk != 'F'){ ?>
								<li style="font-size:12px;color:#888;font-style: italic;"><?php echo __('billing');?> <?php echo $y__m_chk; ?></li>
								<?php } ?>
							</ul>
						</span>
					</div>
                </li>
				<?php }else{ ?>
				<li class="subscription_planbtn all_create_btn<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow';?>">
					<a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker('Left Panel','Subscription Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Upgrade Now');?></a>
				</li>
				<?php } ?>
                <li class="sidebar_parent_li <?php
                if (CONTROLLER == "users" && (PAGE_NAME == "subscription" || PAGE_NAME == "downgrade" || PAGE_NAME == "upgrade_member")) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                    <a href="<?php echo HTTP_ROOT . 'users/subscription'; ?>" onclick="return trackEventLeadTracker('Left Panel','Subscription Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <i class="left-menu-icon material-icons">&#xE064;</i>
                        <span class="mini-sidebar-label"><?php echo __('Overview');?></span>
                    </a>
                </li>
				<?php /*<li class="list-3 <?php echo (CONTROLLER == "users" && (PAGE_NAME == "creditcard" || PAGE_NAME == "edit_creditcard")) ? 'active' : '';?>">
                    <a href="<?php echo HTTP_ROOT . 'users/creditcard'; ?>" onclick="return trackEventLeadTracker('Left Panel','Credit Card Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <i class="left-menu-icon material-icons">&#xE870;</i>
                        <span class="mini-sidebar-label"><?php echo __('Credit Card');?></span>
                    </a>
                </li> */ ?>
				
                <li class="sidebar_parent_li <?php echo (CONTROLLER == "users" && (PAGE_NAME == "pricing")) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : '';?>">
                    <a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker('Left Panel','Subscription pricing','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <i class="left-menu-icon material-icons">&#xE86D;</i>
                        <span class="mini-sidebar-label"><?php echo __('Plan');?></span>
                    </a>
                </li>
                <li class="sidebar_parent_li <?php echo (CONTROLLER == "users" && (PAGE_NAME == "transaction")) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : '';?>">
                    <a href="<?php echo HTTP_ROOT . 'users/transaction'; ?>" onclick="return trackEventLeadTracker('Left Panel','Transactions Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <i class="left-menu-icon material-icons">&#xE915;</i>
                        <span class="mini-sidebar-label"><?php echo __('Invoices');?></span>
                    </a>
                </li>
            </ul>
            <?php /* <span><a class="new_back_icon" href="<?php echo HTTP_ROOT . 'mydashboard'; ?>" title="Back to Dashboard" rel="tooltip" onclick="return trackEventLeadTracker('Left Panel','Dashboard Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE5C4;</i></a></span> */ ?>
        <?php } ?>
    </div>
      </aside>
    </div>
    <div class="<?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>rht_content_cmn<?php } else { ?>rht_content_cmn_help<?php } ?> task_lis_page">
        <?php echo $this->element('top_bar'); ?>
        <?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>
            <!-- breadcrumb -->  
            <input type="hidden" id="checkload" value="0">
            <?php //echo $this->element('breadcrumb');   ?>
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
        <?php }else{ ?>
         $('.template-menu').hide();        
        <?php } ?>
		$(function(){
			$('[rel="tooltipi"]').tipsy({
                gravity: 'w',
                fade: true,
				 html: true
            });
		});
    </script>
     <script>
            $(document).ready(function(){
                expandLeftSubmenu();
            });
            function expandLeftSubmenu(){
               $(".left-palen-submenu-items").hide();
                if(getHash() =='timelog' || getHash() =='timesheet_weekly' ||  getHash() =='timesheet_daily' || PAGE_NAME=="resource_utilization" || PAGE_NAME=="resource-availability" ||  getHash() =='chart_timelog' ||  getHash() =='calendar_timelog'){
                    $(".menu-logs").find('.left-palen-submenu').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                    $(".menu-logs").find('.left-palen-submenu-items').show();

                }
                if(getHash() =='files' || getHash() =='caselist' || PAGE_NAME=="invoice" || PAGE_NAME=="groupupdatealerts" ||  CONTROLLER =='templates'){
                    $(".Miscl_list").find('.left-palen-submenu').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                    $(".Miscl_list").find('.left-palen-submenu-items').show();

                }
                if(getHash() =='tasks' || getHash() =='taskgroup' || getHash() =='kanban' || getHash() =='calendar' || getHash() =='details' || getHash() =='milestonelist'){
                    $(".caseMenuLeft").find('.left-palen-submenu').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                    $(".caseMenuLeft").find('.left-palen-submenu-items').show();

                } 
                <?php if((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports' || in_array(PAGE_NAME, $page_array))){ ?>

                    $(".projectReportMenuLeft").find('.left-palen-submenu').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                    $(".projectReportMenuLeft").find('.left-palen-submenu-items').show();
                <?php } ?>
               hasLeftScrollBar();
            }
        </script>