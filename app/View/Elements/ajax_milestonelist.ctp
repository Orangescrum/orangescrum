<style>
body {margin-bottom: 0px;}
.ui-draggable-dragging{
    -ms-transform: rotate(5deg); /* IE 9 */
  -webkit-transform: rotate(5deg); /* Safari prior 9.0 */
  transform: rotate(5deg); /* S */
}
/*#show_milestonelist{overflow-x: auto;}*/
.kanban-main{overflow-x: auto;}
</style>
<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<div class="pr">
<div class="page_ttle_toptxt"><?php echo __('Kanban Board');?></div>
<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
<?php }else{ ?>
<a href="javascript:void(0)" onclick="kanban_sattus();" class="tgkankan" ><i class="material-icons">&#xE862;</i> <?php echo $this->Format->displayKanbanOrBoard().' '.__('View');?></a>
<?php } ?>
</div>
<div style="height:15px;width:100%"></div>
<%
var rel_arrdflt = new Array();
var rel_arrtg = new Array();
%>

<% if(all_task_group.length != 0){ %>
<div class="cmn_bdr_shadow kanban_top_slider">
	<div class="bxslider">
	<%  var alltotalclosedPercent = Math.round((all_task_cnt_closed/all_task_cnt)*100);
        alltotalclosedPercent = (!isNaN(alltotalclosedPercent))?alltotalclosedPercent:0;
        %>			
            <div class="slide knban_prog_box active">			
                    <a><div class="kanban_count"><?php echo __('All');?><strong>(<%= all_task_cnt %>)</strong></div></a>
			<div class="cb"></div>
			<div class="prog_percent">
				<div class="clsd-txt"><%= alltotalclosedPercent %>% <?php echo __('closed');?></div>
                                <div class="progress kb-head-prgrs" title="<%= all_task_cnt_closed %> <?php echo __('out of');?> <%= all_task_cnt %> <?php echo __('tasks are closed');?>" rel="tooltip">
					<div class="progress-bar progress-bar-info" style="width:<%= alltotalclosedPercent %>%;"></div>
				</div>
			</div>
		</div>
		<%  var defaultclosedPercent = Math.round((all_default_closed/all_default)*100);
                    defaultclosedPercent = (!isNaN(defaultclosedPercent))?defaultclosedPercent:0;
                %>
            <div class="slide knban_prog_box" <% if(all_default == 0) { %> style="display:none;" <% } %>>
			        <a class="dropdown-toggle main_page_menu_togl" href="javascript:void(0);" onclick="openDrpdwn(0,this,0);">
						<i class="material-icons">&#xE5D4;</i>
					</a>
                    <div class="kanban_count"><?php echo __('Default Task Group');?><strong>(<%= all_default%>)</strong></div>
			<div class="cb"></div>
			<div class="prog_percent">
				<div class="clsd-txt"><%= defaultclosedPercent%>% <?php echo __('closed');?></div>
                                <div class="progress kb-head-prgrs" title="<%= all_default_closed%> <?php echo __('out of');?> <%= all_default%> <?php echo __('tasks are closed');?>" rel="tooltip">
					<div class="progress-bar progress-bar-info" style="width:<%= defaultclosedPercent%>%;"></div>
				</div>
			</div>
		</div> 
            <% for(var tskg in all_task_group){ 
            var taskgp = all_task_group[tskg];
            var closedTsk = typeof all_closed[taskgp.TG.id] != 'undefined' ? all_closed[taskgp.TG.id]:0;
            var totCase = typeof all_tot[taskgp.TG.id] != 'undefined' ? all_tot[taskgp.TG.id]:0;
            var closedPercent = Math.round((closedTsk/totCase)*100);
           closedPercent = (!isNaN(closedPercent))?closedPercent:0;
            %>
		<div class="slide knban_prog_box">
			<a class="dropdown-toggle main_page_menu_togl" href="javascript:void(0);" onclick="openDrpdwn(<%= taskgp.TG.id %>,this,0);">
				<i class="material-icons">&#xE5D4;</i>
			</a>
                    <a href="javascript:void(0);" onclick="reloadKanbanPage(<%= '\'' +  taskgp.TG.uniq_id + '\'' %>);"><div class="kanban_count "><span class="kanban_elipse ellipsis-view kanban_prog_<%= taskgp.TG.id %>" ><%= taskgp.TG.title %></span><strong class="kanban_strong">(<%= totCase %>)</strong></div></a> <!--title="<%= taskgp.TG.title %>" rel="tooltip"-->
			<div class="cb"></div>
			<div class="prog_percent">
				<div class="clsd-txt"><%= closedPercent%>% <?php echo __('closed');?></div>
                                <div class="progress kb-head-prgrs" title="<%= closedTsk %> <?php echo __('out of');?> <%= totCase %> <?php echo __('tasks are closed');?>" rel="tooltip">
					<div class="progress-bar progress-bar-info" style="width:<%= closedPercent%>%;"></div>
				</div>
			</div>
		</div>
            <% } %>
	</div>
	<div class="tgle_dropdown_menu" id="tgle_dropdown_menu0">
		<ul class="dropdown-menu">
			<?php /*if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
			<li  onclick="creatask(0)" > 
				<a href="javascript:void(0);">
					<i class="material-icons">&#xE03B;</i><?php echo __('Create New Task');?>
				</a>
			</li>	
		<?php } */ ?>
			<% var dflt = "default"; %>			
			<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>		
			<li onclick="addEditMilestone(<%= '\'\',\'' + dflt + '\'' %>,<%= '\'' + dflt + '\'' %>,<%= '\'' +dflt + '\',1' %>)" class="makeHover">
				<a href="javascript:void(0)"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?> </a>
			</li>				
			<?php } ?>		
		</ul>
		</div>
    <% for(var tskg in all_task_group){
     var taskgp = all_task_group[tskg];
     var totCase = typeof all_tot[taskgp.TG.id] != 'undefined' ? all_tot[taskgp.TG.id]:0;
    %>
	<div class="tgle_dropdown_menu" id="tgle_dropdown_menu<%= taskgp.TG.id %>">
		<ul class="dropdown-menu">
			<?php /*if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>	
			<li  onclick="creatask(<%= taskgp.TG.id %>)" > 
				<a href="javascript:void(0);">
					<i class="material-icons">&#xE03B;</i><?php echo __('Create New Task');?>
				</a>
			</li>
		<?php } */ ?>
		<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>	
			<li  onClick="addTaskToMilestone(<%= '\'\',\''+ taskgp.TG.id + '\'' %>,<%= '\'' + taskgp.TG.project_id+ '\'' %>,<%= '\'' + count + '\'' %>)" >
				<a href="javascript:void(0);"><i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?></a>
			</li>
			<li onclick="addEditMilestone(<%= '\'\',\'' + taskgp.TG.uniq_id + '\'' %>,<%= '\'' + taskgp.TG.id + '\'' %>,<%= '\'' + taskgp.TG.title + '\',1' %>)" class="makeHover">
				<a href="javascript:void(0)"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?> </a>
			</li>
		<?php } ?>
                        <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>	
                        <% if(totCase){ %>
                         <li class="makeHover delete_ntask delete_ntask_t drop_menu_mc">
                           <a href="javascript:void(0);" class="mnsm"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                <ul class="dropdown_status_bk dropdown-menu drop_smenu full_left smenu_ddown width_180">
                                        <li class="li_check_radio"> <div class="radio radio-primary">
                                  <label>
                                        <input name="dtaskgroup" type="radio" id="grp_rdio_<%= taskgp.TG.id %>" onclick="delMilestone(0,<%= '\'' + escape(taskgp.TG.title) + '\'' %>, <%= '\'' + taskgp.TG.uniq_id + '\'' %>,<%= taskgp.TG.id %>,1);"/> <?php echo __('Task Group');?>
                                  </label>
                        </div> </li>
                        <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>	
                                        <li class="li_check_radio"> <div class="radio radio-primary">
                                          <label>
                                                <input name="dtaskgroup" type="radio" id="grp_t_rdio_<%= taskgp.TG.id %>"  onclick="delMilestone(0,<%= '\'' + escape(taskgp.TG.title) + '\'' %>, <%= '\'' + taskgp.TG.uniq_id + '\'' %>,<%= taskgp.TG.id %>,2);"/><?php echo __('Task Group and Task');?>
                                          </label>
                                </div> </li>
                            <?php } ?>
                                </ul>
                                                                  
                            </li>
                        <% }else{ %>
			<li onClick="delMilestone(<%= '\'\',\'' + taskgp.TG.title + '\'' %>,<%= '\'' + taskgp.TG.uniq_id + '\'' %>);" class="makeHover" >
				<a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
			</li>			
                        <% } %>
                    <?php } ?>
		</ul>
	</div>
    <% } %>
