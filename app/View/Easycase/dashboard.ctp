<?php echo $this->HTML->script("dirPagination",array('defer'));?>
<div id="detail_section"></div>
<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
<?php if(isset($first_login) && $first_login == 1 && !isset($_SESSION['Auth']['User']['dt_last_login'])){ ?>
    <div class="common-user-overlay onboard-overlay"></div>
    <div class="top-onboard-div">
        <b><?php echo __('Welcome to Orangescrum');?>!</b> <?php echo __('Let’s Make Your Project Collaboration Simpler');?>.
        <a class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size" href="<?php echo HTTP_ROOT;?>dashboard#tasks"><?php echo __("I'M Ready to Get Started");?></a>
    </div>
    <div class="onboard-div onboard-nav"><?php echo __('This is your "Quick Navigation" menu, from Kanban View to Calendar View and more');?>. </div>
    <div class="onboard-div onboard-ql"><?php echo __('The "Quick Links" tab helps you to add Projects, Users, Tasks, Task Groups, Timelog and Invoices quicker');?>.</div>
    <div class="onboard-div onboard-tlog"><?php echo __('This is the place where you can view all your logged time details');?>.</div>
    <div class="onboard-div onboard-inv"><?php echo __('From here, you can view & generate "Invoices"');?>.</div>
    <div class="onboard-div onboard-prj"><?php echo __('Here you can create new "Project(s)" and manage the existing ones');?>.</div>
    <div class="onboard-div onboard-usr"><?php echo __('Here you can invite or add new "User(s)" and manage the existing ones');?>.</div>
    <div class="onboard-div onboard-tsk"><?php echo __('This button helps you create "Task(s)" in a click');?>.</div>
    <div class="onboard-div onboard-actn"><?php echo __('This section helps you perform all "Task" actions');?>.</div>
    <div class="onboard-div onboard-help"><?php echo __('Give a buzz to our helpdesk. Orangescrum experts will walk you through');?>.</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').css({'overflow':'hidden'});
            $('body').ready(function(){
                setTimeout(function(){
                    if($('.onboard-overlay').size() > 0){
                        $('a.top_main_page_menu_togl').attr('aria-expanded', true);
                        $('a.top_main_page_menu_togl').parent().addClass('open');
                        $('a.top_main_page_menu_togl').next('ul').show();
                        $('.task_listing table').find('tr:nth-of-type(5) td:nth-child(2) .check-drop-icon').css({'visibility':'visible'});
                        $('.task_listing table').find('tr:nth-of-type(5) td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', true);
                        $('.task_listing table').find('tr:nth-of-type(5) td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().addClass('open');
                        $('.task_listing table').find('tr:nth-of-type(5) td:nth-child(2) .check-drop-icon .dropdown-toggle').next('ul').css({'z-index':'998'}).show();
                    }
                }, '5000');
            });
        });
    </script>
