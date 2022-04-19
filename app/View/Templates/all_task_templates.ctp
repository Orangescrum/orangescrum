<style>
.value {display:none;}
.q-icon{ background: rgba(0, 0, 0, 0) url("<?php echo HTTP_ROOT;?>img/q_icon.png") no-repeat 0 0;
    display: inline-block;
    height: 16px;
    position: absolute;
    right: 2px;
    top: 25px;
    width: 16px;
    background-size: 15px 14px;}
</style>
<?php if (isset($proj) && $proj == 'proj') { ?>
<div class="select2__wrapper">
    <select name="data[Project][task_type]" id="new_template_crt_tmpl"  class="form-control floating-label new_template_crt_tmpl" placeholder="<?php echo __('Choose a default task type');?>">
        <option value="0"><?php echo __('Select Default Task Type');?></option>
        <?php foreach ($task_list as $k => $task) { ?>
            <option value="<?php echo $k; ?>" <?php if (isset($task) && $task == $k) { ?> selected="selected" <?php } ?>><?php echo ucwords($task); ?></option>
        <?php } ?>
    </select>
</div>
<div class="cmn_help_select"></div>
<a href="javascript:void(0);" class="onboard_help_anchor all-proj-task" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/what-is-a-task-type/<?= HELPDESK_URL_PARAM ?>#task_type');" title="<?php echo __('Get quick help on Task Type');?>" rel="tooltip" ><span class="help-icon"></span></a>
<?php } ?>