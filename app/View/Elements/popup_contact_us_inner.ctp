<div class="modal-dialog <?php if ($this->Session->read('Auth.User.id')) { ?>wrapper_after<?php } else { ?>wrapper_before<?php } ?>">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="popup_close();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Contact our sales team');?></h4>
        </div>
        <?php echo $this->Form->create('price', array('url' => array('controller' => 'users', 'action' => 'pricing'), 'autocomplete' => 'off', 'id' => 'ContactUsForm')); ?>
        <div class="modal-body popup-container">
            <input type="hidden" value="0" name="check_click" id="check_click"/>
            <input id="hid_captcha"  name="hid_captcha" value="0" type="hidden"/>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="f_name"><?php echo __('Name');?></label>
                <?php echo $this->Form->input('name', array('value' => $userdetails['User']['name'], 'id' => 'f_name', 'class' => 'form-control', 'maxlength' => '20', 'label' => false)); ?>
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="email_id"><?php echo __('Email address');?></label>
                <?php echo $this->Form->input('email', array('type' => 'text', 'value' => $userdetails['User']['email'], 'label' => false, 'id' => 'email_id', 'class' => 'form-control', 'maxlength' => '45')); ?> 
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="mask_phone"><?php echo __('Phone');?>#</label>
                <?php echo $this->Form->input('ph_no', array('label' => false, 'type' => 'text', 'id' => 'mask_phone', 'class' => 'span10 profile_sel', 'class' => 'form-control', 'maxlength' => '15')); ?>
            </div>
						<?php $arrSize=array("100-250"=>"100-250","250-1500"=>"250-1500","1500+"=>"1500+");?>
						<div class="pr cmn-fg5 form-group label-floating form-group-lg">
							<label class="popup_label control-label" for="login_name">Company Size:</label>
							<?php echo $this->Form->input('company_size', array('options'=>$arrSize,'label' => false,'id' => 'company_size','class' => 'form-control1', 'empty'=>'Select')); ?>
						</div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="hlp"><?php echo __('How can we help you');?>?</label>
                <?php echo $this->Form->input('help', array('type' => 'textarea', 'cols' => '30', 'rows' => '1', 'label' => false, 'div' => false, 'value' => '', 'id' => 'hlp', 'class' => 'form-control expand hideoverflow')); ?>
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="js_captcha"><?php echo __('Enter Sum of');?> <span id="showcaptcha"></span></label>
                <input id="js_captcha" maxlength="50" name="js_captcha" class="form-control txt" type="text"/>
                <div class="error" for="type" generated="true" id="cpt_err"></div>
                <p class="help-block">(<?php echo __("Help us to make sure you're not a robot");?>.)</p>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="contactus_loader" class="fr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/></span>
                <span id="contactus_btn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn-sm reset_btn" data-dismiss="modal" onclick="popup_close();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><button type="submit" value="Submit"  id="submit" class="btn btn-sm btn-raised btn_cmn_efect cmn_bg btn-info loginactive1" onclick="return validate();"><?php echo __('Submit');?></button></span>
                </span>
                <div class="cb"></div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>