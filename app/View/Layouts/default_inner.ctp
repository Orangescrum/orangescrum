<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php echo $this->element('metadata'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
 <!--<base href="/" />-->
<?php 
echo $this->Html->meta('icon');
?>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/print.css" type="text/css" media="print" />
<?php
if(defined('RELEASE_V') && RELEASE_V){
echo $this->Html->css('material-icon');
// echo $this->Html->css('bootstrap.min.css');
    echo $this->Html->css('bootstrap.min.css');
    echo $this->Html->css('bootstrap-material-design.min.css');
    echo $this->Html->css('ripples.min.css');
    echo $this->Html->css('jquery.dropdown.css?v='.RELEASE);
		echo $this->Html->css('custom.css?v='.RELEASE);
		echo $this->Html->css('custom_new.css?v='.RELEASE);
    echo $this->Html->css('custom_theme.css?v='.RELEASE);
    echo $this->Html->css('jquery-ui.css?v='.RELEASE); 
    echo $this->Html->css('datepicker/bootstrap-datepicker.min');
    echo $this->Html->css('selectize.default');
    echo $this->Html->css('select2.min');
    echo $this->Html->css('bootstrap-datetimepicker.css');
	if(CONTROLLER == 'Ganttchart'){
        echo $this->Html->css(array('jquery.ganttView', 'reset'));
    }
	if(CONTROLLER == 'easycases'){
        echo $this->Html->css(array('project_overview.css?v='.RELEASE));
    }	
}else{
    //Bootstrap core CSS
    echo $this->Html->css('bootstrap.min_2');
    //Add custom CSS here
    echo $this->Html->css('style_new_v5.css?v='.RELEASE);
    echo $this->Html->css('jquery-ui.css?v='.RELEASE);
}
if(PAGE_NAME == "dashboard"){
    echo $this->Html->css('jquery.contextMenu.min');
}
if(PAGE_NAME == "mydashboard" || PAGE_NAME == "dashboard" || PAGE_NAME=='milestonelist' || PAGE_NAME=='user_detail' || (CONTROLLER == 'projects' && PAGE_NAME == 'manage')) {
	echo $this->Html->css('jquery.jscrollpane');
        echo $this->Html->css('angular_select'); 
        echo $this->Html->css('xeditable.min.css'); 
        echo $this->Html->css('select2.css'); 
}
if(PAGE_NAME == "profile" || PAGE_NAME =="manage") {
	echo $this->Html->css('img_crop/imgareaselect-animated.css');
}
echo $this->Html->css('fcbkcomplete');
echo $this->Html->css('pace-theme-minimal');
echo $this->Html->css('prettyPhoto.css?v='.RELEASE);
echo $this->Html->css('jquery.timepicker.css');
echo $this->Html->css('jquery.bxslider');
//Moved from Create New project ajax request page
echo $this->Html->css('wick_new.css?v='.RELEASE);
        if(PAGE_NAME == "help" || PAGE_NAME=='tour') {
	echo $this->Html->css('help');
}
if(PAGE_NAME == "dashboard") {
	/*echo $this->Html->css('introjs');
	echo $this->Html->script('intro');*/
}
if(!defined('USE_LOCAL') || (defined('USE_LOCAL') && USE_LOCAL==1)) {
	$js_arr = array('jquery/jquery-1.10.1.min.js', 'jquery/jquery-migrate-1.2.1.min.js');
	echo $this->Html->script($js_arr);
}else{
    $js_arr = array('jquery.min.js');
    echo $this->Html->script($js_arr);
}
echo $this->Html->script('moment',array('defer'));
echo $this->Html->script('datepicker/bootstrap-datepicker.min',array('defer'));
echo $this->Html->script('angular.min');
echo $this->Html->script('angular-route');
echo $this->Html->script('angular-sanitize',array('defer'));
echo $this->Html->script('angular-animate',array('defer'));
echo $this->Html->script('jquery.bxslider.min',array('defer'));
?>
<?php echo $this->Html->script('jquery.autogrowtextarea.min',array('defer'));?>
<!--[if lte IE 9]>
    <style>
        body {font-family: 'Arial';}
        .col-lg-3 .btn.gry_btn.smal30{padding-left:15px;}
        .task_ie_width {width:4%;}
    </style>
<![endif]-->
<!--[if lte IE 8]>
   <link href="<?php echo CSS_PATH; ?>ie_lte_8.css" rel="stylesheet">
<![endif]-->
<!--[if lte IE 7]>
   <style>
   	.top_nav2{margin-top:0px;}
    .filters ul li.filter_cb{width:0px; height:0px; margin:0px;}
    .drp_flt{display:inline-block; float:none;}
    .navbar-form.navbar-left.top_search{padding:0px;}
   </style>
<![endif]-->

<script type="text/javascript">
	var emlRegExpRFC = RegExp(
			/^[a-zA-Z0-9.’*+/_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
		);
  if (typeof jQuery == 'undefined') {
	 document.write(unescape("%3Cscript src='<?php echo JS_PATH; ?>jquery-1.10.1.min.js' type='text/javascript'%3E%3C/script%3E"));
	 document.write(unescape("%3Cscript src='<?php echo JS_PATH; ?>jquery-migrate-1.2.1.min.js' type='text/javascript'%3E%3C/script%3E"));
  }
</script>

<?php
    /*//Bootstrap core JavaScript
    $js_files = array( 'bootstrap.min.js', 'modernizer.js');
    echo $this->Html->script($js_files,array('defer'));*/
?>
<style>  
@media all and (-ms-high-contrast:none) {
	.rht_content_cmn {padding-left:170px;}
 }
</style>
<!--[if lte IE 9]>
<style>  
	.rht_content_cmn {padding-left:170px;}
</style>
<![endif]-->
<script language="javascript" type="text/javascript">
function trackEventLeadTrackerGetting(event_name, eventRefer, email_id){
    return true;
}
</script>
<?php if(GA_CODE == 1 && (in_array(PAGE_NAME,array('subscription','pricing','downgrade','upgrade_member','confirmationPage')))){ ?>
	<!-- GA CODE -->
<?php } ?>
</head>
<body onload="showNotifications();" class="<?php if($this->Session->read('leftMenuSize')!='') {echo  $this->Session->read('leftMenuSize'); if($this->Session->read('leftMenuSize') =='mini-sidebar'){ echo ' menu_squeeze';} }else { echo "big-sidebar";} ?> <?php if(isset($_COOKIE['FIRST_INVITE_1']) && $_COOKIE['FIRST_INVITE_1']==1 && PAGE_NAME=='dashboard'){ echo 'onboard_overlay';}?><?php if(!empty($usrdata['User']['verify_string']) && (PAGE_NAME != "profile") && (!isset($_COOKIE['email_varify']))){ ?>open_hellobar <?php } ?> project-<?php echo $_SESSION['project_methodology']; ?>">
	<?php
        if(PAGE_NAME == 'help' || PAGE_NAME=='tour' || PAGE_NAME=='updates') {
			$styleClass = 'style="padding-left:0px;"';
			if(PAGE_NAME=='updates'){
				$styleClass = 'style="padding:0px;margin:0px auto;"';
		}
		}
	?>
	<?php /* if(!empty($usrdata['User']['verify_string']) && (PAGE_NAME != "profile")){ ?>
	<div class="fixed-n-bar" style="display:none">
		<div class="text-center">
			<?php echo __('Please confirm your email address');?>: <span style="font-weight:bold;"><?php echo $usrdata['User']['email']; ?></span> &nbsp;&nbsp;&nbsp;<span class="resend-email"><a href="<?php echo HTTP_ROOT."users/resend_confemail"; ?>" onclick="return trackEventLeadTracker('Top Alert','Resend Email','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Resend email.</a></span>&nbsp;&nbsp;&nbsp; <span class="change-email"><a href="<?php echo HTTP_ROOT."users/profile"; ?>" onclick="return trackEventLeadTracker('Top Alert','Change Your Email','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Change your email');?>.</a></span>
			<span class="fr" style="background-color:#FFE5CA;margin-right:30px;width:20px;display:block;position:relative;top:-4px;">
				<a id="closevarifybtn" href="javascript:void(0);" class="close" onclick="closeemailvarify('<?php echo $usrdata['User']['id']; ?>')">
					<i class="material-icons">&#xE14C;</i>
				</a>
			</span>
		</div>
	</div>
<?php } */ ?>
	<div id="wrapper" <?php echo $styleClass; ?>>
	<?php 
      if(defined('COMP_LAYOUT') && COMP_LAYOUT){
					echo $this->element('header_inner_v2',array('theme_settings'=>$theme_settings));
				}else{
					echo $this->element('header_inner',array('theme_settings'=>$theme_settings));
				}
        if(defined('COMP_LAYOUT') && COMP_LAYOUT){
				echo $this->element('maincontent_inner_v2',array('theme_settings'=>$theme_settings));
			}else{
				echo $this->element('maincontent_inner',array('theme_settings'=>$theme_settings));
			}
            if(PAGE_NAME=='tour') {
                echo $this->element('help_tabbs');
            }
            //echo $this->fetch('content');
        ?>
	</div>
	<?php
	if(defined('COMP_LAYOUT') && COMP_LAYOUT){
		echo $this->element('footer_inner_v2');
	}else{
	echo $this->element('footer_inner');
	}
	echo $this->Html->script('pace.min.js',array('defer'));
	?>
	<script>
        paceOptions = {elements: true};
	$(document).ajaxStart(function(){Pace.restart();});
	$(document).ajaxStop(function(){Pace.stop();});
    </script>
</body>
</html>