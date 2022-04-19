<% if(casePage == 1){ %>
<style>
.task_listing table.table td.attach-file-comment:hover,.attach-file-comment:hover a .material-icons{color:#2d6dc4}
</style>
<?php if (defined("RELEASE_V") && RELEASE_V) { ?>
<div class="slide_switch_container pr d-flex">
<?php echo $this->element('milestone_list_view'); ?>
<div class="task_listing subtask_listing task-grouping-page task_subtask_group_listing switch_listing">	
	<div id="widgethideshow" class="fl task-list-progress-bar fix-status-widget pr">
		<span id="task_count_of" style="float:left;display:block;"></span>
		<span class="pr fl inner_search_span" onclick="slider_inner_search(<%= '\'open\'' %>);">   
			<i class="material-icons clear_close_icon" title="<?php echo __('Clear search');?>" id="clear_close_icon" onclick="clearSearch(<%= '\'inner\'' %>);">close</i>
				<i class="inner_search_icon material-icons">&#xE8B6;</i>
			 <input type="text" name="search_inner" id="inner-search" placeholder="<?php echo __('Search');?>" class="inner-search" value="<%=caseSrch%>" />
			 <img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="loading" title="<?php echo __('loading');?>" id="srch_inner_load1">
			 <div id="ajax_inner_search" class="ajx-srch-inner-dv1"></div>
		</span>				 
		<div class="view_list_refresh" id="task_view_types">                                      
			<span class="reload_icon">
				<a class="" href="javascript:void(0);" onclick="reloadTasks();">
					<span title="<?php echo __('Reload');?>" rel="tooltip"><i class="material-icons">&#xE5D5;</i></span>
				</a>
			</span>
			<div class="cb"></div>		
		</div> 
		<span id="ajaxCaseStatus" style="float:right;margin-top:7px; margin-right:-10px;"></span>
		<div class="cb"></div>					
	</div>
	
	<div class="milestone_filter_active">
		<div class="mil_title"><?php echo __('Task Group'); ?>: <span id="milestone_filter_active_name"></span></div> <div class="reset_mil"><i class="material-icons" rel="tooltip" title="Reset" onclick="clearSubtakMilFiletr();">close</i></div>
	</div>
	
	<div class="task-m-overflow cstm_responsive_tbl min-height-400">
		<table class="table table-striped table-hover subtsk_list_tbl">
			<thead>
				<tr>
					<th class="porl checkbox_th wth_1">
						<div class="pr">
							<div class="checkbox">
								<label>
									<input type="checkbox" value="" class="chkAllTsk" id="chkAllTsk">
								</label>
							</div>
							<div class="drop_th_ttl">								
								<span class="dropdown custom_th_drdown">
									<a class="dropdown-toggle mass_action_dpdwn" data-toggle="dropdown" href="javascript:void(0);">
											<i title="Choose at least one task" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>
									</a>
									<ul class="dropdown-menu" id="dropdown_menu_chk">
									 <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
									 <% if(typeof curProjId != "undefined" && typeof curProjId != "null" &&  typeof customStatusByProject !="undefined" && typeof customStatusByProject[curProjId] !='undefined' && customStatusByProject[curProjId] != null){
										 $.each(customStatusByProject[curProjId], function (key, data) {
											%>
											<% if(data.status_master_id == 3){ %>
																				<% if(isAllowed("Status change except Close",projUniq)){ %>
											<li onclick="multipleCustomAction(<%= '\'' + data.id + '\'' %>, <%= '\'' + escape(data.name) + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>);" id="sts_custm_<%= data.id %>">
											<a href="javascript:void(0);">
											<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span>
											<%= data.name %></a>	
											</li>
											<% } %>
										<% }else{ %>
											<li onclick="multipleCustomAction(<%= '\'' + data.id + '\'' %>, <%= '\'' + escape(data.name) + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>);" id="sts_custm_<%= data.id %>">
												<a href="javascript:void(0);">
												<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span>
												<%= data.name %>
												</a>  
											</li>
										<% } %>
									<% }); %>
							<% }else{ %>
								<li>
										<a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseNew\'' %>)"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
								</li>
								<li>
										<a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseStart\'' %>)"><i class="material-icons">&#xE039;</i><?php echo __('Start');?></a>
								</li>
								<li>
											<a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseResolve\'' %>)"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
								</li>
									 <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
									<li>
											<a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i><?php echo __('Close');?></a>
									</li>  
									<?php } ?>
							<% } %>
						<?php } ?>			
						 <?php if($this->Format->isAllowed('Move to Project',$roleAccess)){ ?>
							<li id="mvTaskToProj">
									<a href="javascript:void(0);" onclick="mvtoProject( <%= '\' \'' %> , <%= '\' \'' %> , <%= '\'movetop\'' %> )"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to project');?></a>
							</li>
						<?php } ?>
						 <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li id="cpTaskToProj">							
									<a href="javascript:void(0);" onclick="cptoProject( <%= '\' \'' %> , <%= '\' \'' %> , <%= '\'movetop\'' %> )"><i class="material-icons">&#xE14D;</i><?php echo __('Copy to Project');?></a>
							</li>
						<?php } ?>
						<?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
						<li id="mvTskToTgrp">
							<a href="javascript:void(0);" onclick="moveTaskToTaskGroup(<%= '\'all\'' %>);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
						</li>
					 <?php } ?>
					 <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
						<li id="crtProjTmpl">							
								<a href="javascript:void(0);" onclick="createPojectTemplate( <%= '\' \'' %> , <%= '\' \'' %> , <%= '\'movetop\'' %> )"><i class="material-icons">&#xE8F1;</i><?php echo __('Create Project Plan');?></a>
						</li>
					<?php }  ?>
					<?php if (SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Archive All Task',$roleAccess)) { ?>
						<?php //if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
							<li>
									<a href="javascript:void(0);" onclick="archiveCase( <%= '\'all\'' %> )"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
							</li>
						<?php //} ?>
					<?php } ?>
					<?php if (SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Delete All Task',$roleAccess)) { ?>
						<li id="delAllTsks">
								<a href="javascript:void(0);" onclick="DeleteAllCase( <%= '\'all\'' %> )"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
						</li>
					<?php } ?>														
				</ul>
				</span>
			</div>
		</div>
		</th>
		<th class="wth_2"></th>
		<th class="wth_2">
			<a href="javascript:void(0);" title="<?php echo __('Task');?>#"  class="sortcaseno" <?php /* onclick=" ajaxSorting( <%= '\'caseno\', ' + caseCount + ', this' %> );" */?> >
				#<?php /* <span class="sorting_arw"><% if(typeof csNum != 'undefined' && csNum != "") { %>
						<% if(csNum == 'asc'){ %>
						<i class="material-icons tsk_asc">&#xE5CE;</i>
						<% }else{ %>
						<i class="material-icons tsk_desc">&#xE5CF;</i>
						<% } %>								
						<% }else{ %>
						<i class="material-icons">&#xE164;</i>
						<% } %></span>		*/?>						
			</a>
		</th>												 
		<th class="wth_4">   
				<span id="shortingByTitle" class="dropdown" style="display: inline;">
				<a class="sorttitle" href="javascript:void(0);" title="<?php echo __('Title');?>">
						<?php echo __('Title');?>
						<?php /* <span class="sorting_arw"><% if((typeof csTtl != 'undefined' && csTtl != "") || (typeof getCookie('TASKSORTBY2')!='undefined')) { %>
								<% if(csTtl2 == 'asc' || csTtl == 'asc'){ %>
								<i class="material-icons tsk_asc">&#xE5CE;</i>
								<% }else{ %>
								<i class="material-icons tsk_desc">&#xE5CF;</i>
								<% } %>								
								<% }else{ %>
								<i class="material-icons">&#xE164;</i>
								<% } %></span> */ ?>
				</a>
			</span>
		</th>
		<th class="wth_3"></th>  
			<?php /* <th class="wth_5"></th> */?>
		<th class="width_assign wth_6">                  
			<a class="sortcaseAt" href="javascript:void(0);" title="<?php echo __('Assigned to');?>" <?php /* onclick="ajaxSorting( <%= '\'caseAt\', ' + caseCount + ', this' %> );" */?> >
					<?php echo __('Assigned to');?>
				<?php /*  <span class="sorting_arw"><% if(typeof csAtSrt != 'undefined' && csAtSrt != "") { %>
							<% if(csAtSrt == 'asc'){ %>
							<i class="material-icons tsk_asc">&#xE5CE;</i>
							<% }else{ %>
							<i class="material-icons tsk_desc">&#xE5CF;</i>
							<% } %>								
							<% }else{ %>
							<i class="material-icons">&#xE164;</i>
							<% } %></span> */ ?>
			</a>                  
		</th>				
		<th class="tsk_est_hours wth_7 text-center">
			<a class="sortestimatedhours" href="javascript:void(0);" title="<?php echo __('Est. Hours');?>" <?php /*onclick="ajaxSorting( <%= '\'estimatedhours\', ' + caseCount + ', this' %> );" */?> >
					<?php echo __('Est. Hours');?>
				<?php /*  <span class="sorting_arw">
				<% if(typeof csEstHrsSrt != 'undefined' && csEstHrsSrt != "") { %>
												<% if(csEstHrsSrt == 'asc'){ %>
													<i class="material-icons tsk_asc">&#xE5CE;</i>
										<% }else{ %>
													<i class="material-icons tsk_desc">&#xE5CF;</i>
												<% } %>								
											<% }else{ %>
												<i class="material-icons">&#xE164;</i>
											<% } %>
				</span> */ ?>
			</a>
		</th>
		<th class="width_status text-center wth_9"><?php echo __('Status');?></th>
		<th class="tsk_due_dt wth_10">
			<a class="sortduedate" href="javascript:void(0);" title="<?php echo __('Due Date');?>" <?php /* onclick="ajaxSorting( <%= '\'duedate\', ' + caseCount + ', this' %> );" */?>>
					<?php echo __('Due Date');?>
				 <?php /* <span class="sorting_arw"><% if(typeof csDuDt != 'undefined' && csDuDt != "") { %>
					<% if(csDuDt == 'asc'){ %>
					<i class="material-icons tsk_asc">&#xE5CE;</i>
					<% }else{ %>
					<i class="material-icons tsk_desc">&#xE5CF;</i>
					<% } %>								
					<% }else{ %>
					<i class="material-icons">&#xE164;</i>
					<% } %></span> */?>
			</a>
		</th>
		<th class="width_progress text-center wth_7">
			<span class="progresselipsis"><?php echo __('Progress');?></span>
		</th>	 
		</tr>
	</thead>
	<tbody id="subtaskListBody">