</div>          
<% } %>  
</div>
</div>

<% if(!error){ %>
<div class="kanban-auto-scroll">
<div class="kanban-main row kanban_mcnt m-kanaban-group">
	<%
        var rec_ids=new Array();
	var clscnt=1;
	var count = 0;
	var totids = "";
	var openId = "";
	var pgCaseCnt = countJS(caseAll);
	var caseCount = countJS(caseAll);
	
        
        if(caseAllDefault && countJS(caseAllDefault)>0){
                        var count = 0;
                        var mdtlstitle = "Default Task Group";
			%>
			<div class="kanban-child tg-autoheight fixed col-lg-3 col-sm-3 kanban-child-taskgroup" id="milestone_0">                            
            <div class="kanban_cnt_det">
				<div class="kanban_top_cnt kbhead kbhead_0">
				       <div class="edit_task_link" id="edit-link_0">												   
                            <h5 id="main-title-holder_0" ><a class="ellipsis-view a_act_link_tg" style="cursor: text;text-decoration: none;"><%= mdtlstitle %></a> <div class="a_act_link_tg_dv">(<%= countJS(caseAllDefault) %>)</div><span class="cb"></span><!--rel="tooltip" title="<%= mdtlstitle %>"-->
                            <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>	
														<div class="kb_top_icn">
                                <a href="javascript:void(0);" onclick="quickEditMilestone(0);"><i class="material-icons">&#xE254;</i></a>
                            </div>	
                        	<?php } ?>
													</h5>
													<div class="tskgrp_hrs">
                            <span>
                              <?php echo __('Task Est Hr');?>: <strong><%= format_time_min(caseAllDefault_est) %></strong>
                            </span>
                            <span>
                               <?php echo __('Spent Hr');?>: <strong><%= format_time_min(caseAllDefault_spent)%></strong>
                            </span> 
                          </div>
                        </div>
                        <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>	
                        <div class="form-group label-floating" id="edit-save_0" style="display:none;width:100%;">
                            <input type="text" class="form-control" data-titl ="<%= mdtlstitle %>" data-taskcnt = "<%= countJS(caseAllDefault) %>" id="milstone_edit_0" value="<%= mdtlstitle %>" onblur="return saveMilesatoneTitle(0);"/>
                        </div>
                    <?php } ?>
					<div class="cb"></div>
				</div>
				
				
				<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>   
					<div class="add_new_item kb_task_det last_title add_new_item_0">
						<span class="tgle_addnew tgle_addnew_0" onclick="show_add_tgle_fld(0)"><i class="material-icons">&#xE147;</i> <?php echo __('Add Task');?></span>						
						<div class="add_tgle_fld add_tgle_fld_0">
							<div class="form-group label-floating">
								<label class="control-label" for="add_task_fld"><?php echo __('Enter Task Title');?></label>
								<input data-mid="0" class="inline_qktask0 in_qt_kanban form-control" type="text" />
							</div>
							<div class="save_cancel_tgle">
								<span>
									<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="AddQuickTask(0, <%= '\'kbn\'' %>);"><?php echo __('Add');?></a>
								</span>
								<span class="close_tgle" onclick="hide_add_tgle_fld(0)"><i class="material-icons">&#xE14C;</i></span>
							</div>
						</div>						
					</div>					
				<?php } ?>
				
                <div class="kban_all_task kanban_content">
                   <% for(var mkey in caseAllDefault){
                        var  getdata = caseAllDefault[mkey];			
			var caseAutoId = getdata.Easycase.id;
			var isFavourite = getdata.Easycase.isFavourite;
	        var favMessage ="Set favourite task";
	        if(isFavourite){
	            var favMessage ="Remove from the favourite task";
	        }
			var favouriteColor = getdata.Easycase.favouriteColor;
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
			var showQuickActiononList = 0;
			var showQuickActiononListEdit = 0;
			if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1) )) {
				var showQuickActiononList = 1;
			}
			if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
				getTotRep = getdata.Easycase.reply_cnt;
			}
			var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
			if(caseUrl == caseUniqId) {
				openId = count;
			}
			var showQuickEdit = 0;
                        if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
                showQuickEdit = 1;
			}
			 if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
              showQuickActiononListEdit = 1;
   			 }

			var chkDat = 0;
			if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
				projectName =	getdata.Easycase.pjname;
				projectUniqid = getdata.Easycase.pjUniqid;
			}else if(projUniq!='all'){
				projectName =	getdata.Easycase.pjname;
				projectUniqid = getdata.Easycase.pjUniqid;
			}
			var chkDat = 0;
			%>
                   <div class="kb_task_det prioo-bdr-<%= easycase.getPriority(casePriority) %>  <% if(isAllowed('Move to Milestone',projectUniqid)){ %>  kbtask_div <% } %>" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %>Updated<% } else { %>Created<% } %> by <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %>on<% } %> <%= getdata.Easycase.updtedCapDt %> " data-is-parent="<% if(rel_arrdflt.length && rel_arrdflt.indexOf(caseAutoId) != -1){ %>1<% } %>">
                   <% if(getdata.Easycase.type_id != 10){ %>
			<span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="Priority: <%=  easycase.getPriority(casePriority) %>"></span>
            <% }else{ %>
            <span class="prio_high prio_lmh prio_kanban" rel="tooltip" title="<?php echo __('Priority');?>: <?php echo __('high');?>"></span>
            <% } %>
					<div class="top_title_type">
                <h6 id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>line_through<% } %> case_title_<%= caseAutoId %>">
                    <span class="case-title-kbn-<%= caseAutoId %>">#<%= caseNo %>: <%= caseTitle %></span>
					<input type="hidden" class="prjhid" value="<%= projId %>" />
                <span class="rt_icn">
                    <span class="dropdown">
                        <a class="dropdown-toggle main_page_menu_togl" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu addn_menu_drop_pos_kbn">
						<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
						$.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
						if(getdata.Easycase.CustomStatus.id != data.id){
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
						<% } 
						}); 
						} else{ %>
                          <% var caseFlag="";
					if(caseLegend != 1 && caseTypeId != 10){ caseFlag=9; }
                    if(getdata.Easycase.isactive == 1){ %>
                    <li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                        <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                    </li>
                    <% }if((caseLegend != 2 && caseLegend != 4) && caseTypeId!= 10) { caseFlag=1; }
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
                    <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                     	<% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
                    <li onclick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                    </li>
                            <% } %>
                    <% if(caseLegend !=3 && caseTypeId != 10){ %>
                    	<% if(isAllowed("Start Timer",projectUniqid)){ %>
							<li onclick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Start Timer\'' %>);startTimer(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>, <%= '\'' + caseUniqId + '\'' %>, <%= '\'' + projectUniqid + '\'' %>, <%= '\'' + escape(projectName) + '\'' %>); trackEventWithIntercom(<%= '\'timer\'' %>,<%= '\'\'' %>);">
		                    <a href="javascript:void(0);"><i class="material-icons">&#xE425;</i><?php echo __('Start Timer');?></a>
		                </li>
                    <% } %>
                    <% } %>
					<?php } ?>
					<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
					if(getdata.Easycase.isactive == 1){ %>
          	<% if(isAllowed("Reply on Task",projectUniqid)){ %>
					<li id="bk_act_reply<%= count %>" data-task="<%= caseUniqId %>" onclick="setSessionStorage(<%= '\'Kanban Task Group\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);">
						<a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE898;</i><?php echo __('Re-open');?></a>
						<a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
					</li>
                            <% } %>
					<% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID)) { caseFlag=3; }
					if(getdata.Easycase.isactive == 1){ 
                                        if(showQuickActiononList || isAllowed("Edit All Task",projectUniqid)){
                                        %>
         	<% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit) || isAllowed("Edit All Task",projectUniqid)){ %>
					<li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickEdit || isAllowed('Edit All Task',projectUniqid)){ %>display:block <% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
					</li>
           <% } %>
					<% } }
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
					if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){
					%>
          	<% if(isAllowed("Move to Project",projectUniqid)){ %>
					<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>" onclick="mvtoProject(<%= '\'' + count + '\'' %>,this)" id="mv_prj<%= caseAutoId %>" style=" ">
					    <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
					</li>
                            <% } %>
					<% } 
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
					if(getdata.Easycase.isactive == 1){ %>
          	<% if(isAllowed("Move to Milestone",projectUniqid)){ %>
					<li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + getdata.Easycase.Mid + '\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
					</li>
					<% } %>
					<% } %>
					<% if(getdata.Easycase.isactive == 1){
					if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
					caseFlag = "remove";
					%>
                     <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
					<li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
					</li>
                            <% } %>
					<%
					}
					}
					if(SES_TYPE == 1 || SES_TYPE == 2 || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ( SES_ID == caseUserId)) || isAllowed("Archive All Task",projectUniqid)) { caseFlag = "archive"; }
					if(getdata.Easycase.isactive == 1){ %>
                    <% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
					<li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
					</li>
                            <% } %>
					<% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (caseLegend == 1  && SES_ID == caseUserId) || isAllowed("Delete All Task",projectUniqid)) { caseFlag = "delete"; }
					if(getdata.Easycase.isactive == 1){ %>
                    <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
					<li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
					</li>
					<% } %>
					<% } %>
                        </ul>
                    </span>
                </span>
            </h6> 
            <div class="kb_det_icn">
                <% if(getdata.Easycase.csTdTyp[1]){ %><i class="glyphicon glyphicon-tags" rel="tooltip" title="<%= getdata.Easycase.csTdTyp[1] %>"></i><% } %>
                <% if(getdata.Easycase.csDuDtFmt.search("Set Due Dt") >= 0 || getdata.Easycase.csDuDtFmt=='No Due Date' || getdata.Easycase.csDuDtFmt.search("Schedule it") >= 0){%><% } else { %><i class="material-icons" rel="tooltip" title="<%= getdata.Easycase.csDuDtFmtT %>">&#xE878;</i><% } %>
                <% if(getTotRep && getTotRep!=0) { %><i class="material-icons">&#xE253;</i><span class="count_knbn" style="top:-1px;position: relative;font-size: 11px !important;padding-left: 2px;"><%= getTotRep %><% } %>
				<% if(getdata.Easycase.format != 2) { %><span title="files/attachments" class="att_fl" style="    display: inline-block;position: relative;top: 5px;left: 4px;"></span><% } %>					
                <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
				<a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId %>);" class="recurring-icon"><i rel="tooltip" title="<?php echo __('Recurring Task');?>" class="material-icons">&#xE040;</i></a><% } %>
					
					<!-- newly added -->
					<div class="gantt_kanban_depedant_block">
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
							
							<% if(getdata.Easycase.parent_task_id && getdata.Easycase.parent_task_id != ""){ %>
							<span class="fl task_parent_block task_parent_block_addn" id="task_parent_id_block_<%= caseUniqId %>">
								<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.parent_task_id + '\'' %>);" class="fl task_title_icons_parents_tt"><i class="material-icons ptask">&#xE23E;</i></div>
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
                       </span>
					</div>				
					<div class="cb"></div>
				<!-- newly added -->				
					
					
					
            </div>
            </div>
            <% var filesArr = getdata.Easycase.all_files; 
                if(filesArr != ''){
            %>
           <div class="kb_det_img">
            <% var fc = 0;
				var imgaes = ""; var caseFileName = "";
				var getFiles = filesArr[0]; %>
            <%	caseFileName = getFiles.CaseFile.file;
                caseFileUName = getFiles.CaseFile.upload_name;
                caseFileId = getFiles.CaseFile.id;
                downloadurl = getFiles.CaseFile.downloadurl;
                var d_name = getFiles.CaseFile.display_name;
                if(!d_name){
                    d_name = caseFileName;
                }if(caseFileUName == null){
                    caseFileUName = caseFileName;
                }
                if(getFiles.CaseFile.is_exist) {
                fc++;
                file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file);%>
                 <% if(isAllowed('View File',projectUniqid)){ %>
                <div class="fl atachment_det" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> <% }else{%> style="display:none;" <%} %>>
                    <div class="aat_file">
                    	<% if(isAllowed('Download File',projectUniqid)){ %>
                        <div class="file_show_dload">
                            <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= d_name %>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                            <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                        </div>
                        <% } %>
                        <% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                            <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                <img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;max-height: 120px;" title="<%= d_name %>" alt="Loading image.." />
                            <% }else{ %>
                                <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                            <% } %>
                        <% } else { %>
                            <div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
                        <% } %>
                    </div>
                </div>
                <% } %>
                <% if(isAllowed('View File',projectUniqid)){ %>
                <div class="fl atachment_det parent_other_holder" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> style="display:none;" <% } %>>
                    <div class="aat_file">
                    	<% if(isAllowed('Download File',projectUniqid)){ %>
                        <div class="file_show_dload">
                            <% if(downloadurl) { %>
                            <a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                            <% } else {%>
                            <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                            <% } %>
                        </div>
                        <% } %>
                        <% if(downloadurl) { %>
                            <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                        <% }else{ %>
                            <% if(getFiles.CaseFile.is_ImgFileExt){ %>
                            <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                            <%  } else{ %>
                            <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                            <% } %>
                        <% } %>
                    </div>
                </div>
                <% } %>
                <% } %>
            </div>
            <% } %>
			<div class="cb"></div>
            <div class="kb_task_status">
							<div class="kb_task_hrs fl">
									<% if(getdata.Easycase.estimated_hours != '0' && getdata.Easycase.estimated_hours != ''){ %>
									<span><?php echo __('Task Est Hr');?>: <%= format_time_min(getdata.Easycase.estimated_hours) %></span>
									<% } %>
									<% if(getdata.Easycase.spent_hrs != '0' && getdata.Easycase.spent_hrs != ''){ %>
									<span>
											<?php echo __('Spent Hr');?>: <strong><%= format_time_min(getdata.Easycase.spent_hrs) %></strong>
									</span>
									<% } %>
									<div>
				<% if(getdata.Easycase.custom_status_id != 0 && getdata.Easycase.CustomStatus != null ){ %>
					<%= easycase.getCustomStatus(getdata.Easycase.CustomStatus, getdata.Easycase.custom_status_id) %>
				<% }else{ %>
				  <%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
				 <% } %>
                </div>               
							</div>
                <?php /* <div class="fl">
                    <span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="Priority: <%=  easycase.getPriority(casePriority) %>"><% var prity = easycase.getPriority(casePriority); if(prity == 'low'){ %>L<% }else if(prity == 'medium'){ %>M<% }else{ %>H<% } %></span>
                </div> */ ?>
								 <div class="fav_assign_kb_task fr">
									 <% if(getdata.Easycase.asgnShortName) { %>
									<span class="assi_tlist" title="Assigned to <%if(getdata.Easycase.asgnShortName.search("me") != -1){ %><%= $(getdata.Easycase.asgnShortName).text() %><%}else{%><%= getdata.Easycase.asgnShortName %><% } %>">
									<i class="material-icons">&#xE7FD;</i><%= getdata.Easycase.asgnShortName %>
									</span>
									<% } %>
									<span class="assi_tlist" title="<%=favMessage%>" id="kanbanDivFav<%=caseAutoId %>">
                    <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,3,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="margin-top:0px;color:<%=favouriteColor%>;" >
                	 <% if(isFavourite) { %>
										<i class="material-icons" style="color:<%=favouriteColor%>;">star</i>
            		<% }else{ %>
											 <i class="material-icons">star_border</i>
	            	<% } %>
            		</a>
									</span>
                </div>
                <div class="cb"></div>
                 
            </div>
                   </div>
                    <%
				totids += caseAutoId + "|";
				chkMstone = getdata.Easycase.Mid;		
			}%>
                        
                </div>
				<?php /*if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
                <div class="kb_task_det last_title">
                    <div class="form-group label-floating">
                      <label class="control-label" for="focusedInput1"><?php echo __('Enter Task Title');?></label>
                      <input data-mid= "0" class="inline_qktask0 in_qt_kanban form-control" id="focusedInput1" type="text" />
                    </div>
                </div>
				<?php } */ ?>
                </div>
			</div>
	<% 	} 
        
        
        
        
        
         if(caseCount && caseCount != 0){
		var count=0;
		var caseNo = "";
		var chkMstone = "";var milestonetitle ='';
		var caseLegend = "";
		var totids = "";
		var projectName ='';var projectUniqid='';
		for(var caseKey in caseAll){  
			var getdata = caseAll[caseKey];
			count++;
			var caseAutoId = getdata.Easycase.id;
			var isFavourite = getdata.Easycase.isFavourite;
	        var favMessage ="Set favourite task";
	        if(isFavourite){
	            var favMessage ="Remove from the favourite task";
	        }
			var favouriteColor = getdata.Easycase.favouriteColor;
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
			var isActive = milestones[getdata.Easycase.Em_milestone_id].isactive;
			var getTotRep = 0;
			var showQuickActiononList = 0;
			var showQuickActiononListEdit = 0;
			if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
				var showQuickActiononList = 1;
			}
			if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
				getTotRep = getdata.Easycase.reply_cnt;
			}
			var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
			if(caseUrl == caseUniqId) {
				openId = count;
			}
			var showQuickEdit = 0;
			/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
				var showQuickEdit = 1;
			}*/
            if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
                showQuickEdit = 1;
			}
			 if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
		              showQuickActiononListEdit = 1;
		    }
			var chkDat = 0;
			if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
				projectName =	getdata.Easycase.pjname;
				projectUniqid = getdata.Easycase.pjUniqid;
			}else if(projUniq!='all'){
				projectName =	getdata.Easycase.pjname;
				projectUniqid = getdata.Easycase.pjUniqid;
			}
			var chkDat = 0;
			if(chkMstone != getdata.Easycase.Mid){
			milestonetitle = str_replace('"', "", str_replace("'","", formatText(getdata.Easycase.Mtitle)));
                        if(count>1){%>
                        </div>
			 <?php /*if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
                        <div class="kb_task_det last_title">
                            <div class="form-group label-floating">
                              <label class="control-label" for="focusedInput1"><?php echo __('Enter Task Title');?></label>
                              <input data-mid= "<%= chkMstone %>" class="inline_qktask<%= chkMstone %> in_qt_kanban form-control" id="focusedInput1" type="text" />
                            </div>
                        </div>
			<?php } */ ?>
				</div>
				</div>
			<%	}
				chkDat = 1;
				var days = getdata.Easycase.days_diff;
			%>
				<div class="kanban-child tg-autoheight col-lg-3 col-sm-12 kanban-child-taskgroup" id="milestone_<%= getdata.Easycase.Mid %>">
			<div class="dot-bar_kanban"><i class="material-icons">&#xE25D;</i></div>
                <input type="hidden" class="prjhid" value="<%= projId %>" />
                <div class="kanban_cnt_det">                
                                    <% rec_ids.push(getdata.Easycase.Mid); %>
				<div class="kanban_top_cnt kbhead kbhead_<%= getdata.Easycase.Mid %>">
					<div class="edit_task_link" id="edit-link_<%= getdata.Easycase.Mid %>">
					<span class="dropdown ktgabs">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                                      <i class="material-icons">&#xE5D4;</i>
                                    </a>
                                    <ul class="dropdown-menu">
                                     <% if(isActive!=0){ %>
									<?php /* if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
                                    <li onClick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Create Task\'' %>);creatask_inline(<%= getdata.Easycase.Mid %>)" >
                                        <a href="javascript:void(0);" class="mnsm">
                                            <i class="material-icons">&#xE03B;</i><?php echo __('Create New Task');?>
                                        </a>
                                    </li>
						<?php } */ ?>
                                        <li  onClick="addTaskToMilestone(<%= '\'\',\''+ getdata.Easycase.Mid + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + count + '\'' %>)" >
                                        <a href="javascript:void(0);" class="mnsm">
                                            <i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
                                        </a>
                                    </li>							
                                    <li onclick="addEditMilestone(<%= '\'\',\'' + getdata.Easycase.Muinq_id + '\'' %>,<%= '\'' + getdata.Easycase.Mid + '\'' %>,<%= '\'' + milestonetitle + '\',1' %>)" class="makeHover">
                                        <a href="javascript:void(0)" class="mnsm">
                                            <i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
                                        </a>
                                    </li>
                                                                <% } %>
                                     <li class="makeHover delete_ntask delete_ntask_t drop_menu_mc">
                                        <a href="javascript:void(0);" class="mnsm"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                             <ul class="dropdown_status_bk dropdown-menu drop_smenu full_left smenu_ddown width_180">
                                                     <li class="li_check_radio"> <div class="radio radio-primary">
                                               <label>
                                                     <input name="dtaskgroup" type="radio" id="grp_rdio_<%= getdata.Easycase.Mid %>" onclick="delMilestone(0,<%= '\'' + escape(milestonetitle) + '\'' %>, <%= '\'' + getdata.Easycase.Muinq_id + '\'' %>,<%= getdata.Easycase.Mid %>,1);"/> <?php echo __('Task Group');?>
                                               </label>
                                     </div> </li>
                                      <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>     
                                                     <li class="li_check_radio"> <div class="radio radio-primary">
                                                       <label>
                                                             <input name="dtaskgroup" type="radio" id="grp_t_rdio_<%= getdata.Easycase.Mid %>"  onclick="delMilestone(0,<%= '\'' + escape(milestonetitle) + '\'' %>, <%= '\'' + getdata.Easycase.Muinq_id + '\'' %>,<%= getdata.Easycase.Mid %>,2);"/><?php echo __('Task Group and Task');?>
                                                       </label>
                                             </div> </li>
                                         <?php } ?>
                                             </ul>

                                         </li>                          
