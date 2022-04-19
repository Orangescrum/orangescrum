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
                                    Hi <?php echo $name;?>,            
                                </p>
								
								<p>I hope you are doing well.
                                <br/>I'm Prakash, Product Manager of Orangescrum.</p>
                                
                                <p>We've got some valuable feedback from the people like you and simplified our  <b>Onboarding</b> process.<br/>We have been working hard to make your experience as smooth as possible. <br/>Now you can Create Projects, Invite your Team and Start using Orangescrum within a minute.</p>
                                
                                <p>We have introduced LIVE support in Orangescrum, you can chat with us in a single click. 24*7 - 5 days a week</p>
                                <p><a href="https://<?php echo $seo_url;?>.orangescrum.com/users/login" target='_blank'><b>Login</b></a> to your Orangescrum account and start using it right away. <br/><a href="https://<?php echo $seo_url;?>.orangescrum.com/users/forgotpassword/?email=<?php echo urlencode($email);?>" target='_blank'><b>Forgot your password?</b> No problem, you can set your new password right away.</p>
                                
                                <br/>
                                <p>Allow me to suggest you how to get best out of Orangescrum. Just reply to this and I will take care of the rest :) </p>
                                
                            </td>
                        </tr>
                   </table>
                  
                   <table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #3DBB89">
                        <tr>
                            <td width="100%" bgcolor="#ffffff" style="text-align:center;">
                            	<p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
									<?php echo NEW_EMAIL_FOOTER; ?>
									
									You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please email with subject 'Unsubscribe' to <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>
									
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
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Hi &nbsp;<?php echo $data['Users']['name']." ".$data['Users']['last_name'];?>,</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Thank you for subscribing again.</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Plan:&nbsp;<b><?php echo $plan_types[$plan_id];?></b> &nbsp;-&nbsp; <b>$<?php echo $price;?></b>&nbsp;/month&nbsp; </td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Storage:&nbsp;;<b><?php echo $this->Format->displaystorage($storage);?>&nbsp;</b> &nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Next billing date:&nbsp;<b><?php echo $next_billing_date;?></b></td></tr>
   <tr height='25px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <?php echo EMAIL_FOOTER;?>
</table><?php */?>