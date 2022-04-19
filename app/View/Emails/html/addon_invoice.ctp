<?php
$addon_nams = Configure::read('AUTOMATE_ADDON');
$comboaddon_nams = Configure::read('COMBO_ADDON_NAMES');
$prebuiltaddon_nams = Configure::read('PREBUILD_ADDON_INV_NAMES');
#$add_down_name = array('timelog'=>'Time Log','newui'=>'New UI', 'ganttchart' => 'Gantt Chart', 'invoice' => 'Invoice', 'taskstatusgroup' => 'Task Status Group');
if($data['request_addon'] == 'combo6'){
    $addon = 'All';
}else{
if(stristr($data['request_addon'], 'prebuild')){
	$addon = $prebuiltaddon_nams[$data['request_addon']][0];
}else{
$addon = stristr($data['request_addon'], 'combo') ? $comboaddon_nams[$data['request_addon']][0]:$addon_nams[$data['request_addon']];
}
}
?>
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
						<?php echo __("Hi");?> <?php echo ucwords($data['name']); ?>,                    
					    </p>
					   <p><?php echo __("Thank you for purchasing");?> <?php echo $addon; ?><?php echo __("add-on");?><?php echo (stristr($data['request_addon'], 'combo') || stristr($data['request_addon'], 'prebuild')) ? 's':''; ?>.</p>
					   <p><?php echo __("We're writing to let you know that your Orangescrum invoice");?>(INV<?php echo $data['invoice_id']; ?>)<?php echo __(", is attached to this message as a PDF file. Your credit card has been charged ");?><b>$<?php echo $data['amount']; ?></b><?php echo __(" USD.");?></p>
					   
					   <p><?php echo __("If you have any questions regarding this invoice, please contact us at");?> <a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>.</p>
					   
					    <p>
						<?php echo __("Cheers!");?><br/> 
						<?php echo __("The Orangescrum Team");?> 
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