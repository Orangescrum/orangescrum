<input type="hidden" value="<?php echo !empty($startDate)?$startDate:"";?>" id="overStartDate" />
<input type="hidden" value="<?php echo !empty($endDate)?$endDate:"";?>" id="overEndDate" />
    <input type="hidden" value="<?php echo !empty($fstartDate)?$fstartDate:"";?>" id="foverStartDate" />
    <input type="hidden" value="<?php echo !empty($fendDate)?$fendDate:"";?>" id="foverEndDate" />
<div id="linechart" style="width:99%">
</div>
<script type="text/javascript">
    $(function () {
        var dt = <?php echo $dt_arr;?>;
        var tikinterval = <?php echo $tinterval;?>;
        var namedata = <?php echo $carr; ?>;
        $('#linechart').highcharts({
            chart: {
                type: '<?php echo $mode=='overview'?'column':'line';?>',
                height: '<?php echo $mode=='overview'?300:400;?>'
            },
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
                filename: ''
            },
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                type: 'datetime',
                categories: eval(dt),
                showFirstLabel: true,
                showLastLabel: true,
                tickInterval: tikinterval,
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Hour(s)'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },
            tooltip: {
                valueSuffix: 'hour',
                formatter: function () {
                    var total_min = this.y * 60 * 60;
                    var hr = isNaN(total_min) || parseInt(total_min) == '0' ? 0 + ' hour' : format_time_hr_min(total_min);
                        <?php if($mode=='overview'){?>
                    return  this.x + '<br>' + hr;
                        <?php }else{?>
                    return  this.x + '<br><b>' + this.series.name + ':</b> ' + hr;
                        <?php }?>
                    //return  Highcharts.dateFormat('%e. %b', this.x)+'<br><b>'+ this.series.name +':</b> '+ this.y +' hour';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    pointWidth: 20
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: eval(namedata)
        });
    });
</script>
