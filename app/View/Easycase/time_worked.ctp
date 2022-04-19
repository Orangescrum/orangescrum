<?php 
$json_data = '';
$closed = 0;
$legend = array( __("Billable",true),  __("Non-billable",true));
$color = array( "#4275B6",  "#F18000");

$json_data= "{name:'".$legend[0].'<br>'.$data[0]['display']."',y:".$data[0]['time'].",color:'".$color[0]."'},{name:'".$legend[1].'<br>'.$data[1]['display']."',y:".$data[1]['time'].",color:'".$color[1]."'}";

$nb_t = ($data[1]['display'])?$data[1]['display']:0;
$b_t = ($data[0]['display'])?$data[0]['display']:0;
$tot_t = ($data[2]['display'])?$data[2]['display']:0;
?>
<div id="time_worked_pie"></div>
<script type="text/javascript">
    $(document).ready(function() {
        var data = [<?php echo trim($json_data);?>];
		$('#ov_tim_entry_cnt').html('<?php echo $this->Format->format_time_hr_min($data[2]['time']*3600); ?>');
		
		var data = [<?php echo trim($json_data);?>];
		$('.chat_billable_result').find('h6').text(0);//set default value
		$('.ov_time_nb').text("<?php echo $nb_t; ?>");
		$('.ov_time_b').text("<?php echo $b_t; ?>");
		$('.ov_time_total').text("<?php echo $tot_t; ?>");
		
        $('#time_worked_pie').highcharts({
			credits: {
                enabled: false
            },
             chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false,
                height:220
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
                    filename: task_status_pie
                },
            title: {
                text: 'Total: <?php echo trim($data[2]['display']);?>',
                align: 'center',
                verticalAlign: 'middle',
                y: 15
            },
            tooltip: {
                pointFormat: '{series.name} <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: 0,

                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '43%']
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