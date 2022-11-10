<table id="grid-keep-selection" class="table table-condensed table-hover table-striped m-list-tbl">
    <thead>
        <tr>
        <th class="text-center tophead manage-list-th1">&nbsp;</th>
        <th id="list_project_name" class="tophead manage-list-th2"><a href="javascript:void(0);"class="sortproject_name"onclick="ajaxProjectSorting(<%= '\'project_name_field\', this' %>);">
        <div class="d-flex pr width-100-per">
        <div><?php echo __('Project Name');?></div>
        <div id ="prj_name_sort" class="icon tsk_sort"></div>
        <span class="sorting_arw">
        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_name_field") { %>
            <% if(order == 'asc'){ %>
                    <i class="material-icons tsk_asc">&#xE5CE;</i>
            <% }else{ %>
                    <i class="material-icons tsk_desc">&#xE5CF;</i>
            <% } %>								
        <% }else{ %>
                <i class="material-icons">&#xE164;</i>
        <% } %>
        </span>	
        </div>
        </div>
        </a></th>
        <% if(inArray('Template',fields)){ %>
        <th class="text-center tophead manage-list-th3">
            <a href="javascript:void(0);" class="sortproject_stdate" onclick="ajaxProjectSorting(<%= '\'project_tmplate_field\', this' %>);">    
                <div class="d-flex pr width-100-per">    
                    <div><?php echo __('Template');?></div>
                    <div id ="prj_tmplate_sort" class="icon tsk_sort"></div>
                    <span class="sorting_arw">
                        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_tmplate_field") { %>
                            <% if(order == 'asc'){ %>
                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                        <% }else{ %>
                                <i class="material-icons">&#xE164;</i>
                        <% } %>
                    </span>	
                </div>
            </a>
         </th>
        <% } %>
        <% if(inArray('Custom Field',fields)){ %>
            <% if(allCustomFields) { %>														
              <% for(var customFieldNames in custom_field_head) {									
              var customFieldName = custom_field_head[customFieldNames]; %>				
            <th class="text-center tophead manage-list-th3">
              <a href="javascript:void(0);" class=""><%= customFieldName  %></a>
            </th>
            <% } } } %>
        <th class="text-center tophead manage-list-th3">
            <a href="javascript:void(0);" class="sortproject_stdate" onclick="ajaxProjectSorting(<%= '\'project_shrtnme_field\', this' %>);">    
                <div class="d-flex pr width-100-per">    
                    <div><?php echo __('Short Name');?></div>
                    <div id ="prj_shrtnme_sort" class="icon tsk_sort"></div>
                    <span class="sorting_arw">
                        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_shrtnme_field") { %>
                            <% if(order == 'asc'){ %>
                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                        <% }else{ %>
                                <i class="material-icons">&#xE164;</i>
                        <% } %>
                    </span>	
                </div>
            </a>
        </th>
        <% if(inArray('Description',fields)){ %>
        <th class="tophead manage-list-th4"><a href="javascript:void(0);"><?php echo __('Description');?></a></th>
        <% } %>
        <th class="text-center tophead manage-list-th3">
            <a href="javascript:void(0);" class="sortproject_stdate" onclick="ajaxProjectSorting(<%= '\'project_stdate_field\', this' %>);">    
                <div class="d-flex pr width-100-per">    
                    <div><?php echo __('Start Date');?></div>
                    <div id ="prj_stdate_sort" class="icon tsk_sort"></div>
                    <span class="sorting_arw">
                        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_stdate_field") { %>
                            <% if(order == 'asc'){ %>
                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                        <% }else{ %>
                                <i class="material-icons">&#xE164;</i>
                        <% } %>
                    </span>	
                </div>
            </a>
        </th>
        <th class="text-center tophead manage-list-th3">
            <a href="javascript:void(0);" class="sortproject_stdate" onclick="ajaxProjectSorting(<%= '\'project_enddate_field\', this' %>);">    
                <div class="d-flex pr width-100-per">    
                    <div><?php echo __('End Date');?></div>
                    <div id ="prj_enddate_sort" class="icon tsk_sort"></div>
                    <span class="sorting_arw">
                        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_enddate_field") { %>
                            <% if(order == 'asc'){ %>
                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                        <% }else{ %>
                                <i class="material-icons">&#xE164;</i>
                        <% } %>
                    </span>	
                </div>
            </a>
        </th>
    	<th class="tophead manage-list-th4"><a href="javascript:void(0);"><?php echo __('Project Manager');?></a></th>
        <?php if($this->Format->isAllowed('Customer Name',$roleAccess)){ ?>
    		<th class="tophead manage-list-th4"><a href="javascript:void(0);"><?php echo __('Customer');?></a></th>
		<?php } ?>
        <% if(inArray('Status',fields)){ %>
        <th class="text-center tophead manage-list-th5">
        <a href="javascript:void(0);" class="sortproject_stdate" onclick="ajaxProjectSorting(<%= '\'project_status_field\', this' %>);">    
                <div class="d-flex pr width-100-per">    
                    <div><?php echo __('Status');?></div>
                    <div id ="prj_status_sort" class="icon tsk_sort"></div>
                    <span class="sorting_arw">
                        <% if(typeof sort_by != 'undefined' && sort_by != "" && sort_by == "project_status_field") { %>
                            <% if(order == 'asc'){ %>
                                    <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                                    <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                        <% }else{ %>
                                <i class="material-icons">&#xE164;</i>
                        <% } %>
                    </span>	
                </div>
            </a>
        </th>
        <% } %>
        <% if(inArray('Status Workflow',fields)){ %>
        <th class="text-center tophead manage-list-th5"><a href="javascript:void(0);"><?php echo __('Status Workflow');?></a></th>
        <% } %>
        <% if(inArray('Tasks',fields)){ %>
        <th class="text-center tophead manage-list-th6"><a href="javascript:void(0);">#<?php echo __('Tasks');?></a></th>
        <% } %>
        <% if(inArray('Users',fields)){ %>
        <th class="text-center tophead manage-list-th7"><a href="javascript:void(0);">#<?php echo __('Users');?></a></th>
        <% } %>
        <th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Estimated Hour(s)');?></a></th>
    	<th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Hour(s) Spent');?></a></th>
        <% if(inArray('Budget',fields)){ %>
        <th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Budget');?></a></th>
        <% } %>
        <% if(inArray('Cost Approved',fields)){ %>
        <th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Cost Approved');?></a></th>
        <% } %>
        <% if(inArray('Project Type',fields)){ %>
        <th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Project Type');?></a></th>
        <% } %>
        <% if(inArray('Industry',fields)){ %>
        <th class="text-center tophead manage-list-th9"><a href="javascript:void(0);"><?php echo __('Industry');?></a></th>
        <% } %>
        <% if(inArray('Last Activity',fields)){ %>
        <th class=" tophead manage-list-th10"><a href="javascript:void(0);"><?php echo __('Last Activity');?></a></th>
        <% } %>
        </tr>
    </thead>
    <% 
    var count = 0;
    var clas = "";
    var space = 0;
    var spacepercent = 0;
    var totCase = 0;
    var totHours = '0.0';
    if(prjAllArr){ 
        for(var k in prjAllArr){
            var prjArr = prjAllArr[k];
            var totUser = prjArr['0']['totusers'] ? prjArr[0]['totusers']: '0';
            var totCase = prjArr['0']['totalcase'] ? prjArr[0]['totalcase']: '0';
            var totHours = prjArr[0]['totalhours'] ? prjArr[0]['totalhours'] : '0';
            var estimatedHours = prjArr['Project']['estimated_hours'] ? prjArr['Project']['estimated_hours'] : '0';
            var prj_name = prjArr['Project']['name'];
            if (prjArr['Project']['isactive'] == 1 && prjArr['Project']['status'] == 1) {
                var sts_txt = 'Started';
                } else if (prjArr['Project']['isactive'] == 1 && prjArr['Project']['status'] == 2) {
                    var sts_txt = 'On Hold';
                } else if (prjArr['Project']['isactive'] == 1 && prjArr['Project']['status'] == 3) {
                    var sts_txt = 'Stack';
                } else if (prjArr['Project']['isactive'] == 2) {
                    var sts_txt = 'Completed';
                }else{
                    var sts_txt = ProjectStatus[prjArr['Project']['status']];
                } %>
            <tr class="row_tr prjct_lst_tr">
                <td class="text-center">
                    <div class="dropdown">
                        <div data-toggle="dropdown" class="sett dropdown-toggle" ><i class="material-icons">&#xE5D4;</i></div>
                        <?php if(SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3){ ?>
                            <ul class="dropdown-menu">
                                <li class="pop_arrow_new"></li>
                                <% if (projtype == 'active-grid') { 
                                    if (prjArr['Project']['isactive'] == 2) {  %>
                                            <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                                <li><a href="javascript:void(0);" class="icon-grid-enable-prj enbl_prj" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>" data-view="<%= projtype %>"onclick="enablePrjListView(this);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                            <?php } ?>
                                            <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                                <li><a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<%= prjArr['Project']['uniq_id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="deleteProjectListView(this);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                            <?php } ?>
                                        <% }else{  %>
                                            <% if((SES_TYPE == 1 || SES_TYPE == 2) && (proj_users_list[prjArr['Project']['id']])){ %>
                                                <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                                    <li class="assgnremoveme<%= prjArr['Project']['uniq_id'] %>"><a href="javascript:void(0);"  data-prj-uid ="<%= prjArr['Project']['uniq_id'] %>" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-name="<%=  prjArr['Prjname'] %>" data-prj-usr="<?php echo SES_ID; ?>" onclick="removeMeFromPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE15C;</i> <?php echo __('Remove me from here');?></a></li>
                                                <?php } ?> 
                                                <% } else if(SES_TYPE == 1 || SES_TYPE == 2){ %>
                                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                                        <li class="assgnremoveme<%= prjArr['Project']['uniq_id'] %>"><a href="javascript:void(0);"  data-prj-uid ="<%= prjArr['Project']['uniq_id'] %>" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-name="<%=  prjArr['Prjname'] %>" data-prj-usr="<?php echo SES_ID; ?>" onclick="assignMeToPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE147;</i> <?php echo __('Add me here');?></a></li>
                                                        <?php } ?> 
                                                    <% } %>
                                                    <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                                        <li><a href="javascript:void(0);" class="icon-grid-edit-usr " data-prj-id="<%= prjArr['Project']['uniq_id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="editProjectFrmListView(this);"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                                                        <?php } ?> 
                                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                                        <li><a href="javascript:void(0);" class="icon-grid-add-usr " data-prj-uid ="<%= prjArr['Project']['uniq_id'] %>" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-name="<%= prjArr['Prjname'] %>" data-prj-usr="<%=  prjArr['Project']['user_id'] %>"onclick="addUserToProjectListView(this)"><i class="material-icons">&#xE147;</i> <?php echo __('Add User');?></a></li>
                                                        <?php } ?> 
                                                    <% if (prjArr[0]['totusers']) { %>
                                                        <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                                            <li><a href="javascript:void(0);" class="icon-grid-remove-usr" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="removeUsrFrmProjectListView(this)"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a></li>
                                                            <?php } ?> 
                                                    <% } %>
                                                    <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                                        <li id="ajax_remove<%= prjArr['Project']['id'] %>" style="display:none;">
                                                            <a href="javascript:void(0);" class="icon-grid-remove-usr" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="removeUsrFrmProjectListView(this)"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                                        </li>
                                                        <?php } ?>  
                                                    <?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                        <li>
                                                            <a href="javascript:void(0);" class="icon-assgn-role" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="assignRoleFrmListView(this);"><i class="material-icons">&#xE147;</i><?php echo __("Assign Role");?></a>
                                                        </li>
                                                        <?php } ?> 
                                                    <li><%  if (prjArr[0]['totalcase'] != 0) { 
                                                        for(var key in ProjectStatus){
                                                            var value = ProjectStatus[key];%>
                                                            <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                                                <%  if (value !='Completed'){ %>
                                                                    <a href="javascript:void(0);" class="icon-grid-enable-prj change_prj_status" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>" data-prj-status-name="<%= value %>" data-prj-status-id="<%= key %>"onclick="changePrjStatus(this);"><i class="material-icons">&#xE86C;</i> <%= value %></a>
                                                                    <% } %>
                                                            <?php } ?> 
                                                        <% }
                                                        %>
                                                        <a href="javascript:void(0);" class="icon-grid-enable-prj disbl_prj" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"><i class="material-icons">&#xE86C;</i> <?php echo __('Completed');?></a>
                                                        <% } else { %>
                                                            <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                                                <a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="deleteProjectListView(this);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                                            <?php } ?>    
                                                        <% } %>
                                                    </li>
                                    <% } }  else if (projtype == 'inactive-grid') { %>
                                        <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-enable-prj enbl_prj" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>" data-view="<%= projtype %>"onclick="enablePrjListView(this);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                        <?php } ?>
                                        <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<%= prjArr['Project']['id'] %>" data-prj-uid="<%= prjArr['Project']['uniq_id'] %>" data-prj-name="<%= prjArr['Prjname'] %>"onclick="deleteProjectListView(this);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                        <?php } ?>
                                        <% } %>
                        <?php }else{ ?>
                            <ul class="dropdown-menu" <% if(SES_TYPE == 3 && prjArr['Project']['user_id'] != SES_ID){ %> onclick="notAuthAlert();" <% } %>>
                            <% if (projtype == 'active-grid') { 
                                if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) {
                                %>
                                <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                <?php } ?>
                                <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                <?php } ?> 
                                <% } else { %>
                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                        <li><a href="javascript:void(0);"><i class="material-icons">&#xE147;</i> <?php echo __('Add User');?></a></li>
                                    <?php } ?>   
                                    <li>
                                        <% if (prjArr[0]['totusers']) { %>
                                            <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                                <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                            <?php } ?>  
                                        <% } %>
                                    </li>
                                    <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                        <li style="display:none;">
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                        </li>
                                    <?php } ?> 
                                    <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                        <li><a href="javascript:void(0);"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                                    <?php } ?>
                                    <li> 
                                    <%  if (prjArr[0]['totalcase']) {  %>
                                        <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a> 
                                        <?php } ?>  
                                        <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a>
                                        <?php } ?>       
                                    <% } else { %>
                                        <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                            <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                        <?php } ?> 

                                    <% } %>
                                    </li>    
                                <% } %>
                                
                            <% } else { %>
                                <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                    <li>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a>
								    </li>
                                <?php } ?>  
                                <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?> 
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>  
                                <?php } ?>
                            <% } %>

                            </ul>
                        <?php } ?>
                    </div>
                </td>
                <% if(prjArr['Project']['isactive'] == 1){
                    console.log(prjArr['Project']['prio']); 
                    if((prjArr['Project']['prio'] =='high')){
                        var prio_text = 'High';
                    } else if((prjArr['Project']['prio'] == 'medium')){
                        var prio_text = 'Medium';
                    } else {
                        var prio_text = 'Low';
                    } %>
                    <td align="left"><a class="ttl_listing" id = "prj_ttl_<%= prjArr['Project']['uniq_id'] %>" href="javascript:void(0);" title="<%= prjArr['tooltip']%>"
                    onclick="return projectBodyClick('<%= prjArr['Project']['uniq_id'] %>');"><%= prjArr['prj_name_shrt'] %> &nbsp; </a> <br />
                    <span class="prio_<%= prjArr['Project']['prio'] %> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<%= prio_text %> <?php echo __('Priority');?>"></span> <span style="font-size:12px;"><%= prio_text %></span> 
                    <span class="project_role_txt"><%= (prjArr[0]['role']) ? prjArr[0]['role'] : prjArr[0]['crole'] %></span>
                    <br />
                    <span style="color:#8d8d8e;font-size:12px;">
                    <?php echo __('Created by')?> <%= p_u_name[prjArr['Project']['user_id']] %> <?php echo __('on');?> <%= prjArr['dateTime'] %>
                    </span>
                    </td>

                    <% } else if (prjArr['Project']['isactive'] == 2) { %>
                        <td align="left"><a class="ttl_listing" id = "prj_ttl_<%= prjArr['Project']['uniq_id'] %>" href="javascript:void(0);" title="<%= prjArr['tooltip'] %>"
                            onclick="return inactiveProjectBodyClick('<%= prjArr['Project']['uniq_id'] %>');"><%= prjArr['prj_name_shrt'] %> &nbsp; </a> <br />
                            <span class="prio_<%= prjArr['Project']['prio'] %> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<%= prjArr['Project']['prio'] %> <?php echo __('Priority');?>"></span> <span style="font-size:12px;"><%= prio_text %></span> 
                            <span class="project_role_txt"><%= (prjArr[0]['role']) ? prjArr[0]['role'] : prjArr[0]['crole'] %></span>
                            <br />
                            <span style="color:#8d8d8e;font-size:12px;">
                            <?php echo __('Created by')?> <%= p_u_name[prjArr['Project']['user_id']] %> <?php echo __('on');?> <%= prjArr['dateTime'] %>
                            </span>
                        </td>

                        <% } 
                         if(inArray('Template',fields)){ %>
                        <td class="text-center"><%= ((prjArr['PML']['title'])) %></td>
                        <% } %>

                        <% if(inArray('Custom Field',fields)){ %>
                            <% for(var c_id in custom_field_ids){ 
                                var cstm_val = "no"; %>
                        <td class="text-center" <% if(cstm_val != 'no' && cstm_val !== 0){ if(prjArr['Project']['custom_fields'][custom_field_ids[c_id]] && cstm_val.toString().charAt(0) == '-'){ %>style="color:#EB7154;"<% }else{ %>style="color:#54EB7B;"<% } } %>>
                               <% if(prjArr['Project']['custom_fields'][custom_field_ids[c_id]]){ %>
                            <span class="ellipsis-view" style="display:block;width:150px" title="<%= prjArr['Project']['custom_fields'][custom_field_ids[c_id]]['CustomFieldValue']['value'] %>"> 
                                <%= prjArr['Project']['custom_fields'][custom_field_ids[c_id]]['CustomFieldValue']['value'] %>
                            </span>
                              <%  }else{ %>
                                    --
                               <% } %>
                               </td>
                            <% } %>
                        <% } %>

                        <td class="text-center txt_upper_prj"><%= prjArr['Project']['short_name'] %></td>
                        <% if(inArray('Description',fields)){ %>
                        <td title="<%= prjArr['frmt_description'] %>"><span class="ellipsis-view" style="display:block;width:150px"><%= prjArr['frmt_description'] %></span></td>
                        <% } 
                            var stdate = (prjArr['Project']['start_date']) ? prjArr['project_tz_startdate'] : "N/A";
							var stdatestamps = (prjArr['Project']['start_date']) ? prjArr['stdatestamp'] : 0;
							var endate = (prjArr['Project']['end_date']) ? prjArr['project_tz_enddate'] : "N/A"; 
							var endatestamps = (prjArr['Project']['end_date']) ? prjArr['endatestamp'] : 0; 
                        %>

                        <td class="text-center" data-order="<%= stdatestamps %>"><%= stdate %></td>
						<td class="text-center" data-order="<%=  endatestamps %>"><%= endate %></td>
                        <% if(prjArr['ProjectMeta']['ProjectMeta']){%>
                        <td title="<%= (prjArr['ProjectMeta']['ProjectMeta']['client']['project_manager'] != 0) ? prjmanager_names[prjArr['ProjectMeta']['ProjectMeta']['project_manager']] : 'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (prjArr['ProjectMeta']['ProjectMeta']['project_manager'] != 0) ? prjmanager_names[prjArr['ProjectMeta']['ProjectMeta']['project_manager']] : 'N/A' %></span></td>
                        <% } else{ %>
                            <td title="<%= 'N/A' %>"> <%= 'N/A' %> </td>
                        <% } %>
                        <?php if($this->Format->isAllowed('Customer Name',$roleAccess)){ ?>
                            <% if(prjArr['ProjectMeta']['ProjectMeta']){%>
                            <td title="<%= (prjArr['ProjectMeta']['ProjectMeta']['client'] != 0) ? user_list[prjArr['ProjectMeta']['ProjectMeta']['client']] : 'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (prjArr['ProjectMeta']['ProjectMeta']['client']!= 0) ? user_list[prjArr['ProjectMeta']['ProjectMeta']['client']] : 'N/A' %></span></td>
                            <% } else{ %>
                                <td title="<%= 'N/A' %>"> <%= 'N/A' %> </td>
                            <% } %>  
                            <?php } ?>
                            <% if(inArray('Status',fields)){ %>
                            <td class="text-center"><%= sts_txt %></td>
                            <% } 
                            if(inArray('Status Workflow',fields)){ 
                             if(csts_arr_grp != ''){  %>
                                <td class="text-center"><%= (prjArr['Project']['status_group_id'] != 0 ) ? csts_arr_grp[prjArr['Project']['status_group_id']]['name'] : 'Default Status Workflow' %></td>
                            <% } else{ %>
                                <td class="text-center"><?php  echo __('Default Status Workflow') ?></td>
                            <% } } %>
                            <% if(inArray('Tasks',fields)){ 
                             if (prjArr['Project']['isactive'] == 2 || prjArr['Project']['status'] == 4) { %>
                                <td class="text-center"><%= totCase %></td>
                            <% } else { %>
                                <td class="text-center proj_tsks_cnt" onclick="return projectBodyClick('<%= prjArr['Project']['uniq_id'] %>','tasks');" style="cursor:pointer;"><%= totCase %></td>
                            <% } }
                            if(inArray('Users',fields)){ %>
                            <td class="text-center"><%= (prjArr[0]['totusers']) ? prjArr[0]['totusers'] : '0' %></td>
                            <% } %>
                            <td class="text-center"><%= estimatedHours %></td>
                            <td class="text-center"><%= (totHours > 0) ? prjArr['total_spenthours']  : totHours %></td>
                            <% if(inArray('Budget',fields)){ %>
                            <?php if($this->Format->isAllowed('Budget',$roleAccess)){ ?>
                                <% if(prjArr['ProjectMeta']['ProjectMeta']!='undefined'){ %>
							        <td title="<%= prjArr['ProjectMeta']['ProjectMeta'] ? prjArr['ProjectMeta']['ProjectMeta']['budget'] : 'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (prjArr['ProjectMeta']['ProjectMeta']) ? prjArr['ProjectMeta']['ProjectMeta']['budget']:'0.00' %></span></td>
                                <% } %>
                            <?php  } ?>
                            <% } %>
                            <% if(inArray('Cost Approved',fields)){ %>
                            <?php if($this->Format->isAllowed('Cost Appr',$roleAccess)){ ?>
                                <td title="<%= (prjArr['ProjectMeta']['ProjectMeta']) ? prjArr['ProjectMeta']['ProjectMeta']['cost_appr']:'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (prjArr['ProjectMeta']['ProjectMeta']) ? prjArr['ProjectMeta']['ProjectMeta']['cost_appr']:'0.00' %></span></td>
                            <?php  } ?>
                            <% } %>
                            <% if(inArray('Project Type',fields)){ 
                              if(prjArr['ProjectMeta']){ %>
                            <td title="<%= (projecttype[prjArr['ProjectMeta']['ProjectMeta']['proj_type']]) ? projecttype[prjArr['ProjectMeta']['ProjectMeta']['proj_type']] : 'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (projecttype[prjArr['ProjectMeta']['ProjectMeta']['proj_type']]) ? projecttype[prjArr['ProjectMeta']['ProjectMeta']['proj_type']]:'N/A' %></span></td>
                            <% }else{ %>
                                <td title="N/A"><?php echo __("N/A"); ?> </td>
                            <% } }

                          if(inArray('Industry',fields)){ 
                            if(prjArr['ProjectMeta']['ProjectMeta']){ %>
                                <td title="<%= (prjArr['ProjectMeta']['ProjectMeta']['industry'] != '0') ? industries[prjArr['ProjectMeta']['ProjectMeta']['industry']]:'N/A' %>"><span class="ellipsis-view" style="display:block;width:150px"><%= (prjArr['ProjectMeta']['ProjectMeta']['industry'] != '0') ? industries[prjArr['ProjectMeta']['ProjectMeta']['industry']]:'N/A' %></span></td>
                            <% } else { %>
                                <td title="N/A"><?php echo __("N/A"); ?> </td>
                            <% } }
                        if(inArray('Last Activity',fields)){ %>
                            <td>
                                <% 
                                if (prjArr['getactivity'] == null) { %>
                                    <?php echo __('No activity'); ?>
                                <% } else { %>
                                   <%= prjArr['localActivityDTArr'] %>
                               <%  } %>
                                </td>
                                <% } %>


            </tr>
        <% }
    } %>
		<% if(!parseInt(caseCount)){ %>
			<tr>
				<td colspan="<%= 8+fields.length %>" style="color:#ff0000"><?php echo __('No project found.'); ?></td>
			</tr>
		<% } %>	
</table>


<%
 if (caseCount) {  
    $("#project_paginate").html('');
    if(caseCount && caseCount!=0) {
            var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
            console.log(pageVars);
            $("#project_paginate").html(tmpl("project_paginate_tmpl", pageVars));
    } 
 } %>
