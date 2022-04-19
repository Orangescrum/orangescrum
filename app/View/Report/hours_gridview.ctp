    <table class="table">
        <tr>
            
            <th class="tophead_first">
                <?php echo __('Name');?>
            </th>
            <th class="tophead">
                <?php echo __('Replies');?>
            </th>
            <th class="tophead">
                <?php echo __('Resolved/Closed');?>
            </th>
            <th class="tophead">
                <?php echo __('Hours Spent');?>
            </th>
        </tr>
        <?php
        if (!empty($users)) {
            $count = 0;
            $clas = "";
            $thrs = array();
            $mnhrs = array();
            foreach ($users as $k => $v) {
                $user_id = $v['User']['id'];
                $count++;
                /*$thrs[] = $loglist[$user_id];
                if (isset($mainhrarr[$v['e']['user_id']])) {
                    $mnhrs[] = $mainhrarr[$v['e']['user_id']];
                }*/
				
				
				if($loggedInUser['user_type'] < 3){
					$thrs[] = $loglist[$user_id];
					if (isset($mainhrarr[$v['e']['user_id']])) {
						$mnhrs[] = $mainhrarr[$v['e']['user_id']];
					}
				}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
					if($loggedInUser['id'] == $user_id){
                $thrs[] = $loglist[$user_id];
                if (isset($mainhrarr[$v['e']['user_id']])) {
                    $mnhrs[] = $mainhrarr[$v['e']['user_id']];
                }
					}
				}
                $clas = ($count % 2 == 0) ? "row_col" : "row_col_alt";
                ?>
                <tr class="<?php echo $clas ?>" id="userlist<?php echo $count; ?>" <?php if ($prjAllArr['Project']['isactive'] == 2) { ?> style="background-color:#FEE2E2;" <?php } ?>>	
                    <td class="hr_spent_row"><?php echo $v['User']['name']; ?></td>
                    <td align="right" class="hr_spent_row_lower">
						<?php
							if($loggedInUser['user_type'] < 3){
								echo (isset($replylist[$user_id])) ? $replylist[$user_id] : 0;
							}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
								if($loggedInUser['id'] == $user_id){
									echo (isset($replylist[$user_id])) ? $replylist[$user_id] : 0;
								}else{
									echo 0;
								}
							}
						?>
                    </td>
                    <td align="right" class="hr_spent_row">                                                            
						<?php
							if($loggedInUser['user_type'] < 3){
								echo (isset($resarr[$user_id])) ? $resarr[$user_id] : 0;
							}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
								if($loggedInUser['id'] == $user_id){
									echo (isset($resarr[$user_id])) ? $resarr[$user_id] : 0;
								}else{
									echo 0;
								}
							}
						?>
                    </td>
                    <td align="right" class="hr_spent_row" style="font-weight:bold;">
						<?php
							if($loggedInUser['user_type'] < 3){
								echo (isset($loglist[$user_id])) ? $this->format->format_time_hr_min($loglist[$user_id]) : '0';
							}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
								if($loggedInUser['id'] == $user_id){
									echo (isset($loglist[$user_id])) ? $this->format->format_time_hr_min($loglist[$user_id]) : '0';
								}else{
									echo 0;
								}
							}
						?>
                    </td>
                </tr>	
            <?php } ?>
            <input type="hidden" id="thrs" value="<?php echo $this->format->format_time_hr_min(array_sum($thrs) + array_sum($mnhrs)); ?>" />	
<?php }else{  ?>
                <tr><td class="no_match_td" colspan="4" align="center"><?php echo __("No Results Found"); ?></td></tr>
<?php } ?>
    </table>
