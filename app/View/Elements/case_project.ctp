<?php if(defined("RELEASE_V") && RELEASE_V){ ?>
<% (typeof GrpBy != 'undefined')?GrpBy:''; 
var check_ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS') != 'undefined' ?JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS')) :[];
%>
<%
var rel_arr = new Array();
var task_parent_ids = JSON.stringify(task_parent_ids);
%>
<% if(GrpBy != 'milestone'){ %>
<div class="task_listing">
            <?php if(PAGE_NAME=='dashboard'){ ?>
                <div id="widgethideshow" class="fl task-list-progress-bar fix-status-widget" <?php if(strtotime("+2 months",strtotime(CMP_CREATED))>=time()){?><?php }?>>
                    <span id="task_count_of" style="float:left;display:block;"></span>
                    <span class="pr fl inner_search_span" onclick="slider_inner_search(<%= '\'open\'' %>);">   
                      <i class="material-icons clear_close_icon" title="<?php echo __('Clear search');?>" id="clear_close_icon" onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Search Task\'' %>); clearSearch(<%= '\'inner\'' %>);">close</i>
                         <i class="inner_search_icon material-icons">&#xE8B6;</i>
                        <input type="text" name="search_inner" id="inner-search" placeholder="<?php echo __('Search');?>" class="inner-search" value="<%=caseSrch%>" />
                        <img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="loading" title="<?php echo __('loading');?>" class="search_load" id="srch_inner_load1">
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
          <span class="pfl-icon-dv show_hide_column_filter">
            <span id="showhide_drpdwn" class="dropdown">
            <a href="javascript:jsVoid();" title="<?php echo __('Show/Hide Columns');?>" onclick="showColumnPreferences(<%= field_name_arr %>);" class="dropdown-toggle" data-toggle="dropdown">
            <i class="material-icons">visibility_off</i> <?php echo __("Show/Hide");?><div class="ripple-container"></div></a>
            <ul class="dropdown-menu drop_menu_mc" id="dropdown_menu_taskcolumns">	
              <li class="li_check_radio">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('All',field_name_arr)){ %> checked="checked" <% } %> class="selectedcols" value="All" id="column_all"  style="cursor:pointer" onchange="checkboxColumn(this);"> <?php echo __('Show/Hide All');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Assigned to',field_name_arr)){ %> checked="checked" <% } %> class="selectedcols" value="Assigned to" id="column_assigned" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Assigned To');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Priority',field_name_arr)){ %> checked="checked" <% } %> class="selectedcols" value="Priority" id="column_priority" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Priority');?>
                    </label>
                  </div>
              </li>
			  <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Estimated Hours',field_name_arr)){ %> checked="checked" <% } %>class="selectedcols" value="Estimated Hours" id="column_estimatedhours" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Est. Hours');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Spent Hours',field_name_arr)){ %> checked="checked" <% } %>class="selectedcols" value="Spent Hours" id="column_spenthours" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Spent Hours');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Updated',field_name_arr)){ %> checked="checked" <% } %> class="selectedcols" value="Updated" id="column_updated" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Updated');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox"  <% if(inArray('Status',field_name_arr)){ %> checked="checked" <% } %> class="selectedcols" value="Status" id="column_status" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Status');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Due Date',field_name_arr)){ %> checked="checked" <% } %>class="selectedcols" value="Due Date" id="column_duedate" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Due Date');?>
                    </label>
                  </div>
              </li>
               <li class="li_check_radio"> 
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <% if(inArray('Progress',field_name_arr)){ %> checked="checked" <% } %>class="selectedcols" value="Progress" id="column_progress" style="cursor:pointer" onchange="checkboxSingleColumn(this);"> <?php echo __('Progress');?>
                    </label>
                  </div>
              </li>
              <li class="li_check_radio"> 
                  <div style="text-align:center;">
                    <label>
                      <input type="button" class="btn btn_cmn_efect cmn_bg btn-info show_btn" value="<?php echo __('Save');?>" onclick="getAllowedColumns();">
                    </label>
                  </div>
              </li>
            </ul>
            <!-- Custom code Ends -->
            </span>
          </span> 
		  <span class="filter_tag_items" id="task_groupby_items_list"></span>
			<span class="groupby_filter mtop5">
				<div class="dropdown" title="<?php echo __('task group by'); ?>">
					<a href="javascript:void(0)" type="button" data-toggle="dropdown" onclick="openTaskGroupByDrpdwn();">
						<span class="icon_groupby_img" title="<?php echo __("Task group by"); ?>"></span>
					</a>
					<ul class="dropdown-menu" id="dropdown_task_groupby_filters">
						<li>
							<a href="javascript:jsVoid();" data-type="Date" data-toggle="dropdown" onclick="ajaxTaskGroupBy(this)"> <?php echo __("Date"); ?></a>
						</li>
						<li>
							<a href="javascript:jsVoid();" data-type="Assign to" data-toggle="dropdown" onclick="ajaxTaskGroupBy(this)"> <?php echo __("Assign To"); ?></a>
						</li>
						<li>
							<a href="javascript:jsVoid();" data-type="Status" data-toggle="dropdown" onclick="ajaxTaskGroupBy(this)"> <?php echo __("Status"); ?></a>
						</li>
						<li>
							<a href="javascript:jsVoid();" data-type="Priority" data-toggle="dropdown" onclick="ajaxTaskGroupBy(this)"> <?php echo __("Priority"); ?></a>
						</li>
					</ul>
				</div>
			</span>		  
          <?php if($this->Format->displayHelpVideo()){ ?>
            <span style="line-height: 30px;">
          <a href="javascript:void(0);" class="help-video-pop" video-url = "https://www.youtube.com/embed/G1oCxuSd640" onclick="showVideoHelp(this);" ><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>   
          </span> 
          <?php } ?>                               
                    <div class="cb"></div>					
                </div>
			<?php } ?>
  <div class="task-m-overflow cstm_responsive_tbl task_scrollable_list">
            <table class="table table-striped table-hover">
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
                                        <a class="dropdown-toggle mass_action_dpdwn" data-toggle="" href="javascript:void(0);">
                                          <i title="<?php echo __('Choose at least one task');?>" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>
                                        </a>
                                        <ul class="dropdown-menu" id="dropdown_menu_chk">
                                          <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>                                          
                                          <% if(projUniq == 'all'){%>
                                          <% }else{ %>
						<% if(typeof curProjId != "undefined" && typeof curProjId != "null" &&  typeof customStatusByProject !="undefined" && typeof customStatusByProject[curProjId] !='undefined' && customStatusByProject[curProjId] != null){
						 $.each(customStatusByProject[curProjId], function (key, data) {
						  %>
                            <% if(data.status_master_id == 3){ %>
                                <% if(isAllowed("Status change except Close",projectUniqid)){ %>
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
							<%= data.name %></a>	
							</li>
                            <% } %>
						 <%    
							}); 
						  }else{ %>
                                          <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseNew\'' %>)"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseStart\'' %>)"><i class="material-icons">&#xE039;</i><?php echo __('Start');?></a>
                                            </li>
                                        <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseResolve\'' %>)"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                                        </li>
                                        <% if(isAllowed('Status change except Close',projectUniqid)){ %>
                                        <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i><?php echo __('Close');?></a>
                                        </li>	
                                        <% } %>	
						<% } %>	
						<% } %>	
                                        <?php } ?>								
                                        <?php if(SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Archive All Task',$roleAccess)) {?>
                                        <?php if($this->Format->isAllowed('Archive Task',$roleAccess)){ ?>                                     
                                        <li>
                                                <a href="javascript:void(0);" onclick="archiveCase(<%= '\'all\'' %>)"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                        </li>
                                      <?php } ?>
                                      <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>      
										<li>
                                                <a href="javascript:void(0);" onclick="ajaxassignAllTaskToUser(<%= '\'movetop\'' %>);"><i class="material-icons">&#xE7FD;</i><?php echo __('Assign task(s) to user');?></a>
                                        </li>
                                      <?php } ?>
                                        <?php if($this->Format->isAllowed('Move to Project',$roleAccess)){ ?>        
                                        <li id="mvTaskToProj">
                                                <a href="javascript:void(0);" onclick="mvtoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to project');?></a>
                                        </li>
                                        <?php } ?>
                                        <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li id="cpTaskToProj">							
                                                <a href="javascript:void(0);" onclick="cptoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE14D;</i><?php echo __('Copy to Project');?></a>
                                        </li>
                                      <?php } ?>
										<?php if (SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Delete All Task',$roleAccess)) { ?>
					<li id="delAllTsks">
						<a href="javascript:void(0);" onclick="DeleteAllCaseTaskList( <%= '\'all\'' %> )"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
					</li>
				  <?php } ?>
                                        <?php } ?>
                                        </ul>
                                </span>
                                    </div>
                            </div>
                        </th>
          <th class="wth_2">                           
                            <a href="javascript:void(0);" title="<?php echo __('Task');?>#" onclick="ajaxSorting(<%= '\'caseno\', ' + caseCount + ', this' %>);" class="sortcaseno">
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
          <th class="wth_3"></th>
          <th class="wth_4">
                            <% if(GrpBy != 'milestone'){ %>
                            <a class="sorttitle" href="javascript:void(0);" title="<?php echo __('Title');?>" onclick="ajaxSorting(<%= '\'title\', ' + caseCount + ', this' %>);">
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
                            <% }else{ %>
                                <?php echo __('Title');?>
                            <% } %>
                        </th>
          <th class="wth_5"></th>
          <% if(inArray('Assigned to',field_name_arr)){ %>
          <th class="width_assign wth_6">
                            <% if(1 || GrpBy != 'milestone'){ %>
                            <a class="sortcaseAt" href="javascript:void(0);" title="<?php echo __('Assigned to');?>" onclick="ajaxSorting(<%= '\'caseAt\', ' + caseCount + ', this' %>);">
                                <?php echo __('Assigned to');?>
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
          <% } %>
          <% if(inArray('Priority',field_name_arr)){ %>
          <th class="width_priority text-center wth_7">
                            <a class="sortprioroty" href="javascript:void(0);" title="<?php echo __('Priority');?>" onclick="ajaxSorting(<%= '\'priority\', ' + caseCount + ', this' %>);">
                                <span class="priorotyelipsis"><?php echo __('Priority');?></span>
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
          <% } %>
		  <% if(inArray('Estimated Hours',field_name_arr)){ %>
          <th class="width_estimatedhours text-center wth_71">
			<a class="sortestimatedhours" href="javascript:void(0);" title="<?php echo __('Est. Hours');?>" onclick="ajaxSorting(<%= '\'estimatedhours\', ' + caseCount + ', this' %>);">
				<span class="estimatedhourselipsis"><?php echo __('Est. Hours');?></span>
				<span class="sorting_arw">
				<% if(typeof csEstHrsSrt != 'undefined' && csEstHrsSrt != "") { %>
						<% if(csEstHrsSrt == 'asc'){ %>
							  <i class="material-icons tsk_asc">&#xE5CE;</i>
						<% }else{ %>
							  <i class="material-icons tsk_desc">&#xE5CF;</i>
						<% } %>								
				<% }else{ %>
					  <i class="material-icons">&#xE164;</i>
				<% } %></span>
			</a>
		  </th>
          <% } %>
          <!--  added spenthr start-->
		  <% if(inArray('Spent Hours',field_name_arr)){ %>
          <th class="width_estimatedhours text-center wth_71">
			<a class="sortestimatedhours" href="javascript:void(0);" title="<?php echo __('Spent Hours');?>" onclick="ajaxSorting(<%= '\'spenthours\', ' + caseCount + ', this' %>);">
				<span class="estimatedhourselipsis"><?php echo __('Spent Hours');?></span>
				<span class="sorting_arw">
				<% if(typeof csEstHrsSrt != 'undefined' && csEstHrsSrt != "") { %>
						<% if(csEstHrsSrt == 'asc'){ %>
							  <i class="material-icons tsk_asc">&#xE5CE;</i>
						<% }else{ %>
							  <i class="material-icons tsk_desc">&#xE5CF;</i>
						<% } %>								
				<% }else{ %>
					  <i class="material-icons">&#xE164;</i>
				<% } %></span>
			</a>
		  </th>
          <% } %>

		  <!-- added spenthr end -->
          <% if(inArray('Updated',field_name_arr)){ %>
          <th class="width_update text-center wth_8">
                            <a class="sortupdated" href="javascript:void(0);" title="<?php echo __('Updated');?>" onclick="ajaxSorting(<%= '\'updated\', ' + caseCount + ', this' %>);">
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
          <% } %>
          <% if(inArray('Status',field_name_arr)){ %>
          <th class="width_status text-center wth_9">
                                <?php echo __('Status');?>
                        </th>						
          <% } %>
          <% if(inArray('Due Date',field_name_arr)){ %>
          <th class="tsk_due_dt wth_10">
                            <a class="sortduedate" href="javascript:void(0);" title="<?php echo __('Due Date');?>" onclick="ajaxSorting(<%= '\'duedate\', ' + caseCount + ', this' %>);">
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
          <% } %>
          <% if(inArray('Progress',field_name_arr)){ %>
          <th class="width_progress text-center wth_71">
            <span class="progresselipsis"><?php echo __('Progress');?></span>
          </th>
          <% } %>
				
          </tr>
              </thead>
              <tbody>                   
              <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>      
                <% if(projUniq != 'all'){%>                      
                    <tr class="qtask quicktsk_tr_lnk">
                          <td colspan="<%= totalColumnCount  %>">
                              <div class="new_qktask_mc">
                                  <div class="new_grp_tsk" id="new_task_label" style="width: 130px;"><a href="javascript:void(0)" class="cmn-bxs-btn"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task');?></a></div>
                              </div>                               
                          </td>
                    </tr>
                    <tr class="quicktsk_tr task_list_page">
						<td colspan="<%= totalColumnCount %>" class="quicktd_task">
							<div class="col-md-3 form-group label-floating fl">
							  <div class="input-group">
									<label class="control-label" for="addon3a"><?php echo __('Task Title');?></label>
									<input class="form-control" type="text" id="inline_qktask">									
							  </div>
							</div>
              <div class="col-md-2 form-group label-floating fl stop-floating-top qt_form-group <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> no-pointer <?php } ?>" style="width: 13%;">
								<label class="control-label multilang_ellipsis" for="qt_due_dat" title="<?php echo __('Due Date');?>"><?php echo __('Due Date');?></label>
								<?php $dues_date_qt_top = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date"); ?>
								<?php echo $this->Form->text('qt_due_dat', array('value' => '', 'class' => 'form-control', 'id' => 'qt_due_dat','readonly'=>'readonly','placeholder'=>'Ex. '.date('M d, Y', strtotime($dues_date_qt_top)))); ?>
								<div class="cmn_help_select"></div>
								<a href="javascript:void(0);" class="onboard_help_anchor" 
								onclick="openHelpWindow(<%= '\'https://helpdesk.orangescrum.com/cloud/create-quick-task/<?= HELPDESK_URL_PARAM ?>#due_date\'' %>)"
								title="<?php echo __("Get quick help on Due Date");?>" rel="tooltip"><i class="material-icons">&#xE8FD;</i></a>
							</div>
              <div class="col-md-2 padrht-non cstm-drop-pad qt_dropdown task_type qt_tsk_type_dropdown <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> no-pointer <?php } ?>" >
								<select class="tsktyp-select form-control task_type floating-label" placeholder="<?php echo __('Task Type');?>" data-dynamic-opts=true id="qt_task_type">
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
							
              <div class="col-md-1 form-group label-floating fl stop-floating-top qt_form-group <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> no-pointer <?php } ?>" id="qt_story_point_container" style="<% if(select_task_type_qt != 'Story'){ %> display:none;<%}%>">
								<label class="control-label" for="qt_story_point"><?php echo __('Story Point');?></label>
								<?php echo $this->Form->text('qt_story_point', array('value' => 0, 'class' => 'form-control check_minute_range', 'id' => 'qt_story_point', 'maxlength' => '4','type'=>'number','min'=>"0", "onkeypress"=>"return numeric_only(event)")); ?>
							</div>
							
              <div class="col-md-1 padrht-non custom-task-fld task-type-fld labl-rt cstm-drop-pad qt_dropdown <?php if(!$this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> no-pointer <?php } ?> qt_dropdown_assn" style="width:15%;">
								<select class="form-control floating-label" placeholder="<?php echo __('Assign To');?>" data-dynamic-opts=true onchange="changeTypeId(this)" id="quick-assign">
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
								<?php echo $this->Form->text('qt_estimated_hours', array('value' => '', 'placeholder' => 'hh:mm', 'class' => 'form-control check_minute_range', 'id' => 'qt_estimated_hours', 'maxlength' => '5', 'onkeypress' => 'return numeric_decimal_colon(event)')); ?>
							</div>	
							<div class="quicktask_save_exit_btn">	
								<div class="btn-group save_exit_btn">
								<input type="hidden" value="list" id="task_view_types_span" />
								<a id="quickcase_qt" href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="setSessionStorage(<%= '\'Task List Quick Task\'' %>, <%= '\'Create Task\'' %>); AddQuickTask(<%= '\'sac\'' %>);"><?php echo __('Save');?></a>
								<span class="dropdown">
									<a href="javascript:void(0);" data-target="#" class="btn btn-primary btn-raised dropdown-toggle crtaskmoreoptn" data-toggle="dropdown"><span class="caret"></span></a>
									<ul class="dropdown-menu crtskmenus">
										<li><a href="javascript:void(0);" onclick ="return AddQuickTask();"><?php echo __('Save & Continue');?></a></li>
										
									</ul>
								</span>
							</div>
							<span class="input-group-btn ds_ib_btn">
							  <a href="javascript:void(0);" onclick="blurqktask_qt();">
									<?php echo __('Cancel');?>
							  </a>								  
							</span>
							</div>
							<div class="cb"></div>
						</td>
                    </tr>
                    <% } %>
      <?php } ?>
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
	var show_history = "";
	var projectName ='';var projectUniqid='';
	var curGgroup = 0;
	for(var caseKey in caseAll){
		var getdata = caseAll[caseKey];
		if(groupby=='milestone' && getdata.Easycase && getdata.EasycaseMilestone.mid == null){
			getdata.EasycaseMilestone.mid = 'NA';
		}
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
		var caseEstHoursRAW = getdata.Easycase.estimated_hours;
		var caseEstHours = getdata.Easycase.estimated_hours_convert;
		var caseSpentHrs = getdata.Easycase.tot_spent_hour;
		var isactive = getdata.Easycase.isactive;
		var caseAssgnUid = getdata.Easycase.assign_to;
		var getTotRep = 0;
		var caseParenId = getdata.Easycase.parent_task_id;
		var task_list_group_by = localStorage.getItem('AJAX_TASK_GROUPBY');
		if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
			getTotRep = getdata.Easycase.reply_cnt;
		}/*getdata.Easycase.case_count */
		var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
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
    var showQuickActiononListEdit = 0;
		/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
			var showQuickActiononList = 1;
		}*/
        if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
              showQuickActiononList = 1;
		}   
    if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
              showQuickActiononListEdit = 1;
    }
		var showQuickActiononCopy = 0;
		if(isactive == 1 && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
			showQuickActiononCopy = 1;
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

			<td colspan="<%= totalColumnCount  %>" align="left" class="curr_day tkt_pjname">
				<div class="<% if(count!=1) {%>y_day<% } %>"><span><%= getdata.Easycase.pjname %></span></div>
			</td>
		</tr>
		<% }
		if(getdata.Easycase.newActuldt && getdata.Easycase.newActuldt!=0) {
	%>
	<?php if(SES_COMP == 1 || SES_COMP == 28528) { ?>
	<% if(getdata.Easycase.newActuldt != "Today" && show_history == '' && caseMenuFilters == "assigntome"){ show_history="show"; %>
		<tr class="list-dt-row my_qt_row_selct">
			<td colspan="<%= totalColumnCount  %>" align="left" class="curr_day qt_history_label">
				<span><?php echo __('History');?></span>
			</td>
		</tr>
	<% } %>
	<tr class="list-dt-row <% if(getdata.Easycase.newActuldt == "Today" && caseMenuFilters == "assigntome"){ %>my_qt_row_selct<% } %>">
	<?php } ?>
	<?php if(SES_COMP != 1 && SES_COMP != 28528) { ?>
    <tr class="list-dt-row">
	<?php } ?>
    	<% if(ajax_group_by == "" || ajax_group_by =="Date" ){ %>
			<td colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
				<div class="dt_cmn_mc <% if(count!=1 && !getdata.Easycase.pjname) {%>y_day<% } %>"> <span><%= getdata.Easycase.newActuldt %> <?php if(SES_COMP == 1 || SES_COMP == 28528) { ?><?php echo __('Tasks');?><?php } ?></span>
				</div>
			</td>
		<% } %>
    </tr>
    <% } %>
	<tr class="list-dt-row">
	<% if(ajax_group_by != "" && task_list_group_by == 'Assign to'){
			 if(curGgroup != getdata.Easycase.asgnShortName){
        		curGgroup = getdata.Easycase.asgnShortName; %>
				<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
					<div class="dt_cmn_mc"> <span><%= getdata.Easycase.asgnShortName %></span>
					</div>
				</td>
				<% 	} %>
			
		<% }else if(task_list_group_by == 'Status') { 
			if(getdata.Easycase.custom_status_id != 0 && getdata.Easycase.CustomStatus != null ){
					if(curGgroup != getdata.Easycase.CustomStatus.name){
						curGgroup = getdata.Easycase.CustomStatus.name; %>
						<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
							<div class="dt_cmn_mc"> <span><%= getdata.Easycase.CustomStatus.name %></span>
							</div>
						</td>
						<% } 
			}else{
				if(curGgroup != getdata.Easycase.legend){
					curGgroup = getdata.Easycase.legend;  %>
					<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
						<div class="dt_cmn_mc"> <span><%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend,'detail') %></span>
						</div>
					</td>
				<% } 
			}
		}else if(task_list_group_by == 'Priority'){ 
			console.log(typeof(getdata.Easycase.priority));
			if(curGgroup !== getdata.Easycase.priority){
				curGgroup = getdata.Easycase.priority;
				 if(getdata.Easycase.priority == '1'){ %>
					<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
						<div class="dt_cmn_mc"> <span>Medium</span>
						</div>
					</td>
				<% }else if(getdata.Easycase.priority == '2'){ %>
					<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
						<div class="dt_cmn_mc"> <span>Low</span>
						</div>
					</td>
				<% }else{ %>
					<td  colspan="<%= totalColumnCount  %>" align="left" class="curr_day">
						<div class="dt_cmn_mc"> <span>High</span>
						</div>
					</td>
				<% } 
			} 
		} %>
	</tr>

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
    <tr class="row_tr tr_all trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %> data-is-parent="<% if(rel_arr.length && rel_arr.indexOf(caseAutoId) != -1){ %>1<% } %>">
	<% }else {%>
    <tr class="row_tr tr_all trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %> data-is-parent="<% if(rel_arr.length && rel_arr.indexOf(caseAutoId) != -1){ %>1<% } %>">
	<% } %>		
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
		<div class="check-drop-icon" <% if(count == 1){ %>id="tour_task_title_listing_act"<% } %>>
			<div class="dropdown cmn_tooltip_hover">
				<a class="dropdown-toggle tooltip_link" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i><?php //&#xE5CF; ?>
				</a>
				<ul class="dropdown-menu hover_item">
         <% if(isAllowed("Change Status of Task",projectUniqid)){ %>
<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
    if(getdata.Easycase.CustomStatus.status_master_id != 3){ %>
		<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.status_master_id + '\'' %>,<%= '\'' + lastCustomStatus.LastCS.name  + '\'' %>);" id="new<%= caseAutoId %>">
        <a href="javascript:void(0);">
    	<span style="background-color:#<%= lastCustomStatus.LastCS.color %>;height: 11px;width: 11px;display: inline-block;"></span>
    	<%= lastCustomStatus.LastCS.name %></a>	
    	</li>
	<% } 
  } else{   %>

		<% var caseFlag="";
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

								<% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									
									if((getdata.Easycase.is_sub_sub_task==null) || (getdata.Easycase.is_sub_sub_task=='')){
									if(caseLegend !=3 && caseTypeId != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Create Sub task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } }%>
                          <% } %>
						  <% if(caseParenId){ %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToParentTask(<%= '\''+ caseAutoId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Convert To Parent Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
                                        </li>
                                      <?php } ?>
									 <% } %>
						  <% if(caseParenId == "" || caseParenId == null){ %>
							<%	if((getdata.Easycase.sub_sub_task==null) || (getdata.Easycase.sub_sub_task =="") || (getdata.Easycase.sub_sub_task ==0) ){  %>
							  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Convert To Sub Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
								  <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
							</li>
						  <?php } ?>
						  
						  <% } } %>

                                    <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                          <% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
									<% if(caseLegend ==3 ) { %>
										<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %>
											<li onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                    </li>
										<% } %>
									<% } else { %>
                                    <li onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                    </li>
                        <% } %>                                  
                  <% } %>                              
                                   
                          
						  
						  
                                    <?php } ?>
                                    <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                    <?php } ?>
                                   <% if((caseFlag == 5 || caseFlag==2) && getdata.Easycase.isactive == 1) { %>
                                    <!--<li class="divider"></li>-->
                                    <% } %>
                            <% if(isAllowed("Reply on Task",projectUniqid)){ %>
                                    <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                    if(getdata.Easycase.isactive == 1){ %>
                                    <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task List Page">
                                        <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                        <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                    </li>
                                    <% } %>
                         <% } %>
                                   <% if( SES_ID == caseUserId) { caseFlag=3; }
                                    if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %> 
                        <% if( (isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit ) || isAllowed('Edit All Task',projectUniqid)){ %>  
                                    <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid) || (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit)){ %>display:block <% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                    </li>
                            <% } %>
							
							
                            <% if(isAllowed("Change Other Details of Task",projectUniqid)){ %>
                                     <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononCopy || isAllowed('Change Other Details of Task',projectUniqid)){ %>display:block <% } else { %>display:none<% } %>">
                                          <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                    </li>
                             <% } %>       
                                    <% }
                                    if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                    if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
                                <% if(isAllowed("Move to Project",projectUniqid)){ %>                             
                                        <% if(getdata.Easycase.isactive == 1){ %>
                                                <li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
                                                        <a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
                                                </li>
                                        <% } %>
                                <% } %>
                                        <% if(getdata.Easycase.isactive == 0){ %>
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
					if(getdata.Easycase.isactive == 1 &&  getdata.Easycase.pjMethodologyid != 2){ %>
                          <% if(isAllowed("Move to Milestone",projectUniqid)){ %> 
                                        <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                        </li>
                                        <% } %>
                                        <% } %>
                                        <% if(getdata.Easycase.milestone_id){ %>
                                        <% if(isAllowed("Move to Milestone",projectUniqid)){ %>
                                        <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                        </li>
                                        <% } %>
                                        <% } %>
                                        <!--<li class="divider"></li>-->
                                        <% if(getdata.Easycase.isactive == 1){
                                                            if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id || isAllowed('Delete All Task',projectUniqid))) {
                                                            caseFlag = "remove";%>
                                        <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>
                                        <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                        </li>
                                        <% } %>
                                        <%
					}
					}
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
					if(getdata.Easycase.isactive == 1){ %>
                  <% if(isAllowed("Archive Task",projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %>
                                        <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                        </li>
                  <% } %>
                                        <% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
					if(getdata.Easycase.isactive == 1){ %>
               <% if(isAllowed("Delete Task",projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %>  
                                        <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                        </li>
                                        <% } %>
                                        <% } %>
				</ul>
			</div>
		</div>
	</td>	
        <td class="favo-td">
            <span class="ttype_global tt_<%= getttformats(getdata.Easycase.csTdTyp[1])%>" style="margin-top:2px;">
            </span>
            <span id="caseProjectSpanFav<%=caseAutoId %>">
           <a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(<%=caseAutoId %>,<%=projId %>,<%= '\''+caseUniqId+'\'' %>,1,<%=isFavourite%>)" rel="tooltip" original-title="<%=favMessage%>" style="color:<%=favouriteColor%>;">
           <% if(isFavourite) { %>
                <i class="material-icons" style="font-size:18px;">star</i>
            <% }else{ %>
                 <i class="material-icons" style="font-size:18px;">star_border</i>
            <% } %>
        </a>
            </span>
        </td>
	<td class="relative list-cont-td" <% if(count == 1){ %>id="tour_task_title_listing"<% } %>>
		<div class="title-dependancy-all">
			<a href="javascript:void(0);" class="ttl_listing" data-task-id="<%= caseUniqId %>">
				<span id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>">
					<span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
						<%= formatText(ucfirst(caseTitle)) %>
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
				<div class="task_dependancy parenttt fr">
					<% if(getdata.Easycase.parent_task_id && getdata.Easycase.parent_task_id != ""){ %>
						<span class="fl case_act_icons task_parent_block" id="task_parent_id_block_<%= caseUniqId %>">
							<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.parent_task_id + '\'' %>);" class="fl parent_sub_icons"><i class="material-icons">&#xE23E;</i></div>
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
		<span class="created-txt"><% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %></span>
		<span class="list-devlop-txt dropdown">
      <a class="dropdown-toggle"  <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>  data-toggle="dropdown" href="javascript:void(0);"<% } %>  data-target="#">
				<i class="material-icons tag_fl">&#xE54E;</i>
				<span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>clsptr<% } %>" title="<%= getdata.Easycase.csTdTyp[1] %>" >
					<span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= getdata.Easycase.csTdTyp[1]%><span class="due_dt_icn"></span></span>
				</span>
			</a>				
			<span id="typlod<%= caseAutoId %>" class="type_loader">
				<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
			</span>				
                        <% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>
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
				  <li onclick="changeCaseType(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>); changestatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + t + '\'' %>, <%= '\'' + t1 + '\'' %>, <%= '\'' + t2 + '\'' %>, <%= '\'' + caseUniqId + '\'' %>)">
					<a href="javascript:void(0);">
                                        <span class="ttype_global tt_<%= getttformats(t2)%>">
					<%= t2 %></span>
                                        </a>
				  </li>
				<% }
        } %>
				</ul>					
                        <% } %>
		</span>
		
		<span class="check-drop-icon dsp-block">
			<span class="dropdown">
        <a class="dropdown-toggle" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %>data-toggle="dropdown" href="javascript:void(0);"<% } %>  data-target="#">
				  <i class="material-icons">&#xE5C5;</i>
				</a>
				<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>
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
				  <li onclick="changeCaseType(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>); changestatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + t + '\'' %>, <%= '\'' + t1 + '\'' %>, <%= '\'' + t2 + '\'' %>, <%= '\'' + caseUniqId + '\'' %>)">
					<a href="javascript:void(0);">
					<span class="ttype_global tt_<%= getttformats(t2)%>">
					<%= t2 %></span>
                                        </a>
				  </li>
				<% }
        } %>
				</ul>					
				<% } %>
			</span>
		</span>
            <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" onclick="showRecurringInfo(<%= caseAutoId %>);" class="recurring-icon"><i class="material-icons">&#xE040;</i></a>
            <% } %>
		<span class="small-list-devlop-icon">
			<% var caseFlag=""; 					
				if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == 2){ %>
				<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){ }else{ %>
				<% if(isAllowed('Change Status of Task',projectUniqid)){ %>
        <a rel="tooltip" title="<?php echo __('Resolve');?>" href="javascript:void(0)" onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);">
					<i class="material-icons">&#xE889;</i>
				</a>
        <% } %>
				<% } } }
				if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4 || caseLegend == 5) && caseTypeId != 10) { caseFlag=5; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == 5) {	%>
        <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
				<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){ %>
          <% if(isAllowed("Status change except Close",projectUniqid)){ %>
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);">
					<i class="material-icons">&#xE876;</i>
				</a>
        <% } %>
				<% }else{ %>
            <% if(isAllowed("Status change except Close",projectUniqid)){ %>
					<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);">
						<i class="material-icons">&#xE876;</i>
					</a>
          <% } %>
				<% } } } } %>					
				<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                              <% if(isAllowed("Manual Time Entry",projectUniqid)){ %>
							  <% if(caseLegend ==3 ) { %>
										<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %>
                                    <span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"></span>
                                  <% } %>
								   <% } else{ %>
                                    <span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"></span>
                                  <% } %>
								    <% } %>
				<?php } ?>
				<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                if (getdata.Easycase.isactive == 1) { 
                                %>
                                <% if(isAllowed('Change Status of Task',projectUniqid)){ %>
                                <a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 7){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task List Page" rel="tooltip" title="<?php echo __('Re-open');?>"><i class="material-icons">&#xE898;</i></a>
                                <% } %>
                                <% if(isAllowed('Reply on Task',projectUniqid)){ %>
                                <a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 8){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task List Page" rel="tooltip" title="<?php echo __('Reply');?>"><i class="material-icons">&#xE15E;</i></a>
                              <% } %>
				<% }
				if( SES_ID == caseUserId) { caseFlag=3; }
				if(getdata.Easycase.isactive == 1){ 
				if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %>
         <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %> 
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);">
					<i class="material-icons">&#xE254;</i>
				</a>
      <% } %>
				<% } } %>	
				<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
          <% if(isAllowed("Manual Time Entry",projectUniqid)){ %> 
					<% if(caseLegend ==3 ) { %>
						<% if(isAllowed("Time Entry On Closed Task",projectUniqid)){ %>
                                <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
								<i class="material-icons">&#xE8B5;</i>
								</a>
						<% } %>
				<% } else { %>
                                <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task List Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
					<i class="material-icons">&#xE8B5;</i>
				</a>
      <% } %>
		<% } %>
				<?php } ?>
				<%
				if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == "archive"){ %>
          <% if(isAllowed('Archive Task',projectUniqid) || isAllowed("Archive All Task",projectUniqid)){ %> 
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);">
					<i class="material-icons">&#xE149;</i>
				</a>
      <% } %>
				<% } }
				if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == "delete"){ %>
           <% if(isAllowed('Delete Task',projectUniqid) || isAllowed("Delete All Task",projectUniqid)){ %> 
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);">
					<i class="material-icons">&#xE872;</i>
				</a>
      <% } %>
				<% } } %>
		</span>
	</div>
