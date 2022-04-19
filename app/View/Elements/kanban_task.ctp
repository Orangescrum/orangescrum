<style>
.kb_det_icn:hover .material-cnt,.count_knbn{color:#2d6dc4}
.ui-sortable-placeholder {
display: inline-block;
height: 1px;
}
.ui-sortable-helper{
    -ms-transform: rotate(5deg); /* IE 9 */
  -webkit-transform: rotate(5deg); /* Safari prior 9.0 */
  transform: rotate(5deg); /* S
}
body {margin-bottom: 0px;}
</style>
<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<%
var rel_arr = new Array();
%>
<% if(!morecontent){ %>
<div class="row pr" <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>style="margin-top: -28px;"<?php } ?>>
	<div class="pr">
		<div class="page_ttle_toptxt"><?php echo __('Kanban Board');?></div>
		<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
			<?php if($this->Format->displayHelpVideo()){ ?>
				<div class="mtop10 text-right" style="margin-right: 20px;">
					<a href="javascript:void(0);" class="help-video-pop" video-url = "https://www.youtube.com/embed/EeqgtIsatxY" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
				</div>
			<?php } ?>
		<?php }else{ ?>
		<% if($("#projFil").val() !="all"){
			if(mlstId && mlstId!="0"){ %>
		<a href="javascript:void(0)" onclick="reloadKanbanPage(<%= '\'kanban \'' %>)" class="tgkankan" ><i class="material-icons">&#xE862;</i> <?php echo __('Kanban Status');?></a>
		<% }else{ %>
		<a href="<?php echo HTTP_ROOT;?>dashboard#milestonelist" class="tgkankan" ><i class="material-icons">&#xE862;</i> <?php echo __('Task Group View');?></a>
		
		<?php if($this->Format->displayHelpVideo()){ ?>
		<a href="javascript:void(0);" class="help-video-pop" style="position: absolute; top:-12px; right: 212px;" video-url = "https://www.youtube.com/embed/EeqgtIsatxY" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
		<?php } ?>
		<% }
			}%>
          
		<?php } ?>	
        
	</div>
    <div class="view_list_refresh" id="task_view_types" style="padding-right: 20px;margin-top: -20px;">
					<span class="reload_icon">
							<a class="" href="javascript:void(0);" onclick="reloadTasks();">
								<span title="<?php echo __('Reload');?>" rel="tooltip"><i class="material-icons">&#xE5D5;</i></span>
							</a>
					</span>
					 <div class="cb"></div>		
	</div>
	<div style="height:15px;width:100%"></div>
	<% if(mlstId && mlstId!="0"){ %>
    <div class="col-lg-12">
<div class="cmn_bdr_shadow kanban_top_slider">
	<div class="bxslider1">
	<%  var alltotalclosedPercent = Math.round((all_task_cnt_closed/all_task_cnt)*100);
         alltotalclosedPercent = (!isNaN(alltotalclosedPercent))?alltotalclosedPercent:0;
        %>
            <div class="slide knban_prog_box">			
                    <a href="javascript:void(0);" onclick="reloadKanbanPage(<%= '\'all \'' %>);"><div class="kanban_count"><?php echo __('All');?><strong>(<%= all_task_cnt %>)</strong></div></a>
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
                 <a class="dropdown-toggle main_page_menu_togl" href="javascript:void(0);" onclick="openDrpdwn(0,this,1);">
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
			<div class="slide knban_prog_box <% if(mlstId == taskgp.TG.id){%>active<%}%> ">
			 <a class="dropdown-toggle main_page_menu_togl" href="javascript:void(0);" onclick="openDrpdwn(<%= taskgp.TG.id %>,this,1);">
				<i class="material-icons">&#xE5D4;</i>
			</a> 
                    <a href="javascript:void(0);" onclick="reloadKanbanPage(<%= '\'' +  taskgp.TG.uniq_id + '\'' %>);"><div class="kanban_count "><span class="kanban_elipse ellipsis-view" title="<%= taskgp.TG.title %>" rel="tooltip"><%= taskgp.TG.title %></span><strong class="kanban_strong">(<%= totCase %>)</strong></div></a>
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
        <div class="tgle_dropdown_menu" id="tgle_dropdown_menu_0">
		<ul class="dropdown-menu">
			<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
			<li  onclick="creatask(0)" > 
				<a href="javascript:void(0);">
					<i class="material-icons">&#xE03B;</i><?php echo __('Create New Task');?>
				</a>
			</li>	
			<?php } ?>	
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
	<div class="tgle_dropdown_menu" id="tgle_dropdown_menu_<%= taskgp.TG.id %>">
		<ul class="dropdown-menu">
			<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
			<li  onclick="creatask(<%= taskgp.TG.id %>)" > 
				<a href="javascript:void(0);">
					<i class="material-icons">&#xE03B;</i><?php echo __('Create New Task');?>
				</a>
			</li>
		<?php } ?>
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
</div>
<% } %>
</div>
<div class="kanban-auto-scroll">
	

<div class="kanban-main row <% if(mlstId){ %>mtop10<% } %> kanban_mcnt task_grp">
    <%
	}
	var clscnt=1;
	var tasktype_colr = "";
	var tasktype_legend = 0;
	var tasktype_colr_cls = "";
	var proj_with_custom_sts = 0;
	var proj_with_custom_chk = 0;
	/*for(var taskallkey in caseAll){*/
	for(var taskallkey in dynamic_sts_arr){
		var tasklist = new Array();
		var tasktype='';
		tasktype = (typeof dynamic_sts_arr[taskallkey]['name'] != 'undefined')? dynamic_sts_arr[taskallkey]['name']:dynamic_sts_arr[taskallkey];
		if(typeof dynamic_sts_arr[taskallkey]['name'] != 'undefined'){
			proj_with_custom_sts = taskallkey;
			tasktype_colr = (typeof dynamic_sts_arr[taskallkey]['name'] != 'undefined')? dynamic_sts_arr[taskallkey]['color']:"";
			tasktype_legend = 0;
			if(dynamic_sts_arr[taskallkey]['status_master_id'] == 1){
				tasktype_legend = 1;
			}
		}else{
			tasktype_legend = 0;
			if(taskallkey=='kanban_board_1'){
				tasktype_colr_cls= 'newTask';
				tasktype_legend = 1;
			}else if(taskallkey=='kanban_board_2'){
				tasktype_colr_cls= 'inprogressTask';
			}else if(taskallkey=='kanban_board_5'){
				tasktype_colr_cls= 'resolvedTask';
			}else if(taskallkey=='kanban_board_3'){
				tasktype_colr_cls= 'closedTask';
			}
		}
		/*if(taskallkey=='newTask'){tasktype=_('New');}else if(taskallkey=='inprogressTask'){tasktype=_('In Progress');}else if(taskallkey=='resolvedTask'){tasktype=_('Resolved')}else if(taskallkey=='closedTask'){tasktype=_('Closed')};*/
	 if(!morecontent){
	%>
		<div class="kanban-child <% if(mlstId){ %>tsms-autoheight<%}else{%>ts-autoheight<%}%> kanban-<%= clscnt++ %>" id="<%= taskallkey %>" style="width:300px;">
        <div class="kanban_cnt_det">
		<div class="kanban_top_cnt kbhead kbhead_<%= taskallkey %>" <% if(tasktype_colr != ''){ %>style="background-color:#<%=tasktype_colr%>" <% }else if(tasktype_colr_cls == "closedTask"){ %> style="background-color:#72CA8D" <% }else if(tasktype_colr_cls == "resolvedTask"){ %>style="background-color:#FAB858" <% }else if(tasktype_colr_cls == "inprogressTask"){ %> style="background-color:#6BA8DE"<% }else if(tasktype_colr_cls == "newTask"){ %>style="background-color:#F08E83" <% } %>>
            <input type="hidden" name="pages" class="kanban_page_count" value="1" />
            <input type="hidden" name="pages" class="kanban_total_page_count" value="1" />
			<h5 class="<%= tasktype_colr_cls %>" style="cursor:default;">
			<%= tasktype %> (<div style="display:inline;" id="cnter_<%= taskallkey %>">
				<% if(typeof caseAll[taskallkey] != 'undefined'){ %>
				<%= caseAll[taskallkey].length%><% }else{ %>0<% } %>
				</div>) 
				<?php /*<% if(tasktype == 'New' && projUniq !='all'){ %>
				<span class="add_new" rel="tooltip" title="<?php echo __('Add New Task');?>" onClick="setSessionStorage(<%= '\'Kanban Page Small Button\'' %>, <%= '\'Create Task\'' %>);creatask(<%= mlstId %>)"><i class="material-icons">&#xE147;</i></span>
				<% } %> */ ?>
				<span class="cb"></span>
			</h5>
		</div>
		
		<% if(isAllowed('Create Task',projectUniqid)){ %>
			 <% if(tasktype_legend == 1 && !morecontent && proj_with_custom_chk == 0){ proj_with_custom_chk++; %>
				<% if(projUniq !='all' || (mlstId && mlstId!="0")){ %>
					<div class="add_new_item kb_task_det last_title">
						<span class="tgle_addnew" onclick="show_add_tgle_fld()"><i class="material-icons">&#xE147;</i> <?php echo __('Add Task');?></span>						
						<div class="add_tgle_fld">
							<div class="form-group label-floating">
								<label class="control-label" for="add_task_fld"><?php echo __('Enter Task Title');?></label>
								<% if(mlstId && mlstId!="0"){ %>
									<input data-mid="<%= mlstId %>" data-custom-type="<%= proj_with_custom_sts %>" class="inline_qktask<%= mlstId %> in_qt_kanban form-control add_task_fld add_task_fld_kbn custom_task_entry_<%= proj_with_custom_sts %>" type="text" onkeypress="calltoquicktask(<%= mlstId %>,<%= '\'tg\'' %>,event);trackEventWithIntercom(<%= '\'quick task\'' %>,<%= '\'\'' %>);" id="inline_qktask_sts_tg"/>
								<% }else{ %>
										<input data-custom-type="<%= proj_with_custom_sts %>" class="inline_qktask in_qt_kanban_status form-control add_task_fld add_task_fld_kbn custom_task_entry_<%= proj_with_custom_sts %>" id="inline_qktask_sts" type="text" />
								<% } %>								
							</div>
							<div class="save_cancel_tgle">
								<span>
									<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="addQuickTaskBtn(<% if(mlstId && mlstId!="0"){ %><%=mlstId%><%}else{%>0<%}%>);"><?php echo __('Add');?></a>
								</span>
								<span class="close_tgle" onclick="hide_add_tgle_fld()"><i class="material-icons">&#xE14C;</i></span>
							</div>
						</div>						
					</div>					
				<% } %>
			 <% } %>			
		<% } %>
    <div class="kban_all_task kanban_content" id="kanban-short-<%=  tasktype %>" >
	<%	}
			var tasklist = caseAll[taskallkey];
			var count = 0;
			var totids = "";
			var openId = "";
			var pgCaseCnt = countJS(tasklist);
			var caseCount = countJS(tasklist);
				if(caseCount && caseCount != 0){
					var count=0;
					var caseNo = "";
					var chkMstone = "";
					var caseLegend = "";
					var totids = "";
					var projectName ='';var projectUniqid='';
					
			for(var caseKey in tasklist){
				var getdata = tasklist[caseKey];
				count++;
				var caseAutoId = getdata.Easycase.id;
				var isFavourite = getdata.Easycase.isFavourite;
		        var favMessage ="Set favourite task";
		        if(isFavourite){
		            var favMessage ="Remove from the favourite task";
		        }
				var favouriteColor = getdata.Easycase.favouriteColor;
				var caseUniqId = getdata.Easycase.uniq_id;
				var caseSeqId = getdata.Easycase.seq_id;
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
				var showQuickActiononListEdit = 0;
				/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
					var showQuickActiononList = 1;
				}*/
				
				if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
					getTotRep = getdata.Easycase.reply_cnt;
				}
				var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
				if(caseUrl == caseUniqId) {
					openId = count;
				}

				var chkDat = 0;
                if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
                    showQuickActiononList = 1;
                }
                 if(is_active == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
			              showQuickActiononListEdit = 1;
			    }

				if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
					projectName =	getdata.Easycase.pjname;
					projectUniqid = getdata.Easycase.pjUniqid;
				}else if(projUniq!='all'){
					projectName =	getdata.Easycase.pjname;
					projectUniqid = getdata.Easycase.pjUniqid;
				} %>
        <div class="kb_task_det item-<%= caseAutoId %> prioo-bdr-<%= easycase.getPriority(casePriority) %> kbtask_div" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> " data-is-parent="<% if(rel_arr.length && rel_arr.indexOf(caseAutoId) != -1){ %>1<% } %>" data-task-id="<%= caseUniqId %>" data-seq-id = "<%= caseSeqId %>" data-proj-id="<%= projectUniqid%>">
			<!--<div class="fl" rel="tooltip" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %>Updated<% } else { %>Created<% } %> by <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %>on<% } %> <%= getdata.Easycase.updtedCapDt %> "> <%= getdata.Easycase.proImage %></div> -->	
            <span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kanban" rel="tooltip" title="<?php echo __('Priority');?>: <%=  easycase.getPriority(casePriority) %>"></span>
						<div class="top_title_type">
            <h6  id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>line_through<% } %> case_title_<%= caseAutoId %>">
            	<span class="case-title-kbn-<%= caseAutoId %>">
            		<% if(typeof getdata.Easycase.pjsname !='undefined' && getdata.Easycase.pjsname !=""){%><strong><%= getdata.Easycase.pjsname %></strong><%}%>
            		#<%= caseNo %>: <%= caseTitle %></span>
                <span class="rt_icn">
                    <span class="dropdown">
                        <a class="dropdown-toggle main_page_menu_togl" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu addn_menu_drop_pos_kbn">
                        <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
							<% 
							if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
								if(getdata.Easycase.isactive == 1){
                $.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
								if(getdata.Easycase.custom_status_id != data.id){
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
                                <% } %>
                                <% } %>
                                <% } %>
								
								
                                <% if(isAllowed('Create Task',projectUniqid)){ 
                                  	if((getdata.Easycase.is_sub_sub_task==null) || (getdata.Easycase.is_sub_sub_task=='')){ %> 
									
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Create Sub task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
								<% } }%>
								<% if(caseParenId){ %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToParentTask(<%= '\''+ caseAutoId+'\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Convert To Parent Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
                                        </li>
                                      <?php } ?>
									  
									 <% } %>
									 <% if(caseParenId == "" || caseParenId == null){ %>
									 <%	if((getdata.Easycase.sub_sub_task==null) || (getdata.Easycase.sub_sub_task =="") || (getdata.Easycase.sub_sub_task ==0)){  %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Kanban Page\'' %>,<%= '\'Convert To Sub Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
                                        </li>
                                      <?php } ?>
									  
								 <% } } %>
                                <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                        	 	<% if(isAllowed('Manual Time Entry',projectUniqid)){ %>
								<% if(caseLegend == 3){ %>
									<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
										<li onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
											<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
										</li>
									<% } %>
								<% }else{%>
                                <li onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                </li>
                            <% } %>
								<% } %>
                                
                                <?php } ?>
								
									
                                <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                if(getdata.Easycase.isactive == 1){ %>
                                <% if(isAllowed('Reply on Task',projectUniqid)){ %>
                                <li id="bk_act_reply<%= count %>" data-task="<%= caseUniqId %>" onclick="setSessionStorage(<%= '\'Kanban Task Status\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);">
                                        <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE898;</i><?php echo __('Re-open');?></a>
                                        <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                </li>
                            <% } %>
                                <% }
                                if(SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId == SES_ID) || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit )  ) { caseFlag=3; }
                                if(showQuickActiononList == 1 || isAllowed('Edit All Task',projectUniqid)){ %>
                                <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                                <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(caseFlag == 3){ %>display:block <% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                </li>
                            <% } %>
                                <% } 
                                if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){
                                %>
                                <% if(isAllowed('Move to Project',projectUniqid)){ %>
                                <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>" onclick="mvtoProject(<%= '\'' + count + '\'' %>,this)" id="mv_prj<%= caseAutoId %>" style=" ">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                                </li>
                            <% } %>
                                <% } 
                                if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                if(getdata.Easycase.isactive == 1){ %>
                                <% if(isAllowed('Move to Milestone',projectUniqid)){ %>
                                <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                </li>
                                <% } %>
                                <% } %>
                                <% if(getdata.Easycase.isactive == 1){
                                if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
                                caseFlag = "remove";
                                %>
                               <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                                <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                </li>
                            <% } %>
                                <%
                                }
                                }
                                if(SES_TYPE == 1 || SES_TYPE == 2 || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ( SES_ID == caseUserId)) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
                                if(getdata.Easycase.isactive == 1){ %>
                               <% if(isAllowed('Archive Task',projectUniqid) || isAllowed('Archive All Task',projectUniqid)){ %>
                                <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                </li>
                            <% } %>
                                <% }
                                if(SES_TYPE == 1 || SES_TYPE == 2 || (caseLegend == 1  && SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid) ) { caseFlag = "delete"; }
                                if(getdata.Easycase.isactive == 1){ %>
                                <% if(isAllowed('Delete Task',projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
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
                <% if(getdata.Easycase.csTdTyp[1]){ %>
								 <span class="ttype_global tt_<%= getttformats(getdata.Easycase.csTdTyp[1])%>" title="<%= getdata.Easycase.csTdTyp[1] %>"></span>
								<% } %>
                <% if(getdata.Easycase.csDuDtFmt.search("Set Due Dt") >= 0 || getdata.Easycase.csDuDtFmt=='No Due Date' || getdata.Easycase.csDuDtFmt.search("Schedule it") >= 0){%><% } else { %><i class="material-icons" rel="tooltip" title="<%= getdata.Easycase.csDuDtFmtT %>">&#xE878;</i> <% } %>
                <% if(getTotRep && getTotRep!=0) { %><i  class="material-icons material-cnt" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="kanbancasecount<%= count %>" style="cursor:pointer;"<% } %>">&#xE253;</i>
                <span class="count_knbn"><%= getTotRep %><span class="fl case_act_icons task_dependent_block" style="float: none;position: absolute;width: auto;left: 0;right: 0;margin: auto;max-width: 500px;width:500px"></span>
                    <% } %></span>
                <% if(getdata.Easycase.format != 2) { %><span title="files/attachments" class="att_fl" style="    display: inline-block;position: relative;top: 5px;left: 4px;"></span><% } %>					
                <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %><a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" class="recurring-icon" onclick="showRecurringInfo(<%= getdata.Easycase.id %>);"><i class="material-icons">&#xE040;</i></a><% } %>
                <div class="gantt_kanban_depedant_block">
                    <span class="case_act_icons">
                            <% if(getdata.Easycase.children && getdata.Easycase.children != ""){ %>
                            <span class="task_parent_block" id="task_parent_block_<%= getdata.Easycase.uniq_id %>">
                                <div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
                                <div class="dropdown dropup1 open1 showParents">
                                    <ul class="dropdown-menu  bottom_dropdown-caret" style="<% if(getdata.Easycase.depends && getdata.Easycase.depends != ''){ %>left:-30px;<%}else{%>left:-50px;<%}%>">
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
                            <span class="task_dependent_block" id="task_dependent_block_<%= getdata.Easycase.uniq_id %>">
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
            </div>
					</div>
            <% var filesArr = getdata.Easycase.all_files;
                if(filesArr != ''){
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
								<% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                <% if(isAllowed('View File',projectUniqid)){ %>
                <div class="fl atachment_det">
                    <div class="aat_file">
                    	<% if(isAllowed('Download File',projectUniqid)){ %>
                        <div class="file_show_dload">
                            <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= d_name %>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                            <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                        </div>
                        <% } %>
                        <% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                            <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                <img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" src="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;max-height: 120px;" title="<%= d_name %>" alt="Loading image.." />
                            <% }else{ %>
                                <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                            <% } %>
                        <% } else { %>
                            <div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
                        <% } %>
                        <?php /* <div class="file_cnt ellipsis-view"><%= d_name %></div> */ ?>
                    </div>
                </div>
                <% } %>
                <% } %>
                  <% if(isAllowed('View File',projectUniqid)){ %>
                <div class="fl atachment_det parent_other_holder" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> style="display:none;" <% } %>>
                    <div class="aat_file">
                        <div class="file_show_dload">
                            <% if(downloadurl) { %>
                            <% if(isAllowed('Download File',projectUniqid)){ %>
                            <a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                            <% } %>
                            <% } else {%>
                             <% if(isAllowed('Download File',projectUniqid)){ %>
                            <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                            <% } %>
                            <% } %>
                        </div>
                        <% if(downloadurl) { %>
                         <% if(isAllowed('Download File',projectUniqid)){ %>
                            <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                        <% } %>
                        <% }else{ %>
                            <% if(getFiles.CaseFile.is_ImgFileExt){ %>
                             <% if(isAllowed('View File',projectUniqid)){ %>
                            <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                            <% } %>
                            <%  } else{ %>
                             <% if(isAllowed('View File',projectUniqid)){ %>
                            <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                            <% } %>
                        <% } %>
                        <% } %>
                        <?php /* <div class="file_cnt ellipsis-view"><%= d_name %></div> */ ?>
                    </div>
                </div>
                <% } %>
                <% } %>
            </div>
            <div class="cb"></div>
            <% } %>
            <div class="kb_task_status">
                <?php /* <div class="fl">
                    <span class="prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_kb_sts" rel="tooltip" title="Priority: <%=  easycase.getPriority(casePriority) %>"><% var prity = easycase.getPriority(casePriority); if(prity == 'low'){ %>L<% }else if(prity == 'medium'){ %>M<% }else{ %>H<% } %></span>
                </div> */ ?>
                <div class="kb_task_hrs fl">
									<% if(getdata.Easycase.estimated_hours != '0' && getdata.Easycase.estimated_hours != ''){ %>
									<span>
										<?php echo __('Est Hr');?>: <%= format_time_min(getdata.Easycase.estimated_hours) %>
									</span>	
									<% } %>
									<% if(getdata.Easycase.spent_hrs != '0' && getdata.Easycase.spent_hrs != ''){ %>
									<span>
										<?php echo __('Spent Hr');?>: <%= format_time_min(getdata.Easycase.spent_hrs) %>
									</span>
									<% } %>
                </div> 
               <?php /*<div class="kb_icons">
                    <% var caseFlag=""; 					
                    if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                    if(getdata.Easycase.isactive == 1){ 
                    if(caseFlag == 2){ %>
                    <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
						<% if(typeof customStatusByProject[getdata.Easycase.project_id] !='undefined'){ }else{ %>
                        <span rel="tooltip" title="<?php echo __('Resolve');?>" onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_resolve fl"><i class="material-icons">&#xE153;</i></span>
                    <% } } %>
                    <% } }
                    if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4 || caseLegend == 5) && caseTypeId != 10) { caseFlag=5; }
                    if(getdata.Easycase.isactive == 1){ 
                    if(caseFlag == 5) {	%>
                    <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
						<% if(typeof customStatusByProject[getdata.Easycase.project_id] !='undefined'){ %>
							<% if(isAllowed("Status change except Close",projectUniqid)){ %>
							<span rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);" class="case_act_icons task_title_icons_close fl"><i class="material-icons">&#xE876;</i></span>
							<% } %>
						<% }else{ %>
							<% if(isAllowed('Status change except Close',projectUniqid)){ %>	
                            <span rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_close fl"><i class="material-icons">&#xE876;</i></span>
							<% } %>
					<% } } %>
                    <% } } %>					
                    <% if(isAllowed('Manual Time Entry',projectUniqid)){ %>			
                    <span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Kanban Task Status Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"><i class="material-icons">&#xE8B5;</i></span>
                <% } %>
                    <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                    if(getdata.Easycase.isactive == 1){ %>                    
                    <% if(isAllowed('Reply on Task',projectUniqid)){ %>	                    
                        <span rel="tooltip" <% if(caseFlag == 7){ %>title="<?php echo __('Re-open');?>"<% } else { %>title="<?php echo __('Reply');?>"<% } %> data-task="<%= caseUniqId %>" id="bk_act_reply_spn<%= count %>" class="case_act_icons task_title_icons_reply fl" onclick="setSessionStorage(<%= '\'Kanban Task Status\'' %>, <%= '\'Reply Task\'' %>);replyFromKanban(this);">
						 <% if(caseFlag == 7){ %><i class="material-icons">&#xE898;</i><% }else{ %><i class="material-icons">&#xE15E;</i> <% } %></span>
                    <% } %>
                    <% }
                    if( SES_ID == caseUserId) { caseFlag=3; }
                    if(getdata.Easycase.isactive == 1){ 
                    if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %>
                    <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                        <span rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" class="case_act_icons task_title_icons_edit fl"><i class="material-icons">&#xE254;</i></span>
                    <% } %>
                    <% } } %>									           
                    <%
                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
                    if(getdata.Easycase.isactive == 1){ 
                    if(caseFlag == "archive"){ %>
                    <% if(isAllowed('Archive Task',projectUniqid) || isAllowed('Archive All Task',projectUniqid)){ %>
                        <span rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" class="case_act_icons task_title_icons_archive fl"><i class="material-icons">&#xE149;</i></span>
                    <% } %>
                    <% } }
                    if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                    if(getdata.Easycase.isactive == 1){ 
                    if(caseFlag == "delete"){ %>
                    <% if(isAllowed('Delete Task',projectUniqid) || isAllowed('Delete All Task',projectUniqid)){ %>
                        <span rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" class="case_act_icons task_title_icons_delete fl"><i class="material-icons">&#xE872;</i></span>
                    <% } %>
                    <% } } %>
                </div> */?>
								<div class="fr fav_assign_kb_task">
									<% if(getdata.Easycase.asgnShortName) { %>
									<span class="assi_tlist" title="<?php echo __('Assigned to');?> <%if(getdata.Easycase.asgnShortName.search("me") != -1){ %><%= $(getdata.Easycase.asgnShortName).text() %><%}else{%><%= getdata.Easycase.asgnShortName %><% } %>">
											<i class="material-icons">&#xE7FD;</i><%= getdata.Easycase.asgnShortName %>
									</span>
									<% } %>
									<span title="<%=favMessage%>" id="kanbanDivFav<%=caseAutoId %>">
                	<% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>
                    <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,3,<%=isFavourite%>)"  rel="tooltip" original-title="<%=favMessage%>" style="margin-top:0px;color:<%=favouriteColor%>;" > <% if(isFavourite) { %>
		                <i class="material-icons" style="color:<%=favouriteColor%>;">star</i>
		            <% }else{ %>
		                 <i class="material-icons">star_border</i>
		            <% } %>
            		</a>
            	<% } %>
									</span>
                </div>
                <div class="cb"></div>
            </div>
			<?php /* <div class="fl title_wd">
				<!--<div id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="fl case-title <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %> ellipsis-view" style="max-width: 170px;">--> 
				<div id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="fl case-title">

                	<span class="case_title wrapword">
                    <span class="<% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %>">#<%= caseNo %>: <%= caseTitle %></span>
                    &nbsp;
					<% if(getdata.Easycase.csTdTyp[1]){ %><span class="tag_kanban" rel="tooltip" title="<%= getdata.Easycase.csTdTyp[1] %>"></span><% } %>
                    <% if(getdata.Easycase.csDuDtFmt.search("Set Due Dt") >= 0 || getdata.Easycase.csDuDtFmt=='No Due Date'){%><% } else { %><span class="dt-icon" rel="tooltip" title="<%= getdata.Easycase.csDuDtFmtT %>"><a href=""></a></span><% } %>
                    <% if(getTotRep && getTotRep!=0) { %><span class="bblecnt2"></span><span class="count_knbn" style="top:-1px;position: relative;font-size: 11px !important;padding-left: 2px;"><%= getTotRep %><% } %></span>
					<% if(getdata.Easycase.format != 2) { %><span title="files/attachments" class="att_fl" style="    display: inline-block;position: relative;top: 5px;left: 4px;"></span><% } %>					
                    <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %><span class="task_title_icons_reoccurrence" rel="tooltip" title="Recurring Task"></span><% } %>
					</span>
                </div>
				<!--<div class="fr" <% if(!getTotRep || getTotRep==0) { %> style="display:none" <% } %>>
				<div id="repno<%= count %>" class="fl bblecnt2"></div>
				<span class="count_knbn"> &nbsp;<% if(getTotRep && getTotRep!=0) { %><%= getTotRep %><% } %></span>
			</div>-->
			</div>
			<div class="cb"></div> */ ?>

			<div class="cb"></div>
            </div>
						<%
				totids += caseAutoId + "|";
                            }	
                        }  %>
		</div>
    <% if(isAllowed('Create Task',projectUniqid)){ %>
        <% if(tasktype_legend == 1 && !morecontent){%>
        <% if(mlstId && mlstId!="0"){ %>
          <?php /*<div class="kb_task_det last_title">
            <div class="form-group label-floating">
              <label class="control-label" for="focusedInput1"><?php echo __('Enter Task Title');?></label>
              <input data-mid= "<%= mlstId %>" class="inline_qktask<%= mlstId %> in_qt_kanban form-control"  type="text" onkeypress="calltoquicktask(<%= mlstId %>,<%= '\'tg\'' %>,event);trackEventWithIntercom(<%= '\'quick task\'' %>,<%= '\'\'' %>);"/>
            </div>
        </div>*/?>
        <% }else{ %>
		<% if(projUniq !='all'){ %>
        <?php /*
				<div class="kb_task_det last_title">
            <div class="form-group label-floating">
              <label class="control-label" for="inline_qktask_sts"><?php echo __('Enter Task Title');?></label>
              <input  class="inline_qktask in_qt_kanban_status form-control" id="inline_qktask_sts" type="text" />
            </div>
        </div>
				*/ ?>
        <% } %>
        <% } %>
        <% } %>
        <% } %>
	<% if(!morecontent){%>
	<div id="loader_<%= taskallkey %>" style="text-align:center;font-size:12px;display:none;"><img src="<?php echo HTTP_ROOT;?>img/images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/><br/><?php echo __('Loading');?>...</div>
	</div>
<% } %>
</div>
<% } %>
	
