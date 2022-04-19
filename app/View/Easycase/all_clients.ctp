<div id="clients_piechart" class="client-chrt-prnt">
</div>
<script>
var piedata = <?php echo $piearr; ?>;
$(function(){
        $('#clients_piechart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
        	    formatter: function() {
                            return '<b>' + this.point.name + ': </b>'+this.point.count+'<br><b>'+ this.point.name +'</b>: '+ parseFloat((this.point.percentage).toPrecision(3)) +' %';
                    }
        	    //pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
            },
			credits: {
				enabled: false
			},
            exporting: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
						enabled: false,
						//distance: -60,
						//color: 'white',
						formatter: function() {
							var precsson = 3;
							if(this.point.percentage<1) precsson = 2;
							if(this.point.percentage>=10) precsson = 4;
							return this.point.percentage > 1 ? parseFloat((this.point.percentage).toPrecision(precsson)) +'% '+this.point.name+'</b>' : null;
						}
					},
                    showInLegend: true
                }
            },
            legend: {
                enabled: true,
                labelFormatter: function() {
                    //return '<a title="'+this.name+'">'+this.name.substr(0,8)+'</a>' + ' - ' + this.y + '';]
                    return this.name + ' - ' + this.count ;
                }
            },
            series: [{
                type: 'pie',
                name: 'Clients',
                data: eval(piedata)
            }]
        });
    });
</script>
