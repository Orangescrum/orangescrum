<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-Frame-Options" content="deny">
<?php echo $this->element('metadata'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
 <!--<base href="/" />-->
<?php 
echo $this->Html->meta('icon');
?>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<style>
	/* fallback */
@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;
  src: url(http://fonts.gstatic.com/s/materialicons/v38/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
}

.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-feature-settings: 'liga';
  -webkit-font-smoothing: antialiased;
}
</style>
<link rel="stylesheet" href="<?php echo HTTP_ROOT_INVOICE; ?>css/print.css" type="text/css" media="print" />
<?php
if(defined('RELEASE_V') && RELEASE_V){
    echo $this->Html->css('bootstrap.min.css');
    echo $this->Html->css('bootstrap-material-design.min.css');
    echo $this->Html->css('ripples.min.css');
    echo $this->Html->css('jquery.dropdown.css?v='.RELEASE);
    echo $this->Html->css('custom.css?v='.RELEASE);    
    echo $this->Html->css('jquery-ui'); 
    echo $this->Html->css('datepicker/bootstrap-datepicker.min');
    echo $this->Html->css('selectize.default');
    echo $this->Html->css('select2.min');
    echo $this->Html->css('bootstrap-datetimepicker.css');
	if(CONTROLLER == 'Ganttchart'){
        echo $this->Html->css(array('jquery.ganttView', 'reset'));
    }
	if(CONTROLLER == 'easycases'){
        echo $this->Html->css(array('project_overview.css?v='.RELEASE));
    }	
}else{
    //Bootstrap core CSS
    echo $this->Html->css('bootstrap.min_2');
    //Add custom CSS here
    echo $this->Html->css('style_new_v5.css?v='.RELEASE);
    echo $this->Html->css('jquery-ui');
}
if(PAGE_NAME == "dashboard"){
    echo $this->Html->css('jquery.contextMenu.min');
}
if(PAGE_NAME == "mydashboard" || PAGE_NAME == "dashboard" || PAGE_NAME=='milestonelist' || PAGE_NAME=='user_detail' || (CONTROLLER == 'projects' && PAGE_NAME == 'manage')) {
	echo $this->Html->css('jquery.jscrollpane');
        echo $this->Html->css('angular_select'); 
        echo $this->Html->css('xeditable.min.css'); 
        echo $this->Html->css('select2.css'); 
}
if(PAGE_NAME == "profile" || PAGE_NAME =="manage") {
	echo $this->Html->css('img_crop/imgareaselect-animated.css');
}
echo $this->Html->css('fcbkcomplete');
echo $this->Html->css('pace-theme-minimal');
echo $this->Html->css('prettyPhoto.css');
echo $this->Html->css('jquery.timepicker.css');
echo $this->Html->css('jquery.bxslider');
//Moved from Create New project ajax request page
echo $this->Html->css('wick_new.css?v='.RELEASE);
        if(PAGE_NAME == "help" || PAGE_NAME=='tour') {
	echo $this->Html->css('help');
}
if(PAGE_NAME == "dashboard") {
    echo $this->Html->css('introjs');
    echo $this->Html->script('intro');
}
if(!defined('USE_LOCAL') || (defined('USE_LOCAL') && USE_LOCAL==0)) {
	$js_arr = array('jquery/jquery-1.10.1.min.js', 'jquery/jquery-migrate-1.2.1.min.js');
	echo $this->Html->script($js_arr);
}else{
    $js_arr = array('jquery.min.js');
    echo $this->Html->script($js_arr);
        
}
echo $this->Html->script('moment',array('defer'));
echo $this->Html->script('datepicker/bootstrap-datepicker.min',array('defer'));
echo $this->Html->script('angular.min');
echo $this->Html->script('angular-route');
echo $this->Html->script('angular-sanitize');
echo $this->Html->script('angular-animate');
echo $this->Html->script('jquery.bxslider.min');
?>
<?php echo $this->Html->script('jquery.autogrowtextarea.min',array('defer'));?>
<!--[if lte IE 9]>
    <style>
        body {font-family: 'Arial';}
        .col-lg-3 .btn.gry_btn.smal30{padding-left:15px;}
        .task_ie_width {width:4%;}
    </style>
<![endif]-->
<!--[if lte IE 8]>
   <link href="<?php echo CSS_PATH; ?>ie_lte_8.css" rel="stylesheet">
<![endif]-->
<!--[if lte IE 7]>
   <style>
   	.top_nav2{margin-top:0px;}
    .filters ul li.filter_cb{width:0px; height:0px; margin:0px;}
    .drp_flt{display:inline-block; float:none;}
    .navbar-form.navbar-left.top_search{padding:0px;}
   </style>
<![endif]-->

