<style>
#txt_shortProjEdit {
	text-transform:uppercase;
}
.more_less_project_opts {display:block;}
</style>
<?php echo $this->Form->create('Project', array('url' => '/projects/settings', 'name' => 'projsettings', 'enctype' => 'multipart/form-data')); ?>

    <center><div id="edit_prj_err_msg" class="err_msg"></div></center>
<div class="modal-body popup-container flex_scroll">  
    <input type="hidden" name="data[Project][validateprj]" id="validateprj" readonly="true" value="0"/>
    <input type="hidden" name="data[Project][pg]" id="pg" readonly="true" value="0"/>
    <input type="hidden" value="<?php echo $uniqid; ?>" name="data[Project][uniq]" id="uniqid"/>
    <input type="hidden" value="<?php echo $projArr['Project']['id'] ?>" name="data[Project][id]"/>
	<input type="hidden" name="data[Project][click_referer_update]" id="upd_project_click_refer" readonly="true" value="" />

	<div class="row ">
		<div class="col-lg-12 padlft-non padrht-non">
			<div class="col-lg-5 col-sm-5">
    <div class="form-group label-floating mark_mandatory">
        <label class="control-label" for="txt_proj"><span><?php echo __('Specify your project name');?></span></label>
        <?php echo $this->Form->text('name', array('value' => html_entity_decode($projArr['Project']['name'], ENT_QUOTES), 'class' => 'form-control input-lg', 'id' => 'txt_proj', 'placeholder' => "", 'maxlength' => '50')); ?>
    </div>
			</div>
               <div class="col-lg-4 col-sm-5 col-xs-2">
                <div class="form-group label-floating mark_mandatory">
                    <label class="control-label" for="txt_shortProjEdit"><span><?php echo __('Short name for your project');?></span></label>
                    <?php
                    $short_name = html_entity_decode($projArr['Project']['short_name']);
                    if (strtoupper($short_name) == 'WCOS') {
                        echo $this->Form->text('short_name', array('value' => stripslashes($short_name), 'class' => 'form-control input-lg', 'id' => 'txt_shortProjEdit', 'maxlength' => '5', 'readonly' => 'readonly'));
                    } else {
                        echo $this->Form->text('short_name', array('value' => stripslashes($short_name), 'class' => 'form-control input-lg', 'id' => 'txt_shortProjEdit', 'maxlength' => '5'));
                    }
                    ?>
                    <span id="ajxShort" style="display:none; position: absolute; top:30px; right:0px;">
                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16"/>
                    </span>
                    <span id="ajxShortPage"></span>
                </div>
            </div>
			<div class="col-lg-3 col-sm-2">
				<div class="select2__wrapper mark_mandatory" id="priority_dropdown">
					<select name="data[Project][priority]" class="form-control floating-label proj_prioty" placeholder="<?php echo __('Choose Priority');?>" data-dynamic-opts=true>
						<option value='2' <?php if($projArr['Project']['priority']==2){ ?>selected <?php } ?>><?php echo __('Low');?></option>
						<option value='1' <?php if($projArr['Project']['priority']==1){ ?>selected <?php } ?>><?php echo __('Medium');?></option>
						<option value='0' <?php if($projArr['Project']['priority']==0){ ?>selected <?php } ?>><?php echo __('High');?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
   <?php /* <div class="form-group label-floating">
        <label class="control-label" for="txt_proj">Specify your project name</label>
        <?php echo $this->Form->text('name', array('value' => html_entity_decode($projArr['Project']['name'], ENT_QUOTES), 'class' => 'form-control input-lg', 'id' => 'txt_proj', 'placeholder' => "", 'maxlength' => '50')); ?>
    </div> */ ?>
    <div class="row">
        <div class="col-lg-12 padlft-non padrht-non">
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <div class="mtp-15 select2__wrapper" id="sel_Typ">
                    <select class="sel_Typ_dp form-control floating-label" name="data[Project][default_assign]" id="sel_Typ1" placeholder="<?php echo __('Default Assign To');?>:" data-dynamic-opts=true>
                        <option value="0" selected="selected"><?php echo __('Select User');?></option>
                        <?php foreach ($quickMem as $asgnMem) { ?>
                        <?php
                            $selected = "";
                            if ((isset($defaultAssign) && $defaultAssign) && ($asgnMem['User']['id'] == $defaultAssign)) {
                                $selected = "selected='selected'";
                            } else if (!$defaultAssign && ($asgnMem['User']['id'] == SES_ID)) {
                                //$selected = "selected='selected'";
                            }?>
                            <option value="<?php echo $asgnMem['User']['id']; ?>" <?php echo $selected; ?>>
                                <?php echo (($asgnMem['User']['id'] == SES_ID)) ? 'me' : $this->Format->formatText($asgnMem['User']['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <div class="mtp-15 select2__wrapper" id="sel_workflow">
                    <select class="workflow_dp form-control floating-label" name="data[Project][status_group_id]" id="sel_wflow" placeholder="<?php echo __('Select workflow');?>:" data-dynamic-opts=true <?php if($tcnt >=1){ echo 'disabled="disabled"';}?>>
                        <?php /* <option value="0" selected="selected"><?php echo __('Default Status Workflow');?></option> */ ?>
                        <?php foreach ($wf_list as $wf_key=>$wf_val) { ?>
                        <?php 
                            $selected = "";
                            if (!empty($status_group_id) && $status_group_id==$wf_key) {
                                $selected = "selected='selected'";
                            } ?>
                            <option value="<?php echo $wf_key; ?>" <?php echo $selected; ?>><?php echo $wf_val; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
		<div class="cb"></div>
        </div>
    </div>
	 <div class="row mtp-20">
		<div class="col-lg-12 padlft-non padrht-non">
			<div class="col-lg-4 col-sm-4 col-xs-4">
                <div class="mtp-15 select2__wrapper" id="sel_TaskTyp">
                    <select class="tsk_Typ_dp form-control floating-label" name="data[Project][task_type]" id="sel_TaskTyp" placeholder="<?php echo __('Default Task Type');?>:" data-dynamic-opts=true>
                        <option value="0" selected="selected"><?php echo __('Select Task Type');?></option>
                        <?php foreach ($task_list as $task_key=>$task_val) { ?>
                        <?php 
                            $selected = "";
                            if (!empty($task_type) && $task_type==$task_key) {
                                $selected = "selected='selected'";
                            } ?>
                            <option value="<?php echo $task_key; ?>" <?php echo $selected; ?>><?php echo $task_val; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
			<div class="col-lg-8 col-sm-12">
				<div class="form-group label-floating cmn-fg0 select2__wrapper">
					<label class="control-label" for="prj_desc"><?php echo __('Describe your project');?></label>
					<textarea id="prj_desc"  class="form-control input-lg expand hideoverflow" rows="1" wrap="virtual" name="data[Project][description]"><?php echo html_entity_decode(stripslashes($projArr['Project']['description'])); ?></textarea>
				</div>
			</div>
			<?php /* 
			<div class="col-lg-4 col-sm-4">
				<div class="select2__wrapper" id="proj_methodology">
					<select name="data[Project][project_methodology_id]" class="form-control floating-label proj_methodology" placeholder="<?php echo __('Project Methodology');?>" data-dynamic-opts=true>
						<option value='1' <?php if($projArr['Project']['project_methodology_id']==1){ ?>selected <?php } ?>><?php echo __('Simple Project');?></option>
						<option value='2' <?php if($projArr['Project']['project_methodology_id']==2){ ?>selected <?php } ?>><?php echo __('Scrum');?></option>
					</select>
				</div>
			</div> */ ?>
		</div>
	</div>    
    <div class="form-group label-floating">
        <label class="control-label"><?php echo __('Created by');?></label>
        <?php
        $locDT = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $projArr['Project']['dt_created'], "datetime");
        $gmdate = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATE, "date");
        $dateTime = $this->Datetime->dateFormatOutputdateTime_day($locDT, $gmdate, 'time');
        ?>
        <div class="form-control input-lg" style="background: #eee;padding: 8px 4px;"><?php echo $this->Format->formatText($uname); ?>, <?php echo $dateTime; ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 more-opt">
            <div class="col-lg-4 col-sm-4 col-xs-4 padlft-non" id="EditProjEsthr" style="">
                <div class="form-group mrg0">
                    <label class="control-label" for="txt_ProjEsthr"><?php echo __('Estimated Hours');?></label>
                    <?php /*<span class="os_sprite est-hrs-icon"></span> */ ?>
                    <?php echo $this->Form->text('estimated_hours', array('value' => stripslashes($projArr['Project']['estimated_hours']), 'class' => 'form-control', 'id' => 'txt_ProjEsthr', 'placeholder' => 'hh', 'maxlength' => '6', 'onkeypress' => 'return numericDecimalProj(event)')); ?>
                    <p class="help-block" style="margin-top: -5px;">(8 <?php echo __('hours');?> = 1 <?php echo __('Day');?>)</p>
                </div>
            </div>
            <div class="col-lg-1 col-sm-1 col-xs-1"></div>
            <?php
            if (!empty($projArr['Project']['start_date'])) {
                $projArr['Project']['start_date'] = date('M j, Y', strtotime($projArr['Project']['start_date']));
            }
            if (!empty($projArr['Project']['end_date'])) {
                $projArr['Project']['end_date'] = date('M j, Y', strtotime($projArr['Project']['end_date']));
            }
            ?>
            <div class="col-lg-7 col-sm-7 col-xs-7 padlft-non padrht-non time_range_fld" id="ProjStartDate" style="">
                <div class="row input-daterange">
                    <div class="col-lg-6 col-sm-6 col-xs-6 padlft-non">
                        <div class="form-group mrg0">
                            <label class="control-label" for="edit_ProjStartDate"><?php echo __('Date Range');?></label>
                            <?php echo $this->Form->text('start_date', array('value' => $projArr['Project']['start_date'], 'class' => 'datepicker form-control', 'id' => 'edit_ProjStartDate','placeholder' => __('Start Date',true), 'readonly' => 'true')); ?>
                        </div>
                    </div>
                    <div class="from_to">to</div>
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <div class="form-group mrg0">
                            <label class="control-label blank-label" for="edit_ProjEndDate">xxx</label>
                            <?php echo $this->Form->text('end_date', array('value' => $projArr['Project']['end_date'], 'class' => 'datepicker form-control', 'id' => 'edit_ProjEndDate', 'placeholder' => __('End Date',true), 'readonly' => 'true')); ?>
                        </div>
                    </div>
                </div>
            </div>
						<div class="cb"></div>
        </div>
    </div>
		
		<div class="row " style="margin-top:6px;">
				<div class="col-lg-12 padlft-non padrht-non">
								
				</div>
			</div>			
			<div class="row ">
				<div class="col-lg-12 more-opt">
					<p class="blue-txt" style="margin-bottom: -4px;margin-top: 19px;"><a href="javascript:void(0);" class="" id="more_proj_options_edt"><?php echo __('Hide options');?></a></p>
				</div>
			</div>		
			
			<div class="row more_less_project_opts">
				<div class="col-lg-12 padlft-non padrht-non">
					<div class="col-lg-4 col-sm-4">
						<div class="select2__wrapper" id="">
							<select name="data[Project][status]" class="form-control floating-label proj_status" placeholder="<?php echo __('Project Status');?>" data-dynamic-opts=true>
								<?php foreach ($All_status as $sts_key=>$sts_val) { ?>
								<?php 
									$selected = "";
									if (!empty($sts_key) && $projArr['Project']['status']==$sts_key) {
											$selected = "selected='selected'";
									} ?>
									<option value="<?php echo $sts_key; ?>" <?php echo $selected; ?>><?php echo $sts_val; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php /* project type */ ?>					
				</div>
			</div>
		
    <?php /*<div class="form-group mrg0 select2__wrapper">
        <label class="control-label" for="prj_sts"><?php echo __('Status');?></label>
        <select name="data[Project][status]" id="prj_sts"  class="form-control status_typ_dp">
            <option value="1" <?php if ($projArr['Project']['status'] == 1) { ?>selected="selected"<?php } ?>><?php echo __('Started');?></option>
            <option value="2" <?php if ($projArr['Project']['status'] == 2) { ?>selected="selected"<?php } ?>><?php echo __('On Hold');?></option>
            <option value="3" <?php if ($projArr['Project']['status'] == 3) { ?>selected="selected"<?php } ?>><?php echo __('Stack');?></option>
            <option value="4" <?php if ($projArr['Project']['status'] == 4) { ?>selected="selected"<?php } ?>><?php echo __('Completed');?></option>
        </select>
    </div>
		*/ ?>
</div>
<div class="modal-footer popup_sticly_cta">
        <div class="fr popup-btn">
            <span id="settingldr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader" /></span>
            <span id="btn" class="project_edit_button">
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="btn_edit_project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick= "return submitProject('txt_proj', 'txt_shortProjEdit', 'txt_ProjEsthr', 'edit_ProjStartDate', 'edit_ProjEndDate')" id="savebtn"><?php echo __('Update');?></a></span>
            </span>
        </div>
    </div>
<?php $this->Form->end(); ?>

<script>
$(function() {
    $("#edit_ProjStartDate").datepicker({format: 'M d, yyyy',changeMonth: false,changeYear: false,hideIfNoPrevNext: true,autoclose: true
 	}).on('changeDate', function(e) {    	
    	$("#edit_ProjEndDate").datepicker("setStartDate", $("#edit_ProjStartDate").datepicker('getFormattedDate'));
	});

    $("#edit_ProjEndDate").datepicker({format: 'M d, yyyy',changeMonth: false,changeYear: false,hideIfNoPrevNext: true,autoclose: true
    }).on('changeDate', function(e) {    	
    	$("#edit_ProjStartDate").datepicker("setEndDate", $("#edit_ProjEndDate").datepicker('getFormattedDate'));
	});
    $('#txt_proj').blur(function (e) {
        var str = $(this).val();
        //makeShortName(str);
    }).keyup(function (e) {
        var str = $(this).val();
        var str_temp = '';
        if (e.keyCode == 32 || e.keyCode == 8 || e.keyCode == 46) {
            //makeShortName(str, 0);
        }
    });
    $('#txt_proj,#txt_shortProjEdit')
            .change(function(){
                $(this).val().trim()!=''?$("#btn_edit_project").removeClass('loginactive'):$("#btn_edit_project").addClass('loginactive');
                $('#edit_prj_err_msg').html('');
            });
    $('#edit_prj_err_msg').html('');
    // $(".input-daterange").datepicker({format: 'M d, yyyy',hideIfNoPrevNext: true,todayBtn: "linked",todayHighlight: true,autoclose: true,clearBtn: true});
    $.material.init();
    $('.proj_prioty,.workflow_dp,.sel_Typ_dp').select2();
    $('.tsk_Typ_dp').select2({
        templateSelection: formatTaskType,
        templateResult: formatTaskType
    });

		$('#more_proj_options_edt').click(function() {
        $('#more_proj_options_edt').html(($('.more_less_project_opts').is(":visible") ? _("More options") : _("Hide options")));
        $('.more_less_project_opts').slideToggle('slow');
    });
		
		$('.proj_manager').select2();
		$('.proj_client').select2();
		$('.proj_industry').select2();
		$('.proj_currency').select2();
		
		if (SES_TYPE == 3) {
				$(".proj_type").select2();
		} else {
				$(".proj_type").select2({
						tags: true,
						//templateSelection: formatTaskType,
						//templateResult: formatTaskType,
						createTag: function(params) {
								var term = $.trim(params.term);
								if (term === '') {
										return null;
								}
								if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
										var msg = _("'Project Type' must not contain special characters!");
										showTopErrSucc('error', msg);
										return null;
								}
								return {
										id: term,
										text: term,
										newTag: true
								}
						}
				}).off('select2:select').on('select2:select', function(evt) {
						if (evt.params.data.newTag == true) {
								var name = evt.params.data.id;
								$('#caseLoader').show();
								$.post(HTTP_ROOT + 'projects/ajax_addProjectType', {
										'name': evt.params.data.id
								}, function(res) {
										$('#caseLoader').hide();
										if (res.status == 'error' && res.msg == 'name') {
												showTopErrSucc('error', _('Project Type already esists!. Please enter another name.'));
												$('.proj_type option[value="' + name + '"]').remove();
												$('.proj_type').trigger('change');
										} else if (res.status == 'success') {
												if (res.msg == 'saved') {
														showTopErrSucc('success', _('Project Type Successfully Added'));
														$(".proj_type").append("<option value='" + res.id + "' selected>" + name + "</option>");
														$('.proj_type option[value="' + res.id + '"]').prop('selected', true);
														$('.proj_type').trigger('change');
												} else {
														showTopErrSucc('error', _('Project Type can not be added'));
														$('.proj_type').trigger('change');
												}
										}
								}, 'json');
						}
				});
		}
		
		if (SES_TYPE == 3) {
			$(".proj_status").select2();
	} else {
		$(".proj_status").select2({
				tags: true,
				//templateSelection: formatTaskType,
				//templateResult: formatTaskType,
				createTag: function(params) {
						var term = $.trim(params.term);
						if (term === '') {
								return null;
						}
						if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
								var msg = _("'Project Status' must not contain special characters!");
								showTopErrSucc('error', msg);
								return null;
						}
						return {
								id: term,
								text: term,
								newTag: true
						}
				}
		}).off('select2:select').on('select2:select', function(evt) {
				if (evt.params.data.newTag == true) {
						var name = evt.params.data.id;
						$('#caseLoader').show();
						$.post(HTTP_ROOT + 'projects/ajax_addProjectStatus', {
								'name': evt.params.data.id
						}, function(res) {
								$('#caseLoader').hide();
								if (res.status == 'error' && res.msg == 'name') {
										showTopErrSucc('error', _('Project Status already esists!. Please enter another name.'));
										$('.proj_status option[value="' + name + '"]').remove();
										$('.proj_status').trigger('change');
								} else if (res.status == 'success') {
										if (res.msg == 'saved') {
												showTopErrSucc('success', _('Project Status Successfully Added'));
												$(".proj_status").append("<option value='" + res.id + "' selected>" + name + "</option>");
												$('.proj_status option[value="' + res.id + '"]').prop('selected', true);
												$('.proj_status').trigger('change');
										} else {
												showTopErrSucc('error', _('Project Status can not be added'));
												$('.proj_status').trigger('change');
										}
								}
						}, 'json');
				}
			});
		}
});
	function changeProjectClient(obj, id){
		var clnt_val = 	$.trim($('#proj_client'+id).val());
		var cust_val = 	$.trim($('#proj_client'+id+' option:selected').attr('data-cust'));
		var in_val = $(obj).val();
		if(clnt_val != 'undefined' && clnt_val != '' && clnt_val !== '0'){
			if(cust_val != in_val){
				$('#proj_currency'+id).val(cust_val); //0
				$('#proj_currency'+id).trigger('change');
				showTopErrSucc('error', _('Currency cannot be updated for a client. Please update currency for a client in manage customer section.'));
			}
		}
	}
function changeProjectCurrency(obj, id){
		var in_val = $(obj).val();
		if(in_val == '0'){
				$('#proj_currency'+id).val(144); //0
				$('#proj_currency'+id).trigger('change');
				if($('#add_instant_customer'+id).is(':visible')){
					addCancelCustomer(id);
				}
		}else{
			var v_t = $('.proj_client option:selected').attr('data-cust');
			if(v_t != 'new'){
				$('#proj_currency'+id).val(v_t);
				$('#proj_currency'+id).trigger('change');
				if($('#add_instant_customer'+id).is(':visible')){
					addCancelCustomer(id);
				}
			}else{
				$('#proj_currency'+id).val(144); //0
				$('#proj_currency'+id).trigger('change');
				addCancelCustomer(id);
			}
		}
	}
	function addCancelCustomer(typ){
		$('#proj_cust_fname'+typ).val('');
		$('#proj_cust_email'+typ).val('');
		$('#add_instant_customer'+typ).slideToggle();
	}

</script>