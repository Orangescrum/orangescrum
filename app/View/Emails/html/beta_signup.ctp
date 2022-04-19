<table style="padding:20px;margin:0 auto;text-align:left;width:100%">
  <tbody>
  <?php echo EMAIL_HEADER;?>
    <tr>
      <td>
	<div style="color:#000;font-family:Arial;font-size:14px;line-height:1.8em;text-align:left;padding-top: 10px;">
		<p style="display:block;margin:0 0 17px">Hi <?php echo $expName;?>,</p>
		<p>
			<div><?php echo __("Welcome to Orangescrum and thank you for signing up.");?> <?php if($plan_id != 1){ ?><?php echo __("This email contains valuable information to get you started.");?><?php }else{ ?><?php echo __("Glad you decided to give Orangescrum a try.");?><?php } ?></div>
		</p>
		<p>
			<div><?php echo __("Your Login Password:");?> <b><?php echo $password;?></a></div>
			<div><?php echo __("Web Address:");?><a href="<?php echo $web_address;?>" target='_blank' style="text-decoration:none;"><?php echo $web_address;?></a></div>
			<?php if($plan_id != 1){ ?>
				<div><?php echo __("Plan:");?><b><?php echo __("PREMIUM");?></b><?php echo __("-");?> $<?php echo $price;?><?php echo __(" /month /user");?> (<b><?php echo $free_trail_days;?><?php echo __("days FREE trial");?></b>)</div>
			<?php }else{ ?>
				<div><?php echo __("Plan:");?> <b><?php echo __("BASIC");?></b><?php echo __("-");?><?php echo __(" $0 /month /user");?></div>				
				<div><?php echo __("Project Limit:");?><b><?php echo $project_limit;?></b> </div>
				<div><?php echo __(" User Limit:");?><b><?php echo $user_limit;?></b> </div>
			<?php } ?>
			<?php if($plan_id != 1){ ?>
				<div><?php echo __("Storage: Additional");?> <b><?php echo $storage;?> MB per user</b></div>
			<?php }else{ ?>
				<div><?php echo __("Storage:");?><b><?php echo $storage;?> MB</b></div>
			<?php } ?>
		</p>
		<?php if($plan_id != 1){ ?>
		<p>
			<div><b>Invite Members and create a Team. Everyone will be on the same page.</b></div>
		</p>
		<?php } ?>
		<p>
			<div><?php echo __("We are here to help you. Just reply to this email (or send an email to");?><a href='mailto:support&#64;orangescrum&#46;com'>support&#64;orangescrum&#46;com</a>)</div>
			<div>><?php echo __("You can also refer our");?> <a href="<?php echo HTTP_ROOT.'easycases/help';?>" target='_blank' style="text-decoration:none;"><?php echo __("HELP");?></a><?php echo __("section.");?></div>
		</p>
		<p>
			<?php echo __("To stay up-to-date on the latest Orangescrum news and events, you can read our ");?><a href="<?php echo BLLOG_OS_URL;?>" target='_blank' style="text-decoration:none;"><?php echo __("blog");?></a>, <a href="https://www.twitter.com" target='_blank' style="text-decoration:none;"><?php echo __("follow us on Twitter");?></a>, <a href="https://www.facebook.com" target='_blank' style="text-decoration:none;"><?php echo __("Like us on Facebook");?></a>.
		</p>
		<p style="display:block;margin:0">
			<?php if($plan_id != 1){ ?>
				<?php echo __("Thanks again for joining Orangescrum,");?>
			<?php }else{ ?>
				<?php echo __("Enjoy your FREE trial.");?>
			<?php } ?>
			<br/>
			<?php echo __("The Orangescrum Team");?>
		</p>				
	</div>
      </td>
    </tr>
    <?php echo Configure::read('free_signup_footer');?>
  </tbody>
</table>
        


