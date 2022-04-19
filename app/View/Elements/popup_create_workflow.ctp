<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="label_title_wf"><?php echo __('Create New Status Workflow');?></h4>
        </div>
        <form name="Workflow" id="workflowForm" method="post" action="<?php echo HTTP_ROOT . 'workflow-setting'; ?>" autocomplete="off" onsubmit="return validateWorkFlow();">
        <div class="modal-body popup-container">
            <div id="inner_label">
                <center><div id="lterr_msg" class="err_msg"></div></center>               
                    <div class="form-group label-floating">
                        <label class="control-label" for="label_nm"><?php echo __('Status Workflow Name');?></label>
                        <input type="text" value="" class="form-control" name="data[StatusGroup][name]" id="StatusGroup_name" placeholder="" maxlength="20" />
                        <input type="hidden" value="" class="form-control" name="data[StatusGroup][id]" id="StatusGroup_id" placeholder="" maxlength="20" />
                    </div>
                     <div class="form-group label-floating">
                        <label class="control-label" for="label_nm"><?php echo __('Description');?></label>
                        <textarea class="form-control" name="data[StatusGroup][description]" id="StatusGroup_desc" placeholder=""></textarea>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="create_wloader" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
                </span>
                <span id="wfbtn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn">
                        <input type="submit" id="newworkflow_btn" value="<?php echo __('Add');?>" name="add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" />
                    </span>
                </span>

                <div class="cb"></div>
            </div>
        </div>
    </form>
    </div>
</div>
