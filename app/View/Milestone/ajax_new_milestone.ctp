<?php echo $this->Form->create('Milestone', array('id' => 'addmilestone')); ?>
<?php echo $this->Form->hidden('user_id', array('id' => 'user_id', 'value' => SES_ID)); ?>
<?php echo $this->Form->hidden('id', array('id' => 'id', 'value' => $milearr['Milestone']['id'])); ?>
<?php echo $this->Form->hidden('default_id', array('value' => $mileuniqid)); ?>
<div class="modal-body popup-container">
    <center><div id="milestone_err_msg" class="err_msg" ></div></center>
    <div class="form-group  label-floating">
        <label class="control-label" for="title"><?php echo __('Name your group');?></label>
        <?php echo $this->Form->text('title', array('class' => 'form-control input-lg', 'id' => 'title', 'maxlength' => '100', 'placeholder' => '', 'value' => htmlspecialchars_decode($milearr['Milestone']['title']), 'data-title' => htmlspecialchars_decode($milearr['Milestone']['title']))); ?>
        
    </div>
    <div id="newmileproj" class="pop-dropdown mtop15">
        <?php if (!$milearr['Milestone']['id']) { ?>
            <select id="project_id" name="data[Milestone][project_id]" class="select_mile form-control floating-label remove-dp" placeholder="<?php echo __('Project');?>">
                <?php /* <option value=""> Select Project</option> */?>
                <?php foreach ($projArr as $prjarr) { ?>
                    <option <?php echo ($projUid == $prjarr['Project']['uniq_id']) ? "selected=selected" : ""; ?>
                    value="<?php echo $prjarr['Project']['id']; ?>" data-pname="<?php echo $prjarr['Project']['name']; ?>" 
                    data-puniq="<?php echo $prjarr['Project']['uniq_id']; ?>"><?php echo $this->Format->formatText($prjarr['Project']['name']); ?></option>
                <?php } ?>
            </select>
        <?php } else { ?>
            <input type="hidden" name="data[Milestone][project_id]" id="project_id" value="<?php echo $milearr['Milestone']['project_id']; ?>" data-pname="<?php echo $projArr[0]['Project']['name']; ?>" data-puniq="<?php echo $projArr[0]['Project']['uniq_id']; ?>">
            <?php /*<strong class="edit-desc-txt"><?php echo $this->Format->formatText($projArr[0]['Project']['name']); ?></strong>*/?>
            <div class="form-group label-floating">
                <label class="control-label"><?php echo __('Project');?></label>
                <div class="form-control input-lg"><?php echo $this->Format->formatText($projArr[0]['Project']['name']); ?></div>
            </div>
        <?php } ?>
    </div>
    <div class="form-group form-group-lg is-empty  label-floating">
        <label class="control-label" for="description"><?php echo __('Describe your group');?></label>
        <?php echo $this->Form->textarea('description', array('id' => 'description', 'class' => 'form-control expand hideoverflow', 'value' => $milearr['Milestone']['description'], 'data-desc' => $milearr['Milestone']['description'], 'rows' => '1', 'placeholder' => '')); ?>
        
    </div>
    <div class="row">
        <div class="col-lg-12 padlft-non padrht-non">
            <div class="col-lg-4 col-sm-4">
                <div class="form-group form-group-lg mrg0">
                    <label class="control-label" for="txt_MlsEsthr"><?php echo __('Estimated Hours');?></label>
                    <?php /*<span class="os_sprite est-hrs-icon"></span> */?>
                    <?php $estimated_hours = !empty($milearr['Milestone']['estimated_hours']) ? $milearr['Milestone']['estimated_hours'] : ""; ?>
                    <?php echo $this->Form->text('estimated_hours', array('data-eshr' => $estimated_hours, 'value' => $estimated_hours, 'class' => 'form-control', 'id' => 'txt_MlsEsthr', 'placeholder' => 'hh', 'maxlength' => '6', 'onkeypress' => 'return numericDecimalProj(event)')); ?>
                    <p class="help-block">(8 <?php echo __('hours');?> = 1 <?php echo __('day');?>)</p>
                </div>
            </div>
            <div class="col-lg-1 col-sm-1"></div>
            <?php
            if (strtotime($milearr['Milestone']['start_date']) > 0 && $milearr['Milestone']['start_date'] != '1970-01-01') {
                $milearr['Milestone']['start_date'] = date('M j, Y', strtotime($milearr['Milestone']['start_date']));
            } else if ($milearr['Milestone']['start_date'] == '0000-00-00' || $milearr['Milestone']['start_date'] == '1970-01-01') {
                $milearr['Milestone']['start_date'] = '';
            }else{
                $milearr['Milestone']['start_date'] = '';
            }

            if (strtotime($milearr['Milestone']['end_date']) > 0 && $milearr['Milestone']['end_date'] != '1970-01-01') {
                $milearr['Milestone']['end_date'] = date('M j, Y', strtotime($milearr['Milestone']['end_date']));
            } else if ($milearr['Milestone']['end_date'] == '0000-00-00' || $milearr['Milestone']['end_date'] == '1970-01-01') {
                $milearr['Milestone']['end_date'] = '';
            }else{
                $milearr['Milestone']['end_date'] = '';
            }
            ?>
            <div class="col-lg-7 col-sm-7">
                <div class="col-lg-6 col-sm-6 padlft-non">
                    <div class="form-group form-group-lg mrg0">
                        <label class="control-label" for="start_date"><?php echo __('Date Range');?></label>
                        <?php echo $this->Form->text('start_date', array('class' => 'datepicker form-control', 'id' => 'start_date_mil', 'placeholder' => __('Start Date',true), 'readonly' => 'readonly', 'value' => $milearr['Milestone']['start_date'], 'data-sdate' => $milearr['Milestone']['start_date']));?>
                    </div>
                </div>
                <div class="from_to">to</div>
                <div class="col-lg-6 col-sm-6 padrht-non">
                    <div class="form-group mrg0">
                        <label class="control-label blank-label" for="end_date">xxx</label>
                        <?php echo $this->Form->text('end_date', array('class' => 'datepicker form-control', 'id' => 'end_date_mil', 'placeholder' => __('End Date',true), 'readonly' => 'readonly', 'value' => $milearr['Milestone']['end_date'], 'data-edate' => $milearr['Milestone']['end_date']));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="fr popup-btn">
        <span id="ldr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></span>
        <span id="btn_mlstn">
            <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="hover-pop-btn"><a href="javascript:void(0)" id="btn-add-new-milestone" onclick="return validatemilestone();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive"><?php echo (!empty($edit)) ?__("Save my changes"):__("Save"); ?></a></span>
        </span>
    </div>
	<div class="cb"></div>
