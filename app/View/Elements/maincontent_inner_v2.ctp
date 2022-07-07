<?php $page_array = array('glide_chart', 'hours_report', 'chart', 'weeklyusage_report','pending_task','completed_sprint_report','velocity_reports'); ?>
<style type="text/css">
	
	.new_back_icon {font-size: 14px;left: 10%;margin-top: 90px;position:fixed;top: 29%;z-index: 999;color:#A6A6A6;}
	.left-menu-panel .side-nav li .fixleft-submenu ul li:hover a{color:#F6911D}
	.new_back_icon:hover {color:#0091EA;}
	.left_panel_other_link {display:none;}
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
    <?php } else if(CONTROLLER == "projects" && (PAGE_NAME == "manage")){ /* ?>
      .big-sidebar .left_panel_other_link,.big-sidebar .recent_visited_projects{display:block;}
			.big-sidebar .left_panel_ntother_link,.big-sidebar .view_tasks_menu,.big-sidebar .caseMenuLeft,.big-sidebar .projectReportMenuLeft{display:none;}      
		<?php  */ } else if ((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports' || in_array(PAGE_NAME, $page_array))) {  ?>
		.big-sidebar .projectReportMenuLeft .left-palen-submenu-items{display:block;} 
    <?php  }else{ ?>
		.big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects,.big-sidebar .recent_visited_project_reports{display:none;}
		.big-sidebar .left_panel_ntother_link{display:block;}
	<?php } ?>
	<?php if ($_COOKIE['FIRST_INVITE_1']) {  ?>
		.big-sidebar .left_panel_other_link,.big-sidebar .view_tasks_menu,.big-sidebar .recent_visited_projects,.big-sidebar .recent_visited_project_reports{display:none;}
		.big-sidebar .left_panel_ntother_link{display:block;}
	<?php } ?>
	.template-menu{display:none;}
	.mini-sidebar .new_back_icon{display:none;}
	.mini-sidebar .plan-info-li{display:none;}
	<?php if(CONTROLLER == 'ganttchart' && PAGE_NAME == 'ganttv2'){ ?>
		body.open_hellobar .rht_content_cmn.task_lis_page .wrapper {padding-top:45px;}
	<?php } ?>
	
</style>
<?php $sub_text_class = $this->Format->getsubmenucolor($theme_settings['sidebar_color']); ?>
<div class="main-container">
	<div class="left-menu-panel<?php echo ' cmn_white_bg';?>" <?php if(PAGE_NAME == 'help_support'){ ?> style="display:none;"<?php } ?> > 
		<aside class="option_menu_panel">
			<?php
        $shw = 1;
        $priving_arr_fun = array("subscription", "transaction", "creditcard", "account_activity", "pricing", 'upgrade_member', 'account_usages', 'downgrade', 'edit_creditcard', 'confirmationPage','cancel_subscription_os');
        $priving_arr_fun = is_array($priving_arr_fun) ? $priving_arr_fun : array();
        if (in_array(PAGE_NAME, $priving_arr_fun)) {
					$shw = 0;
				}
        if (!in_array(PAGE_NAME, array("updates", "help", "tour", "customer_support")) && $shw) {
				?>
				<div class="fixed_left_nav">
					<div>
						<span class="dyn_btn_wrpr">
							<span class="all_create_btn" id="new_onboarding_add_icon">
								<a onclick="$('.show_new_add_div').toggle();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow'; ?>" id="btn-add-new-all" href="javascript:void(0)"><?php __('New');?><div class="ripple-container"></div></a>
							</span>
						</span>
						<div class="show_new_add_div new_add_dropdown" style="display: none;">
							<ul class="border-box">
								<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
									<li>
										<a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Project');newProject();">
											<i class="material-icons cmn-icon-prop">&#xE8F9;</i><?php echo __('Project'); ?>
										</a>
									</li>
								<?php } ?>
								<div class="gray-out-sub"></div>
								<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
									<li>
										<a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Task');creatask();">
											<i class="material-icons cmn-icon-prop">&#xE862;</i><?php echo __('Task'); ?>
										</a>
									</li>
								<?php } ?>
								<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
									<?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
										<li >
											<a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Time Log');createlog(0, '')">
												<i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry'); ?>
											</a>
										</li>
									<?php } ?>
								<?php } ?>
								<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
									<?php /*if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
										<li class="qadd-tg-icon hide-in-scrum" <?php if($_SESSION['project_methodology'] == 'scrum'){ echo "style='display:none;'";}?>>
											<a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Create Task Group');addEditMilestone('', '', '', '', '', '');">
												<i class="material-icons cmn-icon-prop">&#xE065;</i><?php echo __('Task Group'); ?>
											</a>
										</li>
									<?php */} ?>
								<?php //} ?>
								<?php if ($this->Format->isAllowed('Add New User',$roleAccess)) { ?>
									<?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
										<li>
											<a href="javascript:void(0)" onclick="setSessionStorage('Left Panel New Button', 'Invite User');newUser()">
												<i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('User'); ?>
											</a>
										</li>
									<?php } } ?>
							</ul>
						</div>
					</div>
					<ul class="side-nav sidebar-menu" id="side-menu-dynamic-cnt">
						<div class="gray-out"></div>
						<?php //if(!empty($checked_left_menu_submenu['checked_left_menu'])){ 
							$cstm_order = Cache::read('menuOrderlists'); ?>
							<?php echo $this->element('custom_left_menu_new',array('checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist,'sub_text_class'=>$sub_text_class,'exp_plan'=>$exp_plan,'cstm_order'=>$cstm_order[$_SESSION['project_template_view_id']]));?>
							<?php //}else{} ?>
					</ul>
					<?php } else if (in_array(PAGE_NAME, $priving_arr_fun) && SES_ID && SES_TYPE == 1) { ?>
					<div class="fixed_left_nav <?php if($this->Session->read('leftMenuSize') !=''){ echo 'hasScrollBar';}?>">
            <ul class="side-nav sidebar-menu">
							<?php if (PAGE_NAME == "upgrade_member" || PAGE_NAME == "downgrade") { ?>
								<li class="sidebar_parent_li plan-info-li">
									<div>
										<?php $all_PAID_plans = Configure::read('CURRENT_PAID_PLANS'); ?>
										<ul class="plan_info_ul">
											<?php
												$y__m_chk = 'F';
												$pln_month = Configure::read('CURRENT_MONTHLY_PLANS');
												$pln_yr = Configure::read('CURRENT_YEALY_PLANS');
												if (array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_month)) {
													$y__m_chk = 'monthly';
													} else if (array_key_exists($user_subscriptions['UserSubscription']['subscription_id'], $pln_yr)) {
													$y__m_chk = 'yearly';
												}
											?>
											<li title="<?php echo __('This is your current plan'); ?> <br />(<?php echo $user_subscriptions['UserSubscription']['user_limit']; ?> <?php echo __('Users'); ?> & <?php echo ($user_subscriptions['UserSubscription']['storage'] / 1024) . 'GB'; ?> Storage)" rel="tooltipi"><?php echo ($y__m_chk == 'F') ? __('Free') : $all_PAID_plans[$user_subscriptions['UserSubscription']['subscription_id']]; ?> <?php echo __('Plan'); ?> </li>
											<?php if ($y__m_chk != 'F') { ?>
												<li style="font-size:12px;color:#888;font-style: italic;"><?php echo __('billing'); ?> <?php echo $y__m_chk; ?></li>
											<?php } ?>
										</ul>
									</div>
								</li>
                <?php } else { ?>
								<li class="subscription_planbtn all_create_btn">
									<a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker('Upgrade Button Left Panel', 'Subscription Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" class="btn btn_cmn_efect cmn_bg btn-info cmn_size<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow';?>"><?php echo __('Upgrade Now'); ?></a>
								</li>
							<?php } ?>
							<li class="sidebar_parent_li <?php
                if (CONTROLLER == "users" && (PAGE_NAME == "subscription" || PAGE_NAME == "downgrade" || PAGE_NAME == "upgrade_member")) {
									echo 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow';
								}
                ?>">
								<a href="<?php echo HTTP_ROOT . 'users/subscription'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Subscription Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
									<i class="left-menu-icon material-icons">&#xE064;</i>
									<span class="mini-sidebar-label"><?php echo __('Overview'); ?></span>
								</a>
							</li>
							<li class="sidebar_parent_li <?php echo (CONTROLLER == "users" && (PAGE_NAME == "pricing")) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : ''; ?>">
								<a href="<?php echo HTTP_ROOT . 'pricing'; ?>" onclick="return trackEventLeadTracker(' Left Panel', 'Subscription Pricing', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
									<i class="left-menu-icon material-icons">&#xE86D;</i>
									<span class="mini-sidebar-label"><?php echo __('Plan'); ?></span>
								</a>
							</li>
							<li class="sidebar_parent_li <?php echo (CONTROLLER == "users" && (PAGE_NAME == "transaction")) ? 'active'.' '.$theme_settings['sidebar_color'].' gradient-shadow' : ''; ?>">
								<a href="<?php echo HTTP_ROOT . 'users/transaction'; ?>" onclick="return trackEventLeadTracker('Left Panel', 'Transactions Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
									<i class="left-menu-icon material-icons">&#xE915;</i>
									<span class="mini-sidebar-label"><?php echo __('Invoices'); ?></span>
								</a>
							</li>                
						</ul>
					</div>
				<?php } ?>
			</div>
		</aside>
	</div>
	<div class="<?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>rht_content_cmn<?php } else { ?>rht_content_cmn_help<?php } ?> task_lis_page">
		<?php echo $this->element('top_bar_v2'); ?>
		<?php if (PAGE_NAME != "updates" && PAGE_NAME != "help" && PAGE_NAME != "tour" && PAGE_NAME != "customer_support" && PAGE_NAME != 'onbording') { ?>
			<!-- breadcrumb -->  
			<input type="hidden" id="checkload" value="0">
		<?php } ?>
		<div class="wrapper">
			<?php //if (CONTROLLER == 'invoices' && PAGE_NAME == 'settings') { ?>
			<div id="beforeRenderPage">
				<div class="loadingdata">
					<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" style="width:60px;" alt="loading..." title="<?php echo __('loading');?>..."/>
				</div>
			</div>
			<?php //} ?>
			<?php echo $this->element('popup'); ?>
			<div class="slide_rht_con" <?php if (PAGE_NAME == 'updates') { ?>style="width: 100%;padding: 0px;"<?php } ?>>    
				<?php echo $this->fetch('content'); ?>
				<script>
					var elem = document.querySelector('#beforeRenderPage');elem.parentNode.removeChild(elem);
				</script>
			</div>
		</div>
		<script>
			<?php if ((CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) { ?>
				$('.big-sidebar').find('.template-menu').show();
				//$('.mini-sidebar').find('.template-menu-parent').addClass('active'); 
				<?php } else { ?>
				$('.template-menu').hide();
			<?php } ?>
			$(function () {
				$('[rel="tooltipi"]').tipsy({
					gravity: 'w',
					fade: true,
					html: true
				});
			});
		</script>
		<?php $fst_invite = 0; 
			if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13))){
				if (isset($_COOKIE['FIRST_INVITE_2'])) {
					$fst_invite = 1;
				}
				if($_SESSION['project_methodology'] == 'scrum'){
					$fst_invite = 0;
				}
				if (isset($_COOKIE['FIRST_INVITE_2_CNTR'])) {
					$fst_invite_phn = 1;
					if($_SESSION['project_methodology'] == 'scrum'){
						$fst_invite_phn = 2;
					}
					}else{
					$fst_invite_phn = 0;
				}
				if($_SESSION['project_methodology'] != 'scrum' && $_SESSION['project_methodology'] != 'simple'){
					$fst_invite = 0;
					$fst_invite_phn = 0;
				}
			?>
			<script type="text/javascript">
				var fst_invite = '<?php echo $fst_invite; ?>';
				var fst_invite_phn = '<?php echo $fst_invite_phn; ?>';
				if (fst_invite_phn != '0') {
						newOnboardingChk();
				}else if (fst_invite == '1') {
					newOnboardingChk();
				}
				$(function () {
					if (fst_invite_phn != '0') {
						//beforeOnboarding(fst_invite_phn); callback pop up
						//setTimeout(newOnboardingChk, 1000);
						newOnboardingChk();
						
						}else if (fst_invite == '1') {
						//setTimeout(startTour, 1000);
						//setTimeout(newOnboardingChk, 1000);
						newOnboardingChk();
					}
				});
				function startTour() {
					$('#startTourBtn').click();
					//localStorage.setItem("OSTOUR", 1);
				}
				function newOnboardingChk() {
					if(!localStorage.getItem("tour_type") && !localStorage.getItem("OSTOUR")){
						//localStorage.setItem("OSTOUR", 1);
						//newOnboarding();
						//$('#manage_your_work').trigger('click');
						//$('body').addClass('body_onboarding_tour');
						document.body.classList.add("body_onboarding_tour");
					}
				}
				function dispTour() {
					$('.sample_project_btn').trigger('click');
				}
				function closeSamplproj(){
					//startTour();
					newOnboarding();
				}
			</script>
		<?php } ?>
		<input type="hidden" value="<?php echo $fst_invite; ?>" id="fst_invite_chk" />
		<?php
			if (isset($_COOKIE['RAF_OTHERS'])) {
				unset($_SESSION['RAF_OTHERS']);
				setcookie('RAF_OTHERS', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);
				if (SES_TYPE == 1) {
				?>
				<script type="text/javascript">
					$(function () {
						referAFriend();
					});
				</script>
				<?php
				}
			}
		?>
		<script>
			$(document).ready(function(){
				expandLeftSubmenu();
			});
			function expandLeftSubmenu(){
				if($('body').hasClass('mini-sidebar') && !$('body').hasClass('hover_left_menu')){
					$(".left-palen-submenu").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-right');
					$(".left-palen-submenu-items").hide();
					}else{
					$(".left-palen-submenu-items").hide();
					if(getHash() =='timelog' || getHash() =='timesheet_weekly' ||  getHash() =='timesheet_daily' || PAGE_NAME=="resource_availability" ||  getHash() =='chart_timelog' ||  getHash() =='calendar_timelog'){
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
			}
		</script>
		<?php
			if (isset($_COOKIE['FIRST_INVITE_2']) && $_COOKIE['FIRST_INVITE_2']) {
				//echo $this->element('sample_project_modal');
			}
		?>		