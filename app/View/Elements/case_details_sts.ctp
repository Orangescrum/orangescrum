<?php 
$dtl_opt = (isset($popup) && $popup == 1)?'popup':'';
?>
<%
var dtl_opt = "<?php echo $dtl_opt; ?>";
if(is_active == 1 && (csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (csUsrDtls== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
	var user_can_change = 1;
}
%>
<span id="tour_detl_status<%= csUniqId %>" class="gray-txt cmn_ds_inb"><?php echo __('Status');?>:&nbsp;</span>
<% var progress = 0; var bg_sts_colr = '#c8c8c8'; %>
<div class="cmn_ds_inb" style="" id="stsdiv<%= csAtId %>">
	<% if(typetsk_id == "10" && 0){ %>
		   <p> <%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
	<% } else{ %>
	<% if(!parseInt(custom_status_id)){ %>
		<% if(is_active && (csLgndRep !=3 && csLgndRep !=5 && csLgndRep !=2 && csLgndRep !=4)){%>
			<div class="dropdown cmn_h_det_arrow">
				<div class="opt1" id="opt20">
					<% var more_opt = 'more_opt20'; %>
					<p class="status_tdet">
						   <a class="" href="javascript:void(0);" onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)">
							  <%= easycase.getColorStatus(csTypRep, csLgndRep) %><i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
						   </a>
				   </p>
				</div>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<div class="more_opt new_opt_more" id="more_opt20<%= csAtId %>">
					<ul class="dropdown-menu dropdown_tg_sts" style="top: 3px;">
						<li class="start"><a href="javascript:void(0);" onclick="startCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE039;</i><?php echo __('In Progress');?></a></li>
						<?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
						<li class="clos"><a href="javascript:void(0);" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a></li>
						<?php } ?>
						<li class="resolve"><a href="javascript:void(0);" onclick="caseResolve(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a></li>
					</ul>
				</div>
				<?php } ?>
			</div>
		<% }else if(is_active && (csLgndRep ==3)){%>
			<div class="dropdown cmn_h_det_arrow">
				<div class="opt1" id="opt20">
					<% var more_opt = 'more_opt20'; %>
					<p class="status_tdet">
					<a class="" href="javascript:void(0);" onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)">
						<%= easycase.getColorStatus(csTypRep, csLgndRep) %>
						<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
					</a>
					</p>
				</div>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<div class="more_opt new_opt_more" id="more_opt20<%= csAtId %>">
					<ul class="dropdown-menu dropdown_tg_sts" style="top: 3px;">
						<li class="new"><a href="javascript:void(0);" onclick="setNewCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a></li>
						<li class="start"><a href="javascript:void(0);" onclick="startCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE039;</i><?php echo __('In Progress');?></a></li>
						<li class="resolve"><a href="javascript:void(0);" onclick="caseResolve(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a></li>
					</ul>
				</div>
				<?php } ?>
			</div>
		<% }else if(is_active && csLgndRep ==5){%>	
			<div class="dropdown cmn_h_det_arrow">
				<div class="opt1" id="opt20">
					<% var more_opt = 'more_opt20'; %>
					<p class="status_tdet">
					<a class="" href="javascript:void(0);" onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)">
						<%= easycase.getColorStatus(csTypRep, csLgndRep) %>
						<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
					</a>
					</p>
				</div>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<div class="more_opt new_opt_more" id="more_opt20<%= csAtId %>">
					<ul class="dropdown-menu dropdown_tg_sts" style="top: 3px;">
						<li class="new"><a href="javascript:void(0);" onclick="setNewCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a></li>
						<li class="start"><a href="javascript:void(0);" onclick="startCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE039;</i><?php echo __('In Progress');?></a></li>
						<?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
						<li class="clos"><a href="javascript:void(0);" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
			</div>
		<%}else if(is_active && (csLgndRep ==2 || csLgndRep == 4)){%>
			<div class="dropdown cmn_h_det_arrow">
				<div class="opt1" id="opt20">
					<% var more_opt = 'more_opt20'; %>
					<p class="status_tdet">
						<a class="" href="javascript:void(0);" onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)">
							<%= easycase.getColorStatus(csTypRep, csLgndRep) %>
							 <i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
						</a>
					</p>
				</div>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<div class="more_opt new_opt_more" id="more_opt20<%= csAtId %>">
					<ul class="dropdown-menu dropdown_tg_sts" style="top: 3px;">
						<li class="new"><a href="javascript:void(0);" onclick="setNewCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE166;</i><?php echo __('New');?></a></li>
						<?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
						<li class="clos"><a href="javascript:void(0);" onclick="setCloseCase(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE876;</i><?php echo __('Close');?></a></li>
						<?php } ?>
						<li class="resolve"><a href="javascript:void(0);" onclick="caseResolve(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>,<%= '\''+dtl_opt+'\'' %>);"><i class="material-icons">&#xE889;</i><?php echo __('Resolve');?></a></li>
					</ul>
				</div>
				<?php } ?>
			</div>
		<% }else { %>
			<p class="fnt_clr_rd"><?php echo __('Archived');?></p>
		<% } %>
	<% }else{ %>		
		<% if(is_active){%>
			<div class="dropdown cmn_h_det_arrow">
				<div class="opt1" id="opt20">
					<% var more_opt = 'more_opt20'; %>
					<p class="status_tdet">
						   <a class="custom_sts_drop_v<%= csAtId %>" href="javascript:void(0);" onclick="open_more_opt('<%= more_opt %>',<%= '\''+csAtId+'\'' %>)">
							<% 
							$.each(cust_sts_list, function(k_y, v_l) { 
								if(v_l.CustomStatus.id == custom_status_id){ %>
									<%= v_l.CustomStatus.name %>
									<% progress = v_l.CustomStatus.progress; %>
									<% bg_sts_colr = v_l.CustomStatus.color; %>
							<% } }); %>
							  <i class="tsk-dtail-drop material-icons">&#xE5C5;</i>
						   </a>
				   </p>
				</div>
				<?php if($this->Format->isAllowed('Change Status of Task',$roleAccess)){ ?>
				<div class="more_opt new_opt_more" id="more_opt20<%= csAtId %>">
					<ul class="dropdown-menu dropdown_tg_sts" style="top: 3px;">
						<% $.each(cust_sts_list, function(k_y, v_l) { %>	
							<% if(custom_status_id != v_l.CustomStatus.id){ %>
							<% if(v_l.CustomStatus.status_master_id == 3){ %>
                  <?php if($this->Format->isAllowed('Status change except Close',$roleAccess)){ ?>
									<li class="">
										<a href="javascript:void(0);" onclick="setCustomStatus(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>, <%= '\''+v_l.CustomStatus.id+'\'' %>, <%= '\''+v_l.CustomStatus.status_master_id+'\'' %>, <%= '\''+v_l.CustomStatus.name+'\'' %>);">
											<span style="background-color:#<%= v_l.CustomStatus.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= v_l.CustomStatus.name %>
										</a>
									</li>
							<?php } ?>
							<% }else{ %>
							<li class="">
								<a href="javascript:void(0);" onclick="setCustomStatus(<%= '\''+csAtId+'\'' %>, <%= '\''+csNoRep+'\'' %>, <%= '\''+csUniqId+'\'' %>, <%= '\''+v_l.CustomStatus.id+'\'' %>, <%= '\''+v_l.CustomStatus.status_master_id+'\'' %>, <%= '\''+v_l.CustomStatus.name+'\'' %>);">
									<span style="background-color:#<%= v_l.CustomStatus.color %>;height: 11px;width: 11px;display: inline-block;"></span> <%= v_l.CustomStatus.name %>
								</a>
							</li>							
              <% } %>
						<% } }); %>
					</ul>
				</div>
		<?php } ?>
			</div>			
		<% }else { %>
			<p class="fnt_clr_rd"><?php echo __('Archived');?></p>
		<% } %>
		
	<% } %>
	
	<% } %>
