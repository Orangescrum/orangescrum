<?php if(in_array('dashboard',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<?php if(in_array('projects',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<?php if($_SESSION['project_methodology'] == 'scrum'){ ?>
<?php if(in_array('backlog',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<?php if(in_array('active sprint',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<?php if(in_array('tasks',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
		}else if (DEFAULT_TASKVIEW == 'taskgroups') {
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
	 <?php echo $this->element('view_tasks_menu',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist)); ?>
</li>
<?php } ?>
<?php if(in_array('time log',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<li class="list-7 left_panel_other_link">
	<a href="javascript:void(0);">
		<i class="left-menu-icon material-icons">&#xE619;</i>
		<span class="mini-sidebar-label"><?php echo __('Others');?>...</span>
		<!--<span class="showhide_other_links fr glyphicon glyphicon-menu-right" title="View All Links" rel="tooltip"></span>-->
	</a>					
	<?php //echo $this->element('other_links'); ?>
</li>

<?php if (SES_TYPE < 3) { ?>
<?php if(in_array('gantt chart',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
	<?php } ?>
	<?php if(!$left_smenu_exist || in_array('invoices',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
<li class="sidebar_parent_li menu-invoices <?php
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
<?php } ?>
<?php if(!$left_smenu_exist || in_array('files',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
<li class="sidebar_parent_li menu-files">
	<a href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="return trackEventLeadTracker('Left Panel','Files Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('files');">
		<!--<span class="os_sprite file-icon"></span>-->
		<i class="left-menu-icon material-icons">&#xE2BC;</i>
		<span class="mini-sidebar-label"><?php echo __('Files');?> <span class="cmn_count_no" id="fileCnt" style="display: none;margin-left:5px;"></span></span>
	</a>
</li>
<?php } ?>
<?php if(in_array('kanban',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
<?php } ?>
<?php if (SES_TYPE == 1 || SES_TYPE == 2) { ?>
	<?php if(in_array('users',$checked_left_menu_submenu['checked_left_menu'])){ ?>
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
	<?php } ?>
	<?php if(!$left_smenu_exist || in_array('daily catch-up',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
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
<?php } ?>
<?php $page_array = array('glide_chart', 'hours_report', 'chart', 'weeklyusage_report'); ?>
<?php if(in_array('reports',$checked_left_menu_submenu['checked_left_menu'])){ ?>
<li class="sidebar_parent_li <?php echo (CONTROLLER == "reports" && in_array(PAGE_NAME, $page_array)) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : '';?>">
	<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Analytics','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
		<!--<span class="os_sprite anly-icon"></span>-->
		<i class="left-menu-icon material-icons">&#xE922;</i>
		<span class="mini-sidebar-label"><?php echo __('Analytics');?> <?php echo $this->Format->getlockIcon(); ?></span>
	</a>
</li>
<?php } ?>
<?php if(in_array('miscellaneous',$checked_left_menu_submenu['checked_left_menu'])){ ?>
<li class="sidebar_parent_li hover_arrow_right miscellaneous_li  list_miscl Miscl_list menu-files <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>active_bkp<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow';?><?php } ?>">
	<a href="javascript:void(0)" class="miscl-icon-anchor">
		<!--<span class="os_sprite miscl-icon"></span>-->
		<i class="left-menu-icon material-icons">&#xE53B;</i>
		<span class="mini-sidebar-label-hidden"><?php echo __('Miscellaneous');?></span>
		<?php /*?><span class="glyphicon gly_mis <?php if ((CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) || (CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>glyphicon-menu-down<?php } else { ?> glyphicon-menu-right<?php } ?>"></span><?php */?>
	</a>
	<ul class="hover_sub_menu">
		<?php if(!$left_smenu_exist || in_array('archive',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
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
		<?php } ?>
		<?php if(!$left_smenu_exist || in_array('template',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
		<?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
			<li class="prevent_togl_li list-12 <?php
			if (CONTROLLER == "templates") {
				echo 'active_bk active';
			}
			?>">
				<a href="<?php echo HTTP_ROOT . 'templates/projects'; ?>" onclick="return trackEventLeadTracker('Left Panel','Template Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(CONTROLLER == "templates"){ echo " class='".$sub_text_class."'";} ?>>
						<!--<span class="os_sprite temp-icon"></span>-->
					<i class="left-menu-icon material-icons">&#xE8F1;</i>
					<?php echo __('Template');?>
				</a>
			</li> 
		<?php } ?>
	<?php } ?>		
	</ul>
</li>
<?php } ?>                        