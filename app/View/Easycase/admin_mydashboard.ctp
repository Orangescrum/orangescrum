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
    .dynaic_elipse_data{display: inline-block;max-width:100%;white-space:nowrap;text-overflow:ellipsis; overflow:hidden}
    .dashboard_page .user-taskype-box, .dashboard_page .user-dash-activity{height:430px;} 
    .select2-container .select2-search--inline .select2-search__field{margin-top:0.5px}
    .select_field_wrapper .select2 .select2-selection .select2-selection__rendered{padding:3px 15px 0 15px}
 
</style>
<script type="text/javascript" src="<?php echo JS_PATH; ?>moment.js" defer></script>
<div class="dashboard_page" ng-app="dashboard_App">
    <div ng-controller="dashboard_Controller" ng-init="init('<?php echo PROJ_UNIQ_ID; ?>')" id="dashboard_Controller" >
        <div class="row top_dboard_src">
            <div class="col-lg-12">
                <div class="width100 cmn_bdr_shadow">
                    <div  class="width20 fl">
                        <a href="<?php echo HTTP_ROOT . 'projects/manage' . $projecturl; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Projects','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <?php
                        $type = $_COOKIE['PROJECTVIEW_TYPE'];
                        $type = explode('_', $type);
                        $projecturl = '';
                        $projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
                        ?>
                        <h4 class="ellipsis-view mx-width-95" rel="tooltip" title="<?php echo number_format($prjcnt); ?>"><span class="os_sprite task_duedt"></span><?php echo number_format($prjcnt); ?></h4>
                        <h6><?php echo __('Projects');?></h6>
                        </a>
                    </div>
                    <div  class="width20 fl">
                        <a href="javascript:void(0);" onclick="statusTop(3);return trackEventLeadTracker('Admin Dashboard','Closed Tasks/Total Tasks','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" >
                        <?php
                        $closedtasks = $closedtasks != '' ? $closedtasks : 0;
                        $totaltasks = $totaltasks != '' ? $totaltasks : 0;
                        ?>
                        <h4 class="ellipsis-view mx-width-95" rel="tooltip" title="<?php echo number_format($closedtasks) . '/' . number_format($totaltasks); ?>"><span class="os_sprite spent_blog"></span><?php echo number_format($closedtasks) . '/' . number_format($totaltasks); ?></h4>
                        <h6><?php echo __('Closed Tasks');?>/<?php echo __('Total Tasks');?></h6>
                        </a>
                    </div>
                    <div  class="width20 fl">
                        <a href="<?php echo HTTP_ROOT . 'users/manage'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Active Users','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <h4 class="ellipsis-view mx-width-95" rel="tooltip" title="<?php echo number_format($usrcnt); ?>"><span class="os_sprite active_usr"></span><?php echo number_format($usrcnt); ?></h4>
                        <h6><?php echo __('Active User');?><?php if ($usrcnt > 1) { ?>s<?php } ?></h6>
                        </a>
                    </div>
                    <div  class="width20 fl">
                        <a href="<?php echo HTTP_ROOT . 'dashboard#timelog'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Spent And Still Counting','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <h4 class="ellipsis-view mx-width-95" rel="tooltip" title="<?php echo $this->Format->format_time_hr_min($totalhours,'',1) != '' ? $this->Format->format_time_hr_min($totalhours,'',1) : '00 hrs & 00 mins'; ?>"><span class="os_sprite spent_scount"></span><?php echo $this->Format->format_time_hr_min($totalhours,'',1) != '' ? $this->Format->format_time_hr_min($totalhours,'',1) : '00 hrs & 00 mins'; ?></h4>
                        <h6><?php echo __('Spent and still counting');?></h6>
                        </a>
                    </div>
                    <div  class="width20 fl">
                        <a href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','MB Of File Storage','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');">
                        <h4 class="ellipsis-view mx-width-95" rel="tooltip" title="<?php echo number_format($usedspace,2); ?>"><span class="os_sprite file_store"></span><?php echo number_format($usedspace,2); ?></h4>
                        <h6><?php echo __('MB of File Storage');?></h6>
                        </a>
                    </div>

                    <div  class="cb"></div>
                </div>
            </div>
        </div>    
    <div class="row mtop20 dash-row dash-mpad">
        <div class="col-lg-6 padrht-non">
            <div class="width100 cmn_bdr_shadow top-5p">
                <div class="top_ttl_box top-5-prj-ttl">
                    <h2 class=""><a href="<?php echo HTTP_ROOT . 'projects/manage' . $projecturl; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Top Five Projects','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Top Five Projects');?></a></h2>
                    <small class="sml-txt"><?php echo __('In terms of number of tasks');?></small>
                </div>
                <!--<div class="loader_dv_db" id="admin_task_status_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>-->
                <div id="admin_task_status">
                    <?php include("admin_task_status1.ctp");?>
                </div>
				<div style="text-align: right;padding: 5px 30px 0;font-size: 13px;">
				 <a href="<?php echo $this->Html->url(array("controller" => "projects","action" => "manage"));?>" rel="tooltip" title="<?php echo __('All Projects');?>"><?php echo __('View all projects');?></a>
				</div>
            </div>
        </div>
        <div class="col-lg-6 dash-pc">
            <div class="col-lg-6 padlft-non padrht7">
                <div class="cmn_bdr_shadow active-com-prj">
                    <div class="top_ttl_box">
                        <h2><a href="<?php echo HTTP_ROOT . 'projects/manage' . $projecturl; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Active/Completed Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Active');?>/<?php echo __('Completed Project');?></a></h2>
                    </div>
                    <div class="loader_dv_db" id="all_projects_ldr" style="position:absolute;display: none;margin-top:90px;margin-left:100px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                    <div class="comp_proj_dboard project-chart" id="all_projects">
                        <div id="all_projects_pie" style="width:100%;"></div>
