<input type='hidden' id='hiddensavennew' value='0'/>
<?php if (!empty($sun_error)) { ?>
    <div class="fixed-n-bar1" style="display:none">
        <div class="text-center">
            <?php echo __('Your account will be de-activated exactly on');?> <span style="font-weight:bold;"><?php echo $sun_error; ?></span> <?php echo __('due to failed payment');?>.&nbsp;<span class="resend-email"><a href="<?php echo HTTP_ROOT . "pricing"; ?>"><?php echo __('Upgrade');?></a></span> <?php echo __('on or before');?> <span style="font-weight:bold;"><?php echo $sun_error; ?></span> <?php echo __('to continue uninterrupted orangescrum');?>.
            <span class="fr" style="background-color:#FFE5CA;margin-right:30px;width:20px;display:block;">
                <a id="closevarifybtn" href="javascript:void(0);" class="close" onclick="closesubscription()">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </span>
        </div>
    </div>
<?php } ?>
<?php if (CONTROLLER == 'easycases' && PAGE_NAME == 'mydashboard') { ?>
    <div class="task-list-bar dbrd-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-md-7">
                    <h2><?php echo __('Dashboard');?></h2>
                </div>
                <?php if (SES_TYPE < 3) { ?>
                    <?php $chk_accnt_sts = $this->Format->getAlertText($rem_users, $used_projects_count, $remspace, $used_storage); ?>
                    <div class="col-lg-4 fr">
                        <?php if ($chk_accnt_sts != '') { ?>
                            <div class="warning_circle_icon">
                                <i class="material-icons">&#xE000;</i>
                                <div class="manage_plan_setting">
                                    <?php echo $chk_accnt_sts; ?>
                                    <span class="okey"><?php echo __('Okay');?>!</span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-5 col-sm-5 m-top-bar text-right">
                        <div class="top_total_spent_hrs">
                            <div class="col-md-6"></div>
                            <div class="date col-md-6">
                                <strong><?php echo __('Hrs. Spent this week'); ?></strong>
                                <span id="spent_hr_stdt"><?php echo $this->Format->format_time_hr_min($totalhours) != '' ? $this->Format->format_time_hr_min($totalhours) : '00 hrs & 00 mins'; ?></span>
                            </div>
                            <div class="cb"></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="cb"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php } elseif (CONTROLLER == 'users' && PAGE_NAME == 'cancel_account') { ?>
    <div class="task-list-bar dbrd-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo __('Cancel Account');?></h2>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (CONTROLLER == 'users' && PAGE_NAME == 'pricing') { ?>

    <div class="task-list-bar dbrd-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-8">
                    <h2><?php echo __('Simple & Flexible Pricing');?></h2>
                </div>
                <?php if (SES_TYPE < 3) { ?>
                    <?php $chk_accnt_sts = $this->Format->getAlertText($rem_users, $used_projects_count, $remspace, $used_storage); ?>
                    <div class="col-lg-4">
                        <?php if ($chk_accnt_sts != '') { ?>
                            <div class="warning_circle_icon">
                                <i class="material-icons">&#xE000;</i>
                                <div class="manage_plan_setting <?php
                                if (isset($_SESSION['show_info']) && $_SESSION['show_info'] == 1) {
                                    $_SESSION['show_info'] = 2;
                                    ?>idsp<?php } ?>">
                                     <?php echo $chk_accnt_sts; ?>
                                    <span class="okey"><?php echo __('Okay');?>!</span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php } elseif ((CONTROLLER == 'users' && (PAGE_NAME == 'creditcard' || PAGE_NAME == 'edit_creditcard' || PAGE_NAME == 'transaction' || PAGE_NAME == 'subscription' || PAGE_NAME == 'account_activity'|| PAGE_NAME == 'cancel_subscription_os'))) { ?>
    <?php echo $this->element("account_settings"); ?>
<?php } elseif (CONTROLLER == 'projects' && PAGE_NAME == 'manage') { ?>
    <?php
    if ($projtype == '') {
        $cookie_value = 'active-grid';
    } elseif ($projtype == 'inactive') {
        $cookie_value = 'inactive-grid';
    }
    if ($projtype == 'active-grid') {
        $gr_cookie_value = '';
        $cookie_value = 'active-grid';
    } elseif ($projtype == 'inactive-grid') {
        $gr_cookie_value = 'inactive';
        $cookie_value = 'inactive-grid';
    }
    if ($projtype == 'active-grid' || $projtype == 'inactive-grid') {
        $act_grid_view_opt = "active-grid";
        $inact_grid_view_opt = "inactive-grid";
        $extr_proj_url_params = "/active-grid";
    } else {
        $act_grid_view_opt = "";
        $inact_grid_view_opt = "inactive";
        $extr_proj_url_params = "";
    }
    ?>
    <div class="task-list-bar  project-grid-page">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="<?php if($projtype !== 'active-grid') { ?> col-lg-6 col-sm-6  <?php  } else{ ?> col-lg-8 col-sm-8 <?php  } ?>">
                        <ul id="tour_crt_proj_swtch" class="lft_tab_tasklist fl">
                            <li class="all-list-glyph <?php if (($projtype == '' || $projtype == 'active-grid') && $filtype == '') { ?>active-list<?php } ?>">
                                <a href="javascript:void(0)" class="all-list" onclick="setDefaultProjectView('<?php echo $act_grid_view_opt; ?>');
                                        $('#projectLoader').show();">
                                    <i class="material-icons">&#xE0DF;</i>
                                    <?php echo __('All');?> <span id="active_proj_cnt" class="counter">(<?php echo $active_project_cnt; ?>)</span>
                                </a>
                            </li>
                            <li class="<?php if ($filtype == 'started') { ?>active-list<?php } ?>">
                                <a  href="<?php echo HTTP_ROOT; ?>projects/manage<?php echo $extr_proj_url_params; ?>?fil-type=started" onclick="$('#projectLoader').show();">
                                    <i class="material-icons">&#xE885;</i>
                                    <?php echo __('Started');?> <span id="started_proj_cnt" class="counter">(<?php echo isset($started_project_cnt) && $started_project_cnt > 0 ? $started_project_cnt : 0; ?>)</span>
                                </a>
                            </li>
                            <li class="<?php if ($filtype == 'on-hold') { ?>active-list<?php } ?>">
                                <a href="<?php echo HTTP_ROOT; ?>projects/manage<?php echo $extr_proj_url_params; ?>?fil-type=on-hold" onclick="$('#projectLoader').show();">
                                    <i class="material-icons">&#xE052;</i>
                                    <?php echo __('On Hold');?> <span id="hold_proj_cnt" class="counter">(<?php echo isset($hold_project_cnt) && $hold_project_cnt > 0 ? $hold_project_cnt : 0; ?>)</span>
                                </a>
                            </li>
                            <li class="<?php if ($filtype == 'stack') { ?>active-list<?php } ?>">
                                <a href="<?php echo HTTP_ROOT; ?>projects/manage<?php echo $extr_proj_url_params; ?>?fil-type=stack" onclick="$('#projectLoader').show();">
                                    <i class="material-icons">&#xE53B;</i>
                                    <?php echo __('Stack');?> <span id="stack_proj_cnt" class="counter">(<?php echo isset($stack_project_cnt) && $stack_project_cnt > 0 ? $stack_project_cnt : 0; ?>)</span>
                                </a>
                            </li>
                            <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                            <li class="<?php if (($projtype == 'inactive' || $projtype == 'inactive-grid') && $filtype == '') { ?>active-list<?php } ?>">
                                <a href="javascript:void(0);" onclick="setDefaultProjectView('<?php echo $inact_grid_view_opt; ?>');
                                        $('#projectLoader').show();">
                                    <i class="material-icons">&#xE86C;</i>
                                    <?php echo __('Completed');?> <span id="inactive_proj_cnt" class="counter">(<?php echo $inactive_project_cnt; ?>)</span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                   
                    <div class="col-lg-3 col-sm-3">
					    <div id="proj_filtered_items" class="filter_tag_items"></div>
				    </div>
                    <div class="<?php if($projtype !== 'active-grid') { ?> col-lg-3 col-sm-3  <?php  } else{ ?> col-lg-4 col-sm-4 <?php  } ?>">
                        <div id="tour_proj_view" class="fr pfl-icon-dv gidview-proj-menu">
                           
        
                        <span class="dropdown cursor">
						    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" rel="tooltip" title="<?php echo __('Filter');?>">
						    <i class="glyphicon glyphicon-filter"></i>
						    </a>
                            <ul class="dropdown-menu case-filter-menu kanbanview-filter profitable-report-filter drop_menu_mc dropdown_menu_all_filters_ul" style="z-index:1">
                                <!-- <li class="drop_menu_mc">
                                    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="project_allfiltervalue('project_type');"><i class="material-icons">&#xE916;</i><?php echo __('Project Type');?></a>
                                    <div class="dropdown_status" id="dropdown_menu_project_type_div">
                                        <i class="status_arrow_new"></i>
                                        <ul class="dropdown-menu" id="dropdown_menu_project_type" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                        </div>
                                </li> -->
						
						        <li class="drop_menu_mc dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="project_allfiltervalue('project_status');"><i class="material-icons">&#xE88B;</i><?php echo __('Project Status');?></a>
                                    <div class="dropdown_status" id="dropdown_menu_project_status_div">
                                        <i class="status_arrow_new"></i>
                                        <ul class="dropdown-menu" id="dropdown_menu_project_status" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                    </div>
						        </li>
						        <!-- <li class="drop_menu_mc">
                                    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="project_allfiltervalue('clients');"><i class="material-icons">&#xE8F9;</i><?php echo __('Client');?></a>
                                    <div class="dropdown_status" id="dropdown_menu_clients_div">
                                        <i class="status_arrow_new"></i>
                                        <ul class="dropdown-menu" id="dropdown_menu_clients" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                    </div>
						        </li> -->
							<!-- <?php if($this->Format->isAllowed('View All Resource',$roleAccess)){ ?>
                                <li class="drop_menu_mc dropdown">
                                    <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="project_allfiltervalue('project_manager');"><i class="material-icons">&#xE90F;</i><?php echo __('Project Manager');?></a>
                                    <div class="dropdown_status" id="dropdown_menu_project_manager_div">
                                        <i class="status_arrow_new"></i>
                                        <ul class="dropdown-menu" id="dropdown_menu_project_manager" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                    </div>
                                </li>
					        <?php } ?> -->
                            <!-- <li class="drop_menu_mc dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="project_allfiltervalue('project_start_date');"><i class="material-icons">label</i><?php echo __('Project Start Date');?></a>
                                <div class="dropdown_status" id="dropdown_menu_project_start_date_div">
                                    <i class="status_arrow_new"></i>
                                    <ul class="dropdown-menu" id="dropdown_menu_project_start_date" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                </div>
                            </li>
                            <li class="drop_menu_mc dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="project_allfiltervalue('project_end_date');"><i class="material-icons">local_atm</i><?php echo __('Project End Date');?></a>
                                    <div class="dropdown_status" id="dropdown_menu_project_end_date_div">
                                    <i class="status_arrow_new"></i>
                                    <ul class="dropdown-menu" id="dropdown_menu_project_end_date" style="max-height: 200px;overflow-y: scroll;margin-right:160px;"></ul>
                                </div>
                            </li> -->
					    </ul>
				    </span>
                            
							<span id="task_impExp" class="dropdown task_expPrnt case-filter-menu">
                                <a class="dropdown-toggle dropdown_menu_exp_print_togl pdf_export" data-toggle="dropdown" href="javascript:void(0);" data-target="#" >
                                    <span class="export_file_icon"></span>
                                        <ul>
                                           <li style="text-align:left;" onclick="openProjectListExportPopup('excel');"><?php echo __('Export as Excel');?></li>
										   <li style="text-align:left;" onclick="openProjectListExportPopup('csv');"><?php echo __('Export as CSV');?></li>
                                           <?php /*?><li onclick="pdfCaseView(this);" class="expPDFList"><?php echo __('Export as PDF');?></li><?php */?>
                                       </ul>
                                </a>
                            </span>
                            <span>
                                <a href="javascript:void(0);" onclick="setDefaultProjectView('<?php echo $gr_cookie_value; ?>');
                                        $('#projectLoader').show();" class="<?php if ($projtype == '' || $projtype == 'inactive') { ?>active<?php } ?>"  rel="tooltip" title="<?php echo __('Card View');?>">
                                    <i class="material-icons">&#xE42A;</i>
                                </a>
                            </span>
														<?php if(!IS_SKINNY){ ?>
                            <span>
                                <a href="javascript:void(0);" onclick="setDefaultProjectView('<?php echo $cookie_value; ?>');
                                        $('#projectLoader').show();" class="<?php if ($projtype == 'active-grid' || $projtype == 'inactive-grid') { ?>active<?php } ?>" rel="tooltip" title="<?php echo __('Grid View');?>">
                                    <i class="material-icons">&#xE5D2;</i>
                                </a>
                            </span>
														<?php } ?>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (CONTROLLER == 'Wiki' && PAGE_NAME == 'wikidetails') { ?>

	
	<div class="task-list-bar  project-grid-page">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-7">
                        <ul class="lft_tab_tasklist fl wikitab" id="mlsttab">
                            <li id="mlstab_act_wikis" class="invoice_lst_page_tabs active-list">
                                <a href="javascript:void(0)" class="all-list" onclick="switch_tab('allwikis')"><span class="wiki_icon prjwiki"></span> <?php echo __('Project Wikis');?></a>
                            </li>
                            <li id="mlstab_act_nonproj_wikis" class="invoice_lst_page_tabs">
                                <a href="javascript:void(0)" onclick="switch_tab('nonprojectwikis')" id="completed_tab"><span class="wiki_icon nonprjwiki"></span> <?php echo __('Non Project Wikis');?></a>
                            </li>
							<?php if ($this->Format->isAllowed('View Wiki',$roleAccess)) {  //SES_TYPE == 1 || SES_TYPE == 2
 ?>
								<li id="mlstab_assign_wikis" class="invoice_lst_page_tabs">
									<a href="javascript:void(0)" onclick="switch_tab('assigntomewiki')"><span class="wiki_icon assgnwiki"></span> <?php echo __('Assigned to Me');?></a>
								</li>
							<?php } ?>
                        </ul>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (CONTROLLER == 'users' && PAGE_NAME == 'manage') { ?>
    <div class="task-list-bar  user-grid-page">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-10">
                    <ul class="lft_tab_tasklist li_pad10">
                        <li id="tour_actv_user" class="all-list-glyph <?php if ($role == '' || $role == 'all') { ?>active-list<?php } ?>">
                            <a href="javascript:void(0)" class="all-list" onclick="filterUserRole('all', '');">
                                <i class="material-icons">&#xE7FD;</i>
                                <?php echo __('Active');?> <span class="counter">(<?php echo $active_user_cnt; ?>)</span></span>
                            </a>
                        </li>
                        <li id="tour_invt_user" <?php if ($role == 'invited') { ?>class="active-list" <?php } ?> onclick="filterUserRole('invited', '<?php echo $user_srch; ?>');">
                            <a href="javascript:void(0)">
                                <i class="material-icons">&#xE7FE;</i>
                                <?php echo __('Invited');?> <span class="counter">(<?php echo $invited_user_cnt; ?>)</span>
                            </a>
                        </li>
                        <li id="tour_disbl_user" <?php if ($role == 'disable') { ?>class="active-list" <?php } ?> onclick="filterUserRole('disable', '<?php echo $user_srch; ?>');">
                            <a href="javascript:void)(0)">
                                <i class="material-icons">&#xE909;</i>
                                <?php echo __('Disabled');?> <span class="counter">(<?php echo $disabled_user_cnt; ?>)</span>
                            </a>
                        </li>
                        <li  class="recent-icon <?php if ($role == 'recent') { ?>active-list<?php } ?>" onclick="filterUserRole('recent', '<?php echo $user_srch; ?>');">
                            <a href="javascript:void)(0)">
                                <i class="material-icons">&#xE8B3;</i>
                                <?php echo __('Recent');?> <span class="counter">(<?php echo $recent_user_cnt; ?>)</span>
                            </a>
                        </li>
                        <li id="tour_clint_user" <?php if ($role == 'client') { ?>class="active-list" <?php } ?> onclick="filterUserRole('client', '<?php echo $user_srch; ?>');">
                            <a href="javascript:void)(0)">
                                <i class="material-icons">&#xE7FB;</i>
                                <?php echo __('Client');?> <span class="counter">(<?php
                                    if ($client_user_cnt == 0) {
                                        echo '0';
                                    } else {
                                        echo $client_user_cnt;
                                    }
                                    ?>)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } elseif(CONTROLLER == "projects" && PAGE_NAME == "manageTimesheetSettings"){ ?>
	<div class="task-list-bar  analytics-bar">
	<div class="wrap_top_tlbar">
		<div class="row">
		</div>
	</div>
	</div>
<?php } else if ((CONTROLLER == "reports" || CONTROLLER == "Defects") && (PAGE_NAME == "glide_chart" || PAGE_NAME == "defect_report" || PAGE_NAME == "hours_report" || PAGE_NAME == "chart" || PAGE_NAME == "weeklyusage_report" || PAGE_NAME == "resource_utilization" || PAGE_NAME == "pending_task" || PAGE_NAME == "work_load" || PAGE_NAME == "timesheetReport" || PAGE_NAME == "profitable_report")) { ?>
    <div class="task-list-bar  analytics-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-8 pr_0">
                        <ul class="lft_tab_tasklist fl">
							<?php if(SES_TYPE < 3 || $this->Format->isAllowed('View Hour Spent Report',$roleAccess)){ ?>
                            <li class="all-list-glyph <?php if (CONTROLLER == "reports" && (PAGE_NAME == "hours_report")) { ?>active-list<?php } ?>">
                                <a onclick="return trackEventLeadTracker('Hours Spent','<?php echo PAGE_NAME ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT . "hours-report/" ?>">
                                    <i class="material-icons hs-icon">&#xE192;</i>
                                    <?php echo __('Hours Spent');?>
                                </a>
                            </li>
                            <?php } ?>
                            <?php /*if(SES_TYPE < 3 || $this->Format->isAllowed('View Task Report',$roleAccess)){ ?>
                            <li <?php if (CONTROLLER == "reports" && (PAGE_NAME == "chart")) { ?>class="active-list" <?php } ?>>
                                <a onclick="return trackEventLeadTracker('Task Reports','<?php echo PAGE_NAME ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT . "task-report/" ?>">
                                    <i class="material-icons">&#xE862;</i>
                                    <?php echo __('Task Reports');?>
                                </a>
                            </li>
                            <?php } */ ?>
                            <?php if (SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('View Weekly Usage',$roleAccess)) { ?>
                                <li class="<?php if (CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) { ?>active-list<?php } ?>">
                                    <a onclick="return trackEventLeadTracker('Weekly Usage','<?php echo PAGE_NAME ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT . "reports/weeklyusage_report//" ?>">
                                        <i class="material-icons">&#xE922;</i>
                                        <?php echo __('Weekly Usage');?>
                                    </a>
                                </li>
                                <?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
                                <li <?php if (CONTROLLER == "reports" && (PAGE_NAME == "resource_utilization")) { ?>class="active-list" <?php } ?>>
                                    <a onclick="return trackEventLeadTracker('Resource Utilization','<?php echo PAGE_NAME ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"  href="<?php echo HTTP_ROOT . "resource-utilization/" ?>">
                                        <i class="material-icons">&#xE335;</i>
                                        <?php echo __('Resource Utilization');?>
                                    </a>
                                </li>
                            <?php } ?>
                         <?php } ?>
                             <?php if (SES_TYPE == 1 || SES_TYPE == 2) { ?>
                                <?php if (SES_COMP == 1 || SES_COMP == 28528) { ?>
                                    <li <?php if (CONTROLLER == "reports" && (PAGE_NAME == "work_load")) { ?>class="active-list" <?php } ?>>
                                        <a href="<?php echo HTTP_ROOT . "work-load/" ?>">
                                            <i class="material-icons">&#xE886;</i>
                                            <?php echo __('Work Load');?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <div class="cb"></div>
                    </div>
                    <div class="col-lg-4 weeklytime_report analytic_form_fld <?php
                    if (PAGE_NAME == 'weeklyusage_report') {
                        echo "text-right";
                    }
                    ?>">
                             <?php if (PAGE_NAME == 'work_load') { ?>
                            <div class="pfl-icon-dv-wl pfl-icon-dv res_utli fr">
                                <span class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" rel="tooltip" title="<?php echo __('Filter');?>">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </a>
                                    <ul class="dropdown-menu resource-utilization-filter drop_menu_mc dropdown_menu_all_filters_ul">
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="util_fns.allfiltervalue('utilization', event);"><i class="material-icons">&#xE916;</i><?php echo __('Date');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm arch-due-dt" id="dropdown_menu_utilization">
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_today" data-id="today" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'today' || $_COOKIE['utilization_date_filter'] == 'all') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('today', 'check');"/> <?php echo __('Today');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_yesterday" data-id="yesterday" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'yesterday') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('yesterday', 'check');"/> <?php echo __('Yesterday');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_thisweek" data-id="thisweek" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('thisweek', 'check');"/> <?php echo __('This Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_thismonth" data-id="thismonth" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thismonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('thismonth', 'check');"/> <?php echo __('This Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_thisquarter" data-id="thisquarter" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('thisquarter', 'check');"/> <?php echo __('This Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_thisyear" data-id="thisyear" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('thisyear', 'check');"/> <?php echo __('This Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_lastweek" data-id="lastweek" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('lastweek', 'check');"/> <?php echo __('Last Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_lastmonth" data-id="lastmonth" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastmonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('lastmonth', 'check');"/> <?php echo __('Last Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_lastquarter" data-id="lastquarter" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('lastquarter', 'check');"/> <?php echo __('Last Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_lastyear" data-id="lastyear" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('lastyear', 'check');"/> <?php echo __('Last Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="utilization_last365days" data-id="last365days" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'last365days') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.utilization('last365days', 'check');"/> <?php echo __('Last 365 days');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" data-id = "custom" id="utilization_custom" <?php
                                                            if (strpos($_COOKIE['utilization_date_filter'], ':')) {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="util_fns.customdatetutilization();"/> <?php echo __('Custom Date');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="custome_timelog custom_date_li" style="display: none;">
                                                    <?php
                                                    if (isset($_COOKIE['utilization_date_filter'])) {
                                                        $dt = explode(':',$_COOKIE['utilization_date_filter']);
                                                    } else
                                                        $dt = '';
                                                    ?>
                                                    <div class="frto_sch">
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('From Date');?>" readonly  id="utilizationstrtdt" value="<?php echo @$dt[0]; ?>"/>
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('To Date');?>" readonly id="utilizationenddt" value="<?php echo @$dt[1]; ?>"/>
                                                        <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn aply_btn" type="button" onclick="util_fns.utilization('custom', 'Custom');" id="btn_timelog_search"><?php echo __('Search');?></button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="util_fns.allfiltervalue('utilization_project', event);"><i class="material-icons">&#xE8F9;</i><?php echo __('Project');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_project">
                                            </ul>
                                        </li>
                                        <?php if($this->Format->isAllowed('View All Resource',$roleAccess)){ ?> <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="util_fns.allfiltervalue('utilization_resource', event);"><i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('Resource');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_resource"></ul>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </span>
                            </div>
                            <div class="tag-btn utilization_filter_msg fr" data-column-id="filter_msg" style="display:table">
                                <div class="ver_midl">
                                    <div id="filtered_items" class="tag-block" style="display: none;"></div>
                                </div>
                                <div id="wl_filter_msg_close" class="filter_btn_section ver_midl">
                                    <span id="reset_btn" title="<?php echo __('Reset Filters');?>" style="display: none;">
                                        <i class="material-icons">&#xE8BA;</i>
                                    </span>
                                </div>
                            </div>
                            <div class="cb"></div>
                        <?php } elseif (PAGE_NAME == 'resource_utilization') { ?>
                            <div class="fr pfl-icon-dv res_utli">
                                <span class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" rel="tooltip" title="<?php echo __('Filter');?>">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </a>
                                    <ul class="dropdown-menu resource-utilization-filter drop_menu_mc dropdown_menu_all_filters_ul">
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="allfiltervalue('utilization', event);"><i class="material-icons">&#xE916;</i><?php echo __('Date');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm arch-due-dt" id="dropdown_menu_utilization">
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_today" data-id="today" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'today') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('today', 'check');"/> <?php echo __('Today');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_yesterday" data-id="yesterday" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'yesterday') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('yesterday', 'check');"/> <?php echo __('Yesterday');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_thisweek" data-id="thisweek" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('thisweek', 'check');"/> <?php echo __('This Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_thismonth" data-id="thismonth" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thismonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('thismonth', 'check');"/> <?php echo __('This Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_thisquarter" data-id="thisquarter" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('thisquarter', 'check');"/> <?php echo __('This Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_thisyear" data-id="thisyear" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'thisyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('thisyear', 'check');"/> <?php echo __('This Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_lastweek" data-id="lastweek" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('lastweek', 'check');"/> <?php echo __('Last Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_lastmonth" data-id="lastmonth" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastmonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('lastmonth', 'check');"/> <?php echo __('Last Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_lastquarter" data-id="lastquarter" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('lastquarter', 'check');"/> <?php echo __('Last Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_lastyear" data-id="lastyear" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'lastyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('lastyear', 'check');"/> <?php echo __('Last Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls cst_date_cls_resrc" type="checkbox" id="utilization_last365days" data-id="last365days" <?php
                                                            if ($_COOKIE['utilization_date_filter'] == 'last365days') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="utilization('last365days', 'check');"/> <?php echo __('Last 365 days');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" data-id = "custom" id="utilization_custom_uti" <?php
                                                            if (strpos($_COOKIE['utilization_date_filter'], ':')) {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="customdatetutilization();"/> <?php echo __('Custom Date');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="custome_timelog custom_date_li" style="<?php  if (strpos($_COOKIE['utilization_date_filter'], ':')) {?>display: block;<?php }else{ ?>display: none;<?php } ?>">
                                                    <?php
                                                    if (isset($_COOKIE['utilization_date_filter'])) {
                                                        $dt = explode(':', $_COOKIE['utilization_date_filter']);
                                                    } else
                                                        $dt = '';
                                                    ?>
                                                    <div class="frto_sch">
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('From Date');?>" readonly  id="utilizationstrtdt" value="<?php echo @$dt[0]; ?>"/>
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('To Date');?>" readonly id="utilizationenddt" value="<?php echo @$dt[1]; ?>"/>
                                                        <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn aply_btn" type="button" onclick="utilization('custom', 'Custom');" id="btn_timelog_search"><?php echo __('Search');?></button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('utilization_status', event);"><i class="material-icons">&#xE88B;</i><?php echo __('Status');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_status">
                                                <?php /*<?php $stsFil = explode('-', $_COOKIE['utilization_status_filter']); ?>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-status" id="utilization_new" data-id="1" onclick="utilization_status('new', 'check');" <?php
                                                            if (in_array('1', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> /> <?php echo __('New');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-status" <?php
                                                            if (in_array('2', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> id="utilization_wip" data-id="2" onclick="utilization_status('wip', 'check');" /> <?php echo __('In Progress');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-status" <?php
                                                            if (in_array('3', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> id="utilization_closed" data-id="3" onclick="utilization_status('closed', 'check');" /> <?php echo __('Closed');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-status" <?php
                                                            if (in_array('5', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> id="utilization_resolved" data-id="5" onclick="utilization_status('resolved', 'check');" /> <?php echo __('Resolved');?>
                                                        </label>
                                                    </div>
                                                </li>*/ ?>
                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="allfiltervalue('utilization_project', event);"><i class="material-icons">&#xE8F9;</i><?php echo __('Project');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_project">

                                            </ul>
                                        </li>
                                          <?php if($this->Format->isAllowed('View All Resource',$roleAccess)){ ?>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('utilization_resource', event);"><i class="material-icons">&#xE90F;</i><?php echo __('Resource');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_resource"></ul>
                                        </li>
                                    <?php } ?>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('utilization_label', event);"><i class="material-icons">label</i><?php echo __('Label');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_label"></ul>
                                        </li>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('utilization_billability', event);"><i class="material-icons">local_atm</i><?php echo __('Billability');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_utilization_billability">
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-billability" id="utilization_billable" data-id="billable" onclick="utilization_billability('billable', 'check');" /> <?php echo __('Billable');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="utilization-billability" id="utilization_unbillable" data-id="unbillable" onclick="utilization_billability('unbillable', 'check');" /> <?php echo __('Unbillable');?>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </span>
                            </div>
                            <div class="tag-btn utilization_filter_msg fr" data-column-id="filter_msg" style="display:table">
                                <div class="ver_midl">
                                    <div id="filtered_items" class="tag-block" style="display: none;"></div>
                                </div>
                                <div id="utilization_filter_msg_close" class="filter_btn_section ver_midl">
                                    <span id="reset_btn" title="<?php echo __('Reset Filters');?>" style="display: none;">
                                        <i class="material-icons">&#xE8BA;</i>
                                    </span>
                                </div>
                            </div>
                        <?php } else if (PAGE_NAME == 'pending_task') { ?>
                           <div class="fr pfl-icon-dv pen_task">
                                <span class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" rel="tooltip" title="<?php echo __('Filter');?>">
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </a>
                                    <ul class="dropdown-menu pending-task-filter drop_menu_mc dropdown_menu_all_filters_ul">
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="allfiltervalue('pendingtask', event);"><i class="material-icons">&#xE916;</i><?php echo __('Date');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm arch-due-dt" id="dropdown_menu_pendingtask">
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_today" data-id="today" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'today') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('today', 'check');"/> <?php echo __('Today');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_yesterday" data-id="yesterday" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'yesterday') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('yesterday', 'check');"/> <?php echo __('Yesterday');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_thisweek" data-id="thisweek" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'thisweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('thisweek', 'check');"/> <?php echo __('This Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_thismonth" data-id="thismonth" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'thismonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('thismonth', 'check');"/> <?php echo __('This Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_thisquarter" data-id="thisquarter" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'thisquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('thisquarter', 'check');"/> <?php echo __('This Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_thisyear" data-id="thisyear" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'thisyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('thisyear', 'check');"/> <?php echo __('This Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_lastweek" data-id="lastweek" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'lastweek') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('lastweek', 'check');"/> <?php echo __('Last Week');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_lastmonth" data-id="lastmonth" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'lastmonth') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('lastmonth', 'check');"/> <?php echo __('Last Month');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_lastquarter" data-id="lastquarter" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'lastquarter') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('lastquarter', 'check');"/> <?php echo __('Last Quarter');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_lastyear" data-id="lastyear" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'lastyear') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('lastyear', 'check');"/> <?php echo __('Last Year');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" id="pending_last365days" data-id="last365days" <?php
                                                            if ($_COOKIE['pending_date_filter'] == 'last365days') {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="pendingtask('last365days', 'check');"/> <?php echo __('Last 365 days');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="cst_date_cls" type="checkbox" data-id = "custom" id="pending_custom" <?php
                                                            if (strpos($_COOKIE['pending_date_filter'], ':')) {
                                                                echo "checked";
                                                            }
                                                            ?> onclick="customdatependingtask(this);"/> <?php echo __('Custom Date');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="custome_timelog custom_date_li" style="display: none;">
                                                    <?php
                                                    if (isset($_COOKIE['pending_date_filter'])) {
                                                        $dt = explode(':',$_COOKIE['pending_date_filter']);
                                                    } else
                                                        $dt = '';
                                                    ?>
                                                    <div class="frto_sch">
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('From Date');?>" readonly  id="pendingstrtdt" value="<?php echo @$dt[0]; ?>"/>
                                                        <input type="text" class="smal_txt form-control " placeholder="<?php echo __('To Date');?>" readonly id="pendingenddt" value="<?php echo @$dt[1]; ?>"/>
                                                        <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn aply_btn" type="button" onclick="pendingtask('custom', 'Custom');" id="btn_timelog_search"><?php echo __('Search');?></button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('pendingtask_status', event);"><i class="material-icons">&#xE88B;</i><?php echo __('Status');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_pending_status">
												<?php /*<?php $stsFil = explode('-', $_COOKIE['pending_status_filter']); ?>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="pending-status" id="pending_new" data-id="1" onclick="pending_status('new', 'check');" <?php
                                                            if (in_array('1', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> /> <?php echo __('New');?>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="li_check_radio">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="pending-status" <?php
                                                            if (in_array('2', $stsFil)) {
                                                                echo "checked";
                                                            }
                                                            ?> id="pending_wip" data-id="2" onclick="pending_status('wip', 'check');" /> <?php echo __('In Progress');?>
                                                        </label>
                                                    </div>
                                                </li>*/ ?>
												
                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc">
                                            <a class="dropdown-toggle" data-toggle="dropdown"  data-target="#" href="javascript:void(0)" onclick="allfiltervalue('pending_project', event);"><i class="material-icons">&#xE8F9;</i><?php echo __('Project');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_pending_project">

                                            </ul>
                                        </li>
                                        <li class="drop_menu_mc dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle"  data-target="#" data-toggle="dropdown" onclick="allfiltervalue('pending_resource', event);"><i class="material-icons">&#xE90F;</i><?php echo __('Resource');?></a>
                                            <ul class="dropdown_status dropdown-menu drop_smenu ltsm scroll-listing" id="dropdown_menu_pending_resource"></ul>
                                        </li>
                                    </ul>
                                </span>
                            </div>
                            <div class="tag-btn pending_filter_msg fr" data-column-id="filter_msg" style="display:table">
                                <div class="ver_midl">
                                    <div id="filtered_items" class="tag-block" style="display: none;"></div>
                                </div>
                                <div id="pending_filter_msg_close" class="filter_btn_section ver_midl">
                                    <span id="reset_btn" title="<?php echo __('Reset Filters');?>" style="display: none;">
                                        <i class="material-icons">&#xE8BA;</i>
                                    </span>
                                </div>
                            </div>
                        <?php } else if (PAGE_NAME == 'weeklyusage_report') { ?>
                            <span onclick="<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>PrintDiv()<?php } else { ?>alert('<?php echo __("This feature is only available to the paid users! Please Upgrade");?>');<?php } ?>" title="<?php echo __('Print this report');?>" class="anchor print_w_usage"><i class="material-icons">&#xE8AD;</i></span>
        <!-- <img src="<?php echo HTTP_ROOT . 'img/images/print.png'; ?>" style="cursor:pointer">-->
        <?php  } else if (PAGE_NAME == 'profitable_report') { ?>
                        <?php } else { 
            if(PAGE_NAME != "timesheetReport"){ ?>
						<div class="col-lg-3 col-sm-3 col-xs-3 padlft-non">
                                <div class="form-group">
                                    <?php echo $this->Form->text('start_date', array('value' => $frm, 'class' => 'smal_txt datepicker form-control', 'id' => 'start_date', 'placeholder' => __('Start Date',true), 'readonly' => 'true')); ?>
                                </div>
                            </div>
						<div class="col-lg-3 col-sm-3 col-xs-3 end-date">
                            <div class="from_to">to</div>
                                <div class="form-group">
                                    <?php echo $this->Form->text('end_date', array('value' => $to, 'class' => 'smal_txt datepicker form-control', 'id' => 'end_date', 'placeholder' => __('End Date',true), 'readonly' => "true")); ?>
                                </div>
                            </div>
                        <?php } ?>
						<div class="col-lg-3 col-sm-3 col-xs-3">
                                <div id="apply_btn">
                                    <?php if (PAGE_NAME == 'glide_chart') { ?>
                                        <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="submit_Profile" class="btn btn-sm btn_cmn_efect cmn_bg btn-info"  onclick="return validatechart('bug');"><?php echo __('Apply');?></a></span>
                                    <?php } elseif (PAGE_NAME == 'chart') { ?>
                                        <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="submit_Profile" class="btn btn-sm btn_cmn_efect cmn_bg btn-info"  onclick="return validatechart('task');"><?php echo __('Apply');?></a></span>
                                    <?php }elseif (PAGE_NAME == 'defect_report') { ?>
                                        <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="submit_Profile" class="btn btn-sm btn_cmn_efect cmn_bg btn-info"  onclick="return validatechart('defect_report');"><?php echo __('Apply');?></a></span>
                                    <?php } elseif (PAGE_NAME == 'hours_report') { ?>
                                        <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="submit_Profile" class="btn btn-sm btn_cmn_efect cmn_bg btn-info"  onclick="return validatechart('hours');"><?php echo __('Apply');?></a></span>
                                    <?php } ?>
                                </div>
                                <div id="apply_loader" style="display:none;" class="fl">
                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="<?php echo __('loading');?>..." title="<?php echo __('loading');?>..."/>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cb"></div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $("#start_date").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#start_date").datepicker('getFormattedDate');
                            $("#end_date").datepicker("setStartDate", dateText);
                        });
                        $("#end_date").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#end_date").datepicker('getFormattedDate');
                            $("#start_date").datepicker("setEndDate", dateText);
                        });
                        $("#utilizationstrtdt").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#utilizationstrtdt").datepicker('getFormattedDate');
                            $("#utilizationenddt").datepicker("setStartDate", dateText);
                        });
                        $("#utilizationenddt").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#utilizationenddt").datepicker('getFormattedDate');
                            $("#utilizationstrtdt").datepicker("setEndDate", dateText);
                        });
                         $("#pendingstrtdt").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#pendingstrtdt").datepicker('getFormattedDate');
                            $("#pendingenddt").datepicker("setStartDate", dateText);
                        });
                        $("#pendingenddt").datepicker({
                            format: 'M d, yyyy',
                            changeMonth: false,
                            changeYear: false,
                            startDate: 0,
                            hideIfNoPrevNext: true,
                            autoclose: true
                        }).on("changeDate", function () {
                            var dateText = $("#pendingenddt").datepicker('getFormattedDate');
                            $("#pendingstrtdt").datepicker("setEndDate", dateText);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
<?php } else if (CONTROLLER == 'templates' && (PAGE_NAME == 'tasks' || PAGE_NAME == 'projects')) { ?>
    <div class="task-list-bar templates-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="proj_stas_bar lft_tab_tasklist acct_set_tab">
                        <li <?php
                        if (CONTROLLER == 'templates' && PAGE_NAME == 'projects') {
                            echo 'class="active-list"';
                        }
                        ?>>
                            <a href="<?php echo HTTP_ROOT . 'templates/projects'; ?>" class="all-list" id="sett_my_profile">
                                <i class="material-icons">&#xE8F9;</i>
                                <?php echo __('Project');?>
                            </a>
                        </li>
                        <li <?php
                        if (CONTROLLER == 'templates' && PAGE_NAME == 'tasks') {
                            echo 'class="active-list"';
                        }
                        ?>>
                            <a href="<?php echo HTTP_ROOT . 'templates/tasks'; ?>" class="all-list" id="sett_cpw_prof">
                                <i class="material-icons">&#xE862;</i>
                                <?php echo __('Task');?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } else if (CONTROLLER == 'Ganttchart' && PAGE_NAME == 'manage') { ?>
    <div class="task-list-bar templates-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-6 ganttchart-bar">
                        <h2><?php echo __('Gantt chart');?></h2>
                    </div>
                    <div class="col-lg-6 gantt-right-bar">
                        <div class="col-lg-6 padrht-non custom-task-fld gantt-month-fld labl-rt add_new_opt mtop10">
                            <select class="ganttmnth select form-control floating-label" placeholder="<?php echo __('Select Month');?>" data-dynamic-opts=true onchange="gantt_filter_mnth(this)">

                            </select>
                            <input type="hidden" id="gantt_mnth" value="<?php echo $_SESSION['ganttchart_month']; ?>"/>
                        </div>
                        <div class="col-lg-6 padrht-non custom-task-fld gantt-year-fld labl-rt add_new_opt mtop10">
                            <select class="ganttyr select form-control floating-label" placeholder="<?php echo __('Select Year');?>" data-dynamic-opts=true onchange="gantt_filter_yr(this)">

                            </select>
                            <input type="hidden" id="gantt_yr" value="<?php echo $_SESSION['ganttchart_year']; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
/*
PAGE_NAME == 'groupupdatealerts' || PAGE_NAME == 'importexport' || PAGE_NAME == 'importtimelog' || PAGE_NAME == 'task_type' || PAGE_NAME == 'csv_dataimport' || PAGE_NAME == 'csv_tldataimport' || PAGE_NAME == 'confirm_tlimport' || PAGE_NAME == 'confirm_import' || PAGE_NAME == 'task_settings' || PAGE_NAME == 'chat_settings'
 *  */
} else if ( (CONTROLLER == 'projects' && in_array(PAGE_NAME, array('chat_settings'))) || (CONTROLLER == 'users' && PAGE_NAME == 'mycompany' ) || (CONTROLLER == 'LogTimes' && PAGE_NAME == 'resource_settings') || (CONTROLLER == 'projects' && PAGE_NAME == 'sprint_setting') || (CONTROLLER == 'projects' && PAGE_NAME == 'manageProjectTemplates') || (CONTROLLER == 'projects' && PAGE_NAME == 'project_status') || (CONTROLLER == 'projects' && PAGE_NAME == 'project_types') || (CONTROLLER == 'task_actions' && PAGE_NAME =='duedateChangeReason')) {
    ?>
    <?php echo $this->element('company_settings'); ?>
<?php } elseif ((CONTROLLER == 'projects' || CONTROLLER == 'costs' && in_array(PAGE_NAME, array('groupupdatealerts', 'importexport', 'importtimelog','importcomment', 'task_type', 'labels', 'custom_field','csv_dataimport', 'csv_tldataimport','csv_commentimport', 'confirm_tlimport', 'confirm_import', 'task_settings', 'settings')) ) || (CONTROLLER == 'invoices' && in_array(PAGE_NAME, array('settings', 'importCustomers', 'csvDataimport', 'confirmImport')))) { ?> 
<?php echo $this->element('project_settings'); ?>   
<?php } else if (CONTROLLER == 'users' && (PAGE_NAME == 'profile' || PAGE_NAME == 'changepassword' || PAGE_NAME == 'email_notifications' || PAGE_NAME == 'email_reports' || PAGE_NAME == 'default_view' ) || (CONTROLLER == "UserQuicklinks" && PAGE_NAME == "index") || (CONTROLLER == "UserSidebar" && PAGE_NAME == "index") ) { ?>
    <?php echo $this->element('personal_settings'); ?>
<?php } elseif (PAGE_NAME == "syncGoogleCalendar" || PAGE_NAME == 'slack_connect' || (CONTROLLER == "Github" && PAGE_NAME == "gitconnect") || (CONTROLLER == "github" && PAGE_NAME == "gitconnect") || (CONTROLLER == "users" && PAGE_NAME == "zapierConnect") || (CONTROLLER == "sso" && PAGE_NAME == "ssoSetting") || (CONTROLLER == "zoom" && PAGE_NAME == "zoomSetting")) { ?> 
<?php }else if(CONTROLLER == "Defects" && in_array(PAGE_NAME, array('defect_status', 'defect_severity','defect_category','defect_issue_type','defect_activity_type','defect_phase', 'defect_root_cause', 'defect_fix_version', 'defect_affect_version', 'defect_origin', 'defect_resolution'))){?>
<?php echo $this->element('defect_setting'); ?> 
<?php } else if(CONTROLLER == "Defects" && PAGE_NAME == "defect" ) { ?> 
    <div class="task-list-bar templates-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
    <div class="fr pfl-icon-dv">
        <span id="bug_filter" class="dropdown task_section case-filter-menu">
            <a class="dropdown-toggle dropdown_menu_all_filters_togl" href="javascript:void(0);" rel="tooltip" title="<?php echo __('Filter');?>" onclick="showHideBugFilter();">
                <i class="glyphicon glyphicon-filter"></i>
            </a>
            <div class="dropdown_menu_t dropdown_menu_all_filters_ul_bkp" id="dropdown_menu_all_filters_bug">
                <?php echo $this->element('defect_filter'); ?>
            </div>
                                            
        </span>
        <span id="defect_impExp" class="dropdown task_expPrnt case-filter-menu">
            <a class="dropdown-toggle dropdown_menu_exp_print_togl pdf_export" data-toggle="dropdown" href="javascript:void(0);" data-target="#" >
                <!--<i class="material-icons">&#xE8D5;</i>-->
                <span class="export_file_icon"></span>
                    <ul>
                        <li onclick="defect_export_csv();trackEventLeadTracker('Top Bar', 'Export To CSV', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Export as CSV');?></li>
                        
                    </ul>
            </a>
            
        </span>
    </div>
</div>
</div>
</div>
</div>
<?php //echo $this->element('defect_filter'); ?>
<?php } elseif ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports')) { ?>
<?php #&& (PAGE_NAME == 'dashboard' || PAGE_NAME == 'average_age_report') ?>
    <div class="task-list-bar dbrd-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php 
                    if((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports') && (PAGE_NAME =='dashboard' || PAGE_NAME =='PlannedVsActualTaskView' || PAGE_NAME =='utilization') ){
                        echo __('All Reports');
                    }
                    ?></h2>
                </div>
            </div>
        </div>
    </div>
<?php } else if (CONTROLLER == 'Pages' && PAGE_NAME == 'release_activity') { ?>
    <div class="task-list-bar dbrd-bar">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo __('Product Releases');?></h2>
                </div>
            </div>
        </div>
    </div>
<?php } else if (CONTROLLER == 'pages' && PAGE_NAME == 'release_activity') { ?>
    <div id="task_list_bar" class="task-list-bar files-bar archive-bar activities-bar kanban-bar calendar-bar tg_calendar-bar task_section media-bar" style="display:none;">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-6 col-sm-6 m-top-bar">
                        <div class="activity-bar">
                            <h2><?php echo __('Activities');?></h2>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-5 m-top-bar text-right">
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div id="task_list_bar" class="task-list-bar files-bar archive-bar activities-bar kanban-bar calendar-bar tg_calendar-bar task_section media-bar" style="display:none;">
        <div class="wrap_top_tlbar">
            <div class="row">
                <div class="col-lg-12">
					<div class="col-lg-7 col-sm-6 m-top-bar">
                        <ul class="proj_stas_bar archive_stas_bar">
                            <li id="task_li" class="all-list-glyph active-list">
                                <a onclick="task()" href="javascript:void(0);" class="all-list">
                                    <i class="material-icons">&#xE862;</i>
                                    <?php echo __('Tasks');?>(<span class="archive_active_task"></span>)
                                </a>
                            </li>
                            <li id="file_li">
                                <a href="javascript:void(0);" onclick="file()">
                                    <i class="material-icons">&#xE226;</i> <?php echo __('Files');?> (<span class="archive_active_file"></span>)
                                </a>
                            </li>
                        </ul>
                        <div class="activity-bar">
                            <ul class="proj_stas_bar lft_tab_tasklist">
                             <li class="activitylist_breadcrumb actvty_li">
                                 <a id="actvt_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#/activities'; ?>" onclick="trackEventLeadTracker('Breadcrumb Navigation','Activities','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('activities');">
                                    <i class="material-icons">&#xE922;</i><?php echo __('Activities');?>                              
                                 </a>
                               
                            </li>
                            </ul>
                        </div>
                        <div class="calendar-bar-text">
                            <h2><?php echo __('Calendar');?></h2>
                        </div>
                        <div class="files-bar files-nav-text">
                            <h2><?php echo __('Files');?></h2>
                        </div>
                        <div id="topactions">
                        <ul class="proj_stas_bar lft_tab_tasklist">
                             <li class="tasklist_breadcrumb">
                                <a href="<?php echo HTTP_ROOT; ?>dashboard#/tasks" onclick="trackEventLeadTracker('Breadcrumb Navigation','Task List','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('tasks');">
                                    <i class="material-icons">&#xE8EF;</i> <?php echo __('Task List');?>
                                </a>
                            </li>
							<?php /*<li class="subtask_breadcrumb">
                                <a href="<?php echo HTTP_ROOT; ?>dashboard#subtask" onclick="trackEventLeadTracker('Breadcrumb Navigation','Sub Task','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                    <i class="material-icons">&#xE23E;</i> <?php echo __('Sub Task');?>
                                </a>
                            </li> */ ?>
							<?php //if($_SESSION['project_methodology'] != 'scrum'){ ?>
                             <?php /*if($this->Format->isAllowed('View Milestones',$roleAccess)){ ?> 
                             <li class="taskgroup_breadcrumb hide-in-scrum" <?php if($_SESSION['project_methodology'] == 'scrum'){ echo "style='display:none;'";}?>>
                                <a href="javascript:void(0);" onclick="groupby('milestone', event,1);trackEventLeadTracker('Top Bar Navigation','Task Group','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                    <i class="material-icons">&#xE065;</i> <?php echo __('Task Group');?>
                                </a>
                            </li>
                        <?php } */ ?>
                             <?php if($this->Format->isAllowed('View Milestones',$roleAccess)){ ?> 
                             <li class="taskgroup_breadcrumb hide-in-scrum" <?php if($_SESSION['project_methodology'] == 'scrum'){ echo "style='display:none;'";}?>>
                                <a href="javascript:void(0);" onclick=" ajaxCaseView('taskgroups');trackEventLeadTracker('Top Bar Navigation','Sub-task view','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                    <i class="material-icons">&#xE065;</i> <?php echo __('Subtask View');?>
                                </a>
                            </li>
                        <?php } ?>
                            <?php if($this->Format->isAllowed('View Kanban',$roleAccess)){ ?> 
                                <?php
                                $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
                                $ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
                                ?>
                             <li class="kanban_breadcrumb hide-in-scrum"  id="tour_kanban_view" <?php if($_SESSION['project_methodology'] == 'scrum'){ echo "style='display:none;'";}?> >
                                <a href="<?php echo HTTP_ROOT; ?>dashboard#/<?php echo $kanbanurl ?>" onclick="trackEventLeadTracker('Breadcrumb Navigation','<?php echo $ldTrkUrl; ?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('<?php echo $kanbanurl ?>');">
                                    <i class="material-icons">&#xE8F0;</i> <?php echo $this->Format->displayKanbanOrBoard();//__('Kanban');?>
                                </a>
                            </li>
							<?php } ?>
							<?php //} ?>
                             <?php if($this->Format->isAllowed('View Calendar',$roleAccess)){ ?> 
                             <li class="calendar_breadcrumb" id="tour_calendar_view">
                                <a  href="<?php echo HTTP_ROOT; ?>dashboard#/calendar" onclick="trackEventLeadTracker('Breadcrumb Navigation','Calendar','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return calendarView('calendar');">
                                    <i  class="material-icons">&#xE916;</i> <?php echo __('Calendar');?>
                                </a>
                            </li>
                        <?php } ?>
                            <?php /*
                        <li class="subtask_breadcrumb">
                            <a href="javascript:void(0);" onclick="trackEventLeadTracker('Breadcrumb Navigation','Sub Task','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>'); openSubTaskView();">
                                <i class="material-icons">&#xE23E;</i> <?php echo __('Sub Task');?>
                            </a>
                        </li>
                             */ ?>
                        <li class="nohover">
                             <a  href="<?php echo HTTP_ROOT; ?>users/default_view" rel="tooltip" title="<?php echo __('Set Default View');?>" >
                                    <i class="material-icons" style="font-size:22px;">&#xE5D3;</i>
                             </a>
                        </li>
                        </ul>
                        </div>
                        <ul class="proj_stas_bar kanban_stas_bar">
                            <li id="kanban_sts_bar">
                                <a href="javascript:void(0)" onclick="kanban_sattus();">
                                    <i class="material-icons">&#xE862;</i> <?php echo __('Task Status');?>
                                </a>
                            </li>
                            <li id="mlstab_act_kanban_sta" class="all-list-glyph active-list">
                                <a href="dashboard#/milestonelist" class="all-list">
                                    <i class="material-icons">&#xE065;</i>
                                    <?php echo __('Task Group');?>(<span class="kanban_active_task"></span>)
                                </a>
                            </li>
                            <div style="display:none;">
                                <li id="filterSearch_id_kanban" class="filter-dropdown-kanban">
                                    <div class="btn-group margin-left-2">
                                        <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl" type="button" onclick="viewFilters('kanban');">
                                            <span class="ellipsis-view max150"><a href="javascript:void(0);" class="top_project_name1" rel=""><?php echo __('Loading');?></a></span>
                                            <i class="nav-dot material-icons">&#xE5D3;</i>
                                        </button>
                                        <div id="filpopup_kanban" class="dropdown-menu lft popup" style="display: none;">
                                            <div class="scroll-project" id="ajaxViewFiltersKanban">
                                                <?php
                                                if (!empty($tablists)) {
                                                    foreach ($tablists AS $tabkey => $tabvalue) {
                                                        if (!($tabkey & ACT_TAB_ID)) {
                                                            $tab_spn_id = '';
                                                            if ($tabvalue["fkeyword"] == "cases") {
                                                                $tab_spn_id = "tskTabAllCnt";
                                                            } elseif ($tabvalue["fkeyword"] == "assigntome") {
                                                                $tab_spn_id = "tskTabMyCnt";
                                                            } elseif ($tabvalue["fkeyword"] == "delegateto") {
                                                                $tab_spn_id = "tskTabDegCnt";
                                                            } elseif ($tabvalue["fkeyword"] == "highpriority") {
                                                                $tab_spn_id = "tskTabHPriCnt";
                                                            } elseif ($tabvalue["fkeyword"] == "overdue") {
                                                                $tab_spn_id = "tskTabOverdueCnt";
                                                            } elseif ($tabvalue["fkeyword"] == "openedtasks") {
                                                                $tab_spn_id = "tskTabOpenedcnt";
                                                            } elseif ($tabvalue["fkeyword"] == "closedtasks") {
                                                                $tab_spn_id = "tskTabClosedCnt";
                                                            }
                                                            ?>
                                                            <a href="javascript:void(0);" onclick="setSavedFilter(this, '<?php echo $tabvalue["fkeyword"]; ?>', 'dashboard', 'cases', '');" id="kanban_otheropt<?php echo $tabkey; ?>" data-val="0" data-tabkey="<?php echo $tabvalue["fkeyword"]; ?>" rel="" class="gray-background"><?php echo $tabvalue["ftext"]; ?> <span id="kanban_<?php echo $tab_spn_id; ?>" class="spncls"></span></a>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </div>
                            <script type="text/template" id="filterSearch_id_kanban_tmpl">
                                <?php echo $this->element('search_filter'); ?>
                            </script>

                        </ul>
                        <div class="overview-bar pr">
                        <!--<div class="overview-bnr"></div>
                            <h2 id="add_user_pop_pname_overview" class="ellipsis-view mx-width-95 fl">Overview</h2>
                            <span id ="dsbleInactOver" onclick="inlineUserEdit();" class="inline-edit-usr fl anchor" data-prj-id="" data-prj-name="" title="Edit Project" rel="tooltip"><i class="material-icons">&#xE254;</i></span>
                            <span class="hide_back_overview" style="display:none;position: absolute;"><a href="<?php echo HTTP_ROOT . 'projects/manage/inactive'; ?>" class="back_to_prj back-btn task_detail_back_t" title="Back to projects"><span class="os_sprite back-detail"></span></a></span>
                            <div class="cb"></div>
                            <div class="fl overview-sts"></div>
                        <div class="cb"></div>-->
						<div class="overview-bnr" style="display:none;"></div>
						<div class="d_tbl project_overview_bar row" id="tour_overview_statistics">
							<div class="d_tbl_cel col-sm-3 pad_zero">
								<div id="pprog_holder">
								<div id="proj_loading_bar" style="height:150px; width:150px;"></div>
									<span id="proj_prog_cnt" title="<?php echo __('Total closed tasks compared to total tasks in a given project');?>" style="cursor:pointer;">0</span>
								<div class="dyn_overall_abstxt"><?php echo __('Overall Progress');?></div>
									<?php /*<a class="closetask_overview_ttlp" href='javascript:void(0);'><i class="material-icons">&#xE88E;</i>
									<span class="tool_tip_cont"><?php echo __('Total closed tasks compared to total tasks in a given project');?>.</span>
									</a> */ ?>
								</div>	
							</div>
							<div class="d_tbl_cel p_name col-sm-9">
                                <div class="proj_name_over_task">
								<div class="proj_name_overtask">
								<h2 id="ov_prj_name" title="<?php echo $proj['Project']['name']; ?>"><?php echo $proj['Project']['name']; ?>
								</h2>
                                <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
								<span id ="dsbleInactOver" onclick="inlineUserEdit();" class="inline-edit-usr fl anchor" data-prj-id="" data-prj-name="" title="<?php echo __('Edit Project');?>" rel="tooltip"><i class="material-icons">&#xE254;</i></span>
									<?php } ?>
								</div>
								<div class="edit_status_prior">									
									<span id="project_stst_span" class="" title="<?php echo __('Project Status');?>" rel="tooltip"></span>
									<span class="prio_low prio_lmh prio_gen_prj prio-drop-icon proj_ov_priority" rel="tooltip" title="<?php echo __('Low Priority');?>"></span>
								</div>
                                </div>
							</div>
                            <div class="cb"></div>
                        </div>
                    </div>
                        <div class="tlog_top_cnt timlog_top_bar">
                            <!--h2>Time Log</h2-->
                            <ul id="select_view_timelog" class="proj_stas_bar">
                                <li title="<?php echo __('List View');?>"><a id="lview_btn_timelog" onclick="trackEventWithIntercom('time-log', {'view': 'list'});" href="<?php echo HTTP_ROOT . 'dashboard#/timelog'; ?>"><i class="material-icons">&#xE8EF;</i>&nbsp;<?php echo __('List View');?></a></li>
                            </ul>
                            <div class="cb"></div>
                        </div>

                        <div class="tlog_top_cnt timesheet_top_bar">
                            <!--                        <h2>Timesheet</h2>-->
                            <ul id="select_view_timesheet" class="proj_stas_bar ">
                            <li title="<?php echo __('List View');?>"><a id="lview_btn_timelog" onclick="return trackEventLeadTracker('Top Bar','List Timelog','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT.'dashboard#/timelog';?>"><i class="material-icons">&#xE8EF;</i>&nbsp;<?php echo __('List View');?></a></li>
                                
                            </ul>
                            <div class="cb"></div>
                        </div>
                        <div class="filter_top_cnt filter_top_bar">
                            <h2><?php echo __('Manage Filters');?></h2>
                            <div class="cb"></div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-sm-1 m-top-bar text-right minheight" data-step="4" data-intro="Clicking this will let you 'Save or Update' a new Filter.">
                        <?php /* <button onclick="saveFilter();" id="saveFilter" class="btn btn_cmn_efect cmn_bg btn-info"><i class="material-icons">&#xE161;</i> Save</button> */ ?>
                    </div>
                    <div class="col-lg-5 col-sm-5 m-top-bar text-right">
					<div class="os_projct_overview_date" style="display: none;">
						<div class="d_tbl_cel date col-sm-5">
							<span><?php echo __('Start Date');?></span>
							<span id="ov_prj_stdt"><?php echo isset($proj['Project']['start_date'])?$proj['Project']['start_date']:'N/A'; ?></span>
							<div class="v_line_separator"></div>
						</div>
						<div class="d_tbl_cel date col-sm-5">
							<span><?php echo __('Due Date');?></span>
							<span id="ov_prj_eddt"><?php echo isset($proj['Project']['end_date'])?$proj['Project']['end_date']:'N/A'; ?></span>
						</div>
					</div>

                    <div class="tag-btn fl timelog_filter_msg" style="display:none;padding-top:20px;">
                        </div>
                        <div class="fl milst_addition" style="display:none">
                            <span class="anchor print_w_usage actv-mls" title="<?php echo __('Active Task Groups');?>" rel="tooltip" id="actv_btn_tsgrp">
                                <a href="javascript:void(0);" onclick="showMilestoneList('', 1)"><i class="material-icons">&#xE430;</i></a>
                            </span>
                            <span class="anchor print_w_usage" title="<?php echo __('Completed Task Groups');?>" rel="tooltip" id="cmpl_btn_tsgrp">
                                <a id="completed_tab_bk" href="javascript:void(0);" onclick="showMilestoneList('', 0)"><i class="material-icons">&#xE876;</i></a>
                            </span>
                        </div>
                        <div class="tag-btn fl kanban_filter_det" style="display:none">
                            <div id="" class="ver_midl">
                                <div class="tag-block" id="kanban_filtered_items"></div>
                            </div>
                            <div class="filter_btn_section ver_midl" id="kanban_savereset_filter">
                                <span onClick="resetMilestoneSearch();" id="kanban_reset_btn" title="<?php echo __('Reset');?>"><i class="material-icons">&#xE8BA;</i></span>
                            </div>
                        </div>
                        <!--- display search name in kanban task !-->
                        <div class="tag-btn fl kanban_tsk_filter_sec" style="display:none">
                            <div id="" class="ver_midl">
                                <div class="tag-block" id="kanban_tsk_filter_items"></div>
                            </div>
                            <div class="filter_btn_section ver_midl" id="kanban_srch_filter">

                            </div>
                        </div>
                        <!--- end of display search name in kanban task !-->
                        <div class="tag-btn fl archive_filter_det">
                            <div class="ver_midl">
                                <div id="archive_filtered_items" class="tag-block"></div>
                            </div>
                            <div class="filter_btn_section ver_midl" id="archive_savereset_filter">
                                <span onClick="resetAllFilters_archive('all');" id="archive_reset_btn" title="<?php echo __('Reset Filters');?>"><i class="material-icons">&#xE8BA;</i></span>
                            </div>
                        </div>
                        <div class="tag-btn fl filter_det">
                            <div class="ver_midl">
                                <div class="tag-block" id="filtered_items"></div>
                            </div>
                            <div class="filter_btn_section ver_midl" id="savereset_filter">
                                <span onClick="resetAllFilters('all');" id="reset_btn" title="<?php echo __('Reset Filters');?>" rel="tooltip"><i class="material-icons">&#xE8BA;</i></span>
                            </div>
                            <div style="display: table-cell;width: 30px;" class="filter_btn_section ver_midl">
                                <button class="btn btn_cmn_efect cmn_bg btn-info" id="saveFilter" onclick="saveFilter();" style="display: inline-block;" title="<?php echo __('Update Filter');?>" rel="tooltip"><i class="material-icons">?</i></button>
                            </div>
                        </div>
                        <div class="new_calendar_icon_on_top">
                            <span id="calendar_view_types" style="display:block;">
							<?php /*?><ul class="">
                                    <li>
                                        <a class="" href="<?php echo HTTP_ROOT; ?>dashboard#tasks" onclick="trackEventLeadTracker('Top Right Change View', 'List View', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');
                                                checkHashLoad('tasks');">
                                            <span title="List" rel="tooltip"><i class="material-icons">&#xE896;</i></span>
                                        </a>
                                    </li>
                                    <li><a class="" href="javascript:void(0);" onclick="trackEventLeadTracker('Top Right Change View', 'Task Group View', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');
                                            groupby('milestone', event, 1);">
                                            <span title="Task Group" rel="tooltip"><i class="material-icons">&#xE065;</i></span>
                                        </a>
                                    </li>
                                    <?php
                                    $kanbanurl = "";
                                    $kanbanurl = DEFAULT_KANBANVIEW == "kanban" ? "kanban" : "milestonelist";
                                    ?>
                                    <li>
                                        <a class="" href="<?php echo HTTP_ROOT; ?>dashboard#<?php echo $kanbanurl; ?>" onclick="trackEventLeadTracker('Top Right Change View', 'Kanban View', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');
                                                return checkHashLoad('<?php echo $kanbanurl; ?>');">
                                            <span id="kbview_btn" class="" title="Kanban" rel="tooltip">
                                                <i class="material-icons">&#xE8F0;</i>
                                            </span>
                                        </a>
                                    </li>
							</ul>	<?php */ ?>
                            </span>

                        </div>
                        <div class="fr pfl-icon-dv">
                            <span id="task_filter" class="dropdown task_section case-filter-menu">
                                <a class="dropdown-toggle dropdown_menu_all_filters_togl" href="javascript:void(0);" rel="tooltip" title="<?php echo __('Filter');?>" onclick="trackEventLeadTracker('Top Bar', 'Filter', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');showHidetaskFilter();"> <!--  data-toggle="modal" data-target="#filterModal" -->
                                    <i class="glyphicon glyphicon-filter"></i>
                                </a>
																<div class="dropdown_menu_t dropdown_menu_all_filters_ul_bkp" id="dropdown_menu_all_filters_t">
																	<?php echo $this->element('task_filters'); ?>
																</div>
																<?php /*
                                <ul class="dropdown-menu dropdown_menu_all_filters_ul" id="dropdown_menu_all_filters">
                                    <li class="log drop_menu_mc" style="display:none;">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('createdDate', event);"><i class="material-icons">&#xE916;</i><?php echo __("Date");?></a>
                                        <!--<div class="dropdown_status" id="dropdown_menu_createddate_div">-->
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_createddate">
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_alldates" data-id="alldates" onclick="general.filterDate('timelog', 'alldates', 'All', 'check');"/> <?php echo __('All Dates');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_today" data-id="today" onclick="general.filterDate('timelog', 'today', 'Today', 'check');"/> <?php echo __('Today');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_yesterday" data-id="yesterday" onclick="general.filterDate('timelog', 'yesterday', 'Yesterday', 'check');"/> <?php echo __('Yesterday');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisweek" data-id="thisweek" onclick="general.filterDate('timelog', 'thisweek', 'This Week', 'check');"/> <?php echo __('This Week');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thismonth" data-id="thismonth" onclick="general.filterDate('timelog', 'thismonth', 'This Month', 'check');"/> <?php echo __('This Month');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisquarter" data-id="thisquarter" onclick="general.filterDate('timelog', 'thisquarter', 'This Quarter', 'check');"/> <?php echo __('This Quarter');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_thisyear" data-id="thisyear" onclick="general.filterDate('timelog', 'thisyear', 'This Year', 'check');"/> <?php echo __('This Year');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastweek" data-id="lastweek" onclick="general.filterDate('timelog', 'lastweek', 'Last Week', 'check');"/> <?php echo __('Last Week');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastmonth" data-id="lastmonth" onclick="general.filterDate('timelog', 'lastmonth', 'Last Month', 'check');"/> <?php echo __('Last Month');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastquarter" data-id="lastquarter" onclick="general.filterDate('timelog', 'lastquarter', 'Last Quarter', 'check');"/> <?php echo __('Last Quarter');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_lastyear" data-id="lastyear" onclick="general.filterDate('timelog', 'lastyear', 'Last Year', 'check');"/> <?php echo __('Last Year');?>
                                                        </label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="li_check_radio">
                                                <a href="javascript:void(0);">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" <?php echo ($_COOKIE['Timelog_filter'] == 'alldates') ? "checked" : ""; ?> id="timelog_last365days" data-id="last365days" onclick="general.filterDate('timelog', 'last365days', 'Last 365 days', 'check');"/> <?php echo __('Last 365 days');?>
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
                                        <!--</div>-->
                                    </li>
                                    <li class="log drop_menu_mc" style="display:none;">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('resource', event);"><i class="material-icons">&#xE90F;</i><?php echo __('Resource');?></a>
                                        <input type="hidden" id="tlog_date" value=""/>
                                        <input type="hidden" id="tlog_resource" value=""/>
                                        <input type="hidden" id="tlog_externalfilter" value=""/>
                                        <ul class="sub-panel-menu dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_resource"></ul>
                                    </li>
                                    <li class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('date', event);"><i class="material-icons">&#xE8AE;</i><?php echo __('Time');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_date"></ul>
                                    </li>
                                    <li id="tskgrpli" class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('tskgrp', event);"><i class="material-icons">&#xE065;</i><?php echo __('Task Group');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_tskgrp"></ul>
                                    </li>
                                    <li class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('duedate', event);"><i class="material-icons">&#xE8DF;</i><?php echo __('Due Date');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_duedate"></ul>
                                    </li>
                                    <li class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('status', event);"><i class="material-icons">&#xE88B;</i><?php echo __('Status');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm scrollable" id="dropdown_menu_status"></ul>
                                    </li>
                                    <li class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('types', event);"><i class="material-icons">&#xE54E;</i><?php echo __('Types');?></a>
                                        <ul class="dropdown_status dropdown-menu sub-panel-menu_archive drop_smenu ltsm" id="dropdown_menu_types"></ul>
                                    </li>
                                    <li class="nolog drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('priority', event);"><i class="material-icons">&#xE000;</i><?php echo __('Priority');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm" id="dropdown_menu_priority"></ul>
                                    </li>
                                    <?php
                                    if ((count($getallproj) == 0)) {

                                    } else {
                                        ?>
                                        <li class="nolog drop_menu_mc">
                                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('comments', event);"><i class="material-icons">&#xE253;</i><?php echo __('Commented by');?> </a>
                                            <ul class="dropdown_status dropdown-menu sub-panel-menu drop_smenu ltsm" id="dropdown_menu_comments" style="width:200px; max-height:350px;overflow-x: hidden; overflow-y: auto;"></ul>
                                        </li>
                                        <li class="nolog drop_menu_mc">
                                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('taskgroup', event);"><i class="material-icons">&#xE253;</i><?php echo __('Task Group');?> </a>
                                            <ul class="dropdown_status dropdown-menu sub-panel-menu drop_smenu ltsm" id="dropdown_menu_taskgroup" style="width:200px; max-height:350px;overflow-x: hidden; overflow-y: auto;"></ul>
                                        </li>
                                        <li class="nolog drop_menu_mc">
                                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('users', event);"><i class="material-icons">&#xE150;</i><?php echo __('Created by');?> </a>
                                            <ul class="dropdown_status dropdown-menu sub-panel-menu drop_smenu ltsm" id="dropdown_menu_users"></ul>
                                        </li>
                                        <li class="nolog drop_menu_mc">
                                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('assignto', event);"><i class="material-icons">&#xE85E;</i><?php echo __('Assign To');?></a>
                                            <ul class="dropdown_status dropdown-menu sub-panel-menu drop_smenu ltsm" id="dropdown_menu_assignto"></ul>
                                        </li>
										<li class="nolog drop_menu_mc">
                                            <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('label', event);"><i class="material-icons">label</i><?php echo __('Label');?><sup class="sup-new" style="color: #f93737;font-size: 10px;">&nbsp;<?php echo __("New");?></sup></a>
                                            <ul class="dropdown_status dropdown-menu sub-panel-menu drop_smenu ltsm" id="dropdown_menu_label"></ul>
                                        </li>
                                    <?php } ?>
                                </ul>
																*/ ?>
                            </span>

							<?php
								if(CONTROLLER != 'archives' && PAGE_NAME != 'listall'){
							?>
                             <span id="overview_exp" class="dropdown timesheet_expPrnt">
                                <a id="overview_exp_lnk" href="javascript:void(0)" title="Export as PDF" onclick="overviewPDF();" rel="tooltip"><i class="material-icons">picture_as_pdf</i></a>
								<img alt="<?php echo __('loading');?>..." title="<?php echo __('loading');?>..." id="ov_pdf_loader" src="<?php echo HTTP_IMAGES;?>images/del.gif" style="display:none;padding-right: 10px;"/>
                            </span>
							<?php } ?>

                            <span id="timesheet_exp" class="dropdown timesheet_expPrnt">

                            </span>
                            <?php if($this->Format->isAllowed('Download Task',$roleAccess)){ ?>
                            <span id="task_impExp" class="dropdown task_expPrnt case-filter-menu">
                                <a class="dropdown-toggle dropdown_menu_exp_print_togl pdf_export" data-toggle="dropdown" href="javascript:void(0);" data-target="#" >
                                    <!--<i class="material-icons">&#xE8D5;</i>-->
                                    <span class="export_file_icon"></span>
                                        <ul>
                                            <li onclick="openTaskListExportPopup();trackEventLeadTracker('Top Bar', 'Export To CSV', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Export as CSV');?></li>
                                       </ul>
                                </a>
                                <?php /* <ul class="dropdown-menu dropdown_menu_exp_print_ul" id="dropdown_menu_exp_print">
                                  <li class="drop_menu_mc">
                                  <a href="javascript:void(0);" onclick="tasklistexport();">
                                  <i class="glyphicon glyphicon-export"></i>Export(.csv)
                                  </a>
                                  </li>
                                  <li class="drop_menu_mc" onclick="tasklistprint();">
                                  <a href="javascript:void(0);">
                                  <i class="material-icons">&#xE8AD;</i>Print
                                  </a>
                                  </li>
                                  </ul> */ ?>
                            </span>
                        <?php } ?>
                            <!-- archive filter ssection-->
                            <span id="archive_filter" class="dropdown task_section archive-filter-menu">
                                <a class="dropdown-toggle dropdown_menu_all_filters_togl" data-toggle="dropdown" href="javascript:void(0);" data-target="#" onclick="openfilter_popup('0', 'dropdown_menu_archive_filters');" rel="tooltip" title="<?php echo __('Filter');?>">
                                    <i class="glyphicon glyphicon-filter"></i>
                                </a>

                                <ul id="dropdown_menu_archive_filters" class="dropdown-menu">
                                    <li class="drop_menu_mc" id="casestatus_li" style="display:none;">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('casestatus', event, 'archive')"><i class="material-icons">&#xE90A;</i> <?php echo __('Status');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm scrollable" id="dropdown_menu_casestatus">
                                            <?php /*<li class="li_check_radio">
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="archive_status_cls" type="checkbox" data-id="1" id="archive_new" onclick="checkboxarchivestatus('new', 'check');"/> <?php echo __('New');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="archive_status_cls" type="checkbox" data-id="2" id="archive_inprogress" onclick="checkboxarchivestatus('inprogress', 'check');"/> <?php echo __('In Progress');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="archive_status_cls" type="checkbox" data-id="5" id="archive_resolved" onclick="checkboxarchivestatus('resolved', 'check');"/> <?php echo __('Resolved');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="checkbox">
                                                    <label>
                                                        <input class="archive_status_cls" type="checkbox" data-id="3" id="archive_closed" onclick="checkboxarchivestatus('closed', 'check');"/> <?php echo __('Closed');?>
                                                    </label>
                                                </div>
                                            </li> */ ?>
                                        </ul>
                                    </li>

                                    <li class="drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('casedate', event, 'archive')"><i class="material-icons">&#xE149;</i> <?php echo __('Archived Date');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm arch-dat" id="dropdown_menu_casedate" style="">
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "today" id="archive_today" onclick="checkboxarchivedate('today', 'check');"/> <?php echo __('Today');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "yesterday" id="archive_yesterday" onclick="checkboxarchivedate('yesterday', 'check');"/> <?php echo __('Yesterday');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "thisweek" id="archive_thisweek" onclick="checkboxarchivedate('thisweek', 'check');"/> <?php echo __('This Week');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "thismonth" id="archive_thismonth" onclick="checkboxarchivedate('thismonth', 'check');"/> <?php echo __('This Month');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "thisquarter" id="archive_thisquarter" onclick="checkboxarchivedate('thisquarter', 'check');"/> <?php echo __('This Quarter');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "thisyear" id="archive_thisyear" onclick="checkboxarchivedate('thisyear', 'check');"/> <?php echo __('This Year');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "lastweek" id="archive_lastweek" onclick="checkboxarchivedate('lastweek', 'check');"/> <?php echo __('Last Week');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "lastmonth" id="archive_lastmonth" onclick="checkboxarchivedate('lastmonth', 'check');"/> <?php echo __('Last Month');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "lastquarter" id="archive_lastquarter" onclick="checkboxarchivedate('lastquarter', 'check');"/> <?php echo __('Last Quarter');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "lastyear" id="archive_lastyear" onclick="checkboxarchivedate('lastyear', 'check');"/> <?php echo __('Last Year');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_date_cls" type="radio" data-id = "last365days" id="archive_last365days" onclick="checkboxarchivedate('last365days', 'check');"/> <?php echo __('Last 365 days');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio dcus_dt">
                                                <a class="anchor" class="cstm-dt-option" onclick="customarchivedate();" style="padding:3px 25px">
                                                    <span style="position:relative;top:2px;cursor:pointer;"><?php echo __('Custom Date');?></span>
                                                </a>
                                            </li>
                                            <li class="custome_archive dft_dt" style="display:none;">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="arcduestrtdt"><?php echo __('From Date');?></label>
                                                    <input type="text" class="smal_txt form-control" placeholder="" readonly  id="arcduestrtdt" value="<?php echo $frm; ?>"/>
                                                </div>
                                            </li>
                                            <li class="custome_archive dft_dt" style="display:none;">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="arcdueenddt"><?php echo __('To Date');?></label>
                                                    <input type="text" class="smal_txt form-control" placeholder="" readonly id="arcdueenddt" value="<?php echo $to; ?>"/>
                                                </div>
                                            </li>
                                            <li class="custome_archive" style="display:none;text-align:center;padding:5px">
                                                <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" type="button" onclick="arcivecustomdate();" id="btn_archive_search"><?php echo __('Search');?></button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="drop_menu_mc" style="display:none;" id="caseduedate_li">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('archiveduedate', event, 'archive')"><i class="material-icons">&#xE8DF;</i> <?php echo __('Due Date');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm arch-due-dt" id="dropdown_menu_archiveduedate">
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "today" id="archivedue_today" onclick="checkboxarchivedduedate('today', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Today');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "yesterday" id="archivedue_yesterday" onclick="checkboxarchivedduedate('yesterday', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Yesterday');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "thisweek" id="archivedue_thisweek" onclick="checkboxarchivedduedate('thisweek', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('This Week');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "thismonth" id="archivedue_thismonth" onclick="checkboxarchivedduedate('thismonth', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('This Month');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "thisquarter" id="archivedue_thisquarter" onclick="checkboxarchivedduedate('thisquarter', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('This Quarter');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "thisyear" id="archivedue_thisyear" onclick="checkboxarchivedduedate('thisyear', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('This Year');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "lastweek" id="archivedue_lastweek" onclick="checkboxarchivedduedate('lastweek', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Last Week');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "lastmonth" id="archivedue_lastmonth" onclick="checkboxarchivedduedate('lastmonth', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Last Month');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "lastquarter" id="archivedue_lastquarter" onclick="checkboxarchivedduedate('lastquarter', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Last Quarter');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "lastyear" id="archivedue_lastyear" onclick="checkboxarchivedduedate('lastyear', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Last Year');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio">
                                                <div class="radio radio-primary">
                                                    <label>
                                                        <input class="cst_duedate_cls" type="radio" data-id = "last365days" id="archivedue_last365days" onclick="checkboxarchivedduedate('last365days', 'check', '<?php echo $ftype; ?>');"/> <?php echo __('Last 365 days');?>
                                                    </label>
                                                </div>
                                            </li>
                                            <li class="li_check_radio dcus_dt">
                                                <a class="anchor" class="cstm-dt-option" onclick="customarchiveduedate();" style="padding:3px 25px">
                                                    <span style="position:relative;top:2px;cursor:pointer;"><?php echo __('Custom Date');?></span>
                                                </a>
                                            </li>
                                            <li class="custome_archive dft_dt" style="display:none;">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="arcstrtdt"><?php echo __('From Date');?></label>
                                                    <input type="text" class="smal_txt form-control" placeholder="" readonly id="arcstrtdt" value="<?php echo $frm; ?>"/>
                                                </div>
                                            </li>
                                            <li class="custome_archive dft_dt" style="display:none;">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" for="arcenddt"><?php echo __('To Date');?></label>
                                                    <input type="text" class="smal_txt form-control" placeholder="" readonly id="arcenddt" value="<?php echo $to; ?>"/>
                                                </div>
                                            </li>
                                            <li class="custome_archive drop-srch-li" style="display: none;text-align:center;padding:5px">
                                                <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" type="button" onclick="arcivecustomduedate();" id="btn_archive_search"><?php echo __('Search');?></button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('project', event, 'archive')"><i class="material-icons">&#xE8F9;</i> <?php echo __('Project');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm scrollable" id="dropdown_menu_project">
                                        </ul>
                                    </li>
                                    <li class="drop_menu_mc">
                                        <a href="javascript:jsVoid();" data-toggle="dropdown" onclick="allfiltervalue('archivedby', event, 'archive')"><i class="material-icons">&#xE149;</i> <?php echo __('Archived By');?></a>
                                        <ul class="dropdown_status dropdown-menu drop_smenu ltsm scrollable" id="dropdown_menu_archivedby">
                                        </ul>
                                    </li>
                                </ul>
                            </span>
                            <!-- archive filter ssection end-->

                            <?php echo $this->element('top_menu_options_icon') ?>
                        </div>

                        <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    function closesubscription() {
        var strURL1 = HTTP_ROOT + 'users/check_subscription';
        $.post(strURL1, {}, function (data) {
            $(".fixed-n-bar1").hide();
        });
    }
    $(function () {
        checkProjFltSelect();
        $(".warning_circle_icon > .material-icons").click(function (e) {
            $(".manage_plan_setting").show();
            e.stopPropagation();
        });
        $(".manage_plan_setting").click(function (e) {
            e.stopPropagation();
        });
        $(document).click(function () {
            $(".manage_plan_setting").hide();
            $(".okey").click()
        });
        $(".okey").click(function () {
            $(".manage_plan_setting").hide();
        });
				
				$('#proj_prog_cnt').tipsy({
						gravity: 'w',
						fade: true
				});
				
    });
</script>