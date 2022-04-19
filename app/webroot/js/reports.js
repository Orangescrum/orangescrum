var avg_age_reports = {
    init: function(){
        $('#filter_qty').change(function(){
            if($(this).val() < 1 || isNaN($(this).val())){
                $(this).val(7);
            }
        });
        avg_age_reports.project_menu();
        $('#btn_filter').click(function(){
            var filter_qty = $('#filter_qty').val();
            if(!filter_qty){
                showTopErrSucc('error', _("Please enter previously day(s)."));
                $('#filter_qty').val('');
                return false;
            }
             if(Number.isInteger(+filter_qty) && parseInt(filter_qty) > 0){
            $("#btn_filter").addClass('loginactive');
            avg_age_reports.load();
            }else{
                showTopErrSucc('error', _("Oops! Invalid day(s)."));
                $('#filter_qty').val('');
                return false;
            }
            
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    avg_age_reports.load();
                    //setTimeout(function(){avg_age_reports.load();},1000);
                }
            }
        });
    },
    load: function(){
        Highcharts.SVGRenderer.prototype.symbols.download = function (x, y, w, h) {
          var path = [
              // Arrow stem
              'M', x + w * 0.5, y,
              'L', x + w * 0.5, y + h * 0.7,
              // Arrow head
              'M', x + w * 0.3, y + h * 0.5,
              'L', x + w * 0.5, y + h * 0.7,
              'L', x + w * 0.7, y + h * 0.5,
              // Box
              'M', x, y + h * 0.9,
              'L', x, y + h,
              'L', x + w, y + h,
              'L', x + w, y + h * 0.9
          ];
          return path;
      };
        
        
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/average_age_report",
            data: {
                "page": 'average_age_report',
                "pid": $('#company_projects').val(),
                "mode": $('#filter_mode').val(),
                "qty": $('#filter_qty').val(),
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter").removeClass('loginactive');
                if (response) {
                    var x_data = [];
                    var y_data = [];
                    $('#ajax_content').html('');
                   if(response){ 
                   $.each(response,function(key,val){
                       $('#ajax_content').append('<tr><td>'+val.label+'</td><td>'+val.unresolved_count+'</td><td>'+val.age+'</td><td>'+val.avg+'</td></tr>');
                       x_data.push(val.label);
                       y_data.push(val.unresolved_count);
                   });
                   avg_age_reports.graph(x_data, y_data);
                   }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container').html("");
               }
                }
            }
        });
    }, 
    graph: function(x_data, y_data){
        //Highcharts.chart('chart_container', {
        var date_interval = 1;
        if(x_data.length >15){
            date_interval = Math.ceil(x_data.length/15);
        }
        //alert(date_interval);return false;
        $('#chart_container').highcharts({
            credits:{enabled:false},
            chart: {
                type: 'column'
            },
            title: {text: false},
            subtitle: {text: false},
            legend: false,
            exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol: 'download',
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
                        }]
                    }
                },
            },
            xAxis: {
                type: 'datetime',
                categories: eval(x_data),
                showFirstLabel: true,
                showLastLabel: true,
                crosshair: true,
                tickInterval: date_interval,
                },
            yAxis: {
                min: 0,
                title: {
                    text: 'Days'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>'+'<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Tasks',
                    data: y_data
                }]
        });
    }
};

