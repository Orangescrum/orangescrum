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
                                 <?php echo __("Hi");?> <?php echo $data['User']['name']." ".$data['User']['last_name'];?>,
                                </p>
								
								<p><?php echo __("You deleted your account a while ago. We thank you for giving us a try and appreciate your interest in Orangescrum.com, hope you'll continue to visit often");?></p>
								
								<p><?php echo __("If you have a minute, we'd appreciate your thoughts on how we can do better. Your feedback will help us to improve Orangescrum :)");?></p>
								
								<p><?php echo __("We look forward to hearing from you. Please write us at <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a> or just reply to this email.");?></p>
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
									<?php echo NEW_EMAIL_FOOTER; ?>
									
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
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Hi");?> <?php echo $data['User']['name']." ".$data['User']['last_name'];?>,</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("You have deleted your account with Orangescrum.");?></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("We will be happy to hear more about the reason of deletion of account.");?></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("You can send your feedback on ");?>support&#64;orangescrum&#46;com</td></tr>
   <tr height='15px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><?php echo __("Thank you for using Orangescrum.");?></td></tr>
   <?php echo EMAIL_FOOTER;?>
</table><?php */?>
