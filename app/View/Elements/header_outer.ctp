<?php echo $this->Html->script("jquery.bxslider");?>
<?php echo $this->Html->css("jquery.bxslider");?>
<style>
.top_land_menu ul li .header-down-arw{background:url(../img/header-arrow-down.png) no-repeat;width:15px;height:10px;display:inline-block;position:relative;background-position:0px 0px;left:-8px;top:3px;background-size:11px 7px}
.customnav-downarrow .how-sub-menu {position:absolute;width: 225px;
height: auto;left:0;top:70px;z-index:1;max-height:0;overflow:hidden;
-webkit-transform:perspective(400) rotate3d(1,0,0,-90deg);-moz-transform:perspective(400) rotate3d(1,0,0,-90deg);-ms-transform:perspective(400) rotate3d(1,0,0,-90deg);
transform:perspective(400) rotate3d(1,0,0,-90deg);-webkit-transform-origin:50% 0;
-moz-transform-origin:50% 0;-ms-transform-origin:50% 0;
transform-origin:50% 0;-webkit-transition:350ms;-moz-transition:350ms; -ms-transition:350ms;
transition:350ms;text-indent: 12px;background-image: -webkit-linear-gradient(top, #395376, #4C6D9A);background-image: -moz-linear-gradient(top, #395376, #4C6D9A);
background-image: -ms-linear-gradient(top, #395376, #4C6D9A);background-image: -o-linear-gradient(top, #395376, #4C6D9A);background-image: linear-gradient(to bottom, #395376, #4C6D9A);filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#395376, endColorstr=#4C6D9A);}
.how-hover:hover .how-sub-menu{max-height:1000px;
-webkit-transform:perspective(400) rotate3d(0,0,0,0);
-moz-transform:perspective(400) rotate3d(0,0,0,0);
-ms-transform:perspective(400) rotate3d(0,0,0,0);
z-index:9}
.navbar-default .navbar-nav > li > a.fst-a-txt, .navbar-default .navbar-nav > li:hover > a.fst-a-txt{color:#555 !important}
.customnav-downarrow ul.navbar-right li.fst-li:hover, .customnav-downarrow ul.navbar-right li.fst-li.active{background:#eef0f1;}
.customnav-downarrow .how-sub-menu ul li a{color:#fff;
    display: block; font-size: 13px;font-weight: 600;height: auto;
    line-height: 16px;margin: 0;padding: 10px 0;
    border-bottom: 1px solid #6E8296;text-transform: capitalize;}
.customnav-downarrow .how-sub-menu ul li:hover a{color:#555;background:#eef0f1}
.customnav-downarrow .how-sub-menu ul li:last-child:hover a{box-shadow:inset 0px -5px 5px 0px #ccc}
.customnav-downarrow .how-sub-menu ul li:first-child a{padding:12px 0 10px}
.customnav-downarrow .how-hover.menu-li{padding:0;margin:0px 5px}
.customnav-downarrow .how-hover.menu-li .how-sub-menu{right:0;left:inherit}
.customnav-downarrow .how-sub-menu ul li:last-child a{border-bottom:none}
.customnav-downarrow .how-sub-menu:before{content:''; width:100%;height:5px;display:block;background:#FF8B1A;position:absolute;top:0px;left:0}
.top_land_menu ul li.rt_new_menu ul{ background: #fff none repeat scroll 0 0;border: 4px solid #d8d8d9;border-radius: 7px;padding: 15px 8px;position: relative;text-align: left; width: 180px;}
.how-sub-menu ul{margin:0}
.how-sub-menu ul li a:hover{color:#228798;}
.how-sub-menu.active ul li a{border:none;}
.how-hover:hover .how-sub-menu{display:block;}
.arrow-img{position:relative;top: -15px;left:10px;padding: 7px 73px 2px 5px;}
#wrapper.menu_outer_hm{width:1011px;}
.how-hover.osource-commu{position:relative;}
.how-hover.serv_smenu{position:relative;}
.how-hover.mplace_smenu{position:relative;}
.how-sub-menu.osource_community{left:0px; top:26px; height:151px;}
.how-hover.serv_smenu .how-sub-menu.osource_community{}
.how-hover.mplace_smenu .how-sub-menu.osource_community{width:175px; height:122px;}
.os_get_involve{position:relative;}
.os_get_involve .how-sub-menu.osource_ginv{left:220px; top:-70px; height:217px;display:none; width:266px;}
.os_get_involve:hover .how-sub-menu.osource_ginv{display:block;}
.os_get_involve .arrow-img{left:-20px; top:40px; padding:30px 7px;}
.cta_btn_footer{margin:45px 0 20px 0px; text-align:center;}
.cta_btn_footer a.btn.btn_blue.btn_orng{text-decoration:none; padding:8px 60px; margin:0px; font-size:28px;}
.how-hover:hover .how-sub-menu {display: block;}
.skype-os{cursor:pointer}
.skype-os > p,.customnav-downarrow ul li .skype-os > p > a{margin:0;padding:0}
.skype-os > p > a > img{margin:28px 0 0!important}
.skype-os ul{right:0px !important;width:100px !important;padding:0 !important;margin-top:5px !important;box-shadow:0px 0px 5px #fff}
.skype-os ul li{border-bottom:2px solid rgb(0, 175, 240)}
.skype-os ul li:last-child{border-bottom:none}
.skype-os ul li:hover{background:rgb(0, 175, 240) !important;}
.skype-os ul li:hover a{color:#fff !important;}
.skype-os ul li a{font-size:12px !important}
.skype-os ul li a:hover{text-decoration:none !important;}

/*fix menu css*/
.header .navbar-fixed-top{min-height:initial;}
.cmpny-logo{width:20%;box-sizing:border-box;padding:0;margin-top:3px}
.navbar > .container .cmpny-logo a.logo{margin:0;float:none;display:block;height:100%;padding:0;text-align:center;}
.cmpny-menu{width:80%;box-sizing:border-box;padding:0 !important;}
.cmpny-menu .navbar-nav.navbar-right{margin-right:0}
.navbar .cmpny-menu .navbar-nav > li > a{padding:10px;line-height:50px}
.navbar .cmpny-menu .navbar-nav > li.active > a, .navbar .cmpny-menu .navbar-nav > li > a:focus,.navbar .cmpny-menu .navbar-nav > li > a:hover{background:transparent;}
.navbar .cmpny-menu .navbar-nav > li > a.purchase{margin:14px 10px 0;padding:0 10px; line-height:40px;border-radius:3px !important}
.how-hover.h-it-work.menu-li.fst-li > a {padding:25px 10px}
.sup_add_new{color:#FF0000;cursor:text;font-size: 10px;position:relative;top:-4px;}
.nav.navbar-nav .down_arrow_icon{position:relative}
.nav.navbar-nav .down_arrow_icon::before{content: "^";display: inline-block;position: relative;
top:0px;-webkit-transform: rotate(180deg) scaleX(2);-moz-transform: rotate(180deg) scaleX(2);transform: rotate(180deg) scaleX(2);
color: inherit;line-height: 1em;font-size:11px; letter-spacing: 0;margin: 0 0 0 5px;}
.navbar-default .navbar-nav > li > a.purchase.purchase_new { background-color: #2eb327; border: 1px solid #2eb327; }
.navbar-default .navbar-nav > li > a.purchase:hover { color: #2eb327!important;background-color: transparent; border: 1px solid #2eb327;}
@media only screen and (max-width:1290px) {
.add_bar .d_tble .d_tbl_cell .up_to_off{font-size:25px}
.add_bar .d_tble .d_tbl_cell .up_to_off span{font-size:30px}
.add_bar .off_subsc_sec{font-size:18px}
}
@media only screen and (max-width:1100px) {
.header .navbar-fixed-top .container{width:100%}
#wrapper.menu_outer_hm{width:90%; margin:0px auto;}
.top_land_menu ul li.first-child{margin-left:100px;}	
.navbar .cmpny-menu .navbar-nav > li > a{font-size:12px;padding:10px 5px}
.add_bar .wrapper{padding-left:70px;padding-right:70px}
.add_bar .d_tble .d_tbl_cell.cell2{padding-right:0;font-size:14px}
.add_bar .d_tble .d_tbl_cell .up_to_off{font-size:24px;line-height:30px}
.add_bar .off_subsc_sec,.add_bar .coupon_sec{font-size:15px}
}
@media only screen and (max-width:850px) {
.top_land_menu ul li.first-child{margin-left:40px;}
.top_land_menu ul li a{margin:0 5px; font-size:13px;}
.logo_landing img{width:150px; height:auto; max-width:100%;}
.container > .navbar-header.cmpny-logo {margin: 0 auto;margin-top: 3px;padding:10px 0;width:98%;}
.cmpny-logo .navbar-toggle{z-index:999;margin-right:-10px}
.cmpny-menu {margin:0 !important;width:100%}
.navbar .cmpny-menu .navbar-nav > li > a,.customnav-downarrow .how-sub-menu ul li a{padding:10px;line-height:26px}
.how-sub-menu{top:48px !important;height:auto !important}
.cmpny-menu .navbar-nav.navbar-right{margin:0}
.add_bar .wrapper{width:95%}
.add_bar .d_tble .d_tbl_cell:nth-child(2){display:table-cell;padding-right:0}
.add_bar .d_tble .d_tbl_cell .up_to_off{font-size:16px}
.add_bar .off_subsc_sec,.add_bar .coupon_sec{font-size:12px}
.add_bar .d_tble .d_tbl_cell .get_discount{font-size:12px;padding:10px 15px}
.add_bar .smalltext + span > span{padding:3px 6px;font-size:14px}
}
@media only screen and (max-width:750px) {
.top_land_menu ul li.first-child{margin-left:10px; padding:7px 0 6px !important;}
.logo_landing img{width:130px;}
.sb_ttl{font-size: 9px !important;}
.top_land_menu ul li.first-child a{padding:4px 7px 6px !important;font-size:12px;}
.navbar > .container .cmpny-logo a.logo{text-align:left}
.add_bar{background-image:none;background: #000046;
background: -webkit-linear-gradient(to right, #1CB5E0, #000046);
background: linear-gradient(to right, #1CB5E0, #000046);}
.add_bar .wrapper{padding-left:0;padding-right:0}
.add_bar .d_tble .d_tbl_cell .up_to_off{font-size:14px}
.add_bar .off_subsc_sec, .add_bar .coupon_sec{font-size:12px}
}
@media only screen and (max-width:500px){
.fl.logo_landing{float:none; text-align:center;}
.fl.logo_landing .sb_ttl{text-align:center;}
.fr.top_land_menu{float:none; margin-top:10px;width: 100%;}
.top_land_menu ul li.first-child a{padding:4px 5px 6px !important;font-size:11px;}
.top_land_menu ul li a{font-size:12px;}
.add_bar{height:auto}
.add_bar .d_tble .d_tbl_cell{display:block !important;width:100% !important;float:none;text-align:center !important}
.add_bar .d_tble .d_tbl_cell .up_to_off{font-size:16px;line-height:20px}
.add_bar .d_tble .d_tbl_cell .up_to_off span{font-size:25px}
.add_bar .off_subsc_sec,.add_bar .coupon_sec{font-size:12px}
.add_bar #clockdiv{margin-top:10px}
.add_bar .smalltext + span > span{font-size:12px}
.add_bar .d_tble .d_tbl_cell .get_discount{margin-bottom:2px}
}
@media only screen and (max-width:400px){
.top_land_menu ul li.first-child{width:100%; display:block;background: none; border:0px; padding:0px !important;  cursor: auto; margin:10px 0px; text-align:right;}
.top_land_menu ul li.first-child a{border:1px solid #28a752;background-image:-webkit-linear-gradient(top, #43C86F, #2FB45B);background-image: -ms-linear-gradient(top, #43C86F, #2FB45B);background-image: -o-linear-gradient(top, #43C86F, #2FB45B);background-image: linear-gradient(to bottom, #43C86F, #2FB45B); background-image: -moz-linear-gradient(top, #43C86F, #2FB45B); border-radius:5px; margin-right:10px !important;}
.top_land_menu ul li.first-child:hover{background:none;box-shadow:0 0 0px #29a543;box-webkit-box-shadow:0 0 0px #29a543;-moz-box-shadow:0 0 0px #29a543;}
.top_land_menu ul li.rt_new_menu{top:-20px;}
.cmpny-logo .navbar-toggle{margin-right:0}
.container > .navbar-header.cmpny-logo{margin-left:0;margin-right:0;width:100%}
}
</style>
<?php if(CONTROLLER == 'opensource'){ ?>
<style>
	.top_land_menu ul li a{margin:0 9px;}
	.how-sub-menu{height:211px;}
	<?php if(PAGE_NAME == 'add_ons'){ ?>
		.how-sub-menu{height:225px;}
		.how-sub-menu.osource_community{height:163px;}
	<?php } ?>
</style>
<?php } ?>
<div class="wrapper_login">
<input type="hidden" name="pageurl" id="pageurl" value="<?php echo HTTP_ROOT; ?>" size="1" readonly="true"/>
<input type="hidden" name="pageurlhome" id="pageurlhome" value="<?php echo HTTP_HOME; ?>" size="1" readonly="true"/>

<div id="topmostdiv" style="display:block; position:fixed;top: 15%; width:100%; text-align:center;z-index: 2147483647; position:fixed">
	<?php 
	if($success){
	?>
		<div onClick="removeMsg();" id="upperDiv" align="center" style="margin:0px auto;position:relative; text-align:center;margin-top:10px;">
			<span style="position:relative;">
				<span class="topalerts success_flash msg_span" style="font-family:MyriadProSemibold">
					<?php echo $success; ?>
				</span>
			</span>	
		</div>
		<script>setTimeout('removeMsg()',6000);</script>
	<?php
	} 
	elseif($error){
          if(stristr($error,'Object(CakeResponse)')){

          }else{
	?>
		<div onClick="removeMsg();" id="upperDiv" align="center" style="margin:0px auto;position:relative; text-align:center;margin-top:10px;">
			<span style="position:relative;">
				<span class="topalerts error_flash msg_span" style="font-family:MyriadProSemibold">
					<?php echo $error; ?>
				</span>
			</span>	
		</div>
		<script>setTimeout('removeMsg()',6000);</script>
	<?php
	} }
	else{
	?>
		<div onClick="removeMsg();" id="upperDiv" align="center" style="display:none; margin:0px auto;position:relative; text-align:center;margin-top:10px;">
			<span style="position:relative;">
				<span class="topalerts success_flash msg_span" style="font-family:MyriadProSemibold">
					<?php echo $success; ?>
				</span>
			</span>	
		</div>
	<?php
	}
	?>
</div>

<!--<a class="fdbk_tab_right" id="fdbk_tab" href="#contactForm" onClick="randomNum();cover_open('cover','inner_feedback');">FEEDBACK</a>-->
<span class="preload"></span>
<div id="beta"></div>
<?php /*if(PAGE_NAME == "registration" || PAGE_NAME == 'signup'){ ?><div class="top_menu_land" style="display:none"> <?php } else { ?> <div class="top_menu_land"> <?php } */?> 
<!--begin header -->
<?php if(PAGE_NAME != 'signup' && PAGE_NAME != 'pricing'){ ?> 
    <!--begin loader -->
    <?php /* <div id="loader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div> */ ?>
    <!--end loader -->

    <!-- Header begin -->
    <header class="header">

        <!--begin nav -->
        <nav class="navbar navbar-default navbar-fixed-top">
            
            <!--begin container -->
            <div class="container">
        
                <!--begin navbar -->
                <div class="navbar-header pull-left cmpny-logo">
                    <button data-target="#navbar-collapse-02" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                                                    
                    <a href="/" class="navbar-brand brand scrool logo"><img src="<?php echo HTTP_ROOT; ?>img/home_outer/logo.png" alt="Task Management Software" title="Task Management Software" /></a>
                </div>
                        
                <div id="navbar-collapse-02" class="collapse navbar-collapse customnav-downarrow  pull-right cmpny-menu">
                    <ul class="nav navbar-nav navbar-right">			      
                        <?php $how_it_works = array('mobile_app','timelog', 'tour', 'project_management', 'invoice_how_it_works', 'task_groups', 'kanban_view', 'catch_up'); ?>
                        <li class="how-hover h-it-work fst-li <?php if(in_array(PAGE_NAME, $how_it_works)) { ?> active <?php } ?>"><a class="fst-a-txt" href="<?php echo HTTPS_HOME; ?>how-it-works<?php echo $ablink; ?>">How It Works
                        <sup class="new_blink"></sup></a>
					<span class="header-down-arw"></span>
					<div class="how-sub-menu">
							<!--<span class="arrow-img">
								<img src="<?php echo HTTP_ROOT; ?>img/home<?php echo $image_path; ?>/arw_top.png"/>
							</span>-->
							<ul>
								<li><a href="<?php echo HTTPS_HOME; ?>mobile-app<?php echo $ablink; ?>">Mobile APP<span style="color:#FF0000;cursor:text;font-size: 10px;position:relative;top:-4px;">&nbsp;New</span></a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>slack-integration<?php echo $ablink; ?>">Slack Integration<span style="color:#FF0000;cursor:text;font-size: 10px;position:relative;top:-4px;">&nbsp;New</span></a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>project-management<?php echo $ablink; ?>">Project Management</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>time-log<?php echo $ablink; ?>">Time Log</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>invoice-how-it-works<?php echo $ablink; ?>">Invoice</a></li>
							<?php	/* <li><a href="<?php echo HTTPS_HOME; ?>cost-tracking<?php echo $ablink; ?>">Cost Tracking</a></li> */ ?>
								<li><a href="<?php echo HTTPS_HOME; ?>task-groups<?php echo $ablink; ?>">Task Groups</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>kanban-view<?php echo $ablink; ?>">Kanban View</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>catch-up<?php echo $ablink; ?>">Daily Catch Up</a></li>
							</ul>
					</div>
				</li>
				
                <li class="how-hover h-it-work fst-li <?php if(CONTROLLER == 'pages' && PAGE_NAME == 'success_story'){?>active<?php } ?>"><a class="fst-a-txt" href="<?php echo HTTPS_HOME; ?>success-story/">Success Story</a></li>
				<!--<li <?php if(PAGE_NAME == "free_download") { ?>class="active"<?php } ?>>
				    <a href="<?php echo $downloadlink; ?><?php echo $referrer_link; ?>">Download</a>
				</li>-->
				<li class="fst-li" style="<?php if(CONTROLLER == 'opensource'){echo 'display:none;';}?>" class="<?php if(PAGE_NAME == "pricing") { ?>active<?php } ?>">
					<a class="fst-a-txt" href="javascript:void(0);" onclick="regularsignuppricing();">Pricing</a>
				</li>  
				<li style="<?php if(CONTROLLER != 'opensource'){echo 'display:none;';}?>" class="how-hover serv_smenu <?php if(PAGE_NAME == 'services' && CONTROLLER == 'opensource'){ ?>active<?php } ?>">
					<a href="<?php if(CONTROLLER == 'opensource'){ echo HTTP_HOME_ORG.'services'; }?>"> <?php if(CONTROLLER == 'opensource'){ ?>Services <?php } ?></a>
					<div class="how-sub-menu osource_community">
						<span class="arrow-img">
							<img src="<?php echo HTTP_ROOT; ?>img/home<?php echo $image_path; ?>/arw_top.png"/>
						</span>
						<ul>
							<li><a href="<?php echo HTTP_HOME_ORG.'services-consulting'; ?>" >Consulting</a></li>
							<li><a href="<?php echo HTTP_HOME_ORG.'services-customization'; ?>">Customization</a></li>
							<li><a href="<?php echo HTTP_HOME_ORG.'services-orangescrum-at-your-premises'; ?>">On Premises</a></li>
							<li><a href="<?php echo HTTP_HOME_ORG.'services-training'; ?>">Training</a></li>
							<li><a href="<?php echo HTTP_HOME_ORG.'services'; ?>#our_supt_plan">Our Support Plans</a></li>
						</ul>
					</div>
				</li>            
				
								
				<?php if(CONTROLLER == 'opensource'){ ?>
				
				<li class="how-hover mplace_smenu <?php if(CONTROLLER == 'opensource' && PAGE_NAME == 'add_ons'){?>active<?php } ?>"><a href="<?php echo HTTP_HOME_ORG.'add-on'; ?>">Marketplace</a>
					<div class="how-sub-menu osource_community">
						<span class="arrow-img">
							<img src="<?php echo HTTP_ROOT; ?>img/home<?php echo $image_path; ?>/arw_top.png"/>
						</span>
						<ul>
							<li><a href="<?php echo HTTP_HOME_ORG.'add-on/timelog'; ?>" >Time Log</a></li>
							<li><a href="javascript:void(0)" style="cursor:default; text-decoration:none;">Invoice</a></li>
							<li><a href="javascript:void(0)" style="cursor:default; text-decoration:none;">Task Status Group</a></li>
							<li><a href="javascript:void(0)" style="cursor:default; text-decoration:none;">API</a></li>
						</ul>
					</div>	
				</li>  
				<?php }else{ ?>
				<li class="fst-li"><a class="fst-a-txt" target="_blank" href="http://blog.orangescrum.com">Blog</a></li>
				<?php } ?>		
				
				<?php if(CONTROLLER == 'opensource'){ ?>
					<li class="how-hover osource-commu <?php if(PAGE_NAME == "community") { ?> active <?php } ?>">
						<a href="<?php echo HTTP_HOME_ORG.'community'; ?>">Community</a>
						<div class="how-sub-menu osource_community">
							<span class="arrow-img">
								<img src="<?php echo HTTP_ROOT; ?>img/home<?php echo $image_path; ?>/arw_top.png"/>
							</span>
							<ul>
								<li><a href="https://groups.google.com/forum/#!forum/orangescrum-community-support"  target="_blank">Forums</a></li>
								<li><a href="<?php echo HTTP_HOME_ORG.'get-involved'; ?>" >Get Involved</a></li>
								<li  class="os_get_involve">
									<a href="<?php echo HTTP_HOME_ORG.'installation-guide'; ?>" >Installation Guide</a>
									<div class="how-sub-menu osource_ginv">
										<span class="arrow-img">
											<img src="<?php echo HTTP_ROOT; ?>img/home<?php echo $image_path; ?>/arw_lft.png"/>
										</span>
										<ul>
											<li><a href="<?php echo HTTP_HOME_ORG.'general-installation-guide'; ?>">General Installation Guide</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-timelog-addon-in-orangescrum'; ?>">Orangescrum Time Log Add-on</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-orangescrum-on-windows-using-xampp'; ?>">Orangescrum On Windows</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-orangescrum-in-nginx'; ?>">Orangescrum On NGINX</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-orangescrum-in-godaddy'; ?>">Orangescrum On GoDaddy</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-orangescrum-on-centos'; ?>">Orangescrum On CentOS</a></li>
											<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-orangescrum-on-mac'; ?>">Orangescrum On Mac</a></li>
											<!--<li><a href="<?php echo HTTP_HOME_ORG.'how-to-install-api-addon-in-orangescrum'; ?>">Orangescrum On API</a></li>-->
										</ul>
									</div>
								</li>
								<li><a href="<?php echo HTTP_HOME_ORG.'faq'; ?>">FAQ</a></li>
								<li><a href="javascript:void(0)" class="con_team">Contact the Team</a></li>
							</ul>
						</div>
					</li> 
					<?php }else{ ?>
					<li class="fst-li"><a class="fst-a-txt" href="<?php echo HTTP_APP; ?>users/login">Log In</a></li>
				<?php } ?>			
				<li><a href="javascript:void(0);" onclick="regularsignup();" class="purchase">Sign up Free!</a></li>
                        <li class="how-hover h-it-work menu-li fst-li">
                            <a href="javascript:void(0)"><span class="line-menu fst-a-txt"></span></a>
					<div class="how-sub-menu rt_smenu_n">
							<ul>
								<?php if(CONTROLLER == 'opensource'){ ?>
									<li><a href="<?php echo HTTPS_HOME.'users/login'; ?>">SaaS Login</a></li>
									<?php }else{ ?>
									<li><a href="<?php echo HTTP_HOME_ORG; ?>">Opensource</a></li>								
									<li><a href="<?php echo HTTPS_HOME; ?>updates">Product Updates</a></li>
									<li><a href="<?php echo HTTPS_HOME; ?>compare-orangescrum/">Compare Orangescrum</a></li>
								<?php } ?>
								<li><a target="_blank" href="http://blog.orangescrum.com">Blog</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>aboutus<?php echo $ablink; ?>">About Us</a></li>
								<?php if(stristr(HTTP_ROOT, '.org')){ ?>
								<li><a href="http://demo.orangescrum.org/">Open Source Demo</a></li>
								<?php } ?>
								<?php if(CONTROLLER == 'opensource'){ ?>
									<?php }else{ ?>
									<li><a href="<?php echo HTTPS_HOME; ?>affiliates<?php echo $ablink; ?>">Affiliate Program</a></li>
								<?php } ?>								
								<li><a href="<?php echo HTTPS_HOME; ?>help<?php echo $ablink; ?>">Help</a></li>
								<li><a href="<?php echo HTTPS_HOME; ?>securities<?php echo $ablink; ?>">Security</a></li>
								<?php if(CONTROLLER == 'opensource'){ ?>
								<li><a href="<?php echo $roadmaplink; ?><?php echo $referrer_link; ?>">Roadmap</a></li>
									<?php }else{ ?>
									<li><a href="javascript:void(0);" onclick="regularsignuppricing();">Pricing</a></li>
									<li><a href="<?php echo HTTP_ROOT; ?>enterprise">Enterprise</a></li>
									<li><a href="<?php echo HTTPS_HOME; ?>how-it-works<?php echo $ablink; ?>">How it Works</a></li>
								<?php } ?>								
							</ul>
					</div>
			</li>
				<li style="position:relative">
					<div id="SkypeButton_Call_andola.omkar_1" class="skype-os"></div>
				</li>
            </ul>
        </div>
                <!--end navbar -->
        <div class="clearfix"></div>                        
    </div>
    		<!--end container -->

        </nav>
    	<!--end nav -->
        
    </header>
    <!--end header -->
<?php } ?>

</div>
<div id="overlay_cnt_con"></div>
<div style="display:none;" class="cnt_con_tm">
	<div class="cls_team_cnt"><img src="<?php echo HTTP_ROOT; ?>img/close.png"/></div>
	<h3>Contact the Orangescrum team</h3>
	<p>We will be glad to help you out. Get in touch with the creators of Orangescrum. We always welcome feedback as it helps us to bring out the best within us. We would like to hear your thoughts or you want to share an idea or simply say Hello!</p>
	<div id="success_msg" style="margin-left:10px;display:none;color:green;"></div>
	<form id="opensource_contact_form" method="post">
		<!--<input type="text" placeholder="Your Name" />-->
		<input id="opensource_contact" type="text" placeholder="Your Email" />
		<input id="opensource_phone" type="text" placeholder="Your Phone#" />
		<textarea id="opensource_message" placeholder="Message"></textarea>
		<button  id="opensource_submit" class="btn btn_blue" type="button">Contact Us</button>
	</form>
</div>


<div style="display:none;" class="cnt_tmonial_frm inht_frm">
	<div class="cls_team_cnt"><img src="<?php echo HTTP_ROOT; ?>img/close.png"/></div>
	<h3>Submit Your Testimonial</h3>
	<p>We want to hear from you! Submit your experience below and we will share it with others. Your Testimonial will get published on the front page of our website. </p>
	<div id="success_msg" style="margin-left:10px;display:none;color:green;"></div>
	<form id="testimonial_form" method="post">
        <div id="success_msg_testimonial" style="margin-left:10px;display:none;color:green;"></div>
		<input id="testimonial_company" type="text" placeholder="Your Company Name" />
		<input id="testimonial_email" type="text" placeholder="Your Email" />
		<input id="testimonial_address" type="text" placeholder="Address" />
		<input id="testimonial_address2" type="text" placeholder="Address2" />
		<textarea id="testimonial_message" placeholder="Tell us about your experience!"></textarea>
		<button  id="testimonial_submit" class="btn btn_blue" type="button">Submit</button>
	</form>
</div>
<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.bxslider').bxSlider({auto: true,autoHover: true,autoControls: true,pause: 6000,touchEnabled:false,pager: false,speed: 2000,
								onSliderLoad: function(currentIndex){
									$(".ctaFtSlider").css("visibility", "visible");
								}
								});
	$("#feature_btn").click(function(event) {
		var scrl_pos=$("#fet").offset().top;
		$('html,body').animate({ scrollTop: scrl_pos }, 1000);
	});
	$("#tour_scroll").click(function(){
		$( 'html, body' ).animate( { scrollTop: 1900 }, 1000 );
	});
	/*$(window).scroll(function() {
		if ( $(window).scrollTop() >67 ){
			$(".top_menu_land").css({height:"53px"});
			$(".s_lg").css({display:"block"});	
			$(".b_lg").css({display:"none"});			
			$(".sb_ttl").css({"font-size":"11px"});			
		} 
		
		else{
			$(".top_menu_land").css({height:"67px"});
			$(".s_lg").css({display:"none"});	
			$(".b_lg").css({display:"block"});			
			$(".sb_ttl").css({"font-size":"12px"});	
		}
		});*/
		
   $(".con_team").click(function(){
		$("#overlay_cnt_con").show();
		$(".cnt_con_tm").show();
	});
	$("#osc_tmonial_frm").click(function(){
		$("#overlay_cnt_con").show();
		$(".cnt_tmonial_frm").show();
	});
	$(".cls_team_cnt img").click(function(){
		$("#overlay_cnt_con").hide();
		$(".cnt_con_tm").hide();
		$(".cnt_tmonial_frm").hide();
	});
	
	
	
	
	
	$(document).keydown(function(e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
		$("#overlay_cnt_con").hide();
		$(".cnt_con_tm").hide();
		$(".cnt_tmonial_frm").hide();
    }
	});	
	
	$('#opensource_submit').click(function(){
        var error = 0;
        if($('#opensource_contact').val()=='' ){
            //alert('Subject cannot be left blank!');
            $('#opensource_contact').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#opensource_contact').css({
                'border':'1px solid #ccc'
            });
        }
        if($('#opensource_message').val() == ''){
            //alert('Message cannot be left blank!');
            $('#opensource_message').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#opensource_message').css({
                'border':'1px solid #ccc'
            });
        }
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var oprnsource_contact_email = $('#opensource_contact').val();
        if (!oprnsource_contact_email.match(emailRegEx)) {
            //alert('Please Enter a valid Email!');
            $('#opensource_contact').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#opensource_contact').css({
                'border':'1px solid #ccc'
            });
        }
        if(error == 1){
            return false;
        }else{
			var email = $("#opensource_contact").val();
			var phone = $("#opensource_phone").val();
			var message = $("#opensource_message").val();
			var url = "<?php echo HTTP_ROOT;?>opensource/contact_team";
			$.post(url, {'email':email, 'phone':phone, 'message':message}, function(res){
				if(res == 1){
					$('#success_msg').text("Thank you for reaching out to us! We will get back to you soon.");
					$('#success_msg').show();
				}else {
					$('#success_msg').text("Sorry, due to some problem your mail can not be sent.");
					$('#success_msg').show();
				}
			});
		}
        $('#show_button').hide();
        $('.morebar_arc_case').show();
    });

    $('#testimonial_submit').click(function(){
        var error = 0;
        if($('#testimonial_company').val()=='' ){
            $('#testimonial_company').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#testimonial_company').css({
                'border':'1px solid #ccc'
            });
        }

        if($('#testimonial_address').val()=='' ){
            $('#testimonial_address').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#testimonial_address').css({
                'border':'1px solid #ccc'
            });
        }

        if($('#testimonial_message').val()=='' ){
            $('#testimonial_message').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#testimonial_message').css({
                'border':'1px solid #ccc'
            });
        }
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var testimonial_email = $('#testimonial_email').val();
        if (!testimonial_email.match(emailRegEx)) {
            $('#testimonial_email').css({
                'border':'1px solid #FF0000'
            });
            error = 1;
        }else{
            $('#testimonial_email').css({
                'border':'1px solid #ccc'
            });
        }
        if(error == 1){
            return false;
        }else{
			var email = $("#testimonial_email").val();
			var company = $("#testimonial_company").val();
			var add = $("#testimonial_address").val();
			var add2 = $("#testimonial_address2").val();
			var message = $("#testimonial_message").val();
			var url = "<?php echo HTTP_ROOT;?>opensource/testimonial";
			$.post(url, {'email':email, 'company':company, 'address':add, 'address2':add2, 'message':message}, function(res){
				if(res == 1){
					$('#success_msg_testimonial').text("Thank you for reaching out to us! We will get back to you soon.");
					$('#success_msg_testimonial').show();
				}else {
					$('#success_msg_testimonial').text("Sorry, due to some problem your mail can not be sent.");
					$('#success_msg_testimonial').show();
				}
			});
		}
        $('#show_button').hide();
        $('.morebar_arc_case').show();
    });
	
});
<?php if(PAGE_NAME != 'signup' && PAGE_NAME != 'pricing'){ ?>
<?php } ?>
function regularsignup(){
	setSessionStorageOuter('Regular Signup From Header Section', 'Signup');
	document.location.href = "<?php echo HTTPS_HOME; ?>signup/free<?php echo $ablink; ?>";
}
function regularsignuppricing(){
    setSessionStorageOuter('Regular Signup From Pricing Link', 'Signup');
    document.location.href = "<?php echo HTTPS_HOME.'pricing'.$ablink; ?>";
}    
</script>
