<style type="text/css">
	.scroll_fix_header ul li.kv_active a{color: #555;background:#fff;}
	.scroll_fix_header ul li.kv_active a .hrz_line::before {opacity:1;}
	.bnr_video{width:100%;height:400px;position:relative;padding:15px 0px 15px 15px}
</style>
<script type="text/javascript">
$(document).ready(function() {
  var wh=$(window).height() - 160; 
 $('.cmn_outer_page .page-banner').height(wh);
});
</script>
<div class="cmn_outer_page proj_mgnt_page outer_kanban_page cmn_howitwk">
	<section class="page-banner">
		<div class="cmn_wrapper">
			<div class="col-md-6 baner_txt">
				<h1><strong>Kanban View</strong></h1>
				<h6>
					<strong>Analyse and get clear picture of the entire project on what has been done, what needs to be done and what is in progress.</strong>
				</h6>
				<div class="dual_baner_btn">
					<a href="<?php echo HTTP_ROOT;?><?php echo SIGNUP_CTA_LINK; ?>" class="active" title="<?php echo SIGNUP_CTA_B; ?>"><?php echo SIGNUP_CTA_B; ?></a>
					<a href="<?php echo HTTP_ROOT;?>schedule-a-demo" target="_blank" title="Request A Demo">Request A Demo</a>
				</div>
			</div>
			<div class="col-md-6 baner-image">
				<div class="bnr_video">
					<!--<a id="play-video" href="#"></a>-->
					<figure class="text-right wow flipInX play_video_img" data-wow-delay="0.5s" data-toggle="modal" data-target="#video_modal">
						<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/Kanban-video.png" alt="Kanban video" title="Kanban video" width="" height="">
					</figure>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	<div class="feature">
		<section class="description">
			<div class="cmn_wrapper">
				<h2>Track what is done, doing and to be done at the same time</h2>
				<div class="cmn_padt_40">
					<div class="steps_table dtbl">
						<div class="col-md-6 dtbl_cell cell_40">
							<h3>Conversation Threads</h3>
							<p>
								See what other team members are working on and gaze project progress at a glance. Plan your activities and update information - all at one view.
							</p>
						</div>
						<div class="col-md-6 dtbl_cell cell_60">
							<figure class="text-right wow flipInX" data-wow-delay="0.5s">
								<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwtknban2.png" alt="Conversation Threads" title="Conversation Threads" width="" height="">
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
						<h3>Collaborate in Real-Time</h3>
						<p>
							As soon as any of your team makes a change to the OrangeScrum’s Kanban Board, the change immediately gets reflected to everyone those who are part of the Project or task.
						</p>
						<a href="<?php echo HTTP_ROOT;?><?php echo SIGNUP_CTA_LINK; ?>" title="Try OrangeScrum" class="bdy_try_os_btn">Try OrangeScrum</a>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwtknban3.png" alt="Collaborate in Real-Time" title="Collaborate in Real-Time" width="" height="">
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
						<h3>Speed up your process</h3>
						<p>
							Get things done quickly. Add, delete, move or reorder your tasks in real-time with immediate transparency.<br/><br/>Get approvals and reviews instantly - no more delays.
						</p>
						<a href="<?php echo HTTP_ROOT;?>schedule-a-demo" target="_blank" title="Request A Demo" class="bdy_rqst_demo_btn">Request A Demo</a>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwtknban4.png" alt="Speed up your process" title="Speed up your process" width="" height="">
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
						<h3>Drag and Drop</h3>
						<p>
							Drag "n" drop tasks to different task groups or task status painlessly. Save time from tedious work processes.
						</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/hwtknban5.png" alt="Drag and Drop" title="Drag and Drop" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
	</div>
	<div class="explore-con" style="display:none">
		<div class="btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?><?php echo SIGNUP_CTA_LINK; ?><?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
		<div class="btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works<?php echo $ablink; ?>">Or Explore Invoice &rarr;</a></div>
	</div>
	<!-- Video Modal -->
	<div id="video_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="modal-content">
			  <div class="modal-body">
				<iframe id="baner_video_frame" width="100%" height="100%" src="" frameborder="0"  allowfullscreen></iframe>
			  </div>
			</div>
		</div>
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
	/*--------Video popup stop when close---------*/
	$('.play_video_img').click(function() {
		$('#video_modal').show();
		$('.modal-body iframe').attr('src','https://www.youtube.com/embed/eCjYUKAH8Hc?rel=0&amp;autoplay=1');
	});
	$('#video_modal .close').click(function() {
		$('#video_modal').hide();
		$('.modal-body iframe').attr('src','');
	});
});
</script>