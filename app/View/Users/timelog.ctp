<script type="text/javascript">
function showVideo(){
		$(".video_button").hide();
		$("#video2").animate({width:"100%",height:"361px"});
		$("#v_con").animate({top:"0px"});
		$("#video2_inner").fadeIn();
		$("#mover").animate({margin:"0px"});
		$("#video2_inner").html("<iframe class='iframer' src='//www.youtube.com/embed/4qCaP0TZuxU?rel=0&autoplay=1' width='100%' height='100%' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>");
		expand=true;
}
</script>
<script type="text/javascript">
function txt_foc(obj,val){
	if($(obj).val() == val){
		$(obj).val('');
		$(obj).removeClass('placeholder_col').addClass('inact_placeholder_col');
	}
}
function txt_blur(obj,val){
	if($(obj).val() == ''){
		$(obj).val(val).removeClass('inact_placeholder_col').addClass('placeholder_col');
	}
}
$(document).ready(function() {
  var wh=$(window).height() - 100; 
 $('.cmn_outer_page .page-banner').height(wh);
});
</script>
<style type="text/css">
	.cmn_outer_page h1{font-weight:700}
	.cmn_outer_page .slider-wh{margin-bottom:50px}
</style>
<link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/jquery.bxslider.css" type="text/css">
<script src="<?php echo HTTP_ROOT; ?>js/jquery.bxslider.min.js"></script>
<div class="cmn_outer_page proj_mgnt_page outer_timelog_page cmn_howitwk">
	<section class="page-banner">
		<div class="cmn_wrapper">
			<div class="col-md-6 baner_txt">
				<h1>Time Tracking</h1>
				<h6>
					<strong>Effortless Time Tracking That Works For Your Team</strong>
  					Automated | Simplified | Accurate | Efficient
				</h6>
				<div class="dual_baner_btn">
					<a href="<?php echo HTTP_ROOT;?>signup/free" class="active" title="<?php echo SIGNUP_CTA_B; ?>"><?php echo SIGNUP_CTA_B; ?></a>
					<a href="https://calendly.com/priyankagarwal/15min" target="_blank" title="Request A Demo">Request A Demo</a>
				</div>
			</div>
			<div class="col-md-6 baner-image">
				<figure class="text-right">
					<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner.png" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
				</figure>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	<div class="feature">
		<section class="description">
			<div class="cmn_wrapper">
				<h2>Time Tracking features that make your TEAMS tick!</h2>
				<div class="cmn_padt_40">
					<div class="steps_table dtbl">
						<div class="col-md-6 dtbl_cell cell_40">
							<h3>Save Time in NO Time</h3>
							<p>
								Time Tracking saves you time from tracking time.<br>
								Use the Timer and your task time is tracked automatically allowing you to focus on real work. 
								What else! Just enter your task notes upon completion and hit save. No Hassles!  No Distractions!
								Increased  <a href="<?php echo HTTP_ROOT;?>project-management" title="Productivity">Productivity!</a>
							</p>
						</div>
						<div class="col-md-6 dtbl_cell cell_60">
							<figure class="text-right wow flipInX" data-wow-delay="0.5s">
								<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/t-section-1.png" alt="Time Tracking Save Time in NO Time" title="Time Tracking Save Time in NO Time" width="" height="">
							</figure>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</section>
		<section class="bg_clr description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Charge your team's true worth!</h3>
						<p>
							Easily mark your billable and non-billable hours in a click. View your team's time spend in a single view and confidently generate accurate 
							<a href="<?php echo HTTP_ROOT;?>invoice-how-it-works" title="invoices">invoices</a> for your customers.
						</p>
						<a href="<?php echo HTTP_ROOT;?>signup/free" title="Try OrangeScrum" class="bdy_try_os_btn">Try OrangeScrum</a>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-1.png" alt="Time Tracking Charge your team’s true worth!" title="Time Tracking Charge your team’s true worth!" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Your Teams's day in a snapshot</h3>
						<p>
							Intuitive card view instantly tells you what your team has been up to for that day. You can easily see who worked on which  
							<a href="<?php echo HTTP_ROOT;?>task-groups" title="task">task</a> for how long for your entire team. And the more formal calendar view shows you all the tasks lined up for your team for the day.
						</p>
						<a href="https://calendly.com/priyankagarwal/15min" target="_blank" title="Request A Demo" class="bdy_rqst_demo_btn">Request A Demo</a>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner.png" alt="Your Teams's day in a snapshot" title="Your Teams's day in a snapshot" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="bg_clr description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Utilize your Resources to the Optimum</h3>
						<p>
							This over arching report gives you the true state of affairs. All your Who, What, When, Where are answered right here. No more hiding! Smart filters offer you the flexibility to review <a href="<?php echo HTTP_ROOT;?>project-management" title="resource utilization">resource utilization</a>  in greater detail its granular information on your projects, operations and delivery. No Blind Spots!
						</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/t-section-4.png" alt="Utilize your Resources to the Optimum" title="Utilize your Resources to the Optimum" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="screenshot_slide cmn_padtb_60">
			<div class="cmn_wrapper">
				<h2>Time Tracking Screenshots</h2>
				<p class="sub-hd">Take a look at the productivity features designed for you</p>
				<div class="slider-wh">
				<ul class="slack_screnshot_slider">
				  <li>
				  	<figure>
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-1.png" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
					</figure>
				  </li>
				  <li>
				  	<figure>
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-2.jpg" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
					</figure>
				  </li>
				  <li>
				  	<figure>
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-3.png" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
					</figure>
				  </li>
				  <li>
				  	<figure>
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-4.png" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
					</figure>
				  </li>
				  <li>
				  	<figure>
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Touter-banner-5.png" alt="Time Tracking Software" title="Time Tracking Software" width="" height="">
					</figure>
				  </li>
				</ul>
				</div>
			</div>
		</section>
	</div>
	<div class="explore-con" style="display:none">
		<div class="btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?>signup/free<?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
		<div class="btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>gantt-chart<?php echo $ablink; ?>">Or Explore Gantt chart &rarr;</a></div>
	</div>