<script type="text/javascript">
  if (typeof jQuery == 'undefined') {
	 document.write(unescape("%3Cscript src='<?php echo JS_PATH_HTTP; ?>jquery-1.10.1.min.js' type='text/javascript'%3E%3C/script%3E"));
	 document.write(unescape("%3Cscript src='<?php echo JS_PATH_HTTP; ?>jquery-migrate-1.2.1.min.js' type='text/javascript'%3E%3C/script%3E"));
  }
</script>

<?php
    /*//Bootstrap core JavaScript
    $js_files = array( 'bootstrap.min.js', 'modernizer.js');
    echo $this->Html->script($js_files,array('defer'));*/
?>
<style>  
@media all and (-ms-high-contrast:none) {
	.rht_content_cmn {padding-left:170px;}
 }
 body{ font-family: 'Open Sans', sans-serif;}
	.os_projct_overview .scroll_body{height: auto !important; overflow: hidden;}
	table, tr, td, th, tbody, thead, tfoot { page-break-inside: avoid !important;}
	.os_projct_overview .wbox_data{height: auto !important; overflow: hidden;}
	.data_not_avail{font-size:40px; top:50%;}
	#time_worked_pie{width:250px;}
</style>
<!--[if lte IE 9]>
<style>  
	.rht_content_cmn {padding-left:170px;}
</style>
<![endif]-->
<script language="javascript" type="text/javascript">
function trackEventLeadTrackerGetting(event_name, eventRefer, email_id){
	$.post("<?php echo LDTRACK_URL; ?>users/saveeventtrack",
	{
		'event_name': event_name,
		'eventRefer':  eventRefer,
		'email_id':  email_id
	},
	function(data){
		return true;
	}).fail(function(response) {
		return true;
	});
}
</script>
<?php if(GA_CODE == 1 && (in_array(PAGE_NAME,array('subscription','pricing','downgrade','upgrade_member','confirmationPage')))){ ?>
	<!-- GA CODE -->
	  <?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){ /*?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-24950841-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'UA-24950841-1');
		  gtag('event', 'page_view');
		</script>
	  <?php */ } ?>
<?php } ?>
<?php  if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com") && !in_array(SES_COMP, array(30811,19398))){ ?>

