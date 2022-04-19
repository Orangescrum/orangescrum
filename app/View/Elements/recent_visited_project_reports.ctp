<ul class="left-palen-submenu-items_bkp hover_sub_menu">
    <li class="head_li_tmp">
        <a href="<?php echo HTTP_ROOT ?>project_reports/dashboard" >
            <?php echo __('All Reports'); ?>
        </a>
    </li>
	<li class="head_li">
        <a href="javascript:void(0)" style="cursor:default;">
            <?php echo __('Task Analysis Report'); ?>
        </a>
    </li>
	<li class="reports_submenu no_hover_bg">
		<ul class="hover_child_submenu">
			<?php if(!$left_smenu_exist || in_array('sprint report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'completed_sprint_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/completed_sprint_report" title="<?php echo __('Sprint Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Sprint Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" class="left_report_sprint<?php if(PAGE_NAME == 'completed_sprint_report' ){ echo " ".$sub_text_class;} ?>">
					<?php echo __('Sprint Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('velocity chart',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'velocity_reports' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/velocity_reports" title="<?php echo __('Velocity Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Velocity Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"  class="left_report_velocity<?php if(PAGE_NAME == 'velocity_reports' ){ echo " ".$sub_text_class;} ?>">
					<?php echo __('Velocity Chart'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('sprint burndown report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
		   <li  <?php if(PAGE_NAME == 'sprint_burndown_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/sprint_burndown_report" title="<?php echo __('Sprint Burndown Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Sprint Burndown Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'sprint_burndown_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Sprint Burndown Report'); ?>
				</a>
			</li>
			<?php }  ?>
			<?php if(!$left_smenu_exist || in_array('average age report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'average_age_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/average_age_report" title="<?php echo __('Average Age Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Average Age Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'average_age_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Average Age Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('created vs. resolved tasks report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li  <?php if(PAGE_NAME == 'create_resolve_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/create_resolve_report" title="<?php echo __('Created vs. Resolved Tasks Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Created vs. Resolved Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'create_resolve_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Created vs. Resolved Tasks Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('pie chart report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li  <?php if(PAGE_NAME == 'pie_chart_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/pie_chart_report" title="<?php echo __('Pie Chart Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Pie Chart Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'pie_chart_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Pie Chart Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('recently created tasks report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li  <?php if(PAGE_NAME == 'recent_created_task_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/recent_created_task_report" title="<?php echo __('Recently Created Tasks Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Recently Created Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'recent_created_task_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Recently Created Tasks Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('resolution time report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li  <?php if(PAGE_NAME == 'resolution_time_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/resolution_time_report" title="<?php echo __('Resolution Time Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Resolution Time Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'resolution_time_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Resolution Time Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('time since tasks report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
		   <li  <?php if(PAGE_NAME == 'time_since_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/time_since_report" title="<?php echo __('Time Since Tasks Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Time Since Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'time_since_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Time Since Tasks Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(SES_TYPE < 3){
			if(!$left_smenu_exist || in_array('resource allocation report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
		   <li  <?php if(PAGE_NAME == 'resource_allocation_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>project_reports/resource_allocation_report" title="<?php echo __('Resource Allocation Report'); ?>" onclick="return trackEventLeadTracker('Left Panel','Resource Allocation Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'resource_allocation_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Resource Allocation Report'); ?>
				</a>
			</li>
			<?php } } ?>
		</ul>
	</li>
  <?php /*?>  <li class="head_li">
        <a href="javascript:void(0)" >
            <?php echo __('Forecast Report'); ?>
        </a>
    </li>
	<li class="reports_submenu">
		<ul>
			<li>
				<a href="#" >
					<?php echo __('User Workload Report'); ?>
				</a>
			</li>
			<li>
				<a href="#" >
					<?php echo __('Task group/sprint Workload Report'); ?>
				</a>
			</li>
			<li>
				<a href="#" >
					<?php echo __('Workload Pie Chart Report'); ?>
				</a>
			</li>
		</ul>
	</li> <?php */ ?>
    <li class="head_li">
        <a href="javascript:void(0)" style="cursor:default;">
            <?php echo __('Others'); ?>
        </a>
    </li>
	<li class="reports_submenu no_hover_bg">
		<ul class="hover_child_submenu">
			<?php if(!$left_smenu_exist || in_array('hours spent report',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'hours_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>hours-report/" title="<?php echo __('Hours Spent Report'); ?>"  onclick="return trackEventLeadTracker('Left Panel','Hours Spent Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'hours_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Hours Spent Report'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || in_array('tasks reports',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'chart' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>task-report/" title="<?php echo __('Task Reports'); ?>" onclick="return trackEventLeadTracker('Left Panel','Task Reports','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'chart' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Task Reports'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(SES_TYPE <= 2){ ?>
			<?php if(!$left_smenu_exist || in_array('weekly usage',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
			<li <?php if(PAGE_NAME == 'weeklyusage_report' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>reports/weeklyusage_report" title="<?php echo __('Weekly Usage'); ?>" onclick="return trackEventLeadTracker('Left Panel','Weekly Usage','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'weeklyusage_report' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Weekly Usage'); ?>
				</a>
			</li>
			<?php } ?>
			<?php if(!$left_smenu_exist || (in_array('resource utilization',$checked_left_menu_submenu['checked_left_submenus']) && array_key_exists('reports',$checked_left_menu_submenu['m_s_array']) && in_array('resource utilization',$checked_left_menu_submenu['m_s_array']['reports']))){ ?>
			<li <?php if(PAGE_NAME == 'resource_utilization' ){ echo "class='active'";} ?>>
				<a href="<?php echo HTTP_ROOT ?>resource-utilization/" title="<?php echo __('Resource Utilization'); ?>" onclick="return trackEventLeadTracker('Left Panel','Resource Utilization','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"<?php if(PAGE_NAME == 'resource_utilization' ){ echo " class='".$sub_text_class."'";} ?>>
					<?php echo __('Resource Utilization'); ?>
				</a>
			</li>
			<?php } ?>			
			<?php } ?>
		</ul>
	</li>
</ul>