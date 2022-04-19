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

$priving_arr_fun = array("subscription","transaction", "creditcard","account_activity","pricing",'upgrade_member','account_usages','downgrade','edit_creditcard','confirmationPage');

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
<?php if(isset($showExtraCoupon) && $showExtraCoupon ==1 && SES_TYPE==1  && CONTROLLER != 'ganttchart'){ ?>
  <div class="coupon-hello-bar" style="display:none !important">
	  <div>
		  <p> <?php echo __('Just for you');?>: <?php echo __('Use coupon');?> <a href="<?php echo HTTP_ROOT.'users/upgrade_member/'.$popular_plans[1];?>?coupon=<?php echo base64_encode('OSADD25')?>"><span>OSADD25</span></a> <?php echo __('and Get FLAT 20%+EXTRA 5% off on all Yearly Plans');?>.</p> <div class="v-seperator"></div>
		  <p><?php echo __('Use coupon');?> <a href="<?php echo HTTP_ROOT.'users/upgrade_member/'.$popular_plans[0];?>?coupon=<?php echo base64_encode('OSADD15')?>"><span>OSADD15</span></a> <?php echo __('and Get FLAT 10%+EXTRA 5% off on all Monthly Plans');?>.</p>
	  </div>
	  <div class="tandc"><?php echo __('Note: Not applicable for Statrtup plans (Monthly & Yearly) and higher Professional plans(more than 100 users)');?>.</div>
  </div>
  <?php } ?>
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
                        <?php /* <li class="new_task_li crtask" <?php if((in_array(PAGE_NAME,$priving_arr_fun) && SES_ID && SES_ID == 1644) || in_array(PAGE_NAME, array('help', 'customer_support','updates'))){ ?> style="display:none;"<?php } ?>>
                         <?php //if(ACCOUNT_STATUS!=2){ ?>
                           <?php //if($is_active_proj){ ?>   
                            <a href="javascript:void(0)" class="btn btn-default create-task-btn" onclick="creatask();"><i class="os_sprite icon_ct_task"></i>Create Task</a>
                            <?php //} } ?>
                        </li> */ ?>
                        <?php 
                        $withoutprjdropdownpageArr = array('importexport','mycompany','groupupdatealerts', 'task_type','pending_task','resource_utilization','subscription','creditcard','transaction','account_activity','profile','email_notifications','email_reports','getting_started','settings','changepassword','default_view','help','customer_support','cancel_account','pricing','upgrade_member','downgrade', 'listall','confirm_import','resource_availability','average_age_report','create_resolve_report','pie_chart_report','recent_created_task_report','resolution_time_report','time_since_report','completed_sprint_report','velocity_reports','gitconnect');
                        if((!in_array(PAGE_NAME, $withoutprjdropdownpageArr) && (CONTROLLER !== 'templates') && (CONTROLLER !== 'users' && PAGE_NAME != 'manage') && (CONTROLLER !== 'projects' && PAGE_NAME != 'manage')) || (CONTROLLER == 'ganttchart' && PAGE_NAME == 'manage')) {
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
                                            <i class="nav-dot material-icons">&#xE5D3;</i>
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
                                    <i class="nav-dot material-icons">&#xE5D3;</i>
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
                  <?php if(PAGE_NAME !== "work_load"){ ?>
									<a href="javascript:void(0);" id="new_onboarding_link" class="tour_top_txt" onclick="newOnboarding();" <?php if(isset($_COOKIE['FIRST_INVITE_2'])){ ?> style="display:inline-block;"<?php }else{ ?> style="display:none;" <?php } ?>><?php echo __('Take a Tour of Orangescrum');?></a>																		
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
						if(!in_array(PAGE_NAME,array('pricing','upgrade_member'))){
								if(!$user_subscription['is_cancel'] && ($user_subscription['subscription_id'] == CURRENT_FREE_PLAN || $user_subscription['subscription_id'] == CURRENT_EXPIRED_PLAN) && SES_TYPE == 1 && SES_COMP != 5303  && SES_COMP != 8728 && SES_COMP != 15602 && SES_COMP != 17945 && SES_COMP != 20414){
									$t_dt = date("Y-m-d H:i:s", strtotime($user_subscription['created'].' +'.FREE_TRIAL_PERIOD.'days'));
									if($user_subscription['extend_trial'] != 0){
											$t_dt = date("Y-m-d H:i:s", strtotime($user_subscription['extend_date'].' +'.$user_subscription['extend_trial'].'days'));
									}
									$datetime1 = new DateTime(date("Y-m-d H:i:s"));
									$datetime2 = new DateTime($t_dt);
									$interval = $datetime1->diff($datetime2);
									$days_to_go = $interval->format('%R%a');
									if($days_to_go < 0){
													print "<span><a href='".HTTP_ROOT."users/pricing' class='dropdown-toggle upgrade_btn' onclick='return trackEventLeadTracker(\'Top Header\',\'Upgrade Now\',\'".$_SESSION['SES_EMAIL_USER_LOGIN']."\');'><button class='btn btn_cmn_efect cmn_bg btn-info cmn_size upgrd_btn ".$col_class."' type='button'>".__('Upgrade Now')."</button></a></span>";
									}else{
													print "<span class='single_line'><a href='".HTTP_ROOT."users/pricing' class='trial-left' onclick='return trackEventLeadTracker(\'Top Header\',\'Upgrade Now\',\'".$_SESSION['SES_EMAIL_USER_LOGIN']."\');'><span style='color:#00DE00;' class='upgrd_btn_top_hdr'>".$interval->format('%a')." ".__('Day(s) left on your trial')." </span><button class='btn btn_cmn_efect cmn_bg btn-info cmn_size upgrd_btn ".$col_class."' type='button'>".__('Upgrade Now')."</button></a></span>";
									}
								}else{
										print '&nbsp;';
								}						
						}else{
							print '&nbsp;';
						}
						?>
					</span>
				</li>
                    <?php if(PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME !='onbording'){ ?>
                        <?php if(SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3){ ?>
                        <li class="nav-profile-dropdown dropdown hover-menu quick-add-drop cmn_parent_navli">
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
                                        <li class="mange_quick_link">
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
                                          <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?> 
                                    <li class="qadd-tg-icon">
                                        <a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Create Task Group');addEditMilestone('','','','','','');">
                                            <i class="material-icons cmn-icon-prop">&#xE065;</i><?php echo __('Task Group');?>
                                        </a>
                                    </li>
									<?php } ?>
                                <?php } ?>
									<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                        <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
                                    <li>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="setSessionStorage('Quick Links','Time Log');createlog(0,'')">
                                            <i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry');?>
                                        </a>
                                    </li>
                                <?php } ?>
                                     <?php if($this->Format->isAllowed('Start Timer',$roleAccess)){ ?>
                                    <li id="tour_start_timer">
                                        <a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Start Timer');openTimer()">
                                            <i class="material-icons cmn-icon-prop">&#xE425;</i><?php echo __('Start Timer');?>
                                        </a>
                                    </li>
                                <?php } ?>  
                                <?php } ?>  
								<?php //if(SES_TYPE < 3){?>
                                    <?php if($this->Format->isAllowed('View Invoices',$roleAccess)){ ?> 
                                    <li>
											<a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'easycases/invoice';}?>" onclick="return setSessionStorage('Quick Links','New Invoice');">
                                            <i class="left-menu-icon material-icons cmn-icon-prop">&#xE53E;</i><?php echo __('Invoice');?> <?php echo $this->Format->getlockIcon(); ?>
                                        </a>
                                    </li>                                    
								<?php } ?>
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
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Hours Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."hours-report/";} ?>">
                                                            <i class="material-icons hs-icon">&#xE192;</i>
                                                            <?php echo __('Hours Spent');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                            <li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "chart")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Task Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."task-report/";} ?>">
                                                            <i class="material-icons">&#xE862;</i>
                                                            <?php echo __('Task Reports');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>	
                                            <?php if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
                                            <li class="<?php if(CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) { ?>active-list<?php } ?>"> 
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Weekly Usage Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."reports/weeklyusage_report/";} ?>">
                                                            <i class="material-icons">&#xE922;</i>
                                                            <?php echo __('Weekly Usage');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                            <?php } ?>
                                            <?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
                                            <li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "resource_utilization")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."resource-utilization/";} ?>">
                                                            <i class="material-icons">&#xE335;</i>
                                                            <?php echo __('Resource Utilization');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                        <?php } ?>
                                              <?php // if(SES_TYPE < 3){
                                                if($this->Format->isAllowed('View Resource Availability',$roleAccess)){ 
                                              if($this->Format->isResourceAvailabilityOn('upgrade')){
                                                       if($this->Format->isResourceAvailabilityOn('status')){
                                                       ?>
                                             <li <?php if(CONTROLLER == "LogTimes" && (PAGE_NAME == "resource_availability")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:showUpgradPopup(1);">
                                                            <i class="material-icons">&#xE7FB;</i>
                                                            <?php echo __('Resource Availability');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                                       <?php }}else{ ?>
                                             <li>
                                                 <a onclick="showUpgradPopup(0,1,1);trackEventLeadTracker('Quick Links','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:void(0);" class="upgradeLink"><i class="material-icons">&#xE7FB;</i><?php echo __('Resource Availability');?> <?php echo $this->Format->getlockIcon(); ?></a>
                                            </li>
                                            <?php }
                                            }?>
											<li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "pending_task")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','Pending Task Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:showUpgradPopup(1);">
                                                            <i class="material-icons">&#xE85F;</i>
                                                            <?php echo __('Pending Task');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                    <?php } ?>
                                            <?php if($this->Format->isTimesheetOn()) { ?>
                                            <li>
                                                    <a onclick="trackEventWithIntercom('Quick Links', {'view': 'timesheet'});" href="javascript:showUpgradPopup(1);">
                                                            <i class="material-icons">&#xE616;</i>
                                                            <?php echo __('Weekly Timesheet');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                            <li>
                                                    <a onclick="trackEventWithIntercom('Quick Links', {'view': 'timesheet'});" href="javascript:showUpgradPopup(1);">
                                                            <i class="material-icons">&#xE8DF;</i>
                                                            <?php echo __('Daily Timesheet');?> <?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
                                            <?php }else{ ?>
                                                <li>
                                                       <a onclick="showUpgradPopup(0,1);" href="javascript:void(0);">
                                                               <i class="material-icons">&#xE616;</i>
                                                               <?php echo __('Weekly Timesheet');?> <?php echo $this->Format->getlockIcon(); ?>
                                                       </a>
                                               </li>
                                               <li>
                                                       <a onclick="showUpgradPopup(0,1);" href="javascript:void(0);">
                                                               <i class="material-icons">&#xE8DF;</i>
                                                               <?php echo __('Daily Timesheet');?> <?php echo $this->Format->getlockIcon(); ?>
                                                       </a>
                                               </li>
                                            <?php }?>
                                    </ul>
                            </li>
                                    <li class="quick_link_li hide_on_click">
                                       <ul>
                                            <li class="not-hide-li">
                                                <a href="javascript:void(0)" class="type-of-hd hdings">
                                                <strong><?php echo __("Others");?></strong></a>
                                            </li>
                                            <li class="prevent_togl_li list-11 <?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")) { echo 'active'; } ?>">
                                                <a onclick="return trackEventLeadTracker('Quick Links','Archive Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT.'archives/listall#caselist';?>">
                                                    <!--<span class="os_sprite arch-icon"></span>-->
                                                    <i class="left-menu-icon material-icons">&#xE149;</i>
                                                    <?php echo __('Archive');?>
                                                </a>
                                            </li>
                                            <?php if($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
                                            <li class="prevent_togl_li list-12 <?php if(CONTROLLER == "templates") { echo 'active'; } ?>">
                                                <a onclick="return trackEventLeadTracker('Quick Links','Project Template','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT. 'templates/projects';?>">
                                                            <!--<span class="os_sprite temp-icon"></span>-->
                                                            <i class="left-menu-icon material-icons">&#xE8F1;</i>
                                                            <?php echo __('Template');?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                                    <?php //if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
                                                        <?php if($this->Format->isAllowed('View Gantt Chart',$roleAccess)){ ?>
													<?php if($this->Format->isFeatureOn('gantt',$user_subscription['subscription_id'])) { ?>
														<li class="prevent_togl_li list-13 <?php if(CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) { echo 'active'; } ?>">
															<a onclick="return trackEventLeadTracker('Quick Links','Gantt Chart','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:showUpgradPopup(0,1);">
																<i class="left-menu-icon material-icons">&#xE919;</i>
																<?php echo __('Gantt Chart');?><span style="margin-left:-2px"><?php echo $this->Format->getlockIcon(1); ?></span>
															</a>
														</li>
													<?php }else{ ?>
                                                    <li class="prevent_togl_li list-13 <?php if(CONTROLLER == "ganttchart" && (PAGE_NAME == "manage" || PAGE_NAME == "ganttv2")) { echo 'active'; } ?>">
                                                        <a onclick="return trackEventLeadTracker('Quick Links','Gantt Chart','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'ganttchart/manage';}?>">
                                                                <!--<span class="os_sprite gct-icon"></span>-->
                                                                <i class="left-menu-icon material-icons">&#xE919;</i>
                                                                <?php echo __('Gantt Chart');?><span style="margin-left:-2px"><?php echo $this->Format->getlockIcon(); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
											
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
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'reminder-settings';}?>" onclick="trackEventLeadTracker('Quick Links','Daily Catch-Up Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE003;</i> <?php echo __('Daily Catch-Up');?><?php echo $this->Format->getlockIcon(); ?></a></li>
                                                <li><a href="<?php echo HTTP_ROOT.'import-export';?>" onclick="trackEventLeadTracker('Quick Links','Import-Export Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0C3;</i> <?php echo __('Import & Export');?></a></li>
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'task-type';}?>" onclick="trackEventLeadTracker('Quick Links','Task Type Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE862;</i> <?php echo __('Task Type');?><?php echo $this->Format->getlockIcon(); ?></a></li>
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'labels';}?>" onclick="trackEventLeadTracker('Quick Links','Manage Labels Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">label</i> <?php echo __('Manage Labels');?><?php echo $this->Format->getlockIcon(); ?></a></li>
                                                <?php if($this->Format->isAllowed('View Invoice Setting',$roleAccess)){ ?>
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'invoice-settings';} ?>" onclick="trackEventLeadTracker('Quick Links','Invoice Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE53E;</i> <?php echo __('Invoice Settings');?><?php echo $this->Format->getlockIcon(); ?></a></li>
                                            <?php } ?>
                                               <!--  <li><a href="<?php echo HTTP_ROOT.'task-settings';?>" onclick="trackEventLeadTracker('Quick Links','Task Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                                <i class="material-icons">&#xE862;</i>
                                                <i class="material-icons abs_set_icon">&#xE8B8;</i> <?php echo __('Task Setting');?></a></li> -->
                                                <?php if($this->Format->isAllowed('View Resource Availability',$roleAccess)){ ?>
                                                 <?php if($this->Format->isResourceAvailabilityOn('upgrade')){?>
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'LogTimes/resource_settings';} ?>" onclick="trackEventLeadTracker('Quick Links','Resource Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE7FB;</i><i class="material-icons abs_set_icon">&#xE8B8;</i> <?php echo __('Resource Setting');?><?php echo $this->Format->getlockIcon(); ?></a></li>
                                                <?php  }else{?>
                                                    <li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Quick Links','Resource Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');showUpgradPopup(0,1,1);"><i class="material-icons">&#xE7FB;</i><i class="material-icons abs_set_icon">&#xE8B8;</i> <?php echo __('Resource Setting');?> &nbsp;<?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                <?php } ?>                                                
                                                <?php } ?>                                                
                                                <?php if(SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320){?> 
                                                <li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'chat-settings';} ?>" onclick="trackEventLeadTracker('Quick Links','Chat Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0B7;</i> <?php echo __('Chat Setting');?></a><?php echo $this->Format->getlockIcon(); ?></li>
                                                <?php } ?>
                                            <?php  if(SES_TYPE < 3){ ?>
                                             <li <?php if(CONTROLLER == "LogTimes" && (PAGE_NAME == "resource_availability")) { ?>class="active-list" <?php }?>>
                                                    <a onclick="return trackEventLeadTracker('Quick Links','User Role Management','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."user-role-settings/";} ?>">
                                                            <i class="material-icons">&#xE7FB;</i>
                                                            <?php echo __('User Role Mgmt');?><?php echo $this->Format->getlockIcon(); ?>
                                                    </a>
                                            </li>
																					<?php	
																					if($this->Format->isTimesheetOn(5)){ ?>
																					<li>
																					<a onclick="trackEventLeadTracker('Quick Links','Workflow Setting','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'workflow-setting';} ?>" id="tour_sts_work_flow_setting" title="<?php echo __('Status Workflow Setting');?>">
																					<i class="material-icons">perm_data_setting</i> <?php echo __('Status Workflow');?><?php echo $this->Format->getlockIcon(); ?></a>
																					</li>
																					<?php }else{ ?>
																					<li>
																					<a onclick="showUpgradPopup(0,0,0,1);" href="javascript:void(0);" id="tour_sts_work_flow_setting" title="<?php echo __('Status Workflow Setting');?>">
																					<?php echo __('Status Workflow');?> <?php echo $this->Format->getlockIcon(1); ?>
																					</a>
																					</li>
																					<?php } ?>						
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
                                                <li><a href="<?php echo HTTP_ROOT.'updates';?>" onclick="trackEventLeadTracker('Quick Links','Product Updates Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">system_update</i> <?php echo __('Product Updates');?></a></li>
                                                <li><a href="<?php echo KNOWLEDGEBASE_URL; ?>" target="_blank" onclick="trackEventLeadTracker('Quick Links','Help Desk Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">live_help</i> <?php echo __('Help Desk');?></a></li>
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
							<li <?php if(isset($_COOKIE['FIRST_INVITE_2'])){ ?> style="display:none;"<?php } ?>class="quick_tour vline" rel="tooltip_down_btm" title="<?php echo __('Take a Tour of Orangescrum'); ?>" id="tour_after_onboarding">
									<a class="" href="javascript:void(0);" onclick="newOnboarding();return trackEventLeadTracker('Left Panel', 'Quick Tour', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
									<span class="cmn_lh_sp refer_frnd"></span>
									</a>
            </li>
            <?php } ?>
						<li class="feedback vline" title="<?php echo __('Feedback');?>" rel="tooltip_down">
							<span data-toggle="modal" data-target="#feeback_modal"><i class="material-icons">&#xE87F;</i></span>
						</li>
						<li class="help_navli vline" title="<?php echo __('Help');?>" rel="tooltip_down">
               <a href="<?php echo HTTP_ROOT;?>help-support">
							<span data-backdrop="false" onclick="trackEventLeadTracker('Header Link','Help','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php /*echo __('Help');*/?><i class="material-icons">help</i></span></a>
						</li>
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
                        <li class="nav-profile-dropdown dropdown hover-menu cmn_parent_navli  vline pfl_dtl_li">
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
                            <?php /*<div>
                                        <?php if(isset($user_subscription) && $user_subscription['id'] && $is_active_proj){
                                                if(!$user_subscription['is_free']  && (SES_TYPE==1 || SES_TYPE==2)){ ?>
                                                    <div class="usage_detail_on_top">
                                                    <p class="pro_dsc">
                                                            <?php echo __('Projects');?>: <span <?php if((strtolower($user_subscription['project_limit'])!='unlimited') && $used_projects_count>=$user_subscription['project_limit']){?> style="color:#333;"<?php }?> ><b><?php echo $used_projects_count;?></b> <?php echo __('of');?> <b id="tot_project_limit"><?php echo $user_subscription['project_limit'];?></b></span>,&nbsp; 
                                                            <?php if((strtolower($user_subscription['user_limit'])!='unlimited')){
                                                                    $user_alrdy_added = $user_subscription['user_limit'] - $rem_users;
                                                            ?>
                                                                    <?php echo __('Users');?>: <span <?php if((strtolower($user_subscription['user_limit'])!='unlimited') && $user_alrdy_added >= $user_subscription['user_limit']){?> style="color:#333;"<?php }?> ><b><?php echo $user_alrdy_added;?></b> <?php echo __('of');?> <b id="tot_user_limit"><?php echo $user_subscription['user_limit'];?></b></span>,&nbsp; 
                                                            <?php } else if((strtolower($user_subscription['user_limit']) == 'unlimited')){ ?>
                                                                    <?php echo __('Users');?>: <b id="tot_user_limit"><?php echo $user_subscription['user_limit'];?></b>,&nbsp; 
                                                            <?php } ?>
                                                            <?php echo __('Storage');?>: 
                                                            <span id="storage_spn">
                                                            <span <?php if($used_storage >= $user_subscription['storage']){?> style="color:#333" <?php }?>> 
                                                            <?php if($user_subscription['storage'] < 1024) { ?>
                                                                    <span id="used_storage"><b><?php echo $used_storage;?></b> </span>MB
                                                            <?php
                                                            } else {
                                                                    /*$user_used = $used_storage;
                                                                    $user_used_label = 'MB';
                                                                    if($used_storage >= 1024){										
                                                                            $user_used = round($used_storage/1024);
                                                                            $user_used_label = 'GB';
                                                                    }*/
                                                                $user_used_label = 'GB';
                                                            ?>
                                                                <span id="used_storage"><b><?php echo round($used_storage/1024);?></b> </span><?php echo $user_used_label; ?>
                                                        <?php } ?>
													 <?php echo __('of');?> 
                                                            <?php if($user_subscription['storage'] < 1024) { ?>
                                                                    <span id="max_storage"><b><?php echo $user_subscription['storage'];?></b></span><span id="storage_met"><?php if(strtolower($user_subscription['storage']) !='unlimited'){ ?>MB<?php } ?></span>
                                                            <?php } else { ?>
                                                                    <span id="max_storage"><b><?php echo round($user_subscription['storage']/1024);?></b></span> <span id="storage_met">GB</span>
                                                            <?php } ?>
                                                            </span>
                                                                        </span>&nbsp;
                                                                </p>
                                                                </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if (!$user_subscription['is_cancel'] && ($user_subscription['subscription_id'] == CURRENT_FREE_PLAN || $user_subscription['subscription_id'] == CURRENT_EXPIRED_PLAN) && $user_subscription['lifetime_free'] !=1 && SES_TYPE == 1 && SES_COMP != 5303 && SES_COMP != 8728 && SES_COMP != 15602 && SES_COMP != 17945 && SES_COMP != 20414) {
                                                $t_dt = date("Y-m-d H:i:s", strtotime($user_subscription['created'] . ' +' . FREE_TRIAL_PERIOD . 'days'));
                                                if ($user_subscription['extend_trial'] != 0) {
                                                    $t_dt = date("Y-m-d H:i:s", strtotime($user_subscription['extend_date'] . ' +' . $user_subscription['extend_trial'] . 'days'));
                                                }
                                                $datetime1 = new DateTime(date("Y-m-d H:i:s"));
                                                $datetime2 = new DateTime($t_dt);
                                                $interval = $datetime1->diff($datetime2);
                                                $days_to_go = $interval->format('%R%a');
                                                if ($days_to_go < 0) {
                                                    print "<div class='usage_detail_on_top'><p style='margin:0px;'><span>" . FREE_TRIAL_PERIOD . "-".__('day FREE Trial')." <span style='color:red;margin-right:15px;'>".__('Expired')."</span><a href='" . HTTP_ROOT . "users/pricing' onclick='return trackEventLeadTracker(\'Top Settings\',\'Upgrade\',\'".$_SESSION['SES_EMAIL_USER_LOGIN']."\');' class='dropdown-toggle upgrade_btn' ><button class='btn btn_cmn_efect cmn_bg btn-info cmn_size upgrd_btn' type='button'>".__('Upgrade Now')."</button></a></span></p></div>";
                                                } else {
                                                    print "<div class='usage_detail_on_top'><p style='margin:0px;'><span>" . FREE_TRIAL_PERIOD . "-".__('day FREE Trial')." <span original-title='" . date("D, j M Y", strtotime($t_dt)) . "' rel='tooltip' style='color:#333; margin-right:15px;'>(" . $interval->format('%a') . " ".__('day(s) to go').")</span><a href='" . HTTP_ROOT . "users/pricing' onclick='return trackEventLeadTracker(\'Top Settings\',\'Upgrade\',\'".$_SESSION['SES_EMAIL_USER_LOGIN']."\');' class='dropdown-toggle upgrade_btn' ><button class='btn btn_cmn_efect cmn_bg btn-info cmn_size' type='button'>".__('Upgrade')."</button></a></span></p></div>";
                                                }
                                            }
                                            ?>									
                            </div> */?>
                            <ul id="group_menu">
							<?php if(SES_TYPE == 1) { ?>
                              <li><a href="javascript:void(0)" class="grp_ttle togle_link"><span class="cmn_cstm_set"><i class="material-icons">face</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span> <?php echo __('Account Settings');?></a>
                                <ul class="grp_sub_item">
                                  <li class="setng_subcription"><a href="<?php echo HTTP_ROOT.'pricing';?>" onclick="trackEventLeadTracker('Top Setting','Pricing Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Plan & Pricing');?></a></li>
                                  <?php  if($this->Format->isAllowed('View Invoices',$roleAccess)){ ?>
                                  <li class="setng_subcription"><a href="<?php echo HTTP_ROOT.'users/transaction';?>" onclick="trackEventLeadTracker('Top Setting','Transactions Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Invoices');?></a></li>
                                  <?php } ?>   
                                  <li class="setng_subcription"><a href="<?php echo HTTP_ROOT.'users/subscription'; ?>" onclick="trackEventLeadTracker('Top Setting','Subscription Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" style="color:#f6911d;font-weight:400;"><?php echo __('Subscription');?></a></li>
                                </ul>
                              </li>
                              <?php } ?>
                              <li><a href="javascript:void(0)" class="grp_ttle togle_link">
                              <span class="cmn_cstm_set"><i class="material-icons">perm_identity</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span> <?php echo __('Personal Settings');?></a>
                                <ul class="grp_sub_item">                                 
                                  <li><a href="<?php echo HTTP_ROOT.'users/profile';?>" onclick="return trackEventLeadTracker('Top Setting','My Profile Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('My Profile');?></a></li>
                                  <li><a href="<?php echo HTTP_ROOT.'users/changepassword';?>" onclick="return trackEventLeadTracker('Top Setting','Change Password Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Change Password');?></a></li>
                                  <li><a href="<?php echo HTTP_ROOT.'users/email_notifications';?>" onclick="return trackEventLeadTracker('Top Setting','Notifications','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Notifications');?></a></li>
								  <li><a href="<?php echo HTTP_ROOT.'users/email_reports';?>" onclick="trackEventLeadTracker('Top Setting','Email Reports Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Email Reports');?></a></li>
								  
                                  <li><a href="<?php echo HTTP_ROOT.'users/default_view';?>" onclick="trackEventLeadTracker('Top Setting','Default View Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('My Default View');?></a></li>
                                     
                                            <li>
                                                <ul class="sub-menu hide_on_click">
                                                    <li class="not-hide-li">
                                                            <div>
                                                                    <i class="material-icons">&#xE0AF;</i>
                                                                    <p><?php echo __('Company Settings');?></p>
                                                            </div>
                                                    </li>
                            <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1) { ?>
                              <li><a href="javascript:void(0);" class="grp_ttle togle_link" id="tour_company_settings"><span class="cmn_cstm_set"><i class="material-icons">business</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span>  <?php echo __('Company Settings');?></a>
                                <ul class="grp_sub_item">
                                                <?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                    <li><a href="<?php echo HTTP_ROOT.'my-company';?>" onclick="trackEventLeadTracker('Top Setting','My Company Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('My Company');?></a></li>
                                                    <?php if(SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320 || ($this->Format->isChatOn(1))){?> 
                                                        <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);" ><?php echo __('Chat Settings');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <?php } ?>
                                                    <?php if($this->Format->isAllowed('View Resource Availability',$roleAccess)){ 
                                                    if($this->Format->isResourceAvailabilityOn('upgrade')){ ?>
                                                     <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Resource Settings');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <?php }else{ ?>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);" ><?php echo __('Resource Settings');?> <?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <?php } } ?>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);" ><?php echo __('Sprint Settings');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <?php
                                                        //if(SES_COMP == 28528 || stristr($_SERVER['SERVER_NAME'],"payzilla.in")){  
                                                        if($this->Format->isTimesheetOn(5)){ ?>
                                                                  <li>
                                                                 <a onclick="showUpgradPopup(1);" href="javascript:void(0);" ><?php echo __('Status Workflow Settings');?><?php echo $this->Format->getlockIcon(1); ?></a>
                                                            </li>
                                                            <?php }else{ ?>
                                                                <li>
                                                                   <a onclick="showUpgradPopup(1);" href="javascript:void(0);">
                                                                       <?php echo __('Status Workflow Settings');?> <?php echo $this->Format->getlockIcon(1); ?>
                                                                   </a>
                                                               </li>
                                                <?php } ?>
                                                        <?php //} ?>
                                                     <li>
                                                        <a onclick="showUpgradPopup(1);" href="javascript:void(0);">
                                                          <?php echo __('User Role Management');?><?php echo $this->Format->getlockIcon(1); ?>
                                                        </a>
                                                    </li>                                                   
                                                    <?php if($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
                                                        <li>
                                                        <a onclick="showUpgradPopup(1);" href="javascript:void(0);">
                                                                    <?php echo __('Project Template');?><?php echo $this->Format->getlockIcon(1); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php } ?>
                                                </ul>
                                            </li>
                              <li><a href="javascript:void(0);" class="grp_ttle togle_link" id="tour_project_settings"><span class="cmn_cstm_set"><i class="material-icons">work</i><i class="material-icons abs_set_icon">&#xE8B8;</i></span>  <?php echo __('Project Settings');?></a>
                                <ul class="grp_sub_item">
                                                <?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Daily Catch-Up');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <li><a href="<?php echo HTTP_ROOT.'import-export';?>" onclick="trackEventLeadTracker('Top Setting','Import-Export Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Import & Export');?></a></li>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Task Type');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Manage Labels');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                    <?php if($this->Format->isAllowed('View Invoice Setting',$roleAccess)){ ?>
                                                    <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Invoice Settings');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                        <?php } ?>
                                                            
                                  <?php } ?>
                                                    </ul>
                                            </li>
                              <?php } ?>
                              <li><a href="javascript:void(0)" class="grp_ttle togle_link"><span class="cmn_cstm_set"><i class="material-icons">games</i></span> <?php echo __('Integrations');?></a>
                                <ul class="grp_sub_item">
                                 <?php if(SES_TYPE == '1' || SES_TYPE == '2'){  ?>
                                  <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Slack Connect');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                        <?php } ?>
                                  <?php //if($this->Format->isTimesheetOn(4)){ ?>
                                          <li><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('Google Calendar');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                            <?php if(SES_TYPE == '1' || SES_TYPE == '2'){ ?>
                                                    <?php if(SES_COMP == 28528 || 1){ ?>
                                                    <?php if($this->Format->isGithubOn(SES_COMP)){ ?>
                                                        <li <?php if(PAGE_NAME == "gitconnect") { ?>class="active-list" <?php }?>><a onclick="showUpgradPopup(1);" href="javascript:void(0);"><?php echo __('GitHub');?><?php echo $this->Format->getlockIcon(1); ?></a></li>
                                                 <?php }else{ ?>
                                            <li>
                                                                 <a onclick="showUpgradPopup(1);trackEventLeadTracker('Quick Links','GitHub','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:void(0);" class="upgradeLink"> <?php echo __('GitHub');?> <?php echo $this->Format->getlockIcon(1); ?></a>
                                                            </li>
                                                <?php } ?>
                                            <?php } ?>
                                                            <?php } ?>
                                                    </ul>
                                            </li>
                                <li><a href="javascript:void(0)" class="grp_ttle togle_link"><span class="cmn_cstm_set"><i class="material-icons">info</i></span> <?php echo __('Orangescrum Info');?></a>
                                    <ul class="grp_sub_item">
                                                            <li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Top Setting','Getting Started Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');gettingStarted();"><?php echo __('Getting Started');?></a></li>
                                        <li><a href="<?php echo HTTP_ROOT;?>mobile-device"><?php echo __('Get free Mobile Apps');?></a></li> 
                                                            <li><a style="color:#f6911d;" href="<?php echo HTTP_ROOT.'updates';?>" target="_blank" onclick="return trackEventLeadTracker('Top Setting','Product Updates Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Product Updates');?></a></li>
                                    </ul>
                                </li>
                              
                              <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1) { /* ?>
                              <li><a href="javascript:void(0" class="grp_ttle togle_link"><span class="cmn_cstm_set"><i class="material-icons">group_work</i></span> <?php echo __('Resources');?></a>
                                <ul class="grp_sub_item">
                                                    
                                                    <?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
                                                    <li><a href="<?php echo HTTP_ROOT.'resource-utilization/';?>" onclick="trackEventLeadTracker('Top Setting','Resource Utilization Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Resource Utilization');?></a></li>
                                                <?php } ?>
                                                   <?php 
                                                   if($this->Format->isAllowed('View Resource Availability',$roleAccess)){ 
                                                   if($this->Format->isResourceAvailabilityOn('upgrade')){
                                                       if($this->Format->isResourceAvailabilityOn('status')){
                                                       ?>
                                                        <li><a href="<?php echo HTTP_ROOT.'resource-availability/';?>" onclick="trackEventLeadTracker('Top Setting','Resource Availability Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Resource Availability');?></a></li>
                                                       <?php } }else{?>
                                                        <li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Top Setting','Resource Availability Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');showUpgradPopup(0,1,1);" class="upgradeLink" ><?php echo __('Resource Availability');?> <img src="<?php echo HTTP_ROOT.'img/icon-upgrade.png'?>" style="width: 14px;float: right;margin-top: 2px;" tile="<?php echo __('Upgrade Now');?>" /></a></li>
                                                <?php } } ?>
                                                            </ul>
                                                    </li>
                                        <?php */} ?>
                              
                              
                                        
                                                            <?php if(TOT_COMPANY >= 2)  { ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT.'users/launchpad';?>" class="grp_ttle" onclick="return trackEventLeadTracker('Top Setting','Launchpad','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><span class="cmn_cstm_set"><i class="material-icons">flight_takeoff</i></span> <?php echo __('Launchpad');?></a></li>
                                                            <?php } ?>
                                                          <?php if((USER_TYPE == 1) || (IS_MODERATOR == 1)) { ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT.'osadmins';?>" style="color:#FABC6A" class="grp_ttle" target="_blank"><i class="material-icons">accessible</i> <?php echo __('Super Admin');?></a></li>
                                                        <?php } ?>
                              <li class="border_top"><a href="<?php echo HTTP_ROOT;?>users/logout" class="sign_out grp_ttle"><span class="cmn_cstm_set"><i class="material-icons">power_settings_new</i></span> <?php echo __('Log Out');?></a></li>
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
</script>
<script type="text/template" id="notification_tmpl">
<?php echo $this->element('top_notifications'); ?>
</script>