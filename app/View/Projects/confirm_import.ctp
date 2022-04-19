<div class="fl_content">
	<h3 class="imp_head"><?php echo __('Import Task Group');?>/<?php echo __('Task');?></h3>
	<div style="margin-left:20px">
		<ul id="breadcrumbs_imp">
			<li><?php echo __('Upload File');?></li>
			<li> <?php echo __('Preview Data');?></li>
			<li class="activ"><?php echo __('Upload Summary');?></li>
		</ul>
		<div id="review_data">
			<table class="fyl_table">
				<tr>
					<th style="padding-bottom:10px" colspan="2"><h3><?php echo __('Upload Summary');?></h3></th>
				</tr>
				<tr>
					<td colspan="2"><?php echo __('Input CSV file');?>:&nbsp;<?php echo $csv_file_name;?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo __('Total data');?>:&nbsp;<?php echo $total_rows;?> <?php echo __('rows');?></td>
				</tr>
				<tr>
					<td colspan="2" ><?php echo __('Valid data');?>:&nbsp;<?php echo $total_valid_rows;?> <?php echo __('rows');?></td>
				</tr>
				<tr>
					<td valign="top"><?php echo __('Task Group');?>:&nbsp;</td>
					<td>
						<?php foreach($history AS $key=>$val){?>
								<table style="text-align:left" cellpadding='0' cellspacing='0'>
									<tr>
										<td>
											<?php echo $val['milestone_title'];?> / <?php echo $val['total_task'];?> <?php echo __('Task(s)');?>
										</td>
									</tr>
								</table>
						<?php }?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>