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
<p>This feature is only available to the paid users! <a href="<?php echo HTTP_ROOT.'pricing' ?>">Please Upgrade</a></p>
</div>
<?php } ?>
<% } %>
<% if(pagename != 'taskdetails' && timelog_filter_msg != '' && timelog_filter_msg != null) {%>
    <%
	if(timelog_filter_msg == '' || timelog_filter_msg == null){
		$('.timelog_filter_msg').hide();
	}else{
		$('.timelog_filter_msg').show();
		$('.timelog_filter_msg').html('<span class="tg_msg_pos">'+timelog_filter_msg+'</span> <span class="ico-close timelog_filter_msg_close" rel="tooltip" title="Reset All"><i class="material-icons">&#xE8BA;</i></span>');
	} %>
<% } %>
<div class="time-log-header timelog-table timelog-table-head <% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>detail_timelog_header<% } %>" style="<% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>display:none;<% } %>">
    <div class="fr tl-msg-btn" style="<% if(pagename != 'taskdetails'){ %>display:none;<% } %>">
        <% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
            <div class="logmore-btn fr">
                <a class="anchor" style="padding-left: 0px;margin-left: 5px; width: 120px; padding-right: 0px;" onclick="ajax_timelog_export_csv();"><span class="icon-exp"></span>Export(.csv)</a>
            </div>
        <% } %>
        <div class="showreplylog ht_log" style="<% if(SHOWTIMELOG!='No'){ %>display:none;<% } %>">
            <a href="javascript:void(0);" class="hide-tlog" style="text-decoration:none;" onclick="showreplytimelog();">
                Expand Time Log<i class="material-icons">&#xE5C5;</i>
            </a>
        </div>
    </div>
    <div class="cb"></div>
</div>

