<!--[if lte IE 9]>
<style>
	#chked_all{top:2px!important;}
</style>	
<![endif]-->
<style>
.abc{background: #FCFCFC; border: 1px solid #CCCCCC; box-shadow: 0 0 10px #AAAAAA; height: 200px;  left: 50%;  margin-left: -200px;  position: fixed;top: 100px; width: 400px;}
  .quicktask_tr_backlog .form-group.has-error.is-focused .form-control{background-image:linear-gradient(#5093EC, #5093EC), linear-gradient(#d2d2d2, #d2d2d2);background-image: -webkit-linear-gradient(#5093EC, #5093EC), linear-gradient(#d2d2d2, #d2d2d2);border-color: #d2d2d2;}
</style>
<script type="text/javascript">
var rsrch = "";
</script>

<!-- START Modal -->
<div class="container cmn-popup ">
    <div class="modal fade" id="myModal" role="dialog" style="z-index:2001">
    	<!-- Release Info Modal starts -->
		<div class="cmn_popup relese_description_pop" style="display: none;">
		    <div class="modal-dialog">
		        <div class="modal-content" id="inner_rels_detl">
		        </div>
		    </div>
		</div>
    	<!-- Release Info Modal ends-->
      <!-- Sync Notifier Modal -->
		<div class="cmn_popup sync_prog_pop" style="display: none;">
		    <div class="modal-dialog">
		        <div class="modal-content" id="inner_rels_detl">
		        	<div class="modal-header">
					   <h4 id="header_rlinfo"><?php echo __('Initial Sync in progress');?>.</h4>
					</div>
					<div class="modal-body popup-container">
					    <?php /*<div class="loader_dv" style="display: block;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div> */?>
						<div class="dtbl" target="javascript:void(0)">
							<div class="dtbl_cel">
								<img class="provider-icon os-provider-icon" alt="os logo" src="<?php echo HTTP_ROOT;?>img/github/orangescrum-64.png">
							</div>
							<div class="dtbl_cel">
								<h5><?php echo __('Syncing');?>..</h5>
							</div>
							<div class="dtbl_cel">
								<img class="provider-icon os-provider-icon" alt="git logo" src="<?php echo HTTP_ROOT;?>img/github/git-64.png">
							</div>
						</div>
						<p class="note_hnt">
							<span><i class="material-icons">error_outline</i></span>
							<?php echo __("Please don't close or refresh this page"); ?>.
						</p>
					</div>
		        </div>
		    </div>
		</div>
		<!-- New extra coupon popup starts -->
        <div class="new_extracoupon cmn_popup" style="display: none;margin-top:13%">
            <?php echo $this->element('new_extracoupon'); ?>
        </div>
		<!-- New refer a friend popup starts -->
        <div class="new_referafriend cmn_popup createnew-project-pop" style="display: none;">
            <?php echo $this->element('refer_afriend'); ?>
        </div>
        <!-- New project popup starts -->
        <div class="new_project cmn_popup createnew-project-pop" style="display: none;">
            <?php echo $this->element('new_project'); ?>
        </div>
				
				<!-- Remove User popup starts -->
        <div class="remove_active_user cmn_popup createnew-project-pop cmn_auto_scroll_modal" style="display: none;">
            <?php echo $this->element('remove_active_user'); ?>
        </div>
        <div class="feedback_form_popup cmn_popup" style="display: none;">
            <?php echo $this->element('feedback_form'); ?>
        </div>
				<!-- New onboarding starts -->
        <div class="new_onboarding_tour cmn_popup createnew-project-pop" style="display: none;">
            <?php echo $this->element('new_onboarding_tour'); ?>
        </div>
				
				<!-- New onboarding starts -->
        <div class="before_onboarding_tour cmn_popup" style="display: none;margin-top: 11%;">
            <?php echo $this->element('before_onboarding_tour'); ?>
        </div>
				
		<!--  All Wiki Popup Starts Here  -->
	
			<!-- Attachment Wiki popup starts -->
			
				<div class="attachment_pop_wiki cmn_popup" style="display: none;">
					<div class="modal-dialog modal-lg">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header popup-header">
								<button type="button" class="close close-icon" data-dismiss="modal" onclick="closeSession1();closePopup();"><i class="material-icons">&#xE14C;</i></button>
								<h4><?php echo __("All Attachments");?></h4>
								<!--<span style="color: #7899c8;font-size: 15px;font-style: italic;font-weight: bold;padding-left: 30%;" class="displayDisplayFileNamewiki"></span>-->
								<input type="hidden" id="hid_wiki_id" name="hid_wiki_name" value="" />
							</div>
							<div class="modal-body popup-container">
								<div class="loader_div_wiki"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
								<center><div id="cat_err_msg" style="color:#FF0000;display:none;"></div></center>
								
								<div style="display:none;" id="inner_attachments_wiki">
									<div class="logtime-content-wiki">
										<div>
											<table border="0" cellpadding="2" cellspacing="2" width="100%" class="ClsTableDesignwiki">
												<tr>
													<td style="width:40%;vertical-align:top;padding:0px 5px 0 0;">
														<div id="displayAllAttachwiki" style="height:440px;overflow-y:auto;overflow-x:hidden;"></div>
													</td>
													<td style="width:60%;vertical-align:top;text-align:center;padding:5px;" class="displayMainAttachwiki"></td>
												</tr>
												<tr>
													<td style="text-align:left;padding:5px;">
														<div class="button_loader_div_wiki" style="display:none;">
															<center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center>
														</div>
														<div class="displayButtonswiki">
															<button class="btn btn_blue DeleteAttachmentsClswiki" type="button"><?php echo __("Delete"); ?></button>
															<button class="btn btn_cmn_efect cmn_bg btn-info cmn_size  DownloadAttachmentsClswiki" type="button"><?php echo __("Download"); ?></button>
														</div>
													</td>
													<td style="width: 60%;vertical-align: middle;text-align: center;padding: 5px;font-size: 13px;color: #7899c8;font-weight: bold;" class="displayDisplayFileNamewiki"></td>
												</tr>
											</table>
											
											<table cellpadding="2" cellspacing="2" width="100%" class="ClsTableDesignNoResultwiki" style="display:none;">
												<tr class="text-center">
													<td colspan="2" rowspan="2" class="pad15 displayNoDataErrwiki found_null"></td>
												</tr>
											</table>
											
										</div>          
										<!--<div class="log-btn">
											<button class="btn btn_blue" name="submitInvoice" type="button" onclick="assign2Invoice();"><i class="icon-big-tick"></i>Update</button>
											<span class="or_cancel cancel_on_direct_pj">or
												<a onclick="closePopup();">Cancel</a>
											</span>
										</div>-->
									</div>
								</div>
							</div>
							<div class="modal-footer popup-footer"></div>
						</div>
					</div>
				</div>

			<!-- Attachment Wiki popup ends -->
			
			<!-- Wiki activity popup starts -->
			
				<div class="wiki_activity cmn_popup createnew-activity-pop" style="display: none;">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header popup-header">
								<button type="button" class="close close-icon" data-dismiss="modal" onclick="closeSession1();closePopup();"><i class="material-icons">&#xE14C;</i></button>
								<h4><?php echo __("All Activities");?></h4>
							</div>
							<div class="modal-body popup-container">
								<div class="loader_dv_wikiActivity"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
								<center><div id="cat_err_msg" style="color:#FF0000;display:none;"></div></center>
								
								<div id="inner_wiki_activity_details">
									<div class="activity-content-wiki">
										<div style="font-size:13px;">
											<table border="1px" cellpadding="2" cellspacing="2" width="100%" class="ActivityFirstRow">
												<tr>
													<th style="width:60%;vertical-align:top;text-align:center"><?php echo __("Activity Details"); ?></th>
													<th style="width:40%;vertical-align:top;text-align:center"><?php echo __("Created On"); ?></th>
												</tr>
											</table>
										</div>          
									</div>
								</div>
							</div>
							<div class="modal-footer popup-footer"></div>
						</div>
					</div>
				</div>
				
			<!-- Wiki activity popup ends -->
			
			
			<!-- Wiki details popup starts -->
				<div class="wiki_details_approve cmn_popup" style="display: none;">
					<?php echo $this->element('wiki_approve_details'); ?>
				</div>
				
				<?php /*?><div class="wiki_details_approve cmn_popup" style="display: none;">
					<div class="popup_title">
						<span><?php echo __('Approve Wiki Details');?></span>
						<a href="javascript:jsVoid();" onclick="closePopup();"><div class="fr close_popup">X</div></a>
					</div>
					<div class="popup_form">
						<div class="loader_dv_wikiAppr"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
						<div id="inner_wiki_approve_details"><?php echo $this->element('wiki_approve_details'); ?></div>
					</div>
				</div><?php */?>
			<!-- Wiki details popup ends -->
			
			
			<!-- Wiki comment popup starts -->
				<div class="wiki_comments cmn_popup createnew-category-pop" style="display: none;">
					<?php echo $this->element('wiki_comment'); ?>
				</div>
			<!-- Wiki comment popup ends -->
			
			<!-- New wiki Category popup starts -->
				<div class="new_wiki_category cmn_popup createnew-category-pop" style="display: none;">
					<?php echo $this->element('new_wiki_category'); ?>
				</div>
			<!-- New wiki Category popup ends -->
			
			<!-- New wiki Sub-category popup starts -->
				<div class="new_wiki_subcategory cmn_popup createnew-subcategory-pop" style="display: none;">
					<?php echo $this->element('new_wiki_subcategory'); ?>
				</div>
			<!-- New wiki Sub-category popup ends -->
			
			<!-- New wiki approver popup starts -->
				<div class="new_approver_wiki cmn_popup createnew-approver-pop" style="display: none;">
					<?php echo $this->element('new_wiki_approver'); ?>
				</div>
			<!-- New approver popup ends -->
		
		<!-- Due date change Reason popup start here  -->
        <div class="new_duedt_change_rsn cmn_popup" style="display:none;">
        <?php echo $this->element('duedt_change_reason_popup'); ?>
        </div>
        <!-- Due date change Reason popup end here  -->
		<!--  all Wiki popup Ends here   -->
        <!-- Edit Bug popup starts -->
        <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
        <div class="edit_defect cmn_defect_modal cmn_popup" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">close</i></button>
					<h4><?php echo __("Edit Bug"); ?></h4>
				</div>
				<div class="popup_form pad15">
					<?php /*<div class="def_loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div> */?>
					<div id="edit_inner_defect" style="display: none;"></div>
				</div>
			</div>
		</div>
		
        </div>
        <?php //} ?>
        <!-- Edit Bug popup ends -->

		<!-- New Bug popup starts -->
        <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
        <div class="new_defect cmn_defect_modal cmn_popup" style="display: none;">
			<div class="modal-dialog">
		        <div class="modal-content">
					<div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">close</i></button>
                        <h4><?php echo __("Create Bug"); ?></h4>
                    </div>
					<div class="popup_form pad15">
						<div class="def_loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
						<div id="inner_def" style="display: none;">
							<?php if(CONTROLLER == 'Defects' || PAGE_NAME == 'dashboard') { ?>
						<?php echo $this->element('new_defect'); ?>
							<?php } ?>
						</div>						
					</div>
		        </div>
		    </div>
        </div>
        <?php // } ?>
         <!-- New Bug popup ends -->
        <!-- Bug Status Start -->
        <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectstatus new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_status_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Defect Status Ends -->
    <!-- Bug Origin Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectorigin new_defect_bug_modal cmn_popup" style="display: none;">
        <?php  echo $this->element('defect_origin_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug Status Ends -->
    <!-- Bug Resolution Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectresolution new_defect_bug_modal cmn_popup" style="display: none;">
       <?php echo $this->element('defect_resolution_add_new_popup'); ?>
    </div>
    <?php  // } ?>
    <!-- Bug Resolution Ends -->
    <!-- Bug Sevierty Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectseverity new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_severity_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug Sevierty Ends -->

    <!-- Bug ActivityType Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectactivity_type new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_activitytype_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug ActivityType Ends -->
    <!-- Bug Category Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectcategory new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_category_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug Category Ends -->
    <!-- Bug IssueType Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectissue_type new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_issuetype_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug IssueType Ends -->
    <!-- Bug Phase Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectphase new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_phase_add_new_popup'); ?>
    </div>
    <?php // } ?>
    <!-- Bug Phase Ends -->
    <!-- Bug RootCause Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectroot_cause new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_rootcause_add_new_popup') ?>
    </div>
    <?php // } ?>
    <!-- Bug RootCause Ends -->
    <!-- Bug Fix Version Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectfix_version new_defect_bug_modal cmn_popup" style="display: none;">
       <?php echo $this->element('defect_fixversion_add_new_popup');  ?>
    </div>
    <?php // } ?>
    <!-- Bug Fix Version Ends -->
    <!-- Bug Affect Version Start -->
    <?php // if(SES_COMP == ALLOWED_COMPANY) { ?>
    <div class="new_defectaffect_version new_defect_bug_modal cmn_popup" style="display: none;">
        <?php echo $this->element('defect_affectversion_add_new_popup') ?>
    </div>
    <?php // } ?>
    <!-- Bug Affect Version Ends -->
	    <div class="cmn_popup" style="display: none;" id="kanbanViewMain">
        </div>
        <!-- New project popup END -->
		<!--work load report start-->
		<div class="cmn_popup" style="display: none;" id="workLoadMain"></div>
		<!--work load report end-->
        <!-- Recurring Task popup starts -->
        <div class="recurring_tsk_popup cmn_popup " style="display: none;">
            <?php echo $this->element('recurring_task'); ?>
        </div>
        <!-- Recurring Task popup END -->
        
        <!-- Log Time popup starts -->
        <div class="new_log cmn_popup logtime-pop cmn_tbl_widspace width_hover_tbl" style="display: none;">
            <?php echo $this->element('log_task'); ?>
        </div>
        <!-- Log Time popup ends -->
        <!-- Add or Edit Milestone popup starts -->
        <div class="mlstn cmn_popup create-taskgroup-pop" style="display: none;">
            <?php echo $this->element('popup_milestone'); ?>
        </div>
		
		  <!-- Add or Edit Milestone popup starts -->
        <div class="description cmn_popup create-taskgroup-pop" style="display: none;">
            <?php echo $this->element('popup_description'); ?>
        </div>
		
        <!-- Add or Edit Milestone popup ends -->
		
		<!-- Add or Edit Sprint popup starts -->
        <div class="sprint_add_edit cmn_popup create-taskgroup-pop" style="display: none;">
            <?php echo $this->element('popup_sprint'); ?>
        </div>
        <!-- Add or Edit Sprint popup ends -->
		<!-- Start Sprint popup starts -->
        <div class="sprint_start_pop cmn_popup create-taskgroup-pop" style="display: none;">
            <?php echo $this->element('ajax_start_sprint'); ?>
        </div>
        <!-- Start Sprint popup ends -->
		<!-- Complete Sprint popup starts -->
        <div class="sprint_complete_pop cmn_popup create-taskgroup-pop" style="display: none;">
            <?php echo $this->element('ajax_complete_sprint'); ?>
        </div>
        <!-- Complete Sprint popup ends -->
		
        <!-- Add users to projects starts -->
        <div class="add_users_to_project cmn_popup assign-user-pop osinvite-user-pop" style="display: none;">
           <?php echo $this->element('popup_add_user_to_project'); ?>
        </div>
        <!-- Add users to projects popup ends -->
        <!-- Remove users from Project popup starts -->
        <div class="rmv_prj_usr cmn_popup remove-project-pop remove-user-pop" style="display: none;">
            <?php echo $this->element('popup_remove_user_from_project'); ?>
        </div>
        <!-- Remove users from Project popup ends -->
        <!-- Edit Project popup starts -->
        <div class="edt_prj cmn_popup createnew-project-pop cmn_auto_scroll_modal" style="display: none;">
            <?php echo $this->element('popup_edit_project'); ?>
        </div>
        <!-- Edit Project popup ends -->
        <!-- Setting Project popup starts -->
        <div class="setting_prj cmn_popup setting-project-pop" style="display: none;">
            <?php echo $this->element('popup_setting_project'); ?>
        </div>
        <!-- Setting Project popup ends -->
        
        <!-- Add cases to Milestone popup ends -->
        <div class="mlstn_case cmn_popup remove-project-pop case_to_milestone" style="display: none;">
            <?php echo $this->element('popup_add_case_to_milestone'); ?>
        </div>
        <!-- Add cases to Milestone popup end -->
        
        <!-- project template create popup starts -->
        <div class="project_temp_popup cmn_popup proj-template-pop" style="display: none;">
            <?php echo $this->element('popup_add_project_template'); ?>
        </div>
        <!-- project template create popup ends --> 
		
		<!-- Mobile APP popup starts -->
        <div class="mobile-app-ppop cmn_popup proj-template-pop" style="display: none;">
            <?php echo $this->element('popup_ios-android_release'); ?>
        </div>
        <!-- Mobile APP popup ends -->
        
        <!-- Select tabs popup starts -->
        <div class="select_tab cmn_popup proj-template-pop" style="display: none;">
            <?php echo $this->element('popup_dashboard_tabs'); ?>
        </div>
        <!-- Select tabs popup ends -->
    <!-- RS Assign project popup starts -->
       
        <div class="rs_assign_project cmn_popup move_task_to_project" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_mvprj">Assign Project</h4>
                    </div>
                  <!--  <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>-->
                    <div id="rs_assign_project_content" style="display: block;">
                    <?php echo $this->element('resource_assign_project'); ?>
                    </div>
                </div>
            </div>
        </div>
         <!-- RS Assign project end -->
        <!-- Help popup starts -->
        <div class="help_popup cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="trackclick('Close Button');closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4><?php echo __('Need help');?>?</h4>
                    </div>
                    <div class="modal-body popup-container">
                        <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                        <div class="help-text"> 
                            <?php echo __("If you're stuck");?>, <a class="cmn_link_color" href="<?php echo HTTP_ROOT . 'help'; ?>" target="_blank" onclick="trackclick('Help Desk');"><?php echo __('click here');?></a> <?php echo __('for help');?>. 
                            <br><?php echo __('Still not clear');?>, <a class="support-popup cmn_link_color" href="javascript:void(0);" onclick="trackclick('Send us a line')"><?php echo __('send us a line');?></a> <?php echo __('someone from our help desk will be in touch');?>.
                        </div>
                        <div class="help-text" style="display: none;"> 
                            <?php echo __('If you get stuck or need help with anything we are here for you. Just');?> 
                            <a class=" support-popup" href="javascript:void(0);" onclick="trackclick('Send us a line')"><?php echo __('send us a line');?></a> <?php echo __('we will get back to you as soon as possible or find your answer at our');?> 
                            <a href="<?php echo HTTP_ROOT . 'help'; ?>" target="_blank" onclick="trackclick('Help Desk');"><?php echo __('help desk');?></a>.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="fr popup-btn">
                            <span class="fl hover-pop-btn">
                                <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="closePopup();trackclick('Ok ,got it!');"><?php echo __('Ok, got it');?>!</button>
                            </span>
                            <div class="cb"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Help popup ends -->
        <!-- Support popup starts -->
        <div class="support_popup cmn_popup support_popup" style="display: none;">
            <?php echo $this->element('popup_support_feedback'); ?>
        </div>
        <!-- Support popup ends -->
        <!-- New user popup starts -->
        <div class="new_user cmn_popup new_user_quickadd" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closeUserPop();closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="userpopup"><?php echo __('Add New User');?></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_user" style="display: none;">
                        <?php echo $this->element('new_user'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- New user popup ends -->
        <!-- Add project to a user popup starts -->
        <div class="add_usr_prj cmn_popup assign-project-pop add_project_to_user" style="display: none;">
            <?php echo $this->element('popup_add_project_to_user'); ?>
        </div>
        <!-- Add project to a user popup ends -->
        <div class="ass_task_user cmn_popup assign-project-pop assign_tsk_to_usr" style="display: none;">
            <?php echo $this->element('assign_tasks_user'); ?>
        </div>
        <!-- Add project to a user popup starts -->
        <div class="edit_usr_pop cmn_popup edit-user-pops" style="display: none;">
            <?php echo $this->element('edit_user_popup'); ?>
        </div>
        <div class="create_password cmn_popup" style="display: none;">
            <?php echo $this->element('create_new_password'); ?>
        </div>
        <!-- Add project to a user popup ends -->
		<!-- Add Filter -->
        <div class="add_task_filter_pop cmn_popup add-task-filter-pops" style="display: none;">
            <?php echo $this->element('save_filter'); ?>
        </div>
        <!-- Add project to a user popup ends -->
    
        <!-- Remove projects of a user popup starts -->
        <div class="rmv_usr_prj cmn_popup assign-project-pop add_project_to_user" style="display: none;">
            <?php echo $this->element('popup_remove_project_from_user'); ?>
        </div>
        <!-- Remove projects of a user popup ends -->
        
        <!-- Task template create popup starts -->
        <div class="task_temp_popup cmn_popup task_template_create" style="display: none;">
            <?php echo $this->element('popup_task_template_create'); ?>
        </div>
        <!-- Task template create popup ends -->
        <!-- Edit Task Template popup starts -->
        <div class="edt_task_temp cmn_popup task_template_edit" style="display: none;">
            <?php echo $this->element('popup_task_template_edit'); ?>
        </div>
        <!-- Edit Task Template popup ends -->
        
        <!-- tasks of project template Edit popup starts -->
        <div class="task_project_edit cmn_popup tasks_of_project_template" style="display: none;">
            <?php echo $this->element('popup_tasks_of_project_template'); ?>
        </div>
        <!-- tasks of project template Edit popup ends -->
        
        <!-- project template Edit popup starts -->
        <div class="project_temp_popup_edit cmn_popup project_template_edit" style="display: none;">
            <?php echo $this->element('popup_project_template_edit'); ?>
        </div>
        <!-- project template Edit popup ends --> 
        
        <!-- Add tasks to Project popup starts -->
        <div class="add_to_project cmn_popup add_tasks_to_project" style="display: none;">
            <?php echo $this->element('popup_add_tasks_to_project'); ?>
        </div>
        <!-- Add tasks to Project popup ends -->
		<!-- smtp popup start  -->
        <div class="smtp_email_popup cmn_popup" style="display: none;">
            <?php echo $this->element('popup_email_sts'); ?>
        </div>
        <!-- smtp popup end -->
		<!-- Import tasks to Project Template popup starts -->
        <div class="import_task_to_project_template cmn_popup add_tasks_to_project" style="display: none;">
            <?php echo $this->element('popup_add_tasks_to_project_template'); ?>
        </div>
        <!-- Import tasks to Project Template popup ends -->
        
        <!-- Create task to template popup starts -->
        <div class="add_task_to_temp cmn_popup create_task_to_template" style="display: none;">
            <?php echo $this->element('popup_create_task_to_template'); ?>
        </div>
        <!-- Create task to template popup ends -->
        
        <!-- Remove tasks from Template popup starts -->
        <div class="remove_from_task cmn_popup remove_tasks_from_template" style="display: none;">
            <?php echo $this->element('popup_remove_tasks_from_template'); ?>
        </div>
        <!-- Remove tasks from Template popup ends -->
        
        <!-- Task list export popup starts -->
        <div class="task_list_export cmn_popup" style="display: none;">
            <?php echo $this->element('popup_task_list_export'); ?>
        </div>
        <!-- Task list export popup ends -->
		
		<!-- Project list export popup starts -->
        <div class="project_list_export cmn_popup" style="display: none;">
            <?php echo $this->element('popup_project_list_export'); ?>
        </div>
        <!-- Project list export popup ends -->
		
		<!-- Resource utilization export popup starts -->
			<div class="resource_utilization_list_export cmn_popup" style="display: none;">
				<?php echo $this->element('popup_resource_utilization_export'); ?>
			</div>
		<!-- Resource utilization export popup ends -->
		
        <!-- Timelog export popup starts -->
        <div class="timelog_list_export cmn_popup" style="display: none;">
            <?php echo $this->element('popup_timelog_export'); ?>
        </div>
        <div class="inactive_caseDetails cmn_popup" style="display: none;" id ="inactiveCaseDetails">
            <?php //echo $this->element('popup_timelog_export'); ?>
        </div>
        <!-- Timelog export popup ends -->
        <!-- Support popup starts -->
        <div class="invoice_setting_popup cmn_popup" style="display: none;">
        	<div class="modal-dialog">
	    <!-- Modal content-->
			    <div class="modal-content">
			        <div class="modal-header">
			            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
			            <h4><?php echo __('Invoice Settings');?></h4>
			        </div>
		            <div id="invoice_wrapper">
		            	
		            </div>
		        </div>
		    </div>
		</div>
        <!-- Support popup ends -->
        
		<!-- Add New Link -->
		 <div class="cmn_popup popup_add_new_link" style="display: none;">
            <?php echo $this->element('popup_add_new_link'); ?>
        </div>
        <!-- End of new link -->
		<!-- Add New subtaskpop -->
		 <div class="cmn_popup popup_add_new_subtask" style="display: none;">
            <?php echo $this->element('popup_add_new_subtask'); ?>
        </div>
        <!-- End of new subtaskpop -->
							<!-- Add New reminder -->
								<div class="cmn_popup popup_add_new_reminder" style="display: none;">
											<?php echo $this->element('popup_add_new_reminder'); ?>
							</div>
							<!-- End of new reminder -->
		
				<!-- Add New meeting -->
				<div class="cmn_popup popup_add_new_meeting" style="display: none;">
					<?php echo $this->element('zoom/popup_add_new_meeting'); ?>
				</div>
				<div class="cmn_popup popup_add_existing_meeting" style="display: none;">
					<?php echo $this->element('zoom/popup_add_existing_meeting'); ?>
				</div>
				<div class="cmn_popup popup_connect_meeting" style="display: none;">
					<?php echo $this->element('zoom/popup_connect_meeting'); ?>
				</div>
				<!-- End of new meeting -->
							
		
        <!-- New customer popup starts -->
        <div class="new_customer cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="new_customer_title"><?php echo __('Add New Customer');?></h4>
                    </div>
                    <div class="">
                        <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                        <div id="inner_customer_details"><?php echo $this->element('new_customer'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New customer popup ends -->
		<!-- Assign multiple task to user starts -->
        <div class="cmn_popup assign_task_to_user" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_asntskuser"></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_asntskuser" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Assign multiple task to user ends -->
        <!-- Move project popup starts -->
        <div class="mv_project cmn_popup move_task_to_project" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_mvprj"></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_mvproj" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Move project popup ends -->
        <!-- Copy project popup starts -->
        <div class="cp_project cmn_popup copy_task_to_project" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_cpprj"></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_cpproj" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Copy project popup ends -->
        
        <!-- Create Project Template from task list page popup starts -->
        <div class="crt_project_tmpl cmn_popup create_project_template_from_task_list create_pojectplan_modal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header mbtm20">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_crtprjtmpl"></h4>
                    </div>
                   <div class="select-task mbtm10">
					<div class="form-group padnon pl-15">
						<span class="radio m_0 d-inline-block">
							<label for="selected-task">
							<input type="radio" id="selected-task" name="selectedTask" value="selectedtask" checked> Only Selected Tasks</label>
						</span>
						<span class="radio m_0 d-inline-block">
							<label for="all-task">
							<input type="radio" id="all-task" name="selectedTask" value="alltask"> All Task in Project</label>
						</span>
					</div>
					</div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_crtprojtmpl" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Create Project Template from task list page popup ends -->
        
        <!-- Move Task To Milestone popup Start -->
        <div class="movetaskTomlst cmn_popup move_task_to_milestone" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup('mvtask');"><i class="material-icons">&#xE14C;</i></button>
                        <h4>
                            <div class="fl">&nbsp;<?php echo __('Move task to task group');?>&nbsp;</div>
                            <div class="fl">&nbsp;<img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png">&nbsp;</div>
                            <div  id="mvtask_prj_ttl" class="fnt-nrml fl"></div>
                            <div class="cb"></div>
                        </h4>
                    </div>
                    <div class="">
                        <div class="loader_dv" id="mvtask_loader"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                        <div id="mvtask_mlst"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Move Task To Milestone popup end -->
				
				<!-- project type popup starts -->
        <div class="new_projecttype cmn_popup manage_project_status" style="display: none;">
            <?php echo $this->element('popup_new_project_type'); ?>
        </div>
        <div class="edit_projecttype cmn_popup manage_project_status" style="display: none;">
            <?php echo $this->element('popup_edit_project_type'); ?>
        </div
        <!-- project type popup ends -->
				
				<!-- project status popup starts -->
        <div class="new_projectstatus cmn_popup manage_project_status" style="display: none;">
            <?php echo $this->element('popup_new_project_status'); ?>
        </div>
        <div class="edit_projectstatus cmn_popup manage_project_status" style="display: none;">
            <?php echo $this->element('popup_edit_project_status'); ?>
        </div>
        <!-- project status popup ends -->
        
        <!-- Task type popup starts -->
        <div class="new_tasktype cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_new_task_type'); ?>
        </div>
        <div class="edit_tasktype cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_edit_task_type'); ?>
        </div>
        <!-- Task type popup ends -->
        <!-- Label popup starts -->
        <div class="new_label cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_new_label'); ?>
        </div>
        <div class="edit_label cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_edit_label'); ?>
        </div>
        <!-- Label popup ends -->
        <!-- Label popup starts -->
        <div class="new_tasklabel cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_new_tasklabel'); ?>
        </div>
        <!-- Label popup ends -->
				<!-- Due date change reason popup starts -->
        <div class="new_due_change_reason cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_due_change_reason'); ?>
        </div>
        <!-- Due date change reason popup ends -->
        <div class="new_custom_field cmn_popup manage_task_type" style="display: none;">
            <?php echo $this->element('popup_new_custom_field'); ?>
        </div>
        <!-- Export csv popup starts -->
        <div class="exportcsv cmn_popup export_csv_task" style="display: none;" id="exporttaskcsv_popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4><?php echo __('Export Tasks to CSV');?></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="exportcsv_content" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Export csv popup ends -->
        
        <!-- Profile Image popup starts -->
        <div class="prof_img cmn_popup edit_profile_image" style="display: none;">
            <?php echo $this->element('popup_edit_profile_image'); ?>
        </div>
        <!-- Profile Image popup ends -->
        
        <!-- Create Company popup starts -->
        <div class="create_company cmn_popup create_new_company" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4><?php echo __('Create Your Own Company');?></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="crt_cmp"></div>
                </div>
            </div>
        </div>
        <!-- Create Company popup ends -->
        <!-- New video popup starts -->
        <div class="new_video cmn_popup view_howto_video" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4><?php echo __('Introduction');?></h4>
                    </div>
                    <div class="modal-body popup-container">
                        <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                        <div id="inner_video" style="display: none;height:480px"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New video popup ends -->
		<!-- Cancel subscription popup starts -->
        <div class="cancel_subscription_pop cmn_popup new_cancl_sub_pop" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4><?php echo __('Request Cancellation');?> </h4>
                    </div>
                    <div id="cancel_subscription_pop" style="padding: 24px;font-size:16px;">
					<?php echo __("It's unfortunate to see you go. Neverthless we will honor your decision and help you with your request");?>. 
					<br /><br /><?php echo __('Please send us an email from your registered email id to');?> <span style="color:#6BA8DE;">support&#64;orangescrum&#46;com</span> <?php echo __('with a subject - "<strong>CANCEL SUBSCRIPTION');?></strong>" <?php echo __('and we will take care of it within 24hours');?>.
					</div>
                </div>
            </div>
        </div>
        <!-- Cancel subscription popup ends -->        
        <!-- Add unbilled time to invoice popup start -->
         <div id="add_invoice"  class="cmn_popup add_unbilled_time_to_invoice" style="display: none;" >
             <?php echo $this->element('popup_add_unbilled_time_to_invoice'); ?>
        </div>
        <!-- Add unbilled time to invoice popup ends -->
        
        <!-- save and send email invoice popup start -->
        <div id="EmailTemplate" class="cmn_popup save_and_send_email_invoice" style="display:none;" >
            <?php echo $this->element('popup_save_and_send_email_invoice'); ?>
        </div>
        <!-- save and send email invoice popup ends -->
        <!-- contact us inner popup start -->
        <div id="ContactUsInner" class="cmn_popup contact_us_inner" style="display:none;" >
            <?php echo $this->element('popup_contact_us_inner'); ?>
        </div>
        <!-- save and send email invoice popup ends -->
        
        <!-- Send transaction mail popup -->
        <div id="transMail" class="cmn_popup transmail_popup" style="display:none;">
            <?php echo $this->element('popup_email_transaction_invoice'); ?>
        </div>
        <!-- Send transaction mail popup Ends -->
        
        <!-- Send transaction mail popup -->
        <div id="recurring_info" class="cmn_popup recur_popup" style="display:none;">
            <?php echo $this->element('popup_recurring'); ?>
        </div>
        <!-- Send transaction mail popup Ends -->
        
         <!-- User Leave popup starts -->
        <div id="inner_leave" class="new_leave cmn_popup" style="display: none;">
            <?php echo $this->element('popup_user_leave_form'); ?>
</div>

      <div id="options_div" class="options_div cmn_popup" style="display: none;">
            <?php echo $this->element('popup_user_options'); ?>
     </div>
        <!-- User Leave popup ends -->
        <!-- contact us inner popup start -->
        <div id="createWorkFlow" class="cmn_popup create_workflow" style="display:none;" >
            <?php echo $this->element('popup_create_workflow'); ?>
        </div>
        <div id="createbookmark" class="cmn_popup create_bookmark" style="display:none;" >
            <?php echo $this->element('popup_create_bookmark'); ?>
        </div>
        <div id="editbookmark" class="cmn_popup create_bookmark" style="display:none;" >
            <?php echo $this->element('Popup_edit_bookmark'); ?>
        </div>
        
        <!-- save and send email invoice popup ends -->
        <!-- contact us inner popup start -->
        <div id="createWorkFlowStatus" class="cmn_popup create_workflow_status" style="display:none;" >
        	<div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-header">
			            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
			            <h4 id="label_title_sts"><?php echo __('Create New Status');?></h4>
			            <div id="task_status_content"></div>
			        </div>
			    </div>
			</div>
        </div>
        <!-- save and send email invoice popup ends -->
        <!-- Resource Not Available popup starts -->
        <div class="resource_notavailable cmn_popup abs_resource_notavailable" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4><?php echo __("Resource Not Available"); ?></h4>
</div>
                    <div class="modal-body popup-container">
                        <div class="loader_dv">
                            <center>
                                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="<?php echo __('Loading');?>..." title="<?php echo __('Loading');?>..." />
                                <br />
                                <p class="font13"><?php echo __('The assigned user is not available for the selected date. Please wait while I am searching other available user(s) for you');?>.</p>
                            </center>
                        </div>
                         <div id="inner_resource_notavailable"></div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    <!-- New customer popup ends -->
     <!-- DEFECT MODUELE (fOR RETEST POPUP)-->
     <!-- REPLY  DEFECT START -->
     <div class="reply_def_project cmn_defect_modal cmn_popup" style="display: none;">
		<div class="modal-dialog wdth_med">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">close</i></button>
					<h4><span id="header_reply_def_prj" class="fnt-nrml"></span></h4>
				</div>
				<div class="popup_form pad15">
					<?php /*<div class="def_loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div> */?>
					<div id="reply_def_inner_mvproj" style="display: none;"></div>
				</div>
			</div>
		</div>
    </div>
    <!-- REPLY DEFECT END -->
    <!-- Overload details popup starts -->
    <div class="nw-pr-overload cmn_popup" style="display: none;">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4 id="header_nw-pr-overload" class="mlstn_nm_long"><?php echo __("Overload Details"); ?></h4>
                </div>
                <div class="modal-body popup-container">
                   <div class="loader_dv" id="addeditMlst-nw-pr-overload"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_mlstn-nw-pr-overload" class="mils_ipad"></div>
                </div>
                <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Overload details popup starts ends -->
      <!-- Resource upgrade popup start -->
        <div class="resource_upgrade_popup cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="position: fixed;left: 50%;width: 400px;transform: translate(-50%, 100%);transform: -webkit-translate(-50%, -50%);transform: -moz-translate(-50%, -50%);transform: -ms-translate(-50%, -50%);">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 style="color:#ff8600"><?php echo __("Congratulations!"); ?></h4>                    </div>
                    <div class="modal-body popup-container">
                        <p style="font-size:14px; line-height: 20px;"><?php echo __("Now manage your Resources better with Orangescrum's Resource Availability feature. Track their availability, leave planning and utilization effortlessly");?>.</p>
                            <?php if(!$this->Format->isResourceAvailabilityOn()){ ?>
                            <p style="font-size:13px; line-height: 20px; margin-bottom: 20px; font-style: italic;"><strong><?php echo __('Note');?>:</Strong> <?php echo __('Resource Availability is not available in the Startup Plan');?></p>
                        <?php } ?>
                         <div class="popup-btn" style="text-align: right;">
                            <?php if(!$this->Format->isResourceAvailabilityOn()){ ?>
                              <?php if(SES_TYPE < 2){ ?>
                                <span class="hover-pop-btn"><a href="<?php echo HTTP_ROOT.'pricing'?>" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="return trackEventLeadTracker('Availability Pop Up','Upgrade','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Upgrade');?></a></span>
                              <?php } ?>
                                <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="openResourceVideoPopup();trackEventLeadTracker('Availability Pop Up','See How','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('See How');?>?</button></span>
                                <?php if(SES_TYPE >= 2){ ?>
                                <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();" onclick="return trackEventLeadTracker('Availability Pop Up','No Thanks','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('No thanks');?>!</button></span>
                                 <?php } ?>
                            <?php }else{ ?>
                                <span class="cancel-link"><button type="button" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="openResourceVideoPopup();trackEventLeadTracker('Availability Pop Up','See How','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('See How');?>?</button></span>
                                <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();" onclick="return trackEventLeadTracker('Availability Pop Up','No Thanks','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('No thanks');?>!</button></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    <!-- Resource upgrade popup ends -->
    <!-- Resource upgrade popup start -->
        <div class="resource_video_popup cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="position: fixed;left: 50%;transform: translate(-50%, 25%);transform: -webkit-translate(-50%, -50%);transform: -moz-translate(-50%, -50%);transform: -ms-translate(-50%, -50%);">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                     </div>
                    <div class="modal-body popup-container">
                        <div>
                            <?php /* <iframe width="560" height="315" src="https://www.youtube.com/embed/eiEewh1Ewvg?rel=0&VQ=HD720" frameborder="0" allowfullscreen></iframe> */ ?>
                        </div>
                        <div class="popup-btn" style="margin-top:10px;text-align: center;">
                            <?php if(!$this->Format->isResourceAvailabilityOn()){ ?>
                            <span class="hover-pop-btn"><a href="<?php echo HTTP_ROOT.'pricing'?>" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Upgrade');?></a></span>
                            <?php } ?>
                            <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Close');?></button></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    <!-- Resource upgrade popup ends -->
     <!-- Time sheet upgrade popup start -->
        <div class="timesheet_upgrade_popup cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="position: fixed;left: 50%;width: 400px;transform: translate(-50%, 100%);transform: -webkit-translate(-50%, -50%);transform: -moz-translate(-50%, -50%);transform: -ms-translate(-50%, -50%);">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 style="color:#ff8600"><?php echo __("Congratulations!"); ?></h4>                    </div>
                    <div class="modal-body popup-container">
                        <p style="font-size:14px; line-height: 20px;"><?php echo __("Now manage your Timelog better with Orangescrum's");?> <a href="https://helpdesk.orangescrum.com/cloud-category/timesheet/" target="_blank"><?php echo __('Timesheet');?></a> <?php echo __('feature. Manage timelog effortlessly');?>.</p>
                        <p style="font-size:13px; line-height: 20px; margin-bottom: 20px; font-style: italic;"><strong>Note:</Strong> <a href="https://helpdesk.orangescrum.com/cloud-category/timesheet/" target="_blank">Timesheet</a> is not available in the Startup Plan</p>
                         <div class="popup-btn" style="text-align: right;">                           
                              <?php if(SES_TYPE < 2){ ?>
                                <span class="hover-pop-btn"><a href="<?php echo HTTP_ROOT.'pricing'?>" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="return trackEventLeadTracker('Timesheet Pop Up','Upgrade','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Upgrade');?></a></span>
                              <?php } ?>
                              <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();" ><?php echo __('Cancel');?></button></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    <!-- time sheet upgrade popup ends -->
        <!-- Spanish Conversion -->
    <div class="spa_popup_content cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="position: fixed;left: 50%;width: 400px;transform: translate(-50%, 50%);transform: -webkit-translate(-50%, -50%);transform: -moz-translate(-50%, -50%);transform: -ms-translate(-50%, -50%);">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 style="color:#ff8600"><?php echo __("Congratulations!"); ?></h4>                    </div>
                    <div class="modal-body popup-container">                        
                        <div class="row form-group">
                            <p style="font-size:14px; line-height: 20px;"><?php echo __("Select your  preferred language");?></p>
                               <div class="col-md-9 col-sm-9" style="margin:0px; padding:0px;">
                                    <div class="radio radio-primary">
                                         <select name="language" id="notify_lang_pop" class="form-control" onchange="saveDefaultLanguage();" placeholder="<?php echo __('Language');?>">
                                            <option  <?php if ($this->Session->read('Config.language') == 'eng') { ?> selected <?php } ?> value="eng">English</option>
                                            <option  <?php if ($this->Session->read('Config.language') == 'spa') { ?> selected <?php } ?> value="spa">Spanish</option>
                                            <option  <?php if ($this->Session->read('Config.language') == 'por') { ?> selected <?php } ?> value="por">Portuguese</option>
                                            <option  <?php if ($this->Session->read('Config.language') == 'deu') { ?> selected <?php } ?> value="deu">German</option> 
                                            <option  <?php if ($this->Session->read('Config.language') == 'fra') { ?> selected <?php } ?> value="fra">French</option>
                                         </select>
<!--                                        <label><input type="radio" name="language" onclick="saveDefaultLanguage('eng')"  id="langEng" value="1" checked="checked" /><?php echo __('English');?></label>
                                        <label><input type="radio" name="language" onclick="saveDefaultLanguage('spa')" id="langSPA" value="0" /><?php echo __('Spanish');?></label>-->
                                    </div>                                   
                                </div>
                           <div class="col-md-3 col-sm-3 loaderLanguage" style="margin:0px; display:none">
                                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                          </div>
                            </div>
                        <p style="font-size:13px; line-height: 20px; margin-bottom: 20px; font-style: italic;"><strong><?php echo __('Note');?>:</Strong> <?php echo __('You can also update the language from the');?> <a href='<?php echo HTTP_ROOT;?>users/profile'><?php echo __('My Profile');?></a> <?php echo __('page later');?></p>
                         <div class="popup-btn" style="text-align: right;">
                            <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();" ><?php echo __('Cancel');?></button></span>
							<span class="hover-pop-btn"><a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="closePopup();"><?php echo __('Okay');?></a></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    <!-- Spanish Conversion popup ends -->
     <!-- Exit timer popup -->
        <div class="exit_timer_popup cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 style="color:#ff8600"><?php echo __("Alert!"); ?></h4>                    </div>
                    <div class="modal-body popup-container">
                        <p style="font-size:14px; line-height: 20px;"><?php echo __("Timer is running for this task. Do you want to save the current timelog ?");?>.</p>
 
                         <div class="popup-btn" style="text-align: right;">
                               <span class="cancel-link"><button type="button" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="saveTimer();closePopup();"><?php echo __('Okay');?></button></span>
                                <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    <!-- Exit timer popup ends -->

    <!-- User Role Mangement notifications -->
    <div class="userrolemanagementnotification cmn_popup" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content" style="position: fixed;left: 50%;width: 400px;transform: translate(-50%, 50%);transform: -webkit-translate(-50%, -50%);transform: -moz-translate(-50%, -50%);transform: -ms-translate(-50%, -50%);">
                    <div class="modal-header">
                         <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 style="color:#ff8600"><?php echo __("Congratulations!"); ?></h4>                  
                    </div>
                    <div class="modal-body popup-container">                        
                        <div class="row form-group">
                            <p style="font-size:14px; line-height: 20px;"><?php echo __("We are pleased to announce the release of ");?><strong><?php echo __("User Role Management")?></strong></p>
                               <div class="col-md-9 col-sm-9" style="margin:0px; padding:0px;">                                 
                                </div>
                            </div>
                        <p style="font-size:13px; line-height: 20px; margin-bottom: 20px; font-style: italic;"><strong><?php echo __('Note');?>:</Strong> <?php echo __('You can now manage the roles & privileges, click');?> <a href='<?php echo HTTP_ROOT;?>user-role-settings' target="_blank"><?php echo __('here');?></a></p>

                         <div class="popup-btn" style="text-align: right;">
                            <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn nothanks_btn" onclick="closePopup();" ><?php echo __('Cancel');?></button></span>
							<span class="hover-pop-btn"><a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1" onclick="closePopup();"><?php echo __('Okay');?></a></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    <!-- End -->
    <!-- User Role Mangement notifications -->
    <div class="gcProjectSetting cmn_popup" style="display: none;">
    	<div class="modal-dialog">
		    <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close close-icon" data-dismiss="modal" onclick="popup_close();"><i class="material-icons">&#xE14C;</i></button>
		            <h4><?php echo __('Connect to Google Calendar');?></h4>
		        </div>
	    		<div class="gcProjectSettingCnt"></div>
			</div>
		</div>
         <?php //echo $this->element('popup_google_calendar_setting'); ?>
    </div>
    <!-- End -->
    <!-- Resource Work Hour popup starts -->
    <div class="resource_notavailable_hrs cmn_popup" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><?php echo __(""); ?></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                    <div id="inner_resource_notavailable_hrs" style="padding: 0px 15px"></div>
					
					 <div id="inner_resource_notavailable_overload_hrs" style="padding: 0px 15px"></div>
                </div>
              
            </div>
        </div>
    </div>
    <!-- Resource Work Hour popup ends -->
    <div class="exp_timesheet_popup cmn_popup" style="display: none;" >
         <?php echo $this->element('timesheet_expt'); ?>
    </div>
    <div class="exp_ra_reports_popup cmn_popup" style="display: none;" >
         <?php echo $this->element('ra_reports_expt'); ?>
    </div>
     <!-- New Role popup starts -->
    <div class="new_user_role cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" id="tour_add_new_role">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="rolettl"><?php echo __("Create New Role"); ?></span></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                    <div id="inner_role" style="display: none;"></div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- New Role popup ends -->
    <!-- User list of a role popup -->
    <div class="user_role_list cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="user_role_name"><?php echo __("Create New Role"); ?></span></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                    <div id="inner_user_role_list" style="display: none;"></div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div> -->
            </div>
        </div>   
    </div>
    <!-- User list of a role popup ends-->
    <!-- New Role Group popup starts -->
    <div class="new_rolegroup cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="rgttl"><?php echo __("Create New Role Group"); ?></span></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                   <div id="inner_rolegroup" style="display: none;"></div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- New Role Group popup ends -->
    
    <!-- New Module popup starts -->
    <div class="new_module cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="modulettl"><?php echo __("Create New Module"); ?></span></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                   <div id="inner_module" style="display: none;"></div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- New Module popup ends -->
    
    <!-- New Action popup starts -->
    <div class="new_action cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="actionttl"><?php echo __("Create New Action"); ?></span></h4>
                </div>
                <div class="modal-body popup-container">
                    <div class="loader_dv">
                        <center>
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." />
                        </center>
                    </div>
                   <div id="inner_action" style="display: none;"></div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="fr popup-btn">
                        <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    </div>
                </div> -->
            </div>
        </div>    
    </div>
    <!-- New Role popup ends -->
    <!-- Assign role to project users popup starts -->
    <div class="assgn_role_prj_usr cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="hdr-cnt"><?php echo __("Assign Role"); ?> <i class="material-icons" style="vertical-align: middle;">keyboard_arrow_right</i>
                     <span id="header_prj_usr_assgn_role" class="fnt-nrml prj_hd_title"></span></span></h4>
                </div>
                <div class="modal-body popup-container">
		            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
		            <div id="inner_prj_usr_assgn_role"></div>
		           </div>
	            <div class="modal-footer">
		            <div class="assgn-role-btn" style="display: none; text-align: right;">
		                <span id="asgnroleloader" style="display: none;">
		                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
		                </span>
		                <span id="popupload" class="ldr-ad-btn"><?php echo __("Loading users..."); ?> <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" title="Loading..." alt="Loading..."/></span>
		                <span id="confirmbtn" style="display:block;">
		                	 <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __("Cancel"); ?><div class="ripple-container"></div></button></span>

		                    <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" id="confirmusercls" value="Confirm" type="button" onclick="assignrole(this)"><i class="icon-big-tick"></i><?php echo __("Save"); ?></button>		                  
		                </span>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
    <!-- Assign role to project users popup ends -->
     <!-- Assign role to project users popup starts -->
    <div class="assgn_role_usr_prj cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                    <h4><span id="hdr-cnt"><?php echo __("Assign Role"); ?> <i class="material-icons" style="vertical-align: middle;">keyboard_arrow_right</i>
                     <span id="header_usr_prj_assgn_role" class="fnt-nrml prj_hd_title"></span></span></h4>
                </div>
                <div class="modal-body popup-container">
		            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
		            <div id="inner_usr_prj_assgn_role"></div>
		           </div>
	            <div class="modal-footer">
		            <div class="assgn-role-btn" style="display: none;text-align: right;">
		                <span id="asgnroleusrloader" style="display: none;">
		                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
		                </span>
		                <span id="popuploadusr" class="ldr-ad-btn"><?php echo __("Loading users..."); ?> <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" title="Loading..." alt="Loading..."/></span>
		                <span id="confirmbtnusr" style="display:block;">
		                	 <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __("Cancel"); ?><div class="ripple-container"></div></button></span>

		                    <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" id="confirmuserclsusr" value="Confirm" type="button" onclick="assignroleuser(this)"><i class="icon-big-tick"></i><?php echo __("Save"); ?></button>
		                </span>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
    <!-- Assign role to project users popup ends -->

    <!-- Manage Project role Actions popup starts -->
    <div class="manage_role_prj_usr cmn_popup" style="display: none;">
    	<div class="modal-dialog modal-md">
    		<div class="modal-content">
    			<div class="modal-header">
                    <button type="button" class="close close-icon" onclick="closePopupMR();"><i class="material-icons" style="vertical-align: middle;">&#xE14C;</i></button>
                    <h4><span id="hdr-cnt"><?php echo __("Project Role"); ?> <i class="material-icons">keyboard_arrow_right</i>
                     <div id="header_prj_usr_manage_role" class="fnt-nrml fl prj_hd_title"></div></span></h4>
                </div>
		         <div class="modal-body popup-container">
		            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
		            <div id="inner_prj_usr_manage_role" style="height:500px;overflow:auto"></div>

		            <div class="manage-role-btn" style="display: none;">
		                <span id="manageroleloader" style="display: none;">
		                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
		                </span>
		            </div>
		        </div>
	    </div>
    	</div>
    </div>
    <!-- Manage Project role Actions popup ends -->
	<!-- Make parent task as subtask popup starts -->
        <div class="mk_tsk_sbtsk cmn_popup make_task_to_subtask" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
                        <h4 id="header_mk_tsk_sbtsk"></h4>
                    </div>
                    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                    <div id="inner_mk_tsk_sbtsk" style="display: none;"></div>
                </div>
            </div>
        </div>
        <!-- Make parent task as subtask  popup ends -->
    </div>
</div>
<!-- END Modal -->
<?php if(SES_COMP == ALLOWED_COMPANY || 1){ // right side task detail modal ?>
   <div class="modal fade slide_right_modal task_details_modal" id="myModalDetail" role="dialog">
   <!-- Task Detail Popup -->
        <div class="task_details_popup pr" style="display: none;">
            <div class="modal-dialog width-80-per">
                <div class="modal-content">
                     <div class="modal-body popup-container modal-taskdetal-pop-up">
						<div class="close_modal"><button type="button" class="close" data-dismiss="modal" onclick="closePopup('dtl_popup');"><i class="material-icons">&#xE14C;</i></button></div>
                         <div id="cnt_task_detail_kb">
                         </div>
                         <div class="loader_bg" id="caseLoaderPopupKB"> 
                                <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="loading..."/></div>
                          </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- Support popup ends -->
<?php } else{ ?>
    <div class="modal fade" id="myModalDetail" role="dialog">
   <!-- Task Detail Popup -->
        <div class="task_details_popup pr" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                   <div class="modal-header">
                    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup('dtl_popup');"><i class="material-icons">&#xE14C;</i></button>
                   </div>
                     <div class="modal-body popup-container modal-taskdetal-pop-up" style="overflow-y: auto; height: 600px;">
                         <div id="cnt_task_detail_kb">
                         </div>
                         <div class="loader_bg" id="caseLoaderPopupKB"> 
                                <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="loading..."/></div>
                          </div>
                     </div>
                </div>
            </div>
        </div>
<?php } ?>
		
   </div>

 
   <div id="myModalVideoHelp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="help_video_cnt_frame"></div>
      </div>
    </div>

  </div>
</div>
<script type="text/template" id="case_details_popup_tmpl">
<?php 
if(SES_COMP == ALLOWED_COMPANY || 1){ // add new popup for devop company
    echo $this->element('case_details_popup_new');
} else{
    echo $this->element('case_details_popup');
}
 ?>
</script>

<!-- <script type="text/template" id="git_section_tmpl">

</script> -->


<!-- <div class="modal fade feeback_modal" id="feeback_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="bnr_header">
				<?php echo __("Cool, we'd love to hear from you");?> !
				<p><?php echo __("Contact us 24/7 via email at");?> <a href="mailto:support&#64;orangescrum&#46;com">support&#64;orangescrum&#46;com</a><br/><?php echo __('Or By filling the form below');?>.</p>
			</div>
			<form id="feedback-form" methdo="post">
				<h5><?php echo __("Overall Rating");?></h5>
				<div class="star" style="display:inline-block;">
                                    <i class="material-icons str_5" onclick="setStarVal(5);">&#xE838;</i>
                                    <i class="material-icons str_4" onclick="setStarVal(4);">&#xE838;</i>
                                    <i class="material-icons str_3" onclick="setStarVal(3);">&#xE838;</i>
                                    <i class="material-icons str_2" onclick="setStarVal(2);">&#xE838;</i>
                                    <i class="material-icons str_1" onclick="setStarVal(1);">&#xE838;</i>
				</div>
				<input type="hidden" value="" id="feedback_star" /> 
				<textarea placeholder="<?php echo __('Enter Your Feedback Here');?>" id="feedback_textarea" onkeyup="enableFeedbackBTN();" ></textarea>
				<div>
					<span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link" data-dismiss="modal" onclick="closePopup();clearFeedbackData();"><?php echo __('Cancel');?></button></span>
					<input type="button" id="feedback_submit" value="<?php echo __('Submit');?>" class="submit_btn" onclick="saveFeedbackData();" />
					<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
					<p style="font-size: 14px;">Or</p>
					
					<p style="font-size: 13px;" class="loader_dv_ext_usr_p"><?php __("Need more time to explore the possibilities");?>? <a href="javascript:void(0);" onclick="extendTrialByUser();"><?php echo __("Extend trial for");?> <?php echo EXTEND_TRIAL_USER_DAYS; ?> <?php echo __("days");?></a>.</p>
					<div class="loader_dv_ext_usr" style="display:none;"><span><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="<?php echo __('Loading');?>..." title="<?php echo __('Loading');?>..." /></center></span></div>
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</div> -->



<!-- Help modal start-->
<?php //echo $this->element('help_video'); ?>
<!-- End -->
<div class="popup_overlay"></div>
<div class="popup_bg" id="popup_bg_main">

    <!-- Choose Task for project logtime popup starts  -->
    <div class="abc" style="display: none;">
	<div class="popup_title">
	    <span><i class="icon-create-logtime"></i><?php echo __('Choose an existing task');?></span>
	    <a href="javascript:jsVoid();" onclick="closetskPopup();"><div class="fr close_popup">X</div></a>
	</div>
	<div class="popup_form">
	    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
	    <div id="task_log" style="display:none;"><?php echo $this->element('existing_task'); ?></div>
	</div>
    </div>
   <!--  Choose Task for project logtime popup ends -->
    
    

    
    <!-- Cancel Subscription popup starts -->
    <div class="cancel_sub_popup_content cmn_popup scrollTop" style="display: none;">
	<div class="popup_title">
	    <span><i class="icon-create-proj"></i> <?php echo __('Cancel Subscription Information');?></span>
	    <a href="javascript:jsVoid();" onclick="closePopup();"><div class="fr close_popup">X</div></a>
	</div>
	<div class="popup_form">
	    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
	    <div id="cancel_sub_popup_content" style="display: none;"></div>
	</div>
    </div>
    <!-- Cancel Subscription popup ends -->
    
    <!-- Add users from Project popup starts -->
    <div class="add_prj_usr cmn_popup" style="display: none;">
	<div class="popup_title pad-10">
	    <div class="hdr-cnt fl">Add User </div>
		<div class="fl"><img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png"></div>
		<div id="header_prj_usr_add" class="fnt-nrml fl prj_hd_title" style="margin-left: 10px;"></div>

	    <a href="javascript:jsVoid();" onclick="closePopup();"><div class="fr close_popup">X</div></a>
        <?php if (SES_TYPE != 3) { ?>
	    <a id="invite_usr" class="dropdown-toggle upgrade_btn" onclick="newUser(1);" href="javascript:jsVoid();">
		<button class="btn blue_btn blue_btn_lrg fr mrt-10" type="button" style="margin-top: -3px;padding: 7px 10px 4px 32px;">
		    <i class="icon-invite-usr"></i>
		    <?php echo __('Add New User');?>
		</button>
	    </a>
        <?php } ?>
	</div>
	<div class="popup_form">	    
	    <div id="pop_up_add_user_label" class="fl" style="overflow: auto; max-height: 90px; width: 576px;color:#999999;padding:3px;display:none;">
	  	<!--<ul id="userList" class="holder" style="border:1px solid #FAFAFA">
	    	</ul>-->
		<?php echo __('Please check the below user(s) list and Save to add them to this Project');?>.
	    </div>
	    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
	    <div id="usersrch"  class="col-lg-4 mrt-14 fr" style="display:none;">
		<?php echo $this->Form->text('name', array('class' => 'form-control pro_srch', 'id' => 'name', 'maxlength' => '100', 'onkeyup' => "searchListWithInt('searchuser',600)", 'placeholder' => 'Enter User Name')); ?>
		<i class="icon-srch-img chng_icn"></i>
	    </div>
	    <span id="popupload1" class="usr-srh-new"><?php echo __('Loading users');?>... <img src="<?php echo HTTP_IMAGES;?>images/del.gif" title="Loading..." alt="Loading..."/></span>
	    <div class="cb"></div>
	    <div id="inner_prj_usr_add"></div>
	    
	    <div class="add-usr-btn" style="display: none;">
		<span id="userloader" style="display: none;">
		    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
		</span>
		<span id="popupload" class="ldr-ad-btn"><?php echo __('Loading users');?>... <img src="<?php echo HTTP_IMAGES;?>images/case_loader2.gif" title="Loading..." alt="Loading..."/></span>
		<span id="confirmbtn" style="display:block;">
		    <button class="btn btn_blue" id="confirmusercls" value="Confirm" type="button" onclick="assignuser(this)"><i class="icon-big-tick"></i><?php echo __('Save');?></button>
		   <!--<button class="btn btn_blue" id="confirmuserbut" value="Confirm" type="button" onclick="assignuser(this)"><i class="icon-big-tick"></i>Add & Continue</button>
		   <button class="btn btn_grey" type="button" onclick="closePopup();"><i class="icon-big-cross"></i>Cancel</button>-->
                    <span class="or_cancel">or
                        <a onclick="closePopup();"><?php echo __('Cancel');?></a>
                    </span>
		</span>
		
		<span id="excptAddContinue" style="display:none;">
		    <button class="btn btn_blue" id="confirmusercls"  value="Confirm" type="button" onclick="assignuser(this)"><i class="icon-big-tick"></i><?php echo __('Add');?></button>
		    <!--<button class="btn btn_grey" type="button" onclick="closePopup();"><i class="icon-big-cross"></i>Cancel</button>-->
                    <span class="or_cancel">or
                        <a onclick="closePopup();"><?php echo __('Cancel');?></a>
                    </span>
		</span>
	    </div>
	</div>
    </div>
    <!-- Add users from Project popup ends -->
    
    <!-- Remove cases From Milestone popup starts -->
    <div class="mlstn_remove_task cmn_popup" style="display: none;">
	<div class="popup_title pad-10">
	    <div class="hdr-cnt">
		<div class="fl">&nbsp;<?php echo __('Remove Tasks');?>&nbsp;</div>
		<div class="fl">&nbsp;<img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png">&nbsp;</div>
		<div  id="header_prj_ttl_rt" class="fnt-nrml fl"></div>
		<div class="fl">&nbsp;<img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png">&nbsp;</div>
		<div id="header_mlstn_ttl_rt" class="fnt-nrml ttc fl"></div>
		
                <?php /* <div class="fl" style="position: relative;">&nbsp;&nbsp;
                  <a href="javascript:void(0);"><span id="switch_mlstn" style="font-size: 12px;text-decoration:underline;" onclick="view_project_milestone();">Switch Task Group</span></a>
                  <ol style="list-style-type: none;">
                  <li class="dropdown" id="mlstn_drpdwn" style="position: absolute; top: 7px;left: 13px;">
                  <div class="dropdown-menu lft popup" id="mlstnpopup" style="left: 0px;">
                  <center>
                  <div id="loader_mlsmenu" style="display:none;">
                  <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="loading..."/>
                  </div>
                  </center>
                  <div id="ajaxViewMilestonesCP"></div>
                  </div>
                  </li>
                  </ol>
                  </div> */ ?>
                <div class="cb"></div>
	    </div>
	    <a href="javascript:jsVoid();" onclick="closePopup();"><div class="fr close_popup" style="margin-top: -20px;">X</div></a>
	</div>
	<div class="popup_form">
	    <div class="loader_dv" id="rmv_case_loader"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
	    
	    <div id="tsksrch"  class="col-lg-4 mrt-14 fr" style="display:none;">
		<?php echo $this->Form->text('name', array('class' => 'form-control pro_srch', 'id' => 'tsk_name', 'maxlength' => '100', 'onkeyup' => 'searchMilestoneCase()', 'placeholder' => __('Title',true))); ?>
		<i class="icon-srch-img chng_icn"></i>
	    </div>
	    
	    <span id="tskpopupload1" class="mlstn-srh-ldr"><?php echo __('Loading tasks');?>... <img src="<?php echo HTTP_IMAGES;?>images/del.gif" title="Loading..." alt="Loading..."/></span>
	    <div class="cb"></div>
	    <div id="inner_mlstn_removetask"></div>
	    
	    <div class="add-mlstn-btn" style="display: none;">
			<center>
				<span id="tskloader" style="display: none;">
					<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
				</span>
				<span id="confirmbtntsk" style="display:block;">
					<button class="btn btn_blue" id="addtsk" value="Add" type="button" onclick=" return removecaseFromMilestone(this)"><i class="icon-big-tick"></i><?php echo __('Remove');?></button>
					<!--<button class="btn btn_blue" id="addtskncont" value="Add" type="button" onclick="assignCaseToMilestone(this)"><i class="icon-big-tick"></i>Add & Continue</button>-->
					<!--<button class="btn btn_grey" type="button" onclick="closePopup();"><i class="icon-big-cross"></i>Cancel</button>-->
                    <span class="or_cancel">or<a onclick="closePopup();"><?php echo __('Cancel');?></a></span>
				</span>
			</center>
	    </div>
	</div>
    </div>
    <!-- Add cases to Milestone popup ends -->
    <!-- Create task popup starts -->
    
    <!-- Create task popup ends -->    
     <!-- <div id="template_mod_cases" style="position:fixed;left:0;top:0px;width:100%;position: absolute;background: white;" class="inner"></div>-->
	 
	 <?php if((SES_TYPE == 1 || SES_TYPE == 2) && defined('TWITTED') && TWITTED == 0 && !in_array(PAGE_NAME,array('onbording','profile','changepassword','email_notifications','email_reports'))){
		$osTwAccount = 'TheOrangescrum';
		$tweetTexts = array(
			'#Orangescrum is an Awesome Project Collaboration Tool that gives full visibility and control over your projects',
			'Organize Projects, Tasks, Documents & Meeting Minutes in one place #Orangescrum'.' @'.$osTwAccount,
			'Share of your ideas, feedbacks, questions and discussions across the team #Orangescrum'.' @'.$osTwAccount,
			'See what\'s in progress, what needs to be done and what\'s been accomplished #Orangescrum'.' @'.$osTwAccount,
			'Receive reminders, alert for close deadlines, manage tightly not to exceed budget #Orangescrum'.' @'.$osTwAccount,
			'Break-down tasks into smaller ones, share documents using google Drive & Dropbox #Orangescrum'.' @'.$osTwAccount,
			'Just sit back and keep on watching the Activity even while relaxing #Orangescrum'.' @'.$osTwAccount,
			'Win your customer\'s confidence by keeping them informed with daily scrum #Orangescrum'.' @'.$osTwAccount,
			'Keep your team on their toes by reminding them by automatic emails #Orangescrum'.' @'.$osTwAccount,
			'Get instant notification on your cell and respond with your inputs in no time #Orangescrum'.' @'.$osTwAccount,
			'Stay on top and get weekly usage report #Orangescrum'.' @'.$osTwAccount,
			'Managing Project Effectively with project collaboration tool taming inbox #Orangescrum'.' @'.$osTwAccount,
			'Get Daily Progress email from team without fail #Orangescrum'.' @'.$osTwAccount,
			'#Orangescrum is a Awesome project management tool for You & Your Team'.' @'.$osTwAccount
		);
		if($user_subscription['is_free']==1 || ($user_subscription['project_limit'] == 'Unlimited' && $user_subscription['storage'] == 'Unlimited')){
			$twHead = 'Tweet about us!';
			$twBody = 'Tweet about  your favourite project management tool and help us grow.';
		} else {
			$twHead = 'Tweet and get more Project and Storage';
			$twBody = 'Tweet about us and get 1 more Project and 30 MB more Storage.';
		}
		//$twStr = http_build_query(array('url' => HTTP_HOME, 'text' => $tweetTexts[array_rand($tweetTexts)], 'related' => $osTwAccount ), '', '&amp;');
	?>
	
	<!-- Tweet popup starts -->
    <?php /* ?><div class="tweet_popup cmn_popup" style="display: none;">
	<div class="popup_title">
	    <span><i class="icon-tweet"></i> <?php echo $twHead; ?></span>
	    <a href="javascript:jsVoid();" onclick="closePopup();"><div class="fr close_popup">X</div></a>
	</div>
	<div class="popup_form">
	    <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
	    <div class="help-text"> 
			<center><?php echo $twBody; ?></center>
		</div>
		<div class="hlpe_popbtn">
			<a href="https://twitter.com/intent/tweet?<?php echo $twStr; ?>" target="_blank">
				<button class="btn btn_blue" type="button" onclick="trackEventGoogle('Tweet and share', 'Tweet and share', 'Clicked For Tweet - Let me tweet');">
					<!--<i class="icon-tweet"></i>-->
					Let me tweet!
				</button>
			</a>
			<button class="btn btn_grey" type="button" onclick="closePopup();trackEventGoogle('Tweet and share', 'Tweet and share', 'Clicked For Tweet - No thanks');"><i class="icon-big-cross"></i>No thanks</button>
		</div>
	</div>
    </div>
    <?php */ ?>
    <!-- Tweet popup ends -->
	<?php } ?>
</div>
<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
		<div class="crttask_overlay"></div>
			<div class="create-task-container fl crt_tsk m-cmn-flow" style="display:none;">
				<div class="m-crt_task-width">
				<?php echo $this->element('case_quick'); ?>
		</div>
	</div>
<? }else{ ?> 
<?php /* ?>
<div id="create_task_pop" class="crt_tsk cmn_popup1 crt_task_slide">
	<div class="popup_form1">
		
	    <div id="inner_task">
			<!--<div class="task_slide_in">
				<span class="fl">
				<!--<i class="icon-create-tsk" id="ctask_icons"></i>-->
				<!--<span id="taskheading">Create</span> Task
				</span>
                <div class="fr imp_task"><a href="<?php echo HTTP_ROOT.'import-export';?>" class="btn btn_blue" target="_blank">Import Task</a></div>
                <div class="cb"></div>
			</div>-->
			<div class="cb"></div>
			<div class="loader_dv_edit" style="display: none;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
			<table class="create_table fl">
				<tr>
					<td colspan="2">
						<div class="fl lbl-m-wid tfont" style="padding-top:16px">Title:</div>
						<div class="fl w-88">
							<input class="form-control" type="text" placeholder="Task Title..." id="CS_title" maxlength='240' onblur='blur_txt();checkAllProj();' onfocus='focus_txt()' onkeydown='return onEnterPostCase(event)' onkeyup='checktitle_value();' />
						</div>
					</td>
				</tr>
				<tr><td colspan="2" style="height:10px;"></td></tr>
        <tr>
					<td style="width:49%;">
					<input type="hidden" name="data[Easycase][istype]" id="CS_istype" value="1" readonly="true"/>
						<div class="fl lbl-m-wid tfont">Project:</div>
						<div class="createtask fl" style="position:relative">
							<div style="font-weight: bold;" id="edit_project_div" class="ttc"></div>
							<div id="create_project_div">
							<?php 
							$is_post_btn = 1;
							if(count($getallproj) == 0){ ?>
								<div id="projUpdateTop">
									<?php if(SES_TYPE <=3){
										$is_post_btn = 0;
										//echo "<font color='#C4C4C4'>&lt;Yet to Create a Project&gt;</font>";	
										echo '<button class="btn btn_blue" type="button" onClick="newProject();">Create Project</button>';
									}else{?>
										<span class="no_project_assgn ttfont">--None--</span>	
									<?php }  ?>
								</div>
								<?php } ?>
							    
								<?php
								$projUniq1 = "";
								if(PAGE_NAME == "dashboard" && $projName!='All') {
								    if(SES_TYPE<=3){
									    $is_post_btn = $projName ? 1 : 0;
									    //$ctProjName = $projName?$projName:"<Yet to Create a Project>";
									    $ctProjName = $projName?$projName: '<button class="btn btn_blue" type="button" onClick="newProject();">Create Project</button>';
								    } else {
										$ctProjName = $projName;
									}
									$projUniq1 = $projUniq;
								    if(count($getallproj) == 1) {
									?>
									<div class="popup_link link_as_drp_dwn swtchproj fl wid" id="ctask_popup">
									    <a href="javascript:void(0);" data-toggle="dropdown" class="option-toggle case_quick_prj_border" onclick="show_prjlist(event);" >
										<span  id="projUpdateTop" class="ttc ttfont"><?php echo $ctProjName; ?></span>
									    </a>
									</div>
								<?php
								    }
								}elseif(count($getallproj) >= 1) {
									$ctProjName = $getallproj['0']['Project']['name'];
									$projUniq1 = $getallproj['0']['Project']['uniq_id'];
									if(count($getallproj) == 1) {?>
									<div class="popup_link link_as_drp_dwn swtchproj fl wid" id="ctask_popup">
									    <a href="javascript:void(0);" data-toggle="dropdown" class="option-toggle case_quick_prj_border" onclick="show_prjlist(event);" >
										<span  id="projUpdateTop" class="ttc ttfont"><?php echo $ctProjName; ?></span>
									    </a>
									</div>
									<!--<div id="projUpdateTop" class="ttc ttfont">
										<?php //echo $ctProjName; ?>
									</div> -->
								<?php }
								} ?>
								<input type="hidden" readonly="readonly" value="<?php echo $projUniq1; ?>" id="curr_active_project"/>
								<?php if(count($getallproj) > 1){ ?>
									<div class="popup_link link_as_drp_dwn swtchproj fl wid" id="ctask_popup">
									    <a href="javascript:void(0);" style="display:block;" data-toggle="dropdown" class="option-toggle case_quick_prj_border" onclick="show_prjlist(event);" >
										<span  id="projUpdateTop" class="ttc ttfont"><?php echo $ctProjName; ?></span>
										<i class="caret fr caret_margin"></i></a>
										</div>
									<div id="prjchange_loader" style="display:none;margin-left: 5px;margin-top: 10px;" class="fr">
										<img src="<?php echo HTTP_IMAGES;?>images/del.gif" title="Loading..." alt="Loading..."/></div>
									<div class="cb"></div>
									<div id="openpopup" class="popup dropdown-menu lft popup ctaskproj ttc">
										<div class="popup_con_menu" align="left">
											<?php if(count($getallproj) > 6){ ?>
<!--											<div class="find_prj_ie">Find a Project</div>-->
											<input type="text" id="ctask_input_id" class="form-control pro_srch" placeholder="Find a Project" onkeyup="search_project_easypost(this.value,event)">
											<i class="icon-srch-img"></i>
											<div id="load_find_addtask" style="display:none;" class="loading-pro">
												<img src="<?php echo HTTP_IMAGES;?>images/del.gif"/>
											</div>
											<?php } ?>
											<div align="left" id="ajaxaftersrchc" style="display: none;"></div>
											<div align="left" id="ajaxbeforesrchc">
												<?php foreach($getallproj as $getPrj){ ?>
													<a href="javascript:void(0);" class="proj_lnks" onclick="showProjectName('<?php echo rawurlencode($getPrj['Project']['name']); ?>','<?php echo $getPrj['Project']['uniq_id']; ?>')" ><?php echo $this->Format->shortLength($getPrj['Project']['name'],27); ?></a>
													<hr class="pro_div"/>
											<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
							<div id="projAllmsg" style="display:none;color:#C0504D; padding-top:10px;">Oops! No project selected.</div>
							</div>
						</div>
           
          </td>
					<td>
						<div class="fr">
						 <div class="fl lbl-m-wid tfont" style="padding:5px 0">Task Type:</div>
							<div id="sample" class="dropdown option-toggle p-6 fl wid">
									<div class="opt1" id="opt1">
										<a href="javascript:jsVoid()" class="ttfont" onclick="open_more_opt('more_opt');">
											<span id="ctsk_type">
											<?php if(isset($taskdetails) && $taskdetails['type_id']){
												foreach($select as $k=>$v){
													if($v['Type']['id'] == $taskdetails['type_id']){
													    if (trim($v['Type']['short_name']) && file_exists(WWW_ROOT."img/images/types/".$v['Type']['short_name'].".png")) {
														$imgicn = HTTP_IMAGES.'images/types/'.$v['Type']['short_name'].'.png';
													    } else {
														//$imgicn = HTTP_IMAGES.'images/types/default.png';
													    }
													    if (trim($imgicn)){ ?>
														<img class="flag" src="<?php echo $imgicn;?>" alt="type" style="padding-top:3px;"/>&nbsp;<?php echo $v['Type']['name'];?>
														<span class="value">2</span>
													    <?php } else { 
															if(mb_detect_encoding($v['Type']['name'], mb_detect_order(), true) == 'UTF-8'){
																	$cl_cs = 'taxt_typ_width_utf';
																} ?>
															<span class='<?php echo $cl_cs; ?>'><?php echo $v['Type']['name']; ?></span>
														<?php echo $v['Type']['name'];?>
													    <?php } ?>
												<?php break; }
												}
											}else{ ?>
												<span style="padding-left:5px;"></span><?php echo $GLOBALS['TYPE'][0]['Type']['name'];?>
											<?php }?>
											</span> 
											<i class="caret mtop-10 fr"></i>
										</a>
									</div>
									<div class="more_opt" id="more_opt">
										<ul class="wid">
											<?php
											foreach($GLOBALS['TYPE'] as $k=>$v){
												foreach($v as $key=>$value){
													foreach($value as $key1=>$result){
														if($key1=='name'&& $key1='short_name'){
															//$im = $value['short_name'].".png";
															if (trim($value['short_name']) && file_exists(WWW_ROOT."img/images/types/".$value['short_name'].".png")) {
															    $im1= $this->Format->todo_typ_src($value['short_name'],$value['name']);
																echo "<li>
																	<a href='javascript:jsVoid()'>
																		<img class='flag' src='".$im1."' alt='' />
																		<span class='value'>".$value['id']."
																		</span>".$value['name']."
																	</a>
																</li>";
															} else {
															    //$im1 = HTTP_IMAGES.'images/types/default.png';
																$cl_cs = 'taxt_typ_width';
																if(mb_detect_encoding($value['name'], mb_detect_order(), true) == 'UTF-8'){
																	$cl_cs = 'taxt_typ_width_utf';
																}
																echo "<li>
																	<a href='javascript:jsVoid()'>
																		<span class='".$cl_cs."'>".$value['name']."</span>
																		<span class='value'>".$value['id']."
																		</span>".$value['name']."
																	</a>
																</li>";
															}
															    
													 }
												  }
												}
											}?>
											<?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1){ ?>
											<li id='last' style="border-top:1px solid grey;">
											<div><a onclick="novalueshow('<?php //echo $value['name']; ?>')" href="javascript:void(0);" style="color:#06C; font-size:12px; padding-left:24px;">&nbsp;&nbsp;Add New</a></div></li>
		                                    <?php } ?>
										 </ul>
									</div>
								</div>
								</div>
								<div class="cb"></div>
		
					</td>
        </tr>
		<tr><td colspan="2" style="height:10px;"></td></tr>
		<tr>
			<td>
				<div class="fl lbl-m-wid tfont">Priority:</div>
						<div class="fl dropdown option-toggle p-6 wid" style="text-align:left;">
							<div class="opt1" id="opt2">
								<span id="pr_col" class="low fl" ></span><a href="javascript:jsVoid()" class="ttfont" onclick="open_more_opt('more_opt9');">
									<span id="selected_priority">
										<?php if(isset($taskdetails['priority']) && $taskdetails['priority']){
											echo $taskdetails['priority'];
										 }else{?>
											&nbsp;&nbsp;Low
										<?php }?>
									</span>
									<span class="value">2</span>
									<i class="caret mtop-10 fr"></i>
								</a>
							</div>
							<div class="more_opt" id="more_opt9">
								<ul class="wid">
								<li><span class="low fl"></span><a href="javascript:jsVoid()" class="ttfont" onclick="changepriority('low', 2)">&nbsp;&nbsp;Low</a><span class="value">2</span></li>
								<li><span class="medium fl"></span><a href="javascript:jsVoid()" class="ttfont" onclick="changepriority('medium', 1)">&nbsp;&nbsp;Medium</a><span class="value">1</span></li>
								<li><span class="high fl"></span><a href="javascript:jsVoid()" class="ttfont"onclick="changepriority('high', 0)">&nbsp;&nbsp;High</a><span class="value">0</span></li>
								</ul>
							</div>
						</div>
						<div class="cb"></div>
					</div>
			</td>
			<td>
				<div class="fr">
						<div class="fl lbl-m-wid tfont" style="padding:5px 0;">Assign To:</div>
						<div id="sample1" class="fl dropdown option-toggle p-6 wid">
						<div class="opt1" id="opt5">
							<a href="javascript:jsVoid()" class="ttfont" onclick="open_more_opt('more_opt5');">
							<span id="tsk_asgn_to">
                  
							</span>
							<i class="caret mtop-10 fr"></i>
							</a>
						</div>
						<div class="more_opt" id="more_opt5">
							<ul class="wid">
                
							</ul>
						</div>
						</div>
						<div class="cb"></div>
					</div>
			</td>
		</tr>
		<tr>
			<td class="up_file_list" style="width:300px;">
				<table id="up_files" style="font-weight:normal;width: 100%;"></table>
				<form id="cloud_storage_form_0" name="cloud_storage_form_0"  action="javascript:void(0)" method="POST">
				<div style="float: left;margin-top: 7px;" id="cloud_storage_files_0"></div>
				</form>
				<div style="clear: both;margin-bottom: 3px;"></div>
			</td>
			<td></td>
		</tr>
		
				<tr>
					<td colspan="2">
						<div class="case_field">
					
						<!--<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td id="task_priority_td" colspan="2" style="padding:6px 0 5px 0;">
									<table cellpadding="0" cellspacing="0">
										<tr>
											<td class="case_fieldprof" >
												<span id="hd1">
													<div class="fl lbl-m-wid">Priority:</div>
												</span>
											</td>
											<td align="left">
												<div class="fl prio_radio y_low" onclick="check_priority(this);" ><input type="radio" name="task_priority" value="2" id="priority_low"  class="pri-checkbox" <?php if(isset($taskdetails['priority']) && $taskdetails['priority']==2){?>checked="checked"<?php }?>/><label tabindex=4 class="pri-label"></label></div>
                                                <div class="fl pri_type">Low</div>
												<div class="fl prio_radio g_mid" onclick="check_priority(this);"><input type="radio" name="task_priority" value="1" id="priority_mid"  class="pri-checkbox" <?php if(!isset($taskdetails['priority'])){?>checked="checked"<?php }elseif($taskdetails['priority']==1){?>checked="checked"<?php }?> /><label tabindex=4 class="pri-label"></label></div>
                                                <div class="fl pri_type">Medium</div>
												<div class="fl prio_radio h_red" onclick="check_priority(this);"><input type="radio" name="task_priority" value="0" id="priority_high" class="pri-checkbox" <?php if(isset($taskdetails['priority']) && $taskdetails['priority']==0){?>checked="checked"<?php }?> /><label tabindex=4 class="pri-label"></label></div>
                                                <div class="fl pri_type">High</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>-->
					</div>
					<div id="new_case_more_div"><?php echo $this->element('case_quick'); ?></div>
					</td>
				</tr>
				<!--<tr>
					<td colspan="2" align="left">
						<div class="fl lbl-m-wid">&nbsp;</div>
						<div class="col-lg-9 fl rht-con rht_bg" style="padding-left:4px; padding-bottom:0">
							<div class="fr mor_toggle tasktoogle" id="more_tsk_opt_div" style="position: relative;float:left"><a href="javascript:jsVoid();" onclick="opencase('click');" style="text-decoration:none"><img src="<?php echo HTTP_IMAGES;?>description.png" title="Description" rel="tooltip"/>&nbsp;&nbsp;<img src="<?php echo HTTP_IMAGES;?>hours.png" title="Estimated Hours and Hours Spent" rel="tooltip"/>&nbsp;&nbsp;<img src="<?php echo HTTP_IMAGES;?>attachment.png" title="Attachments, Google Drive, Dropbox" rel="tooltip"/>&nbsp;&nbsp;More Options<b class="caret"></b></a></div>

							<div class="fr less_toggle tasktoogle" id="less_tsk_opt_div" style="display:none;position: relative;float:left"><a href="javascript:jsVoid();" onclick="closecase();"  style="text-decoration:none">Less<b class="caret"></b></a></div>
							
							<div style="position:relative;width:20px;" class="fl">
								<img src="<?php echo HTTP_IMAGES;?>images/del.gif" title="Loading..." alt="Loading..." id="loadquick" style="display:none;"/>
							</div>
						</div>

					</td>
				</tr>-->
	</table>
			<div class="cb"></div>
			<input type="hidden" value="" name="easycase_uid" id="easycase_uid"  readonly="readonly"/>
			<input type="hidden" value="" name="easycase_id" id="CSeasycaseid" readonly="readonly" />
			<input type="hidden" value="" name="editRemovedFile" id="editRemovedFile" readonly="readonly" />
			<div class="col-lg-12 task_slide_in btm_block noprint">
				<div style="float:left;width:330px;padding-left:138px;">
					<input type="hidden" name="hid_http_images" id="hid_http_images" value="<?php echo HTTP_IMAGES; ?>" readonly="true" />
					<!--<span id="quickcase" <?php if(intval($is_post_btn) == 0) {?>style="display: none;"<?php } ?> class="nwa">
					<button class="btn btn_blue" <?php if(count($getallproj) == 0) { ?>disabled="disabled"<?php }?> type="submit" onclick ="return submitAddNewCase('Post',0,'','','',1,'');"><i class="icon-big-tick"></i><span id="ctask_btn">Post</span></button>
					<!--<button class="btn btn_grey" type="reset" id="rset" onclick="crt_popup_close();"><i class="icon-big-cross"></i>Cancel</button>-->
                    <!--<span class="or_cancel">or
                    <a id="rset" onclick="crt_popup_close();">Cancel</a>
                    </span>
					</span>
					<span id="quickloading" style="display:none;padding-left:10px;padding-top:5px;">
						<img src="<?php echo HTTP_IMAGES;?>images/case_loader2.gif" title="Loading..." alt="Loading..."/>
					</span>-->
				</div>
				
				<!--<div style="float:left;width:340px;">
					
				</div>-->
			</div>
		</div>
	</div>
 </div>
 <div class="cb"></div>
<?php */ ?>
<?php } ?>
