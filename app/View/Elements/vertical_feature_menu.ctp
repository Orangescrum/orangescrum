<style type="text/css">
	.horizontal_feature_menu{width: 100%;position:fixed;top:0;left:0;background: #f5f6f7;pointer-events: none;opacity:0;z-index:0;transition:all 0.5s ease-in-out;-webkit-transition:all 0.5s ease-in-out;-moz-transition:all 0.5s ease-in-out}
  .sticky .horizontal_feature_menu{opacity:1;z-index:11;pointer-events: auto}
	.horizontal_feature_menu .wrapper{width:100%;max-width:1170px;margin:0 auto;padding:0 60px;}
	.horizontal_feature_menu .bx-wrapper .bx-viewport{border:none;left:0;    -moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none;background:transparent}
	.horizontal_feature_menu .item a{display:flex;text-decoration:none;color:#fff;padding:0px 0px 0px 15px;position:relative;text-align: left;height:60px;
    align-items: center;flex-direction: row;}
	.horizontal_feature_menu .item a:before {content: '';
    width: 3px;height:18px;position: absolute;display: inline-block;top: 0;
    left: 0;bottom: 0;margin: auto;}
	.horizontal_feature_menu .bgbar_1 a:before{background:#ef4848}
	.horizontal_feature_menu .bgbar_2 a:before{background:#f8dd29}
	.horizontal_feature_menu .bgbar_3 a:before{background:#3dba72}
	.horizontal_feature_menu .bgbar_4 a:before{background:#f28b1d}
	.horizontal_feature_menu .bgbar_5 a:before{background:#f4b8fb}
	.horizontal_feature_menu .bgbar_6 a:before{background:#f0cc9d}
	.horizontal_feature_menu .bgbar_1.currnt-pg a strong,
	.horizontal_feature_menu .bgbar_1:hover a strong{color:#fd8888}
	.horizontal_feature_menu .bgbar_1.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_1 a:hover:before{background: #ef4848;}
	.horizontal_feature_menu .bgbar_2.currnt-pg a a strong,
	.horizontal_feature_menu .bgbar_2:hover a strong{color:#f8dd29}
	.horizontal_feature_menu .bgbar_2.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_2 a:hover:before{background: #f8dd29;}
	.horizontal_feature_menu .bgbar_3.currnt-pg a strong,
	.horizontal_feature_menu .bgbar_3:hover a strong{color:#3dba72}
	.horizontal_feature_menu .bgbar_3.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_3 a:hover:before{background: #3dba72;}
	.horizontal_feature_menu .bgbar_4.currnt-pg a strong,
	.horizontal_feature_menu .bgbar_4:hover a strong{color:#f28b1d}
	.horizontal_feature_menu .bgbar_4.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_4 a:hover:before{background: #f28b1d;}
	.horizontal_feature_menu .bgbar_5.currnt-pg a strong,
	.horizontal_feature_menu .bgbar_5:hover a strong{color:#f4b8fb}
	.horizontal_feature_menu .bgbar_5.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_5 a:hover:before{background: #f4b8fb;}
	.horizontal_feature_menu .bgbar_6.currnt-pg a strong,
	.horizontal_feature_menu .bgbar_6:hover a strong{color:#f0cc9d}
	.horizontal_feature_menu .bgbar_6.currnt-pg a:before,
	.horizontal_feature_menu .bgbar_6 a:hover:before{background: #f0cc9d;}
	.horizontal_feature_menu .item strong{display:inline-block;font-size:13px;line-height:20px;font-weight: 500;color: #000;opacity: 1;letter-spacing: 1.5px;position:relative}
	.horizontal_feature_menu .item small{display:block;font-size:12px;line-height:18px;}
	.horizontal_feature_menu .item .new {display: inline-block;
    position: absolute;right: -10px;top: -15px;font-size: 11px;
    color: #ff0000;font-weight: 600;animation: blinker 1s linear infinite;
    -webkit-animation: blinker 1s linear infinite;-moz-animation: blinker 1s linear infinite;}
	.horizontal_feature_menu .owl-controls{margin:0}
	.horizontal_feature_menu .owl-theme .owl-controls .owl-buttons .owl-prev{background: url(../../img/home/feature-nav-arrow.png) no-repeat 0px 0px;width: 12px;height: 22px;background-size: 10px 40px;z-index: 999;position: absolute;top:24px;left: -60px;font-size: 0px;display: block;opacity:1;margin:0}
	.horizontal_feature_menu .owl-theme .owl-controls .owl-buttons .owl-next{background: url(../../img/home/feature-nav-arrow.png) no-repeat 0px -28px;width: 12px;height:22px;background-size: 12px 50px;z-index: 999;position: absolute;top:20px;right: -60px;font-size: 0px;display: block;opacity:1;margin:0}
	.horizontal_feature_menu .owl-carousel .owl-item{width: auto !important;}
	.horizontal_feature_menu .bx-controls-direction .owl-prev:hover,
	.horizontal_feature_menu .bx-controls-direction .owl-next:hover{opacity:1}
</style> 
 
<div class="horizontal_feature_menu">
	<div class="wrapper">
		<div class="feature_nav_slider owl-theme">
			<div class="bgbar_1 item <?php if(PAGE_NAME == 'resource_utlization'){ ?>currnt-pg<?php } ?>" style="width:200px">
				<a href="<?php echo HTTPS_HOME; ?>resource-management" title="Resource Management" onclick="return setFeatureClik('resrcavl');">
				  <span class="header_sp resource_avail"></span>
				  <strong>Resource Management</strong>
				</a>
			</div>
			<div class="bgbar_2 item <?php if(PAGE_NAME == 'time_tracking'){ ?>currnt-pg<?php } ?>" style="width:135px">
				<a href="<?php echo HTTPS_HOME; ?>time-tracking" title="Time Tracking" onclick="return setFeatureClik('time');">
				  <span class="header_sp time_track"></span>
				  <strong>Time Tracking</strong>
				</a>
			</div>
			<div class="bgbar_3 item <?php if(PAGE_NAME == 'agile_pm'){ ?>currnt-pg<?php } ?>" style="width:225px">
				<a href="<?php echo HTTPS_HOME; ?>agile-project-management" title="Agile Project Management" onclick="return setFeatureClik('agile');">
				  <span class="header_sp agile_pm"></span>
				  <strong>Agile Project Management</strong>
				</a>
			</div>
			<div class="bgbar_4 item <?php if(PAGE_NAME == 'task_management'){ ?>currnt-pg<?php } ?>" style="width:165px">
				<a href="<?php echo HTTP_ROOT;?>task-management" title="Task Management" onclick="return setFeatureClik('tskmgt');">
				  <span class="header_sp tsk_mgnt"></span>
				  <strong>Task Management</strong>
				</a>
			</div>
			<div class="bgbar_5 item <?php if(PAGE_NAME == 'kanban_view'){ ?>currnt-pg<?php } ?>" style="width:125px">
				<a href="<?php echo HTTPS_HOME; ?>kanban-view" title="Kanban View" onclick="return setFeatureClik('kanban');">
				  <span class="header_sp kanban"></span>
				  <strong>Kanban View</strong>
				</a>
			</div>
			<div class="bgbar_6 item <?php if(PAGE_NAME == 'user_role_management'){ ?>currnt-pg<?php } ?>" style="width:208px">
				<a href="<?php echo HTTPS_HOME; ?>user-role-management" title="User Role Management" onclick="return setFeatureClik('user_mgt');">
				  <span class="header_sp user_role"></span>
				  <strong>User Role Management </strong>
				</a>
			</div>
			<div class="bgbar_1 item <?php if(PAGE_NAME == 'invoice_how_it_works'){ ?>currnt-pg<?php } ?>" style="width:85px">
				<a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works" title="Invoice" onclick="return setFeatureClik('invoice');">
				  <span class="header_sp invoice"></span>
				  <strong>Invoice</strong>
				</a>
			</div>
			<div class="bgbar_2 item <?php if(PAGE_NAME == 'gcalendar_integration'){ ?>currnt-pg<?php } ?>" style="width:160px">
				<a href="<?php echo HTTPS_HOME; ?>google-calendar-integration" title="Google Calendar" onclick="return setFeatureClik('gcalendar');">
				  <span class="header_sp gcalendar"></span>
				  <strong>Google Calendar <!--<span class="new">New</span>--></strong>
				</a>
			</div>
			<div class="bgbar_3 item <?php if(PAGE_NAME == 'mobile_app'){ ?>currnt-pg<?php } ?>" style="width:120px">
				<a href="<?php echo HTTPS_HOME; ?>mobile-app" title="Mobile App" onclick="return setFeatureClik('mobile');">
				  <span class="header_sp mobileapp"></span>
				  <strong>Mobile App</strong>
				</a>
			</div>
			<div class="bgbar_4 item <?php if(PAGE_NAME == 'gantt_chart'){ ?>currnt-pg<?php } ?>" style="width:124px">
				<a href="<?php echo HTTPS_HOME; ?>gantt-chart" title="Gantt Chart" onclick="return setFeatureClik('gantt');">
				  <span class="header_sp gantt_chart"></span>
				  <strong>Gantt Chart</strong>
				</a>
			</div>
			<div class="bgbar_5 item <?php if(PAGE_NAME == 'custom_status_workflow'){ ?>currnt-pg<?php } ?>">
				<a href="<?php echo HTTPS_HOME; ?>custom-status-workflow" title="Custom Task Status" onclick="return setFeatureClik('customstatus');">
				  <span class="header_sp kanban"></span>
				  <strong>Custom Task Status</strong>
				</a>
			</div>
		</div>
	</div>
</div> 
 
 
<?php /*<div class="vertical_feature_menu">
    <ul>
      <li class="<?php if(PAGE_NAME == 'task_management'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTP_ROOT;?>task-management" title="Task Management" onclick="return setFeatureClik('tskmgt');">
          <span class="header_sp tsk_mgnt"></span>
          <strong>Task Management</strong>
          <small>Assign, Manage And Evaluate Progress of All Your Tasks</small>
        </a>
      </li>
	  <li class="<?php if(PAGE_NAME == 'resource_utlization'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>resource-management" title="Resource Management" onclick="return setFeatureClik('resrcavl');">
          <span class="header_sp resource_avail"></span>
          <strong>Resource Management</strong>
           <small>Know team's availability for efficient project planning</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'time_tracking'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>time-tracking" title="Time Tracking" onclick="return setFeatureClik('time');">
          <span class="header_sp time_track"></span>
          <strong>Time Tracking</strong>
          <small>Automated Timer & Timesheet to track time</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'gantt_chart'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>gantt-chart" title="Gantt Chart" onclick="return setFeatureClik('gantt');">
          <span class="header_sp gantt_chart"></span>
          <strong>Gantt Chart</strong>
          <small>Visual project planning with simplified scheduling</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'kanban_view'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>kanban-view" title="Kanban View" onclick="return setFeatureClik('kanban');">
          <span class="header_sp kanban"></span>
          <strong>Kanban View</strong>
           <small>Review all tasks progress in a single kanban board</small>
        </a>
      </li>
    </ul>
    <ul class="more_fetures" id="more_fetures">
      <li class="<?php if(PAGE_NAME == 'user_role_management'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>user-role-management" title="User Role Management" onclick="return setFeatureClik('user_mgt');">
          <span class="header_sp user_role"></span>
          <strong>User Role Management </strong>
          <small>Role based access control <br/>for users </small>
          <!--<span class="new">New</span>-->
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'agile_pm'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>agile-project-management" title="Agile Project Management" onclick="return setFeatureClik('agile');">
          <span class="header_sp agile_pm"></span>
          <strong>Agile Project Management</strong>
           <small>Plan, Track and Release projects with agility</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'invoice_how_it_works'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works" title="Invoice" onclick="return setFeatureClik('invoice');">
          <span class="header_sp invoice"></span>
          <strong>Invoice</strong>
           <small>Accurate and transparent invoicing for your customers</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'mobile_app'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>mobile-app" title="Mobile App" onclick="return setFeatureClik('mobile');">
          <span class="header_sp mobileapp"></span>
          <strong>Mobile App</strong>
          <small>Stay connected with team and customers on the go</small>
        </a>
      </li>
      <li class="<?php if(PAGE_NAME == 'gcalendar_integration'){ ?>currnt-pg<?php } ?>">
        <a href="<?php echo HTTPS_HOME; ?>google-calendar-integration" title="Google Calendar" onclick="return setFeatureClik('gcalendar');">
          <span class="header_sp gcalendar"></span>
          <strong>Google Calendar</strong>
          <small>Stay updated on your Orangescrum tasks with a 2-way sync with Google Calendar</small>
          <span class="new">New</span>
        </a>
      </li>
    </ul>
    <div class="more_less"><a class="mrs_btn" href="javascript:void(0)">More</a>&nbsp;...</div>   
  </div> */?>
<script type="text/javascript">
  $(document).ready(function(){
	$(".feature_nav_slider").owlCarousel({
    items:6,
	loop:true,
    autoWidth:true,
	navigation: true,
    //itemsDesktop:[1000,3],
    //itemsDesktopSmall:[979,2],
    //itemsTablet:[768,1],
    pagination:false,
    transitionStyle:"fade",
	mouseDrag:false,
	touchDrag:false,
	pullDrag:false,
    autoPlay:false,
	
	});

	$(window).scroll(function () {
	  if($(window).scrollTop() > 680) {
		  //console.log($(window).scrollTop());
		$(".cmn_feature_page").addClass('sticky');
		//$(".horizontal_feature_menu").addClass('sticky');
	  } else {
		$(".cmn_feature_page").removeClass('sticky');
		//$(".horizontal_feature_menu").removeClass('sticky');
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