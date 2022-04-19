<div class="form-group"  id="tr_members">

    <div id="div_members">
        <select name="data[Easycase][members]" class="select form-control floating-label" placeholder="<?php echo __('Members');?>" data-dynamic-opts=true>
            <option value="all"><?php echo __('All');?></option>
            <?php if (isset($memArr)) { ?>
                <?php foreach ($memArr as $mem) { ?>
                    <?php $members = explode("-", $_COOKIE['MEMBERS']); ?>
                    <option value="<?php echo $mem['User']['id']; ?>" <?php if (in_array($mem['User']['id'], $members)) { ?>selected="selected"<?php } ?>><?php echo ucfirst($mem['User']['name']); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group" id="tr_assign_to">
    <div id="div_assign_to">
        <select name="data[Easycase][assign_to]" class="select form-control floating-label" placeholder="<?php echo __('Assign to');?>" data-dynamic-opts=true>
            <option value="all"><?php echo __('All');?></option>
            <?php if (isset($asnArr)) { ?>
                <?php foreach ($asnArr as $Asn) { ?>
                    <?php $Asnbers = explode("-", $_COOKIE['ASSIGNTO']); ?>
                    <option value="<?php echo $Asn['User']['id']; ?>" <?php if (in_array($Asn['User']['id'], $Asnbers)) { ?>selected="selected"<?php } ?>><?php echo ucfirst($Asn['User']['name']); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>