</td>
<td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="kanbancasecount<%= count %>"style="cursor:pointer;"<% } %>>
	<a href="javascript:void(0);" <% if(getdata.Easycase.format != 1 && getdata.Easycase.format != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
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
  <span id="showUpdAssign<%= caseAutoId %>" <% if(isAllowed('Change Assigned to',projectUniqid)){ %>   data-toggle="dropdown" <% } %> title="<%= getdata.Easycase.asgnName %>" class="clsptr" onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)"><%= getdata.Easycase.asgnShortName %><span class="due_dt_icn"></span></span>
	<% } else { %>
	<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= getdata.Easycase.asgnShortName %></span>
	<% } %>
	<% if((projUniq != 'all') && showQuickActiononList){ %>
	<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>			
	<span class="check-drop-icon dsp-block" <% if((projUniq != 'all') && showQuickActiononList){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)" <% } %>>
		<span class="dropdown">
      <a class="dropdown-toggle" <% if(isAllowed('Change Assigned to',projectUniqid)){ %> data-toggle="<% if((projUniq != 'all') && showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);" <% } %>  data-target="#">
                                <% if((projUniq != 'all') && showQuickActiononList){ %>
			  <i class="material-icons">&#xE5C5;</i>
                                <% } %>
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
<td  class="text-center <% if(getdata.Easycase.csTdTyp[1] != 'Update'){ %>task_priority csm-pad-prior-td<% }else{ %>csm-pad12-prior-td<% } %>">
    <% var csLgndRep = getdata.Easycase.legend; %>
    <% if(getdata.Easycase.csTdTyp[1] == 'Update'){ %>
        <span class="prio_high prio_lmh prio_gen" rel="tooltip" title="<?php echo __('Priority');?>:<?php echo __('high');?>"></span>
    <% }else{ %>
    <div style="" id="pridiv<%= caseAutoId %>" data-priority ="<%= casePriority %>" class="pri_actions <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> <% if(showQuickActiononList){ %> dropdown<% } %> <% } %>">    
        <div class="dropdown cmn_h_det_arrow lmh-width">
        <div <% if(showQuickActiononList){ %> class="quick_action" <% if(isAllowed('Change Other Details of Task',projectUniqid)){ %> data-toggle="dropdown" style="cursor:pointer" <% } %> <% } %> ><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>:<%= easycase.getPriority(casePriority) %>"></span><i class="tsk-dtail-drop material-icons">&#xE5C5;</i></div>
        <% var csLgndRep = getdata.Easycase.legend; %>
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
	<td class="esthrs_dt_tlist" style="text-align:center">
    <p class="estblist ttc <% if(!isAllowed('Est Hours',projectUniqid)){ %> no-pointer<% } %>"  style="cursor:pointer;" id="est_blist<%=caseAutoId%>" case-id-val="<%=caseAutoId%>" >
			<span class="border_dashed">
				<% if(caseEstHours) { %> <%= caseEstHours %> <% } else { %><?php echo __('None');?><% } %>
			</span>
		</p>
		
		<% var est_time = Math.floor(caseEstHoursRAW/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
		
		<input type="text" data-est-id="<%=caseAutoId%>" data-est-no="<%=caseNo%>" data-est-uniq="<%=caseUniqId%>" data-est-time="<%=est_time%>" id="est_hrlist<%=caseAutoId%>" class="est_hrlist form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can add time as 1.5(that mean 1 hour and 30 minutes) and press enter to save');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
		
		<span id="estlod<%=caseAutoId%>" style="display:none;margin-left:0px;">
			<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
		</span>
	</td>
<% } %>
<!--  add spenthr start-->
<% if(inArray('Spent Hours',field_name_arr)){ %>
	<td class="border-right-td esthrs_dt_tlist text-center">
    <p style="cursor:auto;" >
			<span >
			<% if(caseSpentHrs) { %> <%= caseSpentHrs %> <% } else { %><?php echo __('None');?><% } %>
			</span>
		</p>
		
		
		
	</td>
<% } %>

<% if(inArray('Updated',field_name_arr)){ %>
<td class="text-center" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('updated');?><% } else { %><?php echo __('created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> <%= getdata.Easycase.fbstyle %>."><%= getdata.Easycase.fbstyle %></td>
<% } %>
<% if(inArray('Status',field_name_arr)){ %>
<td>
<div class="cs_select_dropdown">
<span id="csStsRep<%= count %>" class="cs_select_status">
<% if(isactive==0){ %>
	<div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
<%}else if(groupby =='' || groupby !='status'){
  if(getdata.Easycase.custom_status_id != 0 && getdata.Easycase.CustomStatus != null ){ %>
	<%= easycase.getCustomStatus(getdata.Easycase.CustomStatus, getdata.Easycase.custom_status_id) %>
<% }else{ %>
  <%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
 <% }
    } %>
</span>
<span class="check-drop-icon dsp-block">
	<span class="cmn_h_det_arrow dropdown">
		<a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
			<i class="material-icons">&#xE5C5;</i>
		</a>
		<ul class="dropdown-menu">
		<% if(isAllowed("Change Status of Task",projectUniqid)){
					if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
						$.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
							if(getdata.Easycase.CustomStatus.id != data.id){
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
						if(getdata.Easycase.isactive == 1){ %>
							<li onclick="setNewCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="new<%= caseAutoId %>" style=" <% if(caseFlag == "9"){ %>display:block<% } else { %>display:none<% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
							</li>
						<% }
						 if((caseLegend != 2 && caseLegend != 4) && caseTypeId!= 10) { caseFlag=1; }
						if(getdata.Easycase.isactive == 1) { %>
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
						if(getdata.Easycase.isactive == 1){ %>
							<li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
								<a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
							</li> 
						<% }
						if((caseLegend != 3) && caseTypeId != 10) { caseFlag=5; }
						if(getdata.Easycase.isactive == 1){
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
	<div class="<% if(getdata.Easycase.csDueDate == '' || getdata.Easycase.legend == 5 || getdata.Easycase.type_id == 10 || getdata.Easycase.legend == 3){ %> toggle_due_dt <% } %>">
	<% if(getdata.Easycase.isactive == 1){ %>
	<% if(showQuickActiononList && caseTypeId != 10){ %>
	<?php /*
	<span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
	*/?>
	<% } %>
	<span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= getdata.Easycase.csDuDtFmtT %>">
		<%= getdata.Easycase.csDuDtFmt %>
	</span>
	<span id="datelod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>
	<span class="check-drop-icon dsp-block">
		<span class="dropdown">
      <a class="dropdown-toggle" <% if(isAllowed('Update Task Duedate',projectUniqid)){ %> data-toggle="<% if(showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);" <% } %>  data-target="#">
			  <i class="material-icons">&#xE5C5;</i>
			</a>
			<ul class="dropdown-menu">
				<li class="pop_arrow_new"></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>);changeDueDate(<%= '\'' + caseAutoId + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId + '\'' %>)"><?php echo __('No Due Date');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyCurCrtd + '\', \'Today\', \'' + caseUniqId + '\'' %>)"><?php echo __('Today');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId + '\'' %>)"><?php echo __('Tomorrow');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyMonday + '\', \'Next Monday\', \'' + caseUniqId + '\'' %>)"><?php echo __('Next Monday');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyFriday + '\', \'This Friday\', \'' + caseUniqId + '\'' %>)"><?php echo __('This Friday');?></a></li>
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
	<div class="overdueby_spn overdueby_spn_<%= caseAutoId %>"><% if(showQuickActiononList){ %><%= getdata.Easycase.csDuDtFmtBy %><% } %></div>
</td>
<% } %>
<% if(inArray('Progress',field_name_arr)){ %>
<td class="progress_tlist text-center"><%= getdata.Easycase.completed_task %>%</td>
<% } %>		
</tr>
<%
		totids += caseAutoId + "|";
	}
    }
    if(!caseCount || caseCount==0){
    var case_type = $("#caseMenuFilters").val(); 
	
	
	%>
    <tr class="empty_task_tr">
        <td colspan="12" align="center" class="colr_red">
            <% 
			if(QTAssigns==null){

	       }			
			if(case_type == 'cases' || case_type == ''){
				if(filterenabled){%>
					<?php echo __('No Task Found');?>.
            <% }else{ 
			if(QTAssigns==null){ %>
		     <?php echo $this->element('no_data', array('nodata_name' => 'assigntomeproject','case_type'=>'')); ?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'')); ?>
				
			<% } %>
           
            <% } %>
            <% }else if(case_type == 'assigntome'){
				if(filterenabled){ %>
					<?php echo __('No tasks for me');?>
            <% }else{			
			if(QTAssigns==null){ %>
		     <?php echo $this->element('no_data', array('nodata_name' => 'assigntomeproject','case_type'=>'')); ?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'assigntome')); ?>
				
			<% } %>           
            <% } %>
            <% }else if(case_type == 'overdue'){
				if(filterenabled){ %>
					<?php echo __('No tasks as overdue');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'overdue')); ?>
            <% } %>
            <% }else if(case_type == 'delegateto'){
				if(filterenabled){ %>
					<?php echo __('No tasks delegated');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'delegateto')); ?>
            <% } %>
            <% }else if(case_type == 'highpriority'){
				if(filterenabled){ %>
					<?php echo __('No high priority tasks');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'highpriority')); ?>
            <% } %>
            <% }else if(case_type == 'favourite'){
                if(filterenabled){ %>
                        <?php echo __('No favourite tasks');?>
            <% }else{ %>
            
             <?php echo __('No favourite tasks');?>
            <% } %>
            <% } %>
        </td>
    </tr>
    <% } %>
    </tbody>
    </table>
	</div>
    <% $("#task_paginate").html('');
    if(caseCount && caseCount!=0) {
            var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
            $("#task_paginate").html(tmpl("paginate_tmpl", pageVars));
    } %>

    <% if(isAllowed('Create Task',projectUniqid)){ %>
	<div class="crt_task_btn_btm <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT && $_SESSION['KEEP_HOVER_EFFECT'] && (($_SESSION['KEEP_HOVER_EFFECT'] & 8) == 8)){ ?>keep_hover_efct<?php } ?>">
			<span  class="hide_tlp_cross" title="<?php echo __('Close');?>" onclick="resetHoverEffect(<%= '\'task\'' %>, this);">&times;</span>
        <div class="os_plus">
			<div class="ctask_ttip">
				<span class="label label-default"><?php echo __('Create Task');?></span>
			</div>
 			<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task List Page Big Plus\'' %>, <%= '\'Create Task\'' %>);creatask();"> 
				<img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
				<img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
			</a>
        </div>
	</div>
