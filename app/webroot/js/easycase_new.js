$(document).ready(function() {
    $(".dropdown-menu").click(function(event) {
        event.stopPropagation();
    });
    $(".dropdown-menu").click(function(event) {
        event.stopPropagation();
    });
    $(document).on("click", '[id^="titlehtml"],.titlehtml', function() {
        var prjunid = $("#projFil").val();
        setSessionStorage("Task Details Page", "Reply Task");
        var task_data = $(this).attr("data-task").split("|");
        var caseUniqId = task_data[0];
        var params = parseUrlHash(urlHash);
        if (params == "timelog") {
            $("#caseMenuFilters").val("timelog");
        }
        if (typeof params[0] != "undefined" && params[0] == "caselist") {
            window.location.href = HTTP_ROOT + "dashboard#details/" + caseUniqId;
        } else {
            if ($("#caseMenuFilters").val().trim() == "kanban" && !params[1]) {
                $("#caseMenuFilters").val("kanban_only");
            }
        }
        if ($("#saveFilter").is(":visible")) {
            localStorage.setItem("is_saveFilter_set", 1);
        }
        if (params[0] == "timelog" || params == "kanban" || params == "milestonelist" || (typeof params[0] != "undefined" && params[0] == "kanban" && typeof params[1] != "undefined") || params == "activesprint" || params == "backlog" || parseInt($("#subtask-container").height()) > 70 || (params[0] == "tasks" || params[0] == "taskgroup") || params[0] == "taskgroups" || PAGE_NAME == "resource_availability") {
            $("#myModalDetail").modal();
            $(".task_details_popup").show();
            $(".task_details_popup").find(".modal-body").height($(window).height() - 170);
            $("#cnt_task_detail_kb").html("");
            if ($(this).attr("data-task-from") && $(this).attr("data-task-from") == "linkSection") {
                localStorage.setItem("iscomingfromlinksection", "1");
            } else {
                localStorage.setItem("iscomingfromlinksection", "2");
            }
            easycase.ajaxCaseDetails(caseUniqId, "case", 0, "popup");
        } else {
            localStorage.setItem("iscomingfromlinksection", "2");
            $("#cnt_task_detail_kb").html("");
            if (prjunid == "all") {
                window.location.hash = "details/" + caseUniqId;
            } else {
                window.location.hash = "details/" + caseUniqId;
            }
        }
    });
    $(document).on("click", '[id^="kanbancasecount"]', function() {
        var task_data = $(this).attr("data-task").split("|");
        var caseUniqId = task_data[0];
        openPopup();
        $(".loader_dv_prj").show();
        $("#kanbanViewMain").show();
        if (caseUniqId != "") {
            var params = {
                uid: caseUniqId
            };
            $.post(HTTP_ROOT + "easycases/kanbanview_comments", {
                data: params
            }, function(res) {
                $("#kanbanViewMain").html(res);
                $(".loader_dv_prj").hide();
            });
        }
    });
    $(document).on("click", '[id^="casecount"]', function() {
        var task_data = $(this).attr("data-task").split("|");
        var caseUniqId = task_data[0];
        $("#latestComment" + caseUniqId).find(".showDependents").toggleClass("open ");
        $("#commentTable" + caseUniqId).find("tr:gt(0)").hide();
        $("#commentLoaderId" + caseUniqId).show();
        if (caseUniqId != "") {
            var params = {
                uid: caseUniqId
            };
            $.ajax({
                url: HTTP_ROOT + "easycases/view_comments",
                dataType: "json",
                type: "POST",
                data: params,
                success: function(res) {
                    $("#commentTable" + caseUniqId).find("tr:gt(0)").remove();
                    if (res.length > 0) {
                        var count = 0;
                        $("#commentLoaderId" + caseUniqId).hide();
                        var str = "<tr><th>" + _("Comment") + "</th><th>" + _("User Name") + "</th><th>" + _("Date") + " / " + _("Time") + "</th></tr>";
                        $.each(res, function(key, val) {
                            str = str + "<tr><td>" + val.comment + "</td><td>" + val.username + "</td><td>" + val.date_time + "</td></tr>";
                            count = val.count;
                        });
                        if (count > 5) {
                            str = str + "<tr><th></th><th></th><th><a href='javascript:void(0);' onclick='viewMore(/" + caseUniqId + "/)'>" + _("View More") + "</a></th></tr>";
                        }
                    }
                    $("#commentTable" + caseUniqId).append(str);
                },
            });
        }
        return false;
        window.location.hash = "details/" + caseUniqId;
    });
    $(document).on("click", '[id^="act_reply"]', function() {
        var task_data = $(this).attr("data-task").split("|");
        var caseUniqId = task_data[0];
        $("#myModalDetail").modal();
        $(".task_details_popup").show();
        $(".task_details_popup").find(".modal-body").height($(window).height() - 170);
        $("#cnt_task_detail_kb").html("");
        scrollToRep = caseUniqId;
        var page_refer = $(this).attr("page-refer-val");
        setSessionStorage(page_refer, "Reply Task");
        easycase.ajaxCaseDetails(caseUniqId, 'case', 0, 'popup');
    });
    $(document).on("click", ".task_detail_back", function(event) {
        event.stopPropagation();
        var params = parseUrlHash(urlHash);
        if ($(".hopscotch-bubble-close").length) {
            $(".hopscotch-bubble-close").click();
        }
        if (typeof GBl_tour != "undefined") {
            GBl_tour = tour;
        }
        if ($(".ststd").find("span").text() == "Archived") {
            window.location = HTTP_ROOT + "archives/listall/#caselist";
        } else {
            if ($("#caseMenuFilters").val() == "kanban_only") {
                window.location.hash = "kanban";
                easycase.showKanbanTaskList();
            } else if ($("#caseMenuFilters").val() == "kanban") {
                if (params[0] == "kanban") {
                    if ($("#refMilestone").val() == "milestone") {
                        window.location.hash = "milestonelist";
                    } else {
                        window.location.hash = $("#refMilestone").val();
                    }
                } else {
                    var mid = $("#Case_mislestone_id_" + params[1]).val().trim();
                    window.location.hash = "kanban/" + mid;
                }
            } else if ($("#caseMenuFilters").val() == "activities") {
                window.location.hash = "activities";
            } else if ($("#caseMenuFilters").val() == "milestonelist") {
                window.location.hash = "milestonelist";
            } else if ($("#caseMenuFilters").val() == "calendar") {
                window.location.hash = "calendar";
            } else if ($("#caseMenuFilters").val() == "timelog") {
                window.location.hash = "timelog";
            } else if ($("#caseMenuFilters").val() == "subtask") {
                window.location.hash = "subtask";
                checkHashLoad("timelog");
            } else if ($("#caseMenuFilters").val() == "assigntome") {
                window.location.hash = "tasks/assigntome";
            } else if ($("#caseMenuFilters").val() == "favourite") {
                window.location.hash = "tasks/favourite";
            } else if ($("#caseMenuFilters").val() == "overdue") {
                window.location.hash = "tasks/overdue";
            } else if ($("#caseMenuFilters").val() == "deligateto") {
                window.location.hash = "tasks/deligateto";
            } else if ($("#caseMenuFilters").val() == "highpriority") {
                window.location.hash = "tasks/highpriority";
            } else if ($("#caseMenuFilters").val() == "openedtasks") {
                window.location.hash = "tasks/openedtasks";
            } else if ($("#caseMenuFilters").val() == "closedtasks") {
                window.location.hash = "tasks/closedtasks";
            } else {
                window.location.hash = "tasks";
            }
        }
    });
    $(document).on("click", ".milestonekb_detail_head", function() {
        refreshKanbanTask = 1;
        return false;
    });
    $("img.lazy").lazyload({
        placeholder: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
    });
});

function replyFromKanban(obj) {
    var task_data = $(obj).attr("data-task").split("|");
    var caseUniqId = task_data[0];
    scrollToRep = caseUniqId;
    $("#myModalDetail").modal();
    $(".task_details_popup").show();
    $(".task_details_popup").find(".modal-body").height($(window).height() - 50);
    $("#cnt_task_detail_kb").html("");
    easycase.ajaxCaseDetails(caseUniqId, "case", 0, "popup");
}

function setCustomStatus(arg, customid) {
    remember_filters("reset", "all");
    $("#dropdown_menu_all_filters").hide();
    $(".dropdown_status").hide();
    $(".case-filter-menu").css({
        position: "fixed"
    });
    casePage = 1;
    $("#case_srch").val("");
    $("#caseDateFil").val("");
    $("#casedueDateFil").val("");
    $.post(HTTP_ROOT + "easycases/setCustomStatus", {
        customfilter: customid
    }, function(data) {
        if (data) {
            $("#caseStatus").val(data.status);
            $("#priFil").val(data.priority);
            $("#caseTypes").val(data.type);
            $("#caseLabel").val(data.label);
            $("#caseMember").val(data.member);
            $("#caseComment").val(data.comment);
            $("#caseAssignTo").val(data.assignto);
            $("#caseDate").val(data.date);
            $("#caseDueDate").val(data.duedate);
            $("#widgethideshow").show();
            easycase.showTaskLists(arg);
            $("#customFil").addClass("open");
            $(".menu-files").removeClass("active");
            $(".menu-cases").removeClass("active");
            $(".allmenutab").removeClass("active");
            $(".more_menu_li").removeClass("active");
            if ($(".customFilter").html() == "") {
                openAjaxCustomFilter("auto", customid);
            } else {
                $(".customlink").removeClass("active");
                $("#lnkcustomFilterRow_" + customid).addClass("active");
                $("#deleteImg_" + customid).show();
            }
        }
    }, "json");
}

