<div class="d-flex align-item-center mbtm30">
	<div id="bck_cost_rprt" class="hide_buttn m_0"><button type="button" value="Back" name="Back" class="btn cmn_size btn_cmn_efect cmn_bg btn-info maximize_back_btn" onclick="hide_flscrn_div('cost_rprt')"><?php echo __("Back"); ?></button></div>
	<div class="ml-auto">
		<div id="exprt_cost_rprt" class="hide_buttn m_0">
			<button type="button" value="Export" name="Export" class="btn cmn_size btn_cmn_efect export_btn" onclick="export_costrprt()"><span class="material-icons">upgrade</span> <?php echo __("Export To CSV)"); ?></button>
		</div>
	</div>
</div>

<figure class="highcharts-figure" id="cost_rpt_highchart">
    <div id="container1"></div>
</figure>
<?php
  $type = ['costapproved'=>'Cost Approved', 'costtoclient'=>'Cost To Client', 'costtocompany'=>'Cost To Company'];
  $resultArr['costapproved'] = [];
  $resultArr['costtoclient'] = [];
  $resultArr['costtocompany'] = [];  
  $projectNameArr['projectname'] = [];  
  if(!empty($projects)){ #echo "<pre>";print_r($projects);exit;
                    
      foreach ($projects as $k => $val) {
          $chart_cost_approved = $val['cost_approved'];
          $chart_cost_to_client = $val['rates'];
          $chart_cost_to_company = $val['actual_cost'];
          array_push( $resultArr['costapproved'], $chart_cost_approved);
          array_push( $resultArr['costtoclient'], $chart_cost_to_client);
          array_push( $resultArr['costtocompany'], $chart_cost_to_company);
          array_push( $projectNameArr['projectname'], $val['name']);
      }
      $response['projectname'] = $projectNameArr;
      $j=0;
    foreach($type as $k => $v){
        $response['chartname'][$j]['name']=$v;
        $response['chartname'][$j]['data']=$resultArr[$k];
        $j++;
    }  
    // pr($response);exit;
    $chartdata =  json_encode($response,JSON_NUMERIC_CHECK);
}else{
?>
    <tr>
        <td colspan="7"><div class='mytask_txt'><?php echo __("Oops!No activity in last week! What's cooking"); ?> ?</div></td> 
    </tr>
<?php }  ?>
<!-- <table class="table table-hover custom-datatable m_0">
	<thead>
		<tr>
			<th class="width-30-per"><?php echo __("Project Name"); ?></th>
			<th class="width-25-per"><?php echo __("Client Name"); ?></th>
			<th class="width-15-per"><?php echo __("Cost approved"); ?></th>
			<th class="width-15-per"><?php echo __("Cost to client"); ?></th>
			<th class="width-15-per"><?php echo __("Cost to company"); ?></th> 
		 <?php /*   <th style="text-align: center">Profit</th> */ ?>
		  
		</tr>
	</thead>
</table>     -->
<div class="prjct-rag-tbl cst_rprt_tr h-scroll-container" style="display:none;">
    <table class="table table-hover custom-datatable">
        <thead>
            <tr>
                <th class="width-30-per"><?php echo __("Project Name"); ?></th>
                <th class="width-25-per"><?php echo __("Client Name"); ?></th>
                <th class="width-15-per"><?php echo __("Cost approved"); ?></th>
                <th class="width-15-per"><?php echo __("Cost to client"); ?></th>
                <th class="width-15-per"><?php echo __("Cost to company"); ?></th> 
                <!-- <th style="text-align: center">Profit</th>  -->
              
            </tr>
        </thead>
        <tbody>
            <?php 
                $limit = 8 ; $cnt=0;
                if(!empty($projects)){ #echo "<pre>";print_r($projects);exit;
                foreach($projects as $k => $val){ 
                        $cost_approved = empty($val['cost_approved']) ? $val['budget'] : $val['cost_approved'] != null ? $val['cost_approved'] : 0; 
                        $rate= isset($val['rates']) && !empty($val['rates']) ? $val['rates']."&nbsp;<small>".$val['currency']."</small>" : 0 ;
                        $actual_cost= isset($val['actual_cost']) && !empty($val['actual_cost']) ? $val['actual_cost']."&nbsp;<small>".$val['currency']."</small>" : 0 ;
                     //   $profit = (int)($val['rates'] - $val['actual_cost']);
                        $curncy = $cost_approved != "0.00" ? "<small>".$val['currency']."</small>" : "" ;
                      //  $proft_crncy = $profit != "0" ? "<small>".$val['currency']."</small>" : "" ;
                        $clnt_cmnpy_name = !empty($val['client_company_name'])? $val['client_company_name'] : 'None' ;
                     ?>
            <tr <?php if($cnt >= $limit){?> style="display:none;" <?php } ?> class="cst_rprt_tr">
                <td class="width-30-per"><?php echo $val['name'] ;?></td>
                <td class="width-25-per"><?php echo $clnt_cmnpy_name ;?></td>
                <td class="width-15-per" style="color:#9759e6"><?php echo $cost_approved."&nbsp".$curncy ; ?></td>
                <td class="width-15-per" style="color:#3da4ff"><?php  echo $rate ;?></td>
                <td class="width-15-per" style="color:#ff902f"><?php echo $actual_cost ?></td>
           <?php /*     <td style="text-align: center"><?php echo $profit."&nbsp".$proft_crncy ;?></td> */?>
                
            </tr>
            
            <?php $cnt++;
                 }
                }else{?>
            <tr>
                <td colspan="5"><div class='mytask_txt colr_red text-center font16'><?php echo __("Oops!No activity in last week! What's cooking"); ?> ?</div></td> 
            </tr>
                <?php } ?>
        </tbody>
    </table>
</div>


<script>
    function export_costrprt(){
        $.post(HTTP_ROOT +"Dashboard/dashboards/rag_cost_report?type=export",{}, function(res){
        location.href = HTTP_ROOT +"easycases/rag_cost_report?type=export" ;
        });
    }
    $(document).ready(function(){
        $('[rel=tooltip]').tipsy({gravity: 's', fade: true});
        chartForRagCostReport();
    });
  function chartForRagCostReport(){
     var cd = <?php echo  $chartdata ?>;
     var projects = cd.projectname.projectname;
     var chartdata = cd.chartname;
     Highcharts.chart('container1', {
        chart: {
            height:350,
            type: 'column'
        },
        title: {
            text: 'Project Cost Report'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: projects,
            crosshair: true
        },
        credits: {
    enabled: false
        },
        yAxis: {
            min: 100,
            title: {
                text: ''
            },
            scrollbar: {
                enabled: true,
                showFull: true
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
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
        series: chartdata
    });
}
</script>