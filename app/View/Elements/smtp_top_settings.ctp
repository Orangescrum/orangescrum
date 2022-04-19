<?php
$is_others = 0;
if(isset($this->params['pass'][0]) && trim($this->params['pass'][0]) == 'others'){
	$is_others = 1;
}
?>
<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-9">
                <ul class="proj_stas_bar personal-settings-bar">                    
                    <li <?php if (PAGE_NAME == 'smtp_settings' && !$is_others) { ?>class="active-list" <?php } ?>>
                        <a id="sett_my_profile" href="<?php echo HTTP_ROOT . 'smtp-settings'; ?>" class="all-list">
                            <i class="material-icons">mail_outline</i> <?php echo __('SMTP Settings');?>
                        </a>
                    </li>
                    <li <?php if ($is_others) { ?>class="active-list" <?php } ?>>
                        <a id="sett_cpw_prof" href="<?php echo HTTP_ROOT . 'smtp-settings/others'; ?>" class="all-list">
                            <i class="material-icons">settings_brightness</i> <?php echo __('Advanced Settings');?>
                        </a>
                    </li>             
                </ul>
            </div>
            <div class="col-lg-3 text-right">
            </div>
        </div>
    </div>
</div>