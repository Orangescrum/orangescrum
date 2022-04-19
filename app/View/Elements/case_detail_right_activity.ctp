<% 
var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
if(typeof threadDetails != 'undefined') { 
	var getdata = threadDetails.curCaseDtls;
	var userArr = getdata.Easycase.userArr;
	var by_name = getdata[0].user_name;
	var by_photo = getdata.User.photo;
	var photo_exist = getdata.User.photo_exist;
	var photo_existBg = getdata.User.photo_existBg;
	var filesArr = getdata.Easycase.rply_files;
	if(getdata.Easycase.message == '' && filesArr.length == 0){
		%>
	<div class="activity_blk">
		<!--div class="time_bg">day</div-->
		<div class="activity_info">
			<span class="pfl_img">
				<% if(!photo_exist){ %>
					<span class="cmn_profile_holder <%= photo_existBg %>"><%= by_name.charAt(0) %></span>
				<% }else{ %>
					<img class="lazy round_profile_img rep_bdr" data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=55&sizey=55&quality=100" title="<%= by_name %>" width="55" height="55" />
				<% } %>
			</span>
			<!-- <p><strong><%= formatText(by_name) %> 
			<% if(getdata.Easycase.sts =='<b class="wip"><?php echo __('In Progress');?></b>'){%> <?php echo __('Replied');?><%}else if(getdata.Easycase.sts =='<b class="wip"><?php echo __('Close');?></b>'){ %><?php echo __('Closed');?><% }else if(getdata.Easycase.sts =='<b class="wip"><?php echo __('Resolve');?></b>'){%><?php echo __('Resolved');?><%}else if(getdata.Easycase.replyCap == "Added time log" || getdata.Easycase.replyCap == "Updated time log"){%><?php echo __('Modified');?><%}else{%><?php echo __('Replied');?><%}%>
			</strong><?php echo __('on');?> <span class="gray-txt"><%= getdata.Easycase.rply_dt %></span></p> -->
			<p><strong><%= formatText(by_name) %></strong><%= getdata.Easycase.replyCap %></p>
			<small><?php echo __('on');?> <span><%= getdata.Easycase.rply_dt %></span></small>
		</div>
	</div>
	<% 
	}
}else if(typeof sqlcaseactivity != 'undefined' && sqlcaseactivity.length > 0) { 
%>
<% for(var repKey in sqlcaseactivity){
	var getdata = sqlcaseactivity[repKey];
	var userArr = getdata.Easycase.userArr;
	var by_name = userArr.User.name;
	var by_photo = userArr.User.photo;
	var photo_exist = userArr.User.photo_exist;
	var photo_existBg = userArr.User.photo_existBg;
	var filesArr = getdata.Easycase.rply_files;
	if((getdata.Easycase.message == null || getdata.Easycase.message == '') && filesArr.length == 0){
	%>
	<div class="activity_blk">
		<!--div class="time_bg">day</div-->
		<div class="activity_info">
			<span class="pfl_img">
				<% if(!photo_exist){ %>
					<span class="cmn_profile_holder <%= photo_existBg %>"><%= by_name.charAt(0) %></span>
				<% }else{ %>
					<img class="lazy round_profile_img rep_bdr" data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=55&sizey=55&quality=100" title="<%= by_name %>" width="55" height="55" />
				<% } %>
			</span>
			<!-- <p><strong><%= formatText(getdata.Easycase.usrName) %> 
			<% if(getdata.Easycase.sts =='<b class="wip"><?php echo __('In Progress');?></b>'){%> <?php echo __('Replied');?><%}else if(getdata.Easycase.sts =='<b class="wip"><?php echo __('Close');?></b>'){ %><?php echo __('Closed');?><% }else if(getdata.Easycase.sts =='<b class="wip"><?php echo __('Resolve');?></b>'){%><?php echo __('Resolved');?><%}else if(getdata.Easycase.replyCap == "Added time log" || getdata.Easycase.replyCap == "Updated time log"){%><?php echo __('Modified');?><%}else{%><?php echo __('Replied');?><%}%>
			</strong>on <span class="gray-txt"><%= getdata.Easycase.rply_dt %></span></p> -->
			<p><strong><%= formatText(getdata.Easycase.usrName) %></strong><%= getdata.Easycase.replyCap %></p>
			<small><?php echo __('on');?> <span><%= getdata.Easycase.rply_dt %></span></small>			
		</div>
	</div>	
<% } %>
<% } }else{ %>
<p id="noactivity" class="nofiletxt"><?php echo __('No activity found');?></p>
<% } %>