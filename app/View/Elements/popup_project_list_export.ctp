<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Export Project Details');?></h4>
        </div>
        <div class="cb"></div>
        <div id="inner_project_list_export" class="mtop10">
           <div class="modal-body popup-container">
						<div class="row">
                        <span class="exprt-txt"><?php echo __('Below columns will be exported');?>.</span>
                <div class="col-lg-12">
					<input type="hidden" name="hid_export_type" id="hid_export_type_id" value="" />
                    <div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectName">
									<input id="exp_projectName" type="checkbox" value="project_name" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Name'); ?>
									</span>
							</label>
					</div>
          <div class="checkbox custom-checkbox pop-task-type-check">
						<label for="exp_projectShortName">
							<input id="exp_projectShortName" type="checkbox" value="project_shortname" class="project_exp_chkbx" checked="checked"/>
							<span class="oya-blk">
								 <?php echo __('Project Short Name'); ?>
							</span>
						</label>
					</div>
          <div class="checkbox custom-checkbox pop-task-type-check">
						<label for="exp_projectMethodo">
							<input id="exp_projectMethodo" type="checkbox" value="project_methodo" class="project_exp_chkbx" checked="checked"/>
							<span class="oya-blk">
								 <?php echo __('Project Template'); ?>
							</span>
						</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectDescription">
									<input id="exp_projectDescription" type="checkbox" value="project_description" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Description'); ?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectPriority">
									<input id="exp_projectPriority" type="checkbox" value="project_priority" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Priority');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
						<label for="exp_projectStatus">
							<input id="exp_projectStatus" type="checkbox" value="project_status" class="project_exp_chkbx" checked="checked"/>
							<span class="oya-blk">
								 <?php echo __('Project Status');?>
							</span>
						</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
						<label for="exp_projectWorkflow">
							<input id="exp_projectWorkflow" type="checkbox" value="project_workflow" class="project_exp_chkbx" checked="checked"/>
							<span class="oya-blk">
								 <?php echo __('Status Workflow');?>
							</span>
						</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectStart">
									<input id="exp_projectStart" type="checkbox" value="project_start" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Start Date');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectEnd">
									<input id="exp_projectEnd" type="checkbox" value="project_end" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project End Date');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectEstHr">
									<input id="exp_projectEstHr" type="checkbox" value="project_est" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Est. Hrs');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectHrSpent">
									<input id="exp_projectHrSpent" type="checkbox" value="project_spent_hr" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Spent Hrs');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectNumTasks">
									<input id="exp_projectNumTasks" type="checkbox" value="project_num_tasks" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Number of Tasks');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectLastActivity">
									<input id="exp_projectLastActivity" type="checkbox" value="project_last_activity" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Last Activity ');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_projectLastActivity">
									<input id="exp_project_type" type="checkbox" value="project_project_type" class="project_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project Type');?>
									</span>
							</label>
					</div>
				<div class="cb"></div>
                </div>
			</div>
            </div>
            <div class="modal-footer">
                <div class="fr popup-btn act_btttn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="projectlistexport();"><?php echo __('Submit');?></a></span>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
</div>