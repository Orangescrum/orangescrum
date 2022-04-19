<?php 
$json_data = '';
$closed = 0;
$legend = array( __("Active",true),  __("Completed",true));
$color = array( "#AC92E9",  "#C5C5C5");
$json_data= "{name:'".$legend[0]."',y:".$data[0]['count'].",color:'".$color[0]."',display:'".$data[0]['display']."'},{name:'".$legend[1]."',y:".$data[1]['count'].",color:'".$color[1]."',display:'".$data[1]['display']."'}, ";


?>
<div id="all_projects_pie" style="width:100%;"></div>
<script type="text/javascript">
    $(document).ready(function() {
        var data = [<?php echo trim($json_data);?>];
        $('#all_projects_pie').highcharts({
             chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false,
                height:160
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
            title: {
                text: _('Total')+': <?php echo trim($data[2]['display']);?>',
                align: 'center',
                verticalAlign: 'middle',
                y: 15
            },
            tooltip: {
                pointFormat: '{series.name} <b>{point.display}</b><br /> <b>{point.percentage:.1f}%</b>'
            },
			credits: {
				enabled: false
			},
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: 5,

                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['40%', '43%']
                }
            },
            series: [{
                type: 'pie',
                name: ' ',
                size: '100%',
                innerSize: '50%',
                data: data
            }]
        });
    });
</script>