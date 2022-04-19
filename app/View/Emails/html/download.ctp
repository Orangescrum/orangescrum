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
						Hi <?php echo $data['name']; ?>,                    
					    </p>
					    <p>
						Thank you for your Download <b>Orangescrum v1.0</b>.
					    </p>
					    <p>
						Please click the big button below to start downloading <b>Orangescrum Community Edition</b>
					    </p>
					    <a style="font-weight:bold; text-decoration:none;" href="<?php echo $data['url']; ?>">
						<div style="display:block; max-width:100% !important; width:95% !important;margin:auto; height:auto !important;background-color:#0EA426;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center">Download</div>
					    </a>
					    <br/>
					    <br/>
					    <p>
						Just 5 simple steps to start using Orangescrum in your premises. This procedure is well-tested on Windows, Linux and Mac operating system.
						<br/>
						<a href="<?php echo $data['manual_url']; ?>" target="_blank">
						    Download Orangescrum installation manual
						</a>
					    </p>
                                            <p>
						<b>Time log</b> Add-on is available. Click on below button to submit your request.
					    </p>
                                            <p style="text-align:center;">
                                                <a style="font-weight:bold; text-decoration:none;" href="http://www.orangescrum.org/add-on">
                                                    <div style="display:block; max-width:60% !important; width:95% !important;margin:auto; height:auto !important;background-color:#EA801A;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border-radius:10px;color:#ffffff;font-size:16px;text-align:center">Request Time Log Add-on</div>
                                                </a>
                                            </p>
					    <p>
						We also have a small but growing community which is pretty active. You can join our mailing list on 
						<a style="font-weight:bold; text-decoration:none;" href="<?php echo $data['google_url']; ?>">
						    Google Group
						</a>
					    </p>
					    <p>
						Fork the project from 
						<a style="font-weight:bold; text-decoration:none;" href="<?php echo $data['github_url']; ?>">
						    GitHub
						</a>
						if you are interested in contributing, or you can simply watch its progress.
					    </p>
					    <p>
						Have a great day!<br/>
						The Orangescrum Team
					    </p>
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