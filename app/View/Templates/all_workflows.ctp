<?php if($type == 'status'){ ?>
<div class="select2__wrapper">
    <select name="data[Project][status_group_id]" id="new_status_crt" class="form-control floating-label new_status_crt" placeholder="<?php echo __('Choose a workflow');?>">
        <?php /* <option value="0"><?php echo __('Default Status Workflow');?></option> */ ?>
        <?php foreach ($templates as $k => $template) { ?>
            <option value="<?php echo $k; ?>"><?php echo ucwords($template); ?></option>
        <?php } ?>       
    </select>
</div>
<?php } else{ ?>
<div class="select2__wrapper">
    <select name="data[Project][defect_status_group_id]" id="bug_new_status_crt" class="form-control floating-label new_status_crt" placeholder="<?php echo __('Choose a workflow for bug');?>">
        <?php /* <option value="0"><?php echo __('Default Status Workflow');?></option> */ ?>
        <?php foreach ($templates as $k => $template) { ?>
            <option value="<?php echo $k; ?>"><?php echo ucwords($template); ?></option>
        <?php } ?>       
    </select>
</div>
<?php } ?>
