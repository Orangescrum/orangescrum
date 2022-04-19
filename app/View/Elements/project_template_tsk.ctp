<tr id="quick-task-TG-edit-<%= id %>-<%= task_id %>" class="edit_tg_pt_row ">
    <td colspan="6">
       <!-- <% if(typeof parent_id  != 'undefined'){ %> -->
        <input type="hidden" name="parent_id" value="<%= (typeof parent_id  != 'undefined')?parent_id:0 %>" id="parent_id_pt<%= id %>-<%= task_id %>" />
        <input type="hidden" name="task_label" value="<%= (typeof task_label  != 'undefined')?task_label:0 %>" id="task_label_pt<%= id %>-<%= task_id %>">
       <!-- <% } %>-->
                            <div class="col-md-3 form-group label-floating is-empty">
                              <div class="input-group">
                                    <label class="control-label" for="addon3a"><?php echo __('Task Title');?></label>
                                    <input class="form-control" type="text" id="inline_qktask_pt<%= id %>-<%= task_id %>">
                              </div>
                            </div>                           
                            <div class="col-md-2 form-group padrht-non cstm-drop-pad qt_dropdown task_type qt_tsk_type_dropdown">
                                <select class="tsktyp-select form-control task_type floating-label" placeholder="<?php echo __('Task Type');?>" data-dynamic-opts=true id="qt_task_type_pt<%= id %>-<%= task_id %>">
                                <%
                                for(var k in GLOBALS_TYPE) {
                                if(GLOBALS_TYPE[k].Type.project_id == 0 || GLOBALS_TYPE[k].Type.project_id == PROJECTS_ID_MAP[$('#projFil').val()]){
                                    var v = GLOBALS_TYPE[k];
                                    var t = v.Type.id;
                                    var t1 = v.Type.short_name;
                                    var t2 = v.Type.name;
                                    var txs_typ = t2;
                                    var check_sel = '';
                                    
                                %>
                                    <option value="<%= v.Type.id %>" ><%= v.Type.name %></option>
                                <%                                  
                                } }
                                %>
                                </select>
                                
                            </div>
                            <div class="col-md-1 form-group storypointpt<%= id %>-<%= task_id %> label-floating is-empty" style="display:none; padding: 0px;">
                                <div class="input-group">
                                    <label class="control-label" for="inline_story_point_pt<%= id %>-<%= task_id %>"><?php echo __('Story Point');?></label>
                                    <input class="form-control" type="number" id="inline_story_point_pt<%= id %>-<%= task_id %>" min="0">
                                </div>
                            </div>
                            <div class="col-md-2 form-group padrht-non task-type-fld labl-rt cstm-drop-pad qt_dropdown">
                             <select class="form-control floating-label assign_pt" placeholder="<?php echo __('Assign To');?>" data-dynamic-opts=true onchange="changeTypeId(this)" id="quick_assign_pt<%= id %>-<%= task_id %>">
                                <% for(var qtk in QTAssigns){
                                    var check_sel = '';
                                    var user_nm_me = '<?php echo __('Me');?>';
                                    if(SES_TYPE >=3 && SES_ID == QTAssigns[qtk].id){ 
                                        check_sel = "selected"; 
                                    }
                                    %>
                                    <option value="<%= QTAssigns[qtk].id %>" <%= check_sel %>><% if(SES_ID == QTAssigns[qtk].id){ %><%= user_nm_me %><% }else{ %><%= QTAssigns[qtk].name %><% } %></option>
                                <% } %>
                                <option value="0"><?php echo __('Unassigned');?></option>
                                </select>
                            </div>
                             <div class="col-md-2 form-group label-floating  stop-floating-top qt_form-group" style="width: 13%;">
                                <select class="priority_select form-control priority floating-label" placeholder="<?php echo __('Priority');?>" data-dynamic-opts=true id="qt_priority_pt<%= id %>-<%= task_id %>">
                                       <option value="0">High</option>
                                       <option value="1">Medium</option>
                                       <option value="2">Low</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group label-floating is-empty">
                                <div class="input-group">
                                <label class="control-label" for="qt_estimated_hours"><?php echo __('Est. Hr');?></label>
                                <span class="os_sprite est-hrs-icon" style="top:8px;"></span>
                                <input type="text" name="qt_estimated_hours" value=""  class="form-control check_minute_range" id="qt_estimated_hours_pt<%= id %>-<%= task_id %>" maxlength="5" onkeypress="return numeric_decimal_colon(event)" />   
                                </div>                            
                            </div>  
                        
                            <div class="cb"></div>
                            <div class="col-md-12 padnon uploaded_file_sec">
                                <div class="multiple-file-upload up_file_list">
                                    <table id="up_files_pt<%= id %>-<%= task_id %>" style="font-weight:normal;width: 100%;"></table>
                                    <form id="cloud_storage_form<%= id %>-<%= task_id %>" name="cloud_storage_form"  action="javascript:void(0)" method="POST">
                                    <div style="float: left;margin-top: 7px;" id="cloud_storage_files<%= id %>-<%= task_id %>"></div>
                                    </form>
                                    <div style="clear: both;margin-bottom: 3px;"></div>
                                </div>
                            </div>
                             <div class="cb"></div>
                            <div class="col-md-8 padnon">
                                <textarea name="descriptions" id="qt_description_pt<%= id %>-<%= task_id %>"></textarea>
                            </div>
                            <div class="col-md-4 padnon">
                                <form id="file_upload_pt<%= id %>-<%= task_id %>" action="<?php echo HTTP_ROOT."easycases/fileupload/"; ?>" method="POST" enctype="multipart/form-data">
                                        <div class="drag_and_drop" id="holder_crt_task<%= id %>-<%= task_id %>" style="min-height:100px;margin:0px;box-shadow: none;">
                                            <header class="crt_header">
                                                <?php echo __('Attachments');?>
                                                <div class="fr">                                                   
                                                </div>
                                                <div class="cb"></div>
                                            </header>
                                            <div class="drop-file crttask_attachment">
                                                <span><?php echo __('Drop files here or');?></span>
                                                <div class="customfile-button">                  
                                                    <input class="customfile-input fileload fl" id="task_file<%= id %>-<%= task_id %>" name="data[Easycase][case_files]" type="file" multiple="" style="visibility:visible;" />
                                                    <label class="att_fl" style=""><?php echo __('click upload');?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            <div class="cb"></div>
                            <div class="col-md-2 fr mtp-15 mbtm15">
                                <span class="btn-group">
                                    <input type="hidden" value="list" id="task_view_types_span" />
                                    <a id="quickcase_qt_pt" href="javascript:void(0)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size quickcase_qt_pt"  style="font-size: 14px;margin-right:5px" onclick="addTemplateTask(<%= id %>,<%= task_id %>);"><?php echo __('Save');?></a>                                
                                </span>
                                <span>
                                  <a href="javascript:void(0);" class="cancle_pt" onclick="cancelTSKPT(<%= id %>,<%= task_id %>);"><?php echo __('Cancel');?></a>
                                </span>
                            </div>
                        <div class="cb"></div>
                        </td>
</tr>