<!--                                    <li onClick="delMilestone(<%= '\'\',\'' + milestonetitle + '\'' %>,<%= '\'' + getdata.Easycase.Muinq_id + '\'' %>);" class="makeHover" >
                                        <a href="javascript:void(0);" class="mnsm">
                                            <i class="material-icons">&#xE872;</i><?php echo __('Delete');?>
                                        </a>
                                    </li>-->

                                     <% if(isActive!=0){ %>
                                        <li onclick="milestoneArchive(<%= '\'\',\'' + getdata.Easycase.Muinq_id + '\'' %>, <%= '\'' + milestonetitle + '\'' %>);"  >
                                            <a href="javascript:jsVoid();" class="mnsm">
                                                <i class="material-icons">&#xE86C;</i><?php echo __('Complete');?>
                                            </a>
                                        </li>
                                    <%  }else{ %>
                                        <li onclick="milestoneRestore(<%= '\'\',\'' + getdata.Easycase.Muinq_id + '\'' %>, <%= '\'' + milestonetitle + '\'' %>);"  >
                                            <a href="javascript:jsVoid();" class="mnsm">
                                                <i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?>
                                            </a>
                                        </li>
                                    <%  } %>
                                </ul>
                                </span>
							<h5  id="main-title-holder_<%= getdata.Easycase.Mid %>"  class="pad-left" ><a class="ellipsis-view a_act_link_tg" href="<?php echo HTTP_ROOT.'dashboard#kanban/';?><%= getdata.Easycase.Muinq_id %>"><%= getdata.Easycase.Mtitle %></a> <div class="a_act_link_tg_dv">(<%= getdata.Easycase.totalCs %>)</div><span class="cb"></span><!--rel="tooltip" title="<%= getdata.Easycase.Mtitle %>"-->
												<div class="kb_top_icn">
														<a href="javascript:void(0);" onclick="quickEditMilestone('<%= getdata.Easycase.Mid %>');"><i class="material-icons">&#xE254;</i></a>                                
                            </div>
												</h5>
											<div class="tskgrp_hrs">
												<p><?php echo __('Task Group Est Hr');?>: <strong><%= (milestones[getdata.Easycase.Mid].m_est_hrs>0)?milestones[getdata.Easycase.Mid].m_est_hrs+" hrs": "NA" %></strong></p>
												<span><?php echo __('Task Est Hr');?>: <strong><%= format_time_min(milestones[getdata.Easycase.Mid].est_hrs)%></strong></span>
											 <span><?php echo __('Spent Hr');?>: <strong><%= format_time_min(milestones[getdata.Easycase.Mid].spent_hrs)%></strong></span>
                        </div>
                        
					</div>
					<div class="form-group label-floating" id="edit-save_<%= getdata.Easycase.Mid %>" style="display:none;width:100%;">
					    <input type="text" class="form-control" data-titl ="<%= getdata.Easycase.Mtitle %>" data-taskcnt = "<%= getdata.Easycase.totalCs %>" id="milstone_edit_<%= getdata.Easycase.Mid %>" value="<%= getdata.Easycase.Mtitle %>" onblur="return saveMilesatoneTitle(<%= getdata.Easycase.Mid %>);" />
					</div>
					<div class="cb"></div>
				</div>
				<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>   
					<div class="add_new_item kb_task_det last_title add_new_item_<%= getdata.Easycase.Mid %>">
						<span class="tgle_addnew tgle_addnew_<%= getdata.Easycase.Mid %>" onclick="show_add_tgle_fld(<%= getdata.Easycase.Mid %>)"><i class="material-icons">&#xE147;</i> <?php echo __('Add Task');?></span>						
						<div class="add_tgle_fld add_tgle_fld_<%= getdata.Easycase.Mid %>">
							<div class="form-group label-floating">
								<label class="control-label" for="add_task_fld"><?php echo __('Enter Task Title');?></label>
								<input data-mid="<%= getdata.Easycase.Mid %>" class="inline_qktask<%= getdata.Easycase.Mid %> in_qt_kanban form-control" type="text" />
							</div>
							<div class="save_cancel_tgle">
								<span>
									<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="AddQuickTask(<%= getdata.Easycase.Mid %>);"><?php echo __('Add');?></a>
								</span>
								<span class="close_tgle" onclick="hide_add_tgle_fld(<%= getdata.Easycase.Mid %>)"><i class="material-icons">&#xE14C;</i></span>
							</div>
						</div>						
					</div>					
				<?php } ?>
		<div class="kban_all_task kanban_content">
		<% } %>	
		<div class="kb_task_det prioo-bdr-<%= easycase.getPriority(casePriority) %> <% if(isAllowed('Move to Milestone',projectUniqid)){ %> kbtask_div <% } %>" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> " data-is-parent="<% if(rel_arrtg.length && rel_arrtg.indexOf(caseAutoId) != -1){ %>1<% } %>">
			<!--<div class="fl" rel="tooltip" title="<% if(getTotRep && getTotRep!=0) { %>Updated<% } else { %>Created<% } %> by <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %>on<% } %> <%= getdata.Easycase.updtedCapDt %> "> <%= getdata.Easycase.proImage %></div> -->	
			<% if(getdata.Easycase.type_id != 10){ %>
			<span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="<?php echo __('Priority');?>: <%=  easycase.getPriority(casePriority) %>"></span>
            <% }else{ %>
            <span class="prio_high prio_lmh prio_kanban" rel="tooltip" title="<?php echo __('Priority');?>: <?php echo __('high');?>"></span>
            <% } %>
						<div class="top_title_type">
                <h6 id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>line_through<% } %> case_title_<%= caseAutoId %>">
                <span class="case-title-kbn-<%= caseAutoId %>">#<%= caseNo %>: <%= caseTitle %></span>
                <span class="rt_icn">
                    <span class="dropdown">
                        <a class="dropdown-toggle main_page_menu_togl" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu addn_menu_drop_pos_kbn">
							<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
						$.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
						if(getdata.Easycase.CustomStatus.id != data.id){
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
						<% } 
						}); 
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
					<% if(isAllowed('Status change except Close',projectUniqid)){ %>
						<li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
							<a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
						</li>
					<% } %>
					<% } if(caseFlag == 5 || caseFlag==2) { %>
					<% } %>
					<% } %>
                    <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                    	<% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
                    <li onclick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                    </li>
                    <% } %>
                    <% if(caseLegend !=3 && caseTypeId != 10){ %>
                    <% if(isAllowed("Start Timer",projectUniqid)){ %>
                        <li onclick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Start Timer\'' %>);startTimer(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>, <%= '\'' + caseUniqId + '\'' %>, <%= '\'' + projectUniqid + '\'' %>, <%= '\'' + escape(projectName) + '\'' %>); trackEventWithIntercom(<%= '\'timer\'' %>,<%= '\'\'' %>);">
		                    <a href="javascript:void(0);"><i class="material-icons">&#xE425;</i><?php echo __('Start Timer');?></a>
		                </li>
                    <% } %>
                    <% } %>
					<?php } ?>
					<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
					if(getdata.Easycase.isactive == 1){ %>
					<% if(isAllowed("Reply on Task",projectUniqid)){ %>
					<li id="bk_act_reply<%= count %>" data-task="<%= caseUniqId %>" onclick="setSessionStorage(<%= '\'Kanban Task Group\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);">
						<a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE898;</i><?php echo __('Re-open');?></a>
						<a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
					</li>
					<% } %>
					<% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID)) { caseFlag=3; }
					if(getdata.Easycase.isactive == 1){ 
                                        if(showQuickActiononList || isAllowed("Edit All Task",projectUniqid)){
                                        %>
                    <% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit)  || isAllowed("Edit All Task",projectUniqid)){ %>
					<li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickEdit || isAllowed('Edit All Task',projectUniqid)){ %>display:block <% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
					</li>
					<% } %>
					<% } } 
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
					if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){
					%>
					<% if(isAllowed("Move to Project",projectUniqid)){ %>
					<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>" onclick="mvtoProject(<%= '\'' + count + '\'' %>,this)" id="mv_prj<%= caseAutoId %>" style=" ">
					    <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
					</li>
					<% } %>
					<% } 
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
					if(getdata.Easycase.isactive == 1){ %>
					<% if(isAllowed("Move to Milestone",projectUniqid)){ %>
					<li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + getdata.Easycase.Mid + '\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
					</li>
					<% } %>
					<% } %>
					<% if(getdata.Easycase.isactive == 1){
					if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
					caseFlag = "remove";
					%>
					<% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
					<li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
					</li>
					<% } %>
					<%
					}
					}
					if(SES_TYPE == 1 || SES_TYPE == 2 || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ( SES_ID == caseUserId)) || isAllowed("Archive All Task",projectUniqid)) { caseFlag = "archive"; }
					if(getdata.Easycase.isactive == 1){ %>
					<% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
					<li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
					</li>
					<% } %>
					<% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (caseLegend == 1  && SES_ID == caseUserId) || isAllowed("Delete All Task",projectUniqid)) { caseFlag = "delete"; }
					if(getdata.Easycase.isactive == 1){ %>
					<% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
					<li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
						<a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
					</li>
					<% } %>
					<% } %>
                        </ul>
                    </span>
                </span>
            </h6>
            <div class="kb_det_icn">
                <% if(getdata.Easycase.csTdTyp[1]){ %><i class="glyphicon glyphicon-tags" rel="tooltip" title="<%= getdata.Easycase.csTdTyp[1] %>"></i><% } %>
                <% if(getdata.Easycase.csDuDtFmt.search("Set Due Dt") >= 0 || getdata.Easycase.csDuDtFmt=='No Due Date' || getdata.Easycase.csDuDtFmt.search("Schedule it") >= 0){%><% } else { %><i class="material-icons" rel="tooltip" title="<%= getdata.Easycase.csDuDtFmtT %>">&#xE878;</i><% } %>
                <% if(getTotRep && getTotRep!=0) { %><i class="material-icons">&#xE253;</i><span class="count_knbn" style="top:-1px;position: relative;font-size: 11px !important;padding-left: 2px;"><%= getTotRep %><% } %>
				<% if(getdata.Easycase.format != 2) { %><span title="files/attachments" class="att_fl" style="    display: inline-block;position: relative;top: 5px;left: 4px;"></span><% } %>					
                <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
				<a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId %>);" class="recurring-icon"><i rel="tooltip" title="<?php echo __('Recurring Task');?>" class="material-icons">&#xE040;</i></a><% } %>
					
					
					<!-- newly added -->
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
							
							<% if(getdata.Easycase.parent_task_id && getdata.Easycase.parent_task_id != ""){ %>
							<span class="fl task_parent_block task_parent_block_addn" id="task_parent_id_block_<%= caseUniqId %>">
								<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.parent_task_id + '\'' %>);" class="fl task_title_icons_parents_tt"><i class="material-icons ptask">&#xE23E;</i></div>
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
                       </span>
					</div>				
				<!-- newly added -->
					
					
            </div>
            </div>
            <% var filesArr = getdata.Easycase.all_files; 
                if(filesArr != ''){
            %>
            <div class="kb_det_img">
            <% var fc = 0;
				var imgaes = ""; var caseFileName = "";
				var getFiles = filesArr[0]; %>
            <%	caseFileName = getFiles.CaseFile.file;
                caseFileUName = getFiles.CaseFile.upload_name;
                caseFileId = getFiles.CaseFile.id;
                downloadurl = getFiles.CaseFile.downloadurl;
                var d_name = getFiles.CaseFile.display_name;
                if(!d_name){
                    d_name = caseFileName;
                }if(caseFileUName == null){
                    caseFileUName = caseFileName;
                }
                if(getFiles.CaseFile.is_exist) {
                fc++;
                file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file);%>
                <div class="fl atachment_det" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> <% }else{%> style="display:none;" <%} %>>
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
                    </div>
                </div>
                <% } %>
            </div>
            <% } %>
			<div class="cb"></div>
            <div class="kb_task_status">
          <div class="kb_task_hrs fl">
						<% if(getdata.Easycase.estimated_hours != '0' && getdata.Easycase.estimated_hours != ''){ %>
						<span><?php echo __('Task Est Hr');?>: <strong><%= format_time_min(getdata.Easycase.estimated_hours) %></strong></span>
						 <% } %>
						<% if(getdata.Easycase.spent_hrs != '0' && getdata.Easycase.spent_hrs != ''){ %>
						<span><?php echo __('Spent Hr');?>: <strong><%= format_time_min(getdata.Easycase.spent_hrs) %></strong></span>
						 <% } %>
						<div>
					<% if(getdata.Easycase.custom_status_id != 0 && getdata.Easycase.CustomStatus != null ){ %>
						<%= easycase.getCustomStatus(getdata.Easycase.CustomStatus, getdata.Easycase.custom_status_id) %>
					<% }else{ %>
					  <%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
					 <% } %>
                </div>	
					</div>
					<div class="fav_assign_kb_task fr">
							<% if(getdata.Easycase.asgnShortName && getdata.Easycase.asgnShortName.search("Unassigned") == -1) { %>
                <span class="assi_tlist" title="Assigned to <%if(getdata.Easycase.asgnShortName.search("me") != -1){ %><%= $(getdata.Easycase.asgnShortName).text() %><%}else{%><%= getdata.Easycase.asgnShortName %><% } %>">
                    <i class="material-icons">&#xE7FD;</i><%= getdata.Easycase.asgnShortName %>
                </span>
                <% } %>
							<span title="<%=favMessage%>" id="kanbanDivFav<%=caseAutoId %>">
                    <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,3,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="margin-top:0px;color:<%=favouriteColor%>;" >
                    	<% if(isFavourite) { %>
		                <i class="material-icons" style="color:<%=favouriteColor%>;">star</i>
		            <% }else{ %>
		                 <i class="material-icons">star_border</i>
		            <% } %>
            		</a>
              </span>
                </div>
						<?php /* <div class="fl">
								<span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="Priority: <%=  easycase.getPriority(casePriority) %>"><% var prity = easycase.getPriority(casePriority); if(prity == 'low'){ %>L<% }else if(prity == 'medium'){ %>M<% }else{ %>H<% } %></span>
						</div> */ ?>
                <div class="cb"></div>
            </div>
            </div>
                    <%
				totids += caseAutoId + "|";
				chkMstone = getdata.Easycase.Mid;		
			}%>
		</div>
		 <?php /*if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
        <div class="kb_task_det last_title">
            <div class="form-group label-floating">
              <label class="control-label" for="focusedInput1"><?php echo __('Enter Task Title');?></label>
              <input data-mid= "<%= getdata.Easycase.Mid %>" class="inline_qktask<%= getdata.Easycase.Mid %> in_qt_kanban form-control" id="focusedInput1" type="text" />
            </div>
        </div>
    <?php } */ ?>