<div class="task_listing timelog_lview  hidetablelog timelog-detail-tbl" style="<% if(SHOWTIMELOG=='No'){ %>display:none;<% } %>">
		<% if(pagename == 'taskdetails'){ %>
		<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
		<div class="custom-overlay"></div>
		<?php } ?>
		<% } %>
		<div class="tlog_top_cnt">
            <div class="<% if(pagename != 'taskdetails'){ %>col-lg-10 <% }else{ %>col-lg-8<% } %> padnon">
			<% if(pagename == 'taskdetails'){ %>
			<h6>Time Log:</h6>
			<% } %>
			<h6>Logged: <span><%= format_time_hr_min(logtimes.details.totalHrs) %></span></h6>
			<h6>Billable: <span><%= format_time_hr_min(logtimes.details.billableHrs) %></span></h6>
			<h6>Non-Billable: <span><%= format_time_hr_min(logtimes.details.nonbillableHrs) %></span></h6>
			<h6>Estimated: <span><%= format_time_hr_min(logtimes.details.estimatedHrs) %></span></h6>
            </div>
            <% if(pagename != 'taskdetails'){ %>
			<div class="col-lg-2 padnon btn_tlog_top">
				<a href="javascript:void(0)" class="btn btn-sm btn_cmn_efect fr" onclick="timelog_export_popup();" rel="tooltip" title="Export To CSV">
					<i class="material-icons">&#xE8D5;</i>
				</a>
			</div>
			<% } %>
			<div class="cb"></div>
		</div>
		<div class="m-cmn-flow">
        <table class="table table-striped table-hover m-list-tbl">
            <tr><% var caseCount= logtimes.logs.length;%>
                <th> 
				<% if(pagename != 'taskdetails'){%>
                    <a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'date\', ' + caseCount + ', this' %> );">Date                       
                        <span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "date") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                </a>
               <% } else{ %>Date <% } %>
                </th>
                <th>
                   <% if(pagename != 'taskdetails'){%>
                    <a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'name\', ' + caseCount + ', this' %> );" >Name                       
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
                 <% } else{ %>Name <% } %>      
                  </th>
                  <% if(pagename != 'taskdetails' && logtimes.project_uniqId == 'all'){ %>
                  <th>
                      <a href="javascript:void(0);">Project Name</a>
                  </th>
                  <% } %>
                <% if(typeof logtimes.showTitle != "undefined" && logtimes.showTitle == 'Yes'){ %>
                <th style="min-width:60px;">
                  <% if(pagename != 'taskdetails'){%>
                    <a href="javascript:void(0)"  onclick="ajaxSorting( <%= '\'caseno\', ' + caseCount + ', this' %> );">Task#                        
                        <span class="sorting_arw">
                            <% if(typeof orderBy != 'undefined' && orderBy == "caseno") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                <% } %>
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                    </a>                  
                   <% } else{ %>Task# <% } %>
                </th>
                <th>
                   <% if(pagename != 'taskdetails'){%>
                    <a href="javascript:void(0)"  onclick="ajaxSorting( <%= '\'case_title\', ' + caseCount + ', this' %> );">Task                       
                        <span class="sorting_arw">
                            <% if(typeof orderBy != 'undefined' && orderBy == "case_title") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
					</a>   
					<% } else{ %>Task <% } %>
                </th>
                <% } %>
             <th style="min-width:105px">
					<% if(pagename != 'taskdetails'){%>
                     <a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'description\', ' + caseCount + ', this' %> );">Description
                        <span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "description") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                     </a> 
					<% }else{ %>Description<% } %>					 
               </th>
                <th>
					<% if(pagename != 'taskdetails'){%>
                     <a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'start\', ' + caseCount + ', this' %> );">Start
                        <span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "start") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
					</a>  
					<% }else{ %>Start<% } %>
                  
                </th>
                <th>  
				<% if(pagename != 'taskdetails'){%>				
                    <a href="javascript:void(0)" onclick="ajaxSorting( <%= '\'end\', ' + caseCount + ', this' %> );" >End
                        <span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "end") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>
                </a> 
				<% }else{ %>End<% } %>
                </th>
                <th>Break</th>
                <th class="text-center">Billable</th>
                <th class="noprint text-center">Billed</th>
                <th>
				<% if(pagename != 'taskdetails'){%>
                     <a href="javascript:void(0)"  onclick="ajaxSorting( <%= '\'hours\', ' + caseCount + ', this' %> );">Hours
                        <span class="sorting_arw"><% if(typeof orderBy != 'undefined' && orderBy == "hours") { %>
                            <% if(orderByType == "ASC"){ %>
                            <i class="material-icons tsk_asc">&#xE5CE;</i>
                            <% }else{ %>
                            <i class="material-icons tsk_desc">&#xE5CF;</i>
                            <% } %>								
                            <% }else{ %>
                            <i class="material-icons">&#xE164;</i>
                            <% } %></span>                      
                </a> 
				<% }else{ %>Hours<% } %>
                    
                </th>
                <%  if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
                <th class="text-center">Action</th>
                <% } %>
            </tr>
            <% if(logtimes.logs.length > 0){%>
                <% for(var logKey in logtimes.logs){
                    var getdata = logtimes.logs[logKey];
                    console.log(getdata[0].start_datetime_v1);
                %>
                    <tr class="timelog-hover-block" <% if(typeof getdata.Project.uniq_id != 'undefined'){ %>data-id="log_prjuid_<%= getdata.LogTime.log_id %>" data-puid="<%= getdata.Project.uniq_id %>" <% } %>>
                        <td><%= formatDate('MMM DD, YYYY',getdata[0].start_datetime_v1) %></td>
                        <td id="log_usrNm_<%= getdata.LogTime.log_id %>"><%= getdata[0].user_name %></td>
                        <% if(pagename != 'taskdetails' && logtimes.project_uniqId == 'all'){ %>
                        <td id="log_prjNm_<%= getdata.LogTime.log_id %>>"><%= getdata[0].project_name %></td>
                        <% } %>
                        <% if(typeof logtimes.showTitle != "undefined" && logtimes.showTitle == 'Yes'){ %>
                            <td>
                                <% if(typeof getdata[0].task_name == 'string' && getdata[0].task_name !=''){ %>
                                <% var task_dtl = getdata[0].task_name.split('||'); %>
                                <a id="titlehtml_<%= task_dtl[1] %>" data-task='<%= task_dtl[1] %>' class="ttl_listing">
                                <%= task_dtl[2] %>
                                </a>
                                <% } else { %>
                                    <a class="">---</a>
                                <% } %>
                            </td>
                            <td>
                                <% if(typeof getdata[0].task_name == 'string' && getdata[0].task_name !=''){ %>
                                <% var task_dtl = getdata[0].task_name.split('||'); %>
                                <a id="titlehtml_<%= task_dtl[1] %>" data-task='<%= task_dtl[1] %>' class="ttl_listing">
                                <%= shortLength(task_dtl[0],20,9,1) %>
                                </a>
                            <% } else { %>
                                <a class="">---</a>
                            <% } %>
                            </td>
                        <% } %>
                        <td><div class="max_width_tltsk_title ellipsis-view"> <%= formatText(nl2br(getdata.LogTime.description)) %></div></td>
                        
                        <td><%= format_24hr_to_12hr(getdata.LogTime.start_time) %></td>
                        <td><%= format_24hr_to_12hr(getdata.LogTime.end_time) %></td>
                        <td><span class="fl"><%= format_time_hr_min(getdata.LogTime.break_time) %></span></td>
						
                        <td class="text-center bilble_icn timelog">
							<% if(getdata.LogTime.is_billable == '1'){ %> 
								<a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons tick_mark">&#xE834;</i></a>					
							<% } else { %><a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons cross_mark">&#xE5CD;</i></a><% } %>
						</td>						
                        <td class="noprint">
							<% if(getdata.LogTime.task_status == '1'){ %>
								<a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons">&#xE834;</i></a>
							<% } else { %>
								<a class="tlg-status-link" href="javascript:void(0);"><i class="material-icons">&#xE5CD;</i></a>
							<% } %> >
						</td> 
						
                        <% if(getdata.LogTime.user_id == SES_ID || SES_TYPE == 1 || SES_TYPE == 2){ %>
								<td class="relative  action_tlv" data-logid="<%= getdata.LogTime.log_id %>">
							<% } else { %>
								<td class="relative">
							<% } %>
                            <%= format_time_hr_min(getdata.LogTime.total_hours) %>
                            <% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
                            <% }  %>
                        </td>
                        <% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
                                <%  if(getdata.LogTime.user_id == SES_ID || SES_TYPE == 1 || SES_TYPE == 2){ %>
                                    <td class="text-center action_tlv" data-logid="<%= getdata.LogTime.log_id %>">
                                <% } else { %>
                                    <td>
                                        <div class="timelog-overlap" style="" rel="tooltip" title="You are not authorized to modify."></div>
                                <% } %>                                
                                    <a <% if(pagename != 'taskdetails' && logtimes.project_uniqId == 'all'){ %>data-prj-name="<%= getdata[0].project_name %>"<% } %> class="anchor edit_time_log" href="javascript:void(0);" data-task-id="<%= getdata.LogTime.task_id%>">
									<i class="material-icons">&#xE254;</i>
								</a>
								<a class="anchor delete_time_log" href="javascript:void(0);">
									<i class="material-icons">&#xE872;</i>
								</a>								
                            </td>
                        <% } %>
                    </tr>
                <% } %>
            <% }else{ %>
            <tr>
                    <td colspan="10">No records......</td>
            </tr>
			<% $("#TimeLog_paginate").hide(); %>
            <% } %>
        </table>
    </div>
    </div>
    <% if(typeof logtimes.page != "undefined" && logtimes.page == 'timelog'){ %>
    <% } else{ %>
        <div class="time-log-header tlog_top_cnt timelog-table-head tl-msg-header" style="<% if(SHOWTIMELOG=='No'){ %>display:none;<% } %>">
            <div class="col-lg-10 padnon">
			<h6>Time Log:</h6>
			<h6>Logged: <span><%= format_time_hr_min(logtimes.details.totalHrs) %></span></h6>
            <h6>Billable: <span><%= format_time_hr_min(logtimes.details.billableHrs) %></span></h6>
            <h6>Non-Billable: <span><%= format_time_hr_min(logtimes.details.nonbillableHrs) %></span></h6>
			<h6>Estimated: <span><%= format_time_hr_min(logtimes.details.estimatedHrs) %></span></h6>
            </div>
            <div class="col-lg-2 padnon">
            <a class="fr hide-tlog" href="javascript:void(0);" onclick="hidereplytimelog();">Hide Time Log<i class="material-icons">&#xE5C7;</i></a>
            </div>
            <div class="cb"></div>
        </div>
    <% } %>
    <% if(typeof logtimes.caseCount != 'undefined'){ %>
        <% if(logtimes.caseCount && logtimes.caseCount!=0) {
                var pageVars = {pgShLbl:logtimes.pgShLbl,csPage:logtimes.csPage,page_limit:logtimes.page_limit,caseCount:logtimes.caseCount};
        %>
            <div style="border-bottom:1px solid #ccc;">
                <% $("#TimeLog_paginate").html(tmpl("paginate_tmpl", pageVars)).show(); %>
                <div class="cb"></div>
            </div>
        <% } %>
    <% } %>
</div>
<% if(pagename != 'taskdetails'){ %>
<div class="tlog-ru-report">
	<a class="blue-link-txt" onclick="trackEventWithIntercom(<%= '\'resource utilization\'' %>,<%= '\'\'' %>);" href="<?php echo HTTP_ROOT.'resource-utilization';?>">Resource Utilization Report</a>
</div>
<% } %>
<%
$('.tsk-typ-txt-tg').show();
%>
