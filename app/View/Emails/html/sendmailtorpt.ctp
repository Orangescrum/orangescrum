<table cellpadding='1' cellspacing='1' align='left' width='100%'>
	<?php echo EMAIL_HEADER; ?>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Dear site administrator,</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><b><?php echo $data['name']." ".$data['last_name']; ?></b> trying to make a payment for Company <b><?php echo $company_name;?></b>, But not able to proceed.<br/></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><b>Error Message:</b>&nbsp;<font color="red"><?php echo $message." ".$responsetext;?></font></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr height='25px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <?php echo EMAIL_FOOTER;?>
</table>