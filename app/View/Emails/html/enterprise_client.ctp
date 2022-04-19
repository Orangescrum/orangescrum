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
						Hi <?php echo ucwords($data['name']); ?>,                    
					    </p>
					   <?php 
							if($data['plan'] == '10 Users | $1,899 Annually'){
                                $users = '10';
                                $sup_amt = '$1,899';
                            }else if($data['plan'] == '25 Users | $3,299 Annually'){
                                $users = '25';
                                $sup_amt = '$3,299';
                            }else if($data['plan'] == '50 Users | $4,999 Annually'){
                                $users = '50';
                                $sup_amt = '$4,999';
                            }else{
                                $sup_amt = '';
                            }
							
						?>
					<?php if($sup_amt == ''){ ?>
                        <p>We have received your enquiry for Orangescrum Self-Hosted Edition. We appreciate for taking out time to write to us.</p>
                        <p>We will get back to you shortly – an Orangescrum expert will get in touch with you; we certainly look forward to discover more about your interests and challenges.</p>
                    <?php } else{ ?>
                        <p>My name is Omkar; I wanted to personally welcome you to Orangescrum. I really appreciate you joining us, and I know you will love the convenience of being able to monitor your entire business from one place using our all-in-one project management collaboration tool.</p>
                        <p>We have received your request for - <?php echo $users; ?> Users Orangescrum Enterprise Annual Plan. You will soon receive an invoice for <b><?php echo $sup_amt;?></b> from Andolasoft Inc. Once you have made the payment, one of our Orangescrum expert will contact you; guide you further with the process and deliver the package.</p>
                    <?php } ?>
					    <p>
						Cheers!<br/> 
						The Orangescrum Team<br />
                        <img style="vertical-align: middle" src="https://www.orangescrum.com/img/skype_ico.png" />andola.priyank
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