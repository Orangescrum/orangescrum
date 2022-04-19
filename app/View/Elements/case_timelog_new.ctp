<% 
    var SHOWTIMELOG = getCookie('SHOWTIMELOG'); 
    var pagename = typeof logtimes.page !='undefined' ? logtimes.page : ''; 
    if(pagename == 'taskdetails' && SHOWTIMELOG == ''){
        SHOWTIMELOG = 'No';
    }
    SHOWTIMELOG = typeof logtimes.page !='undefined' && logtimes.page == 'taskdetails' ? SHOWTIMELOG : 'Yes'; 
%>
<% if(pagename != 'taskdetails'){ %>
<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<% } %>
<% if(pagename != 'taskdetails' && timelog_filter_msg != '' && timelog_filter_msg != null) {%>
    <%
	if(timelog_filter_msg == '' || timelog_filter_msg == null){
		$('.timelog_filter_msg').hide();
	}else{
		$('.timelog_filter_msg').show();
		$('.timelog_filter_msg').html('<span class="tg_msg_pos">'+timelog_filter_msg+'</span> <span class="ico-close timelog_filter_msg_close" rel="tooltip" title="<?php echo __('Reset All');?>"><i class="material-icons">&#xE8BA;</i></span>');
	} %>
<% } %>
<?php /*<div class="time-log-header timelog-table timelog-table-head <% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>detail_timelog_header<% } %>" style="<% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>display:none;<% } %>">
    <div class="fr tl-msg-btn" style="<% if(pagename != 'taskdetails'){ %>display:none;<% } %>">
        <% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
            <div class="logmore-btn fr">
                <a class="anchor" style="padding-left: 0px;margin-left: 5px; width: 120px; padding-right: 0px;" onclick="ajax_timelog_export_csv();"><span class="icon-exp"></span><?php echo __('Export(.csv)');?></a>
            </div>
        <% } %>
        <div class="showreplylog ht_log" style="<% if(SHOWTIMELOG!='No'){ %>display:none;<% } %>">
            <a href="javascript:void(0);" class="hide-tlog" style="text-decoration:none;" onclick="showreplytimelog();">
                <?php echo __('Expand Time Log');?><i class="material-icons">&#xE5C5;</i>
            </a>
        </div>
    </div>
    <div class="cb"></div>
</div> */?>

<div class="sec_title d-flex tog" data-cmnt_id ="tmelg_sec">
	<div class="heading_title">
		<span class="sec_icon timelog_icon"></span>
		<h3 id="tour_taskdetail_timelog">Time Log</h3>
	</div>
	<div class="icon_collapse " ></div>
	
