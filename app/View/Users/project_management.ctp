<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>css/bootstrap.min.css"/>
<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function showVideo(){
		//$(".try").animate({top:"40px"})
		$(".video_button").hide();
		$("#video2").animate({width:"100%",height:"361px"});
		//$('html, body').stop().animate({scrollTop: 420}, 800);
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
	var wh=$(window).height() - 220; 
	$('.proj_mgnt_page .page-banner').height(wh);
	$('.testimonial_slider').bxSlider({
		slideWidth:900,
		minSlides: 1,
		pager:true,
		auto: true,
		autoControls: true
	});
	$('.learnmore').click(function() {
    var target = '.feature';
    var $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top - 140
    }, 900, 'swing', function() {});
    });
});

</script>
<div class="cmn_outer_page proj_mgnt_page cmn_howitwk">
	<section class="page-banner">
		<div class="cmn_wrapper">
			<div class="col-md-6 baner_txt">
				<h1><strong>Project Management</strong></h1>
				<h6>
					<strong>Successful Project Completion on time, <br/>on budget!</strong>
				</h6>
				<div class="dual_baner_btn">
					<a href="<?php echo HTTP_ROOT;?>signup/free" class="active" title="<?php echo SIGNUP_CTA_B; ?>"><?php echo SIGNUP_CTA_B; ?></a>
					<a href="https://calendly.com/priyankagarwal/15min" target="_blank" title="Request A Demo">Request A Demo</a>
				</div>
			</div>
			<div class="col-md-6 baner-image">
				<figure class="text-right">
					<img src="<?php echo HTTP_ROOT ;?>img/home_outer/how-it-works/pm-bnr-topimg.png" alt="Timelog" title="Timelog" width="" height="">
				</figure>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	<section class="get_start_forfree" style="display:none">
		<div class="cmn_wrapper">
			<div class="cmn_padt_40">
			<div class="d_tble">
				<div class="d_tble_cell">
					<h2>Get started for free</h2>
					<p>Great solutions need Greater Collaboration!</p>
				</div>
				<div class="d_tble_cell">
					<a href="javascript:void(0)" onclick="regularsignup();" title="Try Orangescrum Project Management" class="join_btn">Try&nbsp;&nbsp;it&nbsp;&nbsp;Now<span class="glyphicon glyphicon-send"></span></a>
				</div>
			</div>
			</div>
		</div>
	</section>
	<section class="collaborate_role">
		<div class="cmn_wrapper">
			<h2>Numerous Projects? Dispersed Teams? Broken Communications? Ever-demanding Clients?<br> No Problem! Orangescrum solves it ALL!</h2>
			<!--<h2>OrangeScrum helps to collaborate people with different roles and responsibilities <br>amid varied objectives towards one single goal</h2>-->
			<div class="cmn_padt_40">
			<figure class="wow bounceInUp" data-wow-delay="0.2s">
				<img src="<?php echo HTTP_ROOT?>img/home/p-collaborate.png" alt="Orangescrum Project Management Tool" title="Orangescrum Project Management Tool" width="" height="">
			</figure>
			</div>
		</div>
	</section>
	<div class="feature">
		<section class="bg_clr description">
			<div class="cmn_wrapper">
				<h2>
					Plan, Initiate, Track and Control all your projects'  action with absolute ease anytime in one place! <br>Everything you need to handle even "THE PERFECT STORM"
				</h2>
				<div class="cmn_padt_40">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home/Project-management-planning.png" alt="Project Planning" title="Project Planning" width="" height="">
						</figure>
					</div>
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Project Planning</h3>
						<p>
							Failing to Plan is Planning to Fail! Orangescrum helps you lay out your projects into the minutest of tasks making you Invincible. Never again do you have to worry about missing key client requirements & instructions. Intuitive <span>Kanban boards</span> with <span>Task Groups</span> is made for quick project plan with well-defined task groupings and task statuses. Keep your Teams and Client in-sync. Transparency Simplified!
						</p>
						<a href="<?php echo HTTP_ROOT;?>signup/free" title="Try OrangeScrum" class="bdy_try_os_btn">Try OrangeScrum</a>
					</div>
					<div class="clearfix"></div>
				</div>
				</div>
			</div>
		</section>
		
		<section class="description">
			<div class="cmn_wrapper">
				<!--<h2>OrangeScrum: Project Management Made Easy</h2>-->
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Sprint Planning Made Easy</h3>
						<p>
							Run all your agile projects with Orangescrum's Scrum methodology! Create & plan sprints, assign tasks to the right team member to improve team performance & reduce your backlog steadily.
						</p>
						<p>
						Scrum board & Scrum reports make it easy for Scrum Masters to prioritize & track sprint progress for quicker execution of projects. 
						</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/sprint-planning-in-orangescrum.png" alt="Sprint Planning Made Easy" title="Sprint Planning Made Easy" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		
		<section class="description">
			<div class="cmn_wrapper">
				<!--<h2>OrangeScrum: Project Management Made Easy</h2>-->
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Task Management</h3>
						<p>
							Get the devil in the details and execute to perfection. Create and assign tasks with utmost clarity and timelines. <span>Track task progress</span>, contribute to the <span>discussion threads</span>, provide <span>timely updates</span> and <span>track time spent</span> on tasks effortlessly from a single platform. Be the ORACLE of your projects!
						</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home/Task-Management.png" alt="Task Management" title="Task Management" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="bg_clr description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home/Project-management-ganttchart.png" alt="Gantt Charts" title="Gantt Charts" width="" height="">
						</figure>
					</div>
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Gantt Charts</h3>
						<p><span>Gantt Charts</span> provide detailed visuals of project progress. You get to know which task has progressed how far, by whom, how long will it take for a task to complete, dependencies among tasks & who is stuck where. All of these in a <span>sigle view</span> helps you handle any delays proactively. Gift your Clients on time delivery, always! 
					  </p>
					  <a href="https://calendly.com/priyankagarwal/15min" target="_blank" title="Request A Demo" class="bdy_rqst_demo_btn">Request A Demo</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="testimonial testimonial_solution">
			<div class="wrapper">
				<div class="testimonial_slider">
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/Fabio.jpg"  alt="Fabio" title="Fabio" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Fabio Guimarães</h6>
								  <small class="address">CEO - FGX, Brazil</small>
								  <p class="quote">
									Orangescrum controls our projects in a way we did not find in any other platform. As an open source project management software, the feature list is quite surprising...
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/Jamei.png" alt="Jamie Smith" title="Jamie Smith" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Jamie Smith</h6>
								  <small class="address">Director of Marketing Automation, SFCG, Texas, USA</small>
								  <p class="quote">
									Orangescrum simplifies the process of project management for our organization with its power collaboration tools. We couldn't be happier with Orangescrum! 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/anil-kumar.png"  alt="Anil Kumar" title="Anil Kumar" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Anil Kumar</h6>
								  <small class="address">CEO, Saral Technologies</small>
								  <p class="quote">
									OrangeScrum made our project management tasks and timesheets so much easier and support provided by team is awesome. 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/pedro.png"  alt="Pedro Artur Oliveira" title="Pedro Artur Oliveira" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Pedro Artur Oliveira</h6>
								  <small class="address">Gestor de clientes (Manager) | CAIXA, Lda.</small>
								  <p class="quote">
									Maintaining a logical understanding of the project before the Orangescrum was a task that was time consuming. With Orangescrum this is not a concern. 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/brent.png"  alt="Brent Kerr" title="Brent Kerr" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Brent Kerr</h6>
								  <small class="address">CEO, Kewico GmbH</small>
								  <p class="quote">
									I work with Freelancers to get the CAD jobs done. Orangescrum provided me with a way for them to track and bill their time... 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/bala.png"  alt="Bala" title="Bala" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Bala</h6>
								  <small class="address">Consultant | IPneeti</small>
								  <p class="quote">
									Orangescrum replaced our complex excel time log to a simple web log, and further,the invoice generation facility reduces most of the work of managers! 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/Sadanand.png"  alt="Sadanand Suresh Walte" title="Sadanand Suresh Walte" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Sadanand Suresh Walte</h6>
								  <small class="address">Delivery Head,Technex Technologies Pvt Ltd, Pune, India.</small>
								  <p class="quote">
									OrangeScrum helped us to be highly effective with - People & tasks planning, Tracking and Communication and updates... 
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/Kuda-Msipa.png"  alt="Kuda Msipa" title="Kuda Msipa" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Kuda Msipa</h6>
								  <small class="address">Cutmec</small>
								  <p class="quote">
									My clients get a faster response from us now. Also, they are able to see what's going on with a project. They talk to my...
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/Khululekani.png"  alt="Khululekani" title="Khululekani" width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Khululekani</h6>
								  <small class="address">Director | Thebe Media Solutions | South Africa</small>
								  <p class="quote">
									Orangescrum provided us with the perfect solution to collaborate on line, keeping track of task statuses, responsibilities...
								   </p>
							   </div>
							</li>
						</ul>
					</div>
					<div class="slide">
						<ul>
							<li>
							  <div class="pfl-img_blk">
								<figure class="pfl-img">
									<img src="<?php echo HTTP_ROOT; ?>img/app-service/robert-koszorus.jpg"  alt="Robert Koszorus E.V." title="Robert Koszorus E.V." width="" height="">
								</figure>
							  </div>
							  <div class="quote_txt_blk">
								  <h6>Robert Koszorus E.V.</h6>
								  <small class="address">Development Agency, Hungary</small>
								  <p class="quote">
									Orangescrum is one of the most usable, flexible and interactive of the project management systems I know. Me and my team can easily manage our projects...
								   </p>
							   </div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="bg_clr description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-left wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home/Project-management-collaboration.png" alt="Collaborate" title="Collaborate" width="" height="">
						</figure>
					</div>
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Project Collaboration</h3>
						<p>
							Lenthy Emails -NO! Lost files - NO! Missing Task Updates - No!
							Orangescrum <span>Daily Catch-up</span>, <span>Task notifications</span>, <span>In-App Chat</span> all ensure that you never miss a beat on your projects. From <span>task updates</span>, <span>re-assignments</span>, status changes to comments and replies by clients and teams are all tracked and updated in real-time. You are always in the thick of things whether you are at office or home. The iOS and Android apps simplify these benefits further. Collaboration and Success was never so easy!
						</p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		<section class="description">
			<div class="cmn_wrapper">
				<div class="steps_table dtbl">
					<div class="col-md-6 dtbl_cell cell_40">
						<h3>Reports & Analytics</h3>
						<p>Orangescrum provides a host of insightful yet simple analytics to stay ahead of time. <span>Resource Utilization</span>, <span>Weekly Status metrics</span>, <span>live activity feeds</span>, <span>billable vs non-billable</span> project hours all come in handy while reviewing your project  team's performance. They also help provide true execution status and help in making timely decisive operational changes. Get all you need to stay ahead of your competition!</p>
					</div>
					<div class="col-md-6 dtbl_cell cell_60">
						<figure class="text-right wow flipInX" data-wow-delay="0.5s">
							<img src="<?php echo HTTP_ROOT ;?>img/home_outer/graphic1.png" alt="Reports & Analytics" title="Reports & Analytics" width="" height="">
						</figure>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
	</div>
<!--<div class="social_med_foot">
	<div>
    	<a target="_blank" title="Twitter" href="https://twitter.com/theorangescrum"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/tw_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
        <a target="_blank" class="fbook" title="Facebook" href="https://www.facebook.com/pages/Orangescrum/170831796411793"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/face_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
		<a target="_blank" class="google" title="Google" href="https://plus.google.com/103991755151199877447" rel="publisher"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/go_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
    </div>
</div>-->
<section class="cmn-outer-page" style="display:none">
	<div class="explore-con">
		<div class="btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?>signup/free<?php echo $ablink; ?>" title="<?php echo SIGNUP_CTA_B; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
		<div class="btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>mobile-app<?php echo $ablink; ?>" title="Explore Mobile App">Or Explore Mobile App &rarr;</a></div>
	</div>
</section>
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

$(document).ready(function() {
    $('#mycarousel1').jcarousel({
		auto: 2,							
    	wrap: 'circular'
    });
});
</script>