$(function() {
    $(document).on('click', '#cpy_lnk', function() {
        var selected_text = $('#cpy_lnk').data('cpylnk');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(selected_text).select();
        document.execCommand("copy");
        $temp.remove();
        showTopErrSucc('success', _('Task Link Copied successfully.'));
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            if ($('.create-task-container').is(':visible')) {
                crt_popup_close('CT');
            }
        }
    });
    $(document).on('click', '[id^="actChkBklog"]', function() {
        var is_bktskchk = 0;
        var actvMilCnt = $('tbody[id^="tobody_"]').length;
        var actvmileIds = new Array();
        var id = $(this).attr('id').split('actChkBklog');
        var idval = $(this).val().split('|');
        var ischked = $(this).is(":checked");
        $.post(HTTP_ROOT + 'milestones/ajax_check_parent', {
            idstr: btoa(id[1])
        }, function(res) {
            $('input[id^="actChkBklog"]').each(function(i) {
                if ($(this).is(":checked")) {
                    if ($.inArray($(this).closest('tbody').attr('id'), actvmileIds) == -1) {
                        actvmileIds.push($(this).closest('tbody').attr('id'));
                    }
                    is_bktskchk = is_bktskchk + 1;
                }
            });
            if (is_bktskchk < $('#caseViewSpan').find('table').find('td input.chkbcklgbx').length) {
                $("#chkAllbacklogTsk").prop('checked', false);
            }
            if (parseInt(actvmileIds.length) == parseInt(actvMilCnt)) {
                $('.mass_act_sprint').addClass('disabel_spnt');
            } else {
                $('.mass_act_sprint').removeClass('disabel_spnt');
            }
            if (typeof res.parentTsk != 'undefined') {
                if ($('#actChkBklog' + res.parentTsk).is(":checked")) {
                    $('#actChkBklog' + id[1]).prop('checked', true);
                    var idvalp = $('#actChkBklog' + res.parentTsk).val().split('|');
                    showTopErrSucc('error', _('Parent task can not be moved without subtask. Task #') + idval[1] + ' ' + _('is a subtask of parent #') + ' ' + idvalp[1]);
                }
            }
            if (res.data) {
                $.each(res.data, function(key, val) {
                    if (ischked) {
                        $('#actChkBklog' + val).prop('checked', true);
                    } else {
                        $('#actChkBklog' + val).prop('checked', false);
                    }
                });
            }
            if (ischked) {
                if (res.data.length >= 1) {
                    var ext_v = $('#multi-move-sprnt').val();
                    if (ext_v != '') {
                        $('#multi-move-sprnt').val(ext_v + ',' + id[1]);
                    } else {
                        $('#multi-move-sprnt').val(id[1]);
                    }
                }
                $('.mass_act_sprint').css('visibility', 'visible');
            } else {
                if (res.data.length >= 1) {
                    var ext_v = $('#multi-move-sprnt').val();
                    ext_v = ext_v.split(',');
                    var ext_t = '';
                    $.each(ext_v, function(key, data) {
                        if (data != id[1]) {
                            ext_t = (ext_t == '') ? data : ',' + data;
                        }
                    });
                    $('#multi-move-sprnt').val(ext_t);
                }
                $('input[id^="actChkBklog"]').each(function(i) {
                    if ($(this).is(":checked")) {
                        is_bktskchk = 1;
                    }
                });
                if (is_bktskchk) {
                    $('.mass_act_sprint').css('visibility', 'visible');
                } else {
                    $('#multi-move-sprnt').val('');
                    $('.mass_act_sprint').css('visibility', 'hidden');
                }
            }
        }, 'json');
    });
    if (typeof $.contextMenu != 'undefined') {
        $.contextMenu({
            selector: '.ttl_listing',
            callback: function(key, options) {
                if (key == 'view') {
                    task_id = options.$trigger.attr('data-task-id');
                    open(HTTP_ROOT + 'dashboard#/details/' + task_id, '_blank');
                }
            },
            items: {
                "view": {
                    name: "Open task in new tab"
                }
            }
        });
    }
    $(document).on("mousedown", "a.ttl_listing", function(e) {
        if (e.which == 2) {
            e.preventDefault();
            if ($.trim($(this).attr('data-task-id')) != '') {
                open(HTTP_ROOT + 'dashboard#/details/' + $(this).attr('data-task-id'), '_blank');
            }
        }
    });
    $(document).on('keyup', '#assignee_search', function() {
        var srch_txt = trim($(this).val());
        if (trim(srch_txt) != '') {
            $('.memHover').each(function() {
                if (trim($(this).find('a').text().toLowerCase()) != 'nobody' && trim($(this).find('a').text().toLowerCase()).indexOf(srch_txt.toLowerCase()) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        } else {
            $('.memHover').each(function() {
                $(this).show();
            });
        }
    });
});
$(document).on('click', '.displayParentBackButton', function() {
    var getUidVal = $("#hidden_parent_case_uid").val();
    easycase.ajaxCaseDetails(getUidVal, 'case', 0, 'popup');
});
$(document).on('click', '.task_action_bar .next', function() {
    if (!$(this).hasClass('disable')) {
        easycase.rollNext(this);
    }
});
$(document).on('click', '.task_action_bar .prev', function() {
    if (!$(this).hasClass('disable')) {
        easycase.rollPrev(this);
    }
});
$(document).on('click', '[id^="showhtml"]', function() {
    var task_data = $(this).attr('data-task').split('|');
    var csAtId = task_data[0];
    easycase.loadTinyMce(csAtId);
    tinymce.activeEditor.setContent('');
    $('#showhtml' + csAtId).hide();
    $('#cmt_sec_dis').show();
});
$(document).on('click', '.pri_actions b', function(e) {
    $('div[id^="more_opt20"]').find('ul').hide();
});
$(document).on('click', '.typ_actions b', function(e) {
    $('div[id^="more_opt20"]').find('ul').hide();
});
$(document).on('click', '.pop_arrow_new', function(e) {
    $(this).closest('.task_dependent_block').find('.showDependents').removeClass('open');
    $(this).closest('.task_parent_block').find('.showParents').removeClass('open');
});
$(document).on('click', 'body', function(e) {
    $(e.target).closest('.more_opt').size() > 0 || $(e.target).hasClass('ttfont') ? '' : $('div[id^="more_opt17"]').find('ul').hide();
    $(e.target).closest('.more_opt').size() > 0 || $(e.target).hasClass('ttfont') ? '' : $('div[id^="more_opt19"]').find('ul').hide();
    $(e.target).closest('.more_opt').size() > 0 || $(e.target).hasClass('ttfont') ? '' : $('div[id^="more_opt80"]').find('ul').hide();
    $(e.target).closest('.new_more_opt').size() > 0 || $(e.target).hasClass('wip') || $(e.target).hasClass('resolved') || $(e.target).hasClass('new') ? '' : $('div[id^="more_opt20"]').find('ul').hide();
    if (!$(e.target).hasClass('pop_arrow_new')) {
        $('.task_dependent_block').find('.showDependents').removeClass('open');
        $('.task_parent_block').find('.showParents').removeClass('open');
        $(e.target).closest('.task_dependent_block').length > 0 ? $(e.target).closest('.task_dependent_block').find('.showDependents').addClass('open') : '';
        $(e.target).closest('.task_parent_block').length > 0 ? $(e.target).closest('.task_parent_block').find('.showParents').addClass('open') : '';
    }
});
$(".nohit").on("mousedue", function() {
    $("#tskprgrs").removeClass("tsk_prgrss");
    $("#tskprgrs").addClass("tsk_hover");
}).on("mouseout", function() {
    $("#tskprgrs").addClass("tsk_prgrss");
    $("#tskprgrs").removeClass("tsk_hover");
});
$(".asignto").on("mouseover", function() {
    $(".assgn").css("border-bottom", "2px dashed #ccc");
}).on("mouseout", function() {
    $(".assgn").css("border-bottom", "0px");
});
$(".assgn_hover").on("mouseover", function() {
    $(".assgn").css("border-bottom", "2px dashed #ccc");
}).on("mouseout", function() {
    $(".assgn").css("border-bottom", "0px");
});
$(".due-date").on("mouseover", function() {
    $(".duedrp").css("border-bottom", "2px dashed #ccc");
    $(".no_due").css("border-bottom", "2px dashed #ccc");
}).on("mouseout", function() {
    $(".duedrp").css("border-bottom", "0px");
    $(".no_due").css("border-bottom", "0px");
});
$(document).on('click', '[id^="mor_toggle"]', function() {
    var csAtId = $(this).attr('data-csatid');
    $('#mor_toggle' + csAtId).hide()
    $('#less_toggle' + csAtId).show();
    $('#tskmore_' + csAtId).slideDown(350);
});
$(document).on('click', '[id^="less_toggle"]', function() {
    var csAtId = $(this).attr('data-csatid');
    $('#mor_toggle' + csAtId).show()
    $('#less_toggle' + csAtId).hide();
    $('#tskmore_' + csAtId).slideUp(350);
});
$(document).on('click', '.task_detail .ftsk_more', function() {
    if ($(this).parents('.task_due_dt').find('.tsk_files_more').css('display') == 'none') {
        $(this).parents('.task_due_dt').find('.tsk_files_more').css('display', 'block');
        $(this).children('.more_in_menu').html(_('Less'));
        $(this).addClass("open");
    } else {
        $(this).parents('.task_due_dt').find('.tsk_files_more').css('display', 'none');
        $(this).children('.more_in_menu').html(_('More'));
        $(this).removeClass('open');
    }
});
$(document).on('click', '[id^="tsk_attac_icon"]', function() {
    var csAtId = $(this).attr('data-csatid');
    $("#tsk_attach" + csAtId).trigger('click');
});
$(document).on('click', '.link_repto_task,.link_repto_task_dtl', function() {
    var csAtId = $(this).attr('data-csatid');
    scrollPageTop($('#reply_box' + csAtId));
    setSessionStorage('Task Details Page', 'Reply Task');
    tinymce.get('txa_comments' + csAtId).focus();
});
function getLoaderChk(type) {
    if (type == '1') {
        $('#caseViewSpan').html('<div class="loader_bg" id="caseLoaderNew" style="display:block;"><div class="loadingdata"><img src="/images/rolling.gif" alt="loading..." title="loading..."/></div></div>');
    } else {}
}

function ajaxCaseView(page) {
    var hashtag = parseUrlHash(urlHash);
    if (getCookie('FIRST_USER_LOGIN')) {
        createCookie('FIRST_USER_LOGIN', '', -1, DOMAIN_COOKIE);
        if (SES_TYPE == '3') {
            $('#assigntome_id').addClass('active-list');
            window.location.replace(HTTP_ROOT + "dashboard#/tasks/assigntome");
            location.reload();
            return false;
        }
    }
    $('#startTourBtn').show();
    if (LANG_PREFIX == '_fra') {
        GBl_tour = tour_fra;
    } else if (LANG_PREFIX == '_por') {
        GBl_tour = tour_por;
    } else if (LANG_PREFIX == '_spa') {
        GBl_tour = tour_spa;
    } else if (LANG_PREFIX == '_deu') {
        GBl_tour = tour_deu;
    } else {
        GBl_tour = tour;
    }
    if ($('.dropdown_menu_all_filters_ul').is(':visible')) {
        $('.dropdown_menu_all_filters_ul').hide();
    }
    $('.dropdown_menu_all_filters_ul').find('ul').hide();
    var strURL = HTTP_ROOT;
    var isUrl = 0;
    isUrl = getURLParameter('project');
    if (isUrl != "0" && isUrl) {
        parent.location.hash = "cases";
    }
    strURL = strURL + "easycases/";
    var projFil = $('#projFil').val();
    var cko = getCookie('TASKGROUPBY');
    if (projFil == 'all' && DEFAULT_TASKVIEW == 'task_group' && cko == 'milestone') {
        remember_filters('TASKGROUPBY', '');
        checkHashLoad('tasks');
        return false;
    }
    var caseId = $('#caseId').val();
    var startCaseId = $('#caseStart').val();
    var caseResolve = $('#caseResolve').val();
    var caseNew = $('#caseNew').val();
    var caseChangeType = $('#caseChangeType').val();
    var caseChangePriority = $('#caseChangePriority').val();
    var caseChangeDuedate = $('#caseChangeDuedate').val();
    var caseChangeAssignto = $('#caseChangeAssignto').val();
    var customfilter = $('#customFIlterId').val();
    if (caseId || startCaseId || caseResolve || caseNew) {}
    $(".side-nav li").removeClass('active');
    $(".menu-cases").addClass('active');
    if (!(localStorage.getItem("theme_setting") === null)) {
        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
        $(".side-nav li").each(function() {
            $(this).removeClass(th_class_str);
        });
        $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
    }
    if ($('#lviewtype').val() == 'compact') {
        $('#select_view div').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#cview_btn').addClass('disable');
    } else {
        $('#select_view div').removeClass('disable');
        $('#lview_btn').addClass('disable');
    }
    $('#caseViewSpanUnclick').show();
    $('#caseLoader').show();
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseTaskGroup = $('#caseTaskgroup').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseDate = $('#caseDate').val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var taskgroup_fil = '';
    var hashtag = parseUrlHash(urlHash);
    var caseSearch = $("#case_search").val();
    if ((caseSearch != null) && (caseSearch.trim() == '')) {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    $("#case_search").val("");
    clearSearchvis();
    var caseTitle = $('#caseTitle').val();
    var caseDueDate = $('#caseDueDate').val();
    var caseEstHours = $('#caseEstHours').val();
    var caseNum = $('#caseNum').val();
    var caseLegendsort = $('#caseLegendsort').val();
    var caseAtsort = $('#caseAtsort').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    var caseCreateDate = $('#caseCreatedDate').val();
    var projIsChange = $('#projIsChange').val();
    var act_smenu_text_color = '';
    var caseCustomField = '';
    if (localStorage.getItem("CUSTOM_FIELD")) {
        caseCustomField = localStorage.getItem("CUSTOM_FIELD");
    } else {
        caseCustomField = "all";
    }
    /*if (!(localStorage.getItem("theme_setting") === null)) {
        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
        act_smenu_text_color = theme_setting.selSubmenu(th_set_obj.sidebar_color);
    }*/
    if (caseMenuFilters != 'milestone' && caseMenuFilters != 'files') {
        if (caseMenuFilters === "") {
            caseMenuFilters = "cases";
        }
        $('.cattab').removeClass('active-list');
        $('.cattab > a').removeClass(th_text_class_str);
        if (localStorage['SELECTTAB'] == "links") {
            $('#' + caseMenuFilters + '_id').addClass('active-list');
            $("#filterSearch_id").find('a').removeClass('sel-filter');
            //$('#' + caseMenuFilters + '_id > a').addClass(act_smenu_text_color);
        } else {
            $("#filterSearch_id").addClass('active-list');
            $("#filterSearch_id").find('a').addClass('sel-filter');
        }
        var ck_page = getCookie('TASKGROUPBY');
        if (ck_page == 'milestone' && page != 'taskgroup') {
            if (localStorage['SELECTTAB'] == "links") {
                $('#' + caseMenuFilters + '_id').addClass('active-list');
                $("#filterSearch_id").find('a').removeClass('sel-filter');
                //$('#' + caseMenuFilters + '_id > a').addClass(act_smenu_text_color);
            } else {
                $("#filterSearch_id").addClass('active-list');
                $("#filterSearch_id").find('a').addClass('sel-filter');
            }
        }
    } else {}
    if (caseMenuFilters == 'milestone') {} else {}
    var caseUrl = "";
    var detailscount = 0;
    var reply = 0;
    if (projIsChange != projFil) {}
    if (caseMenuFilters == 'milestone') {
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
    }
    var limit1, limit2;
    var menu_filter = caseMenuFilters;
    var hashtag = parseUrlHash(urlHash);
    var strAction = ((page == 'taskgroup' || hashtag[0] == 'taskgroup') && page != 'tasks') ? 'case_taskgroup' : 'case_project';
    if (((page == 'taskgroups' || hashtag[0] == 'taskgroups') && page != 'tasks')) {
        strAction = "loadTaskGroup";
        var displayedTaskGroups = $("#displayedTaskGroups").val();
        var types = typeof arguments[1] != "undefined" ? arguments[1] : "";
        if (types == "more") {
            limit1 = displayedTaskGroups;
            limit2 = 20;
        } else {
            limit1 = 0;
            limit2 = 20;
        }
    }
    if ((page == 'subtask' || hashtag[0] == 'subtask') && page != 'tasks') {
        strAction = 'case_subtask';
    }
    if (page == 'taskgroup')
        window.location.hash = 'taskgroup';
    else if (page == 'tasks') {
        window.location.href = HTTP_ROOT + 'dashboard#/tasks';
    } else if (page == 'taskgroups') {
        window.location.href = HTTP_ROOT + 'dashboard#/taskgroups';
    }
    var searchMilestoneUid = '';
    if (strAction == 'case_taskgroup') {
        if (typeof hashtag[1] != 'undefined') {
            searchMilestoneUid = hashtag[1];
        }
    }
    if (strAction == 'case_project' || strAction == 'case_subtask' || strAction == 'loadTaskGroup') {
        strURL = HTTP_ROOT + 'requests/';
    }
    if (strAction == 'case_project') {
        var task_grp_by = localStorage.getItem("AJAX_TASK_GROUPBY");
    }
    if (strAction == 'loadTaskGroup') {
        showTaskByTaskGroupNew();
        return false;
    }
    $.post(strURL + strAction, {
        projFil: projFil,
        caseStatus: caseStatus,
        caseCustomStatus: caseCustomStatus,
        customfilter: customfilter,
        caseChangeAssignto: caseChangeAssignto,
        caseChangeDuedate: caseChangeDuedate,
        caseChangePriority: caseChangePriority,
        caseChangeType: caseChangeType,
        mstype: mstype,
        priFil: priFil,
        caseTypes: caseTypes,
        caseLabel: caseLabel,
        caseMember: caseMember,
        caseComment: caseComment,
        caseTaskGroup: caseTaskGroup,
        caseAssignTo: caseAssignTo,
        caseDate: caseDate,
        caseSearch: caseSearch,
        casePage: casePage,
        caseId: caseId,
        caseTitle: caseTitle,
        caseDueDate: caseDueDate,
        caseEstHours: caseEstHours,
        caseNum: caseNum,
        caseLegendsort: caseLegendsort,
        caseAtsort: caseAtsort,
        startCaseId: startCaseId,
        caseResolve: caseResolve,
        caseNew: caseNew,
        caseMenuFilters: caseMenuFilters,
        caseUrl: caseUrl,
        detailscount: detailscount,
        milestoneIds: milestoneIds,
        case_srch: case_srch,
        case_date: case_date,
        'case_due_date': case_due_date,
        caseCreateDate: caseCreateDate,
        projIsChange: projIsChange,
        searchMilestoneUid: searchMilestoneUid,
        caseCustomField: caseCustomField,
        'casegroupby': (task_grp_by) ? task_grp_by : "",
        caseNew: caseNew,
        limit1: limit1,
        limit2: limit2
    }, function(res) {
        if (res) {
            if (client && typeof res.iotoserver != 'undefined') {
                client.emit('iotoserver', res.iotoserver);
            }
            $('#caseLoader').hide();
            refreshTasks = 0;
            if (res.projUser) {
                PUSERS = res.projUser;
                for (pi in PROJECTS) {
                    if (PROJECTS[pi].Project.uniq_id == res.projUniq) {
                        defaultAssign = PROJECTS[pi].Project.default_assign;
                    }
                }
            }
            if ($('#customFIlterId').val()) {
                refreshTasks = 1;
            }
            $("#caseChangeAssignto").val('');
            $("#caseChangeDuedate").val('');
            $("#caseChangePriority").val('');
            $("#caseChangeType").val('');
            var projFil = $('#projFil').val();
            var projIsChange = $('#projIsChange').val();
            var caseMenuFilters = $('#caseMenuFilters').val();
            if (projFil == 'all') {
                if (SES_COMP == '25814' || SES_COMP == '28528') {
                    $("#dropdown_menu_comments").parent('li').show();
                } else {
                    $("#dropdown_menu_comments").parent('li').hide();
                }
                remember_filters('ALL_PROJECT', 'all');
            } else {
                remember_filters('ALL_PROJECT', '');
            }
            if ((page == 'taskgroup' || hashtag[0] == 'taskgroup') && page != 'tasks') {
                $("#caseViewSpan").html(tmpl("case_taskgroups_tmpl", res));
                $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE065;</i> ' + _('Task Group') + '</a>');
                showHideTopNav(1);
                if (typeof getCookie('PREOPENED_TASK_GROUP_ID') != 'undefined') {
                    tid = getCookie('PREOPENED_TASK_GROUP_ID');
                    $("#empty_milestone_tr" + tid).find('.os_sprite').trigger('click');
                }
            } else if ((page == 'taskgroups' || hashtag[0] == 'taskgroups') && page != 'tasks') {
                if (types == "more") {
                    $(".subtsk_list_tbl tbody:last").after(tmpl("case_taskgrouplst_load_tmpl", res));
                    var displayedTaskGroups = $("#displayedTaskGroups").val();
                    var newdisplayedTaskGroups = (parseInt(displayedTaskGroups)) + 20;
                    $("#displayedTaskGroups").val(newdisplayedTaskGroups);
                } else {
                    $("#displayedTaskGroups").val(20);
                    $("#caseViewSpan").html(tmpl("case_taskgrouplst_tmpl", res));
                    $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE065;</i> ' + _('Subtask View') + '</a>');
                    showHideTopNav(1);
                    $('#task_paginate').html('');
                    var ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS_THREAD') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS_THREAD')) : [];
                    remember_filters('SUBTASKVIEW', 'subtaskview');
                    resetAllFilters('all', 1);
                    $.each(ids_array, function(key, val) {});
                }
            } else if ((page == 'subtask' || hashtag[0] == 'subtask') && page != 'tasks') {
                $("#caseViewSpan").html(tmpl("case_subtasks_tmpl", res));
            } else {
                $("#caseViewSpan").html(tmpl("case_project_tmpl", res));
                if (strAction == 'case_project') {
                    TaskGroupByItem();
                }
                $('.hideSub').closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').hide();
                var groupby = getCookie('TASKGROUPBY');
                if (groupby == 'milestone') {
                    $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE065;</i> ' + _('Subtask View') + '</a>');
                } else {
                    $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE8EF;</i> ' + _('Task List') + '</a>');
                }
                showHideTopNav(1);
            }
            $('.tooltip_link').hover(function(e) {
                var scrollTop = $(window).scrollTop();
                var topOffset = $(this).parent().offset().top;
                var relativeOffset = topOffset - scrollTop;
                var windowHeight = $(window).height();
                if (relativeOffset > windowHeight / 2) {
                    $(this).next('.hover_item').addClass("reverse");
                } else {
                    $(this).next('.hover_item').removeClass("reverse");
                }
            }, function(e) {});
            $('.addn_menu_drop_pos').each(function() {
                if ($(this).find('li').length <= 9) {
                    $(this).css({
                        "top": "inherit",
                        "bottom": 0
                    });
                }
            });
            expandLeftSubmenu();
            clearSearchvis();
            $.material.init();
            setTimeout(function() {
                loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                    "projUniq": projFil,
                    "pageload": 0,
                    "page": "dashboard",
                    "filters": caseMenuFilters,
                    'case_date': case_date,
                    'case_due_date': case_due_date,
                    'caseStatus': caseStatus,
                    'caseCustomStatus': caseCustomStatus,
                    'caseTypes': caseTypes,
                    'caseLabel': caseLabel,
                    'priFil': priFil,
                    'caseMember': caseMember,
                    'caseComment': caseComment,
                    'caseAssignTo': caseAssignTo,
                    'caseSearch': caseSearch,
                    'milestoneIds': milestoneIds,
                    'checktype': checktype
                });
            }, 300);
            notShowEmptyDropdown();
            if ($.trim($('#inner-search').val()) != '') {
                $('#inner-search').addClass('open').css('width', '200px');
            }
            $('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').on('mouseenter', function() {
                $(this).attr('aria-expanded', true);
                $(this).parent().addClass('open');
            });
            $('.row_tr').on('mouseleave', function() {
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', false);
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().removeClass('open');
            });
            $('.task_group_accd .plus-minus-accordian span.dropdown').on('mouseenter', function() {
                $(this).find('a.main_page_menu_togl').attr('aria-expanded', true);
                $(this).addClass('open');
            });
            $('.task_group_accd').on('mouseleave', function() {
                $(this).find('.plus-minus-accordian span.dropdown .dropdown-toggle').attr('aria-expanded', false);
                $(this).find('.plus-minus-accordian span.dropdown').removeClass('open');
            });
            $('#caseViewSpan').show();
            $('#caseViewDetails').hide();
            clearSearchvis();
            if ($('#lviewtype').val() == 'compact') {
                $('.tsk_tbl').addClass('compactview_tbl');
                $('#topaction').addClass('compactview_action');
            } else {
                $('.tsk_tbl').removeClass('compactview_tbl');
                $('#topaction').removeClass('compactview_action');
            }
            var params = parseUrlHash(urlHash);
            if (hashtag[0] != "tasks" && hashtag[0] != "taskgroup" && hashtag[0] != 'subtask' && hashtag[0] != 'taskgroups') {
                parent.location.hash = "tasks";
            }
            if (page == 'details') {
                easycase.ajaxCaseDetails(params[1], 'case', 0);
            } else if (page == 'subtask') {
                easycase.routerHideShow('subtask');
            } else {
                easycase.routerHideShow('tasks');
                if (ioMsgClicked == 1) {
                    ioMsgClicked = 0;
                }
                $('#detail_section').html('');
            }
            var tmdet = getCookie('timerDtls');
            var tm = getCookie('timer');
            if (typeof tmdet != 'undefined' && tmdet != '' && typeof tm != 'undefined' && tm != '') {
                var tmCsDet = tmdet.split('|');
                var taskautoid = tmCsDet[0];
                if ($('.showtime_' + taskautoid).length) {
                    $('.showtime_' + taskautoid).css('display', 'block');
                }
            }
            $("div [id^='set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    startDate: new Date(),
                    todayHighlight: true,
                    format: 'mm/dd/yyyy',
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    var caseId = $(this).attr('data-csatid');
                    var datelod = "datelod" + caseId;
                    var showUpdDueDate = "showUpdDueDate" + caseId;
                    var old_duetxt = $("#" + showUpdDueDate).html();
                    $("#" + showUpdDueDate).html("");
                    $("#" + datelod).show();
                    var text = '';
                    var vobj = $(this);
                    var dateText = $(this).datepicker('getFormattedDate');
                    $(this).val('');
                    commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj);
                });
            });
            $('#quick-assign').select2();
            $('#qt_task_type').select2({
                templateSelection: formatTaskType,
                templateResult: formatTaskType,
            }).on('change', function(evt) {
                if ($(this).find('option:selected').text() == 'Story') {
                    $('#qt_story_point_container').show();
                } else {
                    $('#qt_story_point_container').hide();
                }
            });
            $('.due_dt_tlist').off().on('click', function(e) {
                e.stopPropagation();
                var targt = $(e.target).attr('id');
                if ($(this).find('span.check-drop-icon > span.dropdown').hasClass('open')) {
                    if (typeof targt == 'undefined' || targt.indexOf("set_due_date_") === -1) {
                        $(this).find('span.check-drop-icon > span.dropdown').removeClass('open');
                    }
                } else {
                    if ($(this).find('span.check-drop-icon > span.dropdown > a').attr('data-toggle').trim() != '') {
                        $(this).find('span.check-drop-icon > span.dropdown').addClass('open');
                    }
                }
            });
            $('.assi_tlist').off().on('click', function(e) {
                e.stopPropagation();
                if ($(this).find('span.check-drop-icon > span.dropdown').hasClass('open')) {
                    $(this).find('span.check-drop-icon > span.dropdown').removeClass('open');
                } else {
                    if ($(this).find('span.check-drop-icon > span.dropdown > a').attr('data-toggle').trim() != '') {
                        $(this).find('span.check-drop-icon > span.dropdown').addClass('open');
                    }
                }
            });
            $('input[id^="est_hrlist"]').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var id = $(this).attr('data-est-id');
                    var uid = $(this).attr('data-est-uniq');
                    var cno = $(this).attr('data-est-no');
                    var tim = $(this).attr('data-est-time');
                    changeEstHourTaskListPage(id, uid, cno, tim);
                }
            });
            localStorage.setItem("ckl_chk", 0);
            $('input[id^="est_hrlist"]').on('blur', function(e) {
                var d_val = $(this).attr('data-default-val');
                var d_val_orig = $(this).val();
                if (localStorage.getItem("ckl_chk") == '0') {
                    if (d_val == d_val_orig) {
                        $(this).closest('.estblist').size() > 0 ? '' : $('.estblist').show();
                        $('.est_hrlist').hide();
                    }
                }
            });
            if (getCookie("TASKGROUPBY") != "" || page == 'taskgroup') {
                var ignoreTr = '.white_bg_tr,.quicktskgrp_tr,.quicktskgrp_tr,.quicktskgrp_tr_lnk,thead > tr';
                $('.sortby_btn').prop('disabled', true);
                $('.sortby_btn').addClass('disable-btn');
                $(".compactview_tbl").sortable({
                    opacity: 0.6,
                    cursor: 'grabbing',
                    items: 'tbody',
                    connectWith: '.compactview_tbl',
                    handle: '.dot-bar-group',
                    containment: '.compactview_tbl',
                    cancel: "tbody.no_shortable",
                    update: function(ev, ui) {
                        delete_cookie('TASKSORTBY2');
                        var mileIds = new Array();
                        $('.compactview_tbl').find("tr[id^='empty_milestone_tr']").each(function() {
                            mileIds.push($(this).attr('id').replace("empty_milestone_tr", ""));
                        });
                        var project_id = ui.item.find("tr[id^='empty_milestone_tr']").attr('data-pid');
                        var url = HTTP_ROOT + "milestones/update_sequence_milestones";
                        $.post(url, {
                            "mileIds": mileIds,
                            'project_id': project_id,
                            'casePage': casePage
                        }, function(res1) {
                            if (res1) {
                                showTopErrSucc('success', _('Task group reorder successfully.'));
                                easycase.refreshTaskList();
                            }
                        });
                    }
                });
                var mid = '';
                var sortflag = false;
                $(".compactview_tbl > tbody").sortable({
                    opacity: 0.6,
                    cursor: 'grabbing',
                    items: "tr.tgrp_tr_all",
                    handle: ".dot-bar",
                    containment: '.compactview_tbl',
                    connectWith: 'tbody',
                    scroll: false,
                    start: function(event, ui) {
                        if (typeof $(ui.helper).attr('id') == 'undefined') {
                            return false;
                        }
                        mid = $(ui.item[0]).closest('tbody').find("tr[id^='empty_milestone_tr']").attr('id');
                        sortflag = true;
                    },
                    sort: function(event, ui) {
                        var pos = parseInt($(window).height() - event.clientY);
                        if (pos < parseInt($(window).height() * .1)) {
                            $(window).scrollTop($(window).scrollTop() + 30);
                        } else if (event.clientY < 150) {
                            $(window).scrollTop($(window).scrollTop() - 30);
                        }
                    },
                    stop: function(event, ui) {
                        var tr_id = ui.item[0].id;
                        var id = $('#' + tr_id).prev('tr').not(ignoreTr).attr("id");
                        if (typeof id == 'undefined') {
                            return false;
                        }
                    },
                    update: function(ev, ui) {
                        delete_cookie('TASKSORTBY');
                        var tr_id = ui.item[0].id;
                        var indx_tr = $(".compactview_tbl tr").not(ignoreTr).index($('#' + tr_id));
                        if (tr_id.indexOf('_') > 0) {
                            return false;
                        }
                        if (sortflag === true) {
                            sortflag = false;
                        } else {}
                        if (mid != $(ui.item[0]).closest('tbody').find("tr[id^='empty_milestone_tr']").attr('id')) {}
                        var drped_idx = $(".compactview_tbl tr").not(ignoreTr).index(ui.item[0]);
                        var p_id = 0;
                        var n_id = 0;
                        var p_idx_id = drped_idx + 1;
                        var n_idx_id = drped_idx + 2;
                        $(".compactview_tbl").find('tr').not(ignoreTr).each(function(index) {
                            if (p_idx_id == index) {
                                p_id = $(this).attr('id');
                            }
                            if (n_idx_id == index) {
                                n_id = $(this).attr('id');
                            }
                        });
                        var p_mlstn_id = $('#' + tr_id).attr('data-mid');
                        var n_mlstn_id = $('#' + n_id).attr('data-mid');
                        var indx_m = $(".compactview_tbl tr").not(ignoreTr).index($('#empty_milestone_tr' + n_mlstn_id));
                        var caseIds = new Array();
                        $(ui.item[0]).closest('tbody').find("tr[id^='curRow']").each(function() {
                            caseIds.push($(this).attr('id').substr(6));
                        });
                        var p_mlstn_id = $(ui.item[0]).parents('tbody').find("tr[id^='empty_milestone_tr']").attr('id').replace("empty_milestone_tr", "");
                        n_mlstn_id = p_mlstn_id;
                        var project_id = $(ui.item[0]).attr('data-pid');
                        if (typeof n_id == 'undefined' && typeof p_id == 'undefined') {
                            return false;
                        } else {
                            if (p_mlstn_id !== n_mlstn_id) {
                                if (p_mlstn_id == 'NA') {
                                    var caseid = Array();
                                    caseid.push(tr_id.split('w')[1]);
                                    $.post(HTTP_ROOT + 'milestones/assign_case', {
                                        "caseid": caseid,
                                        "project_id": project_id,
                                        "milestone_id": n_mlstn_id,
                                        "caseIds": caseIds
                                    }, function(data) {
                                        if (data == "success") {
                                            showTopErrSucc('success', _('Task moved successfully.'));
                                        } else {
                                            showTopErrSucc('error', _('Error in moving task to task group'));
                                        }
                                        update_sequence(caseIds, n_mlstn_id, project_id);
                                    });
                                } else if (n_mlstn_id == 'NA') {
                                    $.post(HTTP_ROOT + "milestones/removeTaskMilestone", {
                                        'taskid': tr_id.split('w')[1],
                                        'project_id': project_id,
                                        'mlstid': p_mlstn_id
                                    }, function(res2) {
                                        if (res2) {
                                            showTopErrSucc('success', _('Task moved successfully.'));
                                        } else {
                                            showTopErrSucc('error', _('Error in moving task to task group'));
                                        }
                                    });
                                } else {
                                    switchTaskToMilestoneAction('ajaxCaseView', {
                                        'taskid': tr_id.split('w')[1],
                                        'curr_mlst_id': n_mlstn_id,
                                        'project_id': project_id,
                                        'ext_mlst_id': p_mlstn_id,
                                        'caseIds': caseIds
                                    });
                                }
                            } else {
                                update_sequence(caseIds, n_mlstn_id, project_id);
                            }
                        }
                    }
                });
            } else {
                $('.sortby_btn').removeAttr('disabled');
                $('.sortby_btn').removeClass('disable-btn');
            }
            var caseId = $('#caseId').val();
            var startCaseId = $('#caseStart').val();
            var caseResolve = $('#caseResolve').val();
            var caseNew = $('#caseNew').val();
            if (res.errormsg) {
                showTopErrSucc('error', res.errormsg);
            } else if (caseId) {
                $('#caseId').val('');
                var chk = caseId.indexOf(",");
                if (chk != -1) {
                    showTopErrSucc('success', _('Tasks are closed.'));
                } else {
                    showTopErrSucc('success', _('Task is closed.'));
                }
                casePage = 1;
            } else if (startCaseId) {
                $('#caseStart').val('');
                var chk = startCaseId.indexOf(",");
                if (chk != -1) {
                    showTopErrSucc('success', _('Tasks are started.'));
                } else {
                    showTopErrSucc('success', _('Task is started.'));
                }
                casePage = 1;
            } else if (caseResolve) {
                $('#caseResolve').val('');
                var chk = caseResolve.indexOf(",");
                if (chk != -1) {
                    showTopErrSucc('success', _('Tasks are resolved.'));
                } else {
                    showTopErrSucc('success', _('Task is resolved.'));
                }
                casePage = 1;
            } else if (caseNew) {
                $('#caseNew').val('');
                var chk = caseNew.indexOf(",");
                if (chk != -1) {
                    showTopErrSucc('success', _('Status of tasks are changed to new.'));
                } else {
                    showTopErrSucc('success', _('Task status is changed to new.'));
                }
                casePage = 1;
            }
            var usrUrl = HTTP_ROOT + "users/";
            var url = HTTP_ROOT + "easycases/";
            var filter = $('#caseMenuFilters').val();
            var projFil = $('#projFil').val();
            var projIsChange = $('#projIsChange').val();
            $('#projIsChange').val(projFil);
            var caseId = $('#caseId').val();
            var startCaseId = $('#caseStart').val();
            var caseResolve = $('#caseResolve').val();
            var caseNew = $('#caseNew').val();
            var ischange = 0;
            if (caseMenuFilters && caseMenuFilters != "files") {
                ischange = 1;
            }
            $('#caseId').val();
            $('#caseResolve').val();
            $('#caseStart').val();
            var checktype = $("#checktype").val();
            var caseMenuFilters = $('#caseMenuFilters').val();
            setTimeout(function() {
                restcasestatus(projFil, caseMenuFilters, case_date, case_due_date, caseStatus, caseCustomStatus, caseTypes, priFil, caseMember, caseComment, caseAssignTo, caseSearch, milestoneIds, checktype, caseLabel);
            }, 100);
            var caseMenuFilters = $('#caseMenuFilters').val();
            var x = $("#getcasecount").val();
            $("#showcasecount").html(x);
            if (caseMenuFilters && caseMenuFilters == "milestone") {
                $("#mileStoneFilter").show();
            } else {
                $("#mileStoneFilter").hide();
            }
            if ((caseId || startCaseId || caseResolve || caseNew || caseChangeType || caseChangeDuedate || caseChangePriority || caseChangeAssignto) && ($('#email_arr').val() != '')) {
                $.post(strURL + "ajaxemail", {
                    'json_data': $('#email_arr').val(),
                    'type': 1
                });
            }
            if (localStorage.getItem("tour_open_chk") == '1') {
                localStorage.setItem("tour_open_chk", '0');
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_mngwork + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_mngwork;
                }
                hopscotch.startTour(GBl_tour);
            }
        }
        setTimeout(function() {
            if (caseId || startCaseId || caseResolve || caseNew) {
                resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 1, case_date, case_due_date, '', '', '', '', milestoneIds, caseLabel);
            }
            if (!caseId && !startCaseId && !caseResolve && !caseNew) {
                var clearCaseSearch = $('#clearCaseSearch').val();
                var isSort = $('#isSort').val();
                $('#clearCaseSearch').val('');
                resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 0, case_date, case_due_date, casePage, caseSearch, clearCaseSearch, caseMenuFilters, milestoneIds, caseLabel);
                downloadFile();
            }
        }, 100);
        if (projFil == 'all') {
            if (SES_COMP == '25814' || SES_COMP == '28528') {
                $("#dropdown_menu_comments").parent('li').show();
            } else {
                $("#dropdown_menu_comments").parent('li').hide();
            }
        } else {
            $("#dropdown_menu_comments").parent('li').show();
        }
        changeCBStatus();
        if (localStorage.getItem('url_type') == 'details' && localStorage.getItem('url_uniq') != '') {
            easycase.ajaxCaseDetails(localStorage.getItem('url_uniq'), 'case', 0, 'popup');
            $('.task_details_modal').addClass('in');
            $('.task_details_modal').css("display", "block");
            $('.task_details_modal').css("padding-right", "8px");
            $('.task_details_popup').css("display", "block");
        }
    });
}

function ajaxTaskGroupBy(obj) {
    var type = $(obj).attr("data-type");
    remember_filters('AJAX_TASK_GROUPBY', type);
    ajaxCaseView('case_project');
}

function TaskGroupByItem() {
    var task_group_by = localStorage.getItem('AJAX_TASK_GROUPBY');
    var str = '';
    if (task_group_by != '' && task_group_by != null) {
        if (task_group_by == 'Assign to') {
            var actLabel = 'Assign To';
            str += "<div class='fl filter_opn' rel='tooltip' title='Assign To'>" + actLabel + "<a href='javascript:void(0);' onclick='task_common_reset_group();' class='fr'>X</a></div>";
        } else if (task_group_by == 'Status') {
            var actLabel = 'Status';
            str += "<div class='fl filter_opn' rel='tooltip' title='Status'>" + actLabel + "<a href='javascript:void(0);' onclick='task_common_reset_group();' class='fr'>X</a></div>";
        } else if (task_group_by == 'Date') {
            var actLabel = 'Date';
            str += "<div class='fl filter_opn' rel='tooltip' title='Date'>" + actLabel + "<a href='javascript:void(0);' onclick='task_common_reset_group();' class='fr'>X</a></div>";
        } else if (task_group_by == 'Priority') {
            var actLabel = 'Priority';
            str += "<div class='fl filter_opn' rel='tooltip' title='Priority'>" + actLabel + "<a href='javascript:void(0);' onclick='task_common_reset_group();' class='fr'>X</a></div>";
        }
    }
    if (str != '') {
        $("#task_groupby_items_list").html(str);
        $("#task_groupby_items_list").show();
    } else {
        $("#task_groupby_items_list").html('');
        $("#task_groupby_items_list").hide();
    }
}
function pdfCaseView(page) {
    var strURL = HTTP_ROOT;
    var isUrl = 0;
    isUrl = getURLParameter('project');
    if (isUrl != "0" && isUrl) {
        parent.location.hash = "cases";
    }
    strURL = strURL + "easycases/";
    var projFil = $('#projFil').val();
    var cko = getCookie('TASKGROUPBY');
    var caseId = $('#caseId').val();
    var startCaseId = $('#caseStart').val();
    var caseResolve = $('#caseResolve').val();
    var caseNew = $('#caseNew').val();
    var caseChangeType = $('#caseChangeType').val();
    var caseChangePriority = $('#caseChangePriority').val();
    var caseChangeDuedate = $('#caseChangeDuedate').val();
    var caseChangeAssignto = $('#caseChangeAssignto').val();
    var customfilter = $('#customFIlterId').val();
    var caseStatus = $('#caseStatus').val();
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseTaskGroup = $('#caseTaskgroup').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseDate = $('#caseDate').val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var taskgroup_fil = '';
    var hashtag = parseUrlHash(urlHash);
    var caseSearch = $("#case_search").val();
    if (caseSearch.trim() == '') {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    $("#case_search").val("");
    var caseTitle = $('#caseTitle').val();
    var caseDueDate = $('#caseDueDate').val();
    var caseNum = $('#caseNum').val();
    var caseLegendsort = $('#caseLegendsort').val();
    var caseAtsort = $('#caseAtsort').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    var caseCreateDate = $('#caseCreatedDate').val();
    var projIsChange = $('#projIsChange').val();
    var caseUrl = "";
    var detailscount = 0;
    var reply = 0;
    if (caseMenuFilters == 'milestone') {
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
    }
    var menu_filter = caseMenuFilters;
    var hashtag = parseUrlHash(urlHash);
    var strAction = ((page == 'taskgroup' || hashtag[0] == 'taskgroup') && page != 'tasks') ? 'case_taskgroup' : 'case_project';
    if (page == 'taskgroup')
        window.location.hash = 'taskgroup';
    else if (page == 'tasks')
        window.location.hash = 'tasks';
    var searchMilestoneUid = '';
    if (strAction == 'case_taskgroup') {
        if (typeof hashtag[1] != 'undefined') {
            searchMilestoneUid = hashtag[1];
        }
    }
    if (strAction == 'case_project') {
        strURL = HTTP_ROOT + 'easycases/'
    }
    if (hashtag == 'taskgroups') {
        var pdfexporturl = strURL + "export_taskgroup_pdf_tasklist?projFil=" + projFil + "&caseStatus=" + caseStatus + "&customfilter=" + customfilter + "&caseChangeAssignto=" + caseChangeAssignto + "&caseChangeDuedate=" + caseChangeDuedate + "&caseChangePriority=" + caseChangePriority + "&caseChangeType=" + caseChangeType + "&mstype=" + mstype + "&priFil=" + priFil + "&caseTypes=" + caseTypes + "&caseLabel=" + caseLabel + "&caseMember=" + caseMember + "&caseComment=" + caseComment + "&caseAssignTo=" + caseAssignTo + "&caseDate=" + caseDate + "&caseSearch=" + caseSearch + "&casePage=" + casePage + "&caseId=" + caseId + "&caseTitle=" + caseTitle + "&caseDueDate=" + caseDueDate + "&caseNum=" + caseNum + "&caseLegendsort=" + caseLegendsort + "&caseAtsort=" + caseAtsort + "&startCaseId=" + startCaseId + "&caseResolve=" + caseResolve + "&caseNew=" + caseNew + "&caseMenuFilters=" + caseMenuFilters + "&caseUrl=" + caseUrl + "&detailscount=" + detailscount + "&milestoneIds=" + milestoneIds + "&case_srch=" + case_srch + "&case_date=" + case_date + "&case_due_date=" + case_due_date + "&caseCreateDate=" + caseCreateDate + "&projIsChange=" + projIsChange + "&searchMilestoneUid=" + searchMilestoneUid + "&caseNew=" + caseNew;
    } else {
        var pdfexporturl = strURL + "export_pdf_tasklist?projFil=" + projFil + "&caseStatus=" + caseStatus + "&customfilter=" + customfilter + "&caseChangeAssignto=" + caseChangeAssignto + "&caseChangeDuedate=" + caseChangeDuedate + "&caseChangePriority=" + caseChangePriority + "&caseChangeType=" + caseChangeType + "&mstype=" + mstype + "&priFil=" + priFil + "&caseTypes=" + caseTypes + "&caseLabel=" + caseLabel + "&caseMember=" + caseMember + "&caseComment=" + caseComment + "&caseTaskGroup=" + caseTaskGroup + "&caseAssignTo=" + caseAssignTo + "&caseDate=" + caseDate + "&caseSearch=" + caseSearch + "&casePage=" + casePage + "&caseId=" + caseId + "&caseTitle=" + caseTitle + "&caseDueDate=" + caseDueDate + "&caseNum=" + caseNum + "&caseLegendsort=" + caseLegendsort + "&caseAtsort=" + caseAtsort + "&startCaseId=" + startCaseId + "&caseResolve=" + caseResolve + "&caseNew=" + caseNew + "&caseMenuFilters=" + caseMenuFilters + "&caseUrl=" + caseUrl + "&detailscount=" + detailscount + "&milestoneIds=" + milestoneIds + "&case_srch=" + case_srch + "&case_date=" + case_date + "&case_due_date=" + case_due_date + "&caseCreateDate=" + caseCreateDate + "&projIsChange=" + projIsChange + "&searchMilestoneUid=" + searchMilestoneUid + "&caseNew=" + caseNew;
    }
    var win = window.open(pdfexporturl, '_blank');
    win.focus();
}

function task_common_reset_group() {
    localStorage.removeItem('AJAX_TASK_GROUPBY');
    ajaxCaseView('case_project');
    TaskGroupByItem();
}
var lastCall = 0;

function restcasestatus(projFil, caseMenuFilters, case_date, case_due_date, caseStatus, caseCustomStatus, caseTypes, priFil, caseMember, caseComment, caseAssignTo, caseSearch, milestoneIds, checktype, caseLabel) {
    $.post(HTTP_ROOT + "requests/ajax_case_status", {
        "projUniq": projFil,
        "pageload": 0,
        "caseMenuFilters": caseMenuFilters,
        'case_date': case_date,
        'case_due_date': case_due_date,
        'caseStatus': caseStatus,
        'caseCustomStatus': caseCustomStatus,
        'caseTypes': caseTypes,
        'caseLabel': caseLabel,
        'priFil': priFil,
        'caseMember': caseMember,
        'caseComment': caseComment,
        'caseAssignTo': caseAssignTo,
        'caseSearch': caseSearch,
        'milestoneIds': milestoneIds,
        'checktype': checktype
    }, function(data) {
        if (data) {
            $('#ajaxCaseStatus').html(data);
            $('#ajaxCaseStatus').html(tmpl("case_widget_tmpl", data));
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            $("#upperDiv_not").hide();
            var statusnot = $('#not_sts').html();
            var n = '';
            if (caseMenuFilters != 'milestone' && caseMenuFilters != 'closecase' && n == -1) {
                var closed = $("#closedcaseid").val();
                if (closed != 0) {
                    $("#upperDiv_not").show();
                    if (closed == 1) {
                        $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("task"));
                    } else {
                        $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("tasks"));
                    }
                } else {
                    $("#upperDiv_not").hide();
                    $("#closedcases").html('');
                }
            }
            $('.f-tab').tipsy({
                gravity: 'n',
                fade: true
            });
        }
    });
}

function casePaging(page) {
    if ($('#caseMenuFilters').val() == 'milestone') {
        $('#mlstPage').val(page);
        ManageMilestoneList();
    } else if ($('#caseMenuFilters').val() == 'timelog') {
        casePage = page;
        ajaxTimeLogView('', '', page);
    } else if ($('#caseMenuFilters').val() == 'filter') {
        casePage = page;
        searchFilterView(page);
    } else if ($('#caseMenuFilters').val() == 'files') {
        casePage = page;
        easycase.showFiles('files');
    } else {
        casePage = page;
        easycase.refreshTaskList();
    }
}

function checkedAllResReply(CS_id) {
    var allchk = CS_id + 'chkAllRep';
    var allid = 'hidtotresreply' + CS_id;
    var res = $('#' + allid).val();
    var chkid = CS_id + "chk_";
    if ($('#' + CS_id + 'chkAllRep').prop("checked")) {
        if ($('#make_client_dtl' + CS_id).prop("checked")) {
            $('input[id^="' + chkid + '"]').not('.chk_client').prop("checked", true);
        } else {
            $('input[id^="' + chkid + '"]').prop("checked", true);
        }
    } else {
        $('input[id^="' + chkid + '"]').prop("checked", false);
    }
}

function changeToRte(id) {
    var custom = 'custom' + id;
    var txt = 'txt' + id;
    var html = 'html' + id;
    var plane = 'plane' + id;
    var editortype = 'editortype' + id;
    var cmnts = 'txa_comments' + id;
    var cmnts_plane = 'txa_plane' + id;
    if (!$('#' + txt).is(':visible')) {
        $('#' + custom).hide();
        $('#' + txt).show();
        $('#' + html).show();
        $('#' + plane).hide();
        $('#' + editortype).val(0);
        $("#" + cmnts).focus();
        $("#label_txa_plane" + id).show();
    } else {
        $('#' + custom).show();
        $('#' + txt).hide();
        $('#' + html).hide();
        $('#' + plane).show();
        $('#' + editortype).val(1);
        $("#label_txa_plane" + id).show();
    }
    $('#' + 'showhtml' + id).hide();
    $('#' + 'hidhtml' + id).show();
}

function valforlegend(id, leg, selId) {
    $("#" + selId + " option").removeAttr("selected");
    $("#" + selId + " option").removeClass('selected');
    $('#' + leg).val(id);
    $("#" + selId + " option[value='" + id + "']").attr('selected', 'selected');
}

function select_reply_user(cs_autoid, obj) {
    var uid = $(obj).val();
    if (uid == 0) {
        $("#start_time_div_" + cs_autoid).find('select').val("");
        $("#start_time_div_" + cs_autoid).hide();
        $('.timelog_block').find('select').val('');
        $('.timelog_block').find('input').val('');
        $('.timelog_block').hide();
    } else {
        if (SES_TYPE == 3 && uid != SES_ID) {
            $("#start_time_div_" + cs_autoid).find('select').val("");
            $("#start_time_div_" + cs_autoid).hide();
            $('.timelog_block').find('select').val('');
            $('.timelog_block').find('input').val('');
            $('.timelog_block').hide();
        } else {
            $('.timelog_block').show();
            $("#start_time_div_" + cs_autoid).show();
            $('#' + cs_autoid + 'chk_' + uid).attr('checked', 'checked');
        }
    }
}
var totalReplies = 0;
var easycase = {};
easycase.getStatus = function(type, legend) {
    if (arguments[2] == "detail") {
    if (type == 10) {
        return 'Update';
    } else if (legend == 1) {
        return _('New');
    } else if (legend == 2 || legend == 4) {
        return _('In Progress');
    }
    if (legend == 3) {
        return _('Closed');
    } else if (legend == 4) {
        return _('In Progress');
    } else if (legend == 5) {
        return _('Resolved');
    }
    } else {
        if (type == 10) {
            return '<span class="label update label-update fade-update">' + _('Update') + '</span>';
        } else if (legend == 1) {
            return '<span class="label new label-danger fade-red">' + _('New') + '</span>';
        } else if (legend == 2 || legend == 4) {
            return '<span class="label wip label-info fade-blue">' + _('In Progress') + '</span>';
        }
        if (legend == 3) {
            return '<span class="label closed label-success fade-green">' + _('Closed') + '</span>';
        } else if (legend == 4) {
            return '<span class="label wip label-info fade-blue">' + _('In Progress') + '</span>';
        } else if (legend == 5) {
            return '<span class="label resolved label-warning fade-orange">' + _('Resolved') + '</span>';
        }
    }
}
easycase.getCustomStatus = function(customStatus, id) {
    return '<span class="label label-custom label-info" style="background-color:#' + customStatus.color + '" title="' + customStatus.name + '">' + customStatus.name + '</span>';
}
easycase.getDashLabelStatus = function(type, legend) {
    if (type == 10) {
        return 'Update';
    } else if (legend == 1) {
        return 'New';
    } else if (legend == 2 || legend == 4) {
        return 'In Progress';
    }
    if (legend == 3) {
        return 'Closed';
    } else if (legend == 4) {
        return 'In Progress';
    } else if (legend == 5) {
        return 'Resolved';
    }
}
easycase.getDashColorStatus = function(type, legend) {
    if (type == 10) {
        return 'inprogress';
    } else if (legend == 1) {
        return 'new';
    } else if (legend == 2 || legend == 4) {
        return 'inprogress';
    }
    if (legend == 3) {
        return 'close';
    } else if (legend == 4) {
        return 'inprogress';
    } else if (legend == 5) {
        return 'resolve';
    }
}
easycase.imageTypeIcon = function(format) {
    var iconsArr = ["gd", "db", "zip", "xls", "doc", "jpg", "png", "bmp", "pdf", "tif", "txt", "psd", "video", "ppt", "sql", "csv"];
    if (format == undefined) {
        return;
    }
    format = format.toString().toLowerCase();
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
    } else if (format == "mp4" || format == "3gp" || format == "mpeg4" || format == "mkv") {
        format = "video"
    }
    if ($.inArray(format, iconsArr) == -1) {
        format = 'html'
    }
    return format;
}
easycase.getColorStatus = function(type, legend) {
    if (type == 10) {
        return '<b class="update"rel="tooltip" title="Update">' + _('Update') + '</b>';
    } else if (legend == 1) {
        return '<b class="new border"rel="tooltip" title="New">' + _('New') + '</b>';
    } else if (legend == 2 || legend == 4) {
        return '<b class="wip border"rel="tooltip"title="In Progress">' + _('In Progress') + '</b>';
    }
    if (legend == 3) {
        return '<b class="closed"rel="tooltip"title="Closed">' + _('Closed') + '</b>';
    } else if (legend == 4) {
        return '<b class="wip border"rel="tooltip"title="In Progress">' + _('In Progress') + '</b>';
    } else if (legend == 5) {
        return '<b class="resolved border"rel="tooltip"title="Resolved">' + _('Resolved') + '</b>';
    }
}
easycase.myTaskCount = function(count) {
    $("#myTaskCountId").html('(' + count + ')')
}
easycase.myOverTaskCount = function(count) {
    $("#myOverdueTaskCountId").html('(' + count + ')')
}
easycase.shortName = function(str) {
    var n = str.length;
    if (n > 4) {
        var name = "<i title='" + str + "' >" + str.substring(0, 2) + '.</i>';
    } else {
        var name = "<i title='" + str + "' >" + str + "</i>";
    }
    return name;
}
easycase.getPriority = function(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return;
    } else if (casePriority == 0) {
        return 'high';
    } else if (casePriority == 1) {
        return 'medium';
    } else if (casePriority >= 2) {
        return 'low';
    }
}
easycase.getColorPriority = function(casePriority) {
    if (casePriority == "NULL" || casePriority == "") {
        return;
    } else if (casePriority == 0) {
        return '<b style="color:#FF0000;">' + _('High Priority') + '</b>';
    } else if (casePriority == 1) {
        return '<b style="color:#28AF51;">' + _('Medium Priority') + '</b>';
    } else if (casePriority == 2) {
        return '<b style="color:#B4A532;">' + _('Low Priority') + '</b>';
    }
}
easycase.refreshTaskList = function(dtlsid, details) {
    var params = parseUrlHash(urlHash);
    var filterV = $('#caseMenuFilters').val();
    var hashPage = params[0];
    if (hashPage == 'timelog' || params[0] == 'tasks' || params[0] == 'kanban' || params[0] == 'taskgroup' || params[0] == 'subtask' || (params[0] == 'calendar' || filterV == 'calendar' || params[0] == 'searchFilters' || params[0] == 'milestonelist' || params[0] == 'taskgroups')) {
        if (filterV == 'kanbantask' && (params[0] == 'kanban' || params[0] == 'calendar')) {
            refreshTasks = 1;
            window.location.hash = 'tasks';
        } else {
            if (details) {
                $('#t_' + dtlsid).remove();
            }
            if (params[0] == 'tasks') {
                ajaxCaseView();
            } else if (params[0] == 'taskgroups') {
                ajaxCaseView('taskgroups');
            } else if (params[0] == 'taskgroup') {
                if ($('#projFil').val() != 'all') {
                    remember_filters('TASKGROUPBY', 'milestone');
                }
                ajaxCaseView('taskgroup');
            } else if (params[0] == 'subtask') {
                ajaxCaseView('subtask');
            } else if (params[0] == 'searchFilters') {
                $('#filtered_items').hide();
                searchFilterView();
            } else if (params[0] == 'calendar' || filterV == 'calendar') {
                $('#priFil').val("all");
                $('#caseTypes').val("all");
                $('#caseLabel').val("all");
                $('#caseStatus').val("all");
                $('#caseCustomStatus').val("all");
                $('#caseMember').val("all");
                $('#caseComment').val("all");
                $('#caseAssignTo').val("all");
                $('#caseDateFil').val("");
                $('#casedueDateFil').val("");
                remember_filters('reset', 'all');
                calendarView('calendar');
            } else if (params[0] == 'milestonelist') {
                window.location.hash = 'milestonelist';
                showMilestoneList();
            } else if (hashPage == 'timelog') {
                if (arguments[2]) {
                    ajaxCaseView();
                    $(".side-nav li").removeClass('active');
                    $(".menu-cases").addClass('active');
                    if (!(localStorage.getItem("theme_setting") === null)) {
                        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                        $(".side-nav li").each(function() {
                            $(this).removeClass(th_class_str);
                        });
                        $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                    }
                } else {
                    $('#priFil').val("all");
                    $('#caseTypes').val("all");
                    $('#caseLabel').val("all");
                    $('#caseStatus').val("all");
                    $('#caseCustomStatus').val("all");
                    $('#caseMember').val("all");
                    $('#caseComment').val("all");
                    $('#caseAssignTo').val("all");
                    $('#caseDateFil').val("");
                    $('#casedueDateFil').val("");
                    remember_filters('reset', 'all');
                    if ($("#tlog_externalfilter").val() == 1) {
                        $("#tlog_externalfilter").val('');
                    } else {
                        $('#logstrtdt,#logenddt').val('').datepicker("option", {
                            minDate: null,
                            maxDate: null
                        });
                        $('#tlog_date').val('');
                    }
                    $('#rsrclog').val('');
                    $('#tlog_resource').val('');
                    $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr("checked");
                    $('#dropdown_menu_resource').find('input[type="checkbox"]').removeAttr("checked");
                    ajaxTimeLogView();
                    general.filterDate('timelog', 'alldates', 'All', 'check');
                }
            } else {
                $('#milestoneUid').val('');
                $('#milestoneId').val('');
                var pm1 = params[1];
                if (typeof pm1 != 'undefined') {
                    window.location.hash = 'kanban/' + params[1];
                } else {
                    window.location.hash = 'kanban';
                }
                easycase.showKanbanTaskList();
            }
        }
    } else if (dtlsid) {
        if (details && ($('#caseMenuFilters').val() == '')) {
            refreshKanbanTask = 1;
            refreshActvt = 1;
            refreshMilestone = 1;
            refreshManageMilestone = 1;
            ajaxCaseView('details');
        } else {
            refreshTasks = 1;
            refreshKanbanTask = 1;
            refreshActvt = 1;
            refreshMilestone = 1;
            refreshManageMilestone = 1;
            easycase.ajaxCaseDetails(dtlsid, 'case', 0);
        }
    } else if (params[0] == 'calendar_timelog') {
        if (typeof arguments[2] != 'undefined' && arguments[2] == 'milestone') {
            refreshTasks = 1;
            window.location.hash = 'tasks';
        } else {
            var clk_vald = $('#check_cale_multple_time').val();
            if (clk_vald == '') {
                getCalenderForTimeLog('calendar');
            }
        }
    } else if (params[0] == 'chart_timelog') {
        get_chart_timelog();
    } else if (params[0] == 'timesheet') {} else if (params[0] == 'timesheet_weekly') {} else {
        refreshTasks = 1;
        window.location.hash = 'tasks';
    }
}
easycase.ajaxCaseDetails = function(caseUniqId, type, dtls) {
    if ($('.hopscotch-bubble-close').length && localStorage.getItem("tour_type") != '3') {
        $('.hopscotch-bubble-close').click();
    }
    mention_array['mention_type_id'] = new Array();
    mention_array['mention_type'] = new Array();
    mention_array['mention_id'] = new Array();
    if (PAGE_NAME == "resource_availability") {
        $('#myModal').modal('hide');
        $(".cmn_popup").hide();
    }
    /*var isPopup=(typeof arguments[3]!='undefined'&&arguments[3]=='popup')?1:0;*/
    var isPopup = 1;
    var is_next = (typeof arguments[4] != 'undefined' && arguments[4] == 'next') ? 1 : 0;
    var is_prev = (typeof arguments[4] != 'undefined' && arguments[4] == 'prev') ? 1 : 0;
    var is_reload = (typeof arguments[4] != 'undefined' && arguments[4] == 'reload') ? 1 : 0;
    var is_action = (typeof arguments[4] != 'undefined' && arguments[4] == 'action') ? 1 : 0;
    var strURL = HTTP_ROOT + "easycases/case_details";
    if (isPopup == 1) {
        $('#caseLoaderPopupKB').show();
    } else {
        $('#caseLoader').show();
    }
    $('#lastTotReplies-lst').val(totalReplies);
    $.post(strURL, {
        "caseUniqId": caseUniqId,
        "details": dtls
    }, function(data) {
        if (data) {
            if (typeof data.redirect != 'undefined') {
                $('#projFil').val(data.proj_uid);
                $('#CS_project_id').val(data.proj_uid);
                $('#curr_active_project').val(data.proj_uid);
                var _all_chk = 0;
                var _allradio_chk = 'proj_' + data.proj_uid;
                var _allpage_chk = 'dashboard';
                var cnt = "<a class='top_project_name ellipsis-view' title='" + data.proj_nm + "' href='javascript:void(0);' onClick='updateAllProj(\"" + _allradio_chk + "\",\"" + data.proj_uid + "\",\"" + _allpage_chk + "\",\"" + _all_chk + "\",\"" + data.proj_nm + "\");'>" + data.proj_nm + "</a>";
                $('#pname_dashboard').html(cnt);
                window.location.href = data.redirect_url + 'dashboard#/details/' + data.uid + '/?v=1';
                return false;
            }
            totalReplies = data.total;
            if (isPopup == 1) {
                if (!is_next && !is_prev && !is_reload && !is_action) {
                    localStorage.setItem("last_url", window.location.href);
                }
                var newUrl = HTTP_ROOT + 'dashboard#/details/' + caseUniqId;
                window.history.pushState({}, null, newUrl);
                $("#cnt_task_detail_kb").html(tmpl("case_details_popup_tmpl", data));
                $('#myModalDetail').show();
                $('#myModalDetail').addClass('in');
                $('.task_details_popup').show();
                $('[rel=tooltip_previous]').tipsy({
                    gravity: 's',
                    fade: true
                });
                $('[rel=tooltip_nxt]').tipsy({
                    gravity: 's',
                    fade: true
                });
                $('#caseLoaderPopupKB').hide();
                $('.detail_page_subtask').show();
                $('.other_page_subtask').hide();
                if (isPopup && parseInt($("#subtask-container").height()) > 70) {
                    $('#edit_act' + caseUniqId).hide();
                }
                if (urlHash == 'backlog') {
                    $(".displayOnlyForBackLog").show();
                    var isComingFromLinkSec = localStorage.getItem("iscomingfromlinksection");
                    if (parseInt(data.link_parent_details['parentEasycaseId']) > 0 && data.link_parent_details['parentEasycaseUniqId'] != 0 && isComingFromLinkSec == 1) {
                        $(".displayParentBackButton").hide();
                        $("#hidden_parent_case_uid").val(data.link_parent_details['parentEasycaseUniqId']);
                    } else {
                        $(".displayParentBackButton").hide();
                        $("#hidden_parent_case_uid").val('');
                    }
                } else {
                    if (getHash().indexOf("kanban") !== -1 || getHash().indexOf("tasks") !== -1 || getHash().indexOf("taskgroup") !== -1) {
                        $(".displayOnlyForBackLog").show();
                        var isComingFromLinkSec = localStorage.getItem("iscomingfromlinksection");
                        if (parseInt(data.link_parent_details['parentEasycaseId']) > 0 && data.link_parent_details['parentEasycaseUniqId'] != 0 && isComingFromLinkSec == 1) {
                            $(".displayParentBackButton").hide();
                            $("#hidden_parent_case_uid").val(data.link_parent_details['parentEasycaseUniqId']);
                        } else {
                            $(".displayParentBackButton").hide();
                            $("#hidden_parent_case_uid").val('');
                        }
                    } else {
                        $(".displayOnlyForBackLog").show();
                        $(".displayParentBackButton").hide();
                    }
                }
            } else {
                easycase.routerHideShow('details');
                $('#t_' + data.csUniqId).remove();
                $('.task-list-bar').hide();
                $("#detail_section").append(tmpl("case_details_tmpl", data));
                $('.detail_page_subtask').hide();
                $('.other_page_subtask').show();
            }
            if (parseInt(data.is_zoom_set)) {
                viewMeeting(data.csUniqId, data.projUniqId);
            }
            $('#deatal_tour').off().on('click', function() {
                $('body').addClass('hopscotch_bubble_body');
                var uhas = getHash();
                localStorage.setItem("tour_type", '6');
                localStorage.setItem("OSTOUR", 1);
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_deatailpage + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_deatailpage;
                }
                hopscotch.startTour(GBl_tour);
            });
            $('input[id^="strpo_cnt"]').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var id = $(this).attr('data-est-id');
                    var uid = $(this).attr('data-est-uniq');
                    var cno = $(this).attr('data-est-no');
                    var pt = $(this).attr('data-est-pt');
                    changeStoryPoint(id, uid, cno, pt);
                }
            });
            $('input[id^="est_hr"]').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    localStorage.setItem("ckl_chk", 1);
                    var id = $(this).attr('data-est-id');
                    var uid = $(this).attr('data-est-uniq');
                    var cno = $(this).attr('data-est-no');
                    var tim = $(this).attr('data-est-time');
                    changeEstHour(id, uid, cno, tim);
                }
            });
            localStorage.setItem("ckl_chk", 0);
            $('input[id^="est_hr"]').on('blur', function(e) {
                var d_val = $(this).attr('data-default-val');
                var d_val_orig = $(this).val();
                if (localStorage.getItem("ckl_chk") == '0') {
                    if (d_val == d_val_orig) {
                        $(this).closest('.estb').size() > 0 || $(this).hasClass('fl') ? '' : $('.estb').show();
                        $('.est_hr').hide();
                    } else {
                        $(this).focus();
                    }
                }
            });
            $('input[id^="strpo_cnt"]').on('blur', function(e) {
                $(this).focus();
            });
            $(".add_checklist_inpt").off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var puid = $(this).attr('data-projid');
                    var cs_uid = $(this).attr('data-caseid');
                    if ($.trim($(this).val()) == '') {
                        $(this).focus();
                    } else {
                        addChecklistPopup(puid, cs_uid, 0);
                    }
                }
            });
            $('.checklist_ttl').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var puid = $(this).attr('data-projid');
                    var cs_uid = $(this).attr('data-caseid');
                    var id = $(this).attr('data-id');
                    var val_inpt = $.trim($('#checklist_t_' + id).val());
                    var val_inpt_b = $.trim($('#checklist_b_' + id).val());
                    if (val_inpt == '') {
                        showTopErrSucc('error', _("Checklist can not be blank"));
                        $('#checklist_t_' + id).val(val_inpt_b);
                        val_inpt = val_inpt_b;
                    } else if (val_inpt != val_inpt_b) {
                        addChecklistPopup(puid, cs_uid, id);
                    }
                    $('#checklist_lkn' + id).html(val_inpt).show();
                    $('#checklist_t_' + id).hide();
                    $('#checklist_b_' + id).val(val_inpt);
                }
            });
            $('.checklist_ttl').on('blur', function(e) {
                var id = $(this).attr('data-id');
                var puid = $(this).attr('data-projid');
                var cs_uid = $(this).attr('data-caseid');
                var val_inpt = $.trim($('#checklist_t_' + id).val());
                var val_inpt_b = $.trim($('#checklist_b_' + id).val());
                if (val_inpt == '') {
                    showTopErrSucc('error', _("Checklist can not be blank"));
                    $('#checklist_t_' + id).val(val_inpt_b);
                    val_inpt = val_inpt_b;
                } else if (val_inpt != val_inpt_b) {
                    addChecklistPopup(puid, cs_uid, id);
                }
                $('#checklist_lkn' + id).html(val_inpt).show();
                $('#checklist_t_' + id).hide();
                $('#checklist_b_' + id).val(val_inpt);
            });
            $('.check_chklist').off().on('click', function(e) {
                var is_checked = ($(this).is(':checked')) ? 1 : 0;
                var id = $(this).attr('data-id');
                var puid = $('#checklist_t_' + id).attr('data-projid');
                var cs_uid = $('#checklist_t_' + id).attr('data-caseid');
                addChecklistPopup(puid, cs_uid, id);
            });
            $(`#checklist_body${caseUniqId}`).sortable({
                placeholder: "ui-state-highlight",
                dropOnEmpty: false,
                stop: function(event, ui) {
                    $.ajax({
                        url: `${HTTP_ROOT}requests/ajax_reorderchecklist`,
                        type: 'POST',
                        dataType: 'json',
                        data: $(`#checklist_body${caseUniqId}`).sortable("serialize")
                    }).done(function(response) {});
                }
            });
            if (localStorage.getItem("tour_type") == '3') {
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_mngwork + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_mngwork;
                }
                hopscotch.startTour(GBl_tour, hopscotch.getCurrStepNum());
            }
            $('.detl_tab_switching').off().on('click', function() {
                $('.detl_tab_switching').removeClass('current');
                $(this).addClass('current');
                var tab_to_swh = $(this).attr('data-tab');
                var uid_to_swh = $(this).attr('data-case_uid');
                var tab_to_hid = $(this).attr('data-to_hid');
                var tab_to_hids = tab_to_hid.split(' ');
                $('#' + tab_to_swh).show();
                for (i in tab_to_hids) {
                    $('#' + tab_to_hids[i] + uid_to_swh).hide();
                }
            });
            $('.dropdown').on('click', function() {
                $('.dropdown_tg_sts').hide();
            });
            if (parseInt(localStorage.getItem("detail_timelog_delete"))) {
                localStorage.setItem("detail_timelog_delete", 0);
                $('.detl_tab_switching').removeClass('current');
                $('.detl_tab_switching').trigger('click');
            }
            var tmdet = getCookie('timerDtls');
            var tm = getCookie('timer');
            if (typeof tmdet != 'undefined' && tmdet != '' && typeof tm != 'undefined' && tm != '') {
                var tmCsDet_dtl = tmdet.split('|');
            }
            $.material.init();
            $(".select_sts").select2();
            $(".select-assign-replay").select2();
            var x = document.getElementsByTagName("body")[0];
            var holder_detal = document.getElementById('holder_detl'),
                tests = {
                    dnd_detl: 'draggable' in document.createElement('span')
                };
            if ($('#holder_detl').length) {
                if (tests.dnd_detl) {
                    var entered = 0;
                    holder_detal.ondragover = function() {
                        $('#holder_detl').addClass('hover_drag');
                        return false;
                    };
                    x.ondragenter = function(e) {
                        if ($(e.target).closest('.full_width_resp').length > 0) {
                            entered = 1;
                        } else {
                            entered = 0;
                        }
                        if (entered == 1) {
                            $('#holder_detl').addClass('hover_drag');
                            entered = 0;
                        } else {
                            $('#holder_detl').removeClass('hover_drag');
                            entered = 0;
                        }
                        return false;
                    };
                    x.ondrop = function(e) {
                        if ($(e.target).hasClass('customfile-input')) {} else {
                            $('#holder_detl').removeClass('hover_drag');
                            return false;
                        }
                        entered = 0;
                    };
                    holder_detal.ondrop = function(e) {
                        $('#holder_detl').removeClass('hover_drag');
                        if (e.dataTransfer.files[0].name.match(/\.(.+)$/) == null || e.dataTransfer.files[0].size === 0) {
                            alert(_('File') + ' "' + e.dataTransfer.files[0].name + '" ' + _('has no extension!') + '\n' + _('Please upload files with extension.'));
                            e.stopPropagation();
                            e.preventDefault();
                        }
                        entered = 0;
                        return false;
                    };
                }
            }
            if ($('#t_' + caseUniqId).find('.toggle_task_details').is(":visible")) {
                $('#open_detail_id').text(_('Hide Detail'));
                $('.tglarow_icon').addClass('down');
            } else {
                $('#open_detail_id').text(_('Show Detail'));
                $('.tglarow_icon').removeClass('down');
            }
            if (isPopup == 1) {
                easycase.detailPageinate(caseUniqId);
            }
            $("#hidden_case_uid").val(caseUniqId);
            if (isPopup != 1) {
                easycase.detailPageinate();
                var params = parseUrlHash(urlHash);
                if (params[0] != "details") {
                    parent.location.hash = "details" + "/" + caseUniqId;
                }
            }
            bindPrettyview("prettyPhoto");
            bindPrettyview("prettyImg");
            fuploadUI(data.csAtId);
            var params = parseUrlHash(urlHash);
            if (dtls == 0) {} else {}
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            $('.sub-tasks-popoup .case-title').tipsy({
                gravity: 'n',
                fade: true
            });
            $("img.lazy").each(function() {
                $(this).attr('src', $(this).attr('data-original'));
            });
            if (scrollToRep && scrollToRep == caseUniqId) {
                if (isPopup == 1) {
                    scrollDtlPageTop($('#reply_box' + data.csAtId));
                } else {
                    scrollPageTop($('#t_' + scrollToRep + ' .reply_task_block'));
                }
                $("div[id^='hiddrpdwnstatus']").find('select option:selected').prop('selected', false);
                $("div[id^='hiddrpdwnstatus']").find('select option:nth-of-type(2)').prop('selected', true);
                if (typeof tinymce != 'undefined') {
                    tinymce.execCommand('mceFocus', true, 'txa_comments' + data.csAtId);
                }
            } else {
                scrollPageTop();
            }
            $(".slide_rht_con").animate({
                marginLeft: "0px"
            }, "fast");
            $(".crt_slide").css({
                display: "none"
            });
            $("div [id^='det_set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    startDate: new Date(),
                    todayHighlight: true,
                    format: 'mm/dd/yyyy',
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    var caseId = $(this).attr('data-csatid');
                    var text = '';
                    var dateText = $(this).datepicker('getFormattedDate');
                    $(this).val('');
                    detChangeDueDate(caseId, dateText, '', caseUniqId, data.csNoRep);
                });
            });
            $('.caleder-due-date').off().on('click', function(e) {
                $('div.detail-taskprog-drop > ul.dropdown-menu').hide();
                e.stopPropagation();
                var targt = $(e.target)[0].id;
                if ($(this).find('div.duedate-txts > div.dropdown').hasClass('open')) {
                    if ($(targt).not("det_set_due_date_")) {
                        $(this).find('div.duedate-txts > div.dropdown').removeClass('open');
                    }
                } else {
                    $(this).find('div.duedate-txts > div.dropdown').addClass('open');
                }
            });
            $('.task-progress').off().on('click', function(e) {
                var targt = $(e.target).attr('class');
                $('.dropdown').removeClass('open');
                e.stopPropagation();
                if (typeof targt != 'undefined' && targt.indexOf("task_prog_percent") === -1 && targt.indexOf("tsk-dtail-drop") === -1) {
                    $(this).find('div.detail-taskprog-drop > ul.dropdown-menu').toggle();
                }
            });
            LogTime.initiateLogTime(data.csAtId);
            removeAllReply(data.csAtId);
            $("a[rel^='prettyPhoto']").prettyPhoto({
                animation_speed: 'normal',
                autoplay_slideshow: false,
                social_tools: false,
                overlay_gallery: false,
                deeplinking: false,
                changepicturecallback: function() {
                    $('body').css({
                        'overflow-y': 'hidden'
                    });
                },
                callback: function() {
                    $('body').css({
                        'overflow-y': 'visible'
                    });
                }
            });
            general.update_footer_total();
        } else {
            if (isPopup == 1) {
                $('#myModalDetail button.close').click();
                alert(_('Sorry! you are not a part of the project. Only users associated with a project can view the task detail.'));
            } else {
                alert(_('Sorry! you are not a part of the project. Only users associated with a project can view the task detail.'));
                window.location.href = HTTP_ROOT + 'projects/manage/';
            }
        }
        $('#caseLoader').hide();
        if ($('.ststd').find('span').text() == 'Archived') {
            $('.taskdetails').hide();
        }
        scrollToRep = null;
        select_reply_user(data.csAtId, $('#CS_assign_to' + data.csAtId));
        $('#startTourBtn').show();
        setTourDetail(caseUniqId);
        $('img').off().on('click', function(e) {
            var targt = $(e.target).attr('src');
            e.stopPropagation();
            if (typeof targt != 'undefined' && targt.indexOf("_case_edtr") !== -1) {
                var spltArr = targt.split('file=')[1].split('&quality');
                if (confirm(_('Would you like to delete this file?'))) {
                    $.ajax({
                        url: HTTP_ROOT + "easycases/ajaXRemoveEditorFile",
                        data: {
                            'file': spltArr[0]
                        },
                        method: 'post',
                        success: function(response) {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup', 'reload');
                        }
                    });
                }
            }
        });
    });
}
easycase.loadTinyMce = function(csAtId) {
    $("#htmlloader" + csAtId).show();
    var templat_arr = [];
    $.each(TASKTMPL, function(index_tml, value_tml) {
        templat_arr.push({
            "title": value_tml.CaseTemplate.name,
            "description": value_tml.CaseTemplate.description,
            "content": value_tml.CaseTemplate.description
        });
    });
    if (tinymce.get('txa_comments' + csAtId)) {
        tinymce.get('txa_comments' + csAtId).remove();
    }
    var dir_tiny = 'ltr';
    if (SES_COMP === '33179' || SHOW_ARABK === '1') {
        dir_tiny = 'rtl';
    }
    var content_lnth_mng = 0;
    if (CMP_ARABK === '23823' || SES_COMP === '33179' || SHOW_ARABK === '1') {
        tinymce.init({
            selector: "#txa_comments" + csAtId,
            plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
            menubar: false,
            branding: false,
            statusbar: false,
            toolbar: 'undo redo | bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | template | ltr rtl | fullscreen',
            toolbar_sticky: true,
            importcss_append: true,
            image_caption: true,
            browser_spellcheck: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
            directionality: dir_tiny,
            toolbar_drawer: 'sliding',
            template_popup_height: "200px",
            template_popup_width: "200px",
            templates: templat_arr,
            resize: false,
            min_height: 200,
            max_height: 400,
            paste_data_images: true,
            paste_as_text: true,
            autoresize_on_init: true,
            autoresize_bottom_margin: 20,
            content_css: HTTP_ROOT + 'css/tinymce.css',
            setup: function(ed) {
                ed.on('Click', function(ed, e) {
                    $('#start_time' + csAtId).timepicker('hide');
                    $('#end_time' + csAtId).timepicker('hide');
                    $("#start_date" + csAtId).datepicker('hide');
                    $("#due_date" + csAtId).datepicker('hide');
                });
                ed.on('KeyUp', function(ed, e) {
                    var inpt = $.trim(tinymce.activeEditor.getContent());
                    var inptLen = inpt.length;
                    var datInKb = 0;
                    var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
                    if (datInKb > 2049) {}
                    if (inpt != '') {
                        $('#placeholder' + csAtId).hide();
                    } else {
                        $('#placeholder' + csAtId).show();
                    }
                });
                ed.on('Change', function(ed, e) {
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
                    $("#htmlloader" + csAtId).hide();
                    $("#placeholder" + csAtId).click(function() {
                        $(this).hide();
                    });
                    ed.execCommand('mceFocus', true, 'txa_comments' + csAtId);
                });
            }
        });
    } else {
        tinymce.init({
            selector: "#txa_comments" + csAtId,
            plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help mention',
            menubar: false,
            branding: false,
            statusbar: false,
            toolbar: 'undo redo | bold italic underline strikethrough | outdent indent |  numlist bullist | forecolor backcolor | template | fullscreen',
            toolbar_sticky: true,
            importcss_append: true,
            image_caption: true,
            browser_spellcheck: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 ',
            toolbar_drawer: 'sliding',
            template_popup_height: "200px",
            template_popup_width: "200px",
            templates: templat_arr,
            resize: false,
            min_height: 200,
            max_height: 400,
            paste_data_images: true,
            paste_as_text: true,
            autoresize_on_init: true,
            autoresize_bottom_margin: 20,
            content_css: HTTP_ROOT + 'css/tinymce.css',
            mentions: {
                source: function(query, process, delimiter) {
                    var proj_uniq_id = $('#projFil').val();
                    var murl = HTTP_ROOT + "requests/getUserTaskList";
                    $.post(murl, {
                        proj_uniq_id: proj_uniq_id,
                        search_query: query
                    }, function(data) {
                        if (data) {
                            process(data);
                            $(".rte-autocomplete").css({
                                "z-index": "999999 !important"
                            });
                        }
                    }, 'json');
                },
                insert: function(item) {
                    mention_array['mention_type_id'].push(item.id);
                    mention_array['mention_type'].push(item.type);
                    if (item.type == "task") {
                        return '<span class="task_mention" data-id="' + item.id + '" data-tskuniqid="' + item.uniq_id + '" style="color: #3598db;">' + item.name + '</span>&nbsp;';
                    } else {
                        return '<span class="user_mention" data-id="' + item.id + '" style="color: #3598db;">@' + item.name + '</span>&nbsp;';
                    }
                }
            },
            setup: function(ed) {
                ed.on('Click', function(ed, e) {
                    $('#start_time' + csAtId).timepicker('hide');
                    $('#end_time' + csAtId).timepicker('hide');
                    $("#start_date" + csAtId).datepicker('hide');
                    $("#due_date" + csAtId).datepicker('hide');
                });
                ed.on('KeyUp', function(ed, e) {
                    var inpt = $.trim(tinymce.activeEditor.getContent());
                    var inptLen = inpt.length;
                    var datInKb = 0;
                    var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
                    if (datInKb > 2049) {}
                    var key = ed.keyCode || ed.charCode;
                    if (key == 8) {
                        var domclass = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'class');
                        if (domclass == "task_mention") {
                            var tsk_data_id = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'data-id')
                            remove_element(mention_array['mention_type_id'], tsk_data_id);
                            tinymce.activeEditor.dom.remove(tinymce.activeEditor.selection.getNode());
                        } else if (domclass == "user_mention") {
                            var usr_data_id = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'data-id')
                            remove_element(mention_array['mention_type_id'], usr_data_id);
                            tinymce.activeEditor.dom.remove(tinymce.activeEditor.selection.getNode());
                        }
                    }
                    if (inpt != '') {
                        $('#placeholder' + csAtId).hide();
                    } else {
                        $('#placeholder' + csAtId).show();
                    }
                });
                ed.on('Change', function(ed, e) {
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
                    $("#htmlloader" + csAtId).hide();
                    $("#placeholder" + csAtId).click(function() {
                        $(this).hide();
                    });
                    ed.execCommand('mceFocus', true, 'txa_comments' + csAtId);
                });
            }
        });
    }
}
easycase.showtaskgroup = function(task_data) {
    var strURL = HTTP_ROOT + "easycases/case_taskgroup";
    $('#caseLoader').show();
    ajaxCaseView('taskgroup');
}
easycase.subtask = function(task_data) {
    $('#caseLoader').show();
    ajaxCaseView('subtask');
}
easycase.showTaskDetail = function(task_data) {
    if ($('#t_' + task_data[1]).length) {
        $('#startTourBtn').show();
        $('body').css('background', '#F4F4F4');
        easycase.routerHideShow('details');
        var shtg = getCookie('SHOWTIMELOG');
        if (typeof shtg == 'undefined' || shtg.toLowerCase() == 'yes') {
            $('.timelog-detail-tbl').show();
        }
        $('#case_ttl_edit_main_' + task_data[1]).show();
        $('#case_ttl_edit_dv' + task_data[1]).hide();
        $('#t_' + task_data[1]).show();
        if ($('#t_' + task_data[1]).find('.toggle_task_details').is(":visible")) {
            $('#open_detail_id').text('Hide Detail');
            $('.tglarow_icon').addClass('down');
        } else {
            $('#open_detail_id').text('Show Detail');
            $('.tglarow_icon').removeClass('down');
        }
        easycase.detailPageinate();
        if (scrollToRep && scrollToRep == task_data[1]) {
            scrollPageTop($('#t_' + scrollToRep + ' .reply_task_block'));
            $("div[id^='hiddrpdwnstatus']").find('select option:selected').prop('selected', false);
            $("div[id^='hiddrpdwnstatus']").find('select option:nth-of-type(2)').prop('selected', true);
        } else {
            scrollPageTop();
        }
        if ($('#tab-1' + task_data[1]).is(":visible")) {
            $('.detl_tab_switching').removeClass('current');
            $('.detl_tab_switching.comment_tab').addClass('current');
        } else {
            $('.detl_tab_switching').removeClass('current');
            $('.detl_tab_switching.tlog_tab').addClass('current');
        }
        scrollToRep = null;
    } else {
        easycase.ajaxCaseDetails(task_data[1], 'case', 0, 'popup', 'action');
    }
}
easycase.showTaskLists = function(page) {
    if (refreshTasks == 1) {
        $("#caseMenuFilters").val('');
    }
    $(".side-nav li").removeClass('active');
    $(".menu-cases").addClass('active');
    if (!(localStorage.getItem("theme_setting") === null)) {
        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
        $(".side-nav li").each(function() {
            $(this).removeClass(th_class_str);
        });
        $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
    }
    if (($('#caseViewSpan').html() && refreshTasks == 0 && !$('#bklog').is(':visible')) && !$('#caseViewSpan #preloaderIdTaskList').length) {
        easycase.routerHideShow(page);
        scrollPageTop();
        if (localStorage.getItem("is_saveFilter_set") == '1') {
            localStorage.setItem("is_saveFilter_set", 0);
            $('#saveFilter').show();
            $('#savereset_filter').show();
        }
    } else {
        easycase.refreshTaskList();
    }
    displayMenuProjects('dashboard', '6', '');
}
easycase.detailPageinate = function() {
    if (urlHash) {
        var params = parseUrlHash(urlHash);
        if (params[1] && params[0] == 'details') {
            if ($('.case-title[data-task="' + params[1] + '"]').length) {
                var prevId = $('.case-title[data-task="' + params[1] + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).nextAll('.tr_all[id^="curRow"]').length) {
                    $('.task_detail_head .next').removeClass('disable');
                    $('.task_detail_head .next').attr('disabled', false);
                } else {
                    $('.task_detail_head .next').addClass('disable');
                    $('.task_detail_head .next').attr('disabled', true);
                    $('.task_detail_head .next').css('color', '#D6D0D0');
                }
                if ($('#' + prevId).prevAll('.tr_all[id^="curRow"]').length) {
                    $('.task_detail_head .prev').removeClass('disable');
                    $('.task_detail_head .prev').attr('disabled', false);
                } else {
                    $('.task_detail_head .prev').addClass('disable');
                    $('.task_detail_head .prev').attr('disabled', true);
                    $('.task_detail_head .prev').css('color', '#D6D0D0');
                }
            } else {
                $('.task_detail_head .next, .task_detail_head .prev').addClass('disable');
                $('.task_detail_head .next, .task_detail_head .prev').attr('disabled', true);
            }
        } else if (params[0] == 'backlog' && !params[1]) {
            var currentCaseUid = arguments[0];
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).nextAll('.tr_all[id^="curRow"]').length) {
                    $('.task_detail_head .next').removeClass('disable');
                    $('.task_detail_head .next').attr('disabled', false);
                    $('.task_detail_head .next').css('color', '#FFFFFF');
                } else {
                    $('.task_detail_head .next').addClass('disable');
                    $('.task_detail_head .next').attr('disabled', true);
                    $('.task_detail_head .next').css('color', '#D6D0D0');
                }
                if ($('#' + prevId).prevAll('.tr_all[id^="curRow"]').length) {
                    $('.task_detail_head .prev').removeClass('disable');
                    $('.task_detail_head .prev').attr('disabled', false);
                    $('.task_detail_head .prev').css('color', '#FFFFFF');
                } else {
                    $('.task_detail_head .prev').addClass('disable');
                    $('.task_detail_head .prev').attr('disabled', true);
                    $('.task_detail_head .prev').css('color', '#D6D0D0');
                }
            } else {
                $('.task_detail_head .next, .task_detail_head .prev').addClass('disable');
                $('.task_detail_head .next, .task_detail_head .prev').attr('disabled', true);
            }
        } else if (params[0] != 'details' && (getHash().indexOf("kanban") !== -1 || getHash().indexOf("tasks") !== -1 || getHash().indexOf("taskgroup") !== -1)) {
            var currentCaseUid = arguments[0];
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                if (params[0] == 'kanban') {
                    if ($('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').next('.kb_task_det').length) {
                        $('.task_detail_head .next').removeClass('disable');
                        $('.task_detail_head .next').attr('disabled', false);
                        $('.task_detail_head .next').css('color', '#FFFFFF');
                    } else {
                        $('.task_detail_head .next').addClass('disable');
                        $('.task_detail_head .next').attr('disabled', true);
                        $('.task_detail_head .next').css('color', '#D6D0D0');
                    }
                    if ($('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').prev('.kb_task_det').length) {
                        $('.task_detail_head .prev').removeClass('disable');
                        $('.task_detail_head .prev').attr('disabled', false);
                        $('.task_detail_head .prev').css('color', '#FFFFFF');
                    } else {
                        $('.task_detail_head .prev').addClass('disable');
                        $('.task_detail_head .prev').attr('disabled', true);
                        $('.task_detail_head .prev').css('color', '#D6D0D0');
                    }
                } else {
                    var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                    if ($('#' + prevId).nextAll('.tr_all[id^="curRow"]').length) {
                        $('.task_detail_head .next').removeClass('disable');
                        $('.task_detail_head .next').attr('disabled', false);
                        $('.task_detail_head .next').css('color', '#FFFFFF');
                    } else {
                        $('.task_detail_head .next').addClass('disable');
                        $('.task_detail_head .next').attr('disabled', true);
                        $('.task_detail_head .next').css('color', '#D6D0D0');
                }
                if ($('#' + prevId).prevAll('.tr_all[id^="curRow"]').length) {
                    $('.task_detail_head .prev').removeClass('disable');
                    $('.task_detail_head .prev').attr('disabled', false);
                    $('.task_detail_head .prev').css('color', '#FFFFFF');
                } else {
                    $('.task_detail_head .prev').addClass('disable');
                    $('.task_detail_head .prev').attr('disabled', true);
                        $('.task_detail_head .prev').css('color', '#D6D0D0');
                    }
                }
            } else {
                $('.task_detail_head .next, .task_detail_head .prev').addClass('disable');
                $('.task_detail_head .next, .task_detail_head .prev').attr('disabled', true);
            }
        }
    }
    $('.task_detail_head .next, .task_detail_head .prev').tipsy({
        gravity: 'n',
        fade: true
    });
}
easycase.rollNext = function(el) {
    if (urlHash) {
        var params = parseUrlHash(urlHash);
        if ($('.hopscotch-bubble-close').length) {
            $('.hopscotch-bubble-close').click();
        }
        var currentCaseUid = $("#hidden_case_uid").val();
        if (params[1] && params[0] == 'details') {
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                $('#startTourBtn').hide();
                setSessionStorage('Task Details Page', 'Reply Task');
                var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).nextAll('.tr_all[id^="curRow"]').length) {
                    var nextId = $('#' + prevId).nextAll('.tr_all[id^="curRow"]').attr('id');
                    var nextCaseUid = $('#' + nextId).find('.case-title[id^="titlehtml"]').attr('data-task');
                    easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup', 'next');
                }
            } else {
                return false;
            }
        } else {
            if (params[0] == 'kanban') {
                if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                    $('#startTourBtn').hide();
                    setSessionStorage('Task Details Page', 'Reply Task');
                    var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').attr('data-task-id');
                    if ($('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').next('.kb_task_det').length) {
                        var nextId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').next('.kb_task_det').attr('data-task-id');
                        var nextCaseUid = nextId;
                        easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup');
                    }
                } else {
                    return false;
                }
            } else {
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                $('#startTourBtn').hide();
                setSessionStorage('Task Details Page', 'Reply Task');
                var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).nextAll('.tr_all[id^="curRow"]').length) {
                    var nextId = $('#' + prevId).nextAll('.tr_all[id^="curRow"]').attr('id');
                    var nextCaseUid = $('#' + nextId).find('.case-title[id^="titlehtml"]').attr('data-task');
                    easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup');
                }
            } else {
                return false;
            }
        }
    }
}
}
easycase.rollPrev = function(el) {
    if (urlHash) {
        var params = parseUrlHash(urlHash);
        if ($('.hopscotch-bubble-close').length) {
            $('.hopscotch-bubble-close').click();
        }
        var currentCaseUid = $("#hidden_case_uid").val();
        if (params[1] && params[0] == 'details') {
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                $('#startTourBtn').hide();
                setSessionStorage('Task Details Page', 'Reply Task');
                var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).prevAll('.tr_all[id^="curRow"]').length) {
                    var nextId = $('#' + prevId).prevAll('.tr_all[id^="curRow"]').attr('id');
                    var nextCaseUid = $('#' + nextId).find('.case-title[id^="titlehtml"]').attr('data-task');
                    easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup', 'prev');
                }
            } else {
                return false;
            }
        } else {
            if (params[0] == 'kanban') {
                if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                    $('#startTourBtn').hide();
                    setSessionStorage('Task Details Page', 'Reply Task');
                    var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').attr('data-task-id');
                    if ($('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').prev('.kb_task_det').length) {
                        var nextId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.kb_task_det').prev('.kb_task_det').attr('data-task-id');
                        var nextCaseUid = nextId;
                        easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup');
                    }
                } else {
                    return false;
                }
            } else {
            if ($('.case-title[data-task="' + currentCaseUid + '"]').length) {
                $('#startTourBtn').hide();
                setSessionStorage('Task Details Page', 'Reply Task');
                var prevId = $('.case-title[data-task="' + currentCaseUid + '"]').parents('.tr_all[id^="curRow"]').attr('id');
                if ($('#' + prevId).prevAll('.tr_all[id^="curRow"]').length) {
                    var nextId = $('#' + prevId).prevAll('.tr_all[id^="curRow"]').attr('id');
                    var nextCaseUid = $('#' + nextId).find('.case-title[id^="titlehtml"]').attr('data-task');
                    easycase.ajaxCaseDetails(nextCaseUid, 'case', 0, 'popup');
                }
            } else {
                return false;
            }
        }
    }
}
}
easycase.showActivities = function() {
    $('#select_view div').tipsy({
        gravity: 'n',
        fade: true
    });
    $('#select_view div').removeClass('disable');
    $('#actvt_btn').addClass('disable');
    $("#caseMenuFilters").val('activities');
    if ($('#activities').html() && refreshActvt == 0) {
        easycase.routerHideShow('activities');
        scrollPageTop();
    } else {
        loadActivity('');
        loadOverdue('my');
        loadUpcoming('my');
    }
}
easycase.showMentionList = function() {
    $('#select_view div').tipsy({
        gravity: 'n',
        fade: true
    });
    $('#select_view div').removeClass('disable');
    $('#actvt_btn').addClass('disable');
    $("#caseMenuFilters").val('activities');
    if ($('#mentioned').html() && refreshActvt == 0) {
        easycase.routerHideShow('mention_list');
        scrollPageTop();
    } else {
        loadMentionList('');
    }
}
function loadMentionList(type) {
    var displayed = $("#display_mention").val();
    var prj_id = $("#projFil").val();
    var limit1, limit2, projid;
    if (type == "more") {
        limit1 = displayed;
        limit2 = 10;
        projid = prj_id;
    } else {
        limit1 = 0;
        limit2 = 29;
        projid = prj_id;
    }
    if (type == "more") {
        $(".morebar").show();
    } else {
        $("#caseLoader").show();
    }
    $("#ajax_mentioned_tmpl").show();
    var strURL = HTTP_ROOT + "users/ajax_mentioned_list/";
    angular.element(document.getElementById('mentionController')).scope().getMentionList(strURL, type, limit1, limit2, projid);
    angular.element(document.getElementById('mentionController')).scope().$apply();
}
function activityDetail(caseNo, cas, no, popup) {
    $("#myModalDetail").modal();
    $(".task_details_popup").show();
    $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
    $("#cnt_task_detail_kb").html("");
    easycase.ajaxCaseDetails(caseNo, cas, no, popup);
}
function validateComments(id, uniqid, legend, ses_type, pid) {
    localStorage.setItem("change_reason_duedt", '');
    var msgid = "txa_comments" + id,
        planetext = "txa_plane" + id,
        html = "html" + id,
        text = "plane" + id;
    var pj = "";
    var msg = "";
    var err = "";
    var is_dtl_pop = (typeof arguments[5] != 'undefined' && arguments[5] == '1') ? 1 : 0;
    if ($('#' + html).is(':visible')) {
        var text = $.trim(tinymce.get(msgid).getContent());
        if (text == "") {
            var err = _("Nothing to post!");
            tinymce.get(msgid).focus();
        } else {}
    } else {
        if (document.getElementById(planetext).value.trim() == "") {
            var err = _("Nothing to post!");
            var msg = $('#' + msgid).val();
            document.getElementById(planetext).focus();
        } else {}
    }
    if (err) {
        if ($('input[id^=' + id + 'jqueryfile]').length) {
            err = '';
        } else {
            if ($('input[id^=' + id + 'jqueryfile]').length) {
                err = '';
                return false;
            } else {
                showTopErrSucc('error', err + _(' Please write a reply or attach a file!'));
                return false;
            }
        }
    }
    if (!err) {
        var status = $('#got_lgnd').data('legent');
        submitAddNewCase('Post', id, uniqid, '', '0', status, legend, pid, '', 'comment');
        if (is_dtl_pop == 1) {
            setTimeout(function() {
                var hashtag = parseUrlHash(urlHash);
                if (hashtag[0] == 'milestonelist') {
                    showMilestoneList();
                } else {
                    easycase.showKanbanTaskList('kanban');
                }
            }, 1000);
        }
        return true;
    }
}

function setTourDetail(caseUniqId) {
    var tour_taskdtl = {
        id: 'hello-hopscotch',
        steps: [{
            target: 'tour_detl_title' + caseUniqId,
            title: _('Task Number'),
            content: _('This is a unique system generated number for each task.'),
            placement: 'bottom',
            yOffset: -2,
            xOffset: -8,
            arrowOffset: 1,
        }, {
            target: 'tour_detl_action' + caseUniqId,
            title: _('Task Actions'),
            content: _('Edit, Delete, Resolve, Close or Download your task.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 70
        }, {
            target: 'tour_detl_status' + caseUniqId,
            title: _('Task Status'),
            content: _('Update your task status here.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 30
        }, {
            target: 'tour_detl_progress' + caseUniqId,
            title: _('Task Progress'),
            content: _('Mark your task progress based on the work you have done so far.'),
            placement: 'bottom',
            yOffset: -2,
            arrowOffset: 70
        }, {
            target: 'tour_detl_infos' + caseUniqId,
            title: _('Task Information'),
            content: _('Know the Task belongs to which Project, Task Group, Task Type, Priority and what is the estimated vs. actual hour spent'),
            placement: 'bottom',
            yOffset: -11,
            arrowOffset: 100
        }, {
            target: 'tour_detl_team' + caseUniqId,
            title: _('Team Members Involved'),
            content: _('Know who is currently assigned and involved in this task.'),
            placement: 'left',
            yOffset: -9,
        }, {
            target: 'tour_detl_srtend' + caseUniqId,
            title: _('Start & End Date'),
            content: _('Quick view of Start, End, Created Date and when your team last worked on the task.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_subtask' + caseUniqId,
            title: _('Subtasks'),
            content: _('Shows the total time spent by different resources with total billable and non-billable hours. Start your timer or log time with Time Entry'),
            placement: 'right',
        }, {
            target: 'tour_detl_tlink' + caseUniqId,
            title: _('Linking Tasks'),
            content: _('Shows the total time spent by different resources with total billable and non-billable hours. Start your timer or log time with Time Entry'),
            placement: 'right',
        }, {
            target: 'tour_detl_reminder' + caseUniqId,
            title: _('Task Reminder'),
            content: _('Shows the total time spent by different resources with total billable and non-billable hours. Start your timer or log time with Time Entry'),
            placement: 'right',
        }, {
            target: 'tour_detl_files' + caseUniqId,
            title: _('Files In This Task'),
            content: _('Easy to find all the files shared in the task'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_comts' + caseUniqId,
            title: _('Comments'),
            content: _('Go through all the comments shared by team members or clients.'),
            placement: 'right',
        }, {
            target: 'tour_detl_activt' + caseUniqId,
            title: _('Activities'),
            content: _('A quick Activities trail of all the actions performed within the task like comments, edit, time logs, modified, status change with real time date and time stamp.'),
            placement: 'left',
            yOffset: -10,
        }, {
            target: 'tour_detl_logs' + caseUniqId,
            title: _('Time Logs'),
            content: _('Shows the total time spent by different resources with total billable and non-billable hours. Start your timer or log time with Time Entry'),
            placement: 'right',
        }, {
            target: 'tour_detl_comt' + caseUniqId,
            title: _('Comment'),
            content: _('Post your comments, update Task Status, add your time log, attach files, assign to the next team member and notify key project personnel.'),
            placement: 'bottom',
            yOffset: -5,
            arrowOffset: 70
        }, ],
        showPrevButton: true,
        scrollTopMargin: 100,
        onEnd: function() {
            removeOnboard();
        },
        onClose: function() {
            removeOnboard();
        }
    };
    var tour_taskdtl_deu = {
        id: 'hello-hopscotch',
        i18n: {
            nextBtn: "Nächster",
            prevBtn: "Zurück",
            doneBtn: "Erledigt",
            skipBtn: "Überspringen",
        },
        steps: [{
            target: 'tour_detl_title' + caseUniqId,
            title: _('Aufgabennummer'),
            content: _('Dies ist eine eindeutige, vom System generierte Nummer für jede Aufgabe.'),
            placement: 'bottom',
            yOffset: -2,
            xOffset: -8,
            arrowOffset: 1,
        }, {
            target: 'tour_detl_action' + caseUniqId,
            title: _('Aufgabenaktionen'),
            content: _('Bearbeiten, löschen, lösen, schließen oder laden Sie Ihre Aufgabe.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 70
        }, {
            target: 'tour_detl_status' + caseUniqId,
            title: _('Aufgabenstatus'),
            content: _('Aktualisieren Sie Ihren Aufgabenstatus hier.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 30
        }, {
            target: 'tour_detl_progress' + caseUniqId,
            title: _('Aufgabenfortschritt'),
            content: _('Markieren Sie Ihren Aufgabenfortschritt anhand der bisher geleisteten Arbeit.'),
            placement: 'bottom',
            yOffset: -2,
            arrowOffset: 70
        }, {
            target: 'tour_detl_infos' + caseUniqId,
            title: _('Informationen zur Aufgabe'),
            content: _('Kennen Sie die Aufgabe, zu der das Projekt, die Aufgabengruppe, der Aufgabentyp, die Priorität und die geschätzte Zeit im Verhältnis zur tatsächlich aufgewendeten Stunde gehört'),
            placement: 'bottom',
            yOffset: -11,
            arrowOffset: 100
        }, {
            target: 'tour_detl_team' + caseUniqId,
            title: _('Beteiligte Teammitglieder'),
            content: _('Erkennen Sie, wer zurzeit zugewiesen ist und an dieser Aufgabe beteiligt ist.'),
            placement: 'left',
            yOffset: -9,
        }, {
            target: 'tour_detl_srtend' + caseUniqId,
            title: _('Start- und Enddatum'),
            content: _('Schnellansicht von Start, Ende, Erstellungsdatum und wann Ihr Team zuletzt an der Aufgabe gearbeitet hat.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_files' + caseUniqId,
            title: _('Dateien in dieser Aufgabe'),
            content: _('Einfach alle Dateien zu finden, die in der Aufgabe freigegeben wurden'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_comts' + caseUniqId,
            title: _('Bemerkungen'),
            content: _('Gehen Sie alle Kommentare durch, die von Teammitgliedern oder Kunden geteilt wurden.'),
            placement: 'right',
        }, {
            target: 'tour_detl_activt' + caseUniqId,
            title: _('Aktivitäten'),
            content: _('Ein schneller Aktivitätenpfad aller Aktionen, die innerhalb der Aufgabe ausgeführt werden, wie Kommentare, Bearbeitungen, Zeitprotokolle, Änderungen, Statusänderungen mit Echtzeitdatum und Zeitstempel.'),
            placement: 'left',
            yOffset: -10,
        }, {
            target: 'tour_detl_logs' + caseUniqId,
            title: _('Zeitprotokolle'),
            content: _('Zeigt die Gesamtzeit an, die von verschiedenen Ressourcen mit insgesamt abrechenbaren und nicht abrechenbaren Stunden verbracht wurde. Starten Sie Ihre Timer- oder Protokollierungszeit mit der Zeiteingabe'),
            placement: 'right',
        }, {
            target: 'tour_detl_comt' + caseUniqId,
            title: _('Kommentar'),
            content: _('Veröffentlichen Sie Ihre Kommentare, aktualisieren Sie den Task-Status, fügen Sie Ihr Zeitprotokoll hinzu, fügen Sie Dateien hinzu, weisen Sie das nächste Teammitglied zu und benachrichtigen Sie das wichtige Projektpersonal.'),
            placement: 'bottom',
            yOffset: -5,
            arrowOffset: 70
        }, ],
        showPrevButton: true,
        scrollTopMargin: 100,
        onEnd: function() {
            removeOnboard();
        },
        onClose: function() {
            removeOnboard();
        }
    };
    var tour_taskdtl_por = {
        id: 'hello-hopscotch',
        i18n: {
            nextBtn: "Próximo",
            prevBtn: "De volta",
            doneBtn: "Feito",
            skipBtn: "Feito",
        },
        steps: [{
            target: 'tour_detl_title' + caseUniqId,
            title: _('Número da Tarefa'),
            content: _('Este é um número gerado pelo sistema exclusivo para cada tarefa.'),
            placement: 'bottom',
            yOffset: -2,
            xOffset: -8,
            arrowOffset: 1,
        }, {
            target: 'tour_detl_action' + caseUniqId,
            title: _('Tarefa Ações'),
            content: _('Edite, apague, resolva, feche ou baixe sua tarefa.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 70
        }, {
            target: 'tour_detl_status' + caseUniqId,
            title: _('Status da Tarefa'),
            content: _('Atualize o status da sua tarefa aqui.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 30
        }, {
            target: 'tour_detl_progress' + caseUniqId,
            title: _('Progresso da Tarefa'),
            content: _('Marque o progresso da sua tarefa com base no trabalho que você realizou até agora.'),
            placement: 'bottom',
            yOffset: -2,
            arrowOffset: 70
        }, {
            target: 'tour_detl_infos' + caseUniqId,
            title: _('Informação da Tarefa'),
            content: _('Conhecer a tarefa pertence a qual projeto, grupo de tarefas, tipo de tarefa, prioridade e qual é a hora estimada versus a hora real'),
            placement: 'bottom',
            yOffset: -11,
            arrowOffset: 100
        }, {
            target: 'tour_detl_team' + caseUniqId,
            title: _('Membros da equipe envolvidos'),
            content: _('Saiba quem está atualmente designado e envolvido nesta tarefa.'),
            placement: 'left',
            yOffset: -9,
        }, {
            target: 'tour_detl_srtend' + caseUniqId,
            title: _('Data de início e término'),
            content: _('Visualização rápida de Início, Fim, Data de Criação e quando sua equipe trabalhou pela última vez na tarefa.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_files' + caseUniqId,
            title: _('Arquivos nesta tarefa'),
            content: _('Fácil de encontrar todos os arquivos compartilhados na tarefa'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_comts' + caseUniqId,
            title: _('Comentários'),
            content: _('Veja todos os comentários compartilhados pelos membros da equipe ou clientes.'),
            placement: 'right',
        }, {
            target: 'tour_detl_activt' + caseUniqId,
            title: _('actividades'),
            content: _('Uma rápida trilha de Atividades de todas as ações realizadas dentro da tarefa, como comentários, edição, registros de tempo, modificação, mudança de status com data e hora em tempo real.'),
            placement: 'left',
            yOffset: -10,
        }, {
            target: 'tour_detl_logs' + caseUniqId,
            title: _('Registros de tempo'),
            content: _('Mostra o tempo total gasto por diferentes recursos com o total de horas faturáveis ​​e não faturáveis. Inicie seu temporizador ou tempo de registro com entrada de hora'),
            placement: 'right',
        }, {
            target: 'tour_detl_comt' + caseUniqId,
            title: _('Comente'),
            content: _('Poste seus comentários, atualize o Status da Tarefa, adicione seu registro de horários, anexe arquivos, atribua ao próximo membro da equipe e notifique o pessoal-chave do projeto.'),
            placement: 'bottom',
            yOffset: -5,
            arrowOffset: 70
        }, ],
        showPrevButton: true,
        scrollTopMargin: 100,
        onEnd: function() {
            removeOnboard();
        },
        onClose: function() {
            removeOnboard();
        }
    };
    var tour_taskdtl_spa = {
        id: 'hello-hopscotch',
        i18n: {
            nextBtn: "Siguiente",
            prevBtn: "Espalda",
            doneBtn: "Hecho",
            skipBtn: "Omitir",
        },
        steps: [{
            target: 'tour_detl_title' + caseUniqId,
            title: _('Número de tarea'),
            content: _('Este es un número único generado por el sistema para cada tarea.'),
            placement: 'bottom',
            yOffset: -2,
            xOffset: -8,
            arrowOffset: 1,
        }, {
            target: 'tour_detl_action' + caseUniqId,
            title: _('Acciones de Tarea'),
            content: _('Edite, elimine, resuelva, cierre o descargue su tarea.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 70
        }, {
            target: 'tour_detl_status' + caseUniqId,
            title: _('Estado de la tarea'),
            content: _('Actualice el estado de su tarea aquí.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 30
        }, {
            target: 'tour_detl_progress' + caseUniqId,
            title: _('Progreso de la tarea'),
            content: _('Marque el progreso de su tarea según el trabajo que haya realizado hasta ahora.'),
            placement: 'bottom',
            yOffset: -2,
            arrowOffset: 70
        }, {
            target: 'tour_detl_infos' + caseUniqId,
            title: _('Información de la tarea'),
            content: _('Sepa qué tarea pertenece a qué proyecto, grupo de tareas, tipo de tarea, prioridad y cuál es la hora estimada vs.'),
            placement: 'bottom',
            yOffset: -11,
            arrowOffset: 100
        }, {
            target: 'tour_detl_team' + caseUniqId,
            title: _('Miembros del equipo involucrados'),
            content: _('Sepa quién está actualmente asignado e involucrado en esta tarea.'),
            placement: 'left',
            yOffset: -9,
        }, {
            target: 'tour_detl_srtend' + caseUniqId,
            title: _('Fecha de inicio y finalización'),
            content: _('Vista rápida de Inicio, Fin, Fecha de creación y cuando su equipo trabajó por última vez en la tarea.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_files' + caseUniqId,
            title: _('Archivos en esta tarea'),
            content: _('Fácil de encontrar todos los archivos compartidos en la tarea.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_comts' + caseUniqId,
            title: _('Comentarios'),
            content: _('Ir a través de todos los comentarios compartidos por los miembros del equipo o clientes.'),
            placement: 'right',
        }, {
            target: 'tour_detl_activt' + caseUniqId,
            title: _('Ocupaciones'),
            content: _('Un rápido seguimiento de actividades de todas las acciones realizadas dentro de la tarea como comentarios, edición, registros de tiempo, modificación, cambio de estado con fecha y hora en tiempo real.'),
            placement: 'left',
            yOffset: -10,
        }, {
            target: 'tour_detl_logs' + caseUniqId,
            title: _('Registros de tiempo'),
            content: _('Muestra el tiempo total empleado por los diferentes recursos con el total de horas facturables y no facturables. Comience su temporizador o tiempo de registro con la entrada de tiempo'),
            placement: 'right',
        }, {
            target: 'tour_detl_comt' + caseUniqId,
            title: _('Comentario'),
            content: _('Publique sus comentarios, actualice el estado de la tarea, agregue su registro de tiempo, adjunte archivos, asigne al siguiente miembro del equipo y notifique al personal clave del proyecto.'),
            placement: 'bottom',
            yOffset: -5,
            arrowOffset: 70
        }, ],
        showPrevButton: true,
        scrollTopMargin: 100,
        onEnd: function() {
            removeOnboard();
        },
        onClose: function() {
            removeOnboard();
        }
    };
    var tour_taskdtl_fra = {
        id: 'hello-hopscotch',
        i18n: {
            nextBtn: "Suivant",
            prevBtn: "Retour",
            doneBtn: "Terminé",
            skipBtn: "Sauter",
        },
        steps: [{
            target: 'tour_detl_title' + caseUniqId,
            title: _('Número da Tarefa'),
            content: _('Este é um número gerado pelo sistema exclusivo para cada tarefa.'),
            placement: 'bottom',
            yOffset: -2,
            xOffset: -8,
            arrowOffset: 1,
        }, {
            target: 'tour_detl_action' + caseUniqId,
            title: _('Tarefa Ações'),
            content: _('Edite, apague, resolva, feche ou baixe sua tarefa.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 70
        }, {
            target: 'tour_detl_status' + caseUniqId,
            title: _('Status da Tarefa'),
            content: _('Atualize o status da sua tarefa aqui.'),
            placement: 'bottom',
            yOffset: -3,
            arrowOffset: 30
        }, {
            target: 'tour_detl_progress' + caseUniqId,
            title: _('Progresso da Tarefa'),
            content: _("Marque o progresso da sua tarefa com base no trabalho que você realizou até agora."),
            placement: 'bottom',
            yOffset: -2,
            arrowOffset: 70
        }, {
            target: 'tour_detl_infos' + caseUniqId,
            title: _('Informação da Tarefa'),
            content: _("Conhecer a tarefa pertence a qual projeto, grupo de tarefas, tipo de tarefa, prioridade e qual é a hora estimada versus a hora real"),
            placement: 'bottom',
            yOffset: -11,
            arrowOffset: 100
        }, {
            target: 'tour_detl_team' + caseUniqId,
            title: _("Membros da equipe envolvidos"),
            content: _("Saiba quem está atualmente designado e envolvido nesta tarefa."),
            placement: 'left',
            yOffset: -9,
        }, {
            target: 'tour_detl_srtend' + caseUniqId,
            title: _('Data de início e término'),
            content: _('Visualização rápida de Início, Fim, Data de Criação e quando sua equipe trabalhou pela última vez na tarefa.'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_files' + caseUniqId,
            title: _('Arquivos nesta tarefa'),
            content: _('Fácil de encontrar todos os arquivos compartilhados na tarefa'),
            placement: 'left',
            yOffset: -5,
        }, {
            target: 'tour_detl_comts' + caseUniqId,
            title: _('Comentários'),
            content: _("Veja todos os comentários compartilhados pelos membros da equipe ou clientes."),
            placement: 'right',
        }, {
            target: 'tour_detl_activt' + caseUniqId,
            title: _('actividades'),
            content: _("Uma rápida trilha de Atividades de todas as ações realizadas dentro da tarefa, como comentários, edição, registros de tempo, modificação, mudança de status com data e hora em tempo real."),
            placement: 'left',
            yOffset: -10,
        }, {
            target: 'tour_detl_logs' + caseUniqId,
            title: _('Registros de tempo'),
            content: _("Mostra o tempo total gasto por diferentes recursos com o total de horas faturáveis ​​e não faturáveis. Inicie seu temporizador ou tempo de registro com entrada de hora"),
            placement: 'right',
        }, {
            target: 'tour_detl_comt' + caseUniqId,
            title: _('Comente'),
            content: _("Poste seus comentários, atualize o Status da Tarefa, adicione seu registro de horários, anexe arquivos, atribua ao próximo membro da equipe e notifique o pessoal-chave do projeto."),
            placement: 'bottom',
            yOffset: -5,
            arrowOffset: 70
        }, ],
        showPrevButton: true,
        scrollTopMargin: 100,
        onEnd: function() {
            removeOnboard();
        },
        onClose: function() {
            removeOnboard();
        }
    };
    if (LANG_PREFIX == '_fra') {
        GBl_tour = tour_taskdtl_fra;
    } else if (LANG_PREFIX == '_por') {
        GBl_tour = tour_taskdtl_por;
    } else if (LANG_PREFIX == '_spa') {
        GBl_tour = tour_taskdtl_spa;
    } else if (LANG_PREFIX == '_deu') {
        GBl_tour = tour_taskdtl_deu;
    } else {
        GBl_tour = tour_taskdtl;
    }
    if (typeof arguments[1] != 'undefined') {
        hopscotch.startTour(GBl_tour);
    }
}
var caseapp = angular.module("case_dashboard_App", ["ngRoute", "ngAnimate", 'angularUtils.directives.dirPagination', 'ngSanitize', 'ui.select', 'xeditable']).provider('moment', function() {
    this.$get = function() {
        return moment
    }
});
caseapp.controller("activity_Controller", function($scope, $sce, $http) {
    $scope.trustAsHtml = function(html) {
        return $sce.trustAsHtml(html);
    };
    $scope.getActivity = function(URL, type, limit1, limit2, projid) {
        var data = $.param({
            type: type,
            limit1: limit1,
            limit2: limit2,
            projid: projid
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(URL, data, config).success(function(data, status, headers, config) {
            if (type == "more") {
                $(".morebar").hide();
                $("#PieChart").show();
                $("#displayed").val(parseInt($("#displayed").val()) + parseInt(10));
                for (var i = 0; i < data.activity.length; i++)
                    $scope.activity_records.push(data.activity[i]);
            } else {
                $scope.activity_records = data.activity;
                $scope.activity_total = data.total;
                easycase.routerHideShow('activities');
                refreshActvt = 0;
                var params = parseUrlHash(urlHash);
                if (params[0] != "activities") {
                    parent.location.hash = "activities";
                }
                $("#caseLoader").hide();
                if (data.activity.length > 0) {
                    $("#PieChart").show();
                    $http.post(HTTP_ROOT + 'users/activity_pichart', $.param({
                        'pjid': projid
                    }), config).success(function(piedata, status, headers, config) {
                        var piedata = piedata;
                        $('#piechart').highcharts({
                            credits: {
                                enabled: false
                            },
                            chart: {
                                type: 'pie',
                                height: 270
                            },
                            title: {
                                text: ''
                            },
                            yAxis: {
                                title: {
                                    text: ''
                                }
                            },
                            plotOptions: {
                                pie: {
                                    shadow: false,
                                    center: ['50%', '50%'],
                                    showInLegend: true,
                                    dataLabels: {
                                        distance: -30,
                                        color: 'white'
                                    }
                                }
                            },
                            tooltip: {
                                formatter: function() {
                                    return '<b>' + this.point.name + '</b>: ' + parseFloat(this.y) + ' %';
                                }
                            },
                            series: [{
                                name: '# of Tasks Report',
                                data: eval(piedata),
                                size: '110%',
                                innerSize: '50%',
                                dataLabels: {
                                    formatter: function() {
                                        return this.y > 1 ? this.y + '%' : null;
                                    }
                                }
                            }]
                        });
                    });
                }
            }
        }).error(function(data, status, headers, config) {});
    }
    $scope.setcurrent = function(d, i) {
        var ddate = d[i][0].ddate;
        if (typeof $scope.easycaseArr == "undefined") {
            $scope.easycaseArr = new Array();
        }
        if (typeof $scope.statusCount == "undefined") {
            $scope.statusCount = new Array();
        }
        $scope.statusCount[ddate] = (typeof $scope.statusCount[ddate] != "undefined") ? $scope.statusCount[ddate] : {
            'v_new': 0,
            'v_replied': 0,
            'v_resolved': 0,
            'v_closed': 0
        };
        $scope.easycase_caseno_projId = d[i].Easycase.case_no + "_" + d[i].Easycase.project_id;
        if (i != 0 && d[i].Easycase.lastDate != d[i - 1].Easycase.lastDate) {
            $scope.easycaseArr = new Array();
            $scope.statusCount[ddate] = {
                'v_new': 0,
                'v_replied': 0,
                'v_resolved': 0,
                'v_closed': 0
            };
        }
        if ($.inArray($scope.easycase_caseno_projId, $scope.easycaseArr) == -1) {
            if (d[i].Easycase.istype == 1) {
                d[i].Easycase.legend = 1;
            }
            $scope.easycaseArr.push($scope.easycase_caseno_projId);
        } else {
            if (d[i].Easycase.istype == 1) {
                d[i].Easycase.legend = 1;
            }
        }
        if (d[i].Easycase.legend == 1) {
            $scope.statusCount[ddate].v_new = $scope.statusCount[ddate].v_new + 1;
        } else if (d[i].Easycase.legend == 2 || d[i].Easycase.legend == 4) {
            $scope.statusCount[ddate].v_replied = $scope.statusCount[ddate].v_replied + 1;
        } else if (d[i].Easycase.legend == 3 || d[i].Easycase.legend == 5) {
            $scope.statusCount[ddate].v_closed = $scope.statusCount[ddate].v_closed + 1;
        }
    }
    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
        $("img.lazy").lazyload({
            placeholder: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        });
    });
});
caseapp.controller("mention_Controller", function($scope, $sce, $http) {
    $scope.trustAsHtml = function(html) {
        return $sce.trustAsHtml(html);
    };
    $scope.getMentionList = function(URL, type, limit1, limit2, projid) {
        var data = $.param({
            type: type,
            limit1: limit1,
            limit2: limit2,
            projid: projid
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(URL, data, config).success(function(data, status, headers, config) {
            if (type == "more") {
                $(".morebar").hide();
                $("#display_mention").val(parseInt($("#display_mention").val()) + parseInt(10));
                for (var i = 0; i < data.activity.length; i++)
                    $scope.mention_records.push(data.activity[i]);
            } else {
                $scope.mention_records = data.activity;
                $scope.mention_total = data.total;
                easycase.routerHideShow('mentioned_list');
                refreshActvt = 0;
                var params = parseUrlHash(urlHash);
                if (params[0] != "mention_list") {
                    parent.location.hash = "mentioned_list";
                }
                $("#caseLoader").hide();
            }
        }).error(function(data, status, headers, config) {});
    }
    $scope.setcurrent = function(d, i) {
        var ddate = d[i][0].ddate;
        if (typeof $scope.easycaseArr == "undefined") {
            $scope.easycaseArr = new Array();
        }
    }
    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
        $("img.lazy").lazyload({
            placeholder: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        });
    });
});
caseapp.directive('onFinishRender', ['$timeout', '$parse', function($timeout, $parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function() {
                    scope.$emit(attr.broadcasteventname ? attr.broadcasteventname : 'ngRepeatFinished');
                    if (!!attr.onFinishRender) {
                        $parse(attr.onFinishRender)(scope);
                    }
                });
            }
        }
    }
}]);
caseapp.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
caseapp.controller("overdue_Controller", function($scope, $http) {
    $scope.loadOverdue = function(type) {
        var data = $.param({
            type: type,
            angular: 1,
            projid: $("#projFil").val()
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "users/ajax_overdue/", data, config).success(function(data, status, headers, config) {
            $scope.overdue_records = data;
            $("#moreOverdueloader").hide();
        });
    }
});
caseapp.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
    $routeProvider.when('/timelog', {
        templateUrl: HTTP_ROOT + 'angular_templates/timelog.html?v=' + RELEASE,
        controller: 'timelogController'
    }).when('/chart_timelog', {
        templateUrl: HTTP_ROOT + 'angular_templates/timelog_chart.html?v=' + RELEASE,
        controller: 'timelogChartController'
    }).when('/timesheet', {
        templateUrl: HTTP_ROOT + 'angular_templates/timesheet_daily.html?v=' + RELEASE,
        controller: 'timesheetDailyController'
    }).when('/timesheet_weekly', {
        templateUrl: HTTP_ROOT + 'angular_templates/timesheet_weekly.html?v=' + RELEASE,
        controller: 'timesheetWeeklyController'
    });
    $locationProvider.hashPrefix("");
}]);
caseapp.filter('propsFilter', function() {
    return function(items, props) {
        var out = [];
        if (angular.isArray(items)) {
            items.forEach(function(item) {
                var itemMatches = false;
                var keys = Object.keys(props);
                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }
                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            out = items;
        }
        return out;
    }
});
caseapp.controller('timesheetDailyController', function($scope, $http, $interval, $timeout) {
    $scope.projects = {};
    $scope.projectM = {};
    $scope.taskM = {};
    $scope.week = {};
    $scope.usersnames = {};
    $scope.logs = {};
    $scope.disable_save_all = true;
    $scope.enable_qtask_link = false;
    $scope.project_selected = false;
    $scope.getAllProjects = function() {
        var params_data = $.param({});
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "LogTimes/showAllProjects", params_data, config).success(function(data, status, headers, config) {
            $scope.projects = data.Projects;
        });
    }
    $scope.ShowQt = function() {
        $scope.enable_qtask_link = true;
    }
    $scope.HideQt = function() {
        $scope.enable_qtask_link = false;
    }
    $scope.getAllProjects();
    $scope.initMask = function() {
        $('.hr_maxwth').mask('00:M0', {
            translation: {
                'M': {
                    pattern: /[0-5]/
                },
            }
        });
    }
    $scope.isAllowed = function(action) {
        return isAllowed(action);
    }
    $scope.openTimesheetExportPopup = function(userid, prevDate, nextDate) {
        if (prevDate != '') {
            prevDate = moment(prevDate, "YYYY-MM-DD").add(1, 'days').format('YYYY-MM-DD');
        }
        if (nextDate != '') {
            nextDate = moment(nextDate, "YYYY-MM-DD").subtract(1, 'days').format('YYYY-MM-DD');
        }
        openTimesheetExportPopup(userid, prevDate, nextDate);
    }
    $scope.get_timesheet_daily = function(d, type, curent_date, obj) {
        if (SES_TYPE > 2 && !isAllowed('View All Timelog')) {
            $('#daily_user_menu').hide();
        }
        $scope.HTTP_ROOT = HTTP_ROOT;
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (typeof d != 'undefined') {
            $scope.date = d;
            if (moment($scope.date, "YYYY-MM-DD").startOf('week').format('YYYY-MM-DD') == $scope.date && typeof type != "undefined") {
                $scope.date = moment($scope.date, "YYYY-MM-DD").add(-1, 'days').format("YYYY-MM-DD");
            }
        } else {
            $scope.date = moment().format("YYYY-MM-DD");
        }
        $scope.selected_day = $scope.date;
        $scope.current_day = moment().format("YYYY-MM-DD");
        if (moment($scope.date, "YYYY-MM-DD").startOf('week').format('YYYY-MM-DD') != $scope.date) {
            $scope.prevday = moment($scope.date, "YYYY-MM-DD").startOf('week').format('YYYY-MM-DD');
        $scope.week.Monday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 1).format('YYYY-MM-DD');
        $scope.week.Tuesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 2).format('YYYY-MM-DD');
        $scope.week.Wednesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 3).format('YYYY-MM-DD');
        $scope.week.Thursday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 4).format('YYYY-MM-DD');
        $scope.week.Friday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 5).format('YYYY-MM-DD');
        $scope.week.Saturday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 6).format('YYYY-MM-DD');
            $scope.week.Sunday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 7).format('YYYY-MM-DD');
        }
        $('#caseLoader').show();
        params = {};
        params.currentdate = $scope.date;
        params.angular = 1;
        if (typeof type == 'undefined') {
            params.curent_selected_date = '';
            params.type = '';
        } else {
            params.type = type;
            params.curent_selected_date = curent_date;
        }
        if (typeof obj != 'undefined' || typeof d != 'undefined') {
            params.usrid = $scope.usersnames.userselectedOption.id;
        } else {
            params.usrid = '';
        }
        var params_data = $.param(params);
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $('#timesheet_top_bar').show();
        $('.tg_calendar-bar').show();
        $scope.project_selected = !1;
        $scope.enable_qtask_link = !1;
        urlHash = getHash();
        easycase.routerHideShow('timesheet');
        $http.post(HTTP_ROOT + "LogTimes/timesheet_daily", params_data, config).success(function(data, status, headers, config) {
            $('#caseLoader').hide();
            $('.hidetablelog').hide();
            $scope.logs = data.logtimes;
            if ($scope.logs.length == 0) {
                $('.timesheettogl.togl').show();
                $('.timesheettogl.no-hover').hide();
                $scope.initMask();
                tinymce.init({
                    selector: "textarea",
                    plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
                    menubar: false,
                    branding: false,
                    statusbar: false,
                    toolbar: 'bold italic underline strikethrough | numlist bullist fullscreen',
                    toolbar_sticky: true,
                    importcss_append: true,
                    image_caption: true,
                    browser_spellcheck: true,
                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
                    toolbar_drawer: 'sliding',
                    resize: false,
                    height: 160,
                    max_height: 200,
                    paste_data_images: false,
                    paste_as_text: true,
                    autoresize_on_init: true,
                    autoresize_bottom_margin: 20,
                    content_css: HTTP_ROOT + 'css/tinymce.css',
                    setup: function(ed) {
                        ed.on('Click', function(ed, e) {});
                        ed.on('KeyUp', function(ed, e) {});
                        ed.on('Change', function(ed, e) {});
                        ed.on('init', function(e) {});
                    }
                });
            } else {
                $('.timesheettogl.togl').hide();
                $('.timesheettogl.no-hover').show();
            }
            if (tinymce.editors.length) {
                for (var i = 0; i < tinymce.editors.length; i++) {
                    tinymce.editors[i].setContent("");
                }
            }
            $scope.nextday = data.nextday;
            $scope.prevday = data.prevday;
            $scope.selected_day = data.selected_day;
            $scope.selected_date = data.selected_date;
            $scope.usersnames_all = data.users;
            $scope.projects = data.projects;
            $scope.projectM.selected = '';
            $scope.taskM.selected = '';
            $scope.usersnames.userselectedOption = data.userselectedOption;
            $('.r-u-link').hide();
            if (SES_TYPE < 3) {
                $('.r-u-link').show();
            }
            if (localStorage.getItem("tour_type") == '4') {
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_tandresrc + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_tandresrc;
                }
                hopscotch.startTour(GBl_tour, 3);
            }
        });
    }
    $scope.get_timesheet_daily();
    $scope.setTimepicker = function(obj) {
        $(obj).find('.starttime').timepicker();
        $(obj).find('.endtime').timepicker();
        $(obj).find('.breaktime').mask('00:M0', {
            translation: {
                'M': {
                    pattern: /[0-5]/
                },
            }
        });
    }
    $scope.updatehrs = function(obj) {
        var regex = /^([1-9]|1[0-2]):([0-5]\d)\s?(AM|PM)?$/i;
        if ($(obj).find('.starttime').val().match(regex) && $(obj).find('.endtime').val().match(regex)) {
            var st_time = $(obj).find('.starttime').val();
            var st_tmsp = '0';
            var st_timespl = '0';
            var st_timesplit = '0';
            var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
            st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm', '') : st_time.replace('am', '');
            st_tmsp = st_time.split(":");
            if (st_mode == 'pm') {
                st_timespl = (st_tmsp[0] < 12) ? parseInt(st_tmsp[0]) + 12 : 12;
            } else {
                st_timespl = (st_tmsp[0] == 12) ? "00" : st_tmsp[0];
            }
            st_timesplit = st_timespl + ":" + st_tmsp[1];
            st_time_minute = (parseInt(st_timespl) * 60) + parseInt(st_tmsp[1]);
            var en_time = $(obj).find('.endtime').val();
            var en_tmsp = '';
            var en_timesplit = '';
            var en_timespl = '';
            var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
            en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm', '') : en_time.replace('am', '');
            en_tmsp = en_time.split(":");
            if (en_mode == 'pm') {
                en_timespl = (en_tmsp[0] < 12) ? parseInt(en_tmsp[0]) + 12 : 12;
            } else {
                en_timespl = (en_tmsp[0] == 12) ? "00" : en_tmsp[0];
            }
            en_timesplit = en_timespl + ":" + en_tmsp[1];
            var en_time_minute = (parseInt(en_timespl) * 60) + parseInt(en_tmsp[1]);
            if (st_time_minute <= en_time_minute) {} else {
                en_time_minute = en_time_minute + 1440;
            }
            var spend_duration = en_time_minute - st_time_minute;
            diffinmins = spend_duration;
            diffhours = Math.floor(diffinmins / 60);
            diffmins = (diffinmins % 60);
            var final_spend = (diffhours) + ':' + (diffmins > 9 ? diffmins : '0' + diffmins);
            if ($scope.calculate_break(obj, final_spend)) {
                $scope.hidePopover('custom-popover');
            }
        } else {
            if (!$(obj).find('.starttime').val().match(regex)) {
                showTopErrSucc('error', _('Invalid time format'));
                setTimeout(function() {
                    $(obj).find('.starttime').focus();
                }, 10);
                $(obj).find('.starttime').val('');
                return false;
            }
            if (!$(obj).find('.endtime').val().match(regex)) {
                showTopErrSucc('error', _('Invalid time format'));
                setTimeout(function() {
                    $(obj).find('.endtime').focus();
                }, 10);
                $(obj).find('.endtime').val('');
                return false;
            }
        }
    }
    $scope.calculate_break = function(obj, final_spend) {
        $(obj).find('.breaktime').val($(obj).find('.breaktime').val().replace(/[^\d\:\.]+/g, ''));
        var break_time = $.trim($(obj).find('.breaktime').val()) != '' ? $.trim($(obj).find('.breaktime').val().replace('-', '')) : '0';
        var spend_time = $.trim(final_spend);
        var br_hr = '00';
        var br_min = '00';
        var br_time = '';
        var extra_hr = '';
        if (break_time.indexOf('.') > '-1') {
            br_time = isNaN(break_time) ? 0 : break_time * 60;
            br_hr = Math.floor(br_time / 60);
            br_min = Math.floor(br_time % 60);
        } else if (break_time.indexOf(':') > '-1') {
            br_time = break_time.split(':');
            extra_hr = (br_time[1] == '') ? 0 : Math.floor(parseInt(br_time[1]) / 60);
            br_hr = (br_time[0] == '') ? 0 : (parseInt(br_time[0]) + parseInt(extra_hr));
            br_min = (br_time[1] == '') ? 0 : Math.floor(br_time[1] % 60);
        } else {
            br_hr = break_time;
            br_min = '0';
        }
        var sp_time = spend_time.split(':');
        var total_sp_min = (parseInt(sp_time[0]) * 60) + parseInt(sp_time[1]);
        var total_br_min = (parseInt(br_hr) * 60) + parseInt(br_min);
        var spend_duration = total_sp_min - total_br_min;
        var sp_hr = Math.floor(spend_duration / 60);
        var sp_min = Math.floor(spend_duration % 60);
        var final_sp = parseInt(sp_hr) > 0 || parseInt(sp_min) > 0 ? parseInt(sp_hr) + ':' + (sp_min < 10 ? "0" : "") + sp_min : '0:00';
        if (total_sp_min < total_br_min) {
            showTopErrSucc('error', _('Break time can not exceed the total spent hours.'));
            $(obj).find('.breaktime').val('');
            return false;
        } else if (total_sp_min == total_br_min) {
            showTopErrSucc('error', _('Break time can not same as the total spent hours.'));
            $(obj).find('.breaktime').val('');
            return false;
        } else {
            var final_br = parseInt(br_hr) > 0 || parseInt(br_min) > 0 ? (br_hr < 10 ? "0" : "") + br_hr + ':' + (br_min < 10 ? "0" : "") + br_min : '';
            $scope.hours = final_sp;
            $(obj).find('.breaktime').val(final_br);
            return true;
        }
    }
    $scope.showPopover = function(clss) {
        $('#' + clss).slideToggle();
        $scope.setTimepicker('#' + clss);
    }
    $scope.hidePopover = function(clss) {
        $('#' + clss).slideUp();
    }
    $scope.clearTimeRange = function(clss) {
        $scope.start_time = '';
        $scope.end_time = '';
        $scope.break_time = '';
        $('#' + clss).slideUp();
    }
    $scope.showeditTimeRange = function(i) {
        $("#ng-popover-trigger_edit" + i).show();
        if (tinymce.editors.length) {
            for (var i = 0; i < tinymce.editors.length; i++) {
                tinymce.editors[i].remove();
            }
        }
        tinymce.init({
            selector: "textarea",
            plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
            menubar: false,
            branding: false,
            statusbar: false,
            toolbar: 'bold italic underline strikethrough | numlist bullist fullscreen',
            toolbar_sticky: true,
            importcss_append: true,
            image_caption: true,
            browser_spellcheck: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
            toolbar_drawer: 'sliding',
            resize: false,
            min_height: 160,
            max_height: 200,
            paste_data_images: false,
            paste_as_text: true,
            autoresize_on_init: true,
            autoresize_bottom_margin: 20,
            content_css: HTTP_ROOT + 'css/tinymce.css',
            setup: function(ed) {
                ed.on('Click', function(ed, e) {});
                ed.on('KeyUp', function(ed, e) {});
                ed.on('Change', function(ed, e) {});
                ed.on('init', function(e) {});
            }
        });
        if (tinymce.editors.length) {
            for (var i = 0; i < tinymce.editors.length; i++) {
                tinymce.editors[i].setContent("");
            }
        }
    }
    $scope.hideeditTimeRange = function(i) {
        $("#ng-popover-trigger_edit" + i).hide();
    }
    $scope.getTotalLog = function() {
        var total = 0;
        var tot_min = 0;
        var min = 0;
        for (var i = 0; i < $scope.logs.length; i++) {
            if ($scope.logs[i].LogTime.total_hours.indexOf(":") != -1) {
                var t_exp = $scope.logs[i].LogTime.total_hours.split(':');
                total += parseInt(t_exp[0]);
                tot_min += parseInt(t_exp[1]);
            } else {
                total += parseInt($scope.logs[i].LogTime.total_hours);
            }
        }
        min = tot_min;
        if (tot_min != 0 && tot_min > 59) {
            total += parseInt(tot_min / 60);
            min = (tot_min % 60);
        }
        total = total + ':' + min;
        return $scope.padFormat(total);
    }
    $scope.updateButton = function() {
        if ($scope.hours.trim() != '') {
            if ($scope.hours.trim().indexOf(":") != -1) {
                arr = $scope.hours.trim().split(":");
            } else {
                arr = $scope.hours.trim().split(".");
            }
            if (arr[0] >= 24) {
                $('#btnSave').show();
                $('#btnTimer').hide();
            } else {
                $('#btnTimer').hide();
                $('#btnSave').show();
            }
        } else {
            $('#btnSave').show();
            $('#btnTimer').hide();
        }
    }
    $scope.changeVal = function(e, s, data) {
        var err_msg = _("The time format should be in hh:mm and take at max of 23:59 hours");
        e1 = data;
        if (e1.trim() != '') {
            var inpt = e1.trim();
            var char_restirict = /^[0-9\:]+$/.test(inpt);
            if (!char_restirict) {
                var st_t = inpt.substr(0, inpt.length - 1);
                inpt = st_t;
                showTopErrSucc('error', err_msg);
                return "Invalid time";
            }
            var t_inpt = inpt.split(":");
            var d_inpt = inpt.split(".");
            var len = t_inpt.length - 1;
            var d_len = d_inpt.length - 1;
            if (t_inpt[0].trim() == '') {
                showTopErrSucc('error', err_msg);
                return "Invalid time";
            }
            if (len >= 2 || d_len >= 2 || (len & d_len)) {
                showTopErrSucc('error', err_msg);
                return "Invalid time";
            } else {
                if (len > 0 || d_len > 0) {
                    var c_ln = 0;
                    var d_ln = 0;
                    if (inpt.indexOf(":") != -1) {
                        var sec_part = inpt.substr(inpt.indexOf(":") + 1);
                        c_ln = sec_part.length;
                        var first_part = inpt.substr(0, inpt.indexOf(":"));
                    }
                    if (inpt.indexOf(".") != -1) {
                        var dsec_part = inpt.substr(inpt.indexOf(".") + 1);
                        d_ln = dsec_part.length;
                    }
                    if (c_ln > 2 || d_ln > 2) {
                        showTopErrSucc('error', err_msg);
                        return _("Invalid time");
                    }
                    if (sec_part > 59) {
                        showTopErrSucc('error', err_msg);
                        return _("Invalid time");
                    }
                    if (first_part > 23) {
                        showTopErrSucc('error', err_msg);
                        return _("Invalid time");
                    }
                }
                if (inpt.indexOf(":") == -1 && inpt > 23) {
                    $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', err_msg);
                    return _("Invalid time");
                }
            }
        }
    }
    $scope.getProjectTasks = function() {
        if (typeof $scope.projectM.selected != 'undefined') {
            $scope.HTTP_ROOT = HTTP_ROOT;
            $('.loader_bg_inline').show();
            params = {};
            params.project_id = $scope.projectM.selected.id;
            params.angular = 1;
            params.usrid = $scope.usersnames.userselectedOption.id;
            params.date = $scope.selected_date;
            var params_data = $.param(params);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/getProjectTasks", params_data, config).success(function(data, status, headers, config) {
                $('.loader_bg_inline').hide();
                $('.hidetablelog').hide();
                $scope.tasks = data.Tasks;
                $scope.taskM.selected = '';
            });
            $scope.project_selected = !0;
        } else {
            $scope.project_selected = !1;
        }
    }
    $scope.addQuickTask = function() {
        var title = trim($scope.quick.Title);
        var prj_id = $scope.projectM.selected.id;
        var mid = '';
        var type = 'inline';
        var assign_to = 'inline';
        var view_type = 'daily_time_sheet';
        var task_type = '';
        var story_point = '';
        var estimated = '';
        var due_date = '';
        var user_id = $scope.usersnames.userselectedOption.id;
        if (empty(title)) {
            showTopErrSucc('error', _('Please Enter Task Title.'));
            return false;
        }
        $('.loader_bg_inline').show();
        $.post(HTTP_ROOT + "easycases/quickTask", {
            'title': title,
            'project_id': prj_id,
            'type': 'inline',
            'mid': mid,
            'view_type': view_type,
            'task_type': task_type,
            'story_point': story_point,
            'assign_to': user_id,
            'estimated': estimated,
            'due_date': due_date,
        }, function(res) {
            $('.loader_bg_inline').hide();
            if (res.error) {
                showTopErrSucc('error', res.msg);
                return false;
            } else {
                showTopErrSucc('success', _('Task posted successfully.'));
                $scope.quick.Title = '';
                $scope.HideQt();
                $scope.getProjectTasks();
                $("#searchTaskArea").find('span')[0].click();
            }
            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
            var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
            var event_name = sessionStorage.getItem('SessionStorageEventValue');
            if (eventRefer && event_name) {
                trackEventLeadTracker(event_name, eventRefer, sessionEmail);
            }
            if (client) {
                client.emit('iotoserver', res.iotoserver);
            }
        }, 'json');
    }
    $scope.saveTimesheet = function() {
        if (typeof $scope.projectM.selected != 'undefined') {
            $('.timesheettogl.togl').hide();
            $('.timesheettogl.no-hover').show();
            $scope.HTTP_ROOT = HTTP_ROOT;
            $('#caseLoader').show();
            var done = 1;
            var project_id = (typeof $scope.projectM.selected == 'undefined') ? '' : (typeof $scope.projectM.selected.id != 'undefined') ? $scope.projectM.selected.id : '';
            var task_id = (typeof $scope.taskM.selected == 'undefined') ? '' : (typeof $scope.taskM.selected.id != 'undefined') ? $scope.taskM.selected.id : '';
            var hrs = (typeof $scope.hours == 'undefined') ? '' : $scope.hours;
            if (hrs == '') {
                showTopErrSucc('error', _("Oops! you have not entered hours!"));
                done = 0;
            }
            if (task_id == '') {
                showTopErrSucc('error', _("Oops! you have not select a task!"));
                done = 0;
            }
            if (project_id == '') {
                showTopErrSucc('error', _("Oops! you have not select a project!"));
                done = 0;
            }
            $scope.note = tinymce.get('mgm').getContent();
            var note = (typeof $scope.note == 'undefined') ? '' : $scope.note;
            var is_billable = (typeof $scope.is_billable == 'undefined') ? 0 : $scope.is_billable;
            var task_date = $scope.selected_date;
            if (done == 0) {
                $('#caseLoader').hide();
                return false;
            }
            params = {};
            params.project_id = project_id;
            params.task_id = task_id;
            params.hrs = hrs;
            params.note = note;
            params.is_billable = is_billable;
            params.task_date = task_date;
            params.angular = 1;
            params.timesheet_flag = 1;
            params.start_time = $scope.start_time;
            params.end_time = $scope.end_time;
            params.break_time = $scope.break_time;
            params.usrid = $scope.usersnames.userselectedOption.id;
            var params_data = $.param(params);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/saveTimesheet", params_data, config).success(function(data, status, headers, config) {
                $('#caseLoader').hide();
                $('.hidetablelog').hide();
                $scope.hours = '';
                $scope.note = '';
                tinymce.get('mgm').setContent('');
                $scope.start_time = '';
                $scope.end_time = '';
                $scope.break_time = '';
                if (data.success == 'depend') {
                    showTopErrSucc('error', data.message);
                } else if (data.success == 'err') {
                    showTopErrSucc('error', data.message);
                } else {
                    data.logs.LogTime.total_hours = $scope.padFormat(data.logs.LogTime.total_hours);
                    data.logs.LogTime.task_uniqid = data.task_id;
                    $scope.logs.push(data.logs);
                    showTopErrSucc('success', _('Time Logged successfully'));
                }
            });
        } else {
            showTopErrSucc('error', _("Oops! you have not select a project!"));
        }
    }
    $scope.toggleAddLog = function() {
        $scope.projectM.selected = {};
        $scope.taskM.selected = {};
        $scope.project_selected = !1;
        $scope.enable_qtask_link = !1;
        $("#isBillable").prop('checked', false);
        $("#ngh,#mgm").val('');
        $('.timesheettogl').toggle();
        $('[data-toggle="popover"]').popover();
        if (tinymce.get('mgm') != 'undefined') {
            tinymce.execCommand('mceRemoveControl', true, 'mgm');
        }
        tinymce.init({
            selector: "#mgm",
            plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
            menubar: false,
            branding: false,
            statusbar: false,
            toolbar: 'bold italic underline strikethrough | numlist bullist fullscreen',
            toolbar_sticky: true,
            importcss_append: true,
            image_caption: true,
            browser_spellcheck: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
            toolbar_drawer: 'sliding',
            resize: false,
            min_height: 160,
            max_height: 200,
            paste_data_images: false,
            paste_as_text: true,
            autoresize_on_init: true,
            autoresize_bottom_margin: 20,
            content_css: HTTP_ROOT + 'css/tinymce.css',
            setup: function(ed) {
                ed.on('Click', function(ed, e) {});
                ed.on('KeyUp', function(ed, e) {});
                ed.on('Change', function(ed, e) {});
                ed.on('init', function(e) {});
            }
        });
    };
    $scope.displayTaskDetails = function(uniqid) {
        var caseUniqId = uniqid;
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    };
    $scope.padFormat = function(d) {
        arr = d.split(":");
        hrs = (typeof arr[0] != 'undefined') ? arr[0] : '00';
        mins = (typeof arr[1] != 'undefined') ? arr[1] : '00';
        hrs = (hrs.length == 1) ? '0' + hrs.toString() : hrs.toString().slice(-2);
        mins = (mins.length == 1) ? '0' + mins.toString() : mins.toString().slice(-2);
        return hrs + ":" + mins;
    }
    $scope.activateBtn = function() {
        var project_id = (typeof $scope.projectM.selected == 'undefined') ? '' : (typeof $scope.projectM.selected.id != 'undefined') ? $scope.projectM.selected.id : '';
        var task_id = (typeof $scope.taskM.selected == 'undefined') ? '' : (typeof $scope.taskM.selected.id != 'undefined') ? $scope.taskM.selected.id : '';
        var hrs = (typeof $scope.hours == 'undefined') ? '' : $scope.hours;
        if (hrs != '') {
            if (hrs.indexOf(":") != -1) {
                arr = hrs.split(":");
            } else {
                arr = hrs.split(".");
            }
            if (arr[0] >= 24) {
                $('#ngh').addClass('eborder');
            } else {
                $('#ngh').removeClass('eborder');
            }
        }
        if (project_id != '' && task_id != '' && hrs != '') {
            if (hrs.indexOf(":") != -1) {
                arr = hrs.split(":");
            } else {
                arr = hrs.split(".");
            }
            if (arr[0] >= 24) {
                $("#btnSave").addClass('loginactive');
                $scope.disable_save_all = 1;
            } else {
                $("#btnSave").removeClass('loginactive');
                $scope.disable_save_all = 0;
            }
        } else {
            $("#btnSave").addClass('loginactive');
            $scope.disable_save_all = 1;
        }
    }
});
caseapp.controller('EditableRowCtrl', function($scope, $filter, $http) {
    $scope.projects = {};
    $scope.projectM = {};
    $scope.taskM = {};
    $scope.tasks = {};
    $scope.showBillable = function(log) {
        var text_t_show = 'Billable';
        if (log.LogTime.is_billable == 1) {
            log.LogTime.is_billable = true;
            var text_t_show = '<i class="material-icons tick_mark">&#xE834;</i>'
        } else {
            log.LogTime.is_billable = false;
            var text_t_show = '<i class="material-icons cross_mark">&#xE5CD;</i>'
        }
        return text_t_show;
    };
    $scope.checkName = function(data, id) {
        if (id === 2 && data !== 'awesome') {
            return "Username 2 should be `awesome`";
        }
    };
    $scope.setTimepicker = function(obj) {
        $(obj).find('.starttime').timepicker();
        $(obj).find('.endtime').timepicker();
        if (SES_TIME_FORMAT == 24) {
            $(obj).find('.starttime').timepicker({
                'timeFormat': 'H:i'
            });
            $(obj).find('.endtime').timepicker({
                'timeFormat': 'H:i'
            });
        }
        $(obj).find('.breaktime').mask('00:M0', {
            translation: {
                'M': {
                    pattern: /[0-5]/
                },
            }
        });
    }
    $scope.updatehrs = function(obj, index) {
        var regex = /^([1-9]|1[0-2]):([0-5]\d)\s?(AM|PM)?$/i;
        if ($(obj).find('.starttime').val().match(regex) && $(obj).find('.endtime').val().match(regex)) {
            var st_time = $(obj).find('.starttime').val();
            var st_tmsp = '0';
            var st_timespl = '0';
            var st_timesplit = '0';
            var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
            st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm', '') : st_time.replace('am', '');
            st_tmsp = st_time.split(":");
            if (st_mode == 'pm') {
                st_timespl = (st_tmsp[0] < 12) ? parseInt(st_tmsp[0]) + 12 : 12;
            } else {
                st_timespl = (st_tmsp[0] == 12) ? "00" : st_tmsp[0];
            }
            st_timesplit = st_timespl + ":" + st_tmsp[1];
            st_time_minute = (parseInt(st_timespl) * 60) + parseInt(st_tmsp[1]);
            var en_time = $(obj).find('.endtime').val();
            var en_tmsp = '';
            var en_timesplit = '';
            var en_timespl = '';
            var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
            en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm', '') : en_time.replace('am', '');
            en_tmsp = en_time.split(":");
            if (en_mode == 'pm') {
                en_timespl = (en_tmsp[0] < 12) ? parseInt(en_tmsp[0]) + 12 : 12;
            } else {
                en_timespl = (en_tmsp[0] == 12) ? "00" : en_tmsp[0];
            }
            en_timesplit = en_timespl + ":" + en_tmsp[1];
            var en_time_minute = (parseInt(en_timespl) * 60) + parseInt(en_tmsp[1]);
            if (st_time_minute <= en_time_minute) {} else {
                en_time_minute = en_time_minute + 1440;
            }
            var spend_duration = en_time_minute - st_time_minute;
            diffinmins = spend_duration;
            diffhours = Math.floor(diffinmins / 60);
            diffmins = (diffinmins % 60);
            var final_spend = (diffhours) + ':' + (diffmins > 9 ? diffmins : '0' + diffmins);
            if ($scope.calculate_break(obj, final_spend)) {
                $scope.hidePopover('custom-popover' + index);
            }
        } else {
            if (!$(obj).find('.starttime').val().match(regex)) {
                showTopErrSucc('error', _('Invalid time format'));
                setTimeout(function() {
                    $(obj).find('.starttime').focus();
                }, 10);
                $(obj).find('.starttime').val('');
                return false;
            }
            if (!$(obj).find('.endtime').val().match(regex)) {
                showTopErrSucc('error', _('Invalid time format'));
                setTimeout(function() {
                    $(obj).find('.endtime').focus();
                }, 10);
                $(obj).find('.endtime').val('');
                return false;
            }
        }
    }
    $scope.calculate_break = function(obj, final_spend) {
        $(obj).find('.breaktime').val($(obj).find('.breaktime').val().replace(/[^\d\:\.]+/g, ''));
        var break_time = $.trim($(obj).find('.breaktime').val()) != '' ? $.trim($(obj).find('.breaktime').val().replace('-', '')) : '0';
        var spend_time = $.trim(final_spend);
        var br_hr = '00';
        var br_min = '00';
        var br_time = '';
        var extra_hr = '';
        if (break_time.indexOf('.') > '-1') {
            br_time = isNaN(break_time) ? 0 : break_time * 60;
            br_hr = Math.floor(br_time / 60);
            br_min = Math.floor(br_time % 60);
        } else if (break_time.indexOf(':') > '-1') {
            br_time = break_time.split(':');
            extra_hr = (br_time[1] == '') ? 0 : Math.floor(parseInt(br_time[1]) / 60);
            br_hr = (br_time[0] == '') ? 0 : (parseInt(br_time[0]) + parseInt(extra_hr));
            br_min = (br_time[1] == '') ? 0 : Math.floor(br_time[1] % 60);
        } else {
            br_hr = break_time;
            br_min = '0';
        }
        var sp_time = spend_time.split(':');
        var total_sp_min = (parseInt(sp_time[0]) * 60) + parseInt(sp_time[1]);
        var total_br_min = (parseInt(br_hr) * 60) + parseInt(br_min);
        var spend_duration = total_sp_min - total_br_min;
        var sp_hr = Math.floor(spend_duration / 60);
        var sp_min = Math.floor(spend_duration % 60);
        var final_sp = parseInt(sp_hr) > 0 || parseInt(sp_min) > 0 ? parseInt(sp_hr) + ':' + (sp_min < 10 ? "0" : "") + sp_min : '0:00';
        if (total_sp_min < total_br_min) {
            showTopErrSucc('error', _('Break time can not exceed the total spent hours.'));
            $(obj).find('.breaktime').val('');
            return false;
        } else if (total_sp_min == total_br_min) {
            showTopErrSucc('error', _('Break time can not same as the total spent hours.'));
            $(obj).find('.breaktime').val('');
            return false;
        } else {
            var final_br = parseInt(br_hr) > 0 || parseInt(br_min) > 0 ? (br_hr < 10 ? "0" : "") + br_hr + ':' + (br_min < 10 ? "0" : "") + br_min : '';
            if (typeof $scope.rowform != 'undefined') {
                $scope.rowform.$editables[0].scope.$data = final_sp;
            } else {}
            $(obj).find('.breaktime').val(final_br);
            return true;
        }
    }
    $scope.showPopover = function(clss) {
        $('#' + clss).slideToggle();
        $scope.setTimepicker('#' + clss);
    }
    $scope.hidePopover = function(clss) {
        $('#' + clss).slideUp();
    }
    $scope.clearTimeRange = function(clss) {
        $scope.start_time = '';
        $scope.end_time = '';
        $scope.break_time = '';
        $('#' + clss).slideUp();
    }
    $scope.showeditTimeRange = function(i, log) {
        $("#dynamkEditorTr" + i).find("textarea").attr('id', 'dynamkEditor' + i);
        if (tinymce.get('dynamkEditor' + i)) {
            tinymce.get('dynamkEditor' + i).remove();
        }
        tinymce.init({
            selector: "#dynamkEditor" + i,
            plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
            menubar: false,
            branding: false,
            statusbar: false,
            toolbar: 'bold italic underline strikethrough | numlist bullist fullscreen',
            toolbar_sticky: true,
            importcss_append: true,
            image_caption: true,
            browser_spellcheck: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
            toolbar_drawer: 'sliding',
            resize: false,
            min_height: 160,
            max_height: 180,
            paste_data_images: false,
            paste_as_text: true,
            autoresize_on_init: true,
            autoresize_bottom_margin: 20,
            content_css: HTTP_ROOT + 'css/tinymce.css',
            setup: function(ed) {
                ed.on('Click', function(ed, e) {});
                ed.on('KeyUp', function(ed, e) {});
                ed.on('Change', function(ed, e) {});
                ed.on('init', function(e) {
                    tinymce.get('dynamkEditor' + i).setContent(log.LogTime.description);
                });
            }
        });
        $("input[name='hours']").mask('00:M0', {
            translation: {
                'M': {
                    pattern: /[0-5]/
                }
            }
        });
        if (log.LogTime.description != '' && log.LogTime.description != '---') {}
        $("input[name='hours']").keyup(function() {
            var hrs = $(this).val().trim();
            if (hrs.indexOf(":") != -1) {
                arr = hrs.split(":");
            } else {
                arr = hrs.split(".");
            }
            if (arr[0] >= 24) {
                $(this).addClass('eborder');
                $("button[type='submit']").addClass('loginactive');
            } else {
                $(this).removeClass('eborder');
                $("button[type='submit']").removeClass('loginactive');
            }
        });
    }
    $scope.hideeditTimeRange = function(i) {
        $("#ng-popover-trigger_edit" + i).hide();
    }
    $scope.saveLogs = function(data, id, start_time, end_time, break_time, selected_date, old_data, index) {
        angular.extend(data, {
            id: id
        });
        if (typeof data.id != 'undefined') {
            if (data.hours.trim() == "") {
                showTopErrSucc('error', _('Hour field cannot left blank.'));
                return false;
            }
            if (data.hours.trim().indexOf(":") != -1) {
                arr = data.hours.trim().split(":");
            } else {
                arr = data.hours.trim().split(".");
            }
            if (arr[0] >= 24) {
                showTopErrSucc('error', _('Hour cannot  exceed 24 hours.'));
                return false;
            }
            var dataArr = data.hours.split(":");
            hrval = dataArr[0];
            minval = dataArr[1];
            if (parseInt(hrval) == 0 && parseInt(minval) == 0) {
                showTopErrSucc('error', _('Hour field cannot left blank.'));
                return false;
            }
            var old_description = $scope.$parent.logs[index].LogTime.description;
            data.start_time = start_time;
            data.end_time = end_time;
            data.break_time = break_time;
            data.task_date = selected_date;
            data.hours = $scope.padFormat(data.hours);
            data.description = (tinymce.editors['dynamkEditor' + index].getContent() != '' && tinymce.editors['dynamkEditor' + index].getContent() != '---') ? tinymce.editors['dynamkEditor' + index].getContent() : tinymce.activeEditor.getContent();
            $scope.$parent.logs[index].LogTime.description = data.description;
            $scope.$parent.$apply();
            if (typeof $scope.rowform != 'undefined') {
                $scope.rowform.$editables[0].scope.$data = data.hours;
            } else {}
            var params_data = $.param(data);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/updateTimesheet", params_data, config).success(function(data, status, headers, config) {
                if (data.success == 'depend') {
                    showTopErrSucc('error', data.message);
                    $scope.$parent.logs[index].LogTime.total_hours = old_data;
                } else if (data.success == 'err') {
                    showTopErrSucc('error', data.message);
                    $scope.$parent.logs[index].LogTime.total_hours = old_data;
                } else {
                    showTopErrSucc('success', _('Time Log updated successfully'));
                }
                if (typeof $scope.$parent.getTasks != 'undefined') {
                    $scope.$parent.getTasks($scope.$parent.prevDate, $scope.$parent.nextDate);
                    $('#myModalTimeSheet').modal('hide');
                }
            });
        } else {
            showTopErrSucc('error', _("Oops! we have experienced some problem. Please try again!"));
        }
    };
    $scope.deleteLog = function(data, index) {
        var taskNo = data.LogTime.task_no;
        if (confirm(_('Are you sure you want to delete time log of task#') + ' ' + taskNo + '?')) {
            $scope.logs.splice(index, 1);
            if (typeof data.LogTime.log_id != 'undefined') {
                var params_data = $.param(data);
                var config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                }
                $http.post(HTTP_ROOT + "LogTimes/deleteTimesheet", params_data, config).success(function(data, status, headers, config) {
                    showTopErrSucc('success', _("Time log deleted successfully for task#") + " " + taskNo + ".");
                    if (typeof $scope.$parent.getTasks != 'undefined') {
                        $scope.$parent.getTasks($scope.$parent.prevDate, $scope.$parent.nextDate);
                        $scope.$parent.showplaceholder = 0;
                        $('#myModalTimeSheet').modal('hide');
                    }
                });
            } else {
                showTopErrSucc('error', _("Oops! we have experienced some problem. Please try again!"));
            }
        }
    };
    $scope.addUser = function() {
        $scope.inserted = {
            id: $scope.users.length + 1,
            name: '',
            status: null,
            group: null
        };
        $scope.users.push($scope.inserted);
    };
    $scope.changeVal = function(e, s, data) {
        var e1 = $scope.logs[e].LogTime.total_hours;
        if (e1.trim() != '') {
            var inpt = e1.trim();
            var char_restirict = /^[0-9\:]+$/.test(inpt);
            if (!char_restirict) {
                var st_t = inpt.substr(0, inpt.length - 1);
                $scope.logs[e].LogTime.total_hours = st_t;
                inpt = st_t;
            }
            var t_inpt = inpt.split(":");
            var d_inpt = inpt.split(".");
            var len = t_inpt.length - 1;
            var d_len = d_inpt.length - 1;
            if (len >= 2 || d_len >= 2 || (len & d_len)) {
                $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                showTopErrSucc('error', _("Invalid time"));
                return false;
            } else {
                if (len > 0 || d_len > 0) {
                    var c_ln = 0;
                    var d_ln = 0;
                    if (inpt.indexOf(":") != -1) {
                        var sec_part = inpt.substr(inpt.indexOf(":") + 1);
                        c_ln = sec_part.length;
                        var first_part = inpt.substr(0, inpt.indexOf(":"));
                    }
                    if (inpt.indexOf(".") != -1) {
                        var dsec_part = inpt.substr(inpt.indexOf(".") + 1);
                        d_ln = dsec_part.length;
                    }
                    if (c_ln > 2 || d_ln > 2) {
                        $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', _("Minute can not exceed 2 digit"));
                        return false;
                    }
                    if (sec_part > 59) {
                        $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', _("Invalid time format"));
                        return false;
                    }
                    if (first_part > 23) {
                        $scope.logs[e].LogTime.total_hours = inpt.slice(0, inpt.indexOf(":") - 1) + inpt.slice(inpt.indexOf(":"));
                        showTopErrSucc('error', _("Invalid time format"));
                        return false;
                    }
                }
                if (inpt.indexOf(":") == -1 && inpt > 23) {
                    $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', _("Invalid time format"));
                    return false;
                }
            }
            $scope.getTotalLog();
        }
    }
    $scope.padFormat = function(d) {
        arr = d.split(":");
        hrs = (typeof arr[0] != 'undefined') ? arr[0] : '00';
        mins = (typeof arr[1] != 'undefined') ? arr[1] : '00';
        hrs = (hrs.length == 1) ? '0' + hrs.toString() : hrs.toString().slice(-2);
        mins = (mins.length == 1) ? '0' + mins.toString() : mins.toString().slice(-2);
        return hrs + ":" + mins;
    }
});
caseapp.controller('timesheetWeeklyController', function($scope, $http, $interval, $timeout) {
    $scope.disabled = undefined;
    $scope.chckprevEdtrId = '';
    $scope.HTTP_ROOT = HTTP_ROOT;
    $scope.showplaceholder = 0;
    $scope.IsVisible = false;
    $scope.person = {};
    $scope.filter_type = {};
    $scope.users = {};
    $scope.week = {};
    $scope.date = '';
    $scope.tasks = {};
    $scope.totalT = 0;
    $scope.SundayT = 0;
    $scope.MondayT = 0;
    $scope.TuesdayT = 0;
    $scope.WednesdayT = 0;
    $scope.ThursdayT = 0;
    $scope.FridayT = 0;
    $scope.SaturdayT = 0;
    $scope.showLoader = 0;
    $scope.disable_save_all = 1;
    $scope.cdate = moment().format("YYYY-MM-DD");
    $scope.isCurrentWeek = 0;
    $scope.SES_TYPE = SES_TYPE;
    $scope.SES_COMP = SES_COMP;
    $scope.filter_type = [{
        id: 1,
        name: 'Assign To Me'
    }, {
        id: 2,
        name: 'Delegated'
    }, {
        id: 3,
        name: 'Closed Task'
    }, {
        id: 4,
        name: 'All Opened Task'
    }, ];
    var selected_filter_type = JSON.parse(localStorage.getItem("TIMESHEET_FILTER"));
    if (check_empty(selected_filter_type)) {
        $scope.filter_type.selected = [{
            id: 1,
            name: 'Assign To Me'
        }, {
            id: 4,
            name: 'All Opened Task'
        }];
    } else {
        $scope.filter_type.selected = JSON.parse(localStorage.getItem("TIMESHEET_FILTER"));
    }
    $scope.changeDate = function(d) {
        if (typeof d != 'undefined') {
            $scope.date = moment(d, "YYYY-MM-DD").add(-1, 'days').format("YYYY-MM-DD");
        } else {
            $scope.date = moment().format("YYYY-MM-DD");
        }
        $scope.prevDate = moment($scope.date, "YYYY-MM-DD").startOf('week').format('YYYY-MM-DD');
        $scope.week.Monday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(1, 'days').format('M/DD');
        $scope.week.Tuesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(2, 'days').format('M/DD');
        $scope.week.Wednesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(3, 'days').format('M/DD');
        $scope.week.Thursday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(4, 'days').format('M/DD');
        $scope.week.Friday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(5, 'days').format('M/DD');
        $scope.week.Saturday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(6, 'days').format('M/DD');
        $scope.week.Sunday = moment($scope.date, "YYYY-MM-DD").startOf('week').add(7, 'days').format('M/DD');
        $scope.nextDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add(8, 'days').format('YYYY-MM-DD');
        $scope.getTasks($scope.prevDate, $scope.nextDate);
        $scope.weekTime = moment($scope.date, "YYYY-MM-DD").startOf('week').add(1, 'days').format('DD MMM') + "   -   " + moment($scope.date, "YYYY-MM-DD").startOf('week').add(7, 'days').format('DD MMM YYYY');
        $scope.weekTime_format = moment($scope.date, "YYYY-MM-DD").startOf('week').add(6, 'days').format('MM/DD/YYYY');
        $scope.checkCurrentWeek();
        $scope.today = moment().format("M/DD");
        var weekendDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add(6, 'days').format('YYYY-MM-DD');
        var weekNumber = moment(weekendDate, "YYYY-MM-DD").week();
        if (weekNumber == 1) {
            $scope.weekNumber = 52;
        } else {
            $scope.weekNumber = weekNumber - 1;
        }
    }
    $scope.getAllUsers = function() {
        var params_data = $.param({});
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/showAllUsers", params_data, config).success(function(data, status, headers, config) {
            $scope.users = data.Users;
            $scope.Projects = data.Projects;
            $scope.person.selected = data.Person;
            $scope.ProjectTasks = data.ProjectTasks;
            $scope.project_ID = data.Selected.project_id;
            $scope.project_Name = data.Selected.pname;
        });
    }
    $scope.selectProject = function($event) {
        $('.plistul').find('li').removeClass('active');
        $($event.target).closest('li').addClass('active');
    }
    $scope.isAllowed = function(action) {
        return isAllowed(action);
    }
    $scope.createNewTask = function() {
        var title = trim($scope.searchT.name);
        var active_prj = $('ul.plistul').find('li.active').find('a');
        var prj_id = $(active_prj).attr('attr.data-projectid');
        var prj_name = $(active_prj).attr('attr.data-projectname');
        var mid = '';
        var type = 'inline';
        var assign_to = 'inline';
        var view_type = 'weekly_time_sheet';
        var task_type = '';
        var story_point = '';
        var estimated = '';
        var due_date = '';
        var user_id = (typeof $scope.person.selected != 'undefined') ? $scope.person.selected.id : SES_ID;
        var filter_type_id = $scope.filter_type.selected;
        if (empty(title)) {
            showTopErrSucc('error', _('Please Enter Task Title.'));
            return false;
        }
        $('.tloader').show();
        $scope.ProjectTasks = {};
        $.post(HTTP_ROOT + "easycases/quickTask", {
            'title': title,
            'project_id': prj_id,
            'type': 'inline',
            'mid': mid,
            'view_type': view_type,
            'task_type': task_type,
            'story_point': story_point,
            'assign_to': user_id,
            'estimated': estimated,
            'due_date': due_date,
        }, function(res) {
            if (res.error) {
                showTopErrSucc('error', res.msg);
                $scope.getAllTasks(prj_id, prj_name);
                return false;
            } else {
                showTopErrSucc('success', _('Task posted successfully.'));
                $scope.searchT.name = '';
                $('#task_srch').val('');
                $scope.getAllTasks(prj_id, prj_name);
            }
            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
            var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
            var event_name = sessionStorage.getItem('SessionStorageEventValue');
            if (eventRefer && event_name) {
                trackEventLeadTracker(event_name, eventRefer, sessionEmail);
            }
            if (client) {
                client.emit('iotoserver', res.iotoserver);
            }
        }, 'json');
    }
    $scope.getAllTasks = function(project_id, pname) {
        str = new Array();
        str[0] = 0;
        for (var d in $scope.tasks) {
            str[d] = $scope.tasks[d].LogTime.task_id;
        }
        var params_data = $.param({
            'project_id': project_id,
            'notIn': str.join()
        });
        $scope.project_ID = project_id;
        $scope.project_Name = pname;
        $('.tloader').show();
        $scope.ProjectTasks = {};
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/getTasksByProject", params_data, config).success(function(data, status, headers, config) {
            $scope.ProjectTasks = data.tasks;
            $('.tloader').hide();
        });
    }
    $scope.addTaskRow = function(id, tname, case_no, uniq_id) {
        for (var d in $scope.tasks) {
            if ($scope.tasks[d].LogTime.task_id == id) {
                showTopErrSucc('error', _("This task is already selected."));
                $scope.IsVisible = false;
                return false;
            }
        }
        $scope.IsVisible = false;
        $(".timesheet_add_item_pop").hide();
        newArray = {
            "LogTime": {
                "log_id": "",
                "user_id": $scope.person.selected.id,
                "project_id": $scope.project_ID,
                "task_id": id,
                "task_date": '',
                "start_time": "",
                "end_time": "",
                "total_hours": "",
                "is_billable": "0",
                "description": "",
                "task_status": "0",
                "created": "",
                "start_datetime": "",
                "end_datetime": "",
                "break_time": "0",
                "inner": {
                    "Saturday": "",
                    "SaturdayF": "",
                    "SaturdayC": "0",
                    "Friday": "",
                    "FridayF": "",
                    "FridayC": "0",
                    "Thursday": "",
                    "ThursdayF": "",
                    "ThursdayC": "0",
                    "Wednesday": "",
                    "WednesdayF": "",
                    "WednesdayC": "0",
                    "Tuesday": "",
                    "TuesdayF": "",
                    "TuesdayC": "0",
                    "Monday": "",
                    "MondayF": "",
                    "MondayC": "0",
                    "Sunday": "",
                    "SundayF": "",
                    "SundayC": "0"
                },
                "start_datetime_v1": "",
                "task_name": tname,
                "task_uniqid": "",
                "task_no": case_no,
                "project_name": $scope.project_Name
            },
            "0": {
                "start_datetime_v1": "",
                "ttime": 0,
                "task_name": tname + "|__|" + uniq_id + "|__|" + case_no,
                "project_name": $scope.project_Name
            },
            "Project": {
                "uniq_id": ""
            }
        };
        $scope.tasks.push(newArray);
    }
    $scope.calculate = function() {
        $scope.totalT = 0;
        $scope.SundayT = 0;
        $scope.MondayT = 0;
        $scope.TuesdayT = 0;
        $scope.WednesdayT = 0;
        $scope.ThursdayT = 0;
        $scope.FridayT = 0;
        $scope.SaturdayT = 0;
        for (var d in $scope.tasks) {
            $scope.tasks[d][0].ttime = (isNaN($scope.tasks[d][0].ttime)) ? 0 : $scope.tasks[d][0].ttime;
            $scope.totalT = parseInt($scope.totalT) + parseInt($scope.tasks[d][0].ttime);
            $scope.SundayT = parseInt($scope.SundayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Sunday != 'undefined' && $scope.tasks[d].LogTime.inner.Sunday != '') ? $scope.tasks[d].LogTime.inner.Sunday : 0);
            $scope.MondayT = parseInt($scope.MondayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Monday != 'undefined' && $scope.tasks[d].LogTime.inner.Monday != '') ? $scope.tasks[d].LogTime.inner.Monday : 0);
            $scope.TuesdayT = parseInt($scope.TuesdayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Tuesday != 'undefined' && $scope.tasks[d].LogTime.inner.Tuesday != '') ? $scope.tasks[d].LogTime.inner.Tuesday : 0);
            $scope.WednesdayT = parseInt($scope.WednesdayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Wednesday != 'undefined' && $scope.tasks[d].LogTime.inner.Wednesday != '') ? $scope.tasks[d].LogTime.inner.Wednesday : 0);
            $scope.ThursdayT = parseInt($scope.ThursdayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Thursday != 'undefined' && $scope.tasks[d].LogTime.inner.Thursday != '') ? $scope.tasks[d].LogTime.inner.Thursday : 0);
            $scope.FridayT = parseInt($scope.FridayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Friday != 'undefined' && $scope.tasks[d].LogTime.inner.Friday != '') ? $scope.tasks[d].LogTime.inner.Friday : 0);
            $scope.SaturdayT = parseInt($scope.SaturdayT) + parseInt((typeof $scope.tasks[d].LogTime.inner.Saturday != 'undefined' && $scope.tasks[d].LogTime.inner.Saturday != '') ? $scope.tasks[d].LogTime.inner.Saturday : 0);
        }
        if (parseInt($scope.SundayT) > 86400 || parseInt($scope.MondayT) > 86400 || parseInt($scope.TuesdayT) > 86400 || parseInt($scope.WednesdayT) > 86400 || parseInt($scope.ThursdayT) > 86400 || parseInt($scope.FridayT) > 86400 || parseInt($scope.SaturdayT) > 86400) {}
    }
    $scope.clearTasks = function() {
        var weekd = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for (var d in $scope.tasks) {
            for (var i in weekd) {
                var wi = weekd[i];
                var wicnt = weekd[i] + 'cnt';
                var wiF = weekd[i] + 'F';
                var wiC = weekd[i] + 'C';
                if (typeof $scope.tasks[d].LogTime.inner[wicnt] == 'undefined') {
                    if (typeof $scope.tasks[d].LogTime.inner[wi] != 'undefined') {
                        $scope.tasks[d].LogTime.inner[wi] = ''
                    }
                    if (typeof $scope.tasks[d].LogTime.inner[wiF] != 'undefined') {
                        $scope.tasks[d].LogTime.inner[wiF] = ''
                    }
                    if (typeof $scope.tasks[d].LogTime.inner[wiC] != 'undefined') {
                        $scope.tasks[d].LogTime.inner[wiC] = ''
                    }
                }
            }
        }
    }
    $scope.getTasks = function(prev, next) {
        $scope.disable_save_all = 1;
        user_id = (typeof $scope.person.selected != 'undefined') ? $scope.person.selected.id : SES_ID;
        filter_type_id = $scope.filter_type.selected;
        var params_data = $.param({
            'startdate': prev,
            'enddate': next,
            'usrid': user_id,
            'filter_type_id': filter_type_id,
        });
        localStorage.setItem("TIMESHEET_FILTER", JSON.stringify(filter_type_id));
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/timesheet_weekly", params_data, config).success(function(data, status, headers, config) {
            $scope.tasks = data.logtimes;
            $scope.Projects = data.projects;
            $scope.lastweekLog = data.lastweekLog;
            $scope.ProjectTasks = data.ProjectTasks;
            $scope.project_ID = data.Selected.project_id;
            $scope.project_Name = data.Selected.pname;
            $scope.showNote = false;
            $scope.calculate();
            $scope.Approvers = data.approvers;
            $scope.isAtleastOneHavingData = data.isAtleastOneHavingData;
            $scope.displayApproverListDropDown = 0;
            $scope.isApproveRequestSent = data.isApproveRequestSent;
            $scope.SES_COMP = data.company_id;
            if ($scope.isAtleastOneHavingData > 0 && $scope.isApproveRequestSent == 2) {
                $("#btnSaveApproval").show();
                $("#btnSaveApproval").removeClass('loginactive');
            }
            $('.r-u-link').hide();
            if (SES_TYPE < 3) {
                $('.r-u-link').show();
            }
        });
    }
    $scope.sum = function(obj) {
        var sum = 0;
        var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        for (var el in obj) {
            if (obj.hasOwnProperty(el)) {
                if (!isNaN(obj[el]) && obj[el] != '' && days.indexOf(el) > -1) {
                    if (obj[el + 'F'] != '') {
                        sum += parseFloat(obj[el]);
                    } else {
                        sum += 0;
                    }
                }
            }
        }
        return sum;
    }
    $scope.initMask = function() {
        $(".timelog_listItems").find('input[type="text"]').mask('00:M0', {
            translation: {
                'M': {
                    pattern: /[0-5]/
                },
            }
        });
    }
    $scope.changeFormat = function(e, s) {}
    $scope.changeVal = function(e, s) {
        e1 = $scope.tasks[e].LogTime.inner[s];
        if (e1.trim() != '') {
            var inpt = e1.trim();
            if (inpt.indexOf(":") != -1) {
                hrs = $scope.tasks[e].LogTime.inner[s].split(":");
            } else {
                hrs = $scope.tasks[e].LogTime.inner[s].split(".");
            }
            hr = (typeof hrs[0] != 'undefined' && hrs[0] != '') ? parseInt(hrs[0]) * 3600 : 0;
            min = (typeof hrs[1] != 'undefined' && hrs[1] != '') ? parseInt(hrs[1]) * 60 : 0;
            $scope.tasks[e].LogTime.inner[s.slice(0, -1)] = parseInt(hr) + parseInt(min);
        } else {
            $scope.tasks[e].LogTime.inner[s.slice(0, -1)] = 0;
        }
        $scope.tasks[e][0].ttime = $scope.sum($scope.tasks[e].LogTime.inner);
        $scope.calculate();
    }
    $scope.openTimesheetExportPopup = function(userid, prevDate, nextDate) {
        prevDate = moment(prevDate, "YYYY-MM-DD").add(1, 'days').format('YYYY-MM-DD');
        nextDate = moment(nextDate, "YYYY-MM-DD").subtract(1, 'days').format('YYYY-MM-DD');
        openTimesheetExportPopup(userid, prevDate, nextDate);
    }
    $scope.saveData = function(e, s, m) {
        return false;
        task_id = $scope.tasks[e].LogTime.task_id;
        project_id = $scope.tasks[e].LogTime.project_id;
        user_id = $scope.person.selected.id;
        date = moment($scope.prevDate, "YYYY-MM-DD").add('days', s).format('YYYY-MM-DD');
        value = m;
        hr = value.substring(0, 2) * 3600;
        min = value.substring(2, 4) * 60;
        sec = parseInt(hr) + parseInt(min);
        var params_data = $.param({
            task_id: task_id,
            date: date,
            sec: sec,
            user_id: user_id,
            project_id: project_id
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/saveTimesheet", params_data, config).success(function(data, status, headers, config) {
            showTopErrSucc('success', _('Time Logged successfully'));
        });
    }
    $scope.saveAllData = function() {
        if ($scope.disable_save_all) {
            return false;
        }
        $scope.disable_save_all = 1;
        var t = new Array();
        for (var e in $scope.tasks) {
            t[e] = new Array();
            for (s = 1; s <= 7; s++) {
                date = moment($scope.prevDate, "YYYY-MM-DD").add('days', s).format('YYYY-MM-DD');
                datename = moment($scope.prevDate, "YYYY-MM-DD").add('days', s).format('dddd');
                if ((typeof $scope.tasks[e].LogTime.inner[datename + 'cnt'] == 'undefined' || $scope.tasks[e].LogTime.inner[datename + 'cnt'] <= 1) && $scope.tasks[e].LogTime.inner[datename] > 0) {
                    log_id = (typeof $scope.tasks[e].LogTime.inner[datename + 'id'] != 'undefined') ? $scope.tasks[e].LogTime.inner[datename + 'id'] : '';
                    task_id = $scope.tasks[e].LogTime.task_id;
                    project_id = $scope.tasks[e].LogTime.project_id;
                    user_id = $scope.person.selected.id;
                    sec = $scope.tasks[e].LogTime.inner[datename];
                    desc = $scope.tasks[e].LogTime.inner[datename + 'desc'];
                    is_billable = (typeof $scope.tasks[e].LogTime.inner[datename + 'C'] != 'undefined') ? $scope.tasks[e].LogTime.inner[datename + 'C'] : 0;
                    var params_data = {
                        log_id: log_id,
                        task_id: task_id,
                        date: date,
                        sec: sec,
                        user_id: user_id,
                        desc: desc,
                        project_id: project_id,
                        is_billable: is_billable
                    };
                    t[e][s] = params_data;
                }
            }
        }
        $scope.showLoader = 1;
        params_data = $.param({
            data: JSON.stringify(t)
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/saveAllTimesheet", params_data, config).success(function(data, status, headers, config) {
            $scope.disable_save_all = 0;
            $scope.showLoader = 0;
            if (data.msg) {
                showTopErrSucc('error', data.msg);
            } else {
                showTopErrSucc('success', _("Time sheet data saved successfully."));
            }
            $scope.getTasks($scope.prevDate, $scope.nextDate);
        });
    }
    $scope.showDailyView = function(i, s) {
        if ($scope.tasks[i].LogTime.inner[s] >= 1) {
            $('#myModalTimeSheet').modal('show');
            $('.updateTimesheet').show();
            $('#caseLoader').show();
            params = {};
            inner = s.replace('cnt', '');
            week = {
                'Sunday': 0,
                "Monday": 1,
                "Tuesday": 2,
                "Wednesday": 3,
                "Thursday": 4,
                "Friday": 5,
                "Saturday": 6
            };
            no = week[inner];
            params.currentdate = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', no).format('YYYY-MM-DD');
            params.angular = 1;
            params.curent_selected_date = '';
            params.type = '';
            params.task_id = $scope.tasks[i].LogTime.task_id;
            params.usrid = $scope.person.selected.id;
            var params_data = $.param(params);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/timesheet_daily", params_data, config).success(function(data, status, headers, config) {
                $('#caseLoader').hide();
                $scope.logs = data.logtimes;
                setTimeout(function() {
                    $scope.$apply();
                });
                $('.r-u-link').hide();
                if (SES_TYPE < 3) {
                    $('.r-u-link').show();
                }
            });
        }
    }
    $scope.checkCurrentWeek = function() {
        currentTimestamp = moment($scope.cdate).format("X");
        prevTimestamp = moment($scope.prevDate).format("X");
        nextTimestamp = moment($scope.nextDate).format("X");
        if (prevTimestamp > currentTimestamp || currentTimestamp > nextTimestamp) {
            $scope.isCurrentWeek = 1;
        } else {
            $scope.isCurrentWeek = 0;
        }
    }
    $scope.delete = function(i, tn) {
        var warning_message = _("Are you sure you want to delete all weekly time log of this task?");
        var success_message = _("Weekly time log deleted successfully.");
        if (tn.trim() != '') {
            task_dtl = tn.split('|__|');
            warning_message = _("Are you sure you want to delete all weekly time log of task#") + " " + task_dtl[2] + "?";
            success_message = _("Weekly time log deleted successfully for task#") + " " + task_dtl[2] + ".";
        }
        if (confirm(warning_message)) {
            if ($scope.tasks[i].LogTime.log_id == '') {
                $scope.tasks.splice(i, 1);
                $scope.calculate();
                if ($scope.tasks.length == 0) {
                    $scope.showplaceholder = 0;
                }
            } else {
                date = moment($scope.prevDate, "YYYY-MM-DD").add('days', 1).format('YYYY-MM-DD');
                date1 = moment($scope.nextDate, "YYYY-MM-DD").add('days', -1).format('YYYY-MM-DD');
                var params_data = $.param({
                    task_id: $scope.tasks[i].LogTime.task_id,
                    date: date,
                    date1: date1,
                    user_id: $scope.person.selected.id,
                    project_id: $scope.tasks[i].LogTime.project_id
                });
                var config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                }
                $http.post(HTTP_ROOT + "logTimes/deleteTimesheetWeek", params_data, config).success(function(data, status, headers, config) {
                    $scope.tasks.splice(i, 1);
                    setTimeout(function() {
                        $scope.$apply();
                    });
                    if ($scope.tasks.length == 0) {
                        $scope.showplaceholder = 0;
                    }
                    $scope.calculate();
                    showTopErrSucc('success', success_message);
                });
            }
        }
    }
    $scope.visiblePopup = function() {
        $('.timesheet_add_item_pop').show();
        if ($('.addLineItems').offset().top < 300 || $scope.showplaceholder == 0) {
            $('.timesheet_add_item_pop').css({
                'left': '120px',
                'bottom': '-60%'
            });
        } else {
            $('.timesheet_add_item_pop').css({
                'left': '0px',
                'bottom': '100%'
            });
        }
        $scope.showplaceholder = 1;
        $scope.IsVisible = true;
    }
    $scope.visibilityNone = function() {
        $(".timesheet_add_item_pop").hide();
        $scope.showplaceholder = 0;
        $scope.IsVisible = false;
    }
    $("#weeklyDatePicker").datetimepicker({
        format: 'YYYY/MM/DD'
    });
    $('#weeklyDatePicker').on('dp.change', function(e) {
        value = $("#weeklyDatePicker").val();
        $scope.changeDate(value);
    });
    $scope.padFormat = function(d) {
        if (d.indexOf(":") != -1) {
            arr = d.split(":");
        } else {
            arr = d.split(".");
        }
        hrs = (typeof arr[0] != 'undefined') ? arr[0] : '00';
        mins = (typeof arr[1] != 'undefined') ? arr[1] : '00';
        hrs = (hrs.length == 1) ? '0' + hrs.toString() : hrs.toString().slice(-2);
        mins = (mins.length == 1) ? '0' + mins.toString() : mins.toString().slice(-2);
        return hrs + ":" + mins;
    }
    $scope.activateBtn = function() {
        var flag = false;
        $(".list-body").find('input[type="text"]:not([readonly])').each(function() {
            if ($(this).val().trim() != '') {
                var d = $(this).val().trim();
                if (d.indexOf(":") != -1) {
                    arr = d.split(":");
                } else {
                    arr = d.split(".");
                }
                if (arr[0] >= 24) {
                    $(this).addClass('eborder');
                } else {
                    $(this).removeClass('eborder');
                }
            }
        });
        $(".list-body").find('input[type="text"]:not([readonly])').each(function() {
            if ($(this).val().trim() != '') {
                var d = $(this).val().trim();
                if (d.indexOf(":") != -1) {
                    arr = d.split(":");
                } else {
                    arr = d.split(".");
                }
                if (arr[0] >= 24) {
                    flag = false;
                    return false;
                }
                flag = true;
            }
        });
        if (flag) {
            $("#btnSave").removeClass('loginactive');
            $("#btnSaveApproval").addClass('loginactive');
            $(".displayApproverListDropDown").hide();
            $scope.disable_save_all = 0;
        } else {
            $("#btnSave").addClass('loginactive');
            $("#btnSaveApproval").removeClass('loginactive');
            $(".displayApproverListDropDown").show();
            $scope.disable_save_all = 1;
        }
    }
    $scope.displayTaskDetails = function(uniqid) {
        var task_dtl = uniqid.split('|__|');
        var caseUniqId = task_dtl[1];
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    }
    $scope.changeDate();
    $scope.getAllUsers();
    $scope.$on('$viewContentLoaded', function(event) {
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
    });
    $scope.setNote = function(e, s) {
        e1 = $scope.tasks[e].LogTime.inner;
        if (typeof e1[s + 'cnt'] == 'undefined') {
            $scope.showNote = true;
            $scope.noteDay = s;
            $scope.noteIndex = e;
            if ($scope.chckprevEdtrId != s) {
                $scope.chckprevEdtrId = s;
                tinymce.activeEditor.setContent('');
            }
        }
    }
    $scope.hideNoteDiv = function(e) {
        var obj = $(e.target);
        if (obj.hasClass('shownote') || obj.closest('shownote').length != 0 || e.target.nodeName == 'INPUT') {} else {
            $scope.showNote = false;
        }
    }
    $scope.showNote = false;
    $scope.noteDay = '';
    $scope.noteIndex = '';
    tinymce.init({
        selector: "textarea[name='note']",
        plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
        menubar: false,
        branding: false,
        statusbar: false,
        toolbar: 'bold italic underline strikethrough | numlist bullist fullscreen',
        toolbar_sticky: true,
        importcss_append: true,
        image_caption: true,
        browser_spellcheck: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
        toolbar_drawer: 'sliding',
        resize: false,
        min_height: 160,
        max_height: 200,
        paste_data_images: false,
        paste_as_text: true,
        autoresize_on_init: true,
        autoresize_bottom_margin: 20,
        content_css: HTTP_ROOT + 'css/tinymce.css',
        setup: function(ed) {
            ed.on('Click', function(ed, e) {});
            ed.on('KeyUp', function(ed, e) {
                var inpt = $.trim(tinymce.activeEditor.getContent());
                $scope.tasks[$scope.noteIndex].LogTime.inner[$scope.noteDay + 'desc'] = inpt;
            });
            ed.on('Change', function(ed, e) {});
            ed.on('init', function(e) {});
        }
    });
    $scope.displayApproverList = function() {
        if ($scope.isAtleastOneHavingData == 0) {
            return false;
        } else {
            if ($("#btnSaveApproval").hasClass("loginactive")) {
                return false;
            } else {
                $(".displayApproverListDropDown").show();
                $("#btnSaveApproval").hide();
                window.scrollTo({
                    top: 2500,
                    behavior: "smooth"
                });
                $scope.displayApproverListDropDown = 1;
            }
        }
    }
    $scope.cancelDataApproval = function() {
        $(".displayApproverListDropDown").hide();
        $('#selectApproverId').prop('selectedIndex', "");
        $("#btnSaveApproval").show();
        $scope.displayApproverListDropDown = 0;
    }
    $scope.saveAllDataApproval = function() {
        if (typeof $scope.approverList == 'undefined' || $scope.approverList == null) {
            alert("Please select an approver to submit.");
            return false;
        } else {
            $(".displayApproverListDropDown").show();
            var userId = $scope.person.selected.id;
            var approverUserid = $scope.approverList.id;
            var approverUseremail = $scope.approverList.email;
            var approverUsername = $scope.approverList.name;
            var totalHoursForApproval = $scope.isAtleastOneHavingData;
            var weekstartDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add(0, 'days').format('YYYY-MM-DD');
            var weekendDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add(6, 'days').format('YYYY-MM-DD');
            var weekNumber = moment(weekendDate, "YYYY-MM-DD").week();
            var log_year = moment($scope.date, "YYYY").year();
            var project_id = [];
            for (var e in $scope.tasks) {
               project_id.push($scope.tasks[e].LogTime.project_id);
            }
            var approver_params_data = {
                user_id: userId,
                approver_user_id: approverUserid,
                approver_user_email: approverUseremail,
                approve_total_hours: totalHoursForApproval,
                approver_week_start: weekstartDate,
                approver_week_end: weekendDate,
                timesheet_comment_val: $scope.lessMoreComment,
                week_number: weekNumber,
                log_year: log_year,
                project_id:project_id
            };
            $scope.showLoaderApprover = 1;
            approver_params_data = $.param({
                data: JSON.stringify(approver_params_data)
            });
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            if ($scope.hasUserGivenComments && $scope.hasUserGivenComments == 1) {
                $http.post(HTTP_ROOT + "logTimes/saveApproverTimesheet", approver_params_data, config).success(function(data, status, headers, config) {
                    $scope.showLoaderApprover = 0;
                    if (data.msg) {
                        $("#comment_desc_id").val('');
                        $('#myModalTimeSheet').modal('hide');
                        $("#comment_btn").show();
                        $("#comment_loader").hide();
                        showTopErrSucc('error', data.msg);
                    } else {
                        $("#comment_desc_id").val('');
                        $('#myModalTimeSheet').modal('hide');
                        $("#comment_btn").show();
                        $("#comment_loader").hide();
                        showTopErrSucc('success', _("This week submitted successfully to the selected approver."));
                    }
                    $scope.hasUserGivenComments = null;
                    $scope.getTasks($scope.prevDate, $scope.nextDate);
                });
            } else if (typeof $scope.hasUserGivenComments == 'undefined' || $scope.hasUserGivenComments == null) {
                $http.post(HTTP_ROOT + "logTimes/checkLessMoreTimeSubmit", approver_params_data, config).success(function(data, status, headers, config) {
                    $scope.showLoaderApprover = 0;
                    if (data.isRequestGreaterThanSubmitted == 1) {
                        var textLabel = "<label class='m_0'>Short Hours : </label>";
                    } else if (data.isRequestGreaterThanSubmitted == 2) {
                        var textLabel = "<label class='m_0'>Excess Hours : </label>";
                    }
                    if (data.isRequestGreaterThanSubmitted == 1 || data.isRequestGreaterThanSubmitted == 2) {
                        $('#myModalTimeSheet').modal('show');
                        $(".timesheet_more_less").show();
                        $(".approverText").html($scope.approverList.name);
                        $(".requestHours").html(data.requestedHoursFormatted);
                        $(".submitHours").html(data.submittedHoursFormatted);
                        $(".shortMoreHours").html(data.moreLessHours);
                        if (data.isRequestGreaterThanSubmitted == 1) {
                            $(".shortMoreHours").css({
                                'color': '#FF0000',
                                'font-weight': 'bold'
                            });
                        } else if (data.isRequestGreaterThanSubmitted == 2) {
                            $(".shortMoreHours").css({
                                'color': 'green',
                                'font-weight': 'bold'
                            });
                        }
                        $(".shortMoreCls").html(textLabel);
                        $(".comment_desc_class").focus();
                        $("#comment_desc_id").val('');
                    } else if (data.isRequestGreaterThanSubmitted == 3) {
                        $http.post(HTTP_ROOT + "logTimes/saveApproverTimesheet", approver_params_data, config).success(function(data, status, headers, config) {
                            $scope.showLoaderApprover = 0;
                            if (data.msg) {
                                showTopErrSucc('error', data.msg);
                            } else {
                                showTopErrSucc('success', _("This week submitted successfully to the selected approver."));
                            }
                            $scope.getTasks($scope.prevDate, $scope.nextDate);
                        });
                    }
                }, 'json');
            }
        }
    }
    $scope.commentAdd = function(stsCmnt) {
        if (stsCmnt == 'yes') {
            var comment_desc_id_val = $("#comment_desc_id").val();
            if (comment_desc_id_val == '') {
                alert("Please enter some comments here.");
                $("#comment_desc_id").val('');
                $scope.lessMoreComment = '';
                return false;
            } else {
                $("#comment_btn").hide();
                $("#comment_loader").show();
                $scope.lessMoreComment = comment_desc_id_val;
                $scope.hasUserGivenComments = 1;
                $scope.saveAllDataApproval();
            }
        } else if (stsCmnt == 'no') {
            $('#myModalTimeSheet').modal('hide');
            $scope.lessMoreComment = '';
            $("#comment_desc_id").val('');
            return false;
        }
    }
});
caseapp.controller('timelogChartController', function($scope, $http, $interval, $timeout) {
    $scope.drawPie = function() {
        if (typeof $scope.records != 'undefined') {
            datas = $scope.records.datas;
            var newArray = new Array();
            for (var d in datas) {
                data = [];
                data.push(datas[d]);
                newArray[d] = data;
                if ($('#container_pie' + d).length) {
                    $('#container_pie' + d).highcharts({
                        chart: {
                            margin: 0,
                            padding: 0,
                            type: 'pie',
                            width: datas[d].agrigate_hours,
                            height: datas[d].agrigate_hours,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingRight: 0,
                            spacingTop: 0,
                        },
                        title: {
                            text: null
                        },
                        plotOptions: {
                            series: {
                                animation: false,
                                dataLabels: {
                                    enabled: false
                                }
                            },
                            pie: {
                                size: datas[d].agrigate_hours
                            }
                        },
                        tooltip: {
                            enabled: false
                        },
                        credits: {
                            enabled: false
                        },
                        series: data
                    });
                }
            }
            $(".container_pie").closest('td').mouseenter(function(res) {
                if (!$(this).find(".pophoverCnt").is(':visible')) {
                    var pophoverCnt = $(this).find(".pophoverCnt");
                    var right = $(this).offset().left + $(this).outerWidth();
                    if (right + 370 > $(document).width()) {
                        pophoverCnt.css('right', $(document).width() - $(this).offset().left - 30);
                    } else {
                        pophoverCnt.css('left', $(this).offset().left - 60);
                    }
                    var topHeight = $(this).offset().top;
                    if (topHeight + $(this).find(".pophoverCnt").height() > $(document).height()) {
                        hight = (topHeight + $(this).find(".pophoverCnt").height() - $(document).height());
                        pophoverCnt.css('top', topHeight - 200 - hight);
                    } else {
                        pophoverCnt.css('top', topHeight - 200);
                    }
                    pophoverCnt.show();
                    id = $(this).find(".pophoverCnt").find("div[id^='popover_tooltip']").first().attr('id');
                    if (typeof id != 'undefined') {
                        id = id.replace("popover_tooltip", "");
                    }
                    $(this).find(".pophoverCnt").find("div[id^='popover_tooltip']").highcharts({
                        chart: {
                            margin: 0,
                            padding: 0,
                            type: 'pie',
                            width: 150,
                            height: 150,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingRight: 0,
                            spacingTop: 0,
                        },
                        title: {
                            text: null
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>' + this.point.name + '</b><br />' + this.point.hours;
                            }
                        },
                        plotOptions: {
                            pie: {
                                size: 120,
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true
                            }
                        },
                        legend: {
                            enabled: false,
                            labelFormatter: function() {
                                return this.name + ' - ' + this.y + '%s';
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        series: newArray[id]
                    });
                }
            });
            $(".container_pie").closest('td').mouseleave(function(res) {
                $(this).find(".pophoverCnt").hide();
                if ($('.tipsy:hover').length) {
                    return false;
                }
            });
        }
    }
    $scope.pad = function(d) {
        return (d < 10) ? '0' + d.toString() : d.toString();
    }
    $scope.get_chart_timelog = function(d) {
        $scope.HTTP_ROOT = HTTP_ROOT;
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (typeof d != 'undefined') {
            $scope.date = d;
        } else {
            $scope.date = moment().format("YYYY-MM-DD");
        }
        $scope.day = moment($scope.date, "YYYY-MM-DD").format('DD');
        $scope.month = moment($scope.date, "YYYY-MM-DD").format('MM');
        $scope.year = moment($scope.date, "YYYY-MM-DD").format('YYYY');
        $scope.nextMonth = moment($scope.date, "YYYY-MM-DD").add(1, 'months').format('YYYY-MM-DD');
        $scope.prevMonth = moment($scope.date, "YYYY-MM-DD").add(-1, 'months').format('YYYY-MM-DD');
        $scope.title = months[moment($scope.date, "YYYY-MM-DD").format('M') - 1];
        $scope.dayOfWeek = moment($scope.year + '-' + $scope.month + '-01', "YYYY-MM-DD").format('ddd');
        $scope.daysInMonth = moment($scope.date, "YYYY-MM").daysInMonth();
        $scope.blank = moment($scope.year + '-' + $scope.month + '-01', "YYYY-MM").isoWeekday();
        $scope.blankRange = [];
        $scope.dateRange = [];
        $scope.dayIndex = 1;
        $scope.dateRangeTMP = [];
        for (var i = 0; i < $scope.blank; i++) {
            $scope.blankRange.push(i);
            $scope.dateRangeTMP.push($scope.dateRangeTMP.length + 1);
        }
        for (var i = 0; i < $scope.daysInMonth; i++) {
            $scope.dateRange.push(i);
            $scope.dateRangeTMP.push($scope.dateRangeTMP.length + 1);
        }
        $('#caseLoader').show();
        params = {};
        params.casePage = $('#casePage').val();
        params.projFil = $('#projFil').val();
        params.projIsChange = $('#projIsChange').val();
        params.customfilter = $('#customFIlterId').value;
        params.caseStatus = $('#caseStatus').val();
        params.priFil = $('#priFil').val();
        params.caseTypes = $('#caseTypes').val();
        params.caseLabel = $('#caseLabel').val();
        params.caseMember = $('#caseMember').val();
        params.caseMember = $('#caseComment').val();
        params.caseAssignTo = $('#caseAssignTo').val();
        params.caseSearch = $("#case_search").val();
        params.case_date = $('#caseDateFil').val();
        params.case_due_date = $('#casedueDateFil').val();
        params.case_srch = $('#case_srch').val();
        params.currentdate = (typeof d != 'undefined') ? d : "";
        params.angular = 1;
        var params_data = $.param(params);
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/showChartView", params_data, config).success(function(data, status, headers, config) {
            $('#caseLoader').hide();
            $('.hidetablelog').hide();
            $('#TimeLog_paginate').hide();
            $scope.records = data;
            $timeout(function() {
                $scope.drawPie();
            }, 1000);
            $('.r-u-link').hide();
            if (SES_TYPE < 3) {
                $('.r-u-link').show();
            }
            if (localStorage.getItem("tour_type") == '4') {
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_tandresrc + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_tandresrc;
                }
                hopscotch.startTour(GBl_tour, hopscotch.getCurrStepNum());
            }
        });
    }
    $scope.get_chart_timelog();
    $scope.getNumber = function(num) {
        arr = new Array();
        for (var i = 0; i < num; i++) {
            arr.push(i);
        }
        return arr;
    }
    $scope.addindex = function(num) {
        $scope.dayIndex++;
    }
    $scope.checkForPopup = function(number) {
        if ($scope.records) {
            number = Array(Math.max(0 - String(number).length + 1, 0)).join(0) + number;
            if ($scope.records.chart[number]) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    $scope.isAllowed = function(action) {
        return isAllowed(action);
    }
})
caseapp.controller('timelogController', function($scope, $http) {
    $scope.entries = {};
    $scope.totalItems = 0;
    $scope.SES_ID = SES_ID;
    $scope.SES_TYPE = SES_TYPE;
    $scope.shortLength = function(title, len, len2, len3) {
        titleA = title.split('||');
        var value_format = formatText(value);
        var value_raw = html_entity_decode(value_format, 'ENT_QUOTES');
        if (value_raw.length > len) {
            var value_strip = value_raw.substr(0, len);
            value_strip = formatText(value_strip);
            var lengthvalue = '';
            var t_value_strip = value_strip;
            if (arguments[3]) {
                t_value_strip = htmlspecialchars(value_strip);
            }
            lengthvalue = "" + t_value_strip + "...";
        } else {
            var t_value_strip = value_format;
            if (arguments[3]) {
                t_value_strip = htmlspecialchars(value_format);
            }
            lengthvalue = t_value_strip;
        }
        return lengthvalue;
    }
    $scope.inittooltip = function() {
        $('[rel=tooltip]').tipsy({
            gravity: 'e',
            fade: true
        });
    }
    $scope.fetchTimelog = function(column, page) {
        $(".side-nav li").each(function() {
            $(this).removeClass('active');
        });
        $('.menu-logs').addClass('active');
        if (!(localStorage.getItem("theme_setting") === null)) {
            var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
            $(".side-nav li").each(function() {
                $(this).removeClass(th_class_str);
            });
            $('.menu-logs').addClass(th_set_obj.sidebar_color + " gradient-shadow");
        }
        if (typeof column != 'undefined' && column == "") {
            $scope.column = $scope.column;
        } else {
            $scope.column = column;
            $scope.orderby = "asc";
        }
        if (typeof column != 'undefined' && column != '') {
            $('#isSort').val("1");
            if (typeof(getCookie("TASKSORTBY") != 'undefined') && getCookie("TASKSORTBY") == column) {
                if (getCookie('TASKSORTORDER') == 'ASC') {
                    remember_filters("TASKSORTORDER", 'DESC');
                    $scope.orderby = 'desc';
                } else {
                    remember_filters("TASKSORTORDER", 'ASC');
                    $scope.orderby = 'asc';
                }
            } else {
                remember_filters("TASKSORTBY", column);
                remember_filters("TASKSORTORDER", 'DESC');
                $scope.orderby = 'desc';
            }
        }
        column = (typeof column != 'undefined' && column == '') ? $scope.column : column;
        $(".tsk_asc,.tsk_desc").addClass('hidden');
        $(".tsk_default").removeClass('hidden');
        $("#timelog_" + column + "_" + $scope.orderby).removeClass('hidden');
        $("#timelog_" + column + "_" + $scope.orderby).siblings(".tsk_default").addClass('hidden');
        $('#caseLoader').show();
        filter = '';
        var params = {
            projFil: $('#projFil').val()
        };
        setResetTlogFilter(filter);
        params.filter = $('#tlog_date').val();
        var search_reset = false;
        var prjunid = $('#projFil').val();
        params.projuniqid = prjunid;
        var usrid = filter;
        params.usrid = usrid;
        search_reset = true;
        params.usrid = $('#tlog_resource').val();
        if ($('#logstrtdt').val() != '') {
            var strdt = $('#logstrtdt').val();
            params.strddt = strdt;
            search_reset = true;
        }
        if ($('#logenddt').val() != '') {
            var eddt = $('#logenddt').val();
            params.enddt = eddt;
            search_reset = true;
        }
        params.casePage = (typeof page != "undefined") ? page : 1;
        task_id = '';
        params.task_id = task_id;
        var params_data = $.param(params);
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "requests/time_log", params_data, config).success(function(data, status, headers, config) {
            $('#caseLoader').hide();
            $scope.records = data;
            $scope.totalItems = data.logtimes.caseCount;
            $(".show_total_case").show();
            $scope.records.pagename = typeof $scope.records.logtimes.page != 'undefined' ? $scope.records.logtimes.page : '';
            if (typeof localStorage['open_timelog'] != 'undefined' && localStorage['open_timelog'] == 1) {
                createlog(0, '');
                localStorage.removeItem('open_timelog');
            }
            var SHOWTIMELOG = getCookie('SHOWTIMELOG');
            var pagename = typeof data.logtimes.page != 'undefined' ? data.logtimes.page : '';
            if (pagename == 'taskdetails' && SHOWTIMELOG == '') {
                SHOWTIMELOG = 'No';
            }
            SHOWTIMELOG = typeof data.logtimes.page != 'undefined' && data.logtimes.page == 'taskdetails' ? SHOWTIMELOG : 'Yes';
            var d_y_n = '';
            var tlog_btn = '';
            if (SHOWTIMELOG == 'No') {
                d_y_n = 'style="display:none;"';
            }
            var t_ttl = htmlspecialchars(data.logtimes.task_title);
            tlog_btn = '<a ' + d_y_n + ' onclick="createlog(' + data.logtimes.task_id + ',\'' + t_ttl + '\')" href="javascript:void(0)" class="<%=logtimes.page%> anchor log-more-time btn btn-raised btn-sm btn_cmn_efect"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>' + _('Log more time') + '</a><a ' + d_y_n + ' href="javascript:void(0)" onclick="ajax_timelog_export_csv();" class="btn btn-raised btn-sm btn_cmn_efect" rel="tooltip" title="Export To CSV"><i class="material-icons">&#xE8D5;</i></a>';
            $('.btn_tlog_top_fun').html(tlog_btn);
            $('#caseLoader').hide();
            $('#TimeLog_paginate').show();
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            if (!isAllowed('View All Resource')) {
                $("#dropdown_menu_resource").closest('li').hide();
            } else {
                $("#dropdown_menu_resource").closest('li').show();
            }
            if (typeof data.projUser != 'undefined') {
                PUSERS = data.projUser;
            }
            var user_found = false;
            if (!isAllowed('View All Resource')) {
                var usrhtml = "<option value=''>" + _('Select User') + "</option>";
                $.each(PUSERS, function(key, val) {
                    $.each(val, function(k1, v1) {
                        var user_id = v1['User']['id'];
                        usrhtml += "<option value='" + user_id + "' title='" + v1['User']['name'] + "'>" + shortLength(v1['User']['name'], '15', 1) + "</option>";
                        if (usrid == user_id) {
                            user_found = true;
                        }
                    });
                });
                $('#rsrclog').html(usrhtml).val(user_found == true ? usrid : '');
            }
            if ($scope.records.timelog_filter_msg == '' || $scope.records.timelog_filter_msg == null) {
                $('.timelog_filter_msg').hide();
            } else {
                $('.timelog_filter_msg').show();
                $('.timelog_filter_msg').html('<span class="tg_msg_pos">' + $scope.records.timelog_filter_msg + '</span> <span class="ico-close timelog_filter_msg_close" rel="tooltip" title="Reset All"><i class="material-icons">&#xE8BA;</i></span>');
            }
            if (search_reset) {
                setTimeout(function() {
                    $('#btn-reset-timelog').show()
                }, 200);
            } else {
                $('#btn-reset-timelog').hide();
            }
            $(document).on('click', '#ui-datepicker-div', function(e) {
                e.stopPropagation();
            });
            $(document).on('click', '.ui-datepicker-prev', function(e) {
                e.stopPropagation();
            });
            $(document).on('click', '.ui-datepicker-next', function(e) {
                e.stopPropagation();
            });
            displayMenuProjects('dashboard', '6', '');
            $.material.init();
            if (localStorage.getItem("tour_type") == '4') {
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_tandresrc + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_tandresrc;
                }
                hopscotch.startTour(GBl_tour, 2);
            }
            $('.r-u-link').hide();
            if (SES_TYPE < 3) {
                $('.r-u-link').show();
            }
            if (KEEP_HOVER_EFFECT != '0' && ((KEEP_HOVER_EFFECT & 1) == 1)) {
                $('.timelog_cond_cls').addClass('keep_hover_efct');
            }
            $(document).on('click', '.chkOneTlg', function(e) {
                var tlg_ids = new Array();
                var tot_tlg = $(".chkOneTlg").length;
                $(".chkOneTlg:checked").each(function() {
                    tlg_ids.push($(this).attr("data-logid"));
                });
                if (tlg_ids.length == tot_tlg) {
                    $(".chkOneAllTlg").prop('checked', true);
                } else {
                    $(".chkOneAllTlg").prop('checked', false);
                }
                if (tlg_ids.length > 0) {
                    $(".tlg_bill_typ").show();
                } else {
                    $(".tlg_bill_typ").hide();
                }
            });
            $(document).on('click', '.chkOneAllTlg', function(e) {
                var tlg_ids = new Array();
                if ($(".chkOneAllTlg").is(":checked")) {
                    $(".chkOneTlg").prop('checked', true);
                    $(".chkOneTlg:checked").each(function() {
                        tlg_ids.push($(this).attr("data-logid"));
                    });
                    if (tlg_ids.length > 0) {
                        $(".tlg_bill_typ").show();
                    } else {
                        $(".tlg_bill_typ").hide();
                    }
                } else {
                    $(".tlg_bill_typ").hide();
                    $(".chkOneTlg").prop('checked', false);
                }
            });
            $(".chkOneAllTlg").prop('checked', false);
        });
    }
    $scope.total_hrs_of_page = function() {
        var total = 0;
        if (typeof $scope.records != 'undefined') {
            if ($scope.records.logtimes.caseCount > 0) {
                p = $scope.records.logtimes.logs;
                for (var key in p) {
                    if (p.hasOwnProperty(key)) {
                        total += parseInt(p[key].LogTime.total_hours);
                    }
                }
            }
        }
        return total;
    }
    $scope.isAllowed = function(action) {
        return isAllowed(action);
    }
    $scope.fetchTimelog();
    easycase.routerHideShow('timelog', 'angular');
}).filter('moment', function(moment) {
    return function(input, options) {
        return moment(input).locale('eng').format(options.split('\'')[1])
    }
});
caseapp.filter('keylength', function() {
    return function(input) {
        if (!angular.isObject(input)) {
            return '0';
        }
        return Object.keys(input).length;
    }
})
caseapp.filter("splitTask", function() {
    return function(input, options) {
        task_dtl = input.split('||');
        return task_dtl[options];
    }
});
caseapp.filter("splitTask1", function() {
    return function(input, options) {
        task_dtl = input.split('|__|');
        return task_dtl[options];
    }
});
caseapp.filter("formatText", function() {
    return function(input, options) {
        return formatText(input);
    }
});
caseapp.filter("translate", function() {
    return function(input) {
        return _(input);
    }
});
caseapp.filter("momentSecond", function() {
    return function(input, options) {
        if (typeof input != 'undefined') {
            tarr = new Array();
            tarr[0] = Math.floor(input / 3600);
            input %= 3600;
            tarr[1] = Math.floor(input / 60);
            m = (tarr[1] != '0') ? tarr[1] + ' mins' : '';
            h = (tarr[0] != '0') ? tarr[0] + ' hrs' : '';
            return (h != '' || m != '') ? h + " " + m : '---';
        } else {
            return '---';
        }
    }
});
caseapp.filter("formatdate", function() {
    return function(time, options) {
        if (time == '--') {
            return '---';
        }
        var out_time = time.substr(0, (time.lastIndexOf(':')));
        var out_time_arr = time.split(':');
        if (SES_TIME_FORMAT == 12) {
            var out_mode = parseInt(out_time_arr[0]) < 12 ? 'am' : 'pm';
            var out_hr = parseInt(out_time_arr[0]) > 12 ? parseInt(out_time_arr[0]) - 12 : parseInt(out_time_arr[0]);
            var out_min = parseInt(out_time_arr[1]);
            return (out_hr > 0 ? out_hr : 12) + ':' + (out_min < 10 ? '0' : '') + out_min + '' + out_mode;
        } else {
            var out_mode = '';
            var out_hr = parseInt(out_time_arr[0]);
            var out_min = parseInt(out_time_arr[1]);
            return (out_hr < 10 ? '0' : '') + out_hr + ':' + (out_min < 10 ? '0' : '') + out_min + '' + out_mode;
        }
    }
});
caseapp.filter("momentSecond1", function() {
    return function(input, options) {
        tarr = new Array();
        if (input) {
            tarr[0] = Math.floor(input / 3600);
            input %= 3600;
            tarr[1] = Math.floor(input / 60);
            m = (tarr[1] != '0') ? tarr[1] : '00';
            h = (tarr[0] != '0') ? tarr[0] : '00';
            h = h.toString();
            m = m.toString();
            h = (h.length == 1) ? '0' + h.toString() : h.toString();
            m = (m.length == 1) ? '0' + m.toString() : m.toString();
            return h + ":" + m;
        } else {
            return "00:00";
        }
    }
});
caseapp.controller("upcoming_Controller", function($scope, $http) {
    $scope.loadUpcoming = function(type) {
        var data = $.param({
            type: type,
            angular: 1,
            projid: $("#projFil").val()
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "users/ajax_upcoming/", data, config).success(function(data, status, headers, config) {
            $scope.upcoming_records = data;
            $("#moreOverdueloader").hide();
        });
    }
});

function loadOverdue(type) {
    $("#moreOverdueloader").show();
    angular.element(document.getElementById('Overdue')).scope().loadOverdue(type);
    angular.element(document.getElementById('Overdue')).scope().$apply();
}

function loadActivity(type) {
    var displayed = $("#displayed").val();
    var prj_id = $("#projFil").val();
    var limit1, limit2, projid;
    if (type == "more") {
        limit1 = displayed;
        limit2 = 10;
        projid = prj_id;
    } else {
        limit1 = 0;
        limit2 = 29;
        projid = prj_id;
    }
    if (type == "more") {
        $(".morebar").show();
    } else {
        $("#caseLoader").show();
    }
    $("#PieChart").hide();
    $("#ajax_activity_tmpl").show();
    var strURL = HTTP_ROOT + "users/ajax_activity/";
    angular.element(document.getElementById('activityController')).scope().getActivity(strURL, type, limit1, limit2, projid);
    angular.element(document.getElementById('activityController')).scope().$apply();
}
function loadUpcoming(type) {
    $("#moreOverdueloader").show();
    angular.element(document.getElementById('Upcoming')).scope().loadUpcoming(type);
    angular.element(document.getElementById('Upcoming')).scope().$apply();
}

function showHideMoreReply(id, type) {
    var showhidemorereply = "showhidemorereply" + id;
    var morereply = "morereply" + id;
    var hidereply = "hidereply" + id;
    var loadreply = "loadreply" + id;
    var totdata1 = "totdata" + id;
    var totdata = document.getElementById(totdata1).value;
    if (totdata > 10 && type != "post") {
        if (type == "less") {
            document.getElementById(morereply).style.display = 'inline';
            document.getElementById(hidereply).style.display = 'none';
            for (i = 11; i <= totdata; i++) {
                var rep = "rep" + i;
                document.getElementById(rep).style.display = 'none';
            }
            $('#threadview_type' + id).val('less');
        } else if (type == "more") {
            document.getElementById(morereply).style.display = 'none';
            document.getElementById(hidereply).style.display = 'inline';
            for (i = 11; i <= totdata; i++) {
                var rep = "rep" + i;
                document.getElementById(rep).style.display = 'block';
            }
            $('#threadview_type' + id).val('more');
        }
    } else {
        if (type != "post") {
            document.getElementById(loadreply).style.visibility = 'visible';
        }
        var strURL = HTTP_ROOT + "easycases/case_reply";
        $.post(strURL, {
            "id": id,
            "type": type,
            sortorder: $('#thread_sortorder' + id).val()
        }, function(data) {
            if (data) {
                document.getElementById(loadreply).style.visibility = 'hidden';
                $("#" + showhidemorereply).html(tmpl("case_replies_tmpl", data));
                bindPrettyview("prettyPhoto");
                if (type == "post") {
                    alert(_('This is an error! Please refresh the page'));
                } else if (type == "more") {
                    $('#threadview_type' + id).val('more');
                    document.getElementById(morereply).style.display = 'none';
                    document.getElementById(hidereply).style.display = 'inline';
                } else if (type == "less") {
                    $('#threadview_type' + id).val('less');
                    document.getElementById(morereply).style.display = 'inline';
                    document.getElementById(hidereply).style.display = 'none';
                }
            }
        });
    }
}

function sortreply(id, uniqid) {
    if ($('#thread_sortorder' + id).val() == 'ASC') {
        $('#thread_sortorder' + id).val('DESC');
    } else {
        $('#thread_sortorder' + id).val('ASC');
    }
    var sortorder = $('#thread_sortorder' + id).val();
    var type = $('#threadview_type' + id).val();
    var strURL = HTTP_ROOT + "easycases/case_reply";
    var showhidemorereply = "showhidemorereply" + id;
    var morereply = "morereply" + id;
    var hidereply = "hidereply" + id;
    var loadreply = "loadreply" + id;
    if (type == 'less') {
        var viewtype = 'post';
    } else {
        var viewtype = type;
    }
    if ($('#remain_case' + id).val()) {
        var rem_cases = $('#remain_case' + id).val();
    } else {
        var rem_cases = 0;
    }
    $('#loadreply_sort_' + id).css('visibility', 'visible');
    $.post(strURL, {
        "id": id,
        "type": viewtype,
        'sortorder': sortorder,
        'rem_cases': rem_cases
    }, function(data) {
        if (data) {
            $('#loadreply_sort_' + id).css('visibility', 'hidden');
            var results = document.getElementById(showhidemorereply);
            results.innerHTML = tmpl("case_replies_tmpl", data);
            bindPrettyview("prettyPhoto");
            if ($('#thread_sortorder' + id).val() == 'DESC') {
                $('#repsort_asc_' + id).show();
                $('#repsort_desc_' + id).hide();
            } else {
                $('#repsort_asc_' + id).hide();
                $('#repsort_desc_' + id).show();
            }
            if (type == "more") {
                $('#' + morereply).hide();
                $('#' + hidereply).show();
            } else if (type == "less") {
                $('#' + morereply).show();
                $('#' + hidereply).hide();
            }
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
        }
    });
}

function multipleCaseAction(hidid) {
    var page_location = getHash().indexOf('backlog');
    var prjunid = $('#projFil').val();
    if (prjunid == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _('All') + '" ' + _('project. Please choose a project.'));
        return false;
    }
    var idfor = Array();
    var caseid = Array();
    var splt = Array();
    var done = 1;
    var cscnt = 0;
    var casenos = "";
    if (parseInt($("#subtask-container").height()) > 70) {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
        if (done) {
            if (caseid.length == 0) {
                showTopErrSucc('error', _("No task selected. Please select at least one task."));
            } else {
                document.getElementById(hidid).value = caseid;
                document.getElementById('slctcaseid').value = idfor;
                ajaxCaseSubtaskView();
            }
        }
    } else if (page_location == 0) {
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
        if (done) {
            if (caseid.length == 0) {
                showTopErrSucc('error', _("No task selected. Please select at least one task."));
            } else {
                document.getElementById(hidid).value = caseid;
                document.getElementById('slctcaseid').value = idfor;
                refreshActvt = 1;
                $.post(HTTP_ROOT + "requests/ajaXTaskMassAction", {
                    caseid: caseid,
                    statusid: hidid,
                    projFil: $('#projFil').val()
                }, function(res) {
                    if (res.status == 'success') {
                        showTopErrSucc('success', _("Status changed successfully") + ".");
                        $.post(HTTP_ROOT + "requests/ajaxemail", {
                            'json_data': res.email_arr,
                            'type': 1
                        });
                        easycase.showbacklog();
                    } else {
                        showTopErrSucc('error', 'Oops! Something went wrong');
                    }
                }, 'json');
            }
        }
    } else if (getCookie('TASKGROUPBY') == 'milestone') {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
        if (done) {
            if (caseid.length == 0) {
                showTopErrSucc('error', _("No task selected. Please select at least one task."));
            } else {
                document.getElementById(hidid).value = caseid;
                document.getElementById('slctcaseid').value = idfor;
                refreshActvt = 1;
                easycase.refreshTaskList();
            }
        }
    } else if (getCookie('SUBTASKVIEW') == 'subtaskview') {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
        if (done) {
            if (caseid.length == 0) {
                showTopErrSucc('error', _("No task selected. Please select at least one task."));
            } else {
                document.getElementById(hidid).value = caseid;
                document.getElementById('slctcaseid').value = idfor;
                refreshActvt = 1;
                $.post(HTTP_ROOT + "requests/ajaXTaskMassAction", {
                    caseid: caseid,
                    statusid: hidid,
                    projFil: $('#projFil').val()
                }, function(res) {
                    if (res.status == 'success') {
                        showTopErrSucc('success', _("Status changed successfully") + ".");
                        $.post(HTTP_ROOT + "requests/ajaxemail", {
                            'json_data': res.email_arr,
                            'type': 1
                        });
                easycase.refreshTaskList();
                    } else {
                        showTopErrSucc('error', 'Oops! Something went wrong');
                    }
                }, 'json');
            }
        }
    } else {
        var x = $('#hid_cs').val();
        for (var i = 1; i <= x; i++) {
            var id = "actionChk" + i;
            if ($('#' + id).length && document.getElementById(id).disabled == false) {
                if (document.getElementById(id).checked == true) {
                    var actionCls = "actionCls" + i;
                    var legend = document.getElementById(actionCls).value;
                    var val = document.getElementById(id).value;
                    var splt = val.split("|");
                    var caseRes = 0;
                    if (legend == 1 || legend == 2 || legend == 4 || legend == 5) {
                        caseRes = 1;
                    }
                    if (legend == 3 && hidid == "caseId") {
                        casenos += splt[1] + ",";
                        cscnt++;
                    } else if (hidid == "caseStart" && legend != 1) {
                        casenos += splt[1] + ",";
                        cscnt++;
                    } else if (hidid == "caseResolve" && caseRes == 0) {
                        casenos += splt[1] + ",";
                        cscnt++;
                    } else if (hidid == "caseNew" && caseRes == 0) {
                        casenos += splt[1] + ",";
                        cscnt++;
                    } else {
                        caseid.push(splt[0]);
                        idfor.push(splt[1]);
                        done++;
                        if (splt[2]) {
                            $("#t_" + splt[2]).remove();
                        }
                    }
                }
            }
        }
        if (cscnt) {
            var casenos = casenos.substr(0, casenos.length - 1);
            if (hidid == "caseStart") {
                var msg = _("started");
            }
            if (hidid == "caseResolve") {
                var msg = _("resolved");
            }
            if (hidid == "caseId") {
                var msg = _("closed");
            }
            if (hidid == "caseNew") {
                var msg = _("changed to new");
            }
            showTopErrSucc('error', _("Task") + " #" + casenos + " " + _("cannot be") + " " + msg + "!");
            if (cscnt == 1 && msg) {} else if (msg) {}
        }
        if (done) {
            if (caseid.length == 0) {
                showTopErrSucc('error', _("No task selected. Please select at least one task."));
            } else {
                document.getElementById(hidid).value = caseid;
                document.getElementById('slctcaseid').value = idfor;
                refreshActvt = 1;
                easycase.refreshTaskList();
            }
        }
    }
}

function enableButtons() {
    if ($('.chkOneTsk:not(:disabled):checked').length) {
        $('#chkAllTsk').parents('.dropdown').addClass('active');
        $('.mass_action_dpdwn').attr('data-toggle', 'dropdown');
        $('.mass_action_dpdwn .material-icons').addClass('active');
    } else {
        $('#chkAllTsk').parents('.dropdown').removeClass('active');
        $('.mass_action_dpdwn').attr('data-toggle', '');
        $('.mass_action_dpdwn .material-icons').removeClass('active');
    }
    if ($('.chkOneTsk:checked').length) {
        $('#chkAllTsk').parents('.dropdown').addClass('active');
        $('.mass_action_dpdwn').attr('data-toggle', 'dropdown');
        $('.mass_action_dpdwn .material-icons').addClass('active');
    }
}
$(function(chkAll, chkOne, row, active_class) {
    $(document).on('click', chkAll, function(e) {
        if (getCookie('TASKGROUPBY') == 'milestone') {
            if ($(chkAll).is(':checked')) {
                $("tr.trans_row:visible").each(function() {
                    $(this).find(chkOne + ":not(:disabled)").prop('checked', true);
                    $(this).find(chkOne + ":not(:disabled)").parents(row).addClass(active_class);
                });
            } else {
                $(chkAll).parent().removeClass('open');
                $("tr.trans_row:visible").each(function() {
                    $(this).find(chkOne + ":not(:disabled)").prop('checked', false);
                    $(this).find(chkOne + ":not(:disabled)").parents(row).removeClass(active_class);
                });
            }
        } else {
            if ($(chkAll).is(':checked')) {
                $(chkOne + ":not(:disabled)").prop('checked', true);
                $(chkOne + ":not(:disabled)").parents(row).addClass(active_class);
            } else {
                $(chkAll).parent().removeClass('open');
                $(chkOne + ":not(:disabled)").prop('checked', false);
                $(chkOne + ":not(:disabled)").parents(row).removeClass(active_class);
            }
        }
        enableButtons();
    });
    $(document).on('click', chkOne, function(e) {
        if (getCookie('TASKGROUPBY') == 'milestone') {
            if ($(this).is(':checked')) {
                $(this).parents(row).addClass(active_class);
            } else {
                $(chkAll).parent().removeClass('open');
                $(this).parents(row).removeClass(active_class);
            }
            if ($("tr.trans_row:visible " + chkOne + ':not(:disabled):checked').length == $("tr.trans_row:visible " + chkOne + ':not(:disabled)').length) {
                $(chkAll).prop('checked', true);
            } else {
                $(chkAll).prop('checked', false);
            }
        } else {
            if ($(this).is(':checked')) {
                $(this).parents(row).addClass(active_class);
            } else {
                $(chkAll).parent().removeClass('open');
                $(this).parents(row).removeClass(active_class);
            }
            if ($(chkOne + ':not(:disabled):checked').length == $(chkOne + ':not(:disabled)').length) {
                $(chkAll).prop('checked', true);
            } else {
                $(chkAll).prop('checked', false);
            }
        }
        enableButtons();
    });
}('#chkAllTsk', '.chkOneTsk', '.tr_all', 'tr_all_active'));

function startCase(id, no, dtlsid) {
    var isPopup = (typeof arguments[3] != 'undefined' && arguments[3] == 'popup') ? 1 : 0;
    var isSub = (typeof arguments[4] != 'undefined' && arguments[4] == 'sub') ? 1 : 0;
    refreshActvt = 1;
    refreshKanbanTask = 1;
    refreshTasks = 1;
    refreshManageMilestone = 1;
    refreshMilestone = 1;
    if (dtlsid) {}
    var hashtag = parseUrlHash(urlHash);
    if (hashtag[0] != 'details') {
        $('#caseStart').val(id);
    }
    if ((hashtag[0] == 'kanban') || (hashtag[0] == 'milestonelist') || (($('#caseMenuFilters').val() != 'cases') || (hashtag[0] == 'details')) || (getCookie('TASKGROUPBY') == 'milestone') || isPopup == 1 || (hashtag[0] == 'taskgroups')) {
        if (isSub) {
            actiononTask(id, dtlsid, no, 'start', '', '', 'sub');
        } else if (isPopup == 1) {
            actiononTask(id, dtlsid, no, 'start', 'popup');
        } else {
            actiononTask(id, dtlsid, no, 'start');
        }
    } else {
        if (parseInt($("#subtask-container").height()) > 70) {
            actiononTask(id, dtlsid, no, 'start');
        } else {
            easycase.refreshTaskList(dtlsid);
        }
    }
}

function changeCaseType(id, no) {
    $('#caseChangeType').val(id);
    $('#slctcaseid').val(no);
}

function caseResolve(id, no, dtlsid) {
    var isPopup = (typeof arguments[3] != 'undefined' && arguments[3] == 'popup') ? 1 : 0;
    var isSub = (typeof arguments[4] != 'undefined' && arguments[4] == 'sub') ? 1 : 0;
    refreshActvt = 1;
    refreshKanbanTask = 1
    refreshTasks = 1;
    refreshManageMilestone = 1;
    refreshMilestone = 1;
    if (dtlsid) {}
    var hashtag = parseUrlHash(urlHash);
    if (hashtag[0] != 'details') {
        $('#caseResolve').val(id);
    }
    if (hashtag[0] == 'kanban' || hashtag[0] == 'milestonelist' || (($('#caseMenuFilters').val() != 'cases') || (hashtag[0] == 'details')) || (getCookie('TASKGROUPBY') == 'milestone') || isPopup == 1 || (hashtag[0] == 'taskgroups')) {
        if (isSub) {
            actiononTask(id, dtlsid, no, 'resolve', '', '', 'sub');
        } else if (isPopup == 1) {
            actiononTask(id, dtlsid, no, 'resolve', 'popup');
        } else {
            actiononTask(id, dtlsid, no, 'resolve');
        }
    } else {
        if (parseInt($("#subtask-container").height()) > 70) {
            actiononTask(id, dtlsid, no, 'resolve');
        } else {
            easycase.refreshTaskList(dtlsid, 1);
        }
    }
}

function setNewCase(id, no, dtlsid) {
    var isPopup = (typeof arguments[3] != 'undefined' && arguments[3] == 'popup') ? 1 : 0;
    var isSub = (typeof arguments[4] != 'undefined' && arguments[4] == 'sub') ? 1 : 0;
    refreshActvt = 1;
    refreshKanbanTask = 1;
    refreshTasks = 1;
    refreshManageMilestone = 1;
    refreshMilestone = 1;
    var hashtag = parseUrlHash(urlHash);
    if (hashtag[0] != 'details') {
        $('#caseNew').val(id);
    }
    if ((hashtag[0] == 'kanban') || (hashtag[0] == 'milestonelist') || (($('#caseMenuFilters').val() != 'cases') || (hashtag[0] == 'details')) || hashtag[0] == 'details' || (getCookie('TASKGROUPBY') == 'milestone') || isPopup == 1 || (hashtag[0] == 'taskgroups')) {
        if (isSub) {
            actiononTask(id, dtlsid, no, 'new', '', '', 'sub');
        } else if (isPopup == 1) {
            actiononTask(id, dtlsid, no, 'new', 'popup');
        } else {
            actiononTask(id, dtlsid, no, 'new');
        }
    } else {
        if (parseInt($("#subtask-container").height()) > 70) {
            actiononTask(id, dtlsid, no, 'new');
        } else {
            easycase.refreshTaskList(dtlsid, 1);
        }
    }
}

function setCloseCase(id, no, dtlsid) {
    var isPopup = (typeof arguments[3] != 'undefined' && arguments[3] == 'popup') ? 1 : 0;
    var isSub = (typeof arguments[4] != 'undefined' && arguments[4] == 'sub') ? 1 : 0;
    var is_parent = 0;
    if ($('#curRow' + id).length) {
        is_parent = $.trim($('#curRow' + id).attr('data-is-parent'));
    }
    refreshActvt = 1;
    refreshKanbanTask = 1;
    refreshTasks = 1;
    refreshManageMilestone = 1;
    refreshMilestone = 1;
    var hashtag = parseUrlHash(urlHash);
    var cls_msg = _("All subtasks of this parent task will be closed, are you sure you want to continue?");
    if (hashtag[0] == 'details') {
        is_parent = 1;
        cls_msg = _("All subtasks of this task will be closed, are you sure you want to continue?");
    }
    var is_confirm = 1;
    if (isSub) {
        if ($('#case_ttl_edit_main_' + $('#closecase_id' + id).val()).find('.sub-tasks').find('.case_symb').length && $('#case_ttl_edit_main_' + $('#closecase_id' + id).val()).find('.sub-tasks').find('.case_symb').length == 1 && hashtag[0] == 'details') {
            is_confirm = 0;
        }
    }
    if (is_confirm && is_parent == 1 && !confirm(cls_msg)) {
        return false;
    }
    if (hashtag[0] != 'details') {
        $('#caseId').val(id);
    }
    if ((hashtag[0] == 'kanban') || (hashtag[0] == 'milestonelist') || (($('#caseMenuFilters').val() != 'cases') || (hashtag[0] == 'details')) || hashtag[0] == 'details' || (getCookie('TASKGROUPBY') == 'milestone') || isPopup == 1 || (hashtag[0] == 'taskgroups')) {
        if (isSub) {
            actiononTask(id, dtlsid, no, 'close', '', '', 'sub');
        } else if (isPopup == 1) {
            actiononTask(id, dtlsid, no, 'close', 'popup');
        } else {
            actiononTask(id, dtlsid, no, 'close', '', is_parent);
        }
    } else {
        if (parseInt($("#subtask-container").height()) > 70) {
            actiononTask(id, dtlsid, no, 'close');
        } else {
            easycase.refreshTaskList(dtlsid, 1);
        }
    }
}

function multipleCustomAction(hidid, ststName, stsMasterid) {
    var page_location = getHash().indexOf('backlog');
    var prjunid = $('#projFil').val();
    var stsName = unescape(ststName);
    if (prjunid == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _('All') + '" ' + _('project. Please choose a project.'));
        return false;
    }
    var idfor = Array();
    var caseid = Array();
    var splt = Array();
    var done = 1;
    var cscnt = 0;
    var casenos = "";
    var hashtag = parseUrlHash(urlHash);
    if (getCookie('TASKGROUPBY') == 'milestone' || parseInt($("#subtask-container").height()) > 70) {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
    } else if (page_location == 0) {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
    } else if (hashtag[0] == "taskgroups") {
        var x = $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").length;
        $("tr.trans_row:visible .chkOneTsk:not(:disabled):checked").each(function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var splt = val.split("|");
            var caseRes = 0;
            caseid.push(splt[0]);
            idfor.push(splt[1]);
            done++;
        });
    } else {
        var x = $('#hid_cs').val();
        for (var i = 1; i <= x; i++) {
            var id = "actionChk" + i;
            if ($('#' + id).length && document.getElementById(id).disabled == false) {
                if (document.getElementById(id).checked == true) {
                    var actionCls = "actionCls" + i;
                    var legend = document.getElementById(actionCls).value;
                    var val = document.getElementById(id).value;
                    var splt = val.split("|");
                    var caseRes = 0;
                    if (legend == 1 || legend == 2 || legend == 4 || legend == 5) {
                        caseRes = 1;
                    }
                    caseid.push(splt[0]);
                    idfor.push(splt[1]);
                    done++;
                    if (splt[2]) {
                        $("#t_" + splt[2]).remove();
                    }
                }
            }
        }
        if (cscnt) {
            var casenos = casenos.substr(0, casenos.length - 1);
            showTopErrSucc('error', _("Task") + " #" + casenos + " " + _("cannot be") + " " + stsName + "!");
        }
    }
    if (done) {
        if (caseid.length == 0) {
            showTopErrSucc('error', _("No task selected. Please select at least one task."));
        } else {
            if (stsMasterid == 3) {
                reconf = _('All subtasks of the selected parent tasks status') + ' ' + _('will be changed to') + ' ' + stsName + ', ' + _('are you sure you want to continue?');
                if (!confirm(reconf)) {
                    return false;
                }
            }
            $.post(HTTP_ROOT + "easycases/ajax_changeMassCustomStatus", {
                caseid: caseid,
                statusid: hidid,
                masterid: stsMasterid
            }, function(res) {
                if (res.status == 'success') {
                    showTopErrSucc('success', _("Status changed successfully") + ".");
                    if (parseInt($("#subtask-container").height()) > 70) {
                        ajaxCaseSubtaskView();
                    } else if (page_location == 0) {
                        easycase.showbacklog();
                    } else {
                        easycase.refreshTaskList();
                    }
                } else {
                    if (res.msg) {
                        showTopErrSucc('error', res.msg);
                    } else {
                        showTopErrSucc('error', 'Oops! Something went wrong');
                    }
                }
            }, 'json');
        }
    }
}

function setCustomStatus(id, no, uid, statusid, masterid, actiontype) {
    var strurl = HTTP_ROOT + "easycases/check_parent_before_status";
    var is_parnt = (typeof arguments[6] != 'undefined' && arguments[6] != '') ? 1 : 0;
    var is_sub = (typeof arguments[7] != 'undefined' && arguments[7] != '') ? arguments[7] : 0;
    var is_popup = ($('#myModalDetail').length && $('#myModalDetail').is(':visible')) ? 1 : 0;
    if ($.trim(is_sub) == 'link') {
        is_parnt = arguments[6];
    }
    var hashtag = parseUrlHash(urlHash);
    $.post(strurl, {
        "parent_key": id,
        "validate_parent": 1,
        "status": statusid,
        "masterid": masterid
    }, function(res_chk) {
        var reconf = 1;
        if (res_chk.msg != '') {
            actiontype = res_chk.msg;
            reconf = _('All subtasks of this parent task #') + no + ' ' + _('will be') + ' ' + res_chk.msg + ', ' + _('are you sure you want to continue?');
            if (res_chk.statusid != '') {
                statusid = res_chk.statusid;
            }
        }
        if (reconf == 1 || confirm(reconf)) {
            $.post(HTTP_ROOT + "easycases/changeCustomStatus", {
                id: id,
                no: no,
                uniqid: uid,
                statusid: statusid,
                masterid: masterid,
                'is_sub': is_sub,
                'parent_task': is_parnt
            }, function(res) {
                if (client && typeof res.iotoserver != 'undefined') {
                    client.emit('iotoserver', res.iotoserver);
                }
                var haschield = (res.haschield) ? res.haschield : '';
                if (res.succ) {
                    $('[rel=tooltip]').tipsy({
                        gravity: 's',
                        fade: true
                    });
                    if (masterid == 3) {
                        if (isTimerRunning(id)) {
                            exitTimerPopup();
                        }
                    }
                    if ((hashtag[0] == 'tasks' || hashtag[0] == 'taskgroup') && (parseInt($("#subtask-container").height()) < 70) && !is_popup) {
                        if (!parseInt(is_parnt) && typeof res.checkParentids == 'undefined') {
                            tasklisttmplAdd(res.data.caseStsId);
                        } else {
                            if (typeof res.checkParentids != 'undefined') {
                                var rel_arr_prnt = $.map(res.checkParentids, function(el) {
                                    return el;
                                });
                                for (var i = 0; i < rel_arr_prnt.length; i++) {
                                    tasklisttmplAdd(rel_arr_prnt[i]);
                                }
                            }
                        }
                        showTopErrSucc('success', _('Status of task #') + no + ' ' + _('changed to') + ' ' + actiontype + '.');
                    } else if (hashtag[0] == 'details' || hashtag[0] == 'timesheet_weekly' || hashtag[0] == 'timesheet' || hashtag[0] == 'kanban' || hashtag[0] == 'milestonelist' || hashtag[0] == 'backlog' || (parseInt($("#subtask-container").height()) > 70) || (is_popup && (hashtag[0] == 'tasks' || hashtag[0] == 'taskgroup' || hashtag[0] == 'taskgroups'))) {
                        if (hashtag[0] == 'details') {
                            refreshTasks == 1;
                        }
                        if (is_sub == 'sub' || is_sub == 'link') {
                            showTopErrSucc('success', _("Status changed successfully") + ".");
                            if (res.parent_id != '') {
                                loadSubtaskInDetail(res.parent_id);
                            }
                            if (is_sub == 'link') {
                                $('#tab-taskLink').trigger('click');
                                $("#case_link_task" + is_parnt).html(tmpl("case_link_task_cmn_tmpl", res));
                            }
                        } else if (res.custom_status == 3 || res.prev_status == 3 || is_sub == 'popup') {
                            if (hashtag[0] == 'details' || is_popup == 1) {
                                if (is_sub == 'popup' || is_popup == 1) {
                                    easycase.ajaxCaseDetails(uid, 'case', 0, 'popup', 'action');
                                } else {
                                    easycase.ajaxCaseDetails(uid, 'case', 0);
                                }
                            }
                        } else if (hashtag[0] == 'details' || hashtag[0] == 'timesheet_weekly' || hashtag[0] == 'timesheet' || hashtag[0] == 'kanban' || hashtag[0] == 'backlog' || is_popup) {
                            $('.dtl_page_sts' + id).html(tmpl("case_details_sts__tmpl", res));
                            appendReplyThread(res.data.curCaseId, id);
                        }
                        if (parseInt($("#subtask-container").height()) > 70) {
                            ajaxCaseSubtaskView();
                        }
                    }
                    if (res.isAssignedUserFree != 1) {
                        var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                        openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                    }
                    $.post(HTTP_ROOT + "easycases/ajaxemail", {
                        'json_data': res.data,
                        'type': 1
                    });
                    if (hashtag[0] == 'tasks') {
                        refreshTasks == 1;
                    } else if (hashtag[0] == 'taskgroup') {
                        refreshTasks == 1;
                    } else if (hashtag[0] == 'details') {} else if (hashtag[0] == 'timesheet_weekly') {} else if ($('#caseMenuFilters').val() == 'milestonelist') {
                        showMilestoneList();
                    } else if (hashtag[0] == 'kanban') {
                        $(".item-" + id).appendTo($("#kanban_board_" + statusid).find('.kanban_content'));
                        getkanbanCounts();
                        tasklisttmplAdd(id, 0, 'sts');
                        if (haschield) {
                            easycase.showKanbanTaskList('kanban');
                            }
                    } else if (hashtag[0] == 'taskgroups') {
                        showTaskByTaskGroupNew();
                    } else {
                        easycase.showKanbanTaskList('kanban');
                    }
                } else {
                    if (res.err && res.msg) {
                        showTopErrSucc('error', res.msg);
                    } else {
                        showTopErrSucc('error', 'Oops! Something went wrong');
                    }
                }
            }, 'json');
        }
    }, 'json');
}

function mvtoProject(id, obj, alltask) {
    var is_multiple = 0;
    if (typeof alltask != 'undefined') {
        var chked = 0;
        $('input[id^="actionChk"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                chked = 1;
            }
        });
        if (chked == 0) {
            showTopErrSucc('error', _("Please check atleast one task to move"));
            return false;
        }
        var project_id = $('#curr_sel_project_id').val();
        is_multiple = 1;
        case_id = '';
        var title = _('Move All Task');
    } else {
        var project_id = $(obj).attr('data-prjid');
        var case_id = $(obj).attr('data-caseid');
        var case_no = $(obj).attr('data-caseno');
        var title = $(".case-title-kbn-" + case_id + " span:first-child").text();
        if (typeof title == 'undefined' || title == '') {
            if ($(".case_title_" + case_id + " span").length) {
                title = $(".case_title_" + case_id + " span:first-child").text();
            } else if ($("#titlehtml" + id + " span").length) {
                title = $("#titlehtml" + id + " span:first-child").text();
            } else if ($(".case-title_" + case_id + " span").length) {
                title = $(".case-title_" + case_id + " span:first-child").text();
            } else {
                title = $("#titlehtml" + id).text();
            }
            title = $.trim(title);
        }
        titlearr = title.split(": ");
        if (titlearr[0].indexOf('#') == 0) {
            titlearr[0] = titlearr[0].replace(new RegExp("\\d", "g"), "").replace("#", "");
            title = titlearr.join(" ");
        }
        if (title.length > 40)
            title = jQuery.trim(title).substring(0, 37).split(" ").slice(0, -1).join(" ") + "...";
    }
    openPopup();
    $(".mv_project").show();
    $('#inner_mvproj').html('');
    if (getCookie('TASKGROUPBY') == 'milestone') {
        $('#header_mvprj').text(title);
    } else if ($('#caseMenuFilters').val() == 'kanban' || $('#caseMenuFilters').val() == 'milestonelist') {
        $('#header_mvprj').text(title);
    } else if (is_multiple) {
        $('#header_mvprj').text(title);
    } else {
        $('#header_mvprj').text('#' + case_no + ": " + title);
    }
    $("#err_msg_dv").hide();
    $("#mvprjloader").hide();
    $(".loader_dv").show();
    $.post(HTTP_ROOT + "easycases/ajax_move_task_to_project", {
        "project_id": project_id,
        "case_id": case_id,
        'is_multiple': is_multiple
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_mvproj').show();
            $('#inner_mvproj').html(data);
            $('.mv-btn').show();
            $("#mvprj_btn").show();
            $('#case_no').val(case_no);
            $("#new_project").focus();
            $.material.init();
            $(".select").select2();
        }
    });
}

function resourceAssignProject(userId) {
    if (userId != '') {
        $('input:checkbox[value="' + userId + '"]').attr('checked', true);
    }
    if ($('.userlist').is(':checked')) {
        var user_id = new Array();
        $('input[id^="chkUser"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                user_id.push($(this).val());
            }
        });
    }
    $.post(HTTP_ROOT + "users/ajax_get_resources", {
        "user_id": user_id,
        "assign_project": 'assign_project'
    }, function(res) {
        if (empty(userId)) {
            resourceGetAllProject();
            openPopup();
            $(".rs_assign_project").show();
            $("#rs_assign_project_content").show();
        }
        $('#resource-avl').html('');
        $('#resource-avl').append(res);
    })
}

function resourceGetAllProject() {
    $.getJSON(HTTP_ROOT + 'projects/resourceGetAllProject', {}, function(json, textStatus) {
        $("#all_project_list").find("option:gt(0)").remove();
        $('#all_project_list').select2();
        $.each(json, function(index, val) {
            $('#all_project_list').append($('<option>', {
                value: index,
                text: val
            }));
        });
    });
}

function uncheck_resource(resourceId) {
    if (resourceId != '') {
        $('input:checkbox[value="' + resourceId + '"]').attr('checked', false);
    }
    checkCheckbox();
}

function checkCheckbox() {
    var totalCheckboxes = $('input[type="checkbox"].checkBoxClass').length;
    var checkedItems = $('input:checkbox.checkBoxClass:checked').length;
    if (totalCheckboxes > checkedItems) {
        $("#ckbCheckAll").prop("checked", false);
    } else {
        $("#ckbCheckAll").prop("checked", true);
    }
    if (checkedItems < 1) {
        closePopup();
        $('.project-btn').hide();
    }
}

function hideProjectButton() {
    var checkedItems = $('input:checkbox.checkBoxClass:checked').length;
}

function assignProject() {
    var projectId = $('#all_project_list').val();
    if (!projectId) {
        var msg = "Please select a project.";
        showTopErrSucc("error", msg);
        return null;
    }
    if ($('.userlist').is(':checked')) {
        var user_id = new Array();
        $('input[id^="chkUser"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                user_id.push($(this).val());
            }
        });
    }
    $.post(HTTP_ROOT + "projects/resourceAssignProject", {
        "user_id": user_id,
        "project_id": projectId
    }, function(response) {
        if (response) {
            $('.project-btn').hide();
            closePopup();
            $('input[type="checkbox"].checkBoxClass').attr('checked', false);
            $("#ckbCheckAll").prop("checked", false);
            if (response == 1) {
                var msg = "Resources assigned to project successfully.";
                showTopErrSucc("success", msg);
            } else if (response == 0) {
                var msg = "Resource already assigned to this Project.";
                showTopErrSucc("success", msg);
            }
        }
    })
}

function cptoProject(id, obj, alltask) {
    var is_multiple = 0;
    var prjunid = $('#projFil').val();
    if (prjunid == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _('All') + '" ' + _('project. Please choose a project.'));
        return false;
    }
    if (typeof alltask != 'undefined') {
        var chked = 0;
        $('input[id^="actionChk"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                chked = 1;
            }
        });
        if (chked == 0) {
            showTopErrSucc('error', _("Please check atleast one task to copy"));
            return false;
        }
        var project_id = $('#curr_sel_project_id').val();
        is_multiple = 1
        case_id = '';
        var title = _('Copy Task To Project');
    } else {}
    openPopup();
    $(".cp_project").show();
    $('#inner_cpproj').html('');
    if (is_multiple) {
        $('#header_cpprj').html(title);
    } else {}
    $("#errcp_msg_dv").hide();
    $("#cpprjloader").hide();
    $(".loader_dv").show();
    case_no = '';
    $.post(HTTP_ROOT + "easycases/ajax_copy_task_to_project", {
        "project_id": project_id,
        "case_id": case_id,
        'is_multiple': is_multiple
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_cpproj').show();
            $('#inner_cpproj').html(data);
            $('.cp-btn').show();
            $("#cpprj_btn").show();
            $('#case_no_cp').val(case_no);
            $("#new_cp_project").focus();
            $.material.init();
            $('#new_project_cp').select2();
        }
    });
}

function moveTaskToProject() {
    var prj_id = $("#project").val();
    var new_prj_id = $("#new_project").val();
    var old_prj_nm = $("#old_project_nm").val();
    var new_prj_nm = $('#new_project :selected').text();
    if ($('#move_assignee').is(':checked')) {
        var move_assignee = 1;
    } else {
        var move_assignee = 0;
    }
    var selected_task = $('input[name="selectedTask"]:checked').val();
    if ($('#ismultiple_move').val() == 1) {
        if ($('#projFil').val() != 'all') {
            var cbval = '';
            var case_id = new Array();
            var spval = '';
            var case_no = new Array();
            $('input[id^="actionChk"]').each(function(i) {
                if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                    cbval = $(this).val();
                    spval = cbval.split('|');
                    case_id.push(spval[0]);
                    case_no.push(spval[1]);
                }
            });
        } else {
            return false;
        }
    } else {
        var case_id = $("#case").val();
        var case_no = $('#case_no').val();
    }
    if (parseInt(prj_id) !== parseInt(new_prj_id) && parseInt(new_prj_id)) {
        if ($('#ismultiple_move').val() == 1) {
            if (countJS(case_id) == 1) {
                var cmsg = _("Are you sure you want to move task #") + case_no[0] + " " + _("to") + " '" + new_prj_nm + "' ?";
            } else {
                var cmsg = _("Are you sure you want to move all the selected task to") + " '" + new_prj_nm + "' ?";
            }
        } else {
            var cmsg = _("Are you sure you want to move task #") + case_no + " " + _("from") + " '" + old_prj_nm + "' " + _("to") + " '" + new_prj_nm + "' ?";
        }
        if (1) {
            $("#mvprj_btn").hide();
            $(".move_task_to_project").find('.close').hide();
            $("#mvprjloader").show();
            $.post(HTTP_ROOT + "easycases/move_task_to_project", {
                "project_id": new_prj_id,
                "old_project_id": prj_id,
                "case_id": case_id,
                "case_no": case_no,
                'is_multiple': $('#ismultiple_move').val(),
                'move_assignee': move_assignee,
                'selected_task': selected_task
            }, function(res) {
                $(".move_task_to_project").find('.close').show();
                if (res.message == 'success') {
                    refreshActvt = 1;
                    refreshKanbanTask = 1
                    refreshTasks = 1;
                    refreshManageMilestone = 1;
                    refreshMilestone = 1;
                    closePopup();
                    if ($('#ismultiple_move').val() == 1) {
                        if (countJS(case_id) == 1) {
                            var curRow = "curRow" + case_id[0];
                            $("#" + curRow).fadeOut(500, function() {
                                $(this).remove();
                            });
                            showTopErrSucc('success', _("Task") + " #" + case_no[0] + " " + _("moved  to") + " '" + new_prj_nm + "'");
                        } else if (selected_task == 'alltask') {
                            showTopErrSucc('success', _("All tasks are moved to") + " '" + new_prj_nm + "'");
                        } else {
                            $.each(case_id, function(i, v) {
                                var curRow = "curRow" + v;
                                $("#" + curRow).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            });
                            showTopErrSucc('success', countJS(case_id) + " " + _("Tasks are moved to") + " '" + new_prj_nm + "'");
                        }
                    } else {
                        var curRow = "curRow" + case_id;
                        $("#" + curRow).fadeOut(500, function() {
                            $(this).remove();
                        });
                        showTopErrSucc('success', _("Task") + " #" + case_no + " " + _("moved from") + " '" + old_prj_nm + "' " + _("to") + " '" + new_prj_nm + "'");
                    }
                    $.each(res.case_updated, function(i, v) {
                        var curRow = "curRow" + v;
                        $("#" + curRow).fadeOut(500, function() {
                            $(this).remove();
                        });
                    });
                    var hashtag = parseUrlHash(urlHash);
                    if (hashtag[0] == 'milestonelist') {
                        showMilestoneList();
                    } else if (hashtag[0] == 'kanban') {
                        easycase.showKanbanTaskList('kanban');
                    } else if (getCookie('TASKGROUPBY') == 'milestone') {
                        easycase.refreshTaskList();
                    } else if (hashtag[0] == 'taskgroups' || hashtag[0] == 'tasks') {
                        easycase.refreshTaskList();
                    } else {}
                    displayMenuProjects('dashboard', '6', '');
                } else {
                    $("#mvprj_btn").show();
                    $("#mvprjloader").hide();
                    if (res.msg != '') {
                        showTopErrSucc('error', res.msg);
                    } else {
                        showTopErrSucc('error', _("Unable to move task #") + case_no + " " + _("from") + " '" + old_prj_nm + "' " + _("to") + " '" + new_prj_nm + "'");
                    }
                    return false;
                }
            }, 'json');
        } else {
            return false;
        }
    } else {
        if ($(".movetoproj").val() == '') {
            errMsg = _('Please select a project.');
        } else {
            errMsg = _('Already in this project.');
        }
        $("#err_msg_dv").html(errMsg).show();
        return false;
    }
}

function copyTaskToProject() {
    var prj_id = $("#project_cp").val();
    var new_prj_id = $("#new_project_cp").val();
    var old_prj_nm = $("#old_project_nm_cp").val();
    var new_prj_nm = $('#new_project_cp :selected').text();
    if ($('#ismultiple_move_cp').val() == 1) {
        if ($('#projFil').val() != 'all') {
            var cbval = '';
            var case_id = new Array();
            var spval = '';
            var case_no = new Array();
            var isCloseChkboxChecked = $("#chkRadioId").prop('checked');
            if (isCloseChkboxChecked) {
                $('input[id^="actionChk"]').each(function(i) {
                    if ($(this).is(":checked")) {
                        cbval = $(this).val();
                        spval = cbval.split('|');
                        case_id.push(spval[0]);
                        case_no.push(spval[1]);
                    }
                });
            } else {
                $('input[id^="actionChk"]').each(function(i) {
                    if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                        cbval = $(this).val();
                        spval = cbval.split('|');
                        case_id.push(spval[0]);
                        case_no.push(spval[1]);
                    }
                });
            }
        } else {
            return false;
        }
    } else {
        var case_id = $("#case_cp").val();
        var case_no = $('#case_no_cp').val();
    }
    if (parseInt(prj_id) !== parseInt(new_prj_id) && parseInt(new_prj_id)) {
        if (1) {
            $("#cpprj_btn").hide();
            $("#cpprjloader").show();
            $.post(HTTP_ROOT + "easycases/copy_task_to_project", {
                "project_id": new_prj_id,
                "old_project_id": prj_id,
                "case_id": case_id,
                "case_no": case_no,
                'is_multiple': $('#ismultiple_move_cp').val()
            }, function(res) {
                if (res.success) {
                    refreshActvt = 1;
                    refreshKanbanTask = 1
                    refreshTasks = 1;
                    refreshManageMilestone = 1;
                    refreshMilestone = 1;
                    closePopup();
                    if ($('#ismultiple_move_cp').val() == 1) {
                        if (countJS(case_id) == 1) {
                            showTopErrSucc('success', _("Task") + " #" + case_no[0] + " " + _('copied  to') + " '" + new_prj_nm + "'");
                        } else {
                            showTopErrSucc('success', countJS(case_id) + " " + _("Tasks are copied to") + " '" + new_prj_nm + "'");
                        }
                    } else {
                        showTopErrSucc('success', _("Task") + " #" + case_no + " " + _("copied from") + " '" + old_prj_nm + "' " + _('to') + " '" + new_prj_nm + "'");
                    }
                    var hashtag = parseUrlHash(urlHash);
                    if (hashtag[0] == 'milestonelist') {
                        showMilestoneList();
                    } else if (hashtag[0] == 'kanban') {
                        easycase.showKanbanTaskList('kanban');
                    } else {
                        easycase.refreshTaskList();
                    }
                    displayMenuProjects('dashboard', '6', '');
                } else {
                    $("#cpprj_btn").show();
                    $("#cpprjloader").hide();
                    if (res.msg != '') {
                        showTopErrSucc('error', res.msg);
                    } else {
                        showTopErrSucc('error', _("Unable to copy task #") + case_no + " " + _("from") + " '" + old_prj_nm + "' " + _("to") + " '" + new_prj_nm + "'");
                    }
                    return false;
                }
            }, 'json');
        } else {
            return false;
        }
    } else {
        $("#errcp_msg_dv").show();
        return false;
    }
}

function rmverrmsg() {
    if ($('#errcp_msg_dv').length) {
        $("#errcp_msg_dv").hide();
    } else {
        $("#err_msg_dv").hide();
    }
}

function archiveCase(id, cno, pid, dtlsid) {
    var page_location = getHash().indexOf("backlog");
    var prjunid = $('#projFil').val();
    var isDtlPop = (typeof arguments[4] != 'undefined' && arguments[4] == 'popdtl') ? 1 : 0;
    if (prjunid == 'all' && id == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _("All") + '" ' + _('project. Please choose a project.'));
        return false;
    }
    var al_id = [];
    var al_id_disa = [];
    var al_id_noa = 0;
    var al_cno = '';
    var al_cno_d = '';
    var chked = 0;
    var typ = '';
    if (id == 'all') {
        typ = 'all';
        $('input[id^="actionChk"]').each(function(i) {
            if ($(this).is(":checked")) {
                var t_vl = $(this).val();
                t_vl = t_vl.split('|');
                al_id.push(t_vl[0]);
                al_cno += t_vl[1] + ',';
                al_cno_d += ' #' + t_vl[1] + ',';
                chked = 1;
            }
            if ($(this).is(":disabled")) {
                al_id_disa.push(t_vl[0]);
                al_id.pop();
            }
        });
        if (page_location == 0) {
            $('input[id^="actChkBklog"]').each(function(i) {
                if ($(this).is(":checked")) {
                    var t_vl = $(this).val();
                    t_vl = t_vl.split('|');
                    al_id.push(t_vl[0]);
                    al_cno += t_vl[1] + ',';
                    al_cno_d += ' #' + t_vl[1] + ',';
                    chked = 1;
                }
                if ($(this).is(":disabled")) {
                    al_id_disa.push(t_vl[0]);
                    al_id.pop();
                }
            });
        }
        if (chked == 0) {
            showTopErrSucc('error', _("Please check atleast one task to archive"));
            return false;
        } else {
            al_id_noa = al_id.length;
            al_cno = trim(al_cno, ',');
            al_id = trim(al_id, ',');
            al_cno_d = trim(al_cno_d, ',');
        }
    }
    if (id == 'all') {
        if (al_id_disa.length != al_id_noa) {
            var conf = confirm(_("All the selected task(s) and its subtasks including closed task(s) will be archived.") + "\n" + _("Are you sure you want to proceed?"));
        } else {
            var conf = confirm(_("All the closed task(s) will be archived.") + "\n" + _("Are you sure you want to proceed?"));
        }
    } else {
        var conf = confirm(_("Are you sure you want to archive the task #") + cno + " " + _("and all its subtasks?"));
    }
    if (conf == false) {
        return false;
    } else {
        if (id == 'all') {
            id = al_id;
            cno = al_cno;
        }
        refreshActvt = 1;
        $('#caseLoader').show();
        var strurl = HTTP_ROOT + "easycases/archive_case";
        $.post(strurl, {
            "id": id,
            "cno": cno,
            "pid": pid,
            'typ': typ
        }, function(data) {
            if (data.status == 'success') {
                if (isDtlPop) {
                    closePopupCaseDetails();
                }
                var hashtag = parseUrlHash(urlHash);
                id = data.arch_ids;
                if (id.indexOf(',') != -1) {
                    var idArr = id.split(',');
                    if (hashtag[0] == "taskgroups") {
                        $.each(idArr, function(i, v) {
                            var curRow = "curRow_subtask_" + v;
                            $("#" + curRow).fadeOut(500, function() {
                                $(this).remove();
                            });
                        });
                    } else {
                    $.each(idArr, function(i, v) {
                        var curRow = "curRow" + v;
                        $("#" + curRow).fadeOut(500, function() {
                            $(this).remove();
                        });
                    });
                    enableButtons();
                    }
                } else {
                    if (hashtag[0] == "taskgroups") {
                        var curRow = "curRow_subtask_" + id;
                        $("#" + curRow).fadeOut(500, function() {
                            $(this).remove();
                        });
                } else {
                    var curRow = "curRow" + id;
                    $("#" + curRow).fadeOut(500, function() {
                        $(this).remove();
                        enableButtons();
                    });
                }
                }
                $("#" + dtlsid).remove();
                $('#caseLoader').hide();
                $('#caseResolve').val('');
                if (typ == 'all') {
                    showTopErrSucc('success', _("Task") + " " + data.arch_cno + " " + _("archived successfully."));
                } else {
                    showTopErrSucc('success', _("Task") + " " + data.arch_cno + " " + _("archived successfully."));
                }
                if ($('tr[id^="curRow"]').length == 0) {
                    location.reload();
                } else {
                    $("tr.list-dt-row").each(function() {
                        if ($(this).next('tr.tr_all').length > 0) {} else {
                            $(this).remove();
                        }
                    });
                }
                if (getHash().indexOf("details/") !== -1) {
                    location.reload();
                }
                $.post(HTTP_ROOT + "users/project_menu", {
                    "page": 1,
                    "limit": 6
                }, function(data) {
                    if (data) {
                        $('#ajaxViewProjects').html(data);
                    }
                });
                $.post(HTTP_ROOT + "requests/getAllTasks", {
                    projUniq: $('#projFil').val()
                }, function(res) {
                    $("#taskCnt").html("(" + res.total_case + ")")
                }, 'json');
                if (hashtag[0] == 'milestonelist') {
                    showMilestoneList();
                } else if (hashtag[0] == 'kanban') {
                    easycase.showKanbanTaskList();
                } else if (getCookie('TASKGROUPBY') == 'milestone' || hashtag[0] == 'tasks') {
                    easycase.refreshTaskList();
                } else {
                    var projFil = $('#projFil').val();
                    var casemenufllter = $('#caseMenuFilters').val();
                    loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                        "projUniq": projFil,
                        "pageload": 1,
                        "page": "dashboard",
                        "filters": casemenufllter
                    });
                }
                if (client) {
                    client.emit('iotoserver', data.iotoserver);
                }
            }
        }, 'json');
    }
}

function deleteCase(id, cno, pid, dtlsid, recurring) {
    var tmdet = getCookie('timerDtls');
    if (typeof tmdet != 'undefined') {
        var tmCsDet = tmdet.split('|');
        var taskautoid = tmCsDet[0];
        if (id == taskautoid) {
            showTopErrSucc('error', _("Task can not be deleted while timer is on"));
            return false;
        }
    }
    var isSub = (typeof arguments[5] != 'undefined' && arguments[5] == 'sub') ? 1 : 0;
    var isDtlPop = (typeof arguments[6] != 'undefined' && arguments[6] == 'popdtl') ? 1 : 0;
    var confMesg = _("Are you sure you want to delete the task ?");
    if (confirm(confMesg)) {
        if (recurring == 1) {
            if (!confirm(_("This is a recurring task would you like to proceed?"))) {
                return false;
            }
        }
        var strurl = HTTP_ROOT + "easycases/check_parent_before_delete";
        $.post(strurl, {
            "parent_key": id,
            "validate_parent": 1,
            "pid": pid
        }, function(res_chk) {
            var reconf = 1;
            if (res_chk.status == 'error') {
                reconf = _('All subtasks of this parent task #') + cno + ' ' + _('will be deleted, are you sure you want to continue?');
            }
            if (reconf == 1 || confirm(reconf)) {
                refreshActvt = 1;
                var hashtag = parseUrlHash(urlHash);
                if (hashtag[0] == "taskgroups") {
                    var curRow = "curRow_subtask_" + id;
                } else {
                var curRow = "curRow" + id;
                }
                $("#" + curRow).fadeOut(500);
                $('#caseLoader').show();
                var strurl = HTTP_ROOT + "easycases/delete_case";
                $.post(strurl, {
                    "id": id,
                    "cno": cno,
                    "pid": pid
                }, function(data) {
                    if (data.status == 0) {
                        $('#caseLoader').hide();
                        $("#" + curRow).fadeIn(100);
                        showTopErrSucc('error', _("Failed to delete task #") + cno + ". " + _("Please try again."));
                    } else {
                        if (isDtlPop) {
                            closePopupCaseDetails();
                        }
                        var mid = $("#" + curRow).attr('data-mid');
                        $("#" + curRow).remove();
                        $("#" + dtlsid).remove();
                        $('#caseLoader').hide();
                        $('#caseResolve').val('');
                        showTopErrSucc('success', _("Task") + " #" + cno + " " + _("is deleted."));
                        if (hashtag[0] == "taskgroups") {
                            $("#empty_milestone_tr_thread" + mid).find('.os_sprite' + mid).trigger('click');
                            setTimeout($("#empty_milestone_tr_thread" + mid).find('.os_sprite' + mid).trigger('click'), 5000);
                            var projFil = $('#projFil').val();
                            var caseMenuFilters = $('#caseMenuFilters').val();
                            var case_date = $('#caseDateFil').val();
                            var case_due_date = $('#casedueDateFil').val();
                            var caseStatus = $('#caseStatus').val();
                            var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
                            var priFil = $('#priFil').val();
                            var caseTypes = $('#caseTypes').val();
                            var caseLabel = $('#caseLabel').val();
                            var caseMember = $('#caseMember').val();
                            var caseComment = $('#caseComment').val();
                            var caseTaskGroup = $('#caseTaskgroup').val();
                            var caseAssignTo = $('#caseAssignTo').val();
                            var caseSearch = $("#case_search").val();
                            if ((caseSearch != null) && (caseSearch.trim() == '')) {
                                caseSearch = $('#caseSearch').val();
                            } else {
                                $("#caseSearch").val(caseSearch);
                        }
                            var milestoneIds = $('#milestoneIds').val();
                            var checktype = $("#checktype").val();
                            restcasestatus(projFil, caseMenuFilters, case_date, case_due_date, caseStatus, caseCustomStatus, caseTypes, priFil, caseMember, caseComment, caseAssignTo, caseSearch, milestoneIds, checktype, caseLabel);
                        }
                        if (hashtag[0] != "taskgroups") {}
                        $.post(HTTP_ROOT + "users/project_menu", {
                            "page": 1,
                            "limit": 6
                        }, function(data) {
                            if (data) {
                                $('#ajaxViewProjects').html(data);
                            }
                        });
                        $.post(HTTP_ROOT + "requests/getAllTasks", {
                            projUniq: $('#projFil').val()
                        }, function(res) {
                            $("#taskCnt").html("(" + res.total_case + ")")
                        }, 'json');
                        if (isSub) {
                            if (data.parent_id != '') {
                                loadSubtaskInDetail(data.parent_id);
                                if ($('#tab-taskLink').hasClass('active')) {
                                    $('#tab-taskLink').trigger('click');
                                }
                            }
                        } else if (getCookie('TASKGROUPBY') == 'milestone') {
                            easycase.refreshTaskList();
                        } else if (hashtag[0] == 'milestonelist') {
                            showMilestoneList();
                        } else if (hashtag[0] == 'kanban') {
                            var childId = $(".case-title-kbn-" + id).closest(".kanban-child").attr('id');
                            if (childId == "inprogressTask") {
                                $("#cnter_inprogressTask").html(parseInt($("#cnter_inprogressTask").html()) - 1);
                            } else if (childId == "resolvedTask") {
                                $("#cnter_resolvedTask").html(parseInt($("#cnter_resolvedTask").html()) - 1);
                            } else if (childId == "closedTask") {
                                $("#cnter_closedTask").html(parseInt($("#cnter_closedTask").html()) - 1);
                            } else {
                                $("#cnter_newTask").html(parseInt($("#cnter_newTask").html()) - 1);
                            }
                            $(".case-title-kbn-" + id).closest(".kb_task_det").remove();
                        } else {
                            if (!$('tr[data-mid="' + mid + '"]').length && hashtag[0] != 'taskgroups') {
                                easycase.refreshTaskList();
                            }
                            var projFil = $('#projFil').val();
                            var casemenufllter = $('#caseMenuFilters').val();
                            loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                                "projUniq": projFil,
                                "pageload": 1,
                                "page": "dashboard",
                                "filters": casemenufllter
                            });
                        }
                        if (client) {
                            client.emit('iotoserver', data.iotoserver);
                        }
                    }
                }, 'json');
            }
        }, 'json');
    }
}

function removeThisCase(count, msid, getcount, milestone_id, cno, uid) {
    var conf = confirm(_("Are you sure you want to remove task #") + cno + " " + _("from this milestone?"));
    if (conf == true) {
        var curRow = "curRow" + getcount;
        $("#" + curRow).fadeOut(500);
        var caseDiv = 'caseDiv' + getcount;
        var caseImg = 'caseImg' + getcount;
        var strURL = HTTP_ROOT + 'milestones/case_listing';
        $("#" + caseImg).show();
        $.post(strURL, {
            "milestone_id": milestone_id,
            "count": getcount,
            "msid": msid,
            "uid": uid
        }, function(data) {
            if (data) {
                $('#' + caseDiv).html(data);
                $("#" + caseImg).hide();
            }
        });
        easycase.refreshTaskList();
        return true;
    } else {
        var checkBox = 'csCheckBox' + count;
        document.getElementById(checkBox).checked = true;
        return false;
    }
}

function changestatus(caseId, statusId, statusName, statusTitle, caseUniqId) {
    var typlod = "typlod" + caseId;
    var showUpdStatus = "showUpdStatus" + caseId;
    var typIconClass = $("#" + showUpdStatus).attr('class');
    var tsktype = "tsktype" + caseId;
    $("#" + showUpdStatus).attr('class', '');
    $('#' + tsktype).hide();
    $('#' + typlod).show();
    $("#t_" + caseUniqId).remove();
    var strURL = HTTP_ROOT + "easycases/ajax_change_status";
    $.post(strURL, {
        "caseId": caseId,
        "statusId": statusId,
        "statusName": statusName,
        "statusTitle": statusTitle
    }, function(data) {
        if (data) {
            $('#' + typlod).hide();
            typIconClass = 'type_' + data[0];
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'milestonelist') {
                window.location.hash = 'milestonelist';
            } else if (hashtag[0] == 'kanban') {
                window.location.hash = 'kanban';
            } else if (hashtag[0] == 'taskgroups') {
                window.location.hash = 'taskgroups';
                $("#empty_milestone_tr_thread" + data.task_milestone_id).find('.os_sprite' + data.task_milestone_id).trigger('click');
                setTimeout($("#empty_milestone_tr_thread" + data.task_milestone_id).find('.os_sprite' + data.task_milestone_id).trigger('click'), 5000);
            } else {
                tasklisttmplAdd(caseId);
            }
        }
    }, 'json').always(function() {
        $('#' + typlod).hide();
        $('#' + tsktype).html(statusTitle);
        $('#' + tsktype).show();
    });
}

function changetype(caseId, statusId, statusName, statusTitle, caseUniqId, cno) {
    refreshTasks = 1;
    var typlod = "dettyplod" + caseId;
    var typdiv = "typdiv" + caseId;
    var old_typ = $('#' + typdiv).attr('data-typ-id');
    if (old_typ == statusId) {
        return false;
    }
    $('#' + typdiv).hide();
    $('#' + typlod).show();
    $.post(HTTP_ROOT + "easycases/ajax_change_status", {
        "caseId": caseId,
        "statusId": statusId,
        "statusName": statusName,
        "statusTitle": statusTitle
    }, function(data) {
        if (data) {
            $('#lst_uptd').html(data.last_updated);
            for (var k in GLOBALS_TYPE) {
                var v = GLOBALS_TYPE[k];
                if (v.Type.name == data[1]) {
                    var cls = v.Type.short_name;
                }
            }
            $('#strpoContain' + caseId).hide();
            $('.task-detail-head-extr').removeClass('tsk-detail-story');
            if (statusTitle == 'Story') {
                $('#strpoContain' + caseId).show();
                $('.task-detail-head-extr').addClass('tsk-detail-story');
            }
            if (false) {
                window.location.reload();
            } else {
                $('#' + typdiv).attr('data-typ-id', statusId);
                $('#' + typdiv + ' div').first().attr('class', '').addClass('fl task_types_' + data[0]);
                $('#' + typdiv + ' .quick_action').html('<span class="ttype_global tt_' + getttformats(data[1]) + '">' + shortLength(data[1], 10) + '<i class="tsk-dtail-drop material-icons">&#xE5C5;</i></span>');
                appendReplyThread(data.curCaseId, caseId);
            }
        }
    }, 'json').always(function() {
        $('#' + typdiv).show();
        $('#' + typlod).hide();
        actiononTask(caseId, caseUniqId, cno, 'tasktype');
    });
}

function changeEstHour(caseId, caseUniqId, cno, value) {
    if (LogTime.convertToMin($("#est_hr" + caseId).val()) == LogTime.convertToMin($("#est_hr" + caseId).attr('data-default-val'))) {
        $("#est_hr" + caseId).val($("#est_hr" + caseId).attr('data-default-val'));
        localStorage.setItem("ckl_chk", 0);
        return false;
    }
    $(".estb").hide();
    var estHour = $("#est_hr" + caseId).val();
    var estlod = "estlod" + caseId;
    $('#' + estlod + '').show();
    $(".est_hr").hide();
    $('#estdiv' + caseId).find('.estb span').hide();
    var esthr = estHour;
    $.post(HTTP_ROOT + "easycases/ajax_change_estHour", {
        "caseId": caseId,
        "estHour": estHour
    }, function(data) {
        $('#lst_uptd').html(data.last_updated);
        var esthor = format_time_hr_min(data.task_details.Easycase.estimated_hours);
        $('#est_hr_updated').html(esthor);
        var displayTimeData = estHour;
        if (estHour.indexOf(':') > 0) {
            estHour = estHour.split(':');
            var estTxt = (((parseInt(estHour[0]) * 60) + parseInt(estHour[1])) * 60);
        } else {
            estTxt = estHour * 3600;
        }
        $('#est_time').text(format_time_hr_min(estTxt));
        $('#' + estlod + '').hide();
        $("#est_hr" + caseId).hide();
        $('#estdiv' + caseId).find('.estb').show();
        if (estTxt > 0) {
            $('#estdiv' + caseId).find('.estb span').html(format_time_hr_min(estTxt)).show();
            $('.tlog_top_cnt').find('h6:nth-child(2)').find('span').html(format_time_hr_min(estTxt));
        } else {
            $('#estdiv' + caseId).find('.estb span').html('None').show();
            $('.tlog_top_cnt').find('h6:nth-child(2)').find('span').html('None');
        }
        $("#est_hr" + caseId).attr('data-default-val', displayTimeData);
        appendReplyThread(data.curCaseId, caseId);
        if (data.isAssignedUserFree != 1 && data.isAssignedUserFree != null) {
            CS_start_date = data.task_details.Easycase.gantt_start_date;
            CS_due_date = data.task_details.Easycase.due_date;
            est_hours = esthr;
            caseUniqId = data.task_details.Easycase.uniq_id;
            project_id = data.task_details.Easycase.project_id;
            CS_assign_to = data.task_details.Easycase.assign_to;
            openResourceNotAvailablePopup(CS_assign_to, CS_start_date, CS_due_date, est_hours, project_id, caseId, caseUniqId, data.isAssignedUserFree)
        }
    }, 'json').always(function() {
        localStorage.setItem("ckl_chk", 0);
        actiononTask(caseId, caseUniqId, cno, 'esthour');
    });
}

function changeStoryPoint(caseId, caseUniqId, cno, value) {
    if ($("#strpo_cnt" + caseId).val() == $("#strpo_cnt" + caseId).attr('data-default-val')) {
        $("#strpo_cnt" + caseId).val($("#strpo_cnt" + caseId).attr('data-default-val'));
        return false;
    }
    $(".strpob").hide();
    var story_point = $("#strpo_cnt" + caseId).val();
    var estlod = "strpolod" + caseId;
    if (story_point.trim() == '') {
        $('#strpo_cnt' + caseId).val(0);
        story_point = 0;
    }
    $('#' + estlod + '').show();
    $(".strpo").hide();
    $('#strpodiv' + caseId).find('.strpob span').hide();
    $.post(HTTP_ROOT + "easycases/ajax_change_storyPoint", {
        "caseId": caseId,
        "caseUId": caseUniqId,
        "story_point": story_point
    }, function(data) {
        $('#' + estlod + '').hide();
        $("#strpo_cnt" + caseId).hide();
        $('#strpodiv' + caseId).find('.strpob').show();
        $('#strpodiv' + caseId).find('.strpob span').html(story_point).show();
        appendReplyThread(data.curCaseId, caseId);
    }, 'json').always(function() {
        actiononTask(caseId, caseUniqId, cno, 'story_point');
    });
}

function changeEstHourTaskListPage(caseId, caseUniqId, cno, value) {
    if (LogTime.convertToMin($("#est_hrlist" + caseId).val()) == LogTime.convertToMin($("#est_hrlist" + caseId).attr('data-default-val'))) {
        $("#est_hrlist" + caseId).val($("#est_hrlist" + caseId).attr('data-default-val'));
        $('#est_hrlist' + caseId).hide();
        $('#est_blist' + caseId).show();
        return false;
    }
    var estlod = "estlod" + caseId;
    $("#est_blist" + caseId).hide();
    $('#est_hrlist' + caseId).hide();
    var estHour = $("#est_hrlist" + caseId).val();
    if (estHour.trim() == '') {
        $('#' + estlod + '').hide();
        $('#est_blist' + caseId + ',#est_blist' + caseId + ' span').show();
        showTopErrSucc('error', _('Estimated hour(s) can not be blank.'));
        $('#est_hrlist' + caseId).val(value);
        return;
    }
    $('#' + estlod + '').show();
    $('#est_hrlist' + caseId).hide();
    $('#est_blist' + caseId + ' span').hide();
    if (parseInt(estHour.replace(/[^0-9]+/g, '')) == 0) {
        $('#' + estlod + '').hide();
        $('#est_blist' + caseId + ',#est_blist' + caseId + ' span').show();
        showTopErrSucc('error', _('Estimated hour(s) can not be 0.'));
        $('#est_hrlist' + caseId).val(value);
        $("#est_hrlist" + caseId).focus();
        return;
    }
    var esthr = estHour;
    $.post(HTTP_ROOT + "easycases/ajax_change_estHour", {
        "caseId": caseId,
        "estHour": estHour
    }, function(data) {
        if (estHour.indexOf(':') > 0) {
            estHour = estHour.split(':');
            var estTxt = (((parseInt(estHour[0]) * 60) + parseInt(estHour[1])) * 60);
        } else {
            estTxt = estHour * 3600;
        }
        $('#' + estlod + '').hide();
        $("#est_hrlist" + caseId).hide();
        $('#est_blist' + caseId).show();
        $('#est_blist' + caseId + ' span').html(format_time_hr_min(estTxt)).show();
        appendReplyThread(data.curCaseId, caseId);
        if (data.isAssignedUserFree != 1 && data.isAssignedUserFree != null) {
            CS_start_date = data.task_details.Easycase.gantt_start_date;
            CS_due_date = data.task_details.Easycase.due_date;
            est_hours = esthr;
            caseUniqId = data.task_details.Easycase.uniq_id;
            project_id = data.task_details.Easycase.project_id;
            CS_assign_to = data.task_details.Easycase.assign_to;
            openResourceNotAvailablePopup(CS_assign_to, CS_start_date, CS_due_date, est_hours, project_id, caseId, caseUniqId, data.isAssignedUserFree)
        }
    }, 'json').always(function() {
        actiononTask(caseId, caseUniqId, cno, 'esthour');
    });
}

function changecselegend(caseId, caseUniqId, cno, legend) {
    var hashtag = parseUrlHash(urlHash);
    var lgnd = '';
    if (legend == 2) {
        lgnd = 'start';
    } else if (legend == 3) {
        lgnd = 'close';
    } else if (legend == 5) {
        lgnd = 'resolve'
    }
    $.post(HTTP_ROOT + "easycases/ajax_change_legend", {
        "caseId": caseId,
        "legend": legend
    }, function(data) {
        if (hashtag[0] == 'details') {
            appendReplyThread(data.curCaseId, caseId);
        }
    }, 'json').always(function() {
        actiononTask(caseId, caseUniqId, cno, lgnd);
    });
}

function changetaskProgressbar(percent, caseid, caseUniqId, cno) {
    $('#prgsloader').show();
    $('#opt19').hide();
    $('#more_opt19' + caseid).children('ul.dropdown-menu').hide();
    $.post(HTTP_ROOT + "easycases/ajax_change_completedTask", {
        "caseId": caseid,
        "cmpltask": percent
    }, function(data) {
        if (data.err) {
            $('#opt19').show();
            showTopErrSucc('error', data.msg);
        } else {
            $('#opt19').show();
            $('#pgrsdiv' + caseid).find('.progress').find('.progress-bar').css({
                'width': percent + '%'
            });
            $('#pgrsdiv' + caseid).find('#completed_task' + caseid + ' span').text(percent + "%");
            appendReplyThread(data.curCaseId, caseid);
        }
        $('#prgsloader').hide();
    }, 'json').always(function() {
        actiononTask(caseid, caseUniqId, cno, 'cmpltsk');
    });
}

function displayAssignToMem(csId, project, caseAssgnUid, caseUniqId, page, cno, client_status) {
    $('.cmn_h_det_arrow').removeClass('open');
    $('div[id^="more_opt80"]').find('ul').hide();
    if (!page) {
        page = '';
    }
    if (countJS(PUSERS) && PUSERS[project]) {
        appendAssignUsers(csId, project, caseUniqId, page, cno, caseAssgnUid, client_status);
    } else if ($('#assgnload' + csId).length || $('#detAssgnload' + csId).length) {
        $.post(HTTP_ROOT + "easycases/ajax_assignto_mem", {
            "project": project
        }, function(data) {
            if (data) {
                $('.detasgnlod').hide();
                PUSERS = data;
                $('.assgn').show();
                appendAssignUsers(csId, project, caseUniqId, page, cno, caseAssgnUid);
                $("img.lazy").lazyload({
                    placeholder: HTTP_ROOT + "img/lazy_loading.png"
                });
            }
        });
    } else {}
}

function appendAssignUsers(csId, project, caseUniqId, page, cno, caseAssgnUid, client_status) {
    if (page != 'details')
        $('#showAsgnToMem' + csId).html('<li class="pop_arrow_new"></li>');
    else
        $('#detShowAsgnToMem' + csId).html('<li class="pop_arrow_new" style="margin-left:1%;"></li>');
    if (page == 'details') {
        $('#detShowAsgnToMem' + csId).append('<li><input type="text" id="assignee_search" placeholder="Search Assignee.."/></li>');
    } else {
        $('#showAsgnToMem' + csId).append('<li class="searchAssnLi"><input type="text" placeholder="' + _('Search') + '" class="searchType" onkeyup="seachitems(this,1);" /></li>');
        $('.searchType').on('click', function(evnt) {
            evnt.stopPropagation();
        });
    }
    for (ui in PUSERS[project]) {
        var t1 = PUSERS[project][ui].User.name;
        if (client_status == 1 && PUSERS[project][ui].CompanyUser.is_client == 1) {} else {
            if (PUSERS[project][ui].User.id == SES_ID) {
                var t2 = 'me';
                var t = PUSERS[project][ui].User.id;
                if (page == 'details')
                    $('#detShowAsgnToMem' + csId).append('<li rel="tooltip" title="' + t1 + '" class="memHover" ><a href="javascript:void(0);" onclick="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\',\'' + cno + '\',\'' + caseAssgnUid + '\')">me</a></li>')
                else
                    $('#showAsgnToMem' + csId).append('<li rel="tooltip" title="' + t1 + '" class="memHover" ><a href="javascript:void(0);" onclick="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\')" style="margin-left: 5px;">me</a></li>')
            } else {
                var t2 = PUSERS[project][ui].User.name;
                var t = PUSERS[project][ui].User.id;
                if (page == 'details')
                    $('#detShowAsgnToMem' + csId).append('<li rel="tooltip" title="' + t1 + '" class="memHover ttc"><a href="javascript:void(0);" onclick="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\',\'' + cno + '\',\'' + caseAssgnUid + '\')">' + shortLength(t2, 15) + '</a></li>');
                else
                    $('#showAsgnToMem' + csId).append('<li rel="tooltip" title="' + t1 + '" class="memHover ttc"><a href="javascript:void(0);" onclick="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\')" style="margin-left: 5px;">' + shortLength(t2, 15) + '</a></li>');
            }
        }
    }
    if (page == 'details')
        $('#detShowAsgnToMem' + csId).append('<li rel="tooltip" title="' + _('Unassigned') + '" class="memHover ttc"><a href="javascript:void(0);" onclick="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'0\',\'' + cno + '\',\'' + caseAssgnUid + '\')">Nobody</a></li>');
    else
        $('#showAsgnToMem' + csId).append('<li rel="tooltip" title="' + _('Unassigned') + '" class="memHover ttc"><a href="javascript:void(0);" onclick="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'0\')" style="margin-left: 5px;">Nobody</a></li>');
}

function changeAssignTo(caseId, caseUniqId, assignId) {
    $('#caseChangeAssignto').val(caseId);
    var asgnlod = "asgnlod" + caseId;
    var showUpdAssign = "showUpdAssign" + caseId;
    $("#" + showUpdAssign).html("");
    $("#" + asgnlod).show();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var projFil = $('#projFil').val();
    $("#t_" + caseUniqId).remove();
    $.post(HTTP_ROOT + "easycases/ajax_change_AssignTo", {
        "caseId": caseId,
        "assignId": assignId
    }, function(data) {
        if (data) {
            $('.assgn').show();
            $("#" + asgnlod).hide();
            var name = data.top;
            if (name.length > 10) {
                name = shortLength(data.top, 10);
            }
            $("#" + showUpdAssign).html(name + '<span class="due_dt_icn"></span>');
            if (data.isAssignedUserFree != 1 && assignId != 0) {
                var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
            }
            sendAssignEmail(caseId, caseUniqId, "assignto");
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'milestonelist') {
                window.location.hash = 'milestonelist';
            } else if (hashtag[0] == 'kanban') {
                window.location.hash = 'kanban';
            } else if (hashtag[0] == 'taskgroups') {
                window.location.hash = 'taskgroups';
            } else {
                loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                    "projUniq": projFil,
                    "pageload": 0,
                    "page": "dashboard",
                    "filters": caseMenuFilters
                });
                tasklisttmplAdd(caseId);
            }
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
            if (isTimerRunning(caseId)) {
                exitTimerPopup();
            }
        }
    }, 'json');
}

function sendAssignEmail(taskid, taskUid, actiontype) {
    $.post(HTTP_ROOT + 'easycases/getActionResponse', {
        'taskId': taskid,
        'taskUid': taskUid,
        'type': actiontype,
    }, function(res) {
        if (res.data) {
            $.post(HTTP_ROOT + "easycases/ajaxemail", {
                'json_data': res.data,
                'type': 1
            });
        }
    }, 'json');
}
function ajaxassignAllTaskToUser(alltask) {
    var is_multiple = 0;
    var projFil = $('#projFil').val();
    if (projFil == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _('All') + '" ' + _('project. Please choose a project.'));
        return false;
    } else {
        if (typeof alltask != 'undefined') {
            var chked = 0;
            $('input[id^="actionChk"]').each(function(i) {
                if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                    chked = 1;
                }
            });
            if (chked == 0) {
                showTopErrSucc('error', _("Please check atleast one task to assign"));
                return false;
            }
            var project_id = $('#curr_sel_project_id').val();
            is_multiple = 1
            case_id = '';
            var title = _('Assign selected task(s)');
        }
        openPopup();
        $(".assign_task_to_user").show();
        $('#inner_asntskuser').html('');
        $('#header_asntskuser').html(title);
        $("#err_msgassn_dv").hide();
        $("#asntskuserloader").hide();
        $(".loader_dv").show();
        $.post(HTTP_ROOT + "easycases/ajax_assign_task_to_user", {
            "project_id": project_id,
            'is_multiple': is_multiple
        }, function(data) {
            if (data) {
                $(".loader_dv").hide();
                $('#inner_asntskuser').show();
                $('#inner_asntskuser').html(data);
                $('.mv-btn').show();
                $("#asntskuser_btn").show();
                $("#new_asntskuser").focus();
                $.material.init();
                $(".select").dropdown();
            }
        });
    }
}

function assignTaskToUser() {
    var prj_id = $("#project_asntskuser").val();
    var usrname = $('#new_asntskuser :selected').text();
    var is_multple = $('#ismultiple_asntskuser').val();
    if (is_multple == 1) {
        if ($('#projFil').val() != 'all') {
            var cbval = '';
            var case_id = new Array();
            var spval = '';
            var case_no = new Array();
            $('input[id^="actionChk"]').each(function(i) {
                if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                    cbval = $(this).val();
                    spval = cbval.split('|');
                    case_id.push(spval[0]);
                    case_no.push(spval[1]);
                }
            });
        } else {
            return false;
        }
    } else {}
    if (is_multple == 1) {
        if (countJS(case_id) == 1) {
            var cmsg = _('Tasks') + ' #' + case_no[0] + ' ' + _('will be assigned to') + ' ' + usrname + ' ' + _('and the existing assignee will be unassigned.') + '\n' + _('Are you sure you want to continue?');
        } else {
            var cmsg = _('All the selected tasks will be assigned to') + ' ' + usrname + ' ' + _('and the existing assignee will be unassigned.') + '\n\n' + _('Are you sure you want to continue?');
        }
    }
    if (confirm(cmsg)) {
        $("#asntskuser_btn").hide();
        $("#asntskuserloader").show();
        $.post(HTTP_ROOT + "easycases/AssignAllTaskToUser", {
            "user_id": $('#new_asntskuser').val(),
            "case_id": case_id,
            "case_no": case_no,
            'is_multiple': is_multple
        }, function(res) {
            if (res.status == 'success') {
                refreshTasks = 1;
                closePopup();
                if (is_multple == 1) {
                    if (countJS(case_id) == 1) {
                        showTopErrSucc('success', _("Task") + " #" + case_no[0] + " " + _("has been assigned  to") + " '" + usrname + "'");
                    } else {
                        showTopErrSucc('success', countJS(case_id) + " " + _("Tasks are assigned to") + " '" + usrname + "'");
                    }
                }
                easycase.refreshTaskList();
            } else {
                $("#asntskuser_btn").show();
                $("#asntskuserloader").hide();
                showTopErrSucc('error', _("Oops! there is some problem in the network. Please try again."));
                return false;
            }
        }, 'json');
    } else {
        return false;
    }
}

function detChangeAssignTo(caseId, caseUniqId, assignId, cno, caseAssgnUid) {
    $('.assgn').hide();
    refreshTasks = 1;
    var asgnlod = "detasgnlod" + caseId;
    var showUpdAssign = "asgnUsrdiv" + caseId;
    $('#' + asgnlod).show();
    $.post(HTTP_ROOT + "easycases/ajax_change_AssignTo", {
        "caseId": caseId,
        "assignId": assignId
    }, function(data) {
        if (data) {
            $('.assgn').show();
            $('#lst_uptd').html(data.last_update);
            if (isTimerRunning(caseId)) {
                exitTimerPopup();
            }
            if (data.photo) {
                $('#' + showUpdAssign).find('.user-task-pf').html('<img  title="' + data.top + '" width="55" height="55" src="' + HTTP_ROOT + 'users/image_thumb/?type=photos&file=' + data.photo + '&sizex=55&sizey=55&quality=100"/>');
            } else {
                var usr_name_fst = data.details.charAt(0);
                $('#' + showUpdAssign).find('.user-task-pf').html('<span class="cmn_profile_holder ' + data.asgnPicBg + '" title="' + data.top + '">' + usr_name_fst + '</span>');
            }
            var name = data.top;
            if (name.length > 10) {
                name = shortLength(data.top, 10);
            }
            $('#' + showUpdAssign).find('#case_dtls_new' + caseId).html(name);
            $('#CS_assign_to' + caseId).val(assignId);
            $('#CS_assign_to' + caseId).next('div.dropdownjs').find('input.fakeinput').val(data.top);
            $('#' + caseId + 'chk_' + assignId).prop('checked', true);
            $('#' + caseId + 'chk_' + caseAssgnUid).prop('checked', false);
            $('#case_dtls_new' + caseId).html(name);
            $('#asgnto_id').html(name);
            $.material.init();
            $('#' + asgnlod).hide();
            appendReplyThread(data.curCaseId, caseId);
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
            if (data.isAssignedUserFree != 1 && assignId != 0) {
                var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
            }
        }
    }, 'json').always(function() {
        actiononTask(caseId, caseUniqId, cno, 'assignto');
    });
}

function changeCaseDuedate(id, no) {
    $('#caseChangeDuedate').val(id);
    $('#slctcaseid').val(no);
}

function changeDueDate(caseId, duedt, text, caseUniqId) {
    var cno = 'temp';
    var reason_id = 0;
    if (typeof arguments[4] != 'undefined' && arguments[4] != 'duedate') {
        reason_id = arguments[4];
    }
    var datelod = "datelod" + caseId;
    var showUpdDueDate = "showUpdDueDate" + caseId;
    var old_duetxt = $("#" + showUpdDueDate).html();
    $("#" + showUpdDueDate).html("");
    $("#" + datelod).show();
    $("#t_" + caseUniqId).remove();
    $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
        "caseId": caseId,
        "duedt": duedt,
        "text": text,
        "reason_id": reason_id
    }, function(data) {
        if (data) {
            $("#" + datelod).hide();
            if (typeof data.success != 'undefined' && data.success == 'No') {
                showTopErrSucc('error', data.message);
                $("#" + showUpdDueDate).html(old_duetxt);
                return false;
            }
            if (data.details == 'NA') {
                $("#" + showUpdDueDate).parent('td').removeClass('toggle_due_dt');
            }
            $("#" + showUpdDueDate).html(data.top + '<span class="due_dt_icn"></span>');
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'milestonelist') {
                window.location.hash = 'milestonelist';
            } else if (hashtag[0] == 'kanban') {
                window.location.hash = 'kanban';
            } else if (hashtag[0] == 'taskgroups') {
                $(".overdueby_spn_" + caseId).html("");
            } else {
                tasklisttmplAdd(caseId);
            }
            if (data.isAssignedUserFree != 1) {
                var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
            }
        }
    }, 'json');
}


function commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj) {
    var reason_id = 0;
    if (typeof arguments[7] != 'undefined' && arguments[7] != 'duedate') {
        reason_id = arguments[7];
    }
    $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
        "caseId": caseId,
        "duedt": dateText,
        "text": text,
        "reason_id": reason_id
    }, function(data) {
        if (data) {
            $("#" + datelod).hide();
            if (typeof data.success != 'undefined' && data.success == 'No') {
                showTopErrSucc('error', data.message);
                $("#" + showUpdDueDate).html(old_duetxt);
                return false;
            }
            $("#" + showUpdDueDate).html(data.top + '<span class="due_dt_icn"></span>');
            if (vobj != 'NA') {
                vobj.closest('td').find('.toggle_due_dt').removeClass('toggle_due_dt');
            }
            if (data.isAssignedUserFree != 1) {
                var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
            }
        }
    }, 'json');
}
function detChangeDueDate(caseId, duedt, text, caseUniqId, cno) {
    var reason_id = 0;
    if (typeof arguments[5] != 'undefined' && arguments[5] != 'duedate') {
        reason_id = arguments[5];
    }
    var flag = 1;
    var datelod = "detddlod" + caseId;
    var showUpdDueDate = "case_dtls_due" + caseId;
    $("#" + showUpdDueDate).hide();
    var old_duetxt = $("#" + showUpdDueDate).html();
    $("#" + datelod).show();
    $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
        "caseId": caseId,
        "duedt": duedt,
        "text": text,
        "reason_id": reason_id
    }, function(data) {
        if (data) {
            $('#lst_uptd').html(data.last_updated);
            $('#duedate_id').text(data.top);
            $('#update_due-date').text('Due:' + data.duedate);
            if (typeof data.success != 'undefined' && data.success == 'No') {
                showTopErrSucc('error', data.message);
                $("#" + showUpdDueDate).html(old_duetxt);
                $("#" + showUpdDueDate).show();
                $("#" + datelod).hide();
                flag = 0;
                return false;
            }
            $('.initial_duedate_val').html(data.original_due_date);
            if ($("#" + showUpdDueDate).find('.duedrp').length) {
                $("#" + showUpdDueDate).find('.duedrp').html(data.top + "<i class='tsk-dtail-drop material-icons'>&#xE5C5;</i>");
            } else {
                $("#" + showUpdDueDate).find('.no_due').html(data.top + "<i class='tsk-dtail-drop material-icons'>&#xE5C5;</i>");
            }
            $("#" + showUpdDueDate).children('div.dropdown').attr('original-title', data.title);
            appendReplyThread(data.curCaseId, caseId);
            if (data.isAssignedUserFree != 1) {
                var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
            }
        }
    }, 'json').always(function() {
        if (flag) {
            $("#" + showUpdDueDate).show();
            $("#" + datelod).hide();
            actiononTask(caseId, caseUniqId, cno, 'duedate');
        }
    });
}

function detChangeMilestone(caseId, cno, caseUniqId, mlstnNm, pmlstnId, emlstnId) {
    refreshActvt = 1;
    refreshKanbanTask = 1;
    refreshTasks = 1;
    refreshManageMilestone = 1;
    refreshMilestone = 1;
    mlstnNm = unescape(mlstnNm);
    var prilod = "tgrplod" + caseId;
    var showUpdPri = "tgrpdiv" + caseId;
    $("#" + showUpdPri).hide();
    $('#' + prilod).show();
    $('div[id^="more_opt80"]').find('ul').hide();
    var projFil = $('#projFil').val();
    $.post(HTTP_ROOT + "easycases/ajax_detchange_milestone", {
        "caseId": caseId,
        "mlstnId": pmlstnId,
        "projUid": projFil
    }, function(data) {
        if (data) {
            if (data.msg == 'fail') {
                if (data.project_methodology == 2) {
                    showTopErrSucc('error', _('Failed to change the Task Group to') + ' ' + mlstnNm);
                } else {
                    showTopErrSucc('error', _('Failed to change the Sprint to') + ' ' + mlstnNm);
                }
                setTimeout(window.location.reload(), 5000);
            } else {
                $('#tsk_grp_opt80').attr('title', mlstnNm);
                $('[rel=tooltip]').tipsy({
                    gravity: 's',
                    fade: true
                });
                var params = parseUrlHash(urlHash);
                $('#' + prilod).hide();
                if (params[0] == 'details' || $("#myModalDetail").hasClass('in')) {
                    if (data.project_methodology == 2) {
                        mlstnNm = mlstnNm != 'Default Task Group' ? shortLength(ucfirst(formatText(mlstnNm)), 15) : _('Backlog');
                    } else {
                        mlstnNm = mlstnNm != 'Default Task Group' ? shortLength(ucfirst(formatText(mlstnNm)), 15) : mlstnNm;
                    }
                    $("#" + showUpdPri).show();
                    $('#' + showUpdPri).find('.status_tdet').find('a').html(mlstnNm + '<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>');
                    if (data.project_methodology == 2) {
                        showTopErrSucc('success', _('Successfully changed the Sprint to') + ' ' + mlstnNm);
                    } else {
                        showTopErrSucc('success', _('Successfully changed the Task Group to') + ' ' + mlstnNm);
                    }
                } else if (params[0] == 'tasks') {
                    tasklisttmplAdd(caseId);
                    easycase.refreshTaskList();
                }
            }
        }
    }, 'json').always(function() {});
}

function detChangepriority(caseId, priority, caseUniqId, cno) {
    var isPopup = (typeof arguments[4] != 'undefined' && arguments[4] == 'popup') ? 1 : 0;
    refreshTasks = 1;
    var prilod = "prilod" + caseId;
    var showUpdPri = "pridiv" + caseId;
    var cls = "";
    var protyTtl = "";
    var pre_priority = $('#' + showUpdPri).attr('data-priority');
    $("#" + showUpdPri).hide();
    $('#' + prilod).show();
    if (pre_priority == 0) {
        cls = "high_priority";
        protyTtl = "High";
    }
    if (pre_priority == 1) {
        cls = "medium_priority";
        protyTtl = "Medium"
    }
    if (pre_priority == 2) {
        cls = "low_priority";
        protyTtl = "Low"
    }
    if (pre_priority == priority) {
        $('#' + prilod).hide();
        $("#" + showUpdPri).show();
        $("#" + showUpdPri + ' .quick_action .prio_lmh').removeClass('prio_high prio_mediem prio_low').addClass('prio_' + protyTtl.toLowerCase());
    } else {
        $.post(HTTP_ROOT + "easycases/ajax_change_priority", {
            "caseId": caseId,
            "priority": priority
        }, function(data) {
            if (data) {
                $('#lst_uptd').html(data.last_updated);
                var params = parseUrlHash(urlHash);
                $('#' + prilod).hide();
                $("#" + showUpdPri).show();
                if (params[0] == 'details' || isPopup == 1) {
                    $(".task-detail-head").removeClass('high_priority medium_priority low_priority').addClass(data.protyCls);
                    $("#" + showUpdPri).removeClass('high_priority medium_priority low_priority').addClass(data.protyCls);
                    $("#" + showUpdPri + ' .quick_action').html('<span class="priority-symbol"></span>' + data.protyTtl + '<i class="tsk-dtail-drop material-icons">&#xE5C5;</i>');
                    $('#reply_box' + caseId).find('.comment-rdo-btn').find('input[type="radio"]').prop('checked', false);
                    var cls = data.protyTtl == 'Medium' ? 'mid' : data.protyTtl.toLowerCase();
                    $('#reply_box' + caseId).find('.comment-rdo-btn').find('input#priority_' + cls).prop('checked', true);
                    $('#CS_priority' + caseId).val(priority);
                    $("#" + showUpdPri).attr('data-priority', priority);
                    appendReplyThread(data.curCaseId, caseId);
                } else if (params[0] == 'tasks' || params[0] == 'taskgroup' || params[0] == 'backlog') {
                    $("#" + showUpdPri + ' .quick_action .prio_lmh').removeClass('prio_high prio_mediem prio_low').addClass('prio_' + data.protyTtl.toLowerCase());
                    tasklisttmplAdd(caseId)
                } else if (params[0] == 'taskgroups') {
                    $("#" + showUpdPri + ' .quick_action .prio_lmh').removeClass('prio_high prio_mediem prio_low').addClass('prio_' + data.protyTtl.toLowerCase());
                }
            }
        }, 'json').always(function() {
            if (isPopup == 1) {
                actiononTask(caseId, caseUniqId, cno, 'priority', 'popup');
            } else {
                actiononTask(caseId, caseUniqId, cno, 'priority');
            }
        });
    }
}

function ajaxSorting(type, cases, el) {
    $('#isSort').val("1");
    if (typeof(getCookie("TASKSORTBY") != 'undefined') && getCookie("TASKSORTBY") == type) {
        var tsorder = getCookie('TASKSORTORDER');
        if (tsorder == 'ASC') {
            remember_filters("TASKSORTORDER", 'DESC');
            var tcls = '<i class="material-icons tsk_desc">&#xE5CF;</i>';
        } else {
            remember_filters("TASKSORTORDER", 'ASC');
            var tcls = '<i class="material-icons tsk_asc">&#xE5CE;</i>';
        }
    } else {
        remember_filters("TASKSORTBY", type);
        remember_filters("TASKSORTORDER", 'DESC');
        var tcls = '<i class="material-icons tsk_asc">&#xE5CE;</i>';
    }
    $('.tsk_sort').removeClass('<i class="material-icons tsk_sort show_icons">&#xE164;</i>');
    var el = $('.sort' + type).children('.sorting_arw').html(tcls);
    easycase.refreshTaskList();
}

function ajaxSorting_v2(type, cases, el) {
    $('#isSort').val("1");
    if (typeof(getCookie("TASKSORTBY2") != 'undefined') && getCookie("TASKSORTBY2") == type) {
        var tsorder = getCookie('TASKSORTORDER2');
        if (tsorder == 'ASC') {
            remember_filters("TASKSORTORDER2", 'DESC');
            var tcls = '<i class="material-icons tsk_desc">&#xE5CF;</i>';
        } else {
            remember_filters("TASKSORTORDER2", 'ASC');
            var tcls = '<i class="material-icons tsk_asc">&#xE5CE;</i>';
        }
    } else {
        remember_filters("TASKSORTBY2", type);
        remember_filters("TASKSORTORDER2", 'DESC');
        var tcls = '<i class="material-icons tsk_asc">&#xE5CE;</i>';
    }
    $('.tsk_sort').removeClass('<i class="material-icons tsk_sort show_icons">&#xE164;</i>');
    var el = $('.sort' + type).children('.sorting_arw').html(tcls);
    easycase.refreshTaskList();
}

function filterValue(id, prjuniqid, date, type, status, member, comment, assignto, praiority, searchtxt, pname) {
    $('#customFIlterId').val(id);
    $('#caseStatus').val(status);
    $('#priFil').val(praiority);
    $('#caseTypes').val(type);
    $('#caseMember').val(member);
    $('#caseComment').val(comment);
    $('#caseAssignTo').val(assignto);
    $('#caseDateFil').val(date);
    if (prjuniqid == 'all') {
        var prjuid = 0;
        var radio = 0;
        var all = 'all';
        var page = 'dashboard';
    } else {
        var prjuid = prjuniqid;
        var radio = "proj_" + prjuniqid;
        var all = 0;
        var page = 'dashboard';
    }
    easycase.refreshTaskList();
}

function allfiltervalue(type) {
    if (arguments[1]) {
        var event = arguments[1];
        event.preventDefault();
        event.stopPropagation();
    }
    $('.dropdown_status').hide();
    $('#dropdown_menu_' + type + '_div').show();
    $('#dropdown_menu_' + type).show();
    $('.custome_archive').hide();
    $('.custome_archive').find('input[type="text"]').val('');
    if ((type != 'date' && type != 'duedate' && type != 'createdDate') && $('#dropdown_menu_' + type).length && $.trim($('#dropdown_menu_' + type).html()) != '') {
        return false;
    }
    if (type == 'casedate') {
        var x = getCookie('ARCHIVE_DATE');
        if (x != '' && x != 'all') {
            if (x.indexOf(":") != -1) {
                x = x.split(":");
                $('#arcduestrtdt').val(x[0]);
                $('#arcdueenddt').val(x[1]);
            } else {
                var id = 'arcchive_' + x;
                $('#' + id).attr('checked', 'cheched');
            }
        }
        $('#dropdown_menu_casedate_div').show();
        $('#dropdown_menu_casedate').show();
        return false;
    } else if (type == 'casestatus') {
        $.post(HTTP_ROOT + "requests/ajax_archive_sts_filter", {
            "projUniq": "all"
        }, function(data) {
            if (data) {
                $('#dropdown_menu_casestatus_div').show();
                $('#dropdown_menu_casestatus').html(data);
                $('#dropdown_menu_casestatus').show();
                $.material.init();
                var x = getCookie('ARCHIVE_STATUS');
                if (x != '' && x != 'all') {
                    if (x.indexOf('-') != -1) {
                        x = x.split('-');
                        var id = '';
                        for (i in x) {
                            if (x[i] == 1) {
                                $('#archive_new').prop('checked', true);
                            } else if (x[i] == 2) {
                                $('#archive_inprogress').prop('checked', true);
                            } else if (x[i] == 3) {
                                $('#archive_closed').prop('checked', true);
                            } else if (x[i] == 5) {
                                $('#archive_resolved').prop('checked', true);
                            } else {
                                $('#archive_' + x[i]).prop('checked', true);
                            }
                        }
                    }
                }
            }
        });
        return false;
    } else if (type == 'archiveduedate') {
        var x = getCookie('ARCHIVE_DUEDATE');
        if (x != '' && x != 'all') {
            if (x.indexOf(":") != -1) {
                x = x.split(":");
                $('#arcstrtdt').val(x[0]);
                $('#arcenddt').val(x[1]);
            } else {
                var id = 'arcchivedue_' + x;
                $('#' + id).attr('checked', 'cheched');
            }
        }
        $('#dropdown_menu_archiveduedate_div').show();
        $('#dropdown_menu_archiveduedate').show();
        return false;
    } else if (type == 'utilization') {
        $('#dropdown_menu_utilization_div').show();
        $('#dropdown_menu_utilization').show();
        return false;
    } else if (type == 'utilization_billability') {
        $('#dropdown_menu_billability_div').show();
        $('#dropdown_menu_billability').show();
        return false;
    } else if (type == 'utilization_status') {
        $('#dropdown_menu_utilization_status_div').show();
        $.post(HTTP_ROOT + "requests/ajax_utilization_sts_filter", {
            "projUniq": "all"
        }, function(data) {
            if (data) {
                $('#dropdown_menu_utilization_status').html(data);
                $('#dropdown_menu_utilization_status').show();
                $.material.init();
                var x = getCookie('utilization_status_filter');
                if (x != '' && x != 'all') {
                    if (x.indexOf('-') != -1) {
                        x = x.split('-');
                        var id = '';
                        for (i in x) {
                            if (x[i] == 1) {
                                $('#utilization_new').prop('checked', true);
                            } else if (x[i] == 2) {
                                $('#utilization_inprogress').prop('checked', true);
                            } else if (x[i] == 3) {
                                $('#utilization_closed').prop('checked', true);
                            } else if (x[i] == 5) {
                                $('#utilization_resolved').prop('checked', true);
                            } else {
                                $('#utilization_' + x[i]).prop('checked', true);
                            }
                        }
                    }
                }
            }
        });
        return false;
    } else if (type == 'pendingtask') {
        $('#dropdown_menu_pending').show();
        return false;
    } else if (type == 'pendingtask_status') {
        $.post(HTTP_ROOT + "requests/ajax_pending_sts_filter", {
            "projUniq": "all"
        }, function(data) {
            if (data) {
                $('#dropdown_menu_pending_status').html(data);
                $('#dropdown_menu_pending_status').show();
                $.material.init();
                var x = getCookie('pending_status_filter');
                if (x != '' && x != 'all') {
                    if (x.indexOf('-') != -1) {
                        x = x.split('-');
                        var id = '';
                        for (i in x) {
                            if (x[i] == 1) {
                                $('#pending_stsnew').prop('checked', true);
                            } else if (x[i] == 2) {
                                $('#pending_stsinprogress').prop('checked', true);
                            } else if (x[i] == 3) {
                                $('#pending_stsclosed').prop('checked', true);
                            } else if (x[i] == 5) {
                                $('#pending_stsresolved').prop('checked', true);
                            } else {
                                $('#pending_sts' + x[i]).prop('checked', true);
                            }
                        }
                    }
                }
            }
        });
        return false;
    }
    var hashtag = parseUrlHash(urlHash);
    if (hashtag == 'kanban') {
        $('#dropdown_menu_' + type).css({
            "display": "inline-block",
            'float': 'right'
        });
    } else {
        $('#dropdown_menu_' + type).css({
            "display": "inline-block",
            'float': 'none'
        });
    }
    var li_ldr = "<li><center><img src='" + HTTP_ROOT + "img/images/del.gif' alt='loading...' title='loading...'/><center></li>";
    if (type != 'createdDate') {
    $('#dropdown_menu_' + type).html(li_ldr);
    }
    var projFil = $('#projFil').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    if (type == 'tskgrp') {
        var checktype = $('#checktype').val();
        $.post(HTTP_ROOT + "easycases/ajax_taskgroups", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'checktype': checktype
        }, function(data) {
            if (data) {
                $('#dropdown_menu_tskgrp').html(data);
                $.material.init();
            }
        });
    } else if (type == 'mlstn') {
        var checktype = $('#checktype').val();
        $.post(HTTP_ROOT + "easycases/ajax_milestones", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'checktype': checktype
        }, function(data) {
            if (data) {
                $('#dropdown_menu_mlstn').html(data);
                $.material.init();
            }
        });
    } else if (type == 'date') {
        $('#dropdown_menu_date').html(tmpl("date_filter_tmpl"));
        iniDateFilter();
        $.material.init();
        if (typeof localStorage['DATE'] != 'undefined') {
            x = localStorage['DATE'].split("-");
            if (x.length) {
                $("#date_any").attr("checked", false);
                for (var i = 0; i < x.length; i++) {
                    if (document.getElementById("date_" + x[i]) !== null) {
                    $("#date_" + x[i]).attr("checked", "checked");
                    } else {
                        var cstm_val = decodeURIComponent(x[i]);
                        cstm_val = cstm_val.split('_');
                        $("#date_custom").attr("checked", "checked");
                        $('#custom_date').show();
                        $('#frm').show().val(cstm_val[0]);
                        $('#to').show().val(cstm_val[1]);
                }
            }
                return false;
            }
        }
    } else if (type == 'createdDate') {
        $('#dropdown_menu_createddate_div').show();
        $('#dropdown_menu_createddate').show();
        return false;
    } else if (type == 'resource') {
        $('#dropdown_menu_resource_div').show();
        $('#dropdown_menu_resource').show();
        var resourcelist = "";
        var usrids = $('#tlog_resource').val().split('-');
        $.each(PUSERS, function(key, val) {
            $.each(val, function(k1, v1) {
                var checked = "";
                var usrid = v1['User']['id'];
                if ($.inArray(usrid, usrids) > -1) {
                    checked = "checked";
                }
                var type = 'check';
                resourcelist += "<li class='li_check_radio'><a href='javascript:void(0)'><div class='checkbox'><label><input id='res_" + usrid + "' class='resource_check' data-id='" + usrid + "' type='checkbox' onclick='general.filterResource(" + usrid + ", \"" + type + "\")' " + checked + "/> " + v1['User']['name'] + "</label></div></a></li>";
            });
        });
        rInput = '<input type="text" placeholder="' + _('Search') + '" class="searchType" onkeyup="searchFilterItems(this);">';
        $('#dropdown_menu_resource').html(rInput + resourcelist)
        $.material.init();
    } else if (type == 'casetitle') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_case_title',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_casetitle').html(data);
                $.material.init();
            }
        });
    } else if (type == 'project') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_archive_project',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_project').html(data);
                $.material.init();
            }
        });
    } else if (type == 'archivedby') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_archivedby',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_archivedby').html(data);
                $.material.init();
            }
        });
    } else if (type == 'archiveassign') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_archive_assign',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_archiveassign').html(data);
                $.material.init();
            }
        });
    } else if (type == 'utilization_resource') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_utilization_resource',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_utilization_resource').html(data);
                $.material.init();
            }
        });
    } else if (type == 'utilization_label') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_utilization_label',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_utilization_label').html(data);
                $.material.init();
            }
        });
    } else if (type == 'pending_resource') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_pending_resource',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_pending_resource').html(data);
                $.material.init();
            }
        });
    } else if (type == 'utilization_project') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_utilization_project',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_utilization_project').html(data);
                $.material.init();
            }
        });
    } else if (type == 'pending_project') {
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype,
            'page_type': 'ajax_pending_project',
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#dropdown_menu_pending_project').html(data);
                $.material.init();
            }
        });
    } else {
        var caseStatus = $("#caseStatus").val();
        var case_date = $("#caseDateFil").val();
        var case_due_date = $("#casedueDateFil").val();
        var caseTypes = $("#caseTypes").val();
        var caseLabel = $("#caseLabel").val();
        var caseMember = $("#caseMember").val();
        var caseComment = $("#caseComment").val();
        var caseAssignTo = $("#caseAssignTo").val();
        var caseSearch = $("#caseSearch").val();
        var priFil = $("#priFil").val();
        var milestoneIds = $("#milestoneIds").val();
        var checktype = $("#checktype").val();
        if (type == 'status') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'caseLabel': caseLabel,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_status',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_status').html(data);
                    $.material.init();
                    if (typeof localStorage['STATUS'] != 'undefined') {
                        x = localStorage['STATUS'].split("-");
                        if (x.length) {
                            $("#status_all").attr("checked", false);
                            for (var i = 0; i < x.length; i++) {
                                if (x[i] == '1')
                                    v = "status_new";
                                else if (x[i] == '2')
                                    v = "status_open";
                                else if (x[i] == '3')
                                    v = "status_close";
                                else if (x[i] == '5')
                                    v = "status_resolve";
                                else if (x[i] == 'attch')
                                    v = "status_file";
                                else if (x[i] == 'upd')
                                    v = "status_upd";
                                else if (x[i] == 'all' || x[i] == '' || x[i] == 'undefined')
                                    v = "status_all";
                                $("#" + v).attr("checked", "checked");
                            }
                        }
                    }
                    if (typeof localStorage['CUSTOM_STATUS'] != 'undefined') {
                        x = localStorage['CUSTOM_STATUS'].split("-");
                        if (x.length) {
                            $("#status_all").attr("checked", false);
                            for (var i = 0; i < x.length; i++) {
                                v = "custom_status_" + x[i];
                                $("#" + v).attr("checked", "checked");
                            }
                        }
                    }
                }
            });
        } else if (type == 'types') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'caseLabel': caseLabel,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_types',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_types').html(data);
                    $.material.init();
                    if (typeof localStorage['CS_TYPES'] != 'undefined') {
                        x = localStorage['CS_TYPES'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            $("#types_" + x[i]).attr("checked", "checked");
                        }
                    }
                }
            });
        } else if (type == 'priority') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_priority',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_priority').html(data);
                    $.material.init();
                    if (typeof localStorage['PRIORITY'] != 'undefined') {
                        x = localStorage['PRIORITY'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            $("#priority_" + x[i]).attr("checked", "checked");
                        }
                    }
                }
            });
        } else if (type == 'users') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_members',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_users').html(data);
                    $.material.init();
                    if (typeof localStorage['MEMBERS'] != 'undefined') {
                        x = localStorage['MEMBERS'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            $(".member" + x[i]).attr("checked", "checked");
                        }
                    }
                }
            });
        } else if (type == 'comments') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_comments',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_comments').html(data);
                    $.material.init();
                    if (typeof localStorage['COMMENTS'] != 'undefined') {
                        x = localStorage['COMMENTS'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            $(".comment" + x[i]).attr("checked", "checked");
                        }
                    }
                }
            });
        } else if (type == 'taskgroup') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_taskgroup',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_taskgroup').html(data);
                    $.material.init();
                    if (typeof localStorage['TASKGROUP'] != 'undefined') {
                        x = localStorage['TASKGROUP'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            $(".taskgroup" + x[i]).attr("checked", "checked");
                        }
                    }
                }
            });
        } else if (type == 'assignto') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_assignto',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_assignto').html(data);
                    $.material.init();
                    if (typeof localStorage['ASSIGNTO'] != 'undefined') {
                        x = localStorage['ASSIGNTO'].split("-");
                        for (var i = 0; i < x.length; i++) {
                            if (x[i] == 'unassigned') {
                                $(".assignto0").attr("checked", "checked");
                            } else {
                                $(".assignto" + x[i]).attr("checked", "checked");
                            }
                        }
                    }
                }
            });
        } else if (type == 'label') {
            $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": projFil,
                "pageload": 0,
                "caseMenuFilters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseTypes': caseTypes,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'caseLabel': caseLabel,
                'milestoneIds': milestoneIds,
                'checktype': checktype,
                'page_type': 'ajax_label',
                "pageload": 0
            }, function(data) {
                if (data) {
                    $('#dropdown_menu_label').html(data);
                    $.material.init();
                    if (typeof localStorage['TASKLABEL'] != 'undefined') {
                        x = localStorage['TASKLABEL'].split("-");
                        $('.label_type_cls').each(function() {
                            var dt_id = $(this).attr('data-id');
                            for (var i = 0; i < x.length; i++) {
                                if ($("#Labelids_" + dt_id).val() == x[i]) {
                                    $("#Label_" + dt_id).attr("checked", "checked");
                                }
                            }
                        });
                    }
                }
            });
        } else if (type == 'duedate') {
            $('#dropdown_menu_duedate').html(tmpl("duedate_filter_tmpl"));
            iniDueDateFilter();
            $.material.init();
            if (typeof localStorage['DUE_DATE'] != 'undefined') {
                x = localStorage['DUE_DATE'].split("-");
                if (x.length) {
                    $("#duedate_any").attr("checked", false);
                    for (var i = 0; i < x.length; i++) {
                        if (document.getElementById("duedate_" + x[i]) !== null) {
                        document.getElementById("duedate_" + x[i]).checked = true;
                        } else {
                            var cstm_val = decodeURIComponent(x[i]);
                            cstm_val = cstm_val.split(':');
                            document.getElementById("duedate_custom").checked = true;
                            $('#duedate_custom').trigger('click');
                            $('#duefrm').val(cstm_val[0]);
                            $('#dueto').val(cstm_val[1]);
                        }
                    }
                }
            }
        }
    }
}

function iniDateFilter() {
    $("#frm").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#frm").datepicker('getFormattedDate');
        $("#to").datepicker("setStartDate", dateText);
    });
    $("#to").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#to").datepicker('getFormattedDate');
        $("#frm").datepicker("setEndDate", dateText);
    });
    $("#ui-datepicker-div").click(function(e) {
        e.stopPropagation();
    });
}

function iniDueDateFilter() {
    $("#duefrm").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#duefrm").datepicker('getFormattedDate');
        $("#dueto").datepicker("setStartDate", dateText);
    });
    $("#dueto").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#dueto").datepicker('getFormattedDate');
    });
    $("#ui-datepicker-div").click(function(e) {
        e.stopPropagation();
    });
}

function common_reset_filter(ftype, id, obj) {
    closeTaskFilter();
    casePage = 1;
    if ($('.filter_opn').length == 1) {
        $(".tipsy").remove();
        $('#filtered_items').fadeOut('slow');
        $('#savereset_filter,#savesegment_filter').fadeOut('slow');
    } else {
        $(obj).parent('div').fadeOut('slow');
        $(".tipsy").remove();
    }
    prjid = $('#projFil').val();
    if (ftype == 'taskstatus') {
        var ext_val = $('#caseStatus').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                status_str = get_formated_string(ext_val, id);
            } else {
                status_str = 'all'
            }
        }
        if (typeof status_str != 'undefined') {
            $('#caseStatus').val(status_str);
            remember_filters('STATUS', status_str);
        } else {
            $('#caseStatus').val('all');
        }
    } else if (ftype == 'customtaskstatus') {
        var ext_val = getGlobalFilters('CUSTOM_STATUS');
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                status_str = get_formated_string(ext_val, id);
            } else {
                status_str = 'all'
            }
        }
        if (typeof status_str != 'undefined') {
            $('#caseCustomStatus').val(status_str);
            remember_filters('CUSTOM_STATUS', status_str);
        } else {
            $('#caseCustomStatus').val('all');
        }
    } else if (ftype == 'tasktype') {
        var ext_val = $('#caseTypes').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseTypes').val(formated_str);
            remember_filters('CS_TYPES', formated_str);
        } else {
            $('#caseTypes').val('all');
        }
    } else if (ftype == 'label') {
        var ext_val = $('#caseLabel').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseLabel').val(formated_str);
            remember_filters('TASKLABEL', formated_str);
        } else {
            $('#caseLabel').val('all');
        }
    } else if (ftype == 'priority') {
        var ext_val = $('#priFil').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#priFil').val(formated_str);
            remember_filters('PRIORITY', formated_str);
        } else {
            $('#priFil').val('all');
        }
    } else if (ftype == 'members') {
        var ext_val = $('#caseMember').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseMember').val(formated_str);
            remember_filters('MEMBERS', formated_str);
        } else {
            $('#caseMember').val('all');
        }
    } else if (ftype == 'taskgroups') {
        var ext_val = $('#caseTaskgroup').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseTaskgroup').val(formated_str);
            remember_filters('TASKGROUP', formated_str);
        } else {
            $('#caseTaskgroup').val('all');
        }
    } else if (ftype == 'comments') {
        var ext_val = $('#caseComment').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseComment').val(formated_str);
            remember_filters('COMMENTS', formated_str);
        } else {
            $('#caseComment').val('all');
        }
    } else if (ftype == 'assignto') {
        var ext_val = $('#caseAssignTo').val();
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            $('#caseAssignTo').val(formated_str);
            remember_filters('ASSIGNTO', formated_str);
        } else {
            $('#caseMember').val('all');
        }
    } else if (ftype == 'date') {
        var x = '';
        $('#caseDateFil').val('');
        remember_filters('DATE', x);
    } else if (ftype == 'duedate') {
        var x = '';
        $('#casedueDateFil').val('');
        remember_filters('DUE_DATE', x);
    } else if (ftype == 'mlstn') {
        $('#milestoneIds').val('all');
        remember_filters('MILESTONES', 'all');
    } else if (ftype == 'tskgrp') {
        remember_filters('TASKGROUP_FIL', 'all');
    } else if (ftype == 'search') {
        casePage = 1;
        $('#case_search, #caseSearch').val("");
        $('#case_srch').val("");
        var requiredUrl = document.URL;
        var n = requiredUrl.indexOf("filters=cases");
        if (n != -1) {
            remember_filters('CASESRCH', '');
            remember_filters('SEARCH', '');
            window.location = HTTP_ROOT + "dashboard/";
        } else {
            remember_filters('CASESRCH', '');
            remember_filters('SEARCH', '');
        }
    } else if (ftype == 'casepage') {
        casePage = 1;
    } else if (ftype == 'taskorder') {
        remember_filters('TASKSORTBY', '');
        remember_filters('TASKSORTORDER', '');
    } else if (ftype == 'taskgroupby') {
        $('.sortby_btn').removeAttr('disabled');
        $('.sortby_btn').removeClass('disable-btn');
        remember_filters('TASKGROUPBY', '');
    }
    if (getCookie('SUBTASKVIEW') == 'subtaskview') {
        var flt_len = $("#filtered_items").find('span').length;
        if (flt_len > 1) {
            easycase.refreshTaskList();
        } else {
            easycase.showtaskgroups();
        }
    } else {
    if (parseInt($("#subtask-container").height()) > 70) {
        ajaxCaseSubtaskView();
    } else {
        easycase.refreshTaskList();
    }
}
}

function get_formated_string(inputstr, cmpval) {
    var output_string = '';
    var arr = inputstr.split('-');
    var string_len = arr.length;
    if (cmpval.indexOf("custom_status_") !== -1) {
        var cmpval_t = cmpval.split('custom_status_');
        cmpval = cmpval_t[1];
    }
    for (var i = 0; i < string_len; i++) {
        if (arr[i] != cmpval) {
            output_string += arr[i] + "-";
        }
    }
    return trim(output_string, '-');
}

function openfilter_popup(flag, dropdownid) {
    $('#tskgrpli').hide();
    if ($('#cview_btn').hasClass('disable')) {
        $('#tskgrpli').show();
    }
    if ($('#' + dropdownid).is(":visible") && !parseInt(flag)) {
        $('#' + dropdownid).hide();
        $('.dropdown_status').hide();
    } else {
        $('.case-filter-menu ul.dropdown-menu').hide();
        $('.archive-filter-menu ul.dropdown-menu').hide();
        $('.dropdown_status').hide();
        $('#' + dropdownid).show();
    }
}

function statusTop(status) {
    $('#caseStatus').val(status);
    projid = $('#projFil').val();
    casePage = 1;
    paramdata = parseUrlHash(urlHash);
    if (!$('#reset_btn').is(":visible") || $('#caseStatusprev').val() != status) {
        $('#caseStatusprev').val(status);
        remember_filters('STATUS', status);
        if (parseInt($("#subtask-container").height()) > 70) {
            ajaxCaseSubtaskView();
        } else {
            if ($('#caseMenuFilters').val() == 'kanban') {
                easycase.showKanbanTaskList();
            } else if (paramdata[0] == 'taskgroup') {
                easycase.refreshTaskList();
            } else if (paramdata[0] == 'taskgroups') {
                easycase.refreshTaskList();
            } else {
                if (PAGE_NAME == 'mydashboard') {
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                } else {
                    ajaxCaseView('case_project.php');
                }
            }
        }
    } else {
        resetAllFilters('all', 1);
        easycase.refreshTaskList();
    }
}

function customStatusTop(status) {
    $('#caseCustomStatus').val(status);
    projid = $('#projFil').val();
    casePage = 1;
    paramdata = parseUrlHash(urlHash);
    if (!$('#reset_btn').is(":visible") || $('#caseCustomStatusprev').val() != status) {
        $('#caseCustomStatusprev').val(status);
        remember_filters('CUSTOM_STATUS', status);
        if (parseInt($("#subtask-container").height()) > 70) {
            ajaxCaseSubtaskView();
        } else {
            if ($('#caseMenuFilters').val() == 'kanban') {
                easycase.showKanbanTaskList();
            } else if (paramdata[0] == 'taskgroup') {
                easycase.refreshTaskList();
            } else if (paramdata[0] == 'taskgroups') {
                showTaskByTaskGroupNew();
            } else {
                if (PAGE_NAME == 'mydashboard') {
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                } else {
                    ajaxCaseView('case_project.php');
                }
            }
        }
    } else {
        resetAllFilters('all', 1);
        easycase.refreshTaskList();
    }
}
easycase.routerHideShow = function(page) {
    if (page != 'details') {
    $('#startTourBtn').hide();
    var angular = typeof arguments[1] ? "1" : '0';
    if (angular) {
        paramdata = arguments;
    } else {
        paramdata = parseUrlHash(urlHash);
    }
    $('.main_page_menu_togl_ul').hide();
    $('#select_view_timelog').hide();
    $('.os_projct_overview_date').hide();
    $('#ajaxViewProjects').find('a.proj_lnks').show();
    $("#caseTimeLogDv").hide();
    $('#tasklogbreadcum').hide();
    $("#dropdown_menu_all_filters").find(".nolog").show();
    $("#dropdown_menu_all_filters").find(".log").hide();
    $("#dropdown_menu_all_filters_t").find(".nolog").show();
    $("#dropdown_menu_all_filters_t").find(".log").hide();
    $('.milestonekb_detail_head').hide();
    $('.task-list-bar').hide();
    $('.overview-bar').hide();
    $('.kanban_stas_bar').hide();
    $('.timlog_top_bar').hide();
    $('.timesheet_top_bar').hide();
    $('.filter_top_cnt').hide();
    $('.activity-bar').hide();
    $('.archive-bar').hide();
    $('.files-bar').hide();
    $('#savereset_filter').hide();
    $('.files-bar').hide();
    $('.files-nav-text').hide;
    $('.timelog_filter_msg').hide();
    $('.project-dropdown').show();
    $('.project-dropdown').prev('li').show();
    $('#task_impExp').hide();
    $('#task_reload_icon').hide();
    $('.crt_task_btn_btm').show();
    if (!$('#cview_btn').hasClass('disable')) {
        $('#tskgrpli').hide();
    }
    $('#caseOverview').hide();
    $('.milst_addition').hide();
    $('.filter_det').hide();
    $('.task_section').hide();
    $('#saveFilter').hide();
    $('.kanban_section').hide();
    $('#mlsttab_sta').hide();
    $('.calendar_section').hide();
    $("#caseFileDv").hide();
    $("#widgethideshow").hide();
    $('.dashborad-view-type').hide();
    $('#mlist_crt_mlstbtn').hide();
    $('#actvt_section').hide();
    $('#mention_section').hide();
    $('#milestone_content').hide();
    $('.breadcrumb_div').hide();
    $('.tasksortby-div').hide();
    $('#sortby_items').hide();
    $('.taskgroupby-div').hide();
    $('#groupby_items').hide();
    $('#select_view_mlst').hide();
    $('.bcrumbtimelog').hide();
    $('.timelog-detail-tbl').hide();
    $('#filter_section').hide();
    $('#btn-reset-timelog').hide();
    $('.show_total_case').hide();
    $('.case-filter-menu').hide();
    $('#caseViewSpan').hide();
    $('#task_paginate').hide();
    $('#select_view').hide();
    $('#milestonelisting').hide();
    $('#filtered_items').hide();
    $('#savereset_filter').hide();
    $('#manage_milestone').hide();
    $('#TimeLog_calendar_view').hide();
    $('#topactions').hide();
    $('#TimeLog_paginate').hide();
    $('.sts_filter').hide();
    $('#mlsttab_sta').hide();
    $('#mlsttab_sta_container').hide();
    $('.kanban_filter_det').hide();
    $('#overview_btn').removeClass('disable');
    $('.rht_content_cmn').addClass('task_lis_page');
    $(".toggle-nevigate-drop-down").hide();
    $("#select_view_timelog").find('li').each(function() {
        $(this).removeClass('active-list')
    });
    $("#topactions").find('li').each(function() {
        $(this).removeClass('active-list')
    });
    $("#timesheet_exp").hide();
    $(".expPDFList").hide();
    $('#overview_exp').hide();
    $('#dropdown_menu_taskgroup').closest('li').hide();
    $('#dropdown_menu_taskgroup').parent().parent().hide();
    $(".menu-mention").removeClass('active');
    $(".menu-case").removeClass('active');
    if (page == 'overview') {
        showOtherSubMenu();
        $('.side-nav').children('li').removeClass('active');
        $('#calendar_btn,#actvt_btn,#kbview_btn,#lview_btn,#timelog_btn,#lview_btn_timelog,#files_btn,#cview_btn,#invoice_btn').removeClass('disable');
        $('#overview_btn').addClass('disable');
        $('.breadcrumb_div').show();
        $('.task-list-bar').show();
        $('.overview-bar').show();
        $('#select_view').show();
        $('#caseOverview').show();
        $('#ul_mydashboard').css('margin-top', '18px');
        $('.side-nav').children('li.list-7').addClass('active');
        $('#overview_exp').show();
    } else if (page == 'details') {
        showTaskSubMenu();
        $('.rht_content_cmn').removeClass('task_lis_page');
        $('.task_detail_head').show();
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $('.project-dropdown').show();
        $('.project-dropdown').prev('li').show();
    } else if (page == 'files') {
        showOtherSubMenu();
        $("#caseFileDv").show();
        $('.breadcrumb_div').show();
        $('#select_view').show();
        $('#filtered_items').show();
        $('.files-bar').show();
        $('#savereset_filter').css('display', 'table-cell');
        $('#files_btn').addClass('disable');
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
    } else if (paramdata[0] == 'searchFilters' || page == 'searchFilters') {
        showOtherSubMenu();
        $('#filtered_items').hide();
        $('#caseViewSpanUnclick').show();
        $('#task_paginate').show();
        $('#task_paginate').html("");
        $('#milestonelist').html('');
        $('.filter_det').show();
        $('#milestoneUid').val('');
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        searchFilterView();
    } else if (page == 'kanban') {
        showOtherSubMenu();
        var params = parseUrlHash(urlHash);
        if ($('#hiddensavennew').val() == 1) {
            location.reload();
        }
        $('.kanban-bar').show();
        $('#topactions').show();
        $('#mlsttab_sta_container').show();
        $('#mlstab_act_kanban_sta').removeClass('active-list');
        $('#kanban_sts_bar').addClass('active-list');
        $(".kanban_breadcrumb").addClass('active-list');
        $('#caseViewSpan').html('');
        $('#task_paginate').html('');
        $('.milst_addition').hide();
        $('#filter_section').show();
        $('.os_plus').show();
        if ($('#milestoneUid').val() && typeof params[1] != 'undefined') {
            $('.case-filter-menu').hide();
            $('#mlist_crt_mlstbtn').hide();
            $('#filtered_items').hide();
            $('#savereset_filter').hide();
            $('.breadcrumb_div').hide();
            $('.milestonekb_detail_head').show();
        } else {
            $('#mlstab_act_kanban_sta').removeClass('active-list');
            $('#mlsttab_sta').show();
            $('.case-filter-menu,.filter_det').show();
            $('.breadcrumb_div').show();
            $('#filtered_items').show();
        }
        $('.kanban_section').show();
        $('#milestonelist').html('');
        $('#select_view').show();
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $('.case-filter-menu').addClass('kanbanview-filter');
        $('#dropdown_menu_taskgroup').closest('li').show();
        $('#dropdown_menu_taskgroup').parent().parent().show();
    } else if (page == 'calendar') {
        showOtherSubMenu();
        $('.side-nav').children('li').removeClass('active');
        $('.side-nav').children('li.list-2').addClass('active');
        $(".calendar_breadcrumb").addClass('active-list');
        $('#milestoneUid').val('');
        $('#caseViewSpan').html('');
        $('#task_paginate').html('');
        if ($('#milestoneUid').val()) {
            $('.case-filter-menu').hide();
            $('#mlist_crt_mlstbtn').hide();
            $('.breadcrumb_div').hide();
            $('.milestonekb_detail_head').show();
        } else {
            $('.breadcrumb_div').show();
        }
        $('#topactions').show();
        $('.calendar-bar').show();
        $('.calendar_section').show();
        $('#milestonelist').html('');
        $('#select_view').show();
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $('.menu-cases').addClass('active');
        if (!(localStorage.getItem("theme_setting") === null)) {
            var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
            $(".side-nav li").each(function() {
                $(this).removeClass(th_class_str);
            });
            $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
        }
    } else if (page == 'calendar_timelog') {
        showOtherSubMenu();
        $(".side-nav li").removeClass('active');
        $(".menu-logs").addClass('active');
        $("#caseTimeLogDv").show();
        $('#select_view_timelog').show();
        $('.btn_tlog_top_fun').show();
        $('#timelogtbl').addClass('temp-class');
        $('#TimeLog_calendar_view').show().css({
            'margin-top': '0px',
        });
        $('#filter_text').html("<b>" + _('for all users and all dates') + "</b>");
        if ($('#milestoneUid').val()) {
            $('.case-filter-menu').hide();
            $('.breadcrumb_div').hide();
            $('.milestonekb_detail_head').show();
        } else {
            $('.breadcrumb_div').show();
        }
        $('.tg_calendar-bar').show();
        $('.timlog_top_bar').show();
        $('.calendar_section').show();
        $('#select_view_timelog').show();
        $('#select_view').show();
        $('#task_impExp').hide();
    } else if (page == 'chart_timelog') {
        showOtherSubMenu();
        $(".side-nav li").removeClass('active');
        $(".menu-logs").addClass('active');
        $("#caseTimeLogDv").show();
        $('#select_view_timelog').show();
        $('.btn_tlog_top_fun').show();
        $('#timelogtbl').addClass('temp-class');
        $('#TimeLog_calendar_view').hide();
        $('#filter_text').html("<b>" + _('for all users and all dates') + "</b>");
        if ($('#milestoneUid').val()) {
            $('.case-filter-menu').hide();
            $('.breadcrumb_div').hide();
            $('.milestonekb_detail_head').show();
        } else {
            $('.breadcrumb_div').show();
        }
        $('.tg_calendar-bar').show();
        $('.timlog_top_bar').show();
        $('.calendar_section').show();
        $('#select_view_timelog').show();
        $('#select_view').show();
        $('#task_impExp').hide();
    } else if (page == 'timesheet' || page == 'timesheet_weekly') {
        $("#timesheet_exp").show();
        showOtherSubMenu();
        $(".side-nav li").removeClass('active');
        $(".menu-logs").addClass('active');
        $('#select_view_timesheet').show();
        if (page == 'timesheet_weekly') {
            $('#timesheet_btn_daily').closest('li').removeClass('active-list');
            $('#timesheet_btn_weekly').closest('li').addClass('active-list');
        } else {
            $('#timesheet_btn_daily').closest('li').addClass('active-list');
            $('#timesheet_btn_weekly').closest('li').removeClass('active-list');
        }
        $('.tg_calendar-bar').show();
        $('.timesheet_top_bar').show();
        $('#select_view').show();
        $('#task_impExp').hide();
    } else if (page == 'activities') {
        showOtherSubMenu();
        $('.side_nav_new').children('li').removeClass('active');
        $('.breadcrumb_div').show();
        $('#select_view').show();
        $('#actvt_section').show();
        $('.activities-bar').show();
        $('.activity-bar').show();
        $('.actvty_li').addClass("active-list");
        $('.mntn_li').removeClass("active-list");
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $(".side-nav li").removeClass('active');
        $('.menu-cases').addClass('active');
        if (!(localStorage.getItem("theme_setting") === null)) {
            var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
            $(".side-nav li").each(function() {
                $(this).removeClass(th_class_str);
            });
            $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
        }
    } else if (page == 'mentioned_list') {
        showOtherSubMenu();
        $(".menu-case").removeClass('active');
        $('.side_nav_new').children('li').removeClass('active');
        $('.breadcrumb_div').show();
        $('#select_view').show();
        $('#mention_section').show();
        $('.activities-bar').show();
        $('.activity-bar').show();
        $('.mntn_li').addClass("active-list");
        $('.actvty_li').removeClass("active-list");
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $(".side-nav li").removeClass('active');
        $(".menu-mention").addClass('active');
        if (!(localStorage.getItem("theme_setting") === null)) {
            var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
            $(".side-nav li").each(function() {
                $(this).removeClass(th_class_str);
            });
            $('.menu-mention').addClass(th_set_obj.sidebar_color + " gradient-shadow");
        }
    } else if (page == 'milestone') {
        showOtherSubMenu();
        $('.kanban_section').html('');
        $('.breadcrumb_div').show();
        $('#select_view_mlst').show();
        $('#milestone_content').show();
        $('#manage_milestone').show();
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
    } else if (page == 'milestonelist') {
        showOtherSubMenu();
        if ($('#hiddensavennew').val() == 1) {
            location.reload();
        }
        $('.milst_addition').hide();
        $('#kanban_sts_bar').removeClass('active-list');
        $('#mlstab_act_kanban_sta').addClass('active-list');
        $('.kanban-bar').show();
        $('.kanban_stas_bar').hide();
        $('#topactions').show();
        $(".kanban_breadcrumb").addClass('active-list');
        $('#mlstab_act_kanban_sta').addClass('active-list');
        $('#kanban_sts_bar').removeClass('active-list');
        $('#caseViewSpan').html('');
        $('#task_paginate').html('');
        $('.kanban_section').html('');
        $('.breadcrumb_div').show();
        $('#calendar_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').addClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#invoice_btn').removeClass('disable');
        $('#select_view').show();
        $('#milestonelisting').show();
        $('#mlist_crt_mlstbtn').show();
        $('#milestone_content').show();
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        $('.kanban_filter_det').hide();
        if ($('#filtered_items').html().trim() != '') {
            $('#savereset_filter').show();
        } else {
            $('#savereset_filter').hide();
        }
        $('.case-filter-menu,.filter_det').show();
        $('.case-filter-menu').addClass('kanbanview-filter');
    } else if (page == 'timelog') {
        showOtherSubMenu();
        $('.timelog-detail-tbl').show();
        $('#select_view_timelog').show();
        $('.btn_tlog_top_fun').show();
        $('#ajaxViewProjects').find('a.proj_lnks').not($('#ajaxViewProjects').find('.ttc,.more')).hide();
        $('.case-filter-menu').show();
        $('#select_view').show();
        $('#timelog_btn').addClass('disable');
        $('#lview_btn_timelog').addClass('disable');
        $('#lview_btn_timelog').closest('li').addClass('active-list');
        $('#calendar_btn_timelog').removeClass('disable');
        $('.breadcrumb_div').css('height', '60px');
        $('.tg_calendar-bar').show();
        $('.timlog_top_bar').show();
        $('.filter_rt').show();
        $("#dropdown_menu_all_filters").find(".log").show();
        $("#dropdown_menu_all_filters").find(".nolog").hide();
        $("#dropdown_menu_all_filters_t").find(".log").show();
        $("#dropdown_menu_all_filters_t").find(".nolog").hide();
        $("#caseTimeLogDv").show();
        $('#caseTimeLogViewSpan').show();
        $('#task_impExp').hide();
    } else if (page == 'subtask') {
        $(".subtask_breadcrumb").addClass('active-list');
        $('#topactions').show();
        $('.breadcrumb_fixed').show();
        $('.slide_rht_con').show();
        $('.kanban_section').html('');
        $('#caseViewSpan').show();
        $('#filtered_items').show();
        $('#task_filter').show();
        $('#task_impExp').show();
        $('#task_list_bar').show();
        $('#caseViewSpanUnclick').show();
        $('#task_paginate').show('');
        $('.breadcrumb_div').show();
        $("#widgethideshow").show();
        $('#select_view').show();
        $('#milestonelist').html('');
        $('.filter_det').show();
        $('#milestoneUid').val('');
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        if ($('#projFil').val() == 'all') {
            $('#mvTaskToProj').hide();
        } else {
            $('#mvTaskToProj').show();
        }
        $('#timelog_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#select_view div').removeClass('disable');
        if ($('#lviewtype').val() == 'compact') {
            $('.tsk_tbl').addClass('compactview_tbl');
            $('#topaction').addClass('compactview_action');
            $('#cview_btn').addClass('disable');
        } else {
            $('.tsk_tbl').removeClass('compactview_tbl');
            $('#topaction').removeClass('compactview_action');
            $('#lview_btn').addClass('disable');
        }
        if ($('#lviewtype').val().trim() == 'compact') {} else {
            $('.tasksortby-div').show();
            $('#sortby_items').show();
            $('.taskgroupby-div').show();
            $('#groupby_items').show();
        }
        $('.case-filter-menu').removeClass('kanbanview-filter');
        if ($('#inline_milestone').length) {
            $('#top_tsk_list_dv').addClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '102.5%');
        } else {
            $('#top_tsk_list_dv').removeClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '100%');
        }
        showTaskSubMenu();
    } else if (page == 'backlog') {
        $('#startTourBtn').hide();
        $('#task_reload_icon').show();
        $('.breadcrumb_fixed').show();
        $('.slide_rht_con').show();
        $('#topactions').show();
        $('.kanban_section').html('');
        $('#caseViewSpan').show();
        $('#filtered_items').show();
        $('#task_filter').show();
        $('#task_impExp').show();
        $('#task_list_bar').hide();
        $('#caseViewSpanUnclick').show();
        $('#task_paginate').show('');
        $('.breadcrumb_div').show();
        $("#widgethideshow").show();
        $('#select_view').show();
        $('#milestonelist').html('');
        $('.filter_det').show();
        $('#milestoneUid').val('');
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        if ($('#projFil').val() == 'all') {
            $('#mvTaskToProj').hide();
        } else {
            $('#mvTaskToProj').show();
        }
        $('#timelog_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#select_view div').removeClass('disable');
        if ($('#lviewtype').val() == 'compact') {
            $('.tsk_tbl').addClass('compactview_tbl');
            $('#topaction').addClass('compactview_action');
            $('#cview_btn').addClass('disable');
        } else {
            $('.tsk_tbl').removeClass('compactview_tbl');
            $('#topaction').removeClass('compactview_action');
            $('#lview_btn').addClass('disable');
        }
        if ($('#lviewtype').val().trim() == 'compact') {
            $('.tasksortby-div').hide();
            $('#sortby_items').hide();
            $('.taskgroupby-div').hide();
            $('#groupby_items').hide();
        } else {
            $('.tasksortby-div').show();
            $('#sortby_items').show();
            $('.taskgroupby-div').show();
            $('#groupby_items').show();
        }
        $('.case-filter-menu').removeClass('kanbanview-filter');
        if ($('#inline_milestone').length) {
            $('#top_tsk_list_dv').addClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '102.5%');
        } else {
            $('#top_tsk_list_dv').removeClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '100%');
        }
    } else {
        showTaskSubMenu();
        var gethsh = getHash();
        if (gethsh == "taskgroups") {
            $(".taskgroup_breadcrumb").addClass('active-list');
            $(".expPDFList").show();
        } else {
        if (getCookie('TASKGROUPBY') == 'milestone') {
            $(".taskgroup_breadcrumb").addClass('active-list');
            $(".expPDFList").show();
        } else {
            $(".tasklist_breadcrumb").addClass('active-list');
            $(".expPDFList").show();
        }
            if (gethsh.indexOf('tasks') !== -1) {
                $('#dropdown_menu_taskgroup').closest('li').show();
                $('#dropdown_menu_taskgroup').parent().parent().show();
            }
        }
        $('.show_total_case').show();
        $('#startTourBtn').show();
        $('#task_reload_icon').show();
        $('.breadcrumb_fixed').show();
        $('.slide_rht_con').show();
        $('#topactions').show();
        $('.kanban_section').html('');
        $('#caseViewSpan').show();
        $('#filtered_items').show();
        $('#task_filter').show();
        $('#task_impExp').show();
        $('#task_list_bar').show();
        $('#caseViewSpanUnclick').show();
        $('#task_paginate').show('');
        $('.breadcrumb_div').show();
        $("#widgethideshow").show();
        $('#select_view').show();
        $('#milestonelist').html('');
        $('.filter_det').show();
        $('#milestoneUid').val('');
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
        if ($('#projFil').val() == 'all') {
            $('#mvTaskToProj').hide();
        } else {
            $('#mvTaskToProj').show();
        }
        $('#timelog_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#select_view div').removeClass('disable');
        if ($('#lviewtype').val() == 'compact') {
            $('.tsk_tbl').addClass('compactview_tbl');
            $('#topaction').addClass('compactview_action');
            $('#cview_btn').addClass('disable');
        } else {
            $('.tsk_tbl').removeClass('compactview_tbl');
            $('#topaction').removeClass('compactview_action');
            $('#lview_btn').addClass('disable');
        }
        if ($('#lviewtype').val().trim() == 'compact') {
            $('.tasksortby-div').hide();
            $('#sortby_items').hide();
            $('.taskgroupby-div').hide();
            $('#groupby_items').hide();
        } else {
            $('.tasksortby-div').show();
            $('#sortby_items').show();
            $('.taskgroupby-div').show();
            $('#groupby_items').show();
        }
        $('.case-filter-menu').removeClass('kanbanview-filter');
        if ($('#inline_milestone').length) {
            $('#top_tsk_list_dv').addClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '102.5%');
        } else {
            $('#top_tsk_list_dv').removeClass('top_tsk_list');
            $('#top_tsk_list_tab').css('width', '100%');
        }
    }
    $('#detail_section .task_detail').hide();
    $('.crttask_overlay').hide();
    $(".crt_tsk").hide();
    $(".slide_rht_con").animate({
        marginLeft: "0px"
    }, "fast");
    $(".crt_slide").css({
        display: "none"
    });
}
}
easycase.showFiles = function(type) {
    var theme_classes_obj = thclasses();
    var cstm_clr_class = theme_classes_obj.cstm_clr_class;
    var cstm_smenu_text_class = theme_classes_obj.cstm_smenu_text_class;
    easycase.routerHideShow(type);
    $("#caseMenuFilters").val('files');
    $(".side-nav li").removeClass('active');
    $(".menu-files").addClass('active');
    $("#brdcrmb-cse-hdr").html(_('Files'));
    $('#caseMenuFilters').val('files');
    if (!(localStorage.getItem("theme_setting") === null)) {
        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
        $(".side-nav li").each(function() {
            $(this).removeClass(th_class_str);
        });
        $('.miscellaneous_li').addClass(th_set_obj.sidebar_color + " gradient-shadow");
    }
    $(".left-palen-submenu-items li > a,.left-palen-submenu-items li > a,.smenu_miscl_whit li.active_bk > a").removeClass(th_text_class_str);
    $('a.menu-files').addClass(cstm_smenu_text_class);
    var strURL = HTTP_ROOT + "easycases/";
    $('#caseLoader').show();
    var projFil = $('#projFil').val();
    var projIsChange = $('#projIsChange').val();
    displayMenuProjects('dashboard', '6', 'files');
    var fileUrl = strURL + "case_files";
    $.post(fileUrl, {
        "projFil": projFil,
        "projIsChange": projIsChange,
        "casePage": casePage,
        "file_srch": search_key
    }, function(res) {
        if (res) {
            $('#caseLoader').hide();
            $("#caseFileDv").show();
            var params = parseUrlHash(urlHash);
            if (params[0] != "files") {
                parent.location.hash = "files";
            }
            $('#caseFileDv').find('#files_content_block').html(tmpl("case_files_tmpl", res));
            bindPrettyview("prettyImage");
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            $.material.init();
            notShowEmptyDropdown();
        }
        loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
            "projUniq": projFil,
            "pageload": 0,
            "page": "dashboard"
        })
    });
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
}

function getGlobalFilters(type) {
    var defltFilterArr = {
        CUSTOM_STATUS: 'all'
    };
    if (type) {
        return (typeof localStorage[type] != 'undefined') ? localStorage[type] : defltFilterArr[type];
    }
}

function getkanbanCounts() {
    var params = parseUrlHash(urlHash);
    var milestone_uid = $('#milestoneUid').val();
    if (params[1]) {
        milestone_uid = params[1];
        $('#milestoneUid').val(params[1]);
        if (($('#caseMenuFilters').val() == 'milestone') || ($('#caseMenuFilters').val() == 'milestonelist'))
            $('#refMilestone').val($('#caseMenuFilters').val());
    }
    if ($('#caseMenuFilters').val() == 'kanban_only') {
        milestone_uid = '';
    }
    var projFil = $('#projFil').val();
    var projIsChange = $('#projIsChange').val();
    var customfilter = $('#customFIlterId').value;
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseTaskgroup = $('#caseTaskgroup').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseSearch = $("#case_search").val();
    if ((caseSearch != null) && (caseSearch.trim() == '')) {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var case_srch = $('#case_srch').val();
    var caseId = document.getElementById('caseId').value;
    var kanban_config = {
        "projFil": projFil,
        "projIsChange": projIsChange,
        "casePage": 0,
        'caseStatus': caseStatus,
        'caseCustomStatus': caseCustomStatus,
        'customfilter': customfilter,
        'caseTypes': caseTypes,
        'caseLabel': caseLabel,
        'priFil': priFil,
        'caseMember': caseMember,
        'caseComment': caseComment,
        'caseAssignTo': caseAssignTo,
        'caseSearch': caseSearch,
        'case_srch': case_srch,
        'case_date': case_date,
        'case_due_date': case_due_date,
        'morecontent': '',
        'newTask_limit': '',
        'inProgressTask_limit': '',
        'resolvedTask_limit': '',
        'closedTask_limit': '',
        'milestoneUid': milestone_uid,
        'search_key': '',
        'getcount': 1,
        'caseTaskgroup': caseTaskgroup
    };
    var strURL = HTTP_ROOT + "easycases/";
    var fileUrl = strURL + "kanban_task";
    $.post(fileUrl, kanban_config, function(res) {
        $('div[id^="cnter_kanban_board_"]').html(0);
        for (var k in res.allTask) {
            $('#cnter_kanban_board_' + res.allTask[k][0].custom_legend).html(res.allTask[k][0].cnt);
            $('#kanban_board_' + res.allTask[k][0].custom_legend).find('.kanban_total_page_count').val(res.allTask[k][0].total_page);
        }
    }, 'json');
}
easycase.showKanbanTaskList = function(type, search_key) {
    if ($('#projFil').val() == 'all') {
        showTopErrSucc('error', _('You are viewing') + " " + _('All') + " " + _('project. Please choose a project first.'));
        window.location.href = HTTP_ROOT + 'dashboard';
    }
    var theme_classes_obj = thclasses();
    var cstm_clr_class = theme_classes_obj.cstm_clr_class;
    var cstm_smenu_text_class = theme_classes_obj.cstm_smenu_text_class;
    if (!(localStorage.getItem("theme_setting") === null)) {
        var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
        $(".side-nav li").each(function() {
            $(this).removeClass(th_class_str);
        });
        $('.miscellaneous_li').addClass(th_set_obj.sidebar_color + " gradient-shadow");
    }
    $('a.menu-milestone').addClass(cstm_smenu_text_class);
    var params = parseUrlHash(urlHash);
    var milestone_uid = $('#milestoneUid').val();
    if (params[1]) {
        milestone_uid = params[1];
        $('#milestoneUid').val(params[1]);
        if (($('#caseMenuFilters').val() == 'milestone') || ($('#caseMenuFilters').val() == 'milestonelist'))
            $('#refMilestone').val($('#caseMenuFilters').val());
    }
    if ($('#caseMenuFilters').val() == 'kanban_only') {
        milestone_uid = '';
    }
    var globalkanbantimeout = null;
    var morecontent = '';
    var newTask_limit = 0;
    var inProgressTask_limit = 0;
    var resolvedTask_limit = 0;
    var closedTask_limit = 0;
    if (typeof(type) != 'undefined' && type != 'kanban') {
        morecontent = type;
        newTask_limit = $('#newTask_limit').val();
        inProgressTask_limit = $('#inProgressTask_limit').val();
        resolvedTask_limit = $('#resolvedTask_limit').val();
        closedTask_limit = $('#closedTask_limit').val();
        if (morecontent == 'newTask' && (parseInt($('#cnter_newTask').text()) <= parseInt(newTask_limit))) {
            if (!arguments[2]) {
                return;
            }
        } else if (morecontent == 'inprogressTask' && (parseInt($('#cnter_inprogressTask').text()) <= parseInt(inProgressTask_limit))) {
            return;
        } else if (morecontent == 'resolvedTask' && (parseInt($('#cnter_resolvedTask').text()) <= parseInt(resolvedTask_limit))) {
            return;
        } else if (morecontent == 'closedTask' && (parseInt($('#cnter_closedTask').text()) <= parseInt(closedTask_limit))) {
            return;
        }
    } else {
        if (arguments[2] && arguments[2] != 'stop_cls') {
            crt_popup_close();
        }
        $('#select_view div').removeClass('disable');
        $('#kbview_btn').addClass('disable');
        easycase.routerHideShow('kanban');
        if (params[2] !== undefined) {
            $("#caseMenuFilters").val('kanbanTask');
        } else if ((params[0] == 'kanban' && !params[1]) || $('#caseMenuFilters').val() == 'kanban_only') {
            $('#caseMenuFilters').val('kanban_only');
        } else {
            $("#caseMenuFilters").val('kanban');
        }
        $(".side-nav li").removeClass('active');
        $(".menu-milestone").addClass('active');
        if (!(localStorage.getItem("theme_setting") === null)) {
            var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
            $(".side-nav li").each(function() {
                $(this).removeClass(th_class_str);
            });
            $('.menu-milestone').addClass(th_set_obj.sidebar_color + " gradient-shadow");
        }
        $("#brdcrmb-cse-hdr").html('Tasks');
    }
    var kanbanPage = 0;
    var strURL = HTTP_ROOT + "easycases/";
    if (morecontent) {
        $('#caseLoader').show();
        $('#' + morecontent).find('.kb_task_det.last_title').hide();
        kanbanPage = $('#kanban_board_' + type).find('.kanban_page_count').val();
    } else {
        $('#caseLoader').show();
    }
    var projFil = $('#projFil').val();
    var projIsChange = $('#projIsChange').val();
    var customfilter = $('#customFIlterId').value;
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseTaskgroup = $('#caseTaskgroup').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseSearch = $("#case_search").val();
    if ((caseSearch != null) && (caseSearch.trim() == '')) {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    $("#case_search").val("");
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var case_srch = $('#case_srch').val();
    var caseId = document.getElementById('caseId').value;
    $("#show_milestonelist").html('');
    var fileUrl = strURL + "kanban_task";
    var kanban_config = {
        "projFil": projFil,
        "projIsChange": projIsChange,
        "casePage": kanbanPage,
        'caseStatus': caseStatus,
        'caseCustomStatus': caseCustomStatus,
        'customfilter': customfilter,
        'caseTypes': caseTypes,
        'caseLabel': caseLabel,
        'priFil': priFil,
        'caseMember': caseMember,
        'caseComment': caseComment,
        'caseAssignTo': caseAssignTo,
        'caseSearch': caseSearch,
        'case_srch': case_srch,
        'case_date': case_date,
        'case_due_date': case_due_date,
        'morecontent': morecontent,
        'newTask_limit': newTask_limit,
        'inProgressTask_limit': inProgressTask_limit,
        'resolvedTask_limit': resolvedTask_limit,
        'closedTask_limit': closedTask_limit,
        'milestoneUid': milestone_uid,
        'search_key': search_key,
        'caseTaskgroup': caseTaskgroup
    };
    $.post(fileUrl, kanban_config, function(res) {
        $('body').css('overflow-y', 'hidden');
        if (res) {
            var th_set_obj = '';
            if (!(localStorage.getItem("theme_setting") === null)) {
                var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                $(".side-nav li").each(function() {
                    $(this).removeClass(th_class_str);
                });
            }
            if ($('.menu-milestone').length) {
                $('.menu-milestone').addClass(th_set_obj.sidebar_color + " gradient-shadow active");
            } else {
                $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow active");
            }
            $('.kanban_active_task').html(res.act_milstone);
            refreshKanbanTask = 0;
            $('#detail_section').html('');
            if (morecontent) {
                $('#caseLoader').hide();
                $('#' + morecontent).find('.kb_task_det.last_title').show();
            } else {
                $('#milestoneId').val(res.mlstId);
                $('#caseLoader').hide();
            }
            $("#kanban_list").show();
            var params = parseUrlHash(urlHash);
            if (params[0] != "kanban") {
                parent.location.hash = "kanban";
            }
            var result = document.getElementById('kanban_list');
            if (morecontent) {
                $('#kanban_board_' + morecontent).find('.kanban_page_count').val(parseInt(kanbanPage) + 1);
                $('#newTask_limit').val(res.newTask_limit);
                $('#inProgressTask_limit').val(res.inProgressTask_limit);
                $('#resolvedTask_limit').val(res.resolvedTask_limit);
                $('#closedTask_limit').val(res.closedTask_limit);
                $('#kanban_board_' + morecontent).find('.kanban_content .kbtask_div:last').after(tmpl("kanban_task_tmpl", res));
            } else {
                result.innerHTML = tmpl("kanban_task_tmpl", res);
                var kanbanorboard = (res.project_methodology_id > 3) ? _('Board') : _("Kanban");
                $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE8F0;</i> ' + kanbanorboard + '</a>');
                showHideTopNav(1);
            }
            getkanbanCounts();
            indx = 0;
            if (bxslid1) {
                bxslid1.destroySlider();
            }
            var window_kanban_slider = $('#kanban_list').width() - 100;
            if (window_kanban_slider < 1300) {
                var dp_width = Math.round(window_kanban_slider / 4);
                var bxslid1 = $('.kanban_top_slider .bxslider1').bxSlider({
                    slideWidth: dp_width,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 4,
                    pager: false,
                    slideMargin: 10,
                    infiniteLoop: false,
                    auto: false,
                });
                if (res.mlstId) {
                    indx = $(".bxslider1").find('.knban_prog_box.active').index();
                    indx = Math.floor(indx / 4);
                }
            } else {
                var dp_width = Math.round(window_kanban_slider / 5);
                var bxslid1 = $('.kanban_top_slider .bxslider1').bxSlider({
                    slideWidth: dp_width,
                    minSlides: 5,
                    maxSlides: 5,
                    moveSlides: 5,
                    pager: false,
                    slideMargin: 10,
                    infiniteLoop: false,
                    auto: false,
                });
                if (res.mlstId) {
                    indx = $(".bxslider1").find('.knban_prog_box.active').index();
                    indx = Math.floor(indx / 5);
                }
            }
            if (bxslid1 !== null && res.mlstId) {
                bxslid1.goToSlide(indx);
            }
            $.material.init();
            $('.kb_task_det').find('h6').find('span.rt_icn').find('ul li').on('click', function(e) {
                e.stopPropagation();
            });
            $('.kb_task_det h6 span.dropdown').on('mouseenter', function() {
                $(this).find('a.main_page_menu_togl').attr('aria-expanded', true);
                $(this).addClass('open');
            });
            $('.kb_task_det').on('mouseleave', function() {
                $(this).find('h6 span.dropdown .dropdown-toggle').attr('aria-expanded', false);
                $(this).find('h6 span.dropdown').removeClass('open');
            });
            var div_width = ($('#kanban_list').find('.kanban-child').width() + parseInt($('#kanban_list').find('.kanban-child').css('padding-left')));
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
            $("a[rel^='prettyPhoto']").prettyPhoto({
                animation_speed: 'normal',
                autoplay_slideshow: false,
                social_tools: false,
                overlay_gallery: false,
                deeplinking: false
            });
            var settings = {
                autoReinitialise: true
            };
            if (!morecontent) {}
            var sortflag = false;
            if (isAllowed('Change Status of Task')) {
                $(".kanban_content").sortable({
                    cursor: 'grabbing',
                    connectWith: '.kanban_content',
                    scroll: true,
                    scrollSensitivity: 100,
                    placeholder: "ui-state-highlight",
                    start: function(event, ui) {
                        $(ui.item).find('span.dropdown .dropdown-toggle').attr('aria-expanded', false);
                        $(ui.item).find('span.dropdown').removeClass('open');
                        sortflag = true;
                    },
                    sort: function(event, ui) {
                        if (($(window).width() - event.clientX) < 150) {
                            $('.kanban-auto-scroll').scrollLeft($('.kanban-auto-scroll').scrollLeft() + 30);
                        }
                        if (event.clientX < 250) {
                            $('.kanban-auto-scroll').scrollLeft($('.kanban-auto-scroll').scrollLeft() - 30);
                        }
                    },
                    stop: function(event, ui) {
                        var projFil = $('#projFil').val();
                        var task_ids = [];
                        var ext_sts_id = $(event.target).parent().parent().attr('id');
                        var curr_sts_id = $(ui.item).parent().parent().parent().attr('id');
                        var old_sts = getStatusNumber(ext_sts_id);
                        var new_sts = getStatusNumber(curr_sts_id);
                        var task_uniq_id = $(ui.item).find('h6[id^="titlehtml"]').attr('data-task');
                        if (new_sts == 0) {
                            showTopErrSucc('error', _("Please drop into a valid Status"));
                        } else if (old_sts == new_sts) {
                            if (projFil.toLowerCase() != 'all') {
                                var task_ids_all = [];
                                $('#' + ext_sts_id).find('.kb_task_det').each(function(index) {
                                    task_ids_all.push($(this).attr('data-task-id'));
                                });
                                var prev_tsk_id = $(ui.item).prev().attr('data-task-id');
                                var next_tsk_id = $(ui.item).next().attr('data-task-id');
                                var cur_proj_id = $(ui.item).attr('data-proj-id');
                                if (typeof prev_tsk_id != 'undefined') {
                                    task_ids[0] = prev_tsk_id;
                                }
                                task_ids[1] = task_uniq_id;
                                if (typeof next_tsk_id != 'undefined') {
                                    task_ids[2] = next_tsk_id;
                                }
                                $.post(HTTP_ROOT + 'easycases/ajax_change_sequence', {
                                    'caseId': '0',
                                    'taskuids': task_ids,
                                    'taskuids_All': task_ids_all,
                                    'proj_id': cur_proj_id
                                }, function(res) {
                                    if (res.success == 'fail') {
                                        showTopErrSucc('error', res.message);
                                    }
                                }, 'json');
                            } else {
                                showTopErrSucc('error', _('Task reordering is possible within a single project. You are seeing all project'));
                                return false;
                            }
                        } else {
                            if (projFil.toLowerCase() != 'all') {
                                var task_ids_all = [];
                                $('#' + curr_sts_id).find('.kb_task_det').each(function(index) {
                                    task_ids_all.push($(this).attr('data-task-id'));
                                });
                                $('#caseLoader').show();
                                $(ui.item).css('pointer-events', 'none');
                                $.post(HTTP_ROOT + 'easycases/ajax_change_legend', {
                                    'caseId': '0',
                                    'taskuid': task_uniq_id,
                                    'legend': new_sts,
                                    'taskuids_All': task_ids_all
                                }, function(res) {
                                    tasklisttmplAdd(res.caseId, 0, 'sts');
                                    if (res.haschield) {
                                        easycase.showKanbanTaskList('kanban');
                                        }
                                    getkanbanCounts();
                                    setTimeout(function() {
                                        $('#caseLoader').hide();
                                        $(ui.item).css('pointer-events', '');
                                    }, 1000);
                                    if (res.success == 'fail') {
                                        showTopErrSucc('error', res.message);
                                    } else {
                                        if (res.isAssignedUserFree != 1) {
                                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                                        }
                                        showTopErrSucc('success', _('Task moved successfully.'));
                                    }
                                }, 'json');
                            } else {
                                showTopErrSucc('error', _('Task status change is possible within a single project. You are seeing all project'));
                                return false;
                            }
                        }
                    },
                    update: function(ev, ui) {},
                    beforeStop: function(ev, ui) {
                        var ext_sts_id = $(ev.target).parent().parent().attr('id');
                        var curr_sts_id = $(ui.item).parent().parent().parent().attr('id');
                        var old_sts = getStatusNumber(ext_sts_id);
                        var new_sts = getStatusNumber(curr_sts_id);
                        if (new_sts == 3) {
                            if (!isAllowed("Status change except Close")) {
                                showTopErrSucc('error', _('You are not authorized to close task'));
                                $(this).sortable('cancel');
                            }
                        }
                    }
                }).disableSelection();
            }
            $("div [id^='set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    startDate: new Date(),
                    todayHighlight: true,
                    format: 'mm/dd/yyyy',
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    var caseId = $(this).attr('data-csatid');
                    var datelod = "datelod" + caseId;
                    var showUpdDueDate = "showUpdDueDate" + caseId;
                    var old_duetxt = $("#" + showUpdDueDate).html();
                    $("#" + showUpdDueDate).html("");
                    $("#" + datelod).show();
                    var text = '';
                    var dateText = $(this).datepicker('getFormattedDate');
                    $(this).val('');
                    commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, 'NA');

                });
            });
            var clearCaseSearch = $('#clearCaseSearch').val();
            $('#clearCaseSearch').val("");
            if (!milestone_uid) {
                resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 0, case_date, case_due_date, casePage, caseSearch, clearCaseSearch, 'kanban', '', caseLabel, caseTaskgroup);
                $('#caseKanbanDv').hide();
                $('#filter_det').show();
            }
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            if (!morecontent) {}
        }
        $('.kanban_content').on('scroll', function() {
            if (Math.round($(this).scrollTop()) + Math.round($(this).innerHeight()) >= (parseInt($(this)[0].scrollHeight) - 1)) {
                var kanban_statusID = $(this).closest('.kanban-child').attr('id').replace('kanban_board_', '');
                var kanban_page = $('#kanban_board_' + kanban_statusID).find('.kanban_page_count').val();
                var kanban_total_page = $('#kanban_board_' + kanban_statusID).find('.kanban_total_page_count').val();
                if (kanban_page < kanban_total_page) {
                    easycase.showKanbanTaskList(kanban_statusID, '', '', kanban_page);
                }
            }
        });
        if (projIsChange != projFil) {
            loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                "projUniq": projFil,
                "pageload": 0,
                "page": "dashboard"
            })
        }
    });
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
}

function ajaxFilePage(page) {
    casePage = page;
    easycase.showFiles('files');
}

function archiveFile(obj) {
    var id = $(obj).attr("data-id");
    var name = $(obj).attr("data-name");
    var conf = confirm(_("Are you sure you want to archive the file") + " '" + name + "' ?");
    var hashtag = parseUrlHash(urlHash);
    if (conf == false) {
        return false;
    } else {
        var curRow = "curRow" + id;
        $("#" + curRow).fadeOut(500);
        var strurl = HTTP_ROOT + "easycases/archive_file";
        $.post(strurl, {
            "id": id
        }, function(data) {
            if (data) {
                showTopErrSucc('success', _("File") + " '" + name + "' " + _("is archived."));
                if (typeof hashtag != 'undefined' && hashtag != 'overview') {
                    easycase.showFiles('files');
                }
            }
        });
    }
}

function downloadImage(obj) {
    window.location.href = $(obj).attr('data-url');
}

function downloadTask(csUid, caseNum) {
    var url = HTTP_ROOT + "easycases/taskDownload";
    var left = (screen.width / 2) - (500 / 2);
    var top = (screen.height / 2) - (500 / 2);
    var w = window.open('', 'Download Task #' + caseNum, 'width=500,height=500,top=' + top + ',left=' + left);
    $(w.document.body).html('<div class="loader_dv" style="font-family:\'HelveticaNeue-Roman\',\'HelveticaNeue\',\'Helvetica Neue\',\'Helvetica\',\'Arial\',\'sans-serif\';font-size:17px;"><center><img src="' + HTTP_IMAGES + 'images/case_loader2.gif" alt="Loading..." title="Loading..." /><br>Please wait we are preparing your download...</center></div>');
    $.post(url, {
        'caseUid': csUid
    }, function(res) {
        if (res) {
            $(w.document.body).html(res);
            $(w.document.getElementById('sendemailtouser_btn')).click(function() {
                sendDownloadTaskMail(w);
            });
            $(w.document.getElementById('download_task_link')).click(function() {
                var hrefattr = w.document.getElementById('download_task_link').getAttribute('href');
                w.close();
                window.open(hrefattr, '_blank');
            });
        } else {
            alert(_('Error in downloading task'));
        }
    });
}

function edited_priority(case_id, obj) {
    $('#CS_priority' + case_id).val($(obj).find('input:radio').val());
}

function actiononTask(taskid, taskUid, taskNum, actiontype, legend) {
    var is_parnt = (typeof arguments[5] != 'undefined' && arguments[5] != '') ? 1 : 0;
    var is_sub = (typeof arguments[6] != 'undefined' && arguments[6] != '') ? 1 : 0;
    $.post(HTTP_ROOT + 'easycases/taskactions', {
        'taskId': taskid,
        'taskUid': taskUid,
        'type': actiontype,
        'legend': legend
    }, function(res) {
        if (res) {
            if (client && typeof res.iotoserver != 'undefined') {
                client.emit('iotoserver', res.iotoserver);
            }
            if (res.time_balance_Remaining) {
                $('.time_balance_value').html(res.time_balance_Remaining);
            }
            var hashtag = parseUrlHash(urlHash);
            if (res.succ) {
                $('#caseId').val("");
                if (actiontype == 'tasktype' || actiontype == 'duedate' || actiontype == 'priority' || actiontype == 'assignto' || actiontype == 'story_point' || actiontype == 'esthour' || actiontype == 'cmpltsk' || actiontype == 'titleChange' || actiontype == 'removeFile') {
                    if (actiontype != 'removeFile') {
                        showTopErrSucc('success', _('Task') + ' #' + taskNum + ' ' + _('updated.'));
                    }
                } else {
                    if (hashtag[0] == 'tasks') {
                        $('#curRow' + taskid).find('span.label').removeClass('wip closed resolved label-danger label-warning label-success label-info fade-red fade-green fade-blue fade-orange');
                    }
                    if (legend == 'popup') {
                        easycase.ajaxCaseDetails(taskUid, 'case', 0, 'popup', 'action');
                    }
                    if (actiontype.toLowerCase() != 'close') {
                        $('.subtask_holder_div').show();
                    } else {
                        $('.subtask_holder_div').hide();
                    }
                    if (actiontype.toLowerCase() == 'close') {
                        if (isTimerRunning(taskid)) {
                            exitTimerPopup();
                        }
                        actiontype = 'clos';
                        if (hashtag[0] == 'tasks') {
                            $('#curRow' + taskid).find('span.label').addClass('closed label-success fade-green').text(_('Closed'));
                        } else if (hashtag[0] == 'details') {
                            $('#curRow' + taskid).find('span.label').addClass('closed label-success fade-green').text(_('Closed'));
                        }
                        $('#caseId').val('');
                    }
                    if (actiontype.toLowerCase() == 'resolve') {
                        actiontype = 'resolv';
                        if (isTimerRunning(taskid)) {
                            exitTimerPopup();
                        }
                        if (hashtag[0] == 'tasks') {
                            $('#curRow' + taskid).find('span.label').addClass('resolved label-warning fade-orange').text(_('Resolved'));
                        } else if (hashtag[0] == 'details') {
                            $('#curRow' + taskid).find('span.label').addClass('resolved label-warning fade-orange').text(_('Resolved'));
                        }
                        $('#caseResolve').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        } else if (hashtag[0] == 'details' && is_sub == '0') {
                            easycase.ajaxCaseDetails(taskUid, 'case', 0, 'popup', 'action');
                        }
                    }
                    if (actiontype.toLowerCase() == 'start') {
                        if (hashtag[0] == 'tasks') {
                            $('#curRow' + taskid).find('span.label').addClass('wip label-info fade-blue').text(_('In Progress'));
                        } else if (hashtag[0] == 'details') {
                            $('#curRow' + taskid).find('span.label').addClass('wip label-info fade-blue').text(_('In Progress'));
                        }
                        $('#caseStart').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        } else if (hashtag[0] == 'details' && is_sub == '0') {
                            easycase.ajaxCaseDetails(taskUid, 'case', 0, 'popup', 'action');
                        }
                    }
                    if (actiontype.toLowerCase() == 'new') {
                        if (hashtag[0] == 'tasks' || hashtag[0] == 'taskgroup') {
                            $('#curRow' + taskid).find('span.label').addClass('wip label-info fade-blue').text(_('New'));
                        } else if (hashtag[0] == 'details') {
                            $('#curRow' + taskid).find('span.label').addClass('wip label-info fade-blue').text(_('New'));
                        }
                        $('#caseNew').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        } else if (hashtag[0] == 'details' && is_sub == '0') {
                            easycase.ajaxCaseDetails(taskUid, 'case', 0, 'popup', 'action');
                        }
                    }
                    if (is_sub || (actiontype.toLowerCase() == 'clos' && hashtag[0] == 'details')) {
                        if (res.parent_id != '' && is_sub) {
                            loadSubtaskInDetail(res.parent_id);
                            if ($('#tab-taskLink').hasClass('active')) {
                                $('#tab-taskLink').trigger('click');
                            }
                        } else if ((actiontype.toLowerCase() == 'clos' && hashtag[0] == 'details')) {
                            loadSubtaskInDetail(taskid);
                            if ($('#tab-taskLink').hasClass('active')) {
                                $('#tab-taskLink').trigger('click');
                            }
                        }
                    } else if (parseInt($("#subtask-container").height()) > 70) {
                        ajaxCaseSubtaskView();
                    } else if (hashtag[0] == 'details' || legend == 'popup') {
                        appendReplyThread(res.data.curCaseId, taskid);
                    } else if (hashtag[0] == 'tasks' || hashtag[0] == 'taskgroup') {
                        if (!parseInt(is_parnt) && typeof res.checkParentids == 'undefined') {
                            tasklisttmplAdd(res.data.caseStsId);
                        } else {
                            if (typeof res.checkParentids != 'undefined') {
                                var rel_arr_prnt = $.map(res.checkParentids, function(el) {
                                    return el;
                                });
                                for (var i = 0; i < rel_arr_prnt.length; i++) {
                                    tasklisttmplAdd(rel_arr_prnt[i]);
                                }
                            }
                        }
                    }
                    if (actiontype.toLowerCase() == 'new') {
                        showTopErrSucc('success', _('Status of task #') + taskNum + ' ' + _('changed to') + ' ' + actiontype + '.');
                    } else {
                        showTopErrSucc('success', _('Task') + ' #' + taskNum + ' ' + actiontype + 'ed.');
                    }
                }
                $.post(HTTP_ROOT + "easycases/ajaxemail", {
                    'json_data': res.data,
                    'type': 1
                });
            } else if (res.err) {
                if (res.msg) {
                    showTopErrSucc('error', res.msg);
                    $('#caseId').val('');
                    $('#caseStart').val('');
                    $('#caseResolve').val('');
                    return false;
                }
                if (actiontype != 'removeFile' && hashtag[0] != 'tasks') {
                    showTopErrSucc('error', _('Error in task') + ' ' + actiontype);
                }
            }
            if ((getCookie('TASKGROUPBY') == 'milestone')) {}
            if (hashtag[0] == 'tasks') {} else if (hashtag[0] == 'taskgroup') {} else if (hashtag[0] == 'details') {} else if (hashtag[0] == 'timesheet_weekly') {} else if ($('#caseMenuFilters').val() == 'milestonelist') {
                showMilestoneList();
            } else if (hashtag[0] == 'taskgroups') {
                showTaskByTaskGroupNew();
            } else {
                if (PAGE_NAME == "resource_availability") {} else {
                statusid = '1';
                if (actiontype.toLowerCase() == 'clos') {
                    statusid = 3;
                } else if (actiontype.toLowerCase() == 'resolv') {
                    statusid = 5;
                } else if (actiontype.toLowerCase() == 'start') {
                    statusid = 2;
                }
                $(".item-" + taskid).appendTo($("#kanban_board_" + statusid).find('.kanban_content'));
                getkanbanCounts();
                tasklisttmplAdd(taskid, 0, 'sts');
            }
        }
        }
    }, 'json');
}

function moveTask(taskid, taskno, mlstid, project_id) {
    var type = 'one';
    if (taskid == 'all') {
        if ($('.mass_act_sprint').hasClass('disabel_spnt')) {
            return false;
        }
        type = 'all';
        var ismul = 0;
        if ($('#multi-move-sprnt').length && $.trim($('#multi-move-sprnt').val()) != '') {
            ismul = 1;
        }
        if (ismul && !confirm(_("All subtasks belonging to the parent task(s) will be moved, are you sure you want to continue?"))) {
            return false;
        }
        taskid = new Array();
        $('input[id^="actChkBklog"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                taskid.push($(this).val());
            }
        });
    }
    openPopup();
    $(".movetaskTomlst").show();
    $('#mvtask_mlst').html('');
    $('.add-mlstn-btn').hide();
    $('#tsksrch').hide();
    $("#mvtask_loader").show();
    $("#mvtask_movebtn").css({
        'cursor': 'pointer'
    });
    $.post(HTTP_ROOT + "milestones/moveTaskMilestone", {
        'taskid': taskid,
        'project_id': project_id,
        'mlstid': mlstid,
        'task_no': taskno,
        'type': type
    }, function(res) {
        if (res) {
            $('#mvtask_mlst').html(res);
            $("#mvtask_loader").hide();
            $('#mvtask_mlst').show();
            $('.add-mlstn-btn').show();
            $('#tskloader').hide();
            $('#tsksrch').show();
            $("#mvtask_prj_ttl").html($("#mvtask_proj_name").val());
            if ($('#mvtask_cnt').val() == 0) {
                $("#mvtask_movebtn").attr({
                    'disabled': 'disabled'
                });
            }
            $.material.init();
            $(".select").dropdown();
        }
    });
}

function removeTask(taskid, taskno, mlstid, project_id) {
    var conf = confirm(_("Are you sure you want to remove #") + taskno + " " + _("task from it's corresponding task group"));
    if (conf) {
        $.post(HTTP_ROOT + "milestones/removeTaskMilestone", {
            'taskid': taskid,
            'project_id': project_id,
            'mlstid': mlstid,
            'task_no': taskno
        }, function(res) {
            if (res) {
                if ($('#caseMenuFilters').val() == 'milestonelist') {
                    refreshMilestone = 1;
                    showMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    refreshKanbanTask = 1;
                    easycase.showKanbanTaskList();
                } else if ($('#caseMenuFilters').val() == '') {
                    refreshTasks = 1;
                    easycase.refreshTaskList();
                }
            }
        });
    }
}

function switchTaskToMilestone(obj) {
    var params = parseUrlHash(urlHash);
    var spsts = 0;
    if ($('#mvtask_cnt').val() > 0) {
        var curr_mlst_id = '';
        var ext_mlst_id = $('#ext_mlst_id').val();
        var task_id = $('#mvtask_id').val();
        var task_no = $('#mvtask_task_no').val();
        var project_id = $('#mvtask_project_id').val();
        $('.radio_cur').each(function(i) {
            if ($(this).is(':checked')) {
                curr_mlst_id = $(this).val();
                spsts = parseInt($(this).attr('data-sprint-status'));
            }
        });
        if (curr_mlst_id.trim() == '') {
            if (params[0] == 'backlog') {
                showTopErrSucc('error', _("Please select a Sprint"));
            } else {
                showTopErrSucc('error', _("Please select a Task Group"));
            }
        } else if (ext_mlst_id == curr_mlst_id) {
            if (params[0] == 'backlog') {
                showTopErrSucc('error', 'Oops! #' + task_no + " " + _("is already in selected Sprint"));
            } else {
                showTopErrSucc('error', 'Oops! #' + task_no + " " + _("is already in selected Task Group"));
            }
        } else {
            if (1) {
                if (params[0] == 'backlog') {
                    if (spsts) {
                        if (!confirm(_('The scope of the sprint will be changed, do you still want to proceed?'))) {
                            return false;
                        }
                    }
                }
                $.post(HTTP_ROOT + 'milestones/switchTaskToMilestone', {
                    'taskid': task_id,
                    'curr_mlst_id': curr_mlst_id,
                    'project_id': project_id,
                    'ext_mlst_id': ext_mlst_id
                }, function(res) {
                    if (res.status == 'success') {
                        var log_msg = _('Task') + ' #' + task_no + " " + _("moved successfully.");
                        if (task_no == 'all') {
                            log_msg = _('All task moved successfully.');
                        }
                        showTopErrSucc('success', log_msg);
                        if ($('#caseMenuFilters').val() == 'kanban_only') {
                            refreshKanbanTask = 1;
                            easycase.showKanbanTaskList();
                        }
                    } else {
                        if (params[0] == 'backlog') {
                            showTopErrSucc('error', _('Error in moving task to sprint') + '.');
                        } else {
                            showTopErrSucc('error', _('Error in moving task to task group.'));
                        }
                    }
                }, 'json');
                closePopup();
                var checkType = $('#caseMenuFilters').val();
                var params = parseUrlHash(urlHash);
                if (params[0] == 'backlog') {
                    var ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS')) : [];
                    if ($.inArray(curr_mlst_id, ids_array) == -1) {
                        ids_array.push(curr_mlst_id);
                        createCookie("PREOPENED_TASK_GROUP_IDS", JSON.stringify(ids_array), 365, DOMAIN_COOKIE);
                    }
                    easycase.showbacklog();
                } else if (params[0] == 'taskgroups') {
                    var ids_arrays = typeof getCookie('PREOPENED_TASK_GROUP_IDS_THREAD') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS_THREAD')) : [];
                    if ($.inArray(curr_mlst_id, ids_arrays) == -1) {
                        ids_arrays.push(curr_mlst_id);
                        createCookie("PREOPENED_TASK_GROUP_IDS_THREAD", JSON.stringify(ids_arrays), 365, DOMAIN_COOKIE);
                    }
                    ajaxCaseView('taskgroups');
                } else if (getCookie('TASKGROUPBY') == 'milestone') {
                    createCookie("PREOPENED_TASK_GROUP_ID", ext_mlst_id, 365, DOMAIN_COOKIE);
                    easycase.refreshTaskList();
                } else if (checkType == 'milestonelist') {
                    refreshMilestone = 1;
                    showMilestoneList();
                } else if (checkType == 'kanban') {
                    refreshKanbanTask = 1;
                    easycase.showKanbanTaskList();
                } else if (checkType == '' || checkType == 'kanbantask') {
                    refreshTasks = 1;
                    if (params[0] == 'tasks') {
                        var groupby = getCookie('TASKGROUPBY');
                        if (groupby == 'milestone') {
                            var curRow = "curRow" + task_id;
                            $("#" + curRow).fadeOut(500, function() {
                                var html = $(this).html();
                                var pid = $(this).attr('data-pid');
                                if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + curr_mlst_id).next('tr.white_bg_tr')) {
                                    $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + curr_mlst_id).next('tr.white_bg_tr').after('<tr id="curRow' + task_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + curr_mlst_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                } else {
                                    $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + curr_mlst_id).after('<tr id="curRow' + task_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + curr_mlst_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                }
                                $('tr#curRow' + task_id).find('div.checkbox').find('span.checkbox-material:nth-of-type(2)').remove();
                                $(this).remove();
                            });
                        }
                    } else {
                        easycase.refreshTaskList();
                    }
                }
            } else {
                return false;
            }
        }
    } else {
        showTopErrSucc('error', _('Oops! There is no task group to move the task.'));
    }
}

function editmessage(obj, id, projid) {
    $('#editpopup' + id + ' .icon-edit').addClass('loading');
    var templat_arr = [];
    $.each(TASKTMPL, function(index_tml, value_tml) {
        templat_arr.push({
            "title": value_tml.CaseTemplate.name,
            "description": value_tml.CaseTemplate.description,
            "content": value_tml.CaseTemplate.description
        });
    });
    mention_array['mention_type_id'] = new Array();
    mention_array['mention_type'] = new Array();
    mention_array['mention_id'] = new Array();
    $.post(HTTP_ROOT + "easycases/edit_reply", {
        'id': id,
        'reply_flag': 1,
        projid: projid
    }, function(res) {
        $('#casereplytxt_id_' + id).hide();
        if (tinymce.get('edit_reply_txtbox' + id)) {
            tinymce.get('edit_reply_txtbox' + id).remove();
        }
        $.post(HTTP_ROOT + "easycases/get_reply_mention", {
            'id': id,
            'reply_flag': 1,
            projid: projid
        }, function(ress) {
            if (!check_empty(ress.mention_array)) {
                if (ress.mention_array.mention_type.length > 0) {
                    $.each(ress.mention_array.mention_type, function(index, value) {
                        mention_array['mention_type_id'].push(ress.mention_array.mention_type_id[index]);
                        mention_array['mention_type'].push(ress.mention_array.mention_type[index]);
                        mention_array['mention_id'].push(ress.mention_array.mention_id[index]);
                    });
                }
            }
        }, 'json');
        $('#editpopup' + id + ' .icon-edit').removeClass('loading');
        $('#casereplyid_' + id).html(res);
        var edit_content = $('#replytext_content' + id).html();
        var tiny_mce_url = HTTP_ROOT + 'js/tinymce/tiny_mce.js';
        var dir_tiny = 'ltr';
        if (SES_COMP === '33179' || SHOW_ARABK === '1') {
            dir_tiny = 'rtl';
        }
        if (CMP_ARABK === '23823' || SES_COMP === '19398' || SHOW_ARABK === '1') {
            tinymce.init({
                selector: "#edit_reply_txtbox" + id,
                plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
                menubar: false,
                branding: false,
                statusbar: false,
                toolbar: 'undo redo | bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | template | ltr rtl | fullscreen',
                toolbar_sticky: true,
                importcss_append: true,
                image_caption: true,
                browser_spellcheck: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
                directionality: dir_tiny,
                toolbar_drawer: 'sliding',
                template_popup_height: "200px",
                template_popup_width: "200px",
                templates: templat_arr,
                resize: false,
                min_height: 200,
                max_height: 400,
                paste_data_images: true,
                paste_as_text: true,
                autoresize_on_init: true,
                autoresize_bottom_margin: 20,
                content_css: HTTP_ROOT + 'css/tinymce.css',
                setup: function(ed) {
                    ed.on('Change', function(ed, e) {
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
                        tinymce.get('edit_reply_txtbox' + id).focus();
                        tinymce.get('edit_reply_txtbox' + id).setContent(edit_content);
                    });
                }
            });
        } else {
            tinymce.init({
                selector: "#edit_reply_txtbox" + id,
                plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help mention',
                menubar: false,
                branding: false,
                statusbar: false,
                toolbar: 'undo redo | bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | template | fullscreen',
                toolbar_sticky: true,
                importcss_append: true,
                image_caption: true,
                browser_spellcheck: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
                toolbar_drawer: 'sliding',
                template_popup_height: "200px",
                template_popup_width: "200px",
                templates: templat_arr,
                resize: false,
                min_height: 200,
                max_height: 400,
                paste_data_images: true,
                paste_as_text: true,
                autoresize_on_init: true,
                autoresize_bottom_margin: 20,
                content_css: HTTP_ROOT + 'css/tinymce.css',
                mentions: {
                    source: function(query, process, delimiter) {
                        var proj_uniq_id = $('#projFil').val();
                        var murl = HTTP_ROOT + "requests/getUserTaskList";
                        $.post(murl, {
                            proj_uniq_id: proj_uniq_id,
                            search_query: query
                        }, function(data) {
                            if (data) {
                                process(data);
                                $(".rte-autocomplete").css({
                                    "z-index": "999999 !important"
                                });
                            }
                        }, 'json');
                    },
                    insert: function(item) {
                        mention_array['mention_type_id'].push(item.id);
                        mention_array['mention_type'].push(item.type);
                        if (item.type == "task") {
                            return '<span class="task_mention" data-id="' + item.id + '" data-tskuniqid="' + item.uniq_id + '" style="color: #3598db;">' + item.name + '</span>&nbsp;';
                        } else {
                            return '<span class="user_mention" data-id="' + item.id + '" style="color: #3598db;">@' + item.name + '</span>&nbsp;';
                        }
                    }
                },
                setup: function(ed) {
                    ed.on('Change', function(ed, e) {
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
                    ed.on('KeyUp', function(ed, e) {
                        var inpt = $.trim(tinymce.activeEditor.getContent());
                        var inptLen = inpt.length;
                        var datInKb = 0;
                        var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
                        var key = ed.keyCode || ed.charCode;
                        if (key == 8) {
                            var domclass = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'class');
                            if (domclass == "task_mention") {
                                var tsk_data_id = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'data-id')
                                remove_element(mention_array['mention_type_id'], tsk_data_id);
                                tinymce.activeEditor.dom.remove(tinymce.activeEditor.selection.getNode());
                            } else if (domclass == "user_mention") {
                                var usr_data_id = tinymce.activeEditor.dom.getAttrib(tinymce.activeEditor.selection.getNode(), 'data-id')
                                remove_element(mention_array['mention_type_id'], usr_data_id);
                                tinymce.activeEditor.dom.remove(tinymce.activeEditor.selection.getNode());
                            }
                        }
                    });
                    ed.on('init', function(e) {
                        tinymce.get('edit_reply_txtbox' + id).setContent(edit_content);
                        tinymce.activeEditor.dom.add(tinymce.activeEditor.getBody(), 'p', "", '&nbsp;')
                        tinyMCE.activeEditor.selection.select(tinyMCE.activeEditor.getBody(), true);
                        tinyMCE.activeEditor.selection.collapse(false);
                    });
                }
            });
        }
    });
}

function save_editedvalue_reply(caseno, id, proj_id, repUniqId) {
    var ed = tinymce.get('edit_reply_txtbox' + id);
    var message = ed.getContent();
    ed.selection.select(ed.getBody(), true);
    var message1 = ed.selection.getContent({
        format: 'text'
    });
    message = message.replace(/&nbsp;/gi, '');
    message = $.trim(message);
    if (message == '') {
        showTopErrSucc('error', _("Message cann't be left blank"));
        return;
    }
    $('#edit_btn' + id).hide();
    $('#edit_loader' + id).show();
    $.post(HTTP_ROOT + "easycases/save_editedvalue", {
        'id': id,
        'message': message,
        'caseno': caseno,
        proj_id: proj_id,
        'mention_array': mention_array
    }, function(data) {
        if (data.message == "fail") {
            showTopErrSucc('error', _("Message cann't be left blank"));
            $('#edit_btn' + id).show();
            $('#edit_loader' + id).hide();
            mention_array['mention_type_id'] = new Array();
            mention_array['mention_type'] = new Array();
            mention_array['mention_id'] = new Array();
        } else {
            $('#casereplytxt_id_' + id).show();
            $('#replytext_content' + id).html(message);
            $('#casereplyid_' + id).html('');
            mention_array['mention_type_id'] = new Array();
            mention_array['mention_type'] = new Array();
            mention_array['mention_id'] = new Array();
            showTopErrSucc('success', _('Your reply edited successfully.'));
            if (!check_empty(data.mention_array)) {
                var mEmailUser = Array();
                if (data.mention_array.mention_type.length > 0) {
                    $.each(data.mention_array.mention_type, function(index, value) {
                        if (value == "user") {
                            mEmailUser.push(data.mention_array.mention_type_id[index]);
        }
    });
}
                if (mEmailUser.length != 0) {
                    var murl_ajax = HTTP_ROOT + "requests/ajaxMentionEmail";
                    $.post(murl_ajax, {
                        'projId': data.projId,
                        'emailUser': mEmailUser,
                        'caseNo': data.caseNo,
                        'emailTitle': data.emailTitle,
                        'emailMsg': data.emailMsg,
                        'casePriority': data.casePriority,
                        'caseTypeId': data.caseTypeId,
                        'msg': data.msg,
                        'emailbody': data.emailbody,
                        'caseIstype': data.caseIstype,
                        'csType': data.csType,
                        'caUid': data.caUid,
                        'caseid': data.caseid,
                        'caseUniqId': data.caseUniqId,
                        'is_client': 0
                    });
                }
            }
            $('img').off().on('click', function(e) {
                var targt = $(e.target).attr('src');
                e.stopPropagation();
                if (typeof targt != 'undefined' && targt.indexOf("_case_edtr") !== -1) {
                    var spltArr = targt.split('file=')[1].split('&quality');
                    if (confirm(_('Would you like to delete this file?'))) {
                        $.ajax({
                            url: HTTP_ROOT + "easycases/ajaXRemoveEditorFile",
                            data: {
                                'file': spltArr[0]
                            },
                            method: 'post',
                            success: function(response) {
                                easycase.ajaxCaseDetails(data.caseUniqId, 'case', 0, 'popup', 'reload');
                            }
                        });
                    }
                }
            });
        }
    }, "json");
}

function cancel_editor_reply(id) {
    $('#casereplytxt_id_' + id).show();
    $('#casereplyid_' + id).html('');
    mention_array['mention_type_id'] = new Array();
    mention_array['mention_type'] = new Array();
    mention_array['mention_id'] = new Array();
}

function removeFileFrmFiles(file_id) {
    var url = HTTP_ROOT + "archives/file_remove";
    if (confirm(_("Are you sure you want to remove?"))) {
        var val = new Array();
        val.push(file_id);
        var name = $('#file_remove_' + file_id).attr("data-name");
        var hashtag = parseUrlHash(urlHash);
        $.post(url, {
            "val": val
        }, function(data) {
            showTopErrSucc('success', _("File") + " '" + name + "' " + _("is removed."));
            if (typeof hashtag != 'undefined' && hashtag != 'overview') {
                easycase.showFiles('files');
            } else if (hashtag == 'overview') {
                var curRow = "curRow" + file_id;
                $("#" + curRow).fadeOut(500);
            }
        });
    }
}

function setResetTlogFilter(filter) {
    if (getHash().indexOf("details/") !== -1) {} else {
        var tlg_date = '';
        var tlg_resrc = '';
        if (typeof localStorage.getItem('timelog_date_filter') != 'undefined') {
            tlg_date = localStorage.getItem('timelog_date_filter');
        }
        if (typeof localStorage.getItem('timelog_resource_filter') != 'undefined') {
            tlg_resrc = localStorage.getItem('timelog_resource_filter');
        }
        if (tlg_date != '' && tlg_date != null) {
            if (tlg_date.indexOf(":") !== -1) {
                var tlg_date_t = tlg_date.split(':');
                $('#logstrtdt').val(tlg_date_t[0]);
                $('#logenddt').val(tlg_date_t[1]);
                $('#tlog_date').val('custom');
            } else {
                $('#tlog_date').val(tlg_date);
                $('#timelog_' + tlg_date).prop('checked', true);
            }
        }
        if (tlg_resrc != '' && tlg_resrc != null) {
            $('#tlog_resource').val(tlg_resrc);
        }
    }
}

function ajaxTimeLogView(type, filter) {
    $("#chart_btn_timelog").removeClass('disable');
    if (!arguments[3]) {
        $(".side-nav li").removeClass('active');
        $(".menu-logs").addClass('active');
        $('#caseMenuFilters').val('timelog');
        easycase.routerHideShow('timelog');
    }
    $('#TimeLog_chart_view').hide();
    var strURL = HTTP_ROOT + "requests/";
    var projFil = $('#projFil').val();
    $('#caseLoader').show();
    var params = {
        projFil: projFil
    };
    if (typeof filter != 'undefined' && type == "datesrch") {
        params.filter = filter;
    }
    setResetTlogFilter(filter);
    params.filter = $('#tlog_date').val();
    var search_reset = false;
    var prjunid = $('#projFil').val();
    params.projuniqid = prjunid;
    var usrid = filter;
    params.usrid = usrid;
    search_reset = true;
    params.usrid = $('#tlog_resource').val();
    if ($('#logstrtdt').val() != '') {
        var strdt = $('#logstrtdt').val();
        params.strddt = strdt;
        search_reset = true;
    }
    if ($('#logenddt').val() != '') {
        var eddt = $('#logenddt').val();
        params.enddt = eddt;
        search_reset = true;
    }
    if (arguments[2]) {
        var page = arguments[2];
    } else {
        var page = 1;
    }
    params.casePage = page;
    if (arguments[3]) {
        var task_id = arguments[3];
    } else {
        task_id = '';
    }
    params.task_id = task_id;
    $('#caseLoader').hide();
    $('#caseTimeLogViewSpan').show();
    showreplytimelog();
    var check_dtl_pg = 0;
    if (getHash().indexOf("details/") !== -1) {
        check_dtl_pg = 1;
    }
    if (!check_dtl_pg && typeof angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope() != 'undefined' && typeof angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().fetchTimelog == 'function') {
        pgn = (typeof angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().__default__currentPage != 'undefined') ? angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().__default__currentPage : 1;
        angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().fetchTimelog('', pgn);
        angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().$apply();
    } else {
        $.ajax({
						url:strURL + "time_log",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                if (res) {
                    if (task_id && task_id != '') {
                        if ($('.totalSPH').length > 0) {
                            $('.totalSPH').html(format_time_hr_min(res.logtimes.details.totalHrs))
                        }
                        var logscnt = res.logtimes.logs;
                        if (logscnt.length > 0) {
                            $('#reply_time_log' + task_id).html(tmpl("case_timelog_tmpl", res));
                        }
                        $('#caseLoader').hide();
                    } else {
                        $("#caseTimeLogViewSpan").html(tmpl("case_timelog_tmpl", res));
                        if (typeof localStorage['open_timelog'] != 'undefined' && localStorage['open_timelog'] == 1) {
                            createlog(0, '');
                            localStorage.removeItem('open_timelog');
                        }
                        var SHOWTIMELOG = getCookie('SHOWTIMELOG');
                        var pagename = typeof res.logtimes.page != 'undefined' ? res.logtimes.page : '';
                        if (pagename == 'taskdetails' && SHOWTIMELOG == '') {
                            SHOWTIMELOG = 'No';
                        }
                        SHOWTIMELOG = typeof res.logtimes.page != 'undefined' && res.logtimes.page == 'taskdetails' ? SHOWTIMELOG : 'Yes';
                        var d_y_n = '';
                        var tlog_btn = '';
                        if (SHOWTIMELOG == 'No') {
                            d_y_n = 'style="display:none;"';
                        }
                        var t_ttl = htmlspecialchars(res.logtimes.task_title);
                        tlog_btn = '<a ' + d_y_n + ' onclick="createlog(' + res.logtimes.task_id + ',\'' + t_ttl + '\')" href="javascript:void(0)" class="<%=logtimes.page%> anchor log-more-time btn btn-raised btn-sm btn_cmn_efect"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Log more time</a><a ' + d_y_n + ' href="javascript:void(0)" onclick="ajax_timelog_export_csv();" class="btn btn-raised btn-sm btn_cmn_efect" rel="tooltip" title="Export To CSV"><i class="material-icons">&#xE8D5;</i></a>';
                        $('.btn_tlog_top_fun').html(tlog_btn);
                        $('#caseLoader').hide();
                        $('#TimeLog_paginate').show();
                        $('[rel=tooltip]').tipsy({
                            gravity: 's',
                            fade: true
                        });
                        if (!isAllowed('View All Resource')) {
                            $("#dropdown_menu_resource").closest('li').hide();
                        } else {
                            $("#dropdown_menu_resource").closest('li').show();
                        }
                        if (typeof res.projUser != 'undefined') {
                            PUSERS = res.projUser;
                        }
                        var user_found = false;
                        if (SES_TYPE < 3 || SES_ID == 13902) {
                            var usrhtml = "<option value=''>" + _("Select User") + "</option>";
                            $.each(PUSERS, function(key, val) {
                                $.each(val, function(k1, v1) {
                                    var user_id = v1['User']['id'];
                                    usrhtml += "<option value='" + user_id + "' title='" + v1['User']['name'] + "'>" + shortLength(v1['User']['name'], '15', 1) + "</option>";
                                    if (usrid == user_id) {
                                        user_found = true;
                                    }
                                });
                            });
                            $('#rsrclog').html(usrhtml).val(user_found == true ? usrid : '');
                        }
                        if (search_reset) {
                            setTimeout(function() {
                                $('#btn-reset-timelog').show()
                            }, 200);
                        } else {
                            $('#btn-reset-timelog').hide();
                        }
                        $(document).on('click', '#ui-datepicker-div', function(e) {
                            e.stopPropagation();
                        });
                        $(document).on('click', '.ui-datepicker-prev', function(e) {
                            e.stopPropagation();
                        });
                        $(document).on('click', '.ui-datepicker-next', function(e) {
                            e.stopPropagation();
                        });
                    }
                    displayMenuProjects('dashboard', '6', '');
                }
                $('.r-u-link').hide();
                if (SES_TYPE < 3) {
                    $('.r-u-link').show();
                }
            }
        });
    }
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
}

function ajaxProjectOveriew() {
    $('.case_blocks').hide();
    $('#caseOverview').show();
    $('#caseLoader').show();
    var params_val = typeof arguments[0] != 'undefined' ? arguments[0] : '';
    if (params_val != '') {
        var prjunid = params_val;
        $('.project-dropdown').hide();
        $('.project-dropdown').prev('li').hide();
    } else {
        var prjunid = $('#projFil').val();
    }
    easycase.routerHideShow('overview');
    $.ajax({
        url: HTTP_ROOT + "easycases/project_overview",
        data: {
            'prjunid': prjunid
        },
        method: 'post',
        success: function(response) {
            $('.os_projct_overview_date').show();
            $('#caseOverview').html(response);
            $.post(HTTP_ROOT + "requests/getAllTasks", {
                projUniq: $('#projFil').val()
            }, function(res) {
                $("#taskCnt").html("(" + res.total_case + ")")
            }, 'json');
            $('#caseLoader').hide();
            if (params_val != '') {
                $('.project-dropdown').hide();
                $('.project-dropdown').prev('li').hide();
            }
        }
    });
}

function calenderForTimeLog(page) {
    $('.bcrumbtimelog').hide();
    $('#timelogtbl').addClass('temp-class');
    $('.timelog-detail-tbl').hide();
    $('#calendar_view').show().css({
        'margin-top': '0px',
        'margin-left': '22px'
    });
    $('#filter_text').html("<b>" + _("for all users and all dates") + "</b>");
    $('#btn-reset-timelog').css('display', 'none');
    $('.show_total_case').css('display', 'none');
    $('#filter_section').hide();
    if ($('#milestoneUid').val()) {
        $('.case-filter-menu').hide();
        $('.breadcrumb_div').hide();
        $('.milestonekb_detail_head').show();
    } else {
        $('.breadcrumb_div').show();
    }
    $('.calendar_section').show();
    $('.kanban_section').hide();
    $('#mlsttab_sta').hide();
    $('.task_detail_head').hide();
    $("#caseFileDv").hide();
    $("#widgethideshow").hide();
    $('#select_view_timelog').show();
    $('#select_view_mlst').hide();
    $('#actvt_section').hide();
    $('#milestone_content').hide();
}

function getStatusNumber(sts) {
    var legend = 0;
    if (typeof sts != 'undefined' && sts.indexOf("kanban_board_") !== -1) {
        var t_legnd = sts.split('kanban_board_');
        legend = t_legnd[1];
    } else {
        switch (sts) {
            case 'newTask':
                legend = 1;
                break;
            case 'inprogressTask':
                legend = 2;
                break;
            case 'resolvedTask':
                legend = 5;
                break;
            case 'closedTask':
                legend = 3;
                break;
            default:
                legend = 0;
                break;
        }
    }
    return legend;
}

function comnBacklogItemSum(prev_mid, velocity) {
    var new_cnt = (velocity == 1) ? '0' : 0;
    var wp_cnt = (velocity == 1) ? '0' : 0;
    var cls_cnt = (velocity == 1) ? '0' : 0;
    if ($('#tobody_' + prev_mid + ' .calcBklgSum').length) {
        $('#tobody_' + prev_mid + ' .calcBklgSum').each(function() {
            var legnd = $(this).attr('data-legend');
            var cnt_value = $.trim($(this).text());
            if (cnt_value != '') {
                if (legnd == 1) {
                    if (velocity == 1) {
                        new_cnt = timeSum(new_cnt, cnt_value);
                    } else {
                        new_cnt += parseInt(cnt_value);
                    }
                } else if (legnd == 3) {
                    if (velocity == 1) {
                        cls_cnt = timeSum(cls_cnt, cnt_value);
                    } else {
                        cls_cnt += parseInt(cnt_value);
                    }
                } else {
                    if (velocity == 1) {
                        wp_cnt = timeSum(wp_cnt, cnt_value);
                    } else {
                        wp_cnt += parseInt(cnt_value);
                    }
                }
            }
        });
    }
    $("#st_crt_btn_" + prev_mid).find('.openSprint').text(new_cnt);
    $("#st_crt_btn_" + prev_mid).find('.wipSprint').text(wp_cnt);
    $("#st_crt_btn_" + prev_mid).find('.closeSprint').text(cls_cnt);
}

function timeSum(time1, time2) {
    var hour = 0;
    var minute = 0;
    var splitTime1 = time1.split(':');
    var splitTime2 = time2.split(':');
    hour = parseInt(splitTime1[0]) + parseInt(splitTime2[0]);
    if (typeof splitTime1[1] != 'undefined') {
        minute += parseInt(splitTime1[1]);
    }
    if (typeof splitTime2[1] != 'undefined') {
        minute += parseInt(splitTime2[1]);
    }
    hour = hour + parseInt(minute / 60);
    if (minute > 0) {
        minute = minute % 60;
    }
    if (hour.toString().length <= 1) {}
    if (minute.toString().length <= 1) {}
    return hour + ':' + minute;
}
function collapse_taskgroup(obj) {
    var taskGroupId = $(obj).closest('tr').attr('id').replace('empty_milestone_tr', '');
    var ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS')) : [];
    if ($(obj).hasClass('minus-plus')) {
        $(obj).removeClass('minus-plus');
        $(obj).addClass('plus-minus');
        $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').slideDown(function() {
            changeCBStatus();
            checkAllCB(obj, 'open');
        });
        ids_array.splice($.inArray(taskGroupId, ids_array), 1);
    } else {
        $(obj).addClass('minus-plus');
        $(obj).removeClass('plus-minus');
        $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').slideUp(function() {
            changeCBStatus();
            checkAllCB(obj, 'close');
        });
        if ($.inArray(taskGroupId, ids_array) == -1) {
            ids_array.push(taskGroupId);
        }
    }
    createCookie("PREOPENED_TASK_GROUP_IDS", JSON.stringify(ids_array), 365, DOMAIN_COOKIE);
}

function collapse_by_title(mid, pid) {
    var hashtag = parseUrlHash(urlHash);
    if (hashtag[0] == 'taskgroup') {
        collapse_taskgroup($('.os_sprite' + mid));
        showTaskByMilestone(mid, pid, $('.os_sprite' + mid));
    } else if (hashtag[0] == 'taskgroups') {
        collapse_taskgroup_thread($('.os_sprite' + mid));
        showTaskByTaskGroup(mid, pid, $('.os_sprite' + mid));
    }
}

function collapse_backlog(obj) {
    var ichk_c = (typeof arguments[1] != 'undefined' && arguments[1] != '0') ? 1 : 0;
    var taskGroupId = $(obj).closest('tr').attr('id').replace('empty_milestone_tr', '');
    var ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS')) : [];
    if ($.trim($(obj).text()) == 'keyboard_arrow_right') {
        $(obj).find('.material-icons').text('keyboard_arrow_down');
        $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').slideDown(function() {
            changeCBStatus();
            checkAllCB(obj, 'open');
        });
        if ($.inArray(taskGroupId, ids_array) == -1) {
            ids_array.push(taskGroupId);
        }
    } else {
        if (!ichk_c) {
            $(obj).find('.material-icons').text('keyboard_arrow_right');
            $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').slideUp(function() {
                changeCBStatus();
                checkAllCB(obj, 'close');
            });
            ids_array.splice($.inArray(taskGroupId, ids_array), 1);
        }
    }
    createCookie("PREOPENED_TASK_GROUP_IDS", JSON.stringify(ids_array), 365, DOMAIN_COOKIE);
}

function openTaskListExportPopup() {
    openPopup();
    $(".loader_dv").show();
    $(".task_list_export").show();
    $('.tsk_exp_chkbx').prop('checked', true);
    $('.tsk_exp_rdo').prop('checked', true);
    var taskgroupby = getCookie('TASKGROUPBY');
    if (taskgroupby != '' && typeof taskgroupby != 'undefined') {
        $('#exp_tskgrp').prop('checked', true);
    } else {
        $('#exp_tskgrp').prop('checked', false);
    }
    if ($.trim($('#projFil').val()) == 'all') {
        $('.exp_customField').hide();
    } else {
        $('.exp_customField').show();
    }
}

function tasklistexport() {
    var checkedArr = [];
    $('.tsk_exp_chkbx').each(function() {
        if ($(this).is(':checked')) {
            checkedArr.push($(this).val());
        }
    });
    if (!checkedArr.length) {
        showTopErrSucc('Error', _('Please select atleast one field.'));
        return false;
    }
    var dt_format = "d/m/y";
    $('.tsk_exp_rdo').each(function() {
        if ($(this).is(':checked')) {
            dt_format = $(this).val();
        }
    });
    closePopup();
    var projFil = $('#projFil').val();
    var caseId = $('#caseId').val();
    var startCaseId = $('#caseStart').val();
    var caseResolve = $('#caseResolve').val();
    var caseNew = $('#caseNew').val();
    var caseChangeType = $('#caseChangeType').val();
    var caseChangePriority = $('#caseChangePriority').val();
    var caseChangeDuedate = $('#caseChangeDuedate').val();
    var caseChangeAssignto = $('#caseChangeAssignto').val();
    var customfilter = $('#customFIlterId').val();
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseTaskGroup = $('#caseTaskgroup').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseDate = $('#caseDate').val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var taskgroup_fil = '';
    var hashtag = parseUrlHash(urlHash);
    var caseSearch = $("#case_search").val();
    if ((caseSearch != null) && (caseSearch.trim() == '')) {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    var caseTitle = $('#caseTitle').val();
    var caseDueDate = $('#caseDueDate').val();
    var caseNum = $('#caseNum').val();
    var caseLegendsort = $('#caseLegendsort').val();
    var caseAtsort = $('#caseAtsort').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    var caseCreateDate = $('#caseCreatedDate').val();
    var projIsChange = $('#projIsChange').val();
    if (caseMenuFilters != 'milestone' && caseMenuFilters != 'files') {
        if (caseMenuFilters === "") {
            caseMenuFilters = "cases";
        }
    }
    var caseUrl = "";
    var detailscount = 0;
    var reply = 0;
    if (caseMenuFilters == 'milestone') {
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
    }
    setTimeout('', 500);
    var menu_filter = caseMenuFilters;
    var url_params = 'projFil=' + projFil + '&caseStatus=' + caseStatus + '&caseCustomStatus=' + caseCustomStatus + '&customfilter=' + customfilter + '&caseChangeAssignto=' + caseChangeAssignto + '&caseChangeDuedate=' + caseChangeDuedate + '&caseChangePriority=' + caseChangePriority + '&caseChangeType=' + caseChangeType + '&mstype=' + mstype + '&priFil=' + priFil + '&caseTypes=' + caseTypes + '&caseLabel=' + caseLabel + '&caseMember=' + caseMember + '&caseComment=' + caseComment + '&caseTaskGroup=' + caseTaskGroup + '&caseAssignTo=' + caseAssignTo + '&caseDate=' + caseDate + '&caseSearch=' + caseSearch + '&casePage=' + casePage + '&caseId=' + caseId + '&caseTitle=' + caseTitle + '&caseDueDate=' + caseDueDate + '&caseNum=' + caseNum + '&caseLegendsort=' + caseLegendsort + '&caseAtsort=' + caseAtsort + '&startCaseId=' + startCaseId + '&caseResolve=' + caseResolve + '&caseNew=' + caseNew + '&caseMenuFilters=' + caseMenuFilters + '&caseUrl=' + caseUrl + '&detailscount=' + detailscount + '&milestoneIds=' + milestoneIds + '&case_srch=' + case_srch + '&case_date=' + case_date + '&case_due_date=' + case_due_date + '&caseCreateDate=' + caseCreateDate + '&projIsChange=' + projIsChange + '&dt_format=' + dt_format + '&checkedFields=' + checkedArr;
    var url = HTTP_ROOT + "easycases/export_csv_tasklist?" + url_params;
    window.open(url, '_blank');
    return false;
}

function tasklistprint() {
    var divToPrint = document.getElementById('caseViewSpan');
    var popupWin = window.open('', '_blank', 'width=1280,height=900');
    popupWin.document.open();
    popupWin.document.write('<html><head><title>Orangescrum Task List</title>');
    popupWin.document.write('<link rel="stylesheet" href="' + HTTP_ROOT + 'css/print.css" type="text/css" media="print" /><link rel="stylesheet" href="' + HTTP_ROOT + 'css/bootstrap.min.css" type="text/css" /><link rel="stylesheet" href="' + HTTP_ROOT + 'css/bootstrap-material-design.min.css" type="text/css" /><link rel="stylesheet" href="' + HTTP_ROOT + 'css/ripples.min.css" type="text/css" /><link rel="stylesheet" href="' + HTTP_ROOT + 'css/custom.css" type="text/css" />');
    popupWin.document.write('</head><body onload="window.print();return false;">' + divToPrint.innerHTML + '</body></html>');
    popupWin.document.close();
}

function appendReplyThread(curCaseId, caseId) {
    refreshTasks = 1;
    var url = HTTP_ROOT + 'easycases/appendReplyThread';
    var prjId = $('#projFil').val();
    $.post(url, {
        'curCaseId': curCaseId,
        'caseId': caseId,
        'prjid': prjId
    }, function(data) {
        var active = $('#case_activity_task_dtlpop').prepend(tmpl("case_detail_right_activity_tmpl", data));
        var cnt_actv = $(".actv_count").length;
        if (cnt_actv > 10) {
            $('#show_more_bun').show();
            $('#show_less_bun').trigger('click');
        }
        var params = parseUrlHash(urlHash);
        var thrd_sort_ordr = getCookie('REPLY_SORT_ORDER');
        var no_of_thrds = $("#showhidemorereply" + caseId).find('div.user-task-info').length;
        totalReplies = data.total;
        if (thrd_sort_ordr == 'ASC') {
            var count = $("#showhidemorereply" + caseId).children('div.user-task-info:first').find('.badge').text();
        } else {
            count = $("#showhidemorereply" + caseId).children('div.user-task-info:last').find('.badge').text();
        }
        if (parseInt(count) == 10) {
            easycase.refreshTaskList(params[1]);
        } else {
            count = count != '' ? parseInt(count) + 1 : '1';
            $(".activities_flowchat").find('.actvity_bar').prepend(tmpl("case_detail_right_activity_tmpl", data));
            $(".activities_flowchat").find("#noactivity").remove();
            $(".activities_flowchat").find(".actvity_bar").removeClass('nodot');
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
            $("a[rel^='prettyPhoto']").prettyPhoto({
                animation_speed: 'normal',
                autoplay_slideshow: false,
                social_tools: false,
                overlay_gallery: false,
                deeplinking: false
            });
        }
    }, 'json');
}

function tasklisttmplAdd(taskid) {
    var mid = arguments[1] != '0' ? arguments[1] : 'NA';
    var cp = typeof arguments[2] != 'undefined' ? arguments[2] : '';
    var sourceTask = typeof arguments[3] != 'undefined' ? arguments[3] : '';
    var url = HTTP_ROOT + 'easycases/taskListTmpl';
    var urlHash = getHash();
    $.post(url, {
        'caseid': taskid,
        'mid': mid,
        'page': urlHash
    }, function(res) {
        if (res) {
            var sortby = getCookie('TASKSORTBY');
            var cnttxt = $('#curRow' + taskid).find('.ttl_listing').children('span').attr('id');
            var cnt = typeof cnttxt != 'undefined' ? cnttxt.substring(cnttxt.lastIndexOf("html") + 4) : '';
            res.caseDet.Easycase.count = cnt;
            res.caseDet.Easycase.projectUniqid = $('#projFil').val();
            res.caseDet.Easycase.projectName = $('#pname_dashboard a').text();
            if (urlHash == 'taskgroups') {
                $('#caseViewSpan').find('table').find('tr.quicktsk_tr').after(tmpl("subtask_thread_tmpl", res));
            } else if (cp != '' && cp == 'copy') {
                $('#curRow' + sourceTask).after(tmpl("list_thread_tmpl", res));
            } else if (sortby != 'updated' && typeof sortby != 'undefined' && urlHash != 'backlog') {
                if (mid == 'qtl') {
                    $('#caseViewSpan').find('table').find('tr.quicktsk_tr').after(tmpl("list_thread_tmpl", res));
                } else {
                    if (mid) {
                        $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).next('tr.white_bg_tr').after(tmpl("list_thread_tmpl", res));
                    } else {
                        var prevtr = $('#curRow' + taskid).prev('tr');
                        $('#curRow' + taskid).remove();
                        prevtr.after(tmpl("list_thread_tmpl", res));
                    }
                }
            } else if (cp != 'sts') {
                if (urlHash == 'backlog') {
                    if (mid == 'NA') {
                        mid = 0;
                    }
                    if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).length) {
                        if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).next('tr.white_bg_tr').length) {
                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).next('tr.white_bg_tr').after(tmpl("backlog_thread_tmpl", res));
                        } else {
                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).after(tmpl("backlog_thread_tmpl", res));
                        }
                        comnBacklogItemSum(mid, res.caseDet.velocity);
                    }
                    if ($('#backlog_tsk_cnt_' + mid).length) {
                        var taskLen = parseInt($('#backlog_tsk_cnt_' + mid).text()) + 1;
                        $('#backlog_tsk_cnt_' + mid).text(taskLen);
                    }
                } else if (typeof getCookie("TASKGROUPBY") == "undefined" || getCookie("TASKGROUPBY") == "") {
                    $('#curRow' + taskid).remove();
                    if ($('#caseViewSpan').find('table').find('tr.list-dt-row:first').find('span').text() == 'Today') {
                        $('#caseViewSpan').find('table').find('tr.list-dt-row:first').after(tmpl("list_thread_tmpl", res));
                    } else {
                        if ($('#caseViewSpan').find('table').find('tr.list-dt-row:first').length > 0) {
                            $('#caseViewSpan').find('table').find('tr.list-dt-row:first').before(tmpl("list_thread_tmpl", res));
                        } else {
                            $('#caseViewSpan').find('table').find('tr.empty_task_tr').before(tmpl("list_thread_tmpl", res));
                        }
                    }
                } else {
                    if (mid == 'qtl' || typeof mid == 'undefined') {
                        mid = $('#curRow' + taskid).attr('data-mid');
                    }
                    $('#curRow' + taskid).remove();
                    if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).length) {
                        if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).next('tr.white_bg_tr').length) {
                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).next('tr.white_bg_tr').after(tmpl("list_thread_tmpl", res));
                        } else {
                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + mid).after(tmpl("list_thread_tmpl", res));
                        }
                    } else {
                        easycase.refreshTaskList();
                    }
                }
            }
            if (cp == 's_a_s_t') {
                if ($('#start_qt' + taskid).length) {
                    setTimeout(function() {
                        $('#start_qt' + taskid).click();
                    }, 200);
                }
            }
            if (cp == 'sts') {
                var lngd_id = (parseInt(res.caseDet.Easycase.custom_status_id)) ? res.caseDet.Easycase.custom_status_id : res.caseDet.Easycase.legend;
                if ($('#kanban_board_' + lngd_id).find('.kanban_content .item-' + res.caseDet.Easycase.id).length) {
                    $('#kanban_board_' + lngd_id).find('.kanban_content .item-' + res.caseDet.Easycase.id).after(tmpl("kanban_thread_tmpl", res));
                    $('#kanban_board_' + lngd_id).find('.kanban_content .item-' + res.caseDet.Easycase.id).first().remove();
                } else {
                    $('#kanban_board_' + lngd_id).find('.kanban_content').prepend(tmpl("kanban_thread_tmpl", res));
                    $("#cnter_kanban_board_" + lngd_id).html(parseInt($("#cnter_kanban_board_" + lngd_id).html()) + 1);
                }
                initializeKanban();
            }
            if (mid == 'qtl') {
                $('#curRow' + taskid).addClass('new_qt_tr_bkg_colr');
                setTimeout(function() {
                    $('#curRow' + taskid).removeClass('new_qt_tr_bkg_colr');
                }, 5000);
            }
            $('#curRow' + taskid).find('.ttl_listing').children('span').attr('id', 'titlehtml' + cnt);
            $.material.init();
            $('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').on('mouseenter', function() {
                $(this).attr('aria-expanded', true);
                $(this).parent().addClass('open');
            });
            $('.row_tr').on('mouseleave', function() {
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', false);
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().removeClass('open');
            });
            if (urlHash != 'backlog') {
                $("div [id^='set_due_date_']").each(function(i) {
                    $(this).datepicker({
                        altField: "#CS_due_date",
                        startDate: new Date(),
                        todayHighlight: true,
                        format: 'mm/dd/yyyy',
                        hideIfNoPrevNext: true,
                        autoclose: true
                    }).on('changeDate', function(e) {
                        var caseId = $(this).attr('data-csatid');
                        var datelod = "datelod" + caseId;
                        var showUpdDueDate = "showUpdDueDate" + caseId;
                        var old_duetxt = $("#" + showUpdDueDate).html();
                        $("#" + showUpdDueDate).html("");
                        $("#" + datelod).show();
                        var text = '';
                        var vobj = $(this);
                        var dateText = $(this).datepicker('getFormattedDate');
                        $(this).val('');
                        commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj);

                    });
                });
                $('.due_dt_tlist').off().on('click', function(e) {
                    e.stopPropagation();
                    var targt = $(e.target).attr('id');
                    if ($(this).find('span.check-drop-icon > span.dropdown').hasClass('open')) {
                        if (typeof targt == 'undefined' || targt.indexOf("set_due_date_") === -1) {
                            $(this).find('span.check-drop-icon > span.dropdown').removeClass('open');
                        }
                    } else {
                        if ($(this).find('span.check-drop-icon > span.dropdown > a').attr('data-toggle').trim() != '') {
                            $(this).find('span.check-drop-icon > span.dropdown').addClass('open');
                        }
                    }
                });
                $('.assi_tlist').off().on('click', function(e) {
                    e.stopPropagation();
                    if ($(this).find('span.check-drop-icon > span.dropdown').hasClass('open')) {
                        $(this).find('span.check-drop-icon > span.dropdown').removeClass('open');
                    } else {
                        if ($(this).find('span.check-drop-icon > span.dropdown > a').attr('data-toggle').trim() != '') {
                            $(this).find('span.check-drop-icon > span.dropdown').addClass('open');
                        }
                    }
                });
                $('input[id^="est_hrlist"]').off().on('keyup', function(e) {
                    var unicode = e.charCode ? e.charCode : e.keyCode;
                    if (unicode == 13) {
                        var id = $(this).attr('data-est-id');
                        var uid = $(this).attr('data-est-uniq');
                        var cno = $(this).attr('data-est-no');
                        var tim = $(this).attr('data-est-time');
                        changeEstHourTaskListPage(id, uid, cno, tim);
                    }
                });
                localStorage.setItem("ckl_chk", 0);
                $('input[id^="est_hrlist"]').on('blur', function(e) {
                    var d_val = $(this).attr('data-default-val');
                    var d_val_orig = $(this).val();
                    if (localStorage.getItem("ckl_chk") == '0') {
                        if (d_val == d_val_orig) {
                            $(this).closest('.estblist').size() > 0 ? '' : $('.estblist').show();
                            $('.est_hrlist').hide();
                        }
                    }
                });
                var caseStatus = $('#caseStatus').val();
                var priFil = $('#priFil').val();
                var caseTypes = $('#caseTypes').val();
                var caseLabel = $('#caseLabel').val();
                var caseMember = $('#caseMember').val();
                var caseComment = $('#caseComment').val();
                var caseAssignTo = $('#caseAssignTo').val();
                var case_date = $('#caseDateFil').val();
                var case_due_date = $('#casedueDateFil').val();
                var caseSearch = $("#case_search").val();
                var caseMenuFilters = $('#caseMenuFilters').val();
                var milestoneIds = $('#milestoneIds').val();
                var projFil = $('#projFil').val();
                $('#caseId').val();
                $('#caseResolve').val();
                $('#caseStart').val();
                var checktype = $("#checktype").val();
                var caseMenuFilters = $('#caseMenuFilters').val();
                $.post(HTTP_ROOT + "requests/ajax_case_status", {
                    "projUniq": projFil,
                    "pageload": 0,
                    "caseMenuFilters": caseMenuFilters,
                    'case_date': case_date,
                    'case_due_date': case_due_date,
                    'caseStatus': caseStatus,
                    'caseTypes': caseTypes,
                    'caseLabel': caseLabel,
                    'priFil': priFil,
                    'caseMember': caseMember,
                    'caseComment': caseComment,
                    'caseAssignTo': caseAssignTo,
                    'caseSearch': caseSearch,
                    'milestoneIds': milestoneIds,
                    'checktype': checktype
                }, function(data) {
                    if (data) {
                        $('#ajaxCaseStatus').html(data);
                        $('#ajaxCaseStatus').html(tmpl("case_widget_tmpl", data));
                        $('[rel=tooltip]').tipsy({
                            gravity: 's',
                            fade: true
                        });
                        $("#upperDiv_not").hide();
                        var statusnot = $('#not_sts').html();
                        var n = '';
                        if (caseMenuFilters != 'milestone' && caseMenuFilters != 'closecase' && n == -1) {
                            var closed = $("#closedcaseid").val();
                            if (closed != 0) {
                                $("#upperDiv_not").show();
                                if (closed == 1) {
                                    $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("task"));
                                } else {
                                    $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("tasks"));
                                }
                            } else {
                                $("#upperDiv_not").hide();
                                $("#closedcases").html('');
                            }
                        }
                        $('.f-tab').tipsy({
                            gravity: 'n',
                            fade: true
                        });
                    }
                });
            }
        }
        $("#miviewspan_" + mid).closest("tbody").find(".textRed").closest("tr").remove();
        $("#miviewspan_" + mid).html($("#miviewspan_" + mid).closest("tbody").find("tr[id^='curRow']").length);
        changeCBStatus();
    }, 'json');
}

function checkCategoryLimit(obj) {
    var checked = $('.cattab_cls:checked').size();
    if (checked > 3) {
        $(obj).prop('checked', false);
        showTopErrSucc('error', _('You can not select more than 3 tabs.'));
    }
}

function convertToTask(obj, mstid, projid, cnt) {
    var projFil = $("#projFil").val();
    var url = HTTP_ROOT + 'easycases/ajax_convert_to_task';
    var hashtag = parseUrlHash(urlHash);
    if (confirm(_("Are you sure you want to convert to task?"))) {
        $(obj).closest('tbody').remove();
        $('#caseLoader').show();
        $.post(url, {
            mid: mstid,
            pid: projid,
            puid: projFil
        }, function(data) {
            if (data.success) {
                $('#caseLoader').hide();
                showTopErrSucc('success', data.msg);
                if (hashtag[0] == "taskgroups") {
                    $("#empty_milestone_tr_thread" + mstid).remove();
                    if ($(".empty_milestone_tr_thread0").find(".os_sprite0").hasClass("plus-minus")) {
                        $("#empty_milestone_tr_thread0").find('.os_sprite0').trigger('click');
                        setTimeout($("#empty_milestone_tr_thread0").find('.os_sprite0').trigger('click'), 5000);
                    } else {
                        $("#empty_milestone_tr_thread0").find('.os_sprite0').trigger('click');
                    }
                } else {
                tasklisttmplAdd(data.curCaseId, 0);
            }
            }
        }, 'json');
    }
    return false;
}

function showTaskByMilestone(mid, pid, obj) {
    if ($(obj).hasClass('plus-minus')) {
        var url = HTTP_ROOT + 'easycases/loadTaskByMilestone';
        var tbody = $(obj).closest('tbody');
        tbody.find('tr[id^="curRow"],.white_bg_tr,.noRecord').remove();
        tr = '<tr class="loadTasks"><td colspan="10" align="center"><div class="loader_bg"><div class="loadingdata"><img src="' + HTTP_ROOT + 'images/rolling.gif?v=' + RELEASE + '" alt="' + _('loading') + '..." title="' + _('loading') + '..."/></div></div></td></tr>';
        tbody.append(tr);
        var projFil = $("#projFil").val();
        var caseId = $('#caseId').val();
        var startCaseId = $('#caseStart').val();
        var caseResolve = $('#caseResolve').val();
        var caseChangeType = $('#caseChangeType').val();
        var caseChangePriority = $('#caseChangePriority').val();
        var caseChangeDuedate = $('#caseChangeDuedate').val();
        var caseChangeAssignto = $('#caseChangeAssignto').val();
        var customfilter = $('#customFIlterId').val();
        var caseStatus = $('#caseStatus').val();
        var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
        var priFil = $('#priFil').val();
        var caseTypes = $('#caseTypes').val();
        var caseLabel = $('#caseLabel').val();
        var caseMember = $('#caseMember').val();
        var caseComment = $('#caseComment').val();
        var caseAssignTo = $('#caseAssignTo').val();
        var caseDate = $('#caseDate').val();
        var case_date = $('#caseDateFil').val();
        var case_due_date = $('#casedueDateFil').val();
        var taskgroup_fil = '';
        var hashtag = parseUrlHash(urlHash);
        var caseSearch = $("#case_search").val();
        var caseTitle = $('#caseTitle').val();
        var caseDueDate = $('#caseDueDate').val();
        var caseNum = $('#caseNum').val();
        var caseLegendsort = $('#caseLegendsort').val();
        var caseAtsort = $('#caseAtsort').val();
        var caseMenuFilters = $('#caseMenuFilters').val();
        var milestoneIds = $('#milestoneIds').val();
        var case_srch = $('#case_srch').val();
        var caseCreateDate = $('#caseCreatedDate').val();
        var projIsChange = $('#projIsChange').val();
        var caseUrl = "";
        var detailscount = 0;
        var reply = 0;
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
        var casePage = '';
        $.post(url, {
            mid: mid,
            pid: pid,
            projFil: projFil,
            caseStatus: caseStatus,
            caseCustomStatus: caseCustomStatus,
            customfilter: customfilter,
            caseChangeAssignto: caseChangeAssignto,
            caseChangeDuedate: caseChangeDuedate,
            caseChangePriority: caseChangePriority,
            caseChangeType: caseChangeType,
            mstype: mstype,
            priFil: priFil,
            caseTypes: caseTypes,
            caseLabel: caseLabel,
            caseMember: caseMember,
            caseComment: caseComment,
            caseAssignTo: caseAssignTo,
            caseDate: caseDate,
            caseSearch: caseSearch,
            casePage: casePage,
            caseId: caseId,
            caseTitle: caseTitle,
            caseDueDate: caseDueDate,
            caseNum: caseNum,
            caseLegendsort: caseLegendsort,
            caseAtsort: caseAtsort,
            startCaseId: startCaseId,
            caseResolve: caseResolve,
            caseMenuFilters: caseMenuFilters,
            caseUrl: caseUrl,
            detailscount: detailscount,
            milestoneIds: milestoneIds,
            case_srch: case_srch,
            case_date: case_date,
            'case_due_date': case_due_date,
            caseCreateDate: caseCreateDate,
            projIsChange: projIsChange
        }, function(res) {
            tbody.find('.loadTasks').remove();
            tbody.append(tmpl("task_by_milestone_tmpl", res));
            iniDateFilter();
            $.material.init();
            $('.tooltip_link').hover(function(e) {
                var scrollTop = $(window).scrollTop();
                var topOffset = $(this).parent().offset().top;
                var relativeOffset = topOffset - scrollTop;
                var windowHeight = $(window).height();
                if (relativeOffset > windowHeight / 2) {
                    $(this).next('.hover_item').addClass("reverse");
                } else {
                    $(this).next('.hover_item').removeClass("reverse");
                }
            }, function(e) {});
            notShowEmptyDropdown();
            $('.addn_menu_drop_pos').each(function() {
                if ($(this).find('li').length <= 9) {
                    $(this).css({
                        "top": "inherit",
                        "bottom": 0
                    });
                }
            });
            $('input[id^="est_hrlist"]').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var id = $(this).attr('data-est-id');
                    var uid = $(this).attr('data-est-uniq');
                    var cno = $(this).attr('data-est-no');
                    var tim = $(this).attr('data-est-time');
                    changeEstHourTaskListPage(id, uid, cno, tim);
                }
            });
            localStorage.setItem("ckl_chk", 0);
            $('input[id^="est_hrlist"]').on('blur', function(e) {
                var d_val = $(this).attr('data-default-val');
                var d_val_orig = $(this).val();
                if (localStorage.getItem("ckl_chk") == '0') {
                    if (d_val == d_val_orig) {
                        $(this).closest('.estblist').size() > 0 ? '' : $('.estblist').show();
                        $('.est_hrlist').hide();
                    }
                }
            });
            $('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').on('mouseenter', function() {
                $(this).attr('aria-expanded', true);
                $(this).parent().addClass('open');
            });
            $('.row_tr').on('mouseleave', function() {
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', false);
                $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().removeClass('open');
            });
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            $("div [id^='set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    startDate: new Date(),
                    todayHighlight: true,
                    format: 'mm/dd/yyyy',
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    var caseId = $(this).attr('data-csatid');
                    var datelod = "datelod" + caseId;
                    var showUpdDueDate = "showUpdDueDate" + caseId;
                    var old_duetxt = $("#" + showUpdDueDate).html();
                    $("#" + showUpdDueDate).html("");
                    $("#" + datelod).show();
                    var text = '';
                    var vobj = $(this);
                    var dateText = $(this).datepicker('getFormattedDate');
                    $(this).val('');
                    commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj);

                });
            });
            changeCBStatus();
            checkAllCB(obj, 'open');
        });
    }
}

function checkBclogTask() {
    if ($("#chkAllbacklogTsk").is(':checked')) {
        $('#chkAllbacklogTsk').parents('.dropdown').addClass('active');
        $('.mass_action_dpdwn').attr('data-toggle', 'dropdown');
        $('.mass_action_dpdwn .material-icons').addClass('active');
        $('#caseViewSpan').find('table').find('td input.chkbcklgbx').prop('checked', true);
    } else {
        $('#caseViewSpan').find('table').find('td input.chkbcklgbx').prop('checked', false);
    }
}
function changeCBStatus() {
    if ($("tr.trans_row:visible .chkOneTsk:not(:disabled)").length <= 0)
        $("#chkAllTsk").prop('checked', false).prop('disabled', true);
    else
        $("#chkAllTsk").prop('disabled', false);
    enableButtons();
}

function checkAllCB(obj, status) {
    if ($("#chkAllTsk").is(':checked')) {
        $(obj).closest('tbody').find('.chkOneTsk:not(:disabled)').each(function() {
            if ($(this).closest('tr').is(':visible') && status != "close") {
                $(this).prop('checked', true);
                $(this).parents('.tr_all').addClass('tr_all_active');
            } else {
                $(this).prop('checked', false);
                $(this).parents('.tr_all').removeClass('tr_all_active');
            }
        });
    }
    enableButtons();
}

function clearPaging() {
    casePage = 1;
}

function searchFilterView() {
    $('.bcrumbtimelog,#task_filter,#task_impExp,#topactions,#saveFilter,.archive_stas_bar,.kanban_stas_bar,.overview-bar,.timlog_top_bar,.timesheet_top_bar,#savereset_filter,#kanban_list').hide();
    closePopup();
    var casePage = (typeof arguments[0] != 'undefined') ? arguments[0] : 1;
    $('.filter_top_cnt').show();
    $("#task_list_bar").show();
    $('#caseLoader').show();
    var projFil = $('#projFil').val();
    var checktype = $("#checktype").val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    $.post(HTTP_ROOT + 'searchFilters/getAllFilters', {
        "projUniq": projFil,
        "milestoneIds": milestoneIds,
        "case_srch": case_srch,
        "checktype": checktype,
        "casePage": casePage
    }, function(res) {
        $('#caseViewSpanUnclick').show();
        $('#caseViewSpan').html(tmpl('search_filter_tmpl', res));
        $('#caseViewSpan').show();
        $('#caseLoader').hide();
    });
}

function deleteInlineFilter(v) {
    if (confirm(_('Are you sure you want to delete this filter ?'))) {
        $('#caseLoader').show();
        $.post(HTTP_ROOT + 'searchFilters/deleteFilters', {
            id: v
        }, function(res) {
            $('#caseLoader').hide();
            if (res.type == 'success') {
                if (typeof localStorage.SEARCHFILTER != 'undefined' && localStorage.SEARCHFILTER == "ftopt" + v) {
                    localStorage.removeItem('SEARCHFILTER');
                }
                showTopErrSucc('success', res.message);
                easycase.refreshTaskList();
            } else {
                showTopErrSucc('error', res.message);
            }
        }, 'json');
    }
}

function editInlineFilter(v) {
    var val = $('#name' + v).find('span').html();
    if ($('#name' + v).find('span').is(":visible")) {
        $('#name' + v).find('span').hide();
        $('#name' + v).append('<input type="text" value="' + val + '" class="form-control" maxlength="100" data-id="' + v + '" id="inputName' + v + '" onkeypress="saveFilterData(event,this,' + v + ')">');
        $("#inputName" + v).focus();
        $("#EditFilter" + v).html('<i class="material-icons">&#xE5D5;</i>');
        $("#EditFilter" + v).attr('title', 'Reset');
        $('#SaveFiltr' + v).show();
    } else {
        $('#name' + v).html("<span>" + val + "</span>");
        $("#EditFilter" + v).attr('title', _('Edit'));
        $("#EditFilter" + v).html('<i class="material-icons">&#xE254;</i>');
        $('#SaveFiltr' + v).hide();
    }
}

function saveFilterData(e, obj, v) {
    if (e.keyCode === 13 || e == 13) {
        $('#SaveFiltr' + v).hide();
        var value = $(obj).val();
        if (value.trim() != '') {
            $.post(HTTP_ROOT + 'searchFilters/editFilters', {
                id: v,
                value: value
            }, function(res) {
                if (res.type == 'success') {
                    showTopErrSucc('success', res.message);
                    $("#inputName" + v).remove();
                    $('#name' + v).html('<span>' + value + '</span>');
                    $('#SaveFiltr' + v).hide();
                } else {
                    showTopErrSucc('error', res.message);
                    $("#inputName" + v).closest("td").find("span").show();
                    $("#inputName" + v).remove();
                    $('#SaveFiltr' + v).show();
                }
                $("#EditFilter" + v).html('<i class="material-icons">&#xE254;</i>');
            }, 'json');
        } else {
            $('#SaveFiltr' + v).show();
            showTopErrSucc('error', _('Please enter a filter name'));
        }
    }
}

function saveFilterDataBtn(id) {
    saveFilterData(13, $("#inputName" + id), id);
}

function showDependents(id, uniqid, depends) {
    $("#task_dependent_block_" + uniqid).find('.showDependents').toggleClass('open ');
    if ($("#task_dependent_" + uniqid).find('.loader').length > 0) {
        var params = {
            id: id,
            uid: uniqid,
            deps: depends,
            mode: 'child'
        };
        $.ajax({
            url: HTTP_ROOT + "easycases/dependent_overview",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                $("#task_dependent_" + uniqid).find('li').remove();
                if (res.length > 0) {
                    $.each(res, function(key, val) {
                        var li = $('<li>').addClass('ellipsis-view').html($('<a>').attr({
                            'class': 'case-title',
                            'data-task': val.Easycase.uniq_id,
                            'id': 'titlehtmlt' + val.Easycase.id,
                            'title': val.Easycase.title
                        }).html('#' + val.Easycase.case_no + ": " + val.Easycase.title));
                        $("#task_dependent_" + uniqid).append(li);
                    });
                    msg = _("Task can't start. Waiting on these task to be completed.");
                } else {
                    var li = $('<li>').html($('<span>').attr({
                        'title': 'No Task Found'
                    }).html('No Task Found'));
                    $("#task_dependent_" + uniqid).append(li);
                    msg = _("All tasks has been closed.");
                }
                $("#task_dependent_" + uniqid).parent().closest('ul').find('.task_dependent_msg').html(msg);
            }
        });
    }
}

function showParents(id, uniqid, depends) {
    $("#task_parent_block_" + uniqid).find('.showParents').toggleClass('open ');
    if ($("#task_parent_" + uniqid).find('.loader').length > 0) {
        var params = {
            id: id,
            uid: uniqid,
            deps: depends,
            mode: 'parent'
        };
        $.ajax({
            url: HTTP_ROOT + "easycases/dependent_overview",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                $("#task_parent_" + uniqid).find('li').remove();
                if (res.length > 0) {
                    $.each(res, function(key, val) {
                        var li = $('<li>').addClass('ellipsis-view').html($('<a>').attr({
                            'class': 'case-title',
                            'data-task': val.Easycase.uniq_id,
                            'id': 'titlehtmlt' + val.Easycase.id,
                            'title': val.Easycase.title
                        }).html('#' + val.Easycase.case_no + ": " + val.Easycase.title));
                        $("#task_parent_" + uniqid).append(li);
                    });
                    msg = _("These tasks are waiting on this task.");
                } else {
                    var li = $('<li>').html($('<span>').attr({
                        'title': 'No Task Found'
                    }).html(_('No Task Found')));
                    $("#task_parent_" + uniqid).append(li);
                    msg = _("All tasks has been closed.");
                }
                $("#task_parent_" + uniqid).parent().closest('ul').find('.task_parent_msg').html(msg);
            }
        });
    }
}

function showSubtaskParents(id, uniqid, p_id) {
    $("#task_parent_id_block_" + uniqid).find('.showParents').toggleClass('open ');
    if ($("#task_parent_tt_" + uniqid).find('.loader').length > 0) {
        var params = {
            id: id,
            uid: uniqid,
            p_nt_uid: p_id,
        };
        $.ajax({
            url: HTTP_ROOT + "easycases/fetchParentTask",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                $("#task_parent_tt_" + uniqid).find('li').remove();
                if (res.message == '') {
                    var txt = '';
                    $.each(res.parent, function(key, val) {
                        if (key == 0) {
                            txt = '<span title="' + formatText(ucfirst(val.title)) + '" rel="tooltip" class="anchor case-title titlehtml subtask_elipse" data-task="' + val.uid + '">' + formatText(ucfirst(val.title)) + '</span>';
                        } else {
                            txt += ' <i class="material-icons case_symb">&#xE314;</i> ';
                            txt += '<span title="' + formatText(ucfirst(val.title)) + '" rel="tooltip" class="anchor case-title titlehtml subtask_elipse" data-task="' + val.uid + '">' + formatText(ucfirst(val.title)) + '</span>';
                        }
                    });
                    var li = $('<li>').addClass('ellipsis-view').html(txt);
                    $("#task_parent_tt_" + uniqid).append(li);
                } else {
                    var li = $('<li>').html($('<span>').attr({
                        'title': 'No Parent Task Found'
                    }).html(res.message));
                    $("#task_parent_tt_" + uniqid).append(li);
                }
            }
        });
    }
}

function viewPdfFile(id) {
    var strURL = HTTP_ROOT + 'easycases/viewPdfFile/';
    $('#caseLoader').show();
    $.post(strURL, {
        id: id
    }, function(res) {
        $('#caseLoader').hide();
        if (res.status == 'success') {
            if (res.type == 'local') {
                n = window.open(res.url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=10,left=10");
            } else {
                n = window.open(strURL + id, "_blank");
            }
            if (n == null) {
                return true;
            }
            return false;
        } else {
            showTopErrSucc('error', res.mesg);
        }
    }, 'json');
}

function openTimesheetExportPopup(userid, startdate, enddate) {
    openPopup();
    var selectizeR = $('#select-expt-resource').get(0).selectize;
    var selectizeP = $('#select-expt-proj').get(0).selectize;
    selectizeR.disable();
    selectizeP.clear();
    selectizeP.disable();
    $(".exp_timesheet_popup").show();
    $(".loader_bg_inline_expt").show();
    if (startdate != "" && typeof startdate != "undefined") {
        $("#expt_startDate").val(moment(startdate).format('MMM DD, YYYY'));
    }
    if (enddate != "" && typeof enddate != "undefined") {
        $("#expt_endDate").val(moment(enddate).format('MMM DD, YYYY'));
    }
    $.post(HTTP_ROOT + 'LogTimes/getAllUsersProjects/', {}, function(res) {
        $(".loader_bg_inline_expt").hide();
        selectizeR.enable();
        for (pi in res.resource) {
            if (res.resource[pi].name != '') {
                selectizeR.addOption({
                    value: res.resource[pi].id,
                    text: res.resource[pi].name
                });
            }
        }
        if (typeof userid != 'undefined') {
            selectizeR.setValue(userid);
        }
    }, 'json');
}
angular.module('commonMethods', []).factory('osCommonMethods', function() {
    var factory = {};
    factory.formatTitle = function(str) {
        return factory.escapeHtml(factory.html_entity_decode(str));
    }
    factory.escapeHtml = function(str) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return str.replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }
    factory.html_entity_decode = function(str) {
        return str.replace(/[<>'"]/g, function(m) {
            return '&' + {
                '\'': 'apos',
                '"': 'quot',
                '&': 'amp',
                '<': 'lt',
                '>': 'gt',
            } [m] + ';';
        });
    }
    factory.priArr = function(p) {
        var prior = new Array();
        prior = ['high', 'medium', 'low'];
        return prior[p];
    }
    factory.format_time_hr_min = function(totalsecs, mode) {
        if (mode == 'decimal') {
            val = Math.round(totalsecs / 3600, 2);
        } else if (mode == 'hrmin') {
            hours = Math.floor(totalsecs / 3600) > 0 ? Math.floor(totalsecs / 3600) : '0';
            mins = Math.round((totalsecs % 3600) / 60) > 0 ? Math.round((totalsecs % 3600) / 60) : '00';
            val = hours + ":" + strpad(2, mins, '0');
        } else {
            hours = Math.floor(totalsecs / 3600) > 0 ? Math.floor(totalsecs / 3600) + " hr" + (Math.floor(totalsecs / 3600) > 1 ? 's' : '') + " " : '';
            mins = Math.round((totalsecs % 3600) / 60) > 0 ? "" + Math.round((totalsecs % 3600) / 60) + " min" + (Math.round((totalsecs % 3600) / 60) > 1 ? 's' : '') : '';
            val = hours + "" + mins;
        }
        return val;
    }
    factory.formatHour = function(data) {
        number = data / 3600;
        numb = Number(number).toFixed(2);
        return (isNaN) ? '0.00' : numb;
    }
    factory.strpad = function(width, string, padding) {
        return (width <= string.length) ? string : pad(width, padding + string, padding)
    }
    return factory;
});

function displayAllAct(id, type) {
    $(".loaderAct").show();
    var strURL = HTTP_ROOT + "easycases/case_activity_thread";
    $.post(strURL, {
        "id": id,
        "type": type
    }, function(data) {
        $(".loaderAct").hide();
        if (data) {
            $(".activities_flowchat").find('.actvity_bar').html(tmpl("case_detail_right_activity_tmpl", data));
            if (type == "more") {
                $(".taskActivityAll").html('<a href="javascript:void(0)" onclick="displayAllAct(' + id + ',\'less\'' + ');">' + _("Display Less") + '</a>');
            } else if (type == "less") {
                $(".taskActivityAll").html('<a href="javascript:void(0)" onclick="displayAllAct(' + id + ',\'more\'' + ');">' + _("Display More") + '</a>');
            }
            $("img.lazy").lazyload({
                placeholder: HTTP_ROOT + "img/lazy_loading.png"
            });
        }
    }, 'json');
}

function reloadKanbanPage(uniqid) {
    if (uniqid.trim() == 'all') {
        window.location = HTTP_ROOT + 'dashboard#milestonelist';
        location.reload();
    } else if (uniqid.trim() == 'kanban') {
        window.location = HTTP_ROOT + 'dashboard#kanban';
        location.reload();
    } else {
        window.location = HTTP_ROOT + 'dashboard#kanban/' + uniqid;
    }
}

function openDrpdwn(id, obj, type) {
    $('.tgle_dropdown_menu').removeClass('active_drop');
    var listLeft = 0;
    if (type == 1) {
        var knban_prog_box_details = $("#tgle_dropdown_menu_" + id);
    } else {
        var knban_prog_box_details = $("#tgle_dropdown_menu" + id);
    }
    var item = $(obj),
        listLeft = (item.offset().left);
    knban_prog_box_details.css({
        left: listLeft - 190
    }).addClass('active_drop');
}

function creatask_inline(mid) {
    var div_string = '<div class="kb_task_det kbtask_div appended-tsk"><input type="text" value="" data-mid="' + mid + '" class="inline_qktask' + mid + ' in_qt_kanban" placeholder="Enter Task Title" onkeypress="save_inline_data(' + mid + ',event)" >\n<div><a href="javascript:void(0);" class="btn btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk" onclick="AddQuickTask(' + mid + ');" style="margin-top:0px; margin-bottom:0px;" >Add Task</a> <span class="in-del-tsk" onclick="delete_inline_tsk(this);"><i class="material-icons">&#xE5CD;</i></span></div></div>';
    if ($("#milestone_" + mid).find('.kanban_content').find('.appended-tsk').length == 0) {
        $("#milestone_" + mid).find('.kanban_content').prepend(div_string);
    }
}

function delete_inline_tsk(obj) {
    $(obj).parents('.appended-tsk').remove();
}

function save_inline_data(mid, e) {
    if (e.keyCode === 13) {
        AddQuickTask(mid);
        $('.appended-tsk').hide();
    }
}

function calltoquicktask(mid, typ, e) {
    if (e.keyCode === 13) {
        AddQuickTask(mid, typ);
    }
}

function addQuickTaskBtn(mid) {
    if ($.trim($('.add_task_fld_kbn').val()) == '') {
        $('.add_task_fld_kbn').focus();
        return false;
    }
    if (mid != '0') {
        AddQuickTask(mid, 'tg');
    } else {
        AddQuickTask('', '', 'sts');
    }
}

function show_add_tgle_fld() {
    if (typeof arguments[0] != 'undefined') {
        $('.add_tgle_fld_' + arguments[0]).show();
        $('.tgle_addnew_' + arguments[0]).hide();
        $('.inline_qktask' + arguments[0]).focus();
    } else {
        $('.add_tgle_fld').show();
        $('.tgle_addnew').hide();
        $('.add_task_fld_kbn').focus();
    }
}

function hide_add_tgle_fld() {
    if (typeof arguments[0] != 'undefined') {
        $('.add_tgle_fld_' + arguments[0]).hide();
        $('.tgle_addnew_' + arguments[0]).show();
    } else {
        $('.add_tgle_fld').hide();
        $('.tgle_addnew').show();
    }
}

function createStatusNewKbn(id) {
    openPopup();
    $('#label_title_sts').text(_('Create New Status'));
    $('#createWorkFlowStatus').show();
    $("#task_status_content").html('<div style="width:100%; padding:20px; text-align:center"><img src="' + HTTP_ROOT + 'img/loading2.gif"></div>');
    $.post(HTTP_ROOT + 'projects/crate_new_status', {
        id: btoa(id),
        'from_page': 'kanban'
    }, function(res) {
        $("#task_status_content").html(res);
    });
}
(function() {
    var module = angular.module('anyOtherClick', []);
    var directiveName = "anyOtherClick";
    module.directive(directiveName, ['$document', "$parse", function($document, $parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attr, controller) {
                var anyOtherClickFunction = $parse(attr[directiveName]);
                var documentClickHandler = function(event) {
                    var eventOutsideTarget = (element[0] !== event.target) && (0 === element.find(event.target).length);
                    if (eventOutsideTarget) {
                        scope.$apply(function() {
                            anyOtherClickFunction(scope, {});
                        });
                    }
                };
                $document.on("click", documentClickHandler);
                scope.$on("$destroy", function() {
                    $document.off("click", documentClickHandler);
                });
            },
        };
    }]);
})();

function setCaseFavourite(id, pid, cuid, type, datatype) {
    if (id != '' && pid != '') {
        var strURL = HTTP_ROOT + 'easycases/setCaseFavourite';
        $.ajax({
						url:strURL,
            dataType: "json",
            type: "POST",
            data: {
                'id': id,
                'project_id': pid,
                'taskUid': cuid
            },
            success: function(res) {
                if (res.status) {
                    if (res.class == 'starline_icon') {
                        $('#fav_span').removeClass('starfill_icon');
                        $('#fav_span').addClass('starline_icon');
                        $('#t_fav').attr('original-title', 'Set favourite task');
                    }
                    if (res.class == 'starfill_icon') {
                        $('#fav_span').removeClass('starline_icon');
                        $('#fav_span').addClass('starfill_icon');
                        $('#t_fav').attr('original-title', 'Remove from the favourite task');
                    }
                    var varifydiv = getCookie('CURRENT_FILTER');
                    if (varifydiv == 'favourite') {
                        var caseMenuFilters = $('#caseMenuFilters').val();
                        var projFil = $('#projFil').val();
                        loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                            "projUniq": projFil,
                            "pageload": 0,
                            "page": "dashboard",
                            "filters": caseMenuFilters
                        });
                    }
                    var urlHash = getHash();
                    if (urlHash == 'tasks' || urlHash == 'taskgroup' || urlHash == 'backlog' || urlHash == 'details' || urlHash == 'taskgroups') {
                        var like_txt = $.trim($('#tskTabFavCnt').html());
                        like_txt = parseInt(like_txt.replace(/[{()}]/g, ''));
                        if (datatype == 1) {
                            like_txt = like_txt - 1;
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',0)" rel="tooltip" original-title="Set favourite task" style="color:#888888;"><i class="material-icons" style="font-size:18px;color:#888888;">star_border</i></a>';
                            $("#caseProjectSpanFav" + id).html(str);
                        } else {
                            like_txt = like_txt + 1;
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',1)" rel="tooltip" original-title="Remove from the favourite task" style="color:#FFDC77;"><i class="material-icons" style="font-size:18px;color:#FFDC77;">star</i></a>';
                            $("#caseProjectSpanFav" + id).html(str);
                        }
                        $('#tskTabFavCnt').html('(' + like_txt + ')');
                    } else if (urlHash == 'kanban' || urlHash == 'milestonelist' || urlHash.indexOf("kanban") >= 0) {
                        if (datatype == 1) {
                            $("#kanbanDivFav" + id).attr('title', _('Set favourite task'));
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',0)" rel="tooltip" original-title="Set favourite task" style="margin-top:0px;color:#888888;"><i class="material-icons" style="font-size:18px;color:#888888;">star_border</i></a>';
                            $("#kanbanDivFav" + id).html(str);
                        } else {
                            $("#kanbanDivFav" + id).attr('title', _('Remove from the favourite task'));
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',1)" rel="tooltip" original-title="Remove from the favourite task" style="margin-top:0px;color:#FFDC77;"><i class="material-icons" style="font-size:18px;color:#FFDC77;">star</i></a>';
                            $("#kanbanDivFav" + id).html(str);
                        }
                    }
                    if (type == 2) {
                        if (datatype == 1) {
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',0)" rel="tooltip" original-title="Set favourite task" style="color:#888888;"><i class="material-icons" style="color:#888888;">star_border</i></a>';
                            $("#caseDetailsSpanFav" + id).html(str);
                        } else {
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',1)" rel="tooltip" original-title="Remove from the favourite task" style="color:#FFDC77;"><i class="material-icons" style="color:#FFDC77;">star</i></a>';
                            $("#caseDetailsSpanFav" + id).html(str);
                        }
                        var like_txt = $.trim($('#tskTabFavCnt').html());
                        like_txt = parseInt(like_txt.replace(/[{()}]/g, ''));
                        if (datatype == 1) {
                            like_txt = like_txt - 1;
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',0)" rel="tooltip" original-title="Set favourite task" style="color:#888888;"><i class="material-icons" style="font-size:18px;color:#888888;">star_border</i></a>';
                            $("#caseProjectSpanFav" + id).html(str);
                        } else {
                            like_txt = like_txt + 1;
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',1)" rel="tooltip" original-title="Remove from the favourite task" style="color:#FFDC77;"><i class="material-icons" style="font-size:18px;color:#FFDC77;">star</i></a>';
                            $("#caseProjectSpanFav" + id).html(str);
                        }
                        $('#tskTabFavCnt').html('(' + like_txt + ')');
                    } else if (type == 4) {
                        if (datatype == 1) {
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',0)" rel="tooltip" original-title="Set favourite task" style="color:#888888;"><span id="fav_icon" class="cmn_tskd_sp starline_icon"></span>Favorite</a>';
                            $("#caseDetailsSpanFav" + id).html(str);
                        } else {
                            var str = '<a href="javascript:void(0);" class="caseFav" onclick="setCaseFavourite(' + id + ',' + pid + ',\'' + cuid + '\',' + type + ',1)" rel="tooltip" original-title="Remove from the favourite task" style="color:#888888;"><span id="fav_icon" class="cmn_tskd_sp starfill_icon"></span>Favorite</a>';
                            $("#caseDetailsSpanFav" + id).html(str);
                        }
                    }
                }
                $("[rel='tooltip']").tipsy({
                    gravity: 's'
                });
            }
        });
    } else {
        showTopErrSucc('error', _('Sorry, Something is wrong try after sometimes.'));
    }
}

function openSubTaskView() {
    $('title').html(_('Task') + ' | ' + _('Subtask'));
    $('#subtask-container').height('100%');
    $("#subtask_page_count").val(1);
    ajaxCaseSubtaskView();
    $('body').css('overflow-y', 'hidden');
}

function closeSubTaskView() {
    var urlHash = getHash();
    if (urlHash == 'tasks') {
        $('title').html(_('Task'));
    } else if (urlHash == 'kanban') {
        $('title').html(_('Task') + ' | ' + _('Kanban'));
    } else if (urlHash == 'calendar') {
        $('title').html(_('Task') + ' | ' + _('Calendar'));
    }
    $('#subtask-container').height('0%');
    $('body').css('overflow-y', 'auto');
    setTimeout(function() {
        easycase.refreshTaskList();
    }, 500);
}
var allSubtasks = null;

function ajaxCaseSubtaskView() {
    allSubtasks = null;
    localStorage.setItem("nextSubtasks", 0);
    if (typeof arguments[0] != 'undefined') {
        var casePage = $("#subtask_page_count").val();
        var casePage = parseInt(casePage) + 1;
    } else {
        casePage = 1;
    }
    var projFil = $('#projFil').val();
    var caseId = $('#caseId').val();
    var startCaseId = $('#caseStart').val();
    var caseResolve = $('#caseResolve').val();
    var caseNew = $('#caseNew').val();
    var caseChangeType = $('#caseChangeType').val();
    var caseChangePriority = $('#caseChangePriority').val();
    var caseChangeDuedate = $('#caseChangeDuedate').val();
    var caseChangeAssignto = $('#caseChangeAssignto').val();
    var customfilter = $('#customFIlterId').val();
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseDate = $('#caseDate').val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var taskgroup_fil = '';
    var hashtag = parseUrlHash(urlHash);
    var caseSearch = $("#case_search").val();
    if ((caseSearch != null) && (caseSearch.trim() == '')) {
        caseSearch = $('#caseSearch').val();
    } else {
        $("#caseSearch").val(caseSearch);
    }
    $("#case_search").val("");
    clearSearchvis();
    var caseTitle = $('#caseTitle').val();
    var caseDueDate = $('#caseDueDate').val();
    var caseEstHours = $('#caseEstHours').val();
    var caseNum = $('#caseNum').val();
    var caseLegendsort = $('#caseLegendsort').val();
    var caseAtsort = $('#caseAtsort').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    var caseCreateDate = $('#caseCreatedDate').val();
    var projIsChange = $('#projIsChange').val();
    var checktype = $("#checktype").val();
    var detailscount = 0;
    var mstype = "";
    if (caseMenuFilters == 'milestone') {
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
    }
    var searchMilestoneUid = '';
    var caseUrl = "";
    if (!$('#caseLoaderPopupKB').is(':visible')) {
        $('#caseLoader').show().css('zIndex', 999999);
    }
    var strURL = HTTP_ROOT + 'requests/';
    var strAction = 'case_subtask_list';
    $.post(strURL + strAction, {
        projFil: projFil,
        caseStatus: caseStatus,
        caseCustomStatus: caseCustomStatus,
        customfilter: customfilter,
        caseChangeAssignto: caseChangeAssignto,
        caseChangeDuedate: caseChangeDuedate,
        caseChangePriority: caseChangePriority,
        caseChangeType: caseChangeType,
        mstype: mstype,
        priFil: priFil,
        caseTypes: caseTypes,
        caseLabel: caseLabel,
        caseMember: caseMember,
        caseComment: caseComment,
        caseAssignTo: caseAssignTo,
        caseDate: caseDate,
        caseSearch: caseSearch,
        casePage: casePage,
        caseId: caseId,
        caseTitle: caseTitle,
        caseDueDate: caseDueDate,
        caseEstHours: caseEstHours,
        caseNum: caseNum,
        caseLegendsort: caseLegendsort,
        caseAtsort: caseAtsort,
        startCaseId: startCaseId,
        caseResolve: caseResolve,
        caseNew: caseNew,
        caseMenuFilters: caseMenuFilters,
        caseUrl: caseUrl,
        detailscount: detailscount,
        milestoneIds: milestoneIds,
        case_srch: case_srch,
        case_date: case_date,
        'case_due_date': case_due_date,
        caseCreateDate: caseCreateDate,
        projIsChange: projIsChange,
        searchMilestoneUid: searchMilestoneUid,
        caseNew: caseNew
    }, function(res) {
        $('#caseLoader').hide().css('zIndex', '');
        allSubtasks = res;
        $("#case-sub-task-container").html(tmpl("case_subtask_view_tmpl", res));
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
            "projUniq": (projFil == '0') ? 'all' : projFil,
            "pageload": 0,
            "caseMenuFilters": caseMenuFilters,
            'case_date': case_date,
            'case_due_date': case_due_date,
            'caseStatus': caseStatus,
            'caseTypes': caseTypes,
            'caseLabel': caseLabel,
            'priFil': priFil,
            'caseMember': caseMember,
            'caseComment': caseComment,
            'caseAssignTo': caseAssignTo,
            'caseSearch': caseSearch,
            'milestoneIds': milestoneIds,
            'checktype': checktype
        }, function(data) {
            if (data) {
                $('#ajaxCaseStatus_subtask').html(data);
                $('#ajaxCaseStatus_subtask').html(tmpl("case_widget_tmpl", data));
                $('[rel=tooltip]').tipsy({
                    gravity: 's',
                    fade: true
                });
                $("#upperDiv_not").hide();
                var statusnot = $('#not_sts').html();
                var n = '';
                if (caseMenuFilters != 'milestone' && caseMenuFilters != 'closecase' && n == -1) {
                    var closed = $("#closedcaseid").val();
                    if (closed != 0) {
                        $("#upperDiv_not").show();
                        if (closed == 1) {
                            $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("task"));
                        } else {
                            $("#closedcases").html(_("Including") + " <b>" + closed + "</b> '" + _("Closed") + "' " + _("tasks"));
                        }
                    } else {
                        $("#upperDiv_not").hide();
                        $("#closedcases").html('');
                    }
                }
                $('.f-tab').tipsy({
                    gravity: 'n',
                    fade: true
                });
            }
        });
        setTimeout(function() {
            resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 1, case_date, case_due_date, '', '', '', '', milestoneIds, caseLabel);
        }, 100);
        $("#chkAllTskSubtask").click(function() {
            $('#case-sub-task-container').find('.chkOneTsk:not(:disabled)').prop('checked', this.checked);
        });
        $('#case-sub-task-container').on('click', '.chkOneTsk:not(:disabled)', function() {
            if ($(this).is(":checked")) {
                var isAllChecked = 0;
                $('#case-sub-task-container').find('.chkOneTsk:not(:disabled)').each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                });
                if (isAllChecked == 0) {
                    $("#chkAllTskSubtask").prop("checked", true);
                }
            } else {
                $("#chkAllTskSubtask").prop("checked", false);
            }
        });
        var caseId = $('#caseId').val();
        var startCaseId = $('#caseStart').val();
        var caseResolve = $('#caseResolve').val();
        var caseNew = $('#caseNew').val();
        if (res.errormsg) {
            showTopErrSucc('error', res.errormsg);
        } else if (caseId) {
            $('#caseId').val('');
            var chk = caseId.indexOf(",");
            if (chk != -1) {
                showTopErrSucc('success', _('Tasks are closed.'));
            } else {
                showTopErrSucc('success', _('Task is closed.'));
            }
        } else if (startCaseId) {
            $('#caseStart').val('');
            var chk = startCaseId.indexOf(",");
            if (chk != -1) {
                showTopErrSucc('success', _('Tasks are started.'));
            } else {
                showTopErrSucc('success', _('Task is started.'));
            }
        } else if (caseResolve) {
            $('#caseResolve').val('');
            var chk = caseResolve.indexOf(",");
            if (chk != -1) {
                showTopErrSucc('success', _('Tasks are resolved.'));
            } else {
                showTopErrSucc('success', _('Task is resolved.'));
            }
        } else if (caseNew) {
            $('#caseNew').val('');
            var chk = caseNew.indexOf(",");
            if (chk != -1) {
                showTopErrSucc('success', _('Status of tasks are changed to new.'));
            } else {
                showTopErrSucc('success', _('Task status is changed to new.'));
            }
        }
        $("#subtask_page_count").val(casePage);
        $("#subtask_page_total").val(res.totPages);
        $("#pname_dashboard_subtask").html($("#pname_dashboard").html());
        subtaskAfterRender();
        $('#subtask-container').on('scroll', function() {
            if (Math.round($(this).scrollTop()) + Math.round($(this).innerHeight()) >= (parseInt($(this)[0].scrollHeight) - 1)) {
                ajaxCaseSubtaskViewPagination();
            }
        })
    }, 'json');
}

function ajaxCaseSubtaskViewPagination() {
    var res1 = allSubtasks;
    res1.resCaseProj = res1.resCaseProj.slice(20);
    res1.casePage = 2;
    if (res1.resCaseProj.length) {
        $("#subtaskBody").append(tmpl("case_subtask_view_tmpl", res1));
        subtaskAfterRender();
    }
}

function subtaskAfterRender() {
    $("img.lazy").lazyload({
        placeholder: HTTP_ROOT + "img/lazy_loading.png"
    });
    $.material.init();
    $('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').on('mouseenter', function() {
        $(this).attr('aria-expanded', true);
        $(this).parent().addClass('open');
    });
    $('.row_tr').on('mouseleave', function() {
        $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', false);
        $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().removeClass('open');
    });
}

function convertToParentTask(curCaseId) {
    var projFil = $("#projFil").val();
    var url = HTTP_ROOT + 'easycases/ajax_convert_to_parent_task';
    var hashtag = parseUrlHash(urlHash);
    if (confirm(_("Are you sure you want to convert to parent task?"))) {
        $('#caseLoader').show();
        $.post(url, {
            curCaseId: curCaseId,
        }, function(data) {
            if (data.success) {
                $('#caseLoader').hide();
                showTopErrSucc('success', data.msg);
                if (hashtag[0] == 'kanban') {
                    getkanbanCounts();
                    tasklisttmplAdd(curCaseId, 0, 'sts');
                    easycase.showKanbanTaskList('kanban');
                } else if (hashtag[0] == 'taskgroups') {
                    $("#empty_milestone_tr_thread" + data.task_milestone_id).find('.os_sprite' + data.task_milestone_id).trigger('click');
                    setTimeout($("#empty_milestone_tr_thread" + data.task_milestone_id).find('.os_sprite' + data.task_milestone_id).trigger('click'), 5000);
                } else {
                    tasklisttmplAdd(curCaseId);
                }
            } else {
                $('#caseLoader').hide();
                showTopErrSucc('error', data.msg);
            }
        }, 'json');
    }
    return false;
}

function convertToSubTask(id, project_id, case_no) {
    var project_id = project_id;
    var case_id = id;
    var case_no = case_no;
    var title = $(".case-title-kbn-" + case_id + " span:first-child").text();
    if (typeof title == 'undefined' || title == '') {
        if ($(".case_title_" + case_id + " span").length) {
            title = $(".case_title_" + case_id + " span:first-child").text();
        } else if ($("#titlehtml" + id + " span").length) {
            title = $("#titlehtml" + id + " span:first-child").text();
        } else {
            title = $("#titlehtml" + id).text();
        }
        title = $.trim(title);
    }
    titlearr = title.split(": ");
    if (titlearr[0].indexOf('#') == 0) {
        titlearr[0] = titlearr[0].replace(new RegExp("\\d", "g"), "").replace("#", "");
        title = titlearr.join(" ");
    }
    if (title.length > 60)
        title = jQuery.trim(title).substring(0, 37).split(" ").slice(0, -1).join(" ") + "...";
    if (getCookie('TASKGROUPBY') == 'milestone') {
        $('#header_mk_tsk_sbtsk').text("Convert " + title + " to sub task");
    } else if ($('#caseMenuFilters').val() == 'kanban' || $('#caseMenuFilters').val() == 'milestonelist') {
        $('#header_mk_tsk_sbtsk').text("Convert " + title + " to sub task");
    } else {
        $('#header_mk_tsk_sbtsk').text("Convert #" + case_no + ": " + title + " to sub task");
    }
    $('#caseLoader').show();
    $.post(HTTP_ROOT + "easycases/ajax_get_task_list", {
        "project_id": project_id,
        "case_id": case_id,
    }, function(data) {
        if (data) {
            $('#caseLoader').hide();
            if (data === "not_possible") {
                var msg = _("Task already have Sub Sub Task ! So it cannot be changed to Sub Task");
                showTopErrSucc('error', msg);
            } else {
                openPopup();
                $(".mk_tsk_sbtsk").show();
                $('#inner_mk_tsk_sbtsk').html('');
                $(".loader_dv").hide();
                $('#inner_mk_tsk_sbtsk').show();
                $('#inner_mk_tsk_sbtsk').html(data);
                $.material.init();
                $(".select").select2();
            }
        }
    });
}

function makeTaskToSubTask() {
    var prj_id = $("#tsk_projectid").val();
    var slct_prnt_tsk_id = $("#new_parent_task").val();
    var slct_prnt_tsk_nm = $('#new_parent_task :selected').text();
    var hashtag = parseUrlHash(urlHash);
    var case_id = $("#tsk_id").val();
    if (1) {
        $("#mksbtsk_btn").hide();
        $(".make_task_to_subtask").find('.close').hide();
        $("#mksbtskloader").show();
        $.post(HTTP_ROOT + "easycases/make_task_to_subtask", {
            "project_id": prj_id,
            "parent_task_id": slct_prnt_tsk_id,
            "task_id": case_id,
        }, function(res) {
            $(".make_task_to_subtask").find('.close').show();
            if (res.message == 'success') {
                showTopErrSucc('success', res.msg);
                if (hashtag[0] == 'kanban') {
                    getkanbanCounts();
                    tasklisttmplAdd(case_id, 0, 'sts');
                    easycase.showKanbanTaskList('kanban');
                    closePopup();
                } else {
                    if (hashtag[0] == 'tasks') {
                        var groupby = getCookie('TASKGROUPBY');
                        if (groupby == 'milestone') {
                            var curRow = "curRow" + case_id;
                            $("#" + curRow).fadeOut(500, function() {
                                var html = $(this).html();
                                var pid = $(this).attr('data-pid');
                                if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).next('tr.white_bg_tr')) {
                                    $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).next('tr.white_bg_tr').after('<tr id="curRow' + case_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + res.parent_milestone_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                } else {
                                    $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).after('<tr id="curRow' + case_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + res.parent_milestone_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                }
                                $('tr#curRow' + case_id).find('div.checkbox').find('span.checkbox-material:nth-of-type(2)').remove();
                                $(this).remove();
                            });
                            if (res.child_task_list.length > 0) {
                                for (var i in res.child_task_list) {
                                    var curRow = "curRow" + res.child_task_list[i];
                                    $("#" + curRow).fadeOut(500, function() {
                                        var html = $(this).html();
                                        var pid = $(this).attr('data-pid');
                                        if ($('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).next('tr.white_bg_tr')) {
                                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).next('tr.white_bg_tr').after('<tr id="curRow' + case_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + res.parent_milestone_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                        } else {
                                            $('#caseViewSpan').find('table').find('tr#empty_milestone_tr' + res.parent_milestone_id).after('<tr id="curRow' + case_id + '" class="tr_all row_tr trans_row tgrp_tr_all" data-mid="' + res.parent_milestone_id + '" data-pid="' + pid + '">' + html + '</tr>');
                                        }
                                        $('tr#curRow' + case_id).find('div.checkbox').find('span.checkbox-material:nth-of-type(2)').remove();
                                        $(this).remove();
                                    });
                                }
                            }
                        } else {
                            tasklisttmplAdd(case_id);
                        }
                    } else if (hashtag[0] == 'taskgroups') {
                        if (res.parent_milestone_id == res.child_milestone_id) {
                            showTaskByTaskGroupNew();
                        } else {
                            if ($("#empty_milestone_tr_thread" + res.parent_milestone_id).find('.os_sprite' + res.parent_milestone_id).hasClass('minus-plus')) {
                                $("#empty_milestone_tr_thread" + res.parent_milestone_id).find('.os_sprite' + res.parent_milestone_id).trigger('click');
                            } else {
                                $("#empty_milestone_tr_thread" + res.parent_milestone_id).find('.os_sprite' + res.parent_milestone_id).trigger('click');
                                setTimeout($("#empty_milestone_tr_thread" + res.parent_milestone_id).find('.os_sprite' + res.parent_milestone_id).trigger('click'), 5000);
                            }
                            $("#empty_milestone_tr_thread" + res.child_milestone_id).find('.os_sprite' + res.child_milestone_id).trigger('click');
                            setTimeout($("#empty_milestone_tr_thread" + res.child_milestone_id).find('.os_sprite' + res.child_milestone_id).trigger('click'), 5000);
                        }
                    }
                    closePopup();
                }
            } else {
                $("#mksbtsk_btn").show();
                $("#mksbtskloader").hide();
                showTopErrSucc('error', res.msg);
                return false;
            }
        }, 'json');
    } else {
        return false;
    }
}
easycase.showtaskgroups = function(task_data) {
    $('#caseLoader').show();
    ajaxCaseView('taskgroups');
}

function showhideMilestoneLeftMenu() {
    if (parseInt(localStorage.getItem("subtask_miilestone_toggle"))) {
        $('.milestone_slide_toggle').hide();
        $('.slide_switch_container').css('margin-left', '0px');
        $('.slide_switch_container').addClass('active_slide');
        $('.milestone_side_view').show();
    } else {
        $('.milestone_slide_toggle').show();
        $('.slide_switch_container').css('margin-left', '15px');
        $('.slide_switch_container').removeClass('active_slide');
        $('.milestone_side_view').hide();
    }
}

function clearSubtakMilFiletr() {
    localStorage.setItem("subtask_miilestone", '');
    showTaskByTaskGroupNew();
}
var allSubTaskLists = null;
var allSubTaskListsCnt = 0;

function showTaskByTaskGroupNew() {
    var check_load = (typeof arguments[0] != 'undefined') ? 0 : 1;
    $("#caseLoader").show();
    allSubTaskLists = null;
    var types = '';
    var url = HTTP_ROOT + 'requests/ajaXLoadTaskByTaskgroup';
    var projFil = $("#projFil").val();
    var caseId = $('#caseId').val();
    var startCaseId = $('#caseStart').val();
    var caseResolve = $('#caseResolve').val();
    var caseChangeType = $('#caseChangeType').val();
    var caseChangePriority = $('#caseChangePriority').val();
    var caseChangeDuedate = $('#caseChangeDuedate').val();
    var caseChangeAssignto = $('#caseChangeAssignto').val();
    var customfilter = $('#customFIlterId').val();
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseDate = $('#caseDate').val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var taskgroup_fil = '';
    var hashtag = parseUrlHash(urlHash);
    var caseSearch = $("#inner-search").val();
    var caseTitle = $('#caseTitle').val();
    var caseDueDate = $('#caseDueDate').val();
    var caseNum = $('#caseNum').val();
    var caseLegendsort = $('#caseLegendsort').val();
    var caseAtsort = $('#caseAtsort').val();
    var caseMenuFilters = $('#caseMenuFilters').val();
    var milestoneIds = $('#milestoneIds').val();
    var case_srch = $('#case_srch').val();
    var caseCreateDate = $('#caseCreatedDate').val();
    var projIsChange = $('#projIsChange').val();
    var caseUrl = "";
    var detailscount = 0;
    var reply = 0;
    var mstype = "";
    var mlstype = $('#checktype').val();
    if (mlstype == 'completed') {
        var mstype = 0;
    } else {
        var mstype = 1;
    }
    if (projIsChange != projFil) {
        localStorage.setItem("subtask_miilestone", '');
    }
    var selected_mid = localStorage.getItem("subtask_miilestone");
    if (selected_mid == 'default') {
        selected_mid = 0;
    }
    if (LANG_PREFIX == '_fra') {
        GBl_tour = tour_fra;
    } else if (LANG_PREFIX == '_por') {
        GBl_tour = tour_por;
    } else if (LANG_PREFIX == '_spa') {
        GBl_tour = tour_spa;
    } else if (LANG_PREFIX == '_deu') {
        GBl_tour = tour_deu;
    } else {
        GBl_tour = tour;
    }
    $.post(url, {
        mid: selected_mid,
        projFil: projFil,
        caseStatus: caseStatus,
        caseCustomStatus: caseCustomStatus,
        customfilter: customfilter,
        caseChangeAssignto: caseChangeAssignto,
        caseChangeDuedate: caseChangeDuedate,
        caseChangePriority: caseChangePriority,
        caseChangeType: caseChangeType,
        mstype: mstype,
        priFil: priFil,
        caseTypes: caseTypes,
        caseLabel: caseLabel,
        caseMember: caseMember,
        caseComment: caseComment,
        caseAssignTo: caseAssignTo,
        caseDate: caseDate,
        caseSearch: caseSearch,
        casePage: casePage,
        caseId: caseId,
        caseTitle: caseTitle,
        caseDueDate: caseDueDate,
        caseNum: caseNum,
        caseLegendsort: caseLegendsort,
        caseAtsort: caseAtsort,
        startCaseId: startCaseId,
        caseResolve: caseResolve,
        caseMenuFilters: caseMenuFilters,
        caseUrl: caseUrl,
        detailscount: detailscount,
        milestoneIds: milestoneIds,
        case_srch: case_srch,
        case_date: case_date,
        'case_due_date': case_due_date,
        caseCreateDate: caseCreateDate,
        projIsChange: projIsChange,
        viewType: ''
    }, function(res) {
        allSubTaskLists = res;
        allSubTaskListsCnt = allSubTaskLists.resCaseProj.length;
        $("#caseLoader").hide();
        if (types == "more") {} else {
            $("#caseViewSpan").html(tmpl("case_subtaskview_tmpl", res));
            $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)" onClick="showHideTopNav();"><i class="material-icons">&#xE065;</i> ' + _('Subtask View') + '</a>');
            if (localStorage.getItem("tour_open_chk") == '1') {
                localStorage.setItem("tour_open_chk", '0');
                if ($.trim(LANG_PREFIX) != '') {
                    GBl_tour = onbd_tour_mngwork + LANG_PREFIX;
                } else {
                    GBl_tour = onbd_tour_mngwork;
                }
                hopscotch.startTour(GBl_tour);
            }
            if (allSubTaskLists.resCaseProj.length > $('#subtaskListBody').find('tr.parent_tr').length) {
                $('#subtask-load-more').show();
            } else {
                $('#subtask-load-more').hide();
            }
            $('#subtask-load-more').on('click', function() {
                ajaxSubtaskListViewPagination();
            });
            remember_filters('SUBTASKVIEW', 'subtaskview');
        }
        $('.milestone_slide_toggle').off().on('click', function(e) {
            localStorage.setItem("subtask_miilestone_toggle", 1);
            showhideMilestoneLeftMenu();
        });
        $('.slide_switch_container .milestone_side_view .close_icon').off().on('click', function(e) {
            localStorage.setItem("subtask_miilestone_toggle", '');
            showhideMilestoneLeftMenu();
        });
        showTaskGroupsList();
        showhideMilestoneLeftMenu();
        easycase.routerHideShow('tasks');
        $('#detail_section').html('');
        $.material.init();
        $('input[id^="est_hr_sub_list"]').off().on('keyup', function(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode;
            if (unicode == 13) {
                var id = $(this).attr('data-est-id');
                var uid = $(this).attr('data-est-uniq');
                var cno = $(this).attr('data-est-no');
                var tim = $(this).attr('data-est-time');
                changeEstHourSubTaskListPage(id, uid, cno, tim);
            }
        });
        localStorage.setItem("ckl_chks", 0);
        $('input[id^="est_hr_sub_list"]').on('blur', function(e) {
            var d_val = $(this).attr('data-default-val');
            var d_val_orig = $(this).val();
            if (localStorage.getItem("ckl_chks") == '0') {
                if (d_val == d_val_orig) {
                    $(this).closest('.estblists').size() > 0 ? '' : $('.estblists').show();
                    $('.est_hr_sub_list').hide();
                }
            }
        });
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
        iniDateFilter();
        $("div [id^='set_due_date_']").each(function(i) {
            $(this).datepicker({
                altField: "#CS_due_date",
                startDate: new Date(),
                todayHighlight: true,
                format: 'mm/dd/yyyy',
                hideIfNoPrevNext: true,
                autoclose: true
            }).on('changeDate', function(e) {
                var caseId = $(this).attr('data-csatid');
                var datelod = "datelod" + caseId;
                var showUpdDueDate = "showUpdDueDate" + caseId;
                var old_duetxt = $("#" + showUpdDueDate).html();
                $("#" + showUpdDueDate).html("");
                $("#" + datelod).show();
                var text = '';
                var vobj = $(this);
                var dateText = $(this).datepicker('getFormattedDate');
                $(this).val('');

                commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj);

            });
        });
        expandLeftSubmenu();
        clearSearchvis();
        setTimeout(function() {
            loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                "projUniq": projFil,
                "pageload": 0,
                "page": "dashboard",
                "filters": caseMenuFilters,
                'case_date': case_date,
                'case_due_date': case_due_date,
                'caseStatus': caseStatus,
                'caseCustomStatus': caseCustomStatus,
                'caseTypes': caseTypes,
                'caseLabel': caseLabel,
                'priFil': priFil,
                'caseMember': caseMember,
                'caseComment': caseComment,
                'caseAssignTo': caseAssignTo,
                'caseSearch': caseSearch,
                'milestoneIds': milestoneIds,
                'checktype': checktype
            });
        }, 300);
        notShowEmptyDropdown();
        if ($.trim($('#inner-search').val()) != '') {
            $('#inner-search').addClass('open').css('width', '200px');
        }
        $('#caseViewSpan').show();
        $('#caseViewDetails').hide();
        var caseId = $('#caseId').val();
        var startCaseId = $('#caseStart').val();
        var caseResolve = $('#caseResolve').val();
        var caseNew = $('#caseNew').val();
        var usrUrl = HTTP_ROOT + "users/";
        var url = HTTP_ROOT + "easycases/";
        var filter = $('#caseMenuFilters').val();
        var projFil = $('#projFil').val();
        var projIsChange = $('#projIsChange').val();
        $('#projIsChange').val(projFil);
        var ischange = 0;
        if (caseMenuFilters && caseMenuFilters != "files") {
            ischange = 1;
        }
        var checktype = $("#checktype").val();
        var caseMenuFilters = $('#caseMenuFilters').val();
        setTimeout(function() {
            restcasestatus(projFil, caseMenuFilters, case_date, case_due_date, caseStatus, caseCustomStatus, caseTypes, priFil, caseMember, caseComment, caseAssignTo, caseSearch, milestoneIds, checktype, caseLabel);
        }, 100);
        setTimeout(function() {
            if (caseId || startCaseId || caseResolve || caseNew) {
                resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 1, case_date, case_due_date, '', '', '', '', milestoneIds, caseLabel);
            }
            if (!caseId && !startCaseId && !caseResolve && !caseNew) {
                var clearCaseSearch = $('#clearCaseSearch').val();
                var isSort = $('#isSort').val();
                $('#clearCaseSearch').val('');
                resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 0, case_date, case_due_date, casePage, caseSearch, clearCaseSearch, caseMenuFilters, milestoneIds, caseLabel);
                downloadFile();
            }
        }, 100);
        changeCBStatus();
        $('.show_all_opt_in_listonly').hide();
    }, 'json');
}

function ajaxSubtaskListViewPagination() {
    $('#subtask-load-more').text('Loading tasks...');
    var res1 = allSubTaskLists;
    res1.resCaseProj = res1.resCaseProj.slice(res1.page_limit);
    res1.casePage = 2;
    if (res1.resCaseProj.length) {
        $("#subtaskListBody").append(tmpl("case_subtaskview_tmpl", res1));
        $.material.init();
        if ($('#subtaskListBody').find('tr.parent_tr').length >= allSubTaskListsCnt) {
            $('#subtask-load-more').hide();
        } else {
            $('#subtask-load-more').show();
        }
        $('#subtask-load-more').text('Load More Task');
    } else {
        $('#subtask-load-more').hide();
    }
}

function subtaskFilterByMilestone(mid) {
    if (mid == '0') {
        mid = 'default';
    }
    localStorage.setItem("subtask_miilestone", mid);
    showTaskByTaskGroupNew('milestone');
}

function searchMilestoneItems(obj, e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    e.stopPropagation();
    var val = $(obj).val().toUpperCase();
    $('#milestone_list_table').find('tr.togl_tr').each(function() {
        if ($(this).find('a').text().toUpperCase().indexOf(val) > -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
        if (val.trim() == '') {
            $(this).show();
        }
    });
    if (unicode == 13) {
        var has_val = $.trim($('#is_mil_search').val());
        if ($.trim($("#milestone_search").val()) != '') {
            $('#is_mil_search').val(1);
            has_val = $.trim($('#is_mil_search').val());
        } else {
            $('#is_mil_search').val('');
        }
        localStorage.setItem("next_milestone_page", 0);
        if (has_val != '') {
            showTaskGroupsList();
        }
    }
}

function showNextPrevMilestone(obj, type) {
    if ($(obj).hasClass('disable')) {
        return false;
    }
    var curnt_page = (!localStorage.getItem("next_milestone_page")) ? 0 : localStorage.getItem("next_milestone_page");
    if (type) {
        curnt_page = parseInt(curnt_page) + 1;
    } else {
        curnt_page = parseInt(curnt_page) - 1;
    }
    localStorage.setItem("next_milestone_page", curnt_page);
    showTaskGroupsList();
}

function showTaskGroupsList() {
    $('.milestone_loader_dv').show();
    var hashtag = parseUrlHash(urlHash);
    var url = HTTP_ROOT + 'requests/ajaXLoadTaskGroupList';
    var projFil = $("#projFil").val();
    var caseSearch = $("#milestone_search").val();
    var page = localStorage.getItem("next_milestone_page");
    var selected_mid = localStorage.getItem("subtask_miilestone");
    $.post(url, {
        projFil: projFil,
        caseSearch: caseSearch,
        page: page,
        selected_mid: selected_mid
    }, function(res) {
        $('.milestone_loader_dv').hide();
        $('#milePageCount').val(res.totalMilestones);
        $('.milestone_side_view_container').show();
        $(".milestone_side_view_content").html(tmpl("milestone_subtaskview_tmpl", res.milestones));
        if (res.left == 'active') {
            $('.milestone_side_view_container .mil_paginate .left').removeClass('disable').addClass('active');
        } else {
            $('.milestone_side_view_container .mil_paginate .left').removeClass('active').addClass('disable');
        }
        if (res.right == 'active') {
            $('.milestone_side_view_container .mil_paginate .right').removeClass('disable').addClass('active');
        } else {
            $('.milestone_side_view_container .mil_paginate .right').removeClass('active').addClass('disable');
        }
        $.material.init();
    }, 'json');
}
function showTaskByTaskGroup(mid, pid, obj) {
    if ($(obj).hasClass('plus-minus')) {
        var url = HTTP_ROOT + 'requests/loadTaskByTaskgroup';
        var tbody = $(obj).closest('tbody');
        tbody.find('tr[id^="curRow_subtask_"],.qtsksbtsk,.noRecord,.separetor_tr').remove();
        $("#tskgrpldr" + mid).show();
        var projFil = $("#projFil").val();
        var caseId = $('#caseId').val();
        var startCaseId = $('#caseStart').val();
        var caseResolve = $('#caseResolve').val();
        var caseChangeType = $('#caseChangeType').val();
        var caseChangePriority = $('#caseChangePriority').val();
        var caseChangeDuedate = $('#caseChangeDuedate').val();
        var caseChangeAssignto = $('#caseChangeAssignto').val();
        var customfilter = $('#customFIlterId').val();
        var caseStatus = $('#caseStatus').val();
        var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
        var priFil = $('#priFil').val();
        var caseTypes = $('#caseTypes').val();
        var caseLabel = $('#caseLabel').val();
        var caseMember = $('#caseMember').val();
        var caseComment = $('#caseComment').val();
        var caseAssignTo = $('#caseAssignTo').val();
        var caseDate = $('#caseDate').val();
        var case_date = $('#caseDateFil').val();
        var case_due_date = $('#casedueDateFil').val();
        var taskgroup_fil = '';
        var hashtag = parseUrlHash(urlHash);
        var caseSearch = $("#case_search").val();
        var caseTitle = $('#caseTitle').val();
        var caseDueDate = $('#caseDueDate').val();
        var caseNum = $('#caseNum').val();
        var caseLegendsort = $('#caseLegendsort').val();
        var caseAtsort = $('#caseAtsort').val();
        var caseMenuFilters = $('#caseMenuFilters').val();
        var milestoneIds = $('#milestoneIds').val();
        var case_srch = $('#case_srch').val();
        var caseCreateDate = $('#caseCreatedDate').val();
        var projIsChange = $('#projIsChange').val();
        var caseUrl = "";
        var detailscount = 0;
        var reply = 0;
        var mstype = "";
        var mlstype = $('#checktype').val();
        if (mlstype == 'completed') {
            var mstype = 0;
        } else {
            var mstype = 1;
        }
        var casePage = '';
        $.post(url, {
            mid: mid,
            pid: pid,
            projFil: projFil,
            caseStatus: caseStatus,
            caseCustomStatus: caseCustomStatus,
            customfilter: customfilter,
            caseChangeAssignto: caseChangeAssignto,
            caseChangeDuedate: caseChangeDuedate,
            caseChangePriority: caseChangePriority,
            caseChangeType: caseChangeType,
            mstype: mstype,
            priFil: priFil,
            caseTypes: caseTypes,
            caseLabel: caseLabel,
            caseMember: caseMember,
            caseComment: caseComment,
            caseAssignTo: caseAssignTo,
            caseDate: caseDate,
            caseSearch: caseSearch,
            casePage: casePage,
            caseId: caseId,
            caseTitle: caseTitle,
            caseDueDate: caseDueDate,
            caseNum: caseNum,
            caseLegendsort: caseLegendsort,
            caseAtsort: caseAtsort,
            startCaseId: startCaseId,
            caseResolve: caseResolve,
            caseMenuFilters: caseMenuFilters,
            caseUrl: caseUrl,
            detailscount: detailscount,
            milestoneIds: milestoneIds,
            case_srch: case_srch,
            case_date: case_date,
            'case_due_date': case_due_date,
            caseCreateDate: caseCreateDate,
            projIsChange: projIsChange
        }, function(res) {
            if (mid != 0) {
                $(".n_cnt_grpt_" + mid).text("(" + res.total_task + ")");
            } else {
                $(".n_cnt_grpt_default").text("(" + res.total_task + ")");
            }
            tbody.append(tmpl("task_by_taskgroup_tmpl", res));
            $("#tskgrpldr" + mid).hide();
            $.material.init();
            $('input[id^="est_hr_sub_list"]').off().on('keyup', function(e) {
                var unicode = e.charCode ? e.charCode : e.keyCode;
                if (unicode == 13) {
                    var id = $(this).attr('data-est-id');
                    var uid = $(this).attr('data-est-uniq');
                    var cno = $(this).attr('data-est-no');
                    var tim = $(this).attr('data-est-time');
                    changeEstHourSubTaskListPage(id, uid, cno, tim);
                }
            });
            localStorage.setItem("ckl_chks", 0);
            $('input[id^="est_hr_sub_list"]').on('blur', function(e) {
                var d_val = $(this).attr('data-default-val');
                var d_val_orig = $(this).val();
                if (localStorage.getItem("ckl_chks") == '0') {
                    if (d_val == d_val_orig) {
                        $(this).closest('.estblists').size() > 0 ? '' : $('.estblists').show();
                        $('.est_hr_sub_list').hide();
                    }
                }
            });
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            iniDateFilter();
            $("div [id^='set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    startDate: new Date(),
                    todayHighlight: true,
                    format: 'mm/dd/yyyy',
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    var caseId = $(this).attr('data-csatid');
                    var datelod = "datelod" + caseId;
                    var showUpdDueDate = "showUpdDueDate" + caseId;
                    var old_duetxt = $("#" + showUpdDueDate).html();
                    $("#" + showUpdDueDate).html("");
                    $("#" + datelod).show();
                    var text = '';
                    var vobj = $(this);
                    var dateText = $(this).datepicker('getFormattedDate');
                    $(this).val('');
                    commonDueDateChange(caseId, dateText, text, datelod, old_duetxt, showUpdDueDate, vobj);
                });
            });
        }, 'json');
    }
}

function collapse_taskgroup_thread(obj) {
    var taskGroupId = $(obj).closest('tr').attr('id').replace('empty_milestone_tr_thread', '');
    var ids_array = typeof getCookie('PREOPENED_TASK_GROUP_IDS_THREAD') != 'undefined' ? JSON.parse(getCookie('PREOPENED_TASK_GROUP_IDS_THREAD')) : [];
    if ($(obj).hasClass('minus-plus')) {
        $(obj).removeClass('minus-plus');
        $(obj).addClass('plus-minus');
        $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr_thread"]').slideDown(function() {
            checkAllCB(obj, 'open');
        });
        if ($.inArray(taskGroupId, ids_array) == -1) {
            ids_array.push(taskGroupId);
        }
    } else {
        $(obj).addClass('minus-plus');
        $(obj).removeClass('plus-minus');
        $(obj).closest('tr').nextUntil('tr[id^="empty_milestone_tr_thread"]').slideUp(function() {
            checkAllCB(obj, 'close');
        });
        ids_array.splice($.inArray(taskGroupId, ids_array), 1);
    }
    createCookie("PREOPENED_TASK_GROUP_IDS_THREAD", JSON.stringify(ids_array), 365, DOMAIN_COOKIE);
}

function changeEstHourSubTaskListPage(caseId, caseUniqId, cno, value) {
    if (LogTime.convertToMin($("#est_hr_sub_list" + caseId).val()) == LogTime.convertToMin($("#est_hr_sub_list" + caseId).attr('data-default-val'))) {
        $("#est_hr_sub_list" + caseId).val($("#est_hr_sub_list" + caseId).attr('data-default-val'));
        $('#est_hr_sub_list' + caseId).hide();
        $('#est_hr_sub_list' + caseId).show();
        return false;
    }
    var estlod = "estsublod" + caseId;
    $("#est_blist_sub" + caseId).hide();
    $('#est_hr_sub_list' + caseId).hide();
    var estHour = $("#est_hr_sub_list" + caseId).val();
    if (estHour.trim() == '') {
        $('#' + estlod + '').hide();
        $('#est_blist_sub' + caseId + ',#est_blist_sub' + caseId + ' span').show();
        showTopErrSucc('error', _('Estimated hour(s) can not be blank.'));
        $('#est_hr_sub_list' + caseId).val(value);
        return;
    }
    $('#' + estlod + '').show();
    $('#est_hr_sub_list' + caseId).hide();
    $('#est_blist_sub' + caseId + ' span').hide();
    if (parseInt(estHour.replace(/[^0-9]+/g, '')) == 0) {
        $('#' + estlod + '').hide();
        $('#est_blist_sub' + caseId + ',#est_blist_sub' + caseId + ' span').show();
        showTopErrSucc('error', _('Estimated hour(s) can not be 0.'));
        $('#est_hr_sub_list' + caseId).val(value);
        $("#est_hr_sub_list" + caseId).focus();
        return;
    }
    var esthr = estHour;
    $.post(HTTP_ROOT + "easycases/ajax_change_estHour", {
        "caseId": caseId,
        "estHour": estHour
    }, function(data) {
        if (estHour.indexOf(':') > 0) {
            estHour = estHour.split(':');
            var estTxt = (((parseInt(estHour[0]) * 60) + parseInt(estHour[1])) * 60);
        } else {
            estTxt = estHour * 3600;
        }
        $('#' + estlod + '').hide();
        $("#est_hr_sub_list" + caseId).hide();
        $('#est_blist_sub' + caseId).show();
        $('#est_blist_sub' + caseId + ' span').html(format_time_hr_min(estTxt)).show();
        appendReplyThread(data.curCaseId, caseId);
        if (data.isAssignedUserFree != 1 && data.isAssignedUserFree != null) {
            CS_start_date = data.task_details.Easycase.gantt_start_date;
            CS_due_date = data.task_details.Easycase.due_date;
            est_hours = esthr;
            caseUniqId = data.task_details.Easycase.uniq_id;
            project_id = data.task_details.Easycase.project_id;
            CS_assign_to = data.task_details.Easycase.assign_to;
            openResourceNotAvailablePopup(CS_assign_to, CS_start_date, CS_due_date, est_hours, project_id, caseId, caseUniqId, data.isAssignedUserFree)
        }
    }, 'json').always(function() {
        actiononTask(caseId, caseUniqId, cno, 'esthour');
    });
}
$(document).ready(function() {
    $(document).on('click', '[id^="subact_replys"]', function() {
        var task_data = $(this).attr('data-task').split('|');
        var caseUniqId = task_data[0];
        scrollToRep = caseUniqId;
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    });
    $(document).on('click', '[id^="Ratsk_title"]', function() {
        var task_data = $(this).attr('data-task').split('|');
        var caseUniqId = task_data[0];
        $('#myModal').modal('hide');
        $(".cmn_popup").hide();
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 170);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    });
    $(document).on('click', '.task_mention', function() {
        var task_data = $(this).attr('data-tskuniqid');
        var caseUniqId = task_data;
        var mntn_prnt_tsk_id = $("#case_uiq_detail_popup").val();
        if ($(this).parents("span").hasClass("mentioned_message_cls")) {} else {
            createCookie('mntn_prnt_tsk_id', mntn_prnt_tsk_id, 1, DOMAIN_COOKIE);
        }
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    });
    $(document).on('click', '.mention-task-dtls', function() {
        var task_data = $(this).attr('data-uniqid');
        var caseUniqId = task_data;
        scrollToRep = caseUniqId;
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
        $("#cnt_task_detail_kb").html("");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    });
});

function moveTaskToTaskGroup(type) {
    var taskid = new Array();
    $('input[id^="actionChk"]').each(function(i) {
        if ($(this).is(":checked") && !($(this).is(":disabled"))) {
            taskid.push($(this).val());
        }
    });
    var project_id = $("#curr_sel_project_id").val();
    var mlstid = "";
    var taskno = "all";
    openPopup();
    $(".movetaskTomlst").show();
    $('#mvtask_mlst').html('');
    $('.add-mlstn-btn').hide();
    $('#tsksrch').hide();
    $("#mvtask_loader").show();
    $("#mvtask_movebtn").css({
        'cursor': 'pointer'
    });
    $.post(HTTP_ROOT + "milestones/moveTaskMilestone", {
        'taskid': taskid,
        'project_id': project_id,
        'mlstid': mlstid,
        'task_no': taskno,
        'type': type
    }, function(res) {
        if (res) {
            $('#mvtask_mlst').html(res);
            $("#mvtask_loader").hide();
            $('#mvtask_mlst').show();
            $('.add-mlstn-btn').show();
            $('#tskloader').hide();
            $('#tsksrch').show();
            $("#mvtask_prj_ttl").html($("#mvtask_proj_name").val());
            if ($('#mvtask_cnt').val() == 0) {
                $("#mvtask_movebtn").attr({
                    'disabled': 'disabled'
                });
            }
            $.material.init();
            $(".select").dropdown();
        }
    });
}

function DeleteAllCase(type) {
    var cbval = '';
    var case_id = new Array();
    var spval = '';
    var case_no = new Array();
    var chked = 0;
    $('input[id^="actionChk"]').each(function(i) {
        if ($(this).is(":checked") && !($(this).is(":disabled"))) {
            cbval = $(this).val();
            spval = cbval.split('|');
            case_id.push(spval[0]);
            case_no.push(spval[1]);
            chked = 1;
        }
    });
    if (chked == 0) {
        showTopErrSucc('error', _("Please check atleast one task to delete"));
        return false;
    }
    var tmdet = getCookie('timerDtls');
    if (typeof tmdet != 'undefined') {
        var tmCsDet = tmdet.split('|');
        var taskautoid = tmCsDet[0];
        for (var i in case_id) {
            if (case_id[i] == taskautoid) {
                showTopErrSucc('error', _("Task can not be deleted while timer is on"));
                return false;
            }
        }
    }
    var project_id = $("#curr_sel_project_id").val();
    var isSub = (typeof arguments[5] != 'undefined' && arguments[5] == 'sub') ? 1 : 0;
    var cno = case_no.join(',');
    var confMesg = case_no.length == 1 ? _("Are you sure you want to delete the task ?") : _("Are you sure you want to delete ") + case_no.length + _(" tasks ?");
    if (confirm(confMesg)) {
        refreshActvt = 1;
        var hashtag = parseUrlHash(urlHash);
        $('#caseLoader').show();
        var mid = new Array();
        var strurl = HTTP_ROOT + "requests/delete_bulk_case";
        $.post(strurl, {
            "id": case_id,
            "cno": cno,
            "pid": project_id
        }, function(data) {
            if (data.status == 0) {
                $('#caseLoader').hide();
                showTopErrSucc('error', _("Failed to delete task #") + cno + ". " + _("Please try again."));
            } else {
                for (var i in case_id) {
                    var curRow = "curRow_subtask_" + case_id[i];
                    $("#" + curRow).fadeOut(500);
                    mid.push($("#" + curRow).attr('data-mid'));
                    $("#" + curRow).remove();
                }
                var uniqueMid = mid.filter(function(itm, i) {
                    return i == mid.indexOf(itm);
                });
                if (uniqueMid) {
                    for (var j in uniqueMid) {
                        $("#empty_milestone_tr_thread" + uniqueMid[j]).find('.os_sprite' + uniqueMid[j]).trigger('click');
                        setTimeout($("#empty_milestone_tr_thread" + uniqueMid[j]).find('.os_sprite' + uniqueMid[j]).trigger('click'), 5000);
                    }
                }
                $('#caseLoader').hide();
                $('#caseResolve').val('');
                showTopErrSucc('success', _("Task") + " #" + cno + " " + _("is deleted."));
                $.post(HTTP_ROOT + "users/project_menu", {
                    "page": 1,
                    "limit": 6
                }, function(data) {
                    if (data) {
                        $('#ajaxViewProjects').html(data);
                    }
                });
                var hashtag = parseUrlHash(urlHash);
                $.post(HTTP_ROOT + "requests/getAllTasks", {
                    projUniq: $('#projFil').val()
                }, function(res) {
                    $("#taskCnt").html("(" + res.total_case + ")")
                }, 'json');
                if (!$('tr[data-mid="' + mid + '"]').length && hashtag[0] != 'taskgroups') {
                    easycase.refreshTaskList();
                }
                var projFil = $('#projFil').val();
                var casemenufllter = $('#caseMenuFilters').val();
                loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                    "projUniq": projFil,
                    "pageload": 1,
                    "page": "dashboard",
                    "filters": casemenufllter
                });
            }
        }, 'json');
    }
}

function showhideqt(mid) {
    $('#quicktsk_tr_lnk_' + mid).toggle();
    $('#quicktsk_tr_' + mid).toggle();
    $('.inline_qktask' + mid).focus();
    $('#qt_story_point_' + mid).val(0);
    $("#qt_due_dat_" + mid).datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        startDate: new Date(),
        hideIfNoPrevNext: true,
        autoclose: true
    }).on("changeDate", function(ev) {}).on("hide", function(ev) {});
    $('#quick-assign_' + mid).select2();
    $('#qt_task_type_' + mid).select2({
        templateSelection: formatTaskType,
        templateResult: formatTaskType,
    }).on('change', function(evt) {
        if ($(this).find('option:selected').text() == 'Story') {
            $('#qt_story_point_container_' + mid).show();
        } else {
            $('#qt_story_point_container_' + mid).hide();
        }
    });
}

function blurqktask_qt_tg(mid) {
    var inpt = $('#inline_qktask_' + mid).val().trim();
    $('#inline_task_error').html('&nbsp;');
    if (inpt == '') {
        $('#quicktsk_tr_lnk_' + mid).toggle();
        $('#quicktsk_tr_' + mid).toggle();
    } else {
        $('#quicktsk_tr_lnk_' + mid).toggle();
        $('#quicktsk_tr_' + mid).toggle();
        $('#inline_qktask_' + mid).val('');
        $('#qt_estimated_hours').val('');
    }
}

function DeleteAllCaseTaskList(type) {
    var page_location = getHash().indexOf("backlog");
    var projFil = $('#projFil').val();
    if (projFil == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + ' "' + _('All') + '" ' + _('project. Please choose a project.'));
        return false;
    }
    var cbval = '';
    var case_id = new Array();
    var spval = '';
    var case_no = new Array();
    var chked = 0;
    $('input[id^="actionChk"]').each(function(i) {
        if ($(this).is(":checked") && !($(this).is(":disabled"))) {
            cbval = $(this).val();
            spval = cbval.split('|');
            case_id.push(spval[0]);
            case_no.push(spval[1]);
            chked = 1;
        }
    });
    if (page_location == 0) {
        $('input[id^="actChkBklog"]').each(function(i) {
            if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                cbval = $(this).val();
                spval = cbval.split('|');
                case_id.push(spval[0]);
                case_no.push(spval[1]);
                chked = 1;
            }
        });
    }
    if (chked == 0) {
        showTopErrSucc('error', _("Please check atleast one task to delete"));
        return false;
    }
    var project_id = $("#curr_sel_project_id").val();
    var isSub = (typeof arguments[5] != 'undefined' && arguments[5] == 'sub') ? 1 : 0;
    var cno = case_no.join(',');
    var confMesg = case_no.length == 1 ? _("Are you sure you want to delete the task ?") : _("Are you sure you want to delete ") + case_no.length + _(" tasks ?");
    if (confirm(confMesg)) {
        refreshActvt = 1;
        var hashtag = parseUrlHash(urlHash);
        $('#caseLoader').show();
        var mid = [];
        var strurl = HTTP_ROOT + "requests/delete_bulk_case";
        $.post(strurl, {
            "id": case_id,
            "cno": cno,
            "pid": project_id
        }, function(data) {
            if (data.status == 0) {
                $('#caseLoader').hide();
                showTopErrSucc('error', _("Failed to delete task #") + cno + ". " + _("Please try again."));
            } else if (page_location == 0) {
                easycase.showbacklog();
            } else {
                easycase.refreshTaskList();
            }
        }, 'json');
    }
}

function markBillabltType(obj) {
    var tlg_ids = new Array();
    var billabe_type = $(obj).val();
    $(".chkOneTlg:checked").each(function() {
        tlg_ids.push($(this).attr("data-logid"));
    });
    if (tlg_ids.length > 0) {
        $("#caseLoader").show();
        var strurl = HTTP_ROOT + "requests/updateBillableType";
        $.post(strurl, {
            "log_id": tlg_ids,
            "billable_type": billabe_type
        }, function(data) {
            if (data.status == 1) {
                $("#caseLoader").hide();
                $(obj).prop('checked', false);
                $(".tlg_bill_typ").hide();
                pgn = (typeof angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().__default__currentPage != 'undefined') ? angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().__default__currentPage : 1;
                angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().fetchTimelog('', pgn);
                angular.element(document.getElementById('caseTimeLogViewSpan_angular')).scope().$apply();
                showTopErrSucc('success', data.msg);
            } else {
                $("#caseLoader").hide();
                showTopErrSucc('error', data.msg);
            }
        }, 'json');
    } else {
        showTopErrSucc('error', _("Please select a timelog to change billable status"));
    }
}
var dateFormat = function() {
    var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])1?|[LloSZ]|"[^"]*"|'[^']*'/g,
        timezone = /b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]d{4})?)b/g,
        timezoneClip = /[^-+dA-Z]/g,
        pad = function(val, len) {
            val = String(val);
            len = len || 2;
            while (val.length < len) val = "0" + val;
            return val;
        };
    return function(date, mask, utc) {
        var dF = dateFormat;
        if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/d/.test(date)) {
            mask = date;
            date = undefined;
        }
        date = date ? new Date(date) : new Date;
        if (isNaN(date)) throw SyntaxError("invalid date");
        mask = String(dF.masks[mask] || mask || dF.masks["default"]);
        if (mask.slice(0, 4) == "UTC:") {
            mask = mask.slice(4);
            utc = true;
        }
        var _ = utc ? "getUTC" : "get",
            d = date[_ + "Date"](),
            D = date[_ + "Day"](),
            m = date[_ + "Month"](),
            y = date[_ + "FullYear"](),
            H = date[_ + "Hours"](),
            M = date[_ + "Minutes"](),
            s = date[_ + "Seconds"](),
            L = date[_ + "Milliseconds"](),
            o = utc ? 0 : date.getTimezoneOffset(),
            flags = {
                d: d,
                dd: pad(d),
                ddd: dF.i18n.dayNames[D],
                dddd: dF.i18n.dayNames[D + 7],
                m: m + 1,
                mm: pad(m + 1),
                mmm: dF.i18n.monthNames[m],
                mmmm: dF.i18n.monthNames[m + 12],
                yy: String(y).slice(2),
                yyyy: y,
                h: H % 12 || 12,
                hh: pad(H % 12 || 12),
                H: H,
                HH: pad(H),
                M: M,
                MM: pad(M),
                s: s,
                ss: pad(s),
                l: pad(L, 3),
                L: pad(L > 99 ? Math.round(L / 10) : L),
                t: H < 12 ? "a" : "p",
                tt: H < 12 ? "am" : "pm",
                T: H < 12 ? "A" : "P",
                TT: H < 12 ? "AM" : "PM",
                Z: utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                o: (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                S: ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
            };
        return mask.replace(token, function($0) {
            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
        });
    };
}();
dateFormat.masks = {
    "default": "ddd mmm dd yyyy HH:MM:ss",
    shortDate: "m/d/yy",
    mediumDate: "mmm d, yyyy",
    longDate: "mmmm d, yyyy",
    fullDate: "dddd, mmmm d, yyyy",
    shortTime: "h:MM TT",
    mediumTime: "h:MM:ss TT",
    longTime: "h:MM:ss TT Z",
    isoDate: "yyyy-mm-dd",
    isoTime: "HH:MM:ss",
    isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
    isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};
dateFormat.i18n = {
    dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
};
Date.prototype.format = function(mask, utc) {
    return dateFormat(this, mask, utc);
};

function date_time_format(date) {
    var today = new Date(date);
    var dateString = today.format("mmm, dd yyyy");
    return dateString;
}

function date_time_format1(date) {
    var today = new Date(date);
    var dateString = today.format("yyyy-mm-dd");
    return dateString;
}
function showOverDueTask(){
    checkboxdueDate('overdue','check');
    filterRequest('duedate');
}