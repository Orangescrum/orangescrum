<?php
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en"  xml:lang="en"  xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" href="<?php echo HTTP_ROOT; ?>favicon.ico"/>
<!-- Google Fonts -->
<!-- Modified for specifying cache validator. It is working fine -->
<!-- <link rel="prefetch" type="text/css" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,100" />
<link rel="prefetch" type="text/css" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700" /> -->
<?php 
if(!GA_CODE)
{
?>
	<meta name="robots" content="noindex,nofollow" />
<?php
}
echo $this->element('metadata');
echo $this->Html->meta('icon');

if(PAGE_NAME == "home" || PAGE_NAME == "pricing" || PAGE_NAME == "tour" || PAGE_NAME == "signup" || PAGE_NAME == "privacypolicy" || PAGE_NAME == "securities" || PAGE_NAME == "termsofservice" || PAGE_NAME == "help" || PAGE_NAME == "free_download" || PAGE_NAME == "community" || PAGE_NAME == "roadmap" || PAGE_NAME == "services" || PAGE_NAME == 'enterprise_home')
{
	if($abtest == "a") {
		echo $this->Html->css('index/homepage_new_a.css?v='.RELEASE);
	}
	elseif($abtest == "b_bkp") {
		echo $this->Html->css('index/homepage_new_b.css?v='.RELEASE);
	}
	elseif($abtest == "c") {
		echo $this->Html->css('index/homepage_new_c.css?v='.RELEASE);
	}
	elseif($abtest == "old") {
		echo $this->Html->css('index/homepage_old.css?v='.RELEASE);
	}
	else{
		echo $this->Html->css('index/homepage_new.css?v='.RELEASE);
        if(defined('RELEASE_V') && RELEASE_V){
         //echo $this->Html->css('bootstrap.min.css');
		 if(!SHOW_SIGNUP_POPUP){
			echo $this->Html->css(array('bootstrap-material-design.min.css', 'ripples.min.css', 'jquery.dropdown.css', 'custom_outer.css?v='.RELEASE));
		 }
	}
}
}
else {
	echo $this->Html->css('index/homepage_new.css?v='.RELEASE);
    if(defined('RELEASE_V') && RELEASE_V && (PAGE_NAME == 'login' || PAGE_NAME == 'forgotpassword' || PAGE_NAME == 'downgrade_to_limited_account' || PAGE_NAME == 'os_rev_from_self' || PAGE_NAME == 'community_installation_support')){
        echo $this->Html->css(array(
                'bootstrap.min.css', 
                'bootstrap-material-design.min.css', 
                'ripples.min.css',
                'material-icon',
                'jquery.dropdown.css',
                'custom_outer.css?v='.RELEASE
            )); 
}
}
if(SHOW_SIGNUP_POPUP){
	echo $this->Html->css(array('bootstrap-material-design.min.css','ripples.min.css', 'jquery.dropdown.css')); 
}
echo $this->Html->css('custom_outer.css?v='.RELEASE); 
echo $this->Html->css('css_outer/style.css?v='.RELEASE); 
echo $this->Html->css(array(
        'css_outer/animate.css',
        'css_outer/style-magnific-popup.css',
        'css_outer/fonts.css',
        'css_outer/bootstrap.css',
        'css_outer/layerslider.css',
        'css_outer/social_media.css'
    ));
//echo $this->Html->css('css_outer/animate.css');
//echo $this->Html->css('css_outer/style-magnific-popup.css');
//echo $this->Html->css('css_outer/fonts.css');
//echo $this->Html->css('css_outer/bootstrap.css');
//echo $this->Html->css('css_outer/layerslider.css');
//echo $this->Html->css('css_outer/social_media.css');