</div>
<script type="text/javascript">
	var lastId,
		topMenu = $(".how"),
		topMenuHeight = $(".top_menu_land").outerHeight(),
		// All list items
		menuItems = topMenu.find("a"),
		// Anchors corresponding to menu items
		scrollItems = menuItems.map(function(){
		  var item = $($(this).attr("href"));
		  if (item.length) { return item; }
		});
	// Bind click handler to menu items
	// so we can get a fancy scroll animation
	menuItems.click(function(e){
	  var href = $(this).attr("href"),
		  offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
	  $('html, body').stop().animate({ 
		  scrollTop: offsetTop
	  }, 800);
	  e.preventDefault();
	});
$(window).scroll(function () {//alert("dfgd"); 
	//console.log($(window).scrollTop()+'---');
	if( $(window).scrollTop() > 130 && $(window).scrollTop() < 650){
		$("#to_top").css({display:"block"});
		$(".fixed_signup").animate({opacity: "show"}, "medium");

	}
	else{
		$("#to_top").css({display:"none"});
		$(".fixed_signup").css({display:"none"});
	}
});	
$("#to_top").click(function(){
	
	$('html, body').stop().animate({ 
		  scrollTop: 0
	  }, 800);
});

$(document).ready(function() {
    $('#mycarousel1').jcarousel({
		auto: 2,							
    	wrap: 'circular'
    });
    $('.slack_screnshot_slider').bxSlider({
    minSlides: 1,
  	captions: true,
    pager:true,
    auto: true,
    autoHover: true,
    autoControls: true
  });
  $('.learnmore').click(function() {
    var target = '.feature';
    var $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top-50
    }, 900, 'swing', function() {});
    });
});
</script>