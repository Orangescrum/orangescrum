<?php if ($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN) { ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.bootgrid.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>css/jquery.bootgrid.min.css" />

	<div class="proj_grids glide_div setting_wrapper task_listing resource_sec cmn_tbl_widspace" id="resource_utilization_div">
        <div class="fl tlog_top_cnt" style="display:none;" id="recource_utilization_log_section">
            <div class="spent-time">
                <div class="fl">
                    <h6 class="total use-time"><?php echo __('Estimated');?>:                     
                    <span id="ru_total_EstHrs"></span></h6>
                </div>              
                <div class="fl">
                    <h6 class="use-time"><?php echo __('Logged');?>:
                    <span id="ru_total_log"></span></h6>
                </div>
                <div class="fl">
                    <h6 class="use-time"><?php echo __('Billable');?>:
                    <span id="ru_billable_log"></span></h6>
                </div>
                <div class="fl">
                    <h6 class="use-time"><?php echo __('Non-Billable');?>:
                    <span id="ru_unbillable_log"></span></h6>
                </div>
                <div class="cb"></div>
            </div>
        </div>
		<div id="recource_utilization_export_btn" class="logmore-btn btn_tlog_top" style="display:none;">
			<a class="btn btn-sm btn_cmn_efect" onclick="resource_utilization_export_popup();" rel="tooltip" title="<?php echo __('Export To CSV File');?>">
				<i class="material-icons">&#xE8D5;</i>
			</a>
		</div>
		<div class="cb"></div>
		<?php // echo $this->element('analytics_header');?>
		<div class="m-cmn-flow cmn_timesheet_approver_layout approval_selection pr">
			<div class="d-flex select_add_time_approver">
				<div class="select_time_approver_dropdown">
					<div class="multiselect_formgroup">
						<div class="select_field_wrapper up_select_control size_35">
							<select name="" id="approver_list" class="select2 form-control" multiple>
							</select>
							<div class="select_field_placeholder " for="approver_list"><span><?php echo __('Select Approver');?></span></div>
						</div>
					</div>
				</div>
				<div>
					<button class="btn cmn_size btn_cmn_efect cmn_bg btn-info" id="btnApprover"><?php echo __("Add Approver");?></button>
				</div>
			</div>
		<div class="cb"></div>
		<div class="load-data-table">
			<table id="grid-timesheet-settings" class="table table-hover custom-datatable timesheet-settings mtop20 action-center-table" data-visible-in-selection="false">
				<thead>
					<tr>
						<!-- <th data-column-id="id" data-identifier="true" data-visible="true" data-order="asc"></th> -->
						<th class="width-25-per" data-column-id="name" data-order="asc"><?php echo __('Name');?></th>
						<th class="width-25-per" data-column-id="email" data-order="asc"><?php echo __('Email');?></th>
						<th class="width-20-per" data-column-id="pending_approval" data-visible="true" data-sortable="false"><?php echo __('Pending Approvals');?></th>
						<th class="width-15-per" data-column-id="status" data-visible="true" data-sortable="true"><?php echo __('Status');?></th>
						<th class="width-15-per" data-column-id="actions" data-formatter="actions" data-sortable="false"><?php echo __('Action');?></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    approverList();
    $("#approver_list").select2();
	var crnt_page = 0;
    var totEstofPage = totSpentofPage = 0;
    var url = HTTP_ROOT+'projects/ajax_timesheet_settings';
    var grid = $("#grid-timesheet-settings").bootgrid({
		ajax: true,
		post: function ()
		{
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		url: url,
        columnSelection:false,
        formatters: {
            "actions": function(column, row)
             {
                if(row.status == "Active"){
                    var btn_name = "<i class='material-icons'>&#xE15C;</i>";
                    var tooltip_txt = "rel='tooltip' title='Deactivate'";
                 }else{                    
										var btn_name = "<i class='material-icons'>add_circle</i>";
                    var tooltip_txt = "rel='tooltip' title='Activate'";
                 }
              /*  return "<button type=\"button\" id=\"aIstatus"+row.id+"\" class=\"btn btn-xs btn-default actions-edit\" data-row-id=\"" + row.id + "\" data-row-status=\"" + row.status + "\">"+btn_name+"</button>" + 
                    "<button type=\"button\" id=\"remove"+row.id+"\" class=\"btn btn-xs btn-default actions-delete\" data-row-id=\"" + row.id + "\">Delete</button>";
                */
                return "<a id=\"aIstatus"+row.id+"\" class=\"actions-edit\" style=\"cursor:pointer\" data-row-id=\"" + row.id + "\" data-row-status=\"" + row.status + "\" "+tooltip_txt+">"+btn_name+"</a>" + 
                    "<a id=\"remove"+row.id+"\" class=\"actions-delete\" style=\"cursor:pointer\" data-row-id=\"" + row.id + "\" rel='tooltip' title='Remove'><i class=\"material-icons\">&#xE872;</i></a>";
                
             }

    }
   }).on("loaded.rs.jquery.bootgrid", function(){
		$('[rel=tooltip]').tipsy({gravity:'s',fade:true});
		$("img.lazy").lazyload({
				placeholder: HTTP_ROOT + "img/lazy_loading.png"
		});
    grid.find(".actions-edit").on("click", function(e){
       
        var rowid = $(this).data("row-id");
        var status = $(this).data("row-status");
        if(status == "Active"){
            lstatus = "'Deactivate'";
        }else{
           lstatus = "'Activate'";
        }
        var cnfrm = confirm("Are you sure you want to "+ lstatus +" this Approver ?");
        if(cnfrm){
             $.ajax({
            type:'post',
            url: HTTP_ROOT+'projects/ajaxTimesheetActiveInactive',
            dataType:'json',
            data:{rowid:rowid,status:status},
            success:function(res){
               if(res.status){
                $('#grid-timesheet-settings').bootgrid('reload');
                showTopErrSucc('success',res.msg);
               } else {
                  $('#grid-timesheet-settings').bootgrid('reload');
                  showTopErrSucc('error',res.msg);
               }
            }
        });
        }
       

    }).end().find(".actions-delete").on("click", function(e){
        var rowid = $(this).data("row-id");
        var cnfrm = confirm("Are you sure you want to 'Delete' this Approver?");
        if(cnfrm){
            $.ajax({
            type:'post',
            url: HTTP_ROOT+'projects/ajaxTimesheetDlt',
            dataType:'json',
            data:{rowid:rowid},
            success:function(res){
               if(res.status){
                $('#approver_list').html("");
                approverList();
                $("#remove"+rowid).closest("tr").remove();
                  showTopErrSucc('success',res.msg);
               } else {
                  showTopErrSucc('error',res.msg);
               }
               
            }
        }); 
        }
    });
});
});

function approverList(){
    let url = HTTP_ROOT+'projects/ajaxApproverList';
    $.ajax({
        type:'get',
        url:url,
        dataType:'json',
        success:function(response){
            $('#approver_list').val(null).trigger('change');
            $.each(response, function(key, value) {
                $('#approver_list').append('<option value="' + value.cu.user_id + '">' + ucfirst(formatText(value.u.name)) + '</option>');
                });
                
        }
    });
}
$('#btnApprover').click(function(){
    
   var approver_ids =  $("#approver_list").val();
   if(approver_ids != null){
    let url = HTTP_ROOT+'projects/addApprover';
    $.ajax({
        type:'post',
        url:url,
        data:{approver_id:approver_ids},
        dataType:'json',
        success:function(res){
            if(res){ 
                $('#approver_list').html("");
                approverList();
                $('#grid-timesheet-settings').bootgrid('reload');
            }
        }
    });   
    }else{
        alert("No data selected.");
    }
  
});
</script>