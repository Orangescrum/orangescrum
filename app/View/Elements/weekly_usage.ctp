<div class="weekly_usage_topbar">
<div class="fl">
    <h2 class="cmn_h2"><?php echo ucfirst(CMP_SITE);?></h2>
</div>
<div class="fr">
    <span rel="tooltp" title="<?php echo __('Current Week');?>"><?php echo date("D, M d",  (strtotime($dateCurnt)-($days_diff*24*60*60)))."&nbsp;-&nbsp;".date("D, M d",strtotime($dateCurnt));?></span>
    <label><?php echo __('Last Week');?>: <?php echo date("D, M d",  (strtotime($last_week_date)))."&nbsp;-&nbsp;".date("D, M d",strtotime($prv_date)-(24*60*60));?></label>
</div>
<div class="cb"></div>
<h2 class="cmn_h2 top_statist"><?php echo __('Statistics');?> - <span><?php echo __('SO FAR THIS WEEK');?></span></h2>
</div>
<?php 
if($userlogin[0][0]['notlogged']==$userlogin[0][0]['tot']){
    $logedin_color = '#ED7C16';$loggedin_per=0;
}else{
    $loggedin_users = $userlogin[0][0]['tot']-$userlogin[0][0]['notlogged'];
    $loggedin_per =round(($loggedin_users/$userlogin[0][0]['tot'])*100);
    if($userlogin[0][0]['notlogged']<= ($userlogin[0][0]['tot']/2)){
        $logedin_color = '#5191BD';
    }else{
        $logedin_color = '#ED7C16';
    }
}?>
<div class="row static_sumary">
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo ($userlogin[0][0]["tot"]-$userlogin[0][0]['notlogged']);?> <span><?php echo __('Logged in User');?></span></h3>
            <?php if($progress_flag){?>
            <div>
                <div class="fl perc_cnt"><?php echo $loggedin_per; ?>%</div>
                <div class="fr total_cnt">of Total <?php echo $userlogin[0][0]["tot"]; ?></div>
                <div class="cb"></div>
            </div>
            <div class="progress">
              <div class="progress-bar color1" style="width: <?php echo $loggedin_per; ?>%"></div>
            </div>
            <div class="total_cnt"><?php echo __('Last Week to Date');?></div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo $total_task_cr_current_week; ?> <span><?php echo __('Tasks Created');?></span></h3>
            <div id="task_created"></div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo $total_task_upd_current_week;?> <span><?php echo __('Tasks Updated');?></span></h3>
            <?php if($progress_flag){?>
            <div id="task_update"></div>
            <?php } ?>
        </div>
    </div>
    <div class="cb"></div>
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo $curr_wk_tot_closed_tasks;?> <span><?php echo __('Tasks Closed');?></span></h3>
            <?php if($progress_flag){ ?>
            <div id="task_closed"></div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo $this->format->format_time_hr_min($curr_wk_tot_hr_spent) == '' ? 0:$this->format->format_time_hr_min($curr_wk_tot_hr_spent) ;?> <span><?php echo __('Spent');?></span></h3>
            <?php if($progress_flag){?>
            <div id="task_hours_spent"></div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="static_s_cnt">
            <h3><?php echo $curr_wk_tot_storage_usage;?> <?php echo __('MB');?> <span><?php echo __('Storage Used');?></span></h3>
            <?php if($progress_flag){ ?>
            <div id="task_storage_used"></div>
            <?php } ?>
        </div>
    </div>
    <div class="cb"></div>
</div>
<div>
    <h3><?php echo __('Task Status of the Week');?></h3>
</div>
<table class="table table-striped tsw-table">
    <thead>
        <tr>
            <th><?php echo __('Date');?></th>
            <th><?php echo __('Task Created');?></th>
            <th><?php echo __('Updates and Activities');?></th>
        </tr>
    </thead>
    <tbody>
        <?php 	
            foreach ($last7days as $key1=>$val1){
                $no_of_tasks=0;
                $no_of_tasks_upd=0;$total_hr_spent=0;
                foreach($caseAll AS $k=>$value){
                    if(strtotime($value[0]['created_date'])==strtotime($val1)){
                        if($value['Easycase']['istype']==1){
                            $no_of_tasks = $value[0]['cnt'];
                        }else{
                            $no_of_tasks_upd = $value[0]['cnt'];;
                        }
                        $total_hr_spent = isset($value[0]['cnt']['hrs'])?$value[0]['cnt']['hrs']:0;
                    }
                }
            ?>
        <tr>
            <td><?php echo date("D, M d",  strtotime($val1)); ?></td>
            <td><?php echo $no_of_tasks;?></td>
            <td><?php echo $no_of_tasks_upd;?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php	
$curr_wk_tot_closed_tasks = 0 ;$curr_wk_tot_storage_usage=0;
if($getProj){?>
<h3><?php echo __('Project Status of the Week');?></h3>
<div class="m-weekly-usage">
<table class="table table-striped tsw-table">
    <thead>
        <tr>
            <th><?php echo __('Project');?></th>
            <th><?php echo __('Closed/Total Tasks');?></th>
            <th><?php echo __('Hours');?></th>
            <th><?php echo __('Usage');?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($getProj AS $pkey=>$pval){
            $tot_cases = $pval[0]['totalcase']?$pval[0]['totalcase']:0;
            $tot_hrs = $pval[0]['totalhours']?$pval[0]['totalhours']:'0.0';
            //$tot_close_per = ($pval[0]['totalcase'] && $pval[0]['closedcase'])?(round((($pval[0]['closedcase']/$pval[0]['totalcase'])*100),2)):0;
            $tot_close = $pval[0]['closedcase']?$pval[0]['closedcase']:0;
            $curr_wk_tot_closed_tasks +=$tot_close;
            $tot_users = $pval[0]['totusers']?$pval[0]['totusers']:0;
            if($pval[0]['storage_used']){
                $tot_storage = number_format(($pval[0]['storage_used']/1024),2);
                $curr_wk_tot_storage_usage +=$tot_storage;
                if($tot_storage>=1024){
                    $tot_storage = number_format(($tot_storage/1024),2)." Gb";
                }else{
                    $tot_storage .=" Mb";
                }
            }else{
                $tot_storage = "0 Mb";
            }

            $tot_cases = $pval[0]['totalcase']?$pval[0]['totalcase']:0;
            ?>
        <tr>
            <td><?php echo $pval['Project']['name'];?></td>
			<td><?php echo '<b>'.$tot_close.'</b>/'.$tot_cases;?></td>
            <td><?php echo $this->format->format_time_hr_min($tot_hrs) == '' ? '0hrs': $this->format->format_time_hr_min($tot_hrs); ?></td>
            <td><?php echo $tot_storage;?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<?php }else{ ?>
<h2 class="cmn_h2"><?php echo __('No Project Status on last week');?></h2>
<?php } ?>
<div class="weekly_btm_sumry">
    <h2 class="cmn_h2"><?php echo __('Summary');?></h2>
    <ul>
        <li>
            <span><?php echo $userlogin[0][0]['notlogged'];?></span> <?php echo __('Out of');?> <span><?php echo $userlogin[0][0]['tot']; ?></span> <?php echo __('User has not logged in to the system since last week');?>.
        </li>
        <li>
            <span><?php echo $total_task_cr_current_week; ?></span> <?php echo __('tasks created and');?> <span><?php echo $total_task_upd_current_week;?></span> <?php echo __('updates and activities on last week');?>.
        </li>
        <li>
            <span><?php echo $curr_wk_tot_closed_tasks; ?></span> <?php echo __('closed out of');?> <span><?php echo $total_task_cr_current_week; ?></span> tasks, <span><?php echo $this->format->format_time_hr_min($curr_wk_tot_hr_spent) == '' ? '0hrs' : $this->format->format_time_hr_min($curr_wk_tot_hr_spent); ?></span> <?php echo __('spent and');?> <span><?php echo $curr_wk_tot_storage_usage; ?></span> <?php echo __('Mb storage used on all projects');?>.
        </li>
    </ul>
</div>

<script type="text/javascript">
function PrintDiv() {    
	var divToPrint = document.getElementById('divToPrint');
	var popupWin = window.open('', '_blank', 'width=800,height=600');
	popupWin.document.open();
	popupWin.document.write('<html><title><?php echo __('Orangescrum Weekly Usage Report');?> <?php echo date("D, M d",  (strtotime($dateCurnt)-($days_diff*24*60*60)))."&nbsp;-&nbsp;".date("D, M d",strtotime($dateCurnt));?> </title><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
	popupWin.document.close();
}
$(document).ready(function(){
	var project_idlists = '';
	var total_task_cr_current_week = <?php echo $total_task_cr_current_week;?>;
	var total_task_upd_current_week = <?php echo $total_task_upd_current_week;?>;
	var curr_wk_tot_closed_tasks = <?php echo $curr_wk_tot_closed_tasks;?>;
	var curr_wk_tot_hr_spent = <?php echo $curr_wk_tot_hr_spent;?>;
	var curr_wk_tot_storage_usage = <?php echo $curr_wk_tot_storage_usage;?>;
	<?php if($project_idlist){?>
		project_idlists = '<?php echo $project_idlist; ?>';
	<?php }?>
	$.post(HTTP_ROOT+'reports/ajax_statistics',{'project_idlists':project_idlists},function(res){
		// Hours spent calculation 
		var prv_wk_tot_hr_spent= res.prv_wk_tot_hr_spent;
		if(curr_wk_tot_hr_spent || prv_wk_tot_hr_spent ){
			if(prv_wk_tot_hr_spent>0){
				hstaskper = (((curr_wk_tot_hr_spent-prv_wk_tot_hr_spent)/prv_wk_tot_hr_spent)*100).toFixed(0);
				if(hstaskper>0){hstask_color ='#5191BD';hstask_text='Up';}else{hstask_color = '#ED7C16';hstask_text='Down';}
			}else{
				hstask_color ='#5191BD';hstask_text = 'Up';
				hstaskper = curr_wk_tot_hr_spent*100;
			}
		}else{
			hstask_text='';	hstask_color = '#696969';hstaskper =0;
		}
		//Hours spent data 
		var hspent = '<div><div class="fl perc_cnt">'+Math.abs(hstaskper)+'% </div><div class="fr total_cnt">'+hstask_text+' from '+format_time_hr_min(prv_wk_tot_hr_spent)+'</div><div class="cb"></div></div><div class="progress"><div class="progress-bar color5" style="width:'+Math.abs(hstaskper)+'%"></div></div><div class="total_cnt">Last Week to Date</div>';
		$('#task_hours_spent').show();
		$('#task_hours_spent').html(hspent);
		/*$('#hours_main').css({'border-top':'1px solid'+hstask_color});
		$('#hours_text').css({'color':hstask_color});*/
		// Storage Calculation
		var prev_wk_storage_usage=res.prev_wk_storage_usage;
		if(curr_wk_tot_storage_usage || prev_wk_storage_usage ){
			if(prev_wk_storage_usage>0){
				storageper = (((curr_wk_tot_storage_usage - prev_wk_storage_usage)/prev_wk_storage_usage)*100).toFixed(0);
				if(storageper>0){storage_color ='#5191BD';storage_text = 'Up';}else{storage_color = '#ED7C16';storage_text ='Down';}
			}else{
				storage_color ='#5191BD';storage_text= 'Up';storageper = curr_wk_tot_storage_usage;
			}
		}else{
			storage_text = '';	storage_color = '#696969';	storageper =0;
		}
		// Storage Data 
		var storageusage ='<div><div class="fl perc_cnt">'+Math.abs(storageper)+'% </div><div class="fr total_cnt">'+storage_text+' from '+prev_wk_storage_usage+' MB</div><div class="cb"></div></div><div class="progress"><div class="progress-bar color6" style="width:'+Math.abs(storageper)+'%"></div></div><div class="total_cnt">Last Week to Date</div>';
		$('#task_storage_used').show();
		$('#task_storage_used').html(storageusage);
		/*$('#storage_main').css({'border-top':'1px solid'+storage_color});
		$('#storage_text').css({'color':storage_color});*/
		//Task Closed
		var prev_wk_closed_tasks =res.prev_wk_closed_tasks;
		if(curr_wk_tot_closed_tasks || prev_wk_closed_tasks ){
			if(prev_wk_closed_tasks>0){
				ctaskper = (((curr_wk_tot_closed_tasks - prev_wk_closed_tasks)/prev_wk_closed_tasks)*100).toFixed(0);
				if(ctaskper>0){ctask_color ='#5191BD';ctask_text='Up';}else{ctask_color = '#ED7C16';ctask_text='Down';}
			}else{
				ctask_color ='#5191BD';ctask_text='Up';ctaskper = curr_wk_tot_closed_tasks*100;
			}
		}else{
			ctask_text='';ctask_color = '#696969';ctaskper =0;
		}
		var closedtasks ='<div><div class="fl perc_cnt">'+Math.abs(ctaskper)+'% </div><div class="fr total_cnt">'+ctask_text+' from '+prev_wk_closed_tasks+'</div><div class="cb"></div></div><div class="progress"><div class="progress-bar color4" style="width:'+Math.abs(ctaskper)+'%"></div></div><div class="total_cnt">Last Week to Date</div>';
		$('#task_closed').show();
		$('#task_closed').html(closedtasks);
		/*$('#tclosed_main').css({'border-top':'1px solid'+ctask_color});
		$('#tclosed_text').css({'color':ctask_color});*/
		//Task Updated 
		var total_task_upd_prv_week = res.total_task_upd_prv_week;
		if(total_task_upd_current_week || total_task_upd_prv_week ){
			if(total_task_upd_prv_week>0){
				taskupdper = (((total_task_upd_current_week-total_task_upd_prv_week)/total_task_upd_prv_week)*100).toFixed(0);
				if(taskupdper>0){task_upd_color ='#5191BD';task_upd_text='Up';}else{task_upd_color = '#ED7C16';task_upd_text='Down';}
			}else{
				task_upd_color ='#5191BD';task_upd_text='Up';taskupdper = total_task_upd_current_week*100;
			}
		}else{
			task_upd_text='';task_upd_color = '#696969';taskupdper =0;
		}
		var taskupdated ='<div><div class="fl perc_cnt">'+Math.abs(taskupdper)+'% </div><div class="fr total_cnt">'+task_upd_text+' from '+total_task_upd_prv_week+'</div><div class="cb"></div></div><div class="progress"><div class="progress-bar color3" style="width:'+Math.abs(taskupdper)+'%"></div></div><div class="total_cnt">Last Week to Date</div>';
        $('#task_update').show();
		$('#task_update').html(taskupdated);
		/*$('#tupdate_main').css({'border-top':'1px solid'+task_upd_color});
		$('#tupdate_text').css({'color':task_upd_color});*/
//	Task Created 
		var total_task_cr_prv_week= res.total_task_cr_prv_week;
		if(total_task_cr_current_week || total_task_cr_prv_week ){
			if(total_task_cr_prv_week>0){
				taskper = (((total_task_cr_current_week-total_task_cr_prv_week)/total_task_cr_prv_week)*100).toFixed(0);
				if(taskper>0){task_color ='#5191BD';task_text="Up";}else{task_color = '#ED7C16';task_text="Down";}
			}else{
				task_text="Up";task_color ='#5191BD';taskper = total_task_cr_current_week*100;
			}
		}else{
			task_text='';task_color = '#696969';taskper =0;
		}
        var taskcreated = '<div><div class="fl perc_cnt">'+Math.abs(taskper)+'% </div><div class="fr total_cnt">'+task_text+' from '+total_task_cr_prv_week+'</div><div class="cb"></div></div><div class="progress"><div class="progress-bar color2" style="width:'+Math.abs(taskper)+'%"></div></div><div class="total_cnt">Last Week to Date</div>'
		$('#task_created').show();
		$('#task_created').html(taskcreated);
		/*$('#tcreate_main').css({'border-top':'1px solid'+task_color});
		$('#tcreate_text').css({'color':task_color});*/
	},'json');
});
</script>