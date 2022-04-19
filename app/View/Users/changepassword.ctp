<?php
if (!defined('NO_PASSWORD')) {
    $user = ClassRegistry::init('User')->findById(SES_ID);
    if (!empty($user['User']['password'])) {
        define('NO_PASSWORD', 0);
    } else {
        define('NO_PASSWORD', 1);
    }
}
?>
<div class="setting_wrapper task_listing cmn_tbl_widspace width_hover_tbl changepassword-page">
<div class="row">
<div class="col-lg-12">
    <div class="col-lg-6 col-sm-6 padlft-non">
        <?php if (SES_ID != 515 && SES_ID != 516) { ?>
            <?php echo $this->Form->create('User', array('url' => '/users/changepassword', 'onsubmit' => "return checkPasswordMatch('pas_new','pas_retype','old_pass'," . NO_PASSWORD . ")", 'autocomplete' => 'off')); ?>
            <input type="hidden" name="data[User][changepass]" id="changepass" readonly="true" value="0"/>
			 <input type="hidden" name="data[User][csrftoken]" class="csrftoken" readonly="true" value="" />

            <div class="form-group form-group-lg label-floating" style="display:<?php echo (NO_PASSWORD) ? 'none;' : 'block;'; ?>">
                <label class="control-label" for="old_pass"><?php echo __('Old Password');?></label>
                <?php echo $this->Form->password('old_pass', array('value' => '', 'class' => 'form-control', 'id' => 'old_pass', 'maxlength' => '30', 'onKeyPress' => 'return noSpace(event)', 'autocomplete' => 'off')); ?>
            </div>

            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="pas_new"><?php echo __('New Password');?></label>
                <?php echo $this->Form->password('pas_new', array('value' => '', 'class' => 'form-control', 'id' => 'pas_new', 'maxlength' => '30', 'onKeyPress' => 'return noSpace(event)')); ?>	
                <div id="hints" style="display: block;"><div><span class="hint">Between 8-30 characters<span class="hint-pointer">&nbsp;</span></span></div></div>
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="pas_retype"><?php echo __('Confirm Password');?></label>
                <?php echo $this->Form->password('pas_retype', array('value' => '', 'class' => 'form-control', 'id' => 'pas_retype', 'maxlength' => '30', 'onKeyPress' => 'return noSpace(event)', 'autocomplete' => 'off')); ?>	
            </div>
					</div>
					<div class="cb"></div>
            <div class="">
                <div class="fr btn_row">
                    <div id="subprof1">
                        <div class="fl btn-margin"><a class="btn btn-default btn-sm cmn_size fr" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></a></div>
												<div class="fl"><button type="button" value="<?php echo (NO_PASSWORD) ? 'Set' : 'Change'; ?>" name="submit_Pass"  id="submit_Pass" class="btn btn-sm btn_cmn_efect cmn_bg btn-info cmn_size fr" onclick="$('#changepass').val('1');checkCsrfToken('UserChangepasswordForm');"><?php echo __('Change');?></button></div>
												<div class="cb"></div>
                    </div>
                    <span id="subprof2" style="display:none">
                        <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                    </span>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        <?php } else { ?>
            <center><?php echo __('Sorry, this is not available in this version');?>.</center>
        <?php } ?>
			</div>
    </div>
</div>
<script>
$(function(){
	setTimeout(function() {$('#hints').html(_('Between 8-30 characters'))},2000);
});
</script>