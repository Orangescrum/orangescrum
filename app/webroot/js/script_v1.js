var prj_parent_task_slct;
var new_subtask_parent_id;
var new_usr_html = '';
var th_class_str = "gradient-45deg-white gradient-45deg-indigo-blue gradient-45deg-purple-deep-orange gradient-45deg-light-blue-cyan gradient-45deg-purple-amber gradient-45deg-purple-deep-purple gradient-45deg-deep-orange-orange gradient-45deg-green-teal gradient-45deg-indigo-light-blue gradient-45deg-red-pink red purple pink deep-purple cyan teal light-blue amber brown";
var th_text_class_str = "white indigo-blue purple-deep-orange light-blue-cyan purple-amber purple-deep-purple deep-orange-orange green-teal indigo-light-blue red-pink red-text purple-text pink-text deep-purple-text cyan-text teal-text light-blue-text amber-text brown-text white-text";
var mention_array = {};
mention_array['mention_type_id'] = new Array();
mention_array['mention_type'] = new Array();
mention_array['mention_id'] = new Array();
$(document).keydown(function(evt) {
    if (evt.keyCode == 27 && !$(".resource_notavailable").is(":visible") && !$(".gcProjectSetting").is(":visible")) {
        closePopup();
    }
    if ($(evt.target).attr('id') == 'title_sprint' && evt.keyCode == 13) {
        return false;
    }
});
var new_usr_html = '';
var globalTimeoutBacklog = null;
var globalTimeoutSprint = null;
(function($) {
    var originalVal = $.fn.val;
    $.fn.val = function() {
        var result = originalVal.apply(this, arguments);
        if (arguments.length > 0)
            if ($(this).attr('id') == 'projFil')
                $(this).change();
        return result;
    };
})(jQuery);

function showHidetaskFilter() {
    $('#filterModal').modal({
        show: true,
    });
    var uhas = getHash();
    if (uhas == 'timelog') {
        $('#filter_title_sec').text(_('Filter Your Timelog'));
    } else {
        $('.filter_det').hide();
        $('#filter_title_sec').text(_('Filter Your Task'));
    }
    if (typeof uhas != 'undefined' && uhas.indexOf("tasks/") != -1) {
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
    }
}
function openTaskGroupByDrpdwn() {
    $('#dropdown_menu_groupby_filters').show();
}

function closeTaskFilter() {
    var uhas = getHash();
    if (uhas != 'timelog') {
        $('.filter_det').show();
    }
    $('#dropdown_menu_status, #dropdown_menu_types, #dropdown_menu_priority, #dropdown_menu_comments, #dropdown_menu_taskgroup, #dropdown_menu_users, #dropdown_menu_assignto, #dropdown_menu_label, #dropdown_menu_resource').html('');
    $('.filter_type_header').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).next('.filter_toggle_data').hide();
        }
    });
}

function setTabSelectionFilter(obj) {
    var g_has = getHash();
    if (g_has == 'taskgroups' && obj) {
        remember_filters('TASKGROUPBY', 'milestone');
    }
    $('.dtl_label_tag_tsk').removeClass('active');
    $(obj).parent('.dtl_label_tag_tsk').addClass('active');
}
$(document).ready(function() {
	$(document).click(function(e){
		//if ($(e.target).is('.task_details_popup,.task_details_popup *')) {
		if ($(e.target).is('.slide_right_modal.task_details_modal')) {
			if($('.task_details_popup').length && $('.task_details_popup').is(':visible')){
				closePopup('dtl_popup');
			}
		}
	});
    var gt_has = getHash();
    var ur = gt_has.split('/');
    if (ur[0] == "details") {
        localStorage.removeItem('url_type');
        localStorage.removeItem('url_uniq');
        localStorage.setItem("url_type", 'details');
        localStorage.setItem("url_uniq", ur[1]);
        window.location = HTTP_ROOT + 'dashboard#/tasks';
    }
    $(document).on('click', '.file_new_popup', function() {
        var uid = $(".file_new_popup").data('disid');
        easycase.ajaxCaseDetails(uid, 'case', 0, 'popup');
    });
    $(document).on('click', '#rset', function() {
        var CS_id = $(this).data('cs_id');
        $('#showhtml' + CS_id).show();
        $("[id^='up_files']").remove();
        $('#cmt_sec_dis').hide();
    });
    $(document).on('click', '#savreminder', function() {
        $('#savreminder').addClass('disabled');
    });
    $(document).on('click', '#tour_task_detail_reminder_v2', function() {
        $('#savreminder').removeClass('disabled');
    });
    $(document).on('keyup', '.add_checklist_inpt', function(e) {
        var is_inactive = $(this).data('isinactive');
        var ses_id = $(this).data('seslogin');
        if (e.keyCode === 13) {
            var projUID = $(this).data('projid');
            var csUID = $(this).data('caseid');
            addChecklistPopup(projUID, csUID, 0);
            trackEventLeadTracker('Task Detail Page', 'Task Checklist', ses_id);
        }
    });
    $(document).on('click', '.tog', function() {
        var sec_id = $(this).data('cmnt_id');
        if ($('#' + sec_id).hasClass('selected')) {
            $('#' + sec_id).removeClass('selected');
        } else {
            $('#' + sec_id).removeClass('selected');
            $('#' + sec_id).addClass('selected');
        }
    });
    $(".filter_set > .filter_type_header").on("click", function() {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).siblings(".filter_toggle_data").slideUp(200);
            $(".fa_arrow").removeClass("fa-minus").addClass("fa-plus");
        } else {
            $(".fa_arrow").removeClass("fa-minus").addClass("fa-plus");
            $(this).find(".fa_arrow").removeClass("fa-plus").addClass("fa-minus");
            $(".filter_set > .filter_type_header").removeClass("active");
            $(this).addClass("active");
            $(".filter_toggle_data").slideUp(200);
            $(this).siblings(".filter_toggle_data").slideDown(200);
        }
    });
    notShowEmptyDropdown();
    $('#plan_your_project').off().on('click', function() {
        $('body').addClass('hopscotch_bubble_body');
        localStorage.setItem("tour_type", '1');
        localStorage.setItem("OSTOUR", 1);
        window.location = HTTP_ROOT + 'projects/manage';
    });
    $('#manage_your_work').off().on('click', function() {
        $('body').addClass('hopscotch_bubble_body');
        var uhas = getHash();
        localStorage.setItem("tour_type", '3');
        localStorage.setItem("OSTOUR", 1);
        closePopup();
        if (uhas != 'tasks') {
            localStorage.setItem("tour_open_chk", '1');
            window.location = HTTP_ROOT + 'dashboard#/tasks';
        } else {
            if ($.trim(LANG_PREFIX) != '') {
                GBl_tour = onbd_tour_mngwork + LANG_PREFIX;
            } else {
                GBl_tour = onbd_tour_mngwork;
            }
            hopscotch.startTour(GBl_tour);
        }
    });
    $('#align_your_resource').off().on('click', function() {
        $('body').addClass('hopscotch_bubble_body');
        localStorage.setItem("tour_type", '2');
        localStorage.setItem("OSTOUR", 1);
        closePopup();
        $('#tour_profile_setting').parent('li').addClass('profl_nav_active_section');
        setTimeout(function() {
            $(".hover-menu").addClass('profl_nav_active_section');
            $('document').find('.top_maindropdown-menu').addClass("fadein_bkp").removeClass("fadeout_bkp").show();
            $('#tour_profile_setting').parent('li').addClass('open');
            $('#tour_mainporf_setting_drop').show();
            $('#tour_company_settings').trigger('click');
            if ($.trim(LANG_PREFIX) != '') {
                GBl_tour = onbd_tour_resource + LANG_PREFIX;
            } else {
                GBl_tour = onbd_tour_resource;
            }
            hopscotch.startTour(GBl_tour);
        }, 100);
    });
    $('#time_and_resource').off().on('click', function() {
        $('body').addClass('hopscotch_bubble_body');
        localStorage.setItem("tour_type", '4');
        localStorage.setItem("tour_type_nxt", '0');
        localStorage.setItem("OSTOUR", 1);
        closePopup();
        setTimeout(function() {
            $('#tour_qlink_menu').show();
            if ($.trim(LANG_PREFIX) != '') {
                GBl_tour = onbd_tour_tandresrc + LANG_PREFIX;
            } else {
                GBl_tour = onbd_tour_tandresrc;
            }
            hopscotch.startTour(GBl_tour);
        }, 100);
    });
    $("body").on('change', '#projFil', function(e) {
        remember_filters('CPUID', $(this).val());
    });
    $("#kanban_list").on('blur', '#inner-search-sprint', function(e) {
        search_val = $('#inner-search-sprint').val().trim();
        if (search_val == '') {
            if ($('#is_search_sprint').val() == 1) {
                $('#is_search_sprint').val('');
                $('#srch_inner_load1-sprint').show();
                ajaxSprintView(filterSprint('quk_fil_sprint', 1));
            }
        }
    });
    $("#kanban_list").on('keyup', '#inner-search-sprint', function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 13 && unicode != 40 && unicode != 38) {
            var srch = $("#inner-search-sprint").val();
            srch = srch.trim();
            if (srch == "") {
                $('#srch_inner_load1-sprint').hide();
                $('.filterSprinticon').hide();
            } else {}
            if (globalTimeoutSprint != null)
                clearTimeout(globalTimeoutSprint);
            globalTimeoutSprint = setTimeout(function() {
                ajaxSprintView(filterSprint('quk_fil_sprint', 1));
            }, 1000);
        }
        if (unicode == 13) {
            if (globalTimeoutSprint != null)
                clearTimeout(globalTimeoutSprint);
            $('#is_search_sprint').val(1);
            $('.filterSprinticon').show();
            if ($.trim($("#inner-search-sprint").val()) != '' || $('#is_search_sprint').val() == 1) {
                if ($.trim($("#inner-search-sprint").val()) == '') {}
                $('#srch_inner_load1-sprint').show();
                ajaxSprintView(filterSprint('quk_fil_sprint', 1));
            }
        }
    });
    $("#caseViewSpan").on('blur', '#inner-search-backlog', function(e) {
        search_val = $('#inner-search-backlog').val().trim();
        if (search_val == '') {
            if ($('#is_search_bklog').val() == 1) {
                $('#is_search_bklog').val('');
                $('#srch_inner_load1-bklog').show();
                ajaxBacklogView(filterSprint('quk_fil_bklog', 1));
            }
        }
    });
    var globalTimeoutProj = null;
    $('#fetch_plnd_vs_actl_task').on('keyup', '#plnd-vs-actl-inner-search', function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 13 && unicode != 40 && unicode != 38) {
            var srch = $("#plnd-vs-actl-inner-search").val();
            srch = srch.trim();
            if (srch == "") {
                $('#srch_inner_load1').hide();
            } else {
                $('#srch_inner_load1').show();
            }
            if (globalTimeoutProj != null) {
                clearTimeout(globalTimeoutProj);
            }
            $('#ajax_plnd-vs-actl_inner_search').html("");
            focusedRow = null;
            if (localStorage.getItem('plannedVsactual_filter') == "customdate") {
                var start_date = localStorage.getItem('custom_start_date');
                var end_date = localStorage.getItem('custom_end_date');
                localStorage.setItem('custom_start_date', start_date);
                localStorage.setItem("custom_end_date", end_date);
            }
            var usertype = localStorage.getItem('pln_vs_actl_usertype');
            var cur_date = localStorage.getItem('plannedVsactual_date');
            var nxtprev = localStorage.getItem('plannedVsactual_type');
            var rsc_proj_type = (localStorage.getItem('projRscFiltertype')) ? localStorage.getItem('projRscFiltertype') : '';
            var proj_id = (localStorage.getItem('projFilterdataid')) ? localStorage.getItem('projFilterdataid') : '';
            var rsc_id = (localStorage.getItem('rscFilterdataid')) ? localStorage.getItem('rscFilterdataid') : '';
            var proj_label = (localStorage.getItem('projFilterdatalabel')) ? localStorage.getItem('projFilterdatalabel') : '';
            var rsc_label = (localStorage.getItem('rscFilterdatalabel')) ? localStorage.getItem('rscFilterdatalabel') : '';
            remember_filters('plannedVsactual_srch', srch);
            localStorage.setItem('pln_vs_actl_usertype', usertype);
            localStorage.setItem('projRscFiltertype', rsc_proj_type);
            localStorage.setItem('projFilterdataid', proj_id);
            localStorage.setItem('rscFilterdataid', rsc_id);
            localStorage.setItem('projFilterdatalabel', proj_label);
            localStorage.setItem('rscFilterdatalabel', rsc_label);
            localStorage.setItem('plannedVsactual_type', nxtprev);
            localStorage.setItem('plannedVsactual_page', '');
            localStorage.setItem('plannedVsactual_date', cur_date);
            globalTimeoutProj = setTimeout(function() {
                fetchPlannedVsActualReportView(localStorage.getItem('plannedVsactual_filter'));
            }, 1000);
        }
    });
    $("#caseViewSpan").on('keyup', '#inner-search-backlog', function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 13 && unicode != 40 && unicode != 38) {
            var srch = $("#inner-search-backlog").val();
            srch = srch.trim();
            if (srch == "") {
                $('#srch_inner_load1-bklog').hide();
            } else {}
            if (globalTimeoutBacklog != null)
                clearTimeout(globalTimeoutBacklog);
            globalTimeoutBacklog = setTimeout(function() {
                ajaxBacklogView(filterSprint('quk_fil_bklog', 1));
            }, 1000);
        }
        if (unicode == 13) {
            if (globalTimeoutBacklog != null)
                clearTimeout(globalTimeoutBacklog);
            $('#is_search_bklog').val(1);
            $('.filterBacklogicon').show();
            if ($.trim($("#inner-search-backlog").val()) != '' || $('#is_search_bklog').val() == 1) {
                if ($.trim($("#inner-search-backlog").val()) == '') {}
                ajaxBacklogView(filterSprint('quk_fil_bklog', 1));
            }
        }
    });
    $('.left-palen-submenu').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var curr_class = $(this);
        var current_li = $(this).closest('li');
        if (current_li.hasClass('caseMenuLeft') && getHash() != 'tasks') {
            self.location = HTTP_ROOT + "dashboard#/tasks";
            return false;
        }
        $('.left-palen-submenu').not(this).closest('li').each(function() {
            $(this).find('.left-palen-submenu-items').hide();
            $(this).find('.left-palen-submenu').addClass('glyphicon-menu-right').removeClass('glyphicon-menu-down');
        });
        if (curr_class.hasClass('glyphicon-menu-right')) {
            current_li.find('.left-palen-submenu-items').show();
            current_li.find('.left-palen-submenu').addClass('glyphicon-menu-down').removeClass('glyphicon-menu-right');
        } else {
            current_li.find('.left-palen-submenu-items').hide();
            current_li.find('.left-palen-submenu').addClass('glyphicon-menu-right').removeClass('glyphicon-menu-down');
        }
        hasLeftScrollBar();
    });
    hasLeftScrollBar();
    $(".option_menu_panel,.logo_cmpnay_name_toggle").hover(function() {
        if ($("body").hasClass('mini-sidebar')) {
            $("body").addClass('menu_squeeze');
            $("body").addClass('hover_left_menu');
            $('.left-palen-submenu').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-right');
            $('.left-palen-submenu-items').hide();
            expandLeftSubmenu();
        }
    }, function() {
        if ($("body").hasClass('mini-sidebar')) {
            $("body").addClass('menu_squeeze');
            $("body").removeClass('hover_left_menu');
            $('.left-palen-submenu').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-right');
            $('.left-palen-submenu-items').hide();
        }
    });
    $('.last_visited_projects').on('click', function(e) {
        if (!$('body').hasClass('mini-sidebar')) {
            e.preventDefault();
            e.stopPropagation();
            if (!$('.recent_visited_projects').is(':visible')) {
                $(".last_visited_projects").removeClass("glyphicon-menu-right").addClass("glyphicon-menu-down");
                $(".visit_tasks").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
                $(".last_visited_project_reports").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            } else {
                $(".last_visited_projects").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            }
        }
    });
    $('.visit_tasks').on('click', function(e) {
        if (getCookie('FIRST_INVITE_1')) {} else {
            if (!$('body').hasClass('mini-sidebar')) {
                e.preventDefault();
                e.stopPropagation();
                if (!$('.view_tasks_menu').is(':visible')) {
                    $(".visit_tasks").removeClass("glyphicon-menu-right").addClass("glyphicon-menu-down");
                    $(".last_visited_projects").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
                    $(".last_visited_project_reports").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
                } else {
                    $(".visit_tasks,.left_panel_other_link").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
                }
            }
        }
    });
    $(".last_visited_project_reports").on('click', function(e) {
        if (!$('body').hasClass('mini-sidebar')) {
            e.preventDefault();
            e.stopPropagation();
            if (!$('.recent_visited_project_reports').is(':visible')) {
                $(".last_visited_project_reports").removeClass("glyphicon-menu-right").addClass("glyphicon-menu-down");
                $(".visit_tasks").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
                $(".last_visited_projects").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            } else {
                $(".last_visited_project_reports").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            }
        }
    });
    $('.li_visited_projects').on('click', function(e) {
        if (!$('body').hasClass('mini-sidebar')) {
            $('.li_visited_projects').removeClass('active');
            $(this).addClass("active");
        }
    });
    $('.cmn-arrow_back').on('click', function(e) {
        if (!$('body').hasClass('mini-sidebar')) {
            $(this).hide();
            if ($('body').hasClass('project-scrum')) {
                $(this).closest('li').not(".cmn-arrow_backli").addClass('project-scrum-link');
                $('.left_panel_ntother_link,.projectMenuLeft,.caseMenuLeft,.projectReportMenuLeft,.project-scrum-link').slideDown("slow");
            } else {}
        }
    });
    $('.comn_back_icon').on('click', function(e) {
        var leftLinkobj = {
            project: "&#xE8F9;",
            dashboard: "&#xE871;",
            task: "&#xE862;",
            report: "&#xE922;"
        };
        if (!$('body').hasClass('mini-sidebar')) {
            e.preventDefault();
            e.stopPropagation();
            $(".last_visited_projects").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $(".last_visited_project_reports").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $(".visit_tasks").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $('.report-arrow_forward').show();
            var curref = $(this);
            var crattr = curref.attr('data-name');
            $.each(leftLinkobj, function(key, value) {
                if (key == crattr) {
                    curref.html(value);
                }
            });
            $('.cmn-arrow_back').hide();
            if ($('body').hasClass('project-scrum')) {
                $(this).closest('li').not(".cmn-arrow_back").addClass('project-scrum-link');
                $('.left_panel_ntother_link,.projectMenuLeft,.caseMenuLeft,.projectReportMenuLeft,.project-scrum-link').slideDown("slow");
            } else {
                $('.left_panel_ntother_link,.projectMenuLeft,.caseMenuLeft,.projectReportMenuLeft').slideDown("slow");
            }
        }
    });
    $('.comn_back_nicon').on('click', function(e) {
        if (!$('body').hasClass('mini-sidebar')) {
            $(".last_visited_projects").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $(".last_visited_project_reports").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $(".visit_tasks").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
            $('.report-arrow_forward').show();
            if ($('body').hasClass('project-scrum')) {
                $(this).closest('li').addClass('project-scrum-nlink');
            } else {
                $('.left_panel_ntother_link,.projectMenuLeft,.caseMenuLeft,.projectReportMenuLeft').slideDown("slow");
            }
        }
    });
    $(document).on('click', function(e) {
        if ($(e.target).attr('id') != 'btn-add-new-all' && $('.show_new_add_div').is(':visible')) {
            $('.show_new_add_div').hide();
        }
    });
    $(document).on('click', function(e) {
        if (!e.target.closest('.top_side_breadcrumb')) {
            if (!e.target.onclick) {
                showHideTopNav(1);
            }
        }
        if ($('#help_subjects').is(':visible')) {
            if ($(e.target).closest('#helpvideo').length) {} else {
                helpDesk();
            }
        }
        if ($('#recent_visted_projects_dvblk').length) {
            $('#recent_visted_projects_dvblk, .recent_visited_projects').hide();
        }
    });
    $('.cstm-dt-option').on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('click', ".timelog_filter_msg_close", function() {
        $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr("checked");
        $('#dropdown_menu_resource').find('input[type="checkbox"]').removeAttr("checked");
        $('#tlog_date').val('');
        $('#tlog_resource').val('');
        $('#logstrtdt').val('');
        $('#logenddt').val('');
        $('#logstrtdt,#logenddt').val('').datepicker('setStartDate', null);
        $('#logstrtdt,#logenddt').val('').datepicker('setEndDate', null);
        $('#logstrtdt,#logenddt').val('').datepicker("option", {
            minDate: null,
            maxDate: null
        });
        localStorage.removeItem('timelog_date_filter');
        localStorage.removeItem('timelog_resource_filter');
        ajaxTimeLogView();
    });
    $(document).on('click', '.miscli_clk', function(e) {
        $('.ss_menu_mis').slideToggle("slow");
        if ($('.togle_arrow_spn').hasClass('arw-up')) {
            $('.togle_arrow_spn').removeClass('arw-up').addClass('arw-down');
        } else {
            $('.togle_arrow_spn').removeClass('arw-down').addClass('arw-up');
        }
    });
    $(document).on('click', '.stop_display_drpdn', function(event) {
        event.preventDefault();
        event.stopPropagation();
        return false;
    });
    $(document).on('click', '.showhiderec_visted_proj', function(event) {
        event.stopPropagation();
        toggleRecentVisitedProjects();
    });
    $(document).on('keyup', '.check_minute_range', function(e) {
        var inpt = $(this).val().trim();
        var char_restirict = /^[0-9\.\:]+$/.test(inpt);
        if (!char_restirict) {
            $(this).val(inpt.substr(0, inpt.length - 1));
        }
        var t_inpt = inpt.split(":");
        var d_inpt = inpt.split(".");
        var len = t_inpt.length - 1;
        var d_len = d_inpt.length - 1;
        if (len >= 2 || d_len >= 2 || (len & d_len)) {
            $(this).val(inpt.substr(0, inpt.length - 1));
            showTopErrSucc('error', _("Invalid time"));
        } else {
            if (len > 0 || d_len > 0) {
                var c_ln = 0;
                var d_ln = 0;
                if (inpt.indexOf(":") != -1) {
                    var sec_part = inpt.substr(inpt.indexOf(":") + 1);
                    c_ln = sec_part.length;
                }
                if (inpt.indexOf(".") != -1) {
                    var dsec_part = inpt.substr(inpt.indexOf(".") + 1);
                    d_ln = dsec_part.length;
                }
                if (c_ln > 2 || d_ln > 2) {
                    $(this).val(inpt.substr(0, inpt.length - 1));
                    showTopErrSucc('error', _("Minute can not exceed 2 digit"));
                }
            }
        }
    });
    $(document).on('focus', '.tl_hours', function() {
        $(this).attr('readonly', 'readonly');
        $(this).closest('.timelog_block').find('.timelog_toggle_block').show();
    });
    $(document).on('click', '.edit_time_log', function() {
        if (typeof $(this).closest('td').attr('data-logid') == 'undefined')
            return false;
        if ($('#projFil').val() == 'all') {
            createlog('', '', $(this).closest('td').attr('data-logid'), 0, 0, $(this).attr('data-task-id'), escape($(this).attr('data-prj-name')));
        } else {
            createlog('', '', $(this).closest('td').attr('data-logid'), 0, 0, $(this).attr('data-task-id'));
        }
    });
    
    $('#submit_feed').click(function(){
        openPopup();
        $('.feedback_form_popup').show();
    });
    $(document).on('click', '#btn-reset-timelog', function() {
        $('#logstrtdt,#logenddt').val('').datepicker('setStartDate', null);
        $('#logstrtdt,#logenddt').val('').datepicker('setEndDate', null);
        $('#logstrtdt,#logenddt').val('').datepicker("option", {
            minDate: null,
            maxDate: null
        });
        $(this).hide();
        $('#rsrclog').val('');
        casePage = 1;
        ajaxTimeLogView();
    });
    $(document).on('click', '.delete_time_log', function() {
        if (typeof $(this).closest('td').attr('data-logid') == 'undefined')
            return false;
        $obj = $(this);
        if (confirm(_("Are you sure to delete the timelog?"))) {
            var prjunid = $('#projFil').val();
            var hashtag = parseUrlHash(urlHash);
            if (logid != '' && prjunid == 'all' && hashtag[0] == 'details') {
                var prjunid = $('#CS_project_id' + $(this).attr('data-task-id')).val();
            }
            var logid = $obj.closest('td').attr('data-logid');
            $.ajax({
                url: HTTP_ROOT + "easycases/delete_timelog",
                data: {
                    'projuniqid': prjunid,
                    logid: logid
                },
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.success == '1') {
                        showTopErrSucc('success', _('Timelog deleted successfully.'));
                        if (getHash() == 'timelog') {
                            ajaxTimeLogView();
                        } else {
                            var hasharr = getHash().split('/');
                            if (hasharr[0] == 'details') {
                                localStorage.setItem("detail_timelog_delete", 1);
                                $('#tab-timelog').trigger('click');
                            } else if (CONTROLLER == 'easycases' && PAGE_NAME == 'invoice') {
                                invoices.switch_tab('logtime');
                            } else if ($("#myModalDetail").hasClass('in')) {
                                localStorage.setItem("detail_timelog_delete", 1);
                                $('#tab-timelog').trigger('click');
                            } else {
                                window.location.href = HTTP_ROOT + "/dashboard#calendar_timelog";
                            }
                        }
                    }
                }
            });
        }
    });
    $(document).on('click', '.timelog-table-head', function() {
        if ($(".hidetablelog").css('display') == 'none') {
            $("#showreplylog").find('a').trigger('click');
        }
    });
    $(document).on('click', function(e) {
        if (($(e.target).closest('.tgle_dropdown_menu').length == 0 && $(e.target).closest('.main_page_menu_togl').length == 0)) {
            $('.tgle_dropdown_menu').offset({
                left: 0
            }).removeClass('active_drop');
        }
    });
    checkboxCheckUncheck('#checkAllprojects', '.removePrjFromuser', '.tr_all', 'tr_active');
    checkboxCheckUncheck('#checkAllAddPrj', '.AddPrjToUser', '.tr_all', 'tr_active');
    $('body').click(function() {
        allowChromeDskNotify();
    });
    $('#intro-to-video').on('click', function(event) {
        $.getScript("//f.vimeocdn.com/js/froogaloop2.min.js", function(data, textStatus, jqxhr) {
            if (textStatus == 'success') {
                openPopup();
                $('#popup_bg_main').addClass('popup_bg_main');
                $(".new_video").show();
                $(".loader_dv").hide();
                $('#inner_video').show();
                $('#inner_video').html("<iframe class='iframer' id='player1' src='//www.youtube.com/embed/4qCaP0TZuxU?rel=0&autoplay=1?api=1&player_id=player1' width='100%' height='100%' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>");
                var iframe = $('#player1')[0];
                var player = $f(iframe);
                $('.close').on('click', function() {
                    player.api('pause');
                    window.location.reload();
                });
            }
        });
    });
    $('#more_proj_options').click(function() {
        $('#more_proj_options').html(($('.more_less_project_opts').is(":visible") ? "More options" : _("Hide options")));
        $('.more_less_project_opts').slideToggle('slow');
    });
    $('#hiddensavennew').val('0');
    $("#caseViewSpan").on('keyup', '#inner-search', function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        $('#clear_close_icon').hide();
        if (unicode != 13 && unicode != 40 && unicode != 38) {
            var srch = $("#inner-search").val();
            srch = srch.trim();
            if (srch == "") {
                $('#srch_inner_load1').hide();
            } else {
                $('#srch_inner_load1').show();
            }
            if (globalTimeout != null)
                clearTimeout(globalTimeout);
            $('#ajax_inner_search').html("");
            focusedRow = null;
            globalCount = 0;
            globalTimeout = setTimeout(ajaxCaseSearchInner, 1000);
        }
        if (unicode == 13) {
            if ($("#case_search").val().trim() != '' && $("#inner-search").val().trim() == '') {
                $("#case_search,#caseSearch").val('');
                ajaxCaseView('case_project');
                remember_filters('SEARCH', '');
                remember_filters('CASESRCH', '');
            } else {
                $("#case_search").val($("#inner-search").val());
                validateSearch();
            }
        }
        clearSearchvis();
    });
    $("#helpvideo").draggable({
        handle: ".modal-header"
    });
    $('ul.help-tabs').each(function() {
        var $active, $content, $links = $(this).find('a');
        $active = $($links.filter('[href="' + location.hash + '"]')[0] || $links[0]);
        $active.addClass('active');
        $content = $($active[0].hash);
        $links.not($active).each(function() {
            $(this.hash).hide();
        });
        $(this).on('click', 'a', function(e) {
            $active.removeClass('active');
            $content.hide();
            $active = $(this);
            $content = $(this.hash);
            $active.addClass('active');
            $content.show();
            e.preventDefault();
        });
    });
});
$(function() {
    $(document).on('click', '.estb', function(event) {
        event.stopPropagation();
        $('.estb').hide();
        $('.est_hr').show();
        $('.est_hr').select();
    });
    $(document).on('click', '#estimated_hours', function(event) {
        $(this).select();
    });
    $(document).on('click', '.est_hr', function(event) {
        event.stopPropagation();
        $('.estb').hide();
        $('.est_hr').show();
        $('.est_hr').select();
    });
    $(document).on('click', '.strpob', function(event) {
        event.stopPropagation();
        $('.strpob').hide();
        $('.strpo_cnt').show();
        $('.strpo_cnt').select();
    });
    $(document).on('click', '.estblist', function(event) {
        event.stopPropagation();
        var caseIdVal = $(this).attr('case-id-val');
        $(this).hide();
        $('#est_hrlist' + caseIdVal).show();
        $('#est_hrlist' + caseIdVal).select();
    });
    $(document).on('click', '.est_hrlist', function(event) {
        event.stopPropagation();
    });
    $(document).on('click', '.estblists', function(event) {
        event.stopPropagation();
        var caseIdVal = $(this).attr('case-id-val');
        $(this).hide();
        $('#est_hr_sub_list' + caseIdVal).show();
        $('#est_hr_sub_list' + caseIdVal).select();
    });
    $(document).on('click', '.est_hr_sub_list', function(event) {
        event.stopPropagation();
    });
});

function openFields() {}
var usersListData = 0;
var curr_location;
var urlHash = getHash();
var scrollToRep;
var ioMsgClicked = 0;
var _checkUrlInterval;
var _filterInterval;
var _searchInterval;
var refreshTasks = 0;
var refreshKanbanTask = 0;
var refreshMilestone = 0;
var refreshManageMilestone = 0;
var refreshActvt = 0;
var caseListData = 0;
var fileListData = 0;
var tinyPrevContent = '';
var search_key = '';
var casePage = 1;
var widget = '';
var gDueDate = 1;
var taskGroupsData = 0;
$(function() {
    $(document).on('click', '.dropdown_menu_all_filters_togl', function(event) {
        if ($('.main_page_menu_togl_ul').is(':visible')) {
            $('.main_page_menu_togl_ul').hide();
        }
        if ($('.dropdown_menu_all_filters_ul').is(':hidden')) {
            $('.dropdown_menu_all_filters_ul').show();
        }
        if ($("#task_filter").length != 0) {
            if ($("#task_filter").hasClass('open')) {
                $('.dropdown_menu_all_filters_ul').css({
                    'display': 'block'
                });
            } else {
                $('.dropdown_menu_all_filters_ul').css({
                    'display': 'none'
                });
            }
        }
    });
    $(document).on('click', '.top_main_page_menu_togl', function(event) {
        event.stopPropagation();
        if ($('.dropdown_menu_all_filters_ul').is(':visible')) {
            $('.dropdown_menu_all_filters_ul').hide();
        }
        if ($('#dropdown_menu_archive_filters').is(':visible')) {
            $('#dropdown_menu_archive_filters').hide();
        }
        if ($('.main_page_menu_togl_ul').is(':hidden')) {
            $('.main_page_menu_togl_ul').show();
            $('.dropdown_menu_all_filters_ul').hide();
        }
    });
    $(document).on('click', function(event) {
        if ($('.dropdown_menu_all_filters_ul').is(':visible')) {
            $('.dropdown_menu_all_filters_ul').hide();
        }
        if ($('.main_page_menu_togl_ul').is(':visible')) {
            $('.main_page_menu_togl_ul').hide();
        }
        if ($('#projpopup').is(':visible')) {
            $('#projpopup').hide();
        }
    });
    if (CONTROLLER == 'users' && PAGE_NAME == 'manage') {
        usersListData = 1;
    } else {
        usersListData = 0;
    }
    _checkUrlInterval = setInterval(checkUrl, 50);
    setInterval(trackLogin, 900000);
    $(document).on('keyup', '#inline_milestone', function(event) {
        var inpt = $(this).val().trim();
        if (inpt != '') {
            $('.qk_send_icon_mi').css('color', '#2983FD');
        } else {
            $('.qk_send_icon_mi').css('color', '#BDBDBD');
        }
        if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
            setSessionStorage('Quick Task Group Page', 'Create Task Group');
            AddNewMilestone();
        }
    });
    $(document).on('keyup', '#inline_qktask', function(event) {
        var inpt = $(this).val().trim();
        if (inpt != '') {
            $('.qk_send_icon').css('color', '#2983FD');
        } else {
            $('.qk_send_icon').css('color', '#BDBDBD');
        }
        if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
            setSessionStorage('Task List Quick Task', 'Create Task');
            AddQuickTask('sac');
        }
    });
    $(document).on('keyup', '#inline_qktask_sts', function(event) {
        var inpt = $(this).val().trim();
        if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
            setSessionStorage('Kanban Task Status Quick Task', 'Create Task');
            AddQuickTask('', '', 'sts');
        }
    });
    $(document).on('keyup', '.in_qt_taskgroup', function(event) {
        var inpt = $(this).val().trim();
        if (inpt != '') {
            $('.qk_send_icon_tg' + $(this).attr('data-mid')).css('color', '#2983FD');
        } else {
            $('.qk_send_icon_tg' + $(this).attr('data-mid')).css('color', '#BDBDBD');
        }
        if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
            setSessionStorage('Task Group Quick Task', 'Create Task');
            AddQuickTask($(this).attr('data-mid'), 'tg');
        }
    });
    $(document).on('click', '.in_qt_taskgroupbtn', function(event) {
        var inpt = $('.inline_qktask' + $(this).attr('data-mid')).val().trim();
        if (inpt != '' && !$('#caseLoader').is(':visible')) {
            setSessionStorage('Task Group Quick Task', 'Create Task');
            $('.qk_send_icon_tg' + $(this).attr('data-mid')).css('color', '#BDBDBD');
            var urlHash = getHash();
            if (urlHash != 'backlog') {
                $('.qk_send_icon_tg' + $(this).attr('data-mid')).closest('button').attr('disabled', true);
            }
            AddQuickTask($(this).attr('data-mid'), 'tg');
        }
    });
    $(document).on('blur', '#inline_milestone', function(event) {
        var inpt = $(this).val().trim();
        $('#inline_mile_error').html('&nbsp;');
        if (inpt == '') {
            $(this).val('');
            $('.quicktskgrp_tr_lnk').toggle();
            $('.quicktskgrp_tr').toggle();
        }
    });
    $(document).on('click', '#new_grp_label', function(event) {
        $('.quicktskgrp_tr_lnk').toggle();
        $('.quicktskgrp_tr').toggle();
        $('#inline_milestone').focus();
        $('.qk_send_icon_mi').css('color', '#BDBDBD');
        $('.qk_send_icon_mi').closest('button').attr('disabled', false);
    });
    $(document).on('click', '#new_task_label', function(event) {
        $('.quicktsk_tr_lnk').toggle();
        $('.quicktsk_tr').toggle();
        $('#qt_story_point').val(0);
        $('#inline_qktask').focus();
        $('.qk_send_icon').css('color', '#BDBDBD');
        $(".quicktsk_tr button").attr('disabled', false);
        $("#qt_due_dat").datepicker({
            format: 'M d, yyyy',
            todayHighlight: true,
            changeMonth: false,
            changeYear: false,
            startDate: new Date(),
            hideIfNoPrevNext: true,
            autoclose: true
        }).on("changeDate", function(ev) {}).on("hide", function(ev) {});
    });
    $(document).on('mouseover', '.empty_milstone_holder,.empty_milestone_pad,.adding-task-newTask', function() {
        $(this).find('.n_tsk_grp').show();
        $(this).find('.empty_milestone_pad').show();
        $(this).find('.adding-task-newTask').show();
    });
    $(document).on('mouseout', '.empty_milstone_holder,.empty_milestone_pad,.adding-task-newTask', function() {
        $(this).find('.n_tsk_grp').hide();
        $(this).find('.empty_milestone_pad').hide();
        $(this).find('.adding-task-newTask').hide();
    });
    $(document).on('click', '.delete_ntask_t', function(event) {
        event.stopPropagation();
    });
    $(document).on('click', '.more_opt', function(event) {
        $('.more_opt_tr').toggle('slow');
    });
});

function blurqktask() {
    var inpt = $('#inline_qktask').val().trim();
    $('#inline_task_error').html('&nbsp;');
    if (inpt == '') {
        $('.quicktsk_tr_lnk').toggle();
        $('.quicktsk_tr').toggle();
    }
}

function blurqktask_qt() {
    var inpt = $('#inline_qktask').val().trim();
    $('#inline_task_error').html('&nbsp;');
    if (inpt == '') {
        $('.quicktsk_tr_lnk').toggle();
        $('.quicktsk_tr').toggle();
    } else {
        $('.quicktsk_tr_lnk').toggle();
        $('.quicktsk_tr').toggle();
        $('#inline_qktask').val('');
        $('#qt_estimated_hours').val('');
    }
}

function switchPlans(name, plan, obj) {
    $('.price_plans a').removeClass('active');
    $(obj).addClass('active');
    $('.price_inner_mdiv').hide();
    $('#' + name + '_' + plan).show();
    $('#plantype').val(plan);
    $('#new_upgrade_plnbtn').text(_('Upgrade to') + ' ' + name);
    $('#new_pg_ttl').html(name + ' ' + _('Plan Details'));
}

function trackLogin() {
    $.post(HTTP_ROOT + "users/session_maintain", {}, function(data) {
        if (data) {
            if (data == 1) {
                window.top.location = HTTP_ROOT + "users/login";
            }
        }
    });
}

function getHash(window) {
    var match = (window || this).location.href.replace('#/', '#').match(/#(.*)$/);
    return match ? match[1] : '';
}

function checkUrl() {
    if (curr_location === (window || this).location.href) {
        return false;
    } else {
        curr_location = (window || this).location.href;
        urlHash = getHash();
        routeOSHash();
    }
}

function parseUrlHash(hash) {
    var urlVars = {};
    var params = (hash.substr(0)).split("/");
    return params;
}

function checkHashLoad(type) {
    if (type == "overview" || type == "milestonelist" || type == "files" || type == "activities" || type == "backlog" || type == "sprint" || type == "kanban" || type == "mentioned_list") {
        $('.show_all_opt_in_listonly').hide();
        var prjunid = $('#projFil').val();
        if (prjunid == 'all') {
            if ($('.create-task-container').is(':visible')) {
                showTopErrSucc('error', _('You were viewing') + " " + _('All') + " " + _('project. Please go to tasks & choose a project first.'));
            } else {
                showTopErrSucc('error', _('Oops! You are in') + " " + _('All') + " " + _('project. Please choose a project.'));
            }
            return false;
        }
    } else if (type == "tasks" || type == "timelog" || type == "kanban" || type == "defect") {
        $('.show_all_opt_in_listonly').show();
        if (type == "tasks") {
            $('.task_back_icon').text('arrow_backward').css('display', 'inline-block');
            $('.task_back_icon_d').hide();
            $('.report-arrow_forward').hide();
        }
    }
    var hiddensavennew = $('#hiddensavennew').val();
    $('#hiddensavennew').val('0');
    $('.slide_rht_con').show();
    $('.breadcrumb_fixed').show();
    $('.breadcrumb_div').show();
    if (getCookie('TASKGROUPBY') == 'milestone') {
        $('.sortby_btn').removeAttr('disabled');
        $('.sortby_btn').removeClass('disable-btn');
        remember_filters('TASKGROUPBY', '');
        refreshTasks = 1;
    }
    if (getCookie('SUBTASKVIEW') == 'subtaskview') {
        $('.sortby_btn').removeAttr('disabled');
        $('.sortby_btn').removeClass('disable-btn');
        remember_filters('SUBTASKVIEW', '');
        refreshTasks = 1;
    }
    if (type == "compactTask") {
        $('#lviewtype').val('compact');
        remember_filters('LISTVIEW_TYPE', 'compact');
        $('#calendar_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
    } else if (type == 'tasks') {
        $('.slide_rht_con').show();
        $('.breadcrumb_fixed').show();
        $('.breadcrumb_div').show();
        $('#lviewtype').val('comfort');
        remember_filters('LISTVIEW_TYPE', 'comfort');
        $('#calendar_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
    } else if (type == 'backlog') {
        $('.slide_rht_con').show();
        $('.task-list-bar').hide();
    } else if (type == 'sprint') {
        $('.slide_rht_con').show();
        $('.task-list-bar').hide();
    } else if (type == 'searchFilters') {
        $('#filtered_items').hide();
        searchFilterView();
    } else if (type == 'subtask') {
        $('#lviewtype').val('subtask');
        remember_filters('LISTVIEW_TYPE', 'subtask');
    } else if (type == 'kanban') {
        $('#lviewtype').val('kanban');
        remember_filters('LISTVIEW_TYPE', 'kanban');
        $('#calendar_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
    } else if (type == 'activities') {
        $('#lviewtype').val('activities');
        remember_filters('LISTVIEW_TYPE', 'activities');
        $('#calendar_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
    } else if (type == "timelog") {
        $('#calendar_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#files_btn').removeClass('disable');
        $('#calendar_btn_timelog').removeClass('disable');
        $('#timelog_btn').addClass('disable');
    } else if (type == "files") {
        $('#calendar_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#cview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').addClass('disable');
    } else if (type == "logList") {
        fetchLogLists();
    }
    if ($("#caseLoader").is(':visible') == false) {
        var hashtag = parseUrlHash(urlHash);
        search_key = '';
        if (type == "overview" && hashtag == "overview") {}
        if (type == "timelog" && hashtag == "timelog") {
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                var fil = $('#projFil').val().trim();
                if (fil == 'all') {
                    var p_iid = $('#CS_project_id').val();
                    $('#projFil').val(p_iid);
                    var p_nm = $('#first_recent_hid').val();
                    updateAllProj('proj_' + p_iid, p_iid, 'dashboard', 0, p_nm, '');
                } else {
                    ajaxTimeLogView();
                }
            }
        } else if (type == "timelog") {}
        if (type == "backlog" && hashtag == "backlog") {
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                if ($('.create-task-container').is(':visible')) {
                    crt_popup_close('CT');
                }
                easycase.showbacklog(hashtag);
            }
        }
        if (type == "files" && hashtag == "files") {
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                $("#widgethideshow").hide();
                easycase.showFiles(hashtag);
            }
        } else if (type == "files") {
            casePage = 1;
        }
        if (type == 'task' || type == 'kanban' || type == 'activities' || type == 'milestone' || hashtag == 'task' || hashtag == 'milestone' || hashtag == 'kanban' || hashtag == 'activities') {
            if (widget) {
                widget.insertBefore('.slide_rht_con');
            }
            if (type) {
                $('#prvhash').val(type);
            } else {
                $('#prvhash').val(hashtag);
            }
        }
        if (type == "kanban" && hashtag == "kanban") {
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                $("#widgethideshow").show();
                easycase.showKanbanTaskList(hashtag);
            }
        } else if (type == "kanban") {
            casePage = 1;
        }
        if (type == "milestone") {
            $('.slide_rht_con').show();
            $('.breadcrumb_fixed').show();
            $('.breadcrumb_div').show();
            $('#milestone_content').show();
            widget = $("#widgethideshow").detach();
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                ManageMilestoneList();
            } else {
                ManageMilestoneList();
            }
        } else if (type == "kanban") {
            casePage = 1;
        }
        if ((type == "tasks" || type == "compactTask") && hashtag == "tasks") {
            $('#ajaxViewProjects').html('');
            $('#ajaxViewProjects').hide();
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                $('.case-filter-menu').hide();
                $("#widgethideshow").show();
                easycase.showTaskLists(hashtag);
            }
            if (hiddensavennew == '1') {
                easycase.refreshTaskList();
            }
        } else if (type == "tasks") {
            casePage = 1;
            refreshTasks = 1;
        }
        if (type == "activities" && hashtag == "activities") {
            refreshActvt = 1;
            easycase.showActivities();
        }
        if (type == "mentioned_list" && hashtag == "mentioned_list") {
            refreshActvt = 1;
            easycase.showMentionList();
        }
        if (type == 'kanbanmilestone' && hashtag == 'kanbanmilestone') {
            routeHideshowMilestone('kanbanmilestone');
            showMilestoneList();
        }
        if (hiddensavennew == '1' && type == 'milestonelist') {
            showMilestoneList();
        }
    }
}

function selSubmenu(color) {
    var act_text_color;
    if (typeof color == "undefined" || color == null) {
        $('#leftmenu_theme_switcher').children('li[data-app-theme=' + DEFAULT_THEME_COLOR + ']').trigger('click');
        $('#navmenu_theme_switcher').children('li[data-app-theme=' + DEFAULT_THEME_COLOR + ']').trigger('click');
        color = DEFAULT_THEME_COLOR;
    }
    if (color.indexOf('gradient-45deg-') !== -1) {
        act_text_color = (color == "gradient-45deg-white") ? str_replace('gradient-45deg-', '', color) + "-text" : str_replace('gradient-45deg-', '', color);
    } else {
        act_text_color = color + "-text"
    }
    return act_text_color;
}

function thclasses() {
    var theme_classes_obj = new Object();
    if (localStorage.hasOwnProperty("theme_setting")) {
        var theme_setting = localStorage.getItem("theme_setting");
        theme_setting = JSON.parse(theme_setting);
        theme_classes_obj.cstm_clr_class = ' ' + theme_setting.sidebar_color;
        theme_classes_obj.cstm_smenu_text_class = selSubmenu(theme_setting.sidebar_color);
    } else {
        var th_setting_obj = new Object();
        th_setting_obj.sidebar_color = DEFAULT_THEME_COLOR;
        th_setting_obj.navbar_color = DEFAULT_THEME_COLOR;
        th_setting_obj.style_sidebar_mini = false;
        var th_setting_objJSON = JSON.stringify(th_setting_obj);
        localStorage.setItem("theme_setting", th_setting_objJSON);
        theme_classes_obj.cstm_clr_class = DEFAULT_THEME_COLOR;
        theme_classes_obj.cstm_smenu_text_class = selSubmenu(DEFAULT_THEME_COLOR);
    }
    return theme_classes_obj;
}

function routeOSHash() {
    $('body').css('overflow-y', 'auto');
    $('.slide_rht_con').show();
    var theme_classes_obj = thclasses();
    var cstm_clr_class = theme_classes_obj.cstm_clr_class;
    var cstm_smenu_text_class = theme_classes_obj.cstm_smenu_text_class;
    $('.sticky_footer').show();
    $('#show_search_kanban').html('');
    $('#resetting_kanban').html('');
    $('#kanban_list').css('margin-top', '');
    $('#new_onboarding_add_icon').html('<a onclick="$(\'.show_new_add_div\').toggle();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" id="btn-add-new-all" href="javascript:void(0)">' + _('New') + '<div class="ripple-container"></div></a>');
    $('.show_new_add_div').hide();
    $('.calendar-bar-text').hide();
    $('.new_calendar_icon_on_top').hide();
    $('.slide_rht_con').css('margin-top', '');
    taskGroupsData = 0;
    if (CONTROLLER != 'templates' && PAGE_NAME != 'projects' && localStorage.getItem("tour_type") != '3' && localStorage.getItem("tour_type") != '4') {
        if ($('.hopscotch-close').length) {
            $('.hopscotch-close').trigger('click');
        }
    }
    $('.menu_logs_timelog, .menu_logs_wtsht, .menu_logs_ru').removeClass('active');
    if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
        $("#case_search").attr("placeholder", _("Search Projects"));
        $('.customFilter').html('');
        if (isAllowed('Create Project')) {
            $('#new_onboarding_add_icon').html('<a href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Project\');newProject();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '">' + _('New Project') + '</a>');
        }
        addUserToProject();
    } else if (CONTROLLER == 'Defects' && PAGE_NAME == 'defect') {
        $("#case_search").attr("placeholder", _("Search Defect"));
    } else if (CONTROLLER == 'users' && PAGE_NAME == 'manage') {
        $("#case_search").attr("placeholder", _("Search Users"));
        $("img.lazy").lazyload({
            placeholder: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        });
        $('.customFilter').html('');
        if (SES_TYPE < 3) {
            if (isAllowed('Add New User')) {
                $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Invite User\');newUser()">' + _('New User') + '</a>');
            }
        }
        addProjectToUser();
    } else {
        var params = parseUrlHash(urlHash);
        var params_val = params[0].split('?');
        if (params_val[1] != undefined) {
            params_val = params_val[1].split('=');
            params_val = params_val[1];
            params[0] = 'overview';
            $('.project-dropdown').hide();
            $('.project-dropdown').prev('li').hide();
        } else {
            params_val = '';
        }
        if (params != '') {
            if ((CONTROLLER == 'easycases' && PAGE_NAME == 'invoice')) {} else {
                if (typeof params[0] != 'undefined' && params[0].trim() != 'details') {
                    general.update_footer_total();
                }
            }
        }
        $('#filter_section').show();
        $('#widgethideshow').show();
        params[0] = (params[0] == '' && typeof params[1] != 'undefined') ? params[1] : params[0];
        if (params[0] == "overview" || params[0] == "milestonelist" || params[0] == "files" || params[0] == "activities" || params[0] == "chart_timelog" || params[0] == "searchFilters" || params[0] == "mentioned_list") {
            var prjunid = $('#projFil').val();
            if (prjunid == 'all') {
                window.location = HTTP_ROOT + 'dashboard#tasks';
                return false;
            }
        }
        switch (params[0]) {
            case 'tasks':
                $('title').html(_('Task'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                if (getCookie('TASKGROUPBY') != 'milestone') {
                    $('#caseMenuFilters').val('');
                }
                if (isAllowed('Create Task')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task\');creatask();">' + _('Create Task') + '</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        $("#brdcrmb-cse-hdr").html(_('Tasks'));
                        if (params[1]) {
                            if (params[1].indexOf('custom-') > -1) {
                                $('#customFIlterId').val(params[1]);
                            }
                            refreshTasks = 1;
                            setSavedSrchFilter(params[0], params[1]);
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            refreshTasks = 1;
                            easycase.showTaskLists(params[0]);
                        }
                    }
                }
                break;
            case 'taskgroup':
                $('title').html(_('Task') + ' | ' + _('Task Group'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                if (isAllowed('Create Milestone')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">' + _('New Task Group') + '</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        $("#brdcrmb-cse-hdr").html(_('Tasks'));
                        if (params[1]) {
                            refreshTasks = 1;
                            if (params[1].indexOf('custom-') > -1) {
                                $('#customFIlterId').val(params[1]);
                            }
                            setSavedSrchFilter(params[0], params[1]);
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            easycase.showtaskgroup(params[0]);
                        }
                    }
                }
                break;
            case 'taskgroups':
                $('title').html(_('Task') + ' | ' + _('Task Group'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                taskGroupsData = 1;
                if (isAllowed('Create Milestone')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">' + _('New Task Group') + '</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        $("#brdcrmb-cse-hdr").html(_('Tasks'));
                        if (params[1]) {
                            refreshTasks = 1;
                            if (params[1].indexOf('custom-') > -1) {
                                $('#customFIlterId').val(params[1]);
                            }
                            setSavedSrchFilter(params[0], params[1]);
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            easycase.showtaskgroups(params[0]);
                        }
                    }
                }
                break;
            case 'backlog':
                $('title').html(_('Backlog'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                if (isAllowed('Create Task')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task\');creatask();">' + _('Create Task') + '</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        $("#brdcrmb-cse-hdr").html(_('Tasks'));
                        if (params[1]) {
                            setCustomStatus(params[0], params[1]);
                            $('#customFIlterId').val(params[1]);
                            refreshTasks = 1;
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            $('.slide_rht_con').css('margin-top', '-65px');
                            refreshTasks = 0;
                            easycase.showbacklog();
                        }
                    }
                }
                break;
            case 'activesprint':
                $('title').html(_('Active Sprint'));
                $('.sticky_footer').hide();
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                if (isAllowed('Create Task')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task\');creatask();">' + _('Create Task') + '</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        $("#brdcrmb-cse-hdr").html(_('Tasks'));
                        if (params[1]) {
                            setCustomStatus(params[0], params[1]);
                            $('#customFIlterId').val(params[1]);
                            refreshTasks = 1;
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            $(".task-list-bar").hide();
                            $('.slide_rht_con').css('margin-top', '-65px');
                            easycase.showsprint();
                        }
                    }
                }
                break;
            case 'subtask':
                $('title').html(_('Task') + ' | ' + _('Subtask'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                $('#caseMenuFilters').val('subtask');
                if (isAllowed('Create Milestone')) {
                    $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">New Task Group</a>');
                }
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", "Search Tasks");
                        $("#brdcrmb-cse-hdr").html('Tasks');
                        if (params[1]) {
                            setCustomStatus(params[0], params[1]);
                            $('#customFIlterId').val(params[1]);
                            refreshTasks = 1;
                        } else {
                            $('#customFIlterId').val('');
                            $('.case-filter-menu').hide();
                            $('.kanban_section').html('');
                            $('#mlsttab_sta').hide();
                            $("#widgethideshow").show();
                            easycase.subtask(params[0]);
                        }
                    }
                }
                break;
            case 'searchFilters':
                $('title').html(_('Task') + ' | ' + _('Filter'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.milestonenextprev').hide();
                $('#manage_milestonelist').hide();
                $('#select_view_mlst').hide();
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('#filtered_items').hide();
                    easycase.refreshTaskList();
                }
                break;
            case 'files':
                $('title').html(_('Task') + ' | ' + _('Files'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $("#case_search").attr("placeholder", _("Search Files"));
                    $('.customFilter').html('');
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#widgethideshow").hide();
                        easycase.showFiles(params[0]);
                    }
                }
                break;
            case 'kanban':
                $('title').html(_('Task') + ' | ' + _('Kanban'));
                $('.sticky_footer').hide();
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('#select_view_mlst').hide();
                $("#case_search").attr("placeholder", _("Search Tasks"));
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    if (isAllowed('Create Milestone')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">' + _('New Task Group') + '</a>');
                    }
                    if ($("#caseLoader").is(':visible') == false) {
                        if (($('#kanban_list').html() && refreshKanbanTask == 0 && !params[1])) {
                            easycase.routerHideShow('kanban');
                            scrollPageTop();
                            $('.custom_scroll').jScrollPane();
                            var settings = {
                                autoReinitialise: true
                            };
                            var pane = $(".custom_scroll");
                            pane.jScrollPane(settings);
                            $('#select_view div').removeClass('disable');
                            $('#kbview_btn').addClass('disable');
                        } else {
                            $("#widgethideshow").show();
                            easycase.showKanbanTaskList(params[0], '', 'stop_cls');
                        }
                    }
                }
                break;
            case 'milestone':
                $('title').html(_('Task') + ' | ' + _('Task Group'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $(".side-nav li").removeClass('active');
                $(".menu-milestone").addClass('active');
                if ($('#caseMenuFilters').val() == 'files') {
                    displayMenuProjects('dashboard', '6', '');
                }
                $('#caseMenuFilters').val('milestone');
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    $('#select_view').hide();
                    $('#select_view_mlst').show();
                    if (isAllowed('Create Milestone')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">' + _('New Task Group') + '</a>');
                    }
                    if ($("#caseLoader").is(':visible') == false) {
                        $("#case_search").attr("placeholder", _("Search Tasks"));
                        if ($('#manage_milestone_list').html() && refreshManageMilestone == 0) {
                            easycase.routerHideShow('milestone');
                            scrollPageTop();
                            $('#select_view_mlst div').removeClass('disable');
                            $('#mlview_btn').addClass('disable');
                        } else {
                            $('#milestoneLimit').val('0');
                            $('#totalMlstCnt').val('0');
                            $("#widgethideshow").show();
                            ManageMilestoneList();
                        }
                    }
                    $('#filter_section').hide();
                }
                break;
            case 'milestonelist':
                $('title').html(_('Task') + ' | ' + _('Kanban'));
                $('.sticky_footer').hide();
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    $('#select_view').hide();
                    $('#select_view_mlst').show();
                    $(".side-nav li").removeClass('active');
                    $(".menu-milestone").addClass('active');
                    $('#widgethideshow').hide();
                    if (isAllowed('Create Milestone')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Create Task Group\');addEditMilestone(\'\',\'\',\'\',\'\',\'\',\'\');">' + _('New Task Group') + '</a>');
                    }
                    if ($("#caseLoader").is(':visible') == false) {
                        $(".kanban_tsk_filter_sec").hide();
                        $("#case_search").val('');
                        $("#case_search").attr("placeholder", _("Search Task Groups"));
                        if ($('#milestonelist').html() && refreshMilestone == 0) {
                            easycase.routerHideShow('milestonelist');
                            scrollPageTop();
                            $('.custom_scroll').jScrollPane();
                            var settings = {
                                autoReinitialise: true
                            };
                            var pane = $(".custom_scroll");
                            pane.jScrollPane(settings);
                            $('#select_view_mlst div').removeClass('disable');
                            $('#mkbview_btn').addClass('disable');
                            showMilestoneList('', 1);
                        } else {
                            $('#milestoneLimit').val('0');
                            $('#totalMlstCnt').val('0');
                            $("#widgethideshow").show();
                            showMilestoneList();
                        }
                    }
                }
                break;
            case 'activities':
                $('title').html(_('Task') + ' | ' + _('Activities'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('#select_view_mlst').hide();
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    if ($("#caseLoader").is(':visible') == false) {
                        easycase.showActivities();
                    }
                }
                break;
            case 'mentioned_list':
                $('title').html(_('Task') + ' | ' + _('Mention List'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('#select_view_mlst').hide();
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    if ($("#caseLoader").is(':visible') == false) {
                        easycase.showMentionList();
                    }
                }
                break;
            case 'details':
                $('title').html(_('Task') + ' | ' + _('Detail'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                    $('.customFilter').html('');
                    easycase.showTaskDetail(params);
                }
                break;
            case 'caselist':
                $('title').html(_('Archive') + ' | ' + _('Task'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (CONTROLLER == 'archives' && PAGE_NAME == 'listall') {
                    $('.customFilter').html('');
                    caseListData = 1;
                    fileListData = 0;
                    changeArcCaseList('');
                }
                break;
            case 'filelist':
                $('title').html(_('Archive') + ' | ' + _('File'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (CONTROLLER == 'archives' && PAGE_NAME == 'listall') {
                    $('.customFilter').html('');
                    caseListData = 0;
                    fileListData = 1;
                    changeArcFileList('');
                }
                break;
            case 'calendar':
                $('title').html(_('Task') + ' | ' + _('Calendar'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('#topactions').show();
                $('.new_calendar_icon_on_top').show();
                if($('.qadd-tg-icon').length){
                    $('.qadd-tg-icon').hide();
                }
                calendarView('hash');
                break;
            case 'calendar_timelog':
                $('title').html(_('Time Log') + ' | ' + _('Calendar'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                getCalenderForTimeLog('hash');
                if (!(localStorage.getItem("theme_setting") === null)) {
                    var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                    $(".side-nav li").each(function() {
                        $(this).removeClass(th_class_str);
                    });
                    $('.menu-logs').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                }
                break;
            case 'chart_timelog':
                $('title').html(_('Time Log') + ' | ' + _('Chart'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (USER_SUB_NOW != EXPIRED_PLAN) {
                    if (isAllowed('Manual Time Entry')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Time Log\');createlog(0,\'\')">' + _('New Time Entry') + '</a>');
                    }
                }
                if (!(localStorage.getItem("theme_setting") === null)) {
                    var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                    $(".side-nav li").each(function() {
                        $(this).removeClass(th_class_str);
                    });
                    $('.menu-logs').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                }
                get_chart_timelog();
                break;
            case 'timesheet':
                $('title').html(_('Timesheet') + ' | ' + _('Daily'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (USER_SUB_NOW != EXPIRED_PLAN) {
                    if (isAllowed('Manual Time Entry')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Time Log\');createlog(0,\'\')">' + _('New Time Entry') + '</a>');
                    }
                }
                if (!(localStorage.getItem("theme_setting") === null)) {
                    var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                    $(".side-nav li").each(function() {
                        $(this).removeClass(th_class_str);
                    });
                    $('.menu-logs').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                }
                break;
            case 'timesheet_weekly':
                $('title').html(_('Timesheet') + ' | ' + _('Weekly'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (USER_SUB_NOW != EXPIRED_PLAN) {
                    if (isAllowed('Manual Time Entry')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Time Log\');createlog(0,\'\')">' + _('New Time Entry') + '</a>');
                    }
                }
                if (!(localStorage.getItem("theme_setting") === null)) {
                    var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                    $(".side-nav li").each(function() {
                        $(this).removeClass(th_class_str);
                    });
                    $('.menu-logs').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                }
                easycase.routerHideShow('timesheet_weekly');
                $('.menu_logs_cmn').removeClass('active');
                $('.menu_logs_wtsht').addClass('active');
                $(".menu_logs_cmn > a").removeClass(th_text_class_str);
                $('.menu_logs_wtsht > a').addClass(cstm_smenu_text_class);
                break;
            case 'overview':
                $('title').html(_('Project') + ' | ' + _('Overview'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                if (!(localStorage.getItem("theme_setting") === null)) {
                    var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                    $(".side-nav li").each(function() {
                        $(this).removeClass(th_class_str);
                    });
                    $('.projectMenuLeft').addClass(th_set_obj.sidebar_color + " gradient-shadow");
                }
                ajaxProjectOveriew(params_val);
                $('.projectReportMenuLeft').removeClass('active');
                break;
            case 'timelog':
                $('title').html(_('Time Log') + ' | ' + _('List'));
                $(".caseMenuLeft ul li > a,.caseMenuLeft ul li > a,.projectReportMenuLeft ul li > a,.menu-logs ul li > a,.miscellaneous_li ul li > a,.miscellaneous_li ul li > a").removeClass(th_text_class_str);
                $('.menu_logs_cmn').removeClass('active');
                $('.menu_logs_timelog').addClass('active');
                $(".menu_logs_cmn > a").removeClass(th_text_class_str);
                $('.menu_logs_timelog > a').addClass(cstm_smenu_text_class);
                var fil = $('#projFil').val().trim();
                if (USER_SUB_NOW != EXPIRED_PLAN) {
                    if (isAllowed('Manual Time Entry')) {
                        $('#new_onboarding_add_icon').html('<a class="btn btn_cmn_efect cmn_bg btn-info cmn_size' + cstm_clr_class + '" href="javascript:void(0)" onclick="setSessionStorage(\'Left Panel New Button\', \'Time Log\');createlog(0,\'\')">' + _('New Time Entry') + '</a>');
                    }
                }
                if (fil == 'all') {
                    var p_iid = $('#CS_project_id').val();
                    $('#projFil').val(p_iid);
                    var p_nm = $('#first_recent_hid').val();
                    updateAllProj('proj_' + p_iid, p_iid, 'dashboard', 0, p_nm, '');
                } else {
                    if ($("#tlog_externalfilter").val() == 1) {
                        $("#tlog_externalfilter").val('');
                    } else {
                        $('#logstrtdt,#logenddt').val('').datepicker('setStartDate', null);
                        $('#logstrtdt,#logenddt').val('').datepicker('setEndDate', null);
                        $('#rsrclog').val('');
                    }
                    break;
                }
                default:
                    if (CONTROLLER == 'archives' && PAGE_NAME == 'listall') {
                        $('.customFilter').html('');
                        caseListData = 1;
                        fileListData = 0;
                        changeArcCaseList('');
                    } else if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                        if (typeof params[1] == 'undefined') {
                            redirectToDefaultView();
                        }
                    }
        }
    }
}

function closePopup() {
    var refreshTasks = 1;
    var checkCls = '';
    if (typeof arguments[0] != 'undefined') {
        checkCls = arguments[0];
    }
    if (localStorage.getItem('url_type') == 'details' && localStorage.getItem('url_uniq') != '' && checkCls == 'dtl_popup') {
        $('.task_details_modal').removeClass('in');
        $('.task_details_modal').css("display", "none");
        $('.task_details_modal').css("padding-right", "0px");
        $('.task_details_popup').css("display", "none");
        localStorage.removeItem('url_type');
        localStorage.removeItem('url_uniq');
    }
    var inpt_params = $.trim(localStorage.getItem("change_reason_param"));
    if (inpt_params != '') {
        inpt_params = inpt_params.split('__');
        if ($('#' + inpt_params[5]).length) {
            $("#" + inpt_params[5]).html(inpt_params[4]);
            $("#" + inpt_params[3]).hide();
        }
    }
    localStorage.setItem("change_reason_editask", '');
    localStorage.setItem("change_reason_param", '');
    localStorage.setItem("common_due_change", '');
    localStorage.getItem("change_reason_duedt", '');
    if ($('.pp_close').is(':visible')) {
        $('.pp_content_container .pp_close').click();
    }
    if ($('.hopscotch-close').length && localStorage.getItem("tour_type") != '3' && localStorage.getItem("tour_type") != '2' && localStorage.getItem("tour_type") != '4') {
        $('.hopscotch-close').trigger('click');
    }
    var mntn_prnt_tsk_id = typeof getCookie("mntn_prnt_tsk_id") != "undefined" ? getCookie("mntn_prnt_tsk_id") : "";
    if (typeof arguments[0] != 'undefined' && arguments[0] == 'dtl_popup' && mntn_prnt_tsk_id != "") {
        createCookie('mntn_prnt_tsk_id', '', 1, DOMAIN_COOKIE);
        setTimeout(function() {
            $("#myModalDetail").modal();
            $(".task_details_popup").show();
            $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
            $("#cnt_task_detail_kb").html("");
            easycase.ajaxCaseDetails(mntn_prnt_tsk_id, 'case', 0, 'popup');
        }, 500);
    }
    createCookie('mntn_prnt_tsk_id', '', 1, DOMAIN_COOKIE);
    var chk_hash = getHash();
    if (chk_hash == 'files') {
        $('#myModalDetail').hide();
        $('#myModalDetail').removeClass('in');
        $('.task_details_popup').hide();
    }
    if (chk_hash == 'timesheet_weekly') {
        var prevDate = angular.element(document.getElementById('timesheetWeekly')).scope().prevDate;
        var nextDate = angular.element(document.getElementById('timesheetWeekly')).scope().nextDate;
        angular.element(document.getElementById('timesheetWeekly')).scope().getTasks(prevDate, nextDate);
        angular.element(document.getElementById('timesheetWeekly')).scope().$apply();
    }
    if (new_usr_html != '') {
        $('#inner_user').html(new_usr_html);
        $('.addMember_popup').html(_('Add'));
        $('.project_to_be_assn').show();
    }
    if ($('#prjList li').length || $('#userList li').length) {
        if (confirm(_('Please save the changes before leaving.'))) {
            return false;
        } else {
            if ($('#prjList li').length) {
                $('#prjList').html('');
            } else {
                $('#userList').html('');
            }
        }
    }
    if ($('#pagename').val() == 'profile' || $('#pagename').val() == 'manage') {
        $('#profilephoto').imgAreaSelect({
            hide: true
        });
        $('#up_files_photo').html('');
        $('.edit_profile_image').hide();
    }
    $(".popup_overlay_2").hide();
    $('#myModal').modal('hide');
    $(".sml_popup_bg").hide();
    $(".cmn_popup").hide();
    if (typeof on_cancel != 'undefined' && on_cancel == 1) {
        on_cancel = 0;
        $(".loader_dv").hide();
        $(".remove_from_task").show();
        $(".add_task_to_temp").hide();
    }
    $('#btn-add-new-project').addClass('loginactive');
    if (checkCls == 'onbd') {
        localStorage.setItem("OSTOUR", 1);
    }
    if (parseInt($("#subtask-container").height()) > 70) {
        ajaxCaseSubtaskView();
    }
    if (refreshTasks == 1 && checkCls == 'dtl_popup') {
        if (chk_hash == 'kanban') {} else if (chk_hash == 'milestonelist') {
            showMilestoneList();
        } else if (chk_hash == 'tasks' || chk_hash == 'taskgroup') {
            easycase.refreshTaskList();
        }
    }
    if (chk_hash == 'overview' && checkCls == 'dtl_popup') {
        $('#myModalDetail').removeClass('in');
        $('#myModalDetail').hide();
    }
    if (chk_hash == 'caselist' && checkCls == 'dtl_popup') {
        $('#myModalDetail').removeClass('in');
        $('#myModalDetail').hide();
        location.reload();
    }
    if ((chk_hash == 'tasks' || chk_hash == 'taskgroups' || chk_hash == 'backlog') && checkCls == 'dtl_popup') {
        $('#myModalDetail').removeClass('in');
        $('#myModalDetail').hide();
    }
    if (chk_hash == 'backlog' && checkCls != 'kc') {
        if (checkCls != 'mvtask') {
            easycase.showbacklog();
        }
    }
    if (chk_hash == 'activesprint' && checkCls != 'kc') {
        easycase.showsprint();
    }
    if (PAGE_NAME == 'completed_sprint_report') {
        sprint_reports.loadsprint();
    }
    if (PAGE_NAME == 'velocity_reports') {
        velocity_reports.loadVelocity();
    }
    if (checkCls == 'dtl_popup') {
        var new_url = localStorage.getItem("last_url");
        $('#myModalDetail').removeClass('in');
        $('#myModalDetail').hide();
        history.pushState({}, null, new_url);
        localStorage.setItem("last_url", '');
        var chk_hash = getHash();
        if ($.trim(chk_hash) != '') {
            easycase.routerHideShow(chk_hash);
        }
    }
}

function closeInvitePopup() {
    if ($('#pagename').val() == 'profile') {
        $('#profilephoto').imgAreaSelect({
            hide: true
        });
        $('#up_files_photo').html('');
    }
    $(".sml_popup_bg").hide();
    $(".cmn_popup").hide();
    $('#pop_up_add_user_label').hide();
    add_user($('#projectId').val(), $('#project_name').val());
}

function closeInvitePopupPj() {
    if ($('#pagename').val() == 'profile') {
        $('#profilephoto').imgAreaSelect({
            hide: true
        });
        $('#up_files_photo').html('');
    }
    $(".sml_popup_bg").hide();
    $(".cmn_popup").hide();
    $('.cancel_on_invite_pj').hide();
    $('.cancel_on_direct_pj').show();
    $('#pop_up_add_user_proj_label').hide();
    var usr_id = $('#user_id').val();
    var usr_name = $('#header_usr_prj_add').text();
    var is_invited_user = $("#is_invited_user").val();
    add_project(usr_id, usr_name, is_invited_user);
}

function closePopupEdit() {
    $(".loader_dv").hide();
    $(".remove_from_task").show();
    $(".task_project_edit").hide();
}

function createcompany() {
    openPopup();
    $(".create_company").show();
    $("#crt_cmp").hide();
    $(".loader_dv").show();
    var url = HTTP_ROOT + "users/add_your_company";
    $.post(url, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $("#crt_cmp").show().html(data);
            $.material.init();
            $(".select").dropdown({
                "optionClass": "withripple"
            });
        }
    });
}

function cancelSubPop() {
    openPopup();
    $(".cancel_subscription_pop").show();
    $("#cancel_subscription_pop").show();
}

function openPopup(role) {
    $('#myModal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    $(".cmn_popup").hide();
}
$(".more_in_menu").click(function() {
    var textData = $(".more_in_menu").html().trim();
    if (textData == _("More")) {
        $(this).next().removeClass("open_analytics_archive");
        $(this).next().addClass("menu_more_arr");
    } else {
        if ($(this).parent('li').hasClass("close")) {
            $(this).parent('li').removeClass("close");
        }
    }
});

function ReportMenu(uniq) {
    var prjid = $("#projFil").val();
    if (uniq != prjid) {
        resetAllFilters('all', 1);
    }
    var url = HTTP_ROOT;
    if (!uniq) {
        window.location = url + 'task-report/';
    } else {
        $('#main_con_task').load(url + 'reports/chart/ajax/' + uniq, function(res) {
            $('#pname_dashboard').html($('#pjname').val());
            $('#projpopup').hide();
        });
    }
}

function hoursreport(uniq) {
    var prjid = $("#projFil").val();
    if (uniq != prjid) {
        resetAllFilters('all', 1);
    }
    var url = HTTP_ROOT;
    if (!uniq) {
        window.location = url + 'hours-report/';
    } else {
        $('#main_con_hours').load(url + 'reports/hours_report/ajax/' + uniq, function(res) {
            general.update_footer_total(uniq);
            $('#pname_dashboard').html($('#pjname').val());
            $('#projpopup').hide();
        });
    }
}

function ReportGlideMenu(uniq) {
    var url = HTTP_ROOT;
    if (!uniq) {
        window.location = url + 'bug-report/';
    } else {
        $('#main_con').load(url + 'reports/glide_chart/ajax/' + uniq, function(res) {
            $('#pname_dashboard').html($('#pjname').val());
            $('#projpopup').hide();
        });
    }
}

function validatechart(type) {
    $('#apply_btn').hide();
    $('#apply_loader').show();
    var start_date = document.getElementById('start_date');
    var end_date = document.getElementById('end_date');
    var errMsg = "";
    var done = 1;
    if (start_date.value.trim() == "") {
        errMsg = _("From Date cannot be left blank!");
        start_date.focus();
        done = 0;
    } else if (end_date.value.trim() == "") {
        errMsg = _("To Date cannot be left blank!");
        end_date.focus();
        done = 0;
    } else if (Date.parse(start_date.value) > Date.parse(end_date.value)) {
        errMsg = _("From Date cannot exceed To Date!");
        end_date.focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        $('#apply_btn').show();
        $('#apply_loader').hide();
        return false;
    } else {
        var pjid = $('#pjid').val();
        var sdate = $('#start_date').val();
        var edate = $('#end_date').val();
        if (type == 'bug') {
            $('#piechart_container').load(HTTP_ROOT + 'reports/bug_pichart', {
                'type_id': 1,
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate,
                'dtsearch': 1
            }, function(res) {
                if (res.length > 150) {
                    $('#piechart_container').parent(".col-lg-6").addClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#piechart_container').parent(".col-lg-6").removeClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#statistic_container').load(HTTP_ROOT + 'reports/bug_statistics', {
                'type_id': 1,
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#statistic_container').parent(".col-lg-6").addClass('m-con');
                    $('#statistic_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#statistic_container').parent(".col-lg-6").removeClass('m-con');
                    $('#statistic_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#linechart_container').load(HTTP_ROOT + 'reports/bug_linechart', {
                'type_id': 1,
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#linechart_container').parent(".col-lg-12").addClass('con-100');
                    $('#linechart_container').parent(".col-lg-2").removeClass('error_box_main');
                } else {
                    $('#linechart_container').parent(".col-lg-2").removeClass('con-100');
                    $('#linechart_container').parent(".col-lg-12").addClass('error_box_main');
                }
            });
            $('#glide_container').load(HTTP_ROOT + 'reports/bug_glide', {
                'type_id': 1,
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#glide_container').parent(".col-lg-12").addClass('con-100');
                    $('#glide_container').parent(".col-lg-12").removeClass('error_box_main');
                } else {
                    $('#glide_container').parent(".col-lg-12").removeClass('con-100');
                    $('#glide_container').parent(".col-lg-12").addClass('error_box_main');
                }
                $('#apply_btn').show();
                $('#apply_loader').hide();
            });
        } else if (type == "hours") {
            $('#piechart_container').load(HTTP_ROOT + 'reports/hours_piechart', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate,
                'dtsearch': 1
            }, function(res) {
                if (res.length > 150) {
                    $('#piechart_container').parent(".col-lg-6").addClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#piechart_container').parent(".col-lg-6").removeClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#linechart_container').load(HTTP_ROOT + 'reports/hours_linechart', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#linechart_container').parent(".col-lg-6").addClass('m-con');
                    $('#linechart_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#linechart_container').parent(".col-lg-6").removeClass('m-con');
                    $('#linechart_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#grid_container').load(HTTP_ROOT + 'reports/hours_gridview', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if ($('#thrs').length > 0) {
                    $('#hrspent').html("<b>" + $('#thrs').val() + "</b> ");
                } else {
                    $('#hrspent').html("");
                }
                if (res.length > 150) {
                    $('#grid_container').parent(".col-lg-6").addClass('m-con');
                    $('#grid_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#grid_container').parent(".col-lg-6").removeClass('m-con');
                    $('#grid_container').parent(".col-lg-6").addClass('error_box');
                }
                $('#apply_btn').show();
                $('#apply_loader').hide();
            });
        } else if (type == "task") {
            $('#piechart_container').load(HTTP_ROOT + 'reports/tasks_pichart', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#piechart_container').parent(".col-lg-6").addClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#piechart_container').parent(".col-lg-6").removeClass('m-con');
                    $('#piechart_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#statistic_container').load(HTTP_ROOT + 'reports/tasks_statistics', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#statistic_container').parent(".col-lg-6").addClass('m-con');
                    $('#statistic_container').parent(".col-lg-6").removeClass('error_box');
                } else {
                    $('#statistic_container').parent(".col-lg-6").removeClass('m-con');
                    $('#statistic_container').parent(".col-lg-6").addClass('error_box');
                }
            });
            $('#container').load(HTTP_ROOT + 'reports/tasks_trend', {
                'pjid': pjid,
                'sdate': sdate,
                'edate': edate
            }, function(res) {
                if (res.length > 150) {
                    $('#container').parent(".col-lg-12").addClass('con-100');
                    $('#container').parent(".col-lg-12").removeClass('error_box_main');
                } else {
                    $('#container').parent(".col-lg-12").removeClass('con-100');
                    $('#container').parent(".col-lg-12").addClass('error_box_main');
                }
                $('#apply_btn').show();
                $('#apply_loader').hide();
            });
        } else if (type == "defect_report") {
            ajaxDefectReport();
            $("#apply_loader").hide();
            $("#apply_btn").show();
        }
    }
}

function scrolltotop() {
    $('html, body').animate({
        scrollTop: $(".popup_bg").offset().top - 200
    }, 1000);
}

function hideCmnMesg() {
    var div = $(".comn_message_div");
    $(".comn_message_div").fadeOut('slow');
    $('.comn_message_div_ctnir').html('');
    $(".comn_message_div").css('top', '-108px');
}
var time;

function showTopErrSucc(type, msg) {
    $(".comn_message_div").show();
    var chkflg = (typeof arguments[2] != 'undefined') ? 1 : 0;
    var div = $(".comn_message_div");
    div.clearQueue().stop().css({
        top: -108
    });
    var mes_d = '<a class="mesg_close_icon" onclick="hideCmnMesg();" href="javascript:void(0);">x</a>';
    if (type == 'error') {
        $('.comn_message_div_ctnir').removeClass('success');
        var materialIcon = '<i class="material-icons">&#xE14B;</i>';
    } else {
        $('.comn_message_div_ctnir').removeClass('error');
        var materialIcon = '<i class="material-icons">&#xE876;</i>';
    }
    $('.comn_message_div_ctnir').addClass(type);
    $('.comn_message_div_ctnir').html('<div class="checkInnerHeight">' + materialIcon + ' ' + mes_d + ' ' + msg + '</div>');
    div.animate({
        top: '108px'
    }, "slow");
    div.animate({
        height: (parseInt($(".checkInnerHeight").height()) + parseInt(30)) + 'px'
    }, "slow");
    clearTimeout(time);
    if (chkflg == 0) {
        time = setTimeout(hideCmnMesg, 2700);
    }
}

function showSaveFilter() {
    $(".sml_popup_bg").css({
        display: "block"
    });
    saveAllFilters();
}

function saveAllFilters() {
    var caseStatus = $('#caseStatus').val();
    var caseType = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseDate = $('#caseDateFil').val();
    var caseMemeber = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var casePriority = $('#priFil').val();
    var caseSearch = $('#caseSearch').val();
    var strURL = HTTP_ROOT + "easycases/";
    $.post(strURL + "ajax_save_filter", {
        'caseStatus': caseStatus,
        'caseType': caseType,
        'caseLabel': caseLabel,
        'caseDate': caseDate,
        'caseMemeber': caseMemeber,
        'caseAssignTo': caseAssignTo,
        'casePriority': casePriority,
        'caseSearch': caseSearch
    }, function(data) {
        if (data) {
            $('#inner_save_filter_td').html(data);
            $('#savefilter_name').focus();
        }
    });
}

function submitfilter() {
    $(".eror_txt").hide();
    var filtername = $('#savefilter_name').val();
    if (filtername.trim() != "") {
        var filter_case_status = $('#fstatus').val();
        var filter_date = $('#fdate').val();
        var filter_duedate = $('#fduedate').val();
        var filter_type = $('#ftype').val();
        var filter_priority = $('#fpriority').val();
        var filter_member = $('#fmember').val();
        var filter_assignto = $('#fassignto').val();
        var filter_search = $('#fsearch').val();
        var projuniqid = $('#projFil').val();
        $("#saveFilBtn").hide();
        $("#svloader").show();
        var strURL = HTTP_ROOT + "easycases/";
        $.post(strURL + "ajax_customfilter_save", {
            'caseStatus': filter_case_status,
            'caseType': filter_type,
            'caseDate': filter_date,
            'casedueDate': filter_duedate,
            'caseMemeber': filter_member,
            'caseAssignTo': filter_assignto,
            'casePriority': filter_priority,
            'filterName': filtername,
            'projuniqid': projuniqid,
            'caseSearch': filter_search
        }, function(data) {
            if (data) {
                if (data == 'success') {
                    showTopErrSucc('success', _('Custom filter saved sucessfully..'));
                    closePopup();
                    resetAllFilters();
                    $("#customFil").addClass('open');
                    openAjaxCustomFilter('auto');
                    var hashtag = parseUrlHash(urlHash);
                    if (hashtag[0] == 'kanban') {
                        easycase.showKanbanTaskList('kanban');
                    } else {
                        ajaxCaseView('case_project');
                    }
                } else {
                    showTopErrSucc('error', _('Custom filter name already exists..'));
                    showSaveFilter();
                    $('#savefilter_name').focus();
                }
            }
        });
    } else {
        $(".eror_txt").show();
        $('#savefilter_name').focus();
    }
}
$(document).keypress(function(evt) {
    if (evt.keyCode == 27) {
        $("#inner_save_filter").hide();
    }
});

function jsVoid() {}

function removeMsg() {
    $('#upperDiv').fadeOut(300);
    $("#btnDiv").hide();
}

function removeMsg_err() {
    $('#upperDiv_err').fadeOut(300);
    $("#btnDiv").hide();
}

function removeMsg_alert() {
    $('#upperDiv_alert').fadeOut(300);
    $("#btnDiv").hide();
}

function removeMsg_not() {
    $('#upperDiv_not').fadeOut(300);
    $("#btnDiv").hide();
}
var memberListLoaded = 0;
var projectListLoaded = 0;

function changeTemplateWorkflow(type) {
    wf = $('.proj_methodology').select2('data')[0].element.attributes[1].nodeValue;
    if (wf == 0) {
        if (typeof type != "undefined") {
            if (type == "status") {
                wf = $("#new_status_crt option:first").val();
            } else {
                wf = $("#bug_new_status_crt option:first").val();
            }
        } else {
            wf = $("#new_status_crt option:first").val();
        }
    }
    if (typeof type != "undefined") {
        if (type == "status") {
            $("#new_status_crt").val(wf);
        } else {
            $("#bug_new_status_crt").val(wf);
        }
    } else {
        $("#new_status_crt").val(wf);
    }
    $(".new_status_crt").select2();
}

function newProject() {
    if ((SES_COMP == '20234' || SES_COMP == '34914' || SES_COMP == '19398') && SES_TYPE == '3') {
        showTopErrSucc('error', _('Oops! You are not authorized to add new Project. Please contact your account owner/admin.'));
        return false;
    }
    if (TOTAL_PROJECT && TOTAL_PROJECT >= PROJECT_LIMIT) {
        if (SES_TYPE == '3') {
            var limit_msg = _('Sorry, Project Limit Exceeded') + '. ' + _('Please contact your account owner to Upgrade the account to create more projects');
        } else {
            var limit_msg = _('Sorry, project limit exceeded. Please upgrade') + '.';
        }
        showTopErrSucc('error', limit_msg);
        return false;
    }
    $('#allc_users').prop('checked', false);
    if ($('#prjList li').length) {
        if (confirm(_('Please save the changes before leaving.'))) {
            return false;
        } else {
            $('#prjList').html('');
        }
    }
    $(".add_usr_prj").hide();
    openPopup();
    $(".new_project").show();
    $(".loader_dv").hide();
    var chk_proj = 0;
    if (arguments[0] !== undefined && arguments[0] !== 'newproject') {
        $('.cancel_on_invite_pj').show();
        $('.cancel_on_direct_pj').hide();
        chk_proj = 1;
    } else {
        $('.cancel_on_invite_pj').hide();
        $('.cancel_on_direct_pj').show();
    }
    if (arguments[2] && arguments[3]) {
        var temp_id = arguments[2];
        $('.cancel_on_invite_pj').hide();
        $('.cancel_on_direct_pj').show();
    }
    var custom_sts_id = 0;
    if (typeof arguments[4] != 'undefined') {
        custom_sts_id = arguments[4];
    }
    var projMethodology = 0;
    if (typeof arguments[5] != 'undefined') {
        projMethodology = arguments[5];
    }
    $('.proj_prioty').val('').select2();
    $('.proj_methodology').select2().on('select2:select', function(evt) {
        changeTemplateWorkflow();
    });
    if ($('.proj_methodology').find('option').length <= 2) {
        $.post(HTTP_ROOT + "templates/get_project_templates", {}, function(res) {
            if (Object.keys(res.result).length > 0) {
                $('.proj_methodology').html('');
                $.each(res.result, function(key, val) {
                    $('.proj_methodology').append($('<option>').attr('value', val.ProjectMethodology.id).attr('data-val', val.ProjectMethodology.status_group_id).html(val.ProjectMethodology.title));
                });
                $('.proj_methodology').val((projMethodology != 0) ? projMethodology : $(".proj_methodology option:first").val());
                $('.proj_methodology').change();
                changeTemplateWorkflow();
            }
        }, 'json');
    } else {
        $('.proj_methodology').val((projMethodology != 0) ? projMethodology : $(".proj_methodology option:first").val());
        $('.proj_methodology').change();
        changeTemplateWorkflow();
    }
    var c = HTTP_ROOT + "templates/all_task_templates";
    $.post(c, {
        val: "proj_create"
    }, function(a) {
        a && ($("#task_type").html(a), $.material.init(), $(".new_template_crt_tmpl").select2({
            templateSelection: formatTaskType,
            templateResult: formatTaskType
        }), $("textarea").autoGrow().keyup())
    });
    $.post(HTTP_ROOT + "projects/ajax_get_all_meta", {
        val: "create"
    }, function(res) {
        $('.proj_type').html('');
        $('.proj_status').html('');
        $('.proj_manager').html('').select2();
        $('.proj_client').html('').select2();
        $('.proj_industry').html('').select2();
        $('#budget').html('');
        $('#default_rate').html('');
        $('#cost_appr').html('');
        $('#min_tolerance').html('');
        $('#max_tolerance').html('');
        if (res.All_ptypes) {
            $.each(res.All_ptypes, function(key, value) {
                $('.proj_type').append('<option value="' + key + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
            });
            $('.proj_type').val(0);
            $('.proj_type').trigger('change');
        }
        if (res.All_industry) {
            $.each(res.All_industry, function(key, value) {
                $('.proj_industry').append('<option value="' + key + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
            });
            $('.proj_industry').val(0);
            $('.proj_industry').trigger('change');
        }
        if (res.All_customers) {
            $.each(res.All_customers, function(key, value) {
                var t_client = key.split('__');
                $('.proj_client').append('<option value="' + t_client[0] + '" data-cust="' + t_client[1] + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
            });
            $('.proj_client').val(0);
            $('.proj_client').trigger('change');
        }
        if (res.All_managers) {
            $.each(res.All_managers, function(key, value) {
                $('.proj_manager').append('<option value="' + key + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
            });
            $('.proj_manager').val(0);
            $('.proj_manager').trigger('change');
        }
        if (res.All_psttaus) {
            $.each(res.All_psttaus, function(key, value) {
                $('.proj_status').append('<option value="' + key + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
            });
            $('.proj_status').val(0);
            $('.proj_status').trigger('change');
        }
        if (SES_TYPE == 3) {
            $(".proj_type").select2();
        } else {
            $(".proj_type").select2({
                tags: true,
                maximumInputLength: 40,
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
                        var msg = _("'Project Type' must not contain special characters!");
                        showTopErrSucc('error', msg);
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                }
            }).off('select2:select').on('select2:select', function(evt) {
                if (evt.params.data.newTag == true) {
                    var name = evt.params.data.id;
                    $('#caseLoader').show();
                    $.post(HTTP_ROOT + 'projects/ajax_addProjectType', {
                        'name': evt.params.data.id
                    }, function(res) {
                        $('#caseLoader').hide();
                        if (res.status == 'error' && res.msg == 'name') {
                            showTopErrSucc('error', _('Project Type already esists!. Please enter another name.'));
                            $('.proj_type option[value="' + name + '"]').remove();
                            $('.proj_type').trigger('change');
                        } else if (res.status == 'success') {
                            if (res.msg == 'saved') {
                                showTopErrSucc('success', _('Project Type Successfully Added'));
                                $(".proj_type").append("<option value='" + res.id + "' selected>" + name + "</option>");
                                $('.proj_type option[value="' + res.id + '"]').prop('selected', true);
                                $('.proj_type').trigger('change');
                            } else {
                                showTopErrSucc('error', _('Project Type can not be added'));
                                $('.proj_type').trigger('change');
                            }
                        }
                    }, 'json');
                }
            });
        }
        if (SES_TYPE == 3) {
            $(".proj_status").select2();
        } else {
            $(".proj_status").select2({
                tags: true,
                maximumInputLength: 40,
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
                        var msg = _("'Project Status' must not contain special characters!");
                        showTopErrSucc('error', msg);
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                }
            }).off('select2:select').on('select2:select', function(evt) {
                if (evt.params.data.newTag == true) {
                    var name = evt.params.data.id;
                    $('#caseLoader').show();
                    $.post(HTTP_ROOT + 'projects/ajax_addProjectStatus', {
                        'name': evt.params.data.id
                    }, function(res) {
                        $('#caseLoader').hide();
                        if (res.status == 'error' && res.msg == 'name') {
                            showTopErrSucc('error', _('Project Status already esists!. Please enter another name.'));
                            $('.proj_status option[value="' + name + '"]').remove();
                            $('.proj_status').trigger('change');
                        } else if (res.status == 'success') {
                            if (res.msg == 'saved') {
                                showTopErrSucc('success', _('Project Status Successfully Added'));
                                $(".proj_status").append("<option value='" + res.id + "' selected>" + name + "</option>");
                                $('.proj_status option[value="' + res.id + '"]').prop('selected', true);
                                $('.proj_status').trigger('change');
                            } else {
                                showTopErrSucc('error', _('Project Status can not be added'));
                                $('.proj_status').trigger('change');
                            }
                        }
                    }, 'json');
                }
            });
        }
    }, 'json');
    $('.proj_currency').select2();
    $('.proj_currency').val(144);
    $('.proj_currency').trigger('change');
    var urls = HTTP_ROOT + 'templates/all_workflows';
    $.post(urls, {
        'val': 'proj_create',
        'type': 'status'
    }, function(res) {
        if (res) {
            $('#wrkflow_dropdown').html(res);
            $.material.init();
            $(".new_status_crt").select2();
            changeTemplateWorkflow('status');
            if (custom_sts_id != 0) {
                $("#new_status_crt").val(custom_sts_id).trigger('change');
            }
        }
    });
    var urlb = HTTP_ROOT + 'templates/all_workflows';
    $.post(urlb, {
        'val': 'proj_create',
        'type': 'bug'
    }, function(res) {
        if (res) {
            $('#bug_wrkflow_dropdown').html(res);
            $.material.init();
            $(".new_status_crt").select2();
            changeTemplateWorkflow('bug');
            if (custom_sts_id != 0) {
                $("#bug_new_status_crt").val(custom_sts_id).trigger('change');
            }
        }
    });
    $('#inner_proj .proj_mem_chk').attr('checked', true);
    $('#validate').val(0);
    $('#inner_proj #members_list, #inner_proj #txt_Proj, #inner_proj #txt_shortProj, #txt_ProjStartDate, #txt_ProjEndDate, #txt_ProjEsthr').val('');
    $('#members_list,#txt_Proj,#txt_shortProj,#prj_desc').val('');
    $('#inner_proj').find('#err_msg').hide();
    $('#err_msg').html('');
    $('#inner_proj').show();
    if (!memberListLoaded) {
        getMemeberList();
    }
    memberListLoaded = 1;
    resetAllFilters('all', 1);
    setTimeout(function() {
        $("#txt_Proj").focus();
    }, 500);
}

function numeric_decimal_proj(e, typ) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode < 9 || unicode > 9 && unicode < 46 || unicode > 57 || unicode == 47 || unicode == 186 || unicode == 58 || unicode == 46) {
            if (typ == '1' && unicode == 46) {
                return true;
            } else if (unicode == 37 || unicode == 38 || unicode == 186) {
                if (unicode == 37) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}
var collection = new Array();

function getMemeberList() {
    var url = HTTP_ROOT;
    $.post(url + "projects/member_list", function(res) {
        if (res) {
            var cnt = 0;
            $.each(res, function(key, value) {
                cnt++;
                if (value != 'null') {
                    collection.push(value);
                }
            });
            if (cnt >= 1) {
                $('#default_assignto_tr').show();
                $('#add_new_member_txt').text(_('Add Users'));
            }
            siw = null;
            if (document.addEventListener) {
                document.addEventListener("keydown", handleKeyDown, false);
                document.addEventListener("keyup", handleKeyPress, false);
                document.addEventListener("mouseup", handleClick, false);
                document.addEventListener("mouseover", handleMouseOver, false);
            } else {
                document.onkeydown = handleKeyDown;
                document.onkeyup = handleKeyPress;
                document.onmouseup = handleClick;
                document.onmouseover = handleMouseOver;
            }
            registerSmartInputListeners();
            $('#autopopup').html('<table id="smartInputFloater" class="floater" cellpadding="0" cellspacing="0"><tr><td id="smartInputFloaterContent" nowrap="nowrap" style="padding:0px 0px 0px 0px;text-align: left;font-size:14px;"><\/td><\/tr><\/table>');
            for (x = 0; x < collection.length; x++) {
                collection[x] = collection[x].replace(/\,/gi, '');
            }
            collectionIndex = new Array();
            ds = "";
        }
    }, 'json');
}

function getProjectList() {
    var url = HTTP_ROOT;
    $.post(url + "users/getProjects", {
        serch_chk: 0
    }, function(res) {
        if (res) {
            var cnt = 0;
            $.each(res, function(key, value) {
                cnt++;
                if (value != 'null') {
                    collection.push(value);
                }
            });
            if (cnt >= 1) {
                $('#default_assignto_tr').show();
                $('#add_new_member_txt').text(_('Add Users'));
            }
            siw = null;
            if (document.addEventListener) {
                document.addEventListener("keydown", handleKeyDown, false);
                document.addEventListener("keyup", handleKeyPress, false);
                document.addEventListener("mouseup", handleClick, false);
                document.addEventListener("mouseover", handleMouseOver, false);
            } else {
                document.onkeydown = handleKeyDown;
                document.onkeyup = handleKeyPress;
                document.onmouseup = handleClick;
                document.onmouseover = handleMouseOver;
            }
            registerSmartInputListeners();
            $('#autopopup_projects').html('<table id="smartInputFloater" class="floater" cellpadding="0" cellspacing="0"><tr><td id="smartInputFloaterContent" nowrap="nowrap" style="padding:0px 0px 0px 0px;text-align: left;font-size:14px;"><\/td><\/tr><\/table>');
            for (x = 0; x < collection.length; x++) {
                collection[x] = collection[x].replace(/\,/gi, '');
            }
            collectionIndex = new Array();
            ds = "";
        }
    }, 'json');
}

function addremoveadmin(obj) {
    var projectuserid = $(obj).val();
    var projectusername = $('#puser' + projectuserid).text();
    if ($(obj).is(":checked")) {
        var selectoptions = "<option value='" + projectuserid + "' selected='selected'>" + projectusername + "</option>";
        $("#select_default_assign option").removeAttr('selected');
        $("#select_default_assign").append(selectoptions);
        if ($('#resourcelist').html() != '') {
            add_resource(projectuserid);
        }
    } else {
        $("#select_default_assign option[value='" + projectuserid + "']").remove();
        if ($('#resourcelist').html() != '') {
            manage_resource(projectuserid);
        }
    }
    if ($('input[class=proj_mem_chk]:checked').length == $('input[class=proj_mem_chk]').length) {
        $('#alladmn_users').prop('checked', true);
    } else {
        $('#alladmn_users').prop('checked', false);
    }
}

function startTourCrtTask() {
    if (LANG_PREFIX == '_fra') {
        GBl_tour = tour_crttask_fra;
    } else if (LANG_PREFIX == '_por') {
        GBl_tour = tour_crttask_por;
    } else if (LANG_PREFIX == '_spa') {
        GBl_tour = tour_crttask_spa;
    } else if (LANG_PREFIX == '_deu') {
        GBl_tour = tour_crttask_deu;
    } else {
        GBl_tour = tour_crttask;
    }
    hopscotch.startTour(GBl_tour);
}

function custom_date_field() {
    $('.custom_field_datpicker').datepicker({
        format: "M d, yyyy",
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $(this).datepicker("getFormattedDate");
    });
}

function showTaskCustomFields() {
    $.post(HTTP_ROOT + "projects/ajaxShowTaskCustomFields", {}, function(res) {
        $("#custom_field_container").html(tmpl("case_customfield_tmpl", res));
        custom_date_field();
    }, 'json');
}

function creatask() {
    if (PAGE_NAME == "resource_availability") {
        $('#myModal').modal('hide');
        $(".cmn_popup").hide();
        $('#options_div').hide();
    }
    if (typeof hopscotch != 'undefined' && $('.hopscotch-close').length) {
        localStorage.setItem("onboard_is_on", 1);
    } else {
        localStorage.setItem("onboard_is_on", 0);
    }
    $('#create_another_task_dv').show();
    if (arguments[1] != 'new') {
			$('#create_another_task').prop('checked', false);
			$("#priority_low1").prop('checked', true);
			$("#priority_mid1").prop('checked', false);
			$("#priority_high1").prop('checked', false);
		}
    mention_array['mention_type_id'] = new Array();
    mention_array['mention_type'] = new Array();
    mention_array['mention_id'] = new Array();
    $('.crttask_overlay').show();
    $('.slide_rht_con').hide();
    $('body').css('overflow-y', 'auto');
    if ($('.hopscotch-close').length) {
        $('.hopscotch-close').trigger('click');
    }
    $('#startTourBtn').hide();
    if (PAGE_NAME == 'ganttv2' || PAGE_NAME == 'dhtmlxgantt') {
        $('body').css({
            'overflow': 'auto'
        });
    }
    var prjunid = $('#projFil').val();
    if (prjunid == 'all') {
        showTopErrSucc('error', _('Oops! You are in') + " " + _('All') + " " + _('project. Please choose a project.'));
        $('.crttask_overlay').hide();
        $('.slide_rht_con').show();
        return false;
    }
    if (arguments[1] != 'new') {
        $('.prj-select').val($('#CS_project_id').val());
    }
    $('.prj-select').prop('disabled', false);
    var selectizeProj = $('.prj-select').select2({
        dropdownCssClass: 'dropprojt'
    }).on('select2:select', function(evt) {
        showProjectNameNew(evt.params.data.text, evt.params.data.id, '', '', '', '');
    });
    if ($('#boarding').val() == 1 || $('#boardingprj').val() == 1) {
        window.location = HTTP_ROOT + 'projects/manage';
    } else {
        if ($("#caseLoader").is(':visible')) {
            return;
        }
        if (arguments[1] != 'new') {
            $('#hiddensavennew').val('0');
            $('.is_bilable').prop('checked', false);
        } else {
            $('#hiddensavennew').val('1');
        }
        if (typeof arguments[0] == 'undefined') {
            $('#CS_start_date').val('');
            $('#CS_due_date').val('');
        }
        $('#due_date').prop('disabled', false);
        $('#quickcase').html(_('Save'));
        $('#sendCaret').show();
        $('#quickcase').next('span').show();
        $('#taskheading').html(_('Create Task'));
        $('.crtskmenus').closest('span').removeClass('open');
        $('.project-dropdown').hide();
        $('.project-dropdown').prev('li').hide();
        $('.milestonekb_detail_head').hide();
        $('#make_client').prop('checked', false);
        chk_client();
        $('#opt3').parent().removeClass('option-toggle_active').addClass('option-toggle');
        $('#date_dd').css('font-weight', 'normal');
        $('.archive_filter_det').hide();
        $('.invoice_filter_det').hide();
        $('#CS_title').val('');
        $('#is_recurring').prop('disabled', false);
        $('.task-list-bar').hide();
        $('.page_ttle_toptxt').hide();
        $('.crt_task_btn_btm').hide();
        $('#up_files').find('tr').remove();
        if ($('#easycase_uid').val()) {
            $('#edit_project_div').hide();
            $('#create_project_div').show();
            $('#edit_project_div').html('');
            $('#CS_project_id').val($('#curr_active_project').val());
            $('#easycase_uid').val('');
            $('#CSeasycaseid').val('');
            $('#CS_title').val('');
            $('#CS_parent_task').val('');
            $('#drive_tr_0').remove();
            $('#usedstorage').val('');
            $('#up_files').empty();
            $('#CS_message').val('');
            $('#ctask_btn').html(_('Create'));
            $('#taskheading').html(_('Create Task'));
            $('#ctask_icons').removeClass('icon-edit-tsk').addClass('icon-create-tsk')
            $('.loader_dv_edit').hide();
        }
        $('#editRemovedFile').val('');
        var mid = '';
        if (arguments[0] && ($('#main-title-holder_' + arguments[0] + ' a').text().trim() != '' || $('#miview_' + arguments[0]).text().trim() != '')) {
            mid = arguments[0];
        }
        var tskgrp = '';
        if (typeof arguments[2] != 'undefined') {
            tskgrp = arguments[2];
        }
        var assignto = '';
        if (typeof arguments[3] != 'undefined') {
            assignto = arguments[3];
        }
        var d_date = '';
        if (arguments[4] != '') {
            d_date = arguments[4];
        }
        showProjectNameNew($('.prj-select option:selected').html().trim(), $('.prj-select').val(), mid, tskgrp, assignto, d_date);
        if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
            $(".side-nav li").removeClass('active');
            $(".menu-cases").addClass('active');
            if (!(localStorage.getItem("theme_setting") === null)) {
                var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                $(".side-nav li").each(function() {
                    $(this).removeClass(th_class_str);
                });
                $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
            }
            $("#widgethideshow").hide();
            $(".milestonenextprev").hide();
        }
        $('.task_detail_head').hide();
        $(".slide_rht_con").animate({
            width: "100%",
            marginLeft: "-105%"
        }, "fast", function() {
            $(".crt_tsk").show();
            $("#caseViewSpanUnclick").hide();
            var marginlft = '-72px';
            var params = parseUrlHash(urlHash);
            if (params[0] == 'details') {
                marginlft = '-16px';
            } else if (CONTROLLER == 'users' && PAGE_NAME == 'getting_started') {
                marginlft = '20px';
            }
            $(".crt_tsk").animate({
                marginLeft: "0",
                marginTop: marginlft,
                right: "auto"
            }, "fast");
            if (params[0] == 'overview') {
                $(".crt_tsk").css({
                    'marginTop': marginlft,
                    'marginLeft': "0",
                    'right': 'auto'
                });
            }
            $('#CS_title').focus();
            $('.slide_rht_con').hide();
        });
        $(".breadcrumb_div,.case-filter-menu").hide();
        $('.dashborad-view-type').hide();
        $(".crt_slide").css({
            display: "block"
        });
        $("#footersection").hide();
        $('.InvoiceDownloadEmail').hide();
        scrollPageTop();
        $('#CS_title').focus();
        openEditor('', is_basic_or_free);
    }
    var hasharr = getHash().split('/');
    if (hasharr[0] == 'details') {
        $(".create-task-container").addClass('create_task_detail_pop');
    } else {
        $(".create-task-container").removeClass('create_task_detail_pop');
    }
    if ($('#fst_invite_chk').val() == '1') {
        $('#startTourBtn').show();
        if (typeof hopscotch != 'undefined') {
            setTimeout(function() {
                hopscotch.startTour(tour_crttask);
                remember_filters('FIRST_INVITE_2', '');
                $('#fst_invite_chk').val(0);
            }, 2000);
        }
    } else {
        if (LANG_PREFIX == '_fra') {
            GBl_tour = tour_crttask_fra;
        } else if (LANG_PREFIX == '_por') {
            GBl_tour = tour_crttask_por;
        } else if (LANG_PREFIX == '_spa') {
            GBl_tour = tour_crttask_spa;
        } else if (LANG_PREFIX == '_deu') {
            GBl_tour = tour_crttask_deu;
        } else {
            GBl_tour = tour_crttask;
        }
        $('#startTourBtn').show();
    }
}

function reloadTaskDetail(caseid) {
    easycase.ajaxCaseDetails(caseid, 'case', 0);
}

function restoreTaskDetail(caseid, caseNo) {
    var isDtlPop = (typeof arguments[2] != 'undefined' && arguments[2] == 'popdtl') ? 1 : 0;
    if (confirm(_("Are you sure you want to restore task #") + caseNo + " ?")) {
        var caseids = Array();
        caseids.push(caseid);
        $.post(HTTP_ROOT + "archives/move_list", {
            "val": caseids
        }, function(data) {
            if (data) {
                if (isDtlPop) {
                    easycase.ajaxCaseDetails(caseid, 'case', 0, 'popup');
                    showTopErrSucc('success', _("Task #") + caseNo + " " + _("has been restored."));
                }
            }
        });
    }
}

function editask(csuid, projUid, projName) {
    localStorage.setItem("change_reason_editask", '');
    $('#create_another_task').prop('checked', false);
    $('#create_another_task_dv').hide();
    $('.crttask_overlay').show();
    $('.slide_rht_con').hide();
    $('body').css('overflow-y', 'auto');
    if ($(".link-to-select").val() != 'null') {
        $(".link-to-select").val('').trigger("change");
    }
    if (typeof csuid == 'undefined') {
        csuid = 0;
    }
    mention_array['mention_type_id'] = new Array();
    mention_array['mention_type'] = new Array();
    mention_array['mention_id'] = new Array();
    if (csuid) {
        $('.task_detail_head').hide();
				$('#myModalDetail').hide();
        $('.milestonekb_detail_head').hide();
        $('.task-list-bar').hide();
        $(".slide_rht_con").animate({
            width: "100%",
            marginLeft: "-105%"
        }, "fast", function() {
            $(".crt_tsk").show();
            $("#caseViewSpan").hide();
            var marginlft = '-72px';
            var params = parseUrlHash(urlHash);
            if (params[0] == 'details') {
                marginlft = '-16px';
            }
            $(".crt_tsk").animate({
                marginLeft: "0",
                marginTop: marginlft,
                right: "auto"
            }, "fast");
            $('#CS_title').focus();
        });
        var hasharr = getHash().split('/');
        if (hasharr[0] == 'details') {
            $(".create-task-container").addClass('create_task_detail_pop');
        } else {
            $(".create-task-container").removeClass('create_task_detail_pop');
        }
        $(".breadcrumb_div,.case-filter-menu").hide();
        $('.dashborad-view-type').hide();
        $(".crt_slide").css({
            display: "block"
        });
        $('#create_project_div').hide();
        $('#edit_project_div').show();
        if (projName.length > 20) {
            projName = projName.substr(0, 17) + '...';
        }
        $('#edit_project_div').css('margin-top', '10px');
        $('#edit_project_div').html(projName);
        $('#CS_project_id').val(projUid);
        $('#quickcase').html(_('Update'));
        $('#quickcase').next('span').hide();
        $('#sendCaret').hide();
        $('.project-dropdown').hide();
        $('.project-dropdown').prev('li').hide();
        $('#taskheading').html(_('Edit Task'));
        $('#drive_tr_0').remove();
        $('#usedstorage').val('');
        $('#up_files').empty();
        $('#CS_message').val('');
        $('#CS_milestone').val('');
        $('#CS_parent_task').val('');
        $('#ctask_icons').removeClass('icon-create-tsk').addClass('icon-edit-tsk')
        $('.popup_overlay').show();
        $('.loader_dv_edit').show();
        $('#editRemovedFile').val('');
        $('.page_ttle_toptxt').hide();
        focus_txt();
        scrollPageTop();
        $.post(HTTP_ROOT + 'easycases/edit_task_details', {
            'csUniqid': csuid
        }, function(res) {
            $("#footersection").hide();
            var projFil = $('#projFil').val();
            if (!check_empty(res.mention_array)) {
                if (res.mention_array.mention_type.length > 0) {
                    $.each(res.mention_array.mention_type, function(index, value) {
                        mention_array['mention_type_id'].push(res.mention_array.mention_type_id[index]);
                        mention_array['mention_type'].push(res.mention_array.mention_type[index]);
                        mention_array['mention_id'].push(res.mention_array.mention_id[index]);
                    });
                }
            }
            if (!check_empty(res.caseCustomFieldDetails)) {
                $("#custom_field_container").html(tmpl("case_customfield_tmpl", res));
                custom_date_field();
            }
            if (res.files) {
                var file = '';
                var incr = 1;
                $.each(res.files, function(key, value) {
                    var sizeinMb = parseFloat(value.CaseFile.file_size) / 1024;
                    var d_name = value.CaseFile.file;
                    if (value.CaseFile.display_name) {
                        d_name = value.CaseFile.display_name;
                    }
                    file += '<tr style=""><td valign="top" style="color:#0683B8;"><div id="jquerydiv' + incr + '"><input type="checkbox" style="cursor:pointer;" onclick="return hideEditFile(\'jqueryfile' + incr + '\',\'jquerydiv' + incr + '\',' + sizeinMb + ',' + value.CaseFile.id + ');" checked="">&nbsp;&nbsp;<a style="text-decoration:underline;position:relative;top:-2px;" href="' + HTTP_ROOT + 'easycases/download/' + value.CaseFile.file + '">' + d_name + ' (' + value.CaseFile.file_size + ' Kb)</a><input type="hidden" value="' + value.CaseFile.file + '|' + value.CaseFile.file_size + '|' + value.CaseFile.id + '" id="jqueryfile' + incr + '" name="data[Easycase][name][]" class="ajxfileupload"></div></td></tr>';
                    incr++;
                });
                $('#up_files').html(file);
                $('#totfiles').val(--incr);
            }
            $.post(HTTP_ROOT + "easycases/ajax_quickcase_mem", {
                "projUniq": projUid,
                'csuniqid': res.data.id,
                "pageload": 0
            }, function(data) {
                if (data) {
                    PUSERS = data.quickMem;
                    defaultAssign = data.defaultAssign;
                    dassign = data.dassign;
                    $('#CS_title').val(res.data.title).keyup();
                    $('#easycase_uid').val(csuid);
                    var easycaseid = res.data.id;
                    $('#prjchange_loader').hide();
                    opencase();
                    $('[rel=tooltip], #main-nav span, .loader').tipsy({
                        gravity: 's',
                        fade: true
                    });
                    $('#loadquick').hide();
                    $("#usedstorage").val($("#storageusedqc").val());
                    $('#easycase_uid').val(csuid);
                    $('#CSeasycaseid').val(easycaseid);
                    $('.popup_overlay').hide();
                    $('.loader_dv_edit').hide();
                    $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Task Group'));
                    if (res.mlst_list) {
                        $('#more_opt8 ul li').remove();
                        $('#selected_milestone').html(_('Default Task Group'));
                        $('#CS_milestone').val('');
                        $('.crtskgrp').html('');
                        if (data.project_methodology == 2) {
                            $('.crtskgrp').append('<option value="0">' + _('Backlog') + '</option>');
                            $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Sprint'));
                        } else {
                            $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
                        }
                        $.each(res.mlst_list, function(key, value) {
                            $('.crtskgrp').append('<option value="' + key + '">' + shortLength(ucfirst(formatText(value)), 25) + '</option>');
                        });
                    } else {
                        $('#more_opt8 ul li').remove();
                        if (res.project_methodology == 2) {
                            $('.crtskgrp').append('<option value="0">' + _('Backlog') + '</option>');
                            $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Sprint'));
                        } else {
                            $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
                        }
                        $('#CS_milestone').val('');
                    }
                    $('.crtskgrp').val(res.data.milestone_id);
                    $('#CS_milestone').val(res.data.milestone_id);
                    if (res.data.milestone_id == '') {
                        $("#crtskgrp_id").val(0);
                    }
                    $('.crtskgrp').trigger('change');
                    case_quick(res.data);
                    if (res.checklists.length) {
                        if ($('#checklist_body_create').length) {
                            $('#checklist_body_create').html('');
                            $.each(res.checklists, function(key_ch, val_ch) {
                                var chk_list_cond = '';
                                if (val_ch.CheckList.is_checked) {
                                    chk_list_cond = 'checked="checked"';
                                }
                                $('#checklist_body_create').prepend('<tr class="timelog-hover-block row_tr"><td class="date_time_td"><div class="checkbox marg_top_btm_none"><label><input type="checkbox" class="check_chklist_crt" data-val="' + val_ch.CheckList.id + '" ' + chk_list_cond + ' /></label></div></td><td class="message_td"><div class="" title=""><input type="text" name="checklist[]" value="' + val_ch.CheckList.title + '" class="check_chklist_crt_ttl" /></div></td><td class="action_td"><a href="javascript:void(0);" onclick="deleteChecklistCrt(this);" ><i title="' + _('Remove') + '" class="material-icons">close</i></a></td>');
                            });
                            $('#CS_checklist').val('');
                        }
                        $.material.init();
                    }
                    addTaskEvents();
                    $('.prj-select').val(res.data.project_uniq_id);
                    $('.prj-select').prop('disabled', true);
                    var selectizeProj = $('.prj-select').select2({
                        dropdownCssClass: 'dropprojt'
                    });
                    $(".link-to-select").select2({
                        width: '100%',
                        allowClear: true,
                        ajax: {
                            url: HTTP_ROOT + 'requests/getNewLinkTasks',
                            type: "post",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    'searchTerm': params.term,
                                    'project_id': res.data.project_uniq_id,
                                    'task_id': res.data.id
                                }
                            },
                            processResults: function(data) {
                                if (data.status) {
                                    return {
                                        results: $.map(data.task, function(obj) {
                                            return {
                                                id: (obj.id),
                                                text: (obj.text)
                                            };
                                        })
                                    };
                                } else {
                                    return "No data found";
                                }
                            },
                            cache: true
                        },
                    });
                }
            });
        }, 'json');
        removeAll();
    }
}

function copytask(csuid, case_id, case_no, prj_id, old_prj_nm) {
    var new_prj_id = prj_id;
    var new_prj_nm = old_prj_nm;
    $("#cpprjloader").show();
    $.post(HTTP_ROOT + "easycases/copy_task_to_project", {
        "project_id": new_prj_id,
        "old_project_id": prj_id,
        "case_id": case_id,
        "case_no": case_no,
        'is_multiple': 0,
        'taskCopy': '1'
    }, function(res) {
        if (res.success) {
            refreshActvt = 1;
            refreshKanbanTask = 1
            refreshTasks = 1;
            refreshManageMilestone = 1;
            refreshMilestone = 1;
            if (getCookie('TASKGROUPBY') != 'milestone') {
                showTopErrSucc('success', _("Task #") + case_no + " " + _("copied"));
            } else {
                showTopErrSucc('success', _("Task copied successfully"));
            }
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'milestonelist') {
                showMilestoneList();
            } else if (hashtag[0] == 'kanban') {
                easycase.showKanbanTaskList('kanban');
            } else if (typeof res.id != 'undefined') {
                tasklisttmplAdd(res.id, res.mid, 'copy', case_id);
            } else {
                easycase.refreshTaskList();
            }
            displayMenuProjects('dashboard', '6', '');
        } else {
            $("#cpprjloader").hide();
            if (getCookie('TASKGROUPBY') != 'milestone') {
                showTopErrSucc('error', _("Unable to copy task #") + case_no + " ");
            } else {
                showTopErrSucc('error', _("Unable to copy the task"));
            }
            return false;
        }
    }, 'json');
}
var miseltone_selected = '';

function case_quick(easycase, obj) {
    $('.crttask_overlay').show();
    if ($(".link-to-select").val() != 'null') {
        $(".link-to-select").val('').trigger("change");
    }
    if (easycase) {
        var hasharr = getHash().split('/');
        if (hasharr[0] != 'details') {
            $('.rht_content_cmn').addClass('rht_content_cmn_crt');
        }
    } else {
        $('.rht_content_cmn').removeClass('rht_content_cmn_crt');
        $('#checklist_body_create').html('');
    }
    $('.tl_hours').attr('readonly', false).val('');
    $('.tl_break_time').val('');
    var i = k = 0,
        chked = "",
        defaultAsgnName = '',
        defaultAsgn = parseInt(defaultAssign);
    var objid = typeof obj != 'undefined' ? obj : 'more_opt5';
    var ext = typeof obj != 'undefined' && objid == 'more_opt5_v2' ? '_v2' : '';
    $(".timelog_block").show();
    $('#is_recurring').removeAttr('checked');
    $('#recurring_task_block').hide();
    $('.timelog_block, .timelog_toggle_block').show();
    $('#viewmemdtls, #more_opt5 ul, #more_opt5_v2 ul').html('');
    $('#viewmemdtls .notify_cls').prop('checked', false);
    $('#opt2' + ext).parent('div').addClass('dropdown wid');
    $('#opt2' + ext).html("<span id=" + "pr_col" + ext + " class=" + "low" + " ></span><a href=" + "javascript:void(0);" + " class=" + "ttfont" + "  onclick=" + "open_more_opt('more_opt9" + ext + "');" + "><span id=" + "selected_priority" + ext + ">&nbsp;&nbsp;" + _('Low') + "</span><i id='car'class=" + "caret mtop-10 fr" + "></i></a>");
    $('#tgrp_main').css({
        'width': '253px'
    });
    $('#tgrp_detail').css({
        'width': '155px'
    });
    $('.assign-to-fld').find('select').html('');
    $('.isRecurring').show();
    $('#repeat_type').html("<span class='ttfont'>&nbsp;&nbsp;" + _('None') + "</span>");
    $("#CSrepeat_type").val('');
    $("#occur, #date").attr('disabled', 'disabled');
    $("#occur, #date").prop('checked', false);
    $('#occurrence, #end_datePicker, #start_datePicker').attr('disabled', 'disabled').val('');
    $('#CS_due_date').val('');
    $('#CS_parent_task').val('');
    $('#userIds').val('');
    $('#userNames').val('');
    $('#pr_col' + ext).addClass('fl');
    $('#car').addClass('fr');
    $('#car').addClass('mtop-10');
    $('#more_opt12').html('');
    $('#more_opt11 > ul').html('');
    $('#chked_all').prop('checked', false);
    $('#notify').children('div .notify-name').remove();
    $('#sel_user').html('');
    $('#clientdiv').show();
    $('#clientdiv').children('.color_tag').remove();
    $('#viewmemdtls .notify_cls').prop('checked', false);
    $('#more_opt11 > ul').append('<li class="userli"><input type="checkbox" name="chkAll" id="chked_all" value="all" onclick="checkedAllRes()" style="margin-left:10px;"/><span style="margin-left:15px;color:black;">' + _('All') + '</span></li>');
    $('#more_opt11 > ul').append('<li style="border-bottom:1px solid #ccc;margin-bottom:5px;margin-top:5px;"></li>');
    $('#due_date').val('');
    $('#due_date').prop('disabled', false);
    $('#start_date').val('');
    $('#priority_low, #priority_mid, #priority_high').prop('disabled', false);
    $("#CS_title").parent('div').removeClass('mv-label-up');
    var userIds = '';
    var userNames = ''
    if (countJS(PUSERS)) {
        var UserClients = '';
        var dassignArr = Array();
        if (dassign) {
            for (ui in dassign) {
                dassignArr.push(dassign[ui]);
            }
        }
        for (ipusr in PUSERS) {
            for (ipusr1 in PUSERS[ipusr]) {
                if (typeof PUSERS[ipusr] != 'function') {
                    var pusr = PUSERS[ipusr][ipusr1];
                    if (typeof pusr != 'function') {
                        chked = '';
                        var chk_client = 0;
                        userIds += ',' + pusr.User.id;
                        userNames += ',' + pusr.User.name;
                        var title = '';
                        if (pusr.User.last_name != '') {
                            title = pusr.User.name + '&nbsp;' + pusr.User.last_name;
                        } else {
                            title = pusr.User.name;
                        }
                        title = ucfirst(title);
                        if (pusr.CompanyUser.is_client == 1) {
                            chk_client = 1;
                            if (UserClients == '') {
                                UserClientsId = pusr.User.id;
                                UserClients = pusr.User.name;
                                UserClientsEmail = pusr.User.email;
                            } else {
                                UserClientsId += ',' + pusr.User.id;
                                UserClients += ', ' + pusr.User.name;
                                UserClientsEmail += ', ' + pusr.User.email;
                            }
                            $('#clientdiv').append("<span class='color_tag' id='make_clientspn' title='" + title + "'>" + ucfirst(pusr.User.name) + "</span>");
                        }
                        if (pusr.User.id == SES_ID && pusr.CompanyUser.is_client == 1) {
                            $('#clientdiv').hide();
                        }
                        $('#userIds').val(userIds);
                        $('#userNames').val(userNames);
                        if ($.inArray(pusr.User.id, dassignArr) != -1) {
                            $('#more_opt12').append("<div class='user_div fl'><span id='user" + pusr.User.id + "' style='padding:5px;color:white;'>" + ucfirst(pusr.User.name) + "</span><span class='close' style='margin-left:5px; font-weight:bold;padding:5px;color:white;cursor:pointer;' onclick='closeuser(" + pusr.User.id + ")'>x</span></div>");
                            chked = "checked='checked'";
                        } else if (pusr.User.id == defaultAsgn) {
                            $('#more_opt12').append("<div class='user_div fl'><span id='user" + pusr.User.id + "' style='padding:5px;color:white;'>" + ucfirst(pusr.User.name) + "</span><span class='close' style='margin-left:5px; font-weight:bold;padding:5px;color:white;cursor:pointer;' onclick='closeuser(" + pusr.User.id + ")'>x</span></div>");
                            chked = "checked='checked'";
                        } else if ((!defaultAsgn && pusr.User.id == SES_ID)) {
                            $('#more_opt12').append("<div class='user_div fl'><span id='user" + pusr.User.id + "' style='padding:5px; color:white;'>" + ucfirst(pusr.User.name) + "</span><span class='close' style='margin-left:5px; padding:5px;font-weight:bold;color:white; cursor:pointer;' onclick='closeuser(" + pusr.User.id + ")'>x</span></div>");
                            chked = "checked='checked'";
                        }
                        if (!pusr.User.name) {
                            var i = pusr.User.email.indexOf("@");
                            if (pusr.User.email.indexOf("@") != -1) {
                                pusr.User.name = pusr.User.email.substring(0, i);
                            }
                        }
                        if (chk_client == 1) {
                            $('#viewmemdtls').append('<span class="viewmemdtls_cls checkbox add-user-pro-chk"><label data-toggle="tooltip" data-placement="top" title="" data-original-title="' + ucfirst(pusr.User.email) + '"><input type="checkbox" name="data[Easycase][user_emails][]" id="chk_' + pusr.User.id + '" class="notify_cls fl chk_client" value="' + pusr.User.id + '" onClick="removeAll()" ' + chked + ' />&nbsp;' + ucfirst(shortLength(pusr.User.name, 15)) + '</label></span>');
                        } else {
                            $('#viewmemdtls').append('<span class="viewmemdtls_cls checkbox add-user-pro-chk"><label data-toggle="tooltip" data-placement="top" title="" data-original-title="' + ucfirst(pusr.User.email) + '"><input type="checkbox" name="data[Easycase][user_emails][]" id="chk_' + pusr.User.id + '" class="notify_cls fl" value="' + pusr.User.id + '" onClick="removeAll()" ' + chked + ' />&nbsp;' + ucfirst(shortLength(pusr.User.name, 15)) + '</label></span>');
                        }
                        $('.notify_user').addClass('fl');
                        $('.notify_cls').addClass('fl');
                        $('.chk_client').addClass('fl');
                        i = i + 1;
                        k = i % 4;
                        if (k == 0) {
                            $('#viewmemdtls').append('<div class="cb"></div>');
                        }
                        if (SES_ID == pusr.User.id) {
                            $('.crtskasgnusr').append("<option value='" + pusr.User.id + "'>" + _('me') + "</option>");
                        } else {
                            $('.crtskasgnusr').append("<option value='" + pusr.User.id + "'>" + ucfirst(pusr.User.name) + "</option>");
                        }
                        if (easycase && easycase.assign_to && easycase.assign_to == pusr.User.id && easycase.assign_to != SES_ID) {
                            defaultAsgnName = pusr.User.name;
                            defaultAsgn = easycase.assign_to;
                        } else if (easycase && easycase.assign_to && easycase.assign_to == pusr.User.id && easycase.assign_to == SES_ID) {
                            defaultAsgnName = pusr.User.name;
                            defaultAsgn = easycase.assign_to;
                        } else if (!defaultAsgnName && defaultAsgn && defaultAsgn == pusr.User.id) {
                            defaultAsgnName = pusr.User.name;
                            defaultAsgn = defaultAsgn;
                        }
                        if (easycase && easycase.assign_to == 0) {
                            defaultAsgnName = _('Nobody');
                            defaultAsgn = 0;
                        }
                    }
                }
            }
            if (typeof(easycase) != 'undefined') {
                if (easycase.client_status == 1) {
                    $('#make_client').prop('checked', true);
                    $('#make_client_dtl').prop('checked', false);
                    $('.chk_client').prop('disabled', true);
                    $('.chk_client').prop('checked', false);
                } else {
                    $('#make_client').prop('checked', false);
                }
            } else {
                $('#make_client').prop('checked', false);
            }
            if (UserClients != '') {
                if (UserClients.length >= 30) {
                    $('#client').val(UserClientsId);
                } else {
                    $('#client').val(UserClientsId);
                }
            } else {
                $('#clientdiv').hide();
            }
        }
        $('.crtskasgnusr').append("<option value='0'>" + _('Nobody') + "</option>");
        $('.holder').children('li').remove();
        $('.holder').remove();
        var prjuid = $('#curr_active_project').val();
    } else {
        $('.crtskasgnusr').append("<option value='" + SES_ID + "'>" + _('me') + "</option>");
    }
    if (defaultAsgn && defaultAsgnName && defaultAsgn != SES_ID) {
        $('.crtskasgnusr').find('option[value="' + defaultAsgn + '"]').attr('selected');
        $('.assign-to-fld select').val(defaultAsgn);
        $('.assign-to-fld').find('.dropdownjs').find('input.fakeinput').val(defaultAsgnName);
        $('#CS_assign_to' + ext).val(defaultAsgn);
    } else if (defaultAsgn == 0) {
        $('#CS_assign_to' + ext).val('0');
        $(".timelog_block").hide();
        $('.crtskasgnusr').find('option[value="0"]').attr('selected');
        $('.assign-to-fld select').val(0);
        $('.assign-to-fld').find('.dropdownjs').find('input.fakeinput').val(_('Nobody'));
    } else {
        $('.crtskasgnusr').find('option[value="' + SES_ID + '"]').attr('selected');
        $('.assign-to-fld select').val(SES_ID);
        $('.assign-to-fld').find('.dropdownjs').find('input.fakeinput').val(_('me'));
    }
    if (SES_TYPE == 3 && defaultAsgn != SES_ID) {
        $('.timelog_block').hide();
    }
    $('.tsktyp-select').html('');
    $.each(GLOBALS_TYPE, function(key, value) {
        if (value.Type.project_id == 0 || value.Type.project_id == PROJECTS_ID_MAP[$('.prj-select').val()]) {
            $('.tsktyp-select').append('<option value="' + value.Type.id + '">' + value.Type.name + '</option>');
        }
    });
    $('.tsktyp-select').change();
    if ((parseInt($("#is_default_task_type").val())) && ($('#hiddentasktype').val !== 'creatask')) {
        $('#CS_type_id').val(2);
        $.each(GLOBALS_TYPE, function(key, value) {
            var i = 0;
            if (value.Type.name == 'Development') {
                $('.tsktyp-select').val($('.tsktyp-select').find('option[value="2"]').html());
                $('.task_type select').val(2);
                $('.tsktyp-select').trigger('change');
            }
        });
    }
    $('.crtskasgnusr').trigger('change');
    $('#priority_low').prop('checked', true);
    $('#priority_mid, #priority_high').prop('checked', false);
    $('#CS_priority').val(2);
    if (parseInt(gDueDate)) {
        $('#CS_due_date').val('');
        $('#date_dd').html(_('No Due Date'));
    } else {
        gDueDate = 1;
    }
    $('#CS_message').val('');
    $('#estimated_hours, #hours').val('');
    $('#editEasycaseId, #editRecurId, #editRecurProjId').val('');
    $(".displayEditRecurring").hide();
    removeAll();
    $('#story_points').val(0);
    if (easycase) {
        if (easycase.is_recurring == 1) {
            $('#is_recurring').prop('checked', true);
            $(".displayEditRecurring").show();
        } else {
            $(".displayEditRecurring").hide();
        }
        $('#recurring_task_block').hide();
        $('#tgrp_main').css({
            'width': '339px'
        });
        $('#tgrp_detail').css({
            'width': '250px'
        });
        if (easycase.type_id) {
            $('#CS_type_id').val(easycase.type_id);
            for (typi in GLOBALS_TYPE) {
                if (easycase.type_id == GLOBALS_TYPE[typi].Type.id) {
                    if (GLOBALS_TYPE[typi].Type.seq_order == 0) {
                        $('.task_type select').val(easycase.type_id);
                        $('.tsktyp-select').trigger('change');
                        break;
                    }
                    $('.task_type select').val(easycase.type_id);
                    $('.tsktyp-select').trigger('change');
                    break;
                }
            }
        }
        if (easycase.priority && easycase.type_id !== 10) {
            $('#opt2' + ext).parent('div').addClass('dropdown');
            $('#opt2' + ext).parent('div').addClass('wid');
            $('#pr_col' + ext).removeClass('low high medium');
            $('#CS_priority').val(easycase.priority);
            if ((parseInt(easycase.priority)) == 2) {
                $('#pr_col' + ext).addClass('low');
                $('#priority_low').prop('checked', true);
                $('#selected_priority' + ext).text(_('Low'));
            } else if ((parseInt(easycase.priority)) == 0) {
                $('#pr_col' + ext).addClass('high');
                $('#priority_high').prop('checked', true);
                $('#selected_priority' + ext).text(_('High'));
            } else {
                $('#pr_col' + ext).addClass('medium');
                $('#priority_mid').prop('checked', true);
                $('#selected_priority' + ext).text(_('Medium'));
            }
        } else {
            if (easycase.type_id == 10) {
                $("#CS_priority").val(0);
                $('#priority_mid, #priority_low').prop('checked', false);
                $('#priority_mid, #priority_low').prop('disabled', true);
                $('#priority_high').prop('checked', true);
                $('#opt2' + ext).parent('div').removeClass('dropdown wid');
                $('#opt2' + ext).html('<span id="pr_col' + ext + '" class="high fl" ></span><a href="javascript:void(0);"><span id="selected_priority' + ext + '">&nbsp;&nbsp;' + _('High') + '</span></a>');
            } else {
                $("#CS_priority").val(0);
                $('#opt2' + ext).parent('div').addClass('dropdown wid');
                $('#opt2' + ext).html("<span id=" + "pr_col" + ext + " class=" + "high" + " ></span><a href=" + "javascript:void(0);" + " onclick=" + "open_more_opt('more_opt9" + ext + "')" + "><span id=" + "selected_priority" + ext + ">&nbsp;&nbsp;" + _('High') + "</span><i id=" + "car" + " class=" + "caret" + "></i></a>");
                $('#pr_col' + ext).addClass('fl');
                $('#car').addClass('fr');
                $('#car').addClass('mtop-10');
            }
        }
        localStorage.setItem("change_reason_duedt", '');
        if (easycase.due_date && easycase.formatted_due_date) {
            if (easycase.due_date != '01/01/1970') {
                localStorage.setItem("change_reason_duedt", easycase.due_date);
                $('#CS_due_date').val(easycase.due_date);
                $('#due_date').val(moment(easycase.due_date).format('MMM DD, YYYY'));
                $('#date_dd').val(easycase.formatted_due_date);
            } else {
                $('#CS_due_date').val('');
                $('#date_dd').val('');
            }
            if (easycase.allow_edit == "No") {
                $('#due_date').prop('disabled', true);
            }
        }
        if (easycase.gantt_start_date) {
            if (easycase.gantt_start_date != '01/01/1970') {
                $('#CS_start_date').val(moment(easycase.start_date).format('MM/DD/YYYY'));
                $('#start_date').val(moment(easycase.start_date).format('MMM DD, YYYY'));
            } else {
                $('#CS_start_date').val('');
                $('#start_date').val('');
            }
        }
        if (easycase.message) {
            $('#CS_message').val(easycase.message);
        }
        if (easycase.parent_task_id) {
            $('#CS_parent_task').val(easycase.parent_task_id);
        }
        if (easycase.estimated_hours) {
            $('#estimated_hours').val(easycase.estimated_hours);
        }
        if (easycase.hours) {}
        openEditor(easycase.message, is_basic_or_free);
    }
    if (PAGE_NAME == "resource_availability") {
        var dateText = $('#leave_date').val();
        if (dateText == '' || dateText == undefined) {
            var dateText = $('#leave_date_resourse').val();
        }
        if (dateText) {
            if (dateText != '1970-01-01') {
                $('#CS_start_date').val(moment(dateText, ['YYYY-MM-DD']).format('MM/DD/YYYY'));
                $('#start_date').val(moment(dateText, ['YYYY-MM-DD']).format('MMM DD, YYYY'));
            } else {
                $('#CS_start_date').val('');
                $('#start_date').val('');
            }
        }
        $('#estimated_hours').val(COMPANY_WORK_HOUR);
    }
    var upcontent = $.trim($('#up_files').html());
    $('#up_files').html('');
    $.material.init();
    $('#up_files').html(upcontent);
    if (SES_TYPE == 3) {
        $(".tsktyp-select").select2({
            templateSelection: formatTaskType,
            templateResult: formatTaskType
        });
    } else {
        $(".tsktyp-select").select2({
            tags: true,
            templateSelection: formatTaskType,
            templateResult: formatTaskType,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
                    var msg = "'Name' must not contain Special characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).off('select2:select').on('select2:select', function(evt) {
            if (evt.params.data.newTag == true) {
                var name = evt.params.data.id;
                $('#caseLoader').show();
                $.post(HTTP_ROOT + 'projects/validateTaskTypeFromCreateTask', {
                    'name': evt.params.data.id,
                    'project_uid': $('.prj-select').val().trim()
                }, function(res) {
                    $('#caseLoader').hide();
                    if (res.status == 'error' && res.msg == 'name') {
                        showTopErrSucc('error', 'Name already esists!. Please enter another name.');
                        $('.tsktyp-select option[value="' + name + '"]').remove();
                        $('.tsktyp-select').trigger('change');
                    } else if (res.status == 'success') {
                        if (res.msg == 'saved') {
                            showTopErrSucc('success', 'Task Type Successfully Added');
                            $(".tsktyp-select").append("<option value='" + res.id + "' selected>" + name + "</option>");
                            $('.tsktyp-select option[value="' + res.id + '"]').prop('selected', true);
                            $('.tsktyp-select').trigger('change');
                        } else {
                            showTopErrSucc('error', _('Task Type can not be added'));
                            $('.tsktyp-select').trigger('change');
                        }
                    }
                }, 'json');
            }
        });
    }
    if (easycase) {
        if (typeof easycase.story_point != 'undefined' && easycase.story_point) {
            $('#story_points').val(easycase.story_point);
        }
        if (typeof easycase.priority != 'undefined' && easycase.priority) {
            if (easycase.priority == 2) {
                $('#priority_low1').prop('checked', true);
            }
            if (easycase.priority == 0) {
                $('#priority_high1').prop('checked', true);
            }
            if (easycase.priority == 1) {
                $('#priority_mid1').prop('checked', true);
            }
        }
        if (easycase.type_id) {
            $('#CS_type_id').val(easycase.type_id);
            for (typi in GLOBALS_TYPE) {
                if (easycase.type_id == GLOBALS_TYPE[typi].Type.id) {
                    if (GLOBALS_TYPE[typi].Type.seq_order == 0) {
                        $('.task_type select').val(easycase.type_id);
                        $('.tsktyp-select').trigger('change');
                        break;
                    }
                    $('.task_type select').val(easycase.type_id);
                    $('.tsktyp-select').trigger('change');
                    break;
                }
            }
        }
    } else {
        if (parseInt(defaultTskTyp) != 0) {
            $('.tsktyp-select').val(defaultTskTyp);
            $('.tsktyp-select').trigger('change');
            if ($('.tsktyp-select').val() == null) {
                $('.tsktyp-select').val($('.tsktyp-select').find('option:eq(0)').val());
                $('.tsktyp-select').trigger('change');
            }
        } else {
            $('.tsktyp-select').val($('.tsktyp-select').find('option:eq(0)').val());
            $('.tsktyp-select').trigger('change');
        }
    }
    $(".crtskgrp").select2({
        tags: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            var is_change = $('#projIsChange').val().trim();
            if (is_change == 'all') {
                showTopErrSucc('error', _('Please select the project you want to add the task group.'));
                return false;
            }
            if (term.toLowerCase() == 'default task group') {
                showTopErrSucc('error', _('Title') + ' "' + term + '" ' + _('already exists!'));
                return false;
            }
            return {
                id: term,
                text: term,
                newTag: true
            }
        }
    }).off('select2:select').on('select2:select', function(evt) {
        if (evt.params.data.newTag == true) {
            var titl = evt.params.data.id;
            var proj_id = $('.prj-select').val().trim();
            $('#caseLoader').show();
            $.post(HTTP_ROOT + "milestones/ajax_new_milestone", {
                'title': titl,
                'project_id': proj_id,
                'type': 'inline'
            }, function(res) {
                $('#caseLoader').hide();
                if (typeof res.success != 'undefined' && res.success == 1) {
                    showTopErrSucc('success', res.msg);
                    $(".crtskgrp").append("<option value='" + res.milestone_id + "' selected>" + titl + "</option>");
                    $('.crtskgrp option[value="' + res.milestone_id + '"]').prop('selected', true);
                    $('.crtskgrp').trigger('change');
                } else {
                    showTopErrSucc('error', res.msg);
                    $('.crtskgrp').trigger('change');
                }
            }, 'json');
        }
    }).on('change', function(evt) {
        var selctd_mil = $("#crtskgrp_id").val();
        if (miseltone_selected != selctd_mil) {
            $("#CS_parent_task").val('');
        }
    });
    $(".relates-select").select2();
    if (SES_TYPE == 3) {
        $(".label-to-select").select2({
            tags: true,
            createTag: function(params) {
                return undefined;
            }
        });
    } else {
        $(".label-to-select").select2({
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                if (term.match(/[/:-?{~"^`'\[\]<>]+/)) {
                    var msg = "'Label' must not contain Special characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                if (term.length > 30) {
                    var msg = "Label must not exceed 20 characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).off('select2:select').on('select2:select', function(evt) {
            if (evt.params.data.newTag == true) {
                var name = evt.params.data.id;
                $('#caseLoader').show();
                $.post(HTTP_ROOT + 'projects/validateTaskLabelFromCreateTask', {
                    'name': evt.params.data.id,
                    'project_uid': $(".prj-select ").val()
                }, function(res) {
                    $('#caseLoader').hide();
                    if (res.status == 'error' && res.msg == 'name') {
                        showTopErrSucc('error', _('Label already exists!. Please enter another label.'));
                        $('.label-to-select option[value="' + evt.params.data.id + '"]').remove();
                        $('.label-to-select').trigger('change');
                    } else if (res.status == 'success') {
                        if (res.msg == 'saved') {
                            $(".label-to-select").find('option[value="' + name + '"]').remove();
                            $(".label-to-select").append("<option value='" + res.id + "' selected>" + name + "</option>");
                            $('.label-to-select option[value="' + res.id + '"]').prop('selected', true);
                            $('.label-to-select').trigger('change');
                        } else {
                            showTopErrSucc('error', _('Task Label can not be added'));
                            $('.label-to-select option[value="' + evt.params.data.id + '"]').remove();
                            $('.label-to-select').trigger('change');
                        }
                    }
                }, 'json');
            }
        });
    }
    $(".crtskntfyusr").dropdown({
        "optionClass": "withripple",
        "autoinit": '.crtskntfyusr',
        "callback": false,
        "onSelected": function(selected) {
            if (selected == 'all') {
                var text = [];
                $('.notify_email').find('ul > li').each(function(i) {
                    if ($(this).text() != 'All' && $(this).text() != '') {
                        $(this).addClass('selected');
                        text.push($(this).text());
                    }
                });
                if ($.inArray('All', text) > -1) {
                    text.splice($.inArray('All', text), 1);
                }
                $('.notify_email').find('input.fakeinput').val(text.join(", "));
            }
        },
    });
    $('.crtskasgnusr').select2();
    if (easycase && easycase.parent_task_id) {
        $('#CS_parent_task').val(easycase.parent_task_id);
    }
    $('#CS_checklist').off().on('keyup', function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode == 13) {
            addChecklistCreate();
        }
    });
    addTaskEvents(objid);
    LogTime.initiateLogTime();
    $(".cmn_create_task_form .flex_scroll").on('scroll', function() {
        $('#start_time').timepicker('hide');
        $('#end_time').timepicker('hide');
        $("#start_date").datepicker('hide');
        $("#due_date").datepicker('hide');
    });
}

function matchCustom(params, data) {
    if ($.trim(params.term) === '') {
        return data;
    }
    if (typeof data.text === 'undefined') {
        return null;
    }
    if (data.text.indexOf(params.term) > -1) {
        var modifiedData = $.extend({}, data, true);
        return modifiedData;
    } else {
        $.post(HTTP_ROOT + 'requests/getMoreParent', {
            'csuniqid': '',
            'proj_id': $('.prj-select').val(),
            'search_txt': params.term
        }, function(res) {
            if (res.parent_tasks) {
                var check_val = '';
                $.each(res.parent_tasks, function(key, val) {
                    if (!$('#CS_parent_task option[value="' + key + '"]').length) {
                        $('#CS_parent_task').append("<option value='" + key + "'>" + val + "</option>");
                        if (val.indexOf(params.term) > -1) {
                            check_val = key;
                        }
                    }
                });
                if (check_val != '') {
                    $("#CS_parent_task").val(check_val);
                    $('#CS_parent_task').trigger('change');
                }
                $("#CS_parent_task").blur();
            }
        }, 'json');
    }
    return null;
}

function setTaskGroupAsperParent(ptask_id, proj_id, task_id) {
    $.post(HTTP_ROOT + "milestones/get_task_milestone", {
        'task_id': ptask_id + '__' + task_id,
        'project_id': proj_id,
        'type': 'inline'
    }, function(res) {
        $('#caseLoader').hide();
        if (res.status == 'success') {
            miseltone_selected = res.milestone_id;
            $("#crtskgrp_id").val(res.milestone_id);
            $('.crtskgrp').trigger('change');
            if (res.message != '') {
                $('#CS_parent_task').val(0);
                $("#CS_parent_task").trigger('change');
                showTopErrSucc('error', res.message);
            }
        } else {
            $('.crtskgrp').trigger('change');
        }
    }, 'json');
}

function disable_timelog() {
    $(".timelog_toggle_block").find('select').val("");
    $(".timelog_toggle_block").find('input').val("");
    $("#hours").val("");
    $(".timelog_block").hide();
}

function crt_popup_close() {
    if ($('.hopscotch-close').length) {
        $('.hopscotch-close').trigger('click');
    }
    var on_cal = '';
    if (arguments[0]) {
        $('.crttask_overlay').hide();
        $('.slide_rht_con').show();
        $('.rht_content_cmn').removeClass('rht_content_cmn_crt');
        on_cal = arguments[0];
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
    }
    $('.project-dropdown').show();
    $('.project-dropdown').prev('li').show();
    var params = parseUrlHash(urlHash);
    if (params[0] == 'calendar') {
        easycase.refreshTaskList();
        return false;
    }
    if (PAGE_NAME == 'resource_availability') {
        window.location.href = HTTP_ROOT + 'resource-availability/'
        return false;
    }
    if ($('#hiddensavennew').val() == '1') {
        if (CONTROLLER == 'easycases') {
            if (params[0] != 'kanban' && params[0] != 'milestonelist' && params[0] != '') {
                easycase.refreshTaskList();
            } else if (PAGE_NAME == 'mydashboard') {
                window.location.href = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
                return false;
            }
        }
    }
    $("#footersection").show();
    $('.slide_rht_con').show();
    $('.breadcrumb_fixed').show();
    $('.breadcrumb_div').show();
    $('.page_ttle_toptxt').show();
    $('#milestone_content').show();
    $('.invoice_filter_det').show();
    $('#invoice_filtered_items').show();
    $('#kanban_list').show();
    $(".crt_tsk").animate({
        left: "inherit"
    }, "fast", function() {
        var caseMenuFilters = $('#caseMenuFilters').val();
        if (CONTROLLER == 'easycases' && PAGE_NAME == 'invoice') {
            $('#select_view').show();
            $('.invoiceFilter').children('.task_section ').show();
            $('.InvoiceDownloadEmail').show();
        }
        if (CONTROLLER == 'reports' && PAGE_NAME == 'resource_utilization') {
            $(".breadcrumb_div,.case-filter-menu").css({
                display: "block"
            });
        }
        if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard' && caseMenuFilters == "") {
            if (params[0] != "details") {
                $(".breadcrumb_div,.case-filter-menu").css({
                    display: "inline"
                });
            }
            $("#widgethideshow").show();
            if ($('#caseViewSpan').html() == "" && params[1]) {
                easycase.routerHideShow(params[0]);
                easycase.refreshTaskList(params[1]);
                $('#caseMenuFilters').val('kanban_only');
                $('#t_' + params[1]).show();
            } else {
                if ($('#easycase_uid').val() && params[0] == 'details') {
                    var new_url = localStorage.getItem("last_url");
                    if (typeof new_url != 'undefiend' && new_url != '') {
                        history.pushState({}, null, new_url);
                        localStorage.setItem("last_url", '');
                        var splt_url = new_url.split('#/');
                        easycase.routerHideShow(splt_url[1]);
                    } else {
                    easycase.refreshTaskList($('#easycase_uid').val());
                    }
                } else if (params[0] == "overview") {
                    ajaxProjectOveriew();
                } else if (params[0] == 'taskgroup') {
                    easycase.refreshTaskList();
                } else if (params[0] == 'taskgroups') {
                    easycase.refreshTaskList();
                } else if (params[0] == 'kanban') {
                    easycase.showKanbanTaskList();
                } else if (params[0] == 'milestonelist') {
                    showMilestoneList();
                } else if (params[0] == 'subtask') {
                    easycase.refreshTaskList();
                } else if (params[0] == 'backlog') {
                    easycase.showbacklog();
                } else if (params[0] == 'activesprint') {
                    easycase.showsprint();
                } else if (params[0] != "tasks") {
                    parent.location.hash = "tasks";
                } else if (params[0] == 'tasks') {
                    if (on_cal != 'CT') {
                        easycase.refreshTaskList();
                    }
                }
                if (typeof new_url != 'undefined' && new_url != '') {} else {
                easycase.routerHideShow(params[0]);
            }
            }
        } else {
            if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                if (params[0] === "milestonelist") {
                    if (parseInt($("#totalMlstCnt").val()) > 3) {
                        $(".milestonenextprev").hide();
                    }
                    if (on_cal == 'only_cal') {
                        showMilestoneList();
                    } else {
                        showMilestoneList();
                    }
                } else if (params[0] == "kanban") {
                    easycase.showKanbanTaskList();
                } else if (params[0] == 'activesprint') {
                    easycase.showsprint();
                } else if (params[0] === "details") {
                    $('#caseLoader').show();
                    var new_url = localStorage.getItem("last_url");
                    history.pushState({}, null, new_url);
                    localStorage.setItem("last_url", '');
                    easycase.refreshTaskList(params[1]);
                } else if (params[0] == 'taskgroup') {
                    easycase.refreshTaskList();
                } else if (params[0] == 'taskgroups') {
                    easycase.refreshTaskList();
                } else if (params[0] === "kanban" && on_cal == 'only_cal') {
                    var cnt_tx = parseInt($('#cnter_newTask').text());
                    easycase.showKanbanTaskList('newTask', '', 'create');
                    $('#cnter_newTask').text(eval(cnt_tx + 1));
                }
                easycase.routerHideShow(params[0]);
            } else {
                if (PAGE_NAME == 'listall') {
                    if ($('#archive_filtered_items').find('.filter_opn').size() > 0) {
                        $('.archive_filter_det').css('display', 'table');
                    }
                    window.location.reload();
                    return;
                }
                if (PAGE_NAME == 'getting_started') {
                    window.location.reload();
                    return;
                }
                if (PAGE_NAME == 'mydashboard') {
                    window.location.reload();
                    return;
                }
                if (CONTROLLER == 'reports') {
                    $('.analytics-bar').show();
                }
                $('.task-list-bar').show();
                $('.breadcrumb_div').show();
                $(".crt_tsk").hide();
                $(".slide_rht_con").animate({
                    marginLeft: "0px"
                }, "fast");
                $(".crt_slide").hide();
                window.location = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
            }
            if (params[0] == "details") {
                $('#caseLoader').show();
                $('#t_' + params[1]).show();
            }
        }
    });
}

function closeuser(id) {
    $('#user' + id + '').parent('div').remove();
    $('#chk_' + id).removeAttr("checked");
    removeAll();
}

function addUser(id, name) {
    if ($('#chk_' + id).is(':checked')) {
        $('#more_opt12').append("<div class='user_div fl'><span id='user" + id + "' style='padding:5px;color:white;'>" + ucfirst(name) + "</span><span class='close' style='margin-left:5px; font-weight:bold;padding:5px;color:white;cursor:pointer;' onclick='closeuser(" + id + ")'>x</span></div>");
    } else {
        closeuser(id);
    }
    removeAll();
}

function view_btn_case(id) {
    if (id != 0) {
        $('#btn_cse').show();
    } else {
        $('#btn_cse').hide();
    }
}

function noSpace(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode == 32) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function addUserToProject() {
    var prj_id = getCookie('LAST_PROJ_UID');
    if (prj_id) {
        createCookie("LAST_PROJ_UID", '', -365, DOMAIN_COOKIE);
        var prj_name = $("a.icon-add-usr[data-prj-uid='" + prj_id + "']").attr('data-prj-name');
        if (prj_name == '' || typeof prj_name == 'undefined') {
            prj_name = $("a.icon-grid-add-usr[data-prj-uid='" + prj_id + "']").attr('data-prj-name');
        }
        addUsersToProject(prj_id, prj_name);
    }
}

function projectAdd(txtProj, shortname, txtstart, txtend, txtesthr, loader, btn) {
    $('#txt_Proj').keyup();
    $('#err_msg').html('');
    $("#btn-add-new-project").removeClass('loginactive');
    $('#validate').val('1');
    var clickeventRefer = sessionStorage.getItem('SessionStorageReferValue');
    $("#project_click_refer").val(clickeventRefer);
    var proj1 = "";
    proj1 = $('#' + txtProj).val();
    shortname1 = $('#' + shortname).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Project Name' cannot be left blank!");
        $('#err_msg').show().html(msg);
        $('#' + txtProj).focus();
        $("#btn-add-new-project").addClass('loginactive');
        return false;
    } else if (proj1.match(/[~`<>,;\+\\]+/)) {
        msg = _("'Project Name' only accept Alphabets, Numbers, Special Characters except(~, `, <, >, \\, +, ;, ,)!");
        $('#err_msg').show().html(msg);
        $('#' + txtProj).focus();
        $("#btn-add-new-project").addClass('loginactive');
        return false;
    }
    if ($("#sel-prio").val().trim() == "") {
        msg = _("'Priority' cannot be left blank!");
        $('#err_msg').show().html(msg);
        $('#sel-prio').focus();
        $("#btn-add-new-project").addClass('loginactive');
        return false;
    }
    if (shortname1.trim() == "") {
        msg = _("'Project Short Name' cannot be left blank!");
        $('#err_msg').show().html(msg);
        $('#' + shortname).focus();
        $("#btn-add-new-project").addClass('loginactive');
        return false;
    } else {
        var x = shortname1.substr(-1);
        var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
        var t_test = inValid.test(shortname1.trim());
        if (t_test) {
            msg = _("Special characters are not allowed for 'Project Short Name'!");
            $('#err_msg').show().html(msg);
            $('#' + shortname).focus();
            $("#btn-add-new-project").addClass('loginactive');
            return false;
        }
        var start = $('#' + txtstart).val();
        var end = $('#' + txtend).val();
        start = new Date(start);
        end = new Date(end);
        if (end.getTime() < start.getTime()) {
            msg = _("You can not enter end date less than start date !");
            $('#err_msg').show().html(msg);
            $('#txt_ProjEndDate').focus();
            $("#btn-add-new-project").addClass('loginactive');
            return false;
        }
        var email_id = $('#members_list').val();
        var done = 1;
        if (email_id) {
            var email_arr = email_id.split(',');
            var totlalemails = 0;
            var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!email_id.match(emlRegExpRFC) || email_id.search(/\.\./) != -1) {
                if (email_id.indexOf(',') != -1) {
                    for (var i = 0; i < email_arr.length; i++) {
                        if (email_arr[i].trim() != "") {
                            if ((!email_arr[i].trim().match(emlRegExpRFC) || email_arr[i].trim().search(/\.\./) != -1)) {
                                done = 0;
                                msg = "Invalid Email: '" + email_arr[i] + "'";
                                $('#err_mem_email').show().html(msg);
                                $('#members_list').focus();
                                $("#btn-add-new-project").addClass('loginactive');
                                return false;
                            }
                        } else {
                            totlalemails++;
                        }
                    }
                    if (totlalemails == email_arr.length) {
                        msg = _("Entered string is not a valid email");
                        $('#err_mem_email').show().html(msg);
                        $('#members_list').focus();
                        $("#btn-add-new-project").addClass('loginactive');
                        return false;
                    }
                } else {
                    msg = _("Invalid E-Mail!");
                    $('#err_mem_email').show().html(msg);
                    $('#members_list').focus();
                    $("#btn-add-new-project").addClass('loginactive');
                    return false;
                }
            }
        } else {
            $('#err_mem_email').html();
        }
        $('#err_msg').hide();
        $('#' + loader).show();
        $('#' + btn).hide();
        var start = $('#' + txtstart).val();
        var end = $('#' + txtend).val();
        start = new Date(start);
        end = new Date(end);
        if (end.getTime() < start.getTime()) {
            msg = _("You can not enter end date less than start date !");
            $('#err_enddate').html(msg);
            $('#txt_ProjEndDate').focus();
            $("#btn-add-new-project").addClass('loginactive');
            return false;
        }
        if ($("#btn-add-new-project").hasClass('loginactive')) {
            return false;
        }
        if ($.trim($('.proj_client').val()) == '') {
            var c_name = $.trim($('#proj_cust_fname').val());
            var c_email = $.trim($('#proj_cust_email').val());
            var c_curncy = $.trim($('#proj_currency').val());
            errMsg = '';
            err = false;
            if (c_name != '' || c_email != '') {
                var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (c_name == '') {
                    $('#proj_cust_fname').focus();
                    errMsg = _('Please enter customer name.');
                    err = true;
                } else if (c_email == '') {
                    $('#proj_cust_email').focus();
                    errMsg = _('Please enter email address.');
                    err = true;
                } else if (!c_email.match(emlRegExpRFC) || c_email.search(/\.\./) != -1) {
                    $('#proj_cust_email').focus();
                    errMsg = _('Please enter proper email address.');
                    err = true;
                } else if (c_curncy == '') {
                    $('#proj_currency').focus();
                    errMsg = _('Please select currency.');
                    err = true;
                }
                if (err == true) {
                    showTopErrSucc('error', errMsg);
                    $('#' + loader).hide();
                    $('#' + btn).show();
                    return false;
                }
            }
        }
        $("#btn-add-new-project").hide();
        $.post(strURL + "projects/ajax_check_project_exists", {
            "name": escape(proj1),
            "shortname": escape(shortname1)
        }, function(data) {
            if (data.status == "Project") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Project Name' is already exists!");
                $('#err_msg').show().html(msg);
                $('#' + txtProj).focus();
                $("#btn-add-new-project").addClass('loginactive');
                $("#btn-add-new-project").show();
                return false;
            } else if (data.status == "ShortName") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = "'" + _("Project Short Name -") + " " + shortname1 + "' " + _("already exists!");
                $('#err_msg').show().html(msg);
                $('#' + shortname).focus();
                $("#btn-add-new-project").addClass('loginactive');
                $("#btn-add-new-project").show();
                return false;
            } else {
                if (email_id) {
                    $.post(strURL + 'users/check_fordisabled_user', {
                        'email': email_id
                    }, function(res) {
                        if (res.status != '1') {
                            $('#' + loader).hide();
                            $('#' + btn).show();
                            if (res.users.indexOf(',') != -1) {
                                var msg = "'" + res.users + "' " + _("Users are disabled users.They are not allowed to add into a project.");
                            } else {
                                msg = "'" + res.users + "' " + _("is a disabled user, So cann't be added to a project");
                            }
                            $('#err_mem_email').show().html(msg);
                            $('#members_list').focus();
                            $("#btn-add-new-project").show();
                            return false;
                        } else {
                            $('#err_mem_email').html('').hide();
                            document.projectadd.submit();
                            return true;
                        }
                    }, 'json');
                } else {
                    document.projectadd.submit();
                    return true;
                }
            }
        }, 'json');
        return false;
    }
    return false;
}

function projectOnboardAdd(txtProj, shortname, loader, btn) {
    $('#txt_Proj_onboard').keyup();
    $('#err_msg_onboard').html('');
    $('#validate_onboard').val('1');
    var proj1 = "";
    proj1 = $('#' + txtProj).val();
    shortname1 = $('#' + shortname).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Project Name' cannot be left blank!");
        $('#err_msg_onboard').show();
        $('#err_msg_onboard').html(msg);
        document.getElementById(txtProj).focus();
        return false;
    } else {
        if (proj1.match(/[~`<>,;\+\\]+/)) {
            msg = _("'Project Name' only accept Alphabets, Numbers, Special Characters except(~, `, <, >, \\, +, ;, ,)!");
            $('#err_msg_onboard').show();
            $('#err_msg_onboard').html(msg);
            $('#' + txtProj).focus();
            return false;
        }
    }
    if (shortname1.trim() == "") {
        msg = _("'Project Short Name' cannot be left blank!");
        $('#err_msg_onboard').show();
        $('#err_msg_onboard').html(msg);
        document.getElementById(shortname).focus();
        return false;
    } else {
        var x = shortname1.substr(-1);
        var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
        var t_test = inValid.test(shortname1.trim());
        if (t_test) {
            msg = _("Special characters are not allowed for 'Project Short Name'!");
            $('#err_msg').show();
            $('#err_msg').html(msg);
            document.getElementById(shortname).focus();
            return false;
        }
        var done = 1;
        $('#err_msg_onboard').hide();
        document.getElementById(loader).style.display = 'block';
        $('#' + btn).hide();
        $.post(strURL + "projects/ajax_check_project_exists", {
            "name": escape(proj1),
            "shortname": escape(shortname1)
        }, function(data) {
            if (data.status == "Project") {
                $('#' + loader).hide();
                document.getElementById(btn).style.display = 'block';
                msg = _("'Project Name' is already exists!");
                $('#err_msg_onboard').show();
                $('#err_msg_onboard').html(msg);
                document.getElementById(shortname).focus();
                return false;
            } else if (data.status == "ShortName") {
                $('#' + loader).hide();
                document.getElementById(btn).style.display = 'block';
                msg = "'" + _("Project Short Name -") + " " + shortname1 + "' " + _("already exists!");
                $('#err_msg_onboard').show();
                $('#err_msg_onboard').html(msg);
                document.getElementById(shortname).focus();
                return false;
            } else {
                $('#projectadd_onboard').submit();
                return true;
            }
        }, 'json');
        return false;
    }
    return false;
}

function newUser() {
    if ($("#add_newconopamy_users").length) {
        $("#add_newconopamy_users").html('');
    }
    var company_trial_expire = $('#company_trial_expire').val();
    if (company_trial_expire == 1) {
        showTopErrSucc('error', _('Sorry! you can not add user(s).') + "<br />" + _('Please upgrade your account to add more user(s).'));
        return false;
    }
    if ($('#add_newconopamy_users').length) {
        var ext_user_pop = $('#add_newconopamy_users').html().trim();
        if (ext_user_pop != '') {
            $('#add_newconopamy_users').html('');
        }
    }
    var url = window.location.search;
    var role = url.replace("?", '');
    role = role.split("=");
    if ($('#userList li').length) {
        if (confirm(_('Please save the changes before leaving.'))) {
            return false;
        } else {
            $('#userList').html('');
        }
    }
    $('.cancel_on_invite').hide();
    $('.cancel_on_direct').show();
    var chk_usr = 0;
    var c_p_j_name = 'All';
    var c_p_j_id = '';
    if (arguments[0] !== undefined) {
        var c_pj_val = $('#curr_active_project').val().trim();
        if (arguments[0] == 2) {
            if ($('#pname_dashboard > span').length) {
                c_p_j_name = $('#pname_dashboard > span').attr('title');
            } else {
                c_p_j_name = $('#pname_dashboard').text();
            }
            if (c_p_j_name != 'All') {
                $('.proj_link_for_invite').each(function(e) {
                    if ($(this).attr('data-proj-id') == c_pj_val) {
                        c_p_j_id = c_pj_val;
                    }
                });
            }
        }
        if (arguments[0] == 9) {
            $('.cancel_on_invite').hide();
            $('.cancel_on_direct').show();
        } else {
            $('.cancel_on_invite').show();
            $('.cancel_on_direct').hide();
        }
        if (arguments[0] == 2 && c_p_j_name == 'All') {
            chk_usr = 0;
        } else {
            chk_usr = 1;
        }
    }
    $(".add_prj_usr").hide();
    openPopup(role[1]);
    if (role[1] == 'client') {
        $("#userpopup").html("<i class='icon_client fl' style='margin-top:5px'></i> " + _('Add New Client'));
        $("#role_hid").val('client');
    }
    $(".new_user").show();
    $("#select_role").select2();
    $(".loader_dv").hide();
    $('#txt_email').val('');
    $('#assign_project_list').html('');
    $(".project_to_be_assn ul.holder,.project_to_be_assn .facebook-auto").remove();
    $('.auto_tab_fld').html('<select name="data[User][pid][]" id="sel_custprj" class="form-control" multiple="multiple"></select>');
    $('#sel_Typ').val(3);
    $('#inner_user').show();
    $("#txt_email").focus();
    if (chk_usr) {
        $('.auto_tab_fld').html('<input type="hidden" name="data[User][pid]" class="form-control" value="' + $('#projectId').val() + '"/><input style="width: 352px;" type"text" readonly="readonly" class="form-control" value="' + $('#project_name').val() + '"/><a href="javascript:void(0);" onclick="changeOnInvite();" style="font-size:11px;font-weight:bold;color:#5F9AC2;">' + _('Change project') + '</a>');
    } else {
        getAutocompleteTag("sel_custprj", "users/getProjects", "340px", "Type to select projects");
    }
    $.material.init();
    if (LANG_PREFIX == '_fra') {
        GBl_tour = tour_invtuser_fra;
    } else if (LANG_PREFIX == '_por') {
        GBl_tour = tour_invtuser_por;
    } else if (LANG_PREFIX == '_spa') {
        GBl_tour = tour_invtuser_spa;
    } else if (LANG_PREFIX == '_deu') {
        GBl_tour = tour_invtuser_deu;
    } else {
        GBl_tour = tour_invtuser;
    }
    $('textarea').autoGrow().keyup();
    getAutocompleteTag("assign_project_list", "users/getProjects/view:'list'", "100%", "Type to select projects");
}

function changeOnInvite() {
    $('.auto_tab_fld').html('<select name="data[User][pid]" id="sel_custprj" class="form-control"></select>');
    getAutocompleteTag("sel_custprj", "users/getProjects", "340px", "Type to select projects");
}

function getAutocompleteTag(id, url, width, plchlder) {
    if (id != 'sel_custprj') {
        $("#" + id).fcbkcomplete({
            json_url: HTTP_ROOT + url,
            addontab: true,
            maxitems: 10,
            input_min_size: 0,
            height: 10,
            cache: true,
            filter_selected: true,
            firstselected: true,
            width: width,
            complete_text: plchlder,
            oncreate: function() {
                setTimeout(function() {}, 2000);
            },
            onremove: function() {
                setTimeout(function() {
                    if ($("#assign_project_list").text().trim() == '' && $(".maininput").val().trim() == '') {
                        $(".maininput").parents(".form-group").removeClass('is-focused');
                        $(".maininput").parents(".form-group").addClass('is-empty');
                    }
                }, 1000);
            }
        });
    } else {
        $('#selected_proj_containerdv').html('');
        getAll_projects();
    }
}

function getAll_projects() {
    var serch = '';
    var serch_chk = 0;
    if (typeof arguments[0] != 'undefined') {
        serch = arguments[0];
        serch_chk = 1;
    }
    $.post(HTTP_ROOT + 'users/getProjects', {
        'q': serch,
        'serch_chk': serch_chk
    }, function(data) {
        if (serch_chk == 1) {
            $('#instant_user_add').html(data);
            if ($('div[id ^=selected_proj_containerdv_').length) {
                $('div[id ^=selected_proj_containerdv_').each(function() {
                    var ido = $(this).attr('data-id');
                    $('#project_checked_' + ido).prop('checked', true);
                });
            }
        } else {
            $('#viewallPrj').html(data);
        }
        $('#load_find_pop_proj').hide();
        $.material.init();
    });
}

function open_more_projects(e) {
    e.stopPropagation();
    $('#list_of_projects_below').slideToggle('slow');
}

function closelistProject(pid) {
    $('#selected_proj_containerdv_' + pid).remove();
    $('#opt_proj_' + pid).remove();
    $('#project_checked_' + pid).prop('checked', false);
}

function memberCustomer(txtEmailid, selprj, loader, btn) {
    var email_id = $('#' + txtEmailid).val();
    var email_arr = email_id.split(',');
    var done = 1;
    if (email_id == "") {
        done = 0;
        msg = _("Email cannot be left blank!");
        $('#err_email_new').html('');
        $('#err_email_new').show();
        $('#err_email_new').html(msg);
        document.getElementById(txtEmailid).focus();
        return false;
    } else {
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!email_id.match(emlRegExpRFC) || email_id.search(/\.\./) != -1) {
            if (email_id.indexOf(',') != -1) {
                var totlalemails = 0;
                for (var i = 0; i < email_arr.length; i++) {
                    if (email_arr[i].trim() != "") {
                        if ((!email_arr[i].trim().match(emlRegExpRFC) || email_arr[i].trim().search(/\.\./) != -1)) {
                            done = 0;
                            msg = "Invalid Email: '" + email_arr[i] + "'";
                            $('#err_email_new').html('');
                            $('#err_email_new').show();
                            $('#err_email_new').html(msg);
                            document.getElementById(txtEmailid).focus();
                            return false;
                        }
                    } else {
                        totlalemails++;
                    }
                }
                if (totlalemails == email_arr.length) {
                    msg = _("Entered stirng is not a valid email");
                    $('#err_email_new').html("");
                    $('#err_email_new').show();
                    $('#err_email_new').html(msg);
                    $('#' + txtEmailid).focus();
                    return false;
                }
            } else {
                done = 0;
                msg = _("Invalid E-Mail!");
                $('#err_email_new').html('');
                $('#err_email_new').show();
                $('#err_email_new').html(msg);
                document.getElementById(txtEmailid).focus();
                return false;
            }
        }
        if (done != 0) {
            var type = $('#sel_Typ').val();
            if (type == 2) {
                var usertype = "Admin";
            } else if (type == 3) {
                var usertype = "Member";
            }
            $('#err_email_new').hide();
            $("#ldr").show();
            $("#btn_addmem").hide();
            var uniq_id = $("#uniq_id").val();
            var strURL = HTTP_ROOT;
            if (email_id.indexOf(',') != -1) {
                $.post(strURL + "users/ajax_check_user_exists", {
                    "email": escape(email_id),
                    "uniq_id": escape(uniq_id)
                }, function(data) {
                    if (data == "success") {
                        document.myform.submit();
                        return true;
                    } else {
                        if (data == 'errorlimit') {
                            $("#ldr").hide();
                            $("#btn_addmem").show();
                            $("#err_email_new").show();
                            $("#err_email_new").html(_("Sorry! You are exceeding your user limit."));
                        } else {
                            $("#ldr").hide();
                            $("#btn_addmem").show();
                            $("#err_email_new").show();
                            $("#err_email_new").html(_("Oops! Invitation already sent to") + " '" + data + "'!");
                        }
                        return false;
                    }
                });
            } else {
                $.post(strURL + "users/ajax_check_user_exists", {
                    "email": escape(email_id),
                    "uniq_id": escape(uniq_id)
                }, function(data) {
                    if (data == "invited" || data == "exists" || data == "owner" || data == "account") {
                        $("#ldr").hide();
                        $("#btn_addmem").show();
                        $("#err_email_new").show();
                        if (data == "owner") {
                            $("#err_email_new").html(_("Ah... you are inviting the company Owner!"));
                        } else if (data == "account") {
                            $("#err_email_new").html(_("Ah... you are inviting yourself!"));
                        } else {
                            $("#err_email_new").html(_("Oops! Invitation already sent to") + " '" + email_id + "'!");
                        }
                        return false;
                    } else {
                        document.myform.submit();
                        return true;
                    }
                });
            }
        }
    }
    return false;
}

function sch_slide() {
    $('.search_top_hide_show_spn').hide();
    $('.search_top_hide').show();
    $('.upgrd_btn_top_hdr,.upgrd_btn').hide();
    var in_html = $('.left_trial_span').html();
    $('.right_pfl_menu').removeClass('open_search');
    $(".search_top").animate({
        width: '295px'
    }, 400, function() {
        $('.right_pfl_menu').addClass('open_search');
        clearSearchvis();
        $(".search_top").focus();
        $("#case_search").keyup(function(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode;
            if (unicode != 13 && unicode != 40 && unicode != 38) {
                var srch = $("#case_search").val();
                srch = srch.trim();
                if (srch == "") {
                    $('#srch_load1').hide();
                } else {
                    $('#srch_remv').hide();
                    $('#srch_load1').show();
                }
                if (globalTimeout != null)
                    clearTimeout(globalTimeout);
                $('#ajax_search').html("");
                focusedRow = null;
                globalCount = 0;
                globalTimeout = setTimeout(ajaxCaseSearch, 1000);
            }
            if (unicode == 40 || unicode == 38) {
                if ($('.ajx-srch-tbl tr').hasClass("alltrcls")) {
                    var rowCount = $('.ajx-srch-tbl tr').length;
                    if (focusedRow == null) {
                        focusedRow = $('tr:nth-child(2)', '.ajx-srch-tbl');
                        globalCount = 1;
                    } else if (unicode === 38) {
                        focusedRow.toggleClass('selctd-srch');
                        focusedRow = focusedRow.prev('tr');
                        globalCount--;
                    } else if (unicode === 40) {
                        focusedRow.toggleClass('selctd-srch');
                        focusedRow = focusedRow.next('tr');
                        globalCount++;
                    }
                    if ((parseInt(rowCount) == globalCount) || (globalCount == 0)) {
                        focusedRow = $('tr:nth-child(2)', '.ajx-srch-tbl');
                        focusedRow.toggleClass('selctd-srch');
                        globalCount = 1;
                    } else {
                        focusedRow.toggleClass('selctd-srch');
                    }
                }
            }
        });
    });
    $(".search_top").off().on('blur', function() {
        var search_val = $('#ajax_search').text().trim();
        var txt_val = $('#case_search').val().trim();
        if (search_val == '' && txt_val == '') {
            $(this).animate({
                width: '150px'
            }, 400, function() {
                $('.right_pfl_menu').removeClass('open_search');
                $('.left_trial_span').html(in_html);
                $('.search_top_hide_show_spn').show();
                $('.search_top_hide').hide();
                $('.upgrd_btn_top_hdr,.upgrd_btn').show();
            });
        }
    });
}

function slider_inner_search(v) {
    if (v == 'open') {
        if ($('#inner-search').width() == 0 || $('#inner-search').width() < 10) {
            $('#inner-search').addClass('open');
            $("#inner-search").animate({
                width: '200px'
            }, 400, function() {
                $('#inner-search').focus();
            });
        }
    }
    $("#inner-search").off().on('blur', function() {
        search_val = $('#inner-search').val().trim();
        if (search_val == '') {
            $(this).animate({
                width: '0px'
            }, 400, function() {
                $('#inner-search').removeClass('open');
                $("#ajax_inner_search").html('').hide();
                $("#srch_inner_load1").hide();
            });
        }
    });
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    } else {
        return "";
    }
}
$(document).ready(function() {
    $(".preventdefaultaction").click(function() {});
    $("#prj_ahref").hover(function() {
        if ($('#prj_drpdwn').hasClass('dropdown')) {
            $('#projpopup').removeAttr('style');
        }
    });
    $('.show_tooltip').hide();
    $('a.wink').hover(function() {
        $(this).find('.show_tooltip').show();
    }, function() {
        $(this).find('.show_tooltip').hide();
    });
    $('#txt_Proj').keyup(function(e) {
        var str = $(this).val();
        var str_temp = '';
        if (e.keyCode == 32 || e.keyCode == 8 || e.keyCode == 46) {
            makeShortName(str, 0);
        }
    });
    $('#txt_Proj_onboard').keyup(function(e) {
        var str = $(this).val();
        var str_temp = '';
        if (e.keyCode == 32 || e.keyCode == 8 || e.keyCode == 46) {
            makeShortName(str, 0);
        }
    });
    $('#txt_Proj_onboard').blur(function(e) {
        var str = $(this).val();
        makeShortName(str);
    });
    $('#txt_Proj').blur(function(e) {
        var str = $(this).val();
        makeShortName(str);
    });
    $('#txt_shortProj').keyup(function() {
        $('#short_nm_prj_new').val(1);
    });
});

function makeShortName(str) {
    var str_temp = '';
    str = str.trim();
    str_temp = str;
    if (str != '') {
        if ($('#txt_shortProj').val().trim().length >= 5) {
            return true;
        }
        if ($('#short_nm_prj_new').val() == 1) {
            if ($('#txt_Proj_onboard').length) {
                $('#txt_shortProj_onboard').val(chr);
            } else if ($('#txt_shortProjEdit').length) {
                $('#txt_shortProjEdit').keyup();
            } else {
                $('#txt_shortProj').keyup();
            }
            return true;
        }
        str = str.replace(/\s{2,}/g, ' ');
        var spltStr = str.split(' ');
        var chr = '';
        var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
        if (spltStr.length >= 2) {
            $.each(spltStr, function(index, value) {
                var t_chr = value.substr(0, 1);
                var t_test = inValid.test(t_chr);
                if (!t_test) {
                    chr += t_chr;
                } else {
                    var t_chr = value.substr(1, 1);
                    var t_test = inValid.test(t_chr);
                    if (!t_test) {
                        chr += t_chr;
                    }
                }
            });
        } else {
            var t_chr = str.substr(0, 1);
            var t_test = inValid.test(t_chr);
            if (!t_test) {
                chr = t_chr;
            } else {
                var t_chr = str.substr(1, 1);
                var t_test = inValid.test(t_chr);
                if (!t_test) {
                    chr = t_chr;
                }
            }
        }
        chr = chr.toUpperCase();
        if ($('#txt_Proj_onboard').length) {
            $('#txt_shortProj_onboard').val(chr);
        } else if ($('#txt_shortProjEdit').length) {
            $('#txt_shortProjEdit').val(chr).keyup();
        } else {
            $('#txt_shortProj').val(chr).keydown();
        }
    } else {
        $('#short_nm_prj_new').val(0);
        if ($('#txt_Proj_onboard').length) {
            $('#txt_shortProj_onboard').val('');
            $('#txt_shortProj_onboard').attr('placeholder', 'MP');
        } else if ($('#txt_shortProjEdit').length) {
            $('#txt_shortProjEdit').val('').keyup();
        } else {
            $('#txt_shortProj').val('');
        }
    }
}
$(document).keypress(function(e) {
    if (e.which == 13) {
        if ($('a').hasClass('popup_selected')) {
            eval($('.popup_selected').attr('onClick'));
        }
    }
});

function view_project_menu(page) {
    if (typeof page == 'undefined') {
        page = 'dashboard';
    }
    if (!$('#projpopup').is(':visible')) {
        $('#projpopup').show();
    } else {
        if ($('#ajaxViewProjects').html().trim() != "") {
            $('#projpopup').hide();
            $('#loader_prmenu').hide();
            return false;
        }
    }
    var caseMenuFilters = $('#caseMenuFilters').val();
    if (caseMenuFilters == 'calendar') {
        $('.fc-view-agendaWeek').css('z-index', '1');
        $('.fc-view-agendaDay').css('z-index', '1');
    }
    var usrUrl = HTTP_ROOT;
    if ($('#ajaxViewProjects').html().trim() == "") {
        $("#search_project_menu_txt").val('');
        $('#ajaxViewProject').html('');
        $('#ajaxViewProjects').html('');
        $("#find_prj_dv").hide();
        $('#loader_prmenu').show();
        $.post(usrUrl + "users/project_menu", {
            "page": page,
            "limit": 6,
            "filter": caseMenuFilters
        }, function(data) {
            if (data) {
                $('#loader_prmenu').hide();
                $("#find_prj_dv").show();
                $('#ajaxViewProjects').show();
                $('#ajaxViewProjects').html(data);
                $('#checkload').val('1');
                $('#search_project_menu_txt').focus();
            }
        });
    } else {
        $("#search_project_menu_txt").val('');
        $('#ajaxViewProject').html('');
        $('#ajaxViewProject').hide();
        $("#find_prj_dv").show();
        $('#search_project_menu_txt').focus();
        $('#ajaxViewProjects').show();
    }
}

function view_project_menu_popup(page) {
    if (page == 'subtask_popup') {
        var popupid = 'projpopup_subtask';
        var viewprojects = 'ajaxViewProjects_subtask';
        var viewproject = 'ajaxViewProject_subtask';
        var loader = 'loader_prmenu_subtask';
        var menu_txt_log = 'search_project_menu_txt_subtask';
        var find_prj_dv = 'find_prj_dv_subtask';
    } else {
        var popupid = 'projpopup_log';
        var viewprojects = 'ajaxViewProjects_log';
        var viewproject = 'ajaxViewProject_log';
        var loader = 'loader_prmenu_log';
        var menu_txt_log = 'search_project_menu_txt_log';
        var find_prj_dv = 'find_prj_dv_log';
    }
    $('#' + viewproject).hide();
    resetLogTask();
    if (!$('#' + popupid).is(':visible')) {
        $('#' + popupid).show();
    }
    var caseMenuFilters = $('#caseMenuFilters').val();
    if (caseMenuFilters == 'calendar') {
        $('.fc-view-agendaWeek').css('z-index', '1');
        $('.fc-view-agendaDay').css('z-index', '1');
    }
    var usrUrl = HTTP_ROOT;
    if ($('#' + viewprojects).html().trim() == "") {
        $("#" + menu_txt_log).val('');
        $('#' + viewproject).html('');
        $('#' + viewprojects).html('');
        $("#" + find_prj_dv).hide();
        $('#' + loader).show();
        $.post(usrUrl + "users/project_menu", {
            "page": page,
            "limit": 6,
            "filter": caseMenuFilters,
            "popupid": popupid
        }, function(data) {
            $('#' + loader).hide();
            if (data) {
                $("#" + find_prj_dv).show();
                $('#' + viewprojects).show();
                $('#' + viewprojects).html(data);
                $('#checkload').val('1');
                $('#' + menu_txt_log).focus();
            }
        });
    } else {
        $("#" + menu_txt_log).val('');
        $('#' + viewproject).html('');
        $('#' + viewproject).hide();
        $("#find_prj_dv_log").show();
        $('#' + menu_txt_log).focus();
        $('#' + viewprojects).show();
    }
}

function search_project_menu_popup(page, val, e) {
    var key = e.keyCode;
    if (key == 13)
        return;
    if (page == 'subtask_popup') {
        var menu_div_id = 'ajaxViewProjects_subtask';
        if ($('#ajaxViewProject_subtask').is(":visible")) {
            var menu_div_id = 'ajaxViewProject_subtask';
            $('#ajaxViewProjects_subtask > li').removeClass('popup_selected');
        }
        var menu_div_id_s = 'ajaxViewProject_subtask';
        var menu_div_loader = 'load_find_subtask';
    } else {
        var menu_div_id = 'ajaxViewProjects_log';
        if ($('#ajaxViewProject_log').is(":visible")) {
            var menu_div_id = 'ajaxViewProject_log';
            $('#ajaxViewProjects > li').removeClass('popup_selected');
        }
        var menu_div_id_s = 'ajaxViewProject_log';
        var menu_div_loader = 'load_find_log';
    }
    if (e.keyCode == 40 || e.keyCode == 38) {
        var selected = "$('#" + menu_div_id + " > a')";
        if (key == 40) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':last-child')) {
                $current = $('#' + menu_div_id_s + ' > a').eq(0);
            } else {
                if ($('#' + menu_div_id + '> a').hasClass('popup_selected')) {
                    $current = $('#' + menu_div_id + '> a').filter('.popup_selected').next('hr').next('a');
                } else {
                    $current = $('#' + menu_div_id + ' > a').eq(0);
                }
            }
        } else if (key == 38) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':first-child')) {
                $current = $('#' + menu_div_id + ' > a').last('a');
            } else {
                $current = $('#' + menu_div_id + ' > a').filter('.popup_selected').prev('hr').prev('a');
            }
        }
        $('#' + menu_div_id + ' > a').removeClass('popup_selected');
        $current.addClass('popup_selected');
    } else {
        var caseMenuFilters = $('#caseMenuFilters').val();
        var strURL = HTTP_ROOT + "users/";
        if (val != "") {
            $('#' + menu_div_loader).show();
            $.post(strURL + "search_project_menu", {
                "page": page,
                "val": val,
                "filter": caseMenuFilters,
                "page_name": ''
            }, function(data) {
                if (data) {
                    $('#' + menu_div_id_s).show();
                    $('#' + menu_div_id).hide();
                    $('#' + menu_div_id_s).html(data).show();
                    $('#' + menu_div_loader).hide();
                }
            });
        } else {
            $('#' + menu_div_id_s).hide();
            $('#' + menu_div_id).show();
            $('#' + menu_div_loader).hide();
        }
    }
}

function search_project_menu(page, val, e) {
    var key = e.keyCode;
    if (key == 13)
        return;
    var menu_div_id = 'ajaxViewProjects';
    if ($('#ajaxViewProject').is(":visible")) {
        var menu_div_id = 'ajaxViewProject';
        $('#ajaxViewProjects > li').removeClass('popup_selected');
    }
    if (e.keyCode == 40 || e.keyCode == 38) {
        var selected = "$('#" + menu_div_id + " > a')";
        if (key == 40) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':last-child')) {
                $current = $('#ajaxViewProject > a').eq(0);
            } else {
                if ($('#' + menu_div_id + '> a').hasClass('popup_selected')) {
                    $current = $('#' + menu_div_id + '> a').filter('.popup_selected').next('hr').next('a');
                } else {
                    $current = $('#' + menu_div_id + ' > a').eq(0);
                }
            }
        } else if (key == 38) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':first-child')) {
                $current = $('#' + menu_div_id + ' > a').last('a');
            } else {
                $current = $('#' + menu_div_id + ' > a').filter('.popup_selected').prev('hr').prev('a');
            }
        }
        $('#' + menu_div_id + ' > a').removeClass('popup_selected');
        $current.addClass('popup_selected');
    } else {
        var caseMenuFilters = $('#caseMenuFilters').val();
        var strURL = HTTP_ROOT + "users/";
        if (val != "") {
            $('#load_find_dashboard').show();
            $.post(strURL + "search_project_menu", {
                "page": page,
                "val": val,
                "filter": caseMenuFilters,
                "page_name": ''
            }, function(data) {
                if (data) {
                    $('#ajaxViewProject').show();
                    $('#ajaxViewProjects').hide();
                    $('#ajaxViewProject').html(data);
                    $('#load_find_dashboard').hide();
                }
            });
        } else {
            $('#ajaxViewProject').hide();
            $('#ajaxViewProjects').show();
            $('#load_find_dashboard').hide();
        }
    }
}

function updateAllProj(radio, projId, page, all, pname, srch) {
    if (all != 'all') {
        resetAllFilters('all', 1);
    }
    var projtypeobj = ALLMETHODOLOGY;
    var p_types = ['tasks'];
    for (var i in projtypeobj)
        p_types.push(projtypeobj[i].toLowerCase());
    var projMethChang = '';
    var inpt_type = (typeof arguments[6] != 'undefined') ? arguments[6] : 1;
    var projMethType = $('#projMethType').val();
    refreshTasks = 1;
    refreshActvt = 1;
    refreshKanbanTask = 1;
    refreshMilestone = 1;
    refreshManageMilestone = 1;
    var prjid = $("#projFil").val();
    var params = parseUrlHash(urlHash);
    if ($('#filterModal').is(':visible')) {
        closeTaskFilter();
    }
    var isChange = false;
    if ((params[0] == 'tasks' || params[0] == 'backlog' || params[0] == 'taskgroup' || params[0] == 'taskgroups' || params[0] == 'kanban') && projMethType != p_types[inpt_type] && inpt_type != '9') {
        $('#projMethType').val(p_types[inpt_type]);
        $.each(projtypeobj, function(k, v) {
            if (inpt_type == k) {
                updateProj(radio, projId);
                createCookie('prjChangeId', projId, 1, DOMAIN_COOKIE);
                if (all == '0') {
                    remember_filters('ALL_PROJECT', '');
                } else {
                    remember_filters('ALL_PROJECT', 'all');
                }
                if (all != 'all') {
                    isChange = true;
                    return false;
                }
            }
        });
        if (isChange) {
            var cnt = "<a class='top_project_name ellipsis-view' title='" + pname + "' href='javascript:void(0);' onClick='updateAllProj(\"" + radio + "\",\"" + projId + "\",\"" + page + "\",\"" + all + "\",\"" + pname + "\",\"" + srch + "\");'>" + decodeURIComponent(pname) + "</a>";
            $('#pname_dashboard').html(cnt);
            $("#projUpdateTop").html(decodeURIComponent(pname));
            $('#projpopup').hide();
            $('#prj_drpdwn').removeClass("open");
            $(".dropdown-menu.lft").hide();
            $("#find_prj_dv").hide();
            if (inpt_type == 2) {
                ajaxBacklogView(filterSprint('quk_fil_bklog', 1));
            } else if (inpt_type == 3) {
                easycase.showKanbanTaskList('kanban');
            } else if (inpt_type == 1) {
                $('#caseComment').val('');
                createCookie('COMMENTS', '', -1, DOMAIN_COOKIE);
                localStorage.removeItem('COMMENTS');
                ajaxCaseView('case_project');
            } else {
                easycase.showKanbanTaskList('kanban');
            }
            return;
        }
    } else if (projMethType != p_types[inpt_type]) {
        if (all != 'all') {
            updateProj(radio, projId);
            createCookie('prjChangeId', projId, 1, DOMAIN_COOKIE);
        }
        if (all == '0') {
            remember_filters('ALL_PROJECT', '');
        } else {
            remember_filters('ALL_PROJECT', 'all');
        }
        if (all != 'all' && params[0] != 'timelog') {
            window.location.reload();
        }
    }
    search_key = '';
    if (radio == '0' && projId == '0') {
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
    }
    if (projId != prjid) {
        $('#easycase_uid').val('');
    }
    if ($('#reset_btn').is(":visible") && !$('#customFIlterId').val() && !($('#filtered_items .filter_opn').length == 1 && casePage > 1)) {} else {
        casePage = 1;
    }
    casePage = 1;
    if (all == '0') {
        $("#projUpdateTop").html(decodeURIComponent(pname));
        $('#projpopup').hide();
        $('#prj_drpdwn').removeClass("open");
        $(".dropdown-menu.lft").hide();
        $("#find_prj_dv").hide();
        if (page == 'subtask_popup') {
            $('#projpopup_subtask,#find_prj_dv_popup').hide();
        }
        if (pname && (page != "import")) {
            var fst = $('#pname_dashboard_hid').val();
            var secnd = $('#first_recent_hid').val();
            var thrd = $('#second_recent_hid').val();
            var decodepname = decodeURIComponent(pname);
            var ucpname = decodepname;
            var cnt = "<a class='top_project_name ellipsis-view' title='" + ucpname + "' href='javascript:void(0);' onClick='updateAllProj(\"" + radio + "\",\"" + projId + "\",\"" + page + "\",\"" + all + "\",\"" + pname + "\",\"" + srch + "\");'>" + ucpname + "</a>";
            if (secnd == ucpname) {
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                $('#first_recent_hid').val(fst);
                $('#pname_dashboard_hid').val(secnd);
            } else if (thrd == ucpname) {
                $('#second_recent').html($('#first_recent').html());
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                $('#second_recent_hid').val(secnd);
                $('#first_recent_hid').val(fst);
                $('#pname_dashboard_hid').val(thrd);
            } else if (fst == ucpname) {
                $('#pname_dashboard').html(cnt);
            } else {
                $('#second_recent').html($('#first_recent').html());
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                if (typeof(secnd) != "undefined") {
                    $('#second_recent_hid').val(secnd);
                }
                if (typeof(fst) != "undefined") {
                    $('#first_recent_hid').val(fst);
                }
                $('#pname_dashboard_hid').val(ucpname);
            }
            $('.pname_dashboard').html(decodeURIComponent(pname));
            $('#pname_dashboard').html(cnt);
            $('.top_project_name').tipsy({
                gravity: 'n',
                fade: true
            });
            if (page == 'subtask_popup') {
                $('#pname_dashboard_subtask').html(cnt);
            }
        }
        if (page == "dashboard") {
            updateProj(radio, projId);
            var params = parseUrlHash(urlHash);
            if (params[0] == "details" && $('#easycase_uid').val()) {
                easycase.refreshTaskList($('#easycase_uid').val());
            } else if (params[0] == "overview") {
                ajaxProjectOveriew();
            } else if (params[0] == "backlog") {
                ajaxBacklogView(filterSprint('quk_fil_bklog', 1));
            } else if (params[0] == "activesprint") {
                ajaxSprintView(filterSprint('quk_fil_sprint', 1));
            } else if (params[0] == "chart_timelog") {
                if (typeof angular.element(document.getElementById('chart_log_view')).scope() != 'undefined' && typeof angular.element(document.getElementById('chart_log_view')).scope().get_chart_timelog == 'function') {
                    angular.element(document.getElementById('chart_log_view')).scope().get_chart_timelog();
                } else {
                    location.reload();
                }
            } else if (params[0] == "activities") {
                $('#priFil').val("all");
                $('#caseTypes').val("all");
                $('#caseLabel').val("all");
                $('#caseStatus').val("all");
                $('#caseMember').val("all");
                $('#caseComment').val("all");
                $('#caseAssignTo').val("all");
                $('#caseDateFil').val("");
                $('#casedueDateFil').val("");
                remember_filters('reset', 'all');
                easycase.showActivities();
            } else if (params[0] == "mentioned_list") {
                $('#priFil').val("all");
                $('#caseTypes').val("all");
                $('#caseLabel').val("all");
                $('#caseStatus').val("all");
                $('#caseMember').val("all");
                $('#caseComment').val("all");
                $('#caseAssignTo').val("all");
                $('#caseDateFil').val("");
                $('#casedueDateFil').val("");
                remember_filters('reset', 'all');
                easycase.showMentionList();
            } else {
                var caseUrl = $("#caseUrl").val();
                if (caseUrl) {
                    window.location = HTTP_ROOT + "dashboard/?project=" + projId;
                    return false;
                }
                if ($('#caseMenuFilters').val() == "files") {
                    $('#priFil').val("all");
                    $('#caseTypes').val("all");
                    $('#caseLabel').val("all");
                    $('#caseStatus').val("all");
                    $('#caseMember').val("all");
                    $('#caseComment').val("all");
                    $('#caseAssignTo').val("all");
                    $('#caseDateFil').val("");
                    $('#casedueDateFil').val("");
                    remember_filters('reset', 'all');
                    easycase.showFiles("files");
                } else {
                    if ($('#caseMenuFilters').val() == 'milestonelist') {
                        $('#milestoneLimit').val('0');
                        $('#totalMlstCnt').val('0');
                        $('#priFil').val("all");
                        $('#caseTypes').val("all");
                        $('#caseLabel').val("all");
                        $('#caseStatus').val("all");
                        $('#caseMember').val("all");
                        $('#caseComment').val("all");
                        $('#caseAssignTo').val("all");
                        $('#caseDateFil').val("");
                        $('#casedueDateFil').val("");
                        remember_filters('reset', 'all');
                        showMilestoneList();
                    } else if ($('#caseMenuFilters').val() == 'milestone') {
                        $('#mlstPage').val(1);
                        ManageMilestoneList();
                    } else if ($('#caseMenuFilters').val() == 'timelog') {
                        ajaxTimeLogView();
                    } else {
                        if (params[0] == 'kanban' && typeof params[1] != 'undefined') {
                            window.location.hash = 'milestonelist';
                        } else {
                            easycase.refreshTaskList();
                        }
                    }
                }
            }
        } else if (page == "timelog") {
            var usrhtml = "";
            $.post(HTTP_ROOT + "easycases/timelog", {
                'projuniqid': projId
            }, function(data) {
                if (data) {
                    $('#timelogtbl').html(data);
                    $('#whosassign1').html(rsrch);
                    $('#whosassign1').val(SES_ID);
                    $('#rsrclog').html(rsrch);
                    $('#projFil').val(projId);
                }
            });
        } else if (page == "wikidetails") {
            window.location = HTTP_ROOT + 'wiki-details';
        } else if (page == "invoice") {
            remember_filters('INVOICE_DATE', 'all');
            remember_filters('INVOICE_RESOURCE', 'all');
            $('#dropdown_menu_invoice_filters').hide();
            $('#dropdown_menu_invoiceCreatedDate').find('input[type="checkbox"]').removeAttr('checked');
            $('#dropdown_menu_invoiceCreatedDate').find('input[type="checkbox"][id="invoice_alldates"]').attr('checked', 'checked');
            $('#dropdown_menu_invoiceCreatedDate').find('input[type="text"]').val('');
            $('#dropdown_menu_invoiceResource').find('input[type="checkbox"]').removeAttr('checked');
            $('#priFil').val("all");
            $('#caseTypes').val("all");
            $('#caseLabel').val("all");
            $('#caseStatus').val("all");
            $('#caseMember').val("all");
            $('#caseComment').val("all");
            $('#caseAssignTo').val("all");
            $('#caseDateFil').val("");
            $('#casedueDateFil').val("");
            remember_filters('reset', 'all');
            updateProj(radio, projId);
            $.post(HTTP_ROOT + "easycases/update_invoice_project", {
                'projuniqid': projId
            }, function(data) {
                PUSERS = data;
                invoices.switch_tab('logtime');
            }, 'json');
        } else if (page == "milestone") {
            window.location = HTTP_ROOT + 'milestone/?pj=' + projId;
        } else if (page == "import") {
            window.location = HTTP_ROOT + 'projects/importexport/' + projId;
        } else if (page == 'milestonelist') {
            $('#milestoneLimit').val('0');
            $('#totalMlstCnt').val('0');
            updateProj(radio, projId);
            showMilestoneList();
        } else if (page == "manage") {
            var pjname = $("#pname_dashboard_hid").val();
            $("#milestonelist").hide();
            $("#caseLoader").css("display", "block");
            $('#projFil').val(projId);
            createCookie('prjid', projId, 365, DOMAIN_COOKIE);
            createCookie('pjname', pname, 365, DOMAIN_COOKIE);
            delete_cookie('mlstnid');
            var ganttprjcookie = getCookie('prjid');
            if (ganttprjcookie) {
                projId = ganttprjcookie;
            }
            $.post(HTTP_ROOT + "Ganttchart/get_milestones", {
                prjid: projId
            }, function(res) {
                $("#milestonelist").html(res);
                $("#milestonelist").show();
                $("#caseLoader").hide();
            });
        } else if (CONTROLLER == "Defects" && page == "defect_files") {
            $('#defectLoader').show();
            createCookie("All_Project", "", -365, "");
            createCookie("ALL_PROJECT", "", -365, "");
            createCookie("All_Project_Defect_Files", "", -365, "");
            updateProj(radio, projId);
            $.post(HTTP_ROOT + "easycases/update_invoice_project", {
                'projuniqid': projId
            }, function(data) {
                $('#projFil').val(projId);
                ajaxDefectFilesView();
            });
        } else if (CONTROLLER == "Defects" && page == "defect") {
            $('#defectLoader').show();
            createCookie("All_Project", "", -365, "");
            createCookie("ALL_PROJECT", "", -365, "");
            createCookie("All_Project_Defect", "", -365, "");
            updateProj(radio, projId);
            $.post(HTTP_ROOT + "easycases/update_invoice_project", {
                'projuniqid': projId
            }, function(data) {
                $('#projFil').val(projId);
                ajaxDefectView();
            });
        } else if (CONTROLLER == 'Defects' && page == "defect") {
            $('#defectLoader').show();
            createCookie("All_Project_Defect", "all", 365, "");
            createCookie("All_Project", "", -365, "");
            createCookie("ALL_PROJECT", "", -365, "");
            updateProj1('all');
            ajaxDefectView();
            loadCaseMenu(HTTP_ROOT + "easycases/ajax_case_menu", {
                "projUniq": projId,
                "pageload": 0,
                "page": "defect"
            });
        } else if (CONTROLLER == "Defects" && page == "defect_report") {
            $('#defectLoader').show();
            createCookie("All_Project", "", -365, "");
            createCookie("ALL_PROJECT", "", -365, "");
            createCookie("All_Project_Defect", "", -365, "");
            updateProj(radio, projId);
            $.post(HTTP_ROOT + "easycases/update_invoice_project", {
                'projuniqid': projId
            }, function(data) {
                $('#projFil').val(projId);
                ajaxDefectReport();
            });
        } else if (page == 'ganttv2' || page == 'dhtmlxgantt') {
            page_no = 1;
            var pjname = $("#pname_dashboard_hid").val();
            $("#milestonelist").hide();
            $("#caseLoader").css("display", "block");
            $('#projFil').val(projId);
            createCookie('prjid', projId, 365, DOMAIN_COOKIE);
            createCookie('pjname', pname, 365, DOMAIN_COOKIE);
            delete_cookie('mlstnid');
            var ganttprjcookie = getCookie('prjid');
            if (ganttprjcookie) {
                projId = ganttprjcookie;
            }
            loadGanttFromServer(projId, '', 1)
        } else if (page == 'subtask_popup') {
            $('#projFil').val(projId);
            ajaxCaseSubtaskView();
        } else {
            window.location = HTTP_ROOT + 'dashboard/?project=' + projId;
        }
        general.update_footer_total(projId);
    } else {
        $('#projpopup').hide();
        $("#find_prj_dv").hide();
        $('#prj_drpdwn').removeClass("open");
        $(".dropdown-menu.lft").hide();
        if (page == 'subtask_popup') {
            $('#projpopup_subtask,#find_prj_dv_popup').hide();
        }
        if (pname) {
            var fst = $('#pname_dashboard a').html();
            var secnd = $('#first_recent a').html();
            var thrd = $('#second_recent a').html();
            var cnt = "<a class='top_project_name ellipsis-view' title='" + pname + "' href='javascript:void(0);' onClick='updateAllProj(\"" + radio + "\",\"" + projId + "\",\"" + page + "\",\"" + all + "\",\"" + pname + "\",\"" + srch + "\");'>" + decodeURIComponent(pname) + "</a>";
            if (secnd == decodeURIComponent(pname)) {
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                $('#pname_dashboard_hid').val('All');
                $('#first_recent_hid').val(fst);
            } else if (thrd == decodeURIComponent(pname)) {
                $('#second_recent').html($('#first_recent').html());
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                $('#pname_dashboard_hid').val('All');
                $('#first_recent_hid').val(fst);
                $('#second_recent_hid').val(secnd);
            } else if (fst == decodeURIComponent(pname)) {
                $('#pname_dashboard').html(cnt);
            } else {
                $('#second_recent').html($('#first_recent').html());
                $('#first_recent').html($('#pname_dashboard').html());
                $('#pname_dashboard').html(cnt);
                $('#pname_dashboard_hid').val('All');
                $('#first_recent_hid').val(fst);
                $('#second_recent_hid').val(secnd);
            }
            $('.pname_dashboard').html(ucfirst(decodeURIComponent(pname)));
            $('.top_project_name').tipsy({
                gravity: 'n',
                fade: true
            });
        }
        var params = parseUrlHash(urlHash);
        if (typeof params != 'undefined' && params[0] == 'timelog') {
            $('#caseMenuFilters').val('timelog');
        }
        if (page == "dashboard") {
            updateProj1('all');
            if ($('#caseMenuFilters').val() == "files") {
                easycase.showFiles("files");
            } else {
                if ($('#caseMenuFilters').val() == 'milestonelist') {
                    $('#milestoneLimit').val('0');
                    $('#totalMlstCnt').val('0');
                    showMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'milestone') {
                    $('#mlstPage').val(1);
                    ManageMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'kanban' || $('#caseMenuFilters').val() == 'kanban_only') {
                    easycase.showKanbanTaskList('kanban');
                } else if ($('#caseMenuFilters').val() == 'calendar') {
                    calendarView('calendar');
                } else if ($('#caseMenuFilters').val() == "activities") {
                    easycase.showActivities();
                } else if ($('#caseMenuFilters').val() == "mentioned_list") {
                    easycase.showMentionList();
                } else if ($('#caseMenuFilters').val() == "timelog") {
                    ajaxTimeLogView();
                } else if ($('#caseMenuFilters').val() == "calendar_timelog") {
                    getCalenderForTimeLog('hash');
                } else {
                    $('#caseComment').val('');
                    createCookie('COMMENTS', '', -1, DOMAIN_COOKIE);
                    localStorage.removeItem('COMMENTS');
                    ajaxCaseView('case_project');
                }
            }
        } else if (page == 'subtask_popup') {
            updateProj1('all');
            ajaxCaseSubtaskView();
        } else if (page == 'milestonelist') {
            updateProj1('all');
            $('#milestoneLimit').val('0');
            $('#totalMlstCnt').val('0');
            showMilestoneList();
        } else {
            window.location = HTTP_ROOT + 'easycases/dashboard/?project=all';
        }
    }
}

function CaseActivity(pjid, pname) {
    $('#pname_dashboard').html(decodeURIComponent(pname));
    $('#prjid').val(pjid);
    $('#projpopup').hide();
    $("#find_prj_dv").hide();
    $('#prj_drpdwn').removeClass("open");
    $(".dropdown-menu.lft").hide();
    $("#activities").html('');
    $("#moreloader").show();
    loadActivity('');
    loadOverdue('my');
    loadUpcoming('my');
}

function updateProj(id, uniq) {
    $('#projFil').val(uniq);
    $('#CS_project_id').val(uniq);
    $("#ajaxViewProjects").slideUp(300);
    $('#curr_active_project').val(uniq);
    drawLeftMenu();
}

function updateProj1(all) {
    $('#projFil').val('all');
    $("#ajaxViewProjects").slideUp(300);
    drawLeftMenu();
}

function displayMenuProjects(page, limit, filter) {
    var strURL = HTTP_ROOT + "users/project_menu";
    var fil = $('#caseMenuFilters').val();
    if (limit == "all" && page != 'timelogpopup') {
        $('#showMenu_case_txt').hide();
        $('#loaderMenu_case').show();
    } else if (page == 'timelogpopup') {
        $('#showMenu_case_txt_log').hide();
        $('#loaderMenu_case_log').show();
    }
    if (fil == 'timelog') {
        filter = fil;
    }
    var popupid = (page == 'timelogpopup') ? "projpopup_log" : "projpopup";
    var chk_hash = getHash();
    $.post(strURL, {
        "page": page,
        "limit": limit,
        "filter": filter,
        "popupid": popupid
    }, function(data) {
        if (data) {
            if (page == "timelogpopup") {
                $('#ajaxViewProjects_log').html(data).promise().done(function() {
                    $(this).find('#newprj_but').remove();
                });
            } else {
                $('#ajaxViewProjects').html(data);
            }
            var gtyp = getCookie('TASKGROUPBY');
            if (chk_hash == 'backlog' || chk_hash == 'activesprint') {
                $('.show_all_opt_in_listonly').hide();
            } else if ((gtyp == '' || typeof gtyp == 'undefined' || (gtyp == 'milestone' && chk_hash != 'tasks')) && (chk_hash == 'tasks' || chk_hash == 'timelog' || chk_hash == 'calendar_timelog' || (chk_hash == 'calendar' && (USER_SUB_NOW != '10' || USER_SUB_NOW != '21')))) {
                $('.show_all_opt_in_listonly').show();
            } else if (page == 'mydashboard') {
                $('.show_all_opt_in_listonly').show();
            } else if (page == 'special_mydashoard') {
                $('.show_all_opt_in_listonly').show();
            } else {
                $('.show_all_opt_in_listonly').hide();
            }
        }
    });
}

function caseMenuFileter(value, page, filters, caseid) {
    if (typeof arguments[4] == 'undefined') {
        resetAllFilters('all', 'no_pagerefresh');
    }
    var url = HTTP_ROOT;
    var durl = document.URL;
    var is_dash = durl.match('/dashboard');
    if (is_dash != null && page == "dashboard") {
        casePage = 1;
        $('#caseMenuFilters').val(value);
        if (value == "assigntome") {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        } else if (value == "favourite") {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        } else if (value == "overdue") {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        } else if (value == "delegateto") {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        } else if (value == "highpriority") {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        } else if (value == "cases") {
            ajaxCaseView('case_project');
        } else {
            if ((durl.indexOf('?case=') != -1) && (durl.indexOf('&project=') != -1)) {
                window.location = url + "dashboard?filters=" + value;
            } else {
                ajaxCaseView('case_project');
            }
        }
        strUrl = url + "easycases/";
        var projFil = $('#projFil').val();
    } else {
        if (value) {
            window.location = url + "dashboard?filters=" + value;
        } else {
            window.location = url + "dashboard";
        }
    }
}

function newcategorytab() {
    $('#inner_select_tab').html('');
    openPopup();
    $(".loader_dv").show();
    $(".select_tab").show();
    $.post(HTTP_ROOT + "users/categorytab", function(res) {
        $(".loader_dv").hide();
        $('#inner_select_tab').html(res);
        $.material.init();
    });
}

function savecategorytab() {
    var total_tab_value = 0;
    $('.cattab_cls').each(function() {
        if ($(this).is(':checked')) {
            total_tab_value += parseInt($(this).val());
        }
    });
    $("#btn_cattype").hide();
    $("#tab_ldr").show();
    $.post(HTTP_ROOT + "users/ajax_savecategorytab", {
        'tabvalue': total_tab_value,
        'is_ajaxflag': 1
    }, function(res) {
        if (parseInt(res) === 1) {
            window.location.href = HTTP_ROOT + 'dashboard?filters=cases';
        }
    });
}
$('.ctab_td').hover(function() {
    $(this).css({
        'background': '#EBE8E8'
    });
}, function() {
    $(this).css({
        'background': ''
    });
});

function submitProfile(page) {
    if (typeof page != 'undefined' && page == 'popup') {
        var name1 = $('#profile_name-popup').val().trim();
        var last_name = $('#profile_last_name-popup').val().trim();
        var short_name = $('#short_name-popup').val().trim();
        var email = $('#email-popup').val().trim();
        var phone = 'na';
        $('#address1_popup').val('');
        $('#address2_popup').val('San jose');
        $('#gender_popup').val('o');
    } else {
        var name1 = $('#profile_name').val().trim();
        var last_name = $('#profile_last_name').val().trim();
        var short_name = $('#short_name').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone_num').val().trim();
        $('#address1').val('');
        $('#address2').val('San jose');
        $('#gender').val('o');
    }
    var errMsg;
    var done = 1;
    if (name1 == "") {
        errMsg = _("First Name cannot be left blank!");
        $('#profile_name').focus();
        done = 0;
    } else if (last_name == "") {
        errMsg = _("Last Name cannot be left blank!");
        $('#profile_last_name').focus();
        done = 0;
    } else if (short_name == "") {
        errMsg = _("Short Name cannot be left blank!");
        $('#short_name').focus();
        done = 0;
    } else if (email == "") {
        errMsg = _("Email cannot be left blank!");
        $('#email').focus();
        done = 0;
    } else if (phone != 'na' && phone != '') {
        var phoneREg = /^[0-9\-\(\)\s+]+$/;
        if (!phone.match(phoneREg)) {
            errMsg = _("Invalid phone number!");
            $('#phone_num').focus();
            done = 0;
        }
        phone = phone.replace('-', '').replace('(', '').replace(')', '');
        if (phone.length < 3) {
            errMsg = _("Invalid phone number!");
            $('#phone_num').focus();
            done = 0;
        }
    }
    if (email != "") {
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!email.match(emlRegExpRFC) || email.search(/\.\./) != -1) {
            errMsg = _("Invalid email address!");
            $('#email').focus();
            done = 0;
        }
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        $('#subprof1').show();
        $('#subprof2').hide();
        return false;
    } else {
        $('#subprof1').hide();
        $('#subprof2').show();
    }
}
function checkPassword(password, conformPassword) {
  var stringLength = $.trim(password).length;
    var errMsg;
    var done = 1;
    if ($.trim(password) == "") {
        errMsg = _("Password cannot be left blank!");
        $('#new_password').focus();
        done = 0;
    }else if(stringLength > 24 || stringLength < 8){
        errMsg = _("Password length cannot be more than 24 or less than 8!");
        $('#new_password').focus();
        done = 0;
    }else if ($.trim(conformPassword) == "") {
        errMsg = _("Conform Password cannot be left blank!");
        $('#new_conform_password').focus();
        done = 0;
    }else if ($.trim(password) != $.trim(conformPassword)) {
        errMsg = _("Conform Password not Matching!");
        $('#new_conform_password').focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        $('#subprof1').show();
        $('#subprof2').hide();
        return false;
    } else {
        $('#subprof1').hide();
        $('#subprof2').show();
    }
}
function cancelProfile(url) {
    window.location.href = url;
}

function checkPasswordMatch(a, b, c, d) {
    var errMsg;
    var done = 1;
    if (d == 0) {
        var pass = $("#" + c).val();
        if (pass.trim() != "") {
            var pass_new = $("#" + a).val();
            var retypr_pass = $("#" + b).val();
            if (pass_new.trim() == "") {
                errMsg = _("Password cannot be  blank!");
                document.getElementById(a).focus();
                done = 0;
            } else if (pass_new.length < 8) {
                errMsg = _("Password should be between 8-30 characters!");
                document.getElementById(a).focus();
                done = 0;
            } else if (pass_new.length > 30) {
                errMsg = _("Password should be between 8-30 characters!");
                document.getElementById(a).focus();
                done = 0;
            } else if (retypr_pass.trim() == "") {
                errMsg = _("Confirm Password cannot be  blank!");
                document.getElementById(b).focus();
                done = 0;
            } else if (retypr_pass.trim() != pass_new.trim()) {
                errMsg = _("Passwords do not match!");
                document.getElementById(b).focus();
                done = 0;
            } else {
                $('#subprof2').show();
                $('#subprof1').hide();
            }
        } else {
            errMsg = _("Old Password cannot be left blank!");
            document.getElementById(c).focus();
            done = 0;
        }
    } else {
        var pass_new = $("#" + a).val();
        var retypr_pass = $("#" + b).val();
        if (pass_new.trim() == "") {
            errMsg = _("Password cannot be  blank!");
            document.getElementById(a).focus();
            done = 0;
        } else if (pass_new.length < 8) {
            errMsg = _("Password should be between 8-30 characters!");
            document.getElementById(a).focus();
            done = 0;
        } else if (pass_new.length > 30) {
            errMsg = _("Password should be between 8-30 characters!");
            document.getElementById(a).focus();
            done = 0;
        } else if (retypr_pass.trim() == "") {
            errMsg = _("Confirm Password cannot be  blank!");
            document.getElementById(b).focus();
            done = 0;
        } else if (retypr_pass.trim() != pass_new.trim()) {
            errMsg = _("Passwords do not match!");
            document.getElementById(b).focus();
            done = 0;
        } else {
            $('#subprof2').show();
            $('#subprof1').hide();
        }
    }
    if (done == 0) {
        showTopErrSucc('error', errMsg);
        $('#subprof2').hide();
        $('#subprof1').show();
        return false;
    }
}

function checkCsrfToken(formid) {
    $('#subprof2').show();
    $('#subprof1').hide();
    $.post(HTTP_ROOT + "users/checkToken", {
        'ajax': 1
    }, function(res) {
        $('.csrftoken').val(res.token);
        $('#' + formid).submit();
    }, 'json');
}

function openProfilePopup(page) {
    if (typeof page == 'undefined') {
        $("#upldphoto").trigger('click');
    } else {
        $("#upldphoto").trigger('click');
    }
}

function loadprofilePopup() {
    if (!$(".edit_usr_pop").is(':visible')) {
        openPopup();
    } else {
        $(".prof_img").addClass('secondaryPopup');
        $(".popup_overlay_2").show();
        $(".prof_img").find('button.cmn_size').removeAttr('data-dismiss');
        $(".prof_img").find('button.close').removeAttr('data-dismiss').attr('onclick', 'profilePopupCancel()');
    }
    $(".prof_img").show();
    $('#up_files_photo').html('');
    $("#actConfirmbtn").hide();
    $("#inactConfirmbtn").show();
}

function showEditDeleteImg(page) {
    if (typeof page == 'undefined') {
        $("#editDeleteImg").show();
    } else {
        $("#editDeleteImg-popup").show();
    }
}

function hideEditDeleteImg(page) {
    if (typeof page == 'undefined') {
        $("#editDeleteImg").hide();
    } else {
        $("#editDeleteImg-popup").hide();
    }
}

function profilePopupCancel() {
    $('#profilephoto').imgAreaSelect({
        hide: true
    });
    $('#up_files_photo').html('');
    if (!$(".edit_usr_pop").is(':visible')) {
        closePopup();
    } else {
        $('.edit_profile_image').hide();
    }
    $(".popup_overlay_2").hide();
}
$(function() {
    $('#upldphoto').change(function() {
        profilePopupClose();
        var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
        if ($.inArray(ext, ["jpg", "jpeg", "png", "gif", "bmp"]) == -1) {
            alert(_("Sorry") + ", '" + ext + "' " + _("file type is not allowed!"));
            this.value = '';
        } else {
            loadprofilePopup();
            $("#inactConfirmbtn").hide();
            $("#actConfirmbtn").show();
            $("#profLoader").show();
        }
    });
    $('#file_upload1').fileUploadUI({
        uploadTable: $('#up_files_photo'),
        downloadTable: $('#up_files_photo'),
        buildUploadRow: function(files, index) {
            var filename = files[index].name;
            if (filename.length > 35) {
                filename = filename.substr(0, 35);
            }
        },
        buildDownloadRow: function(file) {
            if (file.name != "error") {
                if (file.message == "success") {
                    var filesize = file.sizeinkb;
                    if (filesize >= 1024) {
                        filesize = filesize / 1024;
                        filesize = Math.round(filesize * 10) / 10;
                        filesize = filesize + " Mb";
                    } else {
                        filesize = Math.round(filesize * 10) / 10;
                        filesize = filesize + " Kb";
                    }
                    var imgNm = HTTP_ROOT + "files/profile/orig/" + file.filename;
                    $('#up_files_photo').html('<img src="' + imgNm + '" id="profilephoto">');
                    if (!$(".edit_usr_pop").is(':visible'))
                        $("#imgName1").val(file.filename);
                    else
                        $("#imgName1-popup").val(file.filename);
                    $("#profLoader").hide();
                    $('#profilephoto').imgAreaSelect({
                        handles: true,
                        instance: true,
                        x1: 10,
                        y1: 20,
                        x2: 60,
                        y2: 60,
                        fadeSpeed: 500,
                        aspectRatio: '1:1',
                        minHeight: 80,
                        minWidth: 80,
                        maxHeight: 170,
                        maxWidth: 170,
                        onInit: setInfo,
                        onSelectChange: setInfo
                    });
                } else if (file.message == "small size image") {
                    alert(_("The image you tried to upload is too small. It needs to be at least 100 pixels wide.") + "\n" + _("Please try again with a larger image."));
                    $("#profLoader").hide();
                    $("#inactConfirmbtn").show();
                    $("#actConfirmbtn").hide();
                } else if (file.message == "exceed") {
                    alert(_("Error uploading file.") + "\n" + _("Storage usage exceeds by") + " " + file.storageExceeds + " Mb!");
                } else if (file.message == "size") {
                    alert(_("Error uploading file. File size cannot be more then") + " " + fmaxilesize + " Mb!");
                } else if (file.message == "error") {
                    alert(_("Error uploading file. Please try with another file"));
                } else if (file.message == "s3_error") {
                    alert(_("Due to some network problem your file is not uploaded.Please try again after sometime."));
                } else {
                    alert(_("Sorry") + ", " + file.message + " " + _("file type is not allowed!"));
                }
            } else {
                alert(_("Error uploading file. Please try with another file"));
            }
        }
    });
});

function setInfo(i, e) {
    $('#x').val(e.x1);
    $('#y').val(e.y1);
    $('#w').val(e.width);
    $('#h').val(e.height);
}

function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;
    $('#x').val(selection.x1);
    $('#y').val(selection.y1);
    $('#x2').val(selection.x2);
    $('#y2').val(selection.y2);
    $('#w').val(selection.width);
    $('#h').val(selection.height);
}

function profilePopupClose() {
    $('#profilephoto').imgAreaSelect({
        hide: true
    });
    $('#up_files_photo').html('');
    if (!$(".edit_usr_pop").is(':visible')) {
        closePopup();
    }
}

function doneCropImage() {
    var x = $('#x').val();
    var y = $('#y').val();
    var width = $('#w').val();
    var height = $('#h').val();
    if (!$(".edit_usr_pop").is(':visible'))
        var imgName = $("#imgName1").val();
    else
        var imgName = $("#imgName1-popup").val();
    $('#file_confirm_btn_loader').show();
    $('.file_confirm_btn').hide();
    if (width != 0 && height != 0 && imgName.trim() != '') {
        $.post(HTTP_ROOT + "users/done_cropimage", {
            'x-cord': x,
            'y-cord': y,
            'width': width,
            'height': height,
            'imgName': imgName
        }, function(res) {
            if (res) {
                profilePopupClose();
                $("#defaultUserImg").hide();
                $('#profilephoto').imgAreaSelect({
                    hide: true
                });
                if (!$(".edit_usr_pop").is(':visible')) {
                    $("#imgName1").val(res);
                    $("#submit_Profile").trigger('click');
                } else {
                    $("#imgName1-popup").val(res);
                    if (typeof $("#profphoto-popup") != 'undefined') {
                        $("#profphoto-popup").attr('src', HTTP_ROOT + 'files/photos/' + res);
                    } else {
                        $("#defaultUserImg-popup").find('img').attr('src', HTTP_ROOT + 'files/photos/' + res);
                    }
                    $('.editDeleteImg-popup').html('<a title="Edit Profile Image" class="custom-t-type" href="javascript:void(0);" onClick="openProfilePopup(\'popup\')"><i class="material-icons" title="Edit">&#xE254;</i></a></span>\n\
                                <a title="Delete Profile Image"  class="custom-t-type rm" href="javascript:void(0);" onclick="removeImgPopupTmp(\' ' + HTTP_ROOT + 'users/profile/' + res + ' \');"><span> <i class="material-icons" title="Delete">&#xE872;</i> </span></a></div><div class="cb"></div>');
                    profilePopupCancel();
                }
            }
            $('#file_confirm_btn_loader').hide();
            $('.file_confirm_btn').show();
        });
    }
}

function checkuserlogin() {
    setInterval('checkloginstatus()', 5000);
}

function checkloginstatus() {
    if (!getCookie('USER_UNIQ') || !getCookie('USERTYP') || !getCookie('USERTZ')) {
        window.location.href = HTTP_ROOT + 'users/logout/';
    }
}
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "");
}
$(".icon-edit-usr, .icon-grid-edit-usr").click(function(e) {
    var getClickedClass = $(e.currentTarget).attr('class');
    if ($.trim(getClickedClass) == "icon-edit-usr") {
        setSessionStorage('From Project Card View', 'Update Project');
    } else if ($.trim(getClickedClass) == "icon-grid-edit-usr") {
        setSessionStorage('From Project Grid View', 'Update Project');
    }
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    openPopup();
    $(".loader_dv").show();
    $("#inner_prj_edit").hide();
    $(".edt_prj").show();
    $("#header_prj").html(prj_name);
    $.post(HTTP_ROOT + "projects/ajax_edit_project", {
        "pid": prj_id
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_prj_edit').show();
            $('#inner_prj_edit').html(data);
            $.material.init();
            $('.proj_prioty').select2();
            $('.proj_methodology').select2();
            $('.sel_Typ_dp').select2();
            $('.tsk_Typ_dp').select2({
                templateSelection: formatTaskType,
                templateResult: formatTaskType
            });
            $('.status_typ_dp').select2();
            $('.workflow_dp').select2();
            $('textarea').autoGrow().keyup();
        }
    });
});
$('body').on("click", ".icon-grid-edit-usr-ajax", function(e) {
    var getClickedClass = $(e.currentTarget).attr('class');
    if ($.trim(getClickedClass) == "icon-edit-usr") {
        setSessionStorage('From Project Card View', 'Update Project');
    } else if ($.trim(getClickedClass) == "icon-grid-edit-usr-ajax") {
        setSessionStorage('From Project Grid View', 'Update Project');
    }
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    openPopup();
    $(".loader_dv").show();
    $("#inner_prj_edit").hide();
    $(".edt_prj").show();
    $("#header_prj").html(prj_name);
    $.post(HTTP_ROOT + "projects/ajax_edit_project", {
        "pid": prj_id
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_prj_edit').show();
            $('#inner_prj_edit').html(data);
            $.material.init();
            $('.proj_prioty').select2();
            $('.proj_methodology').select2();
            $('.sel_Typ_dp').select2();
            $('.tsk_Typ_dp').select2({
                templateSelection: formatTaskType,
                templateResult: formatTaskType
            });
            $('.status_typ_dp').select2();
            $('.workflow_dp').select2();
            $('textarea').autoGrow().keyup();
        }
    });
});

function inlineUserEdit() {
    var prj_id = $('.inline-edit-usr').attr('data-prj-id');
    var prj_name = $('.inline-edit-usr').attr('data-prj-name');
    openPopup();
    $(".edt_prj").show();
    $("#header_prj").html(prj_name);
    $('#inner_prj_edit').hide();
    $.post(HTTP_ROOT + "projects/ajax_edit_project", {
        "pid": prj_id
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_prj_edit').show();
            $('#inner_prj_edit').html(data);
            $('textarea').autoGrow().keyup();
            $.material.init();
        }
    });
}

function viewTemplateCases() {
    var temp_id = $('#sel_Typ').val();
    var url = HTTP_ROOT + "templates/view_templates/" + temp_id;
    var win = window.open(url, '_blank');
    win.focus();
}

function EditTaskTemp(tempId, tasktempname, pagenum) {
    openPopup();
    $(".edt_task_temp").show();
    $("#header_task_temp").html(_('Edit Task Template'));
    $('#inner_task_temp_edit').hide();
    $(".loader_dv_task").show();
    $.post(HTTP_ROOT + "templates/ajax_add_task_template", {
        "tempId": tempId,
        "pagenum": pagenum
    }, function(data) {
        if (data) {
            $(".loader_dv_task").hide();
            $("#tasktemptitle_edit").val(data['CaseTemplate']['name']).keyup();
            $("#desc_edit").val(data['CaseTemplate']['description']);
            $("#hid_edit_id").val(data['CaseTemplate']['id']);
            $("#hid_edit_user_id").val(data['CaseTemplate']['user_id']);
            $("#hid_edit_company_id").val(data['CaseTemplate']['company_id']);
            $("#hid_edit_page_num").val(data['CaseTemplate']['pageNum']);
            $('#inner_task_temp_edit').show();
            $(".edt_task_temp").show();
            $.material.init();
            tinymce.get('desc_edit').setContent(data['CaseTemplate']['description']);
            trim(data['CaseTemplate']['name']) != '' && trim(strip_tags(data['CaseTemplate']['description'])) != '' ? $("#btn_task_template_edit").removeClass('loginactive') : $("#btn_task_template_edit").addClass('loginactive');
        }
    }, 'json');
}

function submitProject(proj, shrt, esthrid, startid, endid) {
    $("#edit_prj_err_msg").html('');
    var done = 1;
    var msg = "";
    var proj_name = $('#' + proj).val().trim();
    var short_name = $('#' + shrt).val().trim();
    var updclickeventRefer = sessionStorage.getItem('SessionStorageReferValue');
    $("#upd_project_click_refer").val(updclickeventRefer);
    if (proj_name == "") {
        msg = _("'Project Name' cannot be left blank!");
        $('#' + proj).focus();
        done = 0;
    } else if (proj_name.match(/[~`<>,;\+\\]+/)) {
        msg = _("'Project Name' only accept Alphabets, Numbers, Special Characters except(~, `, <, >, \\, +, ;, ,)!");
        $('#' + proj).focus();
        done = 0;
    }
    var patern = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
    if (done != 0) {
        if (short_name == "") {
            msg = _("'Short Name' cannot be left blank!");
            $('#' + shrt).focus();
            done = 0;
        } else if (short_name.match(/[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/)) {
            msg = _("'Short Name' must not contain special characters!");
            $('#' + shrt).focus();
            done = 0;
        } else {
            var x = short_name.substr(-1);
        }
    }
    if ($('#prj_sts').val() < 1) {
        done = 0;
        msg = _("Select a valid project status!");
    }
    var start = $('#' + startid).val();
    var end = $('#' + endid).val();
    start = new Date(start);
    end = new Date(end);
    if (end.getTime() < start.getTime()) {
        msg = _("You can not enter end date less than start date !");
        $('#err_msg').show();
        $('#edit_prj_err_msg').html(msg);
        $('#edit_ProjEndDate').focus();
        $('#settingldr').hide();
        return false;
    }
    if (done == 0) {
        $('#edit_prj_err_msg').html(msg).show();
        return false;
    }
    var uniqid = $("#uniqid").val();
    if ($.trim($('#proj_client' + uniqid + ' option:selected').attr('data-cust')) == 'new') {
        var c_name = $.trim($('#proj_cust_fname' + uniqid).val());
        var c_email = $.trim($('#proj_cust_email' + uniqid).val());
        var c_curncy = $.trim($('#proj_currency' + uniqid).val());
        errMsg = '';
        err = false;
        if (c_name != '' || c_email != '') {
            var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (c_name == '') {
                $('#proj_cust_fname').focus();
                errMsg = _('Please enter customer name.');
                err = true;
            } else if (c_email == '') {
                $('#proj_cust_email').focus();
                errMsg = _('Please enter email address.');
                err = true;
            } else if (!c_email.match(emlRegExpRFC) || c_email.search(/\.\./) != -1) {
                $('#proj_cust_email').focus();
                errMsg = _('Please enter proper email address.');
                err = true;
            } else if (c_curncy == '') {
                $('#proj_currency').focus();
                errMsg = _('Please select currency.');
                err = true;
            }
            if (err == true) {
                showTopErrSucc('error', errMsg);
                return false;
            }
        }
    }
    $("#btn").css({
        "visibility": "hidden"
    });
    $("#settingldr").css({
        "display": "block"
    });
    $(".project_edit_button").hide();
    $.post(HTTP_ROOT + "projects/ajax_check_project_exists", {
        "uniqid": uniqid,
        "name": escape($('#' + proj).val().trim()),
        "shortname": escape($('#' + shrt).val().trim())
    }, function(data) {
        if (data.status == "Project") {
            $("#btn").css({
                "visibility": "visible"
            });
            $("#btn").show();
            $("#settingldr").hide();
            msg = _("'Project Name' is already exists!");
            $('#edit_prj_err_msg').html(msg);
            $('#' + proj).focus();
            $(".project_edit_button").show();
            return false;
        } else if (data.status == "ShortName") {
            $("#btn").css({
                "visibility": "visible"
            });
            $("#btn").show();
            $("#settingldr").hide();
            msg = "'" + _("Project Short Name") + " " + short_name + "' " + _("is already exists!");
            $('#edit_prj_err_msg').html(msg);
            $('#' + shrt).focus();
            $(".project_edit_button").show();
            return false;
        } else {
            $("#pg").val($(".button_page").html());
            $("#validateprj").val('1');
            var chk_hash = getHash();
            if (chk_hash == 'overview') {
                $("#ProjectAjaxEditProjectForm").append('<input type="hidden" name="viewpage" value="overview" />');
            }
            document.projsettings.submit();
            return true;
        }
    }, 'json');
    return false;
}
$(".del_prj").click(function() {
    var prj_unq_id = $(this).attr('data-prj-id');
    var prj_nm = $(this).attr('data-prj-name');
    if (confirm(_("Are you sure to delete project") + " '" + prj_nm + "'")) {
        if (confirm(_("All the Tasks, Files associated with") + " '" + prj_nm + "' " + _("will be deleted permanently."))) {
            var pg = $(".button_page").html();
            var loc = HTTP_ROOT + "projects/deleteprojects/" + prj_unq_id;
            if (parseInt(pg) > 1) {
                loc = loc + "/" + pg;
            }
            window.location = loc;
        } else {
            return false;
        }
    } else {
        return false;
    }
});
$(".enbl_prj").click(function() {
    var ref = window.location.href;
    ref = ref.split('projects/');
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    if ($(this).attr('data-view')) {
        var view = $(this).attr('data-view');
    }
    var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' " + _("as not complete ?"));
    if (conf == true) {
        var pg = $(".button_page").html();
        var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&action=activate';
        if (parseInt(pg) > 1) {
            loc = loc + "&pg=" + pg;
        }
        if (view) {
            loc = loc + "&view=" + view;
        }
        window.location = loc + "&req_uri=" + ref[1];
    } else {
        return false;
    }
});
$(".disbl_prj").click(function() {
    var ref = window.location.href;
    ref = ref.split('projects/');
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' " + _("as completed ?"));
    if (conf == true) {
        var pg = $(".button_page").html();
        var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&action=deactivate';
        if (parseInt(pg) > 1) {
            loc = loc + "&pg=" + pg;
        }
        window.location = loc + "&req_uri=" + ref[1];
    } else {
        return false;
    }
});
$(".change_prj_status").click(function() {
    var ref = window.location.href;
    ref = ref.split('projects/');
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    var status_name = $(this).attr('data-prj-status-name');
    var status_id = $(this).attr('data-prj-status-id');
    var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' as " + status_name);
    if (conf == true) {
        var pg = $(".button_page").html();
        var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&status_change=' + status_id;
        if (parseInt(pg) > 1) {
            loc = loc + "&pg=" + pg;
        }
        window.location = loc + "&req_uri=" + ref[1];
    } else {
        return false;
    }
});
$(".icon-remove-usr, .icon-grid-remove-usr").click(function(event) {
    event.stopPropagation();
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    openPopup();
    $("#popupload2").show();
    $(".rmv_prj_usr").show();
    $("#header_prj_usr_rmv").html(prj_name);
    $('#inner_prj_usr_rmv').hide();
    $('.rmv-btn').hide();
    $('#rmname').val('');
    $('#remusersrch').hide();
    $.post(HTTP_ROOT + "projects/user_listing", {
        "project_id": prj_id
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_prj_usr_rmv').show();
            $('#inner_prj_usr_rmv').html(data);
            if (parseInt($("#is_users").val())) {
                $('.rmv-btn').show();
                $('#remusersrch').show();
                enableAddUsrBtns('.rem-usr-prj');
            }
            $("#popupload2").hide();
            $.material.init();
            $('[rel="tooltip"]').tipsy({
                gravity: 's',
                fade: true
            });
        }
    });
});
$("body").on("click", ".icon-grid-remove-usr-ajax", function(event) {
    event.stopPropagation();
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    openPopup();
    $("#popupload2").show();
    $(".rmv_prj_usr").show();
    $("#header_prj_usr_rmv").html(prj_name);
    $('#inner_prj_usr_rmv').hide();
    $('.rmv-btn').hide();
    $('#rmname').val('');
    $('#remusersrch').hide();
    $.post(HTTP_ROOT + "projects/user_listing", {
        "project_id": prj_id
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_prj_usr_rmv').show();
            $('#inner_prj_usr_rmv').html(data);
            if (parseInt($("#is_users").val())) {
                $('.rmv-btn').show();
                $('#remusersrch').show();
                enableAddUsrBtns('.rem-usr-prj');
            }
            $("#popupload2").hide();
            $.material.init();
            $('[rel="tooltip"]').tipsy({
                gravity: 's',
                fade: true
            });
        }
    });
});

function removeusers() {
    var done = 0;
    var done_cnt = 0;
    var user_name = '';
    let user_arr = [];
    let param_data = {};
    var remove_prj_name = $("#header_prj_usr_rmv").text();
    $('#inner_prj_usr_rmv input:checked').each(function() {
        if ($(this).attr('id') !== 'remcheckAll') {
            if (typeof $(this).attr('data-usr-name') != 'undefined') {
                user_name = user_name + ", " + $(this).attr('data-usr-name');
                done++;
                done_cnt++;
            }
        }
    });
    user_name = user_name.replace(', ', '');
    if (done) {
        if (confirm(_("Are you sure you want to remove") + " '" + user_name + "' " + _("from") + " '" + remove_prj_name + "'?")) {
            var project_id = $('#pjid').val();
            var dcrs_cnt = 1;
            $('#inner_prj_usr_rmv input:checked').each(function() {
                if ($(this).attr('id') !== 'remcheckAll' && $(this).attr('disabled') != 'disabled') {
                    var listid = $(this).attr('id');
                    var userid = $(this).attr('value');
                    var listing = $("#" + listid).parents("tr").attr('id');
                    $("#" + listing).fadeOut(1000);
                    $("#" + listid).attr("checked", false);
                    var is_invite = '';
                    if ($("#" + listing).hasClass("invited-cls")) {
                        is_invite = "InvitedUser";
                        dcrs_cnt = 0;
                    }
                    if ($("#" + listing).hasClass("disable-cls")) {
                        dcrs_cnt = 0;
                    }
                    if (!isNaN(parseInt(userid))) {
                        user_arr.push(parseInt(userid));
                    }
                    var strURL = HTTP_ROOT + 'projects/user_listing';
                    $.post(strURL, {
                        "InvitedUser": is_invite,
                        "userid": userid,
                        "project_id": project_id
                    }, function(data) {
                        if (data) {
                            $("#" + listing).remove();
                        }
                        enableAddUsrBtns('.rem-usr-prj');
                    });
                }
            });
            param_data['user_arr'] = user_arr;
            param_data['project_id'] = project_id;
            param_data['field'] = 'id';
            if (parseInt(dcrs_cnt)) {
                var total_user = parseInt($("#tot_prjusers" + project_id).text()) - done_cnt;
                total_user = (total_user == -1) ? 0 : total_user;
                $("#tot_prjusers" + project_id).html(total_user);
                if (parseInt(total_user) == 0) {
                    if (parseInt(total_user) == 0 && SES_TYPE == 1) {
                        $("#remove" + project_id).hide();
                    }
                    $("#ajax_remove" + project_id).hide();
                    closePopup();
                }
            }
            showTopErrSucc('success', _("User(s)") + " '" + user_name + "' " + _("removed from") + " '" + remove_prj_name + "'");
            assign_cases_user(param_data);
        } else {
            return false;
        }
    }
}

function assign_cases_user(param_data) {
    $.ajax({
        url: `${HTTP_ROOT}projects/ajaxcheckUserTasks`,
        type: 'POST',
        dataType: 'json',
        data: param_data,
    }).done(function(res) {
        if (res.status) {} else {
            openPopup();
            $(".ass_task_user").show();
            $('#inner_usr_case_add').hide();
            $('#pop_up_assign_case_user_label').hide();
            $('.add-prj-btn').hide();
            $('#inner_usr_case_add').html('');
            $(".popup_bg").css({
                "width": '850px'
            });
            $(".popup_form").css({
                "margin-top": "6px"
            });
            $('#inner_usr_case_add').hide();
            $.ajax({
                url: `${HTTP_ROOT}projects/ajaxGetProjUsers`,
                type: 'POST',
                dataType: 'html',
                data: {
                    param_data: param_data,
                    user_data: res
                },
            }).done(function(res_data) {
                $(".loader_dv").hide();
                $('#inner_usr_case_add').show();
                $('#inner_usr_case_add').html(res_data);
                $('#pop_up_assign_case_user_label').html('');
                $('#pop_up_assign_case_user_label').html($('#hid_ext_use_lbl').html());
                $('#pop_up_assign_case_user_label').css('display', 'block');
                $('.add-prj-btn').show();
                $.material.init();
            });
        }
    });
}

function selectremuserAll(arg, i) {
    if (parseInt(arg)) {
        if ($('#remcheckAll').is(":checked")) {
            $(".rem-usr-prj").prop("checked", "checked");
        } else {
            $(".rem-usr-prj").prop("checked", false);
        }
    } else {
        var listing = "listing" + i;
        if ($('.rem-usr-prj:checked').length == $('.rem-usr-prj').length) {
            $("#remcheckAll").prop("checked", "checked");
        } else {
            $("#remcheckAll").prop("checked", false);
        }
    }
    enableAddUsrBtns('.rem-usr-prj');
}

function searchremuserkey() {
    var name = $('#rmname').val();
    var project_id = $('#pjid').val();
    if (project_id) {
        var strURL1 = HTTP_ROOT + 'projects/user_listing';
        $('#popupload2').css({
            "top": "48px"
        });
        $('#popupload2').show();
        $.post(strURL1, {
            "project_id": project_id,
            "name": name
        }, function(data) {
            if (data) {
                $('#popupload2').hide();
                $('#inner_prj_usr_rmv').html(data);
                enableAddUsrBtns('.rem-usr-prj');
                $("#popupload2").hide();
                $.material.init();
            }
        });
    }
}

function setemail(obj, type, id, type2) {
    $("#popupload2").show();
    $(obj).prop('disabled', 'disabled');
    $(obj).closest('.checkedonofflbl').find('.checkedonoffdisplay').html($(obj).is(':checked') ? "ON" : "OFF");
    $.post(HTTP_ROOT + 'projects/update_email_notification', {
        "type": type,
        "projectuser_id": id
    }, function(data) {
        $(obj).prop('disabled', false);
        $("#popupload2").hide();
        if (data) {}
    });
    $(obj).parent("li").siblings("li").removeClass(type2);
    $(obj).parent("li").addClass(type);
}
$(".icon-add-usr").click(function(event) {
    event.stopPropagation();
    var prj_id = $(this).attr('data-prj-uid');
    var prj_name = $(this).attr('data-prj-name');
    $('#pop_up_add_user_label').hide();
    setSessionStorage('From Project Card View', 'Add User to Project');
    addUsersToProject(prj_id, prj_name);
});
$(".icon-grid-add-usr").on("click", function(event) {
    event.stopPropagation();
    var prj_id = $(this).attr('data-prj-uid');
    var prj_name = $(this).attr('data-prj-name');
    $('#pop_up_add_user_label').hide();
    setSessionStorage('From Project Grid View', 'Add User to Project');
    addUsersToProject(prj_id, prj_name);
});

function add_user(prj_id, prj_name) {
    openPopup();
    $("#userList").html('');
    hduserid = new Array();
    $(".add_prj_usr").show();
    $("#header_prj_usr_add").html(prj_name);
    $('#inner_prj_usr_add').hide();
    $('.add-usr-btn').hide();
    $("#name").val('');
    $('#usersrch').hide();
    $.post(HTTP_ROOT + "projects/add_user", {
        "pjid": prj_id,
        "pjname": prj_name
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#usersrch').show();
            $('#inner_prj_usr_add').show();
            $('#pop_up_add_user_label').show();
            $('#inner_prj_usr_add').html(data);
            $('.add-usr-btn').show();
            enableAddUsrBtns('.ad-usr-prj');
        }
    });
}
$(".create_project_temp").click(function() {
    openPopup();
    $("#projtemptitle").val('');
    $("#projtemptitle").focus();
    $("#project_temp_err").html('');
    $(".project_temp_popup").show();
});
$(".create_task_temp").click(function() {
    openPopup();
    $("#task_temp_err").html('');
    $("#tasktemptitle").val('').keyup();
    $("#desc").val('');
    $("#tasktemptitle").focus();
    $(".task_temp_popup").show();
    $.material.init();
    tinymce.get('desc').setContent('');
});

function closeemailvarify(id) {
    createCookie('email_varify', 123 + id, 365, DOMAIN_COOKIE);
    $(".fixed-n-bar").hide();
    $('body').removeClass("open_hellobar");
}

function resendemail() {
    $("#varifybtn").hide();
    $("#varifyloader").show();
    var url = HTTP_ROOT + "users/resend_confemail";
    $.post(url, function(data) {
        $("#varifyloader").hide();
        $("#varifybtn").show();
        $("#varifybtn").text(_("Confirmation mail has been sent"));
    });
}
$(function() {
    if (!$(".fixed-n-bar").length) {} else {
        var varifydiv = getCookie('email_varify');
        if (!varifydiv) {
            $(".fixed-n-bar").show();
            $('body').addClass("open_hellobar");
        } else if (varifydiv == 123 + SES_ID) {
            $(".fixed-n-bar").hide();
            $('body').removeClass("open_hellobar");
        } else {
            $(".fixed-n-bar").show();
            $('body').addClass("open_hellobar");
        }
    }
});

function searchListWithInt(type, int) {
    if (_searchInterval) {
        clearInterval(_searchInterval);
    }
    if (!int) {
        int = 1000;
    }
    _searchInterval = setTimeout(function() {
        if (type == 'searchuser') {
            searchuserkey();
        } else if (type == 'searchuserrem') {
            searchremuserkey();
        } else if (type == 'searchproj') {
            searchprojkey();
        } else if (type == 'searchprojrem') {
            searchremprjkey();
        }
    }, int);
}

function searchuserkey() {
    var name = $('#name').val();
    var project_id = '';
    try {
        var project_id = $('#projectId').val();
        var pjname = $('#project_name').val();
        var cntmng = $('#cntmng').val();
    } catch (e) {}
    var uuid = '';
    if (hduserid != '') {
        uuid = hduserid.join(',');
    }
    if (project_id) {
        var strURL1 = HTTP_ROOT + 'projects/add_user';
        $("#popupload1").show();
        $.post(strURL1, {
            "pjname": pjname,
            "pjid": project_id,
            "name": name,
            "cntmng": cntmng,
            "choosen_user_ids": uuid
        }, function(data) {
            if (data) {
                $('#inner_prj_usr_add').html(data);
                $("#popupload1").hide();
                $("#popupContactClose, .c_btn").click(function() {
                    disablePopup();
                });
                enableAddUsrBtns('.ad-usr-prj');
            }
        });
    }
}

function assignuser(el) {
    var userid = new Array();
    var done = 0;
    var cntmng = $('#cntmng').val();
    var page_name = $('#pagename').val();
    userid = hduserid;
    if (hduserid.length != 0) {
        done++;
    }
    if (done) {
        $(".chkbx_cur").prop("disabled", true);
        var tot = userid.length;
        var pjid = $('#projectId').val();
        var pjname = $('#project_name').val();
        var strURL = HTTP_ROOT + 'projects/assign_userall';
        $('#confirmbtn').hide();
        $('#userloader').show();
        $.post(strURL, {
            "userid": userid,
            "pjid": pjid
        }, function(data) {
            if (data == "success") {
                var total_user = parseInt(userid.length) + parseInt($("#tot_prjusers" + pjid).text());
                $("#tot_prjusers" + pjid).html(total_user);
                $('#userloader').hide();
                $('#confirmbtn').show();
                if (parseInt(total_user) > 0) {
                    $("#remove" + pjid).hide();
                    $("#ajax_remove" + pjid).show();
                }
                $("#userList").html('');
                hduserid = new Array();
                showTopErrSucc('success', tot + ' ' + _('User(s) added successfully'));
                if (el && el.id == "confirmuserbut") {
                    $('#name').val('');
                    var strURL1 = HTTP_ROOT + 'projects/add_user';
                    $("#popupload").show();
                    $.post(strURL1, {
                        "pjid": pjid,
                        "pjname": pjname,
                        "cntmng": cntmng
                    }, function(data) {
                        if (data) {
                            $("#popupload").hide();
                            $('#inner_prj_usr_add').html(data);
                            if (page_name == 'dashboard') {
                                ajaxCaseView();
                            }
                            enableAddUsrBtns('.ad-usr-prj');
                        }
                    });
                } else {
                    closePopup();
                    if (page_name == 'onbording') {
                        window.location.reload();
                    }
                }
            }
        });
    }
}
var hduserid = new Array();

function selectuserAll(arg, i, usernm) {
    if (parseInt(arg)) {
        if ($('#checkAll').is(":checked")) {
            $(".ad-usr-prj").attr("checked", "checked");
            $("#userList").html('');
            $('#inner_prj_usr_add input:checked').each(function() {
                if ($(this).attr('id') !== 'checkAll') {
                    var id = $(this).attr('value');
                    var userArr = id.split('@@|@@');
                    var user_id = userArr[0];
                    var user_name = decodeURIComponent(userArr[1].replace(/\+/g, ' '));
                    var exstId = $("#userList").find('li[id="' + user_id + '"]').length;
                    if (exstId == 0) {
                        $("#userList").append('<li class="bit-box instant_select_user" rel="7" id="' + user_id + '">' + user_name + '<a class="closebutton" id="close' + user_id + '" href="javascript:void(0);" onclick="removeUserName(\'' + user_id + '\',\'' + $(this).attr('id') + '\');"></a></li>');
                        hduserid.push(user_id);
                    }
                }
            });
            $('#checkAll').hide();
            $("[id^='listing']").hide('slow');
        } else {
            $("[id^='listing']").show('slow');
            $('#checkAll').show();
            $(".ad-usr-prj").attr("checked", false);
            hduserid = new Array;
            $("#userList").html('');
        }
    } else {
        $('#listing' + i).hide('slow');
        var listing = "listing" + i;
        $('.no-extuser_tr').hide();
        if ($('.ad-usr-prj:checked').length == $('.ad-usr-prj').length) {
            $("#checkAll").attr("checked", "checked");
            $("#checkAll").hide();
            $('#inner_prj_usr_add input:checked').each(function() {
                if ($(this).attr('id') !== 'checkAll') {
                    var id = $(this).attr('value');
                    var userArr = id.split('@@|@@');
                    var user_id = userArr[0];
                    var user_name = decodeURIComponent(userArr[1].replace(/\+/g, ' '));
                    var exstId = $("#userList").find('li[id="' + user_id + '"]').length;
                    if (exstId == 0) {
                        $("#userList").append('<li class="bit-box instant_select_user" rel="7" id="' + user_id + '">' + user_name + '<a class="closebutton" id="close' + user_id + '" href="javascript:void(0);" onclick="removeUserName(\'' + user_id + '\',\'' + $(this).attr('id') + '\');"></a></li>');
                        hduserid.push(user_id);
                    }
                }
            });
        } else {
            var id = $("#actionChk" + i).val();
            var userArr = id.split('@@|@@');
            var user_id = userArr[0];
            var user_name = decodeURIComponent(userArr[1].replace(/\+/g, ' '));
            $("#checkAll").attr("checked", false);
            $('#checkAll').show();
            if ($('#actionChk' + i).is(":checked")) {
                if ($("#actionChk" + i).is(":checked")) {
                    var exstId = $("#userList").find('li[id="' + user_id + '"]').length;
                    if (exstId == 0) {
                        $("#userList").append('<li class="bit-box instant_select_user" rel="7" id="' + user_id + '">' + user_name + '<a class="closebutton" id="close' + user_id + '" href="javascript:void(0);" onclick="removeUserName(\'' + user_id + '\',\'' + "actionChk" + i + '\');"></a></li>');
                        hduserid.push(user_id);
                    }
                } else {
                    $('#listing' + i).show('slow');
                    removeUserName(user_id, "actionChk" + i);
                }
            } else {
                $('#listing' + i).show('slow');
                removeUserName(user_id, "actionChk" + i);
            }
        }
    }
    enableAddUsrBtns('.ad-usr-prj');
}

function getPage() {
    var type = "tasks";
    urlHash = getHash();
    if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
        type = "projects";
    } else if (CONTROLLER == 'Defects' && PAGE_NAME == 'defect') {
        type = "defect";
    } else if (CONTROLLER == 'users' && PAGE_NAME == 'manage') {
        type = "users";
    } else if (urlHash == "files") {
        type = "files";
    } else if (urlHash == "taskgroup") {
        type = "taskgroup";
    } else if (urlHash == "milestonelist" || urlHash == 'milestone') {
        type = "milestones";
    } else if (urlHash.substring(0, 6) == 'kanban' || urlHash == 'kanban') {
        type = "kanban";
    } else if (urlHash == 'backlog') {
        type = "backlog";
    } else if (urlHash == 'activesprint') {
        type = "activesprint";
    } else if (urlHash == 'taskgroups') {
        type = "taskgroups";
    }
    return type;
}
var globalTimeout = null;
var globalCount = 0;
var focusedRow = null;

function ajaxCaseSearch() {
    var srch = $("#case_search").val();
    srch = srch.trim();
    if (srch == "") {
        $('#ajax_search').show();
        return false;
    } else {
        $('#ajax_search').show();
    }
    casePage = 1;
    $('#closesrch').hide();
    var pjuniq = $('#projFil').val();
    var page = getPage();
    var url = HTTP_ROOT + "easycases/";
    $.post(url + "ajax_search", {
        srch: srch,
        page: page,
        pjuniq: pjuniq
    }, function(data) {
        $('#srch_load1').hide();
        clearSearchvis();
        if (data) {
            $('#ajax_search').html(data);
            $('#srch_load1').hide();
            $('#closesrch').hide();
            globalTimeout = null;
        }
    });
}

function ajaxCaseSearchInner() {
    var srch = $("#inner-search").val();
    srch = srch.trim();
    var cur_page = getPage();
    if (cur_page == "tasks") {
        $('#clear_close_icon').hide();
    }
    if (srch == "") {
        $('#ajax_inner_search').show();
        return false;
    } else {
        $('#ajax_inner_search').show();
    }
    casePage = 1;
    var pjuniq = $('#projFil').val();
    var page = getPage();
    var url = HTTP_ROOT + "easycases/";
    $.post(url + "ajax_search", {
        srch: srch,
        page: page,
        pjuniq: pjuniq
    }, function(data) {
        $('#srch_inner_load1').hide();
        clearSearchvis();
        if (data) {
            $('#ajax_inner_search').html(data);
            $('#srch_inner_load1').hide();
            globalTimeout = null;
        }
    });
}

function clearSearchvis() {
    var srch = $("#case_search").val();
    var cur_page = getPage();
    srch = srch.trim();
    var innr_srch = $('#inner-search').val();
    if (srch) {
        $('#srch_load1').hide();
        $('#srch_remv').show();
    } else {
        $('#srch_remv').hide();
    }
    if (!$("#case_search").is(':visible')) {
        $('#srch_remv').hide();
    }
    if (typeof innr_srch !== "undefined") {
        innr_srch = innr_srch.trim();
        if (cur_page == "tasks" || cur_page == "taskgroup") {
            if (innr_srch) {
                $('#srch_inner_load1').hide();
                $('#clear_close_icon').show();
            } else {
                $('#clear_close_icon').hide();
            }
        }
    }
}

function clearSearch(type) {
    var cur_page = getPage();
    $("#case_search").val('');
    $('#inner-search').val('');
    if (!(localStorage.getItem("SEARCH") === null)) {
        common_reset_filter("search", "");
    }
    if (type == "outer") {
        $('#ajax_search').hide();
        $('#ajax_search').html('');
    }
    if (type == "inner") {
        $('#ajax_inner_search').hide();
        $('#ajax_inner_search').html('');
    }
    clearSearchvis();
}

function ajaxCaseSearchInnerBklog() {
    var srch = $("#inner-search-backlog").val();
    srch = srch.trim();
    if (srch == "") {
        $('#ajax_inner_search-backlog').show();
        return false;
    } else {
        $('#ajax_inner_search-backlog').show();
    }
    casePage = 1;
    var pjuniq = $('#projFil').val();
    var page = getPage();
    var url = HTTP_ROOT + "easycases/";
    $.post(url + "ajax_search", {
        srch: srch,
        page: page,
        pjuniq: pjuniq
    }, function(data) {
        $('#srch_inner_load1-backlog').hide();
        if (data) {
            $('#ajax_inner_search-backlog').html(data);
            $('#srch_inner_load1-backlog').hide();
            globalTimeout = null;
        }
    });
}

function ajaxCaseSearchInnerSprint() {
    var srch = $("#inner-search-sprint").val();
    srch = srch.trim();
    if (srch == "") {
        $('#ajax_inner_search-sprint').show();
        return false;
    } else {
        $('#ajax_inner_search-sprint').show();
    }
    casePage = 1;
    var pjuniq = $('#projFil').val();
    var page = getPage();
    var url = HTTP_ROOT + "easycases/";
    $.post(url + "ajax_search", {
        srch: srch,
        page: page,
        pjuniq: pjuniq
    }, function(data) {
        $('#srch_inner_load1-sprint').hide();
        if (data) {
            $('#ajax_inner_search-sprint').html(data);
            $('#srch_inner_load1-sprint').hide();
            globalTimeout = null;
        }
    });
}

function searchProject(role, uniq_id, proj_srch) {
    $("#ajax_search").hide();
    if (proj_srch) {
        window.location = HTTP_ROOT + 'projects/manage/?proj_srch=' + proj_srch;
    } else if (uniq_id) {
        window.location = HTTP_ROOT + 'projects/manage/' + role + '?project=' + uniq_id;
    }
}

function searchDefectSrchBr(role, uniq_id) {
    $("#ajax_search").hide();
    if (uniq_id) {
        window.location = HTTP_ROOT + 'defect-details?uniq_id=' + uniq_id;
    }
}

function searchUser(role, uniq_id, user_srch) {
    $("#ajax_search").hide();
    if (user_srch) {
        window.location = HTTP_ROOT + 'users/manage/?role=all&user_srch=' + user_srch;
    } else if (uniq_id) {
        window.location = HTTP_ROOT + 'users/manage/?role=' + role + '&user=' + uniq_id;
    }
}

function searchTasks(caseno, uniq_id) {
    var url = HTTP_ROOT;
    $("#ajax_search").hide();
    $("#case_search").val("");
    if (caseno.trim() != "") {
        easycase.ajaxCaseDetails(uniq_id, 'case', 0, 'popup');
    } else if (CONTROLLER == "Defects" && PAGE_NAME == "defect") {
        window.location = url + 'defect-details/' + uniq_id;
    } else {
        $('#case_search').focus();
    }
}

function searchMilestones(id, uniq_id) {
    var url = HTTP_ROOT;
    $("#ajax_search").hide();
    $("#case_search").val("");
    if (id.trim() != "") {
        window.location = url + 'dashboard#taskgroup/' + uniq_id;
    } else {
        $('#case_search').focus();
    }
}

function searchFile(file_id, uniq_id, file_srch) {
    $("#ajax_search").hide();
    $("#case_search").val("");
    if (uniq_id.trim() != "") {
        var projFil = uniq_id.trim();
    } else {
        var projFil = $('#projFil').val();
    }
    var strURL = HTTP_ROOT + "easycases/";
    casePage = 1;
    $('#caseLoader').show();
    var projIsChange = $('#projIsChange').val();
    var fileUrl = strURL + "case_files";
    search_key = file_srch;
    $.post(fileUrl, {
        "projFil": projFil,
        "projIsChange": projIsChange,
        "casePage": casePage,
        "caseFileId": file_id,
        "file_srch": search_key
    }, function(res) {
        if (res) {
            $('#srch_load1').hide();
            $('#caseLoader').hide();
            $("#caseFileDv").show();
            var params = parseUrlHash(urlHash);
            if (params[0] != "files") {
                parent.location.hash = "files";
            }
            $("#caseFileDv").find('#files_content_block').html(tmpl("case_files_tmpl", res));
            bindPrettyview("prettyImage");
            scrollPageTop($("#caseFileDv"));
        }
        loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
            "projUniq": uniq_id,
            "pageload": 0,
            "page": "dashboard"
        });
    });
    remember_filters('ALL_PROJECT', '');
}

function searchMilestone(file_id, uniq_id, file_srch, isActive) {
    if (!file_srch) {
        return false;
    }
    isActive = (isActive != '') ? isActive : 1;
    $('#search_text').val(file_srch);
    $('#kanban_filtered_items').html('<span title="search">' + file_srch + '</span>')
    $("#ajax_search").hide();
    $("#case_search").val("");
    if (uniq_id.trim() != "") {
        var projFil = uniq_id.trim();
    } else {
        var projFil = $('#projFil').val();
    }
    $('#caseLoader').show();
    if ($('#view_type').val() == 'kanban') {
        var projIsChange = $('#projIsChange').val();
        search_key = file_srch;
        showMilestoneList(3, isActive, '', file_srch);
    } else {
        if ($('#storeIsActivegrid').val() == '' || $('#storeIsActivegrid').val() == 1) {
            ManageMilestoneList(1, file_srch);
        } else {
            ManageMilestoneList('', file_srch);
        }
    }
    $('#srch_load1').hide();
}

function validateSearch() {
    $('#ajax_search').hide();
    var srch = $("#case_search").val();
    $('#srch_load1').hide();
    if (srch.trim() != "") {
        $('#case_srch').val("");
        casePage = 1;
        var url_string = window.location.href;
        if (url_string.search("/dashboard") != -1) {
            if ($('#caseMenuFilters').val() == 'kanban') {
                easycase.showKanbanTaskList('kanban');
            } else {
                ajaxCaseView('case_project');
            }
            remember_filters('SEARCH', escape(srch));
            remember_filters('CASESRCH', '');
        } else {
            window.location = HTTP_ROOT + 'dashboard/?filters=cases&search=' + srch;
        }
    } else {
        $('#case_search').focus();
    }
}

function onKeyPress(e, id) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 13) {
        var srch = $("#" + id).val();
        if (srch.trim() == "") {
            $("#ajax_search").hide();
        } else {
            $("#ajax_search").show();
        }
    }
}

function goForSearch(e, click) {
    var done = 0;
    if (e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode == 13) {
            if (focusedRow !== null) {
                if ($('.ajx-srch-tbl tr').hasClass("selctd-srch")) {
                    var page = getPage();
                    var uniq_id = $(focusedRow).attr("data-id");
                    if (page == "users") {
                        var role = $(focusedRow).attr("data-role");
                        searchUser(role, uniq_id);
                    } else if (page == "projects") {
                        var role = $(focusedRow).attr("data-role");
                        searchProject(role, uniq_id);
                    } else if (page == "files") {
                        var role = $(focusedRow).attr("data-role");
                        searchFile(role, uniq_id);
                    } else if (page == "milestones") {
                        var role = $(focusedRow).attr("data-role");
                        searchMilestone(role, uniq_id);
                    } else {
                        var caseno = $(focusedRow).attr("data-case-no");
                        searchTasks(caseno, uniq_id);
                    }
                    focusedRow = null;
                    $('#srch_load1').hide();
                    return false;
                }
            } else {
                done = 1;
            }
        }
    }
    if (click) {
        done = 1;
    }
    if (done == 1) {
        var page = getPage();
        var srch = $("#case_search").val();
        srch = srch.trim();
        if (page == "users") {
            searchUser('', '', srch);
        } else if (page == "projects") {
            searchProject('', '', srch);
        } else if (page == "files") {
            searchFile('', '', srch);
        } else if (page == "milestones") {
            var isActive = $('#storeIsActive').val();
            searchMilestone('', '', srch, isActive);
        } else if (page == "kanban") {
            searchMilestoneTasks(srch);
        } else {
            validateSearch();
        }
        return false;
    }
}

function hideupdatebtn() {
    $('#subprof1').hide();
    $('#subprof2').show();
    return true;
}

function validateemailrpt() {
    var errMsg;
    var done = 1;
    $('#subprof1').hide();
    $('#subprof2').show();
    if ($('#dlyupdateyes').is(":checked")) {
        var hr = $('#not_hr').val();
        var mn = $('#not_mn').val();
        var prjct = $('#rpt_selprj').val();
        if (hr == 0) {
            errMsg = _("Hours field cannot be blank");
            $("#not_hr").focus();
            done = 0;
        } else if (mn == -1) {
            errMsg = _("Minutes field cannot be blank");
            $("#not_mn").focus();
            done = 0;
        } else if (prjct == null) {
            errMsg = _("Project field cannot be blank");
            $("#rpt_selprj").focus();
            done = 0;
        }
    }
    if (done == 0) {
        showTopErrSucc('error', errMsg);
        $('#subprof2').hide();
        $('#subprof1').show();
        return false;
    }
}

function submitCompany() {
    $('#subprof1').hide();
    $('#subprof2').show();
    var cmpname = $("#cmpname").val();
    var website = $("#website").val();
    var phone = $("#contact_phone").val();
    var errMsg;
    var done = 1;
    var regUrl = /^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/i;
    var rxAlphaNum = /^([0-9\(\)-]+)$/;
    if (cmpname.trim() == "") {
        errMsg = _("Name cannot be left blank!");
        $("#name").focus();
        done = 0;
    } else if (website.trim().length != 0 && !website.trim().match(regUrl)) {
        errMsg = _('Please enter valid website url.');
        $("#website").focus();
        done = 0;
    }
    if (phone.trim().length != 0 && !phone.trim().match(rxAlphaNum)) {
        errMsg = _('Please enter valid contact number.');
        $("#phone").focus();
        done = 0;
    }
    if (phone.trim().length != 0 && phone.replace('-', '').replace('(', '').replace(')', '').length < 3) {
        errMsg = _("Invalid contact number!");
        $('#contact_phone').focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        $('#subprof2').hide();
        $('#subprof1').show();
        return false;
    } else {
        $('#subprof1').hide();
        $('#subprof2').show();
    }
}

function filterUserRole(role, user_srch) {
    var url = HTTP_ROOT + "users/manage/?role=" + role;
    if (user_srch) {
        url = url + "&user_srch=" + user_srch;
    }
    window.location = url;
}

function addProjectToUser() {
    var usr_id = getCookie('LAST_INVITE_USR');
    var usr_nams = getCookie('LAST_INVITE_USR_NAMES');
    usr_id = decodeURIComponent(usr_id);
    setTimeout(function() {
        if (usr_id != 'undefined') {
            var user_id = usr_id.split(",");
            var usr_name = '';
            usr_name = usr_nams;
            usr_name = usr_name.split('+').join(' ');
            createCookie("LAST_INVITE_USR", '', -365, DOMAIN_COOKIE);
            createCookie("LAST_INVITE_USR_NAMES", '', -365, DOMAIN_COOKIE);
            if (confirm("Do you want to assign project to '" + usr_name + "' ?")) {
                usr_name = shortLength(usr_name, 50);
                add_project(usr_id, usr_name, 1);
            }
        }
    }, 1000);
}
$(".icon-assign-usr").click(function() {
    var usr_id = $(this).attr('data-usr-id');
    var usr_name = $(this).attr('data-usr-name');
    var is_invited_user = $("#is_invited_user").val();
    add_project(usr_id, usr_name, is_invited_user);
});
$(".edit-exist-usr").click(function() {
    var usr_id = $(this).attr('data-usr-id');
    var uniqid = $(this).attr('data-usr-uid');
    var usr_name = $(this).attr('data-usr-name');
    var comp_check_usr = $(this).attr('data-comp-count');
    if (comp_check_usr === '1') {
        showTopErrSucc('error', _('Oops! This user belongs to more than one company accounts.') + '\n' + _('Any changes to their profile will be reflected in all accounts.') + '\n' + _('Please contact the user to modify their information.'), 1);
    } else {
        edit_user(uniqid, usr_name);
    }
});
$(".create_new_password").click(function() {
  
        // edit_user(uniqid, usr_name);
        var uniqid = $(this).attr('data-usr-uid');
        openPopup();
        $(".create_password").show();
        $('#new_password').val('').trigger('change');
        $('#new_conform_password').val('').trigger('change');
        // $("#unID").val(uniqid);
        localStorage.setItem("unqID", uniqid);
        // $("#unqID").data('unqid', uniqid);
        
    
});
function add_project(usr_id, usr_name, is_invite_user) {
    $('#pop_up_add_user_proj_label').hide();
    openPopup();
    $("#prjList").html('');
    hdprojectid = new Array();
    $(".add_usr_prj").show();
    $("#header_usr_prj_add").html(usr_name);
    $('#inner_usr_prj_add').hide();
    $('.add-prj-btn').hide();
    $(".popup_bg").css({
        "width": '850px'
    });
    $(".popup_form").css({
        "margin-top": "6px"
    });
    $("#proj_name").val('');
    $('#prjsrch').hide();
    $.post(HTTP_ROOT + "users/add_project", {
        "uid": usr_id,
        "is_invite_user": is_invite_user
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#pop_up_add_user_proj_label').css('display', 'block');
            $('#prjsrch').show();
            $('#inner_usr_prj_add').show();
            $('#inner_usr_prj_add').html(data);
            $('.add-prj-btn').show();
            enableAddPrjBtns('.AddPrjToUser');
            $.material.init();
        }
    });
}

function searchprojkey() {
    var name = $('#proj_name').val();
    var user_id = '';
    try {
        var user_id = $('#user_id').val();
        var count = $('#count').val();
    } catch (e) {}
    var ppid = '';
    if (hdprojectid != '') {
        ppid = hdprojectid.join(',');
    }
    if (user_id) {
        var strURL1 = HTTP_ROOT + 'users/add_project';
        $("#prjpopupload1").show();
        var is_invite_user = $("#is_invite_user").val();
        $.post(strURL1, {
            "count": count,
            "uid": user_id,
            "name": name,
            "is_invite_user": is_invite_user,
            "choosen_proj_ids": ppid
        }, function(data) {
            if (data) {
                $('#inner_usr_prj_add').html(data);
                $.material.init();
                $("#prjpopupload1").hide();
                enableAddPrjBtns('.AddPrjToUser');
                $("#popupContactClose, .c_btn").click(function() {
                    closePopup();
                });
            }
        });
    }
}
$(".icon-remprj-usr").click(function() {
    var usr_id = $(this).attr('data-usr-id');
    var usr_name = $(this).attr('data-usr-name');
    openPopup();
    $(".rmv_usr_prj").show();
    $("#header_usr_prj_rmv").html(usr_name);
    $('#inner_usr_prj_rmv').hide();
    $(".loader_dv").show();
    $('.rmv-prj-btn').hide();
    $('#rmprjname').val('');
    $('#remprjsrch').hide();
    var is_invite_user = $("#is_invited_user").val();
    $.post(HTTP_ROOT + "users/project_listing", {
        "user_id": usr_id,
        "is_invite_user": is_invite_user
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_usr_prj_rmv').show();
            $('#inner_usr_prj_rmv').html(data);
            if (parseInt($("#is_prj").val())) {
                $('.rmv-prj-btn').show();
                $('#remprjsrch').show();
            }
            enableAddPrjBtns('.removePrjFromuser');
            $.material.init();
        }
    });
});

function grantOrRemoveModerator(obj) {
    var usr_id = $(obj).attr('data-usr-id');
    var usr_name = $(obj).attr('data-usr-name');
    var type = $(obj).attr('data-type');
    var msg, suc_msg, err_msg, data_type = 0,
        text = '';
    add_class = rmv_class = '';
    msg = suc_msg = err_msg = "";
    if (parseInt(type)) {
        msg = "grant";
        suc_msg = "Granted";
        err_msg = "grant";
        data_type = 0;
        text = "Revoke Moderator";
        add_class = 'icon-remove-modrt';
        rmv_class = 'icon-add-modrt';
    } else {
        msg = "revoke";
        suc_msg = "Revoked";
        err_msg = "revoke";
        data_type = 1;
        text = "Grant Moderator";
        add_class = 'icon-add-modrt';
        rmv_class = 'icon-remove-modrt';
    }
    if (confirm(_("Are you sure you want to") + " " + msg + " " + _("moderator to") + " '" + usr_name + "'?")) {
        $.post(HTTP_ROOT + "users/grant_moderate", {
            "type": type,
            "user_id": usr_id
        }, function(data) {
            if (parseInt(data)) {
                $(obj).attr('data-type', data_type);
                $(obj).addClass(add_class);
                $(obj).removeClass(rmv_class);
                $(obj).text(text);
                showTopErrSucc('success', suc_msg + ' ' + _('moderator privilege successfully'));
            } else {
                showTopErrSucc('error', _("Error in") + " " + err_msg + " " + _("to moderator"));
            }
        });
    }
}

function searchremprjkey() {
    var name = $('#rmprjname').val();
    var user_id = $('#usrid').val();
    var is_invite_user = $("#is_invite_user").val();
    if (user_id) {
        var strURL1 = HTTP_ROOT + 'users/project_listing';
        $('#rempopupload').css({
            "top": "48px"
        });
        $('#rempopupload').show();
        $.post(strURL1, {
            "user_id": user_id,
            "name": name,
            "is_invite_user": is_invite_user
        }, function(data) {
            if (data) {
                $('#rempopupload').hide();
                $('#inner_usr_prj_rmv').html(data);
                enableAddPrjBtns('.removePrjFromuser');
                $.material.init();
            }
        });
    }
}

function arrayRemove(str, rmvstr) {
    var array = new Array();
    var rmvArray = new Array();
    str = $.trim(str.toLowerCase());
    array = str.split(', ');
    rmvstr = $.trim(rmvstr.toLowerCase());
    rmvArray = rmvstr.split(', ');
    for (var i = 0; i < rmvArray.length; i++) {
        var element = rmvArray[i];
        var index = array.indexOf(element);
        if (index != -1) {
            array.splice(index, 1);
        }
    }
    var string = '';
    if (array !== '') {
        for (var i = 0; i < array.length; i++) {
            var ToCamelCaseTitle = toTitleCase(array[i]);
            string = string + ", " + ToCamelCaseTitle;
        }
        if (string) {
            string = string.replace(', ', '');
        }
    }
    return string;
}

function toTitleCase(str) {
    return str.replace(/(?:^|\s)\w/g, function(match) {
        return match.toUpperCase();
    });
}

function removeprojects() {
    var done = 0;
    var project_name = '';
    var remaining_projects = Array();
    var rmv_user_name = $("#header_usr_prj_rmv").text();
    var user_id = $('#usrid').val();
    var all_project = $("#rmv_allprj_" + user_id).val();
    $('#inner_usr_prj_rmv input.chkbx_cur:checked').each(function() {
        if ($(this).attr('id') !== 'checkAllprojects') {
            project_name = project_name + ", " + $(this).attr('data-prj-name');
            done++;
        }
    });
    project_name = project_name.replace(', ', '');
    remaining_projects = arrayRemove(all_project, project_name);
    if (done) {
        if (confirm(_("Are you sure you want to remove") + " '" + project_name + "' from '" + rmv_user_name + "'?")) {
            $('#inner_usr_prj_rmv input.chkbx_cur:checked').each(function() {
                if ($(this).attr('id') !== 'checkAllprojects') {
                    var listid = $(this).attr('id');
                    var project_id = $(this).attr('value');
                    var listing = $(this).parents("tr").attr('id');
                    $(this).prop('checked', false);
                    $(this).parents("tr").fadeOut(1000);
                    $(this).parents("tr").remove();
                    enableAddPrjBtns('.removePrjFromuser');
                    var strURL = HTTP_ROOT + 'users/project_listing';
                    var is_invite_user = $("#is_invited_user").val();
                    $.post(strURL, {
                        "user_id": user_id,
                        "project_id": project_id,
                        "is_invite_user": is_invite_user
                    }, function(data) {
                        if (data) {}
                    });
                }
            });
            var total_project = $("#total_projects").val();
            var total_projects = parseInt(total_project) - parseInt(done);
            if (parseInt(total_projects) > 0) {
                $("#total_projects").val(total_projects);
            } else {
                $("#rmv_prj_" + user_id).hide();
                closePopup();
            }
            if (remaining_projects) {
                $("#rmv_allprj_" + user_id).val(remaining_projects);
                $("#remain_prj_" + user_id).html(remaining_projects);
            } else {
                $("#rmv_allprj_" + user_id).val("");
                $("#remain_prj_" + user_id).html('N/A');
            }
            showTopErrSucc('success', _("Project(s)") + " '" + project_name + "' " + _("removed from") + " '" + rmv_user_name + "'");
        } else {
            return false;
        }
    }
}

function assignproject(el) {
    var projectid = new Array();
    var project_name = '';
    var done = 0;
    var count = $('#count').val();
    projectid = hdprojectid;
    project_name = hdproject_name;
    if (hdprojectid.length != 0) {
        done++;
    }
    project_name = project_name.replace(', ', '');
    if (done) {
        $(".chkbx_cur").prop("disabled", true);
        var usrid = $('#user_id').val();
        var strURL = HTTP_ROOT + 'users/assign_prj';
        $("#confirmbtnprj").hide();
        $('#prjloader').show();
        var is_invite_user = $("#is_invite_user").val();
        $.post(strURL, {
            "projectid": projectid,
            "userid": usrid,
            "is_invite_user": is_invite_user
        }, function(data) {
            if (data.message) {
                var parr = data.message.split("::");
                if (parr[0] == "success" || data.message == "success") {
                    var user_id = usrid.split(",");
                    for (var i in user_id) {
                        var assignedProjects = $("#rmv_allprj_" + user_id[i]).val();
                        if (!assignedProjects) {
                            $("#rmv_allprj_" + user_id[i]).val(project_name);
                            $("#remain_prj_" + user_id[i]).html(project_name);
                            $("#rmv_prj_" + user_id[i]).show();
                        } else {
                            project_name = assignedProjects + ", " + project_name;
                            $("#rmv_allprj_" + user_id[i]).val(project_name);
                            $("#remain_prj_" + user_id[i]).html(project_name);
                            $("#rmv_prj_" + user_id[i]).show();
                        }
                    }
                    if (el && el.id == "confirmprjbut") {
                        $('#proj_name').val('');
                        var strURL1 = HTTP_ROOT + 'users/add_project';
                        $("#prjpopupload").show();
                        $.post(strURL1, {
                            "uid": usrid,
                            'count': count,
                            "is_invite_user": is_invite_user
                        }, function(data) {
                            if (data) {
                                $('#inner_usr_prj_add').html(data);
                                $("#prjpopupload").hide();
                                enableAddPrjBtns('.AddPrjToUser');
                                $.material.init();
                            }
                        });
                    } else {
                        $('#prjList').html('');
                        closePopup();
                    }
                    $('#prjloader').hide();
                    $("#confirmbtnprj").show();
                    $("#prjList").html('');
                    hdprojectid = new Array();
                    showTopErrSucc('success', _('Project assigned successfully'));
                }
            }
        }, 'json');
    }
}
var hdprojectid = new Array();
var hdproject_name = '';

function createLi(project_id, project_name, id, chkAll, chkOne, row, active_class) {
    var a = $("<a>").attr({
        "class": "closebutton",
        "id": "close" + project_id,
        "href": "javascript:void(0);",
        "onclick": "removeProjectName('" + project_id + "','" + id + "','" + chkAll + "','" + chkOne + "','" + row + "','" + active_class + "');",
    }).html('<i class="material-icons">&#xE14C;</i>');
    var span = $("<span>").attr({
        "class": "ellipsis-view"
    }).html(project_name);
    var li = $("<li>").attr({
        "class": "bit-box instant_select_proj",
        "id": project_id,
        "rel": "7"
    }).html(span).append(a);
    return li;
}

function checkboxCheckUncheck(chkAll, chkOne, row, active_class) {
    $(document).on('click', chkAll, function(e) {
        if ($(chkAll).is(':checked')) {
            $(chkOne).prop('checked', true);
            $(chkOne).parents(row).addClass(active_class);
            $("#prjList").html('');
            $('#inner_usr_prj_add input:checked').each(function() {
                if ($(this).attr('id') !== 'checkAllAddPrj') {
                    var project_id = $(this).attr('value');
                    var project_name = decodeURIComponent($(this).attr('data-prj-name').replace(/\+/g, ' '));
                    var exstId = $("#prjList").find('li[id="' + project_id + '"]').length;
                    if (exstId == 0) {
                        $("#prjList").append(createLi(project_id, project_name, $(this).attr('id'), chkAll, chkOne, row, active_class));
                        hdprojectid.push(project_id);
                        hdproject_name = hdproject_name + ", " + project_name;
                    }
                }
            });
            if (chkOne == '.removePrjFromuser') {
                $("[id^='listing']").addClass('remove_project_chk');
            } else {
                $("[id^='listing']").hide('slow');
            }
            $(chkAll).hide();
        } else {
            $(chkAll).show();
            if (chkOne == '.removePrjFromuser') {
                $("[id^='listing']").removeClass('remove_project_chk');
            } else {
                $("[id^='listing']").show('slow');
            }
            $(chkOne).prop('checked', false);
            $(chkOne).parents(row).removeClass(active_class);
            hdprojectid = new Array();
            hdproject_name = '';
            $("#prjList").html('');
        }
        enableAddPrjBtns(chkOne);
    });
    $(document).on('click', chkOne, function(e) {
        $('.no-extproj_tr').hide();
        if ($(chkOne + ':checked').length == $(chkOne).length) {
            $(chkAll).prop('checked', true);
            $(chkAll).hide();
            $('#inner_usr_prj_add input:checked').each(function() {
                if ($(this).attr('id') !== 'checkAllAddPrj') {
                    var project_id = $(this).attr('value');
                    var project_name = decodeURIComponent($(this).attr('data-prj-name').replace(/\+/g, ' '));
                    var exstId = $("#prjList").find('li[id="' + project_id + '"]').length;
                    if (exstId == 0) {
                        $("#prjList").append(createLi(project_id, project_name, $(this).attr('id'), chkAll, chkOne, row, active_class));
                        hdprojectid.push(project_id);
                        hdproject_name = hdproject_name + ", " + project_name;
                    }
                }
            });
            var lst_id_no = $(this).attr('id').substr(9);
            if (chkOne == '.removePrjFromuser') {
                $('#listing' + lst_id_no).addClass('remove_project_chk');
            } else {
                $('#listing' + lst_id_no).hide('slow');
            }
        } else {
            $(chkAll).show();
            if ($(this).is(':checked')) {
                $(this).parents(row).addClass(active_class);
                $('#inner_usr_prj_add input:checked').each(function() {
                    if ($(this).attr('id') !== 'checkAllAddPrj') {
                        var project_id = $(this).attr('value');
                        var project_name = decodeURIComponent($(this).attr('data-prj-name').replace(/\+/g, ' '));
                        var exstId = $("#prjList").find('li[id="' + project_id + '"]').length;
                        if (exstId == 0) {
                            $("#prjList").append(createLi(project_id, project_name, $(this).attr('id'), chkAll, chkOne, row, active_class));
                            hdprojectid.push(project_id);
                            hdproject_name = hdproject_name + ", " + project_name;
                        }
                    }
                });
                var lst_id_no = $(this).attr('id').substr(9);
                if (chkOne == '.removePrjFromuser') {
                    $('#listing' + lst_id_no).addClass('remove_project_chk');
                } else {
                    $('#listing' + lst_id_no).hide('slow');
                }
            } else {
                var lst_id_no = $(this).attr('id').substr(9);
                if (chkOne == '.removePrjFromuser') {
                    $('#listing' + lst_id_no).removeClass('remove_project_chk');
                } else {
                    $('#listing' + lst_id_no).show('slow');
                }
                var project_id = $(this).attr('value');
                var project_name = decodeURIComponent($(this).attr('data-prj-name').replace(/\+/g, ' '));
                $(this).parents(row).removeClass(active_class);
                removeProjectName(project_id, $(this).attr('id'), chkAll, chkOne, row, active_class);
            }
        }
        enableAddPrjBtns(chkOne);
    });
}

function enableAddPrjBtns(chkOne) {
    if (chkOne == '.AddPrjToUser') {
        if ($(chkOne + ':checked').length) {
            $('#confirmprjcls').removeClass('loginactive');
            $('#confirmprjbut').removeClass('loginactive');
        } else {
            $('#confirmprjcls').addClass('loginactive');
            $('#confirmprjbut').addClass('loginactive');
        }
    } else if (chkOne == '.removePrjFromuser') {
        if ($(chkOne + ':checked').length) {
            $('#rmvprjbtn').removeClass('loginactive');
        } else {
            $('#rmvprjbtn').addClass('loginactive');
        }
    }
}

function enableAddUsrBtns(chkOne) {
    if (chkOne == '.ad-usr-prj') {
        if ($(chkOne + ':checked').length) {
            $('#confirmusercls').removeClass('loginactive');
            $('#confirmuserbut').removeClass('loginactive');
        } else {
            $('#confirmusercls').addClass('loginactive');
            $('#confirmuserbut').addClass('loginactive');
        }
    } else if (chkOne == '.rem-usr-prj') {
        if ($(chkOne + ':checked').length) {
            $('#rmvbtn').removeClass('loginactive');
        } else {
            $('#rmvbtn').addClass('loginactive');
        }
    }
}

function resend_invitation(qrst, email) {
    if (confirm(_('Are you sure you want to Resend Invitation email to') + ' \'' + email + '\' ?')) {
        $("#projectLoader").show();
        $.post(HTTP_ROOT + 'users/resend_invitation', {
            'ajax_flag': 1,
            'querystring': qrst
        }, function(res) {
            if (res.msg == 'succ') {
                $("#projectLoader").hide();
                showTopErrSucc('success', _("Invitaton link send successfully to email") + " '" + email + "'. ");
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            } else {
                $("#projectLoader").hide();
                showTopErrSucc('error', _("Error in sending invitation link!"));
            }
        }, 'json');
    } else {
        return false;
    }
}
$(".proj_mng_div .contain").hover(function() {
    $(this).find(".proj_mng").stop(true, true).animate({
        bottom: "0px",
        opacity: 1
    }, 400);
}, function() {
    $(this).find(".proj_mng").stop(true, true).animate({
        bottom: "-42px",
        opacity: 0
    }, 400);
});

function myactivities(myTab, delegatedTab) {
    if ($('#' + delegatedTab).parents("li").hasClass('active') == true) {
        $('#' + delegatedTab).parents("li").removeClass('active');
        $('#' + myTab).parents("li").addClass('active');
        loadOverdue('my');
        loadUpcoming('my');
    }
}

function delegateactivities(myTab, delegatedTab) {
    if ($('#' + myTab).parents("li").hasClass('active') == true) {
        $('#' + myTab).parents("li").removeClass('active');
        $('#' + delegatedTab).parents("li").addClass('active');
        loadOverdue('delegated');
        loadUpcoming('delegated');
    }
}
var globalTimeoutArcCase = null;
var globalTimeoutArcFile = null;
var globalTimeoutActivity = null;
var globalTimeoutMention = null;
var globalTimeoutUsers = null;
var globalTimeoutTaskgroups = null;
$(document).ready(function() {
    $(window).scroll(function() {
        var height = parseInt($(document).height() - $(window).height()) - parseInt($(window).scrollTop());
        if (parseInt(height) >= 0 && parseInt(height) <= 100) {
            if (caseListData == 1 && fileListData == 0) {
                var totalcaselist = $("#totalCases").val();
                var displayedcases = $("#displayedCases").val();
                if (parseInt(totalcaselist) > parseInt(displayedcases)) {
                    if (globalTimeoutArcCase != null)
                        clearTimeout(globalTimeoutArcCase);
                    globalTimeoutArcCase = setTimeout(changeArcCaseList, 1000, 'more');
                }
            } else if (caseListData == 0 && fileListData == 1) {
                var totalfilelist = $("#totalFiles").val();
                var displayedfiles = $("#displayedFiles").val();
                if (parseInt(totalfilelist) > parseInt(displayedfiles)) {
                    if (globalTimeoutArcFile != null)
                        clearTimeout(globalTimeoutArcFile);
                    globalTimeoutArcFile = setTimeout(changeArcFileList, 1000, 'more');
                }
            } else if (usersListData == 1) {
                var totalUsersData = $("#total_users_count").val();
                var displayedUsersData = $("#displayed_users_count").val();
                if (parseInt(totalUsersData) > parseInt(displayedUsersData)) {
                    if (globalTimeoutUsers != null)
                        clearTimeout(globalTimeoutUsers);
                    globalTimeoutUsers = setTimeout(moreUsersList, 1000, 'more');
                }
            } else if (taskGroupsData == 1) {
                var totalTaskGroupData = $("#totalTaskGroups").val();
                var displayedTaskGroupData = $("#displayedTaskGroups").val();
                if (parseInt(totalTaskGroupData) > parseInt(displayedTaskGroupData)) {
                    if (globalTimeoutTaskgroups != null)
                        clearTimeout(globalTimeoutTaskgroups);
                    globalTimeoutTaskgroups = setTimeout(ajaxCaseView, 1000, 'taskgroups', 'more');
                }
            } else {
                var totalact = $("#totalact").val();
                var displayed = $("#displayed").val();
                if (parseInt(totalact) > parseInt(displayed) && $('#actvt_section').css('display') != 'none') {
                    if (globalTimeoutActivity != null)
                        clearTimeout(globalTimeoutActivity);
                    globalTimeoutActivity = setTimeout(loadActivity, 1000, 'more');
                }
                var totalacts = $("#totalmention").val();
                var displayeds = $("#display_mention").val();
                if (parseInt(totalacts) > parseInt(displayeds) && $('#mention_section').css('display') != 'none') {
                    if (globalTimeoutMention != null)
                        clearTimeout(globalTimeoutMention);
                    globalTimeoutMention = setTimeout(loadMentionList, 1000, 'more');
                }
            }
        }
    });
});

function setStatus() {
    $("div[id^='allStatus']").each(function(res) {
        var v_new = 0;
        var v_replied = 0;
        var v_resolved = 0;
        var v_closed = 0;
        var id = this.id;
        $("#" + id).html('');
        $("." + id).each(function() {
            var sts = $(this).attr("rel");
            if (sts == '1') {
                v_new++;
            }
            if (sts == '2' || sts == '4') {
                v_replied++;
            }
            if (sts == '5') {
                v_resolved++;
            }
            if (sts == '3') {
                v_closed++;
            }
        });
        var status = "<ul><li><span>" + _('Created') + "(<small class='orange-txt'>" + v_new + "</small>)</span></li><li><span> " + _("Worked in progress") + "(<small class='blue-txt'>" + v_replied + "</small>)</span></li><li><span> " + _("Resolved") + "(<small class='orange-txt'>" + v_resolved + "</small>)</span></li><li><span> " + _("Closed") + "(<small class='green-txt'>" + v_closed + "</small>)</span></li></ul>";
        $("#" + id).html(status);
    });
}

function loadMembers(type) {
    var prj_id = $("#prjid").val();
    var projid = prj_id;
    var strURL = HTTP_ROOT + "users/ajax_member/";
    $.post(strURL, {
        'type': type,
        'projid': projid
    }, function(res) {
        $("#Members").html(res);
        $("#moreMemberloader").hide();
    });
}
$(".support-popup").click(function() {
    closePopup();
    $('#support_msg').val('').keyup();
    setTimeout(function() {
        openPopup();
        if (!$(this).parent().is('li')) {
            $('.support_title').text(_('Contact for Help'));
        } else {
            $('.support_title').text(_('Feedback'));
        }
        $(".support_popup").show();
        $("#support_name").focus();
        $("#support_err").html('').hide();
        $("#url_sendding").val(document.URL);
        $('textarea').autoGrow().keyup();
    }, 500);
});

function postSupport() {
    var geturl = $("#url_sendding").val().trim();
    var support_name = $("#support_name").val().trim();
    var support_email = $("#support_email").val().trim();
    var support_msg = $("#support_msg").val().trim();
    $("#support_err").hide();
    if (support_name == "") {
        $("#support_err").show();
        $("#support_err").html(_("Name can not be blank!"));
        $("#support_name").focus();
        return false;
    } else if (support_email == "") {
        $("#support_err").show();
        $("#support_err").html(_("E-mail can not be blank!"));
        $("#support_email").focus();
        return false;
    } else {
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!support_email.match(emlRegExpRFC) || support_email.search(/\.\./) != -1) {
            $("#support_err").show();
            $("#support_err").html(_("Please enter a valid E-mail!"));
            $("#support_email").focus();
            return false;
        } else if (support_msg == "") {
            $("#support_err").show();
            $("#support_err").html(_("Message can not be blank!"));
            $("#support_msg").focus();
            return false;
        } else {
            $("#spt_btn").hide();
            $("#sprtloader").show();
            $.post(HTTP_ROOT + "users/post_support_inner", {
                "support_refurl": escape(geturl),
                "support_email": escape(support_email),
                "support_msg": escape(support_msg),
                "support_name": escape(support_name)
            }, function(data) {
                if (data == "success") {
                    showTopErrSucc('success', _('Thanks for your feedback. We will get back to you as soon as possible.'));
                } else {
                    showTopErrSucc('error', _("Error in post to support!"));
                }
                $("#spt_btn").show();
                $("#sprtloader").hide();
                $("#support_msg").val('');
                closePopup();
            });
        }
    }
    return false;
}

function getProjectMembers(obj) {
    if (obj.value == 0) {
        $("#daily_btn").prop('disabled', true);
    } else {
        $("#daily_btn").prop('disabled', false);
    }
    var strURL = HTTP_ROOT + "projects/projectMembers";
    $("#loading_sel").show();
    $("#err_msg_spn").hide();
    daily_update_id = 0;
    $("#tr_members").remove();
    $("#tr_timezone").remove();
    $("#tr_time").remove();
    $("#tr_days").remove();
    $("#upd_minute").find('option').remove();
    $("#upd_hour").find('option').remove();
    $("#timezone_id").find('option').remove();
    $("#frequency").find('option').remove();
    $.post(strURL, {
        "id": obj.value,
        "prj_id": obj.value,
    }, function(res) {
        var res = res.replace("<head/>", "");
        var res = res.replace("<head/ >", "");
        var res = res.replace("<head />", "");
        if (res) {
            is_project_members = 1;
            $(res).insertAfter($("#tr_project"));
            $.material.init();
            var t_arr = [];
            $('#tr_timezone').find('.dropdownjs').find('ul li').each(function(e) {
                var t_v = $(this).attr('value');
                if ($.inArray(t_v, t_arr) == -1) {
                    t_arr.push(t_v);
                } else {
                    $(this).remove();
                }
            });
            var t_arr1 = [];
            $('#tr_days').find('.dropdownjs').find('ul li').each(function(e) {
                var t_v1 = $(this).attr('value');
                if ($.inArray(t_v1, t_arr1) == -1) {
                    t_arr1.push(t_v1);
                } else {
                    $(this).remove();
                }
            });
            var t_arr2 = [];
            $('.upd_hour').find('.dropdownjs').find('ul li').each(function(e) {
                var t_v2 = $(this).attr('value');
                if ($.inArray(t_v2, t_arr2) == -1) {
                    t_arr2.push(t_v2);
                } else {
                    $(this).remove();
                }
            });
            var t_arr3 = [];
            $('.upd_minute').find('.dropdownjs').find('ul li').each(function(e) {
                var t_v3 = $(this).attr('value');
                if ($.inArray(t_v3, t_arr3) == -1) {
                    t_arr3.push(t_v3);
                } else {
                    $(this).remove();
                }
            });
            daily_update_id = $("#daily_update_id").val();
            $("#daily_btn_disable").hide();
            $("#daily_btn").show();
        } else {
            is_project_members = 0;
            var str = '<tr id="tr_members"><td colspan="2"></td></tr>';
            $(str).insertAfter($("#tr_project"));
            $("#daily_btn_disable").show();
            $("#daily_btn").hide();
        }
        if (parseInt(daily_update_id)) {
            $("#daily_btn").html("<i class='icon-big-tick'></i>" + _("Update"));
            $("#cancel_daily_update").show();
        } else {
            $("#cancel_daily_update").hide();
            $("#daily_btn").html("<i class='icon-big-tick'></i>" + _("Save"));
        }
        $("#loading_sel").hide();
    });
}

function checkUncheckAll(arg) {
    if (parseInt(arg)) {
        if ($('#user_all').is(":checked")) {
            $(".prj_users").attr("checked", "checked");
        } else {
            $(".prj_users").attr("checked", false);
        }
    } else {
        if ($('.prj_users:checked').length == $('.prj_users').length) {
            $("#user_all").attr("checked", "checked");
        } else {
            $("#user_all").attr("checked", false);
        }
    }
    $("#err_msg_spn").hide();
}

function validateDailyMail() {
    var done = 1;
    if ($.trim($("#project_id").val()) == '') {
        errMsg = _("Please select project.");
        done = 0;
    }
    if ($('.prj_users:checked').length == 0) {
        errMsg = _("Please choose atleast one user.");
        done = 0;
    } else if ($.trim($("#upd_hour").val()) == '' || $.trim($("#upd_hour").val()) == '-1') {
        errMsg = _("Please select hour.");
        done = 0;
    } else if ($.trim($("#upd_minute").val()) == '' || $.trim($("#upd_minute").val()) == '-1') {
        errMsg = _("Please select minute.");
        done = 0;
    }
    if (done == 0) {
        showTopErrSucc('error', errMsg);
        return false;
    } else {
        $('#subprof1').hide();
        $('#subprof2').show();
        $('#dailyUpdateForm').submit();
    }
}

function showError(msg) {
    $("#err_msg_spn").html(msg);
    $("#err_msg_spn").show();
}

function hideErr() {
    $("#err_msg_spn").hide();
}

function cancel_daily_update() {
    if (confirm(_("Are you sure you want to cancel Daily Catch-Up alert for this project?"))) {
        $('#subprof1').hide();
        $('#cancel_daily_update').hide();
        $('#subprof2').show();
        var path = "projects/cancelDailyUpdate/";
        window.location.href = HTTP_ROOT + path + daily_update_id;
    }
}

function openEditor(editormessage, basic_or_free) {
    var templat_arr = [];
    $.each(TASKTMPL, function(index_tml, value_tml) {
        templat_arr.push({
            "title": value_tml.CaseTemplate.name,
            "description": value_tml.CaseTemplate.description,
            "content": value_tml.CaseTemplate.description
        });
    });
    $("#divNewCase").hide();
    $("#divNewCaseLoader").show();
    (function($) {
        if (typeof(tinymce) != "undefined") {}
        var dir_tiny = 'ltr';
        if (SES_COMP === '33179' || SHOW_ARABK === '1') {
            dir_tiny = 'rtl';
        }
        if (tinymce.get('CS_message')) {
            tinymce.get('CS_message').remove();
        }
        if (CMP_ARABK === '23823' || SES_COMP === '33179' || SHOW_ARABK === '1') {
            tinymce.init({
                selector: "#CS_message",
                plugins: 'paste importcss autolink image directionality fullscreen link  template  charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
                menubar: false,
                branding: false,
                statusbar: false,
                toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | template | ltr rtl | fullscreen',
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
                min_height: 160,
                max_height: 400,
                paste_data_images: true,
                paste_as_text: true,
                autoresize_on_init: true,
                autoresize_bottom_margin: 20,
                content_css: HTTP_ROOT + 'css/tinymce.css',
                setup: function(ed) {
                    ed.on('Click', function(ed, e) {
                        $('#start_time').timepicker('hide');
                        $('#end_time').timepicker('hide');
                        $("#start_date").datepicker('hide');
                        $("#due_date").datepicker('hide');
                        $("#showhide_task_conf").removeClass('open');
                    });
                    ed.on('KeyUp', function(ed, e) {
                        var inpt = $.trim(tinymce.activeEditor.getContent());
                        var inptLen = inpt.length;
                        var datInKb = 0;
                        var datInKb = ((inptLen * (3 / 4)) - 1) / 1024;
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
                        $("#divNewCaseLoader").hide();
                        $("#divNewCase").show();
                        $('#CS_message').val(editormessage);
                        tinymce.get('CS_message').setContent(editormessage);
                        $("#tmpl_open").show();
                    });
                }
            });
        } else {
            tinymce.init({
                selector: "#CS_message",
                plugins: 'paste importcss autolink image directionality fullscreen link  template  charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize help',
                menubar: false,
                branding: false,
                statusbar: false,
                toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor | template fullscreen',
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
                min_height: 160,
                max_height: 400,
                paste_data_images: true,
                paste_as_text: true,
                autoresize_on_init: true,
                autoresize_bottom_margin: 20,
                content_css: HTTP_ROOT + 'css/tinymce.css',
                setup: function(ed) {
                    ed.on('Click', function(ed, e) {
                        $('#start_time').timepicker('hide');
                        $('#end_time').timepicker('hide');
                        $("#start_date").datepicker('hide');
                        $("#due_date").datepicker('hide');
                        $("#showhide_task_conf").removeClass('open');
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
                        $("#divNewCaseLoader").hide();
                        $("#divNewCase").show();
                        $('#CS_message').val(editormessage);
                        tinymce.get('CS_message').setContent(editormessage);
                        $("#tmpl_open").show();
                    });
                }
            });
        }
    })($);
    var x = document.getElementsByTagName("body")[0];
    var holder_detal = document.getElementById('holder_crt_task'),
        tests = {
            dnd_detl: 'draggable' in document.createElement('span')
        };
    if ($('#holder_crt_task').length) {
        if (tests.dnd_detl) {
            var entered = 0;
            holder_detal.ondragover = function() {
                $('#holder_crt_task').addClass('hover_drag');
                return false;
            };
            x.ondragenter = function(e) {
                if ($(e.target).closest('.full_width_resp').length > 0) {
                    entered = 1;
                } else {
                    entered = 0;
                }
                if (entered == 1) {
                    $('#holder_crt_task').addClass('hover_drag');
                    entered = 0;
                } else {
                    $('#holder_crt_task').removeClass('hover_drag');
                    entered = 0;
                }
                return false;
            };
            x.ondrop = function(e) {
                if ($(e.target).hasClass('customfile-input')) {} else {
                    $('#holder_crt_task').removeClass('hover_drag');
                    return false;
                }
                entered = 0;
            };
            holder_detal.ondrop = function(e) {
                $('#holder_crt_task').removeClass('hover_drag');
                if (e.dataTransfer.files[0].name.match(/\.(.+)$/) == null || e.dataTransfer.files[0].size === 0) {
                    alert('File "' + e.dataTransfer.files[0].name + '" ' + _("has no extension") + '!\n' + _("Please upload files with extension") + '.');
                    e.stopPropagation();
                    e.preventDefault();
                }
                entered = 0;
                return false;
            };
        }
    }
}

function attachFile() {
    $('#task_file').click();
}

function replyattachfile(id) {
    $("#tsk_attach" + id).click();
}

function createTaskTemplatePlugin() {
    if (typeof(tinymce) != "undefined") {
        tinymce.create('tinymce.plugins.TaskTemplatePlugin', {
            createControl: function(n, cm) {
                switch (n) {
                    case 'tasktemplate':
                        var mlb = cm.createListBox('tasktemplate', {
                            title: 'Task Template',
                            onselect: function(v) {
                                if (v && v.indexOf('##') != -1) {
                                    showTemplates(v.split('##')[0], v.split('##')[1]);
                                } else {
                                    tinymce.activeEditor.setContent(tinyPrevContent);
                                }
                            }
                        });
                        mlb.add('Set to default', 0);
                        if (countJS(TASKTMPL)) {
                            for (var tmpl in TASKTMPL) {
                                if (typeof TASKTMPL[tmpl] != 'function') {
                                    mlb.add(TASKTMPL[tmpl].CaseTemplate.name, TASKTMPL[tmpl].CaseTemplate.id + '##' + TASKTMPL[tmpl].CaseTemplate.name);
                                }
                            }
                        }
                        return mlb;
                }
                return null;
            }
        });
        tinymce.PluginManager.add('tasktemplate', tinymce.plugins.TaskTemplatePlugin);
    }
}

function showTemplates(id, name) {
    tinyPrevContent = tinymce.activeEditor.getContent();
    tinymce.activeEditor.setContent('');
    if (id != "New") {
        document.getElementById('CS_message_ifr').disable = true;
        $("#CS_message_ifr").hide();
        $.post(HTTP_ROOT + "easycases/ajax_case_template", {
            "tmpl_id": id
        }, function(data) {
            $("#CS_message_ifr").show();
            if (data) {
                tinymce.activeEditor.setContent(data);
            }
        });
    }
}
var newchkpt = 0;

function submitAddNewCase(postdata, CS_id, uniqid, cnt, dtls, status, prelegend, pid, type) {
    if (parseInt(localStorage.getItem("is_change_reason_set")) && (!localStorage.getItem("change_reason_editask") || localStorage.getItem("change_reason_editask") == null || localStorage.getItem("change_reason_editask") == '') && localStorage.getItem("change_reason_duedt") != '' && localStorage.getItem("change_reason_duedt") != null) {
        var due_dt_compare = $('#CS_due_date').val();
        if (due_dt_compare != localStorage.getItem("change_reason_duedt")) {
            var d_splt = due_dt_compare.split('-');
            var d_splt_inpt = localStorage.getItem("change_reason_duedt").split('/');
            if ((d_splt[0] != d_splt_inpt[2]) || (d_splt[1] != d_splt_inpt[0]) || (d_splt[2] != d_splt_inpt[1])) {
                $.post(HTTP_ROOT + "task_actions/ajaXCheckDueDateExists", {
                    "caseId": CS_id,
                    'uniqid': $('#easycase_uid').val()
                }, function(resp) {
                    if (resp.status == 'success') {
                        localStorage.setItem("change_reason_param", postdata + '__' + CS_id + '__' + uniqid + '__' + cnt + '__' + dtls + '__' + status + '__' + prelegend);
                        addDuedateReason();
                    } else {
                        localStorage.setItem("change_reason_duedt", '');
                        localStorage.setItem("change_reason_param", '');
                        submitAddNewCase(postdata, CS_id, uniqid, cnt, dtls, status, prelegend);
                    }
                }, 'json');
                return false;
            }
        }
    } else {
        localStorage.getItem("change_reason_duedt", '');
        localStorage.setItem("change_reason_param", '');
    }
    var reason_id = 0;
    if (localStorage.getItem("change_reason_editask") && localStorage.getItem("change_reason_editask") != null && localStorage.getItem("change_reason_editask") != '') {
        reason_id = localStorage.getItem("change_reason_editask");
        localStorage.setItem("change_reason_duedt", '');
        localStorage.setItem("change_reason_editask", '');
    }
    if (type == 'continue' || ($('#create_another_task').is(":checked"))) {
        $('.breadcrumb_fixed').hide();
        $('.breadcrumb_div').hide();
        $('#create_task_pop').css('display', 'block');
        $('.task_action_bar').show();
        $('.crtskmenus').closest('span').removeClass('open');
    } else {
        $('.crttask_overlay').hide();
        $('.slide_rht_con').show();
        $('.rht_content_cmn').removeClass('rht_content_cmn_crt');
    }
    var tl_id = typeof CS_id != 'undefined' && CS_id != '0' ? CS_id : '';
    var timelogparams = {};
    if (CS_id) {
        var total_spent = 0;
        var total_break = 0;
    } else {
        var spnt_times = $('#hours' + tl_id).val().split(':');
        var breaktimes = $('#break_time').val().split(':');
        var total_spent = parseInt((spnt_times[0] * 60) + spnt_times[1]);
        var total_break = parseInt((breaktimes[0] * 60) + breaktimes[1]);
    }
    if ($('#hours' + tl_id).val() != '' && $('.timelog_block').is(':visible')) {
        if (total_spent < total_break) {
            $('#break_time' + tl_id).focus();
            showTopErrSucc('error', _('Break time can not exceed the total spent hours.'));
            return false;
        } else if (total_spent == 0) {
            showTopErrSucc('error', _('Start time and End time can not same.'));
            return false;
        } else if (total_spent == total_break) {
            $('#break_time' + tl_id).focus();
            showTopErrSucc('error', _('Break time can not same as the total spent hours.'));
            return false;
        }
        var d = new Date();
        timelogparams = {
            taskdate: d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(),
            hours: $('#hours' + tl_id).val(),
            start_time: $('#start_time' + tl_id).val(),
            end_time: $('#end_time' + tl_id).val(),
            break_time: $('#break_time' + tl_id).val(),
            is_bilable: $('#is_bilable' + tl_id).attr("checked") ? "Yes" : "No",
        };
    } else {
        timelogparams = false;
    }
    var CS_type_id = 2;
    var CS_priority = 2;
    var CS_assign_to = 0;
    var CS_message = "";
    var CS_start_date = "";
    var CS_due_date = "";
    var CS_legend = status;
    var CS_milestone = "";
    var cs_hours = 0;
    var est_hours = 0;
    var completed = 0;
    var task_uid = 0;
    var taskid = 0;
    var CS_isRecurring = 0;
    var CS_recurringType = '';
    var CS_recurring_endDate = '';
    var CS_recurring_startDate = '';
    var CS_occurrence = '';
    var CS_recurringEndType = '';
    var CS_parent_id = '';
    var story_points = 0;
    if ($('#story_points').length) {
        story_points = $('#story_points').val();
    }
    var done = 1;
    if (CS_id) {
        var project_id = "CS_project_id" + CS_id;
        var istype = "CS_istype" + CS_id;
        var title = "CS_title" + CS_id;
        var CS_project_id = $('#' + project_id).val();
        var CS_istype = $('#' + istype).val();
        var CS_title = $('#' + title).val();
        var CS_parent_id = $('#CS_parent_task' + CS_id).val();
        var type_id = "CS_type_id" + CS_id
        var priority = "CS_priority" + CS_id
        var case_no = "CS_case_no" + CS_id
        var CS_type_id = $('#' + type_id).val();
        var CS_priority = $('#' + priority).val();
        var CS_case_no = $('#' + case_no).val();
        var html = "html" + CS_id;
        var plane = "plane" + CS_id;
        if ($('#' + html).is(":visible")) {
            var txa_comments = "txa_comments" + CS_id;
            CS_message = tinymce.get(txa_comments).getContent();
        } else {
            var txa_plane = "txa_plane" + CS_id;
            CS_message = nl2br($.trim($('#' + txa_plane).val()));
        }
        var editortype = "editortype" + CS_id;
        var datatype = $('#' + editortype).val();
        var totfiles = "totfiles" + CS_id;
        var hidalluser = "hidtotresreply" + CS_id;
        var assign_to = "CS_assign_to" + CS_id;
        var CS_assign_to = $('#' + assign_to).val();
    } else {
        if ($('.crtskasgnusr').length) {
            $('#CS_assign_to').val($('.crtskasgnusr').val().trim());
        }
        var CS_project_id = $(".prj-select").val();
        var CS_istype = $('#CS_istype').val();
        var CS_title = $('#CS_title').val();
        var CS_parent_id = $('#CS_parent_task').val();
        var totfiles = "totfiles";
        var hidalluser = "hidtotproj";
        var datatype = 0;
        if ($('#easycase_uid').val()) {
            task_uid = $('#easycase_uid').val();
            taskid = $('#CSeasycaseid').val();
        }
        $('#projAllmsg').hide();
        if (CS_project_id == 'all') {
            $('#projAllmsg').show();
            $('#ctask_popup a').css({
                'border': '1px solid #CE2129'
            });
            return false;
        } else {
            $('#ctask_popup a').css({
                'border': '1px solid #cccccc'
            });
        }
        if (!CS_id) {
            if (CS_project_id == "") {
                done = 0;
            }
            if (CS_title.trim() == "" || CS_title.trim() == "Task Title") {
                $('#CS_title').parent('div').addClass('has-error');
                $("#CS_title").focus();
                done = 0;
            } else {
                $('#CS_title').parent('div').removeClass('has-error');
            }
        }
    }
    CS_recurringType = $('#CSrepeat_type').val();
    if (trim(CS_recurringType) != '' && trim(CS_recurringType) != 'None') {
        CS_isRecurring = 1;
        CS_recurring_startDate = trim($('#CSrepeat_start_date').val()) != '' ? trim($('#CSrepeat_start_date').val()) : trim($('#CS_due_date').val());
        if ($('#occur').is(':checked')) {
            CS_recurringEndType = 'occur';
            CS_occurrence = trim($('#occurrence').val());
            if (CS_recurring_startDate != '' && CS_occurrence == '') {
                showTopErrSucc('error', _('Number of occurrences can not be left blank'));
                $('#occurrence').focus();
                return false;
            }
        } else if ($('#date').is(':checked')) {
            CS_recurringEndType = 'date';
            CS_recurring_endDate = trim($('#CSrepeat_due_date').val());
            if (CS_recurring_startDate != '' && CS_recurring_endDate == '') {
                showTopErrSucc('error', _('End date can not be left blank'));
                $('#end_datePicker').focus();
                return false;
            }
        }
    }
    var recurringData = '';
    if ($('#is_recurring').is(":checked")) {
        CS_isRecurring = 1;
        recurringData = serializeDatatoArray($('#recurrence_details_form').serializeArray());
    }
    var relates_to = '';
    if ($('.relates-select').val() != '') {
        relates_to = $('.relates-select').val();
    }
    var link_task = '';
    if ($('.link-to-select').val() != '') {
        link_task = $('.link-to-select').val();
    }
    var task_labels = '';
    if ($('.label-to-select').val() != '') {
        task_labels = $('.label-to-select').val();
    }
    var emailUser = Array();
    var allUser = Array();
    var allFiles = Array();
    var allchklist = Array();
    var allchklistSts = Array();
    $('.check_chklist_crt').each(function(i) {
        var is_ched = ($(this).is(':checked')) ? 1 : 0;
        var is_ched_id = $(this).attr('data-val');
        allchklistSts.push(is_ched + '__' + is_ched_id);
    });
    $('.check_chklist_crt_ttl').each(function(i) {
        allchklist.push($(this).val());
    });
    try {
        if (CS_id) {
            var chk = CS_id + "chk_";
        } else {
            var chk = "chk_";
        }
        $('input[id^="' + chk + '"]').each(function(i) {
            if ($(this).is(':checked')) {
                emailUser.push($(this).val());
            }
        });
    } catch (e) {}
    try {
        if (done == 1) {
            if ((typeof(gFileupload) != 'undefined') && gFileupload == 0) {
                showTopErrSucc('error', _('Oops! File upload is in Progress'));
                $('#quickcase').show();
                $('.save_exit_btn').show();
                return false;
            } else {
                done = 1;
            }
        }
        var editRemovedFile = '';
        if (task_uid) {
            editRemovedFile = $('#editRemovedFile').val();
        }
        var totfiles = $('#' + totfiles).val();
        if (parseInt(totfiles) && done == 1) {
            if (!CS_id) {
                $('.ajxfileupload').each(function(i) {
                    allFiles.push($(this).val());
                });
            } else {
                for (var i = 1; i <= totfiles; i++) {
                    var fid = CS_id + "jqueryfile" + i;
                    if ($('#' + fid) && $('#' + fid).val()) {
                        allFiles.push($('#' + fid).val());
                    }
                }
            }
            var file_size = 0;
            var storage_max = $("#max_storage").text();
            var storage_met = $('#storage_met').text().trim();
            if (storage_met == 'GB') {
                storage_max = storage_max * 1024;
            }
            if (parseFloat(storage_max)) {
                var storage_used = $("#used_storage").text().trim();
                for (var indx in allFiles) {
                    if (allFiles[indx] != '') {
                        var first = parseInt(allFiles[indx].indexOf("|"));
                        var second = parseInt(allFiles[indx].indexOf("|", first + 1));
                        file_size = parseFloat(file_size) + parseFloat(allFiles[indx].substring(first + 1));
                    }
                }
                var total_size = parseFloat(storage_used) + parseFloat(file_size / 1024);
                total_size = total_size.toFixed('2');
                if (parseFloat(total_size) <= parseFloat(storage_max)) {
                    done = 1;
                } else {
                    done = 0;
                    showTopErrSucc('error', _('Storage limit exceeded!') + '<br /><br />' + _('Upgrade your account to get more storage.') + '<br /><br />' + _('OR, remove any of the attached file.'));
                }
            }
        }
    } catch (e) {}
    if ((done == 1 && emailUser.length != "0") || (done == 1)) {
        if (!parseInt(CS_id)) {
            if ($('#new_case_more_div').html() || 1) {
                CS_type_id = $('.tsktyp-select').val();
                CS_priority = $('#CS_priority').val();
                cs_hours = $("#hours").val();
                est_hours = $("#estimated_hours").val();
                try {
                    CS_message = tinymce.activeEditor.getContent();
                } catch (e) {}
                CS_start_date = $('#CS_start_date').val();
                if (taskid && CS_start_date.trim() != '' && CS_start_date.indexOf('-') > -1) {
                    CS_start_date = moment(CS_start_date).format('MM/DD/YYYY');
                }
                CS_due_date = $('#CS_due_date').val();
                CS_milestone = $('#CS_milestone').val();
            }
            CS_assign_to = $('#CS_assign_to').val();
            var own_session_id = $('#own_session_id').val();
            if (CS_assign_to == '') {
                CS_assign_to = own_session_id;
            } else {
                CS_assign_to = CS_assign_to;
            }
            $('#quickcase').hide();
            $('.save_exit_btn').hide();
            $('#sendCaret').hide();
            $('#quickloading').show();
            $('#sendOptions').parent('div').removeClass('open');
        } else {
            var postcomments = "postcomments" + CS_id;
            var loadcomments = "loadcomments" + CS_id;
            $('#' + postcomments).find('.toglle_on_click').hide();
            $('#' + postcomments).hide();
            document.getElementById(loadcomments).style.display = 'block';
            var cs_hours = $("#hours" + CS_id).val();
            var completed = $("#completed" + CS_id).val();
        }
        var pagename = $('#pagename').val();
        var strURL = HTTP_ROOT;
        strURL = strURL + "easycases/";
        if (!cs_hours) {
            cs_hours = 0;
        }
        if (!est_hours) {
            est_hours = 0;
        }
        var cloud_storages;
        if (CS_id) {
            cloud_storages = $('#cloud_storage_form_' + CS_id).serialize();
        } else {
            cloud_storages = $('#cloud_storage_form_0').serialize();
        }
        var is_client = 0;
        if ($('#make_client').is(':checked')) {
            is_client = 1;
        }
        if ($('#make_client_dtl').is(':checked')) {
            is_client = 1;
        }
        if (CS_id) {
            if ($('#make_client_dtl' + CS_id).is(':checked')) {
                is_client = 1;
            }
        }
        if (is_client == 1) {
            var asn_to = CS_assign_to;
            var uarr = new Array();
            $('.chk_client').each(function() {
                if ($(this).is(':checked')) {
                    uarr.push($(this).val());
                }
            });
            if ($.inArray(asn_to, uarr) > -1) {
                $('#tsk_asgn_to').text('me');
                $('#CS_assign_to').val(SES_ID);
            }
        }
        var x = 0;
        if (new Date(CS_due_date).getTime() > new Date(CS_recurring_startDate).getTime()) {
            showTopErrSucc('error', _('Task Due date can not be greater than reccurrence start date'));
            x = 1;
        }
        if (new Date(CS_due_date).getTime() > new Date(CS_recurring_endDate).getTime()) {
            showTopErrSucc('error', _('Task Due date can not be greater than reccurrence end date'));
            x = 1
        }
        if (new Date(CS_due_date).getTime() < new Date(CS_start_date).getTime()) {
            showTopErrSucc('error', _('Task Start date can not be greater than Due date'));
            x = 1
        }
        if (new Date(CS_recurring_endDate).getTime() < new Date(CS_recurring_startDate).getTime()) {
            showTopErrSucc('error', _('Reccurrence End date can not be less than reccurrence start date'));
            x = 1
        }
        if ($('.task-field-16').css('display') == 'block') {
            if ($(".CS_value").length) {
                $('.CS_value').each(function() {
                    var taskCFValue = $(this).val();
                    var isRequired = $(this).attr("data-isRequired");
                    var fieldType = $(this).attr("data-fieldType");
                    if ((isRequired == 1) && (taskCFValue == "")) {
                        showTopErrSucc('error', _('This field can not be blank.'));
                        $(this).focus();
                        x = 1
                    }
                    if ((taskCFValue != "") && (fieldType == 4)) {
                        if (!taskCFValue.match(/^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/)) {
                            showTopErrSucc('error', _('Please enter a valid URL.'));
                            $(this).focus();
                            x = 1
                        }
                    }
                    if ((taskCFValue != "") && (fieldType == 5)) {
                        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if (!regex.test(taskCFValue)) {
                            showTopErrSucc('error', _('Please enter a valid Email Id.'));
                            $(this).focus();
                            x = 1
                        }
                    }
                });
            }
        }
        if (x == 1) {
            $('#quickloading').hide();
            $('#quickcase').show();
            $('.save_exit_btn').show();
            $('#sendCaret').show();
            return false;
        }
        var customFieldData = [];
        var customFieldId = [];
        if ($('.task-field-16').css('display') == 'block') {
            if ($(".CS_value").length) {
                $('.CS_value').each(function() {
                    var fieldType = $(this).attr("data-fieldType");
                    var taskCFValue = '';
                    if (fieldType == '3') {
                        var cfValue = $(this).val();
                        taskCFValue = moment(cfValue).format('DD/MM/YYYY');
                    } else {
                        taskCFValue = $(this).val();
                    }
                    if (taskid == 0) {
                        if (taskCFValue != '') {
                            customFieldData.push(taskCFValue);
                            customFieldId.push($(this).data("id"));
                        }
                    } else {
                        customFieldData.push(taskCFValue);
                        customFieldId.push($(this).data("id"));
                    }
                });
            }
        }
        if (typeof arguments[9] != 'undefined' && arguments[9] == 'comment') {
            CS_assign_to = $('#asn_hiddden').val();
        } else {
        CS_assign_to = $('#CS_assign_to').val();
        }
        var tskURL = (cloud_storages) ? strURL + "ajaxpostcase?" + cloud_storages : strURL + "ajaxpostcase";
        var added_mention_array = mention_array;
        $.post(tskURL, {
            pid: pid,
            CS_project_id: CS_project_id,
            CS_istype: CS_istype,
            CS_title: CS_title,
            CS_type_id: CS_type_id,
            CS_priority: CS_priority,
            CS_message: CS_message,
            CS_assign_to: CS_assign_to,
            CS_start_date: CS_start_date,
            CS_due_date: CS_due_date,
            CS_milestone: CS_milestone,
            postdata: postdata,
            pagename: pagename,
            emailUser: emailUser,
            allUser: allUser,
            allFiles: allFiles,
            CS_id: CS_id,
            CS_case_no: CS_case_no,
            datatype: datatype,
            CS_legend: CS_legend,
            prelegend: prelegend,
            'hours': cs_hours,
            'estimated_hours': est_hours,
            'completed': completed,
            'taskid': taskid,
            'task_uid': task_uid,
            'editRemovedFile': editRemovedFile,
            'is_client': is_client,
            timelog: timelogparams,
            'CS_isRecurring': CS_isRecurring,
            'CS_recurringType': CS_recurringType,
            'CS_recurring_endDate': CS_recurring_endDate,
            'CS_recurring_startDate': CS_recurring_startDate,
            'CS_occurrence': CS_occurrence,
            'CS_recurringEndType': CS_recurringEndType,
            'recurringData': recurringData,
            'CS_parent_id': CS_parent_id,
            'relates_to': relates_to,
            'link_task': link_task,
            'task_label': task_labels,
            'story_point': story_points,
            'allchklistSts': allchklistSts,
            'allchklist': allchklist,
            'mention_array': mention_array,
            customFieldData: customFieldData,
            customFieldId: customFieldId,
            'reason_id': reason_id
        }, function(data) {
            if (data) {
                mention_array['mention_type_id'] = new Array();
                mention_array['mention_type'] = new Array();
                mention_array['mention_id'] = new Array();
                $('#checklist_body_create').html('');
                refreshTasks = 1;
                $('#quickloading').hide();
                if (typeof data.success != 'undefined' && data.success == 'No') {
                    $('#quickloading').hide();
                    $('#quickcase').show();
                    $('.save_exit_btn').show();
                    if ($('#quickcase').html() != 'Update') {
                        $('#sendCaret').show();
                    }
                    $('span[id^=postcomments]').show();
                    $('[id^=postcomments]').find('.toglle_on_click').show();
                    $('span[id^=loadcomments]').hide();
                    var html = '';
                    var users_arr = new Array();
                    $('select[id^=CS_assign_to]').find('option').each(function() {
                        users_arr[$(this).val()] = $(this).html();
                    });
                    $.each(data.data, function(index, value) {
                        $.each(value, function(index1, value2) {
                            html += users_arr[value2.user_id] + " " + _("on") + " " + value2.task_date + " " + _("from") + " " + value2.start_time + " " + _("to") + " " + value2.end_time + " ";
                            html += "<br/>";
                        });
                    });
                    showTopErrSucc('error', _('Time Log value overlapping for following users') + ':<br/>' + html);
                    $(".post-canel-btn").children('div').show();
                    return false;
                }
                if (!CS_id) {
                    try {
                        if ($('#caseMenuFilters').val() != 'kanban' && $('#caseMenuFilters').val() != 'milestonelist') {
                            $('#caseMenuFilters').val('');
                        }
                        $('#pageheading').html('Tasks');
                        tinymce.activeEditor.setContent('');
                    } catch (e) {}
                    if (data.isAssignedUserFree != 1) {} else {
                        if (task_uid) {
                            $("#t_" + task_uid).remove();
                            showTopErrSucc('success', _('Your task has been Updated.') + ' ' + (data.depend_message || ''));
                        } else {
                            showTopErrSucc('success', _('Your task has been posted.') + ' ' + (data.depend_message || ''));
                        }
                    }
                    $('#drive_tr_0').remove();
                    $('#usedstorage').val('');
                    $('#up_files').empty();
                    $('#cloud_storage_files_0').html('');
                    if (data.storage_used) {
                        var clr = 'red';
                        var max_storage = $("#max_storage").text().trim();
                        var lbl_storag = $("#storage_met").text().trim();
                        var new_storag = '';
                        if (parseInt(data.storage_used_gb) == 0 || parseInt(data.storage_used_gb) > 0) {
                            new_storag = "<span id='used_storage'>" + data.storage_used_gb + "</span> GB";
                        } else {
                            new_storag = "<span id='used_storage'>" + data.storage_used + "</span> MB";
                        }
                        if (lbl_storag == 'GB') {
                            var t_storage = parseInt(max_storage) * 1024;
                            if (parseFloat(data.storage_used) < parseFloat(t_storage)) {
                                clr = '#333';
                            }
                        } else {
                            if (max_storage == 'Unlimited' || (parseFloat(data.storage_used) < parseFloat(max_storage))) {
                                clr = '#333';
                            }
                        }
                        var str = "<font style='color:" + clr + "'>" + new_storag + "/<b><span id='max_storage'>" + max_storage + "</span></b><span id='storage_met'> " + lbl_storag + "</span></font>";
                        $("#storage_spn").html(str);
                    }
                    $('#quickcase').show();
                    $('.save_exit_btn').show();
                    $('#sendCaret').show();
                    $('#quickloading').hide();
                    $('#CS_title').val('');
                    if (SES_TIME_FORMAT == 24) {
                        $('#end_time' + tl_id).timepicker({
                            'timeFormat': 'H:i'
                        });
                        $('#start_time' + tl_id).timepicker({
                            'timeFormat': 'H:i'
                        });
                    }
                    $('#end_time' + tl_id).timepicker('setTime', null);
                    $('#start_time' + tl_id).timepicker('setTime', null);
                    $('#break_time' + tl_id).val('');
                    $('#hours' + tl_id).val('');
                    if (data.isAssignedUserFree != 1) {} else {
                        if (CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard') {
                            if (type == 'continue' || ($('#create_another_task').is(":checked"))) {
                                $('#CS_title').val('');
                                $('#due_date').val('');
                                $('#CS_due_date').val('');
                                $('#estimated_hours').val('');
                                $('#is_recurring').prop('checked', false);
                                $('#is_bilable').prop('checked', false);
                                $('#hours').val('');
                                tinymce.activeEditor.setContent('');
                                $('#up_files').html('');
                                $('#cloud_storage_files_0').html('');
                                taskgrp = $('#CS_milestone').val();
                                assignto = $('#CS_assign_to').val();
                                creatask('', 'new', taskgrp, assignto);
                            } else {
                                $('#hiddensavennew').val('0');
                                $('#CS_start_date').val('');
                                $('#CS_due_date').val('');
                                crt_popup_close('only_cal');
                            }
                        }
                        if (data.pagename == "dashboard") {
                            if (type != 'continue' && ($('#projFil').val() != data.formdata)) {
                                updateAllProj('proj' + data.formdata, data.formdata, data.pagename, '0', data.projName);
                            }
                        } else {
                            if (pagename == 'onbording') {
                                window.location = HTTP_ROOT + "onbording";
                            } else if (pagename == 'getting_started') {
                                window.location = HTTP_ROOT + "getting_started";
                            } else if (pagename == 'resource_availability') {
                                window.location = HTTP_ROOT + "resource-availability/";
                            } else {
                                if (type == 'continue' || ($('#create_another_task').is(":checked"))) {
                                    $('#CS_title').val('');
                                    $('#due_date').val('');
                                    $('#estimated_hours').val('');
                                    $('#is_recurring').prop('checked', false);
                                    $('#is_bilable').prop('checked', false);
                                    $('#hours').val('');
                                    tinymce.activeEditor.setContent('');
                                    $('#up_files').html('');
                                    $('#cloud_storage_files_0').html('');
                                    $('#sendOptions').parent('div').removeClass('open');
                                    taskgrp = $('#selected_milestone').html();
                                    assignto = $('#tsk_asgn_to').html();
                                    creatask('', 'new', taskgrp, assignto);
                                } else {
                                    var rqUrl = document.URL;
                                    var n = rqUrl.indexOf("activities");
                                    if (n != -1) {
                                        redirectToDefaultView();
                                    } else {
                                        redirectToDefaultView();
                                    }
                                }
                            }
                        }
                    }
                    var CS_project_id = $(".prj-select").val();
                } else {
                    $('#postcomments' + CS_id).show();
                    $('#postcomments' + CS_id).find('.toglle_on_click').show();
                    $('#loadcomments' + CS_id).hide();
                    var prm = parseUrlHash(urlHash);
                    if (typeof prm[0] != 'undefined' && prm[0] == 'mentioned_list') {
                        loadMentionList('');
                    }
                    $('.rep_edit').hide();
                    append_case_reply(data.appendData, CS_id, data.curCaseId);
                    $('.tsk-dtl-reply-cnt-lbl small').text(parseInt($('.tsk-dtl-reply-cnt-lbl small').text()) + 1);
                    if (timelogparams != 'false') {
                        $('#start_time' + CS_id).val('');
                        $('#end_time' + CS_id).val('');
                        $('#break_time' + CS_id).val('');
                        $('#hours' + CS_id).val('');
                        ajaxTimeLogView('', '', '', CS_id);
                        var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
                        trackEventLeadTracker('Time Log', 'Task Detail Post Comment Page', sessionEmail);
                    }
                    tinymce.activeEditor.setContent('');
                    tinymce.activeEditor.save();
                    var priArr = ['High', 'Medium', 'Low'];
                    var prev_asgnUid = $('#asgnUsrdiv' + CS_id).find('input#hid_asgn_uid').val();
                    if (CS_assign_to != prev_asgnUid) {
                        $('#asgnUsrdiv' + CS_id).find('input#hid_asgn_uid').val(CS_assign_to);
                        for (var k in PUSERS) {
                            for (var y in PUSERS[k]) {
                                var usrDtls = PUSERS[k][y];
                                if (CS_assign_to == SES_ID) {
                                    $('#asgnUsrdiv' + CS_id).find('span#case_dtls_new' + CS_id).text('me');
                                    if (usrDtls.User.photo == '' || usrDtls.User.photo == null) {
                                        $('#asgnUsrdiv' + CS_id).find('span.cmn_profile_holder').addClass(usrDtls.User.asgnbgcolor).text(usrDtls.User.name.charAt(0)).attr('title', usrDtls.User.name + ' ' + usrDtls.User.last_name);
                                    } else {
                                        $('#asgnUsrdiv' + CS_id).find('.user-task-pf').html('<img src="' + HTTP_ROOT + 'users/image_thumb/?type=photos&file=' + usrDtls.User.photo + '&sizex=55&sizey=55&quality=100" class="" title="' + usrDtls.User.name + ' ' + usrDtls.User.last_name + '" width="55" height="55" />');
                                    }
                                    break;
                                } else if (CS_assign_to == 0) {
                                    $('#asgnUsrdiv' + CS_id).find('span#case_dtls_new' + CS_id).text('Unassigned');
                                    $('#asgnUsrdiv' + CS_id).find('span.cmn_profile_holder').addClass('unassign').text('U').attr('title', 'Unassigned');
                                    break;
                                } else if (usrDtls.User.id == CS_assign_to) {
                                    $('#asgnUsrdiv' + CS_id).find('span#case_dtls_new' + CS_id).html(shortLength(ucfirst(usrDtls.User.name + ' ' + usrDtls.User.last_name), 10));
                                    if (usrDtls.User.photo == '' || usrDtls.User.photo == null) {
                                        $('#asgnUsrdiv' + CS_id).find('span.cmn_profile_holder').addClass(usrDtls.User.asgnbgcolor).text(usrDtls.User.name.charAt(0)).attr('title', usrDtls.User.name + ' ' + usrDtls.User.last_name);
                                    } else {
                                        $('#asgnUsrdiv' + CS_id).find('.user-task-pf').html('<img src="' + HTTP_ROOT + 'users/image_thumb/?type=photos&file=' + usrDtls.User.photo + '&sizex=55&sizey=55&quality=100" class="" title="' + usrDtls.User.name + ' ' + usrDtls.User.last_name + '" width="55" height="55" />');
                                    }
                                    break;
                                }
                            }
                        }
                    }
                    $('#up_files' + CS_id).html('');
                    $('#cloud_storage_files_' + CS_id).html('');
                    if (data.depend_msg) {
                        showTopErrSucc('success', data.depend_msg);
                    } else {
                        showTopErrSucc('success', _('Your reply is posted.') + ' ' + (data.depend_message || ''));
                    }
                    refreshTasks = 1;
                    if (data.storage_used) {
                        var clr = 'red';
                        var max_storage = $("#max_storage").text().trim();
                        var lbl_storag = $("#storage_met").text().trim();
                        var new_storag = '';
                        if (parseInt(data.storage_used_gb) == 0 || parseInt(data.storage_used_gb) > 0) {
                            new_storag = "<span id='used_storage'>" + data.storage_used_gb + "</span> GB";
                        } else {
                            new_storag = "<span id='used_storage'>" + data.storage_used + "</span> MB";
                        }
                        if (lbl_storag == 'GB') {
                            var t_storage = parseInt(max_storage) * 1024;
                            if (max_storage == 'Unlimited' || (parseFloat(data.storage_used) < parseFloat(t_storage))) {
                                clr = '#333';
                            }
                        } else {
                            if (max_storage == 'Unlimited' || (parseFloat(data.storage_used) < parseFloat(max_storage))) {
                                clr = '#333';
                            }
                        }
                        var str = "<font style='color:" + clr + "'>" + new_storag + "/<b><span id='max_storage'>" + max_storage + "</span></b><span id='storage_met'> " + lbl_storag + "</span></font>";
                        $("#storage_spn").html(str);
                    }
                    try {
                        if (!CS_legend) {
                            $('#actionCls' + cnt).val(2);
                        } else {
                            $('#actionCls' + cnt).val(CS_legend);
                        }
                        var actionChk = "actionChk" + cnt;
                        if (postdata == "Post") {
                            var xdata = $('#' + actionChk).val();
                            var exdt = xdata.split("|");
                            if (exdt[2] == "closed") {
                                $("#" + actionChk).removeAttr('disabled');
                                $("#" + actionChk).removeAttr('checked');
                            }
                        } else {
                            document.getElementById(actionChk).disabled = true;
                            document.getElementById(actionChk).checked = true;
                        }
                    } catch (e) {}
                    var project_id = "CS_project_id" + CS_id;
                    var CS_project_id = $(".prj-select").val();
                    $.post(HTTP_ROOT + "easycases/update_assignto", {
                        "caseId": CS_id
                    }, function(res) {
                        if (res) {
                            $('#showUpdAssign' + CS_id).html(res);
                        }
                    });
                    var caseMenuFilters = $('#caseMenuFilters').val();
                    var url = HTTP_ROOT + "requests/ajax_case_status";
                    var case_date = $("#caseDateFil").val();
                    var caseStatus = $("#caseStatus").val();
                    var caseTypes = $("#caseTypes").val();
                    var caseLabel = $("#caseLabel").val();
                    var caseMember = $("#caseMember").val();
                    var caseComment = $("#caseComment").val();
                    var caseAssignTo = $("#caseAssignTo").val();
                    var caseSearch = $("#case_search").val();
                    var priFil = $("#priFil").val();
                    var milestoneIds = $("#milestoneIds").val();
                    var checktype = $("#checktype").val();
                    $.post(url, {
                        "projUniq": CS_project_id,
                        "pageload": 1,
                        "caseMenuFilters": caseMenuFilters,
                        'case_date': case_date,
                        'caseStatus': caseStatus,
                        'caseLabel': caseLabel,
                        'caseTypes': caseTypes,
                        'priFil': priFil,
                        'caseMember': caseMember,
                        'caseComment': caseComment,
                        'caseAssignTo': caseAssignTo,
                        'caseSearch': caseSearch,
                        'milestoneIds': milestoneIds,
                        'checktype': checktype
                    }, function(data) {
                        if (data) {
                            $('#ajaxCaseStatus').html(tmpl("case_widget_tmpl", data));
                            $('[rel=tooltip], #main-nav span, .loader').tipsy({
                                gravity: 's',
                                fade: true
                            });
                            $('.tooltip_widget').tipsy({
                                gravity: 'e',
                                fade: true
                            });
                            $('.close-widget').click(function() {
                                $(this).parent().fadeTo(350, 0, function() {
                                    $(this).slideUp(600);
                                });
                                return false;
                            });
                            if (document.getElementById('reset_btn').style.display != 'none') {
                                $('#upperDiv_alert').fadeIn();
                                setTimeout(removeMsg_alert, 6000);
                            } else {
                                $('#upperDiv_alert').fadeOut();
                            }
                        }
                    });
                }
                if (data.isAssignedUserFree != 1 && data.isAssignedUserFree != null) {
                    CS_start_date = typeof data.reply_strt_date != 'undefined' ? data.reply_strt_date : CS_start_date;
                    CS_due_date = typeof data.reply_due_date != 'undefined' ? data.reply_due_date : data.due_date;
                    est_hours = (typeof data.estimated_hours != 'undefined') ? data.estimated_hours : est_hours;
                    data.caseid = typeof data.reply_caseId != 'undefined' ? data.reply_caseId : data.caseid;
                    data.caseUniqId = typeof data.reply_caseUniqId != 'undefined' ? data.reply_caseUniqId : data.caseUniqId;
                    openResourceNotAvailablePopup(CS_assign_to, CS_start_date, CS_due_date, est_hours, data.projId, data.caseid, data.caseUniqId, data.isAssignedUserFree);
                }
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
                            'is_client': is_client
                        });
                    }
                }
                if (data.caseNo) {
                    var url_ajax = strURL + "ajaxemail";
                    $.post(url_ajax, {
                        'projId': data.projId,
                        'emailUser': emailUser,
                        "allfiles": data.allfiles,
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
                        'is_client': is_client
                    });
                }
                check_proj_size();
                if (client) {
                    client.emit('iotoserver', data.iotoserver);
                }
            }
            var projUpdateTop = $("#projUpdateTop").html();
            $('#defaultmem').show();
            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
            var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
            var event_name = sessionStorage.getItem('SessionStorageEventValue');
            if (eventRefer && event_name) {
                trackEventLeadTracker(event_name, eventRefer, sessionEmail);
            }
            $("#start_date").datepicker("setEndDate", '+' + eval(365 * 7) + 'd');
            var new_url = localStorage.getItem("last_url");
            if (typeof new_url != 'undefiend' && new_url != '') {
                history.pushState({}, null, new_url);
            }
        }, 'json').fail(function(xhr, textStatus, errorThrown) {
            $('#quickloading').hide();
            if (newchkpt == 0) {
                newchkpt = 1;
                submitAddNewCase(postdata, CS_id, uniqid, cnt, dtls, status, prelegend, pid, type, 'repost');
            }
        });
        return false;
    } else {
        return false;
    }
}

function append_case_reply(data, CS_id, curCaseId) {
    var params = parseUrlHash(urlHash);
    var thrd_sort_ordr = getCookie('REPLY_SORT_ORDER');
    var no_of_thrds = $("#showhidemorereply" + CS_id).find('div.user-task-info').length;
    totalReplies = parseInt(totalReplies) + 1;
    if (thrd_sort_ordr == 'ASC') {
        var count = $("#showhidemorereply" + CS_id).children('div.user-task-info:first').find('.badge').text();
    } else {
        count = $("#showhidemorereply" + CS_id).children('div.user-task-info:last').find('.badge').text();
    }
    if ($(".added-task-file").length == 1) {
        for (var k in data.threadDetails) {
            if (data.threadDetails[k].Easycase.rply_files.length) {
                $(".nofiletxt").hide();
                var exit_file_cnt = parseInt($(".btn-file").text().replace("Files", "").replace('File', ''));
                exit_file_cnt = parseInt(exit_file_cnt) + parseInt(data.threadDetails[k].Easycase.rply_files.length);
                if (exit_file_cnt > 1) {
                    $(".btn-file").html(exit_file_cnt + " " + _("Files"));
                } else {
                    $(".btn-file").html(exit_file_cnt + " " + _("File"));
                }
            }
        }
        $(".added-task-file").prepend(tmpl("case_detail_right_files_tmpl", data));
    }
    if (parseInt(count) == 10) {
        easycase.refreshTaskList(params[1]);
    } else {
        count = count != '' ? parseInt(count) + 1 : '1';
        if ($("#showhidemorereply" + CS_id).length == 0) {
            if ($('#tab-1' + data.threadDetails.curCaseDtls.caseUniqId).length) {
                $('#tab-1' + data.threadDetails.curCaseDtls.caseUniqId).html('<div class="user-comment"><div class="col-lg-4 col-sm-4"><h4>' + _('Comments') + '</h4></div><div class="cb"></div><div class="reply_cont_bg" id="reply_content' + CS_id + '"><div id="showhidemorereply' + CS_id + '"></div></div></div>');
            } else if ($('#t_' + params[1]).find("#case_link_task" + CS_id).length) {
                $('#t_' + params[1]).find("#case_link_task" + CS_id).after('<div class="user-comment"><div class="col-lg-4 col-sm-4"><h4>' + _('Comments') + '</h4></div><div class="cb"></div><div class="reply_cont_bg" id="reply_content' + CS_id + '"><div id="showhidemorereply' + CS_id + '"></div></div></div>');
            } else {
                $('#t_' + params[1]).find('.user-ans-section').after('<div class="user-comment"><div class="col-lg-4 col-sm-4"><h4>' + _('Comments') + '</h4></div><div class="cb"></div><div class="reply_cont_bg" id="reply_content' + CS_id + '"><div id="showhidemorereply' + CS_id + '"></div></div></div>');
            }
            $("#showhidemorereply" + CS_id).children('div:last').prev('div').find('div.rep_edit').remove();
            $("#showhidemorereply" + CS_id).append(tmpl("case_thread_tmpl", data));
            $("#showhidemorereply" + CS_id).children('div.user-task-info:last').find('.badge').text(parseInt(count));
            $("#showhidemorereply" + CS_id).children('div.user-task-info:last').attr('id', 'rep' + count);
        } else {
            var no_of_thrd = data.total - 1;
            if (thrd_sort_ordr == 'DESC' && no_of_thrd < 10) {
                $("#showhidemorereply" + CS_id).children('div:last').prev('div').find('div.rep_edit').remove();
                $("#showhidemorereply" + CS_id).append(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').attr('id', 'rep' + count);
            } else if (thrd_sort_ordr == 'DESC' && no_of_thrd >= 10) {
                $("#showhidemorereply" + CS_id).find('div.user-task-info:first').remove();
                $("#showhidemorereply" + CS_id).children('div:last').prev('div').find('div.rep_edit').remove();
                $("#showhidemorereply" + CS_id).append(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').attr('id', 'rep' + count);
            } else if (thrd_sort_ordr == 'ASC' && no_of_thrd < 10 && no_of_thrd != 0) {
                $("#showhidemorereply" + CS_id).children('div:first').prev('div').find('div.rep_edit').remove();
                $("#showhidemorereply" + CS_id).children('div:first').before(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').attr('id', 'rep' + count);
            } else if (thrd_sort_ordr == 'ASC' && no_of_thrd >= 10) {
                $("#showhidemorereply" + CS_id).find('div.user-task-info:last').remove();
                $("#showhidemorereply" + CS_id).children('div:first').prev('div').find('div.rep_edit').remove();
                $("#showhidemorereply" + CS_id).children('div:first').before(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').attr('id', 'rep' + count);
            } else if (thrd_sort_ordr == 'ASC' && no_of_thrd == 0) {
                $("#showhidemorereply" + CS_id).html('');
                $("#showhidemorereply" + CS_id).append(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:first').attr('id', 'rep' + count);
            } else {
                $("#showhidemorereply" + CS_id).children('div:last').prev('div').find('div.rep_edit').remove();
                $("#showhidemorereply" + CS_id).prepend(tmpl("case_thread_tmpl", data));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').find('.badge').text(parseInt(count));
                $("#showhidemorereply" + CS_id).children('div.user-task-info:last').attr('id', 'rep' + count);
            }
            var cmntcnt = $('.comments_item ').length;
            $('#cmnt_count').text(cmntcnt);
            $('#showhtml' + CS_id).show();
            $('#cmt_sec_dis').hide();
        }
        if ($(".reply_cont_bg").length) {
            $(".reply_cont_bg").animate({
                scrollTop: $('.reply_cont_bg').prop("scrollHeight")
            }, 1000);
        }
        $("img.lazy").each(function() {
            $(this).attr('src', $(this).attr('data-original'));
        });
        $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'normal',
            autoplay_slideshow: false,
            social_tools: false,
            overlay_gallery: false,
            deeplinking: false
        });
    }
}

function blur_txt() {
    $("#CS_title").css({
        color: "#666666"
    });
    if ($("#CS_title").val() == "") {
        $("#CS_title").parent('div').removeClass('mv-label-up');
    }
    if ($("#CS_title").val() != "Add a task here and hit enter..." || $("#CS_title").val() != _("Add a task here and hit enter") + "...") {
        $("#CS_title").css({
            color: "#000000"
        });
    }
}

function checkAllProj() {
    var projFil = $('#CS_project_id').val();
    if (projFil == 'all') {
        $('#projAllmsg').show();
        return false;
    } else {
        $('#projAllmsg').hide();
        return true;
    }
}

function focus_txt() {
    $("#CS_title").css({
        color: "#000"
    });
    if ($("#CS_title").val() == "Add a task here and hit enter..." || $("#CS_title").val() == _("Add a task here and hit enter") + "...") {
        $("#CS_title").val("");
    }
}

function onEnterPostCase(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode == 13 && !$('#quickloading').is(':visible')) {
        submitAddNewCase('Post', 0, '', '', '', 1, '');
    }
}

function checktitle_value() {
    var tasktitle = $.trim($('#CS_title').val());
    if (tasktitle == "" || tasktitle == "Add a task here and hit enter..." || tasktitle == _("Add a task here and hit enter") + "...") {} else {
        $('#CS_title').css('border-color', '');
    }
}

function check_proj_size() {
    if ($('#add_new_popup').is(":visible")) {
        var sizeUrl = HTTP_ROOT + "easycases/";
        $.post(sizeUrl + "ajax_check_size", {
            "check": 'size'
        }, function(data) {
            if (data) {
                $("#ajax_check_size").html(data);
                var isExceed = $("#isExceed").val();
                $("#usedstorage").val($("#storageusedqc").val());
            }
        });
    }
}

function search_project_easypost(val, e) {
    var key = e.keyCode;
    if (key == 13)
        return;
    var menu_div_id = 'ajaxbeforesrchc';
    if ($('#ajaxaftersrchc').is(":visible")) {
        var menu_div_id = 'ajaxaftersrchc';
        $('#ajaxbeforesrchc > li').removeClass('popup_selected');
    }
    if (e.keyCode == 40 || e.keyCode == 38) {
        if (key == 40) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':last-child')) {
                $current = $('#ajaxaftersrchc > a').eq(0);
            } else {
                if ($('#' + menu_div_id + '> a').hasClass('popup_selected')) {
                    $current = $('#' + menu_div_id + '> a').filter('.popup_selected').next('hr').next('a');
                } else {
                    $current = $('#' + menu_div_id + ' > a').eq(0);
                }
            }
        } else if (key == 38) {
            if (!$('#' + menu_div_id + ' > a').length || $('#' + menu_div_id + '> a').filter('.popup_selected').is(':first-child')) {
                $current = $('#' + menu_div_id + ' > a').last('a');
            } else {
                $current = $('#' + menu_div_id + ' > a').filter('.popup_selected').prev('hr').prev('a');
            }
        }
        $('#' + menu_div_id + ' > a').removeClass('popup_selected');
        $current.addClass('popup_selected');
    } else {
        var strURL = HTTP_ROOT;
        strURL = strURL + "users/";
        if (val != "") {
            $('#load_find_addtask').show();
            $.post(strURL + "search_project_menu", {
                "val": val
            }, function(data) {
                if (data) {
                    $('#ajaxaftersrchc').show();
                    $('#ajaxbeforesrchc').hide();
                    $('#ajaxaftersrchc').html(data);
                    $('#load_find_addtask').hide();
                }
            });
        } else {
            $('#ajaxaftersrchc').hide();
            $('#ajaxbeforesrchc').show();
            $('#load_find_addtask').hide();
        }
    }
}

function createCookie(name, value, days, domain) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else
        expires = "";
    if (domain)
        var domain = " ; domain=" + DOMAIN_COOKIE;
    else
        var domain = '';
    document.cookie = name + "=" + value + expires + "; path=/" + domain;
}

function delete_cookie(name) {
    createCookie(name, "", -365, DOMAIN_COOKIE);
}

function removeFile(id, div, storage) {
    var x = $('#' + id).val();
    $('#' + id).val('');
    var strURL = HTTP_ROOT + "easycases/";
    if (storage) {
        var usedstorage = $("#usedstorage").val();
        var newstorage = usedstorage - storage;
        $("#usedstorage").val(newstorage);
    }
    $.post(strURL + "fileremove", {
        "filename": x
    }, function(data) {
        if (data) {}
    });
    $('#' + div).parent().parent().remove();
}

function hideEditFile(id, div, storage, caseFileId) {
    var x = $('#' + id).val();
    $('#' + id).val('');
    var strURL = HTTP_ROOT + "easycases/";
    if (storage) {
        var usedstorage = $("#usedstorage").val();
        var newstorage = usedstorage - storage;
        $("#usedstorage").val(newstorage);
    }
    var remfile = $('#editRemovedFile').val();
    if (remfile) {
        $('#editRemovedFile').val(remfile + "," + caseFileId);
    } else {
        $('#editRemovedFile').val(caseFileId);
    }
    $('#' + div).parent().parent().hide();
}

function removefiledirect(casefileid, caseid, caseuniqid, caseno) {
    var conf = confirm(_("Are you sure, You want to delete this file?"));
    if (conf) {
        $("#caseLoader").show();
        var url = HTTP_ROOT + "easycases/remove_file_from_detail";
        $.post(url, {
            'casefileid': casefileid,
            'caseid': caseid
        }, function(res) {
            $("#caseLoader").hide();
            if (res.msg == 'success') {
                showTopErrSucc('success', _('File has been removed.'));
                var exit_file_cnt = parseInt($(".btn-file").text().replace("Files", "").replace('File', '').replace(_("Files"), "").replace(_('File'), ''));
                exit_file_cnt = parseInt(exit_file_cnt) - 1;
                if (exit_file_cnt > 1) {
                    $(".btn-file").html(exit_file_cnt + " " + _("Files"));
                } else {
                    $(".btn-file").html(exit_file_cnt + " " + _("File"));
                }
                if ($(".atachment_" + casefileid).closest('.create_reply_comment').length > 0) {
                    var text = $(".atachment_" + casefileid).closest('.create_reply_comment').find('.atachment_det:visible').length;
                    text = parseInt(text) - 1;
                    if (text != 0) {
                        var t = (text == 1) ? text + ' ' + _('File') : text + ' ' + _('Files');
                        $(".atachment_" + casefileid).closest('.create_reply_comment').find('.attach_cnt').html(t);
                    } else {
                        $(".atachment_" + casefileid).closest('.create_reply_comment').find('.attachment_wrap').hide();
                    }
                }
                if ($(".atachment_" + casefileid).closest('.details_task_desc').length > 0) {
                    var text = $(".atachment_" + casefileid).closest('.details_task_desc').find('.atachment_det:visible').length;
                    text = parseInt(text) - 1;
                    if (text != 0) {
                        var t = (text == 1) ? text + ' ' + _('Attachment') : text + ' ' + _('Attachments');
                        $(".atachment_" + casefileid).closest('.details_task_desc').find('.attach_cnt').html(t);
                    } else {
                        $(".atachment_" + casefileid).closest('.details_task_desc').find('.attachment_wrap').hide();
                    }
                }
                $(".atachment_" + casefileid).remove();
            } else if (res.msg == 'fail') {
                showTopErrSucc('error', _('Sorry, File con not be deleted.'));
            }
        }, 'json').always(function() {
            actiononTask(caseid, caseuniqid, caseno, 'removeFile');
        });
    } else {
        return false;
    }
}

function cancelReplyFile(file_name) {
    if (reply_total_files.length) {
        reply_total_files.pop(file_name);
    }
    if (reply_total_files.length == 0) {
        gFileupload = 1;
    }
    if ($('.cls_to_check_fl_upload').length == 0 || $('.cls_to_check_fl_upload').length == 1) {
        gFileupload = 1;
    }
}

function removefile() {
    open_pop(this);
    var pjid = $('#pjid').val();
    var count = $("#all").val();
    var val = new Array();
    for (var i = 1; i <= count; i++) {
        if (document.getElementById("file" + i).checked == true) {
            val.push($("#file" + i).val());
        }
    }
    var url = HTTP_ROOT + "archives/file_remove";
    if (val.length != '0') {
        if (confirm(_("Are you sure you want to remove?"))) {
            $('#caseLoader').show();
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    showTopErrSucc('success', _('File is removed.'));
                    var url = HTTP_ROOT + "archives/file_list";
                    $.post(url, {
                        "pjid": pjid
                    }, function(data) {
                        if (data) {
                            $('#caseLoader').hide();
                            $('#filelistall').html(data);
                        }
                    });
                }
            });
        }
    } else {
        alert(_("No file selected!"));
    }
}

function checkedAllRes() {
    var ids = $('#userIds').val();
    ids = ids.split(',');
    var names = $('#userNames').val();
    names = names.split(',');
    $('#more_opt12').html('');
    if ($('#chked_all').prop("checked")) {
        $('.viewmemdtls_cls').show();
        $('.notify_cls').prop("checked", true);
        if ($('#make_client').prop("checked")) {
            $('.chk_client').prop("checked", false);
        } else {
            $('.chk_client').prop("checked", true);
        }
    } else {
        $('.notify_cls').prop("checked", false);
        $('.chk_client').prop("checked", false);
    }
}

function removeAll() {
    if (!$('input.notify_cls[type=checkbox]:not(:checked)').length) {
        $('#chked_all').prop("checked", true);
    } else {
        $('#chked_all').prop("checked", false);
    }
}

function removeAllReply(CS_id) {
    if (!($('input.chk_fl[type=checkbox]:not(:checked)').length - 1)) {
        if (!$('#' + CS_id + 'chkAllRep').is(':checked')) {
            $('#' + CS_id + 'chkAllRep').prop('checked', true);
        }
    } else {
        $('#' + CS_id + 'chkAllRep').prop('checked', false);
    }
}

function selectuserreply(csid, usrname, uid) {
    if ($('#' + csid + 'chk_' + uid).is(":checked")) {
        $('#viewmemdtls' + csid).append("<div id='" + uid + "name' class ='fl notify-name ttfont' rel='tooltip' title='" + usrname + "'><span class='fl gr'>" + shortLength(ucfirst(usrname, 15)) + "</span><div id ='close" + uid + "' class='notify-close fl' style='cursor:pointer;' onclick='closeNotifyName(" + csid + "," + uid + ")'><span> x </span></div><div class='cb'></div></div>");
    } else {
        closeNotifyName(csid, uid);
    }
}

function showHideMemDtls(cls) {
    if ($('.' + cls).css('display') == 'none') {
        $('.' + cls).slideDown(200);
    } else {
        $('.' + cls).slideUp(200);
    }
    $('#defaultmem').slideUp();
}

function show_prjlist(event) {
    if ($('.more_opt').find('ul').is(":visible")) {
        $('.more_opt').find('ul').hide();
    }
    event.preventDefault();
    event.stopPropagation();
    $('#openpopup,#openpopup_v2').toggle();
    $('#ajaxbeforesrchc').show();
    $('#ctask_input_id').focus();
}
$(document).ready(function(event) {
    $(document).click(function(e) {
        $('#openpopup').hide();
        $('#mlstnpopup').hide();
    });
    $("#switch_mlstn").click(function(event) {
        event.stopPropagation();
    });
});

function showProjectName(name, id, mid, tskgrp, assignto, d_date) {
    $('#prjchange_loader').show();
    $('#ctask_popup a').css({
        'border-color': '#CCCCCC'
    });
    var pname_ttl = name;
    if (pname_ttl.length > 30) {
        pname_ttl = pname_ttl.substr(0, 27) + '...';
    }
    $('#projUpdateTop').html(pname_ttl);
    $('#projUpdateTop').attr('title', name);
    $('#CS_project_id').val(id);
    $('#openpopup').hide();
    $('#projAllmsg').hide();
    $('#curr_active_project').val(id);
    if (countJS(PUSERS) && PUSERS[id]) {
        dassign = {};
        var url = HTTP_ROOT + "easycases/ajax_quickcase_mem";
        $.post(url, {
            "projUniq": id,
            "pageload": 0
        }, function(data) {
            if (data) {
                PUSERS = data.quickMem;
                defaultAssign = data.defaultAssign;
                dassign = data.dassign;
                if (assignto != '') {
                    $(".assign-to-fld").find('select.crtskasgnusr').val(assignto);
                    $('.crtskasgnusr').trigger('change');
                } else {
                    case_quick();
                    if (d_date != '' && typeof d_date != 'undefined') {
                        $('#due_date').val(d_date);
                        $('#CS_due_date').val(moment(d_date).format('MM/DD/YYYY'));
                    }
                }
            }
        });
        $('#prjchange_loader').hide();
        $('#caseLoader').hide();
    } else {
        var url = HTTP_ROOT + "easycases/ajax_quickcase_mem";
        $.post(url, {
            "projUniq": id,
            "pageload": 0
        }, function(data) {
            if (data) {
                PUSERS = data.quickMem;
                defaultAssign = data.defaultAssign;
                dassign = data.dassign;
                case_quick();
                if (d_date != '' && typeof d_date != 'undefined') {
                    $('#due_date').val(d_date);
                    $('#CS_due_date').val(moment(d_date).format('MM/DD/YYYY'));
                }
                $('#prjchange_loader').hide();
                $('#caseLoader').hide();
            }
        });
    }
    if (mid != '') {
        if ($('#miview_' + mid).text() != '') {
            milstoneonTask($('#miview_' + mid).text(), mid);
        } else {
            milstoneonTask($('#main-title-holder_' + mid + ' a').text(), mid);
        }
    } else {
        if (tskgrp != '') {
            $('.taskgp-drop').find('select.crtskgrp').val(tskgrp);
        } else {
            milstoneonTask();
        }
    }
}

function showProjectNameNew(name, id, mid, tskgrp, assignto, d_date) {
    $('#caseLoader').show();
    $('#ctask_popup a').css({
        'border-color': '#CCCCCC'
    });
    var pname_ttl = name;
    if (pname_ttl.length > 30) {
        pname_ttl = pname_ttl.substr(0, 27) + '...';
    }
    $('#openpopup').hide();
    $('#projAllmsg').hide();
    if (countJS(PUSERS) && PUSERS[id]) {
        dassign = {};
        var url = HTTP_ROOT + "easycases/ajax_quickcase_mem";
        var default_assign = '';
        var default_assign = $('#leave_user_id').val();
        $.post(url, {
            "projUniq": id,
            "pageload": 0,
            "default_assign": default_assign
        }, function(data) {
            if (data) {
                PUSERS = data.quickMem;
                defaultAssign = data.defaultAssign;
                defaultTskTyp = data.defaultTaskType;
                dassign = data.dassign;
                if (assignto != '') {
                    $(".assign-to-fld").find('select.crtskasgnusr').val(assignto);
                    $('.crtskasgnusr').trigger('change');
                } else {
                    case_quick();
                    if (d_date != '' && typeof d_date != 'undefined') {
                        $('#due_date').val(d_date);
                        $('#CS_due_date').val(moment(d_date).format('MM/DD/YYYY'));
                    }
                }
            }
        });
        $('#caseLoader').hide();
    } else {
        var url = HTTP_ROOT + "easycases/ajax_quickcase_mem";
        $.post(url, {
            "projUniq": id,
            "pageload": 0
        }, function(data) {
            if (data) {
                PUSERS = data.quickMem;
                defaultAssign = data.defaultAssign;
                defaultTskTyp = data.defaultTaskType;
                dassign = data.dassign;
                case_quick();
                if (d_date != '' && typeof d_date != 'undefined') {
                    $('#due_date').val(d_date);
                    $('#CS_due_date').val(moment(d_date).format('MM/DD/YYYY'));
                }
                $('#caseLoader').hide();
            }
        });
    }
    var pm_method = $(".prj-select option[value=" + id + "]").attr("data-methodlogy");
    $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Task Group'));
    $.post(HTTP_ROOT + 'milestones/fetchTaskItemOptions', {
        'projUniq': id
    }, function(res) {
        if (res.milestones_status) {
            $('.taskgp-drop').find('ul li').remove();
            $('.crtskgrp option').remove();
            if (pm_method == 2) {
                $('.crtskgrp').append('<option value="0">' + _('Backlog') + '</option>');
                $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Sprint'));
            } else {
                $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
            }
            var is_tg_exist = 0;
            $.each(res.milestones, function(key, value) {
                $('.crtskgrp').append('<option value="' + key + '">' + ucfirst(formatText(value)) + '</option>');
                if (tskgrp == key) {
                    is_tg_exist = 1;
                }
            });
            if (mid != '') {
                $('.crtskgrp').find('option[value="' + mid + '"]').attr("selected", "selected");
                $('.taskgp-drop').find('select').val(mid);
                $('#CS_milestone').val(mid);
            } else {
                if ($('#create_another_task').is(":checked") && tskgrp != '' && is_tg_exist) {
                    is_tg_exist = 0;
                    $('.crtskgrp').find('option[value="' + tskgrp + '"]').attr("selected", "selected");
                    $('.taskgp-drop').find('select').val(tskgrp);
                    $('#CS_milestone').val(tskgrp);
                } else {
                    $('.crtskgrp').find('option[value="0"]').attr("selected", "selected");
                    $('.taskgp-drop').find('select').val(0);
                    $('#CS_milestone').val('');
                }
            }
            addTaskEvents();
        } else {
            $('.taskgp-drop').find('ul li').remove();
            $('.crtskgrp option').remove();
            if (pm_method == 2) {
                $('.crtskgrp').append('<option value="0">' + _('Backlog') + '</option>');
                $("#tour_crt_tskgrp").find("label[for='crtskgrp_id']").text(_('Sprint'));
            } else {
                $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
            }
            $('.crtskgrp').find('option[value="0"]').attr("selected", "selected");
            $('#CS_milestone').val('');
        }
        $("#custom_field_container").html(tmpl("case_customfield_tmpl", res.custom_fields));
        custom_date_field();
        if (res.labels_status) {
            $('.label-to-select option').remove();
            $.each(res.labels, function(key, value) {
                $('.label-to-select').append('<option value="' + key + '">' + ucfirst(formatText(value)) + '</option>');
            });
        } else {
            $('.label-to-select option').remove();
            $('.label-to-select').append('<option value="">Select</option>');
        }
    }, 'json');
    $(".link-to-select").select2({
        width: '100%',
        allowClear: true,
        ajax: {
            url: HTTP_ROOT + 'requests/getNewLinkTasks',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    'searchTerm': params.term,
                    'project_id': id
                }
            },
            processResults: function(data) {
                if (data.status) {
                    return {
                        results: $.map(data.task, function(obj) {
                            return {
                                id: (obj.id),
                                text: (obj.text)
                            };
                        })
                    };
                } else {
                    return "No data found";
                }
            },
            cache: true
        },
    });
    setStartDueDt();
}

function opencase(type) {
    $("#new_case_more_div").slideDown();
    $("#more_tsk_opt_div").hide();
    $("#less_tsk_opt_div").show();
}

function scrolltop() {
    scrollPageTop();
}

function scrollPageTop(el) {
    if (typeof el !== 'undefined' && el) {
        $('html, body').animate({
            scrollTop: el.offset().top - 100
        }, 1000);
    } else {
        $('html, body').animate({
            scrollTop: 0
        });
    }
}

function scrollDtlPageTop(el) {
    if (typeof el !== 'undefined' && el) {
        $('.modal-taskdetal-pop-up').animate({
            scrollTop: el.offset().top - 100
        }, 1000);
    } else {
        $('.modal-taskdetal-pop-up').animate({
            scrollTop: 0
        });
    }
}

function removePubnubMsg() {
    $('#punnubdiv').fadeOut(300);
    $("#pub_counter").val(0);
    $("#hid_casenum").val(0);
    ioMsgClicked = 1;
    hash = getHash().split('/');
    if (hash[0] != 'details') {}
}

function reloadTasks() {
    easycase.refreshTaskList();
}

function notify(title, desc) {
    console.log('DESK_NOTIFY: ' + DESK_NOTIFY);
    if (DESK_NOTIFY) {
        var returnvalue = notifyMe(title, desc, HTTP_IMAGES + 'logo/orangescrum-200-200.png');
        if (window.webkitNotifications && returnvalue == 1) {
            var havePermission = window.webkitNotifications.checkPermission();
            console.log('Chrome Permission: ' + havePermission);
            if (havePermission == 0) {
                var notification = window.webkitNotifications.createNotification(HTTP_IMAGES + 'logo/orangescrum-200-200.png', title, desc);
                notification.onclick = function() {
                    try {
                        window.focus();
                        removePubnubMsg();
                        notification.cancel();
                    } catch (e) {}
                };
                setTimeout(function() {
                    try {
                        notification.cancel();
                    } catch (e) {}
                }, 10000);
                notification.show();
            } else {
                window.webkitNotifications.requestPermission();
            }
        }
    }
}

function allowChromeDskNotify(check) {
    if ((DESK_NOTIFY || check) && window.webkitNotifications && window.webkitNotifications.checkPermission() != 0) {
        window.webkitNotifications.requestPermission();
    }
}

function getImNotifyMsg(projShName, caseNum, caseTtl, caseTyp) {
    var action = '';
    switch (caseTyp) {
        case 'NEW':
            action = _("New Task Created");
            break;
        case 'UPD':
            action = _("Task Updated");
            break;
        case 'ARC':
            action = _("Task Archived");
            break;
        case 'DEL':
            action = _("Task Deleted");
            break;
        default:
            action = _("New Notification");
    }
    return action + ': ' + projShName + '# ' + caseNum + ' - ' + caseTtl;
}

function notifyMe(title, desc, icon) {
    if (!("Notification" in window)) {
        console.log(_("Browser doesn't support"));
    } else if (Notification.permission === "granted") {
        var notification = new Notification(title, {
            body: desc,
            icon: icon
        });
        console.log(title + desc + icon);
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }
            if (permission === "granted") {
                var notification = new Notification(title, {
                    body: desc,
                    icon: icon
                });
                console.log("2 - " + title + desc + icon);
            } else {
                console.log(_("Notification Didn't work"));
                return 0;
            }
        });
    } else {
        console.log("Notification Didn't work");
        return 0;
    }
    return 1;
}

function numericDecimal(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode < 9 || unicode > 9 && unicode < 46 || unicode > 57 || unicode == 47) {
            if (unicode == 37 || unicode == 38) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function numericDecimalProj(e) {
    if ($(e.target).val() != '' && !$(e.target).val().match(/^[0-9.]+$/)) {
        $(e.target).val('');
        return false;
    }
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode < 9 || unicode > 9 && unicode <= 46 || unicode > 57 || unicode == 47) {
            if (unicode == 37 || unicode == 38) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function numeric_decimal_colon(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode < 9 || unicode > 9 && unicode < 46 || unicode > 57 || unicode == 47 || unicode == 186 || unicode == 58) {
            if (unicode == 37 || unicode == 38 || unicode == 186 || unicode == 58) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function numeric_only(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode != 8) {
        if (unicode >= 48 && unicode <= 59) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function mins_validation(obj) {
    var req_mins = obj.value.split(":");
    if (req_mins['1'] > 59) {
        $(obj).val('');
        var id = $(obj).attr('id');
        $('#' + id).focus();
        showTopErrSucc('error', _("Minute can not be greater then 59"));
    }
}

function notified_users(uid, name) {
    $(".timelog_block").show();
    $(".timelog_toggle_block").show();
    if ($('#chk_' + uid).is(":checked")) {} else {
        if ($("#make_client").is(":checked")) {
            var clients = $("#client").val();
            clients = clients.split(',');
            for (var i = 0; i <= clients.length; i++) {
                if (uid == clients[i]) {
                    var count = 1;
                    break;
                } else {
                    count = 0;
                }
            }
            if (count == 0) {
                if ($('#chk_' + uid).is(':checked')) {} else {
                    $('#more_opt12').append("<div class='user_div fl'><span id='user" + uid + "' style='padding:5px;color:white;'>" + ucfirst(name) + "</span><span class='close' style='margin-left:5px;color:white;font-weight:bold;padding:5px;cursor:pointer;' onclick='closeuser(" + uid + ")'>x</span></div>");
                    $('#chk_' + uid).attr('checked', 'checked');
                }
            }
        } else {
            $('#more_opt12').append("<div class='user_div fl'><span id='user" + uid + "' style='padding:5px;color:white;'>" + ucfirst(name) + "</span><span class='close' style='margin-left:5px; font-weight:bold;padding:5px;cursor:pointer;color:white;' onclick='closeuser(" + uid + ")'>x</span></div>");
            $('#chk_' + uid).attr('checked', 'checked');
        }
    }
    removeAll();
}

function notifi_cq_users(obj) {
    var uid = $(obj).val();
    if ($('#chk_' + uid).is(":checked")) {} else {
        if ($("#make_client").is(":checked")) {
            var clients = $("#client").val();
            clients = clients.split(',');
            for (var i = 0; i <= clients.length; i++) {
                if (uid == clients[i]) {
                    var count = 1;
                    break;
                } else {
                    count = 0;
                }
            }
            if (count == 0) {
                if ($('#chk_' + uid).is(':checked')) {} else {
                    $('#chk_' + uid).prop('checked', 'checked');
                }
            }
        } else {
            $('#chk_' + uid).prop('checked', true);
        }
    }
    removeAll();
}

function closeli(id) {
    $('#close' + id + '').parent('li').remove();
}

function check_priority(obj) {
    $(obj).find('input:radio').attr('checked', 'checked');
    var pvalue = $(obj).find('input:radio').val();
    $("#CS_priority").val(pvalue);
}

function closecase() {
    $("#new_case_more_div").slideUp(200);
    $("#more_tsk_opt_div").show();
    $("#less_tsk_opt_div").hide();
    scrollPageTop();
}
function open_more_opt(more_opt) {
    var sid = arguments[1];
    if (typeof(sid) != 'undefined') {
        $('.more_opt').filter(':not(#' + more_opt + sid + ')').children('ul').hide();
        setTimeout(function() {
            $("#" + more_opt + sid).find("ul").toggle();
        }, 100)
    } else {
        $('.more_opt').filter(':not(#' + more_opt + ')').children('ul').hide();
        $("#" + more_opt).children("ul").toggle();
    }
}

function novalueshow(name) {
    $('#more_opt').children('ul').hide();
    addNewTaskType('creatask');
}

function changepriority(pri, val, objid) {
    var ext = typeof objid != 'undefined' && objid == 'v2' ? "_v2" : "";
    $('#CS_priority').val(val);
    $('#selected_priority' + ext).html(pri);
    $('#pr_col' + ext).removeClass('low').removeClass('medium').removeClass('high').addClass(pri);
}

function getSelectedValue(id) {
    return $("#" + id).find("a span.value").html();
}

function getTmplvalue(objId) {
    var text = $(objId).html();
    var path = $(objId).closest("ul").parent("div").prev("div").attr("id");
    $("#" + path).children("a").children("span").html(text);
    var tmpl_id = $("#" + path).children("a").find("span.value").text();
    $('#hid_tmpl').val(tmpl_id);
    $("#" + path).next("div").children("ul").hide();
    $('#header_crtprjtmpl').text(_('Update Project Plan'));
    $('#crtprjtmpl_btn').find('#tmpl-btn').text('Update');
}
$(document).on("click", 'body', function(e) {
    $(e.target).closest('div').hasClass('opt50') ? $('#more_opt50').find('ul').show() : $('#more_opt50').find('ul').hide();
});

function checkEndlength(obj) {
    var len = $(obj).val().trim();
    len = parseInt(len);
    if (len > 365) {
        $(obj).val(365);
        showTopErrSucc('error', _('Sorry! you can not enter more than 365 occurrences.'));
    }
}

function showRecurringTask(attrVal) {
    if (($('#is_recurring').is(':checked') && $("#CSeasycaseid").val() != '') || ($('#is_recurring').is(':checked') && attrVal == 'r' && $("#CSeasycaseid").val() == '') || (!$('#is_recurring').is(':checked') && $("#CSeasycaseid").val() != '' && attrVal == 'p')) {
        openPopup();
        $('#is_recurring').prop('checked', true);
        $(".recurring_tsk_popup").show();
        $(".repeat-type").dropdown({
            "optionClass": "withripple",
            "autoinit": true,
            "onSelected": false,
        });
        $('#recurring_task_block').show();
        var case_end_date = '';
        if ($("#CS_due_date").val() != '' && $("#CS_due_date").val() != 'No Due Date') {
            case_end_date = moment($("#CS_due_date").val()).format('MMM DD, YYYY');
            $('#recurrence_start_date_formatted').val(case_end_date);
            $('#recurrence_start_date').val(moment($("#CS_due_date").val()).format('YYYY-MM-DD'));
            $('#CSrepeat_start_date').val(moment($("#CS_due_date").val()).format('YYYY-MM-DD'));
        } else if ($("#CS_start_date").val() != '' && $("#CS_start_date").val() != 'No Start Date') {
            case_end_date = moment($("#CS_start_date").val()).format('MMM DD, YYYY');
            $('#recurrence_start_date_formatted').val(case_end_date);
            $('#recurrence_start_date').val(moment($("#CS_start_date").val()).format('YYYY-MM-DD'));
            $('#CSrepeat_start_date').val(moment($("#CS_start_date").val()).format('YYYY-MM-DD'));
        } else {
            var today = new Date();
            case_end_date = moment(today).format('MMM DD, YYYY');
            $('#recurrence_start_date_formatted').val(case_end_date);
            $('#recurrence_start_date').val(moment(today).format('YYYY-MM-DD'));
            $('#CSrepeat_start_date').val(moment(today).format('YYYY-MM-DD'));
        }
        $("#occur, #date").removeAttr('disabled');
        $("#date").prop('checked', false);
        $("#occur").prop('checked', true);
        $('#occurrence, #recurrence_start_date_formatted').removeAttr('disabled', 'disabled');
        $('#repeat_type').find('span').text(_('Weekly'));
        $('#CSrepeat_type').val('Weekly');
        $('#occurrence').val('1');
        $("#recurrence_start_date_formatted").datepicker({
            format: 'M d, yyyy',
            todayHighlight: true,
            changeMonth: false,
            changeYear: false,
            startDate: '0d',
            hideIfNoPrevNext: true,
            setDate: moment(case_end_date).format('MMM DD, YYYY'),
            autoclose: true
        }).on("changeDate", function() {
            var dateText = $("#recurrence_start_date_formatted").datepicker('getFormattedDate');
            $('#recurrence_start_date').val(moment(dateText).format('YYYY-MM-DD'));
        });
        var repeatEnd = '+' + eval(365 * 7) + 'd';
        $("#recurrence_end_date_formatted").datepicker({
            format: 'M d, yyyy',
            todayHighlight: true,
            changeMonth: false,
            changeYear: false,
            startDate: '+1d',
            endDate: repeatEnd,
            hideIfNoPrevNext: true,
            autoclose: true
        }).on("changeDate", function() {
            var dateText = $("#recurrence_end_date_formatted").datepicker('getFormattedDate');
            $('#recurrence_end_date').val(moment(dateText).format('YYYY-MM-DD'));
        });
        if ($("#CSeasycaseid").val() != '') {
            $.post(HTTP_ROOT + "easycases/ajax_task_recurring", {
                'cid': $("#CSeasycaseid").val()
            }, function(res) {
                if (res) {
                    var recurFrequency = res['recurringData'][0]['RecurringEasycase']['frequency'].toLowerCase();
                    $("#editEasycaseId").val(res['recurringData'][0]['RecurringEasycase']['easycase_id']);
                    $("#editRecurId").val(res['recurringData'][0]['RecurringEasycase']['id']);
                    $("#editRecurProjId").val(res['recurringData'][0]['RecurringEasycase']['project_id']);
                    if (recurFrequency == "daily") {
                        $('.recur-pattern-details').hide();
                        $("#daily_pattern").prop('checked', true);
                        $("#daily_details").show();
                        if (res['recurringData'][0]['RecurringEasycase']['byday'] != '') {
                            $("#weekday_interval").prop('checked', true);
                            $("#daily_interval").prop('checked', false);
                        } else if (res['recurringData'][0]['RecurringEasycase']['byday'] == '') {
                            $("#weekday_interval").prop('checked', false);
                            $("#daily_interval").prop('checked', true);
                            $(".dailyInterval").val(res['recurringData'][0]['RecurringEasycase']['rec_interval']);
                        }
                    } else if (recurFrequency == "weekly") {
                        $('.recur-pattern-details').hide();
                        $("#weekly_pattern").prop('checked', true);
                        $("#weekly_details").show();
                        $(".weeklyInterval").val(res['recurringData'][0]['RecurringEasycase']['rec_interval']);
                        var allWeekdays = res['recurringData'][0]['RecurringEasycase']['byday'];
                        var array = allWeekdays.split(",");
                        $('input[name=weekly_days]').prop('checked', false);
                        array.forEach(function(i) {
                            $('input[name=weekly_days][value=' + i + ']').prop('checked', true);
                        });
                    } else if (recurFrequency == "monthly") {
                        $('.recur-pattern-details').hide();
                        $("#monthly_pattern").prop('checked', true);
                        $("#monthly_details").show();
                        if (res['recurringData'][0]['RecurringEasycase']['byday'] != '') {
                            $("#monthly_interval").prop('checked', false);
                            $("#monthly_complicated").prop('checked', true);
                            $("#monthly_mask").val(res['recurringData'][0]['RecurringEasycase']['byweekno']);
                            $("#weekday_mask").val(res['recurringData'][0]['RecurringEasycase']['byday']);
                            $(".monthlyIntervalComplete").val(res['recurringData'][0]['RecurringEasycase']['rec_interval']);
                        } else if (res['recurringData'][0]['RecurringEasycase']['byday'] == '') {
                            $("#monthly_complicated").prop('checked', false);
                            $("#monthly_interval").prop('checked', true);
                            $(".monthlyInterval").val(res['recurringData'][0]['RecurringEasycase']['rec_interval']);
                            $(".monthlyDate").val(res['recurringData'][0]['RecurringEasycase']['bymonthday']);
                        }
                    } else if (recurFrequency == "yearly") {
                        $('.recur-pattern-details').hide();
                        $("#yearly_pattern").prop('checked', true);
                        $("#yearly_details").show();
                        $("#yearly_interval").val(res['recurringData'][0]['RecurringEasycase']['rec_interval'])
                        if (res['recurringData'][0]['RecurringEasycase']['byday'] != '') {
                            $("#yearly_complicated").prop('checked', true);
                            $("#yearly_on").prop('checked', false);
                            $("#yearly_mask").val(res['recurringData'][0]['RecurringEasycase']['byweekno']);
                            $("#weekday_yearly").val(res['recurringData'][0]['RecurringEasycase']['byday']);
                            $("#monthsComplete").val(res['recurringData'][0]['RecurringEasycase']['bymonth']);
                        } else if (res['recurringData'][0]['RecurringEasycase']['byday'] == '') {
                            $("#yearly_complicated").prop('checked', false);
                            $("#yearly_on").prop('checked', true);
                            $("#months").val(res['recurringData'][0]['RecurringEasycase']['bymonth']);
                            $(".yearlyDate").val(res['recurringData'][0]['RecurringEasycase']['bymonthday']);
                        }
                    }
                    var RecurStartDate = res['recurringData'][0]['RecurringEasycase']['start_date'];
                    var RecurEndDate = res['recurringData'][0]['RecurringEasycase']['end_date'];
                    if (RecurStartDate) {
                        $('#recurrence_start_date_formatted').val(moment(RecurStartDate).format('MMM DD, YYYY'));
                        $('#recurrence_start_date').val(moment(RecurStartDate).format('YYYY-MM-DD'));
                    } else {
                        $('#recurrence_start_date_formatted').val(moment().format('MMM DD, YYYY'));
                        $('#recurrence_start_date').val(moment().format('YYYY-MM-DD'));
                    }
                    if (RecurEndDate) {
                        $('#recurrence_end_date_formatted').val(moment(RecurEndDate).format('MMM DD, YYYY'));
                        $('#recurrence_end_date').val(moment(RecurEndDate).format('YYYY-MM-DD'));
                        $("#end_by").prop('checked', true);
                    } else {
                        $('#recurrence_end_date_formatted').val(moment(RecurStartDate).add(10, 'days').format('MMM DD, YYYY'));
                        $('#recurrence_end_date').val(moment(RecurStartDate).add(10, 'days').format('YYYY-MM-DD'));
                    }
                    if (res['recurringData'][0]['RecurringEasycase']['occurrences'] > 0) {
                        $("#end_after").prop('checked', true);
                        $("#end_ocurrences").val(res['recurringData'][0]['RecurringEasycase']['occurrences']);
                    }
                    if (!RecurEndDate && res['recurringData'][0]['RecurringEasycase']['occurrences'] == '') {
                        $("#no_end_date").prop('checked', true);
                    }
                }
            }, 'json');
        }
    } else {
        $('#repeat_txt').text(_('Repeat'));
        $('#repeat_type').html("<span class='ttfont'>&nbsp;&nbsp;" + _('None') + "</span>");
        $("#CSrepeat_type").val('');
        $("#occur, #date").attr('disabled', 'disabled');
        $("#occur, #date").prop('checked', false);
        $('#occurrence, #end_datePicker, #recurrence_start_date_formatted').attr('disabled', 'disabled').val('');
        $('#recurring_task_block').hide();
    }
}

function serializeDatatoArray(recurrenceDetailsArr) {
    var data = {};
    data.weekly_days = '';
    $(recurrenceDetailsArr).each(function(index, obj) {
        if (obj.name === 'weekly_days') {
            data.weekly_days += obj.value + ',';
        } else {
            data[obj.name] = obj.value;
        }
    });
    if (data.weekly_days != '') {
        data.weekly_days = data.weekly_days.substring(0, data.weekly_days.length - 1);
    }
    return data;
}

function addTaskEvents(objid) {
    var ext = (typeof objid != 'undefined' && objid == 'more_opt5_v2') ? '_v2' : '';
    $(".more_opt ul li a").on('click', function() {
        var text = $(this).html();
        var path = $(this).parent("li").parent("ul").parent("div").prev("div").attr("id");
        $("#" + path).children("a").children("span").html(text);
        if (path == "opt3") {
            var hidden_val = $("#" + path).find("a span.value").html();
            var case_end_date = '';
            if (hidden_val != '' && hidden_val != 'No Due Date') {
                $('#start_datePicker').val(hidden_val);
                $("#end_datePicker").val(moment(hidden_val).format('MMM DD, YYYY'));
            } else {
                var today = new Date();
                case_end_date = formatDate('MMM DD, YYYY', today);
                $('#start_datePicker').val(case_end_date);
                $("#end_datePicker").val(case_end_date);
            }
            $("#date_dd").html(hidden_val);
            $("#CS_due_date").val(hidden_val);
            $("#CS_repeat_start_date").val(formatDate('MMM DD, YYYY', hidden_val));
            $("#start_datePicker").datepicker("setStartDate", case_end_date);
        } else if (path == "opt2") {} else if (path == "opt4") {
            $("#CS_milestone").val(getSelectedValue("opt4"));
        } else if (path == "opt5") {
            $("#CS_assign_to").val(getSelectedValue("opt5"));
        } else if (path == "opt8") {
            if (text == '<span class="value"></span>&nbsp;+ Create Task Group') {
                $("#" + path).children("a").children("span").html('<span class="value"></span> ' + _('Default Task Group'));
            }
            $("#CS_milestone").val(getSelectedValue("opt8"));
        } else if (path == 'opt40') {
            var hidden_val = $("#" + path).find("a span.value").html();
            $("#repeat_type").html('<span class="ttfont">' + hidden_val + '</span>');
            if (hidden_val == 'None') {
                $("#CSrepeat_type").val('');
                $("#start_datePicker").attr('disabled', 'disabled').val('');
                $("#occur, #date").attr('disabled', 'disabled');
                $("#occur, #date").prop('checked', false);
                $('#occurrence, #end_datePicker').attr('disabled', 'disabled').val('');
            } else {
                $("#CSrepeat_type").val(hidden_val);
                $("#occur, #date").removeAttr('disabled');
                $("#occur").prop('checked', true);
                $('#occurrence').removeAttr('disabled');
                $("#start_datePicker").removeAttr('disabled');
                $('#occurrence').val('1');
                $('#end_datePicker').attr('disabled', 'disabled');
                var case_end_date = '';
                if ($("#date_dd").html() != '' && $("#date_dd").html() != 'No Due Date') {
                    $('#start_datePicker').val($("#date_dd").html());
                    $("#end_datePicker").val($("#date_dd").html());
                } else {
                    var today = new Date();
                    case_end_date = formatDate('M d, yy', today);
                    $('#start_datePicker').val(case_end_date);
                    $("#end_datePicker").val(case_end_date);
                }
            }
        } else {
            $("#CS_type_id").val(getSelectedValue("opt1" + ext));
            $('#opt2' + ext).parent('div').addClass('dropdown wid');
            if (ext == '') {
                $('#opt2' + ext).html("<span id=" + "pr_col" + ext + " class=" + "low" + " ></span><a href=" + "javascript:void(0);" + " class=" + "ttfont" + "  onclick=" + "open_more_opt('more_opt9" + ext + "');" + "><span id=" + "selected_priority" + ext + ">&nbsp;&nbsp;Low</span><i id='car" + ext + "' class=" + "caret" + "></i></a>");
            }
            $('#pr_col' + ext).addClass('fl');
            $('#car' + ext).addClass('fr');
            $('#car' + ext).addClass('mtop-10');
            $('#CS_priority').val(2);
            if ($("#CS_type_id").val() == 10) {
                $("#CS_priority").val(0);
                $('#opt2' + ext).parent('div').removeClass('dropdown wid');
                $('#opt2' + ext).html('<span id="pr_col' + ext + '" class="high fl" ></span><a href="javascript:void(0);"><span id="selected_priority' + ext + '">&nbsp;&nbsp;High</span></a>');
                document.getElementById("CS_title").style.color = '#000';
            } else if ($("#CS_type_id").val() != 10 && $("#CS_title").val() == TITLE_DLYUPD) {
                $("#CS_title").val('');
            }
        }
        $("#" + path).next("div").children("ul").hide();
    });
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (!($clicked.parents().hasClass("dropdown")) && !($('#ui-datepicker-div').is(":visible"))) {
            $(".dropdown .more_opt ul").hide();
        }
    });
    $("#start_date,#due_date").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        autoclose: true,
        clearBtn: true
    }).on("changeDate", function(ev) {
        if ($(ev.target).attr('id') == 'start_date') {
            var dateText = $("#start_date").datepicker('getFormattedDate');
            if (dateText != 'Invalid date') {
                $("#CS_start_date").val(moment(dateText).format('YYYY-MM-DD'));
                $("#start_datePicker").val(moment(dateText).format('MMM DD, YYYY'));
                $("#end_datePicker").datepicker("setStartDate", dateText);
                $("#due_date").datepicker("setStartDate", dateText);
            }
        } else {
            var dateText = $("#due_date").datepicker('getFormattedDate');
            if (dateText != 'Invalid date') {
                $("#CS_due_date").val(moment(dateText).format('YYYY-MM-DD'));
                $("#end_datePicker").val(moment(dateText).format('MMM DD, YYYY'));
                $("#start_datePicker").datepicker("setEndDate", dateText);
                $("#start_date").datepicker("setEndDate", dateText);
            }
        }
    }).on("hide", function(ev) {
        if ($(ev.target).attr('id') == 'start_date') {
            if ($('#start_date').val() == '') {
                if (moment($('#CS_start_date').val()).format('MMM DD, YYYY') != 'Invalid date') {
                    $('#start_date').val(moment($('#CS_start_date').val()).format('MMM DD, YYYY'));
                }
            }
        } else {
            if ($('#due_date').val() == '') {
                if (moment($('#CS_due_date').val()).format('MMM DD, YYYY') != 'Invalid date') {
                    $('#due_date').val(moment($('#CS_due_date').val()).format('MMM DD, YYYY'));
                }
            }
        }
    });
    if ($('#CS_due_date').val() != '') {
        $("#start_date").datepicker("setEndDate", $("#due_date").datepicker('getFormattedDate'));
    }
}

function priority_change(obj) {
    $('#CS_priority').val($(obj).val());
}

function cancel_repeat() {
    var editEasyCaseId = $("#editEasycaseId").val();
    if (editEasyCaseId == '') {
        $('#is_recurring').prop('checked', false);
    }
    $('#CSrepeat_occurrence,#CSrepeat_type,#CSrepeat_start_date,#CSrepeat_due_date').val('');
}

function addproj_des(obj) {
    if (typeof mlstfrom == 'undefined') {
        mlstfrom = '';
    }
    if (mlstfrom == 'createTask') {
        var projUid = $('#curr_active_project').val();
    } else if (mlstfrom == 'dashboard') {
        var projUid = $('#curr_active_project').val();
    } else {
        var projUid = $('#projFil').val();
        if (arguments[6] !== undefined) {
            var projUid = mlstfrom;
        }
    }
    if (obj) {
        openPopup();
        $(".description").show();
        $('#inner_description').html('');
        $("#addeditDescription").show();
    }
    $.post(HTTP_ROOT + "easycases/ajax_description", {
        'projUid': projUid
    }, function(res) {
        if (res) {
            $("#addeditDescription").hide();
            $('#inner_description').show();
            $('#inner_description').html(res);
        }
    });
}

function addEditMilestone(obj, mileuniqid, mid, name, cnt, mlstfrom) {
    if (typeof mlstfrom == 'undefined') {
        mlstfrom = '';
    }
    if (mlstfrom == 'createTask') {
        var projUid = $('#curr_active_project').val();
    } else if (mlstfrom == 'dashboard') {
        var projUid = $('#curr_active_project').val();
    } else {
        var projUid = $('#projFil').val();
        if (arguments[6] !== undefined) {
            var projUid = mlstfrom;
        }
    }
    if (obj) {
        var mid = $(obj).attr("data-id");
        var mileuniqid = $(obj).attr("data-uid");
        var name = $(obj).attr("data-name");
    }
    openPopup();
    $(".mlstn").show();
    $('#inner_mlstn').html('');
    $("#addeditMlst").show();
    if (mid === '' || typeof mid == 'undefined') {
        $("#icon_mlstn").removeClass("icon-edit-projct");
        $("#icon_mlstn").addClass("icon-create-mlsn");
        $("#header_mlstn").html(_("Create Task Group"));
    } else {
        $("#icon_mlstn").removeClass("icon-create-mlsn");
        $("#icon_mlstn").addClass("icon-edit-projct");
        if (name == 'Create Task Group') {
            name = _('Create Task Group');
        }
        var defaultname = (name == 'default') ? _("Default Task group") : name;
        $("#header_mlstn").html(unescape(defaultname));
        $('#header_mlstn').attr('title', unescape(defaultname));
    }
    $.post(HTTP_ROOT + "milestones/ajax_new_milestone", {
        'mid': mid,
        'mileuniqid': mileuniqid,
        'mlstfrom': mlstfrom,
        'projUid': projUid
    }, function(res) {
        if (res) {
            $("#addeditMlst").hide();
            $('#inner_mlstn').show();
            $('#inner_mlstn').html(res);
            if (mileuniqid == 'default') {
                $('#title').val(_('Default Task Group'));
                var strr = '<input type="hidden" name="data[Milestone][project_id]" id="project_id" value="' + PROJECTS_ID_MAP[projUid] + '" data-pname="' + $('#pname_dashboard').text() + '" data-puniq="' + projUid + '">';
                strr += '<div class="form-group label-floating"><label class="control-label">' + _('Project') + '</label>';
                strr += '<div class="form-control input-lg">' + $('#pname_dashboard').text() + '</div></div>';
                $("#newmileproj").html(strr);
            }
            $("#project_id").focus();
            refreshManageMilestone = 1;
            $.material.init();
            $('.select_mile').dropdown({
                "optionClass": "withripple",
                "autoinit": '.select',
                "callback": function($dropdown) {
                    $($dropdown).find('.dropdownjs-search input').on('keyup', function(e) {
                        val = $($dropdown).find('.dropdownjs-search input').val().toUpperCase();
                        $($dropdown).find('ul li').not('.dropdownjs-search').each(function() {
                            if ($(this).html().toUpperCase().indexOf(val) > -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        })
                    });
                },
                "onSelected": false,
                "search": true,
                "dynamicOptLabel": "Search"
            });
            $('textarea').autoGrow().keyup();
            $("#end_date_mil").datepicker({
                format: 'M d, yyyy',
                todayHighlight: true,
                changeMonth: false,
                changeYear: false,
                startDate: 0,
                hideIfNoPrevNext: true,
                autoclose: true
            }).on("changeDate", function() {
                var dateText = $("#end_date_mil").datepicker('getFormattedDate');
                $("#start_date_mil").datepicker("setEndDate", dateText);
            });
            $("#start_date_mil").datepicker({
                format: 'M d, yyyy',
                todayHighlight: true,
                changeMonth: false,
                changeYear: false,
                startDate: 0,
                hideIfNoPrevNext: true,
                autoclose: true
            }).on("changeDate", function() {
                var dateText = $("#start_date_mil").datepicker('getFormattedDate');
                $("#end_date_mil").datepicker("setStartDate", dateText);
            });
        }
    });
}
var asgnd_usr_arr = new Array();

function addUsersToProject(PrjUid) {
    var company_trial_expire = $('#company_trial_expire').val();
    if (company_trial_expire == 1) {
        showTopErrSucc('error', _('Sorry! you can not add user(s) to project.') + '<br />' + _('Please upgrade your account to add more user(s).'));
        return false;
    }
    new_usr_html = $('#inner_user').html();
    $('#inner_user').html('');
    openPopup();
    $(".add_users_to_project").show();
    $('#add_user_project_resp').html('');
    $("#addUPLoader").show();
    $('#add_user_pop_pname').html('');
    var pj_name = '';
    if (arguments[1]) {
        pj_name = arguments[1];
    }
    $.post(HTTP_ROOT + "projects/addUsersToProject", {
        'projUid': PrjUid
    }, function(res) {
        if (res) {
            $("#addUPLoader").hide();
            $('#add_user_project_resp').show();
            if (pj_name != '') {
                $('#add_user_pop_pname').html(pj_name);
                $('#add_user_pop_pname').attr('title', pj_name);
            } else {
                $('#add_user_pop_pname').html($('#add_user_pop_pname_overview').html());
                $('#add_user_pop_pname').attr('title', $('#add_user_pop_pname_overview').html());
            }
            $('#add_user_project_resp').html(res);
            $('#add_user_pop_pname').html($("#Pjname").val());
            var checked_cnt = $('#existing_conopamy_users').find('.add_user_chk:checked').length;
            $('.add_user_chk:checked').each(function() {
                asgnd_usr_arr.push($(this).val());
            });
            var usr = checked_cnt > 1 ? _("users have") : _("user has");
            $('#asgnd_usr_cnt').html("<b>" + checked_cnt + "</b> " + usr + " " + _("been assigned."));
            if (SES_TYPE == 3) {
                $('#add_user_project_resp').find('ul').find('li:nth-child(2)').hide();
            }
            $('.custom_scroll').jScrollPane({
                autoReinitialise: true
            });
            $.material.init();
            $('[rel="tooltip"]').tipsy({
                gravity: 's',
                fade: true
            });
        }
        $("#select_role").select2();
    });
}

function delMilestone(obj, name, uniqid) {
    if (obj) {
        var uniqid = $(obj).attr("data-uid");
        var name = decodeURIComponent($(obj).attr("data-name"));
    }
    name = unescape(name);
    var conf_txt = _("Are you sure you want to delete task group") + " '" + name + "'?";
    var conf_tg_task = '';
    if (arguments[4] !== undefined) {
        if (arguments[4] == 1) {
            conf_txt = _("Do you want to delete only task group:") + " '" + name + "'?";
            conf_tg_task = 1;
        } else {
            conf_txt = _("Do you want to delete task group") + "( '" + name + "') " + _("along with tasks?");
            conf_tg_task = 2;
        }
    }
    var is_mile_on_taskpage = '';
    if (arguments[3] !== undefined) {
        is_mile_on_taskpage = arguments[3];
    }
    setTimeout(function() {
        if (confirm(conf_txt)) {
            var loc = HTTP_ROOT + "milestones/delete_milestone/";
            $.post(loc, {
                'uniqid': uniqid,
                'conf_check': conf_tg_task
            }, function(res) {
                if (res.err == 1) {
                    showTopErrSucc('error', res.msg);
                } else {
                    showTopErrSucc('success', res.msg);
                    if (is_mile_on_taskpage != '') {
                        $('#empty_milestone_tr' + is_mile_on_taskpage).fadeOut(1000, function() {
                            $('#empty_milestone_tr' + is_mile_on_taskpage).remove();
                        });
                        easycase.refreshTaskList();
                    } else {
                        refreshManageMilestone = 1;
                    }
                }
                if (is_mile_on_taskpage == '') {
                    if ($('#caseMenuFilters').val() == 'milestonelist') {
                        showMilestoneList();
                    } else {
                        var params = parseUrlHash(urlHash);
                        if (typeof params[0] != 'undefined' && typeof params[1] != 'undefined' && params[0] == 'kanban') {
                            window.location.href = HTTP_ROOT + 'dashboard#milestonelist';
                        } else {
                            ManageMilestoneList();
                        }
                    }
                }
            }, 'json');
        }
    }, 500);
    return false;
}

function milestoneArchive(obj, uniqid, title) {
    if (obj) {
        var uniqid = $(obj).attr("data-uid");
        var title = decodeURIComponent($(obj).attr("data-name"));
    }
    var is_from_dsbd = '';
    if (arguments[3] !== undefined) {
        is_from_dsbd = 1;
        title = unescape(title);
    }
    if (1) {
        var loc = HTTP_ROOT + "milestones/milestone_archive/";
        $.post(loc, {
            'uniqid': uniqid
        }, function(res) {
            if (res.error) {
                showTopErrSucc('error', res.msg);
                if (is_from_dsbd == 1) {
                    easycase.refreshTaskList();
                } else if ($('#caseMenuFilters').val() == 'milestonelist') {
                    showMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    easycase.showKanbanTaskList();
                } else {
                    ManageMilestoneList(1);
                }
            } else if (res.success) {
                localStorage.setItem("subtask_miilestone", '');
                showTopErrSucc('success', res.msg);
                if (is_from_dsbd == 1) {
                    easycase.refreshTaskList();
                } else if ($('#caseMenuFilters').val() == 'milestonelist') {
                    showMilestoneList('', 1);
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    easycase.showKanbanTaskList();
                } else {
                    ManageMilestoneList(1);
                }
            }
        }, 'json');
    }
    refreshMilestone = 1;
    return false;
}

function milestoneRestore(obj, uniqid, title) {
    if (obj) {
        var uniqid = $(obj).attr("data-uid");
        var title = decodeURIComponent($(obj).attr("data-name"));
    }
    var is_from_dsbd = '';
    if (arguments[3] !== undefined) {
        is_from_dsbd = 1;
        title = unescape(title);
    }
    if (1) {
        var loc = HTTP_ROOT + "milestones/milestone_restore/";
        $.post(loc, {
            'uniqid': uniqid
        }, function(res) {
            if (res.error) {
                showTopErrSucc('error', res.msg);
                if (is_from_dsbd == 1) {
                    easycase.refreshTaskList();
                } else if ($('#caseMenuFilters').val() == 'milestonelist') {
                    showMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    easycase.showKanbanTaskList();
                } else {
                    ManageMilestoneList(0);
                }
            } else if (res.success) {
                showTopErrSucc('success', res.msg);
                if (is_from_dsbd == 1) {
                    easycase.refreshTaskList();
                } else if ($('#caseMenuFilters').val() == 'milestonelist') {
                    showMilestoneList('', 0);
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    easycase.showKanbanTaskList();
                } else {
                    ManageMilestoneList(0);
                }
            }
        }, 'json');
        refreshMilestone = 1;
    } else {
        return false;
    }
}

function addTaskToMilestone(obj, mstid, projid, cnt) {
    $('#milestone_err_msg').html('');
    var dashboard_chk = '';
    if (arguments[4] !== undefined) {
        dashboard_chk = 1;
    }
    $('.showhidebtn').addClass('loginactive');
    if (obj) {
        var mstid = $(obj).attr("data-id");
        var projid = $(obj).attr("data-prj-id");
    }
    openPopup();
    $(".mlstn_case").show();
    $('#inner_mlstn_case').html('');
    $('.add-mlstn-btn').hide();
    $('#tsksrch').hide();
    $(".loader_dv").show();
    $('#tsk_name').val('');
    $("#mlstnpopup").hide();
    $("#addtsk").css({
        'cursor': 'default'
    });
    $("#addtskncont").css({
        'cursor': 'default'
    });
    $("#tsk_name").val('');
    $.post(HTTP_ROOT + "milestones/add_case", {
        'mstid': mstid,
        'projid': projid,
        'from_dsbd': dashboard_chk
    }, function(res) {
        if (res) {
            $(".loader_dv").hide();
            $('#inner_mlstn_case').show();
            $('.add-mlstn-btn').show();
            $('#tskloader').hide();
            $('#tsksrch').show();
            $('#inner_mlstn_case').html(res);
            $("#header_prj_ttl").html($("#cur_proj_name").val()).attr('title', $("#cur_proj_full_name").val());
            $("#header_mlstn_ttl").html($("#addcsmlstn_titl").val()).attr('title', $("#addcsmlstn_full_titl").val());
            $.material.init();
            $('.scrl-ovr').jScrollPane();
        }
    });
}

function searchMilestoneCase() {
    var project_id = '';
    var milestone_id = '';
    var title = $('#tsk_name').val();
    title = title.trim();
    try {
        var project_id = $('#project_id').val();
        var milestone_id = $('#milestone_id').val();
    } catch (e) {}
    if (project_id && milestone_id) {
        $("#tskpopupload1").show();
        $("#mlstnpopup").hide();
        $("#addtsk").css({
            'cursor': 'default'
        });
        $("#addtskncont").css({
            'cursor': 'default'
        });
        $.post(HTTP_ROOT + "milestones/add_case", {
            "mstid": milestone_id,
            "projid": project_id,
            "title": title
        }, function(res) {
            if (res) {
                $('#inner_mlstn_case').html(res);
                $("#tskpopupload1").hide();
                $.material.init();
                $('.scrl-ovr').jScrollPane();
                $('.showhidebtn').addClass('loginactive');
            }
        });
    }
}

function selectMilestones(arg, i, chkall) {
    $('#milestone_err_msg').html('');
    $("#addtsk").css({
        'cursor': 'default'
    });
    $("#addtskncont").css({
        'cursor': 'default'
    });
    if (parseInt(arg)) {
        if ($('#' + chkall).is(":checked")) {
            if (!$('.ad-mlstn').length) {
                $('.showhidebtn').addClass('loginactive');
            } else {
                $('.showhidebtn').removeClass('loginactive');
            }
            $(".ad-mlstn").attr("checked", "checked");
            $(".ad-mlstn").prop("checked", "checked");
            $("#addtsk").css({
                'cursor': 'pointer'
            });
            $("#addtskncont").css({
                'cursor': 'pointer'
            });
        } else {
            $('.showhidebtn').addClass('loginactive');
            $(".ad-mlstn").attr("checked", false);
            $(".ad-mlstn").prop("checked", false);
        }
    } else {
        var listing = "listings" + i;
        if ($('.ad-mlstn:checked').length == $('.ad-mlstn').length) {
            $("#" + chkall).attr("checked", "checked");
            $("#" + chkall).prop("checked", "checked");
            $("#addtsk").css({
                'cursor': 'pointer'
            });
            $("#addtskncont").css({
                'cursor': 'pointer'
            });
            $('.showhidebtn').removeClass('loginactive');
        } else {
            $("#" + chkall).attr("checked", false);
            $("#" + chkall).prop("checked", false);
            if ($('#actionChk' + i).is(":checked")) {
                $("#addtsk").css({
                    'cursor': 'pointer'
                });
                $("#addtskncont").css({
                    'cursor': 'pointer'
                });
            }
        }
        if (!$('.ad-mlstn:checked').length) {
            $('.showhidebtn').addClass('loginactive');
        } else {
            $('.showhidebtn').removeClass('loginactive');
        }
    }
}

function switchMilestone(obj, milestone_id, project_id) {
    if (project_id && milestone_id) {
        $('#milestone_id').val(milestone_id);
        $('#header_mlstn_ttl').html($(obj).text());
        $("#mlstnpopup").hide();
        $("#tskpopupload1").show();
        $("#addtsk").css({
            'cursor': 'default'
        });
        $("#addtskncont").css({
            'cursor': 'default'
        });
        $("#tsk_name").val('');
        $.post(HTTP_ROOT + "milestones/add_case", {
            "mstid": milestone_id,
            "projid": project_id
        }, function(res) {
            if (res) {
                $('#inner_mlstn_case').html(res);
                $("#tskpopupload1").hide();
                $.material.init();
                $('.scrl-ovr').jScrollPane();
                $('.showhidebtn').addClass('loginactive');
            }
        });
    }
}

function assignCaseToMilestone(el) {
    $('#milestone_err_msg').html('');
    $("#mlstnpopup").hide();
    var caseid = Array();
    var done = 0;
    $('#inner_mlstn_case input:checked').each(function() {
        if ($(this).attr('id') !== 'checkAll') {
            caseid.push($(this).attr('value'));
            done++;
        }
    });
    if (done) {
        var project_id = $('#project_id').val();
        var milestone_id = $('#milestone_id').val();
        var add_task_from_dsbd = $('#add_task_from_dsbd').val().trim();
        $("#confirmbtntsk").hide();
        $('#tskloader').show();
        $.post(HTTP_ROOT + 'milestones/assign_case', {
            "caseid": caseid,
            "project_id": project_id,
            "milestone_id": milestone_id
        }, function(data) {
            if (data.message == "success") {
                var total_tasks = parseInt(caseid.length) + parseInt($("#tot_tasks" + milestone_id).text());
                $("#tot_tasks" + milestone_id).html(total_tasks);
                if (el && el.id == "addtskncont") {
                    $("#addtsk").css({
                        'cursor': 'default'
                    });
                    $("#addtskncont").css({
                        'cursor': 'default'
                    });
                    $("#tsk_name").val('');
                    $('.showhidebtn').addClass('loginactive');
                    $.post(HTTP_ROOT + 'milestones/add_case', {
                        "mstid": milestone_id,
                        "projid": project_id,
                        'from_dsbd': add_task_from_dsbd
                    }, function(data) {
                        if (data) {
                            $('#inner_mlstn_case').html(data);
                            $.material.init();
                            $('.scrl-ovr').jScrollPane()
                        }
                    });
                } else {
                    closePopup();
                }
                $('#tskloader').hide();
                $("#confirmbtntsk").show();
                showTopErrSucc('success', _('Task assigned successfully.'));
                if (add_task_from_dsbd == 1) {
                    easycase.refreshTaskList();
                } else if ($('#caseMenuFilters').val() == 'milestonelist') {
                    showMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'milestone') {
                    ManageMilestoneList();
                } else if ($('#caseMenuFilters').val() == 'kanban') {
                    easycase.showKanbanTaskList();
                }
            }
        }, 'json');
    } else {
        $('#milestone_err_msg').html(_('Choose task to assign to milestone.'));
    }
}

function view_project_milestone() {
    $('#pop_arrow_newp').hide();
    if ($('#mlstnpopup').is(':visible')) {
        $('#pop_arrow_newp').hide();
        $("#mlstnpopup").hide();
    } else {
        $("#mlstnpopup").show();
        $('#pop_arrow_newp').show();
    }
    var project_id = $('#project_id').val();
    $('#ajaxViewMilestones').html('');
    $('#loader_mlsmenu').show();
    $.post(HTTP_ROOT + "milestones/ajax_milestone_menu", {
        "project_id": project_id
    }, function(data) {
        if (data) {
            $('#ajaxViewMilestonesCP').html(data);
            $('#loader_mlsmenu').hide();
        }
    });
}

function caseMilestone(pjid, pname, page) {
    if (typeof(page) == 'undefined') {
        page = 1;
    }
    $('#pname_dashboard').html(decodeURIComponent(pname));
    $('#prjid').val(pjid);
    $('#projpopup').hide();
    $("#find_prj_dv").hide();
    $('#prj_drpdwn').removeClass("open");
    $(".dropdown-menu.lft").hide();
    var mlsttype = $('#mlsttype').val();
    if (pjid) {
        $("#moreloader").show();
        $.post(HTTP_ROOT + "milestones/milestone", {
            "project_id": pjid,
            'page': page,
            'mlsttype': mlsttype
        }, function(data) {
            if (data) {
                $("#moreloader").hide();
                $("#mlstnlistingDv").html(data);
                $(".proj_mng_div .contain").hover(function() {
                    $(this).find(".proj_mng").stop(true, true).animate({
                        bottom: "0px",
                        opacity: 1
                    }, 400);
                }, function() {
                    $(this).find(".proj_mng").stop(true, true).animate({
                        bottom: "-42px",
                        opacity: 0
                    }, 400);
                });
            }
        });
    }
}
showMilestoneList = function(mlstpaginate, isActive, pointer, search_key) {
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
    $('#filterSearch_id_kanban').hide();
    $('#storeIsActive').val(isActive);
    $('#view_type').val('kanban');
    if (!search_key) {
        search_key = $('#search_text').val();
    }
    if (isActive == 0) {
        $('#mlstab_cmpl_kanban').show();
        $('#mlstab_cmpl_kanban').addClass('active')
        $('#mlstab_act_kanban').removeClass('active')
        $('#cmpl_btn_tsgrp').addClass('disable');
        $('#actv_btn_tsgrp').removeClass('disable');
        $('#mlstab_act_kanban').hide();
    } else {
        $('#mlstab_act_kanban').show();
        $('#mlstab_cmpl_kanban').removeClass('active')
        $('#mlstab_act_kanban').addClass('active')
        $('#cmpl_btn_tsgrp').removeClass('disable');
        $('#actv_btn_tsgrp').addClass('disable');
        $('#mlstab_cmpl_kanban').hide();
    }
    $('#mlview_btn,mkbview_btn').tipsy({
        gravity: 'n',
        fade: true
    });
    $(".side-nav li").removeClass('active');
    $(".menu-milestone").addClass('active');
    var ispaginate = '';
    if (typeof(mlstpaginate) != 'undefined' && mlstpaginate) {
        ispaginate = mlstpaginate;
    }
    $("#brdcrmb-cse-hdr").html('Task Groups');
    $('#caseLoader').show();
    $('#select_view_mlst div').removeClass('disable');
    $('#mkbview_btn').addClass('disable');
    var projFil = $('#projFil').val();
    var projIsChange = $('#projIsChange').val();
    var caseStatus = $('#caseStatus').val();
    var caseCustomStatus = getGlobalFilters('CUSTOM_STATUS');
    var priFil = $('#priFil').val();
    var caseTypes = $('#caseTypes').val();
    var caseLabel = $('#caseLabel').val();
    var caseMember = $('#caseMember').val();
    var caseComment = $('#caseComment').val();
    var caseAssignTo = $('#caseAssignTo').val();
    var caseSearch = $("#case_search").val();
    var case_date = $('#caseDateFil').val();
    var case_due_date = $('#casedueDateFil').val();
    var case_srch = $('#case_srch').val();
    var mlimit = ((isActive == 0 || isActive == 1) && pointer != 1) ? 0 : $('#milestoneLimit').val();
    var mURL = HTTP_ROOT + "milestones/ajax_milestonelist";
    easycase.routerHideShow('milestonelist');
    $("#caseMenuFilters").val('milestonelist');
    $('#milestoneUid').val('');
    $('#milestoneId').val('');
    $.post(mURL, {
        "projFil": projFil,
        "projIsChange": projIsChange,
        'caseCustomStatus': caseCustomStatus,
        'caseStatus': caseStatus,
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
        'mlimit': mlimit,
        "caseMenuFilters": 'milestonelist',
        'ispaginate': ispaginate,
        'isActive': isActive,
        'file_srch': search_key
    }, function(res) {
        $('body').css('overflow-y', 'hidden');
        if (res) {
            res.isActive = isActive;
            refreshMilestone = 0;
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            $('#caseLoader').hide();
            $('.show_all_opt_in_listonly').hide();
            $('#kanban_completed_task').html(res.inactmil);
            if (!res.error) {
                if (res.totalMlstCnt > 3) {
                    if (res.mlimit <= 3) {
                        $('.milestonenextprev .prev').addClass('disable');
                        $('.milestonenextprev .prev').attr('disabled', 'disabled');
                    } else {
                        $('.milestonenextprev .prev').removeClass('disable');
                        $('.milestonenextprev .prev').removeAttr('disabled');
                    }
                    if (res.mlimit >= res.totalMlstCnt) {
                        $('.milestonenextprev .next').addClass('disable');
                        $('.milestonenextprev .next').attr('disabled', 'disabled');
                    } else {
                        $('.milestonenextprev .next').removeClass('disable');
                        $('.milestonenextprev .next').removeAttr('disabled');
                    }
                } else {
                    $('.milestonenextprev').hide();
                }
                $('#milestoneLimit').val(res.mlimit);
                $('#totalMlstCnt').val(res.totalMlstCnt);
            } else {
                $('.milestonenextprev').hide();
                $('#milestoneLimit').val('0');
                $('#totalMlstCnt').val('0');
            }
            var result = document.getElementById('show_milestonelist');
            result.innerHTML = tmpl("milestonelist_tmpl", res);
            var window_kanban_slider = $('.kanban_top_slider').width() - 100;
            if (window_kanban_slider < 1300) {
                var dp_width = Math.round(window_kanban_slider / 4);
                bxslid = $('.kanban_top_slider .bxslider').bxSlider({
                    slideWidth: dp_width,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 4,
                    pager: false,
                    slideMargin: 10,
                    infiniteLoop: false,
                    auto: false,
                });
            } else {
                var dp_width = Math.round(window_kanban_slider / 5);
                bxslid = $('.kanban_top_slider .bxslider').bxSlider({
                    slideWidth: dp_width,
                    minSlides: 5,
                    maxSlides: 5,
                    moveSlides: 5,
                    pager: false,
                    slideMargin: 10,
                    infiniteLoop: false,
                    auto: false,
                });
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
            if ($('#actv_btn_tsgrp').hasClass('disable')) {
                $('.last_title').show();
                $('.kanban_active_task').html(res.actmil);
                $('.crt_task_btn_btm').show();
            } else {
                $('.last_title').hide();
                $('.kanban_active_task').html(res.inactmil);
                $('.crt_task_btn_btm').hide();
            }
            $('#show_milestonelist').find('.kanban-child').css({
                'width': '300px'
            });
            var div_width = ($('#show_milestonelist').find('.kanban-child').width() + parseInt($('#show_milestonelist').find('.kanban-child').css('padding-left')));
            $('#show_milestonelist').find('.kanban-main').width(div_width * $('#show_milestonelist').find('.kanban-child').size());
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
            var pane = $(".custom_scroll");
            pane.jScrollPane(settings);
            $(document).on('keyup', '.in_qt_kanban', function(event) {
                var inpt = $(this).val().trim();
                if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
                    setSessionStorage('Kanban Task Group Quick Task', 'Create Task');
                    AddQuickTask($(this).attr('data-mid'));
                }
            });
            $(document).on('keyup', '[id^="milstone_edit_"]', function(event) {
                if (event.keyCode == 13 && !$('#caseLoader').is(':visible')) {
                    saveMilesatoneTitle($(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1));
                }
            });
            $(".kanban-child .kbtask_div").on("hover", function(obj) {
                var curindex = $(this).parent().children().index(this);
                if (($(this).is(":last-child") || $(this).is(":nth-last-child(3)") || $(this).is(":nth-last-child(2)")) && (parseInt(curindex) > 1) && ($(this).parents(".jspPane").height() > 400)) {
                    $(this).find('.dropdown').on('click', function(cobj) {
                        var hite = $(this).find('.dropdown-menu').height();
                        var popup_ht = parseInt(hite) + 12;
                        $(this).find(".dropdown-menu").css({
                            top: "-" + popup_ht + "px"
                        });
                        $(this).find(".pop_arrow_new").css({
                            marginTop: hite + "px",
                            background: "url('" + HTTP_ROOT + "img/arrow_dwn.png') no-repeat"
                        });
                    });
                }
            });
            $('.kbtask_div').draggable({
                cursor: "move",
                helper: 'clone',
                containment: '.kanban-main',
                scroll: false,
                revert: "invalid",
                zIndex: 100,
                cursorAt: {
                    top: 15,
                    left: 18
                },
                start: function() {},
                drag: function(event, ui) {
                    $(ui.helper).find('span.dropdown .dropdown-toggle').attr('aria-expanded', false);
                    $(ui.helper).find('span.dropdown').removeClass('open');
                    $(ui.helper).width('265px');
                    $(ui.helper).css('left', '+=100');
                    if (($(window).width() - event.clientX) < 150) {
                        $('.kanban-main').scrollLeft($('.kanban-main').scrollLeft() + 30);
                        $(ui.helper).css('left', '+=100');
                    }
                    if (event.clientX < 250) {
                        $('.kanban-main').scrollLeft($('.kanban-main').scrollLeft() - 30);
                        $(ui.helper).css('left', '-=100');
                    }
                },
                stop: function(event, ui) {
                    $("#show_milestonelist").stop(true, false);
                }
            });
            $(".kanban-child").droppable({
                accept: ".kbtask_div",
                drop: function(event, ui) {
                    $("#show_milestonelist").stop(true, false);
                    var project_id = $('.prjhid').val();
                    var task_uniq_id = $(ui.helper).find('h6[id^="titlehtml"]').attr('data-task');
                    var ext_mlst_id = $(ui.helper).parent().parent().parent().attr('id').split('_');
                    ext_mlst_id = ext_mlst_id[1];
                    var curr_mlst_id = $(event.target).attr('id').split('_');
                    curr_mlst_id = curr_mlst_id[1];
                    if (curr_mlst_id.trim() == '') {
                        showTopErrSucc('error', _("Please select a Task Group"));
                    } else if (ext_mlst_id == curr_mlst_id) {
                        $(ui.helper).css({
                            'top': '0px',
                            'left': '0px'
                        });
                    } else {
                        $(".kanban-child > .kanban_content").append($(ui.helper));
                        $(ui.helper).css({
                            'width': '25%'
                        });
                        $.post(HTTP_ROOT + 'milestones/switchTaskToMilestone', {
                            'taskid': '0',
                            'taskuid': task_uniq_id,
                            'curr_mlst_id': curr_mlst_id,
                            'project_id': project_id,
                            'ext_mlst_id': ext_mlst_id
                        }, function(res) {
                            if (res.status.trim() == 'success') {
                                showTopErrSucc('success', _('Task moved successfully.'));
                                if ($('#mlstab_cmpl_kanban').hasClass('active')) {
                                    showMilestoneList('', 0);
                                } else {
                                    showMilestoneList('', 1);
                                }
                            } else {
                                showTopErrSucc('error', _('Error in moving task to task group'));
                            }
                        }, 'json');
                    }
                }
            });
            $(".kanban-main").sortable({
                opacity: 0.6,
                cursor: 'grabbing',
                scroll: false,
                items: ".kanban-child:not(.fixed)",
                handle: ".dot-bar_kanban",
                containment: '.kanban-main',
                connectWith: '.kanban-main',
                sort: function(event, ui) {
                    var pos = parseInt($(window).height() - event.clientY);
                    if (pos < parseInt($(window).height() * .1)) {
                        $(window).scrollTop($(window).scrollTop() + 30);
                    } else if (event.clientY < 150) {
                        $(window).scrollTop($(window).scrollTop() - 30);
                    }
                },
                update: function(ev, ui) {
                    var mileIds = new Array();
                    $(".kanban-child:not(.fixed)").each(function() {
                        mileIds.push($(this).attr('id').replace("milestone_", ""));
                    });
                    var url = HTTP_ROOT + "milestones/update_sequence_milestones";
                    $.post(url, {
                        "mileIds": mileIds,
                        'casePage': 1
                    }, function(res1) {
                        if (res1) {
                            showTopErrSucc('success', _('Task group reorder successfully.'));
                            showMilestoneList();
                        }
                    });
                }
            });
            $("div [id^='set_due_date_']").each(function(i) {
                $(this).datepicker({
                    altField: "#CS_due_date",
                    showOn: "button",
                    buttonImage: HTTP_ROOT + "img/images/calendar.png",
                    buttonStyle: "background:#FFF;",
                    todayHighlight: true,
                    changeMonth: false,
                    changeYear: false,
                    minDate: 0,
                    hideIfNoPrevNext: true,
                    onSelect: function(dateText, inst) {
                        var caseId = $(this).parents('.cstm-dt-option').attr('data-csatid');
                        var datelod = "datelod" + caseId;
                        var showUpdDueDate = "showUpdDueDate" + caseId;
                        var old_duetxt = $("#" + showUpdDueDate).html();
                        $("#" + showUpdDueDate).html("");
                        $("#" + datelod).show();
                        var text = '';
                        $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
                            "caseId": caseId,
                            "duedt": dateText,
                            "text": text
                        }, function(data) {
                            if (data) {
                                $("#" + datelod).hide();
                                if (typeof data.success != 'undefined' && data.success == 'No') {
                                    showTopErrSucc('error', data.message);
                                    $("#" + showUpdDueDate).html(old_duetxt);
                                    return false;
                                }
                                $("#" + showUpdDueDate).html(data.top + '<span class="due_dt_icn"></span>');
                            }
                        }, 'json');
                    }
                });
            });
            var clearCaseSearch = $('#clearCaseSearch').val();
            $('#clearCaseSearch').val("");
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
        }
        resetBreadcrumbFilters(HTTP_ROOT + 'requests/', caseStatus, caseCustomStatus, priFil, caseTypes, caseMember, caseComment, caseAssignTo, 0, case_date, case_due_date, casePage, caseSearch, clearCaseSearch, 'kanban', '', caseLabel);
        $('#caseKanbanDv').hide();
        $('#filter_det').show();
    });
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
    $('#manage_milestonelist').css('display', 'block');
}
ManageMilestoneList = function(mlsttype, search_key) {
    $('#view_type').val('grid');
    $('#mlview_btn,mkbview_btn').tipsy({
        gravity: 'n',
        fade: true
    });
    if (!search_key) {
        search_key = $('#search_text').val();
    }
    $(".side-nav li").removeClass('active');
    $(".menu-milestone").addClass('active');
    if (typeof(mlsttype) == 'undefined') {
        mlsttype = $('#mlsttabvalue').val();
    } else {
        $('#mlsttabvalue').val(mlsttype);
        $('#mlstPage').val(1);
    }
    $('#mlsttab li').removeClass('active');
    if (!parseInt(mlsttype)) {
        $('#mlstab_cmpl').addClass('active');
        $('#storeIsActivegrid').val('0');
    } else {
        $('#mlstab_act').addClass('active');
        $('#storeIsActivegrid').val(1);
    }
    $("#brdcrmb-cse-hdr").html('Task Groups');
    $('#caseLoader').show();
    $('#select_view_mlst div').removeClass('disable');
    $('#mlview_btn').addClass('disable');
    var projFil = $('#projFil').val();
    var projIsChange = $('#projIsChange').val();
    var mPage = $('#mlstPage').val();
    var mURL = HTTP_ROOT + "milestones/manage_milestone";
    easycase.routerHideShow('milestone');
    $("#caseMenuFilters").val('milestone');
    $('#milestoneUid').val('');
    $('#milestoneId').val('');
    $.post(mURL, {
        "projFil": projFil,
        "projIsChange": projIsChange,
        'page': mPage,
        "caseMenuFilters": 'milestone',
        'mlsttype': mlsttype,
        "file_srch": search_key
    }, function(res) {
        if (res) {
            refreshManageMilestone = 0;
            $('#caseLoader').hide();
            var result = document.getElementById('manage_milestone_list');
            result.innerHTML = tmpl("manage_milestone_tmpl", res);
            $(".proj_mng_div .contain").hover(function() {
                $(this).find(".proj_mng").stop(true, true).animate({
                    bottom: "0px",
                    opacity: 1
                }, 400);
            }, function() {
                $(this).find(".proj_mng").stop(true, true).animate({
                    bottom: "-42px",
                    opacity: 0
                }, 400);
            });
            $('#clearCaseSearch').val("");
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
        }
    });
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
}

function trackclick(msg) {}

function CaseDashboard(pjid, pname) {
    var prjid = $('#projFil').val();
    if (pjid != prjid) {
        resetAllFilters('all', 1);
    }
    $('#curr_active_project').val(pjid);
    $('#CS_project_id').val(pjid);
    $('#projUpdateTop').html(decodeURIComponent(pname));
    var fst = $('#pname_dashboard_hid').val();
    var secnd = $('#first_recent_hid').val();
    var thrd = $('#second_recent_hid').val();
    var decodepname = decodeURIComponent(pname);
    var ucpname = decodepname;
    var cnt = "<a href='javascript:void(0);' onClick='CaseDashboard(\"" + pjid + "\",\"" + pname + "\");'>" + ucpname + "</a>";
    if (secnd == ucpname) {
        $('#first_recent').html($('#pname_dashboard').html());
        $('#pname_dashboard').html(cnt);
        $('#first_recent_hid').val(fst);
        $('#pname_dashboard_hid').val(secnd);
    } else if (thrd == ucpname) {
        $('#second_recent').html($('#first_recent').html());
        $('#first_recent').html($('#pname_dashboard').html());
        $('#pname_dashboard').html(cnt);
        $('#second_recent_hid').val(secnd);
        $('#first_recent_hid').val(fst);
        $('#pname_dashboard_hid').val(thrd);
    } else if (fst == ucpname) {
        $('#pname_dashboard').html(cnt);
    } else {
        $('#second_recent').html($('#first_recent').html());
        $('#first_recent').html($('#pname_dashboard').html());
        $('#pname_dashboard').html(cnt);
        $('#second_recent_hid').val(secnd);
        $('#first_recent_hid').val(fst);
        $('#pname_dashboard_hid').val(ucpname);
    }
    $('#projpopup').hide();
    $("#find_prj_dv").hide();
    $('#prj_drpdwn').removeClass("open");
    $(".dropdown-menu.lft").hide();
    loadDashboardPage(pjid);
    general.update_footer_total(pjid);
}
var dashboard_app = angular.module('dashboard_App', ['ngSanitize', 'commonMethods']).provider('moment', function() {
    this.$get = function() {
        return moment
    }
});
dashboard_app.controller("dashboard_Controller", function($scope, $http, osCommonMethods) {
    $scope.osCommonMethods = osCommonMethods;
    $scope.to_dos = {};
    $scope.od_label = 0;
    $scope.td_label = 0;
    $scope.SES_ID = SES_ID;
    $scope.SES_TYPE = SES_TYPE;
    $scope.task_status = {
        "new_task_pro": 1,
        "wip_task_proj": 1,
        "resolved_task_proj": 1,
        "closed_task_proj": 1
    };
    $scope.prevmnthhour = [];
    $scope.thismnthhour = [];
    $scope.futurehour = [];
    $scope.uptxt = [];
    $scope.upcls = [];
    $scope.totxt = [];
    $scope.percentage = [];
    $scope.percentageUp = [];
    $scope.init = function(id) {
        $scope.projid = id;
        $scope.usage = "";
        $scope.loadDashboard();
    }
    $scope.projectBodyClick = function(key, event) {
        projectBodyClick(key, event);
    }
    $scope.switchtaskwithProject = function($event) {
        var hrf = $($event.currentTarget).attr('data-hrf');
        var caseUniqId = $($event.currentTarget).attr('data-pid');
        $http.post(HTTP_ROOT + "easycases/switchmyproj", $.param({
            'easycase_uid': $($event.currentTarget).attr('data-pid')
        }), {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }).success(function(data, status, headers, config) {
            $('#projFil').val(data);
            $("#myModalDetail").modal();
            $(".task_details_popup").show();
            $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
            $("#cnt_task_detail_kb").html("");
            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
        });
    }
    $scope.loadSeqDashboardAjax = function(sequency, projid, extra) {
        (sequency[sequency.length - 1] == 'recent_projects' && projid !== 'all') ? sequency.pop(): '';
        var url = HTTP_ROOT + "easycases/";
        var action = sequency[sequency.length - 1];
        var task_type_id = 0;
        if (sequency[sequency.length - 1] === 'task_types') {
            task_type_id = $("#sel_task_types").val();
            if (projid == 'all' && action == 'task_types') {
                $('#list_pie_chart').show();
                taskTypeDistribution(projid);
            } else {
                $('#list_pie_chart').show();
                taskTypeDistribution(projid, extra);
            }
        }
        $scope.downloadFile = function() {
            var request_file = getCookie('REQUESTED_FILE');
            if ($.trim(request_file)) {
                createCookie("REQUESTED_FILE", '', -365, DOMAIN_COOKIE);
                window.location = HTTP_ROOT + 'easycases/download/' + request_file;
            }
        }
        if (sequency[sequency.length - 1] === 'recent_activities') {
            if (projid == 'all') {
                $('#cret_fst_milestone').text(_('Create Task Group'));
                $('#invt_mor_user').text(_('Add New User'));
                $('#cret_anthor_proj').text(_('Create Project'));
            } else {
                $('#cret_fst_milestone').text(_('Create Task Group'));
                $('#invt_mor_user').text(_('Add New User'));
                $('#cret_anthor_proj').text(_('Create Project'));
            }
        }
        var data = $.param({
            extra: typeof extra != 'undefined' ? extra : '',
            task_type_id: task_type_id,
            projid: projid,
            angular: 1
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            },
            responseType: ""
        }
        if (action == 'dashboardbookmarkslist') {
            url = HTTP_ROOT + "bookmarks/";
        }
        $http.post(url + action, data, config).success(function(res, status, headers, config) {
            $scope.cmnDashboard(action, res, extra);
            sequency.pop();
            if (sequency.length >= 1) {
                $scope.loadSeqDashboardAjax(sequency, projid, extra);
            }
            if (parseInt(sequency.length) === 0) {
                $scope.downloadFile();
            }
        });
    }
    $scope.cmnDashboard = function(id, res, extra) {
        if ($scope.usage == '')
            $scope.usage = '';
        if (id == 'task_piechart') {
            $("#loader-taskPieChartId").hide();
            $("#taskPieChartId").show();
            $("#taskPieChartId").html(res);
        }
        if (id == 'workload_chart') {
            $("#loader-workloadChartId").hide();
            $("#workloadChartId").show();
            $("#workloadChartId").html(res);
        }
        if (id == 'spent_hour') {
            $("#spent_hr_stdt").html(res.spent_hours);
        }
        if (id == 'my_tasks') {
            $("#loader-mytaskId").hide();
            $("#myTaskId").html(tmpl("my_task_tmpl", res));
        }
        if (id == 'my_overdue') {
            $("#loader-overdueId").hide();
            $("#myOverdueTaskId").html(tmpl("my_overdue_tmpl", res));
        }
        if (id == 'my_progress') {
            $("#loader-progressDashboardId").hide();
            $("#progressDashboardId").html(tmpl("my_progress_tmpl", res));
        }
        if (id == 'task_types') {
            if (SES_TYPE == 3) {
                iniChartTskProgress(id, res);
            }
        } else if (id == 'task_status') {
            $scope.task_status.new_task_pro = 0;
            $scope.task_status.wip_task_proj = 0;
            $scope.task_status.resolved_task_proj = 0;
            $scope.task_status.closed_task_proj = 0;
            if (SES_TYPE < 3) {
                if (res) {
                    $('#my_task-status').show();
                    $('.status-bar').html(res);
                } else {
                    $('#ul_mydashboard').css('margin-top', '48px');
                    $('#my_task-status').hide();
                }
            } else if (SES_TYPE == 3) {
                if (res.task_prog) {
                    $('#ul_mydashboard').css('margin-top', '1px');
                    $.each(res.task_prog, function(index, value) {
                        var width = value.y - 0.1;
                        if (value.name == 'New' && width > 0) {
                            $scope.task_status.new_task_pro = value.y;
                            $('#new_task_proj').css({
                                'background': value.color,
                                'width': width + '%'
                            });
                        } else if (value.name == 'In Progress' && width > 0) {
                            $scope.task_status.wip_task_proj = 1;
                            $('#wip_task_proj').css({
                                'background': value.color,
                                'width': width + '%'
                            });
                        } else if (value.name == 'Resolved' && width > 0) {
                            $scope.task_status.resolved_task_proj = 1;
                            $('#resolved_task_proj').css({
                                'background': value.color,
                                'width': width + '%'
                            });
                        } else if (value.name == 'Closed' && width > 0) {
                            $scope.task_status.closed_task_proj = 1;
                            $('#closed_task_proj').css({
                                'background': value.color,
                                'width': width + '%'
                            });
                        }
                    });
                    $('#my_task-status').show();
                } else {
                    $('#ul_mydashboard').css('margin-top', '48px');
                    $('#my_task-status').hide();
                }
            }
        } else if (id == 'recent_activities') {
            $("#loader-activities").hide();
            if (!$('.task_action_bar').is(':visible')) {
                $('.activity-txt').show();
            }
            $scope.activity = res;
            $scope.SES_ID = SES_ID;
            if ($("#" + id + "_more").length > 0 && $("#" + id + "_more").attr("data-value") && ($("#" + id + "_more").attr("data-value") > 10)) {
                $("#more_" + id).show();
                $("#more_" + id + ' span#todos_cnt').html('(' + $("#" + id + "_more").attr("data-value") + ')').show();
            }
        } else if (id == 'all_projects') {
            $("#" + id + "_ldr").hide();
            $('#all_projects').html(res);
        } else if (id == 'all_clients') {
            $("#" + id + "_ldr").hide();
            iniDashboardClients(id, res);
        } else if (id == 'dashboard_timelog') {
            $("#" + id + "_ldr").hide();
            iniDashboardTimelog(id, res);
        } else if (id == 'project_status') {
            $("#" + id + "_ldr").hide();
            if (SES_TYPE < 3) {
                iniDashboardTaskstatus(id, res);
            }
        } else if (id == 'dashboard_status') {
            $("#" + id + "_ldr").hide();
            $('#dashboard_status').html(res);
        } else if (id == 'admin_task_status') {
            $scope.admin_task = res;
        } else if (id == 'to_dos') {
            $scope.to_dos = res;
        } else if (id == 'project_resource_utilization') {
            $scope.resource = res;
        } else {
            if (id == 'usage_details') {
                $scope.usage = res;
            } else {
                $("#" + id + "_ldr").hide();
                if (id == 'statistics') {
                    $scope.statistics = res;
                    if (extra == 'overview') {} else {}
                } else {
                    $("#" + id).html(res);
                }
                if ($("#" + id + "_more").length > 0 && $("#" + id + "_more").attr("data-value") && ($("#" + id + "_more").attr("data-value") > 10)) {
                    $("#more_" + id).show();
                    $("#more_" + id + ' span#todos_cnt').html('(' + $("#" + id + "_more").attr("data-value") + ')').show();
                }
                var only_od_overview = $('#only_overdue_count').val();
                if (only_od_overview > 5) {
                    $("#moreover_" + id).show();
                    $("#moreover_" + id + ' span#todos_cnt').html('(' + only_od_overview + ')').show();
                }
                $('.custom_scroll').jScrollPane({
                    autoReinitialise: true
                });
                if (id == 'project_users') {
                    $('[rel=tooltip]').tipsy({
                        gravity: 's',
                        fade: true
                    });
                }
            }
        }
    }
    $scope.loadDashboard = function() {
        if ($scope.projid == 'all') {
            localStorage.setItem('ALL_PROJECT', 'all');
        } else {
            localStorage.setItem('ALL_PROJECT', '');
        }
        if (CONTROLLER == 'easycases' && PAGE_NAME == 'mydashboard' && SES_TYPE < 3) {
            $scope.projid = 'all';
        }
        var orderStr = Array();
        if (getCookie('DASHBOARD_ORDER') && $.inArray('7', getCookie('DASHBOARD_ORDER').split('::')[1].split(',')) === -1) {
            var orderCookie = getCookie('DASHBOARD_ORDER').split('::')[1].split(',');
            for (var i in orderCookie) {
                if (DASHBOARD_ORDER[orderCookie[i]]) {
                    orderStr.push(DASHBOARD_ORDER[orderCookie[i]].name.toLowerCase().replace(' ', '_'));
                }
            }
        } else {
            for (var i in DASHBOARD_ORDER) {
                orderStr.push(DASHBOARD_ORDER[i].name.toLowerCase().replace(' ', '_'));
            }
        }
        $scope.sequency = orderStr;
        ($scope.projid == 'all') ? $('#list_2').show(): $('#list_2').hide();
        $(".loader_dv_db").show();
        $(".moredb").hide();
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
        var dncRecentProj = 0;
        if ($scope.projid != 'all') {
            dncRecentProj = 1;
        }
        $scope.sequency.reverse();
        $scope.loadSeqDashboardAjax($scope.sequency, $scope.projid);
    }
    $scope.checkLastDate = function(i) {
        if (i == 0) {
            $scope.lastdate = '';
        } else {
            $scope.lastdate = $scope.activity.recent_activities[i - 1].Easycase.newActuldt;
        }
        return $scope.lastdate == $scope.activity.recent_activities[i].Easycase.newActuldt;
    }
    $scope.setDates = function(i, v) {
        if (typeof $scope.resource != 'undefined' & v != 'undefined') {
            $scope.prevmnthhour[i] = (typeof $scope.resource.prevmonthdata != 'undefined') ? $scope.resource.prevmonthdata[i][v] : 0;
            $scope.thismnthhour[i] = (typeof $scope.resource.thismonthdata != 'undefined') ? $scope.resource.thismonthdata[i][v] : 0;
            $scope.futurehour[i] = (typeof $scope.resource.futureWorkdata != 'undefined') ? $scope.resource.futureWorkdata[i][v] : 0;
        } else {
            $scope.prevmnthhour[i] = 0;
            $scope.thismnthhour[i] = 0
            $scope.futurehour[i] = 0;
        }
        $scope.uptxt[i] = '';
        $scope.upcls[i] = '';
        $scope.totxt[i] = ' ' + _('from') + ' ';
        $scope.percentage[i] = '';
        $scope.percentageUp[i] = '';
        if ($scope.thismnthhour[i] > $scope.prevmnthhour[i]) {
            $scope.uptxt[i] = ' ' + _('Up');
            $scope.upcls[i] = 'up-div';
            $scope.percentage[i] = parseInt((($scope.thismnthhour[i] - $scope.prevmnthhour[i]) / $scope.prevmnthhour[i]) * 100);
            $scope.percentageUp[i] = $scope.percentage[i] - 100;
        } else if ($scope.thismnthhour[i] < $scope.prevmnthhour[i]) {
            $scope.uptxt[i] = ' ' + _('Down') + ' ';
            $scope.upcls[i] = 'down-div';
            $scope.percentage[i] = parseInt((($scope.thismnthhour[i] - $scope.prevmnthhour[i]) / $scope.prevmnthhour[i]) * 100);
            $scope.percentageUp[i] = (100 - parseInt($scope.percentage[i])) + '% ';
        } else {
            $scope.uptxt[i] = ' ' + _('Equals') + ' ';
            $scope.upcls[i] = ' up-div ';
            $scope.totxt[i] = ' ' + _('to') + ' ';
        }
    }
    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
        cnt = 0;
        $.each($scope.admin_task.series, function(key, project) {
            var data_arr = [];
            $.each(project, function(key_i, project_i) {
                if (key_i != '') {
                    var sts = {
                        y: project_i.cnt,
                        name: key_i,
                        marker: {
                            fillColor: '#' + project_i.color,
                        }
                    };
                    data_arr.push(sts);
                }
            });
            cnt++;
            $('#' + cnt + '_prj').highcharts({
                chart: {
                    type: 'spline',
                    height: 90
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [],
                    lineWidth: 1,
                    minorGridLineWidth: 1,
                    gridLineColor: "transparent",
                    gridLineDashStyle: "none",
                    gridLineWidth: 0
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    gridLineColor: "transparent",
                    gridLineDashStyle: "none",
                    gridLineWidth: 1
                },
                tooltip: {
                    crosshairs: false,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#000000',
                            lineWidth: 1
                        }
                    }
                },
                series: [{
                    name: _('count'),
                    marker: {
                        symbol: "circle"
                    },
                    data: data_arr
                }]
            });
        });
    });
}).filter('moment', function(moment) {
    return function(input, options) {
        return moment(input).locale('eng').format(options.split('\'')[1])
    }
});
dashboard_app.directive('onFinishRender', ['$timeout', '$parse', function($timeout, $parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function() {
                    scope.$emit('ngRepeatFinished');
                    if (!!attr.onFinishRender) {
                        $parse(attr.onFinishRender)(scope);
                    }
                });
            }
        }
    }
}]);

function loadDashboardPage(projid) {
    $("#new_recent_activities").html('');
    $("#loader-activities").show();
    $("#myOverdueTaskId").html('');
    $("#loader-overdueId").show();
    $("#myTaskId").html('');
    $("#loader-mytaskId").show();
    $("#progressDashboardId").html('');
    $("#loader-progressDashboardId").show();
    $("#progressDashboardId").html('');
    $("#loader-progressDashboardId").show();
    $("#taskPieChartId").html('');
    $("#loader-taskPieChartId").show();
    $("#taskPieChartId").hide();
    $("#workloadChartId").html('');
    $("#loader-workloadChartId").show();
    $("#workloadChartId").hide();
    if (projid == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
    if (CONTROLLER == 'easycases' && PAGE_NAME == 'mydashboard' && SES_TYPE < 3) {
        projid = 'all';
    }
    var orderStr = Array();
    if (getCookie('DASHBOARD_ORDER') && $.inArray('7', getCookie('DASHBOARD_ORDER').split('::')[1].split(',')) === -1) {
        var orderCookie = getCookie('DASHBOARD_ORDER').split('::')[1].split(',');
        for (var i in orderCookie) {
            if (DASHBOARD_ORDER[orderCookie[i]]) {
                orderStr.push(DASHBOARD_ORDER[orderCookie[i]].name.toLowerCase().replace(' ', '_'));
            }
        }
    } else {
        for (var i in DASHBOARD_ORDER) {
            orderStr.push(DASHBOARD_ORDER[i].name.toLowerCase().replace(' ', '_'));
        }
    }
    var sequency = orderStr;
    for (var i in sequency) {
        if ($("#" + sequency[i]).html() !== '') {
            $("#" + sequency[i]).html('');
        }
    }
    (projid == 'all') ? $('#list_2').show(): $('#list_2').hide();
    $(".loader_dv_db").show();
    $(".moredb").hide();
    $('[rel=tooltip]').tipsy({
        gravity: 's',
        fade: true
    });
    var dncRecentProj = 0;
    if (projid != 'all') {
        dncRecentProj = 1;
    }
    sequency.reverse();
    loadSeqDashboardAjax(sequency, projid);
}

function loadSeqDashboardAjax(sequency, projid, extra) {
    (sequency[sequency.length - 1] == 'recent_projects' && projid !== 'all') ? sequency.pop(): '';
    var url = HTTP_ROOT + "easycases/";
    var action = sequency[sequency.length - 1];
    var task_type_id = 0;
    if (sequency[sequency.length - 1] === 'task_types') {
        task_type_id = $("#sel_task_types").val();
        if (projid == 'all' && action == 'task_types') {
            $('#list_pie_chart').show();
            taskTypeDistribution(projid);
        } else {
            $('#list_pie_chart').show();
            taskTypeDistribution(projid, extra);
        }
    }
    if (sequency[sequency.length - 1] === 'recent_activities') {
        if (projid == 'all') {
            $('#cret_fst_milestone').text(_('Create Task Group'));
            $('#invt_mor_user').text(_('Add New User'));
            $('#cret_anthor_proj').text(_('Create Project'));
        } else {
            $('#cret_fst_milestone').text(_('Create Task Group'));
            $('#invt_mor_user').text(_('Add New User'));
            $('#cret_anthor_proj').text(_('Create Project'));
        }
    }
    $.post(url + action, {
        "projid": projid,
        "task_type_id": task_type_id,
        extra: typeof extra != 'undefined' ? extra : ''
    }, function(res) {
        if (res) {
            cmnDashboard(action, res, extra);
            sequency.pop();
            if (sequency.length >= 1) {
                loadSeqDashboardAjax(sequency, projid, extra);
            }
            if (parseInt(sequency.length) === 0) {
                downloadFile();
            }
            if (action == 'hours_linechart') {
                var fsdate = $("#foverStartDate").val();
                var fedate = $("#foverEndDate").val();
                $("#dateRangeId").text("( " + _('From') + " : " + fsdate + " - " + _('To') + " : " + fedate + ")");
            }
        }
    });
}

function downloadFile() {
    var request_file = getCookie('REQUESTED_FILE');
    if ($.trim(request_file)) {
        createCookie("REQUESTED_FILE", '', -365, DOMAIN_COOKIE);
        window.location = HTTP_ROOT + 'easycases/download/' + request_file;
    }
}
var usage = '';

function cmnDashboard(id, res, extra) {
    if (usage == '')
        usage = '';
    if (id == 'spent_hour') {
        var spent = JSON.parse(res);
        $("#spent_hr_stdt").html('');
        $("#spent_hr_stdt").html(spent.spent_hours);
    } else if (id == 'my_tasks') {
        $("#loader-mytaskId").hide();
        $("#myTaskId").html(tmpl("my_task_tmpl", res));
    } else if (id == 'my_overdue') {
        $("#loader-overdueId").hide();
        $("#myOverdueTaskId").html(tmpl("my_overdue_tmpl", res));
    } else if (id == 'my_progress') {
        $("#loader-progressDashboardId").hide();
        $("#progressDashboardId").html(tmpl("my_progress_tmpl", res));
    } else if (id == 'task_piechart') {
        $("#loader-taskPieChartId").hide();
        $("#taskPieChartId").show();
        $("#taskPieChartId").html(res);
    } else if (id == 'workload_chart') {
        $("#loader-workloadChartId").hide();
        $("#workloadChartId").show();
        $("#workloadChartId").html(res);
    } else if (id == 'task_types') {
        if (SES_TYPE == 3) {
            iniChartTskProgress(id, res);
        }
    } else if (id == 'task_status') {
        $('#new_task_proj').hide();
        $('#wip_task_proj').hide();
        $('#resolved_task_proj').hide();
        $('#closed_task_proj').hide();
        if (SES_TYPE < 3) {
            if (res) {
                $('#my_task-status').show();
                $('.status-bar').html(res);
            } else {
                $('#ul_mydashboard').css('margin-top', '48px');
                $('#my_task-status').hide();
            }
        } else if (SES_TYPE == 3) {
            if (res.task_prog) {
                $('#ul_mydashboard').css('margin-top', '1px');
                $.each(res.task_prog, function(index, value) {
                    var width = value.y - 0.1;
                    if (value.name == 'New' && width > 0) {
                        $('#new_task_proj').css({
                            'background': value.color,
                            'width': width + '%'
                        });
                        $('#new_task_proj').html(value.y + '%');
                        $('#new_task_proj').attr('title', value.y + '% New');
                        $('#new_task_proj').show();
                    } else if (value.name == 'In Progress' && width > 0) {
                        $('#wip_task_proj').css({
                            'background': value.color,
                            'width': width + '%'
                        });
                        $('#wip_task_proj').html(value.y + '%');
                        $('#wip_task_proj').attr('title', value.y + '% In-Progress');
                        $('#wip_task_proj').show();
                    } else if (value.name == 'Resolved' && width > 0) {
                        $('#resolved_task_proj').css({
                            'background': value.color,
                            'width': width + '%'
                        });
                        $('#resolved_task_proj').html(value.y + '%');
                        $('#resolved_task_proj').attr('title', value.y + '% Resolved');
                        $('#resolved_task_proj').show();
                    } else if (value.name == 'Closed' && width > 0) {
                        $('#closed_task_proj').css({
                            'background': value.color,
                            'width': width + '%'
                        });
                        $('#closed_task_proj').html(value.y + '%');
                        $('#closed_task_proj').attr('title', value.y + '% Closed');
                        $('#closed_task_proj').show();
                    }
                });
                $('#my_task-status').show();
            } else {
                $('#ul_mydashboard').css('margin-top', '48px');
                $('#my_task-status').hide();
            }
        }
    } else if (id == 'recent_activities') {
        $("#loader-activities").hide();
        if (!$('.task_action_bar').is(':visible')) {
            $('.activity-txt').show();
        }
        $('#new_recent_activities').html(res);
        $('#loader-new_recent_activities').hide();
        if ($("#" + id + "_more").length > 0 && $("#" + id + "_more").attr("data-value") && ($("#" + id + "_more").attr("data-value") > 10)) {
            $("#more_" + id).show();
            $("#more_" + id + ' span#todos_cnt').html('(' + $("#" + id + "_more").attr("data-value") + ')').show();
            $('#ov_atvt_entry_cnt').html($("#" + id + "_more").attr("data-value"));
        }
    } else if (id == 'all_projects') {
        $("#" + id + "_ldr").hide();
        $('#all_projects').html(res);
    } else if (id == 'all_clients') {
        $("#" + id + "_ldr").hide();
        $('#all_clients').html(res);
    } else if (id == 'dashboard_timelog') {
        $("#" + id + "_ldr").hide();
        $('#dashboard_timelog').html(res);
    } else if (id == 'project_status') {
        $("#" + id + "_ldr").hide();
        $('#project_status').html(res);
        $('#loader-project_status').hide();
    } else if (id == 'dashboard_status') {
        $("#" + id + "_ldr").hide();
        $('#dashboard_status').html(res);
    } else if (id == 'admin_task_status') {
        $("#" + id + "_ldr").hide();
        $('#admin_task_status').html(res);
    } else {
        if (id == 'usage_details') {
            usage = res;
            if (extra == 'overview') {
                $("#statistics").append(res);
            }
        } else {
            $("#" + id + "_ldr").hide();
            $('#loader-' + id).hide();
            if (id == 'statistics') {
                if (extra == 'overview') {
                    $("#" + id).append(res);
                } else {
                    $("#" + id).html(res);
                    $("#" + id).append(usage);
                }
            } else {
                $("#" + id).html(res);
            }
            if ($("#" + id + "_more").length > 0 && $("#" + id + "_more").attr("data-value") && ($("#" + id + "_more").attr("data-value") > 10)) {
                $("#more_" + id).show();
                $("#more_" + id + ' span#todos_cnt').html('(' + $("#" + id + "_more").attr("data-value") + ')').show();
            }
            var only_od_overview = $('#only_overdue_count').val();
            if (only_od_overview > 5) {
                $("#moreover_" + id).show();
                $("#moreover_" + id + ' span#todos_cnt').html('(' + only_od_overview + ')').show();
            }
            $('.custom_scroll').jScrollPane({
                autoReinitialise: true
            });
            if (id == 'project_users') {
                $('[rel=tooltip]').tipsy({
                    gravity: 's',
                    fade: true
                });
            }
        }
    }
}

function showTaskStatus(obj, projid) {
    if ($("#task_types").html() !== '') {
        $("#task_types").html('');
        $("#task_types_msg").html('');
    }
    $("#task_types_ldr").show();
    var url = HTTP_ROOT + "easycases/task_types";
    var task_type_id = $(obj).val();
    createCookie("TASK_TYPE_IN_DASHBOARD", task_type_id, 365, DOMAIN_COOKIE);
    $.post(url, {
        "projid": projid,
        "task_type_id": task_type_id
    }, function(res) {
        if (res) {
            cmnDashboard("task_types", res);
        }
    });
}

function taskTypeDistribution(projid, extra) {
    var hash = window.location.hash.substr(1).split('/');
    var showLabel = true;
    var extra = '';
    if (typeof hash[1] != 'undefined' && hash[1] == 'overview') {
        showLabel = false;
        extra = 'overview';
    }
    var url = HTTP_ROOT + "requests/";
    var action = 'ajax_case_status';
    $.post(url + action, {
        "projUniq": projid,
        "pageload": 0,
        "caseMenuFilters": '',
        'case_date': '',
        'case_due_date': '',
        'caseStatus': 'all',
        'caseTypes': '',
        'priFil': 'all',
        'caseMember': 'all',
        'caseComment': 'all',
        'caseAssignTo': 'all',
        'caseSearch': '',
        'milestoneIds': 'all',
        'checktype': '',
        'page_type': 'ajax_types',
        'page_type_pie': 1,
        "pageload": 0,
        'extra': extra
    }, function(data) {
        if (data) {
            $('#task_status_ldr_pie').hide();
            $('#loader-task_status_pie').hide();
            var dat = data;
            if (dat.total_cnt) {
                $('#tot_tsx_typ_cnt').text(dat.total_cnt);
            }
            if (dat.status == 'success' && parseInt(dat.total_cnt) > 0) {
                $('#task_status_pie').html('');
                chart = new Highcharts.Chart({
                    credits: {
                        enabled: false
                    },
                    chart: {
                        renderTo: 'task_status_pie',
                        type: 'pie'
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
                            shadow: false
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>' + this.point.project_name + '</b>: ' + this.y;
                        }
                    },
                    series: [{
                        name: 'Browsers',
                        data: dat.data,
                        size: '120%',
                        innerSize: '70%',
                        showInLegend: true,
                        marker: {
                            symbol: "circle",
                            radius: 4
                        },
                        dataLabels: {
                            enabled: false
                        }
                    }],
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: 0,
                        y: 20,
                        borderWidth: 0,
                        labelFormatter: function() {
                            return '<span title="' + this.project_name + '">' + this.name + ' - ' + this.y + '</span>';
                        }
                    },
                });
            } else {
                $('#task_status_pie').html('<img src="/img/sample/dashboard/task_types_pie.jpg" style="width:98%;">');
            }
        }
    }, 'json');
}

function iniDashboardClients(id, res) {
    $("#" + id + "_ldr").hide();
    if (res.status != '') {
        var piedata = res.piearr;
        $('#clients_piechart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.point.name + ': </b>' + this.point.count + '<br><b>' + this.point.name + '</b>: ' + parseFloat((this.point.percentage).toPrecision(3)) + ' %';
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        formatter: function() {
                            var precsson = 3;
                            if (this.point.percentage < 1)
                                precsson = 2;
                            if (this.point.percentage >= 10)
                                precsson = 4;
                            return this.point.percentage > 1 ? parseFloat((this.point.percentage).toPrecision(precsson)) + '% ' + this.point.name + '</b>' : null;
                        }
                    },
                    showInLegend: true
                }
            },
            legend: {
                enabled: true,
                labelFormatter: function() {
                    return this.name + ' - ' + this.count;
                }
            },
            series: [{
                type: 'pie',
                name: _('Clients'),
                data: eval(piedata)
            }]
        });
    } else {
        $('#clients_piechart').html('<img src="' + HTTP_ROOT + '/img/sample/dashboard/clients.jpg">');
    }
}

function iniDashboardTimelog(id, res) {
    $("#" + id + "_ldr").hide();
    var dt = res.dates;
    var series = res.series;
    var intr_val = res.tinterval;
    if (typeof res.imag != '') {
        $('#dboardtimelog').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: _('Time log')
            },
            exporting: {
                enabled: false,
                buttons: {
                    contextButton: {
                        symbolStrokeWidth: 2,
                        symbolStroke: '#969696',
                        menuItems: [{
                            text: 'PNG',
                            onclick: function() {
                                this.exportChart();
                            },
                            separator: false
                        }, {
                            text: 'JPEG',
                            onclick: function() {
                                this.exportChart({
                                    type: 'image/jpeg'
                                });
                            },
                            separator: false
                        }, {
                            text: 'PDF',
                            onclick: function() {
                                this.exportChart({
                                    type: 'application/pdf'
                                });
                            },
                            separator: false
                        }, {
                            text: 'Print',
                            onclick: function() {
                                this.print();
                            },
                            separator: false
                        }]
                    }
                },
            },
            xAxis: {
                type: 'datetime',
                categories: eval(dt),
                showFirstLabel: true,
                showLastLabel: true,
                tickInterval: intr_val,
            },
            yAxis: {
                allowDecimals: false,
                gridLineWidth: 0,
                minorGridLineWidth: 0,
                min: 0,
                title: {
                    text: _('Hour(s) Spent')
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Total: ' + this.point.stackTotal;
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            series: series
        });
    } else {
        $('#dboardtimelog').html(res.imag);
    }
}

function iniDashboardTaskstatus(id, res) {
    var show_legend = (typeof arguments[2] != 'undefined') ? false : true;
    var pdf_ov = 0;
    if (typeof arguments[3] != 'undefined') {
        show_legend = true;
        pdf_ov = 1;
    }
    $("#" + id + "_ldr").hide();
    if (res.status != '') {
        var hash = window.location.hash.substr(1);
        if (hash != 'overview' && !pdf_ov) {
            var height = 230;
            var x = 0;
            var y = -40;
            var align = 'right';
            var verticalAlign = 'top';
            var innerSize = '50%';
            var width = 170;
            var layout = 'vertical';
            var text = '';
        } else {
            var height = 175;
            var x = -65;
            var y = 0;
            var align = 'right';
            var verticalAlign = 'middle';
            var innerSize = '95%';
            var width = 120;
            var layout = 'vertical';
            var text = res.closed + ' / ' + res.total + '<br> Closed';
        }
        var data = res.data;
        $('#project_status_pie' + res.fragment).highcharts({
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false,
                buttons: {
                    contextButton: {
                        symbolStrokeWidth: 2,
                        symbolStroke: '#969696',
                        menuItems: [{
                            text: 'PNG',
                            onclick: function() {
                                this.exportChart();
                            },
                            separator: false
                        }, {
                            text: 'JPEG',
                            onclick: function() {
                                this.exportChart({
                                    type: 'image/jpeg'
                                });
                            },
                            separator: false
                        }, {
                            text: 'PDF',
                            onclick: function() {
                                this.exportChart({
                                    type: 'application/pdf'
                                });
                            },
                            separator: false
                        }, {
                            text: 'Print',
                            onclick: function() {
                                this.print();
                            },
                            separator: false
                        }]
                    }
                },
            },
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                height: height
            },
            title: {
                align: "center",
                floating: true,
                margin: 0,
                style: {
                    "color": "#333333",
                    "fontSize": "18px"
                },
                text: text,
                useHTML: false,
                verticalAlign: "middle",
                x: x,
                y: y
            },
            tooltip: {
                formatter: function() {
                    var precsson = 3;
                    if (this.point.percentage < 1)
                        precsson = 2;
                    if (this.point.percentage >= 10)
                        precsson = 4;
                    return '<b>' + this.point.name + '</b>: ' + parseFloat((this.point.percentage).toPrecision(precsson)) + ' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    borderWidth: 0,
                    showInLegend: show_legend,
                    dataLabels: {
                        enabled: false,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            legend: {
                enabled: true,
                layout: layout,
                align: align,
                verticalAlign: verticalAlign,
                width: width,
                borderWidth: null,
                labelFormatter: function() {
                    return this.name + ' - ' + this.y + '';
                }
            },
            series: [{
                size: '100%',
                innerSize: innerSize,
                type: 'pie',
                name: ' ',
                data: data,
            }]
        });
    } else {
        $('#project_status_pie').html("<center><img src='/img/sample/dashboard/staus.png' alt='' style='max-width:100%;max-height:100%;'/></center>");
    }
}

function iniChartTskProgress(id, res) {
    $("#" + id + "_ldr").hide();
    $("#" + id + '_msg').html(res.sts_msg);
    $("#" + id + '_msg').attr('title', res.sts_msg_ttl);
    $('.custom_scroll').jScrollPane({
        autoReinitialise: true
    });
    if ($("#" + id).highcharts()) {
        $("#" + id).highcharts().destroy();
    }
    if (!res.task_prog) {
        $("#legendTaskTypeId").hide();
        if (id == 'task_type') {
            $("#" + id).html('<img src="img/sample/dashboard/task_types_pie.jpg" style="width:98%;">');
        } else {
            $("#" + id).html('<img src="img/sample/dashboard/task_types_pie.jpg" style="width:98%;margin-top:-11px;">');
        }
        return;
    }
    $("#legendTaskTypeId").show();
    var HighChartVars = {
        startAngle: -90,
        endAngle: 90,
        center: ['50%', '85%'],
        size: '130%',
        innerSize: '60%'
    }
    if (id == 'task_status') {
        HighChartVars = {
            startAngle: 0,
            endAngle: 0,
            center: ['50%', '47%'],
            size: '110%',
            innerSize: '50%'
        }
    }
    Highcharts.setOptions({
        lang: {
            contextButtonTitle: 'Download'
        }
    });
    $("#" + id).highcharts({
        credits: {
            enabled: false
        },
        exporting: {
            buttons: {
                contextButton: {
                    symbolStrokeWidth: 2,
                    symbolStroke: '#969696',
                    menuItems: [{
                        text: 'PNG',
                        onclick: function() {
                            this.exportChart();
                        },
                        separator: false
                    }, {
                        text: 'JPEG',
                        onclick: function() {
                            this.exportChart({
                                type: 'image/jpeg'
                            });
                        },
                        separator: false
                    }, {
                        text: 'PDF',
                        onclick: function() {
                            this.exportChart({
                                type: 'application/pdf'
                            });
                        },
                        separator: false
                    }, {
                        text: 'Print',
                        onclick: function() {
                            this.print();
                        },
                        separator: false
                    }]
                }
            },
            filename: id
        },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false,
            height: 250
        },
        title: {
            text: '',
            align: 'center',
            verticalAlign: 'middle',
            y: 50
        },
        tooltip: {
            formatter: function() {
                var precsson = 3;
                if (this.point.percentage < 1)
                    precsson = 2;
                if (this.point.percentage >= 10)
                    precsson = 4;
                return '<b>' + this.point.name + '</b>: ' + parseFloat((this.point.percentage).toPrecision(precsson)) + ' %';
            }
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -30,
                    color: 'white',
                    formatter: function() {
                        var precsson = 3;
                        if (this.point.percentage < 1)
                            precsson = 2;
                        if (this.point.percentage >= 10)
                            precsson = 4;
                        return this.point.percentage > 1 ? parseFloat((this.point.percentage).toPrecision(precsson)) + '%' : null;
                    }
                },
                startAngle: HighChartVars.startAngle,
                endAngle: HighChartVars.endAngle,
                center: HighChartVars.center,
                showInLegend: false,
                size: HighChartVars.size
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            innerSize: HighChartVars.innerSize,
            data: res.task_prog
        }]
    });
}

function showTasks(arg) {
    remember_filters("reset", "all");
    var action = 'tasks';
    if (arg == 'my') {
        createCookie("CURRENT_FILTER", 'assigntome', 365, DOMAIN_COOKIE);
        createCookie("STATUS", '2-1', 365, DOMAIN_COOKIE);
    } else if (arg == 'all') {
        createCookie("CURRENT_FILTER", 'cases', 365, DOMAIN_COOKIE);
    } else if (arg == 'activities') {
        var prjunid = $('#pname_dashboard_hid').val();
        if (prjunid.toLowerCase() == 'all') {
            showTopErrSucc('error', _('Oops! You are in') + " " + _('All') + " " + _('project. Please choose a project.'));
            return false;
        } else {
            action = 'activities';
        }
    }
    window.location = HTTP_ROOT + 'dashboard#' + action;
}

function remember_filters(name, value) {
    if (name == 'reset') {
        createCookie('STATUS', '', -1, DOMAIN_COOKIE);
        createCookie('CUSTOM_STATUS', '', -1, DOMAIN_COOKIE);
        createCookie('PRIORITY', '', -1, DOMAIN_COOKIE);
        createCookie('CS_TYPES', '', -1, DOMAIN_COOKIE);
        createCookie('MEMBERS', '', -1, DOMAIN_COOKIE);
        createCookie('COMMENTS', '', -1, DOMAIN_COOKIE);
        createCookie('ASSIGNTO', '', -1, DOMAIN_COOKIE);
        createCookie('DATE', '', -1, DOMAIN_COOKIE);
        createCookie('DUE_DATE', '', -1, DOMAIN_COOKIE);
        createCookie('MILESTONES', '', -1, DOMAIN_COOKIE);
        createCookie('TASKGROUP_FIL', '', -1, DOMAIN_COOKIE);
        createCookie('TASKGROUP', '', -1, DOMAIN_COOKIE);
        if (value == 'all') {
            createCookie('IS_SORT', '', -1, DOMAIN_COOKIE);
            createCookie('ORD_DATE', '', -1, DOMAIN_COOKIE);
            createCookie('ORD_TITLE', '', -1, DOMAIN_COOKIE);
            createCookie('CASESRCH', '', -1, DOMAIN_COOKIE);
            createCookie('SEARCH', '', -1, DOMAIN_COOKIE);
        }
        localStorage.removeItem('STATUS');
        localStorage.removeItem('CUSTOM_STATUS');
        localStorage.removeItem('PRIORITY');
        localStorage.removeItem('CS_TYPES');
        localStorage.removeItem('TASKLABEL');
        localStorage.removeItem('MEMBERS');
        localStorage.removeItem('COMMENTS');
        localStorage.removeItem('ASSIGNTO');
        localStorage.removeItem('DATE');
        localStorage.removeItem('DUE_DATE');
        localStorage.removeItem('MILESTONES');
        localStorage.removeItem('TASKGROUP_FIL');
        localStorage.removeItem('TASKGROUP');
        if (value == 'all') {
            localStorage.removeItem('IS_SORT');
            localStorage.removeItem('ORD_DATE');
            localStorage.removeItem('ORD_TITLE');
            localStorage.removeItem('CASESRCH');
            localStorage.removeItem('SEARCH');
            $('#caseMenuFilters').val('cases');
        }
    } else if (value) {
        if (name != 'STATUS' && name != 'CUSTOM_STATUS' && name != 'PRIORITY' && name != 'CS_TYPES' && name != 'TASKLABEL' && name != 'MEMBERS' && name != 'COMMENTS' && name != 'ASSIGNTO' && name != 'DATE' && name != 'DUE_DATE') {
            createCookie(name, value, 30, DOMAIN_COOKIE);
            if (typeof session != 'undefined') {
                session[name] = value;
            }
        }
        localStorage.setItem(name, value);
    } else {
        createCookie(name, value, -1, DOMAIN_COOKIE);
        localStorage.removeItem(name);
    }
}

function deleteAssignedProject(id, userId, name, isInvite) {
    if (id) {
        var conf = confirm(_("Are you sure you want to delete assigned project") + " '" + decodeURIComponent(name.replace(/\+/g, ' ')) + "' ?");
        if (conf == true) {
            var strURL = $('#pageurl').val();
            strURL = strURL + "users/";
            $.post(strURL + "ajax_assignedproject_delete", {
                'id': id,
                'userId': userId,
                'isInvite': isInvite
            }, function(data) {
                if (data) {
                    if (data.message == 'success') {
                        $("#extlisting_" + id).fadeOut('slow');
                        $('#proj_name').keyup();
                        $.material.init();
                    } else {
                        return false;
                    }
                }
            }, 'json');
        } else {
            return false;
        }
    }
}

function removeProjectName(pid, id, chkAll, chkOne, row, active_class) {
    if ($("#prjloader").is(':visible')) {
        return false;
    } else {
        removeArrayElement(hdprojectid, pid);
        if (id == 'selected') {
            $("[value='" + pid + "']").prop('checked', false);
            $("[value='" + pid + "']").parent().parent().show('slow');
            if ($("#prjList li").length == 1) {
                hdprojectid = new Array();
                hdproject_name = '';
                $('#confirmprjcls').addClass('loginactive');
            }
        } else {
            $("#" + id).prop("checked", false);
            var lst_id_no = id.substr(9);
            $('#listing' + lst_id_no).show('slow');
            if ($(".chkbx_cur:checked").length == 0) {
                hdprojectid = new Array();
                hdproject_name = '';
                $('#confirmprjcls').addClass('loginactive');
            }
        }
        var ser_val = $('#proj_name').val().trim();
        var rem_val = $("#" + pid).text();
        var pattn = new RegExp(ser_val, "gi");
        if (ser_val == '' || (ser_val != '' && rem_val.match(pattn))) {
            $(chkAll).prop('checked', false);
            $(chkAll).show();
            $('.no-proj_tr').hide();
        }
        $(chkOne).parents(row).removeClass(active_class);
        $("#" + pid).remove();
    }
}

function deleteUsersInProject(userId, projectId, name) {
    if (userId) {
        var conf = confirm(_("Are you sure you want to delete the user") + " '" + decodeURIComponent(name.replace(/\+/g, ' ')) + "' " + _("from this project?"));
        if (conf == true) {
            var strURL = $('#pageurl').val();
            var dcrs_cnt = 1;
            strURL = strURL + "projects/ajax_existuser_delete";
            $.post(strURL, {
                'userid': userId,
                'project_id': projectId
            }, function(data) {
                if (data) {
                    if (data == 'success') {
                        $("#extlisting" + userId).fadeOut('slow');
                        if (parseInt(dcrs_cnt)) {
                            var total_user = parseInt($("#tot_prjusers" + projectId).text()) - 1;
                            $("#tot_prjusers" + projectId).html(total_user);
                            if (parseInt(total_user) == 0) {
                                $("#remove" + projectId).hide();
                                $("#ajax_remove" + projectId).hide();
                                closePopup();
                            }
                        }
                        $('#name').keyup();
                    } else {
                        return false;
                    }
                }
            });
        } else {
            return false;
        }
    }
}

function removeUserName(uid, id) {
    if ($("#userloader").is(':visible')) {
        return false;
    } else {
        removeArrayElement(hduserid, uid);
        if (id == 'selected') {
            $("[value^='" + uid + "@@|@@']").prop('checked', false);
            $("[value^='" + uid + "@@|@@']").parent().parent().show('slow');
            if ($("#userList li").length == 1) {
                hduserid = new Array();
            }
        } else {
            $("#" + id).attr("checked", false);
            var lst_id = id.substr(9);
            $('#listing' + lst_id).show('slow');
            if ($(".chkbx_cur:checked").length == 0) {
                hduserid = new Array();
            }
        }
        var ser_val = $('#name').val().trim();
        var rem_val = $("#" + uid).text();
        var pattn = new RegExp(ser_val, "gi");
        if (ser_val == '' || (ser_val != '' && rem_val.match(pattn))) {
            $("#checkAll").attr("checked", false);
            $('#checkAll').show();
            $('.no-user_tr').hide();
        }
        $("#" + uid).remove();
        enableAddUsrBtns('.ad-usr-prj');
    }
}

function removeArrayElement(array, itemToRemove) {
    for (var i = 0; i < array.length; i++) {
        if (parseInt(array[i]) == parseInt(itemToRemove)) {
            array.splice(i, 1);
            break;
        }
    }
}

function removeTaskFromMilestone(obj) {
    if (obj) {
        var mstid = $(obj).attr("data-id");
        var projid = $(obj).attr("data-prj-id");
    }
    openPopup();
    $(".mlstn_remove_task").show();
    $('#inner_mlstn_removetask').html('');
    $('.add-mlstn-btn').hide();
    $('#tsksrch').hide();
    $("#rmv_case_loader").show();
    $("#addtsk").css({
        'cursor': 'default'
    });
    $("#addtskncont").css({
        'cursor': 'default'
    });
    $("#tsk_name").val('');
    $.post(HTTP_ROOT + "milestones/removeCasesFromMilestone", {
        'mstid': mstid,
        'projid': projid
    }, function(res) {
        if (res) {
            $("#rmv_case_loader").hide();
            $('#inner_mlstn_removetask').show();
            $('.add-mlstn-btn').show();
            $('#tskloader').hide();
            $('#tsksrch').show();
            $('#inner_mlstn_removetask').html(res);
            $("#header_prj_ttl_rt").html($("#cur_proj_name_rt").val());
            $("#header_mlstn_ttl_rt").html($("#addcsmlstn_titl_rt").val());
        }
    });
}

function removecaseFromMilestone(obj) {
    if (confirm(_('Are you sure you want to remove selected tasks from Task Group?'))) {
        $("#mlstnpopup").hide();
        var caseid = Array();
        var done = 0;
        $('#inner_mlstn_removetask input:checked').each(function() {
            if ($(this).attr('id') !== 'checkAll') {
                caseid.push($(this).attr('value'));
                done++;
            }
        });
        if (done) {
            var project_id = $('#project_id_rt').val();
            var milestone_id = $('#milestone_id_rt').val();
            $("#confirmbtntsk").hide();
            $('#tskloader').show();
            $.post(HTTP_ROOT + 'milestones/remove_case', {
                "caseid": caseid,
                "project_id": project_id,
                "milestone_id": milestone_id
            }, function(data) {
                if (data == "success") {
                    var total_tasks = parseInt(caseid.length) + parseInt($("#tot_tasks_rt" + milestone_id).text());
                    $("#tot_tasks" + milestone_id).html(total_tasks);
                    closePopup();
                    $('#tskloader').hide();
                    $("#confirmbtntsk").show();
                    showTopErrSucc('success', _('Task removed successfully.'));
                    if ($('#caseMenuFilters').val() == 'milestonelist') {
                        showMilestoneList();
                    } else if ($('#caseMenuFilters').val() == 'milestone') {
                        ManageMilestoneList();
                    } else if ($('#caseMenuFilters').val() == 'kanban') {
                        easycase.showKanbanTaskList();
                    }
                }
            });
        } else {
            showTopErrSucc('error', _('Choose task to remove from task group.'));
        }
    }
}

function milstoneonTask(mlstname, mlstid) {
    $.post(HTTP_ROOT + 'milestones/milestone_list', {
        'project_id': $('#curr_active_project').val()
    }, function(res) {
        if (res) {
            $('.taskgp-drop').find('ul li').remove();
            $('.crtskgrp option').remove();
            $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
            $.each(res, function(key, value) {
                $('.crtskgrp').append('<option value="' + key + '">' + ucfirst(formatText(value)) + '</option>');
            });
            if (typeof mlstname == 'undefined') {
                $('.crtskgrp').find('option[value="0"]').attr("selected", "selected");
                $('.taskgp-drop').find('.dropdownjs').find('input.fakeinput').val('Default Task Group');
                $('.taskgp-drop').find('select').val(0);
                $('#CS_milestone').val('');
            } else if (mlstname == '') {
                $('.taskgp-drop').find('.dropdownjs').find('input.fakeinput').val('Default Task Group');
                $('.taskgp-drop').find('select').val(0);
                $('#CS_milestone').val('');
            } else {
                $('.taskgp-drop select').val(mlstid);
                $('#selected_milestone').html();
                $('#CS_milestone').val(mlstid);
                $('.taskgp-drop').find('.dropdownjs').find('input.fakeinput').val(trim(mlstname));
            }
            addTaskEvents();
        } else {
            $('.taskgp-drop').find('ul li').remove();
            $('.crtskgrp option').remove();
            $('.crtskgrp').append('<option value="0">' + _('Default Task Group') + '</option>');
            $('.crtskgrp').find('option[value="0"]').attr("selected", "selected");
            $('#CS_milestone').val('');
        }
    }, 'json');
}

function calendarView(type) {
    if (type == "calendar") {
        var prjunid = $('#projFil').val();
        if (prjunid == 'all' && (USER_SUB_NOW == '10' || USER_SUB_NOW == '21')) {
            showTopErrSucc('error', _('Oops! You are in') + " '" + _('All') + "' " + _('project. Please choose a project.'));
            return false;
        }
    }
    var filterV = $('#caseMenuFilters').val();
    if ((type == 'hash' && urlHash == 'calendar') || (type == 'calendar' && urlHash == 'calendar') || (filterV == 'calendar' && type == 'calendar')) {
        $('#calendar_view').hide();
        easycase.routerHideShow('calendar');
        var type = 'calendar';
        var params = parseUrlHash(urlHash);
        $('#select_view div').tipsy({
            gravity: 'n',
            fade: true
        });
        var globalkanbantimeout = null;
        var morecontent = '';
        if (type == 'calendar') {
            $('#select_view div').removeClass('disable');
            $('#calendar_btn').addClass('disable');
            $('#actvt_btn').removeClass('disable');
            $('#kbview_btn').removeClass('disable');
            $('#cview_btn').removeClass('disable');
            $('#lview_btn').removeClass('disable');
            $('#timelog_btn').removeClass('disable');
            $('#lview_btn_timelog').removeClass('disable');
            $('#invoice_btn').removeClass('disable');
            $('#files_btn').removeClass('disable');
            $('.filter_det').hide();
            $("#caseMenuFilters").val('calendar');
            $(".menu-files").removeClass('active');
            $(".menu-milestone").removeClass('active');
            milestone_uid = '';
        }
        var strURL = HTTP_ROOT + "easycases/";
        var casePage = $('#casePage').val();
        $('#caseLoader').show();
        var projFil = $('#projFil').val();
        var projIsChange = $('#projIsChange').val();
        var customfilter = $('#customFIlterId').value;
        var caseStatus = $('#caseStatus').val();
        var priFil = $('#priFil').val();
        var caseTypes = $('#caseTypes').val();
        var caseLabel = $('#caseLabel').val();
        var caseMember = $('#caseMember').val();
        var caseComment = $('#caseComment').val();
        var caseAssignTo = $('#caseAssignTo').val();
        var caseSearch = $("#case_search").val();
        var case_date = $('#caseDateFil').val();
        var case_due_date = $('#casedueDateFil').val();
        var case_srch = $('#case_srch').val();
        var caseId = $('#caseId').val();
        var strURL = HTTP_ROOT + "easycases/";
        var tskURL = strURL + "calendarView";
        $.post(tskURL, {
            "projFil": projFil,
            "projIsChange": projIsChange,
            "casePage": casePage,
            'caseStatus': caseStatus,
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
            'milestoneUid': milestone_uid
        }, function(res) {
            $('#calendar_view').show();
            $('#calendar_view').html(res);
            $('.top_cmn_breadcrumb').html('<a href="javascript:void(0)"><i class="material-icons">&#xE916;</i> ' + _('Calendar') + '</a>');
            showHideTopNav(1);
            loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                "projUniq": projFil,
                "pageload": 0,
                "page": "dashboard"
            });
        });
        if (projFil == 'all') {
            remember_filters('ALL_PROJECT', 'all');
        } else {
            remember_filters('ALL_PROJECT', '');
        }
    }
}
resetMilestoneSearch = function() {
    $('#search_text').val('');
    $('#show_search').html('');
    $('#resetting').html('');
    $('#milestone_content').css('margin-top', '');
    $('#kanban_filtered_items').html('');
    var view_type = $('#view_type').val();
    if (view_type == 'grid') {
        if ($('#storeIsActivegrid').val() == 0) {
            ManageMilestoneList();
        } else {
            ManageMilestoneList();
        }
    } else {
        if ($('#storeIsActive').val() == 0) {
            showMilestoneList(3, 0);
        } else {
            showMilestoneList(3, 1);
        }
    }
}
searchMilestoneTasks = function(srch) {
    var params = parseUrlHash(urlHash);
    if (!srch) {
        return false;
    }
    $('#kanban_list').css('margin-top', '3px');
    $('.kanban_tsk_filter_sec').show();
    $('#kanban_tsk_filter_items').html("<span> " + srch + "</span>");
    $('#kanban_srch_filter').html('<span onClick="resetKanbanSearch();" id="kanban_srch_btn" title="Reset"><i class="material-icons">&#xE8BA;</i></span>');
    easycase.showKanbanTaskList(params[0], srch);
    $('#srch_load1').hide();
}
resetKanbanSearch = function() {
    $('#kanban_tsk_filter_items').html('');
    $('#kanban_srch_filter').html('');
    $('#kanban_list').css('margin-top', '');
    var params = parseUrlHash(urlHash);
    resetAllFilters();
    easycase.showKanbanTaskList(params[0]);
}

function quickEditMilestone(mid) {
    $('#edit-link_' + mid).hide();
    $('#edit-save_' + mid).show();
    $('#milstone_edit_' + mid).focus();
}

function saveMilesatoneTitle(mid) {
    var title = $('#milstone_edit_' + mid).val().trim();
    var orig_title = $.trim($('#milstone_edit_' + mid).attr('data-titl'));
    var task_cnt = ' <div class="a_act_link_tg_dv">(' + $.trim($('#milstone_edit_' + mid).attr('data-taskcnt')) + ')</div>';
    var project_id = $('#projFil').val();
    if (title != '') {
        if (title != orig_title) {
            $('#milstone_edit_' + mid).css('border-color', '#66AFE9');
            $.post(HTTP_ROOT + "milestone/saveMilestoneTitle", {
                'mid': mid,
                'title': title,
                'project_id': project_id
            }, function(data) {
                if (data.status != 'error') {
                    $('#milstone_edit_' + mid).attr('data-titl', title);
                    $('#main-title-holder_' + mid).attr('original-title', title);
                    $('#milstone_edit_' + mid).val(title);
                    if (getHash() == 'milestonelist') {
                        if (mid == '0') {
                            window.location.reload();
                        } else {
                            $('.kanban_prog_' + mid).text(title);
                            $('.kanban_prog_' + mid).attr('title', title);
                        }
                    }
                    if (title.length > 23) {
                        title = title.substr(0, 23) + '...';
                    }
                    $('#main-title-holder_' + mid).find('a.a_act_link_tg').text(title);
                    $('#main-title-holder_' + mid).find('div.a_act_link_tg_dv').html(task_cnt);
                    showTopErrSucc('success', data.msg);
                } else {
                    $('#milstone_edit_' + mid).val(orig_title);
                    if (orig_title.length > 23) {
                        orig_title = orig_title.substr(0, 23) + '...';
                    }
                    $('#main-title-holder_' + mid).find('a.a_act_link_tg').text(orig_title);
                    $('#main-title-holder_' + mid).find('div.a_act_link_tg_dv').html(task_cnt);
                    showTopErrSucc('error', data.msg);
                }
                $('#edit-link_' + mid).show();
                $('#edit-save_' + mid).hide();
            }, 'json');
        } else {
            $('#edit-link_' + mid).show();
            $('#edit-save_' + mid).hide();
        }
    } else {
        $('#milstone_edit_' + mid).attr('placeholder', _('Enter the title') + '..');
        $('#milstone_edit_' + mid).css('border', '1px solid red');
        $('#milstone_edit_' + mid).focus();
    }
}

function addNewTaskType(type) {
    openPopup();
    $('#newtask_btn').text(_('Add'));
    $('#task_type_title').text(_('New Task Type'));
    $(".new_tasktype").show();
    $(".loader_dv").hide();
    $('#inner_tasktype').show();
    $("#project_task_type").val('');
    $('#tterr_msg').html('');
    $("#another_type").prop('checked', false);
    $.material.init();
    $("#project_task_type").select2().on('change', function(evt) {
        if ($(this).find("option:selected").length > 1 && $(this).find("option:selected").first().val() == 0) {
            $(this).val(0).change();
        }
        if ($(this).closest('.verror').length) {
            $('#tterr_msg').html('');
            $(this).closest('.select_field_wrapper').removeClass('verror');
        }
    })
    $("#task_type_nm").val('').keyup();
    $("#task_type_shnm").val('').keyup();
    $("#task_type_shnm").on("keyup", function() {
        $(this).val($(this).val().toLowerCase());
    });
    if (type == 'creatask') {
        $('#customTaskTypeForm').append("<input type='hidden' id='hiddentasktype' value='" + type + "'>");
    }
    setTimeout(function() {
        $("#project_task_type").focus();
    }, '1000');
    $("#ttbtn .cancel-link").find('button').prop('disabled', false);
    $("#newtask_btn").prop('disabled', false);
}

function validateTaskType() {
    var quickEditOpen = (typeof arguments[0] != 'undefined' && arguments[0] == 'continue') ? 1 : 0;
    var msg = "";
    var nm = $.trim($("#task_type_nm").val());
    var shnm = $.trim($("#task_type_shnm").val());
    var prj = $.trim($("#project_task_type").val());
    var id = $.trim($("#new-typeid").val());
    if (prj === "") {
        msg = _("'Project' cannot be left blank!");
        $("#tterr_msg").show().html(msg);
        $("#project_task_type").focus();
        $("#project_task_type").closest('.select_field_wrapper').addClass('verror');
        return false;
    }
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#tterr_msg").show().html(msg);
        $("#task_type_nm").focus();
        $("#task_type_nm").closest('.field_wrapper').addClass('verror');
        return false;
    } else if (nm.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
        msg = _("'Name' must not contain Special characters!");
        $("#tterr_msg").show().html(msg);
        $("#task_type_nm").focus();
        $("#task_type_nm").closest('.field_wrapper').addClass('verror');
        return false;
    }
    if (shnm === "") {
        msg = _("'Short Name' cannot be left blank!");
        $("#tterr_msg").show().html(msg);
        $("#task_type_shnm").focus();
        $("#task_type_shnm").closest('.field_wrapper').addClass('verror');
        return false;
    } else {
        var x = shnm.substr(-1);
        if (!isNaN(x)) {
            msg = _("Should not end with a number or space!");
            $("#tterr_msg").show().html(msg);
            $("#task_type_shnm").focus();
            $("#task_type_shnm").closest('.field_wrapper').addClass('verror');
            return false;
        }
        $(".quick_tsksave_cancel").hide();
        $("#ttloader").show();
        $("#newtask_btn").addClass('loginactive');
        $("#ttbtn .cancel-link").find('button').prop('disabled', true);
        $("#newtask_btn").prop('disabled', true);
        $.post(HTTP_ROOT + "projects/validateTaskType", {
            'id': id,
            'name': nm,
            'short_name': shnm,
            'project_id': $("#project_task_type").val()
        }, function(data) {
            if (data.status == 'success') {
                $("#customTaskTypeForm").submit(function(e) {
                    e.preventDefault();
                });
                $.post(HTTP_ROOT + "projects/addNewTaskTypetoDropdown", {
                    'id': id,
                    'name': nm,
                    'short_name': shnm,
                    'project_id': $("#project_task_type").val()
                }, function(data) {
                    var type = $.parseJSON(data);
                    $('#ttbtn').show();
                    $('#ttloader').hide();
                    $("#newtask_btn").removeClass('loginactive');
                    $("#ttbtn .cancel-link").find('button').prop('disabled', false);
                    $("#newtask_btn").prop('disabled', false);
                    $('#last').before("<li><a href='javascript:jsVoid()' ><span class='value'>" + type.type_id + "</span>" + nm + "</a></li>");
                    $('#ctsk_type').html("<span class='value'>" + type.type_id + "</span>" + nm);
                    $('#CS_type_id').val(type.type_id);
                    renderTTlist(quickEditOpen, id);
                    if ($("#another_type").is(':checked')) {
                        $("#project_task_type, #task_type_nm,#task_type_shnm").val('');
                        $("#project_task_type").change();
                    } else {
                        closePopup();
                    }
                });
            } else {
                $(".quick_tsksave_cancel").show();
                $("#ttloader").hide();
                $("#newtask_btn").removeClass('loginactive');
                if (data.msg == 'name') {
                    $("#tterr_msg").show().html(_('Name already exists. Please enter another name.'));
                    $("#task_type_nm").closest('.field_wrapper').addClass('verror');
                } else if (data.msg == 'sort_name') {
                    $("#tterr_msg").show().html(_('Short Name already exists. Please enter another short name.'));
                    $("#task_type_shnm").closest('.field_wrapper').addClass('verror');
                } else {
                    $("#tterr_msg").show().html(_('Oops! Missing input parameters.'));
                    $("#task_type_nm").closest('.field_wrapper').addClass('verror');
                }
                return false;
            }
        }, 'json');
    }
}

function validateTaskTypeEdit() {
    var quickEditOpen = (typeof arguments[0] != 'undefined' && arguments[0] == 'continue') ? 1 : 0;
    var msg = "";
    var nm = $.trim($("#task_type_nm_edit").val());
    var shnm = $.trim($("#task_type_shnm_edit").val());
    var id = $.trim($("#new-typeid_edit").val());
    if (nm === "") {
        msg = _("'Name' cannot be left blank!");
        $("#tterr_msg_edit").show().html(msg);
        $("#task_type_nm_edit").focus();
        $("#task_type_nm_edit").closest('.field_wrapper').addClass('verror');
        return false;
    } else if (nm.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
        msg = _("'Name' must not contain Special characters!");
        $("#tterr_msg_edit").show().html(msg);
        $("#task_type_nm_edit").focus();
        $("#task_type_nm_edit").closest('.field_wrapper').addClass('verror');
        return false;
    }
    if (shnm === "") {
        msg = _("'Short Name' cannot be left blank!");
        $("#tterr_msg_edit").show().html(msg);
        $("#task_type_shnm_edit").focus();
        $("#task_type_shnm_edit").closest('.field_wrapper').addClass('verror');
        return false;
    } else {
        var x = shnm.substr(-1);
        if (!isNaN(x)) {
            msg = _("Should not end with a number or space!");
            $("#tterr_msg_edit").show().html(msg);
            $("#task_type_shnm_edit").focus();
            $("#task_type_shnm_edit").closest('.field_wrapper').addClass('verror');
            return false;
        }
        $("#ttloader_edit").show();
        $("#newtask_btn_edit").addClass('loginactive');
        $("#ttbtn_edit .cancel-link").find('button').prop('disabled', true);
        $("#newtask_btn_edit").prop('disabled', true);
        $.post(HTTP_ROOT + "projects/validateTaskType", {
            'id': id,
            'name': nm,
            'short_name': shnm
        }, function(data) {
            if (data.status == 'success') {
                $("#customTaskTypeForm").submit(function(e) {
                    e.preventDefault();
                });
                $.post(HTTP_ROOT + "projects/addNewTaskTypetoDropdown", {
                    'id': id,
                    'name': nm,
                    'short_name': shnm
                }, function(data) {
                    var type = $.parseJSON(data);
                    $('#ttbtn_edit').show();
                    $('#ttloader_edit').hide();
                    $('#last').before("<li><a href='javascript:jsVoid()' ><span class='value'>" + type.type_id + "</span>" + nm + "</a></li>");
                    $('#ctsk_type').html("<span class='value'>" + type.type_id + "</span>" + nm);
                    $('#CS_type_id').val(type.type_id);
                    $("#newtask_btn_edit").removeClass('loginactive');
                    $("#ttbtn_edit .cancel-link").find('button').prop('disabled', false);
                    $("#newtask_btn_edit").prop('disabled', false);
                    renderTTlist(quickEditOpen, id);
                    closePopup();
                });
            } else {
                $("#newtask_btn_edit").removeClass('loginactive');
                $("#ttloader_edit").hide();
                if (data.msg == 'name') {
                    $("#tterr_msg_edit").show().html(_('Name already exists. Please enter another name.'));
                    $("#task_type_nm_edit").closest('.field_wrapper').addClass('verror');
                } else if (data.msg == 'sort_name') {
                    $("#tterr_msg_edit").show().html(_('Short Name already exists. Please enter another short name.'));
                    $("#task_type_shnm_edit").closest('.field_wrapper').addClass('verror');
                } else {
                    $("#tterr_msg_edit").show().html(_('Oops! Missing input parameters.'));
                    $("#task_type_nm_edit").closest('.field_wrapper').addClass('verror');
                }
                return false;
            }
        }, 'json');
    }
}

function renderTTlist(quickEditOpen, type) {
    $.post(HTTP_ROOT + "projects/task_type", {
        quickEditOpen: quickEditOpen
    }, function(data) {
        if (data == 'not_authorized') {
            self.location = HTTP_ROOT + 'dashboard';
        } else {
            $("#tt_ajax_response").html(data);
            if (type != '') {
                showTopErrSucc('success', _('Task type updated successfully.'));
            } else {
                showTopErrSucc('success', _('Task type added successfully.'));
            }
        }
    });
}

function saveTaskType() {
    var isTaskIds = 0;
    if ($('#tt_save_btn').hasClass('loginactive')) {
        return false;
    }
    $(".all_tt").each(function() {
        if ($(this).is(":checked")) {
            isTaskIds = 1;
        }
    });
    if (parseInt(isTaskIds)) {
        $('.all_tt').attr('disabled', false);
        $("#tt_save_btn").hide();
        $("#loader_img_tt").show();
        $('#task_types').attr("action", HTTP_ROOT + "projects/saveTaskType");
        document.task_types.submit();
        return true;
    } else {
        showTopErrSucc('error', _('Check atleast one task type.'));
        return false;
    }
}

function deleteTaskType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("task type ?"))) {
        $("#del_tsk_" + id).hide();
        $("#lding_tsk_" + id).show();
        $.post(HTTP_ROOT + "projects/deleteTaskType", {
            "id": id
        }, function(res) {
            if (parseInt(res)) {
                $("#dv_tsk_" + id).fadeOut(300, function() {
                    $(this).remove();
                    renderTTlist(1, id);
                    showTopErrSucc('success', _("Task type") + " '" + nm + "' " + _("has deleted successfully."));
                });
            } else {
                $("#lding_tsk_" + id).hide();
                $("#del_tsk_" + id).show();
                showTopErrSucc('error', _('Error in deletion of task type.'));
            }
        });
    }
}

function editTaskType(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    var srt_name = $(obj).attr("data-sortname");
    openPopup();
    $(".edit_tasktype").show();
    $("#task_type_nm_edit").val(nm).keyup();
    $("#task_type_shnm_edit").val(srt_name).keyup();
    $("#new-typeid_edit").val(id);
    $("#task_type_shnm_edit").on("keyup", function() {
        $(this).val($(this).val().toLowerCase());
    });
    $("#task_type_nm_edit").focus();
    $('#tterr_msg_edit').html('');
    $.material.init();
    $('#task_type_nm_edit').val().trim() != '' && $('#task_type_shnm_edit').val().trim() != '' ? $("#newtask_btn_edit").removeClass('loginactive') : $("#newtask_btn_edit").addClass('loginactive');
    $("#ttbtn_edit .cancel-link").find('button').prop('disabled', false);
    $("#newtask_btn_edit").prop('disabled', false);
}

function skipOnboarding() {
    $("#skip_btn").hide();
    $("#skip_ldr").show();
    $.post(HTTP_ROOT + "projects/skipOnbording", {}, function(res) {
        if (parseInt(res)) {
            window.location = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
        }
    });
}

function toggleOUTasks(id) {
    if (id == 'upcomming_tasks') {
        $('#upcomming_tasks').show();
        $('#overdue_tasks').hide();
    } else {
        $('#upcomming_tasks').hide();
        $('#overdue_tasks').show();
    }
}

function chk_client() {
    $('#chked_all').prop('checked', false);
    if ($('#make_client').prop('checked')) {
        var asn_to = $('#CS_assign_to').val() != '' ? $('#CS_assign_to').val() : $('select.crtskasgnusr').val();
        var uarr = new Array();
        $('.chk_client').each(function() {
            var clnt_id = $(this).val();
            uarr.push(clnt_id);
            $(".crtskasgnusr option[value='" + clnt_id + "']").prop('disabled', true);
        });
        $(".crtskasgnusr").trigger('change');
        $(".crtskasgnusr").select2();
        if ($.inArray(asn_to, uarr) > -1) {
            $('#tsk_asgn_to').text('me');
            $('#CS_assign_to').val(SES_ID);
            $(".crtskasgnusr option[value='" + SES_ID + "']").prop('selected', true);
            $(".crtskasgnusr").trigger('change');
        }
        $('.chk_client').prop('disabled', true);
        $('.chk_client').prop('checked', false);
    } else {
        $('.chk_client').prop('disabled', false);
        $(".crtskasgnusr option:disabled").prop('disabled', false);
        $(".crtskasgnusr").trigger('change');
        $(".crtskasgnusr").select2();
    }
}

function chk_client_reply(CS_id) {
    $('#' + CS_id + 'chkAllRep').prop('checked', false);
    if ($('#make_client_dtl' + CS_id).prop('checked')) {
        var asn_to = $("#CS_assign_to" + CS_id).val();
        var uarr = new Array();
        $('.chk_client').each(function() {
            var clnt_id = $(this).val();
            uarr.push(clnt_id);
            $("#CS_assign_to" + CS_id + " option[value='" + clnt_id + "']").prop('disabled', true);
        });
        $("#CS_assign_to" + CS_id).trigger('change');
        $("#CS_assign_to" + CS_id).select2();
        if ($.inArray(asn_to, uarr) > -1) {
            $('#CS_assign_to').val(SES_ID);
            $("#CS_assign_to" + CS_id).val(SES_ID);
            $("#CS_assign_to" + CS_id).trigger('change');
        }
        $('.chk_client').prop('disabled', true);
        $('.chk_client').prop('checked', false);
    } else {
        $('.chk_client').prop('disabled', false);
        $("#CS_assign_to" + CS_id + " option:disabled").prop('disabled', false);
        $("#CS_assign_to" + CS_id).trigger('change');
        $("#CS_assign_to" + CS_id).select2();
    }
}

function openbuttons() {
    $('#sendOptions > li').toggle();
}

function chk_client_dtl(id) {
    $('.chk_client').attr('checked', false);
    if ($('#make_client_dtl').is(':checked')) {
        var clientids = $('#clntidsrep').val();
        clientids = clientids.split(',');
        for (var i = 0; i <= clientids.length; i++) {
            closeNotifyName(id, clientids[i]);
        }
        $('.chk_client').attr('disabled', true);
        $('.chk_client').attr('checked', false);
        $('.chk_client').css('cursor', 'not-allowed');
    } else {
        $('.chk_client').css('cursor', 'pointer');
        $('.chk_client').attr('disabled', false);
    }
}
var onc_chk = 0;

function AddQuickTask() {
    var mid = '';
    var t_mid = '';
    var chk_tg = '';
    var is_change = '';
    var qt_task_type = '';
    var qt_story_point = '';
    var qt_task_due = '';
    var qt_assign = '';
    var qt_estr = '';
    var is_sac = '';
    var is_sact = '';
    var view_type = '';
    var is_sts = '';
    var arg_on_chk = 0;
    if (typeof arguments[2] != 'undefined') {
        is_sts = arguments[2];
    }
    if (typeof arguments[1] != 'undefined' && arguments[1] == 'tg') {
        arg_on_chk = arguments[1];
    }
    if ($('#task_view_types_span').length) {
        view_type = $('#task_view_types_span').val();
    }
    if (typeof arguments[0] != 'undefined' && arguments[0] != 'sac' && arguments[0] != 'sact') {
        if (typeof arguments[1] != 'undefined' && arguments[1] == 'qtg') {
            mid = arguments[0];
            t_mid = arguments[0];
        } else if (typeof arguments[1] != 'undefined' && arguments[1] == 'tg') {
            mid = arguments[0];
            t_mid = arguments[0];
            qt_task_type = $('#qt_task_type_backlog' + mid).val();
            chk_tg = 1;
        } else {
            t_mid = arguments[0];
            if (t_mid != '') {
                tmid = $('.inline_qktask' + t_mid).closest('.kanban-child').attr('id');
                tmid = tmid.split('_');
                mid = tmid[1];
            }
        }
    } else if (typeof arguments[2] != 'undefined') {
        is_change = $('#projIsChange').val().trim();
    } else {
        if (typeof arguments[0] != 'undefined' && arguments[0] == 'sac') {
            is_sac = 1;
        }
        if (typeof arguments[0] != 'undefined' && arguments[0] == 'sact') {
            is_sact = 's_a_s_t';
        }
        is_change = $('#projIsChange').val().trim();
        $('#inline_task_error').html('&nbsp;');
        $('.new_qktask_mc').css('margin-top', '0px');
    }
    var proj_id = $('#CS_project_id').val().trim();
    if (is_change == 'all' && mid == '') {
        showTopErrSucc('error', _('Please select the project you want to add the task.'));
        return false;
    } else {
        if (mid != '') {
            if (typeof arguments[1] != 'undefined' && arguments[1] == 'qtg') {
                var titl = $('.inline_qktask' + t_mid).val();
                $('.inline_qktask' + t_mid).each(function() {
                    if ($(this).closest('.appended-tsk').length > 0) {
                        titl = $(this).val();
                    }
                });
            } else {
                var titl = $.trim($('.inline_qktask' + t_mid).val());
                if (titl == '') {
                    $('.inline_qktask' + t_mid).focus();
                }
            }
        } else if (typeof arguments[1] != 'undefined' && arguments[1] == 'kbn') {
            mid = arguments[0];
            t_mid = arguments[0];
            var titl = $.trim($('.inline_qktask' + t_mid).val());
            if (titl == '') {
                $('.inline_qktask' + t_mid).focus();
                return false;
            }
        } else if (typeof arguments[2] != 'undefined') {
            var titl = $.trim($('#inline_qktask_sts').val());
        } else {
            var titl = $.trim($('#inline_qktask').val());
        }
        onc_chk++;
        if (titl != '' && onc_chk == 1) {
            if (view_type == 'list') {
                qt_task_type = $('#qt_task_type').val();
                qt_story_point = $('#qt_story_point').val();
                qt_assign = $('#quick-assign').val();
                qt_estr = $('#qt_estimated_hours').val();
                qt_task_due = $("#qt_due_dat").val().trim();
                if (qt_task_due == "" || qt_task_due == 'Invalid date') {
                    qt_task_due = '';
                } else {
                    qt_task_due = moment(qt_task_due).format('YYYY-MM-DD');
                }
            }
            if (view_type == '') {
                qt_story_point = $('#qt_story_point' + t_mid).val();
                qt_estr = $('#qt_estimated_hours' + t_mid).val();
            }
            $(".quicktsk_tr button").attr('disabled', 'disabled');
            $(".quicktsk_tr button .material-icons").css('color', '#bdbdbd');
            $('#caseLoader').show();
            $.post(HTTP_ROOT + "easycases/quickTask", {
                'title': titl,
                'project_id': proj_id,
                'type': 'inline',
                'mid': mid,
                'view_type': view_type,
                'task_type': qt_task_type,
                'story_point': qt_story_point,
                'assign_to': qt_assign,
                'estimated': qt_estr,
                'due_date': qt_task_due
            }, function(res) {
                $('#caseLoader').hide();
                if (res.error) {
                    if (mid != '') {
                        showTopErrSucc('error', res.msg);
                    } else {
                        $('.new_qktask_mc').css('margin-top', '0px');
                        $('#inline_task_error').html(res.msg);
                    }
                    return false;
                } else {
                    onc_chk = 0;
                    if (res.isAssignedUserFree != 1) {
                        var estimated_hr = res.estimated_hours;
                        openResourceNotAvailablePopup(qt_assign, res.gantt_start_date, res.due_date, estimated_hr, res.projId, res.curCaseId, res.caseUniqId, res.isAssignedUserFree);
                    }
                    showTopErrSucc('success', _('Task posted successfully.'));
                    if (arg_on_chk) {
                        $('#convrt_task_' + mid).remove();
                    }
                    if (view_type == 'list') {
                        $('#qt_estimated_hours').val('');
                        $('#qt_due_dat').val('');
                        $(".quicktsk_tr button").attr('disabled', false);
                    }
                    if (view_type == '') {
                        $('#qt_estimated_hours' + t_mid).val('');
                        $('#qt_story_point' + t_mid).val(0);
                        $(".quicktsk_tr button").attr('disabled', false);
                    }
                    var params = parseUrlHash(urlHash);
                    if ((mid != '' || (mid == '0' && typeof params[0] != 'undefined' && typeof params[0] != 'milestonelist')) && chk_tg == '') {
                        if (typeof params[0] != 'undefined' && typeof params[1] != 'undefined' && params[0] == 'kanban') {
                            easycase.showKanbanTaskList();
                        } else {
                            $('.inline_qktask' + t_mid).val('');
                            $('#inline_qktask_sts').val('');
                            showMilestoneList();
                        }
                    } else if (is_sts == 'sts') {
                        $('#inline_qktask_sts').focus();
                        $('#inline_qktask_sts').val('');
                        tasklisttmplAdd(res.curCaseId, mid, 'sts');
                    } else if (chk_tg != '') {
                        var params = parseUrlHash(urlHash);
                        if (typeof params[0] != 'undefined' && typeof params[1] != 'undefined' && params[0] == 'kanban') {
                            easycase.showKanbanTaskList();
                        } else {
                            $('.in_qt_taskgroup').focus();
                            $('.in_qt_taskgroup').val('');
                            $('.in_qt_taskgroup').blur();
                            tasklisttmplAdd(res.curCaseId, mid);
                            $('#empty_milestone_tr' + mid).closest('tbody').find('.textRed').closest('tr').hide();
                        }
                    } else {
                        $('#inline_qktask').focus();
                        $('#inline_qktask').val('');
                        if (is_sac == 1 || is_sact == 's_a_s_t') {
                            blurqktask_qt();
                        }
                        tasklisttmplAdd(res.curCaseId, 'qtl', is_sact);
                    }
                    $('.empty_task_tr').hide();
                    if (view_type == 'list') {
                        sendNotiFyEmailQt(res);
                    }
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
        } else {
            onc_chk = 0;
            if (view_type == 'list') {
                $('#inline_qktask').focus();
                showTopErrSucc('error', _('Please Enter Task Title.'));
                return false;
            }
        }
    }
}

function AddnewQuickTask() {
    var mid = '';
    var t_mid = '';
    var chk_tg = '';
    var is_change = '';
    var qt_task_type = '';
    var qt_story_point = '';
    var qt_task_due = '';
    var qt_assign = '';
    var qt_estr = '';
    var is_sac = '';
    var is_sact = '';
    var view_type = '';
    var is_sts = '';
    var arg_on_chk = 0;
    if (typeof arguments[2] != 'undefined') {
        is_sts = arguments[2];
    }
    if (typeof arguments[1] != 'undefined' && arguments[1] == 'tg') {
        arg_on_chk = arguments[1];
    }
    if ($('#task_view_types_span').length) {
        view_type = $('#task_view_types_span').val();
    }
    if (typeof arguments[0] != 'undefined' && arguments[0] != 'sac' && arguments[0] != 'sact') {
        if (typeof arguments[1] != 'undefined' && arguments[1] == 'qtg') {
            mid = arguments[0];
            t_mid = arguments[0];
        } else if (typeof arguments[1] != 'undefined' && arguments[1] == 'tg') {
            mid = arguments[0];
            t_mid = arguments[0];
            qt_task_type = $('#qt_task_type_backlog' + mid).val();
            chk_tg = 1;
        } else {
            t_mid = arguments[0];
            if (t_mid != '') {
                tmid = $('.inline_qktask' + t_mid).closest('.kanban-child').attr('id');
                tmid = tmid.split('_');
                mid = tmid[1];
            }
        }
    } else if (typeof arguments[2] != 'undefined') {
        is_change = $('#projIsChange').val().trim();
    } else {
        if (typeof arguments[0] != 'undefined' && arguments[0] == 'sac') {
            is_sac = 1;
        }
        if (typeof arguments[0] != 'undefined' && arguments[0] == 'sact') {
            is_sact = 's_a_s_t';
        }
        is_change = $('#projIsChange').val().trim();
        $('#inline_task_error').html('&nbsp;');
        $('.new_qktask_mc').css('margin-top', '0px');
    }
    var proj_id = $('#CS_project_id').val().trim();
    if (is_change == 'all' && mid == '') {
        showTopErrSucc('error', _('Please select the project you want to add the task.'));
        return false;
    } else {
        if (mid != '') {
            if (typeof arguments[1] != 'undefined' && arguments[1] == 'qtg') {
                var titl = $('.inline_qktask' + t_mid).val();
                $('.inline_qktask' + t_mid).each(function() {
                    if ($(this).closest('.appended-tsk').length > 0) {
                        titl = $(this).val();
                    }
                });
            } else {
                var titl = $.trim($('.inline_qktask' + t_mid).val());
                if (titl == '') {
                    $('.inline_qktask' + t_mid).focus();
                }
            }
        } else if (typeof arguments[1] != 'undefined' && arguments[1] == 'kbn') {
            mid = arguments[0];
            t_mid = arguments[0];
            var titl = $.trim($('.inline_qktask' + t_mid).val());
            if (titl == '') {
                $('.inline_qktask' + t_mid).focus();
                return false;
            }
        } else if (typeof arguments[2] != 'undefined') {
            var titl = $.trim($('#inline_qktask_sts').val());
        } else {
            var titl = $.trim($('#inline_qktask_0').val());
        }
        onc_chk++;
        if (titl != '' && onc_chk == 1) {
            if (view_type == 'list') {
                qt_task_type = $('#qt_task_type_' + mid).val();
                qt_story_point = $('#qt_story_point_' + mid).val();
                qt_assign = $('#quick-assign_' + mid).val();
                qt_estr = $('#qt_estimated_hours_' + mid).val();
                qt_task_due = $("#qt_due_dat_" + mid).val().trim();
                if (qt_task_due == "" || qt_task_due == 'Invalid date') {
                    qt_task_due = '';
                } else {
                    qt_task_due = moment(qt_task_due).format('YYYY-MM-DD');
                }
            }
            $(".quicktsk_tr button").attr('disabled', 'disabled');
            $(".quicktsk_tr button .material-icons").css('color', '#bdbdbd');
            $('#caseLoader').show();
            $.post(HTTP_ROOT + "easycases/quickTask", {
                'title': titl,
                'project_id': proj_id,
                'type': 'inline',
                'mid': mid,
                'view_type': view_type,
                'task_type': qt_task_type,
                'story_point': qt_story_point,
                'assign_to': qt_assign,
                'estimated': qt_estr,
                'due_date': qt_task_due
            }, function(res) {
                $('#caseLoader').hide();
                if (res.error) {
                    if (mid != '') {
                        showTopErrSucc('error', res.msg);
                    } else {
                        $('.new_qktask_mc').css('margin-top', '0px');
                        $('#inline_task_error').html(res.msg);
                    }
                    return false;
                } else {
                    onc_chk = 0;
                    if (res.isAssignedUserFree != 1) {
                        var estimated_hr = res.estimated_hours;
                        openResourceNotAvailablePopup(qt_assign, res.gantt_start_date, res.due_date, estimated_hr, res.projId, res.curCaseId, res.caseUniqId, res.isAssignedUserFree);
                    }
                    showTopErrSucc('success', _('Task posted successfully.'));
                    if (arg_on_chk) {
                        $('#convrt_task_' + mid).remove();
                    }
                    if (view_type == 'list') {
                        $('#qt_estimated_hours').val('');
                        $('#qt_due_dat').val('');
                        $(".quicktsk_tr button").attr('disabled', false);
                    }
                    var params = parseUrlHash(urlHash);
                    if (getHash() == 'taskgroups') {
                        $('#inline_qktask_' + mid).focus();
                        $('#inline_qktask_' + mid).val('');
                        tasklisttmplAdd(res.curCaseId, '', is_sact);
                    } else if ((mid != '' || (mid == '0' && typeof params[0] != 'undefined' && typeof params[0] != 'milestonelist')) && chk_tg == '') {
                        if (typeof params[0] != 'undefined' && typeof params[1] != 'undefined' && params[0] == 'kanban') {
                            easycase.showKanbanTaskList();
                        } else {
                            $('.inline_qktask' + t_mid).val('');
                            $('#inline_qktask_sts').val('');
                            showMilestoneList();
                        }
                    } else if (is_sts == 'sts') {
                        $('#inline_qktask_sts').focus();
                        $('#inline_qktask_sts').val('');
                        tasklisttmplAdd(res.curCaseId, mid, 'sts');
                    } else if (chk_tg != '') {
                        var params = parseUrlHash(urlHash);
                        if (typeof params[0] != 'undefined' && typeof params[1] != 'undefined' && params[0] == 'kanban') {
                            easycase.showKanbanTaskList();
                        } else {
                            $('.in_qt_taskgroup').focus();
                            $('.in_qt_taskgroup').val('');
                            $('.in_qt_taskgroup').blur();
                            tasklisttmplAdd(res.curCaseId, mid);
                            $('#empty_milestone_tr' + mid).closest('tbody').find('.textRed').closest('tr').hide();
                        }
                    } else {
                        $('#inline_qktask').focus();
                        $('#inline_qktask').val('');
                        if (is_sac == 1 || is_sact == 's_a_s_t') {
                            blurqktask_qt();
                        }
                        tasklisttmplAdd(res.curCaseId, 'qtl', is_sact);
                    }
                    $('.empty_task_tr').hide();
                    if (view_type == 'list') {
                        sendNotiFyEmailQt(res);
                    }
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
        } else {
            onc_chk = 0;
            if (view_type == 'list') {
                $('#inline_qktask').focus();
                showTopErrSucc('error', _('Please Enter Task Title.'));
                return false;
            }
        }
    }
}

function sendNotiFyEmailQt(res) {
    var emailUserqt = Array();
    if (SES_ID != res.caUid) {
        emailUserqt.push(res.caUid);
    }
    var url_ajax = HTTP_ROOT + "easycases/ajaxemail";
    if (typeof res.projId != 'undefined') {
        $.post(url_ajax, {
            'projId': res.projId,
            'emailUser': emailUserqt,
            "allfiles": '',
            'caseNo': res.curCaseNo,
            'emailTitle': res.emailTitle,
            'emailMsg': res.emailMsg,
            'casePriority': res.casePriority,
            'caseTypeId': res.caseTypeId,
            'msg': res.msg,
            'emailbody': 'posted a new Task',
            'caseIstype': 1,
            'csType': res.csType,
            'caUid': res.caUid,
            'caseid': res.curCaseId,
            'caseUniqId': res.caseUniqId,
            'is_client': res.is_client
        });
    }
}

function AddNewMilestone() {
    var is_change = $('#projIsChange').val().trim();
    var proj_id = $('#CS_project_id').val().trim();
    $('#inline_mile_error').html('&nbsp;');
    $('.new_grp_mc').css('margin-top', '-10px');
    if (is_change == 'all') {
        showTopErrSucc('error', _('Please select the project you want to add the task group.'));
        return false;
    } else {
        var titl = (arguments[0] !== '' && typeof arguments[0] !== 'undefined') ? arguments[0] : $('#inline_milestone').val().trim();
        if (titl != '') {
            if (titl.toLowerCase() == 'default task group') {
                $('.new_grp_mc').css('margin-top', '0px');
                showTopErrSucc('error', _('Title') + ' "' + titl + '" ' + _('already exists!'));
                return false;
            }
            if (typeof arguments[0] !== 'undefined') {
                $('#caseLoader').show();
            }
            $('.qk_send_icon_mi').css('color', '#BDBDBD');
            $('.qk_send_icon_mi').closest('button').attr('disabled', true);
            var in_arg = (typeof arguments[0] != 'undefined') ? arguments[0] : '';
            $.post(HTTP_ROOT + "milestones/ajax_new_milestone", {
                'title': titl,
                'project_id': proj_id,
                'type': 'inline'
            }, function(res) {
                $('#caseLoader').hide();
                if (res.error) {
                    $('.new_grp_mc').css('margin-top', '0px');
                    showTopErrSucc('error', res.msg);
                    return false;
                } else {
                    $('#inline_milestone').val('');
                    $('#inline_milestone').blur();
                    if ($('#reset_btn').is(":visible") && $('#cls_task_grp').length && $('#cls_task_grp').attr('data-tgid').trim() == 'completed') {
                        $('#cls_task_grp').click();
                    } else if (in_arg != '') {
                        $('.taskgp-drop select').val(res.milestone_id);
                        $('#CS_milestone').val(res.milestone_id);
                        $('.taskgp-drop').find('.dropdownjs').find('input.fakeinput').val(res.milston_ttl).removeClass('focus');
                    } else {
                        if (getHash() == 'taskgroups') {
                            showTaskGroupsList();
                        } else {
                            tbody = '<tbody><tr class="tgrp_tr_all task_group_accd task_group_bg_clr" id="empty_milestone_tr' + res.milestone_id + '" data-pid="' + res.pid + '"><td colspan="11"><div class="plus-minus-accordian"><div class="fl"><span class="os_sprite plus-minus os_sprite' + res.milestone_id + '" onclick="collapse_taskgroup(this);"></span></div><div class="fl"><span class="dropdown n_tsk_grp" id="n_tsk_grp_' + res.milestone_id + '"><a class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown" href="javascript:void(0);" data-target="#" aria-expanded="false"><i class="material-icons">&#xE5D4;</i></a><ul class="dropdown-menu sett_dropdown-caret aede-drop-text"><li class="pop_arrow_new" style="left:126px"></li><li onClick="addTaskToMilestone(0,' + res.milestone_id + ',' + res.pid + ',0,1)"><a href="javascript:void(0);" class="mnsm"><div class="ct_icon icon-add-task-milston fl"></div><div class="fl mntxt"><i class="material-icons">&#xE85D;</i> ' + _('Assign Task') + '</div><div class="cb"></div></a></li><li onClick="convertToTask(this,' + res.milestone_id + ',' + res.pid + ',0,1)"><a href="javascript:void(0);" class="mnsm"><i class="material-icons">&#xE15A;</i>' + _('Convert to Task') + '</a></li><li class="makeHover" onclick="addEditMilestone(0,\'' + res.muid + '\',' + res.milestone_id + ',\'' + escape(res.milston_ttl) + '\',1,\'taskgroup\',' + res.pid + ')"><a href="javascript:void(0)" class="mnsm"><div class="ct_icon act_edit_task fl"></div><div class="fl"><i class="material-icons">&#xE254;</i> ' + _('Edit') + '</div><div class="cb"></div></a></li><li class="makeHover" onclick="delMilestone(0,\'' + escape(res.milston_ttl) + '\', \'' + res.muid + '\',' + res.milestone_id + ');"><a href="javascript:void(0);" class="mnsm"><div class="act_icon act_del_task fl"></div><div class="fl deltmntxt" style="padding:0px;"><i class="material-icons">&#xE872;</i> ' + _('Delete') + '</div><div class="cb"></div></a></li><li onclick="milestoneArchive(0,\'' + res.muid + '\',\'' + escape(res.milston_ttl) + '\',1);"><a href="javascript:jsVoid();" class="mnsm"><div class="ct_icon mt_completed fl"></div><div class="fl cmplmntxt"><i class="material-icons">&#xE86C;</i> ' + _('Complete') + '</div><div class="cb"></div></a></li></ul></span></div><div class="fl accord_cnt_txt"><div class="empty_milstone_holder top_ms"><div class="__a" onclick="collapse_by_title(' + res.milestone_id + ',' + res.pid + ');"><a id="miview_' + res.milestone_id + '" href="javascript:void(0);" title=""></a><div class="form-group label-floating pr edit_task_group" id="miviewtxtdv_' + res.milestone_id + '" style="display:none;"> <label class="control-label" for="focusedInput1">' + _('Edit Task Group') + '</label><input style="display:none;" class="form-control mviewtxt" type="text" id="miviewtxt_' + res.milestone_id + '" onkeyup="inlineEditMilestone(event,' + res.milestone_id + ',0);" onblur="inlineEditMilestone(event,' + res.milestone_id + ',1);" /><span class="input-group-btn"><button onclick="inlineEditMilestone(event,' + res.milestone_id + ',1);" type="button" class="btn btn-fab btn-fab-mini" title="Save"><i class="material-icons">send</i></button></span></div><p class="n_cnt_grpt_' + res.milestone_id + '">&nbsp;(<span id="miviewspan_' + res.milestone_id + '">0</span>)</p></div></div></div>\n\
    <div class="fl taskgroup-pencil showEditTaskgroup' + res.milestone_id + '"  onclick="showhideinlinedit(' + res.milestone_id + ');"><a href="javascript:void(0);" title="Edit"><i class="material-icons">&#xE254;</i></a></div>';
                            if (isAllowed('Create Task')) {
                                tbody += '<div class="fl tskg-add-btn"><a href="javascript:void(0);" class="btn btn-raised btn-xs btn_cmn_efect cmn_bg btn-info add_ntsk n_tsk_grpt_' + res.milestone_id + '" onclick="creatask(' + res.milestone_id + ')">' + _('Add Task') + '</a></div>';
                            }
                            tbody += '<div class="cb"></div></div><div class="tg_extra_td tg_extra_hrdate"><span>' + _('Est. Hr(s)') + ': <strong id="tg_spn_est_id' + res.milestone_id + '">' + _('--') + '</strong></span><span>' + _('Start Date') + ': <strong id="tg_spn_st_id' + res.milestone_id + '">' + _('--') + ' </strong></span><span>' + _('End Date') + ': <strong id="tg_spn_ed_id' + res.milestone_id + '">' + _('--') + '</strong></span></div><div class="cb"></div></td></tr>';
                            if (isAllowed('Create Task')) {
                                tbody += '<tr class="white_bg_tr"><td class="prtl"><div class="wht-bg"></div></td><td colspan="10" class="transp_bg"><div class="width40"><div class="form-group label-floating"><div id="inlin_qtsk_link' + res.milestone_id + '"><a href="javascript:void(0)" class="cmn-bxs-btn cmn_qk_task_clr" onclick="showhidegroupqt(' + res.milestone_id + ');"><i class="material-icons">&#xE145;</i>' + _('Quick Task') + '</a></div><div style="display:none;" class="input-group" id="inlin_qtsk_c' + res.milestone_id + '"><label class="control-label" for="addon3a">' + _('Quick Task') + '</label><input data-mid="' + res.milestone_id + '" id="addon' + res.milestone_id + '" class="in_qt_taskgroup form-control inline_qktask' + res.milestone_id + '" type="text" onblur="showhidegroupqt(' + res.milestone_id + ',1);"><span class="input-group-btn"><button data-mid="' + res.milestone_id + '" type="button" class="btn btn-fab btn-fab-mini in_qt_taskgroupbtn"><i class="material-icons qk_send_icon_tg' + res.milestone_id + '">send</i></button></span></div></div></div></td></tr>';
                            }
                            tbody += '<tr class="empty_task_tr"><td></td><td colspan="10" align="center" class="textRed">' + _('No Tasks found') + '</td></tr></tbody>';
                            if ($('.list-dt-row').length) {
                                $('.list-dt-row').closest('tbody').after(tbody);
                            } else {
                                $('.quicktskgrp_tr').closest('tbody').after(tbody);
                                $('tr.noRecord').remove();
                                $('tr.empty_task_tr_tsgrp').remove();
                            }
                        }
                        $('#miview_' + res.milestone_id).text(res.milston_ttl);
                        $('#miview_' + res.milestone_id).attr('title', res.milston_ttl);
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
                        initializeShorting();
                    }
                    $("#empty_milestone_tr" + res.milestone_id).fadeIn(2000);
                    var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
                    var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
                    var event_name = sessionStorage.getItem('SessionStorageEventValue');
                    if (eventRefer && event_name) {
                        trackEventLeadTracker(event_name, eventRefer, sessionEmail);
                    }
                }
            }, 'json');
        }
    }
}

function showhideinlinedit(mid) {
    var alprj = $('#projFil').val().trim();
    if (alprj != 'all') {
        $('#sch_arrw_edit_' + mid).show();
        $('#n_tsk_grp_' + mid).not('#n_tsk_grp_' + mid + '.n_tsk_grp').hide();
        $('.n_tsk_grpt_' + mid).hide();
        $('.showEditTaskgroup' + mid).hide();
        $('.tskg-add-btn').hide();
        $('.n_cnt_grpt_' + mid).hide();
        var orig_title = $('#miview_' + mid).text().trim();
        $('#miviewtxt_' + mid).val(orig_title);
        $('#miviewtxtdv_' + mid).show();
        $('#miviewtxt_' + mid).show();
        $('#miviewtxt_' + mid).focus();
        $('#miview_' + mid).hide();
    }
}

function inlineEditMilestone(event, mid, blr) {
    var title = $('#miviewtxt_' + mid).val().trim();
    var orig_title = $('#miview_' + mid).text().trim();
    var prj_id = $('#projFil').val().trim();
    if (title != '' && orig_title != title) {
        if (blr == 1 || event.keyCode == 13) {
            if (title.toLowerCase() == 'default task group') {
                showTopErrSucc('error', _('Title') + ' "' + title + '" ' + _('already exists!'));
                return false;
            }
            $.post(HTTP_ROOT + "milestones/inline_edit_milestone", {
                'title': title,
                'mid': mid,
                'project_id': prj_id
            }, function(res) {
                $('#sch_arrw_edit_' + mid).hide();
                $('#n_tsk_grp_' + mid).addClass('n_tsk_grp');
                $('#n_tsk_grp_' + mid).show();
                if (res.status == 'error') {
                    showTopErrSucc('error', res.msg);
                    $('#miview_' + mid).val(orig_title);
                    $('#miviewtxt_' + mid).val(orig_title);
                    $('#miviewtxt_' + mid).hide();
                    $('#miviewtxtdv_' + mid).hide();
                    $('#miview_' + mid).show();
                    $('.n_tsk_grpt_' + mid).show();
                    $('.showEditTaskgroup' + mid).show();
                    $('.n_cnt_grpt_' + mid).show();
                    $('.tskg-add-btn').show();
                    return false;
                } else {
                    $('.n_tsk_grpt_' + mid).show();
                    $('.showEditTaskgroup' + mid).show();
                    $('.n_cnt_grpt_' + mid).show();
                    $('.tskg-add-btn').show();
                    $('#miviewtxt_' + mid).hide();
                    $('#miview_' + mid).show();
                    $('#miview_' + mid).text(title);
                    $('#miviewtxt_' + mid).val(title);
                    $('#miviewtxtdv_' + mid).hide();
                    showTopErrSucc('success', res.msg);
                    if (mid == 'default') {
                        easycase.refreshTaskList();
                    }
                }
            }, 'json');
        }
    } else {
        if (blr == 1) {
            $('#miviewtxt_' + mid).hide();
            $('#miview_' + mid).show();
            $('#miview_' + mid).val(orig_title);
            $('#miviewtxt_' + mid).val(orig_title);
            $('#sch_arrw_edit_' + mid).hide();
            $('#n_tsk_grp_' + mid).addClass('n_tsk_grp');
            $('#n_tsk_grp_' + mid).show();
            $('.n_cnt_grpt_' + mid).show();
            $('#miviewtxtdv_' + mid).hide();
            $('.n_tsk_grpt_' + mid).show();
            $('.showEditTaskgroup' + mid).show();
            $('.tskg-add-btn').show();
        }
    }
}

function showDescription(num) {
    $('#cnt_' + num).slideDown("slow");
    $('#a_' + num).hide();
}

function collapsDescription(num) {
    $('#a_' + num).show();
    $('#cnt_' + num).slideUp("slow");
}

function hidereplytimelog() {
    createCookie("SHOWTIMELOG", 'No', 365, DOMAIN_COOKIE);
    $(".tl-msg-header").slideUp();
    $('.hidetablelog').slideUp("slow", function() {
        $('.showreplylog').show();
        $(".tl-msg-btn").find('.logmore-btn').hide();
        $(".tl-msg-box").addClass('slideup');
        $('.detail_timelog_header').show();
    });
}

function showreplytimelog() {
    createCookie("SHOWTIMELOG", 'Yes', 365, DOMAIN_COOKIE);
    $('.showreplylog').hide();
    $('.detail_timelog_header').hide();
    $(".tl-msg-header").slideDown();
    $('.hidetablelog').slideDown("slow", function() {
        $(".tl-msg-btn").find('.logmore-btn').show();
    });
}

function createlog(casesid) {
    $('#caseLoader').show();
    $(".slct_task >span").removeClass('not_empty');
    var logid = typeof arguments[2] != 'undefined' ? arguments[2] : '';
    var taskTitle = typeof arguments[1] != 'undefined' ? arguments[1] : '';
    var dataTaskId = typeof arguments[5] != 'undefined' ? arguments[5] : '';
    var dataPrjnm = typeof arguments[6] != 'undefined' ? unescape(arguments[6]) : '';
    var clkdDateExst = typeof arguments[3] != 'undefined' ? arguments[3] : '';
    var userID = typeof arguments[4] != 'undefined' ? arguments[4] : '';
    $.post(HTTP_ROOT + "easycases/check_dependant_action_allowed", {
        cid: casesid
    }, function(dependant_task_action_allowed) {
        $('#caseLoader').hide();
        if (dependant_task_action_allowed && dependant_task_action_allowed == 'No') {
            showTopErrSucc('error', 'Dependant tasks are not closed.');
            return false;
        } else {
            var prjunid = $('#projFil').val();
            var hashtag = parseUrlHash(urlHash);
            if (prjunid == 'all' && logid == '' && (casesid == 0 || hashtag[0] != 'details')) {} else if (casesid != 0) {
                if (hashtag[0] == 'details') {
                    var prjunid = $('#CS_project_id' + casesid).val();
                    $("#pname_dashboard_log").html("<a href='javascript:void(0);'>" + $('#CS_project_name' + casesid).val() + "</a>");
                }
            }
            if (logid != '' && prjunid == 'all') {
                var prjunid = $('#CS_project_id').val();
                if (hashtag[0] == 'details') {
                    $("#pname_dashboard_log").html("<a href='javascript:void(0);'>" + $('#CS_project_name' + casesid).val() + "</a>");
                }
            }
            var is_editable = 1;
            if (logid && userID) {
                if ((userID == SES_ID) || SES_TYPE == 1 || SES_TYPE == 2) {
                    is_editable = 1;
                } else {
                    is_editable = 0;
                }
            }
            if (is_editable == 0) {
                showTopErrSucc('error', _('You are not authorized to modify.'));
                return false;
            }
            $("#whosassign1").attr('disabled', false);
            $("#log_task_id").val('');
            if (logid != '') {
                $('.slct_task').removeAttr("onclick");
                $('.project-dropdown_log button').removeAttr("onclick");
            } else {
                $('.slct_task').attr("onclick", "showLogResults();");
                $('.project-dropdown_log button').attr("onclick", "view_project_menu_popup('timelogpopup','projpopup_log','ajaxViewProjects_log','loader_prmenu_log','popup');");
            }
            $(".logtime-content").find('.plus-btn').show();
            var dt = new Date();
            $('#endtime1').timepicker('setTime', dt);
            dt.setMinutes(dt.getMinutes() - 30);
            $('#strttime1').timepicker('setTime', dt);
            if (SES_TIME_FORMAT == 24) {
                $('#endtime1').timepicker({
                    'timeFormat': 'H:i'
                });
                $('#strttime1').timepicker({
                    'timeFormat': 'H:i'
                });
            }
            $('#tsmn1').val('00:30');
            $('#tskdesc').val('').keyup();
            $('input[name=log_id]').remove();
            $('#lgtimebtn').attr('disabled', false);
            $('#lgtimebtn').removeClass('loginactive');
            $(".slct_task >span").html(_("Select The Task To Log Time"));
            $(".slct_task >span").removeClass('not_empty');
            if (clkdDateExst) {
                $("#workeddt1").val(formatDate('MMM DD, YYYY', clkdDateExst));
                $("#workeddt1").datepicker({
                    format: 'MMM DD, YYYY',
                    todayHighlight: true,
                    changeMonth: false,
                    changeYear: false,
                    hideIfNoPrevNext: true,
                    autoclose: true
                });
                $("#workeddt1").datepicker("update", new Date(clkdDateExst));
                redirectToTimelogList = 0;
            } else {
                $("#workeddt1").datepicker({
                    format: 'MMM DD, YYYY',
                    todayHighlight: true,
                    changeMonth: false,
                    changeYear: false,
                    hideIfNoPrevNext: true,
                    autoclose: true
                });
                redirectToTimelogList = 1;
            }
            $("#tlog_date").val('');
            $("#tlog_resource").val('');
            $("#logstrtdt").val('');
            $("#logenddt").val('');
            $('#dropdown_menu_createddate').find('input').prop('checked', false);
            $('#dropdown_menu_resource').find('input').prop('checked', false);
            $('.totalbreak').val('');
            $('.crsid').hide();
            $('#is_billable1').attr('checked', false);
            openPopup('log');
            $(".logtimeTitle").find('.hideOnedit').show();
            $(".new_log").show();
            if (prjunid == 'all') {
                $('#prjsid').val($('#CS_project_id').val());
            } else {
                $('#prjsid').val(prjunid);
            }
            $.material.init();
            $(".select").dropdown({
                "optionClass": "withripple"
            });
            if (casesid != 0) {
                var cstitle = unescape(htmlspecialchars(arguments[1]));
            }
            if (logid != '') {
                $("#inner_log").find('.plus-btn').hide();
                $('#lgtimebtn').find('span').html('Update');
            } else {
                $("#inner_log").find('.plus-btn').show();
                $('#lgtimebtn').find('span').html('Log this time');
            }
            if (prjunid == 'all') {
                prjunid = $('#CS_project_id').val();
            }
            var t_pid_val = $('#projFil').val();
            if (t_pid_val == 'all') {
                if (logid != '') {
                    prjunid = $('[data-id^="log_prjuid_' + logid + '"]').attr('data-puid');
                }
            }
            if (hashtag[0] == 'timesheet' || hashtag[0] == 'timesheet_weekly') {
                prjunid = $('[data-id-tsht^="log_tsht_' + logid + '"]').attr('data-tisht-pid');
                prjunid = typeof prjunid == "undefined" ? $("#proj_uinq_detail_popup").val() : prjunid;
            }
            if (logid == '' || hashtag[0] == 'details') {
                currenttaskID = (casesid) ? casesid : dataTaskId;
                getTimelogActivity(prjunid, currenttaskID);
            } else {
                getTimelogActivity(prjunid);
            }
            var tid_var = casesid;
            if (dataTaskId != '' && logid != '' && casesid == '') {
                tid_var = dataTaskId;
            }
            tinymce.get('tskdesc').setContent('');
            $.post(HTTP_ROOT + "easycases/existing_task", {
                'projuniqid': prjunid,
                'list': 'list',
                'tid': tid_var
            }, function(data) {
                if (data) {
                    $("#log_task_results").html(data);
                    if (casesid != 0) {
                        if (hashtag[0] == 'details' || hashtag[0] == 'timesheet' || hashtag[0] == 'timesheet_weekly') {
                            cstitle = $('#CS_project_name' + casesid).val()
                        } else {
                            var cstitle = $('#pname_dashboard a').html();
                            if (typeof cstitle == 'undefined') {
                                cstitle = $('#pname_dashboard_hid').val();
                            }
                        }
                        $('#log_task_id').val(casesid);
                        if (taskTitle.trim() != '' || casesid != '') {
                            $('.slct_task > span').text($("#logTask_" + casesid).text());
                            $('.slct_task > span').addClass("not_empty");
                        }
                        if (cstitle.length > 60) {
                            $('#tskttl').val(cstitle);
                        } else {
                            $('#tskttl').val(cstitle);
                        }
                        cnt = "<a href='javascript:void(0);'>" + cstitle + "</a>";
                        $("#pname_dashboard_log").html(cnt);
                        $("#prjsid").val(prjunid);
                        $('#pname_dashboard_log').parent('button').attr('disabled', true);
                    } else {
                        $('#pname_dashboard_log').parent('button').attr('disabled', false);
                    }
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
                    $('#inner_log').show();
                    if (casesid == 0) {
                        if (hashtag[0] == 'details') {
                            csprj = $('input[id ^="CS_project_name"]:first').val();
                        } else {
                            var csprj = $('#pname_dashboard a').html();
                            if (typeof csprj == 'undefined') {
                                csprj = $('#pname_dashboard_hid').val();
                            }
                        }
                        $('#tskttl').val(csprj);
                        $('#lgtimebtn').attr('title', 'Select a task.');
                        $('#lgtimebtn').addClass('loginactive');
                        if (csprj == 'All') {
                            csprj = $('#ajaxViewProjects').find('a:nth-child(2)').text();
                            csprj = csprj.replace(/\(\d+\)/, '');
                        }
                        cnt = "<a href='javascript:void(0);'>" + csprj + "</a>";
                        if (dataPrjnm != '') {
                            cnt = "<a href='javascript:void(0);'>" + dataPrjnm + "</a>";
                        }
                        $("#pname_dashboard_log").html(cnt);
                        $("#prjsid").val(prjunid);
                    }
                    if (logid != '') {
                        $.ajax({
                            url: HTTP_ROOT + "easycases/timelog_details",
                            data: {
                                'projuniqid': prjunid,
                                logid: logid
                            },
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                cnt = "<a href='javascript:void(0);'>" + response.project_name + "</a>";
                                $("#pname_dashboard_log").html(cnt);
                                setEditTimeLog(response);
                                project_timelog_details(response.task_id, response.user_id);
                            }
                        });
                    } else {
                        project_timelog_details(casesid, '', prjunid);
                        if (tinymce.get('tskdesc')) {
                            tinymce.execCommand('mceFocus', true, 'tskdesc');
                        }
                    }
                }
            });
        }
    });
}

function modifyheader() {
    if ($('#log_task_id').val() != "" && $('#log_task_id').val() != "0") {
        if ($('#tskttl').val() == "") {
            var tskdata = $('#pname_dashboard_log a').html();
            if (typeof tskdata == 'undefined') {
                tskdata = $('#pname_dashboard_hid_log').val();
            }
            if (tskdata.length > 60) {
                $('#tskttl').val(tskdata);
            } else {
                $('#tskttl').val(tskdata);
            }
        }
        $('#lgtimebtn').removeClass('loginactive');
        $('#lgtimebtn').removeAttr('title');
        $('#lgtimebtn').attr('disabled', false);
    } else {
        var hashtag = parseUrlHash(urlHash);
        if (hashtag[0] != 'details') {
            var csprj = $('#pname_dashboard a').html();
            $('#tskttl').val(csprj);
        }
        $('#lgtimebtn').addClass('loginactive');
        $('#lgtimebtn').attr('disabled', 'disabled');
    }
}

function showtaskpopup() {
    openPopup('log');
    $('.abc').show();
    $(".new_log").show();
    $(".new_log").addClass("ovrlaynewlog");
    var prjunid = $('#projFil').val();
    $.post(HTTP_ROOT + "easycases/existing_task", {
        'projuniqid': prjunid
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#task_log').html(data);
            $('#task_log').show();
        }
    });
}

function savetsk() {
    $('#log_task_id').val($('#prjtsklist').val());
    if ($('#prjtsklist').val() == "") {
        showTopErrSucc('error', _('Please select a task'));
        return false;
    } else {
        var tskdata = $("#prjtsklist option:selected").text();
        $('#slttsk').html(tskdata);
        $('#tskttl').val(tskdata);
        $('#existtskid a').show();
        $('#slttsk').show();
        closetskPopup();
    }
}

function closetskPopup() {
    $('.ui-timepicker-wrapper').hide();
    removeMsg();
    closePopup();
    $("[id^='ul_timelog']").each(function(index) {
        if (index != 0) {
            $(this).remove();
        } else {
            var x = $(this).attr('id');
            var ids = x.substr(2, 4);
            $("#crsid" + ids).hide();
        }
    });
}

function showtimelog(type, filter) {
    if (PAGE_NAME == 'dashboard') {
        ajaxTimeLogView(type, filter);
    } else {
        $('#timelogloader').show();
        filter = typeof filter != 'undefined' && filter != '' ? filter : ($('#blk_timelog_date_filter').attr('data-filter') != '' ? $("#blk_timelog_date_filter").attr('data-filter') : '');
        var params = {
            'projuniqid': $('#projFil').val(),
            'usrid': $('#rsrclog').val(),
            'strddt': $('#logstrtdt').val(),
            'enddt': $('#logenddt').val(),
            'filter': filter
        };
        $.post(HTTP_ROOT + "easycases/timelog", params, function(data) {
            if (data) {
                $('#timelogtbl').html(data);
                $('#timelogloader').hide();
            }
        });
    }
}

function timelog_export_popup() {
    var isPDF = (typeof arguments[0] != 'undefined' && arguments[0] == 'pdf') ? 'pdf' : '';
    openPopup();
    $(".loader_dv").show();
    $(".timelog_list_export").show();
    $('.tlog_exp_chkbx').prop('checked', true);
    $('.tlog_exp_rdo').prop('checked', true);
    if ($('#projFil').val() == 'all') {
        $('#tlog_exp_prj').show();
    } else {
        $('#tlog_exp_prj').hide();
        $('#tlog_exp_prj').find('.tlog_exp_chkbx').prop('checked', false);
    }
    $('#tm-log-download-type').val(isPDF);
    if (isPDF == 'pdf') {
        $("#expt-tm-lg-headeing").html(_('Export Timelog to pdf file'));
    } else {
        $("#expt-tm-lg-headeing").html(_('Export Timelog to csv file'));
    }
}

function ajax_timelog_export_csv() {
    var checkedArr = [];
    var download_type = $('#tm-log-download-type').val();
    $('.tlog_exp_chkbx').each(function() {
        if ($(this).is(':checked')) {
            checkedArr.push($(this).val());
        }
    });
    if (!checkedArr.length) {
        showTopErrSucc('error', _('Please select atleast one field'));
        return false;
    }
    closePopup();
    $('#timelogloader').show();
    var userid = '';
    var date = '';
    $('.resource_check').each(function() {
        if ($(this).is(":checked")) {
            var uid = $(this).attr('data-id');
            userid += uid + ",";
        }
    });
    userid = $('#tlog_resource').val().replace(/-/gi, ',');
    $('#dropdown_menu_createdDate').find('input[type="checkbox"]').each(function() {
        if ($(this).attr('checked') == 'checked') {
            date = $(this).attr('data-id');
        }
    });
    var dt_format = "d/m/y";
    $('.tlog_exp_rdo').each(function() {
        if ($(this).is(':checked')) {
            dt_format = $(this).val();
        }
    });
    var url_params = 'projuniqid=' + $('#projFil').val() + '&usrid=' + userid + '&date=' + date + '&strddt=' + $('#logstrtdt').val() + '&enddt=' + $('#logenddt').val() + '&dt_format=' + dt_format + '&checkedFields=' + checkedArr;
    if (download_type == 'pdf') {
        var url = HTTP_ROOT + "log_times/download_pdf_timelog?" + url_params;
    } else {
        var url = HTTP_ROOT + "log_times/export_csv_timelog?" + url_params;
    }
    window.open(url, '_blank');
    return false;
    var params = {
        'projuniqid': $('#projFil').val(),
        'usrid': $userid,
        'date': date,
        'strddt': $('#logstrtdt').val(),
        'enddt': $('#logenddt').val()
    };
    $.post(HTTP_ROOT + "log_times/export_csv_timelog", params, function(data) {
        if (data) {
            $('#timelogloader').hide();
        }
    });
}

function open_more_opt_pgbar(cid, obj) {
    obj.stopPropagation();
    open_more_opt('more_opt19' + cid);
}

function setTimeOnCreate(start_time, end_time) {
    var srt_time = start_time.split(':');
    var end_time = end_time.split(':');
    $('#strttime1').timepicker('setTime', srt_time[0] + ':' + srt_time[1] + '' + srt_time[2]);
    $('#endtime1').timepicker('setTime', end_time[0] + ':' + end_time[1] + '' + end_time[2]);
    if (SES_TIME_FORMAT == 24) {
        $('#endtime1').timepicker({
            'timeFormat': 'H:i'
        });
        $('#strttime1').timepicker({
            'timeFormat': 'H:i'
        });
    }
}

function setEditTimeLog(response) {
    if (tinymce.get('tskdesc')) {
        tinymce.get('tskdesc').setContent(response.description);
    }
    $("#tskdesc").val(response.description).keyup();
    $("#whosassign1").val(response.user_id).attr('disabled', true);
    $('.resource-select').find('.dropdownjs').find('input.fakeinput').val($("#whosassign1").find('option[value="' + response.user_id + '"]').text());
    $("#log_task_id").val(response.task_id);
    $('.slct_task > span').text($("#logTask_" + response.task_id).text());
    $('.slct_task > span').addClass("not_empty");
    $('.slct_task').removeAttr("onclick");
    $('.project-dropdown_log button').removeAttr("onclick");
    var hashtag = parseUrlHash(urlHash);
    var prjunid = $('#projFil').val();
    if (prjunid == 'all' && hashtag[0] == 'details') {
        $("#pname_dashboard_log").html("<a href='javascript:void(0);'>" + $('#CS_project_name' + response.task_id).val() + "</a>");
    } else if (prjunid == 'all') {
        $("#pname_dashboard_log").html("<a href='javascript:void(0);'>" + response.project_name + "</a>");
    }
    $("#hidden_task_id").val(response.task_id);
    $("#hidden_timesheet_flag").val(response.timesheet_flag);
    $("#inner_log").find('.plus-btn').hide();
    $(".logtimeTitle").find('.hideOnedit').hide();
    $('#workeddt1').datepicker("setDate", new Date(response.start_datetime_v1));
    if (response.start_time != '--') {
        var srt_time = response.start_time.split(':');
        var smode = srt_time[0] >= 12 ? 'pm' : 'am';
        var shr = srt_time[0] > 12 ? parseInt(srt_time[0]) - 12 : srt_time[0];
        var smin = srt_time[1];
        var end_time = response.end_time.split(':');
        var emode = end_time[0] >= 12 ? 'pm' : 'am';
        var ehr = end_time[0] > 12 ? parseInt(end_time[0]) - 12 : end_time[0];
        var emin = end_time[1];
        $('#strttime1').timepicker('setTime', shr + ':' + smin + '' + smode);
        $('#endtime1').timepicker('setTime', ehr + ':' + emin + '' + emode);
        if (SES_TIME_FORMAT == 24) {
            $('#endtime1').timepicker({
                'timeFormat': 'H:i'
            });
            $('#strttime1').timepicker({
                'timeFormat': 'H:i'
            });
        }
        $('#strttime1').attr('placeholder', '---');
        $('#endtime1').attr('placeholder', '---');
        $('#tshr1').attr('placeholder', '---');
    } else {
        $('#strttime1').val('').attr('placeholder', '---');
        $('#endtime1').val('').attr('placeholder', '---');
        $('#tshr1').attr('placeholder', '---');
    }
    var break_time = response.break_time / 60;
    var bh = Math.floor(break_time / 60);
    var bm = Math.floor(break_time % 60);
    if (response.start_time == '--' && response.break_time == 0) {
        $('#tshr1').val('');
    } else {
        $('#tshr1').val((bh < 10 ? '0' : '') + bh + ':' + (bm < 10 ? '0' : '') + bm);
    }
    var total_hours = response.total_hours / 60;
    var th = Math.floor(total_hours / 60);
    var tm = Math.floor(total_hours % 60);
    $('#tsmn1').val((th < 10 ? 0 : '') + th + ':' + (tm < 10 ? 0 : '') + tm);
    $('#is_billable1').prop('checked', (response.is_billable == '1' ? true : false));
    $('#lgtimebtn').attr('disabled', false).removeClass('loginactive');
    if ($('input[name=log_id]').size() > 0) {
        $('input[name=log_id]').val(response.log_id);
    } else {
        var logid = $('<input>').attr({
            type: 'hidden',
            name: 'log_id',
            value: response.log_id
        });
        $('#lgtimebtn').after(logid);
    }
    if ($("#whosassign1").val() == null) {
        $('.resource-select').find('.dropdownjs').find('input').val($('#log_usrNm_' + response.log_id).text());
    }
}
var LogTime = {
    initiateLogTime: function(id) {
        var id = typeof id != 'undefined' ? id : '';
        $('#start_time' + id).timepicker({
            'minTime': '12:00am',
            'step': '30',
            'maxTime': '11:59pm'
        });
        $('#end_time' + id).timepicker({
            'minTime': '12:00am',
            'step': '30',
            'maxTime': '11:59pm'
        });
        var d = new Date();
        $('#end_time' + id).timepicker('setTime', null);
        $('#start_time' + id).timepicker('setTime', null);
        if (SES_TIME_FORMAT == 24) {
            $('#end_time' + id).timepicker({
                'timeFormat': 'H:i'
            });
            $('#start_time' + id).timepicker({
                'timeFormat': 'H:i'
            });
        }
        $(document).on('blur', '.tl_break_time', function() {
            LogTime.updatehrs($(this).closest('.timelog_block'), id);
        }).on('change', '.tl_start_time,.tl_end_time', function() {
            LogTime.updatehrs($(this).closest('.timelog_block'), id);
        });
    },
    updatehrs: function($obj) {
        var id = typeof id != 'undefined' ? id : '';
        var st_time = $obj.find('.tl_start_time').val();
        var en_time = $obj.find('.tl_end_time').val();
        if (st_time == '' || en_time == '') {
            $obj.find('.tl_hours').val('');
            $obj.find('.tl_break_time').val('');
            return false;
        }
        var st_timespl = '0';
        if (SES_TIME_FORMAT == 12) {
            var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
            st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm', '') : st_time.replace('am', '');
            var st_tmsp = st_time.split(":");
            if (st_mode == 'pm') {
                st_timespl = (st_tmsp[0] < 12) ? parseInt(st_tmsp[0]) + 12 : 12;
            } else {
                st_timespl = (st_tmsp[0] == 12) ? "00" : st_tmsp[0];
            }
        } else {
            var st_tmsp = st_time.split(":");
            st_timespl = st_tmsp[0];
        }
        st_timesplit = st_timespl + ":" + st_tmsp[1];
        st_time_minute = (parseInt(st_timespl) * 60) + parseInt(st_tmsp[1]);
        var en_timespl = '';
        if (SES_TIME_FORMAT == 12) {
            var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
            en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm', '') : en_time.replace('am', '');
            var en_tmsp = en_time.split(":");
            if (en_mode == 'pm') {
                en_timespl = (en_tmsp[0] < 12) ? parseInt(en_tmsp[0]) + 12 : 12;
            } else {
                en_timespl = (en_tmsp[0] == 12) ? "00" : en_tmsp[0];
            }
        } else {
            var en_tmsp = en_time.split(":");
            en_timespl = en_tmsp[0];
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
        $obj.find('.tl_hours').val(final_spend);
        LogTime.calculate_break($obj, id);
    },
    calculate_break: function($obj, id) {
        $obj.find('.tl_break_time').val($obj.find('.tl_break_time').val().replace('-', ''));
        var break_time = $.trim($obj.find('.tl_break_time').val()) != '' ? $.trim($obj.find('.tl_break_time').val().replace('-', '')) : '0';
        var spend_time = $.trim($obj.find('.tl_hours').val());
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
            $('#break_time' + id).focus();
            showTopErrSucc('error', _('Break time can not exceed the total spent hours.'));
            return false;
        } else if (total_sp_min == 0) {
            showTopErrSucc('error', _('Start time and End time can not same.'));
            return false;
        } else if (total_sp_min == total_br_min) {
            $('#break_time' + id).focus();
            showTopErrSucc('error', _('Break time can not same as the total spent hours.'));
            return false;
        }
        var final_br = parseInt(br_hr) > 0 || parseInt(br_min) > 0 ? parseInt(br_hr) + ':' + (br_min < 10 ? "0" : "") + br_min : '';
        $obj.find('.tl_hours').val(final_sp);
        $obj.find('.tl_break_time').val(final_br);
    },
    calulate_break_minute: function(id) {
        var id = typeof id != 'undefined' ? id : '';
        var break_time = $('#break_time' + id).val() != '' ? $('#break_time' + id).val() : '0:00';
        var br_hr = '00';
        var br_min = '00';
        var br_time = '';
        var extra_hr = '';
        if (break_time.indexOf('.') > '-1') {
            br_time = break_time * 60;
            br_hr = Math.floor(br_time / 60);
            br_min = Math.floor(br_time % 60);
        } else if (break_time.indexOf(':') > '-1') {
            br_time = break_time.split(':');
            extra_hr = Math.floor(parseInt(br_time[1]) / 60);
            br_hr = parseInt((br_time[0] == '') ? 0 : br_time[0]) + parseInt(extra_hr);
            br_min = Math.floor(br_time[1] % 60);
        } else {
            br_hr = break_time;
            br_min = '0';
        }
        var total_br_min = (parseInt(br_hr) * 60) + parseInt(br_min);
        return total_br_min;
    },
    calulate_spend_minute: function(id) {
        var id = typeof id != 'undefined' ? id : '';
        var st_time = $('#start_time' + id).val() != '' ? $('#start_time' + id).val() : '0:00';
        var en_time = $('#end_time' + id).val() != '' ? $('#end_time' + id).val() : '0:00';
        var st_timespl = '';
        var st_mode = (st_time.indexOf('pm') > -1) ? 'pm' : 'am';
        st_time = (st_time.indexOf('pm') > -1) ? st_time.replace('pm', '') : st_time.replace('am', '');
        var st_tmsp = st_time.split(":");
        if (st_mode == 'pm') {
            st_timespl = (st_tmsp[0] < 12) ? parseInt(st_tmsp[0]) + 12 : 12;
        } else {
            st_timespl = (st_tmsp[0] == 12) ? "00" : st_tmsp[0];
        }
        var st_time_minute = (parseInt(st_timespl) * 60) + parseInt(st_tmsp[1]);
        var en_timespl = '';
        var en_mode = (en_time.indexOf('pm') > -1) ? 'pm' : 'am';
        en_time = (en_time.indexOf('pm') > -1) ? en_time.replace('pm', '') : en_time.replace('am', '');
        var en_tmsp = en_time.split(":");
        if (en_mode == 'pm') {
            en_timespl = (en_tmsp[0] < 12) ? parseInt(en_tmsp[0]) + 12 : 12;
        } else {
            en_timespl = (en_tmsp[0] == 12) ? "00" : en_tmsp[0];
        }
        var en_time_minute = (parseInt(en_timespl) * 60) + parseInt(en_tmsp[1]);
        if (st_time_minute <= en_time_minute) {} else {
            en_time_minute = en_time_minute + 1440;
        }
        var spend_duration = en_time_minute - st_time_minute;
        return spend_duration;
    },
    convertToMin: function(s_time) {
        var r_time = 0;
        if (s_time.indexOf('.') > '-1') {
            r_time = s_time * 60;
        } else if (s_time.indexOf(':') > '-1') {
            var sp_time = s_time.split(':');
            r_time = parseInt(sp_time[0] * 60) + parseInt(sp_time[1] != '' ? sp_time[1] : 0);
        } else {
            r_time = s_time;
        }
        return r_time;
    }
};

function project_timelog_details(task_id) {
    var userid = (typeof arguments['1'] != 'undefined') ? arguments['1'] : '';
    if (typeof $('#prjsid').val() == 'undefined') {
        var prjunid = $('#CS_project_id').val();
    } else {
        var prjunid = $('#prjsid').val();
    }
    prjunid = (typeof arguments['2'] != 'undefined') ? arguments['2'] : prjunid;
    var params = {
        prjunid: prjunid,
        tskid: (typeof task_id != 'undefined' ? task_id : '')
    };
    $.ajax({
        url: HTTP_ROOT + "easycases/project_time_details",
        data: params,
        method: 'post',
        dataType: 'json',
        success: function(response) {
            $('#logtime_total').html(format_time_hr_min(response.total_spent));
            $('#logtime_billable').html(format_time_hr_min(response.billable_hours));
            $('#logtime_nonbillable').html(format_time_hr_min(response.nonbillable_hours));
            $('#logtime_estimated').html(format_time_hr_min(response.total_estimated));
            $('#whosassign1').empty();
            var lop_cnt = 0;
            TLUSER = response.project_users;
            $.each(response.project_users, function(key, value) {
                lop_cnt++;
                $('#whosassign1').append($("<option></option>").attr("value", value.User.id).text(value.User.name + " " + value.User.last_name));
                if (response.project_users.length == lop_cnt) {
                    if (!userid) {
                        $('#whosassign1').val(SES_ID);
                    } else {
                        $('#whosassign1').val(userid);
                    }
                    $('#whosassign1').trigger('change');
                }
            });
        }
    });
}

function formatDate(format, date) {
    var dt = moment(date).format(format);
    return dt;
}
var general = {
    update_footer_total: function(proj_id) {
        var projFil = typeof proj_id != 'undefined' ? proj_id : $('#projFil').val();
        $.post(HTTP_ROOT + "requests/ajax_project_size", {
            "projUniq": projFil,
            "pageload": 0
        }, function(data) {
            if (data) {
                $('#csTotalHours').html(data.used_text);
                if (data.last_activity) {
                    $('#projectaccess').html(data.last_activity);
                    $('#last_project_id').val(data.lastactivity_proj_id);
                    $('#last_project_uniqid').val(data.lastactivity_proj_uid);
                    var url = document.URL.trim();
                    if (isNaN(url.substr(url.lastIndexOf('/') + 1)) && (url.substr(url.lastIndexOf('/') + 1)).length != 32) {
                        $('#selproject').val($('#last_project_id').val());
                        $('#project_id').val($('#last_project_id').val());
                    }
                }
            }
        }, 'json');
    },
    filterDate: function(page, filter, title, type) {
        if (page == 'timelog') {
            $("#filter_date_lbl").html(title);
            if (filter != 'custom') {
                $('#logstrtdt,#logenddt').val('');
                $(".custome_timelog").hide();
                $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr('checked');
                if (type == "check") {
                    if (!$('#timelog_' + filter + '').is(":checked")) {
                        filter = 'alldates';
                    }
                    $('.tlog_date_check').removeAttr('checked');
                    $('#timelog_' + filter + '').attr('checked', 'checked');
                } else {
                    if ($('#timelog_' + filter + '').is(":checked")) {
                        $('#timelog_' + filter + '').removeAttr('checked');
                    } else {
                        $('#timelog_' + filter + '').attr('checked', 'checked');
                    }
                }
                remember_filters('timelog_date_filter', filter);
            } else if (filter == 'custom') {
                if ($.trim($('#logstrtdt').val()) != '' || $.trim($('#logstrtdt').val()) != '') {
                    $('.tlog_date_check').removeAttr('checked');
                    $('#tlog_date').val($('#logstrtdt').val() + ':' + $('#logenddt').val());
                    remember_filters('timelog_date_filter', $('#logstrtdt').val() + ':' + $('#logenddt').val());
                    ajaxTimeLogView();
                } else {
                    return false;
                }
            }
            $('#tlog_date').val(filter);
            showtimelog('datesrch', filter);
        }
    },
    filterResource: function(uid, type) {
        var checked = '';
        if (type == "check") {
            if ($('#res_' + uid).is(":checked")) {
                $('#res_' + uid).attr('checked', 'checked');
            } else {
                $('#res_' + uid).removeAttr('checked');
            }
        } else {
            if ($('#res_' + uid).is(":checked")) {
                $('#res_' + uid).removeAttr('checked');
            } else {
                $('#res_' + uid).attr('checked', 'checked');
            }
        }
        var filter = '';
        $('.resource_check').each(function() {
            if ($(this).is(":checked")) {
                var uid = $(this).attr('data-id');
                filter += uid + "-";
            }
        });
        remember_filters('timelog_resource_filter', filter);
        $('#tlog_resource').val(filter);
        showtimelog('resourcesrch', filter);
    }
};

function displayEdit(id, typ) {
    if (typ == 0) {
        $('#case_ttl_edit_spned_' + id).hide();
    } else {
        $('#case_ttl_edit_spned_' + id).show();
    }
}

function showEditTitle(id) {
    $('#case_ttl_edit_main_' + id).hide();
    $('#case_ttl_edit_dv' + id).show();
    var o_title = $('#temp_title_holder_' + id).val().trim();
    $('#case_ttl_edit_' + id).val(o_title).focus();
}

function saveEditTitle(id, e) {
    var goSave = 1;
    if (e != 0) {
        if (e.keyCode == 13) {
            goSave = 1;
        } else {
            goSave = 0;
        }
    }
    if (goSave == 1) {
        $('#btn_blue_save_' + id).hide();
        $('#btn_blue_cancel_' + id).hide();
        $('#title_edit_loader_' + id).show();
        var title = $('#case_ttl_edit_' + id).val().trim();
        var o_title = $('#temp_title_holder_' + id).val().trim();
        if (title != '' && title != o_title) {
            var o_csn = $('#case_ttl_edit_' + id).attr('data-caseno');
            $.post(HTTP_ROOT + "easycases/saveInlineTitle", {
                'uniq_id': id,
                'title': title
            }, function(res) {
                if (res.status == 'success') {
                    $('#temp_title_holder_' + id).val(formatText(ucfirst(title)));
                    $('#case_ttl_edit_spn_' + id).text('#' + o_csn + ': ' + formatText(ucfirst(title)));
                    appendReplyThread(res.curCaseId, res.caseid);
                    actiononTask(res.caseid, id, res.case_no, 'titleChange');
                } else {
                    showTopErrSucc('error', _('Failed to update task title. Please try once more!'));
                }
                $('#case_ttl_edit_main_' + id).show();
                $('#case_ttl_edit_dv' + id).hide();
                $('#btn_blue_save_' + id).show();
                $('#btn_blue_cancel_' + id).show();
                $('#title_edit_loader_' + id).hide();
            }, 'json');
        } else if (title != '' && title == o_title) {
            $('#case_ttl_edit_main_' + id).show();
            $('#case_ttl_edit_dv' + id).hide();
            $('#btn_blue_save_' + id).show();
            $('#btn_blue_cancel_' + id).show();
            $('#title_edit_loader_' + id).hide();
        } else if (title == '') {
            $('#btn_blue_save_' + id).show();
            $('#btn_blue_cancel_' + id).show();
            $('#title_edit_loader_' + id).hide();
        }
    } else {
        $('#btn_blue_save_' + id).show();
        $('#btn_blue_cancel_' + id).show();
        $('#title_edit_loader_' + id).hide();
    }
}

function cancelEditTitle(id) {
    $('#case_ttl_edit_main_' + id).show();
    $('#case_ttl_edit_dv' + id).hide();
}

function groupby(gbtype) {
    $('.show_all_opt_in_listonly').hide();
    var prjunid = $('#projFil').val();
    if (gbtype == "milestone" && typeof arguments[2] != 'undefined') {
        if (prjunid == 'all') {
            showTopErrSucc('error', _('You are viewing') + " " + _('All') + " " + _('project. Please choose a project first.'));
            return false;
        }
    } else if (prjunid == 'all') {
        if ($('.create-task-container').is(':visible')) {
            crt_popup_close();
            return false;
        }
        if ($('#lview_btn').length) {
            remember_filters('TASKGROUPBY', '');
            $(".side-nav li").removeClass('active');
            $(".menu-cases").addClass('active');
            if (!(localStorage.getItem("theme_setting") === null)) {
                var th_set_obj = JSON.parse(localStorage.getItem("theme_setting"));
                $(".side-nav li").each(function() {
                    $(this).removeClass(th_class_str);
                });
                $('.menu-cases').addClass(th_set_obj.sidebar_color + " gradient-shadow");
            }
            window.location.href = HTTP_ROOT + 'dashboard#tasks';
            return false;
        }
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
    if (arguments[1]) {
        var event = arguments[1];
        event.preventDefault();
        event.stopPropagation();
    }
    if (gbtype == 'date') {
        $('.sortby_btn').removeAttr('disabled');
        $('.sortby_btn').removeClass('disable-btn');
    } else {
        $('.sortby_btn').prop('disabled', true);
        $('.sortby_btn').addClass('disable-btn');
    }
    if (prjunid != 'all') {
        remember_filters('TASKGROUPBY', gbtype);
    } else {
        remember_filters('TASKGROUPBY', '');
        window.location.href = HTTP_ROOT + 'dashboard#tasks';
    }
    var hashtag = parseUrlHash(urlHash);
    if (gbtype == 'milestone') {
        casePage = 1;
        $('#tskgrpli').show();
        $('#lviewtype').val('compact');
        $('#caseMenuFilters').val('cases');
        remember_filters('LISTVIEW_TYPE', 'compact');
        $('#calendar_btn').removeClass('disable');
        $('#actvt_btn').removeClass('disable');
        $('#kbview_btn').removeClass('disable');
        $('#lview_btn').removeClass('disable');
        $('#timelog_btn').removeClass('disable');
        $('#lview_btn_timelog').removeClass('disable');
        $('#files_btn').removeClass('disable');
        $('#invoice_btn').removeClass('disable');
        if (PAGE_NAME == 'invoice' || PAGE_NAME == 'listall') {
            window.location.href = HTTP_ROOT + 'dashboard#tasks';
        }
        if (hashtag[0] != '' || gbtype == "milestone") {
            ajaxCaseView('tasks');
        }
    } else {
        easycase.refreshTaskList();
    }
}

function projectBodyClick(uid) {
    changeProjectFrommanage(uid);
    $('#projFil').val(uid);
    var chktask = '';
    if (typeof arguments[1] != 'undefined' && arguments[1] == 'tasks') {
        chktask = 'tasks';
    }
    if (chktask == '') {
        checkHashLoad('overview');
    }
    $.post(HTTP_ROOT + "projects/updtaeDateVisited", {
        'uniq_id': uid
    }, function(res) {
        if (res.status == 'success') {
            if (typeof res.redirect != 'undefined' && res.redirect == 'tasks') {
                chktask = 'tasks';
            }
            if (chktask == 'tasks') {
                if (res.proj_math == '2') {
                    window.location.href = HTTP_ROOT + "dashboard/#backlog";
                } else if (res.proj_math == '1') {
                    window.location.href = HTTP_ROOT + "dashboard/#tasks";
                } else {
                    window.location.href = HTTP_ROOT + "dashboard/#kanban";
                }
            } else {
                if (typeof res.tsk_cnt != 'undefined' && !parseInt(res.tsk_cnt)) {
                    if (res.proj_math == '2') {
                        window.location.href = HTTP_ROOT + "dashboard/#backlog";
                    } else if (res.proj_math == '1') {
                        window.location.href = HTTP_ROOT + "dashboard/#tasks";
                    } else {
                        window.location.href = HTTP_ROOT + "dashboard/#kanban";
                    }
                } else {
                    window.location.href = HTTP_ROOT + "dashboard/#tasks";
                }
            }
        } else {
            showTopErrSucc('error', _('Oops! You are not a member of the project. Please add yourself as a member of this project.'));
            return false;
        }
    }, 'json');
}

function changeProjectFrommanage(projid) {
    var prjid = $('#projFil').val();
    remember_filters('ALL_PROJECT', '');
    resetAllFilters('all', 1);
}

function customdatetlog() {
    $('.custome_timelog').toggle();
    $('#dropdown_menu_createddate').find('input[type="checkbox"]').prop('checked', false);
    $('.custome_timelog').closest('ul').scrollTop(200);
    $('.filter_toggle_data').scrollTop(400);
}

function get_timesheet(currentDate) {
    var filterV = $('#caseMenuFilters').val();
    var htype = type;
    $('#dropdown_menu_createddate').find('input[type="checkbox"]').removeAttr("checked");
    $('#dropdown_menu_resource').find('input[type="checkbox"]').removeAttr("checked");
    $('#tlog_date').val('');
    $('#tlog_resource').val('');
    $('#logstrtdt').val('');
    $('#logenddt').val('');
    $('#calendar').html('');
    $('#caseTimeLogViewSpan').html('');
    $('#TimeLog_paginate').hide();
    $('#TimeLog_calendar_view,#calendar_timelog,.calender_export,#calendar_view').hide();
    easycase.routerHideShow('timesheet');
    var pathToLook = "ajax_project_size"
    var type = 'chart_timelog';
    var params = parseUrlHash(urlHash);
    $('#select_view_timelog div').tipsy({
        gravity: 'n',
        fade: true
    });
    var globalkanbantimeout = null;
    var morecontent = '';
    if (type == 'chart_timelog') {
        $('#select_view_timelog div').removeClass('disable');
        $('#chart_btn_timelog').addClass('disable');
        $("#caseMenuFilters").val('calendar_timelog');
        $(".cmn_hover_menu_open").find('ul.dropdown-menu a').removeClass('disable');
        $('#lview_btn_timelog,#calendar_btn_timelog').removeClass('disable');
        $('.filter_det').hide();
        $(".menu-files").removeClass('active');
        $(".menu-milestone").removeClass('active');
        milestone_uid = '';
    }
    if (htype == 'calendar' || htype == 'hash') {
        $('.breadcrumb_div').css('height', '60px');
    }
    if (projFil == 'all') {
        remember_filters('ALL_PROJECT', 'all');
    } else {
        remember_filters('ALL_PROJECT', '');
    }
}

function setDefaultProjectView(type) {
    var value = '';
    switch (type) {
        case 'inactive':
            value = 'inactive';
            break;
        case 'active-grid':
            value = 'active-grid';
            break;
        case 'inactive-grid':
            value = 'inactive-grid';
            break;
        default:
            break;
    }
    var cookie_value = SES_ID + "_" + value;
    remember_filters('PROJECTVIEW_TYPE', cookie_value);
    resetProjectFilterItem();
    window.location = HTTP_ROOT + 'projects/manage/' + value;
}
function resetProjectFilterItem() {
    localStorage.removeItem('PROJECTMANAGETYPE');
    localStorage.removeItem('PROJECTMANAGETYPEVAL');
    localStorage.removeItem('PROJECTMANAGESTATUS');
    localStorage.removeItem('PROJECTMANAGESTATUSVAL');
};
function open_recent_activity() {
    if (!$('#new_recent_activities').is(':visible')) {
        $('.activity-txt').animate({
            'bottom': '480px',
            'right': '0px'
        }, function() {
            $('.activity-txt .open-activity').removeClass('up').addClass('down');
            $('#new_recent_activities').show();
            $('#new_recent_activities').jScrollPane({
                autoReinitialise: true
            });
        });
    } else {
        $('#new_recent_activities').hide();
        $('.all-activities').css({
            'background': 'none'
        });
        $('.activity-txt').animate({
            'bottom': '0px',
            'right': '0px'
        }, function() {
            $('.activity-txt .open-activity').removeClass('down').addClass('up');
        });
    }
}

function redirectToDefaultView() {
    var url = '';
    var route = '';
    $('.project-dropdown').show();
    $('.project-dropdown').prev('li').show();
    if (DEFAULT_VIEW_VALUE != 0) {
        url = DEFAULT_VIEW_TASK;
        route = DEFAULT_VIEW_TASK;
        remember_filters('TASKGROUPBY', '');
        if (DEFAULT_VIEW_TASK == 'taskgroup') {
            url = 'tasks';
            route = 'milestone';
            $('#lviewtype').val('compact');
            remember_filters('TASKGROUPBY', 'milestone');
        } else if (DEFAULT_VIEW_TASK == 'task_groups') {
            url = 'taskgroups';
            route = 'taskgroups';
            $('#lviewtype').val('compact');
            remember_filters('TASKGROUPBY', 'milestone');
        }
    } else {
        switch (DEFAULT_TASKVIEW) {
            case 'tasks':
                url = 'tasks';
                route = 'tasks';
                $('#lviewtype').val('comfort');
                remember_filters('TASKGROUPBY', '');
                break;
            case 'task_group':
                url = 'tasks';
                route = 'milestone';
                $('#lviewtype').val('compact');
                remember_filters('TASKGROUPBY', 'milestone');
                break;
            case 'taskgroups':
                url = 'taskgroups';
                route = 'taskgroups';
                $('#lviewtype').val('compact');
                remember_filters('SUBTASKVIEW', 'subtaskview');
                break;
            case 'milestonelist':
                url = 'milestonelist';
                route = 'milestonelist';
                break;
            case 'backlog':
                url = 'backlog';
                route = 'backlog';
                break;
            case 'kanban':
                url = 'kanban';
                route = 'kanban';
                break;
            default:
                url = 'tasks';
                route = 'tasks';
                break;
        }
    }
    if (CONTROLLER == 'easycases') {
        if (PAGE_NAME != 'invoice' && PAGE_NAME != 'mydashboard') {
            easycase.routerHideShow(route);
            if (route == 'milestone') {
                groupby('milestone');
            } else if (route == 'tasks') {
                easycase.routerHideShow(route);
                easycase.refreshTaskList();
                $('#select_view').find('.kan30').removeClass('disable');
                $("#lview_btn").addClass('disable');
            } else if (route == 'milestonelist') {
                if (DEFAULT_VIEW_VALUE != 0) {
                    var hashtag = DEFAULT_VIEW_TASK;
                } else {
                    var hashtag = DEFAULT_KANBANVIEW == 'milestonelist' ? 'milestonelist' : 'kanban';
                }
                easycase.routerHideShow(hashtag);
                window.location.hash = hashtag;
            } else {
                window.location = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
            }
        } else if (PAGE_NAME == 'mydashboard' || PAGE_NAME == 'invoice') {
            window.location = HTTP_ROOT + 'dashboard#tasks';
            $('#select_view').find('.kan30').removeClass('disable');
            if (route == 'tasks') {
                $("#lview_btn").addClass('disable');
            } else if (route == 'milestone') {
                $("#cview_btn").addClass('disable');
            } else {
                window.location = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
            }
        } else {
            if (route == 'tasks') {
                checkHashLoad(route);
            }
            window.location = HTTP_ROOT + 'dashboard#' + url;
        }
    } else {
        window.location = HTTP_ROOT + 'dashboard#' + DEFAULT_VIEW_TASK;
    }
}

function setOccurrenceEndDate(obj) {
    var occurrence = $(obj).val();
    $('#CSrepeat_occurrence').val(occurrence);
    var repeat_type = $('#CSrepeat_type').val();
    var due_date = $('#CS_due_date').val();
    if (due_date.indexOf(',') != -1) {
        var date = due_date.split(',');
        var year = new Date().getFullYear();
        due_date = new Date(date[0] + ' ' + year);
    }
    var daysToAdd = '';
    if (repeat_type == 'Weekly') {
        daysToAdd = 7 * occurrence;
    } else if (repeat_type == 'Monthly') {
        daysToAdd = 30 * occurrence;
    } else if (repeat_type == 'Quarterly') {
        daysToAdd = 90 * occurrence;
    } else if (repeat_type == 'Yearly') {
        daysToAdd = 365 * occurrence;
    }
    due_date = new Date(due_date);
    due_date.setDate(due_date.getDate() + daysToAdd);
    var dateFormated = due_date.toISOString().substr(0, 10);
    $('#CSrepeat_due_date').val(dateFormated);
}

function setNoOfOccurrence(obj) {
    var occurrenceEndDate = $(obj).val();
    var repeat_type = $('#CSrepeat_type').val();
    var due_date = $('#CS_due_date').val();
    if (due_date.indexOf(',') !== -1) {
        var date = due_date.split(',');
        var year = new Date().getFullYear();
        due_date = new Date(date[0] + ' ' + year);
    }
    var one_day = 1000 * 60 * 60 * 24;
    var occurrenceEndDate_ms = new Date(occurrenceEndDate).getTime();
    var due_date_ms = new Date(due_date).getTime();
    var difference_ms = occurrenceEndDate_ms - due_date_ms;
    var diff = Math.round(difference_ms / one_day);
    var occurrence = '';
    if (repeat_type == 'Weekly') {
        occurrence = Math.round(diff / 7);
    } else if (repeat_type == 'Monthly') {
        occurrence = Math.round(diff / 30);
    } else if (repeat_type == 'Quarterly') {
        occurrence = Math.round(diff / 90);
    } else if (repeat_type == 'Yearly') {
        occurrence = Math.round(diff / 365);
    }
    $('#CSrepeat_occurrence').val(occurrence);
}

function enableTextBox(type) {
    if (type == 'occur') {
        $('#occurrence').removeAttr('disabled');
        $('#end_datePicker').attr('disabled', 'disabled');
    } else if (type == 'date') {
        $('#end_datePicker').removeAttr('disabled');
        $('#end_datePicker').datepicker('remove');
        var repeatEnd = '+' + eval(365 * 7) + 'd';
        $("#end_datePicker").datepicker({
            format: 'M d, yyyy',
            todayHighlight: true,
            changeMonth: false,
            changeYear: false,
            startDate: '+1d',
            endDate: repeatEnd,
            hideIfNoPrevNext: true,
            autoclose: true
        }).on("changeDate", function() {
            var dateText = $("#end_datePicker").datepicker('getFormattedDate');
            $('#CSrepeat_due_date').val(moment(dateText).format('YYYY-MM-DD'));
        });
        $('#occurrence').attr('disabled', 'disabled');
    }
}

function updatetime(objid) {
    var regex = (SES_TIME_FORMAT == 12) ? /^([1-9]|1[0-2]):([0-5]\d)\s?(AM|PM)?$/i : /([01]?[0-9]|2[0-3]):[0-5][0-9]/;
    typeof id != 'undefined' ? id : '';
    if (typeof $('#' + objid).val() != 'undefined' && trim($('#' + objid).val()) != '') {
        if (!$('#' + objid).val().match(regex)) {
            showTopErrSucc('error', _('Invalid time format'));
            setTimeout(function() {
                $('#' + objid).focus();
            }, 10);
            $('#' + objid).val('');
            return false;
        }
    }
}

function chooseAllCompUsers() {
    var conf = 1;
    if ($.trim($('#members_list').val()) != '') {
        conf = confirm('This action will replace the data in the "Email ID" field. Would you like to proceed?');
    }
    if (conf) {
        if ($.trim(ACUSERS) == '') {
            showTopErrSucc('error', _('No more user available. Add new users by entering "Email Ids" to invite more users.'));
        }
        if ($('#allc_users').is(':checked')) {
            $('#members_list').val(ACUSERS).keyup();
        } else {
            $('#members_list').val('').keyup();
        }
    } else {
        $('#allc_users').prop('checked', false);
    }
}

function add_new_task_type(name) {
    if (name.trim() !== '') {
        if (name.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
            var msg = "'Name' must not contain Special characters!";
            if ($('.task-type-fld').find('ul li.dropdownjs-add').next('li').hasClass('dropdownjs-search')) {
                $('.task-type-fld').find('ul li.dropdownjs-search').next('li').remove();
            } else {
                $('.task-type-fld').find('ul li.dropdownjs-add').next('li').remove();
            }
            $('.tsktyp-select').find('option[value="' + name + '"]').remove();
            showTopErrSucc('error', msg);
            return false;
        } else {
            $.post(HTTP_ROOT + 'projects/validateTaskTypeFromCreateTask', {
                'name': name
            }, function(res) {
                if (res.status == 'error' && res.msg == 'name') {
                    showTopErrSucc('error', 'Name already esists!. Please enter another name.');
                    if ($('.task-type-fld').find('ul li.dropdownjs-add').next('li').hasClass('dropdownjs-search')) {
                        $('.task-type-fld').find('ul li.dropdownjs-search').next('li').remove();
                    } else {
                        $('.task-type-fld').find('ul li.dropdownjs-add').next('li').remove();
                    }
                    $('.tsktyp-select').find('option[value="' + name + '"]').remove();
                    return false;
                } else if (res.status == 'success') {
                    if (res.msg == 'saved') {
                        showTopErrSucc('success', 'Task Type Successfully Added');
                        if ($('.task-type-fld').find('ul li.dropdownjs-add').next('li').hasClass('dropdownjs-search')) {
                            $('.task-type-fld').find('ul li.dropdownjs-search').next('li').attr('value', res.id);
                        } else {
                            $('.task-type-fld').find('ul li.dropdownjs-add').next('li').attr('value', res.id);
                        }
                        $('.tsktyp-select').find('option[value="' + name + '"]').attr('value', res.id);
                    } else {
                        showTopErrSucc('error', _('Task Type can not be added'));
                        if ($('.task-type-fld').find('ul li.dropdownjs-add').next('li').hasClass('dropdownjs-search')) {
                            $('.task-type-fld').find('ul li.dropdownjs-search').next('li').remove();
                        } else {
                            $('.task-type-fld').find('ul li.dropdownjs-add').next('li').remove();
                        }
                        $('.tsktyp-select').find('option[value="' + name + '"]').remove();
                        return false;
                    }
                }
            }, 'json');
        }
    }
}

function select_all_user_add_to_project(obj) {
    $('.add_user_chk').prop('checked', obj.is(':checked'));
    (obj.is(':checked')) ? $('.btnassignUserToPrj').removeClass('loginactive'): $('.btnassignUserToPrj').addClass('loginactive')
}

function autoheight(a) {
    if ($(a).val() != '') {
        if (!$(a).prop('scrollTop')) {
            do {
                var b = $(a).prop('scrollHeight');
                var h = $(a).height();
                $(a).css("height", (h - 32) + 'px');
            } while (b && (b != $(a).prop('scrollHeight')));
        }
        $(a).css("height", $(a).prop('scrollHeight') + 'px');
    } else {
        $(a).css('height', 36);
    }
}

function showhidegroupqt(mid) {
    if (typeof arguments[1] != 'undefined') {
        var t_va = $('.inline_qktask' + mid).val().trim();
        if (t_va == '') {
            $('#inlin_qtsk_link' + mid).toggle();
            $('#inlin_qtsk_c' + mid).toggle();
        }
    } else {
        $('#inlin_qtsk_link' + mid).toggle();
        $('#inlin_qtsk_c' + mid).toggle();
        $('.inline_qktask' + mid).focus();
        $('.qk_send_icon_tg' + mid).css('color', '#BDBDBD');
        $('.qk_send_icon_tg' + mid).closest('button').attr('disabled', false);
    }
}

function changeTypeId(obj) {
    var typeId = $(obj).val();
    $('#CS_type_id').val(typeId);
    var tsk_titl = $("#CS_title").val();
    if ($(obj).find('option:selected').text() == 'Story') {
        if ($(".task-field-4").is(":visible")) {
            $('#tour_crt_story_point').show();
        } else {
            $('#tour_crt_story_point').hide();
        }
    } else {
        $('#tour_crt_story_point').hide();
    }
    if (typeId == 10) {
        $('#priority_low, #priority_mid').prop({
            'checked': false,
            'disabled': true
        });
        $('#priority_high').prop('checked', true);
        $("#CS_title").parent('div').addClass('mv-label-up');
    } else {
        $('#priority_low, #priority_mid, #priority_high').prop({
            'disabled': false
        });
        $("#CS_title").val(tsk_titl);
    }
}

function showHideTimelogBlock(obj) {
    var usrId = $(obj).val();
    $('#CS_assign_to').val(usrId);
    if (usrId == 0) {
        $('.timelog_block').hide();
    } else {
        if (SES_TYPE == 3 && usrId != SES_ID) {
            $('.timelog_block').hide();
        } else {
            $('.timelog_block').show();
        }
    }
}

function changeRepeatVal(obj) {
    var repeatType = $(obj).val();
    var repeatText = '';
    var repeatEnd = '+' + eval(365 * 7) + 'd';
    if (repeatType == 1) {
        repeatText = 'Weekly';
    } else if (repeatType == 2) {
        repeatText = 'Monthly';
        repeatEnd = '+' + eval(365 * 30) + 'd';
    } else if (repeatType == 3) {
        repeatText = 'Quarterly';
        repeatEnd = '+' + eval(365 * 30 * 3) + 'd';
    } else {
        repeatText = 'Yearly';
        repeatEnd = '+' + eval(365 * 365) + 'd';
    }
    $('#CSrepeat_type').val(repeatText);
    $('#end_datePicker').datepicker('remove');
    $("#end_datePicker").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        startDate: '+1d',
        endDate: repeatEnd,
        hideIfNoPrevNext: true,
        autoclose: true,
        clearBtn: true
    }).on("changeDate", function() {
        var dateText = $("#end_datePicker").datepicker('getFormattedDate');
        $('#CSrepeat_due_date').val(moment(dateText).format('YYYY-MM-DD'));
    });
}

function changeMilsestoneId(obj) {
    var mid = $(obj).val();
    $('#CS_milestone').val(mid);
}

function resetAllProjectFromDbd() {
    remember_filters('ALL_PROJECT', '');
}

function switchtaskwithProject(obj) {
    var hrf = $(obj).attr('data-href');
    var popup = typeof arguments[1] != 'undefined' ? arguments[1] : '';
    var cuid = $(obj).attr('data-pid');
    $.post(HTTP_ROOT + "easycases/switchmyproj", {
        'easycase_uid': $(obj).attr('data-pid')
    }, function(data) {
        $('#projFil').val(data);
        if (popup) {
            actvityTaskDetail(cuid);
        } else {
            window.location.href = hrf;
        }
    });
}
$(function() {
    $(document).on('click', '.add_user_chk', function() {
        var current_checked_users = '';
        var assigned_users = $('#all_asgnd_usrs').val();
        var assigned_usersArr = assigned_users.split(',');
        $('.add_user_chk').each(function() {
            if ($(this).is(':checked')) {
                if ($.inArray($(this).val(), assigned_usersArr) == -1) {
                    current_checked_users += $(this).val() + ',';
                }
            }
        });
        if ($('.add_user_chk').length == $('.add_user_chk:checked').length) {
            $('.add-all-user input[type="checkbox"]').prop('checked', true);
        } else {
            $('.add-all-user input[type="checkbox"]').prop('checked', false);
        }
        $('#current_checked_users').val(trim(current_checked_users, ','));
    });
    $(document).on('keyup', '#srch_usr_to_assgn', function() {
        var srch_txt = trim($(this).val());
        var prjUid = $('#proj_uniq_id').val();
        var prjNm = $('#add_user_pop_pname').text();
        if (trim(srch_txt) != '') {
            var current_checked_users = $('#current_checked_users').val();
            var current_checked_usersArr = current_checked_users.split(',');
            var assigned_users = $('#all_asgnd_usrs').val();
            var assigned_usersArr = assigned_users.split(',');
            var hidden_ids = new Array();
            $('.add_user_chk').each(function() {
                if (trim($(this).siblings('span.oya-blk').find('span').text().toLowerCase()).indexOf(srch_txt.toLowerCase()) < 0) {
                    hidden_ids.push($(this).val());
                    $.inArray($(this).val(), assigned_usersArr) != -1 ? $(this).prop('checked', true) : '';
                    if ($.inArray($(this).val(), assigned_usersArr) == -1 && !$(this).is(':checked')) {
                        $(this).closest('div.checkbox').hide();
                    }
                } else {
                    $(this).closest('div.checkbox').is(':visible') ? '' : $(this).closest('div.checkbox').show();
                }
            });
        } else {
            $('.add_user_chk').each(function() {
                $(this).closest('div.checkbox').show();
            });
        }
    });
});

function helpDesk() {
    var url = HTTP_ROOT + 'users/help_desk';
    var page = PAGE_NAME;
    if (page == 'dashboard') {
        var params = parseUrlHash(urlHash);
        page = params[0];
        if (params[0] == 'timelog' || params[0] == 'calendar_timelog') {
            page = 'log time';
        } else if (params[0] == 'tasks') {
            page = 'task';
        }
    } else if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
        page = 'project';
    } else if (CONTROLLER == 'users' && PAGE_NAME == 'manage') {
        page = 'user';
    } else if (CONTROLLER == 'projects' && PAGE_NAME == 'groupupdatealert') {
        page = 'Daily Catch-up';
    } else if (CONTROLLER == 'reports' && (PAGE_NAME == 'chart' || PAGE_NAME == 'hours_report' || PAGE_NAME == 'weeklyusage_report')) {
        page = 'analytics';
    }
    $.post(url, {
        page: page
    }, function(res) {
        $('#help_subjects').html(res);
        $.material.init();
    });
}

function searchHelpContent(obj) {
    var srch_txt = $(obj).val();
    if (trim(srch_txt) != '') {
        var url = HTTP_ROOT + 'users/help_desk_search';
        $.post(url, {
            'srch_txt': srch_txt
        }, function(res) {
            $('.search-div').html(res);
            $('.search-div').show();
        });
    } else {
        $('.search-div').hide();
    }
}
$(document).on('click', function() {
    $('.search-div').is(':visible') ? $('.search-div').hide() : '';
});

function htmlDecode(value) {
    return $("<div/>").html(value).text();
}
$(function() {
    $('#task_list_bar .pfl-icon-dv span.cmn_hover_menu_open').hover(function() {
        $(this).find('a.top_main_page_menu_togl').attr('aria-expanded', true);
        $(this).addClass('open');
        $(this).find('ul').show();
    }, function() {
        $(this).find('a.top_main_page_menu_togl').attr('aria-expanded', false);
        $(this).removeClass('open');
        $(this).find('ul').hide();
    });
});

function formathour() {
    var time_options = {
        translation: {
            'M': {
                pattern: /[0-5]/
            },
        }
    };
    $('.brk_hr_mskng').mask('00:M0', time_options);
}

function expandTimer() {
    if (!$('.timer-detail').is(':visible')) {
        $('.timer-header').animate({
            'bottom': '265px',
            'left': '176px',
            'height': '40px'
        }, function() {
            $('.timer-header .open-activity').removeClass('up').addClass('down');
            $('.timer-detail').show();
            localStorage.setItem('timeState', 'maximize');
        });
    } else {
        $('.timer-detail').hide();
        $('.timer-div').css({
            'background': 'none'
        });
        $('.timer-header').animate({
            'bottom': '0px',
            'left': '176px',
            'height': '55px'
        }, function() {
            $('.timer-header .open-activity').removeClass('down').addClass('up');
            localStorage.setItem('timeState', 'minimize');
        });
    }
}

function expandCollapseTimer() {
    if (localStorage.getItem('timeState') == 'maximize') {
        $('.timer-header').animate({
            'bottom': '265px',
            'left': '176px',
            'height': '40px'
        }, function() {
            $('.timer-header .open-activity').removeClass('up').addClass('down');
            $('.timer-detail').show();
        });
    } else {
        $('.timer-detail').hide();
        $('.timer-div').css({
            'background': 'none'
        });
        $('.timer-header').animate({
            'bottom': '0px',
            'left': '176px',
            'height': '55px'
        }, function() {
            $('.timer-header .open-activity').removeClass('down').addClass('up');
        });
    }
}
var prj_slct, $prj_slct;
var tsk_slct, $tsk_slct;

function openTimer() {
    if (timer_interval || typeof getCookie('timerPaused') != 'undefined') {
        showTopErrSucc('error', _('Timer is already running.'));
        return false;
    }
    $('#save-tm-span').hide();
    $('.timer-plus-btn,.timer-minus-btn').hide();
    $('#timerquickloading').hide();
    $('#start-tm-span').show();
    $('#cancel-timer-btn').show();
    var strURL = HTTP_ROOT + "users/project_menu";
    $('.timer-pause-btn, .timer-play-btn').hide();
    $('.timer-div').show();
    $('.timer-time').text('00 : 00 : 00');
    $('#timerdesc').parent('div').addClass('is-empty');
    $('#timerdesc').val('');
    $('#timer_is_billable').prop('checked', true);
    $.post(strURL, {
        "page": 'timer',
        "limit": 'all',
        "filter": ''
    }, function(data) {
        if (data) {
            typeof prj_slct != 'undefined' ? prj_slct.destroy() : '';
            $('#select-timer-proj').html(data);
            $('#select-timer-proj').val($('#projFil').val());
            $('#timer_hidden_proj_id').val($('#select-timer-proj').val());
            $('#timer_hidden_proj_nm').val($('#select-timer-proj option:selected').html());
            $prj_slct = $('#select-timer-proj').selectize({
                allowEmptyOption: true,
                onChange: function(value) {
                    if (!value.length)
                        return;
                    tsk_slct.clear();
                    $('#timer_hidden_proj_id').val(value);
                    $('#timer_hidden_proj_nm').val($('#select-timer-proj option:selected').html());
                    getTasksofProject(value);
                }
            });
            prj_slct = $prj_slct[0].selectize;
            prj_slct.enable();
            getTasksofProject($('#projFil').val());
            $('.timer-header').animate({
                'bottom': '265px',
                'left': '176px'
            }, function() {
                $('.timer-header .open-activity').removeClass('up').addClass('down');
                $('.timer-detail').show();
            });
        }
    });
}

function getTasksofProject(puid) {
    $.post(HTTP_ROOT + "easycases/existing_task", {
        'projuniqid': puid,
        'page': 'timer'
    }, function(data) {
        if (data) {
            typeof tsk_slct != 'undefined' ? tsk_slct.destroy() : '';
            $('#select-timer-task').html(data);
            $tsk_slct = $('#select-timer-task').selectize({
                onChange: function(value) {
                    if (!value.length)
                        return;
                    if (value != 0) {
                        $('#save-tm-span').hide();
                        $('#start-tm-span').show();
                    }
                },
                create: function(input) {
                    $.post(HTTP_ROOT + "easycases/quickTask", {
                        'title': input,
                        'project_id': $('#select-timer-proj').val(),
                        'type': 'inline',
                        'mid': ''
                    }, function(res) {
                        if (res.error) {
                            showTopErrSucc('error', res.msg);
                            return false;
                        } else {
                            showTopErrSucc('success', _('Task posted successfully.'));
                            $('#select-timer-task').append('<option value="' + res.curCaseId + '">' + input + '</option>');
                            $('#select-timer-task').val(res.curCaseId);
                            tsk_slct.addOption({
                                value: res.curCaseId,
                                text: input
                            });
                            tsk_slct.addItem(res.curCaseId);
                        }
                        if (client) {
                            client.emit('iotoserver', res.iotoserver);
                        }
                    }, 'json');
                }
            });
            tsk_slct = $tsk_slct[0].selectize;
            tsk_slct.enable();
        }
    });
}

function startTaskTimer() {
    var caseId = $('#select-timer-task').val();
    if (caseId == 0) {
        showTopErrSucc('error', _('Please select a task to start timer.'));
        return false;
    }
    $('#start-tm-span').hide();
    $('#save-tm-span,.timer-minus-btn,.timer-plus-btn').show();
    $('.timer-pause-btn').show();
    var caseTitle = $('#select-timer-task').find('option:selected').html();
    var projId = $('#timer_hidden_proj_id').val();
    var projNm = $('#timer_hidden_proj_nm').val();
    caseTitle = htmlspecialchars(escape(caseTitle), 3);
    startTimer(caseId, caseTitle, '', projId, escape(projNm));
}
var timer_interval;
var offset;
var clock = 0;
var now = Date.now();
var x = 0;
$(function() {
    var tmdet = getCookie('timerDtls');
    var tm = getCookie('timer');
    if (typeof tmdet != 'undefined' && tmdet != '' && typeof tm != 'undefined' && tm != '') {
        var tmCsDet = tmdet.split('|');
        var caseid = tmCsDet[0];
        var casetitle = tmCsDet[1];
        casetitle = changeCharToAnother(casetitle, 2);
        var caseuniqid = tmCsDet[2] != '' ? tmCsDet[2] : '';
        var prjuid = tmCsDet[3];
        var prjnm = tmCsDet[4];
        var description = getCookie('timerDescription');
        if (typeof description != 'undefined' && description != '') {
            $('#timerdesc').val(description);
            $('#timerdesc').parent('div').removeClass('is-empty');
        } else {
            $('#timerdesc').val('');
            $('#timerdesc').parent('div').addClass('is-empty');
        }
        if (typeof prjuid == 'undefined' || prjuid == '') {
            saveTimer('old_data');
        } else {
            var hasharr_tl = getHash().split('/');
            var sho_me_timer = 1;
            if (typeof tmCsDet[5] != 'undefined' && tmCsDet[5] != SES_COMP) {
                sho_me_timer = 0;
            }
            if (typeof hasharr_tl[0] != 'undefined' && sho_me_timer == 1) {
                startTimer(caseid, casetitle, caseuniqid, prjuid, prjnm, tm);
            }
        }
    }
});

function startTimer(caseId, caseTitle, caseUniqId, prjUid, prjnm) {
    prjnm = unescape(prjnm);
    var arg5 = arguments[5] || '';
    var exact_title_inpt = caseTitle;
    $.post(HTTP_ROOT + "easycases/check_dependant_action_allowed", {
        cid: caseId
    }, function(dependant_task_action_allowed) {
        $('#caseLoader').hide();
        if (dependant_task_action_allowed && dependant_task_action_allowed == 'No') {
            showTopErrSucc('error', _('Dependant tasks are not closed.'));
            return false;
        } else {
            if (timer_interval && !arg5) {
                showTopErrSucc('error', _('Timer is already running.'));
                return false;
            }
            $('#start-tm-span').hide();
            if (localStorage.getItem('timeState') != 'undefined' && localStorage.getItem('timeState')) {
                expandCollapseTimer();
            } else {
                expandTimer();
            }
            flag = 1;
            if ($('#timer_hidden_tsk_id').val().trim() == '' && $('#timer_hidden_tsk_uniq_id').val().trim() == '') {
                $('#timer_hidden_tsk_id').val(caseId);
                $('#timer_hidden_tsk_uniq_id').val(caseUniqId);
                $('.showtime_' + caseId).css('display', 'block');
            } else {
                flag = 0;
                var task_id = $('#timer_hidden_tsk_id').val() != '' ? $('#timer_hidden_tsk_id').val() : $('#select-timer-task').val();
                if ($('.showtime_' + task_id).length) {
                    $('.showtime_' + task_id).css('display', 'block');
                }
            }
            var orgprjnm = prjnm;
            var hasharr_tl = getHash().split('/');
            if (caseTitle.trim() == '') {
                if ($('.case_title_' + caseId).length) {
                    caseTitle = ($('.case_title_' + caseId + ' span').length > 1) ? $('.case_title_' + caseId + ' span:first').text() : $('.case_title_' + caseId + ' span').text();
                } else if (typeof hasharr_tl[0] != 'undefined' && hasharr_tl[0] == 'details') {
                    caseTitle = $('#case_ttl_edit_main_' + caseUniqId).text();
                    caseTitle = caseTitle.substr(caseTitle.indexOf(":") + 1);
                }
            }
            caseTitle = unescape(caseTitle);
            caseTitle = html_entity_decode(html_entity_decode(caseTitle.trim()));
            var orgcaseTitle = caseTitle;
            if (typeof prjUid != 'undefined' && prjUid != '' && typeof prjnm != 'undefined' && prjnm != '') {
                if (typeof prj_slct != 'undefined') {
                    prj_slct.destroy();
                }
                if (typeof tsk_slct != 'undefined') {
                    tsk_slct.destroy();
                }
                if (prjnm && prjnm.length > 30) {
                    prjnm = prjnm.substr(0, 25);
                }
                $('#select-timer-proj').html('<option value="' + prjUid + '">' + prjnm + '</option>');
                if (caseTitle && caseTitle.length > 30) {
                    caseTitle = caseTitle.substr(0, 25);
                }
                if (flag) {
                    $('#select-timer-task').html('<option value="' + caseId + '"></option>');
                    $('#select-timer-task option:first').text(caseTitle);
                }
            }
            $('#timer_hidden_proj_id').val(prjUid);
            $prj_slct = $('#select-timer-proj').selectize({
                allowEmptyOption: true
            });
            $tsk_slct = $('#select-timer-task').selectize({
                allowEmptyOption: true
            });
            prj_slct = $prj_slct[0].selectize;
            tsk_slct = $tsk_slct[0].selectize;
            prj_slct.disable();
            tsk_slct.disable();
            $('.timer-div').find('.tsk-title').text(caseTitle);
            $('.timer-div').find('.tsk-ttl').text(caseTitle);
            $('#cancel-timer-btn').show();
            $('#save-tm-span').show();
            $('#timerquickloading').hide();
            if (caseTitle && caseTitle.length > 30) {
                $('.timer-div').find('.tsk-ttl').attr({
                    'title': $('.timer-div').find('.tsk-ttl').html(),
                    'rel': 'tooltip'
                });
            }
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            var paused = getCookie('timerPaused');
            paused = typeof paused != 'undefined' ? paused : 0;
            if (paused == 1) {
                $('.timer-play-btn').css({
                    'display': 'inline-block'
                });
                $('.timer-pause-btn').hide();
            } else {
                $('.timer-play-btn').hide();
                $('.timer-pause-btn').css({
                    'display': 'inline-block'
                });
            }
            $('.timer-minus-btn,.timer-plus-btn').show();
            if (typeof arg5 != 'undefined' && arg5 != '') {
                offset = Date.now();
                update(arg5);
            } else {
                exact_title_inpt = changeCharToAnother(exact_title_inpt, 1);
                remember_filters('timerDtls', caseId + '|' + exact_title_inpt + '|' + caseUniqId + '|' + prjUid + '|' + orgprjnm + '|' + SES_COMP);
                remember_filters('timer', Date.now());
                $('.timer-time').text('00 : 00 : 00');
                $('#timer_is_billable').prop('checked', true);
                var description = getCookie('timerDescription');
                if (typeof description != 'undefined' && description != '') {
                    $('#timerdesc').val(description);
                    $('#timerdesc').parent('div').removeClass('is-empty');
                } else {
                    $('#timerdesc').val('');
                    $('#timerdesc').parent('div').addClass('is-empty');
                }
            }
            if (!timer_interval && !paused) {
                offset = now = Date.now();
                timer_interval = setInterval(update, 1);
            }
            $('.timer-div').show();
            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
            var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
            var event_name = sessionStorage.getItem('SessionStorageEventValue');
            if (eventRefer && event_name) {
                trackEventLeadTracker(event_name, eventRefer, sessionEmail);
            }
            var match = (window || this).location.href.match(/#(.*)$/);
            if (match != null) {
                var params = parseUrlHash(urlHash);
                if (params[0] != 'details' && caseUniqId != '' && $('#t_' + caseUniqId).length && !$("#myModalDetail").hasClass('in')) {
                    $('#t_' + caseUniqId).remove();
                }
            }
        }
    });
}

function update() {
    now = typeof arguments[0] != 'undefined' ? arguments[0] : Date.now();
    if (typeof arguments[0] != 'undefined' && typeof arguments[1] == 'undefined') {
        var paused = getCookie('timerPaused');
        paused = typeof paused != 'undefined' ? paused : 0;
        if (paused == 1) {
            clock = getCookie('timerDuration');
            clock = parseInt(clock);
        } else {
            if (typeof localStorage.TIMEEDITED != 'undefined') {
                clock = localStorage.TIMEEDITED;
            }
            var d = offset - now;
            var pausedTime = 0;
            var resumeTime = getCookie('timerResume');
            if (typeof resumeTime != 'undefined' && resumeTime != '') {
                var timeEnd = getCookie('timerEnd');
                timeEnd = (typeof timeEnd != 'undefined') ? timeEnd : resumeTime;
                pausedTime = parseInt(resumeTime) - parseInt(timeEnd);
                pausedt = (typeof localStorage.PAUSEDTIME != 'undefined') ? localStorage.PAUSEDTIME : 0;
                pausedt = parseInt(pausedt) + parseInt(pausedTime);
                localStorage.setItem('PAUSEDTIME', pausedt);
                remember_filters('timerEnd', '');
                remember_filters('timerResume', '');
            }
            ptm = (typeof localStorage.PAUSEDTIME != 'undefined') ? localStorage.PAUSEDTIME : 0;
            d = parseInt(d) - parseInt(ptm);
            clock = parseInt(clock) + parseInt(d);
        }
    } else {
        if (typeof arguments[2] != 'undefined' && arguments[1] == '2') {
            clock = arguments[2];
            offset = now;
        } else {
            var d = now - offset;
            offset = now;
            clock += d;
        }
    }
    if (parseInt(clock) >= 86400000) {
        showTopErrSucc('error', _('You have reached the maximum allowed time limit of 24hours. Please save or cancel the time log.'));
        clock = 86400000 - 1000;
        pauseTimer();
    }
    $('#timer_hidden_duration').val(clock);
    remember_filters('timerDuration', clock);
    var milliseconds = parseInt((clock % 1000) / 100),
        seconds = parseInt((clock / 1000) % 60),
        minutes = parseInt((clock / (1000 * 60)) % 60),
        hours = parseInt((clock / (1000 * 60 * 60)));
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
    $('.timer-time').text(hours + " : " + minutes + " : " + seconds);
}

function pauseTimer(e) {
    if (e) {
        e.stopPropagation();
    }
    if (timer_interval) {
        clearInterval(timer_interval);
        timer_interval = null;
        remember_filters('timerPaused', 1);
        remember_filters('timerEnd', Date.now());
    }
    $('.timer-pause-btn').hide();
    $('.timer-play-btn').css({
        'display': 'inline-block'
    });
}

function changeCharToAnother(str, typ) {
    if (typ == 1) {
        return str.split('|').join(":@$:");
    } else {
        return str.split(':@$:').join("|");
    }
}

function resumeTimer(e) {
    if (e) {
        e.stopPropagation();
    }
    if (!timer_interval) {
        timer_interval = setInterval(resume, 1000);
        remember_filters('timerPaused', 0);
        remember_filters('timerResume', Date.now());
    }
    $('.timer-play-btn').hide();
    $('.timer-pause-btn').css({
        'display': 'inline-block'
    });
}

function resume() {
    clock = getCookie('timerDuration');
    var d = parseInt(clock);
    d = d + 1000;
    if (parseInt(d) >= 86400000) {
        showTopErrSucc('error', _('You have reached the maximum allowed time limit of 24hours. Please save or cancel the time log.'));
        d = 86400000 - 1000;
        pauseTimer();
    }
    $('#timer_hidden_duration').val(d);
    remember_filters('timerDuration', d);
    var milliseconds = parseInt((d % 1000) / 100),
        seconds = parseInt((d / 1000) % 60),
        minutes = parseInt((d / (1000 * 60)) % 60),
        hours = parseInt((d / (1000 * 60 * 60)));
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
    $('.timer-time').text(hours + " : " + minutes + " : " + seconds);
}

function setDescription() {
    var description = $('#timerdesc').val();
    remember_filters('timerDescription', description);
}

function saveTimer() {
    var is_from_timer = 1;
    if (typeof getCookie('timerDtls') == 'undefined' || typeof getCookie('timer') == 'undefined' || typeof getCookie('timerDuration') == 'undefined') {
        stopTimer();
        showTopErrSucc('error', _('The timer is expired.'));
        return false;
    }
    if (timer_interval) {
        clearInterval(timer_interval);
        timer_interval = null;
    }
    var old_data = '';
    if (typeof arguments[0] != 'undefined') {
        old_data = arguments[0];
    }
    $('#cancel-timer-btn').hide();
    $('#save-tm-span').hide();
    $('#timerquickloading').show();
    var url = HTTP_ROOT + 'log_times/saveTimer';
    var caseUniqId = $('#timer_hidden_tsk_uniq_id').val();
    var project_id = $('#timer_hidden_proj_id').val() != '' ? $('#timer_hidden_proj_id').val() : $('#select-timer-proj').val();
    var task_id = $('#timer_hidden_tsk_id').val() != '' ? $('#timer_hidden_tsk_id').val() : $('#select-timer-task').val();
    dtt = Date.now();
    dtt = parseInt(dtt) + parseInt(typeof localStorage.TIMEEDITED != 'undefined' ? localStorage.TIMEEDITED : 0) + parseInt(typeof localStorage.PAUSEDTIME != 'undefined' ? localStorage.PAUSEDTIME : 0);
    var params = {
        is_from_timer: is_from_timer,
        project_id: project_id,
        task_id: task_id,
        start_time: getCookie('timer'),
        totalduration: $('#timer_hidden_duration').val(),
        end_time: dtt,
        description: trim($('#timerdesc').val()),
        chked_ids: $('#timer_is_billable').is(':checked') ? 1 : 0
    };
    $.post(url, {
        params: params
    }, function(data) {
        if (data.status == 'success') {
            $('#lst_uptd').html(data.last_updated);
            if (old_data == 'old_data') {
                stopTimer('old_data_success');
            } else {
                stopTimer();
                refreshTasks = 1;
                var match = (window || this).location.href.match(/#(.*)$/);
                if (match != null) {
                    var params = parseUrlHash(urlHash);
                    if (params[0] != 'details' && data.task_id != '' && $('#t_' + data.task_id).length && !$("#myModalDetail").hasClass('in')) {
                        $('#t_' + data.task_id).remove();
                    }
                }
                $('#cancel-timer-btn').show();
                $('#save-tm-span').show();
                $('#start-tm-span').hide();
                $('#timerquickloading').hide();
                showTopErrSucc('success', _('Timelog updated successfully.'));
                showTimeLogList(data.task_id, 0);
                var hash = parseUrlHash(urlHash);
                if (hash == 'timelog' || hash == 'calendar_timelog' || hash == 'chart_timelog') {
                    $('#projFil').val($('#select-timer-proj').val());
                    window.location.reload();
                } else if ((hash[0] == 'details' && data.task_id == hash[1]) || $("#myModalDetail").hasClass('in')) {
                    ajaxTimeLogView('', '', '', $('#select-timer-task').val());
                }
            }
            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
            trackEventLeadTracker('Time Log', 'Save Timer Page', sessionEmail);
        } else {
            if (data.success == 'No') {
                if (old_data == 'old_Data') {
                    stopTimer('old_data_overlap');
                } else {
                    stopTimer();
                    var html = '';
                    var users_arr = new Array();
                    $.each(PUSERS, function(key, val) {
                        $.each(val, function(k1, v1) {
                            users_arr[v1['User']['id']] = v1['User']['name'];
                        });
                    });
                    $.each(data.data, function(index, value) {
                        $.each(value, function(index1, value2) {
                            html += users_arr[value2.user_id] + " " + _('on') + " " + value2.task_date + " " + _('from') + " " + value2.start_time + " " + _('to') + " " + value2.end_time + " ";
                            html += "<br/>";
                        });
                    });
                    showTopErrSucc('error', _('Time Log value overlapping for following users') + ':<br/>' + html);
                }
            }
            if (data.success == 'err') {
                stopTimer();
                showTopErrSucc('error', data.message);
            }
        }
    }, 'json');
}

function stopTimer() {
    if (timer_interval) {
        clearInterval(timer_interval);
        timer_interval = null;
    }
    clock = 0;
    var tmdet = getCookie('timerDtls');
    var tm = getCookie('timer');
    if (typeof tmdet != 'undefined' && tmdet != '' && typeof tm != 'undefined' && tm != '') {
        var tmCsDet = tmdet.split('|');
        var taskautoid = tmCsDet[0];
        if ($('.showtime_' + taskautoid).length) {
            $('.showtime_' + taskautoid).css('display', 'none');
        }
    }
    remember_filters('timerDtls', '');
    remember_filters('timer', '');
    remember_filters('timerEnd', '');
    remember_filters('timerDescription', '');
    localStorage.removeItem('TIMEEDITED');
    localStorage.removeItem('PAUSEDTIME');
    localStorage.removeItem('timeState');
    remember_filters('timerPaused', 0);
    remember_filters('timerResume', '');
    $('#timer_hidden_tsk_id').val('');
    $('#timer_hidden_tsk_uniq_id').val('');
    $('#timer_hidden_proj_id').val('');
    $('.timer-time').text('00:00:00');
    $('.timer-div').hide();
    if (typeof arguments[0] != 'undefined') {
        if (arguments[0] == 'old_data_success') {
            showTopErrSucc('success', _('Timer functionality is updated. So the old timer data is saved. Please start a new timer.'));
        } else if (arguments[0] == 'old_data_overlap') {
            showTopErrSucc('error', _('Timer functionality is updated. So the old timer data can not be saved due to overlap condition. Please start a new timer.'));
        }
    }
}

function setProjectid(pid, pname, prjunid) {
    ucpname = decodeURIComponent(pname);
    cnt = "<a href='javascript:void(0);'>" + ucpname + "</a>";
    $("#pname_dashboard_log").html(cnt);
    $('#projpopup_log').hide();
    $('#prj_drpdwn').removeClass("open");
    $(".dropdown-menu.lft").hide();
    $('#prjsid').val(prjunid);
    $('#tskttl').val(ucpname);
    $("tr[id^='ul_timelog']").not(':first').remove();
    $("tr[id^='ul_timelog']").find('.crsid').hide();
    switchProject('hide');
    $.post(HTTP_ROOT + "easycases/existing_task", {
        'projuniqid': prjunid,
        'list': 'list'
    }, function(data) {
        if (data) {
            $('#log_task_results').html(data);
            $("#log_task_id,#log_search").val('');
            $('.slct_task > span').html(_('Select The Task To Log Time'));
            $('.slct_task > span').removeClass("not_empty");
        }
    });
    project_timelog_details('');
    getTimelogActivity(prjunid);
}

function switchProject(v) {}

function getTimelogActivity(project) {
    var taskid = (typeof arguments[1] != 'undefined') ? arguments[1] : '';
    $.post(HTTP_ROOT + "logTimes/getlastLog", {
        "projUniq": project,
        "pageload": 0,
        "taskid": taskid
    }, function(data) {
        $('#projectaccess_log').html(data);
    });
}

function searchLogTask() {
    loader = '<div style="text-align:center;padding:5px;"><img src="' + HTTP_ROOT + 'img/images/del.gif" alt="Loading..."></div>';
    $("#log_task_results").html(loader);
    var URL = HTTP_ROOT + "easycases/existing_task";
    var pid = $("#prjsid").val();
    var q = $('#log_search').val();
    $.post(URL, {
        projuniqid: pid,
        list: 'list',
        q: q
    }, function(res) {
        $("#log_task_results").html(res);
    });
}

function showLogResults() {
    $(".logResult").removeClass('hide');
    $("#log_search,#log_addon").val('');
    $(".logTasks").show();
    $("#log_search_task").hide();
    searchLogTask();
}

function setLogTask(v, obj) {
    $("#log_task_id").val(v);
    $('.slct_task > span').text($(obj).text());
    $('.slct_task > span').addClass("not_empty");
    $(".logResult").addClass("hide");
    modifyheader();
    project_timelog_details(v);
    getTimelogActivity($('#prjsid').val(), v);
}

function showQuickLogTask() {
    $("#log_addon").val('');
    if ($("#log_search_task").is(":visible")) {
        $("#log_search_task").hide();
        $(".addQuickTask > .logTasks").show();
    } else {
        $(".addQuickTask > .logTasks").hide();
        $("#log_search_task").show();
    }
}

function logQuickAddTask() {
    var val = $("#log_addon").val().trim();
    var projId = $("#prjsid").val();
    if (val == '') {
        showTopErrSucc('error', _('Please enter a task title'));
        return false;
    }
    if (projId == '' || projId == 'all') {
        showTopErrSucc('error', _('Please select a project'));
        return false;
    }
    $.post(HTTP_ROOT + "easycases/quickTask", {
        'title': val,
        'project_id': projId,
        'type': 'inline',
        'mid': ''
    }, function(res) {
        $("#log_task_results").append("<a href='javascript:void(0);' onclick='setLogTask(" + res.curCaseId + ",this);' class='logTasks' id='logTask_'" + res.curCaseId + ">" + '#' + res.curCaseId + ': ' + val + "</a>");
        showQuickLogTask();
        $("#log_task_id").val(res.curCaseId);
        $('.slct_task > span').html('#' + res.curCaseNo + ': ' + val);
        $('.slct_task > span').addClass("not_empty");
        $(".logResult").addClass("hide");
        modifyheader();
        project_timelog_details(res.curCaseId);
        if (client) {
            client.emit('iotoserver', res.iotoserver);
        }
    }, 'json');
}

function checkKeyCode(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if (unicode == 13) {
        logQuickAddTask();
    }
}

function resetLogTask() {
    $(".logResult").addClass('hide');
    $("#log_search,#log_addon,#log_task_id").val('');
    $(".logTasks").show();
    $("#log_search_task").hide();
}

function saveUserSkills() {
    var value = $("#user-skills").val();
    var userId = $("#profile-id-popup").val();
    $.post(HTTP_ROOT + "users/saveUserSkill", {
        skillID: value,
        userId: userId
    }, function(resdata) {}, "json");
}
function edit_user(usr_id, usr_name) {
    openPopup();
    $(".edit_usr_pop").show();
    $("#header_usr_name_edit").html(usr_name);
    $("#submit_Profile-popup").attr('disabled', true).removeClass('btn-info');
    if (GCAPTCH_KEY) {
        $('#edit_user_recaptcha').html('');
        $('#edit_user_recaptcha').html('<script src="https://www.google.com/recaptcha/api.js?render=' + GCAPTCH_KEY + '"></script>');
    }
    $("#user-skills").html('');
    $("#user-skills").select2();
    $.post(HTTP_ROOT + "users/getUserInfo", {
        "uid": usr_id
    }, function(data) {
        if (data) {
            $("#profile-id-popup").val(data.User.id);
            $("#profile-id-popup").closest('.form-group').removeClass('is-empty');
            $("#profile_name-popup").val(data.User.name);
            $("#profile_name-popup").closest('.form-group').removeClass('is-empty');
            $("#profile_last_name-popup").val(data.User.last_name);
            $("#profile_last_name-popup").closest('.form-group').removeClass('is-empty');
            $("#short_name-popup").val(data.User.short_name);
            $("#short_name-popup").closest('.form-group').removeClass('is-empty');
            $("#email-popup").val(data.User.email);
            $("#email-popup").closest('.form-group').removeClass('is-empty');
            var varify = '<div class="verify-yes-icon" style="right:0;"><span><img title="Email address varified" rel="tooltip" src="' + HTTP_ROOT + 'img/yes1.png"/></span></div>';
            if (data.User.updated_by != 0) {
                varify = '<p style="font-size: 12px;margin-bottom: 10px; color:#CD5C5C;">' + _("Email address changed to") + ' "' + data.User.update_email + '" ' + _("but not yet verified") + '.</p>';
            }
            $("#emailVarify-popup").html(varify);
            var options = '';
            for (var key in data.Timezone) {
                if (data.Timezone.hasOwnProperty(key)) {
                    selected_txt = (data.Timezone[key]['TimezoneName']['id'] == data.User.timezone_id) ? " selected " : "";
                    options += "<option value='" + data.Timezone[key]['TimezoneName']['id'] + "' " + selected_txt + ">" + data.Timezone[key]['TimezoneName']['gmt'] + " " + data.Timezone[key]['TimezoneName']['zone'] + "</option>";
                }
            }
            $("#timezone_id-popup").html(options);
            $("#timezone_id-popup").closest('.form-group').removeClass('is-empty');
            if (data.User.isemail == 1) {
                $("#profile-is-email-popup").attr('checked', true);
            }
            var img_txt = '';
            if (data.User.user_img_exists == 1) {
                img_txt += '<div id="existProfImg-popup" onmouseover="showEditDeleteImg(\'popup\')" onmouseout="hideEditDeleteImg(\'popup\')"><div class="fl">\n\
                            <a data-href="' + data.User.fileurl + '" href="javascript:void(0);" onClick="openProfilePopup(\'popup\')">\n\
                            <img src="' + HTTP_ROOT + 'users/image_thumb/?type=photos&file=' + data.User.photo + '&sizex=100&sizey=100&quality=100" border="0" id="profphoto-popup"/>\n\
                            </a><input type="hidden" name="data[User][photo]" class="text_field" id="imgName1-popup"><input type="hidden" name="data[User][exst_photo]" class="text_field" id="exst_photo-popup" value="' + data.User.photo + '"></div>\n\
                                <div style="display:none" id="editDeleteImg-popup" class="fl mtop20 editDeleteImg-popup" ><span id="uploadImgLnk-popup"><a title="Edit Profile Image" class="custom-t-type" href="javascript:void(0);" onClick="openProfilePopup(\'popup\')"><i class="material-icons" title="Edit">&#xE254;</i></a></span>\n\
                                <a title="Delete Profile Image"  class="custom-t-type rm" href="javascript:void(0);" onclick="removeImgPopup(\' ' + HTTP_ROOT + 'users/profile/' + data.User.photo + '/' + data.User.id + ' \');">\n\
                                    <span> <i class="material-icons" title="Delete">&#xE872;</i> </span></a></div><div class="cb"></div></div>';
            } else {
                img_txt += '<div id="defaultUserImg-popup" class="fl"><img width="55" height="55" src="' + HTTP_ROOT + 'files/photos/profile_Img.png" onClick="openProfilePopup(\'popup\')" id="profphoto-popup"></div>\n\
                            <div id="uploadImgLnk-popup" class="fl mtop20 editDeleteImg-popup"><a href="javascript:void(0);" onClick="openProfilePopup(\'popup\')" >' + _('Choose Profile Image') + '</a></div><div class="cb"></div><input type="hidden" id="imgName1-popup" name="data[User][photo]" /> ';
            }
            $('#IMG-DIV').html(img_txt);
            $("#submit_Profile-popup").attr('disabled', false).addClass('btn-info');
            $('#pop_up_add_user_proj_label').css('display', 'block');
            $('#prjsrch').show();
            $('#inner_usr_prj_add').show();
            $('#inner_usr_prj_add').html(data);
            $('.add-prj-btn').show();
            enableAddPrjBtns('.AddPrjToUser');
            $.material.init();
        }
    }, 'json');
}

function saveFilter() {
    openPopup();
    $(".add_task_filter_pop").show();
    if (typeof localStorage.SEARCHFILTER != 'undefined')
        $("#flt-id-popup").val(localStorage.SEARCHFILTER.replace('ftopt', ''));
    $("#flt-STATUS-popup").val(localStorage.STATUS);
    $("#flt-CUSTOM_STATUS-popup").val(localStorage.CUSTOM_STATUS);
    $("#flt-PRIORITY-popup").val(localStorage.PRIORITY);
    $("#flt-CS_TYPES-popup").val(localStorage.CS_TYPES);
    $("#flt-TASKLABEL-popup").val(localStorage.TASKLABEL);
    $("#flt-MEMBERS-popup").val(localStorage.MEMBERS);
    $("#flt-COMMENTS-popup").val(localStorage.COMMENTS);
    $("#flt-ASSIGNTO-popup").val(localStorage.ASSIGNTO);
    $("#flt-DATE-popup").val(localStorage.DATE);
    $("#flt-TASKGROUP-popup").val(localStorage.TASKGROUP);
    $("#flt-DUE_DATE-popup").val(localStorage.DUE_DATE);
    if (typeof localStorage.SEARCHFILTER != 'undefined' && localStorage.SEARCHFILTER != '' && localStorage.SEARCHFILTER.substring(0, 5) == 'ftopt') {
        $("#filter_create_1").prop('checked', true);
        $("#updateFilterName").html("'" + $("#" + localStorage.SEARCHFILTER).find('.wrap_title_txt').html().replace(/\(.*\)/, '') + "'");
        $("#filter_name").val("").attr('disabled', true);
        $("#filter_create_1").prop('disabled', false);
        $("#submit_filter-popup").html("Update");
        $("#filter_label").html('Update Filter');
    } else {
        $("#filter_create_0").prop('checked', true);
        $("#filter_create_1").prop('disabled', true);
        $("#filter_name").val('').attr('disabled', false);
        $("#updateFilterName").html("");
        $("#submit_filter-popup").html("Save");
        $("#filter_label").html('Save Filter');
    }
}

function viewFilters() {
    var args = typeof arguments[0] != 'undefined' ? '_' + arguments[0] : '';
    if (!$('#filpopup' + args).is(':visible')) {
        $('#filpopup' + args).show();
    } else {
        $('#filpopup' + args).hide();
    }
}

function viewFilters_new() {
    $("#filterSearch_id").hide();
    $("#filpopup").show();
}

function viewFilters_btn() {
    if (!$('body').hasClass('mini-sidebar')) {
        $('#filpopup').slideUp();
        $("#filterSearch_id").show();
    }
}

function setSavedFilter(obj) {
    if (getHash() != 'kanban') {
        $("#filterSearch_id").addClass('active-list');
    } else {}
    remember_filters('reset');
    if ($('body').hasClass('mini-sidebar')) {
        $(".active_inner").each(function() {
            $(this).removeClass("active_inner");
        });
        $(obj).addClass('active_inner');
        $(".cattab").removeClass("active-list");
    }
    $(".filter-dropdown").find('button a').html($(obj).html());
    $("#filterSearch_id").show();
    $(".filter-dropdown").find('button a span').removeAttr('id');
    txt = $("<div>").html($(obj).html()).find('.wrap_title_txt').text();
    $(".filter-dropdown").find('button a').attr('title', txt);
    $('#filpopup,#filpopup_kanban').hide();
    var id = $(obj).attr('id');
    var id_value = $("#" + id).attr("data-val");
    localStorage.setItem("SEARCHFILTER", id);
    localStorage.setItem("SELECTTAB", 'dropdown');
    $('#caseStatus,#priFil,#caseTypes,#caseLabel,#caseMember,#caseComment,#caseAssignTo,#caseDateFil,#casedueDateFil').val('');
    if (id.substring(0, 5) == 'ftopt') {
        $('#caseMenuFilters').val("cases");
        $("#caseMenuFilterskanban").val('cases');
        $(".cattab").removeClass("active-list");
        $.post(HTTP_ROOT + "searchFilters/setFilter", {
            id: id_value
        }, function(res) {
            for (var prop in res) {
                if (res.hasOwnProperty(prop)) {
                    if (res[prop]) {
                        localStorage.setItem(prop, res[prop]);
                        if (prop == 'STATUS') {
                            $('#caseStatus').val(res[prop]);
                        } else if (prop == 'PRIORITY') {
                            $('#priFil').val(res[prop]);
                        } else if (prop == 'CS_TYPES') {
                            $('#caseTypes').val(res[prop]);
                        } else if (prop == 'TASKLABEL') {
                            $('#caseLabel').val(res[prop]);
                        } else if (prop == 'MEMBERS') {
                            $('#caseMember').val(res[prop]);
                        } else if (prop == 'COMMENTS') {
                            $('#caseComment').val(res[prop]);
                        } else if (prop == 'ASSIGNTO') {
                            $('#caseAssignTo').val(res[prop]);
                        } else if (prop == 'DATE') {
                            $('#caseDateFil').val(res[prop]);
                        } else if (prop == 'DUE_DATE') {
                            $('#casedueDateFil').val(res[prop]);
                        } else if (prop == 'TASKGROUP_FIL') {
                            casePage = 1;
                        }
                    }
                }
            }
            easycase.refreshTaskList();
        }, 'json');
    } else {
        var arg1 = (arguments[1] != 'undefined') ? arguments[1] : '';
        var arg2 = (arguments[2] != 'undefined') ? arguments[2] : '';
        var arg3 = (arguments[3] != 'undefined') ? arguments[3] : '';
        var arg4 = (arguments[4] != 'undefined') ? arguments[4] : '';
        if (getHash() != 'kanban') {
            caseMenuFileter(arg1, arg2, arg3, arg4, 'no_reset');
        } else {
            $("#caseMenuFilterskanban").val(arg1);
            easycase.showKanbanTaskList();
        }
    }
}

function setSavedSrchFilter(page, id_val) {
    if (getHash() != 'kanban') {
        $("#filterSearch_id").addClass('active-list');
    }
    remember_filters('reset');
    var d_filters = ["cases", "closedtasks", "openedtasks", "highpriority", "delegateto", "overdue", "favourite", "assigntome"];
    var id_value = id_val;
    if ($('body').hasClass('mini-sidebar')) {
        $(".active_inner").each(function() {
            $(this).removeClass("active_inner");
        });
        $('#ftopt' + id_value).addClass('active_inner');
        $(".cattab").removeClass("active-list");
    }
    $(".filter-dropdown").find('button a').html($('#ftopt' + id_value).html());
    $("#filterSearch_id").show();
    $(".filter-dropdown").find('button a span').removeAttr('id');
    txt = $("<div>").html($('#ftopt' + id_value).html()).find('.wrap_title_txt').text();
    $(".filter-dropdown").find('button a').attr('title', txt);
    $('#filpopup,#filpopup_kanban').hide();
    $('#caseStatus,#priFil,#caseTypes,#caseLabel,#caseMember,#caseComment,#caseAssignTo,#caseDateFil,#casedueDateFil').val('');
    if (1) {
        $('#caseMenuFilters').val("cases");
        $("#caseMenuFilterskanban").val('cases');
        if ($.inArray(id_val, d_filters) >= 0) {
            $('#caseMenuFilters').val(id_val);
            $('#caseTaskgroup').val('');
            easycase.refreshTaskList();
        } else {
            $(".cattab").removeClass("active-list");
            $.post(HTTP_ROOT + "searchFilters/setFilter", {
                id: id_value,
                'type': 'new_fil'
            }, function(res) {
                var idsplt = id_val.split('-');
                if (prop != 'serc_id') {
                    localStorage.setItem("SEARCHFILTER", 'ftopt' + idsplt[1]);
                    localStorage.setItem("SELECTTAB", 'dropdown');
                }
                if (res) {
                    for (var prop in res) {
                        if (prop == 'serc_id') {
                            localStorage.setItem("SEARCHFILTER", 'ftopt' + res[prop]);
                            localStorage.setItem("SELECTTAB", 'dropdown');
                        } else if (res.hasOwnProperty(prop)) {
                            if (res[prop]) {
                                localStorage.setItem(prop, res[prop]);
                                if (prop == 'CUSTOM_STATUS') {
                                    getGlobalFilters('CUSTOM_STATUS');
                                } else if (prop == 'STATUS') {
                                    $('#caseStatus').val(res[prop]);
                                } else if (prop == 'PRIORITY') {
                                    $('#priFil').val(res[prop]);
                                } else if (prop == 'CS_TYPES') {
                                    $('#caseTypes').val(res[prop]);
                                } else if (prop == 'TASKLABEL') {
                                    $('#caseLabel').val(res[prop]);
                                } else if (prop == 'MEMBERS') {
                                    $('#caseMember').val(res[prop]);
                                } else if (prop == 'COMMENTS') {
                                    $('#caseComment').val(res[prop]);
                                } else if (prop == 'ASSIGNTO') {
                                    $('#caseAssignTo').val(res[prop]);
                                } else if (prop == 'DATE') {
                                    $('#caseDateFil').val(res[prop]);
                                } else if (prop == 'DUE_DATE') {
                                    $('#casedueDateFil').val(res[prop]);
                                } else if (prop == 'TASKGROUP') {
                                    $('#caseTaskgroup').val(res[prop]);
                                } else if (prop == 'TASKGROUP_FIL') {
                                    casePage = 1;
                                }
                            }
                        }
                    }
                    easycase.refreshTaskList();
                } else {
                    easycase.refreshTaskList();
                }
            }, 'json');
        }
    } else {}
}

function minus10(event) {
    clock1 = getCookie('timerDuration');
    n = Date.now();
    if (parseInt(clock1) > parseInt(600000)) {
        n1 = parseInt(clock1) - parseInt(600000);
        update(n, 2, n1);
        $timeedited = (typeof localStorage.TIMEEDITED != 'undefined') ? localStorage.TIMEEDITED : 0;
        $timeedited = parseInt($timeedited) - parseInt(600000);
        $timeedited = (parseInt($timeedited) > 0) ? $timeedited : 0;
        localStorage.setItem('TIMEEDITED', $timeedited);
    } else {
        showTopErrSucc('error', _('You can use this feature only after 10mins.'));
        event.stopPropagation();
        return false;
    }
    event.stopPropagation();
}

function plus10(event) {
    clock1 = getCookie('timerDuration');
    n = Date.now();
    n1 = parseInt(clock1) + parseInt(600000);
    if (parseInt(n1) < 86400000) {
        update(n, 2, n1);
        $timeedited = (typeof localStorage.TIMEEDITED != 'undefined') ? localStorage.TIMEEDITED : 0;
        $timeedited = parseInt($timeedited) + parseInt(600000);
        $timeedited = (parseInt($timeedited) > 0) ? $timeedited : 0;
        localStorage.setItem('TIMEEDITED', $timeedited);
        event.stopPropagation();
    } else {
        showTopErrSucc('error', _('You cannot set the time for more than 24hours.'));
        event.stopPropagation();
        return false;
    }
}

function showNotifications() {
    var args = Array.prototype.slice.call(arguments);
    var url = HTTP_ROOT + "Reports/getNotificationCounts";
    $.post(url, {}, function(data) {
        if (data) {
            $('#total_notification_count').val(data.res.totalCount);
            $('#not-container').html(tmpl('notification_tmpl', data));
            if (data.res.totalCount == 0) {
                $('#no_notification_li').show();
            }
            if (typeof args[0] == "undefined" && !parseInt($('#new_release_count').val())) {
                if (data.res.totalCount == 0) {
                    $('.nav-notification-bar .notification-icon').addClass('inactive');
                    $('.notification-count').hide();
                } else {
                    $('.nav-notification-bar .notification-icon').removeClass('inactive').addClass('active');
                    $('.notification-count').text(data.res.totalCount).removeClass('hidden');
                }
            }
            getProductrelease();
        }
    }, 'json').fail(function(xhr, textStatus, errorThrown) {
        return true;
    });
}

function showReleasedtls(id) {
    openPopup();
    $('.relese_description_pop').show();
    $.ajax({
        url: HTTP_ROOT + "Reports/get_releaseinfo",
        type: 'POST',
        dataType: 'html',
        data: {
            rl_id: id
        },
    }).done(function(res) {
        $('.loader_dv').hide();
        $('#inner_rels_detl').show();
        $('#inner_rels_detl').html(res);
        $('#rls-new-' + id).remove();
        var cur_count = parseInt($('.notification-count').text());
        if (cur_count) {
            var new_cnt = cur_count - 1;
            $('.notification-count').text(new_cnt);
            $('#new_release_count').val(new_cnt);
        } else {
            $('.notification-count').hide();
            $('.notification-icon').addClass('inactive');
        }
    });
}

function getProductrelease() {
    $.ajax({
        url: HTTP_ROOT + "Reports/getProductreleaseCounts",
        type: 'POST',
        dataType: 'json',
        data: {},
    }).done(function(resp) {
        $('.product_up_notfy').html('').html(tmpl('pr_release_notification_tmpl', resp));
        var total_notification_count = parseInt($('#total_notification_count').val());
        var new_not_count = resp.new_count + total_notification_count;
        if (new_not_count == 0) {
            $('.nav-notification-bar .notification-icon').addClass('inactive');
            $('.notification-count').hide();
        } else {
            $('.nav-notification-bar .notification-icon').removeClass('inactive').addClass('active');
            $('.notification-count').text(new_not_count).removeClass('hidden').show();
        }
        $('#new_release_count').val(resp.new_count);
    });
}
var open_timelog = 0;

function seenNotification(type) {
    if (parseInt($('#new_release_count').val())) {
        $('.notification-count').show();
    } else {
        if (type == 'total') {
            $('.notification-count').hide();
        }
    }
    var url = HTTP_ROOT + 'reports/updateLastSeen';
    $.post(url, {
        type: type
    }, function(res) {
        if (res) {
            if (type != 'total') {
                var count = $('#' + type + '_count').val();
                var totalCnt = $('#total_notification_count').val() - count;
            } else {
                var totalCnt = $('#total_notification_count').val();
            }
            if (parseInt($('#new_release_count').val())) {
                totalCnt = parseInt(totalCnt) + parseInt($('#new_release_count').val());
            }
            $('.notification-count').text(totalCnt);
            $('#' + type + '_notification_li').remove();
            if (totalCnt == 0) {
                $('.notification-count').hide();
                $('.notification-icon').addClass('inactive');
            }
            var params = parseUrlHash(urlHash);
            if (type == 'total') {
                showNotifications('redCall');
                $('.nav-notification-bar ul.notification-ul').show();
            } else if (type == 'assigntome') {
                $('#projFil').val('all');
                remember_filters('TASKGROUPBY', '');
                $('#caseAssignTo').val(SES_ID);
                remember_filters('ASSIGNTO', SES_ID);
                $('#caseDateFil').val($('#assigntome_date').val());
                remember_filters('DATE', $('#assigntome_date').val());
                if (params == 'tasks') {
                    updateAllProj('0', '0', 'dashboard', 'all', 'All');
                } else {
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                }
            } else if (type == 'overdue') {
                $('#projFil').val('all');
                remember_filters('TASKGROUPBY', '');
                if (params == 'tasks') {
                    $('#caseMenuFilters').val('overdue');
                    updateAllProj('0', '0', 'dashboard', 'all', 'All');
                } else {
                    $('#casedueDateFil').val('overdue');
                    remember_filters('DUE_DATE', 'overdue');
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                }
            } else if (type == 'activity') {
                checkHashLoad('activities');
                window.location = HTTP_ROOT + 'dashboard#activities';
            } else if (type == 'pricing') {
                window.location = HTTP_ROOT + 'pricing';
            } else if (type == 'timelog') {
                localStorage.setItem('open_timelog', 1);
                window.location = HTTP_ROOT + 'dashboard#timelog';
            }
        }
    });
}

function showSubtaskTitle(title, id, related, wrap, short, page, uniq_id) {
    var page = page || '';
    if (page == 'detail')
        title = '';
    var wrap = wrap || true;
    var short = short || true;
    var separator = ' <i class="material-icons case_symb">&#xE314;</i> ';
    var separator_clnt = ' <i class="material-icons case_symb" style="display:none;" >&#xE314;</i> ';
    if (typeof related['parent'] != 'undefined' && typeof related['parent'][id] != 'undefined' && related['parent'][id] != '' && related['task']) {
        var parent_id = related['parent'][id];
        var clnt_chk = 0;
        if (typeof related['parent'] != 'undefined' && typeof related['parent'][parent_id] != 'undefined' && related['parent'][parent_id] != '') {
            var len = 15;
            var super_parent_id = related['parent'][parent_id];
            if (short === true) {
                var title = TaskTitleSpan(title, uniq_id, formatText(title), clnt_chk, 0, page);
                if (typeof related['data'][parent_id] != 'undefined') {
                    clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[parent_id])) ? 1 : 0;
                    title += (clnt_chk) ? separator_clnt : separator;
                    title += TaskTitleSpan(related['task'][parent_id], related['data'][parent_id]['uniq_id'], formatText(related['task'][parent_id]), clnt_chk, 1, page);
                }
                if (typeof related['data'][super_parent_id] != 'undefined') {
                    clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[super_parent_id])) ? 1 : 0;
                    title += (clnt_chk) ? separator_clnt : separator;
                    title += TaskTitleSpan(related['task'][super_parent_id], related['data'][super_parent_id]['uniq_id'], formatText(related['task'][super_parent_id]), clnt_chk, 1, page);
                }
            } else {
                var title = TaskTitleSpan(title, uniq_id, title, clnt_chk, 0, page);
                if (typeof related['data'][parent_id] != 'undefined') {
                    clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[parent_id])) ? 1 : 0;
                    title += (clnt_chk) ? separator_clnt : separator;
                    title += TaskTitleSpan(related['task'][parent_id], related['data'][parent_id]['uniq_id'], related['task'][parent_id], clnt_chk, 1, page);
                }
                if (typeof related['data'][super_parent_id] != 'undefined') {
                    clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[super_parent_id])) ? 1 : 0;
                    title += (clnt_chk) ? separator_clnt : separator;
                    title += TaskTitleSpan(related['task'][super_parent_id], related['data'][super_parent_id]['uniq_id'], related['task'][super_parent_id], clnt_chk, 1, page);
                }
            }
        } else {
            var len = 25;
            if (short === true) {
                var title = TaskTitleSpan(title, uniq_id, formatText(title), clnt_chk, 0, page);
                if (typeof related['data'][parent_id] != 'undefined') {
                    clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[parent_id])) ? 1 : 0;
                    title += (clnt_chk) ? separator_clnt : separator;
                    title += TaskTitleSpan(related['task'][parent_id], related['data'][parent_id]['uniq_id'], formatText(related['task'][parent_id]), clnt_chk, 1, page);
                }
            } else {
                var title = TaskTitleSpan(title, uniq_id, title, clnt_chk, 0, page);
                clnt_chk = (parseInt(related['client_status'].is_client) && parseInt(related['client_status'].chekstatus[parent_id])) ? 1 : 0;
                title += (clnt_chk) ? separator_clnt : separator;
                title += TaskTitleSpan(related['task'][parent_id], related['data'][parent_id]['uniq_id'], related['task'][parent_id], clnt_chk, 1, page);
            }
        }
    } else {
        var len = 45;
        if (short === true) {
            var title = TaskTitleSpan(title, uniq_id, formatText(title), 0, 0, page);
        } else {
            var title = TaskTitleSpan(title, uniq_id, title, 0, 0, page);
        }
    }
    return title;
}

function TaskTitleSpan(title, uniq_id, short_title, isclient, chkcls, page) {
    var clnt_ck = (isclient) ? 'display:none;' : '';
    if (chkcls && page != 'detail') {
        return '<span style="' + clnt_ck + '" title="' + formatText(ucfirst(title)) + '" rel="tooltip" class="anchor case-title titlehtml subtask_elipse" data-task="' + uniq_id + '">' + formatText(ucfirst(short_title)) + '</span>';
    } else {
        return '<span style="' + clnt_ck + '" title="' + formatText(ucfirst(title)) + '" rel="tooltip" class="anchor case-title titlehtml" data-task="' + uniq_id + '">' + formatText(ucfirst(short_title)) + '</span>';
    }
}

function switchTaskToMilestoneAction(page, params) {
    var page = page || '';
    var params = params || {};
    $.ajax({
        url: HTTP_ROOT + 'milestones/switchTaskToMilestone',
        dataType: "json",
        type: "POST",
        data: params,
        success: function(res) {
            if (res.status == 'success') {
                showTopErrSucc('success', _('Task moved successfully.'));
                if (page == 'kanban') {
                    if ($('#mlstab_cmpl_kanban').hasClass('active')) {
                        showMilestoneList('', 0);
                    } else {
                        showMilestoneList('', 1);
                    }
                }
            } else {
                if (res.message) {
                    showTopErrSucc('error', res.message);
                } else {
                    showTopErrSucc('error', _('Error in moving task to task group'));
                }
            }
            if (page == 'ajaxCaseView') {
                update_sequence(params.caseIds, params.curr_mlst_id, params.project_id);
            }
        },
        error: function() {
            showTopErrSucc('error', _('Error in moving task to task group'));
        }
    });
}

function updateParentTasks(tasks) {
    if (typeof tasks != 'undefined') {
        typeof prj_parent_task_slct != 'undefined' ? prj_parent_task_slct.destroy() : '';
        typeof prj_parent_task_slct != 'undefined' ? prj_parent_task_slct.clearOptions() : '';
        typeof prj_parent_task_slct != 'undefined' ? prj_parent_task_slct.clearCache() : '';
        $('#CS_parent_task').val('').html('');
        $('#CS_parent_task').append("<option value=''>" + _('Select Parent Task') + "</option>");
        $.each(tasks, function(key, val) {
            $('#CS_parent_task').append("<option value='" + key + "'>" + val + "</option>");
        });
    }
}

function toggleMenuBar() {
    var oldMenuMode = $('body').hasClass('mini-sidebar') ? 'mini-sidebar' : 'big-sidebar';
    if ($('body').hasClass('big-sidebar')) {
        $('body').removeClass('big-sidebar').addClass('mini-sidebar');
        $('body').addClass('menu_squeeze');
        $('.template-menu').hide();
        $('.left-palen-submenu').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-right');
        $('.left-palen-submenu-items').hide();
        if (getHash() == 'tasks') {
            $(".view_tasks_menu").addClass('inner_ul_list');
        } else {
            $(".view_tasks_menu").removeClass('inner_ul_list');
        }
        $(".option_menu_panel,.logo_cmpnay_name_toggle").mouseout();
    } else {
        $('body').removeClass('mini-sidebar').addClass('big-sidebar');
        $('body').removeClass('menu_squeeze');
        if (getHash() == 'tasks') {
            $(".view_tasks_menu").addClass('inner_ul_list');
        } else {
            $(".view_tasks_menu").removeClass('inner_ul_list');
        }
    }
    $('.last_visited_projects').hide();
    $(".gly_mis.glyphicon").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-right");
    var menuMode = $('body').hasClass('mini-sidebar') ? 'mini-sidebar' : 'big-sidebar';
    if (menuMode == 'big-sidebar') {
        if ((CONTROLLER == "templates") || (CONTROLLER == "archives" && PAGE_NAME == "listall")) {
            $('.template-menu').show();
        }
        $('.last_visited_projects').show();
    } else {}
    localStorage.setItem('leftMenuView', menuMode);
    updateLeftMenuSize(oldMenuMode);
    $('#style_sidebar_mini').prop('checked', menuMode == "mini-sidebar" ? !0 : !1);
    theme_setting.saveSetting();
    setTimeout(function() {
        if (bxslid) {
            bxslid.destroySlider();
        }
        if (bxslid1) {
            bxslid1.destroySlider();
        }
        var window_kanban_slider = $('.kanban_top_slider').width() - 100;
        if (window_kanban_slider < 1300) {
            var dp_width = Math.round(window_kanban_slider / 4);
            bxslid = $('.kanban_top_slider .bxslider').bxSlider({
                slideWidth: dp_width,
                minSlides: 4,
                maxSlides: 4,
                moveSlides: 4,
                pager: false,
                slideMargin: 10,
                infiniteLoop: false,
                auto: false,
            });
        } else {
            var dp_width = Math.round(window_kanban_slider / 5);
            bxslid = $('.kanban_top_slider .bxslider').bxSlider({
                slideWidth: dp_width,
                minSlides: 5,
                maxSlides: 5,
                moveSlides: 5,
                pager: false,
                slideMargin: 10,
                infiniteLoop: false,
                auto: false,
            });
        }
        var window_kanban_slider1 = $('#kanban_list').width() - 100;
        if (window_kanban_slider1 < 1300) {
            var dp_width1 = Math.round(window_kanban_slider1 / 4);
            var bxslid1 = $('.kanban_top_slider .bxslider1').bxSlider({
                slideWidth: dp_width1,
                minSlides: 4,
                maxSlides: 4,
                moveSlides: 4,
                pager: false,
                slideMargin: 10,
                infiniteLoop: false,
                auto: false,
            });
        } else {
            var dp_width1 = Math.round(window_kanban_slider1 / 5);
            var bxslid1 = $('.kanban_top_slider .bxslider1').bxSlider({
                slideWidth: dp_width1,
                minSlides: 5,
                maxSlides: 5,
                moveSlides: 5,
                pager: false,
                slideMargin: 10,
                infiniteLoop: false,
                auto: false,
            });
        }
    }, 600);
    hasLeftScrollBar();
}

function updateLeftMenuSize(oldMenuMode) {
    var menuMode = oldMenuMode || '';
    if (localStorage.getItem('leftMenuView') != '' && menuMode != '' && menuMode != localStorage.getItem('leftMenuView')) {
        $.ajax({
            url: HTTP_ROOT + "requests/updateLeftMenuSize",
            data: {
                'menuMode': localStorage.getItem('leftMenuView')
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                return;
            }
        });
    }
}

function seachitems(obj) {
    var is_second = 0;
    if (arguments[1] !== undefined) {
        is_second = arguments[1];
    }
    val = $(obj).val().toUpperCase();
    if (is_second == 1) {
        $(obj).closest('ul').find('li').not("li.searchAssnLi").each(function() {
            if ($(this).find('a span').text().toUpperCase().indexOf(val) > -1 || $(this).find('a').text().toUpperCase().indexOf(val) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    } else {
        $(obj).closest('ul').find('li').not("li:first").each(function() {
            if ($(this).find('a span').text().toUpperCase().indexOf(val) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
}

function seachitemsTg(obj) {
    val = $(obj).val().toUpperCase();
    $(obj).closest('ul').find('li').not("li.searchLi").each(function() {
        if ($(this).find('a').text().toUpperCase().indexOf(val) > -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function seachitemsSts(obj) {
    val = $(obj).val().toUpperCase();
    $(obj).closest('ul').find('li').not("li.searchLi").each(function() {
        if ($(this).find('span').text().toUpperCase().indexOf(val) > -1) {
            $(this).show();
        } else {
            $(this).hide();
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
$.fn.ignore = function(sel) {
    return this.clone().find(sel || ">*").remove().end();
};

function showRecurringInfo(id) {
    openPopup();
    $("#recurring_info").show();
    $("#recurring_popupload1").show();
    $("#stoprecur").hide();
    $.post(HTTP_ROOT + 'requests/getRecurringTasks', {
        id: id
    }, function(res) {
        if (res[0] == false) {
            $("#recurring_popupload1").hide();
            $("#inner_recur_case").html("<table class='table table-striped'><tr><td>" + _('No upcoming due dates.') + "</td></tr></table>");
        } else {
            $("#recurring_popupload1").hide();
            $("#recur_title_heading").html(res[0].Easycase.title);
            if (typeof res[0].RecurringEasycase != 'undefined' && res[0].RecurringEasycase.length > 0) {
                $("#stoprecur").show();
                $("#stoprecur").attr('onclick', 'stopRecurring(' + res[0].RecurringEasycase[0].id + ',' + res[0].Easycase.id + ')');
            } else {
                $("#stoprecur").hide();
            }
            if (res[1].length > 0) {
                var str = "";
                str += "<table class='table table-striped'>";
                for (var i in res[1]) {
                    if (res[1].hasOwnProperty(i) && i < 5) {
                        str += "<tr>";
                        str += "<td>" + res[1][i] + "</td>";
                        str += "</tr>";
                    }
                }
                str += "</table>";
                $("#inner_recur_case").html(str);
            } else {
                $("#inner_recur_case").html("<table class='table table-striped'><tr><td>" + _('No upcoming due dates.') + "</td></tr></table>");
            }
        }
    }, 'json');
}

function stopRecurring(id, eid) {
    if (confirm(_("Are sure you want to stop the recurring task?"))) {
        $("#stoprecur").hide();
        $.post(HTTP_ROOT + 'requests/stopRecurringTasks', {
            id: id,
            eid: eid
        }, function(res) {
            if (res.status == 1) {
                closePopup();
                showTopErrSucc('success', _("Recurring task stopped successfully."));
            } else {
                $("#stoprecur").show();
                showTopErrSucc('error', _("Recurring Task cannot stop. Please try again later."));
            }
        }, 'json');
    }
}

function removeOnboard() {
    $('body').removeClass('hopscotch_bubble_body');
    return true;
    delete_cookie('FIRST_INVITE_1');
    if (typeof getCookie('FIRST_INVITE_2') != 'undefined') {
        delete_cookie('FIRST_INVITE_2');
        $('#new_task_label').trigger('click');
        $('body').removeClass('onboard_overlay');
        $(".onboardPop").hide();
    }
}

function nextOnboard(cls) {
    $(".onboardPop").hide();
    $("." + cls).show();
}

function openResourceNotAvailablePopup(CS_assign_to, CS_start_date, CS_due_date, est_hours, projId, caseid, caseUniqId, isAssignedFree, parenttaskId) {
    openPopup();
    showBeforeUnload = true;
    $('#inner_resource_notavailable').html('');
    if (isAssignedFree == 3) {
        $('#rsrc_not_avail_title').html(_('Resource on Leave'));
    } else {
        $('#rsrc_not_avail_title').html(_('Resource Not Available'));
    }
    $(".resource_notavailable").show();
    var not_available_ajax = HTTP_ROOT + 'logTimes/checkAvailableUsers';
    parenttaskId = typeof parenttaskId != "undefined" ? parenttaskId : '';
    $.post(not_available_ajax, {
        'assignedId': CS_assign_to,
        'gantt_start_date': CS_start_date,
        'CS_due_date': CS_due_date,
        'estimated_hours': est_hours,
        'project_id': projId,
        'caseid': caseid,
        'caseuniqid': caseUniqId,
        'parenttaskId': parenttaskId
    }, function(res) {
        if (res) {
            $('.loader_dv').hide();
            $('#inner_resource_notavailable').html(res);
        }
    });
}

function changeUnavailableResource() {
    showBeforeUnload = false;
    if ($('input[name=resource]').is(':checked')) {
        var $clickedOption = $('#inner_resource_notavailable').find('input:checked');
        var caseId = $clickedOption.attr('data-caseId');
        var caseUniqId = $clickedOption.attr('data-caseUniqId');
        var projectId = $clickedOption.attr('data-projectId');
        var assignTo = $clickedOption.attr('data-resource');
        var dtes = $clickedOption.attr('data-nxt-avail-date');
        var str_date = $clickedOption.attr('data-gantt-start-date');
        var est_hr = $clickedOption.attr('data-est-hour');
        var parenttaskId = $("#parenttaskId").val();
        $('#btn_tsk_avl').hide();
        $('#cust_loader_tsk_avl').show();
        var url = HTTP_ROOT + "logTimes/changeresource";
        $.post(url, {
            'caseId': caseId,
            'assignTo': assignTo,
            'start_date': dtes,
            'caseUniqId': caseUniqId,
            'projectId': projectId,
            'str_date': str_date,
            'est_hr': est_hr
        }, function(res) {
            if (res) {
                var hashtag = parseUrlHash(urlHash);
                closePopup();
                if (PAGE_NAME == 'resource_availability') {
                    if ($("#myModalDetail").hasClass('in')) {
                        getAll_projects_resource('');
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
                        }
                    } else {
                        window.location = HTTP_ROOT + 'resource-availability';
                    }
                }
                if (typeof easycase != 'undefined') {
                    if (hashtag[0] == 'activesprint' || hashtag[0] == 'backlog') {
                        window.location.reload();
                    } else if (hashtag[0] == 'details') {
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup', 'action');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup', 'action');
                        }
                    } else if ($("#myModalDetail").hasClass('in')) {
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
                        }
                    } else if ($('#create_another_task').length && $('#create_another_task').is(':checked') && $(".crt_tsk").is(':visible')) {
                        clearCreateTaskPopup();
                    } else {
                        easycase.refreshTaskList();
                    }
                } else {
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                }
            }
        });
    } else {
        alert(_("Please select an user to assign this task!"))
    }
}

function closeChangeResourcePopup() {
    showBeforeUnload = false;
    if ($('input[name=resource]').is(':checked')) {
        var caseId = $('#inner_resource_notavailable').find('#task_id').val();
        var caseUniqId = $('#inner_resource_notavailable').find('#task_uniq_id').val();
        var projectId = $('#inner_resource_notavailable').find('#task_project_id').val();
        var assignTo = $('#inner_resource_notavailable').find('#task_assigned_id').val();
        var str_date = $('#inner_resource_notavailable').find('#task_gantt_start_date').val();
        var CS_due_date = $('#inner_resource_notavailable').find('#task_due_date').val();
        var est_hr = $('#inner_resource_notavailable').find('#task_estimated_hr').val();
        var parenttaskId = $("#parenttaskId").val();
        $('#btn_tsk_avl').hide();
        $('#cust_loader_tsk_avl').show();
        var url = HTTP_ROOT + "logTimes/overloadUsers";
        $.post(url, {
            'caseId': caseId,
            'assignTo': assignTo,
            'caseUniqId': caseUniqId,
            'projectId': projectId,
            'str_date': str_date,
            'CS_due_date': CS_due_date,
            'est_hr': est_hr
        }, function(res) {
            if (res) {
                var hashtag = parseUrlHash(urlHash);
                closePopup();
                if (PAGE_NAME == 'resource_availability') {
                    if ($("#myModalDetail").hasClass('in')) {
                        getAll_projects_resource('');
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
                        }
                    } else {
                        window.location = HTTP_ROOT + 'resource-availability';
                    }
                }
                if (typeof easycase != 'undefined') {
                    if (hashtag[0] == 'activesprint' || hashtag[0] == 'backlog') {
                        window.location.reload();
                    } else if (hashtag[0] == 'details') {
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup', 'action');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
                        }
                    } else if ($("#myModalDetail").hasClass('in')) {
                        if (parenttaskId != "") {
                            easycase.ajaxCaseDetails(parenttaskId, 'case', 0, 'popup', 'action');
                        } else {
                            easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
                        }
                    } else if ($('#create_another_task').length && $('#create_another_task').is(':checked') && $(".crt_tsk").is(':visible')) {
                        clearCreateTaskPopup();
                    } else {
                        easycase.refreshTaskList();
                    }
                } else {
                    window.location = HTTP_ROOT + 'dashboard#tasks';
                }
            }
        });
    } else {
        alert(_("Please select an user to assign this task!"))
    }
}

function openResourceUpgrade() {
    openPopup();
    $(".resource_upgrade_popup").show();
    $(".resource_video_popup").hide();
}

function openResourceVideoPopup() {
    $(".resource_upgrade_popup").hide();
    $(".resource_video_popup").show();
}

function openTimesheetUpgrade() {
    openPopup();
    $(".timesheet_upgrade_popup").show();
}

function setStartDueDt() {
    if ($("#estimated_hours").val().trim() != "" && $("#estimated_hours").val().trim() != "0:00" && $("#estimated_hours").val().trim() != "00:00" && ($("#start_date").val() != "" || $("#start_date").val().trim() == 'Invalid date') && ($("#due_date").val().trim() == "" || $("#due_date").val().trim() == 'Invalid date')) {
        arr = $("#estimated_hours").val().split(":");
        tothr = parseInt(arr[0]);
        totday = Math.ceil(tothr / COMPANY_WORK_HOUR);
        var wdate = addWeekdays(moment($("#start_date").val()), totday - 1);
        $('#due_date').val(moment(wdate).format('MMM DD, YYYY'));
        $('#CS_due_date').val(moment(wdate).format('YYYY-MM-DD'));
    }
    if ($("#estimated_hours").val().trim() != "" && $("#estimated_hours").val().trim() != "0:00" && $("#estimated_hours").val().trim() != "00:00" && ($("#due_date").val() != "" || $("#due_date").val().trim() == 'Invalid date') && ($("#start_date").val().trim() == "" || $("#start_date").val().trim() == 'Invalid date')) {
        $('#start_date').val(moment().format('MMM DD, YYYY'));
        $("#CS_start_date").val(moment().format('YYYY-MM-DD'));
    }
    if (PAGE_NAME == 'resource_availability') {
        var dateText = $('#leave_date').val();
        if (dateText == '' || dateText == undefined) {
            var dateText = $('#leave_date_resourse').val();
        }
        if ($("#estimated_hours").val().trim() != "" && $("#estimated_hours").val().trim() != "0:00" && $("#estimated_hours").val().trim() != "00:00" && ($("#start_date").val() != "" || $("#start_date").val().trim() == 'Invalid date') && ($("#due_date").val().trim() == "" || $("#due_date").val().trim() == 'Invalid date')) {
            arr = $("#estimated_hours").val().split(":");
            tothr = parseInt(arr[0]);
            totday = Math.ceil(tothr / COMPANY_WORK_HOUR);
            var wdate = addWeekdays(moment($("#start_date").val()), totday - 1);
            $('#due_date').val(moment(wdate).format('MMM DD, YYYY'));
            $('#CS_due_date').val(moment(wdate).format('YYYY-MM-DD'));
        }
        if ($("#estimated_hours").val().trim() != "" && $("#estimated_hours").val().trim() != "0:00" && $("#estimated_hours").val().trim() != "00:00" && ($("#due_date").val() != "" || $("#due_date").val().trim() == 'Invalid date') && ($("#start_date").val().trim() == "" || $("#start_date").val().trim() == 'Invalid date')) {
            $('#start_date').val(moment().format('MMM DD, YYYY'));
            $("#CS_start_date").val(moment().format('YYYY-MM-DD'));
        }
    }
}

function addWeekdays(date, days) {
    date = moment(date);
    COMPANY_WEEK_ENDS = COMPANY_WEEK_ENDS.replace('0', '7');
    var array = COMPANY_WEEK_ENDS.split(",");
    var array1 = COMPANY_HOLIDAY.split(",");
    while (days > 0) {
        date = date.add(1, 'days');
        if (array.indexOf(date.isoWeekday().toString()) == -1 && array1.indexOf(date.format('YYYY-MM-DD').toString()) == -1) {
            days -= 1;
        }
    }
    return date;
}
$(document).ready(function() {
    if ($(".coupon-hello-bar").length > 0) {
        $(".onboard_indicate_popup").css({
            'top': "220px"
        });
        $(".onboard_indicate_popup_timelog").css({
            'top': "260px"
        });
        $(".onboard_indicate_popup_invoice").css({
            'top': "335px"
        });
    }
    window.onbeforeunload = function() {
        if ($(".availableTable").length >= 1 && $(".availableTable").is(':visible')) {
            return _("If you reload this page, your previous action will be repeated");
        }
    }
});

function removeUserOverview(obj) {
    var user_name = $(obj).attr('data-name');
        var project_id = $(obj).attr('data-pid');
        var userid = $(obj).attr('data-uid');
    if (confirm(_("Are you sure you want to remove") + " '" + user_name + "' " + _("from this project ?"))) {
        let user_arr = [userid];
        let param_data = {
            user_name,
            project_id,
            user_arr
        }
        $.ajax({
            url: `${HTTP_ROOT}projects/ajaxcheckUserTasks`,
            type: 'POST',
            dataType: 'json',
            data: param_data,
        }).done(function(res) {
            if (res.status) {
                var strURL = `${HTTP_ROOT}projects/removeUserOverview`;
        $.post(strURL, {
            "userid": userid,
            "project_id": project_id
        }, function(data) {
            if (data.status == 'ok') {
                $("#user_prof_" + userid).remove();
                $("#" + project_id + '_' + userid).remove();
                showTopErrSucc('success', _("Successfully removed") + " '" + user_name + "' " + _("from this project."));
            } else {
                showTopErrSucc('error', _("Failed to remove") + " '" + user_name + "'. " + _("Please try again!"));
            }
        }, 'json');
            } else {
                openPopup();
                $(".ass_task_user").show();
                $('#inner_usr_case_add').hide();
                $('#pop_up_assign_case_user_label').hide();
                $('.add-prj-btn').hide();
                $('#inner_usr_case_add').html('');
                $(".popup_bg").css({
                    "width": '850px'
                });
                $(".popup_form").css({
                    "margin-top": "6px"
                });
                $('#inner_usr_case_add').hide();
                $.ajax({
                    url: `${HTTP_ROOT}projects/ajaxGetProjUsers`,
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        param_data: param_data,
                        user_data: res,
                        page: "project_users"
                    },
                }).done(function(res_data) {
                    $(".loader_dv").hide();
                    $('#inner_usr_case_add').show();
                    $('#inner_usr_case_add').html(res_data);
                    $('#pop_up_assign_case_user_label').html('');
                    $('#pop_up_assign_case_user_label').html($('#hid_ext_use_lbl').html());
                    $('#pop_up_assign_case_user_label').css('display', 'block');
                    $('.add-prj-btn').show();
                    $.material.init();
                });
            }
        });
    }
}

function assigncases(el) {
    $("#casasusrloader").show();
    $("#confirmcasas").hide();
    var rem_page_src = $('#rem_page_src').val();
    var rem_obj_class = $('#rem_obj_class').val();
    var rem_users_array = $('#rem_mem_ids').val().split(',');
    var rem_userswn_array = $('#rem_mem_id_wn').val().split(',');
    var project_id = $('#rem_src_pjid').val();
    var sel_user = document.querySelector('input[name="data[AssignUser][value]"]:checked').value;
    if (rem_users_array.length == 1) {
        if (rem_page_src && rem_page_src == "manage") {
            let obj_el = $('.' + rem_obj_class).find('a');
            let proj_id = $(obj_el).attr('data-prj-id');
            let proj_uid = $(obj_el).attr('data-prj-uid');
            let user_ids = $(obj_el).attr('data-prj-usr');
            let pname = $(obj_el).attr('data-prj-name');
            let obj_t = obj_el;
            let loc = HTTP_ROOT + "projects/assignRemovMeToProject/";
            $.post(loc, {
                'user_ids': user_ids,
                'project_id': proj_id,
                'typ': 'rm',
                "assign_to_user": sel_user
            }, function(res) {
                $("#casasusrloader").hide();
                $("#confirmcasas").show();
                if (res.status == 'nf') {
                    showTopErrSucc('error', _('Failed to assign user to the project.'));
                } else {
                    if (trim(res.message) != '') {
                        closePopup();
                        showTopErrSucc('success', res.message);
                        $('.assgnremoveme' + proj_uid).html('<a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="' + proj_uid + '" data-prj-id="' + proj_id + '" data-prj-name="' + pname + '" data-prj-usr="' + res.ses_id + '" onclick="assignMeToPrj(this);"><i class="material-icons">&#xE147;</i> ' + _("Add me here") + '</a>');
                    }
                }
            }, 'json');
        } else if (rem_page_src && rem_page_src == "manage_as_users") {
            $.ajax({
                url: `${HTTP_ROOT}projects/assignLeftCases`,
                type: 'POST',
                dataType: 'json',
                data: {
                    rem_users_array: $('#rem_mem_ids').val(),
                    rem_userswn_array: $('#rem_mem_id_wn').val(),
                    project_id: project_id,
                    assign_to_user: sel_user,
                },
            }).done(function(res) {
                $("#casasusrloader").hide();
                $("#confirmcasas").show();
                if (res.status) {
                    closePopup();
                    showTopErrSucc('success', res.msg);
                    setTimeout(function() {
                        var sequency = ["project_users"];
                        if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                            window.location.reload();
                        } else {
                            loadSeqDashboardAjax(sequency, res.uniq_id, 'overview');
                        }
                    }, 1000);
                } else {
                    showTopErrSucc('error', res.msg);
                }
            });
        } else {
            var strURL = `${HTTP_ROOT}projects/removeUserOverview`;
            $.post(strURL, {
                "userid": rem_users_array[0],
                "project_id": project_id,
                "assign_to_user": sel_user
            }, function(data) {
                if (data.status == 'ok') {
                    let user_name = rem_userswn_array[0].split('@@@');
                    user_name = user_name[1];
                    $("#casasusrloader").hide();
                    $("#confirmcasas").show();
                    $("#user_prof_" + data.user_id).remove();
                    $("#" + data.proj_id + '_' + data.user_id).remove();
                    closePopup();
                    showTopErrSucc('success', _("Successfully removed") + " '" + user_name + "' " + _("from this project."));
                    if (rem_page_src && "project_users" == rem_page_src) {
                        var sequency = ["project_users"];
                        loadSeqDashboardAjax(sequency, data.proj_id, "overview")
                    }
                } else {
                    showTopErrSucc('error', _("Failed to remove") + " '" + user_name + "'. " + _("Please try again!"));
                }
            }, 'json');
        }
    } else {
        $.ajax({
            url: `${HTTP_ROOT}projects/assignLeftCases`,
            type: 'POST',
            dataType: 'json',
            data: {
                rem_users_array: $('#rem_mem_ids').val(),
                rem_userswn_array: $('#rem_mem_id_wn').val(),
                project_id: project_id,
                assign_to_user: sel_user,
            },
        }).done(function(res) {
            $("#casasusrloader").hide();
            $("#confirmcasas").show();
            if (res.status) {
                closePopup();
                showTopErrSucc('success', res.msg);
                if (rem_page_src && rem_page_src == "manage_as_users") {
                    setTimeout(function() {
                        var sequency = ["project_users"];
                        if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                            window.location.reload();
                        } else {
                            loadSeqDashboardAjax(sequency, res.uniq_id, 'overview');
                        }
                    }, 1000);
                }
            } else {
                showTopErrSucc('error', res.msg);
            }
        });
    }
}

function showTaskSubMenu() {}

function showOtherSubMenu() {}

function searchTaskTypeDetail(obj) {
    var srch_txt = trim($(obj).val());
    if (trim(srch_txt) != '') {
        $(obj).closest('ul').find('li').each(function() {
            res = $(this).find('a span').clone().children().remove().end().text();
            if (trim(res.toLowerCase()) != 'nobody' && trim(res.toLowerCase()).indexOf(srch_txt.toLowerCase()) < 0) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    } else {
        $(obj).closest('ul').find('li').each(function() {
            $(this).show();
        });
    }
}

function toggleRecentVisitedProjects() {
    if ($('#recent_visted_projects_dvblk').length) {
        $('#recent_visted_projects_dvblk, .recent_visited_projects').toggle();
    } else {
        $('.recent_visited_projects').slideDown("slow");
    }
}

function setStarVal(v) {
    $(".star").find(".material-icons").removeClass('active');
    for (var i = 1; i <= 5; i++) {
        if (i <= v) {
            $(".str_" + i).addClass('active');
        }
    }
    $("#feedback_star").val(v);
}

function saveFeedbackData() {
    var star = $("#feedback_star").val();
    var message = $("#feedback_textarea").val().trim();
    var htmltag = /<\/?[^>]+>/gi;
    if (htmltag.test(message)) {
        showTopErrSucc('error', _("HTML/script tags are not allowed"));
        return false;
    }
    var url = window.location.href;
    if (message == "") {
        showTopErrSucc('error', _("Please enter feedback"));
        $("#feedback_textarea").focus();
        return false;
    }
    $.post(HTTP_ROOT + "users/saveUserFeedback", {
        message: message,
        star: star,
        url: url
    }, function(res) {
        if (res.msg != 'error') {
            showTopErrSucc('success', _('Feedback posted successfully.'));
            // $('#feeback_modal').modal('hide');
            clearFeedbackData();
            closePopup();
        } else {
            showTopErrSucc('error', _("Oops! Some thing went wrong. Please try again later"));
            return false;
        }
    }, 'json');
}

function clearFeedbackData() {
    $("#feedback_star").val('');
    $("#feedback_textarea").val('');
    $(".star").find(".material-icons").removeClass('active');
}

function enableFeedbackBTN() {
    return true;
}

function initializeShorting() {
    var ignoreTr = '.white_bg_tr,.quicktskgrp_tr,.quicktskgrp_tr,.quicktskgrp_tr_lnk,thead > tr';
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
                        $.post(HTTP_ROOT + 'milestones/switchTaskToMilestone', {
                            'taskid': tr_id.split('w')[1],
                            'curr_mlst_id': n_mlstn_id,
                            'project_id': project_id,
                            'ext_mlst_id': p_mlstn_id
                        }, function(res3) {
                            if (res3.status == 'success') {
                                showTopErrSucc('success', _('Task moved successfully.'));
                            } else {
                                showTopErrSucc('error', _('Error in moving task to task group'));
                            }
                            update_sequence(caseIds, n_mlstn_id, project_id);
                        }, 'json');
                    }
                } else {
                    update_sequence(caseIds, n_mlstn_id, project_id);
                }
            }
        }
    });
}

function initializeKanban() {
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
    var settings = {
        autoReinitialise: true
    };
    $(".kanban-child .kbtask_div").on("hover", function(obj) {
        var curindex = $(this).parent().children().index(this);
        if (($(this).is(":last-child") || $(this).is(":nth-last-child(3)") || $(this).is(":nth-last-child(2)")) && (parseInt(curindex) >= 3) && ($(this).parents(".jspPane").height() > 400)) {
            $(this).find('.dropdown').on('click', function(cobj) {
                var hite = $(this).find('.dropdown-menu').height();
                var popup_ht = parseInt(hite) + 12;
                $(this).find(".dropdown-menu").css({
                    top: "-" + popup_ht + "px"
                });
                $(this).find(".pop_arrow_new").css({
                    marginTop: hite + "px",
                    background: "url('" + HTTP_ROOT + "img/arrow_dwn.png') no-repeat"
                });
            });
        }
    });
    $(".kanban_content").sortable({
        cursor: 'grabbing',
        connectWith: '.kanban_content',
        scroll: true,
        scrollSensitivity: 100,
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

function closePopupCaseDetails() {
    $('#myModalDetail').modal('hide');
}

function extraCouponPop() {
    openPopup();
    $(".new_extracoupon").show();
}

function referAFriend() {
    $('.ref_p_error').text('');
    $('#loader_refaf').show();
    var url = HTTP_ROOT + 'users/generaterefurl';
    $.post(url, {
        'user_id': ''
    }, function(res) {
        if (res) {
            $('#refUrl').val(HTTP_HOME + '?u_ref=' + res.refcode);
            var shr_url = HTTP_HOME + '?u_ref=' + res.refcode;
            var share = '<a onclick="window.open(\'http://www.facebook.com/sharer.php?u=' + shr_url + '&t=I have been using Orangescrum and it is a Simple and Affordable Project management Tool For All. I am sure you will love it! Start a trial and get a coupon for $30 off your first transaction.\', \'_blank\', \'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" class="facebook" title="Facebook">f</a><a onclick="window.open(\'https://twitter.com/intent/tweet?url=' + shr_url + '&text=I have been using Orangescrum and it is a Simple and Affordable Project management Tool For All. I  am sure you will love it! Start a trial and get a coupon for $30 off your first transaction.\', \'_blank\', \'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" class="twitter" title="Twitter">t</a> <a onclick="window.open(\'http://www.linkedin.com/shareArticle?mini=true&url=' + shr_url + '&title=I have been using Orangescrum and it is a Simple and Affordable Project management Tool For All. I am sure you will love it! Start a trial and get a coupon for $30 off your first transaction.\', \'_blank\', \'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" class="linkdin" title="Linkdin">in</a><a onclick="window.open(\'https://plus.google.com/share?url=' + shr_url + '\', \'_blank\', \'location=yes,height=570,width=520,scrollbars=yes,status=yes\');" class="g_plus" title="Google+">g+</a><a href="mailto:" class="g_mail" title="Mail"><i style="font-size: 14px;color: #fff;" class="material-icons">&#xE0BE;</i></a>';
            $('.ref_social_share').html(share);
            $('#loader_refaf').hide();
            $('#own_earned').text('$' + res.ref_data.erned);
            $('#earned_redeem').text('-$' + res.ref_data.redeemed);
            $('#earned_remain').text('$' + res.ref_data.remain);
            $('#frnd_earned').text(res.ref_data.frndConverted);
            if (res.ref_data.frnds.length) {
                $('.show_hide_ern_empty').hide();
                $('.show_hide_ern_frnd').show();
                var reslist = '';
                for (i in res.ref_data.frnds) {
                    reslist += '<tr><td style="align:left;">' + res.ref_data.frnds[i].name + ' ' + res.ref_data.frnds[i].last_name + '</td><td style="align:left;">' + res.ref_data.frnds[i].email + '</td>';
                    reslist += '<td>$' + res.ref_data.frnds[i].amount;
                    if (res.ref_data.frnds[i].is_expired) {
                        reslist += '<i title="Coupon Expired" class="material-icons refr_icon_exp">&#xE5CD;</i>';
                    } else if (res.ref_data.frnds[i].is_redeemed) {
                        reslist += '<i title="Coupon Redeemed" class="material-icons refr_icon_succ">&#xE876;</i>';
                    } else {
                        reslist += ' <a style="display: inline;padding: 4px 14px;" href="javascript:void(0)" id="btn-redeem' + res.ref_data.frnds[i].cuid + '" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"  onclick=" redeemCoupon(\'' + res.ref_data.frnds[i].cuid + '\',\'' + res.ref_data.frnds[i].uniq_id + '\');" title="Redeem Coupon"><i style="font-size:15px;" class="material-icons">&#xE8B1;</i></a>';
                    }
                    reslist += '</td></tr>';
                }
                $('#ref_friends').html(reslist);
            }
        }
    }, 'json');
    openPopup();
    $(".new_referafriend").show();
    $(".loader_dv").hide();
    $('#loader_refaf').hide();
}

function redeemCoupon(uid, user_id) {
    $('#confirm_rdm_box').hide();
    $('.ref_p_error').text('').hide();
    $('.loader_dv_ref').show();
    $('#btn-redeem' + uid).hide();
    var url = HTTP_ROOT + 'users/redeemRferal';
    $.post(url, {
        'uniq_id': uid,
        'u_uid': user_id
    }, function(res) {
        if (res.status == 'success') {
            $('#confirm_rdm_box').show();
            $('.loader_dv_ref').hide();
            $('#btn-redeem' + uid).show();
            $('#same_plan_rdm').html('<a href="' + HTTP_ROOT + 'users/upgrade_member/redeem/' + uid + '/' + user_id + '">Do you want to continue with the current plan?</a>');
        } else {
            if (res.msg == 'free') {
                window.location.href = HTTP_ROOT + 'users/pricing';
            } else {
                $('.ref_p_error').show().text(res.msg);
                $('.loader_dv_ref').hide();
                $('#btn-redeem' + uid).show();
                setTimeout(function() {
                    $(".ref_p_error").hide().text('');
                }, 5000);
            }
        }
    }, 'json');
}

function subTask(task_id, case_no, proj_id) {
    creatask();
    new_subtask_parent_id = task_id;
}

function openHelpWindow(url) {
    var height = 530;
    var width = 1000;
    var left = ($(window).width() / 2) - (width / 2);
    var top = ($(window).height() / 2) - (height / 2);
    window.open(url, '', 'height=' + height + ',width=' + width + ', top=' + top + ', left=' + left);
}

function formatTaskType(tt) {
    if (!tt.id) {
        return tt.text;
    }
    var $state = $('<span class="ttype_global tt_' + tt.text.toLowerCase().split(' ').join('-') + '">' + tt.text + '</span>');
    return $state;
}

function formatUserRole(tt) {
    if (!tt.id) {
        return tt.text;
    }
    if (!tt.element.dataset.role) {
        return tt.text;
    }
    var $state = $('<div class="pr"><span class="urol-txt">' + tt.text + '</span><span class="project_role_txt urol ' + tt.element.dataset.role.toLowerCase() + '">' + tt.element.dataset.role + '</span></div>');
    return $state;
}

function formatParentTask(tt) {
    if (!tt.id) {
        return tt.text;
    }
    var ptext = tt.text;
    if (ptext.match('-sub-')) {
        ptext = ptext.split('-sub-');
        var $state = $('<span><i style="font-size: 12px;" class="material-icons sub_task_icon">&#xE23E;</i> ' + ptext[1].trim() + '</span>');
        return $state;
    } else {
        return tt.text;
    }
}

function getttformats(v) {
    if (typeof v != 'undefined' && v != null) {
        return v.toLowerCase().split(' ').join('-');
    } else {
        return v;
    }
}
function addLinkPopup(project_uniq_id, task_id, proj_id) {
    openPopup();
    $(".popup_add_new_link").show();
    $(".popup-relates-select").select2();
    $(".popup-link-to-select").select2();
    $(".popup-link-to-select").val('').trigger('change');
    $("#popup_plnk_id").val(task_id);
    $("#popup_prj_id").val(proj_id);
    $("#popup_prj_un_id").val(project_uniq_id);
    $(".popup-link-to-select").select2({
        width: '100%',
        allowClear: true,
        ajax: {
            url: HTTP_ROOT + 'requests/getNewLinkTasks',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    'searchTerm': params.term,
                    'project_id': project_uniq_id,
                    'task_id': task_id
                }
            },
            processResults: function(data) {
                if (data.status) {
                    return {
                        results: $.map(data.task, function(obj) {
                            return {
                                id: (obj.id),
                                text: (obj.text)
                            };
                        })
                    };
                } else {
                    return _("No data found");
                }
            },
            cache: true
        },
    });
}

function addSubtaskPopup(project_uniq_id, task_id, proj_id, casuid, title) {
    openPopup();
    $(".popup_add_new_subtask").show();
    if (title == 'Title') {
        $("#parent_task_title").text('#' + $('#case_ttl_edit_' + casuid).attr('data-caseno') + ': ' + $('#temp_title_holder_' + casuid).text());
    } else {
        $("#parent_task_title").text(title);
    }
    $("#popup_plnk_id_sub").val(task_id);
    $("#CS_title_pop").val('');
    $("#popup_prj_id_sub").val(proj_id);
    $("#popup_prj_un_id_sub").val(project_uniq_id);
    $("#popup_caseuiid_sub").val(casuid);
    $(".subcrtskasgnusr").val('');
    $(".subtsktyp-select").val('');
    $("#sub_start_date").val('');
    $("#sub_due_date").val('');
    $("#CS_sub_start_date").val('');
    $("#sub_estimated_hours").val('');
    $("#CS_sub_due_date").val('');
    $('.subcrtskasgnusr').html('');
    var url = HTTP_ROOT + "easycases/ajax_quickcase_mem";
    $.post(url, {
        "projUniq": project_uniq_id,
        "pageload": 0
    }, function(data) {
        if (data) {
            var sub_PUSERS = data.quickMem;
            var sub_defaultAssign = data.defaultAssign;
            var sub_defaultTskTyp = data.defaultTaskType;
            var sub_dassign = data.dassign;
            if (countJS(sub_PUSERS)) {
                var UserClients = '';
                var dassignArr = Array();
                if (sub_dassign) {
                    for (ui in sub_dassign) {
                        dassignArr.push(sub_dassign[ui]);
                    }
                }
                for (ipusr in sub_PUSERS) {
                    for (ipusr1 in sub_PUSERS[ipusr]) {
                        if (typeof sub_PUSERS[ipusr] != 'function') {
                            var pusr = sub_PUSERS[ipusr][ipusr1];
                            if (typeof pusr != 'function') {
                                if (!pusr.User.name) {
                                    var i = pusr.User.email.indexOf("@");
                                    if (pusr.User.email.indexOf("@") != -1) {
                                        pusr.User.name = pusr.User.email.substring(0, i);
                                    }
                                }
                                if (SES_ID == pusr.User.id) {
                                    $('.subcrtskasgnusr').append("<option value='" + pusr.User.id + "'>" + _('me') + "</option>");
                                } else {
                                    $('.subcrtskasgnusr').append("<option value='" + pusr.User.id + "'>" + ucfirst(pusr.User.name) + "</option>");
                                }
                            }
                        }
                    }
                }
                $('.subcrtskasgnusr').append("<option value='0'>" + _('Nobody') + "</option>");
                $('.holder').children('li').remove();
                $('.holder').remove();
                var prjuid = $('#curr_active_project').val();
            } else {
                $('.subcrtskasgnusr').append("<option value='" + SES_ID + "'>" + _('me') + "</option>");
            }
        }
    });
    $('.subcrtskasgnusr').select2();
    $('.subtsktyp-select').select2();
    $('.subtsktyp-select').html('');
    $.each(GLOBALS_TYPE, function(key, value) {
        if (value.Type.project_id == 0 || value.Type.project_id == proj_id) {
                $('.subtsktyp-select').append('<option value="' + value.Type.id + '">' + value.Type.name + '</option>');
            }
    });
    $('.subtsktyp-select').change();
    if (SES_TYPE == 3) {
        $(".subtsktyp-select").select2({
            templateSelection: formatTaskType,
            templateResult: formatTaskType
        });
    } else {
        $(".subtsktyp-select").select2({
            tags: true,
            templateSelection: formatTaskType,
            templateResult: formatTaskType,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                if (term.match(/[$-/:-?{-~!"^_`\[\]<>#]+/)) {
                    var msg = "'Name' must not contain Special characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).off('select2:select').on('select2:select', function(evt) {
            if (evt.params.data.newTag == true) {
                var name = evt.params.data.id;
                $('#caseLoader').show();
                $.post(HTTP_ROOT + 'projects/validateTaskTypeFromCreateTask', {
                    'name': evt.params.data.id,
                    'project_uid': project_uniq_id
                }, function(res) {
                    $('#caseLoader').hide();
                    if (res.status == 'error' && res.msg == 'name') {
                        showTopErrSucc('error', 'Name already esists!. Please enter another name.');
                        $('.subtsktyp-select option[value="' + name + '"]').remove();
                        $('.subtsktyp-select').trigger('change');
                    } else if (res.status == 'success') {
                        if (res.msg == 'saved') {
                            showTopErrSucc('success', 'Task Type Successfully Added');
                            $(".subtsktyp-select").append("<option value='" + res.id + "' selected>" + name + "</option>");
                            $('.subtsktyp-select option[value="' + res.id + '"]').prop('selected', true);
                            $('.subtsktyp-select').trigger('change');
                        } else {
                            showTopErrSucc('error', _('Task Type can not be added'));
                            $('.subtsktyp-select').trigger('change');
                        }
                    }
                }, 'json');
            }
        });
    }
    $("#sub_start_date,#sub_due_date").datepicker({
        format: 'M d, yyyy',
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        autoclose: true,
        clearBtn: true
    }).on("changeDate", function(ev) {
        if ($(ev.target).attr('id') == 'sub_start_date') {
            var dateText = $("#sub_start_date").datepicker('getFormattedDate');
            if (dateText != 'Invalid date') {
                $("#CS_sub_start_date").val(moment(dateText).format('YYYY-MM-DD'));
                $("#sub_due_date").datepicker("setStartDate", dateText);
            }
        } else {
            var dateText = $("#sub_due_date").datepicker('getFormattedDate');
            if (dateText != 'Invalid date') {
                $("#CS_sub_due_date").val(moment(dateText).format('YYYY-MM-DD'));
                $("#sub_start_date").datepicker("setEndDate", dateText);
            }
        }
    }).on("hide", function(ev) {
        if ($(ev.target).attr('id') == 'sub_start_date') {
            if ($('#sub_start_date').val() == '') {
                if (moment($('#CS_sub_start_date').val()).format('MMM DD, YYYY') != 'Invalid date') {
                    $('#sub_start_date').val(moment($('#CS_sub_start_date').val()).format('MMM DD, YYYY'));
                }
            }
        } else {
            if ($('#sub_due_date').val() == '') {
                if (moment($('#CS_sub_due_date').val()).format('MMM DD, YYYY') != 'Invalid date') {
                    $('#sub_due_date').val(moment($('#CS_sub_due_date').val()).format('MMM DD, YYYY'));
                }
            }
        }
    });
    if ($('#CS_sub_due_date').val() != '') {
        $("#sub_start_date").datepicker("setEndDate", $("#sub_due_date").datepicker('getFormattedDate'));
    }
}

function saveSubPop() {
    var relatesID = $("#popup_plnk_id_sub").val();
    var title = $('#CS_title_pop').val();
    var projID = $('#popup_prj_id_sub').val();
    var projUID = $('#popup_prj_un_id_sub').val();
    var csUID = $("#popup_caseuiid_sub").val();
    var est_hour = $("#sub_estimated_hours").val();
    var start_date = $("#CS_sub_start_date").val();
    var due_date = $("#CS_sub_due_date").val();
    var assign_to = $(".subcrtskasgnusr").val();
    var task_types = $(".subtsktyp-select").val();
    var emailUser = Array();
    emailUser.push(assign_to);
    if (!relatesID) {
        showTopErrSucc('error', _("Please select a parent task."));
        return false;
    }
    if (!title) {
        showTopErrSucc('error', _("Task title can not be left blank."));
        return false;
    }
    $("#addsubtaskder").show();
    $("#addsubpop_btn").hide();
    $.post(HTTP_ROOT + 'requests/saveParentTask', {
        'CS_parent_id': relatesID,
        'title': title,
        'project_id': projID,
        'projUID': projUID,
        'csUID': csUID,
        'est_hour': est_hour,
        'start_date': start_date,
        'due_date': due_date,
        'assign_to': assign_to,
        'task_types': task_types
    }, function(resdat) {
        $("#addsubtaskder").hide();
        $("#addsubpop_btn").show();
        if (resdat.success) {
            if (resdat.curCaseNo) {
                var strURL = HTTP_ROOT + "easycases/";
                var url_ajax = strURL + "ajaxemail";
                $.post(url_ajax, {
                    'projId': resdat.taskCreatedDetails.projId,
                    'emailUser': emailUser,
                    "allfiles": resdat.taskCreatedDetails.allfiles,
                    'caseNo': resdat.curCaseNo,
                    'emailTitle': resdat.taskCreatedDetails.emailTitle,
                    'emailMsg': resdat.taskCreatedDetails.emailMsg,
                    'casePriority': resdat.taskCreatedDetails.casePriority,
                    'caseTypeId': resdat.taskCreatedDetails.caseTypeId,
                    'msg': resdat.taskCreatedDetails.msg,
                    'emailbody': resdat.taskCreatedDetails.emailbody,
                    'caseIstype': resdat.taskCreatedDetails.caseIstype,
                    'csType': resdat.taskCreatedDetails.csType,
                    'caUid': resdat.taskCreatedDetails.caUid,
                    'caseid': resdat.taskCreatedDetails.caseid,
                    'caseUniqId': resdat.taskCreatedDetails.caseUniqId,
                    'is_client': '',
                });
            }
            var str = getHash();
            var pos = str.search("details/");
            if (PAGE_NAME == "resource_availability") {} else if (str == "taskgroups") {
                showTaskByTaskGroupNew();
            } else {
                if (pos < 0) {
                    reloadTasks();
                }
            }
            $(".displayOnlyForBackLog .task_detail_head").show();
            refreshTasks = 1;
            showTopErrSucc('success', _("Subtask added successfully."));
            $("#case_subtask_task" + resdat.csUniqId).html(tmpl("case_subtasks_tmpl", resdat));
            if ($("#case_subtask_task" + resdat.csUniqId).length) {
                $("#case_subtask_task" + resdat.csUniqId).html('');
                $("#case_subtask_task" + resdat.csUniqId).html(tmpl("case_subtasks_tmpl", resdat));
            }
            if ($("#case_subtask_task_dtl" + resdat.csUniqId).length) {
                $("#case_subtask_task_dtl" + resdat.csUniqId).html('');
                $("#case_subtask_task_dtl" + resdat.csUniqId).html(tmpl("case_subtasks_tmpl", resdat));
            }
            if (resdat.isAssignedUserFree != 1 && resdat.isAssignedUserFree != null) {
                var CS_start_date = start_date;
                var CS_due_date = due_date;
                var est_hours = (typeof resdat.taskCreatedDetails.estimated_hours != 'undefined') ? resdat.taskCreatedDetails.estimated_hours : est_hour;
                var caseid = resdat.taskCreatedDetails.caseid;
                var caseUniqId = resdat.taskCreatedDetails.caseUniqId;
                openResourceNotAvailablePopup(assign_to, CS_start_date, CS_due_date, est_hours, resdat.taskCreatedDetails.projId, caseid, caseUniqId, resdat.isAssignedUserFree, resdat.csUniqId);
            } else {
                closePopup();
            }
            if (getHash() == 'kanban') {
                tasklisttmplAdd(resdat.curCaseId, 0, 'sts');
            }
        } else {
            showTopErrSucc('error', "Oops! We are experiencing some issue in our database to store the Subtask. We will be back shortly.");
        }
        $('.detail_page_subtask').show();
    }, 'json');
}

function setSubStartDueDt() {
    if ($("#sub_estimated_hours").val().trim() != "" && $("#sub_estimated_hours").val().trim() != "0:00" && $("#sub_estimated_hours").val().trim() != "00:00" && ($("#sub_start_date").val() != "" || $("#sub_start_date").val().trim() == 'Invalid date') && ($("#sub_due_date").val().trim() == "" || $("#sub_due_date").val().trim() == 'Invalid date')) {
        arr = $("#sub_estimated_hours").val().split(":");
        tothr = parseInt(arr[0]);
        totday = Math.ceil(tothr / COMPANY_WORK_HOUR);
        var wdate = addWeekdays(moment($("#sub_start_date").val()), totday - 1);
        $('#sub_due_date').val(moment(wdate).format('MMM DD, YYYY'));
        $('#CS_sub_due_date').val(moment(wdate).format('YYYY-MM-DD'));
    }
    if ($("#sub_estimated_hours").val().trim() != "" && $("#sub_estimated_hours").val().trim() != "0:00" && $("#sub_estimated_hours").val().trim() != "00:00" && ($("#sub_due_date").val() != "" || $("#sub_due_date").val().trim() == 'Invalid date') && ($("#sub_start_date").val().trim() == "" || $("#sub_start_date").val().trim() == 'Invalid date')) {
        $('#sub_start_date').val(moment().format('MMM DD, YYYY'));
        $("#CS_sub_start_date").val(moment().format('YYYY-MM-DD'));
    }
}

function loadSubtaskInDetail(relatesID) {
    $('#tab-subTask').trigger('click');
}

function linkActiononTask(taskid, taskUid, taskNum, actiontype, legend, projUniq, parent_task, projID) {
    $.post(HTTP_ROOT + 'easycases/taskactions', {
        'taskId': taskid,
        'taskUid': taskUid,
        'type': actiontype,
        'legend': legend,
        'link_task': 1,
        'projUniq': projUniq,
        'projID': projID,
        'parent_task': parent_task
    }, function(res) {
        if (res.link_tasks) {
            showTopErrSucc('success', _("Status changed successfully") + ".");
            $("#case_link_task" + parent_task).html(tmpl("fetchAllLinkedTskTmpl", res));
            if ($('#tab-subTask').hasClass('active')) {
                $('#tab-subTask').trigger('click');
            }
        } else if (res.err) {
            if (res.msg) {
                showTopErrSucc('error', res.msg);
            }
        }
    }, 'json');
}

function addLabel(taskId, projId, task_uniqid, projUniqId, type) {
    openPopup();
    $('#newtasklabel_btn').text(_('Add'));
    $('#task_type_title').text(_('New Label'));
    if (SES_TYPE == 3) {
        $(".popup-label-to-select").select2({
            tags: true,
            createTag: function(params) {
                return undefined;
            }
        });
    } else {
        $(".popup-label-to-select").select2({
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                if (term.match(/[/:-?{~"^`'\[\]<>]+/)) {
                    var msg = "'Label' must not contain Special characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                if (term.length > 30) {
                    var msg = "Label must not exceed 20 characters!";
                    showTopErrSucc('error', msg);
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).off('select2:select').on('select2:select', function(evt) {
            if (evt.params.data.newTag == true) {
                var name = evt.params.data.id;
                $('#caseLoader').show();
                $('.new_tasklabel').find('#savlnk').addClass('loginactive');
                $.post(HTTP_ROOT + 'projects/validateTaskLabelFromCreateTask', {
                    'name': evt.params.data.id,
                    'project_id': projId
                }, function(res) {
                    $('#caseLoader').hide();
                    $('.new_tasklabel').find('#savlnk').removeClass('loginactive');
                    if (res.status == 'error' && res.msg == 'name') {
                        showTopErrSucc('error', _('Label already added. Please add another label.'));
                        $('.popup-label-to-select option[value="' + name + '"]').remove();
                        $('.popup-label-to-select').trigger('change');
                    } else if (res.status == 'success') {
                        if (res.msg == 'saved') {
                            $(".popup-label-to-select").find('option[value="' + name + '"]').remove();
                            $(".popup-label-to-select").append("<option value='" + res.id + "' selected>" + name + "</option>");
                            $('.popup-label-to-select option[value="' + res.id + '"]').prop('selected', true);
                            $('.popup-label-to-select').trigger('change');
                        } else {
                            showTopErrSucc('error', _('Task Label can not be added'));
                            $('.popup-label-to-select option[value="' + name + '"]').remove();
                            $('.popup-label-to-select').trigger('change');
                        }
                    }
                }, 'json');
            }
        });
    }
    $(".popup-label-to-select").val('').trigger('change');
    $.post(HTTP_ROOT + 'requests/getNewLabelTasks', {
        'project_id': projUniqId,
        'task_id': taskId
    }, function(resdat) {
        if (resdat.status) {
            $('.popup-label-to-select option').remove();
            $.each(resdat.labels, function(key, value) {
                if ((typeof resdat.prefilLabel != 'undefined' && resdat.prefilLabel.indexOf(key) != -1)) {
                    $('.popup-label-to-select').append('<option value="' + key + '" selected>' + ucfirst(formatText(value)) + '</option>');
                } else {
                    $('.popup-label-to-select').append('<option value="' + key + '">' + ucfirst(formatText(value)) + '</option>');
                }
            });
        }
        $(".popup-label-to-select").select2('focus');
    }, 'json');
    $(".new_tasklabel").show();
    $(".loader_dv").hide();
    $('#inner_tasklabel').show();
    $("#new-tasklabelid").val(taskId);
    $("#new-taskprojid").val(projId);
    $("#new-taskuniqid").val(task_uniqid);
    $("#new-taskprojuid").val(projUniqId);
    $("#new-labeltype").val(type);
    $.material.init();
    $("#newtasklabel_btn").removeClass('loginactive');
}

function addEditSprint(mileuniqid) {
    var projUid = $('#projFil').val();
    openPopup();
    $(".sprint_add_edit").show();
    $('#id_sprint').val('');
    $('#title_sprint').val('');
    $('#description_sprint').val('');
    $("#addeditSprnt").hide();
    if (mileuniqid != '') {
        $("#addeditSprnt").show();
    }
    $('#proj_id_sprint').val(projUid);
    $('textarea').autoGrow().keyup();
    $('#btn-add-new-sprint').html(_('Create'));
    $('#header_sprint').html(_('Create Sprint'));
    if (mileuniqid != '') {
        $('#header_sprint').html(_('Edit Sprint'));
        $.post(HTTP_ROOT + "milestones/ajax_new_sprint", {
            'mileuniqid': mileuniqid,
            'projUid': projUid
        }, function(res) {
            if (res) {
                $("#addeditSprnt").hide();
                $('#id_sprint').val(res.Milestone.id);
                $('#title_sprint').val(res.Milestone.title);
                $('#description_sprint').val(res.Milestone.description);
                $('#btn-add-new-sprint').html(_('Update'));
                $.material.init();
                $('textarea').autoGrow().keyup();
            }
        }, 'json');
    }
}

function moveSprintUpDown(type, obj, tb_id) {
    var projUid = $('#projFil').val();
    var ida = '';
    var idb = '';
    if (type == 1) {
        var btna = $('#tobody_' + tb_id).find('button.start_sprnt').is(':disabled');
        var btnb = $('#' + $('#tobody_' + tb_id).prev('tbody.ui-sortable').attr('id')).find('button.start_sprnt').is(':disabled');
        var ida = '#tobody_' + tb_id;
        var idb = '#' + $('#tobody_' + tb_id).prev('tbody.ui-sortable').attr('id');
        $('#tobody_' + tb_id).insertBefore($('#' + $('#tobody_' + tb_id).prev('tbody.ui-sortable').attr('id')));
    } else {
        var btna = $('#tobody_' + tb_id).find('button.start_sprnt').is(':disabled');
        var btnb = $('#' + $('#tobody_' + tb_id).next('tbody.ui-sortable').attr('id')).find('button.start_sprnt').is(':disabled');
        var ida = '#tobody_' + tb_id;
        var idb = '#' + $('#tobody_' + tb_id).next('tbody.ui-sortable').attr('id');
        $('#tobody_' + tb_id).insertAfter($('#' + $('#tobody_' + tb_id).next('tbody.ui-sortable').attr('id')));
    }
    if (btna != btnb) {
        $(ida).find('button.start_sprnt').prop('disabled', btnb);
        $(idb).find('button.start_sprnt').prop('disabled', btna);
    }
    var ids = [];
    $('tbody[id ^=tobody_').each(function() {
        var ido = $(this).attr('id').replace('tobody_', '');
        if (ido != 0) {
            ids.push(ido);
        }
    });
    $.post(HTTP_ROOT + "milestones/moveupdown_sprint", {
        'mileuniqids': ids,
        'projUid': projUid
    }, function(res) {
        if (res) {
            updateUpDownLinks(ida, idb, ids, type);
        }
    }, 'json');
}

function updateUpDownLinks(ida, idb, ids, type) {
    var lena = $(ida).find('li.move_up_down').length;
    var lenb = $(idb).find('li.move_up_down').length;
    if (lena == lenb && lena == 2) {} else if (lena == lenb && lena == 1) {
        if (type == 1) {
            $(ida).find('li.move_up_down').after('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(2, this, ' + ida.replace('#tobody_', '') + ')"><i class="material-icons">arrow_downward</i>' + _('Move Sprint Down') + '</a></li>');
            $(ida).find('li.move_up_down').first().remove();
            $(idb).find('li.move_up_down').before('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(1, this, ' + idb.replace("#tobody_", "") + ')"><i class="material-icons">arrow_upward</i>' + _('Move Sprint Up') + '</a></li>');
            $(idb).find('li.move_up_down').eq(1).remove();
        } else {
            $(ida).find('li.move_up_down').before('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(1, this, ' + ida.replace("#tobody_", "") + ')"><i class="material-icons">arrow_upward</i>' + _('Move Sprint Up') + '</a></li>');
            $(ida).find('li.move_up_down').eq(1).remove();
            $(idb).find('li.move_up_down').after('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(2, this, ' + idb.replace('#tobody_', '') + ')"><i class="material-icons">arrow_downward</i>' + _('Move Sprint Down') + '</a></li>');
            $(idb).find('li.move_up_down').first().remove();
        }
    } else {
        if (type == 1) {
            if (lena == 2) {
                $(ida).find('li.move_up_down').first().remove();
                $(idb).find('li.move_up_down').before('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(1, this, ' + idb.replace("#tobody_", "") + ')"><i class="material-icons">arrow_upward</i>' + _('Move Sprint Up') + '</a></li>');
            } else {
                $(idb).find('li.move_up_down').eq(1).remove();
                $(ida).find('li.move_up_down').after('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(2, this, ' + ida.replace('#tobody_', '') + ')"><i class="material-icons">arrow_downward</i>' + _('Move Sprint Down') + '</a></li>');
            }
        } else {
            if (lena == 2) {
                $(ida).find('li.move_up_down').eq(1).remove();
                $(idb).find('li.move_up_down').after('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(2, this, ' + idb.replace('#tobody_', '') + ')"><i class="material-icons">arrow_downward</i>' + _('Move Sprint Down') + '</a></li>');
            } else {
                $(idb).find('li.move_up_down').first().remove();
                $(ida).find('li.move_up_down').before('<li class="move_up_down"><a href="javascript:void(0);" class="mnsm" onClick="moveSprintUpDown(1, this, ' + ida.replace('#tobody_', '') + ')"><i class="material-icons">arrow_upward</i>' + _('Move Sprint Up') + '</a></li>');
            }
        }
    }
}

function delSprint(obj, name, uniqid) {
    if (obj) {
        var uniqid = $(obj).attr("data-uid");
        var name = decodeURIComponent($(obj).attr("data-name"));
    }
    name = unescape(name);
    var conf_txt = _("Are you sure you want to delete sprint") + " '" + name + "'?";
    var conf_tg_task = 1;
    if (arguments[3] !== undefined) {
        var is_mile_on_taskpage = arguments[3];
    }
    setTimeout(function() {
        if (confirm(conf_txt)) {
            var loc = HTTP_ROOT + "milestones/delete_milestone/";
            $.post(loc, {
                'uniqid': uniqid,
                'conf_check': conf_tg_task
            }, function(res) {
                if (res.err == 1) {
                    showTopErrSucc('error', res.msg);
                } else {
                    showTopErrSucc('success', res.msg);
                    $('#empty_milestone_tr' + is_mile_on_taskpage).parent().remove();
                    easycase.showbacklog();
                }
            }, 'json');
        }
    }, 500);
    return false;
}

function setDurations(duration, type) {
    var milDates = [];
    var start_date = $("#start_date_sprnt").val();
    var end_date = '';
    var start_date_obj = '';
    if (start_date == '' || start_date == 'Invalid date') {
        start_date_obj = moment(new Date(moment().format('MMM DD, YYYY')));
        if (start_date_obj.format('dddd') != 'Saturday' && start_date_obj.format('dddd') != 'Sunday') {
            start_date = start_date_obj.format('MMM DD, YYYY');
        } else {
            if (start_date_obj.format('dddd') != 'Saturday') {
                start_date = start_date_obj.add(2, 'day').format('MMM DD, YYYY');
            } else {
                start_date = start_date_obj.add(1, 'day').format('MMM DD, YYYY');
            }
        }
        start_date_obj = moment(new Date(start_date));
    } else {
        start_date_obj = moment(new Date(start_date));
    }
    var dur_cnt = duration;
    duration = duration * 7;
    var b = '';
    var j = 0;
    for (var i = 1; i <= duration; i++) {
        b = start_date_obj.add(i, 'day').format('dddd');
        if (b != 'Saturday' && b != 'Sunday') {
            j++;
            end_date = start_date_obj.format('MMM DD, YYYY');
        }
        start_date_obj = moment(new Date(start_date));
    }
    if (type == 1 && (end_date != $("#end_date_sprnt").val())) {
        var stdt = moment(new Date($("#start_date_sprnt").val()));
        var eddt = moment(new Date($("#end_date_sprnt").val()));
        var daydiff = eddt.diff(stdt, 'days');
        if (!isNaN(daydiff)) {
            duration = parseInt(daydiff);
        }
        var t_stdt = moment(new Date($("#start_date_sprnt").val()));
        var j = 0;
        for (var i = 0; i < duration; i++) {
            b = t_stdt.add(i, 'day').format('dddd');
            if (b != 'Saturday' && b != 'Sunday') {
                j++;
            }
            t_stdt = moment(new Date($("#start_date_sprnt").val()));
        }
        $('.dura-sprint-select').val(5);
        $('.dura-sprint-select').trigger('change');
    } else {
        $("#end_date_sprnt").val(end_date);
        $("#start_date_sprnt").val(start_date);
    }
    $("#end_date_sprnt").datepicker("setStartDate", start_date);
    $('#hours_in_sprint').html(_('There are') + ' <strong>' + j + ' ' + _('working days') + '</strong> ' + _('in this sprint') + '.');
    milDates.push(start_date);
    milDates.push(end_date);
    return milDates;
}

function startSprint(mileuniqid, id) {
    var projUid = $('#projFil').val();
    if ($('#backlog_tsk_cnt_' + id).text() == '0') {
        showTopErrSucc('error', _('Sprint can not be started without task. So add some task to the sprint') + '.');
        return false;
    }
    openPopup();
    $('#tasks_in_sprint').html('<strong>' + $('#backlog_tsk_cnt_' + id).text() + '</strong> ' + _('tasks will be included in this sprint') + '.');
    $(".sprint_start_pop").show();
    $('#st_id_sprint').val('').show();
    $('#st_title_sprint').val('');
    $('#st_description_sprint').val('');
    $("#st_addeditSprnt").hide();
    if (mileuniqid != '') {
        $("#st_addeditSprnt").show();
    }
    $('#st_btn_sprint').show();
    $('#st_ldr_sprint').hide();
    $('#st_proj_id_sprint').val(projUid);
    $('textarea').autoGrow().keyup();
    $('#st_btn-add-new-sprint').html(_('Start'));
    $('#tasks_noest_in_sprint').html('');
    if (mileuniqid != '') {
        $.post(HTTP_ROOT + "milestones/ajax_check_estd", {
            'mileuniqid': mileuniqid,
            'projUid': projUid
        }, function(resout) {
            if (resout.status == 'success') {
                if (resout.taskList.length) {
                    var tskEstmsg = '';
                    $.each(resout.taskList, function(key, value) {
                        if (tskEstmsg == '') {
                            tskEstmsg += '#' + value;
                        } else {
                            tskEstmsg += ', #' + value;
                        }
                    });
                    $('#tasks_noest_in_sprint').html('<i class="material-icons">warning</i> Tasks <strong>' + tskEstmsg + '</strong> ' + _('do not have a value for the story point field. Any change after the start of the sprint will be treated as scope change') + '.');
                }
                $.post(HTTP_ROOT + "milestones/ajax_new_sprint", {
                    'mileuniqid': mileuniqid,
                    'projUid': projUid
                }, function(res) {
                    if (res) {
                        $("#st_addeditSprnt").hide();
                        $('#st_id_sprint').val(res.Milestone.id);
                        $('#st_title_sprint').val(res.Milestone.title);
                        $('#st_description_sprint').val(res.Milestone.description);
                        $.material.init();
                        $('textarea').autoGrow().keyup();
                        var retSetDates = [];
                        var selectizeProj = $('.dura-sprint-select').select2({}).off('select2:select').on('select2:select', function(evt) {}).on('change', function(evt) {
                            var selctd_mil = $(this).val();
                            if (selctd_mil != 5) {
                                setDurations(selctd_mil, 0);
                            }
                        });
                        $("#start_date_sprnt,#end_date_sprnt").datepicker({
                            format: 'M d, yyyy',
                            todayHighlight: true,
                            changeMonth: false,
                            changeYear: false,
                            hideIfNoPrevNext: true,
                            autoclose: true,
                            clearBtn: true
                        }).on("changeDate", function(ev) {
                            if ($(ev.target).attr('id') == 'start_date_sprnt') {
                                var selctd_mil = $('.dura-sprint-select').val();
                                setDurations(selctd_mil, 0);
                            } else if ($(ev.target).attr('id') == 'end_date_sprnt') {
                                var selctd_mil = $('.dura-sprint-select').val();
                                setDurations(selctd_mil, 1);
                            }
                        }).on("hide", function(ev) {
                            if ($(ev.target).attr('id') == 'start_date_sprnt') {} else {}
                        });
                        $('.dura-sprint-select').val(1);
                        $('.dura-sprint-select').trigger('change');
                    }
                }, 'json');
            } else {
                showTopErrSucc('error', resout.msg);
                return false;
            }
        }, 'json');
    }
}

function notAllowedSprint(type) {
    var msg = _('You are not authorized to');
    if (type == 1) {
        msg += ' ' + _('create');
    } else if (type == 2) {
        msg += ' ' + _('start');
    } else if (type == 3) {
        msg += ' ' + _('edit');
    } else if (type == 4) {
        msg += ' ' + _('delete');
    } else if (type == 5) {
        msg += ' ' + _('move up or down');
    } else if (type == 6) {
        msg += ' ' + _('complete');
    }
    msg += ' ' + _('a sprint') + '.';
    showTopErrSucc('error', msg);
    return false;
}

function hideCancelQt(mid) {
    var t_va = $('.inline_qktask' + mid).val().trim();
    if (t_va == '') {
        $('#inlin_qtsk_link' + mid).toggle();
        $('#inlin_qtsk_c' + mid).toggle();
    }
}

function openProjectListExportPopup(exportType) {
    openPopup();
    $(".loader_dv").show();
    $(".project_list_export").show();
    $("#hid_export_type_id").val(exportType);
    $('.project_exp_chkbx').prop('checked', true);
}

function projectlistexport() {
    var checkedArr = [];
    $('.project_exp_chkbx').each(function() {
        if ($(this).is(':checked')) {
            checkedArr.push($(this).val());
        }
    });
    if (!checkedArr.length) {
        showTopErrSucc('Error', _('Please select atleast one field.'));
        return false;
    }
    var exportTypeVal = $("#hid_export_type_id").val();
    closePopup();
    var url_params = 'projFil=' + projFil + '&checkedFields=' + checkedArr + '&exportType=' + exportTypeVal;
    var url = HTTP_ROOT + "projects/export_csv_projectlist?" + url_params;
    window.open(url, '_blank');
    return false;
}

function showHideSts() {
    $('.cust_drop_status').toggle();
}

function newRole(type, roleId, roleName) {
    var RoleGroupId = typeof arguments[3] != 'undefined' ? arguments[3] : '';
    openPopup();
    $(".new_user_role").show();
    $('#inner_role').hide();
    $('.loader_dv').show();
    var url = HTTP_ROOT + 'RoleManagement/roles/';
    var id = '';
    if (type == 'add') {
        url += 'add';
        $('#rolettl').html(_('Create New Role'));
    } else {
        url += 'edit';
        id = roleId;
        $('#rolettl').html(_('Edit Role') + ' ' + decodeURIComponent(roleName.replace(/\+/g, ' ')));
    }
    $.post(url, {
        id: id
    }, function(res) {
        if (res) {
            $('#inner_role').html(res).promise().done(function() {
                if (RoleGroupId != '') {
                    $("#RoleAddForm").find("select[name='data[Role][role_group_id]']").val(RoleGroupId);
                    $("#RoleAddForm").find("select[name='data[Role][role_group_id]']").trigger('change');
                }
            });
            $('.loader_dv').hide();
            $('#inner_role').show();
        }
    });
}

function userRole_list(roleId, roleName) {
    openPopup();
    $(".user_role_list").show();
    $('#inner_user_role_list').hide();
    $('.loader_dv').show();
    var url = HTTP_ROOT + 'RoleManagement/roles/get_user_role_list';
    var roleId = roleId;
    $("#user_role_name").text(roleName);
    $.post(url, {
        roleId: roleId
    }, function(res) {
        if (res) {
            $('#inner_user_role_list').html(res);
            $('.loader_dv').hide();
            $('#inner_user_role_list').show();
        }
    });
}



function newModule(type, moduleId, moduleName) {
    openPopup();
    $(".new_module").show();
    $('#inner_module').hide();
    $('.loader_dv').show();
    var url = HTTP_ROOT + 'RoleManagement/roles/';
    var id = '';
    if (type == 'add') {
        url += 'add_module';
        $('#modulettl').html(_('Create New Module'));
    } else {
        url += 'edit_module';
        id = moduleId;
        $('#rolettl').html(_('Edit Module') + ' ' + moduleName);
    }
    $.post(url, {
        id: id
    }, function(res) {
        if (res) {
            $('#inner_module').html(res);
            $('.loader_dv').hide();
            $('#inner_module').show();
        }
    });
}

function newAction(type, actionId, actionName) {
    openPopup();
    $(".new_action").show();
    $('#inner_action').hide();
    $('.loader_dv').show();
    var url = HTTP_ROOT + 'RoleManagement/roles/';
    var id = '';
    if (type == 'add') {
        url += 'add_action';
        $('#actionttl').html(_('Create New Action'));
    } else {
        url += 'edit_action';
        id = actionId;
        $('#actionttl').html(_('Edit Action') + ' ' + actionName);
    }
    $.post(url, {
        id: id
    }, function(res) {
        if (res) {
            $('#inner_action').html(res);
            $('.loader_dv').hide();
            $('#inner_action').show();
        }
    });
}

function roleAdd(roleid, roleshortname, loader, btn) {
    $('#role_err_msg').html('');
    var proj1 = "";
    proj1 = $('#' + roleid).val();
    var shortname1 = $('#' + roleshortname).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Role Name' cannot be left blank!");
        $('#role_err_msg').show();
        $('#role_err_msg').html(msg);
        $('#' + roleid).focus();
        return false;
    } else {
        if (!proj1.match(/^[A-Za-z0-9]/g)) {
            msg = _("'Role Name' must starts with an Alphabet or Number!");
            $('#role_err_msg').show();
            $('#role_err_msg').html(msg);
            $('#' + roleid).focus();
            return false;
        }
    }
    if (shortname1.trim() == "") {
        msg = _("'Role Short Name' cannot be left blank!");
        $('#role_err_msg').show();
        $('#role_err_msg').html(msg);
        $('#' + roleshortname).focus();
        return false;
    } else {
        var x = shortname1.substr(-1);
        if (!x.match(/^[a-z0-9]+$/i)) {
            msg = _("'Short Name' must be alphanumeric!");
            $('#role_err_msg').show();
            $('#role_err_msg').html(msg);
            $('#' + roleshortname).focus();
            return false;
        }
        if ($("#txt_groupId").is(":visible")) {
            if ($("#txt_groupId").val() == "") {
                msg = _("Please select a role group!");
                $('#role_err_msg').show();
                $('#role_err_msg').html(msg);
                $("#txt_groupId").focus();
                return false;
            }
        }
        if ($('#' + roleid).closest('form').find('input[type=checkbox]:checked').size() == 0) {
            msg = _("Please check at least one module!");
            $('#role_err_msg').show();
            $('#role_err_msg').html(msg);
            return false;
        }
        $('#role_err_msg').hide();
        $('#' + loader).show();
        $('#' + btn).hide();
        var uniq_id = '';
        if (roleid == 'edt_role') {
            uniq_id = $('#role_uniq_id').val();
        }
        $.post(strURL + "RoleManagement/roles/ajax_check_role_exists", {
            "name": escape(proj1),
            "shortname": escape(shortname1),
            "uniqid": uniq_id
        }, function(data) {
            if (data == "Role") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Role Name' is already exists!");
                $('#role_err_msg').show();
                $('#role_err_msg').html(msg);
                $('#' + roleshortname).focus();
                return false;
            } else if (data == "ShortName") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Role Short Name' is already exists!");
                $('#role_err_msg').show();
                $('#role_err_msg').html(msg);
                $('#' + roleshortname).focus();
                return false;
            } else {
                if (roleid == 'txt_role') {
                    document.roleadd.submit();
                } else {
                    document.roleedit.submit();
                }
                return true;
            }
        });
        return false;
    }
    return false;
}

function openCaseDetailPopupArc(CsUid) {
    easycase.ajaxCaseDetails(CsUid, 'case', 0, 'popup');
}
function roleGroupAdd(roleid, roleshortname, loader, btn) {
    var $errDiv = '';
    var uniq_id = '';
    if (roleid == 'txt_rolegroup') {
        $errDiv = $('#rolegroup_err_msg');
    } else {
        $errDiv = $('#edtrolegroup_err_msg');
    }
    $errDiv.html('');
    var proj1 = "";
    proj1 = $('#' + roleid).val();
    var shortname1 = $('#' + roleshortname).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Role Group Name' cannot be left blank!");
        $errDiv.show();
        $errDiv.html(msg);
        $('#' + roleid).focus();
        return false;
    } else {
        if (!proj1.match(/^[A-Za-z0-9]/g)) {
            msg = _("'Role Group Name' must starts with an Alphabet or Number!");
            $errDiv.show();
            $errDiv.html(msg);
            $('#' + roleid).focus();
            return false;
        }
    }
    if (shortname1.trim() == "") {
        msg = _("'Role Group Short Name' cannot be left blank!");
        $errDiv.show();
        $errDiv.html(msg);
        $('#' + roleshortname).focus();
        return false;
    } else {
        var x = shortname1.substr(-1);
        if (!x.match(/^[a-z0-9]+$/i)) {
            msg = _("'Role Group Short Name' must be alphanumeric!");
            $errDiv.show();
            $errDiv.html(msg);
            $('#' + roleshortname).focus();
            return false;
        }
        $errDiv.hide();
        $('#' + loader).show();
        $('#' + btn).hide();
        if (roleid == 'txt_rolegroup') {
            uniq_id = '';
        } else {
            uniq_id = $('#rgUniqId').val();
        }
        $.post(strURL + "RoleManagement/roles/ajax_check_rolegroup_exists", {
            "name": escape(proj1),
            "shortname": escape(shortname1),
            "uniqid": escape(uniq_id)
        }, function(data) {
            if (data == "RoleGroup") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Role Group Name' is already exists!");
                $errDiv.show();
                $errDiv.html(msg);
                $('#' + roleshortname).focus();
                return false;
            } else if (data == "ShortName") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Role Group Short Name' is already exists!");
                $errDiv.show();
                $errDiv.html(msg);
                $('#' + roleshortname).focus();
                return false;
            } else {
                if (roleid == 'txt_rolegroup') {
                    document.roleGroupadd.submit();
                } else {
                    document.roleGroupedit.submit();
                }
                return true;
            }
        });
        return false;
    }
    return false;
}

function moduleAdd(moduleid, loader, btn) {
    var $errDiv = '';
    var uniq_id = '';
    if (moduleid == 'txt_module') {
        $errDiv = $('#module_err_msg');
    } else {
        $errDiv = $('#edtmodule_err_msg');
    }
    $errDiv.html('');
    var proj1 = "";
    proj1 = $('#' + moduleid).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Module' cannot be left blank!");
        $errDiv.show();
        $errDiv.html(msg);
        $('#' + moduleid).focus();
        return false;
    } else {
        if (!proj1.match(/^[A-Za-z0-9]/g)) {
            msg = _("'Module' must starts with an Alphabet or Number!");
            $errDiv.show();
            $errDiv.html(msg);
            $('#' + moduleid).focus();
            return false;
        }
    }
    $errDiv.hide();
    $('#' + loader).show();
    $('#' + btn).hide();
    if (moduleid == 'txt_module') {
        uniq_id = '';
    } else {
        uniq_id = $('#moduleUniqId').val();
    }
    $.post(strURL + "RoleManagement/roles/ajax_check_module_exists", {
        "name": escape(proj1),
        "uniqid": escape(uniq_id)
    }, function(data) {
        if (data == "Module") {
            $('#' + loader).hide();
            $('#' + btn).show();
            msg = _("'Module' is already exists!");
            $errDiv.show();
            $errDiv.html(msg);
            return false;
        } else {
            if (moduleid == 'txt_module') {
                document.moduleadd.submit();
            } else {
                document.moduleedit.submit();
            }
            return true;
        }
    });
    return false;
}

function actionAdd(actionid, module_id, loader, btn) {
    var $errDiv = '';
    var uniq_id = '';
    if (actionid == 'txt_action') {
        $errDiv = $('#action_err_msg');
    } else {
        $errDiv = $('#edtaction_err_msg');
    }
    $errDiv.html('');
    var proj1 = "";
    proj1 = $('#' + actionid).val();
    var shortname1 = $('#' + module_id).val();
    var strURL = HTTP_ROOT;
    proj1 = proj1.trim();
    if (proj1 == "") {
        msg = _("'Action' cannot be left blank!");
        $errDiv.show();
        $errDiv.html(msg);
        $('#' + actionid).focus();
        return false;
    } else {
        if (!proj1.match(/^[A-Za-z0-9]/g)) {
            msg = _("'Action' must starts with an Alphabet or Number!");
            $errDiv.show();
            $errDiv.html(msg);
            $('#' + actionid).focus();
            return false;
        }
    }
    if (shortname1.trim() == "") {
        msg = _("'Module' cannot be left blank!");
        $errDiv.show();
        $errDiv.html(msg);
        $('#' + module_id).focus();
        return false;
    } else {
        $errDiv.hide();
        $('#' + loader).show();
        $('#' + btn).hide();
        if (actionid == 'txt_action') {
            uniq_id = '';
        } else {
            uniq_id = $('#actionUniqId').val();
        }
        $.post(strURL + "RoleManagement/roles/ajax_check_action_exists", {
            "name": escape(proj1),
            "shortname": escape(shortname1),
            "uniqid": escape(uniq_id)
        }, function(data) {
            if (data == "Action") {
                $('#' + loader).hide();
                $('#' + btn).show();
                msg = _("'Action' is already exists!");
                $errDiv.show();
                $errDiv.html(msg);
                $('#' + actionid).focus();
                return false;
            } else {
                if (actionid == 'txt_action') {
                    document.actionadd.submit();
                } else {
                    document.actionedit.submit();
                }
                return true;
            }
        });
        return false;
    }
    return false;
}
var roleSettingsChanged = 0;

function saveRoleActionPermissions($obj, role_id) {
    var checked = 0;
    $($obj.closest('form')).find('input[type=checkbox]').each(function(i) {
        if ($(this).is(":checked")) {
            checked++;
        }
    });
    var prjid = '';
    if (typeof arguments[2] != 'undefined') {
        prjid = arguments[2];
    }
    if (checked) {
        roleSettingsChanged = 0;
        $($obj).hide();
        $($obj).next('span').show();
        var serialized = $($obj.closest('form')).find('.onoffswitch_checkbox1').map(function() {
            return {
                name: this.name,
                value: this.checked ? this.value : 0
            };
        });
        var url = $($obj.closest('form')).attr('action');
        $.post(url, {
            actions: JSON.stringify(serialized),
            role_id: role_id
        }, function(res) {
            if (res == 1) {
                showTopErrSucc('success', _('Role permission saved successfully.'));
            } else {
                showTopErrSucc('error', _('The Role Permissions could not be set'));
            }
            window.location.reload();
        });
    } else {
        showTopErrSucc('error', _('Please check atleast one action to save'));
    }
}

function deleteRole(role_id) {
    if (confirm(_('Are you sure you want to delete this role?'))) {
        var url = HTTP_ROOT + 'RoleManagement/roles/delete';
        $.post(url, {
            role_id: role_id
        }, function(res) {
            if (res) {
                showTopErrSucc('success', _("Role Deleted Successfully"));
                window.location.reload();
            }
        });
    }
}

function deleteRoleGroup($obj, rolegroup_id, type, role_name) {
    var confirmMsg = _("Are you sure you want to delete role group") + " '" + role_name + "'";
    if (type == 'roles') {
        confirmMsg = confirmMsg + " " + _("with roles");
    }
    if (confirm(confirmMsg + "?")) {
        $($obj).closest('span.close').hide();
        $($obj).closest('span.close').next('span').show();
        var url = HTTP_ROOT + 'RoleManagement/roles/delete_role_group';
        $.post(url, {
            rolegroup_id: rolegroup_id,
            type: type
        }, function(res) {
            if (res) {
                showTopErrSucc('success', _("Role Group Deleted Successfully"));
                window.location.reload();
            }
        });
    }
}
$(function() {
    $(".icon-assgn-role").click(function() {
        var prj_id = $(this).attr('data-prj-id');
        var prj_name = $(this).attr('data-prj-name');
        assign_role(prj_id, prj_name);
    });
    $(".icon-manage-role").click(function() {
        var prj_id = $(this).attr('data-prj-id');
        var prj_name = $(this).attr('data-prj-name');
        manage_project_role(prj_id, prj_name);
    });
    $(".icon-assgn-role-user").click(function() {
        var usr_id = $(this).attr('data-usr-id');
        var usr_name = $(this).attr('data-usr-name');
        assign_role_user(usr_id, usr_name);
    });
});

function assign_role(prj_id, prj_name) {
    if (typeof arguments[2] == 'undefined') {
        openPopup();
    }
    $(".assgn_role_prj_usr").show();
    $("#header_prj_usr_assgn_role").html(prj_name);
    $('#inner_prj_usr_assgn_role').hide();
    $('.assgn-role-btn').hide();
    $(".popup_bg").css({
        "width": '600px'
    });
    $.post(HTTP_ROOT + "projects/assign_role", {
        "pjid": prj_id,
        "pjname": prj_name
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#usersrch').show();
            $('#inner_prj_usr_assgn_role').show();
            $('#inner_prj_usr_assgn_role').html(data);
            $('.assgn-role-btn').show();
        }
    });
}

function assign_role_user(usr_id, usr_name) {
    if (typeof arguments[2] == 'undefined') {
        openPopup();
    }
    $(".assgn_role_usr_prj").show();
    $("#header_usr_prj_assgn_role").html(usr_name);
    $('#inner_usr_prj_assgn_role').hide();
    $('.assgn-role-btn').hide();
    $(".popup_bg").css({
        "width": '600px'
    });
    $.post(HTTP_ROOT + "projects/assign_role_usr", {
        "usrid": usr_id,
        "usrname": usr_name
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#usersrch').show();
            $('#inner_usr_prj_assgn_role').show();
            $('#inner_usr_prj_assgn_role').html(data);
            $('.assgn-role-btn').show();
        }
    });
}

function assignrole(obj) {
    $(obj).parent().hide();
    $('#asgnroleloader').show();
    var data = $("#ProjectUserAssignRoleForm").serialize();
    var url = $("#ProjectUserAssignRoleForm").attr('action');
    $.post(url, {
        projectroles: data
    }, function(res) {
        if (res == 1) {
            showTopErrSucc('success', _('The Role has been changed successfully'));
        } else {
            showTopErrSucc('error', _('The Role could not be changed. Please try again.'));
        }
        $(obj).parent().show();
        $('#asgnroleloader').hide();
        closePopup();
    });
}

function assignroleuser(obj) {
    $(obj).parent().hide();
    $('#asgnroleusrloader').show();
    var data = $("#ProjectUserAssignRoleUsrFormuser").serialize();
    var url = $("#ProjectUserAssignRoleUsrFormuser").attr('action');
    $.post(url, {
        projectroles: data
    }, function(res) {
        if (res == 1) {
            showTopErrSucc('success', _('The Role has been changed successfully'));
        } else {
            showTopErrSucc('error', _('The Role could not be changed. Please try again.'));
        }
        $(obj).parent().show();
        $('#asgnroleusrloader').hide();
        closePopup();
    });
}

function addActionId(obj) {
    $(obj).parent().parent().next().children().children('.actionViewId').attr('data-roleId', obj.value);
}

function manage_project_role(obj) {
    var role_id = $(obj).attr('data-roleId');
    if (typeof arguments[1] == 'undefined') {
        $(".assgn_role_prj_usr").hide();
        var param = {
            "roleId": role_id,
            "project_id": $('#projectId').val(),
            "project_name": $('#project_name').val(),
        }
    } else {
        $(".assgn_role_usr_prj").hide();
        var param = {
            "roleId": role_id,
            "user_id": $("#puserId").val(),
            "user_name": $("#puser_name").val(),
        }
    }
    $(".manage_role_prj_usr").show();
    $("#header_prj_usr_manage_role").html($(obj).attr('data-roleName'));
    $('#inner_prj_usr_manage_role').hide();
    $('.manage-role-btn').hide();
    $(".popup_bg").css({
        "width": '600px'
    });
    $.post(HTTP_ROOT + "projects/manage_role", param, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#usersrch').show();
            $('#inner_prj_usr_manage_role').show();
            $('#inner_prj_usr_manage_role').html(data);
            $('.manage-role-btn').show();
        }
    });
}

function closePopupMR() {
    var project_id = $("#mng_prct_id").val();
    var project_name = $("#mng_prct_name").val();
    $(".popup_overlay").css({
        display: "none"
    });
    $(".popup_bg").css({
        display: "none"
    });
    $(".sml_popup_bg").css({
        display: "none"
    });
    $(".cmn_popup").hide();
    if (project_id != '') {
        showAsignRole(project_id, project_name);
    } else {
        assign_role_user($("#mng_puser_id").val(), $("#mng_puser_name").val(), 1);
    }
}

function showAsignRole(prj_id, prj_name) {
    assign_role(prj_id, prj_name, 1);
}

function keyDownValid(event) {
    if (event.altKey) {
        event.preventDefault()
    } else {
        var a = event.keyCode || event.which;
        if (((a == 219) || (a == 192) || (a == 188) || (a == 190) || (a == 220) || (a == 187) || (a == 186) || (a == 221) || (a == 191))) {
            event.preventDefault()
        }
    }
}

function clean(obj) {
    var inpVal = $(obj).val().trim();
    if (inpVal.match(/[~`<>,;\+\\]+/)) {
        $(obj).val('');
        $(obj).focus();
    }
}

function isAllowed(action) {
    if (SES_TYPE == '2' || SES_TYPE == '1') {
        return true;
    }
    var project_id = typeof arguments[1] != 'undefined' ? arguments[1] : getCookie('CPUID');
    if (typeof project_id != 'undefined' && typeof roleAccess[project_id] != 'undefined' && roleAccess[project_id] != '') {} else {
        var project_id = 0;
    }
    if (roleAccess[project_id].hasOwnProperty(action) && roleAccess[project_id][action] == 0) {
        return false;
    } else {
        return true;
    }
}

function notShowEmptyDropdown() {
    $('.slide_rht_con .dropdown-menu').each(function() {
        if ($(this).find('*').length == 0) {
            $(this).css('visibility', 'hidden');
            $(this).closest('.dropdown').find('a').removeAttr('href');
        }
    });
}
$("body").on('click', 'form', function(e) {
    if ($(e.target).find('.no-pointer').length >= 1) {
        showTopErrSucc('error', _("You aren't permitted to perform this action"));
        return false;
    }
});

function hasLeftScrollBar() {
    if ($('.fixed_left_nav').height() >= $('.fixed_left_nav').find('.side-nav').get(0).scrollHeight) {
        $('.fixed_left_nav').removeClass('hasScrollBar');
    } else {
        $('.fixed_left_nav').addClass('hasScrollBar');
    }
}

function str_replace(search, replace, subject, countObj) {
    var i = 0
    var j = 0
    var temp = ''
    var repl = ''
    var sl = 0
    var fl = 0
    var f = [].concat(search)
    var r = [].concat(replace)
    var s = subject
    var ra = Object.prototype.toString.call(r) === '[object Array]'
    var sa = Object.prototype.toString.call(s) === '[object Array]'
    s = [].concat(s)
    var $global = (typeof window !== 'undefined' ? window : global)
    $global.$locutus = $global.$locutus || {}
    var $locutus = $global.$locutus
    $locutus.php = $locutus.php || {}
    if (typeof(search) === 'object' && typeof(replace) === 'string') {
        temp = replace
        replace = []
        for (i = 0; i < search.length; i += 1) {
            replace[i] = temp
        }
        temp = ''
        r = [].concat(replace)
        ra = Object.prototype.toString.call(r) === '[object Array]'
    }
    if (typeof countObj !== 'undefined') {
        countObj.value = 0
    }
    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + ''
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0]
            s[i] = (temp).split(f[j]).join(repl)
            if (typeof countObj !== 'undefined') {
                countObj.value += ((temp.split(f[j])).length - 1)
            }
        }
    }
    return sa ? s : s[0]
}
(function() {
    $('.sidebar_parent_li ul').mouseenter(function() {
        $(this).parent('.sidebar_parent_li').addClass('expand_menu');
    });
    $(".sidebar_parent_li ul").mouseleave(function() {
        $(this).parent('.sidebar_parent_li').removeClass('expand_menu');
    });
}());

function addSubtaskLnk() {
    if ($('.subtask_holder_div').is(':visible')) {
        if ($('.other_page_subtask').length && $('.other_page_subtask').is(':visible')) {
            $('.other_page_subtask').trigger('click');
        } else if (!$('.other_page_subtask').length) {
            showTopErrSucc('error', _('You are not authorized to add subtask'));
        } else if ($('.other_page_subtask').length && $('.other_page_subtask').is(':hidden')) {
            showTopErrSucc('error', _('Subtask can not be added in a close task'));
        }
    }
}

function addReminderPopup(project_uniq_id, casuid) {
    openPopup();
    $(".edit_reminder_dv").removeClass('edit_rem');
    $('#savreminder').text(_('Save'));
    $('.add_reminder_temp_name').text(_('Set Reminder'));
    $("#addreminderder").hide();
    $("#addreminder_btn").show();
    $(".popup_add_new_reminder").show();
    $("#reminder_task_id").val(casuid);
    $("#reminder_un_id").val('');
    $("#reminder_prj_un_id").val(project_uniq_id);
    $("#CS_dt_reminder").val('');
    $(".edit_reminder_dv").addClass('edit_rem');
    if (typeof $('#CS_dt_reminder').data("DateTimePicker") != 'undefined') {
        $('#CS_dt_reminder').data("DateTimePicker").destroy();
    }
    $("#message_reminder").val('');
    $(".popup-reminder-to-select").select2();
    $(".popup-reminder-to-select").val('').trigger('change');
    $(".popup-reminder-to-select").select2({
        width: '100%',
        allowClear: true,
        ajax: {
            url: HTTP_ROOT + 'requests/getReminderUsers',
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    'searchTerm': params.term,
                    'project_id': project_uniq_id,
                    'task_id': casuid
                }
            },
            processResults: function(data) {
                if (data.status) {
                    return {
                        results: $.map(data.task, function(obj) {
                            return {
                                id: (obj.id),
                                text: (obj.text)
                            };
                        })
                    };
                } else {
                    return _("No data found");
                }
            },
            cache: true
        },
    });
    $('#CS_dt_reminder').datetimepicker({
        minDate: moment(new Date()),
        ignoreReadonly: true,
        showClear: true,
        stepping: 15
    });
}
function newOnboarding() {
    openPopup();
    $(".new_onboarding_tour").show();
    $('body').removeClass('body_onboarding_tour');
    var t_comple = localStorage.getItem("tour_complete");
    if (!t_comple) {
        t_comple = 0;
    } else {
        var t_comple_t = t_comple.split(',');
        t_comple = t_comple_t.length;
        $.each(t_comple_t, function(key, value) {
            if (value == '1') {
                $('#plan_your_project').addClass('complete');
            } else if (value == '2') {
                $('#align_your_resource').addClass('complete');
            } else if (value == '3') {
                $('#manage_your_work').addClass('complete');
            } else if (value == '4') {
                $('#time_and_resource').addClass('complete');
            }
        });
    }
    $('#tour_counter').text(t_comple);
    $('.fill_bar').css('width', t_comple * 75);
    if (t_comple == '4') {
        $('#new_onboarding_link').hide();
        $('#tour_after_onboarding').show();
        delete_cookie('FIRST_INVITE_1');
        if (typeof getCookie('FIRST_INVITE_2') != 'undefined') {
            delete_cookie('FIRST_INVITE_2');
        }
    }
    if ($('.hopscotch-close').length) {
        $('.hopscotch-close').trigger('click');
    }
}

function quicklinkclk() {
    if ($('.hopscotch-close').length) {
        $('.hopscotch-close').trigger('click');
    }
    if ($('.show_new_add_div').length) {
        $('.show_new_add_div').hide();
    }
}

function empty(r) {
    var n, t, e, f = [void 0, null, !1, 0, "", "0"];
    for (t = 0, e = f.length; t < e; t++)
        if (r === f[t])
            return !0;
    if ("object" == typeof r) {
        for (n in r)
            if (r.hasOwnProperty(n))
                return !1;
    }
    return !1
}

function beforeOnboarding(typ) {
    if (!localStorage.getItem("OSBEFORTOUR") || localStorage.getItem("OSBEFORTOUR") == '0') {
        if (typeof getCookie('FIRST_INVITE_2_CNTR') != 'undefined') {
            delete_cookie('FIRST_INVITE_2_CNTR');
        }
        if (typ != '0') {
            openPopup();
            $(".before_onboarding_tour").show();
        }
    }
}

function isTimerRunning(v) {
    var status = false;
    if (timer_interval || typeof getCookie('timerPaused') != 'undefined') {
        var tmdet = getCookie('timerDtls');
        var tm = getCookie('timer');
        if (typeof tmdet != 'undefined' && tmdet != '' && typeof tm != 'undefined' && tm != '') {
            var tmCsDet = tmdet.split('|');
            var taskautoid = tmCsDet[0];
            if (v == taskautoid) {
                status = true;
            }
        }
    }
    return status;
}

function exitTimerPopup() {
    openPopup();
    $(".exit_timer_popup").show();
}

function addCancelCustomer(typ) {
    if (typeof arguments[1] != 'undefined') {
        $('#proj_cust_fname' + arguments[1]).val('');
        $('#proj_cust_email' + arguments[1]).val('');
        $('#proj_cust_currency' + arguments[1]).val(0).select2();
        $('#add_instant_customer' + arguments[1]).slideToggle();
    } else {
        $('#proj_cust_fname').val('');
        $('#proj_cust_email').val('');
        $('#proj_cust_currency').val(0).select2();
        $('#add_instant_customer').slideToggle();
    }
}

function addProjCustomer() {
    var errMsg;
    var err = false;
    var c_id_nm = '';
    if (typeof arguments[0] != 'undefined') {
        var c_id_nm = arguments[0];
    }
    var c_name = $.trim($('#proj_cust_fname' + c_id_nm).val(''));
    var c_email = $.trim($('#proj_cust_email' + c_id_nm).val(''));
    var c_curncy = $.trim($('#proj_cust_currency' + c_id_nm).val());
    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var rxAlphaNum = /^([0-9\(\)-]+)$/;
    if (c_name == '') {
        $('#proj_cust_fname' + c_id_nm).focus();
        errMsg = _('Please enter customer name.');
        err = true;
    } else if (c_email == '') {
        $('#proj_cust_email' + c_id_nm).focus();
        errMsg = _('Please enter email address.');
        err = true;
    } else if (!c_email.match(emlRegExpRFC) || c_email.search(/\.\./) != -1) {
        $('#proj_cust_email' + c_id_nm).focus();
        errMsg = _('Please enter proper email address.');
        err = true;
    } else if (c_curncy == '') {
        $('#proj_cust_currency' + c_id_nm).focus();
        errMsg = _('Please select currency.');
        err = true;
    }
    if (err == true) {
        showTopErrSucc('error', errMsg);
        return false;
    }
    $('#proj_cust_loader').show();
    $("#proj_btn_cust_add").hide();
    $.ajax({
        url: HTTP_ROOT + "/invoices/add_customer",
        data: {
            'cust_status': 'Active',
            'cust_fname': c_name,
            'cust_email': c_email,
            'cust_currency': c_curncy,
        },
        method: 'post',
        dataType: 'json',
        success: function(response) {
            invoices.flag = true;
            $('#proj_cust_loader').hide();
            $("#proj_btn_cust_add").show();
            if (response.success == 'No') {
                showTopErrSucc('error', response.msg);
                return false;
            }
            if (response.success == 'Yes' && response.mode == 'Add' && response.status == 'Active') {
                $('.proj_client').val(response.client_id);
                $('.proj_client').trigger('change');
            }
        }
    });
}

function remove_non_integers(obj) {
    var inpt = $(obj).val().trim();
    var char_restirict = /^[0-9\.\:]+$/.test(inpt);
    if (!char_restirict) {
        $(obj).val(inpt.substr(0, inpt.length - 1));
    }
}
var mult_qct = false,
    prev_qct = 0;
$('#estimated_hours').keydown(function(e) {
    if (!mult_qct) {
        mult_qct = true;
        prev_qct = e.which;
        var inpt = $(this).val().trim();
        var char_restirict = /^[0-9\.\:]+$/.test(inpt);
        if (!char_restirict) {
            $(this).val(inpt.substr(0, inpt.length - 1));
        }
        setTimeout(function() {
            mult_qct = false;
        }, 100);
    } else if (prev_qct != e.which) {
        mult_qct = false;
    } else {
        return false;
    }
});

function showHideTopNav() {
    if (typeof arguments[0] != 'undefined') {
        $('.top_cmn_breadcrumb_sub').hide();
        $('.top_side_breadcrumb > a > .material-icons').css('color', '#888');
    } else {
        $('.top_cmn_breadcrumb_sub').toggle();
        $('.top_side_breadcrumb > a > .material-icons').css('color', '#888');
        if ($('.top_cmn_breadcrumb_sub').is(':visible')) {
            $('.top_side_breadcrumb > a > .material-icons').css('color', '#1a73e8 !important');
        }
    }
}

function resetHoverEffect(typ, obj) {
    $.post(HTTP_ROOT + "users/ajax_removeHoverEffect", {
        'opt': typ
    }, function(data) {
        if (data.status) {
            $(obj).parent('div').removeClass('keep_hover_efct');
        }
    }, 'json');
}

function showHideTaskFields(fieldId) {
    if ($("#column_all_" + fieldId).is(':checked')) {
        $(".task-field-" + fieldId).show();
    } else {
        $(".task-field-" + fieldId).hide();
    }
    if (!$(".task-field-4").is(":visible")) {
        $('#tour_crt_story_point').hide();
    } else {
        changeTypeId($(".task-field-4").find("select"));
    }
    if (typeof arguments[1] == 'undefined') {
        saveTaskConfFields();
    }
    if ($(".configfields").length == $(".configfields:checked").length) {
        $("#column_all_fields").prop("checked", true);
    } else {
        $("#column_all_fields").prop("checked", false);
    }
}

function saveTaskConfFields() {
    var checkedVals = $('input[id^="column_all_"]:checkbox:checked').map(function() {
        if ($(this).attr('id') != 'column_all_fields_project' && $(this).attr('id') != 'column_all_fields') {
            return this.value
        } else {};
    }).get();
    checkedVals.push(2);
    $.post(HTTP_ROOT + "requests/saveFormFileds", {
        "fieldID": checkedVals
    }, function(data) {
        if (data) {}
    });
}

function showHideProjectFields(fieldId) {
    if ($("#project_column_all_" + fieldId).is(':checked')) {
        $(".project-field-" + fieldId).show();
    } else {
        $(".project-field-" + fieldId).hide();
    }
    if (typeof arguments[1] == 'undefined') {
        saveProjectConfFields();
    }
    if ($(".projectconfigfields").length == $(".projectconfigfields:checked").length) {
        $("#column_all_fields_project").prop("checked", true);
    } else {
        $("#column_all_fields_project").prop("checked", false);
    }
}

function saveProjectConfFields() {
    var checkedVals = $('input[id^="project_column_all_"]:checkbox:checked').map(function() {
        return this.value;
    }).get();
    checkedVals.push(1);
    checkedVals.push(2);
    checkedVals.push(3);
    $.post(HTTP_ROOT + "requests/saveFormFileds", {
        "fieldID": checkedVals,
        "type": "project"
    }, function(data) {
        if (data) {}
    });
}

function drawLeftMenu() {
    var projectID = $('#projFil').val();
    var page_location = window.location.href;
    $.post(HTTP_ROOT + 'UserSidebar/ajax_draw_left_menu', {
        projectID: projectID,
        'url': page_location
    }, function(res) {
        $("#side-menu-dynamic-cnt").html(res);
    })
}

function addNewProjectStatus(type) {
    openPopup();
    $('#new_p_s_btn').text(_('Add'));
    $('#project_status_title').text(_('New Project Status'));
    $(".new_projectstatus").show();
    $(".loader_dv").hide();
    $('#inner_projectstatus').show();
    $('#tterr_msg_p_s').html('');
    $("#another_type_p_s").prop('checked', false);
    $.material.init();
    $("#project_status_nm").val('').keyup();
    if (type == 'creatask') {
        $('#customProjectStatusForm').append("<input type='hidden' id='hiddenprojectstatus' value='" + type + "'>");
    }
    setTimeout(function() {
        $("#project_status_nm").focus();
    }, '1000');
    $("#ttbtn_p_s .cancel-link").find('button').prop('disabled', false);
    $("#new_p_s_btn").prop('disabled', false);
}

function renderPSlist(quickEditOpen, type) {
    $.post(HTTP_ROOT + "projects/project_status", {
        quickEditOpen: quickEditOpen
    }, function(data) {
        if (data == 'not_authorized') {
            self.location = HTTP_ROOT + 'dashboard';
        } else {
            $("#ps_ajax_response").html(data);
            if (type != '') {
                showTopErrSucc('success', _('Project status updated successfully.'));
            } else {
                showTopErrSucc('success', _('Project status added successfully.'));
            }
        }
    });
}
function deleteProjectStatus(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("project status?"))) {
        $("#del_ps_" + id).hide();
        $("#lding_ps_" + id).show();
        $.post(HTTP_ROOT + "projects/deleteProjectStatus", {
            "id": id
        }, function(res) {
            if (parseInt(res)) {
                $("#dv_ps_" + id).fadeOut(300, function() {
                    $(this).remove();
                    renderPSlist(1, id);
                    showTopErrSucc('success', _("Project status") + " '" + nm + "' " + _("has deleted successfully."));
                });
            } else {
                $("#lding_ps_" + id).hide();
                $("#del_ps_" + id).show();
                showTopErrSucc('error', _('Error in deletion of project status.'));
            }
        });
    }
}

function editProjectStatus(obj) {
    var nm = $(obj).attr("data-name");
    var id = $(obj).attr("data-id");
    openPopup();
    $(".edit_projectstatus").show();
    $("#project_status_nm_edit").val(nm).keyup();
    $("#new-p_s_id_edit").val(id);
    setTimeout(function() {
        $("#project_status_nm_edit").focus();
    }, '1000');
    $('#tterr_msg_p_s_edit').html('');
    $.material.init();
    $('#project_status_nm_edit').val().trim() != '' ? $("#new_p_s_btn_edit").removeClass('loginactive') : $("#new_p_s_btn_edit").addClass('loginactive');
    $("#ttbtn_p_s_edit .cancel-link").find('button').prop('disabled', false);
    $("#new_p_s_btn_edit").prop('disabled', false);
}

function renderPTlist(quickEditOpen, type) {
    $.post(HTTP_ROOT + "projects/project_types", {
        quickEditOpen: quickEditOpen
    }, function(data) {
        if (data == 'not_authorized') {
            self.location = HTTP_ROOT + 'dashboard';
        } else {
            $("#pt_ajax_response").html(data);
            if (type != '') {
                showTopErrSucc('success', _('Project type updated successfully.'));
            } else {
                showTopErrSucc('success', _('Project type added successfully.'));
            }
        }
    });
}
function actvityTaskDetail(caseUniqId) {
    $("#myModalDetail").modal();
    $(".task_details_popup").show();
    $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
    $("#cnt_task_detail_kb").html("");
    easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
}

function showVideoHelp(obj) {
    var url = $(obj).attr('video-url');
    $("#myModalVideoHelp").modal('show');
    $("#help_video_cnt_frame").html('<iframe width="900" height="500" src="' + url + '?modestbranding=1&amp;rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen=""></iframe>');
}
$('#myModalVideoHelp').on('hidden.bs.modal', function() {
    $("#help_video_cnt_frame").html('');
});

function clearCreateTaskPopup() {
    $('#CS_title').val('');
    $('#due_date').val('');
    $('#start_date').val('');
    $('#CS_due_date').val('');
    $('#CS_start_date').val('');
    $('#estimated_hours').val('');
    $('#is_recurring').prop('checked', false);
    $('#is_bilable').prop('checked', false);
    $('#hours').val('');
    tinymce.activeEditor.setContent('');
    $('#up_files').html('');
    $('#cloud_storage_files_0').html('');
    taskgrp = $('#CS_milestone').val();
    assignto = $('#CS_assign_to').val();
    creatask('', 'new', taskgrp, assignto);
}

function check_empty(mixedVar) {
    var undef
    var key
    var i
    var len
    var emptyValues = [undef, null, false, 0, '', '0']
    for (i = 0, len = emptyValues.length; i < len; i++) {
        if (mixedVar === emptyValues[i]) {
            return true
        }
    }
    if (typeof mixedVar === 'object') {
        for (key in mixedVar) {
            if (mixedVar.hasOwnProperty(key)) {
                return false
            }
        }
        return true
    }
    return false
}

function remove_element(arr, indx) {
    var chk_typeof = typeof arr[0];
    indx = chk_typeof == "number" ? parseInt(indx) : indx;
    var check_indx = arr.indexOf(indx);
    if (check_indx > -1) {
        arr.splice(check_indx, 1);
        mention_array['mention_type'].splice(check_indx, 1);
        mention_array['mention_id'].splice(check_indx, 1);
    }
}

function selectFields(id) {
    var selected_text = $('#qt_task_type_backlog' + id + ' option:selected').text();
    if (selected_text == 'Story') {
        $('.story_point' + id).show();
    } else {
        $('.story_point' + id).hide();
    }
}

function projPlanShowDependents(id, depends) {
    $("#task_dependent_block_" + id).find('.showDependents').toggleClass('open ');
    if ($("#task_dependent_" + id).find('.loader').length > 0) {
        var params = {
            id: id,
            deps: depends
        };
        $.ajax({
            url: HTTP_ROOT + "templates/plan_dependent_overview",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                $("#task_dependent_" + id).find('li').remove();
                if (res.length > 0) {
                    $.each(res, function(key, val) {
                        var li = $('<li>').addClass('ellipsis-view').html(' ' + val.ProjectTemplateCase.title);
                        $("#task_dependent_" + id).append(li);
                    });
                    msg = _("This task is the children of the following parent(s).");
                }
                $("#task_dependent_" + id).parent().closest('ul').find('.task_dependent_msg').html(msg);
            }
        });
    }
}

function projPlanShowChildren(id, depends) {
    $("#task_parent_block_" + id).find('.showParents').toggleClass('open ');
    if ($("#task_parent_" + id).find('.loader').length > 0) {
        var params = {
            id: id,
            deps: depends
        };
        $.ajax({
            url: HTTP_ROOT + "templates/plan_dependent_overview",
            dataType: "json",
            type: "POST",
            data: params,
            success: function(res) {
                $("#task_parent_" + id).find('li').remove();
                if (res.length > 0) {
                    $.each(res, function(key, val) {
                        var li = $('<li>').addClass('ellipsis-view').html(' ' + val.ProjectTemplateCase.title);
                        $("#task_parent_" + id).append(li);
                    });
                    msg = _("This task is the parent of the following task(s).");
                }
                $("#task_parent_" + id).parent().closest('ul').find('.task_parent_msg').html(msg);
            }
        });
    }
    $(document).on('click', '.pop_arrow_new', function(e) {
        $(this).closest('.task_dependent_block').find('.showDependents').removeClass('open');
        $(this).closest('.task_parent_block').find('.showParents').removeClass('open');
    });
}
function loadAdvancedCustomField() {
    $.ajax({
        url: HTTP_ROOT + 'projects/loadAdvancedCustomField',
        type: 'POST',
        data: {
            'advlist': 1
        },
        dataType: 'html',
        success: function(res) {
            $("#adv_custom_field_container_dv").html(res);
        }
    });
}
function ajaXLoadDuedateChangeReason() {
    $.ajax({
        url: HTTP_ROOT + 'task_actions/duedateChangeReason',
        type: 'POST',
        data: {
            'list': 1
        },
        dataType: 'html',
        success: function(res) {
            $('#due_date_change_rsn_dv').html(res);
            $.material.init();
        }
    })
}

function ajaXAddNewDuedtChangeRsn() {
    var dtId = $('#duedt_cnge_rsn_id').val();
    var rsn = $.trim($("#due_dt_change_rsn").val());
    if (rsn == "") {
        $('#duedterr_msg').show().text(_('Reason field cannot be left blank.'));
        return false;
    }
    $.post(HTTP_ROOT + "task_actions/ajaXAddNewDuedateChangeReason", {
        'id': dtId,
        'change_rsn': rsn,
    }, function(resp) {
        if (resp.status == 'success') {
            if (dtId == "") {
                showTopErrSucc('success', _('Your reason added successfully.'));
            } else {
                showTopErrSucc('success', _('Your reason updated successfully.'));
            }
            ajaXLoadDuedateChangeReason();
            if ($('#add_dt_reason').is(":checked")) {
                $('#due_dt_change_rsn').val('');
            } else {
                closePopup();
            }
        } else {
            showTopErrSucc('error', _('Error in adding the reason.'));
        }
    }, 'json');
}

function ajaXEditDuedtChangeReason(obj) {
    var rsn = $(obj).attr("data-label");
    var id = $(obj).attr("data-id");
    openPopup();
    $('.new_duedt_change_rsn').show();
    $('#duedterr_msg').hide();
    if (rsn == "") {
        $('#duedterr_msg').show().text(_('Reason field cannot be left blank.'));
        return false;
    }
    $('#add_another_reason').hide();
    $('#new_duedt_change_title').text(_('Edit Reason'));
    $.post(HTTP_ROOT + "task_actions/ajaXEditDuedateChangeReason", {
        "id": id
    }, function(res) {
        $('#duedt_cnge_rsn_id').val(res.data.id);
        $('#due_dt_change_rsn').focus().val(res.data.reason);
    }, 'json');
}

function ajaXDeleteDuedtChangeReason(obj) {
    var rsn = $(obj).attr("data-label");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + rsn + "' " + _("from following reasons?"))) {
        $.post(HTTP_ROOT + "task_actions/ajaXDeleteDuedateChangeReason", {
            "id": id
        }, function(res) {
            if (parseInt(res) == 1) {
                $('#due_dt_change_tr_' + id).remove();
                showTopErrSucc('success', rsn + "' " + _("has deleted successfully."));
            } else {
                showTopErrSucc('error', _('Error in deletion of reason.'));
            }
        });
    }
}

function deleteCustomField(obj) {
    var nm = $(obj).attr("data-label");
    var id = $(obj).attr("data-id");
    if (confirm(_("Are you sure you want to delete") + " '" + nm + "' " + _("custom field?"))) {
        $.post(HTTP_ROOT + "projects/deleteCustomField", {
            "id": id
        }, function(res) {
            if (parseInt(res) == 1) {
                $('#custom_status_tr_' + id).remove();
                showTopErrSucc('success', _("Custom Field") + " '" + nm + "' " + _("has deleted successfully."));
            } else {
                showTopErrSucc('error', _('Error in deletion of custom field.'));
            }
        });
    }
}

function previewCustomField() {
    $('.cf_error').html('');
    var label_nm = $.trim($("#cf_label_nm").val());
    var field_type = ($("#cf_field_type").val()).toLowerCase();
    var field_type_value = $('#cf_field_type').attr('data-fieldtype');
    var placeholder = "";
    if ($("#cf_placeholder").val()) {
        placeholder = $.trim($("#cf_placeholder").val());
    }
    if (label_nm != '') {
        $('.new_custom_fld').hide();
        $('.cf_form').hide();
        $('.preview_cf').hide();
        $('.preview_div').show();
        $('.preview_exit').show();
        $('.cf_field_item').addClass("disable_cf_item");
        var reqOption = "";
        var is_required = 0;
        if ($('#cf_is_required').is(":checked")) {
            is_required = 1;
            reqOption = 'mark_mandatory';
        }
        var dateType = '';
        if (field_type == 'date') {
            dateType = "custom_field_datpicker";
            field_type = "text";
        }
        if (field_type == 'url') {
            field_type = "text";
        }
        if ((field_type) == 'textarea') {
            var preview = '<textarea class="preview_input" name="' + label_nm + '" placeholder="' + placeholder + '" id="preview_input" data-typeValue="' + field_type_value + '"></textarea><div class="field_placeholder ' + reqOption + '"><span>' + label_nm + '</span></div>';
        } else {
            var preview = '<input class="preview_input ' + dateType + '" onkeyup="customFieldPreviewKeyup()" id="preview_input" name="' + label_nm + '" type="' + field_type + '" autocomplete="off" value="" data-typeValue="' + field_type_value + '" placeholder="' + placeholder + '" /><div class="field_placeholder ' + reqOption + '"><span>' + label_nm + '</span></div>';
        }
        $("#preview_cf").html('');
        $("#preview_cf").append(preview);
        custom_date_field();
    } else {
        $('.cf_error').show();
        $('.cf_error').html('');
        $('.cf_error').html('Please enter Field Name.');
        setTimeout(function() {
            $('.cf_error').fadeOut();
        }, 5000);
        $('#cf_label_nm').focus();
    }
}

function customFieldPreviewKeyup() {
    $('.cf_error').html('');
    var fieldType = $('#preview_input').attr('data-typeValue');
    var fieldvalue = $('#preview_input').val();
    if ((fieldvalue != "") && (fieldType == 4)) {
        if (!fieldvalue.match(/^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/)) {
            $('.cf_error').html('Please enter a valid URL.');
            $('#preview_input').focus();
        }
    }
    if ((fieldvalue != "") && (fieldType == 5)) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(fieldvalue)) {
            $('.cf_error').html('Please enter a valid Email Id.');
            $('#preview_input').focus();
        }
    }
}

function customFieldPreviewClose() {
    $('.cf_field_item').removeClass("disable_cf_item");
    $('.new_custom_fld').hide();
    $('.cf_form').show();
    $('.cf_error').html('');
    $('.preview_exit').hide();
    $('.preview_div').hide();
    $('.preview_cf').show();
}

function isAllowedAdvancedCustomFields() {
    $.ajax({
        url: HTTP_ROOT + 'projects/isAllowedAdvancedCustomFields',
        type: 'POST',
        data: {
            'isAllow': 1
        },
        dataType: 'json',
        success: function(response) {
            if (response == '0') {
                $('#advancedCustomFieldBtn').hide();
                $('#exp_advCustomField_allow').hide();
            }
        }
    });
}
$(function() {
    checkProjFltSelect();
    $(".warning_circle_icon > .material-icons").click(function(e) {
        $(".manage_plan_setting").show();
        e.stopPropagation();
    });
    $(".manage_plan_setting").click(function(e) {
        e.stopPropagation();
    });
    $(document).click(function() {
        $(".manage_plan_setting").hide();
        $(".okey").click()
    });
    $(".okey").click(function() {
        $(".manage_plan_setting").hide();
    });
    $('#proj_prog_cnt').tipsy({
        gravity: 'w',
        fade: true
    });
});

function project_allfiltervalue(type) {
    if (arguments[1]) {
        var event = arguments[1];
        event.preventDefault();
        event.stopPropagation();
    }
    $('.dropdown_status').hide();
    $('#dropdown_menu_' + type + '_div').show();
    $('#dropdown_menu_' + type).show();
    var li_ldr = "<li><center><img src='" + HTTP_ROOT + "img/images/del.gif' alt='loading...' title='loading...'/><center></li>";
    $('#dropdown_menu_' + type).html(li_ldr);
    if (type == 'project_type') {
        $(".dropdown-menu").css('visibility', 'visible');
        $.post(HTTP_ROOT + "projects/ajax_project_type_flt", {
            'page': PAGE_NAME
        }, function(data) {
            if (data) {
                $('#dropdown_menu_project_type').show();
                $('#dropdown_menu_project_type').html(data);
                if (PAGE_NAME == 'manage') {
                    var project_type = localStorage.getItem('PROJECTMANAGETYPE');
                } else {
                    var project_type = localStorage.getItem('PROJECTTYPE');
                }
                var str = '';
                if (project_type != '' && project_type != null) {
                    var diyArr = JSON.parse(project_type);
                    for (var i = 0; i < diyArr.length; i++) {
                        var diyId = diyArr[i];
                        if (PAGE_NAME == 'manage') {
                            document.getElementById('dprojectmanageType_' + diyId).checked = true;
                        } else {
                            document.getElementById('dprojectType_' + diyId).checked = true;
                        }
                    }
                }
            }
        });
    } else if (type == 'project_sub_type') {
        $(".dropdown-menu").css('visibility', 'visible');
        $.post(HTTP_ROOT + "projects/ajax_project_subtype_flt", {}, function(data) {
            if (data) {
                $('#dropdown_menu_project_sub_type').html(data);
                var project_sub_type = localStorage.getItem('PROJECTSUBTYPE');
                if (project_sub_type != '' && project_sub_type != null) {
                    var dsArr = JSON.parse(project_sub_type);
                    for (var i = 0; i < dsArr.length; i++) {
                        var dsId = dsArr[i];
                        document.getElementById('tprojsubtype_' + dsId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'project_status') {
        $(".dropdown-menu").css('visibility', 'visible');
        $.post(HTTP_ROOT + "projects/ajax_project_status_flt", {
            "page": PAGE_NAME
        }, function(data) {
            if (data) {
                $('#dropdown_menu_project_status').html(data);
                if (PAGE_NAME == 'manage') {
                    var created_by = localStorage.getItem('PROJECTMANAGESTATUS');
                } else {
                    var created_by = localStorage.getItem('PROJECTSTATUS');
                }
                if (created_by != '' && created_by != null) {
                    var dpArr = JSON.parse(created_by);
                    for (var i = 0; i < dpArr.length; i++) {
                        var dpId = dpArr[i];
                        if (PAGE_NAME == 'manage') {
                            document.getElementById('dprojstatusmange_' + dpId).checked = true;
                        } else {
                            document.getElementById('dprojstatus_' + dpId).checked = true;
                        }
                    }
                }
            }
        });
    } else if (type == 'clients') {
        $(".dropdown-menu").css('visibility', 'visible');
        $.post(HTTP_ROOT + "projects/ajax_project_clients_flt", {}, function(data) {
            if (data) {
                $('#dropdown_menu_clients').html(data);
                var clients = localStorage.getItem('PROJECTCLIENTS');
                if (clients != '' && clients != null) {
                    var dcArr = JSON.parse(clients);
                    for (var i = 0; i < dcArr.length; i++) {
                        var dcId = dcArr[i];
                        document.getElementById('dclients_' + dcId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'project_manager') {
        $(".dropdown-menu").css('visibility', 'visible');
        $.post(HTTP_ROOT + "projects/ajax_project_project_manager_flt", {}, function(data) {
            if (data) {
                $('#dropdown_menu_project_manager').html(data);
                var project_manager = localStorage.getItem('PROJECTMANAGER');
                if (project_manager != '' && project_manager != null) {
                    var dcArr = JSON.parse(project_manager);
                    for (var i = 0; i < dcArr.length; i++) {
                        var dcId = dcArr[i];
                        document.getElementById('dproject_manager_' + dcId).checked = true;
                    }
                }
            }
        });
    } else if (type == 'project_start_date') {
        $(".dropdown-menu").css('visibility', 'visible');
        $('#dropdown_menu_project_start_date').html(tmpl("project_startdt_tmpl"));
        iniStDateFilter();
        var project_start_date = localStorage.getItem('PROJECTSTARTDATE');
        if (project_start_date != '' && project_start_date != null) {
            var dcArr = JSON.parse(project_start_date);
            for (var i = 0; i < dcArr.length; i++) {
                var dcId = dcArr[i];
                document.getElementById('prodate_' + dcId).checked = true;
            }
        }
    } else if (type == 'project_end_date') {
        $(".dropdown-menu").css('visibility', 'visible');
        $('#dropdown_menu_project_end_date').html(tmpl("project_enddt_tmpl"));
        iniStDateFilter();
        var project_end_date = localStorage.getItem('PROJECTENDDATE');
        if (project_end_date != '' && project_end_date != null) {
            var dcArr = JSON.parse(project_end_date);
            for (var i = 0; i < dcArr.length; i++) {
                var dcId = dcArr[i];
                document.getElementById('projdate_' + dcId).checked = true;
            }
        }
    }
}

function checkboxProjectType(id, typ, diyVal, diyLab) {
    var x = "";
    var totid = $("#totPtypId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
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
        var checkboxid = "dprojectType_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dprojectType_" + actArr[j];
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
        project_remember_filters('PROJECTTYPE', diyVal, diyLab);
        reloadtble();
        checkProjFltSelect();
    } else {
        project_common_reset_filter('project_type', diyVal, '', diyLab);
        reloadtble();
    }
}

function checkboxProjectStatus(id, typ, diyVal, diyLab) {
    var x = "";
    if (CONTROLLER != 'projects' && PAGE_NAME != 'manage') {
        var totid = $("#totprojstsId").val();
    } else if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
        var totid = $("#totprojstsmanageId").val();
    }
    var actArr = (totid !== undefined) ? JSON.parse(totid) : "";
    if (id == 'types_all') {} else {
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
    if (CONTROLLER !== 'projects' && PAGE_NAME !== 'manage') {
        for (var j = 0; j < actArr.length; j++) {
            var checkboxid = "dprojstatus_" + actArr[j];
            if (document.getElementById(checkboxid).checked == true) {
                var typeid = "dprojstatus_" + actArr[j];
                var typevalue = document.getElementById(typeid).value;
                x = typevalue + "-" + x;
            }
        }
    } else if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
        for (var j = 0; j < actArr.length; j++) {
            var checkboxid = "dprojstatusmange_" + actArr[j];
            if (document.getElementById(checkboxid).checked == true) {
                var typeid = "dprojstatusmange_" + actArr[j];
                var typevalue = document.getElementById(typeid).value;
                x = typevalue + "-" + x;
            }
        }
    }
    if (x == "") {
        var Diy = "all";
    } else {
        var Diy = x.substring(0, x.length - 1);
    }
    if ($("#" + id).is(':checked')) {
        if (CONTROLLER !== 'projects' && PAGE_NAME !== 'manage') {
            project_remember_filters('PROJECTSTATUS', diyVal, diyLab);
            reloadtble();
        } else if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
            project_remember_filters('PROJECTMANAGESTATUS', diyVal, diyLab);
        }
        checkProjFltSelect();
    } else {
        project_common_reset_filter('project_status', diyVal, '', diyLab);
        if (CONTROLLER != 'projects' && PAGE_NAME != 'manage') {
            reloadtble();
        }
    }
}

function checkboxProjectClients(id, typ, diyVal, diyLab) {
    var x = "";
    var totid = $("#totprojclntsId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
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
        var checkboxid = "dclients_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dclients_" + actArr[j];
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
        project_remember_filters('PROJECTCLIENTS', diyVal, diyLab);
        reloadtble();
        checkProjFltSelect();
    } else {
        project_common_reset_filter('project_clients', diyVal, '', diyLab);
        reloadtble();
    }
}

function checkboxProjectManager(id, typ, diyVal, diyLab) {
    var x = "";
    var totid = $("#totprojmngrId").val();
    var actArr = JSON.parse(totid);
    if (id == 'types_all') {} else {
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
        var checkboxid = "dproject_manager_" + actArr[j];
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "dproject_manager_" + actArr[j];
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
        project_remember_filters('PROJECTMANAGER', diyVal, diyLab);
        reloadtble();
        checkProjFltSelect();
    } else {
        project_common_reset_filter('project_manager', diyVal, '', diyLab);
        reloadtble();
    }
}

function projcheckboxDate(x, typ) {
    if (x && (!$('#prodate_' + x).is(':checked'))) {
        projcheckboxDate('', '');
        return false;
    }
    $('.pcbox_date').removeAttr('checked');
    if (x) {
        $('#prodate_' + x).attr('checked', 'checked');
    } else {
        $('#prodate_any').attr('checked', 'checked');
    }
    $('#proj_stfrm').val("");
    $('#proj_stto').val("");
    $('#procustom_date').hide();
    var sdtlbl = getdtlabel(x);
    project_remember_filters('PROJECTSTARTDATE', x, sdtlbl);
    reloadtble();
    checkProjFltSelect();
}

function projcheckboxcustom(id, cid, ctype) {
    if (ctype) {
        $('#' + cid).attr('checked', 'checked');
    } else {
        if (!$('#' + cid).is(":checked")) {
            $('.pcbox_date').removeAttr('checked');
            $('#prodate_any').prop('checked', true);
        } else {
            $('.pcbox_date').removeAttr('checked');
            $('#' + cid).prop('checked', true);
        }
    }
    if ($('#' + cid).is(':checked')) {
        $('#' + id).show();
        $('#' + cid).prop('checked', true);
    } else {
        $('#' + id).hide();
        $('#' + ctype + 'stfrm').val("");
        $('#' + ctype + 'stto').val("");
        projcheckboxDate('', '');
    }
}

function projendcheckboxDate(x, typ) {
    if (x && (!$('#projdate_' + x).is(':checked'))) {
        projendcheckboxDate('', '');
        return false;
    }
    $('.pjcbox_date').removeAttr('checked');
    if (x) {
        $('#projdate_' + x).attr('checked', 'checked');
    } else {
        $('#projdate_any').attr('checked', 'checked');
    }
    $('#proj_endfrm').val("");
    $('#proj_endto').val("");
    $('#proendcustom_date').hide();
    var sdtlbl = getdtlabel(x);
    project_remember_filters('PROJECTENDDATE', x, sdtlbl);
    reloadtble();
}

function projendcheckboxcustom(id, cid, ctype) {
    if (ctype) {
        $('#' + cid).attr('checked', 'checked');
    } else {
        if (!$('#' + cid).is(":checked")) {
            $('.pjcbox_date').removeAttr('checked');
            $('#projdate_any').prop('checked', true);
        } else {
            $('.pjcbox_date').removeAttr('checked');
            $('#' + cid).prop('checked', true);
        }
    }
    if ($('#' + cid).is(':checked')) {
        $('#' + id).show();
        $('#' + cid).prop('checked', true);
    } else {
        $('#' + id).hide();
        $('#' + ctype + 'endfrm').val("");
        $('#' + ctype + 'endto').val("");
        projendcheckboxDate('', '');
    }
}

function project_remember_filters(name, value, label) {
    if (name == 'reset') {
        if (value == 'all') {}
        localStorage.removeItem('PROJECTTYPE');
        localStorage.removeItem('PROJECTSTATUS');
        localStorage.removeItem('PROJECTCLIENTS');
        localStorage.removeItem('PROJECTMANAGER');
        localStorage.removeItem('PROJECTSTARTDATE');
        localStorage.removeItem('PROJECTENDDATE');
        if (value == 'all') {}
    } else if (value) {
        if (name == 'PROJECTTYPE') {
            var diyArr = new Array();
            var diyaArrLab = new Array();
            var project_type = localStorage.getItem('PROJECTTYPE');
            var project_type_label = localStorage.getItem('PROJECTTYPEVAL');
            if (project_type != '' && project_type != null) {
                diyArr = JSON.parse(project_type);
                diyaArrLab = JSON.parse(project_type_label);
                diyArr.push(value);
                diyaArrLab.push(label);
            } else {
                diyArr.push(value);
                diyaArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(diyArr));
            localStorage.setItem('PROJECTTYPEVAL', JSON.stringify(diyaArrLab));
            $('#grid-profitable-report').bootgrid('reload');
        } else if (name == 'PROJECTSTATUS') {
            var dpArr = new Array();
            var dpArrLab = new Array();
            var project_status = localStorage.getItem('PROJECTSTATUS');
            var project_status_label = localStorage.getItem('PROJECTSTATUSVAL');
            if (project_status != '' && project_status != null) {
                dpArr = JSON.parse(project_status);
                dpArrLab = JSON.parse(project_status_label);
                dpArr.push(value);
                dpArrLab.push(label);
            } else {
                dpArr.push(value);
                dpArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dpArr));
            localStorage.setItem('PROJECTSTATUSVAL', JSON.stringify(dpArrLab));
            $('#grid-profitable-report').bootgrid('reload');
        } else if (name == 'PROJECTMANAGESTATUS') {
            var dpArr = new Array();
            var dpArrLab = new Array();
            var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
            var project_status_label = localStorage.getItem('PROJECTMANAGESTATUSVAL');
            if (project_status != '' && project_status != null) {
                dpArr = JSON.parse(project_status);
                dpArrLab = JSON.parse(project_status_label);
                dpArr.push(value);
                dpArrLab.push(label);
            } else {
                dpArr.push(value);
                dpArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dpArr));
            localStorage.setItem('PROJECTMANAGESTATUSVAL', JSON.stringify(dpArrLab));
            $('#projectLoader').show();
            var param = '';
            var ptype = new Array();
            var client = new Array();
            var pm = new Array();
            var project_type = localStorage.getItem('PROJECTMANAGETYPE');
            ptype = JSON.parse(project_type);
            if (dpArr.length !== 0) {
                param += 'fil-type=' + dpArr.toString();
                dpArr = [];
            }
            if (project_type != '' && project_type != null) {
                param += '&proj-type=' + ptype.toString();
                ptype = [];
            }
            window.location = HTTP_ROOT + 'projects/manage?' + param;
        } else if (name == 'PROJECTMANAGETYPE') {
            var dpArr = new Array();
            var dpArrLab = new Array();
            var project_type = localStorage.getItem('PROJECTMANAGETYPE');
            var project_type_label = localStorage.getItem('PROJECTMANAGETYPEVAL');
            if (project_type != '' && project_type != null) {
                dpArr = JSON.parse(project_type);
                dpArrLab = JSON.parse(project_type_label);
                dpArr.push(value);
                dpArrLab.push(label);
            } else {
                dpArr.push(value);
                dpArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dpArr));
            localStorage.setItem('PROJECTMANAGETYPEVAL', JSON.stringify(dpArrLab));
            $('#projectLoader').show();
            var param = '';
            var clientArr = new Array();
            var psArr = new Array();
            var pmArr = new Array();
            var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
            psArr = JSON.parse(project_status);
            if (dpArr.length != 0) {
                param += 'proj-type=' + dpArr.toString();
                dpArr = [];
            }
            if (project_status != '' && project_status != null) {
                param += '&fil-type=' + psArr.toString();
                psArr = [];
            }
            window.location = HTTP_ROOT + 'projects/manage?' + param;
        } else if (name == 'PROJECTCLIENTS') {
            var dcArr = new Array();
            var dcArrLab = new Array();
            var project_clients = localStorage.getItem('PROJECTCLIENTS');
            var project_clients_label = localStorage.getItem('PROJECTCLIENTSVAL');
            if (project_clients != '' && project_clients != null) {
                dcArr = JSON.parse(project_clients);
                dcArrLab = JSON.parse(project_clients_label);
                dcArr.push(value);
                dcArrLab.push(label);
            } else {
                dcArr.push(value);
                dcArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dcArr));
            localStorage.setItem('PROJECTCLIENTSVAL', JSON.stringify(dcArrLab));
            $('#grid-profitable-report').bootgrid('reload');
        } else if (name == 'PROJECTMANAGER') {
            var dsArr = new Array();
            var dsArrLab = new Array();
            var project_manager = localStorage.getItem('PROJECTMANAGER');
            var project_manager_label = localStorage.getItem('PROJECTMANAGERVAL');
            if (project_manager != '' && project_manager != null) {
                dsArr = JSON.parse(project_manager);
                dsArrLab = JSON.parse(project_manager_label);
                dsArr.push(value);
                dsArrLab.push(label);
            } else {
                dsArr.push(value);
                dsArrLab.push(label);
            }
            localStorage.setItem(name, JSON.stringify(dsArr));
            localStorage.setItem('PROJECTMANAGERVAL', JSON.stringify(dsArrLab));
            $('#grid-profitable-report').bootgrid('reload');
        } else if (name == 'PROJECTSTARTDATE') {
            var dusArr = new Array();
            var dusArrLab = new Array();
            var project_start_date = localStorage.getItem('PROJECTSTARTDATE');
            var project_start_date_label = localStorage.getItem('PROJECTSTARTDATEVAL');
            dusArr.push(value);
            dusArrLab.push(label);
            localStorage.setItem(name, JSON.stringify(dusArr));
            localStorage.setItem('PROJECTSTARTDATEVAL', JSON.stringify(dusArrLab));
            if (CONTROLLER != 'projects' && PAGE_NAME != 'manage') {
                $('#grid-profitable-report').bootgrid('reload');
            }
        } else if (name == 'PROJECTENDDATE') {
            var dusArr = new Array();
            var dusArrLab = new Array();
            var project_end_date = localStorage.getItem('PROJECTENDDATE');
            var project_end_date_label = localStorage.getItem('PROJECTENDDATEVAL');
            dusArr.push(value);
            dusArrLab.push(label);
            localStorage.setItem(name, JSON.stringify(dusArr));
            localStorage.setItem('PROJECTENDDATEVAL', JSON.stringify(dusArrLab));
            if (CONTROLLER != 'projects' && PAGE_NAME != 'manage') {
                $('#grid-profitable-report').bootgrid('reload');
            }
        } else {
            localStorage.setItem(name, value);
        }
    } else {
        localStorage.removeItem(name);
    }
}

function project_common_reset_filter(ftype, id, obj, label) {
    var param = '';
    var pmArr = new Array();
    var psArr = new Array();
    var cArr = new Array();
    if (ftype == 'project_type') {
        if (PAGE_NAME == "manage") {
            var project_type = localStorage.getItem('PROJECTMANAGETYPE');
            var project_type_lab = localStorage.getItem('PROJECTMANAGETYPEVAL');
        } else {
            var project_type = localStorage.getItem('PROJECTTYPE');
            var project_type_lab = localStorage.getItem('PROJECTTYPEVAL');
        }
        var str = '';
        if (project_type != '' && project_type != null) {
            var diyArr = JSON.parse(project_type);
            var diyArrLab = JSON.parse(project_type_lab);
            var y = jQuery.grep(diyArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(diyArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                if (PAGE_NAME == "manage") {
                    localStorage.setItem('PROJECTMANAGETYPE', JSON.stringify(y));
                    localStorage.setItem('PROJECTMANAGETYPEVAL', JSON.stringify(z));
                } else {
                    localStorage.setItem('PROJECTTYPE', JSON.stringify(y));
                    localStorage.setItem('PROJECTTYPEVAL', JSON.stringify(z));
                }
                if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                    checkProjFltSelect();
                    project_type = localStorage.getItem('PROJECTMANAGETYPE');
                    var diyArr = JSON.parse(project_type);
                    $('#projectLoader').show();
                    var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
                    psArr = JSON.parse(project_status);
                    if (diyArr.length !== 0) {
                        param += 'proj-type=' + diyArr.toString();
                        diyArr = [];
                    }
                    if (project_status != '' && project_status != null) {
                        param += '&fil-type=' + psArr.toString();
                        psArr = [];
                    }
                    window.location = HTTP_ROOT + 'projects/manage?' + param;
                }
                reloadtble();
                checkProjFltSelect();
            } else {
                if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                    localStorage.removeItem('PROJECTMANAGETYPE');
                    localStorage.removeItem('PROJECTMANAGETYPEVAL');
                    checkProjFltSelect();
                    var filters = new Object();
                    $('#projectLoader').show();
                    var param = '';
                    var pmArr = new Array();
                    var psArr = new Array();
                    var cArr = new Array();
                    var project_manager = localStorage.getItem('PROJECTMANAGER');
                    var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
                    var project_client = localStorage.getItem('PROJECTCLIENTS');
                    pmArr = JSON.parse(project_manager);
                    psArr = JSON.parse(project_status);
                    cArr = JSON.parse(project_client);
                    if (project_manager != '' && project_manager != null) {
                        filters['manager'] = pmArr.toString();
                    }
                    if (project_status != '' && project_status != null) {
                        filters['fil-type'] = psArr.toString();
                    }
                    if (project_client != '' && project_client != null) {
                        filters['client'] = cArr.toString();
                    }
                    var urlParam = [];
                    for (var i in filters) {
                        urlParam.push(encodeURI(i) + "=" + encodeURI(filters[i]));
                    }
                    window.location = HTTP_ROOT + 'projects/manage?' + urlParam.join("&");
                } else {
                    localStorage.removeItem('PROJECTTYPE');
                    localStorage.removeItem('PROJECTTYPEVAL');
                }
                reloadtble();
                checkProjFltSelect();
            }
        }
    }
    if (ftype == 'project_status') {
        if (PAGE_NAME == "manage") {
            var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
            var project_status_lab = localStorage.getItem('PROJECTMANAGESTATUSVAL');
        } else {
            var project_status = localStorage.getItem('PROJECTSTATUS');
            var project_status_lab = localStorage.getItem('PROJECTSTATUSVAL');
        }
        var str = '';
        if (project_status != '' && project_status != null) {
            var dpArr = JSON.parse(project_status);
            var dpArrLab = JSON.parse(project_status_lab);
            var y = jQuery.grep(dpArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dpArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                if (PAGE_NAME == "manage") {
                    localStorage.setItem('PROJECTMANAGESTATUS', JSON.stringify(y));
                    localStorage.setItem('PROJECTMANAGESTATUSVAL', JSON.stringify(z))
                } else {
                    localStorage.setItem('PROJECTSTATUS', JSON.stringify(y));
                    localStorage.setItem('PROJECTSTATUSVAL', JSON.stringify(z));
                }
                if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                    checkProjFltSelect();
                    project_status = localStorage.getItem('PROJECTMANAGESTATUS');
                    var dpArr = JSON.parse(project_status);
                    var project_manager = localStorage.getItem('PROJECTMANAGER');
                    var project_type = localStorage.getItem('PROJECTMANAGETYPE');
                    var project_client = localStorage.getItem('PROJECTCLIENTS');
                    pmArr = JSON.parse(project_manager);
                    ptArr = JSON.parse(project_type);
                    cArr = JSON.parse(project_client);
                    if (dpArr.length !== 0) {
                        param += 'fil-type=' + dpArr.toString();
                        dpArr = [];
                    }
                    if (project_type != '' && project_type != null) {
                        param += '&proj-type=' + ptArr.toString();
                        ptArr = [];
                    }
                    if (project_client != '' && project_client != null) {
                        param += '&client=' + cArr.toString();
                        cArr = [];
                    }
                    if (project_manager != '' && project_manager != null) {
                        param += '&manager=' + pmArr.toString();
                        pmArr = [];
                    }
                    window.location = HTTP_ROOT + 'projects/manage?' + param;
                }
                reloadtble();
                checkProjFltSelect();
            } else {
                if (CONTROLLER == 'projects' && PAGE_NAME == 'manage') {
                    localStorage.removeItem('PROJECTMANAGESTATUS');
                    localStorage.removeItem('PROJECTMANAGESTATUSVAL');
                    checkProjFltSelect();
                    var filters = new Object();
                    $('#projectLoader').show();
                    var project_manager = localStorage.getItem('PROJECTMANAGER');
                    var project_type = localStorage.getItem('PROJECTMANAGETYPE');
                    var project_client = localStorage.getItem('PROJECTCLIENTS');
                    pmArr = JSON.parse(project_manager);
                    psArr = JSON.parse(project_type);
                    cArr = JSON.parse(project_client);
                    if (project_manager != '' && project_manager != null) {
                        filters['manager'] = pmArr.toString();
                    }
                    if (project_type != '' && project_type != null) {
                        filters['proj-type'] = psArr.toString();
                    }
                    if (project_client != '' && project_client != null) {
                        filters['client'] = cArr.toString();
                    }
                    var urlParam = [];
                    for (var i in filters) {
                        urlParam.push(encodeURI(i) + "=" + encodeURI(filters[i]));
                    }
                    window.location = HTTP_ROOT + 'projects/manage?' + urlParam.join("&");
                } else {
                    localStorage.removeItem('PROJECTSTATUS');
                    localStorage.removeItem('PROJECTSTATUSVAL');
                }
                reloadtble();
                checkProjFltSelect();
            }
        }
    }
    if (ftype == 'project_clients') {
        var project_clients = localStorage.getItem('PROJECTCLIENTS');
        var project_clients_lab = localStorage.getItem('PROJECTCLIENTSVAL');
        var str = '';
        if (project_clients != '' && project_clients != null) {
            var dcArr = JSON.parse(project_clients);
            var dcArrLab = JSON.parse(project_clients_lab);
            var y = jQuery.grep(dcArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dcArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('PROJECTCLIENTS', JSON.stringify(y));
                localStorage.setItem('PROJECTCLIENTSVAL', JSON.stringify(z));
                checkProjFltSelect();
                reloadtble();
            } else {
                localStorage.removeItem('PROJECTCLIENTS');
                localStorage.removeItem('PROJECTCLIENTSVAL');
                checkProjFltSelect();
                reloadtble();
            }
        }
    }
    if (ftype == 'project_manager') {
        var project_manager = localStorage.getItem('PROJECTMANAGER');
        var project_manager_lab = localStorage.getItem('PROJECTMANAGERVAL');
        var str = '';
        if (project_manager != '' && project_manager != null) {
            var dsArr = JSON.parse(project_manager);
            var dsArrLab = JSON.parse(project_manager_lab);
            var y = jQuery.grep(dsArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dsArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('PROJECTMANAGER', JSON.stringify(y));
                localStorage.setItem('PROJECTMANAGERVAL', JSON.stringify(z));
                reloadtble();
                checkProjFltSelect();
            } else {
                localStorage.removeItem('PROJECTMANAGER');
                localStorage.removeItem('PROJECTMANAGERVAL');
                reloadtble();
                checkProjFltSelect();
            }
        }
    }
    if (ftype == 'project_start_date') {
        var project_start_date = localStorage.getItem('PROJECTSTARTDATE');
        var project_start_date_lab = localStorage.getItem('PROJECTSTARTDATEVAL');
        var str = '';
        if (project_start_date != '' && project_start_date != null) {
            var dsArr = JSON.parse(project_start_date);
            var dsArrLab = JSON.parse(project_start_date_lab);
            var y = jQuery.grep(dsArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dsArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('PROJECTSTARTDATE', JSON.stringify(y));
                localStorage.setItem('PROJECTSTARTDATEVAL', JSON.stringify(z));
                checkProjFltSelect();
                reloadtble();
            } else {
                localStorage.removeItem('PROJECTSTARTDATE');
                localStorage.removeItem('PROJECTSTARTDATEVAL');
                checkProjFltSelect();
                reloadtble();
            }
        }
    }
    if (ftype == 'project_end_date') {
        var project_end_date = localStorage.getItem('PROJECTENDDATE');
        var project_end_date_lab = localStorage.getItem('PROJECTENDDATEVAL');
        var str = '';
        if (project_end_date != '' && project_end_date != null) {
            var dsArr = JSON.parse(project_end_date);
            var dsArrLab = JSON.parse(project_end_date_lab);
            var y = jQuery.grep(dsArr, function(value) {
                return value != id;
            });
            var z = jQuery.grep(dsArrLab, function(labVal) {
                return labVal != label;
            });
            if (y.length > 0) {
                localStorage.setItem('PROJECTENDDATE', JSON.stringify(y));
                localStorage.setItem('PROJECTENDDATEVAL', JSON.stringify(z));
                reloadtble();
            } else {
                localStorage.removeItem('PROJECTENDDATE');
                localStorage.removeItem('PROJECTENDDATEVAL');
                reloadtble();
            }
        }
    }
}

function getdtlabel(dt) {
    if (dt != '') {
        var retval = "";
        if (dt == 'one') {
            retval = "Past hour";
        } else if (dt == '24') {
            retval = "Past 24Hour";
        } else if (dt == 'week') {
            retval = "Past Week";
        } else if (dt == 'month') {
            retval = "Past month";
        } else if (dt == 'year') {
            retval = "Past Year";
        }
        return retval;
    }
}

function reloadtble() {
    if (CONTROLLER != 'projects' && PAGE_NAME != 'manage') {
        $('#grid-profitable-report').bootgrid('reload');
    }
}

function iniStDateFilter() {
    var date_format = 'd M, yy';
    $("#proj_stfrm").datepicker({
        dateFormat: date_format,
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        onClose: function(selectedDate) {
            $("#proj_stto").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#proj_stto").datepicker({
        dateFormat: date_format,
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        onClose: function(selectedDate) {
            $("#proj_stfrm").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#proj_endfrm").datepicker({
        dateFormat: date_format,
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        onClose: function(selectedDate) {
            $("#proj_endto").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#proj_endto").datepicker({
        dateFormat: date_format,
        todayHighlight: true,
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        onClose: function(selectedDate) {
            $("#proj_endfrm").datepicker("option", "maxDate", selectedDate);
        }
    });
    $("#ui-datepicker-div").click(function(e) {
        e.stopPropagation();
    });
}

function projcheckboxrange() {
    var start_date = document.getElementById('proj_stfrm');
    var end_date = document.getElementById('proj_stto');
    var errMsg;
    var done = 1;
    if (start_date.value.trim() == "") {
        errMsg = _("From Date cannot be left blank!");
        start_date.focus();
        done = 5;
    } else if (end_date.value.trim() == "") {
        errMsg = _("To Date cannot be left blank!");
        end_date.focus();
        done = 5;
    } else if (Date.parse(start_date.value) > Date.parse(end_date.value)) {
        errMsg = _("From Date cannot exceed To Date!");
        end_date.focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        return false;
    } else if (done == 5) {
        return false;
    } else {
        var from = document.getElementById('proj_stfrm').value;
        var to = document.getElementById('proj_stto').value;
        document.getElementById('prodate_24').checked = false;
        document.getElementById('prodate_week').checked = false;
        document.getElementById('prodate_month').checked = false;
        document.getElementById('prodate_year').checked = false;
        var x = from + ":" + to;
        project_remember_filters('PROJECTSTARTDATE', x, x);
        reloadtble();
    }
}

function projendcheckboxrange() {
    var start_date = document.getElementById('proj_endfrm');
    var end_date = document.getElementById('proj_endto');
    var errMsg;
    var done = 1;
    if (start_date.value.trim() == "") {
        errMsg = _("From Date cannot be left blank!");
        start_date.focus();
        done = 5;
    } else if (end_date.value.trim() == "") {
        errMsg = _("To Date cannot be left blank!");
        end_date.focus();
        done = 5;
    } else if (Date.parse(start_date.value) > Date.parse(end_date.value)) {
        errMsg = _("From Date cannot exceed To Date!");
        end_date.focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        return false;
    } else if (done == 5) {
        return false;
    } else {
        var from = document.getElementById('proj_endfrm').value;
        var to = document.getElementById('proj_endto').value;
        document.getElementById('projdate_24').checked = false;
        document.getElementById('projdate_week').checked = false;
        document.getElementById('projdate_month').checked = false;
        document.getElementById('projdate_year').checked = false;
        var x = from + ":" + to;
        project_remember_filters('PROJECTENDDATE', x, x);
        reloadtble();
        checkProjFltSelect();
    }
}

function checkProjFltSelect() {
    if (CONTROLLER !== 'projects' && PAGE_NAME !== 'manage') {
        var project_type = localStorage.getItem('PROJECTTYPE');
        var project_status = localStorage.getItem('PROJECTSTATUS');
        var project_clients = localStorage.getItem('PROJECTCLIENTS');
        var project_manager = localStorage.getItem('PROJECTMANAGER');
    } else {
        var project_status = localStorage.getItem('PROJECTMANAGESTATUS');
        var project_type = localStorage.getItem('PROJECTMANAGETYPE');
    }
    var project_start_date = localStorage.getItem('PROJECTSTARTDATE');
    var project_end_date = localStorage.getItem('PROJECTENDDATE');
    var str = '';
    if (project_type != '' && project_type != null) {
        if (CONTROLLER !== 'projects' && PAGE_NAME !== 'manage') {
            var project_type_lab = localStorage.getItem('PROJECTTYPEVAL');
        } else {
            var project_type_lab = localStorage.getItem('PROJECTMANAGETYPEVAL');
        }
        $("#tckt_reset_btn").show();
        var diyArr = JSON.parse(project_type);
        var diyArrLab = JSON.parse(project_type_lab);
        for (var i = 0; i < diyArr.length; i++) {
            var diyId = diyArr[i]
            var diyLabel = diyArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Project Type' style='margin-right:5px'>" + diyLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_type\",\"" + diyArr[i] + "\",this,\"" + diyLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (project_start_date != '' && project_start_date != null) {
        var project_start_date_lab = localStorage.getItem('PROJECTSTARTDATEVAL');
        $("#tckt_reset_btn").show();
        var dpArr = JSON.parse(project_start_date);
        var dpArrLab = JSON.parse(project_start_date_lab);
        for (var i = 0; i < dpArr.length; i++) {
            var dpId = dpArr[i]
            var dpLabel = dpArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Project Start date' >" + dpLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_start_date\",\"" + dpArr[i] + "\",this,\"" + dpLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (project_clients != '' && project_clients != null) {
        var project_clients_lab = localStorage.getItem('PROJECTCLIENTSVAL');
        $("#tckt_reset_btn").show();
        var dcArr = JSON.parse(project_clients);
        var dcArrLab = JSON.parse(project_clients_lab);
        for (var i = 0; i < dcArr.length; i++) {
            var dcId = dcArr[i]
            var dcLabel = dcArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Clients' >" + dcLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_clients\",\"" + dcArr[i] + "\",this,\"" + dcLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (project_manager != '' && project_manager != null) {
        var project_manager_lab = localStorage.getItem('PROJECTMANAGERVAL');
        $("#def_reset_btn").show();
        var dsArr = JSON.parse(project_manager);
        var dsArrLab = JSON.parse(project_manager_lab);
        for (var i = 0; i < dsArr.length; i++) {
            var dsId = dsArr[i]
            var dsLabel = dsArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Project Manager' >" + dsLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_manager\",\"" + dsArr[i] + "\",this,\"" + dsLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (project_status != '' && project_status != null) {
        if (CONTROLLER !== 'projects' && PAGE_NAME !== 'manage') {
            var project_status_lab = localStorage.getItem('PROJECTSTATUSVAL');
        } else {
            var project_status_lab = localStorage.getItem('PROJECTMANAGESTATUSVAL');
        }
        $("#tckt_reset_btn").show();
        var dpArr = JSON.parse(project_status);
        var dpArrLab = JSON.parse(project_status_lab);
        for (var i = 0; i < dpArr.length; i++) {
            var dpId = dpArr[i]
            var dpLabel = dpArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Status' >" + dpLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_status\",\"" + dpArr[i] + "\",this,\"" + dpLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (project_end_date != '' && project_end_date != null) {
        var project_end_date_lab = localStorage.getItem('PROJECTENDDATEVAL');
        $("#tckt_reset_btn").show();
        var dpArr = JSON.parse(project_end_date);
        var dpArrLab = JSON.parse(project_end_date_lab);
        for (var i = 0; i < dpArr.length; i++) {
            var dpId = dpArr[i]
            var dpLabel = dpArrLab[i];
            str += "<div class='fl filter_opn' rel='tooltip' title='Project End date' >" + dpLabel + "<a href='javascript:void(0);' onclick='project_common_reset_filter(\"project_end_date\",\"" + dpArr[i] + "\",this,\"" + dpLabel + "\");' class='fr'>X</a></div>";
        }
    }
    if (str != '') {
        $("#proj_filtered_items").html(str);
        $("#proj_filtered_items").show();
    } else {
        $("#proj_filtered_items").html('');
        $("#proj_filtered_items").hide();
    }
}

function loadBookmark() {
    $.ajax({
        url: HTTP_ROOT + 'bookmarks/bookmarksList/',
        type: 'POST',
        dataType: 'html',
        data: {
            list: 1
        },
        success: function(res) {
            $("#ajaxBookmarksList").html(res);
        }
    });
}
function openTab(tab) {
    if (tab == 1) {
        $("#tab-checkList").trigger("click");
    } else if (tab == 2) {
        $("#tab-subTask").trigger("click");
    } else if (tab == 3) {
        $("#tab-taskLink").trigger("click");
    } else if (tab == 4) {
        $("#tab-reminders").trigger("click");
    }
}

function show_hide_tab(obj) {
    var casId = $(obj).attr('data-id');
    var tab_name = $(obj).attr('data-tab');
    var csuniqId = $(obj).attr('data-case_uid');
    var is_active_case = $(obj).attr('data-active');
    if (tab_name == "tab-subTask") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").show();
        $("#timelog_items").hide();
        $("#overview_items").hide();
        $("#file_items").hide();
        $("#bugs_items").hide();
        $("#comment_items").hide();
        $("#integration_items").hide();
        showSubtaskList(csuniqId, is_active_case);
    } else if (tab_name == "tab-timeLog") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").show();
        $("#overview_items").hide();
        $("#file_items").hide();
        $("#bugs_items").hide();
        $("#comment_items").hide();
        $("#integration_items").hide();
        showTimeLogList(csuniqId, is_active_case);
    } else if (tab_name == "tab-overView") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").hide();
        $("#overview_items").show();
        $("#file_items").hide();
        $("#bugs_items").hide();
        $("#comment_items").hide();
        $("#integration_items").hide();
    } else if (tab_name == "tab-files") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").hide();
        $("#overview_items").hide();
        $("#file_items").show();
        $("#bugs_items").hide();
        $("#comment_items").hide();
        $("#integration_items").hide();
    } else if (tab_name == "tab-bugs") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").hide();
        $("#overview_items").hide();
        $("#file_items").hide();
        $("#bugs_items").show();
        $("#comment_items").hide();
        $("#integration_items").hide();
    } else if (tab_name == "tab-comments") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").hide();
        $("#overview_items").hide();
        $("#file_items").hide();
        $("#bugs_items").hide();
        $("#comment_items").show();
        easycase.loadTinyMce(casId);
        $("#integration_items").hide();
    } else if (tab_name == "tab-integrations") {
        $('.upper').removeClass('active');
        $(obj).addClass('active');
        $("#subtask_items").hide();
        $("#timelog_items").hide();
        $("#overview_items").hide();
        $("#file_items").hide();
        $("#bugs_items").hide();
        $("#comment_items").hide();
        $("#integration_items").show();
    }
}

function show_hide_lower_tab(obj) {
    var casId = $(obj).attr('data-id');
    var tab_name = $(obj).attr('data-tab');
    var csuniqId = $(obj).attr('data-case_uid');
    if (tab_name == "tab-reminders") {
        $('.lower').removeClass('active');
        $(obj).addClass('active');
        $("#activitylog_items").hide();
        $("#checklist_items").hide();
        $("#tasklink_items").hide();
        $("#reminder_items").show();
    } else if (tab_name == "tab-taskLink") {
        $('.lower').removeClass('active');
        $(obj).addClass('active');
        $("#activitylog_items").hide();
        $("#checklist_items").hide();
        $("#tasklink_items").show();
        $("#reminder_items").hide();
    } else if (tab_name == "tab-activity") {
        $('.lower').removeClass('active');
        $(obj).addClass('active');
        $("#activitylog_items").show();
        $("#checklist_items").hide();
        $("#tasklink_items").hide();
        $("#reminder_items").hide();
    } else if (tab_name == "tab-checkList") {
        $('.lower').removeClass('active');
        $(obj).addClass('active');
        $("#activitylog_items").hide();
        $("#checklist_items").show();
        $("#tasklink_items").hide();
        $("#reminder_items").hide();
    }
}

function showTaskdetailItems() {}

function fetchFilesTskDtl(obj) {
    var caseUniqId = $(obj).attr('data-case_uid');
    var is_active_case = $(obj).attr('data-active');
    var strUrl = HTTP_ROOT + "easycases/ajaXFetchAllFiles";
    $('#caseLoaderPopupKB').show();
    $.post(strUrl, {
        "caseUniqId": caseUniqId,
        "is_active_case": is_active_case
    }, function(data) {
        $('#caseLoaderPopupKB').hide();
        if (data) {
            $("#tskDtlFiles").html(tmpl("fetchFilesTskDtlTmpl", data));
        }
    }, "json");
}

function showMoreActivityTsk(caseUniqId) {
    var strUrl = HTTP_ROOT + "easycases/ajaXFetchAllActivity";
    $.post(strUrl, {
        "caseUniqId": caseUniqId,
        "limit": "more",
    }, function(data) {
        if (data) {
            $("#case_activity_task_dtlpop").html(tmpl("fetchAllActivityTskTmpl", data));
            $('#show_more_less_bun_act1').hide();
            $('#show_more_less_bun_act2').show();
        }
    }, "json");
}

function showLessActivity(obj) {
    var caseUniqId = $(obj).attr("data-uid");
    var strUrl = HTTP_ROOT + "easycases/ajaXFetchAllActivity";
    $.post(strUrl, {
        "caseUniqId": caseUniqId,
        "limit": "less",
    }, function(data) {
        if (data) {
            $("#case_activity_task_dtlpop").html(tmpl("fetchAllActivityTskTmpl", data));
            $('#show_more_less_bun_act1').show();
            $('#show_more_less_bun_act2').hide()
        }
    }, "json");
}

function fetchActivityTsk(obj) {
    var caseUniqId = $(obj).attr('data-case_uid');
    var strUrl = HTTP_ROOT + "easycases/ajaXFetchAllActivity";
    $.post(strUrl, {
        "caseUniqId": caseUniqId,
    }, function(data) {
        if (data) {
            $("#case_activity_task_dtlpop").html(tmpl("fetchAllActivityTskTmpl", data));
        }
    }, "json");
}
function openDueDateDrpDwn() {
    $('.cmn_h_det_arrow').removeClass('open');
    $('div[id^="more_opt80"]').find('ul').hide();
    $('div[id^="more_opt20"]').find('ul').hide();
}
function showTimeLogList(taskUniqId, is_active_case) {
    $('#caseLoaderPopupKB').show();
    $.post(HTTP_ROOT + "requests/ajaxShowTimeLogList", {
        'taskUniqId': taskUniqId,
        'is_active_case': is_active_case
    }, function(res) {
        $('#caseLoaderPopupKB').hide();
        $("#reply_time_log" + taskUniqId).html(tmpl("case_timelog_load_tmpl", res));
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
    }, 'json');
}
function caseGitToggleDiv(classname) {
    var obj = classname + "_id";
    if ($('.' + classname).hasClass('gitDivClose')) {
        if ($('#' + obj).hasClass('selected')) {
            $('#' + obj).removeClass('selected');
        } else {
            $('#' + obj).removeClass('selected');
            $('#' + obj).addClass('selected');
        }
        $('.' + classname).removeClass('gitDivClose');
        $('.' + classname).addClass('gitDivOpen');
    } else if ($('.' + classname).hasClass('gitDivOpen')) {
        if ($('#' + obj).hasClass('selected')) {
            $('#' + obj).removeClass('selected');
        } else {
            $('#' + obj).removeClass('selected');
            $('#' + obj).addClass('selected');
        }
        $('.' + classname).removeClass('gitDivOpen');
        $('.' + classname).addClass('gitDivClose');
    }
}
function eventTrack() {
    var user = "<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>";
    trackEventLeadTracker('Personal Settings', 'Github Connect', user);
    window.location = HTTP_ROOT + 'github/gitconnect';
}