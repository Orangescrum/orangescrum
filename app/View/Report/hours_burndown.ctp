<div id="container-burndown" style="width:99%"></div>
<script>
$(function(){
var dt = <?php echo $dt_arr;?>;
var hr = <?php echo $hr_arr;?>;
var tikinterval = <?php echo $tinterval;?>; 
var namedata = <?php echo $actual_arr; ?>;
var max = <?php echo $estimated_hours; ?>;
var maxd = <?php echo $maxd; ?>;
//alert(maxd);return false;
if(max <200){
	var interval = 20; 
}else{
	var interval = 50;
}
$('#container-burndown').highcharts({
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
        lineWidth: 3
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
				text: 'Days'
			},
			type:'datetime',
			//max: maxd,
			//min: 0,
			showFirstLabel:true,
			showLastLabel:true,
			tickInterval:tikinterval,
			categories: eval(dt),
		},
		exporting:{
			enabled: false  
		},
    yAxis: {
      title: {
        text: 'Hours'
      },
			 type: 'linear',
			 max: max,
			 min: 0,
			 tickInterval:interval,
			 categories: eval(hr)
    },
    
    tooltip: {
      valueSuffix: ' hour(s)',
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
      name: '<?php echo __('Remaining Estimated Hrs');?>',
      color: 'rgba(255,0,0,0.25)',
      lineWidth: 2,      
      data: <?php echo ($ideal_arr);?>
    }, {
      name: '<?php echo __('Remaining Actual Hrs');?>',
      color: 'rgba(0,120,200,0.75)',
      //marker: {
      //  radius: 6
      //},
      data: <?php echo $actual_arr; ?>
    }]
  });
});
</script>