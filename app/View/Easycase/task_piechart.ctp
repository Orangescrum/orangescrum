<div id="task_piechart" class="tlog-chrt-prnt"> <?php //echo "<pre>";print_r($status_report) ;     ?> </div>
<?php if (!empty($arrayList)) { ?>
    <div class="chat_status">
        <ul>
            <li><span class="newli" ></span>New (<?php echo $new; ?>)</li>
            <li><span class="progressli" ></span>In progress (<?php echo $inprogress; ?>)</li>
            <li><span class="completeli" ></span>Completed (<?php echo $close_Resolve; ?>)</li>
        </ul>
    </div>
<?php } ?>
<script>
    $(function () {
        var res = <?php echo $respone; ?>;
        if (res.task_prog != null) {
            Highcharts.setOptions({
                lang: {
                    contextButtonTitle: 'Download'
                }
            });
            $("#task_piechart").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            align: 'right',
                            symbolStrokeWidth: 2,
                            symbolStroke: '#969696',
                            menuItems: [{
                                    text: 'PNG',
                                    onclick: function () {
                                        this.exportChart();
                                    },
                                    separator: false
                                }, {
                                    text: 'JPEG',
                                    onclick: function () {
                                        this.exportChart({
                                            type: 'image/jpeg'
                                        });
                                    },
                                    separator: false
                                }, {
                                    text: 'PDF',
                                    onclick: function () {
                                        this.exportChart({
                                            type: 'application/pdf'
                                        });
                                    },
                                    separator: false
                                }, {
                                    text: 'Print',
                                    onclick: function () {
                                        this.print();
                                    },
                                    separator: false
                                }]
                        }
                    },
                    filename: task_piechart
                },
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                    height: 250
                },
                title: {
                    text: ''
                },
                tooltip: {
                    formatter: function () {
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
                        showInLegend: true,
                        dataLabels: {
                            enabled: typeof extra != 'undefined' ? (extra == 'overview' ? false : false) : false,
                            color: '#000000',
                            connectorColor: '#000000',
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'

                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -30,
                    y: 50,
                    borderWidth: 0,
                    labelFormatter: function () {
                        return this.name + ' - ' + this.y + '';
                    }
                },
                series: [{
                        type: 'pie',
                        name: ' ',
                        data: res.task_prog,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
            });
        } else {
            $('#task_piechart').html('<img src="<?php echo HTTPS_HOME;?>img/sample/dashboard/task.png" style="width:98%;margin-top:-11px;">');
        }

    });
</script>