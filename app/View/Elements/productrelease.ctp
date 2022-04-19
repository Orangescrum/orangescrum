<% 	if(activity.length) {
    var lastDate = "";
    var dateRepeat = "";
    var easycaseArr= new Array();
    for(var key in activity) {
        var obj = activity[key];
		var updated = obj.Release.updated;
        var lastDate = obj.Release.lastDate;
		var rldesc = obj.Release.description;
         %>
		<% if (dateRepeat != lastDate) { %>
        <div class="gray-dot">
            <div class="fl activity-date"><%= lastDate %></div>
            <div class="cb"></div>
        </div>
    <% } %>
    <div class="activity-row">
        <span>
		<% if(obj.Release.is_hyperlink == 1){%>
			<% if(rldesc.indexOf("[HOST]") !== -1){%>
				<% rldesc = str_replace("[HOST]",HTTP_ROOT+obj.Release.hyperlink_url,rldesc); %>
			<% } %>
		<% } %>
        <% var rl_til_fst = obj.Release.title.charAt(0); %>
        <?php /*<span class="cmn_profile_holder prof_hold_pos_absl"><%= rl_til_fst %></span> */?> 
        </span>
        <div class="activity-hover-bg totalstatus">
          <span class="cmn_profile_holder"><i class="material-icons">offline_bolt</i></span>
            <?php /*?><small class="fr activity-time"><%= updated %></small><?php */?>
            <strong><%= obj.Release.title %></strong>
            <span><%= rldesc %></span>
        </div>
        <% var image_nm = '';
			if(obj.Release.id == 1){
				image_nm = 'quicklink-update.png';
			}else if(obj.Release.id == 2){
				image_nm = 'Left-menu-image.png';
			}else if(obj.Release.id == 3){
				image_nm = '';
			}else if(obj.Release.id == 5){
				image_nm = 'google-calendar-product-update.png';
			}else if(obj.Release.id == 6){
				image_nm = 'ctst_pop.png';
			}else if(obj.Release.id == 7){
				image_nm = 'reminder_image_2.png';
			}else if(obj.Release.id == 8){
				image_nm = 'resource_allocation_report.png';
			}else if(obj.Release.id == 9){
				image_nm = 'github.png';
			}else if(obj.Release.id == 10){
				image_nm = 'pnote.png';
			}else if(obj.Release.id == 11){
				image_nm = 'subtask.png';
			}else if(obj.Release.id == 12){
				image_nm = 'checklistn.png';
			}else if(obj.Release.id == 13){
				image_nm = 'create_sub_task.png';
			}else if(obj.Release.id == 14){
				image_nm = 'convert_to_subtask.png';
			}else if(obj.Release.id == 15){
				image_nm = 'create-task-ra.png';				
			}else if(obj.Release.id == 16){
				image_nm = 'new-sub-task-view.png';
			}else if(obj.Release.id == 17){
				image_nm = 'mention_img.png';
			}else{ 
				image_nm = 'theme-update.png';
			} %>
        <% if(obj.Release.photo != '' && obj.Release.photo != null){%>
            <div class="release_img">
              <img src="<?php echo HTTP_ROOT;?>img/release/<%= obj.Release.photo %>" alt="">
            </div>
        <% } %>
    </div>
<% dateRepeat = lastDate; %>

<div class="cb"></div>
<% } %>
<% } %>
<input type="hidden" id="totalrlact" value="<%= total %>">
