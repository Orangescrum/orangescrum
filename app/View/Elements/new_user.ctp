<?php if ((strtolower(trim($user_subscription['user_limit'])) != "unlimited") && $current_active_users >= $user_subscription['user_limit']) { ?>
    <div class="modal-body popup-container" style="padding-top:0px;" >
        <div class="modal-note-msg-err" style="">
                <span><?php echo __('Sorry, User Limit has Exceeded.');?>!</span><br/>
                <?php if (SES_TYPE == 2) { ?>
                    <span><?php echo __('Please contact your account owner to upgrade the account to add more users.');?>.</span>				
                <?php } else { ?>
                    <a class="dropdown-toggle upgrade_btn" href="<?php echo SELFHOSTED_UPGRADE; ?>" target="_blank" style="text-decoration:none !important;">
                        <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info" type="button"><i class="icon-upgrade"></i><?php echo __('Upgrade');?></button>
                    </a>
                <?php } ?>
        </div>
    </div>
<?php } ?>
<style>
.q_tour_btn:hover .mini-sidebar-label{color:#444;}
.q_tour_btn:hover .material-icons{color:#444;}
</style>
<?php echo $this->Form->create('User', array('url' => '/users/new_user', 'id' => 'myform', 'name' => 'myform', 'onsubmit' => 'return memberCustomer(\'txt_email\',\'sel_custprj\',\'loader\',\'btn\')')); ?>
    <div class="modal-body popup-container" style="padding-top:0px; ">
        <input type="hidden" name="data[TimezoneName][id]" value="<?php echo SES_TIMEZONE; ?>" id="txt_loc"/>
        <input type="hidden" name="data[User][istype]" value="3" id="sel_Typ"/>
        <?php echo $this->Form->input('role', array('id' => 'role_hid', 'type' => 'hidden')); ?>
        <div id="err_email_new" style="color:#FF0000;display:none;text-align:center; font-size: 14px;"></div>
        <div class="row">
            <div class="col-lg-12 import-g-contact">
                <div class="form-group label-floating mark_mandatory">
                    <label class="control-label" for="txt_email"><span><?php echo __('Email ID');?></span></label>
                    <?php echo $this->Form->textarea('email', array('id' => 'txt_email', 'class' => 'form-control input-lg', 'placeholder' => '','rows'=>'1')); ?>
                    <p class="help-block"><?php echo __('Use comma to separate multiple email ids');?></p>
                    
                </div>
                <?php if ($is_active_proj >= 1) { ?>
                    <div class="form-group" style="display:none;">
                        <label><?php echo __('Project to be');?><br/><?php echo __('assigned');?>:</label>
                        <div class="auto_tab_fld">
                            <?php
                            if ($is_active_proj >= 5) {
                                
                            } else {
                                echo $this->Form->input('pid', array('type' => 'select', 'label' => false, 'options' => $active_proj_list, 'id' => 'select_project', 'class' => 'form-control'));
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group" id="selected_proj_container" style="display:none;">
                        <div id="selected_proj_containerdv" style=""></div>
                    </div>
                <div class="cb height10"></div>
                    <div id="tour_asnproj_user" class="form-group project_to_be_assn proj-to-assign">
<!--                        <label class="control-label">Project to be assigned:</label>
                    <div id="viewallPrj" class="fl1 dropdown option-toggle p-6 add-new-userdrop" style=""></div>-->
                        <div class="form-group label-floating">
							<div class="cmn_help_select"></div>
                             <a href="javascript:void(0);"  class="onboard_help_anchor" style="top:16px;" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-invite-a-new-user-to-orangescrum/<?= HELPDESK_URL_PARAM ?>#assign');" title="<?php echo __("Get quick help on Project to be assigned");?>" rel="tooltip"><span class="help-icon"></span></a>
                            <label class="control-label" for=""><?php echo __('Project to be assigned');?></label>
                            <select id="assign_project_list"  class="wickEnabled form-control input-lg expand hideoverflow" rows="1" wrap="virtual" name="data[User][pid]" placeholder="" <?php if ($user_subscription['trial_expired'] == 1 && $user_subscription['subscription_id'] == 11) { ?>disabled="disabled" <?php } ?>></select>
                            <div id="err_assing_project" style="display: none;color: #FF0000;"></div>
                            <div id="autopopup_projects"></div>
                            <p class="comma-seprate-txt"></p>
                    </div>
                    </div>
                <?php } ?>
           <?php if(count($rolelist) > 0 ){?>
             <div class="form-group label-floating">
                <!-- <label class="control-label" for="select_role"><?php echo __('Assign Role');?></label> -->
                <?php   echo $this->Form->input('role_id', array('type' => 'select', 'label' => false, 'options' => $rolelist, 'id' => 'select_role', 'class' => 'form-control','empty'=>'Select Role','placeholder'=> __('Assign Role')));
          
                    ?>
            </div>
            <?php }?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
				<?php if(!isset($_COOKIE['FIRST_INVITE_2'])){ ?>
					<div class="quick_tourbtn">
							<a class="btn q_tour_btn" href="javascript:void(0);" onclick="startTourUser();">
								<div class="tour_icon"></div>
								<?php echo __('Quick Tour');?>
						</a>
					</div>
				<?php } ?>
            <?php $totUsr = ""; ?>
            <?php /*if ((strtolower(trim($user_subscription['user_limit'])) != "unlimited") && $current_active_users >= $user_subscription['user_limit']) { ?>
            <?php } else if ((strtolower(trim($user_subscription['user_limit'])) != "unlimited") && $current_active_users >= $user_subscription['user_limit']) { ?>
                <font color="#FF0000"><?php echo __('Sorry, User Limit Exceeded');?>!</font>
                <br/><br/>
                <a class="dropdown-toggle upgrade_btn" href="<?php echo HTTP_ROOT; ?>pricing" style="text-decoration:none !important;">
                    <button class="btn new_task blue_btn_sml" type="button">
                        <i class="icon-upgrade"></i><?php echo __('Upgrade');?>
                    </button>
                </a>
            <?php } else { */ ?>
                <span id="ldr" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                </span>
                <span id="btn_addmem">
                    <input type="hidden" id="uniq_id" value="<?php echo COMP_UID; ?>">
                    <span class="cancel-link cancel_on_invite" style="diaplay:none;" >
						<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closeInvitePopup();"><?php echo __('Cancel');?></button>
					</span>
                    <span class="cancel-link cancel_on_direct">
						<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closeUserPop();closePopup();"><?php echo __('Cancel');?></button>
					</span>
                    <span class="hover-pop-btn"><button type="submit" class="btn cmn_size btn_cmn_efect cmn_bg btn-info addMember_popup"><?php echo __('Add');?></button></span>
                </span>
            <?php // } ?>
            <div class="cb"></div>
        </div>
		<div class="cb"></div>
    </div>
<?php echo $this->Form->end(); ?>
<script>
	function closeUserPop(){
	   var inValid=/projects\/manage/;
	   var inValidU=/users\/manage/;
	   var inValidTask=/dashboard#/;
	   inValidU
	   if(inValidU.test(window.location.href)){		   
			GBl_tour= tour_user<?php echo LANG_PREFIX;?>;
	   }else if(inValid.test(window.location.href)){		   
			GBl_tour= tour_project<?php echo LANG_PREFIX;?>;
	   }else if(inValidTask.test(window.location.href)){		   
			GBl_tour= tour<?php echo LANG_PREFIX;?>;
	   }else{
			GBl_tour= tour<?php echo LANG_PREFIX;?>; 
	   }
    }
    $(document).ready(function(){
        $(".proj-to-assign").on("focus",".maininput" ,function(){ 
            $(this).parents(".form-group").addClass('is-focused');
        });
        $(".proj-to-assign").on("focusout",".maininput" ,function(){ 
             if($("#assign_project_list").text().trim()=='' && $(".maininput").val().trim()==''){
            $(".maininput").parents(".form-group").removeClass('is-focused');
            $(".maininput").parents(".form-group").addClass('is-empty');
            }
        });
        if($("#select_role").length > 0){
					//$("#select_role").select2();
        }
    });
	function startTourUser(){
        if($("#tour_asnproj_user").length > 0 && $("#tour_asnproj_user").is(':visible')){
		  GBl_tour= tour_invtuser<?php echo LANG_PREFIX;?>;
        }else{
            GBl_tour= tour_invtuser_no_project<?php echo LANG_PREFIX;?>;
        }
		//$('#startTourBtn').click();
		hopscotch.startTour(GBl_tour);
	}
</script>