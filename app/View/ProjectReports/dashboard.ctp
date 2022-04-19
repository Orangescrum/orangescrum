<style type="text/css">
    .all_report_page .wrapper {
        padding-top: 105px
    }

    .all_report_page .report_type_hd {
        background: #fff;
        padding: 15px;
        font-size: 16px;
        color: #4D5D74;
        font-weight: 500;
        text-align: left;
        box-shadow: 0px 0px 5px #aaa;
        margin: 15px 0
    }

    .all_report_page .report_box {
        text-decoration: none;
        color: #808B9C;
        display: block;
        width: 100%;
        height: 285px;
        background: #F8F8F8;
        border-radius: 10px;
        box-shadow: 0px 0px 5px #aaa;
        position: relative
    }

    .all_report_page .report_box figure {
        width: 100%;
        height: 100px;
        text-align: center;
        position: relative;
    }

    .all_report_page .report_box figure img {
        max-width: 100%;
        display: inline-block;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
    }

    .all_report_page .report_box h5 {
        font-size: 15px;
        line-height: 30px;
        color: #485d7b;
        font-weight: 600;
        margin: 10px 0;
        padding: 0;
    }

    .all_report_page .report_box .box_bg_ft {
        background: #fff;
        padding: 15px 15px 0px 15px;
        width: 100%;
        border-radius: 10px 10px 0px 0px;
    }

    .all_report_page .height_30_cb {
        height: 30px;
        clear: both
    }

    .all_report_page .report_box p,
    .detl_chart_page {
        font-size: 14px;
        line-height: 20px;
        color: #808B9C;
        margin: 0;
        padding: 0px 15px 10px
    }

    .all_report_page .ui-accordion .ui-accordion-content-active {
        height: auto !important;
    }

    .all_report_page .ui-widget-content {
        border: none !important;
        background: transparent;
    }
		.beta-release {border-radius:10px;border:1px solid #DFDFDF;background:#1A73E8;color:#fff;padding:2px 10px;font-weight: normal;font-size:11px;position:relative;top:-4px;}
</style>

<div class="all_report_page">
    <div class="report_container" id="accordion-1">
        <div class="report_type_hd">
            <?php echo __('Task Analysis Reports'); ?>
        </div>
        <div class="row">
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Average Age Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/average_age_report"
                    class="report_box" title="Average Age Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Average Age Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Task-Analysis-Report.png"
                                alt="<?php echo __('Average Age Report');?>" />
                        </figure>
                        <h5><?php echo __('Average Age Report');?>
                        </h5>
                    </div>
                    <p><?php echo __('Project wise average age of all open tasks at a glance to keep your backlog in control.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Resolution Time Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/resolution_time_report"
                    class="report_box" title="Resolution Time Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Resolution Time Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Resolution-Time-Report.png"
                                alt="<?php echo __('Resolution Time Report');?>" />
                        </figure>
                        <h5><?php echo __('Resolution Time Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('Time taken to resolve tasks of a project. Clear indication of how close or far is your planned vs actual closure date.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Recently Created Tasks Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/recent_created_task_report"
                    class="report_box" title="Recently Created Tasks Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Recently Created Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Recently-Created-tasks-Report.png"
                                alt="<?php echo __('Recently Created Tasks Report');?>" />
                        </figure>
                        <h5><?php echo __('Recently Created Tasks Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('Time bound trend of your incoming task flow for better planning & execution.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <div class="height_30_cb"></div>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Created vs Resolved Tasks Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/create_resolve_report"
                    class="report_box" title="Created vs. Resolved Tasks Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Created vs. Resolved Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Created-vs-Resolved-task-Reports.png"
                                alt="<?php echo __('Created vs. Resolved Tasks Report');?>" />
                        </figure>
                        <h5><?php echo __('Created vs. Resolved Tasks Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('Created tasks versus resolved tasks over a specified period to check progress of your backlog.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Task Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>task-report/"
                    class="report_box" title="Task Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Task Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Task-Report.png"
                                alt="<?php echo __('Task Report');?>" />
                        </figure>
                        <h5><?php echo __('Task Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('This shows Avg time to Resolve or close a task, number of task types created and task trends over a period of time. This helps you to understand how you can optimize your time spent on a task.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Time Since Task Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/time_since_report"
                    class="report_box" title="Time Since Tasks Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Time Since Tasks Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Time-Since-Task-Reports.png"
                                alt="<?php echo __('Time Since Tasks Report');?>" />
                        </figure>
                        <h5><?php echo __('Time Since Tasks Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('Track task trends based on no. of tasks created, worked upon, completed over specific period(s)');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <div class="height_30_cb"></div>
        </div>
        <div class="report_type_hd">
            <?php echo __('Time & Resource Reports'); ?>
        </div>
        <div class="row">            
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Hour Spent Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>hours-report/"
                    class="report_box" title="Hous Spent Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Hour Spent Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Hous-Spent-Report.png"
                                alt="<?php echo __('Hour Spent Report');?>" />
                        </figure>
                        <h5><?php echo __('Hour Spent Report');?>
                        </h5>
                    </div>
                    <p> <?php echo __('Quickly see the Burn-down chart for your time and effort spent, Time spent by Task Types and detailed count of hours spent, tasks closed and tasks replied by All resources of the chosen project.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <div class="height_30_cb"></div>						
        </div>
        <div class="report_type_hd">
            <?php echo __('Others');?>
        </div>
        <div class="row">
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Weekly Usage', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>reports/weeklyusage_report"
                    class="report_box" title="Weekly Usage"
                    onclick="return trackEventLeadTracker('Report Dashboard','Weekly Usage','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Weekly-Usage.png"
                                alt="<?php echo __('Weekly Usage');?>" />
                        </figure>
                        <h5><?php echo __('Weekly Usage');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __("A quick glance of your week's progress and performance w.r.t to the previous week.# of tasks created/closed, spent hours, project status and a summary report.");?>
                    </p>
                </a>
            </div>
            <?php } ?>
            <?php if (SES_TYPE < 3 || $this->Format->isAllowed('View Pie Chart Report', $roleAccess)) { ?>
            <div class="col-md-4">
                <a href="<?php echo HTTP_ROOT ?>project_reports/pie_chart_report"
                    class="report_box" title="Pie Chart Report"
                    onclick="return trackEventLeadTracker('Report Dashboard','Pie Chart Report','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/reports/Pie-Chart-Reports.png"
                                alt="<?php echo __('Pie Chart Report');?>" />
                        </figure>
                        <h5><?php echo __('Pie Chart Report');?>
                        </h5>
                    </div>
                    <p>
                        <?php echo __('Pie chart of tasks for a project grouped by specific field as needed. Handy overview of your task spread over status, assignee, type etc.');?>
                    </p>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#accordion-1").accordion().removeClass(
            ' ui-accordion-content ,ui-helper-reset ,ui-widget-content ,ui-corner-bottom ,ui-accordion-content-active'
        );
    });
    $(function() {
        if (localStorage.getItem("tour_type") == '4') {
            if ($.trim(LANG_PREFIX) != '') {
                GBl_tour = onbd_tour_tandresrc + LANG_PREFIX;
            } else {
                GBl_tour = onbd_tour_tandresrc;
            }
            //hopscotch.endTour();					
            hopscotch.startTour(GBl_tour, hopscotch.getCurrStepNum());
        }
    });
</script>