<?php } ?>
    <div id="easycaseDashboard" ng-app="case_dashboard_App">
      <div><!-- ng-controller="case_dashboard_Controller"  -->
    <!--Task listing section starts here-->
    <div ng-view> </div>
    <div id="caseViewSpanUnclick" class="task_section">
				<?php /* if(SHOW_RELEASE_SIDEBAR){ ?>
					<?php if(SES_TYPE < 3){ ?>
						<?php if($this->Format->isGithubOn(SES_COMP, 1)){ ?>
						<div class="latest_release_info">
							<strong><?php echo __('Info!');?></strong> 
							<?php if($this->Format->isGithubOn(SES_COMP)){ ?>
								<?php echo __("Sync Orangescrum tasks with GitHub & vice versa!");?> <a href="<?php echo HTTP_ROOT;?>github/gitconnect" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" style="margin-left: 14px;" onclick="closeInfodiv(0);"><?php echo __("Try it Now");?></a>
							<?php }else{ ?>
									<?php echo __("Sync Orangescrum tasks with GitHub & vice versa! Available only in Standard Plan & above.");?> <a href="<?php echo HTTP_ROOT;?>pricing" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" style="margin-left: 14px;" onclick="closeInfodiv(0);"><?php echo __("Upgrade Now");?></a>
							<?php } ?>
							<span class="close_info" onclick="closeInfodiv(0);"><i class="material-icons">&#xE14C;</i></span>
						</div>
						<?php } ?>		
					<?php } ?>
						
						<?php if(CMP_CREATED < '2019-08-16 12:50:00'){ ?>						
						<div class="latest_release_info_cmn">
							<strong><?php echo __('Info!');?></strong> 
								<?php echo __("Our Left Menu options have been optimized. Please reset your menu preferences from Menu Settings.");?> <a href="<?php echo HTTP_ROOT;?>sidebar-settings" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" style="margin-left: 14px;" onclick="closeInfodiv(1);"><?php echo __("Check & Reset");?></a>
							<span class="close_info" onclick="closeInfodiv(1);"><i class="material-icons">&#xE14C;</i></span>
						</div>
						<?php } ?>
					
				<?php } */ ?>		
				<div id="caseViewDetails" style="display:none"></div>
				<div id="caseViewSpan" style="display:block">
				<?php echo $this->element('case_preload'); ?>
			</div>
            <div id="task_paginate" style="display:block"></div>
    </div>
    <div id="milestone_content" class="pr" style="display:none">       
        <div id="show_milestonelist" class="kanban_board_container"></div>
    </div>
    <div id="kanban_list" class="kanban_section kanban_resp kanban_board_container" style="display:block"></div>
    <!--Task listing section ends here-->
	<div id="calendar_view" class="calendar_section calendar_resp" style="display:block;margin-top: 12px;"></div>	
        <div id="caseOverview" style="display:block"></div>
	<div id="caseTimeLogDv" style="display:block">            
		<div id="caseTimeLogViewSpan" class="pr" style="display:block">
                   <?php //echo $this->element('case_timelog1'); ?> 
                </div>
		<div id="TimeLog_paginate" style="display:block"></div>
		<div id="TimeLog_calendar_view" style="display:none;"></div>
		<div id="TimeLog_chart_view" style="display:none;"></div>
		<?php if(SES_TYPE == 3){ ?>
			<div class="tsk-typ-txt tsk-typ-txt-tg" style="display:none;"> 
				<p style="margin:0px;"><img style="margin-right:5px;" alt="" src="<?php echo HTTP_ROOT; ?>img/idea-ico.png"><?php echo __('You are seeing your time logs only. To view others time log please contact your account Owner/Admin');?>.</p>
	</div>
		<?php } ?>
	</div>
	
    <?php /* <div id="caseLoader" class="loader-wrapper">
        <div class="loader-os"></div>
    </div> */ ?>