if(PAGE_NAME == "help" || PAGE_NAME == "tour" || PAGE_NAME == "free_download" || PAGE_NAME == "community" || PAGE_NAME == "roadmap" || PAGE_NAME == "services") {
	echo $this->Html->css('help');
}
?>
<input type="hidden" id="track_usr_ip" value="<?php echo USER_REAL_IP; ?>" />
<input type="hidden" id="track_usr_dmn" value="<?php echo $_SERVER['SERVER_NAME']; ?>" />
<style type="text/css">
.feddback_btn {
    position: fixed;
    right: -6px;
    top: 40%;
}
.feddback_btn:hover {
    right: -2px;
}
#luckyext__watcher_div {
	top:18% !important;	
}
#luckyext__chat_pre_chat_form input {
	font-family: Muli-regular;
    padding: 8px;
    width: 90%;
}
#luckyext__submit_btn_area input[type="submit"]{
	 background-image: -moz-linear-gradient(center top , #43c86f, #2fb45b) !important;
    border-radius: 5px !important;
    color: #fff !important;
    font-family: 'OPENSANS-REGULAR' !important;
    height: 29px !important;
    padding: 5px !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.7) !important;
    text-transform: uppercase;
    width: 35% !important;
}
#luckyext__submit_btn_area {
	margin-top: 14px !important;
}
#luckyext__chat_box textarea {
	font-size: 14px !important;
}
#luckyext__chat_log {
	font-family: Muli-regular;
}
#luckyext__msg {
	padding: 3px 1px !important;
}
#luckyext_chat_agent_info {
	font-family: MyriadProSemibold;
}
/*#luckext__chat_branding {
	display: none !important;
}*/
#hellobar_container{
	max-height: 38px !important;
}
</style>
<?php /*?><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>js/1.7.2_jquery.min.js "></script><?php */?>

<script type="text/javascript">	
		var emlRegExpRFC = RegExp(
			/^[a-zA-Z0-9.’*+/_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
		);	
    var PROTOCOL = '<?php echo PROTOCOL;?>';
    var DOMAIN = '<?php echo DOMAIN;?>';
    var HTTP_APP = "<?php echo HTTP_APP; ?>";
    var DOMAIN_COOKIE = "<?php echo DOMAIN_COOKIE; ?>";
    
    //For google login and signup start
    var CLIENT_ID = "<?php echo CLIENT_ID; ?>";
    var CLIENT_ID_SIGNUP = "<?php echo CLIENT_ID_SIGNUP; ?>";
    var REDIRECT = "<?php echo REDIRECT_URI; ?>";
    var REDIRECT_SIGNUP = "<?php echo REDIRECT_URI_SIGNUP; ?>";
    //For google login and signup end
    
</script>  
<!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-outer.min.js?v=<?php echo RELEASE; ?>"></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-migrate-1.2.1.min.js?v=<?php echo RELEASE; ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>index/common_outer.js?v=<?php echo RELEASE; ?>" defer></script>
<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>material.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dropdown.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>ripples.min.js" defer></script>
<!-- Modified for specifying cache validator -->
<!-- <link rel="prefetch" type="text/css" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/icon?family=Material+Icons" /> -->
<script src="<?php echo JS_PATH; ?>outer_js/jquery.magnific-popup.min.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/jquery.nav.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/jquery.scrollTo-min.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/SmoothScroll.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/wow.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/custom.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/plugins.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/layerslider.kreaturamedia.jquery.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/layerslider.transitions.js" defer></script>
<script src="<?php echo JS_PATH; ?>outer_js/greensock.js" defer></script>
    
<?php } ?>

<!-- Google drive starts-->
<!--<script type="text/javascript" src="<?php echo JS_PATH; ?>google_signin.js"></script>-->

<?php //if(defined('USE_LOCAL') && USE_LOCAL==1) {?>
<!--<script src="<?php echo JS_PATH; ?>jsapi.js"></script>
<script src="<?php echo JS_PATH; ?>client.js"></script>-->
<?php //} else {?>
<!--<script src="https://www.google.com/jsapi?key=<?php //echo API_KEY; ?>"></script>
<script src="https://apis.google.com/js/client.js" defer></script>-->
<?php //}?>
<!-- Google drive ends-->

