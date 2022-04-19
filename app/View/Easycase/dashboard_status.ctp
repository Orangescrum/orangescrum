<?php $json_data = '';
$closed = 0;
 $legend = array(1 => "New", 2 => "In-Progress", 3 => "Closed", 4 => "Start", 5 => "Resolved", 6 => "Modified", 10 => "Modified");
 $color = array(1 => "#F19A91", 2 => "#8DC2F8", 3 => "#8AD6A3", 4 => "#A78AB6", 5 => "#F3C788", 6 => "#FFF363",10=>"#c2c2c2");
 #print json_encode($data);exit;
 if(isset($data)){
 }
 
/*if(is_array($status) && count($status)>0){
    if(isset($status[4])){
        $status[2]+=$status[4];
        unset($status[4]);
    }
    if(isset($status[6])){
        $status[2]+=$status[6];
        unset($status[6]);
    }
    if(isset($status[10])){
        $status[2]+=$status[10];        
    }
    unset($status[10]);
    
    foreach($json_status as $key=>$val){
        if($key == 3){
            $closed = $val;
        }
        #$json_data[]= array('name'=>$legend[$key],'y'=>$val,'color'=>$color[$key]);
        $json_data.= "{name:'".$legend[$key]."',y:".$val.",color:'".$color[$key]."'}, ";
    }
    #echo $json_data;exit;
 }*/ else{
     echo "<center><img src='".HTTP_ROOT."img/sample/dashboard/staus.png' alt='' style='max-width:100%;max-height:100%;'/></center>";
     exit;
 } 
 $json_data = trim($json_data, ', ');?>
<div id="project_status_pie"></div>
<script type="text/javascript">
    $(document).ready(function() {
        var hash = window.location.hash.substr(1);
        $('.clsd-tsks').html('<?php echo $status[3]."/".$total; ?>');
        $('.clsd-prnt-dv').show();
        $('#project_status_pie').highcharts({
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
                lineWidth: 0,
                minorGridLineWidth: 0,
                lineColor: 'transparent',
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
                gridLineWidth: 0
            },
            tooltip: {
                crosshairs: false,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [{
                    name: 'count',
                    marker:{
                        symbol: 'square'
                    },
                    data: <?php echo $data; ?>
            }]
        });
        $('.sts-lngds').show();
    });
</script>