<% } %>
</div>

<% } else if(GrpBy == 'milestone'){ %>

<div class="task_listing task-grouping-page">
			<div id="widgethideshow" class="fl task-list-progress-bar fix-status-widget" <?php if(strtotime("+2 months",strtotime(CMP_CREATED))>=time()){?><?php }?>>
            <span id="task_count_of" style="float:left;display:block;"></span>
              <span class="pr fl inner_search_span" onclick="slider_inner_search(<%= '\'open\'' %>);">   
                <i class="material-icons clear_close_icon" title="<?php echo __('Clear search');?>" id="clear_close_icon" onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Search Task\'' %>); clearSearch(<%= '\'inner\'' %>);">close</i>
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
        <div class="task-m-overflow cstm_responsive_tbl task_scrollable_list">
            <table class="table table-striped table-hover compactview_tbl">
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
                                <span class="dropdown custom_th_drdown cmn_tooltip_hover">
                                        <a class="dropdown-toggle mass_action_dpdwn tooltip_link" data-toggle="" href="javascript:void(0);">
                                          <i title="<?php echo __('Choose at least one task');?>" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>
                                        </a>
                                        <ul class="dropdown-menu hover_item" id="dropdown_menu_chk">
                                          <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
										  <% if(typeof curProjId != "undefined" && typeof curProjId != "null" &&  typeof customStatusByProject !="undefined" && typeof customStatusByProject[curProjId] !='undefined' && customStatusByProject[curProjId] != null){
											 $.each(customStatusByProject[curProjId], function (key, data) {
											  %>
                        <% if(data.status_master_id == 3){ %>
                          <% if(isAllowed("Status change except Close",projectUniqid)){ %>
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
												<%= data.name %></a>	
												</li>
                        <% } %>
											 <%    
												}); 
											  }else{ %>
                                          <li>
                                                <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseNew\'' %>)"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseStart\'' %>)"><i class="material-icons">&#xE039;</i><?php echo __('Start');?></a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseResolve\'' %>)"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                                            </li>
                                            <% if(isAllowed("Status change except Close",projectUniqid)){ %>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i><?php echo __('Close');?></a>
                                            </li>
											  <% } %>
											  <% } %>
                                          <?php } ?>
                                            <?php if(SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Archive All Task',$roleAccess)) {?>
                                              <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
                                            <li>
                                                    <a href="javascript:void(0);" onclick="archiveCase(<%= '\'all\'' %>)"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                            </li>
                                          <?php } ?>
                                           <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
											<li>
                                                <a href="javascript:void(0);" onclick="ajaxassignAllTaskToUser(<%= '\'movetop\'' %>);"><i class="material-icons">&#xE7FD;</i><?php echo __('Assign task(s) to user');?></a>
											</li>
                    <?php } ?>
                    <?php if($this->Format->isAllowed('Move to Project',$roleAccess)){ ?>
                                            <li id="mvTaskToProj">
                                                <a href="javascript:void(0);" onclick="mvtoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to project');?></a>
                                            </li>
                                          <?php } ?>
                                          <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                            <li id="cpTaskToProj">							
                                                <a href="javascript:void(0);" onclick="cptoProject(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'movetop\'' %>)"><i class="material-icons">&#xE14D;</i><?php echo __('Copy to Project');?></a>
                                            </li>
                                          <?php } ?>
                                            <?php } ?>
                                        </ul>
                                </span>
                        </div>
							</div>
                        </th>
              <th class="wth_2">                           
                            <a href="javascript:void(0);" title="<?php echo __('Task');?>#" onclick="ajaxSorting(<%= '\'caseno\', ' + caseCount + ', this' %>);" class="sortcaseno">
                                #<span class="sorting_arw">
                                <% if(typeof csNum != 'undefined' && csNum != "") { %>
                                        <% if(csNum == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %>
                                </span>								
                            </a>
                        </th>
            <th class="wth_3"></th>
                <th class="wth_4">
                            <a class="sorttitle" href="javascript:void(0);" title="<?php echo __('Title');?>" onclick="ajaxSorting(<%= '\'title\', ' + caseCount + ', this' %>);">
                                <?php echo __('Title');?><span class="sorting_arw">
                                <% if(typeof csTtl != 'undefined' && csTtl != "") { %>
                                        <% if(csTtl == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %>
                                </span>
                            </a>
                        </th>
            <th class="wth_5"></th>
                        <% if(inArray('Assigned to',field_name_arr)){ %>
            <th class="width_assign wth_6">
                            <% if(1 || GrpBy != 'milestone'){ %>
                            <a class="sortcaseAt" href="javascript:void(0);" title="<?php echo __('Assigned to');?>" onclick="ajaxSorting(<%= '\'caseAt\', ' + caseCount + ', this' %>);">
                                <?php echo __('Assigned to');?>
                                <span class="sorting_arw">
                                <% if(typeof csAtSrt != 'undefined' && csAtSrt != "") { %>
                                        <% if(csAtSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %>
                                </span>
                            </a>
                            <% }else{ %>
                                <div class="fl"><?php echo __('Assigned to');?></div>
                            <% } %>
                        </th>
                        <% } %>
                        <% if(inArray('Priority',field_name_arr)){ %>
            <th class="width_priority text-center wth_7">
                            <a class="sortprioroty" href="javascript:void(0);" title="<?php echo __('Priority');?>" onclick="ajaxSorting(<%= '\'priority\', ' + caseCount + ', this' %>);">
                                <?php echo __('Priority');?>
                                <span class="sorting_arw">
                                <% if(typeof csPriSrt != 'undefined' && csPriSrt != "") { %>
                                        <% if(csPriSrt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %>
                                </span>
                            </a>
                        </th>
                        <% } %>
			<% if(inArray('Estimated Hours',field_name_arr)){ %>
            <th class="tsk_est_hours wth_10" style="text-align:center">
				<a class="sortestimatedhours" href="javascript:void(0);" title="<?php echo __('Est. Hours');?>" onclick="ajaxSorting(<%= '\'estimatedhours\', ' + caseCount + ', this' %>);">
					<?php echo __('Est. Hours');?>
					<span class="sorting_arw">
						<% if(typeof csEstHrsSrt != 'undefined' && csEstHrsSrt != "") { %>
							<% if(csEstHrsSrt == 'asc'){ %>
									<i class="material-icons tsk_asc">&#xE5CE;</i>
							<% }else{ %>
									<i class="material-icons tsk_desc">&#xE5CF;</i>
							<% } %>								
						<% }else{ %>
							<i class="material-icons">&#xE164;</i>
						<% } %>
					</span>
				</a>
			</th>
		  <% } %>			
          <% if(inArray('Updated',field_name_arr)){ %>
            <th class="width_update text-center wth_8">
                            <a class="sortupdated" href="javascript:void(0);" title="<?php echo __('Updated');?>" onclick="ajaxSorting(<%= '\'updated\', ' + caseCount + ', this' %>);">
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
                        <% } %>
          <% if(inArray('Status',field_name_arr)){ %>
            <th class="width_status wth_9">
                                <?php echo __('Status');?>
                        </th>
                        <% } %>
          <% if(inArray('Due Date',field_name_arr)){ %>
            <th class="tsk_due_dt wth_10">
                            <a class="sortduedate" href="javascript:void(0);" title="<?php echo __('Due Date');?>" onclick="ajaxSorting(<%= '\'duedate\', ' + caseCount + ', this' %>);">
                                <?php echo __('Due Date');?>
                                <span class="sorting_arw">
                                <% if(typeof csDuDt != 'undefined' && csDuDt != "") { %>
                                        <% if(csDuDt == 'asc'){ %>
                                                <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                                <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                <% } %>
                                </span>
                            </a>
                        </th>
                        <% } %>
                        <% if(inArray('Progress',field_name_arr)){ %>
                          <th class="width_progress text-center wth_71">
                            <span class="progresselipsis"><?php echo __('Progress');?></span>
                          </th>
                        <% } %>											
                      </tr>
              </thead>
              <tbody> 
                 <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
                    <tr class="qtask quicktskgrp_tr_lnk">
                          <td colspan="9">
                              <div class="new_qktaskgrp_mc">
                                  <div class="" id="new_grp_label" style="width: 150px;"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task Group');?></a></div>
                              </div>                               
                          </td>
                    </tr>
                    <tr class="quicktskgrp_tr">
                    <td colspan="4">
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
                  <?php } ?>
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
                               for(var mkey in all_milesto_names){ mki++; 
  if(!milesto_names[mkey] && csPage == 1){ %>					  
					<tbody>
					 <tr class="tgrp_tr_all task_group_accd task_group_bg_clr" id="empty_milestone_tr<%= all_milesto_names[mkey]['id'] %>" data-pid="<%= all_milesto_names[mkey]['project_id']%>">
						<td colspan="12" class="pr">
							 <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
								<div class="fl os_sprite dot-bar-group"></div>  
							<?php } ?>
							 <% accordianClass='plus-minus';
							 for(i=0;i < check_ids_array.length;i++){
								if(check_ids_array[i]== all_milesto_names[mkey]['id']){
								accordianClass="minus-plus hideSub";                                               
								}
								}%>
						<div class="plus-minus-accordian">
							<div class="fl"><span class="os_sprite <%= accordianClass %> os_sprite<%= all_milesto_names[mkey]['id'] %>" onclick="collapse_taskgroup(this);"></span></div>
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
                   <?php if($this->Format->isAllowed('Add Tasks to MIlestone',$roleAccess)){ ?>
									<li onClick="addTaskToMilestone(<%= '\'\',\''+ all_milesto_names[mkey]['id'] + '\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>,0,1)">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
										</a>
									</li>							
										<li onClick="convertToTask(this, <%= '\''+ all_milesto_names[mkey]['id'] + '\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>,0,1)"  id="convrt_task_<%= all_milesto_names[mkey]['id'] %>">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE15A;</i><?php echo __('Convert to Task');?>
										</a>
									</li>	
									<li class="makeHover" onclick="addEditMilestone(0,<%= '\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]["id"] %>,<%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>,1,<%= '\'taskgroup\'' %>,<%= '\'' + all_milesto_names[mkey]["project_id"] + '\'' %>)">
										<a href="javascript:void(0)" class="mnsm">
											<i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
										</a>
									</li>
                  <?php } ?>  
									<% } %>
                  <?php if($this->Format->isAllowed('Delete Milestone',$roleAccess)){ ?>
									<li class="makeHover" onclick="delMilestone(0,<%= '\'' + escape(all_milesto_names[mkey]["title"]) + '\'' %>, <%= '\'' + all_milesto_names[mkey]["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]["id"] %>);">
										<a href="javascript:void(0);" class="mnsm">
											<i class="material-icons">&#xE872;</i><?php echo __('Delete');?> 
										</a>                                          
									</li>
                <?php } ?>
                <?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>
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
                  <?php } ?>
								</ul>
							</span>
							</div>
							<div class="fl accord_cnt_txt">
								<div class="empty_milstone_holder top_ms ">
									<div class="__a" onclick="collapse_by_title('<%= all_milesto_names[mkey]['id'] %>',<%= all_milesto_names[mkey]["project_id"] %>);">
									<a id="miview_<%= all_milesto_names[mkey]['id'] %>" href="javascript:void(0);" title="<%= all_milesto_names[mkey]['title'] %>" <% if(all_milesto_names[mkey]['isactive'] != 1){ %> class="taskCompleted"<% } %>>
									  <%= all_milesto_names[mkey]['title'] %> 
									</a>
                  <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
									<div class="form-group label-floating pr edit_task_group" id="miviewtxtdv_<%= all_milesto_names[mkey]['id'] %>" style="display:none;">
									  <label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
									  <input style="display:none;" class="form-control mviewtxt" type="text" id="miviewtxt_<%= all_milesto_names[mkey]['id'] %>" onkeyup="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,0);" onblur="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,1);" />
									  <span class="input-group-btn">
										  <button onclick="inlineEditMilestone(event,<%= all_milesto_names[mkey]['id'] %>,1);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="<?php echo __('Save');?>">
											<i class="material-icons">send</i>
										  </button>
										</span>
									</div>   
                  <?php } ?> 
									<p class="n_cnt_grpt_<%= all_milesto_names[mkey]['id'] %> <% if(all_milesto_names[mkey]['isactive'] != 1){ %>taskCompleted<% } %>">(<span id="miviewspan_<%= all_milesto_names[mkey]['id'] %>">0</span>)</p>
								</div>
								</div>
							</div>
              <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
								 <div class="fl taskgroup-pencil <% if(all_milesto_names[mkey]['id'] > 0){ %> <%='showEditTaskgroup'+ all_milesto_names[mkey]['id'] %> <% }else{ %> <%='showEditTaskgroupdefault' %><% } %>" 
											<% if(all_milesto_names[mkey]['id'] > 0){ %>
													onclick="showhideinlinedit( <%= all_milesto_names[mkey]['id'] %> );"
													<% }else{ %>
													onclick="showhideinlinedit(<%= '\'default\'' %>);"
													<% } %>
													>

												<a href="javascript:void(0);" title="<?php echo __('Edit');?>"><i class="material-icons">&#xE254;</i></a>
							</div>
						<?php } ?>
							<div class="fl tskg-add-btn n_tsk_grpt_<%= all_milesto_names[mkey]['id'] %>">
								<% if(all_milesto_names[mkey]['isactive']!=0){ %>
								<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
												<a href="javascript:void(0);" class="btn btn-raised btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk" onclick="setSessionStorage(<%= '\'Task Group Page Add Task\'' %>, <%= '\'Create Task\'' %>);creatask(<%= all_milesto_names[mkey]['id'] %>)"><?php echo __('Add Task');?></a>   
												<?php } ?>  
								<% } %>
								<% if(all_milesto_names[mkey]['isactive'] != 1){ %>
								<?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>
								<a class="add_ntsk" href="javascript:void(0);" style="color:#F7C279;text-decoration:none;margin-top:3px;">
												<?php echo __('Completed');?>
								</a>
							<?php } ?>
								 <% } %>
							</div>
							<div class="cb"></div>
						</div>
						<div class="tg_extra_td tg_extra_hrdate">
							<span><?php echo __('Est. Hr');?>: <strong id="tg_spn_est_id<%= all_milesto_names[mkey]['id'] %>"><%= all_milesto_names[mkey]['estimated_hours'] %></strong></span>
							<span><?php echo __('Start Date');?>: <strong id="tg_spn_st_id<%= all_milesto_names[mkey]['id'] %>"><%= all_milesto_names[mkey]['start_date'] %></strong></span>
							<span><?php echo __('End Date');?>: <strong id="tg_spn_ed_id<%= all_milesto_names[mkey]['id'] %>"><%= all_milesto_names[mkey]['end_date'] %></strong></span>
						</div>
						<div class="cb"></div>
						</td>
						</tr>
							<% var d_mid_empty = all_milesto_names[mkey]['id']; if(d_mid_empty == 'NA'){ d_mid_empty = 0;} %>
									<% if(d_mid_empty == 0 || (d_mid_empty != 0 && all_milesto_names[mkey]['isactive'] == 1)){ %>
									<tr class="white_bg_tr">
													<td class="prtl"><div class="wht-bg"></div></td>
													<td colspan="11" class="transp_bg">
													<div class="width40">
													<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
																	<div class="form-group label-floating">
																					<div id="inlin_qtsk_link<%= d_mid_empty %>"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr" onclick="showhidegroupqt(<%= d_mid_empty %>);"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task');?></a></div>
																					<div style="display:none;" class="input-group" id="inlin_qtsk_c<%= d_mid_empty %>">
																					<label class="control-label" for="addon3a"><?php echo __('Quick Task');?></label>
																					<input data-mid="<%= d_mid_empty %>" id="addon<%= d_mid_empty %>" class="in_qt_taskgroup form-control inline_qktask<%= d_mid_empty %>" type="text" onblur="showhidegroupqt(<%= d_mid_empty %>,1);">
																					<span class="input-group-btn">
																									<button data-mid="<%= d_mid_empty %>" type="button" class="btn btn-fab btn-fab-mini in_qt_taskgroupbtn">
																									<i class="material-icons qk_send_icon_tg<%= d_mid_empty %>">send</i>
																									</button>
																					</span>
																					</div>
																	</div>
																<?php } ?>
													</div>
									</td>
							</tr>
								<% } %>
									<tr class="empty_task_tr"><td></td><td colspan="11" align="center" class="textRed"><?php echo __('No Tasks found');?></td></tr>
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
		var caseEstHoursRAW = getdata.Easycase.estimated_hours;
		var caseEstHours = getdata.Easycase.estimated_hours_convert;
		var isactive = getdata.Easycase.isactive;
		var caseAssgnUid = getdata.Easycase.assign_to;
		var getTotRep = 0;
		var caseParenId = getdata.Easycase.parent_task_id;
		
		if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
			getTotRep = getdata.Easycase.reply_cnt;
		}
		var getTotRepCnt = (getdata.Easycase.case_count)?getdata.Easycase.case_count:0;
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
    var showQuickActiononListEdit = 0;
		/*if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (caseUserId== SES_ID))) {
			var showQuickActiononList = 1;
		}*/
                if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (caseUserId== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
                    showQuickActiononList = 1;
		}
    if(isactive == 1 && (caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && (caseUserId== SES_ID)){
              showQuickActiononListEdit = 1;
    }

		if(projUniq=='all' && (typeof getdata.Easycase.pjname !='undefined')){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}else if(projUniq!='all'){
			projectName = getdata.Easycase.pjname;
			projectUniqid = getdata.Easycase.pjUniqid;
		}
	%>
	
	<% if(groupby && groupby!='date'){
			if(groupby=='milestone' && (getdata.EasycaseMilestone.mid != prvGrpvalue)){ 
                        var tcount=0;
                        %>  
                        </tbody><tbody>
				<tr class="task_group_accd task_group_bg_clr" id="empty_milestone_tr<%= getdata.EasycaseMilestone.mid %>">
				<% if(getdata.EasycaseMilestone.mid == 'NA'){ %>
				<td colspan="12" class="pr">
				 <% var accordianClass='plus-minus';
						for(i=0;i < check_ids_array.length;i++){
						 if(check_ids_array[i]== getdata.EasycaseMilestone.mid){
						 accordianClass="minus-plus hideSub";
						 }
						 }
						 %>
                                         
         <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>                               
          <div class="fl os_sprite dot-bar-group"></div>
        <?php } ?>
            <div class="plus-minus-accordian">
                <div class="fl"><span class="os_sprite <%= accordianClass %> os_sprite<%= getdata.EasycaseMilestone.mid %>"  onclick="collapse_taskgroup(this);"></span></div>
                <div class="fl">
                    <span class="dropdown">
                            <a class="dropdown-toggle active tsk_grp_sett main_page_menu_togl" data-toggle="dropdown" href="" data-target="#">
                                    <i class="material-icons">&#xE5D4;</i>
                            </a>
                            <ul class="dropdown-menu aede-drop-text">
                              <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
                                    <li class="makeHover" onclick="addEditMilestone(0,<%= '\'default\'' %>,<%= '\'default\'' %>,<%= '\'Default Task Group\'' %>,1,<%= '\'taskgroup\'' %>)">
                                            <a href="javascript:void(0)" class="mnsm">
                                                    <i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
                                            </a>
                                    </li>
                                  <?php } ?>
                            </ul>
                    </span>
                </div>
                <div class="fl accord_cnt_txt">
                        <div class="empty_milstone_holder tsk_ttl pr">
                                <div class="fl __hold" onclick="collapse_by_title('<%= getdata.EasycaseMilestone.mid %>',<%= projId %>);" style="font-weight:normal">
                                        <a class="miview_a" id="miview_default" href="javascript:void(0);">
                                                <?php echo __('Default Task Group');?>
                                        </a>
                                        <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
                                        <div class="form-group label-floating edit_task_group pr" id="miviewtxtdv_default" style="display:none;">
                                        <label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
                                        <input style="display:none;" class="mviewtxt form-control" type="text" id="miviewtxt_default" onkeyup="inlineEditMilestone(event,<%= '\'default\'' %>,0);" onblur="inlineEditMilestone(event,<%= '\'default\'' %>,1);" />
                                        <span class="input-group-btn">
                                                <button onclick="inlineEditMilestone(event,<%= '\'default\'' %>,0);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="<?php echo __('Save');?>">
                                                <i class="material-icons">send</i>
                                                </button>
                                        </span>
                                </div>
                              <?php } ?>
                                    <p class="n_cnt_grpt_default">(<span id="miviewspan_NA">0</span>)</p>
                                </div>
                        </div>
                </div>
                <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
										<div class="fl taskgroup-pencil <% if(getdata.EasycaseMilestone.mid > 0){ %><%='showEditTaskgroup'+ getdata.EasycaseMilestone.mid %><% }else{ %><%='showEditTaskgroupdefault' %><% } %>" 
												<% if(getdata.EasycaseMilestone.mid > 0){ %>
												 onclick="showhideinlinedit( <%= getdata.EasycaseMilestone.mid %> );"
												 <% }else{ %>
												 onclick="showhideinlinedit(<%= '\'default\'' %>);"
												 <% } %>
												 >
											 <a href="javascript:void(0);" title="<?php echo __('Edit');?>"><i class="material-icons">&#xE254;</i></a>
									 </div>
								 <?php } ?>
								 <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
						<div class="fl n_tsk_grp tskg-add-btn" id="n_tsk_grp_default">
							<a href="javascript:void(0);" class="btn btn-raised btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk" data-toggle="dropdown" onclick="setSessionStorage(<%= '\'Task Group Page Default Task Group\'' %>, <%= '\'Create Task\'' %>);creatask()"><?php echo __('Add Task');?></a>
						</div>
          <?php } ?>
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
				<td colspan="12" class="pr">
					<?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
					 <div class="fl os_sprite dot-bar-group"></div>
				 <?php } ?>
					<div class="plus-minus-accordian">
						<% accordianClass='plus-minus';                                       
							for(i=0;i < check_ids_array.length;i++){
							 if(check_ids_array[i]== mile_id){
							 accordianClass="minus-plus hideSub";
							 
							 }
							 }                                         
							 %>
						<div class="fl"><span class="os_sprite <%= accordianClass%> os_sprite<%= mile_id %>" onclick="collapse_taskgroup(this);"></span></div>
						<div class="fl">
						<span class="dropdown n_tsk_grp" id="n_tsk_grp_<%= all_milesto_names[mkey]?all_milesto_names[mkey]['id']:1 %>">
							<a class="dropdown-toggle main_page_menu_togl active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
							<a class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
							  <i class="material-icons">&#xE5D4;</i>
							</a>
							<ul class="dropdown-menu sett_dropdown-caret aede-drop-text">			  
							  <li class="pop_arrow_new"></li>
										<% if(mile_isactive !=0){ %>
										<?php if($this->Format->isAllowed('Add Tasks to MIlestone',$roleAccess)){ ?>
										<li onClick="addTaskToMilestone(<%= '\'\',\''+ mile_id + '\'' %>,<%= '\'' + mile_project_id + '\'' %>,0,1)">
														<a href="javascript:void(0);" class="mnsm">
																		<i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
														</a>
										</li>							
									<?php } ?>
										<?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>						
										<li class="makeHover" onclick="addEditMilestone(0,<%= '\'' + mile_uniq_id + '\'' %>,<%= mile_id %>,<%= '\'' + escape(mile_title) + '\'' %>,1,<%= '\'taskgroup\'' %>,<%= '\'' + mile_project_id + '\'' %>)">
														<a href="javascript:void(0)" class="mnsm">
																		<i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
														</a>
										</li>
									<?php } ?>
										<% } %>
										<?php if($this->Format->isAllowed('Delete Milestone',$roleAccess)){ ?>
										<li class="makeHover delete_ntask delete_ntask_t drop_menu_mc">
														<a href="javascript:void(0);" class="mnsm">
																		<i class="material-icons">&#xE872;</i><?php echo __('Delete');?>
														</a>
														<ul class="dropdown_status_bk dropdown-menu drop_smenu full_left smenu_ddown width_180">
															<li class="li_check_radio"> <div class="radio radio-primary">
															  <label>
																<input name="dtaskgroup" type="radio" id="grp_rdio_<%= mile_id %>" onclick="delMilestone(0,<%= '\'' + escape(mile_title) + '\'' %>, <%= '\'' + mile_uniq_id + '\'' %>,<%= mile_id %>,1);"/> <?php echo __('Task Group');?>
																	</label>
												</div> 
												</li>
												<?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
															<li class="li_check_radio"> 
																<div class="radio radio-primary">
																  <label>
																		<input name="dtaskgroup" type="radio" id="grp_t_rdio_<%= mile_id %>"  onclick="delMilestone(0,<%= '\'' + escape(mile_title) + '\'' %>, <%= '\'' + mile_uniq_id + '\'' %>,<%= mile_id %>,2);"/><?php echo __('Task Group and Task');?>
															</label>
										</div> 
										</li>
									<?php } ?>
										</ul>
										</li>
								<?php } ?>
								<?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>
									<% if(mile_isactive !=0){ %>
									<li onclick="milestoneArchive(<%= '\'\',\'' + mile_uniq_id + '\'' %>, <%= '\'' + escape(mile_title) + '\'' %>,1);">
													<a href="javascript:jsVoid();" class="mnsm">
																	<i class="material-icons">&#xE86C;</i><?php echo __('Complete');?>
													</a>
									</li>
									<% }else{ %>
									<li onclick="milestoneRestore(<%= '\'\',\'' + mile_uniq_id + '\'' %>, <%= '\'' + escape(mile_title) + '\'' %>,1);">
													<a href="javascript:jsVoid();" class="mnsm">
																	<i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?>
													</a>
									</li>
									<% } %>
								<?php } ?>
							</ul>
						</span>
						</div>
						<div class="fl accord_cnt_txt ">
							<div class="fl __hold" onclick="collapse_by_title('<%= mile_id %>',<%= mile_project_id %>);" style="font-weight:normal">
								<a class="miview_a <% if(mile_isactive != 1){ %> taskCompleted<% } %>" id="miview_<%= mile_id %>" href="javascript:void(0);">
									<%= mile_title %> 
								</a>
                <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
								<div class="form-group edit_task_group pr label-floating" id="miviewtxtdv_<%= mile_id %>" style="display:none;">
												<label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
												<input style="display:none;" class="mviewtxt form-control" type="text" id="miviewtxt_<%= mile_id %>" onkeyup="inlineEditMilestone(event,<%= mile_id %>,0);" onblur="inlineEditMilestone(event,<%= mile_id %>,1);" />
												<span class="input-group-btn">
																<button onclick="inlineEditMilestone(event,<%= mile_id %>,0);" type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="<?php echo __('Save');?>">
																<i class="material-icons">send</i>
													</button>
												</span>
									</div>
									<?php } ?>
								<p class="n_cnt_grpt_<%= mile_id %> <% if(mile_isactive != 1){ %> taskCompleted<% } %>">(<span id="miviewspan_<%= mile_id %>">0</span>)</p>
							</div>
						</div>
            <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
							<div class="fl taskgroup-pencil <% if(mile_id > 0){ %> <%='showEditTaskgroup'+ mile_id %> <% }else{ %><%='showEditTaskgroupdefault' %><% } %>" 
									<% if(mile_id > 0){ %>
									 onclick="showhideinlinedit( <%= mile_id %> );"
									 <% }else{ %>
									 onclick="showhideinlinedit(<%= '\'default\'' %>);"
									 <% } %>
									 >
							 <a href="javascript:void(0);" title="<?php echo __('Edit');?>"><i class="material-icons">&#xE254;</i></a>
						 </div>
					 <?php } ?>
           <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
						<div class="fl tskg-add-btn n_tsk_grpt_<%= mile_id %>">
						<% if(mile_isactive !=0){ %>
							<a href="javascript:void(0);" class="btn btn-raised btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk" data-toggle="dropdown" onclick="setSessionStorage(<%= '\'Task Group Page Add Task\'' %>, <%= '\'Create Task\'' %>);creatask(<%= mile_id %>)"><?php echo __('Add Task');?></a>                                                                            
						<% } %>
						<% if(mile_isactive != 1){ %>
						<a class="add_ntsk" href="javascript:void(0);" style="color:#F7C279;text-decoration:none; margin-top:3px;">
							<?php echo __('Completed');?>
						</a>
					   <% } %>
						</div>
          <?php } ?>
						<div class="cb"></div>
					</div>
					<div class="tg_extra_td tg_extra_hrdate">
						<span><?php echo __('Est. Hr(s)');?>: <strong id="tg_spn_est_id<%= getdata.EasycaseMilestone.mid %>"><%= milesto_names[getdata.EasycaseMilestone.mid].estimated_hours %></strong></span>
						<span><?php echo __('Start Date');?>: <strong id="tg_spn_st_id<%= getdata.EasycaseMilestone.mid %>"><%= milesto_names[getdata.EasycaseMilestone.mid].start_date %></strong></span>
						<span><?php echo __('End Date');?>: <strong id="tg_spn_ed_id<%= getdata.EasycaseMilestone.mid %>"><%= milesto_names[getdata.EasycaseMilestone.mid].end_date %></strong></span>
					</div>
					<div class="cb"></div>
					</td>						 
				<% } %>
				</tr>
				<% prvGrpvalue= getdata.EasycaseMilestone.mid; %>
				<% var d_mid = getdata.EasycaseMilestone.mid; if(d_mid == 'NA'){ d_mid = 0;} %>
				<% if(d_mid == 0 || (d_mid != 0 && mile_isactive == 1)){ %>
				<tr class="white_bg_tr">
					<td class="prtl"><div class="wht-bg"></div></td>
					<td colspan="11" class="transp_bg">
					<div class="width40">
            <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
						<div class="form-group label-floating">
							<div id="inlin_qtsk_link<%= d_mid %>"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr" onclick="showhidegroupqt(<%= d_mid %>);"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task');?></a></div>
							<div style="display:none;" class="input-group" id="inlin_qtsk_c<%= d_mid %>">
							<label class="control-label" for="addon3a"><?php echo __('Quick Task');?></label>
							<input data-mid="<%= d_mid %>" id="addon<%= d_mid %>" class="in_qt_taskgroup form-control inline_qktask<%= d_mid %>" type="text" onblur="showhidegroupqt(<%= d_mid %>,1);">
							<span class="input-group-btn">
								<button data-mid="<%= d_mid %>" type="button" class="btn btn-fab btn-fab-mini in_qt_taskgroupbtn">
								<i class="material-icons qk_send_icon_tg<%= d_mid %>">send</i>
								</button>
							</span>
							</div>
						</div>
          <?php } ?>
					</div>
					</td>
				</tr>
				<% } %>
				<%
			}
		}else{
			if(getdata.Easycase.newActuldt && getdata.Easycase.newActuldt!=0) {%>
    <tr class="list-dt-row">
        <td colspan="10" align="left" class="curr_day"><div class="dt_cmn_mc <% if(count!=1 && !getdata.Easycase.pjname) {%>y_day<% } %>"><%= getdata.Easycase.newActuldt %></div></td>
    </tr>
                <%	}
            } %>
	
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
    <tr class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %> data-is-parent="<% if(rel_arr.length && rel_arr.indexOf(caseAutoId) != -1){ %>1<% } %>">
	<% }else {%>
     <tr style="position:relative" class="tr_all row_tr trans_row <% if(typeof mid != 'undefined'){ %>tgrp_tr_all<% } %>" id="curRow<%= caseAutoId %>" <% if(typeof mid != 'undefined'){ %>data-pid="<%= projId %>" data-mid="<%= mid %>" <% } %> data-is-parent="<% if(rel_arr.length && rel_arr.indexOf(caseAutoId) != -1){ %>1<% } %>">
	<% }%>	
	<% if(groupby=='milestone') { %>
	<td class="prtl">
  <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
	<div class="fl os_sprite dot-bar"></div>
  <?php } ?>
	<div class="wht-bg"></div>
	</td>
	<% } %>
	<td class="ctg_check_td pr" <% if(groupby =='' || groupby !='priority'){%>class="check_list_task tsk_fst_td pr_<%= easycase.getPriority(casePriority) %>"<% } %>>
		<div class="checkbox fl">
		  <label>
			<% if(caseLegend != 3 && caseTypeId != 10) { %>
			<input type="checkbox" style="cursor:pointer" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|' + caseUniqId %>" class="fl mglt chkOneTsk">
			<% } else if(caseTypeId != 10) { %>
			<input type="checkbox" id="actionChk<%= count %>" checked="checked" value="<%= caseAutoId + '|' + caseNo + '|closed' %>" disabled="disabled" class="fl mglt chkOneTsk">
			<% } else { %>
			<input type="checkbox" id="actionChk<%= count %>" value="<%= caseAutoId + '|' + caseNo + '|update' %>" class="fl mglt chkOneTsk">
			<% } %>
		  </label>
		  <input type="hidden" id="actionCls<%= count %>" value="<%= caseLegend %>" disabled="disabled" size="2"/>			
		</div>
		<div class="check-drop-icon fl" <% if(count == 1){ %>id="tour_task_title_listing_act"<% } %>>
			<div class="dropdown cmn_tooltip_hover"> 
				<a class="dropdown-toggle tooltip_link" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i>
				</a>
				<ul class="dropdown-menu hover_item">
          <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
					<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
					$.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
					if(getdata.Easycase.CustomStatus.id != data.id){
					%>
          <% if(data.status_master_id == 3){ %>
            <% if(isAllowed("Status change except Close",projectUniqid)){ %>
					<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
					<a href="javascript:void(0);">
					<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
					</a>
					</li>
          <% } %>
          <% }else{ %>
					<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
					<a href="javascript:void(0);">
					<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= data.name %>
					</a>
					</li>
          <% } %>
					<%   } 
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
                                    <% if(isAllowed("Status change except Close",projectUniqid)){ %>
                                    <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                                    </li>
                                    <% } %>	
					<% } %>
					<% } %>
          <?php } ?>
                                    <?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
                                      <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
									  <% if(caseLegend ==3 ) { %>
										<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
                                    <li onclick="setSessionStorage(<%= '\'Task Group Hierarchy Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                        </li>
                                      <?php } ?>
									  <% } else { %>
										  <li onclick="setSessionStorage(<%= '\'Task Group Hierarchy Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                        </li>
									 <% } %>
									  <?php } ?>
                                    
                                    <?php } ?>
                                    <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                    <?php } ?>
                                   <% if((caseFlag == 5 || caseFlag==2) && getdata.Easycase.isactive == 1) { %>
                                    <% } %>
                                    <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                    if(getdata.Easycase.isactive == 1){ %>
                                    <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group Hierarchy Page">
                                       <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                                        <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                      <?php } ?>
                                         <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
                                        <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>">
                                                <i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                              <?php } ?>
                                        </li>
                                    <% }
					if( SES_ID == caseUserId) { caseFlag=3; }
					if(getdata.Easycase.isactive == 1){ %> 
                            <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %>
                                   <% if((isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                                        <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)|| (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit ) ){ %>display:block <% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                        </li>
                                      <% } %>
                                      <% } %>
									  
									  
                                       <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononCopy){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                        </li>
                                      <?php } ?>
									  
									  
                                        <% }
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                        if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
						<% if(getdata.Easycase.isactive == 1){ %>
            <?php if($this->Format->isAllowed('Move to Project',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
								<a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
							</li>
            <?php } ?>
						<% } %>
						<% if(getdata.Easycase.isactive == 0){ %>
            <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="restoreFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
							</li>
            <?php } ?>
            <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="removeFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
							</li>
            <?php } ?>
						<% } %>
                                                <% }
                                                if(getdata.Easycase.isactive == 1 &&  getdata.Easycase.pjMethodologyid != 2){ %>
                                                <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
                                                <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                                </li>
                                              <?php } ?>
                                                <% } %>
                                                <% if(getdata.Easycase.milestone_id){ %>
                                                <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                                <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                                </li><?php } ?>
                                                <% } %>
                                                <!--<li class="divider"></li>-->
                                                <% if(getdata.Easycase.isactive == 1){
                                                                    if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id)) {
                                                                    caseFlag = "remove";%>
                                                                    <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                                <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                                </li>
                                              <?php } ?>
                                                <%
                                                }
                                                }
                                                if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
                                                if(getdata.Easycase.isactive == 1){ %>
                                                <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
                                                <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                                </li>
                                              <?php } ?>
                                                <% }
                                                if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
                                                if(getdata.Easycase.isactive == 1){ %>
                                                <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
                                                <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                                    <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                                </li>
                                              <?php } ?>
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
	<% if(groupby !='milestone') { %>
	<td class="pr"><%= caseNo %>
		<div class="check-drop-icon">
			<div class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
				  <i class="material-icons">&#xE5D4;</i><?php //&#xE5CF; ?>
				</a>
				<ul class="dropdown-menu">
        <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){
					$.each(customStatusByProject[getdata.Easycase.project_id], function (key, data) {
					if(getdata.Easycase.CustomStatus.id != data.id){
					%>
					<li onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,<%= '\'' + data.id + '\'' %>,<%= '\'' + data.status_master_id + '\'' %>,<%= '\'' +data.name  + '\'' %>);" id="new<%= caseAutoId %>">
					<a href="javascript:void(0);">
					<span style="background-color:#<%= data.color %>;height: 11px;width: 11px;display: inline-block;"></span>
					<%= data.name %></a>
					</li>
					<%   } 
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
                                        if(caseLegend != 5 && caseTypeId!= 10) { caseFlag=2; }
                                        if(getdata.Easycase.isactive == 1){ %>
                                        <li onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="resolve<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a>
                                        </li>
                                        <% }
                                        if(caseLegend != 3 && caseTypeId != 10) { caseFlag=5; }
                                        if(getdata.Easycase.isactive == 1){ %>
                                        <% if(isAllowed("Status change except Close",projectUniqid)){ %>
                                        <li onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);" id="close<%= caseAutoId %>" style=" <% if(caseFlag == 5) { %>display:block <% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a>
                                        </li>
                                        <% } %>
							<% } %>
							<% } %>
              <?php } ?>
			  <% if(isAllowed("Create Task",projectUniqid)){ %>
                                    <% 
									
									if((getdata.Easycase.is_sub_sub_task==null) || (getdata.Easycase.is_sub_sub_task=='')){
									if(caseLegend !=3 && caseTypeId != 10){ %>
                                    <li onclick="addSubtaskPopup(<%= '\'' + projectUniqid + '\'' %>,<%= '\'' + getdata.Easycase.id + '\'' %>,<%= '\'' + getdata.Easycase.project_id + '\'' %>,<%= '\'' + getdata.Easycase.uniq_id + '\'' %>,<%= '\'' + getdata.Easycase.title + '\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Create Sub task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);">
                                        <a href="javascript:void(0);"><i class="material-icons"></i><?php echo __('Create Subtask');?></a>
                                    </li>
                                    <% } }%>
                          <% } %>
						   <% if(caseParenId){ %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToParentTask(<%= '\''+ caseAutoId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Convert To Parent Task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Parent');?></a>
                                        </li>
                                      <?php } ?>
									 <% } %>
									  <% if(caseParenId == "" || caseParenId == null){ %>
									  <%	if((getdata.Easycase.sub_sub_task==null) || (getdata.Easycase.sub_sub_task =="") || (getdata.Easycase.sub_sub_task ==0)){  %>
										  <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="convertToSubTask(<%= '\''+ caseAutoId+'\',\''+projId+'\',\''+caseNo+'\'' %>);trackEventLeadTracker(<%= '\'Task List Page\'' %>,<%= '\'Convert To Sub task\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);" id="convertToSubTask<%= caseAutoId %>" style=" <% if(showQuickActiononList){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE15A;</i><?php echo __('Convert To Subtask');?></a>
                                        </li>
                                      <?php } ?>
									  
									  <% } } %>
					<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
            <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
			<% if(caseLegend ==3 ) { %>
										<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
                                        <li onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                        </li>
                                      <?php } ?>
									   <% } else { %>
											 <li onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                        </li>
									    <% }  %>
										<?php } ?>
                                        
                                                            <?php } ?>
                                        <?php if(SES_COMP == 4 && ($_SESSION['Auth']['User']['is_client'] == 0)) { ?>
                                        <?php } ?>
                                       <% if((caseFlag == 5 || caseFlag==2) && getdata.Easycase.isactive == 1) { %>
                                        <!--<li class="divider"></li>-->
                                        <% } %>
                                        <% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
                                                            if(getdata.Easycase.isactive == 1){ %>
                                        <li id="act_reply<%= count %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group Hierarchy Page">
                                          <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                                            <a href="javascript:void(0);" id="reopen<%= caseAutoId %>" style="<% if(caseFlag == 7){ %>display:block <% } else { %>display:none<% } %>"><div class="act_icon act_reply_task fl" title="Re-open"></div><i class="material-icons">&#xE898;</i> <?php echo __('Re-open');?></a>
                                          <?php } ?>
                                            <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
                                            <a href="javascript:void(0);" id="reply<%= caseAutoId %>" style="<% if(caseFlag == 8){ %>display:block <% } else { %>display:none<% } %>"><i class="material-icons">&#xE15E;</i><?php echo __('Reply');?></a>
                                          <?php } ?>
                                            </li>
                                        <% }
					if( SES_ID == caseUserId) { caseFlag=3; }
					if(getdata.Easycase.isactive == 1){ %> 
                            <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)){ %>
                            <% if(( isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit) || isAllowed('Edit All Task',projectUniqid)){ %>
                                     <li onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="edit<%= caseAutoId %>" style=" <% if(showQuickActiononList || isAllowed('Edit All Task',projectUniqid)|| (isAllowed('Edit Task',projectUniqid) && showQuickActiononListEdit )){ %>display:block <% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE254;</i><?php echo __('Edit');?></a>
                                        </li>
                                      <% } %>
                                      <% } %>
									  
									 
                                      <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="copytask(<%= '\''+ caseUniqId+'\',\''+ caseAutoId+'\',\''+caseNo+'\',\''+projId+'\',\''+htmlspecialchars(projectName)+'\'' %>);" id="copy<%= caseAutoId %>" style=" <% if(showQuickActiononCopy){ %>display:block <% } else { %>display:none<% } %>">
                                              <a href="javascript:void(0);"><i class="material-icons">&#xE14D;</i><?php echo __('Copy');?></a>
                                        </li>
                                      <?php } ?>
                                        <% }
					if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
                                        if((SES_TYPE == 1 || SES_TYPE == 2) || ((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) &&  (SES_ID == caseUserId))){ %>
						<% if(getdata.Easycase.isactive == 1){ %>
             <?php if($this->Format->isAllowed('Move to Project',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" " onclick="mvtoProject(<%= '\'' + count + '\'' %>,this);">
								<a href="javascript:void(0);"><i class="material-icons">&#xE8D4;</i><?php echo __('Move to Project');?></a>
							</li>
            <?php } ?>
						<% } %>
						<% if(getdata.Easycase.isactive == 0){ %>
             <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="restoreFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?></a>
							</li>
            <?php } ?>
             <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
							<li data-prjid="<%= projId %>" data-caseid="<%= caseAutoId %>" data-caseno="<%= caseNo %>"  id="mv_prj<%= caseAutoId %>" style=" ">
								<a onclick="removeFromTask(<%= caseAutoId %>,<%= projId %>,<%= caseNo %>)" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove');?></a>
							</li>
            <?php } ?>
						<% } %>
                                        <% }
					if(getdata.Easycase.isactive == 1 &&  getdata.Easycase.pjMethodologyid != 2){ %>
                                  <?php if($this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>
                                        <li onclick="moveTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:block <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE89F;</i><?php echo __('Move to Task Group');?></a>
                                        </li>
                                      <?php } ?>
                                        <% } %>
                                        <% if(getdata.Easycase.milestone_id){ %>
                                        <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                        <li onclick="removeTask(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'\'' %>,<%= '\'' + projId + '\'' %>);" id="moveTask<%= caseAutoId %>" style=" <% if(caseFlag == 2){ %> display:block <% } else { %> display:none <% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove from Task Group');?></a>
                                        </li>
                                      <?php } ?>
                                        <% } %>
                                        <!--<li class="divider"></li>-->
                                        <% if(getdata.Easycase.isactive == 1){
                                                            if(caseMenuFilters == "milestone" && (SES_TYPE == 1 || SES_TYPE == 2 || SES_ID == getdata.Easycase.Em_user_id) || isAllowed('Delete All Task',projectUniqid)) {
                                                            caseFlag = "remove";%>
                                                            <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
                                        <li onclick="removeThisCase(<%= '\'' + count + '\'' %>,<%= '\'' + getdata.Easycase.Emid + '\'' %>, <%= '\'' + caseAutoId + '\'' %>, <%= '\'' + getdata.Easycase.Em_milestone_id + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUserId + '\'' %>);" id="rmv<%= caseAutoId %>" style="<% if(caseFlag == "remove"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i><?php echo __('Remove Task');?></a>
                                        </li>
                                      <?php } ?>
                                        <%
					}
					}
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
					if(getdata.Easycase.isactive == 1){ %>
          <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
                                        <li onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "archive"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                        </li>
                                      <?php } ?>
                                        <% }
					if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
					if(getdata.Easycase.isactive == 1){ %>
          <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
                                        <li onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);" id="arch<%= caseAutoId %>" style="<% if(caseFlag == "delete"){ %>display:block<% } else { %>display:none<% } %>">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i><?php echo __('Delete');?></a>
                                        </li>
                                      <?php } ?>
                                        <% } %>
				</ul>
			</div>
		</div>
	</td>
	<% } %>
	
	
	<td class="relative list-cont-td" <% if(count == 1){ %>id="tour_task_title_listing"<% } %>>
		<a href="javascript:void(0);" class="ttl_listing" data-task-id="<%= caseUniqId %>">
	<span id="titlehtml<%= count %>" data-task="<%= caseUniqId %>" class="case-title case_sub_task <% if(getdata.Easycase.type_id!=10 && getdata.Easycase.legend==3) { %>closed_tsk<% } %> case_title_<%= caseAutoId %>">
		<span class="max_width_tsk_title ellipsis-view <% if(caseLegend == 5){%>resolve_tsk<% } %> case_title wrapword task_title_ipad <% if(caseTitle.length>40){%>overme<% }%> " title="<%= formatText(ucfirst(caseTitle)) %>  ">
					#<%=getdata.Easycase.case_no%>: <%= formatText(ucfirst(caseTitle)) %>
		</span>
	</span>
