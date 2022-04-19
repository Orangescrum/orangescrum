<style>
.arc_tbl td{padding:4px 10px;color: #555555;}
.tab_tr th{padding:9px !important;}
</style>
<div class="account_settings payment-tab">
<!--Tabs section starts -->
<div id="donot_refresh" class="donot_refresh" style="display:none;"><span style="margin-top: 3px;"><?php echo __("Please don't refresh or close this page. Cancellation of account is in progress");?>...</span><br><span><img src="<?php echo HTTP_ROOT;?>img/payment_loading.gif" alt="Loader"/></span></div>
<div class="active_subscription">
	<div class="active_heading" style="padding: 1px 0 2px;">
		Current Plan: <span style="color:#56B40B"><?php echo $plan_types[$user_sub[0]['UserSubscription']['subscription_id']];?></span>
		<?php if($user_sub[0]['UserSubscription']['subscription_id'] == CURRENT_FREE_PLAN){ ?>
		<div style="float:right; font-size: 13px;margin-top: 19px;">
			<?php
				$t_dt = date("Y-m-d H:i:s", strtotime($user_sub[0]['UserSubscription']['created'].' +'.FREE_TRIAL_PERIOD.__('days',true)));
				if($user_sub[0]['UserSubscription']['extend_trial'] != 0){
					$t_dt = date("Y-m-d H:i:s", strtotime($user_sub[0]['UserSubscription']['extend_date'].' +'.$user_sub[0]['UserSubscription']['extend_trial'].__('days',true)));
				}
				$datetime1 = new DateTime(date("Y-m-d H:i:s"));
				$datetime2 = new DateTime($t_dt);
				$interval = $datetime1->diff($datetime2);
				$days_to_go = $interval->format('%R%a');
				if($days_to_go < 0){
					print FREE_TRIAL_PERIOD."-".__('day FREE Trial')." <span style='color:red;'>".__('expired')."</span>";
				}else{
					print FREE_TRIAL_PERIOD."-".__('day FREE Trial')." (<span original-title='".date("D, j M Y",strtotime($t_dt))."' rel='tooltip' style='color:brown;'>".$interval->format('%a')." ".__('day(s) to go')."</span>)";
				}
			?>
		</div>
		<?php } ?>
	</div>
    <?php
	$all_paid_plan = Configure::read('ALL_PAID_PLANS_REVISED');
	if(array_key_exists($user_sub[0]['UserSubscription']['subscription_id'],$all_paid_plan)) { ?>
    <div style="font-size:11px;"><?php echo __('You will be charged after your').' '.TRIAL_DAY_TXT.' -'.__('day use of Orangescrum. The charge on your credit card statement will be from "ANDOLASOFT INC"');?></div>
    <?php } ?>
	<div class="drwline"></div>
	<div class="subscription_info">
		<div class="fl sfirst" >
			<?php
			if($user_sub[0]['UserSubscription']['created']){
					$crt_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',$user_sub[0]['UserSubscription']['created'],'datetime');
			}
			if($user_sub[0]['UserSubscription']['next_billing_date']){
				$fb_date = $this->Datetime->facebook_style_date_time($user_sub[0]['UserSubscription']['next_billing_date'],GMT_DATETIME,'date');
				$fb_date = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',$user_sub[0]['UserSubscription']['next_billing_date'],'datetime');
				$fb_date = date("D, j M Y ",strtotime($fb_date));
			}else{
				$fb_date ='NA';
			}
			?>
			<span><?php echo __('Created on');?>: <b><?php echo date("D, j M Y ",strtotime($crt_dt));?></span></b><br/>
			<span><?php echo __('User Limit');?>: <b><?php echo $user_sub[0]['UserSubscription']['user_limit'];?></b>
            <br/><?php echo __('Project Limit');?>: <b><?php echo $user_sub[0]['UserSubscription']['project_limit'];?></b>
            <br/><?php echo __('Storage Limit');?>: <b><?php echo $this->Format->displaystorage($user_sub[0]['UserSubscription']['storage'],1);?></b></span><br/>
			<span><?php echo __('Next Billing Date');?>: <b><?php echo $fb_date;?></b></span>
		</div>
		<div class="fl smiddle">
			<?php /*?><span><b>Usage As of Today</b></span><br/><?php */?>
            <?php if(strtolower($user_sub[0]['UserSubscription']['user_limit']) != "unlimited") { 
			$act_user_count = $user_sub[0]['UserSubscription']['user_limit'] - $rem_users;
		    ?>
    		<span><b><?php echo __('Users');?>:</b> <?php echo $act_user_count; ?> of <?php echo $user_sub[0]['UserSubscription']['user_limit']; ?></span>
    		<div style="clear:both"></div>
			<div class="imprv_bar col-lg-10" style="margin-top:0;">
				<?php 
					$plimitper = round(($act_user_count / ($user_sub[0]['UserSubscription']['user_limit'])) * 100);
					$plimitper = $plimitper>100?100:$plimitper;
				?>
				<div class="cmpl_green" style="width:<?php echo $plimitper;?>%" ></div>
			</div>
			<div style="clear:both"></div>
            <?php } ?>
            <?php if(strtolower($user_sub[0]['UserSubscription']['project_limit']) != "unlimited") { 
			$act_proj_count = $user_sub[0]['UserSubscription']['project_limit'] - $rem_projects;
		    ?>
    		<span><b><?php echo __('Projects');?>:</b> <?php echo $act_proj_count; ?> of <?php echo $user_sub[0]['UserSubscription']['project_limit']; ?></span>
    		<div style="clear:both"></div>
			<div class="imprv_bar col-lg-10" style="margin-top:0;">
				<?php 
					$plimitper = round(($act_proj_count / ($user_sub[0]['UserSubscription']['project_limit'])) * 100);
					$plimitper = $plimitper>100?100:$plimitper;
				?>
				<div class="cmpl_green" style="width:<?php echo $plimitper;?>%" ></div>
			</div>
			<div style="clear:both"></div>
            <?php } ?>
            <?php if(strtolower($user_sub[0]['UserSubscription']['storage']) != "unlimited") { ?>
			<span><b><?php echo __('Storage');?>:</b> <?php echo $this->Format->displaystorage($used_storage);?> of <?php echo $this->Format->displaystorage($user_sub[0]['UserSubscription']['storage'],1);?></span>
            <div style="clear:both"></div>
			<div class="imprv_bar col-lg-10" style="margin-top:0;">
				<?php 
					$stper = round(($used_storage/($user_sub[0]['UserSubscription']['storage']))*100);
					$stper = $stper >100 ? 100:$stper;
				?>
				<div class="cmpl_green" style="width:<?php echo $stper;?>%" ></div>
			</div>
            <?php } ?>
		</div>
		<div class="cb"></div>
	</div>
    
	<!--<div class="fr canclsubscription_txt"><span><a href='javascript:void(0);' onclick='return cancel_sub_info_popup("<?php echo $user_sub[0]['UserSubscription']['company_id'];?>");'>Cancel Subscription</a></span></div>-->
	<!--<div class="fr canclsubscription_txt"><span><a href='<?php echo HTTP_ROOT;?>users/cancel_account'><?php if($user_sub[0]['UserSubscription']['subscription_id']>1){?>Cancel Subscription<?php }else{?>Cancel Account<?php }?></a></span></div>
	<div class="cb"></div>
	<div class="drwline"></div>-->
</div>
<?php if(count($user_sub)>1){?>
<div class="prev_subs_txt" style="padding-bottom:5px"><?php echo __('Plan History');?></div>
<table width="98%" class="tsk_tbl arc_tbl sub_ipad" >
	<tr style="" class="tab_tr">
		<th align="left"><?php echo __('Plan');?></th>
        <th align="right"><?php echo __('Amount($)');?></th>
        <th align="right"><?php echo __('Storage(MB)');?></th>        
        <th align="right"><?php echo __('Project Limit');?></th>        
        <th align="center"><?php echo __('Created On');?></th>        
        <th ><?php echo __('Status');?></th>        
	</tr>
	<?php 	
		if($user_sub){
			array_shift($user_sub);
			$count = 0;
			$t='';
			$total_subscriptions = count($user_sub);
			$cur_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',date('Y-m-d'),'date');
			foreach($user_sub as $key=>$val){ 
			$due_date = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',$val['UserSubscription']['created'],'datetime');
			$dt = date("D",strtotime($due_date)); 
			$dt1 = date("j M Y ",strtotime($due_date)); 
			$nbc_dt='';
			if($val['UserSubscription']['cancel_date']){
				$nbc_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',$val['UserSubscription']['cancel_date'],'datetime');
				$fb_date = $this->Datetime->facebook_style_date_time($val['UserSubscription']['cancel_date'],GMT_DATETIME,'date');
			}elseif($val['UserSubscription']['next_billing_date']){
				$nbc_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,'',$val['UserSubscription']['next_billing_date'],'datetime');
				$fb_date = $this->Datetime->facebook_style_date_time($val['UserSubscription']['next_billing_date'],GMT_DATETIME,'date');
			}else{
				$fb_date='NA';
			}
			if($nbc_dt){
				$dt2 = date("D",strtotime($nbc_dt)); 
				$dt3 = date("j M Y",strtotime($nbc_dt));
				$cancel_nb_dt = $dt2.", ".$dt3;
			}else{
				$cancel_nb_dt ='NA';
			}
			if($val['UserSubscription']['is_free']==1){
				$plan ="FREE";
			}else{
					$plan=$plan_types[$val['UserSubscription']['subscription_id']];
			}	?>	
        <tr class="tr_all">
        	<td align="left"><?php echo $plan; ?></td>
            <td align="right"><?php echo $val['UserSubscription']['price'];?></td>
            <td align="right"><?php echo $val['UserSubscription']['storage'];?></td>
            <td align="right"><?php echo ucfirst($val['UserSubscription']['project_limit']);?></td>
            <td align="center"><?php echo $dt.", ".$dt1; ?></td>
            <td align="left">
				<?php if($val['UserSubscription']['cancel_date'] && ($val['UserSubscription']['is_updown']==1)){
					echo "<div class='label label-upgrade'>".__('UPGRADE')."</div>";
					echo "&nbsp On ".date('dS M',  strtotime($nbc_dt));
				}elseif($val['UserSubscription']['cancel_date'] && ($val['UserSubscription']['is_updown']==2)){ 
					echo "<div class='label label-downgrade'>".__('DOWNGRADE')."</div>"; 
					echo "&nbsp On ".date('dS M',  strtotime($nbc_dt));
				}elseif($val['UserSubscription']['cancel_date']){
					echo "<div class='label label-cancel'><strong>".__('CANCELED')."</strong></div>";
					echo "&nbsp On ".date('dS M',  strtotime($nbc_dt));
				}else{ echo "<span color='green'><strong>".__('Active')."</strong></span>";
					echo "&nbsp On ".date('dS M',  strtotime($val['UserSubscription']['created']));
				}
				?>
			</td>
        </tr>
		<?php } }?>
</table>                                 
<?php }?>

<div class="drwline" style="margin-top:15px;"></div>
<div class="fl canclsubscription_txt" style="padding-top:10px;"><span><a href='<?php echo HTTP_ROOT;?>users/cancel_account'><?php if($user_sub[0]['UserSubscription']['subscription_id']>1){?><?php echo __('Cancel Subscription');?><?php }else{?><?php echo __('Cancel Account');?><?php }?></a></span></div>
<div class="cb"></div>
</div>
<script type="text/javascript">
//function cancel_sub_info_popup(company_id){
//	$('#cover').css({position:'fixed'});
//	$('#cover').show();
//	$('#overlay_newpop').show();
//	$('#cancel_sub_info_popup').show();
//	var pageurl = $("#pageurl").val(); 
//	var path = "users/cancel_sub";
//	$.post(pageurl+path,{"popup":1,'company_id':company_id},function(data){ 
//		$("#cancel_sub_info_popup").html(data);
//	});
//}
//function cancelsub_pop_close(){
//	$('#overlay_newpop').hide();
//	$('#cover').hide();
//	$('#cancel_sub_info_popup').hide();
//}
</script>


