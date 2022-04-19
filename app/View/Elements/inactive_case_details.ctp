<% var showQuickAct = showQuickActDD = 0; var UserClients_dtl = ''; var clientids = '';
   var user_can_change = 0;
if(((csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) || (SES_TYPE == 1 || SES_TYPE == 2 || (csUsrDtls== SES_ID))) && is_active==1) {
    var showQuickAct = 1;
}
if(showQuickAct && taskTyp.id != 10){
    var showQuickActDD = 1;
}
if(is_active == 1 && (csLgndRep == 1 || csLgndRep == 2 || csLgndRep == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (csUsrDtls== SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))){
    user_can_change = 1;
}
var users_colrs = {"clr1":"#AB47BC;","clr2":"#455A64;","clr3":"#5C6BC0;","clr4":"#512DA8;","clr5":"#004D40;","clr6":"#EB4A3C;","clr7":"#ace1ad;","clr8":"#ffe999;","clr9":"#ffa080;","clr10":"#b5b8ea;",};
var taskCreatedDate = frmtCrtdDt;
var taskcrtdBy = crtdBy;
var favMessage ="Set favourite task";
if(isFavourite){
    var favMessage ="Remove from the favourite task";
}
var params = parseUrlHash(urlHash);
%>
<input type="hidden" value="<%= Case_mislestone_id %>" id="Case_mislestone_id_<%= csUniqId %>"/>
<div id="t_<%= csUniqId %>" class="yoxview task_detail">    
    <div class="col-lg-12 col-sm-12 padlft-non padrht-non task-details-wrapper taskdetail_page">
                    <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
            <div class="task-detail-head task_details_title fw_tskdtail_head <%= protyCls %>">
                            <h5>
                                <% var easycaseTitle = showSubtaskTitle(caseTitle,csAtId,related_tasks,9,2,'detail'); %>
                                <div id="case_ttl_edit_main_<%= csUniqId %>" class="wrapword fs-hide removeLinks" onmouseover="displayEdit(<%= '\''+csUniqId+'\'' %>,1);" onmouseout="displayEdit(<%= '\'' +csUniqId+ '\'' %>,0);">
                                    <div <% if(user_can_change == 1 && params[0] !="timesheet_weekly" ){ %>class="task_title_hover" style="float:left;" id="case_ttl_edit_spn_<%= csUniqId %>" title="<?php echo __('Edit Task Title');?>" rel="tooltip" <% }else{ %>style="float:left;"<% } %>>#<%= csNoRep %>: <%= formatText(ucfirst(caseTitle)) %> <span class="relative sub-tasks sub-tasks-popoup"><%= easycaseTitle %></span></div>
                                    <div class="cb"></div>
                                </div>
                                
                                <div class="cb"></div>
                            </h5>
                            <div class="create_by_taskdtl" style="display:none">
                                <p class="fl">
                                    <% if(cntdta && (cntdta>0)) { %><?php echo __('Last updated');?><% } else { %><?php echo __('Created');?><% } %> <?php echo __('by');?> <span><%= shortLength(lstUpdBy,8) %></span> 
                                    <% if(lupdtm.indexOf('Today')==-1 && lupdtm.indexOf('Y\'day')==-1) { %><?php echo __('on');?><% } %>
                                    <none title="<%= lupdtTtl %>"><%= lupdtm %>.</none>
                                </p>
                                <p class="fr">
                                    <% if(srtdt){ %><span class="start-date" title="<%= srtdtT %>" rel="tooltip">(<?php echo __('Start');?>: <%= srtdt %>)</span><% } %>
                                    <% if(csDuDtFmt){ %><span class="gray-txt">(<?php echo __('Due');?>: <%= duedate %>)</span><% } %>
                                </p>
                                <p class="fr">
                                    <% if(client_status == 1){ %>
                                        <div style="min-height:20px;">
                                            <span style="color:#A80F0A;font-size:14px;font-weight:500;float:right;"><?php echo __('Clients can not see this task');?></span>
                                            <br />
                                        </div>
                                    <% } %>
                                </p>
                                <span style="display:inline-block;">
                                            <% if(children && children != ""){ %>
                                            <span class="fl  task_parent_block" id="task_parent_block_<%= csUniqId %>">
                                                <div rel="" title="<?php echo __('Parents');?>" onclick="showParents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + children + '\'' %>);" class=" task_title_icons_parents fl"></div>
                                                <div class="dropdown dropup fl1 open1 showParents">
                                                    <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                                        <li class="pop_arrow_new"></li>
                                                        <li class="task_parent_msg" style=""><?php echo __('These tasks are waiting on this task');?>.</li>
                                                        <li><ul class="task_parent_items" id="task_parent_<%= csUniqId %>"><li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif   "></li></ul></li>
                                                    </ul>
                                                </div>
                                            </span>
                                            <% } %>
                                            <% if(depends && depends != ""){ %>
                                            <span class="fl  task_dependent_block" id="task_dependent_block_<%= csUniqId %>">
                                                <div rel="" title="<?php echo __('Dependents');?>" onclick="showDependents(<%= '\'' + csid + '\'' %>,<%= '\'' + csUniqId + '\'' %>,<%= '\'' + depends + '\'' %>);" class=" task_title_icons_depends fl"></div>
                                                <div class="dropdown dropup fl1 open1 showDependents">
                                                    <ul class="dropdown-menu  bottom_dropdown-caret" style="left: -11px; padding:5px; cursor:default; min-width:250px; max-width:500px;">
                                                        <li class="pop_arrow_new"></li>
                                                        <li class="task_dependent_msg" style=""><?php echo __("Task can't start. Waiting on these task to be completed");?>.</li>
                                                        <li><ul class="task_dependent_items" id="task_dependent_<%= csUniqId %>"><li style="text-align:center;" class="loader"><img src="<?php echo HTTP_ROOT;?>img/images/loader1.gif"></li></ul></li>
                                                    </ul>
                                                </div>
                                            </span>
                                            <% } %>
                                       </span>
                                <div class="cb"></div>
                            </div>
                            <div class="task_action_status">
                                <div class="dtbl">
                                    <div class="dtbl_cel">
                                    </div>
                                    <div class="dtbl_cel">
                                        <div class="status_top">
                                            <span class="gray-txt cmn_ds_inb"><?php echo __('Status');?>:&nbsp;</span>
                                            <div class="cmn_ds_inb" style="" id="stsdiv<%= csAtId %>">
                                                <% if(taskTyp.id == "10"){ %>
                                                       <p> <%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
                                                <% } else{ %>
                                                    <% if(is_active && (csLgndRep !=3 && csLgndRep !=5 && csLgndRep !=2 && csLgndRep !=4)){%>
                                                     <p><%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
                                                    <% }else if(is_active && (csLgndRep ==3)){%>
                                                      <p><%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
                                                    <% }else if(is_active && csLgndRep ==5){%>  
                                                     <p><%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
                                                    <%}else if(is_active && (csLgndRep ==2 || csLgndRep == 4)){%>
                                                     <p><%= easycase.getColorStatus(csTypRep, csLgndRep) %></p>
                                                    <% }else { %>
                                                        <p class="fnt_clr_rd"><?php echo __('Archived');?></p>
                                                    <% } %>
                                                <% } %>
                                            </div>
                                            <div class="task-progress" id="pgrsdiv<%= csAtId %>">
                                                <span class="gray-txt">
                                                    <span class="fr" id="prgsloader" style="display:none"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/></span>
                                                </span>
                                                <% if(csLgndRep == 5 || csLgndRep == 3) {completedtask = 100;} %>
                                                <% var progress = 0; %>
                                                <% if(completedtask){ progress = completedtask;}%>
                                                <% var prgidtemp = 'more_opt19'; %>
                                                <% var prgid= 'more_opt19'; %>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-info" style="width: <%= progress %>%"></div>
                                                    <div class="cb"></div>
                                                </div>
                                                <div id="tskprgrs" class="cmn_h_det_arrow tsk_prgrss drop_percnt fr <% if(csLgndRep != 5 && csLgndRep != 3 && user_can_change ==1){ %>dropdown option-toggle<% } %>">
                                                    <div class="opt1" id="opt19">
                                                        <div class="text-right task_prog_percent" id="completed_task<%= csAtId %>">
                                                            <span><%= progress %>%</span>
                                                            <% if(csLgndRep != 5 && csLgndRep != 3){ %>
                                                            <% } %>
                                                        </div>
                                                    </div>

                                                       <div class="cb"></div>
                                                    </div>
                                                <div class="cb"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php /*<div class="dtl_toggle_arrow_txt">
                                <span class="collapse_txt" id="open_detail_id"> <% if(cntdta) { %>Show Detail<% } else{ %>Hide Detail<% } %></span>
                                <span class="tglarow_icon"><i class="material-icons">&#xE313;</i></span>
                            </div>*/ ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
        <div class="col-lg-9 col-sm-9 padlft-non padrht-non">
            <div class="task-detail-lft">
                <div class="task-detail-container">
                    <div class="toggle_task_details fs-hide <% if(cntdta) { %>hide_detail<% } else{ %>show_detail<% } %>">
                        <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                            <div class="task-detail-head detials-option-cont">
                                <div class="col-lg-3 col-sm-3">
                                    <span class="gray-txt"><?php echo __('Project');?></span>
                                    <p class="ttc"><%= shortLength(projName,16) %></p>
                                </div>
                                <div class="col-lg-3 col-sm-3">
                                    <span class="gray-txt"><?php echo __('Task Group');?></span>
                                    <div class=""  id="tgrpdiv<%= csAtId %>">
                                    <% if(is_active){%>
                                        <div class="dropdown cmn_h_det_arrow">
                                            <div class="opt1" id="opt80">
                                                <% var more_opt = 'more_opt80'; %>
                                                <p class="status_tdet">
                                                   <% if(mistn != '') { %><%= shortLength(ucfirst(formatText(mistn)),15) %><% } else { %><?php echo __('Default Task Group');?><% } %>
                                                </p>
                                            </div>   
                                        </div>                                      
                                    <% }else { %>
                                    <p class="ttc"><% if(mistn != '') { %><%= shortLength(ucfirst(formatText(mistn)),15) %><% } else { %><?php echo __('Default Task Group');?><% } %></p>
                                    <% } %>
                                </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 type-devlop">
                                    <div><span class="gray-txt"><?php echo __('Type');?></span></div>
                                    <div id="typdiv<%= csAtId %>" class="fl typ_actions <% if(showQuickAct==1){ %> dropdown<% } %>">
                                    <span class="dropdown cmn_h_det_arrow">
                                        <p>
                                            <span class="ttype_global tt_<%= getttformats(taskTyp.name)%>">
                                            <%= shortLength(taskTyp.name,10) %>                                                          
                                             </span>
                                        </p>
                                        
                                    </span>
                                    </div>                                    
                                    <div class="cb"></div>
                                </div>
                                <div class="col-lg-1 col-sm-1 tsk-dtail-priorty">
                                    <span class="gray-txt"><?php echo __('Priority');?></span>
                                    <% if(taskTyp.id == "10"){ %>
                                        <div id="pridiv<%= csAtId %>" class="pri_actions high_priority">
                                            <input type="hidden" id="hid_prittl" value="High" />
                                            <p><span class="priority-symbol"></span><?php echo __('High');?></p>
                                        </div>
                                    <% } else{ %>
                                        <div style="" id="pridiv<%= csAtId %>" data-priority ="<%= csPriRep %>" class="pri_actions <%= protyCls %><% if(showQuickAct==1){ %> dropdown<% } %>">
                                                <input type="hidden" id="hid_prittl" value="<%= protyTtl %>" />
                                                <span class="dropdown cmn_h_det_arrow">
                                                    <p <% if(showQuickAct==1){ %> class="quick_action " data-toggle="dropdown" <% } %> style="cursor:text;">
                                                    <span class="priority-symbol"></span><%= protyTtl %>
                                                    </p>
                                                 </span>
                                        </div>                                     
                                    <% } %>
                                </div>
                                <div class="col-lg-1 col-sm-1">
                                    <span class="gray-txt"><?php echo __('Est.Hour(s)');?></span> 
                                    <div id="estdiv<%= csAtId %>">
                                    <% if(taskTyp.id !== "10" && user_can_change == 1){ %>
                                        <p class="ttc" style="">
                                            <span>
                                            <% if(estimated_hours != 0.0) { %> <%= format_time_hr_min(estimated_hours) %> <% } else { %><?php echo __('None');?><% } %>
                                            </span>
                                            </p>
                                       
                                    <% }else { %>
                                        <p class="ttc">
                                        <% if(estimated_hours != 0.0) { %><%= format_time_hr_min(estimated_hours) %><% } else { %><?php echo __('None');?><% } %>
                                        </p>
                                    <% } %>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-1">
                                    <span class="gray-txt multilang_ellipsis" style="display:block" title="<?php echo __('Spent Hour(s)');?>"><?php echo __('Spent Hour(s)');?></span>
                                    <p class="ttc totalSPH"><% if(hours != 0.0) { %><%= format_time_hr_min(hours) %><% } else { %><?php echo __('None');?><% } %></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                        <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                        <div class="user-ans-section"  <% if(!csMsgRep && !csFiles) { %> style="padding:0;"<% } %>>
                                        <% if(csMsgRep || csFiles) { %>
                
                            <h4><?php echo __('Descriptions');?></h4>                           
                            <div class="fr task-down-arw">
                                 <a id="a_0" class="" style="display:none;" href="javascript:void(0);" onclick="showDescription(0)">
                                    <span title="<?php echo __('Expand description');?>" rel="tooltip" class="glyphicon glyphicon-menu-down"></span>
                                </a>
                            </div>
                            <div class="cb"></div>
                            <div class="plane_p_txt">
                                <% if(dispSec) { %>
                                    <div id="cnt_0" class="details_task_desc wrapword" style="overflow:hidden;">
                    <p><%= csMsgRep %></p>
                                        <% var fc = 0;
                                        if(csFiles) { %>
                                            <span class="attac_count_task_det attachment_wrap">
                                                <i class="material-icons">&#xE226;</i>
                                                <% if(filesArr){ %> <span class="attach_cnt"> <% if((filesArr.length)==1){ %> <?php echo __('1 Attachment');?> <%}else {%><%= filesArr.length%> <?php echo __('Attachments');?> <% } %></span> <% } else { %><?php echo __('No Attachments');?> <% } %>
                                            </span>
                                            <% var images = ""; var caseFileName = "";
                                            for(var fileKey in filesArr) {
                        var getFiles = filesArr[fileKey];
                        caseFileName = getFiles.CaseFile.file;
                        caseFileUName = getFiles.CaseFile.upload_name;
                                                caseFileId = getFiles.CaseFile.id;
                        downloadurl = getFiles.CaseFile.downloadurl;
                        var d_name = getFiles.CaseFile.display_name;
                        if(!d_name){ d_name = caseFileName;}
                                                if(caseFileUName == null){ caseFileUName = caseFileName;}
                        if(getFiles.CaseFile.is_exist) {
                                                    fc++; 
                                                    file_icon_name = easycase.imageTypeIcon(getFiles.CaseFile.format_file); %>
                                                        <div class="fr atachment_det atachment_<%=caseFileId%>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> <% }else{%> style="display:none;" <%} %>>
                                                        <div class="aat_file">
                                                            <div class="file_show_dload">
                                                                <a href="<%= getFiles.CaseFile.fileurl %>" target="_blank" alt="<%= caseFileName %>" title="<?php echo __('Preview Image');?>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %>rel="prettyPhoto[]"<% } %>><i class="material-icons">&#xE8FF;</i></a>
                                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                            </div>
                                                            <div class="attach-close">
                                                                <% if(user_can_change == 1){ %>
                                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+csAtId+'\'' %>,<%='\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
                                                                <% } %>
                                                            </div>
                                                            <% if(file_icon_name == 'jpg' || file_icon_name == 'png' || file_icon_name == 'bmp'){ %>
                                                                <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                                                        <img data-original="<%= getFiles.CaseFile.fileurl_thumb %>" class="lazy asignto" style="max-width:180px;" title="<%= d_name %>" alt="Loading image.." />
                                                                <% }else{ %>
                                                                        <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=90&sizey=60&quality=100" class="lazy asignto" width="180" height="120" title="<%= d_name %>" alt="Loading image.." />
                                                                <% } %>
                                                            <% } else { %>
                                                                <div style="display:none;" class="tsk_fl <%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_file"></div>
                                                            <% } %>
                                                            <div class="file_cnt ellipsis-view" title="<%= d_name %>" rel="tooltip"><%= d_name %></div>
                                                            <div class="file_cnt_info">
                                                                <span class="file-date fl"><%= frmtCrtdDt %></span>
                                                                <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                                <div class="cb"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="fr atachment_det parent_other_holder atachment_<%=caseFileId%>" <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'jpg' || easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'png'){ %> style="display:none;" <% } %>>
                                                        <div class="aat_file">
                                                            <div class="file_show_dload">
                                                                <% if(easycase.imageTypeIcon(getFiles.CaseFile.format_file) == 'pdf'){ %>
                                                                <a href="javascript:void(0);" onclick="viewPdfFile(<%= getFiles.CaseFile.id %>);" target="_blank" alt="<%= caseFileName %>" title="<?php echo __('Preview Image');?>"><i class="material-icons">&#xE8FF;</i></a>
                                                                <% } %>
                                                                <% if(downloadurl) { %>
                                                                <a href="<%= downloadurl %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                                <% } else {%>
                                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= caseFileName %>" title="<?php echo __('Download');?>"><i class="material-icons">&#xE2C4;</i></a>
                                                                <% } %>
                                                            </div>
                                                            <div class="attach-close">
                                                                <% if(user_can_change == 1){ %>
                                                                    <a href="javascript:void(0);" class="hover-close close-icon" onclick="removefiledirect(<%= '\''+caseFileId+'\'' %>,<%='\''+csAtId+'\'' %>,<%='\''+csUniqId+'\'' %>,<%= '\''+csNoRep+'\'' %>)"><i class="material-icons">&#xE872;</i></a>
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

                                                            <div class="file_cnt ellipsis-view" title="<%= d_name %>" rel="tooltip"><%= d_name %></div>
                                                            <div class="file_cnt_info">
                                                                <span class="file-date fl"><%= frmtCrtdDt %></span>
                                                                <span class="file-size fr"><%= getFiles.CaseFile.file_size %></span>
                                                                <div class="cb"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <% if(fc%4==0) { %><div class="cb"></div><% } %>
                                            <% } %>
                                        <% } %>
                                    <% } %>
                                    <div class="cb"></div>
                                    <div class="fr collaps" style="display:none;">
                                        <a href="javascript:void(0);" onclick="collapsDescription(0)"><span><?php echo __('Collapse Description');?></span>&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-up"></span></a>
                                    </div>
                                    <div class="cb"></div>
                </div>
                <% } %>
                            </div>                        
                                        <% } %>
                                        </div>
                        </div>
                     <div class="clearfix"></div>
            <% var chk_sub_parent = easycaseTitle.split('<i class="material-icons case_symb'); %>           
            <% if(chk_sub_parent.length < 3){ %>
            <div class="task-details-tlog m-btm10">
                <div class="sub_tasks_tbl" id="case_subtask_task<%= csUniqId %>">
                    <?php echo $this->element('case_subtasks'); ?>
                </div>
            </div>
            <% } %>
            <div class="col-lg-12 col-sm-12 padlft-non padrht-non">                 
                        <div class="sub_tasks_tbl" id="case_link_task<%= csid %>">
                            <?php echo $this->element('case_link_task');?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-sm-12 padlft-non padrht-non">                 
               <div class="comnt_tlog_tab_sec">
                    <ul class="ct_tabs">
                        <li class="tab-link detl_tab_switching comment_tab current" data-tab="tab-1<%= csUniqId %>" data-case_uid="<%= csUniqId %>" data-to_hid="tab-2">
                            <?php echo __('Comments');?> 
                            <% if(cntdta) { %>
                            <p class="tsk-dtl-reply-cnt"><span><i class="material-icons">&#xE0B7;</i></span><span class="tsk-dtl-reply-cnt-lbl">(<small style="display: inline;"><%= total %></small>)</span></p>
                            <% } %>
                        </li>
                        <li class="tab-link detl_tab_switching tlog_tab" data-tab="tab-2<%= csUniqId %>" data-case_uid="<%= csUniqId %>"  data-to_hid="tab-1"><?php echo __('Time log');?></li>
                    </ul>
                  <div id="tab-1<%= csUniqId %>" class="tab-content current">
                    <% if(cntdta){ %>
                        <div class="user-comment">
                        <?php /* <div class="col-lg-4 col-sm-4">
                                    <h4><?php echo __('Comments');?>
                                     <% if(cntdta) { %>
                                    <p class="tsk-dtl-reply-cnt"><span><i class="material-icons">&#xE0B7;</i></span><span class="tsk-dtl-reply-cnt-lbl">(<small><%= total %></small>)</span></p>
                                    <% } %>
                                    </h4>    
                        </div> */ ?>
                              <% if(total > 10){ %>
                                <div class="col-lg-8 col-sm-8 text-right">
                                    <div class="fr view_rem">
                                        <a id="morereply<%= csAtId %>" style="<% if(cntdta > 10) { %>display:none<% } %>;" class="orange_btn" href="javascript:void(0);" onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'more\'' %>)">
                                            <% remaining = total-10; %>
                                        <?php echo __('View remaining');?> <%= remaining %> <?php echo __('thread');?><% if(remaining > 1) {%><?php echo __('s');?><% } %>
                                        </a>
                                        <span id="hidereply<%= csAtId %>" <% if(cntdta <= 10) { %> style="display:none" <% } %>>
                                            <a class="orange_btn" href="javascript:void(0);" onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'less\'' %>)">
                                                <?php echo __('View latest 10');?>
                                            </a>
                                        </span>
                                        <span class="rep_st_icn"></span>
                                        <span id="loadreply<%= csAtId %>" style="visibility: hidden;"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="<?php echo __('loading');?>..."/></span>
                                    </div>
                                    <div class="fr view_rem">
                                        <span id="repsort_desc_<%= csAtId %>" <%= ascStyle %>> 
                                            <a href="javascript:void(0);" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View oldest thread on top');?>"><?php echo __('Newer');?></a>
                                        </span>
                                        <span id="repsort_asc_<%= csAtId %>" <%= descStyle %> > 
                                            <a href="javascript:void(0);" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View newest thread on top');?>"><?php echo __('Older');?></a>
                                        </span>
                                        <span class="rep_st_icn"></span>
                                        <span id="loadreply_sort_<%= csAtId %>" style="visibility: hidden;"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="<?php echo __('loading');?>..."/></span>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                                <input type="hidden" value="less" id="threadview_type<%= csAtId %>" />
                                <input type="hidden" value="<%= thrdStOrd %>" id="thread_sortorder<%= csAtId %>" />
                                <input type="hidden" value="<%= remaining %>" id="remain_case<%= csAtId %>" />
                            <% } %>
                             <div class="cb"></div>
                            <div class="reply_cont_bg fs-hide" id="reply_content<%= csAtId %>">
                                  <div id="showhidemorereply<%= csAtId %>">
                                          <?php echo $this->element('case_reply'); ?>
                                  </div>
                            </div>
                        </div>
                    <% } %>
                    </div>
                    <div class="clearfix"></div>
                <div id="tab-2<%= csUniqId %>" class="tab-content">
                    <div class="time_log_reply task-details-tlog" id="reply_time_log<%= csAtId %>">
                        <% if(logtimes.logs.length > 0){ %>
                            <?php echo $this->element('case_timelog'); ?>
                        <% }else{ %>
                        <div class="tlog_top_cnt"> 
                            <div class="time-log-header timelog-table timelog-table-head <% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>detail_timelog_header<% } %>" style="<% if(SHOWTIMELOG !='No' && pagename == 'taskdetails'){ %>display:none;<% } %>">
                
                <a class="<%=logtimes.page%> anchor log-more-time fr" onclick="setSessionStorage(<%= '\'Task Details Page\'' %>, <%= '\'Time Log\'' %>);createlog(<%= logtimes.task_id %>,'<%= escape(htmlspecialchars(logtimes.task_title))%>')"><i class="material-icons">&#xE192;</i><?php echo __('Time Entry');?></a>
                                <div class="clearfix"></div>
                            </div>
                            </div>
                        <% } %>
                    </div>
                        </div>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                           <div id="tour_detl_logs<%= csUniqId %>" class="col-lg-12 col-sm-12 padlft-non padrht-non">
                    <input type="hidden" name="data[Easycase][sel_myproj]" id="CS_project_id<%= csAtId %>" value="<%= projUniqId %>" readonly="true">
                    <input type="hidden" name="data[Easycase][myproj_name]" id="CS_project_name<%= csAtId %>" value="<%= htmlspecialchars(projName) %>" readonly="true">
                    <input type="hidden" name="data[Easycase][case_no]" id="CS_case_no<%= csAtId %>" value="<%= csNoRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][type_id]" id="CS_type_id<%= csAtId %>" value="<%= csTypRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][title]" id="CS_title<%= csAtId %>" value="" readonly="true"/>
                    <input type="hidden" name="data[Easycase][priority]" id="CS_priority<%= csAtId %>" value="<%= csPriRep %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][org_case_id]" id="CS_case_id<%= csAtId %>" value="<%= csAtId %>" readonly="true"/>
                    <input type="hidden" name="data[Easycase][istype]" id="CS_istype<%= csAtId %>" value="2" readonly="true"/>
                    <div class="cb"></div>

                    <% if(is_active){ %>
                        <div class="col-lg-12 col-sm-12 padlft-non padrht-non reply_task_block"  id="reply_box<%= csAtId %>">
                            <div class="task-details-comment-block">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 col-sm-12 m-top-20" style="display:none;">
                            <div class="fl lbl-font16 lbl_cs_det_125">&nbsp;</div>
                            <div class="fr mor_toggle tasktoogle" style="float:left;" id="mor_toggle<%= csAtId %>" data-csatid="<%= csAtId %>">
                                <a href="javascript:jsVoid();" style="text-decoration:none">
                                    <img src="<?php echo HTTP_IMAGES; ?>priority.png" title="<?php echo __('Priority');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <img src="<?php echo HTTP_IMAGES; ?>hours.png" title="<?php echo __('Hours Spent and % Completed');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <img src="<?php echo HTTP_IMAGES; ?>attachment.png" title="<?php echo __('Attachments, Google Drive, Dropbox');?>" rel="tooltip"/>&nbsp;&nbsp;
                                    <?php echo __('More Options');?>
                                    <b class="caret"></b>
                                </a>
                            </div>
                            <div class="fr less_toggle tasktoogle" id="less_toggle<%= csAtId %>" data-csatid="<%= csAtId %>" style="display:none;float:left"><a href="javascript:jsVoid();" style="text-decoration:none"><?php echo __('Less');?><b class="caret"></b></a></div>
                        </div>
                    <% } %>
                </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
            <div class="col-lg-3 col-sm-3 padlft-non padrht-non">
                <div class="col-lg-12 col-sm-12 padlft-non padrht-non">
                    <div class="task-detail-rht">
                        <div class="cmn_sec_head">
                            <div class="sec_ttl"><h5><span class="cmn_tskd_sp user_icon"></span><?php echo __('People');?></h5></div>
                            <div id="asgnUsrdiv<%= csAtId %>" class="assign_to user-task-info">
                                <input type="hidden" id="hid_asgn_uid" value="<%= asgnUid %>" />
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt"><?php echo __('Assign To');?>:</span>
                                        <span class="fr detasgnlod" id="detasgnlod<%= csAtId %>" style="display:none">
                                                <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                                        </span>
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="fl user-task-pf">
                                            <% if(asgnPic && asgnPic!=0) { %>
                                                    <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= asgnPic %>&sizex=55&sizey=55&quality=100" class="" title="<%= asgnTo %>" width="55" height="55" />
                                            <% } else { %>
                                                <% var usr_name_fst = asgnTo.charAt(0); %>
                                                <span class="cmn_profile_holder <%= asgnPicBg %>" title="<%= asgnTo %>">
                                                    <%= usr_name_fst %>
                                                </span>
                                            <% } %>
                                        </div>
                                        
                                        <div class="cb"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="involve-people">
                                                            <div class="dtbl">
                                <div class="cmn_ds_cel">
                                                                    <span class="gray-txt font_12"><?php echo __('People Involved');?>:</span><!--<i class="material-icons">&#xE7FD;</i>-->
                                                                </div>
                                                                <div class="cmn_ds_cel">
                                                                    <div class="activity-info">
                                    <% for(i in taskUsrs) { %>
                                        <span class="user-task-pf">
                                            <% var upic = 'user.png'; %>
                                            <% var nm_t = formatText(taskUsrs[i].User.name); var usr_name_fst = nm_t.charAt(0); %>                  
                                            <% if(taskUsrs[i].User.photo && taskUsrs[i].User.photo!=0) { 
                                                    upic = taskUsrs[i].User.photo; %>
                                                <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= upic %>&sizex=55&sizey=55&quality=100" class="" title="<%= ucwords(formatText(taskUsrs[i].User.name+' '+taskUsrs[i].User.last_name)) %>" width="55" height="55" rel="tooltip" />
                                            <% }else{ %>
                                                    <span class="cmn_profile_holder <%= taskUsrs[i].User.prflBg %>" title="<%= ucwords(formatText(taskUsrs[i].User.name+' '+taskUsrs[i].User.last_name)) %>">
                                                            <%= usr_name_fst %>
                                                    </span>
                                            <% } %>
                                        </span>
                                    <% } %>
                                    <div  class="cb"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="involve-people">
                                                            <div class="dtbl">
                                                                <div class="cmn_ds_cel">
                                                                    <span class="gray-txt font_12"><?php echo __('Created By');?>:</span>
                                                                </div>
                                                                <div class="cmn_ds_cel">
                                                                    <div class="activity-info">                                 
                                                                            <span class="user-task-pf">
                                                                                  <% if(pstFileExst) { %>
                                                                                        <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= pstPic %>&sizex=55&sizey=55&quality=100" class="lazy rep_bdr" title="<%= pstNm %>" width="55" height="55" />
                                                                                    <% } else { %>
                                                                                        <% var usr_name_fst = pstNm.charAt(0); %>
                                                                                        <span class="cmn_profile_holder <%= pstPicBg %>">
                                                                                                <%= usr_name_fst %>
                                                                                        </span>
                                                                                    <% } %>                                                                                         
                                                                                    <div class="cb"></div>
                                                                            </span>
                                                                                    <span class="gray-txt" style="font-size:13px;"><%= shortLength(crtdBy,25) %></span>
                                                                                <!--%= frmtCrtdDt %-->
                                                                        <div  class="cb"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                        </div>
                        <div class="cmn_sec_head">
                            <div class="sec_ttl"><h5><span class="cmn_tskd_sp date_icon"></span><?php echo __('Date');?></h5></div>
                            <div class="due_date task_due_dt">
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt font_12">
                                            <?php echo __('Due Date');?>
                                        </span>
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="caleder-due-date">
                                            <div class="calender-txt cmn_h_det_arrow anchor">
                                                <span class="fr" id="detddlod<%= csAtId %>" style="display:none">
                                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="<?php echo __('Loading');?>..."/>
                                                </span>
                                                <div id="case_dtls_due<%= csAtId %>" class="duedate-txt">
                                                    <% if(csDuDtFmt) { %>
                                                    <div title="<%= csDuDtFmtT %>" rel="tooltip" class="fl">
                                                        <%= csDuDtFmt %>                                                       
                                                    </div>
                                                    <% } else { %>
                                                    <div class="no_due_dt">
                                                        <div class="fl due-txt no_due"><span class="multilang_ellipsis" style="display:inline-block;width:75%;"><?php echo __('Date Not Set');?></span></div>
                                                        <div class="cb"></div>                                                        
                                                    </div>
                                                    <% } %>
                                                </div>
                                            </div>
                                            <!--<i class="material-icons">&#xE916;</i>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt font_12"><?php echo __('Last Updated');?>:</span>
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="activity-info">
                                            <p><%= lupdtm %> <?php echo __('by');?> <span <% if(lstUpdBy != 'me'){ %> class="ttc" <% } %> style=""><%= shortLength(lstUpdBy,3,0) %></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt font_12"><?php echo __('Last Commented');?>:</span>
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="activity-info">
                                            <p><%= frmtCrtdDt %> <?php echo __('by');?> <%= shortLength(lstUpdBy,3,0) %></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt font_12"><?php echo __('Created Date');?>:</span>
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="activity-info">
                                            <p><%= taskCreatedDate %></p>
                                        </div>
                                    </div>
                                </div>
                                <% if(lstRes) { %>
                                    <div class="dtbl">
                                        <div class="cmn_ds_cel">
                                            <span class="gray-txt font_12"><?php echo __('Resolved Date');?>:</span>
                                        </div>
                                        <div class="cmn_ds_cel">
                                            <div class="activity-info">
                                                <p><%= lstRes %></p>
                                            </div>
                                        </div>
                                    </div>
                                <% } %>
                                <% if(lstCls) { %>
                                <div class="dtbl">
                                    <div class="cmn_ds_cel">
                                        <span class="gray-txt font_12"><?php echo __('Closed');?>:</span> 
                                    </div>
                                    <div class="cmn_ds_cel">
                                        <div class="activity-info">
                                            <p><%= lstCls %></p>
                                        </div>
                                    </div>
                                </div>
                                <% } %>
                            </div>
                        </div>
                        <br/>
                        <div class="cmn_sec_head task_label">
                            <div class="sec_ttl rht_label_task">
                                <h5><i class="material-icons">label</i>
                                    <?php echo __('Label in this Task');?>
                                    <sup class="sup-new" style="color: #f93737;font-size: 9px;margin-left: -5px;">&nbsp;New</sup>                                   
                                </h5>
                            </div>
                            <div id="tour_detl_labels<%= csUniqId %>" class="label_in_task">                            
                                <?php echo $this->element('case_label_task');?>
                            </div>
                        </div>
                        <div class="cmn_sec_head">
                            <div class="sec_ttl"><h5><span class="cmn_tskd_sp file_icon"></span><?php echo __('File in this Task');?></h5></div>
                            <div class="file_in_task">
                                <% var fc = 0; %>
                                    <% var count = all_files.length; %>
                                    <div class="no-file">
                                        <span class="btn-file"><%= count%><% if(count >1){ %> <?php echo __('Files');?> <% }else{ %> <?php echo __('File');?> <% } %></span>
                                        <!--<i class="material-icons">&#xE2BC;</i>-->
                                    </div>
                                    <div class="cb"></div>
                                    <div class="added-task-file">
                                <% if(all_files.length) { %>

                                        <% var imgaes = ""; var caseFileName = ""; %>
                                        <% for(var fkey in all_files){ %>
                                            <% var getFiles = all_files[fkey];
                                            caseFileName = getFiles.CaseFile.file;
                                            caseFileUName = getFiles.CaseFile.upload_name;
                                            downloadurl = getFiles.CaseFile.downloadurl;
                                            var d__fil_name = getFiles.CaseFile.display_name; %>

                                            <% if(!d__fil_name){d__fil_name = caseFileName;} %>
                                            <% if(caseFileUName == null){caseFileUName = caseFileName;} %>
                                            <% if(getFiles.CaseFile.is_exist) {
                                                fc++; %>
                                                <div class="fl smal-addtask-file atachment_<%=getFiles.CaseFile.id%>">
                                                    <div class="atachment_det">
                                                        <div class="aat_file rht-aat_file">
                                                    <% if(getFiles.CaseFile.is_ImgFileExt){ %>
                                                        <% if(downloadurl){ %>
                                                            <a href="<%= downloadurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>" rel="prettyImg[]">
                                                                <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                                                    <center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= caseFileName %>" alt="Loading image.." /></center>
                                                                <% }else{ %>
                                                                    <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= caseFileName %>" alt="Loading image.." />
                                                                <% } %>
                                                                <span class="ellipsis-view"><%= caseFileName %></span>
                                                            </a>
                                                        <% } else { %>
                                                            <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= d__fil_name %>" title="<%= d__fil_name %>" rel="prettyImg[]">
                                                                <% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
                                                                    <center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= d__fil_name %>" alt="Loading image.." /></center>
                                                                <% }else{ %>
                                                                    <img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= d__fil_name %>" alt="Loading image.." />
                                                                <% } %>
                                                                <span class="ellipsis-view"><%= d__fil_name %></span>
                                                            </a>
                                                        <% } %>
                                                    <% } else{ %>
                                                            <% if(downloadurl) { %>
                                                                <a href="<%= downloadurl %>" target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>">
                                                                    <img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                                    <span class="ellipsis-view"><%= caseFileName %></span>
                                                                </a>
                                                            <% } else { %>
                                                                <a href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" alt="<%= d__fil_name %>" title="<%= d__fil_name %>">
                                                                    <img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
                                                                    <span class="ellipsis-view"><%= d__fil_name %></span>
                                                                </a>
                                                            <% } %>
                                                    <% } %>
                                                        <div class="rht_file_cnt"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <% } %>
                                        <% } %>
                                        <div class="cb"></div>
                                <% } %> 
                                <% if(fc==0) { %><p class="fnt12px nofiletxt colr_red"><?php echo __('No Files in this Task');?></p><div class="cb"></div><% } %>
                                </div>
                            </div>
                        </div>
                        <div class="cmn_sec_head">
                            <div class="sec_ttl"><h5><span class="cmn_tskd_sp activity_icon"></span><?php echo __('Activities');?></h5></div>
                            <div class="activities_flowchat">
                                <div class="actvity_bar <% if(sqlcaseactivity.length == 0){ %>nodot<% } %>"  >
                                <?php echo $this->element('case_detail_right_activity'); ?>
                                </div>                                                            
                            </div>
                            <div class="pr">
                                <div class="taskActivityAll">
                                <% if(activitycountall > 10){%>
                                    <a href="javascript:void(0)" onclick="displayAllAct(<%= '\''+csAtId+'\',\'more\'' %>);"><?php echo __('Display All');?></a>
                                <% } %>
                                </div>
                                                                <div class="loaderAct"><img src="<?php echo HTTP_IMAGES;?>images/del.gif" /></div>
                                                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <input type="hidden" value="<%= csUniqId %>" id="case_uiq_detail_popup">
        </div>
    </div>
    <div class="cb"></div>  
</div>