</a>
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
		<div class="task_dependancy parenttt fr">
			<% if(getdata.Easycase.parent_task_id && getdata.Easycase.parent_task_id != ""){ %>
				<span class="fl case_act_icons task_parent_block" id="task_parent_id_block_<%= caseUniqId %>">
					<div rel="" title="<?php echo __('Subtask');?>" onclick="showSubtaskParents(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\'' + getdata.Easycase.parent_task_id + '\'' %>);" class="fl parent_sub_icons"><i class="material-icons">&#xE23E;</i></div>
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
		<div class="list-td-hover-cont">	
		<span class="created-txt"><% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('Updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %></span>
		<span class="list-devlop-txt dropdown">
      <a class="dropdown-toggle" <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> data-toggle="dropdown" href="javascript:void(0);" <?php } ?>  data-target="#">
				<i class="material-icons tag_fl">&#xE54E;</i>
				<span id="showUpdStatus<%= caseAutoId %>" class="<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>clsptr<% } %>" title="<%= getdata.Easycase.csTdTyp[1] %>" >
					<span class="tsktype_colr" id="tsktype<%= caseAutoId %>"><%= getdata.Easycase.csTdTyp[1]%>
          <span class="due_dt_icn"></span>
				</span>
        </span>
			</a>				
			<span id="typlod<%= caseAutoId %>" class="type_loader">
				<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
			</span>				
                    <% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>
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
				  <li onclick="changeCaseType(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>); changestatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + t + '\'' %>, <%= '\'' + t1 + '\'' %>, <%= '\'' + t2 + '\'' %>, <%= '\'' + caseUniqId + '\'' %>)">
						<a href="javascript:void(0);">
						<span class="ttype_global tt_<%= getttformats(t2)%>">
                                                <%= t2 %></span>
                                                </a>
				  </li>
				<% }
        } %>
				</ul>					
				<% } %>
		</span>		
		
		<span class="check-drop-icon dsp-block">
			<span class="dropdown">
        <a class="dropdown-toggle" <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>data-toggle="dropdown" href="javascript:void(0);"<?php } ?>  data-target="#">
				  <i class="material-icons">&#xE5C5;</i>
				</a>
				<% if(showQuickActiononList && getdata.Easycase.isactive == 1){ %>
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
				  <li onclick="changeCaseType(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>); changestatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + t + '\'' %>, <%= '\'' + t1 + '\'' %>, <%= '\'' + t2 + '\'' %>, <%= '\'' + caseUniqId + '\'' %>)">
						<a href="javascript:void(0);">
                                                    <span class="ttype_global tt_<%= getttformats(t2)%>">
                                                        <%= t2 %></span>
						</a>
				  </li>
				<% }
        } %>
				</ul>					
				<% } %>
			</span>
		</span>
                <% if(getdata.Easycase.is_recurring == 1 || getdata.Easycase.is_recurring == 2){ %>
            <a rel="tooltip" title="<?php echo __('Recurring Task');?>" href="javascript:void(0);" class="recurring-icon" onclick="showRecurringInfo(<%= caseAutoId %>);"  ><i class="material-icons">&#xE040;</i></a>
        <% } %>
		<span class="small-list-devlop-icon">
			<% var caseFlag=""; 					
				if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4) && caseTypeId!= 10) { caseFlag=2; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == 2){ %>
				<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){ }else{ %>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
        <a rel="tooltip" title="<?php echo __('Resolve');?>" href="javascript:void(0)" onclick="caseResolve(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);">
					<i class="material-icons">&#xE889;</i>
				</a>
        <?php } ?>
				<% } } }
				if((caseLegend == 1 || caseLegend == 2 || caseLegend == 4 || caseLegend == 5) && caseTypeId != 10) { caseFlag=5; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == 5) {	%>
					<% if(typeof customStatusByProject !="undefined" && typeof customStatusByProject[getdata.Easycase.project_id] !='undefined' && customStatusByProject[getdata.Easycase.project_id] != null){ %>
						<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
            <% if(isAllowed("Status change except Close",projectUniqid)){ %>
            <a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCustomStatus(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>,0,<%= '\'3\'' %>,<%= '\'close\'' %>);">
							<i class="material-icons">&#xE876;</i>
						</a>
					<% } %>
            <?php } ?>
					<% }else{ %>
          <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
            <?php if($this->Format->isAllowed("Status change except Close",$roleAccess)){ ?>
					<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Mark as Completed');?>" onclick="setCloseCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + caseUniqId + '\'' %>);">
						<i class="material-icons">&#xE876;</i>
					</a>
          <?php } ?>
          <?php } ?>
					<% } } } %>					
				<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
          <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
				<% if(caseLegend ==3 ) { %>
					<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
				<span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"></span>
				<?php } ?>
				<% } else{ %>
					<span rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);" class="case_act_icons task_title_icons_timelog fl"></span>
				<% } %>
				
				<?php } ?>
        <?php } ?>
				<% if(caseLegend == 3) { caseFlag= 7; } else { caseFlag= 8; }
				if(getdata.Easycase.isactive == 1){ %>        
            <?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
                                <a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 7){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group Hierarchy Page" rel="tooltip" title="<?php echo __('Re-open');?>"><i class="material-icons">&#xE898;</i></a>
                              <?php } ?>
                              <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
				<a href="javascript:void(0);" id="act_reply_spn<%= count %>" style="<% if(caseFlag == 8){ %>display:inline-block <% } else { %>display:none<% } %>" data-task="<%= caseUniqId %>" page-refer-val="Task Group Hierarchy Page" rel="tooltip" title="<?php echo __('Reply');?>"><i class="material-icons">&#xE15E;</i></a>
      <?php } ?>
				<% }
				if( SES_ID == caseUserId) { caseFlag=3; }
				if(getdata.Easycase.isactive == 1){ 
				if(showQuickActiononList || isAllowed("Edit All Task",projectUniqid)){ %>
        <% if( (isAllowed("Edit Task",projectUniqid) && showQuickActiononListEdit) || isAllowed("Edit All Task",projectUniqid)){ %>
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Edit');?>" onclick="editask(<%= '\''+ caseUniqId+'\',\''+projectUniqid+'\',\''+htmlspecialchars(projectName)+'\'' %>);">
					<i class="material-icons">&#xE254;</i>
				</a>
      <% } %>
				<% } } %>	
				<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
           <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
				<% if(getdata.Easycase.legend == 3){ %>
				<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
					<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group Hierarchy Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
					<i class="material-icons">&#xE8B5;</i>
					<?php } ?>
				</a>
				<% } else { %>
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Group Hierarchy Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= '\'' + caseAutoId + '\'' %>,<%= '\'' + escape(htmlspecialchars(caseTitle,3)) + '\'' %>);">
					<i class="material-icons">&#xE8B5;</i>
				</a>
				<% } %>
				
				<?php } ?>
        <?php } ?>
				<%
				if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Archive All Task',projectUniqid)) { caseFlag = "archive"; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == "archive"){ %>
          <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Archive');?>" onclick="archiveCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>);">
					<i class="material-icons">&#xE149;</i>
				</a>
      <?php } ?>
				<% } }
				if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_ID == caseUserId) || isAllowed('Delete All Task',projectUniqid)) { caseFlag = "delete"; }
				if(getdata.Easycase.isactive == 1){ 
				if(caseFlag == "delete"){ %>
        <?php if($this->Format->isAllowed('Delete Task',$roleAccess) || $this->Format->isAllowed('Delete All Task',$roleAccess)){ ?>
				<a href="javascript:void(0)" rel="tooltip" title="<?php echo __('Delete');?>" onclick="deleteCase(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>, <%= '\'' + projId + '\'' %>, <%= '\'t_' + caseUniqId + '\'' %>, <%= '\'' + getdata.Easycase.is_recurring + '\'' %>);">
					<i class="material-icons">&#xE872;</i>
				</a>
      <?php } ?>
				<% } } %>
		</span>
	</div>
