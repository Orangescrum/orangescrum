<style>
    .task_listing table.table td.attach-file-comment:hover,.attach-file-comment:hover a .material-icons{color:#2d6dc4}
    </style>
<?php if (defined("RELEASE_V") && RELEASE_V) { ?>
    <div class="task_listing task-grouping-page">
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
                                      <?php /* ?>View:<span class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#"><span>Task Group <i class="material-icons">&#xE313;</i></span></a>
                                            <ul class="dropdown-menu new_icon_on_list_top">
				<li>
					<a class="" href="<?php echo HTTP_ROOT; ?>dashboard#calendar" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'Calendar View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);return calendarView(<%= '\'calendar\'' %>);">
                                                            <span title="Calendar" rel="tooltip"><i class="material-icons">&#xE916;</i>Calendar</span>
					</a>
				</li>
				<?php
				$kanbanurl = "";
				$kanbanurl = DEFAULT_KANBANVIEW == "kanban" ? "kanban" : "milestonelist";
				?>
				<li>
							<a class="" href="<?php echo HTTP_ROOT; ?>dashboard#<?php echo $kanbanurl; ?>" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'kanban View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);return checkHashLoad(<%= '\'<?php echo $kanbanurl; ?>\'' %>);">
						<span id="kbview_btn" class="" title="Kanban" rel="tooltip">
								<i class="material-icons">&#xE8F0;</i>Kanban
						</span>
					</a>
				</li>
                                                <% if(GrpBy != 'milestone'){ %>
						<li><a class="" href="javascript:void(0);" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'Task Group View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);groupby(<%= '\'milestone\'' %>, event,1);">
								<span title="Task Group" rel="tooltip"><i class="material-icons">&#xE065;</i>Task Group</span>
							</a>
						</li>
						<% } %>
						<% if(GrpBy == 'milestone'){ %>
						<li>
							<a class="" href="<?php echo HTTP_ROOT; ?>dashboard#tasks" onclick="trackEventLeadTracker(<%= '\'Top Right Change View\'' %>,<%= '\'List View\'' %>,<%= '\'<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>\'' %>);checkHashLoad(<%= '\'tasks\'' %>);">
								<span title="List" rel="tooltip"><i class="material-icons">&#xE896;</i>List</span>
							</a>
						</li>
						<% } %>
                                            </ul>
                                       </span><?php */ ?>
					<span class="reload_icon">
					<a class="" href="javascript:void(0);" onclick="reloadTasks();">
						<span title="<?php echo __('Reload');?>" rel="tooltip"><i class="material-icons">&#xE5D5;</i></span>
					</a>
			</span>
					 <div class="cb"></div>		
					</div> 
             <span id="ajaxCaseStatus" style="float:right;margin-top:7px; margin-right:-10px;"></span>
            <span class="view-type" style="float:left;left:8px;top:24px;">
                <a href="javascript:void(0);" title="<?php echo __('Expand All');?>" rel="tooltip" onclick="clearPaging();groupby(<%= '\'milestone\'' %>, event,1);dashboadrview_ga(<%= '\'Task Group\'' %>);"><?php echo __('Expand All');?></a>
                <!--<a href="javascript:void(0);" title="List View" rel="tooltip"  class="current"><i class="material-icons">format_line_spacing</i></a>-->
            </span>
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
            <div class="cb"></div>					
        </div>
        <div class="task-m-overflow cstm_responsive_tbl">
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
                                   <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
                                  <li>
                                      <a href="javascript:void(0);" onclick="multipleCaseAction(<%= '\'caseId\'' %>)"><i class="material-icons">&#xE5CD;</i><?php echo __('Close');?></a>
                                  </li>  
                                  <?php } ?>
								  <% } %>
                                  <?php } ?>                              
                                <?php if (SES_TYPE == 1 || SES_TYPE == 2 || $this->Format->isAllowed('Archive All Task',$roleAccess)) { ?>
                                   <?php if($this->Format->isAllowed('Archive Task',$roleAccess) || $this->Format->isAllowed('Archive All Task',$roleAccess)){ ?>
                                    <li>
                                        <a href="javascript:void(0);" onclick="archiveCase( <%= '\'all\'' %> )"><i class="material-icons">&#xE149;</i><?php echo __('Archive');?></a>
                                    </li>
                                  <?php } ?>
                                  <?php if($this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>
									<li>
										<a href="javascript:void(0);" onclick="ajaxassignAllTaskToUser(<%= '\'movetop\'' %>);"><i class="material-icons">&#xE7FD;</i><?php echo __('Assign task(s) to user');?></a>
									</li>
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
                                   <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
                                    <li id="crtProjTmpl">							
                                        <a href="javascript:void(0);" onclick="createPojectTemplate( <%= '\' \'' %> , <%= '\' \'' %> , <%= '\'movetop\'' %> )"><i class="material-icons">&#xE8F1;</i><?php echo __('Create Project Plan');?></a>
                                    </li>
                                  <?php } ?>

                                <?php } ?>
                            </ul>
                        </span>
                    </div>
                </div>
                </th>
                <th class="wth_2">
                    <a href="javascript:void(0);" title="<?php echo __('Task');?>#"  class="sortcaseno" onclick=" ajaxSorting( <%= '\'caseno\', ' + caseCount + ', this' %> );" >
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
                    <span id="shortingByTitle" class="dropdown" style="display: inline;">
                    <a class="sorttitle" href="javascript:void(0);" title="<?php echo __('Title');?>" data-toggle="dropdown" aria-expanded="true">
                        <?php echo __('Title');?>
                         <span class="sorting_arw"><% if((typeof csTtl != 'undefined' && csTtl != "") || (typeof getCookie('TASKSORTBY2')!='undefined')) { %>
                            <% if(csTtl2 == 'asc' || csTtl == 'asc'){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                    </a>
                         <ul class="dropdown-menu dropdown_menu_all_title" id="dropdown_menu_all_title">
                                <li class="log drop_menu_mc">
                                    <a href="javascript:void(0);" data-toggle="dropdown" onclick="ajaxSorting_v2( <%= '\'title\', ' + caseCount + ', this' %> );"><?php echo __('Sort By Task Group Title');?>
                                    <span class="sorting_arw"><% if(typeof getCookie('TASKSORTBY2')!='undefined') { %>
                            <% if(csTtl2 == 'asc'){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                                    </a>
                                </li>
                                <li class="log drop_menu_mc">
                                    <a href="javascript:void(0);" data-toggle="dropdown" onclick="ajaxSorting( <%= '\'title\', ' + caseCount + ', this' %> );"><?php echo __('Sort By Task Title');?>
                                      <span class="sorting_arw"><% if(typeof csTtl != 'undefined' && csTtl != "") { %>
                                        <% if(csTtl == 'asc'){ %>
                                        <i class="material-icons tsk_asc">&#xE5CE;</i>
                                        <% }else{ %>
                                        <i class="material-icons tsk_desc">&#xE5CF;</i>
                                        <% } %>								
                                        <% }else{ %>
                                        <i class="material-icons">&#xE164;</i>
                                        <% } %></span>
                                    </a>
                                </li>
                         </ul>
                    </span>
                </th>
                <th class="wth_5"></th>
                <% if(inArray('Assigned to',field_name_arr)){ %>
                <th class="width_assign wth_6">                  
                    <a class="sortcaseAt" href="javascript:void(0);" title="<?php echo __('Assigned to');?>" onclick="ajaxSorting( <%= '\'caseAt\', ' + caseCount + ', this' %> );">
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
                </th>
                <% } %>
                <% if(inArray('Priority',field_name_arr)){ %>
                <th class="width_priority text-center wth_7">
                    <a class="sortprioroty" href="javascript:void(0);" title="<?php echo __('Priority');?>" onclick="ajaxSorting( <%= '\'priority\', ' + caseCount + ', this' %> );">
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
                <% } %>
				<% if(inArray('Estimated Hours',field_name_arr)){ %>
                <th class="tsk_est_hours wth_10 text-center">
                    <a class="sortestimatedhours" href="javascript:void(0);" title="<?php echo __('Est. Hours');?>" onclick="ajaxSorting( <%= '\'estimatedhours\', ' + caseCount + ', this' %> );">
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
                    <a class="sortupdated" href="javascript:void(0);" title="<?php echo __('Updated');?>" onclick="ajaxSorting( <%= '\'updated\', ' + caseCount + ', this' %> );">
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
                <th class="width_status text-center wth_9"><?php echo __('Status');?></th>
                <% } %>
                <% if(inArray('Due Date',field_name_arr)){ %>
                <th class="tsk_due_dt wth_10">
                    <a class="sortduedate" href="javascript:void(0);" title="<?php echo __('Due Date');?>" onclick="ajaxSorting( <%= '\'duedate\', ' + caseCount + ', this' %> );">
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
                 <?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
                <tbody class="no_shortable"> 
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
                                    <input class="form-control" type="text" id="inline_milestone" maxlength="240" >
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-fab-mini" onclick="setSessionStorage(<%= '\'Quick Task Group Page\'' %>, <%= '\'Create Task Group\'' %>);AddNewMilestone();" trackEventWithIntercom(<%= '\'Task Group\'' %>,<%= '\'\'' %>);" title="<?php echo __('Post Task');?>">
                                                <i class="material-icons qk_send_icon_mi">send</i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="6"></td>
                    </tr>
                </tbody>               
                <?php } ?>        
                <% var mki = 0;
                
                if(all_milesto_names.length >0){
                for(var mkey in all_milesto_names){ mki++;
                if(typeof(all_milesto_names[mkey]['Easycase']['count_tasks']) === 'undefined'){
                    var  _count_tasks=0;
                    var _default_count_tasks=0;
                 }else{
                    var _count_tasks=all_milesto_names[mkey]['Easycase']['count_tasks'];
                    var _default_count_tasks=all_milesto_names[mkey]['Easycase']['default_count_tasks'];
                    
                 } 
                 
                 if(_count_tasks > 0 || all_milesto_names[mkey]['Milestone']['id'] > 0){
                %> 
                <tbody>                   
                    <tr class="tgrp_tr_all task_group_accd task_group_bg_clr" id="empty_milestone_tr<%= all_milesto_names[mkey]['Milestone']['id'] %>" data-pid="<%= all_milesto_names[mkey]['Milestone']['project_id'] %>">
                        <td colspan="12" class="pr">
                           <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
                            <div class="fl os_sprite dot-bar-group"></div>
                          <?php } ?>
                            <div class="plus-minus-accordian">
                                <div class="fl"><span class="os_sprite minus-plus os_sprite<%= all_milesto_names[mkey]['Milestone']['id'] %>" onclick="collapse_taskgroup(this); showTaskByMilestone( <%= all_milesto_names[mkey]['Milestone']['id'] %> , <%= all_milesto_names[mkey]['Milestone']['project_id'] %> , this);"></span></div>

                                <div class="fl">
                                    <span class="dropdown n_tsk_grp" id="n_tsk_grp_<%= all_milesto_names[mkey]['Milestone']['id'] %>">
                                        <a class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
                                            <i class="material-icons">&#xE5D4;</i>
                                        </a>
                                        <ul class="dropdown-menu sett_dropdown-caret aede-drop-text">			  
                                            <li class="pop_arrow_new" style="left:126px"></li>
                                            <% if(all_milesto_names[mkey]['Milestone']['id'] > 0){ %>
                                            <% if(all_milesto_names[mkey]['Milestone']['isactive'] != 0){ %>
                                            <?php if($this->Format->isAllowed('Add Tasks to MIlestone',$roleAccess)){ ?> 
                                            <li onClick="addTaskToMilestone( <%= '\'\',\'' + all_milesto_names[mkey]['Milestone']['id'] + '\'' %> , <%= '\'' + all_milesto_names[mkey]['Milestone']["project_id"] + '\'' %>,0,1)">
                                                <a href="javascript:void(0);" class="mnsm">
                                                    <i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                             <%                                            
                                             if(_count_tasks<= 0 && _default_count_tasks <=0){ %>
                                              <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?> 
                                            <li onClick="convertToTask(this, <%= '\'' + all_milesto_names[mkey]['Milestone']['id'] + '\'' %> , <%= '\'' + all_milesto_names[mkey]['Milestone']["project_id"] + '\'' %>,0,1)" id="convrt_task_<%= all_milesto_names[mkey]['Milestone']['id'] %>">
                                                <a href="javascript:void(0);" class="mnsm">
                                                    <i class="material-icons">&#xE15A;</i><?php echo __('Convert to Task');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <% } %>
                                             <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?> 
                                            <li class="makeHover" onclick="addEditMilestone(0, <%= '\'' + all_milesto_names[mkey]['Milestone']["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]['Milestone']["id"] %>,<%= '\'' + escape(all_milesto_names[mkey]['Milestone']["title"]) + '\'' %>,1,<%= '\'taskgroup\'' %>,<%= '\'' + all_milesto_names[mkey]['Milestone']["project_id"] + '\'' %>)">
                                                <a href="javascript:void(0)" class="mnsm">
                                                    <i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <% } %>
                                             <?php if($this->Format->isAllowed('Delete Milestone',$roleAccess)){ ?> 
                                            <li class="makeHover" onclick="delMilestone(0, <%= '\'' + escape(all_milesto_names[mkey]['Milestone']["title"]) + '\'' %>, <%= '\'' + all_milesto_names[mkey]['Milestone']["uniq_id"] + '\'' %>,<%= all_milesto_names[mkey]['Milestone']["id"] %>);">
                                                <a href="javascript:void(0);" class="mnsm">
                                                    <i class="material-icons">&#xE872;</i><?php echo __('Delete');?> 
                                                </a>                                          
                                            </li>
                                          <?php } ?>
                                           <% if(all_milesto_names[mkey]['Milestone']['isactive'] != 0){ %>
                                           <?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>  
                                            <li onclick="milestoneArchive( <%= '\'\',\'' + all_milesto_names[mkey]['Milestone']["uniq_id"] + '\'' %>, <%= '\'' + escape(all_milesto_names[mkey]['Milestone']["title"]) + '\'' %>,1);">
                                                <a href="javascript:jsVoid();" class="mnsm">
                                                    <i class="material-icons">&#xE86C;</i><?php echo __('Complete');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <% }else{ %>
                                            <?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>
                                            <li onclick="milestoneRestore( <%= '\'\',\'' + all_milesto_names[mkey]['Milestone']["uniq_id"] + '\'' %>, <%= '\'' + escape(all_milesto_names[mkey]['Milestone']["title"]) + '\'' %>,1);">
                                                <a href="javascript:jsVoid();" class="mnsm">
                                                    <i class="material-icons">&#xE8B3;</i><?php echo __('Restore');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <% }
                                            }else{ %>
                                            <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
                                             <li class="makeHover" onclick="addEditMilestone(0,<%= '\'default\'' %>,<%= '\'default\'' %>,<%= '\'Default Task Group\'' %>,1,<%= '\'taskgroup\'' %>)">
                                                <a href="javascript:void(0)" class="mnsm">
                                                    <i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
                                                </a>
                                            </li>
                                          <?php } ?>
                                            <% } %>

                                        </ul>
                                    </span>
                                </div>
                                <div class="fl accord_cnt_txt">
                                    <div class="empty_milstone_holder top_ms">
                                        <div class="__a fs-hide" onclick="collapse_by_title(<%= all_milesto_names[mkey]['Milestone']['id'] %>,<%= all_milesto_names[mkey]['Milestone']['project_id'] %>);">
                                            <a id="<% if(all_milesto_names[mkey]['Milestone']['id']==0){ %>miview_default<% }else{ %><%='miview_'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %>" href="javascript:void(0);" title="<%= all_milesto_names[mkey]['Milestone']['title'] %>" <% if(all_milesto_names[mkey]['Milestone']['isactive'] != 1){ %> class="taskCompleted"<% } %>>
                                                <%= all_milesto_names[mkey]['Milestone']['title'] %> 
                                            </a>
                                            <div class="form-group label-floating pr edit_task_group" id="<% if(all_milesto_names[mkey]['Milestone']['id']==0){ %>miviewtxtdv_default<% }else{ %><%='miviewtxtdv_'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %>" style="display:none;">
                                                <label class="control-label" for="focusedInput1"><?php echo __('Edit Task Group');?></label>
                                                <input style="display:none;" class="form-control mviewtxt" type="text" id="<% if(all_milesto_names[mkey]['Milestone']['id']==0){ %>miviewtxt_default<% }else{ %><%='miviewtxt_'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %>" onkeyup="inlineEditMilestone(event, <% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%= '\'default\'' %> <% }else{ %><%= all_milesto_names[mkey]['Milestone']['id'] %><% } %> , 0);" onblur="inlineEditMilestone(event, <% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%= '\'default\'' %> <% }else{ %><%= all_milesto_names[mkey]['Milestone']['id'] %><% } %> , 1);" />
                                                <span class="input-group-btn">
                                                    <button 
                                                        <% if(all_milesto_names[mkey]['Milestone']['id'] > 0){ %>
                                                        onclick="inlineEditMilestone(event, <%= all_milesto_names[mkey]['Milestone']['id'] %> , 1);"
                                                        <% }else{ %>
                                                        onclick="inlineEditMilestone(event,<%= '\'default\'' %>,0);"
                                                        <% } %>
                                                        type="button" class="quick-icon-lft btn btn-fab btn-fab-mini" title="Save">
                                                        <i class="material-icons">send</i>
                                                    </button>
                                                </span>
                                            </div>                                              
                                            <p class="<% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%='n_cnt_grpt_default' %> <% }else{ %><%='n_cnt_grpt_'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %> <% if(all_milesto_names[mkey]['Milestone']['isactive'] != 1){ %>taskCompleted<% } %>" >(<%= _count_tasks %>)</p>
                                        </div>
                                    </div>
                                </div>
                                <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?>
                                <div class="fl taskgroup-pencil <% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%='showEditTaskgroupdefault' %> <% }else{ %><%='showEditTaskgroup'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %>" 
                                     <% if(all_milesto_names[mkey]['Milestone']['id'] > 0){ %>
                                                onclick="showhideinlinedit( <%= all_milesto_names[mkey]['Milestone']['id'] %> );"
                                                <% }else{ %>
                                                onclick="showhideinlinedit(<%= '\'default\'' %>);"
                                                <% } %>
                                                >
                                 
                                              <a href="javascript:void(0);" title="<?php echo __('Edit');?>"><i class="material-icons">&#xE254;</i></a>
                                              
                                </div>
                              <?php } ?>
                                <div class="fl tskg-add-btn <% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%='n_tsk_grpt_default' %> <% }else{ %><%='n_tsk_grpt_'+ all_milesto_names[mkey]['Milestone']['id'] %><% } %>">
                                    <% if(all_milesto_names[mkey]['Milestone']['isactive']!=0){ %>
                                     <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>    
                                    <a href="javascript:void(0);" class="btn btn-raised btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk" onclick="setSessionStorage(<%= '\'Sub-task view Page\'' %>, <%= '\'Create Task\'' %>);creatask( <% if(all_milesto_names[mkey]['Milestone']['id']==0){ %> <%= '\'default\'' %> <% }else{ %><%= all_milesto_names[mkey]['Milestone']['id'] %><% } %> )"><?php echo __('Add Task');?></a>   
                                  <?php } ?>
                                    <% } %>
                                    <% if(all_milesto_names[mkey]['Milestone']['isactive'] != 1){ %>
                                    <a class="add_ntsk" href="javascript:void(0);" style="color:#F7C279;text-decoration:none;margin-top:3px;">
                                        <?php echo __('Completed');?>
                                    </a>
                                    <% } %>
                                </div>                               
                                <div class="cb"></div>
                            </div>
														<% if(all_milesto_names[mkey]['Milestone'].id != 0){ %>
														<div class="tg_extra_td tg_extra_hrdate">
															<span><?php echo __('Est. Hr(s)');?>: <strong id="tg_spn_est_id<%= all_milesto_names[mkey]['Milestone']['id'] %>"><%= all_milesto_names[mkey]['Milestone'].estimated_hours %></strong></span>
															<span><?php echo __('Start Date');?>: <strong id="tg_spn_st_id<%= all_milesto_names[mkey]['Milestone']['id'] %>"><%= all_milesto_names[mkey]['Milestone'].start_date %></strong></span>
															<span><?php echo __('End Date');?>: <strong id="tg_spn_ed_id<%= all_milesto_names[mkey]['Milestone']['id'] %>"><%= all_milesto_names[mkey]['Milestone'].end_date %></strong></span>
														</div>
														<div class="cb"></div>
														<% } %>
                        </td>
                    </tr>                    
                </tbody>
                <% }                
                if(_count_tasks == 0 && all_milesto_names[mkey]['Milestone']['id'] == 0 && all_milesto_names.length == 1 ){               
                %>
                <tbody class="no_shortable">
                    <tr class="noRecord"><td colspan="12" class="textRed"><?php echo __('No task group found');?></td></tr>
                </tbody>
               <% } }
                }else{ %>  
                <tbody class="no_shortable">
                    <tr class="noRecord"><td colspan="12" class="textRed"><?php echo __('No task group found');?></td></tr>
                </tbody>
                <% } %>
            </table>                                           
        </div>
        <% $("#task_paginate").html('');
            if(caseCount && caseCount!=0) {
                    var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
                    $("#task_paginate").html(tmpl("paginate_tmpl", pageVars));
            } %>
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
    <input type="hidden" id="curr_sel_project_id" value="" >
