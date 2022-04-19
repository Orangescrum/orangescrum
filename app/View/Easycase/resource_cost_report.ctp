<div class="d-flex align-item-center" id="zoomData">
	<div id="bck_prjtsht" class="hide_buttn m_0">
		<button type="button" value="Back" name="Back" class="btn cmn_size btn_cmn_efect cmn_bg btn-info maximize_back_btn backZoomdata" onclick=" zoomOutRemoveClass(); hide_flscrn_div('resource_cost_rprt');" ><?php echo __("Back"); ?></button>
	</div>
	<div class="ml-auto">
		<div id="exprt_prjtshet" class="hide_buttn m_0">
		<button type="button" value="Export" name="Export" class="btn cmn_size btn_cmn_efect export_btn" onclick="export_rsrccost()"><span class="material-icons">upgrade</span> <?php echo __("Export To CSV)"); ?></button>
		</div>
	</div>
</div>
<!-- <figure class="highcharts-figure" id="resource_cost_rpt_highchart">
    <div id="container2"></div>
</figure> -->
<!-- <div class="table-responsive prjct-rag-tbl resource_tr" style="display:none;" > -->
	<table class="table table-hover custom-datatable resource_cost_report_table m_0 table-fixed-layout">
        <thead>
            <tr>
                <th class="width-14-per"><?php echo __("Project Name"); ?></th>
                <th class="width-13-per"><?php echo __("Client Name"); ?></th>
                <th class="width-13-per"><?php echo __("Resource Name"); ?></th>
                <th class="width-10-per"><?php echo __("Billable hours"); ?></th>
                <th class="width-15-per"><?php echo __("Hourly Rate For Company"); ?></th>
                <th class="width-15-per"><?php echo __("Cost To Company"); ?></th>
                <th class="width-10-per"><?php echo __("Hourly Rate For Client"); ?></th>
                <th class="width-15-per"><?php echo __("Cost To Client"); ?></th>

            </tr>
        </thead>
	</table>
	<div class="prjct-rag-tbl resource_tr h-scroll-container">
    <table class="table table-hover custom-datatable resource_cost_report_table table-fixed-layout">
        <tbody>
            <?php
            $prjnm = '';
            $limit = 8;
            if (!empty($resource_cost_details)) {
                foreach ($resource_cost_details as $k => $val) {
                    $actual_cost = (isset($val['RoleRate']['actual_rate']) && !empty($val['RoleRate']['actual_rate'])) ? $val['RoleRate']['actual_rate'] . "&nbsp;<small>" . $val['InvoiceCustomer']['currency'] . "</small>" : 0;
                    $billing_cost = (isset($val['RoleRate']['billable_rate']) && !empty($val['RoleRate']['billable_rate'])) ? $val['RoleRate']['billable_rate'] . "&nbsp;<small>" . $val['InvoiceCustomer']['currency'] . "</small>" : 0 ;
                    $total_actual_rate = (($val['0']['hours'] / 3600) * $val['RoleRate']['actual_rate']) != 0 ? round(($val['0']['hours'] / 3600) * $val['RoleRate']['actual_rate'],2) . "&nbsp;<small>" . $val['InvoiceCustomer']['currency'] . "</small>" : 0 ;
                    $total_billing_rate = (int)(($val['0']['hours'] / 3600) * $val['RoleRate']['billable_rate']) != 0 ? round(($val['0']['hours'] / 3600) * $val['RoleRate']['billable_rate'],2) . "&nbsp;<small>" . $val['InvoiceCustomer']['currency'] . "</small>" : 0 ;
                    $clnt_cmnpy_name = !empty($val['InvoiceCustomer']['project_company_name']) ? $val['InvoiceCustomer']['project_company_name'] : 'None';
                    ?>
                    <tr <?php if ($k >= $limit) { ?> style="display:none;" <?php } ?> class="resource_tr">
                        <td class="width-14-per text-left"><span class="dynaic_elipse_data"><?php echo ucfirst($val['Project']['name']); ?></span></td>
                        <td class="width-13-per text-left"><span class="dynaic_elipse_data"><?php echo ucfirst($clnt_cmnpy_name); ?></span></td>
                        <td class="width-13-per text-left"><span class="dynaic_elipse_data"><?php echo ucfirst($val[0]['user_name']); //$prjnm != $val['Project']['name'] ? $val['Project']['name'] : '';   ?></span></td>
                        <td class="width-10-per text-left" style="color:#8e78f9"><?php echo $this->Format->format_time_hr_min($val['0']['hours']) ?></td>
                        <td class="width-15-per text-left blueviolet"><?php echo $actual_cost; ?></td>
                        <td class="width-15-per text-left cornflowerblue" ><?php echo $total_actual_rate; ?></td>
                        <td class="width-10-per text-left coral"><?php echo $billing_cost; ?></td>
                        <td class="width-15-per text-left greenyellow"><?php echo $total_billing_rate; ?></td>

                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8"><div class='mytask_txt colr_red text-center font16'><?php echo __("Oops! No Resource has logged time! What's happening"); ?>?</div></td> 
                </tr>
<?php } ?>


        </tbody>
    </table>
</div>
<script>
     
    function export_rsrccost() {
        
        var rsrc_prjflt = localStorage.getItem('PROJECTCOSTREP');
        if (rsrc_prjflt === null) {
            rsrc_prjflt = [];
        } else {
            rsrc_prjflt = JSON.parse(rsrc_prjflt).toString();
        }
        var rsrc_tmeflt = $("#sel_rsrc_time_typ").val();
        window.open(HTTP_ROOT + "easycases/resource_cost_report?type=export&project_id=" + rsrc_prjflt + "&time_flt=" + rsrc_tmeflt);
    }
    $(document).ready(function () {
        $('[rel=tooltip]').tipsy({gravity: 's', fade: true});
        // chartForResourceCostReport();
    });
function zoomOutRemoveClass(){
$("#zoomData").removeClass('mbtm30');
}

</script>