<style type="text/css">
    .new-dashboard-page{padding:30px 10px;background:#fff;}
    .new-dashboard-page .row.top_dboard_src{margin:0px;padding:0;cursor: grab;}
    .cmn_bdr_shadow{box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);-moz-box-shadow:0 1px 3px  rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);-webkit-box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);background:#fff;margin-bottom: 20px}
    .dashboard_page h2{margin:0px 0px 20px 0px;font-size:20px;}
    .width18{width:19%}
    .top_dboard_src .width18, .top_dboard_src .width25{padding:20px 5px;border:1px solid #D6D6D6;text-align:center;x-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);-moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);-webkit-box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);}
    .top_dboard_src .width18{padding:0 5px 0 0;color:#fff;height:75px;margin-right:1.2%;box-sizing:border-box}
    .top_dboard_src .width18.dash-proj ul li:first-child{background:#27a9e3}
    .top_dboard_src .width18.dash-tsks ul li:first-child{background:#28b779}
    .top_dboard_src .width18.dash-actusr ul li:first-child{background:#ffb848}
    .top_dboard_src .width18.dash-hrs ul li:first-child{background:#f74d4d}
    .top_dboard_src .width18.dash-fle ul li:first-child{background:#2255a4}
    .top_dboard_src .width18 ul li:first-child:hover{background:#253650}
    .top_dboard_src .width18 ul{list-style-type: none;margin:0;padding:0;height:100%}
    .top_dboard_src .width18 ul li{display:inline-block;height:100%}
    .top_dboard_src .width18 ul li:first-child{float:left;position:relative;width:30%;box-sizing:border-box;}
    .top_dboard_src .width18 ul li:nth-child(2){float:right;width:70%;text-align:center;padding:5px;box-sizing:border-box;}
    .top_dboard_src .width18 ul li img{max-width:100%;width:70px;height:70px;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;display:inline-block}
    .top_dboard_src .width18 ul li h4{margin:0;max-width:100%}
    /*.top_dboard_src .width18 ul li h4 a, .top_dboard_src .width18 ul li h6{color:#fff}*/
    .top_dboard_src .width18 ul li h4 a{font-size:18px}
    .top_dboard_src .width18 ul li h6{ font-size:12px; margin: 5px 0 0;}
    .top_dboard_src .width18:last-child, .top_dboard_src .width25:last-child{border-right:0px;}
    .top_dboard_src .width18 h4, .top_dboard_src .width25 h4{margin:0px;color:#333;font-weight:bold;font-size:20px;}
    .top_dboard_src .width18 h4 span, .top_dboard_src .width25 h4 span{font-size:15px;}
    .top_dboard_src .width18 h6, .top_dboard_src .width25 h6{margin:15px 0 0;color:#777;font-weight:normal;font-size:13px;}
    .top_dboard_src .os_sprite{width:25px;height:25px;margin-right:5px;}
    .top_dboard_src .os_sprite.task_duedt{background-position:-181px -113px;}
    .top_dboard_src .os_sprite.spent_scount{background-position:-208px -112px;}
    .top_dboard_src .os_sprite.spent_blog{background-position:-237px -110px;}
    .top_dboard_src .os_sprite.file_store{background-position:-265px -110px;}
    .top_dboard_src .os_sprite.active_usr{background-position:-293px -112px;}
    .dashboard_page .top_ttl_box{display:block;width:100%;background-color:#f3f9fd;padding:8px 15px 8px 15px;border-bottom:1px solid #b7b7b7;height:50px;position:relative;}
    .dashboard_page .top_ttl_box h2{font-weight:600;margin:0px;font-size:14px;color:#63748E;line-height:34px;margin:0}
    .dashboard_page .top_ttl_box .material-icons{position:absolute;color:#727272;background:#EBEBEB;right:25px;top:12px;padding:4px;border-radius:100%;}
    .cstm_scroll{min-height: 230px;overflow-y: auto;}
    .new-dashboard-page .row.top_dboard_src .col-lg-6{padding-left:15px;padding-right:15px}
    .new-dashboard-page .row.top_dboard_src .cmn_bdr_shadow .top_ttl_box select.sel-filter{border:1px solid #999; border-radius:5px;color:#484848; margin-right:30px;padding:2px 5px;width:115px;overflow:hidden;text-overflow:ellipsis;right:0}
    .new-dashboard-page .row.top_dboard_src .cmn_bdr_shadow .top_ttl_box .sel-filter:last-child{margin-right:0}
    .top_dboard_src .width18.mrgn-rght0{margin-right: 0px;}
    .new-dashboard-page .top_dboard_src .width100.cmn_bdr_shadow.top-divs{box-shadow:none}
    .new-dashboard-page .row.top_dboard_src .table-responsive {min-height: .01%;overflow-x: auto;}
    .new-dashboard-page .row.top_dboard_src .table-responsive.prjct-rag-tbl {max-height:550px;overflow-x: auto; overflow-y: auto;height: 100%;}
		.new-dashboard-page .row.top_dboard_src .fullscreen{padding:15px;border: 1px solid #ddd;}
		.new-dashboard-page .row.top_dboard_src .fullscreen .table-responsive.prjct-rag-tbl{
    padding:0px;background: #fff;box-shadow:none;border:none;margin-top: 10px;height: calc(100% - 80px);height: -webkit-calc(100% - 80px);height: -moz-calc(100% - 80px);overflow: auto;}
		.new-dashboard-page .row.top_dboard_src .fullscreen .hide_buttn{position: relative;margin: 0;}
    @-moz-document url-prefix() {
        .new-dashboard-page .row.top_dboard_src .table-responsive.prjct-rag-tbl{
            max-height:580px
        }
    }
    .new-dashboard-page .row.top_dboard_src .table {margin-bottom: 10px;width: 100%;max-width: 100%;background-color: transparent;border-spacing: 0;border-collapse: collapse;}
    .new-dashboard-page .row.top_dboard_src .table > thead > tr > th {vertical-align: bottom;color: #484848;font-size:13px;font-weight: 600;font-weight: 600;text-align: left !important;}
		.new-dashboard-page .row.top_dboard_src .table-responsive.prjct-rag-tbl tr td{padding: 6px 10px !important;vertical-align: middle;} 
		.new-dashboard-page .row.top_dboard_src .table > tbody > tr > td strong{font-weight:500;text-align: left !important;}
    .new-dashboard-page .row.top_dboard_src .table > tbody {color: #212121/*#797979*/;}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr > td, .table > thead > tr > th {padding: 8px;line-height: 1.42857143;vertical-align: top;border-bottom: 1px solid #ebeff2;text-align: left !important;}
		.new-dashboard-page .row.top_dboard_src .table > tbody > tr > td.prjct_duration{vertical-align:middle}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr > td > .label {font-weight: 500;letter-spacing: 0.05em;padding:14px;display: inline-block;font-size: 75%;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;border-radius: 50%;}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr> td > .label.label-red{background:#FF0000}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr > td > .label.label-amber{background:#FFC200}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr > td > .label.label-green{background:#008000}
    .new-dashboard-page .row.top_dboard_src .table > tbody > tr > td > .label.label-grey{background:#A9A9A9}
    .new-dashboard-page .row .table > tbody > tr:last-child > td{border:none;}
    .table-hover tbody tr:hover {-moz-box-shadow: 3px 0px 3px 0px #ccc;-webkit-box-shadow: 3px 0px 3px 0px #ccc;box-shadow:3px 0px 3px 0px #ccc;}

    .new-dashboard-page td{color: #8f8f8f;font-size: 13px;  font-weight: 500;}
    .top-icons{background:url(<?php echo HTTP_ROOT; ?>img/icons/dash-icons.png) no-repeat 0px 0px;display:inline-block;width:42px;height:50px;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;}
    .top-icons.icons-proj{background-position:0px 5px}
    .top-icons.icons-user{background-position:0px -45px}
    .top-icons.icons-tsk{background-position:0px -95px}
    .top-icons.icons-tme{background-position:0px -141px}
    .top-icons.icons-file{background-position:0px -191px}

		#project_rag.dboard_cont{padding:0}
    #project_rag.fullscreen ,#timelog_chart1.fullscreen ,#dash_project_timesheet.fullscreen ,#dash_resource_timesheet.fullscreen,#resource_cost_report.fullscreen,#rag_cost_report.fullscreen,#timelog_tsktyp.fullscreen,#hlp_cntnt_div.fullscreen,#dash_cost_report.fullscreen,#dash_resource_cost_report.fullscreen,#prjct_prgs_report.fullscreen,#mlstn_prgs_report.fullscreen{background:#fff;z-index: 9999;width: 100%;height: 100%;position: fixed;top: 0;left: 0; padding:15px 15px 0 15px;}
    #timelog_chart1,#project_rag,#dash_project_timesheet,#dash_resource_timesheet,#timelog_tsktyp,#hlp_cntnt_div,#dash_cost_report,#resource_cost_report,#cost_report,#dash_resource_cost_report,#prjct_prgs_report,#mlstn_prgs_report{background:#fff;}
		.fullscreen#mlstn_prgs_report .hide_buttn{display:block}
    /*  #exprt_rag,#bck_rag,#bck_prjtsht,#bck_rcrstsht{display:none;margin-bottom:20px} */
    .hide_buttn{display:none;margin-bottom:20px}
    .hide_td{display:none;}
    .hide_td.vscntnt{text-align: center;}
    #tmlog_bck{display:none;margin-bottom:20px}
    /* #expand_tlg{display:none} */
    .tsklst_label{ /*border-radius: 9px;*/ color: rgb(255, 255, 255); display: inline-block;line-height: 14px; padding: 2px 4px; text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25); vertical-align: baseline; white-space: nowrap; font-size: 10.844px;text-align:center;width:75px}
    .tsklst_label.ovrdueby{background:#f74d4d}
    .tsklst_label.crtdate{background:#3a87ad}
    .tsklst_label.upcomngin{background:#51a351}
    .nav-tabs{width:100%;border:none;border-bottom:2px solid #ccc}
    #dash_tsk_lst .nav-tabs li{ padding: inherit;margin-bottom:0;height: inherit;border:none;background:none;position:relative;transition:all 0.8s ease-in-out;-webkit-transition:all 0.8s ease-in-out;-moz-transition:all 0.8s ease-in-out;}
    /*     .nav-tabs > li > a{border-radius:0px;}*/
    #dash_tsk_lst .nav-tabs li:hover:before, .nav-tabs>li.active:before{content:'';border-bottom:2px solid #27a9e3;position:absolute;bottom:-2px;left:0;width:100%;display:block;background:none}
    /*#dash_tsk_lst .nav-tabs li:not(.active){border:none;border-bottom: 1px solid #ccc;}*/
    #dash_tsk_lst .nav-tabs>li>a{border:none;background:none;}
    #dash_tsk_lst .nav-tabs>li>a:hover{color:#000;}
    /* #dash_tsk_lst .nav-tabs li:hover,.nav-tabs>li.active{background:#FFCC33}*/
    /* #dash_tsk_lst .nav-tabs li:hover a,.nav-tabs>li.active a{background:#FFCC33;color:#fff;font-weight:bold} */
    #ovrdue .listdv,#upcmng_tsks .listdv{margin-top:10px}
    /*#dash_tsk_lst li.active {border-top: 1px solid #ff9600;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
    }
    #dash_tsk_lst .nav-tabs{border:none}*/
    /*.top_dboard_src,.top_dboard_src .dboard_cont,.top_dboard_src .task_cre_rec_db,.top_dboard_src .time_rec_db{font-family:'Lucida Sans Unicode';}*/
    #prj_rag{height:390px}
    .to-dos-box .htdb.cstm_scroll{height:342px}
    #dash_recent_activities .act_title_db{padding-top:1px}
    #dash_recent_activities .task_cre_rec_db{padding-left:5px;padding-top: 1px;}
    #timelog_table,#tasktype_table{display:none;margin-top:20px}
    /*table.tbody_scroll{width:100%}
    table.tbody_scroll tbody,
    table.tbody_scroll thead { display: block; }
    table.tbody_scroll tbody {
        height: 100px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .tbody_scroll tbody td:last-child, thead th:last-child {
        border-right: none;
    }
    .tbody_scroll tbody td, .tbody_scroll thead th {
        width: 16%;  Optional 
        border-right: 1px solid black;
    }*/


    .tbody_scroll tbody {
        display:block;
        height:300px;
        overflow:auto;
    }
		.fullscreen .tbody_scroll tbody {height: 130px;}
		.new-dashboard-page .row.top_dboard_src .fullscreen .table-responsive{height:140px;overflow: hidden;border: 1px solid #ddd;
    border-radius: 4px;}
		.fullscreen  #timelog_table, .fullscreen #tasktype_table{margin:0}
    .tbody_scroll thead,.tbody_scroll tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .tbody_scroll thead {
        width: calc( 100% - 1em )
    }
    #hlp_cntnt_div{background: rgba(4, 7, 8, 0.75);}
    .hlp_div{display:none;width:80%;margin:0 auto;}
    .hlp_inner{width:80%;margin:20px auto 0;border:none;
               padding:0px 0 20px;background:#fff;border-radius: 10px;box-shadow:inset 0px 0px 30px #94A3A7;position:relative}
    #hlp_cntnt_div h2{font-size:20px;margin: 0 0 15px; background:rgb(249, 174, 5);padding:20px 50px 20px 20px;color:#fff;border-radius:10px 10px 0 0;}
    .hlp_cntnt{height:500px;overflow-y: scroll;width:100%; margin: 0 auto;padding:0px 25px}
    #hlp_cntnt_div strong{display: block;font-size:14px;color:#303030;margin: 15px 0 10px 0;}
    #hlp_cntnt_div p{font-size:13px;line-height:28px;margin: 0 0 10px;color:#303030}
    #hlp_cntnt_div .close_popup{background: rgba(0, 0, 0, 0) url("<?php echo HTTP_ROOT; ?>img/cross-symbol.png") no-repeat scroll 0 0;position: absolute;top: 15px;right:20px;height:16px;width:16px}
    .mytask_txt{width:100%}
    .recent-activity-new .htdb {height:427px}
    .zindexClas + .select2-container{z-index: 0 !important;width: 130px !important;}
    .expand_icon{display:inline-block;width:16px;height:25px;position:relative;right:0;top: 5px;margin:auto;margin-left:5px}
		.expand_icon a{text-decoration:none;display: flex;align-items: center;width: 100%;height: 100%;}
    /* #star_chart .highcharts-container{height:450px !important;} */


    @media screen and (max-width: 1300px) {
        .top_ttl_box .to_do_ttl h2{  width: 80px;  overflow: hidden;  text-overflow: ellipsis;  white-space: nowrap;}
    }
</style>
<style>
	.dynaic_elipse_data{display: inline-block;max-width:100%;white-space:nowrap;text-overflow:ellipsis; overflow:hidden}
	 .os_projct_overview .overview_report_left_align .wbox_data table tr th, .os_projct_overview .overview_report_left_align .wbox_data table tr td{text-align:left}
</style>
<div class="os_projct_overview blank_view">
	<div class="proj_head" style="display:none;">
		<div class="overview_wrapper">
			<div class="d_tbl">
				<div class="d_tbl_cel">
					<h6><?php echo __('Overall Progress');?></h6>
				</div>
				<div class="d_tbl_cel" style="margin-top: -13px;">
					<figure>
						<img src="<?php echo HTTP_ROOT;?>img/overall-progress.png" alt="overall progres">
					</figure>
					<div class="progress_count">40%</div>
				</div>
				<div class="d_tbl_cel p_name">
					<h2><?php echo __('Polling management system(PMS)');?></h2>
				</div>
				<div class="d_tbl_cel date">
					<span><?php echo __('Start Date');?></span>
						05/10/2016
					<div class="v_line_separator"></div>
				</div>
				<div class="d_tbl_cel date">
					<span><?php echo __('Due Date');?></span>
						10/01/2018
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->element('breadcrumb_overview'); ?>
	<div class="content_databox">
		<section>
			<div class="col-md-8">
				<div class="col-md-6">
					<div class="wbox_data">
						<div class="box_header"><h5><?php echo __('Task Status');?></h5></div>						
						<div id="project_status"> </div>
						<div style="text-align:center;padding: 24%;" id="loader-project_status">
							<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
						</div>
						<ul class="chat_status_result">
							<?php /* <li>
								<?php echo __('New');?>
								<div class="v_line">
									<div class="line_bar small purple"></div>
									<h6 class="status_new">0</h6>
								</div>
							</li>
							<li class="in_progress">
								<?php echo __('In progress');?>
								<div class="v_line">
									<div class="line_bar small gray"></div>
									<h6 class="status_in-progress">0</h6>
								</div>
							</li>
							<li>
								<?php echo __('Resolved');?>
								<div class="v_line">
									<div class="line_bar small orange"></div>
									<h6 class="status_resolved">0</h6>
								</div>
							</li>
							<li>
								<?php echo __('Closed');?>
								<div class="v_line">
									<div class="line_bar small green"></div>
									<h6  class="status_closed">0</h6>
								</div>
							</li> */ ?>
							<li class="total">
								<?php echo __('Total');?>
								<div>
									<div class="line_bar small denim"></div>
									<h6 class="status_total">0</h6>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="wbox_data">
						<div class="box_header"><h5><?php echo __('Time Log');?></h5></div>
						<div id="time_worked"> </div>
						<div style="text-align:center;padding: 24%;" id="loader-time_worked">
							<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
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
				</div>
			</div>
			<div class="col-md-4">
				<div class="wbox_data" style="padding:0px;">
					<div class="box_header">
					<h5><?php echo __('Team');?></h5>					
					<?php
						if (SES_TYPE == 1 || SES_TYPE == 2 || ($prjusrid == SES_ID )) {
							if ($proj['Project']['isactive'] == 1) {
								?>
								<?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
								<div class="add" onclick="setSessionStorage('From Project Overview Page', 'Add User to Project'); addUsersToProject('<?php echo $prjunid; ?>')" title="Add New User To Project">+</div>
							<?php } ?>
								<?php
							}
						}
					?>
					</div>
					
					<div id="project_users"></div>	
					<div style="text-align:center;padding: 24%;" id="loader-project_users">
						<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</section>
		<section>
			<div class="col-md-8">
				<div class="col-md-12">
					<div class="file">
						<div class="box_header">
							<h5><?php echo __('Files');?></h5>
                                                        <?php if ($proj['Project']['isactive'] == 1) { ?>
							<a href="<?php echo HTTP_ROOT; ?>dashboard#files" class="view_more" onclick="return trackEventLeadTracker('Project Overview','Files Page','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('files');">View more</a>
                                                        <?php } ?>
						</div>
						<div class="wbox_data">
							<div id="files_overview"></div>		
							<div style="text-align:center;padding: 24%;" id="loader-files_overview">
								<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-4">
				<div class="project_lunch_date">
					<div class="box_header">
						<figure>
							<img src="<?php echo HTTP_ROOT; ?>img/flag-fill.png" alt="flag">
						</figure>
						<h4>
							<span >
								<?php echo __('Project Launch Date');?>
							</span>
							<span
								<?php							
								if(isset($overdues) && $overdues > 0 ){
									echo 'rel="tooltip"'.' '.' '.'original-title="Overdues by '.$overdues.' days"'.'style="color:red"';
								}
								?>							
							>
							<?php echo $ended_date; ?>
							</span>
						</h4>
					</div>
				</div>
				<div class="task_type">
					<div class="wbox_data">
						<div class="box_header"><h5><?php echo __('Task Type');?></h5></div>
						<div style="text-align:center;padding: 24%;" id="loader-task_status_pie">
							<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
						</div>
						<div id="task_status_pie" style="min-width: 340px; height: 230px; margin: 0 auto;"></div>						
						<div class="clearfix"></div>
						<div class="total_task">
							<?php echo __('Total task');?> <span id="tot_tsx_typ_cnt">0</span>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</section>
		<section>
			<div class="col-md-8">
				<div class="col-md-12">
					<div class="overdue_task">
						<div class="wbox_data">
							<div class="box_header">
								<h5><?php echo __('Overdue Task');?></h5>
                                                                <?php if ($proj['Project']['isactive'] == 1) { ?>
								<?php /* <a href="javascript:void(0)" class="view_more"><?php echo __('View more');?></a>*/ ?>
								<a href="javascript:void(0);" class="view_more" onclick="setTabSelection(); caseMenuFileter('overdue', 'dashboard', 'cases', '');" title="View All Overdue"><?php echo __('View more');?></a>
                                                                <?php } ?>
							</div>
							<div id="to_dos"></div>		
							<div style="text-align:center;padding: 14%;" id="loader-to_dos">
								<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-4">
				<div class="activites">
					<div class="wbox_data">
						<div class="box_header">
							<h5><?php echo __('Activities');?></h5>
                                                        <?php if ($proj['Project']['isactive'] == 1) { ?>
							<a href="javascript:void(0)" class="view_more" onclick="showTasks('activities');"><?php echo __('View more');?></a>
                                                        <?php } ?>
						</div>
						<div class="scroll_body">
						<div id="new_recent_activities"></div>	
						<div style="text-align:center;padding: 30%;" id="loader-new_recent_activities">
							<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</section>
		<section>
			<div class="col-md-12">
			<div class="col-md-12 pad-rht-0 pad-lft-0">
				<div class="task_group">
					<div class="wbox_data">
						<div class="box_header">
							<h5>
								<?php if($_SESSION['project_methodology'] == 'scrum'){ ?>
									<?php echo __('Sprint');?>
								<?php }else{ ?>
									<?php echo __('Task Group');?>
								<?php } ?>
							</h5>
              <?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
               <?php if ($proj['Project']['isactive'] == 1) { ?>
               			<?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
							<button class="view_more" value="Add" type="button" onclick="addEditMilestone(this);">
								<?php echo __('Create Task Group');?>
							</button>
						<?php }?>
              <?php } ?>
              <?php } ?>
						</div>
						<div id="project_groups"></div>
						<div style="text-align:center;padding: 5%;" id="loader-project_groups">
							<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</section>
		<section class="description-mbtom" style="margin-top: 90px;">
			<div class="col-md-12">
				<div class="col-md-12 pad-rht-0 pad-lft-0">
					<div class="project_description">
						<div class="wbox_data">
							<div class="box_header">
								<h5><?php echo __('Project Description');?></h5>
								
								<button class="view_more" value="Add" type="button" onclick="addproj_des(this);">
								<?php
                                  if(empty($proj['Project']['description'])){
								  echo __('Add Project Description');}else{
								  echo __('Update Project Description');
								 } ?>
							</button>
							</div>
							<p style="word-wrap:break-word;">
							<?php if(!empty($proj['Project']['description'])){ echo h($proj['Project']['description']); }else{ echo '<span style="color:#888;margin-left: 15px;">N/A</span>'; } ?>
							</p>							
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</section>
		
		<section class="description-mbtom">
			<div class="col-md-12">
				<div class="col-md-12 pad-rht-0 pad-lft-0">
					<div class="project_notes">
						<div class="wbox_data">
							<div class="box_header">
								<h5><?php echo __('Notes');?></h5>
							</div>
							<div class="row">
								<a href="javascript:void(0);" id="proj_note_link" class="cmn-bxs-btn"><i class="material-icons">&#xE145;</i> <?php echo __('Add Note'); ?></a>
								<div class="col-md-8" style="margin:30px 0 15px 30px;display:none;" id="proj_note_link_cont">
									<textarea id="proj_notes" rows="2" style="resize:none"></textarea>
									<input type="hidden" id="proj_notes_id" value="0"/>
									<div class="fr mtop30">
										<span class="cancel-link">
											<button type="button" id="cancel_note_btn" class="btn btn-default btn_hover_link cmn_size"onclick="cancelProjNote();">Cancel</button>&nbsp;&nbsp;
										</span>
										<a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="saveProjectNote();" id="save_note_btn"><?php echo __('Save Note');?></a>
										<span id="ldr_pnote" style="display:none;">
											<img src="<?php echo HTTP_ROOT;?>img/images/case_loader2.gif" alt="Loading..." title="Loading...">
										</span>
									</div>
									<div class="cb"></div>									
								</div>
								<div class="cb"></div>
							</div>
							<div id="project_notes"></div>
							<div style="text-align:center;padding: 5%;" id="loader-project_notes">
								<img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading"/>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</section>
		
		<section class="description-mbtom">
			
			<div class="clearfix"></div>
		</section>
		<section class="inactiveTask-mbtom">
					<?php if ($proj['Project']['isactive'] == 2) { ?>
              <div class="col-md-12">
              <div class="wbox_data  tlog-oview">
                  <div class="box_header">
                      <div style="float:left"><h5><?php echo __('Displaying all tasks');?></h5></div>
                      <div  style="float:right" class="all-task-srch"><h5><input type="text" id='inact_search' class="form-control" name="case_search" autocomplete="off" placeholder="<?php echo __('Search Tasks');?>" /><button type="button" onclick="search_data();"><i class="material-icons" style="background:#fff;">&#xE8B6;</i></button></h5></div>
										<div style="clear:both"></div>
									</div>
									<div class="loader_dv_db" id="incativeOverview_ldr" style=""><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..."></center></div>
									<div id="inactiveOverviewTask" class="dboard_cont" style=""></div>            
									<div id="inactive_task_paginate" style="display:block"></div>
								</div>
							</div>
			<div class="clearfix"></div>
          <?php } ?>
		</section>		
	</div>
</div>
		
<div class="crt_task_btn_btm">
	<?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
    <div class="pr">
        <div class="os_plus ctg_btn">
            <div class="ctask_ttip">
                <span class="label label-default"><?php echo __('Create Task Group');?></span>
            </div>
            <a href="javascript:void(0)" onclick="setSessionStorage('Project Overview Page', 'Create Task Group'); addEditMilestone('', '', '', '', '', '');">
                <i class="material-icons">&#xE065;</i>
            </a>
        </div>
    </div>
<?php } ?>
     <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
    <div class="os_plus">
        <div class="ctask_ttip">
            <span class="label label-default"><?php echo __('Create Task');?></span>
        </div>
        <a href="javascript:void(0)" onclick="setSessionStorage('Project Overview Page', 'Create Task'); creatask();">
            <img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
<?php } ?>
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
    var DASHBOARD_ORDER = <?php echo json_encode($dashboard_order); ?>;
	var chk_inctv = "<?php echo $proj['Project']['isactive']; ?>";
	//console.log(DASHBOARD_ORDER);
	function cancelProjNote(){
		$('#proj_note_link').show();
		$('#proj_note_link_cont').hide();
		//$('#proj_notes').tinymce().setContent('');
		//tinymce.activeEditor.setContent('');
		tinymce.get('proj_notes').setContent('');
		$('#save_note_btn').text(_('Save Note'));
		$('#ldr_pnote').hide();
	}
	$(document).ready(function () {
		
			localStorage.removeItem('TIMELOGCOSTREP');

		//Project note start
			
			$('#proj_note_link').off().on('click', function(){
				$('#proj_note_link').hide();
				$('#proj_note_link_cont').show();
				$('#proj_notes_id').val(0);
				$('#save_note_btn').text(_('Save Note'));
				$('#ldr_pnote').hide();
			});
		
			if (typeof(tinymce) != "undefined") {
				//tinymce.execCommand('mceRemoveControl', true, 'proj_notes');
				tinymce.remove('#proj_notes');
			}
			tinymce.init({
				selector: "#proj_notes",
				plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize imagetools help',
				menubar: false,
				branding: false,
				statusbar: false,
				toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor fullscreen',
				toolbar_sticky: true,
				/*autosave_ask_before_unload: true,
				autosave_interval: "30s",
				autosave_restore_when_empty: false,
				autosave_retention: "2m",*/
				importcss_append: true,
				image_caption: true,
				browser_spellcheck: true,
				quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
				//directionality: dir_tiny,
				toolbar_drawer: 'sliding',
				contextmenu: "link",
				resize: false, 
				min_height: 180,
				max_height: 300,
				paste_data_images: false,
				paste_as_text: true,
				autoresize_on_init: true,
				autoresize_bottom_margin: 20,
				content_css: HTTP_ROOT+'css/tinymce.css',
				setup: function(ed) {
					ed.on('Click',function(ed, e) {});
					ed.on('KeyUp',function(ed, e) {
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('Change',function(ed, e) {
						//console.log('Change here');
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('init', function(e) {
					});
				}
			});
			/*$('#proj_notes').tinymce({
					script_url: HTTP_ROOT + 'js/tinymce/tiny_mce.js',
					theme: "advanced",
					//directionality: dir_tiny,
					plugins: "paste, autoresize, directionality, lists, advlist",
					theme_advanced_buttons1: "bold,italic,strikethrough,underline,|, numlist,bullist,|, indent,outdent,|, forecolor,backcolor",
					theme_advanced_resizing: false,
					theme_advanced_statusbar_location: "",
					theme_advanced_toolbar_align: "left",
					paste_text_sticky: true,
					gecko_spellcheck: true,
					paste_text_sticky_default: true,
					forced_root_block: false,
					width: "100%",
					autoresize_min_height: "130px",
					autoresize_max_height: "300px",
					autoresize_on_init: true,
					autoresize_bottom_margin: 20,
					oninit: function() {
						//$('#proj_notes').val(editormessage);
						//$('#proj_notes').tinymce().setContent(editormessage);
					}
			});*/
		//End note
		
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
        	 <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>  
        $('#add_user_pop_pname_overview').next('span.inline-edit-usr').attr('data-prj-id', '<?php echo $prjunid; ?>');
        $('#add_user_pop_pname_overview').next('span.inline-edit-usr').attr('data-prj-name', '<?php echo ucwords(trim($prjnm)); ?>');
    <?php }else{ ?> 
    	$('#add_user_pop_pname_overview').next('span.inline-edit-usr').remove();
    <?php } ?>
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
        //if (search_val != '') {
            var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
            var inact = "<?php echo $proj['Project']['isactive']; ?>";
            if (inact == 2) {
                $("#dsbleInactOver").hide();
            } else {
                $("#dsbleInactOver").show();
            }
            if (inact == 2) {
                $.post(HTTP_ROOT + "easycases/inactive_project_task", {'proId': proId, 'search_val': search_val}, function (data) {
                    if (data) {
                        $("#incativeOverview_ldr").hide();
                        $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                    }
                }, 'json');
            }
        //}
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
            $.post(HTTP_ROOT + "easycases/inactive_project_task", {'proId': proId, 'page': page}, function (data) {
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
            $.post(HTTP_ROOT + "easycases/inactive_project_task", {'proId': proId, 'type': type, 'cases': cases, 'csNum': csNum}, function (data) {
                if (data) {
                    $("#incativeOverview_ldr").hide();
                    $("#inactiveOverviewTask").html(tmpl("inactiveOverview", data));
                }
            }, 'json');
        }
    }
    $(document).on('click', '[id^="inactivetitlehtml"]', function () {
        // openPopup();
        // $(".loader_dv").show();
        // $(".inactive_caseDetails").show();
        var Id = "<?php echo $proj['Project']['id']; ?>";
        var proId = "<?php echo $proj['Project']['uniq_id']; ?>";
        var inact = "<?php echo $proj['Project']['isactive']; ?>";
        var task_data = $(this).attr('data-task').split('|');
        var caseUniqId = task_data[0];
        if (inact == 2) {
            $("#myModalDetail").modal();
	        $(".task_details_popup").show();
	        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
	        $("#cnt_task_detail_kb").html("");
            //easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
            $.post(HTTP_ROOT + "easycases/inactive_case_details", {'id': Id, 'proId': proId, 'caseUniqId': caseUniqId}, function (data) {
                if (data) {
                	$('#caseLoaderPopupKB').hide();
                    // $("#cnt_task_detail_kb").html(tmpl("inactive_case_details_tmpl", data));
                    $("#cnt_task_detail_kb").html(tmpl("case_details_popup_tmpl", data));
                    $(".subtask_holder_div").remove();
                    $(".detail_link_section").find('a').remove();
                    $(".duedate-txt").find('i').remove();
                    $(".logmore-btn,.log-more-time").remove();
                    $(".timelog-opts").remove();
                    $(".attach-close").remove();

                    $(".sub_tasks_tbl").find('.titlehtml').each(function(){
                    	$(this).closest('.max_width_tltsk_title').html('<p>'+$(this).text()+'</p>');
                    	$(this).remove();
                    });
                    
                    $(".sub_tasks_tbl").find('.dropdown').remove();
                    $(".sub_tasks_tbl").find('.showinhover').remove();
                    $(".sub-tasks-popoup").find('.case-title').removeClass('titlehtml');
                    $(".sub-tasks-popoup").find('.case-title').removeClass('case-title');

                    $("img.lazy").lazyload({
	                    placeholder: HTTP_ROOT + "img/lazy_loading.png"
	                });
                   

                     $('.detl_tab_switching').off().on('click', function() {
		                $('.detl_tab_switching').removeClass('current');
		                $(this).addClass('current');
		                var tab_to_swh = $(this).attr('data-tab');
		                var uid_to_swh = $(this).attr('data-case_uid');
		                var tab_to_hid = $(this).attr('data-to_hid');
		                $('#' + tab_to_swh).show();
		                $('#' + tab_to_hid + uid_to_swh).hide();
		            });
                   
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
            $.post(HTTP_ROOT + "easycases/inactive_case_details", {'id': Id, 'proId': proId, 'caseUniqId': caseUniqId}, function (data) {
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
function overviewPDF(){
	var project_UID =  '<?php echo $prjunid; ?>';
	$("#ov_pdf_loader").show();
	$('#overview_exp_lnk').hide();
    $.post("<?php echo HTTP_ROOT.'easycases/downloadProjectOverview'?>",{project_UID:project_UID},function(res){
    	if(res.status){
			$('#overview_exp_lnk').show();
    		$("#ov_pdf_loader").hide();
    		self.location = "<?php echo HTTP_ROOT.'easycases/downloadProjectOverview?project_UID='.$prjunid.'&download=1'?>";
    	}
    },'json');
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
		$('.overViewPrio').remove();
		$('.proj_name_over_task').append(' <span class="overViewPrio"><?php echo $proj_text; ?></span>');
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
<script type="text/javascript">
    $(document).ready(function() {
    <?php if ($proj['Project']['isactive'] != 1) { ?>	
    	recurring_project_groups();
    	recurring_overdue_task();
    	recurring_recent_activities();
    	recurring_files_overview();
    	$(".overview_wrapper").find('li').each(function(){
    		var atext = $(this).find('a').html();
    		$(this).html("<span>"+atext+"</span>");
    	});

    <?php } ?>


		$('#proj_prog_cnt').text('<?php echo round($project_progress); ?>%');
        var data = [<?php echo trim($json_data);?>];
        $('#proj_loading_bar').highcharts({
			credits: {
                enabled: false
            },
             chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false,
                height:140,
				width: 150
            },
            title: {
				text: ''
                 /*text: 'Overall Progress: <?php echo (int)$project_progress; ?>',
                 align: 'center',
				 fontSize: "11px",
                verticalAlign: 'middle',
                y: 15,
				x:0*/
            },
            tooltip: {
                //pointFormat: '{series.name} <b>{point.percentage:.1f}%</b>'
				enabled: false
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: false,
                        distance: 0,
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '43%']
                }
            },
            series: [{
                type: 'pie',
                name: ' ',
                size: '90%',
                innerSize: '80%',
                data: data
            }]
        });
				if(localStorage.getItem("tour_type") == '1'){			
					if(typeof hopscotch !='undefined' && hopscotch.getState()){
						GBl_tour = onbd_tour_project<?php echo LANG_PREFIX;?>;
						var st_nu = hopscotch.getState().split(':');
						//setTimeout(function() {
							hopscotch.startTour(GBl_tour, st_nu[1]);
						//},500);
					}
				}
    });
    function showInactiveMessage(actvt){
        var mssg = '<?php echo __("You can not see");?> ' + actvt + ' <?php echo __("for completed projects");?>';
        showTopErrSucc('error', mssg);
    }
    function recurring_project_groups(){
    	if($("#project_groups").html() ==''){
    		setTimeout(function(){ recurring_project_groups();},7000);
    	}else{
    		$("#project_groups").find('th').each(function(){
    			$txt = $(this).text();
    			$(this).html("<p>"+$txt+"</p>");
    		});
    		return;
    	}
    } 
    function recurring_overdue_task(){
    	if($("#to_dos").html() ==''){
    		setTimeout(function(){ recurring_overdue_task();},7000);
    	}else{
    		$("#to_dos").find('a').each(function(){
    			$txt = $(this).text();
    			$(this).closest('td').html("<p>"+$txt+"</p>");
    		});
    		return;
    	}
    }
    function recurring_recent_activities(){
    	if($("#new_recent_activities").html() == ''){
    		setTimeout(function(){ recurring_recent_activities();},7000);
    	}else{
    		$("#more_recent_activities").remove();
    		$("#new_recent_activities").find('a').each(function(){
    			
    			$(this).removeAttr('onclick');
    			$(this).removeAttr('data-href');
    			$(this).removeAttr('data-pid');
    			$(this).removeAttr('href');
    			
    		});
    		return;
    	}
    }
    function recurring_files_overview(){
    	if($("#files_overview").html() == ''){
    		setTimeout(function(){ recurring_files_overview();},7000);
    	}else{
    		$("#files_overview").find('a').each(function(){
    			$(this).removeAttr('href');
    		});
			notShowEmptyDropdown();
    		return;
    	}
    }
	/**
 * hide_flscrn_div
 * show full screen data and  hide overview dashboard 
 * @return void
 * @author bijay
 * date - 07/08/2021
 */
	function fulscreen_div2(type) {
        if (type == "cost_rprt") {
            var data = $('#rag_cost_report').html();
            if (data.indexOf("Oops") == -1) {
                $(".hide_buttn").toggle();
                $('.cst_rprt_tr').show();
                $('#cost_rpt_highchart').hide();
                $('#rag_cost_report').addClass('fullscreen');
            } else {
                showTopErrSucc('error', 'No data to display');
            }
        } 
    }
	function fulscreen_div3(type) {
        if (type == "resource_cost_rprt") {
			// this.find("table tr td").removeClass('text-center');
			// $("div").find('.os_projct_overview .wbox_data table tr td').removeClass('text-center');
            var data = $('#resource_cost_report').html();
            if (data.indexOf("Oops") == -1) {
                $(".hide_buttn").toggle();
                $('.view_tr').toggle();
                $('.hide_td').show();
                $('.resource_tr').show();
				$('#resource_cost_rpt_highchart').hide();
				$("#zoomData").addClass('mbtm30 ');
                $('#resource_cost_report').addClass('fullscreen');
            } else {
                showTopErrSucc('error', 'No data to display');
            }
        }
    }
	/**
 * hide_flscrn_div
 * hide full screen data and show overview dashboard 
 * @return void
 * @author bijay
 * date - 07/08/2021
 */
    function hide_flscrn_div(type) {
       if (type == 'cost_rprt') {
            $(".hide_buttn").toggle();
            $('.cst_rprt_tr').hide();
			$('#cost_rpt_highchart').show();
            $('#rag_cost_report').removeClass('fullscreen');
        } else if (type == 'resource_cost_rprt') {
            $(".hide_buttn").toggle();
			$('.resource_tr:gt(8)').css("display", "none");
            // $('.resource_tr').hide();
			$('#resource_cost_rpt_highchart').show();
            $('#resource_cost_report').removeClass('fullscreen');
        } 
    }
	/**
  * prj_change_rsrc_reprt
  * fetch resource cost report on change of project list
  * @return void
  * @author bijay
  * date- 07/08/2021 
  */
	function prj_change_rsrc_reprt() {
		$('#loader-resource_cost_report').show();
		var projids = '<?php echo $prjunid; ?>';
		$('#resource_cost_report').html("");
		var url = HTTP_ROOT + 'easycases/resource_cost_report';
		var tmeflt = $('#sel_rsrc_time_typ').val();
		localStorage.removeItem('TIMELOGCOSTREP');
		localStorage.setItem('TIMELOGCOSTREP', JSON.stringify(tmeflt));
		$('#resource_cost_report_ldr').show();
		$.post(url, {
			"projid": projids,
			'task_type_id':0,
			"time_flt": tmeflt,
			'extra':'overview'
		}, function(data) {
			$('#loader-resource_cost_report').hide();
			$('#resource_cost_report').html(data);
		});
	} 
</script>