function loadCaseMenu(strURL, params, ispageload) {
    params.caseStatus = typeof localStorage["STATUS"] != "undefined" ? localStorage["STATUS"] : params.caseStatus;
    params.priFil = typeof localStorage["PRIORITY"] != "undefined" ? localStorage["PRIORITY"] : params.priFil;
    params.caseTypes = typeof localStorage["CS_TYPES"] != "undefined" ? localStorage["CS_TYPES"] : params.caseTypes;
    params.caseLabel = typeof localStorage["TASKLABEL"] != "undefined" ? localStorage["TASKLABEL"] : params.caseLabel;
    params.caseMember = typeof localStorage["MEMBERS"] != "undefined" ? localStorage["MEMBERS"] : params.caseMember;
    params.caseComment = typeof localStorage["COMMENTS"] != "undefined" ? localStorage["COMMENTS"] : params.caseComment;
    params.caseAssignTo = typeof localStorage["ASSIGNTO"] != "undefined" ? localStorage["ASSIGNTO"] : params.caseAssignTo;
    params.caseFavourite = typeof localStorage["FAVOURITE"] != "undefined" ? localStorage["FAVOURITE"] : params.caseFavourite;
    params.case_date = typeof localStorage["DATE"] != "undefined" ? localStorage["DATE"] : params.case_date;
    params.case_due_date = typeof localStorage["DUE_DATE"] != "undefined" ? localStorage["DUE_DATE"] : params.case_due_date;
    params.caseTaskgroup = typeof localStorage["TASKGROUP"] != "undefined" ? localStorage["TASKGROUP"] : params.caseTaskgroup;
    $("#caseStatus").val(params.caseStatus);
    $("#caseDateFil").val(params.case_date);
    $("#casedueDateFil").val(params.case_due_date);
    $("#caseTypes").val(params.caseTypes);
    $("#caseLabel").val(params.caseLabel);
    $("#caseMember").val(params.caseMember);
    $("#caseComment").val(params.caseComment);
    $("#caseAssignTo").val(params.caseAssignTo);
    $("#caseFavourite").val(params.caseFavourite);
    $("#caseTaskgroup").val(params.caseTaskgroup);
    $("#priFil").val(params.priFil);
    $.post(strURL, params, function(data) {
        if (data) {
            if (parseInt(data.caseNewOrg) >= 0) {
                $("#taskCnt,#kanban_taskCnt").html("(" + data.caseNewOrg + ")").show();
                $("#taskCnt,#kanban_taskCnt").attr("title", data.caseNewOrg + " Tasks");
                $("#tskTabAllCnt,#kanban_tskTabAllCnt").html(data.caseNewOrg);
            }
            if (parseInt(data.caseFiles) >= 0) {
                $("#fileCnt,#kanban_fileCnt").html(data.caseFiles).show();
                $("#fileCnt,#kanban_fileCnt").attr("title", data.caseFiles + " File");
            }
            if (parseInt(data.assignToMeOrg) >= 0) $("#tskTabMyCnt,#kanban_tskTabMyCnt").html(data.assignToMeOrg);
            if (parseInt(data.caseFavouriteOrg) >= 0) $("#tskTabFavCnt,#kanban_tskTabFavCnt").html(data.caseFavouriteOrg);
            if (parseInt(data.delegateToOrg) >= 0) $("#tskTabDegCnt,#kanban_tskTabDegCnt").html(data.delegateToOrg);
            if (parseInt(data.highPriOrg) >= 0) $("#tskTabHPriCnt,#kanban_tskTabHPriCnt").html(data.highPriOrg);
            if (parseInt(data.overdueOrg) >= 0) $("#tskTabOverdueCnt,#kanban_tskTabOverdueCnt").html(data.overdueOrg);
            if (parseInt(data.openedtasksOrg) >= 0) $("#tskTabOpenedcnt,#kanban_tskTabOpenedcnt").html(data.openedtasksOrg);
            if (parseInt(data.closedtasksOrg) >= 0) $("#tskTabClosedCnt,#kanban_tskTabClosedCnt").html(data.closedtasksOrg);
            if (parseInt(data.showDetails) == 1) {
                if ($("#caseMenuFilters").val() == "assigntome") $("#task_count_of").html(_("Displaying") + " <b>" + data.assignToMe + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "favourite") $("#task_count_of").html(_("Displaying") + " <b>" + data.caseFavourite + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "openedtasks") $("#task_count_of").html(_("Displaying") + " <b>" + data.openedtasks + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "overdue") $("#task_count_of").html(_("Displaying") + " <b>" + data.overdueOrg + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "delegateto") $("#task_count_of").html(_("Displaying") + " <b>" + data.delegateTo + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "highpriority") $("#task_count_of").html(_("Displaying") + " <b>" + data.highPri + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else if ($("#caseMenuFilters").val() == "closedtasks") $("#task_count_of").html(_("Displaying") + " <b>" + data.closedtasks + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                else {
                    if ((data.caseNew != data.caseNewOrg || (typeof localStorage.SEARCHFILTER != "undefined" && $.trim(localStorage.SEARCHFILTER) != "")) && data.showDetailsAll != "1") {
                        $("#task_count_of").html(_("Displaying") + " <b>" + data.caseNew + "</b> " + _("tasks out of") + " <b>" + data.caseNewOrg + "</b> " + _("tasks"));
                    } else {
                        $("#task_count_of").html(_("Displaying all tasks"));
                    }
                }
            }
            if (data.sf) {
                $(".filter-dropdown").hide();
                $("#ajaxViewFilters").find(".show_all_opt_in_listonly").remove();
                $("#ajaxViewFilters").append(tmpl("filterSearch_id_tmpl", data));
                $("#custom_filter_contain").html("");
                $("#custom_filter_contain").append(tmpl("filterSearch_id_tmpl_right", data));
                var uhas = getHash();
                if (typeof uhas != "undefined" && uhas.indexOf("tasks/") != -1) {
                    var sub_dmn = uhas.split("tasks/");
                    if ($.trim(sub_dmn[1]) != "") {
                        $(".only_set_activecls").each(function() {
                            if (this.href.indexOf(sub_dmn[1]) != -1) {
                                $(this).parent(".dtl_label_tag_tsk").addClass("active");
                            }
                        });
                    }
                }
                var val = "";
                val = $("a[data-tabkey='" + $("#caseMenuFilters").val() + "']").html();
                txt = $("<div>").html(val).find(".wrap_title_txt").text();
                var params = parseUrlHash(urlHash);
                var d_filters = ["cases", "closedtasks", "openedtasks", "highpriority", "delegateto", "overdue", "favourite", "assigntome"];
                if (typeof localStorage.SEARCHFILTER != "undefined" && localStorage.SEARCHFILTER != "" && localStorage.SEARCHFILTER.substring(0, 5) == "ftopt") {
                    if ($("#" + localStorage.SEARCHFILTER).length > 0 && $.inArray(params[1], d_filters) < 0) {
                        $(".filter-dropdown").show();
                        $(".filter-dropdown").find("button a").html($("#" + localStorage.SEARCHFILTER).html());
                        $(".filter-dropdown").find("button a").attr("title", $("#" + localStorage.SEARCHFILTER).find(".wrap_title_txt").html());
                        $(".filter-dropdown").find("button a").attr("data-placement", "left");
                        $("#" + localStorage.SEARCHFILTER).addClass("active_inner");
                    } else {
                        if ($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length) {
                            $(".filter-dropdown").show();
                            $(".filter-dropdown").find("button a").html($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more"));
                            $(".filter-dropdown").find("button a").attr("title", $("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more filters"));
                            setTabSelection();
                            localStorage.removeItem("SEARCHFILTER");
                        }
                    }
                } else if (val != "" && val != "undefined" && typeof val != "undefined") {
                    $(".filter-dropdown").show();
                    $(".filter-dropdown").find("button a").html(val);
                    $(".filter-dropdown").find("button a span").removeAttr("id");
                    $(".filter-dropdown").find("button a").attr("title", txt);
                    $("#filtered_items").html("");
                } else {
                    if ($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length) {
                        $(".filter-dropdown").show();
                        $(".filter-dropdown").find("button a").html($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more"));
                        $(".filter-dropdown").find("button a").attr("title", $("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more filters"));
                        setTabSelection();
                    }
                }
            } else {
                if ($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length) {
                    $(".filter-dropdown").show();
                    $(".filter-dropdown").find("button a").html($("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more"));
                    $(".filter-dropdown").find("button a").attr("title", $("#ajaxViewFilters").find("a:not(#manageFilterAnchor)").length + " " + _("more filters"));
                    setTabSelection();
                }
            }
            if (data.checkDefault <= 0 && params.pageload == 0 && typeof introJs != "undefined") {
                tourPluginObject = introJs();
                tourPluginObject.onchange(function(targetElement) {
                    if ($(targetElement).attr("data-step") == 4) {
                        $(".introjs-helperLayer").addClass("min-height");
                    }
                });
                tourPluginObject.start().oncomplete(function() {
                    saveFilterRecords();
                }).onexit(function() {
                    saveFilterRecords();
                });
            }
        }
    });
}

function getURLParameter(name) {
    return decodeURI((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, 0])[1]);
}

function resetBreadcrumbFilters(strURL, caseStatus1, caseCustomStatus1, priFil1, caseTypes1, caseMember1, caseComment1, caseAssignTo1, resetall1, case_date, case_due_date, casePage, caseSearch, clearCaseSearch, caseMenuFilters, milestoneIds, caseLabel, caseTaskgroup1) {
    var filterid = $('#customFIlterId').val();
    caseStatus1 = (typeof localStorage['STATUS'] != 'undefined') ? localStorage['STATUS'] : caseStatus1;
    caseCustomStatus1 = (typeof localStorage['CUSTOM_STATUS'] != 'undefined') ? localStorage['CUSTOM_STATUS'] : caseCustomStatus1;
    priFil1 = (typeof localStorage['PRIORITY'] != 'undefined') ? localStorage['PRIORITY'] : priFil1;
    caseTypes1 = (typeof localStorage['CS_TYPES'] != 'undefined') ? localStorage['CS_TYPES'] : caseTypes1;
    caseMember1 = (typeof localStorage['MEMBERS'] != 'undefined') ? localStorage['MEMBERS'] : caseMember1;
    caseComment1 = (typeof localStorage['COMMENTS'] != 'undefined') ? localStorage['COMMENTS'] : caseComment1;
    caseTaskgroup1 = (typeof localStorage['TASKGROUP'] != 'undefined') ? localStorage['TASKGROUP'] : caseTaskgroup1;
    caseAssignTo1 = (typeof localStorage['ASSIGNTO'] != 'undefined') ? localStorage['ASSIGNTO'] : caseAssignTo1;
    case_date = (typeof localStorage['DATE'] != 'undefined') ? localStorage['DATE'] : case_date;
    case_due_date = (typeof localStorage['DUE_DATE'] != 'undefined') ? localStorage['DUE_DATE'] : case_due_date;
    $.post(strURL + "ajax_common_breadcrumb", {
        "caseMember": caseMember1,
        "caseComment": caseComment1,
        "caseAssignTo": caseAssignTo1,
        "resetall": resetall1,
        "caseTypes": caseTypes1,
        "caseLabel": caseLabel,
        "caseStatus": caseStatus1,
        "caseCustomStatus": caseCustomStatus1,
        "casedate": case_date,
        'caseduedate': case_due_date,
        "priFil": priFil1,
        "casePage": casePage,
        'caseSearch': caseSearch,
        'clearCaseSearch': clearCaseSearch,
        'caseMenuFilters': caseMenuFilters,
        'milestoneIds': milestoneIds,
        'caseTaskgroup': caseTaskgroup1
    }, function(data) {
        $('#filtered_items,#filtered_items_subtask').show();
        if (data) {
            if (data.val) {
                $('#filtered_items,#filtered_items_subtask').show();
                $('.breadcrumb_div').css('height', '60px');
                $('#savereset_filter,#savereset_filter_subtask').css('display', 'table-cell');
            } else {
                $('#filtered_items,#filtered_items_subtask').hide();
                $('#savereset_filter,#savereset_filter_subtask').hide();
                $('.breadcrumb_div').css('height', '37px');
            }
            $('#filtered_items,#filtered_items_subtask').html('');
            if (data.case_assignto != 'All' && (caseAssignTo1 != 'All' && $.trim(caseAssignTo1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_assignto);
                $('#filtered_items').show();
            }
            if (data.duedate != 'Any Time' && (case_due_date != 'Any Time' && $.trim(case_due_date) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.duedate);
            }
            if (data.case_member != 'All' && (caseMember1 != 'All' && $.trim(caseMember1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_member);
            }
            if (data.case_comment != 'All' && (caseComment1 != 'All' && $.trim(caseComment1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_comment);
            }
            var gethash = getHash();
            if ((getHash() == 'kanban' && parseInt($("#subtask-container").height()) < 70) || gethash.indexOf("tasks") != -1) {
                if (data.case_taskgroup != 'All' && (caseTaskgroup1 != 'All' && $.trim(caseTaskgroup1) != '')) {
                    $('#filtered_items,#filtered_items_subtask').append(data.case_taskgroup);
                }
            }
            if (data.case_types != 'All' && (caseTypes1 != 'All' && $.trim(caseTypes1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_types);
            }
            if (data.case_label != 'All' && (caseLabel != 'All' && $.trim(caseLabel) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_label);
            }
            if (data.case_status != 'All' && (caseStatus1 != 'All' && $.trim(caseStatus1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_status);
            }
            if (data.case_custom_status != 'All' && (caseCustomStatus1 != 'All' && $.trim(caseCustomStatus1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_custom_status);
            }
            if (data.date != 'Any Time' && (case_date != 'Any Time' && $.trim(case_date) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.date);
            }
            if (data.pri != 'All' && (priFil1 != 'All' && $.trim(priFil1) != '')) {
                $('#filtered_items,#filtered_items_subtask').append(data.pri);
            }
            if (data.tasksortby) {
                $('#sortby_items').html(data.tasksortby);
            } else {
                $('#sortby_items').html('');
            }
            if (data.taskgroupby) {
                $('#groupby_items').html(data.taskgroupby);
            } else {
                $('#groupby_items').html('');
            }
            $('#not_assign').html(data.case_assignto);
            $('#not_mem').html(data.case_member);
            $('#not_type').html(data.case_types);
            $('#not_sts').html(data.case_status);
            $('#not_date').html(data.date);
            $('#not_pri').html(data.pri);
            if (data.search_case) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_search);
                $("#case_search").val(caseSearch);
            } else {
                $('#not_srch').html(" ");
            }
            clearSearchvis();
            if (data.page_case) {
                $('#filtered_items,#filtered_items_subtask').append(data.case_page);
            }
            if (data.val) {
                $('#reset_btn').show();
                if (filterid || ($('#filtered_items .filter_opn').length == 1 && casePage > 1)) {
                    $('#savefilter_btn').hide();
                    $('#or').hide();
                } else {
                    $('#savefilter_btn').show();
                    $('#or').show();
                }
                if (data.case_page) {
                    $('#case_page').html(data.case_page);
                } else {
                    $('#case_page').html('');
                }
                if (data.case_search) {
                    $('#search_txt_spn').html(data.case_search);
                    if ($.trim($("#hid_srch_text").val()) !== '') {
                        $("#closesrch").css('top', '0px');
                        $("#hid_srch_text").val('');
                    } else {
                        $("#closesrch").css('top', '-7px');
                    }
                    $("#closesrch").css('position', 'relative');
                    $('#closesrch').show();
                } else {
                    $('#search_txt_spn').html('');
                }
            } else {
                $('#reset_btn').hide();
                $('#or').hide();
                $('#savefilter_btn').hide();
                $('#search_txt_spn').html('');
                $('#case_page').html('');
            }
            if (data.mlstn !== 'All') {
                $('#filtered_items,#filtered_items_subtask').append(data.mlstn);
            }
            if (data.tskgrp != 'All') {
                $('#filtered_items,#filtered_items_subtask').append(data.tskgrp);
            }
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            if ($.trim($('#filtered_items').html()) == '') {
                $('#savereset_filter').hide();
            }
            if ($.trim($('#filtered_items_subtask').html()) == '') {
                $('#savereset_filter_subtask').hide();
            }
            if (getHash() != 'kanban') {
                checkFilterItemChanges();
                if ($.trim($('#filtered_items').html()) != '' && (typeof localStorage.SEARCHFILTER == 'undefined' || localStorage.SEARCHFILTER == '' || localStorage.SEARCHFILTER.substring(0, 5) != 'ftopt')) {
                    $("#saveFilter").show();
                    $("#saveFilter").html('<i class="material-icons">&#xE161;</i>');
                    $("#saveFilter").attr("Save Filter");
                } else {
                    $("#saveFilter").hide();
                }
            } else {
                getkanbanFilters();
            }
            $('#active_filter_contain').html($('.filter_det').html());
            if ($.trim($('#filtered_items').html()) == '') {
                $('#active_filter_contain').html('<span class="no-data-found">No active filter.</span>');
                $('.active_filter_sec').hide();
            } else {
                $('.active_filter_sec').show();
            }
            if ($('#filterModal').is(':visible')) {
                $('.filter_det').hide();
            } else {
                $('.filter_det').show();
            }
        }
    }, 'json');
}

function checkMilestones(id, current) {
    var totmstones = $('#totmstones').val();
    var milestns = "";
    var msid = "";
    if (current) {
        document.getElementById(current).checked = true;
    }
    if (id == "all") {
        for (var i = 1; i <= totmstones; i++) {
            var msid = 'mstones' + i;
            document.getElementById(msid).checked = false;
            var curli = 'curli' + i;
            document.getElementById(curli).style.background = '#FFF';
            var chkid = $('#' + msid).val();
            milestns = milestns + "-" + chkid;
        }
        milestns = 'all';
        document.getElementById('allmstones').checked = true;
    } else {
        var chk = 0;
        for (var i = 1; i <= totmstones; i++) {
            var msid = 'mstones' + i;
            var curli = 'curli' + i;
            if (id == "all") {
                document.getElementById(msid).checked = false;
            } else {
                if (document.getElementById(msid).checked == true) {
                    document.getElementById(curli).style.background = '#FFF';
                    var chkid = $('#' + msid).val();
                    milestns = milestns + "-" + chkid;
                    chk++;
                } else {
                    document.getElementById(curli).style.background = '#F2F2F2';
                }
            }
        }
        if (chk == totmstones) {
            document.getElementById('allmstones').checked = true;
            for (var i = 1; i <= totmstones; i++) {
                var curli = 'curli' + i;
                document.getElementById(curli).style.background = '#FFF';
                var msid = 'mstones' + i;
                document.getElementById(msid).checked = false;
                milestns = 'all';
            }
        } else {
            document.getElementById('allmstones').checked = false;
        }
    }
    $('#milestoneIds').val(milestns);
    casePage = 1;
    remember_filters('MILESTONES', milestns);
    ajaxCaseView('case_project');
}

function checkTaskgroups(type) {
    $('#taskgroupActive').attr('checked', false);
    $('#taskgroupComplete').attr('checked', false);
    $('#alltaskgroups').attr('checked', false);
    if (type == 'active') {
        $('#taskgroupActive').attr('checked', true);
    } else if (type == 'all') {
        $('#alltaskgroups').attr('checked', true);
    } else {
        $('#taskgroupComplete').attr('checked', true);
    }
    casePage = 1;
    remember_filters('TASKGROUP_FIL', type);
    ajaxCaseView('case_project');
}

function filterRequest(type) {
    if (_filterInterval) {
        clearInterval(_filterInterval);
    }
    $('#customFIlterId').val('');
    var g_has = getHash();
    var str2 = 'tasks/';
    filterInterval = setTimeout(function() {
        if (g_has == 'taskgroups') {
            showTaskByTaskGroupNew('', '', '', '', '');
        } else if (g_has.indexOf(str2) != -1) {
            window.location.hash = g_has;
            easycase.refreshTaskList();
        } else if (g_has.indexOf('tasks/') == -1) {
            window.location.hash = 'tasks';
            easycase.refreshTaskList();
        }
    }, 1000);
}

function checkboxDate(x, typ) {
    if (x && (!$('#date_' + x).is(':checked'))) {
        checkboxDate('', '');
        return false;
    }
    $('.cbox_date').removeAttr('checked');
    if (x) {
        $('#date_' + x).prop('checked', 'checked');
    } else {
        $('#date_any').prop('checked', 'checked');
    }
    $('#frm').val("");
    $('#to').val("");
    $('#custom_date').hide();
    $('#caseDateFil').val(x);
    casePage = 1;
    remember_filters('DATE', x);
}

function checkboxarchivestatus(id, type) {
    var x = "";
    var totid = $('#dropdown_menu_casestatus').find('input[type="checkbox"]').size();
    if (id == 'types_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "caseid_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        y = 'archive_' + id;
        if (type == "check") {
            if (document.getElementById(y).checked == true) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        } else {
            if (document.getElementById(y).checked == false) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        }
    }
    $('.archive_status_cls').each(function() {
        if ($(this).is(':checked')) {
            var dt_id = $(this).attr('data-id');
            x += dt_id + "-";
        }
    });
    if (x === "") {
        var types = "all";
    } else {
        var types = x.substring(0, x.length - 1);
    }
    casePage = 1;
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_STATUS', types);
        changeArcCaseList();
    } else if ($("#tab_diff").val() == 'file') {
        return;
    }
}

function customarchivedate() {
    $('.custome_archive').toggle();
    $('#dropdown_menu_casedate').find("input[type='radio']").removeAttr('checked');
}

function customarchiveduedate() {
    $('.custome_archive').toggle();
    $('#dropdown_menu_archiveduedate').find("input[type='radio']").removeAttr('checked');
}

function checkboxarchivedate(id, type, ftype) {
    $('.cst_date_cls').removeAttr("checked");
    if (id) {
        $('#archive_' + id).attr('checked', 'checked');
    }
    $('.custome_archive').hide();
    $("#arcduestrtdt").val('');
    $("#arcdueenddt").val('');
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_DATE', id);
        changeArcCaseList('');
    } else if ($("#tab_diff").val() == 'file') {
        remember_filters('ARCHIVE_FILE_DATE', id);
        changeArcFileList('');
    }
}

function arcivecustomdate() {
    if ($("#tab_diff").val() == 'task') {
        var start = $("#arcduestrtdt").val();
        var end = $("#arcdueenddt").val();
        var x = start + ":" + end;
        remember_filters('ARCHIVE_DATE', x);
        changeArcCaseList('');
    } else if ($("#tab_diff").val() == 'file') {
        var start = $("#arcduestrtdt").val();
        var end = $("#arcdueenddt").val();
        var x = start + ":" + end;
        remember_filters('ARCHIVE_FILE_DATE', x);
        changeArcFileList('');
    }
}

function arcivecustomduedate() {
    if ($("#tab_diff").val() == 'task') {
        var start = $("#arcstrtdt").val();
        var end = $("#arcenddt").val();
        var x = start + ":" + end;
        remember_filters('ARCHIVE_DUEDATE', x);
        changeArcCaseList('');
    } else if ($("#tab_diff").val() == 'file') {
        return false;
    }
}

function checkboxarchivedduedate(id, type, ftype) {
    $('.cst_duedate_cls').removeAttr("checked");
    if (id) {
        $('#archivedue_' + id).attr("checked", "checked");
    }
    $('.custome_archive').hide();
    $("#arcstrtdt").val('');
    $("#arcenddt").val('');
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_DUEDATE', id);
        changeArcCaseList();
    } else if ($("#tab_diff").val() == 'file') {
        return false;
    }
}

function checkboxArcProject(id, type) {
    var x = "";
    var totid = $('#dropdown_menu_project').find('input[type="checkbox"]').size();
    if (id == 'types_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "prjid_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        id = 'prjid_' + id;
        if (type == "check") {
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
    var x = '';
    $('.cst_prj_cls').each(function() {
        var dt_id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            var prjid = "prjids_" + dt_id;
            var prjvalue = $("#" + prjid).val();
            x += prjvalue + "-";
        }
    });
    if (x === "") {
        var types = "all";
    } else {
        var types = x.substring(0, x.length - 1);
    }
    casePage = 1;
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_PROJECT', types);
        changeArcCaseList();
    } else if ($("#tab_diff").val() == 'file') {
        remember_filters('ARCHIVE_FILE_PROJECT', types);
        changeArcFileList();
    }
}

function checkboxarchivedby(id, type) {
    var totid = $('#dropdown_menu_archivedby').find('input[type="checkbox"]').size();
    if (id == 'types_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "userid_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        var y = 'userid_' + id;
        if (type == "check") {
            if (document.getElementById(y).checked == true) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        } else {
            if (document.getElementById(y).checked == false) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        }
    }
    var x = '';
    $('.cst_user_cls').each(function() {
        var dt_id = $(this).attr('data-id');
        if ($("#" + this.id).is(':checked')) {
            var userid = "userids_" + dt_id;
            var uservalue = $("#" + userid).val();
            x += uservalue + "-";
        }
    });
    if (x === "") {
        var types = "all";
    } else {
        var types = x.substring(0, x.length - 1);
    }
    casePage = 1;
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_USER', types);
        changeArcCaseList();
    } else if ($("#tab_diff").val() == 'file') {
        remember_filters('ARCHIVE_FILE_USER', types);
        changeArcFileList();
    }
}

function checkboxarchiveassign(id, type) {
    var totid = $('#dropdown_menu_archiveassign').find('input[type="checkbox"]').size();
    if (id == 'types_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "userid_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        if (id != 'unassign') {
            document.getElementById('unassign').checked = false;
            var y = 'assignid_' + id;
        } else {
            var y = 'unassign';
        }
        if (type == "check") {
            if (document.getElementById(y).checked == true) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        } else {
            if (document.getElementById(y).checked == false) {
                document.getElementById(y).checked = true;
            } else {
                document.getElementById(y).checked = false;
            }
        }
    }
    var x = '';
    $('.cst_assign_cls').each(function() {
        var dt_id = $(this).attr('data-id');
        if ($("#" + this.id).is(':checked')) {
            var userid = "assignids_" + dt_id;
            var uservalue = $("#" + userid).val();
            x += uservalue + "-";
        }
    });
    if (x === "") {
        var types = "all";
    } else {
        var types = x.substring(0, x.length - 1);
    }
    if (id == 'unassign') {
        if (document.getElementById(id).checked == true) {
            var types = "unassigned";
        }
    }
    casePage = 1;
    if ($("#tab_diff").val() == 'task') {
        remember_filters('ARCHIVE_ASSIGNTO', types);
        changeArcCaseList();
    } else if ($("#tab_diff").val() == 'file') {
        return false;
    }
}

function checkboxdueDate(x, typ) {
    $('#duedate_' + x).prop('checked', 'checked');
    if (x) {
        $('#duedate_' + x).prop('checked', 'checked');
    } else {
        $('#duedate_any').prop('checked', 'checked');
    }
    if (x == 'any') {
        x = '';
    }
    $('#duefrm').val("");
    $('#dueto').val("");
    $('#custom_duedate').hide();
    $('#casedueDateFil').val(x);
    casePage = 1;
    remember_filters('DUE_DATE', x);
}

function stopProgress(e) {
    e.preventDefault();
    e.stopPropagation();
}

function checkboxcustom(id, cid, ctype) {
    if (arguments[3]) {
        var event = arguments[3];
        event.stopPropagation();
    }
    if (_filterInterval) {
        clearInterval(_filterInterval);
    }
    if (ctype) {
        $('#' + cid).prop('checked', 'checked');
    } else {
        if (!$('#' + cid).is(":checked")) {
            $('.cbox_date').prop('checked', false);
            $('#date_any').prop('checked', true);
        } else {
            $('.cbox_date').prop('checked', false);
            document.getElementById(cid).checked = true;
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
        if ((id != 'custom_date') || (id != 'custom_duedate')) {
            filterRequest('time');
        }
    }
}

function checkBox(id) {
    if (document.getElementById(id).checked != true) {
        document.getElementById(id).checked = true;
    } else {
        document.getElementById(id).checked = false;
    }
}

function checkboxStatus(id, typ) {
    var x = "";
    if (id == 'status_all') {
        if ($('#' + id).length) {
            document.getElementById(id).checked = true;
        }
        if ($('#status_new').length) {
            document.getElementById('status_new').checked = false;
            document.getElementById('status_open').checked = false;
            document.getElementById('status_close').checked = false;
            document.getElementById('status_resolve').checked = false;
        }
        if ($('#status_file').length) {
            document.getElementById('status_file').checked = false;
            document.getElementById('status_upd').checked = false;
        }
        $("[id^=custom_status_]").prop('checked', false);
        var x = "alll";
    } else {
        document.getElementById('status_all').checked = false;
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
    if (document.getElementById('status_new').checked == true) {
        x = 1 + "-";
    }
    if (document.getElementById('status_open').checked == true) {
        x = 2 + "-" + x;
    }
    if (document.getElementById('status_close').checked == true) {
        x = 3 + "-" + x;
    }
    if (document.getElementById('status_resolve').checked == true) {
        x = 5 + "-" + x;
    }
    if ($('#status_file').length) {
        if (document.getElementById('status_file').checked == true) {
            x = "attch-" + x;
        }
        if (document.getElementById('status_upd').checked == true) {
            x = "upd-" + x;
        }
    }
    if (x == "") {
        document.getElementById('status_all').checked = true;
        x = "alll";
    }
    if (x != "all") {
        var status = x.substring(0, x.length - 1);
    } else {
        var status = x;
    }
    $('#caseStatus').val(status);
    casePage = 1;
    remember_filters('STATUS', status);
}

function checkboxCustomStatus(id, typ) {
    var x = "";
    document.getElementById('status_all').checked = false;
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
    $("[id^=custom_status_]").each(function() {
        if ($(this).is(":checked")) {
            x += $(this).attr('id').replace('custom_status_', '') + "-";
        }
    });
    if (x != "all") {
        var status = x.substring(0, x.length - 1);
    } else {
        var status = x;
    }
    $('#caseCustomStatus').val(status);
    casePage = 1;
    remember_filters('CUSTOM_STATUS', status);
}

function moreLeftNav(more, hide, tot, id) {
    if (arguments[4]) {
        var event = arguments[4];
        event.preventDefault();
        event.stopPropagation();
    }
    for (var i = 1; i <= tot; i++) {
        var spanid = id + i;
        $('#' + spanid).css('display', 'block');
    }
    $('#' + more).hide();
    $('#' + hide).show();
    jQuery('html, body').animate({
        scrollTop: 125
    }, 700);
}

function hideLeftNav(more, hide, tot, id) {
    if (arguments[4]) {
        var event = arguments[4];
        event.preventDefault();
        event.stopPropagation();
    }
    for (var i = 1; i <= tot; i++) {
        var spanid = id + i;
        $('#' + spanid).hide();
    }
    $('#' + hide).hide();
    $('#' + more).show();
}

function checkboxTypes(id, typ) {
    var x = "";
    var totid = $('#totType').val();
    if (id == 'types_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "types_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        document.getElementById('types_all').checked = false;
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
    $('.cst_type_cls').each(function() {
        var dt_id = $(this).attr('data-id');
        if ($("#" + this.id).is(':checked')) {
            var typeid = "typeids_" + dt_id;
            var typevalue = $("#" + typeid).val();
            x = typevalue + "-" + x;
        }
    });
    if (x === "") {
        document.getElementById('types_all').checked = true;
        var types = "all";
    } else {
        var types = x.substring(0, x.length - 1);
    }
    $('#caseTypes').val(types);
    casePage = 1;
    remember_filters('CS_TYPES', types);
}

function checkboxLabel(id, typ) {
    var x = "";
    var totid = $('#totLabel').val();
    if (id == 'label_all') {
        document.getElementById(id).checked = true;
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "Label_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        var x = "all";
    } else {
        document.getElementById('label_all').checked = false;
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
    $('.label_type_cls').each(function() {
        var dt_id = $(this).attr('data-id');
        if ($("#" + this.id).is(':checked')) {
            var typeid = "Labelids_" + dt_id;
            var typevalue = $("#" + typeid).val();
            x = typevalue + "-" + x;
        }
    });
    if (x === "") {
        document.getElementById('label_all').checked = true;
        var labels = "all";
    } else {
        var labels = x.substring(0, x.length - 1);
    }
    $('#caseLabel').val(labels);
    casePage = 1;
    remember_filters('TASKLABEL', labels);
}

function checkboxPriority(id, typ) {
    var x = "";
    if (id == 'priority_all') {
        document.getElementById(id).checked = true;
        document.getElementById('priority_High').checked = false;
        document.getElementById('priority_Medium').checked = false;
        document.getElementById('priority_Low').checked = false;
        var x = "alll";
    } else {
        document.getElementById('priority_all').checked = false;
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
    if (document.getElementById('priority_High').checked == true) {
        x = "High-";
    }
    if (document.getElementById('priority_Medium').checked == true) {
        x = "Medium-" + x;
    }
    if (document.getElementById('priority_Low').checked == true) {
        x = "Low-" + x;
    }
    if (x == "") {
        document.getElementById('priority_all').checked = true;
        x = "alll";
    }
    if (x != "all") {
        var priority = x.substring(0, x.length - 1);
    } else {
        var priority = x;
    }
    $('#priFil').val(priority);
    casePage = 1;
    remember_filters('PRIORITY', priority);
}

function checkboxMems(id, typ) {
    var x = "";
    var totid = $('#totMemId').val();
    if (id == 'types_all') {} else {
        document.getElementById('types_all').checked = false;
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
    for (var j = 1; j <= totid; j++) {
        var checkboxid = "mems_" + j;
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "memids_" + j;
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var mems = "all";
    } else {
        var mems = x.substring(0, x.length - 1);
    }
    $('#caseMember').val(mems);
    casePage = 1;
    remember_filters('MEMBERS', mems);
}

function checkboxComs(id, typ) {
    var x = "";
    var totid = $('#totComId').val();
    if (id == 'types_all') {} else {
        document.getElementById('types_all').checked = false;
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
    for (var j = 1; j <= totid; j++) {
        var checkboxid = "coms_" + j;
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "comids_" + j;
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var mems = "all";
    } else {
        var mems = x.substring(0, x.length - 1);
    }
    $('#caseComment').val(mems);
    casePage = 1;
    remember_filters('COMMENTS', mems);
}

function checkboxGroups(id, typ) {
    var x = "";
    var totid = $('#totGroupId').val();
    if (id == 'types_all') {} else {
        document.getElementById('types_all').checked = false;
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
    for (var j = 1; j <= totid; j++) {
        var checkboxid = "groups_" + j;
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "groupids_" + j;
            var typevalue = document.getElementById(typeid).value;
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var mems = "all";
    } else {
        var mems = x.substring(0, x.length - 1);
    }
    $('#caseTaskgroup').val(mems);
    casePage = 1;
    remember_filters('TASKGROUP', mems);
}

function checkboxAsns(id, typ) {
    var x = "";
    var totid = $('#totAsnId').val();
    if (id == 'types_all') {} else {
        document.getElementById('assignTo_all').checked = false;
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
    for (var j = 1; j <= totid; j++) {
        var checkboxid = "Asns_" + j;
        if (document.getElementById(checkboxid).checked == true) {
            var typeid = "Asnids_" + j;
            var typevalue = $('#' + typeid).val();
            x = typevalue + "-" + x;
        }
    }
    if (x == "") {
        var Asns = "all";
    } else {
        var Asns = x.substring(0, x.length - 1);
    }
    if (id == 'unassgn') {
        if (document.getElementById(id).checked == true) {
            var Asns = "unassigned";
        }
    }
    $('#caseAssignTo').val(Asns);
    casePage = 1;
    remember_filters('ASSIGNTO', Asns);
}

function checkboxrange() {
    var start_date = document.getElementById('frm');
    var end_date = document.getElementById('to');
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
        var from = $('#frm').val();
        var to = $('#to').val();
        document.getElementById('date_any').checked = false;
        document.getElementById('date_one').checked = false;
        document.getElementById('date_24').checked = false;
        document.getElementById('date_week').checked = false;
        document.getElementById('date_month').checked = false;
        document.getElementById('date_year').checked = false;
        var x = from + "_" + to;
        $('#caseDateFil').val(x);
        remember_filters('DATE', encodeURIComponent(x));
        filterRequest('time');
    }
}

function searchduedate() {
    var fduedate = $.trim($('#duefrm').val());
    var tduedate = $.trim($('#dueto').val());
    if (fduedate == '') {
        showTopErrSucc('error', _('From date cannot be blank.'));
        $('#duefrm').focus();
        return false;
    } else if (tduedate == '') {
        showTopErrSucc('error', _('To date cannot be blank.'));
        $('#dueto').focus();
        return false;
    } else if (Date.parse(fduedate) > Date.parse(tduedate)) {
        showTopErrSucc('error', _('From Date cannot exceed To Date!'));
        $('#duefrm').focus();
        return false;
    } else {
        var x = fduedate + ":" + tduedate;
        $('#casedueDateFil').val(x);
        remember_filters('DUE_DATE', encodeURIComponent(x));
        filterRequest('duedate');
    }
}

function resetAllFilters(type) {
    closeTaskFilter();
    var pagerefresh = (typeof arguments[1] != 'undefined' && arguments[1] == 'no_pagerefresh') ? 1 : 0;
    $('#filtered_items').fadeOut('slow');
    $('#savereset_filter').fadeOut('slow');
    $('[rel=tooltip]').tipsy({
        gravity: 's',
        fade: false
    });
    var requiredUrl = HTTP_ROOT;
    var n = requiredUrl.indexOf("filters=cases");
    if ($('#search_txt_spn').text()) {
        $('#clearCaseSearch').val(1);
    }
    try {
        $('#caseStatus').val('all');
        $('#caseCustomStatus').val('all');
        $('#priFil').val('all');
        $('#caseTypes').val('all');
        $('#caseLabel').val('all');
        $('#caseMember').val('all');
        $('#caseComment').val('all');
        $('#caseAssignTo').val('all');
        $('#milestoneIds').val('all');
        $('#caseTaskgroup').val('all');
        casePage = 1;
        $('#case_search, #caseSearch').val("");
        $('#case_srch').val('');
        $('#caseDateFil').val('');
        $('#casedueDateFil').val('');
        document.getElementById('status_all').checked = true;
        document.getElementById('status_new').checked = false;
        document.getElementById('status_open').checked = false;
        document.getElementById('status_close').checked = false;
        document.getElementById('status_resolve').checked = false;
        document.getElementById('status_upd').checked = false;
        var totid = $('#totMemId').val();
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "mems_" + i;
            document.getElementById(checkboxid).checked = false;
        }
        document.getElementById('priority_all').checked = true;
        document.getElementById('priority_High').checked = false;
        document.getElementById('priority_Medium').checked = false;
        document.getElementById('priority_Low').checked = false;
        var totid = $('#totType').val();
        for (var i = 1; i <= totid; i++) {
            var checkboxid = "types_" + i;
            document.getElementById(checkboxid).checked = false;
        }
    } catch (e) {}
    if (type == "all") {
        localStorage.setItem('SEARCHFILTER', '');
        if (pagerefresh == 1) {
            remember_filters('reset', 'all');
        } else {
            if (n != -1) {
                remember_filters('reset', 'all');
                var hashtag = parseUrlHash(urlHash);
                if (getCookie('SUBTASKVIEW') == 'subtaskview') {
                    easycase.showtaskgroups();
                } else {
                    if (parseInt($("#subtask-container").height()) > 70) {
                        ajaxCaseSubtaskView();
                    } else {
                        if (hashtag[0] == 'kanban') {
                            easycase.showKanbanTaskList('kanban');
                        } else {
                            ajaxCaseView("case_project.php");
                        }
                    }
                }
                $("#case_search").attr("placeholder", _("Search"));
                window.location = HTTP_ROOT + "dashboard";
            } else {
                remember_filters('reset', 'all');
                var load = arguments['1'];
                if (load != 1) {
                    if (getCookie('SUBTASKVIEW') == 'subtaskview') {
                        easycase.showtaskgroups();
                    } else {
                        if (parseInt($("#subtask-container").height()) > 70) {
                            ajaxCaseSubtaskView();
                        } else {
                            var hashtag = parseUrlHash(urlHash);
                            if (hashtag[0] == 'kanban') {
                                easycase.showKanbanTaskList('kanban');
                            } else if (hashtag[0] == 'taskgroup') {
                                $('#customFIlterId').val('');
                                window.location.hash = 'taskgroup';
                                easycase.refreshTaskList();
                            } else if (hashtag[0] == 'taskgroups') {
                                $('#customFIlterId').val('');
                                window.location.hash = 'taskgroups';
                                easycase.refreshTaskList();
                            } else {
                                $('#customFIlterId').val('');
                                window.location.hash = 'tasks';
                                easycase.refreshTaskList();
                            }
                        }
                    }
                }
            }
        }
    } else if (type == "filters") {
        if (n != -1) {
            remember_filters('reset', 'filters');
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'kanban') {
                easycase.showKanbanTaskList('kanban');
            } else {
                ajaxCaseView("case_project.php");
            }
            $("#case_search").attr("placeholder", _("Search"));
            window.location = HTTP_ROOT + "dashboard/";
        } else {
            remember_filters('reset', 'filters');
            var hashtag = parseUrlHash(urlHash);
            if (hashtag[0] == 'kanban') {
                easycase.showKanbanTaskList('kanban');
            } else {
                ajaxCaseView("case_project.php");
            }
        }
    }
}

function bindPrettyview(id) {
    $(".gallery a[rel^='" + id + "']").prettyPhoto({
        animation_speed: 'normal',
        autoplay_slideshow: false,
        social_tools: false,
        overlay_gallery: false,
        deeplinking: false
    });
}

function fuploadUI(csAtId) {
    var isExceed = 0;
    reply_total_files = new Array();
    reply_indx = 0;
    $('INPUT[type="file"]').change(function() {
        var isExceed = $("#isExceed").val();
        if (this.value.match(/\.(.+)$/) == null) {
            alert(_('File') + ' "' + this.value + '" ' + _('has no extension, please upload files with extension'));
            this.value = '';
            return false;
        }
        if (this.value) {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            if ($.inArray(ext, ["bat", "com", "cpl", "dll", "exe", "msi", "msp", "pif", "shs", "sys", "cgi", "reg", "bin", "torrent", "yps", "mpg", "dat", "xvid", "scr", "com", "pif", "chm", "cmd", "cpl", "crt", "hlp", "hta", "inf", "ins", "isp", "jse?", "lnk", "mdb", "ms", "pcd", "pif", "scr", "sct", "shs", "vb", "ws", "vbs"]) >= 1) {
                alert(_("Sorry") + ", '" + ext + "' " + _("file type is not allowed!"));
                this.value = '';
            }
        } else if (isExceed == 1) {}
    });
    var i = 0;
    $('.upload' + csAtId + ':not(.applied' + csAtId + ')').addClass('applied' + csAtId + '').fileUploadUI({
        uploadTable: $('#up_files' + csAtId + ''),
        downloadTable: $('#up_files' + csAtId + ''),
        buildUploadRow: function(files, index) {
            var filename = files[index].name;
            if (filename.length > 35) {
                filename = filename.substr(0, 35);
            }
            gFileupload = 0;
            reply_total_files.push(filename);
            return $('<tr class="cls_to_check_fl_upload"><td valign="top" class="cmn_link_color" style="font-size:14px;">' + filename + '</td>' + '<td valign="top" align="right" width="300px" style="padding-right:10px;" title="Uploading..." rel="tooltip"><div class=""><img src="' + HTTP_ROOT + 'img/images/upload_progress.gif" /><\/div></td>' + '<td valign="top" style="padding-left:10px;font-size:13px;"><div class="file_upload_cancel anchor">' + '<font id="cancel" title="Cancel" rel="tooltip">' + '<span class="ui-icon-fupload ui-icon-cancel" onclick="cancelReplyFile(\'' + filename + '\');">Cancel<\/span>' + '<\/font><\/div><\/td><\/tr>');
        },
        buildDownloadRow: function(file) {
            var fmaxilesize = $('#fmaxilesize').val();
            reply_indx++;
            if (file.name != "error") {
                if (file.message == "success") {
                    var allowedSize = parseInt(fmaxilesize) * 1024;
                    if (parseInt(file.sizeinkb) <= parseInt(allowedSize)) {
                        i++;
                        $('#totfiles' + csAtId + '').val(i);
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
                        return $('<tr><td style="font-size:14px;" valign="top"><span id="' + csAtId + 'jquerydiv' + i + '" class="checkbox"><label><input type="checkbox" checked onClick="return removeFile(\'' + csAtId + 'jqueryfile' + i + '\',\'' + csAtId + 'jquerydiv' + i + '\');" style="cursor:pointer;"/><span class="checkbox-material"><span class="check"></span></span>&nbsp;&nbsp;<a class="cmn_link_color" href="' + HTTP_ROOT + 'easycases/download/' + fname[0] + '">' + file.name + ' (' + filesize + ')</a><input type="hidden" name="data[Easycase][name][]" id="' + csAtId + 'jqueryfile' + i + '" value="' + file.filename + '"/><\/label><\/span><\/td><\/tr>');
                    } else {
                        alert(_("Error uploading file. File size cannot be more then") + " " + fmaxilesize + " Mb!");
                        if (parseInt(reply_total_files.length) == reply_indx) {
                            gFileupload = 1;
                        }
                    }
                } else if (file.message == "exceed") {
                    alert(_("Error uploading file.") + "\n" + _("Storage usage exceeds by") + " " + file.storageExceeds + " Mb!");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "size") {
                    alert(_("Error uploading file. File size cannot be more then") + " " + fmaxilesize + " Mb!");
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "error") {
                    alert(_("Error uploading file. Please try with another file"));
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else if (file.message == "s3_error") {
                    alert(_("Due to some network problem your file is not uploaded.Please try again after sometime."));
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                } else {
                    alert(_("Sorry") + ", " + file.message + " " + _("file type is not allowed!"));
                    if (parseInt(reply_total_files.length) == reply_indx) {
                        gFileupload = 1;
                    }
                }
            } else {
                alert(_("Error uploading file. Please try with another file"));
                if (parseInt(reply_total_files.length) == reply_indx) {
                    gFileupload = 1;
                }
            }
        }
    });
}

function openAjaxCustomFilter(dataVal, customid) {
    if ($("#customFil").hasClass("open")) {
        if (dataVal == 'auto') {
            $(".customFilterLoader").show();
        } else {
            $(".customFilterLoader").hide();
        }
    } else {
        $(".menu-files").removeClass('active');
        $(".menu-cases").removeClass('active');
        $(".customFilterLoader").show();
    }
    $('.customFilter').html('');
    var strURL = HTTP_ROOT + "easycases/";
    $.post(strURL + "ajax_custom_filter_show", function(data) {
        if (data) {
            $(".customFilterLoader").hide();
            $('.customFilter').html(data);
            if (customid !== '') {
                $('.customlink').removeClass('active');
                $("#lnkcustomFilterRow_" + customid).addClass('active');
                $("#deleteImg_" + customid).show();
                $(".allmenutab").removeClass('active');
                $(".more_menu_li").removeClass('active');
            }
        }
    });
}

function showmoreCustomFilter(limit, type) {
    if (type == "more") {
        var limit1 = limit;
    }
    var strURL = $('#pageurl').val();
    strURL = strURL + "easycases/";
    $(".customFilterLoader").show();
    $('.customFilter').html('');
    $.post(strURL + "ajax_custom_filter_show", {
        "limit1": limit1,
        'type': type
    }, function(data) {
        if (data) {
            $(".customFilterLoader").hide();
            $('.customFilter').html(data);
        }
    });
}

function previousCustomFilter(limit, type) {
    if (type == "less") {
        var limit1 = parseInt(limit) - 6;
    }
    var strURL = $('#pageurl').val();
    strURL = strURL + "easycases/";
    $(".customFilterLoader").show();
    $('.customFilter').html('');
    $.post(strURL + "ajax_custom_filter_show", {
        "limit1": limit1,
        'type': type
    }, function(data) {
        if (data) {
            $(".customFilterLoader").hide();
            $('.customFilter').html(data);
        }
    });
}

function displayDeleteImg(id) {
    $("#deleteImg_" + id).show();
}

function hideDeleteImg(id) {
    $("#deleteImg_" + id).hide();
}

function deleteCustomFilter(id, name) {
    if (id) {
        var conf = confirm(_("Are you sure you want to delete custom filter") + " '" + decodeURIComponent(name.replace(/\+/g, ' ')) + "' ?");
        if (conf == true) {
            var strURL = $('#pageurl').val();
            strURL = strURL + "easycases/";
            $.post(strURL + "ajax_customfilter_delete", {
                'id': id
            }, function(data) {
                if (data) {
                    if (data == 'success') {
                        $("#customFilterRow_" + id).fadeOut('slow');
                        openAjaxCustomFilter('auto', '');
                        ajaxCaseView();
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

function openAjaxRecentCase() {
    if ($("#recentCases").hasClass("open")) {
        $('.recentViewed').html('');
    } else {
        $(".recentViewLoader").show();
        $(".recentViewed").html('');
        var strURL = HTTP_ROOT + "easycases/";
        $.post(strURL + "ajax_recent_case", function(data) {
            if (data) {
                $(".recentViewLoader").hide();
                $('.recentViewed').html(data);
            }
        });
    }
}

function showmoreRecentCase(limit, type) {
    if (type == "more") {
        var limit1 = limit;
        var limit2 = 3;
    }
    var strURL = HTTP_ROOT + "easycases/";
    $(".recentViewLoader").show();
    $(".recentViewed").html('');
    $.post(strURL + "ajax_recent_case", {
        "limit1": limit1,
        'type': type
    }, function(data) {
        if (data) {
            $(".recentViewLoader").hide();
            $('.recentViewed').html(data);
        }
    });
}

function previousRecentCase(limit, type) {
    if (type == "less") {
        var limit1 = parseInt(limit) - 6;
        var limit2 = 3;
    }
    var strURL = HTTP_ROOT + "easycases/";
    $(".recentViewLoader").show();
    $(".recentViewed").html('');
    $.post(strURL + "ajax_recent_case", {
        "limit1": limit1,
        'type': type
    }, function(data) {
        if (data) {
            $(".recentViewLoader").hide();
            $('.recentViewed').html(data);
        }
    });
}

function caseDetailsSearch(pid, cid, page) {
    if (page == "dashboard") {
        window.location = HTTP_ROOT + 'dashboard/?case=' + cid + "&project=" + pid;
    } else {
        window.location = HTTP_ROOT + 'dashboard/?case=' + cid + "&project=" + pid;
    }
}

function changeArcCaseList(type) {
    var displayedcases = $("#displayedCases").val();
    var limit1, limit2;
    if (type == "more") {
        limit1 = displayedcases;
        limit2 = ARC_CASE_PAGE_LIMIT;
    } else {
        limit1 = 0;
        limit2 = ARC_CASE_PAGE_LIMIT;
    }
    if (type == "more") {
        $(".morebar_arc_case").show();
        var lastCount = $("#caselist").children("tr:last").attr("data-value");
    } else {
        $('#caseLoader').show();
    }
    var displayedcases = $("#displayedCases").val();
    var url = HTTP_ROOT + "archives/case_list";
    $.post(url, {
        "pjid": "all",
        "limit1": limit1,
        "limit2": limit2,
        "lastCount": lastCount
    }, function(data) {
        if (data) {
            $('.filter_rt').show();
            $('.archive-filter-menu').show();
            $('#casestatus_li').show();
            $('#caseduedate_li').show();
            $('#archiveassign_li').show();
            $("#caselistDiv").show();
            $("#filelistDiv").hide();
            $('#task_li').addClass('active');
            $('#file_li').removeClass('active');
            $('#task_filter').hide();
            $('#caseLoader').hide();
            $('#archive_filter').show();
            $('#topactions').hide();
            $('.task-list-bar').hide();
            $('.overview-bar').hide();
            $('.kanban_stas_bar').hide();
            $('.timlog_top_bar').hide();
            $('.archive-bar').show();
            $('.archive_stas_bar').show();
            $('.case-filter-menu').hide();
            $('#file_li').removeClass('active-list');
            $('#task_li').addClass('active-list');
            var data = data.replace("<head/>", "");
            var data = data.replace("<head/ >", "");
            var data = data.replace("<head />", "");
            if (type == "more") {
                $('.empty_task_tr').remove();
                $(".morebar_arc_case").hide();
                $('.caselistall').append(data);
                $.material.init();
                if ($('.chkOneArcCase:checked').length == $(".chkOneArcCase").length) {
                    $("#allcase").prop('checked', true);
                } else {
                    $("#allcase").prop('checked', false);
                }
                var displayedcases = $("#displayedCases").val();
                var newdisplayedcases = (parseInt(displayedcases)) + ARC_CASE_PAGE_LIMIT;
                $("#displayedCases").val(newdisplayedcases);
            } else {
                $('#caseLoader').hide();
                $(".all_first_rows").remove();
                $(".pj_id").remove();
                $(".total_case_count").remove();
                $("#displayedCases").remove();
                $("#displayedCases").val(ARC_CASE_PAGE_LIMIT);
                $('#allcase').parents('.dropdown').removeClass('active');
                $('#allcase').next('.all_chk').attr('data-toggle', '');
                $('#allcase').prop('checked', false);
                $('.caselistall').find("tr:gt(0)").remove();
                $('.empty_task_tr').remove();
                $('.caselistall').append(data);
                $.material.init();
            }
            var arcFilStatus = getCookie('ARCHIVE_STATUS');
            var arcFilDate = getCookie('ARCHIVE_DATE');
            var arcFilProject = getCookie('ARCHIVE_PROJECT');
            var arcFilUser = getCookie('ARCHIVE_USER');
            var arcFilAssign = getCookie('ARCHIVE_ASSIGNTO');
            var arcFilDuedate = getCookie('ARCHIVE_DUEDATE');
            archive_common_breadcrumb(arcFilStatus, arcFilDate, arcFilProject, arcFilUser, arcFilDuedate, arcFilAssign, 'task');
        }
    });
}

function setcheck(type, id) {
    if (type == 'casestatus') {
        if (id == '1') {
            $('#archive_new').prop('checked', true);
        } else if (id == '2') {
            $('#archive_inprogress').prop('checked', true);
        } else if (id == '3') {
            $('#archive_closed').prop('checked', true);
        } else if (id == '5') {
            $('#archive_resolved').prop('checked', true);
        }
    } else if (type == 'archiveduedate') {
        $('#archivedue_' + id).attr('checked', 'checked');
    } else if (type == 'casedate') {
        $('#archive_' + id).attr('checked', 'checked');
    }
}

function archive_common_breadcrumb(arcFilStatus, arcFilDate, arcFilProject, arcFilUser, arcFilDuedate, arcFilAssign, type) {
    var url = HTTP_ROOT + "archives/common_filter_det";
    $.post(url, {
        'arcFilStatus': arcFilStatus,
        'arcFilDate': arcFilDate,
        'arcFilProject': arcFilProject,
        'arcFilUser': arcFilUser,
        'arcFilDuedate': arcFilDuedate,
        'arcFilAssign': arcFilAssign,
        'type': type
    }, function(data) {
        if (data) {
            data = jQuery.parseJSON(data);
            if (data.val) {
                $('.archive_filter_det').css('display', 'table');
                $('#archive_filtered_items').show();
                $('#archive_savereset_filter').show();
                $('#archive_reset_btn').show();
            } else {
                $('#archive_filtered_items').hide();
                $('#archive_savereset_filter').hide();
                $('#archive_reset_btn').hide();
            }
            $('.filter_det').hide();
            $('#archive_filtered_items').html('');
            if (data.case_status != 'All') {
                $('#archive_filtered_items').append(data.case_status);
            }
            if (data.duedate != 'alldates') {
                $('#archive_filtered_items').append(data.duedate);
            }
            if (data.archivedate != 'alldates') {
                $('#archive_filtered_items').append(data.archivedate);
            }
            if (data.archived_by != 'all') {
                $('#archive_filtered_items').append(data.archived_by);
            }
            if (data.project != 'all') {
                $('#archive_filtered_items').append(data.project);
            }
            if (data.assignto != 'all') {
                $('#archive_filtered_items').append(data.assignto);
            }
        }
    });
}

function common_reset_archive_filter(ftype, id, obj) {
    if (arguments[3]) {
        var e = arguments[3];
        e.stopPropagation();
    }
    if ($('.filter_opn').length == 1) {
        $(".tipsy").remove();
        $('#archive_filtered_items').fadeOut('slow');
        $('#archive_savereset_filter').fadeOut('slow');
    } else {
        $(obj).parent('div').fadeOut('slow');
        $(".tipsy").remove();
    }
    var task = $('#tab_diff').val();
    var file = $('#tab_diff').val();
    if (ftype == 'casestatus') {
        if (id == 1) {
            $('#archive_new').prop('checked', false);
        } else if (id == 2) {
            $('#archive_inprogress').prop('checked', false);
        } else if (id == 3) {
            $('#archive_closed').prop('checked', false);
        } else if (id == 5) {
            $('#archive_resolved').prop('checked', false);
        }
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_STATUS');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                var formated_str = get_formated_string(ext_val, id);
            } else {
                var formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_STATUS', formated_str);
            }
        }
    } else if (ftype == 'archiveduedate') {
        if (id != 'custom') {
            $('#archivedue_' + id).removeAttr('checked');
        } else {
            $('.custome_archive').hide()
            $('.custome_archive').find('input[type="text"]').val('');
        }
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_DUEDATE');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                var formated_str = get_formated_string(ext_val, id);
            } else {
                var formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_DUEDATE', formated_str);
            }
        }
    } else if (ftype == 'casedate') {
        if (id != 'custom') {
            $('#archive_' + id).removeAttr('checked');
        } else {
            $('.custome_archive').hide()
            $('.custome_archive').find('input[type="text"]').val('');
        }
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_DATE');
        } else if (file == 'file') {
            var ext_val = getCookie('ARCHIVE_FILE_DATE');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                var formated_str = get_formated_string(ext_val, id);
            } else {
                var formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_DATE', formated_str);
            } else if (file == 'file') {
                remember_filters('ARCHIVE_FILE_DATE', formated_str);
            }
        }
    } else if (ftype == 'archivedby') {
        $('#userid_' + id).prop('checked', false);
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_USER');
        } else if (file == 'file') {
            var ext_val = getCookie('ARCHIVE_FILE_USER');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                var formated_str = get_formated_string(ext_val, id);
            } else {
                var formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_USER', formated_str);
            } else if (file == 'file') {
                remember_filters('ARCHIVE_FILE_USER', formated_str);
            }
        }
    } else if (ftype == 'archiveassign') {
        $('#assignid_' + id).prop('checked', false);
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_ASSIGNTO');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                var formated_str = get_formated_string(ext_val, id);
            } else {
                var formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_ASSIGNTO', formated_str);
            }
        }
    } else if (ftype == 'project') {
        $('#prjid_' + id).prop('checked', false);
        if (task == 'task') {
            var ext_val = getCookie('ARCHIVE_PROJECT');
        } else if (file == 'file') {
            var ext_val = getCookie('ARCHIVE_FILE_PROJECT');
        }
        if (ext_val != 'all') {
            if (ext_val.indexOf('-') != -1) {
                formated_str = get_formated_string(ext_val, id);
            } else {
                formated_str = 'all'
            }
        }
        if (typeof formated_str != 'undefined') {
            if (task == 'task') {
                remember_filters('ARCHIVE_PROJECT', formated_str);
            } else if (file == 'file') {
                remember_filters('ARCHIVE_FILE_PROJECT', formated_str);
            }
        }
    }
    if ($('#tab_diff').val() == 'task') {
        changeArcCaseList('');
    } else if ($('#tab_diff').val() == 'file') {
        changeArcFileList('');
    }
}

function resetAllFilters_archive(type) {
    if (type == 'all') {
        $('#dropdown_menu_casedate').find('input[type="checkbox"]').prop('checked', false);
        $('#dropdown_menu_project').find('input[type="checkbox"]').prop('checked', false);
        $('#dropdown_menu_archivedby').find('input[type="checkbox"]').prop('checked', false);
        if ($('#tab_diff').val() == 'task') {
            remember_filters('ARCHIVE_STATUS', 'all');
            remember_filters('ARCHIVE_DUEDATE', 'all');
            remember_filters('ARCHIVE_DATE', 'all');
            remember_filters('ARCHIVE_USER', 'all');
            remember_filters('ARCHIVE_ASSIGNTO', 'all');
            remember_filters('ARCHIVE_PROJECT', 'all');
            $('#dropdown_menu_casestatus').find('input[type="checkbox"]').prop('checked', false);
            $('#dropdown_menu_archiveduedate').find('input[type="checkbox"]').prop('checked', false);
            changeArcCaseList('');
        } else if ($('#tab_diff').val() == 'file') {
            remember_filters('ARCHIVE_FILE_DATE', 'all');
            remember_filters('ARCHIVE_FILE_USER', 'all');
            remember_filters('ARCHIVE_FILE_PROJECT', 'all');
            changeArcFileList('');
        }
    }
}

function enableArcCaseOptions() {
    if ($('.chkOneArcCase:checked').length) {
        $('#allcase').parents('.dropdown').addClass('active');
        $('.arc_case_listing').attr('data-toggle', 'dropdown');
        $('.arc_case_listing .material-icons').addClass('active');
    } else {
        $('#allcase').parents('.dropdown').removeClass('active');
        $('.arc_case_listing').attr('data-toggle', '');
        $('.arc_case_listing .material-icons').removeClass('active');
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
        enableArcCaseOptions();
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
        enableArcCaseOptions();
    });
}('#allcase', '.chkOneArcCase', '.tr_all', 'tr_all_active'));

function changeArcFileList(type) {
    var displayedfiles = $("#displayedFiles").val();
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
        var lastCountFiles = $("#filelist").children("tr:last").attr("data-value");
    } else {
        $('#caseLoader').show();
    }
    var url = HTTP_ROOT + "archives/file_list";
    $.post(url, {
        "pjid": "all",
        "limit1": limit1,
        "limit2": limit2,
        "lastCountFiles": lastCountFiles
    }, function(data) {
        if (data) {
            $('.filter_rt').show();
            $('.archive-filter-menu').show();
            $('#casestatus_li').hide();
            $('#caseduedate_li').hide();
            $('#archiveassign_li').hide();
            $("#caselistDiv").hide();
            $("#filelistDiv").show();
            $('#file_li').addClass('active');
            $('#task_li').removeClass('active');
            $('#task_filter').hide();
            $('#caseLoader').hide();
            $('#archive_filter').show();
            $('#topactions').hide();
            $('.task-list-bar').hide();
            $('.overview-bar').hide();
            $('.kanban_stas_bar').hide();
            $('.timlog_top_bar').hide();
            $('.archive-bar').show();
            $('.archive_stas_bar').show();
            $('#task_li').removeClass('active-list');
            $('#file_li').addClass('active-list');
            var data = data.replace("<head/>", "");
            var data = data.replace("<head/ >", "");
            var data = data.replace("<head />", "");
            if (type == "more") {
                $(".morebar_arc_case").hide();
                $('.empty_task_tr').remove();
                $('.filelistall').append(data);
                if ($('.chkOneArcFile:checked').length == $(".chkOneArcFile").length) {
                    $("#allfile").prop('checked', true);
                } else {
                    $("#allfile").prop('checked', false);
                }
                var displayedfiles = $("#displayedFiles").val();
                var newdisplayedfiles = (parseInt(displayedfiles)) + ARC_FILE_PAGE_LIMIT;
                $("#displayedFiles").val(newdisplayedfiles);
                $.material.init();
            } else {
                $('#caseLoader').hide();
                $(".all_first_rows_files").remove();
                $(".filepjid").remove();
                $(".total_file_count").remove();
                $("#displayedFiles").remove();
                $("#displayedFiles").val(ARC_FILE_PAGE_LIMIT);
                $('#allfile').parents('.dropdown').removeClass('active');
                $('#allfile').next('.all_chk').attr('data-toggle', '');
                $('#allfile').prop('checked', false);
                $('.filelistall').find("tr:gt(0)").remove();
                $('.empty_task_tr').remove();
                $('.filelistall').append(data);
                $.material.init();
            }
            var arcFilDate = getCookie('ARCHIVE_FILE_DATE');
            var arcFilProject = getCookie('ARCHIVE_FILE_PROJECT');
            var arcFilUser = getCookie('ARCHIVE_FILE_USER');
            archive_common_breadcrumb('', arcFilDate, arcFilProject, arcFilUser, '', 'file');
        }
    });
}

function enableArcFileOptions() {
    if ($('.chkOneArcFile:checked').length) {
        $('#allfile').parents('.dropdown').addClass('active');
        $('.arc_file_listing').attr('data-toggle', 'dropdown');
        $('.arc_file_listing .material-icons').addClass('active');
    } else {
        $('#allfile').parents('.dropdown').removeClass('active');
        $('.arc_file_listing').attr('data-toggle', '');
        $('.arc_file_listing .material-icons').addClass('active');
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
        enableArcFileOptions();
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
        enableArcFileOptions();
    });
}('#allfile', '.chkOneArcFile', '.tr_all', 'tr_all_active'));

function restoreall() {
    var pjid = $('#pjid').val();
    var count_t = $("tr[id^='cslisting']").length;
    var count = parseInt($(".archive_active_task").text());
    var val = new Array();
    var alt = new Array();
    for (var i = 1; i <= count_t; i++) {
        if (document.getElementById("case" + i).checked == true) {
            val.push($("#case" + i).val());
            alt.push($("#csn" + i).val());
        }
    }
    if (val.length != '0') {
        $('.archive_active_task').html(count - val.length);
        $('#taskCnt').html('(' + (parseInt($('#taskCnt').text().replace('(', '').replace(')', '')) + parseInt(val.length)) + ')');
        $('#caseLoader').show();
        var pageurl = $('#pageurl').val();
        var url = pageurl + "archives/move_list";
        $.post(url, {
            "val": val
        }, function(data) {
            if (data) {
                var url = HTTP_ROOT + "archives/case_list";
                $.post(url, {
                    "pjid": "all",
                    "limit1": 0,
                    "limit2": ARC_CASE_PAGE_LIMIT,
                    "lastCount": ''
                }, function(data) {
                    if (data) {
                        var data = data.replace("<head/>", "");
                        var data = data.replace("<head/ >", "");
                        var data = data.replace("<head />", "");
                        $(".all_first_rows").remove();
                        $(".pj_id").remove();
                        $(".total_case_count").remove();
                        $("#displayedCases").val(ARC_CASE_PAGE_LIMIT);
                        $('.caselistall').append(data);
                        $.material.init();
                        $(".dropdown").removeClass("open active");
                        $("#allcase").prop('checked', false);
                        $(".all_chk").attr("data-toggle", "");
                        $('#caseLoader').hide();
                        showTopErrSucc('success', _('Task(s) have been restored.'));
                    }
                });
            }
        });
    } else {
        alert("No task selected!");
    }
}

function restoreFromTask(case_id, pjid, case_no) {
    var count = $("#caselist").children("tr:last").attr("data-value");
    var val = new Array();
    val.push(case_id);
    if (val.length != '0') {
        if (confirm("Are you sure you want to restore task# " + case_no + "?")) {
            $('#caseLoader').show();
            var pageurl = $('#pageurl').val();
            var url = pageurl + "archives/move_list";
            $.post(url, {
                "val": val,
                'chk': 1
            }, function(data) {
                if (data) {
                    showTopErrSucc('success', _('Task(s) have been restored.'));
                    easycase.refreshTaskList();
                }
            });
        }
    } else {
        alert("No task selected!");
    }
}

function removeall() {
    var pjid = $('#pjid').val();
    var count_t = $("tr[id^='cslisting']").length;
    var count = parseInt($(".archive_active_task").text());
    var val = new Array();
    var alt = new Array();
    for (var i = 1; i <= count_t; i++) {
        if (document.getElementById("case" + i).checked == true) {
            val.push($("#case" + i).val());
            alt.push($("#csn" + i).val());
        }
    }
    if (val.length != '0') {
        $('.archive_active_task').html(count - val.length);
        var conf_msg = _("Are you sure you want to delete all selected tasks") + "?";
        if (val.length == 1) {
            conf_msg = _("Are you sure you want to delete this task") + "?";
        }
        if (confirm(conf_msg)) {
            $('#caseLoader').show();
            var pageurl = $('#pageurl').val();
            var url = pageurl + "archives/case_remove";
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    var url = HTTP_ROOT + "archives/case_list";
                    $.post(url, {
                        "pjid": "all",
                        "limit1": 0,
                        "limit2": ARC_CASE_PAGE_LIMIT,
                        "lastCount": ''
                    }, function(data) {
                        if (data) {
                            var data = data.replace("<head/>", "");
                            var data = data.replace("<head/ >", "");
                            var data = data.replace("<head />", "");
                            $(".all_first_rows").remove();
                            $(".pj_id").remove();
                            $(".total_case_count").remove();
                            $("#displayedCases").remove();
                            $('.caselistall').append(data);
                            $.material.init();
                            $(".dropdown").removeClass("open active");
                            $("#allcase").prop('checked', false);
                            $(".all_chk").attr("data-toggle", "");
                            $('#caseLoader').hide();
                            showTopErrSucc('success', _('Task(s) have been removed.'));
                        }
                    });
                }
            });
        }
    } else {
        alert("No task selected!");
    }
}

