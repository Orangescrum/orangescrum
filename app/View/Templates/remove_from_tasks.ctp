<?php $caseCount = count($temp_dtls_cases); ?>
<?php if ($caseCount > 0) { ?>
    <div class="modal-body popup-container">
        <div class="popup-inner-container">
            <div class="scrl-ovr">
                <ul class="rmv_frm_task_mng" style="">
                    <li style="list-style:none;">
                        <table class="table table-striped table-hover mrg0">
                            <thead>
                                <tr>
                                    <th width="3%"></th>
                                    <th width="28%"><?php echo __('Title');?></th>
                                    <th width="56%"><?php echo __('Description');?></th>
                                    <th width="12%"><?php echo __('Action');?></th>
                                </tr>
                            </thead>
                        </table>
                    </li>
                </ul>
                <ul class="rmv_frm_task_mng" style="" id="sortme">
                    <?php
                    $counter = 0;
                    $class = "";
                    foreach ($temp_dtls_cases as $val) {
                        $counter++;
                        if ($counter % 2 == 0) {
                            $class = "row_col";
                        } else {
                            $class = "row_col_alt";
                        }
                        ?>
                        <li style="" id="menu_<?php echo $val['ProjectTemplateCase']['id']; ?>">
                            <input type="hidden" id="actionCls<?php echo $val['ProjectTemplateCase']['id']; ?>" value="0"/>
                            <table class="table  table-hover mrg0">
                                <tbody>
                                    <tr id="listing_<?php echo $val['ProjectTemplateCase']['id']; ?>" class=" rw-cls <?php echo $class; ?>" style="cursor:move;">	
                                        <td width="3%" style="">
                                            <span class="glyphicon glyphicon-resize-vertical drag_icn"></span>
                                        </td>
                                        <td width="28%" style="">
                                            <p id="title_<?php echo $val['ProjectTemplateCase']['id']; ?>" style="">
                                                <?php echo $this->Format->formatTitle($this->Format->formatCms($val['ProjectTemplateCase']['title']));?>
                                            </p>
                                        </td>
                                        <td width="56%">
                                            <p id="desc_<?php echo $val['ProjectTemplateCase']['id']; ?>">
                                                <?php echo $val['ProjectTemplateCase']['description'] != '' ? $this->Format->formatTitle($this->Format->formatCms($val['ProjectTemplateCase']['description'])) : '---'; ?>
                                            </p>
                                        </td>
                                        <td width="12%" style="">
                                            <span class="m-task-edit"><a href="javascript:void(0)" onclick="EditTaskProject(<?php echo $val['ProjectTemplateCase']['id']; ?>)" title="<?php echo __('Edit');?>"><i class="material-icons">&#xE3C9;</i></a></span>
                                            <span class="m-task-del"><a href="javascript:void(0)" onclick="deltemplatecases(<?php echo $val['ProjectTemplateCase']['id']; ?>,<?php echo $val['ProjectTemplateCase']['template_id']; ?>);" title="<?php echo __('Delete');?>"><i class="material-icons">&#xE872;</i></a></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span id="taskAddBtns" style="display:block;">
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="confirmusercls" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="closePopup();"><?php echo __('Close');?></a></span>
            </span>
            <span id="addtaskloader" class="ldr-ad-btn fr" style="display:none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <span id="taskAddBtns" style="display:none;">
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="confirmusercls" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="remove_cases_template();"><?php echo __('Remove');?></a></span>
								<div class="cb"></div>
            </span>
            <div class="cb"></div>
        </div>
    </div>
<?php } else { ?>
    <div class="modal-body popup-container">
        <p class="no_rec_note add-tmp-btn" id="excptAddContinue"><?php echo __('No task on this template');?></p>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span class="fl hover-pop-btn"><a href="javascript:void(0)"   class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info" onclick="addTempToTask('<?php echo $template_id; ?>', '', 1)"><?php echo __('Add Task to Template');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function() {
        $("#sortme").sortable({
            update: function() {
                var serial = $('#sortme').sortable('serialize');
                $.ajax({
                    url: HTTP_ROOT + "templates/ajax_sort_tasks",
                    type: "post",
                    data: serial,
                    error: function() {
                        alert("<?php echo __('theres an error with AJAX');?>");
                    }
                });
            }
        });
    });
</script>