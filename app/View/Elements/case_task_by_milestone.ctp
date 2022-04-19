<?php if (defined("RELEASE_V") && RELEASE_V) { ?>
<%
var rel_arr = new Array();
%>
<% prvGrpvalue= milesto_names['mid']; %>
    <% var d_mid = mid; if(d_mid == 'NA'){ d_mid = 0;} %>
    <% if(d_mid == 0 || (d_mid != 0 && milesto_names['isactive'] == 1)){ %>
    <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
    <tr class="white_bg_tr">
            <td class="prtl"><div class="wht-bg"></div></td>
            <td colspan="11" class="transp_bg">
            <div class="width40">
                    <div class="form-group label-floating">
                            <div id="inlin_qtsk_link<%= d_mid %>"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr" onclick="showhidegroupqt(<%= d_mid %>);"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task');?></a></div>
                            <div style="display:none;" class="input-group" id="inlin_qtsk_c<%= d_mid %>">
                            <label class="control-label" for="addon3a"><?php echo __('Quick Task');?></label>
                            <input data-mid="<%= d_mid %>" id="addon<%= d_mid %>" class="in_qt_taskgroup form-control inline_qktask<%= d_mid %>" type="text" maxlength="240" onblur="showhidegroupqt(<%= d_mid %>,1);">
                            <span class="input-group-btn">
                                    <button data-mid="<%= d_mid %>" type="button" class="btn btn-fab btn-fab-mini in_qt_taskgroupbtn">
                                    <i class="material-icons qk_send_icon_tg<%= d_mid %>">send</i>
                                    </button>
                            </span>
                            </div>
                    </div>
            </div>
            </td>
    </tr>
<?php } ?>
    <% } %>

