<style>
.status_custom_cont .form-group {padding-bottom: 20px;}
</style>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo HTTP_ROOT?>css/color_picker/colorpicker.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo HTTP_ROOT?>css/color_picker/layout.css" />
<script type="text/javascript" src="<?php echo HTTP_ROOT?>js/color_picker/colorpicker.js"></script>
   <!-- <form name="WorkflowStatus" id="workflowStatusForm" method="post" action="<?php echo HTTP_ROOT . 'status-setting/'.base64_encode($wid); ?>" autocomplete="off" onsubmit="return validateWorkFlowStatus();">-->
    <form name="WorkflowStatus" id="workflowStatusForm" autocomplete="off">
    
    <div class="modal-body status_custom_cont">
        <div id="inner_label">
            <center><div id="lterr_msg" class="err_msg"></div></center>
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Status Name');?></label>
                    <input type="text"  class="form-control" name="data[CustomStatus][name]" value="<?php echo @$res['CustomStatus']['name'];?>" id="custom_statuses_name" placeholder="" maxlength="35" />
                    <input type="hidden" class="form-control" value="<?php echo @$res['CustomStatus']['id'];?>" name="data[CustomStatus][id]" id="custom_statuses_id" placeholder="" />
                </div>
                 <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Status Type');?></label>
                    <select name="data[CustomStatus][status_master_id]" class="select2" id="custom_statuses_map">
                        <?php foreach($statusMaster as $k=>$v){ ?>
                        <option value="<?php echo $k; ?>" <?php if(isset($res['CustomStatus']['status_master_id']) && $res['CustomStatus']['status_master_id'] ==$k ){ echo 'selected="selected"'; }else if(!isset($res['CustomStatus']['status_master_id']) && $k == 2){ echo 'selected="selected"';} ?> <?php if(isset($res['CustomStatus']['status_master_id']) && $res['CustomStatus']['status_master_id'] == 3 && $k != 3){ echo 'disabled="disabled"'; }else if($k == 3){ echo 'disabled="disabled"'; } ?>><?php echo $v;?></option>
                    <?php } ?>                        
                    </select>
                </div>
				<div class="form-group label-floating">
					<label class="control-label" for="label_nm"><?php echo __('Progress (%)');?></label>
					<select name="data[CustomStatus][progress]" class="select2" id="select2">
						<?php for($i=0; $i<= 100; $i=$i+10){ ?>
							<option value="<?php echo $i; ?>" <?php if(isset($res['CustomStatus']['progress']) && $res['CustomStatus']['progress'] ==$i ){ echo 'selected="selected"'; }?> <?php if(isset($res['CustomStatus']['status_master_id']) && $res['CustomStatus']['status_master_id'] == 3 && $i != 100){ echo 'disabled="disabled"'; }?>><?php echo $i; ?></option>
						<?php } ?>
					</select>
				</div>
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Color');?></label>
                    <input type="hidden" name="data[CustomStatus][color]" value="<?php if(isset($res['CustomStatus']['color'])){ echo $res['CustomStatus']['color']; }else{ ?>0000ff<?php } ?>" id="custom_task_color" />
                    <div id="colorSelector" style="top:10px;"><div style="background-color: #<?php if(isset($res['CustomStatus']['color'])){ echo $res['CustomStatus']['color']; }else{ ?>0000ff<?php } ?>"></div></div>                    
                </div>
        </div>
    </div>		
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span id="create_wloader1" style="display:none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
            </span>             
            <span id="wfbtn1">
								<?php if(!isset($res['CustomStatus']['id'])) { ?>
									<?php /*<span class="fl" style="margin: 5px 2px 2px;font-size: 13px;">
										<input type="checkbox" id="add_wf_status" name="add_wf_status" value="1">
											Create Another
									</span>*/ ?>
									<span class="fl">
										<label style="line-height:25px;">
											<input type="checkbox" id="add_wf_status" name="add_wf_status" value="1">
											<?php echo __("Create another");?>
										</label>
									</span>
							 <?php } ?>
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn">
					<input type="hidden" id="custom-status" name="data[CustomStatus][uu_id]" value="<?php echo base64_encode($wid);?>" />
                    <?php if($from_page != ''){ ?>
                    <input type="button" id="newworkflow_btn" value="<?php if(isset($res['CustomStatus']['id']) && !empty($res['CustomStatus']['id'])){ echo __('Update'); }else{ echo __('Add'); } ?>" name="add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="saveKanbanNewSts('<?php echo base64_encode($wid);?>');" />
               <?php } else { ?>                  
                    <input type="button" id="newworkflow_btn" value="<?php if(isset($res['CustomStatus']['id']) && !empty($res['CustomStatus']['id'])){ echo __('Update'); }else{ echo __('Add'); } ?>" name="add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="addKanbanNewSts()" />
                <?php } ?>
                </span>
            </span>

            <div class="cb"></div>
        </div>
    </div>
</form>
<script>
 $(document).ready(function(){
    $(".select2").select2();
    $('#colorSelector').ColorPicker({
    color: '#<?php if(isset($res['CustomStatus']['color'])){ echo $res['CustomStatus']['color']; }else{ ?>2c41c9<?php } ?>',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#colorSelector div').css('backgroundColor', '#' + hex);
        $('#custom_task_color').val(hex);
    },
    onSubmit: function(hsb, hex, rgb, el) {
        $(el).ColorPickerHide();
    }
});
});
 function validateWorkFlowStatus(){
    if($("#custom_statuses_name").val().trim() ==''){
            showTopErrSucc('error', "<?php echo __('Please enter status name')?>");
            return false;
        }else{
            $("#wfbtn1").hide();
            $("#create_wloader1").show();
            return true;
        }   
 }
 function saveKanbanNewSts(id){
    		var url = '<?php echo HTTP_ROOT; ?>';
		$.ajax({
			url: url + 'projects/ajax_saveNewstatusKanban',
			type: 'POST',
			data: $('#workflowStatusForm').serialize(),
			cached: true,
			dataType: 'json',
			success: function (res) {
				if(res.status == 'success'){                 
					    closePopup();                
				}else{
					showTopErrSucc('error', res.msg);
				}
			},
			error: function() {
				showTopErrSucc('error', _('Error in saving task status.'));
			}
		});
	 
 }

 
</script>