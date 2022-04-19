var globalTimeoutDefect=null;
function defectPage(){
    window.location.href = HTTP_ROOT + 'defect';
}
function addNewDefectStatus() {
    $("#dfcterr_msg").hide();
    $('#new_def_status_title').html('New Bug Status');
    openPopup();
    $('#newdfct_btn').text('Add');
    $(".new_defectstatus").show();
    $(".dfctloader_dv").hide();
    $('#inner_defectstatus').show();
    $("#defect_status_nm").val('');
    $("#new-defectstatusid").val('');
    $("#defect_status_nm").focus();
}
function ChckAllBugForm(type){
    if(type == 'create'){
        $("#column_bug_all_fields").click(function(){
            if($(this).is(":checked")){
                $(".configbugfields").prop('checked',true);
            }else{
                $(".configbugfields").prop('checked',false);
            }
            $(".configbugfields").each(function(){
                showHideBugFields($(this).val(),type,'nosave');
            });
            SaveBugFormFields(type);
            e.preventDefault;
        });
    }
    if(type == 'edit'){
        $("#column_bug_edit_all_fields").click(function(){
            if($(this).is(":checked")){
                $(".configbugeditfields").prop('checked',true);
            }else{
                $(".configbugeditfields").prop('checked',false);
            }
            $(".configbugfields").each(function(){
                showHideBugFields($(this).val(),type,'nosave');
            });
            SaveBugFormFields(type);
            e.preventDefault;
        });
    }
}
function showHideBugFields(fieldId,type){
    if(type == 'create'){
        if ($("#column_bug_all_" + fieldId).is(':checked')) {
            $(".bug-field-" + fieldId).show();
        } else {
            $(".bug-field-" + fieldId).hide();
        }
        if (typeof arguments[2] == 'undefined') {
            SaveBugFormFields(type);
        }
        if ($(".configbugfields").length == $(".configbugfields:checked").length) {
            $("#column_bug_all_fields").prop("checked", true);
        } else {
            $("#column_bug_all_fields").prop("checked", false);
        }
    }
    if(type == 'edit'){
        if ($("#column_bug_edit_all_" + fieldId).is(':checked')) {
            $(".bug-edit-field-" + fieldId).show();
        } else {
            $(".bug-edit-field-" + fieldId).hide();
        }
        if (typeof arguments[2] == 'undefined') {
            SaveBugFormFields(type);
        }
        if ($(".configbugeditfields").length == $(".configbugeditfields:checked").length) {
            $("#column_bug_edit_all_fields").prop("checked", true);
        } else {
            $("#column_bug_edit_all_fields").prop("checked", false);
        }
    }
}
function SaveBugFormFields(type){
    if(type == 'create'){
        var checkedVals = $('input[id^="column_bug_all_"]:checkbox:checked').map(function() {
            if ($(this).attr('id') != 'column_bug_all_fields') {
                return this.value
            } else {};
        }).get();
    }
    if(type == 'edit'){
        var checkedVals = $('input[id^="column_bug_edit_all_"]:checkbox:checked').map(function() {
            if ($(this).attr('id') != 'column_bug_edit_all_fields') {
                return this.value
            } else {};
        }).get();
    }
    checkedVals.push(18);
    $.post(HTTP_ROOT + "defect/defects/saveDefectFormField", {
        "fieldID": checkedVals
    }, function(data) {
        if (data) {}
    });
}
function saveNewDefectStatus(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/addNewDefectStatus',
        type: 'POST',
        dataType: 'json',
        data: $('#customDefectStatusForm').serialize() ,
        success: function(response){
            ajaxDefectStatusLoad();
            if($('#add_df_status').is(":checked")){                        
                $('#defect_status_nm').val('');
            } else {                                            
                closePopup();                        
            } 
           
           
        }
    });
}
function addNewDefectOrigin() {
    openPopup();
    $('#new_def_ori_btn').text('Add');
    $('#new_def_origin_title').text('New Bug Origin');
    $('#add_another_origin').show();
    $("#def_origin_err_msg").hide();
    $(".new_defectorigin").show();
    $(".def_origin_loader_dv").hide();
    $('#inner_defectorigin').show();
    $("#defect_origin_nm").val('');
    $("#defect_origin_shnm").val('');
    $("#new-defectoriginid").val('');
    $("#defect_origin_nm").focus();
}

function addNewDefectResolution() {
    openPopup();
    $('#new_def_res_btn').text('Add');
    $('#new_def_res_title').text('New Bug Resolution');
    $('#add_another_resolution').show();
    $("#def_resolution_err_msg").hide();
    $(".new_defectresolution").show();
    $(".def_resolution_loader_dv").hide();
    $('#inner_defectresolution').show();
    $("#defect_resolution_nm").val('');
    $("#defect_resolution_shnm").val('');
    $("#new-defectresolutionid").val('');
    $("#defect_resolution_nm").focus();
}

function editDefectStatus(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btn').text(_('Update'));
    $('#new_def_status_title').html('Edit Bug Status');
    $('#defect_another_status').hide();
    $("#dfcterr_msg").hide();
    openPopup();
    $(".new_defectstatus").show();
    $(".dfctloader_dv").hide();
    $('#inner_defectstatus').show();
    $("#defect_status_nm").val(nm);
    $("#new-defectstatusid").val(id);
    $("#defect_status_nm").focus();
}

function editDefectOrigin(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#new_def_ori_btn').text(_('Update'));
    $('#new_def_origin_title').text('Edit Bug Origin');
    $('#add_another_origin').hide();
    $("#def_origin_err_msg").hide();
    openPopup();
    $(".new_defectorigin").show();
    $(".def_origin_loader_dv").hide();
    $('#inner_defectorigin').show();
    $("#defect_origin_nm").val(nm).keyup();
    $("#new-defectoriginid").val(id);
    $("#defect_origin_nm").focus();
}

function editDefectResolution(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#new_def_res_btn').text(_('Update'));
    $('#new_def_res_title').text('Edit Bug Resolution');
    $('#add_another_resolution').hide();
    $("#def_resolution_err_msg").hide();
    openPopup();
    $(".new_defectresolution").show();
    $(".def_resolution_loader_dv").hide();
    $('#inner_defectresolution').show();
    $("#defect_resolution_nm").val(nm).keyup();
    $("#new-defectresolutionid").val(id);
    $("#defect_resolution_nm").focus();
}