</td>
<td class="attach-file-comment" <% if(getTotRep && getTotRep!=0) { %>data-task="<%= caseUniqId %>" id="kanbancasecount<%= count %>" style="cursor:pointer;"<% } %>>
	<a href="javascript:void(0);" <% if(getdata.Easycase.format != 1 && getdata.Easycase.format != 3) { %> style="display:none;" id="fileattch<%= count %>"<% } %>>
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
<td class="assi_tlist width_assign">
	<i class="material-icons">&#xE7FD;</i>			
	<% if((projUniq != 'all') && showQuickActiononList){ %>
  <span id="showUpdAssign<%= caseAutoId %>" <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> data-toggle="dropdown" <?php } ?>title="<%= getdata.Easycase.asgnName %>"  <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> class="clsptr" onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)" <?php } ?> ><%= getdata.Easycase.asgnShortName %><span class="due_dt_icn"></span></span>
	<% } else { %>
	<span id="showUpdAssign<%= caseAutoId %>" style="cursor:text;text-decoration:none;color:#a7a7a7;"><%= getdata.Easycase.asgnShortName %></span>
	<% } %>
	<% if((projUniq != 'all') && showQuickActiononList){ %>
  <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
	<span id="asgnlod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
<?php } ?>
	<% } %>			
	<span class="check-drop-icon dsp-block" <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> <% if((projUniq != 'all') && showQuickActiononList){ %> onclick="displayAssignToMem(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + projUniq + '\'' %>,<%= '\'' + caseAssgnUid + '\'' %>,<%= '\'' + caseUniqId + '\'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\'' + getdata.Easycase.client_status + '\'' %>)" <% } %> <?php } ?>>
		<span class="dropdown">
			<a class="dropdown-toggle" <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?> data-toggle="<% if((projUniq != 'all') && showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);" <?php }?> data-target="#">
			  <i class="material-icons">&#xE5C5;</i>
			</a>
			<ul class="dropdown-menu asgn_dropdown-caret scroll-listing" id="showAsgnToMem<%= caseAutoId %>" >
			  <li class="text-centre"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" id="assgnload<%= caseAutoId %>" /></li>
			</ul>
		</span>
	</span>
