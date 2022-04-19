<table class="ruDataTable table m-list-tbl">
    <thead>
			<tr>
        <th class="text-left tophead wdth15"><strong><?php echo __('Week Number');?></strong></th>
				<% for(var k in weekArr){
						var weeNum = weekArr[k];   
				%>
					<th class="tophead text-center" colspan="3">
						<% if(cur_view_type == 3){ %>
							<strong><%= weeNum['display_date']%></strong>
						<% }else{ %>
						<strong><%= "W"+weeNum['wnum']%></strong>
						<%= weeNum['sdate'] %> - <%= weeNum['edate'] %>
						<% } %>
					</th>
					<% } %>
				<th class="text-center tophead">&nbsp;</th>
			</tr>
    </thead>
		<tbody>
		<tr class="subhead_tr">
			<td class="text-left"><?php echo __('Resources');?></td>
			<%	for(var k in weekArr){ %>
				<td class="text-center"><?php echo __('Estimated'); ?></td>
				<td class="text-center" class="text-center"><?php echo __('Actual'); ?></td>
				<td class="text-center"><?php echo __('%'); ?></td>
			<% } %>
			<td class="text-center"><?php echo __('Total'); ?></td>
		</tr>
		
    <% 
    var count = 0;
    var clas = "";
    var space = 0;
    var spacepercent = 0;
    var totCase = 0;
    var totHours = '0.0';
    if(ruData){ 
			var totalEstdhr = 0;
			var totalSpnthr = 0;
			for(var k in ruData){
				var ruArr = ruData[k]; 
				var tot_estd = 0;
				var tot_act = 0;
		%>
			<tr class="row_tr prjct_lst_tr">
				<td class="text-left">
					<%= ruArr['user']['name']+" "+ruArr['user']['last_name'] %>
					<?php /*<div class="progress" style="max-width: 90%">
						<div class="progress-bar"
								style="width: 20%; background-color: green">
						</div>
						<div class="progress-bar progress-bar-stripped"
								style="width: 50%; background-color: #66b400">
						</div>
						<div class="progress-bar progress-bar-stripped"
								style="width: 70%; background-color: rgb(141, 3, 72)">
						</div>
					</div> */ ?>
				</td>
					<% for(var k1 in weekArr){
							if(ruArr['weeks'] && typeof ruArr['weeks'][weekArr[k1]['wnum']] != 'undefined'){
							var wkArr = ruArr['weeks'][weekArr[k1]['wnum']]; 
							tot_estd += parseFloat(wkArr['estd']);
							tot_act += parseFloat(wkArr['act']);							
							
							var estd = format_time_hr_min(wkArr['estd']);
							if(estd == '---'){ estd = 0; }
							var act = format_time_hr_min(wkArr['act']);
							if(act == '---'){ act = 0; }
					%>
						<td class="text-center"><%= estd %></td>
						<td class="text-center"><%= act %></td>
						<td class="text-center <%= wkArr['color']%>"><%= wkArr['per'] %></td>
					<% }else{ %>
						<td class="text-center">0</td>
						<td class="text-center">0</td>
						<td class="text-center">0</td>
					<% } %>
				<% } %>
				<td class="text-center">
				<%
					totalEstdhr += parseFloat(tot_estd);
					totalSpnthr += parseFloat(tot_act);
				%>
				<%= format_time_hr_min(tot_act) %>/<%= format_time_hr_min(tot_estd) %>
				</td>
			</tr>
			<% }  %>
			
			<tr class="fnt-bld">
			<td><?php echo __('Total');?></td>
			<% for(var k2 in totallArr){ var cntr=0; %>
				<% for(var k3 in totallArr[k2]){ cntr++; %>
					<td class="text-center">
						<% if(cntr != 3){ %>
							<%= format_time_hr_min(totallArr[k2][k3]) %>
						<% }else{%>
							<%= totallArr[k2][k3].toFixed(2) %>
						<% } %>
					</td>
				<% } %>			
			<% } %>			
				<td><%= format_time_hr_min(totalSpnthr) %>/<%= format_time_hr_min(totalEstdhr) %></td>
			</tr>
   <% } %>
		</tbody>
</table>