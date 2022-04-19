<table cellpadding='1' cellspacing='1' align='left' width='100%'>
	<?php echo EMAIL_HEADER; ?>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Dear site administrator,</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'><b><?php echo $data['User']['name']." ".$data['User']['last_name'];?></b> just deleted  the account  <b><?php echo $company_name;?></b>.</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>The reason of deletion of account is <b><i><?php echo $inputdata['cancel_reason'];?></i></b></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Comment  <b><i><?php echo $inputdata['comments'];?></i></b></td></tr>
   <tr><td align='left' style='font-family:Arial;font-size:14px;'>Email: &nbsp;<?php echo $data['User']['email'];?></td></tr>
   <tr height='25px'><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
   <?php echo EMAIL_FOOTER;?>
</table>