<% if(caseAll.length >0){
count=0;
var groupby = 'milestone';
for(var mkey in caseAll){ 
    Easycase=caseAll[mkey]['Easycase'];
    EasycaseMilestone=caseAll[mkey]['EasycaseMilestone'];
    caseAutoId=Easycase['id'];
    var isFavourite = Easycase['isFavourite'];
    var favMessage ="Set favourite task";
    if(isFavourite){
        var favMessage ="Remove from the favourite task";
    }
    var favouriteColor = Easycase['favouriteColor'];
    projId=Easycase['project_id'];
    caseLegend=Easycase['legend'];
    caseTypeId=Easycase['type_id'];
    caseNo = Easycase['case_no'];
    caseUniqId =Easycase['uniq_id'];
    caseUserId = Easycase['user_id'];
    casePriority = Easycase['priority'];
    caseFormat = Easycase['format'];
    caseTitle = Easycase['title'];
	caseEstHoursRAW = Easycase['estimated_hours'];
	caseEstHours = Easycase['estimated_hours_convert'];
    isactive = Easycase['isactive'];
    caseAssgnUid = Easycase['assign_to'];
    usrShortName=Easycase['usrShortName'];
    asgnShortName=Easycase['asgnShortName'];
    asgnName=Easycase['asgnName'];
    is_recurring=Easycase['is_recurring'];
    projectUniqid=Easycase['pjUniqid'];
    projectName=Easycase['pjname'];
    csDueDate=Easycase['csDueDate'];
    csDuDtFmt=Easycase['csDuDtFmt'];
    csDuDtFmtT=Easycase['csDuDtFmtT'];
    csTdTyp=Easycase['csTdTyp'];
    
    
    var getTotRep = 0;
    if(Easycase['reply_cnt'] && Easycase['reply_cnt']!=0) {		
    getTotRep = Easycase['reply_cnt'];
    }
	var getTotRepCnt = (Easycase.case_count)?Easycase.case_count:0;
    count++; 
    var showQuickActiononList = 0;
    var showQuickActiononListEdit = 0;
   /* if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
    var showQuickActiononList = 1;
    }*/
    if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
        showQuickActiononList = 1;
    }
    if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
              showQuickActiononListEdit = 1;
    }


    mid=EasycaseMilestone['mid'];
    projUniq=Easycase['pjUniqid'];
    fbstyle=Easycase['fbstyle'];
    %>
    
    <% if(Easycase['isactive']==0) {%>
    <tr class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
        <% }else {%>
    <tr class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
        <% }%>	
        <td class="prtl">
        <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
            <div class="fl os_sprite dot-bar"></div>
        <?php } ?>
            <div class="wht-bg"></div>
        </td>
        <td class="ctg_check_td pr">
            <div class="checkbox fl">
                <label>
                    <% if(caseLegend != 3 && caseTypeId != 10) { %>
                    <input type="checkbox" style="cursor:pointer" id="actionChk<%= caseAutoId %>-<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|' + caseUniqId %>" class="fl mglt chkOneTsk">
                    <% } else if(caseTypeId != 10) { %>
                    <input type="checkbox" id="actionChk<%= caseAutoId %>-<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
                    <% } else { %>
                    <input type="checkbox" id="actionChk<%= caseAutoId %>-<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|update' %>" class="fl mglt chkOneTsk">
                    <% } %>
                </label>
                <input type="hidden" id="actionCls<%= caseAutoId %>-<%= count %>" value="<%= caseLegend %>" disabled="disabled" size="2"/>			
            </div>			
            <div class="check-drop-icon fl">
                <div class="dropdown cmn_tooltip_hover"> 
                    <a class="dropdown-toggle tooltip_link" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                        <i class="material-icons">&#xE5D4;</i><?php //&#xE5C5;  ?>
                    </a>
                    <ul class="dropdown-menu addn_menu_drop_pos hover_item">
                    <% if(isAllowed("Change Status of Task",projectUniqid)){ %>
						<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[Easycase.project_id] !='undefined' && customStatusByProject[Easycase.project_id] != null){
						if(isactive == 1) {
            $.each(customStatusByProject[Easycase.project_id], function (key, data) {
						if(Easycase.CustomStatus.id != data.id){
						%>
                        <% if(data.status_master_id == 3){ %>
                                <% if(isAllowed("Status change except Close",projectUniqid)){ %>
						<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
						<a href="javascript:void(0);"><span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %></a>
														</li>
                        <% } %>
                        <% }else{ %>
						<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
						<a href="javascript:void(0);"><span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %></a>
														</li>
                          <% } %>
						<%   } 
						}); 
            }
						} else{ %>
                        <% var caseFlag="";
                  if(caseLegend != 1 && caseTypeId != 10){ caseFlag=9; }
                    if(isactive == 1){ %>
                    <li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                        <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                    </li>
                        
                     <% }
                     if((caseLegend != 2 && caseLegend != 4)&& caseTypeId!= 10) { caseFlag=1; }
                        if(isactive == 1) { %>
                    <li onclick="startCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="start<%= caseAutoId %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
                        <a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(caseLegend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
                        </li>
                        <% }
                    		if(caseLegend != 5 && caseTypeId!= 10) { caseFlag=2; }
                        if(isactive == 1){ %>
                    <li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                        </li>
                        <% }
                         if(caseLegend != 3 && caseTypeId != 10) { caseFlag=5; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Status change except Close",projectUniqid)){ %>
                    <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                        </li>
                    <% }  %>
                    <% }  %>
                    <% }  %>
                    <% }  %>
                        <?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                            <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
                            <li onclick="setSessionStorage(<%= '\'Task Group List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle, 3)) + '\'' %> );" class="anchor">
                                <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                            </li>
                            <% } %>
                            
                        <?php } ?>
                        <?php if (SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                        <?php } ?>
                        <% if((caseFlag == 5 || caseFlag==2) && isactive == 1) { %>
                        <% } %>
                        <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                        if(isactive == 1){ %>
                         <% if(isAllowed("Reply on Task",projectUniqid)){ %> 
                        <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group List Page">
                            <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="<?php echo __('Re-open');?>"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>

                            <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>">
                                <i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                        </li>
                        <% } %>
                        <% }
                        if( SES_ID == caseUserId) { caseFlag=3; }
                        if(isactive == 1){ %> 
                        <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %> 
                        <% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %> 
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
                        <% }
                        if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                        if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
                        <% if(isactive == 1){ %>
                         <% if(isAllowed("Move to Project",projectUniqid)){ %> 
                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject( <%= '\'' + count + '\'' %> , this);">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% if(isactive == 0){ %>
                        <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> 
                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                            <a onclick="restoreFromTask( <%= caseAutoId %> , <%= projId %> , <%= caseNo %> )" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
                        </li>
                        <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
                            <a onclick="removeFromTask( <%= caseAutoId %> , <%= projId %> , <%= caseNo %> )" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% }
                        if(isactive == 1){ %>
                         <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                        <li onclick="moveTask( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'\'' %> , <%= '\'' + projId + '\'' %> );" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% if(EasycaseMilestone['mid']){ %>
                        <% if(isAllowed("Move to Milestone",projectUniqid)){ %>
                        <li onclick="removeTask( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'\'' %> , <%= '\'' + projId + '\'' %> );" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <!--<li class="divider"></li>-->
                        <% if(isactive == 1){
                        if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == Easycase['user_id'] || isAllowed('Delete All Task',projectUniqid))) {
                        caseFlag = "remove";%>
                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                        <li onclick="removeThisCase( <%= '\'' + count + '\'' %> , <%= '\'' + EasycaseMilestone['mid'] + '\'' %> , <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + mid + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + caseUserId + '\'' %> );" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                        </li>
                        <% } %>
                        <%
                        }
                        }
                        if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed("Archive All Task",projectUniqid)) { caseFlag = "archive"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
                        <li onclick="archiveCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %> );" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                        </li>
                        <% } %>
                        <% }
                        if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                        <li onclick="deleteCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %> , <%= '\'' + is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                        </li>
                        <% } %>
                        <% } %>
                    </ul>
                </div>
            </div>
            <div class="cb"></div>
			
			
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
        <td class="relative list-cont-td">
			<div class="title-dependancy-all">
            <a href="javascript:void(0);" class="ttl_listing"  data-task-id="<%= caseUniqId %>">
                <span id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(Easycase['type_id']!=10 && Easycase['legend']==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>"> 
					                    <span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
                        #<%=caseNo%>: <%= formatText(ucfirst(caseTitle)) %>
                    </span>
                </span>
            <div class="task_dependancy_item">
			<div class="task_dependancy fr">
		<% if(Easycase.children && Easycase.children != ""){ %>
			<span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId %>">
				<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
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
		<% if(Easycase.depends && Easycase.depends != ""){ %>
			<span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId %>">
				<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
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
		<div class="task_dependancy parenttt fr">
			<% if(Easycase.parent_task_id && Easycase.parent_task_id != ""){ %>
				<span class="fl case_act_icons task_parent_block" id="task_parent_id_block_<%= caseUniqId %>">
					<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + Easycase.parent_task_id + '\'' %>);" class="fl parent_sub_icons"><i class="material-icons">&#xE23E;</i></div>
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
            <div class="list-td-hover-cont">
                <span class="created-txt"><% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= usrShortName %> <% if(Easycase['updtedCapDt'].indexOf('Today')==-1 && Easycase['updtedCapDt'].indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= Easycase['updtedCapDt'] %></span>
                <span class="list-devlop-txt dropdown">
                    <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                        <i class="material-icons tag_fl">&#xE54E;</i>
                        <span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && isactive == 1){ %>clsptr<% } %>" title="<%= csTdTyp[1] %>" >
                          <span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= csTdTyp[1]%><span class="due_dt_icn"></span>
                          </span> 
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
                            if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == Easycase.project_id){
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



                <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
                        <% if(showQuickActiononList && isactive == 1){ %>
                        <ul class="dropdown-menu listgrp-bug-dropdn">
                            <li>
                                     <input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="seachitems(this);" />
                                 </li>	
                            <%
                            for(var k in GLOBALS_TYPE) {
                             if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == Easycase.project_id){
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
                <% if(is_recurring == 1 || is_recurring == 2){ %>
                <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
                <% } %>
                <span class="small-list-devlop-icon">
                    <% var caseFlag=""; 					
                    if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                    if(isactive == 1){ 
                    if(caseFlag == 2){ %>
                    <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
                    <a rel="tooltip" title="<?php echo __('Resolve');?>" href="javascript:void(0)" onclick="caseResolve( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + caseUniqId + '\'' %> );">
                        <i class="material-icons">&#xE039;</i>
                    </a>
                    <% } %>
                    <% } }
                    if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4 || caseLegend == 5) && caseTypeId != 10) { caseFlag=5; }
                    if(isactive == 1){ 
                    if(caseFlag == 5) {	%>
                    <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
            					<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[Easycase.project_id] !='undefined' && customStatusByProject[Easycase.project_id] != null){ %>
                                    <% if(isAllowed("Status change except Close",projectUniqid)){ %>
            						<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);">
            							<i class="material-icons">&#xE876;</i>
            						</a>
                                <% } %>
            					<% }else{ %>
                                <% if(isAllowed('Status change except Close',projectUniqid)){ %>
                    <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCloseCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + caseUniqId + '\'' %> );">
                        <i class="material-icons">&#xE876;</i>
                    </a>
                                <% } %>
                    <% } } } } %>					
                    <?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                        <% if(isAllowed('Manual Time Entry',projectUniqid)){ %>
                        <span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle, 3)) + '\'' %> );" class="case_act_icons task_title_icons_timelog fl"></span>
                        <% } %>
                    <?php } ?>
                    <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                    if(isactive == 1){ %> 
                    <% if(isAllowed('Reply on Task',projectUniqid)){ %>       
                    <a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 7){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group List Page" rel="tooltip" title="<?php echo __('Re-open');?>"><i class="material-icons">&#xE898;</i></a>
                    <a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 8){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group List Page" rel="tooltip" title="<?php echo __('Reply');?>"><i class="material-icons">&#xE15E;</i></a>
                    <% } %>
                    <% }
                    if( SES_ID == caseUserId) { caseFlag=3; }
                    if(isactive == 1){ 
                    if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %>
                    <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                    <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask( <%= '\'' + caseUniqId + '\',\'' + projectUniqid + '\',\'' + htmlspecialchars(projectName) + '\'' %> );">
                        <i class="material-icons">&#xE254;</i>
                    </a>
                    <% } %>
                    <% } } %>	
                    <?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                        <% if(isAllowed('Manual Time Entry',projectUniqid)){ %>
                        <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle, 3)) + '\'' %> );">
                            <i class="material-icons">&#xE8B5;</i>
                        </a>
                        <% } %>
                    <?php } ?>
                    <%
                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed("Archive All Task",projectUniqid)) { caseFlag = "archive"; }
                    if(isactive == 1){ 
                    if(caseFlag == "archive"){ %>
                     <% if(isAllowed('Archive Task',projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
                    <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %> );">
                        <i class="material-icons">&#xE149;</i>
                    </a>
                    <% } %>
                    <% } }
                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                    if(isactive == 1){ 
                    if(caseFlag == "delete"){ %>
                    <% if(isAllowed('Delete Task',projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                    <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + caseNo + '\'' %> , <%= '\'' + projId + '\'' %> , <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + is_recurring + '\'' %> );">
                        <i class="material-icons">&#xE872;</i>
                    </a>
                    <% } %>
                    <% } } %>
                </span>
            </div>
        </td> 
        <td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="kanbancasecount<%= count %>" style="cursor:pointer;"<% } %>>
            <a href="javascript:void(0);" <% if(caseFormat != 1 && caseFormat != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
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
            <span id="showUpdAssign<%= caseAutoId %>" <% if(isAllowed('Change Assigned to',projectUniqid)){ %> data-toggle="dropdown" <% } %>title="<%= asgnName %>" class="clsptr" onclick="displayAssignToMem( <%= '\'' + caseAutoId + '\'' %> , <%= '\'' + projUniq + '\'' %> , <%= '\'' + caseAssgnUid + '\'' %> , <%= '\'' + caseUniqId + '\'' %> )"><%= asgnShortName %><span class="due_dt_icn"></span></span>
            <% } else { %>
            <span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= asgnShortName %></span>
            <% } %>
            <% if((projUniq != 'all') && showQuickActiononList){ %>
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
        </td>
        <% } %>
        <% } %>
        <% if(inArray('Priority',field_name_arr)){ %>
        <td  class="text-center csm-pad-prior-td">
            <div style="" id="pridiv<%= caseAutoId %>" class="pri_actions <% if(showQuickActiononList){ %> dropdown<% } %>">    
                <div class="dropdown cmn_h_det_arrow lmh-width">
                    <div <% if(showQuickActiononList){ %> class="quick_action" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> <% } %> style="cursor:pointer"><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>:<%= easycase.getPriority(casePriority) %>"></span><i class="tsk-dtail-drop material-icons">&#xE5C5;</i></div>
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
        </td>
        <% } %>
		
		<% if(inArray('Estimated Hours',field_name_arr)){ %>
			<td class="esthrs_dt_tlist text-center">
				<p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblist <?php } ?> ttc" id="est_blist<%=caseAutoId%>" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> case-id-val="<%=caseAutoId%>" >
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
		
        <% if(inArray('Updated',field_name_arr)){ %>
        <td class="text-center" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %>updated<% } else { %>created<% } %> by <%= usrShortName %> <% if(Easycase['updtedCapDt'].indexOf('Today')==-1 && Easycase['updtedCapDt'].indexOf('Y\'day')==-1) { %>on<% } %> <%= Easycase['updtedCapDt'] %> <%= fbstyle %>."><%= fbstyle %></td>
        <% } %>
        <% if(inArray('Status',field_name_arr)){ %>
        <td>
            <span id="csStsRep<%= count %>" class="">
				<% if(isactive==0){ %>
					<div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
				<%}else if(groupby =='' || groupby !='status'){
				  if(Easycase.custom_status_id != 0 && Easycase.CustomStatus != null ){ %>
					<%= easycase.getCustomStatus(Easycase.CustomStatus, Easycase.custom_status_id) %>
				<% }else{ %>
				  <%= easycase.getStatus(Easycase.type_id, Easycase.legend) %>
				 <% }
					} %>
            </span>
        </td>
        <% } %>
        <% if(inArray('Due Date',field_name_arr)){ %>
        <td class="due_dt_tlist">
            <div class="<% if(csDueDate == '' || caseLegend == 5 || caseTypeId == 10 || caseLegend == 3){ %> toggle_due_dt <% } %>">
                <% if(isactive == 1){ %>
                <% if(showQuickActiononList && caseTypeId != 10){ %>
                <span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
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
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + mdyCurCrtd + '\', \'Today\', \'' + caseUniqId + '\'' %> )"><?php echo __('Today');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId + '\'' %> )"><?php echo __('Tomorrow');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + mdyMonday + '\', \'Next Monday\', \'' + caseUniqId + '\'' %> )"><?php echo __('Next Monday');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId + '\', \'' + mdyFriday + '\', \'This Friday\', \'' + caseUniqId + '\'' %> )"><?php echo __('This Friday');?></a></li>
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
        <td class="progress_tlist text-center"><%= Easycase['completed_task'] %>%</td>
      <% } %>
    </tr>
    <% }
    }else{%>
    <tr class="noRecord"><td class="prtl"><div class="wht-bg"></div></td><td colspan="11" class="textRed"><?php echo __('No tasks found');?>.</td></tr>
    <% } %>
<?php } ?>