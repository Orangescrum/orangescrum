<style>
.modal-header .p_q_tour_btn{margin:0;padding:0;top:25px;right:185px;}
.q_tour_btn:hover .mini-sidebar-label{color:#444;}
.q_tour_btn:hover .material-icons{color:#444;}
	.more_less_project_opts {display:block;}
	#add_instant_customer {display:none;}
.border-bottom{border-bottom:1px solid #ddd !important; margin-bottom: 10px; padding-bottom: 10px; }
.padbtmset{padding-bottom: 25px !important;margin-left: -4px;}
.onboard_help_anchor.all-proj-task {top:0px;right: 12px;}
.create-task-form-main .form-group label.control-label-manual{position: absolute; top:-14px; margin:0px;}
.cmn-popup .form-group textarea.form-control{min-height:35px !important}
.project-field-all .checkbox .checkbox-material{top:1px}
.new_project .close-icon {width: 40px;height: 40px;line-height: 40px;
    position: absolute;right: -35px;top: -25px;text-align: center;margin: 0;padding: 0;opacity: 1;}
.new_project .close-icon .material-icons {font-size: 40px;
    line-height: 40px;color: #fff;margin: 0;}
.new_project .close-icon:hover .material-icons {color: #ff0000;}
</style>
<?php $userArr = $GLOBALS['projOwnAdmin']; ?>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header popup-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closeSession1();closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __("Create New project");?></h4>

					<?php if(!IS_SKINNY){ ?>
            <span id="showhide_project_conf" class="dropdown">
            <a href="javascript:jsVoid();" title="<?php echo __('Project Configuration');?>" onclick="" class="dropdown-toggle" data-toggle="dropdown"><i class="material-icons">visibility_off</i> <?php echo __("Show/Hide");?></a>
            <ul class="dropdown-menu drop_menu_mc" id="dropdown_menu_project_configuration">
            	<span class="close_config" onclick="$('#showhide_project_conf').removeClass('open');">&times;</span>
            	 <li class="li_check_radio border-bottom">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="selectedcols_all_project" value="all" id="column_all_fields_project"  style="cursor:pointer"> <?php echo __("All");?>
                    </label>
                  </div>
              </li>
               <li class="li_check_radio border-bottom padbtmset">
                  
              </li>              
            <?php $taskFileds = Configure::read('PROJECT_FIELDS');	
            $selectedColumns = explode(',',$defaultfields['TaskField']['project_form_fields']);
            	foreach($taskFileds as $k=>$v){ 
            		if($v['is_default'] == 0){ ?>
            <?php if($v['label'] == "Client" || $v['label'] == "Budget" || $v['label'] == "Default Rate" || $v['label'] == "Cost Appr" || $v['label'] == "Min & Max Tolerance"){ 
            	$show_lb = 0;
            	switch ($v['label']) {
            		case 'Client':
            			$show_lb = ($this->Format->isAllowed('Customer Name',$roleAccess)) ? 1 : 0;
            			break;
            		case 'Budget':
            			$show_lb = ($this->Format->isAllowed('Budget',$roleAccess)) ? 1 : 0;
            			break;
            		case 'Default Rate':
            			$show_lb = ($this->Format->isAllowed('Default Rate',$roleAccess)) ? 1 : 0;
            			break;
            		case 'Cost Appr':
            			$show_lb = ($this->Format->isAllowed('Cost Appr',$roleAccess)) ? 1 : 0;
            			break;
            		case 'Min & Max Tolerance':
            			$show_lb = ($this->Format->isAllowed('Minimum Tolerance',$roleAccess) && $this->Format->isAllowed('Maximum Tolerance',$roleAccess)) ? 1 : 0;
            			break;
            		default:
            			$show_lb = 1;
            			break;
            	}
            	if($show_lb){ ?>
            		<li class="li_check_radio">
	                  <div class="checkbox">
	                    <label>
	                      <input type="checkbox" class="selectedcolsproject projectconfigfields" value="<?php echo $v['id'];?>" id="project_column_all_<?php echo $v['id'];?>"  style="cursor:pointer" <?php if(in_array($v['id'],$selectedColumns) || empty($selectedColumns)){ ?> checked="checked" <?php } ?> onchange="showHideProjectFields(<?php echo $v['id'];?>)" > <?php echo $v['label']; ?>
	                    </label>
	                  </div>
	              </li>
            	<?php } ?>
           	<?php }else{ ?>
              <li class="li_check_radio">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" class="selectedcolsproject projectconfigfields" value="<?php echo $v['id'];?>" id="project_column_all_<?php echo $v['id'];?>"  style="cursor:pointer" <?php if(in_array($v['id'],$selectedColumns) || empty($selectedColumns)){ ?> checked="checked" <?php } ?> onchange="showHideProjectFields(<?php echo $v['id'];?>)" > <?php echo $v['label']; ?>
                    </label>
                  </div>
              </li>
           	<?php } ?>
          <?php }} ?>
          </ul>
      </span>
			<?php } ?>
			
			<?php if(!isset($_COOKIE['FIRST_INVITE_2'])){ /* ?>
				<a class="btn q_tour_btn p_q_tour_btn right200" href="javascript:void(0);" onclick="startTourProject();" title="<?php echo __('Quick Tour');?>" rel="tooltip">
					<div class="tour_icon"></div>
				</a>
			<?php */} ?>
			
        </div>
		<input type="hidden" id="short_nm_prj_new" value="0"/>
        <?php echo $this->Form->create('Project', array('url' => '/projects/add_project', 'name' => 'projectadd', 'onsubmit' => 'return projectAdd(\'txt_Proj\',\'txt_shortProj\',\'loader\',\'btn\')')); ?>
        <div class="pl-20 pr-20 mtop15" id="resourcelist"></div>
        <div class="modal-body popup-container flex_scroll">
            <center><div id="err_msg" class="err_msg" style=""></div></center>
			<div class="row">
               <div class="col-lg-12 padlft-non padrht-non">
               	<div class="create-task-form-main">
			<div class="w_a project-field-1 mtop15 ">
	            <div class="form-group label-floating mark_mandatory">
	                <label class="control-label" for="txt_Proj"><span><?php echo __('Specify your project name');?></span></label>
	                <?php echo $this->Form->text('name', array('value' => '', 'class' => 'form-control input-lg', 'id' => 'txt_Proj', 'placeholder' => "", 'maxlength' => '50','autocomplete'=>'off')); ?>
	            </div>
			</div>
            <div class="w_a project-field-2 mtop15">
	            <div class="form-group label-floating mark_mandatory">
	                <label class="control-label" for="txt_shortProj"><span><?php echo __('Short name for your project');?></span></label>
	                <?php echo $this->Form->text('short_name', array('value' => '', 'class' => 'form-control input-lg', 'id' => 'txt_shortProj', 'placeholder' => "", 'maxlength' => '10','autocomplete'=>'off')); ?>
	                <span id="ajxShort" style="display:none; position: absolute; top:30px; right:0px;">
	                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16"/>
	                </span>
	                <span id="ajxShortPage"></span>
	            </div>
	        </div>
			<div class="w_a project-field-3 mtop15 ">
				<div class="select2__wrapper mark_mandatory" id="priority_dropdown">
					<select name="data[Project][priority]" class="form-control floating-label proj_prioty" placeholder="<?php echo __('Choose Priority');?>" data-dynamic-opts=true id="sel-prio">
						<option value='' selected><?php echo __('Select Priority');?></option>
						<option value='2'><?php echo __('Low');?></option>
						<option value='1' ><?php echo __('Medium');?></option>
						<option value='0' ><?php echo __('High');?></option>
					</select>
                </div>
			</div>
				
					<div class="w_b project-field-4 mtop15 project-field-all">
						<div class="form-group label-floating " style="top:-5px;">
							<label class="control-label" for="prj_desc"><?php echo __('Describe your project');?></label>
							<textarea id="prj_desc"  class="form-control input-lg expand hideoverflow" rows="1" wrap="virtual" name="data[Project][description]" placeholder=""></textarea>
                        </div>
                    </div>
					<?php /* project type */ ?>
					<div class="w_a project-field-6 mtop15 project-field-all">
						<div class="select2__wrapper" id="proj_methodology">
							<select name="data[Project][project_methodology_id]" class="form-control floating-label proj_methodology" placeholder="<?php echo __('Project Template');?>" data-dynamic-opts=true>
								<option value='1' data-val="0" selected><?php echo __('Simple Project');?></option>
								<option value='2' data-val="0" ><?php echo __('Scrum');?></option>
							</select>
						</div>
						<div class="cmn_help_select"></div>
                       <a href="javascript:void(0);" class="onboard_help_anchor all-proj-task" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/can-i-change-to-scrum-interface-while-in-simple-project-management-interface/<?= HELPDESK_URL_PARAM ?>');" title="<?php echo __('Get quick help on Project Template');?>" rel="tooltip" ><span class="help-icon"></span></a>

					</div>
					
                    <div class="w_a project-field-7 mtop15 project-field-all">
                        <div class="" id="wrkflow_dropdown">
                            <select class="select form-control floating-label" placeholder="<?php echo __('Choose a workflow');?>" data-dynamic-opts=true></select>
                        </div>
							<div class="cmn_help_select"></div>
                       <a href="javascript:void(0);" class="onboard_help_anchor all-proj-task" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-can-i-add-custom-workflow-to-project/<?= HELPDESK_URL_PARAM ?>');" title="<?php echo __('Get quick help on Workflow');?>" rel="tooltip" ><span class="help-icon"></span></a>

                    </div>
					
					
					
				
				<div class="w_a project-field-9 mtop15 project-field-all" id="more_proj_options_new">			
					<div class="padlft-non" id="ProjEsthr">
						<div class="form-group">
							<label class="control-label control-label-manual" for="txt_ProjEsthr"><?php echo __('Estimated Hours');?>
								<a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-project/<?= HELPDESK_URL_PARAM ?>#estimated_hour');" title="<?php echo __('Get quick help on Estimated hour');?>" rel="tooltip" ><span class="help-icon"></span></a>
							</label>
							<?php /*<span class="os_sprite est-hrs-icon"></span>*/ ?>
							<?php echo $this->Form->text('estimated_hours', array('value' => '', 'placeholder' => 'hh', 'class' => 'form-control', 'id' => 'txt_ProjEsthr', 'maxlength' => '6', 'onkeypress' => 'return numericDecimalProj(event)','onkeyup' => 'return numericDecimalProj(event)')); ?>
							<p class="help-block" style="margin-top: -5px;">(8 <?php echo __('hours');?> = 1 Day)</p>
						</div>
					</div>
				</div>
				<div class="w_b project-field-10 mtop15 project-field-all time_range_fld" id="ProjStartDate">
						<div class="input-daterange">
							<div class="col-lg-6 col-sm-6 padlft-non">
								<div class="form-group">
									<label class="control-label control-label-manual" for="txt_ProjStartDate"><?php echo __('Date Range');?>
									  <a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-to-create-a-project/<?= HELPDESK_URL_PARAM ?>#date');" title="<?php echo __('Get  quick help on Date Range');?>" rel="tooltip" ><span class="help-icon"></span></a>                                       
									</label>
									<?php echo $this->Form->text('start_date', array('value' => '', 'class' => 'datepicker form-control', 'id' => 'txt_ProjStartDate', 'placeholder' => __('Start Date',true), 'readonly' => 'true')); ?>
								</div>
							</div>
							<div class="from_to" style="top:60%;">to</div>
							<div class="col-lg-6 col-sm-6">
								<div class="form-group">
									<label class="control-label control-label-manual blank-label" for="txt_ProjEndDate">xxx</label>
									<?php echo $this->Form->text('end_date', array('value' => '', 'class' => 'datepicker form-control', 'id' => 'txt_ProjEndDate', 'placeholder' => __('End Date',true), 'readonly' => "true")); ?>
								</div>
							</div>
						</div>
					</div>
					</div>
					<div class="create-task-form-main">
						<div class="w_a project-field-8 mtop15 project-field-all row" style="margin-left: 1px;">
							<div class="" id="task_type">
								<?php echo $this->Form->input('task_type',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select form-control floating-label projectTask",'placeholder'=>__("Choose a default task type",true),"data-dynamic-opts"=>true));?>
							</div>
							<div class="cb"></div>
						</div>
						<div class="w_a project-field-19 project-field-all" style="margin-left: 20px;">
								<div class="select2__wrapper" id="">
									<select name="data[Project][status]" class="form-control floating-label proj_status" placeholder="<?php echo __('Project Status');?>" data-dynamic-opts=true>
										<option value='0' selected><?php echo __('Select Status');?></option>
									</select>
								</div>
						<div class="cb"></div>
					</div>
					
					
					</div>
      
				</div>
			</div>
			
			
            <?php if (!isset($is_active_proj) || $is_active_proj) { ?>

                <div class="w_c project-field-14 mtop15 project-field-all">
                	<div class="row">
                    <div class="col-lg-12 padlft-non padrht-non">
                        <p>
						<span id="add_new_member_txt" class="fl"><?php echo (count($userArr) < 2) ? __("Add new Users") : __("Add Users"); ?></span> <span class="fl">(<?php echo __('optional');?>)</span>
						<span class="checkbox custom-checkbox add-all-adminuser fl" style="margin-left:20px;">
							<label class="">
								<input type="checkbox" id="alladmn_users" onclick="checkUncheckAdmnUsers();" checked="checked" />
								<span title="All Admins including Owner"><?php echo __('All');?></span>
							</label>
						</span>
						<span class="cb"></span>
						</p> <br /><br />
                        <div <?php if ($GLOBALS['project_count'] == 0) { ?> style="display:none;" <?php } ?>>
                            <?php foreach ($userArr AS $k => $usr) { ?>
                                <div class="checkbox custom-checkbox add-user-pro-chk">
                                    <label>
                                        <input type="checkbox" checked="checked" name="data[Project][members][]" class="proj_mem_chk" onclick="addremoveadmin(this)"  value="<?php echo $usr['User']['id']; ?>"/>
                                        <span class="oya-blk" id="puser<?php echo $usr['User']['id']; ?>">
                                            <span title="<?php echo h($usr['User']['name']);?>" rel="tooltip">
                                                <?php echo $this->Text->truncate(h($usr['User']['name']),16,array('ellipsis' => '...','exact' => true)); ?>
                                            </span>
                                            <?php if ($usr['CompanyUser']['user_type'] == 1) { ?>
                                                <small class="green-txt">(owner)</small>
                                            <?php } else if ($usr['CompanyUser']['user_type'] == 3) { ?>
                                                <small class="green-txt">(<?php echo __('You');?>)</small>
                                            <?php } else { ?>
                                                <small class="green-txt">(<?php echo __('admin');?>)</small>
                                            <?php } ?>
                                        </span>
                                    </label>
                                </div>
                            <?php } ?>
                            <div class="checkbox custom-checkbox add-all-user  <?php if(!$this->Format->isAllowed('Add New User',$roleAccess)){ ?> no-pointer<?php } ?>">
                                <label class="mtop15">
                                    <input type="checkbox" id="allc_users" onclick="chooseAllCompUsers();"/>
                                    <span><?php echo __('Add all users (including clients)');?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mtop15">
	                <div class="col-lg-12 padlft-non padrht-non">
                 <div class="form-group label-floating <?php if(!$this->Format->isAllowed('Add New User',$roleAccess)){ ?> no-pointer<?php } ?>">
                    <label class="control-label" for="members_list"><?php echo __('Email ID');?></label>
	                    <textarea id="members_list"  class="wickEnabled form-control input-lg expand hideoverflow m_0" rows="1" wrap="virtual" name="data[Project][members_list]" placeholder="" <?php if ($user_subscription['trial_expired'] == 1 && $user_subscription['subscription_id'] == 11) { ?>disabled="disabled" <?php } ?>></textarea>
                    <div id="err_mem_email" style="display: none;color: #FF0000;"></div>
                    <div id="autopopup" style="position:absolute;"></div>
                    <p class="comma-seprate-txt"><?php if ($user_subscription['trial_expired'] == 1 && $user_subscription['subscription_id'] == 11) { ?><?php echo __('Upgrade your account to add new user(s)');?><?php } else { ?><?php echo __('Use comma separators for multiple email id');?><?php } ?></p>
                </div>
                </div>
        		</div>
                </div>
            
               
            <?php } ?>
            <!-- <div class="row ">
                <div class="col-lg-12 more-opt">
					<p class="blue-txt" style="margin-bottom:0px;"><a href="javascript:void(0);" class="" id="more_proj_options"><?php echo __('Hide options');?></a></p>
				</div>
			</div> -->
        </div>
        <div class="modal-footer popup-footer popup_sticly_cta">
            <div class="fr popup-btn">
				<?php /*if(!isset($_COOKIE['FIRST_INVITE_2'])){ ?>
								<div class="quick_tourbtn">
									<a class="btn q_tour_btn" href="javascript:void(0);" onclick="startTourProject();">
										<div class="tour_icon"></div>
										<?php echo __('Quick Tour');?>
									</a>
								</div>
				<?php } */ ?>
                <?php
                $totProj = "";
                if ((!$user_subscription['is_free']) && ($user_subscription['project_limit'] != "Unlimited")) {
                    $totProj = $this->Format->checkProjLimit($user_subscription['project_limit']);
                } ?>
                
                <?php if ($totProj && $totProj >= $user_subscription['project_limit']) { ?>
                    <?php if (SES_TYPE == 3) { ?>
                        <font color="#FF0000"><?php echo __('Sorry, Project Limit Exceeded');?>!</font>
                        <br/>
                        <font color="#F05A14"><?php echo __('Please contact your account owner to Upgrade the account to create more projects');?></font>
                    <?php } else { ?>
                        <font color="#FF0000"><?php echo __('Sorry, Project Limit Exceeded');?>!</font>
                        <br/><br/>
                        <font color="#F05A14">
                            <a class="dropdown-toggle upgrade_btn" href="<?php echo HTTP_ROOT; ?>pricing" style="text-decoration:none !important;">
                                <button class="btn new_task blue_btn_sml" type="button"> <i class="icon-upgrade"></i> <?php echo __('Upgrade');?> </button>
                            </a>
								<!--you account to create more projects-->
								</font>
                    <?php } ?>
                <?php } else { ?>
                    <input type="hidden" name="data[Project][validate]" id="validate" readonly="true" value="0"/>
					<input type="hidden" name="data[Project][click_referer]" id="project_click_refer" readonly="true" value="" />
                    <span id="loader" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/></span>
                    <span id="btn">
                        <span class="cancel-link cancel_on_invite_pj" style="diaplay:none;">
							<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closeInvitePopupPj();"><?php echo __('Cancel');?></button>
						</span>
                        <span class="cancel-link cancel_on_direct_pj">
							<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closeSession1();closePopup();"><?php echo __('Cancel');?></button>
						</span>
                       <span class="hover-pop-btn">
						<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive"  onclick="return projectAdd('txt_Proj', 'txt_shortProj', 'txt_ProjStartDate', 'txt_ProjEndDate', 'txt_ProjEsthr', 'loader', 'btn');"><?php echo __('Create');?></a>
					   </span>
                    </span>
                <?php } ?>
                <div class="cb"></div>
            </div>
			<div class="cb"></div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
	function checkUncheckAdmnUsers(){	
		if($('#alladmn_users').is(':checked')){
			$('.proj_mem_chk').prop('checked',true);
		}else{
			$('.proj_mem_chk').prop('checked',false);
		}
	}
   function closeSession1(){
	   var inValid=/projects\/manage/;
	   var inValidTask=/dashboard#/;
	   if(inValid.test(window.location.href)){		   
			GBl_tour= tour_project<?php echo LANG_PREFIX;?>;
	   }else if(inValidTask.test(window.location.href)){		   
			GBl_tour= tour<?php echo LANG_PREFIX;?>;
	   }else{
			GBl_tour= tour<?php echo LANG_PREFIX;?>; 
	   }
        <?php if($this->Session->read('project_url')=='create_project'){
                unset($_SESSION['project_url']);
         }?>
    }
    function startTourProject(){
		if($('.more_less_project_opts').is(':visible')){
			$('.more_less_project_opts').slideToggle('slow');
			$('#more_proj_options').html(_('More Options'));
		}
		$('.new_project').scrollTop(0);
		setTimeout(function() {
		GBl_tour= tour_crtproj<?php echo LANG_PREFIX;?>;
			//$('#startTourBtn').click();
			hopscotch.startTour(GBl_tour);
	}, 200);
	}
    $(function() {
        $("#members_list").keyup(function(){
            $('#err_mem_email').html('');
        });
        $("#sel-prio").change(function(event) {
        	if($(this).val() !=''){
        		 $('#err_msg').html('');
        		 $("#btn-add-new-project").removeClass('loginactive')
        	}
        });
        $('#txt_Proj').val().trim()!=''?$("#btn-add-new-project").removeClass('loginactive'):$("#btn-add-new-project").addClass('loginactive');
        $('#txt_Proj,#txt_shortProj')
                .keyup(function(){
                    $(this).val().trim()!=''?$("#btn-add-new-project").removeClass('loginactive'):$("#btn-add-new-project").addClass('loginactive');
                    $('#err_msg').html('');
                })
                .change(function(){
                    $(this).val().trim()!=''?$("#btn-add-new-project").removeClass('loginactive'):$("#btn-add-new-project").addClass('loginactive');
                    $('#err_msg').html('');
                });
        $('#err_msg').html('');
         $("#txt_ProjStartDate").datepicker({format: 'M d, yyyy',todayHighlight: true,changeMonth: false,changeYear: false,hideIfNoPrevNext: true,autoclose: true
	 	}).on('changeDate', function(e) {    	
	    	$("#txt_ProjEndDate").datepicker("setStartDate", $("#txt_ProjStartDate").datepicker('getFormattedDate'));
		});

	    $("#txt_ProjEndDate").datepicker({format: 'M d, yyyy',todayHighlight: true,changeMonth: false,changeYear: false,hideIfNoPrevNext: true,autoclose: true
	    }).on('changeDate', function(e) {    	
	    	$("#txt_ProjStartDate").datepicker("setEndDate", $("#txt_ProjEndDate").datepicker('getFormattedDate'));
		});
        // $(".input-daterange").datepicker({format: 'M d, yyyy',hideIfNoPrevNext: true,todayBtn: "linked",todayHighlight: true,autoclose: true});
        
        $('#members_list').on('keyup',function(){
            var aval = $(this).val().trim();
            if(aval == ''){ $('#allc_users').prop('checked',false); }
        });
    });
		
	function changeProjectClient(obj){
		var clnt_val = 	$.trim($('#proj_client').val());
		var cust_val = 	$.trim($('#proj_client option:selected').attr('data-cust'));
		var in_val = $(obj).val();
		if(clnt_val != 'undefined' && clnt_val != '' && clnt_val !== '0'){
			if(cust_val != in_val){
				$('#proj_currency').val(cust_val); //0
				$('#proj_currency').trigger('change');
				showTopErrSucc('error', _('Currency cannot be updated for a client. Please update currency for a client in manage customer section.'));
			}
		}
	}
	function changeProjectCurrency(obj){
		var in_val = $(obj).val();
		console.log(in_val);
		if(in_val === '0'){
				$('.proj_currency').val(144); //0
				$('.proj_currency').trigger('change');
				if($('#add_instant_customer').is(':visible')){
					addCancelCustomer();
				}
		}else{
			var v_t = $('.proj_client option:selected').attr('data-cust');
			if(v_t != 'new'){
				$('.proj_currency').val(v_t);
				$('.proj_currency').trigger('change');
				if($('#add_instant_customer').is(':visible')){
					addCancelCustomer();
				}
			}else{			
				$('#proj_currency').val(144).select2();
				$('.proj_currency').trigger('change');
			addCancelCustomer();
		}
	}
	}
	function addCancelCustomer(){
		$('#proj_cust_fname').val('');
		$('#proj_cust_email').val('');
		$('#add_instant_customer').slideToggle();
	} 
</script>