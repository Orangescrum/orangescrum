<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <ul class="proj_stas_bar company-settings-bar"> 
                    <?php #if(PAGE_NAME == 'importexport'||PAGE_NAME == 'importtimelog'|| PAGE_NAME=='csv_dataimport' || PAGE_NAME=='confirm_import' || PAGE_NAME=='csv_tldataimport' || PAGE_NAME=='confirm_tlimport') {?>
                    <li <?php if (in_array(PAGE_NAME, array('importexport', 'importtimelog', 'importcomment', 'csv_dataimport', 'confirm_import', 'csv_tldataimport', 'csv_commentimport', 'confirm_tlimport', 'importCustomers', 'csvDataimport', 'confirmImport'))) { ?>class="active-list" <?php } ?>>
                        <a id="sett_imp_exp_prof" href="<?php echo HTTP_ROOT.'import-export';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Import & Export','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE0C3;</i> <?php echo __('Import & Export');?>
                        </a>
                    </li>
                <?php if(SES_TYPE < 3){ ?>   
                   <li <?php if(PAGE_NAME == 'task_type') {?>class="active-list" <?php }?>>
                        <a id="sett_task_type" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'task-type';} ?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Task Type','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE862;</i> <?php echo __('Task Type');?> <?php echo $this->Format->getlockIcon(); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if(SES_TYPE < 3){ /* ?>   
                    <li class="task-sett pr <?php if(CONTROLLER == 'projects' && PAGE_NAME == 'task_settings') {?>active-list<?php }?>">
                        <a id="sett_invoice" href="<?php echo HTTP_ROOT.'task-settings';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Task Settings','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE862;</i> <i class="material-icons task-setting-icn">&#xE8B8;</i> <?php echo __('Task Settings');?>
                        </a>
                    </li>
                <?php */} ?>
                    
                  
                
                </ul>
            </div>
            <div class="col-lg-4 text-right">
            </div>
        </div>
    </div>
</div>