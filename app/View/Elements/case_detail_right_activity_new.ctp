<% 
var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
if(typeof threadDetails != 'undefined') { 
	var getdata = threadDetails.curCaseDtls;
	var userArr = getdata.User;
	var by_name = userArr.name;
	var by_photo = userArr.photo;
	var photo_exist = userArr.photo_exist;
	var photo_existBg = userArr.photo_existBg;
	var filesArr = getdata.Easycase.rply_files;
	var pf_bg = userArr.photo_existBg;
	if(getdata.Easycase.message == '' && filesArr.length == 0){
		%>	

	<div class="mtop20 actv_count">
		<div class="d-flex align-item-center">
			<div class="username">
				<div class="user-task-pf">
				<% if(photo_exist && photo_exist!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100" class="" title="<%= by_name %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = by_name.charAt(0); %>
								  <span class="cmn_profile_holder <%= pf_bg %>" title="<%= by_name %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
					<!-- <img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<%= by_photo %>"
					 width="" height=""> -->
				</div>
				<%= formatText(by_name) %>
			</div>&nbsp;
			<div>
				<strong>
					<%= getdata.Easycase.replyCap %>
				</strong>

				<span>
					<%= getdata.Easycase.rply_dt %>
				</span>
			</div>
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
	var pf_bg = userArr.User.prflBg;
	if((getdata.Easycase.message == null || getdata.Easycase.message == '') && filesArr.length == 0){
	%>


			<div class="mtop20 actv_count">
				<div class="d-flex align-item-center">
					<div class="username">
						<div class="user-task-pf">
						<% if(photo_exist && photo_exist!=0) { %>
								  <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=30&sizey=30&quality=100" class="" title="<%= by_name %>" width="30" height="30" />
								  <% } else { %>
								  <% var usr_name_fst = by_name.charAt(0); %>
								  <span class="cmn_profile_holder <%= pf_bg %>" title="<%= by_name %>">
								  <%= usr_name_fst %>
								  </span>
								  <% } %>
							<!-- <img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<%= by_photo %>"
							 width="" height=""> -->
						</div>
						<%= formatText(by_name) %>
					</div>&nbsp;
					<div>
						<strong>
							<%= getdata.Easycase.replyCap %>
						</strong>
						<span>
							<%= getdata.Easycase.rply_dt %>
						</span>
					</div>
				</div>
			</div>

			<% } %>
				<% }  if(activitycountall > 10){%>
					<div class="mt-15">
						<button id="show_more_less_bun_act1" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="showMoreActivityTsk('<%= csUniqId %>');"> <?php echo __('Show more'); ?></button>
						<button id="show_more_less_bun_act2" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" data-uid="<%= csUniqId %>" style="display:none;"onclick="showLessActivity(this);">Show less</button>
						
					</div>
					
				<% } }else{ %>
					<!-- <div class="nodetail_found">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
								height="120">
						</figure>
						<div class="colr_red mtop15">No activity found</div>
					</div>
					<div class="cb"></div> -->
					<% } %>
						<!-- <div class="d-flex align-item-center activity_direction">
							<div>Unassigned</div>
							<div>
								<i class="material-icons">east</i>
							</div>
							<div>John Doe</div>
						</div> -->