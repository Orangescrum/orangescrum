<?php $priving_arr_fun = array("subscription", "transaction", "creditcard", "account_activity", "pricing", 'upgrade_member', 'account_usages', 'downgrade', 'edit_creditcard'); ?>
<div class="task-list-bar  project-grid-page" <?php if (in_array(PAGE_NAME, $priving_arr_fun)) { ?>style="display:block;"<?php } ?>>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <ul class="lft_tab_tasklist fl">
                    <li class="<?php if(PAGE_NAME == 'subscription') { ?>active-list<?php }?>">
                        <a href="<?php echo HTTP_ROOT . 'users/subscription'; ?>" id="sett_mail_noti_prof" onclick="return trackEventLeadTracker('Account Setting','Subscription Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE064;</i>
                            <?php echo __('Overview');?>
                        </a>
                    </li>
                    <?php /* <li class="<?php if(PAGE_NAME == 'creditcard' || PAGE_NAME == 'edit_creditcard'){?>active-list<?php } ?>">
                        <a href="<?php echo HTTP_ROOT . 'users/creditcard'; ?>" id="sett_mail_repo_prof" onclick="return trackEventLeadTracker('Account Setting','Credit Card Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE870;</i>
                            <?php echo __('Credit Card');?>
                        </a>
                    </li> */ ?>					
                    <li class="<?php if(PAGE_NAME == 'pricing'){?>active-list<?php } ?>">
                        <a href="<?php echo HTTP_ROOT . 'pricing'; ?>" id="sett_my_comp_prof" onclick="return trackEventLeadTracker('Account Setting','Account Activity Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE86D;</i>
                            <?php echo __('Plan');?>
                        </a>
                    </li>
                    <li class="<?php if(PAGE_NAME == 'transaction'){?>active-list<?php } ?>">
                        <a href="<?php echo HTTP_ROOT . 'users/transaction'; ?>" id="sett_imp_exp_prof" onclick="return trackEventLeadTracker('Account Setting','Transaction Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE915;</i>
                            <?php echo __('Invoices');?>
                        </a>
                    </li>
                </ul>
            </div>
			<?php if(SES_TYPE < 3){ ?>
			<?php $chk_accnt_sts = $this->Format->getAlertText($rem_users, $used_projects_count, $remspace, $used_storage); ?>
			<div class="col-lg-4">
			<?php if($chk_accnt_sts != ''){ ?>
				<div class="warning_circle_icon">
					<i class="material-icons">&#xE000;</i>
					<div class="manage_plan_setting <?php if(isset($_SESSION['show_info']) && $_SESSION['show_info']==1){ $_SESSION['show_info'] =2; ?>idsp<?php } ?>">
						<?php echo $chk_accnt_sts; ?>
						<span class="okey"><?php echo __('Okay');?>!</span>
					</div>
				</div>
			<?php } ?>
			</div>
			<div class="clearfix"></div>
			<?php } ?>
        </div>		
    </div>
</div>

<script type="text/javascript">
    function cancel_sub_info_popup(company_id) {
        $(".popup_overlay").css({display: "block"});
        $(".popup_bg").css({display: "block"});
        $(".popup_bg").css({width: "650px"});
        $(".cancel_sub_popup_content").show();
        $('#cancel_sub_info_popup').show();
        var pageurl = $("#pageurl").val();
        var path = "users/cancel_sub";
        $.post(pageurl + path, {"popup": 1, 'company_id': company_id}, function(data) {
            $('.loader_dv').hide();
            $('#cancel_sub_popup_content').show();
            $("#cancel_sub_popup_content").html(data);
        });
    }
    function cancelsub_pop_close() {
        $('#popup_overlay').hide();
        $('#cancel_sub_info_popup').hide();
    }
// Get all activity related to payment 
    function get_payment_activity(page_no) {
        var filter = $('#activity_type_id').val();
        $('#activity_data').html("<span style='position: absolute;left:0;right:0;margin:auto;    text-align: center;'><img src='<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif' title='Loading...'></span>");
        var url = $('#pageurl').val();
        $('.ui_tab_cls').removeClass('class_active');
        $.post(url + "users/account_activity", {"page": page_no, 'filter': filter, 'ajaxlayout': '1'}, function(res) {
            $('#activity_data').html(res);
        });
    }
$(function(){ 
	$(".warning_circle_icon > .material-icons").click(function(e){
		$(".manage_plan_setting").show();
		 e.stopPropagation();
	});
	$(".manage_plan_setting").click(function(e){
		e.stopPropagation();
	});
	$(document).click(function(){
		$(".manage_plan_setting").hide();
		$(".okey").click()
	});
	$(".okey").click(function(){
		$(".manage_plan_setting").hide();
	});
});
</script>