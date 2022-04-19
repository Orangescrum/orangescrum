<?php
if(!$tot_hrs) {
		$tot_hrs = 0;
}
?>
<div class="row mtop20 tsb_wrap">
    <div class="col-lg-6 col-sm-6">
        <div class="tsc-box">
            <h3><?php echo $cnt; ?></h3>
            <p><?php echo __('Total Tasks Created');?></p>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="tsr-box">
            <h3><?php echo round($avg_resolved,2); ?></h3>
            <p><?php echo __('Avg days to Resolve a Task');?></p>
        </div>
    </div>
		<div class="cb"></div>
</div>
<div class="row mtop20 tsb_wrap">
    <div class="col-lg-6 col-sm-6">
        <div class="tsp-box">
            <h3><?php echo $tot_hrs; ?></h3>
            <p><?php echo __('Spent on these Task');?></p>
        </div>
    </div>
    <div class="col-lg-6 col-sm-6">
        <div class="tsct-box">
            <h3><?php echo round($avg_closed,2); ?></h3>
            <p><?php echo __('Avg days to Close a Task');?></p>
        </div>
    </div>
		<div class="cb"></div>
</div>