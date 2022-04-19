<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-Frame-Options" content="deny">
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
    echo $this->Html->css('bootstrap.min.css');
    echo $this->Html->css('bootstrap-material-design.min.css');
    echo $this->Html->css('ripples.min.css');
    echo $this->Html->css('material-icon');
    echo $this->Html->css('jquery.dropdown.css?v='.RELEASE);
    echo $this->Html->css('custom.css?v='.RELEASE);    
    echo $this->Html->css('jquery-ui'); 
    echo $this->Html->css('datepicker/bootstrap-datepicker.min');
    echo $this->Html->css('selectize.default');
    echo $this->Html->css('bootstrap-datetimepicker.css');
	if(CONTROLLER == 'Ganttchart'){
        echo $this->Html->css(array('jquery.ganttView', 'reset'));
    }
}else{
    //Bootstrap core CSS
    echo $this->Html->css('bootstrap.min_2');
    //Add custom CSS here
    echo $this->Html->css('style_new_v5.css?v='.RELEASE);
    echo $this->Html->css('jquery-ui');
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
echo $this->Html->css('img_crop/imgareaselect-animated.css');
echo $this->Html->css('fcbkcomplete');
echo $this->Html->css('pace-theme-minimal');
echo $this->Html->css('prettyPhoto.css');
echo $this->Html->css('jquery.timepicker.css');
//Moved from Create New project ajax request page
echo $this->Html->css('wick_new.css?v='.RELEASE);
        if(PAGE_NAME == "help" || PAGE_NAME=='tour') {
	echo $this->Html->css('help');
}
echo $this->Html->script('angular.min');
echo $this->Html->script('angular-route');
echo $this->Html->script('angular-sanitize');
if(PAGE_NAME == "dashboard") {
    echo $this->Html->css('introjs');
    echo $this->Html->script('intro');
}
if(!defined('USE_LOCAL') || (defined('USE_LOCAL') && USE_LOCAL==0)) {
	$js_arr = array('jquery/jquery-1.10.1.min.js', 'jquery/jquery-migrate-1.2.1.min.js');
	echo $this->Html->script($js_arr);
}else{
    $js_arr = array('jquery.min.js');
    echo $this->Html->script($js_arr);
        
}
echo $this->Html->script('moment',array('defer'));
echo $this->Html->script('datepicker/bootstrap-datepicker.min',array('defer'));
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

<?php if(GA_CODE == 1 && (in_array(PAGE_NAME,array('subscription','pricing','downgrade','upgrade_member')))){ ?>
	<!-- GA CODE -->

<?php } ?>
<!--Onboarding page start here-->       
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet"> 
<style type="text/css">
body,#wrapper{width:100%;margin:0;background:#fff}
.modal-dialog .onboard_page_wrap{background:transparent}
.modal-dialog .onboard_page_wrap .onboad_inp_fld{text-align:center}
.cmn-popup .modal-dialog .modal-content .onboard_modal_body{padding:30px}
.onboard_page_wrap{width:100%;margin:0px auto;position:relative;}
.onboard_page_wrap #err_msg_onboard{margin-top:-15px;text-align:left}
.onboard_page_wrap .step_image{max-width: 300px;margin:30px auto 0;}
.onboard_page_wrap .step_image img{max-width:100%}
.onboard_page_wrap .content_wrap{width:100%;
max-width:1100px;position:relative;margin:0 auto;text-align:center;display: flex;flex-direction: column;
justify-content:center;}
.onboard_page_wrap .content_wrap .onbard_form{display:inline-block;position:relative}
	.onboard_page_wrap .content_wrap .step_count{padding:10px 20px;font-size:16px;line-height:20px;font-weight:600;color:#fff;text-align:center;background:#336699;border-radius:30px;position:absolute;left:0;right:0;top:-20px;width:150px;margin:auto}
.onboard_page_wrap .onboad_field_group{width:300px;margin:0 auto;}
    .onboard_page_wrap .content_wrap .cmn_onbd_sp{background: url(../../img/onboard-sprite.png) no-repeat 0px -134px;width: 46px;height: 48px;display: inline-block;vertical-align: middle;margin-right: 5px;}
.onboard_page_wrap .content_wrap .connect_to_google{text-decoration: none;
    font-size: 12px;color: #555;font-weight: 600;
    padding-left: 40px;display: inline-block;}
.onboard_page_wrap .content_wrap .connect_to_google .email_demo {
    display: block;width: 60px;height: 60px;margin: 0 auto 20px;}
    .onboard_page_wrap .content_wrap .welcome_page{text-align:center}
.onboard_page_wrap .upload_pflimg{background:transparent;
text-align:center;margin:20px auto 30px;}
.onboard_page_wrap .upload_pflimg figure{height:100px;width:100px;position:relative;display:block;margin:0 auto;border-radius:50%;overflow: hidden;}
.onboard_page_wrap .upload_pflimg figure img{position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;max-width:100%;border-radius:50%;}
.onboard_page_wrap .cpfl_img{font-size:16px;line-height:20px;margin:10px 0 5px;display:inline-block}

    .onboard_page_wrap .upload_pflimg .toggle-upld-arrow{background:url(../../img/dropdown-arw.png) no-repeat 0px 0px;width:12px;height:7px;display:block;position:absolute;right:-6px;top:0;bottom:0;margin:auto;cursor:pointer;z-index:9;}
    /*.onboard_page_wrap .upload_pflimg::after{content:'';width:14px;height:14px;border-radius:50%;border:1px solid #ccc;display:block;position:absolute;right:-7px;top:-1px;bottom:0;margin:auto;}*/

    .onboard_page_wrap .upload_img_hangbx .file_input{width:85%;height:85%;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;border-radius:50%;display:block;opacity:0;-moz-opacity:0;filter:Alpha(opacity=0)}
    .onboard_page_wrap .upload_img_hangbx{position:relative;display:none;font-size:12px;line-height:26px;color:#fff;background:#ff8600;padding:0 10px;height:26px;width:105px;margin:10px auto 0;border-radius:4px;cursor:pointer;}
    .onboard_page_wrap .upload_img_hangbx::before{content:'';width:0;height:0;border-left:8px solid transparent;border-right:8px solid transparent;border-bottom: 8px solid #ff8600;position:absolute;left:0;right:0;top:-7px;margin:auto;}
    .onboard_page_wrap .info_txt{font-size:15px;line-height:22px;padding:0;margin:10px 0 15px;;color:#555;}
  .onboard_page_wrap .where_to_you{margin:0;text-align:left}
    .onboard_page_wrap .where_to_you > span{font-size:14px;line-height:18px;display:inline-block;vertical-align:middle;}
    .onboard_page_wrap .loaction_dropdown{display:inline-block;vertical-align:middle;width:100%;position:relative;}
  .onboard_page_wrap .loaction_dropdown::before{content:'';background:url(../../img/custum-sdrop.png) no-repeat 0px 0px;width:8px;height:8px;background-size:100% 100%;display:inline-block;position:absolute;right:10px;top:-5px;bottom:0;margin:auto;pointer-events:none;}
  .onboard_page_wrap .where_to_you .control-label{font-size:13px;color:#888;font-weight:300;position:relative;text-align:left;margin:0}
  .onboard_page_wrap .where_to_you select.form-control{padding-right:30px}
  .onboard_page_wrap .onboad_inp_fld{margin:15px 0}
  .onboard_page_wrap .continue_btn{position:relative;min-width:100px;
display:inline-block;font-size:15px;line-height:26px;color:#fff;font-weight:400;text-transform:capitalize;text-align:center;border:none;padding:0;margin-top:30px;background: #24a90c;letter-spacing: .3px;border-radius:4px;box-shadow: 0 1px 3px rgba(0,0,0,0.3);-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.3);
  -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.3);-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;transition:all 0.5s ease-in-out;-webkit-transition:all 0.5s ease-in-out;-moz-transition:all 0.5s ease-in-out;}
  .onboard_page_wrap .continue_btn input{display:block;width:100%;border:none;background:none;color:#fff;padding:4px 35px 4px 15px;z-index: 1;position: relative;}
  .cmn_onboard_layout .continue_btn.done_btn{padding:0}
  .cmn_onboard_layout .continue_btn.done_btn input{padding:4px 15px 4px 15px}
  
  .onboard_page_wrap .continue_btn::before{content:'';background:url(<?php echo HTTP_ROOT;?>img/right-arrow-white.png) no-repeat 0px -4px;width:20px;height:8px;position:absolute;display:inline-block;top: 2px;
    bottom: 0;margin: auto;right: 18px;}
  .onboard_page_wrap input.continue_btn:hover{background: #20960b;
    box-shadow: 0 1px 6px rgba(0,0,0,0.3);-webkit-box-shadow: 0 1px 6px rgba(0,0,0,0.3);-moz-box-shadow: 0 1px 6px rgba(0,0,0,0.3);}
  .onboard_page_wrap .layout_view aside{display:inline-block;vertical-align:top;margin:0 50px;}
    .onboard_page_wrap .layout_view img{max-width:100%;max-height:100%;cursor:pointer}
  .onboard_page_wrap .team_meber .onboad_inp_fld{padding-left:30px;position:relative}
    .onboard_page_wrap .team_meber figure{width:30px;height:30px;display:inline-block;vertical-align:middle;position:absolute;left:0;top:0;bottom:0;margin:auto;text-align:left}
  .onboard_page_wrap .team_meber .control-label{overflow: hidden;
    text-overflow: ellipsis;width: 200px;white-space: nowrap;}
     .onboard_page_wrap .team_meber figure img{max-height:100%;max-width:100%}
    .onboard_page_wrap .where_to_you select option span{text-transform:uppercase;}
    .onboard_page_wrap .start_your_proj input{display:inline-block;font-size:16px;line-height:20px;color:#fff;font-weight:600;text-transform:capitalize;text-align:center;border:1px solid #5271FF;background:#5271FF;padding:12px 30px;border-radius:2px;-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;}
    .onboard_page_wrap .upgrade_plan{margin:20px 0;padding-left:70px;}
    .onboard_page_wrap .upgrade_plan ul{margin:0;padding:0;list-style-type:none}
    .onboard_page_wrap .upgrade_plan ul li{display:inline-block;position:relative;font-size:13px;text-align:left;vertical-align:middle;}
    .onboard_page_wrap .upgrade_plan ul li:first-child{padding-left:60px;width:60%;}
    .onboard_page_wrap .upgrade_plan ul li:last-child{padding-left:50px;width:37%;}
    .onboard_page_wrap .upgrade_plan ul li .cmn_onbd_sp.user{width:50px;height:45px;background-position:0px 0px;background-size:170px 220px;position:absolute;left:0;top:0;bottom:0;margin:auto;}
    .onboard_page_wrap .upgrade_plan ul li .cmn_onbd_sp.help{width:40px;height:36px;background-position:6px -78px;position:absolute;left:0;top:0;bottom:0;margin:auto;}
    .onboard_page_wrap .upgrade_plan ul li a{text-decoration:underline;line-height:15px;color:#57C1FF;display:block;text-align:left;vertical-align:middle;}
    .onboard_page_wrap .upgrade_plan ul li a.help{display:inline-block;color:#57C1FF;text-decoration:none;font-size:14px;font-weight:600;}
    .onboard_page_wrap .upgrade_plan ul li a.help:hover{color:#57C1FF;}
    .onboard_page_wrap .design_project h3{font-size:18px;line-height:30px;color:#555;margin-bottom:30px;font-weight:500;text-align: center;}
    .onboard_page_wrap .design_project h3 strong{font-weight:600;color:#303030;display:inline-block;vertical-align:middle;display:block}
    .onboard_page_wrap .design_project h3 strong span{display:inline-block;color:#555;}
    .onboard_page_wrap .design_project .dproj_inner{background:#F3F8FA;padding:40px 25px;}
    .onboard_page_wrap .design_project .dproj_inner .input_email_name .full_width{width:100%;}
    .onboard_page_wrap .design_project .dproj_inner .input_email_name label{font-size:13px;color:#555;font-weight:500;display:block;margin-bottom:10px}
    .onboard_page_wrap .design_project .dproj_inner .input_email_name textarea{width:100%;font-size:13px;min-height:50px;padding:5px;background:#fff;border:1px solid #ddd;resize:none}
    .onboard_page_wrap .design_project .dproj_inner .add_btn{color:#fff;font-size:15px;text-decoration:none;text-align:center;background:#0F6CA8;border-radius:3px;width:15%;height:34px;line-height:34px;float:left;display:block;margin-top:29px}
    .onboard_page_wrap .design_project .connect_to_google{text-decoration:none;color:#4F91BE;font-size:13px;font-weight:600;position:relative;margin:10px 0;display:block;}
    .onboard_page_wrap .design_project .connect_to_google .cmn_onbd_sp{background-position:0px -134px;position:relative;width:47px;height:48px;vertical-align:middle;margin-right:5px}
    .onboard_page_wrap .design_project .connect_to_google strong{color:#303030;display:inline-block;margin:0 5px;}
    .onboard_page_wrap .design_project .type_user_tbl{width:100%;margin:0 auto 20px;background:#F9FBFC}
    .onboard_page_wrap .design_project .type_user_tbl table{width:100%;table-layout:fixed;}
    .onboard_page_wrap .design_project .type_user_tbl table tr{border-bottom:1px solid #ccc}
    .onboard_page_wrap .design_project .type_user_tbl table tr td:first-child{width:10%;}
    .onboard_page_wrap .design_project .type_user_tbl table tr td:nth-child(2){width:15%;}
    .onboard_page_wrap .design_project .type_user_tbl table tr td:nth-child(3){width:75%;}
    .onboard_page_wrap .design_project .type_user_tbl table tr td{font-size:12px;vertical-align:middle;color:#555;padding:5px}
    .onboard_page_wrap .design_project .type_user_tbl .cmn_onbd_sp{width:26px;height:25px;}
    .onboard_page_wrap .design_project .type_user_tbl .cmn_onbd_sp.owner{background-position:0px -206px}
    .onboard_page_wrap .design_project .type_user_tbl .cmn_onbd_sp.admin{background-position:0px -246px}
    .onboard_page_wrap .design_project .type_user_tbl .cmn_onbd_sp.client{background-position:0px -287px}
    .onboard_page_wrap .design_project .type_user_tbl .cmn_onbd_sp.user{background-position:0px -328px}
    .onboard_page_wrap .design_project .skip_done a{text-decoration:none;color:#555;font-size:13px;display:inline-block;vertical-align:middle;float:left;}
    .onboard_page_wrap .design_project .skip_done .done{color:#fff;font-size:15px;text-align:center;background:#0F6CA8;border-radius:3px;padding:8px 20px;border: none;line-height:15px;float:right;}
    .onboard_page_wrap .txt_email_no_height{height:auto !important; }
    .mar10{margin-top:10px;}
    .remove_btn{line-height:40px;}
    .onboard_page_wrap .g_btn{margin-bottom:30px}
    .onboard_page_wrap .g_btn a{margin-top:0;margin-bottom:0}
  .onboard_page_wrap a.help{display: block;text-decoration: none;margin-top:15px;font-size: 14px;color:#f77436;font-weight:400;text-align: center;}
  .onboard_page_wrap a.help .material-icons{font-size:22px;margin-right:5px}
  .onboard_page_wrap a.help:hover{text-decoration: none;color:#f3611c;}

   .onboard_page_wrap .select2-container--default .select2-selection--single{background-color: transparent;border:none;border-bottom:1px solid #ccc;border-radius:0px}
   .onboard_page_wrap .select2-container--default .select2-selection--single .select2-selection__rendered{padding-left:5px;text-align:left}
.onboard_page_wrap .sub_ttle{font-size:15px;line-height:25px;color:#555;margin:5px 0 50px;padding:0;}
.onboard_page_wrap .option_to_start{display:block;text-decoration:none;font-size:13px;line-height:20px;color:#333;}
.onboard_page_wrap .option_to_start:hover{text-decoration:none;color:#f3611c}
.onboard_page_wrap .option_to_start figure{display:block;margin:10px auto 0px;}

.cmn_onboad_pop{text-align:center}
.cmn_onboad_pop figure{display:block;margin:0 auto;}
.cmn_onboad_pop .dtbl{width:100%;display:table;table-layout:fixed}
.cmn_onboad_pop .dtbl .dtbl_cel{display:table-cell;padding:0 15px;vertical-align:top}
.cmn_onboad_pop .creat_proj{text-decoration:none;display:block;font-size:13px;line-height:20px;color:#4c75ad}
.cmn_onboad_pop .creat_proj strong{display:block;font-size:15px;line-height:24px;font-weight:500;margin:15px 0;}
.back_next_btn a{display:inline-block;text-decoration:none;font-size:15px;font-weight:400;
text-align:center;border-radius:4px;position: relative;margin:15px 15px 0;padding:0px 20px;height:35px;line-height:35px;vertical-align:middle;border:1px solid #24a90c;}
.back_next_btn a .material-icons{font-size:20px;position:relative;}
.back_next_btn a.back_btn{background:#dfe3e4;color:#888;
border:1px solid #dfe3e4;padding:0 25px 0px 15px;margin-left:0;display:none}
.back_next_btn a.back_btn:hover{background:#c0c5c7;color:#333;}
.back_next_btn a.back_btn .material-icons{left:0px;top-1px}
.back_next_btn a.next_btn{background:#24a90c;color:#fff;padding:0 20px 0px 20px;margin-left:0;margin-right:0}
.back_next_btn a.next_btn:hover{background:#24a90c;color:#fff}
.onboard_page_wrap .proj_name{font-size:20px;line-height:30px;margin:15px 0 0;padding:0}
.onboard_page_wrap .proj_desc{font-size:16px;line-height:28px;color:#555;margin:15px 0 30px;padding:0}



#inner_proj_methodo .cmn_onboad_pop .dtbl .dtbl_cel{padding:30px;border:1px solid transparent}
#inner_proj_methodo .cmn_onboad_pop .dtbl .dtbl_cel:hover{border:1px solid #ff8600;    border-radius: 10px;}
#inner_proj_methodo .cmn_onboad_pop .dtbl .dtbl_cel a{color:#333;line-height:22px}
.cmn_onboard_layout .onboard_sp{background:url(<?php echo HTTP_ROOT;?>img/onboard/onboard-sprite.png) no-repeat 0px 0px;width:22px;height:24px;display:inline-block;vertical-align:middle;margin-right: 5px;}
.cmn_onboard_layout .onboard_sp.user_admin{background-position:0px -82px;position:absolute;
left: 0;top: 10px;}

.onboard_page_wrap .team_meber .form-control{text-align:left;height:35px !important}
.onboard_page_wrap .team_meber .control-label{text-align:left}
.cmn_onboard_layout .optional_ttlp{position:absolute;right:0;top:8px;}
.cmn_onboard_layout .optional_ttlp .material-icons{font-size:20px;color:#ccc;}
.cmn_onboard_layout .optional_ttlp small{font-size: 12px;line-height: 20px;color: #fff;background: #000;border-radius: 5px;position: absolute;right: -5px;width: 200px;padding: 10px 15px;text-align: left;top: 30px;z-index: 1;display: none;}
.cmn_onboard_layout .optional_ttlp small::before{content:'';width:0;height:0;border-left:10px solid transparent;border-right:10px solid transparent;border-bottom:10px solid #000;    position:absolute;right:5px;top:-8px;}
.cmn_onboard_layout .optional_ttlp:hover small{display:block}
 
@media only screen and (max-width:800px){
    .onboard_page_wrap .content_wrap {height:auto;margin: auto auto 30px;max-width:100%;position: relative;width:100%;}
    .modal-dialog{width:95% !important}
    }
    @media only screen and (max-width:400px){
    .onboard_page_wrap .welcome_page h1,.onboard_page_wrap .design_project h3{font-size:22px}
    .onboard_page_wrap .welcome_page h6{font-size:17px}
    .onboard_page_wrap .where_to_you{text-align:left}
    .onboard_page_wrap .loaction_dropdown{margin-left:0;width:100%}
    .onboard_page_wrap .where_to_you > span{display:block;padding: 0 0 10px 10px;}
    .onboard_page_wrap .upgrade_plan{padding-left:0}
    .onboard_page_wrap .upgrade_plan ul li:first-child{display:block;margin-bottom:30px;width:100%}
    .onboard_page_wrap .upgrade_plan ul li:last-child{display:block;width:100%;padding-left:50px;}
    .onboard_page_wrap .upgrade_plan ul li .cmn_onbd_sp.help{left:0}
    .onboard_page_wrap .start_your_proj input{padding:12px 20px;font-size:14px}
    .onboard_page_wrap .design_project .dproj_inner{padding:15px}
    .onboard_page_wrap .design_project .type_user_tbl table tr td{display:block;width:100% !important}  
    }
</style>
<!--Onboarding page end here-->
</head>
<body class="<?php echo $this->Session->read('leftMenuSize')!='' ? $this->Session->read('leftMenuSize') : "big-sidebar";?>">
	<?php
        if(PAGE_NAME == 'help' || PAGE_NAME=='tour' || PAGE_NAME=='updates') {
			$styleClass = 'style="padding-left:0px;"';
			if(PAGE_NAME=='updates'){
				$styleClass = 'style="padding:0px;margin:0px auto;"';
		}
		}
	?>
	<div id="wrapper" <?php echo $styleClass; ?>>
	<?php
            //echo $this->element('maincontent_inner');
            echo $this->fetch('content');
        ?>
	</div>
	<?php	
	echo $this->Html->script('pace.min.js',array('defer'));
	?>
	<script>
        paceOptions = {elements: true};
	$(document).ajaxStart(function(){Pace.restart();});
	$(document).ajaxStop(function(){Pace.stop();});
    </script>
	<?php	
	 if(GA_CODE == 1){  ?>
	 <?php /* ?>
	<!-- GA CODE -->
    <script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-24950841-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
	<?php */ ?>
	<?php
	}
	?>
<?php /*if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com") && (PAGE_NAME == "customer_support" || PAGE_NAME == "help")) { ?>
<script type='text/javascript'>window.__wtw_lucky_site_id=24459;(function(){var wa=document.createElement('script');wa.type='text/javascript';wa.async=true;wa.src=('https:'==document.location.protocol?'https://ssl':'http://cdn')+'.luckyorange.com/w.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(wa,s);})();</script>
<?php }*/ ?>
</body>
</html>