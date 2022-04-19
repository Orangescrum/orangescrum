<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 class="add_task_temp_name ellipsis-view" style="max-width: 85%;"><?php echo __('Subtask');?></h4>
        </div>
        <div class="modal-body popup-container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 col-xs-12 select2__wrapper">
					<div class="form-group label-floating">
						<input type="hidden" id="popup_prj_id_sub" value="" />
						<input type="hidden" id="popup_plnk_id_sub" value="" />
						<input type="hidden" id="popup_prj_un_id_sub" value="" />
						<input type="hidden" id="popup_caseuiid_sub" value="" />
						<input type="hidden" id="CS_sub_start_date" value="" />
						<input type="hidden" id="CS_sub_due_date" value="" />
						<span class="parent_tasl_label_pop"><?php echo __('Parent Task');?></span><br /> <br />
						<span id="parent_task_title"></span>
					</div>
				</div>
				<div class="col-lg-12 col-sm-12 col-xs-12 mtop30">
					<div class="select2__wrapper w_b task-field-2">
					<div class="custom-task-fld title-fld top-tsk-ttl ct-title">
						<div class="field_wrapper nofloat_wrapper">
							<!-- label class="control-label dtlpopup" for="CS_title"><?php echo __('Task Title');?></label -->
							<input class="<?php if(SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>" id="CS_title_pop" type="text" maxlength='240' />
							<div class="field_placeholder mark_mandatory"><span><?php echo __('Task Title');?></span></div>
						</div>
					</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="row mtop10">
				<div class="col-lg-6 col-sm-6 col-xs-6 w_a task-field-3 task-field-all custom-task-fld assign-to-fld labl-rt add_new_opt <?php if(!$this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>no-pointer<?php } ?> ">
							<div class="select_field_wrapper">
								<select class="subcrtskasgnusr form-control floating-label remove-dp" placeholder="<?php echo __('Assign To');?>">                                        
								</select>
							</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-xs-6 w_a task-field-4 task-field-all custom-task-fld task-type-fld labl-rt task_type cstm-drop-pad <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>no-pointer<?php } ?>">
					<div class="select_field_wrapper mark_mandatory">
						<select class="subtsktyp-select form-control floating-label" placeholder="<?php echo __('Task Type');?>" data-dynamic-opts=true onchange="changeTypeId(this)" id="inline-add-tsks">
							<?php
								foreach($GLOBALS['TYPE'] as $k=>$v){
									if($v['Type']['project_id'] ==0 || $v['Type']['project_id']==$getallproj[0]['Project']['id']){ 
									foreach($v as $key=>$value){
										foreach($value as $key1=>$result){
											if($key1=='name'&& $key1='short_name'){
												//$im = $value['short_name'].".png";
												if (trim($value['short_name']) && file_exists(WWW_ROOT."img/images/types/".$value['short_name'].".png")) {
													$im1= $this->Format->todo_typ_src($value['short_name'],$value['name']); ?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
												<?php } else {
												//$im1 = HTTP_IMAGES.'images/types/default.png';
													$cl_cs = 'taxt_typ_width';
													if(mb_detect_encoding($value['name'], mb_detect_order(), true) == 'UTF-8'){
															$cl_cs = 'taxt_typ_width_utf';
													} ?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
												<?php }

														 }
												  }
												}
											}
										}?>
						</select>
					</div>
					<div class="cmn_help_select"></div>
					<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/add-view-edit-task-type-task/<?= HELPDESK_URL_PARAM ?>#what_is_task_type');" title="<?php echo __('Get quick help on Task Type');?>" rel="tooltip" ><span class="help-icon"></span></a>
						
				</div>
			</div>
			<div class="row mtop20">
				<div  class="col-md-4 mtop15 <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>no-pointer<?php } ?>">
									<?php $dues_date = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date"); ?>
										
											<div class="field_wrapper nofloat_wrapper">
												<input type="text" id="sub_start_date" name="start_date" class="" placeholder="<?php echo date('M d, Y', strtotime($dues_date)); ?>" value=""  readonly="readonly" onchange="setStartDueDt();"/>
												<div class="field_placeholder"><span><?php echo __('Start Date');?></span></div>
												<div class="inp_icon"><a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#start_date');" title="<?php echo __('Date when task will start');?>" rel="tooltip" ><span class="help-icon"></span></a></div>
											</div>
				</div>
										
				<div class="col-md-4 mtop15">
					<div class="field_wrapper nofloat_wrapper">
						<input class="" id="sub_due_date" type="text" placeholder="<?php echo date('M d, Y', strtotime($dues_date)); ?>" readonly="readonly" onchange="setStartDueDt();" >
						<div class="field_placeholder"><span><?php echo __('Due Date');?></span></div>
						<div class="inp_icon"><a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#due_date');" title="<?php echo __('Date when task will be finished');?>" rel="tooltip" ><span class="help-icon"></span></a></div>	
					</div>
				</div>
				
				<div class="col-md-4 mtop15  <?php if(!$this->Format->isAllowed('Est Hours',$roleAccess)){ ?>no-pointer<?php } ?>">
					<div class="field_wrapper nofloat_wrapper" rel="tooltip" title="<?php echo __('You can enter time as 1.5  (that  mean 1 hour and 30 minutes)');?>.">
						<input type="text" onkeypress="return numeric_decimal_colon(event),mins_validation(this)" id="sub_estimated_hours" name="data[Easycase][estimated_hours]" maxlength="5" class="ttfont est check_minute_range" value="<?php if(isset($taskdetails['estimated_hours']) && $taskdetails['estimated_hours']){echo $taskdetails['estimated_hours'];}?>" placeholder="hh:mm" onchange="mins_validation(this);setSubStartDueDt();">
						<div class="field_placeholder"><span><?php echo __('Estimated Hours');?></span></div> 
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer ">
			<div class="fr popup-btn">
				<span id="addsubtaskder" class="addlnkder fr" style="display: none;"><img src="<?php echo HTTP_ROOT;?>img/images/case_loader2.gif" alt="loading..." title="loading..."> </span>
				<div id="addsubpop_btn">
					<span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
					<span class="fl hover-pop-btn"><a href="javascript:void(0)" id="savsubtask" onclick="saveSubPop();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></a></span>
					<div class="cb"></div>
				</div>
			</div>
		</div>
    </div>
</div>