<% if(!morecontent){%>
<?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
<% if(projUniq !='all'){ %>
<% if(typeof customStatusByProject !="undefined" && customStatusByProject.length != 0){ %>
<div class="create_new_status_kanban">
	<?php
	if($this->Format->isTimesheetOn(5) && $this->Format->isLifeFreeUser()){ ?>
	<a href="javascript:void(0)" class="btn btn_cmn_efect" rel="tooltip" onclick="createStatusNewKbn(<%= curProjStsGroup%>);" title="<?php echo __("Create New Status");?>">
		 + <?php echo __("Add another status");?>              
	</a>
	<?php }else{ ?>
	 <a onclick="showUpgradPopup(0,0,0,1);" href="javascript:void(0);">
		 <?php echo __('Status Workflow Setting');?> <?php echo $this->Format->getlockIcon(1); ?>
	 </a> 
	<?php } ?>
</div>
<% } %>
<% } %>
<?php } ?>

</div>
</div>
<div class="crt_task_btn_btm">
	<% if(isAllowed('Create Task',projectUniqid)){ %>
    <div class="os_plus">
        <div class="ctask_ttip">
            <span class="label label-default"><?php echo __('Create Task');?></span>
        </div>
        <a href="javascript:void(0)" <% if(mlstId){ %>onclick="setSessionStorage(<%= '\'Kanban Page Big Plus Button\'' %>, <%= '\'Create Task\'' %>);creatask(<%= mlstId %>);"<% }else{ %>onclick="setSessionStorage(<%= '\'Kanban Page Big Plus Button\'' %>, <%= '\'Create Task\'' %>);creatask();"<% } %>>
            <img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
            <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
        </a>
    </div>
<% } %>
</div>
<div class="cb h30"></div>
<input type="hidden" id="newTask_limit" value="<%= newTask_limit %>" />
<input type="hidden" id="inProgressTask_limit" value="<%= inProgressTask_limit %>" />
<input type="hidden" id="resolvedTask_limit" value="<%= resolvedTask_limit %>" />
<input type="hidden" id="closedTask_limit" value="<%= closedTask_limit %>" />
<% } %>