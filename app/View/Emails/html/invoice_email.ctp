<body style="width:100%; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;">
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
	<tr>
		<td>
        <div id="tablewrap" style="width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;">
		      <table id="contenttable" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #3DBB89">
            <tr>
                <td width="100%">

                               <table bgcolor="#FFF" border="0" cellspacing="0" cellpadding="10" width="100%">
                        <tr>
                                        <td style="border-top:6px solid #3dbb89;">
                                            <table bgcolor="#FFF" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                    <td align="left" colspan="3"><h2><?php echo __("Invoice");?></h2></td>                                                    
                                                </tr>
                                                <tr>
                                                    <td align="left" style="width:20%"><?php echo __("Invoice#:");?></td>
                                                    <td align="left" style="width:30%"><?php echo $i['Invoice']['invoice_no']; ?></td>
                                                    <td align="right" style="width:40%;font-size:22px;"><?php echo __("Amount:");?> <?php echo $i['Invoice']['currency'] ?> <?php echo $this->Format->format_price($i['Invoice']['price']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left"><?php echo __("Due Date:");?></td>
                                                    <td align="left" colspan="2"><?php echo $this->Format->get_date($i['Invoice']['due_date']); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                            <td width="100%" bgcolor="#FFF" style="text-align:left;">
                                            <p><?php echo nl2br($message); ?></p>
                                            <?php /* ?>
                            	<p>
                                    <?php echo __("Dear");?> <?php $name = $this->Format->getUserDtls($i['Invoice']['user_id']);
                                    echo $name['User']['name'];?>.
                                </p>
								<p><?php echo __("Your Generated Invoice is attached . please");?> <a href="<?php print $f;?>">click here</a> to download Your invoice.</p> 
								<p><?php echo __("Regards,");?><br/>
                                              <?php echo __("The Orangescrum Team");?></p><?php */ ?>
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
    <table border="0" cellspacing="0" cellpadding="10" width="100%" style="margin-top:0px;border-top:3px solid #3DBB89;color:#ccc;">
        <tr>
            <td width="100%" bgcolor="#ffffff" style="text-align:left;">
                <em>Powered By: </em><b>Orangescrum</b>
            </td>
	</tr>
        <tr>
            <td width="100%" bgcolor="#ffffff" style="text-align:center;">
                <p style=" font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
                    &#169; <?php echo __("Copyright");?> <?php echo gmdate('Y'); ?> Orangescrum. <?php echo __("All Rights Reserved.");?><br/>
                    2059 Camden Ave. #118, San Jose, CA 95124, USA
                </p>
            </td>
        </tr>
    </table> 
</body>