<!-- Hotjar Tracking Code for www.orangescrum.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:696705,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<?php } ?>
</head>
<body  style="background:#fff;">
	<?php
        if(PAGE_NAME == 'help' || PAGE_NAME=='tour' || PAGE_NAME=='updates') {
			$styleClass = 'style="padding-left:0px;"';
			if(PAGE_NAME=='updates'){
				$styleClass = 'style="padding:0px;margin:0px auto;"';
		}
		}
	?>

	<div id="wrapper" <?php echo $styleClass; ?>>
		<!-- ######################
			###########main Content here ############
			######################## -->
			<div class="os_projct_overview blank_view">
	
	<table style="width:100%;">
		<tr>
			<td style="width:49%; vertical-align: top;"> 
				<h5>Project Name: <strong style="color:#666;"><?php print $proj['Project']['name']; ?></strong>
					<?php if($proj['Project']['priority']==2){ ?>
						<span style="display: inline-block;margin-top: -5px;" class="prio_low prio_lmh prio_gen_prj prio-drop-icon proj_ov_priority"></span>
						<span style="font-size:14px; color:#666;">Low</span>
					<?php }else if($proj['Project']['priority']==1){ ?>	
						<span style="display: inline-block;margin-top: -5px;" class="prio_medium prio_lmh prio_gen_prj prio-drop-icon proj_ov_priority"></span>
						<span style="font-size:14px; color:#666;">Medium</span>
					<?php }else{ ?>
						<span style="display: inline-block;margin-top: -5px;" class="prio_high prio_lmh prio_gen_prj prio-drop-icon proj_ov_priority"></span>
						<span style="font-size:14px; color:#666;">High</span>
					<?php } ?>

				</h5>
				<p>Overall Progress: <strong><?php echo round($project_progress)?>%</strong></p>
			</td>
			<td style="width:49%; vertical-align: top; text-align: right;"> 
				<?php $ps = json_decode($project_status,true);?>
				<div class="bread_crumb">
					<div class="overview_wrapper">
						<ul>
							<li class="a_task">				
								<a href="#">All Task (<span id="ov_tsk_entry_cnt"><?php echo $ps['total'];?></span>)</a>			
							</li>
							<li class="t_entry">
								<a href="#">Time Entry (<span id="ov_tim_entry_cnt">0</span>)</a>
							</li>
							<li class="activity_icon">				
								<a  href="#">Activities (<span id="ov_atvt_entry_cnt"><?php echo $total;?></span>)</a>
							</li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
	</table>	
	<div class="content_databox">
		<table style="width:100%">
				<tr>
					<td>
				<div class="project_lunch_date">
					<div class="box_header">
						<table style="width:100%">
							<tr>
								<td style="vertical-align: top; width:30%; text-align: left">
									<figure>
										<img src="<?php echo HTTP_ROOT_INVOICE; ?>img/flag-fill.png" alt="flag">
									</figure>
								</td>
								<td style="vertical-align: top; width:30%; text-align: left">
									<h4>
										<span><?php echo __('Project Start Date');?></span>
										<?php echo $started_date; ?>
									</h4>
								</td>
								<td style="vertical-align: top; width:30%; text-align: left">
									<h4>
										<span><?php echo __('Project Launch Date');?></span>
										<?php echo $ended_date; ?>
									</h4>
								</td>
							</tr>
						</table>						
					</div>
				</div>
			</td>
		</tr>
	</table>
		<section>
			<table style="width:100%">
				<tr>
					<td style="width:49%;vertical-align:top;">
						<div class="wbox_data">
							<h5><?php echo __('Task Status');?></h5>						
							<div id="project_status">
								<div id="project_status_pie" style="min-width: 340px; height: 230px; margin: 0 auto;"></div>
							</div>							
							<ul class="chat_status_result">
								<?php /*<li>
									<?php echo __('New');?>
									<div class="v_line">
										<div class="line_bar small purple"></div>
										<h6 class="status_new"><?php echo ($ps['data'][0]['y'])?$ps['data'][0]['y']:0;?></h6>
									</div>
								</li>
								<li class="in_progress">
									<?php echo __('In progress');?>
									<div class="v_line">
										<div class="line_bar small gray"></div>
										<h6 class="status_in-progress"><?php echo  ($ps['data'][1]['y'])?$ps['data'][1]['y']:0;?></h6>
									</div>
								</li>
								<li>
									<?php echo __('Resolved');?>
									<div class="v_line">
										<div class="line_bar small orange"></div>
										<h6 class="status_resolved"><?php echo  ($ps['data'][3]['y'])?$ps['data'][3]['y']:0;;?></h6>
									</div>
								</li>
								<li>
									<?php echo __('Closed');?>
									<div class="v_line">
										<div class="line_bar small green"></div>
										<h6  class="status_closed"><?php echo ($ps['data'][2]['y'])?$ps['data'][2]['y']:0;;?></h6>
									</div>
								</li> */ ?>
								<li class="total">
									<?php echo __('Total');?>
									<div>
										<div class="line_bar small denim"></div>
										<h6 class="status_total"><?php echo $ps['total'];?></h6>
									</div>
								</li>
							</ul>
						</div>
					</td>
					<td style="width:49%;vertical-align:top; ">
						<div class="wbox_data">
							<h5><?php echo __('Time Log');?></h5>
							<div id="time_worked" style="min-width: 340px; height: 230px; margin: 0 auto;">
								<?php if(is_array($data)){
									include_once('time_worked.ctp');
								}else{
									echo $data;
								}?>
							 </div>							
							<ul class="chat_status_result chat_billable_result">
								<li>
									<?php echo __('Billable');?>
									<div class="v_line ov_t_cls">
										<div class="line_bar small darkblue"></div>
										<h6 class="ov_time_b ov_cmn_h6">0</h6>
									</div>
								</li>
								<li class="non_billable">
									<?php echo __('Non-Billable');?>
									<div class="v_line ov_t_cls">
										<div class="line_bar small darkorange"></div>
										<h6 class="ov_time_nb ov_cmn_h6">0</h6>
									</div>
								</li>
								<li class="total ov_t_cls">
									<?php echo __('Total');?>
									<div>
										<div class="line_bar small denim"></div>
										<h6 class="ov_time_total ov_cmn_h6">0</h6>
									</div>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</table>
			<table style="width:100%">
				<tr>
					<td style="width:100%">
						<div class="wbox_data" style="padding:0px;">
							<div class="box_header">
							<h5><?php echo __('Team');?></h5>
							</div>
							
							<div id="project_users">
								<?php include_once('project_users.ctp');?>
							</div>	
							
						</div>
					</td>
				</tr>
			</table>			
			<div class="clearfix"></div>
		</section>

		<table style="width:100%">
				<tr>
					<td>
				<div class="file">
						<div class="box_header">
							<h5><?php echo __('Files');?></h5>
						</div>
						<div class="wbox_data">
							<div id="files_overview">
								<?php include_once('case_files_overview.ctp');?>
							</div>		
						</div>
					</div>
			</td>
		</tr>
	</table>
			
	
	<table style="width:100%">
		<tr>
			<td style="width: 49%; vertical-align: top;">
				<div class="task_type">
					<div class="wbox_data">
						<h5><?php echo __('Task type');?></h5>						
						<div id="task_status_pie" style="min-width: 340px; height: 230px; margin: 0 auto;"></div>						
						<div class="clearfix"></div>
						<div class="total_task">
							<?php echo __('Total task');?> <span id="tot_tsx_typ_cnt">0</span>
						</div>
					</div>
				</div>
			</td>
			<td style="width: 49%; vertical-align: top;">
				<table style="width:100%">
			<tr>
				<td>
			<div class="col-md-12">
				<div class="col-md-12 pad-rht-0 pad-lft-0">
					<div class="project_description">
						<div class="wbox_data">
								<h5><?php echo __('Project Description');?></h5>
							<p>
							<?php if(!empty($proj['Project']['description'])){ echo $proj['Project']['description']; }else{ echo '<span style="color:#888;margin-left: 15px;">N/A</span>'; } ?>
							</p>							
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</td>
	</tr>