</div>
	</div>
<% } %>
<% if(all_task_group && countJS(all_task_group)>0){
		for(var mkey in all_task_group){
			var mdtls = all_task_group[mkey].TG;
			if(jQuery.inArray( mdtls['id'],rec_ids )== -1){
			milestonetitle = str_replace('"', "", str_replace("'","", formatText(mdtls.title)));			
			var totCase = typeof all_tot[mdtls.id] != 'undefined' ? all_tot[mdtls.id]:0;			
			var isActive = milestones[mdtls.id].isactive;		
			%>
			<div class="kanban-child tg-autoheight col-lg-3 col-sm-3 kanban-child-taskgroup" id="milestone_<%= mdtls.id %>">
                           
            <div class="kanban_cnt_det">
				<div class="kanban_top_cnt kbhead kbhead_<%= mdtls.id %>">
				       <div class="edit_task_link" id="edit-link_<%= mdtls.id %>">
								<span class="dropdown ktgabs" >
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
                                       <i class="material-icons">&#xE5D4;</i>
                                    </a>
                                    <ul class="dropdown-menu">
                                    <% if(isActive!=0){ %>
                                     <?php /* if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
                                    <li  onClick="setSessionStorage(<%= '\'Kanban Task Group Page\'' %>, <%= '\'Create Task\'' %>);creatask_inline(<%= mdtls.id %>)" >
                                       <a href="javascript:void(0);" class="mnsm">
                                          <i class="material-icons">&#xE03B;</i> <?php echo __('Create New Task');?>
                                       </a>                                                        
                                   </li>
                               <?php } */ ?>
                                    <li  onClick="addTaskToMilestone(<%= '\'\',\''+ mdtls.id + '\'' %>,<%= '\'' + mdtls.project_id + '\'' %>,<%= '\'' + count + '\'' %>)" >
                                       <a href="javascript:void(0);" class="mnsm">
                                           <i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
                                       </a>                                                       
                                   </li>							 
                                   <li onclick="addEditMilestone(<%= '\'\',\'' + mdtls.uniq_id + '\'' %>,<%= '\'' + mdtls.id + '\'' %>,<%= '\'' + milestonetitle + '\',1' %>)" class="makeHover">
                                       <a href="javascript:void(0)"class="mnsm"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                   </li>
   <%  } %>
                                   <li onClick="delMilestone(<%= '\'\',\'' + milestonetitle + '\'' %>,<%= '\'' + mdtls.uniq_id + '\'' %>);" class="makeHover" >
                                       <a href="javascript:void(0);" class="mnsm"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                   </li>
<% if(isActive!=0){ %>
                                   <li onclick="milestoneArchive(<%= '\'\',\'' + mdtls.uniq_id + '\'' %>, <%= '\'' + milestonetitle + '\'' %>);"  >
                                       <a href="javascript:jsVoid();" class="mnsm"><i class="material-icons">&#xE86C;</i><?php echo __('Complete');?></a>
                                   </li>
                                   <%  }else{ %>
                                   <li onclick="milestoneRestore(<%= '\'\',\'' + mdtls.uniq_id + '\'' %>, <%= '\'' + milestonetitle + '\'' %>);"  >
                                       <a href="javascript:jsVoid();" class="mnsm"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
                                   </li>
                                   <%  } %>
                                </ul>
							</span>					   
                            <h5 id="main-title-holder_<%= mdtls.id %>"  class="pad-left" ><a class="ellipsis-view a_act_link_tg" href="<?php echo HTTP_ROOT.'dashboard#kanban/';?><%= mdtls.uniq_id %>"><%= mdtls.title %></a> <div class="a_act_link_tg_dv">(<%= totCase %>)</div><span class="cb"></span></h5>  <!--rel="tooltip" title="<%= mdtls.title %>"-->                         
														<div class="tskgrp_hrs">
															<p>
																<?php echo __('Task Group Est Hr');?>: <strong><%= (mdtls.estimated_hours>0)?mdtls.estimated_hours+" hrs": "NA" %></strong>
															</p>
															<span class="kb_top_icn">
																<a href="javascript:void(0);" onclick="quickEditMilestone('<%= mdtls.id %>');"><i class="material-icons">&#xE254;</i></a>                                
															</span>
                            </div>
                        </div>
                        <div class="form-group label-floating" id="edit-save_<%= mdtls.id %>" style="display:none;width:100%;">
                            <input type="text" class="form-control" data-titl ="<%= mdtls.title %>" data-taskcnt ="<%= totCase %>" id="milstone_edit_<%= mdtls.id %>" value="<%= mdtls.title %>" onblur="return saveMilesatoneTitle(<%= mdtls.id %>);"/>
                        </div>
					<div class="cb"></div>
				</div>
				<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>   
					<div class="add_new_item kb_task_det last_title add_new_item_<%= mdtls.id %>">
						<span class="tgle_addnew tgle_addnew_<%= mdtls.id %>" onclick="show_add_tgle_fld(<%= mdtls.id %>)"><i class="material-icons">&#xE147;</i> <?php echo __('Add Task');?></span>						
						<div class="add_tgle_fld add_tgle_fld_<%= mdtls.id %>">
							<div class="form-group label-floating">
								<label class="control-label" for="add_task_fld"><?php echo __('Enter Task Title');?></label>
								<input data-mid="<%= mdtls.id %>" class="inline_qktask<%= mdtls.id %> in_qt_kanban form-control" type="text" />
							</div>
							<div class="save_cancel_tgle">
								<span>
									<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="AddQuickTask(<%= mdtls.id %>);"><?php echo __('Add');?></a>
								</span>
								<span class="close_tgle" onclick="hide_add_tgle_fld(<%= mdtls.id %>)"><i class="material-icons">&#xE14C;</i></span>
							</div>
						</div>						
					</div>					
				<?php } ?>
				<div class="kban_all_task kanban_content custom_scroll"></div>
				 <?php /* if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
                <div class="kb_task_det last_title">
                    <div class="form-group label-floating">
                      <label class="control-label" for="focusedInput1"><?php echo __('Enter Task Title');?></label>
                      <input data-mid= "<%= mdtls.id %>" class="inline_qktask<%= mdtls.id %> in_qt_kanban form-control" id="focusedInput1" type="text" />
                    </div>
                </div>
				<?php } */ ?>
                </div>
			</div>
	<% 	}}}  %>
