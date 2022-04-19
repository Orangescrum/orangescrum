<?php if(defined('SES_ID') && SES_ID){ ?>
<style type="text/css">
.help-contact-page .nav-tabs{background:none}
.help-contact-page .wrapper_help{margin:20px auto}
.setting_wrapper.help-contact-page{margin-bottom:70px}
.help-contact-page .tab.tab_comon{padding-right:0px;margin-top:0px;}
.help-contact-page .tab.tab_comon .nav-tabs{margin:0;padding:0;list-style-type:none;border-bottom:2px solid #eee;background:#fff}
.help-contact-page .tab.tab_comon .nav-tabs li{display:inline-block;position:relative;height:auto;width:130px;padding:10px 5px 10px 0;text-align:center}
.help-contact-page .tab.tab_comon .nav-tabs li a .material-icons{font-size:18px;color:#666;margin-right:5px}
.help-contact-page .tab.tab_comon .nav-tabs li:hover::after,.help-contact-page .tab.tab_comon .nav-tabs li.active::after{content:'';position:relative;top:12px;left:0;border-bottom:2px solid #0091EA;display:block}
.help-contact-page .tab.tab_comon .nav-tabs li a{text-decoration:none;color:#333 !important;font-size:14px;padding:0;display:block;font-family:"RobotoDraft-Regular"}
.help-contact-page .tab.tab_comon .nav-tabs li:hover,.help-contact-page .tab.tab_comon .nav-tabs li.active{background:none;
border-bottom: 0 none;border-radius: 0;border:none;padding:10px 5px 10px 0}
.help-contact-page .tab.tab_comon .nav-tabs li{background:none;border:none;}
.help-contact-page .tab.tab_comon .nav-tabs li.active a,.help-contact-page .tab.tab_comon .nav-tabs li.active a:hover, .help-contact-page .tab.tab_comon .nav-tabs li.active a:focus{padding:0}
.help-contact-page .tab.tab_comon .nav-tabs li:hover::before,.help-contact-page .tab.tab_comon .nav-tabs li.active::before{bottom:0px;	left:50%; border: solid transparent;content: " ";height: 0;	width: 0; position:absolute;cursor:pointer;border-color:rgba(0, 145, 234, 0); border-bottom-color: #0091EA; border-width:4px; margin-left:-4px;}
.help-contact-page .customer_support .head{width:100%;text-align:center;margin:20px 0;}
.help-contact-page .head h3 {font-size:18px;color:#333;margin: 0;border-bottom:none}
</style>
<?php $url = HTTP_ROOT."help/"; ?>
<div class="task_listing setting_wrapper help-contact-page">
<div class="tab tab_comon">
	<ul class="nav-tabs mod_wide">
			<li <?php if(PAGE_NAME == 'help'){?>class="active"<?php }?>>
				<a href="<?php echo HTTP_ROOT."help"; ?>">
						<i class="material-icons">&#xE887;</i><?php echo __('Help');?>
				</a>
			</li>
			<li <?php if((PAGE_NAME == 'customer_support') && ($how_work != 1)){?>class="active"<?php }?>>
				<a href="<?php echo HTTP_ROOT."customer-support"?>">
						<i class="material-icons">&#xE0D0;</i><?php echo __('Contact');?>
				</a>
			</li>
			<div class="cb"></div>
	</ul>
</div>

<?php }else{ ?>
<style>
   .active_wrapper_help{border-bottom: 2px solid #ff7200;} 
</style>
<?php $url = HTTP_ROOT."help/"; ?>
<?php if(!defined('SES_ID') || !SES_ID){ ?>
<div class="gray_pattern gray_color help_section" style="<?php if(PAGE_NAME != 'help') { ?>padding-top:80px; <?php } ?>background:#ffffff">
<?php } ?>
    <div class="tab tab_comon">
<ul class="nav-tabs mod_wide">
    <li <?php if(PAGE_NAME == 'help'){?>class="active"<?php }?>>
<a href="<?php echo HTTP_ROOT."help"; ?>">
<div class="fl icon_outer qsn"></div>
<div class="fl">
<?php echo __('Help');?>
</div>
<div class="cb"></div>
</a>
</li>
<li <?php if((PAGE_NAME == 'customer_support') && ($how_work != 1)){?>class="active"<?php }?>>
<?php /*<a href="<?php echo $this->Html->url('/users/customer_support');?>"> */?>
<a href="<?php echo HTTP_ROOT."customer-support"?>">
<div class="fl icon_outer support"></div>
<div class="fl">
<?php echo __('Contact');?>
</div>
<div class="cb"></div>
</a>
</li>
<div class="cb"></div>
</ul>
</div>
<div class="wrapper_help">
<div class="cb" style="margin-bottom:20px;"></div>
<?php } ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>index/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_ROOT; ?>js/jquery.lazy.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("img.lazy").lazy();
		$(".ms_cls img").hover(function(){
			$(this).attr({src:"<?php echo HTTP_IMAGES;?>images/close_hover.png"})
		},function(){
			$(this).attr({src:"<?php echo HTTP_IMAGES;?>images/popup_close.png"});
		});	
	});
</script>

