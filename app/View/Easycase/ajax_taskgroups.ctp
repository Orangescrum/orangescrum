<?php
$i=0;
$all_mil = 0;
$tot_inactive = 0;
$tot_active = 0;
if(isset($milestones)){
        $all_mil = count($milestones);
        foreach($milestones as $k => $milestone) { 
            if($milestone['Milestone']['isactive'] == 1){
                $tot_active = $tot_active+1;
            }else{
                $tot_inactive = $tot_inactive + 1;
            }
        }
        $grp_fil = 'all';
        
        if(isset($_COOKIE['TASKGROUP_FIL'])){
           if($_COOKIE['TASKGROUP_FIL'] == 'active') {
		$grp_fil = 1;
            }else if($_COOKIE['TASKGROUP_FIL'] == 'completed') {
		$grp_fil = 0;
            }
        }
	?>
	<li class="slide_menu_div1 li_check_radio">
       	<div class="radio radio-primary">
		  <label>
			<input type="radio" name="data['milestone]" value="all" id="alltaskgroups" onclick="checkTaskgroups('all')" <?php if ($grp_fil == 'all') { echo "checked"; } ?> class="milestone_fliter_cls" style="cursor:pointer"/> <?php echo __('All');?> (<?php echo $all_mil;?>)
		  </label>
		</div>
	</li>
	<li class="li_check_radio">	    
		<div class="radio radio-primary">
		  <label>
			<input type="radio" name="data['milestone]" class="milestone_fliter_cls" style="cursor:pointer" id="taskgroupActive" <?php if ($grp_fil == '1') { echo "checked"; } ?> onclick="checkTaskgroups('active')"/> <?php echo __("Active")." (<b>".$tot_active."</b>)";  ?>
		  </label>
		</div>
	</li>
	<li class="li_check_radio">	   
		<div class="radio radio-primary">
		  <label>
			<input type="radio" name="data['milestone]" class="milestone_fliter_cls" style="cursor:pointer" id="taskgroupComplete" <?php if ($grp_fil == '0') { echo "checked"; } ?> onclick="checkTaskgroups('completed')"/> <?php echo __("Completed")." (<b>".$tot_inactive."</b>)"; ?>
		  </label>
		</div>
	</li>
<?php }else{ ?>
    <li><?php echo __('No Task Group');?></li>
<?php } ?>
