<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>css/bootstrap.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
	$("#fot_home_emailid").off().on('keyup', function(e) {
		var unicode = e.charCode ? e.charCode : e.keyCode;
		if (unicode == 13) {
			gtStartedOsFooter('fot_home_emailid');
		}
	});
	$('.learnmore').click(function() {
    var target = '.feature';
    var $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top - 140
    }, 900, 'swing', function() {});
    });
});
var Metattl = {
	"resource-management":"Resource Management Tool | Time and Resource Management | Orangescrum",
	"time-tracking":"Time Tracking Software | Time Tracking Tool | Time and Resource  Management Software",
	"agile-project-management":"Agile Project Management Software | Scrum Boards, Backlog & Sprints",
	"task-management":"Task Management Tool | Task Management Software | Orangescrum",
	"kanban-view":"Kanban View | Project Management Software Orangescrum",
	"user-role-management":"User Role Management | Role Based Access Control | Orangescrum",
	"invoice-how-it-works":"Invoice Management | Project and Task Management Tool | Orangescrum",
	"mobile-app":"THE ORANGESCRUM | Project and Task Management Software Mobile App",
	"gantt-chart":"Gantt Chart | Simplified & Visual Project Planning | Project Management Software",
	"google-calendar-integration":"Google Calendar Integration with Orangescrum | SaaS Project Management Tool",
	"custom-status-workflow":"Custom Task Status and Workflow | Create your Own Custom Task | Orangescrum",
};

var pagUrl = {
	"resource_utlization":"",
	"time_tracking":"",
	"agile_pm":"",
	"task_management":"",
	"kanban_view":"",
	"user_role_management":"",
	"invoice_how_it_works":"",
	"mobile_app":"",
	"gantt_chart":"",
	"gcalendar_integration":"",
	"custom_status_workflow":"",
};

function go_next_prev(page){
	$.post(HTTP_ROOT+page,{"is_ajax":1}, function(data){
		if(data){
			$('.cmn_feature_page').html("");
			$('.cmn_feature_page').html(data);
			$(document).prop('title', Metattl.page);
			window.history.pushState({"html":data,"pageTitle":Metattl.page},"", '/'+page);
		}
	});
}
</script>
<script type='application/ld+json'> 
{
  "@context": "http://www.schema.org",
  "@type": "WebPage",
  "url": "https://www.orangescrum.com/catch-up",
  "name": "Daily Catch Up",
  "description": "Syncing your Google calendar with Orangescrum #1 Task Management Tool enhances your task management    capabilities, & ensures better task schedule management.",
   "image": "https://www.orangescrum.com/img/features/gcalendar-feature.png"
  }
