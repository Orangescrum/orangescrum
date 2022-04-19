<div class="bread_crumb">
	<div class="overview_wrapper">
		<ul>
			<li class="a_task">	
			 <?php if($_SESSION['project_methodology'] =='simple'){
			 	$taskURL = HTTP_ROOT . 'dashboard#tasks';
			 }else if( $_SESSION['project_methodology'] =='scrum'){
			 	$taskURL = HTTP_ROOT . 'dashboard#backlog';
			 }else{
			 	$taskURL = HTTP_ROOT . 'dashboard#kanban';
			 }?>	
			<a class="" href="<?php echo $taskURL; ?>" onclick="trackEventLeadTracker('Overview Page','Task List','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('tasks');"><?php echo __('All Task');?> (<span id="ov_tsk_entry_cnt">0</span>)</a>			
			</li>
			 <?php /* <li class="m_task">				
				My task(40)
			</li> */ ?>
			
			<li class="activity_icon">				
				<a class="" href="<?php echo HTTP_ROOT . 'dashboard#activities'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Activities','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('activities');"><?php echo __('Activities');?> (<span id="ov_atvt_entry_cnt">0</span>)</a>
			</li>
			
			<li class="m_task">				
				<a class="" href="javascript:void(0);" onclick="" style="cursor:default;border-bottom:none;"><?php echo __('Project Est.:');?> (<span ><?php echo ($proj['Project']['estimated_hours'])?$proj['Project']['estimated_hours']:0;?> <?php echo ($proj['Project']['estimated_hours'] > 1)? 'hrs': 'hr'; ?></span>)</a>
			</li>
			
			<li class="t_entry">				
				<a class="" href="javascript:void(0);" onclick="" style="cursor:default;border-bottom:none;"><?php echo __('Task Est.:');?> (<span ><?php echo $f_estd;?></span>)</a>
			</li>
			
			<li class="t_entry">
				<?php 
				$timelogurl = '';
				$timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
				?>
				<a class="" href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Time Log','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('timelog');"><?php echo __('Time Entry');?> (<span id="ov_tim_entry_cnt">0</span>)</a>
			</li>
			
		</ul>
	</div>
</div>