function removeFromTask(case_id, pjid, case_no) {
    var val = new Array();
    val.push(case_id);
    if (val.length != '0') {
        if (confirm(_("Are you sure you want to remove task #") + case_no + "?")) {
            $('#caseLoader').show();
            var pageurl = $('#pageurl').val();
            var url = pageurl + "archives/case_remove";
            $.post(url, {
                "val": val,
                'chk': 1
            }, function(data) {
                if (data) {
                    showTopErrSucc('success', _('Task(s) have been removed.'));
                    easycase.refreshTaskList();
                }
            });
        }
    } else {
        alert("No task selected!");
    }
}

function restorefile() {
    var pjid = $('#filepjid').val();
    var count_t = $("tr[id^='fllisting']").length;
    var count = parseInt($(".archive_active_file").text());
    var val = new Array();
    for (var i = 1; i <= count_t; i++) {
        if (document.getElementById("file" + i).checked == true) {
            val.push($("#file" + i).val());
        }
    }
    var url = HTTP_ROOT + "archives/move_file";
    if (val.length != '0') {
        $('.archive_active_file').html(count - val.length);
        if (confirm(_("Are you sure you want to restore?"))) {
            $('#caseLoader').show();
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    var url = HTTP_ROOT + "archives/file_list";
                    $.post(url, {
                        "pjid": pjid,
                        "limit1": 0,
                        "limit2": ARC_FILE_PAGE_LIMIT,
                        "lastCountFiles": ''
                    }, function(data) {
                        if (data) {
                            var data = data.replace("<head/>", "");
                            var data = data.replace("<head/ >", "");
                            var data = data.replace("<head />", "");
                            $(".all_first_rows_files").remove();
                            $(".filepjid").remove();
                            $(".total_file_count").remove();
                            $("#displayedFiles").val(ARC_FILE_PAGE_LIMIT);
                            $('.filelistall').append(data);
                            $.material.init();
                            $(".dropdown").removeClass("open active");
                            $("#allfile").prop('checked', false);
                            $(".all_chk").attr("data-toggle", "");
                            $('#caseLoader').hide();
                            showTopErrSucc('success', _('File has been restored.'));
                        }
                    });
                }
            });
        }
    } else {
        alert("No file selected!");
    }
}