</table>
			</td>
		</tr>
	</table>
	
	<table style="width:100%">
		<tr>
				<td>
				<div class="overdue_task" style="height:auto; max-height: max-content; overflow: hidden;">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Overdue Task');?></h5>
						</div>
						<div id="to_dos" style="height:auto; max-height: max-content; border: none; overflow: hidden;">
							<?php include_once('to_dos_overview.ctp');?>
						</div>
					</div>
				</div>
			</div>
		</td>
		</tr>
	</table>
		<table style="width:100%">
				<tr>
					<td>			
				<div class="activites">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Activities');?></h5>
						</div>
						<div class="scroll_body">
						<div id="new_recent_activities">
							<?php include_once('recent_activities.ctp');?>
						</div>	
						<!-- <div style="text-align:center;padding: 30%;" id="loader-new_recent_activities">
							<img src="<?php echo HTTP_ROOT_INVOICE; ?>img/images/case_loader2.gif" alt="Loading"/>
						</div> -->
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>

	
	<table style="width:100%">
			<tr>
				<td>
				<div class="task_group">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Task Group');?></h5>						
						</div>
						<div id="project_groups">
							<?php include_once('project_groups_pdf.ctp');?>
						</div>					
					</div>
				</div>
			</td>
		</tr>
	</table>
	<table style="width:100%">
		<tr>
		<td>
				<div class="overdue_task" style="height:auto; max-height: max-content; overflow: hidden;">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Project Description');?></h5>
						</div>						
					<div id="new_recent_activities">
										<div class="activity-row">      
        <span style="font-size:14px"><?php echo $proj_desc; ?></span>
                       </div>
						</div>			
					</div>
				</div>
			</div>
		</td>
		</tr>
	</table>

<table style="width:100%">
				<tr>
					<td>			
				<div class="activites">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Notes');?></h5>
						</div>
						<div class="scroll_body">
						<div id="new_recent_activities">
							<?php include_once('notes.ctp');?>
						</div>	
						<!-- <div style="text-align:center;padding: 30%;" id="loader-new_recent_activities">
							<img src="<?php echo HTTP_ROOT_INVOICE; ?>img/images/case_loader2.gif" />
						</div> -->
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>	
	</div>
</div>

<script type="text/template" id="inactiveOverview">
<?php echo $this->element('inactive_project_task'); ?>
</script>
<script type="text/template" id="inactive_paginate_tmpl">
<?php echo $this->element('inactive_task_paginate'); ?>
</script>
<script type="text/template" id="inactive_case_details_tmpl">
    <?php echo $this->element('inactive_case_details'); ?>
