<?php echo $this->HTML->script("reports"); ?>
<div class="all_report_dtlpage">
    <h2><?php echo __('Average Age Report');?></h2>
	<p class="detl_chart_page"><?php echo __('Project wise average age of all open tasks at a glance to keep your backlog in control.');?></p>
    <div class="report_form">
        <div class="row">
            <div class="col-md-4 margin_top">
                <label><?php echo __('Project name:');?></label>
                <div id="" class="report_select_inp project_name">
                    <select class="select2 visibility-hidden" id="company_projects">
                        <option><?php echo __('Loading...');?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 margin_top">
                <label><?php echo __('Period:');?></label>
                <div id="" class="report_select_inp period">
                    <select class="select2 visibility-hidden" id="filter_mode">
                        <option value="daily" selected="selected"><?php echo __('Daily');?></option>
                        <option value="weekly"><?php echo __('Weekly');?></option>
                        <option value="monthly"><?php echo __('Monthly');?></option>
                        <option value="quarterly"><?php echo __('Quarterly');?></option>
                        <option value="yearly"><?php echo __('Yearly');?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 margin_top_15">
                <label><?php echo __('Days Previously:');?> <a href="javascript:void(0);" class="onboard_help_anchor rptdtl" title="<?php echo __('It is a range of days, Default is 7 days previous to Today.');?>" rel="tooltip" ><span class="help-icon"></span></a></label>
                <div id="" class="report_select_inp">
                    <div class="form-group">
                        <input type="text"  class="form-control visibility-hidden" id="filter_qty" value="7"/>
                    </div>					
                </div>				
            </div>
            <div class="col-md-2">
                <input type="button"  value="<?php echo __('Submit');?>" class="btn btn_cmn_efect cmn_bg btn-info visibility-hidden" id="btn_filter"/>
                <div class="report_loader"><img src="<?php echo HTTP_ROOT.'images/rolling.gif?v='.RELEASE;?>"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
	<p class="small_report_txt"><?php echo __('This chart shows the average number of days tasks were unresolved for on a given day over the past');?> <span class="dyn_filter_rpt" style="font-weight:bold;">7</span> <?php echo __('days');?>.</p>
    <div class="report_chart" id="chart_container">

    </div>
    <div class="report_tbl">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo __('Task Unresolved');?> <br /><span style="font-size:12px;">(<?php echo __('New & In-Progress');?>)</span></th>
                    <th><?php echo __('Total Age (Days)');?></th>
                    <th><?php echo __('Avg.Age (Days)');?></th>
                </tr>
            </thead>
            <tbody id="ajax_content">
                <tr>
                    <td><?php echo __('Loading...');?></td>
                    <td></td>
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
		$('.dyn_filter_rpt').html($('#filter_qty').val());
	});
    $('.select2').select2();
	$('.visibility-hidden').css('visibility','visible');
    $.material.init();
    avg_age_reports.init();
});
</script>