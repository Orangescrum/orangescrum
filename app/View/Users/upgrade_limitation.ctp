<style type="text/css"></style>
<table style="width: 100%;font-size: 16px;line-height: 10px;border: 1px solid;" cellspacing="5" cellpadding="5" align="center">
	<tr>
		<td>
			<table cellpadding="0" cellspacing="15" class="pay_desc" style="width: 85%;padding-left: 3%">
				<tr>
					<th colspan="2">Plan Details</th>
				</tr>
				<tr><td style="height:2px" colspan="2"><div style="border-bottom: 1px solid #CCCCCC;"></div></td></tr>
				<tr>
					<th align="left">Particulars</th>
					<th align="right">Limits</th>
				</tr>
				<tr><td style="height:2px" colspan="2"><div style="border-bottom: 1px solid #CCCCCC;"></div></td></tr>
				<tr>
					<td>Projects</td>
					<td align="right"><?php echo $subscription['Subscription']['project_limit'];?></td>
				</tr>
				<tr>
					<td>Users</td>
					<td align="right"><?php echo $subscription['Subscription']['user_limit'];?></td>
				</tr>
				<tr>
					<td>Storage</td>
					<td align="right"><?php echo $this->Format->displaystorage($subscription['Subscription']['storage']);?></td>
				</tr>
				<tr><td style="height:1px" colspan="2"><div style="border-top:1px dashed #CCCCCC"></div></td></tr>
<!--							<tr>
					<td><b>Total Payable</b></td>
					<td style="color:green; font-weight:bold" align="right">$<?php echo number_format((($no_of_users*PRICE_PER_USER)-$discount),2,'.',','); ?></td>
				</tr>-->
			</table>
		</td>
		<td>
			<table cellpadding="0" cellspacing="15" class="pay_desc" style="width: 85%;padding-left: 3%">
				<tr>
					<th colspan="2">Usage Details</th>
				</tr>
				<tr><td style="height:2px" colspan="2"><div style="border-bottom: 1px solid #CCCCCC;"></div></td></tr>
				<tr>
					<th align="left">Particulars</th>
					<th align="left">Limitation</th>
				</tr>
				<tr><td style="height:2px" colspan="2"><div style="border-bottom: 1px solid #CCCCCC;"></div></td></tr>
				<tr>
					<td>Active Projects</td>
					<td align="right"><?php echo $limitation['totproj'];?></td>
				</tr>
				<tr>
					<td>Total Users</td>
					<td align="right"><?php echo $limitation['totalusers'];?></td>
				</tr>
				<tr>
					<td>Storage</td>
					<td align="right"><?php echo $this->Format->displaystorage($limitation['used_space']);?> </td>
				</tr>
				<tr><td style="height:1px" colspan="2"><div style="border-top:1px dashed #CCCCCC"></div></td></tr>
			</table>
		</td>
	</tr>
</table>
<div style="font-size: 16px;color: #000000;line-height: 30px; margin-left: 20px; margin-top: 20px;">
	<?php  if($limitation['proj_limit_exceed']){?>
	<div> You needs to delete atleast <b><?php echo ($limitation['totproj']- $subscription['Subscription']['project_limit']); ?> Projects </b></div>
	<?php } ?>
	<?php  if($limitation['user_limit_exceed']){?>
	<div> You needs to delete atleast <b><?php echo ($limitation['totusers']- $subscription['Subscription']['user_limit']); ?> Users</b></div>
	<?php } ?>
	<?php  if($limitation['storage_limit_exceed']){?>
	<div> You needs to delete files of size <b><?php echo $this->Format->displaystorage($limitation['used_space']- $subscription['Subscription']['storage']); ?> </b></div>
	<?php } ?>
	<div>After deleting above things it is possible to downgrade your current plan</div>
	<div><font style="color: #EF439B;font-size: 16px;">Tips: <i>You can take backup of your data and delete them from Orangescrum.</i></div>
</div>