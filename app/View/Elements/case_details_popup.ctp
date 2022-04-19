<% var showQuickAct = showQuickActDD = 0; var UserClients_dtl = ''; var clientids = '';
   var user_can_change = 0;
   var showQuickActiononListEdit = 0;
if(((csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (csUsrDtls== SES_ID))) && is_active==1) {
	var showQuickAct = 1;
}
if(showQuickAct && taskTyp.id != 10){
	var showQuickActDD = 1;
}
if(is_active == 1 && (csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (csUsrDtls== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
	user_can_change = 1;
}
 if(is_active == 1 && (csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) && (csUsrDtls== SES_ID)){
      showQuickActiononListEdit = 1;
    }
var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
var taskCreatedDate = frmtCrtdDt;
var timeBalancRemainingValue = timeBalancRemainingValue;
var taskcrtdBy = crtdBy;
var favMessage = "<?php echo __('Set favourite task');?>";
if(isFavourite){
	var favMessage ="<?php echo __('Remove from the favourite task');?>";
}
var params = parseUrlHash(urlHash);
%>
<input type="hidden" value="<%= Case_mislestone_id %>" id="Case_mislestone_id_<%= csUniqId %>"/>
<div id="t_<%= csUniqId %>" class="yoxview task_detail">    
    <div class="col-lg-12 col-sm-12 padlft-non padrht-non task-details-wrapper taskdetail_page">
                    <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
			<div class="task-detail-head task_details_title fw_tskdtail_head <%= protyCls %>">
							<div id="caseDetailsSpanNextPrev<%=csid %>" class="displayOnlyForBackLog" style="display:none;">
								<div class="padlft-non padrht-non task_action_bar_div task_detail_head">
									<div class="back-frwd-btn task_action_bar">
										<div class="fl displayParentBackButton">
											<a href="javascript:void(0)" class="back-btn task_detail_back1 pop_backbtn">
												<div class="backToParentBorder">
													<span class="os_sprite back-detail" title="<?php echo __('Back to Parent');?>" rel="tooltip"></span>
												</div>
											</a>
										</div>
										<?php if($this->Format->displayHelpVideo()){ ?>
										<a href="javascript:void(0);" class="help-video-pop inpopup" video-url = "https://www.youtube.com/embed/oHHFktaw408" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
										<?php } ?>
										<div class="fr back-frwd">
											<span class="glyphicon glyphicon-menu-left prev prevBtnBorder" title="<?php echo __('Previous');?>" rel="tooltip"></span>
											<span class="glyphicon glyphicon-menu-right next nextBtnBorder" title="<?php echo __('Next');?>" rel="tooltip"></span>
										</div>
										<input type="hidden" name="hiddden_case_uid" id="hidden_case_uid" value="" />
										<input type="hidden" name="hiddden_parent_case_uid" id="hidden_parent_case_uid" value="" />
										<div class="cb"></div>
									</div>
								</div>
							</div>
                            <h5>
								<% var easycaseTitle = showSubtaskTitle(caseTitle,csAtId,related_tasks,9,2,'detail'); %>
                                <div id="case_ttl_edit_main_<%= csUniqId %>" class="wrapword fs-hide" onmouseover="displayEdit(<%= '\''+csUniqId+'\'' %>,1);" onmouseout="displayEdit(<%= '\'' +csUniqId+ '\'' %>,0);">
                                    <div <% if((user_can_change == 1 ||isAllowed("Edit All Task")) && params[0] !="timesheet_weekly" ){ %><% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task")){ %>class="task_title_hover" style="float:left;cursor:pointer;" id="case_ttl_edit_spn_<%= csUniqId %>" title="<?php echo __('Edit Task Title');?>" rel="tooltip" onclick="showEditTitle(<%= '\'' +csUniqId+ '\'' %>);" <% } %><% }else{ %>style="float:left;"<% } %>>#<%= csNoRep %>: <%= formatText(ucfirst(caseTitle)) %></div>
																		<span class="relative sub-tasks sub-tasks-popoup"><%= easycaseTitle %></span>
                                    <div class="cb"></div>
                                </div>
                                	<% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task") || 1){ %>
                                <div class="case_ttl_edit_dv  form-group label-floating custom-task-fld title-fld top-tsk-ttl is-empty" style="display:none; width:100%;" id="case_ttl_edit_dv<%= csUniqId %>">
                                    <input class="form-control fl <?php if(SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>" maxlength="240"  placeholder="<?php echo __('Enter task title');?>..." style="width:75%;float:left;" type="text" data-caseno="<%= csNoRep %>" id="case_ttl_edit_<%= csUniqId %>" onkeyup="saveEditTitle(<%= '\'' +csUniqId+ '\'' %>,event);"/>
                                    <textarea style="display:none;" id="temp_title_holder_<%= csUniqId %>"><%= formatText(ucfirst(caseDataTitle)) %></textarea>
                                    <div class=" fr" style="padding:7px 0;">
                                        <span class="save_exit_btn"><button id="btn_blue_cancel_<%= csUniqId %>" class="btn btn-raised btn-sm" type="button" onclick="cancelEditTitle(<%= '\'' +csUniqId+ '\'' %>);"><?php echo __('Cancel');?></button></span>
                                        <span class="save_exit_btn" style="margin-right:5px;"><button id="btn_blue_save_<%= csUniqId %>" class="btn btn-raised btn-sm" type="button" onclick="saveEditTitle(<%= '\'' +csUniqId+ '\'' %>,0);"><?php echo __('Save');?></button></span>
                                        <img id="title_edit_loader_<%= csUniqId %>" src="<?php echo HTTP_IMAGES;?>images/del.gif" style="display:none;"/>
                                    </div>
                                </div>
                            <% } %>
                                <div class="cb"></div>
                            </h5>
                            <div class="create_by_taskdtl" style="display:none">
                                <p class="fl">
                                    <% if(cntdta && (cntdta>0)) { %><?php echo __('Last updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <span><%= shortLength(lstUpdBy,8) %></span> 
                                    <% if(lupdtm.indexOf('Today')==-1 && lupdtm.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %>
                                    <none title="<%= lupdtTtl %>"><%= lupdtm %>.</none>
                                </p>
                                <p class="fr">
                                    <% if(srtdt){ %><span class="start-date" title="<%= srtdtT %>" rel="tooltip">(<?php echo __('Start');?>: <%= srtdt %>)</span><% } %>
                                    <% if(csDuDtFmt){ %><span class="gray-txt">(<?php echo __('Due');?>: <%= duedate %>)</span><% } %>
                                </p>
                                <p class="fr">
                                    <% if(client_status == 1){ %>
                                        <div style="min-height:20px;">
                                            <span style="color:#A80F0A;font-size:14px;font-weight:500;float:right;"><?php echo __('Clients can not see this task');?></span>
                                            <br />
                                        </div>
                                    <% } %>
                                </p>
                                <span style="display:inline-block;">
                                            <% if(children && children != ""){ %>
                                            <span class="fl  task_parent_block" id="task_parent_block_<%= csUniqId %>">
                                                <div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + children + '\'' %>);" class=" task_title_icons_parents fl"></div>
                                                <div class="dropdown dropup fl1 open1 showParents">
                                                    <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                                        <li class="pop_arrow_new"></li>
                                                        <li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
                                                        <li><ul class="task_parent_items" id="task_parent_<%= csUniqId %>"><li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif   "></li></ul></li>
                                                    </ul>
                                                </div>
                                            </span>
                                            <% } %>
                                            <% if(depends && depends != ""){ %>
                                            <span class="fl  task_dependent_block" id="task_dependent_block_<%= csUniqId %>">
                                                <div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
                                                <div class="dropdown dropup fl1 open1 showDependents">
                                                    <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                                        <li class="pop_arrow_new"></li>
                                                        <li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>.</li>
                                                        <li><ul class="task_dependent_items" id="task_dependent_<%= csUniqId %>"><li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li></ul></li>
                                                    </ul>
                                                </div>
                                            </span>
                                            <% } %>
                                       </span>
                                <div class="cb"></div>
                            </div>
							<div class="task_action_status">
								<div class="dtbl">
									<div class="dtbl_cel">
										<div class="icon-menu-bar">
											<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Reload');?>" onclick="easycase.ajaxCaseDetails(<%= '\''+ csUniqId+'\'' %>,<%= '\'case\''%>,0,<%= '\'popup\''%>);">
												<!--<i class="material-icons">&#xE5D5;</i>-->
												<span class="cmn_tskd_sp reload_icon"></span>
											</a>
											<% if(is_active && (user_can_change || isAllowed('Edit All Task'))){ %>
											<% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task")){ %>
												<a id="edit_act<%= csUniqId %>" href="javascript:void(0)" rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ csUniqId+'\',\''+projUniqId+'\',\''+escape(htmlspecialchars(projName))+'\'' %>);closePopupCaseDetails();">
													<!--<i class="material-icons">&#xE254;</i>-->
													<span class="cmn_tskd_sp edit_icon"></span>
												</a>
											<% } %>
											<% } %>
											<% if(is_active && (SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == csUsrDtls) || isAllowed('Archive All Task'))) { %>
                      <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
												<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csProjIdRep+'\'' %>, <%= '\'t_'+csUniqId+'\'' %>,<%= '\'popdtl\'' %>);">
													<!--<i class="material-icons">&#xE861;</i>-->
													<span class="cmn_tskd_sp archive_icon"></span>
												</a>
											<?php } ?>
											<% } %> 
											<% if(!is_active){ %>
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
												<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Restore');?>" onclick="restoreTaskDetail(<%= '\''+ csUniqId+'\',\''+csNoRep+'\'' %>,<%= '\'popdtl\'' %>);">
													<!--<i class="material-icons">&#xE042;</i>-->
													<span class="cmn_tskd_sp restore_icon"></span>
												</a>
											<?php } ?>
											<% } %>
											<% if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == csUsrDtls) || isAllowed('Delete All Task')) { %>
                      <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
												<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csProjIdRep+'\'' %>, <%= '\'t_'+csUniqId+'\'' %>, <%= '\'' + isRecurring + '\'' %>,<%= '\'dtl\'' %>,<%= '\'popdtl\'' %>);">
													<!--<i class="material-icons">&#xE872;</i>-->
													<span class="cmn_tskd_sp delete_icon"></span>
												</a>
											<?php } ?>
											<% } %> 
											<% if(!parseInt(custom_status_id)){ %>
											<% if(is_active && ((is_active && csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4))) { %>
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
												<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Resolve');?>" onclick="caseResolve(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\'popup\''%>);">
													<!--<i class="material-icons">&#xE153;</i>-->
													<span class="cmn_tskd_sp resolve_icon"></span>
												</a>
											<?php } ?>
											<% } %>
											<% } %>
											<% if(is_active && ((csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4 || csLgndRep == 5))) { %>
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
												<?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
												<% if(!parseInt(custom_status_id)){ %>
												<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Close');?>" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\'popup\''%>);">
													<!--<i class="material-icons">&#xE876;</i><?php //&#xE14C; ?>-->
													<span class="cmn_tskd_sp closecase_icon"></span>
												</a>
												<% } %>
											<?php } ?>
											<?php } ?>
											<% } %>
											<?php if($this->Format->isAllowed('Download Task',$roleAccess)){ ?>
											<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Download');?>" onclick="downloadTask(<%= '\''+ csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>);">
												<!--<i class="material-icons">&#xE2C4;</i>-->
												<span class="cmn_tskd_sp download_icon"></span>
											</a>
                      <?php } ?>
                      <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
											<a href="javascript:scrollDtlPageTop($('#reply_box<%= csAtId %>'));" rel="tooltip" title="<?php echo __('Comment');?>" class="link_repto_task_dtlt" data-csatid="<%= csAtId %>">
												<span class="cmn_tskd_sp comment_icon" style="background-position: 3px -308px;"></span>
											</a>
											<span id="caseDetailsSpanFav<%=csid %>">
											<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=csid %>,<%=csProjIdRep %>,<%= '\''+csUniqId+'\'' %>,4,<%=isFavourite%>)" rel="tooltip" original-title="<%=favMessage%>" style="color:<%=favouriteColor%>;" >
											 	 <% if(isFavourite) { %>
									                <i class="material-icons">star</i>
									            <% }else{ %>
									                 <i class="material-icons" style="color:#ffffff;">star_border</i>
									            <% } %>
											  </a>
											</span>
                     <?php } ?>
											<?php /* ?>
											  <% if(csLgndRep == 1 && csTypRep!= 10) { %>
											  <a href="javascript:void(0);" onclick="startCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>);">
											  <div class="btn gry_btn smal30" rel="tooltip" title="In Progress">
											  <i class="act_icon act_start_task fl"></i>
											  </div>
											  </a>
											  <% } %><?php */ ?>
										</div>
									</div>
									<div class="dtbl_cel">
										<div class="status_top dtl_page_sts<%= csAtId %>">
											<% var typetsk_id = taskTyp.id; %>
											<?php echo $this->element('case_details_sts', array('popup' => 1)); ?>
										</div>
									</div>
								</div>
							</div>
							<?php /*<div class="dtl_toggle_arrow_txt">
								<span class="collapse_txt" id="open_detail_id"> <% if(cntdta) { %>Show Detail<% } else{ %>Hide Detail<% } %></span>
								<span class="tglarow_icon"><i class="material-icons">&#xE313;</i></span>
							</div>*/ ?>
							<div class="clearfix"></div>
                        </div>
                    </div>
					<div class="clearfix"></div>
        <div class="col-lg-9 col-sm-9 padlft-non padrht-non">
            <div class="task-detail-lft">
                <div class="task-detail-container">
					<div class="toggle_task_details fs-hide <% if(cntdta) { %>hide_detail<% } else{ %>show_detail<% } %>">
						<div class="col-lg-12 col-sm-12 padlft-non padrht-non">
							<div class="task-detail-head detials-option-cont task-detail-head-extr <% if(taskTyp.name == 'Story'){%>tsk-detail-story<%}%>">
								<div class="col-lg-3 col-sm-3 dynmic_wh">
									<span class="gray-txt"><?php echo __('Project');?></span>
									<p class="ttc"><%= shortLength(projName,16) %></p>
								</div>
								<div class="col-lg-3 col-sm-3 dynmic_wh">
									<span class="gray-txt">
									<% if(project_mothodology == 2){ %>
										<?php echo __('Sprint');?>
									<%}else{%>
									<?php echo __('Task Group');?>
									<%}%>
									</span>
									<div class=""  id="tgrpdiv<%= csAtId %>">										
									<% if(is_active && user_can_change){%>
										<div class="dropdown cmn_h_det_arrow">
											<div class="opt1" id="opt80">
												<% var more_opt = 'more_opt80'; %>
												<p class="status_tdet"  style="display:inline-block;">
												<a class="" <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?> href="javascript:void(0);"  onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)" <?php } ?> style="color:#000">
												   <% if(mistn != '') { %>
												   <% if((csLgndRep == 3 || csLgndRep ==5) && project_mothodology == 2){ %>
														<?php echo __("None");?>	
													<% }else{ %>
												   	<%= shortLength(ucfirst(formatText(mistn)),15) %>
												   	<% } %>
												   <% } else { %>
												   <% if(project_mothodology == 2){ %>
													   <% if(csLgndRep == 3 || csLgndRep ==5){ %>
													   		<?php echo __('None');?>
													   <% }else{ %>
													   		<?php echo __('Backlog');?>
													   <% } %>
												   <%}else{%>
													<?php echo __('Default Task Group');?>
												   <% } %>
												   <% } %>
													<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
												</a>
											</p>
												 <% if(spnt_cnt) { %>
												 <div class="dropdown" style="display:inline-block;">
												    <button class="btn btn-primary dropdown-toggle history_btn" type="button" <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?> data-toggle="dropdown" <?php } ?> >+ <%= spnt_cnt %></button>
												    <ul class="dropdown-menu">
												      <li class="history_heading"><%= spnt_cnt %> <?php echo __('Completed Sprint');?>.</li>
												      <%=  history_str %>
												    </ul>
												  </div>
												 <% } %>
											</div>
											<?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
										  <div class="more_opt new_opt_more" id="more_opt80<%= csAtId %>">
												<ul class="dropdown-menu" style="top: 3px;">
													<li class="searchLi">
													<input type="text" placeholder="<?php echo __('Search'); ?>" class="searchType" onkeyup="seachitemsTg(this);" />
													</li>
													<% for(var mkey in all_milestones){
														var getMilestones = all_milestones[mkey];
														milestoneName = getMilestones.Milestone.title;
														mls_id = getMilestones.Milestone.id; 
														mistnId != ''? mistnId:0; %> 
													<li><a href="javascript:void(0);" onclick="detChangeMilestone(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>, <%= '\''+escape(milestoneName)+'\'' %>, <%= '\''+mls_id+'\'' %>, <%= '\''+mistnId+'\'' %>);"><%= ucfirst(milestoneName) %></a></li>
													<% } %>
													<li><a href="javascript:void(0);" onclick="detChangeMilestone(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>, <%= '\'Default Task Group\'' %>, <%= 0 %>, <%= '\''+mistnId+'\'' %>);">
													<% if(project_mothodology == 2){ %>
												   <?php echo __('Backlog');?>
												   <%}else{%>
													<?php echo __('Default Task Group');?>
												   <% } %>
													</a></li>
												</ul>
											</div>
										<?php } ?>
										</div>
										<span id="tgrplod<%= csAtId %>" style="display:none">
												<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
										</span>
									<% }else { %>
									<p class="ttc" style="display: inline-block;">
									<% if(mistn != '') { %>
										<% if((csLgndRep == 3 || csLgndRep ==5) && project_mothodology == 2){ %>
											<?php echo __("None");?>	
										<% }else{ %>								
										<%= shortLength(ucfirst(formatText(mistn)),15) %>
										<% } %>										
									<% } else { %>
									<% if(project_mothodology == 2){ %>
									   	<% if(csLgndRep == 3 || csLgndRep ==5){ %>
									   		<?php echo __('None');?>
									   <% }else{ %>
									   		<?php echo __('Backlog');?>
									   <% } %>								   
								   <%}else{%>
									<?php echo __('Default Task Group');?>
								   <% } %>
									<% } %></p>
									 <% if(spnt_cnt) { %>
								   	<div class="dropdown" style="display:inline-block;">
									    <button class="btn btn-primary dropdown-toggle history_btn" type="button" data-toggle="dropdown">+ <%= spnt_cnt %></button>
									    <ul class="dropdown-menu">
									      <li class="history_heading"><%= spnt_cnt %> <?php echo __('Completed Sprint');?>.</li>
									      <%=  history_str %>
									    </ul>
									  </div>
								    <% } %>
									<% } %>
								</div>
								</div>
								<div class="col-lg-2 col-sm-2 type-devlop dynmic_wh">
									<div><span class="gray-txt"><?php echo __('Type');?></span></div>
									<div id="typdiv<%= csAtId %>" class="fl typ_actions <% if(showQuickAct==1){ %> dropdown<% } %>" data-typ-id = "<%= taskTyp.id %>">
									<span class="dropdown cmn_h_det_arrow">
										<p  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?><% if(showQuickAct==1){ %> class="quick_action" data-toggle="dropdown" <% } %> <?php } ?>>
											<span class="ttype_global tt_<%= getttformats(taskTyp.name)%>">
											<%= shortLength(taskTyp.name,10) %>                                                                                    
											<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
                                                                                    </span>
										</p>
										<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
										<% if(showQuickAct==1){ %>
											<ul class="dropdown-menu quick_menu">
												<input type="text" placeholder="<?php echo __('Search');?>" onkeyup="searchTaskTypeDetail(this);" style="margin:5px;padding:2px 5px; border:1px solid #ddd;" />
												<li class="pop_arrow_new"></li>
												<% for(var k in GLOBALS_TYPE) { 
												if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == csProjIdRep){
												var v = GLOBALS_TYPE[k]; var t = v.Type.id; var t1 = v.Type.short_name; var t2 = v.Type.name; %>
													<%
															var txs_typ = t2;
															$.each(DEFAULT_TASK_TYPES, function(i,n) {
																			if(i == t1){
																					txs_typ = n;
																			}
																	}); 
													%>
												<% if(t2 != taskTyp.name || 1){%>
												<li> 
													<a href="javascript:void(0);" onclick="changetype(<%= '\''+csAtId+'\'' %>, <%= '\''+t+'\'' %>, <%= '\''+t1+'\'' %>, <%= '\''+t2+'\'' %>, <%= '\''+csUniqId+'\'' %>, <%= '\''+csNoRep+'\'' %>)">
															<span class="ttype_global tt_<%= getttformats(t2)%>"><%= t2 %></span>
													</a>
												</li>
												<% } } } %>
											</ul>
											</span>
										<% } %>
									<?php } ?>
									</div>
									<span id="dettyplod<%= csAtId %>" style="display:none">
										<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
									</span>
									<div class="cb"></div>
								</div>
								
								<div class="col-lg-1 col-sm-1 dynmic_wh" <% if(taskTyp.name != 'Story'){ %> style="display:none;"<% } %> id="strpoContain<%= csAtId %>">
									<span class="gray-txt"><?php echo __('Story Point');?></span>
									<div id="strpodiv<%= csAtId %>">
									<% if(user_can_change == 1){ %>
										<p class="strpob ttc" style="">
											<span class="border_dashed">
											<% if(story_point != 0.0) { %> <%= story_point %> <% } else { %><?php echo __('None');?><% } %>
											</span>
										</p>
										<input type="text" data-est-id="<%=csAtId%>" data-est-no="<%=csNoRep%>" data-est-uniq="<%=csUniqId%>" data-est-pt="<%=story_point%>" id="strpo_cnt<%=csAtId%>" class="strpo_cnt form-control check_minute_range" style="margin-bottom: 2px;display:none;" pattern="[0-9]" maxlength="5" rel="tooltip" title="<?php echo __('You can enter as 1(that mean 1 day)');?>" onkeypress="return numeric_only(event)" value="<%= story_point %>" data-default-val="<%=story_point%>"/>
									<% }else { %>
										<p class="ttc">
										<% if(story_point != 0) { %><%= story_point %><% } else { %><?php echo __('None');?><% } %>
										</p>
									<% } %>
									</div>
									<span id="strpolod<%=csAtId%>" style="display:none;margin-left:0px;">
										<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
									</span>
								</div>
								
								<div class="col-lg-1 col-sm-1 tsk-dtail-priorty dynmic_wh">
									<span class="gray-txt"><?php echo __('Priority');?></span>
									<% if(taskTyp.id == "10"){ %>
										<div id="pridiv<%= csAtId %>" class="pri_actions high_priority">
											<input type="hidden" id="hid_prittl" value="High" />
											<p><span class="priority-symbol"></span><?php echo __('High');?></p>
										</div>
									<% } else{ %>
										<div style="" id="pridiv<%= csAtId %>" data-priority ="<%= csPriRep %>" class="pri_actions <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> <%= protyCls %><% if(showQuickAct==1){ %> dropdown<% } %> <?php } ?>">
												<input type="hidden" id="hid_prittl" value="<%= protyTtl %>" />
												<span class="dropdown cmn_h_det_arrow">
													<p  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?><% if(showQuickAct==1){ %> class="quick_action " data-toggle="dropdown" <% } %> <?php } ?>>
													<span class="priority-symbol"></span><%= protyTtl %><i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
													</p>
												<% if(csLgndRep !=3 && csLgndRep !=5){ %><div class="cb"></div><% } %>
												<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
												<% if(showQuickAct==1){ %>
													<ul class="dropdown-menu quick_menu">
														<li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'2\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
														<li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'1\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
														<li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'0\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
													</ul></span>
												<% } %>
											<?php } ?>
										</div>
										<span id="prilod<%= csAtId %>" style="display:none">
												<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
										</span>
									<% } %>
								</div>
								<div class="col-lg-1 col-sm-1 esthrs dynmic_wh">
									<span class="gray-txt"><?php echo __('Est.Hour(s)');?></span> 
									<div id="estdiv<%= csAtId %>">
									<% if(taskTyp.id !== "10" && user_can_change == 1){ %>
										<p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?>estb<?php } ?> ttc" style="">
											<span class="border_dashed">
											<% if(estimated_hours != 0.0) { %> <%= format_time_hr_min(estimated_hours) %> <% } else { %><?php echo __('None');?><% } %>
											</span>
											</p>
										<% var est_time = Math.floor(estimated_hours/3600)+':'+(Math.round(Math.floor(estimated_hours%3600)/60)<10?"0":"")+Math.round(Math.floor(estimated_hours%3600)/60); %>
										<input type="text" data-est-id="<%=csAtId%>" data-est-no="<%=csNoRep%>" data-est-uniq="<%=csUniqId%>" data-est-time="<%=est_time%>" id="est_hr<%=csAtId%>" class="est_hr form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can add time as 1.5(that mean 1 hour and 30 minutes) and press enter to save');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
									<% }else { %>
										<p class="ttc">
										<% if(estimated_hours != 0.0) { %><%= format_time_hr_min(estimated_hours) %><% } else { %><?php echo __('None');?><% } %>
										</p>
									<% } %>
									</div>
									<span id="estlod<%=csAtId%>" style="display:none;margin-left:0px;">
										<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
									</span>
								</div>
								<div class="col-lg-1 col-sm-1 dynmic_wh">
									<span class="gray-txt multilang_ellipsis" style="display:block" title="<?php echo __('Spent Hour(s)');?>"><?php echo __('Spent Hour(s)');?></span>
									<p class="ttc totalSPH"><% if(hours != 0.0) { %><%= format_time_hr_min(hours) %><% } else { %><?php echo __('None');?><% } %></p>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="clearfix"></div>
						</div>
					    <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                        <div class="user-ans-section"  <% if(!csMsgRep && !csFiles) { %> style="padding:0;"<% } %>>
                                        <% if(csMsgRep || csFiles) { %>
                
                            <h4><?php echo __('Descriptions');?></h4>                           
                            <div class="fr task-down-arw">
                                 <a id="a_0" class="" style="display:none;" href="javascript:void(0);" onclick="showDescription(0)">
                                    <span title="<?php echo __('Expand description');?>" rel="tooltip" class="glyphicon glyphicon-menu-down"></span>
                                </a>
                            </div>
                            <div class="cb"></div>
                            <div class="plane_p_txt">
                                <% if(dispSec) { %>
                                    <div id="cnt_0" class="details_task_desc wrapword" style="overflow:hidden;">
					<p><%= csMsgRep %></p>
                                        <% var fc = 0;
                                        if(csFiles) { %>
                                            <span class="attac_count_task_det attachment_wrap">
                                                <i class="material-icons">&#xE226;</i>
                                                <% if(filesArr){ %> <span class="attach_cnt"> <% if((filesArr.length)==1){ %> <?php echo __('1 Attachment');?> <%}else {%><%= filesArr.length%> <?php echo __('Attachments');?> <% } %></span> <% } else { %><?php echo __('No Attachments');?> <% } %>
                                            </span>
                                            <% var images = ""; var caseFileName = "";
                                            for(var fileKey in filesArr) {
						var getFiles = filesArr[fileKey];
						caseFileName = getFiles.CaseFile.file;
						caseFileUName = getFiles.CaseFile.upload_name;
                                                caseFileId = getFiles.CaseFile.id;
						downloadurl = getFiles.CaseFile.downloadurl;
						var d_name = getFiles.CaseFile.display_name;
						if(!d_name){ d_name = caseFileName;}
                                                if(caseFileUName == null){ caseFileUName = caseFileName;}
						if(getFiles.CaseFile.is_exist) {
                                                    fc++; 
                                                    file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file); %>
                                                    <?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>
														<div class="fr atachment_det atachment_<%=caseFileId%>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> <% }else{%> style="display:none;" <%} %>>
                                                        <div class="aat_file">
                                                        	<?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>
                                                            <div class="file_show_dload">
                                                                <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<?php echo __('Preview Image');?>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                            </div>
                                                        <?php } ?>
                                                            <?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
                                                            <div class="attach-close">
                                                                <% if(user_can_change == 1){ %>
                                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+csAtId+'\'' %>,<%='\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
                                                                <% } %>
                                                            </div>
                                                        <?php } ?>
                                                            <% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                                                                <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
																		<img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;" title="<%= d_name %>" alt="Loading image.." />
                                                                <% }else{ %>
																		<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=90&sizey=60&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                                                                <% } %>
                                                            <% } else { %>
                                                                <div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
                                                            <% } %>
                                                            <div class="file_cnt ellipsis-view" title="<%= d_name %>" rel="tooltip"><%= d_name %></div>
                                                            <div class="file_cnt_info">
                                                                <span class="file-date fl"><%= frmtCrtdDt %></span>
                                                                <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                                <div class="cb"></div>
                                                            </div>
                                                        </div>
                                                    </div>
														<div class="fr atachment_det parent_other_holder atachment_<%=caseFileId%>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> style="display:none;" <% } %>>
                                                        <div class="aat_file">
                                                        	<?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>
                                                            <div class="file_show_dload">
                                                                <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'pdf'){ %>
                                                                <a href="javascript:void(0);" onclick="viewPdfFile(<%= getFiles.CaseFile.id %>);" alt="<%= caseFileName %>" title="<?php echo __('Preview Image');?>"><i class="material-icons">&#xE8FF;</i></a>
                                                                <% } %>
                                                                <% if(downloadurl) { %>
                                                                <a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<?php echo __('Preview');?>" target="_blank"><i class="material-icons">&#xE8FF;</i></a>
                                                                <% } else {%>
                                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                                <% } %>
                                                            </div>
                                                        <?php } ?>
                                                            <?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
                                                            <div class="attach-close">
                                                                <% if(user_can_change == 1){ %>
                                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+csAtId+'\'' %>,<%='\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
                                                                <% } %>
                                                            </div>
                                                        <?php } ?>
                                                            <% if(downloadurl) { %>
                                                                <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                            <% }else{ %>
                                                                <% if(getFiles.CaseFile.is_ImgFileExt){ %>
																	<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                                                                <%  } else{ %>
                                                                <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                                <% } %>
                                                            <% } %>

                                                            <div class="file_cnt ellipsis-view" title="<%= d_name %>" rel="tooltip"><%= d_name %></div>
                                                            <div class="file_cnt_info">
                                                                <span class="file-date fl"><%= frmtCrtdDt %></span>
                                                                <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                                <div class="cb"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                    <% if(fc%4==0) { %><div class="cb"></div><% } %>
                                            <% } %>
                                        <% } %>
                                    <% } %>
                                    <div class="cb"></div>
                                    <div class="fr collaps" style="display:none;">
                                        <a href="javascript:void(0);" onclick="collapsDescription(0)"><span><?php echo __('Collapse Description');?></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-up"></span></a>
                                    </div>
                                    <div class="cb"></div>
				</div>
				<% } %>
                            </div>                        
                                        <% } %>
										</div>
						</div>
					 <div class="clearfix"></div>
			<% var chk_sub_parent = easycaseTitle.split('<i class="material-icons case_symb'); %>			
			<% if(chk_sub_parent.length < 3){ %>
			<div class="task-details-tlog  remove_margin_border">
				<div  id="case_subtask_task<%= csUniqId %>">
					<?php echo $this->element('case_subtasks'); ?>
				</div>
            </div>
			<% } %>
			
				<div class="col-lg-12 col-sm-12 padlft-non padrht-non" id="tour_detl_checklist<%= csUniqId %>">
					<div id="case_checklist_task_dtl<%= csUniqId %>">
						<?php echo $this->element('case_checklist'); ?>
					</div>
				</div>
				<div class="cb"></div>
            <div class="col-lg-12 col-sm-12 padlft-non padrht-non">					
						<div class="sub_tasks_tbl" id="case_link_task<%= csid %>">
							<?php echo $this->element('case_link_task');?>
						</div>
					</div>
        <div class="cb"></div>
				<% if(SES_TYPE < 3){ %>
				<?php if($this->Format->isTaskReminderOn()){ ?>
				<div class="col-lg-12 col-sm-12 padlft-non padrht-non">
					<div id="case_reminder_task_dtlpop<%= csUniqId %>">
						<?php echo $this->element('case_reminder'); ?>
					</div>
				</div>
				<?php } ?>
				<% } %>
					<div class="clearfix"></div>
                    <div class="col-lg-12 col-sm-12 padlft-non padrht-non">					
               <div class="comnt_tlog_tab_sec">
              		<ul class="ct_tabs">
              			 
              			<li class="tab-link detl_tab_switching comment_tab current" data-tab="tab-1<%= csUniqId %>" data-case_uid="<%= csUniqId %>" data-to_hid="tab-2 tab-3">
              				<?php echo __('Comments');?> 
							<% if(cntdta) { %>
              				<p class="tsk-dtl-reply-cnt"><span><i class="material-icons">&#xE0B7;</i></span><span class="tsk-dtl-reply-cnt-lbl">(<small style="display: inline;"><%= total %></small>)</span></p>
              				<% } %>
              			</li>
              		
              		<?php if($this->Format->isAllowed('Start Timer',$roleAccess) || 
					$this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
              			<li class="tab-link detl_tab_switching tlog_tab" data-tab="tab-2<%= csUniqId %>" data-case_uid="<%= csUniqId %>"  data-to_hid="tab-1 tab-3"><?php echo __('Time log');?></li>
              		<?php } ?>
					<?php if($this->Format->isAllowed('View Bug',$roleAccess) && $this->Format->isAllowedDefectModule()){ ?>
						<li class="tab-link detl_tab_switching" data-tab="tab-3<%= csUniqId %>" data-case_uid="<%= csUniqId %>" data-to_hid="tab-1 tab-2" ><?php echo __('Bugs');?> </li>
					<?php } ?>
				</ul>
                  <div id="tab-1<%= csUniqId %>" class="tab-content current"data-case_uid="<%= csUniqId %>">
                    <% if(cntdta){ %>
                        <div class="user-comment">
						<?php /* <div class="col-lg-4 col-sm-4">
                                    <h4><?php echo __('Comments');?>
									 <% if(cntdta) { %>
                                	<p class="tsk-dtl-reply-cnt"><span><i class="material-icons">&#xE0B7;</i></span><span class="tsk-dtl-reply-cnt-lbl">(<small><%= total %></small>)</span></p>
									<% } %>
									</h4>    
						</div> */ ?>
                              <% if(total > 10){ %>
                                <div class="col-lg-8 col-sm-8 text-right">
                                    <div class="fr view_rem">
                                        <a id="morereply<%= csAtId %>" style="<% if(cntdta > 10) { %>display:none<% } %>;" class="orange_btn" href="javascript:void(0);" onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'more\'' %>)">
                                            <% remaining = total-10; %>
										<?php echo __('View remaining');?> <%= remaining %> <?php echo __('thread');?><% if(remaining > 1) {%><?php echo __('s');?><% } %>
                                        </a>
                                        <span id="hidereply<%= csAtId %>" <% if(cntdta <= 10) { %> style="display:none" <% } %>>
                                            <a class="orange_btn" href="javascript:void(0);" onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'less\'' %>)">
                                                <?php echo __('View latest 10');?>
                                            </a>
                                        </span>
                                        <span class="rep_st_icn"></span>
                                        <span id="loadreply<%= csAtId %>" style="visibility: hidden;"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="<?php echo __('loading');?>..."/></span>
                                    </div>
                                    <div class="fr view_rem">
                                        <span id="repsort_desc_<%= csAtId %>" <%= ascStyle %>> 
											<a href="javascript:void(0);" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View oldest thread on top');?>"><?php echo __('Newer');?></a>
                                        </span>
                                        <span id="repsort_asc_<%= csAtId %>" <%= descStyle %> > 
											<a href="javascript:void(0);" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View newest thread on top');?>"><?php echo __('Older');?></a>
                                        </span>
                                        <span class="rep_st_icn"></span>
                                        <span id="loadreply_sort_<%= csAtId %>" style="visibility: hidden;"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="<?php echo __('loading');?>..."/></span>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                                <input type="hidden" value="less" id="threadview_type<%= csAtId %>" />
                                <input type="hidden" value="<%= thrdStOrd %>" id="thread_sortorder<%= csAtId %>" />
                                <input type="hidden" value="<%= remaining %>" id="remain_case<%= csAtId %>" />
                            <% } %>
							 <div class="cb"></div>
                            <div class="reply_cont_bg fs-hide" id="reply_content<%= csAtId %>">
                                  <div id="showhidemorereply<%= csAtId %>">
                                          <?php echo $this->element('case_reply'); ?>
                                  </div>
                            </div>
                        </div>
                    <% } %>
					</div>
                    <div class="clearfix"></div>
				<div id="tab-2<%= csUniqId %>" class="tab-content">
                    <div class="time_log_reply task-details-tlog" id="reply_time_log<%= csAtId %>">
                        <% if(logtimes.logs.length > 0){ %>
                            <?php echo $this->element('case_timelog'); ?>
                        <% }else{ %>
                        <div class="tlog_top_cnt"> 
                            <div class="time-log-header timelog-table timelog-table-head <% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>detail_timelog_header<% } %>" style="<% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>display:none;<% } %>">
                            	 <?php if($this->Format->isAllowed('Start Timer',$roleAccess)){ ?>
								 <% if(csLgndRep ==3 ) { %>
								 <% } else{ %>
				<a class="<%=logtimes.page%> anchor log-more-time fr" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Start Timer\'' %>);startTimer(<%= '\'' + logtimes.task_id + '\'' %>,<%= '\'' + escape(htmlspecialchars(logtimes.task_title,3)) + '\'' %>,<%= '\'' + logtimes.task_uniqId + '\'' %>,<%= '\'' + logtimes.project_uniqId + '\'' %>,<%= '\'' + escape(logtimes.project_name) + '\'' %>)"><i class="material-icons">&#xE425;</i><?php echo __('Start Timer');?></a>
								<% } %>
			<?php } ?>
				 <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
						<% if(csLgndRep ==3 ) { %>
							<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
				<a class="<%=logtimes.page%> anchor log-more-time fr" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
			<?php } ?>
							<% } else{ %>
								<a class="<%=logtimes.page%> anchor log-more-time fr" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
							<% } %>
							<?php } ?>
                                <div class="clearfix"></div>
                            </div>
                            </div>
                        <% } %>
                    </div>
                		</div>
						<div id="tab-3<%= csUniqId %>" class="tab-content" style="overflow-y: auto;">
							<div class="task-details-tlog" id="tour_detl_defect<%= csUniqId %>">
								<div id="case_bug_task_dtl<%= csAtId %>">
									<?php echo $this->element('case_defect_list'); ?>
								</div>
							</div>
						</div>
						    </div>
				    	</div>
                    <div class="clearfix"></div>
					       <div id="tour_detl_logs<%= csUniqId %>" class="col-lg-12 col-sm-12 padlft-non padrht-non">
                    <input type="hidden" name="data[Easycase][sel_myproj]" id="CS_project_id<%= csAtId %>" value="<%= projUniqId %>" readonly="true">
                    <input type="hidden" name="data[Easycase][myproj_name]" id="CS_project_name<%= csAtId %>" value="<%= htmlspecialchars(projName) %>" readonly="true">
                    <input type="hidden" name="data[Easycase][case_no]" id="CS_case_no<%= csAtId %>" value="<%= csNoRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][type_id]" id="CS_type_id<%= csAtId %>" value="<%= csTypRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][title]" id="CS_title<%= csAtId %>" value="" readonly="true"/>
                    <input type="hidden" name="data[Easycase][priority]" id="CS_priority<%= csAtId %>" value="<%= csPriRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][org_case_id]" id="CS_case_id<%= csAtId %>" value="<%= csAtId %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][istype]" id="CS_istype<%= csAtId %>" value="2" readonly="true"/>
                    <div class="cb"></div>

                    <% if(is_active){ %>
                        <div class="col-lg-12 col-sm-12 padlft-non padrht-non reply_task_block"  id="reply_box<%= csAtId %>" <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?> style="display:block;"<?php }else{ ?> style="display:none;"<?php } ?>>
                            <div class="task-details-comment-block">
                                <div class="fl user-task-pf commenter-img profile-alpha">
                                   <% if(!usrFileExst){ var usrPhoto = 'user.png'; } %>
                                    <% var usr_name_fst = usrName.charAt(0); %>
                                    <% if(!usrFileExst){ %>
                                            <span class="cmn_profile_holder <%= usrPhotoBg %>">
                                                    <%= usr_name_fst %>
                                            </span>
                                    <% }else{ %>
                                            <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= usrPhoto %>&sizex=55&sizey=55&quality=100" class="lazy " width="55" height="55" title="<%= usrName %>"/>
                                    <% } %>
                                </div>	
                                <div class="fl task-comment">
                                    <div class="fr editor-type">
                                        <span class="active">
                                            <a title="<?php echo __('HTML Editor');?>" rel="tooltip" href="javascript:void(0);" class="fr" id="custom<%= csAtId %>"  onclick="changeToRte(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" style="display:none;"><?php echo __('HTML');?></a>
                                        </span>
                                        <span>
                                            <a title="<?php echo __('TEXT Editor');?>" rel="tooltip" href="javascript:void(0);" class="fr" id="txt<%= csAtId %>" onclick="changeToRte(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" style="display:none;"><?php echo __('Text');?></a>
                                        </span>
                                    </div>
                                    <div class="comment-form full_width_resp">
                                            <div class="col-lg-12 col-sm-12 mbtm15">
                                                <div class="row">
                                                    <div class="form-group label-floating custom-task-fld title-fld dtail-comment-label ct-title">
                                                        <label class="control-label" id="label_txa_plane<%= csAtId %>" for="txa_plane<%= csAtId %>"><?php echo __('Comment');?></label>

                                                            <span id="html<%= csAtId %>" style="display:block;">
                                                                <span id="hidhtml<%= csAtId %>">
                                                                    <textarea name="data[Easycase][message]" id="<%= 'txa_comments'+csAtId %>" rows="2" class="form-control <?php if(SES_COMP == 23823 || SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>"></textarea>
                                                                    <span id="htmlloader<%= csAtId %>" style="color:#999999; display: none; float:left;"><?php echo __('Loading');?>...</span>
                                                                </span>
                                                                <span id="showhtml<%= csAtId %>" data-task="<%= csAtId %>" style="display:none;">
                                                                        <textarea name="data[Easycase][message]" id="<%= 'txa_comments'+csAtId %>" rows="2" class="reply_txt_ipad form-control" style="color:#C8C8C8"></textarea>
                                                                </span>
                                                            </span>
                                                            <span id="plane<%= csAtId %>" style="display:none;">
                                                                    <textarea name="data[Easycase][message]" id="txa_plane<%= csAtId %>" rows="3" class="form-control"></textarea>
                                                            </span>
                                                            <input type="hidden" value="1" id="editortype<%= csAtId %>"/>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cb"></div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="row  m-sap">
                                                    <% if(csTypRep!=10 || 1){ %>
                                                    <div class="col-lg-4 col-sm-3 padlft-non custom-task-fld proj-fld-fld add_new_opt close_none" id="hiddrpdwnstatus<%= csAtId %>" <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> style="pointer-events: none;" <?php } ?>>
                                                        <% var val = ""; %>
                                                            <select class="select_sts form-control floating-label" placeholder="<?php echo __('Status');?>"  onchange="valforlegend(this.value,'legend<%= csAtId %>')" >
									<% if(!parseInt(custom_status_id)){ %>
                                                            <% if(csLgndRep == 1) { val = 1; %>
                                                                    <option value="1" selected><?php echo __('New');?></option>
                                                                    <option value="2" ><?php echo __('In Progress');?></option>
                                                                    <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
                                                                    <option value="3"><?php echo __('Close');?></option>
                                                                    <?php } ?>
                                                                    <option value="5"><?php echo __('Resolve');?></option>
                                                            <% } else if(csLgndRep == 2 || csLgndRep == 4){ val = 2; %>
                                                                    <option value="1"><?php echo __('New');?></option>
                                                                    <option value="2" selected=selected ><?php echo __('In Progress');?></option>
                                                                    <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
                                                                    <option value="3"><?php echo __('Close');?></option>
                                                                    <?php } ?>
                                                                    <option value="5"><?php echo __('Resolve');?></option>
                                                            <% } else if(csLgndRep == 5){ val = 5; %>
                                                                    <option value="1"><?php echo __('New');?></option>
                                                                    <option value="2"><?php echo __('In Progress');?></option>
                                                                    <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
                                                                    <option value="3"><?php echo __('Close');?></option>
                                                                    <?php } ?>
                                                                    <option value="5" selected=selected><?php echo __('Resolve');?></option>
                                                            <% } else if(csLgndRep=="3"){ val = 3; %>
                                                                    <option value="1"><?php echo __('New');?></option>
                                                                    <option value="2"><?php echo __('In Progress');?></option>
                                                                    <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
                                                                    <option value="3" selected=selected><?php echo __('Close');?></option>
                                                                    <?php } ?>
                                                                    <option value="5"><?php echo __('Resolve');?></option>
                                                            <% } %>
									<% }else{ %>
										<% $.each(cust_sts_list, function(k_y, v_l) { %>
										<% if(v_l.CustomStatus.status_master_id == 3){ %>
											<% if(isAllowed("Status change except Close",projectUniqid)){ %>
										<option value="<%= v_l.CustomStatus.id %>" <% if(custom_status_id == v_l.CustomStatus.id){ %>selected=selected <% } %>>
										<% if(custom_status_id == v_l.CustomStatus.id){ val=custom_status_id; } %>
											<%= v_l.CustomStatus.name %>
										</option>
										<% } %>
										<% }else{ %>
										<option value="<%= v_l.CustomStatus.id %>" <% if(custom_status_id == v_l.CustomStatus.id){ %>selected=selected <% } %>>
										<% if(custom_status_id == v_l.CustomStatus.id){ val=custom_status_id; } %>
											<%= v_l.CustomStatus.name %>
										</option>
										<% } %>
									<% }); %>
									<% } %>
                                                            </select>
                                                            <input type="hidden" name="legend" id="legend<%= csAtId %>" value="<%= val %>">
                                                    </div>
                                                    <% } %>
                                                    <!--<div class="col-lg-2"></div>-->
                                                    <div class="col-lg-4  col-sm-3 padrht-non assin_to_fld custom-task-fld task-type-fld add_new_opt close_none" <?php if(!$this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> style="pointer-events: none;" <?php } ?>>
                                                        <select name="data[Easycase][assign_to]" id="CS_assign_to<%= csAtId %>" class="select-assign-replay form-control floating-label" placeholder="<?php echo __('Assign to');?>" onchange="select_reply_user(<%= '\''+csAtId+'\'' %>,this);">
                                                            <% if(countJS(allMems)) {
                                                                for(var casekey in allMems) {
                                                                        var asgnMem = allMems[casekey];
                                                                        if(client_status == 1 && asgnMem.CompanyUser.is_client == 1){}else{
                                                                        if(SES_ID == asgnMem.User.id) {
                                                                            if(asgnMem.User.id == Assign_to_user) { %>
                                                                                <option value="<%= SES_ID %>" <% if(asgnMem.User.id == asgnUid){ %>selected <% } %>><?php echo __('me');?></option>
                                                                            <% } else if(checkAsgn == "self") { %>
                                                                                <option value="self" <% if(asgnMem.User.id == asgnUid){ %>selected <% } %>><?php echo __('self');?></option>
                                                                            <% } else if(checkAsgn == "NA") { %>
                                                                                <option value="NA" <% if(asgnMem.User.id == asgnUid){ %>selected <% } %>><?php echo __('NA');?></option>
                                                                            <% } else { %>
                                                                                <option value="<%= SES_ID %>" <% if(asgnMem.User.id == asgnUid){ %>selected <% } %>><?php echo __('me');?></option>
                                                                            <% } %>
                                                                        <% }else if(asgnMem.User.id == asgnUid) { %>
                                                                                <option value="<%= asgnMem.User.id %>" selected><%= asgnMem.User.name %></option>
                                                                        <% } else { %>
                                                                                <option value="<%= asgnMem.User.id %>" <% if(checkAsgn == "other" && csUsrAsgn == asgnMem.User.id) { %><% } %>><%= asgnMem.User.name %></option>
                                                                        <% } %>
                                                                <% } %>
                                                                <% } %>
                                                                <option value="0" <% if(asgnUid == 0){ %>selected<% } %>><?php echo __('Nobody');?></option>
                                                            <% }else if(asgnUid == 0){ %>
                                                                <option value="0" selected><?php echo __('Nobody');?></option>
                                                            <% } else {%>
                                                                <option value="<%= SES_ID %>" selected><?php echo __('me');?></option> 				
                                                                <option value="0" ><?php echo __('Nobody');?></option>				
                                                            <% } %>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-6 padrht-non comment-rdo-btn m_0" <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> style="pointer-events: none;" <?php } ?>>
                                                        <div class="form-group">
                                                            <label class="control-label prio_tdet"><?php echo __('Priority');?></label>

                                                            <span class="radio radio-primary custom-rdo priority-low-clr">
                                                                <label onclick="edited_priority(<%= '\''+csAtId+'\'' %>,this);">
                                                                    <input type="radio" name="task_priority" value="2" id="priority_low" class="" <% if(csPriRep==2){ %>checked="checked" <% } %> />
                                                                    <?php echo __('Low');?>
                                                                </label>
                                                            </span>
                                                            <span class="radio radio-primary custom-rdo priority-medium-clr">
                                                                <label onclick="edited_priority(<%= '\''+csAtId+'\'' %>,this);">
                                                                    <input type="radio" name="task_priority" value="1" id="priority_mid" class=""  <% if(csPriRep==1){ %>checked="checked" <% } %>  />
                                                                   <?php echo __('Medium');?>
                                                                </label>
                                                            </span>
                                                            <span class="radio radio-primary custom-rdo priority-high-clr">
                                                                <label onclick="edited_priority(<%= '\''+csAtId+'\'' %>,this);">
                                                                    <input type="radio" name="task_priority" value="0" id="priority_high" class="" <% if(csPriRep==0){ %>checked="checked" <% } %> />
                                                                    <?php echo __('High');?>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<div class="cb"></div>
                                            <div class="col-lg-12 col-sm-12 padlft-non padrht-non" <?php if(!$this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?> style="pointer-events: none;" <?php } ?>>
                                                <div class="row timelog_block pr">
                                                    <?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
                                                    <div class="custom-overlay"></div>
                                                    <?php } ?>
                                                    <div class="col-lg-4 col-sm-4 padrht-non">
                                                        <div class="col-lg-12 col-sm-12 padlft-non padrht-non time_range_fld">
                                                            <div class="col-lg-6 col-sm-6 col-xs-6 padlft-non">
                                                                <div class="form-group m-top0">
                                                                    <label class="control-label mrg0 multilang_ellipsis" title="<?php echo __('Time Log');?>"  for="start_time<%= csAtId %>"><?php echo __('Time Log');?></label>
                                                                    <?php $start_placeholder = (SES_TIME_FORMAT == 12)?'08:00am':'13:00';?>
                                                                    <input type="text" class="form-control tl_start_time" name="data[TimeLog][start_time]" id="start_time<%= csAtId %>" placeholder="<?php echo $start_placeholder;?>" onchange="updatetime('start_time<%= csAtId %>')" />
                                                                </div>
                                                            </div>
                                                            <div class="from_to"><?php echo __('to');?></div>
                                                            <div class="col-lg-6 col-sm-6 col-xs-6 padrht-non">
                                                                <div class="form-group m-top0">
                                                                    <label class="control-label blank-label mrg0" for="end_time<%= csAtId %>">xxx</label>
                                                                    <?php $end_placeholder = (SES_TIME_FORMAT == 12)?'08:30am':'13:30';?>
                                                                    <input type="text" class="form-control tl_end_time" name="data[TimeLog][end_time]" id="end_time<%= csAtId %>" placeholder="<?php echo $end_placeholder;?>" onchange="updatetime('end_time<%= csAtId %>')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3 col-xs-3 padrht-non">
                                                        <div class="form-group m-top0">
                                                            <label class="control-label mrg0" for="inputDefault"><?php echo __('Break Time');?></label>
                                                            <input type="text" class="form-control tl_break_time check_minute_range brk_hr_mskng" maxlength="6" name="data[TimeLog][break_time]" id="break_time<%= csAtId %>" placeholder="hh:mm"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-xs-3 padrht-non">
                                                        <div class="form-group m-top0">
                                                            <label class="control-label mrg0" for="inputDefault"><?php echo __('Spent Hours');?></label>
                                                            <input type="text" readonly="readonly" class="form-control tl_hours"  maxlength="6" name="data[Easycase][hours]" id="hours<%= csAtId %>" onkeypress="return numericDecimal(event)" placeholder="hh:mm"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3 col-xs-3 padrht-non">
                                                        <div class="checkbox custom-checkbox">
                                                            <label>
                                                                <input type="checkbox" class="chk_fl"  name="data[TimeLog][is_bilable]" id="is_bilable<%= csAtId %>" />
                                                                <?php echo __('Is Billable');?>?
                                                            </label>
                                                        </div>
                                                    </div>
																										<div class="cb"></div>
                                                </div>
                                            </div>
                                            <?php if($this->Format->isAllowed('Upload File to Task',$roleAccess)){ ?>
                                            <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                                                <input type="hidden" name="totfiles" id="totfiles<%= csAtId %>" value="0" readonly="true"/>
                                                <?php $is_basic_or_free = (($user_subscription['btprofile_id'] || $user_subscription['is_free'] || $GLOBALS['FREE_SUBSCRIPTION'] == 0) || $user_subscription['is_cancel']) ? 0 : 1; ?>
                                                <form class="upload<%= csAtId %> attch_form" id="file_upload<%= csAtId %>" action="<?php echo HTTP_ROOT; ?>easycases/fileupload/?<?php echo time(); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="drag_and_drop" id="holder_detl" style="min-height:125px;">
                                                        <header>
                                                            <?php echo __('Drag and drop files to upload');?>
                                                            <div class="fr">
                                                            	<?php if(!in_array(SES_COMP,Configure::read('REMOVE_DROPBOX_GDRIVE'))){ ?>
                                                                <div class="dropbox-gdrive">
                                                                    <a href="javascript:void(0)" onclick="googleConnect(<%= csAtId %>,<?php echo $is_basic_or_free; ?>);"><span class="os_sprite g-drive"></span></a>
                                                                    <a href="javascript:void(0)" onclick="connectDropbox(<%= csAtId %>,<?php echo $is_basic_or_free; ?>);"><span class="os_sprite drop-box"></span></a>
                                                                    <span id="gloader" style="display: none;">
                                                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" style="position: absolute;bottom: 95px;margin-left: 125px;"/>
                                                                    </span>
                                                                </div>
                                                            <?php } ?>
                                                            </div>
                                                            <div class="cb"></div>
                                                        </header>
                                                        <div class="file_upload_detail drop-file">
                                                            <span class=""><?php echo __('Drop files here or');?></span>
															<label class="att_fl" for="tsk_attach<%= csAtId %>" ><?php echo __('click upload');?></label>
                                                            <div class="customfile-button">
                                                                <input class="customfile-input" name="data[Easycase][case_files]" id="tsk_attach<%= csAtId %>" type="file" multiple=""/>
                                                            </div>
                                                            <small><?php echo __('Max size');?> <%= MAX_FILE_SIZE %> <?php echo __('Mb');?></small>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div id="table1">
                                                    <table class="up_files<%= csAtId %>" id="up_files<%= csAtId %>" style="font-weight:normal;"></table>
                                                </div>
                                                <div id="drive_tr_<%= csAtId %>">
                                                    <form id="cloud_storage_form_<%= csAtId %>" name="cloud_storage_form_<%= csAtId %>"  action="javascript:void(0)" method="POST">
                                                        <div style="float: left;margin-top: 7px;" id="cloud_storage_files_<%= csAtId %>"></div>
                                                    </form>
                                                    <div style="clear: both;margin-bottom: 3px;"></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                            <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                                                <div class="detail-notify-email">
                                                    <span class="gray-txt"><?php echo __('Notify via Email');?></span>
                                                    <div class="checkbox custom-checkbox all-check-box mlf0">
                                                        <label><input type="checkbox" name="chkAllRep" id="<%= csAtId %>chkAllRep" value="all" class="" onclick="checkedAllResReply('<%= csAtId %>')" <% if(allMems.length == usrArr.length) { %> checked="checked" <% } %> /><?php echo __('All');?></label>
                                                    </div>

											<% 	var i = 0; var UserClients_dtl = '';  var client_span_cont = []; var client_span_contId = []; %>
                                                    <% if(countJS(allMems)){ %>
                                                    <div id="mem<%= csAtId %>">
                                                        <div  id="viewmemdtls<%= csAtId %>" class="">
                                                            <% for(var memkey in allMems){ %>
                                                                <% var getAllMems = allMems[memkey]; %>
														<% if(getAllMems.CompanyUser.is_client== "1"){client_span_cont.push(getAllMems.User.name); client_span_contId.push(getAllMems.User.id); } %>
                                                                <% if(getAllMems.User.is_client != 1 || (client_status != 1)){ %>
                                                                    <% var j = i%3; %>
                                                                    <div class="checkbox custom-checkbox  add-user-pro-chk">
                                                                        <label>
                                                                            <input type="hidden" name="data[Easycase][proj_users][]" id="proj_users"  value="<%= getAllMems.User.id %>" readonly="true" />                                        
							<input type="checkbox" name="data[Easycase][user_emails][]" id="<%= csAtId %>chk_<%= getAllMems.User.id %>" value="<%= getAllMems.User.id %>" style="cursor:pointer;" class="chk_fl <% if(getAllMems.CompanyUser.is_client== "1"){%>chk_client<%}%>" onClick="removeAllReply('<%= csAtId %>')" <% if($.inArray(getAllMems.User.id,usrArr)!=-1){ %> checked <% } %> />
                                                                            <%= shortLength(getAllMems.User.name,12) %>
                                                                        </label>
                                                                    </div>
                                                                    <% i = i+1; var k = i%3; %>
                                                                <% } %>
                                                                <% }%>
                                                                <% var client_emails_show = '';
                                                                if(UserClients_dtl != ''){
                                                                    $('#make_client_dtl').attr('checked',false);
                                                                    if(UserClients_dtl.length >= 19){
                                                                        client_emails_show = '('+UserClients_dtl.substr(0,16)+'...)';
                                                                    }else{
                                                                        client_emails_show = '('+UserClients_dtl+')';
                                                                    }
                                                                } %>
                                                                <input type="hidden" name="hidtotresreply" id="hidtotresreply<%= csAtId %>" value="<%= i %>" readonly="true" />
                                                            </div>
                                                        </div>
                                                        <% } %>
                                                    </div>
													
                            											<% if(client_span_cont.length >0 && $.inArray(SES_ID, client_span_contId) == -1){ %>		
                            											<div class="cb"></div>		
                            											<div class="col-lg-7 col-sm-7 col-xs-7 padlft-non notify_email blank_red-tag" style="margin-top: 10px;">
                            												<div id="clientdiv_dtl<%= csAtId %>" class="checkbox">
                            													<label>
                            														<input type="checkbox" name="chk_all" id="make_client_dtl<%= csAtId %>" value="0" onclick="chk_client_reply(<%= csAtId %>);" />
                            														<?php echo __('Do not show this comment to the client');?> &nbsp;
                            														<?php /*<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/knowledge-base/how-to-create-a-new-task/#don\'t_show_task_to_client');" title="<?php echo __("Get quick help on Don't show the task to client");?>" rel="tooltip" ><span class="help-icon"></span></a> */ ?>
                            													</label>
                            													<%
                            													if(client_span_cont){
                            													for(var csk in client_span_cont){ %>
                            													<span class="color_tag" title="">
                            														<%= client_span_cont[csk] %>
                            													</span>		
                            													<% } } %>
                            												</div>
                            											</div>
                            											<% } %>
													
                                                </div>
                                                <div class="post-canel-btn">
                                                    <div class="fr mtp-20" id="postcomments<%= csAtId %>">
                                                                                                                    <span class="fl"><a class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" href="javascript:void(0)" id="rset"><?php echo __('Cancel');?></a></span>
                                                       <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
                                                       <span class="fl"> <button class="btn btn_cmn_efect cmn_bg btn-info cmn_size" type="submit" name="data[Easycase][postdata]" onclick="return validateComments(<%= '\''+csAtId+'\',\''+csUniqId+'\',\''+csLgndRep+'\',\''+SES_TYPE+'\',\''+csProjIdRep+'\'' %>);"><i class="icon-big-tick"></i><?php echo __('Post comment');?></button></span>
                                                   <?php } ?>
                                                                                                                                                                                                                                     <div class="cb"></div>
                                                    </div>
                                                                                                                                                                                                                            <div class="cb"></div>
                                                    <span id="loadcomments<%= csAtId %>" style="display:none;">
                                                        <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." style="padding:5px;"/>
                                                    </span>
                                                    <input type="hidden" value="<%= total %>" id="hidtotrp<%= csAtId %>" />
                                                </div>
                                        </div>
                                    </div>
                                <div class="cb"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 col-sm-12 m-top-20" style="display:none;">
                            <div class="fl lbl-font16 lbl_cs_det_125">&nbsp;</div>
                            <div class="fr mor_toggle tasktoogle" style="float:left;" id="mor_toggle<%= csAtId %>" data-csatid="<%= csAtId %>">
                                <a href="javascript:jsVoid();" style="text-decoration:none">
                                    <img src="<?php echo HTTP_IMAGES; ?>priority.png" title="<?php echo __('Priority');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <img src="<?php echo HTTP_IMAGES; ?>hours.png" title="<?php echo __('Hours Spent and % Completed');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <img src="<?php echo HTTP_IMAGES; ?>attachment.png" title="<?php echo __('Attachments, Google Drive, Dropbox');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <?php echo __('More Options');?>
                                    <b class="caret"></b>
                                </a>
                            </div>
                            <div class="fr less_toggle tasktoogle" id="less_toggle<%= csAtId %>" data-csatid="<%= csAtId %>" style="display:none;float:left"><a href="javascript:jsVoid();" style="text-decoration:none"><?php echo __('Less');?><b class="caret"></b></a></div>
                        </div>
                    <% } %>
                </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            <div class="col-lg-3 col-sm-3 padlft-non padrht-non">
                <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                    <div class="task-detail-rht">
						<div class="cmn_sec_head">
							<div class="sec_ttl"><h5><span class="cmn_tskd_sp user_icon"></span><?php echo __('People');?></h5></div>
							<div id="asgnUsrdiv<%= csAtId %>" class="assign_to user-task-info">
								<input type="hidden" id="hid_asgn_uid" value="<%= asgnUid %>" />
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt"><?php echo __('Assign To');?>:</span>
										<span class="fr detasgnlod" id="detasgnlod<%= csAtId %>" style="display:none">
												<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
										</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="fl user-task-pf">
											<% if(asgnPic && asgnPic!=0) { %>
													<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= asgnPic %>&sizex=55&sizey=55&quality=100" class="" title="<%= asgnTo %>" width="55" height="55" />
											<% } else { %>
												<% var usr_name_fst = asgnTo.charAt(0); %>
												<span class="cmn_profile_holder <%= asgnPicBg %>" title="<%= asgnTo %>">
													<%= usr_name_fst %>
												</span>
											<% } %>
										</div>
										<?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
										<div class="fl cmn_h_det_arrow tsk-dtails-assignto <% if(showQuickAct==1){ %> dropdown<% } %>">
											<p <% if(showQuickAct==1){ %> class="fl assgn quick_action" data-toggle="dropdown"<% } %> onclick="displayAssignToMem(<%= '\''+csAtId+'\'' %>, <%= '\''+projUniqId+'\'' %>,<%= '\''+asgnUid+'\'' %>,<%= '\''+csUniqId+'\'' %>,<%= '\'details\'' %>,<%= '\''+csNoRep+'\'' %>,<%= '\''+client_status+'\'' %> )">
												<%
													var asgnNm = '';
													if(csUsrDtlsLog == asgnUid){
														asgnNm = '<?php echo __("me");?>';
													}else{
														asgnNm = shortLength(asgnTo,10);
													}
												%>
												<span id="case_dtls_new<%= csAtId %>" class="ttc"><%= asgnNm %></span>
												<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
											</p>
											<span class="edit edit-assign" style="display:none;"><?php echo __('Edit');?> </span>
											<% if(showQuickAct==1){ %>
												<ul class="dropdown-menu quick_menu" id="detShowAsgnToMem<%= csAtId %>" style="font-size:14px;">
													<li class="text-centre">
														<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="detAssgnload<%= csAtId %>" />
													</li>
												</ul>
											<% } %>
										</div>
									<?php } ?>
										<div class="cb"></div>
									</div>
								</div>
							</div>
							<div class="involve-people">
                                                            <div class="dtbl">
								<div class="cmn_ds_cel">
                                                                    <span class="gray-txt font_12"><?php echo __('People Involved');?>:</span><!--<i class="material-icons">&#xE7FD;</i>-->
                                                                </div>
                                                                <div class="cmn_ds_cel">
                                                                    <div class="activity-info">
									<% for(i in taskUsrs) { %>
										<span class="user-task-pf">
											<% var upic = 'user.png'; %>
											<% var nm_t = formatText(taskUsrs[i].User.name); var usr_name_fst = nm_t.charAt(0); %>					
											<% if(taskUsrs[i].User.photo && taskUsrs[i].User.photo!=0) { 
													upic = taskUsrs[i].User.photo; %>
												<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= upic %>&sizex=55&sizey=55&quality=100" class="" title="<%= ucwords(formatText(taskUsrs[i].User.name+' '+taskUsrs[i].User.last_name)) %>" width="55" height="55" rel="tooltip" />
											<% }else{ %>
													<span class="cmn_profile_holder <%= taskUsrs[i].User.prflBg %>" title="<%= ucwords(formatText(taskUsrs[i].User.name+' '+taskUsrs[i].User.last_name)) %>">
															<%= usr_name_fst %>
													</span>
											<% } %>
										</span>
									<% } %>
									<div  class="cb"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="involve-people">
                                                            <div class="dtbl">
                                                                <div class="cmn_ds_cel">
                                                                    <span class="gray-txt font_12"><?php echo __('Created By');?>:</span>
                                                                </div>
                                                                <div class="cmn_ds_cel">
                                                                    <div class="activity-info">									
                                                                            <span class="user-task-pf">
                                                                                  <% if(pstFileExst) { %>
                                                                                        <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= pstPic %>&sizex=55&sizey=55&quality=100" class="lazy rep_bdr" title="<%= pstNm %>" width="55" height="55" />
                                                                                    <% } else { %>
                                                                                        <% var usr_name_fst = pstNm.charAt(0); %>
                                                                                        <span class="cmn_profile_holder <%= pstPicBg %>">
                                                                                                <%= usr_name_fst %>
                                                                                        </span>
                                                                                    <% } %>                                                                                         
                                                                                    <div class="cb"></div>
                                                                            </span>
                                                                                    <span class="gray-txt" style="font-size:13px;"><%= shortLength(crtdBy,25) %></span>
                                                                                <!--%= frmtCrtdDt %-->
                                                                        <div  class="cb"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
						</div>
						<div class="cmn_sec_head">
							<div class="sec_ttl"><h5><span class="cmn_tskd_sp date_icon"></span><?php echo __('Date');?></h5></div>
							<div class="due_date task_due_dt">
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12">
											<?php echo __('Due Date');?>
										</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="caleder-due-date <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> no-pointer <?php } ?>">
											<div class="calender-txt cmn_h_det_arrow anchor">
												<span class="fr" id="detddlod<%= csAtId %>" style="display:none">
													<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
												</span>
												<div id="case_dtls_due<%= csAtId %>" class="duedate-txt <% if(user_can_change == 1){ %>dropdown<% } %>">
													<% if(csDuDtFmt) { %>
													<div title="<%= csDuDtFmtT %>" rel="tooltip" class="fl <% if(user_can_change == 1){ %>dropdown<% } %>">
														<%= csDuDtFmt %>
														<?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>
														<ul class="dropdown-menu quick_menu">
															<li class="pop_arrow_new" style="margin-left:1%;"></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \'00/00/0000\', \'No Due Date\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('No Due Date');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyCurCrtd+'\', \'Today\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Today');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyTomorrow+'\', \'Tomorrow\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Tomorrow');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyMonday+'\', \'Next Monday\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Next Monday');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyFriday+'\', \'This Friday\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('This Friday');?></a></li>
															<li>
																<a href="javascript:void(0);">
																   <div class="cstm-dt-option-dtpik prtl">
																	<div class="cstm-dt-option" data-csatid="<%= csAtId %>" style="position:absolute; left:0px; top:0px; z-index:99999999;">
																	<input data-csatid="<%= csAtId %>" value="" type="text" id="det_set_due_date_<%= csAtId %>" class="set_due_date set_due_date_custm hide_corsor" title="<?php echo __('Custom Date');?>" style="background:none; border:0px;"/>	
																	</div>
																	  <span class="cd-caleder glyphicon glyphicon-calendar"></span>
																	  <span class="set_due_date_custm_spn" style="position:relative;top:2px;cursor:text;"><?php echo __('Custom');?>&nbsp;<?php echo __('Date');?></span>
																   </div>
																</a>
															</li>
														</ul>
													<?php } ?>
													</div>
													<% } else { %>
													<div class="no_due_dt <% if(user_can_change == 1){ %>dropdown<% } %>">
														<div class="fl due-txt no_due" <% if(user_can_change == 1){ %>data-toggle="dropdown" style="cursor:pointer;"<% } %>><span class="multilang_ellipsis" style="display:inline-block;width:75%;"><?php echo __('Date Not Set');?></span><i class="tsk-dtail-drop material-icons">&#xE5C5;</i></div>
														<div class="cb"></div>
														<?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>
														<ul class="dropdown-menu quick_menu">
															<li class="pop_arrow_new" style="margin-left:1%;"></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyCurCrtd+'\', \'Today\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Today');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyTomorrow+'\', \'Tomorrow\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Tomorrow');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyMonday+'\', \'Next Monday\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('Next Monday');?></a></li>
															<li><a href="javascript:void(0);" onclick="detChangeDueDate(<%= '\''+csAtId+'\', \''+mdyFriday+'\', \'This Friday\', \''+csUniqId+'\', \''+csNoRep+'\'' %>)"><?php echo __('This Friday');?></a></li>
															<li>
																<a href="javascript:void(0);">
																   <div class="cstm-dt-option-dtpik prtl">
																   <div class="cstm-dt-option" data-csatid="<%= csAtId %>" style="position:absolute; left:0px; top:0px; z-index:99999999;">
																   <input data-csatid="<%= csAtId %>" value="" type="text" id="det_set_due_date_<%= csAtId %>" class="set_due_date set_due_date_custm hide_corsor" title="<?php echo __('Custom Date');?>" style="background:none; border:0px;"/>	
																   </div>
																	   <span class="cd-caleder glyphicon glyphicon-calendar"></span>
																	   <span class="set_due_date_custm_spn" style="position:relative;top:2px;cursor:text;"><?php echo __('Custom');?>&nbsp;<?php echo __('Date');?></span>
																   </div>
																</a>
															</li>
														</ul>
													<?php } ?>
													</div>
													<% } %>
												</div>
											</div>
											<!--<i class="material-icons">&#xE916;</i>-->
										</div>
									</div>
								</div>
							</div>
							<div class="activity">
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Original Due Date');?>:</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p class="initial_due initial_duedate_val"><%= csDuDtFmtInitial %></p>
										</div>
									</div>
								</div>
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Start Date');?>:</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p><% if(srtdt){ %><span class="start-date" title="<%= srtdtT %>" rel="tooltip"><%= srtdt %></span><% }else{ %><span class="start-date" title="<?php echo __('Edit Task To Set Start Date');?>" rel="tooltip"><?php echo __('Date Not Set');?></span><% } %></p>
										</div>
									</div>
								</div>
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Last Updated');?>:</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p><%= lupdtm %> <?php echo __('by');?> <span <% if(lstUpdBy != 'me'){ %> class="ttc" <% } %> style=""><%= shortLength(lstUpdBy,3,0) %></span></p>
										</div>
									</div>
								</div>
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Last Commented');?>:</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p><%= frmtCrtdDt %> <?php echo __('by');?> <%= shortLength(lstUpdBy,3,0) %></p>
										</div>
									</div>
								</div>
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Created Date');?>:</span>
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p><%= taskCreatedDate %></p>
										</div>
									</div>
								</div>
								<% if(lstRes) { %>
									<div class="dtbl">
										<div class="cmn_ds_cel">
											<span class="gray-txt font_12"><?php echo __('Resolved Date');?>:</span>
										</div>
										<div class="cmn_ds_cel">
											<div class="activity-info">
												<p><%= lstRes %></p>
											</div>
										</div>
									</div>
								<% } %>
								<% if(lstCls) { %>
								<div class="dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><?php echo __('Closed');?>:</span> 
									</div>
									<div class="cmn_ds_cel">
										<div class="activity-info">
											<p><%= lstCls %></p>
										</div>
									</div>
								</div>
								<% } %>								
								<% if(allowAdvancedCustomField == '1'){ %>
								<% if(advancedCustomFields.length > 0 ) { %>								
								  <% for(var CustomFieldValue in advancedCustomFields) {									
											var advCustomFieldDetail = advancedCustomFields[CustomFieldValue]; %>
									<% if(advCustomFieldDetail.CustomFieldValue.value != "") { %>
								<div class="dtbl cf_dtbl">
									<div class="cmn_ds_cel">
										<span class="gray-txt font_12"><%= advCustomFieldDetail.CustomField.label %>:</span> 
									</div>									
									<% if(advancedCustomFields.length > 0 ) { %>										
									<div class="cmn_ds_cel">
										<div class="activity-info">	
											<p>
											<% if(csLgndRep != 3 && (advCustomFieldDetail.CustomField.placeholder == "taskCmplDate" || advCustomFieldDetail.CustomField.placeholder == "variation")){ %>
												--
											<% }else{ %>
												<%= advCustomFieldDetail.CustomFieldValue.value == 0 ? '--' : advCustomFieldDetail.CustomFieldValue.value %>
											<% } %>
											</p>
									</div>
								</div>
								<% } %>
								</div>
								<%  } } } %>
								<% } %>
							</div>
						</div>
						<br/>
						<% if(link_parent_title_dtl != null){ link_parent_title_dtl_t = link_parent_title_dtl.split('_||_'); %>
						<div class="cmn_sec_head task_label_prnt">
							<div class="sec_ttl rht_label_task">
								<h5>
									<?php echo __('Linked With');?>
								</h5>
							</div>
							<div class="label_in_task">							
									<span class="max_width_tsk_title_dtl ellipsis-view  case_title wrapword">
										<a class="title_listing" href="<?php echo HTTP_ROOT; ?>dashboard#/details/<%= link_parent_title_dtl_t[1] %>"><%= '#'+link_parent_title_dtl_t[2]+': '+link_parent_title_dtl_t[0] %></a>
									</span>
							</div>
						</div>
						<br/>
						<% } %>
						
						<% if(git_sync != 0){ %>
						<% if(sync_name){ %>
						<div class="cmn_sec_head git_integation_sec">
							<div class="sec_ttl"><h5 class="git_btn cursor" id="tour_detl_activt<%= csUniqId %>" data-id="<%= csProjIdRep %>" data-title="<%= real_git_issue_id %>"><span class="cmn_tskd_sp git_icon"></span><?php echo __('Github');?>
							<sup class="sup-new" style="color: #f93737;font-size: 9px;margin-left: -5px;">&nbsp;<?php echo __("New");?></sup>
							
							<span class="material-icons chevron_right_arrow selected">chevron_right</span>
							</h5> 
							</div>
	
							<div class="activity" id="git_active">
							<?php /*<p id="hide_msg">Click on Github for Show Detail</p> */?>
							<div style="display:none; text-align: center;" id="timerquickloading">
								 <img alt="Loading..." title="Loading..." src= <?php echo HTTP_ROOT."/img/images/case_loader2.gif"?>>
							 </div>
						</div>
						</div>
						<% } } %>
						<br/>
             
					 <% if(parseInt(is_zoom_set)){ %>
						<?php if($this->Format->isAllowed('View Zoom Meeting',$roleAccess)){ ?>						
						<div class="cmn_sec_head task_label">
							<div class="sec_ttl rht_label_task">
								<h5><i class="material-icons">videocam</i>
									<?php echo __('Zoom');?>
									<sup class="sup-new" style="color: #f93737;font-size: 9px;margin-left: -5px;">&nbsp;<?php echo __("New");?></sup>
								</h5>
							</div>
							<div class="label_in_task">								
								<div id="zoom_detaill_<%= csUniqId %>" class="padbtm-10"></div>
							</div>
						</div>						
						<?php } ?>
						<% } %>
						
						<div class="cmn_sec_head task_label">
							<div class="sec_ttl rht_label_task">
								<h5><i class="material-icons">label</i>
									<?php echo __('Label in this Task');?>
									<?php if($this->Format->isAllowed('Add Label',$roleAccess)){ ?>
                  <i class="material-icons plus_icon" onclick="addLabel(<%= '\''+csAtId+'\'' %>, <%= '\''+csProjIdRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+projUniqId+'\'' %>,2);" rel="tooltip" original-title="<?php echo __('Add label');?>" style="right:20px;">&#xE145;</i>
                       <?php } ?>
								</h5>
							</div>
							<div id="tour_detl_labels<%= csUniqId %>" class="label_in_task">							
								<?php echo $this->element('case_label_task');?>
							</div>
						</div>

						<div class="cmn_sec_head">
							<div class="sec_ttl"><h5><span class="cmn_tskd_sp file_icon"></span><?php echo __('File in this Task');?></h5></div>
							<div class="file_in_task">
								<% var fc = 0; %>
									<% var count = all_files.length; %>
									<div class="no-file">
										<span class="btn-file"><%= count%><% if(count >1){ %> <?php echo __('Files');?> <% }else{ %> <?php echo __('File');?> <% } %></span>
										<!--<i class="material-icons">&#xE2BC;</i>-->
									</div>
									<div class="cb"></div>
									<div class="added-task-file">
								<% if(all_files.length) { %>
										<% var imgaes = ""; var caseFileName = ""; %>
										<% for(var fkey in all_files){ %>
											<% var getFiles = all_files[fkey];
											caseFileName = getFiles.CaseFile.file;
											caseFileUName = getFiles.CaseFile.upload_name;
											downloadurl = getFiles.CaseFile.downloadurl;
											var d__fil_name = getFiles.CaseFile.display_name; %>

											<% if(!d__fil_name){d__fil_name = caseFileName;} %>
											<% if(caseFileUName == null){caseFileUName = caseFileName;} %>
											<% if(getFiles.CaseFile.is_exist) {
												fc++; %>
												<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>
												<div class="fl smal-addtask-file atachment_<%=getFiles.CaseFile.id%>">
													<div class="atachment_det">
														<div class="aat_file rht-aat_file">
													<% if(getFiles.CaseFile.is_ImgFileExt){ %>
														<% if(downloadurl){ %>
															<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>href="<%= downloadurl %>" <?php } ?>target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>">
																<% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
																	<center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= caseFileName %>" alt="Loading image.." /></center>
																<% }else{ %>
																	<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= caseFileName %>" alt="Loading image.." />
																<% } %>
																<span class="ellipsis-view"><%= caseFileName %></span>
															</a>
														<% } else { %>
															<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" <?php } ?> alt="<%= d__fil_name %>" title="<%= d__fil_name %>" rel="prettyImg[<%= csAtId %>]">
																<% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
																	<center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= d__fil_name %>" alt="Loading image.." /></center>
																<% }else{ %>
																	<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= d__fil_name %>" alt="Loading image.." />
																<% } %>
																<span class="ellipsis-view"><%= d__fil_name %></span>
															</a>
														<% } %>
													<% } else{ %>
															<% if(downloadurl) { %>
																<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?> href="<%= downloadurl %>" <?php } ?> target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>">
																	<img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
																	<span class="ellipsis-view"><%= caseFileName %></span>
																</a>
															<% } else { %>
																<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?> href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" <?php } ?> alt="<%= d__fil_name %>" title="<%= d__fil_name %>">
																	<img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
																	<span class="ellipsis-view"><%= d__fil_name %></span>
																</a>
															<% } %>
													<% } %>
														<div class="rht_file_cnt"></div>
														</div>
													</div>
												</div>
											<?php } ?>
											<% } %>
										<% } %>
										<div class="cb"></div>
								<% } %> 
								<% if(fc==0) { %><p class="fnt12px nofiletxt colr_red"><?php echo __('No Files in this Task');?></p><div class="cb"></div><% } %>
								</div>
							</div>
						</div>
						<div class="cmn_sec_head">
							<div class="sec_ttl"><h5><span class="cmn_tskd_sp activity_icon"></span><?php echo __('Activities');?></h5></div>
							<div class="activities_flowchat">
								<div class="actvity_bar <% if(sqlcaseactivity.length == 0){ %>nodot<% } %>"  >
								<?php echo $this->element('case_detail_right_activity'); ?>
								</div>                                                            
							</div>
							<div class="pr">
								<div class="taskActivityAll">
								<% if(activitycountall > 10){%>
									<a href="javascript:void(0)" onclick="displayAllAct(<%= '\''+csAtId+'\',\'more\'' %>);"><?php echo __('Display All');?></a>
								<% } %>
								</div>
                                    <div class="loaderAct"><img src="<?php echo HTTP_IMAGES;?>images/del.gif" /></div>
                                </div>
						</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
			<input type="hidden" value="<%= csUniqId %>" id="case_uiq_detail_popup">
			<input type="hidden" value="<%= projUniqId %>" id="proj_uinq_detail_popup">
        </div>
    </div>
    <div class="cb"></div>	
</div>