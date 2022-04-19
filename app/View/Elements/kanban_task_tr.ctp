<%
	var count = 1;
	var getdata = caseDet;				
	var caseAutoId = getdata.Easycase.id;
	var caseUniqId = getdata.Easycase.uniq_id;
	var caseNo = getdata.Easycase.case_no;
	var caseUserId = getdata.Easycase.user_id;
	var caseTypeId = getdata.Easycase.type_id;
	var projId = getdata.Easycase.project_id;
	var caseLegend = getdata.Easycase.legend;
	var casePriority = getdata.Easycase.priority;
	var caseFormat = getdata.Easycase.format;
	var caseTitle = getdata.Easycase.title;
	var caseAssgnUid = getdata.Easycase.assign_to;
	var is_active = getdata.Easycase.isactive;
	var getTotRep = 0;	
var caseParenId = getdata.Easycase.parent_task_id;	
	var showQuickActiononList = 0;
	if(getdata.Easycase.thread_count && getdata.Easycase.thread_count!=0) {getTotRep = getdata.Easycase.thread_count;}
	if(caseUrl == caseUniqId) {openId = count;}
	var chkDat = 0;
	if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
		showQuickActiononList = 1;
	}
	projectName =	getdata.Easycase.pjname;
	projectUniqid = getdata.Easycase.pjUniqid;
 %>
