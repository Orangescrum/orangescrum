<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <ul class="proj_stas_bar company-settings-bar">                    
                    <li <?php if(PAGE_NAME == 'manage_task_status_group') {?>class="active-list" <?php }?>>
                        <a id="sett_mail_noti_prof" href="<?php echo HTTP_ROOT.'workflow-setting';?>" class="all-list" onclick="return trackEventLeadTracker('Workflow Management','Workflow Management','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" style="max-width:200px;">
                           <i class="material-icons">&#xE0AF;</i> <?php echo __('Status Workflow Management');?>
                        </a>
                    </li>                   
                </ul>
            </div>
            <div class="col-lg-4 text-right">
            </div>
        </div>
    </div>
</div>