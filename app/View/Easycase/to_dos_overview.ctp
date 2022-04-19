<?php if (isset($gettodos_overview) && !empty($gettodos_overview)) { ?>
<table>
	<thead>
		<tr>
			<th><?php echo __('User Name');?></th>
			<th><?php echo __('Task Name');?></th>
			<th><?php echo __('Due Date');?></th>
			<th><?php echo __('Late by Date');?></th>
		</tr>
	</thead>
</table>
<div class="scroll_body">
	<table>
	<tbody>
		<?php foreach ($gettodos_overview as $key => $value) { if($value['Easycase']['assign_to'] == 0){$value['User']['name'] = 'Unassigned';} ?>
			<tr>
				<td>
					<div class="user_name">
						<span class="pfl_img">
							<span rel="tooltip" title="<?php echo ucfirst($value['User']['name'].' '.$value['User']['last_name']); ?>">
							<?php if($value['User']['photo']){ ?>
								<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['User']['photo']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['User']['name']; ?>" rel="tooltip" alt="Loading"/>
								<?php }else{
									$random_bgclr = $this->Format->getProfileBgColr($value['User']['uid']);
									if(!$random_bgclr){$random_bgclr = 'unassign';}
									$usr_name_fst = mb_substr(trim($value['User']['name']),0,1, "utf-8");
								?>
								<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
							<?php }?>
							</span>
						</span>
						<?php echo $value['User']['name'].' '.$value['User']['last_name']; ?>
					</div>
				</td>
				<td>
					<a href="javascript:void(0);" onclick= "openCaseDetailPopupArc('<?php echo $value['Easycase']['uniq_id'];?>');">#<?php echo $value['Easycase']['case_no'] . ": " . $value['Easycase']['title']; ?> </a>
				</td>
				<td><?php echo $value['Easycase']['due_date'] ; ?></td>
				<td class="red_txt"><?php echo $value['Easycase']['due_dateby'] ; ?></td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
</div>
<?php }else{ ?>
	<div class="scroll_body empty_line_cont">
		<table>
			<tbody>
				<tr>
					<td>
						<div class="user_name">
							<span class="pfl_img drk_gray"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small red"></div></td>
				</tr>
				<tr>
					<td>
						<div class="user_name">
							<span class="pfl_img drk_gray"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small red"></div></td>
				</tr>
				<tr>
					<td>
						<div class="user_name">
							<span class="pfl_img orange"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small red"></div></td>
				</tr>
				<tr>
					<td>
						<div class="user_name">
							<span class="pfl_img blue"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small gray"></div></td>
					<td><div class="line_bar small red"></div></td>
				</tr>
			</tbody>
		</table>
		<div class="data_not_avail">No Data Available</div>
		</div>
<?php } ?>

<style type="text/css">
    .inactiveDetails:hover, .inactiveDetails:active,.inactiveDetails:link,.inactiveDetails:visited {
        text-decoration: none;
        color: black;
    }
</style>
<input type="hidden" value="<?php echo $Od_total; ?>" id="only_overdue_count" />
<script type="text/javascript">
    function overdue_show_task(value) {
        var new_val = value.split(',');
        openPopup();
        $(".loader_dv").show();
        $(".inactive_caseDetails").show();
        var Id = new_val[0];
        var proId = new_val[1];
        var inact = new_val[2];
        var caseUniqId = new_val[3];
        if (inact == 2) {
            $.post(HTTP_ROOT + "easycases/inactive_case_details", {'id': Id, 'proId': proId, 'caseUniqId': caseUniqId}, function (data) {
                if (data) {
                    $("#inactiveCaseDetails").html(tmpl("inactive_case_details_tmpl", data));
                    $(".loader_dv").hide();
                }
            }, 'json');
        }
    }

</script>
