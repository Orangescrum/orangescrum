<?php foreach ($menu_data as $key => $value) { ?>
	<?php $lowered_menu_name = strtolower($value['QuicklinkMenu']['name']);?>
	<?php if(!empty($value['UserQuicklink'])) {?>
	<?php if($hd_mnu_length == 1){
		$li_class = ' style="display:block"';
		$li_ul_style = ' style="width:100%"';
	}else{
		$li_class = $li_ul_style = '';
	} ?>
	<li class="quick_link_li hide_on_click"<?php echo $li_class;?>>
		<?php 
		$h_menu_icon = '';
		switch ($lowered_menu_name) {
			case 'new':
				$ul_class = '';
				$h_menu_icon = '<i class="material-icons quick-link-icons">new_releases</i>';
				break;
			 case 'analytics':
				$ul_class = ' class="inner_analytic_submenu"';
				$h_menu_icon = '<i class="material-icons quick-link-icons">&#xE922;</i>';
				break;
			 case 'others':
				$ul_class = '';
				$h_menu_icon = '<i class="material-icons quick-link-icons">&#xE53B;</i>';
				break;
			case 'company settings':
				$ul_class = ' class="inner_company_submenu"';
				$h_menu_icon = '<i class="material-icons quick-link-icons">&#xE8B8;</i>';
				break;
			case 'personal settings':
				$ul_class = ' class="inner_company_submenu"';
				$h_menu_icon = '<i class="material-icons quick-link-icons">&#xE8B8;</i>';
				break;
			default:
				$ul_class = '';
				break;
		} ?>
		<ul<?php echo $ul_class;?><?php echo $li_ul_style;?>> 
			<li class="not-hide-li">
			<a href="javascript:void(0)" class="type-of-hd hdings">
			<strong><?php echo $h_menu_icon;?><?php echo $value['QuicklinkMenu']['name'];?></strong></a>
			</li>
			<?php foreach ($value['QuicklinkSubmenu'] as $k => $v) { ?>
			<?php $lowered_name = $v['QuicklinkSubmenu'][0]['smenu_lowered'];?>
			<?php if($lowered_name == "project"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?> 
					<li>
						<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="setSessionStorage('Quick Links','Create Project');newProject();">
							<i class="material-icons cmn-icon-prop">&#xE8F9;</i><?php echo __('Project');?>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "user"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
					<?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?> 
						<li>
								<a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Invite User');newUser()">
								<i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('User');?>
							</a>
						</li>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "task"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						<?php if($this->Format->isAllowed('Create Task',$roleAccess)){
                           if(PAGE_NAME !='resource_availability'){
							?>
						<li>
							<a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Create Task');creatask();">
								<i class="material-icons cmn-icon-prop">&#xE862;</i><?php echo __('Task');?>
							</a>
						</li>
					<?php } }?>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "task group"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						 <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?> 
						<li class="qadd-tg-icon">
							<a href="javascript:void(0)" onclick="setSessionStorage('Quick Links','Create Task Group');addEditMilestone('','','','','','');">
								<i class="material-icons cmn-icon-prop">&#xE065;</i><?php echo __('Task Group');?>
							</a>
						</li>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "time entry"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						 <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
						 	<?php if($GLOBALS['Userlimitation']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
						<li>
							<a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" onclick="setSessionStorage('Quick Links','Time Log');createlog(0,'')">
								<i class="material-icons cmn-icon-prop">&#xE192;</i><?php echo __('Time Entry');?>
							</a>
						</li>
					<?php } ?>
					<?php } ?>
					<?php } ?>
				<?php } ?>				
				
				<?php if($lowered_name == "hours spent"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						<li class="all-list-glyph <?php if(CONTROLLER == "reports" && (PAGE_NAME == "hours_report")) { ?>active-list<?php } ?>"> 
								<a onclick="return trackEventLeadTracker('Quick Links','Hours Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."hours-report/";} ?>">
										<i class="material-icons hs-icon">&#xE192;</i>
										<?php echo __('Hours Spent');?> <?php echo $this->Format->getlockIcon(); ?>
								</a>
						</li>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "task reports"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						<li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "chart")) { ?>class="active-list" <?php }?>>
							<a onclick="return trackEventLeadTracker('Quick Links','Task Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."task-report/" ;} ?>">
									<i class="material-icons">&#xE862;</i>
									<?php echo __('Task Reports');?> <?php echo $this->Format->getlockIcon(); ?>
							</a>
					</li>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "weekly usage"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						<li class="<?php if(CONTROLLER == "reports" && (PAGE_NAME == "weeklyusage_report")) { ?>active-list<?php } ?>"> 
								<a onclick="return trackEventLeadTracker('Quick Links','Weekly Usage Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."reports/weeklyusage_report/";} ?>">
										<i class="material-icons">&#xE922;</i>
										<?php echo __('Weekly Usage');?> <?php echo $this->Format->getlockIcon(); ?>
								</a>
						</li>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "resource utilization"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						 <?php if($this->Format->isAllowed('View Resource Utilization',$roleAccess)){ ?>
						<li <?php if(CONTROLLER == "reports" && (PAGE_NAME == "resource_utilization")) { ?>class="active-list" <?php }?>>
							<a onclick="return trackEventLeadTracker('Quick Links','Resource Utilization Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT."resource-utilization/";} ?>">
									<i class="material-icons">&#xE335;</i>
									<?php echo __('Resource Utilization');?><?php echo $this->Format->getlockIcon(); ?>
							</a>
					</li>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				<?php if($lowered_name == "resource availability"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
						<?php if($this->Format->isResourceAvailabilityOn('upgrade')){
								   if($this->Format->isResourceAvailabilityOn('status')){
								   	if($this->Format->isAllowed('View Resource Availability',$roleAccess)){ 
								   ?>
						 <li <?php if(CONTROLLER == "LogTimes" && (PAGE_NAME == "resource_availability")) { ?>class="active-list" <?php }?>>
								<a onclick="return trackEventLeadTracker('Quick Links','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT."resource-availability/" ?>">
										<i class="material-icons">&#xE7FB;</i>
										<?php echo __('Resource Availability');?>
								</a>
						</li>
				   <?php }}}else{ ?>
					 <li>
						 <a onclick="showUpgradPopup(0,1,1);trackEventLeadTracker('Quick Links','Resource Availability Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="javascript:void(0);" class="upgradeLink"><i class="material-icons">&#xE7FB;</i><?php echo __('Resource Availability');?> <?php echo $this->Format->getlockIcon(1); ?></a>
					</li> 
				   <?php } ?>
				<?php } ?>
			<?php } ?>

			<?php if($lowered_name == "weekly timesheet"){?>					
			<?php } ?>
			<?php if($lowered_name == "daily timesheet"){?>					
			<?php } ?>
			<?php if($lowered_name == "archive"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li class="prevent_togl_li list-11 <?php if(CONTROLLER == "archives" && (PAGE_NAME == "listall")) { echo 'active'; } ?>">
						<a onclick="return trackEventLeadTracker('Quick Links','Archive Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT.'archives/listall#caselist';?>">
							<!--<span class="os_sprite arch-icon"></span>-->
							<i class="left-menu-icon material-icons">&#xE149;</i>
							<?php echo __('Archive');?>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "template"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<?php if($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
					<li class="prevent_togl_li list-12 <?php if(CONTROLLER == "templates") { echo 'active'; } ?>">
						<a onclick="return trackEventLeadTracker('Quick Links','Project Plan','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT. 'templates/projects';?>">
									<!--<span class="os_sprite temp-icon"></span>-->
									<i class="left-menu-icon material-icons">&#xE8F1;</i>
									<?php echo __('Project Plan');?>
						</a>
					</li>
					<li class="prevent_togl_li list-12 <?php if(CONTROLLER == "templates") { echo 'active'; } ?>">
						<a onclick="return trackEventLeadTracker('Quick Links','Project Template','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php echo HTTP_ROOT. 'project-templates';?>">
									<!--<span class="os_sprite temp-icon"></span>-->
									<i class="left-menu-icon material-icons">&#xE8F1;</i>
									<?php echo __('Project Template');?>
						</a>
					</li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "gantt chart"){?>
					<?php if(in_array($v['id'], $checked_ql)) {?>
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
							<a onclick="return trackEventLeadTracker('Quick Links','Gantt Chart','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'ganttchart/manage';} ?>">
									<!--<span class="os_sprite gct-icon"></span>-->
									<i class="left-menu-icon material-icons">&#xE919;</i>
									<?php echo __('Gantt Chart');?><span style="margin-left:-2px"><?php echo $this->Format->getlockIcon(); ?></span>
							</a>
						</li>
						<?php }  ?>
					<?php } ?>
					<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "activities"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li>
						<a class="" href="<?php echo HTTP_ROOT . 'dashboard#activities'; ?>" onclick="trackEventLeadTracker('Quick Links','Activities Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');checkHashLoad('activities');dashboadrview_ga('Activities');">
							<span title="<?php echo __('Activities');?>"><i class="material-icons">&#xE922;</i> <?php echo __('Activities');?></span>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "calendar"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					  <?php if($this->Format->isAllowed('View Calendar',$roleAccess)){ ?>
					<li>
						<a class="" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT . 'dashboard#calendar';} ?>" onclick="trackEventLeadTracker('Quick Links','Calendar Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>'); return calendarView('calendar');">
							<span title="<?php echo __('Calendar');?>"><i class="material-icons">&#xE916;</i> <?php echo __('Calendar');?></span><?php echo $this->Format->getlockIcon(); ?>
					</a>
					</li>
				<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "companies"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li>
						<a class="" href="<?php echo HTTP_ROOT . 'users/manage_company'; ?>">
							<span title="<?php echo __('Manage Company');?>"><i class="material-icons cmn-icon-prop">&#xE7FB;</i><?php echo __('Companies');?></span>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "my company"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'my-company';?>" onclick="trackEventLeadTracker('Quick Links','My Company Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0AF;</i> <?php echo __('My Company');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "import & export"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'import-export';?>" onclick="trackEventLeadTracker('Quick Links','Import-Export Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0C3;</i> <?php echo __('Import & Export');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "task type"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'task-type';} ?>" onclick="trackEventLeadTracker('Quick Links','Task Type Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE862;</i> <?php echo __('Task Type');?> <?php echo $this->Format->getlockIcon(); ?></a></li>
				<?php } ?>
			<?php } ?>		
			<?php if($lowered_name == "status workflow setting"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "chat setting"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<?php if(SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320){?> 
			             <li><a href="<?php echo HTTP_ROOT.'chat-settings';?>" onclick="trackEventLeadTracker('Quick Links','Chat Setting Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0B7;</i> <?php echo __('Chat Setting');?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "my profile"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'users/profile';?>" onclick="trackEventLeadTracker('Quick Links','My Profile Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons cmn-icon-prop">&#xE7FB;</i> <?php echo __('My Profile');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "change password"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'users/changepassword';?>" onclick="trackEventLeadTracker('Quick Links','Change Password Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">lock</i> <?php echo __('Change Password');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "notifications"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'users/email_notifications';?>" onclick="trackEventLeadTracker('Quick Links','Notifications Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">notification_important</i> <?php echo __('Notifications');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "email reports"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'users/email_reports';?>" onclick="trackEventLeadTracker('Quick Links','Email Reports Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">email</i> <?php echo __('Email Reports');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "launchpad"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<?php if(TOT_COMPANY >= 2) { ?>
						<li><a href="<?php echo HTTP_ROOT.'users/launchpad';?>" onclick="trackEventLeadTracker('Quick Links','Launchpad Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">launch</i> <?php echo __('Launchpad');?></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "default view"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'users/default_view';?>" onclick="trackEventLeadTracker('Quick Links','Default View Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">view_agenda</i> <?php echo __('Default View');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "getting started"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="javascript:void(0);" onclick="trackEventLeadTracker('Quick Links','Getting Started Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');gettingStarted();"><i class="material-icons">near_me</i> <?php echo __('Getting Started');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "product updates"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo HTTP_ROOT.'updates';?>" onclick="trackEventLeadTracker('Quick Links','Product Updates Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">system_update</i> <?php echo __('Product Updates');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php if($lowered_name == "help desk"){?>
				<?php if(in_array($v['id'], $checked_ql)) {?>
					<li><a href="<?php echo KNOWLEDGEBASE_URL; ?>" target="_blank" onclick="trackEventLeadTracker('Quick Links','Help Desk Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">live_help</i> <?php echo __('Help Desk');?></a></li>
				<?php } ?>
			<?php } ?>
			<?php  } ?>
		</ul>
	</li>
	<?php  } ?>
<?php } ?>