<% } %>	

<?php if (defined("RELEASE_V") && RELEASE_V) { ?>
<?php $dues_date_qt_top = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date"); ?>
<%

var rel_arr = new Array();
var d_mid = mid; 
if(d_mid == "NA"){ d_mid = 0;}
%>
<% if(casePage == 1){ %>
<% if(d_mid == 0 || d_mid != 0){ %>
    <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
     <% if(projUniq != "all"){ %>                      
                    <tr class="qtask quicktsk_tr_lnk qtsksbtsk" id="quicktsk_tr_lnk_<%= mid %>">
                          <td colspan="10">
                              <div class="new_qktask_mc">
                                  <div class="new_grp_tsk" id="new_task_label_<%= mid %>" style="width: 130px;"><a href="javascript:void(0)" class="cmn-bxs-btn" onclick="showhideqt(<%= mid %>);"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task');?></a></div>
                              </div>                               
                          </td>
                    </tr>
                    <tr class="quicktsk_tr task_list_page qtsksbtsk" id="quicktsk_tr_<%= mid %>">
						<td colspan="12" class="quicktd_task">
							<div class="col-md-3 form-group label-floating fl">
							  <div class="input-group">
									<label class="control-label" for="addon3a"><?php echo __('Task Title');?></label>
									<input class="form-control inline_qktask<%= mid %>" type="text" id="inline_qktask_<%= mid %>" >									
                            </div>
                    </div>
              <div class="col-md-2 form-group label-floating fl stop-floating-top qt_form-group <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> no-pointer <?php } ?>" style="width: 13%;">
								<label class="control-label multilang_ellipsis" for="qt_due_dat_<%= mid %>" title="<?php echo __('Due Date');?>"><?php echo __('Due Date');?></label>
								<?php $dues_date_qt_top = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date"); ?>
								
								 <input class="form-control" type="text" name="qt_due_dat" id="qt_due_dat_<%= mid %>" readonly ="readonly" placeholder="Ex. <?php echo date('M d, Y', strtotime($dues_date_qt_top)) ;?>"> 		
								<?php //echo $this->Form->text('qt_due_dat', array('value' => '', 'class' => 'form-control', 'id' => 'qt_due_dat_<%= mid %>','readonly'=>'readonly','placeholder'=>'Ex. '.date('M d, Y', strtotime(date())))); ?>
								<div class="cmn_help_select"></div>
								<a href="javascript:void(0);" class="onboard_help_anchor" 
								onclick="openHelpWindow(<%= '\'https://helpdesk.orangescrum.com/cloud/create-quick-task/<?= HELPDESK_URL_PARAM ?>#due_date\'' %>)"
								title="<?php echo __("Get quick help on Due Date");?>" rel="tooltip"><i class="material-icons">&#xE8FD;</i></a>
							</div>
              <div class="col-md-2 padrht-non cstm-drop-pad qt_dropdown task_type qt_tsk_type_dropdown <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> no-pointer <?php } ?>" >
								
								<select class="tsktyp-select form-control task_type floating-label" placeholder="<?php echo __('Task Type');?>" data-dynamic-opts=true id="qt_task_type_<%= mid %>">
								<%
								var select_task_type_qt = '';
								for(var k in GLOBALS_TYPE) {
                if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == PROJECTS_ID_MAP[$('#projFil').val()]){
									var v = GLOBALS_TYPE[k];
									var t = v.Type.id;
									var t1 = v.Type.short_name;
									var t2 = v.Type.name;
									var txs_typ = t2;
									var check_sel = '';
									if(select_task_type_qt == ''){
									select_task_type_qt = v.Type.name;
									}
									if(defaultTaskType != "" && defaultTaskType == v.Type.id){ 
										check_sel = "selected"; 
										select_task_type_qt = v.Type.name;
									}
								%>
									<option value="<%= v.Type.id %>" <%= check_sel %>><%= v.Type.name %></option>
								<%	
                }								
								}
								%>
								</select>
								<div class="cmn_help_select"></div>
								<a href="javascript:void(0);" class="onboard_help_anchor mtop12" 
															onclick="openHelpWindow(<%= '\'https://helpdesk.orangescrum.com/cloud/create-quick-task/#task_type\'' %>);" 
															title="<?php echo __("Get quick help on Task Type");?>" rel="tooltip"><i class="material-icons">&#xE8FD;</i></a>
							</div>
							
              <div class="col-md-1 form-group label-floating fl stop-floating-top qt_form-group <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> no-pointer <?php } ?>" id="qt_story_point_container_<%= mid %>" style="<% if(select_task_type_qt != 'Story'){ %> display:none;<%}%>">
								<label class="control-label" for="qt_story_point"><?php echo __('Story Point');?></label>
								<input class="form-control qt_story_point_<%= mid %>" type="number" id="qt_story_point_<%= mid %>" >
								<?php //echo $this->Form->text('qt_story_point', array('value' => 0, 'class' => 'form-control check_minute_range', 'id' => 'qt_story_point', 'maxlength' => '4','type'=>'number','min'=>"0", "onkeypress"=>"return numeric_only(event)")); ?>
							</div>
							
              <div class="col-md-1 padrht-non custom-task-fld task-type-fld labl-rt cstm-drop-pad qt_dropdown <?php if(!$this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> no-pointer <?php } ?> qt_dropdown_assn" style="width:15%;">
								<select class="form-control floating-label" placeholder="<?php echo __('Assign To');?>" data-dynamic-opts=true onchange="changeTypeId(this)" id="quick-assign_<%= mid %>">
								<% for(var qtk in QTAssigns){
									var check_sel = '';
									var user_nm_me = '<?php echo __('Me');?>';
									if(SES_TYPE >=3 && SES_ID == QTAssigns[qtk].id){ 
										check_sel = "selected"; 
										}else if(defaultAssign && QTAssigns[qtk].id == defaultAssign){ 
											check_sel = "selected"; 
										}
									%>
									<option value="<%= QTAssigns[qtk].id %>" <%= check_sel %>><% if(SES_ID == QTAssigns[qtk].id){ %><%= user_nm_me %><% }else{ %><%= QTAssigns[qtk].name %><% } %></option>
								<% } %>
								<option value="0"><?php echo __('Unassigned');?></option>
								</select>
							</div>
              <div class="col-md-1 form-group label-floating fl stop-floating-top qt_form-group <?php if(!$this->Format->isAllowed('Est Hours',$roleAccess)){ ?> no-pointer <?php } ?>">
								<label class="control-label" for="qt_estimated_hours"><?php echo __('Est. Hour');?></label>
								<?php /*<span class="os_sprite est-hrs-icon" style="top:8px;"></span> */?>
								
								  <input class="form-control qt_estimated_hours<%= mid %>" placeholder = "hh:mm" type="text" id="qt_estimated_hours_<%= mid %>" onkeypress = "return numeric_decimal_colon(event)">
								<?php //echo $this->Form->text('qt_estimated_hours', array('value' => '', 'placeholder' => 'hh:mm', 'class' => 'form-control check_minute_range', 'id' => 'qt_estimated_hours', 'maxlength' => '5', 'onkeypress' => 'return numeric_decimal_colon(event)')); ?>
							</div>	
							<div class="quicktask_save_exit_btn">	
								<div class="btn-group save_exit_btn">
								<input type="hidden" value="list" id="task_view_types_span" />
								<a id="quickcase_qt" href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="setSessionStorage(<%= '\'Task List Quick Task\'' %>, <%= '\'Create Task\'' %>); AddnewQuickTask(<%= mid %>,<%= '\'qtg\'' %>);"><?php echo __('Save');?></a>
								
							</div>
							<span class="input-group-btn ds_ib_btn">
							  <a href="javascript:void(0);" onclick="blurqktask_qt_tg(<%= mid %>);">
									<?php echo __('Cancel');?>
							  </a>								  
							</span>
            </div>
							<div class="cb"></div>
            </td>
    </tr>
    <% } %>
<?php } ?>
<% } %>
<% } %>

