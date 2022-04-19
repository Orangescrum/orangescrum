<?php if(isset($recent_activities) && !empty($recent_activities)) {
    $cnt = 0;
	$lastdate = '';
     foreach ($recent_activities as $key => $value) {
	 $cnt++;
    ?>
        <?php if (($value['Easycase']['pclient_status'] == 1 && $value['Easycase']['puserid'] == SES_ID) || $value['Easycase']['pclient_status'] != 1 || SES_TYPE < 3) { ?>
	<?php if(isset($extra) && !empty($extra)){ ?>
		<?php if($cnt == 1){ ?>
		<ul>
		<?php } ?>
			<li>
				<span class="pfl_img" rel="tooltip" title="<?php echo ucfirst($value['User']['funll_name']); ?>">
					<?php if($value['User']['photo']){ ?>
						<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['User']['photo']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['User']['name']; ?>" rel="tooltip" alt="Loading"/>
					<?php }else{
						$random_bgclr = $this->Format->getProfileBgColr($value['User']['id']);
						$usr_name_fst = mb_substr(trim($value['User']['name']),0,1, "utf-8");
					?>
						<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
					<?php }?>
				</span>
				<div class="date" <?php if($value['Easycase']['newActuldt'] == $lastdate){ ?> style="display:none;"<?php } ?>>
					<?php echo $value['Easycase']['newActuldt']; ?>
				</div>
				<?php $lastdate = $value['Easycase']['newActuldt']; ?>
				<div class="type"><?php echo $value['Easycase']['nmsg']; ?></div>
				<div class="link_time">
					<a href="" title="<?php echo strip_tags($value['Easycase']['ntxt']); ?>"><?php echo $value['Easycase']['ntxt']; ?></a>
					<span class="time"><?php echo $value['Easycase']['updated']; ?></span>
					<div class="clearfix"></div>
				</div>
				<div class="name"><?php echo ucfirst($value['User']['name']); ?></div>
			</li>
		<?php if($cnt == count($recent_activities)){ ?>
		</ul>
		<?php } ?>
	<?php }else{ ?>
    <div class="gray-dot" <?php if($value['Easycase']['newActuldt'] == $lastdate){ ?> style="display:none;"<?php } ?>>
        <div class="activity-date"><?php echo $value['Easycase']['newActuldt']; ?></div>
    </div>
    <?php $lastdate = $value['Easycase']['newActuldt']; ?>
    <div class="activity-row">
        <span class="activity-img" rel="tooltip" title="<?php echo ucfirst($value['User']['funll_name']); ?>">
		<?php if($value['User']['photo']){ ?>
            <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['User']['photo']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['User']['name']; ?>" rel="tooltip" alt="Loading"/>
        <?php }else{
			$random_bgclr = $this->Format->getProfileBgColr($value['User']['id']);
			$usr_name_fst = mb_substr(trim($value['User']['name']),0,1, "utf-8");
		?>
			<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
        <?php }?>
        </span>
        <small class="fr activity-time"><?php echo $value['Easycase']['updated']; ?></small>
        <span class="red-txt"><?php echo $value['Easycase']['nmsg']; ?></span>
        <p class="linkable-txt" title="<?php echo strip_tags($value['Easycase']['ntxt']); ?>"><?php echo $value['Easycase']['ntxt']; ?></p>
        <?php if($project == 'all'){ ?>
                        <p style="color:#6699ff;"><i class="material-icons" style="font-size: 18px;vertical-align: middle;">work</i><a href="<?php echo HTTP_ROOT; ?>dashboard/?project=<?php echo $value['Project']['uniq_id']; ?>" title="<?php echo ucfirst($value['Project']['name']); ?>" style="color:#6699ff;vertical-align: middle;"><?php echo ucfirst($value['Project']['short_name']); ?></a></p>
        <?php } ?>
        <span><?php echo ucfirst($value['User']['name']); ?></span>
    </div>
	<?php } ?>
<?php } ?>
    <?php } ?>
	<div id="recent_activities_more" data-value="<?php echo $total;?>" style="display: none;"></div>
	<div class="fr moredb" id="more_recent_activities"><a href="javascript:void(0);" onclick="showTasks('activities');"><?php echo __('View All');?> <span id="todos_cnt" style="display:none;">(0)</span></a></div>

<?php } else { ?>
	<?php if(isset($extra) && !empty($extra)){ ?>
		<div class="scroll_body empty_line_cont">
			<ul>
				<li>
					<span class="pfl_img"></span>
					<div class="line_bar medium blue"></div>
					<div class="line_bar small dark_gray"></div>
					<div class="line_bar small gray"></div>
				</li>
				<li>
					<span class="pfl_img"></span>
					<div class="line_bar medium blue"></div>
					<div class="line_bar small dark_gray"></div>
					<div class="line_bar small gray"></div>
				</li>
				<li>
					<span class="pfl_img"></span>
					<div class="line_bar medium blue"></div>
					<div class="line_bar small dark_gray"></div>
					<div class="line_bar small gray"></div>
				</li>
				<li>
					<span class="pfl_img"></span>
					<div class="line_bar medium blue"></div>
					<div class="line_bar small dark_gray"></div>
					<div class="line_bar small gray"></div>
				</li>
			</ul>
			<div class="data_not_avail">No Data Available</div>
		</div>
	<?php }else{ ?>
	 <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
	<div class="mytask" onclick="setSessionStorage('Recent Activities Page', 'Create Task');creatask();"></div>
	<?php } ?>
	<div class="mytask_txt"><?php echo __('No Recent Activities');?></div>
    <div id="recent_activities_more" class="dash-activity-cont" data-value="0" style="display: none;"></div>
<?php } ?>
<?php } ?>