<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<div class="proj_grids glide_div dashboard_page analytic-graph-wrap" id="main_con_hours">
	<?php #echo $this->element('analytics_header'); ?>
	<?php if(empty($pjid)){ ?>
		<div class="col-lg-12 full_con_al no_analytic"><?php echo __('Not enough Analytics data');?>!</div>
	<?php }else{ ?>
		<div>
			<?php echo $this->Form->hidden('pjid',array('size'=>'45','class'=>'datepicker small','style'=>'','maxlength'=>'100', 'id'=>'pjid','readonly'=>'readonly','value'=>$pjid)); ?>
			<?php echo $this->Form->hidden('pj_uniq',array('size'=>'45','style'=>'','id'=>'pj_uniq','maxlength'=>'100','readonly'=>'readonly','value'=>@$proj_uniq)); ?>
			<?php $pjname = $this->Casequery->getProjectName($pjid); ?>
			<?php echo $this->Form->hidden('pjname',array('size'=>'45','class'=>'datepicker small','style'=>'','maxlength'=>'100','id'=>'pjname','readonly'=>'readonly','value'=>isset($pjname['Project']['name'])?$pjname['Project']['name']:'')); ?>
		</div>
        <div class="row">
            <div class="col-lg-12">	
                <div class="width100 cmn_bdr_shadow burndown-chart">
                    <div class="top_ttl_box">
                        <h2><?php echo __('Burndown Chart');?></h2>
                    </div>
                    <div id="burndownchart_container" class="bc-graph">
                        <?php echo __('Loading Burndown Chart');?>...
                    </div>
                </div>
            </div>
        </div>
        <div class="row mtop20">
            <div class="col-lg-6 col-sm-6">
                <div class="width100 cmn_bdr_shadow pie-chart">
                    <div class="top_ttl_box">
                        <h2><?php echo __('Hours spent on Task Type - Pie Chart');?></h2>
                    </div>
                    <div class="bug-graph" id="piechart_container">
                        <?php echo __('Loading Pie Chart');?>...
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="width100 cmn_bdr_shadow grid-view">
                    <div class="top_ttl_box">
                        <h2>
							<?php
								if($loggedInUser['user_type'] < 3){
									$displaytext = 'All';
								}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
									$displaytext = 'Me';
								}
							?>
							<?php echo __('Hours Spent by '.$displaytext.' - Grid View');?>
							<span class="fr hr_display" id="hrspent"></span>
						</h2>
                    </div>
                    <div id="grid_container" class="scroll-task">
                        <?php echo __('Loading Grid view');?>...
                    </div>
                </div>
            </div>
						<div class="cb"></div>
        </div>
        <div class="row mtop20">
            <div class="col-lg-12">
                <div class="width100 cmn_bdr_shadow line-chart">
                    <div class="top_ttl_box">
                        <h2>
							<?php
								if($loggedInUser['user_type'] < 3){
									$displaytextLine = 'All';
								}elseif($loggedInUser['user_type'] == 3 || $loggedInUser['is_client'] == 1){
									$displaytextLine = 'Me';
								}
							?>
							<?php echo __('Hours Spent by '.$displaytextLine.' - Line Chart');?>
						</h2>
                    </div>
                    <div class="lc-graph" id="linechart_container">
                        <?php echo __('Loading Line Chart');?>...
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="cb"></div>
<?php } ?>
<script>
<?php if(!isset($invalid)){ ?>
$(function(){
	var pjid = $('#pjid').val();
	var sdate = $('#start_date').val();
	var edate = $('#end_date').val();
	var url = HTTP_ROOT;
	
	$('#piechart_container').load(url+'reports/hours_piechart',{'pjid':pjid,'sdate':sdate,'edate':edate}, function(res){
		if(res.length > 150){
			$('#piechart_container').parent(".col-lg-6").addClass('m-con');
			$('#piechart_container').parent(".col-lg-6").removeClass('error_box');
		}else{
			$('#piechart_container').parent(".col-lg-6").removeClass('m-con');
			$('#piechart_container').parent(".col-lg-6").addClass('error_box');
		}
	});
	
	$('#linechart_container').load(url+'reports/hours_linechart',{'pjid':pjid,'sdate':sdate,'edate':edate}, function(res){
		if(res.length > 150){
			$('#linechart_container').parent(".col-lg-6").addClass('m-con');
			$('#linechart_container').parent(".col-lg-6").removeClass('error_box');
		}else{
			$('#linechart_container').parent(".col-lg-6").removeClass('m-con');
			$('#linechart_container').parent(".col-lg-6").addClass('error_box');
		}
	});
		
	$('#grid_container').load(url+'reports/hours_gridview',{'pjid':pjid,'sdate':sdate,'edate':edate},function(res){
		if($('#thrs').length > 0){
			$('#hrspent').html("<b>"+$('#thrs').val()+"</b> ");
		}else{
			$('#hrspent').html("");
		}

		if(res.length > 150){
			$('#grid_container').parent(".col-lg-6").addClass('m-con');
			$('#grid_container').parent(".col-lg-6").removeClass('error_box');
		}else{
			$('#grid_container').parent(".col-lg-6").removeClass('m-con');
			$('#grid_container').parent(".col-lg-6").addClass('error_box');
		}
	});
	$('#burndownchart_container').load(url+'reports/hours_burndown', {'pjid':pjid, 'sdate':sdate, 'edate':edate});
});
<?php } ?>
</script>