</div>
<div class="toggle_details mt-20">
	<div class="d-flex remark_detail">
		<div class="d-flex width-85-per pr-15">
			<p>
				<strong>Est. Hr:</strong>
				<span id="est_hr_updated">
					<% if(logtimes.details.estimatedHrs != 0.0) { %>
						<%= format_time_hr_min(logtimes.details.estimatedHrs) %>
							<% } else { %>
								<?php echo __('None');?>
								<% } %>
				</span>
			</p>
			<p>
				<strong>Spent. Hr:</strong>
				<span>
					<% if(logtimes.details.totalHrs != 0.0) { %>
						<%= format_time_hr_min(logtimes.details.totalHrs) %>
							<% } else { %>
								<?php echo __('None');?>
								<% } %>
				</span>
			</p>
			<p>
				<strong>Billable. Hr:</strong>
				<span>
					<% if(logtimes.details.billableHrs != 0.0) { %>
						<%= format_time_hr_min(logtimes.details.billableHrs) %>
							<% } else { %>
								<?php echo __('None');?>
								<% } %>
				</span>
			</p>
			<p>
				<strong>Non Billable. Hr:</strong>
				<span>
					<% if(logtimes.details.nonbillableHrs != 0.0) { %>
						<%= format_time_hr_min(logtimes.details.nonbillableHrs) %>
							<% } else { %>
								<?php echo __('None');?>
								<% } %>
				</span>
			</p>
		</div>
		<div class="width-15-per d-flex sec_action_item">
			<div class="d-flex ml-auto">
			
				<% if((typeof is_active != 'undefined' && is_active) || (typeof is_active == 'undefined' && logtimes.is_active != '' && logtimes.is_active == 1)) { %>
			
                <?php if($this->Format->isAllowed('Start Timer',$roleAccess)){ ?>
					<% if(is_inactive_case == 0 && is_active == 1) {%>
				<% if(logtimes.csLgndRep ==3 ) { %>
				<% } else{ %>				
				<% } %>
				<% } %>
			<?php } ?>
            <?php if($this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>
				<% if(is_inactive_case == 0 && is_active == 1) {%>
				<% if(logtimes.csLgndRep ==3 ) { %>
					<?php if($this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){ ?>
						<div class="cursor link-icon ml-15">
							<a class="<%=logtimes.page%> d-inline-block link-icon"id="tog_tm_time_entry rel="tooltip" title="<?php echo __('Manual Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')">
							<i class="material-icons">access_time</i> <!-- Time Entry --> </a>
						</div>
						
					<?php } ?>
					<% } else{ %>
						<div class="cursor link-icon ml-15">
							<a class="<%=logtimes.page%> d-inline-block link-icon" rel="tooltip" title="<?php echo __('Manual Time Entry');?>" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')">
							<i class="material-icons">access_time</i> <!-- Time Entry --> </a>
						</div>
						
					<% } %>
					<% } %>
			<?php } ?>
		
			<% } %>

			</div>
		</div>
	</div>
	<div class="detail_list_table mt-20">
	<% if(logtimes.logs.length > 0){%>
		<table class="width-100-per layout_fixed">
			<thead>
				<tr>
					<th class="width-15-per">Date</th>
					<th class="width-15-per">Name</th>
					<th class="width-15-per">Note</th>
					<th class="width-10-per">Start</th>
					<th class="width-10-per">End</th>
					<th class="width-10-per">Break</th>
					<th class="width-10-per">Billable</th>
					<th class="width-15-per" colspan="2">Logged Hrs</th>
				</tr>
			</thead>
			<tbody>
					<% for(var logKey in logtimes.logs){
						var getdata = logtimes.logs[logKey];
						var puid_for_final = logtimes.project_uniqId;
						if(puid_for_final == 'all' && typeof getdata.Project.uniq_id != 'undefined'){
							puid_for_final = getdata.Project.uniq_id;
						}
						
					%>
						<tr class="timelog-hover-block" <% if(typeof getdata.Project.uniq_id != 'undefined'){ %>data-id="log_prjuid_<%= getdata.LogTime.log_id %>" data-puid="<%= getdata.Project.uniq_id %>" <% } %> data-id-tsht="log_tsht_<%= getdata.LogTime.log_id %>" data-tisht-pid="<%= puid_for_final %>">
							<td class="width-10-per">
								<div><%= moment(getdata[0].start_datetime_v1).format('MMM DD, YYYY')%></div>
							</td>
							<td class="width-10-per" >
								<div id="log_usrNm_<%= getdata.LogTime.log_id %>"><%= getdata[0].user_name %></div>
							</td>
							<% if(pagename != 'taskdetails' && logtimes.project_uniqId == 'all'){ %>
							<td ><div id="log_prjNm_<%= getdata.LogTime.log_id %>"><%= getdata[0].project_name %></div></td>
							<% } %>


								 <% if(typeof logtimes.showTitle != "undefined" && logtimes.showTitle == 'Yes'){ %>
								<td>
									<% if(typeof getdata[0].task_name == 'string' && getdata[0].task_name !=''){ %>
									<% var task_dtl = getdata[0].task_name.split('||'); %>
									<div><a id="titlehtml_<%= task_dtl[1] %>" data-task='<%= task_dtl[1] %>' class="ttl_listing">
									<%= task_dtl[2] %>
									</a></div>
									<% } else { %>
									   <div> <a class="">---</a></div>
									<% } %>
								</td>
								<td>
									<% if(typeof getdata[0].task_name == 'string' && getdata[0].task_name !=''){ %>
									<% var task_dtl = getdata[0].task_name.split('||'); %>
									<div><a id="titlehtml_<%= task_dtl[1] %>" data-task='<%= task_dtl[1] %>' class="ttl_listing">
									<%= shortLength(task_dtl[0],20,9,1) %>
									</a></div>
								<% } else { %>
									<div><a class="">---</a></div>
								<% } %>
								</td>
							<% } %>

							<td class="width-10-per">
								<div><%= formatText(getdata.LogTime.description) %></div>
							</td>
							<td class="width-10-per">
								<div><% if(getdata.LogTime.start_time !='--'){ %>
								<%= format_24hr_to_12hr(getdata.LogTime.start_time) %>
								<% }else{ %>
								<%= getdata.LogTime.start_time %>
								<% } %></div>
							</td>
							<td class="width-10-per">
								<div> <% if(getdata.LogTime.end_time !='--'){ %>
								<%= format_24hr_to_12hr(getdata.LogTime.end_time) %>
								<% }else{ %>
								<%= getdata.LogTime.end_time %>
								<% } %></div>
							</td>
							<td class="width-10-per">
								<div><%= format_time_hr_min(getdata.LogTime.break_time) %></div>
							</td>
							<td class="width-10-per">
								<% if(getdata.LogTime.is_billable == '1'){ %> 
									<div class="billable">
									<i class="material-icons">check</i>
								</div>				
								<% } else { %><div class="nonbillable">
									<i class="material-icons">clear</i>
								</div><% } %>
							</td>
							<!-- <td class="noprint">
								<% if(getdata.LogTime.task_status == '1'){ %>
									<div><a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons">&#xE834;</i></a></div>
								<% } else { %>
									<div><a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons">&#xE5CD;</i></a></div>
								<% } %> >
							</td>  -->
							<!-- <td class="width-10-per">1hrs</td> -->
							<% if(getdata.LogTime.user_id == SES_ID || SES_TYPE == 1 || SES_TYPE == 2){ %>
									<td class="relative  action_tlv" data-logid="<%= getdata.LogTime.log_id %>">
								<% } else { %>
									<td class="relative">
								<% } %>
								<%= format_time_hr_min(getdata.LogTime.total_hours) %>
								<% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
								<% }  %>
							  
							  
							</td>    
							<!-- <td class="width-10-per action_td">
								<div class="d-flex">
									<a href="javascript:void(0)">
										<i class="material-icons">mode</i>
									</a>
									<a href="javascript:void(0)">
										<i class="material-icons delete_icon">delete_outline</i>
									</a>
								</div>
							</td> -->
							
							
									<%  if(getdata.LogTime.user_id == SES_ID || SES_TYPE == 1 || SES_TYPE == 2){ %>
										<td class="width-10-per action_td" data-logid="<%= getdata.LogTime.log_id %>">
									<% } else { %>
										<td>
											<div class="timelog-overlap" style="" rel="tooltip" title="<?php echo __('You are not authorized to modify');?>."></div>
									<% } %>   
									<% if(is_inactive_case == 0 && is_active == 1) {%>     
									<div class="d-flex">     
									<a <% if(pagename != 'taskdetails' && logtimes.project_uniqId == 'all'){ %>data-prj-name="<%= getdata[0].project_name %>"<% } %> class="anchor edit_time_log <?php if(!$this->Format->isAllowed('Edit Timelog Entry',$roleAccess)){ ?> no-pointer<?php }?>" href="javascript:void(0);" data-task-id="<%= getdata.LogTime.task_id%>">
										<i class="material-icons">mode</i>
									</a>
									<a class="anchor delete_time_log  <?php if(!$this->Format->isAllowed('Delete Timelog Entry',$roleAccess)){ ?> no-pointer<?php } ?>" href="javascript:void(0);">
									   <?php if(!$this->Format->isAllowed('Delete Timelog Entry',$roleAccess)){ ?>
										<i class="material-icons">not_interested</i>
									   <?php }else{ ?>
										<i class="material-icons delete_icon">delete_outline</i>
										<?php } ?>
										</a>
									</div>	
									<% } %>						
								</td>
							
									

						</tr>
						<% } %>
							
										<tbody>
		</table>
		<% }else{ %>
			<div class="nodetail_found">
				<figure>
					<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
					 height="120">
				</figure>
				<div class="colr_red mtop15">No Time Logs found</div>
			</div>
			<% } %>
		<?php /*<div class="hr_separetor_line"></div>
		<div class="text-right">
			<div class="show_moreless">Show more</div>
		</div> */?>
	</div>
</div>