<?php /* <img src="img/images/chart.jpg"/> */ ?>
                    </div>
                    <div class="ac-prject">
                        <div class="pull-left">
                            <div>
                                <p><?php echo __('Last 30 days');?></p>
                                <span><?php echo $last30dayscreatedprjcnt; ?> <?php echo __('New projects');?></span>
                            </div>
                            <div class="mtop20">
                                <p><?php echo __('Completed');?></p>
                                <span><?php echo $cmpldprjcnt; ?> <?php echo __('projects');?></span>
                            </div>
                        </div>
                        <div class="pull-right active-project-no">
                            <big><?php echo $actvprjcnt; ?></big>
                            <small><?php echo __('Active projects');?></small>
                        </div>
                        <div class="cb"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 padrht-non padlft7">
                <div class="cmn_bdr_shadow dash-client">
                    <div class="top_ttl_box">
                        <h2><a href="<?php echo HTTP_ROOT . 'users/manage/?role=client'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Clients','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Clients');?></h2>
                    </div>
                    <div class="loader_dv_db" id="all_clients_ldr" style="display: none;margin-top:90px"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                    <div class="clients_dboard client-chart" id="all_clients">
						<div id="clients_piechart" class="client-chrt-prnt"></div>
					</div>
                </div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
    <div class="row mtop20 dash-row dash-mpad">
        <div class="col-lg-6 padrht-non">
            <div class="width100 cmn_bdr_shadow dasht-log">
                <div class="top_ttl_box">
                    <h2><a href="<?php echo HTTP_ROOT . 'dashboard#timelog'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Time Log','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Time Log');?></a></h2>
                </div>
                <div class="loader_dv_db" id="dashboard_timelog_ldr" style="position:absolute;display: none;margin-top: 150px;margin-left:250px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                <div class="time_log_dboard time_log" id="dashboard_timelog">
					<div id="dboardtimelog" class="tlog-chrt-prnt"></div>
				</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="width100 cmn_bdr_shadow dash-pwrs">
                <div class="top_ttl_box">
                    <h2><a href="<?php echo HTTP_ROOT . 'resource-utilization'; ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Project wise Resource Utilization','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Project wise Resource Utilization');?></a></h2>
                </div>
                <!--<div class="loader_dv_db" id="project_resource_utilization_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>-->
                <div id="project_resource_utilization" class="project-utilization">
                    <?php include("project_resource_utilization1.ctp");?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mtop20 dash-row dash-mpad">
        <div class="col-lg-4 padrht-non">
            <div class="width100 cmn_bdr_shadow dash-tasklist">
                <div class="top_ttl_box">
                    <h2><a href="javascript:void(0);" onclick="showTasks('my');return trackEventLeadTracker('Admin Dashboard','Task List','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Task List');?></a></h2>
                </div>
