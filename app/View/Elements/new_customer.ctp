<div class="modal-body popup-container">
    <center><div id="cust_err_msg" class="err_msg"></div></center>
    <?php echo $this->Form->create('Customer', array('url' => '/invoices/add_customer', 'name' => 'frm_add_customer', 'id' => 'frm_add_customer')); ?>
    <?php print $this->Form->input('customer_id', array('label' => false, 'type' => 'hidden', 'id' => 'cust_id', 'value' => '')); ?>
    <div class="data-scroll new_customer">
        <div  class="row">
            <div class="col-lg-12 padlft-non padrht-non">
                <div class="col-lg-2 col-sm-2 col-xs-2">
                    <div class="form-group label-floating task-form-group">
                        <label class="control-label" for="cust_title"><?php echo __('Title');?></label>
                        <?php echo $this->Form->text('cust_title', array('value' => '', 'class' => 'form-control', 'id' => 'cust_title', 'placeholder' => "", 'maxlength' => '10')); ?>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-5 col-xs-5">
                    <div class="form-group label-floating task-form-group">
                        <label class="control-label" for="cust_lname"><?php echo __("Customer's first name");?></label>
                        <?php echo $this->Form->text('cust_fname', array('value' => '', 'class' => 'form-control fl', 'id' => 'cust_fname', 'placeholder' => "", 'maxlength' => '100')); ?>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-5 col-xs-5">
                    <div class="form-group label-floating task-form-group">
                        <label class="control-label" for="inputLarge"><?php echo __("Customer's last name");?></label>
                        <?php echo $this->Form->text('cust_lname', array('value' => '', 'class' => 'form-control fr', 'id' => 'cust_lname', 'placeholder' => "", 'maxlength' => '100')); ?>
                    </div>
                </div>
                <div class="err_msg col-lg-12" style="text-align:left;" id="cust_name_err"></div>
            </div>
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="cust_email"><?php echo __("Specify customer's email id");?></label>
            <?php echo $this->Form->text('cust_email', array('value' => '', 'class' => 'form-control', 'id' => 'cust_email', 'placeholder' => "")); ?>
        </div>
        <div class="custom-task-fld assign-to-fld cstmpop-select-label labl-rt add_new_opt select_placeholder" id="sel_cust_currency">
            <?php echo $this->Form->input('cust_currency', array('options' => $this->Format->currency_opts(), 'empty' => false, 'class' => 'select form-control floating-label', 'id' => 'cust_currency', 'placeholder' => __("Specify currency"), 'data-dynamic-opts' => 'true', 'label' => false)); ?>
        </div>
        <div class="form-group label-floating customer_options" style="display:none;">
            <label class="control-label" for="cust_organization"><?php echo __("Specify customer's organization");?></label>
            <?php echo $this->Form->text('cust_organization', array('value' => '', 'class' => 'form-control', 'id' => 'cust_organization', 'placeholder' => "")); ?>
        </div>
        <div class="form-group label-floating customer_options" style="display:none;">
            <label class="control-label" for="focusedInput1"><?php echo __('Specify Street');?></label>
            <?php echo $this->Form->text('cust_street', array('value' => '', 'class' => 'form-control fl', 'id' => 'cust_street', 'placeholder' => "")); ?>
        </div>
        <div class="row customer_options" style="display:none;">
            <div class="col-lg-12 padlft-non padrht-non">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="cust_city"><?php echo __('Specify city');?></label>
                        <?php echo $this->Form->text('cust_city', array('value' => '', 'class' => 'form-control fl', 'id' => 'cust_city', 'placeholder' => "")); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="cust_state"><?php echo __('Specify state');?></label>
                        <?php echo $this->Form->text('cust_state', array('value' => '', 'class' => 'form-control fr', 'id' => 'cust_state', 'placeholder' => "")); ?>
                    </div>
                </div>
								<div class="cb"></div>
            </div>
        </div>
        <div class="row customer_options" style="display:none;">
            <div class="col-lg-12 padlft-non padrht-non">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="cust_country"><?php echo __('Specify country');?></label>
                        <?php echo $this->Form->text('cust_country', array('class' => 'form-control fl', 'id' => 'cust_country', 'placeholder' => "")); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="cust_zipcode"><?php echo __('Specify postal code');?></label>
                        <?php echo $this->Form->text('cust_zipcode', array('class' => 'form-control fr', 'id' => 'cust_zipcode', 'placeholder' => "", 'maxlength' => '10')); ?>
                    </div>
                </div>
								<div class="cb"></div>
            </div>
        </div>
        <div class="row customer_options" style="display:none;">
            <div class="col-lg-12 padlft-non padrht-non">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="cust_phone"><?php echo __('Specify phone number');?></label>
                        <?php echo $this->Form->text('cust_phone', array('value' => '', 'class' => 'form-control fl', 'id' => 'cust_phone', 'placeholder' => "", 'maxlength' => '20')); ?>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6"></div>
									<div class="cb"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="checkbox">
                    <label>
                        <?php echo $this->Form->checkbox('cust_status', array('hiddenField' => false, 'value' => 'Inactive', 'id' => 'cust_status')); ?>
                        <span class="new_customer_chk_lbl"><?php echo __('Make Inactive');?></span>
                    </label>
                </div>
                <div class="cb"></div>
                <a class="fl anchor" style="color:#006699;font-size: 14px;" id="more_customer_options">+ <?php echo __('Details');?></a>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="fr popup-btn add-tmp-btn">
        <span id="cust_loader" style="display:none;">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
        </span>
        <span id="btn_cust_add">
            <span class="fl cancel-link">
                <button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button>
            </span>
            <span class="fl hover-pop-btn">
                <button type="button" value="Add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" id="btn_add_customer"><?php echo __('Create');?></button>
            </span>
            <div class="cb"></div>
        </span>
    </div>
</div>
<?php echo $this->Form->end(); ?>