</td>
<% } %>
<% } %>
<% if(inArray('Priority',field_name_arr)){ %>
<td class="text-center <% if(getdata.Easycase.csTdTyp[1] != 'Update'){ %>task_priority csm-pad-prior-td<% }else{ %>csm-pad12-prior-td<% } %>">
    <% var csLgndRep = getdata.Easycase.legend; %>
    <% if(getdata.Easycase.csTdTyp[1] == 'Update'){ %>
        <span class="prio_high prio_lmh prio_gen" rel="tooltip" title="<?php echo __('Priority');?>:<?php echo __('high');?>"></span>
    <% }else{ %>
    <div style="" id="pridiv<%= caseAutoId %>" data-priority ="<%= casePriority %>" <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> class="pri_actions <% if(showQuickActiononList){ %> dropdown<% } %>" <?php } ?> >    
        <div class="dropdown cmn_h_det_arrow lmh-width">
        <div <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?> <% if(showQuickActiononList){ %> class="quick_action" data-toggle="dropdown" style="cursor:pointer" <% } %> <?php } ?> ><span class=" prio_<%= easycase.getPriority(casePriority) %> prio_lmh prio_gen prio-drop-icon" rel="tooltip" title="<?php echo __('Priority');?>:<%= easycase.getPriority(casePriority) %>"></span><i class="tsk-dtail-drop material-icons">&#xE5C5;</i></div>
        <% if(showQuickActiononList){ %>
        <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
            <ul class="dropdown-menu quick_menu">
                <li class="low_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'2\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('Low');?></a></li>
                <li class="medium_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'1\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('Medium');?></a></li>
                <li class="high_priority"><a href="javascript:void(0);" onclick="detChangepriority(<%= '\''+caseAutoId+'\', \'0\', \''+caseUniqId+'\', \''+caseNo+'\'' %>)"><span class="priority-symbol"></span><?php echo __('High');?></a></li>
            </ul>
          <?php } ?>
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
	<td class="esthrs_dt_tlist"  style="text-align:center">
		<p class=" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> estblist <?php } ?> ttc" id="est_blist<%=caseAutoId%>" <?php if($this->Format->isAllowed('Est Hours',$roleAccess)){ ?> style="cursor:pointer;" <?php } ?> case-id-val="<%=caseAutoId%>" >
			<span class="border_dashed">
				<% if(caseEstHours) { %> <%= caseEstHours %> <% } else { %><?php echo __('None');?><% } %>
			</span>
		</p>
		
		<% var est_time = Math.floor(caseEstHoursRAW/3600)+':'+(Math.round(Math.floor(caseEstHoursRAW%3600)/60)<10?"0":"")+Math.round(Math.floor(caseEstHoursRAW%3600)/60); %>
		
		<input type="text" data-est-id="<%=caseAutoId%>" data-est-no="<%=caseNo%>" data-est-uniq="<%=caseUniqId%>" data-est-time="<%=est_time%>" id="est_hrlist<%=caseAutoId%>" class="est_hrlist form-control check_minute_range" style="margin-bottom: 2px;display:none;" maxlength="5" rel="tooltip" title="<?php echo __('You can add time as 1.5(that mean 1 hour and 30 minutes) and press enter to save');?>" onkeypress="return numeric_decimal_colon(event)" value="<%= est_time %>" placeholder="hh:mm" data-default-val="<%=est_time%>"/>
		
		<span id="estlod<%=caseAutoId%>" style="display:none;margin-left:0px;">
			<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
		</span>
	</td>
