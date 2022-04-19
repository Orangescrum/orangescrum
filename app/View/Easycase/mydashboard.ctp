<style>
    .cmpl_gblue{height:inherit;margin: 0px;padding:11px 0 11px 22px;text-align: center;float: left;color:#fff; position: relative;}

    .cmpl_gblue:after, .cmpl_gblue:before {left:100%;top: 50%;border: solid transparent;content: " ";height: 0;width: 0;position: absolute;
                                           pointer-events: none; z-index:1;}
    .cmpl_gblue:after {border-width: 21px;margin-top: -21px;}
    .cmpl_gblue:before {border-width: 21px;margin-top: -21px;}

    /*.cmpl_gblue.task_one_g:after, .cmpl_gblue.task_one_g:before{left:100.5%;}
    .cmpl_gblue.task_four_g:after, .cmpl_gblue.task_four_g:before{left:107%;}*/

    .cmpl_gblue.task_one_g{position: relative;background: #F19A91;border: 0px solid #F19A91;}
    .cmpl_gblue.task_one_g:after {border-color: rgba(174, 67, 46, 0);border-left-color: #F19A91;}
    .cmpl_gblue.task_one_g:before {border-color: rgba(174, 67, 46, 0);border-left-color: #F19A91;}

    .cmpl_gblue.task_two_g{position: relative;background: #8DC2F8;border: 0px solid #8DC2F8;}
    .cmpl_gblue.task_two_g:after {border-color: rgba(36, 79, 122, 0);border-left-color: #8DC2F8;}
    .cmpl_gblue.task_two_g:before {border-color: rgba(36, 79, 122, 0);border-left-color: #8DC2F8;}

    .cmpl_gblue.task_three_g{position: relative;background:#F3C788;border: 0px solid #F3C788;}
    .cmpl_gblue.task_three_g:after {border-color: rgba(239, 104, 7, 0);border-left-color:#F3C788;}
    .cmpl_gblue.task_three_g:before {border-color: rgba(239, 104, 7, 0);border-left-color:#F3C788;}

    .cmpl_gblue.task_four_g{position: relative;background:#8AD6A3;border: 0px solid #8AD6A3;}
    .cmpl_gblue.task_four_g:after {border-color: rgba(119, 171, 19, 0);border-left-color:#8AD6A3;}
    .cmpl_gblue.task_four_g:before {border-color: rgba(119, 171, 19, 0);border-left-color:#8AD6A3;}

    .rht_content_cmn.task_lis_page .wrapper{padding:105px 0px 0px}
    .green-btn {border:1px solid #48BF6F;background:#48BF6F;color: #fff;}
    .gray-btn {border:1px solid #E6E6E6;background:#E6E6E6;color:black;}
    .fnu-icon{background:url(../img/updates/prodcut-update-icons.png) no-repeat;display:inline-block;width:30px;height:30px;position:relative;}
    .fnu-icon.fix-icon{background-position:0px -1px;left:0;top:10px}
    .fnu-icon.new-icon{background-position:-27px -1px;left:0;top:10px}
    .fnu-icon.update-icon{background-position:-52px -1px;left:0;top:10px}
    .fnu-btn a{text-decoration:none;font-size:13px;background:#e6e6e6;padding:4px 8px;color:#5a5a5a;border-radius:5px;cursor:default;}
    .device-icon{position:relative}
    .device-icon::before{content:'';background:url(../img/updates/sprite-updtaes.png) no-repeat 0px 0px ;position:relative;display:inline-block;vertical-align: middle;margin-right:3px;width: 24px;height: 30px;}
    .device-icon.ios::before{background-position:0px 0px;}
    .device-icon.android::before{background-position:0px -81px;}
    .device-icon.chart::before{background-position: 0px -39px;}
</style>
<div class="dashboard_page cmn_new_dashboard"  ng-app="dashboard_App">
    <div ng-controller="dashboard_Controller" ng-init="init('<?php echo PROJ_UNIQ_ID; ?>')" >
        <div class="col-md-12">
            <?php /** <div class="share_print">
              <span class="cmn_icon"><i class="material-icons">local_printshop</i></span>
              <span class="cmn_icon"><i class="material-icons">share</i></span>
              </div> * */ ?>
            <div class="col-md-8 padnon">
                <div class="col-md-6 padlft-non">
                    <div class="element_box">
                        <div class="element_header">
                            <span class="cmn_icon"><i class="material-icons">assignment_returned</i></span>
                            <strong><?php echo __('My Task');?>&nbsp;<small id ="myTaskCountId">(0)</small></strong>
                            <span class="cmn_icon zoom_icon"><a href="javascript:void(0);" onclick="mytasksection(1);" title="<?php echo __('View More');?>" ><i class="material-icons">zoom_out_map</i></a></span>
                        </div>
                        <div class="dashLoader" id="loader-mytaskId">
                            <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                        </div>
                        <div class="element_body box_list_cont" id ="myTaskId">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 padlft-non">
                    <div class="element_box">
                        <div class="element_header">
                            <span class="cmn_icon"><i class="material-icons">error</i></span>
                            <strong><?php echo __('Overdue');?>&nbsp;<small id ="myOverdueTaskCountId">(0)</small></strong>
                            <span class="cmn_icon zoom_icon"><a href="javascript:void(0);" onclick="mytasksection(2);"><i class="material-icons" title="<?php echo __('View More');?>" >zoom_out_map</i></a></span>
                        </div>
                        <div  class="dashLoader" id="loader-overdueId">
                            <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                        </div>
                        <div class="element_body box_list_cont" id ="myOverdueTaskId">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 padlft-non">
                    <div class="element_box">
                        <div class="element_header">
                            <span class="cmn_icon"><i class="material-icons">linear_scale</i></span>
                            <strong><?php echo __('Progress');?></strong>
                        </div>
                        <div class="dashLoader" id="loader-progressDashboardId">
                            <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                        </div>
                        <div class="element_body progress_tbl" id ="progressDashboardId">

                        </div>
                    </div>
                </div>
                <div class="col-md-6 padlft-non">
                    <div class="element_box task">
                        <div class="element_header">
                            <span class="cmn_icon"><i class="material-icons">assignment_returned</i></span>
                            <strong><?php echo __('Task Status');?></strong>
                            <span class="cmn_icon zoom_icon"><a href="javascript:void(0);" onclick="mytasksection(3);" title="<?php echo __('View More');?>" ><i class="material-icons">zoom_out_map</i></a></span>
                        </div>
                        <div class="element_body">
                            <div class="dashLoader" id="loader-taskPieChartId">
                                <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                            </div>
                            <div class="chat_box" id ="taskPieChartId" style="display:none;">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 padlft-non">
                <div class="element_box activity width100 cmn_bdr_shadow dash-activity user-dash-activity">
                    <div class="element_header">
                        <span class="cmn_icon"><i class="material-icons">show_chart</i></span>
                        <strong><?php echo __('Activity');?></strong>
                        <span class="cmn_icon zoom_icon"><a href="javascript:void(0);" onclick="openActivity();" title="<?php echo __('View More');?>"><i class="material-icons">zoom_out_map</i></a></span>
                    </div>
                    <div class="element_body">
                        <div class="custom-flow">
                            <div class="dashLoader" id="loader-activities">
                                <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                            </div>
                            <div id="new_recent_activities" class="dash-activity-cont mtop10">

                                <?php include('recent_activities1.ctp'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="col-md-4 padlft-non">
                <div class="element_box workload">
                    <div class="element_header">
                        <span class="cmn_icon"><i class="material-icons">fitness_center</i></span>
                        <strong><?php echo __('Workload');?></strong>
                        <?php /*                         * <span class="cmn_icon zoom_icon"><i class="material-icons">zoom_out_map</i></span> * */ ?>
                    </div>
                    <div class="element_body" >
                        <div class="dashLoader" id="loader-workloadChartId">
                            <img src="<?php HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading">
                        </div>
                        <div class="chat_box" id ="workloadChartId" style="display:none;">

                        </div>

                        <div class="chat_box"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 padlft-non">
                <div class="element_box">
                    <div class="element_header">
                        <span class="cmn_icon"><i class="material-icons">assignment_returned</i></span>
                        <strong><?php echo __('Task Type');?></strong>
                    </div>
                    <div class="element_body">
                        <div id="task_status_pie" class="chat_box dboard_cont dash-tasktype-graph" style="height:250px;">
                            <div class="loader_dv_db" id="task_status_pie_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading'); ?>..." /></center></div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-4 padlft-non">
                <div class="element_box overall_type">
                    <div class="element_header">
                        <select id="sel_task_types" class="fl" onchange="showTaskStatus(this, '<?php echo PROJ_UNIQ_ID; ?>');">
                            <?php foreach ($task_type as $key => $value) { ?>
                                <option value="<?php echo $value['Type']['id']; ?>" <?php
                                if (isset($_COOKIE['TASK_TYPE_IN_DASHBOARD']) && $_COOKIE['TASK_TYPE_IN_DASHBOARD'] == $value['Type']['id']) {
                                    echo "selected='selected'";
                                }
                                ?>><?php echo $value['Type']['name']; ?></option>
                                    <?php } ?>
                        </select>
                        <p class="pichart_msg" id="task_types_msg"></p>
                        <div class="cb"></div>
                    </div>
                    <div class="element_body">
                        <div id="task_types" class="dboard_cont chat_box">
                            <div class="loader_dv_db" id="task_types_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading'); ?>..." /></center></div>
                        </div>
                        <div class="chat_status" id="legendTaskTypeId" style="display:none;">
                            <ul>
                                <li><span class="completeli"></span><?php echo __('Completed');?></li>
                                <li><span class="progressli"></span><?php echo __('New & In progress');?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <?php /*         * <div class="col-md-12 padlft-non">
          <div class="element_box timesheet">
          <div class="element_header">
          <span class="cmn_icon"><i class="material-icons">fitness_center</i></span>
          <strong>Workload</strong>
          <span class="cmn_icon zoom_icon"><i class="material-icons">zoom_out_map</i></span>
          </div>
          <div class="element_body">
          </div>
          </div>
          </div>
          <div class="clearfix"></div> * */ ?>
           <?php /*<div class="col-md-12">
            <div class="col-md-8 padlft-non">
                <div class="element_box latest_update_fix">
                    <div class="element_header">
                        <span class="cmn_icon"><i class="material-icons">history</i></span>
                        <strong><?php echo __('Latest Updates & Fixes');?></strong>
                        <span class="cmn_icon zoom_icon"><a href="<?php echo HTTP_ROOT . 'updates'; ?>" onclick="trackEventLeadTracker('Quick Links', 'Product Updates Page', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" title="<?php echo __('View More');?>" target="_blank"><i class="material-icons">zoom_out_map</i></a></span>
                    </div>
                    <div class="element_body">
                        <div class="latest_fix_roadmap" id ="latestUpdateId">
                            <?php
                            foreach ($updates as $k => $v) {
                                $device_type = 'chart';
                                if (stristr(strtolower($v['ProductUpdate']['description']), 'ios')) {
                                    $device_type = 'ios';
                                } elseif (stristr(strtolower($v['ProductUpdate']['description']), 'android')) {
                                    $device_type = 'android';
                                }
                                ?>
                                <div class="release_row">
                                    <span class="fixes_priority fnu-icon <?php echo $v['ProductUpdate']['type']; ?>-icon"></span>
                                    <table>
                                        <tr>
                                            <td class="td_1st"><?php echo $v['ProductUpdate']['date']; ?></td>
                                            <td class="td_2nd"><div class="fixses_status"><?php echo ucfirst($v['ProductUpdate']['type']); ?></div></td>
                                            <td class="td_3rd"><div class="version"><?php echo $v['ProductUpdate']['version']; ?></div></td>
                                            <td class="td_4th"><div class="release_btn <?php if ($v['ProductUpdate']['status'] == 1) { ?>green-btn<?php } else { ?>gray-btn<?php } ?>"><span class="device-icon <?php echo $device_type; ?>"></span><?php if ($v['ProductUpdate']['status'] == 1) { ?>Released<?php } else { ?>Expected<?php } ?></div></td>
                                            <td class="td_5th"><?php echo $v['ProductUpdate']['description']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 padlft-non">
                <div class="element_box help_support">
                    <div class="element_header">
                        <span class="cmn_icon"><i class="material-icons">help</i></span>
                        <strong><?php echo __('Help & Support');?> </strong>
                    </div>
                    <div class="element_body">
                        <table>
                            <tbody>
                                <tr><td><a href="javascript:void(0);"  data-backdrop="false" data-toggle="modal" data-target="#helpvideo" onclick="setVideoContent();trackEventLeadTracker('Header Link', 'Help', 'jaikumar231@gmail.com');"><?php echo __('How OrangeScrum Works');?></a></td></tr>
                                <tr><td><a href="<?php echo KNOWLEDGEBASE_URL;?>getting-started-orangescrum/" target="_blank"><?php echo __('How OrangeScrum Helpdesk');?></a></td></tr>
                                <tr><td><a href="javascript:void(0);" data-toggle="modal" data-target="#feeback_modal" rel="tooltip_down" original-title="Feedback"><?php echo __('Share Your Feedback');?></a></td></tr>
                                <tr><td><a href="https://www.capterra.com/reviews/136500/OrangeScrum/new" target="_blank"><?php echo __('Review Us On Capterra');?></a></td></tr>
                                <tr><td><a href="<?php echo CUSTOMER_SUPPORT_URL;?>" target="_blank"><?php echo __('Contact Us');?></a></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>*/ ?>
        <div class="col-md-12">
                <!-- <div class="col-md-8 padlft-non">
                <div class="row  mtop20 dash-row dash-mpad">
                <div class="col-lg-8 sortable-div">
                    <div class="width100 cmn_bdr_shadow dash-activity user-dash-activity">
                        <div class="top_ttl_box">
                            <div class="fl"><h2><?php echo __('Bookmarks list'); ?></h2></div>
                        </div>
                        <div class="htdb cstm_scroll">
                        <div class="loader_dv_db" id="dashboardbookmarkslist_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                            <div id="dashboardbookmarkslist" class="dashboardbookmarkslist"></div>
                        </div>
                    </div>
                </div>
                </div> -->
           
                 <div class="col-md-4 padlft-non">
                    <div class="element_box">
                        <div class="element_header">
                            <!-- <span class="cmn_icon"><i class="material-icons">assignment_returned</i></span> -->
                            <!-- <strong><?php echo __('Bookmarks list');?>&nbsp;<small id ="myTaskCountId">(0)</small></strong> -->
                            <strong><?php echo __('Bookmarks list');?>
                        </div>
                        <div class="loader_dv_db" id="dashboardbookmarkslist_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                            <div id="dashboardbookmarkslist" class="dashboardbookmarkslist"></div>
                        </div>
                    </div>
                </div>
               
            </div>
        <div class="clearfix"></div>
        </div>
        <br/><br/>
    </div>
</div>
</div>
</div>
<div class="crt_task_btn_btm">
    <div class="pr">
        <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
        <div class="os_plus prj_btn">
            <div class="ctask_ttip">
                <span class="label label-default"><?php echo __('Create New Project'); ?></span>
            </div>
            <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard User Page', 'Create Project');newProject();">
                <i class="material-icons cmn-icon-prop">&#xE8F9;</i>
            </a>
        </div>
    <?php } ?>
    <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
        <div class="os_plus ctg_btn">
            <div class="ctask_ttip">
                <span class="label label-default"><?php echo __('Create Task Group'); ?></span>
            </div>
            <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard User Page', 'Create Task Group');addEditMilestone('', '', '', '', '', '');">
                <i class="material-icons">&#xE065;</i>
            </a>
        </div>
    <?php } ?>
    </div>
    <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
    <div class="os_plus">
        <div class="ctask_ttip">
            <span class="label label-default"><?php echo __('Create Task'); ?></span>
        </div>
        <a href="javascript:void(0)" onclick="setSessionStorage('Dashboard User Page', 'Create Task');creatask();">
            <img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
<?php } ?>
</div>
<script type="text/template" id="my_task_tmpl">
<?php echo $this->element('my_tasks'); ?>
</script>
<script type="text/template" id="my_overdue_tmpl">
<?php echo $this->element('my_overdue'); ?>
</script>
<script type="text/template" id="my_progress_tmpl">
    <?php echo $this->element('my_progress'); ?>
</script>
<script type="text/javascript">
    var DASHBOARD_ORDER = <?php echo json_encode($GLOBALS['DASHBOARD_ORDER']); ?>;
    $(document).ready(function () {
        if (SES_TYPE == 3) {

        }
    });
    function mytasksection(typ) {
        createCookie('DASHMYTASK', '1', 365, DOMAIN_COOKIE);
				if(typ == '2'){
					window.location = HTTP_ROOT + 'dashboard#tasks/overdue';
				}else if(typ == '1'){
					window.location = HTTP_ROOT + 'dashboard#tasks/assigntome';
				}else{
					window.location = HTTP_ROOT + 'dashboard#tasks';
				}
    }
    function openActivity() {
        var prjunid = $('#projFil').val();
        var prjunid_t = $('#pname_dashboard_hid').val();
        if (prjunid_t.toLowerCase() == 'all') {
            showTopErrSucc('error', _('Oops! You are in') + " " + _('All') + " " + _('project. Please choose a project.'));
            return false;
        } else {
            window.location = HTTP_ROOT + 'dashboard#activities';
        }
    }
//    function myoverduesection() {
//        createCookie('DASHMYTASK', '1', 365, DOMAIN_COOKIE);
//        window.location = HTTP_ROOT + 'dashboard#tasks';
//    }
//    function myoverdue() {
//        createCookie('DASHMYTASK', '1', 365, DOMAIN_COOKIE);
//        window.location = HTTP_ROOT + 'dashboard#tasks';
//    }
</script>