function validateDefectStatus() {
    $("#dfcterr_msg").hide();
    $("#dfctbtn").hide();
    $("#dfctloader").show();
    var msg = "";
    var nm = $.trim($("#defect_status_nm").val());
    var id = $.trim($("#new-defectstatusid").val());
    $("#dfcterr_msg").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msg").show().html(msg);
        $("#defect_status_nm").focus();
        $("#dfctbtn").show();
        $("#dfctloader").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msg").show().html(msg);
            $("#defect_status_nm").focus();
            $("#dfctbtn").show();
            $("#dfctloader").hide();
            return false;
        } else {
            $("#dfctbtn").hide();
            $("#dfctloader").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectStatus", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msg").hide();
                    $("#dfctbtn").show();
                    $("#dfctloader").hide();
                    // $('#customDefectStatusForm').submit();
                } else {
                    $("#dfctbtn").show();
                    $("#dfctloader").hide();
                    if (data.msg == 'name') {
                        //alert('Name already exists!. Please enter another name.');
                        $("#dfcterr_msg").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}
function ajaxDefectStatusLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_status',
        type: 'POST',
        dataType: 'json',
        data:{'dfStatus':1},
        success: function (response) {
            $("#defect_status_list_add").html(tmpl("defect_status_tmpl",response));
            $.material.init();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxDefectSeverityLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_severity',
        type: 'POST',
        dataType: 'json',
        data:{'dfSeverity':1},
        success: function (response) {
            $("#defect_severity_list_add").html(tmpl("defect_severity_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxDefectIssueTypeLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_issue_type',
        type: 'POST',
        dataType: 'json',
        data:{'dfIssueType':1},
        success: function (response) {
            $("#defect_issue_type_list_add").html(tmpl("defect_issue_type_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxDefectCategoryLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_category',
        type: 'POST',
        dataType: 'json',
        data:{'dfCategory':1},
        success: function (response) {
					$("#defect_category_list_add").html(tmpl("defect_category_tmpl",response));
					$('#defectLoader').hide();
					$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxdefectActivityTypeLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_activity_type',
        type: 'POST',
        dataType: 'json',
        data:{'dfActivityT':1},
        success: function (response) {
            $("#defect_activity_type_list_add").html(tmpl("defect_activity_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxDefectPhaseLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_phase',
        type: 'POST',
        dataType: 'json',
        data:{'dfPhase':1},
        success: function (response) {
            $("#defect_phase_list_add").html(tmpl("defect_phase_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function ajaxDefectRootCauseLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_root_cause',
        type: 'POST',
        dataType: 'json',
        data:{'dfRootCause':1},
        success: function (response) {
            $("#defect_root_cause_list_add").html(tmpl("defect_root_cause_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function DefectFixVersionLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_fix_version',
        type: 'POST',
        dataType: 'json',
        data:{'dfFixVersion':1},
        success: function (response) {
            $("#defect_fix_version_list_add").html(tmpl("defect_fix_version_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function DefectAffectVersionLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_affect_version',
        type: 'POST',
        dataType: 'json',
        data:{'dfAffectVersion':1},
        success: function (response) {
            $("#defect_affect_version_list_add").html(tmpl("defect_affect_version_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function DefectOriginLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_origin',
        type: 'POST',
        dataType: 'json',
        data:{'dfOrigin':1},
        success: function (response) {
            $("#defect_origin_list_add").html(tmpl("defect_origin_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function DefectResolutionLoad(){
    $.ajax({
        url: HTTP_ROOT + 'defect/defects/defect_resolution',
        type: 'POST',
        dataType: 'json',
        data:{'dfResolution':1},
        success: function (response) {
            $("#defect_resolution_list_add").html(tmpl("defect_resolution_tmpl",response));
            $('#defectLoader').hide();
						$('[rel="tooltip"]').tipsy({gravity:'s', fade:true});
        }

    }); 
}
function showEditDeleteFixVersion(){
       /* $('.dv_tsktyp').hover(function () {
            var tid = $(this).attr('data-id');
            if ($(this).find("#del_dvdfct_" + tid).length || $(this).find("#edit_dvdfct_" + tid).length) {
                alert("hii");
                $(this).find("#del_dvdfct_" + tid).show();
                $(this).find("#edit_dvdfct_" + tid).show();
            }
        }, function () {
            var tid = $(this).attr('data-id');
            if ($(this).find("#del_dvdfct_" + tid).length || $(this).find("#edit_dvdfct_" + tid).length) {
                $(this).find("#del_dvdfct_" + tid).hide();
                $(this).find("#edit_dvdfct_" + tid).hide();
            }
        
        });*/
}
function showEditDeleteAffectVersion(){
    // $('.dv_tsktyp').hover(function () {
    //     var tid = $(this).attr('data-id');
       
    //     if ($(this).find("#del_dvdfct_af_" + tid).length || $(this).find("#edit_dvdfct_af_" + tid).length) {
    //         $(this).find("#del_dvdfct_af_" + tid).show();
    //         $(this).find("#edit_dvdfct_af_" + tid).show();
    //     }
    // }, function () {
    //     var tid = $(this).attr('data-id');
    //     if ($(this).find("#del_dvdfct_af_" + tid).length || $(this).find("#edit_dvdfct_af_" + tid).length) {
    //         $(this).find("#del_dvdfct_af_" + tid).hide();
    //         $(this).find("#edit_dvdfct_af_" + tid).hide();
    //     }
    // });
}
function showEditDeleteOrigin(){
    $('.dv_tsktyp').hover(function () {
        var tid = $(this).attr('data-id');
        if ($(this).find("#del_defect_origin" + tid).length || $(this).find("#edit_defect_origin_" + tid).length) {
            $(this).find("#del_defect_origin" + tid).show();
            $(this).find("#edit_defect_origin_" + tid).show();
        }
    }, function () {
        var tid = $(this).attr('data-id');
        if ($(this).find("#del_defect_origin" + tid).length || $(this).find("#edit_defect_origin_" + tid).length) {
            $(this).find("#del_defect_origin" + tid).hide();
            $(this).find("#edit_defect_origin_" + tid).hide();
        }
    });
}
function showEditDeleteResolution(){
    $('.dv_tsktyp').hover(function () {
        var tid = $(this).attr('data-id');
        if ($(this).find("#del_defect_resolution_" + tid).length || $(this).find("#edit_defect_resolution_" + tid).length) {
            $(this).find("#del_defect_resolution_" + tid).show();
            $(this).find("#edit_defect_resolution_" + tid).show();
        }
    }, function () {
        var tid = $(this).attr('data-id');
        if ($(this).find("#del_defect_resolution_" + tid).length || $(this).find("#edit_defect_resolution_" + tid).length) {
            $(this).find("#del_defect_resolution_" + tid).hide();
            $(this).find("#edit_defect_resolution_" + tid).hide();
        }
    });
}
function validateEnterDefectStatus() {
    $("#dfcterr_msg").hide();
    $("#dfctbtn").hide();
    $("#dfctloader").show();
    var msg = "";
    var nm = $.trim($("#defect_status_nm").val());
    var id = $.trim($("#new-defectstatusid").val());
    $("#dfcterr_msg").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msg").show().html(msg);
        $("#dfctbtn").show();
        $("#dfctloader").hide();
        $("#defect_status_nm").focus();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msg").show().html(msg);
            $("#dfctbtn").show();
            $("#dfctloader").hide();
            $("#defect_status_nm").focus();
            return false;
        } else {
            $("#dfctbtn").hide();
            $("#dfctloader").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectStatus", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msg").hide();
                    $("#dfctbtn").hide();
                    $("#dfctloader").show();
                    return true;
                } else {
                    $("#dfctbtn").show();
                    $("#dfctloader").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msg").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateDefectOrigin() {
    $("#def_origin_err_msg").hide();
    $("#new_def_origin_btn").hide();
    $("#def_origin_loader_dv_save").show();
    var msg = "";
    var nm = $.trim($("#defect_origin_nm").val());
    var id = $.trim($("#new-defectoriginid").val());
    $("#def_origin_err_msg").html("");
    if (nm === "") {
        msg = _("'Origin' can not be left blank!");
        $("#def_origin_err_msg").show().html(msg);
        $("#new_def_origin_btn").show();
        $("#def_origin_loader_dv_save").hide();
        $("#defect_origin_nm").focus();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Origin' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#def_origin_err_msg").show().html(msg);
            $("#new_def_origin_btn").show();
            $("#def_origin_loader_dv_save").hide();
            $("#defect_origin_nm").focus();
            return false;
        } else {
            $("#new_def_origin_btn").hide();
            $("#def_origin_loader_dv_save").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectOrigin", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#def_origin_err_msg").hide();
                    $("#new_def_origin_btn").show();
                    $("#def_origin_loader_dv_save").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectOrigin',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectOriginForm').serialize() ,
                        success: function(response){
                            DefectOriginLoad();
                            if(response.DefectOrigin.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_origin').is(":checked")){                        
                                $('#defect_origin_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                } else {
                    $("#new_def_origin_btn").show();
                    $("#def_origin_loader_dv_save").hide();
                    if (data.msg == 'name') {
                        $("#def_origin_err_msg").show().html(_('Origin already exists!. Please enter another name.'));
                    } else {
                        $("#def_origin_err_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectOrigin() {
    $("#def_origin_err_msg").hide();
    $("#new_def_origin_btn").hide();
    $("#def_origin_loader_dv_save").show();
    var msg = "";
    var nm = $.trim($("#defect_origin_nm").val());
    var id = $.trim($("#new-defectoriginid").val());
    $("#def_origin_err_msg").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#def_origin_err_msg").show().html(msg);
        $("#new_def_origin_btn").show();
        $("#def_origin_loader_dv_save").hide();
        $("#defect_origin_nm").focus();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#def_origin_err_msg").show().html(msg);
            $("#new_def_origin_btn").show();
            $("#def_origin_loader_dv_save").hide();
            $("#defect_origin_nm").focus();
            return false;
        } else {
            $("#new_def_origin_btn").hide();
            $("#def_origin_loader_dv_save").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectOrigin", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#def_origin_err_msg").hide();
                    $("#new_def_origin_btn").hide();
                    $("#def_origin_loader_dv_save").show();
                    return true;
                } else {
                    $("#new_def_origin_btn").show();
                    $("#def_origin_loader_dv_save").hide();
                    if (data.msg == 'name') {
                        //$("#def_origin_err_msg").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#def_origin_err_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateDefectResolution() {
    var msg = "";
    var nm = $.trim($("#defect_resolution_nm").val());
    var id = $.trim($("#new-defectresolutionid").val());
    $("#def_resolution_err_msg").html("");
    if (nm === "") {
        msg = _("'Resolution' can not be left blank!");
        $("#def_resolution_err_msg").show().html(msg);
        $("#defect_resolution_nm").focus();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            $("#new_def_resolution_btn").show();
            $("#def_resolution_loader_dv_save").hide();
            msg = _("'Resolution' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#def_resolution_err_msg").show().html(msg);
            $("#defect_resolution_nm").focus();
            return false;
        } else {
            $("#new_def_resolution_btn").hide();
            $("#def_resolution_loader_dv_save").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectResolution", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.resolution == 'success') {
                    $("#def_resolution_err_msg").hide();
                    $("#new_def_resolution_btn").show();
                    $("#def_resolution_loader_dv_save").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectResolution',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectResolutionForm').serialize() ,
                        success: function(response){
                            DefectResolutionLoad();
                            if(response.DefectResolution.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_resolution').is(":checked")){                        
                                $('#defect_resolution_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                    // $('#customDefectResolutionForm').submit();
                } else {
                    $("#new_def_resolution_btn").show();
                    $("#def_resolution_loader_dv_save").hide();
                    if (data.msg == 'name') {
                        $("#def_resolution_err_msg").show().html(_('Resolution already exists!. Please enter another name.'));
                    } else {
                        $("#def_resolution_err_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectResolution() {
    $("#def_resolution_err_msg").hide();
    $("#new_def_resolution_btn").hide();
    $("#def_resolution_loader_dv_save").show();
    var msg = "";
    var nm = $.trim($("#defect_resolution_nm").val());
    var id = $.trim($("#new-defectresolutionid").val());
    $("#def_resolution_err_msg").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#def_resolution_err_msg").show().html(msg);
        $("#defect_resolution_nm").focus();
        $("#new_def_resolution_btn").show();
        $("#def_resolution_loader_dv_save").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            $("#new_def_resolution_btn").show();
            $("#def_resolution_loader_dv_save").hide();
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#def_resolution_err_msg").show().html(msg);
            $("#defect_resolution_nm").focus();
            $("#new_def_resolution_btn").show();
            $("#def_resolution_loader_dv_save").hide();
            return false;
        } else {
            $("#new_def_resolution_btn").hide();
            $("#def_resolution_loader_dv_save").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectResolution", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#def_resolution_err_msg").hide();
                    // $("#new_def_resolution_btn").hide();
                    // $("#def_resolution_loader_dv_save").show();
                    return true;
                } else {
                    $("#new_def_resolution_btn").show();
                    $("#def_resolution_loader_dv_save").hide();
                    if (data.msg == 'name') {
                        $("#def_resolution_err_msg").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#def_resolution_err_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}
function srchseverity(){
    var searchValue= $('.search_control').val();
		$(".dv_tsktyp").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchValue.toLowerCase()) > -1)
    });
}
function deleteDefectStatus(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug status") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectStatus", {
            "id": id
        }, function(res) {
            if (res.status == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug status") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _('Error in deletion of defect status.'));
            }
        }, 'json');
    }
}

function deleteDefectOrigin(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug origin") + " ?")) {
        $("#del_defect_origin_" + id).hide();
        $("#lding_defect_origin_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectOrigin", {
            "id": id
        }, function(res) {
            if (res.status == 'success') {
                $("#dv_defect_origin_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug origin") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_defect_origin_" + id).hide();
                $("#lding_defect_origin_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function deleteDefectResolution(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug resolution") + " ?")) {
        $("#del_defect_resolution_" + id).hide();
        $("#lding_defect_resolution_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectResolution", {
            "id": id
        }, function(res) {
            if (res.status == 'success') {
                $("#dv_defect_resolution_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug resolution") + " '" + nm + "' " + _("has deleted successfully") + ".");
                    DefectResolutionLoad();
                });
            } else {
                $("#lding_defect_resolution_" + id).hide();
                $("#lding_defect_resolution_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectStatus() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btn").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectStatus',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_status_id').serialize() ,
            success: function(response){
                ajaxDefectStatusLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug status.'));
        return false;
    }
}

function saveDefectOrigin() {
    var isTaskIds = 0;
    $(".all_defect_origin").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_defect_origin').attr('disabled', false);
        $("#defect_origin_save_btn").hide();
        $("#loader_img_defect_origin").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectOrigin',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_origin_submit_id').serialize(),
            success: function(response){
                DefectOriginLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug status.'));
        return false;
    }
}

function saveDefectResolution() {
    var isTaskIds = 0;
    $(".all_defect_resolution").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_defect_resolution').attr('disabled', false);
        $("#defect_resolution_save_btn").hide();
        $("#loader_img_defect_resolution").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectResolution',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_resolution_submit_id').serialize() ,
            success: function(response){
                ajaxDefectStatusLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug resolution.'));
        return false;
    }
}

function addNewDefectSeverity() {
    $("#dfcterr_msgseverity").hide();
    $('#new_def_ser_title').text(_('New Bug Severity'));
    openPopup();
    $('#add_another_severity').show();
    $('#newdfct_btnseverity').text('Add');
    $(".new_defectseverity").show();
    $(".dfctloader_dvseverity").hide();
    $('#inner_defectseverity').show();
    $("#defect_severity_nm").val('');
    $("#defect_severity_nm").focus();
    $("#defect_severity_shnm").val('');
    $("#new-defectseverityid").val('');
    
}

function editDefectSeverity(obj) {
    $("#dfcterr_msgseverity").hide();
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnseverity').text(_('Update'));
    $('#new_def_ser_title').text(_('Edit Bug Severity'));
    $('#add_another_severity').hide();
    openPopup();
    $(".new_defectseverity").show();
    $(".dfctloader_dvseverity").hide();
    $('#inner_defectseverity').show();
    $("#defect_severity_nm").val(nm).keyup();
    $("#new-defectseverityid").val(id);
    $("#defect_severity_nm").focus();
}

function validateDefectSeverity() {
    $("#dfcterr_msgseverity").hide();
    $("#dfctbtnseverity").hide();
    $("#dfctloaderseverity").show();
    var msg = "";
    var nm = $.trim($("#defect_severity_nm").val());
    var id = $.trim($("#new-defectseverityid").val());
    $("#dfcterr_msgseverity").html("");
    if (nm === "") {
        msg = _("'Severity' can not be left blank!");
        $("#dfcterr_msgseverity").show().html(msg);
        $("#defect_severity_nm").focus();
        $("#dfctbtnseverity").show();
        $("#dfctloaderseverity").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Severity' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgseverity").show().html(msg);
            $("#defect_severity_nm").focus();
            $("#dfctbtnseverity").show();
            $("#dfctloaderseverity").hide();
            return false;
        } else {
            $("#dfctbtnseverity").hide();
            $("#dfctloaderseverity").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectSeverity", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.severity == 'success') {
                    $("#dfcterr_msgseverity").hide();
                    $("#dfctbtnseverity").show();
                    $("#dfctloaderseverity").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectSeverity',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectSeverityForm').serialize() ,
                        success: function(response){
                            ajaxDefectSeverityLoad();
                            if(response.DefectSeverity.name !== ""){
                                showTopErrSucc('success', _('Your data saved successfully'));
                            }
                            if($('#add_df_severity').is(":checked")){                        
                                $('#defect_severity_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                    // $('#customDefectSeverityForm').submit();
                } else {
                    $("#dfctbtnseverity").show();
                    $("#dfctloaderseverity").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgseverity").show().html(_('Severity already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgseverity").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectSeverity() {
    $("#dfcterr_msgseverity").hide();
    $("#dfctbtnseverity").hide();
    $("#dfctloaderseverity").show();
    var msg = "";
    var nm = $.trim($("#defect_severity_nm").val());
    var id = $.trim($("#new-defectseverityid").val());
    $("#dfcterr_msgseverity").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgseverity").show().html(msg);
        $("#defect_severity_nm").focus();
        $("#dfctbtnseverity").show();
        $("#dfctloaderseverity").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgseverity").show().html(msg);
            $("#defect_severity_nm").focus();
            $("#dfctbtnseverity").show();
            $("#dfctloaderseverity").hide();
            return false;
        } else {
            $("#dfcterr_msgseverity").hide();
            $("#dfctbtnseverity").hide();
            $("#dfctloaderseverity").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectSeverity", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgseverity").hide();
                    $("#dfctbtnseverity").hide();
                    $("#dfctloaderseverity").show();
                    return true;
                } else {
                    $("#dfctbtnseverity").show();
                    $("#dfctloaderseverity").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgseverity").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgseverity").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectSeverity(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug severity") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectSeverity", {
            "id": id
        }, function(res) {
            if (res.severity == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug severity") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectSeverity() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (isTaskIds) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnseverity").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectSeverity',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_severity_from_id').serialize() ,
            success: function(response){
                ajaxDefectSeverityLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug severity.'));
        return false;
    }
}

function addNewDefectActivityType() {
    openPopup();
    $('#newdfct_btnactivity_type').text('Add');
    $('#new_def_act_title').text('New Activity Type');
    $('#add_another_activity_type').show();
    $("#dfcterr_msgactivity_type").hide();
    $(".new_defectactivity_type").show();
    $(".dfctloader_dvactivity_type").hide();
    $('#inner_defectactivity_type').show();
    $("#defect_activity_type_nm").val('');
    $("#defect_activity_type_shnm").val('');
    $("#new-defectactivity_typeid").val('');
    $("#defect_activity_type_nm").focus();
}

function editDefectActivityType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnactivity_type').text(_('Update'));
    $('#new_def_act_title').text('Edit Defect ActivityType');
    $('#add_another_activity_type').hide();
    $("#dfcterr_msgactivity_type").hide();
    openPopup();
    $(".new_defectactivity_type").show();
    $(".dfctloader_dvactivity_type").hide();
    $('#inner_defectactivity_type').show();
    $("#defect_activity_type_nm").val(nm).keyup();
    $("#new-defectactivity_typeid").val(id);
    $("#defect_activity_type_nm").focus();
}

function validateDefectActivityType() {
    $("#dfcterr_msgactivity_type").hide();
    $("#dfctbtnactivity_type").hide();
    $("#dfctloaderactivity_type").show();
    var msg = "";
    var nm = $.trim($("#defect_activity_type_nm").val());
    var id = $.trim($("#new-defectactivity_typeid").val());
    $("#dfcterr_msgactivity_type").html("");
    if (nm === "") {
        msg = _("'Activity Type' can not be left blank!");
        $("#dfcterr_msgactivity_type").show().html(msg);
        $("#defect_activity_type_nm").focus();
        $("#dfctbtnactivity_type").show();
        $("#dfctloaderactivity_type").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Activity Type' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgactivity_type").show().html(msg);
            $("#defect_activity_type_nm").focus();
            $("#dfctbtnactivity_type").show();
            $("#dfctloaderactivity_type").hide();
            return false;
        } else {
            $("#dfctbtnactivity_type").hide();
            $("#dfctloaderactivity_type").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectActivityType", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.activity_type == 'success') {
                    $("#dfcterr_msgactivity_type").hide();
                    $("#dfctbtnactivity_type").show();
                    $("#dfctloaderactivity_type").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectActivityType',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectActivityTypeForm').serialize() ,
                        success: function(response){
                            ajaxdefectActivityTypeLoad();
                            if(response.DefectActivityType.name !== ""){
                                showTopErrSucc('success', _('Your data saved successfully'));
                            }
                            if($('#add_df_activity_type').is(":checked")){                        
                                $('#defect_activity_type_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                } else {
                    $("#dfctbtnactivity_type").show();
                    $("#dfctloaderactivity_type").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgactivity_type").show().html(_('Activity type already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgactivity_type").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectActivityType() {
    $("#dfcterr_msgactivity_type").hide();
    $("#dfctbtnactivity_type").hide();
    $("#dfctloaderactivity_type").show();
    var msg = "";
    var nm = $.trim($("#defect_activity_type_nm").val());
    var id = $.trim($("#new-defectactivity_typeid").val());
    $("#dfcterr_msgactivity_type").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgactivity_type").show().html(msg);
        $("#defect_activity_type_nm").focus();
        $("#dfctbtnactivity_type").show();
        $("#dfctloaderactivity_type").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgactivity_type").show().html(msg);
            $("#defect_activity_type_nm").focus();
            $("#dfctbtnactivity_type").show();
            $("#dfctloaderactivity_type").hide();
            return false;
        } else {
            $("#dfctbtnactivity_type").hide();
            $("#dfctloaderactivity_type").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectActivityType", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgactivity_type").hide();
                    $("#dfctbtnactivity_type").hide();
                    $("#dfctloaderactivity_type").show();
                    return true;
                } else {
                    $("#dfctbtnactivity_type").show();
                    $("#dfctloaderactivity_type").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgactivity_type").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgactivity_type").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectActivityType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug activity_type") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectActivityType", {
            "id": id
        }, function(res) {
            if (res.activity_type == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug activity type") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectActivityType() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnactivity_type").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectActivityType',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_activity_type_form_id').serialize() ,
            success: function(response){
                ajaxdefectActivityTypeLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one defect activity type.'));
        return false;
    }
}

function addNewDefectCategory() {
    $("#dfcterr_msgcategory").hide();
    openPopup();
    $('#new_def_cat_title').html('New Bug Category');
    $('#newdfct_btncategory').text('Add');
    $('#add_another_category').show();
    $(".new_defectcategory").show();
    $(".dfctloader_dvcategory").hide();
    $('#inner_defectcategory').show();
    $("#defect_category_nm").val('');
    $("#defect_category_shnm").val('');
    $("#new-defectcategoryid").val('');
    $("#defect_category_nm").focus();
}

function editDefectCategory(obj) {
    $("#dfcterr_msgcategory").hide();
    $('#new_def_cat_title').html('Edit Bug Category');
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btncategory').text(_('Update'));
    $('#add_another_category').hide();
    $("#defect_category_nm").val(nm).keyup();
    $("#new-defectcategoryid").val(id);
    openPopup();
    $(".new_defectcategory").show();
    $(".dfctloader_dvcategory").hide();
    $('#inner_defectcategory').show();
    
    $("#defect_category_nm").focus();
}

function validateDefectCategory() {
    $("#dfcterr_msgcategory").hide();
    $("#dfctbtncategory").hide();
    $("#dfctloadercategory").show();
    var msg = "";
    var nm = $.trim($("#defect_category_nm").val());
    var id = $.trim($("#new-defectcategoryid").val());
    $("#dfcterr_msgcategory").html("");
    if (nm === "") {
        msg = _("'Category' can not be left blank!");
        $("#dfcterr_msgcategory").show().html(msg);
        $("#defect_category_nm").focus();
        $("#dfctbtncategory").show();
        $("#dfctloadercategory").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Category' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgcategory").show().html(msg);
            $("#defect_category_nm").focus();
            $("#dfctbtncategory").show();
            $("#dfctloadercategory").hide();
            return false;
        } else {
            $("#dfctbtncategory").hide();
            $("#dfctloadercategory").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectCategory", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.category == 'success') {
                    $("#dfcterr_msgcategory").hide();
                    $("#dfctbtncategory").show();
                    $("#dfctloadercategory").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectCategory',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectCategoryForm').serialize() ,
                        success: function(response){
                            ajaxDefectCategoryLoad();
                            if(response.DefectCategory.name !== ""){
                                showTopErrSucc('success', _('Your data saved successfully'));
                            }
                            if($('#add_df_category').is(":checked")){                        
                                $('#defect_category_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                   // $('#customDefectCategoryForm').submit();
                } else {
                    $("#dfctbtncategory").show();
                    $("#dfctloadercategory").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgcategory").show().html(_('Category already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgcategory").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectCategory() {
    $("#dfcterr_msgcategory").hide();
    $("#dfctbtncategory").hide();
    $("#dfctloadercategory").show();
    var msg = "";
    var nm = $.trim($("#defect_category_nm").val());
    var id = $.trim($("#new-defectcategoryid").val());
    $("#dfcterr_msgcategory").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgcategory").show().html(msg);
        $("#defect_category_nm").focus();
        $("#dfctbtncategory").show();
        $("#dfctloadercategory").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgcategory").show().html(msg);
            $("#defect_category_nm").focus();
            $("#dfctbtncategory").show();
            $("#dfctloadercategory").hide();
            return false;
        } else {
            $("#dfctbtncategory").hide();
            $("#dfctloadercategory").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectCategory", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgcategory").hide();
                    $("#dfctbtncategory").hide();
                    $("#dfctloadercategory").show();
                    return true;
                } else {
                    $("#dfctbtncategory").show();
                    $("#dfctloadercategory").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msg").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msg").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectCategory(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug category") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectCategory", {
            "id": id
        }, function(res) {
            if (res.category == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug category") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectCategory() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btncategory").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectCategory',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_category_form_id').serialize() ,
            success: function(response){
                ajaxDefectCategoryLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug category.'));
        return false;
    }
}

function addNewDefectRootCause() {
    openPopup();
    $('#newdfct_btnroot_cause').text('Add');
    $('#new_def_rootcause_title').text('New Bug Root Cause');
    $('#add_another_root_cause').show();
    $("#dfcterr_msgroot_cause").hide();
    $(".new_defectroot_cause").show();
    $(".dfctloader_dvroot_cause").hide();
    $('#inner_defectroot_cause').show();
    $("#defect_root_cause_nm").val('').keyup();
    $("#defect_root_cause_nm").focus();
    $("#defect_root_cause_shnm").val('');
    $("#new-defectroot_causeid").val('');
    
    
}

function editDefectRootCause(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnroot_cause').text(_('Update'));
    $('#new_def_rootcause_title').text('Edit Bug RootCause');
    $('#add_another_root_cause').hide();
    $("#dfcterr_msgroot_cause").hide();
    openPopup();
    $(".new_defectroot_cause").show();
    $(".dfctloader_dvroot_cause").hide();
    $('#inner_defectroot_cause').show();
    $("#defect_root_cause_nm").val(nm).keyup();
    $("#new-defectroot_causeid").val(id);
    $("#defect_root_cause_nm").focus();
}

function validateDefectRootCause() {
    $("#dfcterr_msgroot_cause").hide();
    $("#dfctbtnroot_cause").hide();
    $("#dfctloaderroot_cause").show();
    var msg = "";
    var nm = $.trim($("#defect_root_cause_nm").val());
    var id = $.trim($("#new-defectroot_causeid").val());
    $("#dfcterr_msgroot_cause").html("");
    if (nm === "") {
        msg = _("'Root Cause' can not be left blank!");
        $("#dfcterr_msgroot_cause").show().html(msg);
        $("#defect_root_cause_nm").focus();
        $("#dfctbtnroot_cause").show();
        $("#dfctloaderroot_cause").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Root Cause' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgroot_cause").show().html(msg);
            $("#defect_root_cause_nm").focus();
            $("#dfctbtnroot_cause").show();
            $("#dfctloaderroot_cause").hide();
            return false;
        } else {
            $("#dfctbtnroot_cause").hide();
            $("#dfctloaderroot_cause").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectRootCause", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.root_cause == 'success') {
                    $("#dfcterr_msgroot_cause").hide();
                    $("#dfctbtnroot_cause").show();
                     $("#dfctloaderroot_cause").hide();
                     $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectRootCause',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectRootCauseForm').serialize() ,
                        success: function(response){
                            ajaxDefectRootCauseLoad();
                            if(response.DefectRootCause.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_root_cause').is(":checked")){                        
                                $('#defect_root_cause_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                    // $('#customDefectRootCauseForm').submit();
                } else {
                  
                    $("#dfctbtnroot_cause").show();
                    $("#dfctloaderroot_cause").hide();
                    if (data.msg == "name") {
                        $("#dfcterr_msgroot_cause").show().html(_('Root cause already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgroot_cause").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectRootCause() {
    $("#dfcterr_msgroot_cause").hide();
    $("#dfctbtnroot_cause").hide();
    $("#dfctloaderroot_cause").show();
    var msg = "";
    var nm = $.trim($("#defect_root_cause_nm").val());
    var id = $.trim($("#new-defectroot_causeid").val());
    $("#dfcterr_msgroot_cause").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgroot_cause").show().html(msg);
        $("#defect_root_cause_nm").focus();
        $("#dfctbtnroot_cause").show();
        $("#dfctloaderroot_cause").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgroot_cause").show().html(msg);
            $("#defect_root_cause_nm").focus();
            $("#dfctbtnroot_cause").show();
            $("#dfctloaderroot_cause").hide();
            return false;
        } else {
            $("#dfctbtnroot_cause").hide();
            $("#dfctloaderroot_cause").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectRootCause", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgroot_cause").hide();
                    $("#dfctbtnroot_cause").hide();
                    $("#dfctloaderroot_cause").show();
                    return true;
                } else {
                    $("#dfctbtnroot_cause").show();
                    $("#dfctloaderroot_cause").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgroot_cause").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgroot_cause").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectRootCause(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug root_cause") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectRootCause", {
            "id": id
        }, function(res) {
            if (res.root_cause == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug root cause") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectRootCause() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnroot_cause").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectRootCause',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_root_cause_form_id').serialize(),
            success: function(response){
                ajaxDefectRootCauseLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug root cause.'));
        return false;
    }
}

function addNewDefectIssueType() {
    openPopup();
    $('#new_def_issue_title').html('New Issue Type');
    $("#dfcterr_msgissue_type").hide();
    $('#newdfct_btnissue_type').text('Add');
    $('#create_another_issue_type').show();
    $(".new_defectissue_type").show();
    $(".dfctloader_dvissue_type").hide();
    $('#inner_defectissue_type').show();
    $("#defect_issue_type_nm").val('');
    $("#defect_issue_type_shnm").val('');
    $("#new-defectissue_typeid").val('');
    $("#defect_issue_type_nm").focus();
}

function editDefectIssueType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnissue_type').text(_('Update'));
    $('#new_def_issue_title').html('Edit IssueType');
    $('#create_another_issue_type').hide();
    $("#dfcterr_msgissue_type").hide();
    openPopup();
    $(".new_defectissue_type").show();
    $(".dfctloader_dvissue_type").hide();
    $('#inner_defectissue_type').show();
    $("#defect_issue_type_nm").val(nm).keyup();
    $("#new-defectissue_typeid").val(id);
    $("#defect_issue_type_nm").focus();
}

function validateDefectIssueType() {
    $("#dfcterr_msgissue_type").hide();
    $("#dfctbtnissue_type").hide();
    $("#dfctloaderissue_type").show();
    var msg = "";
    var nm = $.trim($("#defect_issue_type_nm").val());
    var id = $.trim($("#new-defectissue_typeid").val());
    $("#dfcterr_msgissue_type").html("");
    if (nm === "") {
        msg = _("'Issue Type' can not be left blank!");
        $("#dfcterr_msgissue_type").show().html(msg);
        $("#defect_issue_type_nm").focus();
        $("#dfctbtnissue_type").show();
        $("#dfctloaderissue_type").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Issue Type' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgissue_type").show().html(msg);
            $("#defect_issue_type_nm").focus();
            $("#dfctbtnissue_type").show();
            $("#dfctloaderissue_type").hide();
            return false;
        } else {
            $("#dfctbtnissue_type").hide();
            $("#dfctloaderissue_type").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectIssueType", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.issue_type == 'success') {
                    $("#dfcterr_msgissue_type").hide();
                    $("#dfctbtnissue_type").show();
                    $("#dfctloaderissue_type").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectIssueType',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectIssueTypeForm').serialize() ,
                        success: function(response){
                            ajaxDefectIssueTypeLoad();
                            if(response.DefectIssueType.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_issue_type').is(":checked")){                        
                                $('#defect_issue_type_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                } else {
                    $("#dfctbtnissue_type").show();
                    $("#dfctloaderissue_type").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgissue_type").show().html(_('Issue type already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgissue_type").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectIssueType() {
    $("#dfcterr_msgissue_type").hide();
    $("#dfctbtnissue_type").hide();
    $("#dfctloaderissue_type").show();
    var msg = "";
    var nm = $.trim($("#defect_issue_type_nm").val());
    var id = $.trim($("#new-defectissue_typeid").val());
    $("#dfcterr_msgissue_type").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgissue_type").show().html(msg);
        $("#defect_issue_type_nm").focus();
        $("#dfctbtnissue_type").show();
        $("#dfctloaderissue_type").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgissue_type").show().html(msg);
            $("#defect_issue_type_nm").focus();
            $("#dfctbtnissue_type").show();
            $("#dfctloaderissue_type").hide();
            return false;
        } else {
            $("#dfctbtnissue_type").hide();
            $("#dfctloaderissue_type").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectIssueType", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgissue_type").hide();
                    $("#dfctbtnissue_type").hide();
                    $("#dfctloaderissue_type").show();
                    return true;
                } else {
                    $("#dfctbtnissue_type").show();
                    $("#dfctloaderissue_type").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgissue_type").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgissue_type").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectIssueType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug issue_type") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectIssueType", {
            "id": id
        }, function(res) {
            if (res.issue_type == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug issue type") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectIssueType() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnissue_type").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectIssueType',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_issue_type_form_id').serialize() ,
            success: function(response){
                ajaxDefectIssueTypeLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one defect issue_type.'));
        return false;
    }
}

function addNewDefectPhase() {
    openPopup();
    $('#newdfct_btnphase').text('Add');
    $('#new_def_phase_title').text('New Bug Phase');
    $('#add_another_phase').show();
    $("#dfcterr_msgphase").hide();
    $(".new_defectphase").show();
    $(".dfctloader_dvphase").hide();
    $('#inner_defectphase').show();
    $("#defect_phase_nm").val('');
    $("#defect_phase_shnm").val('');
    $("#new-defectphaseid").val('');
    $("#defect_phase_nm").focus();
}

function editDefectPhase(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnphase').text(_('Update'));
    $('#new_def_phase_title').text('Edit Bug Phase');
    $('#add_another_phase').hide();
    $("#dfcterr_msgphase").hide();
    openPopup();
    $(".new_defectphase").show();
    $(".dfctloader_dvphase").hide();
    $('#inner_defectphase').show();
    $("#defect_phase_nm").val(nm).keyup();
    $("#new-defectphaseid").val(id);
    $("#defect_phase_nm").focus();
}

function validateDefectPhase() {
    $("#dfcterr_msgphase").hide();
    $("#dfctbtnphase").hide();
    $("#dfctloaderphase").show();
    var msg = "";
    var nm = $.trim($("#defect_phase_nm").val());
    var id = $.trim($("#new-defectphaseid").val());
    $("#dfcterr_msgphase").html("");
    if (nm === "") {
        msg = _("'Phase' can not be left blank!");
        $("#dfcterr_msgphase").show().html(msg);
        $("#defect_phase_nm").focus();
        $("#dfctbtnphase").show();
        $("#dfctloaderphase").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Phase' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgphase").show().html(msg);
            $("#defect_phase_nm").focus();
            $("#dfctbtnphase").show();
            $("#dfctloaderphase").hide();
            return false;
        } else {
            $("#dfctbtnphase").hide();
            $("#dfctloaderphase").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectPhase", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.phase == 'success') {
                    $("#dfcterr_msgphase").hide();
                    $("#dfctbtnphase").show();
                    $("#dfctloaderphase").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectPhase',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectPhaseForm').serialize() ,
                        success: function(response){
                            ajaxDefectPhaseLoad();
                            if(response.DefectPhase.name !== ""){
                                showTopErrSucc('success', _('Your data saved successfully'));
                            }
                            if($('#add_df_phase').is(":checked")){                        
                                $('#defect_phase_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                  
                } else {
                    $("#dfctbtnphase").show();
                    $("#dfctloaderphase").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgphase").show().html(_('Phase already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgphase").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectPhase() {
    $("#dfcterr_msgphase").hide();
    $("#dfctbtnphase").hide();
    $("#dfctloaderphase").show();
    var msg = "";
    var nm = $.trim($("#defect_phase_nm").val());
    var id = $.trim($("#new-defectphaseid").val());
    $("#dfcterr_msgphase").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgphase").show().html(msg);
        $("#defect_phase_nm").focus();
        $("#dfctbtnphase").show();
        $("#dfctloaderphase").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgphase").show().html(msg);
            $("#defect_phase_nm").focus();
            $("#dfctbtnphase").show();
            $("#dfctloaderphase").hide();
            return false;
        } else {
            $("#dfctbtnphase").hide();
            $("#dfctloaderphase").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectPhase", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.phase == 'success') {
                    $("#dfcterr_msgphase").hide();
                    $("#dfctbtnphase").hide();
                    $("#dfctloaderphase").show();
                    return true;
                } else {
                    $("#dfctbtnphase").show();
                    $("#dfctloaderphase").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgphase").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgphase").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectPhase(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("bug phase") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectPhase", {
            "id": id
        }, function(res) {
            if (res.phase == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug phase") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectPhase() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnphase").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectPhase',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_phase_form_id').serialize(),
            success: function(response){
                ajaxDefectPhaseLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one bug phase.'));
        return false;
    }
}

function addNewDefectAffectVersion() {
    openPopup();
    $('#newdfct_btnaffect_version').text('Add');
    $('#new_def_affect_title').text('New Affect Version');
    $('#add_another_affect_version').show();
    $("#dfcterr_msgaffect_version").hide();
    $(".new_defectaffect_version").show();
    $(".dfctloader_dvaffect_version").hide();
    $('#inner_defectaffect_version').show();
    $("#defect_affect_version_nm").val('');
    $("#defect_affect_version_shnm").val('');
    $("#new-defectaffect_versionid").val('');
    $("#defect_affect_version_nm").focus();
}

function editDefectAffectVersion(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnaffect_version').text(_('Update'));
    $('#new_def_affect_title').text('Edit Bug Affect Version');
    $('#add_another_affect_version').hide();
    $("#dfcterr_msgaffect_version").hide();
    openPopup();
    $(".new_defectaffect_version").show();
    $(".dfctloader_dvaffect_version").hide();
    $('#inner_defectaffect_version').show();
    $("#defect_affect_version_nm").val(nm).keyup();
    $("#new-defectaffect_versionid").val(id);
    $("#defect_affect_version_nm").focus();
}

function validateDefectAffectVersion() {
    $("#dfcterr_msgaffect_version").hide();
    $("#dfctbtnaffect_version").hide();
    $("#dfctloaderaffect_version").show();
    var msg = "";
    var nm = $.trim($("#defect_affect_version_nm").val());
    var id = $.trim($("#new-defectaffect_versionid").val());
    $("#dfcterr_msgaffect_version").html("");
    if (nm === "") {
        msg = _("'Affect Version' can not be left blank!");
        $("#dfcterr_msgaffect_version").show().html(msg);
        $("#defect_affect_version_nm").focus();
        $("#dfctbtnaffect_version").show();
        $("#dfctloaderaffect_version").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Affect Version' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgaffect_version").show().html(msg);
            $("#defect_affect_version_nm").focus();
            $("#dfctbtnaffect_version").show();
            $("#dfctloaderaffect_version").hide();
            return false;
        } else {
            $("#dfctbtnaffect_version").hide();
            $("#dfctloaderaffect_version").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectAffectVersion", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.affect_version == 'success') {
                    $("#dfcterr_msgaffect_version").hide();
                    $("#dfctbtnaffect_version").show();
                    $("#dfctloaderaffect_version").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectAffectVersion',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectAffectVersionForm').serialize() ,
                        success: function(response){
                            DefectAffectVersionLoad();
                            if(response.DefectAffectVersion.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_affect_version').is(":checked")){                        
                                $('#defect_affect_version_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                    // $('#customDefectAffectVersionForm').submit();
                    return true;
                } else {
                    $("#dfctbtnaffect_version").show();
                    $("#dfctloaderaffect_version").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgaffect_version").show().html(_('Affect version already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgaffect_version").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectAffectVersion() {
    $("#dfcterr_msgaffect_version").hide();
    $("#dfctbtnaffect_version").hide();
    $("#dfctloaderaffect_version").show();
    var msg = "";
    var nm = $.trim($("#defect_affect_version_nm").val());
    var id = $.trim($("#new-defectaffect_versionid").val());
    $("#dfcterr_msgaffect_version").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgaffect_version").show().html(msg);
        $("#defect_affect_version_nm").focus();
        $("#dfctbtnaffect_version").show();
        $("#dfctloaderaffect_version").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgaffect_version").show().html(msg);
            $("#defect_affect_version_nm").focus();
            $("#dfctbtnaffect_version").show();
            $("#dfctloaderaffect_version").hide();
            return false;
        } else {
            $("#dfctbtnaffect_version").hide();
            $("#dfctloaderaffect_version").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectAffectVersion", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgaffect_version").hide();
                    $("#dfctbtnaffect_version").hide();
                    $("#dfctloaderaffect_version").show();
                    return true;
                } else {
                    $("#dfctbtnaffect_version").show();
                    $("#dfctloaderaffect_version").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgaffect_version").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgaffect_version").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectAffectVersion(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("affect version") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectAffectVersion", {
            "id": id
        }, function(res) {
            if (res.affect_version == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug affect_version") + " '" + nm + "' " + _("has deleted successfully") + ".");
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectAffectVersion() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnaffect_version").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectAffectVersion',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_affect_version_form_id').serialize(),
            success: function(response){
                DefectAffectVersionLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one affect version.'));
        return false;
    }
}

function addNewDefectFixVersion() {
    openPopup();
    $('#newdfct_btnfix_version').text('Add');
    $('#new_def_fix_version_title').text('New Fix Version');
    $('#add_another_fix_version').show();
    $("#dfcterr_msgfix_version").hide();
    $(".new_defectfix_version").show();
    $(".dfctloader_dvfix_version").hide();
    $('#inner_defectfix_version').show();
    $("#defect_fix_version_nm").val('');
    $("#defect_fix_version_shnm").val('');
    $("#new-defectfix_versionid").val('');
    $("#defect_fix_version_nm").focus();
}

function editDefectFixVersion(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    $('#newdfct_btnfix_version').text(_('Update'));
    $('#new_def_fix_version_title').text('Edit Fix Version');
    $('#add_another_fix_version').hide();
    $("#dfcterr_msgfix_version").hide();
    openPopup();
    $(".new_defectfix_version").show();
    $(".dfctloader_dvfix_version").hide();
    $('#inner_defectfix_version').show();
    $("#defect_fix_version_nm").val(nm).keyup();
    $("#new-defectfix_versionid").val(id);
    $("#defect_fix_version_nm").focus();
}

function validateDefectFixVersion() {
    var msg = "";
    var nm = $.trim($("#defect_fix_version_nm").val());
    var id = $.trim($("#new-defectfix_versionid").val());
    $("#dfcterr_msgfix_version").html("");
    if (nm === "") {
        msg = _("'Fix Version' can not be left blank!");
        $("#dfcterr_msgfix_version").show().html(msg);
        $("#defect_fix_version_nm").focus();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Fix Version' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgfix_version").show().html(msg);
            $("#defect_fix_version_nm").focus();
            return false;
        } else {
            $("#dfctbtnfix_version").hide();
            $("#dfctloaderfix_version").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectFixVersion", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.fix_version == 'success') {
                    $("#dfcterr_msgfix_version").hide();
                    $("#dfctbtnfix_version").show();
                    $("#dfctloaderfix_version").hide();
                    $.ajax({
                        url: HTTP_ROOT + 'defect/defects/addNewDefectFixVersion',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#customDefectFixVersionForm').serialize() ,
                        success: function(response){
                            DefectFixVersionLoad();
                            if(response.DefectFixVersion.name !== ""){
                                showTopErrSucc('success', _('Your data Saved successfully'));
                            }
                            if($('#add_df_fix_version').is(":checked")){                        
                                $('#defect_fix_version_nm').val('');
                            } else {                                            
                                closePopup();                        
                            } 
                        }
                    });
                    // $('#customDefectFixVersionForm').submit();
                } else {
                    $("#dfctbtnfix_version").show();
                    $("#dfctloaderfix_version").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgfix_version").show().html(_('Fix version already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgfix_version").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function validateEnterDefectFixVersion() {
    $("#dfcterr_msgfix_version").hide();
    $("#dfctbtnfix_version").hide();
    $("#dfctloaderfix_version").show();
    var msg = "";
    var nm = $.trim($("#defect_fix_version_nm").val());
    var id = $.trim($("#new-defectfix_versionid").val());
    $("#dfcterr_msgfix_version").html("");
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#dfcterr_msgfix_version").show().html(msg);
        $("#defect_fix_version_nm").focus();
        $("#dfctbtnfix_version").show();
        $("#dfctloaderfix_version").hide();
        return false;
    } else {
        var inValid = /[~`<>,;\+\\\%\!\{\}\�\^\+\"\']+/;
        if (inValid.test(nm.trim())) {
            msg = _("'Name' can not accept characters like(~, `, <, >, \\, +, ;, !, ', }, {, %, ^)");
            $("#dfcterr_msgfix_version").show().html(msg);
            $("#defect_fix_version_nm").focus();
            $("#dfctbtnfix_version").show();
            $("#dfctloaderfix_version").hide();
            return false;
        } else {
            $("#dfctbtnfix_version").hide();
            $("#dfctloaderfix_version").show();
            $.post(HTTP_ROOT + "defect/defects/validateDefectFixVersion", {
                'id': id,
                'name': nm
            }, function(data) {
                if (data.status == 'success') {
                    $("#dfcterr_msgfix_version").hide();
                    $("#dfctbtnfix_version").hide();
                    $("#dfctloaderfix_version").show();
                    return true;
                } else {
                    $("#dfctbtnfix_version").show();
                    $("#dfctloaderfix_version").hide();
                    if (data.msg == 'name') {
                        $("#dfcterr_msgfix_version").show().html(_('Name already exists!. Please enter another name.'));
                    } else {
                        $("#dfcterr_msgfix_version").show().html(_('Oops! Missing input parameters.'));
                    }
                    return false;
                }
            }, 'json');
        }
    }
}

function deleteDefectFixVersion(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("fix version") + " ?")) {
        $("#del_dfct_" + id).hide();
        $("#lding_dfct_" + id).show();
        $.post(HTTP_ROOT + "defect/defects/deleteDefectFixVersion", {
            "id": id
        }, function(res) {
            if (res.fix_version == 'success') {
                $("#dv_dfct_" + id).fadeOut(300, function() {
                    $(this).remove();
                    showTopErrSucc('success', _("Bug fix_version") + " '" + nm + "' " + _("has deleted successfully") + ".");
                    DefectFixVersionLoad();
                });
            } else {
                $("#lding_dfct_" + id).hide();
                $("#del_dfct_" + id).show();
                showTopErrSucc('error', _("Reference Exists In Create Bug. Can't Be Deleted."));
            }
        }, 'json');
    }
}

function saveDefectFixVersion() {
    var isTaskIds = 0;
    $(".all_dfct").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_dfct').attr('disabled', false);
        $("#dfct_save_btnfix_version").hide();
        $("#loader_img_dfct").show();
        $.ajax({
            url: HTTP_ROOT + 'defect/defects/saveDefectFixVersion',
            type: 'POST',
            dataType: 'json',
            data: $('#defect_fix_version_form_id').serialize(),
            success: function(response){
                DefectFixVersionLoad();
            }
        });
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one fix version.'));
        return false;
    }
}

function newDefect(project_id, task_id, type) {
    $(".new_defect").addClass('pop-overlay');
    $("#fullPageLoder").show();
    $(".def_loader_dv").show();
    openPopup('defect');
    // $("#btndefAdd").show();
    resetData();   
    $('.defect_new_form_due_date').val(''); 
    $("#btndefAdd").show();    
    $(".new_defect").show();
    $(".def_loader_dv").hide();
    $('#inner_def').show();
    $('.select2').select2();
    $('#defect_issue_type_id').trigger("change.select2");
    defectFuploadUI("Defect");
    if(typeof type == 'undefined'){
        $("#def_project_id").val(project_id).trigger("change.select2");
    }
    if ((typeof project_id != 'undefined') && typeof type != 'undefined') {
        $("#def_project_id").val(project_id).trigger("change.select2");
        $('#def_project_id').attr('disabled', true);
        setTimeout(function() {
            $("#def_task_id").val(task_id).trigger("change.select2");
            $('#def_task_id').attr('disabled', true);
        },3000);
       // selectTask(task_id);
       // selectUserForProject(project_id);
    } else {
        resetData();
    }
    if(typeof type == 'undefined'){
        $("#def_project_id").val(project_id).trigger("change.select2");
        $('#def_project_id').attr('disabled', false);
        $('#def_task_id').attr('disabled', false);
    }
}

function defectFuploadUI(tcsAtId) {
    var isExceed = 0;
    var reply_total_files = new Array();
    var reply_indx = 0;
    $('#tsk_attachReplyDefect,#tsk_attachDefect').change(function() {
        var isExceed = $("#isExceed").val();
        if (this.value.match(/\.(.+)$/) == null) {
            alert('File "' + this.value + '" has no extension, please upload files with extension ');
            this.value = '';
            return false;
        }
        if (this.value) {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            if ($.inArray(ext, ["ai", "arf", "avi", "axc", "bak", "bgs", "bmp", "bmpr", "bpm", "bpmn", "bz2", "c3t", "cdr", "cs", "csr", "csv", "dcm", "dia", "dib", "doc", "docm", "docx", "dot", "dotm", "dotx", "dwg", "dxf", "edi", "emb", "eml", "eps", "gdoc", "gdraw", "gif", "gpg", "gpx", "gsheet", "gsl", "gslides", "gz", "HEIC", "ico", "ics", "indd", "jfif", "jpe", "jpeg", "jpg", "jrxml", "kml", "lic", "log", "m4a", "m4v", "map", "mdj", "mht", "mkv", "mm", "mo", "mov", "mp3", "mp4", "mpp", "msg", "mwb", "ndm", "NNI", "numbers", "odg", "odp", "ods", "odt", "oft", "ogg", "one", "otf", "oxps", "p12", "paint", "par", "param", "pbix", "pcap", "pcapng", "pdf", "PES", "pfx", "png", "po", "pod", "potx", "pps", "ppsx", "ppt", "pptm", "pptx", "properties", "prx", "ps1", "psb", "psd", "pub", "py", "qvf", "qvw", "R", "rar", "rb", "rdg", "rdlc", "rpd", "rpm", "rtf", "ru", "sav", "scribe", "scss", "sig", "skb", "sketch", "skp", "SLDPRT", "sql", "srt", "svclog", "svg", "swf", "swift", "tdl", "tgz", "tia", "tif", "tiff", "tlb", "tlp", "ttf", "twb", "twbx", "txt", "uml", "unf", "vcf", "vcl", "vdx", "VSD", "vsdx", "wav", "wbs", "webm", "webp", "wmv", "wsdl", "xbrl", "xcf", "xd", "XEN", "xlam", "xls", "xlsb", "xlsm", "xlsx", "xltx", "xmind", "xpo", "xps", "xsd", "xsl", "yaml", "yml", "Z13", "zef", "zip"]) < 0) {
                alert("Sorry, '" + ext + "' file type is not allowed!");
                this.value = '';
            }
        } else if (isExceed == 1) {}
    });
    var i = 0;
    $('.upload' + tcsAtId + ':not(.applied' + tcsAtId + ')').addClass('applied' + tcsAtId + '').fileUploadUI({
        uploadTable: $('#up_files' + tcsAtId + ''),
        downloadTable: $('#up_files' + tcsAtId + ''),
        buildUploadRow: function(files, index) {
            var filename = files[index].name;
            if (filename.length > 35) {
                filename = filename.substr(0, 35);
            }
            var gFileupload = 0;
            reply_total_files.push(filename);
            return $('<tr><td valign="top">' + filename + '</td>' + '<td valign="top" width="100px" style="padding-left:10px;" title="Uploading..." rel="tooltip"><div class="progress-bar"><div class="progress-bar blue"><\/div><\/div></td>' + '<td valign="top" style="padding-left:10px;"><div class="file_upload_cancel">' + '<font id="cancel" title="Cancel" title="Cancel" rel="tooltip">' + '<span class="ui-icon-fupload ui-icon-cancel" onclick="cancelReplyFile(\'' + filename + '\');">Cancel<\/span>' + '<\/font><\/div><\/td><\/tr>');
        },
        buildDownloadRow: function(file) {
            var fmaxilesize = document.getElementById('fmaxilesize').value;
            reply_indx++;
            if (file.name != "error") {
                if (file.message == "success") {
                    var allowedSize = parseInt(fmaxilesize) * 1024;
                    if (parseInt(file.sizeinkb) <= parseInt(allowedSize)) {
                        i++;
                        document.getElementById('totfiles' + tcsAtId).value = i;
                        var oncheck = "";
                        var fname = file.filename.split("|");
                        var filesize = file.sizeinkb;
                        if (filesize >= 1024) {
                            filesize = filesize / 1024;
                            filesize = Math.round(filesize * 10) / 10;
                            filesize = filesize + " Mb";
                        } else {
                            filesize = Math.round(filesize * 10) / 10;
                            filesize = filesize + " Kb";
                        }
                        if (parseInt(reply_total_files.length) == reply_indx) {
                            gFileupload = 1;
                        }
                        return $('<tr><td style="color:#0683B8;" valign="top"><div id="' + tcsAtId + 'jquerydiv' + i + '"><input type="checkbox" checked onClick="return removeDefectFile(\'' + tcsAtId + 'jqueryfile' + i + '\',\'' + tcsAtId + 'jquerydiv' + i + '\');" style="cursor:pointer;"/>&nbsp;&nbsp;<a href="' + HTTP_ROOT + 'defect/defects/download?filename=' + fname[0] + '" style="text-decoration:underline;position:relative;top:-2px;">' + file.name + ' (' + filesize + ')</a><input type="hidden" name="data[Easycase][name][]" id="' + tcsAtId + 'jqueryfile' + i + '" value="' + file.filename + '"/><\/div><\/td><\/tr>');
                    } else {
                        alert("Error uploading file. File size cannot be more then " + fmaxilesize + " Mb!");
                        if (parseInt(reply_total_files.length) == reply_indx) {
                            gFileupload = 1;
                        }
                    }
                } else if (file.message == "exceed") {
                    alert("Error uploading file.\nStorage usage exceeds by " + file.storageExceeds + " Mb!");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "size") {
                    alert("Error uploading file. File size cannot be more then " + fmaxilesize + " Mb!");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "error") {
                    alert("Error uploading file. Please try with another file");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "s3_error") {
                    alert("Due to some network problem your file is not uploaded.Please try again after sometime.");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else {
                    alert("Sorry, " + file.message + " file type is not allowed!");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                }
            } else {
                alert("Error uploading file. Please try with another file");
                if (parseInt(reply_total_files.length) == reply_indx) {
                    gFileupload = 1;
                }
            }
        }
    });
}

function removeDefectFile(id, div, storage) {
    var x = document.getElementById(id).value;
    document.getElementById(id).value = '';
    var strURL = HTTP_ROOT + "defect/defects/";
    if (storage) {
        var usedstorage = $("#usedstorage").val();
        var newstorage = usedstorage - storage;
        $("#usedstorage").val(newstorage);
    }
    $.post(strURL + "defect_fileremove", {
        "filename": x
    }, function(data) {
        if (data) {}
    });
    $('#' + div).parent().parent().remove();
}

function TestCaseimageTypeIcon(format) {
    var iconsArr = ["gd", "db", "zip", "xls", "doc", "jpg", "png", "bmp", "pdf", "tif"];
    if (format == "xlsx") {
        format = "xls"
    } else if (format == "docx" || format == "rtf" || format == "odt") {
        format = "doc"
    } else if (format == "jpeg") {
        format = "jpg"
    } else if (format == "gif") {
        format = "png"
    } else if (format == "rar" || format == "gz" || format == "bz2") {
        format = "zip"
    }
    if ($.inArray(format, iconsArr) == -1) {
        format = 'html'
    }
    return format;
}

function defect_check_priority(obj) {
    $(obj).find('input:radio').attr('checked', 'checked');
    var pvalue = $(obj).find('input:radio').val();
    $("#defect_priority_id").val(pvalue);
}

function defect_check_type(obj) {
    $(obj).find('input:radio').attr('checked', 'checked');
    var pvalue = $(obj).find('input:radio').val();
    $("#defect_type_id").val(pvalue);
}
function clearDefectFilter(){if($.trim($('#defect_inner-search').val())!=''){$('#defect_inner-search').val('');$('#srch_inner_load1-defect').show();ajaxDefectView();}$('.filterDefecticon').hide();}
function ajaxDefectView() {
    $('#defectLoader').show();
		var srch = (!localStorage.getItem('DEFECT_SEARCH')) ? '' : localStorage.getItem('DEFECT_SEARCH');
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_status_id = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to_id = localStorage.getItem('DEFECTUSER');
    var defect_reported_by_id = localStorage.getItem('DEFECTREPORTED');
    var defect_owner_id = localStorage.getItem('DEFECTOWNER');
    var defect_due_date_id = localStorage.getItem('DEFECTDUEDATE');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_list", {
        'due_date': defect_due_date_id,
        'owner_id': defect_owner_id,
        'reporter_id': defect_reported_by_id,
        'assign_to': defect_assign_to_id,
        'defect_status_id': defect_status_id,
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id,
				'srch': srch,
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectViewSpan").html(tmpl("defect_list_tmpl", res));
            $('#defectLoader').hide();
            checkDefectSelect();
            checkDefectGroup();
						//Search
						if(localStorage.getItem('DEFECT_SEARCH')){
							$("#defect_inner-search").val(localStorage.getItem('DEFECT_SEARCH'));
						}
						
						$("#defect_inner-search").on('blur', function(e) {
								search_val = $('#defect_inner-search').val().trim();
								if (search_val == '') {
										if (localStorage.getItem('DEFECT_SEARCH') && localStorage.getItem('DEFECT_SEARCH') != '') {
												localStorage.setItem('DEFECT_SEARCH', '');
												ajaxDefectView();
										}
								}
						});
						$("#defect_inner-search").on('keyup', function(e) {
								var unicode = e.charCode ? e.charCode : e.keyCode;
								var srch = $("#defect_inner-search").val();
								srch = $.trim(srch);
								if (unicode != 13 && unicode != 40 && unicode != 38) {
										if (globalTimeoutDefect != null)
												clearTimeout(globalTimeoutDefect);
												globalTimeoutDefect = setTimeout(function() {
												if(srch != ''){
													localStorage.setItem('DEFECT_SEARCH', srch);
													ajaxDefectView();
												}
										}, 1000);
								}
								if (unicode == 13) {
										if (globalTimeoutDefect != null)
												clearTimeout(globalTimeoutDefect);
										if ($.trim($("#defect_inner-search").val()) != '' || localStorage.getItem('DEFECT_SEARCH') != ''){				
												localStorage.setItem('DEFECT_SEARCH', srch);
												ajaxDefectView();
										}
								}
						});
        }
    });
}

function defect_export_csv() {
    $('#defectLoader').show();
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    $.post(HTTP_ROOT + "defect/defects/export_csv", {
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id
    }, function(res) {
        if (res.status == 'failed') {
            $('#defectLoader').hide();
            showTopErrSucc('error', res.message);
            return false;
        } else {
            window.location.href = HTTP_ROOT + 'defect/defects/download_csv?filename=' + res.filename
            $('#defectLoader').hide();
        }
    }, 'json');
}

function defectPaging(page) {
    $('#defectLoader').show();
    defect_remember_filters('DEFECTLISTINGPAGE',page);
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_status_id = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to_id = localStorage.getItem('DEFECTUSER');
    var defect_reported_by_id = localStorage.getItem('DEFECTREPORTED');
    var defect_owner_id = localStorage.getItem('DEFECTOWNER');
    var defect_due_date_id = localStorage.getItem('DEFECTDUEDATE');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    var srch = (!localStorage.getItem('DEFECT_SEARCH')) ? '' : localStorage.getItem('DEFECT_SEARCH');
    var order = (localStorage.getItem('DEFECTSORTINGORDER')) ? localStorage.getItem('DEFECTSORTINGORDER') : "";
    var type = (localStorage.getItem('DEFECTSORTINGSORTBY')) ? localStorage.getItem('DEFECTSORTINGSORTBY') : "";
		$.post(HTTP_ROOT + "defect/defects/ajax_defect_list", {
        'due_date': defect_due_date_id,
        'owner_id': defect_owner_id,
        'reporter_id': defect_reported_by_id,
        'assign_to': defect_assign_to_id,
        'defect_status_id': defect_status_id,
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id,
        'order': order,
        'sortby': type,
        'page': page,
		'srch': srch
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectViewSpan").html(tmpl("defect_list_tmpl", res));
            $('#defectLoader').hide();
            checkDefectSelect();
            checkDefectGroup();
        }
    });
}

function ajaxSortings(type, cases, el) {
    if (type == 'defect_no') {
        var sort_val = $("#defect_no").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'defect_task') {
        var sort_val = $("#defect_task").attr('class');

        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'test_case_no') {
        var sort_val = $("#test_case_no").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'release') {
        var sort_val = $("#release_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'title') {
        var sort_val = $("#def_title_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_severity_id') {
        var sort_val = $("#def_severity_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_assign_to_id') {
        var sort_val = $("#def_assign_to_id").attr('class');

        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_reporter_by_id') {
        var sort_val = $("#def_reporter_by_id").attr('class');

        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_phase_id') {
        var sort_val = $("#def_phase_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_category_id') {
        var sort_val = $("#def_category_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_type_id') {
        var sort_val = $("#def_type_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_origin_id') {
        var sort_val = $("#def_origin_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_resolution_id') {
        var sort_val = $("#def_resolution_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_owner_id') {
        var sort_val = $("#def_owner_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_due_date_id') {
        var sort_val = $("#def_due_date_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_created_date_id') {
        var sort_val = $("#def_created_date_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_modified_date_id') {
        var sort_val = $("#def_modified_date_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_environment_id') {
        var sort_val = $("#def_environment_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_impacted_id') {
        var sort_val = $("#def_impacted_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_activity_type_id') {
        var sort_val = $("#def_activity_type_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_status_id') {
        var sort_val = $("#def_status_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    }  else if (type == 'def_original_dev_id') {
        var sort_val = $("#def_original_dev_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    }else if (type == 'def_affects_version_id') {
        var sort_val = $("#def_affects_version_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_fix_version_id') {
        var sort_val = $("#def_fix_version_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_root_cause_id') {
        var sort_val = $("#def_root_cause_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    } else if (type == 'def_issue_type_id') {
        var sort_val = $("#def_issue_type_id").attr('class');
        if (sort_val.indexOf("tsk_asc") > 1) {
            var order = 'desc';
            var tcls = 'tsk_desc';
        } else if (sort_val.indexOf("tsk_desc") > 1) {
            var order = 'asc';
            var tcls = 'tsk_asc';
        } else {
            var order = 'desc';
            var tcls = 'tsk_desc';
        }
    }
    defect_remember_filters('DEFECTSORTINGORDER',order);
    defect_remember_filters('DEFECTSORTINGSORTBY',type);
    $('#defectLoader').show();
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_status_id = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to_id = localStorage.getItem('DEFECTUSER');
    var defect_reported_by_id = localStorage.getItem('DEFECTREPORTED');
    var defect_owner_id = localStorage.getItem('DEFECTOWNER');
    var defect_due_date_id = localStorage.getItem('DEFECTDUEDATE');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
	var srch = (!localStorage.getItem('DEFECT_SEARCH')) ? '' : localStorage.getItem('DEFECT_SEARCH');
    var page = (localStorage.getItem('DEFECTLISTINGPAGE')) ? localStorage.getItem('DEFECTLISTINGPAGE') : "";
		$.post(HTTP_ROOT + "defect/defects/ajax_defect_list", {
        'due_date': defect_due_date_id,
        'owner_id': defect_owner_id,
        'reporter_id': defect_reported_by_id,
        'assign_to': defect_assign_to_id,
        'defect_status_id': defect_status_id,
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id,
        'order': order,
        'sortby': type,
        'page':page,
        'srch': srch
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectViewSpan").html(tmpl("defect_list_tmpl", res));
            $('#defectLoader').hide();
            if (type == 'defect_no') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#defect_no").addClass(tcls);
            } else if (type == 'defect_task') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#defect_task").addClass(tcls);
            }else if (type == 'def_original_dev_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_original_dev_id").addClass(tcls);
            } else if (type == 'test_case_no') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#test_case_no").addClass(tcls);
            } else if (type == 'title') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_title_id").addClass(tcls);
            } else if (type == 'def_severity_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_severity_id").addClass(tcls);
            } else if (type == 'def_assign_to_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_assign_to_id").addClass(tcls);
            } else if (type == 'def_reporter_by_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_reporter_by_id").addClass(tcls);
            } else if (type == 'def_phase_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_phase_id").addClass(tcls);
            } else if (type == 'def_category_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_category_id").addClass(tcls);
            } else if (type == 'def_type_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_type_id").addClass(tcls);
            } else if (type == 'def_origin_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_origin_id").addClass(tcls);
            } else if (type == 'def_resolution_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_resolution_id").addClass(tcls);
            } else if (type == 'def_owner_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_owner_id").addClass(tcls);
            } else if (type == 'def_due_date_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_due_date_id").addClass(tcls);
            } else if (type == 'def_created_date_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_created_date_id").addClass(tcls);
            } else if (type == 'def_modified_date_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_modified_date_id").addClass(tcls);
            } else if (type == 'def_environment_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_environment_id").addClass(tcls);
            } else if (type == 'def_impacted_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_impacted_id").addClass(tcls);
            } else if (type == 'def_activity_type_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_activity_type_id").addClass(tcls);
            } else if (type == 'def_status_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_status_id").addClass(tcls);
            } else if (type == 'def_affects_version_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_affects_version_id").addClass(tcls);
            } else if (type == 'def_fix_version_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_fix_version_id").addClass(tcls);
            } else if (type == 'def_root_cause_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_root_cause_id").addClass(tcls);
            } else if (type == 'def_issue_type_id') {
                $('.tsk_sort').removeClass('tsk_asc tsk_desc');
                $("#def_issue_type_id").addClass(tcls);
            }
        }
    });
}

function dFilterRequest(type) {
    return false;
    if (_filterInterval) {
        clearInterval(_filterInterval);
    }
    _filterInterval = setTimeout(function() {
        $('#customFIlterId').val('');
        window.location.hash = 'tasks';
        easycase.refreshTaskList();
    }, 1000);
}

function defect_openfilter_popup(flag, dropdownid) {
   $(".dropdown_defcet-menu").show();
   var pname_dashboard = $("#prj_drpdwn").find('a#prj_ahref').find("div.prjnm_ttc").find('span#pname_dashboard').html();
   if (pname_dashboard == 'All') {
        $("#proSortId").show();
        $("#allPro").show();
        $("#proGroupId").show();
    } else {
        $("#proSortId").hide();
        $("#allPro").hide();
        $("#proGroupId").hide();
    }
    if ($('#pname_dashboard').text() == 'All') {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').hide();
    } else {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').show();
    }
    if ($('#' + dropdownid).is(":visible") && !flag) {
        
        $('#' + dropdownid).hide();
        $('.dropdown_status').hide();
    } else {
       // alert("hii");
        //$('.case-filter-menu ul.dropdown-menu').hide();
        //$('.dropdown_status').hide();
        $('#' + dropdownid).show();
    }
   return false;
   
    
        
}
function openGrpByFilter(flag,dropdownid){
    $(".dropdown_defcet_groupby-menu").show();
    var pname_dashboard = $("#prj_drpdwn").find('a#prj_ahref').find("div.prjnm_ttc").find('span#pname_dashboard').html();
    if (pname_dashboard == 'All') {
        $("#proSortId").show();
        $("#allPro").show();
        $("#proGroupId").show();
    } else {
        $("#proSortId").hide();
        $("#allPro").hide();
        $("#proGroupId").hide();
    }
    if ($('#pname_dashboard').text() == 'All') {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').hide();
    } else {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').show();
    }

}
function showHideField(flag,dropdownid){
    $(" dropdown_defcet_hidefield-menu").show();
   
    var pname_dashboard = $("#prj_drpdwn").find('a#prj_ahref').find("div.prjnm_ttc").find('span#pname_dashboard').html();
    if (pname_dashboard == 'All') {
        $("#proSortId").show();
        $("#allPro").show();
        $("#proGroupId").show();
    } else {
        $("#proSortId").hide();
        $("#allPro").hide();
        $("#proGroupId").hide();
    }
    if ($('#pname_dashboard').text() == 'All') {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').hide();
    } else {
        $('#dropdown_menu_defect_all_filters').find('li:nth-child(4)').show();
    }
}
function defect_allfiltervalue(type) {
    if (arguments[1]) {
        var event = arguments[1];
        event.preventDefault();
        event.stopPropagation();
    }
     $('.dropdown_status').hide();
    $('#dropdown_menu_' + type + '_div').show();
    var hashtag = parseUrlHash(urlHash);
    if (hashtag == 'kanban') {
        $('#dropdown_menu_' + type).css({
            "display": "inline-block",
            'float': 'right'
        });
    } else {
        $('#dropdown_menu_' + type).css({
            "display": "inline-block",
            'float': 'right'
        });
    }
    var li_ldr = "<li><center><img src='" + HTTP_ROOT + "img/images/del.gif' alt='loading...' title='loading...'/><center></li>";
    $('#dropdown_menu_' + type).html(li_ldr);
    var projFil = $('#projFil').val();
    if (type == 'defect_issue_type') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_issue_type", {}, function(data) {
            if (data) {
                $('#dropdown_menu-defect_issue_type').html(data);
                var defect_issue_type = localStorage.getItem('DEFECTISSUETYPE');
                 // alert(defect_issue_type);
                var str = '';
                if (defect_issue_type != '' && defect_issue_type != null) {
                    var diyArr = JSON.parse(defect_issue_type);
                    for (var i = 0; i < diyArr.length; i++) {
                        var diyId = diyArr[i];
                        document.getElementById('dIssueType_' + diyId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_severity') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_severity", {}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_severity').html(data);
                var defect_severity = localStorage.getItem('DEFECTSEVERITY');
                if (defect_severity != '' && defect_severity != null) {
                    var dsArr = JSON.parse(defect_severity);
                    for (var i = 0; i < dsArr.length; i++) {
                        var dsId = dsArr[i];
                        document.getElementById('dSeverity_' + dsId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_phase') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_phase", {}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_phase').html(data);
                var defect_phase = localStorage.getItem('DEFECTPHASE');
                if (defect_phase != '' && defect_phase != null) {
                    var dpArr = JSON.parse(defect_phase);
                    for (var i = 0; i < dpArr.length; i++) {
                        var dpId = dpArr[i];
                        document.getElementById('dPhase_' + dpId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_category') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_category", {}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_category').html(data);
                var defect_category = localStorage.getItem('DEFECTCATEGORY');
                if (defect_category != '' && defect_category != null) {
                    var dcArr = JSON.parse(defect_category);
                    for (var i = 0; i < dcArr.length; i++) {
                        var dcId = dcArr[i];
                        document.getElementById('dCategory_' + dcId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_activity_type') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_activity_type", {}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_activity_type').html(data);
                var defect_activity_type = localStorage.getItem('DEFECTACTIVITYTYPE');
                if (defect_activity_type != '' && defect_activity_type != null) {
                    var datArr = JSON.parse(defect_activity_type);
                    for (var i = 0; i < datArr.length; i++) {
                        var datId = datArr[i];
                        document.getElementById('dActivityType_' + datId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_task_case_no') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_task_case_no", {
            'project_id': projFil
        }, function(data) {
            if (data) {
                $('#dropdown_menu_defect_task_case_no').html(data);
                var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
                if (defect_task_case_no != '' && defect_task_case_no != null) {
                    var dtcnArr = JSON.parse(defect_task_case_no);
                    for (var i = 0; i < dtcnArr.length; i++) {
                        var dtcnId = dtcnArr[i];
                        document.getElementById('dTaskCaseNo_' + dtcnId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_status') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_status", { 'project_id': projFil}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_status').html(data);
                var defect_status = localStorage.getItem('DEFECTSTATUS');
                if (defect_status != '' && defect_status != null) {
                    var dsArr = JSON.parse(defect_status);
                    for (var i = 0; i < dsArr.length; i++) {
                        var dsId = dsArr[i];
                        document.getElementById('dStatus_' + dsId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_assign_to') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_assign_to", {
            'projFil': projFil
        }, function(data) {
            if (data) {
                $('#dropdown_menu_defect_assign_to').html(data);
                var defect_assign_to = localStorage.getItem('DEFECTUSER');
                if (defect_assign_to != '' && defect_assign_to != null) {
                    var dusArr = JSON.parse(defect_assign_to);
                    for (var i = 0; i < dusArr.length; i++) {
                        var dusId = dusArr[i];
                        document.getElementById('dUser_' + dusId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_reported_by') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_reported_by", {
            'projFil': projFil
        }, function(data) {
            if (data) {
                $('#dropdown_menu_defect_reported_by').html(data);
                var defect_reported_by = localStorage.getItem('DEFECTREPORTED');
                if (defect_reported_by != '' && defect_reported_by != null) {
                    var drbArr = JSON.parse(defect_reported_by);
                    for (var i = 0; i < drbArr.length; i++) {
                        var drbId = drbArr[i];
                        document.getElementById('dReported_' + drbId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_owner') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_owner", {
            'projFil': projFil
        }, function(data) {
            if (data) {
                $('#dropdown_menu_defect_owner').html(data);
                var defect_owner = localStorage.getItem('DEFECTOWNER');
                if (defect_owner != '' && defect_owner != null) {
                    var doArr = JSON.parse(defect_owner);
                    for (var i = 0; i < doArr.length; i++) {
                        var doId = doArr[i];
                        document.getElementById('dOwner_' + doId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'defect_due_date') {
        $.post(HTTP_ROOT + "defect/defects/ajax_defect_due_date", {}, function(data) {
            if (data) {
                $('#dropdown_menu_defect_due_date').html(data);
                var defect_due_date = localStorage.getItem('DEFECTDUEDATEVAL');
                if (defect_due_date != '' && defect_due_date != null) {
                    var dduArr = JSON.parse(defect_due_date);
                    for (var i = 0; i < dduArr.length; i++) {
                        var dduId = dduArr[i];
                        if (dduId == 'any' || dduId == '24' || dduId == 'overdue' || dduId == 'Today') {
                            if(dduId == 'Today'){
                                document.getElementById('defect_duedate_24').checked = true;
                            }
                            document.getElementById('defect_duedate_' + dduId).checked = true;
                        } else if (dduId != '' && dduId != null) {
                            var str_date = decodeURIComponent(dduId);
                            var split_val = str_date.split(":");
                            document.getElementById('defect_duedate_custom').checked = true;
                            $("#defect_custom_duedate").show();
                             $("#defect_duefrm").val(split_val['0']);
                            $("#defect_dueto").val(split_val['1']);
                        }
                    }
                }
            }
        });
    }
}

function dmoreLeftNav(more, hide, tot, id) {
    for (var i = 1; i <= tot; i++) {
        var spanid = id + i;
        document.getElementById(spanid).style.display = 'block';
    }
    document.getElementById(more).style.display = 'none';
    document.getElementById(hide).style.display = 'block';
}

function dhideLeftNav(more, hide, tot, id) {
    for (var i = 1; i <= tot; i++) {
        var spanid = id + i;
        document.getElementById(spanid).style.display = 'none';
    }
    document.getElementById(hide).style.display = 'none';
    document.getElementById(more).style.display = 'block';
}

function checkboxDefectIssueType(id, typ, diyVal, diyLab) {
    var x = "";
    var totid = $("#totDiyId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_issue_type_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dIssueType_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dIssueType_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTISSUETYPE', diyVal, diyLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_issue_type', diyVal, '', diyLab);
    }
}

function checkboxDefectSeverity(id, typ, dsVal, dsLab) {
    var x = "";
    var totid = $("#totDsId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_severity_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dSeverity_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dSeverity_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTSEVERITY', dsVal, dsLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_severity', dsVal, '', dsLab);
    }
}

function checkboxDefectPhase(id, typ, dpVal, dpLab) {
    var x = "";
    var totid = $("#totDpId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_phase_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dPhase_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dPhase_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTPHASE', dpVal, dpLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_phase', dpVal, '', dpLab);
    }
}

function checkboxDefectCategory(id, typ, dcVal, dcLab) {
    var x = "";
    var totid = $("#totDcId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_category_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dCategory_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dCategory_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTCATEGORY', dcVal, dcLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_category', dcVal, '', dcLab);
    }
}

function checkboxDefectActivityType(id, typ, datVal, datLab) {
    var x = "";
    var totid = $("#totDatId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_activity_type_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dActivityType_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dActivityType_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTACTIVITYTYPE', datVal, datLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_activity_type', datVal, '', datLab);
    }
}

function checkboxDefectTaskCaseNo(id, typ, dtcnVal, dtcnLab) {
    var x = "";
    var totid = $("#totDefTaskId").val();
    var actArr = JSON.parse(totid);
    if (id == 'defect_task_case_no_all') {} else {
        document.getElementById('defect_task_case_no_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dTaskCaseNo_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dTaskCaseNo_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Tce = "all";
    } else {
        var Tce = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTTASKCASENO', dtcnVal, dtcnVal);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_task_case_no', dtcnVal, '', dtcnVal);
    }
}

function defect_remember_filters(name, value, label) {
    if (name == 'reset') {
        if (value == 'all') {}
        localStorage.removeItem('DEFECTISSUETYPE');
        localStorage.removeItem('DEFECTISSUETYPEVAL');
        localStorage.removeItem('DEFECTSEVERITY');
        localStorage.removeItem('DEFECTSEVERITYVAL');
        localStorage.removeItem('DEFECTPHASE');
        localStorage.removeItem('DEFECTPHASEVAL');
        localStorage.removeItem('DEFECTCATEGORY');
        localStorage.removeItem('DEFECTSTATUS');
        localStorage.removeItem('DEFECTUSER');
        localStorage.removeItem('DEFECTDUEDATE');
        localStorage.removeItem('DEFECTREPORTED');
        localStorage.removeItem('DEFECTOWNER');
        localStorage.removeItem('DEFECTCATEGORYVAL');
        localStorage.removeItem('DEFECTACTIVITYTYPE');
        localStorage.removeItem('DEFECTACTIVITYTYPEVAL');
        localStorage.removeItem('DEFECTTASKCASENO');
        localStorage.removeItem('DEFECTTASKCASENOVAL');
        localStorage.removeItem('DEFECTTASKCASENOVAL');
        localStorage.removeItem('DEFECTGROUPBY');
        localStorage.removeItem('DEFECSEARCHTITLE');
        if (value == 'all') {}
    } else if (value) {
        if (name == 'DEFECTISSUETYPE') {
            var diyArr = new Array();
            var diyaArrLab = new Array();
            var defect_issue_type = localStorage.getItem('DEFECTISSUETYPE');
            var defect_issue_type_label = localStorage.getItem('DEFECTISSUETYPEVAL');
            if (defect_issue_type != '' && defect_issue_type != null) {
                diyArr = JSON.parse(defect_issue_type);
                diyaArrLab = JSON.parse(defect_issue_type_label);
                diyArr.push(value);
                diyaArrLab.push(label);
            } else {
                diyArr.push(value);
                diyaArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(diyArr));
            localStorage.setItem('DEFECTISSUETYPEVAL', JSON.stringify(diyaArrLab));
        } else if (name == 'DEFECTSEVERITY') {
            var dsArr = new Array();
            var dsArrLab = new Array();
            var defect_severity = localStorage.getItem('DEFECTSEVERITY');
            var defect_severity_label = localStorage.getItem('DEFECTSEVERITYVAL');
            if (defect_severity != '' && defect_severity != null) {
                dsArr = JSON.parse(defect_severity);
                dsArrLab = JSON.parse(defect_severity_label);
                dsArr.push(value);
                dsArrLab.push(label);
            } else {
                dsArr.push(value);
                dsArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dsArr));
            localStorage.setItem('DEFECTSEVERITYVAL', JSON.stringify(dsArrLab));
        } else if (name == 'DEFECTPHASE') {
            var dpArr = new Array();
            var dpArrLab = new Array();
            var defect_phase = localStorage.getItem('DEFECTPHASE');
            var defect_phase_label = localStorage.getItem('DEFECTPHASEVAL');
            if (defect_phase != '' && defect_phase != null) {
                dpArr = JSON.parse(defect_phase);
                dpArrLab = JSON.parse(defect_phase_label);
                dpArr.push(value);
                dpArrLab.push(label);
            } else {
                dpArr.push(value);
                dpArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dpArr));
            localStorage.setItem('DEFECTPHASEVAL', JSON.stringify(dpArrLab));
        } else if (name == 'DEFECTCATEGORY') {
            var dcArr = new Array();
            var dcArrLab = new Array();
            var defect_category = localStorage.getItem('DEFECTCATEGORY');
            var defect_category_label = localStorage.getItem('DEFECTCATEGORYVAL');
            if (defect_category != '' && defect_category != null) {
                dcArr = JSON.parse(defect_category);
                dcArrLab = JSON.parse(defect_category_label);
                dcArr.push(value);
                dcArrLab.push(label);
            } else {
                dcArr.push(value);
                dcArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dcArr));
            localStorage.setItem('DEFECTCATEGORYVAL', JSON.stringify(dcArrLab));
        } else if (name == 'DEFECTSTATUS') {
            var dsArr = new Array();
            var dsArrLab = new Array();
            var defect_status = localStorage.getItem('DEFECTSTATUS');
            var defect_status_label = localStorage.getItem('DEFECTSTATUSVAL');
            if (defect_status != '' && defect_status != null) {
                dsArr = JSON.parse(defect_status);
                dsArrLab = JSON.parse(defect_status_label);
                dsArr.push(value);
                dsArrLab.push(label);
            } else {
                dsArr.push(value);
                dsArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dsArr));
            localStorage.setItem('DEFECTSTATUSVAL', JSON.stringify(dsArrLab));
        } else if (name == 'DEFECTUSER') {
            var dusArr = new Array();
            var dusArrLab = new Array();
            var defect_assign_to = localStorage.getItem('DEFECTUSER');
            var defect_assign_to_label = localStorage.getItem('DEFECTUSERVAL');
            if (defect_assign_to != '' && defect_assign_to != null) {
                dusArr = JSON.parse(defect_assign_to);
                dusArrLab = JSON.parse(defect_assign_to_label);
                dusArr.push(value);
                dusArrLab.push(label);
            } else {
                dusArr.push(value);
                dusArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dusArr));
            localStorage.setItem('DEFECTUSERVAL', JSON.stringify(dusArrLab));
        } else if (name == 'DEFECTREPORTED') {
            var drbArr = new Array();
            var drbArrLab = new Array();
            var defect_reported_by = localStorage.getItem('DEFECTREPORTED');
            var defect_reported_by_label = localStorage.getItem('DEFECTREPORTEDVAL');
            if (defect_reported_by != '' && defect_reported_by != null) {
                drbArr = JSON.parse(defect_reported_by);
                drbArrLab = JSON.parse(defect_reported_by_label);
                drbArr.push(value);
                drbArrLab.push(label);
            } else {
                drbArr.push(value);
                drbArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(drbArr));
            localStorage.setItem('DEFECTREPORTEDVAL', JSON.stringify(drbArrLab));
        } else if (name == 'DEFECTOWNER') {
            var doArr = new Array();
            var doArrLab = new Array();
            var defect_owner = localStorage.getItem('DEFECTOWNER');
            var defect_owner_label = localStorage.getItem('DEFECTOWNERVAL');
            if (defect_owner != '' && defect_owner != null) {
                doArr = JSON.parse(defect_owner);
                doArrLab = JSON.parse(defect_owner_label);
                doArr.push(value);
                doArrLab.push(label);
            } else {
                doArr.push(value);
                doArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(doArr));
            localStorage.setItem('DEFECTOWNERVAL', JSON.stringify(doArrLab));
        } else if (name == 'DEFECTACTIVITYTYPE') {
            var datArr = new Array();
            var datArrLab = new Array();
            var defect_activity_type = localStorage.getItem('DEFECTACTIVITYTYPE');
            var defect_activity_type_label = localStorage.getItem('DEFECTACTIVITYTYPEVAL');
            if (defect_activity_type != '' && defect_activity_type != null) {
                datArr = JSON.parse(defect_activity_type);
                datArrLab = JSON.parse(defect_activity_type_label);
                datArr.push(value);
                datArrLab.push(label);
            } else {
                datArr.push(value);
                datArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(datArr));
            localStorage.setItem('DEFECTACTIVITYTYPEVAL', JSON.stringify(datArrLab));
        } else if (name == 'DEFECTTASKCASENO') {
            var dtcnArr = new Array();
            var dtcnArrLab = new Array();
            var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
            var defect_task_case_no_label = localStorage.getItem('DEFECTTASKCASENOVAL');
            if (defect_task_case_no != '' && defect_task_case_no != null) {
                dtcnArr = JSON.parse(defect_task_case_no);
                dtcnArrLab = JSON.parse(defect_task_case_no);
                dtcnArr.push(value);
                dtcnArrLab.push(label);
            } else {
                dtcnArr.push(value);
                dtcnArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dtcnArr));
            localStorage.setItem('DEFECTTASKCASENOVAL', JSON.stringify(dtcnArrLab));
        } else if (name == 'DEFECTSEARCHTITLE') {
            localStorage.setItem(name, value);
            localStorage.setItem('DEFECTSEARCHTITLEVAL', label);
        } else if (name == 'DEFECTDUEDATE') {
            var dduArr = new Array();
            var dduArrLab = new Array();
            dduArr.push(value);
            dduArrLab.push(label);
            localStorage.setItem(name, JSON.stringify(dduArr));
            localStorage.setItem('DEFECTDUEDATEVAL', JSON.stringify(dduArrLab));
        } else {
            localStorage.setItem(name, value);
        }
    } else {
        localStorage.removeItem(name);
    }
}

function def_common_reset_filter(ftype, id, obj, label) {
    //$(".dropdown_defcet-menu").hide();
    if (ftype == 'defect_issue_type') {
        var defect_issue_type = localStorage.getItem('DEFECTISSUETYPE');
        var defect_issue_type_lab = localStorage.getItem('DEFECTISSUETYPEVAL');
        var str = '';
        if (defect_issue_type != '' && defect_issue_type != null) {
            var diyArr = JSON.parse(defect_issue_type);
            var diyArrLab = JSON.parse(defect_issue_type_lab);
            var y = jQuery.grep(diyArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(diyArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTISSUETYPE', JSON.stringify(y));
                localStorage.setItem('DEFECTISSUETYPEVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTISSUETYPE');
                localStorage.removeItem('DEFECTISSUETYPEVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_severity') {
        var defect_severity = localStorage.getItem('DEFECTSEVERITY');
        var defect_severity_lab = localStorage.getItem('DEFECTSEVERITYVAL');
        var str = '';
        if (defect_severity != '' && defect_severity != null) {
            var dsArr = JSON.parse(defect_severity);
            var dsArrLab = JSON.parse(defect_severity_lab);
            var y = jQuery.grep(dsArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dsArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTSEVERITY', JSON.stringify(y));
                localStorage.setItem('DEFECTSEVERITYVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTSEVERITY');
                localStorage.removeItem('DEFECTSEVERITYVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_phase') {
        var defect_phase = localStorage.getItem('DEFECTPHASE');
        var defect_phase_lab = localStorage.getItem('DEFECTPHASEVAL');
        var str = '';
        if (defect_phase != '' && defect_phase != null) {
            var dpArr = JSON.parse(defect_phase);
            var dpArrLab = JSON.parse(defect_phase_lab);
            var y = jQuery.grep(dpArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dpArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTPHASE', JSON.stringify(y));
                localStorage.setItem('DEFECTPHASEVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTPHASE');
                localStorage.removeItem('DEFECTPHASEVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_category') {
        var defect_category = localStorage.getItem('DEFECTCATEGORY');
        var defect_category_lab = localStorage.getItem('DEFECTCATEGORYVAL');
        var str = '';
        if (defect_category != '' && defect_category != null) {
            var dcArr = JSON.parse(defect_category);
            var dcArrLab = JSON.parse(defect_category_lab);
            var y = jQuery.grep(dcArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dcArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTCATEGORY', JSON.stringify(y));
                localStorage.setItem('DEFECTCATEGORYVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTCATEGORY');
                localStorage.removeItem('DEFECTCATEGORYVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_status') {
        var defect_status = localStorage.getItem('DEFECTSTATUS');
        var defect_status_lab = localStorage.getItem('DEFECTSTATUSVAL');
        var str = '';
        if (defect_status != '' && defect_status != null) {
            var dsArr = JSON.parse(defect_status);
            var dsArrLab = JSON.parse(defect_status_lab);
            var y = jQuery.grep(dsArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dsArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTSTATUS', JSON.stringify(y));
                localStorage.setItem('DEFECTSTATUSVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTSTATUS');
                localStorage.removeItem('DEFECTSTATUSVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_assign_to') {
        var defect_assign_to = localStorage.getItem('DEFECTUSER');
        var defect_assign_to_lab = localStorage.getItem('DEFECTUSERVAL');
        var str = '';
        if (defect_assign_to != '' && defect_assign_to != null) {
            var dusArr = JSON.parse(defect_assign_to);
            var dusArrLab = JSON.parse(defect_assign_to_lab);
            var y = jQuery.grep(dusArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dusArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTUSER', JSON.stringify(y));
                localStorage.setItem('DEFECTUSERVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTUSER');
                localStorage.removeItem('DEFECTUSERVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_reported_by') {
        var defect_reported_by = localStorage.getItem('DEFECTREPORTED');
        var defect_reported_by_lab = localStorage.getItem('DEFECTREPORTEDVAL');
        var str = '';
        if (defect_reported_by != '' && defect_reported_by != null) {
            var drbArr = JSON.parse(defect_reported_by);
            var drbArrLab = JSON.parse(defect_reported_by_lab);
            var y = jQuery.grep(drbArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(drbArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTREPORTED', JSON.stringify(y));
                localStorage.setItem('DEFECTREPORTEDVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTREPORTED');
                localStorage.removeItem('DEFECTREPORTEDVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_owner') {
        var defect_owner = localStorage.getItem('DEFECTOWNER');
        var defect_owner_lab = localStorage.getItem('DEFECTOWNERVAL');
        var str = '';
        if (defect_owner != '' && defect_owner != null) {
            var doArr = JSON.parse(defect_owner);
            var doArrLab = JSON.parse(defect_owner_lab);
            var y = jQuery.grep(doArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(doArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTOWNER', JSON.stringify(y));
                localStorage.setItem('DEFECTOWNERVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTOWNER');
                localStorage.removeItem('DEFECTOWNERVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_due_date') {
        var defect_due_date = localStorage.getItem('DEFECTDUEDATE');
        var defect_due_date_lab = localStorage.getItem('DEFECTDUEDATEVAL');
        var str = '';
        if (defect_due_date != '' && defect_due_date != null) {
            var dduArr = JSON.parse(defect_due_date);
            var dduArrLab = JSON.parse(defect_due_date_lab);
            var y = jQuery.grep(dduArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dduArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTDUEDATE', JSON.stringify(y));
                localStorage.setItem('DEFECTDUEDATERVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTDUEDATE');
                localStorage.removeItem('DEFECTDUEDATEVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_activity_type') {
        var defect_activity_type = localStorage.getItem('DEFECTACTIVITYTYPE');
        var defect_activity_type_lab = localStorage.getItem('DEFECTACTIVITYTYPEVAL');
        var str = '';
        if (defect_activity_type != '' && defect_activity_type != null) {
            var dcArr = JSON.parse(defect_activity_type);
            var dcArrLab = JSON.parse(defect_activity_type_lab);
            var y = jQuery.grep(dcArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dcArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTACTIVITYTYPE', JSON.stringify(y));
                localStorage.setItem('DEFECTACTIVITYTYPEVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTACTIVITYTYPE');
                localStorage.removeItem('DEFECTACTIVITYTYPEVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_search_title') {
        var defect_task_case_no = localStorage.getItem('DEFECSEARCHTITLE');
        var defect_task_case_no_lab = localStorage.getItem('DEFECTTASKCASENOVAL');
        var str = '';
        if (defect_task_case_no != '' && defect_task_case_no != null) {
            var dtcnArr = JSON.parse(defect_task_case_no);
            var dtcnArrLab = JSON.parse(defect_task_case_no_lab);
            var y = jQuery.grep(dtcnArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dtcnArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTTASKCASENO', JSON.stringify(y));
                localStorage.setItem('DEFECTTASKCASENOVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTTASKCASENO');
                localStorage.removeItem('DEFECTTASKCASENOVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_task_case_no') {
        var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
        var defect_task_case_no_lab = localStorage.getItem('DEFECTTASKCASENOVAL');
        var str = '';
        if (defect_task_case_no != '' && defect_task_case_no != null) {
            var dtcnArr = JSON.parse(defect_task_case_no);
            var dtcnArrLab = JSON.parse(defect_task_case_no_lab);
            var y = jQuery.grep(dtcnArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dtcnArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTTASKCASENO', JSON.stringify(y));
                localStorage.setItem('DEFECTTASKCASENOVAL', JSON.stringify(z));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTTASKCASENO');
                localStorage.removeItem('DEFECTTASKCASENOVAL');
                ajaxDefectView();
                checkDefectSelect();
            }
        }
    }
    if (ftype == 'defect_search_title') {
        var defect_search_title = localStorage.getItem('DEFECTSEARCHTITLE');
        var str = '';
        if (defect_search_title != '' && defect_search_title != null) {
            var dstArr = JSON.parse(defect_search_title);
            var y = jQuery.grep(dstArr, function(value) {
                return value != id;
            });
            if (y.length > 0) {
                localStorage.setItem('DEFECTSEARCHTITLE', JSON.stringify(y));
                ajaxDefectView();
                checkDefectSelect();
            } else {
                localStorage.removeItem('DEFECTSEARCHTITLE');
                ajaxDefectView();
                checkDefectSelect()
            }
        }
    }
    var countDiv = $("#def_filtered_items > div").length;
    if (countDiv == 0) {
        defectResetAllFilters('all');
    }
}

function checkDefectSelect() {
    var defect_issue_type = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase = localStorage.getItem('DEFECTPHASE');
    var defect_category = localStorage.getItem('DEFECTCATEGORY');
    var defect_status = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to = localStorage.getItem('DEFECTUSER');
    var defect_due_date = localStorage.getItem('DEFECTDUEDATE');
    var defect_reported_by = localStorage.getItem('DEFECTREPORTED');
    var defect_owner = localStorage.getItem('DEFECTOWNER');
    var defect_activity_type = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_search_title = localStorage.getItem('DEFECTSEARCHTITLE');
    var str = '';
    if (defect_issue_type != '' && defect_issue_type != null) {
        $("#def_reset_btn").show();
        var defect_issue_type_lab = localStorage.getItem('DEFECTISSUETYPEVAL');
        var diyArr = JSON.parse(defect_issue_type);
        var diyArrLab = JSON.parse(defect_issue_type_lab);
        for (var i = 0; i < diyArr.length; i++) {
            var diyId = diyArr[i]
            var diyLabel = diyArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Issue Type' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_issue_type\");'>" + diyLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_issue_type\",\"" + diyArr[i] + "\",this,\"" + diyLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_severity != '' && defect_severity != null) {
        $("#def_reset_btn").show();
        var defect_severity_lab = localStorage.getItem('DEFECTSEVERITYVAL');
        var dsArr = JSON.parse(defect_severity);
        var dsArrLab = JSON.parse(defect_severity_lab);
        for (var i = 0; i < dsArr.length; i++) {
            var dsId = dsArr[i]
            var dsLabel = dsArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Severity' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_severity\");'>" + dsLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_severity\",\"" + dsArr[i] + "\",this,\"" + dsLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_phase != '' && defect_phase != null) {
        var defect_phase_lab = localStorage.getItem('DEFECTPHASEVAL');
        $("#def_reset_btn").show();
        var dpArr = JSON.parse(defect_phase);
        var dpArrLab = JSON.parse(defect_phase_lab);
        for (var i = 0; i < dpArr.length; i++) {
            var dpId = dpArr[i]
            var dpLabel = dpArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Bug Detection Phase' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_phase\");'>" + dpLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_phase\",\"" + dpArr[i] + "\",this,\"" + dpLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_category != '' && defect_category != null) {
        var defect_category_lab = localStorage.getItem('DEFECTCATEGORYVAL');
        $("#def_reset_btn").show();
        var dcArr = JSON.parse(defect_category);
        var dcArrLab = JSON.parse(defect_category_lab);
        for (var i = 0; i < dcArr.length; i++) {
            var dcId = dcArr[i]
            var dcLabel = dcArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Category' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_category\");'>" + dcLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_category\",\"" + dcArr[i] + "\",this,\"" + dcLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_status != '' && defect_status != null) {
        var defect_status_lab = localStorage.getItem('DEFECTSTATUSVAL');
        $("#def_reset_btn").show();
        var dsArr = JSON.parse(defect_status);
        var dsArrLab = JSON.parse(defect_status_lab);
        for (var i = 0; i < dsArr.length; i++) {
            var dsId = dsArr[i]
            var dsLabel = dsArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Status' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_status\");'>" + dsLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_status\",\"" + dsArr[i] + "\",this,\"" + dsLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_assign_to != '' && defect_assign_to != null) {
        var defect_assign_to_lab = localStorage.getItem('DEFECTUSERVAL');
        $("#def_reset_btn").show();
        var dusArr = JSON.parse(defect_assign_to);
        var dusArrLab = JSON.parse(defect_assign_to_lab);
        for (var i = 0; i < dusArr.length; i++) {
            var dusId = dusArr[i]
            var dusLabel = dusArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Assign To' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_assign_to\");'>" + dusLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_assign_to\",\"" + dusArr[i] + "\",this,\"" + dusLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_reported_by != '' && defect_reported_by != null) {
        var defect_reported_by_lab = localStorage.getItem('DEFECTREPORTEDVAL');
        $("#def_reset_btn").show();
        var drbArr = JSON.parse(defect_reported_by);
        var drbArrLab = JSON.parse(defect_reported_by_lab);
        for (var i = 0; i < drbArr.length; i++) {
            var drbId = drbArr[i]
            var drbLabel = drbArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Reported By' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_reported_by\");'>" + drbLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_reported_by\",\"" + drbArr[i] + "\",this,\"" + drbLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_owner != '' && defect_owner != null) {
        var defect_owner_lab = localStorage.getItem('DEFECTREPORTEDVAL');
        $("#def_reset_btn").show();
        var doArr = JSON.parse(defect_owner);
        var doArrLab = JSON.parse(defect_owner_lab);
        for (var i = 0; i < doArr.length; i++) {
            var doId = doArr[i]
            var doLabel = doArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Bug Owner' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_owner\");'>" + doLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_owner\",\"" + doArr[i] + "\",this,\"" + doLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_due_date != '' && defect_due_date != null) {
        var defect_due_date_lab = localStorage.getItem('DEFECTDUEDATEVAL');
        $("#def_reset_btn").show();
        var dduArr = JSON.parse(defect_due_date);
        var dduArrLab = JSON.parse(defect_due_date_lab);
        for (var i = 0; i < dduArr.length; i++) {
            var dduId = dduArr[i]
            var dduLabel = dduArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Due Date' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_due_date\");'>" + dduLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_due_date\",\"" + dduArr[i] + "\",this,\"" + dduLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_activity_type != '' && defect_activity_type != null) {
        var defect_activity_type_lab = localStorage.getItem('DEFECTACTIVITYTYPEVAL');
        $("#def_reset_btn").show();
        var datArr = JSON.parse(defect_activity_type);
        var datArrLab = JSON.parse(defect_activity_type_lab);
        for (var i = 0; i < datArr.length; i++) {
            var datId = datArr[i]
            var datLabel = datArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Activity Type' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_activity_type\");'>" + datLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_activity_type\",\"" + datArr[i] + "\",this,\"" + datLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_task_case_no != '' && defect_task_case_no != null) {
        var defect_task_case_no_lab = localStorage.getItem('DEFECTTASKCASENOVAL');
        $("#def_reset_btn").show();
        var dtcnArr = JSON.parse(defect_task_case_no);
        var dtcnArrLab = JSON.parse(defect_task_case_no_lab);
        for (var i = 0; i < dtcnArr.length; i++) {
            var dtcnId = dtcnArr[i]
            var dtcnLabel = dtcnArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Task#' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_task_case_no\");'>#" + dtcnLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_task_case_no\",\"" + dtcnArr[i] + "\",this,\"" + dtcnLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (defect_search_title != '' && defect_search_title != null) {
        $("#def_reset_btn").show();
        var dstArr = JSON.parse(defect_search_title);
        for (var i = 0; i < dstArr.length; i++) {
            var dstLabel = getTestCaseColorAct(dstArr[i]);
            str += "<div class='fl filter_opn' rel='tooltip' title='Search Title' onclick='defect_openfilter_popup(0,\"dropdown_menu_defect_all_filters\");defect_allfiltervalue(\"defect_search_title\");'>" + dstLabel + "<a href='javascript:void(0);' onclick='def_common_reset_filter(\"defect_search_title\",\"" + dstArr[i] + "\",this);' class='fr'>X</a></div>";
        }
    }
    if (str != '') {
        $("#def_filtered_items").html(str);
        $("#def_filtered_item").show();
    } else {
        $("#def_filtered_items").html('');
        $("#def_filtered_item").hide();
    }
}

function defectResetAllFilters(type) {
    // alert("hii swetalina");
    $("#dropdown_menu_defect_all_filters").hide();
    if (type == 'all') {
        $('#def_filtered_item').fadeOut('slow');
        $("#def_reset_btn").hide();
        defect_remember_filters('reset', '');
        ajaxDefectView();
        checkDefectSelect();
    }
}

function defect_groupby(gbtype) {
    defect_remember_filters('DEFECTGROUPBY', gbtype);
    ajaxDefectView();
   // $("#defectLoader").hide();
}

function def_common_reset_group(ftype, id, obj) {
    localStorage.removeItem('DEFECTGROUPBY');
    ajaxDefectView();
    checkDefectGroup();
   // $("#defectLoader").hide();
}

function checkDefectGroup() {
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    var str = '';
    if (defect_group_by != '' && defect_group_by != null) {
        if (defect_group_by == 'defect_issue_type') {
            var actLabel = 'Issue Type';
            str += "<div class='fl filter_opn' rel='tooltip' title='Issue Type' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'defect_severity') {
            var actLabel = 'Severity';
            str += "<div class='fl filter_opn' rel='tooltip' title='Severity' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'defect_phase') {
            var actLabel = 'Detection Phase ';
            str += "<div class='fl filter_opn' rel='tooltip' title='Detection Phase' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'defect_category') {
            var actLabel = 'Category';
            str += "<div class='fl filter_opn' rel='tooltip' title='Category' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'defect_activity_type') {
            var actLabel = 'Activity Type';
            str += "<div class='fl filter_opn' rel='tooltip' title='Activity Type' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'title') {
            var actLabel = 'Title';
            str += "<div class='fl filter_opn' rel='tooltip' title='Title' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'release') {
            var actLabel = 'Release';
            str += "<div class='fl filter_opn' rel='tooltip' title='Release' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'defect_task') {
            var actLabel = 'Task';
            str += "<div class='fl filter_opn' rel='tooltip' title='Task' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_status_id') {
            var actLabel = 'Status';
            str += "<div class='fl filter_opn' rel='tooltip' title='Status' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_assign_to_id') {
            var actLabel = 'Assign To';
            str += "<div class='fl filter_opn' rel='tooltip' title='Assign To' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_reporter_by_id') {
            var actLabel = 'Reported By';
            str += "<div class='fl filter_opn' rel='tooltip' title='Reported By' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_owner_id') {
            var actLabel = 'Bug Owner';
            str += "<div class='fl filter_opn' rel='tooltip' title='Bug Owner' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_resolution_id') {
            var actLabel = 'Resolution';
            str += "<div class='fl filter_opn' rel='tooltip' title='Resolution' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_due_date_id') {
            var actLabel = 'Due Date';
            str += "<div class='fl filter_opn' rel='tooltip' title='Due Date' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_created_date_id') {
            var actLabel = 'Created Date';
            str += "<div class='fl filter_opn' rel='tooltip' title='Created Date' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        } else if (defect_group_by == 'def_modified_date_id') {
            var actLabel = 'Last Updated Date';
            str += "<div class='fl filter_opn' rel='tooltip' title='Last Updated Date' onclick='defect_openfilter_popup(0,\"dropdown_menu_groupby_filters\");'>" + actLabel + "<a href='javascript:void(0);' onclick='def_common_reset_group(\"taskgroupby\",\"" + '' + "\",this);' class='fr'>X</a></div>";
        }
    }
    if (str != '') {
        $("#def_groupby_items").html(str);
        $("#def_groupby_items").show();
    } else {
        $("#def_groupby_items").html('');
        $("#def_groupby_items").hide();
    }
}

function searchDefectEnter(srch) {
    $('#ajax_search').hide();
    $('#defectLoader').show();
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_status_id = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to_id = localStorage.getItem('DEFECTUSER');
    var defect_reported_by_id = localStorage.getItem('DEFECTREPORTED');
    var defect_owner_id = localStorage.getItem('DEFECTOWNER');
    var defect_due_date_id = localStorage.getItem('DEFECTDUEDATE');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_list", {
        'due_date': defect_due_date_id,
        'owner_id': defect_owner_id,
        'reporter_id': defect_reported_by_id,
        'assign_to': defect_assign_to_id,
        'defect_status_id': defect_status_id,
        'srch': srch,
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectViewSpan").html(tmpl("defect_list_tmpl", res));
            $('#defectLoader').hide();
            checkDefectSelect();
            checkDefectGroup();
        }
    });
}

function searchDefect(id, uniq_id, srch) {
    $('#ajax_search').hide();
    $('#defectLoader').show();
    defect_remember_filters('DEFECSEARCHTITLE', id, srch);
    checkDefectSelect();
    checkDefectGroup();
    var defect_issue_type_id = localStorage.getItem('DEFECTISSUETYPE');
    var defect_severity_id = localStorage.getItem('DEFECTSEVERITY');
    var defect_phase_id = localStorage.getItem('DEFECTPHASE');
    var defect_category_id = localStorage.getItem('DEFECTCATEGORY');
    var defect_status_id = localStorage.getItem('DEFECTSTATUS');
    var defect_assign_to_id = localStorage.getItem('DEFECTUSER');
    var defect_reported_by_id = localStorage.getItem('DEFECTREPORTED');
    var defect_owner_id = localStorage.getItem('DEFECTOWNER');
    var defect_due_date_id = localStorage.getItem('DEFECTDUEDATE');
    var defect_activity_type_id = localStorage.getItem('DEFECTACTIVITYTYPE');
    var defect_task_case_no = localStorage.getItem('DEFECTTASKCASENO');
    var defect_group_by = localStorage.getItem('DEFECTGROUPBY');
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_list", {
        'due_date': defect_due_date_id,
        'owner_id': defect_owner_id,
        'reporter_id': defect_reported_by_id,
        'assign_to': defect_assign_to_id,
        'defect_status_id': defect_status_id,
        'id': id,
        "uniq_id": uniq_id,
        'defect_group_by': defect_group_by,
        'defect_task_case_no': defect_task_case_no,
        'defect_activity_type_id': defect_activity_type_id,
        'defect_category_id': defect_category_id,
        'defect_issue_type_id': defect_issue_type_id,
        'defect_severity_id': defect_severity_id,
        'defect_phase_id': defect_phase_id
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectViewSpan").html(tmpl("defect_list_tmpl", res));
            $('#defectLoader').hide();
            checkDefectSelect();
            checkDefectGroup();
        }
    });
}

function getDefectColorPriority(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return '<b>NA</b>';
    } else if (casePriority == 0) {
        return '<b style="color:#FF0000;">High</b>';
    } else if (casePriority == 1) {
        return '<b style="color:#28AF51;">Medium</b>';
    } else if (casePriority == 2) {
        return '<b style="color:#B4A532;">Low</b>';
    }
}

function getDefectColorPr(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return '<b>NA</b>';
    } else if (casePriority == 0) {
        return 'pr_high';
    } else if (casePriority == 1) {
        return 'pr_medium';
    } else if (casePriority == 2) {
        return 'pr_low';
    }
}

function getDefectColorAct(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return 'NA';
    } else if (casePriority == 1) {
        return 'Pass';
    } else if (casePriority == 2) {
        return 'Failed';
    } else if (casePriority == 3) {
        return 'Blocked';
    } else if (casePriority == 4) {
        return 'Invalid';
    }
}

function getDefectColorActul(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return '<b>NA</b>';
    } else if (casePriority == 1) {
        return '<b style="color:#28AF51;">Pass</b>';
    } else if (casePriority == 2) {
        return '<b style="color:red">Failed</b>';
    } else if (casePriority == 3) {
        return '<b style="color:#B4A532;">Blocked</b>';
    } else if (casePriority == 4) {
        return '<b style="color:#E651DF">Invalid</b>';
    }
}

function defectType(type) {
    if (type == "NULL" || type == "") {
        return 'NA';
    } else if (type == 1) {
        return 'Yes';
    } else if (type == 2) {
        return 'No';
    }
}

function defectOrigin(origin) {
    if (origin == "NULL" || origin == "") {
        return 'NA';
    } else if (origin == 1) {
        return 'Requirements';
    } else if (origin == 2) {
        return 'Design';
    } else if (origin == 3) {
        return 'Development';
    }
}

function defectResolution(resolution) {
    if (resolution == "NULL" || type == "") {
        return 'NA';
    } else if (resolution == 1) {
        return 'Fixed';
    } else if (resolution == 2) {
        return "Won't Fix";
    } else if (resolution == 3) {
        return "Not an Issue";
    } else if (resolution == 4) {
        return "Duplicate";
    } else if (resolution == 5) {
        return "Can not reproduce";
    } else if (resolution == 6) {
        return "Invalid";
    } else if (resolution == 7) {
        return "Not an Issue";
    }
}

function converSecondToHourMin(seconds) {
    var hours = Math.floor(seconds / 3600);
    var seconds = seconds - hours * 3600;
    var minutes = Math.floor(seconds / 60);
    seconds -= minutes * 60;
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    return hours + ':' + minutes;
}

function ajaxDefectDetails(defect_uniq_id) {
    $('#testCaseLoader').show();
    $('#defectViewDetails').show();
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_details", {
        'defect_uniq_id': defect_uniq_id
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#testCaseLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#defectViewDetails").html(tmpl("defect_details_tmpl", res));
						$("a[rel^='prettyPhoto']").prettyPhoto({
                animation_speed: 'normal',
                autoplay_slideshow: false,
                social_tools: false,
                overlay_gallery: false,
                deeplinking: false
            });
            $('#testCaseLoader').hide();
        }
    });
}

function DefectimageTypeIcon(format) {
    var iconsArr = ["gd", "db", "zip", "xls", "doc", "jpg", "png", "bmp", "pdf", "tif"];
    if (format == "xlsx") {
        format = "xls"
    } else if (format == "docx" || format == "rtf" || format == "odt") {
        format = "doc"
    } else if (format == "jpeg") {
        format = "jpg"
    } else if (format == "gif") {
        format = "png"
    } else if (format == "rar" || format == "gz" || format == "bz2") {
        format = "zip"
    }
    if ($.inArray(format, iconsArr) == -1) {
        format = 'html'
    }
    return format;
}

function ediDefect(id) {
    openPopup('defect');
    $(".edit_defect").show();
    $(".ecit_defect_loader_dv").show();
    $('#edit_inner_defect').html('');
    $.post(HTTP_ROOT + "defect/defects/ajax_edit_defect", {
        "id": id
    }, function(data) {
        if (data) {
            $('.select2').select2();
            $(".ecit_defect_loader_dv").hide();
            $('#edit_inner_defect').show();
            $('#edit_inner_defect').html(data);
        }
    });
}

function replyDefect(id, issue_no, title) {
    var title = unescape(title);
    openPopup('log');
    $(".reply_def_project").show();
    $(".reply_def_loader_dv").show();
    $('#reply_def_inner_mvproj').html('');
    $('#header_reply_def_prj').html('Re-Test (#' + issue_no + ": " + title + ")");
    $("#err_msg_dv").hide();
    $.post(HTTP_ROOT + "Defect/defects/ajax_defect_reply", {
        "id": id
    }, function(data) {
        // console.log(data);
        if (data) {
            $(".reply_def_loader_dv").hide();
            $('#reply_def_inner_mvproj').show();
            $('.select2').select2();
            $('#reply_def_inner_mvproj').html(data);
            $('.mv-btn').show();
            $("#reply_def_cp_prj_btn").show();
            $('#case_no').val(issue_no);
            $("#tc_new_project").focus();
        }
    });
}

function ajaxDefectFilesView() {
    $('#defectLoader').show();
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_files", {}, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectFileViewSpan").html(tmpl("defect_files_tmpl", res));
            $('#defectLoader').hide();
        }
    });
}

function downloadDefectImage(obj) {
    window.location.href = $(obj).attr('data-url');
}

function ajaxDefectFilePage(page) {
    $('#defectLoader').show();
    $.post(HTTP_ROOT + "defect/defects/ajax_defect_files", {
        'page': page
    }, function(res) {
        if (res) {
            if (res.errormsg) {
                $('#defectLoader').hide();
                showTopErrSucc('error', res.errormsg);
                return false;
            }
            $("#DefectFileViewSpan").html(tmpl("defect_files_tmpl", res));
            $('#defectLoader').hide();
        }
    });
}

function removeDefectFileFrmFiles(file_id) {
    var url = HTTP_ROOT + "Defect/Defects/defect_file_remove";
    if (confirm(_("Are you sure you want to remove?"))) {
        $('#defectLoader').show();
        var val = new Array();
        val.push(file_id);
        var name = $('#file_remove_' + file_id).attr("data-name");
        $.post(url, {
            "val": val
        }, function(data) {
            ajaxDefectFilesView();
            showTopErrSucc('success', _("File '") + name + "'" + _(" is removed."));
        });
    }
}

function archiveDefectFile(obj) {
    var id = $(obj).attr("data-id");
    var name = $(obj).attr("data-name");
    var conf = confirm(_("Are you sure you want to archive the file '") + name + "' ?");
    if (conf == false) {
        return false;
    } else {
        var curRow = "curRow" + id;
        $("#" + curRow).fadeOut(500);
        var strurl = HTTP_ROOT + "Defect/Defects/archive_defect_file";
        $.post(strurl, {
            "id": id
        }, function(data) {
            if (data) {
                ajaxTestCaseFilesView();
                showTopErrSucc('success', _("File '") + name + "'" + _(" is archived."));
            }
        });
    }
}

function deleteDefect(id) {
    if (confirm("Are you sure you want to delete the bug?")) {
        var page_hash = getHash();
        var hashtag = parseUrlHash(urlHash);
        $('#testCaseLoader').show();
        $.post(HTTP_ROOT + "Defect/Defects/delete_defect", {
            "id": id,
            "page_hash":page_hash
        }, function(data) {
            if (data.status == 'success') {
                showTopErrSucc('success', _("Bug deleted successfully."));
                if(page_hash){
                    if(hashtag[0] == "calendar" || hashtag[0] == "kanban" || hashtag[0] == "details" || hashtag[0] == "taskgroups" || hashtag[0] == "tasks" || hashtag[0] == "activities" || hashtag[0] == "timelog" ||  hashtag[0] == "timesheet" ||  hashtag[0] == "timesheet_weekly"){
                        fetchAllBugsTask(data.task_id);
                        closePopup();
                        
                    }else{
                        $("#case_bug_task_dtl" + data.task_id).html('');
                        $("#case_bug_task_dtl" + data.task_id).html(tmpl("case_bug_load_tmpl", data));
                        closePopup();
                    }
                   
                } else{
                    window.location.href = HTTP_ROOT + 'defect';
                }
                
            } else {
                showTopErrSucc('error', _("Error in deleting bug."));
                window.location.href = HTTP_ROOT + 'defect';
            }
        }, 'json');
    }
}

function changeArcDefectFileList(type) {
    var displayedfiles = $("#displayedDefectFiles").val();
    var limit1, limit2;
    if (type == "more") {
        limit1 = displayedfiles;
        limit2 = ARC_FILE_PAGE_LIMIT;
    } else {
        limit1 = 0;
        limit2 = ARC_FILE_PAGE_LIMIT;
    }
    if (type == "more") {
        $(".morebar_arc_case").show();
        var lastCountFiles = $("#defectfilelist").children("tr:last").attr("data-value");
    } else {
        document.getElementById('caseLoader').style.display = 'block';
    }
    var url = HTTP_ROOT + "Defect/Defects/archive_defect_files";
    $.post(url, {
        "pjid": "all",
        "limit1": limit1,
        "limit2": limit2,
        "lastCountFiles": lastCountFiles
    }, function(data) {
        if (data) {
            $("#filelistDiv").hide();
            $("#caselistDiv").hide();
            $("#testcasefilelistDiv").hide();
            $("#defectfilelistDiv").show();
            $('#file_li').removeClass('active');
            $('#task_li').removeClass('active');
            $('#test_case_file_li').removeClass('active');
            $('#defect_file_li').addClass('active');
            var data = data.replace("<head/>", "");
            var data = data.replace("<head/ >", "");
            var data = data.replace("<head />", "");
            if (type == "more") {
                $(".morebar_arc_case").hide();
                $('.testcasefilelistall').append(data);
                if ($('.chkOneArcFile:checked').length == $(".chkOneArcFile").length) {
                    $("#alldefectfile").prop('checked', true);
                } else {
                    $("#alldefectfile").prop('checked', false);
                }
                var displayedfiles = $("#displayedDefectFiles").val();
                var newdisplayedfiles = (parseInt(displayedfiles)) + ARC_FILE_PAGE_LIMIT;
                $("#displayedDefectFiles").val(newdisplayedfiles);
            } else {
                document.getElementById('caseLoader').style.display = "none";
                $(".all_first_rows_files").remove();
                $(".filepjid").remove();
                $(".total_file_count").remove();
                $("#displayedDefectFiles").remove();
                $("#displayedDefectFiles").val(ARC_FILE_PAGE_LIMIT);
                $('#alldefectfile').parents('.dropdown').removeClass('active');
                $('#alldefectfile').next('.all_chk').attr('data-toggle', '');
                $('#alldefectfile').prop('checked', false);
                $('.defectfilelistall').find("tr:gt(0)").remove();
                $('.defectfilelistall').append(data);
            }
        }
    });
}

function enableArcDefectFileOptions() {
    if ($('.chkOneArcDefectFile:checked').length) {
        $('#alldefectfile').parents('.dropdown').addClass('active');
        $('#alldefectfile').next('.all_chk').attr('data-toggle', 'dropdown');
    } else {
        $('#alldefectfile').parents('.dropdown').removeClass('active');
        $('#alldefectfile').next('.all_chk').attr('data-toggle', '');
    }
}
$(function(chkAll, chkOne, row, active_class) {
    $(document).on('click', chkAll, function(e) {
        if ($(chkAll).is(':checked')) {
            $(chkOne).prop('checked', true);
            $(chkOne).parents(row).addClass(active_class);
        } else {
            $(chkAll).parent().removeClass('open');
            $(chkOne).prop('checked', false);
            $(chkOne).parents(row).removeClass(active_class);
        }
        enableArcDefectFileOptions();
    });
    $(document).on('click', chkOne, function(e) {
        if ($(this).is(':checked')) {
            $(this).parents(row).addClass(active_class);
        } else {
            $(chkAll).parent().removeClass('open');
            $(this).parents(row).removeClass(active_class);
        }
        if ($(chkOne + ':checked').length == $(chkOne).length) {
            $(chkAll).prop('checked', true);
        } else {
            $(chkAll).prop('checked', false);
        }
        enableArcDefectFileOptions();
    });
}('#alldefectfile', '.chkOneArcDefectFile', '.tr_all', 'tr_all_active'));

function removeDefectfile() {
    var pjid = document.getElementById('defectfilepjid').value;
    var count = document.getElementById("all").value;
    var val = new Array();
    for (var i = 1; i <= count; i++) {
        if (document.getElementById("file" + i).checked == true) {
            val.push(document.getElementById("file" + i).value);
        }
    }
    var url = HTTP_ROOT + "Defect/Defects/defect_file_remove";
    if (val.length != '0') {
        if (confirm(_("Are you sure you want to remove?"))) {
            document.getElementById('caseLoader').style.display = "block";
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    showTopErrSucc('success', _('File is removed.'));
                    changeArcDefectFileList('');
                }
            });
        }
    } else {
        alert(_("No file selected!"));
    }
}

function restoredDefectFile() {
    var pjid = document.getElementById('defectfilepjid').value;
    var count = $("#defectfilelist").children("tr:last").attr("data-value");
    var val = new Array();
    for (var i = 1; i <= count; i++) {
        if (document.getElementById("file" + i).checked == true) {
            val.push(document.getElementById("file" + i).value);
        }
    }
    var url = HTTP_ROOT + "Defect/Defects/move_defect_file";
    if (val.length != '0') {
        if (confirm("Are you sure you want to restore?")) {
            document.getElementById('caseLoader').style.display = "block";
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    changeArcDefectFileList('');
                    showTopErrSucc('success', _('File has been restored.'));
                }
            });
        }
    } else {
        alert("No file selected!");
    }
}

function reopenDefect(id) {
    if (confirm("Do you want to reopen defect?")) {
        $('#defectLoader').show();
        $.post(HTTP_ROOT + "Defect/defects/reopen_defect", {
            "id": id
        }, function(data) {
            if (data.status == 'success') {
                showTopErrSucc('success', _("Bug reopen successfully."));
                location.reload();
            } else {
                showTopErrSucc('error', _("Error in reopening bug."));
                location.reload();
            }
        }, 'json');
    }
}
function openRetestEditor(){
    if (tinymce.get('defect_comment_id')) {
        tinymce.get('defect_comment_id').remove();
    }
    tinymce.init({
        selector: "#defect_comment_id",
        plugins: 'paste importcss autolink image directionality fullscreen link  charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
        menubar: false,
        branding: false,
        statusbar: false,
        toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | ltr rtl | fullscreen',
        toolbar_sticky: true,
        importcss_append: true,
        image_caption: true,
        browser_spellcheck: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
        //directionality: dir_tiny,
        toolbar_drawer: 'sliding',
        resize: false,
        min_height: 160,
        max_height: 400,
        paste_data_images: true,
        paste_as_text: true,
        autoresize_on_init: true,
        autoresize_bottom_margin: 20,
        content_css: HTTP_ROOT + 'css/tinymce.css',
        setup: function(ed) {
            ed.on('Click', function(ed, e) {
            });
            ed.on('KeyUp', function(ed, e) {
                    var inpt = $.trim(tinymce.activeEditor.getContent());
                    var inptLen = inpt.length;
                    var datInKb = 0;
                    var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
            });
            ed.on('Change', function(ed, e) {
							$('.field_wrapper.text_editor').removeClass('focus');
							var inpt = $.trim(tinymce.activeEditor.getContent());
							var inptLen = inpt.length;
							var datInKb = 0;
							var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
							if (datInKb > 2049) {
											var dtt_T = inpt.split('<img');
											dtt_T.pop();
											dtt_T = dtt_T.join('<img');
											dtt_T = dtt_T + '</p>';
											showTopErrSucc('error', _('Maximum limit of 2 mb reached'), 1);
											tinymce.activeEditor.setContent(dtt_T);
							}
            });
            ed.on('init', function(e) {
							$('.field_wrapper.text_editor').removeClass('focus');
							if(typeof editormessage != 'undefined'){
									$('#defect_comment_id').val(editormessage);
									tinymce.get('defect_comment_id').setContent(editormessage);
							}
            });
        }
    });
}
function openEditorDefect(editormessage) {
	if (tinymce.get('def_description')) {
		tinymce.get('def_description').remove();
	}
	tinymce.init({
		selector: "#def_description",
		plugins: 'paste importcss autolink image directionality fullscreen link  charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
		menubar: false,
		branding: false,
		statusbar: false,
		toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | ltr rtl | fullscreen',
		toolbar_sticky: true,
		importcss_append: true,
		image_caption: true,
		browser_spellcheck: true,
		quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
		//directionality: dir_tiny,
		toolbar_drawer: 'sliding',
		resize: false,
		min_height: 160,
		max_height: 400,
		paste_data_images: true,
		paste_as_text: true,
		autoresize_on_init: true,
		autoresize_bottom_margin: 20,
		content_css: HTTP_ROOT + 'css/tinymce.css',
		setup: function(ed) {
			ed.on('Click', function(ed, e) {
			});
			ed.on('KeyUp', function(ed, e) {
							var inpt = $.trim(tinymce.activeEditor.getContent());
							var inptLen = inpt.length;
							var datInKb = 0;
							var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
			});
			ed.on('Change', function(ed, e) {
				$('.field_wrapper.text_editor').removeClass('focus');
				var inpt = $.trim(tinymce.activeEditor.getContent());
				var inptLen = inpt.length;
				var datInKb = 0;
				var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
				if (datInKb > 2049) {
					var dtt_T = inpt.split('<img');
					dtt_T.pop();
					dtt_T = dtt_T.join('<img');
					dtt_T = dtt_T + '</p>';
					showTopErrSucc('error', _('Maximum limit of 2 mb reached'), 1);
					tinymce.activeEditor.setContent(dtt_T);
				}
			});
			ed.on('init', function(e) {
				$('.field_wrapper.text_editor').removeClass('focus');
				if(typeof editormessage != 'undefined'){
						$('#def_description').val(editormessage);
						tinymce.get('def_description').setContent(editormessage);
				}
			});
		}
	});
}

function openEditorEditDefect(editormessage) {		
    if (tinymce.get('edit_def_description')) {
			tinymce.get('edit_def_description').remove();
    }
    tinymce.init({
			selector: "#edit_def_description",
			plugins: 'paste importcss autolink image directionality fullscreen link  charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
			menubar: false,
			branding: false,
			statusbar: false,
			toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | ltr rtl | fullscreen',
			toolbar_sticky: true,
			importcss_append: true,
			image_caption: true,
			browser_spellcheck: true,
			quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
			//directionality: dir_tiny,
			toolbar_drawer: 'sliding',
			resize: false,
			min_height: 160,
			max_height: 400,
			paste_data_images: true,
			paste_as_text: true,
			autoresize_on_init: true,
			autoresize_bottom_margin: 20,
			content_css: HTTP_ROOT + 'css/tinymce.css',
			setup: function(ed) {
				ed.on('Click', function(ed, e) {
				});
				ed.on('KeyUp', function(ed, e) {
								var inpt = $.trim(tinymce.activeEditor.getContent());
								var inptLen = inpt.length;
								var datInKb = 0;
								var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
				});
				ed.on('Change', function(ed, e) {
					$('.field_wrapper.text_editor').removeClass('focus');
					var inpt = $.trim(tinymce.activeEditor.getContent());
					var inptLen = inpt.length;
					var datInKb = 0;
					var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
					if (datInKb > 2049) {
						var dtt_T = inpt.split('<img');
						dtt_T.pop();
						dtt_T = dtt_T.join('<img');
						dtt_T = dtt_T + '</p>';
						showTopErrSucc('error', _('Maximum limit of 2 mb reached'), 1);
						tinymce.activeEditor.setContent(dtt_T);
					}
				});
				ed.on('init', function(e) {
					$('.field_wrapper.text_editor').removeClass('focus');
					if(typeof(editormessage) !== undefined ){
							$('#edit_def_description').val(editormessage);
							tinymce.get('edit_def_description').setContent(editormessage);
					}							 
				});
			}
    });
}

function defect_hide_show() {
    $('.task_details_title_list').css('height', '100%');
    if ($('#cxd').text() == 'Hide Details') {
        $('#cxd').text('Show Details');
        $('.collapse_txt_defect span').addClass('arrow_up');
    } else {
        $('#cxd').text('Hide Details');
        $('.collapse_txt_defect span').removeClass('arrow_up');
    }
}

function viewMoreDefectHistory() {
    openPopup('defect');
    var defectUniqId = $("#uniq_id_more").val();
    $(".loader_dv_prj").show();
    $(".defect_history_popup").show();
    if (defectUniqId != '') {
        var params = {
            uid: defectUniqId
        };
        $.post(HTTP_ROOT + "Defect/defects/get_defect_all_history", {
            'data': params
        }, function(res) {
            $("#defect_history_id").html(res);
            $(".loader_dv_prj").hide();
        });
    }
}

function saveFields() {
    var values = [];
    var flag = 0;
    var flagCount = 0;
    $('.customFields').each(function() {
        if (this.checked) {
            values.push($(this).val());
            flag = 1;
            flagCount++;
        }
    });
    if (flagCount >= 5) {
        $("#defectLoader").show();
        $.post(HTTP_ROOT + "Defect/defects/save_fields", {
            'data': values
        }, function(res) {
            $('#hideShowField').removeClass('open');
            $("#defectLoader").show();
            ajaxDefectView();
        });
    } else {
        alert('Please select atleast any 5 fields');
    }
}

function inArray(needle, haystack) {
	 if(haystack == null){ return true; }
    var length = haystack.length;
    if (length != 0) {
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
    } else {
        return true;
    }
    return false;
}

function checkShowSaveIcon() {
    var flag = 0;
    var checked_field = 0;
    $('.customFields').each(function() {
        if (this.checked) {
            flag = 1;
            checked_field = checked_field + 1;
        }
    });
    if(checked_field ==  $('.customFields').length){
        $(".customField").prop("checked", true);
    } else {
        $(".customField").prop("checked", false);
    }
    if (flag == 1) {
        $("#def_save_field_btn").show();
    } else {
        $("#def_save_field_btn").hide();
    }

}

function checkShowSaveIconAll() {
    var status = $("#fAllId").is(":checked");
    $(".customFields").prop("checked",status);
    $("#def_save_field_btn").show();
   
}

function checkboxDefectStatus(id, typ, dsVal, dsLab) {
    var x = "";
    var totid = $("#totDsId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_status_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dStatus_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dStatus_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTSTATUS', dsVal, dsLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_status', dsVal, '', dsLab);
    }
}

function checkboxDefectUser(id, typ, dusVal, dusLab) {
    var x = "";
    var totid = $("#totDusId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_assign_to_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dUser_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dUser_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTUSER', dusVal, dusLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_assign_to', dusVal, '', dusLab);
    }
}

function checkboxDefectReported(id, typ, drbVal, drbLab) {
    var x = "";
    var totid = $("#totDrbId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_reported_by_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dReported_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dReported_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTREPORTED', drbVal, drbLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_reported_by', drbVal, '', drbLab);
    }
}

function checkboxDefectOwner(id, typ, doVal, doLab) {
    var x = "";
    var totid = $("#totDoId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
        document.getElementById('defect_owner_all').checked = false;
        if (typ == "check") {
            if (document.getElementById(id).checked == true) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        } else {
            if (document.getElementById(id).checked == false) {
                document.getElementById(id).checked = true;
            } else {
                document.getElementById(id).checked = false;
            }
        }
    }
    for (var j = 0; j < actArr.length; j++) {
        var checkboxid = "dOwner_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dOwner_" + actArr[j];
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        defect_remember_filters('DEFECTOWNER', doVal, doLab);
        ajaxDefectView();
        checkDefectSelect();
    } else {
        def_common_reset_filter('defect_owner', doVal, '', doLab);
    }
}

function defectCheckboxdueDate(x, typ) {
   $('#defect_duedate_' + x).attr('checked', 'checked');
    if (x) {
        $('#defect_duedate_' + x).attr('checked', 'checked');
    } else {
        $('#defect_duedate_any').attr('checked', 'checked');
    }
    var z = x;
    if (x == 'any') {
        x = 'any';
    }
    var y = x;
    if (x == '24') {
        y = 'Today';
    }
    $('#duefrm').val("");
    $('#dueto').val("");
    $('#defect_custom_duedate').hide();
    defect_remember_filters('DEFECTDUEDATE', x, y);
    ajaxDefectView();
    checkDefectSelect();
    if (z == 'any') {
        def_common_reset_filter('defect_owner', x, '', x);
    }
}

function defectCheckboxCustom(id, cid, ctype) {
    if (ctype) {
        $('#' + cid).attr('checked', 'checked');
    } else {
        if (!$('#' + cid).is(":checked")) {
            $('.cbox_date').removeAttr('checked');
            $('#defect_duedate_any').prop('checked', true);
        } else {
            $('.cbox_date').removeAttr('checked');
            $('#' + cid).prop('checked', true);
        }
    }
    if ($('#' + cid).is(':checked')) {
        $('#' + id).show();
        $('#' + cid).prop('checked', true);
    } else {
        $('#' + id).hide();
        $('#' + ctype + 'frm').val("");
        $('#' + ctype + 'to').val("");
        checkboxDate('', '');
        if ((id != 'defect_custom_date') || (id != 'defect_custom_duedate')) {}
    }
}

function defectSearchduedate() {
    var defect_duefrm = $.trim($('#defect_duefrm').val());
    var defect_dueto = $.trim($('#defect_dueto').val());
    if (defect_duefrm == '') {
        showTopErrSucc('error', _('From Date cannot be left blank!'));
        $('#defect_duefrm').focus();
        return false;
    } else if (defect_dueto == '') {
        showTopErrSucc('error', _('To Date cannot be left blank!'));
        $('#defect_dueto').focus();
        return false;
    } else if (Date.parse(defect_duefrm) > Date.parse(defect_dueto)) {
        showTopErrSucc('error', _('From Date cannot exceed To Date!'));
        $('#defect_duefrm').focus();
        return false;
    } else {
        var x = defect_duefrm + ":" + defect_dueto;
        defect_remember_filters('DEFECTDUEDATE', encodeURIComponent(x), x);
        ajaxDefectView();
        checkDefectSelect();
    }
}
function showHideBugFilter() {
    $('#bug_filter_section').modal({
        show: true,
    });
    
        $('.filter_det').hide();
        $('#filter_title_sec').text(_('Filter Your Bug'));
   /* if (typeof uhas != 'undefined' && uhas.indexOf("tasks/") != -1) {
        var sub_dmn = uhas.split('tasks/');
        if ($.trim(sub_dmn[1]) != '') {
            $(".only_set_activecls").each(function() {
                if (this.href.indexOf(sub_dmn[1]) != -1) {
                    $(this).parent('.dtl_label_tag_tsk').addClass('active');
                }
            });
        }
    } else {
        $('.default_cmn_filtr').addClass('active');
    } */
}
function closeBugFilter() {
    $('.filter_det').show();
    $('#dropdown_menu_status, #dropdown_menu_types, #dropdown_menu_priority, #dropdown_menu_comments, #dropdown_menu_taskgroup, #dropdown_menu_users, #dropdown_menu_assignto, #dropdown_menu_label, #dropdown_menu_resource').html('');
    $('.filter_type_header').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).next('.filter_toggle_data').hide();
        }
    });
}
function searchFilterItems(obj) {
    val = $(obj).val().toUpperCase();
    $(obj).closest('ul').find('li').each(function() {
        if ($(this).find('.checkbox').ignore("span").text().toUpperCase().indexOf(val) > -1 || $(this).find('.slide_menu_div1').ignore("span").text().toUpperCase().indexOf(val) > -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
        if (val.trim() == '') {
            $(this).show();
        }
    });
}
function displayTaskDetails(uniqid) {
    var caseUniqId = uniqid;
    $("#myModalDetail").modal();
    $(".task_details_popup").show();
    $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
    $("#cnt_task_detail_kb").html("");
    easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
}

function getDefectStatus(id,type){
    var name_arry = {1:"New",2:"In-Progress",3:"Closed",5:"Resolved"};
    var color_arry = {1:"#f19a91",2:"#8dc2f8",3:"#f3c788",5:"#8ad6a3"};
    if(type == 'name'){
        return name_arry[id];
    }else{
        return color_arry[id];
    }
}
