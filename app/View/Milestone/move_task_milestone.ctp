<div class="modal-body popup-container">
    <div class="scrl-ovr">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
            <tr class="hdr_tr">
                <th></th>
                <th style="width:60%;"><?php echo __('Task Group');?></th>
                <th><?php echo __('Start Date');?></th>
                <th><?php echo __('End Date');?></th>
            </tr>
            <?php
            $caseCount = count($milestones);
            $empty_dates = array('','0000-00-00', '0000-00-00 00:00:00');
            if ($caseCount) {
                foreach ($milestones as $getdata) {
                    $mlstAutoId = $getdata['Milestone']['id'];
                    $frmt_data = $this->Format->formatText(ucfirst($getdata['Milestone']['title']));
                    $milestoneTitle = $this->Format->convert_ascii($frmt_data);
                    $start_date = __('Not Assigned',true);
                    $end_date = __('Not Assigned',true);
                    if (!in_array($getdata['Milestone']['start_date'], $empty_dates)) {
                        $st_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Milestone']['start_date'], "date");
                        $end_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Milestone']['end_date'], "date");
                        $start_date = date('D, M j Y', strtotime($st_dt));
                        $end_date = date('D, M j Y', strtotime($end_dt));
                    }
                    $count++;
                    if ($count % 2 == 0) {
                        $class = "row_col";
                    } else {
                        $class = "row_col_alt";
                    }
                    ?>
                    <tr id="mvtask_listings<?php echo $count; ?>" class="rw-cls <?php echo $class; ?>">	
                        <td align="left">
                            <div class="radio radio-primary mrg0">
                                <label>
                                    <input type="radio" class="radio_cur ad-mlstn" id="actradio<?php echo $count; ?>" value="<?php echo $mlstAutoId; ?>" data-sprint-status="<?php echo $getdata['Milestone']['is_started']; ?>" name="milestone_radio" <?php if ($mlstid == $mlstAutoId && $mlstAutoId != 0 || $caseCount == 1) { ?>checked='true'<?php } ?>/>
                                </label>
                            </div>
                            <input type="hidden" id="mvtask_actionClss<?php echo $count; ?>" value="0"/>
                        </td>
                        <td>
                            <label for="actradio<?php echo $count; ?>" class="ad_cs mv_tsk_mlstn" title="<?php echo $this->Format->formatTitle($milestoneTitle); ?>">
                                <?php echo $this->Format->formatTitle($milestoneTitle); ?></label>
                        </td>
                        <td> <?php echo $start_date; ?></td>
                        <td> <?php echo $end_date; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr valign="middle">
                    <td colspan="7" align="center">
                <center class="fnt_clr_rd"><?php echo __('No Task Group(s) available');?>.</center>
                </td>
                </tr>
            <?php } ?>
        </table>
        <?php $proj_name = $this->Casequery->getProjectName($project_id); ?>
        <input type="hidden" id="mvtask_project_id" value="<?php echo $project_id; ?>" />
        <input type="hidden" id="mvtask_proj_name" value="<?php echo $this->Format->formatText($proj_name['Project']['name']); ?>" />
        <input type="hidden" id="ext_mlst_id" value="<?php echo $mlstid; ?>" />
        <input type="hidden" id="mvtask_id" value="<?php echo $mlst_id; ?>" />
        <input type="hidden" id="mvtask_task_no" value="<?php echo $task_no; ?>" />
        <input type="hidden" id="mvtask_cnt" value="<?php echo $caseCount; ?>" />
    </div>
</div>

<div class="modal-footer add-mlstn-btn" style="display: none;">
    <div class="fr popup-btn">
        <span id="tskloader" style="display: none;">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
        </span>
        <div id="mvtask_confirmbtn" style="display:block;">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup('mvtask');"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="mvtask_movebtn" onclick="switchTaskToMilestone(this);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Move Task');?></a></span>
						 <div class="cb"></div>
        </div>
    </div>
		 <div class="cb"></div>
</div>