var reports = {
    init: function(){
        reports.project_menu();
        $('#btn_filter_cvr').click(function(){
            var filter_qty = $('#filter_qty').val();
            if(!filter_qty){
                showTopErrSucc('error', _("Please enter previously day(s)."));
                $('#filter_qty').val('');
                return false;
            }
             if(Number.isInteger(+filter_qty) && parseInt(filter_qty) > 0){
            $("#btn_filter_cvr").addClass('loginactive');
            reports.loadcvr();
            }else{
                showTopErrSucc('error', _("Oops! Invalid day(s)."));
                $('#filter_qty').val('');
                return false;
            }
            
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    reports.loadcvr();                    
                }
            }
        });
    },
    loadcvr: function(){
        $('.report_loader').css('display','inline-block');
        var mode = $('#filter_mode').val();
        $.ajax({
            url:HTTP_ROOT + "project_reports/create_resolve_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode,
                "qty": $('#filter_qty').val(),
                "cumulative":$("#cumulative_total").val(),
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter_cvr").removeClass('loginactive');
                $('#ajax_content').html('');                   
                if (response) {
                   if(response['result'].length > 0){
                   $.each(response['result'],function(key,val){
                       var resolved = (val[0].resolve)?val[0].resolve:0;
                       if(mode == 'weekly'){
                          $('#ajax_content').prepend('<tr><td>'+val[0].wk +' Week, '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+resolved+'</td></tr>'); 
                       }else if(mode == 'monthly'){
                           $('#ajax_content').prepend('<tr><td>'+moment(val[0].mt).format('MMMM') +' '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+resolved+'</td></tr>');
                       }else if(mode == 'quarterly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].qt +' Quater, '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+resolved+'</td></tr>');
                       }else if(mode == 'yearly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+resolved+'</td></tr>');
                       }else{
                            $('#ajax_content').prepend('<tr><td>'+moment(val[0].dt).format('DD MMM, YYYY') +'</td><td>'+val[0].created+'</td><td>'+resolved+'</td></tr>');
                        }
                   });
                   reports.graphcvr(response['chart']);
                   }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container_cvr').html("");
               }
                }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container_cvr').html("");
                }
            }
        });
    },
    graphcvr : function(res){
        var created = [];
        var resolved = [];
        var xaxis = [];
        $.each(res.rdate.created, function(i, obj) {
            if(obj){
               created.push(parseInt(obj));
           }else{
                created.push(0);
           }
       });
        $.each(res.xaxis, function(i, obj) {
            if(obj){
               xaxis.push(obj);
							 }else{
                xaxis.push(null);
           }
       });
        $.each(res.rdate.resolved, function(i, obj) {
            if(obj){
               resolved.push(parseInt(obj));
           }else{
                resolved.push(0);
           }
       });
       $('#chart_container_cvr').highcharts({
           credits:{enabled:false},
            colors: ['#6ba8de','#fab858'],
            chart: {
                type: 'area'
            },
            title: {
                text: 'Created vs Resolved Tasks Report'
            },
            subtitle: {
                text: ''
            },
			exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol : 'download',
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
                        }]
                    }
                },
            },
            xAxis: {
                 type: 'datetime',
                categories: eval(xaxis),
                showFirstLabel: true,
                showLastLabel: true,
                tickInterval: res.interval,
            },
            yAxis: {
                title: {
                    text: 'Task Count'
                },
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            plotOptions: {
                area: {
                    stacking: null
                    }
            },
            series: [{
                name: 'Created',
                data: created 
            },{
                name: 'Resolved',
                data: resolved 
            }]

         });
    }
};
/*
 * Pie chart Reports
 */
var pieReports = {
    init: function(){
        pieReports.project_menu();
        $('#btn_filter').click(function(){
            $("#btn_filter").addClass('loginactive');
            pieReports.load();
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    pieReports.load();
                }
            }
        });
    },
    load: function(){
        var mode = $('#filter_mode').val();
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/pie_chart_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter").removeClass('loginactive');
                    $('#ajax_content').html('');
                if (response.total_count) {
                if(response.result){
                   $.each(response.result,function(key,val){
                       $('#ajax_content').append('<tr><td>'+val.label+'</td><td>'+val.created+'</td><td>'+ Math.round((parseInt(val.created)/response.total_count)*100)+ "%"  +'</td></tr>');
                  });
                  pieReports.graph(response.chart,mode,response.total_count);
                  }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container').html("");
               }
                }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container').html("");
                }
            }
        });
    },
    graph: function(chart,mode,tot){
        var chartArr = [];
     $.each(chart, function(i, obj) {
         if(obj){
             if(typeof obj.color != 'undefined'){
                 chartArr.push({name:obj.name,y:Math.round((parseInt(obj.y)/tot)*100),color:obj.color});
             }else{
                chartArr.push({name:obj.name,y:Math.round((parseInt(obj.y)/tot)*100)});
            }
        }
    });
         $('#chart_container').highcharts({
             credits:{enabled:false},
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Pie Chart Reports'
            },
			exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol : 'download',
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
                        }]
                    }
                },
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} %', //point.percentage:.1f
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Tasks',
                colorByPoint: true,
                data: chartArr 
            }]
        });
    }
    
}
/*
 * Recent Created Task Reports
 */