<% var subTaskPname = ""; 
var count = 0;
var count1= 0;
var count2 = 0;
var projectUniqid = projUniq ;
if(resCaseProj.length >0){ %>
	<% var sindex = 0;
		for (var key in resCaseProj) { 
			if(sindex == page_limit){ <?php /* //changed 20 to 5 */ ?>  
				break;	
			}
			Easycase= resCaseProj[key]['Easycase'];
			CustomStatus = resCaseProj[key]['CustomStatus'];
			caseAutoId=Easycase['id'];
			var isFavourite = Easycase['isFavourite'];
			var favMessage ="Set favourite task";
			if(isFavourite){
				var favMessage ="Remove from the favourite task";
			}
			var favouriteColor = Easycase['favouriteColor'];
			projId=Easycase['project_id'];
			
			caseLegend = Easycase['custom_status_id'] != 0 ? Easycase['custom_status_id'] : Easycase['legend'];
			caseTypeId=Easycase['type_id'];
			caseNo = Easycase['case_no'];
			caseUniqId =Easycase['uniq_id'];
			caseUserId = Easycase['user_id'];
			casePriority = Easycase['priority'];
			caseFormat = Easycase['format'];
			caseTitle = Easycase['title'];
			caseEstHoursRAW = Easycase['estimated_hours'];
			
			isactive = Easycase['isactive'];
			caseAssgnUid = Easycase['assign_to'];
			is_recurring=Easycase['is_recurring'];
			var showQuickActiononList = 0;
			var showQuickActiononListEdit = 0;
			if(isactive == 1 && (caseLegend != max_custom_status) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
				showQuickActiononList = 1;
			}
			var showQuickActiononCopy = 0;
			if(isactive == 1 && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
				showQuickActiononCopy = 1;
			}
			if(isactive == 1 && (caseLegend != max_custom_status) && (caseUserId== SES_ID)){
				showQuickActiononListEdit = 1;
			}
		
			csTdTyp=resCaseProj[key]['Type']['name']; 
			csDueDate=Easycase['csDueDate'];
			csDuDtFmt=Easycase['csDuDtFmt'];
			csDuDtFmtT=Easycase['csDuDtFmtT'];
			count++;
					sindex++;
						 if (resCaseProj.hasOwnProperty(key)) { 
						 var getdata = resCaseProj[key]; 
			 %>
               <tr class="row_tr tr_all trans_row parent_tr " id="curRow_subtask_<%= getdata.Easycase.id %>" data-mid="<%= d_mid %>">
               <td class="check_list_task tsk_fst_td pr_low">
                  <div class="checkbox">     
                     <label>   
                     <% if(getdata.Easycase.legend != 3 && getdata.Easycase.type_id != 10) { %>
                        <input type="checkbox" style="cursor:pointer" id="actionChk<%= getdata.Easycase.id %>" value="<%= getdata.Easycase.id + '|' + getdata.Easycase.case_no + '|' + getdata.Easycase.uniq_id %>" class="fl mglt chkOneTsk">
                        <% } else if(getdata.Easycase.type_id != 10) { %>
                        <input type="checkbox" id="actionChk<%= getdata.Easycase.id %>" checked="checked" value="<%= getdata.Easycase.id + '|' + getdata.Easycase.case_no + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } else { %>
                        <input type="checkbox" id="actionChk<%= getdata.Easycase.id %>" checked="checked" value="<%= getdata.Easycase.id + '|' + getdata.Easycase.case_no + '|update' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } %>  
                     </label>   
                  </div>
                  <input type="hidden" id="actionCls<%= getdata.Easycase.id %>" value="1" disabled="disabled" size="2">     
				<div class="check-drop-icon hover-effect">
                     <div class="dropdown"> 
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu tsg_chng_action_menu hover-block">
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
                            if(getdata.CustomStatus.status_master_id != 3){ %>
                                <li onclick="setCustomStatus(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= getdata.Easycase.id %>">
                           <a href="javascript:void(0);">
                                <span style="background-color:#<%= lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
                                <%= lastCustomStatus.LastCS.name %></a>	
                           </li>
                           <%   } 
                           } else{ %>
                          <% var caseFlag="";
                              if((getdata.Easycase.legend != 3) && getdata.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>);" id="close<%= getdata.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
					  <% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									if(caseLegend != max_custom_status && caseTypeId != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Create Sub task\'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } %>
                          <% } %>
						  <%	if(getdata.Easycase.sub_sub_task == 0){  %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Convert To Sub Task\'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
                                        </li>
                                      <?php } ?>
									  
									  <% }  %>
						<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                            <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
								<% if(caseLegend == max_custom_status){ %>
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
						<% if(caseLegend == max_custom_status) { caseFlag= 7; } else { caseFlag= 8; }
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
                         <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononCopy){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                          </li> 
                          <% } %>
                         
                        <% } %>
						<% if((caseLegend != max_custom_status) && caseTypeId!= 10) { caseFlag=2; }
                        if((SES_TYPE == 1 || SES_TYPE == 2) || (((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (caseLegend != max_custom_status)) &&  (SES_ID == caseUserId))){ %>
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
                  <%= getdata.Easycase.case_no %>   <span class="watch showtime_<%= getdata.Easycase.id %>"></span>  
               </td>
               
               <td class="relative list-cont-td label_task_tle" id="tour_task_title_listing"> 
				<?php /*
                  <span class="ttype_global tt_<%= getttformats(getdata.Type.name)%>"></span> 
					*/ ?>
                  <%
                   var priorClass = 'prio_low';
                    if(getdata.Easycase.priority == 1){
                        priorClass = 'prio_medium';
                     }else if(getdata.Easycase.priority == 0){
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
                  <div class="ttl_listing" data-task-id="<%= getdata.Easycase.uniq_id %>">
                  <a href="javascript:void(0);" class="titlehtml" data-task="<%= getdata.Easycase.uniq_id %>">
                     <span class="case-title_<%= getdata.Easycase.id %> case_sub_task <% if(getdata.Easycase.type_id!=10 && (getdata.Easycase.legend == max_custom_status || getdata.Easycase.custom_status_id == max_custom_status)) { %>closed_tsk<% } %>">
                        <span class="max_width_tsk_title ellipsis-view <% if(getdata.Easycase.legend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(getdata.Easycase.title && getdata.Easycase.title.length>100){%>overme<% }%> " title="<%= formatText(ucfirst(getdata.Easycase.title)) %>  ">
                           <%= formatText(ucfirst(getdata.Easycase.title)) %>
                        </span>
                     </span>
                  </a>   
                  
                  <div class="list-td-hover-cont">
                    <?php /*<span class="created-txt"><% if(getdata.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.User.name %> <?php echo __('on');?> <%= moment(getdata.Easycase.dt_created).format("LLLL") %></span>*/?>
                    <span class="created-txt"><% if(getdata.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %>  <?php echo __('on');?> <%= moment(getdata.Easycase.dt_created).format("lll") %></span>
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
                             if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == getdata.Easycase.project_id){
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
					
					<div class="subcls_rcrng fr">
					<% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
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
                     <% if(!getdata.AssignTo.photo){ getdata.AssignTo.photo = 'user.png'; } %>
                     <% var usr_name_fst = (getdata.AssignTo.name != null)?getdata.AssignTo.name:"<?php echo __("Unassigned");?>"; %>
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
                  <p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblists <?php } ?> estblist_subtask" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> id="est_blist_sub<%= getdata.Easycase.id %>" case-id-val="<%= getdata.Easycase.id %>">    
                     <span class="border_dashed_subtask">
                        <%= format_time_hr_min(getdata.Easycase.estimated_hours) %>
                     </span>   
                  </p> 
					<% var est_time = Math.floor(caseEstHoursRAW/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
				
				<input type="text" data-est-id="<%=caseAutoId%>" data-est-no="<%=caseNo%>" data-est-uniq="<%=caseUniqId%>" data-est-time="<%=est_time%>" id="est_hr_sub_list<%=caseAutoId%>" class="est_hr_sub_list form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can enter time as 1.5(that mean 1 hour and 30 minutes)');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
				
				<span id="estlod<%=caseAutoId%>" style="display:none;margin-left:0px;">
					<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>				  
               </td>            
               <td class="text-center"> 
									<div class="cs_select_dropdown">
                  <span id="csStsRep_sub<%= getdata.Easycase.id %>" class="cs_select_status">
                     <% if(getdata.Easycase.isactive==0){ %>
                        <div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
                     <%}else {
                       if(getdata.Easycase.custom_status_id != 0 && getdata.CustomStatus != null ){ %>
                        <%= easycase.getCustomStatus(getdata.CustomStatus, getdata.Easycase.custom_status_id) %>
                     <% }else{ %>
                       <%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
                      <% }
                      } %>
                  </span>
				    <span class="check-drop-icon dsp-block">
						<span class="dropdown">
							<a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
							  <i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu">
							<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
                           $.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
                           if(getdata.CustomStatus.id != data.id){
                           %>
                      <% if(data.status_master_id == 3){ %>
                        <% if(isAllowed("Status change except Close",getdata.Project.uniq_id)){ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                      <% }else{ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                           <%   } 
                           }); 
                           } else{ %>
                          <% var caseFlag="";
                              if(getdata.Easycase.legend != 1 && getdata.Easycase.type_id != 10){ caseFlag=9; }
                              if(getdata.Easycase.isactive == 1){ %>
                              <li onclick="setNewCase(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>);" id="new<%= getdata.Easycase.id %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                              </li>
                              <% }
                              if((getdata.Easycase.legend != 2 && getdata.Easycase.legend != 4) && getdata.Easycase.type_id!= 10) { caseFlag=1; }
                                                  if(getdata.Easycase.isactive == 1) { %>
                              <li onclick="startCase(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>);" id="start<%= getdata.Easycase.id %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(getdata.Easycase.legend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
                              </li>
                              <% }
                                                  if((getdata.Easycase.legend != 5) && getdata.Easycase.type_id!= 10) { caseFlag=2; }
                                                  if(getdata.Easycase.isactive == 1){ %>
                              <li onclick="caseResolve(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>);" id="resolve<%= getdata.Easycase.id %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                              </li>
                              <% }
                              if((getdata.Easycase.legend != 3) && getdata.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata.Easycase.id + '\'' %>, <%= '\'' + getdata.Easycase.case_no + '\'' %>, <%= '\'' + getdata.Easycase.uniq_id + '\'' %>);" id="close<%= getdata.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
							</ul>
						</span>
					</span>
						</div>
               </td>
               <td class="due_dt_tlist text-center">
			   <div class="<% if(csDueDate == '' || caseLegend == 5 || caseTypeId == 10 || caseLegend == 3){ %> toggle_due_dt <% } %>">
                <% if(isactive == 1){ %>
                <% if(showQuickActiononList && caseTypeId != 10){ %>
				<?php /*
                <span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
				*/?>
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
                <div class="overdueby_spns overdueby_spn_<%= caseAutoId %>"><% if(showQuickActiononList){ %><%= getdata.Easycase.csDuDtFmtBy %><% } %></div> 
               </td> 
                 <td class="due_dt_tlist text-center">
                 <%= (getdata.Easycase.completed_task)?getdata.Easycase.completed_task :"0" %> %
               </td>             
            </tr>
            <% 
            if(getdata.children.length) {
             var childe = getdata.children;
                  for (var key1 in childe) {
					  Easycase1= childe[key1]['Easycase'];
				CustomStatus1 = childe[key1]['CustomStatus'];
				caseAutoId1=Easycase1['id'];
				var isFavourite1 = Easycase1['isFavourite'];
				var favMessage1 ="Set favourite task";
				if(isFavourite1){
					var favMessage1 ="Remove from the favourite task";
				}
				var favouriteColor1 = Easycase1['favouriteColor'];

			
				projId1=Easycase1['project_id'];
			
				caseLegend1 = Easycase1['custom_status_id'] != 0 ? Easycase1['custom_status_id'] : Easycase1['legend'];
				caseTypeId1=Easycase1['type_id'];
				caseNo1 = Easycase1['case_no'];
				caseUniqId1 =Easycase1['uniq_id'];
				caseUserId1= Easycase1['user_id'];
				casePriority1 = Easycase1['priority'];
				caseFormat1 = Easycase1['format'];
				caseTitle1 = Easycase1['title'];
				caseEstHoursRAW1 = Easycase1['estimated_hours'];
				
				isactive1 = Easycase1['isactive'];
				caseAssgnUid1 = Easycase1['assign_to'];
				is_recurring1=Easycase1['is_recurring'];
				csTdTyp1=childe[key1]['Type']['name'];
				csDueDate1=Easycase1['csDueDate'];
				csDuDtFmt1=Easycase1['csDuDtFmt'];
				csDuDtFmtT1=Easycase1['csDuDtFmtT'];
				count1++;
				var showQuickActiononList1 = 0;
				var showQuickActiononListEdit1 = 0;
				if(isactive1 == 1 && (caseLegend1 != max_custom_status) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
					showQuickActiononList1 = 1;
				}
				var showQuickActiononCopy1 = 0;
				if(isactive1 == 1 && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
					showQuickActiononCopy1 = 1;
				}
				if(isactive1 == 1 && (caseLegend1 != max_custom_status) && (caseUserId1 == SES_ID)){
					showQuickActiononListEdit1 = 1;
				}
                     if (childe.hasOwnProperty(key1)) { 
                        var getdata1 = childe[key1]; %>  
                        <tr class="row_tr tr_all trans_row child_task_tr" id="curRow_subtask_<%= getdata1.Easycase.id %>" data-mid="<%= d_mid %>">
               <td class="check_list_task tsk_fst_td pr_low text-left">
                  <div class="checkbox">     
                     <label>  
                       <% if(getdata1.Easycase.legend != 3 && getdata1.Easycase.type_id != 10) { %>
                        <input type="checkbox" style="cursor:pointer" id="actionChk<%= getdata1.Easycase.id %>" value="<%= getdata1.Easycase.id + '|' + getdata1.Easycase.case_no + '|' + getdata1.Easycase.uniq_id %>" class="fl mglt chkOneTsk">
                        <% } else if(getdata1.Easycase.type_id != 10) { %>
                        <input type="checkbox" id="actionChk<%= getdata1.Easycase.id %>" checked="checked" value="<%= getdata1.Easycase.id + '|' + getdata1.Easycase.case_no + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } else { %>
                        <input type="checkbox" id="actionChk<%= getdata1.Easycase.id %>" checked="checked" value="<%= getdata1.Easycase.id + '|' + getdata1.Easycase.case_no + '|update' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } %> 
                     </label>   
                  </div>
                  <input type="hidden" id="actionCls<%= getdata1.Easycase.id %>" value="1" disabled="disabled" size="2"> 
					<div class="check-drop-icon">
                     <div class="dropdown"> 
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu tsg_chng_action_menu">
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata1.Easycase.project_id] !='undefined' && customStatusByProject[getdata1.Easycase.project_id] != null){
                            if(getdata1.CustomStatus.status_master_id != 3){ %>
                                <li onclick="setCustomStatus(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= getdata1.Easycase.id %>">
                           <a href="javascript:void(0);">
                                <span style="background-color:#<%= lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
                                <%= lastCustomStatus.LastCS.name %></a>	
                           </li>
                           <%   } 
                           } else{ %>
                          <% var caseFlag="";
                              if((getdata1.Easycase.legend != 3) && getdata1.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata1.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata1.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>);" id="close<%= getdata1.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
					  <% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									if(caseLegend1 != max_custom_status && caseTypeId1 != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata1.Easycase.id + '\'' %>,<%= '\'' + getdata1.Easycase.project_id + '\'' %>,<%= '\'' + getdata1.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata1.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\' Create Sub task \'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } %>
                          <% } %>
						  
						  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li onclick="convertToParentTask(<%= '\''+ caseAutoId1+'\',\''+caseNo1+'\'' %>);trackEventLeadTracker(<%= '\' Convert To Parent Task \'' %>,<%= '\'Sub task view Page\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToTask<%= caseAutoId1 %>" style=" <% if(showQuickActiononList1){ %>display:block <% } else { %>display:none<% } %>">
								  <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
							</li>
						  <?php } ?>
						<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                            <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
								<% if(caseLegend1 == max_custom_status){ %>
									<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
									<li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle1, 3)) + '\'' %> );" class="anchor">
										<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
									</li>
									<% } %>
								<% } else { %>
                            <li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle1, 3)) + '\'' %> );" class="anchor">
                                <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                            </li>
                            <% } %>
                            <% } %>
                            
                        <?php } ?>
						<% if(caseLegend1 == max_custom_status) { caseFlag1= 7; } else { caseFlag1= 8; }
                        if(isactive == 1){ %>
                         <% if(isAllowed("Reply on Task",projectUniqid)){ %> 
                        <li id="subact_replys<%= count1 %>" data-task="<%= caseUniqId1 %>" page-refer-val="Task Group List Pages">
                            <a href="javascript:void(0);" id="reopen<%= caseAutoId1 %>" style="<% if(caseFlag1 == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="<?php echo __('Re-open');?>"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>

                            <a href="javascript:void(0);" id="reply<%= caseAutoId1 %>" style="<% if(caseFlag1 == 8){ %>display:block <% } else { %>display:none<% } %>">
                                <i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                        </li>
                        <% } %>
                        <% } %>
						<% if( SES_ID == caseUserId1) { caseFlag2=3; }
                        if(isactive1 == 1){ %> 
                        <% if(showQuickActiononList1 || isAllowed("Edit All Task",projectUniqid)){ %> 
                        <% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit2) || isAllowed("Edit All Task",projectUniqid)){ %> 
                         <li onclick="editask(<%= '\''+ caseUniqId1+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId1 %>" style=" <% if(showQuickActiononList1 || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit1) ){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                          </li> 
                          <% } %>  
                          <% } %>  
                          <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> 
                         <li onclick="copytask(<%= '\''+ caseUniqId1+'\',\''+ caseAutoId1+'\',\''+caseNo1+'\',\''+projId1+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId1 %>" style=" <% if(showQuickActiononCopy1){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                          </li> 
                          <% } %>
                         
                        <% } %>
						<% if((caseLegend1 != max_custom_status) && caseTypeId1!= 10) { caseFlag2=2; }
                        if((SES_TYPE == 1 || SES_TYPE == 2) || (((caseLegend1 == 1 || caseLegend1 == 2 || caseLegend1 == 4) || (caseLegend1 != max_custom_status)) &&  (SES_ID == caseUserId1))){ %>
                        <% if(isactive1 == 1){ %>
                         <% if(isAllowed("Move to Project",projectUniqid)){ %> 
                        <li data-prjid="<%= projId1 %>" data-caseid="<%= caseAutoId1 %>" data-caseno="<%= caseNo1 %>"  id="mv_prj<%= caseAutoId1 %>" style=" " onclick="mvtoProject( <%= '\'' + count1 + '\'' %> , this);">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% } %>
                       <% if(isactive1 == 1){ %>
                         <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                        <li onclick="moveTask( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + caseNo1 + '\'' %> , <%= '\'\'' %> , <%= '\'' + projId1 + '\'' %> );" id="moveTask<%= caseAutoId1 %>" style=" <% if(caseFlag1 == 2){ %> display:block <% } else { %> display:block <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                        </li>
                        <% } %>
                        <% } %>
                             <% if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId1) || isAllowed("Archive All Task",projectUniqid)) { caseFlag1 = "archive"; }
                        if(isactive1 == 1){ %>
                        <% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
                        <li onclick="archiveCase( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + caseNo1 + '\'' %> , <%= '\'' + projId1 + '\'' %> , <%= '\'t_' + caseUniqId1 + '\'' %> );" id="arch<%= caseAutoId1 %>" style="<% if(caseFlag1 == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                        </li>
                        <% } %>
                        <% } %>	
						<%	if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId1) || isAllowed("Delete All Task",projectUniqid)) { caseFlag1 = "delete"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
                        <li onclick="deleteCase( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + caseNo1 + '\'' %> , <%= '\'' + projId1 + '\'' %> , <%= '\'t_' + caseUniqId1 + '\'' %> , <%= '\'' + is_recurring1 + '\'' %>);" id="arch<%= caseAutoId1 %>" style="<% if(caseFlag1 == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                        </li>
                        <% } %>						
                        <% } %>						
                        </ul>
                     </div>
					 </div>
               </td>
			   <td class="favo-td">
					<span id="caseProjectSpanFav<%=caseAutoId1 %>">
						<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId1 %>,<%=projId1 %>,<%= '\''+caseUniqId1+'\'' %>,1,<%=isFavourite1%>)"  rel="tooltip" original-title="<%=favMessage1%>" style="margin-top:0px;color:<%=favouriteColor1%>;" >
						<% if(isFavourite1) { %>
							<i class="material-icons" style="font-size:18px;">star</i>
						<% }else{ %>
							 <i class="material-icons" style="font-size:18px;">star_border</i>
						<% } %>
						</a>
					</span>
				</td>
               <td class="text-left count-plist-drop pr">
                  <%= getdata1.Easycase.case_no %>   <span class="watch showtime_<%= getdata1.Easycase.id %>"></span>   
                  
               </td>
               <td class="text-left relative list-cont-td label_task_tle" id="tour_task_title_listing">
				<?php /*			   
                  <span class="ttype_global tt_<%= getttformats(getdata1.Type.name)%>"></span>  
					*/?>				  
                  <%
                   var priorClass = 'prio_low';
                    if(getdata1.Easycase.priority == 1){
                        priorClass = 'prio_medium';
                     }else if(getdata1.Easycase.priority == 0){
                     priorClass = 'prio_high';
                  }
                  %>
                  <div style="" id="pridiv<%= caseAutoId1 %>" class="pri_actions <% if(showQuickActiononList1){ %> dropdown<% } %>"> 
					<div class="dropdown cmn_h_det_arrow">
						<div <% if(showQuickActiononList1){ %> class="quick_action" <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> data-toggle="dropdown" <% } %> <% } %> style="cursor:pointer"><span class=" priority <%= priorClass %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>"></span><% if(showQuickActiononList1){ %> <i class="tsk-dtail-drop material-icons">&#xE5C5;</i> <% } %> </div>
                    <% var csLgndRep1 = caseLegend1; %>
                    <% if(showQuickActiononList1){ %>
                    <ul class="dropdown-menu quick_menu">
                        <li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId1 + '\', \'2\', \'' + caseUniqId1 + '\', \'' + caseNo1 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
                        <li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId1 + '\', \'1\', \'' + caseUniqId1 + '\', \'' + caseNo1 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
                        <li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId1 + '\', \'0\', \'' + caseUniqId1 + '\', \'' + caseNo1 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
                    </ul>
                    <% } %>
					</div>					
				</div>					
                 <span id="prilod<%= caseAutoId1 %>" style="display:none">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>
                  <div class="ttl_listing" data-task-id="<%= getdata1.Easycase.uniq_id %>">
                  <a href="javascript:void(0);" class="titlehtml" data-task="<%= getdata1.Easycase.uniq_id %>">
                       <span class="case-title_<%= getdata1.Easycase.id %> case_sub_task <% if(getdata1.Easycase.type_id!=10 && (getdata1.Easycase.legend == max_custom_status || getdata1.Easycase.custom_status_id == max_custom_status)) { %>closed_tsk<% } %>">
                        <span class="max_width_tsk_title ellipsis-view <% if(getdata1.Easycase.legend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(getdata1.Easycase.title && getdata1.Easycase.title.length>100){%>overme<% }%> " title="<%= formatText(ucfirst(getdata1.Easycase.title)) %>  ">
                           <%= formatText(ucfirst(getdata1.Easycase.title)) %>
                        </span>
                     </span>
                  </a>   
                  
                  <div class="list-td-hover-cont">
                     <?php /* <span class="created-txt"><% if(getdata1.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata1.User.name %> <?php echo __('on');?> <%= moment(getdata1.Easycase.dt_created).format("LLLL") %></span> */ ?>
                     <span class="created-txt"><% if(getdata1.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %>  <?php echo __('on');?> <%= moment(getdata1.Easycase.dt_created).format("lll") %></span>
					<span class="list-devlop-txt dropdown">
                    <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                        <i class="material-icons tag_fl">&#xE54E;</i>
                        <span id="showUpdStatus<%= caseAutoId1 %>" class="<% if(showQuickActiononList1 && isactive1 == 1){ %>clsptr<% } %>" title="<%= csTdTyp1 %>" >
                          <span class="tsktype_colr" id="tsktype<%= caseAutoId1 %>"><%= csTdTyp1 %><span class="due_dt_icn"></span>
                          </span> 
                          </span> 
                    </a>				
                    <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
						<span id="typlod<%= caseAutoId1 %>" class="type_loader">
                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
						</span>
                        <% if(showQuickActiononList1 && isactive1 == 1){ %>
                        <ul class="dropdown-menu listgrp-bug-dropdn">
                            <li>
                                     <input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="seachitems(this);" />
                                 </li>	
                            <%
                            for(var k in GLOBALS_TYPE) {
                             if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == getdata1.Easycase.project_id){
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
                            <li onclick="changeCaseType( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + caseNo1 + '\'' %> ); changestatus( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + t + '\'' %> , <%= '\'' + t1 + '\'' %> , <%= '\'' + t2 + '\'' %> , <%= '\'' + caseUniqId1 + '\'' %> )">
                                <a href="javascript:void(0);">
								 <span class="ttype_global tt_<%= getttformats(t2)%>"><%= t2 %></span>
                                </a>
                            </li>
                            <% } } %>
                        </ul>					
                        <% } %>
                    </span>
                </span>
				</div>
				<div class="task_dependancy_item">
					<div class="task_dependancy fr">
						<% if(getdata1.Easycase.children && getdata1.Easycase.children != ""){ %>
							<span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId1 %>">
								<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + caseAutoId1 + '\'' %>,<%= '\'' + caseUniqId1 + '\'' %>,<%= '\'' + getdata1.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
								<div class="dropdown dropup fl1 open1 showParents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
										<li>
											<ul class="task_parent_items" id="task_parent_<%= caseUniqId1 %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
						<% if(getdata1.Easycase.depends && getdata1.Easycase.depends != ""){ %>
							<span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId1 %>">
								<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + caseAutoId1 + '\'' %>,<%= '\'' + caseUniqId1 + '\'' %>,<%= '\'' + getdata1.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
								<div class="dropdown dropup fl1 open1 showDependents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>".</li>
										<li>
											<ul class="task_dependent_items" id="task_dependent_<%= caseUniqId1 %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
					</div>
					
					<div class="subcls_rcrng fr">
					<% if(getdata1.Easycase.is_recurring == 1 || getdata1.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId1 %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
            <% } %>
					</div> 
					<div class="cb"></div>
					
				</div>
				<?php /*
				<% if(getdata1.Easycase.is_recurring == 1 || getdata1.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId1 %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
            <% } %>
				*/ ?>  
               </div>
               </td>
               <td class="attach-file-comment text-center">  
                  <a href="javascript:void(0);" style="display:none;" id="fileattch1">   <i class="glyphicon glyphicon-paperclip"></i>  </a>    <a href="javascript:void(0)" id="repno1" style="display:none">   <i class="material-icons"></i>  </a> 
               </td>              
              <td class="assi_tlist">
                  <div class="user-task-pf">
                     <% if(!getdata1.AssignTo.photo){ getdata1.AssignTo.photo = 'user.png'; } %>
                     <% var usr_name_fst = (getdata1.AssignTo.name != null)?getdata1.AssignTo.name:"<?php echo __("Unassigned");?>"; %>
					<i class="material-icons">&#xE7FD;</i>			
						<% if((projUniq != 'all') && showQuickActiononList1){ %>
						<span id="showUpdAssign<%= caseAutoId1 %>" <% if(isAllowed("Change Assigned to",projectUniqid)){ %> data-toggle="dropdown" <% } %>title="<%= usr_name_fst %>" class="clsptr" onclick="displayAssignToMem( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + projUniq + '\'' %> , <%= '\'' + caseAssgnUid1 + '\'' %> , <%= '\'' + caseUniqId1 + '\'' %> )"><%= usr_name_fst %><span class="due_dt_icn"></span></span>
						<% } else { %>
						<span id="showUpdAssign<%= caseAutoId1 %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= usr_name_fst %></span>
						<% } %>
                   <% if((projUniq != "all") && showQuickActiononList1){ %>
					<span id="asgnlod<%= caseAutoId1 %>" class="asgn_loader">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
					</span>
					<% } %>			
					<span class="check-drop-icon dsp-block" <% if((projUniq != "all") && showQuickActiononList1){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId1 + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid1 + '\'' %>,<%= '\'' + caseUniqId1 + '\'' %>)" <% } %>>
						  <span class="dropdown">
							<a class="dropdown-toggle" <% if(isAllowed("Change Assigned to",projectUniqid)){ %> data-toggle="<% if((projUniq != "all") && showQuickActiononList1){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
								<i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem<%= caseAutoId1 %>">
								<li class="text-centre"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="assgnload<%= caseAutoId1 %>" /></li>
							</ul>
						</span>
					</span>          
                 </div> 
               </td>     
              <td class="esthrs_dt_tlist text-center">
                  <p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblists <?php } ?> estblist_subtask" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> id="est_blist_sub<%= getdata1.Easycase.id %>" case-id-val="<%= getdata1.Easycase.id %>">    
                     <span class="border_dashed_subtask">
                        <%= format_time_hr_min(getdata1.Easycase.estimated_hours) %>
                     </span>   
                  </p> 
					<% var est_time = Math.floor(caseEstHoursRAW1/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
				
				<input type="text" data-est-id="<%=caseAutoId1%>" data-est-no="<%=caseNo1%>" data-est-uniq="<%=caseUniqId1%>" data-est-time="<%=est_time%>" id="est_hr_sub_list<%=caseAutoId1%>" class="est_hr_sub_list form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can enter time as 1.5(that mean 1 hour and 30 minutes)');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
				
				<span id="estsublod<%=caseAutoId1%>" style="display:none;margin-left:0px;">
					<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>	
               </td>            
                <td class="text-center"> 
									<div class="cs_select_dropdown">
                  <span id="csStsRep_sub<%= getdata1.Easycase.id %>" class="cs_select_status">
                     <% if(getdata1.Easycase.isactive==0){ %>
                        <div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
                     <%}else {
                       if(getdata1.Easycase.custom_status_id != 0 && getdata1.CustomStatus != null ){ %>
                        <%= easycase.getCustomStatus(getdata1.CustomStatus, getdata1.Easycase.custom_status_id) %>
                     <% }else{ %>
                       <%= easycase.getStatus(getdata1.Easycase.type_id, getdata1.Easycase.legend) %>
                      <% }
                      } %>
                  </span>
                    <span class="check-drop-icon dsp-block">
						<span class="dropdown">
							<a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
							  <i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu">
                            <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata1.Easycase.project_id] !='undefined' && customStatusByProject[getdata1.Easycase.project_id] != null){
                           $.each(customStatusByProject[getdata1.Easycase.project_id], function (key, data) {
                           if(getdata1.CustomStatus.id != data.id){
                           %>
                      <% if(data.status_master_id == 3){ %>
                        <% if(isAllowed("Status change except Close",getdata1.Project.uniq_id)){ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata1.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                      <% }else{ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata1.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                           <%   } 
                           }); 
                           } else{ %>
                          <% var caseFlag="";
                              if(getdata1.Easycase.legend != 1 && getdata1.Easycase.type_id != 10){ caseFlag=9; }
                              if(getdata1.Easycase.isactive == 1){ %>
                              <li onclick="setNewCase(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>);" id="new<%= getdata1.Easycase.id %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                              </li>
                              <% }
                              if((getdata1.Easycase.legend != 2 && getdata1.Easycase.legend != 4) && getdata1.Easycase.type_id!= 10) { caseFlag=1; }
                                                  if(getdata1.Easycase.isactive == 1) { %>
                              <li onclick="startCase(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>);" id="start<%= getdata1.Easycase.id %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(getdata1.Easycase.legend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
                              </li>
                              <% }
                                                  if((getdata1.Easycase.legend != 5) && getdata1.Easycase.type_id!= 10) { caseFlag=2; }
                                                  if(getdata1.Easycase.isactive == 1){ %>
                              <li onclick="caseResolve(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>);" id="resolve<%= getdata.Easycase.id %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                              </li>
                              <% }
                              if((getdata1.Easycase.legend != 3) && getdata1.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata1.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata1.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata1.Easycase.id + '\'' %>, <%= '\'' + getdata1.Easycase.case_no + '\'' %>, <%= '\'' + getdata1.Easycase.uniq_id + '\'' %>);" id="close<%= getdata1.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
                            </ul>
                        </span>
                    </span>
                    </div>
               </td>
               <td class="due_dt_tlist text-center">
                 <div class="<% if(csDueDate1 == '' || caseLegend1 == 5 || caseTypeId1 == 10 || caseLegend1 == 3){ %> toggle_due_dt <% } %>">
                <% if(isactive == 1){ %>
                <% if(showQuickActiononList1 && caseTypeId1 != 10){ %>
				<?php /*
                <span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList1){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
				*/ ?>
                <% } %>
                <span class="show_dt" id="showUpdDueDate<%= caseAutoId1 %>" title="<%= csDuDtFmtT1 %>">
                    <%= csDuDtFmt1 %>
                </span>
                <span id="datelod<%= caseAutoId1 %>" class="asgn_loader">
                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                </span>
                <% } %>
                <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Update Task Duedate',projectUniqid)){ %> data-toggle="<% if(showQuickActiononList1){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="pop_arrow_new"></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId1 + '\'' %> , <%= '\'' + caseNo1 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId1 + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId1 + '\'' %> )"><?php echo __('No Due Date');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId1 + '\', \'' + caseNo1 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId1 + '\', \'' + mdyCurCrtd + '\', \'Today\', \'' + caseUniqId1 + '\'' %> )"><?php echo __('Today');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId1+ '\', \'' + caseNo1 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId1 + '\', \'' + mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId1 + '\'' %> )"><?php echo __('Tomorrow');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId1 + '\', \'' + caseNo1 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId1 + '\', \'' + mdyMonday + '\', \'Next Monday\', \'' + caseUniqId1 + '\'' %> )"><?php echo __('Next Monday');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId1 + '\', \'' + caseNo1 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId1 + '\', \'' + mdyFriday + '\', \'This Friday\', \'' + caseUniqId1 + '\'' %> )"><?php echo __('This Friday');?></a></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="cstm-dt-option-dtpik prtl">
                                        <div class="cstm-dt-option" data-csatid="<%= caseAutoId1 %>" style="position:absolute; left:0px; top:0px; z-index:99999999;">
                                            <input data-csatid="<%= caseAutoId1 %>" value="" type="text" id="set_due_date_<%= caseAutoId1 %>" class="set_due_date hide_corsor" title="<?php echo __('Custom Date');?>" style="background:none; border:0px;"/>	
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
			<div class="overdueby_spns overdueby_spn_<%= caseAutoId1 %>"><% if(showQuickActiononList1){ %><%= getdata1.Easycase.csDuDtFmtBy %><% } %></div> 
               </td>  
                <td class="due_dt_tlist text-center">
                 <%= (getdata1.Easycase.completed_task)?getdata1.Easycase.completed_task :"0" %> %
               </td>        
            </tr>
            <% 
            if(getdata1.children.length) {
             var childe1 = getdata1.children;
                  for (var key2 in childe1) {
					    Easycase2= childe1[key2]['Easycase'];
				CustomStatus2 = childe1[key2]['CustomStatus'];
				caseAutoId2=Easycase2['id'];
				var isFavourite2 = Easycase2['isFavourite'];
				var favMessage2 ="Set favourite task";
				if(isFavourite2){
					var favMessage2 ="Remove from the favourite task";
				}
				var favouriteColor2 = Easycase2['favouriteColor'];

			
				projId2=Easycase2['project_id'];
				
				caseLegend2 = Easycase2['custom_status_id'] != 0 ? Easycase2['custom_status_id'] : Easycase2['legend'];
				caseTypeId2=Easycase2['type_id'];
				caseNo2 = Easycase2['case_no'];
				caseUniqId2 =Easycase2['uniq_id'];
				caseUserId2 = Easycase2['user_id'];
				casePriority2 = Easycase2['priority'];
				caseFormat2 = Easycase2['format'];
				caseTitle2 = Easycase2['title'];
				caseEstHoursRAW2 = Easycase2['estimated_hours'];
				
				isactive2 = Easycase2['isactive'];
				caseAssgnUid2 = Easycase2['assign_to'];
				is_recurring2=Easycase2['is_recurring'];
				csTdTyp2=childe1[key2]['Type']['name'];
				csDueDate2=Easycase1['csDueDate'];
				csDuDtFmt2=Easycase1['csDuDtFmt'];
				csDuDtFmtT2=Easycase1['csDuDtFmtT'];
				count2++;
				var showQuickActiononList2 = 0;
				var showQuickActiononListEdit2 = 0;
				if(isactive2 == 1 && (caseLegend2 != max_custom_status) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
					showQuickActiononList2 = 1;
				}
				var showQuickActiononCopy2 = 0;
				if(isactive2 == 1 && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
					showQuickActiononCopy2 = 1;
				}
				if(isactive2 == 1 && (caseLegend2 != max_custom_status) && (caseUserId2 == SES_ID)){
					showQuickActiononListEdit2 = 1;
				}
                     if (childe1.hasOwnProperty(key2)) { 
                        var getdata2 = childe1[key2]; %> 
                        <tr class="row_tr tr_all trans_row sub_child_task_tr " id="curRow_subtask_<%= getdata2.Easycase.id %>" data-mid="<%= d_mid %>">
               <td class="check_list_task tsk_fst_td pr_low text-left">
                  <div class="checkbox">     
                     <label>  
                     <% if(getdata2.Easycase.legend != 3 && getdata2.Easycase.type_id != 10) { %>
                        <input type="checkbox" style="cursor:pointer" id="actionChk<%= getdata2.Easycase.id %>" value="<%= getdata2.Easycase.id + '|' + getdata2.Easycase.case_no + '|' + getdata2.Easycase.uniq_id %>" class="fl mglt chkOneTsk">
                        <% } else if(getdata2.Easycase.type_id != 10) { %>
                        <input type="checkbox" id="actionChk<%= getdata2.Easycase.id %>" checked="checked" value="<%= getdata2.Easycase.id + '|' + getdata2.Easycase.case_no + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } else { %>
                        <input type="checkbox" id="actionChk<%= getdata2.Easycase.id %>" checked="checked" value="<%= getdata2.Easycase.id + '|' + getdata2.Easycase.case_no + '|update' %>" disabled="disabled" class="fl mglt chkOneTsk">
                        <% } %>       
                        
                     </label>   
                  </div>
                  <input type="hidden" id="actionCls<%= getdata2.Easycase.id %>" value="1" disabled="disabled" size="2">
									<div class="check-drop-icon">
                     <div class="dropdown"> 
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                          <i class="material-icons">&#xE5D4;</i>
                        </a>
                        <ul class="dropdown-menu tsg_chng_action_menu">
                      <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata2.Easycase.project_id] !='undefined' && customStatusByProject[getdata2.Easycase.project_id] != null){
                            if(getdata2.CustomStatus.status_master_id != 3){ %>
                                <li onclick="setCustomStatus(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= getdata2.Easycase.id %>">
                           <a href="javascript:void(0);">
                                <span style="background-color:#<%= lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
                                <%= lastCustomStatus.LastCS.name %></a>	
                           </li>
                           <%   } 
                           } else{ %>
                          <% var caseFlag="";
                              if((getdata2.Easycase.legend != 3) && getdata2.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata2.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata2.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>);" id="close<%= getdata2.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
					  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToParentTask(<%= '\''+ caseAutoId2+'\',\''+caseNo2+'\'' %>);" id="convertToTask<%= caseAutoId2 %>" style=" <% if(showQuickActiononList2){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
                                        </li>
                                      <?php } ?>
						<?php if ($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN) { ?>
                            <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
								<% if(caseLegend2 == max_custom_status){ %>
									<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %> 
										<li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle2, 3)) + '\'' %> );" class="anchor">
											<a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
										</li>
									<% } %>
								<% } else{ %>
                            <li onclick="setSessionStorage(<%= '\'Task Groups List Page\'' %>, <%= '\'Time Log\'' %>);createlog( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + escape(htmlspecialchars(caseTitle2, 3)) + '\'' %> );" class="anchor">
                                <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                            </li>
                            <% } %>
                            <% } %>
                            
                        <?php } ?>
						<% if(caseLegend2 == max_custom_status) { caseFlag2= 7; } else { caseFlag2= 8; }
                        if(isactive2 == 1){ %>
                         <% if(isAllowed("Reply on Task",projectUniqid)){ %> 
                        <li id="subact_replys<%= count2 %>" data-task="<%= caseUniqId2 %>" page-refer-val="Task Group List Pages">
                            <a href="javascript:void(0);" id="reopen<%= caseAutoId2 %>" style="<% if(caseFlag2 == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="<?php echo __('Re-open');?>"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>

                            <a href="javascript:void(0);" id="reply<%= caseAutoId2 %>" style="<% if(caseFlag2 == 8){ %>display:block <% } else { %>display:none<% } %>">
                                <i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                        </li>
                        <% } %>
                        <% } %>
						<% if( SES_ID == caseUserId2) { caseFlag2=3; }
                        if(isactive2 == 1){ %> 
                        <% if(showQuickActiononList2 || isAllowed("Edit All Task",projectUniqid)){ %> 
                        <% if((isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit2) || isAllowed("Edit All Task",projectUniqid)){ %> 
                         <li onclick="editask(<%= '\''+ caseUniqId2+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId2 %>" style=" <% if(showQuickActiononList2 || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit2) ){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                          </li> 
                          <% } %>  
                          <% } %>  
                          <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> 
                         <li onclick="copytask(<%= '\''+ caseUniqId2+'\',\''+ caseAutoId2+'\',\''+caseNo2+'\',\''+projId2+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId2 %>" style=" <% if(showQuickActiononCopy2){ %>display:block <% } else { %>display:none<% } %>">
                          <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                          </li> 
                          <% } %>
                         
                        <% } %>
						<% if((caseLegend2 != max_custom_status) && caseTypeId2!= 10) { caseFlag2=2; }
                        if((SES_TYPE == 1 || SES_TYPE == 2) || (((caseLegend2 == 1 || caseLegend2 == 2 || caseLegend2 == 4) || (caseLegend2 != max_custom_status)) &&  (SES_ID == caseUserId2))){ %>
                        <% if(isactive2 == 1){ %>
                         <% if(isAllowed("Move to Project",projectUniqid)){ %> 
                        <li data-prjid="<%= projId2 %>" data-caseid="<%= caseAutoId2 %>" data-caseno="<%= caseNo2 %>"  id="mv_prj<%= caseAutoId2 %>" style=" " onclick="mvtoProject( <%= '\'' + count2 + '\'' %> , this);">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                        </li>
                        <% } %>
                        <% } %>
                        <% } %>
                       <% if(isactive2 == 1){ %>
                         <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                        <li onclick="moveTask( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + caseNo2 + '\'' %> , <%= '\'\'' %> , <%= '\'' + projId2 + '\'' %> );" id="moveTask<%= caseAutoId2 %>" style=" <% if(caseFlag2 == 2){ %> display:block <% } else { %> display:block <% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                        </li>
                        <% } %>
                        <% } %>
						
                            <% if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId2) || isAllowed("Archive All Task",projectUniqid)) { caseFlag2 = "archive"; }
							if(isactive2 == 1){ %>
							<% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
							<li onclick="archiveCase( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + caseNo2 + '\'' %> , <%= '\'' + projId2 + '\'' %> , <%= '\'t_' + caseUniqId2 + '\'' %> );" id="arch<%= caseAutoId2 %>" style="<% if(caseFlag2 == "archive"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
							</li>
							<% } %>
							<% } %>
				<%	if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId2) || isAllowed("Delete All Task",projectUniqid)) { caseFlag2 = "delete"; }
                        if(isactive == 1){ %>
                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
                        <li onclick="deleteCase( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + caseNo2 + '\'' %> , <%= '\'' + projId2 + '\'' %> , <%= '\'t_' + caseUniqId2 + '\'' %> , <%= '\'' + is_recurring2 + '\'' %>);" id="arch<%= caseAutoId2 %>" style="<% if(caseFlag2 == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                        </li>
                        <% } %>						
                        <% } %>								
                        </ul>
                     </div>
					 </div>				  
               </td>
			   <td class="favo-td">
					<span id="caseProjectSpanFav<%=caseAutoId2 %>">
						<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId2 %>,<%=projId2 %>,<%= '\''+caseUniqId2+'\'' %>,1,<%=isFavourite2%>)"  rel="tooltip" original-title="<%=favMessage2%>" style="margin-top:0px;color:<%=favouriteColor2%>;" >
						<% if(isFavourite2) { %>
							<i class="material-icons" style="font-size:18px;">star</i>
						<% }else{ %>
							 <i class="material-icons" style="font-size:18px;">star_border</i>
						<% } %>
						</a>
					</span>
				</td>
               <td class="text-left count-plist-drop pr">
                  <%= getdata2.Easycase.case_no %>   <span class="watch showtime_<%= getdata2.Easycase.id %>"></span>   
                  
               </td>
               <td class="relative list-cont-td label_task_tle text-left" id="tour_task_title_listing">  
				<?php /*
                  <span class="ttype_global tt_<%= getttformats(getdata2.Type.name)%>"></span> 
					*/ ?>
                  <%
                   var priorClass = 'prio_low';
                    if(getdata2.Easycase.priority == 1){
                        priorClass = 'prio_medium';
                     }else if(getdata2.Easycase.priority == 0){
                     priorClass = 'prio_high';
                  }
                  %>
                  <div style="" id="pridiv<%= caseAutoId2 %>" class="pri_actions <% if(showQuickActiononList2){ %> dropdown<% } %>"> 
					<div class="dropdown cmn_h_det_arrow">
						<div <% if(showQuickActiononList2){ %> class="quick_action" <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %> data-toggle="dropdown" <% } %> <% } %> style="cursor:pointer"><span class=" priority <%= priorClass %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>"></span><% if(showQuickActiononList2){ %> <i class="tsk-dtail-drop material-icons">&#xE5C5;</i> <% } %></div>
                    <% var csLgndRep2 = caseLegend2; %>
                    <% if(showQuickActiononList2){ %>
                    <ul class="dropdown-menu quick_menu">
                        <li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId2 + '\', \'2\', \'' + caseUniqId2 + '\', \'' + caseNo2 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
                        <li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId2 + '\', \'1\', \'' + caseUniqId2 + '\', \'' + caseNo2 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
                        <li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority( <%= '\'' + caseAutoId2 + '\', \'0\', \'' + caseUniqId2 + '\', \'' + caseNo2 + '\'' %> )"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
                    </ul>
                    <% } %>
					</div>					
				</div>					
                 <span id="prilod<%= caseAutoId2 %>" style="display:none">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>
                  <div class="ttl_listing" data-task-id="<%= getdata2.Easycase.uniq_id %>">
                  <a href="javascript:void(0);" class="titlehtml" data-task="<%= getdata2.Easycase.uniq_id %>">
                      <span class="case-title_<%= getdata2.Easycase.id %> case_sub_task <% if(getdata2.Easycase.type_id!=10 && (getdata2.Easycase.legend == max_custom_status || getdata2.Easycase.custom_status_id == max_custom_status)) { %>closed_tsk<% } %>">
                        <span class="max_width_tsk_title ellipsis-view <% if(getdata2.Easycase.legend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(getdata2.Easycase.title && getdata2.Easycase.title.length>100){%>overme<% }%> " title="<%= formatText(ucfirst(getdata2.Easycase.title)) %>  ">
                           <%= formatText(ucfirst(getdata2.Easycase.title)) %>
                        </span>
                     </span>
                  </a>   
                  
                  <div class="list-td-hover-cont">
                     <?php /*<span class="created-txt"><% if(getdata2.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata2.User.name %> <?php echo __('on');?> <%= moment(getdata2.Easycase.dt_created).format("LLLL") %></span> */?>
                     <span class="created-txt"><% if(getdata2.Easycase.case_count!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('on');?> <%= moment(getdata2.Easycase.dt_created).format("lll") %></span>
					<span class="list-devlop-txt dropdown">
                    <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                        <i class="material-icons tag_fl">&#xE54E;</i>
                        <span id="showUpdStatus<%= caseAutoId2 %>" class="<% if(showQuickActiononList2 && isactive2 == 1){ %>clsptr<% } %>" title="<%= csTdTyp2 %>" >
                          <span class="tsktype_colr" id="tsktype<%= caseAutoId2 %>"><%= csTdTyp2 %><span class="due_dt_icn"></span>
                          </span> 
                          </span> 
                    </a>				
                    <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
						<span id="typlod<%= caseAutoId2 %>" class="type_loader">
                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
						</span>
                        <% if(showQuickActiononList2 && isactive2 == 1){ %>
                        <ul class="dropdown-menu listgrp-bug-dropdn">
                            <li>
                                     <input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="seachitems(this);" />
                                 </li>	
                            <%
                            for(var k in GLOBALS_TYPE) {
                             if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == getdata2.Easycase.project_id){
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
                            <li onclick="changeCaseType( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + caseNo2 + '\'' %> ); changestatus( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + t + '\'' %> , <%= '\'' + t1 + '\'' %> , <%= '\'' + t2 + '\'' %> , <%= '\'' + caseUniqId2 + '\'' %> )">
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
						<% if(getdata2.Easycase.children && getdata2.Easycase.children != ""){ %>
							<span class="fl case_act_icons task_parent_block" id="task_parent_block_<%= caseUniqId2 %>">
								<div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + caseAutoId2 + '\'' %>,<%= '\'' + caseUniqId2 + '\'' %>,<%= '\'' + getdata2.Easycase.children + '\'' %>);" class=" task_title_icons_parents fl"></div>
								<div class="dropdown dropup fl1 open1 showParents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
										<li>
											<ul class="task_parent_items" id="task_parent_<%= caseUniqId2 %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
						<% if(getdata2.Easycase.depends && getdata2.Easycase.depends != ""){ %>
							<span class="fl case_act_icons task_dependent_block" id="task_dependent_block_<%= caseUniqId2 %>">
								<div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + caseAutoId2 + '\'' %>,<%= '\'' + caseUniqId2 + '\'' %>,<%= '\'' + getdata2.Easycase.depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
								<div class="dropdown dropup fl1 open1 showDependents">
									<ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
										<li class="pop_arrow_new"></li>
										<li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>".</li>
										<li>
											<ul class="task_dependent_items" id="task_dependent_<%= caseUniqId2 %>" style="">
												<li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li>
											</ul>
										</li>
									</ul>
								</div>
							</span>
						<% } %>
					</div>
					
					<div class="subcls_rcrng fr">
					<% if(getdata2.Easycase.is_recurring == 1 || getdata2.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId2 %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
            <% } %>
					</div> 
					<div class="cb"></div>
					
				</div>
				<?php /*
				<% if(getdata2.Easycase.is_recurring == 1 || getdata2.Easycase.is_recurring == 2){ %>
				<a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId2 %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
				<% } %>
				*/ ?>  
               </div>
               </td>
               <td class="attach-file-comment text-center">  
                  <a href="javascript:void(0);" style="display:none;" id="fileattch1">   <i class="glyphicon glyphicon-paperclip"></i>  </a>    <a href="javascript:void(0)" id="repno1" style="display:none">   <i class="material-icons"></i>  </a> 
               </td> 
				<td class="assi_tlist">
                  <div class="user-task-pf">
                     <% if(!getdata2.AssignTo.photo){ getdata2.AssignTo.photo = 'user.png'; } %>
                     <% var usr_name_fst = (getdata2.AssignTo.name != null)?getdata2.AssignTo.name:"<?php echo __("Unassigned");?>"; %>
					<i class="material-icons">&#xE7FD;</i>			
						<% if((projUniq != 'all') && showQuickActiononList2){ %>
						<span id="showUpdAssign<%= caseAutoId2 %>" <% if(isAllowed("Change Assigned to",projectUniqid)){ %> data-toggle="dropdown" <% } %>title="<%= usr_name_fst %>" class="clsptr" onclick="displayAssignToMem( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + projUniq + '\'' %> , <%= '\'' + caseAssgnUid2 + '\'' %> , <%= '\'' + caseUniqId2 + '\'' %> )"><%= usr_name_fst %><span class="due_dt_icn"></span></span>
						<% } else { %>
						<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= usr_name_fst %></span>
						<% } %>
                   <% if((projUniq != "all") && showQuickActiononList2){ %>
					<span id="asgnlod<%= caseAutoId2 %>" class="asgn_loader">
						<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
					</span>
					<% } %>			
					<span class="check-drop-icon dsp-block" <% if((projUniq != "all") && showQuickActiononList2){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId2 + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid2 + '\'' %>,<%= '\'' + caseUniqId2 + '\'' %>)" <% } %>>
						  <span class="dropdown">
							<a class="dropdown-toggle" <% if(isAllowed("Change Assigned to",projectUniqid)){ %> data-toggle="<% if((projUniq != "all") && showQuickActiononList2){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
								<i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem<%= caseAutoId2 %>">
								<li class="text-centre"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="assgnload<%= caseAutoId2 %>" /></li>
							</ul>
						</span>
					</span>          
                 </div> 
               </td>			   
               <td class="esthrs_dt_tlist text-center">
			   <p class="<?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblists <?php } ?> estblist_subtask" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> id="est_blist_sub<%= getdata2.Easycase.id %>" case-id-val="<%= getdata2.Easycase.id %>">    
                     <span class="border_dashed_subtask">
                        <%= format_time_hr_min(getdata2.Easycase.estimated_hours) %>
                     </span>   
                  </p> 
					<% var est_time = Math.floor(caseEstHoursRAW2/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
				
				<input type="text" data-est-id="<%=caseAutoId2%>" data-est-no="<%=caseNo2%>" data-est-uniq="<%=caseUniqId2%>" data-est-time="<%=est_time%>" id="est_hr_sub_list<%=caseAutoId2%>" class="est_hr_sub_list form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can enter time as 1.5(that mean 1 hour and 30 minutes)');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
				
				<span id="estsublod<%=caseAutoId2%>" style="display:none;margin-left:0px;">
					<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
				</span>	
                  
               </td>             
                <td class="text-center"> 
									<div class="cs_select_dropdown">
                  <span id="csStsRep_sub<%= getdata2.Easycase.id %>" class="cs_select_status">
                     <% if(getdata2.Easycase.isactive==0){ %>
                        <div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
                     <%}else {
                       if(getdata2.Easycase.custom_status_id != 0 && getdata2.CustomStatus != null ){ %>
                        <%= easycase.getCustomStatus(getdata2.CustomStatus, getdata2.Easycase.custom_status_id) %>
                     <% }else{ %>
                       <%= easycase.getStatus(getdata2.Easycase.type_id, getdata2.Easycase.legend) %>
                      <% }
                      } %>
                  </span>
                    <span class="check-drop-icon dsp-block">
						<span class="dropdown">
							<a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
							  <i class="material-icons">&#xE5C5;</i>
							</a>
							<ul class="dropdown-menu">
                            <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                           <% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata2.Easycase.project_id] !='undefined' && customStatusByProject[getdata2.Easycase.project_id] != null){
                           $.each(customStatusByProject[getdata2.Easycase.project_id], function (key, data) {
                           if(getdata2.CustomStatus.id != data.id){
                           %>
                      <% if(data.status_master_id == 3){ %>
                        <% if(isAllowed("Status change except Close",getdata2.Project.uniq_id)){ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata2.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                      <% }else{ %>
                           <li onclick="setCustomStatus(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= getdata2.Easycase.id %>">
                           <a href="javascript:void(0);">
                           <span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
                           </a>
                           </li>
                      <% } %>
                           <%   } 
                           }); 
                           } else{ %>
                          <% var caseFlag="";
                              if(getdata2.Easycase.legend != 1 && getdata2.Easycase.type_id != 10){ caseFlag=9; }
                              if(getdata2.Easycase.isactive == 1){ %>
                              <li onclick="setNewCase(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>);" id="new<%= getdata2.Easycase.id %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                              </li>
                              <% }
                              if((getdata2.Easycase.legend != 2 && getdata2.Easycase.legend != 4) && getdata2.Easycase.type_id!= 10) { caseFlag=1; }
                                                  if(getdata2.Easycase.isactive == 1) { %>
                              <li onclick="startCase(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>);" id="start<%= getdata2.Easycase.id %>" style=" <% if(caseFlag == "1"){ %>display:block<% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE039;</i><% if(getdata2.Easycase.legend == 1){ %><?php echo __('Start');?><% }else{ %><?php echo __('In Progress');?><% } %></a>
                              </li>
                              <% }
                                                  if((getdata2.Easycase.legend != 5) && getdata2.Easycase.type_id!= 10) { caseFlag=2; }
                                                  if(getdata2.Easycase.isactive == 1){ %>
                              <li onclick="caseResolve(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>);" id="resolve<%= getdata.Easycase.id %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                              </li>
                              <% }
                              if((getdata2.Easycase.legend != 3) && getdata2.Easycase.type_id != 10) { caseFlag=5; }
                              if(getdata2.Easycase.isactive == 1){ %>
                              <% if(isAllowed("Status change except Close",getdata2.Project.uniq_id)){ %>
                              <li onclick="setCloseCase(<%= '\'' + getdata2.Easycase.id + '\'' %>, <%= '\'' + getdata2.Easycase.case_no + '\'' %>, <%= '\'' + getdata2.Easycase.uniq_id + '\'' %>);" id="close<%= getdata2.Easycase.id %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                  <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                              </li>
                              <% } %>  
                           <% } %>
                           <% } %>
                      <?php } ?>
                            </ul>
                        </span>
                    </span>
                    </div>
               </td>
               <td class="due_dt_tlist text-center">
                  <div class="<% if(csDueDate2 == '' || caseLegend2 == 5 || caseTypeId2 == 10 || caseLegend2 == 3){ %> toggle_due_dt <% } %>">
                <% if(isactive == 1){ %>
                <% if(showQuickActiononList2 && caseTypeId2 != 10){ %>
				<?php /*
                <span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList2){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
				*/ ?>
                <% } %>
                <span class="show_dt" id="showUpdDueDate<%= caseAutoId2 %>" title="<%= csDuDtFmtT2 %>">
                    <%= csDuDtFmt2 %>
                </span>
                <span id="datelod<%= caseAutoId2 %>" class="asgn_loader">
                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                </span>
                <% } %>
                <span class="check-drop-icon dsp-block">
                    <span class="dropdown">
                        <a class="dropdown-toggle" <% if(isAllowed('Update Task Duedate',projectUniqid)){ %> data-toggle="<% if(showQuickActiononList2){ %>dropdown<% } %>" <% } %> href="javascript:void(0);" data-target="#">
                            <i class="material-icons">&#xE5C5;</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="pop_arrow_new"></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId2 + '\'' %> , <%= '\'' + caseNo2 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId2 + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId2 + '\'' %> )"><?php echo __('No Due Date');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId2 + '\', \'' + caseNo2 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId2 + '\', \'' + mdyCurCrtd + '\', \'Today\', \'' + caseUniqId2 + '\'' %> )"><?php echo __('Today');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId2+ '\', \'' + caseNo2 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId2 + '\', \'' + mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId2 + '\'' %> )"><?php echo __('Tomorrow');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId2 + '\', \'' + caseNo2 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId2 + '\', \'' + mdyMonday + '\', \'Next Monday\', \'' + caseUniqId2 + '\'' %> )"><?php echo __('Next Monday');?></a></li>
                            <li><a href="javascript:void(0);" onclick="changeCaseDuedate( <%= '\'' + caseAutoId2 + '\', \'' + caseNo2 + '\'' %> ); changeDueDate( <%= '\'' + caseAutoId2 + '\', \'' + mdyFriday + '\', \'This Friday\', \'' + caseUniqId2 + '\'' %> )"><?php echo __('This Friday');?></a></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="cstm-dt-option-dtpik prtl">
                                        <div class="cstm-dt-option" data-csatid="<%= caseAutoId2 %>" style="position:absolute; left:0px; top:0px; z-index:99999999;">
                                            <input data-csatid="<%= caseAutoId2 %>" value="" type="text" id="set_due_date_<%= caseAutoId2 %>" class="set_due_date hide_corsor" title="<?php echo __('Custom Date');?>" style="background:none; border:0px;"/>	
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
			<div class="overdueby_spns overdueby_spn_<%= caseAutoId2 %>"><% if(showQuickActiononList2){ %><%= getdata2.Easycase.csDuDtFmtBy %><% } %></div> 
               </td>
               <td class="due_dt_tist text-center">
                 <%= (getdata2.Easycase.completed_task)?getdata2.Easycase.completed_task :"0" %> %
               </td>                 
            </tr>
               <% } } }%>

            <% }
            }
            } %>
            <tr class="separetor_tr"><td colspan="9"></td></tr>
             <% } } %>
						 
						 <% if(resCaseProj.length == 0){ %>
							<tr><td colspan="9" style="color: #ff0000;"> <?php echo __("No task found."); ?></td></tr>
						 <% } %>
  <%  }else{%>
    <tr class="noRecord"><td colspan="9" class="textRed"><?php echo __('No tasks found');?>.</td></tr>
    <% } %>
	
