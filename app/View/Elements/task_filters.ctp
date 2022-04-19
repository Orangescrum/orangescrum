<div class="modal right fade filterModal" id="filterModal" role="dialog" data-backdrop="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="filter_title_sec"><?php echo __('Filter Your Task');?></h3>
				<button type="button" class="close" id="tour_closeTaskFilter" data-dismiss="modal" aria-label="Close" onclick="closeTaskFilter();"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">				
				<div class="active_filter_sec" style="display:none;">
					<div class="active_filter_sec_head">
							<?php echo __('Active Filters');?>
						</div>
					<div class="active_filter_sec_cont" style="display:block;">
							<div id="active_filter_contain"></div>
						</div>
					</div>
				<div class="filter_accordion">
					
				  <div class="filter_set nolog">
						<div class="filter_type_header active">
							<?php echo __('Common Task Filters');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data" style="display:block">
							<p>
							<span class="dtl_label_tag dtl_label_tag_tsk default_cmn_filtr">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/cases" onclick="setTabSelection(this);" title="All tasks"><?php echo __('All Tasks');?>
								</a>
								</span>	
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/assigntome" onclick="setTabSelection(this);" title="All Task Assigned To Me"><?php echo __('Assigned to me');?>
								</a>
								</span>	
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/favourite" onclick="setTabSelection(this);" title="All favourite tasks"><?php echo __('Favourites');?>
								</a>
								</span>	
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/overdue" onclick="setTabSelection(this);" title="All Overdue tasks"><?php echo __('Overdue');?>
								</a>
								</span>	 
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/deligateto" onclick="setTabSelection(this);" title="Tasks i've created"><?php echo __("Tasks i've created");?>
								</a>
								</span>	
								
							<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/highpriority" onclick="setTabSelection(this);" title="All high priority tasks"><?php echo __('High Priority');?>
								</a>
								</span>	
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/openedtasks" onclick="setTabSelection(this);" title="All tasks having status new, in progress and resolve"><?php echo __('All Opened');?>
								</a>
								</span>	
								<span class="dtl_label_tag dtl_label_tag_tsk">
								<a class="only_set_activecls" href="<?php echo HTTP_ROOT;?>dashboard#tasks/closedtasks" onclick="setTabSelection(this);" title="All Closed tasks"><?php echo __('All Closed');?>
								</a>
								</span>	
							</p>
							<?php /*<div><?php echo __('Saved Filters');?></div>
							<p id="custom_filter_contain">
							</p>*/?>
						</div>
				  </div>
					<div class="filter_set nolog">
						<div class="filter_type_header">
							<?php echo __('Saved Filters');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<p id="custom_filter_contain"></p>
						</div>
				  </div>
					<script type="text/template" id="filterSearch_id_tmpl_right">								
						<?php echo $this->element('search_filter_right'); ?>
					</script>
					<div class="filter_set nolog">
						<div class="filter_type_header" onclick="allfiltervalue('date', event);">
							<?php echo __('Time');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_date" onclick="event.stopPropagation();"> </ul>
						</div>
				  </div>
					
					
				  <div class="filter_set nolog">
						<div class="filter_type_header" onclick="allfiltervalue('duedate', event);">
							<?php echo __('Due Date');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_duedate" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
				  <div class="filter_set nolog">
					<div class="filter_type_header" data-val="status" onclick="allfiltervalue('status', event);">
					  <?php echo __('Status');?>
					  <span class="fa_arrow fa-plus"></span>
					</div>
					<div class="filter_toggle_data">
					  <ul class="dropdown_status_filter_new ltsm scrollable" id="dropdown_menu_status" onclick="event.stopPropagation();"></ul>
					</div>
				  </div>
				  <div class="filter_set nolog">
					<div class="filter_type_header" data-val="types" onclick="allfiltervalue('types', event);">
					  <?php echo __('Type');?>
					  <span class="fa_arrow fa-plus"></span>
					</div>
					<div class="filter_toggle_data">
					  <ul class="dropdown_status_filter_new sub-panel-menu_archive ltsm" id="dropdown_menu_types" onclick="event.stopPropagation();"></ul>
					</div>
				  </div>
				  <div class="filter_set nolog">
						<div class="filter_type_header" data-val="priority" onclick="allfiltervalue('priority', event);">
							<?php echo __('Priority');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_priority" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					<?php if (count($getallproj) != 0) { ?>
					<div class="filter_set nolog">
						<div class="filter_type_header" data-val="comments" onclick="allfiltervalue('comments', event);">
							<?php echo __('Commented By');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_comments" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					<div class="filter_set nolog">
						<div class="filter_type_header" data-val="taskgroup" onclick="allfiltervalue('taskgroup', event);">
							<?php echo __('Task Group');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_taskgroup" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					<div class="filter_set nolog">
						<div class="filter_type_header" data-val="users" onclick="allfiltervalue('users', event);">
							<?php echo __('Created By');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_users" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					<div class="filter_set nolog">
						<div class="filter_type_header" data-val="assignto" onclick="allfiltervalue('assignto', event);">
							<?php echo __('Assign To');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_assignto" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					<?php } ?>
					
					<?php /*time log*/?>
					<div class="filter_set log">
						<div class="filter_type_header" onclick="allfiltervalue('createdDate', event);">
							<?php echo __('Date');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_createdDate" onclick="event.stopPropagation();">
								<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_alldates" data-id="alldates" onclick="general.filterDate('timelog', 'alldates', 'All', 'check');"/> <?php echo __('All Dates');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_today" data-id="today" onclick="general.filterDate('timelog', 'today', 'Today', 'check');"/> <?php echo __('Today');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_yesterday" data-id="yesterday" onclick="general.filterDate('timelog', 'yesterday', 'Yesterday', 'check');"/> <?php echo __('Yesterday');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisweek" data-id="thisweek" onclick="general.filterDate('timelog', 'thisweek', 'This Week', 'check');"/> <?php echo __('This Week');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thismonth" data-id="thismonth" onclick="general.filterDate('timelog', 'thismonth', 'This Month', 'check');"/> <?php echo __('This Month');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisquarter" data-id="thisquarter" onclick="general.filterDate('timelog', 'thisquarter', 'This Quarter', 'check');"/> <?php echo __('This Quarter');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisyear" data-id="thisyear" onclick="general.filterDate('timelog', 'thisyear', 'This Year', 'check');"/> <?php echo __('This Year');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastweek" data-id="lastweek" onclick="general.filterDate('timelog', 'lastweek', 'Last Week', 'check');"/> <?php echo __('Last Week');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastmonth" data-id="lastmonth" onclick="general.filterDate('timelog', 'lastmonth', 'Last Month', 'check');"/> <?php echo __('Last Month');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastquarter" data-id="lastquarter" onclick="general.filterDate('timelog', 'lastquarter', 'Last Quarter', 'check');"/> <?php echo __('Last Quarter');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastyear" data-id="lastyear" onclick="general.filterDate('timelog', 'lastyear', 'Last Year', 'check');"/> <?php echo __('Last Year');?>
													</label>
											</div>
									</a>
							</li>
							<li class="li_check_radio">
									<a href="javascript:void(0);">
											<div class="checkbox">
													<label>
															<input class="tlog_date_check" type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_last365days" data-id="last365days" onclick="general.filterDate('timelog', 'last365days', 'Last 365 days', 'check');"/> <?php echo __('Last 365 days');?>
													</label>
											</div>
									</a>
							</li>
							<li class="custom-date-btn">
									<a class="anchor cstm-dt-option" onclick="customdatetlog();">
											<button type="button" class="ui-datepicker-trigger"><img src="<?php echo HTTP_ROOT; ?>img/images/calendar.png" alt="..." title="..."></button>
											<span style="position:relative;top:2px;cursor:text;"><?php echo __('Custom Date');?></span>
									</a>
							</li>
							<li class="custome_timelog custom_date_li" style="display: none;">
									<div class="frto_sch">
											<input type="text" class="smal_txt form-control " placeholder="<?php echo __('From Date');?>" readonly  id="logstrtdt" value="<?php echo $frm; ?>"/>
											<input type="text" class="smal_txt form-control " placeholder="<?php echo __('To Date');?>" readonly id="logenddt" value="<?php echo $to; ?>"/>
											<button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn aply_btn" type="button" onclick="general.filterDate('timelog', 'custom', 'Custom');" id="btn_timelog_search"><?php echo __('Search');?></button>
									</div>
							</li>							
							</ul>
						</div>
				  </div>
					
					<div class="filter_set log">
						<div class="filter_type_header" data-val="resource" onclick="allfiltervalue('resource', event);">
							<?php echo __('Resource');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<input type="hidden" id="tlog_date" value=""/>
							<input type="hidden" id="tlog_resource" value=""/>
							<input type="hidden" id="tlog_externalfilter" value=""/>
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_resource" onclick="event.stopPropagation();">
								
							</ul>
						</div>
				  </div>					
					
				</div>
			</div>
		</div>
	</div>
</div>