</script>
<style>
  .cmn_features_landing_page .tab_details .step_no{font-size:55px;line-height:60px;font-family: 'Work Sans', sans-serif;}
	.cmn_new_feature_page .cmn_home_btn,.cmn_new_feature_page .cmn_learnmore_btn{font-size:18px;min-width:130px}
	.cmn_new_feature_page .cmn_article_sec article {font-size: 24px;line-height: 40px;}
	.cmn_new_feature_page .description_article h4 {font-size: 24px;line-height: 32px;font-weight:600;font-family: 'Work Sans', sans-serif;}
  .cmn_new_feature_page .description figure img{width:auto;height:auto}

  .cmn_new_feature_page .feature_bnr_hero{background:#f6f6f7;padding:100px 60px 120px;width: calc(100% - 0px);width: -webkit-calc(100% - 0px);width: -moz-calc(100% - 0px);margin:0px auto 0;position:relative}

	.cmn_features_landing_page .feature_bnr_hero article {margin:30px auto 60px;max-width: 900px;font-size: 26px;line-height: 36px;}
	.cmn_features_landing_page .feature_bnr_hero .start_signup_form .inp_fld {border: 1.5px solid #9c9a9a !important}
	.cmn_features_landing_page .feature_bnr_hero .start_signup_form .cmn_home_btn {padding: 0 30px 0 30px;}
	.cmn_features_landing_page .feature_bnr_hero .start_signup_form .no_credit_card {padding: 0 10px;margin-top: 10px;}
	.cmn_features_landing_page .watch_feature_video.nobg{background:transparent;width:400px;height:200px;margin: 120px auto 0;position:relative}
	.cmn_features_landing_page .watch_feature_video.nobg figure img{max-height:200px}
	.cmn_features_landing_page .watch_feature_video.nobg .video_action{position:absolute;top:0;left:0}
	.cmn_features_landing_page .watch_feature_video.nobg figure::before,
	.cmn_features_landing_page .watch_feature_video.nobg figure::after{display:none}
	.cmn_new_feature_page .feature_bnr_hero .hero_media_item{left:0}
	.cmn_features_landing_page .watch_feature_video span::after{content:'';width:50px;height:50px;background:#fff;position:absolute;left:0;right: 0;top: 0;bottom: 0; margin: auto;border-radius: 50%;top:0;z-index:-1;pointer-events:none}
	.cmn_features_landing_page .watch_feature_video span{background:rgb(254 248 248 / 9%);position: relative;z-index: 1;width: 100%;height: 100%;display: flex;align-items: center; justify-content: center;border: 1px solid #00AAFF;
    border-radius: 5px;-webkit-box-shadow: -8px -8px 20px rgb(112 112 112 / 5%), 8px 8px 20px rgb(112 112 112 / 5%);
    box-shadow: -8px -8px 20px rgb(112 112 112 / 5%), 8px 8px 20px rgb(112 112 112 / 5%);}
	.cmn_features_landing_page .watch_feature_video span::before{margin:0;}
	.cmn_new_feature_page .navigate_feature_navbar{width: calc(100% - 0px);width: -webkit-calc(100% - 0px);width: -moz-calc(100% - 0px);margin:0 auto}
	.cmn_features_landing_page .cmn_blog_sec {padding: 0px 0 30px;}
	.start_trailnow{margin:80px 0 0px;text-align:center}
	.newuser_freetrial .start_trailnow .sub_hero_title{margin:0 0 40px}

	
	.cmn_features_landing_page .intergration .wrapper{background: url(<?php echo HTTP_ROOT;?>img/features/integarion-bg-new.png) no-repeat 0px 0px;background-size: 100% 100%;padding:100px 80px}
	
	.cmn_features_landing_page .feature_step_sec{padding:100px 0 120px}
	.cmn_features_landing_page .feature_tabs {margin: 0 auto 120px;}
	.cmn_features_landing_page .how_agileuse_sec {padding: 60px 0 60px;}
	.cmn_features_landing_page .navigate_prev_next{height:300px}
	.cmn_new_feature_page .flex_column {padding: 0 40px;}
	.cmn_features_landing_page .testimonial{padding:20px 0 120px}
	
</style>
<div itemscope itemtype="http://schema.org/Organization" style="display:none">
	<a itemprop="url" href="https://www.orangescrum.com/catch-up"><div itemprop="name">Project and Task Management Software Daily Catch Up | Orangescrum</div>
	</a>
	<div itemprop="description">Orangescrum project and task management software daily catch-up helps you to track your team and their tasks without any physical follow-up. Helps to track a clear picture on how a smart team performs.</div>
</div>
<main class="cmn_new_feature_page cmn_features_landing_page dailycatchup_page">
  <section class="feature_bnr_hero">
		<div class="wrapper">
        <div class="hero_title cmn_head_font">
            <div class="page_tag"><span>Daily Catch Up</span></div>
           <h1>Daily Catch Up</h1>
        </div>
        <article>
         Hassle free and automated daily check-ins for project progress, task updates and accomplishments of the day.
        </article>
        <div class="flex_row flow_mark_bg">
            <div class="flex_column start_signup_form">
                <form action="javascript:void(0);">
                <input type="email" placeholder="Your Email Address" class="inp_fld" id="home_emailid" />
                <button type="button" title="Get Started" class="cmn_home_btn cmn_right_slide_cta" onclick="return gtStartedOsFooter('home_emailid');">Get Started <span class="arrow_right_icon"></span></button>
                <p id="home_emailid_error" class="error_msg">Please enter your email.</p>
                </form>
               <small class="no_credit_card">No credit card required</small>
            </div>
            <div class="flex_column">
              <div class="or">OR</div>
              <div class="signup_cta google_signup" id="gSignInWrapper" onclick="googlesignuphome();signinWithGoogle();savePageGSignup('signup');" title="Sign up with Google">
                <div id="customBtn" class="customGPlusSignIn google_icon"></div>
              </div>
            </div>
        </div>
        <div class="hero_media_item">
              <div class="watch_feature_video nobg">
			  <figure>
					<img src="<?php echo HTTP_ROOT;?>img/home_outer/How-to-Setup-your-First-Project-in-Orangescrum.jpg" alt="Orangescrum Daily Catchup video" width="400" height="200">
				</figure>
			  <span class="video_action" data-video="https://www.youtube.com/embed/STT0bEn8ZLs" data-toggle="modal" data-target="#taskmgmtvideo" title="Watch the Video"></span></div>
          </div>
          <!-- Modal start -->
          <div id="taskmgmtvideo" class="modal fade video_modal" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="modal-body">
              <iframe width="900" height="500" src="" frameborder="0" allowfullscreen></iframe>
              </div>
            </div>
            </div>
          </div>
          <!-- Modal end -->
		</div>
	</section>
	<?php echo $this->element('feature_navigation_slider'); ?>
	<section class="description">
		<div class="wrapper">
			<div class="flex_row  m_0">
			  <div class="flex_column column_40">
				<div class="sub_hero_title cmn_head_font">
					<h3>Schedule Once & Relax</h3>
				  </div>
				<div class="desc_paragrph">
				  <p>
					Set automated reminders and get progress updates from all your team members at the same time, in a single email delivered to your inbox.
				  </p>
				</div>
				<a href="javascript:void(0)" onclick="signUpModal()" title="Learn more" class="cmn_learnmore_btn">Learn more</a>
			  </div>
			  <div class="flex_column column_60">
				<figure class="text-right wow fadeIn"  data-wow-duration="2s" data-wow-delay="0.2s">				  
				  <img src="<?php echo HTTP_ROOT ;?>img/features/Daily-Catch-Up1.png" class="magniflier" alt="Schedule Once & Relax" title="Schedule Once & Relax" width="831" height="520">
				</figure>
			  </div>
			</div>
			<div class="flex_row">
				<div class="flex_column column_60">
					<figure class="text-left wow fadeIn"  data-wow-duration="2s" data-wow-delay="0.2s">
						 <img src="<?php echo HTTP_ROOT ;?>img/features/Drag-Drop-Task-Groups.png" class="magniflier" alt="GDrag and Drop Tasks to the Task Groups" title="Drag and Drop Tasks to the Task Groups" width="831" height="520">
					</figure>
				</div>
				<div class="flex_column column_40">
				<div class="sub_hero_title cmn_head_font">
					<h3>Daily Team Updates</h3>
					</div>
					<div class="desc_paragrph">
					  <p>
						 Get daily progress updates with absolute clarity of the day’s activities & plan your actions for the next day transparently.
					  </p>
					</div>
					<a href="<?php echo HTTP_ROOT;?>schedule-a-demo" target="_blank" title="Request a Demo" class="cmn_learnmore_btn">Request a Demo</a>
				</div>
			</div>
			<div class="flex_row">
			  <div class="flex_column column_40">
			  <div class="sub_hero_title cmn_head_font">
				 <h3>Know what is being done</h3>
				 </div>
				<div class="desc_paragrph">
				  <p>
					Teams get timely reminders to report daily accomplishments ensuring deliverability and accountability for all.
				  </p>
				</div>
				<a href="javascript:void(0)" onclick="signUpModal()" title="Learn more" class="cmn_learnmore_btn">Learn more</a>
			  </div>
			  <div class="flex_column column_60">
				<figure class="text-right wow fadeIn"  data-wow-duration="2s" data-wow-delay="0.2s">				  
				  <img src="<?php echo HTTP_ROOT ;?>img/features/Daily-Catch-Up3.png" class="magniflier" alt="Know what is being done" title="Know what is being done" width="831" height="520">
				</figure>
			  </div>
			</div>
		</div>
	</section>
	<section class="navigate_prev_next">
		<div class="wrapper">
			<div class="flex_row try_upnaxt">
				<div class="flex_column left">
					<a href="<?php echo HTTP_ROOT;?><?php echo SIGNUP_CTA_LINK; ?>" title="Try Orangescrum" class="try_os_cta cmn_right_slide_cta">Try Orangescrum <span class="arrow_right_icon"></span></a>
				</div>
				<?php /*<div class="flex_column right">	
					<a <?php if($FEATURE_PAGES[PAGE_NAME]['next'] == ''){ ?>class="noprev"<?php } ?> href="<?php if($FEATURE_PAGES[PAGE_NAME]['next'] == ''){ ?>javascript:void(0);<?php }else{ ?>javascript:void(0);<?php } ?>" onclick="go_next_prev('<?php echo $FEATURE_PAGES[PAGE_NAME]['next'];?>');"><small>Up Next:</small> Kanban View <span class="arrow_next"></span></a>
				</div> */?>
				<div class="flex_column right">	
					<a href="<?php echo HTTP_ROOT;?>invoice-how-it-works" title="Invoice"><small>Up Next:</small> Invoice <span class="arrow_next"></span></a>
				</div>
			</div>
		</div>
	</section>
	<section class="teams_can_use">
		<div class="wrapper">
			<div class="sub_hero_title cmn_head_font">
				<h2><small>Teams that</small> benefit the most from Orangescrum</h2>
			</div>
		
		<div class="d-flex ticker_marquee">
			<ul class="d-flex">
				<aside class="slide">
					<a href="<?php echo HTTP_ROOT;?>solutions/it-project-management" title="IT Teams" class="card_item">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/IT-teams.svg" alt="IT Teams" width="150" height="100">
						</figure>
						<h4>IT Teams</h4>
						<p>
							Accelerate IT project delivery with Orangescrum. Organize tasks, track time & manage resources to maximize productivity & ROI.
						</p>
						<div class="leranmore"><strong>Learn More</strong> <span class="use-case-more"></span></div>
					</a>
				</aside>
				<aside class="slide">
					<a href="<?php echo HTTP_ROOT;?>solutions/marketing-projectportfolio-management" title="Marketing Teams" class="card_item">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/marketing-teams.svg" alt="Marketing Teams" width="150" height="100">
						</figure>
						<h4>Marketing Teams</h4>
						<p>
							Drive marketing strategy with Orangescrum. A single collaborative tool for your teams & clients for the marketing campaigns.
						</p>
						<div class="leranmore"><strong>Learn More</strong> <span class="use-case-more"></span></div>
					</a>
				</aside>
				<aside class="slide">
					<a href="<?php echo HTTP_ROOT;?>remote-team-management" title="Remote Teams" class="card_item">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/remote-teams.svg" alt="Remote Teams" width="150" height="100">
						</figure>
						<h4>Remote Teams</h4>
						<p>
							Stay updated by collaborating with your distributed teams in one place. Orangescrum makes your virtual teams real.
						</p>
						<div class="leranmore"><strong>Learn More</strong> <span class="use-case-more"></span></div>
					</a>
				</aside>
				<aside class="slide">
					<a href="<?php echo HTTP_ROOT;?>agency-project-management" title="Creative Teams" class="card_item">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/creative-teams.svg" alt="Creative Teams" width="150" height="100">
						</figure>
						<h4>Creative Teams</h4>
						<p>
							Streamline & speed up digital, creative and marketing process with Orangescrum and deliver high quality projects.
						</p>
						<div class="leranmore"><strong>Learn More</strong> <span class="use-case-more"></span></div>
					</a>
				</aside>
			</div>
		</div>
	</section>
	
	<section class="intergration">
		<div class="wrapper">
			<div class="sub_hero_title cmn_head_font">
				<h2><small>Integrate</small> Orangescrum with your favourite apps</h2>
			</div>
			<div class="flex_row">
				<div class="flex_column">
					<figure class="wow fadeInLeft" data-wow-delay="0.1s">
						<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-slack-integration.svg" alt="Orangescrum slack integration" title="Orangescrum slack integration" width="58" height="64">
					</figure>
				</div>
				<div class="flex_column">
					<figure class="wow fadeInLeft" data-wow-delay="0.2s">
						<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-github-integration.svg" alt="Orangescrum github integration" title="Orangescrum github integration" width="58" height="64">
					</figure>
				</div>
				<div class="flex_column">
					<figure class="wow fadeInLeft" data-wow-delay="0.3s">
						<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-dropbox-integration.svg" alt="Orangescrum google dropbox integration" title="Orangescrum dropbox integration" width="58" height="64">
					</figure>
				</div>
				<div class="flex_column">
					<figure class="wow fadeInLeft" data-wow-delay="0.4s">
						<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-google-drive-integration.svg" alt="Orangescrum google drive integration" title="Orangescrum google drive integration" width="58" height="64">
					</figure>
				</div>
				<div class="flex_column">
					<figure class="wow fadeInLeft" data-wow-delay="0.5s">
						<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-google-calender-integration.svg" alt="Orangescrum google calendar integration" title="Orangescrum google calendar integration" width="58" height="64">
					</figure>
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial">
		<div class="wrapper">
			<div class="sub_hero_title cmn_head_font margin-bottom-60">
				<h2>What our customers say</h2>
			</div>
			<div id="testimonial-carousel" class="owl-carousel">
				<article>
					<div class="flex_row">
						<div class="flex_column">
							<div class="quote_desc">
								<span class="lt_qt">&#8220;</span>My team (Hailstorm-Development) and I LOVE Orangescrum! We are a flextime remote business solution specialist agency, and this tool has enabled us to actually create this company. Without you all, we wouldn't even exist!<span class="rt_qt">&#8221;</span>
							</div>
							<div class="cmny_logo_postion">
                <figure> <img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/Hayley-Turner-400.png" alt="Hayley Turner" width="300" height="300"> </figure>
								<div class="tmonial_owner">
									<h5 class="name">Hayley Turner</h5>
									<div class="address">(Founder & CEO, United States, Michigan)</div>
								</div>
							</div>
						</div>
					</div>
				</article>
				<article>
					<div class="flex_row">
						<div class="flex_column">
						<div class="quote_desc">
							<span class="lt_qt">&#8220;</span>Orangescrum simplifies the process of project management for our organization with its power collaboration tools and provides seamless support and on-boarding We couldn't be happier with Orangescrum!<span class="rt_qt">&#8221;</span>
						</div>
						<div class="cmny_logo_postion">	
              <figure>
								<img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/Jamie-400.jpg" alt="Jamie Smith" width="300" height="300">
							</figure>
							<div class="tmonial_owner">
								<h5 class="name">Jamie Smith</h5>
								<div class="address">(Director of Marketing Automation, SFCG, Texas, USA)</div>
							</div>
						</div>
						</div>
					</div>
				</article>
				<article>
					<div class="flex_row">
						<div class="flex_column">
						<div class="quote_desc">
							<span class="lt_qt">&#8220;</span>I work with Freelancers to get the CAD jobs done. Orangescrum provided my team with a way to track and bill their time directly on the project they are working on. This saved me a lot of administrative work.<span class="rt_qt">&#8221;</span>
						</div>
						<div class="cmny_logo_postion">
              <figure> <img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/brent-kerr-400.png" alt="Brent Kerr" width="300" height="300"> </figure>
							<div class="tmonial_owner">
								<h5 class="name">Brent Kerr</h5>
								<div class="address">(CEO, Kewico GmbH)</div>
							</div>
						</div>
						</div>
					</div>
				</article>
				<article>
					<div class="flex_row">
						<div class="flex_column">
						<div class="quote_desc">
							<span class="lt_qt">&#8220;</span>I was very impressed with the ease of use of its interface and all its features to manage projects. It is a platform that can be customized to our needs. Migrating my projects to Orangescrum was super easy. <span class="rt_qt">&#8221;</span>
						</div>
						<div class="cmny_logo_postion">
              <figure> <img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/clotilde.png" alt="Clotilde Jolimaitre Rodriguez" width="300" height="300"> </figure>
							<div class="tmonial_owner">
								<h5 class="name">Clotilde Jolimaitre Rodriguez</h5>
								<div class="address">(Digital Project Manage, Imagevo France)</div>
							</div>
						</div>
						</div>
					</div>
				</article>
				
				<article>
					<div class="flex_row">
						<div class="flex_column">
						<div class="quote_desc">
							<span class="lt_qt">&#8220;</span>Our major chellenge was to manage multiple Projects/multiple clients at the same time. So we needed something more than excel sheets to manage the development velocity and make things automated.<span class="rt_qt">&#8221;</span>
						</div>
						<div class="cmny_logo_postion">
              <figure> <img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/Shan.jpg" alt="Shan Sashidharan" width="300" height="300"> </figure>
							<div class="tmonial_owner">
								<h5 class="name">Shan Sashidharan</h5>
								<div class="address">(Director Of Technology At Techuva Solutions)</div>
							</div>
						</div>
						</div>
					</div>
				</article>
				<article>
					<div class="flex_row">
						<div class="flex_column">
						<div class="quote_desc">
							<span class="lt_qt">&#8220;</span>The most beautiful thing about Orangescrum is easy in its approach which makes it a lot simpler to use. Orangescrum makes a complicated project way easier to run within my team.<span class="rt_qt">&#8221;</span>
						</div>
						<div class="cmny_logo_postion">
              <figure> <img src="<?php echo HTTP_ROOT;?>img/home_outer/success-story/Kuda-Msipa.jpg" alt="Kuda Msipa" width="300" height="300"> </figure>
							<div class="tmonial_owner">	
								<h5 class="name">Kuda Msipa</h5>
								<div class="address">(CEO Cutmec Group, Bristol, United Kingdom)</div>
							</div>
						</div>
						</div>
					</div>
				</article> 
			</div>
      <div>
        <figure>
					<img src="<?php echo HTTP_ROOT;?>img/features/orangescrum-clients-logo.png" alt="Orangescrum Happy Customers" width="901" height="120">
				</figure>
      </div>
		</div>
	</section>
  <?php echo $this->element('signup_modal'); ?>
</main>
<script type="text/javascript" src="<?php echo HTTP_ROOT;?>js/jquery/maginifying-glass.js"></script>
<script type="text/javascript">
function signUpModal(){
  $("#signUpModal").modal('show');
 }
		$(document).ready(function() {
	$(".video_action,.team_video_action").click(function () {
	  var theModal = $(this).data("target"),
	  videoSRC = $(this).attr("data-video"),
	  videoSRCauto = videoSRC + "?modestbranding=1&rel=0&controls=1&showinfo=0&autoplay=1";
	  $(theModal + ' iframe').attr('src', videoSRCauto);
	  $(theModal + ' .close').click(function () {
		$(theModal + ' iframe').attr('src', videoSRC);
	  });
	  $(theModal).on('hidden.bs.modal', function (e) {
		$(theModal + ' iframe').attr('src', videoSRC);
	  });
	});


	var carousel = $("#testimonial-carousel");
   carousel.owlCarousel({
		//items:1,
		//itemsDesktop:[1000,1],
		//itemsDesktopSmall:[979,1],
		//itemsTablet:[768,1],
		//pagination: true,
		//slideSpeed:1000,
		//singleItem:true,
		//transitionStyle:"fadeUp",
		//animateIn: 'fadeIn', 
    //animateOut: 'fadeOut',
    //autoPlay: true
    
    items:1,
    itemsDesktop:[1000,1],
    itemsDesktopSmall:[979,1],
    itemsTablet:[768,1],
    pagination:true,
	navigation:false,
    transitionStyle:"fade",
	mouseDrag:false,
	touchDrag:false,
	pullDrag:false,
    autoPlay:true,
	afterAction: function(el){
   //remove class active
   this
   .$owlItems
   .removeClass('active')

   //add class active
   this
   .$owlItems //owl internal $ object containing items
   .eq(this.currentItem)
   .addClass('active')    
    } 
    
	});
		});
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