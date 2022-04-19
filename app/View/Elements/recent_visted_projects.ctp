<ul class="recent_visited_projects">
<?php
$PrjTypArr = Configure::read('PROJECT_TYPE');
if(count($GLOBALS['getallproj'])){
	if(count($GLOBALS['getallproj']) > 5){
		$allLastVistedProjs = array_slice($GLOBALS['getallproj'], 0, 5, true);
	}else{
		$allLastVistedProjs = $GLOBALS['getallproj'];
	}
	$page = PAGE_NAME;
	foreach ($allLastVistedProjs as $proj_LV) {
		if ($this->request->data['popupid'] != 'projpopup_log') {
			if ($page == 'chart' || $page == 'hours_report' || $page == 'glide_chart') {
				if ($page == 'chart') { ?>
					<li class="" title="<?php echo ucfirst($proj_LV['Project']['name']); ?>" rel="tooltip">
						<a href="javascript:jsVoid();" class="proj_lnks li_visited_projects ttc <?php if($proj_LV['Project']['uniq_id'] == $GLOBALS['getallproj'][0]['Project']['uniq_id']){ ?>active<?php } ?>" onclick="ReportMenu('<?php echo $proj_LV['Project']['uniq_id']; ?>');">
							<?php echo ucfirst($proj_LV['Project']['name']); ?>
						</a>
					</li>
				<?php } else if ($page == 'hours_report') { ?>
					<li class="" title="<?php echo ucfirst($proj_LV['Project']['name']); ?>" rel="tooltip">
						<a href="javascript:jsVoid();" class="proj_lnks li_visited_projects ttc <?php if($proj_LV['Project']['uniq_id'] == $GLOBALS['getallproj'][0]['Project']['uniq_id']){ ?>active<?php } ?>" onclick="hoursreport('<?php echo $proj_LV['Project']['uniq_id']; ?>');">
							<?php echo ucfirst($proj_LV['Project']['name']); ?>
						</a>
					</li>
				<?php } else if ($page == 'glide_chart') { ?>
					<li class="" title="<?php echo ucfirst($proj_LV['Project']['name']); ?>" rel="tooltip">
						<a href="javascript:jsVoid();" class="proj_lnks ttc li_visited_projects <?php if($proj_LV['Project']['uniq_id'] == $GLOBALS['getallproj'][0]['Project']['uniq_id']){ ?>active<?php } ?>" onclick="ReportGlideMenu('<?php echo $proj_LV['Project']['uniq_id']; ?>');">
							<?php echo ucfirst($proj_LV['Project']['name']); ?>
						</a>
					</li>
				<?php } ?>
			<?php } else { ?>					
				<li class="" title="<?php echo ucfirst($proj_LV['Project']['name']); ?>" rel="tooltip">
					<a href="javascript:jsVoid();" <?php if ($page == 'mydashboard') { ?>data-proj-name="<?php echo $proj_LV['Project']['name']; ?>" data-proj-id="<?php echo $proj_LV['Project']['uniq_id']; ?>"<?php } ?> class="ellipsis-view proj_lnks li_visited_projects ttc <?php if ($page == 'mydashboard') { ?>proj_link_for_invite<?php } ?><?php if($proj_LV['Project']['uniq_id'] == $GLOBALS['getallproj'][0]['Project']['uniq_id']){ ?>active<?php } ?>" onClick="<?php if ($page == 'activity') { ?>CaseActivity('<?php echo $proj_LV['Project']['id']; ?>', '<?php echo rawurlencode($proj_LV['Project']['name']); ?>'); <?php } elseif ($page == 'milestone') { ?>caseMilestone('<?php echo $proj_LV['Project']['id']; ?>', '<?php echo rawurlencode($proj_LV['Project']['name']); ?>', 1); <?php } else if( (CONTROLLER == "projects" && ($page == "manage")) || (CONTROLLER == "users" && ($page == "manage")) ){ ?>projectBodyClick('<?php echo $proj_LV['Project']['uniq_id']; ?>')<?php } else { ?>updateAllProj('proj_<?php echo $proj_LV['Project']['uniq_id']; ?>', '<?php echo $proj_LV['Project']['uniq_id']; ?>', '<?php echo $page; ?>', '0', '<?php echo rawurlencode($proj_LV['Project']['name']); ?>','',<?php echo rawurlencode($proj_LV['Project']['project_methodology_id']); ?>) <?php } ?>;">
					<span>
						<?php if($_SESSION['project_methodology'] == 'scrum' && CONTROLLER != 'projects'){ ?>
						<i class="material-icons">&#xE8F9;</i>
						<?php } ?>
						<?php echo ucfirst($proj_LV['Project']['name']); ?>
						<?php if($_SESSION['project_methodology'] == 'scrum'){ ?>
					</span>
					<span class="project_type_spn"><?php echo $PrjTypArr[$proj_LV['Project']['project_methodology_id']].' Project'; ?></span>
						<?php } ?>
					</a>
				</li>
			<?php }
		} else {
			?>
			<li class="" title="<?php echo ucfirst($proj_LV['Project']['name']); ?>" rel="tooltip">
				<a href="javascript:jsVoid();" <?php if ($page == 'mydashboard') { ?>data-proj-name="<?php echo $proj_LV['Project']['name']; ?>" data-proj-id="<?php echo $proj_LV['Project']['uniq_id']; ?>"<?php } ?> class="proj_lnks li_visited_projects ttc <?php if($proj_LV['Project']['uniq_id'] == $GLOBALS['getallproj'][0]['Project']['uniq_id']){ ?>active<?php } ?>" onClick="setProjectid('<?php echo $proj_LV['Project']['id']; ?>', '<?php echo rawurlencode($proj_LV['Project']['name']); ?>', '<?php echo $proj_LV['Project']['uniq_id']; ?>')">
					<?php echo ucfirst($proj_LV['Project']['name']); ?>
				</a>
			</li>
		<?php
		}
	}
}
?>
<li class="list_none" style="font-style: italic;">
	<a style="color:#2d6dc4;" href="<?php echo HTTP_ROOT . 'projects/manage' . $projecturl; ?>" onclick="return trackEventLeadTracker('Left Panel','Projects Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
		<?php echo __('View All Projects');?>
	</a>
</li>
<?php if ((CONTROLLER=='projects' && PAGE_NAME == 'manage') || ($page != 'timer' && $_SESSION['project_methodology'] != 'scrum')) { ?>        
	<!-- Add project option start -->
	<?php if ((SES_TYPE == 1 || SES_TYPE == 2) && $this->request->data['popupid'] != 'projpopup_log') { ?>
		<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
		<li class="list_none" title="<?php echo __('Create New Project');?>" rel="tooltip">
		<div id="newprj_but_last_visited">
			<a id="newproject_last_visited" class="proj_lnks col333" href="javascript:jsVoid();" onclick="setSessionStorage('Left Panel', 'Create Project'); newProject('newproject', 'loaderprj_last_visited');">+ <?php echo __('Create Project');?></a>
		</div>
		<a href="javascript:jsVoid()" id="loaderprj_last_visited" style="text-decoration:none;cursor:wait;display:none;">
			Loading...<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="loading..."/>
		</a>
		</li>
	<?php } ?>
	<?php } ?>
	<!-- Add project option end -->
<?php } ?>
</ul>