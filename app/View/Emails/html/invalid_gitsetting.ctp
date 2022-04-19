<body style="width:100%; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;">
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
	<tr>
		<td>
        <div id="tablewrap" style="width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;">
		      <table id="contenttable" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #3DBB89">
            <tr>
                <td width="100%">
                   <?php echo NEW_EMAIL_HEADER; ?>
                   <table bgcolor="#FFF" border="0" cellspacing="0" cellpadding="20" width="100%">
                        <tr>
                            <td width="100%" bgcolor="#FFF" style="text-align:left;">
                            	<p>
                                   <?php echo __("Hi");?> <?php echo $userdetails['name']." ".$userdetails['last_name'];?>,                    
                                </p>
								
								<p><?php echo __("Git sync connection settings disabled.");?></p>
								
								<p>
									<?php echo __("Possible reasons:");?><br/>
									<ul>
										<li><b><?php echo __("Your access token revoked from github.");?></b></li>
										<li><b><?php echo __("Connected repository deleted/transferred from github");?></b></li>
										<li><b><?php echo __("Webhooks deleted from repository");?></b></li>
									</ul>
								</p>
                                <br/>
								<p><?php echo __("In order to resume your sync please adda new sync setting again.");?></p>
								<p><?php echo __("If you have any questions, please write us at");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>, we will be happy to help you.</p>
								
								<br/>
								
								<p>Regards,<br/>
								The Orangescrum Team</p>
                            </td>
                        </tr>
                   </table>
                  
                   <table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #3DBB89">
                        <tr>
                            <td width="100%" bgcolor="#ffffff" style="text-align:center;">
                            	<p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
									<?php echo NEW_EMAIL_FOOTER; ?>
									
									<?php echo __("You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please email with subject 'Unsubscribe' to");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>
									
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </div>
		</td>
	</tr>
</table> 
</body>

<?php /*?><table cellpadding='1' cellspacing='1' align='left' width='100%'>
	<?php echo EMAIL_HEADER; ?>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Hi");?> &nbsp;<?php echo $data['Users']['name']." ".$data['Users']['last_name'];?>,</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Thank you for subscribing again.");?></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Plan:");?>&nbsp;<b><?php echo $plan_types[$plan_id];?></b> &nbsp;-&nbsp; <b>$<?php echo $price;?></b>&nbsp;/month&nbsp; </td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Storage:");?>&nbsp;;<b><?php echo $this->Format->displaystorage($storage);?>&nbsp;</b> &nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Next billing date:");?>&nbsp;<b><?php echo $next_billing_date;?></b></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Next billing date:");?>&nbsp;<b><?php echo $next_billing_date;?></b></td></tr>
   <tr height='25px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <?php echo EMAIL_FOOTER;?>
</table><?php */?>