</script>
<script type="text/javascript">
    var DASHBOARD_ORDER = "";<?php //echo json_encode($dashboard_order); ?>;
	var chk_inctv = "<?php echo $proj['Project']['isactive']; ?>";
    //console.log(DASHBOARD_ORDER);
    $(document).ready(function () {

    	$('#list_pie_chart').show();
    	/*** Project Status*/
    	iniDashboardTaskstatus('project_status',<?php echo $project_status ;?>,'legend',1);


    	/** task status section **/
        $('#task_status_ldr_pie').hide();
        $('#loader-task_status_pie').hide();
        var dat = <?php echo $task_type; ?>;
        if (dat.total_cnt) {
            $('#tot_tsx_typ_cnt').text(dat.total_cnt);
        }
        if (dat.status == 'success' && parseInt(dat.total_cnt) > 0) {
            $('#task_status_pie').html('');
            chart = new Highcharts.Chart({
                credits: {
                    enabled: false
                },
                chart: {
                    renderTo: 'task_status_pie',
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                plotOptions: {
                    pie: {
                        shadow: false
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.point.name + '</b>: ' + this.y;
                    }
                },
                series: [{
                    name: 'Browsers',
                    data: dat.data,
                    size: '120%',
                    innerSize: '70%',
                    showInLegend: true,
                    marker: {
                        symbol: "circle",
                        radius: 4
                    },
                    dataLabels: {
                        enabled: false
                    }
                }],
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: 0,
                    y: 20,
                    borderWidth: 0,
                    labelFormatter: function() {
                        return this.name + ' - ' + this.y + '';
                    }
                },
            });
        } else {
            $('#task_status_pie').html('<img src="/img/sample/dashboard/task_types_pie.jpg" style="width:98%;">');
        }

        /** End **/


		$('.hide_back_overview').hide();
		if(chk_inctv == 2){
			$('.hide_back_overview').show();
		}
        //$('.overview-bar').html('<?php echo $html; ?>');
        $('#add_user_pop_pname_overview').html('<?php echo html_entity_decode($prjnm); ?>');
		<?php
        if ($proj['Project']['status'] == 1) {
            $sts_cls = 'started-bnr';
            $sts_txt = 'started';
        } else if ($proj['Project']['status'] == 2) {
            $sts_cls = 'holdon-bnr';
            $sts_txt = 'hold_on';
        } else if ($proj['Project']['status'] == 3) {
            $sts_cls = 'stack-bnr';
            $sts_txt = 'Stack';
        }
        if ($proj['Project']['isactive'] == 2 || $proj['Project']['status'] == 4) {
            $sts_cls = 'completed-bnr';
            $sts_txt = 'Completed';
        }
        ?>
        <?php if (SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == $proj['Project']['user_id'])){ ?>
        $('#add_user_pop_pname_overview').next('span.inline-edit-usr').attr('data-prj-id', '<?php echo $prjunid; ?>');
        $('#add_user_pop_pname_overview').next('span.inline-edit-usr').attr('data-prj-name', '<?php echo ucwords(trim($prjnm)); ?>');
        <?php }else{ ?>
        $('#add_user_pop_pname_overview').next('span.inline-edit-usr').remove();
        <?php } ?>
        $('.overview-sts').text('<?php echo $strtdtxt; ?>');
        $('.overview-bnr').addClass('<?php echo $sts_cls; ?>')
        /*$('.prj-sts-dv').text('<?php #echo $sts_txt; ?>');
         $('.prj-sts-dv').show();*/
        //loadDashboardPage('<?php echo $prjunid; ?>','overview');
        var projid = '<?php echo $prjunid; ?>';
        var orderStr = new Array();
        for (var i in DASHBOARD_ORDER) {
            orderStr.push(DASHBOARD_ORDER[i].name.toLowerCase().replace(' ', '_'));
        }
        var sequency = orderStr;
        for (var i in sequency) {
            if ($("#" + sequency[i]).html() !== '') {
                $("#" + sequency[i]).html('');
            }
        }
        sequency.reverse();
        loadSeqDashboardAjax(sequency, projid, 'overview');
    });
    $(function () {
		$(document).on('keyup','#inact_search',function(event){
			var inpt = $(this).val().trim();
			if(event.keyCode==13){
				search_data();
			}
		});
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        if (inact == 2) {
            $("#dsbleInactOver").hide();
        } else {
            $("#dsbleInactOver").show();
        }
        if (inact == 2) {
            $.post(HTTP_ROOT + "easycases/inactive_project_task", {'proId': proId}, function (data) {
                if (data) {
                    $("#incativeOverview_ldr").hide();
                    $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                }
            }, 'json');
        }
    });
    function search_data() {
        var search_val = $("#inact_search").val();
        if (search_val != '') {
            var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
            var inact = "<?php echo $proj['Project']['isactive']; ?>";
            if (inact == 2) {
                $("#dsbleInactOver").hide();
            } else {
                $("#dsbleInactOver").show();
            }
            if (inact == 2) {
                $.post(HTTP_ROOT_INVOICE + "easycases/inactive_project_task", {'proId': proId, 'search_val': search_val}, function (data) {
                    if (data) {
                        $("#incativeOverview_ldr").hide();
                        $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                    }
                }, 'json');
            }
        }
    }
    function clickPrev(prev_next) {
        $("#hours_linechart_ldr").show();
        var pjid = $('#projectUid').val();
        var sdate = $('#overStartDate').val();
        var edate = $('#overEndDate').val();
        $('#hours_linechart').load(HTTP_ROOT + 'easycases/hours_linechart', {
            'projid': pjid,
            'sdate': sdate,
            'edate': edate,
            'mode': prev_next,
            'task_type_id': 0,
            'extra': "overview"
        }, function (res) {
            $("#hours_linechart_ldr").hide();
            if (res.length > 150) {
                $('#hours_linechart').parent(".col-lg-6").addClass('m-con');
                $('#hours_linechart').parent(".col-lg-6").removeClass('error_box');
            } else {
                $('#hours_linechart').parent(".col-lg-6").removeClass('m-con');
                $('#hours_linechart').parent(".col-lg-6").addClass('error_box');
            }
            var fsdate = $("#foverStartDate").val();
            var fedate = $("#foverEndDate").val();
            $("#dateRangeId").text("( From : " + fsdate + " - To : " + fedate + ")");
        });
    }
    function inactiveCasePaging(page) {
        $("#incativeOverview_ldr").show();
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        if (inact == 2) {
            $("#dsbleInactOver").hide();
        } else {
            $("#dsbleInactOver").show();
        }
        if (inact == 2) {
            $.post(HTTP_ROOT_INVOICE + "easycases/inactive_project_task", {'proId': proId, 'page': page}, function (data) {
                if (data) {
                    $("#incativeOverview_ldr").hide();
                    $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                }
            }, 'json');
        }
    }
    function inactiveAjaxSorting(type, cases, el, csNum) {
        $("#incativeOverview_ldr").show();
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        if (inact == 2) {
            $("#dsbleInactOver").hide();
        } else {
            $("#dsbleInactOver").show();
        }
        if (inact == 2) {
            $.post(HTTP_ROOT_INVOICE + "easycases/inactive_project_task", {'proId': proId, 'type': type, 'cases': cases, 'csNum': csNum}, function (data) {
                if (data) {
                    $("#incativeOverview_ldr").hide();
                    $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                }
            }, 'json');
        }
    }
    $(document).on('click', '[id^="inactivetitlehtml"]', function () {
        openPopup();
        $(".loader_dv").show();
        $(".inactive_caseDetails").show();
        var Id = "<?php echo $proj['Project']['id']; ?>";
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        var task_data = $(this).attr('data-task').split('|');
        var caseUniqId = task_data[0];
        if (inact == 2) {
            $("#dsbleInactOver").hide();
        } else {
            $("#dsbleInactOver").show();
        }
        if (inact == 2) {
            $.post(HTTP_ROOT_INVOICE + "easycases/inactive_case_details", {'id': Id, 'proId': proId, 'caseUniqId': caseUniqId}, function (data) {
                if (data) {
//                    $("#incativeOverview_ldr").hide();
                    $("#inactiveCaseDetails").html(tmpl("inactive_case_details_tmpl", data));
                    $(".loader_dv").hide();
                }
            }, 'json');
        }
    });
    $(document).on('click', '[id^="inactivecasecount"]', function () {
        openPopup();
        $(".loader_dv").show();
        $(".inactive_caseDetails").show();
        var Id = "<?php echo $proj['Project']['id']; ?>";
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        var task_data = $(this).attr('data-task').split('|');
        var caseUniqId = task_data[0];
        if (inact == 2) {
            $("#dsbleInactOver").hide();
        } else {
            $("#dsbleInactOver").show();
        }
        if (inact == 2) {
            $.post(HTTP_ROOT_INVOICE + "easycases/inactive_case_details", {'id': Id, 'proId': proId, 'caseUniqId': caseUniqId}, function (data) {
                if (data) {
//                    $("#incativeOverview_ldr").hide();
                    $("#inactiveCaseDetails").html(tmpl("inactive_case_details_tmpl", data));
                    $(".loader_dv").hide();
                }
            }, 'json');
        }
    });

    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

