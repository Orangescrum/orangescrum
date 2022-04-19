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
                                    <?php echo __("Hi");?> <?php echo $expName;?>,                    
                                </p>
								
								<?php
								if($existing_user)
								{
								?>
									<p><b><a href="mailto:<?php echo $fromEmail; ?>"><?php echo $fromName; ?></a></b> <?php echo __("added you to");?> <b><?php echo $company_name; ?></b> <?php echo __("on");?> Orangescrum.</p>
                                    
									<p><?php echo __("Now you are in multiple company in Orangescrum. After login to your Orangescrum account, you can choose to access any of these Company.");?></p>
									
                                    <p><?php echo __("You can also login to a specific company in Orangescrum using the Company URL. Please click the below button to access");?> <b><?php echo $company_name; ?></b></p>
                                    
									<a style="font-weight:bold; text-decoration:none;" href="<?php echo HTTP_APP.'users/invitation/'.$qstr;?>" target='_blank'><div style="display:block; max-width:100% !important; width:auto !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center"><?php echo __("Access");?> <?php echo $company_name; ?></div></a>
									
								<?php
								}
								else {
								?>
									<p><b><a href="mailto:<?php echo $fromEmail; ?>"><?php echo $fromName; ?></a></b> <?php echo __("has just setup an account for you on Orangescrum.");?></p>
                                    
                                    <p><?php echo __("Your login details,");?>
                                    <br/>
                                    <?php echo __("Email:");?> <b><?php echo $email; ?></b><br/>
                                    <?php echo __("Password:");?><b><?php echo $password; ?></b>
                                    </p>
                                    
									<p><?php echo __("Please click the button below to start using Orangescrum.");?></p>
									
									<a style="font-weight:bold; text-decoration:none;" href="<?php echo HTTP_APP.'users/invitation/'.$qstr;?>" target='_blank'><div style="display:block; max-width:100% !important; width:auto !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center"><?php echo __("Login to Orangescrum");?></div></a>
								<?php
								}
								?>
									
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
										<?php echo __("You received this message because you are a Orangescrum customer. If you would prefer not to receive these emails in the future, you can ");?><a href='<?php echo $user_unsub_link; ?>'>unsubscribe</a> at any time.										
										<?php /* You are receiving this email notification because you have an account on Orangescrum and<?php echo $fromName; ?> added you to his company. To unsubscribe, please email with subject 'Unsubscribe' to <a href='<?php echo HTTP_ROOT;?>unsubscribe/<?php echo $user_uid; ?>'>unsubscribe</a> */ ?>
									<?php 
									}
									else {
									?>
									<?php echo __("You received this message because you are a Orangescrum customer. If you would prefer not to receive these emails in the future, you can");?> <a href='<?php echo $user_unsub_link; ?>'><?php echo __("unsubscribe");?></a> at any time.	
										<?php /* Your email address is used to create an account on Orangescrum. To unsubscribe, please email with subject 'Unsubscribe' to <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a> */ ?>
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


<?php /*?><table style="padding-top:20px;margin:0 auto;text-align:left;width:100%">
  <tbody>
  	<?php echo EMAIL_HEADER;?>
    <tr>
      <td>
	<div style="color:#000;font-family:Arial;font-size:14px;line-height:1.8em;text-align:left;padding-top: 10px;">
		<p style="display:block;margin:0 0 17px"><?php echo __("Hi");?> <?php echo $expName;?>,</p>
		<p>
			<?php echo $invitationMsg;?>
		</p>
		<p>
			<div><?php echo __("Please click on the link below to confirm.");?></div>
			<div><a href="<?php echo HTTP_ROOT.'users/invitation/'.$qstr;?>" target='_blank'><?php echo HTTP_ROOT."users/invitation/".$qstr; ?></a></div>
		</p>
		<p style="display:block;margin:0">
			<?php echo __("Regards,");?><br/>
			<?php echo __("The Orangescrum Team");?>
		</p>				
	</div>
      </td>
    </tr>
    	<?php echo Configure::read('invite_user_footer');?>
    	<?php if(!empty($existing_user)){ ?>
    		<?php echo $existing_user;?>
		<?php echo Configure::read('common_footer');?>
	<?php } ?>
  </tbody>
</table><?php */?>


