<div class="modal-body popup-container">
    <div class="data-scroll user_pdt">
        <?php if (isset($task_list_arry) && !empty($task_list_arry)) { ?>
            <div>
                <div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder customize-plshdr">
                    <select name="new_parent_task" id="new_parent_task" class="select form-control mke_parent_task"  data-dynamic-opts=true>
                        <?php /*<option value=""></option>*/?>
                        <?php
                        foreach ($task_list_arry as $k=>$tsk) { ?>
                            <option value="<?php echo $k; ?>" >#&nbsp;<?php echo ucwords($this->Format->shortLength($tsk, 75)); ?></option>
                            <?php /*if ($proj['Project']['id'] == $project_id) { ?>selected="selected"<?php } */?>
                        <?php } ?>
                    </select>
                    <div id="err_msg_dv" class="exist-prj exit-pro-txt" style="display:none"><?php echo __('Already in this Project');?>.</div>
                </div>
            </div>
            <input type="hidden" id="tsk_id" value="<?php echo $case_id ?>" />
            <input type="hidden" id="tsk_projectid" value="<?php echo $project_id ?>" />
            
            
        <?php } else { ?>
            <div>
                <p class="v-top" colspan="2"><span class="fnt_clr_rd"><?php echo __('No Parent Task found. Create a Parent task first to convert this task to a Subtask');?>!</span></p>
            </div>
        <?php } ?>

    </div>
</div>
<div class="modal-footer ">
    <div class="fr popup-btn">
        <span id="mksbtskloader" class="mvprjlder fr" style="display: none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> </span>
        <div id="mksbtsk_btn">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="mvbtn" onclick="makeTaskToSubTask();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Select');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
</div>