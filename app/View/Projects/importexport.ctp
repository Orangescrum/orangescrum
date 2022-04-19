<style type="text/css">
    .import_project_div #pname_dashboard{max-width:226px;}
</style>
<div class="user_profile_con setting_wrapper task_listing import-export-page cmn_tbl_widspace width_hover_tbl">
    <!--Tabs section starts -->
    <?php echo $this->element('import_page_tabs', array('mode' => 'importexport')); ?> 
    <div class="imp-exp-upu">
        <ul id="breadcrumbs_imp">
            <li <?php if (PAGE_NAME == 'importexport') { ?>class="activ"<?php } ?>><?php echo __('Upload File');?></li>
            <li <?php if (PAGE_NAME == 'csv_dataimport') { ?>class="activ"<?php } ?> ><?php echo __('Preview Data');?></li>
            <li <?php if (PAGE_NAME == 'confirm_import') { ?>class="activ"<?php } ?>><?php echo __('Upload Summary');?></li>
        </ul>
    </div>
    <?php if (PAGE_NAME != 'confirm_import') { ?>
        <div class="row exp_innerdiv" id="imploade_file"  <?php
        if (isset($fileds)) {
            echo "style='display:none;'";
        }
        ?>>
            <div class="col-lg-5 col-sm-5">
                <div class="import-csv-file">
                    <div class="import_project_div mtop20 mbtm15 pr">
                        <span class="browse-file-name"><?php echo __('Project');?>:</span> 
                                <?php if ((count($getallproj) == 0) && (SES_TYPE == 1 || SES_TYPE == 2)) { ?>
                            <button onclick="setSessionStorage('Import Export No Project', 'Create Project');
                                    newProject('menupj', 'loaderpj');"><?php echo __('Create Project');?></button>
                        <?php } else { ?>
                            <?php if (count($getallproj) == '0') { ?>
                                --<?php echo __('None');?>--
                            <?php } else { ?>
                                <?php
                                // if (count($getallproj) == '1') {
                                //echo $getallproj['0']['Project']['name'];
                                //$swPrjVal = $getallproj['0']['Project']['name'];
                                //} else {
                                $swPrjVal = $import_pjname;
                                ?>
                                <a href="javascript:void(0);" onclick="view_project_menu('import');" data-toggle="dropdown" class="option-toggle" id="prj_ahref">
                                    <span id="pname_dashboard"><?php echo $this->Format->shortLength(ucfirst($swPrjVal), 30); ?></span>
                                    <i class="caret"></i>
                                </a>
                                <div class="dropdown-menu lft popup scroll-project" id="projpopup">
                                    <center>
                                        <div id="loader_prmenu" style="display:none;">
                                            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading..." title="loading..."/>
                                        </div>
                                    </center>
            <?php if (count($getallproj) >= 6) { ?>
                                        <div id="find_prj_dv" style="display: none;">
                                            <input type="text" placeholder="<?php echo __('Find a Project');?>" class="form-control pro_srch" onkeyup="search_project_menu('import', this.value, event)" id="search_project_menu_txt">
                                            <i class="icon-srch-img"></i>
                                            <div id="load_find_dashboard" style="display:none;" class="loading-pro">
                                                <img src="<?php echo HTTP_IMAGES; ?>images/del.gif"/>
                                            </div>
                                        </div>
            <?php } ?>
                                    <input type="hidden" id="caseMenuFilters" value="" />
                                    <div id="ajaxViewProject" style='display:none;'></div>
                                    <div id="ajaxViewProjects"></div>
                                </div>
                                <?php // }  ?>
        <?php } ?>
    <?php } ?>
                    </div>			
                    <form action="<?php echo HTTP_ROOT; ?>projects/csv_dataimport/<?php echo $proj_uid; ?>" enctype="multipart/form-data" method="post" name="data_import_form" id="data_import_form">
                        <input type="hidden" value="<?php echo $proj_id; ?>" name="proj_id" id="proj_id"/> 
                        <input type="hidden" value="<?php echo $proj_uid; ?>" name="proj_uid" id="proj_uid"/> 
                        <!--<div class="upld_file">Upload your CSV file</div>-->
                        <!--<div class="fl customfile-button">
                            <input type="file" class="fl" name="import_csv" id="import_csv" onchange="check_csvfile()"/>
                            <div>Choose file</div>
                        </div>-->
                        <!--<span class="upload_limit" style="color:#333333"><b>2 MB</b> or <b>1,000</b> rows maximum size</span>-->
                        <div class="form-group">
                            <input multiple="" type="file" name="import_csv" id="import_csv" onchange="check_csvfile();
                                    check_multiple_project();
                                    $('#cnt_btn').prop('disabled', false);"/>
                            <div class="input-group">
                                <input readonly="" class="form-control" placeholder="<?php echo __('Upload your CSV file');?>" type="text" id="task_impot_placeholder">
                                <span class="input-group-btn input-group-sm">
                                    <button type="button" class="btn btn-fab btn-fab-mini">
                                        <i class="material-icons import-attach-icon">attach_file</i>
                                    </button>
                                </span>
                            </div>
                            <span class="upload_limit"><b>2 MB</b> <?php echo __('or');?> <b>1,000</b> <?php echo __('rows maximum size');?></span>
                        </div>
                        <span id="err_span" style="color:#900;font-size:12px"></span>
                        <div class="import_btn_div text-right">
                            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..."  id="loader_img_csv" style="display: none;"/>
                            <button type="submit" id="cnt_btn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size cmn_disabled_btn" disabled="true">
                                <i class="icon-big-tick"></i>
                                <span><?php echo __('Continue');?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 col-sm-7">
                <div class="import-info-dif import_proj">
                    <div class="chk_content">
                        <h4 class="chk_head"><?php echo __('CSV File');?></h4>
                        <div class="download_samplefile">
                            <a href="<?php echo HTTP_ROOT; ?>projects/download_sample_csvfile"><?php echo __('Download the sample file');?></a> <?php echo __('to see what you can import');?>
                        </div>
                        <ul class="chk_desc">
                            <li><b><?php echo __('Project');?> </b> <?php echo __('"Project Name" is mandatory when all project is selected');?>.</li>
                            <li><b><?php echo __('Task Group');?> / <?php echo __('Sprint');?> </b></li>
                            <li><b><?php echo __('Title');?> - </b> <?php echo __('Task Title');?> - <span><?php echo __('mandatory');?> (<?php echo __('max characters limit is 240');?>)</span></li>
                            <li><b><?php echo __('Description');?> - </b> <?php echo __('Description of the task');?></li>
							<li><b><?php echo __('Start Date');?> - </b> <?php echo __('Start date of Task (mm-dd-yyyy)');?> </li>
                            <li><b><?php echo __('Due Date');?> - </b> <?php echo __('Due date of Task (mm-dd-yyyy)');?> </li>
                            <li><b><?php echo __('Status');?> - </b> <?php echo __('Current status of the Task (NEW, IN PROGRESS, RESOLVED, CLOSED) or the custom task status name');?></li>
                            <li><b><?php echo __('Type');?> - </b> <?php echo __('Task type (Bug, Development, Enhancement, RnD, QA, Unit Testing, Maintenance, Release, Updates, Idea, Others)');?> </li>
                            <li><b><?php echo __('Assign to');?>  - </b> <?php echo __('Email ID of Task Assigned To');?></li>
														<li><b><?php echo __('Priority');?>  - </b> <?php echo __('Priority (high, medium, low)');?></li>
                            <li><b><?php echo __('Created By');?>  - </b> <?php echo __('Email ID of The Who Created The Task');?></li>
                            <li><b><?php echo __('Estimated Hour');?>  - </b>(<span><?php echo __('hh:mm format only');?></span>)</li>
                            <li><b><?php echo __('Start Time & End Time');?>  - </b>(<span><?php echo __('hh:mmam/pm format only, Ex. 10:45am/10:45pm - no space between time and meridian');?></span>)</li>
                            <li><b><?php echo __('Break Time');?>  - </b>(<span><?php echo __('hh:mm format only');?></span>)</li>
                            <li><b><?php echo __('Is Billable');?>  - </b>(0,1)</li>

                        </ul>

                        <h4 class="chk_head"><?php echo __('Help');?></h4>
                        <ul class="chk_desc">
                            <li><?php echo __('Choose a project to Import Task');?> <br /><font style="color:red;"><?php echo __('NOTE');?> :-</font> <br /><?php echo __('We can upload more one project if we select "All" project from project dropdown');?></li>
                            <li><?php echo __('Upload the valid CSV file with your Tasks');?></li>
                            <li><?php echo __('First system will prompt a preview of all the data in the file');?></li>
                            <li><?php echo __('In preview you can validate your data');?></li>
                            <li><?php echo __('Confirm the data in the preview and Import them to the system');?></li>
                            <li><?php echo __('All the Tasks will be posted to the selected Project');?>.</li>
                            <li><?php echo __('Start Time, End Time and Break Time will be treated as time log for the individual task');?>.</li>
                            <li><?php echo __('Is Billable is treated as whether the Time Log is billable one or not. The input will be either 0 or 1');?>.<br /> <?php echo __('0 - Not Billable');?><br /><?php echo __('1 - Billable');?></li>
                            <li><span><?php echo __('Left blank the columns having no entry');?>.</span></li>
                        </ul>
                <!--<div class="fr more-help-tips"><a href="<?php echo HTTP_ROOT; ?>projects/learnmore" target="_blank" onclick="window.open(this.href, this.target, 'width=430,height=450,resizable,scrollbars');return false;"> More on Help & Tips</a></div>-->
                        <!--<div class="cb"></div>-->
                    </div>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div id="review_data" <?php if (!isset($fileds)) { ?>style="display: none;"<?php } ?>>
    <?php if (isset($fileds)) { ?>
                <form action="<?php echo HTTP_ROOT; ?>projects/confirm_import/<?php echo $porj_uid; ?>" method="post" >
                    <input type="hidden" value="<?php echo $porj_id; ?>" name="project_id" /> 
                    <input type="hidden" value="<?php echo $csv_file_name; ?>" name="csv_file_name" /> 
                    <input type="hidden" value="<?php echo $total_rows; ?>" name="total_rows" /> 
                    <input type="hidden" value="<?php $mserialize = serialize($milestone_arr);
                   echo htmlentities($mserialize);
                   ?>" name="milestone_arr"/>
                    <input type="hidden" value="<?php echo $new_file_name; ?>" name="new_file_name"/> 				

                    <textarea name="task_arr" style="display:none;"><?php echo json_encode($task); ?></textarea>
                    <div class="imp_data_outer mbtm30 weekly_btm_sumry imp_task">
        <?php if (isset($task_err) && $task_err) { ?>
                            <div class="data-import-err">
                                <h2 class="cmn_h2"><span><?php echo __('Project');?>:&nbsp;</span><?php echo $projectname; ?></h2>
                                <p class="text-success" <?php if (count($task) == 0) { ?>style="color:red"<?php } else { ?>style="color:green"<?php } ?>>
                                    <b><?php echo count($task); ?></b> <?php echo __('Tasks to Import');?>
                                </p>
                                <p class="text-muted"><?php echo __('Please double-check(specifically text showing in red color) the below points before importing your Tasks');?></p>
                                <ul>
                                    <li><?php echo __('Blank Title');?></li>
                                    <li><?php echo __('Invalid Due Date');?> (<?php echo __('should be');?> <b>MM</b>/<b>DD</b>/<b>YYYY</b>)</li>
                                    <li><?php echo __('Invalid or Misspelled Status');?></li>
                                    <li><?php echo __('Invalid or Misspelled Type');?></li>
                                    <li><?php echo __('Unknown Assigned To Email ID (User must be associated with the project)');?></li>
                                    <li><?php echo __('Unknown Create By Email ID (User must be associated with the project)');?></li>
                                    <li><?php echo __('Invalid Estimated Hour');?></li>
                                    <li><?php echo __('Invalid start time or end time or break time or spent hour');?></li>
                                    <li><?php echo __('If');?> "<?php echo __('Project Name');?>" <?php echo __('are showing in red color then project does not exits in your application, it will be created as new project');?></li>
                                    <li>"<?php echo __('Assigned To');?>" <?php echo __('must be a valid email address of an existing/invited user in Orangescrum');?>.</li>
                                </ul>
																<?php if($is_ttl_length){ ?> 
																<div style="position: absolute;font-size: 15px;color: #ff0000;"> 
																	<?php echo __('We have found').' '.$is_ttl_length.' '.__('tasks having character length more than 240.'); ?> <br />
																	<?php echo __('Limit the task title to 240 at max, otherwise it will be truncated after upload.');?>
																</div>
																<?php } ?>
                                <button type="submit" class="fr btn btn-sm btn_cmn_efect cmn_bg btn-info cmn_size" style="position:relative;">
                                    <i class="icon-big-tick"></i>
                                    <?php echo __('Confirm & Import');?>
                                </button>
                                <button type="button" class="fr btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="deleteCsvFile('<?php echo $new_file_name; ?>');"  style="margin-right:10px;"><?php echo __('Cancel');?></button>
                                <div class="cb"></div>
                            </div>
                        </div>
        <?php }
        ?>
                    <div class="cmn_tbl_widspace imprt_task_page_tbl">
                        <table class="table table-striped table-hover tsk_tbl arc_tbl" id="preview_data_tbl">
                            <thead>
                                <tr class="tab_tr">
                                    <th><?php echo __('Sl');?>#</th>
                                    <?php
                                    $_t_field_arr = array('estimated hour', 'start time', 'end time', 'break time');
                                    foreach ($fileds as $hk => $hv) {
                                        ?>
                                        <th><?php
                                            echo $hv;
                                            if (in_array(strtolower($hv), $_t_field_arr)) {
                                                echo ' (hh:mm)';
                                                if (strtolower($hv) == 'start time' || strtolower($hv) == 'end time') {
                                                    echo '(am/pm)';
                                                }
                                            }
                                            ?></th>
                                <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($task) && $task) {
                                    $error_arr = $task_err;
                                    $i = 0;
                                    foreach ($task AS $k => $v) {
                                        $i++;
                                        ?>
                                        <tr class="tr_all">
                                            <td><?php echo $i; ?> </td>
                                                <?php foreach ($fileds as $hk => $hv) { ?>
                                                    <?php if (isset($v[strtolower($hv)])) { ?>
                                                    <td <?php if ($error_arr[$k][strtolower($hv)]) {
                                    $err = 1;
                                                            ?>class="error-imp-data"<?php } ?> valign="top">
                                                        <?php
																												if (in_array(strtolower($hv), array('taskgroup', 'title', 'description'))) {
                                                            echo $this->Format->formatTitle($v[strtolower($hv)]);
                                                        } else {
                                                            echo htmlentities($v[strtolower($hv)]);
                                                        }
                                                        ?>
                                                    </td>
                                            <?php }
                                        }
                                        ?>
                                        </tr>
            <?php } ?>
            <?php //}}   ?>
        <?php } ?>
					</tbody>
        </table>
        </div>
        <?php if ($task) { ?>
					<div class="mtop20 text-right">
							<button type="button" class="btn btn-default btn_hover_link cmn_size mright5" data-dismiss="modal" onclick="deleteCsvFile('<?php echo $new_file_name; ?>');"><?php echo __('Cancel');?></button>
                                                <button type="submit" class="btn btn-sm btn_cmn_efect cmn_bg btn-info cmn_size" style="position:relative">
                                                    <i class="icon-big-tick"></i>
                                                    <?php echo __('Import');?>
                                                </button>
                                            </div>
        <?php } ?>
    <?php } ?>
        </div>
    </form>	
    </div>
<?php } else { ?>
    <div id="review_data">
        <h3><?php echo __('Upload Summary');?></h3>
        <table class="fyl_table" style="width:100%">
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td colspan="2"><span class="upld-sum-lebel"><?php echo __('Input CSV file');?>:&nbsp;</span><b><?php echo $csv_file_name; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="upld-sum-lebel"><?php echo __('Total data');?>:&nbsp;</span><b><?php echo!empty($newtotal_task) ? ($newtotal_task ) : 0; ?></b> <?php echo __('rows');?></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><span class="upld-sum-lebel"><?php echo __('Valid data');?>:&nbsp;</span><b><?php echo!empty($total_valid_rows) ? $total_valid_rows : 0; ?></b> <?php echo __('rows');?></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><b><?php echo $total_task; ?></b><span class="upld-sum-lebel"> <?php echo __('Task(s) Imported into project');?>:&nbsp;</span><b><?php echo!empty($proj_name) ? $proj_name : 'NA'; ?></b></td>
                        </tr>
                        <?php if (isset($non_create_projects) && !empty($non_create_projects)) { ?>
                            <tr>
                                <td colspan="2" ><span class="upld-sum-lebel"><?php echo __("Project(s) can't Imported");?> :&nbsp;</span><b><?php echo!empty($non_create_projects) ? $non_create_projects : 'NA'; ?></b> <i style='color:#ff0000;margin-left: 20px;'> <?php echo __('Project Limit Exceeded');?>!. <?php echo __('Please');?> <a href="<?php echo HTTP_ROOT . 'users/pricing' ?>" target="_blank"><?php echo __('Upgrade');?></a> .</i></td>
                            </tr>
    <?php } ?>
    <?php if ($non_existing_typ_with) { ?>
                            <tr>
                                <td colspan="4">
                                    <b>Note: </b>
                                    <span class="upld-sum-lebel" style="color:red;">
                                        <?php echo __('We found some non existence task type(s)/blank  spaces');?>: <span style="color:#639fed"><?php echo implode(', ', $non_existing_typ); ?></span> <br />
                                       <?php echo __(' We have replaced those task type(s) with');?>:  <span style="color:#639fed"><?php echo $non_existing_typ_with; ?></span>
                                        <br />
                                        <?php echo __('If you want to change the task type(s) then please follow the below steps');?>:
                                        <ul>
                                            <li><?php echo __('Go to the');?> <a href="<?php echo HTTP_ROOT . 'task-type'; ?>"><?php echo __('Task Type');?></a> <?php echo __('section and add');?> "+ <?php echo __('New Task Type');?>".</li>
                                            <li><?php echo __('Edit each task and update the task type');?>.</li>
                                        </ul>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php /* <tr>
                          <td valign="top">Milestone:&nbsp;</td>
                          <td>
                          <?php foreach ($history AS $key => $val) { ?>
                          <table style="text-align:left" cellpadding='0' cellspacing='0'>
                          <tr>
                          <td>
                          <?php echo $val['milestone_title']; ?> / <?php echo $val['total_task']; ?> Task(s)
                          </td>
                          </tr>
                          </table>
                          <?php } ?>
                          </td>
                          </tr> */ ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
<?php } ?>
</div>
</div>
<script type="text/javascript">
    function check_csvfile() {
        //$('#cnt_btn').attr('disabled','disabled');
        //$('#cnt_btn').removeClass('activ');
        var url = '<?php echo HTTP_ROOT; ?>' + 'projects/checkfile_existance';
        if ($('#import_csv').val()) {
            var file = $('#import_csv').val();
            var ext = file.split('.').pop();
            if (ext == 'csv' || ext == 'CSV') {
                var data = new FormData();
                jQuery.each($('#import_csv')[0].files, function (i, file) {
                    data.append('file-' + i, file);
                });
                data.append('porject_id', $('#proj_id').val());

                $('#loader_img_csv').css('display', 'inline-block');
                //$('#cnt_btn').hide();
                $.ajax({
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $('#loader_img_csv').hide();
                        //$('#cnt_btn').show();
                        $('#err_span').html('');
                        if (data.error) {
                            if (confirm(data.msg)) {
                                call_validation();
                                $('#cnt_btn').prop('disabled', false);
                                $('#cnt_btn').removeClass('cmn_disabled_btn');
                            }else{
															$('#import_csv').val('');
															$('#task_impot_placeholder').val('');
														}
                        } else {
                            $('#cnt_btn').prop('disabled', false);
                            $('#cnt_btn').removeClass('cmn_disabled_btn');
                        }
                    }
                });
            } else {
                $('#err_span').html('<?php echo __('Please upload a valid csv file');?><br/>');
                $('#import_csv').val('');
            }
        } else {
            $('#cnt_btn').prop('disabled', true);
            $('#cnt_btn').addClass('cmn_disabled_btn');
        }
    }
    function ajax_exportCsv(is_milestone) {
        openPopup();
        $(".exportcsv").show();
        $('#exportcsv_content').html('');
        //$('#expimppopup').toggle();
        var projFil = $('#projFil').val();
        if (parseInt(is_milestone)) {
            $("#popup_heading").text("<?php echo __('Export task group to CSV');?>");
        } else {
            $("#popup_heading").text("<?php echo __('Export Tasks to CSV');?>");
        }
        //$('#exporttaskcsv_popup').show();
        $('.loader_dv').show();
        $.post(HTTP_ROOT + "easycases/ajax_exportcsv", {"projUniq": projFil, "is_milestone": is_milestone}, function (res) {
            if (res) {
                //  $('#popdv_csv').hide();
                $('.loader_dv').hide();
                $('#exportcsv_content').show();
                $('#exportcsv_content').html(res);
                $.material.init();
                //$(".select").dropdown();
                $(".select").select2();
            }
        });
        // cover_open('cover','exporttaskcsv_popup');
    }

    function ExportCSV()
    {
        var projFil = $('#projFil').val();
        window.location = HTTP_ROOT + "easycases/exporttoCSV/" + projFil;
    }
    function exportcsv() {
        var chkedarr = new Array();
        var carr = new Array();
        var j = 0;
        $('input[id^="mstones"]').each(function (i) {
            if ($(this).attr('checked')) {
                j++;
                chkedarr.push($(this).val());
            }
        });
        if (j) {
            document.getElementById('check_csv').value = chkedarr;
            document.getElementById('check_typ').value = "printcsv";
            document.getElementById('idaud').submit();
        } else {
            alert('<?php echo __('Please select atleast one checkbox to export the task group tasks to csv');?>');
        }
    }
    function change_milestone(obj) {
        var strURL = $('#pageurl').val();
        strURL = strURL + "easycases/ajax_change_milestone";
        $.post(strURL, {"id": obj.value}, function (res) {
            if (res) {
                $("#milestone_dv").html(res);
            }
        });
    }
    function change_milestone_options(obj) {
        var strURL = $('#pageurl').val();
        strURL = strURL + "easycases/ajax_change_milestone_options";
        $.post(strURL, {"id": obj.value}, function (res) {
            if (res) {
                $('#tr_milestone_list .dropdownjs').find('ul').html('');
                $('#tr_milestone_list .dropdownjs').find('input.fakeinput').val('All');
                $("#milestone_list").html('');
                $("#milestone_list").html(res);
            }
        });
    }
	
	function change_status_options(obj) {
        var strURL = $('#pageurl').val();
        strURL = strURL + "easycases/ajax_change_status_options";
        $.post(strURL, {"id": obj.value}, function (res) {
            if (res) {
                $('#tr_export_sts_dropdown .dropdownjs').find('ul').html('');
                $('#tr_export_sts_dropdown .dropdownjs').find('input.fakeinput').val('All');
                $("#export_sts_dropdown").html('');
                $("#export_sts_dropdown").html(res);
            }
        });
    }

    function change_member_assignto(obj) {
        change_milestone_options(obj);
        change_status_options(obj);
        var strURL = $('#pageurl').val();
        strURL = strURL + "easycases/ajax_member_assignto";
        $.post(strURL, {"id": obj.value}, function (res) {
            if (res) {
                $("#tr_members").remove();
                $("#tr_assign_to").remove();
                $(res).insertAfter($("#tr_priority"));
                $.material.init();
                //$(".select").dropdown();
                $(".select").select2();
            }
        });
    }

    function showCustomRange(obj) {
        if (obj.value == 'cst_rng') {
            $("#tr_cst_rng").show();
        } else {
            $("#tr_cst_rng").hide();
        }
    }
    function deleteCsvFile(file) {
        strURL = HTTP_ROOT + "projects/deleteCsvFile";
        $.post(strURL, {"file": file}, function (res) {
            if (res) {
                window.location = HTTP_ROOT + 'import-export';
            }
        });
    }
    function call_validation() {
        var filename = $("#import_csv").val();
        var pro_id = $("#proj_id").val();
        var form = new FormData($('#data_import_form')[0]);
        if (pro_id == 'all') {
            var url = '<?php echo HTTP_ROOT; ?>' + 'projects/checkfile_csv_validation';
//            $('#loader_img_csv').show();
            $.ajax({
                url: url,
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    delete_file(filename);
                    if (data.trim() == 2) {
                        alert('<?php echo __('There is no project name column in the CSV');?>');
                        window.location = HTTP_ROOT + 'projects/importexport/' + pro_id;
                        $("#import_csv").val('');
                        $("#import_csv").html('');
                    }
                }
            });
        }
    }
    function check_multiple_project() {
        var filename = $("#import_csv").val();
        var pro_id = $("#proj_id").val();
        var pname = $("#pname_dashboard").html();
        var form = new FormData($('#data_import_form')[0]);
        var url = '<?php echo HTTP_ROOT; ?>' + 'projects/check_multiple_project';
        $.ajax({
            url: url,
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                if (data.trim() == 'more_pro') {
                    delete_file(filename);
                    var msg = '<?php echo __('You have chosen');?> "' + pname + '" <?php echo __('project to import task, but you are trying to import task(s) for project(s) other than selected project. Please choose (all) option from the project drop down menu to import multiple project(s) task(s) at a time');?>.';
                    showTopErrSucc('error', msg, 1);
                    setTimeout(function () {
                        window.location = HTTP_ROOT + 'import-export';
                    }, 15000);
                    $("#import_csv").val('');
                    $("#import_csv").html('');
                } else if (data.trim() == 'exists' || data.trim() == 'no_project') {

                } else if (data.trim() == 0 || data.trim() == 3) {
                    delete_file(filename);
                    var msg = "<?php echo __('Invalid CSV file'); ?>, <a href='" + HTTP_ROOT + "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'><?php echo __('Download'); ?></a> <?php echo __('and check with our sample file');?>.";
                    showTopErrSucc('error', msg, 1);
                    setTimeout(function () {
                        window.location = HTTP_ROOT + 'import-export';
                    }, 6000);
                }
            }
        });
    }
    function delete_file(file_name) {
        var url = '<?php echo HTTP_ROOT; ?>' + 'projects/delete_file';
        $.post(url, {"file_name": file_name}, function (res) {
        });
    }
    $(function () {
        var cont = "<?php echo $this->params['controller']; ?>";
        var action = "<?php echo $this->params['action']; ?>";
        if (cont == 'projects' && action == 'confirm_import') {
            var valid_val = "<?php echo!empty($total_valid_rows) ? $total_valid_rows : 0; ?>";
            if (valid_val != 0) {
                showTopErrSucc('success', "<?php echo __('Successfully imported');?>.");
            } else {
                var msg = "<?php echo __('Invalid CSV file');?>, <a href='" + HTTP_ROOT + "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'><?php echo __('Download');?></a> <?php echo __('and check with our sample file');?>.";
                showTopErrSucc('error', msg);
            }
        }
    });
</script>