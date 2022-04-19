<div class="help-container">
<div class="col-lg-12 help-srch">
    <div class="form-group label-floating">
        <label class="control-label" for="search_help">Enter question or keyword</label>
        <input class="form-control" id="search_help" type="text" maxlength='240' onkeyup='searchHelpContent(this);' />
    </div>
</div>
<ul id="subjects_list">
    <?php 
	$helpNewArr = array(
		'Time Sheet'=>'timesheet',
		'Tasks' =>'task-management',
		'Files' =>'task-management',
		'Tasks List' => 'task-management',
		'Task Type' => 'task-management',
		'Calendar View' =>'task-management',
		'Kanban View' =>'task-management',
		'Resource Utilization' =>'time-log',
		'Archive' =>'task-management',
		'Profile' =>'account-management',
		'Project Template' =>'projects',
		'Emails Notifications' =>'account-management',
		'Company Setting' =>'account-management',
		'Pricing & Billing' =>'account-management',
		'Delete Account' =>'account-management',
		'Cancel Account' =>'account-management'
	);
	if(!empty($allRelatedData)) {
        foreach ($allRelatedData as $key => $value) { ?>
        <li class="active">
                <?php $subject = preg_replace('/[\s]+/','-',preg_replace('/[&]+/','',strtolower($value['Help']['title'])));?>
                <a href="<?php echo KNOWLEDGEBASE_URL.$subject;?>" target="_blank" style="outline:none;"><?php echo $value['Help']['title']; ?></a>	
            </li>
    <?php }
    } else { 
        foreach ($allSubjectData as $key => $value) { ?>
            <li class="active">
            <?php 
			$subject = preg_replace('/[\s]+/','-',preg_replace('/[&]+/','',strtolower($value['Subject']['subject_name'])));
			if(isset($helpNewArr[$value['Subject']['subject_name']]) && !empty($helpNewArr[$value['Subject']['subject_name']])){
				$subject = $helpNewArr[$value['Subject']['subject_name']];
			}
			?>
            <a href="<?php echo KNOWLEDGEBASE_CATEGORY_URL.$subject;?>" target="_blank" style="outline:none;"><?php echo $value['Subject']['subject_name'];?></a>	
        </li>
        <?php }
    } ?>	
</ul>
</div>
<div class="help-customer-txt">
    <span class="or-txt">OR</span>
    <span><a class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info btn-live-chat" href="<?php echo CUSTOMER_SUPPORT_URL; ?>" target="_blank" onclick="trackEventLeadTracker('Footer Right','Live Chat','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Live Chat</a></span>
</div>
<div class="search-div"></div>