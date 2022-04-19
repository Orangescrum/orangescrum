<div class="ganttTaskEditor">
    <div class="popup_overlay"></div>
    <div class="new_project cmn_popup">
        <div class="modal-dialog1">
            <div class="modal-content">
                <div class="modal-header popup-header">
                    <h4><?php echo __('Edit Task');?></h4>
                    <a href="javascript:jsVoid();"><div class="fr close_popup close_popup_btn">X</div></a>
                </div>
                <div class="modal-body popup-container" style="padding-top: 0px;">
                    <div class="noprint">
                        <input type="text" name="code" id="code" value="" class="formElements noprint">
                        
                    </div>
                    <div id="inner_task">
                        <input type="hidden" name="duration" id="duration"  value=""/>
                        <input type="hidden" name="data[Easycase][istype]" id="CS_istype" value="1" readonly="true"/>
                        <div class="cb"></div>
                        <div class="loader_dv_edit" style="display: none;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                        <div class="col-lg-12 padlft-non padrht-non err_msg" id="ganttv2_task_error"></div>
                        <div class="col-lg-12 padlft-non padrht-non">
                            <div class="form-group">
                                <label><?php echo __('Title');?>:</label>
                                <input class="form-control" type="text" placeholder="<?php echo __('Task Title');?>..." id="name" name="name" maxlength='240' onblur='blur_txt();checkAllProj();' onfocus='focus_txt()' onkeydown='return onEnterPostCase(event)' onkeyup='checktitle_value();' />
                            </div>
                        </div>
                        <div class="col-lg-12 padlft-non padrht-non">
                            <div class="form-group">
                                <label><?php echo __('Description');?>:</label>
                                <textarea rows="" cols="" id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 padlft-non padrht-non1 hidden">
                            <div class="form-group">
                                <label><?php echo __('Project');?>:</label>
                                <div class="createtask fl dropdown-blocks form-control" style="width:100%;">
                                    <div style="font-weight: bold;" id="edit_project_div" class="ttc"></div>
                                    <div id="create_project_div">
                                        <div id="projUpdateTop_v2" class="popup_link link_as_drp_dwn  fl wid1 ellipsis-view" style="max-width: 100%;">
                                            <?php echo $ctProjName; ?>
                                        </div>
                                        <input type="hidden" readonly="readonly" value="<?php echo $projUniq1; ?>" id="curr_active_project"/>
                                        <div id="projAllmsg" style="display:none;color:#C0504D; padding-top:10px;"><?php echo __('Oops! No project selected');?>.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cb"></div>
                        <div class="col-sm-4 padlft-non padrht-non1">
                            <div class="form-group">
                                <label><?php echo __('Assign To');?>:</label>
                                <select class="form-control"  id="gantt_assigned_to">
                                    
                                </select>
                            </div>
                        </div>
                        <div id="status" class="taskStatus noprint" status=""></div>
                        <div class="col-sm-4 padlft-non padrht-non1">
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" id="gantt_legend">
                                    <option value="1"><?php echo __('New');?></option>
                                    <option value="2" ><?php echo __('In Progress');?></option>
                                    <option value="5"><?php echo __('Resolve');?></option>
                                    <option value="3"><?php echo __('Close');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group create_priority">
                                <label><?php echo __('Priority');?>:</label>
                                <div class="form-group pri-div ct-prior-lmh">
                                    <span class="radio radio-primary custom-rdo priority-low-clr">
                                        <label>
                                            <input name="gantt_priority" id="gantt_priority_low" value="2" type="radio" onclick="changepriority_v2('low', 2, 'v2')" />
                                            <?php echo __('Low');?>
                                        </label>
                                    </span>
                                    <span class="radio radio-primary custom-rdo priority-medium-clr">
                                        <label>
                                            <input name="gantt_priority" id="gantt_priority_medium" value="1" type="radio" onclick="changepriority_v2('medium', 1, 'v2')" />
                                            <?php echo __('Medium');?>
                                        </label>
                                    </span>
                                    <span class="radio radio-primary custom-rdo priority-high-clr">
                                        <label>
                                            <input name="gantt_priority" id="gantt_priority_high" value="0" type="radio" onclick="changepriority_v2('high', 0, 'v2')" />
                                            <?php echo __('High');?>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="cb"></div>
                        <div class="col-sm-3 padlft-non padrht-non1">
                            <div class="form-group task_type cstm-drop-pad">
                                <label><?php echo __('Task Type');?>:</label>
                                <select class="form-control" id="gantt_tasktype_select">
                                    <?php
                                        foreach ($GLOBALS['TYPE'] as $k => $v) {
                                            foreach ($v as $key => $value) {
                                                foreach ($value as $key1 => $result) {
                                                    if ($key1 == 'name' && $key1 = 'short_name') {
                                                        //$im = $value['short_name'].".png";
                                                        $onlick="onclick=\"javascript:changeTaskType_v2('{$value['id']}','{$value['name']}')\"";
                                                        if (trim($value['short_name']) && file_exists(WWW_ROOT . "img/images/types/" . $value['short_name'] . ".png")) {
                                                            $im1 = $this->Format->todo_typ_src($value['short_name'], $value['name']);
                                                            echo "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
                                                        } else {
                                                            echo "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 padlft-non padrht-non1">
                            <div class="form-group">
                                <label><?php echo __('Progress');?>:</label>
                                <?php /*<input type="text" name="progress" id="progress" value="" placeholder="Task Progress..." class="form-control"/>*/?>
                                <select class="form-control remove-dp" name="progress" id="progress">
                                    <option value=""><?php echo __('Select');?></option>
                                <?php
                                $range = range(10, 100, 10);
                                foreach($range as $val){
                                    echo "<option value='{$val}'>{$val}</option>";
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 padlft-non padrht-non1">
                            <div class="form-group">
                                <label class="" for="start"><?php echo __('Start Date');?>:</label>
                                <input type="text" name="start" id="start"  value="" class="datepicker form-control" readonly="true"/>
                                <input type="checkbox" id="startIsMilestone" class="noprint"/>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 padlft-non padrht-non">
                            <div class="form-group">
                                <label class="" for="end"><?php echo __('Due Date');?>:</label>
                                <input type="text" name="end" id="end" value="" class="datepicker form-control" readonly="true"/>
                                <input type="checkbox" id="endIsMilestone" class="noprint"/>
                            </div>
                        </div>
                        <div class="col-sm-6 padlft-non padrht-non1 hidden"><div class="row gantt-input-daterange" id="gantt_input_daterange"><div class="from_to hidden"><?php echo __('to');?></div></div></div>
                        <div class="cb"></div>
                        <input type="hidden" value="" name="easycase_uid" id="easycase_uid"  readonly="readonly"/>
                        <input type="hidden" value="" name="easycase_id" id="CSeasycaseid" readonly="readonly" />
                        <input type="hidden" value="" name="editRemovedFile" id="editRemovedFile" readonly="readonly" />
                        <input type="hidden" name="hid_http_images" id="hid_http_images" value="<?php echo HTTP_IMAGES; ?>" readonly="true" />
                    </div>
                </div>
                <div class="modal-footer popup-footer" style="padding:17px 25px;">
                    <div class="fr">
                        <span id="btn"><span class="btn btn-default btn_hover_link cmn_size"><a class="close_popup_btn"><?php echo __('Cancel');?></a></span></span>
                        <button id="saveButton" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    case_quick('', 'more_opt5_v2');

    //$("#CS_type_id").val(getSelectedValue("opt1_v2"));
    $('#opt2_v2').parent('div').addClass('dropdown wid');
</script>