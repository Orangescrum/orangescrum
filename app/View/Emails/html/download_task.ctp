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
                                  <?php echo __("Hi");?> <?php echo $userdetails['User']['name'];?>,                    
                                </p>
								<p><?php echo __("Please find the attachment of");?> <b><?php echo __("Task#");?> :</b><?php echo $caseNum;?> <?php echo $title;?></b>  </p>
								<p><?php echo __("File name:");?><?php echo $zipfile;?> </p>
								<!--<p><?php echo __("Click below button to download");?> <b><?php echo __("Task# :");?><?php echo $caseNum;?> <?php echo $title;?></b></p>-->
<!--								<p>
									<a style="font-weight:bold; text-decoration:none;" href="<?php echo $download_url;?>" target='_blank'><div style="display:block; max-width:100% !important; width:auto !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center">Download Task</div></a>
								</p>-->
<!--								<p style="color: #333;font-style: italic;">Note: This link is only valid for 48hours.</p>-->
																
								<p><?php echo __("If you have any questions, please write us at");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>, we will be happy to help you.</p>
								
								<br/>
								
								<p><?php echo __("Regards,");?><br/>
								The Orangescrum Team</p>
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
									<?php echo __("You are receiving this email notification because you have subscribed to Orangescrum, to unsubscribe, please email with subject 'Unsubscribe' to");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>
									<?php
									}
									else {
									?>
									<?php echo __("Your email address is used to invite you on Orangescrum. If you didn't intend to do this, just ignore this email; no account has been created yet.");?>
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




