<?php if($cnt != 0) { ?>
<div class="fl"> <?php echo __('Total');?> <strong><?php echo $cnt; ?></strong> <?php echo __('Bugs created');?>.</div>
<div class="cb"></div>
<div>
	<ul>
		<li><?php echo __('Avg. days to Resolve a Bug');?>: <strong><?php echo round($avg_resolved); ?></strong></li>
		<li><?php echo __('Avg. days to Close a Bug');?>: <strong><?php echo round($avg_closed); ?></strong></li>
		<li><?php echo __('Hours spent on these Bugs');?>: <strong><?php echo $tot_hrs; ?></strong></li>
	</ul>
</div>
<?php }else{ ?>
<div class="fl"> <font color='red' size='2px'><?php echo __('No data for this date range & project');?>.</font></div>
<?php } ?>