var created_reports = {
    init: function(){
        created_reports.project_menu();
        $('#btn_filter_cvr').click(function(){
            var filter_qty = $('#filter_qty').val();
            if(!filter_qty){
                showTopErrSucc('error', _("Please enter previously day(s)."));
                $('#filter_qty').val('');
                return false;
            }
             if(Number.isInteger(+filter_qty) && parseInt(filter_qty) > 0){
            $("#btn_filter_cvr").addClass('loginactive');
            created_reports.loadcvr();
            }else{
                showTopErrSucc('error', _("Oops! Invalid day(s)."));
                $('#filter_qty').val('');
                return false;
            }
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    created_reports.loadcvr();                    
                }
            }
        });
    },
    loadcvr: function(){
        var mode = $('#filter_mode').val();
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/recent_created_task_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode,
                "qty": $('#filter_qty').val(),
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $("#btn_filter_cvr").removeClass('loginactive');
                $('.report_loader').css('display','none');
                $('#ajax_content').html('');
                if (response) {
                  if(response['result'].length > 0){ 
                   $.each(response['result'],function(key,val){
                       if(mode == 'weekly'){
                          $('#ajax_content').prepend('<tr><td>'+val[0].wk +' Week, '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+val[0].resolve+'</td></tr>'); 
                       }else if(mode == 'monthly'){
                           $('#ajax_content').prepend('<tr><td>'+moment(val[0].mt).format('MMMM') +' '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+val[0].resolve+'</td></tr>');
                       }else if(mode == 'quarterly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].qt +' Quater, '+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+val[0].resolve+'</td></tr>');
                       }else if(mode == 'yearly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].yr+'</td><td>'+val[0].created+'</td><td>'+val[0].resolve+'</td></tr>');
                       }else{
                            $('#ajax_content').prepend('<tr><td>'+moment(val[0].dt).format('DD MMM, YYYY') +'</td><td>'+val[0].created+'</td><td>'+val[0].resolve+'</td></tr>');
                        }                        
                   });
                   created_reports.graphcvr(response['chart']);
                   }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container_cvr').html("");
               }
                }else{
                     $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                     $('#chart_container_cvr').html("");
                }
            }
        });
    },
    graphcvr : function(res){
     var created = [];
     var resolved = [];
     var xaxis = [];
     $.each(res.rdate.created, function(i, obj) {
         if(obj){
            created.push(parseInt(obj));
        }else{
             created.push(null);
        }
    });
     $.each(res.rdate.resolved, function(i, obj) {
         if(obj){
            resolved.push(parseInt(obj));
        }else{
             resolved.push(null);
        }
    });
     $.each(res.xaxis, function(i, obj) {
         if(obj){
            xaxis.push(obj);
        }else{
             xaxis.push(null);
        }
    });
    $('#chart_container_cvr').highcharts({
        credits:{enabled:false},
    colors: ['#6ba8de','#fab858'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'Recent Created Tasks'
    },
	exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol : 'download',
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
                        }]
                    }
                },
            },
    xAxis: {
       type: 'datetime',
        categories: eval(xaxis),
        showFirstLabel: true,
        showLastLabel: true,
        tickInterval: res.interval,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Tasks'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: false,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Unresolved',
        data: created
    }, {
        name: 'Resolved',
        data: resolved
    }]
});      
    }
};

/*
 * Resolution Time Reports
 */
var resolutionReports = {
    init: function(){
        resolutionReports.project_menu();
        $('#btn_filter_cvr').click(function(){
            var filter_qty = $('#filter_qty').val();
            if(!filter_qty){
                showTopErrSucc('error', _("Please enter previously day(s)."));
                $('#filter_qty').val('');
                return false;
            }
            if(Number.isInteger(+filter_qty) && parseInt(filter_qty) > 0){
            $("#btn_filter_cvr").addClass('loginactive');
            resolutionReports.loadcvr();
            }else{
                showTopErrSucc('error', _("Oops! Invalid day(s)."));
                $('#filter_qty').val('');
                return false;
            }
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    resolutionReports.loadcvr();                    
                }
            }
        });
    },
    loadcvr: function(){
        var mode = $('#filter_mode').val();
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/resolution_time_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode,
                "qty": $('#filter_qty').val(),
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter_cvr").removeClass('loginactive');
                $('#ajax_content').html('');
                if (response) {
                   if(response['result'].length > 0){
                   $.each(response['result'],function(key,val){
                       if(mode == 'weekly'){
                          $('#ajax_content').prepend('<tr><td>'+val[0].wk +' Week, '+val[0].yr+'</td><td>'+val[0].resolve+'</td><td>'+val[0].durations+'</td><td>'+val[0].average+'</td></tr>'); 
                       }else if(mode == 'monthly'){
                           $('#ajax_content').prepend('<tr><td>'+moment(val[0].mt).format('MMMM') +' '+val[0].yr+'</td><td>'+val[0].resolve+'</td><td>'+val[0].durations+'</td><td>'+val[0].average+'</td></tr>');
                       }else if(mode == 'quarterly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].qt +' Quater, '+val[0].yr+'</td><td>'+val[0].resolve+'</td><td>'+val[0].durations+'</td><td>'+val[0].average+'</td></tr>');
                       }else if(mode == 'yearly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].yr+'</td><td>'+val[0].resolve+'</td><td>'+val[0].durations+'</td><td>'+val[0].average+'</td></tr>');
                       }else{
                            $('#ajax_content').prepend('<tr><td>'+moment(val[0].dt).format('DD MMM, YYYY') +'</td><td>'+val[0].resolve+'</td><td>'+val[0].durations+'</td><td>'+val[0].average+'</td></tr>');
                        }                        
                   });
                   resolutionReports.graphcvr(response['chart']);
               }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container_cvr').html("");
               }
                }else{
                    $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                    $('#chart_container_cvr').html("");
                }
            }
        });
    },
    graphcvr : function(res){   
     var rdate = [];
     var xaxis = [];
     $.each(res.rdate, function(i, obj) {
         if(obj){
            rdate.push(parseInt(obj));
        }else{
             rdate.push(null);
        }
    });
     $.each(res.xaxis, function(i, obj) {
         if(obj){
            xaxis.push(obj);
        }else{
             xaxis.push(null);
        }
    });
    $('#chart_container_cvr').highcharts({
        credits:{enabled:false},
    colors: ['#6ba8de'],
    chart: {
        type: 'column'
    },
    title: {
        text: 'Resolution Time Report'
    },
	exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol : 'download',
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
                        }]
                    }
                },
            },
    xAxis: {
        type: 'datetime',
        categories: eval(xaxis),
        showFirstLabel: true,
        showLastLabel: true,
        tickInterval: res.interval,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total days'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: false,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Resolution Days',
        data: rdate
    }]
});      
    }
};
/*
 * Time Since Task Reports
 */