<?php } ?>

<% if(casePage == 1){ %>
</tbody>
</table> 
	<div class="text-center">
		<a href="javascript:void(0);" id="subtask-load-more" class="btn btn-primary"><?php echo __("Load More Task"); ?></a>
	</div>
</div>
		<% $("#task_paginate").html(''); %>
<div class="crt_task_btn_btm <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT && $_SESSION['KEEP_HOVER_EFFECT'] && (($_SESSION['KEEP_HOVER_EFFECT'] & 8) == 8)){ ?>keep_hover_efct<?php } ?> num_2">
			<span  class="hide_tlp_cross" title="<?php echo __('Close');?>" onclick="resetHoverEffect(<%= '\'task\'' %>, this);">&times;</span>
	<div class="pr">
		<?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
		<div class="os_plus ctg_btn">
			<div class="ctask_ttip">
				<span class="label label-default"><?php echo __('Create Task Group');?></span>
			</div>
			<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task Group List View Page Big Plus\'' %>, <%= '\'Create Task Group\'' %>);addEditMilestone(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>);">
				<i class="material-icons">&#xE065;</i>
			</a>
		</div>
	<?php } ?>
	</div>
	 <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
	<div class="os_plus">
		<div class="ctask_ttip">
			<span class="label label-default"><?php echo __('Create Task');?></span>
		</div>
		<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task Group List View Page Big Plus\'' %>, <%= '\'Create Task\'' %>);creatask();">
			<img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
			<img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
		</a>
	</div>
<?php } ?>
</div>
<div class="cb"></div>
<?php } ?>

<input type="hidden" name="hid_cs" id="hid_cs" value=""/>
<input type="hidden" name="totid" id="totid" value=""/>
<input type="hidden" name="chkID" id="chkID" value=""/>
<input type="hidden" name="slctcaseid" id="slctcaseid" value=""/>
<input type="hidden" id="getcasecount" value="" readonly="true"/>
<input type="hidden" id="openId" value="" />
<input type="hidden" id="email_arr" value="" />
<input type="hidden" id="curr_sel_project_id" value="<%= curProjId %>" >
<input type="hidden" id="displayedTaskGroups" value="20">
<input type="hidden" id="totalTaskGroups" value="<%= caseCount %>">
<% } %>
</div>