<script type="text/javascript">
function showVideo(){
		//$(".try").animate({top:"40px"})
		$(".video_button").hide();
		$("#video2").animate({width:"100%",height:"361px"});
		//$('html, body').stop().animate({scrollTop: 420}, 800);
		$("#v_con").animate({top:"0px"});
		$("#video2_inner").fadeIn();
		$("#mover").animate({margin:"0px"});
		$("#video2_inner").html('<iframe width="640" height="360" src="https://www.youtube.com/embed/2Neml2PFLMk?rel=0" width="100%" height="100%" frameborder="0" class="frame-border" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
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
</script>
<div class="clear"></div>
<div class="cmn-outer-page">
	<div id="wrapper" >
	<!-- <h3 class="awsm">Organize Projects, Tasks, Documents & Meeting Minutes in one place</h3> -->
	    <div class="top_bnr_mc_land">
			<h1>Clear and Concise graphics of your Projects</h1>
			<span class="sub-title">
				Stay on Top! Get things done Efficiently, Increase Productivity.
			</span>
			<div id="video2">
				<div id="video2_inner">
					<iframe width="640" height="360" src="https://www.youtube.com/embed/2Neml2PFLMk?rel=0" width="100%" height="100%" frameborder="0" class="frame-border" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
				</div>
				<div style="display:none;" class="video_button" onClick="showVideo();ga_tracking_video('Bridge The Communication Gap');" >
				<div style="display:none;" class="play_icn"><img src="<?php echo HTTP_ROOT; ?>img/home/icon-play.png?v=<?php echo RELEASE; ?>" width="48px" height="48px" /></div>
				</div>
			</div>
			<div class="cb"></div>           
		</div>
		<div class="hm_mcontent">
			<h2>All Features</h2>
			<span class="sub-title">
				Increase Productivity using Orangescrum
			</span>
			<div <?php if($this->Session->read('Auth.User.id')==''){?> <?php } ?>>
		        <table cellpadding="0" cellspacing="0">
		            <tr>
		                <td>
		                	<h5>Interactive summary of Projects.</h5>
		                    <p>Provides interactive summary of Projects.</p>
		                </td>
		                <td>
		                	<img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/summary.png?v=<?php echo RELEASE; ?>" alt="" />
		                </td>
		            </tr>
					<tr>
						<td>
						<h5>Visual Representation</h5>
						<p>Consolidates, aggregates and arranges reports in a visual representation.</p>
		                </td>
		                 <td>
		                 	<img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/visual.png?v=<?php echo RELEASE; ?>" alt="" />
		                 </td>
		            </tr>
		            <tr>
		                <td>
		                	<h5>All in one screen</h5>
		                  <p>Displayed on a single screen so information can be mentioned at a glance</p>
		                </td>
		                <td>
		                	<img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/project.jpg?v=<?php echo RELEASE; ?>" alt="" />
		                </td>
		            </tr>
					<tr>
		                <td>
		                	<h5>Project Demonstrate</h5>
		                  <p>Demonstrate to project managers where corrective action needs to b e taken</p>
		                </td>
		                <td>
		                	<img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/screen.png?v=<?php echo RELEASE; ?>" alt="" />
		                </td>
		            </tr>
		        </table>
				<!--<?php if($this->Session->read('Auth.User.id')==''){ ?>
					<div class="explore-con">
						<div class="fl btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?><?php echo SIGNUP_CTA_LINK; ?><?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
							<div class="fr btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>project-management">Or Explore Project Management Tool &rarr;</a></div>
						<div class="cb"></div>
					</div>
				<?php } ?>-->
		    </div>
		</div>
		<div class="cb"></div>
		<a href="javascript:void(0);" id="to_top" style="display:none">
		    <img title="Scroll to Top" alt="Scroll to Top" src="../img/scr_top.png?v=183" width="44px" height="58px" style="position:fixed; right:20px; bottom:50px;"/>
		</a>
<?php /* if($this->Session->read('Auth.User.id')==''){?>
<div class="fixed_signup">
	<div class="fixed_txt" style="color:#333333;font-family:'OPENSANS-REGULAR';">Stay on Top ! Get things done Efficiently, Increase Productivity.</div>
	<div  style="margin-bottom:12px;">
		<a href="<?php echo PROTOCOL."www.".DOMAIN; ?>signup/getstarted<?php echo $ablink; ?>" onclick="getstarted_ga('TOP');" class="tk_tour" style="font-size: 16px; padding: 5px 18px;">
			<span><?php echo SIGNUP_CTA_B; ?></span>
			<!--<img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/free_trial_arr.png?v=<?php echo RELEASE; ?>"  alt="Free Trial" />-->
		</a>
		<span style="margin-left:20px;">or</span>
		<span onclick="signinWithGoogle();ga_tracking_google_signup('Signup Page');">
			<img src="<?php echo HTTP_ROOT; ?>img/sign-up-with.png?v=<?php echo RELEASE; ?>"  alt="Signup with Google" style="cursor:pointer;position:relative;top:11px;left: 20px;"/>
		</span>
	</div>
</div>
<?php } */ ?>
</div>
	<?php if($this->Session->read('Auth.User.id')==''){ ?>
		<div class="explore-con">
			<div class="btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?><?php echo SIGNUP_CTA_LINK; ?><?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
			<div class="btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>project-management">Or Explore Project Management Tool &rarr;</a></div>
		</div>
	<?php } ?>
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
	if( $(window).scrollTop() > 630 ){
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