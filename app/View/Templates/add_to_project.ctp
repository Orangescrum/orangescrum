<?php $caseCount = count($temp_dtls_cases); ?>
<?php if ($caseCount > 0) { ?>
    <div class="modal-body popup-container">
        <div class="form-group label-floating pop-custom-fld">
            <div>
                <div class="fl input-group width100">
                    
                    <select name="" id="proj_id" class="select form-control floating-label" placeholder="<?php echo __('Choose a project');?>" data-dynamic-opts=true>
                        <?php if (count($project_details)) { ?>
                            <option value="0" selected><?php echo __('Select Project');?></option>
                            <?php foreach ($project_details as $project_details) { ?>
                                <option value="<?php echo $project_details['Project']['id']; ?>"><?php echo $this->Format->formatText($project_details['Project']['name']); ?></option>
                            <?php } ?>                            
                        <?php } else { ?>
                            <option value="0" selected>[<?php echo __('Select');?>]</option>
                        <?php } ?>
                    </select>
                    <span class="input-group-btn pop-bulb">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                            <i class="material-icons">&#xE90F;</i>
                        </button>
                    </span>
                </div>
                <div class="fl width-30 below_tsk_p">
                    <p class="blue-txt"><?php echo __('Below Tasks will be added to the selected project');?>.</p>
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <div class="popup-inner-container">
            <h6 id="tmpl_txt" class="ellipsis-view"><?php echo __('Below are the tasks of "new lunch" templete');?></h6>
            <input type="hidden" id="templateId" value="<?php echo $template_id; ?>"/>
            <div class="scrl-ovr">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="25%"><?php echo __('Title');?></th>
                            <th width="25%"><?php echo __('Description');?></th>
                            <th width="15%"><?php echo __('Task Type');?></th>
                            <th width="15%"><?php echo __('Assign To');?></th>
                            <th width="10%"><?php echo __('Priority');?></th>
                            <th width="10%"><?php echo __('Est Hr');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 0;
                        $class = "";
                        foreach ($temp_dtls_cases as $val) {
                            $counter++;
                            $class = ($counter % 2 == 0) ? "row_col" : "row_col_alt";
                            ?>

                            <tr id="listing<?php echo $counter; ?>" class="">	
                                <td  width="25%">
                                    <p><?php echo $this->Format->formatTitle($this->Format->formatCms($val['ProjectTemplateCase']['title'])); ?></p>
                                </td>
                                <td width="25%">
                                    <p>
                                        <?php echo $val['ProjectTemplateCase']['description'] != '' ? $val['ProjectTemplateCase']['description'] : '---'; ?>
                                    </p>
                                </td>
                                <td>
                                    <?php 
                                    $typename = "Development";
                                    foreach($GLOBALS['TYPE'] as $k=>$v){
                                        if($v['Type']['id'] ==  $val['ProjectTemplateCase']['task_type']){
                                            $typename = $v['Type']['name'];
                                        }

                                    }
                                    $story_point = ($typename == 'Story')?" <span class='bkStorPont_PT' title='Story Point'>".$val['ProjectTemplateCase']['story_point']."</span>":"";
                                    echo $typename .$story_point;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $Assignname = 'Unassigned';
                                    foreach($QT_assigns as $k=>$v){
                                     if($v['id'] == $val['ProjectTemplateCase']['assign_to']){
                                        $Assignname = $v['name'];
                                     }  
                                    }
                                    echo $Assignname;
                                    ?>
                                </td>
                                <td>
                                    <?php $prio = "high";
                                    if($val['ProjectTemplateCase']['priority'] ==2){
                                        $prio = 'low';
                                    }else if($val['ProjectTemplateCase']['priority'] ==1){
                                        $prio = 'medium';
                                    }
                                    ?>
                                    <span class=" prio_<?php echo $prio?> prio_lmh prio_gen prio-drop-icon" rel="tooltip" original-title="Priority:<?php echo $prio; ?>"></span>
                                </td>
                                <td>
                                    <?php echo $this->Format->format_time_hr_min($val['ProjectTemplateCase']['estimated'],'hrmin');?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span id="addtaskloader" class="ldr-ad-btn">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <div id="taskAddBtns">
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="confirmusercls"  class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="add_cases_project()"><?php echo __('Add');?></a></span>
								<div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
<?php } else { ?>
    <div class="modal-body popup-container">
        <p class="no_rec_note" id="addtaskloader"><?php echo __('No task on template');?></p>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span class="fl hover-pop-btn"><a href="javascript:void(0)"   class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info"onclick="addTempToTask('<?php echo $template_id; ?>', '', 1)"><?php echo __('Add Task to Template');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
<?php } ?>