<% } %>

<% if(inArray('Updated',field_name_arr)){ %>
<td class="text-center tskg-updt-time" title="<% if(getTotRepCnt && getTotRepCnt!=0) { %><?php echo __('updated');?><% } else { %><?php echo __('created');?><% } %> <?php echo __('by');?> <%= getdata.Easycase.usrShortName %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %> <%= getdata.Easycase.updtedCapDt %> <%= getdata.Easycase.fbstyle %>."><%= getdata.Easycase.fbstyle %></td>
<% } %>
<% if(inArray('Status',field_name_arr)){ %>
<td>
<div class="cs_select_dropdown">
<span id="csStsRep<%= count %>" class="cs_select_status">
<% if(isactive==0){ %>
	<div class="label new" style="background-color: olive"><?php echo __('Archived');?></div>
<%}else if(groupby =='' || groupby !='status'){
  if(getdata.Easycase.custom_status_id != 0 && getdata.Easycase.CustomStatus != null ){ %>
	<%= easycase.getCustomStatus(getdata.Easycase.CustomStatus, getdata.Easycase.custom_status_id) %>
<% }else{ %>
  <%= easycase.getStatus(getdata.Easycase.type_id, getdata.Easycase.legend) %>
 <% }
    } %>
</span>
<span class="check-drop-icon dsp-block">
	<span class="dropdown cmn_h_det_arrow">
		 <a class="dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0);" data-target="#">
			  <i class="material-icons">&#xE5C5;</i>
			</a>
	</span>
</span>
</div>
</td>
<% } %>
<% if(inArray('Due Date',field_name_arr)){ %>
<td class="due_dt_tlist">
<div class="<% if(getdata.Easycase.csDueDate == '' || getdata.Easycase.legend == 5 || getdata.Easycase.type_id == 10 || getdata.Easycase.legend == 3){ %> toggle_due_dt <% } %>">
	<% if(getdata.Easycase.isactive == 1){ %>
	<% if(showQuickActiononList && caseTypeId != 10){ %>
	<?php /*
	<span class="glyphicon glyphicon-calendar" <% if(showQuickActiononList){ %>title="<?php echo __('Edit Due Date');?>"<% } %>></span>
	*/ ?>
	<% } %>
	<span class="show_dt" id="showUpdDueDate<%= caseAutoId %>" title="<%= getdata.Easycase.csDuDtFmtT %>">
		<%= getdata.Easycase.csDuDtFmt %>
	</span>
	<span id="datelod<%= caseAutoId %>" class="asgn_loader">
		<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
	</span>
	<% } %>
	<span class="check-drop-icon dsp-block">
		<span class="dropdown">
      <a class="dropdown-toggle" <?php if($this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?> data-toggle="<% if(showQuickActiononList){ %>dropdown<% } %>" href="javascript:void(0);"<?php } ?>  data-target="#">
			  <i class="material-icons">&#xE5C5;</i>
			</a>
			<ul class="dropdown-menu">
				<li class="pop_arrow_new"></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\'' %>, <%= '\'' + caseNo + '\'' %>);changeDueDate(<%= '\'' + caseAutoId + '\', \'00/00/0000\', \'No Due Date\', \'' + caseUniqId + '\'' %>)"><?php echo __('No Due Date');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyCurCrtd + '\', \'Today\', \'' + caseUniqId + '\'' %>)"><?php echo __('Today');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyTomorrow + '\', \'Tomorrow\', \'' + caseUniqId + '\'' %>)"><?php echo __('Tomorrow');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyMonday + '\', \'Next Monday\', \'' + caseUniqId + '\'' %>)"><?php echo __('Next Monday');?></a></li>
				<li><a href="javascript:void(0);" onclick="changeCaseDuedate(<%= '\'' + caseAutoId + '\', \'' + caseNo + '\'' %>); changeDueDate(<%= '\'' + caseAutoId + '\', \'' + mdyFriday + '\', \'This Friday\', \'' + caseUniqId + '\'' %>)"><?php echo __('This Friday');?></a></li>
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
	<div class="overdueby_spn overdueby_spn_<%= caseAutoId %>"><% if(showQuickActiononList){ %><%= getdata.Easycase.csDuDtFmtBy %><% } %></div>