var timeSinceReports = {
    init: function(){
        timeSinceReports.project_menu();
        $('#btn_filter_cvr').click(function(){
            var filter_qty = $('#filter_qty').val();
            if(!filter_qty){
                showTopErrSucc('error', _("Please enter previously day(s)."));
                $('#filter_qty').val('');
                return false;
            }
            if(Number.isInteger(+filter_qty) && parseInt(filter_qty) > 0){
            $("#btn_filter_cvr").addClass('loginactive');
            timeSinceReports.loadcvr();
            }else{
                showTopErrSucc('error', _("Oops! Invalid day(s)."));
                $('#filter_qty').val('');
                return false;
            }
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $.each(response.projects, function(key,val){
                        $('#company_projects').append($('<option>').attr('value',val.p.uniq_id).html(val.p.name));
                    });
                    $('.select2').select2();
                    timeSinceReports.loadcvr();                    
                }
            }
        });
    },
    loadcvr: function(){
        var mode = $('#filter_mode').val();
        var date_fields =  $('#date_fields').val();
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/time_since_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode,
                "qty": $('#filter_qty').val(),
                "date_fields": date_fields,
                "cumulative": $("#cumulative_total").val(),
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter_cvr").removeClass('loginactive');
                   $('#ajax_content').html('');
				   var mod = $("#date_fields").val();
                    if(mod =='due_date'){
                        var mode_text = "Due Date Tasks";
                    }else if(mod =='resolved'){
                         var mode_text = "Resolved Tasks";
                    }else if(mod =='updated'){
                         var mode_text = "Updated Tasks";
                    }else{
                         var mode_text = "Created Tasks";
                    }
                    $(".field_label").html(mode_text);
                if (response) {
                   if(response['result'].length > 0){
                   $.each(response['result'],function(key,val){
                       if(mode == 'weekly'){
                          $('#ajax_content').prepend('<tr><td>'+val[0].wk +' Week, '+val[0].yr+'</td><td>'+val[0].result_data+'</td></tr>'); 
                       }else if(mode == 'monthly'){
                           $('#ajax_content').prepend('<tr><td>'+moment(val[0].mt).format('MMMM') +' '+val[0].yr+'</td><td>'+val[0].result_data+'</td></tr>');
                       }else if(mode == 'quarterly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].qt +' Quater, '+val[0].yr+'</td><td>'+val[0].result_data+'</td></tr>');
                       }else if(mode == 'yearly'){
                           $('#ajax_content').prepend('<tr><td>'+val[0].yr+'</td><td>'+val[0].result_data+'</td></tr>');
                       }else{
                            $('#ajax_content').prepend('<tr><td>'+moment(val[0].dt).format('DD MMM, YYYY') +'</td><td>'+val[0].result_data+'</td></tr>');
                        }                        
                   });
                    
                   timeSinceReports.graphcvr(response['chart'],mode_text);
                   
               }else{
                  $('#ajax_content').append('<tr><td colspan="2" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                  $('#chart_container_cvr').html("");
               }
                }else{
                  $('#ajax_content').append('<tr><td colspan="2" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                  $('#chart_container_cvr').html("");
                }
            }
        });
    },
    graphcvr : function(res,mode_text){   
     var rdate = [];
     var xaxis = [];
     $.each(res.rdate, function(i, obj) {
         if(obj){
            rdate.push(parseInt(obj));
        }else{
             rdate.push(null);
        }
    });
     $.each(res.xaxis, function(i, obj) {
         if(obj){
            xaxis.push(obj);
        }else{
             xaxis.push(null);
        }
    });
    $('#chart_container_cvr').highcharts({
        credits:{enabled:false},
    colors: ['#6ba8de'],
    chart: {
        type: 'column'
    },
     exporting: {
            enabled: false
        },
    title: {
        text: 'Time Since Task Report'
    },
	exporting: {
                enabled: true,
                buttons: {
                    contextButton: {
                        symbol : 'download',
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
                        }]
                    }
                },
            },
    xAxis: {
        type: 'datetime',
        categories: eval(xaxis),
        showFirstLabel: true,
        showLastLabel: true,
        tickInterval: res.interval,
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total days'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal'
            }
    },
    series: [{
        name: mode_text,
        data: rdate
    }]
});      
    }
};
/**
* Sprint Reports
**/

