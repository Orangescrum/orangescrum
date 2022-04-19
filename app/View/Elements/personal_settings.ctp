<?php
if (!defined('NO_PASSWORD')) {
    $user = ClassRegistry::init('User')->findById(SES_ID);
    if (!empty($user['User']['password'])) {
        define('NO_PASSWORD', 0);
    } else {
        define('NO_PASSWORD', 1);
    }
}
?>
<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <ul class="proj_stas_bar personal-settings-bar">                    
                    <li <?php if (PAGE_NAME == 'profile') { ?>class="active-list" <?php } ?>>
                        <a id="sett_my_profile" href="<?php echo HTTP_ROOT . 'users/profile'; ?>" class="all-list" onclick="return trackEventLeadTracker('Personal Settings','My Profile','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE7FD;</i> <?php echo __('My Profile');?>
                        </a>
                    </li>
                    <li <?php if (PAGE_NAME == 'changepassword') { ?>class="active-list" <?php } ?>>
                        <a id="sett_cpw_prof" href="<?php echo HTTP_ROOT . 'users/changepassword'; ?>" class="all-list" onclick="return trackEventLeadTracker('Personal Settings','Change Password','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE897;</i> <?php if (NO_PASSWORD) { ?>Set Password<?php } else { ?><?php echo __('Change Password');?><?php } ?>
                        </a>
                    </li>
                    <li <?php if (PAGE_NAME == 'email_notifications') { ?>class="active-list" <?php } ?>>
                        <a id="sett_mail_noti_prof" href="<?php echo HTTP_ROOT . 'users/email_notifications'; ?>" class="all-list" onclick="return trackEventLeadTracker('Personal Settings','Notifications','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE003;</i> <?php echo __('Notifications');?>
                        </a>
                    </li>
                    <li <?php if (PAGE_NAME == 'email_reports') { ?>class="active-list" <?php } ?>>
                        <a id="sett_mail_repo_prof" href="<?php echo HTTP_ROOT . 'users/email_reports'; ?>" class="all-list" onclick="return trackEventLeadTracker('Personal Settings','Email Reports','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE0BE;</i> <?php echo __('Email Reports');?>
                        </a>
                    </li>
                    <li <?php if (CONTROLLER =="UserQuicklinks" && PAGE_NAME == 'index') { ?>class="active-list" <?php } ?>>
                        <a id="sett_dflt_view_prof" href="<?php echo HTTP_ROOT . 'quick-link-settings'; ?>" class="all-list" onclick="return trackEventLeadTracker('Quick Link Settings','Default View','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">link</i> <?php echo __('Quick Links');?>
                        </a>
                    </li>
                    <li  <?php if (CONTROLLER =="bookmarks") { ?>class="active-list" <?php } ?> >
                    <a id="sett_dflt_view_prof"  href="<?php echo HTTP_ROOT . 'bookmarks/bookmarksList'; ?>" class="all-list">
                    <i class="material-icons">link</i> <?php echo __('Bookmarks');?>
                    </a>
                    </li>
                </ul>
            </div>
            <!-- <div class="col-lg-1 text-right">
            </div> -->
        </div>
    </div>
</div>