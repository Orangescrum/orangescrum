

<div class="due_task_list" style="display:none;"><?php echo __('OVERDUE TASKS');?></div>
<?php if(!empty($overdue)){ ?>
<?php foreach($overdue as $k=>$v){?>
<div class="due_task_data ellipsis-view" style="max-width: 100%;"">
    <b><?php $b=explode(" ",$v['Easycase']['due_date']);$a=explode("-",$b[0]);echo date("M ", mktime(0, 0, 0, $a[1], $a[2],$a[0]));?> <?php $b=explode(" ",$v['Easycase']['due_date']);$a=explode("-",$b[0]);echo date("d ", mktime(0, 0, 0, $a[1], $a[2],$a[0]));?></b><br/>
    <?php $projectId = $this->Casequery->getProjUniqId($v['Easycase']['project_id']); 
        $title = $this->Format->formatTitle($v['Easycase']['title']);
    ?>
    <a href="<?php echo HTTP_ROOT; ?>dashboard#details/<?php echo $v['Easycase']['uniq_id']; ?>"><?php echo $title; ?></a> 
    <br />
    <span>Late by <?php 
	$date1 = $v['Easycase']['due_date'];
	$date2 = $today;
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	echo $days;
	?> days
    </span>
</div>
<?php } ?>
<?php }else{ ?>
    <div class="fnt_clr_gry"><?php echo __('No tasks');?></div>
<?php } ?>
