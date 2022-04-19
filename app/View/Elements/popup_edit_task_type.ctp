<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="task_type_title_edit"><?php echo __('Update Task Type');?></h4>
        </div>
        <div class="modal-body popup-container">
          <!--   <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div> -->
            <div class="mtop15" id="inner_tasktype_edit" style="display: block;">
                <center><div id="tterr_msg_edit" class="err_msg"></div></center>
                <form name="task_type" id="customTaskTypeForm_edit" method="post" action="<?php echo HTTP_ROOT . "projects/addNewTaskType"; ?>" autocomplete="off">
                    <div class="field_wrapper">
                        <input type="text" value="" class="" name="data[Type][name]" id="task_type_nm_edit" placeholder="" maxlength="20" />
												<div class="field_placeholder mark_mandatory"><span><?php echo __('Specify task type name');?></span></div>
                        <input type="hidden" class="" name="data[Type][id]" id="new-typeid_edit"/>
                    </div>
                    <div class="field_wrapper mtop30">
                        <input type="text" value="" class="" name="data[Type][short_name]" id="task_type_shnm_edit" placeholder="" maxlength="4" />
												<div class="field_placeholder mark_mandatory"><span><?php echo __('Give a short name for task type');?></span></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="ttloader_edit" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader" style="vertical-align: initial;"/>
                </span>
                <span id="ttbtn_edit">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="newtask_btn_edit" onclick="validateTaskTypeEdit();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Update');?></a></span>
                </span>

                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">		
    $(function() {
        $('#task_type_nm_edit').val().trim()!=''?$("#newtask_btn_edit").removeClass('loginactive'):$("#newtask_btn_edit").addClass('loginactive');
        $('#task_type_nm_edit,#task_type_shnm_edit').on('change, keyup',function(){
			$('#task_type_nm_edit').val().trim()!='' && $('#task_type_shnm_edit').val().trim()!=''
				?$("#newtask_btn_edit").removeClass('loginactive'):$("#newtask_btn_edit").addClass('loginactive');
			$('#tterr_msg_edit').html('');
        });
        $('#tterr_msg_edit').html('');
        $(document).on('keypress','#task_type_nm_edit,#task_type_shnm_edit',function(e){
          if (e.which == 13) {
            validateTaskTypeEdit();
          }
        });
    });
</script>