</div>
<div class="task-progress" id="pgrsdiv<%= csAtId %>">
	<span class="gray-txt">
		<span class="fr" id="prgsloader" style="display:none"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/></span>
	</span>
	<% if(csLgndRep == 5 || csLgndRep == 3) {completedtask = 100;} %>
	<% if(completedtask && !parseInt(custom_status_id)){ progress = completedtask;} %>
	<% var prgidtemp = 'more_opt19'; %>
	<% var prgid= 'more_opt19'; %>
	<div id="tour_detl_progress<%= csUniqId %>" class="progress">
		<div class="progress-bar progress-bar-info" style="width: <%= progress %>% <%if(parseInt(custom_status_id)){%>;background-color:#<%=bg_sts_colr%><%}%>"></div>
		<div class="cb"></div>
	</div>	
	<div id="tskprgrs" class="cmn_h_det_arrow tsk_prgrss drop_percnt fr <?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?><% if(csLgndRep != 5 && csLgndRep != 3 && user_can_change ==1 && !parseInt(custom_status_id)){ %>dropdown option-toggle<% } %> <?php } ?>">
		<div class="opt1" id="opt19">
			<div class="text-right task_prog_percent" id="completed_task<%= csAtId %>" <% if(user_can_change == 1){ %>onclick="open_more_opt('<%= prgid %>',<%= '\''+csAtId+'\'' %>);" <% } %>>
				<span><%= progress %>%</span>
				<% if(csLgndRep != 5 && csLgndRep != 3 && !parseInt(custom_status_id)){ %>
					<i class="<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>tsk-dtail-drop<?php }?> material-icons">&#xE5C5;</i>
				<% } %>
			</div>
		</div>
		<?php if($this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>
    <% if(!parseInt(custom_status_id)){ %>
		<div class="more_opt detail-taskprog-drop" id="more_opt19<%= csAtId %>" >
			<ul style="display:none;" class="dropdown-menu dropdown_tg_sts">
				<% if((csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4 || csLgndRep == 0) && user_can_change == 1){ %>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(10,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>10</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(20,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>20</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(30,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>30</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(40,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>40</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(50,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>50</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(60,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>60</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(70,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>70</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(80,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>80</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(90,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>90</a></li>
					<li style="color:black;cursor:pointer;" onclick="changetaskProgressbar(100,<%= '\''+csAtId+'\''%>,<%= '\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><a>100</a></li>  
				<% } %>
			<ul>
		</div>
		<% } %>
    <?php } ?>
		<div class="cb"></div>
	</div>
	<div class="cb"></div>
</div>