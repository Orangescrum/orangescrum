<?php
	$t_clr = Configure::read('PROFILE_BG_CLR'); 
	$random_bgclr = $t_clr[array_rand($t_clr,1)];
?>
<%
var total_records = sqlcasedata.length;
var totdata = 0;
var last_tot_rep = parseInt($('#lastTotReplies-lst').val());
sqlcasedata = sqlcasedata.reverse();
var edit_cnt;
if(0){ edit_cnt = 1; }else{ edit_cnt = total_records;}
totdata = total_records+1;
var i=0;
startSlno = (totalReplies < total_records) ? (last_tot_rep - total_records) + 1 : (totalReplies -total_records) + 1;
startSlno =1;
var sortOrder = getCookie('REPLY_SORT_ORDER');
console.log(last_tot_rep);
if(sortOrder == 'ASC') { startSlno = (totalReplies < total_records) ? last_tot_rep : totalReplies; }
if(typeof thrdStOrd == 'undefined' || !thrdStOrd) {
	if($('#thread_sortorder'+csAtId).length) {
		var thrdStOrd = $('#thread_sortorder'+csAtId).val();
	} else {
		var thrdStOrd = 'DESC';
	}
}
for(var repKey in sqlcasedata){
	var getdata = sqlcasedata[repKey];
	totdata--; i++;
	var caseDtId = getdata.Easycase.id;
	var caseDtUniqId = getdata.Easycase.uniq_id;
	var caseDtPid = getdata.Easycase.project_id;
	var caseDtUid = getdata.Easycase.user_id;
	var caseDtMsg = getdata.Easycase.message;
	var wrap_msg = getdata.Easycase.wrap_msg;
	var caseDtFormat = getdata.Easycase.format;
	var taskLegend = getdata.Easycase.legend;
	var userArr = getdata.Easycase.userArr;
	var by_name = userArr.User.name;
	var by_photo = userArr.User.photo;
	var short_name = userArr.User.short_name;
	var photo_exist = userArr.User.photo_exist;
	var photo_existBg = userArr.User.photo_existBg;
	var CSrep_count = getdata.Easycase.CSrep_count;
	if(!photo_exist){	
		by_photo = 'user.png'; 
		var usr_name_fst = by_name.charAt(0);	
	}
	var shRplyEdt = 0;
        if(typeof user_can_change == 'undefined'){
            if(is_active == 1 && ((taskLegend == 1 || taskLegend == 2 || taskLegend == 4) || SES_TYPE == 1 || SES_TYPE == 2 || (caseDtUid == SES_ID))){
                user_can_change = 1;
            }
        }
	if((taskLegend == 1 || taskLegend == 2) && SES_ID == caseDtUid && caseDtMsg) {
            if((thrdStOrd=='ASC' && i==1) || (thrdStOrd=='DESC' && edit_cnt== i)) {
                shRplyEdt = 1;
            }
	} %>
    <% if((wrap_msg.length > 0) || (getdata.Easycase.replyCap.length > 0) || (getdata.Easycase.rply_files.length > 0)){ %>
        <div class="fl user-task-info details_task_block <% if((startSlno)%2 == 0) {%>content2 <% }else{ %> content4 <% } %>" id="rep<%= totdata %>"> 
            <a class="comment-numb"><span class="badge"><%= startSlno%></span></a>
            <div class="fl user-task-pf">
				<% if(!photo_exist){ %>
					<span class="cmn_profile_holder <%= photo_existBg %>"><%= usr_name_fst %></span>
				<% }else{ %>
					<img class="lazy round_profile_img rep_bdr" data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= by_photo %>&sizex=55&sizey=55&quality=100" title="<%= by_name %>" width="55" height="55" />
				<% } %>                
            </div>
            <div class="fl">
                <p><%= formatText(getdata.Easycase.usrName) %>&nbsp;<small class="blue-txt"><% if(getdata.Easycase.sts =='<b class="wip">In Progress</b>'){%> Replied<%}else if(getdata.Easycase.sts =='<b class="wip">Close</b>'){ %>Closed<% }else if(getdata.Easycase.sts =='<b class="wip">Resolve</b>'){%>Resolved<%}else if(getdata.Easycase.replyCap == "Added time log" || getdata.Easycase.replyCap == "Updated time log"){%>Modified<%}else{%>Replied<%}%></small></p>
                <span class="gray-txt"><%= getdata.Easycase.rply_dt %></span>
            </div>
            <div class="cb"></div>
            <div class="details_task_block plane_p_txt mtb">
<!--                <div class="details_task_head">
                    <div class="fr">
                        <% if(is_active){ %>
                            <a href="javascript:void(0);" class="link_repto_task" data-csatid="<%= csAtId %>" rel="tooltip" title="Reply"><div class="reply_to_task fr"><i class="material-icons">&#xE15E;</i></div></a>
                        <% } %>
                    </div>
                </div>-->
                <div id="cnt_<%= startSlno%>"class="details_task_desc wrapword" style="overflow:hidden;">
<!--                        <div id="casereplytxt_id_<%= caseDtId %>">
                            <span id="replytext_content<%= caseDtId %>">
                                <%= wrap_msg %>
							</span>
							<% if(shRplyEdt==1){ %>
								<div rel="tooltip" title="Edit" onclick="editmessage(this,<%= caseDtId %>,<%= caseDtPid %>);" id="editpopup<%= caseDtId %>" class="fr rep_edit"><i class="material-icons icon-edit">&#xE3C9;</i></div>
							<% } %>
							<%= getdata.Easycase.replyCap %>
                        </div>-->
                        <div id="casereplyid_<%= caseDtId %>"></div>
                        <% if(caseDtFormat != 2){
                        var filesArr = getdata.Easycase.rply_files;
                        if(filesArr.length){ 
                            var len = filesArr.length;
                        %>
                        <div class="fl">
                            <div class="glyph attachment attachment_wrap"></div>
                            <span style="font-size:15px;">
                                <span class="attach_cnt"><%= len%> <% if(len > 1){ %> Files <% }else{ %> File<% } %></span>
                            </span>
                        </div>
                        <div class="cb"></div>
                                <% var fc = 0;
                                var imgaes = ""; var caseFileName = "";
                                for(var fkey in filesArr){
                                    var getFiles = filesArr[fkey]; %>
                                <% caseFileName = getFiles.CaseFile.file;
                                    caseFileUName = getFiles.CaseFile.upload_name;
                                    caseFileId = getFiles.CaseFile.id;
                                    downloadurl = getFiles.CaseFile.downloadurl;
                                    var d_name = getFiles.CaseFile.display_name;
                                    if(!d_name){ 
                                        d_name = caseFileName;
                                    }
                                    if(caseFileUName == null){
                                        caseFileUName = caseFileName;
                                    }
                                    if(getFiles.CaseFile.is_exist) {
                                        fc++;
                                        file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file);%>
                                        <div class="fl atachment_det atachment_<%=caseFileId%>" <% if(!downloadurl && (easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png')){ %> <% }else{%> style="display:none;" <%} %>>
                                            <div class="aat_file">
                                                <div class="file_show_dload">
                                                    <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= d_name %>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                                                    <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>  
                                                </div>
																								<div class="attach-close">
																										 <% if(user_can_change == 1){ %>
                                                        <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+caseDtId+'\'' %>,<%='\''+caseDtUniqId+'\'' %>,<%= '\''+CSrep_count+'\'' %>)"><i class="material-icons">&#xE5CD;</i></a>
                                                    <% } %>
																								</div>
                                                <% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                                                    <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                                        <img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;max-height: 120px;" title="<%= d_name %>" alt="Loading image.." />
                                                    <% }else{ %>
                                                        <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                                                    <% } %>
                                                <% } else { %>
                                                    <div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
                                                <% } %>
                                                <div class="file_cnt ellipsis-view"><%= d_name %></div>
                                            </div>
                                        </div>
                                        <div class="fl atachment_det parent_other_holder atachment_<%=caseFileId%>" <% if(!downloadurl && (easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png')){ %> style="display:none;" <% } %>>
                                            <div class="aat_file">
                                                <div class="file_show_dload">
                                                    <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'pdf'){ %>
                                                        <a href="javascript:void(0);" onclick="viewPdfFile(<%= getFiles.CaseFile.id %>);" target="_blank" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE8FF;</i></a>
                                                    <% } %>
                                                    <% if(downloadurl) { %>
                                                    <a href="<%= downloadurl %>" alt="<%= caseFileName %>" target="_blank" title="<?php echo __('Preview');?>"><i class="material-icons">&#xE8FF;</i></a>
                                                    <% } else {%>
                                                    <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<%= d_name %>"><i class="material-icons">&#xE2C4;</i></a>
                                                    <% } %>
                                                </div>
												<div class="attach-close">
														<% if(user_can_change == 1){ %>
                                                        <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+caseDtId+'\'' %>,<%='\''+caseDtUniqId+'\'' %>,<%= '\''+CSrep_count+'\'' %>)"><i class="material-icons">&#xE5CD;</i></a>
                                                    <% } %>
																								</div>
                                                <% if(downloadurl) { %>
                                                    <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                <% }else{ %>
                                                    <% if(getFiles.CaseFile.is_ImgFileExt){ %>
                                                    <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                                                    <%  } else{ %>
                                                    <img src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                    <% } %>
                                                <% } %>
                                                
                                                <div class="file_cnt ellipsis-view"><%= d_name %></div>
                                            </div>
                                        </div>
                                    <% if(fc%3==0) { %><div class="cb"></div><% } %>
                                <% } %>
                            <% } %>
                            <div class="cb"></div>
                        <% } %>
                    <% } %>
                </div>
            </div>
        </div>
    <% } %>
    <div class="cb"></div>
    <% if(sortOrder == 'ASC') { startSlno--; } else { startSlno++; } %>
<% } %>
<input type="hidden" value="<%= total_records %>" id="totdata<%= csAtId %>"/> 