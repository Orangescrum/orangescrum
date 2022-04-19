<div class="lstbtndv"></div>
<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE8D1;</i></div>
    <div class="fl cnt_udet_db"><b ng-if="usage[0].total_filesize.filesize != null" ng-cloak>{{usage[0].total_filesize.filesize}}</b>
                                <b ng-if="usage[0].total_filesize.filesize =='' || usage[0].total_filesize.filesize == null" ng-cloak>0</b> MB <span><?php echo __('of');?></span> <?php echo __('File Storage');?></div>
    <div class="cb"></div>
</div>
<div class="lstbtndv"></div>

<div ng-if="usage[0].total_projects">
<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE7FD;</i></div>
    <div class="fl cnt_udet_db">
        <b ng-if="usage[0].total_projects.cnt_projects != null && usage[0].total_projects.cnt_projects != '' " ng-cloak> {{usage[0].total_projects.cnt_projects}}</b>
        <b ng-if="usage[0].total_projects.cnt_projects == null || usage[0].total_projects.cnt_projects == '' " ng-cloak>0</b> <?php echo __('Projects');?></div>
    <div class="cb"></div>
</div>
<div class="lstbtndv"></div>
</div>

<div class="listdv summary_row">
    <div class="fl icn_udet_db"><i class="material-icons">&#xE7FD;</i></div>
    <div class="fl cnt_udet_db">
        <b ng-if="usage[0].total_users.cnt_users != null" ng-cloak>{{usage[0].total_users.cnt_users}}</b>
        <b ng-if="usage[0].total_users.cnt_users == null || usage[0].total_users.cnt_users == ''" ng-cloak>0</b> <?php echo __('Active Users');?></div>
    <div class="cb"></div>
</div>
<?php /* if(isset($user_subscription) && $user_subscription['id'] && $is_active_proj){
    if((!$user_subscription['is_free']) && (SES_TYPE==1) && ($user_subscription['subscription_id']<=3) && CONFIG_SUBSCRIPTION && (PAGE_NAME !='pricing' && PAGE_NAME !='upgrade_member')){?>
	<div>
	    <a href="<?php echo HTTP_ROOT.'users/pricing';?>" class="dropdown-toggle upgrade_btn" ><button type="button" class="btn orange_btn">Upgrade your Account</button></a></div>
	<div class="cnt_udet_db" style="margin-left:0px;"><span>to get upto </span><b>100</b> Projects & <b>50<b> GB Storage</div>
<?php } }*/ ?>