<!--                <div class="loader_dv_db" id="to_dos_ldr" style="display: none;margin-top:90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>-->
                <div id="to_dos" data-example-id="togglable-tabs" class="bs-example bs-example-tabs ">
                    <?php include("to_dos1.ctp");?>
                </div>
                <div class="fr moredb" id="more_to_dos" style="padding-top:0px;"><a href="javascript:void(0);" onclick="showTasks('my');return trackEventLeadTracker('Admin Dashboard','View All Task List','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('View All');?> <span id="todos_cnt" style="display:none;">(0)</span></a></div>
            </div>
        </div>
        <div class="col-lg-4 padrht-non">
            <div class="width100 cmn_bdr_shadow dash-task-status">
                <div class="top_ttl_box">
                    <h2><a href="<?php echo HTTP_ROOT; ?>dashboard#kanban" onclick="return trackEventLeadTracker('Admin Dashboard','Task Status','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Task Status');?></a></h2>
                </div>
                <div class="dash-status-graph">
                    <div>
                        <div class="loader_dv_db" id="project_status_ldr" style="display: none;margin-top:90px"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                        <div  id="project_status">
                            <div id="project_status_pie<?php echo $fragment?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="width100 cmn_bdr_shadow dash-task-type mtop20">
                <div class="top_ttl_box">
                    <h2><a href="<?php echo HTTP_ROOT; ?>task-type" onclick="return trackEventLeadTracker('Admin Dashboard','Task Status','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Task Type');?></a></h2>
                </div>
                <div id="task_status_pie" class="dash-tasktype-graph" style="height:330px;">
                    <div class="loader_dv_db" id="task_types_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="width100 cmn_bdr_shadow dash-activity">
                <div class="top_ttl_box">
                    <h2><a href="<?php echo HTTP_ROOT . 'dashboard#activities' ?>" onclick="return trackEventLeadTracker('Admin Dashboard','Activity','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');"><?php echo __('Activity');?></a></h2>
                </div>
                <div class="custom-flow">
                     <div id="new_recent_activities" class="dash-activity-cont mtop10">
                        <?php include('recent_activities1.ctp');?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row  mtop20 dash-row dash-mpad">
        <div class="col-lg-4 sortable-div padrht-non">
            <div class="width100 cmn_bdr_shadow dash-activity user-dash-activity">
                <div class="top_ttl_box">
                    <div class=""><h2><a href="<?php echo HTTP_ROOT?>bookmarks/bookmarksList"><?php echo __('Bookmarks list'); ?></a></h2></div>
                </div>
                <div class="htdb cstm_scroll">
                <div class="loader_dv_db" id="dashboardbookmarkslist_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="dashboardbookmarkslist" class="dashboardbookmarkslist"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="crt_task_btn_btm">
    <div class="pr">
  <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
            <div class="os_plus usr_btn">
                <div class="ctask_ttip">
                    <span class="label label-default"><?php echo __('Add New User');?></span>
                </div>
                <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard Page', 'Add New User');newUser();">
                    <i class="material-icons cmn-icon-prop">&#xE7FB;</i>
                </a>
            </div>
<?php } ?>
  <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
        <div class="os_plus prj_btn">
            <div class="ctask_ttip">
                <span class="label label-default"><?php echo __('Create New Project');?></span>
            </div>
            <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard Page','Create Project');newProject();">
                <i class="material-icons cmn-icon-prop">&#xE8F9;</i>
            </a>
        </div>
  <?php } ?>
  <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
        <div class="os_plus ctg_btn">
            <div class="ctask_ttip">
                <span class="label label-default"><?php echo __('Create Task Group');?></span>
            </div>
            <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard Page','Create Task Group');addEditMilestone('','','','','','');">
                <i class="material-icons">&#xE065;</i>
            </a>
        </div>
  <?php }?>
    </div>
