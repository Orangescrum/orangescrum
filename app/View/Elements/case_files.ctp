<div class="files_page">
    <% var count = 0; var totids = "";
    if(file_srch.trim()) { 
        var vfile = "files"; %>
		<div class="cmn_search_result cmn_bdr_shadow">
			<div class="global-srch-res fl"><?php echo __('Search Results for');?>: <span><%= file_srch %></span></div>
			<div class="fl global-srch-rst">
				<a title="<?php echo __('Reset Filter');?>" rel="tooltip" class="file-global-srch-rst" onclick="checkHashLoad('<%=vfile%>')" href="<%= HTTP_ROOT %>dashboard#files">
					<i class="material-icons">&#xE8BA;</i></a>
				</a>  
			</div>
			<div class="cb"></div>
		</div>
    <% } %>
    <% if(file_srch.trim() || parseInt(caseCount)) { %>
    <div class="files_top_ttl cmn_bdr_shadow task_listing">
        <table class="table table-striped mrg0">
            <tbody><tr>
                    <th class="drdown_width"></th>
                    <th class="tasknu_width"><?php echo __('Task');?>#</th>
                    <th><?php echo __('File Name');?></th>
                    <th class="ftype_width"><?php echo __('File Type');?></th>
                    <th class="upload_width"><?php echo __('Uploaded by');?></th>
                    <th class="date_width"><?php echo __('Date');?></th>
                    <th class="size_width"><?php echo __('Size');?></th>
                    <th class="dload_width"><?php echo __('Download');?></th>
                </tr>
            </tbody></table>
    </div>
    <% } %>
    
    <%  chkDateTime = ''; loopcntr=0;
        for(var key in caseAll) {
            var obj = caseAll[key];
            count++;

            var caseAutoId = obj.Easycase.id;
            var caseUniqId = obj.Easycase.uniq_id;
            var projUniqId = obj.Project.uniq_id;
            var caseNo = obj.Easycase.case_no;
            var fileId = obj.CaseFile.id;
            var fileName = obj.CaseFile.file;

                    var newUpdDt = obj.newUpdDt;
                    if(chkDateTime != newUpdDt) { %>
                        <% if(loopcntr++ >0) { %>
                            </tbody>
                            </table>
                            </div>
                        <% } %>
    
                        <div class="dt_cmn_mc"><%= obj.newdt %></div>
                        <div class="files_cmn cmn_bdr_shadow task_listing">
                        <table class="table table-striped table-hover mrg0">
                        <tbody>
                    <% } %>
                    <tr class="tr_all" id="curRow<%= fileId %>">
                        <td class="drdown_width">
                            <span class="dropdown">
                                <a href="javascript:void(0)" class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown"  data-target="#">
                                    <i class="material-icons">&#xE5D4;</i>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if($this->Format->isAllowed('Archive File',$roleAccess)){ ?>
                                    <li><a onClick="archiveFile(this)" data-id="<%= fileId %>" data-name="<%= obj.file_name %>" href="javascript:void(0);"><i class="material-icons">&#xE149;</i> <?php echo __('Archive');?></a></li>
                                <?php } ?>
                                <?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
                                    <li><a onclick="removeFileFrmFiles(<%= fileId %>)" data-name="<%= obj.file_name %>" id="file_remove_<%= fileId %>" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove');?></a></li>
                                <?php } ?>
                                </ul>
                            </span>
                        </td>
                        <td class="tasknu_width"><a class="cmn_link_color file_new_popup" data-disid="<%= caseUniqId %>"><%= caseNo %></a></td>
                        <td>
                            <div class="fl_nm_ipad ellipsis-view ttl_listing">
                                <% if(obj.download_url != '') { %>
                                    <a class="cmn_link_color" href="<?php if($this->Format->isAllowed('Download File',$roleAccess)){?> <%= obj.download_url %> <?php } else{ ?>javascript:void(0);<?php } ?>"" target="_blank" title="<%= obj.file_name %>" class="file_name_ipad">
                                        <%= obj.file_name %>
                                    </a>
                                <% } else { %>
                                    <a class="cmn_link_color" href="<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?><%= obj.link_url %><?php } else{ ?>javascript:void(0);<?php } ?>" target="_blank" title=" <%= obj.file_name %>" class="file_name_ipad fl" <% if(obj.is_image) { %>rel="prettyImage[]" <% } %>>
                                        <%= obj.file_name %>
                                    </a>
                                <% } %>
                            </div>
                        </td>
                        <td class="ftype_width">
                            <span class="os_sprite play_file <%= easycase.imageTypeIcon(obj.file_type)%>_file"></span>
                        </td>
                        <td class="assi_tlist upload_width">
                            <i class="material-icons">&#xE7FD;</i><%= obj.usrName %>
                        </td>
                        <td class="date_width"><span title="<%= obj.xct_activity %>"><%= obj.activity %></span></td>
                        <td class="size_width"><%= obj.file_size %>&nbsp;</td>
                        <td  class="dload_width">
                         <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>   
                        <% if(obj.download_url != '') { %>
                            <a href="<%= obj.download_url %>" rel="tooltip" title="<?php echo __('Download');?>" data-url="<%= obj.download_url %>" target="_blank">
                        <% } else { %>
                            <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Download');?>" data-url="<%= obj.link_url %>" onclick="downloadImage(this);">
                        <% } %>
                                <i class="material-icons">&#xE884;</i>
                            </a>
                        <?php }else{  ?>
						---
						<?php } ?>
                        </td>
                    </tr>
                    <% chkDateTime = newUpdDt; totids= totids+caseAutoId+"|"; %>
                <% } %>
            </tbody>
            </table>
    </div>
    
    <% $("#files_paginate").html(''); %>
    <% if(parseInt(caseCount)>0) { %>
        <% var pageVars = {pgShLbl:total_files,csPage:casePage,page_limit:page_limit,caseCount:caseCount};
            $("#files_paginate").html(tmpl("paginate_tmpl", pageVars)).show();
        %>
    <% } else if(file_srch.trim()){ %>
        <div class="row">
            <div class="col-lg-12">
                <div class="no_usr fl cmn_bdr_shadow">
                    <?php echo $this->element('no_data', array('nodata_name' => 'files-search')); ?>
                </div>
            </div>
        </div>
    <% } else if(!file_srch.trim()) {%>
        <div class="row">
            <div class="col-lg-12">
                <div class="no_usr fl cmn_bdr_shadow">
                    <?php echo $this->element('no_data', array('nodata_name' => 'files')); ?>
                </div>
            </div>
        </div>
    <% } %>

    <input type="hidden" name="hid_cs" id="hid_cs" value="<%= count %>"/>
    <input type="hidden" name="totid" id="totid" value="<%= totids %>"/>
    <input type="hidden" name="chkID" id="chkID" value=""/>
</div>