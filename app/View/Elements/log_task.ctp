<style>
.tox-silver-sink {
	z-index: 9999;
}
</style>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <marquee style="position:absolute; top:7px;padding-right: 50px;" scrollamount="3"><div class="text-left cmn_foot_cont fl" id="projectaccess_log" style="margin-bottom: 10px; font-size:12px;" ></div></marquee>
             <div class="cb"></div>
            <div class="projectDropdownTimelog" style=margin-top:5px;>
                <h4 class="mxwid95p fl" style="margin-right:10px;"><?php echo __('Log time');?> - </h4><div class="project-dropdown_log fl" style="width:auto; margin-right: 20px;">
                            <div class="btn-group" style="margin: 0;">
                            <input type='hidden' id='boarding' value='0'/>
                            <?php $curProjName = $getallproj['0']['Project']['name']; ?>
                            <?php if(count($getallproj)=='1'){ ?>
                                        <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl" type="button"  onclick="view_project_menu_popup('timelogpopup','projpopup_log','ajaxViewProjects_log','loader_prmenu_log','popup');">
                                        <span id="pname_dashboard" class="ttc ellipsis-view">
                                           <a class="top_project_name" title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" href="javascript:void(0);" onChange='updateusers("<?php echo $curProjName; ?>");'><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a>
                                        </span>
                                            <i class="nav-dot material-icons">&#xE5D3;</i>
                                        </button> 
                                        <?php
                                        $swPrjVal = $getallproj['0']['Project']['name'];
                                        $soprjval = $getallproj['0']['Project']['name'];
                                    }else{
                                        $swPrjVal = $this->Format->shortLength($projName,20); 
                                        $soprjval = $projName;	
                                            $soprjval = $getallproj['0']['Project']['name'];
                                    ?>
                                <input type ="hidden" id="pname_dashboard_hid_log" value="<?php echo $this->Format->formatTitle($projName); ?>" />
                                <input type ="hidden" id="first_recent_hid_log" value="<?php echo $getallproj['1']['Project']['name']; ?>" />
                                <input type ="hidden" id="second_recent_hid_log" value="<?php echo $getallproj['2']['Project']['name']; ?>" />         
                                <button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl" type="button" onclick="view_project_menu_popup('timelogpopup','projpopup_log','ajaxViewProjects_log','loader_prmenu_log','popup');">
                                   <span id="pname_dashboard_log" class="ttc ellipsis-view">
                                <?php if($projUniq == 'all'){ ?>
                                        <a class="top_project_name" title="All" href="javascript:void(0);" onChange='updateusers("<?php echo $curProjName; ?>");'><?php echo __('All');?></a>
                                <?php }else{ ?>
                                        <a class="top_project_name" title="<?php echo ucfirst($getallproj['0']['Project']['name']); ?>" href="javascript:void(0);" onChange='updateusers("<?php echo $curProjName; ?>");'><?php echo ucfirst($getallproj['0']['Project']['name']); ?></a>
                                <?php } ?>
									</span>
                                    <i class="nav-dot material-icons">&#xE5D3;</i>
                                </button> 
                                <?php } ?>
                                <div class="dropdown-menu lft popup" id="projpopup_log" style="padding: 0;">
                                    <center>
                                    <div id="loader_prmenu_log" style="display:none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="<?php echo __('loading');?>..." title="<?php echo __('loading');?>..."/>
                                    </div>
                                    </center>
                                    <div id="find_prj_dv_log" class="pr" style="">
					<i class="material-icons">search</i>
                                        <div class="form-group is-empty" style="margin-top: 0px;"><input type="text" placeholder="<?php echo __('Find Project');?>" class="form-control pro_srch" onkeyup="search_project_menu_popup('popup',this.value,event)" id="search_project_menu_txt_log"><span class="material-input"></span></div>
                                        <div id="load_find_log" style="display:none; text-align:center;" class="loading-pro">
                                            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="<?php echo __('loading');?>..." title="<?php echo __('loading');?>..." >
                                        </div>
                                    </div>
                                    <div id="ajaxViewProjects_log" class="scroll-project"></div>
                                    <div id="ajaxViewProject_log" class="scroll-project"></div>
                                </div>                               
                            </div>
                        </div>
                <input type="hidden" value="" id="tskttl" />
                <!--a href="javascript:void(0);" onclick="switchProject('hide');" class="blue-txt pr" style="font-size:13px;top:5px;">Cancel</a-->
            </div>
            
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closetskPopup();"><i class="material-icons">&#xE14C;</i></button>
           <!--div class="logtimeTitle" style="display:none;">
            <h4 class="mxwid95p">Log time - <span id="tskttl" class="tlog-head-titl ellipsis-view"></span></h4>
            <a href="javascript:void(0);" onclick="switchProject('show');" class="blue-txt hideOnedit" style="margin-left:20px;font-size:13px;">Switch Project</a>
           </div-->
            <div class="cb">&nbsp;</div>
        </div>
        <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
        <div class="modal-body popup-container m640-pop-overflow" id="inner_log" style="display:none;">
            <form action="<?php echo HTTP_ROOT."easycases/add_tasklog"; ?>" method="POST" onSubmit="return stvariables();" autocomplete="off" name='frmaddlogtim' id="frmaddlogtim" class="media-width700">
                <input type="hidden" name="project_id" value="" id="prjsid" />
                <input type="hidden" name="chked_ids" value="" id="chked_ids" />
                <input type="hidden" name="page_type" value="" id="page_type" />
                <input type="hidden" name="hidden_task_id" id="hidden_task_id" value=""/>
                <input type="hidden" name="hidden_angular_log" id="hidden_angular_log" value=""/>
                <input type="hidden" name="timesheet_flag" id="hidden_timesheet_flag" value="0"/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pop-dropdown st-pop-drop">
                       <div id="logtsksid">
                           <input type="hidden" id="log_task_id" name="task_id" value="" />
                           <div class="slct_task form-control floating-label custom-tlog-select padding-top-8" style="cursor:pointer;margin-bottom: 27px;margin-top: 27px;" onclick="showLogResults();"><span><?php echo __('Select task to log time');?></span>
							<div class="logt-select-drop drp_down_arw"></div>
                    </div>
                           <div class="hide logResult">  
                               <div id="searchQuickTask" class="pr margin-top-0">
                                    <i class="material-icons">search</i>
                                    <div class="form-group is-empty">
                                        <input type="text" placeholder="<?php echo __('Search Tasks');?>" id="log_search" class="form-control pro_srch" onkeyup="searchLogTask();">
                                        <span class="material-input"></span>
                                    </div>
                                    <div id="load_find_log" style="display: none;" class="loading-pro">
                                        <img src="<?php print HTTP_IMAGES?>images/del.gif">
                                    </div>
                               </div>
                               <div id="log_task_results"></div> 
                               <?php if($this->Format->isAllowed('Create Task',$roleAccess) || SES_TYPE ==1){ ?>
                               <div class="addQuickTask">
                                   <a href="javascript:void(0);" class="logTasks" onclick="showQuickLogTask();" style="paddin:0 10px; border-top:1px solid #ddd;">+ <?php echo __('Create Task');?></a>
                                   <div class="form-group label-floating is-empty" id="log_search_task" style="display:none; margin-top:0px;" >
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <input id="log_addon" placeholder="<?php echo __('Task Title');?>" class="form-control" type="text" onkeydown="checkKeyCode(event);" >
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="logQuickAddTask();"><?php echo __('Save');?></a> &nbsp; &nbsp;
                                            <a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg cmn_size btn-default" onclick="showQuickLogTask();"><?php echo __('Cancel');?></a>
                                        </div>
                                    </div>
                                        <!--span class="input-group-btn">
                                                <button type="button" class="btn btn-fab btn-fab-mini in_qt_taskgroupbtn">
                                                <i class="material-icons">send</i>
                                                </button>
                                        </span-->
                                   </div>
                               </div>
                           <?php } ?>
                           </div>
                       </div>
                        <!--select id="tsksid" name="task_id" class="form-control floating-label custom-tlog-select" placeholder="Select Task" data-dynamic-opts=true onchange="modifyheader();">                            <option value="0">Select Task</option>
                        </select-->
												
                    </div>
                    <div class="lbe">
                        <ul>
                            <li><h6><?php echo __('Estimated');?>: <span id='logtime_estimated'>---</span></h6></li>
                            <li><h6><?php echo __('Logged');?>: <span id='logtime_total'>---</span></h6></li>
                            <li><h6><?php echo __('Billable');?>: <span id='logtime_billable'>---</span></h6></li>
                            <li><h6><?php echo __('Non-Billable');?>: <span id='logtime_nonbillable'>---</span></h6></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="popup-inner-container">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>
                                <label>
                                    <input type="checkbox" id="skip_timeDuration" name="skip_timeDuration" value="1" />
                                        Skip Time Duration
                                    </label>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?php echo __('Resource');?></th>
                                    <th><?php echo __('Date');?></th>
                                    <th class="start_tm"><?php echo __('Start Time');?>
                                    <a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-do-i-log-time/<?= HELPDESK_URL_PARAM ?>#start_time');" title="<?php echo __("Get quick help on start time");?>" rel="tooltip"><span class="help-icon"></span></a>
                                    </th>
                                    <th class="end_tm"><?php echo __('End Time');?>
                                    <a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-do-i-log-time/<?= HELPDESK_URL_PARAM ?>#end_time');" title="<?php echo __("Get quick help on End time");?>" rel="tooltip"><span class="help-icon"></span></a>
                                    </th>
                                    <th class="break_tm" style="padding-left:2px;"><?php echo __('Break Time');?>
                                        <a href="javascript:void(0);" class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-do-i-log-time/<?= HELPDESK_URL_PARAM ?>#break_time');" title="<?php echo __("Get quick help on Break time");?>" rel="tooltip"><span class="help-icon"></span></a>
                                    </th>
                                    <th><?php echo __('Spent Hours');?></th>
                                    <th><?php echo __('Billable');?>?</th>
                                </tr>
                            </thead>
                            <tbody class="log-time">
                                <tr id="ul_timelog1">
                                    <td style="width:180px;">
                                        <div class="resource-select">
                                            <select id="whosassign1" name="user_id[]" class="form-control"><option value=""><?php echo __('Select User');?></option></select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" id="workeddt1" name="task_date[]" class="form-control" value="<?php echo date('M d, Y',strtotime('now')); ?>" readonly/>
                                        </div>
                                    </td>
                                    <td class="start_tm">
                                        <div class="form-group">
                                            <input type="text" id="strttime1" name="start_time[]" onchange="updatehrs(1);" class="form-control updatehrs"  />
                                        </div>
                                    </td>
                                    <td class="end_tm">
                                        <div class="form-group">
                                            <input type="text" id="endtime1" name="end_time[]" onchange="updatehrs(1);" class="form-control updatehrs"/>
                                        </div>
                                    </td>
                                    <td class="break_tm">
                                        <div class="form-group">
                                            <input type="text"  value="" id="tshr1" class="form-control totalbreak check_minute_range brk_hr_mskng" name="totalbreak[]" placeholder="hh:mm" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" maxlength="5" value="" id="tsmn1" class="form-control totalduration"  name="totalduration[]" placeholder="hh:mm"/>
                                        </div>
                                    </td>
                                    <td class="td-last">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="billablecls" id="is_billable1" name="is_billable[]" value="1" />
                                                <a href="javascript:void(0);" onClick="removeUI(1);" id="crsid1" class="crsid" style="display:none;"><i class="material-icons">&#xE14C;</i></a>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="plus-btn">
                            <a href="javascript:void(0)" onclick="appendnewrow();" class="append-new-row blue-txt"><?php echo __('Add line-item');?></a>
							 <a href="javascript:void(0);"  class="onboard_help_anchor" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/how-do-i-log-time/<?= HELPDESK_URL_PARAM ?>#new_line_item');" title="<?php echo __("Get quick help on Add line item");?>" rel="tooltip"><span class="help-icon"></span></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="cb"></div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="tskdesc"><?php //echo __('Add a note');?></label>
                <textarea class="form-control expand hideoverflow" data-dynamic-opts=true rows="2" cols="" style="" name="description" id="tskdesc" placeholder=""></textarea>
            </div>
            <div class="modal-footer">
                <div class="fr popup-btn">
                    <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closetskPopup();"><?php echo __('Cancel');?></button></span>
                    <span class="hover-pop-btn"><a href="javascript:void(0)" id="lgtimebtn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></a></span>
                    <span style="display:none;margin-right:20px;" id="lgquickloading">
                        <img alt="Loading..." title="Loading..." src="<?php echo HTTP_ROOT;?>img/images/case_loader2.gif">
                    </span>
                    <div class="cb"></div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<script type="text/javascript">
	var cntr = 1;
	var clone = '';
        var trigger_blur = true;
	$(document).ready(function(){
        /* Skip adding start time, end time and break time while adding new timelog */
		   $('#skip_timeDuration').change(function () {
        if (!this.checked) {
               $('.start_tm, .end_tm, .break_tm').show();    
          }  else {
            $('.start_tm, .end_tm, .break_tm').hide();           
          }
    });
            //Hide the project dropdown;
                $('.totalduration').mask('00:M0', {translation: {'M': {pattern: /[0-5]/}}});
                $( "#frmaddlogtim" ).off().on( "keyup", ".totalduration", function() {
                    if($('#skip_timeDuration').is(":not(:checked)")){
                val = $(this).val();
                 if(val.trim()!=''){
                  valArr = val.split(":");
                  if(parseInt(valArr[0]) > 23){
                    value = valArr[0].slice(0, -1);
                    if(typeof valArr[1] != 'undefined' ){
                        value = value +":"+valArr[1];                        
                    }
                    $(this).val(value); return false;
                  }
                 }
                    }
                });
                $( "#frmaddlogtim" ).off().on( "keyup", ".totalbreak", function() { 
                    if($('#skip_timeDuration').is(":not(:checked)")){
                val = $(this).val();
                 if(val.trim()!=''){
                  valArr = val.split(":");
                  if(parseInt(valArr[0]) > 23){
                    value = valArr[0].slice(0, -1);
                    if(typeof valArr[1] != 'undefined' ){
                        value = value +":"+valArr[1];                        
                    }
                    $(this).val(value); return false;
                  }
                 }
                    }
                });
                $( "#frmaddlogtim" ).off().on( "blur", ".totalduration", function() {
                    if($('#skip_timeDuration').is(":not(:checked)")){
                    var sttime = $(this).closest('tr').find('input[name="start_time[]"]').val();
                    var edtime = $(this).closest('tr').find('input[name="end_time[]"]').val();
                    var brtime = $(this).closest('tr').find('input[name="totalbreak[]"]').val();
                    var sptime = $(this).val();                  
                    if(sttime !=''){
                        if(brtime !=''){
                            if(brtime.indexOf(':')>'-1'){
                                 br_time = brtime.split(':');
                                 extra_hr = (br_time[1] == '') ? 0 : Math.floor(parseInt(br_time[1])/60);                         
                                 br_hr = (br_time[0] == '') ? 0 : (parseInt(br_time[0])+parseInt(extra_hr));
                                 br_min = (br_time[1] == '') ? 0 : Math.floor(br_time[1]%60);
                            }else{
                                br_hr = brtime;                
                                br_min = '0';
                            }
                            total_br_min = (parseInt(br_hr)*60)+parseInt(br_min);
                        }else{
                            total_br_min = 0;
                        }  

                        if(sptime !=''){
                            if(sptime.indexOf(':')>'-1'){
                                 sp_time = sptime.split(':');
                                 extra_hr_sp = (sp_time[1] == '') ? 0 : Math.floor(parseInt(sp_time[1])/60);                         
                                 sp_hr = (sp_time[0] == '') ? 0 : (parseInt(sp_time[0])+parseInt(extra_hr_sp));
                                 sp_min = (sp_time[1] == '') ? 0 : Math.floor(sp_time[1]%60);
                            }else{
                                sp_hr = sptime;                
                                sp_min = '0';
                            }
                            total_sp_min = (parseInt(sp_hr)*60)+parseInt(sp_min);
                        }else{
                            total_sp_min = 0;
                        }       
                       
                        total = parseInt(total_br_min)+ parseInt(total_sp_min);
                        <?php if(SES_TIME_FORMAT == 12){ ?>
                            var st_mode = (sttime.indexOf('pm') > -1) ? 'pm' : 'am';
                            st_time = (sttime.indexOf('pm') > -1) ? sttime.replace('pm','') : sttime.replace('am','');
                            st_tmsp = st_time.split(":");
                            if(st_mode == 'pm'){
                                    st_timespl = (st_tmsp[0] < 12 ) ? parseInt(st_tmsp[0]) + 12 : 12;
                            }else{
                                    st_timespl = (st_tmsp[0] == 12 ) ? "00" : st_tmsp[0];
                            }
                        <?php }else{ ?>
                             var st_mode = '';
                             st_time = sttime;
                             st_tmsp = st_time.split(":");
                             st_timespl = st_tmsp[0];
                        <?php } ?>
                        st_timesplit = st_timespl+":"+st_tmsp[1];
                        st_time_minute = (parseInt(st_timespl)*60)+parseInt(st_tmsp[1]);
                        
                        generaged_end_tm_min = parseInt(st_time_minute) + parseInt(total);                        
                        generated_end = "";
                        generaged_end_tm_hr = Math.floor(generaged_end_tm_min/60);
                        generaged_end_min = Math.floor(generaged_end_tm_min%60);
                        <?php if(SES_TIME_FORMAT == 12){ ?>
                            generaged_end_hr = (generaged_end_tm_hr <= 12)? generaged_end_tm_hr:(parseInt(generaged_end_tm_hr)%12);
                            if(generaged_end_tm_hr < 24){
                            generated_am = (generaged_end_tm_hr < 12)? 'am':'pm';
                            }else{
                                 generaged_end_tm_hr = generaged_end_tm_hr - 24;
                                 generated_am = (generaged_end_tm_hr < 12)? 'am':'pm';
                            }
                        <?php }else{ ?>
                            generaged_end_hr = generaged_end_tm_hr;
                            if(generaged_end_tm_hr < 24){
                                generated_am = '';
                            }else{
                                 generated_am = '';
                                 generaged_end_hr = generaged_end_tm_hr - 24;
                            }
                        <?php } ?>
                        $(this).closest('tr').find('input[name="end_time[]"]').val(generaged_end_hr+":"+generaged_end_min+""+generated_am);
                        
                     }
                    }
                });
               $(document).click(function(e){
                if($(e.target).closest('#projpopup_log').length != 0){ 
                    return false;
                }else{ 
                $('#projpopup_log').hide();
                }
                if($(e.target).closest('#projpopup_subtask').length != 0){ 
                    return false;
                }else{ 
                    $('#projpopup_subtask').hide();
                }
                if($(e.target).closest('.logResult').length != 0){ 
                    return false;
                }
                if($(e.target).closest('.slct_task').length !=1){ 
                    $('.logResult').addClass('hide');
                }
                if($(e.target).closest('.custom-popover').length != 0){                     
                        return false;
                }else{                  
                    if(!$(e.target).hasClass('ng-popover-trigger') && !$(e.target).hasClass('ng-popover-trigger_edit') && $(e.target).closest('.ui-timepicker-wrapper').length == 0){
                        $('.custom-popover').hide();
                        $('#custom-popover').find('input:text').val('');
                    }
                }
               if($(e.target).closest('.dateSpan').length !=1){ 
                   if(typeof $('#weeklyDatePicker') != 'undefined'){
                        $('#weeklyDatePicker').datetimepicker('hide');
                    }
                }
               
             });
             //End of code
                clone = $("#ul_timelog1").clone();                $(document).off('click','#lgtimebtn').on('click','#lgtimebtn',function () {
                    if($('#lgtimebtn').hasClass('loginactive')){
                        showTopErrSucc('error','<?php echo __('Please select a task');?>');
                        return false ;
                    }
                    $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr("checked");
                    $('#dropdown_menu_resource').find('input[type="checkbox"]').removeAttr("checked");
                    createCookie("Timelog_filter", '', -365, DOMAIN_COOKIE);
                    createCookie("Timelog_Resource_Filter", '', -365, DOMAIN_COOKIE);
                    if(!$("#log_task_id").val()){
                        return;
                    }
                    $('#frmaddlogtim').submit();
                });
                $(document).on('change',"#log_task_id",function () {
                    $(this).val()?project_timelog_details($(this).val()):"";
                });
                $(document).on('mousedown',function (e) {
                    trigger_blur = ($(e.target).closest('.append-new-row,.crsid,.log-btn,.popup_title').size()>0)?false:true;
                });
                $(document).on('blur',".totalbreak",function (e) {
                    if(trigger_blur){
                        updatehrs($(this).closest('tr').attr('id').replace(/\D+/g,''));
                    }
                });
               /* $("#tskdesc").tinymce({
                script_url: HTTP_ROOT + 'js/tinymce/tiny_mce.js',
                theme: "advanced",
                directionality: 'ltr',
                plugins: "paste, -tasktemplate, autoresize, directionality, lists, advlist",
                theme_advanced_buttons1: "bold,italic,strikethrough,underline,|, numlist,bullist,|, ltr,rtl,|, indent,outdent,|, forecolor,backcolor",
                theme_advanced_resizing: false,
                theme_advanced_statusbar_location: "",
                theme_advanced_toolbar_align: "left",
                paste_text_sticky: true,
                gecko_spellcheck: true,
                paste_text_sticky_default: true,
                width: "100%",
                autoresize_min_height: "130px",
                autoresize_max_height: "200px",
                autoresize_on_init: true,
                autoresize_bottom_margin: 20,
                oninit: function() {
//                    $('#tskdesc').val(editormessage);
//                    $('#tskdesc').tinymce().setContent(editormessage);
                }
            });*/
							if (tinymce.get('tskdesc')) {
								tinymce.remove('#tskdesc');
							}
							tinymce.init({
								selector: "#tskdesc",
								plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize imagetools help',
								menubar: false,
								branding: false,
								statusbar: false,
								toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor fullscreen',
								toolbar_sticky: true,
								/*autosave_ask_before_unload: true,
								autosave_interval: "30s",
								autosave_restore_when_empty: false,
								autosave_retention: "2m",*/
								importcss_append: true,
								image_caption: true,
								browser_spellcheck: true,
								quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
								//directionality: dir_tiny,
								toolbar_drawer: 'sliding',
								contextmenu: "link",
								resize: false, 
								min_height: 130,
								max_height: 200,
								paste_data_images: false,
								paste_as_text: true,
								autoresize_on_init: true,
								autoresize_bottom_margin: 20,
								content_css: HTTP_ROOT+'css/tinymce.css',
									setup: function(ed) {
											ed.on('Click',function(ed, e) {});
											ed.on('KeyUp',function(ed, e) {
													var inpt = tinymce.activeEditor.getContent().trim();
													var inptLen = inpt.length;
													/*var datInKb = 0;
													var datInKb = ((inptLen * (3/4)) - 1)/1024;
													
													//console.log(inpt);
													
													if(datInKb > 5045){
														tinymce.activeEditor.setContent("");
													}	*/
											});
											ed.on('Change',function(ed, e) {
												//console.log('Change here');
												/*var inpt = tinymce.activeEditor.getContent().trim();
												var inptLen = inpt.length;
												var datInKb = 0;
												var datInKb = ((inptLen * (3/4)) - 1)/1024;												
												if(datInKb > 5048){
													tinymce.activeEditor.setContent("");
												}else{
													//console.log($(inpt).find('img'));
													//tinymce.activeEditor.setContent(inpt);
												}	*/
											});
											ed.on('init', function(e) {
												//tinymce.execCommand('mceFocus', true, 'tskdesc');
											});
									}
								});
						
                $("#tskdesc").keyup(function (e) {autoheight(this);});
                if(getHash().indexOf('details/')!='-1' && PAGE_NAME == 'dashboard'){
									//$("#tsksid").attr('disabled',true);
                }
                $("#workeddt"+cntr).datepicker({
                    format: 'M d, yyyy',
										todayHighlight: true,
                    changeMonth: false,
                    changeYear: false,
                    hideIfNoPrevNext: true,
                    autoclose:true
                });
                var d= new Date();

                $('#strttime'+cntr).timepicker({
                        'minTime': '12:00am',
                        'step': '30',
                        //'forceRoundTime': true,
                        //'useSelect':true,
                        'maxTime':'11:59pm',
                });
                $('#endtime'+cntr).timepicker({
                        'minTime': '12:00am',
                        'step': '30',
                        //'forceRoundTime': true,
                        //'useSelect':true,
                        'maxTime':'11:59pm',
                });
                $('#endtime'+cntr).timepicker('setTime', d);
                d.setMinutes(d.getMinutes() - 30);
                $('#strttime'+cntr).timepicker('setTime', d);
                <?php if(SES_TIME_FORMAT == 24){ ?>
                $('#endtime'+cntr).timepicker({'timeFormat': 'H:i'});
                $('#strttime'+cntr).timepicker({'timeFormat': 'H:i'});
                <?php } ?>

                //$('#endtime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());
                //$('#strttime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());

                $('#endtime'+cntr).on('changeTime', function() {
                        //$('#strttime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());
                });
                $('#strttime'+cntr).on('changeTime', function() {
                        //$('#endtime'+cntr).timepicker('option', 'minTime', $('#strttime'+cntr).val());
                });
                //$('#endtime'+cntr).timepicker('option', 'minTime', $('#strttime'+cntr).val());
                updatetime(1);
                formathour();
	});
	
	function updatetime(countr){
		var mn = parseInt($('#tsmn'+countr).val());
		if($.trim(mn) == "NaN"){
			mn = parseInt(0);
			$('#tsmn'+countr).val('0:00');
		}
		var hr = parseInt($('#tshr'+countr).val());
		if($.trim(hr) == "NaN"){
			hr = parseInt(0);
			//$('#tshr'+countr).val('00:00');
		}
		var logdt = $('#workeddt'+countr).val();
		var time2 = $('#endtime'+countr).val();
		if(time2.indexOf('pm') > -1){
			time2 = time2.replace('pm','');
			var tmsp = time2.split(":");
			var timespl = parseInt(tmsp[0]) + 12;
			var timesplit2 = timespl+":"+tmsp[1];
		}else{
		 var timesplit2 = time2.replace('am','');
		}
		var enddt = logdt + " "+timesplit2;	
		var d= new Date(enddt);
		if(d.getHours() < hr){
			var d1 = new Date(logdt+" 00:00");
			$('#strttime'+countr).timepicker('setTime', d1);
			updatehrs(countr);
			
		}else{
			d.setMinutes(d.getMinutes() - mn);
			d.setHours(d.getHours() - hr);
			$('#strttime'+countr).timepicker('setTime', d);
		}
                
	}
	
	function stvariables(){
//            serror =0 ;
//            eerror =0 ;
//            $( "tr[id^='ul_timelog']" ).each(function( index ) {
//                stime = $(this).find('input[name="start_time[]"]').val();
//                etime = $(this).find('input[name="end_time[]"]').val();
//                if(stime =='' && etime !='' ){
//                  serror = 1;
//                }
//                if(etime =='' && stime !='' ){
//                   eerror = 1;
//                }
//            });
//            
//            if(serror == 1){
//                showTopErrSucc('error','Please set start time in each line item');
//                $('#lgquickloading').hide();
//                $('#lgtimebtn').addClass('loginactive');
//                $('#lgtimebtn').show();
//                return false;
//            }
//            if(eerror == 1){
//                showTopErrSucc('error','Please set end time in each line item');
//                $('#lgquickloading').hide();
//                $('#lgtimebtn').addClass('loginactive');
//                $('#lgtimebtn').show();
//                return false; 
//            }
            if(!$('#log_task_id').val()){
                    showTopErrSucc('error','<?php echo __('Please select a task');?>');
                    $('#lgquickloading').hide();
                    $('#lgtimebtn').show();
                    return false;
            }
            var a = 0;
            $( ".updatehrs" ).each(function( index ) {
                if(!$(this).val() && $('#hidden_timesheet_flag').val() != 1){
                        a=1;
                }
            });

            if(a==1){
                if($('#skip_timeDuration').is(":not(:checked)")){
                showTopErrSucc('error','<?php echo __('Please set start & end time in each line item');?>');
                $('#lgquickloading').hide();
                $('#lgtimebtn').addClass('loginactive');
                $('#lgtimebtn').show();
                return false;
            }
            }
            var x=0;
            var y = 0;
            var z=0;
            var zro1 = 0;
            var zro2 = 0;
            $( "select[id^='whosassign']" ).each(function( index ) {
                if($(this).val() == null || $(this).val() == ""){
                        x=1;
                }
            });
			if(x==1 && $('.resource-select').find('.dropdownjs').find('input').val() == ''){
	        	showTopErrSucc('error','<?php echo __('Please select user');?>');
	        	$('#lgquickloading').hide();
	       		$('#lgtimebtn').show();
	        	return false;
	        }
	        
	        var x = '';
	        
		 if(y==1){
	        	showTopErrSucc('error',"<?php echo __("End Time can't be earlier than Start Time");?>");
	        	$('#lgquickloading').hide();
	       		$('#lgtimebtn').show();
	        	return false;
	        }
	        
	        $( "input[id^='tsmn']" ).each(function( index ) {
                    if(parseInt($(this).val()) < 0){
                            z=1;
                    }
                    if(!(/^[0-9]([0-9])?$/.test($(this).val()))){
                            //z=1;
                    }
                    if($.trim($(this).val()) == ''){
                            zro2=1;
                    }
		});
                
                if(z==1){
	        	showTopErrSucc('error',"<?php echo __("End Time can't be earlier than Start Time");?>");
	        	$('#lgquickloading').hide();
	       		$('#lgtimebtn').show();
	        	return false;
	        }
	        if(zro2 == 1){
	        	showTopErrSucc('error',"<?php echo __("Please select start and end time");?>");
	        	$('#lgquickloading').hide();
	       		$('#lgtimebtn').show();
	        	return false;
	        }
                //return false;
                var chkstr = 0;
                var invalidduration = false;
                var sameduration = false;
                var samestartend = false;
	        $( "[id^='ul_timelog']" ).each(function( index ) {
			var x = $(this).attr('id');
			var ids = x.substr(2,4);
			var str1 = $('#whosassign'+ids).val()+" "+$('#workeddt'+ids).val()+" "+$('#strttime'+ids).val()+" "+$('#endtime'+ids).val();
			$( "[id^='ul_timelog']" ).each(function( index ) {
				var y = $(this).attr('id');
				var idy = y.substr(2,4);
				if(idy != ids){
					var str2 = $('#whosassign'+idy).val()+" "+$('#workeddt'+idy).val()+" "+$('#strttime'+idy).val()+" "+$('#endtime'+idy).val();
					if(str1 == str2){
		       				chkstr = 1;
						return false;
					}
				}
			});
			if(chkstr ==1){
				return false;
			}
                        
                        /*check for break time < spend time*/
                        $ul = $(this);
                        var total_br_min = calulate_break_minute($ul);
                        var total_sp_min = calulate_spend_minute($ul);
                        //console.log(total_sp_min+' < '+total_br_min+' >> '+(total_sp_min<total_br_min));
                        if(total_sp_min<total_br_min){
                            $ul.find('.totalbreak').focus();
                            invalidduration = true;
                            return false;
                        }else if(total_sp_min==total_br_min){
                            $ul.find('.totalbreak').focus();
                            sameduration =true;
                            return false;
                        }else if(total_sp_min==0){
                            samestartend =true;
                            return false;
                        }
		});
        if($('#skip_timeDuration').is(":not(:checked)")){
		if(invalidduration){
                    showTopErrSucc('error','<?php echo __('Break time can not exceed the total spent hours.');?>');
                    return false;
                }else if(sameduration){                   
                    showTopErrSucc('error', '<?php echo __('Break time can not same as the total spent hours.');?>');
                    return false;
		}else if(samestartend){                   
			showTopErrSucc('error', '<?php echo __('Oops! Start and End Time can not be same.');?>');
			return false;
                }
        }
                
		if(chkstr ==1){
			showTopErrSucc('error','<?php echo __('Duplicate data found');?>');
	        	$('#lgquickloading').hide();
	       		$('#lgtimebtn').show();
	       		return false;
		}  
		//$('#prjsid').val($('#projFil').val());
		var billindx = "";
		$( ".billablecls" ).each(function( index ) {
			if($(this).prop("checked") == true){
                		billindx += index+",";
            		}
		});
		$('#chked_ids').val(billindx);
                $stay = false;
                if(getHash().indexOf('details/')!='-1' && PAGE_NAME == 'dashboard'){
                    $stay = true;
                }
                //if($stay){
                    ajax_log_form_submit();
                    return false;                    
                //}
                //$('#lgtimebtn').hide();
                //$('#lgquickloading').show();
	}
	function  ajax_log_form_submit(){
			//$('#tskdesc_new').val(tinymce.get('tskdesc').getContent());
			$('#tskdesc').val(tinymce.get('tskdesc').getContent());
			$('#lgtimebtn').hide();
			$('#lgquickloading').show();
			$('#page_type').val('details');
			$('#check_cale_multple_time').val(1);
            $.ajax({
                url:$('#lgtimebtn').closest('form').attr('action'),
                data:$('#lgtimebtn').closest('form').serialize(),
                method:'post',
                dataType:'json',
                success:function(response){
					if(response.success == 'depend'){
						$('#lgtimebtn').show();
                        $('#lgquickloading').hide();
                        var html = '';
                        var users_arr = new Array();
                        $('#whosassign1').find('option').each(function(){
                            users_arr[$(this).val()]=$(this).html();
                        });
                        showTopErrSucc('error',response.message);
                        return false;
					}
					if(response.success == 'err'){
						$('#lgtimebtn').show();
                        $('#lgquickloading').hide();
                        var html = '';
                        var users_arr = new Array();
                        $('#whosassign1').find('option').each(function(){
                            users_arr[$(this).val()]=$(this).html();
                        });
                        showTopErrSucc('error',response.message);
                        return false;
					}
                    if(response.success == 'No'){
                        $('#lgtimebtn').show();
                        $('#lgquickloading').hide();
                        var html = '';
                        var users_arr = new Array();
                        $('#whosassign1').find('option').each(function(){
                            users_arr[$(this).val()]=$(this).html();
                        });
                        $.each(response.data,function(index,value){
                            $.each(value,function(index1,value2){
                                html += users_arr[value2.user_id]+" on "+value2.task_date+" from "+value2.start_time+" to "+value2.end_time+" ";
                                html +="<br/>";
                            });
                            
                        });
                        showTopErrSucc('error','<?php echo __('Time Log value overlapping for following users');?>:<br/>'+html);
                        return false;
                    }
                    if(response.success){
						/* Code for Create Event tracking starts here */
						var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
						var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
						var event_name = sessionStorage.getItem('SessionStorageEventValue');
			
						if(eventRefer && event_name){
							trackEventLeadTracker(event_name, eventRefer, sessionEmail);
						}
						/* Code for Create Event tracking ends here */
						
						
						setTimeout(function(){ //Settimeout function is required to sleep th epage so that event tracking can be easily insert into database
							
                        closetskPopup();
                        $('#lst_uptd').html(response.last_updated);
                        /**Set the Project dropdown **/                       
                        radio="1";
                        ucpname=decodeURIComponent($('#tskttl').val());
                        projId=decodeURIComponent($('#prjsid').val());
                        var select_edprj = $('#projFil').val();
            						$('#easycase_uid').val(response.task_id);
            						if((getHash() == 'timelog' || getHash() == 'calendar_timelog') && select_edprj == 'all'){
            							$('#projFil').val('all');
            						}else{
            							$('#projFil').val(projId);                        
													if($('#pname_dashboard_log').parent('button').is('disabled')){
            							updateAllProj('proj_'+projId,projId,'dashboard','0',ucpname,'',9);
            						}
												}
                        /**End of set drop down ***/
                        $('#lgtimebtn').show();
                        $('#lgquickloading').hide();
                        /*bottom project status with hour update*/
                        general.update_footer_total();
                        showTopErrSucc('success','<?php echo __('Time Entry Updated Successfully.');?>');
                        showTimeLogList(response.task_id);                        
                        if(getHash() == 'timelog' && !$("#myModalDetail").hasClass('in')){                            
                            ajaxTimeLogView();
                        }else if(getHash() == 'calendar_timelog'){
                            $('#check_cale_multple_time').val('');   
                            cal_view = $('#calendar_timelog').fullCalendar('getView');
                            getCalenderForTimeLog('calendar',cal_view.name);
							//return false;
                        }else if(getHash() == 'tasks' && !$("#myModalDetail").hasClass('in')){
                            var caseId = $('#log_task_id').val();
                            tasklisttmplAdd(caseId);
                            //easycase.refreshTaskList(); 
                        }else if(getHash() == 'kanban' && !$("#myModalDetail").hasClass('in')){
                            var caseId = $('#log_task_id').val();
                            tasklisttmplAdd(caseId,0,'sts');
                        }else if(getHash() == 'milestonelist' && !$("#myModalDetail").hasClass('in')){
                            showMilestoneList();
                        }else if(CONTROLLER == 'easycases' && PAGE_NAME == 'invoice'){
                                invoices.switch_tab('logtime');
                        }else if(getHash() == 'taskgroups'){
                            if($("#myModalDetail").hasClass('in')){
                                var task_id = $('#log_task_id').val();
                                ajaxTimeLogView('', '', '', task_id)
                            } else{
                                $("#empty_milestone_tr_thread" + response.task_milestone_id).find('.os_sprite' + response.task_milestone_id).trigger('click');
							setTimeout($("#empty_milestone_tr_thread" + response.task_milestone_id).find('.os_sprite' + response.task_milestone_id).trigger('click'), 5000);
                            }
                        }else{
                            var hasharr = getHash().split('/');                          
                            if(hasharr[0] == 'details' || $("#myModalDetail").hasClass('in')){
//                                var task_id = hasharr[1];
//                                if(hasharr[1] != response.task_id){
//                                    task_id = response.task_id;
//                                }
                                //reloadTaskDetail(getHash().replace('details/',''));
                                //reloadTaskDetail(task_id);
                                var task_id = $('#log_task_id').val();
                                ajaxTimeLogView('', '', '', task_id)
                            }else{
                                var tlview = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
                                window.location.href=HTTP_ROOT+"/dashboard#"+tlview;
                            }
                        }
							
						}, 2000);
                    }
                }
            });
        }
        function updateusers(projname){
            if (rsrch == "") {
                        $('.resource-select').find('.dropdownjs').find('ul').html('');
                        var usrhtml = "<option value=''>" + _('Select User') + "</option>";
                        if (SES_TYPE < 3) {
                            $.each(PUSERS, function(key, val) {
                                $.each(val, function(k1, v1) {
                                    var usrid = v1['User']['id'];
                                    var selected = '';
                                    usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
                                });
                            });
                        } else if (SES_TYPE == 3) {
                            $.each(PUSERS, function(key, val) {
                                $.each(val, function(k1, v1) {
                                    var usrid = v1['User']['id'];
                                    var selected = '';
                                    if (usrid == SES_ID) {
                                        usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
                                    }
                                });
                            });
                        }
                        $('#whosassign1').html(usrhtml);
                        if (logid == '') {
                            $('#whosassign1').val(SES_ID);
                        }
                        $('#whosassign1').next('.dropdownjs').find('input.fakeinput').val($('#whosassign1').find('option:selected').html());
                        $('#whosassign1').select2();
                    }
                    $(".loader_dv").hide();
        }
        
	function updatehrs(countr){
        if($('#skip_timeDuration').is(":not(:checked)")){

        // else {
        if(trim($('#strttime'+countr).val()) == '' && $('#hidden_timesheet_flag').val() != 1){
            showTopErrSucc('error','<?php echo __('Start time can not be left blank');?>');
            setTimeout(function() {
            $('#strttime'+countr).focus();
            }, 10);
            return false;
        }else if(trim($('#endtime'+countr).val()) == '' && $('#hidden_timesheet_flag').val() != 1){
            showTopErrSucc('error','<?php echo __('End time can not be left blank');?>');
            setTimeout(function() {
                $('#endtime'+countr).focus();
            }, 10);
            return false;
        }
        }
        <?php if(SES_TIME_FORMAT == 12){ ?>
            var regex = /^([1-9]|1[0-2]):([0-5]\d)\s?(AM|PM)?$/i; 
        <?php }else{ ?>
            var regex = /([01]?[0-9]|2[0-3]):[0-5][0-9]/ ;
        <?php } ?>

        if($('#strttime'+countr).val().match(regex) && $('#endtime'+countr).val().match(regex)){
            if($('#skip_timeDuration').is(":not(:checked)")){
		var logdt = $('#workeddt'+countr).val();
        var  a = 0;
        $( ".updatehrs" ).each(function( index ) {
            if($(this).val() == ""){
                a=1;
            }
        });
                if(a != 1 && $('#log_task_id').val() > 0){
                    $('#lgtimebtn').removeClass('loginactive');
	        }
		var st_time = $('#strttime'+countr).val();
                var st_tmsp = '0';
                var st_timespl= '0';
                var st_timesplit='0';
		        <?php if(SES_TIME_FORMAT == 12){ ?>
                    var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
                    st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm','') : st_time.replace('am','');
                    st_tmsp = st_time.split(":");
                    if(st_mode == 'pm'){
                        st_timespl = (st_tmsp[0] < 12 ) ? parseInt(st_tmsp[0]) + 12 : 12;
            		}else{
                        st_timespl = (st_tmsp[0] == 12 ) ? "00" : st_tmsp[0];
            		}
                <?php }else{ ?>
                    var st_mode = '';
                    st_tmsp = st_time.split(":");
                    st_timespl = st_tmsp[0];
                <?php } ?>
                st_timesplit = st_timespl+":"+st_tmsp[1];
                st_time_minute = (parseInt(st_timespl)*60)+parseInt(st_tmsp[1]);

		var en_time = $('#endtime'+countr).val();
                var en_tmsp = '';
                var en_timesplit = '';
                var en_timespl = '';
                <?php if(SES_TIME_FORMAT == 12){ ?>
                    var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
                    en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm','') : en_time.replace('am','');
                    en_tmsp = en_time.split(":");
                    
                    if(en_mode == 'pm'){
                        en_timespl = (en_tmsp[0] < 12 ) ? parseInt(en_tmsp[0]) + 12 : 12;
            		}else{
                        en_timespl = (en_tmsp[0] == 12 ) ? "00" : en_tmsp[0];
            		}
                <?php }else{ ?>
                    var en_mode ='';
                    en_tmsp = en_time.split(":");
                    en_timespl = en_tmsp[0];
                <?php } ?>
                en_timesplit = en_timespl+":"+en_tmsp[1];
                var en_time_minute = (parseInt(en_timespl)*60)+parseInt(en_tmsp[1]);
                
                if( st_time_minute <= en_time_minute){
                    
                }else{
                    //adding 24 hr to end time
                    en_time_minute = en_time_minute+1440;
                }
                var spend_duration = en_time_minute-st_time_minute;
                //console.log(en_time_minute+' >> '+st_time_minute+' >> '+spend_duration);
		/*var stdt = logdt + " "+st_timesplit;
		var enddt = logdt + " "+en_timesplit;	
		var d2 = new Date(enddt);
		var d1 = new Date(stdt);
		diffinmins = ((d2-d1)/60000) ;*/
                
		diffinmins = spend_duration ;
		diffhours = Math.floor(diffinmins/60);
		diffmins = (diffinmins%60);
		//$('#tshr'+countr).val();
                var final_spend = (diffhours)+':'+(diffmins>9?diffmins:'0'+diffmins);
		$('#tsmn'+countr).val(final_spend);
                calculate_break($('#ul_timelog'+countr));
            }else{
                if(!$('#strttime'+countr).val().match(regex)){
                    if($('#hidden_timesheet_flag').val() != 1){            
                    showTopErrSucc('error','<?php echo __('Invalid time format');?>');
                    }
                    setTimeout(function() {
                        $('#strttime'+countr).focus();
                    }, 10);
                    $('#strttime'+countr).val('');
                    return false;
                }
                if(!$('#endtime'+countr).val().match(regex)){
                    if($('#hidden_timesheet_flag').val() != 1){            
                    showTopErrSucc('error','<?php echo __('Invalid time format');?>');
                    }
                    setTimeout(function() {
                        $('#endtime'+countr).focus();
                    }, 10);
                    $('#endtime'+countr).val('');
                    return false;
                }
            }
	}
	}
	
	function appendnewrow(){
                //clone.find('label').html('').remove();
                var nclone = clone.clone();
                nclone.find('.margin52').addClass('margin15').removeClass('margin52');
                nclone.find('.ui-timepicker-select').remove();
                nclone.find('.ui-timepicker-input').removeClass('ui-timepicker-input');
                nclone.find('.hasDatepicker').removeClass('hasDatepicker');
                
	        cntr++;
                
                nclone.attr('id','ul_timelog'+cntr)
                nclone.find('input,select,li,a').each(function(){
                    var type = this.type || this.tagName.toLowerCase();
                    
                    var oldid = $(this).attr('id');
                    if(typeof oldid !='undefined'){
                        var newid = oldid.replace(/\d+/,cntr); 
                        $(this).attr('id',newid);
                    }
                    if($(this).hasClass('updatehrs')){
                        $(this).attr({onchange:"updatehrs("+cntr+")"});
                    }
                    if(type == 'select-one'){
                        //console.log($(this).val());
                    }
                    if(type == 'text'){
                        $(this).val('');
                    }
                });
	        var cdate = "<?php echo date('M d, Y',strtotime('now')); ?>";
                
		if($('.log-time').append(nclone)){
        if($('#skip_timeDuration').is(":checked")){           
        $('.start_tm, .end_tm, .break_tm').hide();   
    }
        }
                $("#crsid"+cntr).attr('onclick','removeUI('+cntr+');')
		$("#workeddt"+cntr).datepicker({
            format: 'M d, yyyy',
						todayHighlight: true,
            changeMonth: false,
            changeYear: false,
            hideIfNoPrevNext: true,
            sautoclose:true
        });
                $("#workeddt"+cntr).val(moment(new Date()).format('MMM DD, YYYY'));
                $("#tsmn"+cntr).val("00:30");
                $("#is_billable"+cntr).val(cntr);
		var d= new Date();
                
		$('#strttime'+cntr).timepicker({
			'minTime': '12:00am',
			'step': '30',
			//'forceRoundTime': true,
			//'useSelect':true,
                        'maxTime':'11:59pm',			
		});
		$('#endtime'+cntr).timepicker({
			'minTime': '12:00am',
			'step': '30',
			//'forceRoundTime': true,
			//'useSelect':true,
			'maxTime':'11:59pm',
		});
	        $('#endtime'+cntr).timepicker('setTime', d);
		d.setMinutes(d.getMinutes() - 30);
		$('#strttime'+cntr).timepicker('setTime', d);

        <?php  if(SES_TIME_FORMAT == 24){ ?>                     
                $('#endtime' + cntr).timepicker({'timeFormat': 'H:i'});
                $('#strttime' + cntr).timepicker({'timeFormat': 'H:i'});
         <?php } ?>
		
		//$('#endtime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());
		//$('#strttime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());
                
		var d= new Date();
		
		$('#endtime'+cntr).on('changeTime', function() {
			//$('#strttime'+cntr).timepicker('option', 'maxTime', $('#endtime'+cntr).val());
		});
		$('#strttime'+cntr).on('changeTime', function() {
			//$('#endtime'+cntr).timepicker('option', 'minTime', $('#strttime'+cntr).val());
		});
		var usrhtml = "";//<option value=''>Select User</option>
		if(rsrch == ""){
            if(SES_TYPE < 3){
               /* $.each(PUSERS, function (key, val) {
                    $.each(val, function (k1, v1) {
				var usrid = v1['User']['id'];
                        var selected = (usrid===SES_ID)?"selected='selected'":"";
                        usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
			});
                    }); */
				$.each(TLUSER, function (k1, v1) {
				var usrid = v1['User']['id'];
                        var selected = (usrid===SES_ID)?"selected='selected'":"";
                        usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
			});
            }else if(SES_TYPE == 3){
				/*
                $.each(PUSERS, function (key, val) {
                    $.each(val, function (k1, v1) {
                        var usrid = v1['User']['id'];
                        var selected = (usrid===SES_ID)?"selected='selected'":"";
                        if(usrid == SES_ID){
                            usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
                        }
                    });
                }); */
				$.each(TLUSER, function (k1, v1) {
                        var usrid = v1['User']['id'];
                        var selected = (usrid===SES_ID)?"selected='selected'":"";
                        if(usrid == SES_ID){
                            usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
                        }
                    });
            }
		}else{
                    usrhtml = rsrch;
		}
    $('#whosassign'+cntr).html(usrhtml);
$('#whosassign'+cntr).val(SES_ID);
    
    ($("[id^='ul_timelog']").length < 2)?$(".crsid").hide():$(".crsid").show();
$('#whosassign'+cntr).select2();				   
    $.material.init();
    //$('.select').dropdown();
	}
	
	function removeUI(countr){
            $("#ul_timelog"+countr).remove();
            ($("[id^='ul_timelog']").length < 2)?$(".crsid").hide():$(".crsid").show();                    
	}
	
	function displayblock(showid,hiddenid){
		$('#'+showid).show();
		$('#'+hiddenid).hide();
	}
        
        function calculate_break($ul){
            $ul.find('.totalbreak').val($ul.find('.totalbreak').val().replace(/[^\d\:\.]+/g,''));
            var break_time = $.trim($ul.find('.totalbreak').val())!=''?$.trim($ul.find('.totalbreak').val().replace('-','')):'0';
            var spend_time = $.trim($ul.find('.totalduration').val());
            //console.log(break_time+" >> "+spend_time);
            var br_hr = '00';
            var br_min = '00';
            var br_time = '';
            var extra_hr = '';
            if(break_time.indexOf('.')>'-1'){
                /*converting to minute*/
                br_time = isNaN(break_time) ? 0 : break_time*60;
                br_hr = Math.floor(br_time/60);
                br_min = Math.floor(br_time%60);
            }else if(break_time.indexOf(':')>'-1'){
                br_time = break_time.split(':');
                extra_hr = (br_time[1] == '') ? 0 : Math.floor(parseInt(br_time[1])/60);
                //br_hr = parseInt(br_time[0])+parseInt(extra_hr);
                br_hr = (br_time[0] == '') ? 0 : (parseInt(br_time[0])+parseInt(extra_hr));
                br_min = (br_time[1] == '') ? 0 : Math.floor(br_time[1]%60);
            }else{
                br_hr = break_time;                
                br_min = '0';
            }

            var sp_time = spend_time.split(':');
            var total_sp_min = (parseInt(sp_time[0])*60)+parseInt(sp_time[1]);
            var total_br_min = (parseInt(br_hr)*60)+parseInt(br_min);
            //console.log(total_sp_min+' < '+total_br_min);
            var spend_duration = total_sp_min-total_br_min;
            var sp_hr = Math.floor(spend_duration/60);
            var sp_min = Math.floor(spend_duration%60);
            /*if final spent is greater than zero then it will place the value else will make it empty*/
            var final_sp = parseInt(sp_hr)>0 || parseInt(sp_min) > 0 ? parseInt(sp_hr)+':'+(sp_min<10?"0":"")+sp_min : '0:00';
            
            if($('#skip_timeDuration').is(":not(:checked)")){
            if(total_sp_min<total_br_min){
                showTopErrSucc('error','<?php echo __('Break time can not exceed the total spent hours.');?>');
                return false;
            }else if(total_sp_min == total_br_min){
                showTopErrSucc('error','<?php echo __('Break time can not same as the total spent hours.');?>');
                return false;
            }
        }
            /*if final break is greater than zero then it will place the value else will make it empty*/
            var final_br = parseInt(br_hr)>0 || parseInt(br_min) > 0 ? (br_hr<10?"0":"") +br_hr +':' + (br_min<10?"0":"") +br_min:'';
            /*assigning values to time spent and break time fields */
            $ul.find('.totalduration').val($ul.find('.totalduration').val()!='' && final_sp==''?$ul.find('.totalduration').val():final_sp);
            $ul.find('.totalbreak').val(final_br);
        }
        
        function calulate_break_minute($ul){
            var break_time = $ul.find('.totalbreak').val();
            var br_hr = '00';
            var br_min = '00';
            var br_time = '';
            var extra_hr = '';
            if(break_time.indexOf('.')>'-1'){
                br_time = break_time*60;
                br_hr = Math.floor(br_time/60);
                br_min = Math.floor(br_time%60);
            }else if(break_time.indexOf(':')>'-1'){
                br_time = break_time.split(':');
                extra_hr = Math.floor(parseInt(br_time[1])/60);
                br_hr = parseInt((br_time[0]=='')?0:br_time[0])+parseInt(extra_hr);                
                br_min = Math.floor(br_time[1]%60);
            }else{
                br_hr = break_time;                
                br_min = '0';
            }

            var total_br_min = (parseInt(br_hr)*60)+parseInt(br_min);
            return total_br_min;
        }
        function calulate_spend_minute($ul){
            /*var spend_time = $ul.find('.totalduration').val();                        
            var sp_time = spend_time.split(':');
            var total_sp_min = (parseInt(sp_time[0])*60)+parseInt(sp_time[1]);
            return total_sp_min;*/
            $id = ($ul.attr('id').replace(/\D+/g,''));
            var st_time = $('#strttime'+$id).val();
            var st_tmsp = '0';
            var st_timespl= '0';
            var st_timesplit='0';
            <?php if(SES_TIME_FORMAT == 12){ ?>
                var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
                st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm','') : st_time.replace('am','');
                st_tmsp = st_time.split(":");
                if(st_mode == 'pm'){
                    st_timespl = (st_tmsp[0] < 12 ) ? parseInt(st_tmsp[0]) + 12 : 12;
                }else{
                    st_timespl = (st_tmsp[0] == 12 ) ? "00" : st_tmsp[0];
                }
            <?php }else{ ?>
                var st_mode ='';
                st_tmsp = st_time.split(":");
                st_timespl = st_tmsp[0];
            <?php } ?>
            st_timesplit = st_timespl+":"+st_tmsp[1];
            st_time_minute = (parseInt(st_timespl)*60)+parseInt(st_tmsp[1]);


            var en_time = $('#endtime'+$id).val();
            var en_tmsp = '';
            var en_timespl = '';
            <?php if(SES_TIME_FORMAT == 12){ ?>
                var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
                en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm','') : en_time.replace('am','');
                en_tmsp = en_time.split(":");
                if(en_mode == 'pm'){
                    en_timespl = (en_tmsp[0] < 12 ) ? parseInt(en_tmsp[0]) + 12 : 12;
                }else{
                    en_timespl = (en_tmsp[0] == 12 ) ? "00" : en_tmsp[0];
                }
            <?php }else{ ?>
                var en_mode = '';
                en_tmsp = en_time.split(":");
                en_timespl = en_tmsp[0];
            <?php } ?>
            var en_time_minute = (parseInt(en_timespl)*60)+parseInt(en_tmsp[1]);

            if( st_time_minute <= en_time_minute){

            }else{
                //adding 24 hr to end time
                en_time_minute = en_time_minute+1440;
            }
            var spend_duration = en_time_minute-st_time_minute;
            /*diffinmins = spend_duration ;
            diffhours = Math.floor(diffinmins/60);
            diffmins = (diffinmins%60);
            var final_spend = (diffhours)+':'+(diffmins>9?diffmins:'0'+diffmins);*/
            return spend_duration;
        }
</script>