<?php //if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com") && !$this->Session->read('Auth.User.id')){ ?>
<!--Start of Zopim Live Chat Script-->
<?php /*?><script type = "text/javascript" >
    window.$zopim || (function (d, s) {
        var z = $zopim = function (c) {
            z._.push(c)
        }, $ = z.s =
                d.createElement(s),
            e = d.getElementsByTagName(s)[0];
        z.set = function (o) {
            z.set.
            _.push(o)
        };
        z._ = [];
        z.set._ = [];
        $.async = !0;
        $.setAttribute('charset', 'utf-8');
        $.src = '//v2.zopim.com/?1aJJ4FyYdn5drd6au0PJYsFwepoHa9rD';
        z.t = +new Date;
        $.
        type = 'text/javascript';
        e.parentNode.insertBefore($, e)
    })(document, 'script'); 
</script><?php */?>
<!--End of Zopim Live Chat Script-->
<?php //} ?>

<?php
$org_social_pages = array("free_download", "community", "services", "roadmap");
if(in_array(PAGE_NAME, $org_social_pages)) { ?>
<!--<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js" defer></script>
<script type="text/javascript">stLight.options({publisher: "0bef34e8-d1f9-4378-ae96-deebcd1afc67", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>-->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=344031535737414&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<?php } ?>
<script type="text/javascript">
function setSessionStorageOuter(StorageRefer, StorageEvent){
	// Save data to sessionStorage
    sessionStorage.setItem('SessionStorageReferValue', StorageRefer);
    sessionStorage.setItem('SessionStorageEventValue', StorageEvent);
}

function trackEventLeadTrackerOuter(event_name, eventRefer, email_id){
    return true;
}
</script>
</head>
<?php flush(); ?>
<body class="head_back" id="headbody">
	<div id="cover" class="outer" style="filter:alpha(opacity=50);"></div>
	<?php
	if(PAGE_NAME != "login" && PAGE_NAME != "forgotpassword" && PAGE_NAME != "launchpad" && PAGE_NAME != "invitation" && PAGE_NAME != 'downgrade_to_limited_account' && PAGE_NAME != 'community_addon_download' && PAGE_NAME != 'community_installation_support') {
		echo $this->element('header_outer');
	}
	echo $content_for_layout;
	if(PAGE_NAME != "login" && PAGE_NAME != "forgotpassword" && PAGE_NAME != "signup" && PAGE_NAME != "pricing" && PAGE_NAME != "launchpad" && PAGE_NAME != "invitation" && PAGE_NAME != 'downgrade_to_limited_account' && PAGE_NAME != 'community_addon_download' && PAGE_NAME != 'community_installation_support') {
		echo $this->element('footer_outer');
	}
	if(GA_CODE == 1 && (PAGE_NAME != "launchpad" && PAGE_NAME != "login" && PAGE_NAME != "invitation" && PAGE_NAME != "confirmation") && (!$_GET['case'] && !$_GET['project'])){?>
	<!-- GA CODE -->
    <?php
    }
?>
        
<script type="text/javascript">
$(function(){
    $.material.init();
	var uri = window.location.href;
	var uri_blog = uri.substr(-12);
	if(uri_blog.toLowerCase() == 'googlesignup'){
		signinWithGoogle();
	}
});
</script>
<?php
$clientIP = USER_REAL_IP;
$urlVisit = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$domain = $_SERVER['SERVER_NAME'];
?>
<script language="javascript" type="text/javascript">
function setSuptrackCookie(cname, cvalue, exdays) {
    localStorage.setItem(cname, cvalue);
}
function getSuptrackCookie(cname) {
    n= (typeof localStorage.getItem(cname) != 'undefined') ? localStorage.getItem(cname):'';
    return n;
}
</script>
</body>
</html>
