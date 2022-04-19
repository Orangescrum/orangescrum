<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopupEdit();"><i class="material-icons">&#xE14C;</i></button>
            <h4>
                <span id="header_task_prj"></span>
            </h4>
        </div>
        <div class="modal-body popup-container">
            <div class="loader_dv_tsk_prj"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
            <div id="inner_task_project_edit">
                <center><div id="task_project_err_edit" class="fnt_clr_rd" style="display:block;"></div></center>
                <form name="templatecase" method="post" >
                    <input type="hidden" name="template_id" id="temp_id" value="" />
                    
                    <div class="form-group label-floating">
                        <label class="control-label" for="title_edit"><?php echo __('Specify task title');?></label>
                        <input type="text" name="title_edit" id="title_edit" class="form-control" value= "" />
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="description_edit"><?php echo __('Give task description');?></label>
                        <textarea name="description_edit" id="description_edit" class="form-control input-lg expand hideoverflow"></textarea>
                    </div>
                </form>	
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="prjtemploader_task_prj" class="ldr-ad-btn" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
                </span>
                <span id="prj_btn_task_edit">
                    <span class="fl cancel-link">
                        <button type="button" class="btn btn-default btn-sm pull-left" onclick="closePopupEdit();"><?php echo __('Cancel');?></button>
                    </span>
                    <span class="fl hover-pop-btn">
                        <a href="javascript:void(0)"  class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info" onclick="validateTaskTemplateEdit();"><?php echo __('Update');?></a>
                    </span>
                </span>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
