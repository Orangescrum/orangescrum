<?php if(defined("RELEASE_V") && RELEASE_V){ ?>
<% (typeof GrpBy != 'undefined')?GrpBy:''; 
var check_ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS') != 'undefined' ?JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS')) :[];
%>
<% if(GrpBy != 'milestone'){ %>
<div class="task_listing">
            <?php if(PAGE_NAME=='dashboard'){ ?>
                <div id="widgethideshow" class="fl task-list-progress-bar fix-status-widget" <?php if(strtotime("+2 months",strtotime(CMP_CREATED))>=time()){?><?php }?>>
                    <span id="task_count_of" style="float:left;display:block;"></span>
					<span id="task_view_types" style="float:right;display:block;margin-top:-4px">					
					<ul class="new_icon_on_list_top">
						<li>
							<a class="" href="<?php echo HTTP_ROOT; ?>dashboard#calendar" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'Calendar View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);return calendarView(<%= '\'calendar\'' %>);">
								<span title="Calendar" rel="tooltip"><i class="material-icons">&#xE916;</i></span>
							</a>
						</li>
						<?php
						$kanbanurl = "";
						$kanbanurl = DEFAULT_KANBANVIEW == "kanban" ? "kanban" : "milestonelist";
						?>
						<li>
							<a class="" href="<?php echo HTTP_ROOT; ?>dashboard#<?php echo $kanbanurl; ?>" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'kanban View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);return checkHashLoad(<%= '\'<?php echo $kanbanurl; ?>\'' %>);">
								<span id="kbview_btn" class="" title="Kanban" rel="tooltip">
								<i class="material-icons">&#xE8F0;</i>
								</span>
							</a>
						</li>
						<% if(GrpBy != 'milestone'){ %>
						<li><a class="" href="javascript:void(0);" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'Task Group View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);groupby(<%= '\'milestone\'' %>, event,1);">
								<span title="Task Group" rel="tooltip"><i class="material-icons">&#xE065;</i></span>
							</a>
						</li>
						<% } %>
						<% if(GrpBy == 'milestone'){ %>
						<li>
							<a class="" href="<?php echo HTTP_ROOT; ?><%= '\'dashboard#tasks\'' %>" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'List View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);checkHashLoad(<%= '\'tasks\'' %>);">
								<span title="List" rel="tooltip"><i class="material-icons">&#xE896;</i></span>
							</a>
						</li>
						<% } %>
						<li>
							<a class="" href="javascript:noid(0);" onclick="reloadTasks();">
								<span title="Reload" rel="tooltip"><i class="material-icons">&#xE5D5;</i></span>
							</a>
						</li>
					</ul>					
					</span>
					<span id="ajaxCaseStatus" style="float:right;"></span>
                    <div class="cb"></div>					
                </div>
			<?php } ?>
					<div class="task-m-overflow">
            <table class="table table-striped table-hover">
              <thead>
                      <tr>
                        <th class="porl checkbox_th">
							<div class="pr">
                                <div class="checkbox">
                                  <label>
                                        <input type="checkbox" value="" class="chkAllTsk" id="chkAllTsk">
                                  </label>
                                </div>
								<div class="drop_th_ttl">
                                <span class="dropdown custom_th_drdown">
                                        <a class="dropdown-toggle mass_action_dpdwn" data-toggle="" href="javascript:void(0);">
                                          <!--<i title="Choose at least one task" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>-->
                                        </a>
                                        <ul class="dropdown-menu" id="dropdown_menu_chk">
                                          <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseNew\'' %>)"><i class="material-icons">&#xE166;</i>New</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseStart\'' %>)"><i class="material-icons">&#xE039;</i>Start</a>
                                            </li>
                                        <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseResolve\'' %>)"><i class="material-icons">&#xE889;</i>Resolve</a>
                                        </li>
                                        <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i>Close</a>
                                        </li>										
                                        <?php if(SES_TYPE == 1 || SES_TYPE == 2) {?>
                                        <li>
                                                <a href="javascript:void(0);" onclick="archiveCase(<%= '\'all\'' %>)"><i class="material-icons">&#xE149;</i>Archive</a>
                                        </li>
										<li>
                                                <a href="javascript:void(0);" onclick="ajaxassignAllTaskToUser(<%= '\'movetop\'' %>);"><i class="material-icons">&#xE7FD;</i>Assign task(s) to user</a>
                                        </li>
                                        <li id="mvTaskToProj">
                                                <a href="javascript:void(0);" onclick="mvtoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8D4;</i>Move to project</a>
                                        </li>
                                        <li id="cpTaskToProj">							
                                                <a href="javascript:void(0);" onclick="cptoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE14D;</i>Copy to Project</a>
                                        </li>
                                        <li id="crtProjTmpl">							
                                                <a href="javascript:void(0);" onclick="createPojectTemplate(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8F1;</i>Create Project Plan</a>
                                        </li>
                                        <?php } ?>
                                        </ul>
                                </span>
                                    </div>
                            </div>
                        </th>
                        <th> 
                             <% 
                            if(typeof csNum != undefined && csNum != "") {
                                    orderType = "'"+csNum+"'";
                               
                            }else{
                                orderType = 'desc'
                            }
                            %>
                            <a href="javascript:void(0);" title="Task#" onclick="inactiveAjaxSorting(<%= '\'caseno\', ' + caseCount + ', this,' +orderType%>);" class="sortcaseno">
                                #<span class="sorting_arw"><% if(typeof csNum != 'undefined' && csNum != "") { %>
                                        <% if(csNum == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>								
                            </a>
                        </th>
                        <th>
                             <% 
                            if(typeof csTtl != 'undefined' && csTtl != ""){
                                    orderTtl = "'"+csTtl+"'";
                               
                            }else{
                                orderTtl = 'desc';
                            }
                            %>
                            <% if(GrpBy != 'milestone'){ %>
                            <a class="sorttitle" href="javascript:void(0);" title="Title" onclick="inactiveAjaxSorting(<%= '\'title\', ' + caseCount + ', this,'+orderTtl %>);">
                                Title<span class="sorting_arw"><% if(typeof csTtl != 'undefined' && csTtl != "") { %>
                                        <% if(csTtl == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                            <% }else{ %>
                                Title
                            <% } %>
                        </th>
                        <th></th>
                        <th class="width_assign">
                             <% 
                            if(typeof csAtSrt != 'undefined' && csAtSrt != ""){
                                    orderAtSrt = "'"+csAtSrt+"'";
                               
                            }else{
                                orderAtSrt = 'desc';
                            }
                            %>
                            <% if(1 || GrpBy != 'milestone'){ %>
                            <a class="sortcaseAt" href="javascript:void(0);" title="Assigned to" onclick="inactiveAjaxSorting(<%= '\'caseAt\', ' + caseCount + ', this,'+orderAtSrt %>);">
                                Assigned to
                                <span class="sorting_arw"><% if(typeof csAtSrt != 'undefined' && csAtSrt != "") { %>
                                        <% if(csAtSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                            <% }else{ %>
                                <div class="fl">Assigned to</div>
                            <% } %>
                        </th>
                        <% 
                            if(typeof csPriSrt != 'undefined' && csPriSrt != ""){
                                    orderPriSrt = "'"+csPriSrt+"'";
                               
                            }else{
                                orderPriSrt = "'desc'";
                            }
                            %>
						<th class="width_priority text-center">
                            <a class="sortprioroty" href="javascript:void(0);" title="Priority" onclick="inactiveAjaxSorting(<%= '\'priority\', ' + caseCount + ', this,'+orderPriSrt %>);">
                                Priority
                                <span class="sorting_arw"><% if(typeof csPriSrt != 'undefined' && csPriSrt != "") { %>
                                        <% if(csPriSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                         <% 
                            if(typeof csUpdatSrt != 'undefined' && csUpdatSrt != ""){
                                    orderUpdatSrt = "'"+csUpdatSrt+"'";
                               
                            }else{
                                orderUpdatSrt = "'desc'";
                            }
                            %>
						<th class="width_update text-center">
                            <a class="sortupdated" href="javascript:void(0);" title="Updated" onclick="inactiveAjaxSorting(<%= '\'updated\', ' + caseCount + ', this,'+orderUpdatSrt %>);">
                                Updated<span class="sorting_arw"><% if(typeof csUpdatSrt != 'undefined' && csUpdatSrt != "") { %>
                                            <% if(csUpdatSrt == 'asc'){ %>
                                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                                            <% }else{ %>
                                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                                            <% } %>								
                                    <% }else{ %>
                                            <i class="material-icons">&#xE164;</i>
                                    <% } %></span>
                            </a>
                        </th>
                        <th class="width_status text-center">
                                Status
                        </th>
                        <% 
                            if(typeof csDuDt != 'undefined' && csDuDt != ""){
                                    orderDuDt = "'"+csDuDt+"'";
                               
                            }else{
                                orderDuDt = "'desc'";
                            }
                            %>
                        <th class="tsk_due_dt">
                            <a class="sortduedate" href="javascript:void(0);" title="Due Date" onclick="inactiveAjaxSorting(<%= '\'duedate\', ' + caseCount + ', this,'+orderDuDt %>);">
                                Due Date
                                <span class="sorting_arw"><% if(typeof csDuDt != 'undefined' && csDuDt != "") { %>
                                        <% if(csDuDt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                      </tr>
              </thead>
              <tbody>                   
                    <tr class="quicktsk_tr">
                    <td colspan="3">
                    <div class="form-group label-floating">
                      <div class="input-group">
                            <label class="control-label" for="addon3a">Task Title</label>
                            <input class="form-control" type="text" id="inline_qktask" onblur="blurqktask();">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-fab btn-fab-mini quick-send-icon" onclick="setSessionStorage(<%= '\'Task List Quick Task\'' %>, <%= '\'Create Task\'' %>); AddQuickTask(); trackEventWithIntercom(<%= '\'quick task\'' %>,<%= '\'\'' %>);" title="Post Task">
                                    <i class="material-icons qk_send_icon">send</i>
                              </button>
                            </span>
                      </div>
                    </div>
                    </td>
                        <td colspan="5"></td>
                    </tr>
    <%
    var count = 0;
    var totids = "";
    var openId = "";
    var groupby = GrpBy;
    var prvGrpvalue='';
    var pgCaseCnt = caseAll?countJS(caseAll):0;
    if(caseCount && caseCount != 0){
	var count=0;
	var caseNo = "";
	var chkMstone = "";
	var caseLegend = "";
	var totids = "";
	var projectName ='';var projectUniqid='';
	for(var caseKey in caseAll){
		var getdata = caseAll[caseKey];
		if(groupby=='milestone' && getdata.Easycase && getdata.EasycaseMilestone.mid == null){
			getdata.EasycaseMilestone.mid = 'NA';
		}
		count++;
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
		var isactive = getdata.Easycase.isactive;
		var caseAssgnUid = getdata.Easycase.assign_to;
		var getTotRep = 0;
		if(getdata.Easycase.thread_count && getdata.Easycase.thread_count!=0) {		
			getTotRep = getdata.Easycase.thread_count;
		}

		if(caseUrl == caseUniqId) {
			openId = count;
		}
		if(caseLegend==2 || caseLegend==4){
			var headerlegend = 2;
		}else{
			var headerlegend = caseLegend;
		}
		var chkDat = 0;
		var showQuickActiononList = 0;
		/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
			var showQuickActiononList = 1;
		}*/
        if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
            showQuickActiononList = 1;
		}

		if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}else if(projUniq!='all'){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}
		if(projUniq=='all' && groupby !='milestone') { %>
		<tr class="list-dt-row">
			<td colspan="9" align="left" class="curr_day tkt_pjname">
				<div class="<% if(count!=1) {%>y_day<% } %>"><span><%= getdata.Easycase.pjname %></span></div>
			</td>
		</tr>
		<% }
		if(getdata.Easycase.newActuldt && getdata.Easycase.newActuldt!=0) {
	%>
    <tr class="list-dt-row">
        <td colspan="9" align="left" class="curr_day">
			<div class="dt_cmn_mc <% if(count!=1 && !getdata.Easycase.pjname) {%>y_day<% } %>"> <span><%= getdata.Easycase.newActuldt %></span>
			</div>
		</td>
    </tr>
    <%	} %>
	<%
	if(typeof getdata.EasycaseMilestone != 'undefined'){
		if(getdata.EasycaseMilestone.mid == null){
			var mid = 'NA';
		}else{
			var mid = getdata.EasycaseMilestone.mid;
		}
	}
	%>
	<% var bgcol = "#F2F2F2";
		if(chkDat == 1) { bgcol = "#FFF"; }
		var borderBottom = "";
		if(pgCaseCnt == count) { borderBottom = "border-bottom:1px solid #F2F2F2;"; } %>
	<% if(isactive==0) {%>
    <tr class="row_tr tr_all trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
	<% }else {%>
    <tr class="row_tr tr_all trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
	<% } %>		
	<td <% if(groupby =='' || groupby !='priority'){%>class="check_list_task tsk_fst_td pr_<%= easycase.getPriority(casePriority) %>"<% } %>>
		<!-- <div class="checkbox">
		  <label>
			<% if(caseLegend != 3 && caseTypeId != 10) { %>
			<input type="checkbox" style="cursor:pointer" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|' + caseUniqId %>" class="fl mglt chkOneTsk">
			<% } else if(caseTypeId != 10) { %>
			<input type="checkbox" id="actionChk<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
			<% } else { %>
			<input type="checkbox" id="actionChk<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|update' %>" disabled="disabled" class="fl mglt chkOneTsk">
			<% } %>
		  </label>
		</div> -->
        <%= caseNo %>
		<input type="hidden" id="actionCls<%= count %>" value="<%= caseLegend %>" disabled="disabled" size="2"/>			
	</td>
	<td class="text-center count-plist-drop pr">
        <span class="ttype_global tt_<%= getttformats(getdata.Easycase.csTdTyp[1])%>" style="top:2px;"></span>
         <span id="caseProjectSpanFav<%=caseAutoId %>" style="position:relative;top:1px;margin-left: 20px">
           <% if(getdata.Easycase.isFavourite) { %>
                <i class="material-icons" style="font-size:18px;">star</i>
            <% }else{ %>
                 <i class="material-icons" style="font-size:18px;">star_border</i>
            <% } %>
            </span>
	</td>	
	<td class="relative list-cont-td">
		<a href="javascript:void(0);" class="ttl_listing">
			<span id="inactivetitlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>"> 
				<span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
					<%= formatText(ucfirst(caseTitle)) %>
				</span>
			</span>
		</a>
            <div class="task_dependancy fr">
                    <% if(getdata.Easycase.children && getdata.Easycase.children != ""){ %>
                        <span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId %>">
                            <div rel="" title="Parents" onclick="showParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
                            <div class="dropdown dropup fl1 open1 showParents">
                                <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                    <li class="pop_arrow_new"></li>
                                    <li class="task_parent_msg" style="">These tasks are waiting on this task.</li>
                                    <li>
                                        <ul class="task_parent_items" id="task_parent_<%= caseUniqId %>" style="">
                                            <li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </span>
                    <% } %>
                    <% if(getdata.Easycase.depends && getdata.Easycase.depends != ""){ %>
                        <span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId %>">
                            <div rel="" title="Dependents" onclick="showDependents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
                            <div class="dropdown dropup fl1 open1 showDependents">
                                <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                    <li class="pop_arrow_new"></li>
                                    <li class="task_dependent_msg" style="">Task can't start. Waiting on these task to be completed.</li>
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
		<div class="list-td-hover-cont">
		<span class="created-txt"><% if(getTotRep && getTotRep!=0) { %>Updated<% } else { %>Created<% } %> by <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %>on<% } %> <%= getdata.Easycase.updtedCapDt %></span>
		<span class="list-devlop-txt">
			<a href="javascript:void(0)">
				<i class="material-icons tag_fl">&#xE54E;</i>
				<span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>clsptr<% } %>" title="<%= getdata.Easycase.csTdTyp[1] %>" >
					<span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= getdata.Easycase.csTdTyp[1]%><span class="due_dt_icn"></span></span>
				</span>
			</a>				
			<span id="typlod<%= caseAutoId %>" class="type_loader">
				<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..."/>
			</span>				
		</span>
		
            <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="Recurring Task" href="javascript:void(0);" class="recurring-icon" onclick="showRecurringInfo(<%= getdata.Easycase.id %>);"><i class="material-icons">&#xE040;</i></a>
            <% } %>
	</div>
</td>
<td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %> id="<%= count %>" <% } %> style="cursor:pointer; vertical-align:top" >
	<a href="javascript:void(0);" <% if(getdata.Easycase.format != 1 && getdata.Easycase.format != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
		<i class="glyphicon glyphicon-paperclip"></i>
	</a>
	<% if(getTotRep && getTotRep!=0) { %><%= getTotRep %><% } %>
	<a href="javascript:void(0)" id="<%= count %>" style="<% if(!getTotRep || getTotRep==0) { %>display:none<% } %>">
		<i class="material-icons">&#xE0B9;</i>
	</a>
</td>
<% if(isactive==0){ %>
<td></td>
<% } else { %>
<td class="assi_tlist">
	<i class="material-icons">&#xE7FD;</i>			
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="showUpdAssign<%= caseAutoId %>" data-toggle="dropdown" title="<%= getdata.Easycase.asgnName %>" class="clsptr" onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)"><%= getdata.Easycase.asgnShortName %><span class="due_dt_icn"></span></span>
	<% } else { %>
	<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= getdata.Easycase.asgnShortName %></span>
	<% } %>
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..."/>
	</span>
	<% } %>			
</td>
<% } %>
<td  class="text-center <% if(getdata.Easycase.csTdTyp[1] != 'Update'){ %>task_priority csm-pad-prior-td<% }else{ %>csm-pad12-prior-td<% } %>">
    <% var csLgndRep = getdata.Easycase.legend; %>
    <% if(getdata.Easycase.csTdTyp[1] == 'Update'){ %>
        <span class="prio_high prio_lmh prio_gen" rel="tooltip" title="Priority:high"></span>
    <% }else{ %>
    <div style="" id="pridiv<%= caseAutoId %>" data-priority ="<%= casePriority %>" class="pri_actions <% if(showQuickActiononList){ %> dropdown<% } %>">    
        <div class="dropdown cmn_h_det_arrow lmh-width">
        <div <% if(showQuickActiononList){ %> class="quick_action" data-toggle="dropdown" <% } %> style="cursor:pointer"><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="Priority:<%= easycase.getPriority(casePriority) %>"></span>
            <!--<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>-->
        </div>
        <% var csLgndRep = getdata.Easycase.legend; %>
        </div>
    </div>
    <span id="prilod<%= caseAutoId %>" style="display:none">
            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..."/>
    </span>
    <% } %>
</td>
<td class="text-center" title="<% if(getTotRep && getTotRep!=0) { %>updated<% } else { %>created<% } %> by <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %>on<% } %> <%= getdata.Easycase.updtedCapDt %> <%= getdata.Easycase.fbstyle %>."><%= getdata.Easycase.fbstyle %></td>
<td>
<span id="csStsRep<%= count %>" class="">
<% if(isactive==0){ %>
	<div class="label new" style="background-color: olive">Archived</div>
<%}else if(groupby =='' || groupby !='status'){%>
	<%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
<% } %>
</span>
</td>

<td class="due_dt_tlist">
	<div class="<% if(getdata.Easycase.csDueDate == '' || getdata.Easycase.legend == 5 || getdata.Easycase.type_id == 10 || getdata.Easycase.legend == 3){ %> <% } %>">
	<% if(getdata.Easycase.isactive == 1){ %>
	<% if(showQuickActiononList && caseTypeId != 10){ %>
	<span class="" <% if(showQuickActiononList){ %>title="Edit Due Date"<% } %>></span>
	<% } %>
	<span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= getdata.Easycase.csDuDtFmtT %>">
		<%= getdata.Easycase.csDuDtFmt1!=''? getdata.Easycase.csDuDtFmt1:'NA' %>
        

	</span>
	<span id="datelod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..."/>
	</span>
	<% } %>
	</div>
	<div class="overdueby_spn overdueby_spn_<%= caseAutoId %>"><%= getdata.Easycase.csDuDtFmtBy %></div>
</td>
</tr>
<%
		totids += caseAutoId + "|";
	}
    }
    if(!caseCount || caseCount==0){
    var case_type = $("#caseMenuFilters").val(); %>
    <tr class="empty_task_tr">
        <td colspan="10" align="center">

            <% if(case_type == 'cases' || case_type == ''){
				if(filterenabled){%>
					No Tasks
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'')); ?>
            <% } %>
            <% }else if(case_type == 'assigntome'){
				if(filterenabled){ %>
					No tasks for me
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'assigntome')); ?>
            <% } %>
            <% }else if(case_type == 'overdue'){
				if(filterenabled){ %>
					No tasks as overdue
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'overdue')); ?>
            <% } %>
            <% }else if(case_type == 'delegateto'){
				if(filterenabled){ %>
					No tasks delegated
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'delegateto')); ?>
            <% } %>
            <% }else if(case_type == 'highpriority'){
				if(filterenabled){ %>
					No high priority tasks
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'highpriority')); ?>
            <% } %>
            <% } %>
        </td>
    </tr>
    <% } %>
    </tbody>
    </table>
	</div>
    <% $("#inactive_task_paginate").html('');
    if(caseCount && caseCount!=0) {
            var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
            $("#inactive_task_paginate").html(tmpl("inactive_paginate_tmpl", pageVars));
    } %>

	<div class="crt_task_btn_btm">
         <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
        <div class="os_plus">
			<div class="ctask_ttip">
				<span class="label label-default"><?php echo __('Create Task');?></span>
			</div>
 			<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task List Page Big Plus\'' %>, <%= '\'Create Task\'' %>);creatask();"> 
				<img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
				<img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
			</a>
        </div>
    <?php } ?>
	</div>