<div class="cb"></div>
</div>
</div>
<div class="cb h30"></div>
<% $('#mlist_crt_mlstbtn').show(); %>
<% }else{ %>
<div class="fl col-lg-12 not-fonud ml_not_found no_usr cmn_bdr_shadow">
	<div class="icon_con icon-no-milestone"></div>
	<h2>
		<%
			$('#mlist_crt_mlstbtn').hide();
			if(total_exist){
				if(mile_type == '1'){
		%>
				<?php echo __('No active Task Group');?>
			<% 	}else{ %>
					<?php echo __('No Completed Task Group');?>
			<% 	} %>
		<% }else{ %>
			<?php echo __('No Task Group');?>
		<% } %>
	</h2>
	
</div>
	<?php //echo $this->element('no_data', array('nodata_name' => 'milestonelist','isActive'=>isActive)); ?>
<% } %>
<% if(typeof mile_type == 'undefined' || mile_type == 1){ %>
<div class="crt_task_btn_btm">
    <div class="os_plus">
        <div class="ctask_ttip">
            <span class="label label-default"><?php echo __('Create Task Group');?></span>
        </div>
        <a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Kanban Task Group Page Big Plus\'' %>, <%= '\'Create Task Group\'' %>);addEditMilestone(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>);">
            <i class="material-icons ctask_icn">&#xE065;</i>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
</div>
<% } %>