var sprint_reports = {
    init: function(){
        $("#n_tsk_grp").hide();        
        sprint_reports.project_menu();
        $('#btn_filter_cvr').click(function(){
            var filter_qty = $('#filter_qty').val();
            $("#btn_filter_cvr").addClass('loginactive');
            sprint_reports.loadsprint();
        });
    },
    project_menu: function(){
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
                "methodology":"sprint"
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {                
                if (response) {
                    $('#company_projects').html('');
                    $('#filter_mode').html(''); 
                    var projectsarr = response.projects;
                    if(projectsarr.length) {              
                    $.each(response.projects, function(key,val){
                       if(SELECTED_PROJECT_RPT == val.p.id){
                         $('#company_projects').append($('<option>').attr('value',val.p.id).attr('selected','selected').html(val.p.name));   
                       }else{
                        $('#company_projects').append($('<option>').attr('value',val.p.id).html(val.p.name));   
                       }                   
                    });
                    }else{
                       $("#ajax_content").html('<div style="color:#ef7474; font-size:13px;">'+_('There are no matching projects to report on')+'.</div>'); 
                    }
                   $('#company_projects').select2(); 
                   sprint_reports.getAllSprints( $('#company_projects').val()); 

                }
            }
        });
    },
    getAllSprints: function(pid){
         $('#filter_mode').html("");
         $.post(HTTP_ROOT + "project_reports/get_all_sprints",{pid:pid},function(res){
            if(res.status){
                 $.each(res.records, function(key1,val1){
                  if(SELECTED_SPRINT_RPT == val1.Milestone.id){
                    $('#filter_mode').append($('<option>').attr('value',val1.Milestone.id).attr('selected','selected').attr('data-closed',val1.Milestone.isactive).html(val1.Milestone.title)); 
                   }else{
                    $('#filter_mode').append($('<option>').attr('value',val1.Milestone.id).attr('data-closed',val1.Milestone.isactive).html(val1.Milestone.title)); 
                   } 
                 });
                 $('#filter_mode').select2();
                 sprint_reports.loadsprint(); 
            }
        },'json');

    },
    loadsprint: function(){
        $(".task-list-bar").show();
        $("#n_tsk_grp").hide();
        var isClosed = ($('#filter_mode option').length) ? $('#filter_mode').select2('data')[0].element.attributes['data-closed'].value:0;
        $('.report_loader').css('display','inline-block');
        var mode = ($('#filter_mode option').length)?$('#filter_mode').val():'';       
        $.ajax({
            url:HTTP_ROOT + "project_reports/create_sprint_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode
            },
            method: 'post',
            dataType: 'json',
            success: function(response) { 
                if(isClosed !=1){               
                    $("#n_tsk_grp").show();
                }else{
                    $("#n_tsk_grp").hide();
                }
                $('.report_loader').css('display','none');
                $("#btn_filter_cvr").removeClass('loginactive');
                $('#ajax_content').html('');                   
                if (response.status) {
                    $("#sprint_info_text").html(response.sprint_info);
                    if(response.any_completed){
                       $("#reopen_link_csp").addClass("disabled"); 
                    }else{
                        $("#reopen_link_csp").removeClass("disabled");  
                    }
                    result = response.result;
                    result1 = response.result1;
                    result2 = response.result2;
                   if(Object.keys(result.caseAll).length > 0  || Object.keys(result1.caseAll).length > 0 || Object.keys(result2.caseAll).length > 0){
                        if(Object.keys(result1.caseAll).length > 0){
                            $('#ajax_content').append(tmpl("task_by_backlo_tmpl",result1));
                        }
                        if(Object.keys(result.caseAll).length > 0){
                            $('#ajax_content').append(tmpl("task_by_backlo_tmpl",result));
                        }
                        if(Object.keys(result2.caseAll).length > 0){
                            $('#ajax_content').append(tmpl("task_by_backlo_tmpl",result2));
                        }
                        $("#total_not_completed_tasks").val(response.not_completed_count);
                   }else{
                        if(!mode){
                            $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474; font-size:13px;">'+_('There are no active sprint available')+'.</tr></td>'); 
                            $('#sprint_info_text').html("");
                            $("#n_tsk_grp").hide();
                        }else{
                            $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474; font-size:13px;">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                        }
                        $('#chart_container_cvr').html("");                        
               }
                }else{
                    if(!mode){
                        $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474; font-size:13px;">'+_('There are no active sprint available')+'.</tr></td>'); 
                        $('#sprint_info_text').html("");
                        $("#n_tsk_grp").hide();
                    }else{
                         $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474; font-size:13px;">'+_('There are no matching tasks to report on')+'.</tr></td>');    
                    }
                    $('#chart_container_cvr').html("");
                    
                }
            }
        });
    },

    deleteCompletedSprint : function(){  
        var id = $("#filter_mode").val();
        var name = $("#filter_mode option:selected").text();
        if(typeof id == 'indefined'){
          showTopErrSucc('error', _("Please select sprint."));  
          return false;
        }
        if(confirm(_('Are you sure you want to delete sprint')+' '+ name + '?'+' '+_('All the task under this sprint will move to the Backlog.'))){
            $("#caseLoaderProject").show();
            $("#n_tsk_grp").removeClass('open');
            $.post(HTTP_ROOT + "project_reports/remove_sprint",{id:id},function(res){
                $("#caseLoaderProject").hide();
                if(res.err){
                    showTopErrSucc('error',res.msg);  
                }else{
                     showTopErrSucc('success',res.msg);  
                }
                sprint_reports.project_menu();
            },'json');
        }
    },
    reopenCompletedSprint: function(obj){
       var id = $("#filter_mode").val();
        var name = $("#filter_mode option:selected").text();
        if(typeof id == 'indefined'){
          showTopErrSucc('error', _("Please select sprint."));  
          return false;
        }

         if($(obj).hasClass('disabled')){
            showTopErrSucc('error',_("This sprint cant be reopened at the moment! Complete your currently active sprint."));  
            return false;
        }
        var nm = $("#total_not_completed_tasks").val();  
        var status =true;
        if(nm !=0 ){    
            status = confirm(nm +" "+ _("task will be moved back to the sprint you're reopening."));
        }
        if(status){
            $("#caseLoaderProject").show();
            $("#n_tsk_grp").removeClass('open');
             $.post(HTTP_ROOT + "project_reports/reopen_sprint",{id:id,pid:$('#company_projects').val()},function(res){
                    $("#caseLoaderProject").hide();
                    if(res.err){
                        showTopErrSucc('error',res.msg);  
                    }else{
                        localStorage.removeItem("sprint_by_id");
                        self.location=HTTP_ROOT+"dashboard#activesprint";
                         //showTopErrSucc('success',res.msg);  
                    }
                    //sprint_reports.project_menu();
                },'json');
         }

    }
};

