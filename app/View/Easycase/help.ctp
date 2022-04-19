<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('.accordionButton').click(function(){
        $('.accordionContent').slideUp(300);
		$(".open_list").addClass("plus");
        if($(this).next().is(':hidden') == true) {
            $(this).next().slideDown(300);
			$(this).children().children(".open_list").removeClass("plus");
         }
     });
    $('.accordionContent').hide();
	$(".open_list:first").removeClass("plus"); //First time the content will be stayed open
	$('.accordionButton:first').next().slideDown('slow');
});

function validate()
{
	if($("#search_help_txt").val() == ''){
		return false;
	}else{
		return true;
	}
}
function open_timelog(){
        if(typeof SES_ID != 'undefined'){
            window.location = "<?php echo HTTP_ROOT; ?>dashboard#timelog";
        }else{
            window.location = "<?php echo HTTP_ROOT; ?>users/login";
        }
}
function open_invoice(){
        if(typeof SES_ID != 'undefined'){
            window.location = "<?php echo HTTP_ROOT; ?>easycases/invoice";
        }else{
            window.location = "<?php echo HTTP_ROOT; ?>users/login";
        }
}
</script>
<?php if(defined('SES_ID') && SES_ID){ ?>
<style type="text/css">
.left_panel_list{width:25%;margin-right:20px;box-sizing:border-box}
#display_div.right_panel_list{width:70%;box-sizing:border-box}
</style>
	<?php echo $this->element('help_tabbs');?>
	
	<div class="wrapper_help">
	<div class="help-type-hd" style="font-size:17px;text-align:center;color:#666666;"><?php echo __('Welcome to the Orangescrum knowledge base');?>.</div>
	<div style="font-size:17px;text-align:center;color:#666666;"><?php echo __('What can we help you with today');?>?</div>
	
	<div class="search_help">
		<center>
			<form name="search_help_form" action="<?php echo $url; ?>">
				<div style="position:relative;width:370px;">
				<input type="text" placeholder="<?php echo __('Enter question or keyword');?>" value="<?php echo urldecode(trim(@$_GET['search_help_txt'])); ?>" name="search_help_txt" id="search_help_txt"/>
				<button class="search_icon fr" onClick="return validate();"></button>
				</div>
			</form>
		</center>
	</div>
	<div class="left_panel_list fl">
		<h3><?php echo __('Category');?></h3>
		<ul>
			<?php foreach ($allSubjectData as $key => $value) {
					if($key == (count($allSubjectData) - 1)){
						$classLast = 'class="last"';
					}else{
						$classLast = '';
					}
					
					if($subjectId == $value['Subject']['id'] && trim(@$_GET['search_help_txt']) == ''){
						$selectColor = 'color:#4F92BF';
					}else{
						$selectColor = '';
					}
			?>
				<li <?php echo $classLast; ?>>
                    <?php $subject = preg_replace('/[\s]+/','-',preg_replace('/[&]+/','',strtolower($value['Subject']['subject_name'])));?>
					<a href="<?php echo HTTP_ROOT."help-".$subject."-".$value['Subject']['id'];?>" style="outline:none;<?php echo $selectColor; ?>"><?php echo $value['Subject']['subject_name'];?></a>	
				</li>
			<?php } ?>	
		</ul>
	</div>
	<?php if(trim(@$_GET['search_help_txt']) && $isSearchresult == 0){?> <!--  If search text present but no search result present the display error message  -->
			<div id="display_div" class="right_panel_list fl">   
				<div class="each_list_head"><?php echo __('Search Results for');?>: <span style="font-size:30px;"><?php echo trim(@$_GET['search_help_txt']); ?></span></div>
				<div class="cb"></div>
				<div class="detail_help">
					<div style="color:#FF0000;"><?php echo __('No Search Result Found');?></div>
				</div>
			</div>
		<div class="cb"></div>
	<?php }else{ ?>	
			<div id="display_div" class="right_panel_list fl">   
				<div class="each_list_head">
					<?php
						if($isSearchresult == 1){
							echo "Search Results for: <span style='font-size:30px;'>".trim(@$_GET['search_help_txt'])."</span>";
						}else{
							echo $subject_name;
						}
					 ?>	
				</div>
							
				<div class="cb"></div>
				<?php foreach ($allHelpData as $key => $value) {	?>
					<div class="detail_help">
						<?php if(isset($value['Help']['title']) && $value['Help']['title'] != ''){ ?>
							<div class="accordionButton">
								<a href="javascript:void(0);" style="outline:none;"><i class="fl open_list plus"></i><?php echo $value['Help']['title']; ?></a>
							</div>
							<div class="accordionContent">
								<ol>
									<?php if(stristr($value['Help']['description'],'src="img/') || stristr($value['Help']['description'],'href="img/')){
										$value['Help']['description'] = str_ireplace(array('src="img/','href="img/'), array('src="'.HTTP_ROOT.'img/help/task/','href="'.HTTP_ROOT.'img/help/task/'), $value['Help']['description']);
		  							}
									echo $value['Help']['description']; ?>
								</ol>
                            <?php if(isset($value['Help']['image']) && $value['Help']['image'] !=''){ ?>
                                <div class="help_img"><center><a href="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"><img src="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"/></a></center></div>
                            <?php } ?>
							</div>	
						<?php }else{ ?>	
							<div class="noaccordContent">
								<ol>
									<?php echo $value['Help']['description'] ?>
								</ol>
                            <?php if(isset($value['Help']['image']) && $value['Help']['image'] !=''){ ?>
                                <div class="help_img"><center><a href="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"><img src="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"></a></center></div>
                            <?php } ?>
							</div>	
						<?php } ?>
					</div>
				<?php } ?>	
				<div class="cb"></div>
			</div>
		<div class="cb"></div>
	<?php } ?>
	
</div>
</div>


<?php }else{ ?>
<style>
    body{font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;}
    .detail_help img{max-width: 80%;margin:10px 0px;}
</style>
<style type="text/css">
.timelog_nb {background: rgba(0, 0, 0, 0) url("<?php echo HTTP_ROOT; ?>img/lft_menu_sprite.png") no-repeat scroll 0 -543px;height: 35px;margin: 0 auto;width: 35px;position:absolute;top:-10px;left: 243px;display:block;} 
.invoice_nb{background: url("<?php echo HTTP_ROOT; ?>/img/lft_menu_sprite.png") no-repeat scroll 0 -782px;height: 35px;margin: 0 auto;width: 35px;position:absolute;top:-5px;left: 212px;display:block;}
.accordionContent ol li a{display: inline-block;margin-left: 24px;}
.accordionContent ol{margin-top:5px;}
.help_img{margin-bottom:10px;margin-top:10px;}
.help_img img{max-width:80%;margin:0 auto;}
.left_panel_list{width:231px;padding:0;border:none}
.left_panel_list h3{font-size:22px;color:#333}
.left_panel_list ul{ border: 1px solid #ccc;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 15px;
    margin: 10px 0 0;
    padding: 10px 15px;}

.db-filter-icon_help {
    background: rgba(0, 0, 0, 0) url("../img/images/filter_save_reset.png") no-repeat scroll -26px 0;
    height: 20px;
    position: relative;
    width: 20px;
	display: inline-block;
	vertical-align:bottom;
}
.sett_help {
    background: rgba(0, 0, 0, 0) url("../img/sprite_osv2.png") no-repeat scroll -277px -164px;
    cursor: pointer;
    height: 18px;
    /*margin: 3px 5px 0 7px;*/
    opacity: 0.3;
    width: 20px;
	display: inline-block;
	vertical-align:middle;
}
.act_edit_task_help {
    background: rgba(0, 0, 0, 0) url("../img/sprite_osv2.png") no-repeat scroll -121px -170px;
    height: 17px;
    /*margin-right: 9px !important;*/
    width: 21px;
	display: inline-block;
	vertical-align:middle;
}
.act_task_type_dropdwn{
	background: url("../img/sprite_osv2.png") no-repeat scroll -169px -146px transparent;
    display: inline-block;
    height: 16px;
    position: relative;
    width: 14px;
    vertical-align: middle;
    margin-right: 2px;
}

.act_task_type_tag{
	 background: url("../img/tag-icon.png") no-repeat scroll 0 0 transparent;
    display: inline-block;
    height: 13px;
    vertical-align: middle;
    width: 13px;
    margin-left: 3px;
}
.act_arcv_task_help {
    background: rgba(0, 0, 0, 0) url("../img/sprite_osv2.png") no-repeat scroll -163px -170px;
    height: 17px;
    width: 19px;
	display: inline-block;
	vertical-align:middle;
}
.template_n_help {
    background: rgba(0, 0, 0, 0) url("../img/lft_menu_sprite.png") no-repeat scroll 0 -454px;
	height: 35px;
    margin: 0 auto;
    width: 35px;
	display: inline-block;
	vertical-align:middle;
}
.help_section .nav-tabs.mod_wide{background:inherit}
.help_section .tab.tab_comon{margin-top:50px}
.nav-tabs.mod_wide > li > a, .nav-tabs.mod_wide > li > a:focus, .nav-tabs.mod_wide > li > a:hover{color:inherit !important}
</style>
<?php if(!defined('SES_ID') || !SES_ID){ ?>
<style type="text/css">
.wrapper_help *, .wrapper_help *:before, .wrapper_help *:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.noaccordContent, .accordionContent{padding-left:40px;}
.noaccordContent ul, .accordionContent ul{margin:1em 0;};
body {
	font-family:myriadpro-regular;
}
.g-signup:hover img{box-shadow: 0 0 9px #BF3E2A;-moz-box-shadow: 0 0 9px #BF3E2A;-webkit-box-shadow: 0 0 9px #BF3E2A;transition:none;}
</style>
<?php } ?>


<?php echo $this->element('help_tabbs');?>
	<!--<div style="font-size:17px;padding-left:12px;text-align:center;">Here are some answers to the most common questions we've been asked.</div>-->
	<div class="help-type-hd" style="font-size:17px;padding-left:12px;text-align:center;color:#666666;"><?php echo __('Welcome to the Orangescrum knowledge base');?>.</div>
	<div style="font-size:17px;padding-left:12px;text-align:center;color:#666666;"><?php echo __('What can we help you with today');?>?</div>
	
	<?php /*if(defined('SES_ID') && SES_ID){ ?><div style="font-size:17px;padding-left:12px;text-align:center;">If you still have questions? <a href="javascript:void(0);" class="support-popup" style="outline:none;text-decoration:underline;color:#00F">Ask Us</a></div><?php } else {
		?>
        <div style="font-size:17px;padding-left:12px;text-align:center;">If you still have questions? Please email us <a href="mailto:support&#64;orangescrum&#46;com"target="_blank" style="color: blue;">support&#64;orangescrum&#46;com</a></div>
        <?php
		 } */?>
         <!--<br/>-->

	<!--<div class="head fl"><h3>Category</h3></div>-->
	<div class="search_help">
		<center><form name="search_help_form" action="<?php echo $url; ?>">
			<div style="position:relative;width:370px;">
			<input type="text" placeholder="Enter question or keyword" value="<?php echo urldecode(trim(@$_GET['search_help_txt'])); ?>" name="search_help_txt" id="search_help_txt"/>
			<button class="search_icon fr" onClick="return validate();"></button>
            </div>
			
		</form></center>
	</div>
	<div class="left_panel_list fl">
		<h3><?php echo __('Category');?></h3>
		<ul>
			<?php foreach ($allSubjectData as $key => $value) {
					if($key == (count($allSubjectData) - 1)){
						$classLast = 'class="last"';
					}else{
						$classLast = '';
					}
					
					if($subjectId == $value['Subject']['id'] && trim(@$_GET['search_help_txt']) == ''){
						$selectColor = 'color:#4F92BF';
					}else{
						$selectColor = '';
					}
			?>
				<li <?php echo $classLast; ?>>
                    <?php $subject = preg_replace('/[\s]+/','-',preg_replace('/[&]+/','',strtolower($value['Subject']['subject_name'])));?>
					<a href="<?php echo HTTP_ROOT."help-".$subject."-".$value['Subject']['id'];?>" style="outline:none;<?php echo $selectColor; ?>"><?php echo $value['Subject']['subject_name'];?></a>	
				</li>
			<?php } ?>	
		</ul>
	</div>
	<?php if(trim(@$_GET['search_help_txt']) && $isSearchresult == 0){?> <!--  If search text present but no search result present the display error message  -->
		<div id="display_div">
			<div class="right_panel_list fl">   
				<div class="each_list_head"><?php echo __('Search Results for');?>: <span style="font-size:30px;"><?php echo trim(@$_GET['search_help_txt']); ?></span></div>
				<div class="cb"></div>
				<div class="detail_help">
					<div style="color:#FF0000;"><?php echo __('No Search Result Found');?></div>
				</div>
			</div>
		</div>
	<?php }else{ ?>	
		<div id="display_div">
			<div class="right_panel_list fl">   
				<div class="each_list_head">
					<?php
						if($isSearchresult == 1){
							echo __("Search Results for").": <span style='font-size:30px;'>".trim(@$_GET['search_help_txt'])."</span>";
						}else{
							echo $subject_name;
						}
					 ?>	
				</div>
							
				<div class="cb"></div>
				<?php foreach ($allHelpData as $key => $value) {	?>
					<div class="detail_help">
						<?php if(isset($value['Help']['title']) && $value['Help']['title'] != ''){ ?>
							<div class="accordionButton">
								<a href="javascript:void(0);" style="outline:none;"><i class="fl open_list plus"></i><?php echo $value['Help']['title']; ?></a>
							</div>
							<div class="accordionContent">
								<ol>
									<?php if(stristr($value['Help']['description'],'src="img/') || stristr($value['Help']['description'],'href="img/')){
										$value['Help']['description'] = str_ireplace(array('src="img/','href="img/'), array('src="'.HTTP_ROOT.'img/help/task/','href="'.HTTP_ROOT.'img/help/task/'), $value['Help']['description']);
		  							}
									echo $value['Help']['description']; ?>
								</ol>
                            <?php if(isset($value['Help']['image']) && $value['Help']['image'] !=''){ ?>
                                <div class="help_img"><center><a href="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"><img src="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"/></a></center></div>
                            <?php } ?>
							</div>	
						<?php }else{ ?>	
							<div class="noaccordContent">
								<ol>
									<?php echo $value['Help']['description'] ?>
								</ol>
                            <?php if(isset($value['Help']['image']) && $value['Help']['image'] !=''){ ?>
                                <div class="help_img"><center><a href="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"><img src="<?php echo HTTP_ROOT; ?>img/help/<?php echo $value['Help']['image']; ?>"></a></center></div>
                            <?php } ?>
							</div>	
						<?php } ?>
					</div>
				<?php } ?>	
				<div class="cb"></div>
			</div>
		</div>
	<?php } ?>

</div>
<?php if(!defined('SES_ID') || !SES_ID){ ?>
	<div class="cb"></div>
	<div class="sub_form_bg" style="margin:40px auto;text-align:center;width:auto;">
		<a style="text-decoration:none;" href="<?php echo PROTOCOL."www.".DOMAIN; ?>signup/getstarted<?php echo $ablink; ?>" onclick="getstarted_ga(' aboutus');">
		   <span class="tk_tour" style="padding:7px 18px"><?php echo __('Sign Up Free');?></span>
		</a>
		<span style="margin-left:20px;color:#999;">or</span>
		<span onclick="signinWithGoogle();ga_tracking_google_signup('Signup Page');" class="g-signup">
			<img src="<?php echo HTTP_ROOT; ?>img/sign-up-with.png?v=<?php echo RELEASE; ?>"  alt="Signup with Google" style="cursor:pointer;position:relative;top:0px;left: 20px;"/>
		</span>
	</div>
</div>
<?php 
} else { 
?>
	<br/><br/>
<?php
}
?>
<div style="clear:both"></div>
<?php if($this->Session->read('Auth.User.id')==''){?>
<?php echo $this->element('social_share');?>
<?php } ?>
<?php } ?>