<div class="kb_task_det item-<%= caseAutoId %> prioo-bdr-<%= easycase.getPriority(casePriority) %> kbtask_div" title="<% if(getTotRep && getTotRep!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> ">
	<span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="<?php echo __('Priority');?>: <%=  easycase.getPriority(casePriority) %>"></span>
	<h6  id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>line_through<% } %> case_title_<%= caseAutoId %>">
		<span class="case-title-kbn-<%= caseAutoId %>">#<%= caseNo %>: <%= caseTitle %></span>
		<span class="rt_icn">
			<span class="dropdown">
				<a class="dropdown-toggle main_page_menu_togl" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
				  <i class="material-icons">&#xE5D4;</i>
				</a>
				<ul class="dropdown-menu addn_menu_drop_pos_kbn">
        <% if(isAllowed("Change Status of Task",projectUniqid)){ %>
				   <% 
            if(typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined'){ 
					 if(getdata.Easycase.isactive == 1){
           $.each(caseDet.customStatusByProject[caseDet.Easycase.project_id], function (key, data) {
						if(caseDet.Easycase.CustomStatus.id != data.id){
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
							if(getdata.Easycase.isactive == 1){ %>
							<li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
							</li>
							<% }
							if((caseLegend != 2 && caseLegend != 4) && caseTypeId!= 10) { caseFlag=1; }
							if(getdata.Easycase.isactive == 1) { %>
							<li onclick="startCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="start<%= caseAutoId %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
									<a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(caseLegend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
							</li>
							<% }
							if((caseLegend != 5) && caseTypeId!= 10) { caseFlag=2; }
							if(getdata.Easycase.isactive == 1){ %>
							<li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
									<a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
							</li>
							<% }
							if((caseLegend != 3) && caseTypeId != 10) { caseFlag=5; }
							if(getdata.Easycase.isactive == 1){ %>
							<% if(isAllowed("Status change except Close",projectUniqid)){ %>
							<li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
									<a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
							</li>
							<% } %>
							<% } if(caseFlag == 5 || caseFlag==2) { %>
							<% } %>
						<% } %>
            <% } %>
			<% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									
									if((getdata.Easycase.is_sub_sub_task==null) || (getdata.Easycase.is_sub_sub_task=='')){
									if(caseLegend !=3 && caseTypeId != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Create Sub task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } }%>
                          <% } %>
					<% if(caseParenId){ %>
					<% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
										  
                                        <li onclick="convertToParentTask(<%= '\''+ caseAutoId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Convert To Parent Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
                                        </li>
                                      
					<% } } %>
									  <% if(caseParenId == "" || caseParenId == null){ %>
									  <%	if((getdata.Easycase.sub_sub_task==null) || (getdata.Easycase.sub_sub_task =="") || (getdata.Easycase.sub_sub_task ==0)){  %>
										  <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                        <li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Convert To Sub Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
                                        </li>
                                      
									  
										  <% } } } %>
						<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
						<% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
								<% if(caseLegend == 3){ %>
									<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
									<li onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
										<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
									</li>
									<% } %>
								<% }else{ %>
						<li onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
							<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
						</li>
								<% } %>
						<% } %>						
						<?php } ?>
						<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
						if(getdata.Easycase.isactive == 1){ %>
						<li id="bk_act_reply<%= count %>" data-task="<%= caseUniqId %>" onclick="setSessionStorage(<%= '\'Kanban Task Status\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);">
								<a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE898;</i><?php echo __('Re-open');?></a>
								<a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
						</li>
						<% }
						if(SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId == SES_ID)) { caseFlag=3; }
						if(showQuickActiononList == 1){ %>
						<li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(caseFlag == 3){ %>display:block <% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
						</li>
						<% } 
						if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
						if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){
						%>
						<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>" onclick="mvtoProject(<%= '\'' + count + '\'' %>,this)" id="mv_prj<%= caseAutoId %>" style=" ">
							<a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
						</li>
						<% } 
						if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
						if(getdata.Easycase.isactive == 1){ %>
						<li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
						</li>
						<% } %>
						<% if(getdata.Easycase.isactive == 1){
						if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
						caseFlag = "remove";
						%>
						<li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
						</li>
						<%
						}
						}
						if(SES_TYPE == 1 || SES_TYPE == 2 || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ( SES_ID == caseUserId))) { caseFlag = "archive"; }
						if(getdata.Easycase.isactive == 1){ %>
						<li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
						</li>
						<% }
						if(SES_TYPE == 1 || SES_TYPE == 2 || (caseLegend == 1  && SES_ID == caseUserId)) { caseFlag = "delete"; }
						if(getdata.Easycase.isactive == 1){ %>
						<li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
						</li>
						<% } %>
				</ul>
			</span>
		</span>
	</h6>
	<div class="kb_det_icn">
		<?php /* <% if(getdata.Easycase.csTdTyp[1]){ %><i class="glyphicon glyphicon-tags" rel="tooltip" title="<%= getdata.Easycase.csTdTyp[1] %>"></i><% } %> */ ?>		
		<% if(getdata.Easycase.csTdTyp[1]){ %>
		 <span class="ttype_global tt_<%= getttformats(getdata.Easycase.csTdTyp[1])%>" title="<%= getdata.Easycase.csTdTyp[1] %>"></span>
		<% } %>		
		<% if(getdata.Easycase.csDuDtFmt.search("Set Due Dt") >= 0 || getdata.Easycase.csDuDtFmt=='No Due Date' || getdata.Easycase.csDuDtFmt.search("Schedule it") >= 0){%><% } else { %><i class="material-icons" rel="tooltip" title="<%= getdata.Easycase.csDuDtFmtT %>">&#xE878;</i> <% } %>
		<% if(getTotRep && getTotRep!=0) { %>
		<i  class="material-icons material-cnt" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="kanbancasecount<%= count %>" style="cursor:pointer;"<% } %>">&#xE253;</i>
		<span class="count_knbn"><%= getTotRep %>
			<span class="fl case_act_icons task_dependent_block" style="float: none;position: absolute;width: auto;left: 0;right: 0;margin: auto;max-width: 500px;width:500px">
			</span>
		</span>
		<% } %>
		<% if(getdata.Easycase.format != 2) { %><span title="files/attachments" class="att_fl" style="    display: inline-block;position: relative;top: 5px;left: 4px;"></span><% } %>					
		<% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %><a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" class="recurring-icon" onclick="showRecurringInfo(<%= getdata.Easycase.id %>);"><i class="material-icons">&#xE040;</i></a><% } %>
		<div class="gantt_kanban_depedant_block" style="width:auto;float:right;height:14px;">
			<span class="case_act_icons fl" style="display:inline-block;">
					<% if(getdata.Easycase.children && getdata.Easycase.children != ""){ %>
					<span class="fl  task_parent_block" id="task_parent_block_<%= getdata.Easycase.uniq_id %>">
						<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
						<div class="dropdown dropup1 fl1 open1 showParents">
							<ul class="dropdown-menu  bottom_dropdown-caret" style="<% if(getdata.Easycase.depends && getdata.Easycase.depends != ''){ %>left:-195px;<%}else{%>left:-210px;<%}%>">
								<li class="pop_arrow_new"></li>
								<li class="task_parent_msg" style=""><?php echo __("These tasks are waiting on this task.");?></li>
								<li>
									<ul class="task_parent_items" id="task_parent_<%= getdata.Easycase.uniq_id %>" style="">
										<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
									</ul>
								</li>
							</ul>
						</div>
					</span>
					<% } %>
					<% if(getdata.Easycase.depends && getdata.Easycase.depends != ""){ %>
					<span class="fl  task_dependent_block" id="task_dependent_block_<%= getdata.Easycase.uniq_id %>">
						<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
						<div class="dropdown dropup1 fl1 open1 showDependents">
							<ul class="dropdown-menu  bottom_dropdown-caret" style="">
								<li class="pop_arrow_new"></li>
								<li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed.");?></li>
								<li>
									<ul class="task_dependent_items" id="task_dependent_<%= getdata.Easycase.uniq_id %>" style="">
										<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
									</ul>
								</li>
							</ul>
						</div>
					</span>
					<% } %>
			   </span>
		</div>
	</div>
	<% var filesArr = getdata.Easycase.all_files;
		if(typeof filesArr != 'undefined' && filesArr != ''){
	%>
	<div class="kb_det_img">
	<% var fc = 0;
		var imgaes = ""; var caseFileName = "";
		var getFiles = filesArr[0];%>
	<%	caseFileName = getFiles.CaseFile.file;
		caseFileUName = getFiles.CaseFile.upload_name;
		caseFileId = getFiles.CaseFile.id;
		downloadurl = getFiles.CaseFile.downloadurl;
		var d_name = getFiles.CaseFile.display_name;
		if(!d_name){
			d_name = caseFileName;
		}
		if(caseFileUName == null){
			caseFileUName = caseFileName;
		}
		if(getFiles.CaseFile.is_exist) {
		fc++;
		file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file);%>
		<div class="fl atachment_det">
			<div class="aat_file">
				<div class="file_show_dload">
					<a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= d_name %>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
					<a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
				</div>
				<% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
					<% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
						<img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;max-height: 120px;" title="<%= d_name %>" alt="Loading image.." />
					<% }else{ %>
						<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
					<% } %>
				<% } else { %>
					<div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
				<% } %>
				<?php /* <div class="file_cnt ellipsis-view"><%= d_name %></div> */ ?>
			</div>
		</div>
		<div class="fl atachment_det parent_other_holder" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> style="display:none;" <% } %>>
			<div class="aat_file">
				<div class="file_show_dload">
					<% if(downloadurl) { %>
					<a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
					<% } else {%>
					<a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
					<% } %>
				</div>
				<% if(downloadurl) { %>
					<img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
				<% }else{ %>
					<% if(getFiles.CaseFile.is_ImgFileExt){ %>
					<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
					<%  } else{ %>
					<img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
					<% } %>
				<% } %>
				<?php /* <div class="file_cnt ellipsis-view"><%= d_name %></div> */ ?>
			</div>
		</div>
		<% } %>
	</div>
	<div class="cb"></div>
	<% } %>
	<div class="kb_task_status">  
		
	<div class="kb_task_hrs fl">
									<% if(getdata.Easycase.estimated_hours != '0' && getdata.Easycase.estimated_hours != ''){ %>
									<span>
										<?php echo __('Est Hr');?>: <%= format_time_min(getdata.Easycase.estimated_hours) %>
									</span>	
									<% } %>
									<% if(getdata.lt.tot_spent_sec != '0' && getdata.lt.tot_spent_sec != ''){ %>
									<span>
										<?php echo __('Spent Hr');?>: <%= format_time_min(getdata.lt.tot_spent_sec) %>
									</span>
									<% } %>
                </div> 
		<?php /*<div class="fl kb_icons">
			<% var caseFlag=""; 					
			if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
			if(getdata.Easycase.isactive == 1){ 
			if(caseFlag == 2){ %>
				<% if(isAllowed("Change Status of Task",projectUniqid)){ %>	
				<% if(typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined'){ }else{ %>
				<span rel="tooltip" title="<?php echo __('Resolve');?>" onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_resolve fl"><i class="material-icons">&#xE153;</i></span>
				<% } } } }
			if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4 || caseLegend == 5) && caseTypeId != 10) { caseFlag=5; }
			if(getdata.Easycase.isactive == 1){ 
			if(caseFlag == 5) {	%>
			<% if(isAllowed("Change Status of Task",projectUniqid)){ %>				
			<% if(typeof caseDet.customStatusByProject[caseDet.Easycase.project_id] !='undefined'){ %>
				<% if(isAllowed("Status change except Close",projectUniqid)){ %>
				<span rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);" class="case_act_icons task_title_icons_close fl"><i class="material-icons">&#xE876;</i></span>
				<% } %>
			<% }else{ %>
				<% if(isAllowed("Status change except Close",projectUniqid)){ %>
				<span rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_close fl"><i class="material-icons">&#xE876;</i></span>
			<% } %>
			<% } %>
				<% } } } %>					
			<span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"><i class="material-icons">&#xE8B5;</i></span>
			<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
			if(getdata.Easycase.isactive == 1){ %>                    
				<span rel="tooltip" <% if(caseFlag == 7){ %>title="Re-open"<% } else { %>title="Reply"<% } %> data-task="<%= caseUniqId %>" id="bk_act_reply_spn<%= count %>" class="case_act_icons task_title_icons_reply fl" onclick="setSessionStorage(<%= '\'Kanban Task Status\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);"><i class="material-icons">&#xE15E;</i></span>
			<% }
			if( SES_ID == caseUserId) { caseFlag=3; }
			if(getdata.Easycase.isactive == 1){ 
			if(showQuickActiononList){ %>
				<span rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" class="case_act_icons task_title_icons_edit fl"><i class="material-icons">&#xE254;</i></span>
			<% } } %>									           
			<%
			if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId)) { caseFlag = "archive"; }
			if(getdata.Easycase.isactive == 1){ 
			if(caseFlag == "archive"){ %>
				<span rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_archive fl"><i class="material-icons">&#xE149;</i></span>
			<% } }
			if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId)) { caseFlag = "delete"; }
			if(getdata.Easycase.isactive == 1){ 
			if(caseFlag == "delete"){ %>
				<span rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" class="case_act_icons task_title_icons_delete fl"><i class="material-icons">&#xE872;</i></span>
			<% } } %>
		</div> */?>
		<% if(getdata.Easycase.asgnShortName && getdata.Easycase.asgnShortName.search("me") == -1) { %>
		<div class="fr assi_tlist">
			<i class="material-icons">&#xE7FD;</i><%= getdata.Easycase.asgnShortName %>
		</div>
		<% } %>
		<div class="cb"></div>
	</div>
	
	<div class="cb"></div>
	</div>			