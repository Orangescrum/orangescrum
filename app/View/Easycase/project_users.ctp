<?php /*
<div style="height:170px;" class="custom_scroll">
    <?php if (is_array($users)) {?>
        <div class="assign-user-img">
            <?php foreach ($users as $key => $val) {
				$t_nm = '';
				if(trim($val['User']['name']) == ''){
					$t_nm = explode('@',$val['User']['email']);
					$val['User']['name'] = $t_nm[0];
				}
                if($val['User']['name'] != ''){					
					$random_bgclr = $this->Format->getProfileBgColr($val['User']['id']);
					$usr_name_fst = mb_substr(trim($val['User']['name']),0,1, "utf-8");
				?>
                    <span class="overview_pimg" id="user_prof_<?php echo $val['User']['uniq_id']; ?>">
						<?php if(trim($val['User']['photo']) != ''){ ?>
                        <img title="<?php echo $val['User']['name']; ?>"  alt="" rel="tooltip" src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo trim($val['User']['photo']) != ''? trim($val['User']['photo']):'user.png'; ?>&sizex=35&sizey=35&quality=100" 
                             class="lazy round_profile_img" height="35" width="35" alt="No Image"/>
						<?php }else{ ?>
							<span title="<?php echo $val['User']['name']; ?>" rel="tooltip" class="cmn_profile_holder <?php echo $random_bgclr; ?> project_user_ov"><?php echo $usr_name_fst; ?></span>
						<?php } ?>
						<?php if(isset($extra) && $extra == 'overview' && (SES_TYPE <= 2 || ($prjusrid == SES_ID))){ ?>
						<span onclick="removeUserOverview(this);" class="remove_user_hover" data-pid="<?php echo $projid; ?>" data-uid="<?php echo $val['User']['uniq_id']; ?>" data-name="<?php echo $val['User']['name']; ?>" title="Remove <?php echo $val['User']['name']; ?> from this project"><i class="material-icons">&#xE15C;</i></span>
						<?php } ?>
                    </span>					
                <?php }?>
            <?php }?>
			
        </div>
    <?php }?>
</div> */ ?>
<style>
.pu_unm {
display:inline-block;width:60px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:13px;vertical-align:middle;}
</style>
<?php if (is_array($users)) {?>
	<div class="team">
	<table>
		<thead>
			<tr>
				<th><?php echo __('User');?></th>
				<th><?php echo __('Total Task');?></th>
				<th><?php echo __('Overdue Task');?></th>
				<th><?php echo __('Billable Hours');?></th>
				<th><?php echo __('Non-Billable Hours');?></th>
			</tr>
		</thead>
	</table>
	<div class="scroll_body">
	<table>
		<tbody>
			<?php foreach ($users as $key => $val) { 
				$t_nm = '';
				if(trim($val['User']['name']) == ''){
					$t_nm = explode('@',$val['User']['email']);
					$val['User']['name'] = $t_nm[0];
				}
				if($val['User']['name'] != ''){					
					$random_bgclr = $this->Format->getProfileBgColr($val['User']['id']);
					$usr_name_fst = mb_substr(trim($val['User']['name']),0,1, "utf-8");
			?>
			<tr id="<?php echo $projid.'_'; ?><?php echo $val['User']['uniq_id']; ?>">
				<td>
					<div class="user_name" title="<?php echo $val['User']['name'].' '.$val['User']['last_name']; ?>">
						<?php if(isset($extra) && $extra == 'overview' && $this->Format->isAllowed('Remove Users from Project',$roleAccess)){ //(SES_TYPE <= 2 || ($prjusrid == SES_ID)) ?>
						<span class="drop_icon" onclick="removeUserOverview(this);" class="remove_user_hover" data-pid="<?php echo $projid; ?>" data-uid="<?php echo $val['User']['uniq_id']; ?>" data-name="<?php echo $val['User']['name']; ?>" title="<?php echo __('Remove');?> <?php echo $val['User']['name']; ?> <?php echo __('from this project');?>"><span class="h_line"></span></span>
						<?php } ?>						
						<span class="pfl_img" id="user_prof_<?php echo $val['User']['uniq_id']; ?>">
							<?php if(trim($val['User']['photo']) != ''){ ?>
							<img title="<?php echo $val['User']['name']; ?>"  alt="" rel="tooltip" src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo trim($val['User']['photo']) != ''? trim($val['User']['photo']):'user.png'; ?>&sizex=35&sizey=35&quality=100" 
								 class="lazy round_profile_img" height="35" width="35" alt="No Image"/>
							<?php }else{ ?>
								<span title="<?php echo $val['User']['name']; ?>" rel="tooltip" class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
							<?php } ?>
						</span>
						<span class="pu_unm"><?php echo $val['User']['name']; ?></span>
					</div>
				</td>
				<td>
					<?php
						if($loggedInUser['user_type'] < 3){
							echo isset($val['ProjectUser']['tot_task'])?$val['ProjectUser']['tot_task']:0;
						}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
							if($loggedInUser['id'] == $val['User']['id']){
								echo isset($val['ProjectUser']['tot_task'])?$val['ProjectUser']['tot_task']:0;
							}else{
								echo 0;
							}
						}
					?>
				</td>
				<td class="red_txt">
					<?php
						if($loggedInUser['user_type'] < 3){
							echo isset($val['ProjectUser']['od_task'])?$val['ProjectUser']['od_task']:0;
						}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
							if($loggedInUser['id'] == $val['User']['id']){
								echo isset($val['ProjectUser']['od_task'])?$val['ProjectUser']['od_task']:0;
							}else{
								echo 0;
							}
						}
					?>
				</td>
				<td>
					<?php
						if($loggedInUser['user_type'] < 3){
							echo isset($val['ProjectUser']['billable'])?$this->Format->format_time_hr_min($val['ProjectUser']['billable'],1):0;
						}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
							if($loggedInUser['id'] == $val['User']['id']){
								echo isset($val['ProjectUser']['billable'])?$this->Format->format_time_hr_min($val['ProjectUser']['billable'],1):0;
							}else{
								echo 0;
							}
						}
					?>
				</td>
				<td>
					<?php
						if($loggedInUser['user_type'] < 3){
							echo isset($val['ProjectUser']['non_billable'])?$this->Format->format_time_hr_min($val['ProjectUser']['non_billable'],1):0;
						}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
							if($loggedInUser['id'] == $val['User']['id']){
								echo isset($val['ProjectUser']['non_billable'])?$this->Format->format_time_hr_min($val['ProjectUser']['non_billable'],1):0;
							}else{
								echo 0;
							}
						}
					?>
				</td>
			</tr>
			<?php } } ?>
		</tbody>
	</table>
	</div>
</div>
<?php } ?>