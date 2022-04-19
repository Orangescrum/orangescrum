<style>
.create-task-form-main {box-sizing: border-box;display: -webkit-box;    display: -ms-flexbox;display: flex;-webkit-box-flex: 0;-ms-flex: 0 1 auto;flex: 0 1 auto;-webkit-box-orient: horizontal;-webkit-box-direction: normal;-ms-flex-direction: row;flex-direction: row;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-left: -7.5px;margin-right: -7.5px;}

.create-task-form-main > .w_a {width:33.33%;-ms-flex-preferred-size: 33.33%;flex-basis: 33.33%;box-sizing: border-box;padding:0 7.5px;position: relative;}
.create-task-form-main > .w_b {width:66.66%;-ms-flex-preferred-size: 66.66%;flex-basis: 66.66%;box-sizing: border-box;padding:0 7.5px;position: relative;}
.create-task-form-main > .w_c {width:100.00%;-ms-flex-preferred-size: 100.00%;flex-basis: 100.00%;box-sizing: border-box;padding:0 7.5px;position: relative;}

#showhide_task_conf,#showhide_project_conf{display:inline-block;position:absolute;right:20px;top:12px;
z-index: 1000000;}
#showhide_task_conf a,#showhide_project_conf a{text-decoration:none;font-size:14px;line-height:20px;color:#099DFF;border: 1px solid #D9F0FF;background:#D9F0FF;padding: 5px 15px;border-radius: 20px;display: block;}
#showhide_task_conf a:hover, #showhide_project_conf a:hover{box-shadow:0px 5px 10px rgba(218, 219, 220, 0.19)}
#showhide_task_conf .material-icons,#showhide_project_conf .material-icons{font-size:20px;margin-right: 3px;}
#dropdown_menu_task_configuration,#dropdown_menu_project_configuration{width: 400px;left: initial;right: 0;
top:45px;padding:5px 0px 5px 5px;margin:0;}
#dropdown_menu_task_configuration li,#dropdown_menu_project_configuration li{display:inline-block;vertical-align:middle;width: calc(50% - 5px);    border-bottom: none;padding:5px 5px 5px 15px}
#dropdown_menu_task_configuration li.li_check_radio:first-child,
#dropdown_menu_task_configuration li.li_check_radio:nth-child(2),
#dropdown_menu_project_configuration li.li_check_radio:first-child,
#dropdown_menu_project_configuration li.li_check_radio:nth-child(2){padding-left:5px}
.close_config{position:absolute;right:10px;top:10px;font-size:18px;line-height:20px;color:#ff0000;cursor:pointer;display: inline-block; z-index: 1;}
#dropdown_menu_task_configuration li:hover,#dropdown_menu_project_configuration li:hover{color:#1A73E8}
#showhide_task_conf .save_configure_btn{display:block;width:100%;text-align:right;padding:15px 15px 15px}
#showhide_task_conf .save_configure_btn .btn_cmn_efect{margin:0}
.create-task-form .create-task-form-main .labl-rt.custom-task-fld {margin-top: 25px;}
.create-task-form-main .mtop15{margin-top:25px}
.create-task-form-main .row{margin:0 -7.5px}
.create-task-form-main .row .col-md-6,
.create-task-form-main .row .col-md-4,
.create-task-form-main .row .col-md-3,
.create-task-form-main .row .col-md-2{padding:0 7.5px}
.cmn_create_task_form .field_wrapper{margin-bottom:0}
#tour_crt_recur .custom-checkbox{float:none}
.create-task-container .cmn_create_task_form .task-editor-form {margin: 10px 0 0;}
.create-task-container .cmn_help_select + .onboard_help_anchor {top: -14px;right: 10px;}
.left-134{left:-134px; padding-top:3px;}
.crtskmenus.left-134 li{padding: 6px;}
.left-5{margin-left:-5px;}
.save_exit_btn.sticly_cta_btn:hover {box-shadow: none !important;}
 .help-video-pop.inpopup{position: absolute;right: 160px;top: 25px;z-index: 99; pointer-events: auto;}

</style>

<script type="text/javascript" src="<?php echo HTTP_ROOT.'js/jquery-ui-1.10.3.js';?>" defer></script>
<script type="text/javascript">
	$(function () {
		$(".field_wrapper .field_placeholder").on("click", function () {
			$(this).closest(".field_wrapper").find("input").focus();
		});
		$(".field_wrapper input").on("keyup", function () {
			var value = $.trim($(this).val());
			if (value) {
				$(this).closest(".field_wrapper").addClass("hasValue");
			} else {
				$(this).closest(".field_wrapper").removeClass("hasValue");
			}
		});
		$('.crt_popup_close .close').tipsy({gravity:'w', fade:true});
	});
</script>
<?php if(defined('RELEASE_V') && RELEASE_V){?>
<div class="cmn_create_task_form pr">
<?php if($this->Format->displayHelpVideo()){ ?>
<a href="javascript:void(0);" class="help-video-pop inpopup" video-url = "https://www.youtube.com/embed/q51UVLWABAE" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
<?php } ?> 

<?php if(
			!$this->Format->isAllowed('Change Assigned to',$roleAccess) || 
      !$this->Format->isAllowed('Update Task Duedate',$roleAccess) ||
			!$this->Format->isAllowed('Change Other Details of Task',$roleAccess) ||
			!$this->Format->isAllowed('Move to Milestone',$roleAccess) ||
			!$this->Format->isAllowed('Est Hours',$roleAccess) ||
			!$this->Format->isAllowed('Manual Time Entry',$roleAccess) || 
			!$this->Format->isAllowed('Link Task',$roleAccess) || 
			!$this->Format->isAllowed('Add Label',$roleAccess) 
			){ ?>
			<div class="ur-not-msg"><span><i class="material-icons">error</i><?php echo __("Your admin or owner has not allowed you to update certain task fields. Contact your admin or owner for enhanced permissions.");?></span></div>
			<?php } ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="crt_popup_close">
				<button type="button" class="close close-icon back-btn" title="<?php echo __('Close');?>" onclick="crt_popup_close('CT');"><i class="material-icons">&#xE14C;</i></button>
			</div>
			<?php /* if(!isset($_COOKIE['FIRST_INVITE_2'])){ ?>
				<div class="crt_tsk_quq_tur">
					<a class="refer_frnd" href="javascript:void(0);" onclick="startTourCrtTask();">
						</a>
				</div>
			<?php } */ ?>
			
			<div class="fl">
				<h4 id="taskheading"><?php echo __('Create Task');?></h4>
			</div>
			<span id="showhide_task_conf" class="dropdown">
            <a href="javascript:jsVoid();" title="<?php echo __('Task Configuration');?>" onclick="" class="dropdown-toggle" data-toggle="dropdown"><i class="material-icons">visibility_off</i> <?php echo __("Show/Hide");?></a>
            <ul class="dropdown-menu drop_menu_mc" id="dropdown_menu_task_configuration">
            	<span class="close_config" onclick="$('#showhide_task_conf').removeClass('open');">&times;</span>
            	 <li class="li_check_radio border-bottom">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="selectedcols_all" value="all" id="column_all_fields"  style="cursor:pointer"> <?php echo __("All");?>
                    </label>
                  </div>
              </li>
               <li class="li_check_radio border-bottom padbtmset">
                  
              </li>
            <?php $taskFileds = Configure::read('TASK_FIELDS');	
            $selectedColumns = explode(',',$defaultfields['TaskField']['form_fields']);
            	foreach($taskFileds as $k=>$v){ 
            		if($v['is_default'] == 0){ ?>
              <li class="li_check_radio">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="selectedcols configfields" value="<?php echo $v['id'];?>" id="column_all_<?php echo $v['id'];?>"  style="cursor:pointer" <?php if(in_array($v['id'],$selectedColumns) || empty($selectedColumns)){ ?> checked="checked" <?php } ?> onchange="showHideTaskFields(<?php echo $v['id'];?>)" > <?php echo $v['label']; ?>
                    </label>
                  </div>
              </li>
          <?php }} ?>
					<?php /*<li class="save_configure_btn">
          			<input type="button" class="btn btn_cmn_efect cmn_bg btn-info show_btn" value="Save" onclick="saveTaskConfiguration();">                     
					</li> */?>
          </ul>
      </span>
			<!--                     <div class="fl add_task_project">
			<span class="add_task_project_span"><?php echo __('on project');?> </span>
			<select class="prj-select form-control floating-label">
			<?php if(count($getallproj) != 0){
			foreach($getallproj as $getPrj){ ?>
			<option value="<?php echo $getPrj['Project']['uniq_id']; ?>" data-methodlogy="<?php echo $getPrj['Project']['project_methodology_id']; ?>"><?php echo $this->Format->shortLength($getPrj['Project']['name'],27); ?></option>
			<?php } 
			} ?>
			</select>

			</div>-->
			<?php /* <div class="fr back-btn">
			<a href="javascript:void(0)" >
			<i class="material-icons">&#xE5CD;</i>
			</a>
			</div> */ ?>
			<div class="cb"></div>
		</div>
		<div class="cb"></div>
		<!--<div class="row">
			<div class="col-md-4" style="margin:30px 0 0 60px">
				<div class="field_wrapper">
					<input type="email" name="email" id="">
					<div class="field_placeholder"><span>Enter your email</span></div>
					<div class="inp_icon"><i class="material-icons">clear</i></div>
				</div>
			</div>
		</div>-->
	</div> 
	<div class="flex_scroll">
	<div class="row">
		<div class="col-md-12">
		<div class="create-task-form">
			<form>    
				<div class="create-task-form-main proj_task_ttle_row">
					<div class="w_a task-field-1 mtop15 task-field-all">
						<div class="add_task_project select_field_wrapper mark_mandatory">
							 <select class="prj-select form-control floating-label" placeholder="<?php echo __('Project');?>">
							<?php if(count($getallproj) != 0){
								foreach($getallproj as $getPrj){ ?>
									<option value="<?php echo $getPrj['Project']['uniq_id']; ?>" data-methodlogy="<?php echo $getPrj['Project']['project_methodology_id']; ?>"><?php echo $this->Format->shortLength($getPrj['Project']['name'],27); ?></option>
							<?php } 
								} ?>
							</select>
						</div>
					</div>
					<div class="w_b task-field-2 mtop15">
						<div class="custom-task-fld title-fld top-tsk-ttl ct-title">
							<div class="field_wrapper nofloat_wrapper">
								<input class="<?php if(SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>" id="CS_title" type="text" maxlength='240' onblur='blur_txt();checkAllProj();' onfocus='focus_txt()' onkeydown='return onEnterPostCase(event)' onkeyup='checktitle_value();' />
								<div class="field_placeholder mark_mandatory"><span><?php echo __('Task Title');?></span></div>
								<?php /*<div class="inp_icon"><i class="material-icons">clear</i></div> */ ?>
							</div>
						</div>
					</div>
				

			
					
					
						<input type="hidden" name="data[Easycase][istype]" id="CS_istype" value="1" readonly="true"/>
						<input type="hidden" readonly="readonly" value="<?php echo $projUniq1; ?>" id="curr_active_project"/>
						<div class="col-lg-5 padlft-non custom-task-fld proj-fld-fld labl-rt" style="display:none;">
							<span class="os_sprite crt-proj-icon"></span>
						</div>
						
						
						
						
						<div id="tour_crt_asign" class="w_a task-field-3 mtop15 task-field-all custom-task-fld assign-to-fld labl-rt add_new_opt <?php if(!$this->Format->isAllowed('Change Assigned to',$roleAccess)){ ?>no-pointer<?php } ?> ">
							<div class="select_field_wrapper">
								<select class="crtskasgnusr form-control floating-label remove-dp" placeholder="<?php echo __('Assign To');?>"  onchange="showHideTimelogBlock(this);notifi_cq_users(this);">                                        
								</select>
							</div>
						</div>
						
						
						<div id="tour_crt_type" class="w_a task-field-4 mtop15 task-field-all custom-task-fld task-type-fld labl-rt task_type cstm-drop-pad <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>no-pointer<?php } ?>">
							<div class="select_field_wrapper mark_mandatory">
								<select class="tsktyp-select form-control floating-label" placeholder="<?php echo __('Task Type');?>" data-dynamic-opts=true onchange="changeTypeId(this)" id="inline-add-tsk">
									<?php
										foreach($GLOBALS['TYPE'] as $k=>$v){
											if($v['Type']['project_id'] ==0 || $v['Type']['project_id']==$getallproj[0]['Project']['id']){ 
											foreach($v as $key=>$value){
												foreach($value as $key1=>$result){
													if($key1=='name'&& $key1='short_name'){
														//$im = $value['short_name'].".png";
														if (trim($value['short_name']) && file_exists(WWW_ROOT."img/images/types/".$value['short_name'].".png")) {
															$im1= $this->Format->todo_typ_src($value['short_name'],$value['name']); ?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php } else {
														//$im1 = HTTP_IMAGES.'images/types/default.png';
															$cl_cs = 'taxt_typ_width';
															if(mb_detect_encoding($value['name'], mb_detect_order(), true) == 'UTF-8'){
																	$cl_cs = 'taxt_typ_width_utf';
															} ?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
														<?php }

																 }
														  }
														}
													}
												}?>
								</select>
							</div>
							<div class="cmn_help_select"></div>
							<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/add-view-edit-task-type-task/<?= HELPDESK_URL_PARAM ?>#what_is_task_type');" title="<?php echo __('Get quick help on Task Type');?>" rel="tooltip" ><span class="help-icon"></span></a>
						
						</div>
						<div class="w_a mtop15 story_point_row <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>no-pointer<?php } ?>" id="tour_crt_story_point" style="display:none;">								
							<div class="field_wrapper nofloat_wrapper" rel="tooltip" title="<?php echo __('story point 1 = 1 day');?>.">
								<input type="text" id="story_points" name="data[Easycase][story_point]" pattern="[0-9]" maxlength="5" class="ttfont" value="<?php if(isset($taskdetails['story_point']) && $taskdetails['story_point']){echo $taskdetails['story_point'];}?>" style="padding-right:0" onkeypress="return numeric_only(event)">
								<div class="field_placeholder"><span><?php echo __('Story Points');?></span></div>
							</div>
						</div>
						
						
						<div id="tour_crt_prio" class="w_a task-field-5 mtop15 task-field-all pririty-fld labl-rt add_new_opt create_priority mtop20 <?php if(!$this->Format->isAllowed('Change Other Details of Task',$roleAccess)){ ?>no-pointer<?php } ?>">
							<div class="priority_field_wrapper">
								<label class="control-label mark_mandatory"><?php echo __('Priority');?></label>
								<div class="form-group pri-div ct-prior-lmh">
									<span class="radio radio-primary custom-rdo priority-low-clr">
										<label>
										  <input name="priority" id="priority_low1" value="2" type="radio" onclick="priority_change(this)" />
										  <?php echo __('Low');?>
										</label>
									</span>
									<span class="radio radio-primary custom-rdo priority-medium-clr">
									   <label>
										<input name="priority" id="priority_mid1" value="1"  type="radio" onclick="priority_change(this)" />
										<?php echo __('Medium');?>
									  </label>
									</span>
									<span class="radio radio-primary custom-rdo priority-high-clr">
									   <label>
										<input name="priority" id="priority_high1" value="0"  type="radio" onclick="priority_change(this)" />
										<?php echo __('High');?>
									  </label>
									</span>
								</div>
							</div>
						</div>
						<div id="tour_crt_tskgrp" class="w_a task-field-8 task-field-all mtop15 <?php if(!$this->Format->isAllowed('Move to Milestone',$roleAccess)){ ?>no-pointer<?php } ?>">
							<div class="select_field_wrapper">
								<select class="crtskgrp form-control floating-label" placeholder="<?php echo __('Task Group');?>" data-dynamic-opts=true onchange="changeMilsestoneId(this)" id="crtskgrp_id" >
														</select>
								<div class="cmn_help_select"></div>
								<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/create-task-group/<?= HELPDESK_URL_PARAM ?>#task_group');" title="<?php echo __('Get quick help on task group');?>" rel="tooltip" ><span class="help-icon"></span></a> 
							</div>
					</div>
				</div>
			</form>
		</div>
		</div>
	</div>
	<!-- Target Here -->
	
	
	<div class="multiple-file-upload up_file_list">
			<table id="up_files" style="font-weight:normal;width: 100%;"></table>
			<form id="cloud_storage_form_0" name="cloud_storage_form_0"  action="javascript:void(0)" method="POST">
			<div style="float: left;margin-top: 7px;" id="cloud_storage_files_0"></div>
			</form>
			<div style="clear: both;margin-bottom: 3px;"></div>
	</div>
                <div class="create-task-editor">
				<div class="create-task-form-main">
				<div class="w_c task-field-6 task-field-all">
                    <div id="tour_crt_desc" style="height:auto;padding:0" class="col-md-8">
                    <?php 
                        if($user_subscription['btprofile_id'] || $user_subscription['is_free'] || $GLOBALS['FREE_SUBSCRIPTION'] == 0) {
                            $is_basic_or_free = 0;
                        } else {
                            $is_basic_or_free = 1;
                        }
                        if($user_subscription['is_cancel']) {
                            $is_basic_or_free = 0;
                        }
                        ?>

                    <script type="text/javascript">
                        var is_basic_or_free = <?php echo $is_basic_or_free; ?>
                    </script>
                        <textarea name="data[Easycase][message]" id="CS_message" onfocus="openEditor()" rows="2" style="resize:none" class="form-control <?php if(SES_COMP == 23823 || SES_COMP == 33179 || SHOW_ARABIC){ ?>arabic_rtl<?php } ?>" placeholder="<?php echo __('Enter Description');?>..."><?php if(isset($taskdetails['message']) && $taskdetails['message']){echo $taskdetails['message']; }?></textarea>
                        <?php /*<form id="file_upload" action="<?php echo HTTP_ROOT."easycases/fileupload/?".time(); ?>" method="POST" enctype="multipart/form-data">
                        <input class="customfile-input fileload fl" id="task_file" name="data[Easycase][case_files]" type="file" multiple=""  /> 
                        </form>*/ ?>
                    </div>
                        <?php if($this->Format->isAllowed('Upload File to Task',$roleAccess)){ ?>
        					<div id="tour_crt_attach" class="col-md-4" style="padding:0">
        							<?php /*<form class="upload<%= csAtId %> attch_form" id="file_upload<%= csAtId %>" action="<?php echo HTTP_ROOT; ?>easycases/fileupload/?<?php echo time(); ?>" method="POST" enctype="multipart/form-data"> */ ?>
        							<form id="file_upload" action="<?php echo HTTP_ROOT."easycases/fileupload/?".time(); ?>" method="POST" enctype="multipart/form-data">
        								<div class="drag_and_drop" id="holder_crt_task" style="min-height:100px;margin:0px;box-shadow: none;">
        									<header class="crt_header">
        										<?php echo __('Attachments');?>
        										<div class="fr">
                              <?php if(!in_array(SES_COMP,Configure::read('REMOVE_DROPBOX_GDRIVE'))){ ?>
        											<div class="dropbox-gdrive">
        												<span id="gloader" style="display: none;">
        													<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" style="position: absolute;bottom: 95px;margin-left: 125px;"/>
        												</span>
        											</div>
                              <?php } ?>
        										</div>
        										<div class="cb"></div>
        									</header>
        									<div class="drop-file crttask_attachment">
        										<span><?php echo __('Drop files here or');?></span>
        										<div class="customfile-button">
        											<?php /* <input class="customfile-input" name="data[Easycase][case_files]" id="tsk_attach<%= csAtId %>" type="file" multiple=""  style="width:110px;height:30px;visibility: visible;"/> */ ?>
        											<input class="customfile-input fileload fl" id="task_file" name="data[Easycase][case_files]" type="file" multiple="" style="visibility:visible;" />
        											<label class="att_fl" for="tsk_attach<%= csAtId %>" style=""><?php echo __('click upload');?></label>
        										</div>
        										<!--<small>Max size 200 Mb</small>-->
        									</div>
        								</div>
        							</form>					
        					</div>
							<div class="clearfix"></div>
                        <?php } ?>
						</div>
						
						</div>
					
                    <div class="task-editor-form">
                        <form>
                            <div class="create-task-form-main">
                                <div id="tour_crt_srtend" class="w_a task-field-7 mtop15 task-field-all <?php if(!$this->Format->isAllowed('Update Task Duedate',$roleAccess)){ ?>no-pointer<?php } ?>">
                                <?php $dues_date = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date"); ?>
									<div class="form-group hidden">
										<label class="control-label" for="due_date"><?php echo __('Due Date');?></label>
									</div>
									<div class="row">
									<div class="col-md-6">
										<div class="field_wrapper nofloat_wrapper">
											<input type="text" id="start_date" name="start_date" class="" placeholder="<?php echo date('M d, Y', strtotime($dues_date)); ?>" value=""  readonly="readonly" onchange="setStartDueDt();"/>
											<div class="field_placeholder"><span><?php echo __('Start Date');?></span></div>
											<div class="inp_icon"><a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#start_date');" title="<?php echo __('Date when task will start');?>" rel="tooltip" ><span class="help-icon"></span></a></div>
										</div>
									</div>
									<div class="from_to hidden">to</div>
									<div class="col-md-6">
										<div class="field_wrapper nofloat_wrapper">
											<input class="" id="due_date" type="text" placeholder="<?php echo date('M d, Y', strtotime($dues_date)); ?>" readonly="readonly" onchange="setStartDueDt();" >
											<div class="field_placeholder"><span><?php echo __('Due Date');?></span></div>
											<div class="inp_icon"><a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#due_date');" title="<?php echo __('Date when task will be finished');?>" rel="tooltip" ><span class="help-icon"></span></a></div>	
										</div>
									</div>
								</div>
                                </div>
                                <div id="tour_crt_estmtd" class="w_a task-field-9 mtop15 task-field-all <?php if(!$this->Format->isAllowed('Est Hours',$roleAccess)){ ?>no-pointer<?php } ?>">
                                    <div class="field_wrapper nofloat_wrapper" rel="tooltip" title="<?php echo __('You can enter time as 1.5  (that  mean 1 hour and 30 minutes)');?>.">
										<input type="text" onkeypress="return numeric_decimal_colon(event),mins_validation(this)" id="estimated_hours" name="data[Easycase][estimated_hours]" maxlength="5" class="ttfont est check_minute_range" value="<?php if(isset($taskdetails['estimated_hours']) && $taskdetails['estimated_hours']){echo $taskdetails['estimated_hours'];}?>" placeholder="hh:mm" onchange="mins_validation(this);setStartDueDt();">
										<div class="field_placeholder"><span><?php echo __('Estimated Hours');?></span></div> 
                                    </div>
                                </div>
                            <div class="task-field-11 task-field-all w_c mtop15">
                            <div class='timelog_block <?php if(!$this->Format->isAllowed('Manual Time Entry',$roleAccess)){ ?>no-pointer<?php } ?>'>
                            <div class="timelog_toggle_block pr">
                                <?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
                                <div class="custom-overlay"></div>
                                <?php } ?>
															<div class="row">
                                <div id="tour_crt_timrng" class="col-md-4  time_range_fld">
									<div class="field_wrapper nofloat_wrapper">
										<?php $start_placeholder = (SES_TIME_FORMAT == 12)?'08:00am':'13:00';?>
										<input type="text" id="start_time" name="data[TimeLog][start_time]" onchange="updatetime('start_time');" class="from_range ttfont w105 tl_start_time" placeholder="<?php echo $start_placeholder;?>" value="<?php if(isset($taskdetails['start_time']) && $taskdetails['start_time']){echo $taskdetails['start_time'];}?>" >
										<div class="field_placeholder"><span><?php echo __('Time Log');?></span></div>
										<div class="from_to">to</div>
										<?php $end_placeholder = (SES_TIME_FORMAT == 12)?'08:30am':'13:30';?>
										<input type="text" id="end_time" name="data[TimeLog][end_time]" onchange="updatetime('end_time');" class="to_range ttfont w105 tl_end_time" placeholder="<?php echo $end_placeholder;?>" value="<?php if(isset($taskdetails['end_time']) && $taskdetails['end_time']){echo $taskdetails['end_time'];}?>">
										<div class="cb"></div>
									</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="field_wrapper nofloat_wrapper">
                                        <input id="break_time" name="data[TimeLog][break_time]" class=" ttfont w105 tl_break_time check_minute_range brk_hr_mskng " value="" placeholder="hh:mm" maxlength="5" >
										<div class="field_placeholder"><span><?php echo __('Break Time');?></span></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="field_wrapper nofloat_wrapper">
                                        <input type="text" id="hours" name="data[Easycase][hours]" maxlength="6" class="ttfont tl_hours" value="<?php if(isset($taskdetails['hours']) && $taskdetails['hours']){echo $taskdetails['hours'];}?>" placeholder="hh:mm" rel="tooltip" title='<?php echo __('Select Start time and End time, it will calculate spent hours automatically');?>.'>
										<div class="field_placeholder"><span><?php echo __('Spent Hours');?></span></div>
                                    </div>
                                </div>
                                <div id="tour_crt_isbil" class="col-md-2">
                                    <div class="checkbox custom-checkbox">
                                        <label>
                                            <input type="checkbox" id="is_bilable" name="data[LogTime][is_bilable]" class="is_bilable" value="Yes"><?php echo __('Is Billable');?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="cb"></div>
                        </div>
                    </div>
						<!-- LABELS START -->
						<div class="w_c task-field-16 task-field-all custom-task-fld parent-task-fld labl-rt">
						<div id="custom_field_container"></div>
						</div>
					
							<div id="tour_crt_notify" class="w_c task-field-15 task-field-all notify_email add_new_opt">
								<div class="row">
									<div class="col-md-12">
									<div>
										<label id="tour_crt_notify_v2" for="select111" class="control-label"><?php echo __('Notify via Email');?>
										<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#notify_via_email');" title="<?php echo __('Get quick help on Notify via Email');?>" rel="tooltip" ><span class="help-icon"></span></a>  
										</label>
									</div>
									<div class="checkbox all-check">
										<label>
											<input type="checkbox" name="chk_all" id="chked_all" value="all" onclick="checkedAllRes();" />
											<?php echo __('ALL');?>
										</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class='ntfy-usrs'>
										<div id="viewmemdtls" class="checkbox"></div>
									</div>
								</div>
								</div>
								<?php /*<select multiple class="crtskntfyusr select form-control floating-label" placeholder="" data-dynamic-opts=true onchange="checkedAllRes()">
									<option value="all">All</option>
								</select> */ ?>
								<div class="clearfix"></div>
							</div>
                        </div>
						<div class="row mtop30">
							<div class="col-md-7 notify_email blank_red-tag">
								<div id="clientdiv" class="checkbox">
									<label>
										<input type="checkbox" name="chk_all" id="make_client" value="0" onclick="chk_client();" />
										<?php echo __('Do not show the task to the client');?>
										<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-new-task/<?= HELPDESK_URL_PARAM ?>#don\'t_show_task_to_client');" title="<?php echo __("Get quick help on Don't show the task to client");?>" rel="tooltip" ><span class="help-icon"></span></a>
									</label>
								</div>
							</div>							
						<div class="clearfix"></div>
					</div>
                <input type="hidden" name="totfiles" id="totfiles" value="0" readonly="true">
                <input type="hidden" id="is_default_task_type" value="<?php echo $GLOBALS['TYPE_DEFAULT'];?>" readonly="true">
                <input type="hidden" id="CS_type_id" value="<?php if(isset($taskdetails) && $taskdetails['type_id']){echo $taskdetails['type_id'];}else{if (isset($GLOBALS['TYPE_DEFAULT']) && $GLOBALS['TYPE_DEFAULT']==1) {?>2 <?php }else {echo $GLOBALS['TYPE'][0]['Type']['id'];}}?>">
                <input type="hidden" id="CS_priority" value="<?php if(isset($taskdetails) && $taskdetails['priority']){echo $taskdetails['priority'];}else{echo "2";}?>">
                <input type="hidden" id="CS_start_date" value="<?php if(isset($taskdetails) && $taskdetails['start_date']){echo date('m/d/Y',strtotime($taskdetails['start_date']));}else{?>No Start Date<?php }?>">
                <input type="hidden" id="CS_due_date" value="<?php if(isset($taskdetails) && $taskdetails['due_date']){echo date('m/d/Y',strtotime($taskdetails['due_date']));}else{?>No Due Date<?php }?>">
                <input type="hidden" id="CS_milestone" value="<?php if(isset($taskdetails) && $taskdetails['milestone_id']){echo $taskdetails['milestone_id'];} ?>">
                <input type='hidden' id="client" value='0'/>
                <input type="hidden" id="userIds" />
                <input type="hidden" id="userNames" />
                <input type="hidden" id="CSrepeat_due_date" value='' />
                <input type="hidden" id="CSrepeat_start_date" value='' />
                <input type="hidden" id="CSrepeat_type" value='' />
                <input type="hidden" id="CSrepeat_occurrence" value='' />
								<div class="clearfix"></div>
						</form>
				</div>
		</div>
</div>
<div class="popup_sticly_cta">
	<div class="row">
		<div class="media-se-btn col-md-12 text-right">
			<input type="hidden" value="" name="easycase_uid" id="easycase_uid"  readonly="readonly"/>
			<input type="hidden" value="" name="easycase_id" id="CSeasycaseid" readonly="readonly" />
			<input type="hidden" value="" name="cs_index" id="CSindex" readonly="readonly" />
			<input type="hidden" value="" name="editRemovedFile" id="editRemovedFile" readonly="readonly" />
			<span id="quickloading" class="fr" style="display:none;">
				<img src="<?php echo HTTP_IMAGES;?>images/case_loader2.gif" title="<?php echo __('Loading');?>..." alt="Loading..."/>
			</span>
						
			<div class="dib_can_savebtn sticly_cta_btn" id="tour_crt_post" >
				<div class="sticly_cta_btn">
					<div class="checkbox sticly_cta_btn mtop5 m-btm0"  id="create_another_task_dv" >
						<label style="display:block;">
							<input type="checkbox" id="create_another_task"> <?php echo __('Create another');?>
						</label>
					</div>
					<div class="dib_can_savebtn sticly_cta_btn">
						<button class="btn btn-default btn_hover_link cmn_size" onclick="crt_popup_close('CT');" type="button"><?php echo __('Cancel');?></button>
					</div>
					<div class="save_exit_btn sticly_cta_btn">
						<!-- <a id="quickcase" href="javascript:void(0)" class="btn btn-primary btn-raised m_0" onclick ="return submitAddNewCase('Post',0,'','','',1,'');"><?php echo __('Save');?></a> -->
						<a id="quickcase_qt" href="javascript:void(0)" class="btn cmn_size btn_cmn_efect cmn_bg btn-info" onclick="return submitAddNewCase('Post',0,'','','',1,'');"><?php echo __('Save');?></a>
								<!--
								<span class="dropdown">
									<a href="javascript:void(0);" data-target="#" class="btn btn-primary btn-raised dropdown-toggle crtaskmoreoptn left-5" data-toggle="dropdown"><span class="caret"></span></a>
									<ul class="dropdown-menu crtskmenus left-134">
										<li><a href="javascript:void(0);" onclick ="return submitAddNewCase('Post',0,'','','',1,'','','continue');"><?php echo __('Save & Continue');?></a></li>
									</ul>
								</span> -->
					</div>
					<?php /*<span class="dropdown">
								<a href="javascript:void(0);" data-target="#" class="btn btn-primary btn-raised dropdown-toggle crtaskmoreoptn" data-toggle="dropdown"><span class="caret"></span></a>
								<ul class="dropdown-menu crtskmenus">
									<li><a href="javascript:void(0);" onclick ="return submitAddNewCase('Post',0,'','','',1,'','','continue');"><?php echo __('Save & Continue');?></a></li>
									<li><a href="javascript:void(0)" onclick ="creatask();"><?php echo __('Reset');?></a></li>
								</ul>
							</span> */ ?>
				</div>
			</div>
      	
			<div class="cb"></div>
		</div>
	</div>
</div>
</div>
<?php }else{ ?>
<style type="text/css">
    #holder { border: 4px dashed #F8F81E;padding: 8px;height:85px;background: #F0F0F0;}
    #holder.hover { border: 4px dashed #0c0; }
	.form-new-group{background:#F6F7F9;min-height:120px;padding:10px 0 0;}
	.group-ele.f-select{width:230px;margin-left:8px;}
	.group-ele.n-text{width:740px;margin-right:0px;height:auto;}
	.group-ele{width:210px;margin-bottom:7px;}
	.group-ele .form-control{height:24px;padding:3px 5px}
	.group-ele .form-control.w105{width:81px;}
	.group-ele.w200{width:auto;}
	.group-ele.w105{width:auto;}
	.est{height:24px; padding:3px 5px;}
	.gr-lbl{margin:5px 5px 0 5px;}
	.dropdown .opt1 a{min-width:108px;}
	.hrs{width:160px; margin-left:12px;}
	.no-cl{color:#e76161;padding-left: 5px;}
	.no-cl input{position:relative;top:2px;}
	.client-sec{display:inline-block;border:1px solid #ccc;padding:0 10px;background:#fff;margin-left:10px;}
	.submit-block{border-top:1px solid #ddd; padding:5px 5px 0; height:inherit;}
	.case_quick_prj_border{border:1px solid #cccccc !important;padding:8px 12px;}
	.notify-name{border:1px solid #ccc; border-radius:10px;background-color:#fff;padding:3px; margin-left:3px; margin-right:12px;margin-bottom:10px;}
	#viewmemdtls{position:relative;}
	.cwid{width:275px !important;}
	.wid{width:230px !important;}
	.tfont{font-size:13px;}
	.ttfont{font-size:12px;}
	.due{width:70px; padding:5px 0px !important;}
	.ttc.ttfont{font-size:12px; font-weight:lighter;}
	.caret_margin{margin-top:7px;}.ml{margin-left:5px;}
	.fr.caret{margin-left:0px;}
	.task_slide_in button .icon-backto{display:none;}
	#sel_user_feed{margin:0 0;}
	#cloud_storage_files_0{color:blue;font-family:Raleway !important; font-size:12px !important;}
	.fileload{position:fixed;left:700px; cursor:default !important;}
	.btn-dropdown{margin-top:-5px;padding:14px 10px 7px;margin-right:-6px;border-radius:0; background:none repeat scroll 0 0 #3dbb89;}
	.btn-dropdown:hover{background:none repeat scroll 0 0 #25996b;}
	.holder > li{background:none repeat scroll 0 0 #ccc; font-family:Raleway !important; font-size:12.5px !important;}
	.taskoptions{left: 155px !important;position: absolute;top: -2px;}
	#more_opt3{z-index:2000;}#more_opt8{z-index:2000;}#openpopup{z-index:2000;}#more_opt{z-index:2000;}
	.swtchproj{margin-top:10px;}
	.notify_user{font-family:Raleway !important; font-size:13px;padding-left:10px;}
	.user_div{border-radius:5px; margin-right:10px; background-color:grey;margin-top:5px; margin-bottom:5px;}
	.userli{}
	.notify_cls{margin-left:10px !important;}
    .create-new-task select.ui-timepicker-select{width:100%;height:24px;padding:0px 5px;line-height:1.428571429;color:#555555;vertical-align:middle;background-color:#ffffff;background-image:none;border:1px solid #cccccc;-webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);-webkit-transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;}
    .repeat{margin:4px 5px 0px 10px;width:50px;}
    .noEnd{width:250px;}
    .repeatEnd{margin-left:10px;}
.ui-timepicker-wrapper{width:94px;}
    .calendar-img{position:absolute;top:1px;right:5px;}
    .form-control[disabled]{cursor:not-allowed;}
    .form-control[disabled] + .calendar-img{cursor:not-allowed;}
    input.hasDatepicker[readonly][disabled]{background:#eeeeee;}
    .recurring-block{position:absolute;top:207px;right:-280px;background: #f6f7f9 none repeat scroll 0 0;border: 1px solid #ccc;padding: 10px 10px 0px 10px;}
    .starts-repeat{margin-left:10px;}
</style>
<input type="hidden" name="totfiles" id="totfiles" value="0" readonly="true">
<input type="hidden" id="is_default_task_type" value="<?php echo $GLOBALS['TYPE_DEFAULT'];?>" readonly="true">
<input type="hidden" id="CS_type_id" value="<?php if(isset($taskdetails) && $taskdetails['type_id']){echo $taskdetails['type_id'];}else{if (isset($GLOBALS['TYPE_DEFAULT']) && $GLOBALS['TYPE_DEFAULT']==1) {?>2 <?php }else {echo $GLOBALS['TYPE'][0]['Type']['id'];}}?>">
<input type="hidden" id="CS_priority" value="<?php if(isset($taskdetails) && $taskdetails['priority']){echo $taskdetails['priority'];}else{echo "2";}?>">
<input type="hidden" id="CS_due_date" value="<?php if(isset($taskdetails) && $taskdetails['due_date']){echo date('m/d/Y',strtotime($taskdetails['due_date']));}else{?>No Due Date<?php }?>">
<input type="hidden" id="CS_milestone" value="<?php if(isset($taskdetails) && $taskdetails['milestone_id']){echo $taskdetails['milestone_id'];} ?>">
<input type='hidden' id="client" value='0'/>
<input type="hidden" id="userIds" />
<input type="hidden" id="userNames" />
<input type="hidden" id="CSrepeat_due_date" value='' />
<input type="hidden" id="CSrepeat_start_date" value='' />
<input type="hidden" id="CSrepeat_type" value='' />
<input type="hidden" id="CSrepeat_occurrence" value='' />

<div class="head_back"></div>
<div id="cover" class="outer"></div>
<div id="pagefade" class="pagefade" style="z-index:0"></div>
<div class="create-new-task" style="position:relative;">
	<?php 
	if($user_subscription['btprofile_id'] || $user_subscription['is_free'] || $GLOBALS['FREE_SUBSCRIPTION'] == 0) {
		$is_basic_or_free = 0;
	} else {
		$is_basic_or_free = 1;
	}
	if($user_subscription['is_cancel']) {
		$is_basic_or_free = 0;
	}
	?>
	
<script type="text/javascript">
	var is_basic_or_free= <?php echo $is_basic_or_free; ?>
</script>
	<div id="divNewCase" class="col-lg-9 fl rht-con" style='margin-top:0px;'>
		<textarea name="data[Easycase][message]" id="CS_message" onfocus="openEditor()" rows="2" style="resize:none" class="form-control" placeholder="<?php echo __('Enter Description');?>..."><?php if(isset($taskdetails['message']) && $taskdetails['message']){echo $taskdetails['message']; }?></textarea>
		<div class="cb"></div>
		<div class="form-new-group">
			<div class="fl group-ele">
			<?php
            $curdate = gmdate("Y-m-d H:i:s");
            $userDate = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$curdate,"datetime");

            $curDay = date('D',strtotime($userDate));
            $friday = date('Y-m-d',strtotime($userDate."next Friday"));
            $monday = date('Y-m-d',strtotime($userDate."next Monday"));
            $tomorrow = date('Y-m-d',strtotime($userDate."+1 day"));

            $titleValue = "Daily Update - ".date("m/d");
            ?>
            <div class="fl lbl-m-wid tfont due" style="margin-left:10px;">Due Date:</div>
            <div class="fl rht-con">	
              <div class="fl dropdown option-toggle p-6" style="padding:0 5px 0 5px;">
                <div class="opt1" id="opt3"><a href="javascript:jsVoid()" onclick="open_more_opt('more_opt3');"> 
                  <span id="date_dd" class="ttfont">	
                  <?php if(isset($taskdetails['due_date']) && $taskdetails['due_date']){
                    echo date('m/d/Y',strtotime($taskdetails['due_date']));
                   }else{?>
                    <span class="ttfont"><?php echo __('No Due Date');?></span>
                  <?php }?>
                  </span>
                  <i class="caret mtop-10 fr"></i></a>
				</div>
				<div class="more_opt" id="more_opt3" >
					<ul>
						<li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('No Due Date');?><span class="value"><?php echo __('No Due Date');?></span></a></li>
						<li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Today');?><span class="value"><?php echo date('M j, Y',strtotime($userDate));?></span> </a></li> 	
						<li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Next Monday');?> <span class="value"><?php echo date('M j, Y',strtotime($monday));?></span></a></li> 
						<li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Tomorrow');?><span class="value"><?php echo date('M j, Y',strtotime($tomorrow));?></span></a></li>
						<li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('This Friday');?><span class="value"><?php echo date('M j, Y',strtotime($friday));?></span></a></li> 
						<li style="color:#808080; padding-left:10px;">
						<input type="hidden" id="due_date" title="<?php echo __('Custom Date');?>" style="min-width:30px;"/>&nbsp;<span class="ttfont" style="position:relative;"><?php echo __('Custom Date');?></span>
						</li>
					</ul>
				</div>
            </div>
          </div>
        <div class="cb"></div>
        </div>
            <div id="tgrp_main" class="fl group-ele f-select" style="width:253px;">
            <div class="fl gr-lbl tfont"><?php echo __('Task Group');?>:</div>
            <div class="createtask fl rht-con">	
            <div id="tgrp_detail" class="fl dropdown option-toggle p-6" style="text-align:left;padding:0 4px 0 2px;width:155px;">
                        <div class="opt1" id="opt8">
                            <a href="javascript:jsVoid()" onclick="open_more_opt('more_opt8');" style="min-width:126px;">
                                <span id="selected_milestone" class="ttfont" style="padding:5px;">
                                    <?php if(isset($taskdetails['milestone']) && $taskdetails['milestone']){
                                            echo $taskdetails['milestone'];
                                     }else{?>
                                            <span class="ttfont"><?php echo __('No group');?></span>
                                    <?php } ?>
                                </span>
                                <i class="caret mtop-10 fr"></i>
                            </a>
                        </div>
                        <div class="more_opt" id="more_opt8"><ul style="width:235px;"></ul></div>
                    </div>
				</div>
		<div class="cb"></div>
        </div>
            <div class="fl gropu-ele" style="margin-right:22px;">
                <div class="fl gr-lbl tfont" title="Estimated Hour(s)"><?php echo __('Estimated Hours');?>:</div>
                <div class="fl">
                  <a rel="tooltip" href="javascript:;" original-title="<?php echo __('You can enter time as 1.5  (that  mean 1 hour and 30 minutes)');?>.">
                        <input type="text" onkeypress="return numeric_decimal_colon(event)" onkeyup="return remove_non_integers(this)" id="estimated_hours" name="data[Easycase][estimated_hours]" maxlength="5" class="form-control ttfont est check_minute_range" style="width:72px;" value="<?php if(isset($taskdetails['estimated_hours']) && $taskdetails['estimated_hours']){echo $taskdetails['estimated_hours'];}?>" placeholder="hh:mm"/>
                  </a>
                </div>
		<div class="cb"></div>
            </div>
            <div class="cb"></div>
        <div style="height:auto;"></div>
        <span class='timelog_block'>

                <div class="cb"></div>
                <!-- time log code atart -->
                <span class="timelog_toggle_block">
                    <div class="fl group-ele w200">
                        <div class="fl gr-lbl tfont" title="<?php echo __('Start Time');?>" style="margin-left:10px;"><?php echo __('Start Time');?>:</div>
                        <div class="fl">
                            <?php $start_placeholder = (SES_TIME_FORMAT == 12)?'08:00am':'13:00';?>
                            <input type="text" id="start_time" name="data[TimeLog][start_time]" onchange="updatetime('start_time');" class="form-control ttfont w105 tl_start_time" placeholder="<?php echo $start_placeholder;?>" value="<?php if(isset($taskdetails['start_time']) && $taskdetails['start_time']){echo $taskdetails['start_time'];}?>"/>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="fl group-ele w200">
                        <div class="fl gr-lbl tfont" title="<?php echo __('End Time');?>"><?php echo __('End Time');?>:</div>
                        <div class="fl">
                            <?php $end_placeholder = (SES_TIME_FORMAT == 12)?'08:30am':'13:30';?>
                            <input type="text" id="end_time" name="data[TimeLog][end_time]" onchange="updatetime('end_time');" class="form-control ttfont w105 tl_end_time" placeholder="<?php echo $end_placeholder;?>" value="<?php if(isset($taskdetails['end_time']) && $taskdetails['end_time']){echo $taskdetails['end_time'];}?>"/>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="fl group-ele w200">
                        <div class="fl gr-lbl tfont" title="<?php echo __('Break Time');?>"><?php echo __('Break Time');?>:</div>
                        <div class="fl">
                        <input type="text" id="break_time" name="data[TimeLog][break_time]" class="form-control ttfont w105 tl_break_time check_minute_range" value="" placeholder="hh:mm" maxlength="5" style="width:70px;"/>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div class="fl group-ele w105" style="padding-left:10px;">
                        <div class="fl">
                            <input type="checkbox" id="is_bilable" name="data[LogTime][is_bilable]" class="is_bilable" style='margin-top:6px;' value="Yes" />
                        </div>
                        <div class="fl tfont" title="<?php echo __('Is Billable');?>?" style="margin:4px 0 0 5px;"><?php echo __('Is Billable');?>?</div>
                        <div class="cb"></div>
                    </div>
                </span>
                <div class="fr group-ele hrs" style="width: auto; margin-left: 0px;margin-right:22px;">
                  <div class="fl gr-lbl tfont" title="<?php echo __('Actual Hour(s)');?>"><?php echo __('Spent Hours');?>:</div>
	        <div id="sample" class="fl">
                  <input type="text" id="hours" name="data[Easycase][hours]" maxlength="6" class="form-control ttfont tl_hours" style="width:70px;" value="<?php if(isset($taskdetails['hours']) && $taskdetails['hours']){echo $taskdetails['hours'];}?>" placeholder="hh:mm" rel='tooltip' original-title='<?php echo __('Select Start time and End time, it will calculate spent hours automatically');?>.'/>
            </div>
            <div class="cb"></div>
        </div>
                <!-- time log code end -->
            </span>
            <div class="cb"></div>
            <div class="fl group-ele n-text" id="notify" style="margin-left:10px;">
                    <div class="fl gr-lbl tfont"><?php echo __('Notify via Email');?>:</div>
                    <div  class="fl" style="margin-right:0px;">
                            <!--<input type="text" id="notifytextbox1232434" class="form-control ttfont" style="width:250px;" placeholder="Enter Name/Email"/>
                            <input type="hidden" id="hiddenid" />-->
                            <!--<div class="span4 fl">
                                <select name="" id="sel_user" class="form-control mod-wid-153 fl min_mgt">
                                </select>
                            </div>
                            <span id="ajax_loader" class="fl" style="display:none;position:relative;">
                                <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." />
                            </span>-->
                            <div id="viewmemdtl" class="fl dropdown option-toggle p-6" style="text-align:left;height:25px; padding:0 4px 0 2px;">
                                    <div class="opt1" id="opt11">
                                            <a class="ttfont" href="javascript:jsVoid()" onclick="open_more_opt('more_opt11');" style="min-width:100px;">
                                                    <?php echo __('Select User(s)');?><i class="caret mtop-10 fr"></i>
                                            </a>
                                    </div>
                                    <div class="more_opt" id="more_opt11" >
                                            <ul style="width:132px !important;">
                                                    <li><input type="checkbox" name="chkAll" id="chked_all" class="fl" value="all" onclick="checkedAllRes()"/><span id="selected_milestone" class="ttfont fl" style="padding:5px;"><?php echo __('All');?></span></li>
                                            </ul>
                                    </div>
                                    </div>
                                    <div id="notified_users" class="fl dropdown option-toggle p-6" style="text-align:left; width:503px; height:auto; margin-left:20px; padding:0 4px 0 2px; min-height:25px;">
                                            <div id="more_opt12" style="display:block;"></div>
                                    </div>
                                </div>
                            </div>
							
							                            <!--<div  id="viewmemdtls" class="fl"></div>-->
                            <div class="cb"></div>
                            <div class="submit-block">
                                    <div class="fl no-cl" id="clientdiv">
                                            <span><input type="checkbox" name="chk_all" id="make_client" value="0" onclick="chk_client();"/></span> 
                                             <span class="tfont ml"><?php echo __('Do not show this task to the client');?></span> 
                                            <!--<span class="client-sec ttfont" id="make_clientspn"></span> -->
                                    </div>

                                    <div class="fr" id='buttons' style='position:relative;'>
                                        <span id="quickloading" style="display:none;">
                                        <img src="<?php echo HTTP_IMAGES;?>images/case_loader2.gif" title="<?php echo __('Loading');?>..." alt="<?php echo __('Loading');?>..."/>
                                        </span>
                                        <div class="fl">
                                        <button id="quickcase" class="btn btn_blue" <?php if(count($getallproj) == 0) { ?>disabled="disabled"<?php }?>type="submit" style="margin-top:-5px;padding:10px 30px 11px;margin-right:-6px;border-radius:0;font-size:13px;" onclick ="return submitAddNewCase('Post',0,'','','',1,'');"><?php echo __('Save');?></button>
                                        </div>
                                        <div class="fr">
                                        <button id="sendCaret" class="btn btn-success dropdown-toggle btn-dropdown" data-toggle="dropdown">
                                        <i class="caret"></i>
                                        </button>
                                        <ul id="sendOptions" class="dropdown-menu pull-right taskoptions" role="menu">
                                        <li class="originalCreator" style="display:list-item;text-align:center;">
                                                <a class="sender" data-val="creator" href="#" onclick ="return submitAddNewCase('Post',0,'','','',1,'','','continue');"><?php echo __('Save & Create');?></a>
                                        </li>
                                        <!--<li class="originalCreator divider" style="display:list-item;"></li>
                                        <li class="originalCreator" style="display:list-item;">
                                                <a class="sender" data-val="creator" href="#" onclick ="return submitAddNewCase('Post',0,'','','',1,'');">Save</a>
                                        </li>-->
                                        </ul>
                                        </div>
                                        <div class="cb"></div>
                                    </div>
                                    <div class="cb"></div>
                                </div>
			</div>
		</div>
        
        <span class="recurring-block" id="recurring_task_block" style="display:none;">
            <div class="cb"></div>
            <!-- Recurring Task Code Starts -->
            <div class="group-ele w200" style="margin-left:10px;">
                <div class="fl gr-lbl tfont" title="<?php echo __('Start Date');?>" style="margin-right:15px;"><?php echo __('Type');?>:</div>
                <div class="fl">
                    <div class="fl dropdown option-toggle p-6" style="padding:0 5px 0 5px;">
                        <div class="opt1" id="opt40"><a href="javascript:jsVoid()" onclick="open_more_opt('more_opt40');"> 
                            <span id="repeat_type" class="ttfont">	
                              <span class="ttfont"><?php echo __('None');?></span>
                            </span>
                            <i class="caret mtop-10 fr"></i></a>
                        </div>
                        <div class="more_opt" id="more_opt40" >
                            <ul>
                                <li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('None');?><span class="value"><?php echo __('None');?></span></a></li>
                                <li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Weekly');?><span class="value"><?php echo __('Weekly');?></span></a></li>
                                <li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Monthly');?><span class="value"><?php echo __('Monthly');?></span> </a></li> 	
                                <li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Quarterly');?> <span class="value"><?php echo __('Quarterly');?></span></a></li> 
                                <li><a href="javascript:jsVoid()" class="ttfont">&nbsp;&nbsp;<?php echo __('Yearly');?><span class="value"><?php echo __('Yearly');?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
	<div class="cb"></div>
            </div>
            <div class="group-ele starts-repeat">
                <div class="fl gr-lbl tfont" title="<?php echo __('Start Date');?>" style="margin-right:10px;"><?php echo __('Starts');?>:</div>
                <div class="fl">
                    <input type="text" id="start_datePicker" class="form-control ttfont est" disabled readonly="true" style="width:90px;" name="data[EasycaseRepeat][start_date]" onkeypress="return numeric_decimal_colon(event)"/>
                </div>
            </div>
            <div class="group-ele noEnd">
                <div class="fl tfont" style="margin:4px 0 0 15px;">
                    <input type="radio" id="occur" class="fl" name="endsOn" disabled onclick="enableTextBox('occur')"/> <span class="fl">&nbsp;&nbsp;<?php echo __('Ends after');?>&nbsp;&nbsp; </span><input type="text" id="occurrence" class="form-control ttfont est fl" style="width:65px;" value="1" disabled name="data[EasycaseRepeat][occurrence]" onkeypress="return numeric_decimal_colon(event)"/> <span class="fl">&nbsp;&nbsp;<?php echo __('occurrences');?> </span>
                </div>
                <div class="fl tfont" style="margin:4px 0 0 15px;position:relative; ">
                    <input type="radio" id="date" class="fl" name="endsOn" disabled onclick="enableTextBox('date')"/> <span class="fl">&nbsp;&nbsp;<?php echo __('Ends on');?>&nbsp;&nbsp; </span><input type="text" id="end_datePicker" class="form-control ttfont est fl" style="width:105px;margin-left:12px;" disabled name="data[EasycaseRepeat][end_date]" readonly="true" onkeypress="return numeric_decimal_colon(event)"/><span class="calendar-img"><img src="<?php echo HTTP_ROOT; ?>img/images/calendar.png" /></span>
                </div>
                <div class="cb"></div>
            </div>
        </span>
	</div>
	<div class="cb"></div>
	<div class="clear"></div>
	<div class="case_field">
		<table border="0" cellpadding="0" cellspacing="0" style="padding-left:2px;" id="table1">
			<tr>
                            <td class="case_fieldprof" valign="top">
                                    <!--<div class="fl lbl-m-wid">Attachment(s):</div>-->
                            </td>
                            <td align="left">
                                <table cellpadding="0" cellspacing="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <form id="file_upload" action="<?php echo HTTP_ROOT."easycases/fileupload/?".time(); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="fl" style="margin:10px 0;">
                                                        <!--<div id="holder" style="">
                                                        <div class="customfile-button" style="right:0">-->
                                                                <input class="customfile-input fileload fl" id="task_file" name="data[Easycase][case_files]" type="file" multiple=""  style="display:block;"/>
                                                                <input name="data[Easycase][usedstorage]" type="hidden" id="usedstorage" value=""/>
                                                                <input name="data[Easycase][allowusage]" type="hidden" id="allowusage" value="<?php echo $user_subscription['storage']; ?>"/>
                                                                <!--<div class="att_fl fl" style="margin-right:5px"></div><div class="fr">Select multiple files to upload...</div>
                                                        </div>
                                                        <div style="margin-left:4px;color:#F48B02;font-size:13px;" class="fnt999">Drag and Drop files to Upload</div>
                                                            <div style="margin-left:6px" class="fnt999">Max size <?php echo MAX_FILE_SIZE; ?> Mb</div>
                                                        </div>									
                                                        </div>
                                                        <?php //if(isset($user_subscription) && ($user_subscription['is_free'] || ($user_subscription['subscription_id']>1))){?>
                                                        <div class="soc-257 drive_con_ipad">
                                                        <div class="fr btn-al-mr drive_drop">
                                                            <button type="button" class="customfile-button" onclick="connectDropbox(0,<?php echo $is_basic_or_free;?>);">
                                                                    <span class="icon-drop-box"></span>
                                                                    Dropbox
                                                            </button>
                                                        </div>
                                                        <div class="btn-al-mr drive_mgl">
                                                         <button type="button" class="customfile-button" onclick="googleConnect(0,<?php echo $is_basic_or_free;?>);">
                                                                    <span class="icon-google-drive"></span>
                                                                    Google Drive
                                                            </button>
                                                            <span id="gloader" style="display: none;">
                                                                    <img src="<?php echo HTTP_IMAGES;?>images/del.gif" style="position: absolute;bottom: 95px;margin-left: 125px;"/>
                                                            </span>
                                                        </div>
                                                        </div>-->
                                                        <?php //}?>
                                                        <div class="cb"></div>
                                                        </form>     
                                                    </td>
                                            </tr>
                                            <tr><td></td></tr>
                                    </table>
				</td>
			</tr>
			<tr id="drive_tr_0" style="display: none;">
				<td>&nbsp;</td>
				<td>
				<form id="cloud_storage_form_0" name="cloud_storage_form_0"  action="javascript:void(0)" method="POST">
					<div style="float: left;margin-top: 7px;" id="cloud_storage_files_0"></div>
				</form>
				<div style="clear: both;margin-bottom: 3px;"></div>
				</td>
			</tr>
		</table>
	</div>
	<div class="cb"></div>
<div class="client_hid_div"></div>
<script type="text/javascript">
/* var holder = document.getElementById('holder'),
    tests = {
      dnd: 'draggable' in document.createElement('span')
    };

if (tests.dnd) {
  holder.ondragover = function () { this.className = 'hover'; return false; };
  holder.ondrop = function (e) {
	$('#holder').removeClass('hover');
	if($.trim(e.dataTransfer.files[0].type) === "" || e.dataTransfer.files[0].size === 0) {
	    alert('File "'+e.dataTransfer.files[0].name+'" has no extension!\nPlease upload files with extension.');
	    e.stopPropagation();
	    e.preventDefault();
	}
	return false;
  };
} */

$(function(){ 
	var prjuid = $('#projFil').val();	
	/*$('#notifytextbox').autocomplete({
		source : function(req,res) {
                $.ajax({
                    url: HTTP_ROOT+"Users/autoComplete",
                    dataType: "json",
                    type: "POST",
                    data: {
						prjid : prjuid,
                        term: req.term
                    },
					beforeSend: function(){
						$('#notifytextbox').css("background","url('"+HTTP_ROOT+"/img/images/task.gif') no-repeat right center");
					},
                    success: function(data) {
                        res($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
								email:item.email,
								client :item.client,
                            };
						}));
                    },
                    error: function(xhr) {
                        alert(xhr.status + ' : ' + xhr.statusText);
                    }
                });
            },
            focus: function( event, ui ) {
                //$( "#notifytextbox" ).val(ui.item.label);
                    return false;
            },
            select: function(event, ui) {
                $( "#hiddenid" ).val( ui.item.id );
				$('#notifytextbox').css("background","");
				if($('#'+ui.item.id+'name').text() == ''){
					if(ui.item.client == '1'){
						var cid = $('#client').val();
						cid += ','+ui.item.id;
						$('#client').val(cid);
					}
						$('#notify').append("<div id='"+ui.item.id+"name' class ='fl notify-name ttfont' rel='tooltip' title='"+ui.item.email+"'><span class='fl gr'>"+shortLength(ucfirst(ui.item.value,15))+"</span><div id ='close"+ui.item.id+"' class='notify-close fl' style='cursor:pointer;' onclick='closeNotifyName("+ui.item.id+")'><span> x </span></div><div class='cb'></div></div>");
				}else{
					//alert('This user is already selected.');
					// do fading 3 times
					if($('#make_client').is(":checked") && ui.item.client == '1'){
						alert('The selected user is a client. First uncheck the check box to select this client.');
					}else{
						for(i=0;i<3;i++) {
							$('#'+ui.item.id+'name').fadeTo('slow', 0.5).fadeTo('slow', 1.5);
						}
					}
				}
				setTimeout(function(){$('#notifytextbox').val('');},2000);
            }
	});*/ 
	
});

function closeNotifyName(id, uid){
	$('#close'+uid).parent().remove();
	$('#'+id+"chk_"+uid).prop('checked', false);
	removeAllReply(id);
}
function showloader(){
	if($('#notifytextbox').val() !=''){
		//$('#notifytextbox').css("background","url('"+HTTP_ROOT+"/img/images/task.gif') no-repeat right center");
	}else if($('#notifytextbox').val() == ''){
		$('#notifytextbox').css("background","");
	}
}
</script>
<?php } ?>
