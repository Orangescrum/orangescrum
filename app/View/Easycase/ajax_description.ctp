<?php echo $this->Form->create('Milestone', array('id' => 'add_description')); ?>
<?php echo $this->Form->hidden('user_id', array('id' => 'user_id', 'value' => SES_ID)); ?>
<?php echo $this->Form->hidden('project_id', array('id' => 'user_id', 'value' => $project_id)); ?>
<div class="modal-body popup-container">
    <center><div id="description_err_msg" class="err_msg" ></div></center>
    <div class="form-group form-group-lg is-empty  label-floating">
        <label class="control-label" for="description"><?php //echo __('Description');?></label>
        <?php echo $this->Form->textarea('description', array('id' => 'description', 'class' => 'form-control expand hideoverflow', 'value' => $milearr['Milestone']['description'], 'data-desc' => $description, 'rows' => '1', 'placeholder' => '','value'=>$description)); ?>
        
    </div>
  
</div>
<div class="modal-footer">
    <div class="fr popup-btn">
        <span id="desc_ldr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></span>
        <span id="btn_desc">
            <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="hover-pop-btn"><a href="javascript:void(0)" id="btn-add-new-milestone" onclick="return validatemilestone();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo (!empty($edit)) ?__("Save my changes"):__("Save"); ?></a></span>
        </span>
    </div>
	<div class="cb"></div>
</div>



<input type="hidden" value="<?php //echo $mlstfrom;?>" id="milestone_crted_from"/>
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
    $('#description_err_msg').html('');
	//console.log($('#addmilestone').serialize());return false;
    $("#btn-add-new-milestone").removeClass('loginactive')
   
    var desc = $('#description').val().trim();   
    var any_changes = 1;    
	if($('#id').val()){
		var proj_uniq = $('#project_id').attr('data-puniq');
		var proj_name = $('#project_id').attr('data-pname');
	} else {
		//var proj_uniq = $('#project_id option[value="'+project_id+'"]').attr('data-puniq');
		//var proj_name = $('#project_id option[value="'+project_id+'"]').attr('data-pname');
	}	
    var errMsg;
    var done = 1;    
    if (desc.trim() == "") {
		errMsg = "<?php echo __('Project Description be left blank');?>!";
		$('#description').focus();
		done = 0;
                
    }  
	if (done == 0) {
        //$('#milestone_err_msg').html(errMsg);
		showTopErrSucc('error', errMsg);
		return false;
    } else {
		var mdata = $('#add_description').serialize();
		//var url = HTTP_ROOT+'milestones/ajax_new_milestone?'+mdata;
		var url = HTTP_ROOT+'easycases/update_description';
		$('#inner_description #btn_desc').hide();
		$('#inner_description #desc_ldr').show();
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
				$('#inner_description #btn_desc').show();
				$('#inner_description #desc_ldr').hide(); 
				location.reload();
				return false;
			}			
		
		    }
		});
    }
}
</script>