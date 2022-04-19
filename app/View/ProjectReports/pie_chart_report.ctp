<?php echo $this->HTML->script("reports");?>
<div class="all_report_dtlpage">
    <h2><?php echo __('Pie Chart Report');?></h2>
	<p class="detl_chart_page">
		<?php echo __('Pie chart of tasks for a project grouped by specific field as needed. Handy overview of your task spread over status, assignee, type etc.');?>
	</p>
    <div class="report_form">
            <div class="row">
                <div class="col-md-5 margin_top">
                    <label><?php echo __('Project name:');?></label>
                    <div id="" class="report_select_inp project_name">
                        <select class="select2 visibility-hidden" id="company_projects">
                            <option><?php echo __('Loading...');?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5 margin_top">
                    <label><?php echo __('Statistic Types:');?></label>
                    <div id="report_select_inp" class="report_select_inp period">
                        <select class="select2 visibility-hidden" id="filter_mode">
                            <option value="assignee" selected="selected"><?php echo __('Assignee');?></option>
                            <option value="task_type"><?php echo __('Task Type');?></option>
                            <option value="priority"><?php echo __('Priority');?></option>
                            <option value="status"><?php echo __('Status');?></option>
                            <option value="epic_link"><?php echo __('Epic Link');?></option>
                            <option value="task_group"><?php echo __('Task Group');?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="button"  value="<?php echo __('Submit');?>" class="btn btn_cmn_efect cmn_bg btn-info visibility-hidden" id="btn_filter"/>
                    <div class="report_loader"><img src="<?php echo HTTP_ROOT.'images/rolling.gif?v='.RELEASE;?>"></div>
                </div>
                <div class="clearfix"></div>
            </div>
    </div>
	<p class="small_report_txt"><?php echo __('This chart shows the number of tasks based on the');?> <span class="dyn_filter_rpt" style="font-weight:bold;"><?php echo __('Assignee');?></span> <?php echo __('field');?>.</p>
    <div class="report" id="chart_container">

    </div>
    <div class="report_tbl">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo __('Tasks');?></th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody id="ajax_content">
                <tr>
                    <td><?php echo __('Loading...');?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function(event){
	$('#btn_filter').on('click',function(){
		$('.dyn_filter_rpt').html($('#report_select_inp option:selected').text());
	});
    $('.select2').select2();
	$('.visibility-hidden').css('visibility','visible');
    $.material.init();
    pieReports.init();
});
</script>