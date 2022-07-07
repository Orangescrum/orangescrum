<style type="text/css">
.pad-left-non{padding-left:0;}
.project-name-hd{min-width:138px;background:none;box-shadow:none;border-right:1px solid #6A7A89;font-family:"RobotoDraft-Medium";}
.navbar-brand.nav-logo{background:none;border-right:none;
box-shadow:none;padding:8px 0px 8px 19px;}
.navbar .navbar-nav > li.nav-logo > a {padding:16px 10px 16px 10px;color:#ececec;font-size:16px;width:136px;text-align:left;}
.coupon-hello-bar{height: 50px;width: 100%;background: #ccb485;position: fixed;top: 0;text-align: center; padding: 0 5%;z-index: 999;}
.coupon-hello-bar p{display:inline-block; vertical-align: middle; line-height:40px; font-weight:normal; color:#fff;font-size:13px;margin:0; padding:0;}
.coupon-hello-bar a{ text-decoration:none;}
.coupon-hello-bar a:hover{ text-decoration:none;}
.coupon-hello-bar a:hover span{ color:#436089;border-color:#436089;}
.coupon-hello-bar span {border:1px dashed #fff; color:#fff;padding:3px 5px;font-weight:600;} 
 .coupon-hello-bar .v-seperator{width:2px;height:18px;background: #fff; margin:0 5px; display:inline-block; vertical-align: middle;}
 .tandc {text-align: center;margin-top: -8px;color: #333;font-weight: 600; font-size: 11px;font-style: italic;text-align:center;}
.navbar .profile-bar > li > a.quick_link_ellip{display: block;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;}
.custom-navbar.nav_inr_menu .right_pfl_menu .profile-bar > li.upgrade_plan_li {padding: 5px 15px;}
	.custom-navbar.nav_inr_menu .right_pfl_menu .profile-bar > li.upgrade_plan_li .upgrd_btn{ border-radius: 4px;
    padding: 4px 10px;top:0} 

<?php if(isset($showExtraCoupon) && $showExtraCoupon ==1 && SES_TYPE==1 && CONTROLLER != 'ganttchart' && 0){ ?>
 .custom-navbar{top:50px;}
 .left-menu-panel .side-nav,.task-list-bar{top:100px;}
 .rht_content_cmn.task_lis_page .wrapper, .wrapper.pad_top_fbar {padding-top:174px;} 
 <?php } ?>
</style>
<div class="rt_tutorial"><a href="<?php echo HTTP_ROOT_LIVE.'help';?>" target="_blank">&nbsp;</a></div>
<input type="hidden" name="pageurl" id="pageurl" value="<?php echo HTTP_ROOT; ?>" size="1" readonly="true"/>
<input type="hidden" name="pagename" id="pagename" value="<?php echo PAGE_NAME; ?>" size="1" readonly="true"/>
<input type="hidden" name="fmaxilesize" id="fmaxilesize" value="<?php echo MAX_FILE_SIZE; ?>" size="1" readonly="true"/>
<input type="hidden" name="case_srch" id="case_srch"  size="1" readonly="true" <?php if($case_num) { echo "value='".$case_num."'"; } else {  echo "value=''"; } ?>/>
 
<?php
$popular_plans=Configure::read('POPULAR_PLANS');
$projUniq1 = "";

$priving_arr_fun = array("subscription","transaction", "creditcard","account_activity","pricing",'upgrade_member','account_usages','downgrade','edit_creditcard','confirmationPage','defect_severity','defect_category','defect_issue_type','defect_activity_type','defect_phase', 'defect_root_cause', 'defect_fix_version', 'defect_affect_version', 'defect_origin', 'defect_resolution');

//print $projUniq.'--'.$is_active_proj;
//echo "<pre>";print_r($getallproj);exit;

if(count($getallproj) >= 1) {
	$projUniq1 = $getallproj['0']['Project']['uniq_id'];
}
if( $is_active_proj || (SES_TYPE==3)){
	if(!isset($projUniq)) {
		$projUniq = $projUniq1;
	}
	if(CONTROLLER == 'reports' && (PAGE_NAME == 'chart' || PAGE_NAME == 'glide_chart' || PAGE_NAME == 'hours_report')){
		$projUniq = $proj_uniq;
	}
    if(SES_TYPE == 3 && $projUniq =='all'){
        $projUniq = $getallproj['0']['Project']['uniq_id'];
    }
    setcookie('CPUID', $projUniq, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
    ?>
	
<input type="hidden" name="projFil" id="projFil" value="<?php echo $projUniq; ?>" size="24" readonly="true"/>
<input type="hidden" name="projMethType" id="projMethType" value="<?php echo $_SESSION['project_methodology']; ?>" size="24" readonly="true"/>
<input type="hidden" id="company_trial_expire" value="<?php echo $user_subscription['trial_expired']; ?>" readonly="true"/>

<input type="hidden" name="projIsChange" id="projIsChange" value="<?php echo $projUniq; ?>" size="24" readonly="true"/>

<input type="hidden" name="CS_project_id" id="CS_project_id" value="<?php if(isset($ctProjUniq)) { echo $ctProjUniq; } ?>" size="24" readonly="true"/>
<input type="hidden" id="CS_assign_to" value="<?php echo SES_ID; ?>">
<input type="hidden" id="own_session_id" value="<?php echo SES_ID; ?>">
<?php } ?>

<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
    <div class="navbar custom-navbar nav_inr_menu">
        <div class="container-fluid pad-left-non">
                <div class="navbar-header logo_cmpnay_name_toggle<?php echo ' cmn_white_bg';?>">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                  </button>
                        <a class="navbar-brand nav-logo" href="<?php if ($_COOKIE['FIRST_LOGIN_1']) {echo 'javascript:void(0);';}else{ echo HTTP_ROOT . Configure::read('default_action');} ?>">
                                <img src="<?php echo HTTP_IMAGES; ?>logo/orangescrum-100-100.png" height="32" width="32"/>
                        </a>
                  <div class="logo_cmpany_name">
                  <ul class="nav navbar-nav">
						<li class="respo_menu"><i class="material-icons">&#xE5D2;</i></li>
                        <li class="nav-logo project-name-hd">
                        <a title="<?php  echo (CMP_SITE) ? CMP_SITE : 'Andolasoft'; ?>" href="<?php if ($_COOKIE['FIRST_LOGIN_1']) {echo 'javascript:void(0);';}else{ echo HTTP_ROOT . 'mydashboard';} ?>" class="ellipsis-view company_name_view"><?php echo (CMP_SITE) ? CMP_SITE : 'Andolasoft'; ?></a>
                        </li>
                    <li class="web-menu">
                        <a onclick="javascript:toggleMenuBar();trackEventLeadTracker('Header Link','Expand And Collapse Left Panel','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" class="anchor sidebar-toggle" data-toggle="offcanvas" role="button">
                            <i class="material-icons">&#xE8FE;</i>
                        </a>
                    </li>
                    </ul>
                  </div>
                </div>
                <?php $men_col_class = $theme_settings['navbar_color'] == "gradient-45deg-white" ? " "."cmn_white_bg"." ".$theme_settings['navbar_color']." gradient-shadow" : ' '.$theme_settings['navbar_color'].' gradient-shadow';?>
                <?php $col_class = $theme_settings['navbar_color'];?>
                <div class="navbar-collapse collapse navbar-inverse-collapse pad-left-non"> 
                 <div class="right_pfl_menu<?php echo $men_col_class;?>">
                  <ul class="project_drop_nav_ul">
                        <?php 
                        $withoutprjdropdownpageArr = array('importexport','mycompany','groupupdatealerts', 'task_type','pending_task','resource_utilization','subscription','creditcard','transaction','account_activity','profile','email_notifications','email_reports','getting_started','settings','changepassword','default_view','help','customer_support','cancel_account','pricing','upgrade_member','downgrade', 'listall','confirm_import','resource_availability','average_age_report','create_resolve_report','pie_chart_report','recent_created_task_report','resolution_time_report','time_since_report','PlannedVsActualTaskView','completed_sprint_report','velocity_reports','gitconnect','profitable_report');
                        if((!in_array(PAGE_NAME, $withoutprjdropdownpageArr) && (CONTROLLER !== 'templates') && CONTROLLER != 'Roles' && (CONTROLLER !== 'users' && PAGE_NAME != 'manage') && (!in_array(PAGE_NAME,array('defect_severity','defect_category','defect_issue_type','defect_activity_type','defect_phase','defect_root_cause','defect_fix_version','defect_affect_version','defect_origin','defect_resolution'))) && (CONTROLLER !== 'projects' && PAGE_NAME != 'manage') && (CONTROLLER !== 'UserSidebar' && PAGE_NAME != 'index')  ) || (CONTROLLER == 'ganttchart' && PAGE_NAME == 'manage')) {
                        ?>
                        <?php if(PAGE_NAME !== "work_load"){ ?>
                        <li <?php  if(PAGE_NAME == 'mydashboard' && SES_TYPE < 3){?>style="display:none"<?php } ?>><i class="material-icons folder-icon">&#xE8F9;</i></li>
                        <?php } ?>
                        <?php if(PAGE_NAME !== "work_load"){ ?>
                        <li class="project-dropdown" <?php  if(PAGE_NAME == 'mydashboard' && SES_TYPE < 3){?>style="display:none"<?php } ?>>
                            <div class="btn-group"> 
                                <?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2) ) { } else {?><!--Project:--> <?php } ?>
                                <?php if((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3) ) { ?>
                                    <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
                                    <button class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size padd_cmn" type="button" onClick="setSessionStorage('Header Section No Project','Create Project');newProject();">+ <?php echo __('Create Project');?></button>
                                <?php } ?>
                                    <input type='hidden' id='boarding' value='1'/>
                                <?php } else { ?>
                                    <input type='hidden' id='boarding' value='0'/>
                            <?php if(count($getallproj)=='0'){ ?>
                                    <i style="color:#FF0000"><?php echo __('None');?></i>
                            <?php } else {
                                    if(count($getallproj)=='1'){ ?>
                                        <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl" type="button"  onclick="view_project_menu('<?php echo PAGE_NAME;?>');">
                                        <span id="pname_dashboard" class="ttc ellipsis-view top_header_ptjwth">
                                                <?php if($projUniq == 'all'){ ?>
                                                        <a class="top_project_name" title="<?php echo __('All');?>" href="javascript:void(0);" onClick="updateAllProj(0,0,'dashboard', 'all', 'All');"><?php echo __('All');?></a>
                                                <?php } else { ?>
                                                        <a class="top_project_name" title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" href="javascript:void(0);" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['0']['Project']['name']; ?>'); <?php } ?>"><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a>
                                                <?php } ?>
                                        </span>
																						<i class="nav-dot material-icons">expand_more</i>
                                        </button> 
                                        <?php
                                        //echo "<span style='color:#000;'>".$this->Format->shortLength(ucfirst($getallproj['0']['Project']['name']),20)."</span>";
                                        $swPrjVal = $getallproj['0']['Project']['name'];
                                        $soprjval = $getallproj['0']['Project']['name'];
                                    } else {
                                        $swPrjVal = $this->Format->shortLength($projName,20); 
                                        $soprjval = $projName;	    
                                        //if(trim($soprjval) == ''){
                                            $soprjval = $getallproj['0']['Project']['name'];
                                        //}
                                    ?>
                                <input type ="hidden" id="pname_dashboard_hid" value="<?php echo $this->Format->formatTitle($projName); ?>" />
                                <input type ="hidden" id="first_recent_hid" value="<?php echo $getallproj['1']['Project']['name']; ?>" />
                                <input type ="hidden" id="second_recent_hid" value="<?php echo $getallproj['2']['Project']['name']; ?>" />         
                                <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl" type="button" onclick="view_project_menu('<?php echo PAGE_NAME;?>');">
                                   <span id="pname_dashboard" class="ttc ellipsis-view top_header_ptjwth">
                                    <?php if($projUniq == 'all'){ ?>
                                            <a class="top_project_name" title="<?php echo __('All');?>" href="javascript:void(0);" onClick="updateAllProj(0,0,'dashboard', 'all', 'All');"><?php echo __('All');?></a>
                                    <?php }else{ ?>
                                            <a class="top_project_name" title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" href="javascript:void(0);" onClick="<?php if(PAGE_NAME == 'mydashboard'){ ?> CaseDashboard('<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['name']; ?>'); <?php }else { ?> updateAllProj('proj_<?php echo $getallproj['0']['Project']['uniq_id']; ?>','<?php echo $getallproj['0']['Project']['uniq_id']; ?>', '<?php echo PAGE_NAME; ?>', 0, '<?php echo $getallproj['0']['Project']['name']; ?>'); <?php } ?>"><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a>
                                    <?php } ?>
                                    </span>
                                    <i class="nav-dot material-icons">expand_more</i>
                                </button> 
                                <?php } ?>
                                <div class="dropdown-menu lft popup" id="projpopup">
                                    <center>
                                    <div id="loader_prmenu" style="display:none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/>
                                    </div>
                                    </center>
                                    <?php if(count($getallproj) >= 6) { ?>
                                    <div id="find_prj_dv" class="pr" style="display: none;">
                                    <i class="material-icons">&#xE8B6;</i>
                                    <input type="text" placeholder="<?php echo __('Find Project');?>" class="form-control pro_srch" onkeyup="search_project_menu('<?php echo PAGE_NAME;?>',this.value,event)" id="search_project_menu_txt">
                                    <div id="load_find_dashboard" style="display:none;" class="loading-pro">
                                        <img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
                                    </div>
                                    </div>
                                    <?php } ?>
                                    <div id="ajaxViewProject" style='display:none;'></div>									
                                    <div id="ajaxViewProjects" class="scroll-project"></div>
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </li>
                        <?php } ?>
                        <?php } else { ?>
                            <?php if(count($getallproj) > '0') { ?>
                            <input type ="hidden" id="pname_dashboard_hid" value="<?php echo $this->Format->formatTitle($getallproj['0']['Project']['name']); ?>" />
                        <?php } ?>
                        <?php } ?>
                  </ul>
                  <?php //if(ACCOUNT_STATUS !=2 && $is_active_proj){ ?>
                  <?php if(PAGE_NAME !== "work_load" && PAGE_NAME !== "updates" && PAGE_NAME != "defect"){ ?>
									<?php /*<a href="javascript:void(0);" id="new_onboarding_link" class="tour_top_txt" onclick="newOnboarding();" <?php if(isset($_COOKIE['FIRST_INVITE_2'])){ ?> style="display:inline-block;"<?php }else{ ?> style="display:none;" <?php } ?>><?php echo __('Take a Tour of Orangescrum');?></a>	*/ ?>																	
                  <form class="navbar-form navbar-search top_search header-search-box" role="search">
                        <div id="tour_proj_srch" class="form-group" <?php if(in_array(PAGE_NAME,$priving_arr_fun)){ ?>style="display:none;" <?php } ?>>
                            <div id="srch_remv" onclick="clearSearch('outer');"> 
                                  <i class="material-icons">clear</i> 
                            </div>
                            <div id="srch_load1" class="lod-src-itm"> 
                                  <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading" title="<?php echo __('loading');?>"/> 
                            </div>
							<span class="nav-srch-icon search_top_hide_show_spn"  onclick="trackEventLeadTracker('Top Header','Search','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return sch_slide();">
								<i class="material-icons search_top_hide_show_icon">&#xE8B6;</i>
							</span>
                            <?php if (PAGE_NAME != "dashboard") { ?>
                                  <input type="hidden" name="casePage" id="casePage" value="1" size="4" readonly="true"/>
                            <?php } ?>
                            <input type="text" class="form-control col-md-8 nav-srch-box search_top search_top_hide" name="case_search" autocomplete="off" id="case_search" onkeypress="onKeyPress(event,'case_search');" onkeydown="return goForSearch(event,'');" placeholder="<?php echo __('Search Tasks');?>" />
							<span class="nav-srch-icon search_top_hide"  onclick="return goForSearch('',1);"><i class="material-icons">&#xE8B6;</i></span>
                        </div>
												<div id="ajax_search" class="ajx-srch-dv1"></div>
                  </form>
                 <?php } ?>
                 <?php //} ?>
                  <ul class="nav navbar-nav profile-bar">
					<li class="left_trial upgrd">
						<span class="left_trial_span">
						<?php 
							if($user_subscription['user_limit']){
								$user_alert = $this->Format->getUserStatus($user_subscription['user_limit'], $rem_users);
								if($user_alert){
									print "";
								}
							}else{
								print '&nbsp;';
							}
						?>
					</span>
				</li>
                <li class="upgrade_plan_li">
                    <a href="https://www.orangescrum.com/pricing" target="_blank" title="Upgrade" class="upgrd_btn">Upgrade</a>
                </li>
                    <?php if(PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME !='onbording'){ ?>
                        <?php if(SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3){ ?>
                        <li class="nav-profile-dropdown dropdown hover-menu quick-add-drop cmn_parent_navli vline">
                                <div class="gray-out-quick"></div>
                            <a class="dropdown-toggle quick_link_ellip quick_link_btn" data-toggle="dropdown" href="javascript:void(0)" data-target="#" title="<?php echo __('Quick Links');?>" onclick="trackEventLeadTracker('Header Link','Quick Link','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>'); quicklinkclk();"><?php echo __('Quick Links');?> </a>
                                <?php if(ACCOUNT_STATUS!=2){ ?>
                                <?php $is_menu_hidden = false;
                                    $mnu_length = count($menu_data);
                                    $hd_mnu_length = 0;
                                    foreach ($menu_data as $key => $value) {
                                        if(empty($value['UserQuicklink'])){
                                            $is_menu_hidden = true;
                                        }else{
                                            $hd_mnu_length++;
                                        }
                                    }
                                    $menu_style = ($is_menu_hidden) ? ' style="min-width:inherit;"' : '';
                                    ?>
                                <ul class="dropdown-menu border-box top_maindropdown-menu new-topmenu-list fadeout_bkp"<?php echo $menu_style;?> id="tour_qlink_menu">
                                    <li class="mange_quick_link" onclick="trackEventLeadTracker('Quick Links','Manage Quick Links','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                        <a href="<?php echo HTTP_ROOT;?>quick-link-settings"><span></span><?php echo __('Manage Quick Links');?></a>
                                      </li>
                                    <li style="display:none"><p class="drop-paragraph"><?php echo __('Add New');?></p></li>
                                    <li  class="menu-ttle-hd" style="display:none"><a href="javascript:void(0)" class="hdings"><?php echo __('Create');?></a></li>
                                    <?php if(empty($checked_ql)){ ?>
										<li class="quick_link_li hide_on_click">
                                        <ul>
                                        	<li class="not-hide-li">
											<a href="javascript:void(0)" class="type-of-hd hdings">
                                            <strong><?php echo __('New');?></strong></a>
                                        	</li>
                                            <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?> 
                                        	<li>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="setSessionStorage('Quick Links','Create Project');newProject();">
                                            <i class="material-icons cmn-icon-prop">&#xE8F9;</i><?php echo __('Project');?>
                                        </a>
                                    </li>
                                <?php } ?>
                                    <?php //if(SES_TYPE < 3){?>
                                    <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?> 
                                    <li>
											<a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Invite User');newUser()">
                                            <i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('User');?>
                                        </a>
                                    </li>                                    
									<?php } ?>
									<?php //} ?>
                                     <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?> 
                                    <li>
                                        <a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Create Task');creatask();">
											<i class="material-icons cmn-icon-prop">&#xE862;</i><?php echo __('Task');?>
                                        </a>
                                    </li>
                                <?php } ?>
									<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
                                          <?php /*if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
                                    <li class="qadd-tg-icon">
                                        <a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Create Task Group');addEditMilestone('','','','','','');">
                                            <i class="material-icons cmn-icon-prop">&#xE065;</i><?php echo __('Task Group');?>
                                        </a>
                                    </li>
									<?php }*/ ?>
                                <?php } ?>
									<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                        <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
                                    <li>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="setSessionStorage('Quick Links','Time Log');createlog(0,'')">
                                            <i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry');?>
                                        </a>
                                    </li>
                                <?php } ?>                            
                                <?php } ?>  
								<?php //if(SES_TYPE < 3){?>
								<?php //} ?>
                                </ul>
                            </li>
                            <li class="quick_link_li hide_on_click">
                                    <ul class="inner_analytic_submenu" <?php if(SES_TYPE > 2) { ?><?php } ?>>
                                            <li class="not-hide-li">
                                              <a href="javascript:void(0)" class="type-of-hd hdings">
                                              <strong><?php echo __('Analytics');?></strong></a>
                                            </li>
                                            <li class="all-list-glyph <?php if(CONTROLLER == "reports" && (PAGE_NAME == "hours_report")) { ?>active-list<?php } ?>"> 
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Hours Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."hours-report/" ?>">
                                                            <i class="material-icons hs-icon">&#xE192;</i>
                                                            <?php echo __('Hours Spent');?>
                                                    </a>
                                            </li>
                                            <li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "chart")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Task Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."task-report/" ?>">
                                                            <i class="material-icons">&#xE862;</i>
                                                            <?php echo __('Task Reports');?>
                                                    </a>
                                            </li>	
                                            <?php if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
                                            <li class="<?php if(CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) { ?>active-list<?php } ?>"> 
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Weekly Usage Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."reports/weeklyusage_report/" ?>">
                                                            <i class="material-icons">&#xE922;</i>
                                                            <?php echo __('Weekly Usage');?>
                                                    </a>
                                            </li>
                                            <?php } ?>
											</ul>
                            </li>
                                    <li class="quick_link_li hide_on_click">
                                       <ul>
                                            <li class="not-hide-li">
                                                <a href="javascript:void(0)" class="type-of-hd hdings">
                                                <strong><?php echo __("Others");?></strong></a>
                                            </li>
                                            <?php // if($this->Format->isAllowed('View Invoices',$roleAccess)){ ?>
                                            <li class="prevent_togl_li list-11 <?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")) { echo 'active'; } ?>">
                                                <a onclick="return trackEventLeadTracker('Quick Links','Archive Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT.'archives/listall#caselist';?>">
                                                    <!--<span class="os_sprite arch-icon"></span>-->
                                                    <i class="left-menu-icon material-icons">&#xE149;</i>
                                                    <?php echo __('Archive');?>
                                                </a>
                                            </li>
                                        
											
											
                                                    <li>
                                                        <a class="" href="<?php echo HTTP_ROOT . 'dashboard#activities'; ?>" onclick="trackEventLeadTracker('Quick Links','Activities Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');checkHashLoad('activities');dashboadrview_ga('Activities');">
                                                                    <span title="<?php echo __('Activities');?>"><i class="material-icons">&#xE922;</i><?php echo __('Activities');?></span>
                                                        </a>
                                                    </li>
                                                     <?php if($this->Format->isAllowed('View Calendar',$roleAccess)){ ?>
                                                    <li>
                                                        <a class="" href="<?php echo HTTP_ROOT . 'dashboard#calendar'; ?>" onclick="trackEventLeadTracker('Quick Links','Calendar Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>'); return calendarView('calendar');">
                                                            <span title="<?php echo __('Calendar');?>"><i class="material-icons">&#xE916;</i><?php echo __('Calendar');?></span>
                                                    </a>
                                                    </li>
                                                <?php } ?>
													<?php if(SES_COMP == 1 && SES_TYPE == 2) { ?>
													<li>
                                                        <a class="" href="<?php echo HTTP_ROOT . 'users/manage_company'; ?>">
                                                            <span title="<?php echo __('Manage Company');?>"><i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('Companies');?></span>
														</a>
                                                    </li>
													<?php } ?>
                                            </ul>
                                    </li>
                                    <?php if(SES_TYPE == 1 || SES_TYPE <= 2){ ?>
                                    <li class="quick_link_li hide_on_click">
                                       <ul class="inner_company_submenu">
                                    <li class="not-hide-li">
                                           <a href="javascript:void(0)" class="type-of-hd hdings">
                                            <strong><?php echo __("Company Settings");?></strong></a></li>	
                                                <li><a href="<?php echo HTTP_ROOT.'my-company';?>" onclick="trackEventLeadTracker('Quick Links','My Company Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0AF;</i> <?php echo __('My Company');?></a></li>
																								<li><a href="<?php echo HTTP_ROOT.'smtp-settings';?>"><?php echo __('SMTP Configuration');?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'import-export';?>" onclick="trackEventLeadTracker('Quick Links','Import-Export Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0C3;</i> <?php echo __('Import & Export');?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'task-type';?>" onclick="trackEventLeadTracker('Quick Links','Task Type Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE862;</i> <?php echo __('Task Type');?></a></li>                   
                                                
                                               <!--  <li><a href="<?php echo HTTP_ROOT.'task-settings';?>" onclick="trackEventLeadTracker('Quick Links','Task Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                                <i class="material-icons">&#xE862;</i>
                                                <i class="material-icons abs_set_icon">&#xE8B8;</i> <?php echo __('Task Setting');?></a></li> --> 
                                            <?php  if(SES_TYPE < 3){ ?>
                                             <li <?php if(CONTROLLER == "LogTimes" && (PAGE_NAME == "resource_availability")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','User Role Management','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."user-role-settings/" ?>">
                                                            <i class="material-icons">&#xE7FB;</i>
                                                            <?php echo __('User Role Mgmt');?>
                                                    </a>
                                            </li>
																										
																					<li><a href="<?php echo HTTP_ROOT.'duedate-change-reason';?>" onclick="trackEventLeadTracker('Top Setting','Duedate Change Reason','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
																						<?php echo __('Due Date Change Reason');?></a>
																					</li>
                                                <?php } ?>
                                        </ul>
                                    </li>
                                    <?php }else{ ?>
                                        <li class="quick_link_li hide_on_click">
                                           <ul class="inner_company_submenu">
                                                <li class="not-hide-li"><a href="javascript:void(0)" class="type-of-hd hdings">
                                                <i class="material-icons">&#xE8F9;</i>
                                                <strong>Personal Settings</strong></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'users/profile';?>" onclick="trackEventLeadTracker('Quick Links','My Profile Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons cmn-icon-prop">&#xE7FB;</i> <?php echo __('My Profile');?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'users/changepassword';?>" onclick="trackEventLeadTracker('Quick Links','Change Password Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">lock</i> <?php echo __('Change Password');?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'users/email_notifications';?>" onclick="trackEventLeadTracker('Quick Links','Notifications Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">notification_important</i> <?php echo __('Notifications');?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'users/email_reports';?>" onclick="trackEventLeadTracker('Quick Links','Email Reports Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">email</i> <?php echo __('Email Reports');?></a></li>
                                                <?php if(TOT_COMPANY >= 2) { ?>
                                                    <li><a href="<?php echo HTTP_ROOT.'users/launchpad';?>" onclick="trackEventLeadTracker('Quick Links','Launchpad Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">launch</i> <?php echo __('Launchpad');?></a></li>
                                                <?php } ?>
                                                <li><a href="<?php echo HTTP_ROOT.'users/default_view';?>" onclick="trackEventLeadTracker('Quick Links','Default View Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">view_agenda</i> <?php echo __('Default View');?></a></li>
                                                
                                                <li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Quick Links','Getting Started Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');gettingStarted();"><i class="material-icons">near_me</i> <?php echo __('Getting Started');?></a></li>
                                        </ul>
                                </li>
                        <?php } ?>                                    
									<?php }else{ ?>
										<?php echo $this->element('custom_quicklink', array(
											"menu_data" => $menu_data,
											"checked_ql" => $checked_ql,
                                            'hd_mnu_length'=>$hd_mnu_length
										)); ?>
									<?php } ?>
                                </ul>
                              <?php } ?>
                            </li>
                            <?php } ?>  
                             <?php if (in_array($GLOBALS['user_subscription']['subscription_id'], array(11, 13)) || 1) { ?>
							<?php /*<li class="quick_tour vline" id="startTourBtn" <?php if ((PAGE_NAME == 'dashboard' && CONTROLLER != "project_reports") || (CONTROLLER == "projects" && PAGE_NAME == "manage" && (!isset($this->request->params['pass'][0]) || $this->request->params['pass'][0] != 'active-grid')) || (CONTROLLER == "users" && PAGE_NAME == "manage") || (CONTROLLER == "templates" && PAGE_NAME == "projects")) { ?>style="display:inline-block;"<?php } else { ?>style="display:none;"<?php } ?> rel="tooltip_down" title="<?php echo __('Quick Tour'); ?>">
                <a class="" href="javascript:void(0);" onclick="return trackEventLeadTracker('Left Panel', 'Quick Tour', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                <span class="cmn_lh_sp refer_frnd"></span>
                </a>
							</li> */ ?>
							<!-- <li <?php if(isset($_COOKIE['FIRST_INVITE_2'])){ ?> style="display:none;"<?php } ?>class="quick_tour vline" rel="tooltip_down_btm" title="<?php echo __('Take a Tour of Orangescrum'); ?>" id="tour_after_onboarding">
									<a class="" href="javascript:void(0);" onclick="newOnboarding();return trackEventLeadTracker('Left Panel', 'Quick Tour', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
									<span class="cmn_lh_sp refer_frnd"></span>
									<span class="sonar-wave"></span>
									</a>
            </li> -->
            <?php } ?>
                        <li class="nav-profile-dropdown nav-notification-bar quick-add-drop dropdown hover-menu cmn_parent_navli vline">
                            <a class="dropdown-toggle" data-target="#" href="javascript:void(0)" data-toggle="dropdown" onclick="seenNotification('total');trackEventLeadTracker('Header Link','Notification','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" title="<?php echo __('Notifications'); ?>" rel="tooltip_bot">
                                <span class="notification-icon inactive">
                                    <i class="material-icons">&#xE7F4;</i>
                                </span>
                                <input type="hidden" id="total_notification_count" value="<?php echo $_SESSION['Notification']['TotalCount']; ?>"/>
                                <input type="hidden" id="new_release_count" value=""/>
                                <span class="notification-count ellipsis-view hidden"></span>
                            </a>
                 <div class="dropdown-menu border-box top_maindropdown-menu fadeout_bkp notifiaction_update">
                    <ul class="notification-ul" id="not-container"></ul>
                    <ul class="notification-ul product_up_notfy"></ul>
                    <div class="center_sepa_brd"></div>
                    <div class="cb"></div>
                </div>
                        </li>
                        <?php } ?>
                        <li class="nav-profile-dropdown dropdown hover-menu cmn_parent_navli vline pfl_dtl_li">
						<div class="gray-out-quick"></div>
                        <?php 
                            $usrArr = $this->Format->getUserDtls(SES_ID);
                                if(count($usrArr)) {
                                    $ses_name = $usrArr['User']['name'];
                                    $ses_photo = $usrArr['User']['photo'];
                                    $ses_email = $usrArr['User']['email'];
                                    $ses_last_name = $usrArr['User']['last_name'];
                                }
                        ?>
                          <a href="javascript:void(0);" data-target="#" class="dropdown-toggle" data-toggle="dropdown" id="tour_profile_setting">
                                <div class="prof_sett">
                                        <span class="user_ipad"><?php echo $this->Format->shortLength(trim($ses_name),8); ?></span>
                                        <?php if(trim($ses_photo)) { ?>
                                        <img data-original="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo $ses_photo; ?>&sizex=28&sizey=28&quality=100" class="lazy round_profile_img" height="28" width="28" />
                                        <?php } else {
											$random_bgclr = $this->Format->getProfileBgColr(SES_ID);
											$usr_name_fst = mb_substr(trim($ses_name),0,1, "utf-8");											
										?>
										<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
                                        <?php } ?>
                                        <span class="sett_icn">
											<i class="material-icons">&#xE8B8;</i>
                                        </span>
                                        <div class="cb"></div>
                                </div>
                          </a>
                          <div class="dropdown-menu top_maindropdown-menu cap-setting cmn_setting_menu fadeout_bkp" id="tour_mainporf_setting_drop">
                          <div class="cmn_groupy_menu">
                            <p class="menu_title_hd drop-paragraph">
                              <span class="cmpny_placehld_icon"><i class="material-icons">business</i></span>
                            <?php /*echo __('This account is managed by');*/?> <span title="<?php echo CMP_SITE; ?>" class="account_mgt_by"><?php echo $this->Format->shortLength(CMP_SITE,25); ?></span></p>
                                    <ul id="group_menu">
								
                              <li><a href="javascript:void(0)" class="grp_ttle togle_link">
                              <span class="cmn_cstm_set"><i class="material-icons">perm_identity</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span> <?php echo __('Personal Settings');?></a>
                                <ul class="grp_sub_item">
                                  <li><a href="<?php echo HTTP_ROOT.'users/profile';?>" onclick="return trackEventLeadTracker('Top Setting','My Profile Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('My Profile');?></a></li>
                                  <li><a href="<?php echo HTTP_ROOT.'users/changepassword';?>" onclick="return trackEventLeadTracker('Top Setting','Change Password Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Change Password');?></a></li>
                                  <li><a href="<?php echo HTTP_ROOT.'users/email_notifications';?>" onclick="return trackEventLeadTracker('Top Setting','Notifications','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Notifications');?></a></li>
								  <li><a href="<?php echo HTTP_ROOT.'users/email_reports';?>" onclick="trackEventLeadTracker('Top Setting','Email Reports Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Email Reports');?></a></li>
                                  
                                   <li>
                                    <a href="<?php echo HTTP_ROOT;?>quick-link-settings"><span></span><?php echo __('Quick Links');?></a>
                                  </li>
                                  <li>
                                 	<a href="<?php echo HTTP_ROOT;?>bookmarks/bookmarksList"><span></span><?php echo __('Bookmarks');?></a>
                                  </li>
                                </ul>
                              </li>
                                        <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1) { ?>
                              <li><a href="javascript:void(0);" class="grp_ttle togle_link" id="tour_company_settings"><span class="cmn_cstm_set"><i class="material-icons">business</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span>  <?php echo __('Company Settings');?></a>
                                <ul class="grp_sub_item">
												<?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
														<li><a href="<?php echo HTTP_ROOT.'my-company';?>" onclick="trackEventLeadTracker('Top Setting','My Company Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('My Company');?></a></li>
														<?php if(SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320 || ($this->Format->isChatOn() || (!in_array($GLOBALS['user_subscription']['subscription_id'],Configure::read('PLANS_NOT_ALLOW_CHAT'))))){?> 
																<!-- <li><a href="<?php echo HTTP_ROOT.'chat-settings';?>" onclick="trackEventLeadTracker('Top Setting','Chat Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Chat Settings');?></a></li> -->
												<?php } ?>
														
														
														<li><a href="<?php echo HTTP_ROOT.'project-status';?>" onclick="trackEventLeadTracker('Top Setting','Project Status','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Project Status');?></a></li>
													
                                                    
									
											
                                                       <?php } ?>
                                </ul>
                              </li>
                              <li><a href="javascript:void(0);" class="grp_ttle togle_link" id="tour_project_settings"><span class="cmn_cstm_set"><i class="material-icons">work</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span>  <?php echo __('Project Settings');?></a>
                                <ul class="grp_sub_item">
                                                <?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                    <li><a href="<?php echo HTTP_ROOT.'import-export';?>" onclick="trackEventLeadTracker('Top Setting','Import-Export Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Import & Export');?></a></li>
                                                    <li><a href="<?php echo HTTP_ROOT.'task-type';?>" id="tour_task_type"><?php echo __('Task Type');?></a></li>          
                                  <?php } ?>
                                                </ul>
                                            </li>

                                        <?php } ?>
                                <li><a href="javascript:void(0)" class="grp_ttle togle_link"><span class="cmn_cstm_set"><i class="material-icons">info</i></span> <?php echo __('Orangescrum Info');?></a>
                                    <ul class="grp_sub_item">
                                        <li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Top Setting','Getting Started Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');gettingStarted();"><?php echo __('Getting Started');?></a></li> 
                                        <li><a href="https://www.orangescrum.com/schedule-a-demo" title="Talk to an Expert">Talk to an Expert</a></li> 
                                    </ul>
																		</li>
															<?php if(TOT_COMPANY >= 2)  { ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT.'users/launchpad';?>" class="grp_ttle" onclick="return trackEventLeadTracker('Top Setting','Launchpad','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><span class="cmn_cstm_set"><i class="material-icons">flight_takeoff</i></span> <?php echo __('Launchpad');?></a></li>
															<?php } ?>
														<?php if((USER_TYPE == 1) || (IS_MODERATOR == 1)) { ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT.'osadmins';?>" style="color:#FABC6A" class="grp_ttle" target="_blank"><i class="material-icons">accessible</i> <?php echo __('Super Admin');?></a></li>
															<?php } ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT;?>users/logout" class="sign_out grp_ttle" onclick="trackEventLeadTracker('Logout','Logout','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><span class="cmn_cstm_set"><i class="material-icons">power_settings_new</i></span> <?php echo __('Log Out');?></a></li>
                                            </ul>
                                    </div>
                                </div>
                        </li>
                  </ul>
                </div>
                  <div class="cb"></div>
                </div>
        </div>
</div>
<?php } else { ?>
<?php } ?>
<?php if(PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support") { ?>

<input type="hidden" name="pub_counter" id="pub_counter" value="0" />
<input type="hidden" name="hid_casenum" id="hid_casenum" value="0" />
<div onClick="removePubnubMsg();" id="punnubdiv" align="center" style="display:none;">
  <div class="fls-spn">
        <i class="material-icons">&#xE160;</i>
	<div id="pubnub_notf" class="topalerts alert_info msg_span" ></div>
	<div class="fr close_popup" >X</div>
  </div>
</div>
<!-- Flash Success and error msg starts --> 
<!-- Flash Success and error msg ends --> 
<!-- common popups like Create task, Create project, Invite User -->
<?php } ?>
<?php //echo $this->element('popup'); ?>
<!--  common popups -->
<?php if(PAGE_NAME =='onbording'){ ?>
<div class="crt_slide task_action_bar">
	<button type="button" class="btn gry_btn task_create_back" onclick="crt_popup_close()"><i class="icon-backto"></i><?php echo __('Go Back');?></button>
</div>
<?php } ?>
<?php if(PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME !='onbording'){ ?>
<!-- breadcrumb, project popup 
<input type="hidden" id="checkload" value="0">-->  
<?php //echo $this->element('breadcrumb'); ?>
<?php if(PAGE_NAME=='dashboard'){?>
<?php } ?>
<?php } ?>
<script language="javascript" type="text/javascript">
$(document).ready(function () { 
  $('#group_menu > li > a').click(function(){
    if (!$(this).hasClass('active')){
      $('#group_menu li .grp_sub_item').slideUp();
      $(this).next().slideToggle();
      $('#group_menu li a').removeClass('active');
      $(this).addClass('active');
    } else {
      $('#group_menu li .grp_sub_item').slideUp();
      $('#group_menu li a').removeClass('active');
    }
  });
});
function gettingStarted(){
	setSessionStorage('Header Section', 'Getting Started');
	document.location.href = "<?php echo HTTP_ROOT.'getting_started';?>";
}
function setVideoContent(){
	$('.player_wrapper11').html('');	
	$('.player_wrapper11').html('<iframe id="play_yt_video" width="600" height="335" src="https://www.youtube.com/embed/bTyAakCMrnY?rel=0&enablejsapi=1" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>');
}
/*var ONBOARD_TOUR = "<?php echo $_SESSION['ONBOARD_TOUR']; ?>";*/ 
</script>
<script type="text/template" id="notification_tmpl">
<?php echo $this->element('top_notifications'); ?>
</script>
<script type="text/template" id="pr_release_notification_tmpl">
<?php echo $this->element('top_notifications_productrelease'); ?>
</script>
<?php if (CONTROLLER == 'Pages' && PAGE_NAME == 'release_activity') { ?>
<script type="text/template" id="productrelease_tmpl">
<?php echo $this->element('productrelease'); ?>
</script>
<?php } ?>