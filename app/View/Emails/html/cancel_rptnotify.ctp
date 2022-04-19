<?php if($cancel_active_period != ''){
	$fb_date_t = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, '', $cancel_active_period, 'datetime');									
}else{ $fb_date_t= 'now'; } ?>
<table cellpadding='1' cellspacing='1' align='left' width='100%'>
	<?php echo EMAIL_HEADER; ?>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Dear site administrator,");?></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><b><?php echo $data['User']['name']." ".$data['User']['last_name'];?></b><?php echo __("just cancelled the subscription for");?><b><?php echo $company_name;?></b><?php echo __("and the account will be deactivated effectively from");?><b><?php echo date("D, j M Y ", strtotime($fb_date_t)); ?></b>.</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("The reason of Cancellation of account is");?><b><i><?php echo $inputdata['cancel_reason'];?></i></b></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Comment:");?><b><i><?php echo $inputdata['comments'];?></i></b></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Email:");?>&nbsp;<?php echo $data['User']['email'];?></td></tr>
   <tr height='25px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <?php echo EMAIL_FOOTER;?>
</table>