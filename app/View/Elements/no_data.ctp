<?php
$createTask = "";
if ($nodata_name == 'caselist') {
    $imageClass = 'icon-no-archive';
    $msgHead = __('No tasks have been archived yet.',true);
    //$msgDesc = 'All archived tasks of this project will appear here';
}else if($nodata_name == 'defectlist'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/No-defect-data-found.svg" /> 
		<div class="mtop30 mbtm20">
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" onclick="newDefect();">+ <?php echo __("New Bug"); ?></button>
		</div>
        <h3 class="m_0"><?php echo __("No bugs have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div class="mtop15"><?php echo __("All your project(s) bugs will appear here."); ?> </div>
		
           
    </div>
<?php }else if($nodata_name == 'defect_severity'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectSeverity();">+ <?php echo __("New Bug Severity"); ?></button>
		</div>
        <h3><?php echo __("No severities have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your severities will appear here."); ?> </div>
		
           
    </div>
<?php  } else if($nodata_name == 'defect_category'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectCategory();">+ <?php echo __("New Bug Category"); ?></button>
		</div>
        <h3><?php echo __("No categories have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your categories will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_issue_type'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectIssueType();">+ <?php echo __("New Issue type"); ?></button>
		</div>
        <h3><?php echo __("No Issue Types have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your issue types will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_activity_type'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectActivityType();">+ <?php echo __("New Activity Type"); ?></button>
		</div>
        <h3><?php echo __("No Activity Types have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your activity types will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_phase'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectPhase();">+ <?php echo __("New Bug Phase"); ?></button>
		</div>
        <h3><?php echo __("No phases have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your phases will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_root_cause'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectRootCause();">+ <?php echo __("New Root Cause"); ?></button>
		</div>
        <h3><?php echo __("No Root Cause have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your root causes will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_fix_version'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectFixVersion();">+ <?php echo __("New Fix Version"); ?></button>
		</div>
        <h3><?php echo __("No Fix Versions have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your fix versions will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_affect_version'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectAffectVersion();">+ <?php echo __("New Affect Version"); ?></button>
		</div>
        <h3><?php echo __("No Affect Versions have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your affect versions will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_origin'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectOrigin();">+ <?php echo __("New Bug Origin"); ?></button>
		</div>
        <h3><?php echo __("No origins have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your bug origins will appear here."); ?> </div>
		
           
    </div>
<?php } else if($nodata_name == 'defect_resolution'){ ?>
    <div class="no-data-box">		
        <img style="max-height: 100px;" src="img/tools/empty-bug-image.svg" /> 
        <br /><br /> 
		<div>
			<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" style="padding:3px 8px;margin-top:15px;" onclick="addNewDefectResolution();">+ <?php echo __("New Bug Resolution"); ?></button>
		</div>
        <h3><?php echo __("No resolutions have been added on this project."); ?></h3>
        <span class="tlog_nodt"><div style="margin: 10px;"><?php echo __("All your bug resolutions will appear here."); ?> </div>
		
           
    </div>
<?php  } else if ($nodata_name == 'filelist') {
    $imageClass = 'icon-no-archive';
    $msgHead = __('No files have been archived yet.',true);
    //$msgDesc = 'All archived files of this project will appear here';
} else if ($nodata_name == 'activity') {
    $imageClass = 'icon-no-activity';
    $msgHead = __('No task activities.',true);
    //$msgDesc = 'All activities of this project will appear here';
} else if ($nodata_name == 'files') {
    $imageClass = 'icon-no-files';
    $msgHead = __('No files have been shared or uploaded.',true);
    //$msgDesc = 'All files shared on this project will appear here';
} else if ($nodata_name == 'files-search') {
    $imageClass = 'icon-no-files';
    $msgHead = __('No files found',true);
    $msgDesc = '';
} else if ($nodata_name == 'milestonelist') {
    $imageClass = 'icon-no-milestone';
    //$msgHead = 'No milestone have been created on this project';
    //$msgDesc = 'All milestone created on this project will appear here';
	$msgHead = __('No task group.',true);
    $msgDesc = '';
}else if ($nodata_name == 'tasklist') {
	$imageClass = 'icon-no-task';
	if($case_type=='overdue'){
		$msgHead = __('No Overdue Task',true);
	}elseif($case_type=='highpriority'){
		$msgHead = __('No High Priority Task have been created',true);
	}elseif($case_type=='assigntome'){
		$msgHead = __('No Task for me',true);
	}elseif($case_type=='delegateto'){
		$msgHead = __('No Task delegeted',true);
	}elseif($case_type=='favourite'){
		$msgHead = __('No Task favourite',true);
	}elseif($case_type=='assigntomeproject'){
		$msgHead = __('You have not been assigned to a project. Please contact your admin to add you to a project.',true);
	}else{
		$msgHead = __('No Task has been created.',true);
		 if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){    
			$createTask = '<a onclick="creatask();" href="javascript:void(0);">Create</a> or <a href="'.HTTP_ROOT.'import-export" >Import</a> Task';
		}else{
			$createTask = '';
		}
	}
	//echo $msgHead; 
    //$msgDesc = 'All Task created on this project will appear here';
}else if ($nodata_name == 'inacttasklist') {
	$imageClass = 'icon-no-task';
	if($case_type=='overdue'){
		$msgHead = __('No Overdue Task',true);
	}elseif($case_type=='highpriority'){
		$msgHead = __('No High Priority Task have been created',true);
	}elseif($case_type=='assigntome'){
		$msgHead = __('No Task for me',true);
	}elseif($case_type=='delegateto'){
		$msgHead = __('No Task delegeted',true);
	}else{
		$msgHead = __('No Task has been created.',true);
}
    //$msgDesc = 'All Task created on this project will appear here';
}


//echo $case_type;exit;
?>
<div class="not-fonud ml_not_found">
	<div class="icon_con <?php echo $imageClass;?>"  <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    <?php if ($nodata_name == 'tasklist') { ?>onclick="creatask();"<?php } ?> <?php } ?>></div>
	<?php if($nodata_name == 'assigntomeproject'){ ?>
	<div class="no-data-box extra">		
		<div>
			<p class="head"><?php echo __('Getting Started');?></p>
			<p class="sub-head"><?php echo __('You have not been assigned to a project. Please contact your admin to add you to a project.');?></p>
		</div>
		<img style="max-height: 100px;" src="<?php echo HTTP_ROOT;?>img/no-data/notask.png" /> 
		<br /><br /> 
		 <?php if($this->Format->isAllowed('Create Project',$roleAccess) || SES_TYPE ==1){ ?>    
		<span class="m-left"><a class="btn btn_cmn_efect cmn_bg btn-info cmn_size" href="javascript:void(0)" onclick="newProject();"><?php echo __('Create Project');?><div class="ripple-container"></div></a> 

		</span>
	<?php }}else if($nodata_name != 'tasklist' && $nodata_name != 'caselist'){ ?>
	<h2><?php echo $msgHead; ?></h2>
	<div><?php echo $msgDesc; ?><?php echo $createTask; ?></div>
	<?php }else{ ?>
	<div class="no-data-box extra">		
		<div>
			<p class="head"><?php echo __('Getting Started');?></p>
			<p class="sub-head"><?php echo __('Create and Assign tasks to your team');?></p>
		</div>
		<img style="max-height: 100px;" src="<?php echo HTTP_ROOT;?>img/no-data/notask.png" /> 
		<br /><br /> 
		 <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
		<span class="m-left"><a class="btn btn_cmn_efect cmn_bg btn-info cmn_size" href="javascript:void(0)" onclick="creatask();"><?php echo __('Create New Task');?><div class="ripple-container"></div></a> 
			<span class="btn cmn_bg cmn_size mtop17 border-primary"><a href="<?php echo HTTP_ROOT.'import-export'?>"><?php echo __('Import');?> <?php echo __('Task');?></a></span>
		</span>
	<?php } ?>
	</div>
	<?php } ?>
<?php if ($nodata_name == 'milestonelist') {?>
	<div>
		<button class="btn btn_blue" value="Add" type="button" onclick="addEditMilestone(this);" style="margin:0;">
			<?php echo __('Create Task Group');?>
		</button>
	</div>
<?php }?>

</div>