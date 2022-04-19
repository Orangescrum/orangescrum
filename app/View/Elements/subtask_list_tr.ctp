<%
	var field_name_arr = caseDet.field_name_arr;
	var caseAutoId = caseDet.Easycase.id;
	var isFavourite = caseDet.Easycase.isFavourite;
	var favMessage ="Set favourite task";
	if(isFavourite){
			var favMessage ="Remove from the favourite task";
	}
	var favouriteColor = caseDet.Easycase.favouriteColor;   
	var caseUniqId = caseDet.Easycase.uniq_id;
	var caseNo = caseDet.Easycase.case_no;
	var caseUserId = caseDet.Easycase.user_id;
	var caseTypeId = caseDet.Easycase.type_id;
	var projId = caseDet.Easycase.project_id;
	var caseLegend = caseDet.Easycase.legend;
	var casePriority = caseDet.Easycase.priority;
	var caseFormat = caseDet.Easycase.format;
	var caseTitle = caseDet.Easycase.title;
	var caseEstHoursRAW = caseDet.Easycase.estimated_hours;
	var caseEstHours = caseDet.Easycase.estimated_hours_convert;
	var isactive = caseDet.Easycase.isactive;
	var caseAssgnUid = caseDet.Easycase.assign_to;
	var sho_assign_nm = 'me';
	if(caseAssgnUid != SES_ID){
		sho_assign_nm = caseDet.Easycase.asgnName; 
	}
	var caseParenId = caseDet.Easycase.parent_task_id;	
	var getTotRep = 0;
	if(caseDet.Easycase.reply_cnt && caseDet.Easycase.reply_cnt!=0) {		
			getTotRep = caseDet.Easycase.reply_cnt;
	}
	var getTotRepCnt = (caseDet.Easycase.case_count)?caseDet.Easycase.case_count:0;
	var mid = caseDet.Easycase.mid;
	var count = caseDet.Easycase.count;
	var projectUniqid = caseDet.Easycase.projectUniqid;
	var projUniq = caseDet.Easycase.projectUniqid;
	var projectName = caseDet.Easycase.projectName;
	var is_active = caseDet.Easycase.isactive;
	var showQuickActiononList = 0;
	var showQuickActiononListEdit = 0;
	if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
			showQuickActiononList = 1;
	}
	if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
			showQuickActiononListEdit = 1;
	}

	var groupby = getCookie('TASKGROUPBY');
	var d_mid = 0;
