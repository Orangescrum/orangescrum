<?php $json_data = array();
$closed = 0;
 $legend = array(1 => __("New",true), 2 => __("In-Progress",true), 3 => __("Closed",true), 4 => __("Start",true), 5 => __("Resolved",true), 6 => __("Modified",true), 10 => __("Modified",true));
 $color = array(1 => "#F19A91", 2 => "#8DC2F8", 3 => "#8AD6A3", 4 => "#A78AB6", 5 => "#F3C788", 6 => "#FFF363",10=>"#c2c2c2");
 
if(is_array($status) && count($status)>0){
    if(isset($status[4])){
        $status[2]+=$status[4];
        unset($status[4]);
    }
    if(isset($status[6])){
        $status[2]+=$status[6];
        unset($status[6]);
    }
    /*if(isset($status[10])){
        $status[2]+=$status[10];        
    }*/
    unset($status[10]);
	$i =0;
	foreach($common_qry as $key=>$val){
		if($val[0]['legend'] == 3){
			$closed += $val[0]['tot_count'];
		}
		if($val['Easycase']['custom_status_id']){
			$json_data['data'][$i]['name'] = $csts_arr[$val['Easycase']['custom_status_id']]['name'];
			$json_data['data'][$i]['y'] = $val[0]['tot_count'];
			$json_data['data'][$i]['color'] = '#'.$csts_arr[$val['Easycase']['custom_status_id']]['color'];
		}else{
			$json_data['data'][$i]['name'] = $legend[$val[0]['legend']];
			$json_data['data'][$i]['y'] = $val[0]['tot_count'];
			$json_data['data'][$i]['color'] = $color[$val[0]['legend']];
		}
		$i++;
	}
	$json_data_out = '';
	if(!empty($json_data['data'])){
		foreach($json_data['data'] as $key=>$val){
        if($key == 3){
				//$closed = $val;
        }
			$json_data_out.= "{name:'".$val['name']."',y:".$val['y'].",color:'".$val['color']."'}, ";
		}
    }
    #echo $json_data;exit;
 }else{
	 if(isset($this->data['extra']) && $this->data['extra'] == 'overview'){
		echo "<figure style='margin: 30px auto;text-align: center;'><img src='" . HTTP_ROOT . "img/no-data/sample_image_1.png' alt='No Data' /></figure>";
	}else{
		echo "<center><img src='".HTTP_ROOT."/img/sample/dashboard/staus.png' alt='' style='max-width:100%;max-height:100%;'/></center>";
	}
     exit;
 }?>
<div id="project_status_pie<?php echo $fragment?>"></div>
<?php
 $showLabel = true;
 if($extra == 'overview'){
	 $showLabel = false;;
 }
?>
<script type="text/javascript">
    var show_legend = true;
    var data = [<?php echo trim($json_data_out);?>];
		
	$('.chat_status_result').find('h6').text(0);//set default value
	var total = 0;
	for(var i in data){
		//$('.status_'+data[i].name.toLowerCase()).text(data[i].y);
		total = total+parseInt(data[i].y);
	}
	$('.status_total').text(total);
	$('#ov_tsk_entry_cnt').text(total);	
	var hash = window.location.hash.substr(1);
	if (hash != 'overview') {
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
		var text = '<?php echo $closed;?> / <?php echo $total;?> <br> <?php echo __("Closed");?>';
	}
	$('#project_status_pie<?php echo $fragment?>').highcharts({
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
    /*$(document).ready(function() {
        var hash = window.location.hash.substr(1);
        if(hash != 'overview'){
            var height = 230;
            var x = 0;
            var y = -40;
            var align = 'none';
            var verticalAlign = 'top';
            var innerSize = '50%';
            var width = 400;
            var layout = 'horizontal';
            var text = '';
        }else{
            height = 175;
            x = -65;
            y = 0;
            align = 'right';
            verticalAlign = 'middle';
            innerSize = '95%';
            width = 120;
            layout = 'vertical';
            text = '<?php echo $closed;?> / <?php echo $total;?> <br> <?php echo __("Closed");?>';
        }
        var data = [<?php echo trim($json_data_out);?>];
		
		$('.chat_status_result').find('h6').text(0);//set default value
		var total = 0;
		for(var i in data){
			$('.status_'+data[i].name.toLowerCase()).text(data[i].y);
			total = total+parseInt(data[i].y);
		}
		$('.status_total').text(total);
		$('#ov_tsk_entry_cnt').text(total);
        $('#project_status_pie<?php echo $fragment?>').highcharts({
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
                //filename: task_status_pie
            },
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                height:  height
            },
            title: {
                align: "center",
                floating: true,
                margin: 0,
                style: {"color": "#333333", "fontSize": "18px"},
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
                    showInLegend: true,
                    dataLabels: {
                        enabled: false,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            legend: {
                enabled: '<?php echo $showLabel; ?>',
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
    });*/
</script>