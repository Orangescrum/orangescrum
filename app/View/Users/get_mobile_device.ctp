<style type="text/css">
	.main-container .rht_content_cmn.task_lis_page .wrapper{padding-top:70px}
	.get_your_device{
		width:100%;height:100%;background:#fff;box-shadow:0px 0px 5px #c1cede;text-align:center;padding:100px;margin:0 auto;border-radius:5px;}
	.get_your_device .pfl_logo{display:inline-block;width:70px;height:70px;line-height:70px;border-radius:50%;font-size:30px;color:#fff;text-align:center;}
	.get_your_device .pfl_logo img{max-width:100%;width:100%;height:100%;border-radius:50%}
	.get_your_device h2{font-size:30px;line-height:40px;margin:15px 0 30px;padding:0 0 15px;border-bottom:2px solid #333}
	.get_your_device p{font-size:18px;line-height:30px;margin:0;padding:0;}
	.get_your_device .app_btn a{display:inline-block;text-decoration:none;margin:30px 15px 0;}
	.get_your_device .cmn_profile_holder{border-radius: 50%;height: 100%; width: 100%;line-height: 70px; font-size: 30px;display: inline-block;}
	@media only screen and (max-width:1290px){
		.get_your_device br{display:none}
	}
</style>
<div class="get_your_device">
	<?php 
		$usrArr = $this->Format->getUserDtls(SES_ID);
			if(count($usrArr)) {
				$ses_name = $usrArr['User']['name'];
				$ses_photo = $usrArr['User']['photo'];
			}
	?>
	<div class="pfl_logo prof_sett">
		<?php if(trim($ses_photo)) { ?>
		<img data-original="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo $ses_photo; ?>&sizex=70&sizey=70&quality=100" class="lazy" height="70" width="70" />
		<?php } else {
			$random_bgclr = $this->Format->getProfileBgColr(SES_ID);
			$usr_name_fst = mb_substr(trim($ses_name),0,1, "utf-8");											
		?>
		<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
		<?php } ?>
	</div>
	<h2>Get OrangeScrum on your mobile device</h2>
	<p>OrangeScrum is with you everywhere. Get our free apps for iOS & Android. Manage your project tasks on the go. <br/>Save time and stay updated on what’s happening in your project.</p>
	<div class="app_btn">
		<a href="https://itunes.apple.com/ph/app/id1132539893" target="_blank">
			<img src="<?php echo HTTP_ROOT;?>images/app-store.png" alt="The Orangescrum in App Store" title="The Orangescrum in App Store">
		</a>
		<a href="https://play.google.com/store/apps/details?id=com.andolasoft.orangescrum&hl=en" target="_blank">
			<img src="<?php echo HTTP_ROOT;?>images/google-play.png" alt="The Orangescrum in Play Store" title="The Orangescrum in Play Store">
		</a>
	</div>
</div>