%>
<tr class="row_tr tr_all trans_row parent_tr " id="curRow_subtask_<%= caseAutoId %>" data-mid="<%= d_mid %>">
               <td class="check_list_task tsk_fst_td pr_low">
                  <div class="checkbox">     
                     <label>   
                     <% if(caseDet.Easycase.legend != 3 && caseDet.Easycase.type_id != 10) { %>
                        <input type="checkbox" style="cursor:pointer" id="actionChk<%= caseAutoId %>" value="<%= caseAutoId + '|' + caseDet.Easycase.case_no + '|' + caseDet.Easycase.uniq_id %>" class="fl mglt chkOneTsk">
                        <% } else if(caseDet.Easycase.type_id != 10) { %>
                        <input type="checkbox" id="actionChk<%= caseAutoId %>" checked="checked" value="<%= caseAutoId + '|' + caseDet.Easycase.case_no + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } else { %>
                        <input type="checkbox" id="actionChk<%= caseAutoId %>" checked="checked" value="<%= caseAutoId + '|' + caseDet.Easycase.case_no + '|update' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } %>  
                     </label>   
                  </div>
                  <input type="hidden" id="actionCls<%= caseAutoId %>" value="1" disabled="disabled" size="2">     
									<div class="check-drop-icon">
                     <div class="dropdown"> 
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu tsg_chng_action_menu">
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[caseDet.Easycase.project_id] !='undefined' && customStatusByProject[caseDet.Easycase.project_id] != null){
                           $.each(customStatusByProject[caseDet.Easycase.project_id], function (key, data) {
                           if(caseDet.CustomStatus.id != data.id){
                           %>
                      <% if(data.status_master_id == 3){ %>
                        <% if(isAllowed("Status change except Close",caseDet.Easycase.pjUniqid)){ %>
                           <li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                      <% }else{ %>
                           <li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                           <%   } 
                           }); 
                           } else{ %>
                          <% var caseFlag="";
                              if(caseDet.Easycase.legend != 1 && caseDet.Easycase.type_id != 10){ caseFlag=9; }
                              if(caseDet.Easycase.isactive == 1){ %>
                              <li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                              </li>
                              <% }
                              if((caseDet.Easycase.legend != 2 && caseDet.Easycase.legend != 4) && caseDet.Easycase.type_id!= 10) { caseFlag=1; }
                                                  if(caseDet.Easycase.isactive == 1) { %>
                              <li onclick="startCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>);" id="start<%= caseAutoId %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(caseDet.Easycase.legend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
                              </li>
                              <% }
                                                  if((caseDet.Easycase.legend != 5) && caseDet.Easycase.type_id!= 10) { caseFlag=2; }
                                                  if(caseDet.Easycase.isactive == 1){ %>
                              <li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                              </li>
                              <% }
                              if((caseDet.Easycase.legend != 3) && caseDet.Easycase.type_id != 10) { caseFlag=5; }
                              if(caseDet.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",caseDet.Easycase.pjUniqid)){ %>
                              <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.case_no + '\'' %>, <%= '\'' + caseDet.Easycase.uniq_id + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
					  <% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									if(caseLegend != caseDet.max_custom_status && caseTypeId != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseDet.Easycase.project_id + '\'' %>,<%= '\'' + caseDet.Easycase.uniq_id + '\'' %>,<%= '\'' + caseDet.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Create Sub task\'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } %>
                          <% } %>
						  <%	if(caseDet.Easycase.sub_sub_task == 0){  %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Convert To Sub Task\'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
                                        </li>
                                      <?php } ?>
									  
									  <% }  %>
						<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                            <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
								<% if(caseLegend == caseDet.max_custom_status){ %>
									<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
									<li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle, 3)) + '\'' %> );" class="anchor">
										<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
									</li>
									<% } %>
								<% } else{ %>
                            <li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle, 3)) + '\'' %> );" class="anchor">
                                <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                            </li>
                            <% } %>
                            <% } %>                            
                        <?php } ?>
						<% if(caseLegend == caseDet.max_custom_status) { caseFlag= 7; } else { caseFlag= 8; }
                        if(isactive == 1){ %>
                         <% if(isAllowed("Reply on Task",projectUniqid)){ %> 
                        <li id="subact_replys<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group List Pages">
                            <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="<?php echo __('Re-open');?>"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>

                            <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>">
                                <i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                        </li>
                        <% } %>
                        <% } %>
						<% if( SES_ID == caseUserId) { caseFlag=3; }
                        if(isactive == 1){ %> 
                        <% if(showQuickActiononList || isAllowed("Edit All Task",projectUniqid)){ %> 
                        <% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit) || isAllowed("Edit All Task",projectUniqid)){ %> 
                         <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) ){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                          </li> 
                          <% } %>  
                          <% } %>  
                          <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> 
                         <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                          </li> 
                          <% } %>
                         
                        <% } %>
						<% if((caseLegend != caseDet.max_custom_status) && caseTypeId!= 10) { caseFlag=2; }
                        if((SES_TYPE == 1 || SES_TYPE == 2) || (((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (caseLegend != caseDet.max_custom_status)) &&  (SES_ID == caseUserId))){ %>
                        <% if(isactive == 1){ %>
                         <% if(isAllowed("Move to Project",projectUniqid)){ %> 
                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject( <%= '\'' + count + '\'' %> , this);">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% } %>
                       <% if(isactive == 1){ %>
                         <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                        <li onclick="moveTask( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'\'' %> , <%= '\'' + projId + '\'' %> );" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                        </li>
                        <% } %>
                        <% } %>
						<% if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed("Archive All Task",projectUniqid)) { caseFlag = "archive"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
                        <li onclick="archiveCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %> );" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                        </li>
                        <% } %>
                        <% } %>	
						<%	if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed("Delete All Task",projectUniqid)) { caseFlag = "delete"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
                        <li onclick="deleteCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %> , <%= '\'' + is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                        </li>
                        <% } %>						
                        <% } %>						
                        </ul>
                     </div>
                  </div>   
               </td>
			   <td class="favo-td">
					<span id="caseProjectSpanFav<%=caseAutoId %>">
						<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,1,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="margin-top:0px;color:<%=favouriteColor%>;" >
						<% if(isFavourite) { %>
							<i class="material-icons" style="font-size:18px;">star</i>
						<% }else{ %>
							 <i class="material-icons" style="font-size:18px;">star_border</i>
						<% } %>
						</a>
					</span>
				</td>
               <td class="text-left count-plist-drop pr">
                  <%= caseDet.Easycase.case_no %>   <span class="watch showtime_<%= caseAutoId %>"></span>  
               </td>
               
               <td class="relative list-cont-td label_task_tle" id="tour_task_title_listing"> 
				<?php /*
                  <span class="ttype_global tt_<%= getttformats(caseDet.Type.name)%>"></span> 
					*/ ?>
                  <%
                   var priorClass = 'prio_low';
                    if(caseDet.Easycase.priority == 1){
                        priorClass = 'prio_medium';
                     }else if(caseDet.Easycase.priority == 0){
                     priorClass = 'prio_high';
                  }
                  %>
				  <div style="" id="pridiv<%= caseAutoId %>" class="pri_actions <% if(showQuickActiononList){ %> dropdown<% } %>"> 
					<div class="dropdown cmn_h_det_arrow">
						<div <% if(showQuickActiononList){ %> class="quick_action" <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> data-toggle="dropdown" <% } %> <% } %> style="cursor:pointer"><span class=" priority <%= priorClass %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>"></span><% if(showQuickActiononList){ %> <i class="tsk-dtail-drop material-icons">&#xE5C5;</i> <% } %></div>
                    <% var csLgndRep = caseLegend; %>
                    <% if(showQuickActiononList){ %>
                    <ul class="dropdown-menu quick_menu">
                        <li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId + '\', \'2\', \'' + caseUniqId + '\', \'' + caseNo + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
                        <li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId + '\', \'1\', \'' + caseUniqId + '\', \'' + caseNo + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
                        <li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId + '\', \'0\', \'' + caseUniqId + '\', \'' + caseNo + '\'' %> )"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
                    </ul>
                    <% } %>
					</div>					
				</div>					
                 <span id="prilod<%= caseAutoId %>" style="display:none">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>
                  <div class="ttl_listing" data-task-id="<%= caseDet.Easycase.uniq_id %>">
                  <a href="javascript:void(0);" class="titlehtml" data-task="<%= caseDet.Easycase.uniq_id %>">
                     <span class="case-title_<%= caseAutoId %> case_sub_task <% if(caseDet.Easycase.type_id!=10 && (caseDet.Easycase.legend == caseDet.max_custom_status || caseDet.Easycase.custom_status_id == caseDet.max_custom_status)) { %>closed_tsk<% } %>">
                        <span class="max_width_tsk_title ellipsis-view <% if(caseDet.Easycase.legend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseDet.Easycase.title && caseDet.Easycase.title.length>100){%>overme<% }%> " title="<%= formatText(ucfirst(caseDet.Easycase.title)) %>  ">
                           <%= formatText(ucfirst(caseDet.Easycase.title)) %>
                        </span>
                     </span>
                  </a>   
                  
                  <div class="list-td-hover-cont">
                    <?php /*<span class="created-txt"><% if(caseDet.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= caseDet.User.name %> <?php echo __('on');?> <%= moment(caseDet.Easycase.dt_created).format("LLLL") %></span>*/?>
                    <span class="created-txt"><% if(caseDet.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %>  <?php echo __('on');?> <%= moment(caseDet.Easycase.dt_created).format("lll") %></span>
                  <span class="list-devlop-txt dropdown">
                    <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                        <i class="material-icons tag_fl">&#xE54E;</i>
                        <span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && isactive == 1){ %>clsptr<% } %>" title="<%= csTdTyp %>" >
                          <span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= csTdTyp%><span class="due_dt_icn"></span>
                          </span> 
                          </span> 
                    </a>				
                    <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
						<span id="typlod<%= caseAutoId %>" class="type_loader">
                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
						</span>
                        <% if(showQuickActiononList && isactive == 1){ %>
                        <ul class="dropdown-menu listgrp-bug-dropdn">
                            <li>
                                     <input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="seachitems(this);" />
                                 </li>	
                            <%
                            for(var k in GLOBALS_TYPE) {
                             if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == caseDet.Easycase.project_id){
                            var v = GLOBALS_TYPE[k];
                            var t = v.Type.id;
                            var t1 = v.Type.short_name;
                            var t2 = v.Type.name;
                            var txs_typ = t2;
                            $.each(DEFAULT_TASK_TYPES, function(i,n) {
                            if(i == t1){
                            txs_typ = n;
                            }
                            });
                            %>
                            <li onclick="changeCaseType( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> ); changestatus( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + t + '\'' %> , <%= '\'' + t1 + '\'' %> , <%= '\'' + t2 + '\'' %> , <%= '\'' + caseUniqId + '\'' %> )">
                                <a href="javascript:void(0);">
								 <span class="ttype_global tt_<%= getttformats(t2)%>"><%= t2 %></span>
                                </a>
                            </li>
                            <% } } %>
                        </ul>					
                        <% } %>
                    </span>
                </span>
                
                </span>
				</div>
				<div class="task_dependancy_item">
					<div class="task_dependancy fr">
						<% if(caseDet.Easycase.children && caseDet.Easycase.children != ""){ %>
							<span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId %>">
								<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + caseDet.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
								<div class="dropdown dropup fl1 open1 showParents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
										<li>
											<ul class="task_parent_items" id="task_parent_<%= caseUniqId %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
						<% if(caseDet.Easycase.depends && caseDet.Easycase.depends != ""){ %>
							<span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId %>">
								<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + caseDet.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
								<div class="dropdown dropup fl1 open1 showDependents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>".</li>
										<li>
											<ul class="task_dependent_items" id="task_dependent_<%= caseUniqId %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
					</div>
					
					<div class="subcls_rcrng fr">
					<% if(caseDet.Easycase.is_recurring == 1 || caseDet.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
            <% } %>
					</div> 
					<div class="cb"></div>
					
				</div>
			</div>
               </td>
               <td class="attach-file-comment text-center">  
                  <a href="javascript:void(0);" style="display:none;" id="fileattch1">   <i class="glyphicon glyphicon-paperclip"></i>  </a>
               </td>
			   <td class="assi_tlist">
                  <div class="user-task-pf">                     
                     <% var usr_name_fst = (caseDet.Easycase.usrTgShortName != null)?caseDet.Easycase.usrTgShortName:"<?php echo __("Unassigned");?>"; %>
					<i class="material-icons">&#xE7FD;</i>			
						<% if((projUniq != 'all') && showQuickActiononList){ %>
						<span id="showUpdAssign<%= caseAutoId %>" <% if(isAllowed("Change Assigned to",projectUniqid)){ %> data-toggle="dropdown" <% } %>title="<%= usr_name_fst %>" class="clsptr" onclick="displayAssignToMem( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + projUniq + '\'' %> , <%= '\'' + caseAssgnUid + '\'' %> , <%= '\'' + caseUniqId + '\'' %> )"><%= usr_name_fst %><span class="due_dt_icn"></span></span>
						<% } else { %>
						<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= usr_name_fst %></span>
						<% } %>
                   <% if((projUniq != "all") && showQuickActiononList){ %>
					<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
					</span>
					<% } %>			
					<span class="check-drop-icon dsp-block" <% if((projUniq != 'all') && showQuickActiononList){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>)" <% } %>>
						  <span class="dropdown">
							<a class="dropdown-toggle" <% if(isAllowed('Change Assigned to',projectUniqid)){ %> data-toggle="<% if((projUniq != 'all') && showQuickActiononList){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
								<i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem<%= caseAutoId %>">
								<li class="text-centre"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="assgnload<%= caseAutoId %>" /></li>
							</ul>
						</span>
					</span>          
                 </div>  
               </td>    
               <td class="esthrs_dt_tlist text-center">
                  <p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblists <?php } ?> estblist_subtask" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> id="est_blist_sub<%= caseAutoId %>" case-id-val="<%= caseAutoId %>">    
                     <span class="border_dashed_subtask">
                        <%= format_time_hr_min(caseDet.Easycase.estimated_hours) %>
                     </span>   
                  </p> 
					<% var est_time = Math.floor(caseEstHoursRAW/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
				
				<input type="text" data-est-id="<%=caseAutoId%>" data-est-no="<%=caseNo%>" data-est-uniq="<%=caseUniqId%>" data-est-time="<%=est_time%>" id="est_hr_sub_list<%=caseAutoId%>" class="est_hr_sub_list form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can enter time as 1.5(that mean 1 hour and 30 minutes)');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
				
				<span id="estlod<%=caseAutoId%>" style="display:none;margin-left:0px;">
					<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>				  
               </td>            
               <td class="text-center"> 
                  <span id="csStsRep_sub<%= caseAutoId %>" class="">
                     <% if(caseDet.Easycase.isactive==0){ %>
                        <div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
                     <%}else {
                       if(caseDet.Easycase.custom_status_id != 0 && caseDet.CustomStatus != null ){ %>
                        <%= easycase.getCustomStatus(caseDet.CustomStatus, caseDet.Easycase.custom_status_id) %>
                     <% }else{ %>
                       <%= easycase.getStatus(caseDet.Easycase.type_id, caseDet.Easycase.legend) %>
                      <% }
                      } %>
                  </span>
               </td>
               <td class="due_dt_tlist text-center">
			          <div class="<% if(csDueDate == '' || caseLegend == 5 || caseTypeId == 10 || caseLegend == 3){ %> toggle_due_dt <% } %>">
                <% if(isactive == 1){ %>
                <% if(showQuickActiononList && caseTypeId != 10){ %>
                <% } %>
                <span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= csDuDtFmtT %>">
                    <%= csDuDtFmt %>
                </span>
                <span id="datelod<%= caseAutoId %>" class="asgn_loader">
                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                </span>
                <% } %>
                <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Update Task Duedate',projectUniqid)){ %> data-toggle="<% if(showQuickActiononList){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="pop_arrow_new"></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId + '\'' %> )"><?php echo __('No Due Date');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + caseDet.mdyCurCrtd + '\', \'Today\', \'' + caseUniqId + '\'' %> )"><?php echo __('Today');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + caseDet.mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId + '\'' %> )"><?php echo __('Tomorrow');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + caseDet.mdyMonday + '\', \'Next Monday\', \'' + caseUniqId + '\'' %> )"><?php echo __('Next Monday');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + caseDet.mdyFriday + '\', \'This Friday\', \'' + caseUniqId + '\'' %> )"><?php echo __('This Friday');?></a></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="cstm-dt-option-dtpik prtl">
                                        <div class="cstm-dt-option" data-csatid="<%= caseAutoId %>" style="position:absolute; left:0px; top:0px; z-index:99999999;">
                                            <input data-csatid="<%= caseAutoId %>" value="" type="text" id="set_due_date_<%= caseAutoId %>" class="set_due_date hide_corsor" title="<?php echo __('Custom Date');?>" style="background:none; border:0px;"/>	
                                        </div>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        <span style="position:relative;top:2px;"><?php echo __('Custom');?>&nbsp;<?php echo __('Date');?></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </span>
                </span>
            </div>
                <div class="overdueby_spns overdueby_spn_<%= caseAutoId %>"><% if(showQuickActiononList){ %><%= caseDet.Easycase.csDuDtFmtBy %><% } %></div> 
               </td> 
                 <td class="due_dt_tlist text-center">
                 <%= (caseDet.Easycase.completed_task)?caseDet.Easycase.completed_task :"0" %> %
               </td>             
            </tr>