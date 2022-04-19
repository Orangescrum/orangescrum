var caseapp = angular.module("case_dashboard_App", ["ngRoute", 'angularUtils.directives.dirPagination', 'ngSanitize', 'ui.select', 'xeditable', 'commonMethods']).provider('moment', function () {
    this.$get = function () {
        return moment
    }
});
caseapp.controller("activity_Controller", function ($scope, $http) {
    $scope.getActivity = function (URL, type, limit1, limit2, projid) {
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
        $http.post(URL, data, config).success(function (data, status, headers, config) {
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
                    }), config).success(function (piedata, status, headers, config) {
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
                                formatter: function () {
                                    return '<b>' + this.point.name + '</b>: ' + parseFloat(this.y) + ' %';
                                }
                            },
                            series: [{
                                    name: '# of Tasks Report',
                                    data: eval(piedata),
                                    size: '110%',
                                    innerSize: '50%',
                                    dataLabels: {
                                        formatter: function () {
                                            return this.y > 1 ? this.y + '%' : null;
                                        }
                                    }
                                }]
                        });
                    });
                }
            }
        }).error(function (data, status, headers, config) {});
    }
    $scope.setcurrent = function (d, i) {
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
            d[i].Easycase.legend = 0;
        }
        if (d[i].Easycase.legend == 1) {
            $scope.statusCount[ddate].v_new = $scope.statusCount[ddate].v_new + 1;
        }
        if (d[i].Easycase.legend == 2 || d[i].Easycase.legend == 4) {
            $scope.statusCount[ddate].v_replied = $scope.statusCount[ddate].v_replied + 1;
        }
        if (d[i].Easycase.legend == 5) {
            $scope.statusCount[ddate].v_resolved = $scope.statusCount[ddate].v_resolved + 1;
        }
        if (d[i].Easycase.legend == 3) {
            $scope.statusCount[ddate].v_closed = $scope.statusCount[ddate].v_closed + 1;
        }
    }
    $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
        $("img.lazy").lazyload({
            placeholder: "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        });
    });
});
caseapp.directive('onFinishRender', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit(attr.broadcasteventname ? attr.broadcasteventname : 'ngRepeatFinished');
                        if (!!attr.onFinishRender) {
                            $parse(attr.onFinishRender)(scope);
                        }
                    });
                }
            }
        }
    }
]);
caseapp.controller("overdue_Controller", function ($scope, $http) {
    $scope.loadOverdue = function (type) {
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
        $http.post(HTTP_ROOT + "users/ajax_overdue/", data, config).success(function (data, status, headers, config) {
            $scope.overdue_records = data;
            $("#moreOverdueloader").hide();
        });
    }
});
caseapp.config(['$routeProvider', '$locationProvider', function AppConfig($routeProvider, $locationProvider) {
        $routeProvider.when('/timelog', {
            templateUrl: '../angular_templates/timelog.html?v=' + RELEASE,
            controller: 'timelogController'
        }).when('/chart_timelog', {
            templateUrl: '../angular_templates/timelog_chart.html?v=' + RELEASE,
            controller: 'timelogChartController'
        }).when('/timesheet', {
            templateUrl: '../angular_templates/timesheet_daily.html?v=' + RELEASE,
            controller: 'timesheetDailyController'
        }).when('/timesheet_weekly', {
            templateUrl: '../angular_templates/timesheet_weekly.html?v=' + RELEASE,
            controller: 'timesheetWeeklyController'
        }).when('/tasks', {
            templateUrl: '../angular_templates/task.html?v=' + RELEASE,
            controller: 'taskController'
        });
        $locationProvider.hashPrefix("");
    }
]);
caseapp.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];
        if (angular.isArray(items)) {
            items.forEach(function (item) {
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
caseapp.controller('timesheetDailyController', function ($scope, $http, $interval, $timeout) {
    $scope.projects = {};
    $scope.projectM = {};
    $scope.taskM = {};
    $scope.week = {};
    $scope.usersnames = {};
    $scope.logs = {};
    $scope.getAllProjects = function () {
        var params_data = $.param({});
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "LogTimes/showAllProjects", params_data, config).success(function (data, status, headers, config) {
            $scope.projects = data.Projects;
        });
    }
    $scope.getAllProjects();
    $scope.get_timesheet_daily = function (d, type, curent_date, obj) {
        if (SES_TYPE > 2) {
            $('#daily_user_menu').hide();
        }
        $scope.HTTP_ROOT = HTTP_ROOT;
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (typeof d != 'undefined') {
            $scope.date = d;
        } else {
            $scope.date = moment().format("YYYY-MM-DD");
        }
        $scope.selected_day = $scope.date;
        $scope.current_day = moment().format("YYYY-MM-DD");
        $scope.prevday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', -1).format('YYYY-MM-DD');
        $scope.week.Sunday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 0).format('YYYY-MM-DD');
        $scope.week.Monday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 1).format('YYYY-MM-DD');
        $scope.week.Tuesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 2).format('YYYY-MM-DD');
        $scope.week.Wednesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 3).format('YYYY-MM-DD');
        $scope.week.Thursday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 4).format('YYYY-MM-DD');
        $scope.week.Friday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 5).format('YYYY-MM-DD');
        $scope.week.Saturday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 6).format('YYYY-MM-DD');
        $scope.nextday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 7).format('YYYY-MM-DD');
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
        urlHash = getHash();
        easycase.routerHideShow('timesheet');
        $http.post(HTTP_ROOT + "LogTimes/timesheet_daily", params_data, config).success(function (data, status, headers, config) {
            $('#caseLoader').hide();
            $('.hidetablelog').hide();
            $scope.logs = data.logtimes;
            if ($scope.logs.length == 0) {
                $('.timesheettogl.togl').show();
                $('.timesheettogl.no-hover').hide();
            } else {
                $('.timesheettogl.togl').hide();
                $('.timesheettogl.no-hover').show();
            }
            $scope.nextday = data.nextday;
            $scope.prevday = data.prevday;
            $scope.selected_day = data.selected_day;
            $scope.selected_date = data.selected_date;
            $scope.usersnames_all = data.users;
            $scope.usersnames.userselectedOption = data.userselectedOption;
        });
    }
    $scope.get_timesheet_daily();
    $scope.getTotalLog = function () {
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
            min = tot_min;
            if (tot_min != 0 && tot_min > 59) {
                total += parseInt(tot_min / 60);
                min = (tot_min % 60);
            }
        }
        total = total + ':' + min;
        return total;
    }
    $scope.updateButton = function () {
        if ($scope.hours.trim() != '') {
            var inpt = $scope.hours.trim();
            var char_restirict = /^[0-9\:]+$/.test(inpt);
            if (!char_restirict) {
                $scope.hours = inpt.substr(0, inpt.length - 1);
            }
            var t_inpt = inpt.split(":");
            var d_inpt = inpt.split(".");
            var len = t_inpt.length - 1;
            var d_len = d_inpt.length - 1;
            if (t_inpt[0].trim() != '') {
                var hr_len = t_inpt[0].length;
                if (hr_len > 2) {
                    $scope.hours = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', "Invalid time format. The format should be hh:mm.");
                } else if (hr_len == 2 && parseInt(inpt) > 23) {
                    $scope.hours = 23;
                    showTopErrSucc('error', "Oops! you are exceeding the per day limit of 24 hour");
                }
            }
            if (len >= 2 || d_len >= 2 || (len & d_len)) {
                $scope.hours = inpt.substr(0, inpt.length - 1);
                showTopErrSucc('error', "Invalid time");
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
                        $scope.hours = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', "Minute can not exceed 2 digit");
                    }
                }
            }
            $('#btnTimer').hide();
            $('#btnSave').show();
        } else {
            $('#btnSave').show();
            $('#btnTimer').hide();
        }
    }
    $scope.changeVal = function (e, s, data) {
        var err_msg = "The time format should be in hh:mm and take at max of 23:59 hours";
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
                        return "Invalid time";
                    }
                    if (sec_part > 59) {
                        showTopErrSucc('error', err_msg);
                        return "Invalid time";
                    }
                    if (first_part > 23) {
                        showTopErrSucc('error', err_msg);
                        return "Invalid time";
                    }
                }
                if (inpt.indexOf(":") == -1 && inpt > 23) {
                    $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', err_msg);
                    return "Invalid time";
                }
            }
        }
    }
    $scope.getProjectTasks = function () {
        if (typeof $scope.projectM.selected != 'undefined') {
            $scope.HTTP_ROOT = HTTP_ROOT;
            $('#caseLoader').show();
            params = {};
            params.project_id = $scope.projectM.selected.id;
            params.angular = 1;
            params.usrid = $scope.usersnames.userselectedOption.id;
            var params_data = $.param(params);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/getProjectTasks", params_data, config).success(function (data, status, headers, config) {
                $('#caseLoader').hide();
                $('.hidetablelog').hide();
                $scope.tasks = data.Tasks;
            });
        }
    }
    $scope.saveTimesheet = function () {
        if (typeof $scope.projectM.selected != 'undefined') {
            $('.timesheettogl.togl').hide();
            $('.timesheettogl.no-hover').show();
            $scope.HTTP_ROOT = HTTP_ROOT;
            $('#caseLoader').show();
            var done = 1;
            var project_id = (typeof $scope.projectM.selected == 'undefined') ? '' : $scope.projectM.selected.id;
            var task_id = (typeof $scope.taskM.selected == 'undefined') ? '' : $scope.taskM.selected.id;
            if (task_id == '') {
                showTopErrSucc('error', "Oops! you have not select a task!");
                done = 0;
            }
            var hrs = (typeof $scope.hours == 'undefined') ? '' : $scope.hours;
            if (hrs == '') {
                showTopErrSucc('error', "Oops! you have not entered hours!");
                done = 0;
            }
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
            params.usrid = $scope.usersnames.userselectedOption.id;
            var params_data = $.param(params);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/saveTimesheet", params_data, config).success(function (data, status, headers, config) {
                $('#caseLoader').hide();
                $('.hidetablelog').hide();
                $scope.hours = '';
                $scope.note = '';
                $scope.logs.push(data.logs);
            });
        } else {
            showTopErrSucc('error', "Oops! you have not select a project!");
        }
    }
    $scope.toggleAddLog = function () {
        $scope.projectM.selected = {};
        $scope.taskM.selected = {};
        $("#isBillable").prop('checked', false);
        $("#ngh,#mgm").val('');
        $('.timesheettogl').toggle();
    }
    ;
});
caseapp.controller('EditableRowCtrl', function ($scope, $filter, $http) {
    $scope.projects = {};
    $scope.projectM = {};
    $scope.taskM = {};
    $scope.tasks = {};
    $scope.showBillable = function (log) {
        var text_t_show = 'Billable'
        if (log.LogTime.is_billable == 1) {
            log.LogTime.is_billable = true;
            var text_t_show = 'Billable'
        } else {
            log.LogTime.is_billable = false;
            var text_t_show = 'Non billable'
        }
        return text_t_show;
    }
    ;
    $scope.checkName = function (data, id) {
        if (id === 2 && data !== 'awesome') {
            return "Username 2 should be `awesome`";
        }
    }
    ;
    $scope.saveLogs = function (data, id) {
        angular.extend(data, {
            id: id
        });
        if (typeof data.id != 'undefined') {
            var params_data = $.param(data);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            $http.post(HTTP_ROOT + "LogTimes/updateTimesheet", params_data, config).success(function (data, status, headers, config) {
                if (typeof $scope.$$prevSibling.getTasks != 'undefined') {
                    $scope.$$prevSibling.getTasks($scope.$$prevSibling.prevDate, $scope.$$prevSibling.nextDate);
                    $('#myModalTimeSheet').modal('hide');
                }
            });
        } else {
            showTopErrSucc('error', "Oops! we have experienced some problem. Please try again!");
        }
    }
    ;
    $scope.deleteLog = function (data, index) {
        if (confirm('Are you sure you want to delete this time?')) {
            $scope.logs.splice(index, 1);
            if (typeof data.LogTime.log_id != 'undefined') {
                var params_data = $.param(data);
                var config = {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    }
                }
                $http.post(HTTP_ROOT + "LogTimes/deleteTimesheet", params_data, config).success(function (data, status, headers, config) {
                    if (typeof $scope.$$prevSibling.getTasks != 'undefined') {
                        $scope.$$prevSibling.getTasks($scope.$$prevSibling.prevDate, $scope.$$prevSibling.nextDate);
                        $('#myModalTimeSheet').modal('hide');
                    }
                });
            } else {
                showTopErrSucc('error', "Oops! we have experienced some problem. Please try again!");
            }
        }
    }
    ;
    $scope.addUser = function () {
        $scope.inserted = {
            id: $scope.users.length + 1,
            name: '',
            status: null,
            group: null
        };
        $scope.users.push($scope.inserted);
    }
    ;
    $scope.changeVal = function (e, s, data) {
        var e1 = $scope.logs[e].LogTime.total_hours;
        console.log($scope.logs[e].LogTime.total_hours);
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
                showTopErrSucc('error', "Invalid time");
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
                        showTopErrSucc('error', "Minute can not exceed 2 digit");
                        return false;
                    }
                    if (sec_part > 59) {
                        $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', "Invalid time format");
                        return false;
                    }
                    if (first_part > 23) {
                        $scope.logs[e].LogTime.total_hours = inpt.slice(0, inpt.indexOf(":") - 1) + inpt.slice(inpt.indexOf(":"));
                        showTopErrSucc('error', "Invalid time format");
                        return false;
                    }
                }
                if (inpt.indexOf(":") == -1 && inpt > 23) {
                    $scope.logs[e].LogTime.total_hours = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', "Invalid time format");
                    return false;
                }
            }
            $scope.getTotalLog();
        }
    }
});
caseapp.controller('timesheetWeeklyController', function ($scope, $http, $interval, $timeout) {
    $scope.disabled = undefined;
    $scope.HTTP_ROOT = HTTP_ROOT;
    $scope.IsVisible = false;
    $scope.person = {};
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
    $scope.cdate = moment().format("YYYY-MM-DD");
    $scope.isCurrentWeek = 0;
    $scope.SES_TYPE = SES_TYPE;
    $scope.changeDate = function (d) {
        if (typeof d != 'undefined') {
            $scope.date = d;
        } else {
            $scope.date = moment().format("YYYY-MM-DD");
        }
        $scope.prevDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', -1).format('YYYY-MM-DD');
        $scope.week.Sunday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 0).format('M/DD');
        $scope.week.Monday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 1).format('M/DD');
        $scope.week.Tuesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 2).format('M/DD');
        $scope.week.Wednesday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 3).format('M/DD');
        $scope.week.Thursday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 4).format('M/DD');
        $scope.week.Friday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 5).format('M/DD');
        $scope.week.Saturday = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 6).format('M/DD');
        $scope.nextDate = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 7).format('YYYY-MM-DD');
        $scope.getTasks($scope.prevDate, $scope.nextDate);
        $scope.weekTime = moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 0).format('MM-DD-YYYY') + "   -   " + moment($scope.date, "YYYY-MM-DD").startOf('week').add('days', 6).format('MM-DD-YYYY');
        $scope.checkCurrentWeek();
    }
    $scope.getAllUsers = function () {
        var params_data = $.param({});
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/showAllUsers", params_data, config).success(function (data, status, headers, config) {
            $scope.users = data.Users;
            $scope.Projects = data.Projects;
            $scope.person.selected = data.Person;
        });
    }
    $scope.getAllTasks = function (project_id, pname) {
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
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/getTasksByProject", params_data, config).success(function (data, status, headers, config) {
            $scope.ProjectTasks = data.tasks;
            $('.tloader').hide();
        });
    }
    $scope.addTaskRow = function (id, tname, case_no) {
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
                    "Friday": "",
                    "FridayF": "",
                    "Thursday": "",
                    "ThursdayF": "",
                    "Wednesday": "",
                    "WednesdayF": "",
                    "Tuesday": "",
                    "TuesdayF": "",
                    "Monday": "",
                    "MondayF": "",
                    "Sunday": "",
                    "SundayF": ""
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
                "task_name": tname + "|__|" + "uniqid" + "|__|" + case_no,
                "project_name": $scope.project_Name
            },
            "Project": {
                "uniq_id": ""
            }
        };
        $scope.tasks.push(newArray);
        $scope.IsVisible = false;
    }
    $scope.calculate = function () {
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
    }
    $scope.getTasks = function (prev, next) {
        user_id = (typeof $scope.person.selected != 'undefined') ? $scope.person.selected.id : SES_ID;
        var params_data = $.param({
            'startdate': prev,
            'enddate': next,
            'usrid': user_id
        });
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(HTTP_ROOT + "logTimes/timesheet_weekly", params_data, config).success(function (data, status, headers, config) {
            $scope.tasks = data.logtimes;
            $scope.calculate();
        });
    }
    $scope.sum = function (obj) {
        var sum = 0;
        for (var el in obj) {
            if (obj.hasOwnProperty(el)) {
                if (!isNaN(obj[el]) && obj[el] != '') {
                    sum += parseFloat(obj[el]);
                }
            }
        }
        return sum;
    }
    $scope.changeVal = function (e, s) {
        e1 = $scope.tasks[e].LogTime.inner[s];
        if (e1.trim() != '') {
            var inpt = e1.trim();
            var char_restirict = /^[0-9\:]+$/.test(inpt);
            if (!char_restirict) {
                $scope.tasks[e].LogTime.inner[s] = inpt.substr(0, inpt.length - 1);
            }
            var t_inpt = inpt.split(":");
            var d_inpt = inpt.split(".");
            var len = t_inpt.length - 1;
            var d_len = d_inpt.length - 1;
            if (len >= 2 || d_len >= 2 || (len & d_len)) {
                $scope.tasks[e].LogTime.inner[s] = inpt.substr(0, inpt.length - 1);
                showTopErrSucc('error', "Invalid time");
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
                        $scope.tasks[e].LogTime.inner[s] = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', "Minute can not exceed 2 digit");
                        return false;
                    }
                    if (sec_part > 59) {
                        $scope.tasks[e].LogTime.inner[s] = inpt.substr(0, inpt.length - 1);
                        showTopErrSucc('error', "Invalid time format");
                        return false;
                    }
                    if (first_part > 23) {
                        $scope.tasks[e].LogTime.inner[s] = inpt.slice(0, inpt.indexOf(":") - 1) + inpt.slice(inpt.indexOf(":"));
                        showTopErrSucc('error', "Invalid time format");
                        return false;
                    }
                }
                if (inpt.indexOf(":") == -1 && inpt > 23) {
                    $scope.tasks[e].LogTime.inner[s] = inpt.substr(0, inpt.length - 1);
                    showTopErrSucc('error', "Invalid time format");
                    return false;
                }
            }
            hrs = $scope.tasks[e].LogTime.inner[s].split(":");
            hr = (typeof hrs[0] != 'undefined' && hrs[0] != '') ? parseInt(hrs[0]) * 3600 : 0;
            min = (typeof hrs[1] != 'undefined' && hrs[1] != '') ? parseInt(hrs[1]) * 60 : 0;
            $scope.tasks[e].LogTime.inner[s.slice(0, -1)] = parseInt(hr) + parseInt(min);
            $scope.tasks[e][0].ttime = $scope.sum($scope.tasks[e].LogTime.inner);
            $scope.calculate();
        }
    }
    $scope.saveData = function (e, s, m) {
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
        $http.post(HTTP_ROOT + "logTimes/saveTimesheet", params_data, config).success(function (data, status, headers, config) {
            showTopErrSucc('success', "Time log saved successfully");
        });
    }
    $scope.saveAllData = function () {
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
                    var params_data = {
                        log_id: log_id,
                        task_id: task_id,
                        date: date,
                        sec: sec,
                        user_id: user_id,
                        project_id: project_id
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
        $http.post(HTTP_ROOT + "logTimes/saveAllTimesheet", params_data, config).success(function (data, status, headers, config) {
            $scope.showLoader = 0;
            showTopErrSucc('success', "Time sheet data saved successfully.");
        });
    }
    $scope.showDailyView = function (i, s) {
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
            $http.post(HTTP_ROOT + "LogTimes/timesheet_daily", params_data, config).success(function (data, status, headers, config) {
                $('#caseLoader').hide();
                $scope.logs = data.logtimes;
            });
        }
    }
    $scope.checkCurrentWeek = function () {
        currentTimestamp = moment($scope.cdate).format("X");
        prevTimestamp = moment($scope.prevDate).format("X");
        nextTimestamp = moment($scope.nextDate).format("X");
        if (prevTimestamp > currentTimestamp || currentTimestamp > nextTimestamp) {
            $scope.isCurrentWeek = 1;
        } else {
            $scope.isCurrentWeek = 0;
        }
    }
    $scope.delete = function (i) {
        if ($scope.tasks[i].LogTime.log_id == '') {
            $scope.tasks.splice(i, 1);
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
            $http.post(HTTP_ROOT + "logTimes/deleteTimesheetWeek", params_data, config).success(function (data, status, headers, config) {
                $scope.tasks.splice(i, 1);
            });
        }
    }
    $scope.visiblePopup = function () {
        $scope.IsVisible = true;
        $scope.ProjectTasks = {};
        $scope.searchP.name = '';
        $scope.searchT.name = '';
    }
    $("#weeklyDatePicker").datetimepicker({
        format: 'MM-DD-YYYY'
    });
    $('#weeklyDatePicker').on('dp.change', function (e) {
        value = $("#weeklyDatePicker").val();
        firstDate = moment(value, "MM-DD-YYYY").day(0).format("MM-DD-YYYY");
        lastDate = moment(value, "MM-DD-YYYY").day(6).format("MM-DD-YYYY");
        $("#weeklyDatePicker").val(firstDate + "   -   " + lastDate);
        $scope.changeDate(moment(firstDate).format("YYYY-MM-DD"));
    });
    $scope.changeDate();
    $scope.getAllUsers();
    $scope.$on('$viewContentLoaded', function (event) {
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
    });
});
caseapp.controller('timelogChartController', function ($scope, $http, $interval, $timeout) {
    $scope.drawPie = function () {
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
            $(".container_pie").closest('td').mouseenter(function (res) {
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
                            formatter: function () {
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
                            labelFormatter: function () {
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
            $(".container_pie").closest('td').mouseleave(function (res) {
                $(this).find(".pophoverCnt").hide();
                if ($('.tipsy:hover').length) {
                    return false;
                }
            });
        }
    }
    $scope.pad = function (d) {
        return (d < 10) ? '0' + d.toString() : d.toString();
    }
    $scope.get_chart_timelog = function (d) {
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
        $http.post(HTTP_ROOT + "logTimes/showChartView", params_data, config).success(function (data, status, headers, config) {
            $('#caseLoader').hide();
            $('.hidetablelog').hide();
            $('#TimeLog_paginate').hide();
            $scope.records = data;
            $timeout(function () {
                $scope.drawPie();
            }, 1000);
        });
    }
    $scope.get_chart_timelog();
    $scope.getNumber = function (num) {
        arr = new Array();
        for (var i = 0; i < num; i++) {
            arr.push(i);
        }
        return arr;
    }
    $scope.addindex = function (num) {
        $scope.dayIndex++;
    }
    $scope.checkForPopup = function (number) {
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
})
caseapp.controller('timelogController', function ($scope, $http) {
    $scope.entries = {};
    $scope.totalItems = 0;
    $scope.SES_ID = SES_ID;
    $scope.SES_TYPE = SES_TYPE;
    $scope.shortLength = function (title, len, len2, len3) {
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
    $scope.fetchTimelog = function (column, page) {
        if (typeof column != 'undefined' && column == "") {
            $scope.column = $scope.column;
        } else {
            $scope.column = column;
            $scope.orderby = "asc";
        }
        if (typeof column != 'undefined' && column != '') {
            $('#isSort').val("1");
            if (typeof (getCookie("TASKSORTBY") != 'undefined') && getCookie("TASKSORTBY") == column) {
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
        $http.post(HTTP_ROOT + "requests/time_log", params_data, config).success(function (data, status, headers, config) {
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
            tlog_btn = '<a ' + d_y_n + ' onclick="createlog(' + data.logtimes.task_id + ',\'' + t_ttl + '\')" href="javascript:void(0)" class="<%=logtimes.page%> anchor log-more-time btn btn-raised btn-sm btn_cmn_efect"><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Log more time</a><a ' + d_y_n + ' href="javascript:void(0)" onclick="ajax_timelog_export_csv();" class="btn btn-raised btn-sm btn_cmn_efect"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export(.csv)</a>';
            $('.btn_tlog_top_fun').html(tlog_btn);
            $('#caseLoader').hide();
            $('#TimeLog_paginate').show();
            $('[rel=tooltip]').tipsy({
                gravity: 's',
                fade: true
            });
            if (SES_TYPE == 3 && SES_ID != 13902) {
                $("#dropdown_menu_resource").closest('li').hide();
            } else {
                $("#dropdown_menu_resource").closest('li').show();
            }
            if (typeof data.projUser != 'undefined') {
                PUSERS = data.projUser;
            }
            var user_found = false;
            if (SES_TYPE < 3 || SES_ID == 13902) {
                var usrhtml = "<option value=''>Select User</option>";
                $.each(PUSERS, function (key, val) {
                    $.each(val, function (k1, v1) {
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
                setTimeout(function () {
                    $('#btn-reset-timelog').show()
                }, 200);
            } else {
                $('#btn-reset-timelog').hide();
            }
            $(document).on('click', '#ui-datepicker-div', function (e) {
                e.stopPropagation();
            });
            $(document).on('click', '.ui-datepicker-prev', function (e) {
                e.stopPropagation();
            });
            $(document).on('click', '.ui-datepicker-next', function (e) {
                e.stopPropagation();
            });
            displayMenuProjects('dashboard', '6', '');
            materialInitialize();
            $(".checkbox").find('.checkbox-material:nth-of-type(2)').remove();
        });
    }
    $scope.fetchTimelog();
}).filter('moment', function (moment) {
    return function (input, options) {
        return moment(input).locale('eng').format(options.split('\'')[1])
    }
});
caseapp.controller('taskController', function ($scope,$cacheFactory,$compile, $http, osCommonMethods, $interval, $timeout) {
    $scope.osCommonMethods = osCommonMethods;
    $scope.SES_TYPE = SES_TYPE;
    $scope.HTTP_ROOT = HTTP_ROOT;
    $scope.GLOBALS_TYPE = GLOBALS_TYPE;
    $scope.USER_SUB_NOW = USER_SUB_NOW;
    $scope.CURRENT_EXPIRED_PLAN = EXPIRED_PLAN;
//    console.log($scope.cacheObject);
//    if(typeof $scope.cacheObject != 'object'){
//        $scope.cacheObject = $cacheFactory("newCacheInstance");
//    }

    if (typeof localStorage['taskColumn'] == 'undefined')
        localStorage.setItem('taskColumn', JSON.stringify({'tb_title': true, 'tb_message':false,'tb_assign': true, 'tb_priority': true, 'tb_updates': true,'tb_gantt_start_date':false,'tb_est_hrs':false,'tb_client_status':false, 'tb_status': true, 'tb_duedate': true}));
    ltc = JSON.parse(localStorage['taskColumn']);
    $scope.tb_title = ltc['tb_title'];
    $scope.tb_message = ltc['tb_message'];
    $scope.tb_assign = ltc['tb_assign'];
    $scope.tb_priority = ltc['tb_priority'];
    $scope.tb_updates = ltc['tb_updates'];
    $scope.tb_gantt_start_date = ltc['tb_gantt_start_date'];
    $scope.tb_est_hrs = ltc['tb_est_hrs'];
    $scope.tb_client_status = ltc['tb_client_status'];
    $scope.tb_status = ltc['tb_status'];
    $scope.tb_duedate = ltc['tb_duedate'];

    if (typeof localStorage['selectedTab'] == 'undefined')
        localStorage.setItem('selectedTab', '');
    $scope.selectedTab = localStorage['selectedTab'];
    
    $scope.totids = '';
    $scope.totuids = '';
    $scope.openId = '';
    $scope.prjId ='';
    $scope.lnth =0;
    
//     $scope.removeAllCache = function () {
//        $scope.cacheObject.removeAll();
//    };
    $scope.defaultColumn = function (){
        $scope.tb_title = true;
        $scope.tb_message = false;
        $scope.tb_assign = true;
        $scope.tb_priority = true;
        $scope.tb_updates = true;
        $scope.tb_gantt_start_date = false;
        $scope.tb_est_hrs = false;
        $scope.tb_client_status = false;
        $scope.tb_status = true;
        $scope.tb_duedate = true;
        $scope.$apply();
    }
    $scope.showAllColumn = function (){
        $scope.tb_title = true;
        $scope.tb_message = true;
        $scope.tb_assign = true;
        $scope.tb_priority = true;
        $scope.tb_updates = true;
        $scope.tb_gantt_start_date = true;
        $scope.tb_est_hrs = true;
        $scope.tb_client_status = true;
        $scope.tb_status = true;
        $scope.tb_duedate = true;
        $scope.$apply();
    }
    $scope.ajaxSorting = function (type,cases,$event){ 
        $('#isSort').val("1");
        if (typeof (getCookie("TASKSORTBY") != 'undefined') && getCookie("TASKSORTBY") == type) {
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
        $('.sorting_arw').each(function(){ $(this).html('<i class="material-icons tsk_sort show_icons">&#xE164;</i>');});
        var el = $('.sort' + type).children('.sorting_arw').html(tcls);
        $scope.fetchTask('','',$scope.newPageNumber);
        }
   
    $scope.fetchTask = function (column, page, casePage) {
        easycase.routerHideShow('tasks');
        $('#caseViewSpan_angular').show();
        $scope.newPageNumber = casePage;
        var params = {};
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
        params.projFil = $('#projFil').val();
        var cko = getCookie('TASKGROUPBY');
        if (params.projFil == 'all' && DEFAULT_TASKVIEW == 'task_group' && cko == 'milestone') {
            remember_filters('TASKGROUPBY', '');
            checkHashLoad('tasks');
            return false;
        }
        params.caseId = $('#caseId').val();
        params.startCaseId = $('#caseStart').val();
        params.caseResolve = $('#caseResolve').val();
        params.caseNew = $('#caseNew').val();
        params.caseChangeType = $('#caseChangeType').val();
        params.caseChangePriority = $('#caseChangePriority').val();
        params.caseChangeDuedate = $('#caseChangeDuedate').val();
        params.caseChangeAssignto = $('#caseChangeAssignto').val();
        params.customfilter = $('#customFIlterId').val();
        if (params.caseId || params.startCaseId || params.caseResolve || params.caseNew) {
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
        params.caseStatus = $('#caseStatus').val();
        params.priFil = $('#priFil').val();
        params.caseTypes = $('#caseTypes').val();
        params.caseMember = $('#caseMember').val();
        params.caseComment = $('#caseComment').val();
        params.caseAssignTo = $('#caseAssignTo').val();
        params.caseDate = $('#caseDate').val();
        params.case_date = $('#caseDateFil').val();
        params.case_due_date = $('#casedueDateFil').val();
        var taskgroup_fil = '';
        var hashtag = parseUrlHash(getHash());
        params.caseSearch = $("#case_search").val();
        if (params.caseSearch.trim() == '') {
            params.caseSearch = $('#caseSearch').val();
        } else {
            $("#caseSearch").val(params.caseSearch);
        }
        $("#case_search").val("");
        params.caseTitle = $('#caseTitle').val();
        params.caseDueDate = $('#caseDueDate').val();
        params.caseNum = $('#caseNum').val();
        params.caseLegendsort = $('#caseLegendsort').val();
        params.caseAtsort = $('#caseAtsort').val();
        params.caseMenuFilters = $('#caseMenuFilters').val();
        params.milestoneIds = $('#milestoneIds').val();
        params.case_srch = $('#case_srch').val();
        params.caseCreateDate = $('#caseCreatedDate').val();
        params.projIsChange = $('#projIsChange').val();
        if (params.caseMenuFilters != 'milestone' && params.caseMenuFilters != 'files') {
            if (params.caseMenuFilters === "") {
                params.caseMenuFilters = "cases";
            }
            $('.cattab').removeClass('active-list');
            if (localStorage['SELECTTAB'] == "links") {
                $('#' + params.caseMenuFilters + '_id').addClass('active-list');
            } else {
                $("#filterSearch_id").addClass('active-list');
            }
            var ck_page = getCookie('TASKGROUPBY');
            if (ck_page == 'milestone' && page != 'taskgroup') {
                if (localStorage['SELECTTAB'] == "links") {
                    $('#' + params.caseMenuFilters + '_id').addClass('active-list');
                } else {
                    $("#filterSearch_id").addClass('active-list');
                }
            }
        } 
        params.caseUrl = "";
        params.detailscount = 0;
        var reply = 0;
        if (params.projIsChange != params.projFil) {
        }
        if (params.caseMenuFilters == 'milestone') {
            params.mstype = "";
            params.mlstype = $('#checktype').val();
            if (params.mlstype == 'completed') {
                params.mstype = 0;
            } else {
                params.mstype = 1;
            }
        }
        setTimeout('', 500);
        var menu_filter = params.caseMenuFilters;
        var hashtag = parseUrlHash(getHash());
        var strAction = 'case_project';
        if (page == 'taskgroup')
            window.location.hash = 'taskgroup';
        else if (page == 'tasks')
            window.location.hash = 'tasks';
        params.searchMilestoneUid = '';
        if (strAction == 'case_taskgroup') {
            if (typeof hashtag[1] != 'undefined') {
                params.searchMilestoneUid = hashtag[1];
            }
        }
        if (strAction == 'case_project') {
            strURL = HTTP_ROOT + 'requests/'
        }



        params.casePage = casePage;


        var params_data = $.param(params);
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        $http.post(strURL + strAction, params_data, config).success(function (res, status, headers, config) {
            if (res) {
                $(".show_total_case").show();
                $scope.totalItems = res.caseCount;
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
                $scope.res = res;
                for (var key in $scope.res.caseAll) {
                    $scope.lnth += 1;
                     $scope.totids += $scope.res.caseAll[key].Easycase.id + "|";
                     $scope.totuids += $scope.res.caseAll[key].Easycase.uniq_id + "|";                     
                     if($scope.caseUrl == $scope.res.caseAll[key].Easycase.uniq_id)
                         $scope.openId = (key+1);
                     if(key == 0 && $scope.projUniq != 'all')
                         $scope.prjId = $scope.res.caseAll[key].Easycase.project_id;
                }
                $('#caseViewDetails').hide();
                $('#caseLoader').hide();

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
                        showTopErrSucc('success', 'Tasks are closed.');
                    } else {
                        showTopErrSucc('success', 'Task is closed.');
                    }
                    casePage = 1;
                } else if (startCaseId) {
                    $('#caseStart').val('');
                    var chk = startCaseId.indexOf(",");
                    if (chk != -1) {
                        showTopErrSucc('success', 'Tasks are started.');
                    } else {
                        showTopErrSucc('success', 'Task is started.');
                    }
                    casePage = 1;
                } else if (caseResolve) {
                    $('#caseResolve').val('');
                    var chk = caseResolve.indexOf(",");
                    if (chk != -1) {
                        showTopErrSucc('success', 'Tasks are resolved.');
                    } else {
                        showTopErrSucc('success', 'Task is resolved.');
                    }
                    casePage = 1;
                } else if (caseNew) {
                    $('#caseNew').val('');
                    var chk = caseNew.indexOf(",");
                    if (chk != -1) {
                        showTopErrSucc('success', 'Status of tasks are changed to new.');
                    } else {
                        showTopErrSucc('success', 'Task status is changed to new.');
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
              
                var caseMenuFilters = $('#caseMenuFilters').val();
                
                 if (page == 'details') {
                    easycase.ajaxCaseDetails(hashtag[1], 'case', 0);
                } else {
                    easycase.routerHideShow('tasks');
                    if (ioMsgClicked == 1) {
                        ioMsgClicked = 0;
                    }
                    $('#detail_section').html('');
                }
                var caseMenuFilters = $('#caseMenuFilters').val();
                var x = $("#getcasecount").val();
                $("#showcasecount").html(x);
                if (caseMenuFilters && caseMenuFilters == "milestone") {
                    $("#mileStoneFilter").show();
                } else {
                    $("#mileStoneFilter").hide();
                }
                }
            if (caseId || startCaseId || caseResolve || caseNew) {
               resetBreadcrumbFilters(strURL, $('#caseStatus').val(), $('#priFil').val(), $('#caseTypes').val(), $('#caseMember').val(), $('#caseComment').val(), $('#caseAssignTo').val(), 1, $('#caseDateFil').val(), $('#casedueDateFil').val(), '', '', '', '', $('#milestoneIds').val());
            }
            if (!caseId && !startCaseId && !caseResolve && !caseNew) {
                var clearCaseSearch = $('#clearCaseSearch').val();
                var isSort = $('#isSort').val();
                $('#clearCaseSearch').val('');
               resetBreadcrumbFilters(strURL, $('#caseStatus').val(), $('#priFil').val(), $('#caseTypes').val(), $('#caseMember').val(), $('#caseComment').val(), $('#caseAssignTo').val(), 0, $('#caseDateFil').val(), $('#casedueDateFil').val(), casePage, $("#caseSearch").val(), $('#clearCaseSearch').val(), $('#caseMenuFilters').val(), $('#milestoneIds').val());
                downloadFile();
            }
           
        });
    }
    /** Initialize the all the checkbox and tool tip after render the template **/
    $scope.checkboxInitialize = function () { 
            if (projFil == 'all') {
                $("#dropdown_menu_comments").parent('li').hide();
            remember_filters('ALL_PROJECT', 'all');
            } else {
            remember_filters('ALL_PROJECT', '');
            }
         loadCaseMenu(HTTP_ROOT + "requests/ajax_case_menu", {
                    "projUniq": $('#projFil').val(),
                    "pageload": 0,
                    "page": "dashboard",
                    "filters": $('#caseMenuFilters').val(),
                    'case_date': $('#caseDateFil').val(),
                    'case_due_date': $('#casedueDateFil').val(),
                    'caseStatus': $('#caseStatus').val(),
                    'caseTypes': $('#caseTypes').val(),
                    'priFil': $('#priFil').val(),
                    'caseMember': $('#caseMember').val(),
                    'caseComment': $('#caseComment').val(),
                    'caseAssignTo': $('#caseAssignTo').val(),
                    'caseSearch': $("#caseSearch").val(),
                    'milestoneIds': $('#milestoneIds').val(),
                    'checktype': $('#checktype').val()
                });
        ustr= $scope.totuids ; 
        if (ustr.charAt(ustr.length - 1) == '|') {
            ustr = ustr.substr(0, ustr.length - 1);
        } 
        $("#detail_paging_ids").val(ustr);        
        $('.hideSub').closest('tr').nextUntil('tr[id^="empty_milestone_tr"]').hide();
        materialInitialize();
        $('.row_tr td:nth-child(2) .check-drop-icon .dropdown-toggle').on('mouseenter', function () {
            $(this).attr('aria-expanded', true);
            $(this).parent().addClass('open');
        });
        $('.row_tr').on('mouseleave', function () {
            $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').attr('aria-expanded', false);
            $(this).find('td:nth-child(2) .check-drop-icon .dropdown-toggle').parent().removeClass('open');
        });
        $('.task_group_accd .plus-minus-accordian span.dropdown').on('mouseenter', function () {
            $(this).find('a.main_page_menu_togl').attr('aria-expanded', true);
            $(this).addClass('open');
        });
        $('.task_group_accd').on('mouseleave', function () {
            $(this).find('.plus-minus-accordian span.dropdown .dropdown-toggle').attr('aria-expanded', false);
            $(this).find('.plus-minus-accordian span.dropdown').removeClass('open');
        });
        
        $scope.displayStatusBar();
        
        if (($('#caseId').val() || $('#caseStart').val() || $('#caseResolve').val() || $('#caseNew').val() || $('#caseChangeType').val() || $('#caseChangeDuedate').val() || $('#caseChangePriority').val() ||  $("#caseChangeAssignto").val()) && ($('#email_arr').val() != '')) {
                    $.post(strURL + "ajaxemail", {
                        'json_data': $('#email_arr').val(),
                        'type': 1
                    });
                }
        
        if ($('#lviewtype').val() == 'compact') {
            $('.tsk_tbl').addClass('compactview_tbl');
            $('#topaction').addClass('compactview_action');
        } else {
            $('.tsk_tbl').removeClass('compactview_tbl');
            $('#topaction').removeClass('compactview_action');
    }
        
         var params = parseUrlHash(getHash());
         
        if (params[0] != "tasks" && params[0] != "taskgroup") {
            parent.location.hash = "tasks";
        }      
       
        $('.sortby_btn').removeAttr('disabled');
        $('.sortby_btn').removeClass('disable-btn');
        
         if (projFil == 'all') {
            $("#dropdown_menu_comments").parent('li').hide();
        } else {
            $("#dropdown_menu_comments").parent('li').show();
        }
                
        $('[rel=tooltip]').tipsy({gravity: 's', fade: true});
        $('.f-tab').tipsy({gravity: 'n', fade: true});
        changeCBStatus();
        subscribeClient();
    }
    /** End **/
    /** Est Hr **/
    $scope.estHrFormat = function(d){
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);

        var hDisplay = h > 0 ? h + (h == 1 ? " hr  " : " hrs ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " min  " : " mins ") : "";
        return hDisplay + mDisplay;        
    }
    /** End **/
    /** Display Status Bar **/
    $scope.displayStatusBar = function(){
        $.post(HTTP_ROOT + "requests/ajax_case_status", {
                "projUniq": $('#projFil').val(),
                 "pageload": 0,
                 "caseMenuFilters":$('#caseMenuFilters').val(),
                 'case_date': $('#caseDateFil').val(),
                 'case_due_date': $('#casedueDateFil').val(),
                 'caseStatus': $('#caseStatus').val(),
                 'caseTypes': $('#caseTypes').val(),
                 'priFil': $('#priFil').val(),
                 'caseMember': $('#caseMember').val(),
                 'caseComment': $('#caseComment').val(),
                 'caseAssignTo': $('#caseAssignTo').val(),
                 'caseSearch': ($("#case_search").val().trim() != '')?$("#case_search").val():$('#caseSearch').val(),
                 'milestoneIds': $('#milestoneIds').val(),
                 'checktype': $("#checktype").val()
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
                    if ($('#caseMenuFilters').val() != 'milestone' && $('#caseMenuFilters').val() != 'closecase' && n == -1) {
                    var closed = $("#closedcaseid").val();
                    if (closed != 0) {
                    $("#upperDiv_not").show();
                    if (closed == 1) {
                    $("#closedcases").html("Including <b>" + closed + "</b> 'Closed' task");
                    } else {
                    $("#closedcases").html("Including <b>" + closed + "</b> 'Closed' tasks");
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
    /** End **/

    /* Set the checkbox third parameter */
    $scope.getCld = function (r) {
        if (r.legend != 3 && r.type_id != 10) {
            d = r.uniq_id;
        } else if (r.type_id != 10) {
            d = 'closed';
        } else {
            d = 'update';
        }
        return d;
    }
    /* End */
    /* set the showQuickActiononList of  tasks */
    $scope.showQuickActiononList = function (r) {
        actiononList = 0;
        if (r.isactive == 1 && (r.legend == 1 || r.legend == 2 || r.legend == 4) && ((SES_TYPE == 1 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (SES_TYPE == 2 && (EDIT_TASK == 1 || EDIT_TASK == 2)) || (r.user_id == SES_ID) || (SES_TYPE == 3 && EDIT_TASK == 1))) {
            actiononList = 1;
        }
        return actiononList;
    }
    /* End */
    /* Get the priority */
    $scope.getPriority = function (casePriority) {
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
    /* End */
    /** Change the action of the Task **/
    $scope.actiononTask = function (taskid, taskNum, taskUid, actiontype, index) {
        $.post(HTTP_ROOT + 'easycases/taskactions', {
            'taskId': taskid,
            'taskUid': taskUid,
            'type': actiontype,
            'angular': 1
        }, function (res) {
            if (res) {
                var hashtag = parseUrlHash(urlHash);
                if (res.succ) {
                    $('#caseId').val("");
                    $('#curRow' + taskid).find('span.label').removeClass('wip closed resolved label-danger label-warning label-success label-info fade-red fade-green fade-blue fade-orange');

                    if (actiontype.toLowerCase() == 'resolve') {
                        $('#caseResolve').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        }
                    }
                    if (actiontype.toLowerCase() == 'start') {
                        $('#caseStart').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        }
                    }
                    if (actiontype.toLowerCase() == 'new') {
                        $('#caseNew').val('');
                        if (res.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(res.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(res.task_details.Easycase.assign_to, res.task_details.Easycase.gantt_start_date, res.task_details.Easycase.due_date, estimated_hr, res.task_details.Easycase.project_id, res.task_details.Easycase.id, res.task_details.Easycase.uniq_id, res.isAssignedUserFree);
                        }
                    }
                    $scope.res.caseAll = updateScopeObj($scope.res.caseAll,res.result.caseDet,index);
                    $scope.$apply();
                    if (actiontype.toLowerCase() == 'new') {
                        showTopErrSucc('success', 'Status of task #' + taskNum + ' changed to ' + actiontype + '.');
                    } else {
                        showTopErrSucc('success', 'Task #' + taskNum + ' ' + actiontype + 'ed.');
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
                }
            }
        }, 'json');
    }
    /* End*/
    /* set new cases */
    $scope.setNewCase = function (id, caseno, uniqid) {
        setNewCase(id, caseno, uniqid);
    }
    /* End */
    /* set start cases */
    $scope.startCase = function (id, caseno, uniqid) {
        startCase(id, caseno, uniqid);
    }
    /* End */
    /* set case resolved */
    $scope.caseResolve = function (id, caseno, uniqid) {
        caseResolve(id, caseno, uniqid);
    }
    /* End */
    /* set case resolved */
    $scope.setCloseCase = function (id, caseno, uniqid) {
        setCloseCase(id, caseno, uniqid);
    }
    /* End */
    /* start timer case resolved */
    $scope.startTimer = function (id, title, uniqid, projectid, projectname) {
        title = escape(htmlspecialchars(title, 3));
        startTimer(id, title, uniqid, projectid, projectname);
    }
    /* End */
    /* Copy task timer case resolved */
    $scope.copytask = function (csuid, case_id, case_no, prj_id, old_prj_nm,indx) {
        var new_prj_id = prj_id;
        var new_prj_nm = htmlspecialchars(old_prj_nm);
        $("#cpprjloader").show();
        $.post(HTTP_ROOT + "easycases/copy_task_to_project", {
            "project_id": new_prj_id,
            "old_project_id": prj_id,
            "case_id": case_id,
            "case_no": case_no,
            'is_multiple': 0,
            'taskCopy': '1',
            'angular': 1
        }, function (res) {
            r = JSON.parse(res);
            $("#cpprjloader").hide();
            if (parseInt(r.id)) {
                if (getCookie('TASKGROUPBY') != 'milestone') {
                    showTopErrSucc('success', "Task #" + case_no + " copied ");
                } else {
                    showTopErrSucc('success', "Task copied successfully ");
                }
                $scope.res.caseAll = appendScopeObj($scope.res.caseAll,r.result.caseDet);
                $scope.$apply();

            } else {
                if (getCookie('TASKGROUPBY') != 'milestone') {
                    showTopErrSucc('error', "Unable to copy task #" + case_no + " ");
                } else {
                    showTopErrSucc('error', "Unable to copy the task");
                }
                return false;
            }
        });
    }
    /* End */
    /** copy Multiple task to project **/
    $scope.cptoProject= function(id, obj, alltask){
        cptoProject(id, obj, alltask);
    }
    /* end **/
    /* Move to project */
    $scope.mvtoProject = function (count, $event,alltask) {
        mvtoProject(count, $event.currentTarget,alltask);
    }
    /* End */
     /** Create project template **/
    $scope.createPojectTemplate= function(id, obj, alltask){
        createPojectTemplate(id, obj, alltask);
    }
    /* end **/
    /* start timer case resolved */
    $scope.trackEventWithIntercom = function (t1, t2) {
        trackEventWithIntercom(t1, t2);
    }
    /* End */
    /* restore task */
    $scope.restoreFromTask = function (id, pid, cno) {
        restoreFromTask(id, pid, cno);
    }
    /* Remove from task */
    $scope.removeFromTask = function (case_id, pjid, case_no, index) {
        var val = new Array();
        val.push(case_id);
        if (val.length != '0') {
            if (confirm("Are you sure you want to remove task# " + case_no + "?")) {
                $('#caseLoader').show();
                var pageurl = $('#pageurl').val();
                var url = pageurl + "archives/case_remove";
                $.post(url, {
                    "val": val,
                    'chk': 1
                }, function (data) {
                    if (data) {
                        showTopErrSucc('success', 'Task(s) have been removed.');
                        $scope.res.caseAll = removeScopeObj($scope.res.caseAll,index);                        
                        $scope.$apply();
                    }
                });
            }
        } else {
            alert("No task selected!");
        }
    }
    /* End */
    /* move task */
    $scope.moveTask = function (id, cno, v, pid) {
        moveTask(id, cno, v, pid);
    }
    /* End */
    /* move task */
    $scope.removeTask = function (id, cno, v, pid) {
        removeTask(id, cno, v, pid);
    }
    /* End */
    /* removeThisCase task */
    $scope.removeThisCase = function (count, Emid, id, Em_milestone_id, case_no, user_id) {
        removeThisCase(count, Emid, id, Em_milestone_id, case_no, user_id);
    }
    /* End */
    /* Implement change case type */
    $scope.changeCaseType = function (id, caseno) {
        changeCaseType(id, caseno);
    }
    /* End */
    /* Implement change status */
    $scope.changestatus = function (caseId, statusId, statusName, statusTitle, caseUniqId,index) {
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
            "statusTitle": statusTitle,
			"angular" : 1
        }, function (data) {
            if (data) {
                $('#' + typlod).hide();				
				$scope.res.caseAll = updateScopeObj($scope.res.caseAll,data.result.caseDet,index);
				$scope.$apply();				
            }
        }, 'json').always(function () {
            $('#' + typlod).hide();
            $('#' + tsktype).html(statusTitle);
            $('#' + tsktype).show();
        });
    }
    /* End */
    /* Implement search of case type */
    $scope.seachitems = function ($event) {
        seachitems($event.currentTarget);
    }
    /* End */
    /* show the parent tasks */
    $scope.showRecurringInfo = function (id) {
        showRecurringInfo(id);
    }
    /* End */
    /* show the parent tasks */
    $scope.showParents = function (id, uniqid, children) {
        showParents(id, uniqid, children);
    }
    /* End */
    /* show the depends tasks */
    $scope.showDependents = function (id, uniqid, children) {
        showDependents(id, uniqid, children);
    }
    /* End */
    /* set the session storage for timer */
    $scope.setSessionStorage = function (v1, v2) {
        setSessionStorage(v1, v2);
    }
    /* End */
    /* Create the timelog for the task */
    $scope.createlog = function (casesid, title, index) {
        $('#caseLoader').show();
        var logid = typeof arguments[2] != 'undefined' ? arguments[2] : '';
        var taskTitle = typeof arguments[1] != 'undefined' ? escape(htmlspecialchars(arguments[1], 3)) : '';
        var dataTaskId = typeof arguments[5] != 'undefined' ? arguments[5] : '';
        var dataPrjnm = typeof arguments[6] != 'undefined' ? unescape(arguments[6]) : '';
        var clkdDateExst = typeof arguments[3] != 'undefined' ? arguments[3] : '';
        var userID = typeof arguments[4] != 'undefined' ? arguments[4] : '';
        $.post(HTTP_ROOT + "easycases/check_dependant_action_allowed", {
            cid: casesid
        }, function (dependant_task_action_allowed) {
            $('#caseLoader').hide();
            if (dependant_task_action_allowed && dependant_task_action_allowed == 'No') {
                showTopErrSucc('error', 'Dependant tasks are not closed.');
                return false;
            } else {
                var prjunid = $('#projFil').val();
                var hashtag = parseUrlHash(urlHash);
                if (logid != '' && prjunid == 'all') {
                    var prjunid = $('#CS_project_id').val();
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
                    showTopErrSucc('error', 'You are not authorized to modify.');
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
                $('#tsmn1').val('0:30');
                $('#tskdesc').val('').keyup();
                $('input[name=log_id]').remove();
                $('#lgtimebtn').attr('disabled', false);
                $('#lgtimebtn').removeClass('loginactive');
                $(".slct_task >span").html("Select Task");
                if (clkdDateExst) {
                    $("#workeddt1").val(formatDate('MMM DD, YYYY', clkdDateExst));
                    $("#workeddt1").datepicker({
                        format: 'MMM DD, YYYY',
                        changeMonth: false,
                        changeYear: false,
                        hideIfNoPrevNext: true,
                        autoclose: true
                    });
                    $("#workeddt1").datepicker("update", new Date(clkdDateExst));
                } else {
                    $("#workeddt1").datepicker({
                        format: 'MMM DD, YYYY',
                        changeMonth: false,
                        changeYear: false,
                        hideIfNoPrevNext: true,
                        autoclose: true
                    });
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
                $("#hidden_angular_log").val(index);
                materialInitialize();
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
                getTimelogActivity(prjunid);

                if (prjunid == 'all') {
                    prjunid = $('#CS_project_id').val();
                }
                var t_pid_val = $('#projFil').val();
                if (t_pid_val == 'all') {
                    if (logid != '') {
                        prjunid = $('[data-id^="log_prjuid_' + logid + '"]').attr('data-puid');
                    }
                }
                $.post(HTTP_ROOT + "easycases/existing_task", {
                    'projuniqid': prjunid,
                    'list': 'list',
                    'tid': casesid
                }, function (data) {
                    if (data) {
                        $("#log_task_results").html(data);
                        if (casesid != 0) {
                            var cstitle = $('#pname_dashboard a').html();
                            if (typeof cstitle == 'undefined') {
                                cstitle = $('#pname_dashboard_hid').val();
                            }
                            $('#log_task_id').val(casesid);
                            if (taskTitle.trim() != '' || casesid != '') {
                                $('.slct_task > span').text($("#logTask_" + casesid).text());
                            }
                            if (cstitle.length > 60) {
                                $('#tskttl').val(cstitle);
                            } else {
                                $('#tskttl').val(cstitle);
                            }
                            cnt = "<a href='javascript:void(0);'>" + cstitle + "</a>";
                            $("#pname_dashboard_log").html(cnt);
                            $("#prjsid").val(prjunid);
                        }
                        if (rsrch == "") {
                            $('.resource-select').find('.dropdownjs').find('ul').html('');
                            var usrhtml = "<option value=''>Select User</option>";
                            if (SES_TYPE < 3) {
                                $.each(PUSERS, function (key, val) {
                                    $.each(val, function (k1, v1) {
                                        var usrid = v1['User']['id'];
                                        var selected = '';
                                        usrhtml += "<option value='" + usrid + "' " + selected + ">" + v1['User']['name'] + "</option>";
                                    });
                                });
                            } else if (SES_TYPE == 3) {
                                $.each(PUSERS, function (key, val) {
                                    $.each(val, function (k1, v1) {
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
                        }
                        $(".loader_dv").hide();
                        $('#inner_log').show();
                        if (casesid == 0) {
                            var csprj = $('#pname_dashboard a').html();
                            if (typeof csprj == 'undefined') {
                                csprj = $('#pname_dashboard_hid').val();
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
//                        if (logid != '') {
//                            $.ajax({
//                                url: HTTP_ROOT + "easycases/timelog_details",
//                                data: {
//                                    'projuniqid': prjunid,
//                                    logid: logid
//                                },
//                                method: 'post',
//                                dataType: 'json',
//                                success: function (response) {
//                                    setEditTimeLog(response);
//                                    project_timelog_details(response.task_id);
//                                }
//                            });
//                        } else {
                            project_timelog_details(casesid);
                        //}
                        }
                });
            }
        });
    }
    /* End */
    /* Edit task task */
    $scope.editask = function (uniqid, puniqid, pname, index) {
        pname = htmlspecialchars(pname);
        editask(uniqid, puniqid, pname, index);
    }
    /* End */
    /* Create archive task */
    $scope.archiveCase = function (id, cno, pid, dtlsid,index) {
        var prjunid = $('#projFil').val();
        if (prjunid == 'all' && id == 'all') {
            showTopErrSucc('error', 'Oops! You are in "All" project. Please choose a project.');
            return false;
        }
        var al_id = [];
        var al_cno = '';
        var al_cno_d = '';
        var chked = 0;
        var typ = '';
        if (id == 'all') {
            typ = 'all';
            $('input[id^="actionChk"]').each(function (i) {
                if ($(this).is(":checked")) {
                    var t_vl = $(this).val();
                    t_vl = t_vl.split('|');
                    al_id.push(t_vl[0]);
                    al_cno += t_vl[1] + ',';
                    al_cno_d += ' #' + t_vl[1] + ',';
                    chked = 1;
                }
            });
            if (chked == 0) {
                showTopErrSucc('error', "Please check atleast one task to archive");
                return false;
            } else {
                al_cno = trim(al_cno, ',');
                al_id = trim(al_id, ',');
                al_cno_d = trim(al_cno_d, ',');
            }
        }
        if (id == 'all') {
            var conf = confirm("All the selected task(s) including closed task(s) will be archived.\nAre you sure you want to proceed?");
        } else {
            var conf = confirm("Are you sure you want to archive the task #" + cno + " ?");
        }
        if (conf == false) {
            return false;
        } else {
            if (id == 'all') {
                id = al_id;
                cno = al_cno;
            }
            $('#caseLoader').show();
            var strurl = HTTP_ROOT + "easycases/archive_case";
            $.post(strurl, {
                "id": id,
                "cno": cno,
                "pid": pid,
                'typ': typ
            }, function (data) {
                if (data) {
                    if (id.indexOf(',') != -1) {
                        var idArr = id.split(',');
                        $.each(idArr, function (i, v) {
                            var curRow = "curRow" + v;
                            $("#" + curRow).fadeOut(500, function () {
                                $(this).remove();
                            });
                        });
                        $scope.checkboxInitialize();
                    } else {
                        var curRow = "curRow" + id;
                        $("#" + curRow).fadeOut(500, function () {
                            $(this).remove();
                        });
                        $scope.res.caseAll = removeScopeObj($scope.res.caseAll,index);
                        $scope.$apply();
                    }
                    $("#" + dtlsid).remove();
                    $('#caseLoader').hide();
                    $('#caseResolve').val('');
                    if (typ == 'all') {
                        showTopErrSucc('success', "Task " + al_cno_d + " archived successfully.");
                    } else {
                        showTopErrSucc('success', "Task #" + cno + " is archived.");
                    }
                }
            });
        }
    }
    /* End */
    /* Create archive task */
    $scope.deleteCase = function (id, cno, pid, dtlsid, recurring,index) {
        if (confirm("Are you sure you want to delete the task #" + cno + " ?")) {
            if (recurring == 1) {
                if (!confirm("This is a recurring task would you like to proceed?")) {
                    return false;
                }
            }
            var curRow = "curRow" + id;
            $("#" + curRow).fadeOut(500);
            var strurl = HTTP_ROOT + "easycases/delete_case";
            $.post(strurl, {
                "id": id,
                "cno": cno,
                "pid": pid
            }, function (data) {
                if (data == 0) {
                    $("#" + curRow).fadeIn(100);
                    showTopErrSucc('error', "Failed to delete task #" + cno + ". Please try again.");
                } else {
                    $scope.res.caseAll = removeScopeObj($scope.res.caseAll,index);                    
                    var mid = $("#" + curRow).attr('data-mid');
//                    $("#" + curRow).remove();
//                    $("#" + dtlsid).remove();
                    $('#caseResolve').val('');
                    showTopErrSucc('success', "Task #" + cno + " is deleted.");
                }
            });
        }
    }
    /* End */
    /* set and display assign to me */
    $scope.displayAssignToMem = function (csId, project, caseAssgnUid, caseUniqId, page, cno, client_status) {
        if (!page) {
            page = '';
        }

        if (countJS(PUSERS) && PUSERS[project]) {
            $scope.appendAssignUsers(csId, project, caseUniqId, page, cno, caseAssgnUid, client_status);
        } else if ($('#assgnload' + csId).length || $('#detAssgnload' + csId).length) {
            $.post(HTTP_ROOT + "easycases/ajax_assignto_mem", {
                "project": project
            }, function (data) {
                if (data) {
                    PUSERS = data;
                    $scope.appendAssignUsers(csId, project, caseUniqId, page, cno, caseAssgnUid);
                    $("img.lazy").lazyload({
                        placeholder: HTTP_ROOT + "img/lazy_loading.png"
                    });
                }
            });
        } else {
        }
    }

    /**** multiple Status change*/
    $scope.multipleCaseAction = function (hidid) {
        var prjunid = $('#projFil').val();
        if (prjunid == 'all') {
            showTopErrSucc('error', 'Oops! You are in "All" project. Please choose a project.');
            return false;
        }
        var idfor = Array();
        var caseid = Array();
        var splt = Array();
        var done = 1;
        var cscnt = 0;
        var casenos = "";
        var x = $('#hid_cs').val();
        for (var i = 1; i <= x; i++) {
            var id = "actionChk" + i;
            if (document.getElementById(id).disabled == false) { 
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
                var msg = "started";
            }
            if (hidid == "caseResolve") {
                var msg = "resolved";
            }
            if (hidid == "caseId") {
                var msg = "closed";
            }
            if (hidid == "caseNew") {
                var msg = "changed to new";
            }
            showTopErrSucc('error', "Task #" + casenos + " cannot be " + msg + "!");
            if (cscnt == 1 && msg) {
            } else if (msg) {
            }
        }
        if (done) {
            document.getElementById(hidid).value = caseid;
            document.getElementById('slctcaseid').value = idfor;
            refreshActvt = 1;
            $scope.fetchTask('','',$scope.newPageNumber);
        }
    }
    /** End **/
    /** Multiple */
    $scope.ajaxassignAllTaskToUser = function(alltask){
        var is_multiple = 0;
        var projFil = $('#projFil').val();
        if (projFil == 'all') {
            showTopErrSucc('error', 'Oops! You are in "All" project. Please choose a project.');
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
                    showTopErrSucc('error', "Please check atleast one task to assign");
                    return false;
                }
                var project_id = $('#curr_sel_project_id').val();
                is_multiple = 1
                case_id = '';
                var title = 'Assign selected task(s)';
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
                    materialInitialize();
                    $(".select").dropdown();
                }
            });
        }
    }
    /** End **/
    $scope.appendAssignUsers = function (csId, project, caseUniqId, page, cno, caseAssgnUid, client_status) {
        if (page != 'details')
            $('#showAsgnToMem' + csId).html('<li class="pop_arrow_new"></li>');
        else
            $('#detShowAsgnToMem' + csId).html('<li class="pop_arrow_new" style="margin-left:1%;"></li>');
        for (ui in PUSERS[project]) {
            var t1 = PUSERS[project][ui].User.name;
            if (client_status == 1 && PUSERS[project][ui].CompanyUser.is_client == 1) {
            } else {
                if (PUSERS[project][ui].User.id == SES_ID) {
                    var t2 = 'me';
                    var t = PUSERS[project][ui].User.id;
                    if (page == 'details')
                        $('#detShowAsgnToMem' + csId).append($compile('<li rel="tooltip" title="' + t1 + '" class="memHover" ><a href="javascript:void(0);" ng-click="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\',\'' + cno + '\',\'' + caseAssgnUid + '\')">me</a></li>')($scope))
                    else
                        $('#showAsgnToMem' + csId).append($compile('<li rel="tooltip" title="' + t1 + '" class="memHover" ><a href="javascript:void(0);" ng-click="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\')">me</a></li>')($scope))
                } else {
                    var t2 = PUSERS[project][ui].User.name;
                    var t = PUSERS[project][ui].User.id;
                    if (page == 'details')
                        $('#detShowAsgnToMem' + csId).append($compile('<li rel="tooltip" title="' + t1 + '" class="memHover ttc"><a href="javascript:void(0);" ng-click="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\',\'' + cno + '\',\'' + caseAssgnUid + '\')">' + shortLength(t2, 15) + '</a></li>')($scope));
                    else
                        $('#showAsgnToMem' + csId).append($compile('<li rel="tooltip" title="' + t1 + '" class="memHover ttc"><a href="javascript:void(0);" ng-click="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'' + t + '\')">' + shortLength(t2, 15) + '</a></li>')($scope));
                }
            }
        }
        if (page == 'details')
            $('#detShowAsgnToMem' + csId).append($compile('<li rel="tooltip" title="Unassigned" class="memHover ttc"><a href="javascript:void(0);" ng-click="detChangeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'0\',\'' + cno + '\',\'' + caseAssgnUid + '\')">Nobody</a></li>')($scope));
        else
            $('#showAsgnToMem' + csId).append($compile('<li rel="tooltip" title="Unassigned" class="memHover ttc"><a href="javascript:void(0);" ng-click="changeAssignTo(\'' + csId + '\', \'' + caseUniqId + '\',\'0\')">Nobody</a></li>')($scope));
    }
    $scope.changeAssignTo = function (caseId, caseUniqId, assignId) {
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
            "assignId": assignId,
            "angular" : 1
        }, function (data) {
            if (data) {
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
                indx = 0; 
                 for (var key in $scope.res.caseAll) {
                     if($scope.res.caseAll[key].Easycase.id == data.result.caseDet.Easycase.id){
                         indx = key;
            }
                 }
                $scope.res.caseAll = updateScopeObj($scope.res.caseAll,data.result.caseDet,indx);
                $scope.$apply();
            }
        }, 'json');
    }
    /* End */
    /* change priority */
    $scope.detChangepriority = function (caseId, priority, caseUniqId, cno, index) {
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
            }, function (data) {
                if (data) {
                    $('#' + prilod).hide();
                    $("#" + showUpdPri).show();
                    $scope.res.caseAll[index].Easycase.priority = priority;
                    $scope.res.caseAll = updateScopeObj($scope.res.caseAll,$scope.res.caseAll[index],index);
                    $scope.$apply();
                    $("#" + showUpdPri + ' .quick_action .prio_lmh').removeClass('prio_high prio_mediem prio_low').addClass('prio_' + data.protyTtl.toLowerCase());
                    $('#' + showUpdPri).attr('data-priority', priority)
                }
            }, 'json');
        }
    }
    /* End */
    /* get getStatus */
    $scope.getStatus = function (typeid, legend) {
        return easycase.getStatus(typeid, legend);
    }
    /* End */
    /* change case due date */
    $scope.changeCaseDuedate = function (id, caseno) {
        changeCaseDuedate(id, caseno);
    }
    /* End */
    /**Display the due date **/
    $scope.displayDatePick = function (id) {
        d = $("#set_due_date_" + id).val();
        $("#set_due_date_" + id).val('');
        $(".datepicker").hide();
        if (d) {
            var caseId = id;
            var datelod = "datelod" + caseId;
            var showUpdDueDate = "showUpdDueDate" + caseId;
            var old_duetxt = $("#" + showUpdDueDate).html();
            $("#" + showUpdDueDate).html("");
            $("#" + datelod).show();
            var text = '';
            $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
                "caseId": caseId,
                "duedt": d,
                "text": text
            }, function (data) {
                if (data) {
                    $("#" + datelod).hide();
                    if (typeof data.success != 'undefined' && data.success == 'No') {
                        showTopErrSucc('error', data.message);
                        $("#" + showUpdDueDate).html(old_duetxt);
                        return false;
                    }
                    $("#" + showUpdDueDate).html(data.top + '<span class="due_dt_icn"></span>');
                    index = 0;
                    for (var key in $scope.res.caseAll) {       
                        if ($scope.res.caseAll[key].Easycase.id == id) {            
                           index = parseInt(key);
                           $scope.res.caseAll[key].Easycase.csDuDtFmt = data.top;
                           $scope.res.caseAll[key].Easycase.csDueDate = data.top;
                }
                    }  
                    $scope.res.caseAll = updateScopeObj($scope.res.caseAll,$scope.res.caseAll[index],index);
                    $scope.$apply();
                }
            }, 'json');
        }
    }
    
    /** End **/
    /* change  due date */
    $scope.changeDueDate = function (caseId, duedt, text, caseUniqId) {
        var datelod = "datelod" + caseId;
        var showUpdDueDate = "showUpdDueDate" + caseId;
        var old_duetxt = $("#" + showUpdDueDate).html();
        $("#" + showUpdDueDate).html("");
        $("#" + datelod).show();
        $("#t_" + caseUniqId).remove();
        $.post(HTTP_ROOT + "easycases/ajax_change_DueDate", {
            "caseId": caseId,
            "duedt": duedt,
            "text": text
        }, function (data) {
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
                index = 0;
                for (var key in $scope.res.caseAll) {       
                    if ($scope.res.caseAll[key].Easycase.id == caseId) {            
                       index = parseInt(key);
                       $scope.res.caseAll[key].Easycase.csDuDtFmt = data.top;
                       $scope.res.caseAll[key].Easycase.csDueDate = data.top;
                    }
                }   

                $scope.res.caseAll = updateScopeObj($scope.res.caseAll,$scope.res.caseAll[index],index);
                $scope.$apply();
                
                
                
                if (data.isAssignedUserFree != 1) {
                    var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                    openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
                }
            }
        }, 'json');
    }
    /* End */
    /* Add quick Task */
    $scope.AddQuickTask = function () {
        var mid = '';
        is_change = $('#projIsChange').val().trim();
        $('#inline_task_error').html('&nbsp;');
        $('.new_qktask_mc').css('margin-top', '0px');

        var proj_id = $('#CS_project_id').val().trim();
        if (is_change == 'all' && mid == '') {
            showTopErrSucc('error', 'Please select the project you want to add the task.');
            return false;
        } else {
            var titl = $scope.qkname.trim();
            if (titl != '') {
                $(".quicktsk_tr button").prop('disabled', true);
                $(".quicktsk_tr button .material-icons").css('color', '#bdbdbd');
                $('#caseLoader').show();
                var params_data = $.param({'title': titl, 'project_id': proj_id, 'type': 'inline', 'mid': mid, 'angular': 1});
                var config = {headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}
                $http.post(HTTP_ROOT + "easycases/quickTask", params_data, config).success(function (res, status, headers, config) {
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
                        showTopErrSucc('success', 'Task posted successfully.');
                        $scope.qkname = '';
                        $('#inline_qktask_angular').focus();
                        $('#inline_qktask_angular').val('');
                        $('#inline_qktask_angular').blur();
                        $scope.res.caseAll = appendScopeObj($scope.res.caseAll,res.result.caseDet);                        
                        $scope.$apply();
                        $('.empty_task_tr').hide();
                    }
                    var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
                    var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
                    var event_name = sessionStorage.getItem('SessionStorageEventValue');
                    if (eventRefer && event_name) {
                        trackEventLeadTracker(event_name, eventRefer, sessionEmail);
                    }
                });
            }
        }
    }
    $scope.blurqktask = function() {
        var inpt = $('#inline_qktask_angular').val().trim();
        $('#inline_task_error').html('&nbsp;');
        if (inpt == '') {
            $('.quicktsk_tr_lnk').toggle();
            $('.quicktsk_tr').toggle();
        }
    }
    /* End */
    /** Set the Local storage **/
    $scope.setLocalStorage = function (t, m) {
        taskColumn = JSON.parse(localStorage['taskColumn']);
        taskColumn[t] = m;
        localStorage.setItem('taskColumn', JSON.stringify(taskColumn));
    }
    /**End**/
    /** Set the template for the display of task **/
    $scope.setColumnTemplate = function (obj, indx) {
        taskColumn = JSON.parse(localStorage['taskColumn']);
        for (var key in taskColumn) {
            taskColumn[key] = false;
            $scope.key = false;
        }
        for (i = 0; i < obj.length; i++) {
            taskColumn[obj[i]] = true;
            k = obj[i];
        }

        $scope.tb_title = taskColumn['tb_title'];
        $scope.tb_assign = taskColumn['tb_assign'];
        $scope.tb_priority = taskColumn['tb_priority'];
        $scope.tb_updates = taskColumn['tb_updates'];
        $scope.tb_status = taskColumn['tb_status'];
        $scope.tb_duedate = taskColumn['tb_duedate'];
        localStorage.setItem('selectedTab', indx);
        $scope.selectedTab = indx;

        localStorage.setItem('taskColumn', JSON.stringify(taskColumn));
    }
    /** End **/


    $scope.fetchTask('', '', 1);

}).filter('moment', function (moment) {
    return function (input, options) {
        return moment(input).locale('eng').format(options.split('\'')[1])
    }
});
caseapp.filter('keylength', function () {
    return function (input) {
        if (!angular.isObject(input)) {
            return '0';
        }
        return Object.keys(input).length;
    }
})
caseapp.filter("splitTask", function () {
    return function (input, options) {
        task_dtl = input.split('||');
        return task_dtl[options];
    }
});
caseapp.filter("splitTask1", function () {
    return function (input, options) {
        task_dtl = input.split('|__|');
        return task_dtl[options];
    }
});
caseapp.filter("formatText", function () {
    return function (input, options) {
        return formatText(nl2br(input));
    }
});
caseapp.filter("momentSecond", function () {
    return function (input, options) {
        tarr = new Array();
        tarr[0] = Math.floor(input / 3600);
        input %= 3600;
        tarr[1] = Math.floor(input / 60);
        m = (tarr[1] != '0') ? tarr[1] + ' mins' : '';
        h = (tarr[0] != '0') ? tarr[0] + ' hrs' : '';
        return (h != '' || m != '') ? h + " " + m : '---';
    }
});
caseapp.filter("formatdate", function () {
    return function (time, options) {
        var out_time = time.substr(0, (time.lastIndexOf(':')));
        var out_time_arr = time.split(':');
        var out_mode = parseInt(out_time_arr[0]) < 12 ? 'am' : 'pm';
        var out_hr = parseInt(out_time_arr[0]) > 12 ? parseInt(out_time_arr[0]) - 12 : parseInt(out_time_arr[0]);
        var out_min = parseInt(out_time_arr[1]);
        return (out_hr > 0 ? out_hr : 12) + ':' + (out_min < 10 ? '0' : '') + out_min + '' + out_mode;
    }
});
caseapp.filter("momentSecond1", function () {
    return function (input, options) {
        tarr = new Array();
        if (input) {
            tarr[0] = Math.floor(input / 3600);
            input %= 3600;
            tarr[1] = Math.floor(input / 60);
            m = (tarr[1] != '0') ? tarr[1] : '00';
            h = (tarr[0] != '0') ? tarr[0] : 0;
            return (h != '' || m != '') ? h + ":" + m : '';
        } else {
            return "0:00";
        }
    }
});
caseapp.directive('mydatepicker', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            $(element).datepicker({
                altField: "#CS_due_date",
                showOn: "button",
                format: 'mm/dd/yyyy',
                buttonImage: HTTP_ROOT + "img/images/calendar.png",
                buttonStyle: "background:#FFF;",
                changeMonth: false,
                changeYear: false,
                minDate: 0,
                hideIfNoPrevNext: true,
                onSelect: function (dateText, inst) {
                }
            });
        }
    };
});



caseapp.controller("upcoming_Controller", function ($scope, $http) {
    $scope.loadUpcoming = function (type) {
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
        $http.post(HTTP_ROOT + "users/ajax_upcoming/", data, config).success(function (data, status, headers, config) {
            $scope.upcoming_records = data;
            $("#moreOverdueloader").hide();
        });
    }
});


/** Copy from script_v1 **/
var dashboard_app = angular.module('dashboard_App', ['ngSanitize', 'commonMethods']).provider('moment', function () {
    this.$get = function () {
        return moment
    }
});
dashboard_app.controller("dashboard_Controller", function ($scope, $http, osCommonMethods) {
    $scope.osCommonMethods = osCommonMethods;
    $scope.to_dos = {};
    $scope.od_label = 0;
    $scope.td_label = 0;
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
    $scope.init = function (id) {
        $scope.projid = id;
        $scope.usage = "";
        $scope.loadDashboard();
    }
    $scope.projectBodyClick = function (key, event) {
        projectBodyClick(key, event);
    }
    $scope.switchtaskwithProject = function ($event) {
        var hrf = $($event.currentTarget).attr('data-hrf');
        $http.post(HTTP_ROOT + "easycases/switchmyproj", $.param({
            'easycase_uid': $($event.currentTarget).attr('data-pid')
        }), {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }).success(function (data, status, headers, config) {
            $('#projFil').val(data);
            window.location.href = hrf;
        });
    }
    $scope.loadSeqDashboardAjax = function (sequency, projid, extra) {
        (sequency[sequency.length - 1] == 'recent_projects' && projid !== 'all') ? sequency.pop() : '';
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
        $scope.downloadFile = function () {
            var request_file = getCookie('REQUESTED_FILE');
            if ($.trim(request_file)) {
                createCookie("REQUESTED_FILE", '', -365, DOMAIN_COOKIE);
                window.location = HTTP_ROOT + 'easycases/download/' + request_file;
            }
        }
        if (sequency[sequency.length - 1] === 'recent_activities') {
            if (projid == 'all') {
                $('#cret_fst_milestone').text('Create Task Group');
                $('#invt_mor_user').text('Add New User');
                $('#cret_anthor_proj').text('Create Project');
            } else {
                $('#cret_fst_milestone').text('Create Task Group');
                $('#invt_mor_user').text('Add New User');
                $('#cret_anthor_proj').text('Create Project');
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
        $http.post(url + action, data, config).success(function (res, status, headers, config) {
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
    $scope.cmnDashboard = function (id, res, extra) {
        if ($scope.usage == '')
            $scope.usage = '';
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
                    $.each(res.task_prog, function (index, value) {
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
            if (!$('.task_action_bar').is(':visible')) {
                $('.activity-txt').show();
            }
            $scope.activity = res;
            if ($("#" + id + "_more").length > 0 && $("#" + id + "_more").attr("data-value") && ($("#" + id + "_more").attr("data-value") > 10)) {
                $("#more_" + id).show();
                $("#more_" + id + ' span#todos_cnt').html('(' + $("#" + id + "_more").attr("data-value") + ')').show();
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
                    if (extra == 'overview') {
                    } else {
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
    $scope.loadDashboard = function () {
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
        ($scope.projid == 'all') ? $('#list_2').show() : $('#list_2').hide();
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
    $scope.checkLastDate = function (i) {
        if (i == 0) {
            $scope.lastdate = '';
        } else {
            $scope.lastdate = $scope.activity.recent_activities[i - 1].Easycase.newActuldt;
        }
        return $scope.lastdate == $scope.activity.recent_activities[i].Easycase.newActuldt;
    }
    $scope.setDates = function (i, v) {
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
        $scope.totxt[i] = ' from ';
        $scope.percentage[i] = '';
        $scope.percentageUp[i] = '';
        if ($scope.thismnthhour[i] > $scope.prevmnthhour[i]) {
            $scope.uptxt[i] = ' Up';
            $scope.upcls[i] = 'up-div';
            $scope.percentage[i] = parseInt((($scope.thismnthhour[i] - $scope.prevmnthhour[i]) / $scope.prevmnthhour[i]) * 100);
            $scope.percentageUp[i] = $scope.percentage[i] - 100;
        } else if ($scope.thismnthhour[i] < $scope.prevmnthhour[i]) {
            $scope.uptxt[i] = ' Down ';
            $scope.upcls[i] = 'down-div';
            $scope.percentage[i] = parseInt((($scope.thismnthhour[i] - $scope.prevmnthhour[i]) / $scope.prevmnthhour[i]) * 100);
            $scope.percentageUp[i] = (100 - parseInt($scope.percentage[i])) + '% ';
        } else {
            $scope.uptxt[i] = ' Equals ';
            $scope.upcls[i] = ' up-div ';
            $scope.totxt[i] = ' to ';
        }
    }
    $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
        $('[rel=tooltip]').tipsy({
            gravity: 's',
            fade: true
        });
        cnt = 0;
        $.each($scope.admin_task.series, function (key, project) {
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
                    labels: false,
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
                    labels: false,
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
                        name: 'count',
                        marker: {
                            symbol: "square"
                        },
                        data: [{
                                y: typeof project.New != 'undefined' ? parseInt(project.New) : 0,
                                name: 'New',
                                marker: {
                                    symbol: "url(img/new-chart.png)"
                                }
                            }, {
                                y: typeof project.InProgress != 'undefined' ? parseInt(project.InProgress) : 0,
                                name: 'In Progress',
                                marker: {
                                    symbol: "url(img/inprogress-chart.png)"
                                }
                            }, {
                                y: typeof project.Closed != 'undefined' ? project.Closed : 0,
                                name: 'Closed',
                                marker: {
                                    symbol: "url(img/closed-chart.png)"
                                }
                            }, {
                                y: typeof project.Resolved != 'undefined' ? project.Resolved : 0,
                                name: 'Resolved',
                                marker: {
                                    symbol: "url(img/resolved-chart.png)"
                                }
                            }]
                    }]
            });
        });
    });
}).filter('moment', function (moment) {
    return function (input, options) {
        return moment(input).locale('eng').format(options.split('\'')[1])
    }
});

dashboard_app.directive('onFinishRender', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit('ngRepeatFinished');
                        if (!!attr.onFinishRender) {
                            $parse(attr.onFinishRender)(scope);
                        }
                    });
                }
            }
        }
    }
]);
/** End */


angular.module('commonMethods', []).factory('osCommonMethods', function () {
    var factory = {};
    factory.formatTitle = function (str) {
        return factory.escapeHtml(factory.html_entity_decode(str));
    }
    factory.escapeHtml = function (str) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return str.replace(/[&<>"']/g, function (m) {
            return map[m];
        });
    }
    factory.html_entity_decode = function (str) {
        return str.replace(/[<>'"]/g, function (m) {
            return '&' + {
                '\'': 'apos',
                '"': 'quot',
                '&': 'amp',
                '<': 'lt',
                '>': 'gt',
            }[m] + ';';
        });
    }
    factory.priArr = function (p) {
        var prior = new Array();
        prior = ['high', 'medium', 'low'];
        return prior[p];
    }
    factory.format_time_hr_min = function (totalsecs, mode) {
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
    factory.formatHour = function (data) {
        number = data / 3600;
        return Number(number).toFixed(2);
    }
    factory.strpad = function (width, string, padding) {
        return (width <= string.length) ? string : pad(width, padding + string, padding)
    }
    factory.formatText = function (str) {
        return formatText(nl2br(str))
    }
    factory.ucfirst = function (str) {
        return ucfirst(str)
    }
    factory.txs_typ = function (t1, t2, c) {
        txs_typ = t2;
        $.each(DEFAULT_TASK_TYPES, function (i, n) {
            if (i == t1) {
                txs_typ = n;
            }
        });
        return (c == 0) ? txs_typ.charAt(0) : txs_typ;
    }
    return factory;
});
(function () {
    var module = angular.module('anyOtherClick', []);
    var directiveName = "anyOtherClick";
    module.directive(directiveName, ['$document', "$parse", function ($document, $parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attr, controller) {
                    var anyOtherClickFunction = $parse(attr[directiveName]);
                    var documentClickHandler = function (event) {
                        var eventOutsideTarget = (element[0] !== event.target) && (0 === element.find(event.target).length);
                        if (eventOutsideTarget) {
                            scope.$apply(function () {
                                anyOtherClickFunction(scope, {});
                            });
                        }
                    };
                    $document.on("click", documentClickHandler);
                    scope.$on("$destroy", function () {
                        $document.off("click", documentClickHandler);
                    });
                },
            };
        }
    ]);
}
)();


/** All the scope object update functions  **/
function appendScopeObj(tmpres,data){
    result = [];
    result.push(data);
    i = 1;
    for (var key in tmpres) {
        if(typeof tmpres[key] === 'object'){
            result.push(tmpres[key]);
            i++;
        }else{
            result[key] = tmpres[key];
        }
    }
    angular.element(document.getElementById('caseViewSpan_angular')).scope().checkboxInitialize();
    angular.element(document.getElementById('caseViewSpan_angular')).scope().$apply();
    return result;
}
function updateScopeObj(tmpres,data,indx){
    result = [];
    //data.Easycase.title = tmpres[indx].Easycase.title;
    tmpres[indx]= data;
	result.push(tmpres[indx]);
    for (var key in tmpres) {
       if(key != indx){
			result.push(tmpres[key]);
		}
    }	
    angular.element(document.getElementById('caseViewSpan_angular')).scope().checkboxInitialize();
    angular.element(document.getElementById('caseViewSpan_angular')).scope().$apply();
    return result;
}
function removeScopeObj(tmpres,indx){
    result = [];
    for (var key in tmpres) {
        if (parseInt(key) != indx) {            
            result.push(tmpres[key]);
        }
    }
    angular.element(document.getElementById('caseViewSpan_angular')).scope().checkboxInitialize();
    angular.element(document.getElementById('caseViewSpan_angular')).scope().$apply();
     return result;
}
/** End **/