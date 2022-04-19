<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<div class="proj_grids">
	<?php #echo $this->element('analytics_header'); ?>
	
	<div>
		<?php echo $this->Form->hidden('pjid',array('size'=>'45','class'=>'datepicker small','style'=>'','maxlength'=>'100', 'id'=>'pjid','readonly'=>'readonly','value'=>$pjid)); ?>
		<?php echo $this->Form->hidden('pj_uniq',array('size'=>'45','style'=>'','id'=>'pj_uniq','maxlength'=>'100','readonly'=>'readonly','value'=>@$proj_uniq)); ?>
		<?php $pjname = $this->Casequery->getProjectName($pjid); ?>
		<?php echo $this->Form->hidden('pjname',array('size'=>'45','class'=>'datepicker small','style'=>'','maxlength'=>'100','id'=>'pjname','readonly'=>'readonly','value'=>isset($pjname['Project']['name'])?$pjname['Project']['name']:'')); ?>
	</div>
	<div id="divToPrint" class="col-lg-12 full_con_al no_analytic setting_wrapper task_listing cmn_tbl_widspace weekly_usage">
		<?php echo $this->element('weekly_usage'); ?>
	</div>
</div>
<div class="cb"></div>