//        if (month.length < 2)
//            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        var monthArr = new Array();
        monthArr[0] = "January";
        monthArr[1] = "February";
        monthArr[2] = "March";
        monthArr[3] = "April";
        monthArr[4] = "May";
        monthArr[5] = "June";
        monthArr[6] = "July";
        monthArr[7] = "August";
        monthArr[8] = "September";
        monthArr[9] = "October";
        monthArr[10] = "November";
        monthArr[11] = "December";
        var n = monthArr[month];

        return [n, day, year].join('-');
    }
    function show_all_message(pro_name) {
        var msg = '<?php echo __("Please active the");?> ' + pro_name + ' <?php echo __("project to view all overdue task");?>';
        showTopErrSucc('error', msg);
//        location.reload();
    }
</script>
<script type="text/javascript">
	var pprg = "<?php echo $project_progress; ?>";
	//var ppnm = "<?php echo html_entity_decode($proj['Project']['name']); ?>";
	var ppst = "<?php echo isset($proj['Project']['start_date'])?date("M j, Y", strtotime($proj['Project']['start_date'])):'<span style=\"color:#888\">N/A</span>'; ?>";
	var pped = "<?php echo isset($proj['Project']['end_date'])?date("M j, Y", strtotime($proj['Project']['end_date'])):'<span style=\"color:#888\">N/A</span>'; ?>";
	$(document).ready(function() {
		/*$.getScript("<?php echo HTTP_ROOT; ?>js/loading-bar.js", function(data, textStatus, jqxhr) {
            if (textStatus == 'success') {
				$('#proj_loading_bar').html('');
                 var bar1 = new ldBar("#proj_loading_bar");
				 var bar2 = $('#proj_loading_bar').ldBar;
				 bar1.set(pprg);
            }			
        });	*/
		$('#ov_prj_name').html('<?php echo addslashes(html_entity_decode($proj['Project']['name'])); ?>');
		
		$('#project_stst_span').html('<?php echo html_entity_decode($All_status[$proj['Project']['status']]); ?>');
		
		$('#ov_prj_stdt').html(ppst);
		$('#ov_prj_eddt').html(pped);
		$('#dsbleInactOver').attr('data-prj-id',"<?php echo $proj['Project']['uniq_id']; ?>");
		$('#dsbleInactOver').attr('data-prj-name','<?php echo addslashes(html_entity_decode($proj['Project']['name'])); ?>');
		<?php $prio = $this->Format->getPriority($proj['Project']['priority']);
                    if($prio =='high'){
                        $proj_text = __('High',true);
                    }else if($prio =='medium'){
                         $proj_text = __('Medium',true);
                    }else{
                        $proj_text = __('Low',true);
                    }
                ?>
		$('.proj_ov_priority').attr('title','<?php echo $proj_text; ?> <?php echo __('Priority');?>');
		$('.proj_ov_priority').addClass('prio_<?php echo $this->Format->getPriority($proj['Project']['priority']); ?>');	
		$('.proj_name_over_task').append(' <span><?php echo $proj_text; ?></span>');
		$('[rel=tooltip]').tipsy({
			gravity: 's',
			fade: true
		});
	});
