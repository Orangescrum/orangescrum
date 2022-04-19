<?php if(in_array('dashboard',$checked_left_menu_submenu['checked_left_menu'])){ ?>
<?php if($this->Format->isAllowed('View Dashboard',$roleAccess)){ ?> 
                <li class="sidebar_parent_li <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "mydashboard")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
<a href="<?php echo HTTP_ROOT . 'mydashboard'; ?>" onclick="resetAllProjectFromDbd();return trackEventLeadTracker('Left Panel','Dashboard Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <i class="left-menu-icon material-icons">&#xE871;</i>
                        <span class="mini-sidebar-label"><?php echo __('Dashboard');?></span>
                    </a>
                </li>
            <?php } ?>
			<?php } ?>
			<?php if(in_array('projects',$checked_left_menu_submenu['checked_left_menu'])){ ?>
                <?php if($this->Format->isAllowed('View Project',$roleAccess)){ ?> 
                <li class="sidebar_parent_li projectMenuLeft <?php if (CONTROLLER == "projects" && (PAGE_NAME == "manage")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
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
                </li>
            <?php } ?>
            <?php } ?>
			<?php if($_SESSION['project_methodology'] == 'scrum'){ ?>
			<?php if(in_array('backlog',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<li class="sidebar_parent_li menu-backlog <?php	if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {echo '';}?>">				
					<a href="<?php echo HTTP_ROOT . 'dashboard#backlog'; ?>" onclick="return checkHashLoad('backlog');">
						<i class="left-menu-icon material-icons">ballot</i>
						<span class="mini-sidebar-label"><?php echo __('Backlog'); ?> </span>
					</a>
				</li>
				<?php } ?>
				<?php if(in_array('active sprint',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php if(!$exp_plan){ ?>
        <li class="sidebar_parent_li menu-sprint <?php
				if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
					echo '';
				}
				?>">				
					<a href="<?php echo HTTP_ROOT . 'dashboard#activesprint'; ?>" onclick="return checkHashLoad('sprint');">
						<i class="left-menu-icon material-icons">horizontal_split</i>
						<span class="mini-sidebar-label"><?php echo __('Active Sprint'); ?></span>
					</a>
				</li>
				<?php }else{ ?>
					<li class="left_panel_ntother_link menu-sprint list-4 <?php
				if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {
					echo '';
				}
				?>">				
					<a href="javascript:showUpgradPopup(1);">
						<i class="left-menu-icon material-icons">horizontal_split</i>
						<span class="mini-sidebar-label"><?php echo __('Active Sprint'); ?> <?php echo $this->Format->getlockIcon(); ?></span>
					</a>
				</li>
				<?php } ?>
				<?php } ?>
				<?php if(in_array('reports',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php if(!$exp_plan){ ?>
        <li class="sidebar_parent_li hover_arrow_right projectReportMenuLeft <?php
                if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array) || CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports')) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                    <a href="<?php echo HTTP_ROOT . 'project_reports/dashboard' ; ?>">
                        <i class="left-menu-icon material-icons">&#xE922;</i>
                        <span class="mini-sidebar-label"><?php echo __('Reports'); ?></span>
                        <?php /*?><span class="left-palen-submenu fr glyphicon <?php if (CONTROLLER == "project_reports" && (PAGE_NAME == "dashboard") || in_array(PAGE_NAME, $page_array)) {echo 'glyphicon-menu-down';} else {echo 'glyphicon-menu-right';}?>" title="<?php echo __('View Last Visited Reports');?>" rel="tooltip"></span><?php */?>
                    </a>					
                    <?php echo $this->element('recent_visited_project_reports',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist,'sub_text_class'=>$sub_text_class)); ?>
                </li>
				<?php }else{ ?>
					<li class="left_panel_ntother_link list-10 <?php
                if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array) || CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports')) {
                    echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
                }
                ?>">
                    <a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Analytics','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <!--<span class="os_sprite anly-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE922;</i>
                        <span class="mini-sidebar-label"><?php echo __('Reports'); ?> <?php echo $this->Format->getlockIcon(); ?></span>
                    </a>
                </li>
				<?php } ?>
				<?php } ?>
				<?php if(in_array('tasks',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<li class="caseMenuLeft menu-cases sidebar_parent_li hover_arrow_right <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
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
                                $ldTrkUrl = 'Sub Task Group View';
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
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $tskurl; ?>" onclick="<?php echo $onclick; ?>;" id="left_menu_nav_tour">
                        <!--<span class="os_sprite task-icon"></span>-->
                        <i class="left-menu-icon material-icons">&#xE862;</i>
                        <span class="mini-sidebar-label"><?php echo __('Tasks'); ?></span>

                    </a>
                    <?php echo $this->element('view_tasks_menu',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist)); ?>
                </li>
				<?php } ?>
			<?php }else{ ?>
			<?php if(in_array('tasks',$checked_left_menu_submenu['checked_left_menu'])){ ?>
                <li class="caseMenuLeft menu-cases sidebar_parent_li hover_arrow_right <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
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
                            }else if (DEFAULT_VIEW_TASK == 'taskgroups') {
                                $tskurl = "taskgroups";
                                $onclick = "return ajaxCaseView('taskgroups')";
                                $ldTrkUrl = 'Sub-task view';
							} else {
                                $onclick = "return checkHashLoad('milestonelist')";
                                $ldTrkUrl = 'Task Group Page';
                            }
                        }
                        ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $tskurl; ?>" onclick="<?php echo $onclick; ?>;"  id="left_menu_nav_tour">
                        <i class="left-menu-icon material-icons">&#xE862;</i>
                        <span class="mini-sidebar-label"><?php echo __('Tasks'); ?></span>

                    </a>
                    <?php echo $this->element('view_tasks_menu',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist)); ?>
                </li>
				<?php } ?>				
			<?php } ?>
			<?php if(in_array('time log',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php if(!$exp_plan){ ?>
                <li  class="menu-logs sidebar_parent_li hover_arrow_right list_miscl relative miscl-icon-li <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "timelog")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
                         <?php
                         $timelogurl = '';
                         $ldTrkUrl = '';
                         $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
                         $ldTrkUrl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'Time Log Calendar Page' : 'Time Log Page';
                         ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" onclick="return trackEventLeadTracker('Left Panel', '<?php echo $ldTrkUrl; ?>', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');return checkHashLoad('timelog');"  >
                        <i class="left-menu-icon material-icons">&#xE192;</i>
                        <span class="mini-sidebar-label"><?php echo __('Time Log List View'); ?></span>
                        <?php /*?><span class="left-palen-submenu fr glyphicon glyphicon-menu-right" title="<?php echo __('View Timelog');?>" rel="tooltip"></span><?php */?>
                    </a>
                    <ul class="hover_sub_menu">
					<?php if(!$left_smenu_exist || in_array('time log list view',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                      <li class="prevent_togl_li list-11 menu_logs_cmn menu_logs_timelog">
                        <a onclick="return trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('timelog');" href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" <?php if(PAGE_NAME != "resource_availability" && PAGE_NAME != "resource_utilization"){ echo "class='activesmenu'";} ?> title="<?php echo __('Time Log List View');?>">
                            <?php 
                                if(DEFAULT_TIMELOGVIEW == 'calendar_timelog'){
                                    echo __('Calender View');
                                }else{
                                    echo __('Time Log List View');
                                }
                            ?>
                          </a>							
                      </li>
					  <?php } ?>
					  <?php if(!$left_smenu_exist || in_array('weekly timesheet',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                        <?php if ($this->Format->isTimesheetOn()) { ?>
                            <!-- <li class="prevent_togl_li_bkp  menu_logs_cmn menu_logs_wtsht">
                                <a id="timesheet_btn_timelog" onclick="return trackEventLeadTracker('Weekly Timesheet', 'Left Menu', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="<?php echo HTTP_ROOT . 'dashboard#timesheet_weekly'; ?>" title=" <?php echo __('Weekly Timesheet'); ?>"><?php echo __('Weekly Timesheet'); ?></a>
                            </li>						 -->
                        <?php } else { ?>
                            <li class="prevent_togl_li_bkp  menu_logs_cmn menu_logs_wtsht">
                                <a onclick="showUpgradPopup(0, 1);" href="javascript:void(0);" title="<?php echo __('Weekly Timesheet'); ?>"> <?php echo __('Weekly Timesheet'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                            </li>
                        <?php } ?>
						<?php } ?>
						<?php /* if(!$left_smenu_exist || (in_array('resource utilization',$checked_left_menu_submenu['checked_left_submenus']) && array_key_exists('time log',$checked_left_menu_submenu['m_s_array']) && in_array('resource utilization',$checked_left_menu_submenu['m_s_array']['time log']))){ ?>
                        <?php if ($this->Format->isAllowed('View Resource Utilization',$roleAccess)) { ?>
                            <?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
                            <li class="prevent_togl_li list-12 <?php if (PAGE_NAME == "resource_utilization") {echo 'active_bk active';}?> menu_logs_cmn menu_logs_ru">
							 <a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-utilization/" ?>" <?php if(PAGE_NAME == "resource_utilization"){ echo "class='active'";} ?> title="<?php echo __('Resource Utilization');?>">
                                  <?php echo __('Resource Utilization'); ?>
                                </a>
                            </li> 
                        <?php } } ?>
						<?php } ?>
						<?php if(!$left_smenu_exist || in_array('resource availability',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                        <li class="prevent_togl_li list-12 <?php if (PAGE_NAME == "resource_availability") {echo 'active_bk active';}?>">
                                <?php
                                if ($this->Format->isAllowed('View Resource Availability',$roleAccess)) {
                                    if($this->Format->isAllowed('View Resource Availability',$roleAccess)){
                                    if ($this->Format->isResourceAvailabilityOn('upgrade')) {
                                        if ($this->Format->isResourceAvailabilityOn('status')) {
                                            ?>              
                                <a onclick="return trackEventLeadTracker('Left Panel','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-availability/" ?>" <?php if(PAGE_NAME == "resource_availability"){ echo "class='active".' '.$sub_text_class."'";} ?> title=" <?php echo __('Resource Availability');?>">
                                            <?php echo __('Resource Availability'); ?>
                                        </a>
                            <?php }}else{ ?>
                                    <a onclick="showUpgradPopup(0, 1, 1); trackEventLeadTracker('Left Panel', 'Resource Availability Report', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="javascript:void(0);" class="upgradeLink" title=" <?php echo __('Resource Availability'); ?>"><?php echo __('Resource Availability'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
                        <?php }
                    }
                            }?>
                        </li>
							<?php } */ ?>
                    </ul>

                </li>
				<?php }else { ?>
					<li  class="menu-logs left_panel_ntother_link list-3  list_miscl relative miscl-icon-li <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "timelog") || PAGE_NAME == "resource_availability") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
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
				<?php } ?>	
				
				<?php if(in_array('resource mgmt',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php if(!$exp_plan){ ?>
					<?php if ($this->Format->isAllowed('View Resource Utilization',$roleAccess) || $this->Format->isAllowed('View Resource Availability',$roleAccess)) { ?>
                <li  class="sidebar_parent_li hover_arrow_right list_miscl relative <?php if (PAGE_NAME == "resource_utilization" || PAGE_NAME == "resource_availability") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">				
										<?php if ($this->Format->isAllowed('View Resource Utilization',$roleAccess)) { ?>
											<?php if(!$left_smenu_exist || (in_array('resource utilization',$checked_left_menu_submenu['checked_left_submenus']) && array_key_exists('time log',$checked_left_menu_submenu['m_s_array']) && in_array('resource utilization',$checked_left_menu_submenu['m_s_array']['resource mgmt']))){ ?>
											<a href="<?php echo HTTP_ROOT."resource-utilization/"; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Resource Management', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"  >
													<i class="left-menu-icon material-icons">group_work</i>
													<span class="mini-sidebar-label"><?php echo __('Resource Mgmt'); ?></span>
											</a>
											<?php }else{ ?>
											<a href="javascript:void(0);" onclick="return trackEventLeadTracker('Left Panel', 'Resource Management', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"  >
													<i class="left-menu-icon material-icons">group_work</i>
													<span class="mini-sidebar-label"><?php echo __('Resource Mgmt'); ?></span>
											</a>
											<?php } ?>
										<?php }else{ ?>
                    <a href="javascript:void(0);" onclick="return trackEventLeadTracker('Left Panel', 'Resource Management', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"  >
                        <i class="left-menu-icon material-icons">group_work</i>
                        <span class="mini-sidebar-label"><?php echo __('Resource Mgmt'); ?></span>
                    </a>
										<?php } ?>
                    <ul class="hover_sub_menu">
										<?php if(!$left_smenu_exist || (in_array('resource utilization',$checked_left_menu_submenu['checked_left_submenus']) && array_key_exists('time log',$checked_left_menu_submenu['m_s_array']) && in_array('resource utilization',$checked_left_menu_submenu['m_s_array']['resource mgmt']))){ ?>
													<?php if ($this->Format->isAllowed('View Resource Utilization',$roleAccess)) { ?>
															<?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
															<li class="prevent_togl_li list-12 <?php if (PAGE_NAME == "resource_utilization") {echo 'active_bk active';}?> menu_logs_cmn menu_logs_ru">
																		<a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-utilization/"; ?>" <?php if(PAGE_NAME == "resource_utilization"){ echo "class='active ".$sub_text_class."'";} ?> title="<?php echo __('Resource Utilization');?>">
																		<?php echo __('Resource Utilization'); ?>
																	</a>
															</li> 
													<?php } } ?>
										<?php } ?>
										<?php if(!$left_smenu_exist || in_array('resource availability',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
																<li class="prevent_togl_li list-12 <?php if (PAGE_NAME == "resource_availability") {echo 'active_bk active';}?>">
																				<?php
																				if ($this->Format->isAllowed('View Resource Availability',$roleAccess)) {
																						if($this->Format->isAllowed('View Resource Availability',$roleAccess)){
																						if ($this->Format->isResourceAvailabilityOn('upgrade')) {
																								if ($this->Format->isResourceAvailabilityOn('status')) {
																										?>              
																				<a onclick="return trackEventLeadTracker('Left Panel','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-availability/" ?>" <?php if(PAGE_NAME == "resource_availability"){ echo "class='active".' '.$sub_text_class."'";} ?> title=" <?php echo __('Resource Availability');?>">
																										<?php echo __('Resource Availability'); ?>
																								</a>
																		<?php }}else{ ?>
																						<a onclick="showUpgradPopup(0, 1, 1); trackEventLeadTracker('Left Panel', 'Resource Availability Report', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="javascript:void(0);" class="upgradeLink" title=" <?php echo __('Resource Availability'); ?>"><?php echo __('Resource Availability'); ?> <?php echo $this->Format->getlockIcon(1); ?></a>
																<?php }
														}
																		}?>
																</li>
											<?php } ?>
                    </ul>

                </li>
							<?php } ?>
							<?php } ?>
				<?php } ?>	

				<?php if(in_array('users',$checked_left_menu_submenu['checked_left_menu'])){ ?>
                <?php if ($this->Format->isAllowed('View Users',$roleAccess) ) { ?>
                   <?php if($this->Format->isAllowed('View Users',$roleAccess) ) { ?>
                    <li class="sidebar_parent_li <?php if (CONTROLLER == "users" && (PAGE_NAME == "manage")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
                        <a href="<?php echo HTTP_ROOT . 'users/manage'; ?>">
                            <i class="left-menu-icon material-icons">&#xE7FD;</i>
                            <span class="mini-sidebar-label"><?php echo __('Users'); ?></span>
                        </a>
                    </li>
                <?php } ?>
						<?php } ?>
				<?php } ?>
				
				<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
					<?php if(in_array('reports',$checked_left_menu_submenu['checked_left_menu'])){ ?>
					<?php if(!$exp_plan){ ?>
					<li class="sidebar_parent_li hover_arrow_right projectReportMenuLeft  <?php if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array))) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
											<a href="<?php echo HTTP_ROOT . 'project_reports/dashboard' ; ?>">
													<i class="left-menu-icon material-icons">&#xE922;</i>
													<span class="mini-sidebar-label"><?php echo __('Reports'); ?></span>
													<?php /*<span class="left-palen-submenu fr glyphicon 
													<?php if((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports' || in_array(PAGE_NAME, $page_array))){ ?>
															glyphicon-menu-down
													<?php }else{ ?>
													glyphicon-menu-right
											<?php } ?>
													" title="<?php echo __('View Last Visited Reports');?>" rel="tooltip"></span><?php */?>
											</a>					
											<?php echo $this->element('recent_visited_project_reports',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist,'sub_text_class'=>$sub_text_class)); ?>
									</li>
					<?php }else{ ?>
						<li class="left_panel_ntother_link list-10 <?php if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array) || CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports')) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
											<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Analytics','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
													<!--<span class="os_sprite anly-icon"></span>-->
													<i class="left-menu-icon material-icons">&#xE922;</i>
													<span class="mini-sidebar-label"><?php echo __('Reports'); ?> <?php echo $this->Format->getlockIcon(); ?></span>
											</a>
									</li>
					<?php } ?>				
				<?php } ?>
			<?php } ?>
				
				
				<?php /*<li class="left_panel_other_link">
                    <a href="javascript:void(0);">
                        <i class="left-menu-icon material-icons">&#xE619;</i>
                        <span class="mini-sidebar-label"><?php echo __('Others'); ?>...</span>
                    </a>					
				</li> */ ?>
				
			<?php /* if(in_array('gantt chart',$checked_left_menu_submenu['checked_left_menu'])){ ?>
                <?php if ($this->Format->isAllowed('View Gantt Chart',$roleAccess)) { ?>
                    <?php if( $this->Format->isAllowed('View Gantt Chart',$roleAccess)){?>
					<?php if(!$exp_plan){ ?>
                    <li class="sidebar_parent_li prevent_togl_li_bkp <?php if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {echo 'active_bk active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
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
					<?php }else{ ?>
					<?php if (SES_TYPE < 3) { ?>
					<li class="left_panel_ntother_link prevent_togl_li list-13 <?php if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {echo 'active_bk active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Gantt Chart Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
							<i class="left-menu-icon material-icons">&#xE919;</i>
                            <span class="mini-sidebar-label"><?php echo __('Gantt Chart');?> <?php echo $this->Format->getlockIcon(); ?></span>
						</a>
					</li>
                <?php } ?>
				<?php }?>
                <?php } ?>
                <?php } ?>
				<?php } */ ?>
				
				<?php if(in_array('status workflow',$checked_left_menu_submenu['checked_left_menu'])){ ?>				
				<?php	if(SES_TYPE < 3){ ?>
						<?php	if($this->Format->isTimesheetOn(5)){ ?>
						<li class="sidebar_parent_li menu-status_workflow <?php if (PAGE_NAME == "manage_task_status_group") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a onclick="trackEventLeadTracker('Quick Links','Workflow Setting','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT.'workflow-setting'; ?>" title="<?php echo __('Status Workflow Setting');?>">
							<i class="left-menu-icon material-icons">perm_data_setting</i>
							<span class="mini-sidebar-label"><?php echo __('Status Workflow');?></span>
							</a>
						</li>
						<?php }else{ ?>
						<li class="sidebar_parent_li left_panel_ntother_link menu-status_workflow <?php if (PAGE_NAME == "manage_task_status_group") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a onclick="showUpgradPopup(0,0,0,1);" href="javascript:void(0);" title="<?php echo __('Status Workflow Setting');?>">
							<i class="left-menu-icon material-icons">perm_data_setting</i>
							<span class="mini-sidebar-label"><?php echo __('Status Workflow');?> <?php echo $this->Format->getlockIcon(1); ?></span>
						</a>
						</li>
						<?php } ?>
				<?php } ?>				
				<?php } ?>	
				
				<?php /*
				<?php if(in_array('template',$checked_left_menu_submenu['checked_left_menu'])){ ?>				
				<?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
					<li class="sidebar_parent_li menu-status_workflow <?php if (CONTROLLER == "templates") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a onclick="return trackEventLeadTracker('Left Panel', 'Template Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="<?php echo HTTP_ROOT.'templates/projects'; ?>" id="tour_sts_work_flow_setting" title="<?php echo __('Template');?>">
							<i class="left-menu-icon material-icons">&#xE8F9;</i>
							<span class="mini-sidebar-label"><?php echo __('Template');?></span>
						</a>
					</li>
				<?php } ?>				
                <?php } ?>
				
				 if(in_array('wiki',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php
					if (stristr($_SERVER['SERVER_NAME'], 'sandeep.com') || (stristr($_SERVER['SERVER_NAME'], 'orangescrum.com') && (SES_COMP == 1 || SES_COMP == 28528)) || $this->Format->isWikiOn()){				
				?>
                <?php if($this->Format->isAllowed('View Wiki',$roleAccess)){ ?>
				<?php if(!$exp_plan){ ?>
        <li <?php echo $displayWikiNone; ?> class="sidebar_parent_li menu-wiki <?php if (CONTROLLER == "Wiki" && (PAGE_NAME == "wikidetails")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
                    <a href="<?php echo HTTP_ROOT . 'wiki-details'; ?>">
                        <span class="wiki_icon"></span>
						<span class="mini-sidebar-label"><?php echo __('Wiki'); ?></span><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __('New');?></sup>
                    </a>
                </li>
				<?php }else{ ?>
					<li <?php echo $displayWikiNone; ?> class="left_panel_ntother_link list-5 menu-wiki <?php if (CONTROLLER == "Wiki" && (PAGE_NAME == "wikidetails")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
                    <a href="<?php echo HTTP_ROOT . 'wiki-details'; ?>">
                        <span class="wiki_icon"></span>
						<span class="mini-sidebar-label"><?php echo __('Wiki'); ?> <?php echo $this->Format->getlockIcon(); ?></span><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __('New');?></sup>
                    </a>
                </li>
				<?php } ?>
				<?php } ?>
                <?php } ?>
                <?php } ?>
				<?php if(in_array('kanban',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<?php $check_kanban = 1; if(defined('CMP_CREATED') && CMP_CREATED >= '2018-01-17 00:00:59' && SES_COMP != 37731){$check_kanban = 0;}; ?>
                <?php if ($check_kanban) { ?>
				<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
                    <?php if($this->Format->isAllowed('View Kanban',$roleAccess)){ ?>
                    <li class="sidebar_parent_li menu-milestone <?php if (CONTROLLER == "milestones" && (PAGE_NAME == "milestone")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
                            <?php
                            $kanbanurl = '';
                            $ldTrkUrl = '';
                            $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
                            $ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
                            ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#' . $kanbanurl; ?>" onclick="trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('<?php echo $kanbanurl; ?>');">
                            <i class="left-menu-icon material-icons">&#xE8F0;</i>
                            <span class="mini-sidebar-label"><?php echo __('Kanban'); ?></span>
                        </a>
                    </li>
                <?php } ?>
                <?php } ?>
                <?php } ?>
				<?php } */ ?>
				
				<?php if(in_array('more',$checked_left_menu_submenu['checked_left_menu'])){ ?>
				<li  class="sidebar_parent_li hover_arrow_right miscellaneous_li  list_miscl Miscl_list menu-files <?php if (CONTROLLER == "templates" || (CONTROLLER == "archives" && PAGE_NAME == "listall") || (CONTROLLER == "projects" && PAGE_NAME == "groupupdatealerts") || (CONTROLLER == "easycases" && PAGE_NAME == "invoice") || CONTROLLER == "Wiki") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">				
					<a href="javascript:void(0);" onclick="return trackEventLeadTracker('Left Panel', 'Miscellaneous', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');return checkHashLoad('timelog');"  >
							<i class="left-menu-icon material-icons">&#xE53B;</i>
							<span class="mini-sidebar-label"><?php echo __('More'); ?></span>
					</a>
					<ul class="hover_sub_menu">					
					
					<?php if(!$left_smenu_exist || in_array('wiki',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
					<?php
					if (stristr($_SERVER['SERVER_NAME'], 'sandeep.com') || (stristr($_SERVER['SERVER_NAME'], 'orangescrum.com') && (SES_COMP == 1 || SES_COMP == 28528)) || $this->Format->isWikiOn()){	?>
					<?php if($this->Format->isAllowed('View Wiki',$roleAccess)){ ?>
						<?php if(!$exp_plan){ ?>
						<li <?php echo $displayWikiNone; ?> class="menu-wiki <?php if (CONTROLLER == "Wiki" && (PAGE_NAME == "wikidetails")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
									<a href="<?php echo HTTP_ROOT . 'wiki-details'; ?>" class="<?php if (CONTROLLER == "Wiki") { echo 'active'.' '.$sub_text_class; } ?>">
										<span class="mini-sidebar-label"><?php echo __('Wiki'); ?></span><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __('New');?></sup>
									</a>
							</li>
					<?php }else{ ?>
							<li <?php echo $displayWikiNone; ?> class="left_panel_ntother_link list-5 menu-wiki <?php if (CONTROLLER == "Wiki" && (PAGE_NAME == "wikidetails")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
									<a href="<?php echo HTTP_ROOT . 'wiki-details'; ?>"  class="<?php if (CONTROLLER == "Wiki") { echo 'active'.' '.$sub_text_class; } ?>">
											<span class="mini-sidebar-label"><?php echo __('Wiki'); ?> <?php echo $this->Format->getlockIcon(); ?></span><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __('New');?></sup>
									</a>
							</li>
						<?php } ?>
					<?php } ?>
					<?php } ?>
                <?php } ?>
					
					<?php   if(!$left_smenu_exist || in_array('kanban',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
						<?php $check_kanban = 1; if(defined('CMP_CREATED') && CMP_CREATED >= '2018-01-17 00:00:59' && SES_COMP != 37731){$check_kanban = 1;}; ?>
						<?php if ($check_kanban) { ?>
						<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
								<?php if($this->Format->isAllowed('View Kanban',$roleAccess)){ ?>
								<li class="menu-milestone <?php if (CONTROLLER == "milestones" && (PAGE_NAME == "milestone")) {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
									<?php
									$kanbanurl = '';
									$ldTrkUrl = '';
									$kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
									$ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
									?>
								<a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT . 'dashboard#' . $kanbanurl;} ?>" onclick="trackEventLeadTracker('Left Panel','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('<?php echo $kanbanurl; ?>');" class="menu-milestone">
												<span class="mini-sidebar-label"><?php echo __('Kanban'); ?></span><?php echo $this->Format->getlockIcon(); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php } ?>
                <?php } ?>
					<?php } ?>
						
				<?php if(in_array('template',$checked_left_menu_submenu['checked_left_menu'])){ ?>				
				<?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
					<li class="menu-status_workflow <?php if (CONTROLLER == "templates") {echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a onclick="return trackEventLeadTracker('Left Panel', 'Template Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" href="<?php echo HTTP_ROOT.'templates/projects'; ?>" title="<?php echo __('Template');?>">
							<span class="mini-sidebar-label"><?php echo __('Template');?></span>
						</a>
					</li>
				<?php } ?>				
				<?php } ?>
				
				
				<?php if(in_array('gantt chart',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
					<?php if ($this->Format->isAllowed('View Gantt Chart',$roleAccess)) { ?>
							<?php if( $this->Format->isAllowed('View Gantt Chart',$roleAccess)){?>
							<?php if(!$exp_plan){ ?>
						<li class="prevent_togl_li_bkp <?php if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {echo 'active_bk active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
										<?php if ($this->Format->isFeatureOn('gantt', $user_subscription['subscription_id'])) { ?>
										<a href="javascript:showUpgradPopup(0,1);" onclick="trackEventLeadTracker('Left Panel', 'Gantt Chart Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
												<span class="mini-sidebar-label"><?php echo __('Gantt Chart'); ?> <?php echo $this->Format->getlockIcon(1); ?></span>
										</a>
								<?php } else { ?>					
										<a href="<?php echo HTTP_ROOT . 'ganttchart/manage'; ?>" onclick="trackEventLeadTracker('Left Panel', 'Gantt Chart Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
												<span class="mini-sidebar-label"><?php echo __('Gantt Chart'); ?></span>
										</a>
								<?php } ?>
						</li>
					<?php }else{ ?>
					<?php if (SES_TYPE < 3) { ?>
					<li class="left_panel_ntother_link prevent_togl_li list-13 <?php if (CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) {echo 'active_bk active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';}?>">
						<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel','Gantt Chart Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
							<span class="mini-sidebar-label"><?php echo __('Gantt Chart');?> <?php echo $this->Format->getlockIcon(); ?></span>
                    </a>
					</li>
					<?php } ?>
				<?php }?>
				<?php } ?>
				<?php } ?>
				<?php } ?>
					<?php if(!$left_smenu_exist || in_array('files',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                     <?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>					
						<li class="menu-files">
							<a href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Files Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');return checkHashLoad('files');" class="menu-files">
								<?php echo __('Files'); ?> <span class="cmn_count_no" id="fileCnt" style="display: none;"></span>
							</a>
						</li>
                    <?php } ?>
                    <?php } ?>
						<?php if(!$left_smenu_exist || in_array('invoices',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                             <?php if($this->Format->isAllowed('View Invoices',$roleAccess)){ ?>
							 <?php if(!$exp_plan){ ?>
              <li class="<?php if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) {echo ' active';}?>">
								<a href="<?php echo HTTP_ROOT . 'easycases/invoice'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Invoice Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) { echo 'active'.' '.$sub_text_class; } ?>">
									<?php echo __('Invoices'); ?>
								</a>
							</li>
							<?php }else{ ?>
								<li class="left_panel_ntother_link menu-invoices prevent_togl_li  list-4 <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) {echo 'active';}?>">
									<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel', 'Invoice Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) { echo 'active'.' '.$sub_text_class; } ?>">
										<?php echo __('Invoices'); ?> <?php echo $this->Format->getlockIcon(1); ?>
									</a>
								</li>
							<?php } ?>
                        <?php } ?>
                        <?php } ?>
						<?php if(!$left_smenu_exist || in_array('daily catch-up',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                       <?php  if ($this->Format->isAllowed('View Daily Catchup',$roleAccess)) { //if (SES_TYPE == 1 || SES_TYPE == 2){ ?>
					   <?php if(!$exp_plan){ ?>
              <li class="<?php if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) {echo ' active';}?>">
								<a href="<?php echo HTTP_ROOT . 'reminder-settings'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Daily Catch-up Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) { echo 'active'.' '.$sub_text_class; } ?>">
									<?php echo __('Daily Catch-up'); ?>
								</a>
							</li>
							<?php }else{ ?>
								<li class="left_panel_ntother_link prevent_togl_li list-9 <?php	if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) {echo 'active';}?>">
								<a href="javascript:showUpgradPopup(1);" onclick="return trackEventLeadTracker('Left Panel', 'Daily Catch-up Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) { echo 'active'.' '.$sub_text_class; } ?>">
									<?php echo __('Daily Catch-up'); ?> <?php echo $this->Format->getlockIcon(1); ?>
								</a>
							</li>
							<?php } ?>
						<?php } ?>
						<?php } ?>
						<?php if(!$left_smenu_exist || in_array('archive',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
						<li class="<?php if (CONTROLLER == "archives" && (PAGE_NAME == "listall")) {echo ' active_bk active';}?>">
							<a href="<?php echo HTTP_ROOT . 'archives/listall#caselist'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Archive Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")){ echo 'active'.' '.$sub_text_class;} ?>">
								<?php echo __('Archive'); ?>
							</a>
						</li>
						<?php } ?>
						<?php if(!$left_smenu_exist || in_array('template',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
						<?php if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
							<li class="<?php if (CONTROLLER == "templates") {echo ' active_bk active';}?>">
								<a href="<?php echo HTTP_ROOT . 'templates/projects'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Template Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="<?php if (CONTROLLER == "templates") { echo 'active_bk active'.' '.$sub_text_class; }?>" >
									<?php echo __('Template'); ?>
								</a>
							</li>
						<?php } ?>
						<?php } ?>
                    </ul>
                </li>
				<?php } ?>