<?php
	if(count($list)) {
	//$count = $lastCount;
	$count = $limit_one;
	$legendClass = '';
	foreach($list as $lis)
	{ 
		$count++;
		$caseDtUploaded = $lis['Archive']['dt_created'];
		$updated = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$caseDtUploaded,"datetime");
		$updatedCur = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,GMT_DATETIME,"date");
		$displayTime = $this->Datetime->dateFormatOutputdateTime_day($updated,$updatedCur); //Nov 25, Thu at 1:25 pm
        $curCreated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $caseDueDate = $lis['Easycase']['due_date'];
        if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00" && $caseDueDate != "" && $caseDueDate != "1970-01-01") {
            $csDuDtFmtT = $this->Datetime->facebook_datestyle($caseDueDate);
            $csDuDtFmt = $this->Datetime->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
        }else{
            $csDuDtFmtT = '';
            $csDuDtFmt = '';
        }
?>
	
	<tr class="tr_all all_first_rows" id="cslisting<?php echo $count; ?>" data-value="<?php echo $count; ?>">		
		<td class="check_list_task">
			<div class="checkbox">
			  <label>
				<input id="case<?php echo $count; ?>" value="<?php echo $lis['Easycase']['uniq_id'];?>" type="checkbox" class="mglt chkOneArcCase">				
			  </label>
			</div>
			<input type="hidden" id="csn<?php echo $count;?>" value="<?php echo $lis['Easycase']['case_no'];?>">
		</td>		
		<td class="text-center">
		<a class="cmn_link_color" href="javascript:void(0);" onclick= "openCaseDetailPopupArc('<?php echo $lis['Easycase']['uniq_id'];?>');" >
    <?php echo $lis['Easycase']['case_no']?>
    </a>
		</td>
		<td>
            <?php //echo $this->Format->showSubtaskTitle($lis['Easycase']['title'], $lis['Easycase']['id'], $related_tasks, 0, $lis['Easycase']); ?>
			
			<a href="javascript:void(0);"onclick= "openCaseDetailPopupArc('<?php echo $lis['Easycase']['uniq_id'];?>');" class="cmn_link_color"><?php echo $lis['Easycase']['title']; ?></a>
			
			<?php if($lis['Easycase']['parent_task_id'] && $lis['Easycase']['parent_task_id'] != ""){ ?>
			<span class="fr task_parent_block task_parent_block_addn" id="task_parent_id_block_<?php echo $lis['Easycase']['uniq_id']; ?>">
				<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<?php echo $lis['Easycase']['id']; ?>,'<?php echo $lis['Easycase']['uniq_id']; ?>',<?php echo $lis['Easycase']['parent_task_id']; ?>);" class="fl icons_parents_tt_archive"><i class="material-icons ptask">&#xE23E;</i></div>
				<div class="dropdown dropup fl1 open1 showParents">
					<ul class="dropdown-menu  bottom_dropdown-caret inner_parent_ul">
						<li class="pop_arrow_new"></li>
						<li class="task_parent_msg" style=""><?php echo __('Below tasks are parent task of this Subtask');?>.</li>
						<li>
							<ul class="task_parent_tt_items" id="task_parent_tt_<?php echo $lis['Easycase']['uniq_id']; ?>" style="">
								<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
							</ul>
						</li>
					</ul>
				</div>
			</span>
			<?php } ?>	
			
			<div>
				<span class="list-devlop-txt">
					<?php echo __("Archived by");?> <?php echo $lis['User']['short_name'];?>
					<?php if(strpos($displayTime,'Today')===false && strpos($displayTime,'Y\'day')===false) echo 'on'; ?>
					<?php echo $displayTime; ?>
				</span>
			</div>
		</td>
		<td class="due_dt_tlist">
            <?php if (!empty($csDuDtFmt)) {
                echo $csDuDtFmt; 
            } ?>
        </td>
		<td>
			<?php
				if(isset($allStatus) && array_key_exists($lis['Easycase']['project_id'], $allStatus)){
					echo $this->Format->getCustomStatusProj($allStatus, $lis['Easycase']['project_id'], $lis['Easycase']['custom_status_id']);
				}else{
					echo $this->Format->getStatus($lis['Easycase']['type_id'],$lis['Easycase']['legend']);
				}
			?>	
		</td>
		<td>
			<div>
				<?php 
					if($lis['Easycase']['project_id'])
					{
						$projectname = $this->Casequery->getpjname($lis['Easycase']['project_id']);
						echo $projectname;
					}
				?>
			</div>
		</td>
	</tr>
	
	<?php
		} }else{
	?>	
	 <tr class="empty_task_tr">
		<td colspan="7">
			<?php echo $this->element('no_data', array('nodata_name' => 'caselist')); ?>
		</td>
	</tr>
	<?php } ?>

	<?php if($lastCount < 15){ ?>
		<?php /*?><input type="hidden" id="all" class="all_count" value="<?php echo $count;?>"><?php */?>
		<input type="hidden" id="pjid" class="pj_id" value="<?php echo $pjid;?>">
		<input type="hidden" id="totalCases" class="total_case_count" value="<?php echo $caseCount;?>">
		<input type="hidden" id="displayedCases" value="<?php echo ARC_CASE_PAGE_LIMIT; ?>">
	<?php } ?>