</div>



<input type="hidden" value="<?php echo $mlstfrom;?>" id="milestone_crted_from"/>
<?php echo $this->Form->end(); ?>
<script>
$(function() {
    $("#end_date_mil").datepicker({
        format: 'M d, yyyy',
        changeMonth: false,
        changeYear: false,
        startDate: 0,
        hideIfNoPrevNext: true,
        autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#end_date_mil").datepicker('getFormattedDate');
        $("#start_date_mil").datepicker("setEndDate", dateText);
    });
    $("#start_date_mil").datepicker({
        format: 'M d, yyyy',
        changeMonth: false,
        changeYear: false,
        startDate: 0,
        hideIfNoPrevNext: true,
        autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#start_date_mil").datepicker('getFormattedDate');
        $("#end_date_mil").datepicker("setStartDate", dateText);
    });
    $('#title').val().trim()!=''?$("#btn-add-new-milestone").removeClass('loginactive'):$("#btn-add-new-milestone").addClass('loginactive');
    $('#title').keyup(function(){
        $('#title').val().trim()!=''?$("#btn-add-new-milestone").removeClass('loginactive'):$("#btn-add-new-milestone").addClass('loginactive');
        $('#milestone_err_msg').html('');
    });
    $('#milestone_err_msg').html('');
});
function validatemilestone() {
    $('#milestone_err_msg').html('');
	//console.log($('#addmilestone').serialize());return false;
    $("#btn-add-new-milestone").removeClass('loginactive')
    var title = $('#title').val().trim();
    var start_date = $('#start_date_mil').val().trim();
    var end_date = $('#end_date_mil').val().trim();
    var project_id = $('#project_id').val();
    var desc = $('#description').val().trim();
    var est_hr = $('#txt_MlsEsthr').val().trim();
    var any_changes = 1;
    if($('#id').val()){
        var data_title = $('#title').attr('data-title').trim();
        var data_start_date = $('#start_date_mil').attr('data-sdate').trim();
        var data_end_date = $('#end_date_mil').attr('data-edate').trim();
        var data_desc = $('#description').attr('data-desc').trim();
        var data_est_hr = $('#txt_MlsEsthr').attr('data-eshr').trim();
        if((title == data_title) && (data_start_date == start_date) && (data_end_date == end_date) && (data_desc == desc) && (data_est_hr == est_hr)){
            any_changes = 0;
        }
    }
	if($('#id').val()){
		var proj_uniq = $('#project_id').attr('data-puniq');
		var proj_name = $('#project_id').attr('data-pname');
	} else {
		var proj_uniq = $('#project_id option[value="'+project_id+'"]').attr('data-puniq');
		var proj_name = $('#project_id option[value="'+project_id+'"]').attr('data-pname');
	}
	
    var errMsg;
    var done = 1;
    
    if (project_id.trim() == "") {
		errMsg = "<?php echo __('Project cannot be left blank');?>!";
		$('#project_id').focus();
		done = 0;
                
    } else if (title == "" || title.toLowerCase() == 'default task group') {
		errMsg = "<?php echo __('Task group name cannot be left blank');?>!";
                if(title.toLowerCase() == 'default task group'){
                    errMsg = "<?php echo __('Task group name');?> '"+title+"' <?php echo __('already exists');?>!";
                }
		$('#title').focus();
		done = 0;
    } else if ((start_date.trim() != "" && end_date.trim() == "") || (start_date.trim() == "" && end_date.trim() != "")) {
		if(start_date.trim() == ""){
                    errMsg = "<?php echo __('Start Date cannot be left blank');?>!";
                    $('#start_date_mil').focus();
                }else{
                    errMsg = "<?php echo __('End Date cannot be left blank');?>!";
                    $('#end_date_mil').focus();
                }
		done = 0;
    } else if(est_hr.trim() == ""){
		//errMsg = "Estimated hours cannot be left blank!";
		//$('#txt_MlsEsthr').focus();
		//done = 0;
	}
    /*else if (end_date.trim() == "") {
		errMsg = "End Date cannot be left blank!";
		$('#end_date').focus();
		done = 0;
    }*/
    else if ((start_date.trim() != "" && end_date.trim() != "") && (Date.parse(start_date) > Date.parse(end_date))) {
		errMsg = "<?php echo __('Start Date cannot exceed End Date');?>!";
		$('#end_date_mil').focus();
		done = 0;
    }
    if (done == 0) {
        $("#btn-add-new-milestone").addClass('loginactive');
    }
    if($("#btn-add-new-milestone").hasClass('loginactive')){
        done = 0;
    }
    if (done == 0) {
        //$('#milestone_err_msg').html(errMsg);
		showTopErrSucc('error', errMsg);
		return false;
    } else {
		var mdata = $('#addmilestone').serialize();
		//var url = HTTP_ROOT+'milestones/ajax_new_milestone?'+mdata;
		var url = HTTP_ROOT+'milestones/ajax_new_milestone';
		$('#inner_mlstn #btn_mlstn').hide();
		$('#inner_mlstn #ldr').show();
		//$.post(url, {"mdata":mdata}, function(res){
		$.ajax({
			type: "POST",
			url: url,
			data: mdata,
			dataType: "json",
			success: function(res) {
				if(res.error){
					showTopErrSucc('error', res.msg);
				}else if(res.success){
					if(any_changes == 1){
						showTopErrSucc('success', res.msg);
					}
				}
			
				var match= window.location.href.replace('#/','#').match(/#(.*)$/);
				match = match?match[1]:'';			
				if(match == 'overview'){ 
					$('#inner_mlstn #btn_mlstn').show();
					$('#inner_mlstn #ldr').hide(); 
					location.reload();
					return false;
				}
				if(match == 'taskgroups'){ 
					$('#inner_mlstn #btn_mlstn').show();
					$('#inner_mlstn #ldr').hide(); 
					showTaskGroupsList();
					closePopup();
					return false;
				}
			
				$('#mlstPage').val(1);
				if($('#milestone_crted_from').val()=='createTask'){
					milstoneonTask($('#title').val(),res.milestone_id);
				}else if($('#caseMenuFilters').val()=='milestone'){
					if($('#id').val()){
						//ManageMilestoneList();alert(1);
						updateAllProj('proj_'+proj_uniq,proj_uniq,'dashboard','0',proj_name);
					}else{
						//ManageMilestoneList(1);
						$('#mlsttabvalue').val(1);
						updateAllProj('proj_'+proj_uniq,proj_uniq,'dashboard','0',proj_name);
					}
				}else if($('#caseMenuFilters').val()=='milestonelist'){
					//showMilestoneList();
					updateAllProj('proj_'+proj_uniq,proj_uniq,'dashboard','0',proj_name);
				}else if($('#caseMenuFilters').val()=='kanban'){
					<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){  ?>
							easycase.refreshTaskList();
					<?php }else{ ?>
							easycase.showKanbanTaskList();
					<?php } ?>
				}else{
					var dflt = $('#MilestoneDefaultId').val().trim();
					if(($('#inline_milestone').length || (dflt == 'default')) && $('#caseMenuFilters').val().trim() != 'timelog' && $('#caseMenuFilters').val().trim() != 'activities' && $('#caseMenuFilters').val().trim() != 'files'){
						if(res.success){
							if(dflt == 'default' || dflt == '0'){
							if(dflt == 'default'){
								$('#miview_default').text(title.trim());
								}
								easycase.refreshTaskList();
							}else{
								var id = $('#id').val();
								$('#miview_'+id).text(title.trim());
								$('#tg_spn_est_id'+id).text($('#txt_MlsEsthr').val());
								$('#tg_spn_st_id'+id).text($('#start_date_mil').val());
								$('#tg_spn_ed_id'+id).text($('#end_date_mil').val());							
							}
						}
					}else{
						if(PAGE_NAME !='dashboard' && PAGE_NAME !='invoice'){
												 <?php  if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
														 window.location.href=HTTP_ROOT+'dashboard#tasks';
													<?php }else{ ?>
														 window.location.href=HTTP_ROOT+'dashboard#milestonelist';
												 <?php  }?>
						
						}else{
							//ManageMilestoneList();
							if(dflt == '0'){
								//easycase.refreshTaskList();
								groupby('milestone');
							}else{
							<?php  if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
															window.location.href=HTTP_ROOT+'dashboard#tasks';
												 <?php  }else{ ?> 
														 window.location.href=HTTP_ROOT+'dashboard#milestonelist';
													<?php } ?>
											
						}
					}
				}
				}
				$('#inner_mlstn #btn_mlstn').show();
				$('#inner_mlstn #ldr').hide();
				/* Code for Create Event tracking starts here */
				var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
				var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
				var event_name = sessionStorage.getItem('SessionStorageEventValue');
				if(eventRefer && event_name){
					trackEventLeadTracker(event_name, eventRefer, sessionEmail);
				}
				/* Code for Create Event tracking ends here */
				closePopup();
			}
		});
    }
}
</script>