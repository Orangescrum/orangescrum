<style>
    .availableTable{width:100%;}
    .availableTable td , .availableTable th {font-size:13px; padding:5px 0;border-bottom: 1px solid #ebeff2;}
    .availableTableInner td{border-bottom:none;padding:3px 0;}
    .user-role{color:#f6911d;}
</style>
<p style="color:red;margin-top:0" class="font13"><?php echo __('The assigned user is not available fully on the date specified. User will be next available on the following dates');?></p>
<p style="color:green;margin-top:0" class="font13"><?php echo __('Other available resources are as follows');?>:</p>
<div id="avldiv" style="max-height:350px;overflow-y:scroll;">
<table cellspacing='15' cellpadding='15' class="availableTable">
    <tr class="availableTabletr">
        <th style="width:10%;"></th>
        <th  style="width:50%;"><?php echo __('Resource');?></th>
        <th style="width:30%;"><?php echo __('Available Date & Hours');?>
            <input type="hidden" id="task_assigned_id" value ="<?php echo $assigned_Resource_id; ?>"> 
            <input type="hidden" id="task_id" value ="<?php echo $caseId; ?>"> 
            <input type="hidden" id="task_uniq_id" value ="<?php echo $caseUniqId; ?>"> 
            <input type="hidden" id="task_project_id" value ="<?php echo $project_id; ?>"> 
            <input type="hidden" id="task_gantt_start_date" value ="<?php echo $gantt_start_date; ?>"> 
            <input type="hidden" id="task_due_date" value ="<?php echo $task_due_date; ?>"> 
            <input type="hidden" id="task_estimated_hr" value ="<?php echo $estimated_hours; ?>"> 
            <input type="hidden" id="parenttaskId" value ="<?php echo $parenttaskId; ?>"> 
        </th>
    </tr>
    <?php foreach($ResourceNextAvailableDate as $k => $usrdata){
        ?>
    <tr <?php if($k == $assigned_Resource_id){echo "class='checkedtd'";}?>>
        <td valign="top"><input type="radio" id="choseResource_<?php echo $k; ?>" data-caseId="<?php echo $caseId; ?>" data-caseUniqId="<?php echo $caseUniqId; ?>" data-projectId ="<?php echo $project_id; ?>" data-resource="<?php echo $k; ?>" data-gantt-start-date='<?php echo $gantt_start_date;?>' data-est-hour='<?php echo $estimated_hours;?>' name="resource" <?php if($k == $assigned_Resource_id){echo "checked";}?>/></td>
        <td valign="top"><?php echo $k == SES_ID ? 'Me' : $usrdata['name']; ?> <span class="user-role">( <?php echo $usrdata['role']; ?> )</span>
        <?php 
        $userCount=count($usrdata['skill']);
        $seeMore=$userCount - 1;
              if(!empty($userCount)){ ?>
             <span class="dtl_label_tag"><?php echo $usrdata['skill'][0]['Skill']['name']; ?> </span>
        <?php if($userCount > 1){ ?>
            <span id="tour_proj_crtdon" title="<?php echo $usrdata['skillList'];?>" rel="tooltip" class="backlog-ellipsis dtl_label_tag">See <?php echo $seeMore; ?>+</span>
            <?php } } ?>
        <td colspan="2">
            <table cellspacing='15' cellpadding='15' class="availableTableInner">
                <?php 
        foreach ($usrdata['AvailableHours']['next_available_dates'] as $key => $value) {?>
                <tr>
                    <td style="color:green;padding-right:30px;"><?php echo date('M d,Y',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value['date'], "datetime")));?></td>
                    <td style="color:green;"><?php echo round($value['Avlhrs'],2)." Hr";?></td>
    </tr>
    <?php } ?>
</table>
        </td>      
    </tr>
    <?php } ?>
</table>
</div>
<div style="text-align:center;padding-top:30px;">
    <span id="cust_loader_tsk_avl" style="display:none;">
        <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
    </span>
    <span id="btn_tsk_avl">
        <button type="button" value="Change" class="btn btn-info cmn_bg btn_cmn_efect cmn_size prev-btn" id="btn_resource" onclick="changeUnavailableResource()"><i class="icon-big-tick"></i><?php echo __('Change');?></button>
        <span class="or_cancel cancel_on_direct_pj"><span style="font-size: 13px; padding:0 10px;"><?php echo __('or');?></span> <a onclick="closeChangeResourcePopup();" class="btn btn-info cmn_bg btn_cmn_efect cmn_size prev-btn"><?php echo __('Create Any Way');?></a></span>
    </span>

</div>

<script>
    $(document).ready(function(){
        var stp = $(".checkedtd").clone();
        $('.availableTable').find(".checkedtd").remove();
        //$('.availableTable').prepend(stp);
        stp.insertAfter($('.availableTabletr'));
    });
</script>