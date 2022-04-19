<style>
</style>
<?php if(PAGE_NAME != 'add_your_company'){?>
<div class="crt_slide task_action_bar">
	<div class="task_slide_in">
		<div class='fl'>
		<button type="button" class="btn gry_btn task_create_back" onclick="crt_popup_close()"></button>
		</div>
		<span class="fl">
			<span id="taskheading"><?php echo __('Create');?></span> <?php echo __('Task');?>
		</span>
        <div class="fr imp_task"><a href="<?php echo HTTP_ROOT.'import-export';?>" class="btn btn_blue" target="_blank"><?php echo __('Import Task');?></a></div>
        <div class="cb"></div>
	</div>
</div>
<div class="breadcrumb_div">
<ol class="breadcrumb breadcrumb_fixed">
<input type='hidden' id='hiddensavennew' value='0'/>
<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3) ) { ?>
<input type='hidden' id='boardingprj' value='1'>
<?php }else{ ?>
<input type='hidden' id='boardingprj' value='0'>
<?php } ?>
<script>
	var id = '<?php echo $usrdata['User']['id']; ?>';
</script>
<?php 
if(!empty($usrdata['User']['verify_string']) && (PAGE_NAME != "profile")){ ?>
<div class="fixed-n-bar" style="display:none">
<div class="fl" style="margin-left:325px;"><?php echo __('Please confirm your email address');?>: <span style="font-weight:bold;"><?php echo $usrdata['User']['email']; ?></span> &nbsp;&nbsp;&nbsp;<span class="resend-email"><a href="<?php echo HTTP_ROOT."users/resend_confemail"; ?>"><?php echo __('Resend email');?>.</a></span>&nbsp;&nbsp;&nbsp; <span class="change-email"><a href="<?php echo HTTP_ROOT."users/profile"; ?>"><?php echo __('Change your email');?>.</a></span></div><span class="fr" style="background-color:#FFE5CA;margin-right:30px;width:20px;display:block;"><a id="closevarifybtn" style="display:none;" href="javascript:void(0);" class="close" onclick="closeemailvarify('<?php echo $usrdata['User']['id']; ?>')"><img src="<?php echo HTTP_IMAGES;?>Closed.png" /></a></span><div class="cb"></div></div>
<?php } ?>
<?php if(CONTROLLER == "easycases" && (PAGE_NAME == "files")) { ?>
	<li><?php echo __('Files');?></li>
<?php } ?>
<?php if(CONTROLLER == "milestones" && (PAGE_NAME == "milestone" || PAGE_NAME=='milestonelist')) { ?>
	<li><?php echo __('Task Group');?></li>
<?php } ?>
<?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")) { ?>
	<li><?php echo __('Miscellaneous');?></li>
	<li><?php echo __('Archive');?></li>
	<li><?php echo __('Tasks');?></li>
<?php } ?>
<?php if(CONTROLLER == "projects" && (PAGE_NAME == "manage")) { ?>
	<li><?php echo __('Projects');?></li>
	<li><?php echo __('Manage');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "manage")) { ?>
	<li><?php echo __('Users');?></li>
	<li><?php echo __('Manage');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "profile")) { ?>
	<li><?php echo __('Personal Settings');?></li>
	<li><?php echo __('My Profile');?></li>
<?php }
	if(CONTROLLER == "users" && (PAGE_NAME == "changepassword")) { ?>
	<li><?php echo __('Personal Settings');?></li>
	<li><?php echo __('Change Password');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "email_notifications")) { ?>
	<li><?php echo __('Personal Settings');?></li>
	<li><?php echo __('Notifications');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "email_reports")) { ?>
	<li><?php echo __('Personal Settings');?></li>
	<li><?php echo __('Email Reports');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "default_view")) { ?>
	<li><?php echo __('Personal Settings');?></li>
	<li class="under-icon"><?php echo __('Default Views');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "mycompany")) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('My Company');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "dailyupdatealerts")) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Daily Catch-Up');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "importexport")) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Import & Export');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "cancelact")) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Cancel Account');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "subscription")) { ?>
	<li><?php echo __('Account Settings');?></li>
	<li><?php echo __('Subscription')?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "creditcard")) { ?>
	<li><?php echo __('Account Settings');?></li>
	<li><?php echo __('Credit Card');?></li>
<?php }
	if(CONTROLLER == "users" && (PAGE_NAME == "transaction")) { ?>
	<li><?php echo __('Account Settings');?></li>
	<li><?php echo __('Transactions');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "account_activity")) { ?>
	<li><?php echo __('Account Settings');?></li>
	<li><?php echo __('Account Activity');?></li>
<?php }
        if(CONTROLLER == "users" && (PAGE_NAME == "account_usages")) { ?>
	<li><?php echo __('Account Settings');?></li>
	<li><?php echo __('Usage Details');?></li>
<?php }
if(CONTROLLER == "users" && (PAGE_NAME == "upgrade_member")) { ?>
	<li><?php echo __('Subscription');?></li>
	<li><?php echo __('Upgrade Subscription');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "downgrade")) { ?>
	<li><?php echo __('Subscription');?></li>
	<li><?php echo __('Downgrade Subscription');?></li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "edit_creditcard")) { ?>
	<li><?php echo __('Credit Card');?></li>
	<li><?php echo __('Edit Credit Card');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "confirmationPage")) { ?>
	<li><?php echo __('Subscription');?></li>
	<li><?php echo __('Account Limitation');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "pricing")) { ?>
	<li><?php echo __('Subscription');?></li>
	<li><?php echo __('Pricing');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "activity")) { ?>
	<li><?php echo __('Activities');?></li>
<?php } ?>	
<?php if(CONTROLLER == "projects" && (PAGE_NAME == "importexport" || PAGE_NAME=='csv_dataimport' || PAGE_NAME=='confirm_import') ) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Import & Export');?></li>
<?php }
    if(CONTROLLER == "projects" && (PAGE_NAME == "task_type")) { ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Task Type');?></li>
<?php } ?>	
<?php if(CONTROLLER == "projects" && PAGE_NAME == "labels"){ ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Labels');?></li>
<?php } ?>	
<?php if(CONTROLLER == "projects" && PAGE_NAME == "groupupdatealerts"){ ?>
	<li><?php echo __('Company Settings');?></li>
	<li><?php echo __('Daily Progress Reminder');?></li>
<?php } ?>	
<?php if(CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {?>
	<!--<li><span id="brdcrmb-cse-hdr">Tasks</span></li>-->
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "view_templates")) {?>
	<li><?php echo __('Template');?></li>
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "projects")) {?>
	<li><?php echo __('Templates');?></li>
	<li><?php echo __('Project');?></li>
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "tasks")) {?>
	<li><?php echo __('Miscellaneous');?></li>
	<li><?php echo __('Templates');?></li>
	<li><?php echo __('Task');?></li>
<?php } ?>

