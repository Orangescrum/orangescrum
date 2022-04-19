<?php /* if (!isset($ajaxlayout)) { ?>
    <div class="setting_wrapper task_listing billing-histroy-page account-activity-page">
        <div class="account_activity_header">
            <h3 class="fl"><?php echo __('Account Activities');?></h3>
            <div class="form-group fr">
                <div class="pr cmn-popup">
                    <?php echo $this->Form->input('activity_type_id', array('id' => 'activity_type_id', 'class' => 'form-control', 'value' => $filter, 'options' => $logtype, 'onchange' => "get_payment_activity(0);")); ?>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
       
        <div id="activity_data" class="mtop10">
<?php } */ ?>	
            <?php
            $t = '';
            if ($logactivity) {
                ?>
								<div class="activity_tbl">
                <table id="activity_tbl"  class="table table-striped">
                    <tbody>
                        <?php
                        foreach ($logactivity as $key => $val) {
                            $cur_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, '', $val['logActivity']['created'], 'datetime');
                            $fb_date = $this->Datetime->facebook_style_date_time($cur_dt, GMT_DATETIME, 'time');
                            ?>
                            <tr>
                                <td><?php echo $this->Format->activity_message($val['logActivity']['json_value'], $val['logActivity']['log_type_id'], $logtype); ?> &nbsp; <i> On  <span  title="<?php echo $fb_date; ?>" ><?php echo date('D, M d, Y h:i a', strtotime($cur_dt)); ?></span></i></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
								</div>
                <input type="hidden" id="getcasecount" value="<?php echo $activityCount; ?>" readonly="true"/>
                <?php if ($activityCount) { ?>
                        <?php 
                        if ($flag) {
                            $second_arg = "," . $comp_id;
                        } else {
                            $second_arg = '';
                        } ?>
                
                    <?php $pagedata = array('mode' => 'php', 'pgShLbl' => $this->Format->pagingShowRecords($activityCount, $page_limit, $page), 'csPage' => $page, 'page_limit' => $page_limit, 'caseCount' => $activityCount, 'pagemode' => 'ajax','callback'=>"get_payment_activity","extraarg"=>$second_arg); ?>
                    <?php echo $this->element("task_paginate",$pagedata);?>
                <?php } ?>
            <?php } else { ?>
                <table class="table table-striped">
                    <tr>
                        <td style="color:red;"> <?php echo __('No activity found');?>.</td>
                    </tr>
                </table>
            <?php } ?>	
<?php /* if (!isset($ajaxlayout)) { ?>
        </div>
    </div>
<?php } ?>
<script>
    $(document).ready(function() {
        $.material.init();
	//$(".select").dropdown({"optionClass": "withripple"});
	$("#activity_type_id").select2();
    });
</script> <?php */ ?>