<!--    <div class="loader_bg" id="caseLoader"><div class="loader-wrapper md-preloader md-preloader-warning"><svg version="1.1" height="48" width="48" viewBox="0 0 75 75"><circle cx="37.5" cy="37.5" r="25" stroke-width="4"></circle></svg></div></div>-->
   <div class="loader_bg" id="caseLoader"> 
			<div class="loadingdata">
				<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
			</div>
		<!--<div class="loadingdata"><img style="margin: 13px;" src="<?php echo HTTP_ROOT; ?>img/images/feed.gif" alt="loading..." title="loading..."/></div>-->
   </div>
    <div id="caseFileDv" style="display:block">            
        <div id="files_content_block" class="m-cmn-flow"></div>
        <div id="files_paginate"></div>
    </div>
	
	<!--Task activities section start here-->
	<div class="row cmn_bdr_shadow main-activity-wrap" id="actvt_section" style="display:none">
		<div class="col-lg-12 padlft-non padrht-non">
			
			<div class="col-lg-9 activity_ipad">
				<div class="width100 dash-activity">
                                    <div id="activities"></div>
					<div class="dash-activity-cont mtop10">
                                        <div id="ajax_activity_tmpl" style="display:none;"> <!--ng-app='ajax_activity_app'-->
                                            <?php echo $this->element("../Users/json_activity1");?>
                                        </div></div>
					<div id="more_loader" class="morebar">
						<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/>
					</div>
				</div>
			</div>
			
			<div class="act_rt_div col-lg-3 activity-chart padlft-non padrht-non">
				<div class="my-delegate-task">
					<ul class="nav-tabs activ_line mod_wide">
						<li class="active">
							<a href="javascript:void(0);" id="myTab" onclick="myactivities('myTab', 'delegatedTab');"><?php echo __('My Task');?></a>
						</li>
						<li id="file_li"><a href="javascript:void(0);"  id="delegatedTab" onclick="delegateactivities('myTab', 'delegatedTab');"><?php echo __('Delegated');?></a></li>
					</ul>
				</div>
				<div class="uo-task">
					<h4><?php echo __('UPCOMING TASKS');?></h4>
					<div id="Upcoming"  ng-controller="upcoming_Controller"> 
                                             <div class="up_task_data ellipsis-view" style="max-width: 100%;" ng-repeat="data in upcoming_records[1]">
                                                 <b>{{data.Easycase.formated_due_date}}</b><br/>
                                                <a href="<?php echo HTTP_ROOT; ?>dashboard#details/{{data.Easycase.uniq_id}}">{{data.Easycase.title}}</a> 
                                                <br />
                                                <span><?php echo __('Late by');?> {{data.Easycase.late}} <?php echo __('day(s)');?>
                                                </span> 
                                             </div>
                                            <div ng-if="upcoming_records[1].length == 0" class="fnt_clr_gry"><?php echo __('No tasks');?></div>
                                        </div>
				</div>
				<div class="uo-task">
					<h4><?php echo __('OVERDUE TASKS');?></h4>
					<div id="Overdue"  ng-controller="overdue_Controller">
                                             <div class="due_task_data ellipsis-view" style="max-width: 100%;" ng-repeat="data in overdue_records[1]">
                                                 <b>{{data.Easycase.formated_due_date}}</b><br/>
                                                <a href="<?php echo HTTP_ROOT; ?>dashboard#details/{{data.Easycase.uniq_id}}">{{data.Easycase.title}}</a> 
                                                <br />
                                                <span><?php echo __('Late by');?> {{data.Easycase.late}} <?php echo __('day(s)');?>
                                                </span> 
                                             </div>
                                            <div ng-if="overdue_records[1].length == 0" class="fnt_clr_gry"><?php echo __('No tasks');?></div>
                                        </div>
				</div>					
				<div id="moreOverdueloader" class="moreOverdueloader"><?php echo __('Loading Tasks');?>...</div>					
				<div id="PieChart" class="dash-client" style="display: none;">
                                   <div id="piechart"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="cb"></div>
        <div class="row cmn_bdr_shadow main-activity-wrap" id="mention_section" style="display:none">
		<div class="col-lg-12 padlft-non padrht-non">
			
			<div class="col-lg-12 activity_ipad">
				<div class="width100 dash-mention">
                                    <div id="mentioned"></div>
					<div class="dash-mentioned-cont mtop10">
                                        <div id="ajax_mentioned_tmpl" style="display:none;"> <!--ng-app='ajax_activity_app'-->
                                            <?php echo $this->element("../Users/json_mentioned");?>
                                        </div></div>
					<div id="more_loader" class="morebar">
						<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="cb"></div>
	<input type="hidden" id="displayed" value="30">
	<input type="hidden" id="display_mention" value="30">
	<!--Task activities section ends here-->
     </div>
</div>
<?php } ?>
<!-- Subtask Container -->
<div id="subtask-container" class="overlay-subtask">
  <a href="javascript:void(0)" class="closebtn" onclick="closeSubTaskView()">&times;</a>
  <div class="overlay-subtask-content">
    <div id="case-sub-task-container">
        <?php echo $this->element('case_preload'); ?>
    </div>
  </div>
</div>
<script type="text/template" id="case_subtask_view_tmpl">
<?php echo $this->element('case_subtask_list'); ?>
</script>
<input type="hidden" id="subtask_page_count" value="1">
<input type="hidden" id="subtask_page_total" value="1">
<!-- End Subtask Container -->
<script type="text/template" id="case_timelog_tmpl">
<?php echo $this->element('case_timelog'); ?>
</script>
<script type="text/template" id="case_project_tmpl">
<?php 
	if(defined('COMP_LAYOUT') && COMP_LAYOUT){
		echo $this->element('case_project_v2'); 
	}else{
		echo $this->element('case_project'); 
	}
