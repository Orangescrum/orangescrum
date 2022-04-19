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
												<?php echo __('Dear Team');?>,
											</p>
											
											<p><?php echo __('A project note has been')?> <?php if($is_update){?><?php echo __('updated');?><?php }else{ ?><?php echo __('added');?><?php } ?> <?php echo __('in');?> "<b><?php echo $pname;?></b>".</p> 
											
											<p><?php echo __('Note:');?></p>
											<p><?php echo $note; ?></p>											
											<br/>
											
											<p><?php echo __('Regards');?>,<br/>
											<?php echo __('The Orangescrum Team');?></p>
										</td>
									</tr>
								</table>
								
								<table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #3DBB89">
									<tr>
										<td width="100%" bgcolor="#ffffff" style="text-align:center;">
											<p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
												<?php echo NEW_EMAIL_FOOTER; ?>
												
											<?php echo __('You are receiving this email notification because you are a part of the project, to unsubscribe, please contact your project owner');?></a>
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