<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
    <div class="os_plus">
        <div class="ctask_ttip">
            <span class="label label-default"><?php echo __('Create Task');?></span>
        </div>
        <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard Page','Create Task');creatask();">
            <img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
<?php } ?>
</div>
<script type="text/javascript">
    var DASHBOARD_ORDER = <?php echo json_encode($GLOBALS['DASHBOARD_ORDER']); ?>;
    //    $(document).ready(function() {
    //	loadDashboardPage('<?php echo PROJ_UNIQ_ID; ?>');
    //    });
	$( document ).ready(function() {
        <?php if($this->Session->read('project_url')=='create_project'){?>
             setSessionStorage('Quick Links','Create Project');
             newProject();   
        <?php }?>
       $("#sel_rsrc_project").select2({
        placeholder: "Select projects",
            allowClear: true
       });
       $("#sel_rsrc_time_typ").select2();
    });
 
 /**
  * prj_change_rsrc_reprt
  * fetch resource cost report on change of project list
  * @return void
  * @author bijay
  * date- 07/08/2021 
  */
 function prj_change_rsrc_reprt() {
    $('#resource_cost_report').html("");
    var url = HTTP_ROOT + 'easycases/resource_cost_report';
    var tmeflt = $('#sel_rsrc_time_typ').val();
    localStorage.removeItem('TIMELOGCOSTREP');
    localStorage.setItem('TIMELOGCOSTREP', JSON.stringify(tmeflt));
    var prjlrpt = $('#sel_rsrc_project').val();
    localStorage.removeItem('PROJECTLOGCOSTREP');
    localStorage.setItem('PROJECTLOGCOSTREP', JSON.stringify(prjlrpt));
    var project_cost_rep = localStorage.getItem('PROJECTLOGCOSTREP');
    if (project_cost_rep === 'null') {
        project_cost_rep = [];
    } else {
        project_cost_rep = JSON.parse(project_cost_rep);
    }
    $('#resource_cost_report_ldr').show();
    $.post(url, {
        "projid": project_cost_rep,
        "time_flt": tmeflt
    }, function(data) {
        $('#resource_cost_report_ldr').hide();
        $('#resource_cost_report').html(data);
    });
}  

/**
 * fulscreen_div
 * show full screen data and hide dashboard
 * @return void
 * @author bijay
 * date - 07/08/2021
 */
function fulscreen_div(type) {
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
function fulscreen_div1(type) {
  if (type == "resource_cost_rprt") {
        var data = $('#resource_cost_report').html();
        if (data.indexOf("Oops") == -1) {
            $(".hide_buttn").toggle();
            $('.view_tr').toggle();
            $('.hide_td').show();
            $('.resource_tr').show();
            // $('#resource_cost_rpt_highchart').hide();
            $('#resource_cost_report').addClass('fullscreen');
            $("#zoomData").addClass('mbtm30 ');
        } else {
            showTopErrSucc('error', 'No data to display');
        }
    }
}
/**
 * hide_flscrn_div
 * hide full screen data and show dashboard 
 * @return void
 * @author bijay
 * date - 07/08/2021
 */
    function hide_flscrn_div(type) {
       if (type == 'cost_rprt') {
            $(".hide_buttn").toggle();
            // $('.cst_rprt_tr:gt(4)').css("display", "none");
            $('.cst_rprt_tr').hide();
            $('#rag_cost_report').removeClass('fullscreen');
            $('#cost_rpt_highchart').show();
        } else if (type == 'resource_cost_rprt') {
            $(".hide_buttn").toggle();
            $('.resource_tr:gt(8)').css("display", "none");
            // $('.resource_tr').hide();
            // $('#resource_cost_rpt_highchart').show();
            $('#resource_cost_report').removeClass('fullscreen');
        } 
    }
    $(".select2-scroll-remover").click(function(e){
        $('body').addClass('resource-cost-overflow');
        e.stopPropagation();
    });
    // $(document).on('click',function(){
    //     $('body').removeClass('resource-cost-overflow');
    // });
</script>