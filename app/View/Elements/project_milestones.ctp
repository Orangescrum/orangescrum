<div class="">
	<table id="milestone_list_table" class="width-100-per">
	<tr class="qtask quicktskgrp_tr_lnk">
			<td>
				<div class="new_qktaskgrp_mc">
						<div class="width-100-per" id="new_grp_label"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr"><i class="material-icons">&#xE145;</i><?php echo __('Quick Task Group');?></a></div>
				</div>                               
			</td>
	</tr>
	<tr class="quicktskgrp_tr">
		<td>                            
			<div class="form-group label-floating quicktskgrp_form_grp p_0">
				<div class="input-group">
				<label class="control-label" for="inline_milestone"><?php echo __('Task Group Title');?></label>
				<input class="form-control" type="text" id="inline_milestone" maxlength="240" >
					<span class="input-group-btn">
						<button type="button" class="btn btn-fab btn-fab-mini" onclick="AddNewMilestone();">
							<i class="material-icons qk_send_icon_mi">send</i>
						</button>
					</span>
				</div>
			</div>
		</td>
	</tr>
	<%
		var milTotal = Object.keys(project_milestones).length;
		$('.milestone_filter_active').hide();
		if(milTotal>0){
			for(var k in project_milestones) {
			var nm_mil = project_milestones[k]["Milestone"]["title"];
			if(project_milestones[k]["Milestone"]["id"] == selected_mid && selected_mid != "" || (selected_mid == "default" && project_milestones[k]["Milestone"]["id"] == '0')){
				$('.milestone_filter_active').show();
				$('#milestone_filter_active_name').html(nm_mil);
			}
	%>
				<tr class="togl_tr">
					<td <% if(project_milestones[k]["Milestone"]["id"] == selected_mid && selected_mid != "" || (selected_mid == "default" && project_milestones[k]["Milestone"]["id"] == '0')){ %>class="active"<% } %>>
						<div>
							<div class="d-flex">
							<div class="vdot_action">
								<span class="dropdown n_tsk_grp" id="n_tsk_grp_<%= project_milestones[k]["Milestone"]["id"] %>">
										<a class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
												<i class="material-icons">&#xE5D4;</i>
										</a>
										<ul class="dropdown-menu sett_dropdown-caret aede-drop-text">			  
												<li class="pop_arrow_new" style="left:126px"></li>
												<% if(project_milestones[k]['Milestone']['id'] > 0){ %>
												<% if(project_milestones[k]['Milestone']['isactive'] != 0){ %>
												<?php if($this->Format->isAllowed('Add Tasks to MIlestone',$roleAccess)){ ?> 
												<li onClick="addTaskToMilestone( <%= '\'\',\'' + project_milestones[k]['Milestone']['id'] + '\'' %> , <%= '\'' + project_milestones[k]['Milestone']["project_id"] + '\'' %>,0,1)">
														<a href="javascript:void(0);" class="mnsm">
																<i class="material-icons">&#xE85D;</i><?php echo __('Assign Task');?>
														</a>
												</li>
											<?php } ?>
												 <?php /*<%                                            
												 if(_count_tasks<= 0 && _default_count_tasks <=0){ %>
													<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?> 
												<li onClick="convertToTask(this, <%= '\'' + project_milestones[k]['Milestone']['id'] + '\'' %> , <%= '\'' + project_milestones[k]['Milestone']["project_id"] + '\'' %>,0,1)" id="convrt_task_<%= project_milestones[k]['Milestone']['id'] %>">
														<a href="javascript:void(0);" class="mnsm">
																<i class="material-icons">&#xE15A;</i><?php echo __('Convert to Task');?>
														</a>
												</li>
											<?php } ?>
												<% } %> */ ?>
												 <?php if($this->Format->isAllowed('Edit Milestone',$roleAccess)){ ?> 
												<li class="makeHover" onclick="addEditMilestone(0, <%= '\'' + project_milestones[k]['Milestone']["uniq_id"] + '\'' %>,<%= project_milestones[k]['Milestone']["id"] %>,<%= '\'' + escape(project_milestones[k]['Milestone']["title"]) + '\'' %>,1,<%= '\'taskgroup\'' %>,<%= '\'' + project_milestones[k]['Milestone']["project_id"] + '\'' %>)">
														<a href="javascript:void(0)" class="mnsm">
																<i class="material-icons">&#xE254;</i><?php echo __('Edit');?>
														</a>
												</li>
											<?php } ?>
												<% } %>
												 <?php if($this->Format->isAllowed('Delete Milestone',$roleAccess)){ ?> 
												<li class="makeHover" onclick="delMilestone(0, <%= '\'' + escape(project_milestones[k]['Milestone']["title"]) + '\'' %>, <%= '\'' + project_milestones[k]['Milestone']["uniq_id"] + '\'' %>,<%= project_milestones[k]['Milestone']["id"] %>);">
														<a href="javascript:void(0);" class="mnsm">
																<i class="material-icons">&#xE872;</i><?php echo __('Delete');?> 
														</a>                                          
												</li>
											<?php } ?>
											 <% if(project_milestones[k]['Milestone']['isactive'] != 0){ %>
											 <?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>  
												<li onclick="milestoneArchive( <%= '\'\',\'' + project_milestones[k]['Milestone']["uniq_id"] + '\'' %>, <%= '\'' + escape(project_milestones[k]['Milestone']["title"]) + '\'' %>,1);">
														<a href="javascript:jsVoid();" class="mnsm">
																<i class="material-icons">&#xE86C;</i><?php echo __('Complete');?>
														</a>
												</li>
											<?php } ?>
												<% }else{ %>
												<?php if($this->Format->isAllowed('Mark Milestone as Completed',$roleAccess)){ ?>
												<li onclick="milestoneRestore( <%= '\'\',\'' + project_milestones[k]['Milestone']["uniq_id"] + '\'' %>, <%= '\'' + escape(project_milestones[k]['Milestone']["title"]) + '\'' %>,1);">
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
							<a href="javascript:void(0);" class=".d-flex-column milestone_link <% if(!parseInt(project_milestones[k]["Milestone"]["isactive"])){ %>inactive<% } %>" onclick="subtaskFilterByMilestone(<%= project_milestones[k]["Milestone"]["id"]%>);">
							<div class="d-flex hover_subtask_title">
								<span class="ellipsis-view">
									<%= project_milestones[k]['Milestone']['title']%> 
								</span> 
								<span class="count_no">
								(<%= project_milestones[k][0]['CNT']%>)
								</span>
							</div>								
								<div class="pop_subtask_tooltip">
									<p><%= project_milestones[k]['Milestone']['title'] %></p>
								</div>
								<div class="time_date_ontask">
									<p>Est Hrs: <span><%= project_milestones[k]['Milestone']['estimated_hours']%></span></p>
									<p>Start Date: <span><%= project_milestones[k]['Milestone']['start_date']%></span></p>
									<p>Due Date: <span><%= project_milestones[k]['Milestone']['end_date']%></span></p>
								</div>
							</a>
						</div>
						</div>
					</td>
				</tr>
	<%		}
		}else{
	%>
			<tr>
				<td class="nofound color_red">
					<?php echo __("No Task Group found."); ?>
				</td>
			</tr>
	<%	}
	%>
	</table>
</div>