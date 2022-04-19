<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12">
                <ul class="proj_stas_bar company-settings-bar">                    
                 <?php if(SES_TYPE < 3){ ?>                  
                    <li <?php if(PAGE_NAME == 'mycompany') {?>class="active-list" <?php }?>>
                        <a id="sett_mail_noti_prof" href="<?php echo HTTP_ROOT.'my-company';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','My Company','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE0AF;</i> <?php echo __('My Company');?>
                        </a>
                    </li>
                <?php } ?>                                                 
                <?php if(SES_TYPE < 3){ ?>										
										 <li class="task-sett pr <?php if(CONTROLLER == 'projects' && PAGE_NAME == 'project_status') {?>active-list<?php }?>" >
                        <a id="sett_invoice" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'project-status';} ?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Project Status','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons ">&#xE8B8;</i> <?php echo __('Project Status');?> <?php echo $this->Format->getlockIcon(); ?>
                        </a>
                    </li>
										
                <?php } ?>
                <li <?php
                   if(PAGE_NAME =='manage_status'){
						$page_from='Workflow Management';
					}else if(PAGE_NAME =='project_types'){
						$page_from='Project Type';						
					}else if(PAGE_NAME =='project_status'){
						$page_from='Project Status';						
					}else if(PAGE_NAME =='sprint_setting'){
						$page_from='Sprint Setting';	
					}else if(PAGE_NAME =='resource_settings'){
						$page_from='Resource Setting';	
					}else if(PAGE_NAME =='chat_settings'){
							$page_from='Chat Setting';	
					}else if(PAGE_NAME =='index'){
						$page_from='User role Management';	
					}else if(PAGE_NAME =='manageProjectTemplates'){
							$page_from='Project Templates';		
					}else if(PAGE_NAME =='groupupdatealerts'){
						$page_from='Daily Catchup';			
					}else if(PAGE_NAME =='task_type'){
						$page_from='Task Type';			
					}else if(PAGE_NAME =='settings'){
					 $page_from='Invoice Settings';	
					}else if(PAGE_NAME =='labels'){
					$page_from='Labels';				
					}else{
					$page_from='Company Settings';	
					 }
				if(PAGE_NAME == 'manage_task_status_group' || PAGE_NAME =='manage_status') {		
					
					?>class="active-list" <?php }?>>
                    <a id="sett_mail_noti_prof" href="<?php if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN){ echo 'javascript:showUpgradPopup(1);'; }else{ echo HTTP_ROOT.'workflow-setting';} ?>" class="all-list" onclick="return trackEventLeadTracker('<?php echo $page_from; ;?>','Workflow Management','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" style="max-width:200px;">
                       <i class="material-icons">&#xE0AF;</i> <?php echo __('Status Workflow Mgt');?>. <?php echo $this->Format->getlockIcon(); ?>
                    </a>
                </li>  
                    <?php if($this->Format->isAllowed('View Invoice Setting',$roleAccess)){ ?>
                  <!--   <li <?php if(PAGE_NAME == 'groupupdatealerts') {?>class="active-list" <?php }?>>
                        <a id="sett_mail_repo_prof" href="<?php echo HTTP_ROOT.'reminder-settings';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Daily Catch-Up','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE003;</i> <?php echo __('Daily Catch-Up');?>
                        </a>
                    </li> -->
                   <?php } ?>
                    <?php #if(PAGE_NAME == 'importexport'||PAGE_NAME == 'importtimelog'|| PAGE_NAME=='csv_dataimport' || PAGE_NAME=='confirm_import' || PAGE_NAME=='csv_tldataimport' || PAGE_NAME=='confirm_tlimport') {?>
                    <!-- <li <?php if (in_array(PAGE_NAME, array('importexport', 'importtimelog', 'importcomment', 'csv_dataimport', 'confirm_import', 'csv_tldataimport', 'csv_commentimport', 'confirm_tlimport', 'importCustomers', 'csvDataimport', 'confirmImport'))) { ?>class="active-list" <?php } ?>>
                        <a id="sett_imp_exp_prof" href="<?php echo HTTP_ROOT.'import-export';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Import & Export','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                           <i class="material-icons">&#xE0C3;</i> <?php echo __('Import & Export');?>
                        </a>
                    </li> -->
                <?php if(SES_TYPE < 3){ ?>   
                   <!--  <li <?php if(PAGE_NAME == 'task_type') {?>class="active-list" <?php }?>>
                        <a id="sett_task_type" href="<?php echo HTTP_ROOT.'task-type';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Task Type','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE862;</i> <?php echo __('Task Type');?>
                        </a>
                    </li> -->
                <?php } ?>
                  <?php if($this->Format->isAllowed('View Invoice Setting',$roleAccess)){ ?>
                    <!-- <li <?php if(CONTROLLER == 'invoices' && PAGE_NAME == 'settings') {?>class="active-list" <?php }?>>
                        <a id="sett_invoice" href="<?php echo HTTP_ROOT.'invoice-settings';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Invoice','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE53E;</i> <?php echo __('Invoice');?>
                        </a>
                    </li> -->
                <?php } ?>
                <?php if(SES_TYPE < 3){ /* ?>   
                    <li class="task-sett pr <?php if(CONTROLLER == 'projects' && PAGE_NAME == 'task_settings') {?>active-list<?php }?>">
                        <a id="sett_invoice" href="<?php echo HTTP_ROOT.'task-settings';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Task Settings','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons">&#xE862;</i> <i class="material-icons task-setting-icn">&#xE8B8;</i> <?php echo __('Task Settings');?>
                        </a>
                    </li>
                <?php */} ?>
                    
                  
                <?php if(SES_TYPE < 3){ ?>   
                    <!-- <li class="task-sett pr <?php if(CONTROLLER == 'projects' && PAGE_NAME == 'labels') {?>active-list<?php }?>">
                        <a id="sett_invoice" href="<?php echo HTTP_ROOT.'labels';?>" class="all-list" onclick="return trackEventLeadTracker('Company Settings','Lebel','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                            <i class="material-icons ">&#xE8B8;</i> <?php echo __('Label');?>
                        </a>
                    </li>   -->                  
                <?php } ?>
                </ul>
            </div>
            <div class="col-lg-4 text-right">
            </div>
        </div>
    </div>
</div>