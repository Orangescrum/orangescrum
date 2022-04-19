<table id="project_utilization" class="table table-striped tbl_cmn proj_wis_res">
	<tr>
		<th><?php echo __('Title');?></th>
		<th><?php echo __('This month work');?></th>
		<th class="text-center"><?php echo __('Future work');?></th>
	</tr>
    <?php foreach($topprojects as $pid=>$pnm){ 
        $prevmnthhour = $prevmonthdata[$pid][$pnm];
        $thismnthhour = $thismonthdata[$pid][$pnm];
        $futurehour = $futureWorkdata[$pid][$pnm];
        $uptxt = '';
        $upcls = '';
        $totxt = 'from ';
        $percentage = '';
        $percentageUp = '';
        if($thismnthhour > $prevmnthhour){
            $uptxt = 'Up';
            $upcls = 'up-div';
            $percentage = (int)(($thismnthhour-$prevmnthhour)/$prevmnthhour)*100;
            $percentageUp = $percentage-100;
        }elseif($thismnthhour < $prevmnthhour){
            $uptxt = 'Down';
            $upcls = 'down-div';
            $percentage = (int)(($thismnthhour-$prevmnthhour)/$prevmnthhour)*100;
            $percentageUp = 100-$percentage.'% ';
        }else{
            $uptxt = 'Equals';
            $upcls = 'up-div';
            $totxt = 'to ';
        }
    ?>
    <tr>
        <td><?php echo $pnm; ?></td>
        <td  class="tm_work">
            <div class="last_30">
                <div class="fl <?php if($upcls == 'up-div'){ ?>info_lst<?php }else{?>warn_lst<?php } ?>">
                    <h4><?php echo $this->Format->formatHour($thismnthhour); ?></h4>
                </div>
                <div class="fl">
                    <span class="label <?php if($upcls == 'up-div'){ ?>label-info<?php }else{?>label-warn<?php } ?>"><?php echo $uptxt . ' ' . $percentageUp . $totxt . $this->Format->formatHour($prevmnthhour); ?></span>
                    <h6><?php echo __('Last month to Date');?></h6>
                </div>
								<div class="cb"></div>
            </div>
        </td>
        <td class="text-center future_work"><strong><?php echo $this->Format->formatHour($futurehour); ?></strong></td>
    </tr>
    <?php } ?>
</table>