</script>

<?php 
$json_data_t = '';
$closed = 0;
$legend = array( __("Closed",true),  __("In Progress",true));
$color = array( "#00BCD5",  "#eee");
$prog_inp = 100 - $project_progress;

$json_data= "{name:'".$legend[0].'<br>'.$project_progress."',y:".$project_progress.",color:'".$color[0]."'},{name:'".$legend[1].'<br>'.$prog_inp."',y:".$prog_inp.",color:'".$color[1]."'}";
?>
<div id="time_worked_pie"></div>

<!-- #############################
	###############End of main Content Here ##########-->
	</div>
	<script type="text/javascript">
<?php /*?>JS VARs from footer_inner<?php */?>
var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>'; //pageurl
var HTTP_HOME = '<?php echo HTTPS_HOME; ?>'; //pageurl
var HTTP_IMAGES = '<?php echo HTTP_IMAGES; ?>'; //hid_http_images
var MAX_FILE_SIZE = '<?php echo MAX_FILE_SIZE; ?>'; //fmaxilesize
var SES_ID = '<?php echo SES_ID; ?>'; //pub_show
var SES_TYPE = '<?php echo SES_TYPE; ?>';
<?php $GLOBALS['TYPE'] = array_filter($GLOBALS['TYPE']); ?>;
var GLOBALS_TYPE = <?php echo json_encode($GLOBALS['TYPE']); ?>;
var DESK_NOTIFY = <?php echo (int)DESK_NOTIFY; ?>;
var CONTROLLER = '<?php echo CONTROLLER; ?>';
var PAGE_NAME = '<?php echo PAGE_NAME; ?>';
var ARC_CASE_PAGE_LIMIT = 10;
var ARC_FILE_PAGE_LIMIT = 10;
var PUSERS = <?php echo json_encode($GLOBALS['projUser']); ?>;
var ACUSERS = <?php echo json_encode($GLOBALS['AllCompUser']); ?>;
var PROJECTS = ''<?php //echo json_encode($GLOBALS['getallproj']); ?>;
var defaultAssign = '<?php echo $defaultAssign; ?>';
var dassign;
var TASKTMPL = <?php echo json_encode($GLOBALS['getTmpl']); ?>;
var SITENAME = '<?php echo SITE_NAME; ?>';
var DEFAULT_TASKVIEW = '<?php echo DEFAULT_TASKVIEW; ?>';
var DEFAULT_KANBANVIEW = '<?php echo DEFAULT_KANBANVIEW; ?>';
var DEFAULT_TIMELOGVIEW = '<?php echo DEFAULT_TIMELOGVIEW; ?>';
var DEFAULT_PROJECTVIEW = '<?php echo DEFAULT_PROJECTVIEW; ?>';
var DEFAULT_VIEW_TASK = '<?php echo DEFAULT_VIEW_TASK; ?>';
var DEFAULT_VIEW_VALUE = '<?php echo DEFAULT_VIEW_VALUE; ?>';
var DEFAULT_PAID = '<?php echo SES_COMP; ?>';
var CMP_ARABK = '<?php echo SES_COMP; ?>';
var SHOW_ARABK = '<?php echo SHOW_ARABIC; ?>';
var EDIT_TASK = '<?php echo $edit_task; ?>';
var EXPIRED_PLAN = '<?php echo CURRENT_EXPIRED_PLAN; ?>';
var USER_SUB_NOW = '<?php echo $GLOBALS['user_subscription']['subscription_id']; ?>';
var NODEJS_HOST = '<?php echo NODEJS_HOST_CHAT; ?>';
var NODEJS_SECURE = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?"true":"true"; ?>';
var COMPANY_WORK_HOUR = '<?php echo $GLOBALS['company_work_hour'] ?>';
var COMPANY_WEEK_ENDS = '<?php echo $GLOBALS['company_week_ends'] ?>';
var COMPANY_HOLIDAY = '<?php echo $GLOBALS['company_holiday'] ?>';