/**
* Velocity Reports
**/
var velocity_reports = {
     init: function(){
        $("#n_tsk_grp").hide();        
        velocity_reports.project_menu();
        $('#btn_filter_cvr').click(function(){
             $("#btn_filter_cvr").addClass('loginactive');
             velocity_reports.loadVelocity();
        });
    },
    project_menu: function(){          
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
                "methodology":"sprint"
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {                
                if (response) {
                    $('#company_projects').html('');
                    var projectsarr = response.projects;
                    if(projectsarr.length) {              
                        $.each(response.projects, function(key,val){
                            $('#company_projects').append($('<option>').attr('value',val.p.id).html(val.p.name));  
                        });
                      $('#company_projects').select2();                   
                      velocity_reports.loadVelocity();
                    }else{
                       $("#ajax_content").html('<div style="color:#ef7474; font-size:13px;">'+_('There are no matching projects to report on')+'.</div>'); 
                    }                   
                }
            }
        });
    },
    loadVelocity: function(){
        Highcharts.SVGRenderer.prototype.symbols.download = function (x, y, w, h) {
            var path = [
                // Arrow stem
                'M', x + w * 0.5, y,
                'L', x + w * 0.5, y + h * 0.7,
                // Arrow head
                'M', x + w * 0.3, y + h * 0.5,
                'L', x + w * 0.5, y + h * 0.7,
                'L', x + w * 0.7, y + h * 0.5,
                // Box
                'M', x, y + h * 0.9,
                'L', x, y + h,
                'L', x + w, y + h,
                'L', x + w, y + h * 0.9
            ];
            return path;
        };
        $('.report_loader').css('display','inline-block');
         $("#n_tsk_grp").show();    
         $("#n_tsk_grp_inner").removeAttr('onclick'); 
         $("#n_tsk_grp_inner").attr('onclick',"openProjectSettings("+$('#company_projects').val()+")"); 
        $.ajax({
            url:HTTP_ROOT + "project_reports/velocity_reports",
            data: {
                "pid": $('#company_projects').val() 
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter_cvr").removeClass('loginactive');
                   $('#ajax_content').html('');
                if (response) {
                   if(Object.keys(response['result']).length > 0){
                   $.each(response['result'],function(key,val){
                      if(response['chart'].yaxis_text  == 'Original Time Estimate'){
                        $('#ajax_content').prepend('<tr><td><a href="'+HTTP_ROOT+'project_reports/completed_sprint_report/'+response['puid']+'/'+val.mid+'">'+key +'</a></td><td>'+format_time_min_num(val.commited).replace("mins","").replace("hrs","").replace("hr","")+'</td><td>'+format_time_min_num(val.completed).replace("mins","").replace("hrs","").replace("hr","")+'</td></tr>'); 
                      }else{
                       $('#ajax_content').prepend('<tr><td><a href="'+HTTP_ROOT+'project_reports/completed_sprint_report/'+response['puid']+'/'+val.mid+'">'+key +'</a></td><td>'+val.commited+'</td><td>'+val.completed+'</td></tr>'); 
                      }
                    });
                    
                   velocity_reports.graphcvr(response['chart']);
                   
               }else{
                  $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                  $('#chart_container_cvr').html("");
               }
                }else{
                  $('#ajax_content').append('<tr><td colspan="3" style="color:#ef7474">'+_('There are no matching tasks to report on')+'.</tr></td>'); 
                  $('#chart_container_cvr').html("");
                }
            }
        });

    },
    graphcvr: function(res){

          if(res.yaxis_text =='Original Time Estimate'){
            yaxis = { 
                        min: 0,
											 allowDecimals: false,
                       type: 'linear',
                       labels:{
                           formatter: function(){
                                var seconds = (this.value/ 1000) | 0;
                                this.value -= seconds * 1000;

                                var minutes = (seconds / 60) | 0;
                                seconds -= minutes * 60;

                                var hours = (minutes / 60) | 0;
                                minutes -= hours * 60;
                                return hours;
                            }
                       },
                       title: {
                            text: res.yaxis_text
                        },
                        gridLineColor:'transparent'
                };
          }else{
                yaxis = { 
                        min: 0,
												allowDecimals: false,
                        title: {
                            text: res.yaxis_text
                        },
                        gridLineColor:'transparent',
												//tickInterval: 1
                };

          }

        var xaxis = [];
        $.each(res.xaxis, function(i, obj) {
           xaxis.push(obj);           
       });
        $('#chart_container_cvr').highcharts({
            credits:{enabled:false},
            colors: ['#cccccc','#14892c'],
            chart: {
                type: 'column'
            },
             exporting: {
                    enabled: false
                },
            title: {
                text: _('Velocity Chart')
            },
            exporting: {
                        enabled: true,
                        buttons: {
                            contextButton: {
                                symbol: 'download',
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
                                }]
                            }
                        },
                    },
           xAxis: {
                categories: xaxis,
                crosshair: true,
                gridLineColor:'transparent'
            },

            yAxis: yaxis,
            legend: {
                align: 'right',
                verticalAlign: 'top',
                layout: 'vertical',
                x: -30,
                y: 0
            },            
             plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                    //  dataLabels: {
                    //     enabled: true,
                    //     formatter: function(){
                    //         if( res.yaxis_text =='Original Time Estimate') {
                    //             return velocity_reports.secondsTimeSpanToHMS(this.y/1000) ;
                    //         } else {
                    //             return this.y;
                    //         }
                    //     },
                    //     enableMouseTracking: false
                    // }
                }                
            },
             tooltip: {
                formatter: function () {
                    var s = '<b>' + this.x + '</b>';
                    if(res.yaxis_text =='Original Time Estimate'){
                        s += '<br/>' + this.series.name + ': ' + velocity_reports.secondsTimeSpanToHMS(this.point.y/1000);
                    }else{
                        s += '<br/>' + this.series.name + ': ' + this.point.y;
                    }
                    return s;
                }
                // headerFormat: '<b>{point.x}</b><br/>',
                // pointFormat: '{series.name}: {point.y}'
            },
            series: [{
                name: _('Commitment'),
                data: res.chart.Commited

            }, {
                name: _('Completed'),
                data: res.chart.Completed

            }]
        });  

    },
    secondsTimeSpanToHMS: function(s){
          var h = Math.floor(s / 3600); //Get whole hours
          s -= h * 3600;
          var m = Math.floor(s / 60); //Get remaining minutes
          s -= m * 60;
          return h + ":" + (m < 10 ? '0' + m : m); //zero padding on minutes and seconds
    }
};
/*
 * burndown  Reports
 */
