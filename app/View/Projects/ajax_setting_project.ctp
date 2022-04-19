<style>
#txt_shortProjEdit {
	text-transform:uppercase;
}
</style>
<div class="modal-body popup-container">
     <div class="row ">  
        <div class="col-lg-12 col-sm-12">
        <p style="font-size: 12px;"><?php echo __("Task can be estimated when in the Backlog to get an idea of how much work is being committed to in a sprint.");?> </p>
        </div>
    </div>
    <center><div id="edit_prj_err_msg" class="err_msg"></div></center>
    <?php echo $this->Form->create('ProjectSetting', array('url' => '/projects/ajax_setting_project','id'=>'projsettings', 'name' => 'projsettings', 'enctype' => 'multipart/form-data')); ?>    
    <input type="hidden" id="ProjectSettingId" value="<?php echo $projArr['ProjectSetting']['id'] ?>" name="data[ProjectSetting][id]"/>
    <input type="hidden" id="ProjectSettingProjectId" value="<?php echo $pid; ?>" name="data[ProjectSetting][project_id]"/>
    <input type="hidden" id="ProjectSettinCompanyId" value="<?php echo SES_COMP; ?>" name="data[ProjectSetting][company_id]"/>
	<div class="row ">
		<div class="col-lg-12 padlft-non padrht-non">	
            <div class="col-lg-12 col-sm-12">
                <div class="select2__wrapper" id="setting_dropdown">
                    <select name="data[ProjectSetting][velocity_reports]" class="form-control floating-label proj_velocity" placeholder="<?php echo __('Estimation Statistic');?>" data-dynamic-opts=true id="ProjectSettingVelocityReports">
                        <option value='0' <?php if($projArr['ProjectSetting']['velocity_reports']==0){ ?>selected <?php } ?>><?php echo __('Story Points');?></option>
                        <option value='1' <?php if($projArr['ProjectSetting']['velocity_reports']==1){ ?>selected <?php } ?>><?php echo __('Original Time Estimate');?></option>
                        <option value='2' <?php if($projArr['ProjectSetting']['velocity_reports']==2){ ?>selected <?php } ?>><?php echo __('Task Count');?></option>
                    </select>
                </div>
            </div>
		</div>		
	</div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span id="settingldr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader" /></span>
            <span id="btn" class="project_edit_button">
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="btn_setting_project" onclick="submitProjectSetting();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Update');?></a></span>
            </span>
        </div>
    </div>
<?php $this->Form->end(); ?>
</div>

<script>
$(function() {   
     $('#edit_prj_err_msg').html('');
});
function submitProjectSetting(){
    $("#settingldr").show();
    $(".project_edit_button").hide();
    $.post('<?php echo HTTP_ROOT.'projects/ajax_setting_project'?>',{
        "data[ProjectSetting][id]":$("#ProjectSettingId").val(),
        "data[ProjectSetting][project_id]":$("#ProjectSettingProjectId").val(),
        "data[ProjectSetting][company_id]":$("#ProjectSettinCompanyId").val(),
        "data[ProjectSetting][velocity_reports]":$("#ProjectSettingVelocityReports").val()
    },function(res){
        if(res.status == 1){
             showTopErrSucc('success', res.msg);
        }else{
            showTopErrSucc('error', res.msg);
        }
        $("#settingldr").hide();
        $(".project_edit_button").show();
        closePopup();
    },'json');  
}
</script>