var DEFAULT_TASK_TYPES = {"bug":"&#xE60E;","enh":"&#xE01D;","cr":"&#xE873;","dev":"&#xE1B0;","idea":"&#xE90F;","mnt":"&#xE869;","oth":"&#xE892;","qa":"Q","rel":"&#xE031;","rnd":"&#xE8FA;","unt":"&#xE3E8;","upd":"&#xE923;"};
var bxslid = null;
var bxslid1 = null;
<?php /*?><?php
$curdate = gmdate("Y-m-d H:i:s");
$userDate = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$curdate,"datetime");
?>
var USERDATE = '<?php echo $userDate; ?>';
var CURDAY = '<?php echo date('D',strtotime($userDate)); ?>';
var FRIDAY = '<?php echo date('Y-m-d',strtotime($userDate."next Friday")); ?>';
var MONDAY = '<?php echo date('Y-m-d',strtotime($userDate."next Monday")); ?>';
var TOMORROW = '<?php echo date('Y-m-d',strtotime($userDate."+1 day")); ?>';<?php */?>
var TITLE_DLYUPD = '<?php echo "Daily Update - ".date("m/d"); ?>';
var RELEASE = '<?php echo RELEASE;?>';
var CompWorkHR = <?php echo $GLOBALS['company_work_hour'] == '' ? 8 : $GLOBALS['company_work_hour']; ?>;
</script>

<?php
    if(defined('RELEASE_V') && RELEASE_V){ 
        $js_files = array( 'bootstrap.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
   ?>
	
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>bootstrap.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>material.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.dropdown.js?v=<?php echo RELEASE; ?>" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>ripples.min.js" defer></script>
        <?php if(PAGE_NAME == "dashboard"){ ?>
             <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.contextMenu.min.js" defer></script>
         <?php } ?>       
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.mask.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>selectize.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>angular_select.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>moment.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>xeditable.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>select2.min.js"></script>
    <?php }else{
	//Bootstrap core JavaScript
	$js_files = array( 'bootstrap.min.js', 'modernizer.js');
	echo $this->Html->script($js_files,array('defer'));
    }
?>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>os_core.js?v=<?php echo RELEASE; ?>" defer></script>


<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery-ui-1.9.2.custom.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>script_v1.js?v=<?php echo RELEASE; ?>" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>easycase_new.js?v=<?php echo RELEASE; ?>" defer></script>

<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.tipsy.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.lazyload.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>tinymce/jquery.tinymce.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>tinymce/tiny_mce.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP;?>jquery.fcbkcomplete.js" defer></script>



<script type="text/javascript">
	function subscribeClient(){}
</script>



<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>dashboard_v1.js?v=<?php echo RELEASE; ?>" defer></script>
<script type="text/javascript" src="<?php echo HTTP_ROOT_INVOICE;?>js/jquery/jquery.mousewheel.js" defer></script>
<script type="text/javascript" src="<?php echo HTTP_ROOT_INVOICE;?>js/jquery/jquery.jscrollpane.min.js" defer></script>
<link type="text/css" href="<?php echo HTTP_ROOT_INVOICE;?>js/jquery/jquery.jscrollpane.css" />



<?php /*?>Moved from Create New project ajax request page<?php */?>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP;?>wiki.js?v=<?php echo RELEASE; ?>" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>highcharts.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>exporting.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>jquery.timepicker.min.js" defer></script>

<script type="text/javascript" src="<?php echo JS_PATH_HTTP;?>jquery.fileupload.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP;?>jquery.fileupload-ui.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH_HTTP; ?>gettext.js"  defer></script>


<?php //echo $this->element('sql_dump'); ?>
<!-- Flash Success and error msg ends -->
</body>
</html>
