?>
</script>
<script type="text/template" id="case_subtask_tmpl">
<?php echo $this->element('case_subtask'); ?>
</script>
<script type="text/template" id="case_subtasks_tmpl">
<?php echo $this->element('case_subtasks_new'); ?>
</script>
<script type="text/template" id="case_reminder_tmpl">
<?php echo $this->element('case_reminder'); ?>
</script>
<!-- Added for listing task group by Milestone -->
<script type="text/template" id="case_taskgroups_tmpl">
<?php 
	if(defined('COMP_LAYOUT') && COMP_LAYOUT){
		echo $this->element('case_taskgroup_v2'); 
	}else{
		echo $this->element('case_taskgroup'); 
	}
?>
</script>
<script type="text/template" id="case_subtaskview_tmpl">
<?php //echo $this->element('case_subtaskview'); ?>
<?php echo $this->element('case_task_by_taskgroup_new'); ?>
</script>
<script type="text/template" id="case_subsubtaskview_tmpl">
<?php echo $this->element('case_subsubtaskview'); ?>
</script>
<script type="text/template" id="milestone_subtaskview_tmpl">
<?php echo $this->element('project_milestones'); ?>
</script>


<script type="text/template" id="task_by_milestone_tmpl">
<?php echo $this->element('case_task_by_milestone'); ?>
</script>
<script type="text/template" id="task_by_taskgroup_tmpl">
<?php echo $this->element('case_task_by_taskgroup'); ?>
</script>
<!-- End of listing task group by Milestone -->

<!-- Added for listing backlog -->
<script type="text/template" id="case_backlogs_tmpl">
<?php echo $this->element('case_backlog'); ?>
</script>
<script type="text/template" id="task_by_backlo_tmpl">
<?php echo $this->element('case_task_by_backlog'); ?>
</script>
<!-- End of listing task group by Milestone -->

<!-- Added for listing active sprint -->
<script type="text/template" id="active_sprint_tmpl">
<?php echo $this->element('active_sprint'); ?>
</script>

<!-- Added for listing active sprint empty-->
<script type="text/template" id="active_sprint_empty_tmpl">
<?php echo $this->element('active_sprint_empty'); ?>
</script>

<!--<script type="text/template" id="case_project_tmpl">
<?php //echo $this->element('compact_view'); ?>
</script>-->
<script type="text/template" id="kanban_task_tmpl">
<?php echo $this->element('kanban_task'); ?>
</script>
<?php /*<script type="text/template" id="paginate_tmpl">
<?php echo $this->element('paginate'); ?>
</script>*/?>
<script type="text/template" id="paginate_tmpl">
<?php echo $this->element('task_paginate'); ?>
</script>
<script type="text/template" id="case_details_tmpl">
<?php echo $this->element('case_details'); ?>
</script>
<script type="text/template" id="case_details_sts__tmpl">
<?php echo $this->element('case_details_sts_new'); ?>
</script>
<script type="text/template" id="case_replies_tmpl">
<?php echo $this->element('case_reply'); ?>
</script>
<script type="text/template" id="case_widget_tmpl">
<?php echo $this->element('ajax_case_status'); ?>
</script>

<script type="text/template" id="case_files_tmpl">
<?php echo $this->element('case_files'); ?>
</script>

<script type="text/template" id="date_filter_tmpl">
<?php echo $this->element('date_filter'); ?>
</script>

<script type="text/template" id="duedate_filter_tmpl">
<?php echo $this->element('duedate_filter'); ?>
</script>
<!--<script type="text/template" id="ajax_activity_tmpl">
    <?php echo $this->element("../Users/json_activity");?>
</script>-->
<!--<div ng-app='ajax_activity_app' id="ajax_activity_tmpl" style="display:none;">
    <?php echo $this->element("../Users/json_activity1");?>
</div>-->
<script type="text/template" id="manage_milestone_tmpl">
<?php echo $this->element('manage_milestone'); ?>
</script>
<script type="text/template" id="milestonelist_tmpl">
<?php echo $this->element('ajax_milestonelist'); ?>
</script>

<script type="text/template" id="case_detail_right_files_tmpl">
<?php echo $this->element('case_detail_right_files'); ?>
</script>

