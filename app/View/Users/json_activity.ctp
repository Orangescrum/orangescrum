<% var istype = new Array();
    istype[1] = '<font color="#763532"><b>New</b></font>';
    istype[2] = '<font color="#0E93CA"><b>Replied</b></font>';
    istype[3] = '<font color="#77AB13"><b>Closed</b></font>';
    istype[4] = '<font color="#0E93CA"><b>Replied</b></font>';
    istype[5] = '<font color="#EF6807"><b>Resolved</b></font>';
    istype[6] = '<font color="#000"><b>Update</b></font>';
    istype[7] = '<font color="#000"><b>Comment</b></font>';
    istype[9] = '<font color="#EF6807"><b>Edited</b></font>';
    if(activity.length) { 
	var lastDate = "";
	var dateRepeat = "";
	var easycaseArr= new Array();
	for(var key in activity) {
	    var obj = activity[key];
	    for(var key1 in obj) {
	
	    var updated = obj[key1].Easycase.updated;
	    var lastDate = obj[key1].Easycase.lastDate;
	    
	    var easycase_caseno_projId =  obj[key1].Easycase.case_no+"_"+ obj[key1].Easycase.project_id;

	    if (dateRepeat != lastDate) { 
		easycaseArr= new Array();
	    }
	    if($.inArray(easycase_caseno_projId,easycaseArr) == -1){
		var legend = obj[key1].Easycase.legend;
		if(obj[key1].Easycase.istype == 1){
		    var legend = 1;
		}else{
		    var legend = obj[key1].Easycase.legend;
		}
		easycaseArr.push(easycase_caseno_projId);
	    }else{
		var legend = 0;
	    } %>
		
	<% if (dateRepeat != lastDate) { 
	    caseid_tot = obj[key1].Easycase.id; %>
		<div class="gray-dot">
			<div class="fl activity-date"><%= lastDate %></div>
			<div class="fr cwrc" id="allStatus<%= caseid_tot %>"></div>
			<div class="cb"></div>
		</div>
	<% } %>
		
		
	<% if (obj[key1].Easycase.msg) { %>
	<div class="activity-row">
		<span>		
		<% if(obj[key1].User.photo){ %>
		<span class="cmn_profile_holder prof_hold_pos_absl">
			<img class="round_profile_img ppl_invol lazy" data-original="<%= HTTP_ROOT %>users/image_thumb/?type=photos&file=<%= obj[key1].User.photo %>&sizex=30&sizey=30&quality=100" width="30" height="30" title="<%= obj[key1].User.name %> <%= obj[key1].User.short_name %>" rel="tooltip" alt="Loading"/>
		</span>
		<% }else{ %>
		<% var usr_name_fst = obj[key1].User.name.charAt(0); %>
		<span class="cmn_profile_holder prof_hold_pos_absl <%= obj[key1].User.profile_bg_clr %>"><%= usr_name_fst %></span>
		<% } %>
		</span>
		<div class="activity-hover-bg totalstatus allStatus<%= caseid_tot %>" rel="<%= legend %>">
			<small class="fr activity-time"><%= updated %></small>
			<%= obj[key1].Easycase.msg %>
			<span><%= obj[key1].User.name %></span>
			<div style="display: none;" class="prj_dvs">
				<% if(obj[key1].Project.name){ %>
				<a class="fnt999 ttc" href="<%= HTTP_ROOT %>dashboard/?project=<%= obj[key1].Project.uniq_id %>"><%= obj[key1].Project.name %></a>
			<% } %>
			</div>
		</div>
	</div>
	<% } %>
<% dateRepeat = lastDate; %>

<% } %>
<div class="cb"></div>
<% } %>
<% } else {
	if(total && total == 0){ %>
	<?php echo $this->element('no_data', array('nodata_name' => 'activity')); ?>
<%  }
} %>

<input type="hidden" id="totalact" value="<%= total %>">
