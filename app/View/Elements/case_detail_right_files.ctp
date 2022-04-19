  <% 
for(var k in threadDetails){
    var getdata = threadDetails[k];
	var all_files = getdata.Easycase.rply_files;
   if(all_files.length) { 
	$(".nofiletxt").remove();
   %>
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
						 %>
							<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>
						<div class="fl smal-addtask-file atachment_<%=getFiles.CaseFile.id%>">
								<div class="atachment_det">
										<div class="aat_file rht-aat_file">
								<% if(getFiles.CaseFile.is_ImgFileExt){ %>
										<% if(downloadurl){ %>
                                                        <a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?> href="<%= downloadurl %>"<?php }?> target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>" rel="prettyImg[]">
														<% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){%>
																<center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= caseFileName %>" alt="Loading image.." /></center>
														<% }else{ %>
																<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= caseFileName %>" alt="Loading image.." />
														<% } %>
														<span class="ellipsis-view"><%= caseFileName %></span>
												</a>
										<% } else { %>
                                                        <a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>"<?php }?> alt="<%= d__fil_name %>" title="<%= d__fil_name %>">
														<% if (typeof getFiles.CaseFile.fileurl_thumb != 'undefined' && getFiles.CaseFile.fileurl_thumb != ''){ %>
																<center><img src="<%= getFiles.CaseFile.fileurl_thumb %>" class=" asignto" title="<%= d__fil_name %>" alt="Loading image.." /></center>
														<% }else{ %>
																<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=&file=<%= caseFileUName %>&sizex=180&sizey=120&quality=100" class="lazy asignto thumb-img" title="<%= d__fil_name %>" alt="Loading image.." />
														<% } %>
														<span class="ellipsis-view"><%= d__fil_name %></span>
												</a>
										<% } %>
								<% } else{ %>
												<% if(downloadurl) { %>
														<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?> href=" <%= downloadurl %> "<?php } ?> target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>">
																<img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
																<span class="ellipsis-view"><%= caseFileName %></span>
														</a>
												<% } else { %>
														<a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?> href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>"<?php } ?> alt="<%= d__fil_name %>" title="<%= d__fil_name %>">
																<img class="thumb-img" src="<?php echo HTTP_IMAGES; ?>images/task_dtl_imgs/<%= easycase.imageTypeIcon(getFiles.CaseFile.format_file) %>_64.png" alt="Loading image.." />
																<span class="ellipsis-view"><%= d__fil_name %></span>
														</a>
												<% } %>
								<% } %>
										<div class="rht_file_cnt"></div>
										</div>
								</div>
						</div>
				<?php } ?>
				<% } %>
		<% } %>
		
<% }
}							
%> 