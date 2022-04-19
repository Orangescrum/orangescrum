<div class="setting_wrapper task_listing send-email-notify-page eu-report-page">
    <div class="pririty-fld labl-rt add_new_opt padrht-non create_priority">
        <?php echo $this->Form->create('UserNotification', array('url' => '/users/email_reports', 'onsubmit' => "return validateemailrpt();")); ?>
        <input type="hidden" name="data[UserNotification][id]" value="<?php echo @$getAllNot['UserNotification']['id']; ?>"/>
        <input type="hidden" name="data[UserNotification][type]" value="1"/>
        <input type="hidden" name="data[User][changepass]" id="changepass" readonly="true" value="0"/>
				<div class="row">
				<div class="col-lg-12 email_report_label">
            <h3><?php echo __('Send me Email Reports');?></h3>
						<div class="ser-label mtop30">
            <?php if (SES_TYPE < 3) { ?>
                <div class="row form-group">
                    <label class="col-md-3 col-sm-3 control-label padlft-non"><p><?php echo __('Weekly Usage');?></p></label>
                    <div class="col-md-9 col-sm-9">
                        <div class="radio radio-primary">
                            <label><input type="radio" name="data[UserNotification][weekly_usage_alert]" id="wkugalyes" value="1" <?php echo (@$getAllNot['UserNotification']['weekly_usage_alert'] == 1) ? 'checked="checked"' : ""; ?> /><?php echo __('Yes');?></label>
                            <label><input type="radio" name="data[UserNotification][weekly_usage_alert]" id="wkugalno" value="0" <?php echo (@$getAllNot['UserNotification']['weekly_usage_alert'] == 0) ? 'checked="checked"' : ''; ?> /><?php echo __('No');?></label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row form-group">
                <label class="col-md-3 col-sm-3 control-label padlft-non"><p><?php echo __('Task Status');?></p></label>
                <div class="col-md-9 col-sm-9">
                    <div class="radio radio-primary">
                        <label><input type="radio" name="data[UserNotification][value]" id="valdaily" value="1" <?php echo (@$getAllNot['UserNotification']['value'] == 1) ? 'checked="checked"' : ""; ?> /><?php echo __('Daily');?></label>
                        <label><input type="radio" name="data[UserNotification][value]" id="valweekly" value="2" <?php echo (@$getAllNot['UserNotification']['value'] == 2) ? 'checked="checked"' : ""; ?> /><?php echo __('Weekly');?></label>
                        <label><input type="radio" name="data[UserNotification][value]" id="valmonthly" value="3" <?php echo (@$getAllNot['UserNotification']['value'] == 3) ? 'checked="checked"' : ""; ?> /><?php echo __('Monthly');?></label>
                        <label><input type="radio" name="data[UserNotification][value]" id="valnone" value="0" <?php echo (@$getAllNot['UserNotification']['value'] == 0) ? 'checked="checked"' : ""; ?> /><?php echo __('None');?></label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-md-3 col-sm-3 control-label padlft-non"><p><?php echo __('Task Due (daily)');?></p></label>
                <div class="col-md-9 col-sm-9">
                    <div class="radio radio-primary">
                        <label><input type="radio" name="data[UserNotification][due_val]" id="dueyes" value="1" <?php echo (@$getAllNot['UserNotification']['due_val'] == 1) ? 'checked="checked"' : ""; ?> /><?php echo __('Yes');?></label>
                        <label><input type="radio" name="data[UserNotification][due_val]" id="dueno" value="0" <?php echo (@$getAllNot['UserNotification']['due_val'] == 0) ? 'checked="checked"' : ""; ?> /><?php echo __('No');?></label>
                    </div>
                </div>
            </div>
						</div>
        </div>
				</div>
				<div>
					<h3><?php echo __('Daily Update Report');?></h3>
				<div class="row mtop30">
				<div class="col-lg-12">
        <div class="col-lg-6 col-sm-6 padlft-non">
            <div class="row form-group">
                <label class="col-md-6 col-sm-6 control-label padlft-non"><p><?php echo __('Send me Email');?></p></label>
                <div class="col-md-6 col-sm-6 ser-label">
                    <div class="radio radio-primary semail-rdo">
                        <label><input type="radio" name="data[DailyupdateNotification][dly_update]"  id="dlyupdateyes" value="1" <?php echo (@$getAllDailyupdateNot['DailyupdateNotification']['dly_update'] == 1) ? 'checked="checked"' : ""; ?> onClick="showbox('show')" /><?php echo __('Yes');?></label>
                        <label><input type="radio" name="data[DailyupdateNotification][dly_update]"  id="dlyupdateno" value="0" <?php echo (@$getAllDailyupdateNot['DailyupdateNotification']['dly_update'] == 0) ? 'checked="checked"' : ""; ?> onClick="showbox('hide')"/><?php echo __('No');?></label>
                    </div>
                </div>
            </div>
            <?php
            if (@$getAllDailyupdateNot['DailyupdateNotification']['dly_update'] == 1) {
                $style = '';
                $hr_min = explode(':', $getAllDailyupdateNot['DailyupdateNotification']['notification_time']);
            } else
                $style = 'style="display:none"';
            ?>
            <div class="row for-option dlyupdt mtop20" <?php echo $style; ?>>
                <div class="col-lg-6 col-sm-6 custom-task-fld time-font">
										<div class="form-group custom-drop-lebel label-floating">
                   <select id="not_hr" name="data[DailyupdateNotification][not_hr]" class="select form-control floating-label" placeholder="Hour <span style='color:red'>*</span>" data-dynamic-opts="true">
                        <option selected="" value="0"><?php echo __('Hour');?></option>
                        <?php
                        for ($i = 1; $i <= 24; $i++) {
                            if ($i <= 9) {
                             //   $i = '0' . $i;
                            }
                            ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $hr_min[0]) echo 'selected'; ?>><?php echo $i <= 9 ?'0'.$i:$i; ?></option>
                        <?php } ?>
                    </select>
									</div>
								</div>
								<div class="col-lg-6 col-sm-6 custom-task-fld time-font">
                <div class="form-group custom-drop-lebel label-floating">
                    <select id="not_mn"  name="data[DailyupdateNotification][not_mn]" class="select form-control floating-label" placeholder="Min <span style='color:red'>*</span>" data-dynamic-opts="true">
                        <option selected="" value="-1"><?php echo __('Min');?></option>
                        <?php
                        for ($i = 0; $i <= 45; $i = $i + 15) {
                            if ($i < 10)
                                //$i = '0' . $i;
                            ?>
                                            <option value="<?php echo $i; ?>"<?php if ($hr_min[1] != 0 && $i == $hr_min[1]) echo 'selected' ; ?>><?php echo $i < 10 ? '0' . $i : $i; ?></option>
                        <?php } ?>
                    </select>
                 </div>
								</div>
            </div>
							<div class="row mtop30">
            <div class="col-lg-12 custom-task-fld time-font">
                <div class="form-group custom-drop-lebel label-floating dlyupdt prj-dlyupdt pr" <?php echo $style; ?>>
                <select name="data[DailyupdateNotification][proj_name]" id="rpt_selprj" class="form-control floating-label" placeholder="Projects" data-dynamic-opts="true">
                    <?php
                    if ($getAllDailyupdateNot['DailyupdateNotification']['proj_name'] != '') {
                        $pjarr = explode(",", $getAllDailyupdateNot['DailyupdateNotification']['proj_name']);
                        if (isset($pjarr[0])) {
                            foreach ($pjarr as $pjtnm) {
                                ?>
                                <option value="<?php echo $pjtnm; ?>" class="selected">
                                    <?php
                                    $prjtnm = $this->Casequery->getProjectName($pjtnm);
                                    echo $prjtnm['Project']['name'];
                                    ?>
                                </option>
                            <?php } ?>                            
                        <?php } else { ?>
                            <option value="<?php echo $pjarr; ?>" class="selected">
                                <?php
                                $prjtnm = $this->Casequery->getProjectName($pjarr);
                                echo $prjtnm['Project']['name'];
                                ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <span id="ajax_loader" style="display:none;position:absolute; right: -25px;top: 59px;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." />
                </span>
                </div>
                </div>
            </div>
					</div>
					<div class="cb"></div>
					<div class="mtop20">
            <div class="btn_row fr">
                <div id="subprof1">
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
        </div>
				</div>
		</div>
    </div>
<script>
    $(document).ready(function() {
        $.material.init();
        $(".select").dropdown({"optionClass": "withripple"});

        getAutocompleteTag("rpt_selprj", "users/getProjects", "480px", "Type to select projects");
		
		if($('#dlyupdateyes').is(':checked'))
		{
			showbox('show');
		}
    });
    function showbox(act) {
        if (act == 'show') {
            $('#dlyupdt,.dlyupdt').slideDown("fast");
        } else {
            $('#dlyupdt,.dlyupdt').slideUp("fast");
        }
    }
</script>