function removefile() {
    var pjid = $('#filepjid').val();
    var count_t = $("tr[id^='fllisting']").length;
    var count = parseInt($(".archive_active_file").text());
    var val = new Array();
    for (var i = 1; i <= count_t; i++) {
        if (document.getElementById("file" + i).checked == true) {
            val.push($("#file" + i).val());
        }
    }
    var url = HTTP_ROOT + "archives/file_remove";
    if (val.length != '0') {
        $('.archive_active_file').html(count - val.length);
        if (confirm(_("Are you sure you want to remove?"))) {
            $('#caseLoader').show();
            $.post(url, {
                "val": val
            }, function(data) {
                if (data) {
                    var url = HTTP_ROOT + "archives/file_list";
                    $.post(url, {
                        "pjid": pjid,
                        "limit1": 0,
                        "limit2": ARC_FILE_PAGE_LIMIT,
                        "lastCountFiles": ''
                    }, function(data) {
                        if (data) {
                            var data = data.replace("<head/>", "");
                            var data = data.replace("<head/ >", "");
                            var data = data.replace("<head />", "");
                            $(".all_first_rows_files").remove();
                            $(".filepjid").remove();
                            $(".total_file_count").remove();
                            $("#displayedFiles").remove();
                            $('.filelistall').append(data);
                            $.material.init();
                            $(".dropdown").removeClass("open active");
                            $("#allfile").prop('checked', false);
                            $(".all_chk").attr("data-toggle", "");
                            $('#caseLoader').hide();
                            showTopErrSucc('success', _('File has been removed.'));
                        }
                    });
                }
            });
        }
    } else {
        alert("No file selected!");
    }
}

