<div class="cmn_sec_card selected  mtop20" id="cmt_sec">
	<div class="sec_title tog" data-cmnt_id ="cmt_sec">
		<div class="heading_title">
			<span class="sec_icon comment_icon"></span>
			<h3 id="tour_taskdetail_comment">
				Comment
				<div class="counter_badge" id="cmnt_count">
					<%= cmnt_count %>
				</div>
			</h3>
		</div>
		<div class="icon_collapse " ></div>
	</div>
    <div class="toggle_details">
		<div id="tour_detl_logs<%= csUniqId %>" class="">
				<input type="hidden" name="data[Easycase][sel_myproj]" id="CS_project_id<%= csAtId %>" value="<%= projUniqId %>" readonly="true">
				<input type="hidden" name="data[Easycase][myproj_name]" id="CS_project_name<%= csAtId %>" value="<%= htmlspecialchars(projName) %>"
				 readonly="true">
				<input type="hidden" name="data[Easycase][case_no]" id="CS_case_no<%= csAtId %>" value="<%= csNoRep %>" readonly="true" />
				<input type="hidden" name="data[Easycase][type_id]" id="CS_type_id<%= csAtId %>" value="<%= csTypRep %>" readonly="true"
				/>
				<input type="hidden" name="data[Easycase][title]" id="CS_title<%= csAtId %>" value="" readonly="true" />
				<input type="hidden" name="data[Easycase][priority]" id="CS_priority<%= csAtId %>" value="<%= csPriRep %>" readonly="true"
				/>
				<input type="hidden" name="data[Easycase][org_case_id]" id="CS_case_id<%= csAtId %>" value="<%= csAtId %>" readonly="true"
				/>
				<input type="hidden" name="data[Easycase][istype]" id="CS_istype<%= csAtId %>" value="2" readonly="true" />
				<div class="cb"></div>

				<% if(is_active){ %>
					<div class="" id="reply_box<%= csAtId %>" <?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?> style="display:block;"
						<?php }else{ ?>style="display:none;"
						<?php } ?>>
						<div class="user_task_comments pr align-item-center d-flex">
							<div class="user-task-pf commenter-img profile-alpha">
								<% if(!usrFileExst){ var usrPhoto = 'user.png'; } %>
									<% var usr_name_fst = usrName.charAt(0); %>
										<% if(!usrFileExst){ %>
											<span class="cmn_profile_holder <%= usrPhotoBg %>">
												<%= usr_name_fst %>
											</span>
											<% }else{ %>
												<img data-original="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<%= usrPhoto %>&sizex=55&sizey=55&quality=100"
												 class="lazy " width="55" height="55" title="<%= usrName %>" />
												<% } %>
							</div>
							<div class="task_comment_input">
								<?php /*<div class="editor-type">
									<span class="active">
										<a title="<?php echo __('HTML Editor');?>" rel="tooltip" href="javascript:void(0);"
										 class="fr" id="custom<%= csAtId %>" onclick="changeToRte(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" style="display:none;">
											<?php echo __('HTML');?>
										</a>
									</span>
									<span>
										<a title="<?php echo __('TEXT Editor');?>" rel="tooltip" href="javascript:void(0);"
										 class="fr" id="txt<%= csAtId %>" onclick="changeToRte(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" style="display:none;">
											<?php echo __('Text');?>
										</a>
									</span>
								</div> */?>
								<div>
									<span <% if(is_inactive_case == 0 && is_active == 1) {%> id="showhtml<%= csAtId %>" <% } %> data-task="<%= csAtId %>">
										<input type="text" name="data[Easycase][message]" id="<%= 'txa_comment'+csAtId %>" placeholder="Write your comment here ..."  class="editor_input" >
									</span>			
								</div>
								<div class="comment_form_editor" id="cmt_sec_dis" style="display:none;">
									<div class="">
										<?php /*<label class="control-label" id="label_txa_plane<%= csAtId %>" for="txa_plane<%= csAtId %>">
											<?php echo __('Write your comment here...');?>
										</label> */?>

										<span id="html<%= csAtId %>" style="display:block;">
											<span class="d-block" id="hidhtml<%= csAtId %>">
												<textarea name="data[Easycase][message]" id="<%= 'txa_comments'+csAtId %>" rows="2" class="form-control txt_are <?php if(SES_COMP == 23823 || SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>"></textarea>
												<span id="htmlloader<%= csAtId %>" style="color:#999999; display: none; float:left;">
													<?php echo __('Loading');?>...</span>
											</span>
											
										</span>
										<span id="plane<%= csAtId %>" style="display:none;">
											<textarea name="data[Easycase][message]" id="txa_plane<%= csAtId %>" rows="3" class="form-control"></textarea>
										</span>
										<input type="hidden" value="1" id="editortype<%= csAtId %>" />

									</div>


									<?php if($this->Format->isAllowed('Upload File to Task',$roleAccess)){ ?>
									<div class="">
										<input type="hidden" name="totfiles" id="totfiles<%= csAtId %>" value="0" readonly="true" />
										<?php $is_basic_or_free = (($user_subscription['btprofile_id'] || $user_subscription['is_free'] || $GLOBALS['FREE_SUBSCRIPTION'] == 0) || $user_subscription['is_cancel']) ? 0 : 1; ?>
										<form class="upload<%= csAtId %> attch_form" id="file_upload<%= csAtId %>" action="<?php echo HTTP_ROOT; ?>easycases/fileupload/?<?php echo time(); ?>"
										 method="POST" enctype="multipart/form-data">
											<div class="drag_and_drop" id="holder_detl" style="min-height:125px;">
												<header>
													<?php echo __('Drag and drop files to upload');?>
													<div class="fr">
														<?php if(!in_array(SES_COMP,Configure::read('REMOVE_DROPBOX_GDRIVE'))){ ?>
														<div class="dropbox-gdrive">
															<span id="gloader" style="display: none;">
																<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" style="position: absolute;bottom: 95px;margin-left: 125px;"
																/>
															</span>
														</div>
														<?php } ?>
													</div>
													<div class="cb"></div>
												</header>
												<div class="file_upload_detail drop-file">
													<span class="">
														<?php echo __('Drop files here or');?>
													</span>
													<label class="att_fl" for="tsk_attach<%= csAtId %>">
														<?php echo __('click upload');?>
													</label>
													<div class="customfile-button">
														<input class="customfile-input" name="data[Easycase][case_files]" id="tsk_attach<%= csAtId %>" type="file" multiple="" />
													</div>
													<small>
														<?php echo __('Max size');?>
														<%= MAX_FILE_SIZE %>
															<?php echo __('Mb');?>
													</small>
												</div>
											</div>
										</form>
										<div id="table1">
											<table class="up_files<%= csAtId %>" id="up_files<%= csAtId %>" style="font-weight:normal;"></table>
										</div>
										<div id="drive_tr_<%= csAtId %>">
											<form id="cloud_storage_form_<%= csAtId %>" name="cloud_storage_form_<%= csAtId %>" action="javascript:void(0)" method="POST">
												<div style="float: left;margin-top: 7px;" id="cloud_storage_files_<%= csAtId %>"></div>
											</form>
											<div style="clear: both;margin-bottom: 3px;"></div>
										</div>
									</div>
									<?php } ?>

									<div class="">
										<div class="detail-notify-email">
											<div class="item_title_heading">
												<?php echo __('Notify via Email');?>
											</div>
											<div class="checkbox custom-checkbox all-check-box">
												<label>
													<input type="checkbox" name="chkAllRep" id="<%= csAtId %>chkAllRep" value="all" class="" onclick="checkedAllResReply('<%= csAtId %>')"
													 <% if(allMems.length == usrArr.length) { %> checked="checked"
													<% } %> />
														<?php echo __('All');?>
												</label>
											</div>

											<% 	var i = 0; var UserClients_dtl = '';  var client_span_cont = []; var client_span_contId = []; %>
												<% if(countJS(allMems)){ %>
													<div id="mem<%= csAtId %>">
														<div id="viewmemdtls<%= csAtId %>" class="d-flex">
															<% for(var memkey in allMems){ %>
																<% var getAllMems = allMems[memkey]; %>
																	<% if(getAllMems.CompanyUser.is_client== "1"){client_span_cont.push(getAllMems.User.name); client_span_contId.push(getAllMems.User.id); } %>
																		<% if(getAllMems.User.is_client != 1 || (client_status != 1)){ %>
																			<% var j = i%3; %>
																				<div class="checkbox custom-checkbox  add-user-pro-chk">
																					<label>
																						<input type="hidden" name="data[Easycase][proj_users][]" id="proj_users" value="<%= getAllMems.User.id %>" readonly="true"
																						/>
																						<input type="checkbox" name="data[Easycase][user_emails][]" id="<%= csAtId %>chk_<%= getAllMems.User.id %>" value="<%= getAllMems.User.id %>"
																						 style="cursor:pointer;" class="chk_fl <% if(getAllMems.CompanyUser.is_client== "1"){%>chk_client<%}%>" onClick="removeAllReply('<%= csAtId %>')" <% if($.inArray(getAllMems.User.id,usrArr)!=-1){ %> checked<% } %> />
																							<%= shortLength(getAllMems.User.name,12) %>
																					</label>
																				</div>
																				<% i = i+1; var k = i%3; %>
																					<% } %>
																						<% }%>
																							<% var client_emails_show = '';
                                                                if(UserClients_dtl != ''){
                                                                    $('#make_client_dtl').attr('checked',false);
                                                                    if(UserClients_dtl.length >= 19){
                                                                        client_emails_show = '('+UserClients_dtl.substr(0,16)+'...)';
                                                                    }else{
                                                                        client_emails_show = '('+UserClients_dtl+')';
                                                                    }
                                                                } %>
																								<input type="hidden" name="hidtotresreply" id="hidtotresreply<%= csAtId %>" value="<%= i %>" readonly="true" />
														</div>
													</div>
													<% } %>
										</div>

										<% if(client_span_cont.length >0 && $.inArray(SES_ID, client_span_contId) == -1){ %>
											<div class="cb"></div>
											<div class="col-lg-7 col-sm-7 col-xs-7 padlft-non notify_email blank_red-tag">
												<div id="clientdiv_dtl<%= csAtId %>" class="checkbox">
													<label class="mb-15">
														<input type="checkbox" name="chk_all" id="make_client_dtl<%= csAtId %>" value="0" onclick="chk_client_reply(<%= csAtId %>);"
														/>
														<?php echo __('Do not show this comment to the client');?>&nbsp;
														<?php /*<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/knowledge-base/how-to-create-a-new-task/#don\'t_show_task_to_client');" title="<?php echo __("Get quick help on Don't show the task to client");?>" rel="tooltip" ><span class="help-icon"></span></a> */ ?>
													</label>
													<%
                            													if(client_span_cont){
                            													for(var csk in client_span_cont){ %>
														<span class="color_tag" title="">
															<%= client_span_cont[csk] %>
														</span>
														<% } } %>
												</div>
											</div>
											<% } %>

									</div>
									<div class="d-flex post-canel-btn mt-30">
										<div class="ml-auto">
										<div class="d-inline-block" id="postcomments<%= csAtId %>">
											<span class="d-inline-block">
												<a class="btn btn-default btn_hover_link cmn_size toglle_on_click" data-cs_id="<%= csAtId %>" href="javascript:void(0)" id="rset">
													<?php echo __('Cancel');?>
												</a>
											</span>
											<?php if($this->Format->isAllowed('Reply on Task',$roleAccess)){ ?>
											<span class="d-inline-block">
												<button class="btn btn_cmn_efect cmn_bg btn-info cmn_size comnt_submit_btn toglle_on_click" type="submit" name="data[Easycase][postdata]" onclick="return validateComments(<%= '\''+csAtId+'\',\''+csUniqId+'\',\''+csLgndRep+'\',\''+SES_TYPE+'\',\''+csProjIdRep+'\'' %>);">
													<i class="icon-big-tick"></i>
													<?php echo __('Post comment');?>
												</button>
											</span>
											<?php } ?>
										</div>
										<div class="d-inline-block">
											<span id="loadcomments<%= csAtId %>" style="display:none;">
												<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..."
												 title="<?php echo __('Loading');?>..." style="padding:5px;" />
											</span>
											<input type="hidden" value="<%= total %>" id="hidtotrp<%= csAtId %>" />
										</div>
										</div>
									</div>
								</div>



								
							</div>
							<div class="cb"></div>
						</div>
					</div>

					<% } %>
            </div>


            
		<div class="comments_list">
			<?php /* <div class="col-lg-4 col-sm-4">
                                    <h4><?php echo __('Comments');?>
									 <% if(cntdta) { %>
                                	<p class="tsk-dtl-reply-cnt"><span><i class="material-icons">&#xE0B7;</i></span><span class="tsk-dtl-reply-cnt-lbl">(<small><%= total %></small>)</span></p>
									<% } %>
									</h4>    
						</div> */ ?>
			<% if(total > 10){ %>
				<div>
				<div class="d-flex text-right mt-30">
					<div class="ml-auto">
						<div class="d-flex">
							<div class="view_rem">
								<a id="morereply<%= csAtId %>" style="<% if(cntdta > 10) { %>display:none<% } %>;" class="cmn_outline_cta" href="javascript:void(0);"
								 onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'more\'' %>)">
									<% remaining = total-10; %>
										<?php echo __('View remaining');?>
										<%= remaining %>
											
											<% if(remaining == 1) {%>
												<?php echo __('thread');?>
												<% } else if(remaining > 1) {%>
												<?php echo __('threads');?>
												<% } %>
								</a>
								<span id="hidereply<%= csAtId %>" <% if(cntdta <= 10) { %> style="display:none"<% } %>>
										<a class="cmn_outline_cta" href="javascript:void(0);" onclick="showHideMoreReply(<%= '\''+csAtId+'\',\'less\'' %>)">
											<?php echo __('View latest 10');?>
										</a>
								</span>
								<span class="rep_st_icn"></span>
								<span id="loadreply<%= csAtId %>" style="visibility: hidden;">
									<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16"
									 alt="loading..." title="<?php echo __('loading');?>..." />
								</span>
							</div>
							<div class="view_rem">
								<span id="repsort_desc_<%= csAtId %>" <%=ascStyle %>>
									<a href="javascript:void(0);" class="cmn_outline_cta" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View oldest thread on top');?>">
										<?php echo __('Older');?>
									</a>
								</span>
								<span id="repsort_asc_<%= csAtId %>" <%=descStyle %> >
									<a href="javascript:void(0);" class="cmn_outline_cta" onclick="sortreply(<%= '\''+csAtId+'\'' %>,<%= '\''+csUniqId+'\'' %>)" rel="tooltip" title="<?php echo __('View newest thread on top');?>">
										<?php echo __('Newer');?>
									</a>
								</span>
								<span class="rep_st_icn"></span>
								<span id="loadreply_sort_<%= csAtId %>" style="visibility: hidden;">
									<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16"
									 alt="loading..." title="<?php echo __('loading');?>..." />
								</span>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" value="less" id="threadview_type<%= csAtId %>" />
				<input type="hidden" value="<%= thrdStOrd %>" id="thread_sortorder<%= csAtId %>" />
				<input type="hidden" value="<%= remaining %>" id="remain_case<%= csAtId %>" />
				</div>
				<% } %>
			<div class="reply_cont_bg fs-hide mt-30" id="reply_content<%= csAtId %>">
				<div id="showhidemorereply<%= csAtId %>">
					<?php echo $this->element('case_reply'); ?>
				</div>
			</div>
		</div>
	</div>
		
</div>