var burndownReports = {
    init: function(){
        burndownReports.project_menu();
        $('#btn_filter').click(function(){
            $("#btn_filter").addClass('loginactive');
            burndownReports.loadsprint();
        });
    },
    project_menu: function(){ 
        $.ajax({
            url:HTTP_ROOT + "users/project_menu",
            data: {
                "page": 'PROJECT_REPORTS',
                "limit": 'all',
                "methodology":"sprint"
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#company_projects').html('');
                    $('#filter_mode').html(''); 
                    var projectsarr = response.projects;
                    if(projectsarr.length) {              
                    $.each(response.projects, function(key,val){
                       if(SELECTED_PROJECT_RPT == val.p.id){
                         $('#company_projects').append($('<option>').attr('value',val.p.id).attr('selected','selected').html(val.p.name));   
                       }else{
                        $('#company_projects').append($('<option>').attr('value',val.p.id).html(val.p.name));   
                       }                   
                    });
                    }else{
                       $("#ajax_content").html('<div style="color:#ef7474; font-size:13px;">'+_('There are no matching projects to report on')+'.</div>'); 
                    }
                   $('#company_projects').select2(); 
                   burndownReports.getAllSprints( $('#company_projects').val()); 

                }
            }
        });
    },
    getAllSprints: function(pid){
         $('#filter_mode').html("");
         $.post(HTTP_ROOT + "project_reports/get_all_sprints",{pid:pid,type:'notcreated'},function(res){
            if(res.status){
                if(Object.keys(res.records).length > 0){
                     $.each(res.records, function(key1,val1){
                      if(SELECTED_SPRINT_RPT == val1.Milestone.id){
                        $('#filter_mode').append($('<option>').attr('value',val1.Milestone.id).attr('selected','selected').attr('data-closed',val1.Milestone.isactive).html(val1.Milestone.title)); 
                       }else{
                        $('#filter_mode').append($('<option>').attr('value',val1.Milestone.id).attr('data-closed',val1.Milestone.isactive).html(val1.Milestone.title)); 
                       } 
                     });
                     $('#filter_mode').select2();
                     burndownReports.loadsprint(); 
                 }else{
                    $('#filter_mode').append($('<option>').attr('value','0').attr('data-closed','').html(_('Select Sprint'))); 
                    $('#filter_mode').select2();
                    burndownReports.loadsprint(); 
                 }
            }
        },'json');

    },
    loadsprint: function(){
        var mode = $('#filter_mode').val();
        $('.report_loader').css('display','inline-block');
        $.ajax({
            url:HTTP_ROOT + "project_reports/sprint_burndown_report",
            data: {
                "pid": $('#company_projects').val(),
                "mode": mode
            },
            method: 'post',
            dataType: 'json',
            success: function(response) {
                $('.report_loader').css('display','none');
                $("#btn_filter").removeClass('loginactive');
                $('#ajax_content').html('');
                if(response.status == 1){
                    $('#chart_container').show();
                    $('#chart_container_error').hide();
                    burndownReports.graph(response);
                }else{
                    $('#chart_container').hide();
                    $('#chart_container_error').show().html(response.image);
                }
                
            }
        });
    },
    graph: function(response){
        var dt = response.dt_arr;
        var hr = response.hr_arr;
        var est = response.hr_est;
       
        $('#chart_container').highcharts({
            title: {
                text: ''
            },
            scrollbar: {
                        barBackgroundColor: 'gray',
                        barBorderRadius: 7,
                        barBorderWidth: 0,
                        buttonBackgroundColor: 'gray',
                        buttonBorderWidth: 0,
                        buttonBorderRadius: 7,
                        trackBackgroundColor: 'none',
                        trackBorderWidth: 1,
                        trackBorderRadius: 8,
                        trackBorderColor: '#CCC'
                },
            colors: ['blue', 'red'],
            plotOptions: {
              line: {
                lineWidth: 1
              },
              tooltip: {
                hideDelay: 200
              }
            },
            subtitle: {
              text: '',
              x: -10
            },
            xAxis: {
                    title: {
                        text: 'Sprint Days'
                    },
                    type:'datetime',
                    //max: maxd,
                    min: 0,
                    showFirstLabel:true,
                    showLastLabel:true,
                    categories: eval(dt),
                },
                exporting:{
                    enabled: false  
                },
            yAxis: {
              title: {
                text: 'Story Point',
                min: 0,
              },
                     type: 'linear',
                     min:0
            },
            
            tooltip: {
              valueSuffix: '',
              crosshairs: true,
              shared: true
            },
            legend: {
             layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom',
              borderWidth: 0
            },
            series: [{
              name: _('Ideal task remaining'),
              color: 'rgba(255,0,0,0.25)',
              lineWidth: 2,      
              data: hr
            }, {
              name: _('Actual Task remaining'),
              color: 'rgba(0,120,200,0.75)',
              data: est
            }]
          });
    }
    
}