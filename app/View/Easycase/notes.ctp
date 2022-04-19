<?php if(isset($project_notes) && !empty($project_notes)) {
    $cnt = 0;
	$lastdate = '';
     foreach ($project_notes as $key => $value) {
	 $cnt++;
    ?>
        <?php if( SES_TYPE < 3) { ?>
	<?php if(isset($extra) && !empty($extra)){ ?>
		<?php if($cnt == 1){ ?>
		<ul>
		<?php } ?>
			<li>
				<span class="pfl_img" rel="tooltip" title="<?php echo ucfirst($value['User']['name']).' '.ucfirst($value['User']['last_name']); ?>">
					<?php if($value['User']['photo']){ ?>
						<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['User']['photo']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['User']['name']; ?>" rel="tooltip" alt="Loading"/>
					<?php }else{
						$random_bgclr = $this->Format->getProfileBgColr($value['User']['id']);
						$usr_name_fst = mb_substr(trim($value['User']['name']),0,1, "utf-8");
					?>
						<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
					<?php }?>
				</span>
				<div class="date" <?php if($value['ProjectNote']['created'] == $lastdate){ ?> style="display:none;"<?php } ?>>
					<?php echo date('M d, Y', strtotime($value['ProjectNote']['created'])); ?>
				</div>
				<?php $lastdate = $value['ProjectNote']['created']; ?>
				<div class="type"><?php echo $value['ProjectNote']['note']; ?></div>
				<div class="link_time">
					<a href="" title="<?php echo strip_tags($value['ProjectNote']['note']); ?>"><?php echo $value['ProjectNote']['notes']; ?></a>
					<span class="time"><?php //echo $value['ProjectNote']['created']; ?></span>
					<div class="clearfix"></div>
				</div>
				<div class="name"><?php echo ucfirst($value['User']['name']); ?></div>
			</li>
		<?php if($cnt == count($project_notes)){ ?>
		</ul>
		<?php } ?>
	<?php }else{ ?>
    <div class="gray-dot" <?php if($value['Easycase']['newActuldt'] == $lastdate){ ?> style="display:none;"<?php } ?>>
        <div class="activity-date"><?php echo $value['Easycase']['newActuldt']; ?></div>
    </div>
    <?php $lastdate = $value['Easycase']['newActuldt']; ?>
    <div class="activity-row">
        <span class="activity-img" rel="tooltip" title="<?php echo ucfirst($value['User']['name']); ?>">
		<?php if($value['User']['photo']){ ?>
            <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['User']['photo']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['User']['name']; ?>" rel="tooltip" alt="Loading"/>
        <?php }else{
			$random_bgclr = $this->Format->getProfileBgColr($value['User']['id']);
			$usr_name_fst = mb_substr(trim($value['User']['name']),0,1, "utf-8");
		?>
			<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
        <?php }?>
        </span>
        <small class="fr activity-time"><?php echo $value['ProjectNote']['created']; ?></small>
        <span class="red-txt"><?php echo $value['ProjectNote']['note']; ?></span>
        <p class="linkable-txt" title="<?php echo strip_tags($value['ProjectNote']['note']); ?>"><?php echo $value['ProjectNote']['note']; ?></p>
     
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
	
	<div class="mytask_txt"><?php echo __('No Data Available');?></div>
    <div id="recent_activities_more" class="dash-activity-cont" data-value="0" style="display: none;"></div>
<?php } ?>
<?php } ?>