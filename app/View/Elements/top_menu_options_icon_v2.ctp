<span class="dropdown cmn_hover_menu_open">
    <a class="dropdown-toggle active main_page_menu_togl top_main_page_menu_togl" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
        <i id="top_main_togl_nav" class="material-icons">&#xE5C3;</i>
    </a>
    <ul class="dropdown-menu main_page_menu_togl_ul">
       <?php
		//$reov = Configure::read('RESTRICTED_PROJ_OV');
		//if(in_array(SES_COMP,$reov) && SES_TYPE > 2){ ?>
		<?php //}else{ ?>
        
		<?php //} ?>
		<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?> 
        <li><a id="files_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Files','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('files');"> 
                <span title="<?php echo __('Files');?>"><i class="material-icons">&#xE226;</i><?php echo __('Files');?></span>  	
            </a>
        </li>
    <?php } ?>
        <li>
            <a id="actvt_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#activities'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Activities','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('activities');">
                <span title="<?php echo __('Activities');?>"><i class="material-icons">&#xE922;</i><?php echo __('Activities');?></span>
            </a>
        </li>
    </ul>
</span>