<script type="text/template" id="list_thread_tmpl">
<?php 
if(defined('COMP_LAYOUT') && COMP_LAYOUT){
	echo $this->element('case_list_tr_v2'); 
}else{
	echo $this->element('case_list_tr'); 
}
?>
</script>
<script type="text/template" id="subtask_thread_tmpl">
<?php	echo $this->element('subtask_list_tr'); ?>
</script>
<script type="text/template" id="backlog_thread_tmpl">
<?php echo $this->element('backlog_list_tr'); ?>
</script>
<script type="text/template" id="kanban_thread_tmpl">
<?php echo $this->element('kanban_task_tr'); ?>
</script>
<script type="text/template" id="search_filter_tmpl">
<?php echo $this->element('case_search_filter'); ?>
</script>
<!-- Added for listing taskgroup for sub task view-->
<script type="text/template" id="case_taskgrouplst_tmpl">
<?php echo $this->element('case_taskgroup_list'); ?>
</script>
<script type="text/template" id="case_taskgrouplst_load_tmpl">
<?php echo $this->element('case_taskgroup_list_load'); ?>
</script>
<!-- include json template for subtask list in task detail-->

<input type="hidden" name="checktype" id="checktype" value="" size="10" readonly="true">
<input type="hidden" name="caseStatus" id="caseStatus" value="<?php echo $caseStatus; ?>" size="10" readonly="true">
<input type="hidden" name="caseStatusprev" id="caseStatusprev" value="" size="10" readonly="true">
<input type="hidden" name="caseCustomStatus" id="caseCustomStatus" value="<?php echo $caseCustomStatus; ?>" size="10" readonly="true">
<input type="hidden" name="caseCustomStatusprev" id="caseCustomStatusprev" value="" size="10" readonly="true">
<input type="hidden" name="priFil" id="priFil" value="<?php echo $priorityFil; ?>" size="14" readonly="true"/>
<input type="hidden" name="caseTypes" id="caseTypes" value="<?php echo $caseTypes; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseMember" id="caseMember" value="<?php echo $caseUserId; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseTaskgroup" id="caseTaskgroup" value="<?php //echo $caseUserId; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseComment" id="caseComment" value="<?php //echo $caseComment; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseLabel" id="caseLabel" value="<?php echo $caseLabel; ?>" readonly="true"/>
<input type="hidden" name="caseAssignTo" id="caseAssignTo" value="<?php echo $caseAssignTo; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseFavourite" id="caseFavourite" value="<?php echo $caseFavourite; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseSearch" id="caseSearch" value="<?php echo $caseSearch; ?>" size="4" readonly="true"/>
<input type="hidden" name="mlstPage" id="mlstPage" value="1" size="4" readonly="true"/>
<input type="hidden" name="caseId" id="caseId" value="<?php //echo $caseUniqId; ?>" size="14" readonly="true"/>
<input type="hidden" name="caseDate" id="caseDate" value="<?php echo $caseDate; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseTitle" id="caseTitle" value="<?php echo $caseTitle; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseDueDate" id="caseDueDate" value="<?php echo $caseDueDate; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseEstHours" id="caseEstHours" value="<?php echo $caseEstHours; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseCreatedDate" id="caseCreatedDate" value="<?php echo $caseCreatedDate; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseNum" id="caseNum" value="<?php echo $caseNum; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseLegendsort" id="caseLegendsort" value="<?php echo $caseLegendsort; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseAtsort" id="caseAtsort" value="<?php echo $caseAtsort; ?>" size="4" readonly="true"/>
<input type="hidden" name="isSort" id="isSort" value="<?php echo $isSort; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseStart" id="caseStart" value="" size="4" readonly="true"/>
<input type="hidden" name="caseChangeType" id="caseChangeType" value="" size="4" readonly="true"/>
<input type="hidden" name="caseChangePriority" id="caseChangePriority" value="" size="4" readonly="true"/>
<input type="hidden" name="caseChangeAssignto" id="caseChangeAssignto" value="" size="4" readonly="true"/>
<input type="hidden" name="caseChangeDuedate" id="caseChangeDuedate" value="" size="4" readonly="true"/>
<input type="hidden" name="caseResolve" id="caseResolve" value="" size="4" readonly="true"/>
<input type="hidden" name="caseNew" id="caseNew" value="" size="4" readonly="true"/>
<input type="hidden" name="clearCaseSearch" id="clearCaseSearch" value="" size="4" readonly="true"/>
<input type="hidden" name="caseMenuFilters" id="caseMenuFilters" value="<?php echo $caseMenuFilters?$caseMenuFilters:'cases'; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseMenuFilterskanban" id="caseMenuFilterskanban" value="" size="4" readonly="true"/>
<input type="hidden" name="customFIlterId" id="customFIlterId" value="" size="4" readonly="true"/>