function createTaskTemplate(action) {
    if ($("#btn_task_template_create").hasClass('loginactive') && action != 'edit') {
        return false;
    }
    if (action == 'add') {
        var tempTitle = $("#tasktemptitle").val();
        var tempDesc = tinymce.get('desc').getContent();
    } else {
        var tempTitle = $("#tasktemptitle_edit").val();
        var tempDesc = tinymce.get('desc_edit').getContent();
    }
    if (tempTitle == '') {
        $("#err_task_temp").show();
        $("#task_temp_err").html(_('Please provide a project plan title.'));
    } else if (tempDesc == '') {
        $("#err_task_temp").show();
        $("#task_temp_err").html(_('Please provide project data-placement description.'));
    } else {
        var pageurl = HTTP_ROOT;
        var url = pageurl + "templates/ajax_add_task_template";
        if (action == 'add') {
            $("#tasktemploader").removeClass("ldr-ad-btn");
            $("#task_btn").hide();
            var tempId = '';
            var page_num = '';
        } else if (action == 'edit') {
            $("#tasktemploader_edit").removeClass("ldr-ad-btn");
            $("#task_btn_edit").hide();
            var tempId = $("#hid_edit_id").val();
            var page_num = $("#hid_edit_page_num").val();
        }
        $.post(url, {
            "tasktempId": tempId,
            "title": tempTitle,
            "tempDesc": tempDesc
        }, function(data) {
            if (data) {
                $("#tasktemploader").addClass("ldr-ad-btn");
                $("#task_btn").show();
                if (data == 1) {
                    closePopup();
                    showTopErrSucc('success', _('Project plan created successfully.'));
                    document.location.href = pageurl + "templates/tasks"
                } else if (data == 0) {
                    closePopup();
                    showTopErrSucc('error', _("Project plan can't be added."));
                } else if (data == 2) {
                    closePopup();
                    showTopErrSucc('success', _('Template updated successfully.'));
                    if ((page_num == 1) || (page_num == '')) {
                        document.location.href = pageurl + "templates/tasks";
                    } else {
                        document.location.href = pageurl + "templates/tasks/?page=" + page_num;
                    }
                } else if (data == 3) {
                    closePopup();
                    showTopErrSucc('error', _("Project plan can't be updated."));
                } else if (data == 4) {
                    closePopup();
                    showTopErrSucc('error', _('This Project plan already exists.'));
                } else if (data == 5) {
                    closePopup();
                    showTopErrSucc('error', _('Invalid project plan name.'));
                }
            }
        });
    }
}