<?php if(CONTROLLER == "reports" && (PAGE_NAME == "glide_chart")) {?>
	<li><?php echo __('Analytics');?></li>
	<li><?php echo __('Bug Reports')?></li>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "hours_report")) {?>
	<li><?php echo __('Analytics');?></li>
	<li><?php echo __('Hours Spent Reports');?></li>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "chart")) {?>
	<li><?php echo __('Analytics');?></li>
	<li><?php echo __('Task Reports');?></li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "cancel_account")) {?>
	<li><?php echo __('Account');?></li>
	<?php if(($user_subscription['subscription_id']>1) && !$user_subscription['is_free']){?>
	<li><?php echo __('Cancel Account');?></li>
	<?php }else{?>
	<li><?php echo __('Delete Account');?></li>
	<?php } ?>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) {?>
	<li><?php echo __('Analytics');?></li>
	<li><?php echo __('Weekly Usage Report');?></li>
	<li><?php echo __('Project');?>: <span class="weekly_all">All</span></li>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "resource_utilization")) {?>
	<li><?php echo __('Analytics');?></li>
	<li><?php echo __('Resource Utilization Report');?></li>
	<li><?php echo __('Project');?>: <span class="weekly_all">All</span></li>
<?php } ?>
<?php if(CONTROLLER == "Ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")){?>
	<li><?php echo __('Miscellaneous');?></li>
	<li><?php echo __('Gantt Chart');?></li>
<?php } ?>
<?php if(0 && (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard" || PAGE_NAME == "mydashboard" || PAGE_NAME == "timelog" || PAGE_NAME == "invoice")) || (CONTROLLER == "milestones" && (PAGE_NAME == "milestone" || PAGE_NAME=='milestonelist')) || (CONTROLLER == "users" && (PAGE_NAME == "activity"))) {?>
	<li class="dropdown" id="prj_drpdwn">
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { } else {?><!--Project:--> <?php } ?>
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3) ) { ?>
		<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
		<button class="btn btn_blue" type="button" onClick="newProject();"><?php echo __('Create Project');?></button>
         <?php } ?>
		<input type='hidden' id='boarding' value='1'/>
	<?php }else{?>
	<input type='hidden' id='boarding' value='0'/>
	<?php
		 if(count($getallproj)=='0'){ ?>
		    <i style="color:#FF0000"><?php echo __('None');?></i>
	<?php } else {
			if(count($getallproj)=='1'){ ?>
				<div class="proj_icn_tsk fl"></div>
				<div class="prjnm_ttc prjnm_ttc_n fl ellipsis-view stop_display_drpdn" style="max-width: 130px;" id="first_recent" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['0']['Project']['name']; ?>'); <?php } ?>" title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" rel="tooltip"><a href="javascript:void(0);" ><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a></div>
				<?php
				//echo "<span style='color:#000;'>".$this->Format->shortLength(ucfirst($getallproj['0']['Project']['name']),20)."</span>";
			    $swPrjVal = $getallproj['0']['Project']['name'];
			    $soprjval = $getallproj['0']['Project']['name'];
			}else{
			    $swPrjVal = $this->Format->shortLength($projName,20); 
			    $soprjval = $projName;	    
				//if(trim($soprjval) == ''){
					$soprjval = $getallproj['0']['Project']['name'];
				//}
			?>
            <div class="proj_icn_tsk fl"></div>
            <input type ="hidden" id="pname_dashboard_hid" value="<?php echo $soprjval; ?>" />
            <input type ="hidden" id="first_recent_hid" value="<?php echo $getallproj['1']['Project']['name']; ?>" />
            <input type ="hidden" id="second_recent_hid" value="<?php echo $getallproj['2']['Project']['name']; ?>" />         
            
            <div class="prjnm_ttc prjnm_ttc_n fl ellipsis-view stop_display_drpdn" style="max-width: 122px;"><span id="pname_dashboard" class="ttc "><a  title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" rel="tooltip" href="javascript:void(0);" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['0']['Project']['name']; ?>'); <?php } ?>"><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a></span></div>
            <div class="top_proj_ttc fl ellipsis-view stop_display_drpdn" style="max-width: 122px;display:none;" id="first_recent"><a title="<?php echo ucfirst($getallproj['1']['Project']['name']); ?>" rel="tooltip" href="javascript:void(0);" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['1']['Project']['uniq_id']; ?>','<?php echo $getallproj['1']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['1']['Project']['uniq_id']; ?>','<?php echo $getallproj['1']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['1']['Project']['name']; ?>'); <?php } ?>"><?php echo ucfirst($getallproj['1']['Project']['name']); ?></a></div>
            
            <?php if($getallproj['2']['Project']['uniq_id']) { ?>
            <div class="top_proj_ttc fl ellipsis-view stop_display_drpdn" style="max-width: 122px;display:none;" id="second_recent" ><a title="<?php echo ucfirst($getallproj['2']['Project']['name']); ?>" rel="tooltip" href="javascript:void(0);" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['2']['Project']['uniq_id']; ?>','<?php echo $getallproj['2']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['2']['Project']['uniq_id']; ?>','<?php echo $getallproj['2']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['2']['Project']['name']; ?>'); <?php } ?>"><?php echo ucfirst($getallproj['2']['Project']['name']); ?></a></div>
			<?php } ?>
			<a href="javascript:void(0);" onclick="view_project_menu('<?php echo PAGE_NAME;?>');" data-toggle="dropdown" class="option-toggle" id="prj_ahref">
			    <i class="caret"></i>
			</a>
			<div class="dropdown-menu lft popup" id="projpopup">
			    <center>
				<div id="loader_prmenu" style="display:none;">
				    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/>
				</div>
			    </center>
			    <?php if(count($getallproj) >= 6) { ?>
			    <div id="find_prj_dv" style="display: none;">
				<input type="text" placeholder="<?php echo __('Find a Project');?>" class="form-control pro_srch" onkeyup="search_project_menu('<?php echo PAGE_NAME;?>',this.value,event)" id="search_project_menu_txt">
				<i class="icon-srch-img"></i>
				<div id="load_find_dashboard" style="display:none;" class="loading-pro">
				    <img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
				</div>
			    </div>
			    <?php } ?>
			    <div id="ajaxViewProject" style='display:none;'></div>
				<div id="ajaxViewProjects"></div>
			</div>
	<?php } ?>
	<?php } ?>
	<?php }?>
	</li>
    
	<?php } ?>
