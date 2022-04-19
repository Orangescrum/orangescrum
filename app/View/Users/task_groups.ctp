<script type="text/javascript">
$(document).ready(function() {
  var wh=$(window).height() - 160; 
 $('.cmn_outer_page .page-banner').height(wh);
});
</script>
<div class="cmn_outer_page proj_mgnt_page outer_tskgp_page cmn_howitwk">
	<section class="page-banner">
		<div class="cmn_wrapper">
			<div class="col-md-6 baner_txt">
				<h1><strong>Task Groups</strong></h1>
				<h6>
					<strong>Orangescrum helps to accomplish a specific task in a project in collaboration with proper information sharing in proper control without any conflict.</strong> 
				</h6>
				<div class="dual_baner_btn">
					<a href="<?php echo HTTP_ROOT;?>signup/free" class="active" title="<?php echo SIGNUP_CTA_B; ?>"><?php echo SIGNUP_CTA_B; ?></a>
					<a href="https://calendly.com/priyankagarwal/15min" target="_blank" title="Request A Demo">Request A Demo</a>
				</div>
			</div>
			<div class="col-md-6 baner-image">
				<figure class="text-right">
					<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwt-tskgp1.png" alt="Gantt chart" title="Gantt chart" width="" height="" style="height:350px">
				</figure>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	<div class="feature">
		<section class="description">
			<div class="cmn_wrapper">
				<h2>OrangeScrum Task Groups for Better Productivity</h2>
				<div class="cmn_padt_40">
					<div class="steps_table dtbl">
						<div class="col-md-6 dtbl_cell cell_40">
							<h3>Group Tasks</h3>
							<p>
								Categorize and report project or task information in a variety of ways. Group tasks to view rolled-up summary in one place for identical tasks.
							</p>
							<a href="<?php echo HTTP_ROOT;?>signup/free" title="Try OrangeScrum" class="bdy_try_os_btn">Try OrangeScrum</a>
						</div>
						<div class="col-md-6 dtbl_cell cell_60">
							<figure class="text-right wow flipInX" data-wow-delay="0.5s">
								<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwt-tskgp2.png" alt="Group Tasks or Resources by Criterion" title="Group Tasks or Resources by Criterion" width="" height="">
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
						<h3>Drag and Drop Tasks to the Task Groups</h3>
						<p>
							Easily drag n drop tasks to preferred task groups for hassle free demarkation of tasks. Task groups makes it simple for your teams to review tasks and take swift actions.
						</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwt-tskgp3.png" alt="GDrag and Drop Tasks to the Task Groups" title="Drag and Drop Tasks to the Task Groups" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
	</div>
	<div class="explore-con" style="display:none">
		<div class="btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?>signup/free<?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
		<div class="btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works<?php echo $ablink; ?>">Or Explore Invoice &rarr;</a></div>
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
	if( $(window).scrollTop() > 130 && $(window).scrollTop() < 1430 ){
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
</script>