</div>

<% } else if(GrpBy == 'milestone'){ %>

<div class="task_listing task-grouping-page">
        <div class="task-m-overflow">
            <table class="table table-striped table-hover compactview_tbl">
              <thead>
                      <tr>
                        <th class="porl checkbox_th">
							<div class="pr">
                                <div class="checkbox">
                                  <label>
                                        <input type="checkbox" value="" class="chkAllTsk" id="chkAllTsk">
                                  </label>
                                </div>
								<div class="drop_th_ttl">								
                                <span class="dropdown custom_th_drdown">
                                        <a class="dropdown-toggle mass_action_dpdwn" data-toggle="" href="javascript:void(0);">
                                          <!--<i title="Choose at least one task" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>-->
                                        </a>
                                        <ul class="dropdown-menu" id="dropdown_menu_chk">
                                          <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseNew\'' %>)"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseStart\'' %>)"><i class="material-icons">&#xE039;</i><?php echo __('Start');?></a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseResolve\'' %>)"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i><?php echo __('Close');?></a>
                                            </li>
                                            <?php if(SES_TYPE == 1 || SES_TYPE == 2) {?>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="archiveCase(<%= '\'all\'' %>)"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                            </li>
											<li>
                                                <a href="javascript:void(0);" onclick="ajaxassignAllTaskToUser(<%= '\'movetop\'' %>);"><i class="material-icons">&#xE7FD;</i><?php echo __('Assign task(s) to user');?></a>
											</li>
                                            <li id="mvTaskToProj">
                                                <a href="javascript:void(0);" onclick="mvtoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to project');?></a>
                                            </li>
                                            <li id="cpTaskToProj">							
                                                <a href="javascript:void(0);" onclick="cptoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE14D;</i><?php echo __('Copy to Project');?></a>
                                            </li>
                                            <li id="crtProjTmpl">							
                                                    <a href="javascript:void(0);" onclick="createPojectTemplate(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8F1;</i><?php echo __('Create Project Plan');?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                </span>
                        </div>
							</div>
                        </th>
                        <th>   <% 
                            if(typeof csNum != undefined && csNum != "") {
                                    orderType = "'"+csNum+"'";
                               
                            }else{
                                orderType = 'desc'
                            }
                            %>
                            <a href="javascript:void(0);" title="<?php echo __('Task');?>#" onclick="inactiveAjaxSorting(<%= '\'caseno\', ' + caseCount + ', this,'+orderType %>);" class="sortcaseno">
                                #<span class="sorting_arw"><% if(typeof csNum != 'undefined' && csNum != "") { %>
                                        <% if(csNum == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>								
                            </a>
                        </th>
                        <th colspan="2">
                            <% 
                            if(typeof csTtl != 'undefined' && csTtl != ""){
                                    orderTtl = "'"+csTtl+"'";
                               
                            }else{
                                orderTtl = 'desc';
                            }
                            %>
                            <a class="sorttitle" href="javascript:void(0);" title=" <?php echo __('Title');?>" onclick="inactiveAjaxSorting(<%= '\'title\', ' + caseCount + ', this,'+orderTtl %>);">
                                 <?php echo __('Title');?><span class="sorting_arw"><% if(typeof csTtl != 'undefined' && csTtl != "") { %>
                                        <% if(csTtl == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                        <th class="width_assign">
                            <% 
                            if(typeof csAtSrt != 'undefined' && csAtSrt != ""){
                                    orderAtSrt = "'"+csAtSrt+"'";
                               
                            }else{
                                orderAtSrt = 'desc';
                            }
                            %>
                            <% if(1 || GrpBy != 'milestone'){ %>
                            <a class="sortcaseAt" href="javascript:void(0);" title="<?php echo __('Assigned to');?>" onclick="inactiveAjaxSorting(<%= '\'caseAt\', ' + caseCount + ', this,'+orderAtSrt %>);">
                                Assigned to
                                <span class="sorting_arw"><% if(typeof csAtSrt != 'undefined' && csAtSrt != "") { %>
                                        <% if(csAtSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                            <% }else{ %>
                                <div class="fl"><?php echo __('Assigned to');?></div>
                            <% } %>
                        </th>
                        <% 
                            if(typeof csPriSrt != 'undefined' && csPriSrt != ""){
                                    orderPriSrt = "'"+csPriSrt+"'";
                               
                            }else{
                                orderPriSrt = "'desc'";
                            }
                            %>
                        <th class="width_priority text-center">
                            <a class="sortprioroty" href="javascript:void(0);" title="<?php echo __('Priority');?>" onclick="inactiveAjaxSorting(<%= '\'priority\', ' + caseCount + ', this,'+orderPriSrt %>);">
                                <?php echo __('Priority');?>
                                <span class="sorting_arw"><% if(typeof csPriSrt != 'undefined' && csPriSrt != "") { %>
                                        <% if(csPriSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                         <% 
                            if(typeof csUpdatSrt != 'undefined' && csUpdatSrt != ""){
                                    orderUpdatSrt = "'"+csUpdatSrt+"'";
                               
                            }else{
                                orderUpdatSrt = "'desc'";
                            }
                            %>
						<th class="width_update text-center">
                            <a class="sortupdated" href="javascript:void(0);" title="<?php echo __('Updated');?>" onclick="inactiveAjaxSorting(<%= '\'updated\', ' + caseCount + ', this,'+orderUpdatSrt %>);">
                                <?php echo __('Updated');?><span class="sorting_arw"><% if(typeof csUpdatSrt != 'undefined' && csUpdatSrt != "") { %>
                                        <% if(csUpdatSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                        <th class="width_status">
                                 <?php echo __('Status');?>
                        </th>	
                        <% 
                            if(typeof csDuDt != 'undefined' && csDuDt != ""){
                                    ordercsDuDt = "'"+csDuDt+"'";
                               
                            }else{
                                ordercsDuDt = "'desc'";
                            }
                            %>
                        <th class="tsk_due_dt">
                            
                            <a class="sortduedate" href="javascript:void(0);" title="<?php echo __('Due Date');?>" onclick="inactiveAjaxSorting(<%= '\'duedate\', ' + caseCount + ', this,'+ordercsDuDt %>);">
                                <?php echo __('Due Date');?>
                                <span class="sorting_arw"><% if(typeof csDuDt != 'undefined' && csDuDt != "") { %>
                                        <% if(csDuDt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %></span>
                            </a>
                        </th>
                      </tr>
              </thead>
              <tbody> 
                    <tr class="quicktskgrp_tr">
                    <td colspan="3">
                    <div class="form-group label-floating">
                      <div class="input-group">
                            <label class="control-label" for="inline_milestone"><?php echo __('Task Group Title');?></label>
                            <input class="form-control" type="text" id="inline_milestone" >
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-fab btn-fab-mini" onclick="setSessionStorage(<%= '\'Quick Task Group Page\'' %>, <%= '\'Create Task Group\'' %>);AddNewMilestone();trackEventWithIntercom(<%= '\'Task Group\'' %>,<%= '\'\'' %>);" title="<?php echo __('Post Task');?>">
                                    <i class="material-icons qk_send_icon_mi">send</i>
                              </button>
                            </span>
                      </div>
                    </div>
                    </td>
                            <td colspan="6"></td>
                    </tr>
              </tbody>
			<% if(GrpBy == 'milestone'){ %> 
				<% var mki = 0; var chk_milsto_pj_name = '';  
                              if((caseMenuFilters =='' || caseMenuFilters=='cases') &&
                                (case_date =='') &&
                                (caseStatus =='' || caseStatus =='all') &&
                                (priorityFil =='' || priorityFil =='all') &&
                                (caseTypes =='' || caseTypes =='all') &&
                                (caseUserId =='' || caseUserId =='all') &&
                                (caseAssignTo =='' || caseAssignTo =='all') &&
                                (case_duedate =='') &&
                                (typeof getCookie('TASKGROUP_FIL')=='undefined' || getCookie('TASKGROUP_FIL')=='all') &&
                                (caseSrch =='')
                              ){
                               for(var mkey in all_milesto_names){ mki++; %>
					  <% if(!milesto_names[mkey] && csPage == 1){ %>					  
                                         <tbody>
					 <tr class="tgrp_tr_all task_group_accd" id="empty_milestone_tr<%= all_milesto_names[mkey]['id'] %>" data-pid="<%= all_milesto_names[mkey]['project_id']%>">
						<td colspan="10" class="pr">
                                                <div class="fl os_sprite dot-bar-group"></div>  
                                               <% accordianClass='plus-minus';
                                               for(i=0;i < check_ids_array.length;i++){
                                                if(check_ids_array[i]== all_milesto_names[mkey]['id']){
                                                accordianClass="minus-plus hideSub";                                               
                                                }
                                                }%>
						<div class="plus-minus-accordian">
							<!--<div class="fl"><span class="os_sprite <%= accordianClass %> os_sprite<%= all_milesto_names[mkey]['id'] %>" onclick="collapse_taskgroup(this);"></span></div>-->
							<div class="fl">
									<span class="dropdown n_tsk_grp" id="n_tsk_grp_<%= all_milesto_names[mkey]['id'] %>">
								<a class="dropdown-toggle  main_page_menu_togl active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
								<span class="dropdown n_tsk_grp" id="n_tsk_grp_<%= all_milesto_names[mkey]['id'] %>">
								<a class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
								  <i class="material-icons">&#xE5D4;</i>
								</a>
								<ul class="dropdown-menu sett_dropdown-caret aede-drop-text">			  
								  <li class="pop_arrow_new" style="left:126px"></li>
									<% if(all_milesto_names[mkey]['isactive']!=0){ %>
									<li onClick="addTaskToMilestone(<%= '\'\',\''+ all_milesto_names[mkey]['id'] + '\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>,0,1)">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
										</a>
									</li>							
                                                                        <li onClick="convertToTask(this, <%= '\''+ all_milesto_names[mkey]['id'] + '\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>,0,1)">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE15A;</i><?php echo __('Convert to Task');?>
										</a>
									</li>	
									<li class="makeHover" onclick="addEditMilestone(0,<%= '\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]["id"] %>,<%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>,1,<%= '\'taskgroup\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>)">
										<a href="javascript:void(0)" class="mnsm">
											<i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
										</a>
									</li>
									<% } %>
									<li class="makeHover" onclick="delMilestone(0,<%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>, <%= '\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]["id"] %>);">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE872;</i><?php echo __('Delete');?> 
										</a>                                          
									</li>
									<% if(all_milesto_names[mkey]['isactive']!=0){ %>
									<li onclick="milestoneArchive(<%= '\'\',\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>, <%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>,1);">
										<a href="javascript:jsVoid();" class="mnsm">
											<i class="material-icons">&#xE86C;</i><?php echo __('Complete');?>
										</a>
									</li>
									<% }else{ %>
									<li onclick="milestoneRestore(<%= '\'\',\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>, <%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>,1);">
										<a href="javascript:jsVoid();" class="mnsm">
											<i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?>
										</a>
									</li>
									<% } %>
								</ul>
							</span>
							</div>
							<div class="fl accord_cnt_txt">
								<div class="empty_milstone_holder top_ms">
									<div class="__a" onclick="collapse_by_title('<%= all_milesto_names[mkey]['id'] %>',<%= all_milesto_names[mkey]["project_id"] %>);">
									<a id="miview_<%= all_milesto_names[mkey]['id'] %>" href="javascript:void(0);" title="<%= all_milesto_names[mkey]['title'] %>" <% if(all_milesto_names[mkey]['isactive'] != 1){ %> class="taskCompleted"<% } %>>
									  <%= all_milesto_names[mkey]['title'] %> 
									</a>
									<div class="form-group label-floating pr edit_task_group" id="miviewtxtdv_<%= all_milesto_names[mkey]['id'] %>" style="display:none;">
									  <label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
									  <input style="display:none;" class="form-control mviewtxt" type="text" id="miviewtxt_<%= all_milesto_names[mkey]['id'] %>" onkeyup="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,0);" onblur="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,1);" />
									  <span class="input-group-btn">
										  <button onclick="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,1);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="<?php echo __('Save');?>">
											<i class="material-icons">send</i>
										  </button>
										</span>
									</div>   
                                                                            <p class="n_cnt_grpt_<%= all_milesto_names[mkey]['id'] %> <% if(all_milesto_names[mkey]['isactive'] != 1){ %>taskCompleted<% } %>">(<span id="miviewspan_<%= all_milesto_names[mkey]['id'] %>">0</span>)</p>
								</div>
								</div>
							</div>
                                                       <div class="fl taskgroup-pencil <% if(all_milesto_names[mkey]['id'] > 0){ %> <%='showEditTaskgroup'+ all_milesto_names[mkey]['id'] %> <% }else{ %> <%='showEditTaskgroupdefault' %><% } %>" 
                                                            <% if(all_milesto_names[mkey]['id'] > 0){ %>
                                                                onclick="showhideinlinedit( <%= all_milesto_names[mkey]['id'] %> );"
                                                                <% }else{ %>
                                                                onclick="showhideinlinedit(<%= '\'default\'' %>);"
                                                                <% } %>
                                                                >

                                                              <a href="javascript:void(0);" title="Edit"><i class="material-icons">&#xE254;</i></a>
                                                    </div>
							<div class="cb"></div>
						</div>
						</td>
						</tr>
                                                <% var d_mid_empty = all_milesto_names[mkey]['id']; if(d_mid_empty == 'NA'){ d_mid_empty = 0;} %>
                                                    <% if(d_mid_empty == 0 || (d_mid_empty != 0 && all_milesto_names[mkey]['isactive'] == 1)){ %>
                                                  <% } %>
                                                    <tr class="empty_task_tr"><td></td><td colspan="10" align="center" class="textRed"><?php echo __('No Tasks found');?></td></tr>
                                         </tbody>
				   <% } %>
			   <% } %>
                         <% } %>

	<% } %>
    <%
    var count = 0;
    var totids = "";
    var openId = "";
    var groupby = GrpBy;
    var prvGrpvalue='';
    var pgCaseCnt = caseAll?countJS(caseAll):0;
    if(caseCount && caseCount != 0){
	var count=0;
	var caseNo = "";
	var chkMstone = "";
	var caseLegend = "";
	var totids = "";
	var projectName ='';var projectUniqid='';
        var countMile = [];
	for(var caseKey in caseAll){
		var getdata = caseAll[caseKey];
		if(groupby=='milestone' && getdata.Easycase && getdata.EasycaseMilestone.mid == null){
			getdata.EasycaseMilestone.mid = 'NA';
		}
		count++;
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
		var isactive = getdata.Easycase.isactive;
		var caseAssgnUid = getdata.Easycase.assign_to;
		var getTotRep = 0;
		if(getdata.Easycase.case_count && getdata.Easycase.case_count!=0) {		
			getTotRep = getdata.Easycase.case_count;
		}

		if(caseUrl == caseUniqId) {
			openId = count;
		}
		if(caseLegend==2 || caseLegend==4){
			var headerlegend = 2;
		}else{
			var headerlegend = caseLegend;
		}
		var chkDat = 0;
		var milestone_proj_name_default = '';
		var showQuickActiononList = 0;
		/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
			var showQuickActiononList = 1;
		}*/
                if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
                    showQuickActiononList = 1;
		}

		if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}else if(projUniq!='all'){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}
        var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
	%>
	
	<% if(groupby && groupby!='date'){
			if(groupby=='milestone' && (getdata.EasycaseMilestone.mid != prvGrpvalue)){ 
                        var tcount=0;
                        %>  
                        </tbody><tbody>
				<tr class="task_group_accd" id="empty_milestone_tr<%= getdata.EasycaseMilestone.mid %>">
				<% if(getdata.EasycaseMilestone.mid == 'NA'){ %>
				<td colspan="10" class="pr">
                                     <% var accordianClass='plus-minus';
                                        for(i=0;i < check_ids_array.length;i++){
                                         if(check_ids_array[i]== getdata.EasycaseMilestone.mid){
                                         accordianClass="minus-plus hideSub";
                                         }
                                         }
                                         %>
                                         
          <div class="fl os_sprite dot-bar-group"></div>
            <div class="plus-minus-accordian">
                <div class="fl accord_cnt_txt">
                        <div class="empty_milstone_holder tsk_ttl pr">
                                <div class="fl __hold" onclick="collapse_by_title('<%= getdata.EasycaseMilestone.mid %>',<%= projId %>);" style="font-weight:normal">
                                        <a class="miview_a" id="miview_default" href="javascript:void(0);">
                                                <?php echo __('Default Task Group');?>
                                        </a>
                                        <div class="form-group label-floating edit_task_group pr" id="miviewtxtdv_default" style="display:none;">
                                        <label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
                                        <input style="display:none;" class="mviewtxt form-control" type="text" id="miviewtxt_default" onkeyup="inlineEditMilestone(event,<%= '\'default\'' %>,0);" onblur="inlineEditMilestone(event,<%= '\'default\'' %>,1);" />
                                        <span class="input-group-btn">
                                                <button onclick="inlineEditMilestone(event,<%= '\'default\'' %>,0);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="<?php echo __('Save');?>">
                                                <i class="material-icons">send</i>
                                                </button>
                                        </span>
                                </div>
                                    <p class="n_cnt_grpt_default">(<span id="miviewspan_NA">0</span>)</p>
                                </div>
                        </div>
                </div>
						<div class="cb"></div>
					</div>
				</td>
				<% }else{
                                mile_isactive = mile_id = mile_project_id = mile_uniq_id = mile_title ='';
                                if(typeof(milesto_names[getdata.EasycaseMilestone.mid])=== 'object'){
                                    mile_isactive = milesto_names[getdata.EasycaseMilestone.mid].isactive;
                                    mile_id=milesto_names[getdata.EasycaseMilestone.mid].id;
                                    mile_project_id=milesto_names[getdata.EasycaseMilestone.mid].project_id;
                                    mile_uniq_id=milesto_names[getdata.EasycaseMilestone.mid].uniq_id;
                                    mile_title=milesto_names[getdata.EasycaseMilestone.mid].title;
                                }
                                
                                %>	
				<td colspan="10" class="pr">
                                     <div class="fl os_sprite dot-bar-group"></div>
					<div class="plus-minus-accordian">
                                            <% accordianClass='plus-minus';                                       
                                        for(i=0;i < check_ids_array.length;i++){
                                         if(check_ids_array[i]== mile_id){
                                         accordianClass="minus-plus hideSub";
                                         
                                         }
                                         }                                         
                                         %>
						<div class="fl accord_cnt_txt">
							<div class="fl __hold" onclick="collapse_by_title('<%= mile_id %>',<%= mile_project_id %>);" style="font-weight:normal">
								<a class="miview_a <% if(mile_isactive != 1){ %> taskCompleted<% } %>" id="miview_<%= mile_id %>" href="javascript:void(0);">
                                                                    <%= mile_title %> 
								</a>
								<div class="form-group edit_task_group pr label-floating" id="miviewtxtdv_<%= mile_id %>" style="display:none;">
                                                                    <label class="control-label" for="focusedInput1">Edit Task Group</label>
                                                                    <input style="display:none;" class="mviewtxt form-control" type="text" id="miviewtxt_<%= mile_id %>" onkeyup="inlineEditMilestone(event,<%= mile_id %>,0);" onblur="inlineEditMilestone(event,<%= mile_id %>,1);" />
                                                                    <span class="input-group-btn">
                                                                            <button onclick="inlineEditMilestone(event,<%= mile_id %>,0);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="Save">
                                                                            <i class="material-icons">send</i>
                                                                      </button>
                                                                    </span>
								</div>
                                                            <p class="n_cnt_grpt_<%= mile_id %> <% if(mile_isactive != 1){ %> taskCompleted<% } %>">(<span id="miviewspan_<%= mile_id %>">0</span>)</p>
							</div>
						</div>
						</div>
						<div class="cb"></div>
					</div>
					</td>	
				<% } %>
				</tr>
				<% prvGrpvalue= getdata.EasycaseMilestone.mid; %>
				<% var d_mid = getdata.EasycaseMilestone.mid; if(d_mid == 'NA'){ d_mid = 0;} %>
				<% if(d_mid == 0 || (d_mid != 0 && mile_isactive == 1)){ %>
				<% } %>
				<%
			}
		}else{
			if(getdata.Easycase.newActuldt && getdata.Easycase.newActuldt!=0) {%>
    <tr class="list-dt-row">
        <td colspan="9" align="left" class="curr_day"><div class="dt_cmn_mc <% if(count!=1 && !getdata.Easycase.pjname) {%>y_day<% } %>"><%= getdata.Easycase.newActuldt %></div></td>
    </tr>
    <%	}} %>
	
	<%
	if(typeof getdata.EasycaseMilestone != 'undefined'){
		if(getdata.EasycaseMilestone.mid == null){
			var mid = 'NA';
		}else{
			var mid = getdata.EasycaseMilestone.mid;
		}
	}
	%>
	<% var bgcol = "#F2F2F2";
		if(chkDat == 1) { bgcol = "#FFF"; }
		var borderBottom = "";
		if(pgCaseCnt == count) { borderBottom = "border-bottom:1px solid #F2F2F2;"; }
                tcount++;
                countMile[mid]=tcount;                             
                %>
	<% if(isactive==0) {%>
    <tr class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
	<% }else {%>
    <tr class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %>>
	<% }%>	
	<% if(groupby=='milestone') { %>
	<td class="prtl">
	</td>
	<% } %>
	<td class="ctg_check_td pr" <% if(groupby =='' || groupby !='priority'){%>class="check_list_task tsk_fst_td pr_<%= easycase.getPriority(casePriority) %>"<% } %>>
            <span class="max_width_tsk_title ellipsis-view" title="Task#<%= caseNo %>  ">
					<%= caseNo %>
				</span>
	</td>
	<% if(groupby !='milestone') { %>
	<td class="pr"><%= caseNo %>
		<div class="check-drop-icon">
			<div class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i><?php //&#xE5CF; ?>
				</a>
				<ul class="dropdown-menu">
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
                                        if(caseLegend != 5 && caseTypeId!= 10) { caseFlag=2; }
                                        if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                                        </li>
                                        <% }
                                        if(caseLegend != 3 && caseTypeId != 10) { caseFlag=5; }
                                        if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                                        </li>
                                        <% } %>
					<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                        <li onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                        </li>     
                                                            <?php } ?>
                                        <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                        <?php } ?>
                                       <% if((caseFlag == 5 || caseFlag==2) && getdata.Easycase.isactive == 1) { %>
                                        <!--<li class="divider"></li>-->
                                        <% } %>
                                        <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                                            if(getdata.Easycase.isactive == 1){ %>
                                        <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group Hierarchy Page">
                                            <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                            <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                            </li>
                                        <% }
					if( SES_ID == caseUserId) { caseFlag=3; }
					if(getdata.Easycase.isactive == 1){ %> 
                                        <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                        </li>
                                        <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                        </li>
                                        <% }
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                        if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
						<% if(getdata.Easycase.isactive == 1){ %>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
								<a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
							</li>
						<% } %>
						<% if(getdata.Easycase.isactive == 0){ %>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="restoreFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
							</li>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="removeFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
							</li>
						<% } %>
                                        <% }
					if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                        </li>
                                        <% } %>
                                        <% if(getdata.Easycase.milestone_id){ %>
                                        <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                        </li>
                                        <% } %>
                                        <!--<li class="divider"></li>-->
                                        <% if(getdata.Easycase.isactive == 1){
                                                            if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
                                                            caseFlag = "remove";%>
                                        <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                        </li>
                                        <%
					}
					}
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId)) { caseFlag = "archive"; }
					if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                        </li>
                                        <% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId)) { caseFlag = "delete"; }
					if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                        </li>
                                        <% } %>
				</ul>
			</div>
		</div>
	</td>
	<% } %>

	<td class="relative list-cont-td">
		<div class="title-dependancy-all">
		<a href="javascript:void(0);" class="ttl_listing">
			<span id="inactivetitlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>"> 
				<span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
					#<%=getdata.Easycase.case_no%>: <%= formatText(ucfirst(caseTitle)) %>
				</span>
			</span>
		 <div class="task_dependancy_item">
            <div class="task_dependancy fr">
                    <% if(getdata.Easycase.children && getdata.Easycase.children != ""){ %>
                        <span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId %>">
				<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
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
                    <% if(getdata.Easycase.depends && getdata.Easycase.depends != ""){ %>
                        <span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId %>">
				<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
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
			<div class="cb"></div>
		</div>
		</a>
		</div>
		<div class="list-td-hover-cont">	
		<span class="created-txt"><% if(getTotRep && getTotRep!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %></span>
		<span class="list-devlop-txt">
			<a href="javascript:void(0)">
				<i class="material-icons tag_fl">&#xE54E;</i>
				<span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>clsptr<% } %>" title="<%= getdata.Easycase.csTdTyp[1] %>" >
					<span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= getdata.Easycase.csTdTyp[1]%><span class="due_dt_icn"></span>
				</span>
			</a>				
			<span id="typlod<%= caseAutoId %>" class="type_loader">
				<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
			</span>				
		</span>		
                <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" class="recurring-icon" onclick="showRecurringInfo(<%= getdata.Easycase.id %>);" ><i class="material-icons">&#xE040;</i></a>
        <% } %>
	</div>
</td>
<td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %> id="<%= count %>" <% } %> style="cursor:pointer;vertical-align:top">
	<a href="javascript:void(0);" <% if(getdata.Easycase.format != 1 && getdata.Easycase.format != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
		<i class="glyphicon glyphicon-paperclip"></i>
	</a>
	<% if(getTotRep && getTotRep!=0) { %><%= getTotRep %><% } %>
	<a href="javascript:void(0)" id="<%= count %>" style="<% if(!getTotRep || getTotRep==0) { %>display:none<% } %>">
		<i class="material-icons">&#xE0B9;</i>
	</a>
</td>
<% if(isactive==0){ %>
<td></td>
<% } else { %>
<td class="assi_tlist width_assign">
	<i class="material-icons">&#xE7FD;</i>			
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="showUpdAssign<%= caseAutoId %>" data-toggle="dropdown" title="<%= getdata.Easycase.asgnName %>" class="clsptr" onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)"><%= getdata.Easycase.asgnShortName %><span class="due_dt_icn"></span></span>
	<% } else { %>
	<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= getdata.Easycase.asgnShortName %></span>
	<% } %>
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>			
</td>
<% } %>
<td class="text-center <% if(getdata.Easycase.csTdTyp[1] != 'Update'){ %>task_priority csm-pad-prior-td<% }else{ %>csm-pad12-prior-td<% } %>">
    <% var csLgndRep = getdata.Easycase.legend; %>
    <% if(getdata.Easycase.csTdTyp[1] == 'Update'){ %>
        <span class="prio_high prio_lmh prio_gen" rel="tooltip" title="<?php echo __('Priority');?>:<?php echo __('high');?>"></span>
    <% }else{ %>
    <div style="" id="pridiv<%= caseAutoId %>" data-priority ="<%= casePriority %>" class="pri_actions <% if(showQuickActiononList){ %> dropdown<% } %>">    
        <div class="dropdown cmn_h_det_arrow lmh-width">
        <div <% if(showQuickActiononList){ %> class="quick_action" data-toggle="dropdown" <% } %> style="cursor:pointer"><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>:<%= easycase.getPriority(casePriority) %>"></span></div>
        </div>
    </div>
    <span id="prilod<%= caseAutoId %>" style="display:none">
            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
    </span>
    <% } %>
