<style>
.disp_assn_proj_popup {cursor:pointer;}
</style>
<input type="hidden" id="role" value="<?php echo $role;?>">
<input type="hidden" id="type" value="<?php echo $type;?>">
<input type="hidden" id="user_srch" value="<?php echo $user_srch;?>">
<div class="proj_grids m-cmn-flow">
	<?php
	$srch_res = '';
	if(isset($_GET['user']) && trim($_GET['user']) && isset($userArr['0']['User']) && !empty($userArr['0']['User'])){
	    if($userArr['0']['User']['name']) {
		$srch_res = ucfirst($userArr['0']['User']['name'])." ".ucfirst($userArr['0']['User']['last_name']);
	    } else {
		$srch_res = $userArr['0']['User']['email'];
	    }
	}
	
	if(isset($user_srch) && trim($user_srch)) {
	    $srch_res = $user_srch;
	}
	?>
    <?php if(trim($srch_res)){ ?>
	<div class="cmn_search_result cmn_bdr_shadow">
		<div class="global-srch-res fl"><?php echo __('Search Results for');?>: <span><?php echo $srch_res;?></span></div>
		<div class="fl global-srch-rst"><a href="<?php echo HTTP_ROOT.'users/manage';?>"><i class="material-icons">&#xE8BA;</i></a></div>
		<div class="cb"></div>
	</div>
    <?php } ?>
    
    
