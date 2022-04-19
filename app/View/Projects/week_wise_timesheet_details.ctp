<style>
	.checklist-report table{border:none}
	.checklist-report table tr th{background-color:#efefef;padding:5px 8px;font-size:14px;color:#7B7878;font-weight: 600;border: 1px solid #ddd;}
    .checklist-report table tr td {padding:5px 8px;text-align: left;font-size: 13px;border:1px solid #eee}
    .checklist-report table tr td.final_prj_hrs {font-size:16px}
    .checklist-report table tr td.final_hrs {font-size:20px}
</style>
<div class="data-scroll checklist-report scrolltotopclass">
	<div class="row">
    <div class="col-lg-12">
		<input type="hidden" id="approvers_user_id" />
		<input type="hidden" id="approvers_record_id" />
		<input type="hidden" id="approver_id" />
		<input type="hidden" id="approve_start_week" />
		<input type="hidden" id="approve_end_week" />
		<table class="width100">
			<thead>
				<tr>
					<th class="tableHeading">Project</th>
					<th class="tableHeading">Task</th>
					<?php
						$dayofApproverStartWeek = date("d", strtotime($approve_start_week));
						$dayofApproverendWeek = date("d", strtotime($approve_end_week));
						
						for($i = 0;$i < 7;$i++){
						$newWeekDate = date('Y-m-d', strtotime($approve_start_week. ' + '.$i.' days'));
					?>
						<th class="tableHeading"><?php echo date("m/d", strtotime($newWeekDate)); ?></th>
					<?php } ?>
					<th class="tableHeading">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$totalHoursProject = 0;
					$finalTotalHours = 0;
					foreach($newTimeLogArray as $k => $v){
				?>
					<tr>
						<td><?php echo $v['projects']['name']; ?></td>
						<td><?php echo $v['easycases']['case_no']. ": " . $v['easycases']['title']; ?></td>
						<?php
							$dayofApproverStartWeek = date("d", strtotime($approve_start_week));
							$dayofApproverendWeek = date("d", strtotime($approve_end_week));
							$totalHoursProject = 0;
							for($j = 0;$j < 7;$j++){
								//$newFormatedDate = date("Y-m", strtotime($approve_start_week))."-".$j;
								$newFormatedDate = date('Y-m-d', strtotime($approve_start_week. ' + '.$j.' days'));
								if(isset($v['log_times'][$newFormatedDate]) && count($v['log_times'][$newFormatedDate]) > 0){
									$totalHoursProject = $totalHoursProject + $v['log_times'][$newFormatedDate]['total_hours'];
						?>
									<td class="text-center">
										<?php echo $this->Format->format_second_hrmin_pad($v['log_times'][$newFormatedDate]['total_hours']); ?> 
										<span>
											<?php if($v['log_times'][$newFormatedDate]['is_billable'] == 1){ ?>
												<img src="<?php echo HTTP_ROOT; ?>img/billable.png" style="width:12px;" title="<?php echo __("Billable Hours"); ?>" alt="<?php echo __("Billable Hours"); ?>" />
											<?php } ?>
										</span>
									</td>
						<?php 	
								}else{
						?>
									<td><?php echo "00:00"; ?></td>
						<?php
								}
							}
							$finalTotalHours = $finalTotalHours + $totalHoursProject;
						?>
						<td class="final_prj_hrs"><strong><?php echo $this->Format->format_second_hrmin_pad($totalHoursProject); ?></strong></td>
					</tr>
				<?php } ?>
				<tr><td colspan="11">&nbsp;</td></tr>
				<tr>
					<td colspan="2"><strong>Total</strong></td>
					<?php
						$dayofApproverStartWeek = date("d", strtotime($approve_start_week));
						$dayofApproverendWeek = date("d", strtotime($approve_end_week));
						for($j = 0;$j < 7;$j++){
							$newFormatedDate = date('Y-m-d', strtotime($approve_start_week. ' + '.$j.' days'));
							if(isset($dateWiseTotalHours[$newFormatedDate])){
								$displayTotalDayHrs = $dateWiseTotalHours[$newFormatedDate];
							}else{
								$displayTotalDayHrs = "00:00";
							}
					?>
								<td><strong><?php echo $this->Format->format_second_hrmin_pad($displayTotalDayHrs); ?></strong></td>
					<?php } ?>
					<td class="final_hrs"><strong><?php echo $this->Format->format_second_hrmin_pad($finalTotalHours); ?></strong></td>
				</tr>
			</tbody>
		</table>
    </div>
	<div class="col-lg-12">
		<table class="width100">
			<tr class="displayRejectNotePanel" style="display:none;">
				<td><strong>Reject Note :</strong> </td>
				<td class="text-left"><textarea name="rejectNote" id="rejectNoteId" class="form-control" onkeypress="removeErr('rjctErr')"></textarea>
                                    <span id="rjctErr" class="text-danger"></span>
                                </td>
			</tr>
                        <?php if($flag!=1) { ?>
			<tr id="approve_tr">
				<td colspan="2">
					<div class="text-right pad15">
					<span id="displayPopupButtons">
						<span class="hover-pop-btn d-inline-block"><a href="javascript:void(0)" onclick="approveRejectTimeSheetPopup('approve')" id="approveBtnId" class="btn cmn_size btn_cmn_efect cmn_bg btn-info"><?php echo __("Approve");?></a></span>
						<span class="hover-pop-btn d-inline-block ml-15"><a onclick="approveRejectTimeSheetPopup('reject')" href="javascript:void(0)" id="rejectBtnId" class="btn cmn_size btn_cmn_efect cmn_bg btn_reject"><?php echo __("Reject");?></a></span>
					</span>
                                        <span id="displayRejectPopupButtons" style="display:none">
                                                 <button type="button" value="button" name="crtComment" class="btn btn-default btn_hover_link cmn_size" onclick="cancelReject();">
                                                    <i class="icon-big-tick"></i><?php echo __("Cancel");?>
                                                </button>
                                                <button type="button" name="crtComment" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="approveRejectTimeSheetPopup('reject')">
                                                    <i class="icon-big-tick"></i><?php echo __("Confirm");?>
                                                </button>
                                        <?php /*
						<span class="hover-pop-btn d-inline-block"><a href="javascript:void(0)" onclick="cancelReject()" id="approveBtnId" class="btn cmn_size btn_cmn_efect cmn_bg btn-info">Approve</a></span>
						<span class="hover-pop-btn d-inline-block ml-15"><a onclick="approveRejectTimeSheetPopup('reject')" href="javascript:void(0)" id="rejectBtnId" class="btn cmn_size btn_cmn_efect cmn_bg btn_reject"><?php echo __("Confirm");?></a></span>
					*/?>
                                        </span>
					<span style="display:none" id="displayPopupLoader">
						<img alt="Loading..." title="Loading..." src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif">
					</span>
					</div>
				</td>
			</tr>
                        <?php } ?>
		</table>
	</div>
	<div class="cb"></div>
	</div>
</div>