<div class="lstbtndv"></div>
<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE8D1;</i></div>
    <div class="fl cnt_udet_db"><b><?php if(isset($usage_details['0']['total_filesize']['filesize']) && !empty($usage_details['0']['total_filesize']['filesize'])){ echo $usage_details['0']['total_filesize']['filesize'];} else { echo 0;}?></b> MB <span><?php echo __('of');?></span> <?php echo __('File Storage');?></div>
    <div class="cb"></div>
</div>
<div class="lstbtndv"></div>
<?php if(isset($usage_details['0']['total_projects'])){ ?>
<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE7FD;</i></div>
    <div class="fl cnt_udet_db"><b><?php if(isset($usage_details['0']['total_projects']['cnt_projects']) && !empty($usage_details['0']['total_projects']['cnt_projects'])){ echo $usage_details['0']['total_projects']['cnt_projects'];} else { echo 0;}?></b> <?php echo __('Projects');?></div>
    <div class="cb"></div>
</div>
<div class="lstbtndv"></div>
<?php } ?>
<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE7FD;</i></div>
    <div class="fl cnt_udet_db"><b><?php if(isset($usage_details['0']['total_users']['cnt_users']) && !empty($usage_details['0']['total_users']['cnt_users'])){ echo $usage_details['0']['total_users']['cnt_users'];} else { echo 0;}?></b> <?php echo __('Active Users');?></div>
    <div class="cb"></div>
</div>
<?php if(isset($user_subscription) && $user_subscription['id'] && $is_active_proj){
    if((!$user_subscription['is_free']) && (SES_TYPE==1) && ($user_subscription['subscription_id']<=3) && CONFIG_SUBSCRIPTION && (PAGE_NAME !='pricing' && PAGE_NAME !='upgrade_member')){?>
	<div>
	    <a href="<?php echo HTTP_ROOT.'users/pricing';?>" class="dropdown-toggle upgrade_btn" ><button type="button" class="btn orange_btn"><?php echo __('Upgrade your Account');?></button></a></div>
	<div class="cnt_udet_db" style="margin-left:0px;"><span><?php echo __('to get upto');?> </span><b>100</b> <?php echo __('Projects');?> & <b>50<b> <?php echo __('GB Storage');?></div>
<?php } } ?>

