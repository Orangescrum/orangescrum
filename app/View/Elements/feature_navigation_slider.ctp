<style type="text/css">
.outer_header .fixed-header .snow_header{background-color: #fff;}
.cmn_new_feature_page .navigate_feature_navbar{padding:30px 0px 160px;background: #f6f6f7;margin:0 0 30px}
.cmn_new_feature_page .navigate_feature_navbar::after {content: '';
    width: 100%;height: 34px; background: url(<?php echo HTTP_ROOT;?>img/wave-tap-border-bottom.svg) no-repeat 0px 0px;
    background-size: 100% auto;position: absolute;right: 0; bottom:-5px;}
	.cmn_new_feature_page .navigate_feature_navbar{box-shadow:none}
.cmn_new_feature_page .navigate_feature_navbar.sticky{position:fixed;top:68px;height:auto;margin:0;padding:0;background:#fff;box-shadow: 0px 0px 10px rgb(225 226 228 / 71%);z-index:9}
.cmn_new_feature_page .navigate_feature_navbar.sticky::before,
.cmn_new_feature_page .navigate_feature_navbar.sticky::after{display:none}


	.navigate_feature_menu .wrapper{width:100%;max-width:1170px;margin:0 auto;padding:0 60px;}
	.navigate_feature_menu .bx-wrapper .bx-viewport{border:none;left:0;    -moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none;background:transparent;padding: 0 20px;}
	.navigate_feature_menu .item{position:relative}
	.navigate_feature_menu .item a{display:inline-block;text-decoration:none;color:#fff;padding:0px ;position:relative;text-align: left;height:70px;line-height:70px;}
	.navigate_feature_menu .item a:before {content: '';
    width:calc(100% + 30px);width:-webkit-calc(100% + 30px);height:100%;position: absolute;display:block;top: 0;left:-15px;background:transparent}
	.navigate_feature_menu .item.currnt-pg a:before,.navigate_feature_menu .item a:hover::before{background:#00AAFF}
	.navigate_feature_menu .item.currnt-pg strong,
	.navigate_feature_menu .item.currnt-pg a:hover strong,
	.navigate_feature_menu .item a:hover strong{color:#fff;font-weight: 700;}
	/*.navigate_feature_menu .item a:hover strong{color:#00AAFF}
	.navigate_feature_menu .item.currnt-pg a:hover strong{color:#fff}*/


	
	.navigate_feature_menu .width_cstm{width:130px !important}
	.navigate_feature_menu .width_cstm_midle{width:150px !important}
	.navigate_feature_menu .width_cstm_small{width:110px !important}
	.navigate_feature_menu .width_cstm_125{width:125px !important}
	
	
	
	
	/*.navigate_feature_menu .bgbar_1 a:before{background:#ef4848}
	.navigate_feature_menu .bgbar_2 a:before{background:#f8dd29}
	.navigate_feature_menu .bgbar_3 a:before{background:#3dba72}
	.navigate_feature_menu .bgbar_4 a:before{background:#f28b1d}
	.navigate_feature_menu .bgbar_5 a:before{background:#f4b8fb}
	.navigate_feature_menu .bgbar_6 a:before{background:#f0cc9d}
	.navigate_feature_menu .bgbar_1.currnt-pg a strong,
	.navigate_feature_menu .bgbar_1:hover a strong{color:#fd8888;font-weight: 900;}
	.navigate_feature_menu .bgbar_1.currnt-pg a:before,
	.navigate_feature_menu .bgbar_1 a:hover:before{background: #ef4848;}
	.navigate_feature_menu .bgbar_2.currnt-pg a a strong,
	.navigate_feature_menu .bgbar_2:hover a strong{color:#f8dd29;font-weight: 900;}
	.navigate_feature_menu .bgbar_2.currnt-pg a:before,
	.navigate_feature_menu .bgbar_2 a:hover:before{background: #f8dd29;}
	.navigate_feature_menu .bgbar_3.currnt-pg a strong,
	.navigate_feature_menu .bgbar_3:hover a strong{color:#3dba72;font-weight: 900;}
	.navigate_feature_menu .bgbar_3.currnt-pg a:before,
	.navigate_feature_menu .bgbar_3 a:hover:before{background: #3dba72;}
	.navigate_feature_menu .bgbar_4.currnt-pg a strong,
	.navigate_feature_menu .bgbar_4:hover a strong{color:#f28b1d;font-weight: 900;}
	.navigate_feature_menu .bgbar_4.currnt-pg a:before,
	.navigate_feature_menu .bgbar_4 a:hover:before{background: #f28b1d;}
	.navigate_feature_menu .bgbar_5.currnt-pg a strong,
	.navigate_feature_menu .bgbar_5:hover a strong{color:#f4b8fb;font-weight: 900;}
	.navigate_feature_menu .bgbar_5.currnt-pg a:before,
	.navigate_feature_menu .bgbar_5 a:hover:before{background: #f4b8fb;}
	.navigate_feature_menu .bgbar_6.currnt-pg a strong,
	.navigate_feature_menu .bgbar_6:hover a strong{color:#f0cc9d;font-weight: 900;}
	.navigate_feature_menu .bgbar_6.currnt-pg a:before,
	.navigate_feature_menu .bgbar_6 a:hover:before{background: #f0cc9d;}*/
	.navigate_feature_menu .item strong{display:inline-block;font-size:15px;font-weight: 500;color: #3d474d;opacity: 1;position:relative}
	.navigate_feature_menu .item small{display:block;font-size:12px;line-height:18px;}
	.navigate_feature_menu .item .new {display: inline-block;
    position: absolute;right: -10px;top: -15px;font-size: 11px;
    color: #ff0000;font-weight: 600;animation: blinker 1s linear infinite;
    -webkit-animation: blinker 1s linear infinite;-moz-animation: blinker 1s linear infinite;}
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-prev{z-index:11;margin:0;top:0;left: -45px;bottom: 0;margin: auto;border-radius: 50%;
    background-color: #fff;
    box-shadow: 0 16px 24px -16px rgba(0,0,0,0.5), 0px 0px 24px rgba(0,0,0,0.1);}
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-next{z-index:11;margin:0;top:0;right: -45px;bottom: 0;margin: auto;border-radius: 50%;background-color: #fff;
    box-shadow: 0 16px 24px -16px rgba(0,0,0,0.5), 0px 0px 24px rgba(0,0,0,0.1);}
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-prev::before{-webkit-transform: rotate(225deg);-ms-transform: rotate(225deg);-o-transform: rotate(225deg);transform: rotate(225deg) rgb(159 161 162);width: 12px;height: 12px;border-right: 2px solid rgb(159 161 162);border-top: 2px solid rgb(159 161 162);content: '';display: block;line-height: 100px;position:absolute;left: 5px;right: 0;top: 0;bottom: 0;margin: auto;}
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-next::before{-webkit-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);width: 12px;height: 12px;border-right:2px solid rgb(159 161 162);border-top:2px solid rgb(159 161 162);content: '';display: block;line-height: 100px;position:absolute;left:0;right: 5px;top: 0;bottom: 0;margin: auto;}
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-prev:hover::before,
	.navigate_feature_menu .bx-wrapper .bx-controls-direction a.bx-next:hover::before{border-color:rgb(18,131,218)}
	
</style> 
 <section class="navigate_feature_navbar" id="fixnavigate">
	<div class="wrapper">
<div class="navigate_feature_menu">
	<ul class="navigate_feature_bxslider" style="display:none">
		<li class="bgbar_3 item <?php if(PAGE_NAME == 'agile_pm'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>agile-project-management" title="Agile Project Management" onclick="return setFeatureClik('agile');">
			  <span class="header_sp agile_pm"></span>
			  <strong>Agile Project Management</strong>
			</a>
		</li>
		<li class="width_cstm_midle bgbar_4 item <?php if(PAGE_NAME == 'task_management'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTP_ROOT;?>task-management" title="Task Management" onclick="return setFeatureClik('tskmgt');">
			  <span class="header_sp tsk_mgnt"></span>
			  <strong>Task Management</strong>
			</a>
		</li>
		<li class="width_cstm_small bgbar_5 item <?php if(PAGE_NAME == 'kanban_view'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>kanban-view" title="Kanban View" onclick="return setFeatureClik('kanban');">
			  <span class="header_sp kanban"></span>
			  <strong>Kanban View</strong>
			</a>
		</li>		
		<li class="width_cstm_small bgbar_2 item <?php if(PAGE_NAME == 'time_tracking'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>time-tracking" title="Time Tracking" onclick="return setFeatureClik('time');">
			  <span class="header_sp time_track"></span>
			  <strong>Time Tracking</strong>
			</a>
		</li>
		<li class="bgbar_1 item <?php if(PAGE_NAME == 'resource_utlization'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>resource-management" title="Resource Management" onclick="return setFeatureClik('resrcavl');">
			  <span class="header_sp resource_avail"></span>
			  <strong>Resource Management</strong>
			</a>
		</li>
		<li class="width_cstm_midle bgbar_6 item <?php if(PAGE_NAME == 'analytic_reports'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>project-reports-analytics" title="Reports & Analytics" onclick="return setFeatureClik('anly_rpt');">
			  <span class="header_sp user_role"></span>
			  <strong>Reports & Analytics</strong>
			</a>
		</li>
		<li class="width_cstm bgbar_6 item <?php if(PAGE_NAME == 'project_templates'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>project-template" title="Project Template" onclick="return setFeatureClik('proj_tmpl');">
			  <span class="header_sp user_role"></span>
			  <strong>Project Template</strong>
			</a>
		</li>
		<li class="width_cstm_midle bgbar_5 item <?php if(PAGE_NAME == 'custom_status_workflow'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>custom-status-workflow" title="Custom Task Status" onclick="return setFeatureClik('customstatus');">
			  <span class="header_sp kanban"></span>
			  <strong>Custom Task Status</strong>
			</a>
		</li>
		<li class="bgbar_6 item <?php if(PAGE_NAME == 'user_role_management'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>user-role-management" title="User Role Management" onclick="return setFeatureClik('user_mgt');">
			  <span class="header_sp user_role"></span>
			  <strong>User Role Management </strong>
			</a>
		</li>
		<li class="width_cstm_small bgbar_4 item <?php if(PAGE_NAME == 'gantt_chart'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>gantt-chart" title="Gantt Chart" onclick="return setFeatureClik('gantt');">
			  <span class="header_sp gantt_chart"></span>
			  <strong>Gantt Chart</strong>
			</a>
		</li>
		<li class="width_cstm bgbar_4 item <?php if(PAGE_NAME == 'slack_integration'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>slack-integration" title="Slack Integration" onclick="return setFeatureClik('gantt');">
			  <span class="header_sp gantt_chart"></span>
			  <strong>Slack Integration</strong>
			</a>
		</li>
		<li class="width_cstm bgbar_2 item <?php if(PAGE_NAME == 'gcalendar_integration'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>google-calendar-integration" title="Google Calendar" onclick="return setFeatureClik('gcalendar');">
			  <span class="header_sp gcalendar"></span>
			  <strong>Google Calendar <!--<span class="new">New</span>--></strong>
			</a>
		</li>
		<li class="width_cstm_small bgbar_3 item <?php if(PAGE_NAME == 'mobile_app'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>mobile-app" title="Mobile App" onclick="return setFeatureClik('mobile');">
			  <span class="header_sp mobileapp"></span>
			  <strong>Mobile App</strong>
			</a>
		</li>
		<li class="width_cstm_small bgbar_3 item <?php if(PAGE_NAME == 'task_groups'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>task-groups" title="Task Groups" onclick="return setFeatureClik('taskgroups');">
			  <span class="header_sp mobileapp"></span>
			  <strong>Task Groups</strong>
			</a>
		</li>
		<li class="width_cstm_125 bgbar_3 item <?php if(PAGE_NAME == 'catch_up'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>catch-up" title="Daily Catch Up" onclick="return setFeatureClik('catchup');">
			  <span class="header_sp mobileapp"></span>
			  <strong>Daily Catch Up</strong>
			</a>
		</li>
		<li class="width_cstm_small bgbar_1 item <?php if(PAGE_NAME == 'invoice_how_it_works'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works" title="Invoice" onclick="return setFeatureClik('invoice');">
			  <span class="header_sp invoice"></span>
			  <strong>Invoice</strong>
			</a>
		</li>
    <li class="width_cstm_small bgbar_1 item <?php if(PAGE_NAME == 'mention'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>mention" title="@Mention" onclick="return setFeatureClik('mention');">
			  <span class="header_sp invoice"></span>
			  <strong>@Mention</strong>
			</a>
		</li>
    <li class="width_cstm_small bgbar_1 item <?php if(PAGE_NAME == 'about_timesheet'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>timesheet" title="Timesheet" onclick="return setFeatureClik('timesheet');">
			  <span class="header_sp invoice"></span>
			  <strong>Timesheet</strong>
			</a>
		</li>
    <li class="width_cstm_midle item <?php if(PAGE_NAME == 'work_management'){ ?>currnt-pg<?php } ?>">
			<a href="<?php echo HTTPS_HOME; ?>work-management" title="Work Management" onclick="return setFeatureClik('workmgmt');">
			  <span class="header_sp invoice"></span>
			  <strong>Work Management</strong>
			</a>
		</li>
	</ul>
</div> 
</div> 
</section> 
<script type="text/javascript">
var opt_slider;
var page_index_obj = {
    "agile_pm": 0,
    "task_management": 1,
    "kanban_view": 2,
    "time_tracking": 3,
    "resource_utlization": 4,
    "analytic_reports": 5,
    "project_templates": 6,
    "custom_status_workflow": 7,
    "user_role_management": 8,
    "gantt_chart": 9,
    "slack_integration": 10,
    "gcalendar_integration": 11,
    "mobile_app": 12,
    "task_groups": 13,
    "catch_up": 14,
    "invoice_how_it_works": 15,
    "mention": 16,
    "about_timesheet": 17,
    "work_management": 18,
};
 $(document).ready(function() {
    opt_slider = $('.navigate_feature_bxslider').show().bxSlider({
        minSlides: 1,
        maxSlides: 9,
        moveSlides: 1,
        auto: false,
        mode: 'horizontal',
        captions: false,
        slideWidth: 190,
        slideMargin: 30,
        responsive: true,
        useCSS: true,
        pager: false,
        controls: true,
        speed: 500
    });
    opt_slider.goToSlide(page_index_obj[PAGE_NM]);
    /*var fixmeTop = $('#fixnavigate').offset().top;
    $(window).scroll(function() {
        var currentScroll = $(window).scrollTop() + 70;
        if (currentScroll >= fixmeTop) {
            $('#fixnavigate').css({
                position: 'fixed',
                top: '68px',
                left: '0'
            });
        } else {
            $('#fixnavigate').css({
                position: 'static'
            });
        }
    });*/

    $(window).scroll(function () {
     if($(window).scrollTop() > 1300) {
      //console.log($(window).scrollTop());
        $(".navigate_feature_navbar").addClass('sticky');
        } else {
        $(".navigate_feature_navbar").removeClass('sticky');
      }
    });
    /*$('.mrs_btn').off().on('click',function() {
      $('.more_fetures').slideToggle(function() {
		  if($(this).is(":hidden")) {
			$('.tgle_pading').css('padding-left','0px');
		  }else{
			  $('.tgle_pading').css('padding-left','330px');
		  }
		});
      if ($.trim($(this).text()) == "More") {
        $(this).text("Less")
      } else {
        $(this).text("More")
      }
    });*/

});

</script>