function createTemplate() {
    $('#project_temp_err').html('');
    var tempTitle = $("#projtemptitle").val();
    if (trim(tempTitle) == '') {
        $("#project_temp_err").html(_('Please provide a project plan name.'));
        $("#projtemptitle").focus();
    } else {
        $("#prjtemploader").removeClass("ldr-ad-btn");
        $("#prj_btn").hide();
        var pageurl = HTTP_ROOT;
        var url = pageurl + "templates/ajax_add_template_module";
        if (typeof new_tmpl != 'undefined' && new_tmpl == 1) {
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
            new_tmpl = '';
        }
        var selected_task = $('input[name="selectedTask"]:checked').val();
        var project_id = $('#project_id').val();
        $.post(url, {
            "title": trim(tempTitle),
            "case_id": case_id,
            "selected_task": selected_task,
            "project_id": project_id
        }, function(data) {
            if (data) {
                $("#prjtemploader").addClass("ldr-ad-btn");
                $("#prj_btn").show();
                if (data.tmpl_id) {
                    closePopup();
                    showTopErrSucc('success', _('Project plan created successfully.'));
                    document.location.href = pageurl + "templates/projects";
                } else if (data.error == 'fail' || data.error == 'duplicate') {
                    $('#project_temp_err').html(_('This Template already exists.'));
                    new_tmpl = 1;
                    $('#projtemptitle').focus();
                    return false;
                } else if (data.error == 'invalid') {
                    $('#project_temp_err').html(_('Invalid template name.') + ' "HTML" ' + _('tags are not allowed.'));
                    new_tmpl = 1;
                    $('#projtemptitle').focus();
                    return false;
                }
            }
        }, 'json');
    }
}

