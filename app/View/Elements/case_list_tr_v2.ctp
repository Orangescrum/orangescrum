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
    var getTotRep = 0;
	var caseParenId = caseDet.Easycase.parent_task_id;
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
    /*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
        var showQuickActiononList = 1;
    }*/
    if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
        showQuickActiononList = 1;
    }
    if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
              showQuickActiononListEdit = 1;
    }

    var groupby = getCookie('TASKGROUPBY');
%>
<tr class="row_tr tr_all trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %> data-is-parent="<%= caseDet.Easycase.is_parent %>">
	<% if(groupby=='milestone') { %>
	<td class="prtl">
    <% if(isAllowed('Move to Milestone',projectUniqid)){ %>
	<div class="fl os_sprite dot-bar"></div>
    <% } %>
	<div class="wht-bg"></div>
	</td>
    <td class="ctg_check_td pr" <% if(groupby =='' || groupby !='priority'){%>class="check_list_task tsk_fst_td pr_<%= easycase.getPriority(casePriority) %>"<% } %>>
		<div class="checkbox fl">
		  <label>
			<% if(caseLegend != 3 && caseTypeId != 10) { %>
			<input type="checkbox" style="cursor:pointer" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|' + caseUniqId %>" class="fl mglt chkOneTsk">
			<% } else if(caseTypeId != 10) { %>
			<input type="checkbox" id="actionChk<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
			<% } else { %>
			<input type="checkbox" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|update' %>"  class="fl mglt chkOneTsk">
			<% } %>
		  </label>
		  <input type="hidden" id="actionCls<%= count %>" value="<%= caseLegend %>" disabled="disabled" size="2"/>			
		</div>
		<div class="check-drop-icon fl">
			<div class="dropdown cmn_tooltip_hover"> 
				<a class="dropdown-toggle tooltip_link" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i>
				</a>
				<ul class="dropdown-menu hover_item">
            <% 
              if(typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined'){
                    if(caseDet.Easycase.isactive == 1){
							if(isAllowed('Change Status of Task',projectUniqid)){
                                if(caseDet.Easycase.CustomStatus.status_master_id != 3){ %>
                                <li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= caseAutoId %>">
                                <a href="javascript:void(0);">
                                <span style="background-color:#<%= caseDet.lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
                                <%= caseDet.lastCustomStatus.LastCS.name %></a>	
                                </li>
                            <% } 
							}
                      }  
				          } else{ %>
				  <% var caseFlag="";
							if(isAllowed('Change Status of Task',projectUniqid)){
                                    if((caseLegend != 3) && caseTypeId != 10) { caseFlag=5; }
                                    if(caseDet.Easycase.isactive == 1){ %>
                                    <% if(isAllowed("Status change except Close",projectUniqid)){ %>
                                    <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                                    </li>
                                    <% } %>
                                <% } %>
                                <% } %>
                                <% } %>
                                    <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                    <% if(isAllowed('Manual Time Entry',projectUniqid)){ %>
									<% if(caseLegend == 3){ %>
											<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
                                    <li onclick="createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                    </li>
                                    <% } %>
                                    <% } else { %>
										<li onclick="createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
										</li>
                                    <% } %>
                                    <% } %>
                                    
                                    <?php } ?>
                                    <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                    <?php } ?>
                                    <% if((caseFlag == 5 || caseFlag==2) && caseDet.Easycase.isactive == 1) { %>
                                    <!--<li class="divider"></li>-->
                                    <% } %>
                                    <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                    if(caseDet.Easycase.isactive == 1){ %>
                                    <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>">
                                        <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
                                        <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                        <% } %>
                                        <% if(isAllowed('Reply on Task',projectUniqid)){ %>
                                        <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                        <% } %>
                                        </li>
                                    <% }
                                    if( SES_ID == caseUserId) { caseFlag=3; }
                                    if(caseDet.Easycase.isactive == 1 || isAllowed('Edit All Task',projectUniqid)){ %> 
                                    <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                                    <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) ){ %>display:block <% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                    </li>
                                    <% } %>
                                     <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                                    <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                         <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                   </li>
                                   <% } %>
                                   <% }
                                   if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                   if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
                                    <% if(caseDet.Easycase.isactive == 1){ %>
                                    <% if(isAllowed('Move to Project',projectUniqid)){ %>
                                            <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                                            </li>
                                    <% } %>
                                    <% } %>
                                    <% if(caseDet.Easycase.isactive == 0){ %>
                                    <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                                                <a onclick="restoreFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
                                        </li>
                                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                                                <a onclick="removeFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
                                        </li>
                                    <% } %>
                                    <% } %>
                                    <% }
                                    if(caseDet.Easycase.isactive == 1 &&  caseDet.Easycase.pjMethodologyid != 2){ %>
                                    <% if(isAllowed('Move to Milestone',projectUniqid)){ %>
                                    <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                    </li>
                                    <% } %>
                                    <% } %>
                                    <% if(caseDet.Easycase.milestone_id){ %>
                                     <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                                    <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                    </li>
                                    <% } %>
                                    <% } %>
                                    <!--<li class="divider"></li>-->
                                    <% if(caseDet.Easycase.isactive == 1){
                                    if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == caseDet.Easycase.Em_user_id)) {
                                    caseFlag = "remove";%>
                                     <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                                    <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + caseDet.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                    </li>
                                    <% } %>
                                    <%
                                    }
                                    }
                                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
                                    if(caseDet.Easycase.isactive == 1){ %>
                                     <% if(isAllowed('Archive Task',projectUniqid) || isAllowed('Archive All Task',projectUniqid)){ %>
                                    <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                    </li>
                                    <% } %>
                                    <% }
                                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                                    if(caseDet.Easycase.isactive == 1){ %>
                                     <% if(isAllowed('Delete Task',projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                                    <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + caseDet.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                    </li>
                                    <% } %>
                                    <% } %>
				</ul>
			</div>
		</div>
		<div class="cb"></div>
	</td>
      <td>
				<span class="ttype_global tt_<%= getttformats(caseDet.Easycase.csTdTyp[1])%>" style="margin-top:2px;"></span>
        <span id="caseProjectSpanFav<%=caseAutoId %>">
         <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,1,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="margin-top:0px;color:<%=favouriteColor%>;">
             <% if(isFavourite) { %>
                <i class="material-icons" style="font-size:18px;">star</i>
            <% }else{ %>
                 <i class="material-icons" style="font-size:18px;">star_border</i>
            <% } %>
            </a>
        </span>
    </td>
	<% }else { %>
    <td <% if(groupby =='' || groupby !='priority'){%>class="check_list_task tsk_fst_td pr_<%= easycase.getPriority(casePriority) %>"<% } %>>
		<div class="checkbox">
		  <label>
			<% if(caseLegend != 3 && caseTypeId != 10) { %>
			<input type="checkbox" style="cursor:pointer" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|' + caseUniqId %>" class="fl mglt chkOneTsk">
			<% } else if(caseTypeId != 10) { %>
			<input type="checkbox" id="actionChk<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
			<% } else { %>
			<input type="checkbox" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|update' %>" class="fl mglt chkOneTsk">
			<% } %>
		  </label>
		</div>
		<input type="hidden" id="actionCls<%= count %>" value="<%= caseLegend %>" disabled="disabled" size="2"/>			
	</td>
	<td class="text-center count-plist-drop pr"><%= caseNo %>
		<span class="watch showtime_<%= caseAutoId %>"></span>
		<div class="check-drop-icon">
			<div class="dropdown cmn_tooltip_hover">
				<a class="dropdown-toggle tooltip_link" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i>
				</a>
				<ul class="dropdown-menu hover_item">
                     <% 
                    if(typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined'){ 
 if(caseDet.Easycase.isactive == 1){
	 if(isAllowed('Change Status of Task',projectUniqid)){
        if(caseDet.Easycase.CustomStatus.status_master_id != 3){ %>
		<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + caseDet.lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= caseAutoId %>">
        <a href="javascript:void(0);">
    	<span style="background-color:#<%= caseDet.lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
    	<%= caseDet.lastCustomStatus.LastCS.name %></a>	
    	</li>
	<% } 
    }
	}
  } else{ %>
				  <% var caseFlag="";
							if(isAllowed('Change Status of Task',projectUniqid)){
                                if((caseLegend != 3) && caseTypeId != 10) { caseFlag=5; }
                                if(caseDet.Easycase.isactive == 1){ %>
                                <% if(isAllowed("Status change except Close",projectUniqid)){ %>
		                <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
		                    <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                                </li>
                                <% } %>
                                <% } %>
                    <% } %>
                    <% } %>
                                <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                    <% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
									<% if(caseLegend == 3){ %>
											<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
                                    <li onclick="createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                    </li>
                                 <% } %>
                                 <% } else{ %>
									<li onclick="createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                    </li>
                                 <% } %>
                                 <% } %>
                                 
                                <?php } ?>
                                <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                <?php } ?>
                                <% if((caseFlag == 5 || caseFlag==2) && caseDet.Easycase.isactive == 1) { %>
                                <!--<li class="divider"></li>-->
                                <% } %>
                                <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                if(caseDet.Easycase.isactive == 1){ %>
                                <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>">
                                    <% if(isAllowed("Change Status of Task",projectUniqid)){ %>
                                    <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                    <% } %>
                                      <% if(isAllowed("Reply on Task",projectUniqid)){ %>
                                    <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                      <% } %>
                                    </li>
                                <% } %>
                                  
                                <% if( SES_ID == caseUserId) { caseFlag=3; }
                                if(caseDet.Easycase.isactive == 1 || isAllowed('Edit All Task',projectUniqid)){ %> 
                                 <% if( (isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>  
                                <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)|| (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) ){ %>display:block <% } else { %>display:none<% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                </li>
                                <% } %>
                            <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                 <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                      <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                </li>
                             <% } %>       
                                <% }
                                if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
                                <% if(isAllowed("Move to Project",projectUniqid)){ %>    
                                <% if(caseDet.Easycase.isactive == 1){ %>
                                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
                                                <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                                        </li>
                                <% } %>
                                 <% } %>
                                <% if(caseDet.Easycase.isactive == 0){ %>
                                 <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                                                <a onclick="restoreFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
                                        </li>
                                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                                                <a onclick="removeFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
                                        </li>
                                <% } %>
                                        <% } %>
                                <% }
                                if(caseDet.Easycase.isactive == 1  &&  caseDet.Easycase.pjMethodologyid != 2){ %>
                                               <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                                <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                </li>
                                <% } %>
                                <% } %>
                                <% if(caseDet.Easycase.mid){ %>
                                 <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                </li>
                                <% } %>
                                        <% } %>
                    <!--<li class="divider"></li>-->
                                <% if(caseDet.Easycase.isactive == 1){
                                if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == caseDet.Easycase.Em_user_id)) {
                                caseFlag = "remove";%>
                                 <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + caseDet.Easycase.mid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseDet.Easycase.mid + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                </li>
                                        <% } %>
                                <%
                                }
                                }
                                if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
                                if(caseDet.Easycase.isactive == 1){ %>
                                <% if(isAllowed("Archive Task",projectUniqid) || isAllowed('Archive All Task',projectUniqid)){ %>
                                <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                </li>
                              <% } %>
                                <% }
                                if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                                if(caseDet.Easycase.isactive == 1){ %>
                                <% if(isAllowed("Delete Task",projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                                <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                </li>
                                <% } %>
                                        <% } %>
				</ul>
			</div>
		</div>
	</td>	
        <td>
            <span class="ttype_global tt_<%= getttformats(caseDet.Easycase.csTdTyp[1])%>" style="margin-top:2px;"></span>
            <span id="caseProjectSpanFav<%=caseAutoId %>">
            <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,1,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="color:<%=favouriteColor%>;">
                 <% if(isFavourite) { %>
                <i class="material-icons" style="font-size:18px;">star</i>
            <% }else{ %>
                 <i class="material-icons" style="font-size:18px;">star_border</i>
            <% } %>
            </a>
        </span>
        </td>
	<% } %>
	<td class="relative list-cont-td">
	<div class="title-dependancy-all">
		<a href="javascript:void(0);" class="ttl_listing" data-task-id="<%= caseUniqId %>" >
                    <span id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(caseDet.Easycase.type_id!=10 && caseDet.Easycase.legend==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>"> 
                        <span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
						                          <% if(groupby=='milestone') { %>#<%=caseNo%>: <% }%><%= formatText(ucfirst(caseTitle)) %>
                        </span>
                    </span>
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
                                    <li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>.</li>
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
								<div class="task_dependancy parenttt fr">
								<% if(caseDet.Easycase.parent_task_id && caseDet.Easycase.parent_task_id != ""){ %>
									<span class="fl case_act_icons task_parent_block" id="task_parent_id_block_<%= caseUniqId %>">
										<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + caseDet.Easycase.parent_task_id + '\'' %>);" class="fl parent_sub_icons"><i class="material-icons">&#xE23E;</i></div>
										<div class="dropdown dropup fl1 open1 showParents">
											<ul class="dropdown-menu  bottom_dropdown-caret inner_parent_ul">
												<li class="pop_arrow_new"></li>
												<li class="task_parent_msg" style=""><?php echo __('Below tasks are parent task of this Subtask');?>.</li>
												<li>
													<ul class="task_parent_tt_items" id="task_parent_tt_<%= caseUniqId %>" style="">
														<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
													</ul>
												</li>
											</ul>
										</div>
									</span>
								<% } %>			
							</div>
					<div class="cb"></div>
			</div>
			</a>
		</div>
</td>
<td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="casecount<%= count %>" style="cursor:pointer;"<% } %>>
	<a href="javascript:void(0);" <% if(caseDet.Easycase.format != 1 && caseDet.Easycase.format != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
		<i class="glyphicon glyphicon-paperclip"></i>
	</a>
	<% if(getTotRep && getTotRep!=0) { %><%= getTotRep %><% } %>
	<a href="javascript:void(0)" id="repno<%= count %>" style="<% if(!getTotRep || getTotRep==0) { %>display:none<% } %>">
		<i class="material-icons">&#xE0B9;</i>
	</a>
</td>
<% if(isactive==0){ %>
<td></td>
<% } else { %>
<% if(inArray('Assigned to',field_name_arr)){ %>
<td class="assi_tlist">
	<i class="material-icons">&#xE7FD;</i>			
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="showUpdAssign<%= caseAutoId %>" <% if(isAllowed('Change Assigned to',projectUniqid)){ %> data-toggle="dropdown"<% } %> title="<%= sho_assign_nm %>" class="clsptr" onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + caseDet.Easycase.client_status + '\'' %>)"><%= sho_assign_nm %><span class="due_dt_icn"></span></span>
	<% } else { %>
	<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;">
	<% if(caseAssgnUid != SES_ID){ %>
	<%= caseDet.Easycase.asgnShortName %>
	<% }else{ %>
		<?php echo __('me');?>
	<% } %>
	</span>
	<% } %>
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>			
	<span class="check-drop-icon dsp-block" <% if((projUniq != 'all') && showQuickActiononList){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + caseDet.Easycase.client_status + '\'' %>)" <% } %>>
		<span class="dropdown">
			<a class="dropdown-toggle" <% if(isAllowed('Change Assigned to',projectUniqid)){ %> data-toggle="<% if((projUniq != 'all') && showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);"<% } %>  data-target="#">
			  <i class="material-icons">&#xE5C5;</i>
			</a>
			<ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem<%= caseAutoId %>">
			  <li class="text-centre"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="assgnload<%= caseAutoId %>" /></li>
			</ul>
		</span>
	</span>
</td>
<% } %>
<% } %>
<% if(inArray('Priority',field_name_arr)){ %>
<td  class="text-center <% if(caseDet.Easycase.csTdTyp[1] != 'Update'){ %>task_priority csm-pad-prior-td<% }else{ %>csm-pad12-prior-td<% } %>">
    <% var csLgndRep = caseDet.Easycase.legend; %>
    <% if(caseDet.Easycase.csTdTyp[1] == 'Update'){ %>
        <span class="prio_high prio_lmh prio_gen" rel="tooltip" title="Priority:high"></span>
    <% }else{ %>
    <div style="" id="pridiv<%= caseAutoId %>" data-priority ="<%= casePriority %>" class="pri_actions <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> <% if(showQuickActiononList){ %> dropdown<% } %> <% } %>">    
        <div class="dropdown cmn_h_det_arrow">
        <div <% if(showQuickActiononList){ %> class="quick_action" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> style="cursor:pointer" <% } %> ><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>:<%= easycase.getPriority(casePriority) %>"></span><i class="tsk-dtail-drop material-icons">&#xE5C5;</i></div>
        <% var csLgndRep = caseDet.Easycase.legend; %>
        <% if(showQuickActiononList){ %>
            <ul class="dropdown-menu quick_menu">
                <li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'2\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
                <li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'1\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
                <li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'0\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
            </ul>
        <% } %>
        </div>
    </div>
    <span id="prilod<%= caseAutoId %>" style="display:none">
            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
    </span>
    <% } %>
</td>
<% } %>
<% if(inArray('Estimated Hours',field_name_arr)){ %>
		<td class="esthrs_dt_tlist text-center">
            <p class="estblist ttc <% if(!isAllowed('Est Hours',projectUniqid)){ %> no-pointer <% } %>" id="est_blist<%=caseAutoId%>" style="cursor:pointer;" case-id-val="<%=caseAutoId%>" >
				<span class="border_dashed">
					<% if(caseEstHours) { %> <%= caseEstHours %> <% } else { %><?php echo __('None');?><% } %>
				</span>
			</p>
			
			<% var est_time = Math.floor(caseEstHoursRAW/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
			
			<input type="text" data-est-id="<%=caseAutoId%>" data-est-no="<%=caseNo%>" data-est-uniq="<%=caseUniqId%>" data-est-time="<%=est_time%>" id="est_hrlist<%=caseAutoId%>" class="est_hrlist form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can enter time as 1.5(that mean 1 hour and 30 minutes)');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
			
			<span id="estlod<%=caseAutoId%>" style="display:none;margin-left:0px;">
				<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
			</span>
		</td>
	<% } %>
    <% if(inArray('Spent Hours',field_name_arr)){ %>
	<td class="border-right-td esthrs_dt_tlist text-center">
    <p style="cursor:auto;" >
			<span >
			<% if(caseDet.lt.tot_spent_hour) { %> <%= caseDet.lt.tot_spent_hour %> <% } else { %><?php echo __('None');?><% } %>
			</span>
		</p>
	</td>
<% } %>
<% if(inArray('Updated',field_name_arr)){ %>
<td class="text-center" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('updated');?><% } else { %><?php echo __('created');?><% } %> <?php echo __('by');?> <%= caseDet.Easycase.usrShortName %> <% if(caseDet.Easycase.updtedCapDt.indexOf('Today')==-1 && caseDet.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= caseDet.Easycase.updtedCapDt %> <%= caseDet.Easycase.fbstyle %>."><%= caseDet.Easycase.fbstyle %></td> 
<% } %>
<% if(inArray('Status',field_name_arr)){ %>
    <td>
		<div class="cs_select_dropdown">
			<span id="csStsRep<%= count %>" class="cs_select_status">
			<% if(isactive==0){ %>
					<div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
			<%}else if(groupby =='' || groupby !='status'){
			 if(caseDet.Easycase.custom_status_id != 0 && caseDet.Easycase.CustomStatus != null){ %>
				<%= easycase.getCustomStatus(caseDet.Easycase.CustomStatus, caseDet.Easycase.custom_status_id) %>
			<% }else{ %>
					<%= easycase.getStatus(caseDet.Easycase.type_id, caseDet.Easycase.legend) %>
			<% } %>
			<% } %>
			</span>
			<span class="check-drop-icon dsp-block">
			<span class="dropdown cmn_h_det_arrow">
				<a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
					<i class="material-icons">&#xE5C5;</i>
				</a>
				<ul class="dropdown-menu">
				<% if(isAllowed("Change Status of Task",projectUniqid)){
							if(typeof caseDet.customStatusByProject !="undefined" && typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined' && caseDet.customStatusByProject[caseDet.Easycase.project_id] != null){
								$.each(caseDet.customStatusByProject[caseDet.Easycase.project_id], function (key, data) {
									if(caseDet.Easycase.CustomStatus.id != data.id){
										if(data.status_master_id == 3){
											if(isAllowed("Status change except Close",projectUniqid)){ %>
												<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
												<a href="javascript:void(0);">
												<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span>
												<%= data.name %></a>
												</li>
											<% }
										}else { %>
										<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
										<a href="javascript:void(0);">
										<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span>
										<%= data.name %></a>		
										<% }
									}
								});
							}else{
								var caseFlag="";
								if(caseLegend != 1 && caseTypeId != 10){ caseFlag=9; }
								if(caseDet.Easycase.isactive == 1){ %>
									<li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
										<a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
									</li>
								<% }
								 if((caseLegend != 2 && caseLegend != 4) && caseTypeId!= 10) { caseFlag=1; }
								if(caseDet.Easycase.isactive == 1) { %>
									<li onclick="startCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);"id="start<%= caseAutoId %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
									<a href="javascript:void(0);"><i class="material-icons">&#xE039;</i>
									<% if(caseLegend == 1){ %>
									<?php echo __('Start');?>
									<% } else { %>
									<?php echo __('In Progress');?>
									<% } %>
									</a>
									</li>
								<% }
								if((caseLegend != 5) && caseTypeId!= 10) { caseFlag=2; }
								if(caseDet.Easycase.isactive == 1){ %>
									<li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
										<a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
									</li> 
								<% }
								if((caseLegend != 3) && caseTypeId != 10) { caseFlag=5; }
								if(caseDet.Easycase.isactive == 1){
									if(isAllowed("Status change except Close",projectUniqid)){ %> 
										<li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
											<a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
										</li>
									<% }	
								}

							} 
						} %>
				</ul>
			</span>
		</span>
	</div>
    </td>
    <% } %>
    <% if(inArray('Due Date',field_name_arr)){ %>
    <td class="due_dt_tlist">
        <div class="<% if(caseDet.Easycase.csDueDate == ''){ %> toggle_due_dt <% } %>">
            <% if(caseDet.Easycase.isactive == 1){ %>
			<?php /*
            <% if(showQuickActiononList && caseTypeId != 10){ %>
            <span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
            <% } %>
			*/ ?>
            <span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= caseDet.Easycase.csDuDtFmtT %>">
                    <%= caseDet.Easycase.csDuDtFmt %>
            </span>
            <span id="datelod<%= caseAutoId %>" class="asgn_loader">
                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
            </span>
            <% } %>
            <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
      <a class="dropdown-toggle" <% if(isAllowed('Update Task Duedate',projectUniqid)){ %> data-toggle="<% if(showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);"  <% } %> data-target="#">
                              <i class="material-icons">&#xE5C5;</i>
                            </a>
                            <ul class="dropdown-menu">
                                    <li class="pop_arrow_new"></li>
                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>);changeDueDate(<%= '\'' + caseAutoId + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId + '\'' %>)"><?php echo __('No Due Date');?></a></li>
                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + caseDet.mdyCurCrtd + '\', \'Today\', \'' + caseUniqId + '\'' %>)"><?php echo __('Today');?></a></li>
                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + caseDet.mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId + '\'' %>)"><?php echo __('Tomorrow');?></a></li>
                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + caseDet.mdyMonday + '\', \'Next Monday\', \'' + caseUniqId + '\'' %>)"><?php echo __('Next Monday');?></a></li>
                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + caseDet.mdyFriday + '\', \'This Friday\', \'' + caseUniqId + '\'' %>)"><?php echo __('This Friday');?></a></li>
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
    </td>
    <% } %>	
     <% if(inArray('Progress',field_name_arr)){ %>
    <td class="progress_tlist text-center"><%= caseDet.Easycase.completed_task %>%</td>
  <% } %>	
</tr>