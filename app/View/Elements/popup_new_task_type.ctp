<style type="text/css">
	.modal-footer .custom-checkbox{float:none;width:auto}
</style>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="task_type_title"><?php echo __('New Task Type');?></h4>
        </div>
        <div class="modal-body popup-container">
            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
            <div class="mtop15" id="inner_tasktype" style="display: none;">
                <center><div id="tterr_msg" class="err_msg"></div></center>
                <form name="task_type" id="customTaskTypeForm" method="post" action="<?php echo HTTP_ROOT . "projects/addNewTaskType"; ?>" autocomplete="off">
                    <div class="select_field_wrapper mbtm15 mark_mandatory">
                        <select name="data[Type][project_id][]" multiple="multiple" class="task_type_project form-control floating-label" id="project_task_type"  placeholder="<?php echo __('Projects');?>">
                            <?php if(count($GLOBALS['getallprojForAdmin']) > 1){ ?>
                                <option value="0"><?php echo __("All Project");?></option> 
                            <?php } ?>
                            <?php foreach($GLOBALS['getallprojForAdmin'] as $k=>$v){ ?>
                            <option value="<?php echo $v['Project']['id'];?>"><?php echo $v['Project']['name'];?></option>
                            <?php } ?>                             
                        </select> 
                    </div>
                    <div class="field_wrapper">
                        <input type="text" value="" class="" name="data[Type][name]" id="task_type_nm" placeholder="" maxlength="20" />
												<div class="field_placeholder mark_mandatory"><span><?php echo __('Specify task type name');?></span></div>
                        <input type="hidden" class="" name="data[Type][id]" id="new-typeid"/>
                    </div>
                    <div class="field_wrapper">
                        <input type="text" value="" class="" name="data[Type][short_name]" id="task_type_shnm" placeholder="" maxlength="4" />
						<div class="field_placeholder mark_mandatory"><span><?php echo __('Give a short name for task type');?></span></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
								<span class="checkbox custom-checkbox">
									<label style="line-height:25px;">
											<input type="checkbox" class="add_new_type" value="1" name="another_type" id="another_type"  /> <?php echo __("Create another");?>
									</label>
								</span> 
                <span id="ttbtn">
                    
										<span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                                        <span class="hover-pop-btn"><a href="javascript:void(0)" id="newtask_btn" onclick="validateTaskType();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Add');?></a></span>
                </span>

                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
       // $('#task_type_nm').val().trim()!=''?$("#newtask_btn").removeClass('loginactive'):$("#newtask_btn").addClass('loginactive');
        $('#task_type_nm,#task_type_shnm').on('change, keyup',function(){
			//$('#task_type_nm').val().trim()!='' && $('#task_type_shnm').val().trim()!=''
			//	?$("#newtask_btn").removeClass('loginactive'):$("#newtask_btn").addClass('loginactive');
			$('#tterr_msg').html('');
        });
        $('#tterr_msg').html('');
        $(document).on('keypress','#task_type_nm,#task_type_shnm',function(e){
          if (e.which == 13) {
            validateTaskType();
          }
        });
    });
</script>