<?php if((CONTROLLER == "reports" && (PAGE_NAME == "glide_chart" || PAGE_NAME == "chart" || PAGE_NAME == "hours_report"))|| (CONTROLLER == "Ganttchart" && (PAGE_NAME == "manage"||PAGE_NAME == "ganttv2"))) { ?>
	<li class="dropdown" id="prj_drpdwn">
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { } else {?><?php echo __('Project');?>: <?php } ?>
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { ?>
		<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
		<button class="btn btn_blue" type="button" onClick="newProject();"><?php echo __('Create Project');?></button>
	<?php } ?>
	<?php }else{
		 if(count($getallproj)=='0'){ ?>
		    --<?php echo __('None');?>--
	<?php } else {
	 if(count($getallproj)=='1'){
				echo $getallproj['0']['Project']['name'];
			    $swPrjVal = $getallproj['0']['Project']['name'];
			}else{
			    $swPrjVal = $this->Format->shortLength($projName,30); ?>
			<a href="javascript:void(0);" onclick="view_project_menu('<?php echo PAGE_NAME;?>');" data-toggle="dropdown" class="option-toggle" id="prj_ahref" style="top:0px !important;">
			    <span id="pname_dashboard" class="ttc" style="color:#FFF !important"><?php echo isset($getallproj['0']['Project']['name'])?$getallproj['0']['Project']['name']:ucfirst($swPrjVal); ?></span>
			    <i class="caret"></i>
			</a>
			<div class="dropdown-menu lft popup" id="projpopup">
			    <center>
				<div id="loader_prmenu" style="display:none;">
				    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/>
				</div>
			    </center>
			    <?php if(count($getallproj) >= 6) { ?>
			    <div id="find_prj_dv" style="display: none;">
				<input type="text" placeholder="<?php echo __('Find a Project');?>" class="form-control pro_srch" onkeyup="search_project_menu('<?php echo PAGE_NAME;?>',this.value,event)" id="search_project_menu_txt">
				<i class="icon-srch-img"></i>
				<div id="load_find_dashboard" style="display:none;" class="loading-pro">
				    <img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
				</div>
			    </div>
			    <?php } ?>
			    <div id="ajaxViewProject" style='display:none;'></div>
				<div id="ajaxViewProjects"></div>
			</div>
	<?php } ?>
	<?php } ?>
	<?php }?>
	</li>
	<?php } ?>
	<?php if(PAGE_NAME=='dashboard' ||  PAGE_NAME == 'invoice'){?>
        <li  class="kanbn dashborad-view-type" id="select_view" style="display: none;width:700px;">
	<a href="<?php echo HTTP_ROOT.'dashboard#overview';?>" onclick="return checkHashLoad('overview');dashboadrview_ga('Overview');trackEventWithIntercom('overview','');"><span id="overview_btn" class="btn gry_btn kan30" title="Overview"><?php echo __('Overview');?></span></a>
	<a href="<?php echo HTTP_ROOT.'dashboard#tasks';?>" onclick="trackEventWithIntercom('task-list','');checkHashLoad('tasks');dashboadrview_ga('List');"><span id="lview_btn" class="btn gry_btn kan30" title="List View"><i class="icon-list-view"></i><?php echo __('List');?></span></a>
	<?php /*<a href="<?php echo HTTP_ROOT.'dashboard#tasks';?>" onclick="checkHashLoad('compactTask');dashboadrview_ga('Compact');"><span id="cview_btn" class="btn gry_btn kan30" title="Compact View"><i class="icon-compact-view"></i>Compact</span></a>*/?>
	 <?php if($this->Format->isAllowed('View Milestones',$roleAccess)){ ?> 
        <a href="javascript:void(0);" onclick="trackEventWithIntercom('task-group','');groupby('milestone',event);dashboadrview_ga('Task Group');"><span id="cview_btn" class="btn gry_btn kan30" title="Task Group View"><i class="icon-compact-view"></i><?php echo __('Task Group');?></span></a>
    <?php } ?>
	<?php $kanbanurl = '';
        $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist'; 
        ?>
        <?php if($this->Format->isAllowed('View Kanban',$roleAccess)){ ?> 
    <a href="<?php echo HTTP_ROOT.'dashboard#'.$kanbanurl;?>" onclick="trackEventWithIntercom('kanban','');checkHashLoad('<?php echo $kanbanurl; ?>');dashboadrview_ga('Kanban');"><span id="kbview_btn" class="btn gry_btn kan30" title="Kanban View"><i class="icon-kanv-view"></i><?php echo $this->Format->displayKanbanOrBoard();//__('Kanban');?></span></a>
<?php } ?>
<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?> 
	<a href="<?php echo HTTP_ROOT.'dashboard#files';?>" onclick="trackEventWithIntercom('files',''); checkHashLoad('files');trackEventGoogle('Page','Files','');">
    <span id="files_btn" class="btn gry_btn kan30" title="Files"><i class="icon-files-view"></i><?php echo __('Files');?></span>	
    </a>
<?php } ?>
	<a href="<?php echo HTTP_ROOT.'dashboard#activities';?>" onclick="checkHashLoad('activities');dashboadrview_ga('Activities');"><span id="actvt_btn" class="btn gry_btn kan30" title="Activities"><i class="icon-actvt-view"></i><?php echo __('Activities');?></span></a>
	<?php if($this->Format->isAllowed('View Calendar',$roleAccess)){ ?>
    <a href="<?php echo HTTP_ROOT.'dashboard#calendar';?>" onclick="trackEventWithIntercom('calendar',''); calendarView('calendar');dashboadrview_ga('Calendar');">
    <span id="calendar_btn" class="btn gry_btn kan30" title="Calendar"><i class="icon-calender-view"></i><?php echo __('Calendar');?></span>
    </a>
<?php } ?>
	<?php $timelogurl = '';
        $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog'; 
    ?>
	<a href="<?php echo HTTP_ROOT.'dashboard#'.$timelogurl;?>" onclick="trackEventWithIntercom('time-log','');checkHashLoad('timelog');">
    <span id="timelog_btn" class="btn gry_btn kan30" title="Time Log"><i class="icon-timelog-view"></i><?php echo __('Time Log');?></span>	
    </a>
    <?php if($this->Format->isAllowed('View Invoices',$roleAccess)){ ?>
    <a onclick="trackEventWithIntercom('invoice','');" href="<?php echo HTTP_ROOT.'easycases/invoice';?>">
    <span id="invoice_btn" class="btn gry_btn kan30" title="Invoice"><i class="icon-invoice-view"></i><?php echo __('Invoice');?></span>	
    </a>
<?php } ?>
	<?php if(SITE_NAME !='Orangescrum.com'){?>
		<?php /*<a href="<?php echo HTTP_ROOT.'dashboard#milestone';?>" onclick="checkHashLoad('milestone');"><div id="mlst_btn" class="btn gry_btn kan30" style="border-radius:0 3px 3px 0"  title="Task Group"><i class="icon-mlst-view"></i></div></a>*/?>
	<?php }?>
    <!--     FILTER SECTION -->
        <div class="fr filter_rt" style="margin-left: 6px;" title="Filters" rel="tooltip">
            <div class="fl task_section case-filter-menu " data-toggle="dropdown" onclick="openfilter_popup('0' ,'dropdown_menu_all_filters');">
                <button type="button" class="btn tsk-menu-filter-btn" onclick="filter_ga()">
                <a href="javascript:void(0);" class="flt-txt"><i class="db-filter-icon"></i><i class="caret"></i></a>
                </button>
                    <ul class="dropdown-menu" id="dropdown_menu_all_filters" style="position: absolute;">
                        <li class="pop_arrow_new"></li>
                            <li class="log">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('createdDate',event);"> <?php echo __('Date');?></a>
                            <div class="dropdown_status" id="dropdown_menu_createddate_div">
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_createddate">
                        <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_alldates" data-id="alldates" onclick="general.filterDate('timelog', 'alldates','All', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'alldates','All', 'text');"><?php echo __('All Dates');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_today" data-id="today" onclick="general.filterDate('timelog', 'today','Today', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'today','Today', 'text');"><?php echo __('Today');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_yesterday" data-id="yesterday" onclick="general.filterDate('timelog', 'yesterday','Yesterday', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'yesterday','Yesterday', 'text');"><?php echo __('Yesterday');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_thisweek" data-id="thisweek" onclick="general.filterDate('timelog', 'thisweek','This Week', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'thisweek','This Week', 'text');"><?php echo __('This Week');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_thismonth" data-id="thismonth" onclick="general.filterDate('timelog', 'thismonth','This Month', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'thismonth','This Month', 'text');"><?php echo __('This Month');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_thisquarter" data-id="thisquarter" onclick="general.filterDate('timelog', 'thisquarter','This Quarter', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'thisquarter','This Quarter', 'text');"><?php echo __('This Quarter');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_thisyear" data-id="thisyear" onclick="general.filterDate('timelog', 'thisyear','This Year', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'thisyear','This Year', 'text');"><?php echo __('This Year');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_lastweek" data-id="lastweek" onclick="general.filterDate('timelog', 'lastweek','Last Week', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'lastweek','Last Week', 'text');"><?php echo __('Last Week');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_lastmonth" data-id="lastmonth" onclick="general.filterDate('timelog', 'lastmonth','Last Month', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'lastmonth','Last Month', 'text');"><?php echo __('Last Month');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_lastquarter" data-id="lastquarter" onclick="general.filterDate('timelog', 'lastquarter','Last Quarter', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'lastquarter','Last Quarter', 'text');"><?php echo __('Last Quarter');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_lastyear" data-id="lastyear" onclick="general.filterDate('timelog', 'lastyear','Last Year', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'lastyear','Last Year', 'text');"><?php echo __('Last Year');?></font>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <input type="checkbox" <?php if($_COOKIE['Timelog_filter'] == 'alldates'){ echo "checked"; } ?> id="timelog_last365days" data-id="last365days" onclick="general.filterDate('timelog', 'last365days','Last 365 days', 'check');"/>
                                            <font style="padding-left:5px;" onclick="general.filterDate('timelog', 'last365days','Last 365 days', 'text');"><?php echo __('Last 365 days');?></font>
                                        </a>
                                    </li>                                    
                                    <li>
                                        <a class="anchor" class="cstm-dt-option" onclick="customdatetlog();">
                                            <button type="button" class="ui-datepicker-trigger"><img src="<?php echo HTTP_ROOT; ?>img/images/calendar.png" alt="..." title="..."></button>
                                            <span style="position:relative;top:2px;cursor:text;"><?php echo __('Custom Date');?></span>
                                        </a>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <input type="text" class="smal_txt" placeholder="<?php echo __('From Date');?>" readonly  style="width:115px;height:30px;font-size:13px !important;" id="logstrtdt" value="<?php echo $frm; ?>"/>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <input type="text" class="smal_txt" placeholder="<?php echo __('To Date');?>" readonly style="width:115px;height:30px;font-size:13px !important;" id="logenddt" value="<?php echo $to; ?>"/>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <button class="btn btn_blue aply_btn" type="button" style="height:30px;width:115px;" onclick="general.filterDate('timelog', 'custom','Custom');" id="btn_timelog_search"><?php echo __('Search');?></button>
                                    </li>
                                </ul>
                            </div>
                            </li>
                            <li class="log">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('resource',event);"> <?php echo __('Resource');?></a>
                            <div class="dropdown_status" id="dropdown_menu_resource_div">
                                <input type="hidden" id="tlog_date" value=""/>
                                <input type="hidden" id="tlog_resource" value=""/>
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_resource"></ul>
                            </div>
                            </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('date',event);"> <?php echo __('Time');?></a>
                            <div class="dropdown_status" id="dropdown_menu_date_div">
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_date"></ul>
                            </div>
                        </li>
                        <li id="tskgrpli" style="display:none;" class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('tskgrp',event);"> <?php echo __('Task Group');?></a>
                            <div class="dropdown_status" id="dropdown_menu_tskgrp_div">
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_tskgrp"></ul>
                            </div>
                        </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('duedate',event);"> <?php echo __('Due Date');?></a>
                            <div class="dropdown_status" id="dropdown_menu_duedate_div">
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_duedate"></ul>
                            </div>
                        </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('status',event);"><?php echo __('Status');?></a>
                            <div class="dropdown_status" id="dropdown_menu_status_div">
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_status"></ul>
                            </div>
                        </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('types',event);"><?php echo __('Types');?></a>
                            <div class="dropdown_status" id="dropdown_menu_types_div" >
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_types"></ul>
                            </div>
        
                        </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('priority',event);"><?php echo __('Priority');?></a>
                            <div class="dropdown_status" id="dropdown_menu_priority_div" >
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_priority"></ul>
        
                            </div>
                        </li>
                        <?php if((count($getallproj) == 0)) { } else { ?>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('users',event);"><?php echo __('Created by');?> </a>
                            <div class="dropdown_status" id="dropdown_menu_users_div" >
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_users"></ul>
                            </div>
                        </li>
                        <li class="nolog">
                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('assignto',event);"><?php echo __('Assign To');?></a>
                            <div class="dropdown_status" id="dropdown_menu_assignto_div" >
                                <i class="status_arrow_new"></i>
                                <ul class="dropdown-menu" id="dropdown_menu_assignto"></ul>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                 <div class="cb"></div>    
                </div>
        <!--<button style="margin-left:14px;padding:2px 10px;" onclick="addEditMilestone('','','','','','');" id="mlist_crt_mlstbtn" type="button" rel="tooltip" title="New Task Group" value="Create Task Group" class="btn btn_blue fr">+</button>-->
            <div class="cb"></div> 
            <script type="text/javascript">
                $(".timelog_filter_msg_close").on('click',function(){
                    $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr("checked");
                    $('#dropdown_menu_resource').find('input[type="checkbox"]').removeAttr("checked");
                    $('#tlog_date').val('');
                    $('#tlog_resource').val('');
                    $('#logstrtdt').val('');
                    $('#logenddt').val('');
                    ajaxTimeLogView();
                    //general.filterDate('timelog', 'alldates','All', 'check');
                });
                /*$(document).bind('click', function(e) {
                    var $clicked = $(e.target);
                    if (! ($clicked.parents().hasClass("dropdown")) && !($('#ui-datepicker-div').is(":visible"))){
                        //$(".dropdown .more_opt ul").hide();
                        $("#blk_timelog_date_filter").removeClass('open').addClass('close');
                    }else{
                        $("#blk_timelog_date_filter").removeClass('close').addClass('open');
                    }
                });*/
            </script>
 <!-- END FILTER SECTION -->   
	</li>
	<?php } ?>
	<?php/* if(CONTROLLER == 'easycases' && (PAGE_NAME  == 'timelog' || PAGE_NAME  == 'dashboard')){ ?>
        <li class="bcrumbtimelog" id="tasklogbreadcum" style="display: none;float: right;margin-right:133px;">
		<div class="fr filter_dt1 filter_analytics timelog-cal1">
            <div class="task_due_dt">
		<div class="fl" style="padding:4px;">
                            <div class="dropdown fl close" id='blk_timelog_date_filter' data-filter="">
                                <div class="dt_fl fl"></div>
                                <div class="fl" data-toggle="dropdown" style="cursor:pointer">
                                    <span class="show_dt" id="" title="">
                                        <span class="over-due" id="filter_date_lbl">All</span>
                                        <span class="due_dt_icn"></span>
                                    </span>
                                    <span id="datelod_timelog" class="asgn_loader">
                                        <img src="<?php echo HTTP_ROOT;?>img/images/del.gif" alt="Loading..." title="Loading...">
                                    </span>
                                </div>
                                <ul class="dropdown-menu dudt_dropdown-caret" style="left: -100px;">
                                    <li class="pop_arrow_new" style='left: 125px; top: -12px; margin: 0px;'></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'alldates','All');">All Dates</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'today','Today');">Today</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'yesterday','Yesterday');">Yesterday</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'thisweek','This Week');">This Week</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'thismonth','This Month');">This Month</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'thisquarter','This Quarter');">This Quarter</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'thisyear','This Year');">This Year</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'lastweek','Last Week');">Last Week</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'lastmonth','Last Month');">Last Month</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'lastquarter','Last Quarter');">Last Quarter</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'lastyear','Last Year');">Last Year</a></li>
                                    <li><a class="anchor" onclick="general.filterDate('timelog', 'last365days','Last 365 days');">Last 365 days</a></li>                                    
                                    <li>
                                        <a class="anchor" class="cstm-dt-option" onclick="$('.custome_timelog').toggle();">
                                            <button type="button" class="ui-datepicker-trigger"><img src="<?php echo HTTP_ROOT; ?>img/images/calendar.png" alt="..." title="..."></button>
                                            <span style="position:relative;top:2px;cursor:text;">Custom Date</span>
                                        </a>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <input type="text" class="smal_txt" placeholder="From Date" readonly  style="width:115px;height:30px;font-size:13px !important;" id="logstrtdt" value="<?php echo $frm; ?>"/>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <input type="text" class="smal_txt" placeholder="To Date" readonly style="width:115px;height:30px;font-size:13px !important;" id="logenddt" value="<?php echo $to; ?>"/>
                                    </li>
                                    <li class="custome_timelog" style="display: none;text-align: center;margin:5px 0;">
                                        <button class="btn btn_blue aply_btn" type="button" style="height:30px;width:115px;" onclick="general.filterDate('timelog', 'custom','Custom');" id="btn_timelog_search">Search</button>
                                    </li>
                                </ul>
                            </div>
                               <?php /*?> 
			<input type="text" class="smal_txt" placeholder="From Date" readonly  style="width:115px;height:30px;font-size:13px !important;" id="logstrtdt" value="<?php echo $frm; ?>"/> <span>-</span>
			<input type="text" class="smal_txt" placeholder="To Date" readonly style="width:115px;height:30px;font-size:13px !important;" id="logenddt" value="<?php echo $to; ?>"/>
                                <?php ?>
                                
		</div>
		<div class="fl" style="margin-left:10px;">
		<select class="form-control" id="rsrclog" style="height:30px;">
		<option value="">Select Resource</option>
		<?php if(is_array($rsrclist)){
                    foreach($rsrclist as $uid=>$uname) { 
                        ?>
                    <option value="<?php echo $uid; ?>"><?php echo $uname; ?></option>
                <?php } 
                }
                ?>
		</select>
		</div>
		<div class="fl apply_button">
			<div id="apply_btn" class="fl">
				<button class="btn btn_blue aply_btn" type="button" style="height:30px;" onclick= "showtimelog('datesrch');" value="Update" name="submit_Profile" id="submit_Profile">Search</button>
			</div>
		</div>
	</div>
		</div>
            <div class="cb"></div> 
	</li>
	<?php } */?>
	<li  class="kanbn dashborad-view-type" id="select_view_mlst" style="display: none;">
		<!--<a href="<?php echo HTTP_ROOT.'dashboard#milestone';?>" onclick="checkHashLoad('milestone');" ><div id="mlview_btn" class="btn gry_btn kan30" title="Manage Task Group"><i class="icon-list-view"></i></div></a>-->
		<!--<a href="<?php echo HTTP_ROOT.'dashboard#milestonelist';?>" onclick="checkHashLoad('milestonelist');"><div id="mkbview_btn" class="btn gry_btn kan30" style="border-radius:3px 0 0 3px;"  title="Task Group Kanban View"><i class="icon-kanv-view"></i></div></a>
		<a href="<?php echo HTTP_ROOT.'dashboard#milestone';?>" onclick="groupby('milestone',event);dashboadrview_ga('Task Group');"><div id="mlview_btn" class="btn gry_btn kan30" title="Task Group List View" style="border-radius:0 3px 3px 0"><i class="icon-list-view"></i></div></a>
		<!--<a href="javascript:void(0);" onclick="addEditMilestone(this);" id="mlist_crt_mlstbtn" class="mlstlink_new" data-name="" data-uid="" data-id="">Create Task Group</a>-->
		<!--<button style="margin-left:25px;" onclick="addEditMilestone('','','','','','');" id="mlist_crt_mlstbtn" type="button" value="Create Task Group" class="btn btn_blue">    + Task Group   </button>-->
	</li>
   <div class="cb"></div> 
   <div class="filter_det">
        <div class="filter_btn_section fr" id="savereset_filter">
            <div class="fl db-filter-reset-icon" style="display:none;" id="reset_btn" title="<?php echo __('Reset Filters');?>" rel="tooltip" onClick="resetAllFilters('all');"></div>
        </div>
        <div class="fr" id="filtered_items"></div>
        <div class="cb"></div>    
    </div>
