<style type="text/css">
.top_menu_land { position:absolute !important;background:none;margin-top:20px; }
.fixed_signup{position:fixed;top:0px;background:#ffffff;z-index:2147483647;text-align:center;padding:2px 0 7px;font-family:MyriadProSemibold;color:#999999;font-size:16px;border-bottom: 1px solid #cccccc;display:none;width:100%}

.top_m_cont_land {width:100%;height:650px;}

#video2 { height:361px; width:642px; background:url("../../img/loading2.gif") no-repeat center;margin:30px auto; position:relative; z-index:1;}
.closer{position:absolute; background-color:#999; color:#fff; text-align:center; line-height:22px; width:22px; border-radius:10px; top:-18px; right:-15px; font-weight:bold; cursor:pointer;}
#video2_inner {width:60%; height:inherit; display:none; margin:0px auto;}
.video_button {width:642px; height:361px;border:1px solid #ccc; margin:30px auto; display:block; cursor:pointer; background: url("../../img/home/video.jpg?v=1") no-repeat  center top #fff;}
.explore-con{width:473px;margin:0 auto 50px;}
.btn-n a{border:1px solid #28a752;border-radius: 5px;display:block;font-size: 22px;text-align: center;text-decoration:none;padding:10px; font-family:'OPENSANS-REGULAR';}
.btn-n.btn-sign a{background:#3cc168;color: #fff;}
.btn-n.btn-explr a{background:#ffffff;color: #28a752;}
.btn-n.btn-sign a:hover, .btn-n.btn-explr a:hover{box-shadow:0px 0px 10px #28a752;-webkit-box-shadow:0px 0px 10px #28a752;-moz-box-shadow:0px 0px 10px #28a752;}
.btn-n.btn-explr a:hover{background:#28a752;color: #ffffff;}
.explore-green-bg .btn-n.btn-explr a{background:none;color: #28a752;}
.explore-green-bg .btn-n.btn-explr a:hover{background:#28a752;color:#ffffff;}
.explore-green-bg{ background:url("../../img/home/bg-green.png") no-repeat center top; width:100%;padding:52px 0px;}
.explore-green-bg .btn-n {margin-right:30px;}
.start-stil{font-size:16px;margin:5px 30px;color:#FFFFFF;font-family:'OPENSANS-REGULAR';}
.start-til{font-size:24px;margin:0 30px;color:#FFFFFF;font-weight:bold;font-family:'OPENSANS-REGULAR';}
.cont4-row {width: 770px;margin:30px auto;}
.cont4-text1 a{color:#1a7fc5;text-decoration:none;}
.cont4-text1 a:hover{text-decoration:underline;}
.round { border: 1px solid #ccc;border-radius: 46px;height:87px; margin-left: 20px; width: 650px;font-family:'OPENSANS-REGULAR';}
.image-m { padding:0 30px;}
.i-prod{font-size:18px;color:#666;font-weight:normal;text-align:center;font-family: "OPENSANS-REGULAR";}

@media only screen and (min-width:761px) and (max-width:1000px) {
  .bord_dash h1{font-size:30px!important;}
  .bord_dash h3{font-size:22px!important;}

}
@media only screen and (max-width:1040px) {
	.tk_tour, a.tk_tour{ font-size: 21px;}
	#wrapper, .wrapper_new{width:90%;}
	.awsm{padding-top:60px;}
	.explore-con {width:880px;}
}
@media only screen and (max-width:850px) {
	.i-prod{font-size:14px;}
	.hm_mcontent table td p{font-size:16px;}
	.fixed_signup{display:none !important;}
	.how-sub-menu{top:100px;left:120px;}
	.explore-con {width:690px;}
	.bord_dash h1 {margin-top:50px}
}
@media only screen and (max-width:650px) {
	.all_buis{margin-top:0px;}
	.hm_mcontent table{width:100%; padding-top:30px;}
	.hm_mcontent table td h5{margin:10px auto 0;}
	.hm_mcontent table td{width:100%; display:block; padding-top:10px;margin:10px 0}
	.explore-con{width:100%;}
	.how-sub-menu{left:60px;}
	.bord_dash h1 {margin-top:40px}
	.wrapper_new table tr td img {width:50%;padding-left:130px;}
}
@media only screen and (max-width:550px) {
	.hm_mcontent table{width:100%; padding-top:0px;}
}

@media screen and (max-width:490px){
.bord_dash h1 {margin-top:10px;}
.wrapper_new table tr td img {width:50%;padding-left:25px;}
#wrapper, .wrapper_new {width:95%;}
}
@media only screen and (max-width:400px) {
	.bord_dash{padding-top:45px;}
	.fr.btn-n.btn-explr{float:left; margin-left:10px;}
	.btn-n a{font-size:13px; padding:5px;}
}
@media screen and (max-width:370px){
.explore-con {margin-bottom:25px}
.explore-con .btn-sign,.explore-con .btn-explr{float:none;width:90%;margin:0 auto 20px}
.explore-con .btn-n a {font-size: 22px;padding: 10px;}
.fr.btn-n.btn-explr{margin-left:16px;}
.bord_dash {padding-top:20px;}
.bord_dash h1 {margin-bottom: 10px;}
}

@media screen and (max-width:330px){
#wrapper, .wrapper_new {margin-top:60px;}
.wrapper_new table tr td img {padding-left:0;}
.explore-con .btn-sign, .explore-con .btn-explr {width:100%}
.fr.btn-n.btn-explr{margin-left:0;}
.bord_dash {padding-top:0;}
.how-sub-menu {left:5px;top:74px !important;}
}
.gogle_log_sup_icn{left: 30px;}
.gogle_log_sup{padding-left: 60px;}
</style>
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
</script>
<div class="clear"></div>


<div class="w_youget_con_land">
	<h3 class="awsm">Organize Projects, Tasks, Documents & Meeting Minutes in one place</h3>
	<div class="bord_dash">
		<h1 style="padding-top:0px;">Cost Tracking</h1>
		<div class="i-prod">OrangeScrum keeps track of your budget assigned to the project and tracks cost with assigned with the team, task or activity.  </div>
		<div class="i-prod" style="font-weight:bold;margin-top: 10px;">Orangescrum: Budget/Cost Management Made Easy</div>
	</div>
</div>
 <div class="cb"></div>
 <style>
 .w_youget_con_land p {
 	color: #1A7FC5;
    font-family: Muli-regular;
    font-size: 16px;
    margin: 20px 0;
    padding: 0;
	}
 .w_youget_con_land span {
 	color: #999;
 	}
 	 .w_youget_con_land a {
 	 	color:#1A7FC5;
 	 }

 </style>

<div class="hm_mcontent" style="border:none;padding:0;">
	<div class="wrapper_new" style="border-bottom:1px solid #ccc">
		<!--<h1>"It's really hard to design products by focus groups. A lot of times, people don't know what they want until you show it to them"</h1>
		<h6>-Steve Jobs</h6>-->
        <!--<h1>"Unity is strength... when there is teamwork & collaboration wonderful things can be achieved."</h1>
        <h6>-Mattie Stepanek</h6>-->
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>
					<h5>Cost Tracking</h5>
								<p>Keep track of costs and expenses in real-time at the project or task phase. Track costs endured with respect to time spent on a particular task and manage your cost accordingly.<br/>Know if your cost is in track or not. Take immediate decisions and make modification to the cost distribution based on real-time information.</p>
                	
                </td>
                <td><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/c-tracking.png?v=<?php echo RELEASE; ?>" alt="" /></td>
            </tr>
						<tr>
                <td><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/c-mgmt.png?v=<?php echo RELEASE; ?>" alt="" /></td>
								<td>
								<h5>Cost Management</h5>
                    <p>Manage your projects and tasks with planned target budget at the top level and track it with distributed channels in real-time. Analyse budget scenario in real-time. Forecast easily, if the project is in budget, below budget or can go beyond the estimated budget.</p>
                </td>
            </tr>
            <tr>
                <td>
                	<h5>Cost Control</h5>
                  <p>Control your cost with the time to cost variation model. Know where you stand now and what will be the cost incurred by your team or consultant by the end of the day. <br/>It gives a holistic approach on real-time scenario based on cost allocated to respective teams, tasks or individual.</p>
                </td>
                <td><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/c-control.png?v=<?php echo RELEASE; ?>" alt="" /></td>
            </tr>
						<tr>
                <td><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/cv-tracking.png?v=<?php echo RELEASE; ?>" alt="" /></td>
                <td>
                	<h5>Cost Variation Tracking</h5>
                  <p>OrangeScrum helps you to get a deep eye on cost variations, as each cost can vary according to business, according to project and according to sector. This will help to take decisions and allocate or re-allocate cost according to scenario. </p>
                </td>
            </tr>
         <!--   <tr>
                <td>
                	<h5>Time - Cost Budget Mapping</h5>
                  <p>Track the exact cost incurred with respect to time spent for a team. Analyze budget scenario in real-time. Forecast easily, if the project is in budget, below budget or can go beyond the estimated budget.</p>
                </td>
                <td><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/tc-maping.png?v=<?php echo RELEASE; ?>" alt="" /></td>
            </tr> -->
        </table>
				<div class="explore-con">
					<div class="fl btn-n btn-sign"> <a href="<?php echo HTTPS_HOME; ?><?php echo SIGNUP_CTA_LINK; ?><?php echo $ablink; ?>"><?php echo SIGNUP_CTA_B; ?></a></div>
					<div class="fr btn-n btn-explr"><a href="<?php echo HTTPS_HOME; ?>task-groups<?php echo $ablink; ?>">Or Explore Task Groups &rarr;</a></div>
					<div class="cb"></div>
				</div>
    </div>

</div>
<style>
.lower_image {
	position:relative;top:5px;padding-right:3px;
}
</style>
<div class="cb"></div>


<!--<div class="quote_bg">
	<h1>We Love Our Customers</h1>
	<div class="sld_clients">
		<div class="sld_clients_inner">
			<div class="showcase_img">
				<div id="wrap">
				  <ul id="mycarousel1" class="jcarousel-skin-tango">
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/1i.jpg?v=<?php echo RELEASE; ?>" alt="" width="200" height="52" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/4i.jpg?v=<?php echo RELEASE; ?>" alt="" width="187px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/5i.jpg?v=<?php echo RELEASE; ?>" alt="" width="190px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/2i.jpg?v=<?php echo RELEASE; ?>" alt="" width="287" height="52" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/6i.jpg?v=<?php echo RELEASE; ?>" alt="" width="190px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/7i.jpg?v=<?php echo RELEASE; ?>" alt="" width="190px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/8i.jpg?v=<?php echo RELEASE; ?>" alt="" width="218px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/3i.jpg?v=<?php echo RELEASE; ?>" alt="" width="287" height="52" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/9i.jpg?v=<?php echo RELEASE; ?>" alt="" width="190px" height="63px" /></li>
					<li><img src="<?php echo HTTP_ROOT; ?>img/home_a/sld_img/10i.jpg?v=<?php echo RELEASE; ?>" alt="" width="218px" height="63px" /></li>
				  </ul>
				</div>
			</div>
		</div>
	 </div>
</div>
<div class="cb"></div>

<div class="social_med_foot">
	<div>
    	<a target="_blank" title="Twitter" href="https://twitter.com/theorangescrum"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/tw_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
        <a target="_blank" class="fbook" title="Facebook" href="https://www.facebook.com/pages/Orangescrum/170831796411793"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/face_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
		<a target="_blank" class="google" title="Google" href="https://plus.google.com/103991755151199877447" rel="publisher"><img class="lazy" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" data-src="<?php echo HTTP_ROOT; ?>img/home/go_soc_hm.png?v=<?php echo RELEASE; ?>" alt="" /></a>
    </div>
</div>-->

<?php /*?><div class="quote_bg">
	<h1>We Love Our Customers</h1>
    <img class="lazy" data-src="<?php echo HTTP_ROOT;?>img/images/os_client_logo.png?v=<?php echo RELEASE;?>" src="<?php echo HTTP_ROOT; ?>img/loading.gif?v=<?php echo RELEASE; ?>" alt="Loading" />
</div><?php */?>


<a href="javascript:void(0);" id="to_top" style="display:none">
    <img title="Scroll to Top" alt="Scroll to Top" src="../img/scr_top.png?v=183" width="44px" height="58px" style="position:fixed; right:20px; bottom:50px;"/>
</a>
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


<div class="clear"></div><!-- This is a clear fix -->
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
	if( $(window).scrollTop() > 130 && $(window).scrollTop() < 930){
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