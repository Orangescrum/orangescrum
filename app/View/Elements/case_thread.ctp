<% 
var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
for(var k in threadDetails){
    var getdata = threadDetails[k];
    var caseDtId = getdata.Easycase.id;
    var caseDtUniqId = getdata.Easycase.uniq_id;
	var caseDtPid = getdata.Easycase.project_id;
	var caseDtUid = getdata.Easycase.user_id;
	var caseDtMsg = getdata.Easycase.message;
	var wrap_msg = getdata.Easycase.wrap_msg;
	var caseDtFormat = getdata.Easycase.format;
	var taskLegend = getdata.Easycase.legend;
    var photo_exist = getdata.User.photo;
	var filesArr = getdata.Easycase.rply_files;
	if(getdata.Easycase.message != '' || filesArr.length > 0){
    %>
    <div class="comments_item user-task-info details_task_block" id="rep"> 
		<div class="user-task-pf commenter-img creater_replyer_img">
       <?php /* <a class="comment-numb"><span class="badge"><%= getdata.thread_count %></span></a> */?>
            <% if(!photo_exist){ %>
                <span class="cmn_profile_holder <%= getdata.User.photo_existBg %>"><%= getdata.Easycase.user_name.charAt(0) %></span>
            <% }else{ %>
                <img class="lazy round_profile_img rep_bdr" data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= getdata.User.photo %>&sizex=55&sizey=55&quality=100" title="<%= getdata.Easycase.user_name %>" width="55" height="55" />
            <% } %>                
        </div>
		<div id="tour_detl_comts" class="commentor_name create_reply_comment">
        <div class="right_name">
                <div class="width-100-per d-flex pr-10">
                <p class="width-60-per"><strong <% if(!photo_exist){ %>style="color:<%= users_colrs[getdata.User.photo_existBg]%>" <% } %>><%= formatText(getdata.Easycase.user_name) %></strong> </p>
                <p class="replay_time ml-auto"><span class="font-size-12"><%= getdata.Easycase.rply_dt %></span></p>
        </div>
                <?php /* <p>&nbsp;<small class="blue-txt"><% if(taskLegend =='2' || taskLegend =='4'){%> <?php echo __('Replied');?><%}else if(taskLegend =='3'){ %><?php echo __('Closed');?><% }else if(taskLegend =='5'){%><?php echo __('Resolved');?><%}else{%><?php echo __('Replied');?><%}%></small></p> */?>
                
            </div>
            <div class="details_task_block comment_data">
             <?php /*<div class="details_task_head">
                <div class="fr">
                    <a href="javascript:void(0);" class="link_repto_task" data-csatid="<%= getdata.caseId %>" rel="tooltip" title="<?php echo __('Reply');?>"><div class="reply_to_task fr"><i class="material-icons">&#xE15E;</i></div></a>
                </div>
            </div> */?>
            <div id="cnt_<%= getdata.thread_count %>"class="details_task_desc wrapword" style="overflow:hidden;">
                    <div class="pr pr-30" id="casereplytxt_id_<%= caseDtId %>">
                        <span class="d-block pr-30" id="replytext_content<%= caseDtId %>">
                            <%= wrap_msg %>
                        </span>
                        <% if(caseDtMsg!=''){ %>
                            <div rel="tooltip" title="<?php echo __('Edit');?>" onclick="editmessage(this,<%= caseDtId %>,<%= caseDtPid %>);" id="editpopup<%= caseDtId %>" class="rep_edit link-icon"><i class="material-icons icon-edit">&#xE3C9;</i></div>
                        <% } %>
                        <%= getdata.Easycase.replyCap %>
                    </div>
                    <div id="casereplyid_<%= caseDtId %>" class="edit_reply_editor_tbl"></div>
                    <% if(caseDtFormat != 2){
                    var filesArr = getdata.Easycase.rply_files;
                    if(filesArr.length){ 
                        var len = filesArr.length;
                    %>
                    <div class="fl attachment_wrap">
                        <div class="glyph attachment"></div>
                        <span style="font-size:15px;">
                            <span class="attach_cnt"><%= len%> <% if(len > 1){ %> <?php echo __('Files');?> <% }else{ %> <?php echo __('File');?><% } %></span>
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
                                    <?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>
										<div class="fr atachment_det atachment_<%=caseFileId%>" <% if(!downloadurl && (easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png')){ %> <% }else{%> style="display:none;" <%} %>>
                                        <div class="aat_file">
                                            <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>
                                            <div class="file_show_dload">
                                                <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<?php echo __('Preview Images');?>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[<%=getdata.caseId%>]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>  
                                            </div>
                                        <?php } ?>
                                        <?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
                                                                                            <div class="attach-close">
                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+caseDtId+'\'' %>,<%='\''+caseDtUniqId+'\'' %>,<%= '\''+getdata.Easycase.case_no+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
                                                                                            </div>
                                                                                        <?php } ?>
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
                                             <div class="file_cnt_info">
                                                    <span class="file-date fl"><?php echo __('Now');?></span>
                                                    <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                    <div class="cb"></div>
                                                </div>
                                        </div>
                                    </div>
										<div class="fr atachment_det parent_other_holder atachment_<%=caseFileId%>" <% if(!downloadurl && (easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png')){ %> style="display:none;" <% } %>>
                                        <div class="aat_file">
                                            <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>
                                            <div class="file_show_dload">
											<% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'pdf'){ %>
													<a href="javascript:void(0);" onclick="viewPdfFile(<%= getFiles.CaseFile.id %>);" target="_blank" alt="<%= caseFileName %>" title="<?php echo __('Preview');?>"><i class="material-icons">&#xE8FF;</i></a>
												<% } %>
                                                <% if(downloadurl) { %>
                                                <a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<?php echo __('Preview');?>" target="_blank"><i class="material-icons">&#xE8FF;</i></a>
                                                <% } else {%>
                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                <% } %>
                                            </div>
                                        <?php } ?>
                                        <?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
                                            <div class="attach-close">
                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+caseDtId+'\'' %>,<%='\''+caseDtUniqId+'\'' %>,<%= '\''+getdata.Easycase.case_no+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
                                                                                            </div>
                                                                                        <?php } ?>
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
                                            <div class="file_cnt_info">
                                                   <span class="file-date fl"><?php echo __('Now');?></span>
                                                   <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                   <div class="cb"></div>
                                               </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <% if(fc%3==0) { %><div class="cb"></div><% } %>
                            <% } %>
                        <% } %>
                        <div class="cb"></div>
                    <% } %>
                <% } %>
            </div>
        </div>
    </div>
    </div>
<% }
} %>