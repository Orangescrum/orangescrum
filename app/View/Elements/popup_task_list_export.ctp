<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Export Tasks to csv file');?></h4>
        </div>
        <div class="cb"></div>
        <div id="inner_task_list_export" class="mtop10">
           <div class="modal-body popup-container">
						<div class="row">
                        <span class="exprt-txt"><?php echo __('Below columns will be exported');?>.</span>
                <div class="col-lg-12 mbtm15 export-fields">
                    <div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseNo">
									<input id="exp_caseNo" type="checkbox" value="case_no" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Task');?>#
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseTitle">
									<input id="exp_caseTitle" type="checkbox" value="case_title" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Task Title');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseDescription">
									<input id="exp_caseDescription" type="checkbox" value="case_description" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Description');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_tskgrp">
									<input id="exp_tskgrp" type="checkbox" value="task_group" class="tsk_exp_chkbx" <?php if($_COOKIE['TASKGROUPBY'] == 'milestone'){ ?>checked="checked" <?php } ?>/>
									<span class="oya-blk">
										 <?php echo __('Sprint/Task Group');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_prjnm">
									<input id="exp_prjnm" type="checkbox" value="project_name" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Project name');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseType">
									<input id="exp_caseType" type="checkbox" value="case_type" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Task Type');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_estHour">
									<input id="exp_estHour" type="checkbox" value="estimated_hour" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Estimated Hour');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_spentHour">
									<input id="exp_spentHour" type="checkbox" value="spent_hour" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Spent Hour');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_assignTo">
									<input id="exp_assignTo" type="checkbox" value="assigned_to" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Assigned to');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_casePriority">
									<input id="exp_casePriority" type="checkbox" value="case_priority" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Priority');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseCreatedDt">
									<input id="exp_caseCreatedDt" type="checkbox" value="created_date" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Created Date');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseCreatedBy">
									<input id="exp_caseCreatedBy" type="checkbox" value="created_by" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Created By');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseUpdatedDt">
									<input id="exp_caseUpdatedDt" type="checkbox" value="updated_date" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Updated Date');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseStatus">
									<input id="exp_caseStatus" type="checkbox" value="case_status" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Status');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_caseDue">
									<input id="exp_caseDue" type="checkbox" value="due_date" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Due Date');?>
									</span>
							</label>
					</div>
										<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_startDate">
									<input id="exp_startDate" type="checkbox" value="gantt_start_date" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Start Date');?>
									</span>
							</label>
					</div>
					<div class="checkbox custom-checkbox pop-task-type-check">
							<label for="exp_comment">
									<input id="exp_comment" type="checkbox" value="comment" class="tsk_exp_chkbx" checked="checked"/>
									<span class="oya-blk">
										 <?php echo __('Comments');?>
									</span>
							</label>
					</div>
				<div class="cb"></div>
        </div>
			<span class="exprt-txt"><?php echo __('Please select date format');?>.</span>
			    <div class="col-lg-12">
				
					 <div class="checkbox custom-checkbox pop-task-type-check">
								<label for="">
									<input  name="dt_format" id="exp_dt1" type="radio" value="Y/m/d" class="tsk_exp_rdo" />
									<span class="oya-blk">
										 <?php echo __('YYYY/MM/DD');?>
									</span>
							</label>
							
								<label for="">
									<input  name="dt_format" id="exp_dt2" type="radio" value="y/m/d" class="tsk_exp_rdo" />
									<span class="oya-blk">
										 <?php echo __('YY/MM/DD');?>
									</span>
							</label>
							
							
					</div>
					
				 <div class="checkbox custom-checkbox pop-task-type-check">
						<label for="oya-blk">
									<input name="dt_format" id="exp_dt3" type="radio"  value="d/m/Y" class="tsk_exp_rdo" checked />
									<span class="oya-blk">
										 <?php echo __('DD/MM/YYYY');?>
									</span>
							</label>
							
							<label for="oya-blk">
									<input name="dt_format" id="exp_dt4" type="radio"  value="d/m/y" class="tsk_exp_rdo" checked />
									<span class="oya-blk">
										 <?php echo __('DD/MM/YY');?>
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
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="tasklistexport();"><?php echo __('Submit');?></a></span>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(function () {
		isAllowedAdvancedCustomFields();
	});
	</script>