function addToProject(val, temp_name) {
    openPopup();
    if (!temp_name) {
        temp_name = $('#textTemp_' + val).text();
    }
    $(".add_prod_temp_name").html(_('Add') + ' "' + temp_name + '" ' + _('plan to project'));
    $(".add_to_project").show();
    $('#inner_tmp_add').hide();
    $('.add-tmp-btn').hide();
    var strURL = HTTP_ROOT + "templates/add_to_project";
    $.post(strURL, {
        "temp_id": val
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_tmp_add').show();
            $('#inner_tmp_add').html(data);
            $("#tmpl_txt").html(_('Below are the tasks of') + ' "' + temp_name + '" ' + _('project plan'));
            $.material.init();
            $(".select").select2();
        }
    });
}

function addTempToTask(val, temp_name, IsFromAddProject) {
    if (IsFromAddProject == 1) {
        openPopup();
        on_cancel = 1;
    } else {
        openPopup();
        on_cancel = 0;
    }
    temp_name = $('#textTemp_' + val).text();
    var nm = $('.proj_temp_name').text().split('"');
    if (parseInt(temp_name.length) > 50) {
        var tempName = temp_name.substr(0, 50) + "...";
    } else {
        var tempName = temp_name;
    }
    if (!tempName) {
        tempName = nm[1];
    }
    $(".add_task_temp_name").html(_('Add tasks to template') + ' "' + tempName + '"');
    $(".add_task_to_temp").show();
    $("#task_to_temp_err").html('');
    $('#inner_task_add').hide();
    $('#add-task-btn').hide();
    $(".popup_bg").css({
        "width": '600px'
    });
    $(".popup_form").css({
        "margin-top": "6px"
    });
    var strURL = HTTP_ROOT + "templates/add_template";
    $.post(strURL, {
        "temp_id": val,
        "temp_name": temp_name
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_task_add').show();
            $('#inner_task_add').html(data);
            $("#title").focus();
            $('.add-task-btn').show();
            $.material.init();
            $('textarea').autoGrow().keyup();
        }
    });
}

function removeTaskFromTemp(val, temp_name) {
    openPopup();
    temp_name = $('#textTemp_' + val).text();
    $(".remove_from_task").show();
    $(".proj_temp_name").html(_('Manage tasks for project plan') + ' "' + temp_name + '"');
    $('#inner_tasks').hide();
    $('#add-remove-btn').hide();
    $(".loader_dv").show();
    var strURL = HTTP_ROOT + "templates/remove_from_tasks";
    $.post(strURL, {
        "temp_id": val,
        "temp_name": temp_name
    }, function(data) {
        if (data) {
            $(".loader_dv").hide();
            $('#inner_tasks').show();
            $('#inner_tasks').html(data);
            $('.add-remove-btn').show();
        }
    });
}

function selectcaseAll(arg, i) {
    if (parseInt(arg)) {
        if ($('#checkAll').is(":checked")) {
            $(".ad-usr-prj").attr("checked", "checked");
            $('.rw-cls').css({
                'background-color': '#FFFFCC'
            });
            $("#taskAddBtns").show();
        } else {
            $(".ad-usr-prj").attr("checked", false);
            $('.rw-cls').css({
                'background-color': ''
            });
            $("#taskAddBtns").hide();
        }
    } else {
        var listing = "listing_" + i;
        if ($('.ad-usr-prj:checked').length == $('.ad-usr-prj').length) {
            $("#checkAll").attr("checked", "checked");
            $('#' + listing).css({
                'background-color': '#FFFFCC'
            });
            $("#taskAddBtns").show();
        } else {
            $("#checkAll").attr("checked", false);
            if ($('#actionChk' + i).is(":checked")) {
                $('#' + listing).css({
                    'background-color': '#FFFFCC'
                });
                $("#taskAddBtns").show();
            } else {
                $('#' + listing).css({
                    'background-color': ''
                });
                $("#taskAddBtns").hide();
            }
        }
    }
}

function validateTaskTemplateEdit() {
    var desc = document.getElementById('description_edit');
    var tmpl_id = $('#temp_id').val();
    $("#task_project_err_edit").html('');
    $("#prjtemploader_task_prj").show();
    $("#prj_btn_task_edit").hide();
    var errMsg;
    var done = 1;
    if ($('#title_edit').val().trim() == "") {
        errMsg = _("Title cannot be left blank!");
        $('#title_edit').focus();
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        $("#task_project_err_edit").html(errMsg);
        $("#prjtemploader_task_prj").hide();
        $("#prj_btn_task_edit").show();
        return false;
    } else {
        var url = HTTP_ROOT + 'templates/edit_template_task';
        $.post(url, {
            'tmpl_id': tmpl_id,
            'title': $('#title_edit').val().trim(),
            'description': $('#description_edit').val().trim()
        }, function(data) {
            if (data) {
                if (data.msg == 'success') {
                    showTopErrSucc('success', _("Project plan tasks updated successfully."));
                    $("#prjtemploader_task_prj").hide();
                    $("#prj_btn_task_edit").show();
                    removeTaskFromTemp(data.tmpl_id, '"' + data.tmpl_name + '"');
                }
            }
        }, 'json');
    }
}

function EditTaskProject(tempId) {
    $(".remove_from_task").hide();
    openPopup();
    $("#task_project_err_edit").html('');
    $(".task_project_edit").show();
    $("#header_task_prj").html(_("Edit"));
    $('#inner_task_project_edit').show();
    $(".loader_dv_tsk_prj").hide();
    var tmp_name = $('#title_' + tempId).html();
    var tmp_desc = $('#desc_' + tempId).html();
    $("#title_edit").val(trim(html_entity_decode(tmp_name))).keyup();
    $("#description_edit").val((trim(tmp_desc) != '---') ? trim(html_entity_decode(tmp_desc)) : '').keyup();
    $("#temp_id").val(tempId);
    $("#title_edit").focus();
    $.material.init();
    $('textarea').autoGrow().keyup();
}

