
<div class="modal-dialog feeback_modal">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="bnr_header">
				<?php echo __("Cool, we'd love to hear from you");?> !
				<p><?php echo __("Contact us 24/7 via email at");?> <a href="mailto:support&#64;orangescrum&#46;com">support&#64;orangescrum&#46;com</a><br/><?php echo __('Or By filling the form below');?>.</p>
			</div>
			<form id="feedback-form" methdo="post">
				<h5><?php echo __("Overall Rating");?></h5>
				<div class="star" style="display:inline-block;">
                                    <i class="material-icons str_5" onclick="setStarVal(5);">&#xE838;</i>
                                    <i class="material-icons str_4" onclick="setStarVal(4);">&#xE838;</i>
                                    <i class="material-icons str_3" onclick="setStarVal(3);">&#xE838;</i>
                                    <i class="material-icons str_2" onclick="setStarVal(2);">&#xE838;</i>
                                    <i class="material-icons str_1" onclick="setStarVal(1);">&#xE838;</i>
				</div>
				<input type="hidden" value="" id="feedback_star" /> 
				<textarea placeholder="<?php echo __('Enter Your Feedback Here');?>" id="feedback_textarea" onkeyup="enableFeedbackBTN();" ></textarea>
				<div>
					<span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link" data-dismiss="modal" onclick="closePopup();clearFeedbackData();"><?php echo __('Cancel');?></button></span>
					<input type="button" id="feedback_submit" value="<?php echo __('Submit');?>" class="submit_btn" onclick="saveFeedbackData();" />
					<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
					<p style="font-size: 14px;">Or</p>
					
					<p style="font-size: 13px;" class="loader_dv_ext_usr_p"><?php __("Need more time to explore the possibilities");?>? <a href="javascript:void(0);" onclick="extendTrialByUser();"><?php echo __("Extend trial for");?> <?php echo EXTEND_TRIAL_USER_DAYS; ?> <?php echo __("days");?></a>.</p>
					<div class="loader_dv_ext_usr" style="display:none;"><span><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="<?php echo __('Loading');?>..." title="<?php echo __('Loading');?>..." /></center></span></div>
					<?php } ?>
				</div>
			</form>
		</div>
	</div>