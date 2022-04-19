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
                                   <?php echo __(" Hi ");?><?php echo $newInfo['name'];?>,                    
                                </p>
									<p><?php echo __("Your profile information has been changed by");?> <b><?php echo $ut;?></b>.</p>
                                    
                                    <p><?php echo __("Please find below your updated profile details,");?>
                                    <br/>
									<?php echo __("Email:");?> <b><?php echo $newInfo['email']; ?></b><br/> 
                                    <?php echo __("Name:");?> <b><?php echo $newInfo['name']; ?></b><br/>  
								    <?php echo __("Last name:");?> <b><?php echo $newInfo['last_name'] ?></b><br/> 		
									<?php echo __("Short name:");?> <b><?php echo $newInfo['short_name'] ?></b>											
                                    </p>
                                    
									<p><?php echo __("Please click the button below to view your details.");?></p>
									
									<a style="font-weight:bold; text-decoration:none;" href="<?php echo HTTP_ROOT.'users/invitation/'.$qstr;?>" target='_blank'><div style="display:block; max-width:100% !important; width:auto !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center">Login to Orangescrum</div></a>

									
                                <br/>
								
								<p><?php echo __("If you have any questions, please write us at");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a><?php echo __(", we will be happy to help you.");?></p>
								
								<br/>
								
								<p><?php echo __("Regards,");?><br/>
								<?php echo __("The Orangescrum Team");?></p>
                            </td>
                        </tr>
                   </table>
                  
                   <table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #3DBB89">
                        <tr>
                            <td width="100%" bgcolor="#ffffff" style="text-align:center;">
                            	<p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
									<?php echo NEW_EMAIL_FOOTER;
									
									if($existing_user)
									{
									?>
										<?php echo __("You are receiving this email notification because you have an account on Orangescrum and");?><?php echo $fromName; ?><?php echo __(" added you to his company. To unsubscribe, please email with subject 'Unsubscribe' to");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>
									<?php
									}
									else {
									?>
										<?php echo __("Your email address is used to create an account on Orangescrum. To unsubscribe, please email with subject 'Unsubscribe' to");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>
									<?php
									}
									?>
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