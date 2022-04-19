<div class="setting_wrapper task_listing send-email-notify-page">
    <h3><?php echo __('Send me Email Notification');?></h3>
    <?php echo $this->Form->create('UserNotification', array('url' => '/users/email_notifications', 'onsubmit' => "return hideupdatebtn();")); ?>
    <input type="hidden" name="data[UserNotification][id]" value="<?php echo @$getAllNot['UserNotification']['id']; ?>"/>
    <input type="hidden" name="data[UserNotification][type]" value="1"/>
    <div class="pririty-fld labl-rt add_new_opt create_priority mtop30">
        <div class="row form-group pri-div">
            <label class="col-lg-3 control-label padlft-non"><p><?php echo __('All New Task');?></p></label>
            <div class="col-lg-9 padlft-non">
                <div class="radio radio-primary">
                    <label><input type="radio" title="<?php echo __('Send me All New Task emails');?>" rel="tooltip" name="data[UserNotification][new_case]" id="newcaseyes" value="1" <?php echo (@$getAllNot['UserNotification']['new_case'] == 1) ? 'checked="checked"' : "";?> /><?php echo __('Yes');?></label>
                    <label><input type="radio" title="<?php echo __('Send me New Task email, only when I am selected to get the email');?>" rel="tooltip" name="data[UserNotification][new_case]" id="newcaseno" value="0" <?php echo (@$getAllNot['UserNotification']['new_case'] == 0) ? 'checked="checked"' : "";?> /><?php echo __('No');?></label>
               </div>
            </div>
        </div>
        <div class="row form-group pri-div">
            <label class="col-lg-3 control-label padlft-non"><p><?php echo __('All Task Reply & Comment');?></p></label>
            <div class="col-lg-9 padlft-non">
                <div class="radio radio-primary">
                    <label><input type="radio" title="<?php echo __('Send me All Reply emails');?>" rel="tooltip" name="data[UserNotification][reply_case]" id="replycaseyes" value="1" <?php echo (@$getAllNot['UserNotification']['reply_case'] == 1) ? 'checked="checked"' : "";?> /><?php echo __('Yes');?></label>
                    <label><input type="radio" title="<?php echo __('Send me Reply email, only when I am selected to get the email');?>" rel="tooltip" name="data[UserNotification][reply_case]" id="replycaseno" value="0" <?php echo (@$getAllNot['UserNotification']['reply_case'] == 0) ? 'checked="checked"' : "";?> /><?php echo __('No');?></label>
                </div>
            </div>
        </div>
        <div class="row form-group pri-div">
            <label class="col-lg-3 control-label padlft-non"><p><?php echo __('All Task Status Change');?></p></label>
            <div class="col-lg-9 padlft-non">
                <div class="radio radio-primary">
                    <label><input type="radio" title="<?php echo __('Send me All Status Update emails');?>" rel="tooltip" name="data[UserNotification][case_status]" id="casestatusyes" value="1" <?php echo (@$getAllNot['UserNotification']['case_status'] == 1) ? 'checked="checked"' : "";?> /><?php echo __('Yes');?></label>
                    <label><input type="radio" title="<?php echo __('Send me Status Update email, only when I am selected to get the email');?>" rel="tooltip" name="data[UserNotification][case_status]" id="casestatusno" value="0" <?php echo (@$getAllNot['UserNotification']['case_status'] == 0) ? 'checked="checked"' : "";?> /><?php echo __('No');?></label>
                </div>
            </div>
        </div>
        <div class="row form-group pri-div">
            <label class="col-lg-3 control-label padlft-non"><p><?php echo __('All Mention in Task and Comment');?></p></label>
            <div class="col-lg-9 padlft-non">
                <div class="radio radio-primary">
                    <label><input type="radio" title="<?php echo __('Send me emails when ever i am mentioned in task and comment');?>" rel="tooltip" name="data[UserNotification][mention_case]" id="casestatusyes" value="1" <?php echo (@$getAllNot['UserNotification']['mention_case'] == 1) ? 'checked="checked"' : "";?> /><?php echo __('Yes');?></label>
                    <label><input type="radio" title="<?php echo __('Send me emails when ever i am mentioned in task and comment');?>" rel="tooltip" name="data[UserNotification][mention_case]" id="casestatusno" value="0" <?php echo (@$getAllNot['UserNotification']['mention_case'] == 0) ? 'checked="checked"' : "";?> /><?php echo __('No');?></label>
                </div>
            </div>
        </div>
    </div>
    <?php if (defined('NODEJS_HOST') && trim(NODEJS_HOST)) { ?>
        <h3 class="cmn_h2"><?php echo __('Show me Notification');?></h3>
        <div class="pririty-fld labl-rt add_new_opt create_priority mtop30">
            <div class="row form-group pri-div">
                <label class="col-lg-3 control-label padlft-non"><p><?php echo __('Enable Desktop Notification');?></p></label>
                <div class="col-lg-9 padlft-non">
                    <div class="radio radio-primary">
                        <label><input type="radio" name="data[User][desk_notify]"  id="desknotifyyes" value="1" <?php echo ((int) DESK_NOTIFY == 1) ?'checked="checked"' : "";?> onclick="allowChromeDskNotify(this.checked);" /><?php echo __('Yes');?></label>
                        <label><input type="radio" name="data[User][desk_notify]"  id="desknotifyno" value="0" <?php echo ((int) DESK_NOTIFY == 0) ? 'checked="checked"' : "";?> /><?php echo __('No');?></label>
                    </div>
                </div>
            </div>
            <div class="weekly_btm_sumry">
             <p><?php echo __('Browser version supporting Desktop Notification');?>,</p>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="browse-compat">
                        <li> <?php echo __('Firefox 22 and above');?></li>
                        <li><?php echo __('Chrome 32 and above');?></li>
                        <li><?php echo __('Above Safari 6 on Mac OSX 10.8+');?></li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="cb"></div>
    <?php } ?>

      <div class="mtop30">
              <div class="btn_row fr">
                  <div id="subprof1">
                      <input type="hidden" name="data[User][changepass]" id="changepass" readonly="true" value="0"/>
                      <div class="fl"><a class="btn btn-default btn_hover_link cmn_size" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></a></div>
											<div class="fl btn-margin"><button type="submit" value="Save" name="submit_Pass"  id="submit_Pass" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Update');?></button></div>
					<div class="cb"></div>
                  </div>
                  <span id="subprof2" style="display:none">
                      <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                  </span>
              </div>
          <div class="cb"></div>
        </div>
    <?php echo $this->Form->end(); ?>
</div>