</ol>
<?php /* <ol class="breadcrumb breadcrumb_fixed" style="border:2px solid red;">
	<li>
		<a href="<?php echo HTTP_ROOT.Configure::read('default_action');?>">	<i class="icon-home"></i></a>
	</li>
<?php if(CONTROLLER == "easycases" && (PAGE_NAME == "mydashboard")) { ?>
	<li>Dashboard</li>
<?php } ?>
<?php if(CONTROLLER == "easycases" && (PAGE_NAME == "files")) { ?>
	<li>Files</li>
<?php } ?>
<?php if(CONTROLLER == "milestones" && (PAGE_NAME == "milestone" || PAGE_NAME=='milestonelist')) { ?>
	<li>Task Group</li>
<?php } ?>
<?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")) { ?>
	<li>Archive</li>
	<li>Tasks</li>
<?php } ?>
<?php if(CONTROLLER == "projects" && (PAGE_NAME == "manage")) { ?>
	<li>Projects</li>
	<li>Manage</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "manage")) { ?>
	<li>Users</li>
	<li>Manage</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "profile")) { ?>
	<li>Personal Settings</li>
	<li>My Profile</li>
<?php }
	if(CONTROLLER == "users" && (PAGE_NAME == "changepassword")) { ?>
	<li>Personal Settings</li>
	<li>Change Password</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "email_notifications")) { ?>
	<li>Personal Settings</li>
	<li>Notifications</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "email_reports")) { ?>
	<li>Personal Settings</li>
	<li>Email Reports</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "mycompany")) { ?>
	<li>Company Settings</li>
	<li>My Company</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "dailyupdatealerts")) { ?>
	<li>Company Settings</li>
	<li>Daily Catch-Up</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "importexport")) { ?>
	<li>Company Settings</li>
	<li>Import & Export</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "cancelact")) { ?>
	<li>Company Settings</li>
	<li>Cancel Account</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "subscription")) { ?>
	<li>Account Settings</li>
	<li>Subscription</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "creditcard")) { ?>
	<li>Account Settings</li>
	<li>Credit Card</li>
<?php }
	if(CONTROLLER == "users" && (PAGE_NAME == "transaction")) { ?>
	<li>Account Settings</li>
	<li>Transactions</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "account_activity")) { ?>
	<li>Account Settings</li>
	<li>Account Activity</li>
<?php } 
if(CONTROLLER == "users" && (PAGE_NAME == "upgrade_member")) { ?>
	<li>Subscription</li>
	<li>Upgrade Subscription</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "downgrade")) { ?>
	<li>Subscription</li>
	<li>Downgrade Subscription</li>
<?php } 
	if(CONTROLLER == "users" && (PAGE_NAME == "edit_creditcard")) { ?>
	<li>Credit Card</li>
	<li>Edit Credit Card</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "confirmationPage")) { ?>
	<li>Subscription</li>
	<li>Account Limitation</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "pricing")) { ?>
	<li>Subscription</li>
	<li>Pricing</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "activity")) { ?>
	<li>Activities</li>
<?php } ?>	
<?php if(CONTROLLER == "projects" && (PAGE_NAME == "importexport" || PAGE_NAME=='csv_dataimport' || PAGE_NAME=='confirm_import') ) { ?>
	<li>Company Settings</li>
	<li>Import & Export</li>
<?php }
    if(CONTROLLER == "projects" && (PAGE_NAME == "task_type")) { ?>
	<li>Company Settings</li>
	<li>Task Type</li>
<?php } ?>	
<?php if(CONTROLLER == "projects" && PAGE_NAME == "labels"){ ?>
	<li>Company Settings</li>
	<li>Manage Labels</li>
<?php } ?>
<?php if(CONTROLLER == "projects" && PAGE_NAME == "groupupdatealerts"){ ?>
	<li>Company Settings</li>
	<li>Daily Progress Reminder</li>
<?php } ?>	
<?php if(CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) {?>
	<li><span id="brdcrmb-cse-hdr">Tasks</span></li>
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "view_templates")) {?>
	<li>Template</li>
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "projects")) {?>
	<li>Templates</li>
	<li>Project</li>
<?php } ?>
<?php if(CONTROLLER == "templates" && (PAGE_NAME == "tasks")) {?>
	<li>Templates</li>
	<li>Task</li>
<?php } ?>

<?php if(CONTROLLER == "reports" && (PAGE_NAME == "glide_chart")) {?>
	<li>Analytics</li>
	<li>Bug Reports</li>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "hours_report")) {?>
	<li>Analytics</li>
	<li>Hours Spent Reports</li>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "chart")) {?>
	<li>Analytics</li>
	<li>Task Reports</li>
<?php } ?>
<?php if(CONTROLLER == "users" && (PAGE_NAME == "cancel_account")) {?>
	<li>Account</li>
	<?php if(($user_subscription['subscription_id']>1) && !$user_subscription['is_free']){?>
	<li>Cancel Account</li>
	<?php }else{?>
	<li>Delete Account</li>
	<?php } ?>
<?php } ?>
<?php if(CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) {?>
	<li>Analytics</li>
	<li>Weekly Usage Report</li>
	<li>Project: <span class="weekly_all">All</span></li>
<?php } ?>
<?php if((CONTROLLER == "easycases" && (PAGE_NAME == "dashboard" || PAGE_NAME == "mydashboard")) || (CONTROLLER == "milestones" && (PAGE_NAME == "milestone" || PAGE_NAME=='milestonelist')) || (CONTROLLER == "users" && (PAGE_NAME == "activity"))) {?>
	<li class="dropdown" id="prj_drpdwn">
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { } else {?>Project: <?php } ?>
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3) ) { ?>
		<button class="btn btn_blue" type="button" onClick="newProject();">Create Project</button>
	<?php }else{
		 if(count($getallproj)=='0'){ ?>
		    <i style="color:#FF0000">None</i>
	<?php } else {
			if(count($getallproj)=='1'){
				echo "<span style='color:#000;'>".$this->Format->shortLength(ucfirst($getallproj['0']['Project']['name']),20)."</span>";
			    $swPrjVal = $getallproj['0']['Project']['name'];
			}else{
			    $swPrjVal = $this->Format->shortLength($projName,20); ?>
			<a href="javascript:void(0);" onclick="view_project_menu('<?php echo PAGE_NAME;?>');" data-toggle="dropdown" class="option-toggle" id="prj_ahref">
			    <div class="prjnm_ttc"><span id="pname_dashboard" class="ttc "><?php echo ucfirst($swPrjVal); ?></span></div>
			    <i class="caret"></i>
			</a>
			<div class="dropdown-menu lft popup" id="projpopup">
			    <center>
				<div id="loader_prmenu" style="display:none;">
				    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="loading..."/>
				</div>
			    </center>
			    <?php if(count($getallproj) >= 6) { ?>
			    <div id="find_prj_dv" style="display: none;">
				<input type="text" placeholder="Find a Project" class="form-control pro_srch" onkeyup="search_project_menu('<?php echo PAGE_NAME;?>',this.value,event)" id="search_project_menu_txt">
				<i class="icon-srch-img"></i>
				<div id="load_find_dashboard" style="display:none;" class="loading-pro">
				    <img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
				</div>
			    </div>
			    <?php } ?>
			    <div id="ajaxViewProject" style='display:none;'></div>
				<div id="ajaxViewProjects"></div>
			</div>
	<?php } ?>
	<?php } ?>
	<?php }?>
	</li>
	<?php } ?>

<?php if(CONTROLLER == "reports" && (PAGE_NAME == "glide_chart" || PAGE_NAME == "chart" || PAGE_NAME == "hours_report")) { ?>
	<li class="dropdown" id="prj_drpdwn">
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { } else {?>Project: <?php } ?>
	<?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { ?>
		<button class="btn btn_blue" type="button" onClick="newProject();">Create Project</button>
	<?php }else{
		 if(count($getallproj)=='0'){ ?>
		    --None--
	<?php } else {
	 if(count($getallproj)=='1'){
				echo $getallproj['0']['Project']['name'];
			    $swPrjVal = $getallproj['0']['Project']['name'];
			}else{
			    $swPrjVal = $this->Format->shortLength($projName,30); ?>
			<a href="javascript:void(0);" onclick="view_project_menu('<?php echo PAGE_NAME;?>');" data-toggle="dropdown" class="option-toggle" id="prj_ahref" style="top:0px !important;">
			    <span id="pname_dashboard" class="ttc" style="color:#FFF !important"><?php echo isset($getallproj['0']['Project']['name'])?$getallproj['0']['Project']['name']:ucfirst($swPrjVal); ?></span>
			    <i class="caret"></i>
			</a>
			<div class="dropdown-menu lft popup" id="projpopup">
			    <center>
				<div id="loader_prmenu" style="display:none;">
				    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="loading..."/>
				</div>
			    </center>
			    <?php if(count($getallproj) >= 6) { ?>
			    <div id="find_prj_dv" style="display: none;">
				<input type="text" placeholder="Find a Project" class="form-control pro_srch" onkeyup="search_project_menu('<?php echo PAGE_NAME;?>',this.value,event)" id="search_project_menu_txt">
				<i class="icon-srch-img"></i>
				<div id="load_find_dashboard" style="display:none;" class="loading-pro">
				    <img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
				</div>
			    </div>
			    <?php } ?>
			    <div id="ajaxViewProject" style='display:none;'></div>
				<div id="ajaxViewProjects"></div>
			</div>
	<?php } ?>
	<?php } ?>
	<?php }?>
	</li>
	<?php } ?>
	<?php if(PAGE_NAME=='dashboard'){?>
	<li  class="kanbn dashborad-view-type" id="select_view">
	<a href="<?php echo HTTP_ROOT.'dashboard#tasks';?>" onclick="checkHashLoad('tasks');dashboadrview_ga('List');"><div id="lview_btn" class="btn gry_btn kan30" title="List View"><i class="icon-list-view"></i></div></a>
	<a href="<?php echo HTTP_ROOT.'dashboard#tasks';?>" onclick="checkHashLoad('compactTask');dashboadrview_ga('Compact');"><div id="cview_btn" class="btn gry_btn kan30" title="Compact View"><i class="icon-compact-view"></i></div></a>
	<a href="<?php echo HTTP_ROOT.'dashboard#kanban';?>" onclick="checkHashLoad('kanban');dashboadrview_ga('Kanban');"><div id="kbview_btn" class="btn gry_btn kan30" style="border-radius:0 3px 3px 0"  title="Kanban View"><i class="icon-kanv-view"></i></div></a>
	<a href="<?php echo HTTP_ROOT.'dashboard#activities';?>" onclick="checkHashLoad('activities');dashboadrview_ga('Activities');"><div id="actvt_btn" class="btn gry_btn kan30" style="border-radius:0 3px 3px 0"  title="Activities"><i class="icon-actvt-view"></i></div></a>
	<a href="<?php echo HTTP_ROOT.'dashboard#calendar';?>" onclick="calendarView('calendar');dashboadrview_ga('Calendar');"><div id="calendar_btn" class="btn gry_btn kan30" style="border-radius:0 3px 3px 0"  title="Calendar"><img src="/img/calendar.png" style="margin-top:-8px;margin-left:-2px"></img></div></a>
	<?php if(SITE_NAME !='Orangescrum.com'){?>
	<?php }?>
	</li>
	<?php } ?>
	<li  class="kanbn dashborad-view-type" id="select_view_mlst" style="display: none;">
		<a href="<?php echo HTTP_ROOT.'dashboard#milestonelist';?>" onclick="checkHashLoad('milestonelist');"><div id="mkbview_btn" class="btn gry_btn kan30" style="border-radius:3px 0 0 3px" title="Task Group Kanban View"><i class="icon-kanv-view"></i></div></a>
		<a href="<?php echo HTTP_ROOT.'dashboard#milestone';?>" onclick="groupby('milestone',event);dashboadrview_ga('Task Group');"><div id="mlview_btn" class="btn gry_btn kan30" title="Task Group List View" style="border-radius:0 3px 3px 0"><i class="icon-list-view"></i></div></a>
		<button style="margin-left:25px;display:none;" onclick="addEditMilestone(this);" id="mlist_crt_mlstbtn" type="button" value="Create Task Group" class="btn btn_blue">    Create Task Group   </button>
	</li>
	
</ol> */ ?>
</div>	
<div class="task_action_bar_div task_detail_head">
	<div class="task_action_bar">
		<button class="btn gry_btn task_detail_back" type="button">
		</button>
		<div class="fr">
			<button class="btn gry_btn next" type="button" title="<?php echo __('Next');?>">

			<i class="icon-next"></i>
			</button>
		</div>
		<div class="fr">
			<button class="btn gry_btn prev" type="button" title="<?php echo __('Previous');?>">
			<i class="icon-prev"></i>
			</button>
		</div>
	</div><!-- Case Detail buttons -->
</div>
<div class="task_action_bar_div milestonekb_detail_head">
	<div class="task_action_bar">
		<button class="btn gry_btn task_detail_back" type="button" style="margin-left:18px;">
		</button>
	</div><!-- Case Detail buttons -->
</div>
<?php } ?>