<div class="user_div_bk usrs_page m-list-tbl">
	
    <?php //if(!empty($userArr) && isset($userArr)){
	$count = 1;
	$is_invited_user = 0;
	if ($role == 'invited') {
	    $is_invited_user = 1;
	}
	
	foreach($userArr as $user) { 
		if ($user['Role']['role'] == 'Owner') {
		    $colors = 'own_clr';
		    $usr_typ_name = __('Owner',true);
		} else if ($user['Role']['role'] == 'Admin') {
		    $colors = 'adm_clr';
		    $usr_typ_name = __('Admin',true);
		} else if ($user['Role']['role'] == 'User' && $role != 3) {
		    $colors = 'usr_clr';
		    $usr_typ_name = __('User',true);
		} else if ($user['Role']['role'] == 'Guest') {
		    $colors = 'cli_clr';
		    $usr_typ_name = __('Guest',true);
		} else{
			$colors = 'usr_clr';
		    $usr_typ_name = ($user['Role']['role'])?$user['Role']['role']:__('User',true);
		}
		
		if ($role == 'invited') {
		    $colors = 'usr_clr';
		    $usr_typ_name = __('User',true);
			if($user['CompanyUser']['is_client'] == 1){
				$colors = 'cli_clr';
				$usr_typ_name = __('Client',true);
			}
		}		
		if($role == 'recent') {
                    $colors = 'usr_clr';
		    $usr_typ_name = __('User',true);
			if($user['User']['is_client'] == 1)
			{
				$colors = 'cli_clr';
				$usr_typ_name = __('Client',true);
			} else {
				$usr_typ_name = ($user['User']['role'])?$user['User']['role']:__('User',true);
			}
		}
		if($user['CompanyUser']['is_client'] == 1){
			$colors = 'cli_clr';
			$usr_typ_name = __('Client',true);
		}
		if($user['CompanyUser']['is_client'] == 1 && $user['CompanyUser']['user_type'] == 2){
			$colors = 'cli_clr';
			$usr_typ_name = __('Admin/Client',true);
		}
		?>
    <div class="usr_mcnt fl cmn_bdr_shadow" id="usr_mcnt<?php echo $user['User']['id'];?>">	
							
		<div class="usr_top_cnt">
			<div id="tour_role_user" class="usr_cat <?php echo $colors;?>" rel="tooltip" title="<?php echo $usr_typ_name;?>"><?php echo $usr_typ_name;?></div>
			<div id="tour_acton_user" class="usr_act_det">
				<span class="dropdown">
					<a class="dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
					  <i class="material-icons">&#xE5D4;</i>
					</a>
					<ul class="dropdown-menu right0">
					<?php if ($user['CompanyUser']['user_type'] == 1 || ($user['CompanyUser']['user_type'] == 2 && SES_ID == $user['User']['id'])) { ?>
						 <?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?> 
						  <li><a class="icon-assign-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>"><i class="material-icons">&#xE85D;</i> <?php echo __('Assign Project');?></a></li>
						<?php } ?>
						<?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
						  <li><input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
						<a id="rmv_prj_<?php echo $user['User']['id'];?>" class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-total-project="<?php echo $user['User']['total_project'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;" <?php } ?>><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a></li>	
						<?php } ?>		  
					 <?php }else{ ?>
                                                <?php if($role == 'invited'){ ?>
                                                	<?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?>
							<li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <a class="icon-assign-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>"><i class="material-icons">&#xE85D;</i> <?php echo __('Assign Project');?></a>
                                                            <input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
                                                            <span id="rmv_prj_<?php echo $user['User']['id'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;"<?php } ?>></span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                              <a class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>" data-total-project="<?php echo $user['User']['total_project'];?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->Format->isAllowed('Delete User',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                              <a class="icon-delete-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?del=<?php echo urlencode($user['User']['uniq_id']); ?>&role=<?php echo $_GET['role']; ?>" Onclick="return confirm('Are you sure you want to delete \'<?php echo $user['User']['email']; ?>\' ?')"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">				  
                                                              <a class="icon-resend-usr" href="javascript:void(0);" onclick="return resend_invitation('<?php echo $user['User']['qstr']; ?>','<?php echo $user['User']['email']; ?>');"><i class="material-icons">&#xE040;</i> <?php echo __('Resend');?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php }else if($role == 'recent'){ ?>
                                                	<?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <a class="icon-assign-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>"><i class="material-icons">&#xE85D;</i> <?php echo __('Assign Project');?></a>
							<input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
							<span id="rmv_prj_<?php echo $user['User']['id'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;"<?php } ?>></span>
                                                    </li>
                                                <?php } ?>
                                                <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                          <a class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>" data-total-project="<?php echo $user['User']['total_project'];?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                    </li>
                                                <?php } ?>
                                                  <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                          <?php if(!$user['User']['dt_last_login']){ ?>			    
                                                                  <a class="icon-resend-usr" href="javascript:void(0);" onclick="return resend_invitation('<?php echo $user['User']['qstr']; ?>','<?php echo $user['User']['email']; ?>');"><i class="material-icons">&#xE040;</i> <?php echo __('Resend');?></a>
                                                          <?php } ?>
                                                    </li>
                                                    <?php } ?>				  
                                                <?php }else if($role == 'disable'){ ?>
                                                	 <?php if($this->Format->isAllowed('Enable User',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
							<a class="icon-enable-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?act=<?php echo urlencode($user['User']['uniq_id']); ?>&role=<?php echo $_GET['role']; ?>" Onclick="return confirm('<?php echo __('Are you sure you want to enable');?> \'<?php echo $user['User']['name']; ?>\' ?')"><i class="material-icons">&#xE87A;</i> <?php echo __('Enable');?></a>
                                                    </li>
                                                <?php } ?>
                                                 <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
							<input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
							<a id="rmv_prj_<?php echo $user['User']['id'];?>" class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-total-project="<?php echo $user['User']['total_project'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;" <?php } ?>><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                    </li>
                                                <?php } ?>
                                                <?php }else if($role == 'client'){ 
                                                    if($user['CompanyUser']['is_active'] == 0){ ?>
                                                    	<?php if($this->Format->isAllowed('Enable User',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <a class="icon-enable-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?act=<?php echo urlencode($user['User']['uniq_id']); ?>&role=<?php echo $_GET['role']; ?>" Onclick="return confirm('<?php echo __('Are you sure you want to enable');?> \'<?php echo $user['User']['name']; ?>\' ?')"><i class="material-icons">&#xE87A;</i> <?php echo __('Enable');?></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
                                                            <a id="rmv_prj_<?php echo $user['User']['id'];?>" class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-total-project="<?php echo $user['User']['total_project'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;" <?php } ?>><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php } else { ?>
                                                    	 <?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <a class="icon-assign-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>"><i class="material-icons">&#xE85D;</i> <?php echo __('Assign Project');?></a>
                                                        </li>
                                                    <?php } ?>
                                                     <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
                                                            <a class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-total-project="<?php echo $user['User']['total_project'];?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                            <span id="rmv_prj_<?php echo $user['User']['id'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;"<?php } ?>></span>
                                                        </li>
                                                    <?php } ?>
                                                     <?php if(USER_TYPE ==1){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php if(USER_TYPE ==1){ ?>
								<?php if($user['User']['is_moderator']){ ?>
                                                                    <a class="icon-moderator icon-remove-modrt" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-type="0" onclick="grantOrRemoveModerator(this);"><i class="material-icons">&#xE8F1;</i> <?php echo __('Revoke Moderator');?></a>
								<?php } else { ?>
                                                                    <a class="icon-moderator icon-add-modrt" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-type="1" onclick="grantOrRemoveModerator(this);"><i class="material-icons">&#xE8E9;</i> <?php echo __('Grant Moderator');?></a>
								<?php } ?>
                                                         <?php } ?>
                                                        </li>
                                                    <?php } ?>
                                                        <?php if(($this->Format->isAllowed('Delete User',$roleAccess) && !$user['User']['dt_last_login']) || $this->Format->isAllowed('Disable Users',$roleAccess) ){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php if(!$user['User']['dt_last_login']) { ?>
                                                            	<?php if($this->Format->isAllowed('Delete User',$roleAccess)){ ?>
                                                                <a class="icon-delete-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?del=<?php echo urlencode($user['User']['uniq_id']); ?>&role=<?php echo $_GET['role']; ?>" Onclick="return confirm('<?php echo __('Are you sure you want to delete');?> \'<?php echo $user['User']['email']; ?>\' ?')"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                                            <?php } ?>
                                                            <?php }else{?>
                                                            	<?php if($this->Format->isAllowed('Disable Users',$roleAccess)){ ?>
                                                                <a class="icon-disable-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?deact=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to disable');?> \'<?php echo $user['User']['name']; ?>\' ?')"><i class="material-icons">&#xE909;</i> <?php echo __('Disable');?></a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </li>
                                                    <?php } ?>
						  								  <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php  if(($istype == 1 || $istype == 2) && !$user['User']['dt_last_login']) { ?>
                                                                <a class="icon-resend-usr" href="javascript:void(0);" onclick="return resend_invitation('<?php echo $user['User']['qstr']; ?>','<?php echo $user['User']['email']; ?>');"><i class="material-icons">&#xE040;</i> <?php echo __('Resend');?></a><br />
                                                            <?php } ?>
                                                        </li>
                                                    <?php } ?>
                                                      <?php if(SES_TYPE ==1 || SES_TYPE==2){ ?>
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php if($user['CompanyUser']['is_client'] == '0'){  ?>
                                                                <a class="icon-client-usr" href="<?php echo HTTP_ROOT;?>users/manage/?grant_client=<?php echo urlencode($user['User']['uniq_id']); ?>" onclick="return confirm('<?php echo __('Are you sure you want to mark');?> \'<?php echo ucfirst($user['User']['name']); ?>\' <?php echo __('as client');?> ?')"><i class="material-icons">&#xE7FB;</i> <?php echo __('Mark Client');?></a>
                                                            <?php } else {?>
                                                                <a class="icon-revclient-usr" href="<?php echo HTTP_ROOT;?>users/manage/?revoke_client=<?php echo urlencode($user['User']['uniq_id']); ?>" onclick="return confirm('<?php echo __('Are you sure you want to revoke client access from');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE7FF;</i> <?php echo __('Revoke Client');?></a>
                                                            <?php } ?>
                                                        </li>                                                   
                                                        <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php if ($user['CompanyUser']['user_type'] == 2) { ?>
								<a class="icon-revadmin-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?revoke_admin=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to revoke Admin privilege from');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE7FF;</i> <?php echo __('Revoke Admin');?></a>
                                                            <?php } else {?>
								<a class="icon-admin-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?grant_admin=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to grant Admin privilege to');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE914;</i> <?php echo __('Grant Admin');?></a>
                                                            <?php } ?>
                                                        </li>
                                                         <?php } ?>				  
                                                    <?php } ?>
                                                <?php } else { ?>
                                                	<?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <a class="icon-assign-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>"><i class="material-icons">&#xE85D;</i> <?php echo __('Assign Project');?></a>
                                                    </li>
                                                <?php } ?>
                                                <?php if($this->Format->isAllowed('Remove Project',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <input id="rmv_allprj_<?php echo $user['User']['id'];?>" type="hidden" value="<?php echo $user['User']['all_projects'];?>"/>
                                                        <a class="icon-remprj-usr" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-total-project="<?php echo $user['User']['total_project'];?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove Project');?></a>
                                                        <span id="rmv_prj_<?php echo $user['User']['id'];?>" <?php if($user['User']['all_project'] == ''){ ?> style="display:none;"<?php } ?>></span>	
                                                    </li>
                                                    <?php } ?>
                                                     <?php if(SES_TYPE == 1 || SES_TYPE == 2){
                                                     	if($user['CompanyUser']['user_type'] != 1 && $user['CompanyUser']['user_type'] != 2){
                                                      ?>
		                                                <li>
		                                                    <a href="javascript:void(0);" class="icon-assgn-role-user" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name']; ?>"><i class="material-icons">&#xE147;</i><?php echo __("Assign Role");?></a>
		                                                </li>
		                                            <?php } } ?>
                                                    <?php if(USER_TYPE ==1){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                            <?php if($user['User']['is_moderator']){ ?>
                                                                <a class="icon-moderator icon-remove-modrt" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-type="0" onclick="grantOrRemoveModerator(this);"><i class="material-icons">&#xE8F1;</i> <?php echo __('Revoke Moderator');?></a>
                                                            <?php } else { ?>
                                                                <a class="icon-moderator icon-add-modrt" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-type="1" onclick="grantOrRemoveModerator(this);"><i class="material-icons">&#xE8E9;</i> Grant Moderator</a>
                                                            <?php } ?>
                                                    </li>
                                                     <?php } ?>
                                                    <?php if(($this->Format->isAllowed('Delete User',$roleAccess) && !$user['User']['dt_last_login']) || $this->Format->isAllowed('Disable Users',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <?php if(!$user['User']['dt_last_login']) { ?>
                                                        	<?php if($this->Format->isAllowed('Delete User',$roleAccess)){ ?>
                                                            <a class="icon-delete-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?del=<?php echo urlencode($user['User']['uniq_id']); ?>&role=<?php echo $_GET['role']; ?>" Onclick="return confirm('<?php echo __('Are you sure you want to delete');?> \'<?php echo $user['User']['email']; ?>\' ?')"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                                        <?php } ?>
                                                        <?php } else {?>
                                                        	<?php if($this->Format->isAllowed('Disable Users',$roleAccess)){ ?>
                                                            <a class="icon-disable-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?deact=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to disable');?> \'<?php echo $user['User']['name']; ?>\' ?')"><i class="material-icons">&#xE909;</i> <?php echo __('Disable');?></a>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
						  							 <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <?php  if(($istype == 1 || $istype == 2) && !$user['User']['dt_last_login']) { ?>
                                                            <a class="icon-resend-usr" href="javascript:void(0);" onclick="return resend_invitation('<?php echo $user['User']['qstr']; ?>','<?php echo $user['User']['email']; ?>');"><i class="material-icons">&#xE040;</i> <?php echo __('Resend');?></a><br />
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
												<?php if(SES_TYPE==1){?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <a class="icon-client-usr create_new_password" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-uid="<?php echo $user['User']['uniq_id'];?>" ><i class="material-icons">&#xE7FB;</i>  <?php echo __('Change Password');?></a>
                                                    </li>
                                                    
                                                <?php } ?>
                                                <?php if(SES_TYPE==1 || SES_TYPE==2){?>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <?php if($user['CompanyUser']['is_client'] == '0'){  ?>
                                                            <a class="icon-client-usr" href="<?php echo HTTP_ROOT;?>users/manage/?grant_client=<?php echo urlencode($user['User']['uniq_id']); ?>" onclick="return confirm('<?php echo __('Are you sure you want to mark');?> \'<?php echo ucfirst($user['User']['name']); ?>\' <?php echo __('as client');?> ?')"><i class="material-icons">&#xE7FB;</i> <?php echo __('Mark Client');?></a>
                                                        <?php } else {?>
                                                            <a class="icon-revclient-usr" href="<?php echo HTTP_ROOT;?>users/manage/?revoke_client=<?php echo urlencode($user['User']['uniq_id']); ?>" onclick="return confirm('<?php echo __('Are you sure you want to revoke client access from');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE7FF;</i> <?php echo __('Revoke Client');?></a>
                                                        <?php } ?>
                                                    </li>
                                                    <li data-usr-id="<?php echo $user['User']['id'];?>" data-usr-name="<?php echo $user['User']['email'];?>">
                                                        <?php if ($user['CompanyUser']['user_type'] == 2) { ?>
                                                            <a class="icon-revadmin-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?revoke_admin=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to revoke Admin privilege from');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE7FF;</i> <?php echo __('Revoke Admin');?></a>
                                                        <?php } else {?>
                                                            <a class="icon-admin-usr" href="<?php echo HTTP_ROOT; ?>users/manage/?grant_admin=<?php echo urlencode($user['User']['uniq_id']); ?>" Onclick="return confirm('<?php echo __('Are you sure you want to grant Admin privilege to');?> \'<?php echo ucfirst($user['User']['name']); ?>\' ?')"><i class="material-icons">&#xE914;</i> <?php echo __('Grant Admin');?></a>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                                <?php } ?>				  
                                        <?php } ?>	  
					<?php if((SES_TYPE ==1 || (SES_TYPE !=3 && $user['CompanyUser']['user_type'] != 1)) && $role != 'disable'){?>
                                            <li><a class="edit-exist-usr" id="edit-exist-usr<?php echo $user['User']['id'];?>" href="javascript:void(0);" data-usr-id="<?php echo $user['User']['id'];?>" data-usr-uid="<?php echo $user['User']['uniq_id'];?>" data-usr-name="<?php echo $user['User']['name'];?>" data-comp-count="<?php echo ($userinmorecompany && in_array($user['User']['id'],$userinmorecompany) && SES_ID != $user['User']['id'])?1:0;?>"><i class="material-icons">&#xE8A6;</i> <?php echo __('Edit Profile');?> <?php echo ($userinmorecompany && in_array($user['User']['id'],$userinmorecompany) && SES_ID != $user['User']['id'])? '<i class="material-icons">&#xE897;</i>':'';?></a> </li>
					<?php } ?>
                                    </ul>
				</span>
			</div>
			<?php $random_bgclr = $this->Format->getProfileBgColr($user['User']['id']); ?>			
			<div id="pimg_<?php echo $user['User']['id']; ?>" class="user_img holder <?php echo $random_bgclr; ?>">
				<?php if(trim($user['User']['photo'])) {?>
					<img class="lazy" data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $user['User']['photo']; ?>&sizex=94&sizey=94&quality=100" width="94" height="94" />
				<?php } else { ?>
					<?php if (isset($user['User']['name']) && trim($user['User']['name'])) { ?>
                                            <span class="name_txt"><?php echo mb_substr(trim($user['User']['name']),0,1, "utf-8"); ?></span>
                                        <?php }else if(isset($user['User']['short_name']) && trim($user['User']['short_name'])){
                                            echo mb_substr(trim($user['User']['short_name']),0,1, "utf-8");
                                        }else{ ?>
                                            <img src="<?php echo HTTP_ROOT; ?>img/images/user.png" />
                                        <?php } ?>
				<?php } ?>									
			</div>
			<h3 class="invite_user_cls ellipsis-view" id="pn_<?php echo $user['User']['id']; ?>" data-usr-id="<?php echo $user['User']['id']; ?>" data-usr-name="<?php echo trim($user['User']['name']); ?>" title="<?php echo trim($user['User']['name']); ?>" rel="tooltip" ><?php if(isset($user['User']['name']) && trim($user['User']['name'])) {echo ucfirst($user['User']['name']); } else { echo "&nbsp;";} ?></h3>
			<h4 id="psn_<?php echo $user['User']['id']; ?>"><?php echo $user['User']['short_name']; ?></h4>
		</div>
		
		
		<div class="usr_cnts">
			<ul>
				<li>
					<span class="cnt_ttl_usr"><?php echo __('Last Activity');?></span>
					<span class="cnt_usr" id="pla_<?php echo $user['User']['id']; ?>">
						<?php
						if ($user['CompanyUser']['is_active'] == 0 && $_GET['role'] == 'invited') {
						$activity = "<span class='fnt_clr_rd'>".__("Invited",true)."</span>";
						}else if ($_GET['role'] == 'recent') {
						if($user['User']['is_active'] == 2){
							$activity = "<span class='fnt_clr_rd'>".__("Invited",true)."</span>";
						}else if(($istype == 1 || $istype == 2) && !$user['User']['dt_last_login']) {
							$activity = "<span class='fnt_clr_rd'>".__("No activity yet",true)."</span>";
						}else if($user['User']['dt_last_login']){
							$activity = $user['User']['latest_activity'];
						}
						}else {
						if ($user['User']['dt_last_login']) {
							$activity = $user['User']['latest_activity'];
						} elseif ($user['CompanyUser']['is_active']) {
						}
						if(($istype == 1 || $istype == 2) && !$user['User']['dt_last_login']) {
							if($user['CompanyUser']['is_active'] == 2){
							$activity = "<span class='fnt_clr_rd'>".__("Invited",true)."</span>";
							}else{
							$activity = "<span class='fnt_clr_rd'>".__("No activity yet",true)."</span>";
							}
						}
						} 
						echo $activity;
						?>											
					</span>
				</li>
				<li id="tour_info_user">
					<span class="cnt_ttl_usr"><?php echo __('Created');?></span>
					<span class="cnt_usr" id="pcr_<?php echo $user['User']['id']; ?>">
						<?php
							if ($role == "invited") {
							$crdt = $user['UserInvitation']['created'];
							} else if ($role == "recent") {
							$crdt = $user['User']['created'];	 
							}else{
							$crdt = $user['CompanyUser']['created'];
							}
							if ($crdt != "0000-00-00 00:00:00") {
								echo $user['User']['created_on'];
							} ?>
					</span>
				</li>
				<li>
					<span class="usr_email cnt_ttl_usr"><?php echo __('Email');?></span>
					<span class="cnt_usr" id="pemail_<?php echo $user['User']['id']; ?>" title="<?php echo $user['User']['email']; ?>">
					<?php 
					$email = $this->Format->shortLength($user['User']['email'],25);
					echo $email; ?></span>
				</li>
				<li id="tour_projs_user" <?php if($this->Format->isAllowed('Assign Project',$roleAccess)){ ?> class="disp_assn_proj_popup" <?php } ?>>				
					<span class="cnt_ttl_usr"><?php echo __('Projects');?></span>
					<span id="remain_prj_<?php echo $user['User']['id'];?>" class="cnt_usr nm_prj nm_prj_mx_width ellipsis-view" title="<?php echo $user['User']['all_project_lst']; ?>">
						<?php if(isset($user['User']['all_project']) && trim($user['User']['all_project'])) { 	echo $user['User']['all_project'];
						} else { echo 'N/A'; }
						?>
					</span>
				</li>
			</ul>
		</div>
	</div>
	<?php $count++;
		} ?>
		
    <div class="cb"></div>
    <input type="hidden" id="is_invited_user" value="<?php echo $is_invited_user;?>" />
    
   <?php //} 
   if(!isset($userArr) || empty($userArr)){ ?>
	<div class="row">
		<div class="col-lg-12 text-centre">
		    <div class="no_usr fl cmn_bdr_shadow">
			<h2 class="fnt_clr_rd">
                            <?php if($role == 'client'){ ?>
                            <?php echo __('No clients found');?>
                            <?php }else{ ?>
                            <?php echo __('No users found');?>.
                            <?php } ?>
                        </h2>
                    </div>
		</div>
	</div>
    <?php } ?>
</div>
    
<div class="cbt"></div>
<input type="hidden" id="getcasecount" value="<?php echo $caseCount; ?>" readonly="true"/>
<?php if ($caseCount) {
$page_url = HTTP_ROOT . "users/manage/?role=" . $this->params['url']['role'] . "&type=" . $this->params['url']['type'] . "&user_srch=" . $this->params['url']['user_srch'] . "&page=";
$pagedata = array('mode' => 'php', 'pgShLbl' => $this->Format->pagingShowRecords($caseCount, $page_limit, $casePage), 'csPage' => $casePage, 'page_limit' => $page_limit, 'caseCount' => $caseCount, 'page_url' => $page_url);
echo $this->element("task_paginate",$pagedata); ?>
<?php } ?>
<input type="hidden" id="totalcount" name="totalcount" value="<?php echo $count; ?>"/>
</div>
<div id="projectLoader">
    <div class="loadingdata"><?php echo __('Invitation resend');?>...</div>
</div>
<div class="crt_task_btn_btm <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT && $_SESSION['KEEP_HOVER_EFFECT'] && ((Cache::read('KEEP_HOVER_EFFECT_'.SES_ID) & 2) == 2)){ ?>keep_hover_efct<?php } ?>">
	<span  class="hide_tlp_cross" title="<?php echo __('Close');?>" onclick="resetHoverEffect('user',this);">&times;</span>
	<?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
    <div class="os_plus" id="tour_invt_user_btn">
        <div class="ctask_ttip">
            <span class="label label-default">
                <?php if($role == 'client'){ ?>
                   <?php echo __('Add New Client');?>
                <?php } else {?>
                    <?php echo __('Add New User');?>
                <?php } ?>
            </span>
        </div>
        <a href="javascript:void(0)" onClick="newUser()">
            <i class="material-icons cmn-icon-prop ctask_icn">&#xE7FB;</i>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
<?php } ?>
</div>
<script>
$(document).ready(function() {		
	if(typeof hopscotch !='undefined'){
		if(localStorage.getItem("tour_type") == '0'){
		GBl_tour = tour_user<?php echo LANG_PREFIX;?>;
	}
	}
	setTimeout(hideCmnMesg, 2000);
	$('.disp_assn_proj_popup').off().on('click',function(){
		if($('.icon-assign-usr').length){
			$('.icon-assign-usr').trigger('click');
		}
	});
});
</script>