<!-- check calender time log not to load multiple time -->
<input type="hidden" id="check_cale_multple_time" value="" size="4" readonly="true"/>

<input type="hidden" name="milestoneIds" id="milestoneIds" value="<?php echo $milestoneIds; ?>" size="4" readonly="true"/>

<input type="hidden" name="caseDetailsSorting" id="caseDetailsSorting" value="<?php echo $caseDtlsSort; ?>" size="4" readonly="true"/>
<input type="hidden" name="urllvalueCase" id="urllvalueCase" value="<?php echo $urllvalueCase; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseUrl" id="caseUrl" value="<?php echo $caseUrl; ?>" size="4" readonly="true"/>
<input type="hidden" name="caseDateFil" id="caseDateFil" value="<?php echo $caseDateFil; ?>" size="4" readonly="true"/>
<input type="hidden" name="casedueDateFil" id="casedueDateFil" value="<?php echo $casedueDateFil; ?>" size="4" readonly="true"/>

<input type="hidden" name="prvhash" id="prvhash" value="" readonly="true"/>
<input type="hidden" name="milestoneUid" id="milestoneUid"   readonly="true"  value=''/>
<!-- Used for switching from milestone list to kanban task list and Accordingly counter changed -->
<input type="hidden" name="milestoneUid" id="milestoneId"   readonly="true"  value=''/>
<!-- differentiate between list view and Compact View -->
<input type="hidden" name="lviewtype" id="lviewtype"   readonly="true"  value='<?php echo $_SESSION['LISTVIEW_TYPE'];?>'/>

<input type="hidden" id="last_project_id" value="">
<input type="hidden" id="last_project_uniqid" value="">
<input type="hidden" value="0" id="totalMlstCnt" readonly="true"/>
<input type="hidden" value="0" id="milestoneLimit" readonly="true"/>
<input type="hidden" value="1" id="mlsttabvalue" readonly="true"/>
<input type="hidden" value="milestone" id="refMilestone" readonly="true"/>
<input type="hidden" id="storeIsActive">
<input type="hidden" id="storeIsActivegrid">
<input type="hidden" id="view_type" value="kanban">
<input type="hidden" id="search_text">
<!-- Used for saving the state of totalreplies which has been loaded by ajax in task details page -->
<input type="hidden" name="lastTotReplies-lst" id="lastTotReplies-lst" value=''/>
<script type="text/javascript">
    var showBeforeUnload= false;
    if(window.location.hash.indexOf("overview") != -1){
        $("#caseLoader").show();
    }
	$(document).ready(function(event){
		$(document).click(function(e){
			if($(e.target).is(".filter_opn")){
				e.preventDefault();
				e.stopPropagation();
			}else{
				$('#dropdown_menu_all_filters').hide();
				$('#dropdown_menu_sortby_filters').hide();
				$('#dropdown_menu_groupby_filters').hide();
				$('.dropdown_status').hide();
				//$(".case-filter-menu").css({"position":'fixed'});
			}
		});
		$("#logstrtdt").datepicker({
			format: 'M d, yyyy',
			changeMonth: false,
			changeYear: false,
			hideIfNoPrevNext: true,
            autoclose:true
        }).on("changeDate", function(){
            var dateText = $("#logstrtdt").datepicker('getFormattedDate');
            $("#logenddt").datepicker("setStartDate", dateText);
        });
		$("#logenddt").datepicker({
					format: 'M d, yyyy',
					changeMonth: false,
					changeYear: false,
					hideIfNoPrevNext: true,
                    autoclose:true
        }).on("changeDate", function(){
            var dateText = $("#logenddt").datepicker('getFormattedDate');
            $("#logstrtdt").datepicker("setEndDate", dateText);
        });
		//display release info
		setTimeout(function(){
				showInfodiv();
		}, 2000);
	});
	$(".proj_mng_div .contain").hover(function(){
		$(this).find(".proj_mng").stop(true,true).animate({bottom:"0px",opacity:1},400);
	},function(){
		$(this).find(".proj_mng").stop(true,true).animate({bottom:"-42px",opacity:0},400);
	});
	$(document).on('click','.milestonenextprev .prev',function(){
		//$('#milestoneLimit').val(parseInt($('#milestoneLimit').val())-6);
                var isActive=($('#storeIsActive').val()!='')?$('#storeIsActive').val():1;
                var search_key=$('#search_text').val();
		showMilestoneList('prev',isActive,1,search_key);
	});
	$(document).on('click','.milestonenextprev .next',function(){
            var isActive=($('#storeIsActive').val()!='')?$('#storeIsActive').val():1;
                var search_key=$('#search_text').val();
		showMilestoneList('next',isActive,1,search_key);
	});
	function kanban_sattus(){
        $('.milst_addition').hide();
        localStorage.setItem("SELECTTAB", 'link');
		window.location.href = HTTP_ROOT+'dashboard#kanban';
	}
	$(document).on('click','#open_detail_id',function(){
       $('.toggle_task_details').slideToggle('3000');
	   //$('.tglarow_icon').addClass('down');
       if($(this).text().trim() == 'Hide Detail')
       {
           $(this).text('Show Detail');
		   $('.tglarow_icon').removeClass('down');   
       }
       else
       {
           $(this).text('Hide Detail');
		   $('.tglarow_icon').addClass('down');
       }
	});
