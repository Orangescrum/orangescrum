<div class="milestone_side_view_main">
  <div class="milestone_slide_toggle">Task Groups</div>	
	<div class="milestone_side_view">
		<div class="d-flex alltask_group align-item-center">
  		<h6 onclick="subtaskFilterByMilestone(<%= '\'\'' %>);">
  				<?php echo __('All Task Groups'); ?>
      </h6>
  		<div class="close_icon"><i class="material-icons">close</i></div>
  	</div>
  	
  	<div class="milestone_side_view_container">
  		<div class="search_box">
  			<i class="mil_search_icon material-icons">&#xE8B6;</i>
  			<input type="text" placeholder="Search" class="" id="milestone_search" onkeyup="searchMilestoneItems(this, event);">
  			<input type="hidden" value="" id="is_mil_search" />
  		</div>
  		<div class="milestone_side_view_content"></div>
  		<div class="mil_paginate">
  			<div class="left fl disable" onclick="showNextPrevMilestone(this, 0);" rel="tooltip" title="Previous">
  				<i class="material-icons">navigate_before</i>
  			</div>
  			<div class="right fr active" onclick="showNextPrevMilestone(this, 1);" rel="tooltip" title="Next">
  				<i class="material-icons">navigate_next</i>
  			</div>
			<div class="cb"></div>
  		</div>
			
			<div class="milestone_loader_dv"><?php echo __('Loading Task Group...'); ?></div>
  	</div>
  	<input type="hidden" value="" id="milePageCount" />
  	
</div>
</div>