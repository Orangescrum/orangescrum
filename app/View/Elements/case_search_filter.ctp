<div class="task_listing timelog_lview">
	<div class="m-cmn-flow">
    <table class="table table-striped  m-list-tbl">
			<tbody>
				<tr>
					<th style="width:50%; border-top:none;"> 
						<a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'name\', ' + caseCount + ', this' %> );">Name                       
							<span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "name") { %>
								<% if(orderByType == "ASC"){ %>
								<i class="material-icons tsk_asc">&#xE5CE;</i>
								<% }else{ %>
								<i class="material-icons tsk_desc">&#xE5CF;</i>
								<% } %>								
								<% }else{ %>
								<i class="material-icons">&#xE164;</i>
								<% } %></span>
								</a>
                </th>
                <th style="width:10%;border-top:none;"><?php echo __('Tasks Count');?></th>
                <th style="width:30%; border-top:none;"><?php echo __('Filter Items');?></th>
                <th style="width:10%;border-top:none;"><?php echo __('Action');?></th>
								</tr>
								<% if(typeof details != 'undefined' && details.length >0 ){
									for(var filter in details){ 
								%>
								<tr>
                <td id="name<%= details[filter]["SearchFilter"]["id"] %>"><span><%= details[filter]["SearchFilter"]["name"] %></span></td>
								<td><%= details[filter]["SearchFilter"]["namewithcount"] %></td>
								<td class="tag-btn-td">
								<% var fid=details[filter]["SearchFilter"]["id"];
									var ftypes=JSON.parse(details[filter]["SearchFilter"]["json_array"]);
									for(var ftype in ftypes){
									if(ftypes[ftype] !="" && ftypes[ftype] !="all"){ 
								if(ftype=="STATUS"){ %>
								<%= ftypes[ftype] %>
								<% } else if(ftype=="CUSTOM_STATUS"){ %>
									<%= ftypes[ftype] %>
								<% } else if(ftype=="CS_TYPES"){ %>
								<%= ftypes[ftype] %>
								<% } else if(ftype=="TASKLABEL"){ %>
								<%= ftypes[ftype] %>
								<% 
									} else if(ftype=="PRIORITY" && ftypes[ftype] !="" && ftypes[ftype] !="all"){ 
									x=ftypes[ftype].split("-");
									for(var j=0;x.length > j; j++){	
								%>
								<span class="filter_opn" rel="tooltip" title="<?php echo __('Priority');?>" "><%= x[j] %><a href="javascript:void(0);" onclick="deleteFilterItem(<%= fid %>,<%= '\''+ ftype + '\'' %>,<%= '\''+x[j]+ '\'' %>,this);" class="fr"><i class="material-icons">&#xE14C;</i></a></span>
									<%}
									}else if(ftype=="MEMBERS"){ %>
									<%= ftypes[ftype] %>
									<%}else if(ftype=="COMMENTS"){ %>
									<%= ftypes[ftype] %>
									<%}else if(ftype=="ASSIGNTO"){ %>
									<%= ftypes[ftype] %>
									<%}else if(ftype=="TASKGROUP"){ %>
									<%= ftypes[ftype] %>
									<%}else if(ftype=="DATE" && ftypes[ftype] !="" && ftypes[ftype] !="any"){ 
										x=ftypes[ftype].split("-"); 
										for(var j=0;x.length > j; j++){	
										if(x[j]=="one")
										v="Past hour";
										else if(x[j]=="24")
										v="past 24 hours";
										else if(x[j]=="any")
										v="Any time";
										else if(x[j]=="week")
										v="Past week";	
										else if(x[j]=="month")
										v="Past month";	
										else if(x[j]=="year")
										v="Past year";							
										else	
										v=decodeURIComponent(x[j].replace(":","-"));
									%>
									<span class="filter_open" rel="tooltip" title="<?php echo __('Time');?>"><%= v %><a href="javascript:void(0);" onclick="deleteFilterItem(<%= fid %>,<%= '\''+ ftype + '\'' %>,<%= '\''+x[j]+ '\'' %>,this);" class="fr"><i class="material-icons">&#xE14C;</i></a></span>
										<%}
											}else if(ftype=="DUE_DATE" && ftypes[ftype] !="" && ftypes[ftype] !="any"){
											x=ftypes[ftype].split("-");
											for(var j=0;x.length > j; j++){	
											if(x[j]=="overdue")
											v="Overdue";
											else if(x[j]=="24")
											v="Today";
											else if(x[j]=="any")
											v="Any Time";							
											else	
											v=decodeURIComponent(x[j].replace(":","-"));
										%>
										<span class="filter_open" rel="tooltip" title="<?php echo __('Due Date');?>" ><%= v %><a href="javascript:void(0);" onclick="deleteFilterItem(<%= fid %>,<%= '\''+ ftype + '\'' %>,<%= '\''+x[j]+ '\'' %>,this);"  class="fr"><i class="material-icons">&#xE14C;</i></a></span>
											<% }
												}
												}
												}
											%>
											</td>
											<td class="action_tlv">
											<a href="javascript:void(0);" class="anchor" style="display:none;" id="SaveFiltr<%= details[filter]["SearchFilter"]["id"] %>" title="<?php echo __('Save Filter');?>" onclick="saveFilterDataBtn(<%= details[filter]["SearchFilter"]["id"] %>)"><i class="material-icons">&#xE876;</i></a> &nbsp;&nbsp;
											<a href="javascript:void(0);" class="anchor" id="EditFilter<%= details[filter]["SearchFilter"]["id"] %>" title="<?php echo __('Edit');?>" onclick="editInlineFilter(<%= details[filter]["SearchFilter"]["id"] %>)"><i class="material-icons">&#xE254;</i></a> &nbsp;&nbsp;					
											<a href="javascript:void(0);" class="anchor" title="<?php echo __('Delete');?>" onclick="deleteInlineFilter(<%= details[filter]["SearchFilter"]["id"] %>)"><i class="material-icons">&#xE872;</i></a>
											</td>
											</tr>
											<% } }else{ %>
											<tr><td colspan="4" style="color:red; text-align: center;"><?php echo __('No filter has been created');?>. </td></tr>
											<% } %>
											</tbody>
											</table>
											</div>
											<% $("#task_paginate").html('');
												if(caseCount && caseCount!=0) {
												var pageVars = {pgShLbl:pgShLbl,csPage:csPage,page_limit:page_limit,caseCount:caseCount};
												$("#task_paginate").html(tmpl("paginate_tmpl", pageVars));
											} %>
										</div>										