function EditTask(tempId, tmp_name, pagenum) {
    openPopup();
    tmp_name = $('#textTemp_' + tempId).text().trim();
    $('#project_temp_err_edit').html('');
    $(".project_temp_popup_edit").show();
    $("#header_prj_task_temp").text(tmp_name);
    $('#inner_project_temp_edit').show();
    $(".loader_dv_prj").hide();
    $("#projtemptitle_edit").val(tmp_name).keyup();
    $("#hid_orig_projtemptitle_edit").val(tmp_name);
    $("#hid_temptitle_id").val(tempId);
    $("#hid_page_num").val(pagenum);
    $("#projtemptitle_edit").focus();
    $.material.init();
}

function save_edit_template() {
    var temp_title = $('#projtemptitle_edit').val();
    var orig_temp_title = $('#hid_orig_projtemptitle_edit').val();
    var temptitle_id = $('#hid_temptitle_id').val();
    var pageNum = $("#hid_page_num").val();
    $("#project_temp_err_edit").html('');
    var strURL = HTTP_ROOT + 'templates/ajax_template_edit';
    if (temp_title.trim() != '') {
        if (temp_title.trim() == orig_temp_title.trim()) {
            return false;
        } else {
            $("#prjtemploader_edit").show();
            $("#prj_btn_edit").hide();
            $.post(strURL, {
                "template_id": temptitle_id,
                "module_name": escape(temp_title.trim())
            }, function(data) {
                if (data) {
                    if (data.trim() == 'fail') {
                        $("#project_temp_err_edit").hide();
                        $("#prj_btn_edit").show();
                    } else if (data.trim() == 'exist') {
                        $("#project_temp_err_edit").hide();
                        $("#prj_btn_edit").show();
                        $("#prjtemploader_edit").hide();
                        $("#project_temp_err_edit").show();
                        $("#project_temp_err_edit").html(_("This Project plan already exists."));
                        return false;
                    } else if (data.trim() == 'invalid') {
                        $("#project_temp_err_edit").hide();
                        $("#prj_btn_edit").show();
                        $("#prjtemploader_edit").hide();
                        $("#project_temp_err_edit").show();
                        $("#project_temp_err_edit").html(_("Invalid project plan name. HTML tags are not allowed."));
                        return false;
                    } else {
                        if ((pageNum && parseInt(pageNum) == 1) || (pageNum == '')) {
                            document.location.href = HTTP_ROOT + 'templates/projects';
                        } else {
                            document.location.href = HTTP_ROOT + 'templates/projects?page=' + pageNum;
                        }
                        showTopErrSucc('success', _("Project plan updated successfully."));
                        $("#prjtemploader_edit").hide();
                    }
                }
            });
        }
    } else {
        $("#project_temp_err_edit").html(_("Project plan name can't be blank."));
        return false;
    }
}

function deltemplatecases(caseId, templateId) {
    var caseName = $('#title_' + caseId).html();
    if (confirm(_("Are you sure you want to remove") + " '" + formatText(ucfirst(caseName)) + "'?")) {
        $("#listing_" + caseId).fadeOut(1000);
        var strURL = HTTP_ROOT + 'templates/ajax_template_case_listing';
        $.post(strURL, {
            "templateId": templateId,
            "case_id": caseId
        }, function(data) {
            if (data) {
                $('#tsk_count_' + templateId).find('strong').text(data.count);
                if (data.count == 0) {
                    $('.remove_from_task').find('#inner_tasks').find('div.scrl-ovr').remove();
                    $('.remove_from_task').find('#inner_tasks').children('script').after("<table cellpadding=" + "0" + " cellspacing=" + "0" + " class=" + "col-lg-12 ad_prj_usr_tbl" + "><tr class=" + "rw-cls" + "><td align=" + "center" + "><div class=" + "add-tmp-btn" + "><span id=" + "excptAddContinue" + " >No task on this project plan</span></div></td></tr><tr class=" + "rw-cls" + "><td align=" + "center" + "><div class=" + "add-tmp-btn" + "><span id=" + "excptAddContinue" + " ><button class=" + "btn" + " type=" + "button" + " onclick=" + "addTempToTask(" + templateId + ",'',1)" + ">Add Task to Project Plan</button></span></div></td></tr></table>");
                    $('#inner_tasks').find('span#excptAddContinue').find('button.btn').addClass('btn_add_task_template');
                }
            }
        }, 'json');
    } else {
        return false;
    }
}

function remove_cases_template() {
    var done = 0;
    var case_name = '';
    $('#inner_tasks input:checked').each(function() {
        if ($(this).attr('id') !== 'checkAll') {
            case_name = case_name + ", " + $(this).attr('data-case-name');
            done++;
        }
    });
    case_name = case_name.replace(', ', '');
    if (done) {
        if (confirm(_("Are you sure you want to remove") + " '" + case_name + "'?")) {
            var templateId = $('#templateId').val();
            $('#inner_tasks input:checked').each(function() {
                if ($(this).attr('id') !== 'checkAll') {
                    var listid = $(this).attr('id');
                    var case_id = $(this).attr('value');
                    var listing = $("#" + listid).parents("tr").attr('id');
                    $("#" + listing).fadeOut(1000);
                    var strURL = HTTP_ROOT + 'templates/ajax_template_case_listing';
                    $.post(strURL, {
                        "templateId": templateId,
                        "case_id": case_id
                    }, function(data) {
                        if (data) {}
                    });
                }
            });
            showTopErrSucc('success', _('Task removed successfully'));
        } else {
            return false;
        }
    } else {
        showTopErrSucc('error', _('No task is selected to delete'));
        return false;
    }
}

function validateTaskTemplate() {
    $("#addtasktotemploader").show();
    $("#taskAddBtns").hide();
    $("#task_to_temp_err").html('');
    var errMsg;
    var done = 1;
    var titleIsEmpty = 0;
    $("input[name^='data[ProjectTemplateCase][title]']").each(function() {
        if ($(this).val().trim() == "") {
            titleIsEmpty = 1;
        }
    });
    if (titleIsEmpty == 1) {
        errMsg = _("Title cannot be left blank!");
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        $("#task_to_temp_err").html(errMsg);
        $("#addtasktotemploader").hide();
        $("#taskAddBtns").show();
        return false;
    } else {
        return true;
    }
}

function add_cases_project() {
    var pj_id = $('#proj_id').val();
    var temp_mod_id = $('#templateId').val();
    var projectName = $("#proj_id option:selected").text();
    var done = 1;
    if (pj_id == 0) {
        errMsg = _("Please select a project to add tasks.");
        done = 0;
    }
    if (done == 0) {
        var op = 100;
        showTopErrSucc('error', errMsg);
        return false;
    } else {
        $("#addtaskloader").removeClass('ldr-ad-btn');
        $("#taskAddBtns").hide();
        var strURL = HTTP_ROOT + "templates/";
        $.post(strURL + "ajax_add_template_cases", {
            "pj_id": pj_id,
            "temp_mod_id": temp_mod_id
        }, function(data) {
            if (data) {
                if (data == 1) {
                    $("#addtaskloader").addClass('ldr-ad-btn');
                    $("#taskAddBtns").show();
                    var op = 100;
                    showTopErrSucc('success', _('Tasks has been added to') + ' "' + projectName + '".');
                    closePopup();
                } else {
                    $("#addtaskloader").addClass('ldr-ad-btn');
                    $("#taskAddBtns").show();
                    var op = 100;
                    showTopErrSucc('error', _('Project plan is already added to this project!'));
                    return false;
                }
            }
        });
    }
}

function checkFilterItemChanges(jsonVal) {
    var status = true;
    if (typeof jsonVal != 'undefined') {
        jsonVal = JSON.parse(jsonVal);
        for (var prop in jsonVal) {
            if (jsonVal.hasOwnProperty(prop)) {
                if (jsonVal[prop] != localStorage[prop] && typeof localStorage[prop] != 'undefined') {
                    status = false;
                } else if (prop == "DATE" || prop == "DUE_DATE") {
                    if (jsonVal[prop] != localStorage[prop] && jsonVal[prop] != '' && jsonVal[prop] != 'any') {
                        status = false;
                    }
                }
            }
        }
    }
    if (status) {
        if ($('#filtered_items').html().trim() != '' && (typeof localStorage.SEARCHFILTER == 'undefined' || localStorage.SEARCHFILTER == '' || localStorage.SEARCHFILTER.substring(0, 5) != 'ftopt')) {
            $("#saveFilter").show();
            localStorage.setItem("is_saveFilter_set", 1);
            $("#saveFilter").html('<i class="material-icons">&#xE161;</i>');
            $("#saveFilter").attr('title', 'Save');
        } else {
            if (getHash() != 'kanban') {
                $("#saveFilter").hide();
            }
        }
    } else {
        if ($('#filtered_items').html().trim() != '') {
            $("#saveFilter").show();
            localStorage.setItem("is_saveFilter_set", 1);
            if (typeof localStorage.SEARCHFILTER != 'undefined' && localStorage.SEARCHFILTER != '' && localStorage.SEARCHFILTER.substring(0, 5) == 'ftopt') {
                $("#saveFilter").html('<i class="material-icons">&#xE161;</i>');
                $("#saveFilter").attr('title', 'Update');
            } else {
                $("#saveFilter").html('<i class="material-icons">&#xE161;</i>');
                $("#saveFilter").attr('title', 'Save');
            }
        }
    }
    if (getHash() == 'kanban' && parseInt($("#subtask-container").height()) < 70) {
        $("#saveFilter").hide();
    }
}

function saveFilterRecords() {
    $.post(HTTP_ROOT + "searchFilters/setDefaultValue", {}, function(res) {
        location.reload();
    })
}

function deleteFilterItem(id, name, value, obj) {
    if ($(obj).closest("td").children("span").length <= 1) {
        alert(_("At least one filter item is required."));
        return false;
    }
    if (confirm(_("Are you sure you want to delete this filter item ?"))) {
        $.post(HTTP_ROOT + "searchFilters/deleteItems", {
            id: id,
            name: name,
            value: value
        }, function() {
            $(obj).closest("span").remove();
        });
    }
}

function setTabSelection() {
    var obj = (typeof arguments[0] != 'undefined') ? arguments[0] : 0;
    if (obj) {
        $('.dtl_label_tag_tsk').removeClass('active');
        $(obj).parent('.dtl_label_tag_tsk').addClass('active');
    }
    var g_has = getHash();
    if (g_has == 'taskgroups' && obj) {
        remember_filters('TASKGROUPBY', 'milestone');
    }
    $("#filterSearch_id").removeClass("active-list");
    $('.cattab').removeClass('active-list');
    localStorage.setItem('SELECTTAB', 'links');
    if (typeof $('#caseMenuFilters').val() != 'undefined') {
        var CMF = ($('#caseMenuFilters').val().trim() == '') ? "cases" : $('#caseMenuFilters').val().trim();
        $("#" + CMF + "_id").addClass("active-list");
    }
}

function getkanbanFilters() {
    var caseSearch = $("#case_search").val();
    if (caseSearch.trim() == '') {
        caseSearch = $('#caseSearch').val();
    }
    $.post(HTTP_ROOT + 'SearchFilters/kanbanFilters', {
        projUniq: $('#projFil').val(),
        milestoneIds: $('#milestoneId').val(),
        case_srch: caseSearch,
        checktype: ''
    }, function(data) {
        $('#filterSearch_id_kanban').show();
        $("#ajaxViewFiltersKanban a[id ^='ftopt'],#manageFilterAnchor").remove();
        $("#ajaxViewFiltersKanban").append(tmpl("filterSearch_id_kanban_tmpl", data));
        countAllFilter = $("#ajaxViewFiltersKanban").find("a:not(#manageFilterAnchor)").length
        if (typeof localStorage.SEARCHFILTER != 'undefined' && localStorage.SEARCHFILTER != '') {
            if ($('#' + localStorage.SEARCHFILTER).length > 0) {
                $(".filter-dropdown-kanban").find('button a').html($('#' + localStorage.SEARCHFILTER).html());
                $(".filter-dropdown-kanban").find('button a').attr('title', $('#' + localStorage.SEARCHFILTER).html());
                $(".filter-dropdown-kanban").find('button a').attr('data-placement', 'left');
            } else {
                $(".filter-dropdown-kanban").find('button a').html(countAllFilter + " more...");
                $(".filter-dropdown-kanban").find('button a').attr('title', countAllFilter + " more...");
                localStorage.removeItem('SEARCHFILTER');
            }
        } else if (countAllFilter) {
            $("#filterSearch_id_kanban button a").html(countAllFilter + " more...");
            $("#filterSearch_id_kanban button a").attr('title', countAllFilter + " more...");
        } else {
            $("#filterSearch_id_kanban button a").html(_("Filter not available"));
            $("#filterSearch_id_kanban button a").attr('title', "Filter not available");
        }
    }, 'json');
}

function viewMore(caseUniqId) {
    var str = trim(caseUniqId, '/');
    window.location.hash = 'details/' + str;
}
$(document).on('click', '[id^="closeId"]', function(event) {
    var task_data = $(this).attr('id').split('@@@');
    var caseUniqId = task_data[1];
    $("#latestComment" + caseUniqId).find('.showDependents').toggleClass('Close ');
    event.stopPropagation();
});