function inArray(needle, haystack) {
    if(typeof haystack !='undefined' && haystack != null){
    var length = haystack.length;
    if (length != 0) {
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
    } else {
        return true;
    }
    }else{
        return true;
    }
    return false;
}
function columnfiltervalue(type) {
        $('#dropdown_menu_casestatus_div').show();
        $('#dropdown_menu_casestatus').show();
        return false;
}

function getAllowedColumns(){
    var checkedVals = $('.selectedcols:checkbox:checked').map(function() {
        return this.value;
    }).get();
    var selectedCols = checkedVals.join(",");
    $.post( HTTP_ROOT + "requests/saveSelectedColumns", {"cols": selectedCols}, function(data){
      if (data) {
          reloadTasks();
      }
    });
}
function checkboxColumn(ev){
    var status = $(ev).is(":checked");
    $(".selectedcols").prop("checked",status);
    $("#showhide_drpdwn").addClass("open");
}
function checkboxSingleColumn(ev){
    $("#showhide_drpdwn").addClass("open");
    var status = $(ev).is(":checked");
    if(!status)
    $("#column_all").prop("checked",false);    
    if($("#column_assigned").is(":checked") && $("#column_priority").is(":checked") && $("#column_updated").is(":checked") && $("#column_status").is(":checked") && $("#column_duedate").is(":checked") && $("#column_progress").is(":checked")){ 
            $("#column_all").prop("checked",true);
    }
}
function showColumnPreferences(pref){
     //$(".selectedcols").trigger('change');
}
function closeInfodiv(typ){
	if(typ==1){
		localStorage.setItem("DESKTOP_RES_MESG_CMN", 1);	
		$('.latest_release_info_cmn').hide();
	}else{
		localStorage.setItem("DESKTOP_RES_MESG", 1);	
		$('.latest_release_info').hide();
	}
}
function showInfodiv(){	
	var u_hs = getHash();	
	if(typeof u_hs !='undefined' && u_hs == 'backlog') {
		$('.latest_release_info_cmn').hide();
		$('.latest_release_info').hide();
	}else{
		if(!localStorage.getItem("DESKTOP_RES_MESG") || localStorage.getItem("DESKTOP_RES_MESG") == '0'){
			if($('.latest_release_info').length){
				$('.latest_release_info').show();
			}
		}
		if(!localStorage.getItem("DESKTOP_RES_MESG_CMN") || localStorage.getItem("DESKTOP_RES_MESG_CMN") == '0'){
			if($('.latest_release_info_cmn').length){
				$('.latest_release_info_cmn').show();
			}
		}	
	}
}
window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (!showBeforeUnload) {
            return undefined;
        }
        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });
};
</script>