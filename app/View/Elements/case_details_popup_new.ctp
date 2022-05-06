<style>
	ul.dropdown-menu li .caseDetailsSpan a:hover {background: #eee;color: #2d6dc4 !important;}
	.ttype_global {position: relative;display: inline;width: 100%;padding-left: 20px;}
	.attach_detils{ display: flex;flex-wrap: wrap;align-items: flex-start;    margin: 0 -10px;}
	span.downlodfile_detail {padding: 0 10px;display: block;width: 33.33%;border: none;background: transparent;}
	.downlodfile_detail a .ellipsis-view {margin-left: 5px;max-width: 100px;}
	.downlodfile_detail a {text-decoration:none;color: #000;display: flex;padding: 5px;border: 1px solid #e6e6e6;border-radius: 4px;background-color: #e6e6e6;margin: 5px;}
	.downlodfile_detail a small {display: block;margin: 3px 0 0 15px;color: #939fa9;}

</style>

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
   var taskcrtdBy = crtdBy;
   
   if(isFavourite){
   var favMessage ="<?php echo __('Remove from the favourite task');?>";
   }else{
	var favMessage = "<?php echo __('Set favourite task');?>";
   }
   var params = parseUrlHash(urlHash);
   var descr = csMsgRep;
   %>
   <% 
   	var r = localStorage.getItem("last_url").split("/");
	   var url_count = (r.length)-1;
    %>
<input type="hidden" value="<%= Case_mislestone_id %>" id="Case_mislestone_id_<%= csUniqId %>"/>
<div id="t_<%= csUniqId %>" class="yoxview task_detail">
   <div class="p_0 task-details-wrapper taskdetail_page task_detail_container">
      <section class="header_navigate d-flex width-100-per">
		<div class="width-100-per">
			<?php /*<div class="close_modal"><button type="button" class="close" data-dismiss="modal" onclick="closePopup('dtl_popup');"><i class="material-icons">&#xE14C;</i></button></div> */?>
			  <div class="task-detail-head task_details_title fw_tskdtail_head <%= protyCls %>">
				 <div id="caseDetailsSpanNextPrev<%=csid %>" class="displayOnlyForBackLog" style="display:none;">
					<div class="padlft-non padrht-non task_action_bar_div task_detail_head">
					   <div class="d-flex align-item-center back-frwd-btn task_action_bar">
						  <div class="displayParentBackButton">
							 <a href="javascript:void(0)" class="back-btn task_detail_back1 pop_backbtn">
								<div class="backToParentBorder">
								   <span class="os_sprite back-detail" title="<?php echo __('Back to Parent');?>" rel="tooltip"></span>
								</div>
							 </a>
						  </div>
						  <?php if($this->Format->displayHelpVideo()){ ?>
						  <a href="javascript:void(0);" class="help-video-pop inpopup" video-url = "https://www.youtube.com/embed/oHHFktaw408" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
						  <?php } ?>
						  <div class="back-frwd">
							 <span class="glyphicon glyphicon-menu-left prev" title="<?php echo __('Previous');?>" rel="tooltip_previous" <% if(r[url_count] != "tasks" && r[url_count] != "backlog") {%> style="display:none;" <% } %>></span>
							 <span class="glyphicon glyphicon-menu-right next" title="<?php echo __('Next');?>" rel="tooltip_nxt" <% if(r[url_count] != "tasks" && r[url_count] != "backlog") {%> style="display:none;" <% } %>></span>
						  </div>
						  <input type="hidden" name="hiddden_case_uid" id="hidden_case_uid" value="" />
						  <input type="hidden" name="hiddden_parent_case_uid" id="hidden_parent_case_uid" value="" />
						  <div class="cb"></div>
						  <!-- <div class="d-flex"> 
						 
						  <span><p id="copy_url" data-urlvalue="<?php echo HTTP_ROOT;?>dashboard#/details/<%= csUniqId %>"><?php echo HTTP_ROOT;?>dashboard#/details/<%= csUniqId %></p></span>
						  <span style="margin-left:385px;"><button id="copy_link_button" class="btn btn_cmn_efect cmn_bg btn-info cmn_size">Copy Link</button> </span>
						  </div> -->
					   </div>
					</div>
				 </div>
				<div class="d-flex align-item-center mtop10">
				 <div class="width-70-per create_by_taskdtl">
					<div class="d-flex align-item-center">
					<div>
					<% if(related_tasks) { var i = 0;  %>
					
					<div>
					<p>
						<% for(var pkey in related_tasks.task){
                                                   var getParents = related_tasks.task[pkey];
												   %>
								<a href="javascript:void(0)" class="link-text" onclick="easycase.ajaxCaseDetails(<%= '\''+ related_tasks.data[pkey].uniq_id +'\'' %>,<%= '\'case\''%>,0,<%= '\'popup\''%>, <%= '\'action\''%>);"  ><%= getParents %> </a> <% if(i == 0 && related_tasks.parent_counts > 1) {%>/<% } %>

								<% i++ ; } %>
								</p>
								</div>
					<% } %>
						
						<p>
						
						<% if(cntdta && (cntdta>1)) { %>						
						<?php echo __('Last updated');?>
						<% } else { %>							
						<?php echo __('Created');?><% } %>
						 <?php echo __('by');?> 
						 <span class="create_person"><%= shortLength(lstUpdBy,8) %></span> 
					   <% if(lupdtm.indexOf('Today')==-1 && lupdtm.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %>
					   <none title="<%= lupdtTtl %>"><%= lupdtm %>.</none>					   
					   <% if(srtdt){ %><span class="start-date m_0" title="<%= srtdtT %>" rel="tooltip">(<?php echo __('Start');?>: <%= srtdt %>)</span><% } %>
					   <% if(csDuDtFmt){ %><span id="update_due-date">(<?php echo __('Due');?>: <%= duedate %>)</span><% } %>
					   </p>
					
					</div>
					<?php /*<div class="detail_tour">
					<button id="deatal_tour" class="btn btn_cmn_efect cmn_bg btn-info cmn_size">Take a Tour</button>
					</div>*/ ?>
					
					<div>
					   <% if(client_status == 1){ %>
						<div class="client_no_task">
						   <p><?php echo __('Clients can not see this task');?></p>
						</div>
						<% } %>
					</div>
					 <% if(children && children != ""){ %>
					   <div class="task_parent_block" id="task_parent_block_<%= csUniqId %>">
						  <div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + children + '\'' %>);" class=" task_title_icons_parents fl"></div>
						  <div class="dropdown dropup fl1 open1 showParents">
							 <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
								<li class="pop_arrow_new"></li>
								<li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
								<li>
								   <ul class="task_parent_items" id="task_parent_<%= csUniqId %>">
									  <li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif   "></li>
								   </ul>
								</li>
							 </ul>
						  </div>
					   </div>
					   <% } %>
					   <% if(depends && depends != ""){ %>
					   <div class="task_dependent_block" id="task_dependent_block_<%= csUniqId %>">
						  <div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
						  <div class="dropdown dropup fl1 open1 showDependents">
							 <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
								<li class="pop_arrow_new"></li>
								<li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>.</li>
								<li>
								   <ul class="task_dependent_items" id="task_dependent_<%= csUniqId %>">
									  <li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
								   </ul>
								</li>
							 </ul>
						  </div>
					   </div>
					   <% } %>
					</div>
				</div>
				 <div class="width-30-per ml-auto text-right task_action_status">
				 <% if(is_inactive_case == 0 ) { %>
					<div class="icon-menu-bar">
					
					<a id="deatal_tour" href="javascript:void(0)" rel="tooltip" title="<?php echo __('Take a Tour');?>">
						<i class="material-icons icon-colr">tour</i>
					 </a>
					
					<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Reload');?>" onclick="easycase.ajaxCaseDetails(<%= '\''+ csUniqId+'\'' %>,<%= '\'case\''%>,0,<%= '\'popup\''%>,<%= '\'reload\''%>);">
						<!--<i class="material-icons">&#xE5D5;</i>-->
						<span class="cmn_tskd_sp reload_icon"></span>
					 </a>
					 <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
						<% if(is_inactive_case == 0 && is_active == 1) {%>
							<% if(logtimes.csLgndRep ==3 ) { %>
								<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
									<span class="cursor link-icon">
										<a class="<%=logtimes.page%> d-inline-block link-icon"id="tog_tm_time_entry rel="tooltip" title="<?php echo __('Manual Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')">
										<i class="material-icons icon-colr">access_time</i> <!-- Time Entry --> </a>
									</span>
								<?php } ?>
							<% } else{ %>
								<span class="cursor link-icon">
									<a class="<%=logtimes.page%> d-inline-block link-icon" rel="tooltip" title="<?php echo __('Manual Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')">
									<i class="material-icons icon-colr">access_time</i> <!-- Time Entry --> </a>
								</span>
							<% } %>
							<% } %>	
						<?php } ?>
					<% if(is_active == 1) {%>
						<span id="DetailsSpanFav<%=csid %>">
								<a href="javascript:void(0);" id="t_fav" class="caseFav" onclick="setCaseFavourite(<%=csid %>,<%=csProjIdRep %>,<%= '\''+csUniqId+'\'' %>,4,<%=isFavourite%>)" rel="tooltip" original-title="<%=favMessage%>" style="color:<%=favouriteColor%>;" >
								<% if(isFavourite) { %>
								<span id="fav_span" class="cmn_tskd_sp starfill_icon"></span>
								<% }else{ %>
								<span id="fav_span" class="cmn_tskd_sp starline_icon"></span>
								<% } %>
								<!-- <?php echo __('Favorite');?> -->
								</a>
						</span>	 
						<% } %>
						<% if(is_active == 1) {%>
							 <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
							 <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
							 


								<% if(csLgndRep != 3) {%>
							 	<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[projId] !='undefined' && customStatusByProject[projId] != null){ %>
					<% if(isAllowed('Change Status of Task',projUniqId)){ %>
                    <% if(isAllowed("Status change except Close",projUniqId)){ %>
					<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + csAtId + '\'' %>, <%= '\'' + csNoRep + '\'' %>, <%= '\'' + csUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);">
					<span class="cmn_tskd_sp closecase_icon"></span>
					</a>
					<% } %>
					<% } %>
				<% }else{ %>
					<% if(isAllowed('Change Status of Task',projUniqId)){ %>
                        <% if(isAllowed("Status change except Close",projUniqId)){ %>
							<a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Close');?>" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\'popup\''%>);">
								<!--<i class="material-icons">&#xE876;</i><?php //&#xE14C; ?>-->
								<span class="cmn_tskd_sp closecase_icon"></span>
								<!-- <?php echo __('Close');?> -->
							 </a>
						
                    <% } %>
					<% } } %>
					<% } %>


							 <?php } ?>
							 <?php } ?>
							 <% } %>
					
					 <% if(is_active && (user_can_change || isAllowed('Edit All Task'))){ %>
					 <% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task")){ %>
					 <a class="edit_my_task" id="edit_act<%= csUniqId %>" href="javascript:void(0)" rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ csUniqId+'\',\''+projUniqId+'\',\''+escape(htmlspecialchars(projName))+'\'' %>);closePopupCaseDetails();">
						<!--<i class="material-icons">&#xE254;</i>-->
						<span class="cmn_tskd_sp edit_icon"></span>
					 </a>
					 <% } %>
					 <% } %>
					 <% if(is_active && (SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == csUsrDtls) || isAllowed('Archive All Task'))) { %>
					 <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
					 <a href="javascript:void(0)" id="arcv" data-uniq_id="<%= csUniqId %>" rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csProjIdRep+'\'' %>, <%= '\'t_'+csUniqId+'\'' %>,<%= '\'popdtl\'' %>);">
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
					 <% if(is_active){ %>
					 
					  <% if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == csUsrDtls) || isAllowed('Delete All Task')) { %>
						 <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
						 <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csProjIdRep+'\'' %>, <%= '\'t_'+csUniqId+'\'' %>, <%= '\'' + isRecurring + '\'' %>,<%= '\'dtl\'' %>,<%= '\'popdtl\'' %>);">
							<!--<i class="material-icons">&#xE872;</i>-->
							<span class="delete_icon material-icons">delete_outline</span>
						 </a>
						 <?php } ?>
					<% } %> 
					<% } %> 
					<% if(is_active){ %>
					 <div class="more_action dropdown">
						<span class="cmn_tskd_sp more_icon m_0" id="more-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>
					  <ul class="dropdown-menu" aria-labelledby="more-action">
						<li>	
							 <% if(!parseInt(custom_status_id)){ %>
							 <% if(is_active && ((is_active && csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4))) { %>
							 <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
							 <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Resolve');?>" onclick="caseResolve(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\'popup\''%>);">
								<!--<i class="material-icons">&#xE153;</i>-->
								<span class="cmn_tskd_sp resolve_icon"></span>
								<?php echo __('Resolve');?>
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
								<?php echo __('Close');?>
							 </a>
							 <% } %>
							 <?php } ?>
							 <?php } ?>
							 
							 <% } %>
							 <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Copy Task Link');?>" id="cpy_lnk" data-cpylnk="<?php echo HTTP_ROOT;?>dashboard#/details/<%= csUniqId %>" >
								<i class="material-icons">content_copy</i>
								<!-- <span class="cmn_tskd_sp case_icon"></span> -->
								<?php echo __('Copy Task Link');?>
							 </a>
							 <?php if($this->Format->isAllowed('Download Task',$roleAccess)){ ?>
							 <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Download');?>" onclick="downloadTask(<%= '\''+ csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>);">
								<!--<i class="material-icons">&#xE2C4;</i>-->
								<span class="cmn_tskd_sp download_icon"></span>
								<?php echo __('Download');?>
							 </a>
							 <?php } ?>
							 <?php /* if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
							 <a href="javascript:scrollDtlPageTop($('#reply_box<%= csAtId %>'));" rel="tooltip" title="<?php echo __('Comment');?>" class="link_repto_task_dtlt" data-csatid="<%= csAtId %>">
							 <span class="cmn_tskd_sp comment_icon"></span>
							 <?php echo __('Comment');?>
							 </a>
							 <?php } */ ?>
							 <div class="caseDetailsSpan" id="caseDetailsSpanFav<%=csid %>">
							 <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=csid %>,<%=csProjIdRep %>,<%= '\''+csUniqId+'\'' %>,4,<%=isFavourite%>)" rel="tooltip" original-title="<%=favMessage%>" style="color:#888888;" >
							 <% if(isFavourite) { %>
							 <span id="fav_icon" class="cmn_tskd_sp starfill_icon"></span>
							 <% }else{ %>
							 <span id="fav_icon" class="cmn_tskd_sp starline_icon"></span>
							 <% } %>
							 <?php echo __('Favorite');?>
							 </a>
							 </div>
							 
							 <?php /* ?>
							 <% if(csLgndRep == 1 && csTypRep!= 10) { %>
							 <a href="javascript:void(0);" onclick="startCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>);">
								<div class="btn gry_btn smal30" rel="tooltip" title="In Progress">
								   <i class="act_icon act_start_task fl"></i>
								</div>
							 </a>
							 <% } %><?php */ ?>
							</li>
					  </ul>
					</div>
					<% } %> 
					
					</div>
					<% } %>
				 </div>
				 <?php /*<div class="dtl_toggle_arrow_txt">
					<span class="collapse_txt" id="open_detail_id"> <% if(cntdta) { %>Show Detail<% } else{ %>Hide Detail<% } %></span>
					<span class="tglarow_icon"><i class="material-icons">&#xE313;</i></span>
					</div>*/ ?>
				</div>
			  </div>
		</div>
      </section>
      <section class="scroll_details d-flex">
         <aside class="left_detail">
			<!-- Quick task action start here -->
			<div class="row mtop10">
				<div class="col-md-12">
					 <h5 class="task_title_heading" id="tour_task_detail_sec">
                        <% var easycaseTitle = showSubtaskTitle(caseTitle,csAtId,related_tasks,9,2,'detail'); %>
                        <div id="case_ttl_edit_main_<%= csUniqId %>" class="wrapword fs-hide" onmouseover="displayEdit(<%= '\''+csUniqId+'\'' %>,1);" onmouseout="displayEdit(<%= '\'' +csUniqId+ '\'' %>,0);">
						<% if(is_inactive_case == 0 && is_active == 1) { %><div <% if((user_can_change == 1 ||isAllowed("Edit All Task")) && params[0] !="timesheet_weekly" ){ %><% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task")){ %>class="task_title_hover" style="float:left;cursor:pointer;" id="case_ttl_edit_spn_<%= csUniqId %>" title="<?php echo __('Edit Task Title');?>" rel="tooltip" onclick="showEditTitle(<%= '\'' +csUniqId+ '\'' %>);" <% } %><% }else{ %>style="float:left;"<% } %>>#<%= csNoRep %>: <%= formatText(ucfirst(caseTitle)) %></div><% } else {%> <div><%= formatText(ucfirst(caseTitle)) %></div><% }%>
                           <div class="cb"></div>
                        </div>
						<% if(is_inactive_case == 0 && is_active == 1) { %>
                        <% if( (isAllowed("Edit Task") && showQuickActiononListEdit) || isAllowed("Edit All Task") || 1){ %>
                        <div class="case_ttl_edit_dv width-100-per m_0 p_0 custom-task-fld title-fld top-tsk-ttl" style="display:none;" id="case_ttl_edit_dv<%= csUniqId %>">
						<div class="d-flex align-item-center">
						<div class="width-70-per">
                           <input class="width-100-per m_0 custom_input_control form-control <?php if(SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>" maxlength="240"  placeholder="<?php echo __('Enter task title');?>..." type="text" data-caseno="<%= csNoRep %>" id="case_ttl_edit_<%= csUniqId %>" onkeyup="saveEditTitle(<%= '\'' +csUniqId+ '\'' %>,event);"/>
                           <textarea class="custom_input_control" style="display:none;" id="temp_title_holder_<%= csUniqId %>"><%= formatText(ucfirst(caseDataTitle)) %></textarea>
						</div>
						<div class="width-30-per text-right ml-auto">
						  <span class="save_exit_btn mright10"><button id="btn_blue_save_<%= csUniqId %>" class="btn cmn_size btn_cmn_efect cmn_bg btn-info" type="button" onclick="saveEditTitle(<%= '\'' +csUniqId+ '\'' %>,0);"><?php echo __('Save');?></button></span>
						  <span class="save_exit_btn"><button id=" btn_blue_cancel_<%= csUniqId %>" class="btn btn_cancel" type="button" onclick="cancelEditTitle(<%= '\'' +csUniqId+ '\'' %>);"><?php echo __('Cancel');?></button></span>
						  <img id="title_edit_loader_<%= csUniqId %>" src="<?php echo HTTP_IMAGES;?>images/del.gif" style="display:none;"/>
					   </div>
						</div>
                        </div>
                        <% } }%>
                        <div class="cb"></div>
                     </h5>
					<div class="quick_option_detail hover_option_detail mtop15 mbtm15">
                        <div class="task_detail_option_head task-detail-head-extr <% if(taskTyp.name == 'Story'){%>tsk-detail-story<%}%>">
                           <div class="d-flex">
                                <div class="d-flex-column width-25-per">
                                    <div class="detail_fld_label">
                                       <?php echo __('Project');?>
                                    </div>
                                    <div class="detail_fld_data">
                                       <p class="ttc"><%= shortLength(projName,22) %></p>
                                    </div>
                                 </div>
							<div class="d-flex width-75-per">
                                 <div class="d-flex-column width-25-per pl-15">
                                    <div class="detail_fld_label pl-8">
                                       <% if(project_mothodology == 2){ %>
                                       <?php echo __('Sprint');?>
                                       <%}else{%>
                                       <?php echo __('Task Group');?>
                                       <%}%>
                                    </div>
									<span id="tgrplod<%= csAtId %>" style="display:none">
                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                                    </span>
                                    <div class="detail_fld_data"  id="tgrpdiv<%= csAtId %>">
                                       <% if(is_active && user_can_change){%>
                                       <div class="dropdown cmn_h_det_arrow">
                                          <div class="opt1" id="opt80">
                                             <% var more_opt = 'more_opt80'; 
											 if(mistn != ""){
												var drp_action_title = mistn;
											 }else if((csLgndRep == 3 || csLgndRep ==5) && project_mothodology == 2){
												var drp_action_title = "None"
											 }else if(project_mothodology == 2){
												if(csLgndRep == 3 || csLgndRep ==5){
													var drp_action_title = 'None';
												}else{
													var drp_action_title = 'Backlog';
												}
											 }else{
												var drp_action_title = 'Default Task Group';
											 }
											 %>
                                             <p class="quick_action status_tdet">
											 <a  rel="tooltip" id="tsk_grp_opt80" title="<%= drp_action_title %>" class="drop_action_data" <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?> <% if(is_inactive_case == 0 && is_active == 1) { %> href="javascript:void(0);"  onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)"<% } %> <?php } ?>>
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
                                                <%}else{ %>
                                                <?php echo __('Default Task Group');?>
                                                <% } %>
                                                <% } %>
                                                <i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
                                                </a>
                                             </p>
                                          </div>
                                          <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
                                          <div class="more_opt new_opt_more" id="more_opt80<%= csAtId %>">
                                             <ul class="dropdown-menu">
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
                                                   </a>
                                                </li>
                                             </ul>
                                          </div>
                                          <?php } ?>
                                       </div>
                                       <% }else { %>
                                       <p class="ttc d-inline-block">
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
                                       </p>
                                       <% } %>
                                    </div>
                                 </div>
                                 
                                 <div class="d-flex-column width-25-per pl-15">
                                    <div class="detail_fld_label pl-8">
                                       <span class="multilang_ellipsis"><?php echo __('ASSIGN TO');?></span>
                                    </div>
                                    <div class="detail_fld_data">
											<div class="d-flex align-item-center">	
									<div class="">
									<%
													var asgnNm = '';
													if(csUsrDtlsLog == asgnUid){
														asgnNm = '<?php echo __("me");?>';
													}else{
														asgnNm = shortLength(asgnTo,10);
													}
													%>
										<?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
										<div class="cmn_h_det_arrow tsk-dtails-assignto <% if(showQuickAct == 1){ %> dropdown<% } %>">
										<% if(is_inactive_case == 0 && is_active == 1) {%>
											<div class="detasgnlod" id="detasgnlod<%= csAtId %>" style="display:none">
											<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
											</div>
										<% } %>		
										<p  <% if(showQuickAct==1){ %> class="assgn quick_action" data-toggle="dropdown"<% } %> <% if(is_inactive_case == 0 && is_active == 1) { %> onclick="displayAssignToMem(<%= '\''+csAtId+'\'' %>, <%= '\''+projUniqId+'\'' %>,<%= '\''+asgnUid+'\'' %>,<%= '\''+csUniqId+'\'' %>,<%= '\'details\'' %>,<%= '\''+csNoRep+'\'' %>,<%= '\''+client_status+'\'' %> )" <% } %>>
												
												<span id="case_dtls_new<%= csAtId %>" class="drop_action_data ttc"><%= asgnNm %></span>
												<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
											</p>
											<span class="edit edit-assign" style="display:none;"><?php echo __('Edit');?> </span>
											<% if(showQuickAct==1){ %>
												<% if(is_inactive_case == 0 && is_active == 1) {%>
											<ul class="dropdown-menu quick_menu" id="detShowAsgnToMem<%= csAtId %>">
												<li class="text-centre">
													<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="detAssgnload<%= csAtId %>" />
												</li>
											</ul>
											<% } %>
											<% } %>
										</div>
										<?php }else { ?>
											<span rel="tooltip" title="<%= asgnNm %>" id="case_dtls_new<%= csAtId %>" class="drop_action_data ttc"><%= asgnNm %></span>
										<?php }?>
										
										</div>
										</div>
										</div>
								  </div>

								  <div class="d-flex-column width-25-per pl-15">
                                    <div class="detail_fld_label pl-8">
                                       <span class="multilang_ellipsis"><?php echo __('DUE DATE');?></span>
                                    </div>
                                    <div class="detail_fld_data">
										<div class="caleder-due-date <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> no-pointer <?php } ?>">
											<div class="calender-txt cmn_h_det_arrow anchor">
												<div id="detddlod<%= csAtId %>" style="display:none">
												<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
												</div>
												<div id="case_dtls_due<%= csAtId %>" class="duedate-txts <% if(user_can_change == 1){ %>dropdown<% } %>"onclick="openDueDateDrpDwn();">
													<% if(csDuDtFmt) { %>
													<div title="<%= csDuDtFmtT %>" rel="tooltip" class="quick_action <% if(user_can_change == 1){ %>dropdown<% } %>">
													<%= csDuDtFmt %>
													<?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>
														<% if(is_inactive_case == 0 && is_active == 1) {%>
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
													<% } %>
													<?php } ?>
													</div>
													<% } else { %>
													<div class="quick_action no_due_dt dropdown ">
													<div class="due-txt no_due cursor" data-toggle="dropdown"  ><span class="multilang_ellipsis"><?php echo __('Date Not Set');?></span>
													<i class="tsk-dtail-drop material-icons"></i>
													</div>
													<?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>
														<% if(is_inactive_case == 0 && is_active == 1) {%>
													<ul class="dropdown-menu quick_menu">
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
													<% } %>
													<?php } ?>
													</div>
													<% } %>
												</div>
											</div>
											<!--<i class="material-icons">&#xE916;</i>-->
										</div>
										</div>
								  </div>
								  <div class="d-flex-column width-25-per pl-15">
                                    <div class="detail_fld_label">
                                       <?php echo __('EST.HOURS');?>
                                    </div>
                                    <div class="detail_fld_data">
                                       <div class="est_hrs_group cursor" id="estdiv<%= csAtId %>">
                                          <% if(taskTyp.id !== "10" && user_can_change == 1){ %>
                                          <p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?><% if(is_inactive_case == 0 && is_active == 1) {%> estb <% } %><?php } ?> ttc" style="">
                                             <span class="border_dashed">
                                             <% if(estimated_hours != 0.0) { %> <%= format_time_hr_min(estimated_hours) %> <% } else { %><?php echo __('None');?><% } %>
                                             </span>
                                          </p>
                                          <% var est_time = Math.floor(estimated_hours/3600)+':'+(Math.round(Math.floor(estimated_hours%3600)/60)<10?"0":"")+Math.round(Math.floor(estimated_hours%3600)/60); %>
                                          <input type="text" data-est-id="<%=csAtId%>" data-est-no="<%=csNoRep%>" data-est-uniq="<%=csUniqId%>" data-est-time="<%=est_time%>" id="est_hr<%=csAtId%>" class="est_hr form-control check_minute_range" style="display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can add time as 1.5(that mean 1 hour and 30 minutes) and press enter to save');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
                                          <% }else { %>
                                          <p class="ttc">
                                             <% if(estimated_hours != 0.0) { %><%= format_time_hr_min(estimated_hours) %><% } else { %><?php echo __('None');?><% } %>
                                          </p>
                                          <% } %>
                                       </div>
                                       <span id="estlod<%=csAtId%>" style="display:none;">
                                       <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                                       </span>
                                    </div>
                                 </div>
								
								</div>
                           </div>
                        </div>
					</div>
					 
					<div class="d-flex status_breadcrumbs hover_option_detail mbtm20">
						<div class="all_breadcrumbs d-flex width-25-per">
							<div class="status_detail width-100-per">
							   <div class="status_top dtl_page_sts<%= csAtId %>">
								  <% var typetsk_id = taskTyp.id; %>
								  <?php echo $this->element('case_details_sts_new', array('popup' => 1)); ?>
							   </div>
							</div>
						</div>
						<div class="d-flex width-75-per">
							<?php /*<div class="pl-15 pr-15">
								<div class="more_status dropdown">
									<span class="m_0" id="more-status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="material-icons">keyboard_arrow_down</i></span>
									<ul class="dropdown-menu" aria-labelledby="more-status">
										<li><a href="javascript:void(0)">sdjdgjadgjagja</a></li>
										<li><a href="javascript:void(0)">sdjdgjadgjagja</a></li>
										<li><a href="javascript:void(0)">sdjdgjadgjagja</a></li>
									</ul>
								</div>
							</div> 
							<div class="mark_as_close ml-auto">
								<div class="markclose_status" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\'popup\''%>);">
									<i class="material-icons">check</i> mark as closed
								</div>
							</div> */?>
							  <input type="hidden" id="asn_hiddden" value= "<%= asgnUid %>" />
							<div class="tsk-dtail-priorty d-flex-column width-25-per pl-15">
								<div class="detail_fld_label pl-8">
								   <?php echo __('PRIORITY');?>
								</div>
								<div class="detail_fld_data">
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
										 <% if(csLgndRep !=3 && csLgndRep !=5){ %>
										 <div class="cb"></div>
										 <% } %>
										 <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
										 <% if(showQuickAct==1){ %>
											<% if(is_inactive_case == 0 && is_active == 1) {%>
										 <ul class="dropdown-menu quick_menu">
											<li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'2\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
											<li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'1\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
											<li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+csAtId+'\', \'0\', \''+csUniqId+'\', \''+csNoRep+'\'' %>,<%= '\'popup\''%>)"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
										 </ul>
										 <% } %>
									  </span>
									  <% } %>
									  <?php } ?>
								   </div>
								   <span id="prilod<%= csAtId %>" style="display:none">
								   <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
								   </span>
								   <% } %>
								</div>
						</div>
						<div class="d-flex-column width-25-per pl-15">
						<div class="type-devlop">
								<div class="detail_fld_label pl-8">
								   <?php echo __('TYPE');?>
								</div>
								<div class="detail_fld_data">
								   <div id="typdiv<%= csAtId %>" class=" typ_actions <% if(showQuickAct==1){ %> dropdown<% } %>" data-typ-id = "<%= taskTyp.id %>">
									  <span class="dropdown cmn_h_det_arrow">
										 <p  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?><% if(showQuickAct== 1){ %> class="quick_action type_show" data-toggle="dropdown" <% } %> <?php } ?>>
											<span class="ttype_global tt_<%= getttformats(taskTyp.name)%>">
											<%= shortLength(taskTyp.name,10) %> 
											</span>
											<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
										 </p>
										 <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
										 <% if(showQuickAct==1){ %>
											<% if(is_inactive_case == 0 && is_active == 1) {%>
										 <ul class="dropdown-menu quick_menu">
											<input class="search_inp" type="text" placeholder="<?php echo __('Search');?>" onkeyup="searchTaskTypeDetail(this);"  />
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
										 <% } %>
									  </span>
									  <% } %>
									  <?php } ?>
								   </div>
								  
								   <span id="dettyplod<%= csAtId %>" style="display:none">
								   <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
								   </span>
								<div class="cb"></div>
								

							</div>
							
						</div>	
						
					</div> 

					<div class="d-flex-column width-25-per pl-15" <% if(taskTyp.name != 'Story'){%> style="display:none;"<%}%> id="strpoContain<%= csAtId %>">
							<div class="detail_fld_label">
							  <?php echo __('STORY POINT');?>
							</div>
							<div class="detail_fld_data story_point_fld">
							   <div id="strpodiv<%= csAtId %>">
								  <% if(user_can_change == 1){ %>
								  <p class="strpob ttc" style="">
									 <span class="border_dashed">
									 <% if(story_point != 0.0) { %> <%= story_point %> <% } else { %><?php echo __('None');?><% } %>
									 </span>
								  </p>
								  <input type="text" data-est-id="<%=csAtId%>" data-est-no="<%=csNoRep%>" data-est-uniq="<%=csUniqId%>" data-est-pt="<%=story_point%>" id="strpo_cnt<%=csAtId%>" class="strpo_cnt form-control check_minute_range" style="margin-bottom: 2px;display:none;" pattern="[0-9]" maxlength="5" rel="tooltip" title="<?php echo __('You can enter as 1(that mean 1 day)');?>" <% if(is_inactive_case == 0 && is_active == 1) {%> onkeypress="return numeric_only(event)"  <% } %> value="<%= story_point %>" data-default-val="<%=story_point%>"/>
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
						 </div>
				</div>
			
			</div>
						
            <div class="mt-30">
               <div class="">
                  <ul class="details_item_tab">
                     <li class="item_li upper active" id="tab-overView" data-tab="tab-overView" data-active="<%= is_inactive_case %>"  data-case_uid="<%= csUniqId %>"  onclick="show_hide_tab(this)"><a href="javascript:void(0)" class="link_item "><span class="overview_icon"></span>Overview</a></li>
					 <% var chk_sub_parent = easycaseTitle.split('<i class="material-icons case_symb'); %>
                     <li class="item_li upper" id="tab-timelog" data-tab="tab-timeLog" data-active="<%= is_inactive_case %>"  data-case_uid="<%= csUniqId %>" onclick="show_hide_tab(this)"><a href="javascript:void(0)" class="link_item"><span class="timelog_icon"></span>Time Logs</a></li>
                     <li class="item_li upper" id="tab-files" data-active="<%= is_inactive_case %>"  data-tab="tab-files" data-case_uid="<%= csUniqId %>" onclick="fetchFilesTskDtl(this);show_hide_tab(this);"><a href="javascript:void(0)" class="link_item"><span class="files_icon"></span>Files</a></li>
                  </ul>
               </div>
            </div>
			<!-- Quick task action end here -->
            <!-- Overview section start here -->
            <div id="overview_items" class="details_item_content" style="display:block">
               <div class="toggle_task_details fs-hide <% if(cntdta) { %>hide_detail<% } else{ %>show_detail<% } %>">
			   
            <!-- Descrition section start here -->
			   <div class="cmn_sec_card selected" id="desc_sec">
					<div class="sec_title tog" data-cmnt_id ="desc_sec">
						<div class="heading_title">
							<span class="sec_icon desc_icon"></span>
						   <h3 id="tour_taskdetail_description"><?php echo __('Description');?></h3>
						</div>
						<div class="icon_collapse" ></div>
					</div>
					<div class="toggle_details">
						<div class="description_details">
							
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
											<div class="attach_detils" style="margin-bottom:20px">
											<% for(var fileKey in filesArr) {
												var getFiles = filesArr[fileKey];
												caseFileName = getFiles.CaseFile.file;
												caseFileUName = getFiles.CaseFile.upload_name;
                                                caseFileId = getFiles.CaseFile.id;
												downloadurl = getFiles.CaseFile.downloadurl;
												var d_name = getFiles.CaseFile.display_name;
												if(!d_name){ d_name = caseFileName;}
                                                if(caseFileUName == null){ caseFileUName = caseFileName;}  %>
		
												<span class ="downlodfile_detail">
														<a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i style="color: #049aff"class="material-icons">&#xE2C4;</i><div class="ellipsis-view"><%= d_name %></div> <small>(<%= getFiles.CaseFile.file_size %>)</small></a>
													</span>
											
												<% } %>
											</div>
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
                                   
				</div>
				<% } %>
                            </div> 
						</div>
					</div>
				</div> 
               <!-- Descrition section end here -->
			   
			   <!-- Comment section starts here -->
			   <div class="comment_tab" id="comment_tab_id">
			   <?php echo $this->element('case_comment_new'); ?>	
			   </div>
			   <!-- Comment section Ends here -->
            </div>
		</div>
        <!-- Overview section end here -->
		
        <!-- Subtask section start here -->
            <div id="subtask_items" class="details_item_content mt-20 mb-30">
				<div class="cmn_sec_card selected" id="subtask_sec">
                  
					<% var chk_sub_parent = easycaseTitle.split('<i class="material-icons case_symb'); %>			
                  <% if(chk_sub_parent.length < 3){ %>
                  <div class="">
                     <div  id="case_subtask_task<%= csUniqId %>"></div>
                  </div>
				  <% } %>
				</div>
            </div>
		<!-- Subtask section end here -->
		
		<!-- Timelog section start here -->
            <div id="timelog_items" class="details_item_content mt-20 mb-20">
				<div class="cmn_sec_card selected" id="tmelg_sec">
					<div class="" id="reply_time_log<%= csUniqId %>">
                    <div id="reply_time_log<%= csAtId %>">
                        <?php echo $this->element('case_timelog_new'); ?>
                    </div>
				</div>
				</div>
            </div>
            <!-- Timelog section end here -->
			
			<!-- Files section start here -->
            <div id="file_items" class="details_item_content mt-20 mb-20">
				<div class="cmn_sec_card selected" id="files_sec">
					<div id="tskDtlFiles">
					</div>
				</div>
			</div>
			<!-- Files section end here -->
		
			<!-- Bugs section start here -->
				<div id="bugs_items" class="details_item_content mt-20 mb-20">
					<div class="cmn_sec_card selected" id="bug_sec">
						<div id="case_bug_task_dtlpop">
						</div>
					</div>
				</div>
			<!-- Bugs section end here -->
		
		
			<!-- Integration section start here -->
            <div id="integration_items" class="details_item_content mt-20 mb-20">
			<?php if(SES_COMP == 28528 || 1){ ?>
            <?php if($this->Format->isGithubOn(SES_COMP)){ ?>
				<div class="cmn_sec_card" id="git_sec">
					<div class="sec_title d-flex tog" data-cmnt_id ="git_sec">
						<div class="heading_title">
							<span class="sec_icon git_icon"></span>
							<h3 class="cursor" id="tour_detl_activt<%= csUniqId %>" data-id="<%= csProjIdRep %>" data-title="<%= real_git_issue_id %>">Github</h3>
						</div>
						<div class="icon_collapse" ></div>
					</div>
					<div class="toggle_details">

					<% if(git_sync == "1"){ %>
					<% if(sync_name){ %>
					<div class="git_integation_sec">
						<div class="git_new_ui"></div>
						<div class="activity" id="git_active">
							<?php /*<p id="hide_msg">Click on Github for Show Detail</p> 
							<div style="display:none; text-align: center;" id="timerquickloading">
								 <img alt="Loading..." title="Loading..." src= <?php echo HTTP_ROOT."/img/images/case_loader2.gif"?>>
							 </div> */?>
						</div>
					</div>
						<% } %>
				<% } else { %>
					<!-- <div class="ml-auto sec_action_item"> -->
					<div class="cursor link-icon sec_action_item" onclick="eventTrack();">
				  <i class="material-icons">sync</i> Sync Github
				</div>
				<!-- </div> -->
					<div class="nodetail_found">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
							 height="120">
						</figure>
						<div class="colr_red mtop15">No Github Accout Synced</div>
					</div>
				<% } %>
				</div>
				</div>
				<?php } ?>
                <?php } ?>
				<?php if(SES_COMP == 28528 || SES_COMP == 1 || SES_COMP == 59977){ ?>
				<?php if($this->Format->isZoomOn(SES_COMP)){ ?>
				<div class="cmn_sec_card mt-20" id="zoom_sec">
					<div class="sec_title d-flex tog" data-cmnt_id ="zoom_sec">
						<div class="heading_title">
							<span class="sec_icon zoom_icon"></span>
							<h3>Zoom</h3>
						</div>
						<div class="icon_collapse" ></div>
					</div>
				<div class="toggle_details">
					<% if(parseInt(is_zoom_set)){ %>
						<?php if($this->Format->isAllowed('View Zoom Meeting',$roleAccess)){ ?>						
						<div>
							<div class="label_in_task">								
								<div id="zoom_detaill_<%= csUniqId %>" class="padbtm-10"></div>
							</div>
						</div>						
						<?php } ?>
				<% } else { %>
					<div class="nodetail_found">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
							 height="120">
						</figure>
						<div class="colr_red mtop15">No Zoom Accout Synced</div>
					</div>
				<% } %>
				</div>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
			<!-- Integration section end here -->
		
		
		<!-- Other secondary tabs start here -->
		<div class="row mt-20">
			<div class="col-md-12" style="margin-top:8px;">
				<ul class="details_item_tab">
					 <li class="item_li lower active" id="tab-activity" data-active="<%= is_inactive_case %>" data-tab="tab-activity" data-case_uid="<%= csUniqId %>" onclick="fetchActivityTsk(this);show_hide_lower_tab(this)"><a href="javascript:void(0)" class="link_item"><span class="activity_icon"></span>Activity Log</a></li>					 					 
				</ul>
			</div>
		</div>
		<!-- Other secondary tabs end here -->
		
		

		<!-- Activity Log section start here -->
            <div id="activitylog_items" class="details_item_content mt-20 mb-20" style="display:block">
				<div class="cmn_sec_card selected" id="actyvty_sec">
					<div class="sec_title d-flex tog" data-cmnt_id ="actyvty_sec"> 
						<div class="heading_title"> 
							<span class="sec_icon activities_icon"></span> 
							<h3 id="tour_taskdetail_activity"><?php echo __('Activities');?></h3> 
						</div> 
						<div class="icon_collapse" ></div>
					</div>
				<div class="toggle_details mt-20">
					<div class="activity_log" id="case_activity_task_dtlpop">
					<% 
					var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
					if(typeof threadDetails != 'undefined') { 
						var getdata = threadDetails.curCaseDtls;
						var userArr = getdata.Easycase.userArr;
						var by_name = getdata[0].user_name;
						var by_photo = getdata.User.photo;
						var photo_exist = getdata.User.photo_exist;
						var photo_existBg = getdata.User.photo_existBg;
						var pf_bg = userArr.User.prflBg;
						
						var filesArr = getdata.Easycase.rply_files;
						if(getdata.Easycase.message == '' && filesArr.length == 0){
							%>

						<div class="mt-20 actv_count">
							<div class="d-flex align-item-center">
								<div class="username">
									<div class="user-task-pf">
									<% if(photo_exist && photo_exist!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100" class="" title="<%= by_name %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = by_name.charAt(0); %>
								  <span class="cmn_profile_holder <%= pf_bg %>" title="<%= by_name %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
										<!-- <img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100"
										 width="30" height="30"> -->
									</div>
									<%= formatText(by_name) %>
								</div>&nbsp;
								<div>
									<strong>
										<%= getdata.Easycase.replyCap %>
									</strong>

									<span>
										<%= getdata.Easycase.rply_dt %>
									</span>
								</div>
							</div>
						</div>
						<div class="mt-15">
							<button id="show_more_bun" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" style="display:none;" onclick="showMoreActivityTsk('<%= csUniqId %>');"> <?php echo __('Show more'); ?></button>	
							<button id="show_less_bun" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" data-uid="<%= csUniqId %>" style="display:none;"onclick="showLessActivity(this);">Show less</button>					
						</div>
						<% 
						}
					}else if(typeof sqlcaseactivity != 'undefined' && sqlcaseactivity.length > 0) { 
					%>
							<% for(var repKey in sqlcaseactivity){
						var getdata = sqlcaseactivity[repKey];
						var userArr = getdata.Easycase.userArr;
						var by_name = userArr.User.name;
						var by_photo = userArr.User.photo;
						var photo_exist = userArr.User.photo_exist;
						var photo_existBg = userArr.User.photo_existBg;
						var filesArr = getdata.Easycase.rply_files;
						var pf_bg = userArr.User.prflBg;
						if((getdata.Easycase.message == null || getdata.Easycase.message == '') && filesArr.length == 0){
						%>


			<div class="mt-15 actv_count">
				<div class="d-flex align-item-center">
					<div class="username">
						<div class="user-task-pf">
						<% if(photo_exist && photo_exist!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100" class="" title="<%= by_name %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = by_name.charAt(0); %>
								  <span class="cmn_profile_holder <%= pf_bg %>" title="<%= by_name %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
							<!-- <img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100"
							 width="30" height="30"> -->
						</div>
						<%= formatText(by_name) %>
					</div>&nbsp;
					<div>
						<strong>
							<%= getdata.Easycase.replyCap %>
						</strong>
						<span>
							<%= getdata.Easycase.rply_dt %>
						</span>
					</div>
				</div>
			</div>
			<div class="mt-15">
				<button id="show_more_bun" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" style="display:none;" onclick="showMoreActivityTsk('<%= csUniqId %>');"> <?php echo __('Show more'); ?></button>
				<button id="show_less_bun" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" data-uid="<%= csUniqId %>" style="display:none;"onclick="showLessActivity(this);">Show less</button>											
			</div>
			<% } } %>
			
				<% if(activitycountall > 10){%>
					<div class="mt-15">
						<button id="show_more_bun" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="showMoreActivityTsk('<%= csUniqId %>');"> <?php echo __('Show more'); ?></button>						
					</div>
				<% } %>
			<% }else{ %>
			
					<div id="noactivity" class="nodetail_found">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
							 height="120">
						</figure>
						<div class="colr_red mtop15"><?php echo __('No activity found');?></div>
					</div>
				<div class="cb"></div>
					<% } %>
					</div>
					
				</div>
			</div>
			
            </div>
			<?php /*<div class="detail_feature_sec">
					<div class="d-flex mtop30">
						<div class="width-100-per">
							<div class="activities_flowchat">
								 <div class="actvity_bar <% if(sqlcaseactivity.length == 0){ %>nodot<% } %>"  >
									<?php echo $this->element('case_detail_right_activity_new'); ?>
								 </div>
							</div>
							<div class="taskActivityAll">
								<% if(activitycountall > 10){%>
								<a href="javascript:void(0)" onclick="displayAllAct(<%= '\''+csAtId+'\',\'more\'' %>);"><?php echo __('Display All');?></a>
								<% } %>
							</div>
							 <div class="loaderAct" style="display:none"><img src="<?php echo HTTP_IMAGES;?>images/del.gif" /></div>
						</div>
					</div>
					</div> */?>
            <!-- Activity Log section end here -->
			
           <!-- Checklist section start here -->
            <div id="checklist_items" class="details_item_content mt-20 mb-20">
				<div class="cmn_sec_card selected" id="chklst_sec">
					<div class="" id="tour_detl_checklist<%= csUniqId %>">
					  <div id="case_checklist_task_dtl<%= csUniqId %>">
					  </div>
				   </div> 
					
				</div>
			</div>
			<!-- Checklist section end here -->
		   
		   
            <!-- Task link section start here -->
            <div id="tasklink_items" class="details_item_content mtop20">
				<div class="cmn_sec_card selected" id="tsklink_sec">
				   <div id="case_link_task<%= csid %>">
				   </div> 
				</div>
			
            </div>
            <!-- Task link section end here -->
			
			
            <!-- Reminder section start here -->
            <div id="reminder_items" class="details_item_content mtop20">		
				<div class="cmn_sec_card selected" id="rmnd_sec">
				  
				   <?php //if($this->Format->isTaskReminderOn()){ ?>
					<div id="case_reminder_task_dtlpop<%= csUniqId %>">
					</div>
				   <?php// } ?>
				   
			   </div>
            </div>
            <!-- Reminder section end here -->
         </aside>
         <aside class="right_detail">
            <div class="task-detail-rht">
			
			<!-- Timeline section start here -->
			<div class="cmn_sec_head selected" id="timelineSec">
                  <div class="sec_ttl tog" id="tour_detail_timeline" data-cmnt_id="timelineSec">
					<span class="label_icon date_icon"></span>
					<h5><?php echo __('Timeline');?></h5>
					<div class="icon_collapse"></div>
                  </div>
				<div id="itemcard1" class="toggle_card_item" style="cursor: default;">

				<div class="d-flex">
					<div class="width-50-per pr-7">
							<div class="detail_fld_label">
								 <?php echo __('Est. Hours');?>
							</div>
							<span id="est_time"> <% if(estimated_hours != 0.0) { %> <%= format_time_hr_min(estimated_hours) %> <% } else { %><?php echo __('None');?><% } %><span>
						<?php /* <div class="detail_fld_data">
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
                                       <span id="estlod<%=csAtId%>" style="display:none;">
                                       <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                                       </span>
                                    </div> */ ?>
                        </div>
                        <div class="width-50-per pl-7">
						   <div class="detail_fld_label">
								<?php echo __('Spent Hours');?>
						   </div>
                                    <div class="detail_fld_data">
                                       <p class="ttc totalSPH"><% if(hours != 0.0) { %><%= format_time_hr_min(hours) %><% } else { %><?php echo __('None');?><% } %></p>
                                    </div>
                        </div>
						
                     </div>
					 <div class="hr_separetor_line"></div>

                    <div class="d-flex">
					<div class="width-50-per pr-7">
							<div class="detail_fld_label">
								 <?php echo __('Start Date');?>
							</div>
							<div class="detail_fld_data">
							   <div class="activity-info">
								  <p><% if(srtdt){ %><span class="start-date" title="<%= srtdtT %>"> <%= srtdt %></span><% }else{ %><span class="start-date"  ><?php echo __('Date Not Set');?></span><% } %></p>
							   </div>
							</div>
                        </div>
                        <div class="width-50-per pl-7">
						   <div class="detail_fld_label">
								<?php echo __('Due Date');?>
						   </div>
						   <div class="detail_fld_data">
						   <p><% if(csDuDtFmt1){ %><span class="start-date" id="duedate_id"> <%= csDuDtFmt1 %></span><% }
						   else{ %><span class="start-date" id="duedate_id"><?php echo __('Date Not Set');?></span><% } %></p>
						   <!-- <span id="duedate_id"><%= csDuDtFmt1 %></span> -->
							  <?php /* <div class="caleder-due-date <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> no-pointer <?php } ?>">
								  <div class="calender-txt cmn_h_det_arrow anchor">
									 <div id="detddlod<%= csAtId %>" style="display:none">
									 <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
									 </div>
									 <div id="case_dtls_due<%= csAtId %>" class="duedate-txt <% if(user_can_change == 1){ %>dropdown<% } %>">
										<% if(csDuDtFmt) { %>
										<div title="<%= csDuDtFmtT %>" rel="tooltip" class="quick_action <% if(user_can_change == 1){ %>dropdown<% } %>">
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
										<div class="quick_action no_due_dt <% if(user_can_change == 1){ %>dropdown<% } %>">
										   <div class="due-txt no_due cursor" <% if(user_can_change == 1){ %>data-toggle="dropdown" <% } %>><span class="multilang_ellipsis"><?php echo __('Date Not Set');?></span></div>
										   <?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>
										   <ul class="dropdown-menu quick_menu">
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
							   </div> */ ?>
							</div>
                        </div>
						
                     </div>
					 <div class="hr_separetor_line"></div>


                    <div class="d-flex">
                        <div class="width-50-per pr-7">
							<div class="detail_fld_label">
								 <?php echo __('Last Updated');?>
						   </div>
						   <div class="detail_fld_data">
							   <div class="activity-info">
								  <p><div id="lst_uptd"><%= lupdtm %></div> <?php echo __('by');?> <span <% if(lstUpdBy != 'me'){ %> class="ttc" <% } %> style=""><%= shortLength(lstUpdBy,3,0) %></span></p>
							   </div>
							</div>
                        </div>
						<div class="width-50-per pl-7">
						   <div class="detail_fld_label">
								<?php echo __('Last Commented');?>
						   </div>
						   <div class="detail_fld_data">
							   <div class="activity-info">
								  <p><%= frmtCrtdDt %> <?php echo __('by');?> <%= shortLength(lstUpdBy,3,0) %></p>
							   </div>
                           </div>
                        </div>
                    </div>
					<div class="hr_separetor_line"></div>


                    <div class="d-flex">
                        <div class="width-50-per pr-7">
							<div class="detail_fld_label">
								 <?php echo __('Created Date');?>
						   </div>
						   <div class="detail_fld_data">
							   <div class="activity-info">
								  <p><%= taskCreatedDate %></p>
							   </div>
							</div>
                        </div>
						<% if(lstRes) { %>
							<div class="width-50-per pl-7">
								<div class="detail_fld_label">
									 <?php echo __('Resolved Date');?>
							   </div>
							   <div class="detail_fld_data">
								   <div class="activity-info">
									  <p><%= lstRes %></p>
								   </div>
							   </div>
							</div>
						<% } %>
							<% if(lstRes && lstRes) { %>
								<div class="hr_separetor_line"></div>
								<% } %>
						<div class="width-50-per pl-7">
							<div class="detail_fld_label">
								 <?php echo __('Closed');?>
						   </div>
						   <div class="detail_fld_data">
							   <div class="activity-info">
							   <% if(lstCls) { %>
								  <p><%= lstCls %></p>
								  <% }else{ %>
									<p><?php echo __('--'); ?> <p>
									<% } %>
							   </div>
							</div>
						</div>
					</div>
					
				
					<% if(allowAdvancedCustomField == '1'){ %>
						<div class="hr_separetor_line"></div>
						<div class="d-flex">
						<% if(advancedCustomFields) { var con = 1; %>
							<% for(var caseAdvCFValue in advancedCustomFields) {									
					var advCustomFieldDetail = advancedCustomFields[caseAdvCFValue]; %>
								<% if(advCustomFieldDetail.CustomFieldValue.value != "") { 
									 if(con == 1) { con = con +1;%>
							<div class="width-50-per pr-7">
								<div class="detail_fld_label">
									<?php echo __('<%= advCustomFieldDetail.CustomField.label %>:');?>
								</div>
								<div class="detail_fld_data">
										<div class="activity-info">
											<p><% if(csLgndRep != 3 && (advCustomFieldDetail.CustomField.placeholder == "taskCmplDate" || advCustomFieldDetail.CustomField.placeholder == "variation")){ %>
												--
												<% }else{ %>
													<%= advCustomFieldDetail.CustomFieldValue.value == 0 ? '--' : advCustomFieldDetail.CustomFieldValue.value %>
												<% } %>
											</p>
									</div>
								</div>
							</div>
						
							<% } else if(con == 2){ %>
							<div class="width-50-per pl-7">
								<div class="detail_fld_label">
										<?php echo __('<%= advCustomFieldDetail.CustomField.label %>:');?>
								</div>
								<div class="detail_fld_data">
									<div class="activity-info">
									<p><% if(csLgndRep != 3 && (advCustomFieldDetail.CustomField.placeholder == "taskCmplDate" || advCustomFieldDetail.CustomField.placeholder == "variation")){ %>
										--
										<% }else{ %>
											<%= advCustomFieldDetail.CustomFieldValue.value == 0 ? '--' : advCustomFieldDetail.CustomFieldValue.value %>
										<% } %>
									</p>
									</div>
								</div>
							</div>
							<% if (con == 2) {%>
								<div class="hr_separetor_line"></div>
								<% } %>
							<% con = 1; } %>
					
					
					<% } } }%>

					<% if(timeBalancRemainingValue) { %>

						<div class="width-50-per pl-7">
								<div class="detail_fld_label">
										<?php echo __('Time Balance Remaining:');?>
								</div>
								<div class="detail_fld_data">
									<div class="activity-info">
									<p class="time_balance_value <% if(timeBalancRemainingValue < '0'){ %>overdue_redd<% } %>">
											<% if(caseStatus == 2) { %>0<% } else { %><%= timeBalancRemainingValue %><% } %>
												</p>
									</div>
								</div>
							</div>
																				
							<% } %>

					</div>
						<%  }%>				
				</div>
            </div>
			<!-- Timeline section end here -->
			
			
			<!-- People section start here -->
               <div class="cmn_sec_head mtop30" id="peopleSec">
					<div class="sec_ttl tog" id="tour_detail_people" data-cmnt_id="peopleSec">  
						<span class="label_icon people_icon"></span>
						<h5>People</h5> 
						<div class="icon_collapse" ></div>
					</div>
					<div id="itemcard2" class="toggle_card_item"style="cursor: default;">
                  <div id="asgnUsrdiv<%= csAtId %>" class="assign_to user-task-info">
                     <input type="hidden" id="hid_asgn_uid" value="<%= asgnUid %>" />
                    <div class="d-flex">
                        <div class="width-100-per">
							<div class="detail_fld_label">
								<?php echo __('Assign To');?>
						   </div>

						    <div class="detail_fld_data">
							<div class="username d-flex width-100-per pt-0">
							   <div class="user-task-pf">
								  <% if(asgnPic && asgnPic!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= asgnPic %>&sizex=30&sizey=30&quality=100" class="" title="<%= asgnTo %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = asgnTo.charAt(0); %>
								  <span class="cmn_profile_holder <%= asgnPicBg %>" title="<%= asgnTo %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
							   </div>
							<div class="">
								<input type="hidden" id="asgn_to" value="<%= asgnUid %>">
                           <?php // if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
                           <div class="cmn_h_det_arrow tsk-dtails-assignto">
						   
                                 <span id="asgnto_id" class="ttc"><%= asgnNm %></span>
						
                                <?php /*  <i class="tsk-dtail-drop material-icons">&#xE5C5;</i> -->
                              </p>
                              <span class="edit edit-assign" style="display:none;"><?php echo __('Edit');?> </span>
                              <!-- <% if(showQuickAct==1){ %>
                              <ul class="dropdown-menu quick_menu" id="detShowAsgnToMems<%= csAtId %>">
                                 <li class="text-centre">
                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="detAssgnload<%= csAtId %>" />
                                 </li>
                              </ul>
                              <% } %> */?>
                           </div>
                           <?php // } ?>
							  <?php /*  <div class="detasgnlod" id="detasgnlod<%= csAtId %>" style="display:none">
							   <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
							   </div>  */ ?>
						   </div>
						   </div>
                        </div>






						  <?php /* <div class="detail_fld_data">
							<div class="d-flex align-item-center">
							   <div class="user-task-pf">
								  <% if(asgnPic && asgnPic!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= asgnPic %>&sizex=30&sizey=30&quality=100" class="" title="<%= asgnTo %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = asgnTo.charAt(0); %>
								  <span class="cmn_profile_holder <%= asgnPicBg %>" title="<%= asgnTo %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
							   </div>
							<div class="ml-auto">
								<input type="hidden" id="asgn_to" value="<%= asgnUid %>">
                           <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
                           <div class="cmn_h_det_arrow tsk-dtails-assignto <% if(showQuickAct==1){ %> dropdown<% } %>">
                              <p <% if(showQuickAct==1){ %> class="assgn quick_action" data-toggle="dropdown"<% } %> onclick="displayAssignToMem(<%= '\''+csAtId+'\'' %>, <%= '\''+projUniqId+'\'' %>,<%= '\''+asgnUid+'\'' %>,<%= '\''+csUniqId+'\'' %>,<%= '\'details\'' %>,<%= '\''+csNoRep+'\'' %>,<%= '\''+client_status+'\'' %> )">
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
                              <ul class="dropdown-menu quick_menu" id="detShowAsgnToMems<%= csAtId %>">
                                 <li class="text-centre">
                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="detAssgnload<%= csAtId %>" />
                                 </li>
                              </ul>
                              <% } %>
                           </div>
                           <?php } ?>
							   <div class="detasgnlod" id="detasgnlod<%= csAtId %>" style="display:none">
							   <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
							   </div>
						   </div>
						   </div>
                        </div> */?>
                        </div>
                    </div>
                  </div>
				  <div class="hr_separetor_line"></div>
                  <div class="involve-people">
					<div class="d-flex">
                        <div class="width-100-per">
							<div class="detail_fld_label">
								<?php echo __('People Involved');?>
						   </div>
						<div class="detail_fld_data">
						   <div class="activity-info">
							  <% for(i in taskUsrs) { %>
							  <span class="user-task-pf">
							  <% var upic = 'user.png'; %>
							  <% var nm_t = formatText(taskUsrs[i].User.name); var usr_name_fst = nm_t.charAt(0); %>					
							  <% if(taskUsrs[i].User.photo && taskUsrs[i].User.photo!=0) { 
								 upic = taskUsrs[i].User.photo; %>
							  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= upic %>&sizex=30&sizey=30&quality=100" class="" title="<%= ucwords(formatText(taskUsrs[i].User.name+' '+taskUsrs[i].User.last_name)) %>" width="30" height="30" rel="tooltip" />
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
					<div class="hr_separetor_line"></div>
					<div class="d-flex">
                        <div class="width-100-per">
							<div class="detail_fld_label">
								<?php echo __('Created By');?>
						   </div>
						<div class="detail_fld_data">
						   <div class="activity-info">
							  <span class="user-task-pf">
								 <% if(pstFileExst) { %>
								 <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= pstPic %>&sizex=30&sizey=30&quality=100" class="lazy rep_bdr" title="<%= pstNm %>" width="30" height="30" />
								 <% } else { %>
								 <% var usr_name_fst = pstNm.charAt(0); %>
								 <span class="cmn_profile_holder <%= pstPicBg %>">
								 <%= usr_name_fst %>
								 </span>
								 <% } %>                                                                                         
								 <div class="cb"></div>
							  </span>
							  <span><%= shortLength(crtdBy,25) %></span>
						
							  <div  class="cb"></div>
						   </div>
					   </div>
					   </div>
                     </div>
                  </div>
               </div>
			</div>	
			<!-- People section end here -->
			<!-- Tag section start here -->
			   <!-- Tag section end here -->
         </aside>
      </section>
      <?php /*<div class="col-lg-9 col-sm-9 padlft-non padrht-non">
         <div class="task-detail-lft">
            <div class="task-detail-container">
               <div class="clearfix"></div>
               <div class="cb"></div>
               <div class="cb"></div>
               <div class="clearfix"></div>
               
            <div class="clearfix"></div>
            
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-sm-3 padlft-non padrht-non">
      <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
      </div>
   </div> */?>
   <div class="clearfix"></div>
   <input type="hidden" value="<%= csUniqId %>" id="case_uiq_detail_popup">
   <input type="hidden" value="<%= projUniqId %>" id="proj_uinq_detail_popup">
</div>
</div>
<div class="cb"></div>
</div>