</div>
</td>
<% } %>
 <% if(inArray('Progress',field_name_arr)){ %>
    <td class="progress_tlist text-center"><%= getdata.Easycase.completed_task %>%</td>
  <% } %>  
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
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'')); ?>
			<% } %>
            <% } %>
            <% }else if(case_type == 'assigntome'){
				if(filterenabled){ %>
					<?php echo __('No tasks for me');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'assigntome')); ?>
            <% } %>
            <% }else if(case_type == 'overdue'){
				if(filterenabled){ %>
					<?php echo __('No tasks as overdue');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'overdue')); ?>
            <% } %>
            <% }else if(case_type == 'delegateto'){
				if(filterenabled){ %>
					<?php echo __('No tasks delegated');?>
            <% }else{ %>
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'delegateto')); ?>
            <% } %>
            <% }else if(case_type == 'highpriority'){
                if(filterenabled){ %>
                        <?php echo __('No high priority tasks');?>
            <% }else{ %>
			
            <?php echo $this->element('no_data', array('nodata_name' => 'tasklist','case_type'=>'highpriority')); ?>
            <% } %>
            <% }else if(case_type == 'favourite'){
                if(filterenabled){ %>
                        <?php echo __('No favourite tasks');?>
            <% }else{ %>
                <?php echo __('No favourite tasks');?>
            <% } %>
            <% } %>
        </td>
    </tr>
    <% } %>
    </tbody>
    </table>
	</div>
    <% $("#task_paginate").html('');
    if(caseCount && caseCount!=0) {
            var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
            $("#task_paginate").html(tmpl("paginate_tmpl", pageVars));
    }
    $(document).ready(function(){   
    setTimeout(function(){
        for (var k in countMile){       
            $("#miviewspan_"+k).html(countMile[k]);
        }
        },1000);
    });
    %>
		<div class="crt_task_btn_btm <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT && $_SESSION['KEEP_HOVER_EFFECT'] && (($_SESSION['KEEP_HOVER_EFFECT'] & 8) == 8)){ ?>keep_hover_efct<?php } ?> num_2">
			<span  class="hide_tlp_cross" title="<?php echo __('Close');?>" onclick="resetHoverEffect(<%= '\'task\'' %>, this);">&times;</span>
			<div class="pr">
        <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
				<div class="os_plus ctg_btn">
					<div class="ctask_ttip">
						<span class="label label-default"><?php echo __('Create Task Group');?></span>
					</div>
					<a href="javascript:void(0)" onclick="setSessionStorage(<%= '\'Task Group Page Big Plus\'' %>, <%= '\'Create Task Group\'' %>);addEditMilestone(<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>,<%= '\' \'' %>);">
						<i class="material-icons">&#xE065;</i>
					</a>
				</div>
      <?php } ?>
			</div>
      <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
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