</td>
<td class="text-center tskg-updt-time" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('updated');?><% } else { %><?php echo __('created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> <%= getdata.Easycase.fbstyle %>."><%= getdata.Easycase.fbstyle %></td>
<td>
<span id="csStsRep<%= count %>" class="">
<% if(isactive==0){ %>
	<div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
<%}else if(groupby =='' || groupby !='status'){%>
	<%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
<% } %>
</span>
</td>

<td class="due_dt_tlist <% if(getdata.Easycase.csDueDate == '' || getdata.Easycase.legend == 5 || getdata.Easycase.type_id == 10 || getdata.Easycase.legend == 3){ %>  <% } %>">
	<% if(getdata.Easycase.isactive == 1){ %>
	<% if(showQuickActiononList && caseTypeId != 10){ %>
	<!--<span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="Edit Due Date"<% } %>></span>-->
	<% } %>
	<span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= getdata.Easycase.csDuDtFmt1 %>">
		<%= getdata.Easycase.csDuDtFmt1 %>
	</span>
	<span id="datelod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>
</td>
</tr>
<%
		totids += caseAutoId + "|";
	}
    }
    if(!caseCount || caseCount==0){
    var case_type = $("#caseMenuFilters").val(); %>
    <tr class="empty_task_tr empty_task_tr_tsgrp">
        <td colspan="10" align="center" class="textRed">
            <% if(case_type == 'cases' || case_type == ''){
				if(filterenabled){%>
					<?php echo __('No Tasks found');?>
            <% }else{ %>			
			<% if(all_milesto_names.length == 0){ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'')); ?>
			<% } %>
            <% } %>
            <% }else if(case_type == 'assigntome'){
				if(filterenabled){ %>
					<?php echo __('No tasks for me');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'assigntome')); ?>
            <% } %>
            <% }else if(case_type == 'overdue'){
				if(filterenabled){ %>
					<?php echo __('No tasks as overdue');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'overdue')); ?>
            <% } %>
            <% }else if(case_type == 'delegateto'){
				if(filterenabled){ %>
					<?php echo __('No tasks delegated');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'delegateto')); ?>
            <% } %>
            <% }else if(case_type == 'highpriority'){
                if(filterenabled){ %>
                        <?php echo __('No high priority tasks');?>
            <% }else{ %>
			
            <?php echo $this->element('no_data', array('nodata_name' => 'inacttasklist','case_type'=>'highpriority')); ?>
            <% } %>
            <% } %>
        </td>
    </tr>
    <% } %>
    </tbody>
    </table>
	</div>
    <% $("#inactive_task_paginate").html('');
    if(caseCount && caseCount!=0) {
            var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
            $("#inactive_task_paginate").html(tmpl("inactive_paginate_tmpl", pageVars));
    }
    $(document).ready(function(){   
    setTimeout(function(){
        for (var k in countMile){       
            $("#miviewspan_"+k).html(countMile[k]);
        }
        },1000);
    });
    %>
		<div class="crt_task_btn_btm">
			<div class="pr">
				<div class="os_plus ctg_btn">
					<div class="ctask_ttip">
						<span class="label label-default"><?php echo __('Create Task Group');?></span>
					</div>
					<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task Group Page Big Plus\'' %>, <%= '\'Create Task Group\'' %>);addEditMilestone(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>);">
						<i class="material-icons">&#xE065;</i>
					</a>
				</div>
			</div>
             <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
			<div class="os_plus">
				<div class="ctask_ttip">
					<span class="label label-default"><?php echo __('Create Task');?></span>
				</div>
				<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task Group Page Big Plus\'' %>, <%= '\'Create Task\'' %>);creatask();">
					<img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
					<img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
				</a>
			</div>
        <?php } ?>
		</div>
		<div class="cb"></div>
</div>
<% } %>
<?php } ?>
<input type="hidden" name="hid_cs" id="hid_cs" value="<%= count %>"/>
<input type="hidden" name="totid" id="totid" value="<%= totids %>"/>
<input type="hidden" name="chkID" id="chkID" value=""/>
<input type="hidden" name="slctcaseid" id="slctcaseid" value=""/>
<input type="hidden" id="getcasecount" value="<%= caseCount %>" readonly="true"/>
<input type="hidden" id="openId" value="<%= openId %>" />
<input type="hidden" id="email_arr" value=<%= '\'' + ((typeof email_arr != 'undefined' && email_arr)?email_arr:'') + '\''  %>  />
<input type="hidden" id="curr_sel_project_id" value="<% if(projUniq!='all'){%><%= projId %> <% } %>"  />
<script type="text/javascript">
    $(function(){
        $(".cmn_hover_menu_open").hide();
    })
</script>