<table class="table table-striped tbl_cmn top_prj_chrt_tbl"><?php #print_r($series);exit; ?>
<?php $cnt = 0; foreach($projects as $key=>$value){ $cnt++;?>
    <tr>
        <td class="prj_nm">
            <div class="tfp-name">
							<a class="ellipsis-view" href="javascript:void(0);" rel="tooltip" title="<?php echo $value[0]; ?>" onclick="return projectBodyClick('<?php echo $key;?>', event);" style="display:block"><?php echo $value[0]; ?></a>
                            <?php if($value[2] != '' ){?>
                                <small class="prj-desc ellipsis-view mx-width-100"><?php echo $value[2]; ?></small>
                            <?php } ?>
                                <small class="prj-desc ellipsis-view mx-width-100" rel="tooltip" title="<?php echo __('Updated on');?> <?php echo Date('M d, Y', strtotime($value[1])); ?>">Updated on <?php echo Date('M d, Y', strtotime($value[1])); ?></small>
						</div>
        </td>
        <?php /* <td class="prj_dt"><?php echo Date('M d, Y', strtotime($value[1])); ?></td> */ ?>
        <td class="tfp-chart">
           <div id="<?php echo $cnt; ?>_prj"></div> 
        </td>
    </tr>
<?php } ?>
    <?php /* <tr>
        <td colspan="3" class="sts_symbol">
            <span class="symbol new"><?php echo __('New');?></span>
            <span class="symbol ip"><?php echo __('In Progress');?></span>
            <span class="symbol closed"><?php echo __('Closed');?></span>
            <span class="symbol resolve"><?php echo __('Resolved');?></span>
        </td>
    </tr> */ ?>
</table>
<script type="text/javascript">
$(function () {
var data = <?php echo $series; ?>;
    var cnt = 0;
    for(var prj in data){cnt ++;
        var project = data[prj];
       $('#'+cnt+'_prj').highcharts({
        chart: {
            type: 'spline',
            height:90
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
            enabled:false
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: [],
            labels: false,
            lineWidth: 1,
            minorGridLineWidth: 1,
            //lineColor: 'transparent',
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
                marker:{
                    symbol: "square"
                },
                data:[
                    {
                        y: typeof project.New != 'undefined'? parseInt(project.New): 0, 
                        name: 'New', 
                        marker:{
                            symbol: "url(img/new-chart.png)"
                        }
                    },
                    {
                        y: typeof project.InProgress != 'undefined'? parseInt(project.InProgress): 0,
                        name: 'In Progress',
                        marker: {
                            symbol: "url(img/inprogress-chart.png)"
                        }
                    },
                    {
                        y: typeof project.Closed != 'undefined'? project.Closed: 0,
                        name: 'Closed',
                        marker: {
                            symbol: "url(img/closed-chart.png)"
                        }
                    },
                    {
                        y: typeof project.Resolved != 'undefined'? project.Resolved: 0,
                        name: 'Resolved',
                        marker: {
                            symbol: "url(img/resolved-chart.png)"
                        }
                    }
                ]
                
            }]
        });
    }
});
</script>