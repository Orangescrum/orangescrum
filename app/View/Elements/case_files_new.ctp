<div class="sec_title tog" data-cmnt_id ="files_sec">
	<div class="heading_title">
		<span class="sec_icon file_icon"></span>
		<h3>Files</h3>
	</div>
	<div class="icon_collapse " ></div>
</div>
<div class="toggle_details mt-20">
	<div class="detail_list_table">
<% console.log(all_new_files);
if (all_new_files.length > 0) { %>

	<table class="width-100-per layout_fixed">
		<thead>
			<tr>
				<!-- <th class="width-5-per"></th> -->
				<th>Task#</th>
				<th class="width-50-per text-center">File Name</th>
				<th class="text-center">User</th>
				<th class="text-center">Download</th>
			</tr>
		</thead>
		<tbody>
			<?php /*<tr class="date_separetor">
									<td colspan="5">
										<strong>5 Sep 2021</strong>
									</td>
								</tr> */?>
				<% for(var file in all_new_files){
                    var getFiles = all_new_files[file];
                    caseFileName = getFiles.CaseFile.file;
                           caseFileUName = getFiles.CaseFile.upload_name;
						   var caseFileFormat = getFiles.CaseFile.format_file;
                           downloadurl = getFiles.CaseFile.downloadurl;
                           var d__fil_name = getFiles.CaseFile.display_name; %>
                        <% if(!d__fil_name){d__fil_name = caseFileName;} %>
                        <% if(caseFileUName == null){caseFileUName = caseFileName;} %>
                        <?php if($this->Format->isAllowed('View File',$roleAccess)){ ?>
					<tr>
						<?php /*<td>
							<div class="more_action dropdown mtop5">
								<div class="cursor" data-toggle="dropdown" aria-haspopup="true">
									<i class="material-icons">
										more_vert</i>
								</div>
								<ul class="dropdown-menu">
									<li>
										<a href="javascript:void(0)">test 1</a>
									</li>
									<li>
										<a href="javascript:void(0)">test 2</a>
									</li>
									<li>
										<a href="javascript:void(0)">test 3</a>
									</li>
								</ul>
							</div>
						</td> */?>
						<td>
							<div><%= csNoRep %></div>
						</td>
						<td>
							<div class="file_type_icon">
								<% if(caseFileFormat == 'xls' ) {%>
									<img src="<?php echo HTTP_ROOT;?>img/excel.png" width="20" height="20"><%= caseFileUName %>
								<% } else if((caseFileFormat =='png' || (caseFileFormat =='jpg'))){ %>
									<img src="<?php echo HTTP_ROOT;?>img/png.png" width="20" height="20"><%= caseFileUName %>
								<% }else if(caseFileFormat == 'pdf'){ %>
									<img src="<?php echo HTTP_ROOT;?>img/pdf.png" width="20" height="20"><%= caseFileUName %>
								<% }else if(caseFileFormat == 'pptx'){ %>
									<img src="<?php echo HTTP_ROOT;?>img/ppt.png" width="20" height="20"><%= caseFileUName %>
								<% }else{ %>
									<img src="<?php echo HTTP_ROOT;?>img/<%= caseFileFormat%>.png" width="20" height="20"><%= caseFileUName %>
								<% } %>
							</div>
						</td>
						<td class="text-left">
							<div class="username">
								<%= csby %>
							</div>
						</td>
						<td class="action_td">
						<% if(is_inactive_case == 0 && is_active == 1) {%>
                        <% if(downloadurl){ %>
							 <a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>href="<%= downloadurl %>" <?php } ?>target="_blank" alt="<%= caseFileName %>" title="<%= caseFileName %>"><div class="download_icon"></div></a> 
                             <% } else { %>
                                <a <?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>href="<?php echo HTTP_ROOT; ?>easycases/download/<%= caseFileUName %>" <?php } ?> alt="<%= d__fil_name %>" title="<%= d__fil_name %>" rel="prettyImg[<%= csAtId %>]"><div class="download_icon"></div></a> 
                                <% } %>
								<% } %>
						</td>
						
					</tr>
                        <?php } ?>
                    <% } %>
					

		</tbody>
	</table>
	
	<?php /*<div class="hr_separetor_line"></div>
	<div class="text-right">
		<div class="show_moreless">Show more</div>
	</div> */?>
	<% } else { %>
		<div class="nodetail_found">
			<figure>
				<img src="<?php echo HTTP_ROOT;?>img/tools/No-details-found.svg" width="120"
				 height="120">
			</figure>
			<div class="colr_red mtop15">No Files found</div>
		</div>
		<% } %>
	</div>
</div>